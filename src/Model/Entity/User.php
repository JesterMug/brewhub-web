<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Authentication\PasswordHasher\DefaultPasswordHasher;

class User extends Entity
{
    protected array $_accessible = [
        'first_name' => true,
        'last_name'  => true,
        'email'      => true,
        'password'   => true,
        'user_type'  => true,
        'nonce' => true,
        'nonce_expiry' => true,
        'date_created' => true,
        'date_modified' => true,
    ];

    protected array $_hidden = ['password'];

    protected function _setPassword(?string $password): ?string
    {
        if ($password === null || $password === '') {
            return null;
        }
        return (new DefaultPasswordHasher())->hash($password);
    }
}
