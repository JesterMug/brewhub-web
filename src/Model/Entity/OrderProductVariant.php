<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * OrderProductVariant Entity
 *
 * @property int $id
 * @property int $order_id
 * @property int $product_variant_id
 * @property int $quantity
 * @property bool $is_preorder
 *
 * @property \App\Model\Entity\Order $order
 * @property \App\Model\Entity\ProductVariant $product_variant
 */
class OrderProductVariant extends Entity
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
        'order_id' => true,
        'product_variant_id' => true,
        'quantity' => true,
        'is_preorder' => true,
        'order' => true,
        'product_variant' => true,
    ];
}
