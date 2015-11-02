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
    <center><h2>Casos Notificados de S&iacute;filis Materna y S&iacute;filis Cong&eacute;nita</h2></center>
	<a class="btn btn-primary btn-xs" href="<?php echo site_url('sifilisMaterna/listarSifilis');?>" role="button"><span class="glyphicon glyphicon-backward"></span>&nbsp;Regresar</a>
    <div style="font-size:11px;">
	<?php echo $output; ?>
    </div>
</div>
</body>
</html>