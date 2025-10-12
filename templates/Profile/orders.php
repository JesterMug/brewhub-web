<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\ResultSetInterface|array $orders
 */
?>
<header>
    <div class="py-5"></div>
    <div class="container px-4 px-lg-5 my-4">
        <div class="text-center text-white">
            <h1 class="display-6 fw-bolder">My Orders</h1>
            <p class="lead">Track your purchases and shipping status</p>
        </div>
    </div>
</header>

<div class="container my-4">
    <?= $this->Flash->render() ?>

    <?php if (empty($orders) || count($orders) === 0): ?>
        <div class="text-center py-5">
            <p class="text-muted mb-4">You haven't placed any orders yet.</p>
            <a class="btn btn-primary" href="<?= $this->Url->build(['controller' => 'Shop', 'action' => 'index']) ?>">Start Shopping</a>
        </div>
    <?php else: ?>
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                        <tr>
                            <th class="text-white">Order #</th>
                            <th class="text-white">Date</th>
                            <th class="text-white">Status</th>
                            <th class="text-white">Items</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($orders as $o): ?>
                            <tr>
                                <td class="text-muted mb-4"><?= (int)$o->id ?></td>
                                <td class="text-muted mb-4"><?= h($o->order_date ? $o->order_date->format('Y-m-d H:i') : '') ?></td>
                                <td class="text-muted mb-4"><span class="badge bg-secondary"><?= h($o->shipping_status) ?></span></td>
                                <td class="text-muted mb-4"><?= isset($o->order_product_variants) ? count($o->order_product_variants) : '' ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
