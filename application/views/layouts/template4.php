<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
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
<script type="text/javascript" src="<?php echo base_url()?>public/js/stuHover.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>public/js/combos.js"></script>

<!--*************auxiliares*****************-->
<?php echo $this->layout->css; ?> 
<?php echo $this->layout->js; ?> 
<!--**********fin auxiliares*****************-->

<script type="text/javascript">
function anoInicio()
{
	var x = document.form1.fecha_ini.value;
	
	var y = new Date("12/28/2014");
	var z = new Date("01/03/2015");
	
	if(x.match(/\//)){
		x = x.replace(/\//g,"-",x); //Permite que se puedan ingresar formatos de fecha ustilizando el "/" o "-" como separador
	};
	 
	x = x.split("-"); //Dividimos el string de fecha en trozos (dia,mes,año)
	var dia = eval(x[0]);
	var mes = eval(x[1]);
	var ano = eval(x[2]);
	
	
	var w = new Date(mes+"/"+dia+"/"+ano);
	
	if((w >= y) && (w <= z)){
		x = "28-12-2014";
		
		if(x.match(/\//)){
			x = x.replace(/\//g,"-",x); //Permite que se puedan ingresar formatos de fecha ustilizando el "/" o "-" como separador
		};
		 
		x = x.split("-"); //Dividimos el string de fecha en trozos (dia,mes,año)
		var dia = eval(x[0]);
		var mes = eval(x[1]);
		var ano = eval(x[2]);
	}
	
	if (mes==1 || mes==2){
		//Cálculos si el mes es Enero o Febrero
		var a   =   ano-1;
		var b   =   Math.floor(a/4)-Math.floor(a/100)+Math.floor(a/400);
		var c   =   Math.floor((a-1)/4)-Math.floor((a-1)/100)+Math.floor((a-1)/400);
		var s   =   b-c;
		var e   =   0;
		var f   =   dia-1+(31*(mes-1));
	} else {
		//Calculos para los meses entre marzo y Diciembre
		var a   =   ano;
		var b   =   Math.floor(a/4)-Math.floor(a/100)+Math.floor(a/400);
		var c   =   Math.floor((a-1)/4)-Math.floor((a-1)/100)+Math.floor((a-1)/400);
		var s   =   b-c;
		var e   =   s+1;
		var f   =   dia+Math.floor(((153*(mes-3))+2)/5)+58+s;
	};
  
	//Adicionalmente sumándole 1 a la variable $f se obtiene numero ordinal del dia de la fecha ingresada con referencia al año actual.

	//Estos cálculos se aplican a cualquier mes
	var g   =   (a+b)%7;
	var d   =   (f+g-e)%7; //Adicionalmente esta variable nos indica el dia de la semana 0=Lunes, ... , 6=Domingo.
	var n   =   f+3-d;
	 
	if (n<0){
		//Si la variable n es menor a 0 se trata de una semana perteneciente al año anterior
		var semana = 53-Math.floor((g-s)/5);
		var ano = ano-1; 
	} else if (n>(364+s)) {
		//Si n es mayor a 364 + $s entonces la fecha corresponde a la primera semana del año siguiente.
		var semana = 1;
		var ano = ano+1;
	} else {
		//En cualquier otro caso es una semana del año actual.
		if(d == 6){
			var semana = Math.floor(n/7)+2;
		}else{
			var semana = Math.floor(n/7)+1;
		}
	};
	 
	if(ano > 2014){
		form1.ano_ini.value = ano;
		form1.semana_ini.value = semana-1;
	}else{
		form1.ano_ini.value = ano;
		form1.semana_ini.value = semana;
	}

	if((w >= y) && (w <= z)){
		form1.ano_ini.value = ano;
		form1.semana_ini.value = semana;
	}
}

function anoNotificacion()
{
	var x = document.form1.fecha_not.value;

	var y = new Date("12/28/2014");
	var z = new Date("01/03/2015");
	
	if(x.match(/\//)){
		x = x.replace(/\//g,"-",x); //Permite que se puedan ingresar formatos de fecha ustilizando el "/" o "-" como separador
	};
	 
	x = x.split("-"); //Dividimos el string de fecha en trozos (dia,mes,año)
	var dia = eval(x[0]);
	var mes = eval(x[1]);
	var ano = eval(x[2]);
	
	
	var w = new Date(mes+"/"+dia+"/"+ano);
	
	if((w >= y) && (w <= z)){
		x = "28-12-2014";
		
		if(x.match(/\//)){
			x = x.replace(/\//g,"-",x); //Permite que se puedan ingresar formatos de fecha ustilizando el "/" o "-" como separador
		};
		 
		x = x.split("-"); //Dividimos el string de fecha en trozos (dia,mes,año)
		var dia = eval(x[0]);
		var mes = eval(x[1]);
		var ano = eval(x[2]);
	}
	
	if (mes==1 || mes==2){
		//Cálculos si el mes es Enero o Febrero
		var a   =   ano-1;
		var b   =   Math.floor(a/4)-Math.floor(a/100)+Math.floor(a/400);
		var c   =   Math.floor((a-1)/4)-Math.floor((a-1)/100)+Math.floor((a-1)/400);
		var s   =   b-c;
		var e   =   0;
		var f   =   dia-1+(31*(mes-1));
	} else {
		//Calculos para los meses entre marzo y Diciembre
		var a   =   ano;
		var b   =   Math.floor(a/4)-Math.floor(a/100)+Math.floor(a/400);
		var c   =   Math.floor((a-1)/4)-Math.floor((a-1)/100)+Math.floor((a-1)/400);
		var s   =   b-c;
		var e   =   s+1;
		var f   =   dia+Math.floor(((153*(mes-3))+2)/5)+58+s;
	};
  
	//Adicionalmente sumándole 1 a la variable $f se obtiene numero ordinal del dia de la fecha ingresada con referencia al año actual.

	//Estos cálculos se aplican a cualquier mes
	var g   =   (a+b)%7;
	var d   =   (f+g-e)%7; //Adicionalmente esta variable nos indica el dia de la semana 0=Lunes, ... , 6=Domingo.
	var n   =   f+3-d;
	 
	if (n<0){
		//Si la variable n es menor a 0 se trata de una semana perteneciente al año anterior
		var semana = 53-Math.floor((g-s)/5);
		var ano = ano-1; 
	} else if (n>(364+s)) {
		//Si n es mayor a 364 + $s entonces la fecha corresponde a la primera semana del año siguiente.
		var semana = 1;
		var ano = ano+1;
	} else {
		//En cualquier otro caso es una semana del año actual.
		if(d == 6){
			var semana = Math.floor(n/7)+2;
		}else{
			var semana = Math.floor(n/7)+1;
		}
	};
	 
	if(ano > 2014){
		form1.ano_not.value = ano;
		form1.semana_not.value = semana-1;
	}else{
		form1.ano_not.value = ano;
		form1.semana_not.value = semana;
	}

	if((w >= y) && (w <= z)){
		form1.ano_not.value = ano;
		form1.semana_not.value = semana;
	}
}

function duplicadoEdas()
{
	$.ajax({
	  type: "POST",
	  url: window.location.protocol + "//" + window.location.host + '/notiWeb/index.php/edas/validaDuplicado',
	  data: $("#form1").serialize(),
	  dataType: 'json',
		success: function(msg){
			$.each(msg, function(i,item){
				$("#"+i+"*").val(item);				
			});
			if(msg!=''){
				alert('CUIDADO: Ya existen datos para esta semana');
				window.location = window.location.protocol + "//" + window.location.host + '/notiWeb/index.php/edas/modEdas/'+msg.eda; 
			}
			$("#daa_c1").focus();
		}
	});
}

function duplicadoIras()
{
	$.ajax({
	  type: "POST",
	  url: window.location.protocol + "//" + window.location.host + '/notiWeb/index.php/iras/validaDuplicado',
	  data: $("#form1").serialize(),
	  dataType: 'json',
		success: function(msg){
			$.each(msg, function(i,item){
				$("#"+i+"*").val(item);				
			});
			if(msg!=''){
				alert('CUIDADO: Ya existen datos para esta semana');
				window.location = window.location.protocol + "//" + window.location.host + '/notiWeb/index.php/iras/modIras/'+msg.ira; 
			}
			$("#ira_m2").focus();
		}
	});
}

function duplicadoDFebriles()
{
	$.ajax({
	  type: "POST",
	  url: window.location.protocol + "//" + window.location.host + '/notiWeb/index.php/febriles/validaDuplicado',
	  data: $("#form1").serialize(),
	  dataType: 'json',
		success: function(msg){
			$.each(msg, function(i,item){
				$("#"+i+"*").val(item);				
			});
			if(msg!=''){
				alert('CUIDADO: Ya existen datos para esta semana');
				window.location = window.location.protocol + "//" + window.location.host + '/notiWeb/index.php/febriles/modFebriles/'+msg.febril; 
			}
			$("#feb_m1").focus();
		}
	});
}

function showContent() {
	element = document.getElementById("cargandoPNT");
	element.style.display='block';
}


function sumaFebriles(){
	form1.feb_tot.value = Math.floor(form1.feb_m1.value) + Math.floor(form1.feb_1_4.value) + Math.floor(form1.feb_5_9.value) + Math.floor(form1.feb_10_19.value) +  Math.floor(form1.feb_20_59.value) + Math.floor(form1.feb_m60.value);
}

function nobackbutton(){
   window.location.hash="no-back-button";
   window.location.hash="Again-No-back-button" //chrome
   window.onhashchange=function(){window.location.hash="no-back-button";}
}

$(window).on('load', function(){
	$('#cargando').fadeOut(1000);
}); 
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
		$nivelInsti = array('A'=>'MINSA', 'C'=>'ESSALUD', 'D'=>'FFAA/PNP', 'X'=>'PRIVADOS');
        echo ' Nivel: '.$nivelUser[$this->session->userdata('nivel')];
		echo '&nbsp;&nbsp;|&nbsp;&nbspInstituci&oacute;n: '.$nivelInsti[$this->session->userdata('institucion')];
    ?>
  </div>
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