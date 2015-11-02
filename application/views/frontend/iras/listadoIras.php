<?php
/******************************************  
*   REGISTRO SEMANAL NOTIFICACION IRAS    *
*******************************************/

//combo DIRESA

if($this->session->userdata('diresa') == ''){
	$subreg = $this->frontend_model->buscarDiresas();
	
	$diresa[''] = 'Seleccione ...';
	foreach ($subreg as $dato){
		$diresa[$dato->codigo] = $dato->nombre;
	}
}else{
	if($this->input->post('diresa') == ''){
		$subreg = $this->frontend_model->mostrarDiresa($this->session->userdata('diresa'));
		//$diresa[''] = 'Seleccione ...';
		foreach ($subreg as $dato){
			$diresa[$dato->codigo] = $dato->nombre;
		}
	}else{
		$subreg = $this->frontend_model->mostrarDiresa($this->input->post('diresa'));
		foreach ($subreg as $dato){
			$diresa[$dato->codigo] = $dato->nombre;
		}
	}
}

//combo Red

if($this->session->userdata('red') != ''){
	$red = $this->frontend_model->mostrarRed($this->session->userdata('diresa'),$this->session->userdata('red'));
	//$redes[''] = 'Seleccione ...';
	foreach ($red as $dato){
		$redes[$dato->codigo] = $dato->nombre;
	}
}else{
	if($this->input->post('red') == ''){
		$red = $this->frontend_model->buscarRedes($this->session->userdata('diresa'));
		$redes[''] = 'Seleccione ...';
		foreach ($red as $dato){
			$redes[$dato->codigo] = $dato->nombre;
		}
	}else{
		$red = $this->frontend_model->buscarRedes($this->input->post('diresa'));
		$redes[''] = 'Seleccione ...';
		foreach ($red as $dato){
			$redes[$dato->codigo] = $dato->nombre;
		}
	}
}

//combo Microred

if($this->session->userdata('microred') != ''){
	$mred = $this->frontend_model->mostrarMicrored($this->session->userdata('diresa'),$this->session->userdata('red'),$this->session->userdata('microred'));
	//$microred[''] = 'Seleccione ...';
	foreach ($mred as $dato){
		$microred[$dato->codigo] = $dato->nombre;
	}
}else{
	if($this->input->post('microred') == ''){
		$mred = $this->frontend_model->buscarMicroredes($this->session->userdata('diresa'),$this->session->userdata('red'));
		$microred[''] = 'Seleccione ...';
		foreach ($mred as $dato){
			$microred[$dato->codigo] = $dato->nombre;
		}
	}else{
		$mred = $this->frontend_model->buscarMicroredes($this->input->post('diresa'),$this->input->post('redes'));
		$microred[''] = 'Seleccione ...';
		foreach ($mred as $dato){
			$microred[$dato->codigo] = $dato->nombre;
		}
	}
}

//combo Establecimiento

if($this->session->userdata('establecimiento') != ''){
	$est = $this->frontend_model->mostrarEstablecimiento($this->session->userdata('establecimiento'));
	//$establec[''] = 'Seleccione ...';
	foreach ($est as $dato){
		$establec[$dato->cod_est] = $dato->raz_soc;
	}
}else{
	if($this->input->post('establec') == ''){
		$est = $this->frontend_model->buscarEstablec($this->session->userdata('diresa'),$this->session->userdata('red'),$this->session->userdata('microred'));
		$establec[''] = 'Seleccione ...';
		foreach ($est as $dato){
			$establec[$dato->cod_est] = $dato->raz_soc;
		}
	}else{
		$est = $this->frontend_model->buscarEstablec($this->input->post('diresa'),$this->input->post('redes'),$this->input->post('microred'));
		$establec[''] = 'Seleccione ...';
		foreach ($est as $dato){
			$establec[$dato->cod_est] = $dato->raz_soc;
		}
	}
}

//combo Departamentos

$depar = $this->frontend_model->buscarDepartamentos();

$departamento[''] = 'Seleccione ...';
foreach ($depar as $dato){
	$departamento[$dato->ubigeo] = $dato->nombre;
}

//combo Provincias

if($this->input->post('departamento') != ''){
	$prov = $this->frontend_model->buscarProvincias($this->input->post('departamento'));

	//$provincia[''] = 'Seleccione ...';
	foreach ($prov as $dato){
		$provincia[$dato->ubigeo] = $dato->nombre;
	}
}

//combo Distrito

if($this->input->post('provincia') != ''){
	$dist = $this->frontend_model->buscarDistritos($this->input->post('provincia'));

	//$distrito[''] = 'Seleccione ...';
	foreach ($dist as $dato){
		$distrito[$dato->ubigeo] = $dato->nombre;
	}
}

/////////////////////////

