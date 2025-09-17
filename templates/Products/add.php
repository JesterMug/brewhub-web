<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product $product
 */
?>
<h1 class="h3 mb-2 text-gray-800">Add New Product</h1>
<div class="card shadow mb-4">
    <div class="card-body">
<?= $this->Form->create($product, ['type' => 'file', 'id' => 'productForm']) ?>
    <?php
    echo $this->Form->control('name');
    echo $this->Form->control('product_type', [
        'type' => 'select',
        'options' => [
            'coffee' => 'Coffee Beans',
            'merchandise' => 'Merchandise'
        ],
        //'empty' => 'Select Product Type',
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
    <?= $this->Form->control('product_coffee.roast_level', [
        'type' => 'select',
        'options' => range(1, 9),
        'empty' => 'Select Roast Level'
    ]); ?>
    <?= $this->Form->control('product_coffee.brew_type', [
        'type' => 'select',
        'options' => [
            'Drip' => 'Drip',
            'French Press' => 'French Press',
            'Espresso' => 'Espresso',
            'Pour Over' => 'Pour Over',
            'Cold Brew' => 'Cold Brew',
            'Aeropress' => 'Aeropress',
            'Percolate' => 'Percolate',
            'Vacuum' => 'Vacuum'
        ],
        'empty' => 'Select Brew Type'
    ]) ?>
    <?= $this->Form->control('product_coffee.bean_type', [
        'type' => 'select',
        //'multiple' => 'checkbox',
            'options' => [
            'Arabica' => 'Arabica',
            'Robusta' => 'Robusta',
            'Liberica' => 'Liberica',
            'Excelsa' => 'Excelsa'],
        'empty' => 'Select Bean Type'
    ]); ?>
    <?= $this->Form->control('product_coffee.processing_method', [
        'type' => 'select',
        'options' => [
            'Washed' => 'Washed',
            'Natural' => 'Natural',
            'Honey' => 'Honey'],
        'empty' => 'Select Processing Method'
    ]); ?>
    <?= $this->Form->control('product_coffee.caffeine_level', [
        'type' => 'select',
        'options' => [
            'Low' => 'Low',
            'Medium' => 'Medium',
            'High' => 'High',
            'Decaf' => 'Decaf'],
        'empty' => 'Select Caffeine Level'
    ]); ?>
    <?= $this->Form->control('product_coffee.origin_country') ?>
    <?= $this->Form->control('product_coffee.certifications', [
        'type' => 'select',
        //'multiple' => 'checkbox',
        'options' => [
            'Fair Trade' => 'Fair Trade',
            'Rainforest Alliance' => 'Rainforest Alliance',
            'UTZ' => 'UTZ',
            'Specialty Coffee Association' => 'Specialty Coffee Association',
            'Organic' => 'Organic',
            'Shade-grown' => 'Shade-grown',
            'Bird-Friendly' => 'Bird-Friendly',
            'Direct Trade' => 'Direct Trade'],
        'empty' => 'Select Certifications'
    ]); ?>
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
<!--        <?php //= $this->Form->control('product_variants.0.size') ?>  -->
            <div class="form-group">
                <label for="size">Size</label>
                    <div class="input-group w-100">
                        <?= $this->Form->control('product_variants.0.size_value', [
                            'label' => false,
                            'type' => 'number',
                            'min' => 1,
                            'step' => 1,
                            'class' => 'form-control flex-grow-1',
                            'placeholder' => 'Enter size',
                        ]) ?>
                        <?= $this->Form->control('product_variants.0.size_unit', [
                            'label' => false,
                            'type' => 'select',
                            'options' => ['g' => 'g', 'kg' => 'kg', 'oz' => 'oz', 'ml' => 'ml'],
                            'class' => 'form-select',
                        ]) ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="price">Price</label>
                    <div class="input-group w-100">
                        <?= $this->Form->control('product_variants.0.price', [
                            'label' => false,
                            'type' => 'number',
                            'step' => '0.01',
                            'min' => '0.01',
                            'max' => '9999.99',
                            'class' => 'form-control flex-grow-1',
                            'placeholder' => 'Enter price'
                        ]) ?>
                        <span class="input-group-text" style="background-color: #2a2a2c; color: white; border-color: #444444;">AUD</span>
                    </div>
                </div>
                <?= $this->Form->control('product_variants.0.stock') ?>
            <?= $this->Form->control('product_variants.0.sku') ?>
        </div>
    </div>
    <button type="button" id="addVariantBtn" class="btn btn-secondary mt-2">+ Add Another Variant</button>
</div>

<?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary mt-3']) ?>
<?= $this->Form->end() ?>
    </div>
</div>

<script>
    function setDisabled(container, disabled) {
        if (!container) return;
        const fields = container.querySelectorAll('input, select, textarea');
        fields.forEach(el => {
            if (disabled) {
                // Clear value when disabling so no stale data remains
                if (el.type === 'checkbox' || el.type === 'radio') {
                    el.checked = false;
                } else {
                    el.value = '';
                }
            }
            el.disabled = disabled;
        });
    }

    function toggleTypeFields() {
        const typeEl = document.getElementById('productType');
        const type = typeEl ? typeEl.value : '';
        let coffee = document.getElementById('coffeeFields');
        let merch = document.getElementById('merchFields');
        const isCoffee = type === 'coffee';
        const isMerch = type === 'merchandise';
        if (coffee) coffee.style.display = isCoffee ? 'block' : 'none';
        if (merch) merch.style.display = isMerch ? 'block' : 'none';
        // Disable the irrelevant group so the browser will ignore them on submit
        setDisabled(coffee, !isCoffee);
        setDisabled(merch, !isMerch);
    }

    document.addEventListener('DOMContentLoaded', function() {
        const typeEl = document.getElementById('productType');
        if (typeEl) {
            typeEl.addEventListener('change', toggleTypeFields);
        }
        // Initialize state on load
        toggleTypeFields();
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
