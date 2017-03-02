<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * Project Entity
 *
 * @property int $id
 * @property int $parent_id
 * @property string $title
 * @property bool $is_archived
 *
 * @property \App\Model\Entity\Project $parent_project
 * @property \App\Model\Entity\Project[] $child_projects
 * @property \App\Model\Entity\Task[] $tasks
 * @property \App\Model\Entity\Tag[] $tags
 */
class Project extends Entity {

	/**
	 * Fields that can be mass assigned using newEntity() or patchEntity().
	 *
	 * Note that when '*' is set to true, this allows all unspecified fields to
	 * be mass assigned. For security purposes, it is advised to set '*' to false
	 * (or remove it), and explicitly make individual fields accessible as needed.
	 *
	 * @var array
	 */
	protected $_accessible = [
		'*' => true,
		'id' => false
	];

	public function archive() {
		$this->set('is_archived', 1);
		$repository = TableRegistry::get($this->_registryAlias);
		return $repository->save($this);
	}

	public function getPercentageCompleted() {
		if (count($this->unarchived_tasks) === 0) {
			return 0;
		}
		// Calculate ratio completed of tasks
		$count = 0;
		foreach ($this->unarchived_tasks as $task) {
			$count += (int) $task->getRatioCompleted();
		}

		$ratio = $count / count($this->unarchived_tasks);
		$percentage = $ratio * 100;
		if (fmod($percentage, 1) != 0) {
			return number_format($percentage, 2, ',', '.');
		} else {
			return $percentage;
		}
	}

	public function getTasksAsTree($is_archived = false) {
		$repository = TableRegistry::get('Tasks');
		$repository->behaviors()->Tree->config('scope', ['project_id' => $this->id]);

		$query = $repository->find('threaded');
		$query->where(['project_id' => $this->id]);
		$query->where(['is_archived' => (bool) $is_archived]);
		// $query->order(['lft']);
		return $query->toArray();
	}

	public function getTasksCount() {
		return count($this->unarchived_tasks);
	}

}
