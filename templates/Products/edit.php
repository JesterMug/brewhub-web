<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product $product
 */
?>

<style>
    .variantGroup { border: 1px solid #e9ecef; border-radius: .25rem; padding: 1rem; margin-bottom: 1rem; background: #1b1919; }
    .variantGroup h6 { margin-top: 0; }
    .variantGroup.to-delete { border-color: #dc3545; background: #2a1e1e; opacity: 0.8; }
    .thumbs img { height: 80px; border: 1px solid #dee2e6; border-radius: .25rem; }
</style>

<h1 class="h3 mb-3 text-gray-800">Edit Product</h1>

<?= $this->Form->create($product, ['type' => 'file', 'id' => 'productForm']) ?>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white"><strong>Basic Information</strong></div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <?= $this->Form->control('name', ['label' => 'Product Name', 'class' => 'form-control']) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $this->Form->control('category', ['label' => 'Category', 'class' => 'form-control', 'placeholder' => 'e.g. coffee or merchandise']) ?>
                    </div>
                    <div class="col-12">
                        <?= $this->Form->control('description', ['label' => 'Description', 'class' => 'form-control', 'type' => 'textarea', 'rows' => 3]) ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <strong>Images</strong>
                <small class="text-muted">You can upload multiple images</small>
            </div>
            <div class="card-body">
                <?= $this->Form->control('product_images_files[]', [
                    'type' => 'file',
                    'multiple' => true,
                    'label' => 'Upload Images',
                    'class' => 'form-control'
                ]) ?>

                <?php if (!empty($product->product_images)) : ?>
                    <div class="mt-3">
                        <div class="thumbs d-flex flex-wrap gap-2">
                            <?php foreach ($product->product_images as $img): ?>
                                <img src="<?= $this->Url->image('products/' . h($img->image_file)) ?>" alt="Image">
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white"><strong>Product Details</strong></div>
            <div class="card-body">
                <?php $coffee = $product->product_coffee ?? null; ?>
                <?php if (!empty($coffee)): ?>
                    <div id="coffeeFields" class="mt-3">
                        <h6 class="mb-3">Coffee Details</h6>
                        <?php
                            echo $this->Form->hidden('product_coffee.id', ['value' => $coffee->id]);
                            echo $this->Form->control('product_coffee.roast_level', ['label' => 'Roast Level', 'value' => $coffee->roast_level ?? null, 'class' => 'form-control']);
                            echo $this->Form->control('product_coffee.brew_type', ['label' => 'Brew Type', 'value' => $coffee->brew_type ?? null, 'class' => 'form-control']);
                            echo $this->Form->control('product_coffee.bean_type', ['label' => 'Bean Type', 'value' => $coffee->bean_type ?? null, 'class' => 'form-control']);
                            echo $this->Form->control('product_coffee.processing_method', ['label' => 'Processing Method', 'value' => $coffee->processing_method ?? null, 'class' => 'form-control']);
                            echo $this->Form->control('product_coffee.caffeine_level', ['label' => 'Caffeine Level', 'value' => $coffee->caffeine_level ?? null, 'class' => 'form-control']);
                            echo $this->Form->control('product_coffee.origin_country', ['label' => 'Origin Country', 'value' => $coffee->origin_country ?? null, 'class' => 'form-control']);
                            echo $this->Form->control('product_coffee.certifications', ['label' => 'Certifications', 'value' => $coffee->certifications ?? null, 'class' => 'form-control']);
                        ?>
                    </div>
                <?php endif; ?>

                <?php $merch = $product->product_merchandise[0] ?? null; ?>
                <?php if (!empty($merch)): ?>
                    <div id="merchFields" class="mt-3">
                        <h6 class="mb-3">Merchandise Details</h6>
                        <?php
                            echo $this->Form->hidden('product_merchandise.0.id', ['value' => $merch->id ?? null]);
                            echo $this->Form->control('product_merchandise.0.material', ['label' => 'Material', 'value' => $merch->material ?? null, 'class' => 'form-control']);
                        ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <strong>Variants</strong>
                <button type="button" id="addVariantBtn" class="btn btn-sm btn-outline-secondary">+ Add Variant</button>
            </div>
            <div class="card-body" id="variantFields">
                <div id="variantsWrapper">
                    <?php $vIndex = 0; foreach ($product->product_variants as $variant): ?>
                        <div class="variantGroup" data-index="<?= (int)$vIndex ?>">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="mb-0">Variant <?= (int)($vIndex + 1) ?></h6>
                                <div>
                                    <button type="button" class="btn btn-sm btn-outline-danger btnRemoveVariant" data-existing="1">Delete</button>
                                </div>
                            </div>
                            <?= $this->Form->hidden("product_variants.$vIndex.id", ['value' => $variant->id]) ?>
                            <?= $this->Form->hidden("product_variants.$vIndex._delete", ['value' => '0', 'class' => 'variantDeleteFlag']) ?>
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <?= $this->Form->control("product_variants.$vIndex.size", ['label' => 'Size', 'value' => $variant->size, 'class' => 'form-control']) ?>
                                </div>
                                <div class="col-md-3">
                                    <?= $this->Form->control("product_variants.$vIndex.price", ['label' => 'Price', 'value' => $variant->price, 'class' => 'form-control']) ?>
                                </div>
                                <div class="col-md-3">
                                    <?= $this->Form->control("product_variants.$vIndex.stock", ['label' => 'Stock', 'value' => $variant->stock, 'class' => 'form-control']) ?>
                                </div>
                                <div class="col-md-3">
                                    <?= $this->Form->control("product_variants.$vIndex.sku", ['label' => 'SKU', 'value' => $variant->sku, 'class' => 'form-control']) ?>
                                </div>
                            </div>
                        </div>
                    <?php $vIndex++; endforeach; ?>

                    <?php if (empty($product->product_variants)): ?>
                        <div class="variantGroup" data-index="0">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="mb-0">Variant 1</h6>
                                <div>
                                    <button type="button" class="btn btn-sm btn-outline-danger btnRemoveVariant">Delete</button>
                                </div>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <?= $this->Form->control('product_variants.0.size', ['label' => 'Size', 'class' => 'form-control']) ?>
                                </div>
                                <div class="col-md-3">
                                    <?= $this->Form->control('product_variants.0.price', ['label' => 'Price', 'class' => 'form-control']) ?>
                                </div>
                                <div class="col-md-3">
                                    <?= $this->Form->control('product_variants.0.stock', ['label' => 'Stock', 'class' => 'form-control']) ?>
                                </div>
                                <div class="col-md-3">
                                    <?= $this->Form->control('product_variants.0.sku', ['label' => 'SKU', 'class' => 'form-control']) ?>
                                </div>
                            </div>
                        </div>
                        <?php $vIndex = 1; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="mb-4">
            <?= $this->Form->button(__('Save Changes'), ['class' => 'btn btn-primary']) ?>
            <?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'btn btn-outline-secondary ms-2']) ?>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white"><strong>Tips</strong></div>
            <div class="card-body small text-muted">
                <ul class="mb-0">
                    <li>Use a descriptive product name.</li>
                    <li>For Coffee, provide roast level and origin.</li>
                    <li>SKU should be unique per variant.</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?= $this->Form->end() ?>

<script>
    (function(){
        var addBtn = document.getElementById('addVariantBtn');
        var wrapper = document.getElementById('variantsWrapper');
        var variantIndex = <?php echo (int)($vIndex ?? 0); ?>;
        if (typeof variantIndex !== 'number' || isNaN(variantIndex)) { variantIndex = 0; }

        // Add new variant group
        if (addBtn) {
            addBtn.addEventListener('click', function(){
                if (!wrapper) return;
                var group = document.createElement('div');
                group.className = 'variantGroup';
                group.innerHTML = `
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="mb-0">Variant ${variantIndex + 1}</h6>
                        <div>
                            <button type="button" class="btn btn-sm btn-outline-danger btnRemoveVariant">Delete</button>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Size</label>
                            <input type="text" name="product_variants[${variantIndex}][size]" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Price</label>
                            <input type="text" name="product_variants[${variantIndex}][price]" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Stock</label>
                            <input type="number" name="product_variants[${variantIndex}][stock]" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">SKU</label>
                            <input type="text" name="product_variants[${variantIndex}][sku]" class="form-control">
                        </div>
                    </div>`;
                wrapper.appendChild(group);
                variantIndex++;
            });
        }

        // Delegate delete clicks
        if (wrapper) {
            wrapper.addEventListener('click', function(ev){
                var btn = ev.target.closest('.btnRemoveVariant');
                if (!btn) return;
                var group = btn.closest('.variantGroup');
                if (!group) return;
                var deleteFlag = group.querySelector('.variantDeleteFlag');
                var idInput = group.querySelector('input[name$="[id]"]');

                if (deleteFlag && idInput) {
                    // Existing variant, mark for deletion and hide fields
                    deleteFlag.value = '1';
                    group.classList.add('to-delete');
                    var inputs = group.querySelectorAll('input, select, textarea');
                    inputs.forEach(function(el){
                        if (el === deleteFlag || el === idInput) return;
                        el.disabled = true;
                    });
                    group.style.display = 'none';
                } else {
                    group.remove();
                }
            });
        }
    })();
</script>

<div class="mt-2">
    <?= $this->Html->link(__('Back to List'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
</div>
