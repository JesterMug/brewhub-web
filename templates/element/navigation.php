<?php
/**
 * @var \App\View\AppView $this
 */
$user = $this->request->getAttribute('identity');
?>
<nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
    <div class="container px-4 px-lg-5">
        <a class="navbar-brand" href="<?= $this->Url->build('/') ?>">BrewHub</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?= $this->Url->build(['controller' => 'Shop', 'action' => 'index']) ?>">Shop</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= $this->Url->build(['controller' => 'Forms', 'action' => 'add']) ?>">Contact</a>
                </li>

                <!-- Separator for visual clarity -->
                <li class="nav-item d-none d-lg-block mx-lg-2">
                    <span class="nav-link text-white-50">|</span>
                </li>

                <?php if ($user): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user fa-fw"></i> <?= h($user->first_name ?? $user->email) ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <?php if (in_array($user->user_type, ['admin', 'superuser'])): ?>
                                <li><a class="dropdown-item" href="<?= $this->Url->build(['controller' => 'Pages', 'action' => 'dashboard']) ?>">Admin Dashboard</a></li>
                                <li><hr class="dropdown-divider"></li>
                            <?php endif; ?>
                            <li><a class="dropdown-item" href="<?= $this->Url->build(['controller' => 'Orders', 'action' => 'index']) ?>">Orders</a></li>
                            <li><a class="dropdown-item" href="<?= $this->Url->build(['controller' => 'Auth', 'action' => 'logout']) ?>">Logout</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $this->Url->build(['controller' => 'Auth', 'action' => 'login']) ?>">Log In</a>
                    </li>
                <?php endif; ?>

                <li class="nav-item">
                    <a class="nav-link" title="Cart" href="<?= $this->Url->build(['controller' => 'Shop', 'action' => 'cart']) ?>">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="d-lg-none ms-2">Cart</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
