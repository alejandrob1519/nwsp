<!DOCTYPE html>
<html lang='es'>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->layout->getTitle(); ?></title>
<meta name="description" content="<?php echo $this->layout->getDescripcion(); ?>">
<meta name="keywords" content="<?php echo $this->layout->getKeywords(); ?>" />
<link href="<?php echo base_url()?>public/css/index_metal.css" rel='stylesheet' type='text/css' media='all' />
<link href="<?php echo base_url()?>assets/css/bootstrap.min.css" rel='stylesheet' type='text/css' media='all' />
<link href="<?php echo base_url()?>public/css/jquery-ui-1.10.2.custom.min.css" rel="stylesheet" > 


<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>public/js/combos-metal.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>public/js/jquery-ui-1.10.2.custom.min.js"></script>




<!--*************auxiliares*****************-->
<?php echo $this->layout->css; ?> 
<?php echo $this->layout->js; ?> 
<!--**********fin auxiliares*****************-->

<script type="text/javascript">
$(window).on('load', function(){
	$('#cargando').fadeOut(1000);
}); 	
function numMetales(){
	$.ajax({
	  type: "POST",
	  url: window.location.protocol + "//" + window.location.host + '/notiWeb/index.php/modulometal/numMetales',
	  data: $("#form1").serialize(),
	  dataType: 'json',
		success: function(msg){
			$.each(msg, function(i,item){
				$("#fichanum").val(item);				
			});
			if(msg==''){
				var fecha = new Date();
				var ano = fecha.getFullYear();
				
				var num = 1;
				
				var numero = (ano+"-0000"+num);
				
				document.getElementById('fichanum').value = numero;
				document.getElementById('numero').value = num;
			}else{
				var fecha = new Date();
				var ano = fecha.getFullYear();
				
				var num = parseFloat(msg.numero) + 1;
				
				var numero = (ano+"-0000"+num);
				
				document.getElementById('fichanum').value = numero;
				document.getElementById('numero').value = num;
			}
		}
	});
}

function numSeguimiento(){
	$.ajax({
	  type: "POST",
	  url: window.location.protocol + "//" + window.location.host + '/diabetes/index.php/fichas/numSeguimiento',
	  data: $("#form1").serialize(),
	  dataType: 'json',
		success: function(msg){
			$.each(msg, function(i,item){
				$("#fichanum").val(item);				
			});
			if(msg==''){
				var fecha = new Date();
				var ano = fecha.getFullYear();
				
				var num = 1;
				
				var numero = (ano+"-0000"+num);
				
				document.getElementById('fichanum').value = numero;
				document.getElementById('numero').value = num;
			}else{
				var fecha = new Date();
				var ano = fecha.getFullYear();
				
				var num = parseFloat(msg.numero) + 1;
				
				var numero = (ano+"-0000"+num);
				
				document.getElementById('fichanum').value = numero;
				document.getElementById('numero').value = num;
			}
		}
	});
}

function glicemiaAyunas(){
	var glic = 	document.form1.glicemia.value;

	if(glic < 35 || glic > 1000){
		alert('CUIDADO: Usted está registrando '+glic+' mg/dL, compruebe si está correcto el dato.');
	}
}

function glicemiaPostprandial(){
	var post = 	document.form1.postpandrial.value;

	if(post < 35 || post > 1000){
		alert('CUIDADO: Usted está registrando '+post+' mg/dL, compruebe si está correcto el dato.');
	}
}

function hemoglobinaGlicocilada(){
	var hemo = 	document.form1.hemoglic.value;

	if(hemo > 20){
		alert('CUIDADO: Usted está registrando '+hemo+' %, compruebe si está correcto el dato.');
	}
}

