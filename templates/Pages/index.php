<?php
$this->disableAutoLayout();

// Self-contained data loading to avoid PagesController changes
use Cake\Datasource\FactoryLocator;

$products = $products ?? null;
if ($products === null) {
    try {
        $productsTable = FactoryLocator::get('Table')->get('Products');
        // Ensure ProductImages are ordered so the "first" image is deterministic
        $products = $productsTable->find('all', contain: [
            'ProductImages' => function($q) { return $q->orderAsc('ProductImages.id'); },
            'ProductVariants'
        ]);
    } catch (Throwable $e) {
        $products = [];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Shop Homepage</title>
    <!-- Custom styles for this template-->
    <?= $this->Html->css(['styles']) ?>
    <?= $this->Html->css(['shop']) ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>

    <?= $this->Html->script(['/vendor/jquery/jquery.min.js']) ?>
</head>
<body>
<?= $this->element('navigation') ?>
<!-- Header-->
<header class="bg-dark py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">Shop in style</h1>
            <p class="lead fw-normal text-white-50 mb-0">With this shop hompeage template</p>
        </div>
    </div>
</header>
<!-- Section-->
<section class="py-5">
    <div class="container px-4 px-lg-5 mt-5">
        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                    <?php
                        $imageUrl = 'https://dummyimage.com/450x300/dee2e6/6c757d.jpg';
                        if (!empty($product->product_images)) {
                            $firstImage = $product->product_images[0]->image_file ?? null;
                            if ($firstImage) {
                                $imageUrl = $this->Url->image('products/' . $firstImage, ['fullBase' => false]);
                            }
                        }
                        $prices = [];
                        if (!empty($product->product_variants)) {
                            foreach ($product->product_variants as $variant) {
                                if ($variant->price !== null) {
                                    $prices[] = (float)$variant->price;
                                }
                            }
                        }
                        $priceHtml = '<span class="text-muted">Unavailable</span>';
                        if (!empty($prices)) {
                            $min = min($prices);
                            $max = max($prices);
                            if ($min === $max) {
                                $priceHtml = '$' . number_format($min, 2);
                            } else {
                                $priceHtml = '$' . number_format($min, 2) . ' - $' . number_format($max, 2);
                            }
                        }
                    ?>
                    <div class="col mb-5">
                        <div class="card h-100">
                            <img class="card-img-top" src="<?= h($imageUrl) ?>" alt="<?= h($product->name) ?>" />
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <h5 class="fw-bolder"><?= h($product->name) ?></h5>
                                    <?= $priceHtml ?>
                                </div>
                            </div>
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center">
                                    <a class="btn btn-outline-dark mt-auto" href="<?= $this->Url->build(['controller' => 'Products', 'action' => 'view', $product->id]) ?>">View</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center text-muted">No products available yet.</div>
            <?php endif; ?>
        </div>
    </div>
</section>
<!-- Footer-->
<footer class="py-5 bg-dark">
    <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Your Website 2023</p></div>
</footer>
<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Core theme JS-->
<script src="js/scripts.js"></script>
</body>
</html>

