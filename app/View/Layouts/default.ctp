<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'Shopping List');

//function that will output tabs to the current layout.
if(function_exists('OutputTabs') == false) {
function OutputTabs($pages, $page)
{
	foreach($pages as $pageName => $pageLinks)
	{
		if(isset($pageLinks["Controller"]))
		{
			$pageLinks = Array($pageLinks);
		}
	
		$foundLink = false;
		foreach($pageLinks as $pageLink)
		{
			$pageController = $pageLink["Controller"];
			$pageAction = $pageLink["Action"];
			if($pageController == $page->name && $pageAction == $page->action)
			{
				$foundLink = true;
			}
		}
	
		if($foundLink)
		{
			echo "<li class='active'><a href='' data-toggle='tab'>" . $pageName . "</a></li>";
		}
		else
		{
			echo "<li>" . $page->Html->link($pageName, array('controller' => $pageController, 'action' => $pageAction)) . "</li>";
		}
	
	}
}}
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');
		echo $this->Html->css('bootstrap.min');
		echo $this->Html->css('cake.generic');
		echo $this->Html->css('login.panel');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
	<div id="container">
		<?php
			$tabs = Array();
			$tabs["Home"] = Array("Controller" => "Index", "Action" => "index");

			if(!$this->Session->read('Auth.User'))
			{
				//display login panel
				echo "<div id='loginPanel'>";
				echo $this->Form->create('User', array('url' => array('controller'=>'Authenticates', 'action'=>'login'), 'id' => 'AuthenticationLogin'));
	    		echo $this->Form->input('username', array('label' => 'Username: '));
	    		echo $this->Form->input('password', array('label' => 'Password: '));
	    		echo $this->Form->end('Login');
	    		echo "</div>";
			}
			else
			{
				//display logoff link
				echo "<div id='logoutPanel'>Welcome " . $this->Session->read('Auth.User')['username'] . " [" . $this->Html->link('Log Off', array('controller' => 'Authenticates', 'action' => 'logout')) . "]</div>";
				$tabs["Shopping List"] = Array(
					Array("Controller" => "ShoppingItems", "Action" => "viewAll"),
					Array("Controller" => "ShoppingLists", "Action" => "viewAll")
				);
			}
			
			$tabs["About"] = Array("Controller" => "About", "Action" => "about");
    	?>    	
		
		<div id="header">
			<h1><?php echo $this->Html->link($cakeDescription, array('controller' => 'Index', 'action' => 'index')); ?></h1>
		</div>
		<ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
		<?php OutputTabs($tabs, $this); ?>
		</ul>
		<div id="content">
			<?php echo $this->Session->flash(); ?>
			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="footer">
			
		</div>
	</div>
</body>
</html>
