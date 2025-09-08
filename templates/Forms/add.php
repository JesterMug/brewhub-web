<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Form $form
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BrewHub</title>
    <link rel="stylesheet" href="webroot/css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Inter:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>
<?= $this->element('navigation') ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h4 class="m-0 font-weight-bold text-primary"><?= __('Contact Us') ?></h4>
                </div>
                <div class="card-body">
                    <?= $this->Form->create($form) ?>

                    <div class="form-group">
                        <?= $this->Form->control('first_name', [
                            'class' => 'form-control',
                            'label' => 'First Name',
                            'placeholder' => 'Enter your first name'
                        ]) ?>
                    </div>

                    <div class="form-group">
                        <?= $this->Form->control('last_name', [
                            'class' => 'form-control',
                            'label' => 'Last Name',
                            'placeholder' => 'Enter your last name'
                        ]) ?>
                    </div>

                    <div class="form-group">
                        <?= $this->Form->control('email', [
                            'class' => 'form-control',
                            'label' => 'Email Address',
                            'placeholder' => 'Enter your email'
                        ]) ?>
                    </div>

                    <div class="form-group">
                        <?= $this->Form->control('message', [
                            'type' => 'textarea',
                            'rows' => 5,
                            'class' => 'form-control',
                            'label' => 'Message',
                            'placeholder' => 'Type your message here...'
                        ]) ?>
                    </div>

                    <div class="text-right">
                        <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']) ?>
                    </div>

                    <?= $this->Form->end() ?>
                </div>
            </div>

        </div>
    </div>
</div>
</body>
