$(document).ready(function() {
	$('#departamento').change(function () {
		var url = 'http://apps.allintecperu.com/cipapurimac/mantenimiento/';
		$.getJSON(url+'obtenerProvincias', {departamento:$('#departamento').val()}, function (data) {
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
		var url = 'http://apps.allintecperu.com/cipapurimac/mantenimiento/';
		$.getJSON(url+'obtenerDistritos', {departamento:$('#departamento').val(), provincia:$('#provincia').val()}, function (data) {
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
			$('#distrito').prepend('<option value="">Seleccione ...</option>');
			$('#distrito').val('');
		});
		$('#localidad').empty().append('<option value="">Seleccione ...</option>');
	});

	$('#capitulo').change(function () {
		var url = 'http://apps.allintecperu.com/cipapurimac/mantenimiento/';
		$.getJSON(url+'obtenerEspecialidad', {capitulo:$('#capitulo').val()}, function (data) {
			$('#especialidad').empty();
			$.each(data, function (id, desc) {
				option = $('<option></option>', {
					value : id,
					text : desc
				});
				$('#especialidad').append(option);
			});
			var sort = $('#especialidad option');
			sort.sort(function (a, b) {
				 if (a.text > b.text) { return 1; } else if (a.text < b.text) { return -1; } else { return 0 }
			});
			$('#especialidad').empty().append(sort);
			$('#especialidad').prepend('<option value="" disabled>Seleccione ...</option>');
			$('#especialidad').val('');
		});
		var capitulo = $('#capitulo').val();
		//$('#capitulo option').removeAttr('selected');
		$('#capitulo option[value='+capitulo+']').attr('selected', '');
		$('#especialidad').empty().append('<option value="">Seleccione ...</option>');
	});
});