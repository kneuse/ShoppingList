<?php

//Shopping Items Controller
class ShoppingItemsController extends AppController {
	var $components = array('Auth');
	
	public function viewAll($id = null) {
		//read the current list and save to session
		if(isset($id) && $this->getListId() != $id) {
			$this->ShoppingList = ClassRegistry::init('ShoppingList');
			$ShoppingListItem = $this->ShoppingList->Read(null, $id);
			if($ShoppingListItem["ShoppingList"]["user_id"] == $this->Session->read('Auth.User')['id'])
			{
				$this->Session->Write("currentListId", $id);
				$this->Session->Write("currentList", $ShoppingListItem);
			}
			else
			{
				$this->redirect(array("action" => "viewAll", $this->getListId()));
			}
		}
	
		//Read the current shopping list
		$currentList = $this->Session->read("currentList");
		
		if($currentList != null){
			//set some variables for creating a link back to the shopping lists view
			$currentList = $currentList["ShoppingList"];
			$this->set('listId', $currentList["id"]);
			$this->set('listName', $currentList["name"]);
	
			if($currentList["id"])
			{
				//find all shopping items that correspond to the current shopping list
				$shoppingItems = $this->ShoppingItem->find('all',
						array('conditions' => array('ShoppingItem.list_id' => $currentList["id"]))
				);
			}
		}
		else
		{
			$shoppingItems = array();
		}
		$this->set('shoppingItems', $shoppingItems);
	}
	
	public function addItem() {
		if ($this->request->is('post')) {
			
			//create new shopping item
			$this->ShoppingItem->create();
			$this->ShoppingItem->Set('list_id', $this->getListId());
			$this->ShoppingItem->Set('retrieved', 0);
			
			//save to database
			if($this->ShoppingItem->save($this->request->data)) {
				$this->Session->setFlash(__('The item has been added'));
				$this->redirect("viewAll");
			}
			else
			{
				$this->Session->setFlash(__($this->ShoppingItem->validationErrors));
			}
		}
	}
	
	public function removeItem($id) {
		if($this->request->is('get')) {
			
			//delete shopping item from database
			if ($this->ShoppingItem->delete($id)) {
				$this->Session->setFlash('The item has been removed!');
			}
			else
			{
				$this->Session->setFlash('Failed to remove item!');
			}
			
			$this->redirect("viewAll");
		}
	}
	
	//cache the current listId and return it.
	private function getListId()
	{
		//
		static $listId = null;
		if($listId == null)
		{
			$data = $this->Session->read("currentList");
			if($data != null)
			{
				$listId = $data["ShoppingList"]["id"];
			}
		}
		return $listId; 
	}
	
	//This method will update all items in the current shopping list
	public function updateAll() {
		$failed = true;
		
		//iterate through the post
		$inputKeys = array_keys($this->request->data);
		for($loop = 0; $loop < count($inputKeys); $loop+=3)
		{
			//first post input = id
			$id = $inputKeys[$loop];
			//second post input = retrieved
			$retrieved = $this->request->data[$inputKeys[$loop+1]];
			//third post input = quantity
			$quantity = $this->request->data[$inputKeys[$loop+2]];
				
			//read the shopping item
			$this->ShoppingItem->Read(null, $id);
			if($this->ShoppingItem->data["ShoppingItem"]["list_id"] == $this->getListId())
			{
				//update the shopping item
				$this->ShoppingItem->Set("quantity", $quantity);
				$this->ShoppingItem->Set("retrieved", $retrieved);
				if($this->ShoppingItem->Save())
				{
					$failed = false;
				}
			}
		}
	
		//output status
		if($failed)
		{
			$this->Session->setFlash(__('Failed to save data'));
		}
		else
		{
			$this->Session->setFlash(__('Your changes have been saved!'));
		}
		$this->redirect("viewAll");
	}
}