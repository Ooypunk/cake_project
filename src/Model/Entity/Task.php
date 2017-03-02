<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * Task Entity
 *
 * @property int $id
 * @property int $parent_id
 * @property int $project_id
 * @property string $title
 * @property string $description
 * @property bool $is_completed
 * @property bool $is_archived
 *
 * @property \App\Model\Entity\Task $parent_task
 * @property \App\Model\Entity\Project $project
 * @property \App\Model\Entity\Task[] $child_tasks
 */
class Task extends Entity {

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

	public function complete() {
		$this->set('is_completed', 1);
		$repository = TableRegistry::get($this->_registryAlias);
		return $repository->save($this);
	}

	public function getPctCompleted() {
		$ratio = $this->getRatioCompleted();
		$percentage = $ratio * 100;
		return $percentage;
	}

	public function getRatioCompleted() {
		// Check if task has children
		$child_tasks = $this->getChildTasks();
		if (count($child_tasks) > 0) {
			// Task has children, calculate completed ratio
			$count = 0;
			foreach ($child_tasks as $task) {
				$count += (int) $task->getRatioCompleted();
			}
			$ratio = $count / count($child_tasks);
			return $ratio;
		}
		// No children, just return is_completed
		return (int) $this->is_completed;
	}

	public function getChildTasks() {
		$repository = TableRegistry::get($this->_registryAlias);
		$query = $repository->find();
		$query->where([
			'parent_id' => $this->id,
			'is_archived' => 0,
		]);
		return $query->toArray();
	}

	public function hasChildTasks() {
		$child_tasks = $this->getChildTasks();
		return count($child_tasks) > 0;
	}

}
