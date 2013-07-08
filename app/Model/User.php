<?php
class User extends AppModel {
	public $hasMany = array(
			'ShoppingList' => array(
					'className'  => 'ShoppingList'
			)
	);
	
	var $validate = array(
	// other validation code
			'username' => array(
				'required' => array( 
					'rule' => array('notEmpty'),
                	'message' => 'A username is required'
				),
				'unique' => array(
					'rule' => array('isUnique'),
					'message' => 'The username you have chosen already exists!'
				)
			),
			'password' => array(
					'match' => array(
							'rule' => array('match', 'confirmPassword'),
							'message' => 'Passwords doesn\'t match'
				)
			),
			'confirmPassword' => array('required' => array ( 
					'rule' => array('notEmpty'),
                	'message' => 'A username is required'
				)
			)
		);
	
	public function beforeSave($options = array()) {
		//encrypt password
		$this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
	}
	
	public function match($password, $confirmPassword) {
		// Removing blank fields
		$password = trim($password["password"]);
		$confirmPassword = trim($this->data[$this->name][$confirmPassword]);
	
		// If both arent empty we compare and return true or false
		if (!empty($password) && !empty($confirmPassword)) {
			return $password == $confirmPassword;
		}
	
		// Return false, some fields is empty
		return false;
	}
}