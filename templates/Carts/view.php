<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Cart $cart
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Cart'), ['action' => 'edit', $cart->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Cart'), ['action' => 'delete', $cart->id], ['confirm' => __('Are you sure you want to delete # {0}?', $cart->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Carts'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Cart'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="carts view content">
            <h3><?= h($cart->status) ?></h3>
            <table>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $cart->hasValue('user') ? $this->Html->link($cart->user->first_name, ['controller' => 'Users', 'action' => 'view', $cart->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Address') ?></th>
                    <td><?= $cart->hasValue('address') ? $this->Html->link($cart->address->label, ['controller' => 'Addresses', 'action' => 'view', $cart->address->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($cart->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($cart->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Date Created') ?></th>
                    <td><?= h($cart->date_created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Date Modified') ?></th>
                    <td><?= h($cart->date_modified) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Cart Items') ?></h4>
                <?php if (!empty($cart->cart_items)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Cart Id') ?></th>
                            <th><?= __('Product Variant Id') ?></th>
                            <th><?= __('Quantity') ?></th>
                            <th><?= __('Is Preorder') ?></th>
                            <th><?= __('Date Added') ?></th>
                            <th><?= __('Date Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($cart->cart_items as $cartItem) : ?>
                        <tr>
                            <td><?= h($cartItem->id) ?></td>
                            <td><?= h($cartItem->cart_id) ?></td>
                            <td><?= h($cartItem->product_variant_id) ?></td>
                            <td><?= h($cartItem->quantity) ?></td>
                            <td><?= h($cartItem->is_preorder) ?></td>
                            <td><?= h($cartItem->date_added) ?></td>
                            <td><?= h($cartItem->date_modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'CartItems', 'action' => 'view', $cartItem->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'CartItems', 'action' => 'edit', $cartItem->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'CartItems', 'action' => 'delete', $cartItem->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $cartItem->id),
                                    ]
                                ) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>