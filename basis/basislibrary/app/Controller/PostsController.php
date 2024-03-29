<?php
class PostsController extends AppController {
	
	
	public $helpers = array('Html', 'Form');
	public $components = array('Session');
	
	function index() {
		$this->set('posts', $this->Post->find('all'));
		$this->set('posts', $this->paginate());
		
		
	}
	
	function view($id = null) {
		$this->Post->id = $id;
		$this->set('post', $this->Post->read());
	}
	
	function add() {
		if($this->request->is('post')) {
			if ($this->Post->save($this->request->data)) {
				$this->Session->setFlash('Your post has been saved.');
				$this->redirect(array('action' => 'index'));
				
			}
			else {
				$this->Session->setFlash('Unable to add your post');
			}
		}
	}
	
	//Edit
	function edit($id = null) {
		$this->Post->id = $id;
		if($this->request->is('get')) {
			$this->request->data = $this->Post->read();
		}
		else {
			if($this->Post->save($this->request->data)) {
				$this->Session->setFlash('Your post has been updated');
				$this->redirect(array('action' => 'index'));
				
			}
			else {
				$this->Session->setFlash('Unable to update your post');
			}
		}
		
	}
	
	//Delete
	function delete($id) {
		if($this->request->is('get')) {
			throw new MethodNotAllowedException();
		}
		else{
			$this->Post->delete($id);
			$this->Session->setFlash('The post with id '. $id .' has been removed');
			$this->redirect(array('action' => 'index'));
		}
	}
	
	
}