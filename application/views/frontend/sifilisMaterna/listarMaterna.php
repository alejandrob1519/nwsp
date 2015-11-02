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
    <center><h4>Registro de Fichas de Investigaci&oacute;n Epidemiol&oacute;gica de Caso de S&iacute;filis Materna</h4></center>
	<a class="btn btn-primary btn-xs" href="<?php echo site_url('sifilisMaterna/listarCasos');?>" role="button"><span class="glyphicon glyphicon-plus-sign"></span>&nbsp;A&ntilde;adir Ficha</a>
    <div>
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
    ?>
	<?php echo $output; ?>
    </div>
</body>
</html>