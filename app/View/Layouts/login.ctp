<!DOCTYPE HTML>
<html>
<head>
<?php
echo $this->Html->css('bootstrap.min');
echo $this->Html->css('cake.generic');
?>
</head>
<body>
<?php echo $this->Session->flash(); ?>

<?php echo $this->fetch('content'); ?>
</body>
</html>
