<!DOCTYPE html>
<html lang="es">
<head>
<meta http-equiv="content-type" content="text/html" charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $this->layout->getTitle(); ?></title>
<meta name="description" content="<?php echo $this->layout->getDescripcion(); ?>">
<meta name="keywords" content="<?php echo $this->layout->getKeywords(); ?>" />

<meta name="viewport" content="width=device-width, initial-scale=1.0" />


<link href="<?php echo base_url()?>assets/css/blitzer/jquery-ui-1.10.4.custom.css" rel='stylesheet' type='text/css' media='all' />
<link href="<?php echo base_url()?>assets/css/bootstrap.min.css" rel='stylesheet' type='text/css' media='all' />
<link href="<?php echo base_url()?>assets/font-awesome/css/font-awesome.min.css" rel='stylesheet' type='text/css' media='all' />
<link href="<?php echo base_url()?>assets/css/style_transito.css" rel='stylesheet' type='text/css' media='all' />
<link href="<?php echo base_url()?>assets/css/segmented-controls.css" rel='stylesheet' type='text/css' media='all' />
<link href="<?php echo base_url()?>assets/ladda-bootstrap-buttons-loader/dist/ladda-themeless.min.css" rel='stylesheet' />
<link href="<?php echo base_url()?>assets/css/bootstrapValidator.min.css" rel='stylesheet' />
<link href="<?php echo base_url()?>assets/css/bootstrap-clockpicker.min.css" rel='stylesheet' />
<link href="<?php echo base_url()?>assets/css/circulos.css" rel='stylesheet' />
<link href="<?php echo base_url()?>assets/css/animate.css" rel='stylesheet' />
<link href="<?php echo base_url()?>assets/css/bootstrap-tour.css" rel='stylesheet' />

<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery-ui-1.10.4.custom.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/ladda-bootstrap-buttons-loader/dist/spin.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/ladda-bootstrap-buttons-loader/dist/ladda.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/bootstrapValidator.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/highcharts/js/highcharts.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/highcharts/js/modules/exporting.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/bootstrap-clockpicker.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/autoStorage.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/bootstrap-tour.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/funcionestransito.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/validacionTransito.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/manualTransito.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery.placeholder.js"></script>

<link rel="shortcut icon" href="<?php echo base_url();?>assets/images//favicon_transito.png">
  <script>
    setTimeout(function(){ $(".exito").fadeOut(800).fadeIn(800).fadeOut(500).fadeIn(500).fadeOut(300);}, 5000);
    setTimeout(function(){ $(".alerta").fadeOut(800).fadeIn(800).fadeOut(500).fadeIn(500).fadeOut(300);}, 5000);
//    setTimeout(function(){ $(".error").fadeOut(800).fadeIn(800).fadeOut(500).fadeIn(500).fadeOut(300);}, 5000);
    setTimeout(function(){ $(".errores").fadeOut(800).fadeIn(800).fadeOut(500).fadeIn(500).fadeOut(300);}, 5000);
  </script>
</head>

<body onLoad="nobackbutton();" style="background:#F4F3F3;">
<div class="barra">
    <div style="text-align: left;">
        <?php
        $caducidad = $this->session->userdata('caduca');
        $faltan = $this->login_model->daysDifference($caducidad, date('Y-m-d'));

        if($faltan <= 30){
        	$termina = 'Atenci&oacute;n: Faltan '.$faltan.' d&iacute;as para que su usuario caduque, USTED DEBE CAMBIAR SU CONTRASE&Ntilde;A. Proceda por favor.';
        }else{
        	$termina = "Ficha de Accidentes de Transito Version 1.0";
        }

        if($faltan <= 0){
        	$data = array("usuario" => $this->session->userdata("usuario"), "estado" => "2");

        	$this->login_model->baja($data);

        	redirect(site_url("index/login"), 301);
        }

        if($termina <> ""){
    	?>

    	</div>

      <div class="info_user">
        Bienvenido: <i class="fa fa-user"></i>
        <?php
              echo "<div style='display: inline;' id='nombreUsuario'>".ucwords(strtolower($this->session->userdata('nombres')))."</div>";
              echo ' ('.$this->session->userdata('usuario').') &nbsp;&nbsp;|&nbsp;&nbsp; ';
              //$trozos2=explode(" ",$this->session->userdata('nombres'));
              //echo ucwords("<br>".strtolower($trozos2[0]))." ".ucwords(strtolower($trozos2[1]));

        ?>
        <i class="fa fa-eye"></i>
        <?php
              $nivelUser = array(''=>'sin nivel','1'=>'Administrador','4'=>'Nacional','5'=>'Diresa','6'=>'Red','7'=>'Microred','8'=>'Establecimiento');
              echo ' Nivel: '.$nivelUser[$this->session->userdata('nivel')];
       }
       ?>
      </div>

