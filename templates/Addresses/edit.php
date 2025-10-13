<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Address $address
 */
?>

<?php // This template is rendered inside templates/layout/frontend.php ?>

<header>
    <div class="py-5"></div>
    <div class="container px-lg-5 my-4">
        <div class="text-center text-white">
            <h1 class="display-6 fw-bolder">Edit Address</h1>
            <p class="lead">Update your delivery details</p>
        </div>
    </div>
</header>

<div class="container my-5">
    <?= $this->Flash->render() ?>

    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <?= $this->Form->create($address, ['novalidate' => true]) ?>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <?= $this->Form->control('label', [
                                'label' => 'Label (optional)',
                                'class' => 'form-control',
                                'maxlength' => 63,
                                'placeholder' => 'Home, Office, etc.'
                            ]) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $this->Form->control('property_type', [
                                'label' => 'Property Type',
                                'class' => 'form-select',
                                'options' => ['House' => 'House', 'Apartment' => 'Apartment', 'Business' => 'Business', 'Other' => 'Other'],
                                'empty' => 'Select type',
                                'required' => true,
                                'value' => ucfirst(strtolower((string)$address->property_type))
                            ]) ?>
                        </div>

                        <div class="col-md">
                            <?= $this->Form->control('recipient_full_name', [
                                'label' => 'Recipient Full Name',
                                'class' => 'form-control',
                                'maxlength' => 100,
                                'required' => true,
                                'pattern' => "[A-Za-zÀ-ÖØ-öø-ÿ' -]{2,100}",
                                'title' => "Only letters, spaces, hyphens or apostrophes; 2-100 chars"
                            ]) ?>
                        </div>

                        <div class="col-md-6">
                            <?= $this->Form->control('recipient_phone', [
                                'label' => 'Recipient Phone',
                                'class' => 'form-control',
                                'maxlength' => 20,
                                'required' => true,
                                'pattern' => "[0-9\s\+\-\(\)\.]{6,20}",
                                'title' => '6-20 digits; spaces, +, (), . and - allowed'
                            ]) ?>
                        </div>

                        <div class="col-12">
                            <?= $this->Form->control('street', [
                                'label' => 'Street Address',
                                'class' => 'form-control',
                                'maxlength' => 255,
                                'required' => true,
                                'placeholder' => 'Street and number'
                            ]) ?>
                        </div>

                        <div class="col-md-6">
                            <?= $this->Form->control('building', [
                                'label' => 'Building, Apartment, Suite (optional)',
                                'class' => 'form-control',
                                'maxlength' => 100,
                                'placeholder' => 'Apartment, suite, unit, etc.'
                            ]) ?>
                        </div>

                        <div class="col-md-6">
                            <?= $this->Form->control('city', [
                                'label' => 'City/Suburb',
                                'class' => 'form-control',
                                'maxlength' => 100,
                                'required' => true,
                                'pattern' => "[A-Za-zÀ-ÖØ-öø-ÿ' -]{2,100}",
                                'title' => "Only letters, spaces, hyphens or apostrophes; 2-100 chars"
                            ]) ?>
                        </div>

                        <div class="col-md">
                            <?= $this->Form->control('state', [
                                'label' => 'State',
                                'class' => 'form-select',
                                'options' => ['NSW' => 'NSW', 'VIC' => 'VIC', 'QLD' => 'QLD', 'SA' => 'SA', 'WA' => 'WA', 'TAS' => 'TAS', 'ACT' => 'ACT', 'NT' => 'NT'],
                                'empty' => 'Select state',
                                'required' => true
                            ]) ?>
                        </div>
                        <div class="col-md">
                            <?= $this->Form->control('postcode', [
                                'label' => 'Postcode',
                                'class' => 'form-control',
                                'required' => true,
                                'pattern' => "\\d{4}",
                                'title' => '4-digit postcode',
                                'maxlength' => 4,
                                'inputmode' => 'numeric'
                            ]) ?>
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <a href="<?= $this->Url->build(['controller' => 'Profile', 'action' => 'addresses']) ?>" class="btn btn-outline-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update Address</button>
                    </div>

                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>
    </div>
</div>
