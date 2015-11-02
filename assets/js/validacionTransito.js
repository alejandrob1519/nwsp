//validacion de formulario con bootstrapValidator
$(document).ready(function () {
	
	var validator = $("#form1").bootstrapValidator({
		excluded: [':disabled'],
		feedbackIcons : {
			valid 		: "glyphicon glyphicon-ok",
			invalid 	: "glyphicon glyphicon-remove",
			validating 	: "glyphicon glyphicon-refresh"
		},

		fields : {
			fuen_finc: {
                validators: {
                    notEmpty: {
                        message: '<span class="null_financiamiento">La fuente de financiamiento es requerido, elejir: SOAT | MTC | PARTICULAR</span>'
                    }
                }
            },

            cod_eess: {
                validators: {
                    notEmpty: {
                        message: 'Establecimiento es requerido'
                    }
                }
            },

            dis: {
                validators: {
                    notEmpty: {
                        message: 'Distrito es requerido'
                    }
                }
            },

			ap_nm1	:{
				message 	: "El Apellido es requerido",
				validators 	: {
					notEmpty : {
						message : "Ingrese el apellido de lesionado"
					}
				}
			},

			ap_nm2	:{
				message 	: "El Apellido es requerido",
				validators 	: {
					notEmpty : {
						message : "Ingrese el apellido de lesionado"
					}
				}
			},

			nom_les	: {
				message 	: "El nombre es requerido",
				validators 	: {
					notEmpty : {
						message : "Ingrese el nombre de lesionado"
					}
				}
			},

			dni 	: {
				validators: {

					digits: {
                        message: 'Ingrese solo numeros'
                    },
					stringLength : {
						min 	: 8,
						message : "Minimo 8 caracteres"
					}
				}
			},

			edad: {
                validators: {
                	notEmpty : {
                		message : "Ingresa edad"
                	},
                    lessThan: {
                        value		: 120,
                        inclusive	: true,
                        message		: 'Solo edad menor a 120'
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
            },

			tipo_edad 	: {
				message 	: "Tipo es requerido",
				validators : {
					notEmpty 	: {
						message : "Elegir Tipo"
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

			},

			hora : {
				trigger: 'change click',
				validators : {
					notEmpty 	: {
						message : "Hora es requerida"
					},

					regexp: {
						//"^(09|1[0-7]{1}):[0-5]{1}[0-9]{1}$" between 09:00 and 17:59
						// ^([0-9]|0[0-9]|1?[0-9]|2[0-3]):[0-5]?[0-9]$  formato 23:59 sin riesgo
                        regexp: /^(?:\d|[01]\d|2[0-3]):[0-5]\d$/,
                        message: 'Formato 24 horas incorrecto, 23:59'
                    }
				}
			},

			diagno1	: {
				message 	: "Sexo es requerido",
				validators : {
					notEmpty 	: {
						message : "Al menos un diagnostico es requerido"
					}
				}

			},

			ing_eess : {
				trigger: 'change click',
				validators : {
					notEmpty 	: {
						message : "fecha es requerida"
					},

					date: {
                        message: 'No puede ser mayor al campo <strong>11.fecha egreso del eess</strong>',
                        format: 'DD-MM-YYYY',                        
                        //$.datepicker.formatDate('dd-mm-yy', new Date());
                        //min: '01-01-2013',
                        max: 'fech_egre'


                    }
				}
			},


			fech_egre : {
				trigger: 'change click',
				validators : {
					notEmpty 	: {
						message : "fecha es requerida"
					},

					date: {
                        message: 'No puede ser menor al campo <strong>8.fecha ingreso al eess</strong>',
                        format: 'DD-MM-YYYY',
                        min: 'ing_eess'
                        //max: '06-07-2016'

                    }
				}
			},

            fec_accd : {
				trigger: 'change click',
				validators : {
					notEmpty 	: {
						message : "fecha es requerida"
					},

					date: {
                        message: 'No puede ser mayor al campo <strong>8.fecha ingreso al eess</strong>',
                        format: 'DD-MM-YYYY',
                        max: 'ing_eess'

                    }
				}
			},

			hor_accid : {
				trigger: 'change click',
				validators : {
					notEmpty 	: {
						message : "Hora es requerida"
					},

					regexp: {
                        regexp: /^(?:\d|[01]\d|2[0-3]):[0-5]\d$/,
                        message: 'Formato 24 horas incorrecto, 23:59'
                    }
				}
			},

			 dist_acc: {
                validators: {
                    notEmpty: {
                        message: 'Distrito es requerido'
                    }
                }
            },

             tp_accd: {
                validators: {
                    notEmpty: {
                        message: '<span style="background:#FFF7BB;">Tipo de accidente es requerido, elegir uno.</span>'
                    }
                }
            },

            trasl_les: {
                validators: {
                    notEmpty: {
                        message: '<span style="background:#FFF7BB;">Traslado del lesionado es requerido, elegir uno.</span>'
                    }
                }
            }



		}
	});



});