<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ProductMerchandise $productMerchandise
 * @var string[]|\Cake\Collection\CollectionInterface $products
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $productMerchandise->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $productMerchandise->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Product Merchandise'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="productMerchandise form content">
            <?= $this->Form->create($productMerchandise) ?>
            <fieldset>
                <legend><?= __('Edit Product Merchandise') ?></legend>
                <?php
                    echo $this->Form->control('product_id', ['options' => $products]);
                    echo $this->Form->control('material');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
