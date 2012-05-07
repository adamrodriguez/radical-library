<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 */
class UsersController extends AppController {

	
	public function beforeFilter() {
		parent::beforeFilter();
		//$this->Auth->allow('initDB');
		$this->Auth->allow('add');

	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	
	
	// Remove when finished
	public function initDB() {
		$group = $this->User->Group;
		//Allow admins to everything
		$group->id = 2;
		$this->Acl->allow($group, 'controllers');
	
		//allow staff to posts and widgets
		$group->id = 3;
		$this->Acl->deny($group, 'controllers');
		$this->Acl->deny($group, 'controllers/Users/add');
		$this->Acl->deny($group, 'controllers/Users/view');
		$this->Acl->allow($group, 'controllers/Users/logout');
		$this->Acl->allow($group, 'controllers/Books');
		$this->Acl->allow($group, 'controllers/Books/add');
		$this->Acl->allow($group, 'controllers/Books/search');
		$this->Acl->allow($group, 'controllers/Books/view');
		$this->Acl->allow($group, 'controllers/Books/checkout');
		$this->Acl->allow($group, 'controllers/Books/edit');
	
		//allow students to only add and edit on posts and widgets
		$group->id = 1;
		$this->Acl->deny($group, 'controllers');
		$this->Acl->deny($group, 'controllers/Users/add');
		$this->Acl->deny($group, 'controllers/Users/view');
		$this->Acl->deny($group, 'controllers/Books/add');
		$this->Acl->deny($group, 'controllers/Books/edit');
		$this->Acl->deny($group, 'controllers/Books/delete');
		$this->Acl->allow($group, 'controllers/Users/logout');
		$this->Acl->allow($group, 'controllers/Books/index');
		$this->Acl->allow($group, 'controllers/Books/search');
		$this->Acl->allow($group, 'controllers/Books/checkout');
		$this->Acl->allow($group, 'controllers/Books/view');
		//we add an exit to avoid an ugly "missing views" error message
		echo "all done";
		exit;
	}
	
	
	public function view($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->set('user', $this->User->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		//$this->User->id = $id;
		if($this->Auth->user('group_id')=='1' || $this->Auth->user('group_id')=='3'){
			
			$this->redirect(array('action' => 'index'));
		}
		
			if ($this->request->is('post')) {
				$this->User->create();
				if ($this->User->save($this->request->data, $this->User->set(array('student' => $this->random36())))) {
					if ($this->User->field('group_id') != '1'){
						$this->User->saveField('student', null);
					}
					$this->Session->setFlash(__('The user has been saved'));
					$this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
				}
			}
		
			$groups = $this->User->Group->find('list');
			$this->set(compact('groups'));
		
	}
	
	
	function random36()
	{
		// 6 characters
		//$result = substr(base_convert(mt_rand(60466176, 2147483647), 10, 36), 0, 9);
		// for 12 characters or more, simply duplicate the stuff
		
		$result = substr(base_convert(mt_rand(60466176, 2147483647), 10, 36).base_convert(mt_rand(60466176, 2147483647), 10, 36), 0, 9);
		debug($result);
		return $result;
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->User->save($this->request->data, $this->User->set(array('student' => $this->random36())))) {
				$this->Session->setFlash(__('The user has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->User->read(null, $id);
		}
		$groups = $this->User->Group->find('list');
		$this->set(compact('groups'));
	}
	
	
	
	public function login() {
		if ($this->Session->read('Auth.User')) {
			$this->Session->setFlash('You are logged in!', 'success');
			$this->redirect('/', null, false);
		} else {
	
			if ($this->request->is('post')) {
					
				debug($this->User->exists());
				if ($this->Auth->login()) {
					$this->redirect($this->Auth->redirect(''));
					$this->Session->setFlash('Welcome, ', $this->Auth->user('firstname'), 'success');
				} else {
					$this->Session->setFlash(__('Invalid username or password, try again'));
				}
			}
		}
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->User->delete()) {
			$this->Session->setFlash(__('User deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('User was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
	
	public function logout() {
		$this->redirect($this->Auth->logout());
	}
	
}
