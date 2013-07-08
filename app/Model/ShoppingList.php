<?php
class ShoppingList extends AppModel {
	public $hasMany = array(
			'ShoppingItem' => array(
					'className'  => 'ShoppingItem',
					'foreignKey' => 'list_id',
					'dependent' => true,
					'exclusive' => true
			)
	);
	
	var $validate = array (
		'name' => array (
				'required' => array(
						'rule' => array('notEmpty'),
						'message' => 'A username is required'
				)
		),
	);
	
	public function beforeDelete($cascade = true)
	{
		$shoppingList = $this->find("first", array(
				'conditions' => array("ShoppingList.Id" => $this->id)
		));
		$user_id = CakeSession::read("Auth.User.id");
	
		//query to see if user created shopping list
		$count = $this->find("count", array(
				"conditions" => array("user_id" => $user_id, 'id' => $this->id)
		));

		//prevent delete if user did not create shopping list
		return($count > 0);
	
	}
	
	public function beforeSave($options = array())
	{
		if(isset($options["user_id"]))
		{
			$this->data[$this->alias]['user_id'] = $options['user_id'];
		}
	}
}