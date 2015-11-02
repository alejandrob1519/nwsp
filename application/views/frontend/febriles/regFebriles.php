<?php
/************************************************* 
*   REGISTRO SEMANAL NOTIFICACION DE FEBRILES    *
**************************************************/
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
<BR /><BR />
<table width="100%" style="font-size:12px; background-color:#CEE3F6;" align="center">
<tr>
<td colspan="9" valign="middle"><strong>REGISTRO SEMANAL DE LA NOTIFICACION DE CASOS FEBRILES</strong></td>
</tr>
<tr><td colspan="9" valign="middle"><hr/></td></tr>
<tr>
<td colspan="9" valign="middle">Notificaci&oacute;n</td>
</tr>
<tr>
<td valign="middle" bgcolor="#CCCCCC"><strong>A&ntilde;o</strong></td>
<td>
<?php echo form_error('ano', '<div class="warning">', '</div>'); 
$sem = date("W") - 2;
$ano = date("Y");
if(date("W") - 2 <= 0){
	$ano = date("Y")-1;
	$sem = 53;
}
?> 
<input name="ano" type="text" id="ano" value="<?php if(!$this->input->post()){ echo $ano; }else{ echo set_value('ano');}?>" size='10' tabindex="1" />
</td>
<td valign="middle" bgcolor="#CCCCCC"><strong>Semana</strong></td>
<td>
<?php echo form_error('semana', '<div class="warning">', '</div>'); ?>
<input name="semana" type="text" id="semana" value="<?php if(!$this->input->post()){ echo $sem; }else{ echo set_value('semana'); }?>" size='10' tabindex="2" />
</td>
<td valign="middle" bgcolor="#CCCCCC"><strong>Fecha de atenci&oacute;n</strong></td>
<td>
<?php echo form_error('fecha_ate', '<div class="warning">', '</div>'); ?> 
<input name="fecha_ate" type="text" id="fecha_ate" tabindex="3" title="Ingrese la fecha de atenci&oacute;n del registro" value="<?php echo set_value('fecha_ate')?>" size='27' placeholder='Ejm. dd-mm-YYYY' />
</td>
<td valign="middle" bgcolor="#CCCCCC"><strong>Fecha de notificaci&oacute;n</strong></td>
<td>
<?php echo form_error('fecha_not', '<div class="warning">', '</div>'); ?> 
<input name="fecha_not" type="text" id="fecha_not" tabindex="4" title="Ingrese la fecha de notificaci&oacute;n del registro" value="<?php echo set_value('fecha_not')?>" size='27' placeholder='Ejm. dd-mm-YYYY' />
</td>
</tr>
<tr>
<td colspan="5" valign="middle">Establecimiento notificante</td>
</tr>
<tr>
<td valign="middle" bgcolor="#CCCCCC"><strong>DIRESA</strong></td>
<td valign="middle">
<?php echo form_error('diresa', '<div class="warning">', '</div>'); 
//$diresa[''] = "Seleccione...";
echo form_dropdown('diresa', $diresa, set_value('diresa'), 'id="diresa" style="width: 160px;" tabindex="5"');
?>
</td>
<td valign="middle" bgcolor="#CCCCCC"><strong>RED</strong></td>
<td valign="middle">
<?php echo form_error('redes', '<div class="warning">', '</div>'); 
//$redes[''] = "Seleccione...";
echo form_dropdown('redes', $redes, set_value('redes'), 'id="redes" style="width: 200px;" tabindex="6"');
?>
</td>
<td valign="middle" bgcolor="#CCCCCC"><strong>MICRORED</strong></td>
<td valign="middle">
<?php echo form_error('microred', '<div class="warning">', '</div>'); 
//$microred[''] = "Seleccione...";
echo form_dropdown('microred', $microred, set_value('microred'), 'id="microred" style="width: 200px;" tabindex="7"');
?>
</td>
<td valign="middle" bgcolor="#CCCCCC"><strong>ESTABLECIMIENTO</strong></td>
<td valign="middle">
<?php echo form_error('establec', '<div class="warning">', '</div>'); 
//$establec[''] = "Seleccione...";
echo form_dropdown('establec', $establec, set_value('establec'), 'id="establec" style="width: 200px;" tabindex="8"');
?>
</td>
</tr>
<tr>
<td colspan="9" valign="middle">Lugar probable de infecci&oacute;n</td>
</tr>
<tr>
<td valign="middle" bgcolor="#CCCCCC"><strong>Departamento</strong></td>
<td valign="middle">
<?php echo form_error('departamento', '<div class="warning">', '</div>'); 
$departamento[''] = "Seleccione...";
echo form_dropdown('departamento', $departamento, set_value('departamento'), 'id="departamento" style="width: 160px;" tabindex="9"');
?>
</td>
<td valign="middle" bgcolor="#CCCCCC"><strong>Provincia</strong></td>
<td valign="middle">
<?php echo form_error('provincia', '<div class="warning">', '</div>'); 
$provincia[''] = "Seleccione...";
echo form_dropdown('provincia', $provincia, set_value('provincia'), 'id="provincia" style="width: 200px;" tabindex="10"');
?>
</td>
<td valign="middle" bgcolor="#CCCCCC"><strong>Distrito</strong></td>
<td valign="middle">
<?php echo form_error('distrito', '<div class="warning">', '</div>'); 
$distrito[''] = "Seleccione...";
echo form_dropdown('distrito', $distrito, set_value('distrito'), 'id="distrito" style="width: 200px;" onchange="duplicadoDFebriles();" tabindex="11"');
?>
</td>
</tr>
</table>
<table width="100%" style="font-size:12px; background-color:#CEE3F6;" align="center">
<tr><td colspan="7" valign="middle"><hr/></td></tr>
<tr>
<td colspan="7" valign="middle">Distribuci&oacute;n de casos seg&uacute;n ciclos de vida</td>
</tr>
<tr>
<td valign="middle" bgcolor="#CCCCCC"><center><strong>< 1 a&ntilde;os</strong></center></td>
<td valign="middle" bgcolor="#CCCCCC"><center><strong>1 a 4 a&ntilde;os</strong></center></td>
<td valign="middle" bgcolor="#CCCCCC"><center><strong>5 a 9 a&ntilde;os</strong></center></td>
<td valign="middle" bgcolor="#CCCCCC"><center><strong>10 a 19 a&ntilde;os</strong></center></td>
<td valign="middle" bgcolor="#CCCCCC"><center><strong>20 a 59 a&ntilde;os</strong></center></td>
<td valign="middle" bgcolor="#CCCCCC"><center><strong>60 a +</strong></center></td>
<td valign="middle" bgcolor="#CCCCCC"><center><strong>Total Febriles</strong></center></td>
</tr>
<tr>
<td align="center">
<?php echo form_error('feb_m1', '<div class="warning">', '</div>'); ?> 
<input name="feb_m1" type="text" id="feb_m1" title="febriles en menores de < 1 a&ntilde;o" value="<?php echo set_value('feb_m1')?>" size='10' tabindex="12" onblur="sumaFebriles()" />
</td>
<td align="center">
<?php echo form_error('feb_1_4', '<div class="warning">', '</div>'); ?> 
<input name="feb_1_4" type="text" id="feb_1_4" title="febriles en menores de 1 a 4 a&ntilde;os" value="<?php echo set_value('feb_1_4')?>" size='10' tabindex="14" onFocus="sumaFebriles()" />
</td>
<td align="center">
<?php echo form_error('feb_5_9', '<div class="warning">', '</div>'); ?> 
<input name="feb_5_9" type="text" id="feb_5_9" title="febriles de 5 a 9 a&ntilde;os" value="<?php echo set_value('feb_5_9')?>" size='10' tabindex="15" onFocus="sumaFebriles()" />
</td>
<td align="center">
<?php echo form_error('feb_10_19', '<div class="warning">', '</div>'); ?> 
<input name="feb_10_19" type="text" id="feb_10_19" title="febriles de 5 a 9 a&ntilde;os" value="<?php echo set_value('feb_10_19')?>" size='10' tabindex="16" onFocus="sumaFebriles()" />
</td>
<td align="center">
<?php echo form_error('feb_20_59', '<div class="warning">', '</div>'); ?> 
<input name="feb_20_59" type="text" id="feb_20_59" title="febriles de 20 a 59 a&ntilde;os" value="<?php echo set_value('feb_20_59')?>" size='10' tabindex="17" onFocus="sumaFebriles()" />
</td>
<td align="center">
<?php echo form_error('feb_m60', '<div class="warning">', '</div>'); ?> 
<input name="feb_m60" type="text" id="feb_m60" title="febriles en mayores de 60 a&ntilde;os" value="<?php echo set_value('feb_m60')?>" size='10' tabindex="18" onFocus="sumaFebriles()" />
</td>
<td align="center">
<?php echo form_error('feb_tot', '<div class="warning">', '</div>'); ?> 
<input name="feb_tot" type="text" id="feb_tot" title="Total de febriles" value="<?php echo set_value('feb_tot')?>" size='10' tabindex="19" onFocus="sumaFebriles()" />
</td>
</tr>
<tr>
<tr>
<td valign="middle" bgcolor="#CCCCCC"><center><strong>Total Atenciones en EESS.</strong></center></td>
<td align="center">
<?php echo form_error('tot_aten', '<div class="warning">', '</div>'); ?> 
<input name="tot_aten" type="text" id="tot_aten" title="Total de atenciones en el EESS" value="<?php echo set_value('tot_aten')?>" size='10' tabindex="20" />
</td>
</tr>
<tr><td colspan="7" valign="middle"><hr/></td></tr>
<tr>
<td colspan="7" align="right">
<!--<input type="button" id="botonListado" name="nuevo" value="Nuevo" title="Registrar nuevo caso" disabled="disabled" />
--><input type="submit" id="botonGrabar" name="grabar" value="Grabar" title="Guardar los datos ingresados" />
<input type="button" id="botonBuscar" name="abrir" value="Abrir" title="Buscar casos registrados" onclick="window.location='<?php echo site_url('febriles/listadoFebriles'); ?>'" />
<input type="button" id="botonSalir" name="salir" value="Salir" title="Retornar a la p&aacute;gina principal" onclick="window.location='<?php echo site_url('index/principal'); ?>'" />
</td>
</tr>
</table>
<?php
echo form_close();
?>	