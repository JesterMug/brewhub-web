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
</head>
<body>
<div class="container">
    <header class="">
        <div class="py-4">
        </div>
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1 class="display-4 fw-bolder">Contact Us</h1>
            </div>
        </div>
    </header>
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
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
