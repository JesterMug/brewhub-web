<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\InventoryTransaction $inventoryTransaction
 * @var string[]|\Cake\Collection\CollectionInterface $productVariants
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $inventoryTransaction->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $inventoryTransaction->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Inventory Transactions'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="inventoryTransactions form content">
            <?= $this->Form->create($inventoryTransaction) ?>
            <fieldset>
                <legend><?= __('Edit Inventory Transaction') ?></legend>
                <?php
                    echo $this->Form->control('product_variant_id', ['options' => $productVariants]);
                    echo $this->Form->control('change_type');
                    echo $this->Form->control('quantity_change');
                    echo $this->Form->control('note');
                    echo $this->Form->control('created_by');
                    echo $this->Form->control('date_created');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
