<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use App\ORM\Rule\ExistsInOrZero;

/**
 * Projects Model
 *
 * @property \Cake\ORM\Association\BelongsTo $ParentProjects
 * @property \Cake\ORM\Association\HasMany $ChildProjects
 * @property \Cake\ORM\Association\HasMany $Tasks
 * @property \Cake\ORM\Association\BelongsToMany $Tags
 *
 * @method \App\Model\Entity\Project get($primaryKey, $options = [])
 * @method \App\Model\Entity\Project newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Project[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Project|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Project patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Project[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Project findOrCreate($search, callable $callback = null, $options = [])
 */
class ProjectsTable extends Table {

	/**
	 * Initialize method
	 *
	 * @param array $config The configuration for the Table.
	 * @return void
	 */
	public function initialize(array $config) {
		parent::initialize($config);

		$this->table('projects');
		$this->displayField('title');
		$this->primaryKey('id');

		$this->belongsTo('ParentProjects', [
			'className' => 'Projects',
			'foreignKey' => 'parent_id'
		]);
		$this->hasMany('ChildProjects', [
			'className' => 'Projects',
			'foreignKey' => 'parent_id'
		]);
		$this->hasMany('Tasks', [
			'foreignKey' => 'project_id'
		]);
		$this->hasMany('UnarchivedTasks', [
			'className' => 'Tasks',
			'foreignKey' => 'project_id',
			'conditions' => [
				'is_archived' => 0,
			],
		]);
		$this->belongsToMany('Tags', [
			'foreignKey' => 'project_id',
			'targetForeignKey' => 'tag_id',
			'joinTable' => 'projects_tags'
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
				->boolean('is_archived')
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
		// $rules->add($rules->existsIn(['parent_id'], 'ParentProjects'));
		$rules->add(new ExistsInOrZero(['parent_id'], 'ParentProjects'), [
			'errorField' => 'parent_id',
			'message' => __d('cake', 'This value does not exist')
		]);

		return $rules;
	}

	public function findUnarchived(Query $query) {
		return $query->where([$this->table() . '.is_archived' => 0]);
	}

}
