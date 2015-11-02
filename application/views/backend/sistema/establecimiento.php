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
	<?php
    if($this->session->flashdata('ControllerMessage') != ''){
        ?>
        <div class="exito"><?php echo $this->session->flashdata('ControllerMessage'); ?></div>
        <?php
    }
    ?>
    <center><h2>Registro de Establecimientos de Salud</h2></center>
    <div>
	<?php echo $output; ?>
    </div>
</div>
</body>
</html>