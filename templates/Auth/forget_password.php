<?php
/**
 * @var \App\View\AppView $this
 */

$this->layout = 'login';
$this->assign('title', 'Forgot Password');
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-6 col-md-9">

            <!-- Card Begins -->
            <div class="card o-hidden border-0 shadow-lg my-5" style="min-height: 400px;">
                <div class="card-body p-0">
                    <div class="row h-100">
                        <div class="col-12 d-flex justify-content-center align-items-center">
                            <div class="p-5 w-100 text-center">

                                <!-- Header -->
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4" style="font-size: 26px">Forgot your password?</h1>
                                    <h4 class="text-gray-500 mb-4" style="font-size: 12px">
                                        Enter your email address and we’ll send you a reset link.
                                    </h4>
                                </div>

                                <!-- Flash Messages -->
                                <?= $this->Flash->render() ?>

                                <!-- Form Begins -->
                                <?= $this->Form->create() ?>
                                <div class="form-group">
                                    <?= $this->Form->control('email', [
                                        'label' => false,
                                        'class' => 'form-control form-control-user',
                                        'placeholder' => 'Enter Email Address...',
                                        'required' => true,
                                        'autofocus' => true
                                    ]) ?>
                                </div>
                                <?= $this->Form->button('Send Reset Link', [
                                    'class' => 'btn btn-primary btn-user btn-block'
                                ]) ?>
                                <?= $this->Form->end() ?>

                                <hr>
                                <div class="text-center">
                                    <?= $this->Html->link('Back to Login', [
                                        'controller' => 'Auth',
                                        'action' => 'login'
                                    ], ['class' => 'small']) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Card Ends -->

        </div>
    </div>
</div>