function casoEvaluado(){
	if(document.getElementById('evaluado').value == "2"){
		document.getElementById('neuropatia').disabled = true;		
		document.getElementById('neuropatia').checked = false;
		document.getElementById('nefropatia').disabled = true;		
		document.getElementById('nefropatia').checked = false;
		document.getElementById('noproliferativa').disabled = true;		
		document.getElementById('noproliferativa').checked = false;
		document.getElementById('enfisquemica').disabled = true;		
		document.getElementById('enfisquemica').checked = false;
		document.getElementById('proliferativa').disabled = true;		
		document.getElementById('proliferativa').checked = false;
		document.getElementById('enfcerebrovascular').disabled = true;		
		document.getElementById('enfcerebrovascular').checked = false;
		document.getElementById('sinamputacion').disabled = true;		
		document.getElementById('sinamputacion').checked = false;
		document.getElementById('conamputacion').disabled = true;		
		document.getElementById('conamputacion').checked = false;
		document.getElementById('enfarterial').disabled = true;		
		document.getElementById('enfarterial').checked = false;
		document.getElementById('hipoglicemia').disabled = true;		
		document.getElementById('hipoglicemia').checked = false;
	}else{
		document.getElementById('neuropatia').disabled = false;		
		document.getElementById('nefropatia').disabled = false;		
		document.getElementById('noproliferativa').disabled = false;		
		document.getElementById('enfisquemica').disabled = false;		
		document.getElementById('proliferativa').disabled = false;		
		document.getElementById('enfcerebrovascular').disabled = false;		
		document.getElementById('sinamputacion').disabled = false;		
		document.getElementById('conamputacion').disabled = false;		
		document.getElementById('enfarterial').disabled = false;		
		document.getElementById('hipoglicemia').disabled = false;		
	}
}

var nav4 = window.Event ? true : false;
function acceptNum(evt){
	// NOTE: Backspace = 8, Enter = 13, '0' = 48, '9' = 57
	var key = nav4 ? evt.which : evt.keyCode;
	return (key <= 13 || (key >= 45 && key <= 57));
}

function nobackbutton(){
   window.location.hash="no-back-button";
   window.location.hash="Again-No-back-button" //chrome
   window.onhashchange=function(){window.location.hash="no-back-button";}
}

function cambia(){
	form1.nueva.value=document.form1.clave.value;
}

function calcular_edad() {
	var fecha = document.form1.fecha_nac.value;
	var fechaActual = new Date()
	var diaActual = fechaActual.getDate();
	var mmActual = fechaActual.getMonth() + 1;
	var yyyyActual = fechaActual.getFullYear();
	FechaNac = fecha.split("-");
	var diaCumple = FechaNac[0];
	var mmCumple = FechaNac[1];
	var yyyyCumple = FechaNac[2];
	//retiramos el primer cero de la izquierda
	if (mmCumple.substr(0,1) == 0) {
		mmCumple= mmCumple.substring(1, 2);
	}
	//retiramos el primer cero de la izquierda
	if (diaCumple.substr(0, 1) == 0) {
		diaCumple = diaCumple.substring(1, 2);
	}
	var edad = yyyyActual - yyyyCumple;
	
	//validamos si el mes de cumpleaños es menor al actual
	//o si el mes de cumpleaños es igual al actual
	//y el dia actual es menor al del nacimiento
	//De ser asi, se resta un año
	if ((mmActual < mmCumple) || (mmActual == mmCumple && diaActual < diaCumple)) {
		edad--;
	}
	form1.edad.value = edad;
}

// Para momento de muerte
$("#ocupacion").change(function(){

	if($(this).val()=='1') {  
		$("#subocupacion").find('option[value="3"]').remove();
		$("#subocupacion").find('option[value="1"]').remove();
		$("#subocupacion").find('option[value="2"]').remove();
		$('#subocupacion').append('<option value="1">1. Profesional</option>');
		$('#subocupacion').append('<option value="2">2. Ingeniero</option>');				  
		$('#subocupacion').append('<option value="2">3. Otros</option>');				  
		return
	}
	else if($(this).val()=='2') {  
		$("#subocupacion").find('option[value="3"]').remove();
		$("#subocupacion").find('option[value="1"]').remove();
		$("#subocupacion").find('option[value="2"]').remove();
		$('#subocupacion').append('<option value="3">3 - Post - Parto</option>');
		return
	}else{
		$("#subocupacion").find('option[value="3"]').remove();
		$("#subocupacion").find('option[value="1"]').remove();
		$("#subocupacion").find('option[value="2"]').remove();
		$('#subocupacion').append('<option value="1">1 - Ante - Parto</option>');
		$('#subocupacion').append('<option value="2">2 - Intra - Parto</option>');
		$('#subocupacion').append('<option value="3">3 - Post - Parto</option>');
		return
	}
});

