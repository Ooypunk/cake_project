<?php

namespace App\Controller;

use App\Controller\AppController;

/**
 * Projects Controller
 *
 * @property \App\Model\Table\ProjectsTable $Projects
 */
class ProjectsController extends AppController {

	/**
	 * Index method
	 *
	 * @return \Cake\Network\Response|null
	 */
	public function index() {
		$this->paginate = [
			'contain' => ['ParentProjects', 'UnarchivedTasks'],
			'finder' => 'unarchived',
			'order' => [
				'Projects.lft' => 'asc',
			],
		];
		$projects = $this->paginate($this->Projects);

		$this->set(compact('projects'));
		$this->set('title', __('Projects'));
		$this->set('_serialize', ['projects']);
	}

	/**
	 * View method
	 *
	 * @param string|null $id Project id.
	 * @return \Cake\Network\Response|null
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	public function view($id = null) {
		$project = $this->Projects->get($id, [
			'contain' => ['ParentProjects', 'Tags', 'ChildProjects', 'UnarchivedTasks']
		]);

		$this->set('project', $project);

		$project_title = $project->title;
		if ($project->has('parent_project')) {
			$project_title .= ' (< ' . $project->parent_project->title . ')';
		}

		$this->set('title', $project_title);
		$this->set('_serialize', ['project', 'title']);
	}

	/**
	 * Add method
	 *
	 * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
	 */
	public function add() {
		$project = $this->Projects->newEntity();
		if ($this->request->is('post')) {
			$project = $this->Projects->patchEntity($project, $this->request->data);
			if ($this->Projects->save($project)) {
				$this->Flash->success(__('The project has been saved.'));

				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error(__('The project could not be saved. Please, try again.'));
			}
		}
		$parentProjects = $this->Projects->ParentProjects->find('treelist', ['limit' => 200]);
		$tags = $this->Projects->Tags->find('list', ['limit' => 200]);
		$this->set(compact('project', 'parentProjects', 'tags'));
		$this->set('title', __('Add Project'));
		$this->set('_serialize', ['project']);
	}

	/**
	 * Edit method
	 *
	 * @param string|null $id Project id.
	 * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
	 * @throws \Cake\Network\Exception\NotFoundException When record not found.
	 */
	public function edit($id = null) {
		$project = $this->Projects->get($id, [
			'contain' => ['Tags']
		]);
		if ($this->request->is(['patch', 'post', 'put'])) {
			$project = $this->Projects->patchEntity($project, $this->request->data);
			if ($this->Projects->save($project)) {
				$this->Flash->success(__('The project has been saved.'));

				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error(__('The project could not be saved. Please, try again.'));
			}
		}
		$parentProjects = $this->Projects->ParentProjects->find('treelist', ['limit' => 200]);
		$tags = $this->Projects->Tags->find('list', ['limit' => 200]);
		$this->set(compact('project', 'parentProjects', 'tags'));
		$this->set('title', __('Edit Project'));
		$this->set('_serialize', ['project']);
	}

	public function tree() {
		$tree = $this
				->Projects
				->find('threaded')
				->toArray();
		$json_tree = $this->treeToJson($tree);
		die(json_encode($json_tree));
	}

	public function tasksTree($id = null) {
		$project = $this->Projects->get((int) $id);
		$tree = $project->getTasksAsTree(false);
		$json_tree = $this->treeToJson($tree);
		die(json_encode($json_tree));
	}

	private function treeToJson(array $tree) {
		$nodes = [];
		foreach ($tree as $leaf) {
			$node = new \stdClass();
			$node->text = $leaf->title;
			$node->href = "#node-" . $leaf->id;
			if (isset($leaf->children) && count($leaf->children) > 0) {
				$node->nodes = $this->treeToJson($leaf->children);
			}
			$nodes[] = $node;
		}
		return $nodes;
	}

}
