<?php
/**
 * Register page
 *
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
$this->layout = 'login';
$this->assign('title', 'Register new user');
?>

<div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <div class="row">
                <!-- Left image -->
                <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>

                <!-- Right form -->
                <div class="col-lg-7">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Create an Account</h1>
                        </div>

                        <?= $this->Form->create($user, ['class' => 'user', 'id' => 'registerForm']) ?>
                        <?= $this->Flash->render() ?>

                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <?= $this->Form->control('first_name', [
                                    'label' => false,
                                    'class' => 'form-control form-control-user',
                                    'placeholder' => 'First Name',
                                    'required' => true
                                ]) ?>
                            </div>
                            <div class="col-sm-6">
                                <?= $this->Form->control('last_name', [
                                    'label' => false,
                                    'class' => 'form-control form-control-user',
                                    'placeholder' => 'Last Name',
                                    'required' => true
                                ]) ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <?= $this->Form->control('email', [
                                'label' => false,
                                'class' => 'form-control form-control-user',
                                'placeholder' => 'Email Address',
                                'required' => true
                            ]) ?>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <?= $this->Form->control('password', [
                                    'label' => false,
                                    'class' => 'form-control form-control-user',
                                    'placeholder' => 'Password',
                                    'value' => '',
                                    'id' => 'password',
                                    'required' => true
                                ]) ?>
                            </div>
                            <div class="col-sm-6">
                                <?= $this->Form->control('password_confirm', [
                                    'type' => 'password',
                                    'label' => false,
                                    'class' => 'form-control form-control-user',
                                    'placeholder' => 'Repeat Password',
                                    'value' => '',
                                    'id' => 'password_confirm',
                                    'required' => true
                                ]) ?>
                            </div>
                        </div>

                        <div id="passwordMatchMsg" style="color:red; display:none;">Passwords do not match.</div>

                        <?= $this->Form->button(__('Register Account'), [
                            'class' => 'btn btn-primary btn-user btn-block'
                        ]) ?>
                        <?= $this->Form->end() ?>

                        <hr>
                        <div class="text-center">
                            <?= $this->Html->link('Forgot Password?', ['action' => 'forgetPassword'], ['class' => 'small']) ?>
                        </div>
                        <div class="text-center">
                            <?= $this->Html->link('Already have an account? Login!', ['action' => 'login'], ['class' => 'small']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    const pwd = document.getElementById('password');
    const confirm = document.getElementById('password_confirm');
    const msg = document.getElementById('passwordMatchMsg');

    confirm.addEventListener('blur', function() {
        if (confirm.value !== '' && pwd.value !== confirm.value) {
            msg.style.display = 'block';
        } else {
            msg.style.display = 'none';
        }
    });
</script>
