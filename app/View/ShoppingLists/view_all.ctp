<?php
	echo $this->Form->create('ShoppingList', array('action' => 'addList'));
	echo $this->Form->input('name');
	echo $this->Form->end('Create List');
?>

<table>
	<tr>
		<th width="300">Name</th>
		<th>Action</th>
	</tr>
	
	<?php foreach ($shoppingLists as $shoppingList):
		$currentItem = $shoppingList["ShoppingList"];
	?>
	<tr>
		<td><?php echo $currentItem["name"]; ?></td>
		<td><?php echo $this->Html->Link("View", array("controller" => "ShoppingItems", "action" => "viewAll", $currentItem["id"]), array("class" => "btn btn-success")); ?>
		<?php echo $this->Html->Link("Delete", array("controller" => "ShoppingLists", "action" => "removeList", $currentItem["id"]), array("class" => "btn btn-danger")); ?></td>
	</tr>
	<?php endforeach; ?>
</table>