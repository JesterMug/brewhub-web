<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Http\Exception\NotFoundException;

class ShopController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        // Allow unauthenticated access to shop listing, product view, cart, and cart mutations
        $this->Authentication->addUnauthenticatedActions(['index', 'view', 'cart', 'addToCart', 'removeFromCart']);
        $this->viewBuilder()->setLayout('frontend');
    }

    public function index()
    {
        $productsTable = TableRegistry::getTableLocator()->get('Products');
        $products = $productsTable->find('all', [
            'contain' => ['ProductImages' => function($q) {
                return $q->orderByAsc('ProductImages.id');
            }, 'ProductVariants']
        ]);

        // Segmented type filter (default to coffee)
        $type = (string)$this->request->getQuery('type');
        if (!in_array($type, ['coffee', 'merch'], true)) {
            $type = 'coffee';
        }
        if ($type === 'coffee') {
            $products->innerJoinWith('ProductCoffee');
        } else {
            $products->innerJoinWith('ProductMerchandise');
        }

        // Apply search filter if provided
        $q = trim((string)$this->request->getQuery('q'));
        if ($q !== '') {
            $products->where([
                'OR' => [
                    'Products.name LIKE' => "%$q%",
                    'Products.description LIKE' => "%$q%",
                    'Products.category LIKE' => "%$q%",
                ]
            ]);
        }

        $this->set(compact('products', 'q', 'type'));
    }

    // Product details
    public function view($id = null)
    {
        if (!$id) {
            throw new NotFoundException('Product ID missing.');
        }

        $productsTable = TableRegistry::getTableLocator()->get('Products');
        $product = $productsTable->get($id, [
            'contain' => ['ProductImages', 'ProductVariants'],
        ]);

        $this->set(compact('product'));
        $this->viewBuilder()->setLayout('frontend');
    }

    // Shopping Cart page
    public function cart()
    {
        $this->viewBuilder()->setLayout('frontend');

        $identity = $this->request->getAttribute('identity');
        $cart = null;
        $cartItems = [];
        $totals = [
            'subtotal' => 0.0,
            'discount' => 0.0,
            'shipping' => 0.0,
            'tax' => 0.0,
            'total' => 0.0,
        ];

        if ($identity) {
            $cartsTable = TableRegistry::getTableLocator()->get('Carts');
            $cart = $cartsTable->find()
                ->where([
                    'Carts.user_id' => (int)$identity->id,
                    'Carts.status' => 'active',
                ])
                ->contain([
                    'CartItems' => [
                        'ProductVariants' => [
                            'Products' => ['ProductImages']
                        ]
                    ]
                ])
                ->orderDesc('Carts.id')
                ->first();

            if ($cart) {
                $cartItems = $cart->cart_items ?? [];
                foreach ($cartItems as $ci) {
                    $price = (float)($ci->product_variant->price ?? 0);
                    $qty = (int)($ci->quantity ?? 0);
                    $totals['subtotal'] += $price * $qty;
                }
            }
        } else {
            // Guest cart via session
            $session = $this->request->getSession();
            $guestCart = (array)$session->read('GuestCart'); // [variantId => qty]
            if (!empty($guestCart)) {
                $variantIds = array_keys($guestCart);
                $variantsTable = TableRegistry::getTableLocator()->get('ProductVariants');
                $variants = $variantsTable->find()
                    ->where(['ProductVariants.id IN' => $variantIds])
                    ->contain(['Products' => ['ProductImages']])
                    ->all()
                    ->indexBy('id')
                    ->toArray();

                foreach ($guestCart as $vid => $qty) {
                    if (!isset($variants[$vid])) {
                        continue;
                    }
                    $variant = $variants[$vid];
                    $item = (object) [
                        'product_variant' => $variant,
                        'quantity' => (int)$qty,
                    ];
                    $cartItems[] = $item;
                    $price = (float)($variant->price ?? 0);
                    $totals['subtotal'] += $price * (int)$qty;
                }
            }
        }

        // Simple total calc (no business rules yet)
        $totals['total'] = $totals['subtotal'] - $totals['discount'] + $totals['shipping'] + $totals['tax'];

        $this->set(compact('cart', 'cartItems', 'totals'));
    }

    // Add to cart (handles guest carts via session)
    public function addToCart()
    {
        $this->request->allowMethod(['post']);
        $variantId = (int)$this->request->getData('product_variant_id');
        $qty = (int)max(1, (int)$this->request->getData('quantity'));

        if ($variantId <= 0) {
            $this->Flash->error('Invalid product selection.');
            return $this->redirect($this->referer() ?: ['action' => 'index']);
        }

        $identity = $this->request->getAttribute('identity');
        if ($identity) {
            // For now, store in session as well (DB requires address/user linkage to create a Cart)
            $session = $this->request->getSession();
            $guestCart = (array)$session->read('GuestCart');
            $guestCart[$variantId] = ($guestCart[$variantId] ?? 0) + $qty;
            $session->write('GuestCart', $guestCart);
        } else {
            // Guest: store in session
            $session = $this->request->getSession();
            $guestCart = (array)$session->read('GuestCart');
            $guestCart[$variantId] = ($guestCart[$variantId] ?? 0) + $qty;
            $session->write('GuestCart', $guestCart);
        }

        $this->Flash->success('Item added to your shopping list.');
        return $this->redirect(['action' => 'cart']);
    }

    // Remove from cart (handles guest session and authenticated DB cart)
    public function removeFromCart()
    {
        $this->request->allowMethod(['post']);

        $identity = $this->request->getAttribute('identity');
        $cartItemId = (int)$this->request->getData('cart_item_id');
        $variantId = (int)$this->request->getData('product_variant_id');

        // If a CartItem ID is provided and a user is authenticated, try DB deletion
        if ($cartItemId > 0 && $identity) {
            $cartItemsTable = TableRegistry::getTableLocator()->get('CartItems');
            $cartItem = $cartItemsTable->find()
                ->where(['CartItems.id' => $cartItemId])
                ->contain(['Carts'])
                ->first();

            if ($cartItem && (int)$cartItem->cart->user_id === (int)$identity->id) {
                if ($cartItemsTable->delete($cartItem)) {
                    $this->Flash->success('Item removed from your cart.');
                    return $this->redirect(['action' => 'cart']);
                }
                $this->Flash->error('Unable to remove that item. Please try again.');
                return $this->redirect(['action' => 'cart']);
            }
            // Fallback to session removal if DB context not valid
        }

        // Remove from session-based guest cart by variant ID
        if ($variantId > 0) {
            $session = $this->request->getSession();
            $guestCart = (array)$session->read('GuestCart');
            if (array_key_exists($variantId, $guestCart)) {
                unset($guestCart[$variantId]);
                $session->write('GuestCart', $guestCart);
                $this->Flash->success('Item removed from your cart.');
            } else {
                $this->Flash->warning('That item was not found in your cart.');
            }
            return $this->redirect(['action' => 'cart']);
        }

        $this->Flash->error('Invalid remove request.');
        return $this->redirect(['action' => 'cart']);
    }
}
