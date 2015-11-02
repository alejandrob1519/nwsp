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
    <center><h2>Registro de Tipos de Diagn&oacute;stico de la Vigilancia Epidemiol&oacute;gica</h2></center>
    <div>
	<?php echo $output; ?>
    </div>
</div>
</body>
</html>