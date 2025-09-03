<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * InventoryTransaction Entity
 *
 * @property int $id
 * @property int $product_variant_id
 * @property string $change_type
 * @property int $quantity_change
 * @property string|null $note
 * @property string $created_by
 * @property \Cake\I18n\DateTime $date_created
 *
 * @property \App\Model\Entity\ProductVariant $product_variant
 */
class InventoryTransaction extends Entity
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
        'product_variant_id' => true,
        'change_type' => true,
        'quantity_change' => true,
        'note' => true,
        'created_by' => true,
        'date_created' => true,
        'product_variant' => true,
    ];
}
