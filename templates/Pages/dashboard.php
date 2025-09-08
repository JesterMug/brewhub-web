<?php
/**
 * @var \App\View\AppView $this
 */
$this->assign('title', 'Admin Dashboard');
?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Admin Dashboard</h1>
</div>

<?= $this->Flash->render() ?>

<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Orders</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">—</div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Revenue</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">—</div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Products</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">—</div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Users</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">—</div>
            </div>
        </div>
    </div>
</div>
