<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Form $form
 */
?>

<?php // This template is rendered inside templates/layout/frontend.php ?>

<div class="container mt-5 py-5">
    <header class="mt-2 mb-4">
        <div class="text-center">
            <h1 class="display-6 fw-semibold">Contact Us</h1>
        </div>
    </header>

    <div class="row justify-content-center">
        <div class="col-lg-7 col-xl-6">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <?= $this->Form->create($form, ['class' => 'needs-validation']) ?>

                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <div class="row g-2">
                            <div class="col-12 col-md-6">
                                <?= $this->Form->control('first_name', [
                                    'label' => false,
                                    'class' => 'form-control',
                                    'placeholder' => 'First name'
                                ]) ?>
                            </div>
                            <div class="col-12 col-md-6">
                                <?= $this->Form->control('last_name', [
                                    'label' => false,
                                    'class' => 'form-control',
                                    'placeholder' => 'Last name'
                                ]) ?>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <?= $this->Form->control('email', [
                            'class' => 'form-control',
                            'label' => 'Email Address',
                            'placeholder' => 'you@example.com'
                        ]) ?>
                    </div>

                    <div class="mb-3">
                        <?= $this->Form->control('message', [
                            'type' => 'textarea',
                            'rows' => 4,
                            'class' => 'form-control',
                            'label' => 'Message',
                            'placeholder' => 'Type your message here...'
                        ]) ?>
                    </div>

                    <div class="mb-3 text-center">
                        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
                        <div class="g-recaptcha d-inline-block" data-sitekey="6LeMd8wrAAAAAMJUYNsJZX7Ka3IQ9920tDY92F_7"></div>
                    </div>

                    <div class="d-grid">
                        <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']) ?>
                    </div>

                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>
    </div>
</div>
