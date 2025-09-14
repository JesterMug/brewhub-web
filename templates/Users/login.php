<?php
$this->layout = 'login';
$this->assign('title', 'Login');
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Welcome back</h1>
                                </div>
                                <?= $this->Form->create(null, ['class' => 'user']) ?>
                                <div class="form-group">
                                    <?= $this->Form->control('email', [
                                        'label' => false,
                                        'class' => 'form-control form-control-user',
                                        'placeholder' => 'Enter Email Address...',
                                        'required' => true,
                                        'autofocus' => true
                                    ]) ?>
                                </div>
                                <div class="form-group">
                                    <?= $this->Form->control('password', [
                                        'label' => false,
                                        'class' => 'form-control form-control-user',
                                        'placeholder' => 'Password',
                                        'required' => true,
                                        'value' => ''
                                    ]) ?>
                                </div>
                                <?= $this->Form->button('Login', ['class' => 'btn btn-primary btn-user btn-block']) ?>
                                <?= $this->Form->end() ?>
                                <hr>
                                <div class="text-center">
                                    <?= $this->Html->link('Create an Account', ['controller' => 'Users', 'action' => 'register'], ['class' => 'small']) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
