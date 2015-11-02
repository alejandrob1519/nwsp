<!DOCTYPE html>
<html lang='es'>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->layout->getTitle(); ?></title>
<meta name="description" content="<?php echo $this->layout->getDescripcion(); ?>">
<meta name="keywords" content="<?php echo $this->layout->getKeywords(); ?>" />

<link href="<?php echo base_url()?>public/css/blitzer/jquery-ui-1.10.4.custom.css" rel='stylesheet' type='text/css' media='all' />
<link href="<?php echo base_url()?>public/css/index.css" rel='stylesheet' type='text/css' media='all' />
<link href="<?php echo base_url()?>public/css/jquery-ui-1.10.2.custom.min.css" rel="stylesheet" > 

<script type="text/javascript" src="<?php echo base_url()?>public/js/jquery-1.10.2.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>public/js/jquery-ui-1.10.4.custom.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>public/js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>public/js/jquery-ui-1.10.2.custom.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>public/js/combos2.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>public/js/jquery.PrintArea.js"></script>

<!--
<link href="''public/css/index.css" rel='stylesheet' type='text/css' media='all' />
<link href="''public/css/style.css" rel='stylesheet' type='text/css' media='all' />
<link href="''public/bootstrap/css/bootstrap.min.css" rel='stylesheet' type='text/css' media='all' />

<script type="text/javascript" src="''"public/bootstrap/js/bootstrap.min.js"></script>

<script type="text/javascript" src="''"public/js/jquery.PrintArea.js"></script>

	<link rel="stylesheet" href="public/css/style.css" /> 
	<script type="text/javascript" src="public/js/jquery.min.js"></script>
  <script type="text/javascript" src="public/js/script.js"></script> -->

	
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
		yearRange: "2007:2025",
		dateFormat: "dd-mm-yy"
	});
    
	//$( "#fecha_nac" ).datepicker().change(function(){if(!isDate($(this).val()))$(this).val('').focus();});
	
	$("#fecha_mte").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		yearRange: "2007:2025",
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

	$('#programa').change(function () {
		if($('#programa').val() != '3'){
			$('#otro_programa').attr('disabled','disabled');
		}else{
			$('#otro_programa').removeAttr('disabled');
		}
	});

// --- fecha notificacion

$('#fechaNotificacion').change(damefecha);
$('#fechaNotificacion').blur(damefecha);

function damefecha() { 
	var lct = ''+location;
	var url = lct.slice(0, lct.indexOf('notiWeb')+'notiWeb'.length)+'/fecha/';
	$.getJSON(url+'obtenerAnoSemanaFN', {fecha:$('#fechaNotificacion').val()}, function (data) {
		$('#ano').val(data['ano']);
		$('#semana').val(data['semana']);
		$('#fechaNotificacion').val(data['fechaNotificacion']);	
	});
}
	
	// Para las horas
horas = ["hora_nac","hora_mte","hnotifica","hmuerte"];
$.each(horas, function( i, l ){
	$('#'+l).blur(function(){
		if($('#'+l).val()!=''){
			CheckTime(this);
		}
	});
});

function anoInicio()
{
	var x = document.form1.fecha_mte.value;
	
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
		form1.ano.value = ano;
		form1.semana.value = semana-1;
	}else{
		form1.ano.value = ano;
		form1.semana.value = semana;
	}

	if((w >= y) && (w <= z)){
		form1.ano.value = ano;
		form1.semana.value = semana;
	}
}

function CheckTime(str){
	hora=str.value
	//if (hora=='') {return}
	if (hora.length>5) {$("#dialog-message").dialog({modal: true,width:500});
			$("#dialog-message").html("<h3>Introdujo una cadena mayor a 5 caracteres</h3>");$(str).val('');return}
	if (hora.length!=5) {$("#dialog-message").dialog({modal: true,width:500});
			$("#dialog-message").html("<h3>Formato permitido HH:MM</h3>");$(str).val('');return}
	a=hora.charAt(0) //<=2
	b=hora.charAt(1) //<4
	c=hora.charAt(2) //:
	d=hora.charAt(3) //<=5
	g=hora.charAt(4)
	// Para segundos
	e=hora.charAt(5) //:
	f=hora.charAt(6) //<=5
	if ((a==2 && b>3) || (a>2) || (isNaN(a)) || (isNaN(b))) {$("#dialog-message").dialog({modal: true,width:500});
			$("#dialog-message").html("<h3>El valor que introdujo en la Hora no corresponde, introduzca un digito entre 00 y 23</h3>");$(str).val('');return}
	if (d>5 || (isNaN(d)) || (isNaN(g))) {$("#dialog-message").dialog({modal: true,width:500});
			$("#dialog-message").html("<h3>El valor que introdujo en los minutos no corresponde, introduzca un digito entre 00 y 59</h3>");$(str).val('');return}
	//if (f>5) {alert("El valor que introdujo en los segundos no corresponde");return}
	if (c!=':') {$("#dialog-message").dialog({modal: true,width:500});
			$("#dialog-message").html("<h3>Introduzca el caracter ':' para separar la hora y los minutos</h3>");$(str).val('');return}
	//if (c!=':' || e!=':') {alert("Introduzca el caracter ':' para separar la hora y los minutos");$(str).val('');return}
}

