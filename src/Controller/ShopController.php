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
        $this->Authentication->addUnauthenticatedActions(['index', 'view', 'cart', 'addToCart', 'removeFromCart', 'updateCartQuantity']);
        $this->viewBuilder()->setLayout('frontend');
    }

    public function index()
    {
        $productsTable = $this->fetchTable('Products');

        $type = (string)$this->request->getQuery('type');
        if (!in_array($type, ['coffee', 'merch'], true)) {
            $type = 'coffee';
        }

        // Find products of the selected type
        $categorySubQuery = $productsTable->find();
        if ($type === 'coffee') {
            $categorySubQuery->innerJoinWith('ProductCoffee');
        } else {
            $categorySubQuery->innerJoinWith('ProductMerchandise');
        }

        // List of categories from the subset of products
        $categories = $productsTable->find('list', [
            'keyField' => 'category',
            'valueField' => 'category'
        ])
            ->distinct(['category'])
            ->where([
                'category IS NOT NULL',
                'category !=' => '',
                'Products.id IN' => $categorySubQuery->select(['Products.id'])
            ])
            ->toArray();

        $selectedCategory = $this->request->getQuery('category');

        $products = $productsTable->find('all', [
            'contain' => ['ProductImages' => function($q) {
                return $q->orderByAsc('ProductImages.id');
            }, 'ProductVariants']
        ]);

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
                ]
            ]);
        }

        if (!empty($selectedCategory)) {
            $products->where(['Products.category' => $selectedCategory]);
        }

        $paginatedProducts = $this->paginate($products);

        $this->set(compact('paginatedProducts', 'q', 'type', 'categories', 'selectedCategory'));

        $this->set('products', $paginatedProducts);
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

    // Add to cart (handles guest carts via session and logged in user carts)
    public function addToCart()
    {
        $this->request->allowMethod(['post']);
        $variantId = (int)$this->request->getData('product_variant_id');
        $qty = (int)max(1, (int)$this->request->getData('quantity'));

        if ($variantId <= 0) {
            $this->Flash->error('Invalid product selection.');
            return $this->redirect($this->referer() ?: ['action' => 'index']);
        }

        $variantsTable = $this->fetchTable('ProductVariants');
        $variant = $variantsTable->get($variantId);

        $identity = $this->request->getAttribute('identity');
        if ($identity) {
            $cartsTable = $this->fetchTable('Carts');
            $cartItemsTable = $this->fetchTable('CartItems');

            $cart = $cartsTable->findOrCreate(
                ['user_id' => $identity->id, 'status' => 'active'],
                function ($cart) use ($identity) {
                    $cart->user_id = $identity->id;
                    $cart->status = 'active';
                }
            );

            $cartItem = $cartItemsTable->find()
                ->where(['cart_id' => $cart->id, 'product_variant_id' => $variantId])
                ->first();

            $currentQtyInCart = $cartItem ? $cartItem->quantity : 0;
            $newTotalQty = $currentQtyInCart + $qty;

            if ($variant->stock == 0) {
                $this->Flash->error(__('Out of stock'));
                return $this->redirect($this->referer() ?: ['action' => 'index']);
            }
            else if ($newTotalQty > $variant->stock) {
                $this->Flash->error(__('Could not add to cart. Only {0} items are available and you already have {1} in your cart.', $variant->stock, $currentQtyInCart));
                return $this->redirect($this->referer() ?: ['action' => 'index']);
            }

            if ($cartItem) {
                $cartItem->quantity = $newTotalQty;
            } else {
                $cartItem = $cartItemsTable->newEntity([
                    'cart_id' => $cart->id,
                    'product_variant_id' => $variantId,
                    'quantity' => $newTotalQty,
                    'is_preorder' => false,
                ]);
            }

            if ($cartItemsTable->save($cartItem)) {
                $this->Flash->success('Item added to your cart.');
            } else {
                $this->Flash->error('Could not add the item to your cart. Please try again.');
            }
        } else {
            $session = $this->request->getSession();
            $guestCart = (array)$session->read('GuestCart');

            $currentQtyInCart = $guestCart[$variantId] ?? 0;
            $newTotalQty = $currentQtyInCart + $qty;

            if ($variant->stock == 0) {
                $this->Flash->error(__('Out of stock'));
                return $this->redirect($this->referer() ?: ['action' => 'index']);
            }
            else if ($newTotalQty > $variant->stock) {
                $this->Flash->error(__('Could not add to cart. Only {0} items are available and you already have {1} in your cart.', $variant->stock, $currentQtyInCart));
                return $this->redirect($this->referer() ?: ['action' => 'index']);
            }

            $guestCart[$variantId] = $newTotalQty;
            $session->write('GuestCart', $guestCart);
            $this->Flash->success('Item added to your cart.');
        }
        return $this->redirect(['action' => 'cart']);
    }

    // Remove from cart (handles guest session and authenticated DB cart)
    public function removeFromCart()
    {
        $this->request->allowMethod(['post']);

        $identity = $this->request->getAttribute('identity');
        $cartItemId = (int)$this->request->getData('cart_item_id');
        $variantId = (int)$this->request->getData('product_variant_id');

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

    // Update quantity (handles guest session and authenticated DB cart)
    public function updateCartQuantity()
    {
        $this->request->allowMethod(['post']);

        $qty = (int)$this->request->getData('quantity');
        if ($qty < 1) { $qty = 1; }
        if ($qty > 99) { $qty = 99; }

        $identity = $this->request->getAttribute('identity');
        $cartItemId = (int)$this->request->getData('cart_item_id');
        $variantId = (int)$this->request->getData('product_variant_id');

        // Authenticated user: update DB cart item if it belongs to the user
        if ($cartItemId > 0 && $identity) {
            $cartItemsTable = TableRegistry::getTableLocator()->get('CartItems');
            $cartItem = $cartItemsTable->find()
                ->where(['CartItems.id' => $cartItemId])
                ->contain(['Carts'])
                ->first();

            if ($cartItem && (int)$cartItem->cart->user_id === (int)$identity->id) {
                $variantsTable = $this->fetchTable('ProductVariants');
                $variant = $variantsTable->get($cartItem->product_variant_id);

                if ($variant->stock == 0) {
                    $this->Flash->error('Out of stock.');
                    return $this->redirect(['action' => 'cart']);
                }
                if ($qty > $variant->stock) {
                    $this->Flash->error(__('Could not update quantity. Only {0} items are in stock.', $variant->stock));
                    return $this->redirect(['action' => 'cart']);
                }
                $cartItem->quantity = $qty;
                if ($cartItemsTable->save($cartItem)) {
                    $this->Flash->success('Cart updated.');
                    return $this->redirect(['action' => 'cart']);
                }
                $this->Flash->error('Unable to update quantity. Please try again.');
                return $this->redirect(['action' => 'cart']);

            }
        }

        // Guest/session cart: update by variant ID
        if ($variantId > 0) {
            $variantsTable = $this->fetchTable('ProductVariants');
            $variant = $variantsTable->get($variantId);

            if ($qty > $variant->stock) {
                $this->Flash->error(__('Could not update quantity. Only {0} items are in stock.', $variant->stock));
                return $this->redirect(['action' => 'cart']);
            }
            $session = $this->request->getSession();
            $guestCart = (array)$session->read('GuestCart');
            $guestCart[$variantId] = $qty;
            $session->write('GuestCart', $guestCart);
            $this->Flash->success('Cart updated.');
            return $this->redirect(['action' => 'cart']);
        }

        $this->Flash->error('Invalid update request.');
        return $this->redirect(['action' => 'cart']);
    }
}
