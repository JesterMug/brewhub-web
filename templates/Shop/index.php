<?php
$this->disableAutoLayout();
?>
<?= $this->Html->css('styles') ?>
<?= $this->element('navigation') ?>

<header class="bg-dark py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">Shop</h1>
            <p class="lead fw-normal text-white-50 mb-0">Call our number to place your order: 0450764522</p>
        </div>
    </div>
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />

</header>
<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap mb-2">
                <div class="btn-group" role="group" aria-label="Product type">
                    <a class="btn btn-outline-primary <?= ($type ?? 'coffee') === 'coffee' ? 'active' : '' ?>" href="<?= $this->Url->build(['controller' => 'Shop', 'action' => 'index', '?' => ['type' => 'coffee', 'q' => $this->request->getQuery('q')]]) ?>">Coffee</a>
                    <a class="btn btn-outline-primary <?= ($type ?? 'coffee') === 'merch' ? 'active' : '' ?>" href="<?= $this->Url->build(['controller' => 'Shop', 'action' => 'index', '?' => ['type' => 'merch', 'q' => $this->request->getQuery('q')]]) ?>">Merchandise</a>
                </div>
            </div>

            <?= $this->Form->create(null, ['type' => 'get', 'valueSources' => ['query'], 'templates' => ['inputContainer' => '{{content}}']]) ?>
            <?= $this->Form->hidden('type', ['value' => $type ?? 'coffee']) ?>
            <div class="input-group">
                <?= $this->Form->control('q', [
                    'label' => false,
                    'placeholder' => 'Search products',
                    'class' => 'form-control',
                ]) ?>
                <button class="btn btn-outline-secondary" type="submit">Search</button>
                <?php if (!empty($this->request->getQuery('q'))): ?>
                    <a class="btn btn-outline-danger" href="<?= $this->Url->build(['controller' => 'Shop', 'action' => 'index', '?' => ['type' => $type ?? 'coffee']]) ?>">Clear</a>
                <?php endif; ?>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>

    <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
                <?php
                // first product image or fallback
                $imageUrl = 'https://dummyimage.com/450x300/dee2e6/6c757d.jpg';
                if (!empty($product->product_images)) {
                    $firstImage = $product->product_images[0]->image_file ?? null;
                    if ($firstImage) {
                        $imageUrl = $this->Url->image('products/' . $firstImage);
                    }
                }

                // price calculation
                $prices = [];
                foreach ($product->product_variants as $variant) {
                    if ($variant->price !== null) {
                        $prices[] = (float)$variant->price;
                    }
                }
                if (!empty($prices)) {
                    $min = min($prices);
                    $max = max($prices);
                    $priceHtml = $min === $max ? '$'.number_format($min,2) : '$'.number_format($min,2).' - $'.number_format($max,2);
                } else {
                    $priceHtml = '<span class="text-muted">Unavailable</span>';
                }
                ?>
                <div class="col mb-5">
                    <div class="card h-100">
                        <img class="card-img-top" src="<?= h($imageUrl) ?>" alt="<?= h($product->name) ?>" />
                        <div class="card-body p-4 text-center">
                            <h5 class="fw-bolder"><?= h($product->name) ?></h5>
                            <?= $priceHtml ?>
                        </div>
                        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent text-center">
                            <a class="btn btn-outline-dark mt-auto"
                               href="<?= $this->Url->build(['controller' => 'Shop', 'action' => 'view', $product->id]) ?>">
                                View
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <?php if (!empty($this->request->getQuery('q'))): ?>
                <div class="col-12 text-center text-muted">No products match your search.</div>
            <?php else: ?>
                <div class="col-12 text-center text-muted">No products available yet.</div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>
