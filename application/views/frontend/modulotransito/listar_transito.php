<head>
	<meta charset="utf-8" />
	<?php
    foreach($css_files as $file): ?>
        <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
    <?php endforeach; ?>
    <?php foreach($js_files as $file): ?>
        <script src="<?php echo $file; ?>"></script>
    <?php endforeach; ?>
    <script type="text/javascript" src="<?php echo base_url()?>assets/js/transito-eliminar.js"></script>
</head>


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
} ?>


<body>
    <center><h4>Lista Vigilancia epidemiológica de Lesiones por Accidentes de transito</h4></center>
    <div class="container my-container" style="margin-bottom:10px;">
    	<div class="row">
	    	<div class="col-xs-offset-8 col-sm-offset-10 col-md-offset-11 col-lg-offset-11">
	    		<a class="btn btn-primary btn-xs" href="<?php echo site_url('modulotransito/registro_transito');?>" role="button">
	    		<span class="glyphicon glyphicon-plus"></span>&nbsp;Nueva Ficha</a>
	    	</div>
    	</div>
    </div>

    <div>
	<?php echo $output; ?>
    </div>
</body>
