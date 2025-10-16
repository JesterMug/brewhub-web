<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\ResultSetInterface|array $preorderItems
 */

echo $this->Html->css('/vendor/datatables/dataTables.bootstrap4.min.css', ['block' => true]);
echo $this->Html->script('/vendor/datatables/jquery.dataTables.min.js', ['block' => true]);
echo $this->Html->script('/vendor/datatables/dataTables.bootstrap4.min.js', ['block' => true]);
?>
<div class="orders index content">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= __('Preorder Items (Unshipped Orders)') ?></h1>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th><?= h('Product') ?></th>
                    <th><?= h('Variant') ?></th>
                    <th><?= h('SKU') ?></th>
                    <th class="text-end"><?= h('Total Preorder Qty') ?></th>
                    <th class="text-end"><?= h('# Orders') ?></th>
                    <th class="text-end"><?= h('Current Stock') ?></th>
                    <th class="text-end"><?= h('Need to Buy') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($preorderItems as $row): ?>
                    <?php $variant = $row->product_variant ?? null; $product = $variant->product ?? null; $totalQty = (int)($row->get('total_quantity') ?? 0); $ordersCount = (int)($row->get('orders_count') ?? 0); $stock = (int)($variant->stock ?? 0); $need = max(0, $totalQty - $stock); ?>
                    <tr>
                        <td><?= $this->Html->link(__($product->name ?? 'Item'), ['controller' => 'products','action' => 'edit', $product->id]) ?></td>
                        <td><?= h($variant ? ($variant->size ?? (($variant->size_value ?? '') . ($variant->size_unit ?? ''))) : '') ?></td>
                        <td><?= h($variant->sku ?? '') ?></td>
                        <td class="text-end"><?= (int)$totalQty ?></td>
                        <td class="text-end"><span class="badge badge-light"><?= (int)$ordersCount ?></span></td>
                        <td class="text-end"><?= (int)$stock ?></td>
                        <td class="text-end fw-bold <?= $need > 0 ? 'text-danger' : 'text-success' ?>"><?= (int)$need ?></td>
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
