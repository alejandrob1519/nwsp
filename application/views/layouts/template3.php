<!DOCTYPE html>
<html lang='es'>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->layout->getTitle(); ?></title>
<meta name="description" content="<?php echo $this->layout->getDescripcion(); ?>">
<meta name="keywords" content="<?php echo $this->layout->getKeywords(); ?>" />

<link href="<?php echo base_url()?>public/bootstrap/css/bootstrap.min.css" rel='stylesheet' type='text/css' media='all' />
<link href="<?php echo base_url()?>public/css/index.css" rel='stylesheet' type='text/css' media='all' />
<link href="<?php echo base_url()?>public/css/style.css" rel='stylesheet' type='text/css' media='all' />

<script type="text/javascript" src="<?php echo base_url()?>public/js/jquery-1.10.2.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>public/js/jquery-ui-1.10.4.custom.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>public/js/combos.js"></script>

<!--*************auxiliares*****************-->
<?php echo $this->layout->css; ?> 
<?php echo $this->layout->js; ?> 
<!--**********fin auxiliares*****************-->
<script language="javascript">
$(document).ready(function(){
	setTimeout(function(){ $(".exito").fadeOut(800).fadeIn(800).fadeOut(500).fadeIn(500).fadeOut(300);}, 5000); 
	setTimeout(function(){ $(".errores").fadeOut(800).fadeIn(800).fadeOut(500).fadeIn(500).fadeOut(300);}, 5000); 
	setTimeout(function(){ $(".warning").fadeOut(800).fadeIn(800).fadeOut(500).fadeIn(500).fadeOut(300);}, 5000); 
	setTimeout(function(){ $(".info").fadeOut(800).fadeIn(800).fadeOut(500).fadeIn(500).fadeOut(300);}, 5000); 
});
$(window).on('load', function(){
	$('#cargando').fadeOut(1000);
});
function cambia(){
	form1.nueva.value=document.form1.clave.value;
}
	
function nobackbutton(){
   window.location.hash="no-back-button";
   window.location.hash="Again-No-back-button" //chrome
   window.onhashchange=function(){window.location.hash="no-back-button";}
}
</script>

<link rel="icon" href="<?php echo base_url(); ?>public/images/logo2.ico" type="image/gif">

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
<?php
    if($this->session->flashdata('ControllerMessage') != ''){
        ?>
        <div class="errores"><?php echo $this->session->flashdata('ControllerMessage'); ?></div>
        <?php
    }
?>
</head>

<body onLoad="nobackbutton();">
<div id="cargando" 
    style="cursor:pointer;
    background-image: url(<?php echo base_url();?>public/images/cargando.gif);
    background-repeat:no-repeat;
    background-position:center;
    background-size:10%;
    background-color: rgba(0, 0, 0, 0.7);
    width:100%;
    height:100%;
    color:#fff;
    text-align:center;
    padding:52px 12px 12px 12px;
    position:absolute;
    top:0;
    left:0;
    z-index:600;
    display: block;
    opacity: 1;">
</div>
<link href="public/images/favicon.ico" rel="shortcut icon" type="image/x-icon" />
<div class="container-fluid" style="background:#036; color:#FFF; font-size:12px; padding: 10px; font-size:48px;">
  <div class="row">
	<div class="hidden-xs hidden-sm col-sm-6">
		<img src="<?php echo base_url()?>public/images/logo.png" width="350px;" />
    </div>
	<div class="col-xs-12 col-sm-12 col-md-6" align="center">
	    NotiWeb - versión  2.0
    </div>
  </div>
</div>
<div class="container">
	<?php echo $content_for_layout; ?>
</div>
<footer style="background:#036; color:#FFF; font-size:12px">
	<center>
    <br>
    <p><?php echo "NotiWeb, pertenece a la Direcci&oacute;n General de Epidemiolog&iacute;a del Ministerio de Salud del Per&uacute;.";?></p>
    <p>
	<?php 
	date_default_timezone_set('America/Lima');
	echo "Copyright (c) ".date('Y').". Todos los derechos reservados.";?></p>
    <br>
    </center>
</footer>
</body>
</html>