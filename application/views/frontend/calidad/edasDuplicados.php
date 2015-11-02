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
if($termina <> ""){
	?>
	<div style="width: 100%; background:#FCC; font-weight:bold; text-align:center; padding: 2px;"><?php echo $termina?></div>
    <?php
}
?>
<body>
<h4>Notificaci&oacute;n EDA's</h4>
<div style="position:absolute; font-size:10px; width:20%; margin-top: 28px; z-index: 1000;">
	<a class="btn btn-default btn-xs" href="<?php echo site_url('calidad');?>" role="button"><span class="glyphicon glyphicon-backward"></span>&nbsp;Retorna al anterior</a>
</div>

<div style="position:relative; font-size:10px; width:100%;">
    <?php echo $output; ?>
</div>
    
<div id="tmm-form-wizard">
    <div class="row stage-container">
        <div class="stage tmm-success col-md-2 col-sm-2">
            <div class="stage-header head-number">1</div>

            <div class="stage-content">
                <h5 class="stage-title" style="text-align:center">Semanas</h5>
                <div class="stage-info" style="text-align:center">
                    Semanas que no concuerdan con la actual
                </div> 
            </div>
        </div>

        <div class="stage tmm-current col-md-2 col-sm-2">
            <div class="stage-header head-number">2</div>

            <div class="stage-content">
                <h5 class="stage-title" style="text-align:center">Duplicados</h5>
                <div class="stage-info" style="text-align:center">
                    <br />Registros duplicados
                </div>
            </div>
        </div>

        <div class="stage col-md-2 col-sm-2">
            <div class="stage-header head-number">3</div>

            <div class="stage-content">
                <h5 class="stage-title" style="text-align:center">Semanas</h5>
                <div class="stage-info" style="text-align:center">
                    Semanas mayores a la semana actual
                </div>
            </div>
        </div>

        <div class="stage col-md-2 col-sm-2">
            <div class="stage-header head-number">4</div>
            <div class="stage-content">
                <h5 class="stage-title" style="text-align:center">Establecimientos</h5>
                <div class="stage-info" style="text-align:center">
                    Verifica c&oacute;digos de establecimientos de salud
                </div>
            </div>
        </div>

        <div class="stage col-md-2 col-sm-2">
            <div class="stage-header head-number">5</div>
            <div class="stage-content">
                <h5 class="stage-title" style="text-align:center">Defunciones</h5>
                <div class="stage-info" style="text-align:center">
                    Mas defunciones que casos registrados
                </div> 
            </div>
        </div>

        <div class="stage col-md-2 col-sm-2">
            <div class="stage-header head-number">6</div>
            <div class="stage-content">
                <h5 class="stage-title" style="text-align:center">Campos Vac&iacute;os</h5>
                <div class="stage-info" style="text-align:center">
                    <br />Campos vac&iacute;os obligatorios
                </div> 
            </div>
        </div>
    </div>
    
	<?php
    $atributos = array('id'=>'form1', 'name'=>'form1');
    echo form_open(null, $atributos);
	?>
        <div class="prev">
        	<button class="button button-control" type="button" id="atras" onClick="window.location.href='<?php echo site_url("/calidad/edasCalidad"); ?>'"><span>Paso Anterior <b>Semanas</b></span></button>
            <div class="button-divider"></div>
        </div>
    
        <div class="next">
            <button class="button button-control" type="button" id="siguiente" onClick="window.location.href='<?php echo site_url("/calidad/edasSemanas"); ?>'"><span>Siguiente Paso <b>Semanas</b></span></button>
            <div class="button-divider"></div>
        </div>

	<?php
	echo form_close();
	?>    
</div>

<script src="<?php echo base_url()?>public/js/tmm_form_wizard_custom.js"></script>

</body>
</html>