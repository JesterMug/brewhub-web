<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
echo $this->Html->css('/vendor/datatables/dataTables.bootstrap4.min.css', ['block' => true]);
echo $this->Html->script('/vendor/datatables/jquery.dataTables.min.js', ['block' => true]);
echo $this->Html->script('/vendor/datatables/dataTables.bootstrap4.min.js', ['block' => true]);
?>
<div class="row">
    <div class="column column-80">
        <div class="users view content">
            <h3><?= h($user->first_name) ?></h3>
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <tr>
                    <th><?= __('First Name') ?></th>
                    <td><?= h($user->first_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Last Name') ?></th>
                    <td><?= h($user->last_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Email') ?></th>
                    <td><?= h($user->email) ?></td>
                </tr>
                <tr>
                    <th><?= __('User Type') ?></th>
                    <td><?= h($user->user_type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Date Created') ?></th>
                    <td><?= h($user->date_created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Date Modified') ?></th>
                    <td><?= h($user->date_modified) ?></td>
                </tr>
            </table>
            <div class="side-nav">
                <?php if ($user->user_type != 'superuser') : ?>
                    <?= $this->Html->link(__('Edit User'), ['action' => 'edit', $user->id], ['class' => 'side-nav-item']) ?>
                    <?= $this->Form->postLink(__('Delete User'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id), 'class' => 'side-nav-item']) ?>
                <?php endif; ?>
                <?= $this->Html->link(__('List Users'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            </div>
            <div class="related">
                <?php if (!empty($user->addresses)) : ?>
                <h4><?= __('Related Addresses') ?></h4>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
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
                <?php endif; ?>
            </div>
            <div class="related">
                <?php if (!empty($user->carts)) : ?>
                <h4><?= __('Related Carts') ?></h4>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
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
                <?php endif; ?>
            </div>
            <div class="related">
                <?php if (!empty($user->orders)) : ?>
                <h4><?= __('Related Orders') ?></h4>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
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
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
