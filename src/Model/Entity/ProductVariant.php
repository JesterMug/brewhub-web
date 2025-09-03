<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ProductVariant Entity
 *
 * @property int $id
 * @property int $product_id
 * @property string $size
 * @property string $price
 * @property int $stock
 * @property \Cake\I18n\DateTime $date_created
 * @property \Cake\I18n\DateTime $date_modified
 * @property string $sku
 *
 * @property \App\Model\Entity\Product $product
 * @property \App\Model\Entity\CartItem[] $cart_items
 * @property \App\Model\Entity\InventoryTransaction[] $inventory_transactions
 * @property \App\Model\Entity\OrderProductVariant[] $order_product_variants
 */
class ProductVariant extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'product_id' => true,
        'size' => true,
        'price' => true,
        'stock' => true,
        'date_created' => true,
        'date_modified' => true,
        'sku' => true,
        'product' => true,
        'cart_items' => true,
        'inventory_transactions' => true,
        'order_product_variants' => true,
    ];
}
