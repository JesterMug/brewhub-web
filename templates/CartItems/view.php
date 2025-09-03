<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CartItem $cartItem
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Cart Item'), ['action' => 'edit', $cartItem->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Cart Item'), ['action' => 'delete', $cartItem->id], ['confirm' => __('Are you sure you want to delete # {0}?', $cartItem->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Cart Items'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Cart Item'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="cartItems view content">
            <h3><?= h($cartItem->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Cart') ?></th>
                    <td><?= $cartItem->hasValue('cart') ? $this->Html->link($cartItem->cart->status, ['controller' => 'Carts', 'action' => 'view', $cartItem->cart->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Product Variant') ?></th>
                    <td><?= $cartItem->hasValue('product_variant') ? $this->Html->link($cartItem->product_variant->size, ['controller' => 'ProductVariants', 'action' => 'view', $cartItem->product_variant->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($cartItem->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Quantity') ?></th>
                    <td><?= $this->Number->format($cartItem->quantity) ?></td>
                </tr>
                <tr>
                    <th><?= __('Date Added') ?></th>
                    <td><?= h($cartItem->date_added) ?></td>
                </tr>
                <tr>
                    <th><?= __('Date Modified') ?></th>
                    <td><?= h($cartItem->date_modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Preorder') ?></th>
                    <td><?= $cartItem->is_preorder ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>