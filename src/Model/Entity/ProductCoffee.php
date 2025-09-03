<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ProductCoffee Entity
 *
 * @property int $id
 * @property int $product_id
 * @property string $roast_level
 * @property string $brew_type
 * @property string $bean_type
 * @property string $processing_method
 * @property string $caffeine_level
 * @property string $origin_country
 * @property string $certifications
 *
 * @property \App\Model\Entity\Product $product
 */
class ProductCoffee extends Entity
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
        'roast_level' => true,
        'brew_type' => true,
        'bean_type' => true,
        'processing_method' => true,
        'caffeine_level' => true,
        'origin_country' => true,
        'certifications' => true,
        'product' => true,
    ];
}
