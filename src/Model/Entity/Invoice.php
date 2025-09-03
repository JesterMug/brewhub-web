<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Invoice Entity
 *
 * @property int $id
 * @property int $order_id
 * @property string $payment_method
 * @property string $transaction_number
 * @property string $paid_amount
 *
 * @property \App\Model\Entity\Order $order
 */
class Invoice extends Entity
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
        'payment_method' => true,
        'transaction_number' => true,
        'paid_amount' => true,
        'order' => true,
    ];
}
