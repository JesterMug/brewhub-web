<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ContentBlocks Model
 *
 * @property \App\Model\Table\PhinxlogTable&\Cake\ORM\Association\BelongsToMany $Phinxlog
 *
 * @method \App\Model\Entity\ContentBlock newEmptyEntity()
 * @method \App\Model\Entity\ContentBlock newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\ContentBlock> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ContentBlock get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\ContentBlock findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\ContentBlock patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\ContentBlock> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ContentBlock|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\ContentBlock saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\ContentBlock>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ContentBlock>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ContentBlock>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ContentBlock> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ContentBlock>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ContentBlock>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ContentBlock>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ContentBlock> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ContentBlocksTable extends Table
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

        $this->setTable('content_blocks');
        $this->setDisplayField('label');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsToMany('Phinxlog', [
            'foreignKey' => 'content_block_id',
            'targetForeignKey' => 'phinxlog_id',
            'joinTable' => 'content_blocks_phinxlog',
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
            ->scalar('parent')
            ->maxLength('parent', 128)
            ->requirePresence('parent', 'create')
            ->notEmptyString('parent');

        $validator
            ->scalar('slug')
            ->maxLength('slug', 128)
            ->requirePresence('slug', 'create')
            ->notEmptyString('slug');

        $validator
            ->scalar('label')
            ->maxLength('label', 255)
            ->requirePresence('label', 'create')
            ->notEmptyString('label');

        $validator
            ->scalar('description')
            ->maxLength('description', 255)
            ->requirePresence('description', 'create')
            ->notEmptyString('description');

        $validator
            ->scalar('type')
            ->maxLength('type', 32)
            ->requirePresence('type', 'create')
            ->notEmptyString('type');

        $validator
            ->scalar('value')
            ->allowEmptyString('value');

        $validator
            ->scalar('previous_value')
            ->allowEmptyString('previous_value');

        return $validator;
    }
}
