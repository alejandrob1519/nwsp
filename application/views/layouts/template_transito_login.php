<!DOCTYPE html>
<html lang="es">
<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="description" content="Modulo de Accidentes de transito - DGE" />
	<meta name="author" content="" />

	<title>.::Vigilancia epidemiológica de Lesiones por Accidentes de transito::. | ACCESO </title>



	<link rel="stylesheet" href="<?php echo base_url();?>/assets/neon/css/font-icons/entypo/css/entypo.css">
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic">
	<link rel="stylesheet" href="<?php echo base_url();?>/assets/neon/css/bootstrap.css">
	<link rel="stylesheet" href="<?php echo base_url();?>/assets/neon/css/neon-core.css">
	<link rel="stylesheet" href="<?php echo base_url();?>/assets/neon/css/neon-theme.css">
	<link rel="stylesheet" href="<?php echo base_url();?>/assets/neon/css/neon-forms.css">
	<link rel="stylesheet" href="<?php echo base_url();?>/assets/neon/css/custom.css">
	<link rel="stylesheet" href="<?php echo base_url();?>/assets/css/bootstrapValidator.min.css">
	

	<script src="<?php echo base_url();?>/assets/neon/js/jquery-1.11.0.min.js"></script>
	<script src="<?php echo base_url();?>/assets/js/bootstrapValidator.min.js"></script>


	<link rel="shortcut icon" href="<?php echo base_url();?>/assets/images/favicon_transito.png">
	<script>
		setTimeout(function(){ $(".errores").fadeOut(800).fadeIn(800).fadeOut(500).fadeIn(500).fadeOut(300);}, 5000);
		setTimeout(function(){ $(".alerta").fadeOut(800).fadeIn(800).fadeOut(500).fadeIn(500).fadeOut(300);}, 5000);

	</script>
	<script type="text/javascript">
$(document).change(function() {
   var validator = $("#form1").bootstrapValidator({
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            usuario: {
                message: 'El usuario no es valido',
                validators: {
                    notEmpty: {
                        message: '<span class="accesotransito">El usuario es requerido</span>'
                    }
                }
            },
            clave: {
                validators: {
                    notEmpty: {
                        message: '<span class="accesotransito">la clave es requerida</span>'
                    }
                }
            }
        }
    });
});
</script>
	<style type="text/css" media="screen">
		.info, .exito, .alerta, .errores {
			width: 98%;
		    font-family: Arial, Helvetica, sans-serif;
		    font-size: 15px;
		    border: 1px solid;
		    background-repeat: no-repeat;
		    background-position: 10px center;
		    margin-top: 1px;
		    margin-right: 1%;
		    margin-bottom: 10px;
		    margin-left: 1%;
		    padding-top: 10px;
		    padding-right: 0px;
		    padding-bottom: 15px;
		    padding-left: 0px;
		}
		.errores {
		    color: #F63F49;
		    background-color: #FFC1BB;
		    text-align: center;
		    position: absolute;
			z-index: 991;
		}

		.exito {
		    color: #4B4B4B;
		    background-color: #21FAA0;
		    text-align: center;
		    position: absolute;
			z-index: 991;
		}

		.alerta {
		    color: #9F6000;
		    background-color: #FEEFB3;
		    text-align: center;
		    position: absolute;
			z-index: 991;
		}

		.accesotransito{
			 font-size:15px;
		}
	</style>
</head>
<!-- PHP DE VALIDACION -->
	<?php
		if($this->session->flashdata('error') != ''){
	?>
			<div class="errores">
				<?php echo $this->session->flashdata('error'); ?>
			</div>
	<?php
		}
		if($this->session->flashdata('alerta') != ''){
	?>
	<div class="alerta">
		<?php echo $this->session->flashdata('alerta'); ?>

	</div>

	<?php
		}
	?>

