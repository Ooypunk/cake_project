<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Network\Exception\NotAcceptableException;

/**
 * Tasks Controller
 *
 * @property \App\Model\Table\TasksTable $Tasks
 */
class TasksController extends AppController {

	/**
	 * Index method
	 *
	 * @return \Cake\Network\Response|null
	 */
	public function index() {
		$this->paginate = [
			'contain' => ['ParentTasks', 'Projects'],
			'finder' => 'unarchived',
		];
		$tasks = $this->paginate($this->Tasks);

		$this->set(compact('tasks'));
		$this->set('title', __('Tasks'));
		$this->set('_serialize', ['tasks']);
	}

	/**
	 * View method
	 *
	 * @param string|null $id Task id.
	 * @return \Cake\Network\Response|null
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	public function view($id = null) {
		$task = $this->Tasks->get($id, [
			'contain' => ['ParentTasks', 'Projects', 'ChildTasks']
		]);

		$this->set('title', $task->title);

		$this->set('task', $task);
		$this->set('_serialize', ['task']);
	}

	/**
	 * Add method
	 *
	 * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
	 */
	public function add($project_id = null) {
		$task = $this->Tasks->newEntity();
		if ($this->request->is('post')) {
			$task = $this->Tasks->patchEntity($task, $this->request->data);
			if ($this->Tasks->save($task)) {
				$this->Flash->success(__('The task has been saved.'));

				return $this->redirect(['controller' => 'Projects', 'action' => 'view', $task->project_id]);
			} else {
				$this->Flash->error(__('The task could not be saved. Please, try again.'));
			}
		}
		$parentTasks = $this->Tasks->ParentTasks->find('list', ['limit' => 200]);
		$projects = $this->Tasks->Projects->find('list', ['limit' => 200]);
		if ($project_id !== null) {
			$task->project_id = $project_id;
		}
		$this->set(compact('task', 'parentTasks', 'projects'));
		$this->set('title', __('Add Task'));
		$this->set('_serialize', ['task']);
	}

	/**
	 * Edit method
	 *
	 * @param string|null $id Task id.
	 * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
	 * @throws \Cake\Network\Exception\NotFoundException When record not found.
	 */
	public function edit($id = null) {
		$task = $this->Tasks->get($id, [
			'contain' => []
		]);
		if ($this->request->is(['patch', 'post', 'put'])) {
			$task = $this->Tasks->patchEntity($task, $this->request->data);
			if ($this->Tasks->save($task)) {
				$this->Flash->success(__('The task has been saved.'));

				return $this->redirect(['controller' => 'Projects', 'action' => 'view', $task->project_id]);
			} else {
				$this->Flash->error(__('The task could not be saved. Please, try again.'));
			}
		}
		$parentTasks = $this->Tasks->ParentTasks->find('list', ['limit' => 200]);
		$projects = $this->Tasks->Projects->find('list', ['limit' => 200]);
		$this->set(compact('task', 'parentTasks', 'projects'));
		$this->set('title', __('Edit Task'));
		$this->set('_serialize', ['task']);
	}

	/**
	 * 
	 * @param string|null $id Task id.
	 * @return \Cake\Network\Response Redirects to index page
	 */
	public function archive($id = null) {
		$this->request->allowMethod(['post', 'delete']);
		$task = $this->Tasks->get($id);
		if ($task->archive()) {
			$this->Flash->success(__('The task has been archived.'));
		} else {
			$this->Flash->error(__('The task could not be archived. Please, try again.'));
		}

		return $this->redirect(['action' => 'index']);
	}

	/**
	 * 
	 * @param string|null $id Task id.
	 * @return \Cake\Network\Response Redirects to index page
	 */
	public function complete($id = null) {
		$this->request->allowMethod(['post', 'delete']);
		$task = $this->Tasks->get($id);
		if ($task->hasChildTasks()) {
			throw new NotAcceptableException(__('Cannot complete a task that has children'));
		}
		if ($task->complete()) {
			$this->Flash->success(__('The task has been completed.'));
		} else {
			$this->Flash->error(__('The task could not be completed. Please, try again.'));
		}

		return $this->redirect(['controller' => 'Projects', 'action' => 'view', $task->project_id]);
	}

}
