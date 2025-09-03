<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProductCoffee Model
 *
 * @property \App\Model\Table\ProductsTable&\Cake\ORM\Association\BelongsTo $Products
 *
 * @method \App\Model\Entity\ProductCoffee newEmptyEntity()
 * @method \App\Model\Entity\ProductCoffee newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\ProductCoffee> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ProductCoffee get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\ProductCoffee findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\ProductCoffee patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\ProductCoffee> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ProductCoffee|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\ProductCoffee saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\ProductCoffee>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ProductCoffee>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ProductCoffee>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ProductCoffee> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ProductCoffee>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ProductCoffee>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ProductCoffee>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ProductCoffee> deleteManyOrFail(iterable $entities, array $options = [])
 */
class ProductCoffeeTable extends Table
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

        $this->setTable('product_coffee');
        $this->setDisplayField('roast_level');
        $this->setPrimaryKey('id');

        $this->belongsTo('Products', [
            'foreignKey' => 'product_id',
            'joinType' => 'INNER',
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
            ->integer('product_id')
            ->notEmptyString('product_id');

        $validator
            ->scalar('roast_level')
            ->maxLength('roast_level', 50)
            ->requirePresence('roast_level', 'create')
            ->notEmptyString('roast_level');

        $validator
            ->scalar('brew_type')
            ->maxLength('brew_type', 50)
            ->requirePresence('brew_type', 'create')
            ->notEmptyString('brew_type');

        $validator
            ->scalar('bean_type')
            ->maxLength('bean_type', 50)
            ->requirePresence('bean_type', 'create')
            ->notEmptyString('bean_type');

        $validator
            ->scalar('processing_method')
            ->maxLength('processing_method', 50)
            ->requirePresence('processing_method', 'create')
            ->notEmptyString('processing_method');

        $validator
            ->scalar('caffeine_level')
            ->maxLength('caffeine_level', 50)
            ->requirePresence('caffeine_level', 'create')
            ->notEmptyString('caffeine_level');

        $validator
            ->scalar('origin_country')
            ->maxLength('origin_country', 100)
            ->requirePresence('origin_country', 'create')
            ->notEmptyString('origin_country');

        $validator
            ->scalar('certifications')
            ->maxLength('certifications', 255)
            ->requirePresence('certifications', 'create')
            ->notEmptyString('certifications');

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
        $rules->add($rules->existsIn(['product_id'], 'Products'), ['errorField' => 'product_id']);

        return $rules;
    }
}
