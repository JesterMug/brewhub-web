<?php

?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/5.3.45/css/materialdesignicons.css" integrity="sha256-NAxhqDvtY0l4xn+YVa6WjAcmd94NNfttjNsDmNatFVc=" crossorigin="anonymous" />
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

<div class="shop-cart container-fluid">
    <header class=" py-5">
    </header>
    <div class="container">
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
                                            <i class="mdi mdi-trash-can-outline"></i>
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
                            <div class="col-md-5">
                                <div class="mt-3">
                                    <p class="text-muted mb-2">Quantity</p>
                                    <div class="d-inline-flex">
                                        <?= $this->Form->create(null, ['url' => ['controller' => 'Shop', 'action' => 'updateCartQuantity'], 'class' => 'd-inline']) ?>
                                            <?php if (!empty($item->id)): ?>
                                                <?= $this->Form->hidden('cart_item_id', ['value' => (int)$item->id]) ?>
                                            <?php else: ?>
                                                <?= $this->Form->hidden('product_variant_id', ['value' => (int)($variant->id ?? 0)]) ?>
                                            <?php endif; ?>
                                            <?= $this->Form->select('quantity', array_combine(range(1,8), range(1,8)), [
                                                'value' => $qty,
                                                'class' => 'form-select form-select-sm w-xl',
                                                'onchange' => 'this.form.submit()'
                                            ]) ?>
                                        <?= $this->Form->end() ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
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
                        <a href="#" class="btn btn-success">
                            <i class="mdi mdi-cart-outline me-1"></i> Checkout </a>
                    </div>
                </div>
            </div>
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