$('#edadges').change(function(){
	if($(this).val()<22){
		$("#dialog-message").dialog({modal: true,width:500});
		$("#dialog-message").html("<h3>Usted a ingresado "+$(this).val()+" Edad minima 22 semanas</h3>");
		//$(this).val('22');
		if($(this).val()<20){
		   $(this).val('');  
		}
		return;
	}
	if($(this).val()>43){
		$("#dialog-message").dialog({modal: true,width:500});
		$("#dialog-message").html("<h3>Usted a ingresado "+$(this).val()+" como edad gestacional. Maxima es 43 Semanas</h3>");
		//$(this).val('43');
		if($(this).val()>46){
		   $(this).val('');  
		}
		return;
	}
	if($('#edadges').val()>33 && $('#diagno').val()=='P07.2'){
                     $("#dialog-message").dialog({modal: true,width:500});
		             $("#dialog-message").html("<h3>El Diagnostico " + $('#diagno').val() + " es inconsistente con la edad gestacional (Edad < 34)</h3>");		
                     $( "#edadges" ).val('')	
	}	
	if($('#edadges').val()>35 && $('#diagno').val()=='P22.0' && $('#tipo_mte').val()=='N'){
                     $("#dialog-message").dialog({modal: true,width:500});
		             $("#dialog-message").html("<h3>El Diagnostico " + $('#diagno').val() + " no debe existir en Neonatos con 36 a mas semanas (Edad Gestacional) </h3>");		
                     $( "#edadges" ).val('')	
	}	

});	
// Para el peso 
$("#peso_nac").change(function(){
	if($(this).val()<500){
		$("#dialog-message").dialog({modal: true,width:500});
		$("#dialog-message").html("<h3>Peso minimo 500 gramos</h3>");
		$(this).val('');
		return;
	}
	if($(this).val()>6500){
		$("#dialog-message").dialog({modal: true,width:500});
		$("#dialog-message").html("<h3>Usted a ingresado "+$(this).val()+" gramos como peso. Maximo es 6500 gramos</h3>");
		if($(this).val()>8000){
		   $(this).val('');  
		}		//$(this).val('6500');
		return;
	}

});

// MUERTE MATERNA PERINATAL
	
	// CAUSAS  (CREAR)
    $( "#causa_bas" ).autocomplete({
	    minLength: 1,
	    source: 'causasMM',
	    select: function( event, ui ) {
	        $( "#codcat" ).val( ui.item.codigo );
	        $( "#categoria" ).val( ui.item.clave );
	        $( "#causa_bas" ).val( ui.item.value );
	        $( "#diagno" ).val( ui.item.id );
  		          //p20
				  var diagno1 = $('#diagno').val();		
		          var t = diagno1.substr(0,3);  
    			  if($("#tipo_mte").val()=='N' && t=='P20'){	  
                     $("#dialog-message").dialog({modal: true,width:500});
		             $("#dialog-message").html("<h3>El Diagostico es " + t + " Exclusivo para Muerte Fetal revisar diagnostico o tipo de muerte</h3>");		
                     //$( "#diagno" ).val('')
                     //$( "#categoria" ).val('')
                     //$( "#codcat" ).val('')
					 //$( "#causa_bas" ).val('')
	                 $('#tipo_mte option[value=""]').attr('selected', '');
  			      }
		          //P21
				  var diagno1 = $('#diagno').val();		
		          var t = diagno1.substr(0,3);  
    			  if($("#tipo_mte").val()=='F' && t=='P21'){	  
                     $("#dialog-message").dialog({modal: true,width:500});
		             $("#dialog-message").html("<h3>El Diagostico es " + t + " Exclusivo para Neonatos</h3>");		
                     //$( "#diagno" ).val('')
                     //$( "#categoria" ).val('')
                     //$( "#codcat" ).val('')
 	                 $('#tipo_mte option[value=""]').attr('selected', '');
  			      }  
		          //P07.2
				  var diagno1 = $('#diagno').val();		
		          var t = diagno1.substr(0,5);  
    			  if($('#edadges').val()>33 && t=='P07.2'){	  
                     $("#dialog-message").dialog({modal: true,width:500});
		             $("#dialog-message").html("<h3>El Diagostico " + t + " es inconsistente con la edad gestacional (Edad < 34)</h3>");		
                     $( "#edadges" ).val('')
  			      }  
		          //P22.0
				  var diagno1 = $('#diagno').val();		
		          var t = diagno1.substr(0,5);  
    			  if($('#edadges').val()>35 && t=='P22.0' && $("#tipo_mte").val()=='N'){	  
                     $("#dialog-message").dialog({modal: true,width:500});
                     $("#dialog-message").html("<h3>El Diagnostico " + t + " no debe existir en Neonatos con 36 a mas semanas (Edad Gestacional) </h3>");		
					 $( "#edadges" ).val('')
  			      }  
    			  if(t=='P22.0' && $("#tipo_mte").val()=='F'){	  
                     $("#dialog-message").dialog({modal: true,width:500});
                     $("#dialog-message").html("<h3>El Diagnostico " + t + " no debe existir en Fetos </h3>");		
					 $('#tipo_mte option[value=""]').attr('selected', '');
  			      }  
				  
		  
			}
 
	});
	$( "#causa_bas" ).change(function(){
		if($( "#causa_bas" ).val()==''){$( "#diagno" ).val('')};
        if($( "#causa_bas" ).val()==''){$( "#categoria" ).val('')};
        if($( "#causa_bas" ).val()==''){$( "#codcat" ).val('')};
 	});

	// CAUSAS (modificar)
    //var baseurl = '<?=base_url()?>';
    $( "#causa_ba" ).autocomplete({
	    minLength: 1,
	    source: '../causasMM',
	    select: function( event, ui ) {
	        $( "#codcat" ).val( ui.item.codigo );
	        $( "#categoria" ).val( ui.item.clave );
	        $( "#causa_ba" ).val( ui.item.value );
	        $( "#diagno" ).val( ui.item.id );
 		          //P20
				  var diagno1 = $('#diagno').val();		
		          var t = diagno1.substr(0,3);  
    			  if($("#tipo_mte").val()=='N' && t=='P20'){	  
                     $("#dialog-message").dialog({modal: true,width:500});
		             $("#dialog-message").html("<h3>El Diagostico es " + t + " Exclusivo para Muerte Fetal revisar diagnostico o tipo de muerte</h3>");		
                     //$( "#diagno" ).val('')
                     //$( "#categoria" ).val('')
                     //$( "#codcat" ).val('')
 	                 $('#tipo_mte option[value=""]').attr('selected', '');
  			      }  
 		          //P21
				  var diagno1 = $('#diagno').val();		
		          var t = diagno1.substr(0,3);  
    			  if($("#tipo_mte").val()=='F' && t=='P21'){	  
                     $("#dialog-message").dialog({modal: true,width:500});
		             $("#dialog-message").html("<h3>El Diagostico es " + t + " Exclusivo para Neonatos</h3>");		
                     //$( "#diagno" ).val('')
                     //$( "#categoria" ).val('')
                     //$( "#codcat" ).val('')
 	                 $('#tipo_mte option[value=""]').attr('selected', '');
  			      }  
		          //P07.2
				  var diagno1 = $('#diagno').val();		
		          var t = diagno1.substr(0,5);  
    			  if($('#edadges').val()>33 && t=='P07.2'){	  
                     $("#dialog-message").dialog({modal: true,width:500});
		             $("#dialog-message").html("<h3>El Diagostico " + t + " es inconsistente con la edad gestacional (Edad < 34)</h3>");		
                     $( "#edadges" ).val('')
  			      }  
		          //P22.0
				  var diagno1 = $('#diagno').val();		
		          var t = diagno1.substr(0,5);  
    			  if($('#edadges').val()>35 && t=='P22.0' && $("#tipo_mte").val()=='N'){	  
                     $("#dialog-message").dialog({modal: true,width:500});
                     $("#dialog-message").html("<h3>El Diagnostico " + t + " no debe existir en Neonatos con 36 a mas semanas (Edad Gestacional) </h3>");		
					 $( "#edadges" ).val('')
  			      }  
    			  if(t=='P22.0' && $("#tipo_mte").val()=='F'){	  
                     $("#dialog-message").dialog({modal: true,width:500});
                     $("#dialog-message").html("<h3>El Diagnostico " + t + " no debe existir en Fetos </h3>");		
					 $('#tipo_mte option[value=""]').attr('selected', '');
  			      }  			   
			}
	}); 
	$( "#causa_ba" ).change(function(){
		if($( "#causa_ba" ).val()==''){$( "#diagno" ).val('')};
    if($( "#causa_ba" ).val()==''){$( "#categoria" ).val('')};
    if($( "#causa_ba" ).val()==''){$( "#codcat" ).val('')};
	});


