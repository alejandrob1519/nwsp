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

<!--*************auxiliares*****************-->
<?php echo $this->layout->css; ?> 
<?php echo $this->layout->js; ?> 
<!--**********fin auxiliares*****************-->
<script language="javascript">
$(function(){
	$("#fecha_reg").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		yearRange: "1950:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fecha_nac").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		yearRange: "1950:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fecha_def").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		yearRange: "1950:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fecha_ini").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		yearRange: "1950:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fecha_ate").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		yearRange: "1950:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fecha_tra").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		yearRange: "1950:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fecha_eme").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		yearRange: "1950:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fecha_hos").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		yearRange: "1950:2025",
		dateFormat: "dd-mm-yy"
	});

	$('#establec').change(function () {
		var establec = $('#establec').val();
		
		var t = establec.substr(6,1);

		switch(t){
			case 'A':
			form1.institucion.value = "MINSA";			
			break;
			case 'C':
			form1.institucion.value = "ESSALUD";			
			break;
			case 'D':
			form1.institucion.value = "SANIDADES";			
			break;
			case 'X':
			form1.institucion.value = "PRIVADOS";			
			break;
		}
	});

	$('#lugar_def').change(function () {
		if($('#lugar_def').val() != '6'){
			$('#otro_def').attr('disabled','disabled');
		}else{
			$('#otro_def').removeAttr('disabled');
		}
	});

	$('#cuidador').change(function () {
		if($('#cuidador').val() != '5'){
			$('#cuida_otro').attr('disabled','disabled');
		}else{
			$('#cuida_otro').removeAttr('disabled');
		}
	});

	$('#lugar_atencion').change(function () {
		if($('#lugar_atencion').val() != '7'){
			$('#otro_lugar').attr('disabled','disabled');
		}else{
			$('#otro_lugar').removeAttr('disabled');
		}
	});

	$('#seguro').change(function () {
		if($('#seguro').val() != '5'){
			$('#otro_seguro').attr('disabled','disabled');
		}else{
			$('#otro_seguro').removeAttr('disabled');
		}
	});

	$('#programa').change(function () {
		if($('#programa').val() != '3'){
			$('#otro_programa').attr('disabled','disabled');
		}else{
			$('#otro_programa').removeAttr('disabled');
		}
	});

	$('#lactancia').change(function () {
		if($('#lactancia').val() != '3'){
			$('#otro_lactancia').attr('disabled','disabled');
		}else{
			$('#otro_lactancia').removeAttr('disabled');
		}
	});
});
$(window).on('load', function(){
	$('#cargando').fadeOut(1000);
}); 
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
	<div class="titulo"><p>Defunciones por Neumon&iacute;as</p></div>
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
            include_once("public/menu/fichas_menu.php");
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