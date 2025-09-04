<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CartsFixture
 */
class CartsFixture extends TestFixture
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
                'user_id' => 1,
                'address_id' => 1,
                'status' => 'Lorem ipsum dolor sit amet',
                'date_created' => '2025-09-04 13:34:48',
                'date_modified' => '2025-09-04 13:34:48',
            ],
        ];
        parent::init();
    }
}
