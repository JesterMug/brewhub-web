<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ProductCoffee $productCoffee
 * @var string[]|\Cake\Collection\CollectionInterface $products
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $productCoffee->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $productCoffee->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Product Coffee'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="productCoffee form content">
            <?= $this->Form->create($productCoffee) ?>
            <fieldset>
                <legend><?= __('Edit Product Coffee') ?></legend>
                <?php
                    echo $this->Form->control('product_id', ['options' => $products]);
                    echo $this->Form->control('roast_level');
                    echo $this->Form->control('brew_type');
                    echo $this->Form->control('bean_type');
                    echo $this->Form->control('processing_method');
                    echo $this->Form->control('caffeine_level');
                    echo $this->Form->control('origin_country');
                    echo $this->Form->control('certifications');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
