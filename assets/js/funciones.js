$(document).ready(function(){
	$('#diresa').change(function () {
		var url = window.location.protocol + "//" + window.location.host;
		$.getJSON(url+'/vih-sida/index.php/fichas/llenaRedes', {diresa:$('#diresa').val()}, function (data) {
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
		$('#diresa option[value='+diresa+']').attr('selected', '');
		$('#redes').empty().append('<option value="">Seleccione ...</option>');
		$('#microred').empty().append('<option value="">Seleccione ...</option>');
		$('#establec').empty().append('<option value="">Seleccione ...</option>');
	});
	
	$('#redes').change(function () {
		var url = window.location.protocol + "//" + window.location.host;
		$.getJSON(url+'/vih-sida/index.php/fichas/llenaMicroredes', {diresa:$('#diresa').val(), redes:$('#redes').val()}, function (data) {
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
		$.getJSON(url+'/vih-sida/index.php/fichas/llenaEstablec', {diresa:$('#diresa').val(), redes:$('#redes').val(), microred:$('#microred').val()}, function (data) {
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

	$('#establec').change(function () {
		var url = window.location.protocol + "//" + window.location.host;
		$.getJSON(url+'/vih-sida/index.php/sifilisMaterna/buscaCategoria', {eess:$('#establec').val()}, function (data) {
			$('#nivel_estab').val(data);
		});
	});

	$('#diresa1').change(function () {
		var url = window.location.protocol + "//" + window.location.host;
		$.getJSON(url+'/vih-sida/index.php/fichas/llenaRedes', {diresa:$('#diresa1').val()}, function (data) {
			$('#redes1').empty();
			$.each(data, function (id, desc) {
				option = $('<option></option>', {
					value : id,
					text : desc
				});
				$('#redes1').append(option);
			});
			var sort = $('#redes1 option');
			sort.sort(function (a, b) {
				 if (a.text > b.text) { return 1; } else if (a.text < b.text) { return -1; } else { return 0 }
			});
			$('#redes1').empty().append(sort);
			$('#redes1').prepend('<option value="" disabled>Seleccione ...</option>');
			$('#redes1').val('');
		});
/*		var diresa1 = $('#diresa1').val();
		$('#departamento option').removeAttr('selected');
		$('#diresa1 option[value='+diresa1+']').attr('selected', '');
*/		$('#redes1').empty().append('<option value="">Seleccione ...</option>');
		$('#microred1').empty().append('<option value="">Seleccione ...</option>');
		$('#establec1').empty().append('<option value="">Seleccione ...</option>');
	});
	
	$('#redes1').change(function () {
		var url = window.location.protocol + "//" + window.location.host;
		$.getJSON(url+'/vih-sida/index.php/fichas/llenaMicroredes', {diresa:$('#diresa1').val(), redes:$('#redes1').val()}, function (data) {
			$('#microred1').empty();
			$.each(data, function (id, desc) {
				option = $('<option></option>', {
					value : id,
					text : desc
				});
				$('#microred1').append(option);
			});
			var sort = $('#microred1 option');
			sort.sort(function (a, b) {
				 if (a.text > b.text) { return 1; } else if (a.text < b.text) { return -1; } else { return 0 }
			});
			$('#microred1').empty().append(sort);
			$('#microred1').prepend('<option value="">Seleccione ...</option>');
			$('#microred1').val('');
		});
		$('#establec1').empty().append('<option value="">Seleccione ...</option>');
	});

	$('#microred1').change(function () {
		var url = window.location.protocol + "//" + window.location.host;
		$.getJSON(url+'/vih-sida/index.php/fichas/llenaEstablec', {diresa:$('#diresa1').val(), redes:$('#redes1').val(), microred:$('#microred1').val()}, function (data) {
			$('#establec1').empty();
			$.each(data, function (id, desc) {
				option = $('<option></option>', {
					value : id,
					text : desc
				});
				$('#establec1').append(option);
			});
			var sort = $('#establec1 option');
			sort.sort(function (a, b) {
				 if (a.text > b.text) { return 1; } else if (a.text < b.text) { return -1; } else { return 0 }
			});
			$('#establec1').empty().append(sort);
			$('#establec1').prepend('<option value="">Seleccione ...</option>');
			$('#establec1').val('');
		});
	});

	$('#departamento').change(function () {
		var url = window.location.protocol + "//" + window.location.host;
		$.getJSON(url+'/vih-sida/index.php/fichas/llenaProvincias', {departamento:$('#departamento').val()}, function (data) {
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
		$.getJSON(url+'/vih-sida/index.php/fichas/llenaDistritos', { provincia:$('#provincia').val()},function (data) {
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

	$('#departamento_vih').change(function () {
		var url = window.location.protocol + "//" + window.location.host;
		$.getJSON(url+'/vih-sida/index.php/fichas/llenaProvincias', {departamento:$('#departamento_vih').val()}, function (data) {
			$('#provincia_vih').empty();
			$.each(data, function (id, desc) {
				option = $('<option></option>', {
					value : id,
					text : desc
				});
				$('#provincia_vih').append(option);
			});
			var sort = $('#provincia_vih option');
			sort.sort(function (a, b) {
				 if (a.text > b.text) { return 1; } else if (a.text < b.text) { return -1; } else { return 0 }
			});
			$('#provincia_vih').empty().append(sort);
			$('#provincia_vih').prepend('<option value="" disabled>Seleccione ...</option>');
			$('#provincia_vih').val('');
		});
		var departamento = $('#departamento_vih').val();
		/*$('#departamento option').removeAttr('selected');*/
		$('#departamento_vih option[value='+departamento+']').attr('selected', '');
		$('#provincia_vih').empty().append('<option value="">Seleccione ...</option>');
		$('#distrito_vih').empty().append('<option value="">Seleccione ...</option>');
	});
	
	$('#provincia_vih').change(function () {
		var url = window.location.protocol + "//" + window.location.host;
		$.getJSON(url+'/vih-sida/index.php/fichas/llenaDistritos', { provincia:$('#provincia_vih').val()},function (data) {
			$('#distrito_vih').empty();
			$.each(data, function (id, desc) {
				option = $('<option></option>', {
					value : id,
					text : desc
				});
				$('#distrito_vih').append(option);
			});
			var sort = $('#distrito_vih option');
			sort.sort(function (a, b) {
				 if (a.text > b.text) { return 1; } else if (a.text < b.text) { return -1; } else { return 0 }
			});
			$('#distrito_vih').empty().append(sort);
			$('#distrito_vih').prepend('<option value="" disabled>Seleccione ...</option>');
			$('#distrito_vih').val('');
		});
		var provincia = $('#provincia_vih').val();
		/*$('#departamento option').removeAttr('selected');*/
		$('#provincia_vih option[value='+provincia+']').attr('selected', '');
		$('#distrito_vih').empty().append('<option value="">Seleccione ...</option>');
	});

	$('#departamento_aid').change(function () {
		var url = window.location.protocol + "//" + window.location.host;
		$.getJSON(url+'/vih-sida/index.php/fichas/llenaProvincias', {departamento:$('#departamento_aid').val()}, function (data) {
			$('#provincia_aid').empty();
			$.each(data, function (id, desc) {
				option = $('<option></option>', {
					value : id,
					text : desc
				});
				$('#provincia_aid').append(option);
			});
			var sort = $('#provincia_aid option');
			sort.sort(function (a, b) {
				 if (a.text > b.text) { return 1; } else if (a.text < b.text) { return -1; } else { return 0 }
			});
			$('#provincia_aid').empty().append(sort);
			$('#provincia_aid').prepend('<option value="" disabled>Seleccione ...</option>');
			$('#provincia_aid').val('');
		});
		var departamento = $('#departamento_aid').val();
		/*$('#departamento option').removeAttr('selected');*/
		$('#departamento_aid option[value='+departamento+']').attr('selected', '');
		$('#provincia_aid').empty().append('<option value="">Seleccione ...</option>');
		$('#distrito_aid').empty().append('<option value="">Seleccione ...</option>');
	});
	
	$('#provincia_aid').change(function () {
		var url = window.location.protocol + "//" + window.location.host;
		$.getJSON(url+'/vih-sida/index.php/fichas/llenaDistritos', { provincia:$('#provincia_aid').val()},function (data) {
			$('#distrito_aid').empty();
			$.each(data, function (id, desc) {
				option = $('<option></option>', {
					value : id,
					text : desc
				});
				$('#distrito_aid').append(option);
			});
			var sort = $('#distrito_aid option');
			sort.sort(function (a, b) {
				 if (a.text > b.text) { return 1; } else if (a.text < b.text) { return -1; } else { return 0 }
			});
			$('#distrito_aid').empty().append(sort);
			$('#distrito_aid').prepend('<option value="" disabled>Seleccione ...</option>');
			$('#distrito_aid').val('');
		});
		var provincia = $('#provincia_aid').val();
		/*$('#departamento option').removeAttr('selected');*/
		$('#provincia_aid option[value='+provincia+']').attr('selected', '');
		$('#distrito_aid').empty().append('<option value="">Seleccione ...</option>');
	});

	$('#departamento_def').change(function () {
		var url = window.location.protocol + "//" + window.location.host;
		$.getJSON(url+'/vih-sida/index.php/fichas/llenaProvincias', {departamento:$('#departamento_def').val()}, function (data) {
			$('#provincia_def').empty();
			$.each(data, function (id, desc) {
				option = $('<option></option>', {
					value : id,
					text : desc
				});
				$('#provincia_def').append(option);
			});
			var sort = $('#provincia_def option');
			sort.sort(function (a, b) {
				 if (a.text > b.text) { return 1; } else if (a.text < b.text) { return -1; } else { return 0 }
			});
			$('#provincia_def').empty().append(sort);
			$('#provincia_def').prepend('<option value="" disabled>Seleccione ...</option>');
			$('#provincia_def').val('');
		});
		var departamento = $('#departamento_def').val();
		/*$('#departamento option').removeAttr('selected');*/
		$('#departamento_def option[value='+departamento+']').attr('selected', '');
		$('#provincia_def').empty().append('<option value="">Seleccione ...</option>');
		$('#distrito_def').empty().append('<option value="">Seleccione ...</option>');
	});
	
	$('#provincia_def').change(function () {
		var url = window.location.protocol + "//" + window.location.host;
		$.getJSON(url+'/vih-sida/index.php/fichas/llenaDistritos', { provincia:$('#provincia_def').val()},function (data) {
			$('#distrito_def').empty();
			$.each(data, function (id, desc) {
				option = $('<option></option>', {
					value : id,
					text : desc
				});
				$('#distrito_def').append(option);
			});
			var sort = $('#distrito_def option');
			sort.sort(function (a, b) {
				 if (a.text > b.text) { return 1; } else if (a.text < b.text) { return -1; } else { return 0 }
			});
			$('#distrito_def').empty().append(sort);
			$('#distrito_def').prepend('<option value="" disabled>Seleccione ...</option>');
			$('#distrito_def').val('');
		});
		var provincia = $('#provincia_def').val();
		/*$('#departamento option').removeAttr('selected');*/
		$('#provincia_def option[value='+provincia+']').attr('selected', '');
		$('#distrito_def').empty().append('<option value="">Seleccione ...</option>');
	});

	$("#fecha_not").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1920:2025",
		dateFormat: "dd-mm-yy"
	});
	
	$("#fecha_ini").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1920:2025",
		dateFormat: "dd-mm-yy"
	});
	
	$("#fecha_con1").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1920:2025",
		dateFormat: "dd-mm-yy"
	});
	
	$("#fecha_ntrep1").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1920:2025",
		dateFormat: "dd-mm-yy"
	});
	
	$("#fecha_ntrep2").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1920:2025",
		dateFormat: "dd-mm-yy"
	});
	
	$("#fecha_trep1").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1920:2025",
		dateFormat: "dd-mm-yy"
	});
	
	$("#fecha_trep2").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1920:2025",
		dateFormat: "dd-mm-yy"
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

	$("#fecha_par").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1920:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fecha_fac").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1920:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fecha_test").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1920:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fecha_exp_tam").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1920:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fecha_exp_conf").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1920:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fecha_tar").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1920:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fecha_tbc").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1920:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fecha_motivo1").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1920:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fecha_motivo2").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1920:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fecha_motivo3").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1920:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fecha_motivo4").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1920:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fecha_motivo5").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1920:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fecha_motivo6").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1920:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fecha_motivo7").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1920:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fecha_motivo8").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1920:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fecha_tam1").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1920:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fecha_tam2").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1920:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#prueba_conf").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1920:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fur").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1920:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fecha_avr").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1920:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fecha_arv").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1920:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fecha_par").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1920:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fecha_pcr1").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1920:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fecha_pcr2").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1920:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fecha_eli").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1920:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#desde").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1920:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#hasta").datepicker({ 
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

