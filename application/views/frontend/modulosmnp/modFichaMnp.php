<?php
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
<div style="width: 100%; height: auto; margin-left:auto; margin-right:auto; overflow: auto;">
<table width="70%" style="font-size:12px; background-color:#FFFCCC; margin-left:auto; margin-right:auto;">
<tr><td colspan="6">&nbsp;</td></tr>
<tr>
<td  style="font-size:20px" colspan="6" valign="middle" align="center"><strong>FICHA DE NOTIFICACION DE MUERTE FETAL Y NEONATAL</strong></td>
</tr>
<tr>
<td  style="font-size:12px" colspan="6" valign="middle" align="center"><strong>SUBSISTEMA NACIONAL DE VIGILANCIA EPIDEMIOLOGICA PERINATAL Y NEONATAL</strong></td>
</tr>

<tr><td colspan="6">&nbsp;</td></tr>
<tr><td colspan="6" valign="middle"><hr/></td></tr>
<tr>
<td colspan="6" valign="middle"><b>Datos Generales del Establecimiento Notificante</b></td>
</tr>
<tr><td colspan="6" valign="middle"><hr/></td></tr>
<tr>
<td valign="middle" bgcolor="#CCCCCC"><strong>DIRESA</strong></td>
<td valign="middle" bgcolor="#CCCCCC"><strong>RED</strong></td>
<td valign="middle" bgcolor="#CCCCCC"><strong>MICRORED</strong></td>
<td valign="middle" bgcolor="#CCCCCC"><strong>Establecimiento</strong></td>
<td valign="middle" bgcolor="#CCCCCC"><strong>Instituci&oacute;n</strong></td>
<td valign="middle" bgcolor="#CCCCCC"><strong>A&ntilde;o de proceso - Semana </strong></td>
</tr>
<tr>
<td valign="middle">
<?php echo form_error('diresa', '<div class="warning">', '</div>'); 
echo form_dropdown('diresa', $subr, $modificar->diresa, 'id="diresa" style="width: 150px;" tabindex="1"');
?>
</td>
<td valign="middle">
<?php echo form_error('redes', '<div class="warning">', '</div>'); 
echo form_dropdown('redes', $red, $modificar->red, 'id="redes" style="width: 150px;" tabindex="2"');
?>
</td>
<td valign="middle">
<?php echo form_error('microred', '<div class="warning">', '</div>'); 
echo form_dropdown('microred', $mred, $modificar->microred, 'id="microred" style="width: 150px;" tabindex="3"');
?>
</td>
<td valign="middle">
<?php echo form_error('establec', '<div class="warning">', '</div>'); 
echo form_dropdown('establec', $est, $modificar->e_salud, 'id="establec" style="width: 200px;" tabindex="4"');
?>
</td>
<td valign="middle">
<input name="institucion" type="text" id="institucion" title="Ingrese la instituci&oacute;n" value="<?php echo $institucion;?>" size='25' tabindex="5" readonly="readonly" />
</td>
<td valign="middle">
<?php echo form_error('ano', '<div class="warning">', '</div>'); ?> 
<input name="ano" type="text" id="ano" title="A&ntilde;o de Proceso" value="<?php echo $modificar->anio?>" size="8"  readonly="readonly" tabindex="6" />
-
<?php echo form_error('semana', '<div class="warning">', '</div>'); ?> 
<input name="semana" type="text" id="semana" title="semana de Proceso" value="<?php echo $modificar->semana?>" size="2" readonly="readonly" tabindex="7" />
</td>
</tr>
<td valign="middle" bgcolor="#CCCCCC"><strong>Responsable : </strong></td>
<td colspan="5">
<?php echo form_error('responsabl', '<div class="warning">', '</div>'); ?> 
<input name="responsabl" type="text" id="responsabl" title="Nombre del Responsable" value="<?php echo $modificar->responsabl?>" size='126' onkeyup="javascript:this.value=this.value.toUpperCase();" tabindex="8" />
</td>
<tr><td colspan="6" valign="middle"><hr/></td></tr>
<tr>
<td colspan="6" valign="middle"><b>Datos del fallecido</b></td>
</tr>
<tr><td colspan="6" valign="middle"><hr/></td></tr>
<tr>
<td valign="middle" nowrap="nowrap" bgcolor="#CCCCCC"><strong>Apellido Paterno</strong></td>
<td>
<?php echo form_error('apepat', '<div class="warning">', '</div>'); ?> 
<input name="apepat" class="mayus" type="text" id="apepat" title="Ingrese el apellido paterno" value="<?php echo $modificar->apepat?>" tabindex="9" />
</td>
<td valign="middle" nowrap="nowrap" bgcolor="#CCCCCC"><strong>Apellido Materno</strong></td>
<td>
<?php echo form_error('apemat', '<div class="warning">', '</div>'); ?> 
<input name="apemat" type="text" id="apemat" title="Ingrese el apellido materno" value="<?php echo $modificar->apemat?>" class="mayus" tabindex="10" />
</td>
<td valign="middle" bgcolor="#CCCCCC"><strong>Nombres</strong></td>
<td>
<?php echo form_error('nombres', '<div class="warning">', '</div>'); ?> 
<input name="nombres" type="text" id="nombres" title="Ingrese los nombres" value="<?php echo $modificar->nombres?>" class="mayus" tabindex="11" />
</td>
<tr>
<td valign="middle" nowrap="nowrap" bgcolor="#CCCCCC"><strong>Sexo</strong></td>
<td valign="middle">
<?php 
$sexo = array("" => "Seleccione...", "M" => "Masculino", "F"=> "Femenino", "I"=> "Indeterminado");
echo form_error('sexo', '<div class="warning">', '</div>'); 
echo form_dropdown('sexo', $sexo, $modificar->sexo, 'id="sexo" style="width: 150px;" tabindex="12"');
?>
</td>
<td valign="middle" bgcolor="#CCCCCC"><strong>Edad Gestacional</strong></td>
<td>
<?php echo form_error('edadges', '<div class="warning">', '</div>'); ?> 
<input maxlength="2" name="edadges" type="text" id="edadges" tabindex="13" title="Ingrese la edad Gestacional x semana" value="<?php echo $modificar->edadges?>" size='10' onkeyup="javascript:this.value=this.value.toUpperCase();" />
Semana
</td>
<td valign="middle" bgcolor="#CCCCCC"><strong>Fecha de nacimiento</strong></td>
<td>
<?php echo form_error('fecha_nac', '<div class="warning">', '</div>'); ?> 
<input name="fecha_nac" type="text" id="fecha_nac" tabindex="14" title="Ingrese la fecha de nacimiento" value="<?php echo $this->fechas_model->modificarFechas($modificar->fecha_nac);?>" size='7' placeholder='Ejm. dd-mm-YYYY' />
-
<?php echo form_error('hora_nac', '<div class="warning">', '</div>'); ?> 
<input name="hora_nac" type="text" id="hora_nac" title="Hora de nacimiento" value="<?php echo $modificar->hora_nac?>" size="4" tabindex="15" placeholder="HH:MM" />
</td>
</tr>
<tr>
<td valign="middle" bgcolor="#CCCCCC"><strong>Fecha de defunci&oacute;n - Hora</strong></td>
<td>
<?php echo form_error('fecha_mte', '<div class="warning">', '</div>'); ?> 
<input name="fecha_mte" type="text" id="fecha_mte" tabindex="16" title="Ingrese la fecha de Muerte" value="<?php echo $this->fechas_model->modificarFechas($modificar->fecha_mte);?>" size='7' placeholder='Ejm. dd-mm-YYYY' />
-
<?php echo form_error('hora_mte', '<div class="warning">', '</div>'); ?> 
<input name="hora_mte" type="text" id="hora_mte" title="Hora de Muerte" value="<?php echo $modificar->hora_mte?>" size="4" tabindex="17" placeholder="HH:MM" />
</td>
<td valign="middle" bgcolor="#CCCCCC"><strong>Peso</strong></td>
<td>
<?php echo form_error('peso_nac', '<div class="warning">', '</div>'); ?> 
<input name="peso_nac" maxlength="5" type="text" id="peso_nac" title="Peso" value="<?php echo $modificar->peso_nac?>" onkeypress="return justNumbers(event);" size="10" tabindex="18" placeholder="Ej. 500gr." />
Gramos
</td>
<td valign="middle" bgcolor="#CCCCCC"><strong>Tipo de Muerte</strong></td>
<td>
<?php 
$tipo_mte = array("" => "Seleccione...", "F" => "Fetal", "N" => "Neonatal");
echo form_error('tipo_mte', '<div class="warning">', '</div>'); 
echo form_dropdown('tipo_mte', $tipo_mte, $modificar->tipo_mte, 'id="tipo_mte" style="width: 150px;" tabindex="19"');
?>
</td>
</td>
<tr><td colspan="6" valign="middle"><hr/></td></tr>
<tr>
<td colspan="6" valign="middle"><b>Datos de la Muerte</b></td>
</tr>
<tr><td colspan="6" valign="middle"><hr/></td></tr>
<td valign="middle" bgcolor="#CCCCCC"><strong>Causa de Muerte : </strong></td>
<td colspan="6">
<?php echo form_error('causa_bas', '<div class="warning">', '</div>'); ?> 
<input name="causa_ba" type="text" id="causa_ba" title="Ingresa Causa de Muerte" value="<?php echo $modificar->causa_bas?>"  size='126' tabindex="20" placeholder="Escribe Aqui" />
</td>
<tr><td colspan="6" valign="middle"><hr/></td></tr>
<td valign="middle" nowrap="nowrap" bgcolor="#CCCCCC"><strong>Diagnostico CIE10</strong></td>
<td>
<?php echo form_error('diagno', '<div class="warning">', '</div>'); ?> 
<input name="diagno" type="text" id="diagno" title="Ingrese Diagnostico" value="<?php echo $modificar->diagno?>" tabindex="21" readonly="readonly" />
</td>
<td valign="middle" nowrap="nowrap" bgcolor="#CCCCCC"><strong>Estancia en hospital</strong></td>
<td>
<?php echo form_error('estancia', '<div class="warning">', '</div>'); ?> 
<input name="estancia" type="text" id="estancia" title="Ingrese el Estancia en Hospital" value="<?php echo $modificar->estancia?>" onkeyup="javascript:this.value=this.value.toUpperCase();" tabindex="22" />
</td>
<td valign="middle" nowrap="nowrap" bgcolor="#CCCCCC"><strong>Dias de vida</strong></td>
<td>
<?php echo form_error('diasvid', '<div class="warning">', '</div>'); ?> 
<input name="diasvid" type="text" id="diasvid" title="Ingrese los Dias Vividos" value="<?php echo $modificar->vida?>" tabindex="23" />
</td>
<tr>
<td valign="middle" bgcolor="#CCCCCC"><strong>&iquest;Lugar del Parto?</strong></td>
<td>
<?php 
$lugar_par = array("" => "Seleccione...", "PI" => "PI - Parto institucional", "PD" => "PD - Parto domiciliario");
echo form_error('lugar_par', '<div class="warning">', '</div>'); 
echo form_dropdown('lugar_par', $lugar_par, $modificar->lugar_par, 'id="lugar_par" style="width: 170px;" tabindex="24"');
?>
</td>
<td valign="middle" bgcolor="#CCCCCC"><strong>&iquest;Momento?</strong></td>
<td>
<?php 
$momento = array("" => "Seleccione...", "1" => "1 - Ante - Parto", "2" => "2 - Intra - Parto", "3" => "3 - Post - Parto");
echo form_error('momento', '<div class="warning">', '</div>'); 
echo form_dropdown('momento', $momento, $modificar->momento, 'id="momento" style="width: 170px;" tabindex="25"');
?>
</td>
<td valign="middle" bgcolor="#CCCCCC"><strong>&iquest;Lugar de la Muerte?</strong></td>
<td>
<?php 
$lugar_mte = array("" => "Seleccione...", "ES" => "ES - Establecimiento de Salud", "CC" => "CC - Comunidad");
echo form_error('lugar_mte', '<div class="warning">', '</div>'); 
echo form_dropdown('lugar_mte', $lugar_mte, $modificar->lugar_mte, 'id="lugar_mte" style="width: 170px;" tabindex="26"');
?>
</tr>
<tr><td colspan="6" valign="middle"><hr/></td></tr>
<tr>
<td colspan="6" valign="middle"><b>Residencia Habitual de la Madre</b></td>
</tr>
<tr><td colspan="6" valign="middle"><hr/></td></tr>
<tr>
<td valign="middle" bgcolor="#CCCCCC"><strong>Departamento</strong></td>
<td valign="middle">
<?php echo form_error('departamento', '<div class="warning">', '</div>'); 
$departamento14_1[''] = "Seleccione...";
foreach($this->mantenimiento_model->buscarDepartamentos() as $dato){
	$departamento14_1[$dato->ubigeo] = $dato->nombre;
}

