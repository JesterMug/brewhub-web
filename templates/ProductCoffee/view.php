<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ProductCoffee $productCoffee
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Product Coffee'), ['action' => 'edit', $productCoffee->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Product Coffee'), ['action' => 'delete', $productCoffee->id], ['confirm' => __('Are you sure you want to delete # {0}?', $productCoffee->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Product Coffee'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Product Coffee'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="productCoffee view content">
            <h3><?= h($productCoffee->roast_level) ?></h3>
            <table>
                <tr>
                    <th><?= __('Product') ?></th>
                    <td><?= $productCoffee->hasValue('product') ? $this->Html->link($productCoffee->product->name, ['controller' => 'Products', 'action' => 'view', $productCoffee->product->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Roast Level') ?></th>
                    <td><?= h($productCoffee->roast_level) ?></td>
                </tr>
                <tr>
                    <th><?= __('Brew Type') ?></th>
                    <td><?= h($productCoffee->brew_type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Bean Type') ?></th>
                    <td><?= h($productCoffee->bean_type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Processing Method') ?></th>
                    <td><?= h($productCoffee->processing_method) ?></td>
                </tr>
                <tr>
                    <th><?= __('Caffeine Level') ?></th>
                    <td><?= h($productCoffee->caffeine_level) ?></td>
                </tr>
                <tr>
                    <th><?= __('Origin Country') ?></th>
                    <td><?= h($productCoffee->origin_country) ?></td>
                </tr>
                <tr>
                    <th><?= __('Certifications') ?></th>
                    <td><?= h($productCoffee->certifications) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($productCoffee->id) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>