if($this->session->flashdata('exito') != ''){
	?>
	<div class="exitoFrontend"><?php echo $this->session->flashdata('exito'); ?></div>
	<?php
}
if($this->session->flashdata('error') != ''){
	?>
	<div class="errorFrontend"><?php echo $this->session->flashdata('error'); ?></div>
	<?php
}
if($this->session->flashdata('info') != ''){
	?>
	<div class="infoFrontend"><?php echo $this->session->flashdata('info'); ?></div>
	<?php
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
<?php 
foreach($css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
<?php foreach($js_files as $file): ?>
	<script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>
</head>
<div class="formulario">
    <center><h3 style="background-color:#CEE3F6;">REGISTRO SEMANAL DE NOTIFICACION DE LAS IRA's</h3></center>
	<?php
    $atributos = array('id'=>'form1', 'name'=>'form1');
    echo form_open(null, $atributos);
    ?>
	<table width="100%" style="font-size:10px; background-color:#CEE3F6;" align="center">    
    <tr>
    <td valign="middle" bgcolor="#CCCCCC"><strong>DIRESA</strong></td>
    <td valign="middle" bgcolor="#CCCCCC"><strong>RED</strong></td>
    <td valign="middle" bgcolor="#CCCCCC"><strong>MICRORED</strong></td>
    <td valign="middle" bgcolor="#CCCCCC" colspan="2"><strong>ESTABLECIMIENTO</strong></td>
    </tr>
    <tr>
    <td valign="middle">
    <?php echo form_error('diresa', '<div class="warning">', '</div>'); 
    //$diresa[''] = "Seleccione...";
    echo form_dropdown('diresa', $diresa, set_value('diresa'), 'id="diresa" style="width: 200px;"');
    ?>
    </td>
    <td valign="middle">
    <?php echo form_error('redes', '<div class="warning">', '</div>'); 
    //$redes[''] = "Seleccione...";
    echo form_dropdown('redes', $redes, set_value('redes'), 'id="redes" style="width: 215px;"');
    ?>
    </td>
    <td valign="middle">
    <?php echo form_error('microred', '<div class="warning">', '</div>'); 
    //$microred[''] = "Seleccione...";
    echo form_dropdown('microred', $microred, set_value('microred'), 'id="microred" style="width: 200px;"');
    ?>
    </td>
    <td valign="middle">
    <?php echo form_error('establec', '<div class="warning">', '</div>'); 
    //$establec[''] = "Seleccione...";
    echo form_dropdown('establec', $establec, set_value('establec'), 'id="establec" style="width: 250px;"');
    ?>
    </td>
    </tr>
    <tr>
    <td valign="middle" bgcolor="#CCCCCC"><strong>DEPARTAMENTO</strong></td>
    <td valign="middle" bgcolor="#CCCCCC"><strong>PROVINCIA</strong></td>
    <td valign="middle" bgcolor="#CCCCCC" colspan="2"><strong>DISTRITO</strong></td>
    </tr>
    <tr>
    <td valign="middle">
    <?php echo form_error('departamento', '<div class="warning">', '</div>'); 
    $departamento[''] = "Seleccione...";
    echo form_dropdown('departamento', $departamento, set_value('departamento'), 'id="departamento" style="width: 200px;"');
    ?>
    </td>
    <td valign="middle">
    <?php echo form_error('provincia', '<div class="warning">', '</div>'); 
    $provincia[''] = "Seleccione...";
    echo form_dropdown('provincia', $provincia, set_value('provincia'), 'id="provincia" style="width: 200px;"');
    ?>
    </td>
    <td valign="middle">
    <?php echo form_error('distrito', '<div class="warning">', '</div>'); 
    $distrito[''] = "Seleccione...";
    echo form_dropdown('distrito', $distrito, set_value('distrito'), 'id="distrito" style="width: 200px;"');
    ?>
    </td>
    </tr>
    <tr>
    <td valign="middle" bgcolor="#CCCCCC"><strong>A&Ntilde;O</strong></td>
    <td valign="middle" bgcolor="#CCCCCC" colspan="3"><strong>SEMANA</strong></td>
    </tr>
    <tr>
    <td>
    <?php echo form_error('ano', '<div class="warning">', '</div>'); ?> 
    <input name="ano" type="text" id="ano" value="<?php echo date('Y');?>" size='20' />
    </td>
    <td>
    <?php echo form_error('semana', '<div class="warning">', '</div>'); ?> 
    <input name="semana" type="text" id="semana" value="<?php echo date('W')-1;?>" size='20' />
    </td>
    <td>
    <input type="submit" id="botonBuscar" name="enviar" value="Filtrar" title="Procesa el filtro de registros por los datos solicitados" />
    <input type="button" id="botonAnadir" name="aceptar" value="A&ntilde;adir" title="Ingresar un nuevo registro" onclick="window.location='<?php echo site_url('iras/regIras'); ?>'" />
    </td>
    </tr>
    </table>
	<?php
    echo form_close();
    ?>
    <div style="position:relative; font-size:10px; width:100%;">
	<?php echo $output; ?>
    </div>
</div>
</body>
</html>