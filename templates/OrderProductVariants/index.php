<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\OrderProductVariant> $orderProductVariants
 */
?>
<div class="orderProductVariants index content">
    <?= $this->Html->link(__('New Order Product Variant'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Order Product Variants') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('order_id') ?></th>
                    <th><?= $this->Paginator->sort('product_variant_id') ?></th>
                    <th><?= $this->Paginator->sort('quantity') ?></th>
                    <th><?= $this->Paginator->sort('is_preorder') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orderProductVariants as $orderProductVariant): ?>
                <tr>
                    <td><?= $this->Number->format($orderProductVariant->id) ?></td>
                    <td><?= $orderProductVariant->hasValue('order') ? $this->Html->link($orderProductVariant->order->shipping_status, ['controller' => 'Orders', 'action' => 'view', $orderProductVariant->order->id]) : '' ?></td>
                    <td><?= $orderProductVariant->hasValue('product_variant') ? $this->Html->link($orderProductVariant->product_variant->size, ['controller' => 'ProductVariants', 'action' => 'view', $orderProductVariant->product_variant->id]) : '' ?></td>
                    <td><?= $this->Number->format($orderProductVariant->quantity) ?></td>
                    <td><?= h($orderProductVariant->is_preorder) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $orderProductVariant->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $orderProductVariant->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $orderProductVariant->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $orderProductVariant->id),
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