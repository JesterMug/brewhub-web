<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product $product
 */
?>
<h1 class="h3 mb-2 text-gray-800">Edit Product</h1>
<?= $this->Form->create($product) ?>
    <?php
    echo $this->Form->control('name');
    echo $this->Form->control('category');
    echo $this->Form->control('description');
    echo $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']);
    echo $this->Html->link(__('List Products'), ['action' => 'index'], ['class' => 'side-nav-item']);
    echo $this->Form->postLink(
        __('Delete'),
        ['action' => 'delete', $product->id],
        ['confirm' => __('Are you sure you want to delete {0}? This will delete all associated product variants and images.', $product->name), 'class' => 'side-nav-item']
    );
    ?>

<?= $this->Form->end() ?>
