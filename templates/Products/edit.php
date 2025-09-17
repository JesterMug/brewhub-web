<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product $product
 */
?>
<h1 class="h3 mb-2 text-gray-800">Edit Product</h1>
<div class="card shadow mb-4">
    <div class="card-body">
<?= $this->Form->create($product, ['type' => 'file', 'id' => 'productForm']) ?>
    <?php
    echo $this->Form->control('name');
    echo $this->Form->control('category');
    echo $this->Form->control('description');
    echo $this->Form->control('product_images_files[]', [
        'type' => 'file',
        'multiple' => true,
        'label' => 'Upload Additional Images'
    ]);
    ?>

<!-- Existing Images -->
<?php if (!empty($product->product_images)) : ?>
    <div class="mt-2 mb-3">
        <h5>Existing Images</h5>
        <div style="display:flex; gap:10px; flex-wrap: wrap;">
        <?php foreach ($product->product_images as $img): ?>
            <div>
                <img src="<?= $this->Url->image('products/' . h($img->image_file)) ?>" alt="Image" style="height:80px;">
            </div>
        <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>

<!-- Coffee -->
<div id="coffeeFields" style="display:none;">
    <h3>Coffee Details</h3>
    <?php
    $coffee = $product->product_coffee ?? null;
    if ($coffee) {
        echo $this->Form->hidden('product_coffee.id', ['value' => $coffee->id]);
        echo $this->Form->control('product_coffee.roast_level', ['value' => $coffee->roast_level]);
        echo $this->Form->control('product_coffee.brew_type', ['value' => $coffee->brew_type]);
        echo $this->Form->control('product_coffee.bean_type', ['value' => $coffee->bean_type]);
        echo $this->Form->control('product_coffee.processing_method', ['value' => $coffee->processing_method]);
        echo $this->Form->control('product_coffee.caffeine_level', ['value' => $coffee->caffeine_level]);
        echo $this->Form->control('product_coffee.origin_country', ['value' => $coffee->origin_country]);
        echo $this->Form->control('product_coffee.certifications', ['value' => $coffee->certifications]);
    }
    ?>
</div>

<!-- Merchandise -->
<div id="merchFields" style="display:none;">
    <h3>Merchandise Details</h3>
    <?php
        $merch = $product->product_merchandise[0] ?? null;
        echo $this->Form->hidden('product_merchandise.0.id', ['value' => $merch->id ?? null]);
        echo $this->Form->control('product_merchandise.0.material', ['value' => $merch->material ?? null]);
    ?>
</div>

<!-- Variants -->
<div id="variantFields">
    <h3>Variants</h3>
    <div id="variantsWrapper">
        <?php $vIndex = 0; foreach ($product->product_variants as $variant): ?>
            <div class="variantGroup">
                <?= "<h5>Variant " . ($vIndex + 1) . "</h5>" ?>
                <?= $this->Form->hidden("product_variants.$vIndex.id", ['value' => $variant->id]) ?>
                <?= $this->Form->control("product_variants.$vIndex.size", ['value' => $variant->size]) ?>
                <?= $this->Form->control("product_variants.$vIndex.price", ['value' => $variant->price]) ?>
                <?= $this->Form->control("product_variants.$vIndex.stock", ['value' => $variant->stock]) ?>
                <?= $this->Form->control("product_variants.$vIndex.sku", ['value' => $variant->sku]) ?>
            </div>
        <?php $vIndex++; endforeach; ?>
        <?php if (empty($product->product_variants)): ?>
            <div class="variantGroup">
                <?= $this->Form->control('product_variants.0.size') ?>
                <?= $this->Form->control('product_variants.0.price') ?>
                <?= $this->Form->control('product_variants.0.stock') ?>
                <?= $this->Form->control('product_variants.0.sku') ?>
            </div>
            <?php $vIndex = 1; ?>
        <?php endif; ?>
    </div>
    <button type="button" id="addVariantBtn" class="btn btn-secondary mt-2">+ Add Another Variant</button>
</div>

<?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary mt-3']) ?>
<?= $this->Form->end() ?>
    </div>
</div>

<script>
    function updateTypeVisibility(init=false) {
        const typeEl = document.getElementById('productType');
        const coffee = document.getElementById('coffeeFields');
        const merch = document.getElementById('merchFields');
        const val = typeEl ? typeEl.value : '';
        coffee.style.display = val === 'coffee' ? 'block' : 'none';
        merch.style.display = val === 'merchandise' ? 'block' : 'none';
    }
    const pt = document.getElementById('productType');
    if (pt) {
        pt.addEventListener('change', updateTypeVisibility);
    }
    document.addEventListener('DOMContentLoaded', function(){ updateTypeVisibility(true); });

    // Variant add button
    let variantIndex = typeof <?php echo (int)($vIndex ?? 0); ?> === 'number' ? <?php echo (int)($vIndex ?? 0); ?> : 0;
    document.getElementById('addVariantBtn').addEventListener('click', function() {
        const wrapper = document.getElementById('variantsWrapper');
        const group = document.createElement('div');
        group.classList.add('variantGroup');
        group.innerHTML = `
        <hr>
        <label>Size</label><input type="text" name="product_variants[${variantIndex}][size]" class="form-control">
        <label>Price</label><input type="text" name="product_variants[${variantIndex}][price]" class="form-control">
        <label>Stock</label><input type="number" name="product_variants[${variantIndex}][stock]" class="form-control">
        <label>SKU</label><input type="text" name="product_variants[${variantIndex}][sku]" class="form-control">
    `;
        wrapper.appendChild(group);
        variantIndex++;
    });
</script>

<div class="mt-3">
    <?= $this->Html->link(__('Back to List'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
    <?= $this->Form->postLink(
        __('Delete'),
        ['action' => 'delete', $product->id],
        ['confirm' => __('Are you sure you want to delete {0}? This will delete all associated product variants and images.', $product->name), 'class' => 'side-nav-item btn btn-link text-danger']
    ) ?>
</div>