//var baseurl = '<?=base_url()?>';

 
//Para las fechas de nacimiento y muerte
function existeFecha(fechar, str, feo){
      var fechaf = fechar.split("-");
      var day = fechaf[0];
      var month = fechaf[1];
      var year = fechaf[2];
  
      fec=new Date; 
      dia=fec.getDate(); 
      if (dia<10) dia='0'+dia; 
          mes=fec.getMonth(); 
      if (mes<10) mes='0'+mes; 
          anio=fec.getFullYear(); 
  
      var fechas1 = dia+'-'+mes+'-'+anio;
      
      var fechas2 = new Date(anio, mes, dia);	  
      //if((Date.parse($("#fecha_nac").val())) > (Date.parse(fechas1))){
      //var date = new Date(year,month,'0');
      //var hoya = new date (hoy.getDate() + "-" + (hoy.getMonth() +1) + "-" + hoy.getFullYear());
      var plantilla = new Date(year, month - 1, day);//mes empieza de cero Enero = 0 
      if(!plantilla || plantilla.getFullYear() == year && plantilla.getMonth() == month -1 && plantilla.getDate() == day){
            //$("#dialog-message").dialog({modal: true,width:500});
			//$("#dialog-message").html("<h3> dia ("+day+") mes ("+month+") year ("+year+") </h3>");
           //if($("#fecha_nac").val()>fechas1){
		   if((Date.parse(plantilla)) > (Date.parse(fechas2))){
              $("#dialog-message").dialog({modal: true,width:500});
			  $("#dialog-message").html("<h3>La Fecha " + feo +  " es Mayor a la fecha actual </h3>");
			  $(str).val('');
			  return false;
            }else{
				var apli='4';
				//aqui se hace el proceso de verificacion de cierre de año
				$.ajax({
					url: "/notiWeb/index.php/modulosmnp/vercierreaplica",
					data: { anio: year, apli: apli }
				}).done(function( msg ) {
					var obj = jQuery.parseJSON(msg);
					//alert(obj.estado);
					if (obj.estado==1 && feo=="Muerte"){
                       $("#dialog-message").dialog({modal: true,width:500});
			           $("#dialog-message").html("<h3>El Año ingresado "+ year +" Esta cerrado </h3>");
					   $(str).val('');
					   return false;
					}else{
					  if (year<2007 && feo=="Muerte"){
							$("#dialog-message").dialog({modal: true,width:500});
							$("#dialog-message").html("<h3>El Año ingresado "+ year +" Es menor del 2007 (Año de inicio de la vigilancia MNP) </h3>");
							$(str).val('');
							return false;
					  }else{	
							return true;
					  }
					}
				});
		   }
      }else{
            $("#dialog-message").dialog({modal: true,width:500});
			$("#dialog-message").html("<h3>La Fecha de "+feo+" ("+fechar+") es Errada </h3>");
			$(str).val('');
         return false;
      }     
}

function comparaFecha(fechar1,fechar2,feo1,feo2,str){
      //fecha1 
      var fechaf1 = fechar1.split("-");
      var day1 = fechaf1[0];
      var month1 = fechaf1[1];
      var year1 = fechaf1[2];
      var fechas1 = new Date(year1, month1 - 1, day1);//mes empieza de cero Enero = 0 
      //fecha2
      var fechaf2 = fechar2.split("-");
      var day2 = fechaf2[0];
      var month2 = fechaf2[1];
      var year2 = fechaf2[2];
      var fechas2 = new Date(year2, month2 - 1, day2);//mes empieza de cero Enero = 0 
      if((Date.parse(fechas1)) > (Date.parse(fechas2))){
              $("#dialog-message").dialog({modal: true,width:500});
			  $("#dialog-message").html("<h3>La Fecha de " + feo1 +  " es Mayor a la fecha de "+feo2+"</h3>");
			  $(str).val('');
			  form1.diasvid.value = 0;
    	      form1.ano.value = '';
		      form1.semana.value = '';
			  return false;
            }else{
			  var a=anoInicio();
			  var b=nombrehijo();
   			  return true;
	  }
}     