<body class="page-body login-page login-form-fall" data-url="http://neon.dev">

	<?php
        $atributos = array('id'=>'form1', 'name'=>'form1');
        echo form_open(null, $atributos);
    ?>

<div class="login-container">

	<div class="login-header login-caret">

		<div class="login-content" style="width:100%;">


			<a href="<?php echo base_url();?>" class="logo">
				<img src="<?php echo base_url()?>assets/images/logo.png" width="250" />
				<!--<img src="<?php echo base_url();?>/uploads/logo.png" height="60" alt="" /> -->
			</a>

			<p class="description">
              <h1 style="color:#444444; font-weight:100; font-size: 2.5em;">
					Vigilancia Epidemiológica de Lesiones <br/> por Accidentes de Transito
              </h1>
           </p>

			<!-- progress bar indicator -->
			<div class="login-progressbar-indicator">
				<h3>43%</h3>
				<span>Procesando acceso...</span>
			</div>
		</div>

	</div>

	<div class="login-progressbar">
		<div></div>

	</div>

	<div class="login-form " style="padding:1px;">

		<div class="login-content">

			<div class="form-login-error">
				<h3>Acceso invalido</h3>
				<p>Por favor ingrese un usuario!</p>
			</div>

			<form method="post" role="form" id="form_login">

				<div class="form-group">

					<div class="input-group">
						<div class="input-group-addon">
							<i class="entypo-user"></i>
						</div>

						<!--<input type="text" class="form-control" name="email" id="email" placeholder="Email" autocomplete="off" data-mask="email" />-->
						<input type="text" class="form-control" name="usuario" id="email" data-mask="email" placeholder="Usuario" autocomplete="off" autofocus />
					</div>

				</div>

				<div class="form-group">

					<div class="input-group">
						<div class="input-group-addon">
							<i class="entypo-key"></i>
						</div>

						<!--<input type="password" class="form-control" name="password" id="password" placeholder="Password" autocomplete="off" />-->
						<input type="password" class="form-control" name="clave" id="password" placeholder="Contrase&ntilde;a" />
					</div>

				</div>

				<div class="form-group">
					<button name="enviar" type="submit" class="btn btn-primary btn-block btn-login">
						<i class="entypo-login"></i>
						Acceder
					</button>
					<!--<button type="submit" name="enviar" class="btn btn-primary btn-block btn-login">
						<i class="entypo-login"></i>
						Acceder
					</button> -->
				</div>


			</form>


			<!--<div class="login-bottom-links">
				<a href="#" class="link">Olvidaste tu contraseña?</a>
			</div>
			-->

		</div>

	</div>
	<footer>
    <p><center style="font-size:11px; color: #646464"><?php echo "Lesiones por Accidentes de transito, pertenece a la Direcci&oacute;n General de Epidemiolog&iacute;a del Ministerio de Salud del Per&uacute;.";?>
    <br/>
    <?php date_default_timezone_set('America/Lima');
    echo "Copyright (c) ".date('Y').". Todos los derechos reservados.";?></center></p>
</footer>

</div>



	<!-- Bottom Scripts -->
	<script src="<?php echo base_url();?>/assets/neon/js/gsap/main-gsap.js"></script>
	<script src="<?php echo base_url();?>/assets/neon/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
	<script src="<?php echo base_url();?>/assets/neon/js/bootstrap.js"></script>
	<script src="<?php echo base_url();?>/assets/neon/js/joinable.js"></script>
	<script src="<?php echo base_url();?>/assets/neon/js/resizeable.js"></script>
	<script src="<?php echo base_url();?>/assets/neon/js/neon-api.js"></script>
	<script src="<?php echo base_url();?>/assets/neon/js/jquery.validate.min.js"></script>
	<script src="<?php echo base_url();?>/assets/neon/js/neon-login.js"></script>
	<script src="<?php echo base_url();?>/assets/neon/js/neon-custom.js"></script>
	<script src="<?php echo base_url();?>/assets/neon/js/neon-demo.js"></script>


</body>
</html>