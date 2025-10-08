<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Address $address
 */
?>
<header>
    <div class="py-5"></div>
    <div class="container px-4 px-lg-5 my-4">
        <div class="text-center text-white">
            <h1 class="display-6 fw-bolder">Add Address</h1>
            <p class="lead">Provide your shipping details</p>
        </div>
    </div>
</header>

<div class="container my-5">
    <?= $this->Flash->render() ?>

    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <?= $this->Form->create($address) ?>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <?= $this->Form->label('label', 'Label (optional)') ?>
                            <?= $this->Form->text('label', [
                                'class' => 'form-control',
                                'maxlength' => 63,
                                'placeholder' => 'Home, Work, etc.'
                            ]) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $this->Form->label('recipient_full_name', 'Recipient Full Name') ?>
                            <?= $this->Form->text('recipient_full_name', [
                                'class' => 'form-control',
                                'required' => true,
                                'maxlength' => 127,
                                'pattern' => "^[\p{L}\s'\-]+$",
                                'title' => "Only letters, spaces, hyphens, and apostrophes allowed"
                            ]) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $this->Form->label('recipient_phone', 'Recipient Phone') ?>
                            <?= $this->Form->text('recipient_phone', [
                                'class' => 'form-control',
                                'required' => true,
                                'maxlength' => 23,
                                'pattern' => '^[+()\d\s-]{8,20}$',
                                'inputmode' => 'tel',
                                'title' => 'Enter a valid phone number'
                            ]) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $this->Form->label('property_type', 'Property Type') ?>
                            <?= $this->Form->select('property_type', [
                                'House' => 'House',
                                'Apartment' => 'Apartment',
                                'Business' => 'Business',
                                'PO Box' => 'PO Box',
                                'Other' => 'Other',
                            ], [
                                'class' => 'form-select',
                                'required' => true
                            ]) ?>
                        </div>
                        <div class="col-md-8">
                            <?= $this->Form->label('street', 'Street Address') ?>
                            <?= $this->Form->text('street', [
                                'class' => 'form-control',
                                'required' => true,
                                'maxlength' => 255,
                                'placeholder' => '123 Example St'
                            ]) ?>
                        </div>
                        <div class="col-md-4">
                            <?= $this->Form->label('building', 'Building/Unit (optional)') ?>
                            <?= $this->Form->text('building', [
                                'class' => 'form-control',
                                'maxlength' => 100,
                                'placeholder' => 'Unit/Suite'
                            ]) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $this->Form->label('city', 'City/Suburb') ?>
                            <?= $this->Form->text('city', [
                                'class' => 'form-control',
                                'required' => true,
                                'maxlength' => 100,
                                'pattern' => "^[\p{L}\s'\-]+$",
                                'title' => "Only letters, spaces, hyphens, and apostrophes allowed"
                            ]) ?>
                        </div>
                        <div class="col-md-3">
                            <?= $this->Form->label('state', 'State') ?>
                            <?= $this->Form->select('state', [
                                'ACT' => 'ACT', 'NSW' => 'NSW', 'NT' => 'NT', 'QLD' => 'QLD', 'SA' => 'SA', 'TAS' => 'TAS', 'VIC' => 'VIC', 'WA' => 'WA'
                            ], [
                                'class' => 'form-select',
                                'required' => true
                            ]) ?>
                        </div>
                        <div class="col-md-3">
                            <?= $this->Form->label('postcode', 'Postcode') ?>
                            <?= $this->Form->text('postcode', [
                                'class' => 'form-control',
                                'required' => true,
                                'maxlength' => 4,
                                'pattern' => '^\d{4}$',
                                'inputmode' => 'numeric',
                                'title' => '4-digit postcode'
                            ]) ?>
                        </div>
                        <div class="col-12">
                            <div class="form-check">
                                <?= $this->Form->checkbox('is_active', ['class' => 'form-check-input', 'checked' => true]) ?>
                                <?= $this->Form->label('is_active', 'Set as active address', ['class' => 'form-check-label']) ?>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex gap-2 mt-4">
                        <a href="<?= $this->Url->build(['controller' => 'Profile', 'action' => 'addresses']) ?>" class="btn btn-outline-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Save Address</button>
                    </div>
                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>
    </div>
</div>