function codigoEnfermedad1(){
	var a = document.form1.indicadora1.value;
	form1.ciex1.value = a;
}

function codigoEnfermedad2(){
	var a = document.form1.indicadora2.value;
	form1.ciex2.value = a;
}

var nav4 = window.Event ? true : false;
function acceptNum(evt){
	// NOTE: Backspace = 8, Enter = 13, '0' = 48, '9' = 57
	var key = nav4 ? evt.which : evt.keyCode;
	return (key <= 13 || (key >= 45 && key <= 57));
}

function tipoEstab(){
	var codigo = document.form1.establec.value;
	
	var a = codigo.substr(7,1);

	switch(a){
		case '1':
		form1.tipo.value = "Hospital";
		break;
		case '2':
		form1.tipo.value = "Centro de Salud";
		break;
		case '3':
		form1.tipo.value = "Puesto de Salud";
		break;
		default:
		form1.tipo.value = "Otro";
		break;
	}
	
	var b = codigo.substr(6,1);

	switch(b){
		case 'A':
		form1.institucion.value = "Ministerio de Salud";
		break;
		case 'C':
		form1.institucion.value = "ESSALUD";
		break;
		case 'D':
		form1.institucion.value = "FFAA/PNP";
		break;
		case 'X':
		form1.institucion.value = "Otros";
		break;
	}
}

