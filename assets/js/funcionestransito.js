
function exportandoms(){
	$('#exportandoms').removeAttr( 'style' )
	$('#exportandoms').addClass('btn btn-success');
	$('#exportandoms').text('Exportando... espere la ventana de descarga un momento por favor, puede tardar unos minutos.');
	setTimeout(function(){ $("#exportandoms").fadeOut(800).fadeIn(800).fadeOut(500).fadeIn(500).fadeOut(300);}, 15000);
}


$(document).ready(function(){

$(function() {
	//$('input, textarea').placeholder();
	$('input, textarea').placeholder({ customClass: 'my-placeholder' });
});
/*//Activar LocalStorage a todo el form y exclusion de campos
	$( function() {
		$('form').autoStorage( {
			'submit' : true,
			'storageType' : 'local',
			'exclude' : ['hce','hch','ref_es','referi','ap_nm1','ap_nm2','nom_les','dni','edad','direccion','ing_eess','hora','diagno1','dx1','dx2','dx3','fech_egre','cond_egr','rehab','refer']
		});
	});
*/


	function limpiarLocalStorage(){
		window.localStorage.clear();
	}

	//INGRESO DE HORA CON RELOJ
	$('.clockpicker').clockpicker();

	// BOTONES PARA SIGUIENTE Y ATRAZ ENTRE PESTAÑAS
	$('#btnSiguiente').click(function(){
	  $('.nav-tabs > .active').next('li').find('a').trigger('click');
	});
	$('#btnAtras').click(function(){
	  $('.nav-tabs > .active').prev('li').find('a').trigger('click');
	});
	$('#btnSiguiente2').click(function(){
	  $('.nav-tabs > .active').next('li').find('a').trigger('click');
	});
	$('#btnAtras2').click(function(){
	  $('.nav-tabs > .active').prev('li').find('a').trigger('click');
	});

	//Imprimir ficha transito
	$("#imprimirficha").click(function(){
   	$('.ui-tabs-panel').show();
   	window.print();
   	$('.ui-tabs-panel[aria-hidden=true]').hide();
});


});

function habilita_elemento(){
	if(document.getElementById('ref_es').checked == true){
		document.getElementById('diresa_les').disabled = false;
		document.getElementById('redes_les').disabled = false;
		document.getElementById('microred_les').disabled = false;
		document.getElementById('referi').disabled = false;

	}else{
		document.getElementById('diresa_les').disabled = true;
		document.getElementById('redes_les').disabled = true;
		document.getElementById('microred_les').disabled = true;
		document.getElementById('referi').disabled = true;
	}

	if(document.getElementById('inlineRadio175').checked == true){
		$('#tipo_accidente_otros').prop('readonly', false);

	}else{
		$('#tipo_accidente_otros').prop('readonly', true);
		$('#tipo_accidente_otros').val('');

	}

	if(document.getElementById('inlineRadio1241').checked == true){
		$('#referidodonde').prop('readonly', false);


	}else{
		$('#referidodonde').val('');
		$('#referidodonde').prop('readonly', true);
	}

	if(document.getElementById('inlineRadio261').checked == true){
		$('#licenciaconducir').prop('readonly', false);
	}else{
		$('#licenciaconducir').prop('readonly', true);
	}

	if(document.getElementById('inlineRadio318').checked == true){
		$('#otraaseguradora').prop('readonly', false);

	}
	else {
		$('#otraaseguradora').prop('readonly', true);
	}

}

//CONVERTIR TODOS LOS INPUT EN MAYUSCULAS
 $(document).ready(function(){
      	 $("input").blur(function(){
             $(this).val($(this).val().toUpperCase());
         });

});

