<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Address Entity
 *
 * @property int $id
 * @property string|null $label
 * @property string $recipient_full_name
 * @property string $recipient_phone
 * @property string $property_type
 * @property string $street
 * @property string|null $building
 * @property string $city
 * @property string $state
 * @property int $postcode
 * @property bool $is_active
 * @property int $user_id
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Order[] $orders
 */
class Address extends Entity
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
        'label' => true,
        'recipient_full_name' => true,
        'recipient_phone' => true,
        'property_type' => true,
        'street' => true,
        'building' => true,
        'city' => true,
        'state' => true,
        'postcode' => true,
        'is_active' => true,
        'user_id' => true,
        'user' => true,
        'orders' => true,
    ];
}