$("#fecha_nac").change(function(){   
   var f1 =$("#fecha_nac").val();
   var f2 = "#fecha_nac";
   var f4 = "Nacimiento";
   /*$('#hora_nac').val($('').val());*/
   existeFecha(f1, f2, f4); 

   /*   var f1 = $("#fecha_nac").val();
   fec=new Date; 
   dia=fec.getDate(); 
   if (dia<10) dia='0'+dia; 
      mes=fec.getMonth() + 1; 
   if (mes<10) mes='0'+mes; 
      anio=fec.getFullYear(); 
  
   var fechas1 = dia+'-'+mes+'-'+anio;
   
   //if((Date.parse($("#fecha_nac").val())) > (Date.parse(fechas1))){
   if($("#fecha_nac").val()>fechas1){
            $("#dialog-message").dialog({modal: true,width:500});
			$("#dialog-message").html("<h3>La Fecha de Nacimiento es Mayor a la fecha actual "+ fechas1 +"</h3>");
			$(this).val('');
   }else{
            $("#dialog-message").dialog({modal: true,width:500});
			$("#dialog-message").html("<h3>ok</h3>");   
   }
*/  
  if($("#fecha_mte").val()!=''){ 
               var f1 =$("#fecha_nac").val();
               var f2 =$("#fecha_mte").val();
               form1.diasvid.value = (restaFechas(f1,f2));
   				if($("#diasvid").val()==1) {
                   var inicio =$("#hora_nac").val();
                   var fin =$("#hora_mte").val();
                   form1.diasvid.value = (restaHoras(inicio,fin));
                 }else{
	               	if($("#diasvid").val()<0) {
                		$("#dialog-message").dialog({modal: true,width:500});
		                $("#dialog-message").html("<h3>La Fecha de Muerte es menor de Fecha de Nacimiento 2</h3>");
                        $('#fecha_nac').val($('').val());
                        $('#hora_nac').val($('').val());
                        form1.diasvid.value = 0;
						return
                    }else{
 						if($("#diasvid").val()>28) {
                     	   $("#dialog-message").dialog({modal: true,width:500});
		                   $("#dialog-message").html("<h3>Los Dias de Vida "+ $("#diasvid").val() +" Superan a los dias permitidos</h3>");
                           $('#fecha_nac').val($('').val());
                           $('#hora_nac').val($('').val());
                           form1.diasvid.value = 0;
						   return
                         }
					}
				 }

       if($("#tipo_mte").val()=='F'){
	          if($("#fecha_nac").val()!=$("#fecha_mte").val()){
		            $("#dialog-message").dialog({modal: true,width:500});
		            $("#dialog-message").html("<h3>La Fecha de Nacimiento no puede ser diferente de Fecha de Muerte por ser fetal</h3>");
         			$('#fecha_mte').val($('').val());
                    $('#hora_mte').val($('').val());
					form1.ano.value = '';
		            form1.semana.value = '';
                    form1.diasvid.value = 0;
		          //$('#fecha_mte').val($('#fecha_nac').val());
			        return
	          }       
       }else{
	          if($("#fecha_nac").val()>$("#fecha_mte").val()){
		          //if($('#fechaNacimiento').val()==''){
		          $("#dialog-message").dialog({modal: true,width:500});
		          $("#dialog-message").html("<h3>La Fecha de Nacimiento "+$("#fecha_nac").val()+"es Mayor de Fecha de Defuncion"+$("#fecha_mte").val()+"</h3>");
		          //$('#fecha_mte').val($('#fecha_nac').val());
                  $('#fecha_mte').val($('').val());
                  $('#hora_mte').val($('').val());
                  form1.diasvid.value = 0;
			        return
		          //}
	          }
       }
	}else{
					       var f1 = $("#hora_nac").val();
				           var ahoras = f1.split(':'); 
                           var ahor = ahoras[0];
				           var amin = ahoras[1];
                           var hora = fec.getHours(); 
                           var minutos = fec.getMinutes();
				           if (ahor>hora) {
				              $("#dialog-message").dialog({modal: true,width:500});
		                      $("#dialog-message").html("<h3>La Hora de Nacimiento "+ $("#hora_nac").val() +" es mayor a la hora permitida</h3>");				   
                              $('#hora_nac').val($('').val());					  
					       }else{
					          if (ahor==hora) {
						          if (amin>minutos) {
							         $("#dialog-message").dialog({modal: true,width:500});
		                             $("#dialog-message").html("<h3>Los Minutos de Nacimiento "+ $("#hora_nac").val() + " es mayor a los minutos permitidos </h3>");	
                                     $('#hora_nac').val($('').val()); 					  						  
   					              } 
					          } 
				           }  
						}
});

