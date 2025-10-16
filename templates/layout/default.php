<?php
$user = $this->request->getAttribute('identity');
$currentController = $this->request->getParam('controller');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?= $this->Html->charset() ?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <?= $this->Html->meta('icon') ?>

    <title><?= $this->fetch('title') ?></title>

    <!-- Custom fonts for this template-->
    <?= $this->Html->css(['/vendor/fontawesome-free/css/all.min.css']) ?>
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <?= $this->Html->css(['sb-admin-2']) ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>

    <?= $this->Html->script(['/vendor/jquery/jquery.min.js']) ?>

</head>

<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">
    <?php if ($user && ($user->user_type !== 'admin' || $user->user_type !== 'superuser')) : ?>

    <?php endif; ?>

    <?php if ($user && ($user->user_type === 'admin' || $user->user_type === 'superuser')) : ?>
    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <div class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= $this->Url->build('') ?>">
            <div class="sidebar-brand-icon">
                <i class="fas fa-mug-hot"></i>
            </div>
            <div class="sidebar-brand-text mx-3">Admin</div>
        </div>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Admin Dashboard -->
        <li class="nav-item">
            <a class="nav-link" href="<?= $this->Url->build(['plugin' => null, 'controller' => 'Pages', 'action' => 'dashboard']) ?>">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Functions
        </div>

        <!-- Nav Item - Pages Collapse Menu -->

        <li class="nav-item">
            <a class="nav-link" href="<?= $this->Url->build(['plugin' => null, 'controller' => 'users', 'action' => 'index']) ?>">
                <i class="fas fa-fw fa-users"></i>
                <span>Users</span>
            </a>
        </li>


        <li class="nav-item">
            <a class="nav-link" href="<?= $this->Url->build(['plugin' => null, 'controller' => 'forms', 'action' => 'index']) ?>">
                <i class="fas fa-fw fa-comment"></i>
                <span>Enquiries</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="<?= $this->Url->build(['plugin' => null, 'controller' => 'products', 'action' => 'index']) ?>">
                <i class="fas fa-fw fa-box-open"></i>
                <span>Products</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="<?= $this->Url->build(['plugin' => null, 'controller' => 'orders', 'action' => 'index']) ?>">
                <i class="fas fa-fw fa-receipt"></i>
                <span>Orders</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="<?= $this->Url->build(['plugin' => null, 'controller' => 'orders', 'action' => 'adminPreorders']) ?>">
                <i class="fas fa-fw fa-clock"></i>
                <span>Preorders</span>
            </a>
        </li>

        <?php if ($user && $user->user_type === 'superuser') : ?>
        <li class="nav-item">
            <a class="nav-link" href="<?= $this->Url->build(['plugin' => 'ContentBlocks', 'controller' => 'ContentBlocks', 'action' => 'index']) ?>">
                <i class="fas fa-fw fa-edit"></i>
                <span>Content</span>
            </a>
        </li>
        <?php endif;?>
        <!-- Divider -->
<!--        <hr class="sidebar-divider">-->

        <!-- Heading -->
<!--        <div class="sidebar-heading">
            Addons
        </div>-->

        <!-- Nav Item - Pages Collapse Menu -->
<!--        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
               aria-expanded="true" aria-controls="collapsePages">
                <i class="fas fa-fw fa-folder"></i>
                <span>Pages</span>
            </a>
            <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Login Screens:</h6>
                    <a class="collapse-item" href="login.html">Login</a>
                    <a class="collapse-item" href="register.html">Register</a>
                    <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
                    <div class="collapse-divider"></div>
                    <h6 class="collapse-header">Other Pages:</h6>
                    <a class="collapse-item" href="404.html">404 Page</a>
                    <a class="collapse-item" href="blank.html">Blank Page</a>
                </div>
            </div>
        </li>
-->
        <!-- Nav Item - Charts -->
<!--        <li class="nav-item">
            <a class="nav-link" href="charts.html">
                <i class="fas fa-fw fa-chart-area"></i>
                <span>Charts</span></a>
        </li>
-->
        <!-- Nav Item - Tables -->
<!--        <li class="nav-item">
            <a class="nav-link" href="tables.html">
                <i class="fas fa-fw fa-table"></i>
                <span>Tables</span></a>
        </li>
-->
        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    </ul>
    <!-- End of Sidebar -->
    <?php endif; ?>


    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">
            <?php if ($user && ($user->user_type === 'admin' || $user->user_type === 'superuser')): ?>

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                <!-- Sidebar Toggle (Topbar) -->
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>

                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                <?= h($user ? $user->first_name . ' ' . $user->last_name : 'Guest') ?>
                            </span>
                            <?=$this->Html->image('undraw_profile.svg', ['class' => 'img-profile rounded-circle'])?>
                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                             aria-labelledby="userDropdown">
<!--                            <a class="dropdown-item" href="#">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                Profile
                            </a>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                Settings
                            </a>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                Activity Log
                            </a>
                            <div class="dropdown-divider"></div>
-->                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Logout
                            </a>
                        </div>
                    </li>
                </ul>

            </nav>
            <!-- End of Topbar -->
            <?php endif; ?>

            <!-- Begin Page Content -->
            <div class="container-fluid">
                <?= $this->Flash->render() ?>
                <?= $this->fetch('content') ?>
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; BrewHub 2025</span>
                </div>
            </div>
        </footer>
        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="<?= $this->Url->build(['plugin' => null, 'controller' => 'Auth', 'action' => 'logout']) ?>">Logout</a>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript-->
<?= $this->Html->script(['/vendor/bootstrap/js/bootstrap.bundle.min.js']) ?>

<!-- Core plugin JavaScript-->
<?= $this->Html->script(['/vendor/jquery-easing/jquery.easing.min.js']) ?>

<!-- Custom scripts for all pages-->
<?= $this->Html->script(['sb-admin-2.min.js']) ?>

<?= $this->fetch('script') ?>
</body>

</html>