function mostrar_contenido() {
        element = document.getElementById("contenido_oculto");
        check = document.getElementById("ref_es");
        if (check.checked) {
            element.style.display='block';
            $('#form1')
            .bootstrapValidator('addField', 'referi', {
                validators: {
                    notEmpty: {
                        message: 'eess es requerido, de lo contrario deshabilite la opcion 2.1 El Paciente es Referido?'
                    }
                }
            });
        }
        else {
            element.style.display='none';
            $('#form1')
                .bootstrapValidator('removeField', 'referi');
        }

        element2 = document.getElementById("conten_ref_oculto");
        check2 = document.getElementById("inlineRadio123");

        if (check2.checked) {
            element2.style.display='block';
			$('#form1')
            .bootstrapValidator('addField', 'refer', {
                validators: {
                    notEmpty: {
                        message: 'eess es requerido, de lo contrario deshabilite la opcion 12.3 Referido'
                    }
                }
            });
        }
        else {
            element2.style.display='none';
            $('#form1')
                .bootstrapValidator('removeField', 'refer');
        }

}

//AUTOCOMPLETAR CAMPOS CON BUSQUEDA AUTOLLENADO DIAGNO
$(document).ready(function(){

	$( "#diagno1" ).autocomplete({
	    minLength: 1,
	    source: window.location.protocol + "//" + window.location.host + "/notiWeb/index.php/modulotransito/autollenadoDiagno",
	    select: function(event, ui) {
	        $( "#ciex1" ).val( ui.item.id);
	        $( "#diagno1" ).val( ui.item.value);
	        $( "#categoria1" ).val( ui.item.cate);
	        $( "#grupo1" ).val( ui.item.grup);
	        $( "#capitulo1" ).val( ui.item.capi);
	    }
	});
	$( "#diagno1" ).change(function(){
		if($( "#diagno1" ).val()==''){
			$( "#ciex1" ).val('');
			$( "#categoria1" ).val('');
			$( "#grupo1" ).val('');
			$( "#capitulo1" ).val('');
		};
	});

	$( "#diagno2" ).autocomplete({
	    minLength: 1,
	    source: window.location.protocol + "//" + window.location.host + "/notiWeb/index.php/modulotransito/autollenadoDiagno",
	    select: function(event, ui) {
	        $( "#ciex2" ).val( ui.item.id);
	        $( "#diagno2" ).val( ui.item.value);
	        $( "#categoria2" ).val( ui.item.cate);
	        $( "#grupo2" ).val( ui.item.grup);
	        $( "#capitulo2" ).val( ui.item.capi);
	    }
	});
	$( "#diagno2" ).change(function(){
		if($( "#diagno2" ).val()==''){
			$( "#ciex2" ).val('');
			$( "#categoria2" ).val('');
			$( "#grupo2" ).val('');
			$( "#capitulo2" ).val('');
		};
	});

	$( "#diagno3" ).autocomplete({
	    minLength: 1,
	    source: window.location.protocol + "//" + window.location.host + "/notiWeb/index.php/modulotransito/autollenadoDiagno",
	    select: function(event, ui) {
	        $( "#ciex3" ).val( ui.item.id);
	        $( "#diagno3" ).val( ui.item.value);
	        $( "#categoria3" ).val( ui.item.cate);
	        $( "#grupo3" ).val( ui.item.grup);
	        $( "#capitulo3" ).val( ui.item.capi);
	    }
	});
	$( "#diagno3" ).change(function(){
		if($( "#diagno3" ).val()==''){
			$( "#ciex3" ).val('');
			$( "#categoria3" ).val('');
			$( "#grupo3" ).val('');
			$( "#capitulo3" ).val('');
		};
	});


  // BUTTONS PROGRESS LADDA - Bind normal buttons
  Ladda.bind( 'div:not(.progress-demo) button', { timeout: 2000 } );

  // Bind progress buttons and simulate loading progress
  Ladda.bind( '.progress-demo button', {
    callback: function( instance ) {
      var progress = 0;
      var interval = setInterval( function() {
        progress = Math.min( progress + Math.random() * 0.1, 1 );
        instance.setProgress( progress );

        if( progress === 1 ) {
          instance.stop();
          clearInterval( interval );
        }
      }, 200 );
    }
  } );

//VALIDACIONES CON BOOTSTRAP http://reactiveraven.github.io/jqBootstrapValidation/
// $(function () { $("input,select,textarea").not("[type=submit]").jqBootstrapValidation(); } );

//DIRESA RED MICRORED UNIDAD NOTIFICANTE
	$('#diresa_not').change(function () {
		var url = window.location.protocol + "//" + window.location.host;
		$.getJSON(url+'/notiWeb/index.php/modulotransito/llenaRedes', {diresa:$('#diresa_not').val()}, function (data) {
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
		$.getJSON(url+'/notiWeb/index.php/modulotransito/llenaMicroredes', {diresa:$('#diresa_not').val(), redes:$('#redes_not').val()}, function (data) {
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
		$.getJSON(url+'/notiWeb/index.php/modulotransito/llenaEstablec', {diresa:$('#diresa_not').val(), redes:$('#redes_not').val(), microred:$('#microred_not').val()}, function (data) {
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

//DIRESA RED MICRORED ORIGEN REFERENCIA LESIONADO
	$('#diresa_les').change(function () {
		var url = window.location.protocol + "//" + window.location.host;
		$.getJSON(url+'/notiWeb/index.php/modulotransito/llenaRedes', {diresa:$('#diresa_les').val()}, function (data) {
			$('#redes_les').empty();
			$.each(data, function (id, desc) {
				option = $('<option></option>', {
					value : id,
					text : desc
				});
				$('#redes_les').append(option);
			});
			var sort = $('#redes_les option');
			sort.sort(function (a, b) {
				 if (a.text > b.text) { return 1; } else if (a.text < b.text) { return -1; } else { return 0 }
			});
			$('#redes_les').empty().append(sort);
			$('#redes_les').prepend('<option value="">Seleccione ...</option>');
			$('#redes_les').val('');
		});

		$('#redes_les').empty().append('<option value="">Seleccione ...</option>');
		$('#microred_les').empty().append('<option value="">Seleccione ...</option>');
		$('#referi').empty().append('<option value="">Seleccione ...</option>');
	});

	$('#redes_les').change(function () {
		var url = window.location.protocol + "//" + window.location.host;
		$.getJSON(url+'/notiWeb/index.php/modulotransito/llenaMicroredes', {diresa:$('#diresa_les').val(), redes:$('#redes_les').val()}, function (data) {
			$('#microred_les').empty();
			$.each(data, function (id, desc) {
				option = $('<option></option>', {
					value : id,
					text : desc
				});
				$('#microred_les').append(option);
			});
			var sort = $('#microred_les option');
			sort.sort(function (a, b) {
				 if (a.text > b.text) { return 1; } else if (a.text < b.text) { return -1; } else { return 0 }
			});
			$('#microred_les').empty().append(sort);
			$('#microred_les').prepend('<option value="">Seleccione ...</option>');
			$('#microred_les').val('');
		});
		$('#microred_les').empty().append('<option value="">Seleccione ...</option>');
		$('#referi').empty().append('<option value="">Seleccione ...</option>');
	});

	$('#microred_les').change(function () {
		var url = window.location.protocol + "//" + window.location.host;
		$.getJSON(url+'/notiWeb/index.php/modulotransito/llenaEstablec', {diresa:$('#diresa_les').val(), redes:$('#redes_les').val(), microred:$('#microred_les').val()}, function (data) {
			$('#referi').empty();
			$.each(data, function (id, desc) {
				option = $('<option></option>', {
					value : id,
					text : desc
				});
				$('#referi').append(option);
			});
			var sort = $('#referi option');
			sort.sort(function (a, b) {
				 if (a.text > b.text) { return 1; } else if (a.text < b.text) { return -1; } else { return 0 }
			});
			$('#referi').empty().append(sort);
			$('#referi').prepend('<option value="">Seleccione ...</option>');
			$('#referi').val('');
		});
		$('#referi').empty().append('<option value="">Seleccione ...</option>');
	});



//DIRESA RED MICRORED REFERIDO DESTINO
	$('#diresa_ref_destino').change(function () {
		var url = window.location.protocol + "//" + window.location.host;
		$.getJSON(url+'/notiWeb/index.php/modulotransito/llenaRedes', {diresa:$('#diresa_ref_destino').val()}, function (data) {
			$('#redes_ref_destino').empty();
			$.each(data, function (id, desc) {
				option = $('<option></option>', {
					value : id,
					text : desc
				});
				$('#redes_ref_destino').append(option);
			});
			var sort = $('#redes_ref_destino option');
			sort.sort(function (a, b) {
				 if (a.text > b.text) { return 1; } else if (a.text < b.text) { return -1; } else { return 0 }
			});
			$('#redes_ref_destino').empty().append(sort);
			$('#redes_ref_destino').prepend('<option value="" disabled>Seleccione ...</option>');
			$('#redes_ref_destino').val('');
		});

		$('#redes_ref_destino').empty().append('<option value="">Seleccione ...</option>');
		$('#microred_ref_destino').empty().append('<option value="">Seleccione ...</option>');
		$('#refer').empty().append('<option value="">Seleccione ...</option>');
	});

	$('#redes_ref_destino').change(function () {
		var url = window.location.protocol + "//" + window.location.host;
		$.getJSON(url+'/notiWeb/index.php/modulotransito/llenaMicroredes', {diresa:$('#diresa_ref_destino').val(), redes:$('#redes_ref_destino').val()}, function (data) {
			$('#microred_ref_destino').empty();
			$.each(data, function (id, desc) {
				option = $('<option></option>', {
					value : id,
					text : desc
				});
				$('#microred_ref_destino').append(option);
			});
			var sort = $('#microred_ref_destino option');
			sort.sort(function (a, b) {
				 if (a.text > b.text) { return 1; } else if (a.text < b.text) { return -1; } else { return 0 }
			});
			$('#microred_ref_destino').empty().append(sort);
			$('#microred_ref_destino').prepend('<option value="">Seleccione ...</option>');
			$('#microred_ref_destino').val('');
		});
		$('#microred_ref_destino').empty().append('<option value="">Seleccione ...</option>');
		$('#refer').empty().append('<option value="">Seleccione ...</option>');
	});

	$('#microred_ref_destino').change(function () {
		var url = window.location.protocol + "//" + window.location.host;
		$.getJSON(url+'/notiWeb/index.php/modulotransito/llenaEstablec', {diresa:$('#diresa_ref_destino').val(), redes:$('#redes_ref_destino').val(), microred:$('#microred_ref_destino').val()}, function (data) {
			$('#refer').empty();
			$.each(data, function (id, desc) {
				option = $('<option></option>', {
					value : id,
					text : desc
				});
				$('#refer').append(option);
			});
			var sort = $('#refer option');
			sort.sort(function (a, b) {
				 if (a.text > b.text) { return 1; } else if (a.text < b.text) { return -1; } else { return 0 }
			});
			$('#refer').empty().append(sort);
			$('#refer').prepend('<option value="">Seleccione ...</option>');
			$('#refer').val('');
		});
		$('#refer').empty().append('<option value="">Seleccione ...</option>');
	});


//DEPARTAMENTO PROVINCIA DISTRITO LESIONADO
	$('#departamento').change(function () {
		var url = window.location.protocol + "//" + window.location.host;
		$.getJSON(url+'/notiWeb/index.php/modulotransito/llenaProvincias', {departamento:$('#departamento').val()}, function (data) {
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
		//$('#departamento option[value='+departamento+']').attr('selected', '');
		$('#provincia').empty().append('<option value="">Seleccione ...</option>');
		$('#distrito').empty().append('<option value="">Seleccione ...</option>');
	});

	$('#provincia').change(function () {
		var url = window.location.protocol + "//" + window.location.host;
		$.getJSON(url+'/notiWeb/index.php/modulotransito/llenaDistritos', { provincia:$('#provincia').val()},function (data) {
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
		//$('#provincia option[value='+provincia+']').attr('selected', '');
		$('#distrito').empty().append('<option value="">Seleccione ...</option>');
		$('#localidad').empty().append('<option value="">Seleccione ...</option>');
	});

//DEPARTAMENTO PROVINCIA DISTRITO LUGAR DEL ACCIDENTE
	$('#departamento_accidente').change(function () {
		var url = window.location.protocol + "//" + window.location.host;
		$.getJSON(url+'/notiWeb/index.php/modulotransito/llenaProvincias', {departamento:$('#departamento_accidente').val()}, function (data) {
			$('#provincia_accidente').empty();
			$.each(data, function (id, desc) {
				option = $('<option></option>', {
					value : id,
					text : desc
				});
				$('#provincia_accidente').append(option);
			});
			var sort = $('#provincia_accidente option');
			sort.sort(function (a, b) {
				 if (a.text > b.text) { return 1; } else if (a.text < b.text) { return -1; } else { return 0 }
			});
			$('#provincia_accidente').empty().append(sort);
			$('#provincia_accidente').prepend('<option value="" disabled>Seleccione ...</option>');
			$('#provincia_accidente').val('');
		});
		var departamento = $('#departamento_accidente').val();
		/*$('#departamento option').removeAttr('selected');*/
		$('#departamento_accidente option[value='+departamento+']').attr('selected', '');
		$('#provincia_accidente').empty().append('<option value="">Seleccione ...</option>');
		$('#distrito_accidente').empty().append('<option value="">Seleccione ...</option>');
	});

	$('#provincia_accidente').change(function () {
		var url = window.location.protocol + "//" + window.location.host;
		$.getJSON(url+'/notiWeb/index.php/modulotransito/llenaDistritos', { provincia:$('#provincia_accidente').val()},function (data) {
			$('#distrito_accidente').empty();
			$.each(data, function (id, desc) {
				option = $('<option></option>', {
					value : id,
					text : desc
				});
				$('#distrito_accidente').append(option);
			});
			var sort = $('#distrito_accidente option');
			sort.sort(function (a, b) {
				 if (a.text > b.text) { return 1; } else if (a.text < b.text) { return -1; } else { return 0 }
			});
			$('#distrito_accidente').empty().append(sort);
			$('#distrito_accidente').prepend('<option value="" disabled>Seleccione ...</option>');
			$('#distrito_accidente').val('');
		});
		var provincia = $('#provincia_accidente').val();
		/*$('#departamento option').removeAttr('selected');*/
		$('#provincia_accidente option[value='+provincia+']').attr('selected', '');
		$('#distrito_accidente').empty().append('<option value="">Seleccione ...</option>');
	});


//DEPARTAMENTO PROVINCIA DISTRITO LUGAR DEL CONDUCTOR
	$('#departamento_cond').change(function () {
		var url = window.location.protocol + "//" + window.location.host;
		$.getJSON(url+'/notiWeb/index.php/modulotransito/llenaProvincias', {departamento:$('#departamento_cond').val()}, function (data) {
			$('#provincia_cond').empty();
			$.each(data, function (id, desc) {
				option = $('<option></option>', {
					value : id,
					text : desc
				});
				$('#provincia_cond').append(option);
			});
			var sort = $('#provincia_cond option');
			sort.sort(function (a, b) {
				 if (a.text > b.text) { return 1; } else if (a.text < b.text) { return -1; } else { return 0 }
			});
			$('#provincia_cond').empty().append(sort);
			$('#provincia_cond').prepend('<option value="" disabled>Seleccione ...</option>');
			$('#provincia_cond').val('');
		});
		var departamento = $('#departamento_cond').val();
		/*$('#departamento option').removeAttr('selected');*/
		$('#departamento_cond option[value='+departamento+']').attr('selected', '');
		$('#provincia_cond').empty().append('<option value="">Seleccione ...</option>');
		$('#distrito_cond').empty().append('<option value="">Seleccione ...</option>');
	});

	$('#provincia_cond').change(function () {
		var url = window.location.protocol + "//" + window.location.host;
		$.getJSON(url+'/notiWeb/index.php/modulotransito/llenaDistritos', { provincia:$('#provincia_cond').val()},function (data) {
			$('#distrito_cond').empty();
			$.each(data, function (id, desc) {
				option = $('<option></option>', {
					value : id,
					text : desc
				});
				$('#distrito_cond').append(option);
			});
			var sort = $('#distrito_cond option');
			sort.sort(function (a, b) {
				 if (a.text > b.text) { return 1; } else if (a.text < b.text) { return -1; } else { return 0 }
			});
			$('#distrito_cond').empty().append(sort);
			$('#distrito_cond').prepend('<option value="" disabled>Seleccione ...</option>');
			$('#distrito_cond').val('');
		});
		var provincia = $('#provincia_cond').val();
		/*$('#departamento option').removeAttr('selected');*/
		$('#provincia_cond option[value='+provincia+']').attr('selected', '');
		$('#distrito_cond').empty().append('<option value="">Seleccione ...</option>');
	});



	$("#fecha_ingreso_lesion").datepicker({
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1950:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fecha_egreso_lesion").datepicker({
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
		dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
		currentText: 'Now',
		changeMonth: true,
		changeYear: true,
		maxDate: "+0D",
		yearRange: "1950:2025",
		dateFormat: "dd-mm-yy"
	});

	$("#fecha_accidente").datepicker({
	monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
	dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
	currentText: 'Now',
	changeMonth: true,
	changeYear: true,
	maxDate: "+0D",
	yearRange: "1950:2025",
	dateFormat: "dd-mm-yy"
	});

	setTimeout(function(){ $(".errores").fadeOut(800).fadeIn(800).fadeOut(500).fadeIn(500).fadeOut(300);}, 5000);
	setTimeout(function(){ $(".exito").fadeOut(800).fadeIn(800).fadeOut(500).fadeIn(500).fadeOut(300);}, 5000);
	setTimeout(function(){ $(".info").fadeOut(800).fadeIn(800).fadeOut(500).fadeIn(500).fadeOut(300);}, 5000);
	setTimeout(function(){ $(".alerta").fadeOut(800).fadeIn(800).fadeOut(500).fadeIn(500).fadeOut(300);}, 5000);
//	setTimeout(function(){ $(".warning").fadeOut(800).fadeIn(800).fadeOut(500).fadeIn(500).fadeOut(300);}, 5000);
});


//BOQUEAR ENTRADA DE TEXTO, PERMITIR SOLO NUMERO
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



// autofiltro con AJAX  para resumen casos notificados por años
$(function(){

	$('#ListarCasos').on('click',function(){
		var anio = $('#filtro_an').val();
		var diresa = $('#diresa_not').val();
		var red = $('#redes_not').val();
		var mred = $('#microred_not').val();
		var eess = $('#cod_eess').val();
		var url = '/notiWeb/index.php/modulotransito/casosAjax';
		$.ajax({
			type:'POST',
			url:url,
			data:{'anio' : anio, 'diresa' : diresa, 'red' : red, 'mred' : mred, 'eess' : eess},
			success: function(datos){
				$('#listar-registros').empty();
				$('#listar-registros').html(datos);
			}
		});
	return false;
	});


	/* llamando a tooltips*/
	$('[data-toggle="tooltip"]').tooltip();

	/*haciendo focus a diagnostico para ingreso y ejecucion de tooltip*/
	$('#ciex1').click(function(){
	    $('#diagno1').focus();
	});

	$('#ciex2').click(function(){
	    $('#diagno2').focus();
	});

	$('#ciex3').click(function(){
	    $('#diagno3').focus();
	});


	/*verificacion de cierre de año*/
	$('#fecha_ingreso_lesion').change(function(){
		//d = new Date($('#fecha_ingreso_lesion').val());
		//year= d.getFullYear();
		var year= parseInt($('#fecha_ingreso_lesion').val().substring(6));
		var apli=9;
		var urlvercierreaplica='http://'+location.hostname+'/notiWeb/index.php/modulotransito/vercierreaplica'
		$.ajax({
		    url: urlvercierreaplica,
		    data: { anio: year, apli: apli }
		    }).done(function( msg ) {
			    var obj = jQuery.parseJSON(msg);
			    
			    if (obj.estado==1 || year<2005){
					$('#fecha_ingreso_lesion').val('');

					var mensaje_anio = "<span style='color:red;'>Este Año esta cerrado,</span> Por Favor seleccione otra fecha mas actual.";
					var tour = new Tour({						
						steps: [
						  {
						    element: ".fecha_ingreso_lesion",
						    placement: "left",
						    title: "Advertencia de ingreso",
						    content: mensaje_anio
						  }
						],
						  backdrop: true,
						  storage: false,
					  
					});
					
					tour.init();
					tour.start();
					
					$('#form1').bootstrapValidator('revalidateField', 'ing_eess');
			        return false;
			    }
			    else{
			    						    
					       Tour.prototype.off();

				
			        return true;
			    }
		});
	});



})



