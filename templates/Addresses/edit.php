<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Address $address
 */
$this->assign('title', 'Edit Address');
?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white border-0 py-3 d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Edit Shipping Address</h5>
                <div>
                    <?= $this->Form->postLink('<i class="fas fa-trash-alt me-1"></i> Delete', ['action' => 'delete', $address->id], [
                        'escape' => false,
                        'class' => 'btn btn-link btn-sm text-danger',
                        'confirm' => __('Are you sure you want to delete this address?')
                    ]) ?>
                    <a href="<?= $this->Url->build(['action' => 'index']) ?>" class="btn btn-link btn-sm text-muted">Manage Addresses</a>
                </div>
            </div>
            <div class="card-body">
                <?= $this->Form->create($address, ['class' => 'needs-validation']) ?>
                <div class="row g-3">
                    <div class="col-md-6">
                        <?= $this->Form->control('label', ['label' => 'Address Label', 'class' => 'form-control']) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $this->Form->control('recipient_full_name', ['label' => 'Recipient Full Name', 'class' => 'form-control']) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $this->Form->control('recipient_phone', ['label' => 'Recipient Phone', 'class' => 'form-control']) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $this->Form->control('property_type', ['label' => 'Property Type', 'class' => 'form-select']) ?>
                    </div>
                    <div class="col-md-8">
                        <?= $this->Form->control('street', ['label' => 'Street Address', 'class' => 'form-control']) ?>
                    </div>
                    <div class="col-md-4">
                        <?= $this->Form->control('building', ['label' => 'Apt / Unit / Building', 'class' => 'form-control']) ?>
                    </div>
                    <div class="col-md-5">
                        <?= $this->Form->control('city', ['label' => 'City/Suburb', 'class' => 'form-control']) ?>
                    </div>
                    <div class="col-md-5">
                        <?= $this->Form->control('state', ['label' => 'State', 'class' => 'form-control']) ?>
                    </div>
                    <div class="col-md-2">
                        <?= $this->Form->control('postcode', ['label' => 'Postcode', 'class' => 'form-control']) ?>
                    </div>
                    <div class="col-md-12">
                        <div class="form-check">
                            <?= $this->Form->control('is_active', [
                                'type' => 'checkbox',
                                'label' => 'Active',
                                'class' => 'form-check-input',
                                'hiddenField' => false,
                                'templates' => [
                                    'checkboxContainer' => '<div class="form-check">{{content}}</div>',
                                    'checkbox' => '<input type="checkbox" name="{{name}}" value="{{value}}"{{attrs}}/>',
                                    'checkboxFormGroup' => '{{label}}'
                                ]
                            ]) ?>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-4">
                    <a href="<?= $this->Url->build(['action' => 'index']) ?>" class="btn btn-outline-secondary me-2">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>
