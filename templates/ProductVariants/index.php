<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\ProductVariant> $productVariants
 */
?>
<div class="productVariants index content">
    <?= $this->Html->link(__('New Product Variant'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Product Variants') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('product_id') ?></th>
                    <th><?= $this->Paginator->sort('size') ?></th>
                    <th><?= $this->Paginator->sort('price') ?></th>
                    <th><?= $this->Paginator->sort('stock') ?></th>
                    <th><?= $this->Paginator->sort('date_created') ?></th>
                    <th><?= $this->Paginator->sort('date_modified') ?></th>
                    <th><?= $this->Paginator->sort('sku') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productVariants as $productVariant): ?>
                <tr>
                    <td><?= $this->Number->format($productVariant->id) ?></td>
                    <td><?= $productVariant->hasValue('product') ? $this->Html->link($productVariant->product->name, ['controller' => 'Products', 'action' => 'view', $productVariant->product->id]) : '' ?></td>
                    <td><?= h($productVariant->size) ?></td>
                    <td><?= $this->Number->format($productVariant->price) ?></td>
                    <td><?= $this->Number->format($productVariant->stock) ?></td>
                    <td><?= h($productVariant->date_created) ?></td>
                    <td><?= h($productVariant->date_modified) ?></td>
                    <td><?= h($productVariant->sku) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $productVariant->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $productVariant->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $productVariant->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $productVariant->id),
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