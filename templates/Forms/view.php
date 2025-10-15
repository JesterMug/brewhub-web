<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Form $form
 */
echo $this->Html->css('/vendor/datatables/dataTables.bootstrap4.min.css', ['block' => true]);
echo $this->Html->script('/vendor/datatables/jquery.dataTables.min.js', ['block' => true]);
echo $this->Html->script('/vendor/datatables/dataTables.bootstrap4.min.js', ['block' => true]);
?>

<style>
    /* Subtle improvements for readability */
    .card-header .subtitle { font-size: 0.9rem; color: #6c757d; }
    blockquote { border-left: 4px solid #e9ecef; padding-left: 1rem; color: #495057; }
</style>

<div class="row justify-content-center">
    <div class="col-12 col-lg-10">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-0">
                        <?= h($form->first_name) ?> <?= h($form->last_name) ?>
                    </h4>
                    <?php if (!empty($form->email)) : ?>
                        <div class="subtitle">
                            <?= $this->Html->link(h($form->email), 'mailto:' . h($form->email)) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="text-right">
                    <?php if ($form->replied_status) : ?>
                        <span class="badge badge-success"><?= __('Replied') ?></span>
                    <?php else : ?>
                        <span class="badge badge-secondary"><?= __('Not Replied') ?></span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped table-hover mb-0" id="dataTable">
                    <tbody>
                        <tr>
                            <th style="width: 220px;" class="align-middle"><?= __('Replied Status') ?></th>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="mr-3">
                                        <?php if ($form->replied_status) : ?>
                                            <span class="badge badge-success"><?= __('Replied') ?></span>
                                        <?php else : ?>
                                            <span class="badge badge-secondary"><?= __('Not Replied') ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <div>
                                        <?= $this->Form->create($form, ['url' => ['action' => 'mark', $form->id]]) ?>
                                        <?= $this->Form->control('replied_status', [
                                            'type' => 'checkbox',
                                            'label' => __('Toggle'),
                                            'checked' => (bool)$form->replied_status,
                                            'onchange' => 'this.form.submit();',
                                            'class' => 'form-check-input',
                                            'templates' => [
                                                'inputContainer' => '<div class="form-check">{{content}}</div>',
                                                'checkboxWrapper' => '<div class="form-check">{{label}}</div>',
                                                'checkboxFormGroup' => '{{label}}',
                                                'nestingLabel' => '<label class="form-check-label">{{input}}{{text}}</label>'
                                            ]
                                        ]) ?>
                                        <?= $this->Form->end() ?>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th class="align-middle"><?= __('Date Created') ?></th>
                            <td>
                                <?php
                                $created = $form->date_created ?? null;
                                echo $created ? $this->Time->nice($created) : '<span class="text-muted">' . __('N/A') . '</span>';
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th class="align-middle"><?= __('Date Replied') ?></th>
                            <td>
                                <?php
                                $replied = $form->date_replied ?? null;
                                echo $replied ? $this->Time->nice($replied) : '<span class="text-muted">' . __('N/A') . '</span>';
                                ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white">
                <strong><?= __('Message') ?></strong>
            </div>
            <div class="card-body">
                <blockquote class="mb-0">
                    <?= $this->Text->autoParagraph(h($form->message)); ?>
                </blockquote>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <?= $this->Html->link(__('« Back to Forms'), ['action' => 'index'], ['class' => 'btn btn-outline-secondary']) ?>
            </div>
            <div>
                <?= $this->Form->postLink(
                    __('Delete Form'),
                    ['action' => 'delete', $form->id],
                    [
                        'confirm' => __('Are you sure you want to delete # {0}?', $form->id),
                        'class' => 'btn btn-danger'
                    ]
                ) ?>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            searching: false,
            paging: false,
            info: false,
            ordering: false
        });
    });
</script>
