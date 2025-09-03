<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\ProductCoffee> $productCoffee
 */
?>
<div class="productCoffee index content">
    <?= $this->Html->link(__('New Product Coffee'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Product Coffee') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('product_id') ?></th>
                    <th><?= $this->Paginator->sort('roast_level') ?></th>
                    <th><?= $this->Paginator->sort('brew_type') ?></th>
                    <th><?= $this->Paginator->sort('bean_type') ?></th>
                    <th><?= $this->Paginator->sort('processing_method') ?></th>
                    <th><?= $this->Paginator->sort('caffeine_level') ?></th>
                    <th><?= $this->Paginator->sort('origin_country') ?></th>
                    <th><?= $this->Paginator->sort('certifications') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productCoffee as $productCoffee): ?>
                <tr>
                    <td><?= $this->Number->format($productCoffee->id) ?></td>
                    <td><?= $productCoffee->hasValue('product') ? $this->Html->link($productCoffee->product->name, ['controller' => 'Products', 'action' => 'view', $productCoffee->product->id]) : '' ?></td>
                    <td><?= h($productCoffee->roast_level) ?></td>
                    <td><?= h($productCoffee->brew_type) ?></td>
                    <td><?= h($productCoffee->bean_type) ?></td>
                    <td><?= h($productCoffee->processing_method) ?></td>
                    <td><?= h($productCoffee->caffeine_level) ?></td>
                    <td><?= h($productCoffee->origin_country) ?></td>
                    <td><?= h($productCoffee->certifications) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $productCoffee->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $productCoffee->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $productCoffee->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $productCoffee->id),
                            ]
                        ) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>