<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product $product
 */
echo $this->Html->css('/vendor/datatables/dataTables.bootstrap4.min.css', ['block' => true]);
echo $this->Html->script('/vendor/datatables/jquery.dataTables.min.js', ['block' => true]);
echo $this->Html->script('/vendor/datatables/dataTables.bootstrap4.min.js', ['block' => true]);
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Product'), ['action' => 'edit', $product->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Product'), ['action' => 'delete', $product->id], ['confirm' => __('Are you sure you want to delete # {0}?', $product->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Products'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Product'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="products view content">
            <h3><?= h($product->name) ?></h3>
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($product->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Category') ?></th>
                    <td><?= h($product->category) ?></td>
                </tr>
                <tr>
                    <th><?= __('Date Created') ?></th>
                    <td><?= h($product->date_created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Date Modified') ?></th>
                    <td><?= h($product->date_modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Description') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($product->description)); ?>
                </blockquote>
            </div>
            <div class="related">
                <?php if (!empty($product->product_coffee)) : ?>
                <h4><?= __('Related Product Coffee') ?></h4>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Product Id') ?></th>
                            <th><?= __('Roast Level') ?></th>
                            <th><?= __('Brew Type') ?></th>
                            <th><?= __('Bean Type') ?></th>
                            <th><?= __('Processing Method') ?></th>
                            <th><?= __('Caffeine Level') ?></th>
                            <th><?= __('Origin Country') ?></th>
                            <th><?= __('Certifications') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($product->product_coffee as $productCoffee) : ?>
                        <tr>
                            <td><?= h($productCoffee->id) ?></td>
                            <td><?= h($productCoffee->product_id) ?></td>
                            <td><?= h($productCoffee->roast_level) ?></td>
                            <td><?= h($productCoffee->brew_type) ?></td>
                            <td><?= h($productCoffee->bean_type) ?></td>
                            <td><?= h($productCoffee->processing_method) ?></td>
                            <td><?= h($productCoffee->caffeine_level) ?></td>
                            <td><?= h($productCoffee->origin_country) ?></td>
                            <td><?= h($productCoffee->certifications) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'ProductCoffee', 'action' => 'view', $productCoffee->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'ProductCoffee', 'action' => 'edit', $productCoffee->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'ProductCoffee', 'action' => 'delete', $productCoffee->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $productCoffee->id),
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
                <?php if (!empty($product->product_images)) : ?>
                <h4><?= __('Related Product Images') ?></h4>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Product Id') ?></th>
                            <th><?= __('Image File') ?></th>
                            <th><?= __('Date Created') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($product->product_images as $productImage) : ?>
                        <tr>
                            <td><?= h($productImage->id) ?></td>
                            <td><?= h($productImage->product_id) ?></td>
                            <td><?= h($productImage->image_file) ?></td>
                            <td><?= h($productImage->date_created) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'ProductImages', 'action' => 'view', $productImage->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'ProductImages', 'action' => 'delete', $productImage->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $productImage->id),
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
                <?php if (!empty($product->product_merchandise)) : ?>
                <h4><?= __('Related Product Merchandise') ?></h4>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Product Id') ?></th>
                            <th><?= __('Material') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($product->product_merchandise as $productMerchandise) : ?>
                        <tr>
                            <td><?= h($productMerchandise->id) ?></td>
                            <td><?= h($productMerchandise->product_id) ?></td>
                            <td><?= h($productMerchandise->material) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'ProductMerchandise', 'action' => 'view', $productMerchandise->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'ProductMerchandise', 'action' => 'edit', $productMerchandise->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'ProductMerchandise', 'action' => 'delete', $productMerchandise->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $productMerchandise->id),
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
                <?php if (!empty($product->product_variants)) : ?>
                <h4><?= __('Related Product Variants') ?></h4>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Product Id') ?></th>
                            <th><?= __('Size') ?></th>
                            <th><?= __('Price') ?></th>
                            <th><?= __('Stock') ?></th>
                            <th><?= __('Date Created') ?></th>
                            <th><?= __('Date Modified') ?></th>
                            <th><?= __('Sku') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($product->product_variants as $productVariant) : ?>
                        <tr>
                            <td><?= h($productVariant->id) ?></td>
                            <td><?= h($productVariant->product_id) ?></td>
                            <td><?= h($productVariant->size) ?></td>
                            <td><?= h($productVariant->price) ?></td>
                            <td><?= h($productVariant->stock) ?></td>
                            <td><?= h($productVariant->date_created) ?></td>
                            <td><?= h($productVariant->date_modified) ?></td>
                            <td><?= h($productVariant->sku) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'ProductVariants', 'action' => 'view', $productVariant->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'ProductVariants', 'action' => 'edit', $productVariant->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'ProductVariants', 'action' => 'delete', $productVariant->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $productVariant->id),
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
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>
</div>
