<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>

<div class="row justify-content-center">
    <div class="col-12 col-lg-8">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white">
                <h4 class="mb-0"><?= __('Edit User') ?></h4>
            </div>
            <div class="card-body">
                <?= $this->Form->create($user) ?>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <?= $this->Form->control('first_name', ['class' => 'form-control']) ?>
                    </div>
                    <div class="form-group col-md-6">
                        <?= $this->Form->control('last_name', ['class' => 'form-control']) ?>
                    </div>
                </div>
                <div class="form-group">
                    <?= $this->Form->control('email', ['class' => 'form-control']) ?>
                </div>
                <div class="d-flex justify-content-between mt-3">
                    <?= $this->Html->link(__('« Back to Users'), ['action' => 'index'], ['class' => 'btn btn-outline-secondary']) ?>
                    <div>
                        <?= $this->Html->link(__('Set New Password'), ['action' => 'password', $user->id], ['class' => 'btn btn-warning mr-2']) ?>
                        <?= $this->Form->button(__('Save'), ['class' => 'btn btn-primary mr-2']) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $user->id],
                            ['confirm' => __('Are you sure you want to delete {0} {1}? This will completely erase all associated data.', $user->first_name, $user->last_name), 'class' => 'btn btn-danger']
                        ) ?>
                    </div>
                </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>
