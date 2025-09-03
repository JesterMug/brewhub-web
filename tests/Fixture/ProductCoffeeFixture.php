<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ProductCoffeeFixture
 */
class ProductCoffeeFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public string $table = 'product_coffee';
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
                'roast_level' => 'Lorem ipsum dolor sit amet',
                'brew_type' => 'Lorem ipsum dolor sit amet',
                'bean_type' => 'Lorem ipsum dolor sit amet',
                'processing_method' => 'Lorem ipsum dolor sit amet',
                'caffeine_level' => 'Lorem ipsum dolor sit amet',
                'origin_country' => 'Lorem ipsum dolor sit amet',
                'certifications' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
