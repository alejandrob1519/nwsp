$(function() {

	//Activar placeholder en ie8
	$('input, textarea').placeholder({ customClass: 'my-placeholder' });

	//CONVERTIR TODOS LOS INPUT EN MAYUSCULAS
  	 $("input").blur(function(){
         $(this).val($(this).val().toUpperCase());
     });

});

//bloquear entrada de texto, permitir solo numero
var nav4 = window.Event ? true : false;
function SoloNumeros(evt){
	// NOTE: Backspace = 8, Enter = 13, '0' = 48, '9' = 57
	var key = nav4 ? evt.which : evt.keyCode;
	return (key <= 13 || (key >= 45 && key <= 57));
}


//formato de fechas con clase .datepicker
$(document).ready(function(){
	$(".datepicker").datepicker({
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1950:2025",
		dateFormat: "dd-mm-yy",
		weekHeader: ["SE"],
		showWeek: true,
		firstDay: 7
	});

	//INGRESO DE HORA CON RELOJ
	$('.clockpicker').clockpicker();

	//DIRESA RED MICRORED UNIDAD NOTIFICANTE
	$('#cod_disa').change(function () {
		var url = window.location.protocol + "//" + window.location.host;
		$.getJSON(url+'/notiWeb/index.php/violenciafamiliar/llenaRedes', {diresa:$('#cod_disa').val()}, function (data) {
			$('#redes_not').empty();
			$.each(data, function (id, desc) {
				option = $('<option></option>', {
					value : id,
					text : desc
				});
				$('#redes_not').append(option);
			});
			var sort = $('#redes_not option');
			sort.sort(function (a, b) {
				 if (a.text > b.text) { return 1; } else if (a.text < b.text) { return -1; } else { return 0 }
			});
			$('#redes_not').empty().append(sort);
			$('#redes_not').prepend('<option value="">Seleccione ...</option>');
			$('#redes_not').val('');
		});

		$('#redes_not').empty().append('<option value="">Seleccione ...</option>');
		$('#microred_not').empty().append('<option value="">Seleccione ...</option>');
		$('#cod_eess').empty().append('<option value="">Seleccione ...</option>');
	});

	$('#redes_not').change(function () {
		var url = window.location.protocol + "//" + window.location.host;
		$.getJSON(url+'/notiWeb/index.php/violenciafamiliar/llenaMicroredes', {diresa:$('#cod_disa').val(), redes:$('#redes_not').val()}, function (data) {
			$('#microred_not').empty();
			$.each(data, function (id, desc) {
				option = $('<option></option>', {
					value : id,
					text : desc
				});
				$('#microred_not').append(option);
			});
			var sort = $('#microred_not option');
			sort.sort(function (a, b) {
				 if (a.text > b.text) { return 1; } else if (a.text < b.text) { return -1; } else { return 0 }
			});
			$('#microred_not').empty().append(sort);
			$('#microred_not').prepend('<option value="">Seleccione ...</option>');
			$('#microred_not').val('');
		});
		$('#microred_not').empty().append('<option value="">Seleccione ...</option>');
		$('#cod_eess').empty().append('<option value="">Seleccione ...</option>');
	});

	$('#microred_not').change(function () {
		var url = window.location.protocol + "//" + window.location.host;
		$.getJSON(url+'/notiWeb/index.php/violenciafamiliar/llenaEstablec', {diresa:$('#cod_disa').val(), redes:$('#redes_not').val(), microred:$('#microred_not').val()}, function (data) {
			$('#cod_eess').empty();
			$.each(data, function (id, desc) {
				option = $('<option></option>', {
					value : id,
					text : desc
				});
				$('#cod_eess').append(option);
			});
			var sort = $('#cod_eess option');
			sort.sort(function (a, b) {
				 if (a.text > b.text) { return 1; } else if (a.text < b.text) { return -1; } else { return 0 }
			});
			$('#cod_eess').empty().append(sort);
			$('#cod_eess').prepend('<option value="">Seleccione ...</option>');
			$('#cod_eess').val('');
		});
		$('#cod_eess').empty().append('<option value="">Seleccione ...</option>');
	});




/*
//desactiavar checkbox de radio si no se requiere
$('input:radio').bind('click mousedown', (function() {
    var isChecked;
    return function(event) {
        if(event.type == 'click') {
            if(isChecked) {
                isChecked = this.checked = false;
            } else {
                isChecked = true;
            }
    } else {
        isChecked = this.checked;
    }
}})());
*/




});

