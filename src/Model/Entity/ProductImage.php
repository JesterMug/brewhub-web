<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ProductImage Entity
 *
 * @property int $id
 * @property int $product_id
 * @property string $image_file
 * @property \Cake\I18n\DateTime $date_created
 *
 * @property \App\Model\Entity\Product $product
 */
class ProductImage extends Entity
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
        '*' => true,
        'id' => false,
        'product_id' => true,
        'image_file' => true,
        'date_created' => true,
        'product' => true,
    ];
}
