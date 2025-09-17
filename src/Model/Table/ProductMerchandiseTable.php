<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProductMerchandise Model
 *
 * @property \App\Model\Table\ProductsTable&\Cake\ORM\Association\BelongsTo $Products
 *
 * @method \App\Model\Entity\ProductMerchandise newEmptyEntity()
 * @method \App\Model\Entity\ProductMerchandise newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\ProductMerchandise> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ProductMerchandise get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\ProductMerchandise findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\ProductMerchandise patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\ProductMerchandise> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ProductMerchandise|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\ProductMerchandise saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\ProductMerchandise>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ProductMerchandise>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ProductMerchandise>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ProductMerchandise> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ProductMerchandise>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ProductMerchandise>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ProductMerchandise>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ProductMerchandise> deleteManyOrFail(iterable $entities, array $options = [])
 */
class ProductMerchandiseTable extends Table
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

        $this->setTable('product_merchandise');
        $this->setDisplayField('id');
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
            ->scalar('material')
            ->regex('last_name', "/^[\p{L}\s'\-]+$/u", "Only letters, spaces, hyphens, and apostrophes allowed")
            ->maxLength('material', 100)
            ->allowEmptyString('material');

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
