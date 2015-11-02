<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
    <?php
        if($this->session->flashdata('ControllerMessage') != ''){
            ?>
            <div class="errorFrontend"><?php echo $this->session->flashdata('ControllerMessage'); ?></div>
            <?php
        }
    ?>
    <?php 
    foreach($css_files as $file): ?>
    	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
    <?php endforeach; ?>
    <?php foreach($js_files as $file): ?>
    	<script src="<?php echo $file; ?>"></script>
    <?php endforeach; ?>
</head>
<?php
if($this->session->flashdata('exito') != ''){
    ?>
    <div class="exito"><?php echo $this->session->flashdata('exito'); ?></div>
    <?php
}
if($this->session->flashdata('error') != ''){
    ?>
    <div class="error"><?php echo $this->session->flashdata('error'); ?></div>
    <?php
}
if($this->session->flashdata('info') != ''){
    ?>
    <div class="info"><?php echo $this->session->flashdata('info'); ?></div>
    <?php
}
?>
<body>
<div class="formulario">
    <center><h2>Ficha de Investigaci&oacute;n Cl&iacute;nico Epidemiol&oacute;gica</h2></center>
    <div>
	<?php echo $output; ?>
    </div>
</div>
</body>
</html>