function activarCheckbox(source){
	if(document.getElementById('vih').checked == true){
		document.getElementById('avanzado').disabled = false;		
		document.getElementById('sida').disabled = false;		
		document.getElementById('gestante_vih').disabled = false;		
		document.getElementById('expuesto_vih').disabled = false;		
		document.getElementById('fallecido').disabled = false;		
		document.getElementById('targa').disabled = false;	
		document.getElementById('nino_vih').disabled = true;		
		document.getElementById('nino_vih').checked = false;
		document.getElementById('nino_expuesto_novih').disabled = true;		
		document.getElementById('nino_expuesto_novih').checked = false;
	}else{
		document.getElementById('avanzado').checked = false;
		document.getElementById('avanzado').disabled = true;		
		document.getElementById('sida').checked = false;
		document.getElementById('sida').disabled = true;		
		document.getElementById('gestante_vih').checked = false;
		document.getElementById('gestante_vih').disabled = true;		
		document.getElementById('expuesto_vih').checked = false;
		document.getElementById('expuesto_vih').disabled = true;		
		document.getElementById('fallecido').checked = false;
		document.getElementById('fallecido').disabled = true;		
		document.getElementById('targa').checked = false;
		document.getElementById('targa').disabled = true;	
		document.getElementById('fecha_motivo1').value = "";	
		document.getElementById('fecha_motivo2').value = "";	
		document.getElementById('fecha_motivo3').value = "";	
		document.getElementById('fecha_motivo4').value = "";	
		document.getElementById('fecha_motivo5').value = "";	
		document.getElementById('fecha_motivo6').value = "";	
		document.getElementById('fecha_motivo7').value = "";	
		document.getElementById('fecha_motivo8').value = "";	
		document.getElementById('fecha_motivo1').disabled = true;		
		document.getElementById('fecha_motivo2').disabled = true;		
		document.getElementById('fecha_motivo3').disabled = true;		
		document.getElementById('fecha_motivo4').disabled = true;		
		document.getElementById('fecha_motivo5').disabled = true;		
		document.getElementById('fecha_motivo6').disabled = true;		
		document.getElementById('fecha_motivo7').disabled = true;		
		document.getElementById('fecha_motivo8').disabled = true;		
		document.getElementById('nino_vih').disabled = false;		
		document.getElementById('nino_vih').checked = false;
		document.getElementById('nino_expuesto_novih').disabled = false;		
		document.getElementById('nino_expuesto_novih').checked = false;
	}	
}