function calculoImc(){
	a = document.form1.peso.value;
	b = document.form1.talla.value;
	
	c = parseFloat(a) / (parseFloat(b) * parseFloat(b));
	
	document.getElementById('imc').value = c.toFixed(2);
}

$(function() {

	$("#fecha_loc").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		//maxDate: "+0D",
		yearRange: "1950:2025",
		dateFormat: "dd-mm-yy"
	});
	
	var active = true;
	
    $('#extender').click(function () 
	{
		var active = true;
		
		if (active) {
			active = false;	
			$('.panel-collapse').collapse('show');
			$('.panel-title').attr('data-toggle', '');
		}else{
			active = true;	
			$('.panel-collapse').collapse('hide');
			$('.panel-title').attr('data-toggle', 'collapse');
		}
	});

    var action;
    $(".number-spinner button").mousedown(function () {
        btn = $(this);
        input = btn.closest('.number-spinner').find('input');
        btn.closest('.number-spinner').find('button').prop("disabled", false);

    	if (btn.attr('data-dir') == 'up') {
            action = setInterval(function(){
                if ( input.attr('max') == undefined || parseInt(input.val()) < parseInt(input.attr('max')) ) {
                    input.val(parseInt(input.val())+1);
                }else{
                    btn.prop("disabled", true);
                    clearInterval(action);
                }
            }, 50);
    	} else {
            action = setInterval(function(){
                if ( input.attr('min') == undefined || parseInt(input.val()) > parseInt(input.attr('min')) ) {
                    input.val(parseInt(input.val())-1);
                }else{
                    btn.prop("disabled", true);
                    clearInterval(action);
                }
            }, 50);
    	}
    }).mouseup(function(){
        clearInterval(action);
    });
});

setTimeout(function(){ $(".exitoFrontend").fadeOut(800).fadeIn(800).fadeOut(500).fadeIn(500).fadeOut(300);}, 5000); 
setTimeout(function(){ $(".errorFrontend").fadeOut(800).fadeIn(800).fadeOut(500).fadeIn(500).fadeOut(300);}, 5000); 
setTimeout(function(){ $(".infoFrontend").fadeOut(800).fadeIn(800).fadeOut(500).fadeIn(500).fadeOut(300);}, 5000); 
<body onLoad="nobackbutton();">

</script>
</head>

<body>
<link href="<?php base_url()?>public/images/favicon.ico" rel="shortcut icon" type="image/x-icon" />
<div class="container">
    <div class="container-fluid" style="background:#069; color: #FFF;">
        <header>
 <?php
	$session_id = $this->session->userdata('usuario');
	$nivel_id = $this->session->userdata('nivel');
	$grabar_id = $this->session->userdata('grabar');
	$nivel = $this->login_model->buscarNivel($nivel_id);
?>
        <label class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
		  <strong>Bienvenido: </strong> <i class="fa fa-user"></i> <?php echo $this->session->userdata('nombres');?>
          <!--<strong> - </strong><?php //echo $this->session->userdata('usuario');?>-->
		  <strong>/ Nivel: </strong><?php echo $nivel->nombre;?>
          </label>
          <label class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
          <strong>Exposici&oacute;n a Metales</strong>
          </label>
        </header>
    </div>
    <!--El div que contiene el menú-->
    <div class="sidebar">
        <?php
            include_once("public/menu/menu_frontend_metal.php");
        ?>
    </div>
        
    <!--El div contenedor, donde se presentan todos los formularios-->
    <div class="content">
        <?php echo $content_for_layout; ?>
    </div>
    <div class="container" style="font-size:11px; font-weight:bold;">
    	<footer>
            <p><center><?php echo "Vigilancia de Exposici&oacute;n a Metales Pesados, pertenece a la Direcci&oacute;n General de Epidemiolog&iacute;a del Ministerio de Salud del Per&uacute;.";?></center></p>
            <p><center>
            <?php date_default_timezone_set('America/Lima');
            echo "Copyright (c) ".date('Y').". Todos los derechos reservados.";?></center></p>
        </footer>
    </div>
</div>
</body>
</html>