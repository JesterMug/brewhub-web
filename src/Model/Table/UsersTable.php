<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\RulesChecker;

class UsersTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('users');
        $this->setDisplayField('first_name');
        $this->setPrimaryKey('id');

        $this->hasMany('Addresses', ['foreignKey' => 'user_id']);
        $this->hasMany('Carts', ['foreignKey' => 'user_id']);
        $this->hasMany('Orders', ['foreignKey' => 'user_id']);

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'date_created' => 'new',
                    'date_modified' => 'always',
                ],
            ],
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('first_name')
            ->maxLength('first_name', 63)
            ->allowEmptyString('first_name');

        $validator
            ->scalar('last_name')
            ->maxLength('last_name', 63)
            ->allowEmptyString('last_name');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email')
            ->add('email', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('password')
            ->maxLength('password', 255)
            ->minLength('password', 6)
            ->requirePresence('password', 'create')
            ->notEmptyString('password');

        $validator
            ->scalar('user_type')
            ->allowEmptyString('user_type');

        $validator
            ->scalar('nonce')
            ->maxLength('nonce', 255)
            ->allowEmptyString('nonce');

        $validator
            ->dateTime('nonce_expiry')
            ->allowEmptyDateTime('nonce_expiry');

        $validator
            ->dateTime('date_created')
            ->allowEmptyDateTime('date_created');

        $validator
            ->dateTime('date_modified')
            ->allowEmptyDateTime('date_modified');

        return $validator;
    }

    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['email']), ['errorField' => 'email']);
        return $rules;
    }
}
