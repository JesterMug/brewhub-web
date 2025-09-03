<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Forms Model
 *
 * @method \App\Model\Entity\Form newEmptyEntity()
 * @method \App\Model\Entity\Form newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Form> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Form get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Form findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Form patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Form> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Form|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Form saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Form>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Form>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Form>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Form> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Form>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Form>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Form>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Form> deleteManyOrFail(iterable $entities, array $options = [])
 */
class FormsTable extends Table
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

        $this->setTable('forms');
        $this->setDisplayField('first_name');
        $this->setPrimaryKey('id');
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
            ->scalar('first_name')
            ->maxLength('first_name', 63)
            ->requirePresence('first_name', 'create')
            ->notEmptyString('first_name');

        $validator
            ->scalar('last_name')
            ->maxLength('last_name', 63)
            ->requirePresence('last_name', 'create')
            ->notEmptyString('last_name');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email');

        $validator
            ->scalar('message')
            ->requirePresence('message', 'create')
            ->notEmptyString('message');

        $validator
            ->boolean('replied_status')
            ->notEmptyString('replied_status');

        $validator
            ->dateTime('date_created')
            ->notEmptyDateTime('date_created');

        $validator
            ->dateTime('date_replied')
            ->allowEmptyDateTime('date_replied');

        return $validator;
    }
}
