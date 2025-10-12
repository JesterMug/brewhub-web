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
            <p class="lead">Enter a new shipping address</p>
        </div>
    </div>
</header>

<div class="container my-5">
    <?= $this->Flash->render() ?>
    <div class="row justify-content-center">
        <div class="col-lg-8 col-xl-7">
            <div class="card shadow-sm">
                <div class="card-body">
                    <?= $this->Form->create($address, ['class' => 'needs-validation', 'novalidate' => true]) ?>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <?= $this->Form->label('label', 'Address Label (optional)') ?>
                            <?= $this->Form->text('label', ['class' => 'form-control', 'maxlength' => 63, 'placeholder' => 'Home, Office']) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $this->Form->label('property_type', 'Property Type') ?>
                            <?= $this->Form->select('property_type', [
                                'house' => 'House',
                                'apartment' => 'Apartment/Unit',
                                'business' => 'Business',
                                'other' => 'Other',
                            ], ['class' => 'form-select', 'required' => true]) ?>
                        </div>

                        <div class="col-md-6">
                            <?= $this->Form->label('recipient_full_name', 'Recipient Full Name') ?>
                            <?= $this->Form->text('recipient_full_name', [
                                'class' => 'form-control',
                                'required' => true,
                                'maxlength' => 127,
                                'pattern' => "[\p{L}0-9 .,'-]+",
                                'title' => 'Letters, numbers, spaces and - , . allowed'
                            ]) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $this->Form->label('recipient_phone', 'Recipient Phone') ?>
                            <?= $this->Form->tel('recipient_phone', [
                                'class' => 'form-control',
                                'required' => true,
                                'maxlength' => 23,
                                'pattern' => '^[0-9 +()-]{8,23}$',
                                'inputmode' => 'tel',
                                'title' => 'Enter a valid phone number'
                            ]) ?>
                        </div>

                        <div class="col-12">
                            <?= $this->Form->label('street', 'Street Address') ?>
                            <?= $this->Form->text('street', ['class' => 'form-control', 'required' => true, 'maxlength' => 255, 'placeholder' => 'e.g., 123 Main St']) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $this->Form->label('building', 'Building, Apartment, Suite (optional)') ?>
                            <?= $this->Form->text('building', ['class' => 'form-control', 'maxlength' => 100]) ?>
                        </div>

                        <div class="col-md-6">
                            <?= $this->Form->label('city', 'City/Suburb') ?>
                            <?= $this->Form->text('city', ['class' => 'form-control', 'required' => true, 'maxlength' => 100]) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $this->Form->label('state', 'State') ?>
                            <?= $this->Form->select('state', [
                                'ACT' => 'ACT', 'NSW' => 'NSW', 'NT' => 'NT', 'QLD' => 'QLD', 'SA' => 'SA', 'TAS' => 'TAS', 'VIC' => 'VIC', 'WA' => 'WA'
                            ], ['class' => 'form-select', 'required' => true]) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $this->Form->label('postcode', 'Postcode') ?>
                            <?= $this->Form->text('postcode', [
                                'class' => 'form-control',
                                'required' => true,
                                'maxlength' => 4,
                                'pattern' => '^[0-9]{4}$',
                                'inputmode' => 'numeric',
                                'title' => '4-digit postcode'
                            ]) ?>
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
