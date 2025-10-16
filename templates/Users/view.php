<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
echo $this->Html->css('/vendor/datatables/dataTables.bootstrap4.min.css', ['block' => true]);
echo $this->Html->script('/vendor/datatables/jquery.dataTables.min.js', ['block' => true]);
echo $this->Html->script('/vendor/datatables/dataTables.bootstrap4.min.js', ['block' => true]);
?>

<style>
    .card-header .subtitle { font-size: 0.9rem; color: #6c757d; }
</style>

<div class="row justify-content-center">
    <div class="col-12 col-lg-10">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-0">
                        <?= h($user->first_name) ?> <?= h($user->last_name) ?>
                    </h4>
                    <?php if (!empty($user->email)) : ?>
                        <div class="subtitle">
                            <?= $this->Html->link(h($user->email), 'mailto:' . h($user->email)) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="text-right">
                    <?php if (!empty($user->user_type)) : ?>
                        <span class="badge badge-info text-uppercase"><?= h($user->user_type) ?></span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped table-hover mb-0" id="dataTable">
                    <tbody>
                        <tr>
                            <th style="width: 220px;" class="align-middle"><?= __('First Name') ?></th>
                            <td><?= h($user->first_name) ?></td>
                        </tr>
                        <tr>
                            <th class="align-middle"><?= __('Last Name') ?></th>
                            <td><?= h($user->last_name) ?></td>
                        </tr>
                        <tr>
                            <th class="align-middle"><?= __('Email') ?></th>
                            <td><?= !empty($user->email) ? $this->Html->link(h($user->email), 'mailto:' . h($user->email)) : '<span class="text-muted">' . __('N/A') . '</span>' ?></td>
                        </tr>
                        <tr>
                            <th class="align-middle"><?= __('User Type') ?></th>
                            <td>
                                <?php if (!empty($user->user_type)) : ?>
                                    <span class="badge badge-pill badge-primary text-uppercase">
                                        <?= h($user->user_type) ?>
                                    </span>
                                <?php else: ?>
                                    <span class="text-muted"><?= __('N/A') ?></span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <th class="align-middle"><?= __('Date Created') ?></th>
                            <td>
                                <?php
                                $created = $user->date_created ?? null;
                                echo $created ? $this->Time->nice($created) : '<span class="text-muted">' . __('N/A') . '</span>';
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th class="align-middle"><?= __('Date Modified') ?></th>
                            <td>
                                <?php
                                $modified = $user->date_modified ?? null;
                                echo $modified ? $this->Time->nice($modified) : '<span class="text-muted">' . __('N/A') . '</span>';
                                ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <?= $this->Html->link(__('« Back to Users'), ['action' => 'index'], ['class' => 'btn btn-outline-secondary']) ?>
            </div>
            <div>
                <?php if ($user->user_type != 'superuser') : ?>
                    <?= $this->Html->link(__('Edit User'), ['action' => 'edit', $user->id], ['class' => 'btn btn-primary mr-2']) ?>
                    <?= $this->Form->postLink(
                        __('Delete User'),
                        ['action' => 'delete', $user->id],
                        [
                            'confirm' => __('Are you sure you want to delete # {0}?', $user->id),
                            'class' => 'btn btn-danger'
                        ]
                    ) ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="related">
            <?php if (!empty($user->addresses)) : ?>
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white"><strong><?= __('Related Addresses') ?></strong></div>
                <div class="card-body p-0">
                    <div class="table-responsive mb-0">
                        <table class="table table-bordered mb-0" id="dataTable" width="100%" cellspacing="0">
                            <tr>
                                <th><?= __('Id') ?></th>
                                <th><?= __('Label') ?></th>
                                <th><?= __('Recipient Full Name') ?></th>
                                <th><?= __('Recipient Phone') ?></th>
                                <th><?= __('Property Type') ?></th>
                                <th><?= __('Street') ?></th>
                                <th><?= __('Building') ?></th>
                                <th><?= __('City') ?></th>
                                <th><?= __('State') ?></th>
                                <th><?= __('Postcode') ?></th>
                                <th><?= __('Is Active') ?></th>
                                <th><?= __('User Id') ?></th>
                                <th class="actions"><?= __('Actions') ?></th>
                            </tr>
                            <?php foreach ($user->addresses as $address) : ?>
                            <tr>
                                <td><?= h($address->id) ?></td>
                                <td><?= h($address->label) ?></td>
                                <td><?= h($address->recipient_full_name) ?></td>
                                <td><?= h($address->recipient_phone) ?></td>
                                <td><?= h($address->property_type) ?></td>
                                <td><?= h($address->street) ?></td>
                                <td><?= h($address->building) ?></td>
                                <td><?= h($address->city) ?></td>
                                <td><?= h($address->state) ?></td>
                                <td><?= h($address->postcode) ?></td>
                                <td><?= h($address->is_active) ?></td>
                                <td><?= h($address->user_id) ?></td>
                                <td class="actions">
                                    <?= $this->Html->link(__('View'), ['controller' => 'Addresses', 'action' => 'view', $address->id]) ?>
                                    <?= $this->Html->link(__('Edit'), ['controller' => 'Addresses', 'action' => 'edit', $address->id]) ?>
                                    <?= $this->Form->postLink(
                                        __('Delete'),
                                        ['controller' => 'Addresses', 'action' => 'delete', $address->id],
                                        [
                                            'method' => 'delete',
                                            'confirm' => __('Are you sure you want to delete # {0}?', $address->id),
                                        ]
                                    ) ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <div class="related">
            <?php if (!empty($user->carts)) : ?>
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white"><strong><?= __('Related Carts') ?></strong></div>
                <div class="card-body p-0">
                    <div class="table-responsive mb-0">
                        <table class="table table-bordered mb-0" id="dataTable" width="100%" cellspacing="0">
                            <tr>
                                <th><?= __('Id') ?></th>
                                <th><?= __('User Id') ?></th>
                                <th><?= __('Address Id') ?></th>
                                <th><?= __('Status') ?></th>
                                <th><?= __('Date Created') ?></th>
                                <th><?= __('Date Modified') ?></th>
                                <th class="actions"><?= __('Actions') ?></th>
                            </tr>
                            <?php foreach ($user->carts as $cart) : ?>
                            <tr>
                                <td><?= h($cart->id) ?></td>
                                <td><?= h($cart->user_id) ?></td>
                                <td><?= h($cart->address_id) ?></td>
                                <td><?= h($cart->status) ?></td>
                                <td><?= h($cart->date_created) ?></td>
                                <td><?= h($cart->date_modified) ?></td>
                                <td class="actions">
                                    <?= $this->Html->link(__('View'), ['controller' => 'Carts', 'action' => 'view', $cart->id]) ?>
                                    <?= $this->Html->link(__('Edit'), ['controller' => 'Carts', 'action' => 'edit', $cart->id]) ?>
                                    <?= $this->Form->postLink(
                                        __('Delete'),
                                        ['controller' => 'Carts', 'action' => 'delete', $cart->id],
                                        [
                                            'method' => 'delete',
                                            'confirm' => __('Are you sure you want to delete # {0}?', $cart->id),
                                        ]
                                    ) ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <div class="related">
            <?php if (!empty($user->orders)) : ?>
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white"><strong><?= __('Related Orders') ?></strong></div>
                <div class="card-body p-0">
                    <div class="table-responsive mb-0">
                        <table class="table table-bordered mb-0" id="dataTable" width="100%" cellspacing="0">
                            <tr>
                                <th><?= __('Id') ?></th>
                                <th><?= __('User Id') ?></th>
                                <th><?= __('Address Id') ?></th>
                                <th><?= __('Order Date') ?></th>
                                <th><?= __('Shipping Status') ?></th>
                                <th class="actions"><?= __('Actions') ?></th>
                            </tr>
                            <?php foreach ($user->orders as $order) : ?>
                            <tr>
                                <td><?= h($order->id) ?></td>
                                <td><?= h($order->user_id) ?></td>
                                <td><?= h($order->address_id) ?></td>
                                <td><?= h($order->order_date) ?></td>
                                <td><?= h($order->shipping_status) ?></td>
                                <td class="actions">
                                    <?= $this->Html->link(__('View'), ['controller' => 'Orders', 'action' => 'view', $order->id]) ?>
                                    <?= $this->Html->link(__('Edit'), ['controller' => 'Orders', 'action' => 'edit', $order->id]) ?>
                                    <?= $this->Form->postLink(
                                        __('Delete'),
                                        ['controller' => 'Orders', 'action' => 'delete', $order->id],
                                        [
                                            'method' => 'delete',
                                            'confirm' => __('Are you sure you want to delete # {0}?', $order->id),
                                        ]
                                    ) ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
