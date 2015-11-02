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
<script src="<?php echo base_url()?>public/js/jquery-1.11.0.min.js" type="text/javascript"></script>

<!--*************auxiliares*****************-->
<?php echo $this->layout->css; ?> 
<?php echo $this->layout->js; ?> 
<!--**********fin auxiliares*****************-->

<script language="javascript">
$(document).ready(function(){
	$("#cargando").fadeIn(100);
	
	$("#opciones").change(function(){
		$.getJSON('graficos/llenaComboNivel', {opcion:$('#opciones').val()}, function (data) {
			$('#nivel').empty();
				$.each(data, function (id, desc) {
					option = $('<option></option>', {
					value : id,
					text : desc
				});
				$('#nivel').append(option);
			});
			var sort = $('#nivel option');
			sort.sort(function (a, b) {
			if (a.text > b.text) { return 1; } else if (a.text < b.text) { return -1; } else { return 0 }
		});
		var opciones = $('#opciones').val();
		$('#opciones option[value='+opciones+']').attr('selected', '');
		$('#nivel').empty().append(sort);
		$('#nivel').prepend('<option value="">Seleccione ...</option>');
		$('#nivel').val('');
	  });
 	});

	$("#enfermedad").change(function(){
		$.getJSON('graficos/llenaComboDiagno', {opcion:$('#enfermedad').val()}, function (data) {
			$('#diagno').empty();
				$.each(data, function (id, desc) {
					option = $('<option></option>', {
					value : id,
					text : desc
				});
				$('#diagno').append(option);
			});
			var sort = $('#diagno option');
			sort.sort(function (a, b) {
			if (a.text > b.text) { return 1; } else if (a.text < b.text) { return -1; } else { return 0 }
		});
		var enfermedad = $('#enfermedad').val();
		$('#enfermedad option[value='+enfermedad+']').attr('selected', '');
		$('#diagno').empty().append(sort);
		$('#diagno').prepend('<option value="">Seleccione ...</option>');
		$('#diagno').val('');
	  });
 	});
});

$(window).on('load', function(){
	$('#cargando').fadeOut(500);
}); 
</script>

<script>
function asegurar(){
   rc = confirm("Este proceso puede durar varios segundos, sea paciente por favor."); 
   if(rc==true){
	$("#cargando").fadeIn(100);
   }
   return rc;
}
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