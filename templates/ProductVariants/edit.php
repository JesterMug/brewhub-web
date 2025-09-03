<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ProductVariant $productVariant
 * @var string[]|\Cake\Collection\CollectionInterface $products
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $productVariant->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $productVariant->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Product Variants'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="productVariants form content">
            <?= $this->Form->create($productVariant) ?>
            <fieldset>
                <legend><?= __('Edit Product Variant') ?></legend>
                <?php
                    echo $this->Form->control('product_id', ['options' => $products]);
                    echo $this->Form->control('size');
                    echo $this->Form->control('price');
                    echo $this->Form->control('stock');
                    echo $this->Form->control('date_created');
                    echo $this->Form->control('date_modified');
                    echo $this->Form->control('sku');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