function activarSexual(){
	if(document.getElementById('sexual').checked == true){
		document.getElementById("tipo_sexual").disabled =false;
		document.getElementById('parenteral').checked = false;
		document.getElementById('parenteral').disabled = true;		
		document.getElementById('vertical').checked = false;
		document.getElementById('vertical').disabled = true;		
		document.getElementById('via_desconocida').checked = false;
		document.getElementById('via_desconocida').disabled = true;		
	}else{
		document.getElementById("tipo_sexual").disabled =true;	
		document.getElementById('parenteral').checked = false;
		document.getElementById('parenteral').disabled = false;		
		document.getElementById('vertical').checked = false;
		document.getElementById('vertical').disabled = false;		
		document.getElementById('via_desconocida').checked = false;
		document.getElementById('via_desconocida').disabled = false;		
	}	
}

function activarParenteral(){
	if(document.getElementById('parenteral').checked == true){
		document.getElementById("tipo_parenteral").disabled =false;
		document.getElementById('sexual').checked = false;
		document.getElementById('sexual').disabled = true;		
		document.getElementById('vertical').checked = false;
		document.getElementById('vertical').disabled = true;		
		document.getElementById('via_desconocida').checked = false;
		document.getElementById('via_desconocida').disabled = true;		
	}else{
		document.getElementById("tipo_parenteral").disabled =true;	
		document.getElementById('sexual').checked = false;
		document.getElementById('sexual').disabled = false;		
		document.getElementById('vertical').checked = false;
		document.getElementById('vertical').disabled = false;		
		document.getElementById('via_desconocida').checked = false;
		document.getElementById('via_desconocida').disabled = false;		
	}	
}

