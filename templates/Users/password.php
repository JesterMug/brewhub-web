<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>

<div class="row justify-content-center">
    <div class="col-12 col-lg-6">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white">
                <h4 class="mb-0"><?= __('Set New Password') ?></h4>
            </div>
            <div class="card-body">
                <p class="text-muted"><?= __('Setting a new password for: {0} {1} ({2})', h($user->first_name), h($user->last_name), h($user->email)) ?></p>
                <?= $this->Form->create(null, ['url' => ['action' => 'password', $user->id], 'autocomplete' => 'off']) ?>
                <div class="form-group">
                    <?= $this->Form->control('password', [
                        'type' => 'password',
                        'label' => __('New Password'),
                        'class' => 'form-control',
                        'value' => '',
                        'autocomplete' => 'new-password',
                    ]) ?>
                </div>
                <div class="form-group">
                    <?= $this->Form->control('confirm_password', [
                        'type' => 'password',
                        'label' => __('Confirm New Password'),
                        'class' => 'form-control',
                        'value' => '',
                        'autocomplete' => 'new-password',
                    ]) ?>
                </div>
                <div class="d-flex justify-content-between mt-3">
                    <?= $this->Html->link(__('Cancel'), ['action' => 'view', $user->id], ['class' => 'btn btn-outline-secondary']) ?>
                    <?= $this->Form->button(__('Save New Password'), ['class' => 'btn btn-primary']) ?>
                </div>
                <?= $this->Form->end() ?>
                <div class="mt-3 text-muted" style="font-size: 0.9rem;">
                    <?= __('Password must be at least 8 characters and sufficiently strong.') ?>
                </div>
            </div>
        </div>
    </div>
</div>
