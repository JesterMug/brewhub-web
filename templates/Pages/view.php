<?php
$imageUrl = 'https://dummyimage.com/600x700/dee2e6/6c757d.jpg';
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
    $priceHtml = ($min === $max)
        ? '$' . number_format($min, 2)
        : '$' . number_format($min, 2) . ' - $' . number_format($max, 2);
}
?>
<section class="py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="row gx-4 gx-lg-5 align-items-center">
            <div class="col-md-6">
                <img class="card-img-top mb-5 mb-md-0" src="<?= h($imageUrl) ?>" alt="<?= h($product->name) ?>" />
            </div>
            <div class="col-md-6">
                <h1 class="display-5 fw-bolder"><?= h($product->name) ?></h1>
                <div class="fs-5 mb-5"><?= $priceHtml ?></div>
                <p class="lead"><?= h($product->description ?? 'No description available.') ?></p>
            </div>
        </div>
    </div>
</section>
