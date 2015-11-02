<?php
if($this->session->flashdata('exito') != ''){
    ?>
    <div class="exito"><?php echo $this->session->flashdata('exito'); ?></div>
    <?php
}
if($this->session->flashdata('error') != ''){
    ?>
    <div class="errores"><?php echo $this->session->flashdata('error'); ?></div>
    <?php
}
if($this->session->flashdata('info') != ''){
    ?>
    <div class="info"><?php echo $this->session->flashdata('info'); ?></div>
    <?php
}
if($this->session->flashdata('ControllerMessage') != ''){
	?>
	<div class="errorFrontend"><?php echo $this->session->flashdata('ControllerMessage'); ?></div>
	<?php
}
?>
<!DOCTYPE html>
<html lang="es">
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
<body>
<div class="formulario" style="font-size:10px;">
    <center><h3>Casos Notificados por Fiebre Chikungunya</h3></center>
	<a class="btn btn-primary btn-xs" href="<?php echo site_url('modulos/listarChikungunya');?>" role="button"><span class="glyphicon glyphicon-backward"></span>&nbsp;Regresar</a>
    <div>
	<?php echo $output; ?>
    </div>
</div>
</body>
</html>