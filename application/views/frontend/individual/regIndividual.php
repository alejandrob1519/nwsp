<?php
/************************************************  
*   REGISTRO SEMANAL NOTIFICACION INDIVIDUAL    *
************************************************/
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
$atributos = array('id'=>'form1', 'name'=>'form1');
echo form_open(null, $atributos);
?>
<table width="70%" style="font-size:12px; background-color:#CEE3F6;" align="center">
<tr>
<td colspan="5" valign="middle"><strong>REGISTRO SEMANAL DE NOTIFICACION INDIVIDUAL</strong></td>
</tr>
<tr><td colspan="5" valign="middle"><hr/></td></tr>
<tr>
<td colspan="5" valign="middle">Datos de la notificaci&oacute;n</td>
</tr>
<tr>
<td colspan="5" valign="middle" bgcolor="#CCCCCC"><strong>Tipo de Vigilancia</strong></td>
</tr>
<tr>
<td valign="middle">
<?php echo form_error('vigilancias', '<div class="warning">', '</div>'); 
$vigilancias[''] = "Seleccione...";
echo form_dropdown('vigilancias', $vigilancias, 'P', 'id="vigilancias" style="width: 200px;" tabindex="1"');
?>
</td>
</tr>
<tr>
<td colspan="5" valign="middle">Establecimiento notificante</td>
</tr>
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
echo form_dropdown('diresa', $diresa, set_value('diresa'), 'id="diresa" style="width: 200px;" tabindex="2"');
?>
</td>
<td valign="middle">
<?php echo form_error('redes', '<div class="warning">', '</div>'); 
//$redes[''] = "Seleccione...";
echo form_dropdown('redes', $redes, set_value('redes'), 'id="redes" style="width: 215px;" tabindex="3"');
?>
</td>
<td valign="middle">
<?php echo form_error('microred', '<div class="warning">', '</div>'); 
//$microred[''] = "Seleccione...";
echo form_dropdown('microred', $microred, set_value('microred'), 'id="microred" style="width: 200px;" tabindex="4"');
?>
</td>
<td valign="middle">
<?php echo form_error('establec', '<div class="warning">', '</div>'); 
//$establec[''] = "Seleccione...";
echo form_dropdown('establec', $establec, set_value('establec'), 'id="establec" style="width: 250px;" tabindex="5"');
?>
</td>
</tr>
<tr>
<td colspan="2" valign="middle">Personal</td>
<td colspan="3" valign="middle">Lugar probable de infecci&oacute;n</td>
</tr>
<tr>
<td valign="middle" bgcolor="#CCCCCC"><strong>Apellido Paterno</strong></td>
<td>
<?php echo form_error('apepat', '<div class="warning">', '</div>'); ?> 
<input name="apepat" type="text" id="apepat" title="Ingrese el apellido paterno del paciente" value="<?php echo set_value('apepat')?>" onkeyup="javascript:this.value=this.value.toUpperCase();" size='30' tabindex="6" />
</td>
<td valign="middle" bgcolor="#CCCCCC"><strong>Selecci&oacute;n de pa&iacute;s</strong></td>
<td valign="middle">
<?php echo form_error('paises', '<div class="warning">', '</div>'); 
$paises[''] = "Seleccione...";
echo form_dropdown('paises', $paises, '171', 'id="paises" style="width: 200px;" tabindex="17"');
?>
</td>
</tr>
<tr>
<td valign="middle" bgcolor="#CCCCCC"><strong>Apellido Materno</strong></td>
<td>
<?php echo form_error('apemat', '<div class="warning">', '</div>'); ?> 
<input name="apemat" type="text" id="apemat" title="Ingrese el apellido materno del paciente" value="<?php echo set_value('apemat')?>" onkeyup="javascript:this.value=this.value.toUpperCase();" size='30' tabindex="7" />
</td>
<td valign="middle" bgcolor="#CCCCCC"><strong>Departamento</strong></td>
<td valign="middle">
<?php echo form_error('departamento', '<div class="warning">', '</div>'); 
$departamento[''] = "Seleccione...";
echo form_dropdown('departamento', $departamento, set_value('departamento'), 'id="departamento" style="width: 200px;" tabindex="18"');
?>
</td>
</tr>
<tr>
<td valign="middle" bgcolor="#CCCCCC"><strong>Nombres</strong></td>
<td>
<?php echo form_error('nombres', '<div class="warning">', '</div>'); ?> 
<input name="nombres" type="text" id="nombres" title="Ingrese los nombres del paciente" value="<?php echo set_value('nombres')?>" onkeyup="javascript:this.value=this.value.toUpperCase();" size='30' tabindex="8" />
</td>
<td valign="middle" bgcolor="#CCCCCC"><strong>Provincia</strong></td>
<td valign="middle">
<?php echo form_error('provincia', '<div class="warning">', '</div>'); 
$provincia[''] = "Seleccione...";
echo form_dropdown('provincia', $provincia, set_value('provincia'), 'id="provincia" style="width: 200px;" tabindex="19"');
?>
</td>
</tr>
<tr>
<td valign="middle" bgcolor="#CCCCCC"><strong>DNI</strong></td>
<td>
<?php echo form_error('dni', '<div class="warning">', '</div>'); ?> 
<input name="dni" type="text" id="dni" title="Ingrese el documento nacional de identidad del paciente" value="<?php echo set_value('dni')?>" onkeyup="javascript:this.value=this.value.toUpperCase();" size='30' tabindex="9" />
</td>
<td valign="middle" bgcolor="#CCCCCC"><strong>Distrito</strong></td>
<td valign="middle">
<?php echo form_error('distrito', '<div class="warning">', '</div>'); 
$distrito[''] = "Seleccione...";
echo form_dropdown('distrito', $distrito, set_value('distrito'), 'id="distrito" style="width: 200px;" tabindex="20"');
?>
</td>
</tr>
<tr>
<td valign="middle" bgcolor="#CCCCCC"><strong>Historia cl&iacute;nica</strong></td>
<td>
<?php echo form_error('historia', '<div class="warning">', '</div>'); ?> 
<input name="historia" type="text" id="historia" title="Ingrese la historia cl&iacute;nica del paciente" value="<?php echo set_value('historia')?>" onkeyup="javascript:this.value=this.value.toUpperCase();" size='30' tabindex="10" />
</td>
<td valign="middle" bgcolor="#CCCCCC"><strong>Localidad</strong></td>
<td valign="middle">
<?php echo form_error('localidad', '<div class="warning">', '</div>'); 
$localidad[''] = "Seleccione...";
echo form_dropdown('localidad', $localidad, set_value('localidad'), 'id="localidad" style="width: 200px;" tabindex="21"');
?>
</td>
</tr>
<tr>
<td valign="middle" bgcolor="#CCCCCC"><strong>Fecha hospitalizaci&oacute;n</strong></td>
<td>
<?php echo form_error('fecha_hos', '<div class="warning">', '</div>'); ?> 
<input name="fecha_hos" type="text" id="fecha_hos" tabindex="11" title="Ingrese la fecha de hospitalizaci&oacute;n del paciente" value="<?php echo set_value('fecha_hos')?>" size='30' placeholder='Ejm. dd-mm-YYYY' />
</td>
<td valign="middle" bgcolor="#CCCCCC"><strong>Etnia</strong></td>
<td valign="middle">
<?php echo form_error('etnias', '<div class="warning">', '</div>'); 
$etnias[''] = "Seleccione...";
echo form_dropdown('etnias', $etnias, set_value('etnias'), 'id="etnias" style="width: 200px;" tabindex="22"');
?>
</td>
</tr>
<tr>
<td valign="middle" bgcolor="#CCCCCC"><strong>Sexo</strong></td>
<td valign="middle">
<?php 
$sexo = array("" => "Seleccione...", "M" => "Masculino", "F"=> "Femenino");
echo form_error('sexo', '<div class="warning">', '</div>'); 
echo form_dropdown('sexo', $sexo, set_value('sexo'), 'id="sexo" style="width: 215px;" tabindex="12"');
?>
</td>
<td></td>
<td valign="middle">
<?php echo form_error('subetnias', '<div class="warning">', '</div>'); 
$subetnias[''] = "Seleccione...";
echo form_dropdown('subetnias', $subetnias, set_value('subetnias'), 'id="subetnias" style="width: 200px;" tabindex="23"');
?>
</td>
</tr>
<tr>
<td valign="middle" bgcolor="#CCCCCC"><strong>Edad</strong></td>
<td valign="middle">
<?php echo form_error('edad', '<div class="warning">', '</div>'); ?> 
<input name="edad" type="text" id="edad" title="Ingrese la edad del paciente" value="<?php echo set_value('edad')?>" onkeyup="javascript:this.value=this.value.toUpperCase();" size='10' tabindex="13" />
<?php 
$tipo = array("" => "Seleccione...", "A" => "A&ntilde;os", "M" => "Meses", "D" => "D&iacute;as");
echo form_error('tipo', '<div class="warning">', '</div>'); 
echo form_dropdown('tipo', $tipo, set_value('tipo'), 'id="tipo" style="width: 115px;" tabindex="14"');
?>
</td>
<td></td>
<td>
<?php echo form_error('otro', '<div class="warning">', '</div>'); ?> 
<input name="otro" type="text" id="otro" title="Otra etnia de procedencia del paciente" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo set_value('otro')?>" size='30' placeholder="Otra etnia" disabled="disabled" tabindex="24" />
</td>
</tr>
<tr>
<td valign="middle" bgcolor="#CCCCCC"><strong>Direcci&oacute;n</strong></td>
<td colspan="2">
<?php echo form_error('direccion', '<div class="warning">', '</div>'); ?> 
<input name="direccion" type="text" id="direccion" title="Ingrese la direcci&oacute;n del paciente" value="<?php echo set_value('direccion')?>" onkeyup="javascript:this.value=this.value.toUpperCase();" size='70' tabindex="15" />
</td>
<td valign="middle" bgcolor="#CCCCCC"><strong>Procedencia</strong></td>
<td>
<?php 
$zona = array("" => "Seleccione...", "1" => "Urbana", "2" => "Urbana Marginal", "3" => "Rural Campesina");
echo form_error('zona', '<div class="warning">', '</div>'); 
echo form_dropdown('zona', $zona, set_value('zona'), 'id="zona" style="width: 200px;" tabindex="16"');
?>
</td>
</tr>
<tr>
<td colspan="2" valign="middle">Diagn&oacute;stico</td>
<td colspan="2" valign="middle">Fechas y semanas epidemiol&oacute;gicas</td>
</tr>
<tr>
<td valign="middle" bgcolor="#CCCCCC"><strong>Diagn&oacute;stico</strong></td>
<td>
<?php 
echo form_error('diagno', '<div class="warning">', '</div>'); 
echo form_dropdown('diagno', $diagno, set_value('diagno'), 'id="diagno" style="width: 200px;" tabindex="25"');
?>
</td>
<td valign="middle" bgcolor="#CCCCCC"><strong>Inicio de s&iacute;ntomas</strong></td>
<td valign="middle" bgcolor="#CCCCCC"><strong>A&ntilde;o</strong></td>
<td valign="middle" bgcolor="#CCCCCC"><strong>Semana</strong></td>
</tr>
<tr>
<td valign="middle" bgcolor="#CCCCCC"><strong>Tipo de Diagn&oacute;stico</strong></td>
<td>
<?php 
echo form_error('tipoDx', '<div class="warning">', '</div>'); 
echo form_dropdown('tipoDx', $tipoDx, set_value('tipoDx'), 'id="tipoDx" style="width: 200px;" tabindex="26"');
?>
</td>
<td>
<?php echo form_error('fecha_ini', '<div class="warning">', '</div>'); ?> 
<input name="fecha_ini" type="text" id="fecha_ini" title="Ingrese la fecha de inicio de s&iacute;ntomas del paciente" value="<?php echo set_value('fecha_ini')?>" placeholder='Ejm. dd-mm-YYYY' size='30' onchange="anoInicio();" tabindex="28" />
</td>
<td>
<?php echo form_error('ano_ini', '<div class="warning">', '</div>'); ?> 
<input name="ano_ini" type="text" id="ano_ini" value="<?php echo set_value('ano_ini')?>" size='20' readonly="readonly" tabindex="29" />
</td>
<td>
<?php echo form_error('semana_ini', '<div class="warning">', '</div>'); ?> 
<input name="semana_ini" type="text" id="semana_ini" value="<?php echo set_value('semana_ini')?>" size='20' readonly="readonly" tabindex="30" />
</td>
</tr>
<tr>
<td valign="middle" bgcolor="#CCCCCC"><strong>Protegido</strong></td>
<td>
<?php 
$protegido = array("" => "Seleccione...", "S" => "Si", "N" => "No", "I" => "Ignorado");
echo form_error('protegido', '<div class="warning">', '</div>'); 
echo form_dropdown('protegido', $protegido, set_value('protegido'), 'id="protegido" style="width: 200px;" tabindex="27"');
?>
</td>
<td valign="middle" bgcolor="#CCCCCC"><strong>Defunci&oacute;n</strong></td>
<td valign="middle" bgcolor="#CCCCCC" colspan="2"><strong>Investigaci&oacute;n</strong></td>
</tr>
<tr>
<td valign="middle" bgcolor="#CCCCCC"><strong>Toma de muestra</strong></td>
<td>
<?php 
$muestra = array("" => "Seleccione...", "S" => "Si", "N" => "No", "I" => "Ignorado");
echo form_error('muestra', '<div class="warning">', '</div>'); 
echo form_dropdown('muestra', $muestra, set_value('muestra'), 'id="muestra" style="width: 200px;" tabindex="28"');
?>
</td>
<td>
<?php echo form_error('fecha_def', '<div class="warning">', '</div>'); ?> 
<input name="fecha_def" type="text" id="fecha_def" title="Ingrese la fecha de defunci&oacute; del paciente" value="<?php echo set_value('fecha_def')?>" placeholder='Ejm. dd-mm-YYYY' size='30' tabindex="31" />
</td>
<td>
<?php echo form_error('fecha_inv', '<div class="warning">', '</div>'); ?> 
<input name="fecha_inv" type="text" id="fecha_inv" title="Ingrese la fecha de investigaci&oacute;n del caso" value="<?php echo set_value('fecha_inv')?>" placeholder='Ejm. dd-mm-YYYY' size='30' tabindex="32" />
</td>
</tr>
<tr>
<td></td>
<td></td>
<td valign="middle" bgcolor="#CCCCCC"><strong>Notificaci&oacute;n</strong></td>
<td valign="middle" bgcolor="#CCCCCC"><strong>A&ntilde;o de notificaci&oacute;n</strong></td>
<td valign="middle" bgcolor="#CCCCCC"><strong>Semana de notificaci&oacute;n</strong></td>
</tr>
<tr>
<td></td>
<td></td>
<td>
<?php echo form_error('fecha_not', '<div class="warning">', '</div>'); ?> 
<input name="fecha_not" type="text" id="fecha_not" title="Ingrese la fecha de notificaci&oacute;n del caso" value="<?php echo set_value('fecha_not')?>" placeholder='Ejm. dd-mm-YYYY' size='30' onchange="anoNotificacion();" tabindex="33" />
</td>
<td>
<?php echo form_error('ano_not', '<div class="warning">', '</div>'); ?> 
<input name="ano_not" type="text" id="ano_not" value="<?php echo set_value('ano_not')?>" size='20' readonly="readonly" tabindex="34" />
</td>
<td>
<?php echo form_error('semana_not', '<div class="warning">', '</div>'); ?> 
<input name="semana_not" type="text" id="semana_not" value="<?php echo set_value('semana_not')?>" size='20' readonly="readonly" tabindex="35" />
</td>
</tr>
<tr><td colspan="5" valign="middle"><hr/></td></tr>
<tr>
<td colspan="5" align="right">
<!--<input type="button" id="botonListado" name="nuevo" value="Nuevo" title="Registrar nuevo caso" disabled="disabled" />
--><input type="submit" id="botonGrabar" name="grabar" value="Grabar" title="Guardar los datos ingresados" />
<input type="button" id="botonBuscar" name="abrir" value="Abrir" title="Buscar casos registrados" onclick="window.location='<?php echo site_url('individual/listadoIndividual'); ?>'" />
<input type="button" id="botonSalir" name="salir" value="Salir" title="Retornar a la p&aacute;gina principal" onclick="window.location='<?php echo site_url('index/principal'); ?>'" />
<input type="hidden" id="edadEnf" name="edadEnf" />
<input type="hidden" id="tedadEnf" name="tedadEnf" />
<input type="hidden" id="sexoEnf" name="sexoEnf" />
</td>
</tr>
</table>
<?php
echo form_close();
?>	