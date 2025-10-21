<?php
/**
 * @var \App\View\AppView $this
 * @var int $productsCount
 * @var int $usersCount
 * @var int $newMessagesCount
 * @var float $totalRevenue
 */
$this->assign('title', 'Admin Dashboard');
?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0">Admin Dashboard</h1>
</div>

<?= $this->Flash->render() ?>

<div class="row">

    <div class="col-xl-3 col-md-6 mb-4">
        <a href="<?= $this->Url->build(['controller' => 'forms', 'action' => 'index']) ?>" class="text-decoration-none">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">New Enquiries</div>
                            <div class="h5 mb-0 font-weight-bold"><?= (int)$newMessagesCount ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comment fa-2x text-gray-300" style="color: var(--text-secondary-dark) !important;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">This Month's Revenue</div>
                        <div class="h5 mb-0 font-weight-bold">$<?= number_format((float)$totalRevenue, 2) ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300" style="color: var(--text-secondary-dark) !important;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <a href="<?= $this->Url->build(['controller' => 'products', 'action' => 'index']) ?>" class="text-decoration-none">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Products</div>
                            <div class="h5 mb-0 font-weight-bold"><?= (int)$productsCount ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-box-open fa-2x text-gray-300" style="color: var(--text-secondary-dark) !important;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <a href="<?= $this->Url->build(['controller' => 'orders', 'action' => 'index']) ?>" class="text-decoration-none">
            <div class="card border-left-secondary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Orders</div>
                            <div class="h5 mb-0 font-weight-bold"><?= (int)$ordersCount ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-receipt fa-2x text-gray-300" style="color: var(--text-secondary-dark) !important;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <a href="<?= $this->Url->build(['controller' => 'users', 'action' => 'index']) ?>" class="text-decoration-none">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Users</div>
                            <div class="h5 mb-0 font-weight-bold"><?= (int)$usersCount ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300" style="color: var(--text-secondary-dark) !important;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <a href="<?= $this->Url->build(['controller' => 'orders', 'action' => 'index']) ?>" class="text-decoration-none">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Preorders</div>
                            <div class="h5 mb-0 font-weight-bold"><?= (int)($unshippedPreordersCount ?? 0) ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300" style="color: var(--text-secondary-dark) !important;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>
