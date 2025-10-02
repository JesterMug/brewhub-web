<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CartItemsFixture
 */
class CartItemsFixture extends TestFixture
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
                'cart_id' => 1,
                'product_variant_id' => 1,
                'quantity' => 1,
                'is_preorder' => 1,
                'date_added' => 1759376227,
                'date_modified' => 1759376227,
            ],
        ];
        parent::init();
    }
}
