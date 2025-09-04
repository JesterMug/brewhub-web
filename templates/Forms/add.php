<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Form $form
 */
?>
<?= $this->Form->create($form) ?>
    <fieldset>
        <legend><?= __('Add Form') ?></legend>
        <?php
        echo $this->Form->control('first_name');
        echo $this->Form->control('last_name');
        echo $this->Form->control('email');
        echo $this->Form->control('message');
        ?>
    </fieldset>
<?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']) ?>
<?= $this->Form->end() ?>