echo form_dropdown('departamento', $departamento14_1, substr($modificar->ubigeo_res,0,2), 'id="departamento14_1" style="width: 150px;" tabindex="27"');
?>
</td>
<td valign="middle" bgcolor="#CCCCCC"><strong>Provincia</strong></td>
<td valign="middle">
<?php echo form_error('provincia', '<div class="warning">', '</div>'); 
$provincia14_1[''] = "Seleccione...";
echo form_dropdown('provincia14_1', $prov1, substr($modificar->ubigeo_res,0,4), 'id="provincia14_1" style="width: 150px;" tabindex="28"');
?>
</td>
<td valign="middle" bgcolor="#CCCCCC"><strong>Distrito</strong></td>
<td valign="middle">
<?php echo form_error('distrito14_1', '<div class="warning">', '</div>'); 
$distrito14_1[''] = "Seleccione...";
echo form_dropdown('distrito14_1', $dist1, $modificar->ubigeo_res, 'id="distrito14_1" style="width: 150px;" tabindex="29"');
?>
</td>
</tr>
<tr><td colspan="6" valign="middle"><hr/></td></tr>
<tr>

</tr>
<tr>
<td valign="middle" bgcolor="#CCCCCC"><strong>DNI de la Madre</strong></td>
<td valign="middle">
<?php echo form_error('dni_madre', '<div class="entero">', '</div>'); ?> 
<input maxlength="8" name="dni_madre" type="text" id="dni_madre" tabindex="30" title="Ingrese la edad Gestacional x semana" value="<?php echo $modificar->dni_madre?>" size='10' onkeypress="return justNumbers(event);"  />
</td>
<td valign="middle" nowrap="nowrap" bgcolor="#CCCCCC"><strong>Nombre del Hijo :</strong></td>
<td colspan="3">
<?php echo form_error('ape_nom', '<div class="warning">', '</div>'); ?> 
<input name="ape_nom" class="mayus" type="text" id="ape_nom" title="Nombre del Fallecido" value="<?php echo $modificar->ape_nom?>" size='81'  tabindex="32" readonly="readonly" />
</td>
</tr>
<tr><td colspan="6" valign="middle"><hr/></td></tr>
<td valign="middle" bgcolor="#CCCCCC"><strong>Categoria : </strong></td>
<td colspan="6">
<?php echo form_error('categoria', '<div class="warning">', '</div>'); ?> 
<input name="codcat" type="text" id="codcat" title="codigo de categoria" value="<?php echo $modificar->codcat?>" size="8"  tabindex="33" placeholder="" readonly="readonly" />
-
<input name="categoria" type="text" id="categoria" title="Ingresa Categoria" value="<?php echo $modificar->categoria?>"  size='53' tabindex="34" readonly="readonly" />
</td>
<tr>
<td colspan="6" align="right">
<input type="submit" id="botonGrabar" name="grabar" value="Grabar" title="Guardar los datos ingresados" />
<input type="button" id="botonBuscar" name="abrir" value="Listado" title="Buscar casos registrados" onclick="window.location='<?php echo site_url('modulosmnp/listarMnp'); ?>'" />
<input type="button" id="botonSalir" name="salir" value="Salir" title="Retornar a la p&aacute;gina principal" onclick="window.location='<?php echo site_url('mnp/principal'); ?>'" />
</td>
</tr>
</table>
</div>
<?php
echo form_close();
?>	