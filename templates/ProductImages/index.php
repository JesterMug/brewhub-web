<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\ProductImage> $productImages
 */
echo $this->Html->css('/vendor/datatables/dataTables.bootstrap4.min.css', ['block' => true]);
echo $this->Html->script('/vendor/datatables/jquery.dataTables.min.js', ['block' => true]);
echo $this->Html->script('/vendor/datatables/dataTables.bootstrap4.min.js', ['block' => true]);
?>
<div class="productImages index content">
    <?= $this->Html->link(__('New Product Image'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Product Images') ?></h3>
    <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th><?= h('Product') ?></th>
                    <th><?= h('image_file') ?></th>
                    <th><?= h('Date Created') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productImages as $productImage): ?>
                <tr>
                    <td><?= $productImage->hasValue('product') ? $this->Html->link($productImage->product->name, ['controller' => 'Products', 'action' => 'view', $productImage->product->id]) : '' ?></td>
                    <td><?= h($productImage->image_file) ?></td>
                    <td><?= h($productImage->date_created) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $productImage->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $productImage->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $productImage->id),
                            ]
                        ) ?>
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
