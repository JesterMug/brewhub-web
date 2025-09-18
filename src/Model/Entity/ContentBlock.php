<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ContentBlock Entity
 *
 * @property int $id
 * @property string $parent
 * @property string $slug
 * @property string $label
 * @property string $description
 * @property string $type
 * @property string|null $value
 * @property string|null $previous_value
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\Phinxlog[] $phinxlog
 */
class ContentBlock extends Entity
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
        'parent' => true,
        'slug' => true,
        'label' => true,
        'description' => true,
        'type' => true,
        'value' => true,
        'previous_value' => true,
        'modified' => true,
        'phinxlog' => true,
    ];
}
