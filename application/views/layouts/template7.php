<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->layout->getTitle(); ?></title>
<meta name="description" content="<?php echo $this->layout->getDescripcion(); ?>">
<meta name="keywords" content="<?php echo $this->layout->getKeywords(); ?>" />
<link href="<?php echo base_url()?>public/css/blitzer/jquery-ui-1.10.4.custom.css" rel='stylesheet' type='text/css' media='all' />
<link href="<?php echo base_url()?>public/css/pro_drop_1.css" rel='stylesheet' type='text/css' media='all' />
<link href="<?php echo base_url()?>public/css/index.css" rel='stylesheet' type='text/css' media='all' />
<script type="text/javascript" src="<?php echo base_url()?>public/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>public/js/jquery-ui-1.10.4.custom.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>public/js/combos.js"></script>

<!--*************auxiliares*****************-->
<?php echo $this->layout->css; ?> 
<?php echo $this->layout->js; ?> 
<!--**********fin auxiliares*****************-->

<script language="javascript">
function showContent() {
	element = document.getElementById("cargandoPNT");
	element.style.display='block';
}
	
$(window).on('load', function(){
	$('#cargando').fadeOut(500);
}); 

setTimeout(function(){ $(".exitoFrontend").fadeOut(800).fadeIn(800).fadeOut(500).fadeIn(500).fadeOut(300);}, 5000); 
setTimeout(function(){ $(".errorFrontend").fadeOut(800).fadeIn(800).fadeOut(500).fadeIn(500).fadeOut(300);}, 5000); 
setTimeout(function(){ $(".infoFrontend").fadeOut(800).fadeIn(800).fadeOut(500).fadeIn(500).fadeOut(300);}, 5000); 

</script>

<link rel="icon" href="<?php echo base_url(); ?>public/images/logo2.ico" type="image/gif">

</head>

<body>
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
    height:92%;
    position:absolute;
    top:0;
    left:0;
    z-index:6;
    display: block;
    opacity: 1;">
</div>

<?php
	$login = $this->session->userdata("usuario");

	if(empty($login)){
		redirect(site_url("index/login"), 301);
	}

?>

<div class="headerNotiWeb">
<?php
	$session_id = $this->session->userdata('usuario');
	$nivel_id = $this->session->userdata('nivel');
	$grabar_id = $this->session->userdata('grabar');
	$nivel = $this->login_model->buscarNivel($nivel_id);
?>
&nbsp;<b>DIRECCION GENERAL DE EPIDEMIOLOGIA</b> / Nivel: <?php echo $nivel->nombre; ?> / Usuario: <?php echo $session_id;?>
</div>

<div class="container">
    <!--El div que orderna los demás divs-->
    <div class='clearbox'></div>

    <!--El div que contiene el menú-->
    <div class="sidebar">
	  <?php
          include_once("public/menu/menu_frontend.php");
      ?>
    </div>

    <!--El div que contiene la barra de accesos-->
    <div class="sidebar">
	  <?php
          include_once("public/menu/barra_frontend.php");
      ?>
    </div>

    <div class="content1"><?php echo $content_for_layout; ?></div>
</div>
<div class="footer">
    <p><?php echo "NotiWeb, pertenece a la Direcci&oacute;n General de Epidemiolog&iacute;a del Ministerio de Salud del Per&uacute;.";?></p>
    <p><?php 
	date_default_timezone_set('America/Lima');
	echo "Copyright (c) ".date('Y').". Todos los derechos reservados.";?></p>
</div>
</body>
</html>