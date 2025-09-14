<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Carts Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\AddressesTable&\Cake\ORM\Association\BelongsTo $Addresses
 * @property \App\Model\Table\CartItemsTable&\Cake\ORM\Association\HasMany $CartItems
 *
 * @method \App\Model\Entity\Cart newEmptyEntity()
 * @method \App\Model\Entity\Cart newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Cart> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Cart get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Cart findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Cart patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Cart> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Cart|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Cart saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Cart>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Cart>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Cart>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Cart> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Cart>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Cart>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Cart>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Cart> deleteManyOrFail(iterable $entities, array $options = [])
 */
class CartsTable extends Table
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

        $this->setTable('carts');
        $this->setDisplayField('status');
        $this->setPrimaryKey('id');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Addresses', [
            'foreignKey' => 'address_id',
        ]);
        $this->hasMany('CartItems', [
            'foreignKey' => 'cart_id',
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
            ->integer('user_id')
            ->notEmptyString('user_id');

        $validator
            ->integer('address_id')
            ->allowEmptyString('address_id');

        $validator
            ->scalar('status')
            ->notEmptyString('status');

        $validator
            ->dateTime('date_created')
            ->notEmptyDateTime('date_created');

        $validator
            ->dateTime('date_modified')
            ->notEmptyDateTime('date_modified');

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
        $rules->add($rules->existsIn(['address_id'], 'Addresses'), ['errorField' => 'address_id']);

        return $rules;
    }
}
