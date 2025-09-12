<?php
$this->disableAutoLayout();
?>
<header class="bg-dark py-5">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
          rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
          crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />
    <?= $this->Html->css('styles') ?>
</header>
<?= $this->element('navigation') ?>
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
                <input class="form-control text-center me-3" id="inputQuantity" type="num" value="1" style="max-width: 3rem" />
                <button class="btn btn-outline-dark flex-shrink-0" type="button">
                    <i class="bi-cart-fill me-1"></i>
                    Add to cart
                </button>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    </body>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
</div>
