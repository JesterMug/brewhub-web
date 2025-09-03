<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\CartItem> $cartItems
 */
?>
<div class="cartItems index content">
    <?= $this->Html->link(__('New Cart Item'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Cart Items') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('cart_id') ?></th>
                    <th><?= $this->Paginator->sort('product_variant_id') ?></th>
                    <th><?= $this->Paginator->sort('quantity') ?></th>
                    <th><?= $this->Paginator->sort('is_preorder') ?></th>
                    <th><?= $this->Paginator->sort('date_added') ?></th>
                    <th><?= $this->Paginator->sort('date_modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cartItems as $cartItem): ?>
                <tr>
                    <td><?= $this->Number->format($cartItem->id) ?></td>
                    <td><?= $cartItem->hasValue('cart') ? $this->Html->link($cartItem->cart->status, ['controller' => 'Carts', 'action' => 'view', $cartItem->cart->id]) : '' ?></td>
                    <td><?= $cartItem->hasValue('product_variant') ? $this->Html->link($cartItem->product_variant->size, ['controller' => 'ProductVariants', 'action' => 'view', $cartItem->product_variant->id]) : '' ?></td>
                    <td><?= $this->Number->format($cartItem->quantity) ?></td>
                    <td><?= h($cartItem->is_preorder) ?></td>
                    <td><?= h($cartItem->date_added) ?></td>
                    <td><?= h($cartItem->date_modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $cartItem->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $cartItem->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $cartItem->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $cartItem->id),
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