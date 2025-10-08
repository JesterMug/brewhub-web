<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Addresses Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\OrdersTable&\Cake\ORM\Association\HasMany $Orders
 *
 * @method \App\Model\Entity\Address newEmptyEntity()
 * @method \App\Model\Entity\Address newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Address> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Address get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Address findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Address patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Address> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Address|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Address saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Address>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Address>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Address>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Address> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Address>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Address>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Address>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Address> deleteManyOrFail(iterable $entities, array $options = [])
 */
class AddressesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('addresses');
        $this->setDisplayField('label');
        $this->setPrimaryKey('id');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('Orders', [
            'foreignKey' => 'address_id',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('label')
            ->maxLength('label', 63)
            ->allowEmptyString('label');

        $validator
            ->scalar('recipient_full_name')
            ->maxLength('recipient_full_name', 127)
            ->regex('recipient_full_name', "/^[\p{L}\s'\-]+$/u", 'Only letters, spaces, hyphens, and apostrophes allowed')
            ->requirePresence('recipient_full_name', 'create')
            ->notEmptyString('recipient_full_name');

        $validator
            ->scalar('recipient_phone')
            ->maxLength('recipient_phone', 23)
            ->regex('recipient_phone', '/^[+()\d\s-]{8,20}$/', 'Enter a valid phone number')
            ->requirePresence('recipient_phone', 'create')
            ->notEmptyString('recipient_phone');

        // Restrict to allowed property types
        $allowedPropertyTypes = ['House', 'Apartment', 'Business', 'PO Box', 'Other'];
        $validator
            ->scalar('property_type')
            ->inList('property_type', $allowedPropertyTypes, 'Invalid property type')
            ->requirePresence('property_type', 'create')
            ->notEmptyString('property_type');

        $validator
            ->scalar('street')
            ->maxLength('street', 255)
            ->requirePresence('street', 'create')
            ->notEmptyString('street');

        $validator
            ->scalar('building')
            ->maxLength('building', 100)
            ->allowEmptyString('building');

        $validator
            ->scalar('city')
            ->maxLength('city', 100)
            ->regex('city', "/^[\p{L}\s'\-]+$/u", 'Only letters, spaces, hyphens, and apostrophes allowed')
            ->requirePresence('city', 'create')
            ->notEmptyString('city');

        // AU states
        $auStates = ['ACT','NSW','NT','QLD','SA','TAS','VIC','WA'];
        $validator
            ->scalar('state')
            ->inList('state', $auStates, 'Select a valid state/territory')
            ->requirePresence('state', 'create')
            ->notEmptyString('state');

        $validator
            ->requirePresence('postcode', 'create')
            ->regex('postcode', '/^\d{4}$/', 'Enter a valid 4-digit postcode')
            ->notEmptyString('postcode');

        $validator
            ->boolean('is_active')
            ->allowEmptyString('is_active');

        $validator
            ->integer('user_id')
            ->notEmptyString('user_id');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);

        return $rules;
    }
}
