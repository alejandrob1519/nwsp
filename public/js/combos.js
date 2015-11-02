$(document).ready(function() {
	$('#diresa').change(function () {
		var url = window.location.protocol + "//" + window.location.host;
		$.getJSON(url+'/notiWeb/index.php/individual/llenaRedes', {diresa:$('#diresa').val()}, function (data) {
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
		$.getJSON(url+'/notiWeb/index.php/individual/llenaMicroredes', {diresa:$('#diresa').val(), redes:$('#redes').val()}, function (data) {
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
		$.getJSON(url+'/notiWeb/index.php/individual/llenaEstablec', {diresa:$('#diresa').val(), redes:$('#redes').val(), microred:$('#microred').val()}, function (data) {
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

	$('#departamento').change(function () {
		var url = window.location.protocol + "//" + window.location.host;
		$.getJSON(url+'/notiWeb/index.php/individual/llenaProvincias', {departamento:$('#departamento').val()}, function (data) {
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
		var departamento = $('#departamento').val();
		/*$('#departamento option').removeAttr('selected');*/
		$('#departamento option[value='+departamento+']').attr('selected', '');
		$('#provincia').empty().append('<option value="">Seleccione ...</option>');
		$('#distrito').empty().append('<option value="">Seleccione ...</option>');
	});
	
	$('#provincia').change(function () {
		var url = window.location.protocol + "//" + window.location.host;
		$.getJSON(url+'/notiWeb/index.php/individual/llenaDistritos', { provincia:$('#provincia').val()},function (data) {
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

	$('#distrito').change(function () {
		var url = window.location.protocol + "//" + window.location.host;
		$.getJSON(url+'/notiWeb/index.php/individual/llenaLocalidad', { distrito:$('#distrito').val()},function (data) {
			$('#localidad').empty();
			$.each(data, function (id, desc) {
				option = $('<option></option>', {
					value : id,
					text : desc
				});
				$('#localidad').append(option);
			});
			var sort = $('#localidad option');
			sort.sort(function (a, b) {
				 if (a.text > b.text) { return 1; } else if (a.text < b.text) { return -1; } else { return 0 }
			});
			$('#localidad').empty().append(sort);
			$('#localidad').prepend('<option value="" disabled>Seleccione ...</option>');
			$('#localidad').val('');
		});
		var distrito = $('#distrito').val();
		/*$('#departamento option').removeAttr('selected');*/
		$('#distrito option[value='+distrito+']').attr('selected', '');
		$('#localidad').empty().append('<option value="">Seleccione ...</option>');
	});

	$('#pais14_1').change(function () {
		if($('#pais14_1').val() != '171'){
			$('#departamento14_1').attr('disabled','disabled');
			$('#provincia14_1').attr('disabled','disabled');
			$('#distrito14_1').attr('disabled','disabled');
		}else{
			$('#departamento14_1').removeAttr('disabled');
			$('#provincia14_1').removeAttr('disabled');
			$('#distrito14_1').removeAttr('disabled');
		}
	});

	$('#departamento14_1').change(function () {
		var url = window.location.protocol + "//" + window.location.host;
		$.getJSON(url+'/notiWeb/index.php/individual/llenaProvincias', {departamento:$('#departamento14_1').val()}, function (data) {
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
		$.getJSON(url+'/notiWeb/index.php/individual/llenaDistritos', { provincia:$('#provincia14_1').val()},function (data) {
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
		var provincia14_1 = $('#provincia14_1').val();
		/*$('#departamento option').removeAttr('selected');*/
		$('#provincia14_1 option[value='+provincia14_1+']').attr('selected', '');
		$('#distrito14_1').empty().append('<option value="">Seleccione ...</option>');
		$('#localidad14_1').empty().append('<option value="">Seleccione ...</option>');
	});

	$('#pais14_2').change(function () {
		if($('#pais14_2').val() != '171'){
			$('#departamento14_2').attr('disabled','disabled');
			$('#provincia14_2').attr('disabled','disabled');
			$('#distrito14_2').attr('disabled','disabled');
		}else{
			$('#departamento14_2').removeAttr('disabled');
			$('#provincia14_2').removeAttr('disabled');
			$('#distrito14_2').removeAttr('disabled');
		}
	});

	$('#departamento14_2').change(function () {
		var url = window.location.protocol + "//" + window.location.host;
		$.getJSON(url+'/notiWeb/index.php/individual/llenaProvincias', {departamento:$('#departamento14_2').val()}, function (data) {
			$('#provincia14_2').empty();
			$.each(data, function (id, desc) {
				option = $('<option></option>', {
					value : id,
					text : desc
				});
				$('#provincia14_2').append(option);
			});
			var sort = $('#provincia14_2 option');
			sort.sort(function (a, b) {
				 if (a.text > b.text) { return 1; } else if (a.text < b.text) { return -1; } else { return 0 }
			});
			$('#provincia14_2').empty().append(sort);
			$('#provincia14_2').prepend('<option value="" disabled>Seleccione ...</option>');
			$('#provincia14_2').val('');
		});
		var departamento14_2 = $('#departamento14_2').val();
		/*$('#departamento option').removeAttr('selected');*/
		$('#departamento14_2 option[value='+departamento14_2+']').attr('selected', '');
		$('#provincia14_2').empty().append('<option value="">Seleccione ...</option>');
		$('#distrito14_2').empty().append('<option value="">Seleccione ...</option>');
	});
	
	$('#provincia14_2').change(function () {
		var url = window.location.protocol + "//" + window.location.host;
		$.getJSON(url+'/notiWeb/index.php/individual/llenaDistritos', { provincia:$('#provincia14_2').val()},function (data) {
			$('#distrito14_2').empty();
			$.each(data, function (id, desc) {
				option = $('<option></option>', {
					value : id,
					text : desc
				});
				$('#distrito14_2').append(option);
			});
			var sort = $('#distrito14_2 option');
			sort.sort(function (a, b) {
				 if (a.text > b.text) { return 1; } else if (a.text < b.text) { return -1; } else { return 0 }
			});
			$('#distrito14_2').empty().append(sort);
			$('#distrito14_2').prepend('<option value="" disabled>Seleccione ...</option>');
			$('#distrito14_2').val('');
		});
		var provincia14_2 = $('#provincia14_2').val();
		/*$('#departamento option').removeAttr('selected');*/
		$('#provincia14_2 option[value='+provincia14_2+']').attr('selected', '');
		$('#distrito14_2').empty().append('<option value="">Seleccione ...</option>');
		$('#localidad14_2').empty().append('<option value="">Seleccione ...</option>');
	});

	$('#etnias').change(function () {
		var url = window.location.protocol + "//" + window.location.host;
		$.getJSON(url+'/notiWeb/index.php/individual/llenaSubetnias', { etnias:$('#etnias').val()},function (data) {
			$('#subetnias').empty();
			$.each(data, function (id, desc) {
				option = $('<option></option>', {
					value : id,
					text : desc
				});
				$('#subetnias').append(option);
			});
			var sort = $('#subetnias option');
			sort.sort(function (a, b) {
				 if (a.text > b.text) { return 1; } else if (a.text < b.text) { return -1; } else { return 0 }
			});
			$('#subetnias').empty().append(sort);
			$('#subetnias').prepend('<option value="" disabled>Seleccione ...</option>');
			$('#subetnias').val('');
		});

		var etnias = $('#etnias').val();

		if($('#etnias').val() == '6'){
			$('#subetnias').attr('disabled','disabled');
			$('#otro').removeAttr('disabled');
		}else{
			$('#subetnias').removeAttr('disabled');
			$('#otro').attr('disabled','disabled');
		}
		/*$('#departamento option').removeAttr('selected');*/
		$('#etnias option[value='+etnias+']').attr('selected', '');
		$('#subetnias').empty().append('<option value="">Seleccione ...</option>');
		$('#subetnias').val('');

	});

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

	$("#fecha_not").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1950:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fecha_inv").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1950:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fecha_def").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
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
		maxDate: "+0D",
		yearRange: "1950:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fecha_hos").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1950:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fecha_ate").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1950:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fecha_cult").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1950:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fecha_resul").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1950:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fecha_loc").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1950:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fecha_est").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1950:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fecha_dir").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1950:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fecha_nac").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1950:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fecha_int").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1950:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fecha_con").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1950:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fecha_sin").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1950:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fecha_ant").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1950:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fecha_mue").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1950:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fecha_env").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1950:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fecha_rec").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1950:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fecha_ocu").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1950:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fecha_alt").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1950:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fecha_inv1").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1950:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fecha_inv2").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1950:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fecha_rep").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1950:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fecha_con1").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1950:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fecha_ntrep1").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1950:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fecha_ntrep2").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1950:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fecha_trep1").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1950:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fecha_trep2").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1950:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fecha_par").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1950:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fecha_fac").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1950:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fecha_test").datepicker({ 
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1950:2025",
		dateFormat: "dd-mm-yy"
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
});