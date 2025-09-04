<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product $product
 */
?>
<h1 class="h3 mb-2 text-gray-800">Add New Product</h1>
<?= $this->Form->create($product, ['type' => 'file']) ?>
    <?php
    echo $this->Form->control('name');
    echo $this->Form->control('category');
    echo $this->Form->control('description');
    echo $this->Form->control('product_images_files[]', [
        'type' => 'file',
        'multiple' => true,
        'label' => 'Upload Images'
    ]);
    ?>

    <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']) ?>
<?= $this->Form->end() ?>