function activarVertical(){
	if(document.getElementById('vertical').checked == true){
		document.getElementById('sexual').checked = false;
		document.getElementById('sexual').disabled = true;		
		document.getElementById('parenteral').checked = false;
		document.getElementById('parenteral').disabled = true;		
		document.getElementById('via_desconocida').checked = false;
		document.getElementById('via_desconocida').disabled = true;		
	}else{
		document.getElementById('sexual').checked = false;
		document.getElementById('sexual').disabled = false;		
		document.getElementById('parenteral').checked = false;
		document.getElementById('parenteral').disabled = false;		
		document.getElementById('via_desconocida').checked = false;
		document.getElementById('via_desconocida').disabled = false;		
	}	
}

function activarDesconocida(){
	if(document.getElementById('via_desconocida').checked == true){
		document.getElementById('sexual').checked = false;
		document.getElementById('sexual').disabled = true;		
		document.getElementById('parenteral').checked = false;
		document.getElementById('parenteral').disabled = true;		
		document.getElementById('vertical').checked = false;
		document.getElementById('vertical').disabled = true;		
	}else{
		document.getElementById('sexual').checked = false;
		document.getElementById('sexual').disabled = false;		
		document.getElementById('parenteral').checked = false;
		document.getElementById('parenteral').disabled = false;		
		document.getElementById('vertical').checked = false;
		document.getElementById('vertical').disabled = false;		
	}	
}

function contarMeses(){
	var fecha = new Date();
	var ano = fecha.getFullYear();
	var mes = fecha.getMonth();
	var a = new Array();
	
	if(document.getElementById('ano_tam1').value < ano && document.getElementById('ano_tam1').value != ""){
		
		$('#mes_tam1 option').remove();
		
		for(i=12;i>=1;i--){
			a[i] = i;
			$('#mes_tam1').append('<option value="'+i+'">'+i+'</option>');
		}
	
		$('#mes_tam1').val(a);
	}
	
	if(document.getElementById('ano_tam1').value == ano && document.getElementById('ano_tam1').value != ""){
		$('#mes_tam1 option').remove();
		
		for(i=mes+1;i>=1;i--){
			a[i] = i;
			$('#mes_tam1').append('<option value="'+i+'">'+i+'</option>');
		}
	
		$('#mes_tam1').val(a);
	}
}

function contarMeses1(){
	var fecha = new Date();
	var ano = fecha.getFullYear();
	var mes = fecha.getMonth();
	var a = new Array();
	
	if(document.getElementById('ano_tam2').value < ano && document.getElementById('ano_tam2').value != ""){
		
		$('#mes_tam2 option').remove();
		
		for(i=12;i>=1;i--){
			a[i] = i;
			$('#mes_tam2').append('<option value="'+i+'">'+i+'</option>');
		}
	
		$('#mes_tam2').val(a);
	}
	
	if(document.getElementById('ano_tam2').value == ano && document.getElementById('ano_tam2').value != ""){
		$('#mes_tam2 option').remove();
		
		for(i=mes+1;i>=1;i--){
			a[i] = i;
			$('#mes_tam2').append('<option value="'+i+'">'+i+'</option>');
		}
	
		$('#mes_tam2').val(a);
	}
}

function contarMeses2(){
	var fecha = new Date();
	var ano = fecha.getFullYear();
	var mes = fecha.getMonth();
	var a = new Array();

	if(document.getElementById('ano_conf1').value < ano && document.getElementById('ano_conf1').value != ""){
		
		$('#mes_conf1 option').remove();
		
		for(i=12;i>=1;i--){
			a[i] = i;
			$('#mes_conf1').append('<option value="'+i+'">'+i+'</option>');
		}
	
		$('#mes_conf1').val(a);
	}
	
	if(document.getElementById('ano_conf1').value == ano && document.getElementById('ano_conf1').value != ""){
		$('#mes_conf1 option').remove();
		
		for(i=mes+1;i>=1;i--){
			a[i] = i;
			$('#mes_conf1').append('<option value="'+i+'">'+i+'</option>');
		}
	
		$('#mes_conf1').val(a);
	}
}

