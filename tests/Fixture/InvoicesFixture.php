<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * InvoicesFixture
 */
class InvoicesFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'order_id' => 1,
                'payment_method' => 'Lorem ipsum dolor sit amet',
                'transaction_number' => 'Lorem ipsum dolor sit amet',
                'paid_amount' => 1.5,
            ],
        ];
        parent::init();
    }
}
