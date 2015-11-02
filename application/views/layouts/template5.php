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

<link rel="stylesheet" href="<?php echo base_url()?>public/css/jquery-jvectormap-1.2.2.css" type="text/css" media="screen"/>
<script src="<?php echo base_url()?>public/js/jquery-1.10.2.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>public/js/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo base_url()?>public/js/mapas/perudist.js"></script>
<script src="<?php echo base_url()?>public/js/mapas/amazonas.js"></script>
<script src="<?php echo base_url()?>public/js/mapas/ancash.js"></script>
<script src="<?php echo base_url()?>public/js/mapas/apurimac.js"></script>
<script src="<?php echo base_url()?>public/js/mapas/arequipa.js"></script>
<script src="<?php echo base_url()?>public/js/mapas/ayacucho.js"></script>
<script src="<?php echo base_url()?>public/js/mapas/cajamarca.js"></script>
<script src="<?php echo base_url()?>public/js/mapas/callao.js"></script>
<script src="<?php echo base_url()?>public/js/mapas/cusco.js"></script>
<script src="<?php echo base_url()?>public/js/mapas/huancavelica.js"></script>
<script src="<?php echo base_url()?>public/js/mapas/huanuco.js"></script>
<script src="<?php echo base_url()?>public/js/mapas/ica.js"></script>
<script src="<?php echo base_url()?>public/js/mapas/junin.js"></script>
<script src="<?php echo base_url()?>public/js/mapas/lalibertad.js"></script>
<script src="<?php echo base_url()?>public/js/mapas/lambayeque.js"></script>
<script src="<?php echo base_url()?>public/js/mapas/lima.js"></script>
<script src="<?php echo base_url()?>public/js/mapas/loreto.js"></script>
<script src="<?php echo base_url()?>public/js/mapas/madrededios.js"></script>
<script src="<?php echo base_url()?>public/js/mapas/moquegua.js"></script>
<script src="<?php echo base_url()?>public/js/mapas/pasco.js"></script>
<script src="<?php echo base_url()?>public/js/mapas/piura.js"></script>
<script src="<?php echo base_url()?>public/js/mapas/puno.js"></script>
<script src="<?php echo base_url()?>public/js/mapas/sanmartin.js"></script>
<script src="<?php echo base_url()?>public/js/mapas/tacna.js"></script>
<script src="<?php echo base_url()?>public/js/mapas/tumbes.js"></script>
<script src="<?php echo base_url()?>public/js/mapas/ucayali.js"></script>
<script src="<?php echo base_url()?>public/js/mapas/limanorte.js"></script>
<script src="<?php echo base_url()?>public/js/mapas/cutervo.js"></script>
<script src="<?php echo base_url()?>public/js/mapas/limasur.js"></script>
<script src="<?php echo base_url()?>public/js/mapas/limaeste.js"></script>
<script src="<?php echo base_url()?>public/js/mapas/limaciudad.js"></script>
<script src="<?php echo base_url()?>public/js/mapas/jaen.js"></script>
<script src="<?php echo base_url()?>public/js/mapas/chota.js"></script>
<script src="<?php echo base_url()?>public/js/mapas/cajamarcaI.js"></script>
<script src="<?php echo base_url()?>public/js/mapas/chanka.js"></script>
<script src="<?php echo base_url()?>public/js/mapas/apurimacI.js"></script>
<script src="<?php echo base_url()?>public/js/mapas/piura1.js"></script>
<script src="<?php echo base_url()?>public/js/mapas/luciano.js"></script>
<script src="<?php echo base_url()?>public/js/mapas/chachapoyas.js"></script>

<!--*************auxiliares*****************-->
<?php echo $this->layout->css; ?> 
<?php echo $this->layout->js; ?> 
<!--**********fin auxiliares*****************-->

<script language="javascript">
$(document).ready(function(){
	$("#opciones").change(function(){
		$.getJSON(window.location.protocol + "//" + window.location.host + '/notiWeb/index.php/mapas/llenaComboNivel', {opcion:$('#opciones').val()}, function (data) {
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
		$.getJSON(window.location.protocol + "//" + window.location.host + '/notiWeb/index.php/mapas/llenaComboDiagno', {opcion:$('#enfermedad').val()}, function (data) {
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

	$("#botonAnadir").click(function(){	
									 
		$("#cargando").fadeIn(100);
		
		$.ajax({
			type: "POST",
			dataType: "json",
			url: "mapas/jvmapa",
			data: $("#form1").serialize(),
			success: function(data) {
				if(data == ""){
				  	$('#cargando').fadeOut(500);
					alert('Debe elegir todos los datos que se solicitan o no existe información para los datos elegidos.');
					//$('#form1').submit();
					return;
				}
				
				  $('.derecha').html('');
				  $('.derecha').vectorMap({
					  map: data['mapa'],
					  backgroundColor: '#CEE3F6',
					  series: {
						  regions: [{
							  values:data,
							  attribute: 'fill'
						  }]
					  }                
				  })
				  $('#cargando').fadeOut(500);
			  }
		});
	
		$.ajax({
			type: "POST",
			dataType: "html",
			url: "mapas/leyenda",
			data: $("#form1").serialize(),
			success: function(data) {
				if(data == 1){
					alert('No ha elegido la enfermedad para procesar.');
					return;
				}
	
				if(data == 2){
					alert('No ha elegido el nivel para procesar.');
					return;
				}
	
				$('.leyenda').html(data);
			}
		});
	});
}); 

/*	setTimeout(function(){ $(".error").fadeOut(800).fadeIn(800).fadeOut(500).fadeIn(500).fadeOut(300);}, 5000); 
*/	setTimeout(function(){ $(".warning").fadeOut(800).fadeIn(800).fadeOut(500).fadeIn(500).fadeOut(300);}, 5000); 
/*	setTimeout(function(){ $(".exito").fadeOut(800).fadeIn(800).fadeOut(500).fadeIn(500).fadeOut(300);}, 5000); 
*/	setTimeout(function(){ $(".exitoFrontend").fadeOut(800).fadeIn(800).fadeOut(500).fadeIn(500).fadeOut(300);}, 5000); 
	setTimeout(function(){ $(".errorFrontend").fadeOut(800).fadeIn(800).fadeOut(500).fadeIn(500).fadeOut(300);}, 5000); 
	setTimeout(function(){ $(".infoFrontend").fadeOut(800).fadeIn(800).fadeOut(500).fadeIn(500).fadeOut(300);}, 5000); 

$(window).on('load', function(){
	$('#cargando').fadeOut(500);
}); 
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

    <!--El div contenedor, donde se presentan todos los formularios-->
    <div class="content1">
        <?php echo $content_for_layout; ?>
    </div>
</div>
<div class="footer">
    <p><?php echo "NotiWeb, pertenece a la Direcci&oacute;n General de Epidemiolog&iacute;a del Ministerio de Salud del Per&uacute;.";?></p>
    <p><?php 
	date_default_timezone_set('America/Lima');
	echo "Copyright (c) ".date('Y').". Todos los derechos reservados.";?></p>
</div>
</body>
</html>