<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */

$this->layout = 'login';
$this->assign('title', 'Register new user');
?>
<div class="container register">
    <div class="users form content">

        <?= $this->Form->create($user) ?>

        <fieldset>
            <legend>Register new user</legend>

            <?= $this->Flash->render() ?>

            <?= $this->Form->control('email'); ?>

            <div class="row">
                <?= $this->Form->control('first_name', ['templateVars' => ['container_class' => 'column']]); ?>
                <?= $this->Form->control('last_name', ['templateVars' => ['container_class' => 'column']]); ?>
            </div>

            <div class="row">
                <?php
                echo $this->Form->control('password', [
                    'value' => '',  // Ensure password is not sending back to the client side
                    'templateVars' => ['container_class' => 'column']
                ]);
                // Validate password by repeating it
                echo $this->Form->control('password_confirm', [
                    'type' => 'password',
                    'value' => '',  // Ensure password is not sending back to the client side
                    'label' => 'Retype Password',
                    'templateVars' => ['container_class' => 'column']
                ]);
                ?>
            </div>

            <?= $this->Form->control('avatar', ['type' => 'file']); ?>

        </fieldset>

        <?= $this->Form->button('Register') ?>
        <?= $this->Html->link('Back to login', ['controller' => 'Auth', 'action' => 'login'], ['class' => 'button button-outline float-right']) ?>
        <?= $this->Form->end() ?>

        <h1 class="h3 mb-2 text-gray-800">Add New User</h1>
        <?= $this->Form->create($user) ?>
        <?php
        echo $this->Form->control('first_name');
        echo $this->Form->control('last_name');
        echo $this->Form->control('email');
        echo $this->Form->control('password');
        echo $this->Form->control('user_type', ['options' => ['customer' => 'Customer', 'admin' => 'Admin', 'superuser' => 'Superuser']]);
        ?>
        <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']) ?>
        <?= $this->Form->end() ?>


    </div>
</div>
