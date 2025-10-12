<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<header>
    <div class="py-5"></div>
    <div class="container px-lg-5 my-4">
        <div class="text-center text-white">
            <h1 class="display-6 fw-bolder">Edit Profile</h1>
            <p class="lead">Update your personal details</p>
        </div>
    </div>
</header>

<div class="container my-5">
    <?= $this->Flash->render() ?>

    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <?= $this->Form->create($user) ?>
                    <div class="mb-3">
                        <?= $this->Form->label('first_name', 'First Name') ?>
                        <?= $this->Form->text('first_name', ['class' => 'form-control', 'required' => true]) ?>
                    </div>
                    <div class="mb-3">
                        <?= $this->Form->label('last_name', 'Last Name') ?>
                        <?= $this->Form->text('last_name', ['class' => 'form-control', 'required' => true]) ?>
                    </div>
<!--                    <div class="mb-3">
                        <?php /*= $this->Form->label('email', 'Email') */?>
                        <?php /*= $this->Form->email('email', ['class' => 'form-control', 'required' => true]) */?>
                    </div>
-->                    <div class="d-flex gap-2">
                        <a href="<?= $this->Url->build(['action' => 'index']) ?>" class="btn btn-outline-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>
    </div>
</div>
