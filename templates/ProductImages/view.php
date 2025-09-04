<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ProductImage $productImage
 */
echo $this->Html->css('/vendor/datatables/dataTables.bootstrap4.min.css', ['block' => true]);
echo $this->Html->script('/vendor/datatables/jquery.dataTables.min.js', ['block' => true]);
echo $this->Html->script('/vendor/datatables/dataTables.bootstrap4.min.js', ['block' => true]);
?>
<div class="row">
    <div class="column column-80">
        <div class="productImages view content">
            <h3><?= h($productImage->image_file) ?></h3>
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <tr>
                    <th><?= __('Product') ?></th>
                    <td><?= $productImage->hasValue('product') ? $this->Html->link($productImage->product->name, ['controller' => 'Products', 'action' => 'view', $productImage->product->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Image File') ?></th>
                    <td><?= h($productImage->image_file) ?></td>
                </tr>
                <tr>
                    <th><?= __('Product Image') ?></th>
                    <td><?= $this->Html->Image(
                            'products/' . h($productImage->image_file),
                            ['style' => 'max-width:300px; height:auto;']) ?>
                    </td>
                </tr>
                <tr>
                    <th><?= __('Date Created') ?></th>
                    <td><?= h($productImage->date_created) ?></td>
                </tr>
            </table>
        </div>
        <div class="side-nav">
            <?= $this->Form->postLink(__('Delete Product Image'), ['action' => 'delete', $productImage->id], ['confirm' => __('Are you sure you want to delete # {0}?', $productImage->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Product Images'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </div>
</div>
