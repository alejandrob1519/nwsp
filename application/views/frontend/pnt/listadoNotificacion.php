<?php
/************************************************  
*   REGISTRO DE NOTIFICACION TELEMATICA SEMANAL *
************************************************/
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
<body>
<div class="formulario">
    <center><h3 style="background-color:#CEE3F6;">REGISTRO NOTIFICACION TELEMATICA SEMANAL</h3></center>
    <p><b style="color:#F00">La ejecución de este proceso, actualizará la información de la base de datos del sistema NotiWeb con la que 
    contienen los archivos que en este momento est&aacute; por enviar. Se le recuerda hacer siempre un backup de la base 
    de datos con la opción correspondiente antes de realizar este proceso. 
    El archivo ZIP que está a punto de procesar debe ser aquel generado por el Programa de Notificaci&oacute;n 
    Telem&aacute;tica del Software NotiSP. Por el momento este proceso solo lo podr&aacute;n realizar los usuarios con el nivel de DIRESA.
    Usted debe tener el cuidado de considerar que el proceso de notificaci&oacute;n solo se debe realizar una vez por semana ya que los registros que se remiten 
    serán sumados a la base de datos principal.</b></p>
    <p><b><center><<<<<<<<<<<<<<<<<<<<<<<<¡¡NO USAR OTRO ARCHIVO PARA ESTE PROCESO SINO EL GENERADO POR EL SOFTWARE NOTISP, BAJO RESPONSABILIDAD!!>>>>>>>>>>>>>>>>>>>>>>>>></center></b></p>
    <div>
	<?php echo $output; ?>
    </div>
</div>
</body>
</html>