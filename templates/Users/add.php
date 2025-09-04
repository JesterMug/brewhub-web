<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<h1 class="h3 mb-2 text-gray-800">Add New User</h1>
<?= $this->Form->create($user) ?>
    <?php
    echo $this->Form->control('first_name');
    echo $this->Form->control('last_name');
    echo $this->Form->control('email');
    echo $this->Form->control('password');
    echo $this->Form->control('user_type', ['options' => ['customer' => 'Customer', 'admin' => 'Admin']]);
    ?>
    <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']) ?>
<?= $this->Form->end() ?>
