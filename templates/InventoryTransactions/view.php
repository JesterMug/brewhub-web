<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\InventoryTransaction $inventoryTransaction
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Inventory Transaction'), ['action' => 'edit', $inventoryTransaction->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Inventory Transaction'), ['action' => 'delete', $inventoryTransaction->id], ['confirm' => __('Are you sure you want to delete # {0}?', $inventoryTransaction->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Inventory Transactions'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Inventory Transaction'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="inventoryTransactions view content">
            <h3><?= h($inventoryTransaction->change_type) ?></h3>
            <table>
                <tr>
                    <th><?= __('Product Variant') ?></th>
                    <td><?= $inventoryTransaction->hasValue('product_variant') ? $this->Html->link($inventoryTransaction->product_variant->size, ['controller' => 'ProductVariants', 'action' => 'view', $inventoryTransaction->product_variant->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Change Type') ?></th>
                    <td><?= h($inventoryTransaction->change_type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Note') ?></th>
                    <td><?= h($inventoryTransaction->note) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created By') ?></th>
                    <td><?= h($inventoryTransaction->created_by) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($inventoryTransaction->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Quantity Change') ?></th>
                    <td><?= $this->Number->format($inventoryTransaction->quantity_change) ?></td>
                </tr>
                <tr>
                    <th><?= __('Date Created') ?></th>
                    <td><?= h($inventoryTransaction->date_created) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>