$("#fecha_mte").change(function(){
    var f1 =$("#fecha_mte").val();
    var f2 = "#fecha_mte";
    var f4 = "Muerte";
    existeFecha(f1, f2, f4); 
	comparaFecha($("#fecha_nac").val(),f1,"Nacimiento",f4,f2)
        if($("#fecha_mte").val()!=''){
            if($("#fecha_nac").val()!=''){
                var f1 =$("#fecha_nac").val();
                var f2 =$("#fecha_mte").val();
                form1.diasvid.value = (restaFechas(f1,f2));
				if($("#diasvid").val()==1) {
                   var inicio =$("#hora_nac").val();
                   var fin =$("#hora_mte").val();
                   form1.diasvid.value = (restaHoras(inicio,fin));
                 }
               
               //form1.diasvid.value = (restaFechas(f1,f2));
        }       
              	if($("#diasvid").val()<0) {
                		$("#dialog-message").dialog({modal: true,width:500});
		                $("#dialog-message").html("<h3>La Fecha de Muerte es menor de Fecha de Nacimiento </h3>");
                    $('#fecha_mte').val($('').val());
                    $('#hora_mte').val($('').val());
					form1.ano.value = '';
		            form1.semana.value = '';
                    form1.diasvid.value = 0;
                }else{
				       	if($("#diasvid").val()>28) {
                     	   $("#dialog-message").dialog({modal: true,width:500});
		                   $("#dialog-message").html("<h3>Los Dias de Vida "+ $("#diasvid").val() +" Superan a los dias permitidos</h3>");
                           $('#fecha_mte').val($('').val());
                           $('#hora_mte').val($('').val());
					       form1.ano.value = '';
		                   form1.semana.value = '';
                           form1.diasvid.value = 0;
                        }else{
					       var f1 = $("#hora_mte").val();
				           var ahoras = f1.split(':'); 
                           var ahor = ahoras[0];
				           var amin = ahoras[1];
                           var hora = fec.getHours(); 
                           var minutos = fec.getMinutes();
				           if (ahor>hora) {
				              $("#dialog-message").dialog({modal: true,width:500});
		                      $("#dialog-message").html("<h3>La Hora de Fallecimiento "+ $("#hora_mte").val() +" es mayor a la hora permitida</h3>");				   
                              $('#hora_mte').val($('').val());					  
					       }else{
					          if (ahor==hora) {
						          if (amin>minutos) {
							         $("#dialog-message").dialog({modal: true,width:500});
		                             $("#dialog-message").html("<h3>Los Minutos de Fallecimiento "+ $("#hora_mte").val() + " es mayor a los minutos permitidos </h3>");	
                                     $('#hora_mte').val($('').val()); 					  						  
   					              } 
					          } 
				           }  
						}
				}
                return
            } 


	/*
	if($("#fecha_mte").val()<$("#fecha_nac").val()){
		$("#dialog-message").dialog({modal: true,width:500});
		$("#dialog-message").html("<h3>La Fecha de Muerte "+ $("#fecha_mte").val() +"es menor de Fecha de Nacimiento "+ $("#fecha_nac").val() +"</h3>");
        $('#fecha_mte').val($('').val());
        $('#hora_mte').val($('').val());
        form1.diasvid.value = 0;
		
			return
	}else{
		var a=anoInicio();
		var b=nombrehijo();
        if($("#fecha_mte").val()!=''){
            if($("#fecha_nac").val()!=''){
                var f1 =$("#fecha_nac").val();
                var f2 =$("#fecha_mte").val();
                form1.diasvid.value = (restaFechas(f1,f2));
              	if($("#diasvid").val()<0) {
                		$("#dialog-message").dialog({modal: true,width:500});
		                $("#dialog-message").html("<h3>La Fecha de Muerte es menor de Fecha de Nacimiento 2</h3>");
                    $('#fecha_mte').val($('').val());
                    $('#hora_mte').val($('').val());
                    form1.diasvid.value = 0;
                }
                return
            }
    } 
	}
*/	
});

$("#hora_mte").change(function(){
              var fec=new Date; 
              var dia=fec.getDate(); 
              if (dia<10) dia='0'+dia; 
              var mes=fec.getMonth()+1; 
              if (mes<10) mes='0'+mes; 
              var anio=fec.getFullYear(); 
              var f2 = dia+'-'+mes+'-'+anio;					
              var f1 =$("#fecha_mte").val();
			  //var f2 = fecha_js;
			  var resta = restaFechaact(f1,f2);
			  //alert(resta);
              if (restaFechaact(f1,f2)==0) {
   		          //$("#dialog-message").dialog({modal: true,width:500});
		          //$("#dialog-message").html("<h3>La Fecha de Nacimiento es igual ala fecha del servidor</h3>");
				   var f1 = $("#hora_mte").val();
				   var ahoras = f1.split(':'); 
                   var ahor = ahoras[0];
				   var amin = ahoras[1];
                   var hora = fec.getHours(); 
                   var minutos = fec.getMinutes();
				   if (ahor>hora) {
				      $("#dialog-message").dialog({modal: true,width:500});
		              $("#dialog-message").html("<h3>La Hora de nacimiento es mayor a la hora permitida</h3>");				   
                      $(this).val(''); 					  
					 }else{
					   if (ahor==hora) {
						   if (amin>minutos) {
							  $("#dialog-message").dialog({modal: true,width:500});
		                      $("#dialog-message").html("<h3>Los Minutos de nacimiento es mayor a los minutos permitidos </h3>");	
                              $(this).val(''); 					  						  
   					       } 
	
					   } 
				   }
              }else{
				      //verifica con el tipo de muerte
					if($("#tipo_mte").val()=='F'){
						if($("#fecha_nac").val()!=$("#fecha_mte").val()){
								$("#dialog-message").dialog({modal: true,width:500});
								$("#dialog-message").html("<h3>La Fecha de Nacimiento no puede ser diferente de Fecha de Muerte por ser fetal</h3>");
							if($("#fecha_mte").val()!=''){
							if($("#hora_mte").val()!=''){
								$('#fecha_nac').val($('#fecha_mte').val());
								$('#hora_nac').val($('#hora_mte').val());
							}else{
								$('#fecha_nac').val($('#fecha_mte').val());
								if($("#hora_nac").val()!=''){
									$('#hora_mte').val($('#hora_nac').val());
								}else{ 
									$('#hora_nac').val($('').val());
								}  
							}	
						}else{
							if($("#fecha_nac").val()!=''){
								if($("#hora_nac").val()!=''){
									$('#fecha_mte').val($('#fecha_nac').val());
									$('#hora_mte').val($('#hora_nac').val());
									var a=anoInicio();
								}else{					 
								}
							}
						} 
							form1.diasvid.value = 0;
							//$('#fecha_mte').val($('#fecha_nac').val());
							return
						}else{ 
					       if($("#hora_mte").val()!=''){
						     if($("#hora_nac").val()!=$("#hora_mte").val()){
						        $('#hora_nac').val($('#hora_mte').val());
		                        $("#dialog-message").dialog({modal: true,width:500});
		                        $("#dialog-message").html("<h3>La Hora de Nacimiento no puede ser diferente a la Hora de Muerte por ser fetal</h3>");
					    	 }
							}		 
						}  
					}
			  }  
			  
	var f1 =$("#fecha_mte").val();
	
    if($("#fecha_mte").val()!=''){
	        if($("#hora_nac").val()!=''){
              var f1 =$("#fecha_nac").val();
              var f2 =$("#fecha_mte").val();
              form1.diasvid.value = (restaFechas(f1,f2));
      	   if($("#diasvid").val()==1) {
                var inicio =$("#hora_nac").val();
                var fin =$("#hora_mte").val();
                form1.diasvid.value = (restaHoras(inicio,fin));
                return
               
               //form1.diasvid.value = (restaFechas(f1,f2));
           }        
	    }
	}else{
	}	
});

