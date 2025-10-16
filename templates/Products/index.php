<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Product> $products
 * @var int $threshold
 */

echo $this->Html->css('/vendor/datatables/dataTables.bootstrap4.min.css', ['block' => true]);
echo $this->Html->script('/vendor/datatables/jquery.dataTables.min.js', ['block' => true]);
echo $this->Html->script('/vendor/datatables/dataTables.bootstrap4.min.js', ['block' => true]);
?>
<div class="products index content">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= __('Products') ?></h1>
        <div class="d-flex">
            <!-- Button to generate stock report PDF -->
            <a href="<?= $this->Url->build(['action' => 'report']) ?>"
               class="btn btn-sm btn-success shadow-sm me-2">
                <i class="fas fa-file-pdf fa-sm text-white-50"></i> Generate Stock Report
            </a>

            <!-- Button to add a new product -->
            <a href="<?= $this->Url->build(['action' => 'add']) ?>"
               class="btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50"></i> New Product
            </a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
            <tr>
                <th><?= h('Name') ?></th>
                <th><?= h('Category') ?></th>
                <th><?= h('Stock Status') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($products as $product): ?>
                <?php $stock = (int)($product->stock_effective ?? 0); ?>
                <tr>
                    <td><?= h($product->name) ?></td>
                    <td><?= h($product->category) ?></td>
                    <td>
                        <?php if ($stock < 50): ?>
                            <span class="badge bg-danger text-white">
                                Low Stock (<?= h($stock) ?>)
                            </span>
                        <?php else: ?>
                            <span class="badge bg-success text-white">
                                In Stock (<?= h($stock) ?>)
                            </span>
                        <?php endif; ?>
                    </td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['controller' => 'shop','action' => 'view', $product->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $product->id]) ?>
<!--                        --><?php //= $this->Form->postLink(
//                            __('Delete'),
//                            ['action' => 'delete', $product->id],
//                            [
//                                'method' => 'delete',
//                                'confirm' => __(
//                                    'Are you sure you want to delete {0}? This will delete all associated product variants and images.',
//                                    $product->name
//                                ),
//                            ],
//                        ) ?>
                        <?php if ($product->is_featured == 0) : ?>
                            <?= $this->Form->postLink(
                                __('Feature'),
                                ['controller' => 'products', 'action' => 'feature', $product->id],

                            ) ?>
                        <?php endif; ?>

                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>
</div>
