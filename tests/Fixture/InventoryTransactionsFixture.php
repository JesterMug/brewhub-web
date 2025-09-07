<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * InventoryTransactionsFixture
 */
class InventoryTransactionsFixture extends TestFixture
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
                'product_variant_id' => 1,
                'change_type' => 'Lorem ipsum dolor sit amet',
                'quantity_change' => 1,
                'note' => 'Lorem ipsum dolor sit amet',
                'created_by' => 'Lorem ipsum dolor sit amet',
                'date_created' => 1756992888,
            ],
        ];
        parent::init();
    }
}