function contarMeses3(){
	var fecha = new Date();
	var ano = fecha.getFullYear();
	var mes = fecha.getMonth();
	var a = new Array();

	if(document.getElementById('ano_conf2').value < ano && document.getElementById('ano_conf2').value != ""){
		
		$('#mes_conf2 option').remove();
		
		for(i=12;i>=1;i--){
			a[i] = i;
			$('#mes_conf2').append('<option value="'+i+'">'+i+'</option>');
		}
	
		$('#mes_conf2').val(a);
	}
	
	if(document.getElementById('ano_conf2').value == ano && document.getElementById('ano_conf2').value != ""){
		$('#mes_conf2 option').remove();
		
		for(i=mes+1;i>=1;i--){
			a[i] = i;
			$('#mes_conf2').append('<option value="'+i+'">'+i+'</option>');
		}
	
		$('#mes_conf2').val(a);
	}
}

function contarMeses4(){
	var fecha = new Date();
	var ano = fecha.getFullYear();
	var mes = fecha.getMonth();
	var a = new Array();

	if(document.getElementById('estadio_vih_ano').value < ano && document.getElementById('estadio_vih_ano').value != ""){
		
		$('#estadio_vih_mes option').remove();
		
		for(i=12;i>=1;i--){
			a[i] = i;
			$('#estadio_vih_mes').append('<option value="'+i+'">'+i+'</option>');
		}
	
		$('#estadio_vih_mes').val(a);
	}
	
	if(document.getElementById('estadio_vih_ano').value == ano && document.getElementById('estadio_vih_ano').value != ""){
		$('#estadio_vih_mes option').remove();
		
		for(i=mes+1;i>=1;i--){
			a[i] = i;
			$('#estadio_vih_mes').append('<option value="'+i+'">'+i+'</option>');
		}
	
		$('#estadio_vih_mes').val(a);
	}
}

function contarMeses5(){
	var fecha = new Date();
	var ano = fecha.getFullYear();
	var mes = fecha.getMonth();
	var a = new Array();

	if(document.getElementById('estadio_sida_ano').value < ano && document.getElementById('estadio_sida_ano').value != ""){
		
		$('#estadio_sida_mes option').remove();
		
		for(i=12;i>=1;i--){
			a[i] = i;
			$('#estadio_sida_mes').append('<option value="'+i+'">'+i+'</option>');
		}
	
		$('#estadio_sida_mes').val(a);
	}
	
	if(document.getElementById('estadio_sida_ano').value == ano && document.getElementById('estadio_sida_ano').value != ""){
		$('#estadio_sida_mes option').remove();
		
		for(i=mes+1;i>=1;i--){
			a[i] = i;
			$('#estadio_sida_mes').append('<option value="'+i+'">'+i+'</option>');
		}
	
		$('#estadio_sida_mes').val(a);
	}
}

function contarMeses6(){
	var fecha = new Date();
	var ano = fecha.getFullYear();
	var mes = fecha.getMonth();
	var a = new Array();

	if(document.getElementById('ano_def').value < ano && document.getElementById('ano_def').value != ""){
		
		$('#mes_def option').remove();
		
		for(i=12;i>=1;i--){
			a[i] = i;
			$('#mes_def').append('<option value="'+i+'">'+i+'</option>');
		}
	
		$('#mes_def').val(a);
	}
	
	if(document.getElementById('ano_def').value == ano && document.getElementById('ano_def').value != ""){
		$('#mes_def option').remove();
		
		for(i=mes+1;i>=1;i--){
			a[i] = i;
			$('#mes_def').append('<option value="'+i+'">'+i+'</option>');
		}
	
		$('#mes_def').val(a);
	}
}

function fechasMotivo(){
	if(document.getElementById('avanzado').checked == true){
		document.getElementById('fecha_motivo1').disabled = false;		
	}else{
		document.getElementById('fecha_motivo1').disabled = true;		
	}
	if(document.getElementById('sida').checked == true){
		document.getElementById('fecha_motivo2').disabled = false;		
	}else{
		document.getElementById('fecha_motivo2').disabled = true;		
	}
	if(document.getElementById('gestante_vih').checked == true){
		document.getElementById('fecha_motivo3').disabled = false;		
	}else{
		document.getElementById('fecha_motivo3').disabled = true;		
	}
	if(document.getElementById('expuesto_vih').checked == true){
		document.getElementById('fecha_motivo4').disabled = false;		
	}else{
		document.getElementById('fecha_motivo4').disabled = true;		
	}
	if(document.getElementById('fallecido').checked == true){
		document.getElementById('fecha_motivo5').disabled = false;		
	}else{
		document.getElementById('fecha_motivo5').disabled = true;		
	}
	if(document.getElementById('targa').checked == true){
		document.getElementById('fecha_motivo6').disabled = false;		
	}else{
		document.getElementById('fecha_motivo6').disabled = true;		
	}
	if(document.getElementById('nino_vih').checked == true){
		document.getElementById('fecha_motivo7').disabled = false;		
	}else{
		document.getElementById('fecha_motivo7').value = "";	
		document.getElementById('fecha_motivo7').disabled = true;		
	}
	if(document.getElementById('nino_expuesto_novih').checked == true){
		document.getElementById('fecha_motivo8').disabled = false;		
	}else{
		document.getElementById('fecha_motivo8').value = "";	
		document.getElementById('fecha_motivo8').disabled = true;		
	}
}

