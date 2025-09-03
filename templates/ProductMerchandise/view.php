<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ProductMerchandise $productMerchandise
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Product Merchandise'), ['action' => 'edit', $productMerchandise->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Product Merchandise'), ['action' => 'delete', $productMerchandise->id], ['confirm' => __('Are you sure you want to delete # {0}?', $productMerchandise->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Product Merchandise'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Product Merchandise'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="productMerchandise view content">
            <h3><?= h($productMerchandise->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Product') ?></th>
                    <td><?= $productMerchandise->hasValue('product') ? $this->Html->link($productMerchandise->product->name, ['controller' => 'Products', 'action' => 'view', $productMerchandise->product->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Material') ?></th>
                    <td><?= h($productMerchandise->material) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($productMerchandise->id) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>