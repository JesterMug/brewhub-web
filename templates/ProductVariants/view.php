<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ProductVariant $productVariant
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Product Variant'), ['action' => 'edit', $productVariant->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Product Variant'), ['action' => 'delete', $productVariant->id], ['confirm' => __('Are you sure you want to delete # {0}?', $productVariant->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Product Variants'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Product Variant'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="productVariants view content">
            <h3><?= h($productVariant->size) ?></h3>
            <table>
                <tr>
                    <th><?= __('Product') ?></th>
                    <td><?= $productVariant->hasValue('product') ? $this->Html->link($productVariant->product->name, ['controller' => 'Products', 'action' => 'view', $productVariant->product->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Size') ?></th>
                    <td><?= h($productVariant->size) ?></td>
                </tr>
                <tr>
                    <th><?= __('Sku') ?></th>
                    <td><?= h($productVariant->sku) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($productVariant->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Price') ?></th>
                    <td><?= $this->Number->format($productVariant->price) ?></td>
                </tr>
                <tr>
                    <th><?= __('Stock') ?></th>
                    <td><?= $this->Number->format($productVariant->stock) ?></td>
                </tr>
                <tr>
                    <th><?= __('Date Created') ?></th>
                    <td><?= h($productVariant->date_created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Date Modified') ?></th>
                    <td><?= h($productVariant->date_modified) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Cart Items') ?></h4>
                <?php if (!empty($productVariant->cart_items)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Cart Id') ?></th>
                            <th><?= __('Product Variant Id') ?></th>
                            <th><?= __('Quantity') ?></th>
                            <th><?= __('Is Preorder') ?></th>
                            <th><?= __('Date Added') ?></th>
                            <th><?= __('Date Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($productVariant->cart_items as $cartItem) : ?>
                        <tr>
                            <td><?= h($cartItem->id) ?></td>
                            <td><?= h($cartItem->cart_id) ?></td>
                            <td><?= h($cartItem->product_variant_id) ?></td>
                            <td><?= h($cartItem->quantity) ?></td>
                            <td><?= h($cartItem->is_preorder) ?></td>
                            <td><?= h($cartItem->date_added) ?></td>
                            <td><?= h($cartItem->date_modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'CartItems', 'action' => 'view', $cartItem->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'CartItems', 'action' => 'edit', $cartItem->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'CartItems', 'action' => 'delete', $cartItem->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $cartItem->id),
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
                <h4><?= __('Related Inventory Transactions') ?></h4>
                <?php if (!empty($productVariant->inventory_transactions)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Product Variant Id') ?></th>
                            <th><?= __('Change Type') ?></th>
                            <th><?= __('Quantity Change') ?></th>
                            <th><?= __('Note') ?></th>
                            <th><?= __('Created By') ?></th>
                            <th><?= __('Date Created') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($productVariant->inventory_transactions as $inventoryTransaction) : ?>
                        <tr>
                            <td><?= h($inventoryTransaction->id) ?></td>
                            <td><?= h($inventoryTransaction->product_variant_id) ?></td>
                            <td><?= h($inventoryTransaction->change_type) ?></td>
                            <td><?= h($inventoryTransaction->quantity_change) ?></td>
                            <td><?= h($inventoryTransaction->note) ?></td>
                            <td><?= h($inventoryTransaction->created_by) ?></td>
                            <td><?= h($inventoryTransaction->date_created) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'InventoryTransactions', 'action' => 'view', $inventoryTransaction->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'InventoryTransactions', 'action' => 'edit', $inventoryTransaction->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'InventoryTransactions', 'action' => 'delete', $inventoryTransaction->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $inventoryTransaction->id),
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
                <h4><?= __('Related Order Product Variants') ?></h4>
                <?php if (!empty($productVariant->order_product_variants)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Order Id') ?></th>
                            <th><?= __('Product Variant Id') ?></th>
                            <th><?= __('Quantity') ?></th>
                            <th><?= __('Is Preorder') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($productVariant->order_product_variants as $orderProductVariant) : ?>
                        <tr>
                            <td><?= h($orderProductVariant->id) ?></td>
                            <td><?= h($orderProductVariant->order_id) ?></td>
                            <td><?= h($orderProductVariant->product_variant_id) ?></td>
                            <td><?= h($orderProductVariant->quantity) ?></td>
                            <td><?= h($orderProductVariant->is_preorder) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'OrderProductVariants', 'action' => 'view', $orderProductVariant->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'OrderProductVariants', 'action' => 'edit', $orderProductVariant->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'OrderProductVariants', 'action' => 'delete', $orderProductVariant->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $orderProductVariant->id),
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