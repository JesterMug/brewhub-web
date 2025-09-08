<?php
?>
<nav class="navbar">
    <div class="container">
        <a href="<?= $this->Url->build('/') ?>" class="brand">BrewHub</a>
        <ul class="nav-links">
            <li><a href="<?= $this->Url->build(['controller' => 'forms', 'action' => 'index']) ?>">Login</a></li>
            <li><a href="<?= $this->Url->build(['controller' => 'Pages', 'action' => 'display', 'index']) ?>">Shop</a></li>
            <li><a href="<?= $this->Url->build(['controller' => 'forms', 'action' => 'add']) ?>" class="btn btn-outline">Get in Touch</a></li>
        </ul>
    </div>
</nav>
