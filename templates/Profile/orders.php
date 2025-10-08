<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\ResultSetInterface|array $orders
 */
?>
<header>
    <div class="py-4"></div>
    <div class="container px-4 px-lg-5 my-4">
        <div class="text-center text-white">
            <h1 class="display-6 fw-bolder">My Orders</h1>
            <p class="lead">Track your purchases and shipping status</p>
        </div>
    </div>
</header>

<div class="container my-5">
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
                            <th>#</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Items</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($orders as $o): ?>
                            <tr>
                                <td><?= (int)$o->id ?></td>
                                <td><?= h($o->order_date ? $o->order_date->format('Y-m-d H:i') : '') ?></td>
                                <td><span class="badge bg-secondary"><?= h($o->shipping_status) ?></span></td>
                                <td><?= isset($o->order_product_variants) ? count($o->order_product_variants) : '' ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?= $this->element('pagination') ?>
            </div>
        </div>
    <?php endif; ?>
</div>
