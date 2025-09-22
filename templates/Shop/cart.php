<?php

?>
<header>
    <div class="py-4">
    </div>
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">Shopping Cart</h1>
        </div>
    </div>
</header>
<div class="shop-cart container-fluid">
    <?= $this->Flash->render() ?>
    <div class="container py-1">
    <?php if (!empty($cartItems)): ?>
    <div class="row">
        <div class="col-xl-8">
            <?php foreach ($cartItems as $item):
                $variant = $item->product_variant ?? null;
                $product = $variant->product ?? null;
                $images = $product->product_images ?? [];
                $imgUrl = !empty($images) && !empty($images[0]->image_file)
                    ? $this->Url->image('products/' . $images[0]->image_file)
                    : 'https://www.bootdey.com/image/380x380/008B8B/000000';
                $name = $product->name ?? 'Product';
                $size = $variant->size ?? '';
                $price = (float)($variant->price ?? 0);
                $qty = (int)($item->quantity ?? 1);
                $lineTotal = $price * $qty;
            ?>
            <div class="card border shadow-none">
                <div class="card-body">

                    <div class="d-flex align-items-start border-bottom pb-3">
                        <div class="me-4">
                            <img src="<?= h($imgUrl) ?>" alt="<?= h($name) ?>" class="avatar-lg rounded">
                        </div>
                        <div class="flex-grow-1 align-self-center overflow-hidden">
                            <div>
                                <h5 class="text-truncate font-size-18">
                                    <a href="<?= $this->Url->build(['controller' => 'Shop', 'action' => 'view', $product->id ?? null]) ?>" class="text-white">
                                        <?= h($name) ?>
                                    </a>
                                </h5>
                                <?php if ($size !== ''): ?>
                                    <p class="mb-0 mt-1">Size : <span class="fw-medium"><?= h($size) ?></span></p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="flex-shrink-0 ms-2">
                            <ul class="list-inline mb-0 font-size-16">
                                <li class="list-inline-item">
                                    <?= $this->Form->create(null, ['url' => ['controller' => 'Shop', 'action' => 'removeFromCart'], 'class' => 'd-inline']) ?>
                                        <?php if (!empty($item->id)): ?>
                                            <?= $this->Form->hidden('cart_item_id', ['value' => (int)$item->id]) ?>
                                        <?php else: ?>
                                            <?= $this->Form->hidden('product_variant_id', ['value' => (int)($variant->id ?? 0)]) ?>
                                        <?php endif; ?>
                                        <button type="submit" class="btn btn-sm btn-link text-muted px-1" title="Remove">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    <?= $this->Form->end() ?>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mt-3">
                                    <p class="text-muted mb-2">Price</p>
                                    <h5 class="mb-0 mt-2">$<?= number_format($price, 2) ?></h5>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mt-3">
                                    <p class="text-muted mb-2">Quantity</p>
                                    <div class="d-inline-flex">
                                        <?= $this->Form->create(null, ['url' => ['controller' => 'Shop', 'action' => 'updateCartQuantity'], 'class' => 'd-inline']) ?>
                                            <?php if (!empty($item->id)): ?>
                                                <?= $this->Form->hidden('cart_item_id', ['value' => (int)$item->id]) ?>
                                            <?php else: ?>
                                                <?= $this->Form->hidden('product_variant_id', ['value' => (int)($variant->id ?? 0)]) ?>
                                            <?php endif; ?>
                                            <?= $this->Form->select('quantity', array_combine(range(1,6), range(1,6)), [
                                                'value' => $qty,
                                                'class' => 'form-select form-select-sm w-xl',
                                                'onchange' => 'this.form.submit()'
                                            ]) ?>
                                        <?= $this->Form->end() ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mt-3">
                                    <p class="text-muted mb-2">Total</p>
                                    <h5>$<?= number_format($lineTotal, 2) ?></h5>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <?php endforeach; ?>

            <div class="row my-4">
                <div class="col-sm-6">
                    <a href="<?= $this->Url->build(['controller' => 'Shop', 'action' => 'index']) ?>" class="btn btn-link text-muted">
                        <i class="mdi mdi-arrow-left me-1"></i> Continue Shopping </a>
                </div>
                <div class="col-sm-6">
                    <div class="text-sm-end mt-2 mt-sm-0">
                        <a href="#" id="checkoutBtn" class="btn btn-success">
                            <i class="mdi mdi-cart-outline me-1"></i> Checkout </a>
                    </div>
                </div>
            </div>
            <div id="checkoutMessage" class="alert bg-dark text-white mt-3" style="display:none;">
                <h2>Please call us directly on <?= $this->ContentBlock->text('phone') ?> to finalise your order:</h2>
                <a href="tel:+61<?= ltrim(preg_replace('/\s+/', '', $this->ContentBlock->text('phone')), '0') ?>" class="btn btn-primary">
                    Call Us
                </a>
                <p class="mt-3"><?= $this->ContentBlock->text('opening_hours') ?> <br><?= $this->ContentBlock->text('address') ?></p>
            </div>
            <script>
                document.getElementById("checkoutBtn").addEventListener("click", function(event) {
                    event.preventDefault(); // stop the default link action
                    document.getElementById("checkoutMessage").style.display = "block";
                });
            </script>
        </div>


    <?php else: ?>
    <div class="row">
        <div class="col-12">
            <div class="card border shadow-none">
                <div class="card-body">
                    <div class="text-center py-5">
                        <h3 class="mb-3">Your cart is empty</h3>
                        <p class="text-muted mb-4">Looks like you haven’t added anything yet.</p>
                        <a class="btn btn-primary" href="<?= $this->Url->build(['controller' => 'Shop', 'action' => 'index']) ?>">
                            <i class="mdi mdi-arrow-left me-1"></i> Start shopping
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php return; ?>

    <!-- end row -->
    <?php endif; ?>
</div>
</div>
