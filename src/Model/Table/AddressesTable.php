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
            'joinType' => 'LEFT',
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
            ->maxLength('recipient_full_name', 100)
            ->requirePresence('recipient_full_name', 'create')
            ->notEmptyString('recipient_full_name')
            ->add('recipient_full_name', 'lettersOnly', [
                'rule' => function ($value) {
                    return (bool)preg_match("/^[A-Za-zÀ-ÖØ-öø-ÿ' -]{2,100}$/u", (string)$value);
                },
                'message' => 'Full name should contain only letters, spaces, hyphens or apostrophes.'
            ]);

        $validator
            ->scalar('recipient_phone')
            ->maxLength('recipient_phone', 20)
            ->requirePresence('recipient_phone', 'create')
            ->notEmptyString('recipient_phone')
            ->add('recipient_phone', 'validPhone', [
                'rule' => function ($value) {
                    return (bool)preg_match('/^[0-9\s\+\-\(\)\.]{6,20}$/', (string)$value);
                },
                'message' => 'Please enter a valid phone number (6-20 digits; spaces, +, (), . and - allowed).'
            ]);

        $validator
            ->scalar('property_type')
            ->requirePresence('property_type', 'create')
            ->notEmptyString('property_type')
            ->add('property_type', 'inList', [
                'rule' => ['inList', ['House', 'Apartment', 'Business', 'Other']],
                'message' => 'Please select a valid property type.'
            ]);

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
            ->requirePresence('city', 'create')
            ->notEmptyString('city')
            ->add('city', 'lettersOnly', [
                'rule' => function ($value) {
                    return (bool)preg_match("/^[A-Za-zÀ-ÖØ-öø-ÿ' -]{2,100}$/u", (string)$value);
                },
                'message' => 'City should contain only letters, spaces, hyphens or apostrophes.'
            ]);

        $validator
            ->scalar('state')
            ->requirePresence('state', 'create')
            ->notEmptyString('state')
            ->add('state', 'inList', [
                'rule' => ['inList', ['NSW', 'VIC', 'QLD', 'SA', 'WA', 'TAS', 'ACT', 'NT']],
                'message' => 'Please select a valid state.'
            ]);

        $validator
            ->requirePresence('postcode', 'create')
            ->notEmptyString('postcode')
            ->add('postcode', 'numeric', [
                'rule' => function ($value) {
                    return (bool)preg_match('/^\d{4}$/', (string)$value);
                },
                'message' => 'Please enter a valid 4-digit postcode.'
            ]);

        $validator
            ->boolean('is_active')
            ->notEmptyString('is_active');

        $validator
            ->integer('user_id')
            ->allowEmptyString('user_id');

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
        // Allow guest addresses without a user account
        // $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);

        return $rules;
    }
}
