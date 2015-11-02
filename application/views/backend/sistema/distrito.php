<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
<?php 
foreach($css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
<?php foreach($js_files as $file): ?>
	<script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>
</head>
<div class="formulario">
    <center><h2>Registro de Distritos del Per&uacute;</h2></center>
    <div>
	<?php echo $output; ?>
    </div>
</div>
</body>
</html>