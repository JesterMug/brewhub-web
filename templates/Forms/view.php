<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Form $form
 */
echo $this->Html->css('/vendor/datatables/dataTables.bootstrap4.min.css', ['block' => true]);
echo $this->Html->script('/vendor/datatables/jquery.dataTables.min.js', ['block' => true]);
echo $this->Html->script('/vendor/datatables/dataTables.bootstrap4.min.js', ['block' => true]);
?>
<div class="row">
    <div class="column column-80">
        <div class="forms view content">
            <h3><?= h($form->first_name), ' ', h($form->last_name) ?></h3>
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <tr>
                    <th><?= __('Email') ?></th>
                    <td><?= h($form->email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Replied Status') ?></th>
                    <td>
                        <?php if ($form->replied_status) : ?>
                            <?= $this->Form->create($form, ['url' => ['action' => 'mark', $form->id]]) ?>
                            <?= $this->Form->control('replied_status', [
                                'type' => 'checkbox',
                                'label' => ' ',
                                'checked' => true,
                                'onchange' => 'this.form.submit();',
                            ]) ?>
                            <?= $this->Form->end() ?>
                        <?php else : ?>
                            <?= $this->Form->create($form, ['url' => ['action' => 'mark', $form->id]]) ?>
                            <?= $this->Form->control('replied_status', [
                                'type' => 'checkbox',
                                'label' => ' ',
                                'checked' => false,
                                'onchange' => 'this.form.submit();',
                            ]) ?>
                            <?= $this->Form->end() ?>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th><?= __('Date Created') ?></th>
                    <td><?= h($form->date_created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Date Replied') ?></th>
                    <td><?= h($form->date_replied) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Message') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($form->message)); ?>
                </blockquote>
            </div>
        </div>
        <div class="side-nav">
            <?= $this->Form->postLink(__('Delete Form'), ['action' => 'delete', $form->id], ['confirm' => __('Are you sure you want to delete # {0}?', $form->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Forms'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>
</div>
