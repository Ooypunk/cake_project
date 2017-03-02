<?php

namespace App\Controller;

use App\Controller\AppController;

/**
 * Tags Controller
 *
 * @property \App\Model\Table\TagsTable $Tags
 */
class TagsController extends AppController {

	/**
	 * Index method
	 *
	 * @return \Cake\Network\Response|null
	 */
	public function index() {
		$tags = $this->paginate($this->Tags);

		$this->set(compact('tags'));
		$this->set('title', __('Tags'));
		$this->set('_serialize', ['tags']);
	}

	/**
	 * View method
	 *
	 * @param string|null $id Tag id.
	 * @return \Cake\Network\Response|null
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	public function view($id = null) {
		$tag = $this->Tags->get($id, [
			'contain' => ['Projects']
		]);

		$this->set('title', $tag->title);

		$this->set('tag', $tag);
		$this->set('_serialize', ['tag']);
	}

	/**
	 * Add method
	 *
	 * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
	 */
	public function add() {
		$tag = $this->Tags->newEntity();
		if ($this->request->is('post')) {
			$tag = $this->Tags->patchEntity($tag, $this->request->data);
			if ($this->Tags->save($tag)) {
				$this->Flash->success(__('The tag has been saved.'));

				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error(__('The tag could not be saved. Please, try again.'));
			}
		}
		$projects = $this->Tags->Projects->find('list', ['limit' => 200]);
		$this->set('title', __('Add Tag'));
		$this->set(compact('tag', 'projects'));
		$this->set('_serialize', ['tag']);
	}

	/**
	 * Edit method
	 *
	 * @param string|null $id Tag id.
	 * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
	 * @throws \Cake\Network\Exception\NotFoundException When record not found.
	 */
	public function edit($id = null) {
		$tag = $this->Tags->get($id, [
			'contain' => ['Projects']
		]);
		if ($this->request->is(['patch', 'post', 'put'])) {
			$tag = $this->Tags->patchEntity($tag, $this->request->data);
			if ($this->Tags->save($tag)) {
				$this->Flash->success(__('The tag has been saved.'));

				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error(__('The tag could not be saved. Please, try again.'));
			}
		}
		$projects = $this->Tags->Projects->find('list', ['limit' => 200]);
		$this->set(compact('tag', 'projects'));
		$this->set('title', __('Edit Tag'));
		$this->set('_serialize', ['tag']);
	}

	/**
	 * Delete method
	 *
	 * @param string|null $id Tag id.
	 * @return \Cake\Network\Response|null Redirects to index.
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	public function delete($id = null) {
		$this->request->allowMethod(['post', 'delete']);
		$tag = $this->Tags->get($id);
		if ($this->Tags->delete($tag)) {
			$this->Flash->success(__('The tag has been deleted.'));
		} else {
			$this->Flash->error(__('The tag could not be deleted. Please, try again.'));
		}

		return $this->redirect(['action' => 'index']);
	}

	public function jsonGet() {
		$this->autoRender = false;
		$status['msg'] = "this is a message from cake controller";

		$this->set(compact('status'));
		$this->set('_serialize', ['status']);
//
//		$query = $this->Tags->find('all');
//		$tags = $query->toArray();
//
//		header('Content-type: text/json');
//		$output = [
//			'results' => $tags,
//		];
//		die(json_encode($output));
	}

}
