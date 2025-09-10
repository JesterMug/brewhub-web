<?php
$this->disableAutoLayout();
$imageUrl = 'https://dummyimage.com/600x700/dee2e6/6c757d.jpg';
if (!empty($product->product_images)) {
    $firstImage = $product->product_images[0]->image_file ?? null;
    if ($firstImage) {
        $imageUrl = $this->Url->image('products/' . $firstImage);
    }
}
?>
<?= $this->Html->css('styles') ?>
<?= $this->Html->css(['shop']) ?>
<?= $this->element('navigation') ?>
<header class="bg-dark py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">Shop in style</h1>
            <p class="lead fw-normal text-white-50 mb-0">With this shop hompeage template</p>
        </div>
    </div>
</header>

<div class="container my-5">
    <div class="row gx-4 gx-lg-5 align-items-center">
        <div class="col-md-6">
            <img class="card-img-top mb-5 mb-md-0" src="<?= h($imageUrl) ?>" alt="<?= h($product->name) ?>" />
        </div>
        <div class="col-md-6">
            <h1 class="display-5 fw-bolder"><?= h($product->name) ?></h1>
            <p class="lead"><?= h($product->description) ?></p>

            <?php if (!empty($product->product_variants)): ?>
                <div class="mb-3">
                    <label for="variantSelect">Choose variant:</label>
                    <select id="variantSelect" class="form-select">
                        <?php foreach ($product->product_variants as $variant): ?>
                            <option value="<?= h($variant->id) ?>">
                                <?= h($variant->size) ?> - $<?= number_format($variant->price,2) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            <?php endif; ?>

            <div class="d-flex">
                <input class="form-control text-center me-3" id="inputQuantity" type="number" value="1" style="max-width: 3rem" />
                <button class="btn btn-outline-dark flex-shrink-0" type="button">
                    <i class="bi-cart-fill me-1"></i>
                    Add to cart
                </button>
            </div>
        </div>
    </div>
</div>
