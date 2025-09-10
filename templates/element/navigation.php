<?php
$user = $this->request->getAttribute('identity');
?>
<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
    <div class="container px-4 px-lg-5">
        <a class="navbar-brand" href="<?= $this->Url->build('/') ?>">BrewHub</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            Menu
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ms-auto">

                <?php if ($user): ?>
                    <?php if (in_array($user->user_type, ['admin', 'superuser'])): ?>
                        <!-- Admin or Superuser: show Dashboard and Logout -->
                        <li class="nav-item">
                            <a class="nav-link" href="<?= $this->Url->build(['controller' => 'Pages', 'action' => 'dashboard']) ?>">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'logout']) ?>">Logout</a>
                        </li>
                    <?php else: ?>
                        <!-- Customer: show Logout only -->
                        <li class="nav-item">
                            <a class="nav-link" href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'logout']) ?>">Logout</a>
                        </li>
                    <?php endif; ?>
                <?php else: ?>
                    <!-- Not logged in: show Login -->
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'login']) ?>">Log in</a>
                    </li>
                <?php endif; ?>

                <li class="nav-item">
                    <a class ="nav-link" href="<?= $this->Url->build(['controller' => 'forms', 'action' => 'add']) ?>">Shop</a>
                </li>

                <li class="nav-item">
                    <a class ="nav-link" href="<?= $this->Url->build(['controller' => 'forms', 'action' => 'add']) ?>">Get in Touch</a>
                </li>

            </ul>
        </div>
    </div>
</nav>
