<?php
$this->layout = 'login';
$this->assign('title', 'Register');
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-6 col-md-9">


            <!-- Card Begins -->



            <div class="card o-hidden border-0 shadow-lg my-5" style="min-height: 400px:>
                <div class="card-body p-0">
            <div class="row h-100">
                <div class="col-12 d-flex justify-content-center align-items-center">
                    <div class="p-5 w-100 text-center">


                        <!-- Form Beings -->


                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4" style="font-size: 30px">Join Now</h1>
                        </div>

                        <?= $this->Form->create($user, ['class' => 'user']) ?>

                        <div class="form-group">
                            <?= $this->Form->control('first_name', [
                                'label' => false,
                                'class' => 'form-control form-control-user',
                                'placeholder' => 'First Name',
                                'required' => true
                            ]) ?>
                        </div>

                        <div class="form-group">
                            <?= $this->Form->control('last_name', [
                                'label' => false,
                                'class' => 'form-control form-control-user',
                                'placeholder' => 'Last Name',
                                'required' => true
                            ]) ?>
                        </div>

                        <div class="form-group">
                            <?= $this->Form->control('email', [
                                'label' => false,
                                'class' => 'form-control form-control-user',
                                'placeholder' => 'Email Address',
                                'required' => true
                            ]) ?>
                        </div>

                        <div class="form-group">
                            <?= $this->Form->control('password', [
                                'label' => false,
                                'class' => 'form-control form-control-user',
                                'placeholder' => 'Password',
                                'type' => 'password',
                                'required' => true
                            ]) ?>
                        </div>

                        <div class="d-grid">
                            <button class="btn btn-primary btn-user btn-block">Register</button>
                        </div>

                        <?= $this->Form->end() ?>

                        <hr>
                        <div class="text-center">
                            <?= $this->Html->link('Already have an account? Login!', ['controller' => 'Users', 'action' => 'login'], ['class' => 'small']) ?>
                        </div>
                        <div class="text-center">
                            <?= $this->Html->link('Go to Homepage', '/', ['class' => 'small']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
