<!DOCTYPE html>
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->layout->getTitle(); ?></title>
<meta name="description" content="<?php echo $this->layout->getDescripcion(); ?>">
<meta name="keywords" content="<?php echo $this->layout->getKeywords(); ?>" />


<link href="<?php echo base_url()?>public/css/tmm_form_wizard_style_demo.css" rel='stylesheet' type='text/css' media='all' />
<link href="<?php echo base_url()?>public/css/grid.css" rel='stylesheet' type='text/css' media='all' />
<link href="<?php echo base_url()?>public/css/tmm_form_wizard_layout.css" rel='stylesheet' type='text/css' media='all' />
<link href="<?php echo base_url()?>public/css/fontello.css" rel='stylesheet' type='text/css' media='all' />

<link href="<?php echo base_url()?>assets/css/bootstrap.min.css" rel='stylesheet' type='text/css' media='all' />
<link href="<?php echo base_url()?>assets/font-awesome/css/font-awesome.min.css" rel='stylesheet' type='text/css' media='all' />
<link href="<?php echo base_url()?>assets/css/segmented-controls.css" rel='stylesheet' type='text/css' media='all' />
<link href="<?php echo base_url()?>assets/ladda-bootstrap-buttons-loader/dist/ladda-themeless.min.css" rel='stylesheet' />
<link href="<?php echo base_url()?>assets/css/bootstrapValidator.min.css" rel='stylesheet' />
<link href="<?php echo base_url()?>public/css/pro_drop_1.css" rel='stylesheet' type='text/css' media='all' />
<link href="<?php echo base_url()?>assets/css/circulos.css" rel='stylesheet' />
<link href="<?php echo base_url()?>public/css/index.css" rel='stylesheet' type='text/css' media='all' />

<script type="text/javascript" src="<?php echo base_url()?>public/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>public/js/jquery-ui-1.10.4.custom.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/ladda-bootstrap-buttons-loader/dist/spin.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/ladda-bootstrap-buttons-loader/dist/ladda.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/bootstrapValidator.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/highcharts/js/highcharts.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/highcharts/js/modules/exporting.js"></script>

<!--*************auxiliares*****************-->
<?php echo $this->layout->css; ?> 
<?php echo $this->layout->js; ?> 
<!--**********fin auxiliares*****************-->

<script type="text/javascript">
function showContent() {
	element = document.getElementById("cargandoPNT");
	element.style.display='block';
}

function nobackbutton(){
   window.location.hash="no-back-button";
   window.location.hash="Again-No-back-button" //chrome
   window.onhashchange=function(){window.location.hash="no-back-button";}
}

$(window).on('load', function(){
	$('#cargando').fadeOut(1000);
}); 

$(document).ready(function(){
	$(".borrar-icon").click( function(e) {
		e.preventDefault();
		var url = this.href;
		var accion = confirm('Estas seguro que deseas eliminar el registro?');
		if(accion == true){
			location.href = url;
		}
	});

	$("#siguiente").click(function(){
		$("#procesando").css("display", "block");							  
	});

	$("#atras").click(function(){
		$("#procesando").css("display", "block");							  
	});
});

setTimeout(function(){ $(".exito").fadeOut(800).fadeIn(800).fadeOut(500).fadeIn(500).fadeOut(300);}, 5000); 
</script>

<link rel="icon" href="<?php echo base_url(); ?>public/images/logo2.ico" type="image/gif">

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
    height:92%;
    position:absolute;
    top:0;
    left:0;
    z-index:6;
    display: block;
    opacity: 1;">
</div>
<link href="public/images/favicon.ico" rel="shortcut icon" type="image/x-icon" />

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
<div>
	&nbsp;<b>DIRECCION GENERAL DE EPIDEMIOLOGIA: </b> 

    <?php 
	    echo ucwords(strtolower($this->session->userdata('nombres')));
    	echo ' ('.$this->session->userdata('usuario').') &nbsp;&nbsp;|&nbsp;&nbsp; ';
        $nivelUser = array(''=>'sin nivel','1'=>'Administrador','4'=>'Nacional','5'=>'Diresa','6'=>'Red','7'=>'Microred','8'=>'Establecimiento');
        echo ' Nivel: '.$nivelUser[$this->session->userdata('nivel')];
    ?>
  </div>
</div>

    <!--El div que orderna los demás divs-->
    <div class='clearbox'></div>

    <!--El div que contiene el menú-->
    <div class="sidebar">
	  <?php
          include_once("public/menu/menu_frontend.php");
      ?>
    </div>

    <!--El div que contiene la barra de accesos-->
    <div style="width:100%; padding-top: 31px;">
	  <?php
          include_once("public/menu/barra_frontend.php");
      ?>
    </div>

	<div id="procesando" style="width:100%; background-color:#F00; color:#FFF; font-weight:bold; display:none;">&nbsp;&nbsp;Cargando...</div>

    <!--El div contenedor, donde se presentan todos los formularios-->
    <div class="container" style="width:100%; height:70%; margin-top: 15px;">
        <?php echo $content_for_layout; ?>
    </div>

<div class="footer">
    <p>Los datos y an&aacute;lisis que emite este software son provisionales y pueden estar sujetos a modificaci&oacute;n. </p>
    <p>Esta informaci&oacute;n es suministrada por la Red Nacional de Epidemiolog&iacute;a (RENACE), cuya fuente es el registro de enfermedades y eventos sujetos a notificaci&oacute;n inmediata o semanal. </p>
    <p>La Semana Epidemiol&oacute;gica inicia el d&iacute;a domingo de cada semana y concluye el d&iacute;a s&aacute;bado siguiente.</p>
    <p><?php echo "NotiWeb, pertenece a la Direcci&oacute;n General de Epidemiolog&iacute;a del Ministerio de Salud del Per&uacute;.";?></p>
    <p><?php 
	date_default_timezone_set('America/Lima');
	echo "Copyright (c) ".date('Y').". Todos los derechos reservados.";?></p>
</div>

</body>
</html>