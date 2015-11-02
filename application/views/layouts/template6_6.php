<!DOCTYPE html>
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->layout->getTitle(); ?></title>
<meta name="description" content="<?php echo $this->layout->getDescripcion(); ?>">
<meta name="keywords" content="<?php echo $this->layout->getKeywords(); ?>" />
<link href="<?php echo base_url()?>public/css/blitzer/jquery-ui-1.10.4.custom.css" rel='stylesheet' type='text/css' media='all' />
<script type="text/javascript" src="<?php echo base_url()?>public/js/jquery-1.10.2.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>public/js/jquery-ui-1.10.4.custom.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>public/js/combos.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>public/js/jquery.PrintArea.js"></script>
<link href="<?php echo base_url()?>public/css/PrintArea.css" rel='stylesheet' type='text/css' media='all' />
<link href="<?php echo base_url()?>public/css/index.css" rel='stylesheet' type='text/css' media='all' />

<!--*************auxiliares*****************-->
<?php echo $this->layout->css; ?> 
<?php echo $this->layout->js; ?> 
<!--**********fin auxiliares*****************-->
<script language="javascript">
$(window).on('load', function(){
	$('#cargando').fadeOut(1000);
}); 

function asegurar()
{
  var rc = confirm("¿Seguro que desea eliminar el registro?"); 

  if(rc == true){
	  $("form[name='form1']").submit();
  }
  return rc;
}


function nivelEstablecimiento(){
	x = document.form1.establec.value;
	y = x.substr(7,1);
	
	switch(y){
		case '1':
		document.form1.nivel_estab.value = "Hospital";
		break;
		case '2':
		document.form1.nivel_estab.value = "Centro de Salud";
		break;
		case '3':
		document.form1.nivel_estab.value = "Puesto de Salud";
		break;
	}
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
	<div class="titulo" style="font-size: 48px;">S&iacute;filis Materna y Cong&eacute;nita</div>
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
            include_once("public/menu/sifilis_menu.php");
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