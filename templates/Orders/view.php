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

            <div class="card mb-3">
                <div class="card-header"><?= __('Shipping Address') ?></div>
                <div class="card-body">
                    <?php if ($order->has('address')): $addr = $order->address; ?>
                        <div class="small">
                            <div class="mb-1 d-flex align-items-center gap-2">
                                <?php if (!empty($addr->label)): ?>
                                    <span class="badge bg-secondary"><?= h($addr->label) ?></span>
                                <?php endif; ?>
                                <strong><?= h($addr->recipient_full_name ?? '') ?></strong>
                                <?php if (!empty($addr->recipient_phone)): ?>
                                    <span class="text-muted">• <?= h($addr->recipient_phone) ?></span>
                                <?php endif; ?>
                            </div>
                            <?php if (!empty($addr->street)): ?>
                                <div class="mb-1"><?= h($addr->street) ?></div>
                            <?php endif; ?>
                            <?php if (!empty($addr->building)): ?>
                                <div class="mb-1"><?= h($addr->building) ?></div>
                            <?php endif; ?>
                            <div class="mb-1">
                                <?= h($addr->city ?? '') ?><?= !empty($addr->city) && (!empty($addr->state) || !empty($addr->postcode)) ? ',' : '' ?>
                                <?= h($addr->state ?? '') ?> <?= h($addr->postcode ?? '') ?>
                            </div>
                            <div class="mt-2">
                                <?= $this->Html->link(__('View address'), ['controller' => 'Addresses', 'action' => 'view', $addr->id], ['class' => 'link-primary']) ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <span class="text-muted"><?= __('No address on file') ?></span>
                    <?php endif; ?>
                </div>
            </div>

            <table class="table table-bordered table-sm" width="100%" cellspacing="0">
                <tr>
                    <th><?= __('Shipping Status') ?></th>
                    <td>
                        <?php $identity = $this->request->getAttribute('identity'); ?>
                        <?php if ($identity && in_array($identity->user_type ?? null, ['admin', 'superuser'], true)) : ?>
                            <?php
                                // Determine if we can mark as shipped. Preorder items must have sufficient stock
                                $canShip = true;
                                if (!empty($order->order_product_variants)) {
                                    foreach ($order->order_product_variants as $opv) {
                                        if (!empty($opv->is_preorder)) {
                                            $variant = $opv->product_variant ?? null;
                                            $variantStock = (int)($variant->stock ?? 0);
                                            $qty = (int)($opv->quantity ?? 0);
                                            if ($variantStock < $qty) { $canShip = false; break; }
                                        }
                                    }
                                }
                            ?>
                            <?= $this->Form->create($order, ['url' => ['action' => 'edit', $order->id], 'class' => 'd-flex align-items-center gap-2']) ?>
                                <?= $this->Form->control('shipping_status', [
                                    'label' => false,
                                    'type' => 'select',
                                    'options' => [
                                        'pending' => 'Pending',
                                        'shipped' => 'Shipped',
                                    ],
                                    'default' => $order->shipping_status,
                                    'class' => 'form-select form-select-sm me-2',
                                    'disabled' => false,
                                    'templates' => [
                                        'selectOption' => '<option value="{{value}}"{{attrs}}>{{text}}</option>'
                                    ],
                                ]) ?>
                                <script>
                                    (function(){
                                        var select = document.querySelector('select[name="shipping_status"]');
                                        if (select) {
                                            var shippedOption = Array.from(select.options).find(function(o){ return o.value === 'shipped'; });
                                            if (shippedOption && <?= $canShip ? 'false' : 'true' ?>) {
                                                shippedOption.disabled = true;
                                                shippedOption.text = shippedOption.text + ' (insufficient preorder stock)';
                                                if (select.value === 'shipped') { select.value = 'pending'; }
                                            }
                                        }
                                    })();
                                </script>
                                <?= $this->Form->button(__('Update'), ['class' => 'btn btn-sm btn-primary']) ?>
                            <?= $this->Form->end() ?>
                            <?php if (!$canShip): ?>
                                <div class="text-danger small mt-1">Cannot mark as shipped until preorder item stock is available.</div>
                            <?php endif; ?>
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