function activarGestacionPrevia(){
	if(document.getElementById('dx_previo_ges').checked == true){
		document.getElementById('ano_dx_previo').disabled = false;		
		document.getElementById('ano_dx_previo').value = "";	
		document.getElementById('dx_actual_ges').checked = false;
		document.getElementById('dx_actual_ges').disabled = true;		
		document.getElementById('apn').checked = false;
		document.getElementById('apn').disabled = true;		
		document.getElementById('parto').checked = false;
		document.getElementById('parto').disabled = true;		
		document.getElementById('fecha_tam1').value = "";	
		document.getElementById('fecha_tam1').disabled = true;		
		document.getElementById('puerperio').checked = false;
		document.getElementById('puerperio').disabled = true;		
		document.getElementById('fecha_tam2').value = "";	
		document.getElementById('fecha_tam2').disabled = true;		
		document.getElementById('posterior').checked = false;
		document.getElementById('posterior').disabled = true;		
		document.getElementById('prueba_conf').value = "";	
		document.getElementById('prueba_conf').disabled = true;		
		document.getElementById('aborto').checked = false;
		document.getElementById('aborto').disabled = true;		
	}else{
		document.getElementById('ano_dx_previo').disabled = true;		
		document.getElementById('ano_dx_previo').value = "";	
		document.getElementById('dx_actual_ges').checked = false;
		document.getElementById('dx_actual_ges').disabled = false;		
	}	
}

function activarGestacionActual(){
	if(document.getElementById('dx_actual_ges').checked == true){
		document.getElementById('dx_previo_ges').checked = false;
		document.getElementById('dx_previo_ges').disabled = true;		
		document.getElementById('ano_dx_previo').value = "";	
		document.getElementById('ano_dx_previo').disabled = true;		
		document.getElementById('apn').checked = false;
		document.getElementById('apn').disabled = false;		
		document.getElementById('parto').checked = false;
		document.getElementById('parto').disabled = false;		
		document.getElementById('puerperio').checked = false;
		document.getElementById('puerperio').disabled = false;		
		document.getElementById('posterior').checked = false;
		document.getElementById('posterior').disabled = false;		
		document.getElementById('aborto').checked = false;
		document.getElementById('aborto').disabled = false;		
	}else{
		document.getElementById('dx_previo_ges').checked = false;
		document.getElementById('dx_previo_ges').disabled = false;		
		document.getElementById('ano_dx_previo').value = "";	
		document.getElementById('ano_dx_previo').disabled = true;		
		document.getElementById('apn').checked = false;
		document.getElementById('apn').disabled = true;		
		document.getElementById('parto').checked = false;
		document.getElementById('parto').disabled = true;		
		document.getElementById('puerperio').checked = false;
		document.getElementById('puerperio').disabled = true;		
		document.getElementById('posterior').checked = false;
		document.getElementById('posterior').disabled = true;		
		document.getElementById('aborto').checked = false;
		document.getElementById('aborto').disabled = true;		
	}	
}

function activarParto(){
	if(document.getElementById('parto').checked == true){
		document.getElementById('fecha_tam1').value = "";	
		document.getElementById('fecha_tam1').disabled = false;		
	}else{
		document.getElementById('fecha_tam1').value = "";	
		document.getElementById('fecha_tam1').disabled = true;		
	}	
}

function activarPuerperio(){
	if(document.getElementById('puerperio').checked == true){
		document.getElementById('fecha_tam2').value = "";	
		document.getElementById('fecha_tam2').disabled = false;		
	}else{
		document.getElementById('fecha_tam2').value = "";	
		document.getElementById('fecha_tam2').disabled = true;		
	}	
}

function activarPosterior(){
	if(document.getElementById('posterior').checked == true){
		document.getElementById('prueba_conf').value = "";	
		document.getElementById('prueba_conf').disabled = false;		
	}else{
		document.getElementById('prueba_conf').value = "";	
		document.getElementById('prueba_conf').disabled = true;		
	}	
}

function nobackbutton(){
   window.location.hash="no-back-button";
   window.location.hash="Again-No-back-button" //chrome
   window.onhashchange=function(){window.location.hash="no-back-button";}
}

