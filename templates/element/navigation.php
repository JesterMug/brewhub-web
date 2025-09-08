<?php
?>
<nav class="navbar">
    <div class="container">
        <a href="<?= $this->Url->build('/') ?>" class="brand">BrewHub</a>
        <ul class="nav-links">
            <?php if ($this->Identity->isLoggedIn()): ?>
                <?php if (in_array($this->Identity->get('user_type'), ['admin', 'superuser'])): ?>
                    <!-- Admin or Superuser: show Dashboard and Logout -->
                    <li>
                        <a href="<?= $this->Url->build(['controller' => 'Pages', 'action' => 'dashboard']) ?>">Dashboard</a>
                    </li>
                    <li>
                        <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'logout']) ?>">Logout</a>
                    </li>
                <?php else: ?>
                    <!-- Customer: show Logout only -->
                    <li>
                        <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'logout']) ?>">Logout</a>
                    </li>
                <?php endif; ?>
            <?php else: ?>
                <!-- Not logged in: show Login -->
                <li>
                    <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'login']) ?>">Login</a>
                </li>
            <?php endif; ?>

            <li>
                <a href="<?= $this->Url->build(['controller' => 'Pages', 'action' => 'display', 'index']) ?>">Shop</a>
            </li>
            <li>
                <a href="<?= $this->Url->build(['controller' => 'Forms', 'action' => 'add']) ?>" class="btn btn-outline">Get in Touch</a>
            </li>
        </ul>
    </div>
</nav>
