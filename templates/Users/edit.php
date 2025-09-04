<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<?= $this->Form->create($user) ?>
    <legend><?= __('Edit User') ?></legend>
    <?php
    echo $this->Form->control('first_name');
    echo $this->Form->control('last_name');
    echo $this->Form->control('email');
    echo $this->Form->control('password');
    ?>
<?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']) ?>
<?= $this->Form->postLink(
    __('Delete'),
    ['action' => 'delete', $user->id],
    ['confirm' => __('Are you sure you want to delete {0} {1}? This will completely erase all associated data.', $user->first_name, $user->last_name), 'class' => 'side-nav-item']
) ?>
<?= $this->Html->link(__('List Users'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
<?= $this->Form->end() ?>
