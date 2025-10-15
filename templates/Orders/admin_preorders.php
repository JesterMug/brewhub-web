<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Order> $orders
 */

echo $this->Html->css('/vendor/datatables/dataTables.bootstrap4.min.css', ['block' => true]);
echo $this->Html->script('/vendor/datatables/jquery.dataTables.min.js', ['block' => true]);
echo $this->Html->script('/vendor/datatables/dataTables.bootstrap4.min.js', ['block' => true]);
?>
<div class="orders index content">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= __('Preorders (Unshipped)') ?></h1>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th><?= h('Order #') ?></th>
                    <th><?= h('Customer') ?></th>
                    <th><?= h('Order Date') ?></th>
                    <th><?= h('Shipping Status') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                <tr>
                    <td>
                        <span class="badge badge-info mr-1"><?= __('Pre-Order') ?></span>
                        <?= h($order->id) ?>
                    </td>
                    <td>
                        <?php if (!empty($order->user)) : ?>
                            <?= h($order->user->first_name ?? '') ?> <?= h($order->user->last_name ?? '') ?>
                            <?php if (!empty($order->user->email)) : ?>
                                <div class="small text-muted"><?= $this->Html->link(h($order->user->email), 'mailto:' . h($order->user->email)) ?></div>
                            <?php endif; ?>
                        <?php else: ?>
                            <span class="text-muted">Guest</span>
                        <?php endif; ?>
                    </td>
                    <td><?= $this->Time->nice($order->order_date) ?></td>
                    <td><span class="badge badge-secondary"><?= h($order->shipping_status) ?></span></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $order->id], ['class' => 'btn btn-sm btn-outline-primary']) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>
</div>
