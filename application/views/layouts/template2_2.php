<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->layout->getTitle(); ?></title>
<meta name="description" content="<?php echo $this->layout->getDescripcion(); ?>">
<meta name="keywords" content="<?php echo $this->layout->getKeywords(); ?>" />
<link href='http://fonts.googleapis.com/css?family=Droid+Sans' rel='stylesheet' type='text/css'>
<link href="<?php echo base_url()?>public/css/index.css" rel='stylesheet' type='text/css' media='all' />

<script type="text/javascript" src="<?php echo base_url()?>public/js/jquery-1.10.2.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>public/js/jquery-ui-1.10.4.custom.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>public/js/combos.js"></script>

<!--*************auxiliares*****************-->
<?php echo $this->layout->css; ?> 
<?php echo $this->layout->js; ?> 
<!--**********fin auxiliares*****************-->

<link rel="icon" href="<?php echo base_url(); ?>public/images/logo2.ico" type="image/gif">

</head>

<body>
<link href="public/images/favicon.ico" rel="shortcut icon" type="image/x-icon" />
<div class="header">
	<div class="logo"><img src="<?php echo base_url()?>public/images/logo.png" width="350" /></div>
	<div class="titulo2"><p>Vigilancia Epidemiol&oacute;gica</p></div>
</div>

<div class="container">
    <!--El div que orderna los demás divs-->
    <div class='clearbox'></div>

    <!--El div que contiene el menú-->
    <div class="sidebar1">
        <?php
            include_once("public/menu/menu.php");
        ?>
        <div style="text-align: right; position:absolute; margin-top: -2%; margin-left: 67%;">
            <?php
                $login = $this->session->userdata("usuario");

                if(empty($login)){
                    redirect(site_url("backend/index/login"), 301);
                }
            
                echo "<b>Usuario:</b> ".$this->session->userdata("usuario");
            ?>
        </div>
    </div>
        
    <!--El div contenedor, donde se presentan todos los formularios-->
    <div class="content">
        <?php echo $content_for_layout; ?>
    </div>
</div>

<div class="footer">
    <p><?php echo "Notificaci&oacute;n de la vigilancia epidemiol&oacute;gica, pertenece a la Direcci&oacute;n General de Epidemiolog&iacute;a del Ministerio de Salud del Per&uacute;.";?></p>
    <p><?php echo "Copyright (c) ".date("Y"). ". Todos los derechos reservados.";?></p>
</div>

</body>
</html>