function nivelEstablecimiento(){
	x = document.getElementById('establec').value;
	y = x.substr(7,1);
	
	switch(y){
		case '1':
		document.getElementById('nivel_estab').value = "Hospital";
		break;
		case '2':
		document.getElementById('nivel_estab').value = "Centro de Salud";
		break;
		case '3':
		document.getElementById('nivel_estab').value = "Puesto de Salud";
		break;
	}
}

$(document).ready(function () {
							
	var validator = $("#form1").bootstrapValidator({
		excluded: [':disabled'],
		feedbackIcons : {
			valid 		: "glyphicon glyphicon-ok",
			invalid 	: "glyphicon glyphicon-remove",
			validating 	: "glyphicon glyphicon-refresh"
		},

		fields : {
			establec: {
                validators: {
                    notEmpty: {
                        message: 'establecimiento es requerido'
                    }
                }
            },

			fecha_not : {
				validators : {
					notEmpty 	: {
						message : "fecha es requerida"
					},

					date: {
                        message: 'fecha no puede ser superior a la fecha actual',
                        format: 'DD-MM-YYYY',
                        min: '01-01-1983',
                        max: 'diaHoy'

                    }
				}
			},

			iniciales: {
                validators: {
                    notEmpty: {
                        message: 'iniciales son requeridas'
                    }
                }
            },

			dni 		: {
				message   : "El nombre es requerido",
				validators: {
					notEmpty : {
						message : "DNI es requerido"
					},
					digits: {
                        message: 'Ingrese solo numeros'
                    },
					stringLength : {
						min 	: 8,
						message : "Minimo 8 caracteres"
					}
				}
			},

			fecha_nac : {
				validators : {
					notEmpty 	: {
						message : "fecha es requerida"
					},

					date: {
                        message: 'fecha no puede ser superior a la fecha actual',
                        format: 'DD-MM-YYYY',
                        min: '01-01-1920',
                        max: 'diaHoy'

                    }
				}
			},

			fecha_motivo1 : {
				validators : {
					date: {
                        message: 'fecha no puede ser superior a la fecha actual',
                        format: 'DD-MM-YYYY',
                        min: '01-01-1983',
                        max: 'diaHoy'

                    }
				}
			},

			fecha_motivo2 : {
				validators : {
					date: {
                        message: 'fecha no puede ser superior a la fecha actual',
                        format: 'DD-MM-YYYY',
                        min: '01-01-1983',
                        max: 'diaHoy'

                    }
				}
			},

			fecha_motivo3 : {
				validators : {
					date: {
                        message: 'fecha no puede ser superior a la fecha actual',
                        format: 'DD-MM-YYYY',
                        min: '01-01-1983',
                        max: 'diaHoy'

                    }
				}
			},

			fecha_motivo4 : {
				validators : {
					date: {
                        message: 'fecha no puede ser superior a la fecha actual',
                        format: 'DD-MM-YYYY',
                        min: '01-01-1983',
                        max: 'diaHoy'

                    }
				}
			},

			fecha_motivo5 : {
				validators : {
					date: {
                        message: 'fecha no puede ser superior a la fecha actual',
                        format: 'DD-MM-YYYY',
                        min: '01-01-1983',
                        max: 'diaHoy'

                    }
				}
			},

			fecha_motivo6 : {
				validators : {
					date: {
                        message: 'fecha no puede ser superior a la fecha actual',
                        format: 'DD-MM-YYYY',
                        min: '01-01-1983',
                        max: 'diaHoy'

                    }
				}
			},

			fecha_motivo7 : {
				validators : {
					date: {
                        message: 'fecha no puede ser superior a la fecha actual',
                        format: 'DD-MM-YYYY',
                        min: '01-01-1983',
                        max: 'diaHoy'

                    }
				}
			},

			fecha_motivo8 : {
				validators : {
					date: {
                        message: 'fecha no puede ser superior a la fecha actual',
                        format: 'DD-MM-YYYY',
                        min: '01-01-1983',
                        max: 'diaHoy'

                    }
				}
			},

			distrito : {
				message 	: "distrito es requerido",
                validators: {
                    notEmpty: {
                        message: 'distrito es requerido'
                    }
                }
			},

			estadio : {
				message 	: "estadio es requerido",
                validators: {
                    notEmpty: {
                        message: 'estadio es requerido'
                    }
                }
			},

			sexo 	: {
				message 	: "Sexo es requerido",
				validators : {
					notEmpty 	: {
						message : "Elegir sexo"
					}
				}
			}

		}
	});

});