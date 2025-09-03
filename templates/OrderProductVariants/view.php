<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OrderProductVariant $orderProductVariant
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Order Product Variant'), ['action' => 'edit', $orderProductVariant->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Order Product Variant'), ['action' => 'delete', $orderProductVariant->id], ['confirm' => __('Are you sure you want to delete # {0}?', $orderProductVariant->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Order Product Variants'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Order Product Variant'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="orderProductVariants view content">
            <h3><?= h($orderProductVariant->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Order') ?></th>
                    <td><?= $orderProductVariant->hasValue('order') ? $this->Html->link($orderProductVariant->order->shipping_status, ['controller' => 'Orders', 'action' => 'view', $orderProductVariant->order->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Product Variant') ?></th>
                    <td><?= $orderProductVariant->hasValue('product_variant') ? $this->Html->link($orderProductVariant->product_variant->size, ['controller' => 'ProductVariants', 'action' => 'view', $orderProductVariant->product_variant->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($orderProductVariant->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Quantity') ?></th>
                    <td><?= $this->Number->format($orderProductVariant->quantity) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Preorder') ?></th>
                    <td><?= $orderProductVariant->is_preorder ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>