</div>
<nav class="navbar navbar-default" role="navigation">
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse"
            data-target=".navbar-ex1-collapse">
      <span class="sr-only">Desplegar navegación</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand hidden-sm" href="<?php echo base_url();?>"><img src="<?php echo base_url()?>assets/images/logo.png" width="250" /></a>
  </div>

  <div class="collapse navbar-collapse navbar-ex1-collapse" id="menu-principal">
    <ul class="nav navbar-nav">
        <li class="item0"><a href="<?php echo site_url('modulotransito/principal_transito'); ?>"><strong><i class="fa fa-home"></i> Inicio</strong></a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <strong><i class="fa fa-table"></i> Fichas</strong>
          </a>
          <ul class="dropdown-menu">
            <li><a href="<?php echo site_url('modulotransito/registro_transito');?>"><i class="fa fa-file-text-o"></i> Nueva Ficha</a></li>
            <li class="divider"></li>
            <li><a href="<?php echo site_url('modulotransito/listar_transito');?>"><i class="fa fa-list"></i> Listar Fichas</a></li>            
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <strong><i class="fa fa-cog"></i> Reportes/Procesos</strong> <b class="caret"></b>
          </a>
          <ul class="dropdown-menu">
            <li><a href="<?php echo site_url('modulotransito/exportar');?>"><i class="fa fa-database"></i> Exportar Base Datos</a></li>
            <li class="divider"></li>
            <li><a href="<?php echo site_url('modulotransito/graficos');?>"><i class="fa fa-bar-chart"></i> Generar Gr&aacute;ficos</a></li>
            <li class="divider"></li>
            <li><a href="<?php echo site_url('modulotransito/controlnotificacion_transito');?>"><i class="fa fa-line-chart"></i> Seguimiento de casos</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <strong><i class="fa fa-file"></i> Documentos</strong> <b class="caret"></b>
          </a>
          <ul class="dropdown-menu">
            <li><a href="<?php echo base_url('assets/images/Ficha_Lesacctra.pdf');?>" target="_blank" download><i class="fa fa-download"></i>
              Formato Ficha</a>
            </li>
            <li class="divider"></li>
            <li><a href="<?php echo base_url('assets/images/Norma_tecnica.pdf');?>" target="_blank" download><i class="fa fa-download"></i>
              Norma Tecnica</a>
            </li>
            <li class="divider"></li>
            <li><a href="<?php echo base_url('assets/images/Diccionario_Variables_Lesacctra.pdf');?>" target="_blank" download><i class="fa fa-download"></i>
              Diccionario Variables</a>
            </li>
            <li class="divider"></li>
            <li><a href="#" id="iniciar-manual"><i class="fa fa-life-ring"></i>
              Inicar Manual </a>

            </li>
          </ul>
        </li>
        <li ><a href="<?php echo site_url('index/principal');?>"><strong><i class="fa fa-sign-out"></i> Salir</strong></a></li>
     </ul>

  </div>

</nav>
<div class="contenido">
    <?php echo $content_for_layout; ?>
</div>




<footer>
    <p><center style="font-size:11px; color: #646464"><?php echo "Lesiones por Accidentes de transito, pertenece a la Direcci&oacute;n General de Epidemiolog&iacute;a del Ministerio de Salud del Per&uacute;.";?>
    <br/>
    <?php date_default_timezone_set('America/Lima');
    echo "Copyright (c) ".date('Y').". Todos los derechos reservados.";?></center></p>
</footer>
</body>
</html>