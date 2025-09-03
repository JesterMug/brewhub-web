<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OrderProductVariant $orderProductVariant
 * @var string[]|\Cake\Collection\CollectionInterface $orders
 * @var string[]|\Cake\Collection\CollectionInterface $productVariants
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $orderProductVariant->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $orderProductVariant->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Order Product Variants'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="orderProductVariants form content">
            <?= $this->Form->create($orderProductVariant) ?>
            <fieldset>
                <legend><?= __('Edit Order Product Variant') ?></legend>
                <?php
                    echo $this->Form->control('order_id', ['options' => $orders]);
                    echo $this->Form->control('product_variant_id', ['options' => $productVariants]);
                    echo $this->Form->control('quantity');
                    echo $this->Form->control('is_preorder');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
