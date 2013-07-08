<?php echo $this->Html->Link("Shopping Lists", array("controller" => "ShoppingLists", "action" => "viewAll", $listId)) . " > " . $listName ?> 

<h2><?php echo $listName ?> Shopping List</h2>
<?php
	echo $this->Form->create('ShoppingItem', array('action' => 'addItem'));
	echo $this->Form->input('name');
	echo $this->Form->input('quantity');
	echo $this->Form->end('Add Item'); 
?>	
<?php echo $this->Form->create('ShoppingItem', array('action' => 'updateAll')); ?>
<table>
	<tr>
		<th width="20">Retrieved</th>
		<th width="200">Item</th>
		<th>Quantity</th>
		<th>Action</th>
	</tr>
	
	<?php foreach ($shoppingItems as $shoppingItem):
		$currentItem = $shoppingItem["ShoppingItem"];
		echo $this->form->hidden($currentItem['id'], array("value" => ""));
		$retrievedCheckBox = $this->form->input("retrieved_" . $currentItem['id'], array('type' => 'checkbox', 'label' => '', 'checked' => $currentItem['retrieved'])); 
	?>
	<tr>
		<td><?php echo $retrievedCheckBox ?></td>
		<td><?php echo $currentItem["name"]; ?></td>
		<td><?php echo $this->form->input("quantity_" . $currentItem['id'], array('label' => '', 'value' => $currentItem["quantity"], 'style' => 'width:50px')); ?></td>
		<td><?php echo $this->Html->Link("Remove", array("action" => "removeItem", $currentItem["id"]), array("class" => "btn btn-danger")); ?></td>
	</tr>
	<?php endforeach; ?>
</table>
<?php echo $this->Form->end('Update Shopping List'); ?>