<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CartItem $cartItem
 * @var \Cake\Collection\CollectionInterface|string[] $carts
 * @var \Cake\Collection\CollectionInterface|string[] $productVariants
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Cart Items'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="cartItems form content">
            <?= $this->Form->create($cartItem) ?>
            <fieldset>
                <legend><?= __('Add Cart Item') ?></legend>
                <?php
                    echo $this->Form->control('cart_id', ['options' => $carts]);
                    echo $this->Form->control('product_variant_id', ['options' => $productVariants]);
                    echo $this->Form->control('quantity');
                    echo $this->Form->control('is_preorder');
                    echo $this->Form->control('date_added');
                    echo $this->Form->control('date_modified');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
