$(document).ready(function () {
	var validator = $("#form1").bootstrapValidator({
		excluded: [':disabled'],
		feedbackIcons : {
			valid 		: "glyphicon glyphicon-ok",
			invalid 	: "glyphicon glyphicon-remove",
			validating 	: "glyphicon glyphicon-refresh"
		},

		fields : {
			fecha_nac : {
				trigger: 'change click',
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

			fecha_inv : {
				trigger: 'change click',
				validators : {
					notEmpty 	: {
						message : "fecha es requerida"
					}
				}
			},

			fecha_mue : {
				trigger: 'change click',
				validators : {
					date: {
                        message: 'error con respecto a la fecha de inicio',
                        format: 'DD-MM-YYYY',
                        min: 'fecha_sin',
                        max: 'diaHoy'

                    }
				}
			},

			fecha_cult : {
				trigger: 'change click',
				validators : {
					date: {
                        message: 'error con respecto a la fecha de inicio',
                        format: 'DD-MM-YYYY',
                        min: 'fecha_sin',
                        max: 'diaHoy'

                    }
				}
			},

			fecha_resul : {
				trigger: 'change click',
				validators : {
					date: {
                        message: 'error con respecto a la fecha de toma de muestra',
                        format: 'DD-MM-YYYY',
                        min: 'fecha_cult',
                        max: 'diaHoy'

                    }
				}
			},

			fecha_ser1 : {
				trigger: 'change click',
				validators : {
					date: {
                        message: 'error con respecto a la fecha de inicio',
                        format: 'DD-MM-YYYY',
                        min: 'fecha_sin',
                        max: 'diaHoy'

                    }
				}
			},

			fecha_res1 : {
				trigger: 'change click',
				validators : {
					date: {
                        message: 'error con respecto a la fecha de toma de muestra',
                        format: 'DD-MM-YYYY',
                        min: 'fecha_ser1',
                        max: 'diaHoy'

                    }
				}
			},

			fecha_ser2 : {
				trigger: 'change click',
				validators : {
					date: {
                        message: 'error con respecto a la fecha de inicio',
                        format: 'DD-MM-YYYY',
                        min: 'fecha_ser1',
                        max: 'diaHoy'

                    }
				}
			},

			fecha_res2 : {
				trigger: 'change click',
				validators : {
					date: {
                        message: 'error con respecto a la fecha de toma de muestra',
                        format: 'DD-MM-YYYY',
                        min: 'fecha_ser2',
                        max: 'diaHoy'

                    }
				}
			},

			fecha_pcr : {
				trigger: 'change click',
				validators : {
					date: {
                        message: 'error con respecto a la fecha de inicio',
                        format: 'DD-MM-YYYY',
                        min: 'fecha_sin',
                        max: 'diaHoy'

                    }
				}
			},

			fecha_res3 : {
				trigger: 'change click',
				validators : {
					date: {
                        message: 'error con respecto a la fecha de toma de muestra',
                        format: 'DD-MM-YYYY',
                        min: 'fecha_pcr',
                        max: 'diaHoy'

                    }
				}
			},

			fecha_hos : {
				trigger: 'change click',
				validators : {
					date: {
                        message: 'error con respecto a la fecha de inicio',
                        format: 'DD-MM-YYYY',
                        min: 'fecha_sin',
                        max: 'diaHoy'

                    }
				}
			},

			fecha_def : {
				trigger: 'change click',
				validators : {
					date: {
                        message: 'error con respecto a la fecha de inicio',
                        format: 'DD-MM-YYYY',
                        min: 'fecha_sin',
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

			localidad : {
				message 	: "localidad es requerida",
                validators: {
                    notEmpty: {
                        message: 'localidad es requerida'
                    }
                }
			},

			'clasifica[]' : {
				message 	: "debe elegir alguna opcion",
                validators: {
                    notEmpty: {
                        message: 'debe elegir alguna opcion'
                    }
                }
			},

			'procede[]' : {
				message 	: "debe elegir alguna opcion",
                validators: {
                    notEmpty: {
                        message: 'debe elegir alguna opcion'
                    }
                }
			},

			investigador : {
				message 	: "dato es requerido",
                validators: {
                    notEmpty: {
                        message: 'dato es requerido'
                    }
                }
			},

			cargo : {
				message 	: "dato es requerido",
                validators: {
                    notEmpty: {
                        message: 'dato es requerido'
                    }
                }
			},

			correo : {
				message 	: "dato es requerido",
                validators: {
                    notEmpty: {
                        message: 'dato es requerido'
                    },

                    emailAddress: {
                        message: 'no es un correo v&aacute;lido'
                    }
                }
			}
		}
	});

	$('#fallecido').change(function(){
		if(document.getElementById('fallecido').value == '1'){
			if(document.getElementById('fallecido').value == '1'){
				document.getElementById("alta").disabled =true;
				document.getElementById("referido").disabled =true;
			}else if(document.getElementById('fallecido').value != '1'){
				document.getElementById("alta").disabled =false;
				document.getElementById("referido").disabled =false;
			}

			$('#form1')
			.bootstrapValidator('addField', 'fecha_def', {
				trigger: 'change click',
				validators: {
					notEmpty: {
						message: 'fecha es requerida'
					},
					date: {
                        message: 'fecha no puede ser superior a la fecha actual',
                        format: 'DD-MM-YYYY',
                        min: '01-01-1983',
                        max: 'diaHoy'

                    }
				}
			});
		}else if(document.getElementById('fallecido').value != '1'){
			$('#form1').data('bootstrapValidator').resetField($('#fecha_def'));
			$('#form1').bootstrapValidator('removeField', 'fecha_def');
			document.getElementById('fecha_def').value = "";	
		}
	});

	$('#alta').change(function(){
		if(document.getElementById('alta').value == '1'){
			document.getElementById("fallecido").disabled =true;
			document.getElementById("fecha_def").disabled =true;
			document.getElementById("referido").disabled =true;
		}else if(document.getElementById('alta').value != '1'){
			document.getElementById("fallecido").disabled =false;
			document.getElementById("fecha_def").disabled =false;
			document.getElementById("referido").disabled =false;
		}
	});

	$('#referido').change(function(){
		if(document.getElementById('alta').value == '1'){
			document.getElementById("fallecido").disabled =true;
			document.getElementById("fecha_def").disabled =true;
			document.getElementById("alta").disabled =true;
		}else if(document.getElementById('alta').value != '1'){
			document.getElementById("fallecido").disabled =false;
			document.getElementById("fecha_def").disabled =false;
			document.getElementById("alta").disabled =false;
		}
	});

	$('#fecha_ser1').change(function(){
		if(document.getElementById('fecha_ser1').value != ''){
			$('#form1')
			.bootstrapValidator('addField', 'fecha_res1', {
				trigger: 'change click',
				validators: {
					notEmpty: {
						message: 'fecha es requerida'
					},
					date: {
	                    message: 'fecha no puede ser superior a la fecha actual',
	                    format: 'DD-MM-YYYY',
	                    min: '01-01-1983',
	                    max: 'diaHoy'

	                }
				}
			});
		}else{
			$('#form1').data('bootstrapValidator').resetField($('#fecha_res1'));
			$('#form1').bootstrapValidator('removeField', 'fecha_res1');
			document.getElementById('fecha_res1').value = "";	
		}
	});	

	$('#fecha_ser2').change(function(){
		if(document.getElementById('fecha_ser2').value != ''){
			$('#form1')
			.bootstrapValidator('addField', 'fecha_res2', {
				trigger: 'change click',
				validators: {
					notEmpty: {
						message: 'fecha es requerida'
					},
					date: {
	                    message: 'fecha no puede ser superior a la fecha actual',
	                    format: 'DD-MM-YYYY',
	                    min: '01-01-1983',
	                    max: 'diaHoy'

	                }
				}
			});
		}else{
			$('#form1').data('bootstrapValidator').resetField($('#fecha_res2'));
			$('#form1').bootstrapValidator('removeField', 'fecha_res2');
			document.getElementById('fecha_res2').value = "";	
		}
	});	

	$('#fecha_ser2').change(function(){
		if(document.getElementById('fecha_ser1').value == ''){
			$('#form1')
			.bootstrapValidator('addField', 'fecha_ser1', {
				trigger: 'change click',
				validators: {
					notEmpty: {
						message: 'Ingrese 1era. muestra'
					},
					date: {
	                    message: 'fecha no puede ser superior a la fecha actual',
	                    format: 'DD-MM-YYYY',
	                    min: '01-01-1983',
	                    max: 'diaHoy'

	                }
				}
			});
		}
	});	
});
