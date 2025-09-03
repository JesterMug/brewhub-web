<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\ProductImage> $productImages
 */
?>
<div class="productImages index content">
    <?= $this->Html->link(__('New Product Image'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Product Images') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('product_id') ?></th>
                    <th><?= $this->Paginator->sort('image_file') ?></th>
                    <th><?= $this->Paginator->sort('date_created') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productImages as $productImage): ?>
                <tr>
                    <td><?= $this->Number->format($productImage->id) ?></td>
                    <td><?= $productImage->hasValue('product') ? $this->Html->link($productImage->product->name, ['controller' => 'Products', 'action' => 'view', $productImage->product->id]) : '' ?></td>
                    <td><?= h($productImage->image_file) ?></td>
                    <td><?= h($productImage->date_created) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $productImage->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $productImage->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $productImage->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $productImage->id),
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