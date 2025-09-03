<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Order $order
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Order'), ['action' => 'edit', $order->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Order'), ['action' => 'delete', $order->id], ['confirm' => __('Are you sure you want to delete # {0}?', $order->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Orders'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Order'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="orders view content">
            <h3><?= h($order->shipping_status) ?></h3>
            <table>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $order->hasValue('user') ? $this->Html->link($order->user->first_name, ['controller' => 'Users', 'action' => 'view', $order->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Address') ?></th>
                    <td><?= $order->hasValue('address') ? $this->Html->link($order->address->label, ['controller' => 'Addresses', 'action' => 'view', $order->address->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Shipping Status') ?></th>
                    <td><?= h($order->shipping_status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($order->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Order Date') ?></th>
                    <td><?= h($order->order_date) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Invoices') ?></h4>
                <?php if (!empty($order->invoices)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Order Id') ?></th>
                            <th><?= __('Payment Method') ?></th>
                            <th><?= __('Transaction Number') ?></th>
                            <th><?= __('Paid Amount') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($order->invoices as $invoice) : ?>
                        <tr>
                            <td><?= h($invoice->id) ?></td>
                            <td><?= h($invoice->order_id) ?></td>
                            <td><?= h($invoice->payment_method) ?></td>
                            <td><?= h($invoice->transaction_number) ?></td>
                            <td><?= h($invoice->paid_amount) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Invoices', 'action' => 'view', $invoice->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Invoices', 'action' => 'edit', $invoice->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'Invoices', 'action' => 'delete', $invoice->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $invoice->id),
                                    ]
                                ) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Order Product Variants') ?></h4>
                <?php if (!empty($order->order_product_variants)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Order Id') ?></th>
                            <th><?= __('Product Variant Id') ?></th>
                            <th><?= __('Quantity') ?></th>
                            <th><?= __('Is Preorder') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($order->order_product_variants as $orderProductVariant) : ?>
                        <tr>
                            <td><?= h($orderProductVariant->id) ?></td>
                            <td><?= h($orderProductVariant->order_id) ?></td>
                            <td><?= h($orderProductVariant->product_variant_id) ?></td>
                            <td><?= h($orderProductVariant->quantity) ?></td>
                            <td><?= h($orderProductVariant->is_preorder) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'OrderProductVariants', 'action' => 'view', $orderProductVariant->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'OrderProductVariants', 'action' => 'edit', $orderProductVariant->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'OrderProductVariants', 'action' => 'delete', $orderProductVariant->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $orderProductVariant->id),
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