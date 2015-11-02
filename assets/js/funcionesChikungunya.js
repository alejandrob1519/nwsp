$(document).ready(function(){
	$('#departamento').change(function () {
		var url = window.location.protocol + "//" + window.location.host;
		$.getJSON(url+'/notiWeb/index.php/modulos/llenaProvincias', {departamento:$('#departamento').val()}, function (data) {
			$('#provincia').empty();
			$.each(data, function (id, desc) {
				option = $('<option></option>', {
					value : id,
					text : desc
				});
				$('#provincia').append(option);
			});
			var sort = $('#provincia option');
			sort.sort(function (a, b) {
				 if (a.text > b.text) { return 1; } else if (a.text < b.text) { return -1; } else { return 0 }
			});
			$('#provincia').empty().append(sort);
			$('#provincia').prepend('<option value="" disabled>Seleccione ...</option>');
			$('#provincia').val('');
		});
/*		var departamento = $('#departamento').val();
		$('#departamento option').removeAttr('selected');
		$('#departamento option[value='+departamento+']').attr('selected', '');*/
		$('#provincia').empty().append('<option value="">Seleccione ...</option>');
		$('#distrito').empty().append('<option value="">Seleccione ...</option>');
	});
	
	$('#provincia').change(function () {
		var url = window.location.protocol + "//" + window.location.host;
		$.getJSON(url+'/notiWeb/index.php/modulos/llenaDistritos', { provincia:$('#provincia').val()},function (data) {
			$('#distrito').empty();
			$.each(data, function (id, desc) {
				option = $('<option></option>', {
					value : id,
					text : desc
				});
				$('#distrito').append(option);
			});
			var sort = $('#distrito option');
			sort.sort(function (a, b) {
				 if (a.text > b.text) { return 1; } else if (a.text < b.text) { return -1; } else { return 0 }
			});
			$('#distrito').empty().append(sort);
			$('#distrito').prepend('<option value="" disabled>Seleccione ...</option>');
			$('#distrito').val('');
		});
		var provincia = $('#provincia').val();
		/*$('#departamento option').removeAttr('selected');*/
		$('#provincia option[value='+provincia+']').attr('selected', '');
		$('#distrito').empty().append('<option value="">Seleccione ...</option>');
		$('#localidad').empty().append('<option value="">Seleccione ...</option>');
	});

	$('#departamento14_1').change(function () {
		var url = window.location.protocol + "//" + window.location.host;
		$.getJSON(url+'/notiWeb/index.php/modulos/llenaProvincias', {departamento:$('#departamento14_1').val()}, function (data) {
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
		var departamento = $('#departamento14_1').val();
		/*$('#departamento option').removeAttr('selected');*/
		$('#departamento14_1 option[value='+departamento+']').attr('selected', '');
		$('#provincia14_1').empty().append('<option value="">Seleccione ...</option>');
		$('#distrito14_1').empty().append('<option value="">Seleccione ...</option>');
	});
	
	$('#provincia14_1').change(function () {
		var url = window.location.protocol + "//" + window.location.host;
		$.getJSON(url+'/notiWeb/index.php/modulos/llenaDistritos', { provincia:$('#provincia14_1').val()},function (data) {
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
		var provincia = $('#provincia14_1').val();
		/*$('#departamento option').removeAttr('selected');*/
		$('#provincia14_1 option[value='+provincia+']').attr('selected', '');
		$('#distrito14_1').empty().append('<option value="">Seleccione ...</option>');
	});

	$("#fecha_nac").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1920:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fecha_mue").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1920:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fecha_cult").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1920:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fecha_resul").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1920:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fecha_ser1").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1920:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fecha_res1").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1920:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fecha_ser2").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1920:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fecha_res2").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1920:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fecha_pcr").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1920:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fecha_res3").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1920:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fecha_hos").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1920:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fecha_def").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1920:2025",
		dateFormat: "dd-mm-yy"
	});

	$(".borrar-icon").click( function(e) {
		e.preventDefault();
	  	var url = this.href;
		var accion = confirm('Estas seguro que deseas eliminar el registro?');
		if(accion == true){
			location.href = url;
		}
	});
		
	setTimeout(function(){ $(".errores").fadeOut(800).fadeIn(800).fadeOut(500).fadeIn(500).fadeOut(300);}, 5000); 
	setTimeout(function(){ $(".exito").fadeOut(800).fadeIn(800).fadeOut(500).fadeIn(500).fadeOut(300);}, 5000); 
	setTimeout(function(){ $(".info").fadeOut(800).fadeIn(800).fadeOut(500).fadeIn(500).fadeOut(300);}, 5000); 
});

function cambia(){
	form1.nueva.value=document.form1.clave.value;
}

var nav4 = window.Event ? true : false;
function acceptNum(evt){
	// NOTE: Backspace = 8, Enter = 13, '0' = 48, '9' = 57
	var key = nav4 ? evt.which : evt.keyCode;
	return (key <= 13 || (key >= 45 && key <= 57));
}
