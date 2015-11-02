<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->layout->getTitle(); ?></title>
<meta name="description" content="<?php echo $this->layout->getDescripcion(); ?>">
<meta name="keywords" content="<?php echo $this->layout->getKeywords(); ?>" />
<link href="<?php echo base_url()?>public/css/index.css" rel='stylesheet' type='text/css' media='all' />

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
	<div class="titulo"><p>Vigilancia Epidemiol&oacute;gica</p></div>
</div>
<div class="container">
    <div class="content1"><?php echo $content_for_layout; ?></div>
</div>
<div class="footer">
    <p><?php echo "Copyright (c) ".date("Y").", Notificaci&oacute;n pertenece a la Direcci&oacute;n General de Epidemiolog&iacute;a del Ministerio de Salud del Per&uacute;, todos los derechos reservados.";?></p>
</div>
</body>
</html>