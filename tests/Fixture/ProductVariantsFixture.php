<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ProductVariantsFixture
 */
class ProductVariantsFixture extends TestFixture
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
                'product_id' => 1,
                'size' => 'Lorem ipsum do',
                'price' => 1.5,
                'stock' => 1,
                'date_created' => 1756992888,
                'date_modified' => 1756992888,
                'sku' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
