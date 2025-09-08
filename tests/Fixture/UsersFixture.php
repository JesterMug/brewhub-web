<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UsersFixture
 */
class UsersFixture extends TestFixture
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
                'first_name' => 'Lorem ipsum dolor sit amet',
                'last_name' => 'Lorem ipsum dolor sit amet',
                'email' => 'Lorem ipsum dolor sit amet',
                'password' => 'Lorem ipsum dolor sit amet',
                'user_type' => 'Lorem ipsum dolor sit amet',
                'nonce' => 'Lorem ipsum dolor sit amet',
                'nonce_expiry' => '2025-09-04 13:34:48',
                'date_created' => '2025-09-04 13:34:48',
                'date_modified' => '2025-09-04 13:34:48',
            ],
        ];
        parent::init();
    }
}
