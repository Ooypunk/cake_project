<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use App\ORM\Rule\ExistsInOrZero;

/**
 * Tasks Model
 *
 * @property \Cake\ORM\Association\BelongsTo $ParentTasks
 * @property \Cake\ORM\Association\BelongsTo $Projects
 * @property \Cake\ORM\Association\HasMany $ChildTasks
 *
 * @method \App\Model\Entity\Task get($primaryKey, $options = [])
 * @method \App\Model\Entity\Task newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Task[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Task|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Task patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Task[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Task findOrCreate($search, callable $callback = null, $options = [])
 */
class TasksTable extends Table {

	/**
	 * Initialize method
	 *
	 * @param array $config The configuration for the Table.
	 * @return void
	 */
	public function initialize(array $config) {
		parent::initialize($config);

		$this->table('tasks');
		$this->displayField('title');
		$this->primaryKey('id');

		$this->belongsTo('ParentTasks', [
			'className' => 'Tasks',
			'foreignKey' => 'parent_id'
		]);
		$this->belongsTo('Projects', [
			'foreignKey' => 'project_id',
			'joinType' => 'INNER'
		]);
		$this->hasMany('ChildTasks', [
			'className' => 'Tasks',
			'foreignKey' => 'parent_id',
			'conditions' => [
				'is_archived' => 0,
			],
		]);

		$this->addBehavior('Tree');
	}

	/**
	 * Default validation rules.
	 *
	 * @param \Cake\Validation\Validator $validator Validator instance.
	 * @return \Cake\Validation\Validator
	 */
	public function validationDefault(Validator $validator) {
		$validator
				->integer('id')
				->allowEmpty('id', 'create');

		$validator
				->requirePresence('title', 'create')
				->notEmpty('title');

		$validator
				->allowEmpty('description');

		$validator
				->boolean('is_completed')
				// ->requirePresence('is_completed', 'create')
				->notEmpty('is_completed');

		$validator
				->boolean('is_archived')
				// ->requirePresence('is_archived', 'create')
				->notEmpty('is_archived');

		return $validator;
	}

	/**
	 * Returns a rules checker object that will be used for validating
	 * application integrity.
	 *
	 * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
	 * @return \Cake\ORM\RulesChecker
	 */
	public function buildRules(RulesChecker $rules) {
		// $rules->add($rules->existsIn(['parent_id'], 'ParentTasks'));
		$rules->add(new ExistsInOrZero(['parent_id'], 'ParentTasks'), [
			'errorField' => 'parent_id',
			'message' => __d('cake', 'This value does not exist')
		]);
		$rules->add($rules->existsIn(['project_id'], 'Projects'));

		return $rules;
	}

	public function findUnarchived(Query $query) {
		return $query->where([$this->table() . '.is_archived' => 0]);
	}

}
