<?php
class ShoppingListsController extends AppController {
	var $components = array('Auth');
	
	public function removeList($id) {
		if($this->request->is('get')) {
			if ($this->ShoppingList->delete($id)) {
				$this->Session->setFlash('The list has been removed!');
			}
			else
			{
				$this->Session->setFlash('Error removing List!');
			}
			$this->redirect("viewAll");
		}
	}
	
	public function viewAll() {
		$user_id = $this->Session->read('Auth.User')['id'];
		$shoppingLists = $this->ShoppingList->find('all',
				array('conditions' => array('ShoppingList.user_id' => $user_id))
		);
		$this->set("shoppingLists", $shoppingLists);
	}
	
	public function addList() {
		if ($this->request->is('post')) {
			$this->ShoppingList->create();
			$this->ShoppingList->Set('user_id', $this->Auth->user("id"));
			print_r($this->request->data);
			if($this->ShoppingList->save($this->request->data)) {
				$this->Session->setFlash(__('The list has been added'));
			}
			else
			{
				$this->Session->setFlash(__($this->ShoppingList->validationErrors));	
			}
			$this->redirect("viewAll");
		}
	}
}