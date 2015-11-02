<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->layout->getTitle(); ?></title>
<meta name="description" content="<?php echo $this->layout->getDescripcion(); ?>">
<meta name="keywords" content="<?php echo $this->layout->getKeywords(); ?>" />
<link href="<?php echo base_url()?>public/css/blitzer/jquery-ui-1.10.4.custom.css" rel='stylesheet' type='text/css' media='all' />
<link href="<?php echo base_url()?>public/css/index.css" rel='stylesheet' type='text/css' media='all' />

<script type="text/javascript" src="<?php echo base_url()?>public/js/jquery-1.10.2.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>public/js/jquery-ui-1.10.4.custom.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>public/js/combos.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>public/js/jquery.PrintArea.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>public/js/tinymce/tinymce.min.js"></script>

<!--*************auxiliares*****************-->
<?php echo $this->layout->css; ?> 
<?php echo $this->layout->js; ?> 
<!--**********fin auxiliares*****************-->
<script language="javascript">
var nav4 = window.Event ? true : false;
function acceptNum(evt){
	// NOTE: Backspace = 8, Enter = 13, '0' = 48, '9' = 57
	var key = nav4 ? evt.which : evt.keyCode;
	return (key <= 13 || (key >= 45 && key <= 57));
}

$(window).on('load', function(){
	$('#cargando').fadeOut(1000);
}); 


tinyMCE.init({
    mode : "textareas",
    theme : "modern",
	language : 'es',
    theme_advanced_buttons1 : "bold,italic,underline,separator,strikethrough,justifyleft,justifycenter,justifyright, justifyfull,bullist,numlist,undo,redo,link,unlink",
    theme_advanced_buttons2 : "",
    theme_advanced_buttons3 : "",
    theme_advanced_toolbar_location : "top",
    theme_advanced_toolbar_align : "left",
    theme_advanced_path_location : "bottom",
    extended_valid_elements : "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]"
});

function abrirVentana(){ 
   var f = document.forms[0];       
   window.showModalDialog("modulos4/listarGrillaBrotes",window,"dialogHeight:300px;dialogWidth:800px;center:yes;help:no;resizable:no;status:yes");   
} 
</script>

<link rel="icon" href="<?php echo base_url(); ?>public/images/logo2.ico" type="image/gif">

</head>

<body>
<div id="cargando" 
    style="cursor:pointer;
    background-image: url(../../public/images/cargando.gif);
    background-repeat:no-repeat;
    background-position:center;
    background-size:10%;
    background-color: rgba(0, 0, 0, 0.7);
    width:98.5%;
    color:#fff;
    text-align:center;
    height:92%;
    padding:52px 12px 12px 12px;
    position:absolute;
    top:0;
    left:0;
    z-index:6;
    display: block;
    opacity: 1;">
</div>

<link href="public/images/favicon.ico" rel="shortcut icon" type="image/x-icon" />
<div class="header">
	<div class="logo"><img src="<?php echo base_url()?>public/images/logo.png" width="350" /></div>
	<div class="titulo"><p>Intoxicaci&oacute;n por Plaguicidas</p></div>
</div>
<div class="container">
    <!--El div que orderna los demás divs-->
    <div class='clearbox'></div>

    <div style="text-align: right; position:absolute; margin-top: 1%; margin-left: 80%; color:#000;">
        <?php
            $login = $this->session->userdata("usuario");
			
            echo "<b>Usuario:</b> ".$login;
        ?>
    </div>

    <!--El div que contiene el menú-->
    <div class="sidebar">
        <?php
            include_once("public/menu/plaguicidas_menu.php");
        ?>
    </div>
        
    <!--El div contenedor, donde se presentan todos los formularios-->
    <div class="content1"><?php echo $content_for_layout; ?></div>
</div>
<div class="footer" style="line-height: 15px;">
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