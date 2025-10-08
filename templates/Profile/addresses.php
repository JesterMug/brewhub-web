<?php
/**
 * @var \App\View\AppView $this
 * @var array<\App\Model\Entity\Address> $addresses
 */
?>
<header>
    <div class="py-4"></div>
    <div class="container px-4 px-lg-5 my-4">
        <div class="text-center text-white">
            <h1 class="display-6 fw-bolder">My Addresses</h1>
            <p class="lead">Manage where we ship your orders</p>
        </div>
    </div>
</header>

<div class="container my-5">
    <?= $this->Flash->render() ?>

    <?php if (empty($addresses)): ?>
        <div class="text-center py-5">
            <p class="text-muted mb-4">You have not added any addresses yet.</p>
            <a class="btn btn-primary" href="<?= $this->Url->build(['controller' => 'Addresses', 'action' => 'add']) ?>">Add Address</a>
        </div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach ($addresses as $addr): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h6 class="card-subtitle mb-2 text-muted">Address #<?= (int)$addr->id ?></h6>
                            <p class="mb-1"><?= h($addr->address_line_1) ?></p>
                            <?php if (!empty($addr->address_line_2)): ?>
                                <p class="mb-1"><?= h($addr->address_line_2) ?></p>
                            <?php endif; ?>
                            <p class="mb-1"><?= h($addr->suburb) ?>, <?= h($addr->state) ?> <?= h($addr->postcode) ?></p>
                            <p class="mb-0"><?= h($addr->country ?? 'Australia') ?></p>
                        </div>
                        <div class="card-footer bg-transparent border-0 d-flex gap-2 pt-0">
                            <a class="btn btn-outline-dark btn-sm flex-fill" href="<?= $this->Url->build(['controller' => 'Addresses', 'action' => 'edit', $addr->id]) ?>">Edit</a>
                            <a class="btn btn-outline-danger btn-sm flex-fill" href="<?= $this->Url->build(['controller' => 'Addresses', 'action' => 'delete', $addr->id]) ?>" onclick="return confirm('Delete this address?')">Delete</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="mt-4">
            <a class="btn btn-primary" href="<?= $this->Url->build(['controller' => 'Addresses', 'action' => 'add']) ?>">Add New Address</a>
        </div>
    <?php endif; ?>
</div>
