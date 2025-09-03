<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * InventoryTransactions Model
 *
 * @property \App\Model\Table\ProductVariantsTable&\Cake\ORM\Association\BelongsTo $ProductVariants
 *
 * @method \App\Model\Entity\InventoryTransaction newEmptyEntity()
 * @method \App\Model\Entity\InventoryTransaction newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\InventoryTransaction> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\InventoryTransaction get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\InventoryTransaction findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\InventoryTransaction patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\InventoryTransaction> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\InventoryTransaction|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\InventoryTransaction saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\InventoryTransaction>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\InventoryTransaction>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\InventoryTransaction>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\InventoryTransaction> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\InventoryTransaction>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\InventoryTransaction>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\InventoryTransaction>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\InventoryTransaction> deleteManyOrFail(iterable $entities, array $options = [])
 */
class InventoryTransactionsTable extends Table
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

        $this->setTable('inventory_transactions');
        $this->setDisplayField('change_type');
        $this->setPrimaryKey('id');

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
            ->integer('product_variant_id')
            ->notEmptyString('product_variant_id');

        $validator
            ->scalar('change_type')
            ->requirePresence('change_type', 'create')
            ->notEmptyString('change_type');

        $validator
            ->integer('quantity_change')
            ->requirePresence('quantity_change', 'create')
            ->notEmptyString('quantity_change');

        $validator
            ->scalar('note')
            ->maxLength('note', 255)
            ->allowEmptyString('note');

        $validator
            ->scalar('created_by')
            ->maxLength('created_by', 50)
            ->notEmptyString('created_by');

        $validator
            ->dateTime('date_created')
            ->notEmptyDateTime('date_created');

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
        $rules->add($rules->existsIn(['product_variant_id'], 'ProductVariants'), ['errorField' => 'product_variant_id']);

        return $rules;
    }
}
