<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\ProductMerchandise> $productMerchandise
 */
?>
<div class="productMerchandise index content">
    <?= $this->Html->link(__('New Product Merchandise'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Product Merchandise') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('product_id') ?></th>
                    <th><?= $this->Paginator->sort('material') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productMerchandise as $productMerchandise): ?>
                <tr>
                    <td><?= $this->Number->format($productMerchandise->id) ?></td>
                    <td><?= $productMerchandise->hasValue('product') ? $this->Html->link($productMerchandise->product->name, ['controller' => 'Products', 'action' => 'view', $productMerchandise->product->id]) : '' ?></td>
                    <td><?= h($productMerchandise->material) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $productMerchandise->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $productMerchandise->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $productMerchandise->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $productMerchandise->id),
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