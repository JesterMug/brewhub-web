<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OrderProductVariants Model
 *
 * @property \App\Model\Table\OrdersTable&\Cake\ORM\Association\BelongsTo $Orders
 * @property \App\Model\Table\ProductVariantsTable&\Cake\ORM\Association\BelongsTo $ProductVariants
 *
 * @method \App\Model\Entity\OrderProductVariant newEmptyEntity()
 * @method \App\Model\Entity\OrderProductVariant newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\OrderProductVariant> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OrderProductVariant get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\OrderProductVariant findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\OrderProductVariant patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\OrderProductVariant> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\OrderProductVariant|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\OrderProductVariant saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\OrderProductVariant>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\OrderProductVariant>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\OrderProductVariant>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\OrderProductVariant> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\OrderProductVariant>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\OrderProductVariant>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\OrderProductVariant>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\OrderProductVariant> deleteManyOrFail(iterable $entities, array $options = [])
 */
class OrderProductVariantsTable extends Table
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

        $this->setTable('order_product_variants');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Orders', [
            'foreignKey' => 'order_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('ProductVariants', [
            'foreignKey' => 'product_variant_id',
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
            ->integer('order_id')
            ->notEmptyString('order_id');

        $validator
            ->integer('product_variant_id')
            ->notEmptyString('product_variant_id');

        $validator
            ->integer('quantity')
            ->notEmptyString('quantity');

        $validator
            ->boolean('is_preorder')
            ->notEmptyString('is_preorder');

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
        $rules->add($rules->existsIn(['order_id'], 'Orders'), ['errorField' => 'order_id']);
        $rules->add($rules->existsIn(['product_variant_id'], 'ProductVariants'), ['errorField' => 'product_variant_id']);

        return $rules;
    }
}
