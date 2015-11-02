<!DOCTYPE html>
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->layout->getTitle(); ?></title>
<meta name="description" content="<?php echo $this->layout->getDescripcion(); ?>">
<meta name="keywords" content="<?php echo $this->layout->getKeywords(); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="<?php echo base_url()?>public/css/blitzer/jquery-ui-1.10.4.custom.css" rel='stylesheet' type='text/css' media='all' />
<link href="<?php echo base_url()?>assets/font-awesome/css/font-awesome.min.css" rel='stylesheet' type='text/css' media='all' />
<link href="<?php echo base_url()?>assets/css/bootstrap.min.css" rel='stylesheet' type='text/css' media='all' />
<link href="<?php echo base_url()?>assets/css/bootstrapValidator.min.css" rel='stylesheet' />
<link href="<?php echo base_url()?>assets/css/style.css" rel='stylesheet' type='text/css' media='all' />
<link href="<?php echo base_url()?>assets/css/animate.css" rel='stylesheet' />
<link href="<?php echo base_url()?>assets/css/circulos.css" rel='stylesheet' />

<script type="text/javascript" src="<?php echo base_url()?>assets/ladda-bootstrap-buttons-loader/dist/spin.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/ladda-bootstrap-buttons-loader/dist/ladda.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>public/js/jquery-1.10.2.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>public/js/jquery-ui-1.10.4.custom.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/bootstrapValidator.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/funcionesMaterna.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/materna.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>public/js/jquery.PrintArea.js"></script>

<!--*************auxiliares*****************-->
<?php echo $this->layout->css; ?> 
<?php echo $this->layout->js; ?> 
<!--**********fin auxiliares*****************-->
<script language="javascript">
$(window).on('load', function(){
	$('#cargando').fadeOut(1000);
}); 

function nobackbutton(){
   window.location.hash="no-back-button";
   window.location.hash="Again-No-back-button" //chrome
   window.onhashchange=function(){window.location.hash="no-back-button";}
}

</script>

<link rel="icon" href="<?php echo base_url(); ?>public/images/logo2.ico" type="image/gif">

</head>

<body onLoad="nobackbutton();">
<div id="cargando" 
    style="cursor:pointer;
    background-image: url(../../../public/images/cargando.gif);
    background-repeat:no-repeat;
    background-position:center;
    background-size:10%;
    background-color: rgba(0, 0, 0, 0.7);
    width:100%;
    color:#fff;
    text-align:center;
    height:100%;
    padding:52px 12px 12px 12px;
    position:absolute;
    top:0;
    left:0;
    z-index:6;
    display: block;
    opacity: 1;">
</div>

<link href="public/images/favicon.ico" rel="shortcut icon" type="image/x-icon" />

<div class="barra">
		<?php
        $caducidad = $this->session->userdata('caduca');
        $faltan = $this->login_model->daysDifference($caducidad, date('Y-m-d'));
        
        if($faltan <= 30){
            $termina = 'Atenci&oacute;n: Faltan '.$faltan.' d&iacute;as para que su usuario caduque, USTED DEBE CAMBIAR SU CONTRASE&Ntilde;A. Proceda por favor.';
        }else{
            $termina = "&nbsp;Vigilancia de S&iacute;filis Materna y Cong&eacute;nita | Versi&oacute;n Beta - 1";
        }
        
        if($faltan <= 0){
            $data = array("usuario" => $this->session->userdata("usuario"), "estado" => "2");
            
            $this->login_model->baja($data);
            
            redirect(site_url("index/login"), 301);
        }
        
        if($termina <> ""){
            ?>
            <div class="hidden-xs" style="position: absolute; text-align:left;"><?php echo $termina; ?></div>
            <?php
        }
        ?>

<header>
        <div class="info_user">
            <i class="fa fa-user"></i>
            <?php 
            echo ucwords(strtolower($this->session->userdata('nombres')));
            echo ' ('.$this->session->userdata('usuario').') &nbsp;&nbsp;|&nbsp;&nbsp; ';
            ?>
            <i class="fa fa-eye"></i>
            <?php
            $nivelUser = array(''=>'sin nivel','1'=>'Administrador','4'=>'Nacional','5'=>'Diresa','6'=>'Red','7'=>'Microred','8'=>'Establecimiento');
            echo ' Nivel: '.$nivelUser[$this->session->userdata('nivel')];
            ?>
        </div>
    </div>
    <!--El div que contiene el menú-->
	<?php
        include_once("public/menu/sifilis_menu.php");
    ?>
    </div>
</header>

<div class="contenido"><?php echo $content_for_layout; ?></div>

<footer>
    <p><center style="font-size:11px; font-weight:bold"><?php echo "NotiWeb, pertenece a la Direcci&oacute;n General de Epidemiolog&iacute;a del Ministerio de Salud del Per&uacute;.";?></center></p>
    <p><center style="font-size:11px; font-weight:bold"><?php 
	date_default_timezone_set('America/Lima');
	echo "Copyright (c) ".date('Y').". Todos los derechos reservados.";?></center></p>
</footer>
</body>
</html>