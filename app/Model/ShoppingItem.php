<?php
class ShoppingItem extends AppModel {
	var $belongsTo = array(
			'list' => array('className'=>'ShoppingList', 'foreignKey'=>'list_id')
	);
	
	var $validate = array (
		'name' => array (
				'required' => array(
						'rule' => array('notEmpty'),
						'message' => 'A username is required'
				)
		),
		'quantity' => array (
				'required' => array(
						'rule' => array('notEmpty'),
						'message' => 'An item quantity is required'
				),
		)
	);
	
	public function beforeDelete($cascade = true) 
	{
		$this->ShoppingList = ClassRegistry::init('ShoppingList');
		$shoppingItem = $this->find("first", array(
				'conditions' => array("ShoppingItem.Id" => $this->id)
		));
		$list_id = $shoppingItem["ShoppingItem"]["list_id"];
		$user_id = CakeSession::read("Auth.User.id");
		
		$count = $this->ShoppingList->find("count", array(
				"conditions" => array(
						"id" => $list_id, 
						"user_id" => $user_id
				)
			)
		);
		
		return $count > 0;
		
	}
	
	public function beforeSave($options = array())
	{
		if(isset($options["retrieved"]))
		{
			$this->data[$this->alias]['retrieved'] = $options["retrieved"]; 
		}
		if(isset($options["list_id"]))
		{
			$this->data[$this->alias]['list_id'] = $options['list_id'];
		}
	}
}
?>