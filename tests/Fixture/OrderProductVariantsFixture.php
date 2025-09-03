<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * OrderProductVariantsFixture
 */
class OrderProductVariantsFixture extends TestFixture
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
                'product_variant_id' => 1,
                'quantity' => 1,
                'is_preorder' => 1,
            ],
        ];
        parent::init();
    }
}
