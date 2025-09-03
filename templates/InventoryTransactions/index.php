<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\InventoryTransaction> $inventoryTransactions
 */
?>
<div class="inventoryTransactions index content">
    <?= $this->Html->link(__('New Inventory Transaction'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Inventory Transactions') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('product_variant_id') ?></th>
                    <th><?= $this->Paginator->sort('change_type') ?></th>
                    <th><?= $this->Paginator->sort('quantity_change') ?></th>
                    <th><?= $this->Paginator->sort('note') ?></th>
                    <th><?= $this->Paginator->sort('created_by') ?></th>
                    <th><?= $this->Paginator->sort('date_created') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($inventoryTransactions as $inventoryTransaction): ?>
                <tr>
                    <td><?= $this->Number->format($inventoryTransaction->id) ?></td>
                    <td><?= $inventoryTransaction->hasValue('product_variant') ? $this->Html->link($inventoryTransaction->product_variant->size, ['controller' => 'ProductVariants', 'action' => 'view', $inventoryTransaction->product_variant->id]) : '' ?></td>
                    <td><?= h($inventoryTransaction->change_type) ?></td>
                    <td><?= $this->Number->format($inventoryTransaction->quantity_change) ?></td>
                    <td><?= h($inventoryTransaction->note) ?></td>
                    <td><?= h($inventoryTransaction->created_by) ?></td>
                    <td><?= h($inventoryTransaction->date_created) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $inventoryTransaction->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $inventoryTransaction->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $inventoryTransaction->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $inventoryTransaction->id),
                            ]
                        ) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>