$("#hora_nac").change(function(){
  //alert("Esyooooo");
                // Recogemos la fecha del servidor.
                    //var fechaser = "<%=Now()%>";
			    // Pasamos la fecha a javascript
                    //var fecha_js = new Date();
      var fec=new Date; 
      var dia=fec.getDate(); 
      if (dia<10) dia='0'+dia; 
          var mes=fec.getMonth()+1; 
      if (mes<10) mes='0'+mes; 
          var anio=fec.getFullYear(); 
  
              var f2 = dia+'-'+mes+'-'+anio;					
              var f1 =$("#fecha_nac").val();
			  //var f2 = fecha_js;
			  var resta = restaFechaact(f1,f2);
			  //alert(resta);
              if (restaFechaact(f1,f2)==0) {
   		          //$("#dialog-message").dialog({modal: true,width:500});
		          //$("#dialog-message").html("<h3>La Fecha de Nacimiento es igual ala fecha del servidor</h3>");
				   var f1 = $("#hora_nac").val();
				   var ahoras = f1.split(':'); 
                   var ahor = ahoras[0];
				   var amin = ahoras[1];
				   
                   var hora = fec.getHours(); 
                   var minutos = fec.getMinutes();
				   if (ahor>hora) {
				      $("#dialog-message").dialog({modal: true,width:500});
		              $("#dialog-message").html("<h3>La Hora de nacimiento es mayor a la hora permitida</h3>");				   
                      $(this).val(''); 					  
					 }else{
					   if (ahor==hora) {
						   if (amin>minutos) {
							  $("#dialog-message").dialog({modal: true,width:500});
		                      $("#dialog-message").html("<h3>Los Minutos de nacimiento es mayor a los minutos permitidos </h3>");	
                              $(this).val(''); 					  						  
   					       } 
	
					   } 
				   }
              }else{
				      //verifica con el tipo de muerte
					if($("#tipo_mte").val()=='F'){
						if($("#fecha_nac").val()!=$("#fecha_mte").val()){
								$("#dialog-message").dialog({modal: true,width:500});
								$("#dialog-message").html("<h3>La Fecha de Nacimiento no puede ser diferente de Fecha de Muerte por ser fetal</h3>");
							if($("#fecha_mte").val()!=''){
							if($("#hora_mte").val()!=''){
								$('#fecha_nac').val($('#fecha_mte').val());
								$('#hora_nac').val($('#hora_mte').val());
							}else{
								$('#fecha_nac').val($('#fecha_mte').val());
								if($("#hora_nac").val()!=''){
									$('#hora_mte').val($('#hora_nac').val());
								}else{ 
									$('#hora_nac').val($('').val());
								}  
							}	
						}else{
							if($("#fecha_nac").val()!=''){
								if($("#hora_nac").val()!=''){
									$('#fecha_mte').val($('#fecha_nac').val());
									$('#hora_mte').val($('#hora_nac').val());
									var a=anoInicio();
								}else{					 
								}
							}
						} 
							form1.diasvid.value = 0;
							//$('#fecha_mte').val($('#fecha_nac').val());
							return
						}else{ 
					       if($("#hora_mte").val()!=''){
						     if($("#hora_nac").val()!=$("#hora_mte").val()){
						        $('#hora_nac').val($('#hora_mte').val());
		                        $("#dialog-message").dialog({modal: true,width:500});
		                        $("#dialog-message").html("<h3>La Hora de Nacimiento no puede ser diferente a la Hora de Muerte por ser fetal</h3>");
					    	 }
							}else{
							 $('#hora_mte').val($('#hora_nac').val());
							}		
						}  
					}			  
			  } 		
  if($("#fecha_nac").val()!=''){  
      if($("#hora_mte").val()!=''){
              var f1 =$("#fecha_nac").val();
              var f2 =$("#fecha_mte").val();
              form1.diasvid.value = (restaFechas(f1,f2));
      	if($("#diasvid").val()==1) {
                var inicio =$("#hora_nac").val();
                var fin =$("#hora_mte").val();
                form1.diasvid.value = (restaHoras(inicio,fin));
                return
               
               //form1.diasvid.value = (restaFechas(f1,f2));
        }       
	  }
  }else{
  } 	  
});

// Función para calcular los Horas transcurridas
restaHoras = function(inicio,fin) 
{
  inicioMinutos = parseInt(inicio.substr(3,2));
  inicioHoras = parseInt(inicio.substr(0,2));
  finMinutos = parseInt(fin.substr(3,2));
  finHoras = parseInt(fin.substr(0,2));
  transcurridoMinutos =  (finMinutos - inicioMinutos);
  transcurridoHoras = 24 + (finHoras - inicioHoras);
  if (transcurridoMinutos < 0) {
    transcurridoHoras--;
    transcurridoMinutos = 60 + transcurridoMinutos;
  }
  horas = transcurridoHoras;
  //alert(horas);
  
  //horas = transcurridoHoras.toString();
  //minutos = transcurridoMinutos.toString();
  if (horas < 24) {
    horas = 0;
  }else{  
    horas = 1;
  }
  //document.getElementById("resta").value = horas+":"+minutos;
  return horas;
}

