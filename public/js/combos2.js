$(document).ready(function() {

    $("input").blur(function(){
             $(this).val($(this).val().toUpperCase());
    });

	$('#diresa').change(function () {
		var url = window.location.protocol + "//" + window.location.host;
		$.getJSON(url+'/notiWeb/index.php/modulosmnp/llenaRedes', {diresa:$('#diresa').val()}, function (data) {
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
		$.getJSON(url+'/notiWeb/index.php/modulosmnp/llenaMicroredes', {diresa:$('#diresa').val(), redes:$('#redes').val()}, function (data) {
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
		$('#establec').empty().append('<option value="">Seleccione ...</option>');
	});

	$('#microred').change(function () {
		var url = window.location.protocol + "//" + window.location.host;
		$.getJSON(url+'/notiWeb/index.php/modulosmnp/llenaEstablec', {diresa:$('#diresa').val(), redes:$('#redes').val(), microred:$('#microred').val()}, function (data) {
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

	$('#paises').change(function () {
		if($('#paises').val() != '171'){
			$('#departamento').attr('disabled','disabled');
			$('#provincia').attr('disabled','disabled');
			$('#distrito').attr('disabled','disabled');
			$('#localidad').attr('disabled','disabled');
		}else{
			$('#departamento').removeAttr('disabled');
			$('#provincia').removeAttr('disabled');
			$('#distrito').removeAttr('disabled');
			$('#localidad').removeAttr('disabled');
		}
	});

	$('#departamento14_1').change(function () {
		var url = window.location.protocol + "//" + window.location.host;
		$.getJSON(url+'/notiWeb/index.php/modulosmnp/llenaProvincias', {departamento:$('#departamento14_1').val()}, function (data) {
			$('#provincia14_1').empty();
			$.each(data, function (id, desc) {
				option = $('<option></option>', {
					value : id,
					text : desc
				});
				$('#provincia14_1').append(option);
			});
			var sort = $('#provincia14_1 option');
			sort.sort(function (a, b) {
				 if (a.text > b.text) { return 1; } else if (a.text < b.text) { return -1; } else { return 0 }
			});
			$('#provincia14_1').empty().append(sort);
			$('#provincia14_1').prepend('<option value="" disabled>Seleccione ...</option>');
			$('#provincia14_1').val('');
		});
		var departamento14_1 = $('#departamento14_1').val();
		/*$('#departamento option').removeAttr('selected');*/
		$('#departamento14_1 option[value='+departamento14_1+']').attr('selected', '');
		$('#provincia14_1').empty().append('<option value="">Seleccione ...</option>');
		$('#distrito14_1').empty().append('<option value="">Seleccione ...</option>');
	});
	
	$('#provincia14_1').change(function () {
		var url = window.location.protocol + "//" + window.location.host;
		$.getJSON(url+'/notiWeb/index.php/modulosmnp/llenaDistritos', { provincia:$('#provincia14_1').val()},function (data) {
			$('#distrito14_1').empty();
			$.each(data, function (id, desc) {
				option = $('<option></option>', {
					value : id,
					text : desc
				});
				$('#distrito14_1').append(option);
			});
			var sort = $('#distrito14_1 option');
			sort.sort(function (a, b) {
				 if (a.text > b.text) { return 1; } else if (a.text < b.text) { return -1; } else { return 0 }
			});
			$('#distrito14_1').empty().append(sort);
			$('#distrito14_1').prepend('<option value="" disabled>Seleccione ...</option>');
			$('#distrito14_1').val('');
		});
		//var provincia14_1 = $('#provincia14_1').val();
		/*$('#departamento option').removeAttr('selected');*/
		//$('#provincia14_1 option[value='+provincia14_1+']').attr('selected', '');
		//$('#distrito14_1').empty().append('<option value="">Seleccione ...</option>');
	});

	$("#fecha_not").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		yearRange: "1950:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fecha_inv").datepicker({ 
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
/*		showWeek: true,
		firstDay: 7,
		weekHeader: 'Sem',
*/		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
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

	$("#fecha_ate").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		yearRange: "1950:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fecha_cult").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		yearRange: "1950:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fecha_resul").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		yearRange: "1950:2025",
		dateFormat: "dd-mm-yy"
	});

	$('#nivel1').change(function () {
		if($('#nivel1').val() != '0'){
			$('#departamento').removeAttr('disabled');
			$('#provincia').removeAttr('disabled');
			$('#distrito').removeAttr('disabled');
			$('#diresa').attr('disabled','disabled');
			$('#redes').attr('disabled','disabled');
			$('#microred').attr('disabled','disabled');
			$('#establec').attr('disabled','disabled');
		}else{
			$('#departamento').attr('disabled','disabled');
			$('#provincia').attr('disabled','disabled');
			$('#distrito').attr('disabled','disabled');
			$('#diresa').removeAttr('disabled');
			$('#redes').removeAttr('disabled');
			$('#microred').removeAttr('disabled');
			$('#establec').removeAttr('disabled');
		}
	});

	$('#nivel2').change(function () {
		if($('#nivel1').val() != '0'){
			$('#departamento').attr('disabled','disabled');
			$('#provincia').attr('disabled','disabled');
			$('#distrito').attr('disabled','disabled');
			$('#diresa').removeAttr('disabled');
			$('#redes').removeAttr('disabled');
			$('#microred').removeAttr('disabled');
			$('#establec').removeAttr('disabled');
		}else{
			$('#departamento').removeAttr('disabled');
			$('#provincia').removeAttr('disabled');
			$('#distrito').removeAttr('disabled');
			$('#diresa').attr('disabled','disabled');
			$('#redes').attr('disabled','disabled');
			$('#microred').attr('disabled','disabled');
			$('#establec').attr('disabled','disabled');
		}
	});

	$('.borrar-icon').live('click', function(){
		 var url = $(this).attr('href');
		 var accion = confirm('Estas seguro que deseas eliminar el registro?');
		 if(accion == true){
		 	location.href = url;
			return true;
		 }else{
			 return false;
		 }
	});

	$("#botonImprimir").click(function (){
		$("div.content1").printArea();
	})
/*	setTimeout(function(){ $(".error").fadeOut(800).fadeIn(800).fadeOut(500).fadeIn(500).fadeOut(300);}, 5000); 
*/	setTimeout(function(){ $(".warning").fadeOut(800).fadeIn(800).fadeOut(500).fadeIn(500).fadeOut(300);}, 5000); 
/*	setTimeout(function(){ $(".exito").fadeOut(800).fadeIn(800).fadeOut(500).fadeIn(500).fadeOut(300);}, 5000); 
*/	setTimeout(function(){ $(".exitoFrontend").fadeOut(800).fadeIn(800).fadeOut(500).fadeIn(500).fadeOut(300);}, 5000); 
	setTimeout(function(){ $(".errorFrontend").fadeOut(800).fadeIn(800).fadeOut(500).fadeIn(500).fadeOut(300);}, 5000); 
	setTimeout(function(){ $(".infoFrontend").fadeOut(800).fadeIn(800).fadeOut(500).fadeIn(500).fadeOut(300);}, 5000); 
	
	
	/* precargado de nombre de hijo mnp */
	
	// Cuando pone el sexo actualisa Apellidos y Nombres
	$("#sexo").change(function(){
		nombrehijo();
	  if($("#sexo").val()=='I' && $("#tipo_mte").val()=='N'){	  
			$("#dialog-message").dialog({modal: true,width:500});
			$("#dialog-message").html("<h3>Un Potencial error que solo puede considerarse en caso de un RN malformado</h3>");		
	  }
	});

	$("#apepat").change(function(){
		nombrehijo();
	});
	
	$("#apemat").change(function(){
		nombrehijo();
	});
	
	$("#nombres").change(function(){
		nombrehijo();
	});
});

function nombrehijo()
{
	var apepat = $('#apepat').val();
	var apemat = $('#apemat').val();
	var nombre = $('#nombres').val();
	var total = '';
	total = apepat+' '+apemat+' '+nombre;
	$("#ape_nom").val(total);
}

