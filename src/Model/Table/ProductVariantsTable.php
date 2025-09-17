<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProductVariants Model
 *
 * @property \App\Model\Table\ProductsTable&\Cake\ORM\Association\BelongsTo $Products
 * @property \App\Model\Table\CartItemsTable&\Cake\ORM\Association\HasMany $CartItems
 * @property \App\Model\Table\InventoryTransactionsTable&\Cake\ORM\Association\HasMany $InventoryTransactions
 * @property \App\Model\Table\OrderProductVariantsTable&\Cake\ORM\Association\HasMany $OrderProductVariants
 *
 * @method \App\Model\Entity\ProductVariant newEmptyEntity()
 * @method \App\Model\Entity\ProductVariant newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\ProductVariant> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ProductVariant get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\ProductVariant findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\ProductVariant patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\ProductVariant> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ProductVariant|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\ProductVariant saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\ProductVariant>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ProductVariant>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ProductVariant>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ProductVariant> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ProductVariant>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ProductVariant>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ProductVariant>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ProductVariant> deleteManyOrFail(iterable $entities, array $options = [])
 */
class ProductVariantsTable extends Table
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

        $this->setTable('product_variants');
        $this->setDisplayField('size');
        $this->setPrimaryKey('id');

        $this->belongsTo('Products', [
            'foreignKey' => 'product_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('CartItems', [
            'foreignKey' => 'product_variant_id',
        ]);
        $this->hasMany('InventoryTransactions', [
            'foreignKey' => 'product_variant_id',
        ]);
        $this->hasMany('OrderProductVariants', [
            'foreignKey' => 'product_variant_id',
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
            ->decimal('size_value')
            ->greaterThan('size_value', 0, 'Size must be greater than zero')
            ->requirePresence('size_value', 'create')
            ->notEmptyString('size_value');

        $validator
            ->scalar('size_unit')
            ->inList('size_unit', ['g', 'kg', 'oz', 'ml'], 'Please select a valid unit')
            ->requirePresence('size_unit', 'create')
            ->notEmptyString('size_unit');

        $validator
            ->decimal('price')
            ->requirePresence('price', 'create')
            ->greaterThanOrEqual('price', 0, 'Price must be zero or higher')
            ->lessThanOrEqual('price', 9999.99, 'Price cannot exceed 9999.99')
            ->notEmptyString('price');

        $validator
            ->integer('stock')
            ->greaterThanOrEqual('stock', 0, 'Stock must be zero or higher')
            ->requirePresence('stock', 'create')
            ->notEmptyString('stock');

        $validator
            ->dateTime('date_created')
            ->notEmptyDateTime('date_created');

        $validator
            ->dateTime('date_modified')
            ->notEmptyDateTime('date_modified');

        $validator
            ->scalar('sku')
            ->maxLength('sku', 50)
            ->requirePresence('sku', 'create')
            ->notEmptyString('sku')
            ->add('sku', 'validSKU', [
                'rule' => ['custom', "/^[A-Za-z0-9\-_]+$/"],
                'message' => "SKU may only contain letters, numbers, hyphens, and underscores."
            ]);

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