// Función para calcular los días transcurridos entre dos fechas
restaFechas = function(f1,f2)
 {
 var aFecha1 = f1.split('-'); 
 var aFecha2 = f2.split('-'); 
 var fFecha1 = Date.UTC(aFecha1[2],aFecha1[1]-1,aFecha1[0]); 
 var fFecha2 = Date.UTC(aFecha2[2],aFecha2[1]-1,aFecha2[0]); 
 var dif = fFecha2 - fFecha1;
 var dias = Math.floor(dif / (1000 * 60 * 60 * 24));
 form1.diasvid.value = dias; 
            //if(dias == 1){
            //   alert("Es uno");
            //}
 
 return dias;
 }

restaFechaact = function(f1,f2)
 {
 var aFecha1 = f1.split('-'); 
 var aFecha2 = f2.split('-'); 
 var fFecha1 = Date.UTC(aFecha1[2],aFecha1[1]-1,aFecha1[0]); 
 var fFecha2 = Date.UTC(aFecha2[2],aFecha2[1]-1,aFecha2[0]); 
 var dif = fFecha2 - fFecha1;
 var dias = Math.floor(dif / (1000 * 60 * 60 * 24)); 
 return dias;
 }
 
 
$("#fecha_mte").change(function(){
	if($("#tipo_mte").val()=='F'){
		//if($('#fechaNacimiento').val()==''){
		//	$('#fecha_nac').val($(this).val());
 	          if($("#fecha_nac").val()!=$("#fecha_mte").val()){
		          $("#dialog-message").dialog({modal: true,width:500});
		          $("#dialog-message").html("<h3>La Fecha de Nacimiento no puede ser diferente de Fecha de Muerte por ser fetal</h3>");
         		  $('#fecha_mte').val($('').val());
                  $('#hora_mte').val($('').val());
                  form1.diasvid.value = 0;
			      form1.ano.value = '';
		          form1.semana.value = '';

		          //$('#fecha_mte').val($('#fecha_nac').val());
			        return
	          }     
			//return
		//}
	}
	
});

$("#tipo_mte").change(function(){
	if($("#tipo_mte").val()=='F'){
 	          if($("#fecha_nac").val()!=$("#fecha_mte").val()){
		          $("#dialog-message").dialog({modal: true,width:500});
		          $("#dialog-message").html("<h3>La Fecha de Nacimiento no puede ser diferente de Fecha de Muerte por ser fetal</h3>");
				     if($("#fecha_mte").val()!=''){
					    if($("#hora_mte").val()!=''){
						   $('#fecha_nac').val($('#fecha_mte').val());
						   $('#hora_nac').val($('#hora_mte').val());
						}else{
						   $('#fecha_nac').val($('#fecha_mte').val());
						   if($("#hora_nac").val()!=''){
						      $('#hora_mte').val($('#hora_nac').val());
						   }else{ 
						      $('#hora_nac').val($('').val());
						   }  
					    }	
					 }else{
				     if($("#fecha_nac").val()!=''){
					    if($("#hora_nac").val()!=''){
						   $('#fecha_mte').val($('#fecha_nac').val());
						   $('#hora_mte').val($('#hora_nac').val());
						   var a=anoInicio();
						}else{					 
					    }
					 }
					} 
                    form1.diasvid.value = 0;
		            //$('#fecha_mte').val($('#fecha_nac').val());
			        return
     			  }else{ 
					       if($("#hora_mte").val()!=''){
						     if($("#hora_nac").val()!=$("#hora_mte").val()){
						        $('#hora_nac').val($('#hora_mte').val());
		                        $("#dialog-message").dialog({modal: true,width:500});
		                        $("#dialog-message").html("<h3>La Hora de Nacimiento no puede ser diferente a la Hora de Muerte por ser fetal</h3>");
					    	 }
							}		 
						   }  
    
	}
	
});

