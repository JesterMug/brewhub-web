<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Order $order
 */
?>
<div class="row">
    <div class="column column-80">
        <div class="orders view content">
            <h3><?="Order #", h($order->id) ?></h3>
            <table class="table table-bordered table-sm" width="100%" cellspacing="0">
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
                    <td>
                        <?php $identity = $this->request->getAttribute('identity'); ?>
                        <?php if ($identity && in_array($identity->user_type ?? null, ['admin', 'superuser'], true)) : ?>
                            <?= $this->Form->create($order, ['url' => ['action' => 'edit', $order->id], 'class' => 'd-flex align-items-center gap-2']) ?>
                                <?= $this->Form->control('shipping_status', [
                                    'label' => false,
                                    'type' => 'select',
                                    'options' => [
                                        'pending' => 'Pending',
                                        'failed' => 'Failed',
                                        'shipped' => 'Shipped',
                                        'completed' => 'Completed',
                                        'cancelled' => 'Cancelled',
                                    ],
                                    'default' => $order->shipping_status,
                                    'class' => 'form-select form-select-sm me-2',
                                ]) ?>
                                <?= $this->Form->button(__('Update'), ['class' => 'btn btn-sm btn-primary ms-2']) ?>
                            <?= $this->Form->end() ?>
                        <?php else: ?>
                            <?= h($order->shipping_status) ?>
                        <?php endif; ?>
                    </td>
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
                    <table class="table table-bordered table-sm" width="100%" cellspacing="0">
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
            <div class="related mb-4">
                <h4><?= __('Order Items') ?></h4>
                <?php if (!empty($order->order_product_variants)) : ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-sm align-middle" width="100%" cellspacing="0">
                        <tr>
                            <th><?= __('Product') ?></th>
                            <th><?= __('Variant') ?></th>
                            <th><?= __('Quantity') ?></th>
                            <th><?= __('Preorder') ?></th>
                        </tr>
                        <?php foreach ($order->order_product_variants as $orderProductVariant) : ?>
                        <?php $variant = $orderProductVariant->product_variant ?? null; $product = $variant->product ?? null; ?>
                        <tr>
                            <td><?= $product ? h($product->name) : __('N/A') ?></td>
                            <td><?= $variant ? h($variant->size ?? (($variant->size_value ?? '') . ($variant->size_unit ?? ''))) : __('N/A') ?></td>
                            <td><?= h($orderProductVariant->quantity) ?></td>
                            <td>
                                <?php if ($orderProductVariant->is_preorder) : ?>
                                    <span class="badge bg-info">Yes</span>
                                <?php else : ?>
                                    <span class="badge bg-secondary">No</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php else: ?>
                    <p class="text-muted"><?= __('No items found for this order.') ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
