<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\User> $users
 */

echo $this->Html->css('/vendor/datatables/dataTables.bootstrap4.min.css', ['block' => true]);
echo $this->Html->script('/vendor/datatables/jquery.dataTables.min.js', ['block' => true]);
echo $this->Html->script('/vendor/datatables/dataTables.bootstrap4.min.js', ['block' => true]);
?>
<div class="users index content">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= __('Users') ?></h1>
        <a href="<?= $this->Url->build(['action' => 'add']) ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-plus fa-sm text-white-50"></i> New User</a>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th><?= h('Full Name') ?></th>
                    <th><?= h('Email') ?></th>
                    <th><?= h('User Type') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= h($user->first_name), ' ', h($user->last_name) ?></td>
                    <td><?= h($user->email) ?></td>
                    <td><?= h($user->user_type) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $user->id]) ?>
                        <?php if ($user->user_type != 'superuser') : ?>
                            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $user->id]) ?>
                            <?= $this->Form->postLink(
                                __('Delete'),
                                ['action' => 'delete', $user->id],
                                [
                                    'method' => 'delete',
                                    'confirm' => __('Are you sure you want to delete # {0}?', $user->id),
                                ]
                            ) ?>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>
</div>
