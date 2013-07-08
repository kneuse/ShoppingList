<?php
	if($this->Session->read('Auth.User'))
	{
		echo $this->Html->link('Shopping List', array('controller' => 'ShoppingLists', 'action' => 'ViewAll'));		
	}
	else
	{
		echo $this->Html->link('Register', array('controller' => 'Authenticates', 'action' => 'Register'));
	}
?>