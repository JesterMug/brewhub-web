<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product $product
 */
?>
<h1 class="h3 mb-2 text-gray-800">Add New Product</h1>
<?= $this->Form->create($product, ['type' => 'file', 'id' => 'productForm']) ?>
    <?php
    echo $this->Form->control('name');
    echo $this->Form->control('product_type', [
        'type' => 'select',
        'options' => [
            'coffee' => 'Coffee Beans',
            'merchandise' => 'Merchandise'
        ],
        'empty' => 'Select Product Type',
        'id' => 'productType'
    ]);
    echo $this->Form->control('category');
    echo $this->Form->control('description');
    echo $this->Form->control('product_images_files[]', [
        'type' => 'file',
        'multiple' => true,
        'label' => 'Upload Images'
    ]);
    ?>
<!-- Coffee -->
<div id="coffeeFields" style="display:none;">
    <h3>Coffee Details</h3>
    <?= $this->Form->control('product_coffee.roast_level') ?>
    <?= $this->Form->control('product_coffee.brew_type') ?>
    <?= $this->Form->control('product_coffee.bean_type') ?>
    <?= $this->Form->control('product_coffee.processing_method') ?>
    <?= $this->Form->control('product_coffee.caffeine_level') ?>
    <?= $this->Form->control('product_coffee.origin_country') ?>
    <?= $this->Form->control('product_coffee.certifications') ?>
</div>

<!-- Merchandise -->
<div id="merchFields" style="display:none;">
    <h3>Merchandise Details</h3>
    <?= $this->Form->control('product_merchandise.material') ?>
</div>

<!-- Variants -->
<div id="variantFields">
    <h3>Variants</h3>
    <div id="variantsWrapper">
        <div class="variantGroup">
            <?= $this->Form->control('product_variants.0.size') ?>
            <?= $this->Form->control('product_variants.0.price') ?>
            <?= $this->Form->control('product_variants.0.stock') ?>
            <?= $this->Form->control('product_variants.0.sku') ?>
        </div>
    </div>
    <button type="button" id="addVariantBtn" class="btn btn-secondary mt-2">+ Add Another Variant</button>
</div>

<?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary mt-3']) ?>
<?= $this->Form->end() ?>

<script>
    document.getElementById('productType').addEventListener('change', function() {
        let coffee = document.getElementById('coffeeFields');
        let merch = document.getElementById('merchFields');
        coffee.style.display = this.value === 'coffee' ? 'block' : 'none';
        merch.style.display = this.value === 'merchandise' ? 'block' : 'none';
    });

    // Variant add button
    let variantIndex = 1;
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
