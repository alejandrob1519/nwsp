$(document).ready(function () {
	var validator = $("#form1").bootstrapValidator({
		excluded: [':disabled'],
		feedbackIcons : {
			valid 		: "glyphicon glyphicon-ok",
			invalid 	: "glyphicon glyphicon-remove",
			validating 	: "glyphicon glyphicon-refresh"
		},

		fields : {
			madre_apenom: {
                validators: {
                    notEmpty: {
                        message: 'dato es requerido'
                    }
                }
            },

			notificador: {
                validators: {
                    notEmpty: {
                        message: 'dato es requerido'
                    }
                }
            },

			codigo 		: {
				trigger: 'change click',
				message   : "dato es requerido",
				validators: {
					notEmpty : {
						message : "dato es requerido"
					},
					digits: {
                        message: 'Ingrese solo numeros'
                    },
					stringLength : {
						min 	: 8,
						message : "Minimo 8 caracteres"
					}
				}
			}
		}
	});

	if(document.getElementById('sifilis1').checked == true){
		$('#form1')
		.bootstrapValidator('addField', 'distrito', {
			trigger: 'change click',
			validators: {
				notEmpty: {
					message: 'dato es requerido'
				}
			}
		});
	}else{
		$('#form1').data('bootstrapValidator').resetField($('#distrito'));
		$('#form1').bootstrapValidator('removeField', 'distrito');
	}
	
	$('#atencion').on('change', function(){
		var valor = $(this).val();
		
        switch(valor){
			case '':
            $('#form1').data('bootstrapValidator').resetField($('#fecha_con1'));
            $('#form1').data('bootstrapValidator').resetField($('#edad_ges_mat'));
            $('#form1').bootstrapValidator('removeField', 'fecha_con1');
            $('#form1').bootstrapValidator('removeField', 'edad_ges_mat');
			break;
            case '1':
			$('#form1').bootstrapValidator('addField', 'fecha_con1', {
				trigger: 'change click',
				message: 'Dato es requerido',
				validators: {
					notEmpty: {
						message: 'Dato es requerido'
					},
					date: {
						message: 'fecha no puede ser superior a la fecha actual',
						format: 'DD-MM-YYYY',
						min: '01-01-1983',
						max: 'diaHoy'
					}
				}
			}); 

			$('#form1').bootstrapValidator('addField', 'edad_ges_mat', {
				trigger: 'change click',
				message: 'Dato es requerido',
                validators: {
                	notEmpty : {
                		message : "Dato es requerido"
                	},
                    lessThan: {
                        value		: 42,
                        inclusive	: true,
                        message		: 'Solo semanas menor a 42'
                    },
                    digits: {
                        message: 'Ingrese solo numeros'
                    },
                    greaterThan: {
                        value		: 0,
                        inclusive	: false,
                        message		: 'valor tiene que ser >= 0'
                    }
                }
			}); 
			break;
			case '2':
			case '3':
            $('#form1').data('bootstrapValidator').resetField($('#fecha_con1'));
            $('#form1').data('bootstrapValidator').resetField($('#edad_ges_mat'));
            $('#form1').bootstrapValidator('removeField', 'fecha_con1');
            $('#form1').bootstrapValidator('removeField', 'edad_ges_mat');
			break;
		}
	});
});
