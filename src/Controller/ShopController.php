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
        // Allow unauthenticated access to shop listing, product view, cart, cart mutations, and checkout flow
        $this->Authentication->addUnauthenticatedActions(['index', 'view', 'cart', 'addToCart', 'removeFromCart', 'updateCartQuantity', 'review', 'checkout', 'preorderCheckout', 'success', 'cancel']);
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

        $this->set(compact('cart', 'cartItems', 'totals'));
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
                        $this->Flash->error('Unable to update quantity. Please try again later.');
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
    public function review()
    {
        $this->viewBuilder()->setLayout('frontend');
        $session = $this->request->getSession();
        $identity = $this->request->getAttribute('identity');

        // Build cart preview the same way as in cart()
        $cartItems = [];
        if ($identity) {
            $cartsTable = $this->fetchTable('Carts');
            $cart = $cartsTable->find()
                ->where(['Carts.user_id' => (int)$identity->id, 'Carts.status' => 'active'])
                ->contain([
                    'CartItems' => [
                        'ProductVariants' => [
                            'Products' => ['ProductImages']
                        ]
                    ]
                ])->orderByDesc('Carts.id')->first();
            if ($cart) { $cartItems = $cart->cart_items ?? []; }
        } else {
            $guestCart = (array)$session->read('GuestCart');
            if (!empty($guestCart)) {
                $variantIds = array_keys($guestCart);
                $variants = $this->fetchTable('ProductVariants')->find()
                    ->where(['ProductVariants.id IN' => $variantIds])
                    ->contain(['Products' => ['ProductImages']])
                    ->all()->indexBy('id')->toArray();
                foreach ($guestCart as $vid => $itemData) {
                    if (!isset($variants[$vid])) { continue; }
                    $cartItems[] = (object) [
                        'product_variant' => $variants[$vid],
                        'quantity' => (int)$itemData['quantity'],
                        'is_preorder' => (bool)$itemData['is_preorder'],
                    ];
                }
            }
        }
        if (empty($cartItems)) {
            $this->Flash->warning('Your cart is empty.');
            return $this->redirect(['action' => 'cart']);
        }

        $addresses = [];
        if ($identity) {
            $addresses = $this->fetchTable('Addresses')->find()
                ->where(['user_id' => (int)$identity->id, 'is_active' => true])
                ->orderByAsc('id')->all()->toArray();
        }

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $addressesTable = $this->fetchTable('Addresses');

            $selectedAddressId = (int)($data['address_id'] ?? 0);
            $createNew = (bool)($data['create_new'] ?? false);

            if ($identity && $selectedAddressId > 0 && !$createNew) {
                // ensure that the selected address belongs to the user
                $exists = $addressesTable->exists(['id' => $selectedAddressId, 'user_id' => (int)$identity->id]);
                if ($exists) {
                    $session->write('Checkout.address_id', $selectedAddressId);
                    return $this->redirect(['action' => 'checkout']);
                }
                $this->Flash->error('Please select a valid address.');
            }

            // Prepare address payload from form
            $addrPayload = [
                'label' => (string)($data['label'] ?? ''),
                'recipient_full_name' => (string)($data['recipient_full_name'] ?? ''),
                'recipient_phone' => (string)($data['recipient_phone'] ?? ''),
                'property_type' => (string)($data['property_type'] ?? ''),
                'street' => (string)($data['street'] ?? ''),
                'building' => (string)($data['building'] ?? ''),
                'city' => (string)($data['city'] ?? ''),
                'state' => (string)($data['state'] ?? ''),
                'postcode' => (string)($data['postcode'] ?? ''),
                'is_active' => true,
            ];

            // For logged-in users, link the address; for guests, leave user_id null
            if ($identity) {
                $addrPayload['user_id'] = (int)$identity->id;
            }

            // Some basic sanitation
            $addrPayload['postcode'] = preg_replace('/[^0-9]/', '', (string)$addrPayload['postcode']);

            $address = $addressesTable->newEntity($addrPayload);
            if ($addressesTable->save($address)) {
                $session->write('Checkout.address_id', (int)$address->id);
                return $this->redirect(['action' => 'checkout']);
            }

            $this->set('address', $address);
        }

        $this->set(compact('addresses', 'cartItems'));
    }

    public function checkout()
    {
        $secretKey = (string)Configure::read('Stripe.secret_key');
        if (!$secretKey) {
            $this->Flash->error('Payment configuration missing.');
            return $this->redirect(['action' => 'cart']);
        }

        $session = $this->request->getSession();
        $addressId = (int)$session->read('Checkout.address_id');
        if ($addressId <= 0) {
            $this->Flash->warning('Please provide a shipping address first.');
            return $this->redirect(['action' => 'review']);
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
                ->orderByDesc('Carts.id')
                ->first();

            if ($cart) {
                $cartItems = $cart->cart_items ?? [];
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
            if (!class_exists(\Stripe\StripeClient::class)) {
                throw new \RuntimeException('Stripe SDK is not installed.');
            }
            $stripe = new \Stripe\StripeClient($secretKey);

            $params = [
                'mode' => 'payment',
                'payment_method_types' => ['card'],
                'line_items' => $lineItems,
                'success_url' => $successUrl,
                'cancel_url' => $cancelUrl,
                'billing_address_collection' => 'auto',
                'automatic_tax' => ['enabled' => false],
                'customer_creation' => 'always',
                'metadata' => [
                    'address_id' => (string)$addressId,
                    'guest' => $identity ? '0' : '1',
                ],
            ];

            // Pass the authenticated user's email to Stripe so it pre-fills the checkout email
            if ($identity && !empty($identity->email)) {
                $params['customer_email'] = (string)$identity->email;
            }

            $session = $stripe->checkout->sessions->create($params);
        } catch (\Throwable $e) {
            $this->Flash->error('Payment service error. Please try again later.');
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
                if (!class_exists(\Stripe\StripeClient::class)) {
                    throw new \RuntimeException('Stripe SDK is not installed.');
                }
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

        // If cart is empty (e.g., direct pre-order checkout bypassed cart), try reconstructing from Stripe metadata
        if (empty($cartItems) && isset($checkoutSession) && !empty($checkoutSession)) {
            $metaArr = [];
            $meta = $checkoutSession->metadata ?? null;
            if ($meta instanceof \Stripe\StripeObject) {
                $metaArr = $meta->toArray();
            } elseif (is_array($meta)) {
                $metaArr = $meta;
            }
            $isPreMeta = (string)($metaArr['preorder'] ?? '') === '1';
            $variantIdMeta = isset($metaArr['variant_id']) ? (int)$metaArr['variant_id'] : 0;
            $qtyMeta = isset($metaArr['quantity']) ? (int)$metaArr['quantity'] : 0;
            if ($isPreMeta && $variantIdMeta > 0 && $qtyMeta > 0) {
                $variantsTable = TableRegistry::getTableLocator()->get('ProductVariants');
                try {
                    $variant = $variantsTable->get($variantIdMeta);
                    $cartItems[] = (object) [
                        'product_variant' => $variant,
                        'quantity' => max(1, $qtyMeta),
                        'is_preorder' => true,
                    ];
                } catch (\Throwable $e) {
                    // ignore if cannot load variant
                }
            }
        }

        if (empty($cartItems)) {
            // Nothing to convert into an order
            $session->delete('GuestCart');
            if ($sessionId) { $session->write('ProcessedSessions.' . $sessionId, true); }
            return;
        }

        // Pull address selected/created during review
        $addressId = (int)$session->read('Checkout.address_id');
        if ($addressId <= 0 && isset($checkoutSession)) {
            $meta = $checkoutSession->metadata ?? null;
            if ($meta instanceof \Stripe\StripeObject) { $meta = $meta->toArray(); }
            if (is_array($meta) && !empty($meta['address_id'])) {
                $addressId = (int)$meta['address_id'];
            }
        }

        $ordersTable = $this->fetchTable('Orders');
        $orderItemsTable = $this->fetchTable('OrderProductVariants');
        $invTxTable = $this->fetchTable('InventoryTransactions');

        $connection = $ordersTable->getConnection();
        $now = new \DateTimeImmutable('now');
        $createdBy = $identity ? (string)($identity->email ?? ($identity->id ?? 'web')) : 'guest';
        $createdBy = substr($createdBy, 0, 50);

        $orderId = null;
        $connection->transactional(function () use ($ordersTable, $orderItemsTable, $invTxTable, $identity, $cartItems, $now, $createdBy, &$orderId, $userCart, $addressId) {
            // Create order
            $order = $ordersTable->newEntity([
                'user_id' => $identity ? (int)$identity->id : null,
                'address_id' => $addressId ?: null,
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
        $session->delete('Checkout.address_id');
        if ($sessionId) { $session->write('ProcessedSessions.' . $sessionId, true); }

        // Optionally set order id for display
        if (!empty($orderId)) {
            $this->set('orderId', $orderId);
        }

        // Send order confrmation email using email from Stripe
        try {
            $recipientEmail = null;
            if (isset($checkoutSession) && $checkoutSession) {
                // Prefer customer_details.email when available
                $recipientEmail = $checkoutSession->customer_details->email
                    ?? $checkoutSession->customer_email
                    ?? null;
            }
            if (!$recipientEmail && $identity && !empty($identity->email)) {
                $recipientEmail = (string)$identity->email;
            }

            if ($recipientEmail && !empty($orderId)) {
                $order = $ordersTable->get($orderId, contain: [
                    'OrderProductVariants' => ['ProductVariants' => ['Products']]
                ]);

                $items = [];
                $subtotal = 0.0;
                foreach ($order->order_product_variants as $opv) {
                    $variant = $opv->product_variant ?? null;
                    $product = $variant ? ($variant->product ?? null) : null;
                    $name = $product ? (string)$product->name : 'Item';
                    $variantLabel = null;
                    if ($variant) {
                        $sizeValue = $variant->size_value ?? null;
                        $sizeUnit = $variant->size_unit ?? null;
                        $variantLabel = ($sizeValue && $sizeUnit) ? ($sizeValue . ' ' . $sizeUnit) : null;
                    }
                    $qty = (int)$opv->quantity;
                    $price = (float)($variant->price ?? 0);
                    $lineTotal = $price * $qty;
                    $subtotal += $lineTotal;

                    $items[] = [
                        'name' => $name,
                        'variant' => $variantLabel,
                        'qty' => $qty,
                        'price' => $price,
                        'line_total' => $lineTotal,
                        'is_preorder' => (bool)$opv->is_preorder,
                    ];
                }

                // Extract shipping from Stripe session, otherwise fall back to customer saved Address
                $shipping = null;
                if (isset($checkoutSession) && $checkoutSession) {
                    $shippingDetails = $checkoutSession->shipping_details ?? null;
                    if ($shippingDetails && isset($shippingDetails->address)) {
                        $addr = $shippingDetails->address;
                        $shipping = [
                            'name' => $shippingDetails->name ?? null,
                            'line1' => $addr->line1 ?? null,
                            'line2' => $addr->line2 ?? null,
                            'city' => $addr->city ?? null,
                            'state' => $addr->state ?? null,
                            'postal_code' => $addr->postal_code ?? null,
                            'country' => $addr->country ?? null,
                        ];
                    }
                }

                //use the Address selected during checkout if Stripe didn't return shipping details
                if (!$shipping) {
                    try {
                        $addrId = (int)($addressId ?? 0);
                        if ($addrId > 0) {
                            $addressesTable = $this->fetchTable('Addresses');
                            $addr = $addressesTable->get($addrId);
                            $shipping = [
                                'name' => (string)($addr->recipient_full_name ?? ''),
                                'line1' => (string)($addr->street ?? ''),
                                'line2' => (string)($addr->building ?? ''),
                                'city' => (string)($addr->city ?? ''),
                                'state' => (string)($addr->state ?? ''),
                                'postal_code' => (string)($addr->postcode ?? ''),
                                'country' => null,
                            ];
                        }
                    } catch (\Throwable $ee) {
                        // ignore fallback failure
                    }
                }

                // Send email through the OrderMailer
                /** @var \App\Mailer\OrderMailer $mailer */
                $mailer = new \App\Mailer\OrderMailer('default');
                $mailer->sendOrderConfirmation($recipientEmail, [
                    'order' => [
                        'id' => $order->id,
                        'order_date' => $order->order_date?->format('M j, Y g:i A') ?? ''
                    ],
                    'items' => $items,
                    'subtotal' => $subtotal,
                    'total' => $subtotal,
                    'shipping' => $shipping,
                ]);
            }
        } catch (\Throwable $e) {

        }
    }

    public function cancel()
    {
        $this->viewBuilder()->setLayout('frontend');
        $this->Flash->warning('Checkout canceled. You can review your cart and try again.');
        return $this->redirect(['action' => 'cart']);
    }

    // Direct checkout for a single pre-order item (bypass cart)
    public function preorderCheckout()
    {
        $this->request->allowMethod(['post']);

        $variantId = (int)$this->request->getData('product_variant_id');
        $qty = (int)max(1, (int)$this->request->getData('quantity'));
        if ($variantId <= 0) {
            $this->Flash->error('Invalid product selection.');
            return $this->redirect($this->referer() ?: ['action' => 'index']);
        }

        $secretKey = (string)Configure::read('Stripe.secret_key');
        if (!$secretKey) {
            $this->Flash->error('Payment configuration missing.');
            return $this->redirect($this->referer() ?: ['action' => 'view']);
        }

        $variantsTable = $this->fetchTable('ProductVariants');
        $variant = $variantsTable->find()
            ->where(['ProductVariants.id' => $variantId])
            ->contain(['Products'])
            ->first();
        if (!$variant) {
            $this->Flash->error('Selected item is unavailable.');
            return $this->redirect($this->referer() ?: ['action' => 'index']);
        }

        $currency = 'aud';
        $name = $variant->product->name ?? 'Item';
        $unitAmount = (int)round(((float)($variant->price ?? 0)) * 100);
        $qty = max(1, $qty);

        $lineItems = [[
            'price_data' => [
                'currency' => $currency,
                'product_data' => [
                    'name' => $name,
                ],
                'unit_amount' => $unitAmount,
            ],
            'quantity' => $qty,
        ]];

        $successUrl = Router::url(['controller' => 'Shop', 'action' => 'success'], true) . '?session_id={CHECKOUT_SESSION_ID}';
        $cancelUrl = Router::url(['controller' => 'Shop', 'action' => 'cancel'], true);

        $identity = $this->request->getAttribute('identity');

        try {
            if (!class_exists(\Stripe\StripeClient::class)) {
                throw new \RuntimeException('Stripe SDK is not installed.');
            }
            $stripe = new \Stripe\StripeClient($secretKey);

            $params = [
                'mode' => 'payment',
                'payment_method_types' => ['card'],
                'line_items' => $lineItems,
                'success_url' => $successUrl,
                'cancel_url' => $cancelUrl,
                'billing_address_collection' => 'auto',
                'automatic_tax' => ['enabled' => false],
                'customer_creation' => 'always',
                'shipping_address_collection' => [
                    'allowed_countries' => ['AU']
                ],
                'phone_number_collection' => [
                    'enabled' => true
                ],
                'metadata' => [
                    'preorder' => '1',
                    'variant_id' => (string)$variantId,
                    'quantity' => (string)$qty,
                ],
            ];

            if ($identity && !empty($identity->email)) {
                $params['customer_email'] = (string)$identity->email;
            }

            $session = $stripe->checkout->sessions->create($params);
        } catch (\Throwable $e) {
            $this->Flash->error('Payment service error. Please try again later.');
            return $this->redirect($this->referer() ?: ['action' => 'index']);
        }

        return $this->redirect($session->url, 303);
    }
}
