<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<header>
    <div class="py-5"></div>
    <div class="container px-4 px-lg-5 my-4">
        <div class="text-center text-white">
            <h1 class="display-5 fw-bolder">My Profile</h1>
            <p class="lead">Manage your account, addresses and orders</p>
        </div>
    </div>
</header>

<div class="container my-5">
    <?= $this->Flash->render() ?>
    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">Account Details</h5>
                    <p class="mb-1"><strong>Name:</strong> <?= h(($user->first_name ?? '') . ' ' . ($user->last_name ?? '')) ?></p>
                    <p class="mb-1"><strong>Email:</strong> <?= h($user->email ?? '') ?></p>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0">
                    <a href="<?= $this->Url->build(['action' => 'edit']) ?>" class="btn btn-primary w-100">Edit Profile</a>
                </div>
            </div>
        </div>
        <div>
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">Addresses</h5>
                            <p class="text-muted mb-4">Manage your shipping addresses</p>
                            <div class="mt-auto">
                                <a href="<?= $this->Url->build(['action' => 'addresses']) ?>" class="btn btn-outline-dark w-100">View Addresses</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">Orders</h5>
                            <p class="text-muted mb-4">See your recent purchases</p>
                            <div class="mt-auto">
                                <a href="<?= $this->Url->build(['action' => 'orders']) ?>" class="btn btn-outline-dark w-100">View Orders</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if (!empty($user->orders)): ?>
                    <div class="col-12">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title mb-3">Recent Orders</h5>
                                <div class="table-responsive">
                                    <table class="table table-sm align-middle">
                                        <thead>
                                        <tr>
                                            <th class="text-white">Order#</th>
                                            <th class="text-white">Date</th>
                                            <th class="text-white">Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($user->orders as $o): ?>
                                            <tr>
                                                <td class="text-muted mb-4"><?= (int)$o->id ?></td>
                                                <td class="text-muted mb-4"><?= h($o->order_date ? $o->order_date->format('Y-m-d H:i') : '') ?></td>
                                                <td class="text-muted mb-4"><span class="badge bg-secondary"><?= h($o->shipping_status) ?></span></td>
                                            </tr>
                                        <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
