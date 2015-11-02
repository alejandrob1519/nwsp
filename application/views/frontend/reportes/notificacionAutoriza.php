<?php
/**********************************************************  
*   REPORTE DE REGISTROS NOTIFICADOS POR OTRAS DIRESAS    *
***********************************************************/
if($this->session->flashdata('exito') != ''){
	?>
	<div class="exitoFrontend"><?php echo $this->session->flashdata('exito'); ?></div>
	<?php
}
if($this->session->flashdata('error') != ''){
	?>
	<div class="errorFrontend"><?php echo $this->session->flashdata('error'); ?></div>
	<?php
}
if($this->session->flashdata('info') != ''){
	?>
	<div class="infoFrontend"><?php echo $this->session->flashdata('info'); ?></div>
	<?php
}
?>
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
    <center><h3 style="background-color:#CEE3F6;">AUTORIZACION DE LA NOTIFICACION SEMANAL</h3></center>
    <p><b style="color:#F00">La ejecución de este proceso, ser&aacute; tomado como constancia de que la DIRESA ha realizado
    la revisi&oacute;n y control de calidad registro por registro de la notificación semanal de los casos de las 
    enfermedades sujetas a vigilancia epidemiol&oacute;gica en la semana para la cual se realizará la autorizaci&oacute;n.</b></p>
    <div>
	<?php echo $output; ?>
    </div>
</div>
</body>
</html>