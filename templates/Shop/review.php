<?php
/** @var \App\View\AppView $this */
/** @var array $addresses */
/** @var array $cartItems */
?>
<header>
    <div class="py-4"></div>
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">Review & Address</h1>
            <p class="lead">Confirm your items and provide a shipping address</p>
        </div>
    </div>
</header>
<div class="container my-4">
    <?= $this->Flash->render() ?>
    <div class="row">
        <div class="col-lg-7">
            <div class="card border shadow-none mb-4">
                <div class="card-body">
                    <h5 class="mb-3">Shipping Address</h5>

                    <?= $this->Form->create($address ?? null, ['url' => ['controller' => 'Shop', 'action' => 'review'], 'class' => 'mb-3']) ?>

                    <?php if (!empty($addresses)): ?>
                        <div class="mb-3">
                            <label class="form-label">Choose an existing address</label>
                            <select name="address_id" id="addressSelect" class="form-select">
                                <option value="">-- Select --</option>
                                <?php foreach ($addresses as $addr): ?>
                                    <option value="<?= (int)$addr->id ?>">
                                        <?= h(($addr->label ?: 'Address') . ' — ' . $addr->street . ', ' . $addr->city . ' ' . $addr->state . ' ' . $addr->postcode) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="form-text">Or add a new address below.</div>
                        </div>
                    <?php endif; ?>

                    <input type="hidden" id="createNewInput" name="create_new" value="1" />

                    <div id="newAddressFields" class="row g-3">
                        <?php if ($this->Identity->isLoggedIn()): ?>
                            <div class="col-md-6">
                                <?= $this->Form->control('label', ['label' => 'Label (optional)', 'class' => 'form-control', 'required' => false, 'maxlength' => 63]) ?>
                            </div>
                        <?php endif; ?>
                        <div class="col-md-6">
                            <?= $this->Form->control('recipient_full_name', ['label' => 'Full name', 'class' => 'form-control', 'required' => true, 'maxlength' => 100, 'pattern' => "^[A-Za-zÀ-ÖØ-öø-ÿ' -]{2,100}$", 'title' => 'Use letters, spaces, hyphens or apostrophes only', 'autocomplete' => 'name']) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $this->Form->control('recipient_phone', ['label' => 'Phone', 'class' => 'form-control', 'required' => true, 'maxlength' => 20, 'pattern' => '^[0-9\s+().-]{6,20}$', 'inputmode' => 'tel', 'title' => 'Use 6-20 digits; allowed: spaces, +, (), . and -', 'autocomplete' => 'tel']) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $this->Form->control('property_type', ['label' => 'Property Type', 'class' => 'form-control', 'required' => true, 'options' => ['House' => 'House', 'Apartment' => 'Apartment', 'Business' => 'Business', 'Other' => 'Other']]) ?>
                        </div>
                        <div class="col-12">
                            <?= $this->Form->control('street', ['label' => 'Street', 'class' => 'form-control', 'required' => true, 'maxlength' => 255, 'autocomplete' => 'address-line1']) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $this->Form->control('building', ['label' => 'Building (optional)', 'class' => 'form-control', 'required' => false, 'maxlength' => 100, 'autocomplete' => 'address-line2']) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $this->Form->control('city', ['label' => 'City/Suburb', 'class' => 'form-control', 'required' => true, 'maxlength' => 100, 'pattern' => "^[A-Za-zÀ-ÖØ-öø-ÿ' -]{2,100}$", 'title' => 'Use letters, spaces, hyphens or apostrophes only']) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $this->Form->control('state', ['label' => 'State', 'class' => 'form-control', 'required' => true, 'options' => ['NSW' => 'NSW', 'VIC' => 'VIC', 'QLD' => 'QLD', 'SA' => 'SA', 'WA' => 'WA', 'TAS' => 'TAS', 'ACT' => 'ACT', 'NT' => 'NT']]) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $this->Form->control('postcode', ['label' => 'Postcode', 'class' => 'form-control', 'required' => true, 'maxlength' => 4, 'pattern' => '^\d{4}$', 'inputmode' => 'numeric', 'title' => 'Enter 4 digits']) ?>
                            <div class="form-text text-white">Digits only, 4 numbers.</div>
                        </div>
                    </div>

                    <div class="mt-3 text-end">
                        <button type="submit" class="btn btn-primary">Continue to payment</button>
                    </div>

                    <script>
                        (function() {
                            const select = document.getElementById('addressSelect');
                            const createNew = document.getElementById('createNewInput');
                            const fields = document.getElementById('newAddressFields');
                            function setDisabled(container, disabled) {
                                if (!container) return;
                                const inputs = container.querySelectorAll('input, select, textarea');
                                inputs.forEach(el => {
                                    // Don't disable the address select itself
                                    if (el.id === 'addressSelect' || el.name === 'address_id') return;
                                    el.disabled = !!disabled;
                                });
                            }
                            function toggle() {
                                if (!select) return;
                                const hasSelection = !!select.value;
                                if (hasSelection) {
                                    if (fields) fields.style.display = 'none';
                                    if (createNew) createNew.value = '0';
                                    setDisabled(fields, true);
                                } else {
                                    if (fields) fields.style.display = '';
                                    if (createNew) createNew.value = '1';
                                    setDisabled(fields, false);
                                }
                            }
                            if (select) {
                                select.addEventListener('change', toggle);
                                // Initial state on load
                                toggle();
                            }
                        })();
                    </script>

                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card border shadow-none">
                <div class="card-body">
                    <h5 class="mb-3">Order Summary</h5>
                    <?php if (!empty($cartItems)): foreach ($cartItems as $item): $variant = $item->product_variant ?? null; $product = $variant->product ?? null; ?>
                        <div class="d-flex justify-content-between small mb-2">
                            <div>
                                <?= h($product->name ?? 'Item') ?> x <?= (int)($item->quantity ?? 1) ?>
                                <?php if (!empty($item->is_preorder)): ?><span class="badge bg-info ms-1">Pre-Order</span><?php endif; ?>
                            </div>
                            <div>
                                $<?= number_format((float)($variant->price ?? 0) * (int)($item->quantity ?? 1), 2) ?>
                            </div>
                        </div>
                    <?php endforeach; endif; ?>
                    <div class="text-muted small mt-2">Shipping will be calculated later if applicable.</div>
                </div>
            </div>
        </div>
    </div>
</div>
