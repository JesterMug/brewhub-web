<?php
?>
<header class=" py-5">
</header>
<div class="container my-5">
    <div class="row gx-4 gx-lg-5 align-items-center">
        <div class="col-md-6">
            <?php
            $images = [];
            if (!empty($product->product_images)) {
                foreach ($product->product_images as $pi) {
                    if (!empty($pi->image_file)) {
                        $images[] = $this->Url->image('products/' . $pi->image_file);
                    }
                }
            }
            if (count($images) > 1):
            ?>
                <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <?php foreach ($images as $idx => $_): ?>
                            <button type="button" data-bs-target="#productCarousel" data-bs-slide-to="<?= (int)$idx ?>" class="<?= $idx === 0 ? 'active' : '' ?>" aria-current="<?= $idx === 0 ? 'true' : 'false' ?>" aria-label="Slide <?= (int)($idx+1) ?>"></button>
                        <?php endforeach; ?>
                    </div>
                    <div class="carousel-inner">
                        <?php foreach ($images as $idx => $url): ?>
                            <div class="carousel-item <?= $idx === 0 ? 'active' : '' ?>">
                                <img src="<?= h($url) ?>" class="d-block w-100" alt="<?= h($product->name) ?> image <?= (int)($idx+1) ?>">
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            <?php else: ?>
                <?php
                $single = $images[0] ?? 'https://dummyimage.com/600x700/dee2e6/6c757d.jpg';
                ?>
                <img class="card-img-top mb-5 mb-md-0" src="<?= h($single) ?>" alt="<?= h($product->name) ?>" />
            <?php endif; ?>
        </div>
        <div class="col-md-6">
            <h1 class="display-5 fw-bolder"><?= h($product->name) ?></h1>

            <?php if (!empty($product->product_variants)): ?>
                <div class="mb-3">
                    <label for="variantSelect">Selection</label>
                    <select id="variantSelect" class="form-select">
                        <?php foreach ($product->product_variants as $variant): ?>
                            <option value="<?= h($variant->id) ?>">
                                <?= h($variant->size) ?> - $<?= number_format($variant->price,2) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            <?php endif; ?>

            <p class="lead"><?= h($product->description) ?></p>

            <div class="d-flex">
                <?= $this->Form->create(null, ['url' => ['controller' => 'Shop', 'action' => 'addToCart'], 'class' => 'd-flex align-items-center']) ?>
                    <input class="form-control text-center me-3" name="quantity" id="inputQuantity" type="number" min="1" value="1" style="max-width: 4rem" />
                    <?php
                        // Default to first variant if available
                        $firstVariantId = !empty($product->product_variants) ? ($product->product_variants[0]->id ?? null) : null;
                    ?>
                    <input type="hidden" name="product_variant_id" id="hiddenVariantId" value="<?= h($firstVariantId) ?>" />
                    <button class="btn btn-outline-dark flex-shrink-0" type="submit">
                        <i class="bi-cart-fill me-1"></i>
                        Add to Shopping List
                    </button>
                <?= $this->Form->end() ?>
            </div>

            <script>
                (function(){
                    var select = document.getElementById('variantSelect');
                    var hidden = document.getElementById('hiddenVariantId');
                    if (select && hidden) {
                        // Initialize hidden field in case default select differs
                        hidden.value = select.value || hidden.value;
                        select.addEventListener('change', function(){
                            hidden.value = this.value;
                        });
                    }
                })();
            </script>
        </div>
    </div>
</div>
