<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ProductImagesFixture
 */
class ProductImagesFixture extends TestFixture
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
                'image_file' => 'Lorem ipsum dolor sit amet',
                'date_created' => '2025-09-04 13:34:48',
            ],
        ];
        parent::init();
    }
}
