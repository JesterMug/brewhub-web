<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\InventoryTransaction $inventoryTransaction
 * @var \Cake\Collection\CollectionInterface|string[] $productVariants
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Inventory Transactions'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="inventoryTransactions form content">
            <?= $this->Form->create($inventoryTransaction) ?>
            <fieldset>
                <legend><?= __('Add Inventory Transaction') ?></legend>
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
