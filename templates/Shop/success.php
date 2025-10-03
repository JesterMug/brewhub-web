<?php
?>
<header>
    <div class="py-4"></div>
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">Thank you!</h1>
            <p class="lead">Your payment was successful.</p>
        </div>
    </div>
</header>
<div class="container py-5 text-white">
    <div class="card border shadow-none bg-dark text-white">
        <div class="card-body">
            <p>We have received your order. A confirmation will be sent to your email shortly.</p>
            <?php if (!empty($orderId)): ?>
                <p class="text-muted">Order #<?= h($orderId) ?> created successfully.</p>
            <?php elseif (!empty($sessionId)): ?>
                <p class="text-muted">Reference: <?= h($sessionId) ?></p>
            <?php endif; ?>
            <a href="<?= $this->Url->build(['controller' => 'Shop', 'action' => 'index']) ?>" class="btn btn-primary mt-3">Continue Shopping</a>
        </div>
    </div>
</div>
