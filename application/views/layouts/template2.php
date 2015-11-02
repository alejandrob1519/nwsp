<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->layout->getTitle(); ?></title>
<meta name="description" content="<?php echo $this->layout->getDescripcion(); ?>">
<meta name="keywords" content="<?php echo $this->layout->getKeywords(); ?>" />
<link href="<?php echo base_url()?>public/css/index.css" rel='stylesheet' type='text/css' media='all' />
<link href="<?php echo base_url()?>public/css/menu.css" rel='stylesheet' type='text/css' media='all' />

<script type="text/javascript" src="<?php echo base_url()?>public/js/jquery-1.10.2.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>public/js/jquery-ui-1.10.4.custom.min.js"></script>

<!--*************auxiliares*****************-->
<?php echo $this->layout->css; ?> 
<?php echo $this->layout->js; ?> 
<!--**********fin auxiliares*****************-->

<script type="text/javascript">
$(document).ready(function(){
	$('#diresa').change(function () {
		var url = window.location.protocol + "//" + window.location.host;
		$.getJSON(url+'/notiWeb/index.php/backend/sistema/llenaRedes', {diresa:$('#diresa').val()}, function (data) {
			$('#redes').empty();
			$.each(data, function (id, desc) {
				option = $('<option></option>', {
					value : id,
					text : desc
				});
				$('#redes').append(option);
			});
			var sort = $('#redes option');
			sort.sort(function (a, b) {
				 if (a.text > b.text) { return 1; } else if (a.text < b.text) { return -1; } else { return 0 }
			});
			$('#redes').empty().append(sort);
			$('#redes').prepend('<option value="" disabled>Seleccione ...</option>');
			$('#redes').val('');
		});
		var diresa = $('#diresa').val();
		/*$('#departamento option').removeAttr('selected');*/
		$('#diresa option[value='+diresa+']').attr('selected', '');
		$('#redes').empty().append('<option value="">Seleccione ...</option>');
		$('#microred').empty().append('<option value="">Seleccione ...</option>');
		$('#establec').empty().append('<option value="">Seleccione ...</option>');
	});

	$('#redes').change(function () {
		var url = window.location.protocol + "//" + window.location.host;
		$.getJSON(url+'/notiWeb/index.php/backend/sistema/llenaMicroredes', {diresa:$('#diresa').val(), redes:$('#redes').val()}, function (data) {
			$('#microred').empty();
			$.each(data, function (id, desc) {
				option = $('<option></option>', {
					value : id,
					text : desc
				});
				$('#microred').append(option);
			});
			var sort = $('#microred option');
			sort.sort(function (a, b) {
				 if (a.text > b.text) { return 1; } else if (a.text < b.text) { return -1; } else { return 0 }
			});
			$('#microred').empty().append(sort);
			$('#microred').prepend('<option value="">Seleccione ...</option>');
			$('#microred').val('');
		});
		$('#microred').empty().append('<option value="">Seleccione ...</option>');
		$('#establec').empty().append('<option value="">Seleccione ...</option>');
	});

	$('#microred').change(function () {
		var url = window.location.protocol + "//" + window.location.host;
		$.getJSON(url+'/notiWeb/index.php/backend/sistema/llenaEstablec', {diresa:$('#diresa').val(), redes:$('#redes').val(), microred:$('#microred').val()}, function (data) {
			$('#establec').empty();
			$.each(data, function (id, desc) {
				option = $('<option></option>', {
					value : id,
					text : desc
				});
				$('#establec').append(option);
			});
			var sort = $('#establec option');
			sort.sort(function (a, b) {
				 if (a.text > b.text) { return 1; } else if (a.text < b.text) { return -1; } else { return 0 }
			});
			$('#establec').empty().append(sort);
			$('#establec').prepend('<option value="">Seleccione ...</option>');
			$('#establec').val('');
		});
	});

/*	$("#caduca").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		yearRange: "1950:2025",
		dateFormat: "dd-mm-yy"
	});

*/	
/*	setTimeout(function(){ $(".error").fadeOut(800).fadeIn(800).fadeOut(500).fadeIn(500).fadeOut(300);}, 5000); 
	setTimeout(function(){ $(".warning").fadeOut(800).fadeIn(800).fadeOut(500).fadeIn(500).fadeOut(300);}, 5000); 
	setTimeout(function(){ $(".exito").fadeOut(800).fadeIn(800).fadeOut(500).fadeIn(500).fadeOut(300);}, 5000); */
	setTimeout(function(){ $(".exitoFrontend").fadeOut(800).fadeIn(800).fadeOut(500).fadeIn(500).fadeOut(300);}, 5000); 
	setTimeout(function(){ $(".errorFrontend").fadeOut(800).fadeIn(800).fadeOut(500).fadeIn(500).fadeOut(300);}, 5000); 
	setTimeout(function(){ $(".infoFrontend").fadeOut(800).fadeIn(800).fadeOut(500).fadeIn(500).fadeOut(300);}, 5000); 
});

function showContent() {
	element = document.getElementById("cargandoPNT");
	element.style.display='block';
}

function nobackbutton(){
   window.location.hash="no-back-button";
   window.location.hash="Again-No-back-button" //chrome
   window.onhashchange=function(){window.location.hash="no-back-button";}
}
	
</script>

<link rel="icon" href="<?php echo base_url(); ?>public/images/logo2.ico" type="image/gif">

</head>

<body onLoad="nobackbutton();">
<link href="public/images/favicon.ico" rel="shortcut icon" type="image/x-icon" />
<div class="header">
	<div class="logo"><img src="<?php echo base_url()?>public/images/logo.png" width="350" /></div>
	<div class="titulo">Administraci&oacute;n</div>
</div>

<div class="container">
    <!--El div que orderna los demás divs-->
    <div class='clearbox'></div>

    <!--El div que contiene el menú-->
    <div class="sidebar1">
        <?php
            include_once("public/menu/menu_backend.php");
        ?>
        <div style="text-align: right; position:absolute; margin-top: -2%; margin-left: 67%;">
            <?php
                $login = $this->session->userdata("usuario");

                if(empty($login)){
                    redirect(site_url("backend/index/login"), 301);
                }
            
            ?>
        </div>
    </div>
        
    <!--El div contenedor, donde se presentan todos los formularios-->
    <div class="content">
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