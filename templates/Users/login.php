<?php
$this->layout = 'login';
$this->assign('title', 'Login');
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-6 col-md-9">


            <!-- Card Begins -->


            <div class="card o-hidden border-0 shadow-lg my-5" style="min-height: 400px:">
                <div class="card-body p-0">
                    <div class="row h-100">
                        <div class="col-12 d-flex justify-content-center align-items-center">
                            <div class="p-5 w-100 text-center">



                                <!-- Form Beings -->


                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4" style="font-size: 30px">Welcome back</h1>
                                    <h4 class="text-gray-500 mb-4" style="font-size: 12px">Sign in to your account here</h4>
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
