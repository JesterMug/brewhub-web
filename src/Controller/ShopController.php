<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Http\Exception\NotFoundException;
use Cake\Database\Exception\QueryException;
use Cake\Core\Configure;
use Cake\Routing\Router;

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
        $addresses = [];

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

            // Handle address selection submission
            if ($cart && $this->request->is('post') && $this->request->getData('set_address') !== null) {
                $addressId = (int)$this->request->getData('address_id');
                if ($addressId > 0) {
                    // Ensure address belongs to current user
                    $addressesTable = TableRegistry::getTableLocator()->get('Addresses');
                    $address = $addressesTable->find()
                        ->where(['Addresses.id' => $addressId, 'Addresses.user_id' => (int)$identity->id])
                        ->first();
                    if ($address) {
                        $cart->address_id = $addressId;
                        if ($cartsTable->save($cart)) {
                            $this->Flash->success('Address selected for this cart.');
                        } else {
                            $this->Flash->error('Could not update the cart address. Please try again.');
                        }
                    } else {
                        $this->Flash->error('Invalid address selection.');
                    }
                } else {
                    $cart->address_id = null;
                    $cartsTable->save($cart);
                }
            }

            if ($cart) {
                $cartItems = $cart->cart_items ?? [];
                foreach ($cartItems as $ci) {
                    $price = (float)($ci->product_variant->price ?? 0);
                    $qty = (int)($ci->quantity ?? 0);
                    $totals['subtotal'] += $price * $qty;
                }
            }

            // Load addresses for the logged-in user
            $addressesTable = TableRegistry::getTableLocator()->get('Addresses');
            $addresses = $addressesTable->find()
                ->where(['Addresses.user_id' => (int)$identity->id, 'Addresses.is_active' => true])
                ->orderAsc('Addresses.label')
                ->all()
                ->toList();
        } else {
            // Guest cart via session
            $session = $this->request->getSession();
            $guestCart = (array)$session->read('GuestCart');
            if (!empty($guestCart)) {
                $variantIds = array_keys($guestCart);
                $variantsTable = TableRegistry::getTableLocator()->get('ProductVariants');
                $variants = $variantsTable->find()
                    ->where(['ProductVariants.id IN' => $variantIds])
                    ->contain(['Products' => ['ProductImages']])
                    ->all()
                    ->indexBy('id')
                    ->toArray();

                foreach ($guestCart as $vid => $itemData) {
                    if (!isset($variants[$vid])) {
                        continue;
                    }
                    $item = (object) [
                        'product_variant' => $variants[$vid],
                        'quantity' => (int)$itemData['quantity'],
                        'is_preorder' => (bool)$itemData['is_preorder'],
                    ];
                    $cartItems[] = $item;
                }
            }

        }

        // Simple total calc (no business rules yet)
        $totals['total'] = $totals['subtotal'] - $totals['discount'] + $totals['shipping'] + $totals['tax'];

        $this->set(compact('cart', 'cartItems', 'totals', 'addresses'));
    }

    // Add to cart (handles guest carts via session and logged in user carts)
    public function addToCart()
    {
        $this->request->allowMethod(['post']);
        $variantId = (int)$this->request->getData('product_variant_id');
        $qty = (int)max(1, (int)$this->request->getData('quantity'));
        $isPreorder = (bool)$this->request->getData('is_preorder', false);

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

            if (!$isPreorder) {
                if ($newTotalQty > $variant->stock) {
                    $this->Flash->error(__('Could not add to cart. Only {0} items are available and you already have {1} in your cart.', $variant->stock, $currentQtyInCart));
                    return $this->redirect($this->referer() ?: ['action' => 'index']);
                }
            }

            if ($cartItem) {
                $cartItem->quantity = $newTotalQty;
                if ($isPreorder) {
                    $cartItem->is_preorder = true;
                }
            } else {
                $cartItem = $cartItemsTable->newEntity([
                    'cart_id' => $cart->id,
                    'product_variant_id' => $variantId,
                    'quantity' => $qty,
                    'is_preorder' => $isPreorder,
                ]);
            }

            if ($cartItemsTable->save($cartItem)) {
                $this->Flash->success($isPreorder ? 'Item pre-ordered and added to your cart.' : 'Item added to your cart.');
            } else {
                $this->Flash->error('Could not add the item to your cart. Please try again.');
            }
        } else {
            $session = $this->request->getSession();
            $guestCart = (array)$session->read('GuestCart');

            $currentItemData = $guestCart[$variantId] ?? ['quantity' => 0, 'is_preorder' => false];
            $newTotalQty = $currentItemData['quantity'] + $qty;

            if (!$isPreorder && !$currentItemData['is_preorder']) {
                if ($newTotalQty > $variant->stock) {
                    $this->Flash->error(__('Could not add to cart. Only {0} items are available and you already have {1} in your cart.', $variant->stock, $currentItemData['quantity']));
                    return $this->redirect($this->referer() ?: ['action' => 'index']);
                }
            }

            $guestCart[$variantId] = [
                'quantity' => $newTotalQty,
                'is_preorder' => $currentItemData['is_preorder'] || $isPreorder,
            ];
            $session->write('GuestCart', $guestCart);
            $this->Flash->success($isPreorder ? 'Item pre-ordered and added to your cart.' : 'Item added to your cart.');
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
        $qty = (int)max(1, (int)$this->request->getData('quantity'));
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
                if (!$cartItem->is_preorder) {
                    $variantsTable = $this->fetchTable('ProductVariants');
                    $variant = $variantsTable->get($cartItem->product_variant_id);

                    if ($qty > $variant->stock) {
                        $this->Flash->error(__('Could not update quantity. Only {0} items are in stock.', $variant->stock));
                        return $this->redirect(['action' => 'cart']);
                    }
                }

                $cartItem->quantity = $qty;

                try {
                    if ($cartItemsTable->save($cartItem)) {
                        $this->Flash->success('Cart updated.');
                    } else {
                        $this->Flash->error('Unable to update quantity. Please try again.');
                    }
                } catch (QueryException $e) {
                    if (str_contains($e->getMessage(), 'Not enough stock')) {
                        $variantsTable = $this->fetchTable('ProductVariants');
                        $latestVariant = $variantsTable->get($cartItem->product_variant_id);
                        $this->Flash->error(__('Could not update. Stock changed. Only {0} items are available.', $latestVariant->stock));
                    } else {
                        $this->Flash->error('A database error occurred. Please try again.');
                    }
                }
                return $this->redirect(['action' => 'cart']);

            }
        }

        // Guest cart update by variant ID
        elseif ($variantId > 0) {
            $session = $this->request->getSession();
            $guestCart = (array)$session->read('GuestCart');

            if (isset($guestCart[$variantId])) {
                $variantsTable = $this->fetchTable('ProductVariants');
                $variant = $variantsTable->get($variantId);

                if ($variant->stock > 0 && !$guestCart[$variantId]['is_preorder']) {
                    if ($qty > $variant->stock) {
                        $this->Flash->error(__('Could not update quantity. Only {0} items are in stock.', $variant->stock));
                        return $this->redirect(['action' => 'cart']);
                    }
                }
                $guestCart[$variantId]['quantity'] = $qty;
                $session->write('GuestCart', $guestCart);
                $this->Flash->success('Cart updated.');
            }
        } else {
            $this->Flash->error('Invalid update request.');
        }
        return $this->redirect(['action' => 'cart']);
    }

    // Create a Stripe Checkout Session and redirect customer
    public function checkout()
    {
        $this->request->allowMethod(['post']);

        $secretKey = (string)Configure::read('Stripe.secret_key');
        if (!$secretKey) {
            $this->Flash->error('Payment configuration missing.');
            return $this->redirect(['action' => 'cart']);
        }

        $identity = $this->request->getAttribute('identity');
        $cartItems = [];
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
                if ((int)($cart->address_id ?? 0) <= 0) {
                    $this->Flash->error('Please select a shipping address before checkout.');
                    return $this->redirect(['action' => 'cart']);
                }
            }
        } else {
            $session = $this->request->getSession();
            $guestCart = (array)$session->read('GuestCart');
            if (!empty($guestCart)) {
                $variantIds = array_keys($guestCart);
                $variantsTable = TableRegistry::getTableLocator()->get('ProductVariants');
                $variants = $variantsTable->find()
                    ->where(['ProductVariants.id IN' => $variantIds])
                    ->contain(['Products' => ['ProductImages']])
                    ->all()
                    ->indexBy('id')
                    ->toArray();

                foreach ($guestCart as $vid => $itemData) {
                    if (!isset($variants[$vid])) {
                        continue;
                    }
                    $item = (object) [
                        'product_variant' => $variants[$vid],
                        'quantity' => (int)$itemData['quantity'],
                        'is_preorder' => (bool)$itemData['is_preorder'],
                    ];
                    $cartItems[] = $item;
                }
            }
        }

        if (empty($cartItems)) {
            $this->Flash->warning('Your cart is empty.');
            return $this->redirect(['action' => 'cart']);
        }

        $lineItems = [];
        $currency = 'aud';
        foreach ($cartItems as $ci) {
            $variant = $ci->product_variant ?? null;
            if (!$variant) { continue; }
            $product = $variant->product ?? null;
            $name = $product->name ?? 'Item';
            $unitAmount = (int)round(((float)($variant->price ?? 0)) * 100);
            $qty = max(1, (int)($ci->quantity ?? 1));

            $lineItem = [
                'price_data' => [
                    'currency' => $currency,
                    'product_data' => [
                        'name' => $name,
                    ],
                    'unit_amount' => $unitAmount,
                ],
                'quantity' => $qty,
            ];
            $lineItems[] = $lineItem;
        }

        if (empty($lineItems)) {
            $this->Flash->error('Unable to prepare your cart for checkout.');
            return $this->redirect(['action' => 'cart']);
        }

        $successUrl = Router::url(['controller' => 'Shop', 'action' => 'success'], true) . '?session_id={CHECKOUT_SESSION_ID}';
        $cancelUrl = Router::url(['controller' => 'Shop', 'action' => 'cancel'], true);

        try {
            $stripe = new \Stripe\StripeClient($secretKey);

            $params = [
                'mode' => 'payment',
                'payment_method_types' => ['card'],
                'line_items' => $lineItems,
                'success_url' => $successUrl,
                'cancel_url' => $cancelUrl,
                'billing_address_collection' => 'auto',
                'automatic_tax' => ['enabled' => false],
            ];

            // Pass the authenticated user's email to Stripe so it pre-fills the checkout email
            if ($identity && !empty($identity->email)) {
                $params['customer_email'] = (string)$identity->email;
            }

            $session = $stripe->checkout->sessions->create($params);
        } catch (\Throwable $e) {
            $this->Flash->error('Payment service error: ' . $e->getMessage());
            return $this->redirect(['action' => 'cart']);
        }

        // Redirect to Stripe checkout
        return $this->redirect($session->url, 303);
    }

    public function success()
    {
        $this->viewBuilder()->setLayout('frontend');
        $sessionId = (string)$this->request->getQuery('session_id');
        if ($sessionId) {
            $this->set('sessionId', $sessionId);
        }

        $session = $this->request->getSession();

        // Prevent duplicate processing on manual refreshes
        if ($sessionId) {
            $processedKey = 'ProcessedSessions.' . $sessionId;
            if ($session->read($processedKey)) {
                // Already processed this session
                return;
            }
        }

        // Verify payment status with Stripe first
        $secretKey = (string)Configure::read('Stripe.secret_key');
        $isPaid = false;
        if ($sessionId && $secretKey) {
            try {
                $stripe = new \Stripe\StripeClient($secretKey);
                $checkoutSession = $stripe->checkout->sessions->retrieve($sessionId);
                $isPaid = ($checkoutSession && ($checkoutSession->payment_status === 'paid'));
            } catch (\Throwable $e) {
                // If we cannot verify, do not create orders to avoid phantom orders
                $isPaid = false;
            }
        }

        if (!$isPaid) {
            // For safety, do not attempt order creation without verified payment
            // Still clear guest cart so the UX matches Stripe success page
            $session->delete('GuestCart');
            return;
        }

        // Build items from the user's cart (DB) or guest cart (session)
        $identity = $this->request->getAttribute('identity');
        $cartItems = [];
        $userCart = null;
        if ($identity) {
            $cartsTable = TableRegistry::getTableLocator()->get('Carts');
            $userCart = $cartsTable->find()
                ->where([
                    'Carts.user_id' => (int)$identity->id,
                    'Carts.status' => 'active',
                ])
                ->contain([
                    'CartItems' => [
                        'ProductVariants'
                    ]
                ])
                ->orderDesc('Carts.id')
                ->first();
            if ($userCart) {
                $cartItems = $userCart->cart_items ?? [];
            }
        } else {
            // Guest cart (cannot be linked to a user order as Orders.user_id is required)
            $guestCart = (array)$session->read('GuestCart');
            if (!empty($guestCart)) {
                $variantIds = array_keys($guestCart);
                $variantsTable = TableRegistry::getTableLocator()->get('ProductVariants');
                $variants = $variantsTable->find()
                    ->where(['ProductVariants.id IN' => $variantIds])
                    ->all()
                    ->indexBy('id')
                    ->toArray();
                foreach ($guestCart as $vid => $itemData) {
                    if (!isset($variants[$vid])) { continue; }
                    $cartItems[] = (object)[
                        'product_variant' => $variants[$vid],
                        'quantity' => (int)($itemData['quantity'] ?? 1),
                        'is_preorder' => (bool)($itemData['is_preorder'] ?? false),
                    ];
                }
            }
        }

        if (empty($cartItems)) {
            // Nothing to convert into an order
            $session->delete('GuestCart');
            if ($sessionId) { $session->write('ProcessedSessions.' . $sessionId, true); }
            return;
        }

        // Only create orders for authenticated users (Orders.user_id is required)
        if (!$identity) {
            // Clear guest cart and stop (cannot create an order without a user)
            $session->delete('GuestCart');
            if ($sessionId) { $session->write('ProcessedSessions.' . $sessionId, true); }
            return;
        }

        $ordersTable = $this->fetchTable('Orders');
        $orderItemsTable = $this->fetchTable('OrderProductVariants');
        $invTxTable = $this->fetchTable('InventoryTransactions');

        $connection = $ordersTable->getConnection();
        $now = new \DateTimeImmutable('now');
        $createdBy = (string)($identity->email ?? ($identity->id ?? 'web'));
        $createdBy = substr($createdBy, 0, 50);

        $orderId = null;
        $connection->transactional(function () use ($ordersTable, $orderItemsTable, $invTxTable, $identity, $cartItems, $now, $createdBy, &$orderId, $userCart) {
            // Create order
            $order = $ordersTable->newEntity([
                'user_id' => (int)$identity->id,
                'address_id' => null,
                'order_date' => $now,
                'shipping_status' => 'pending',
            ]);
            $ordersTable->saveOrFail($order);
            $orderId = (int)$order->id;

            // Create order items and inventory transactions
            foreach ($cartItems as $ci) {
                $variant = $ci->product_variant ?? null;
                if (!$variant) { continue; }
                $qty = max(1, (int)($ci->quantity ?? 1));
                $isPre = (bool)($ci->is_preorder ?? false);

                $orderItem = $orderItemsTable->newEntity([
                    'order_id' => $orderId,
                    'product_variant_id' => (int)$variant->id,
                    'quantity' => $qty,
                    'is_preorder' => $isPre,
                ]);
                $orderItemsTable->saveOrFail($orderItem);

                // Inventory change only for in-stock (non-preorder) items
                if (!$isPre) {
                    $inv = $invTxTable->newEntity([
                        'product_variant_id' => (int)$variant->id,
                        'change_type' => 'purchase',
                        'quantity_change' => -$qty,
                        'note' => 'Order #' . $orderId,
                        'created_by' => $createdBy,
                        'date_created' => $now,
                    ]);
                    $invTxTable->saveOrFail($inv);
                }
            }

            // Mark the user's cart as ordered and clear it
            if ($userCart) {
                // If you want to keep history, you may keep items; here we clear items
                if (!empty($userCart->cart_items)) {
                    $cartItemsTable = TableRegistry::getTableLocator()->get('CartItems');
                    foreach ($userCart->cart_items as $item) {
                        $cartItemsTable->delete($item);
                    }
                }
                TableRegistry::getTableLocator()->get('Carts')->save($userCart);
            }
        });

        // Clear guest cart (if any) and mark processed
        $session->delete('GuestCart');
        if ($sessionId) { $session->write('ProcessedSessions.' . $sessionId, true); }

        // Optionally set order id for display
        if (!empty($orderId)) {
            $this->set('orderId', $orderId);
        }
    }

    public function cancel()
    {
        $this->viewBuilder()->setLayout('frontend');
        $this->Flash->warning('Checkout canceled. You can review your cart and try again.');
        return $this->redirect(['action' => 'cart']);
    }
}
