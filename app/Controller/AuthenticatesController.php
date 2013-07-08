<?php
class AuthenticatesController extends AppController {
	var $uses = array('User');
	var $components = array('Auth' => array(
				'authorize' => 'actions',
				'actionPath' => 'controller/',
				'loginAction' => array(
							'controller' => 'authenticates',
							'action' => 'login',
							'plugins' => false,
							'admin' => false,
						),
				'loginRedirect' => array('controller' => 'ShoppingLists', 'action' => 'viewAll'),
				'logoutRedirect' => array('controller' => 'Index','action' => 'index')
			),'Session');
	var $name = 'Authenticates';
	
	function beforeFilter(){
		$this->Auth->allow('register', 'logout', 'login');
		$this->layout='login';
	}
	
	function login() {
		if ($this->request->is('post')) {
			//$this->data['User']['confirmPassword'] = $this->Auth->password($this->data['User']['confirmPassword']);			
			if ($this->Auth->login()) {
				return $this->redirect($this->Auth->redirectUrl());
				// Prior to 2.3 use `return $this->redirect($this->Auth->redirect());`
			} else {
				$this->Session->setFlash(__('Username or password is incorrect'), 'default', array(), 'auth');
			}
		}
	}
	
	function register()
	{
		if ($this->request->is('post')) {
			//$this->data['User']['confirmPassword'] = $this->Auth->password( $this->data['User']['confirmPassword']);
			$this->User->create();
			if($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'));
				$this->redirect(array(
					'controller' => 'Index',
					'action' => 'index'
				));
			}
		}
	}
	
	function logout() {
		$this->redirect($this->Auth->logout());
	}
}