// Para momento de muerte
$("#tipo_mte").change(function(){
	if($(this).val()=='F') {  
		$("#momento").find('option[value="3"]').remove();
		$("#momento").find('option[value="1"]').remove();
		$("#momento").find('option[value="2"]').remove();
		$('#momento').append('<option value="1">1 - Ante - Parto</option>');
		$('#momento').append('<option value="2">2 - Intra - Parto</option>');
		          var diagno1 = $('#diagno').val();		
		          var t = diagno1.substr(0,3);  
				  var t1 = diagno1.substr(0,5);  
    			  if($("#tipo_mte").val()=='F' && t=='P21'){	  
                     $("#dialog-message").dialog({modal: true,width:500});
		             $("#dialog-message").html("<h3>El Diagostico es " + t + " Exclusivo para Neonatos</h3>");		
                     $( "#diagno" ).val('')
                     $( "#categoria" ).val('')
                     $( "#codcat" ).val('')
					 $( "#causa_bas" ).val('')
  			      }	
    			  if(t1=='P22.0'){	  
                     $("#dialog-message").dialog({modal: true,width:500});
                     $("#dialog-message").html("<h3>El Diagnostico " + t1 + " no debe existir en Fetos </h3>");		
					 $('#tipo_mte option[value=""]').attr('selected', '');
  			      }  
				  

		return
	}
	else if($(this).val()=='N') {  
		$("#momento").find('option[value="3"]').remove();
		$("#momento").find('option[value="1"]').remove();
		$("#momento").find('option[value="2"]').remove();
		$('#momento').append('<option value="3">3 - Post - Parto</option>');
		          var diagno1 = $('#diagno').val();		
		          var t = diagno1.substr(0,3); 
                  var t1 = diagno1.substr(0,5); 				  
    			  if($("#tipo_mte").val()=='N' && t=='P20'){	  
                     $("#dialog-message").dialog({modal: true,width:500});
		             $("#dialog-message").html("<h3>El Diagostico es " + t + " Exclusivo para Muerte Fetal revisar diagnostico o tipo de muerte</h3>");		
                     $( "#diagno" ).val('')
                     $( "#categoria" ).val('')
                     $( "#codcat" ).val('')
					 $( "#causa_bas" ).val('')
 				 }
            	  if($('#edadges').val()>35 && t1=='P22.0'){
                     $("#dialog-message").dialog({modal: true,width:500});
		             $("#dialog-message").html("<h3>El Diagnostico " + t1 + " no debe existir en Neonatos con 36 a mas semanas (Edad Gestacional) </h3>");		
                     $( "#edadges" ).val('')	
	             }	
    			  if($("#sexo").val()=='I'){	  
                     $("#dialog-message").dialog({modal: true,width:500});
		             $("#dialog-message").html("<h3>Un Potencial error que solo puede considerarse en caso de un RN malformado</h3>");		
 				 }
						     if($("#hora_nac").val()==$("#hora_mte").val() && $("#fecha_nac").val()==$("#fecha_mte").val()){
		                        $("#dialog-message").dialog({modal: true,width:500});
		                        $("#dialog-message").html("<h3>Las fecha y Horas son identicas la Muerte debe ser fetal</h3>");
								$('#tipo_mte option[value=""]').attr('selected', '');
					    	 }

				 
		return
	}else{
		$("#momento").find('option[value="3"]').remove();
		$("#momento").find('option[value="1"]').remove();
		$("#momento").find('option[value="2"]').remove();
		$('#momento').append('<option value="1">1 - Ante - Parto</option>');
		$('#momento').append('<option value="2">2 - Intra - Parto</option>');
		$('#momento').append('<option value="3">3 - Post - Parto</option>');
		return
	}
});

//Para lugar de nacimiento
//$("#lugar_par").change(function(){
//	if($("#tipo_mte").val()=='F'){
//		if($(this).val()=='PI'){
//			$('#lugar_mte option[value="ES"]').attr('selected', '');
//			return
//		}
//		else if($(this).val()=='PD'){
//			$('#lugar_mte option[value="CC"]').attr('selected', '');
//			return
//		}else{
//			$('#lugar_mte option').removeAttr('selected');
//			return
//		}
//	}
//});

});

$(window).on('load', function(){
	$('#cargando').fadeOut(1000);
}); 

function fecha( cadena ) {

   //Separador para la introduccion de las fechas
   var separador = "/"

   //Separa por dia, mes y año
   if ( cadena.indexOf( separador ) != -1 ) {
        var posi1 = 0
        var posi2 = cadena.indexOf( separador, posi1 + 1 )
        var posi3 = cadena.indexOf( separador, posi2 + 1 )
        this.dia = cadena.substring( posi1, posi2 )
        this.mes = cadena.substring( posi2 + 1, posi3 )
        this.anio = cadena.substring( posi3 + 1, cadena.length )
   } else {
        this.dia = 0
        this.mes = 0
        this.anio = 0   
   }
}

function showContent() {
	element = document.getElementById("cargandoPNT");
	element.style.display='block';
}

function justNumbers(e)
        {
        var keynum = window.event ? window.event.keyCode : e.which;
        if ((keynum == 8) || (keynum == 46))
        return true;
         
        return /\d/.test(String.fromCharCode(keynum));
        }

var hoy=new Date();

function isDate(txtDate)
{
  var currVal = txtDate;
  if(currVal == '')
    return false;
  
  //Declare Regex  
  var rxDatePattern = /^(\d{1,2})(\/|-)(\d{1,2})(\/|-)(\d{4})$/; 
  var dtArray = currVal.match(rxDatePattern); // is format OK?

  if (dtArray == null)
     return false;
 
  //Checks for mm/dd/yyyy format.
  dtMonth = dtArray[3];
  dtDay= dtArray[1];
  dtYear = dtArray[5];

  var ftx = new Date(dtYear,dtMonth-1,dtDay-1);

  var days = (hoy - ftx) / 1000 / 60 / 60 / 24;

  if(days<1) return false;
  
  
  if (dtMonth < 1 || dtMonth > 12)
      return false;
  else if (dtDay < 1 || dtDay> 31)
      return false;
  else if ((dtMonth==4 || dtMonth==6 || dtMonth==9 || dtMonth==11) && dtDay ==31)
      return false;
  else if (dtMonth == 2)
  {
     var isleap = (dtYear % 4 == 0 && (dtYear % 100 != 0 || dtYear % 400 == 0));
     if (dtDay> 29 || (dtDay ==29 && !isleap))
          return false;
  }
  return true;
}
</script>
</head>

<body>
<div id="cargando" 
    style="cursor:pointer;
    background-image: url(<?php echo base_url()?>public/images/cargando.gif);
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
<div id="dialog-message" title="Mensaje Importante"></div>

<link href="public/images/favicon.ico" rel="shortcut icon" type="image/x-icon" />
<div class="header">
	<div class="logo"><img src="<?php echo base_url()?>public/images/logo.png" width="350" /></div>
	<div class="titulo"><p>Muerte Fetal y Neonatal</p></div>
</div>
<div class="container">
    <!--El div que orderna los demás divs-->
    <div class='clearbox'></div>

    <div style="text-align: right; position:absolute; margin-top: 1%; margin-left: 57%; color:#000;">
        <?php
            $login = $this->session->userdata("usuario");
			$login1 = $this->session->userdata("nombres");
			
            echo "<b>Usuario:</b> ".$login1." (".$login.")";
        ?>
    </div>

    <!--El div que contiene el menú-->
    <div class="sidebar">
        <?php
            include_once("public/menu/mnp_menu.php");
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