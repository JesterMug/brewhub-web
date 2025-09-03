<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Product Entity
 *
 * @property int $id
 * @property string $name
 * @property string $category
 * @property string|null $description
 * @property \Cake\I18n\DateTime $date_created
 * @property \Cake\I18n\DateTime $date_modified
 *
 * @property \App\Model\Entity\ProductCoffee[] $product_coffee
 * @property \App\Model\Entity\ProductImage[] $product_images
 * @property \App\Model\Entity\ProductMerchandise[] $product_merchandise
 * @property \App\Model\Entity\ProductVariant[] $product_variants
 */
class Product extends Entity
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
        'name' => true,
        'category' => true,
        'description' => true,
        'date_created' => true,
        'date_modified' => true,
        'product_coffee' => true,
        'product_images' => true,
        'product_merchandise' => true,
        'product_variants' => true,
    ];
}
