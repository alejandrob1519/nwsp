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
<div style="width: 100%; height: 575px; margin-left:auto; margin-right:auto; overflow: auto;">
<table width="70%" style="font-size:12px; background-color:#FFFCCC; margin-left:auto; margin-right:auto;">
<tr><td colspan="6">&nbsp;</td></tr>
<tr>
<td colspan="6" valign="middle" align="center"><strong>FORMATO DE NOTIFICACION INDIVIDUAL DE DEFUNCIONES POR INFECCION RESPIRATORIA AGUDA Y/O NEUMONIA EN MENORES DE 5 A&Ntilde;OS</strong></td>
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
<td valign="middle" bgcolor="#CCCCCC"><strong>Fecha de Registro</strong></td>
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
<td>
<?php echo form_error('fecha_reg', '<div class="warning">', '</div>'); ?> 
<input name="fecha_reg" type="text" id="fecha_reg" tabindex="6" title="Ingrese la fecha de registro" value="<?php echo $this->fechas_model->modificarFechas($modificar->fecha_reg);?>" size='20' placeholder='Ejm. dd-mm-YYYY' />
</td>
</tr>
<tr><td colspan="6" valign="middle"><hr/></td></tr>
<tr>
<td colspan="6" valign="middle"><b>Identificaci&oacute;n del ni&ntilde;o/ni&ntilde;a fallecido</b></td>
</tr>
<tr><td colspan="6" valign="middle"><hr/></td></tr>
<tr>
<td valign="middle" nowrap="nowrap" bgcolor="#CCCCCC"><strong>Apellido Paterno</strong></td>
<td>
<?php echo form_error('apepat', '<div class="warning">', '</div>'); ?> 
<input name="apepat" type="text" id="apepat" title="Ingrese el apellido paterno" value="<?php echo $modificar->apepat?>" onkeyup="javascript:this.value=this.value.toUpperCase();" tabindex="7" />
</td>
<td valign="middle" nowrap="nowrap" bgcolor="#CCCCCC"><strong>Apellido Materno</strong></td>
<td>
<?php echo form_error('apemat', '<div class="warning">', '</div>'); ?> 
<input name="apemat" type="text" id="apemat" title="Ingrese el apellido materno" value="<?php echo $modificar->apemat?>" onkeyup="javascript:this.value=this.value.toUpperCase();" tabindex="8" />
</td>
<td valign="middle" bgcolor="#CCCCCC"><strong>Nombres</strong></td>
<td>
<?php echo form_error('nombres', '<div class="warning">', '</div>'); ?> 
<input name="nombres" type="text" id="nombres" title="Ingrese los nombres" value="<?php echo $modificar->nombres?>" onkeyup="javascript:this.value=this.value.toUpperCase();" tabindex="9" />
</td>
<tr>
<td valign="middle" nowrap="nowrap" bgcolor="#CCCCCC"><strong>Sexo</strong></td>
<td valign="middle">
<?php 
$sexo = array("" => "Seleccione...", "M" => "Masculino", "F"=> "Femenino");
echo form_error('sexo', '<div class="warning">', '</div>'); 
echo form_dropdown('sexo', $sexo, $modificar->sexo, 'id="sexo" style="width: 150px;" tabindex="10"');
?>
</td>
<td valign="middle" bgcolor="#CCCCCC"><strong>Fecha de nacimiento</strong></td>
<td>
<?php echo form_error('fecha_nac', '<div class="warning">', '</div>'); ?> 
<input name="fecha_nac" type="text" id="fecha_nac" tabindex="11" title="Ingrese la fecha de nacimiento" value="<?php echo $this->fechas_model->modificarFechas($modificar->fecha_nac);?>" size='20' placeholder='Ejm. dd-mm-YYYY' />
</td>
</tr>
<tr>
<td valign="middle" bgcolor="#CCCCCC"><strong>Direcci&oacute;n habitual</strong></td>
<td colspan="5">
<?php echo form_error('direccion', '<div class="warning">', '</div>'); ?> 
<input name="direccion" type="text" id="direccion" title="Direcci&oacute;n habitual" value="<?php echo $modificar->direccion?>" size='71' onkeyup="javascript:this.value=this.value.toUpperCase();" tabindex="12" />
</td>
</tr>
<tr>
<td valign="middle" bgcolor="#CCCCCC"><strong>Departamento</strong></td>
<td valign="middle">
<?php echo form_error('departamento', '<div class="warning">', '</div>'); 
$departamento[''] = "Seleccione...";
foreach($this->mantenimiento_model->buscarDepartamentos() as $dato){
	$departamento[$dato->ubigeo] = $dato->nombre;
}

echo form_dropdown('departamento', $departamento, substr($modificar->ubigeo_res,0,2), 'id="departamento" style="width: 150px;" tabindex="13"');
?>
</td>
<td valign="middle" bgcolor="#CCCCCC"><strong>Provincia</strong></td>
<td valign="middle">
<?php echo form_error('provincia', '<div class="warning">', '</div>'); 
$provincia[''] = "Seleccione...";
echo form_dropdown('provincia', $prov, substr($modificar->ubigeo_res,0,4), 'id="provincia" style="width: 150px;" tabindex="14"');
?>
</td>
<td valign="middle" bgcolor="#CCCCCC"><strong>Distrito</strong></td>
<td valign="middle">
<?php echo form_error('distrito', '<div class="warning">', '</div>'); 
$distrito[''] = "Seleccione...";
echo form_dropdown('distrito', $dist, $modificar->ubigeo_res, 'id="distrito" style="width: 150px;" tabindex="15"');
?>
</td>
</tr>
<tr>
<td valign="middle" bgcolor="#CCCCCC"><strong>Zona</strong></td>
<td>
<?php 
$zona = array("" => "Seleccione...", "1" => "Zona Urbana", "2" => "Zona Rural");
echo form_error('zona', '<div class="warning">', '</div>'); 
echo form_dropdown('zona', $zona, $modificar->zona, 'id="zona" style="width: 150px;" tabindex="16"');
?>
</td>
<td valign="middle" bgcolor="#CCCCCC"><strong>Fecha de defunci&oacute;n</strong></td>
<td>
<?php echo form_error('fecha_def', '<div class="warning">', '</div>'); ?> 
<input name="fecha_def" type="text" id="fecha_def" tabindex="17" title="Ingrese la fecha de defunci&oacute;n" value="<?php echo $this->fechas_model->modificarFechas($modificar->fecha_def);?>" size='20' placeholder='Ejm. dd-mm-YYYY' />
</td>
<td valign="middle" bgcolor="#CCCCCC"><strong>Hora de defunci&oacute;n</strong></td>
<td>
<?php echo form_error('hora_def', '<div class="warning">', '</div>'); ?> 
<input name="hora_def" type="text" id="hora_def" title="Hora de defunci&oacute;n" value="<?php echo $modificar->hora_def?>" size="8" tabindex="18" placeholder="Ej. 99.99" />
</td>
</tr>
<tr><td colspan="6" valign="middle"><hr/></td></tr>
<tr>
<td colspan="6" valign="middle"><b>Lugar de defunci&oacute;n</b></td>
</tr>
<tr><td colspan="6" valign="middle"><hr/></td></tr>
<tr>
<td valign="middle" bgcolor="#CCCCCC"><strong>Departamento</strong></td>
<td valign="middle">
<?php echo form_error('departamento14_1', '<div class="warning">', '</div>'); 
$departamento14_1[''] = "Seleccione...";
foreach($this->mantenimiento_model->buscarDepartamentos() as $dato){
	$departamento14_1[$dato->ubigeo] = $dato->nombre;
}

echo form_dropdown('departamento14_1', $departamento14_1, substr($modificar->ubigeo_def,0,2), 'id="departamento14_1" style="width: 150px;" tabindex="19"');
?>
</td>
<td valign="middle" bgcolor="#CCCCCC"><strong>Provincia</strong></td>
<td valign="middle">
<?php echo form_error('provincia14_1', '<div class="warning">', '</div>'); 
$provincia14_1[''] = "Seleccione...";
echo form_dropdown('provincia14_1', $prov1, substr($modificar->ubigeo_def,0,4), 'id="provincia14_1" style="width: 150px;" tabindex="20"');
?>
</td>
<td valign="middle" bgcolor="#CCCCCC"><strong>Distrito</strong></td>
<td valign="middle">
<?php echo form_error('distrito14_1', '<div class="warning">', '</div>'); 
$distrito14_1[''] = "Seleccione...";
echo form_dropdown('distrito14_1', $dist1, $modificar->ubigeo_def, 'id="distrito14_1" style="width: 150px;" tabindex="21"');
?>
</td>
</tr>
<tr>
<td valign="middle" bgcolor="#CCCCCC"><strong>Lugar de Ocurrencia</strong></td>
<td>
<?php 
$lugar_def = array("" => "Seleccione...", "1" => "Casa", "2" => "Puesto de Salud", "3" => "Centro de Salud", "4" => "Hospital o Cl&iacute;nica con permanencia menos de 24 Horas", "5" => "Hospital o Cl&iacute;nica con permanencia m&aacute;s de 24 Horas", "6" => "Otro");
echo form_error('lugar_def', '<div class="warning">', '</div>'); 
echo form_dropdown('lugar_def', $lugar_def, $modificar->lugar_def, 'id="lugar_def" style="width: 150px;" tabindex="22"');
?>
</td>
<td valign="middle" bgcolor="#CCCCCC"><strong>Otro</strong></td>
<td>
<?php echo form_error('otro_def', '<div class="warning">', '</div>'); ?> 
<input name="otro_def" type="text" id="otro_def" title="Otro Lugar" value="<?php echo $modificar->otro_def?>" onkeyup="javascript:this.value=this.value.toUpperCase();" size="25" tabindex="23" />
</td>
</tr>
<tr><td colspan="6" valign="middle"><hr/></td></tr>
<tr>
<td colspan="6" valign="middle"><b>Datos acerca de atenci&oacute;n y acceso a servicios de salud</b></td>
</tr>
<tr><td colspan="6" valign="middle"><hr/></td></tr>
<tr>
<td colspan="2" valign="middle" bgcolor="#CCCCCC"><strong>&iquest;Qui&eacute;n cuidaba al ni&ntilde;o/ni&ntilde;a los &uacute;ltimos 30 d&iacute;as?</strong></td>
<td>
<?php 
$cuidador = array("" => "Seleccione...", "1" => "Madre", "2" => "Padre", "3" => "Abuela/o", "4" => "Hermana", "5" => "Otro");
echo form_error('cuidador', '<div class="warning">', '</div>'); 
echo form_dropdown('cuidador', $cuidador, $modificar->cuidador, 'id="cuidador" style="width: 150px;" tabindex="24"');
?>
</td>
<td valign="middle" bgcolor="#CCCCCC"><strong>Otro</strong></td>
<td>
<?php echo form_error('cuida_otro', '<div class="warning">', '</div>'); ?> 
<input name="cuida_otro" type="text" id="cuida_otro" title="Otro cuidador" value="<?php echo $modificar->cuida_otro?>" onkeyup="javascript:this.value=this.value.toUpperCase();" size="25" tabindex="25" />
</td>
</tr>
<tr>
<td valign="middle" bgcolor="#CCCCCC"><strong>Inicio de la enfermedad</strong></td>
<td>
<?php echo form_error('fecha_ini', '<div class="warning">', '</div>'); ?> 
<input name="fecha_ini" type="text" id="fecha_ini" tabindex="26" title="Ingrese la fecha de inicio de la enfermedad" value="<?php echo $this->fechas_model->modificarFechas($modificar->fecha_ini);?>" size='20' placeholder='Ejm. dd-mm-YYYY' />
</td>
<td valign="middle" bgcolor="#CCCCCC"><strong>&iquest;D&oacute;nde lo llev&oacute; primero?</strong></td>
<td>
<?php 
$lugar_atencion = array("" => "Seleccione...", "1" => "Puesto de Salud", "2" => "Centro de Salud", "3" => "Hospital", "4" => "Cl&iacute;nica privada", "5" => "Farmacia/Botica", "6" => "Curandero", "7" => "Otro");
echo form_error('lugar_atencion', '<div class="warning">', '</div>'); 
echo form_dropdown('lugar_atencion', $lugar_atencion, $modificar->lugar_atencion, 'id="lugar_atencion" style="width: 150px;" tabindex="27"');
?>
</td>
<td valign="middle" bgcolor="#CCCCCC"><strong>Otro</strong></td>
<td>
<?php echo form_error('otro_lugar', '<div class="warning">', '</div>'); ?> 
<input name="otro_lugar" type="text" id="otro_lugar" title="Otro Lugar" value="<?php echo $modificar->otro_lugar?>" onkeyup="javascript:this.value=this.value.toUpperCase();" tabindex="28" />
</td>
</tr>
<tr>
<td valign="middle" bgcolor="#CCCCCC"><strong>Primera atenci&oacute;n</strong></td>
<td>
<?php echo form_error('fecha_ate', '<div class="warning">', '</div>'); ?> 
<input name="fecha_ate" type="text" id="fecha_ate" tabindex="29" title="Ingrese la fecha de la primera atenci&oacute;n" value="<?php echo $this->fechas_model->modificarFechas($modificar->fecha_ate);?>" size='20' placeholder='Ejm. dd-mm-YYYY' />
</td>
<td valign="middle" bgcolor="#CCCCCC"><strong>&iquest;Le indicaron transferirlo?</strong></td>
<td>
<?php 
$gravedad_tran = array("" => "Seleccione...", "1" => "SI", "2" => "NO");
echo form_error('gravedad_tran', '<div class="warning">', '</div>'); 
echo form_dropdown('gravedad_tran', $gravedad_tran, $modificar->gravedad_tran, 'id="gravedad_tran" style="width: 150px;" tabindex="30"');
?>
</td>
<td valign="middle" bgcolor="#CCCCCC"><strong>&iquest;Acept&oacute; la transferencia?</strong></td>
<td>
<?php 
$acepto_tran = array("" => "Seleccione...", "1" => "SI", "2" => "NO");
echo form_error('acepto_tran', '<div class="warning">', '</div>'); 
echo form_dropdown('acepto_tran', $acepto_tran, $modificar->acepto_tran, 'id="acepto_tran" style="width: 150px;" tabindex="31"');
?>
</td>
<tr>
<td valign="middle" bgcolor="#CCCCCC"><strong>Fecha de la transferencia</strong></td>
<td>
<?php echo form_error('fecha_tra', '<div class="warning">', '</div>'); ?> 
<input name="fecha_tra" type="text" id="fecha_tra" tabindex="32" title="Ingrese la fecha de la transferencia" value="<?php echo $this->fechas_model->modificarFechas($modificar->fecha_tra);?>" size='20' placeholder='Ejm. dd-mm-YYYY' />
</td>
<td valign="middle" bgcolor="#CCCCCC"><strong>Hora de transferencia</strong></td>
<td>
<?php echo form_error('hora_tra', '<div class="warning">', '</div>'); ?> 
<input name="hora_tra" type="text" id="hora_tra" title="Hora de la transferencia" size="8" value="<?php echo $modificar->hora_tra?>" tabindex="33" placeholder="Ej. 99.99" />
</td>
</tr>
<tr>
<td valign="middle" bgcolor="#CCCCCC"><strong>Tipo de aseguramiento</strong></td>
<td>
<?php 
$seguro = array("" => "Seleccione...", "1" => "SIS", "2" => "ESSALUD", "3" => "FFAA/PNP", "4" => "Privado", "5" => "Otro", "6" => "No ten&iacute;a seguro");
echo form_error('seguro', '<div class="warning">', '</div>'); 
echo form_dropdown('seguro', $seguro, $modificar->seguro, 'id="seguro" style="width: 150px;" tabindex="34"');
?>
</td>
<td valign="middle" bgcolor="#CCCCCC"><strong>Otro</strong></td>
<td>
<?php echo form_error('otro_seguro', '<div class="warning">', '</div>'); ?> 
<input name="otro_seguro" type="text" id="otro_seguro" title="Otro seguro" value="<?php echo $modificar->otro_seguro?>" onkeyup="javascript:this.value=this.value.toUpperCase();" tabindex="35" />
</td>
</tr>
<tr>
<td valign="middle" bgcolor="#CCCCCC"><strong>&iquest;Programa social?</strong></td>
<td>
<?php 
$programa = array("" => "Seleccione...", "1" => "Juntos", "2" => "Vaso de leche", "3" => "Otro");
echo form_error('programa', '<div class="warning">', '</div>'); 
echo form_dropdown('programa', $programa, $modificar->programa, 'id="programa" style="width: 150px;" tabindex="36"');
?>
</td>
<td valign="middle" bgcolor="#CCCCCC"><strong>Otro</strong></td>
<td>
<?php echo form_error('otro_programa', '<div class="warning">', '</div>'); ?> 
<input name="otro_programa" type="text" id="otro_programa" title="Otro programa" value="<?php echo $modificar->otro_programa?>" onkeyup="javascript:this.value=this.value.toUpperCase();" tabindex="37" />
</td>
</tr>
<tr><td colspan="6" valign="middle"><hr/></td></tr>
<tr>
<td colspan="6" valign="middle"><b>Vacunas</b></td>
</tr>
<tr><td colspan="6" valign="middle"><hr/></td></tr>
<tr>
<td valign="middle" bgcolor="#CCCCCC"><strong>Pentavalente</strong></td>
<td>
<?php 
$pentavalente = array("" => "Seleccione...", "1" => "1 Dosis", "2" => "2 Dosis", "3" => "Dosis completas");
echo form_error('pentavalente', '<div class="warning">', '</div>'); 
echo form_dropdown('pentavalente', $pentavalente, $modificar->pentavalente, 'id="pentavalente" style="width: 150px;" tabindex="38"');
?>
</td>
<td valign="middle" bgcolor="#CCCCCC"><strong>Neumococo</strong></td>
<td>
<?php 
$neumococo = array("" => "Seleccione...", "1" => "1 Dosis", "2" => "2 Dosis", "3" => "Dosis completas");
echo form_error('neumococo', '<div class="warning">', '</div>'); 
echo form_dropdown('neumococo', $neumococo, $modificar->neumococo, 'id="neumococo" style="width: 150px;" tabindex="39"');
?>
</td>
<td valign="middle" bgcolor="#CCCCCC"><strong>Influenza</strong></td>
<td>
<?php 
$influenza = array("" => "Seleccione...", "1" => "1 Dosis", "2" => "2 Dosis");
echo form_error('influenza', '<div class="warning">', '</div>'); 
echo form_dropdown('influenza', $influenza, $modificar->influenza, 'id="influenza" style="width: 150px;" tabindex="40"');
?>
</td>
</tr>
<tr><td colspan="6" valign="middle"><hr/></td></tr>
<tr>
<td colspan="6" valign="middle"><b>Estado Nutricional</b></td>
</tr>
<tr><td colspan="6" valign="middle"><hr/></td></tr>
<tr>
<td valign="middle" bgcolor="#CCCCCC"><strong>Talla</strong></td>
<td>
<?php echo form_error('talla', '<div class="warning">', '</div>'); ?> 
<input name="talla" type="text" id="talla" title="Talla" value="<?php echo $modificar->talla?>" size="10" tabindex="41" placeholder="Ej. 2.50 mt" />
</td>
<td valign="middle" bgcolor="#CCCCCC"><strong>Peso</strong></td>
<td>
<?php echo form_error('peso', '<div class="warning">', '</div>'); ?> 
<input name="peso" type="text" id="peso" title="Peso" value="<?php echo $modificar->peso?>" size="10" tabindex="42" placeholder="Ej. 2.50 Kgr." />
</td>
<td>
<?php 
$nutricion = array("" => "Seleccione...", "1" => "Eutr&oacute;fico", "2" => "Desnutrido");
echo form_error('nutricion', '<div class="warning">', '</div>'); 
echo form_dropdown('nutricion', $nutricion, $modificar->nutricion, 'id="nutricion" style="width: 150px;" tabindex="43"');
?>
</td>
<td>
<?php 
$tipo = array("" => "Seleccione...", "1" => "Agudo", "2" => "Cr&oacute;nico");
echo form_error('tipo', '<div class="warning">', '</div>'); 
echo form_dropdown('tipo', $tipo, $modificar->tipo, 'id="tipo" style="width: 100px;" tabindex="44"');
?>
</td>
</tr>
<tr>
<td valign="middle" bgcolor="#CCCCCC"><strong>Lactancia Exclusiva</strong></td>
<td>
<?php 
$lactancia = array("" => "Seleccione...", "1" => "6 meses", "2" => "2 a&ntilde;os", "3" => "Otro");
echo form_error('lactancia', '<div class="warning">', '</div>'); 
echo form_dropdown('lactancia', $lactancia, $modificar->lactancia, 'id="lactancia" style="width: 150px;" tabindex="45"');
?>
</td>
<td valign="middle" bgcolor="#CCCCCC"><strong>Otro</strong></td>
<td>
<?php echo form_error('otro_lactancia', '<div class="warning">', '</div>'); ?> 
<input name="otro_lactancia" type="text" id="otro_lactancia" title="Otro tipo de lactancia" value="<?php echo $modificar->otro_lactancia?>" onkeyup="javascript:this.value=this.value.toUpperCase();" tabindex="46" />
</td>
<td valign="middle" bgcolor="#CCCCCC"><strong>No. Controles CRED</strong></td>
<td>
<?php echo form_error('cred', '<div class="warning">', '</div>'); ?> 
<input name="cred" type="text" id="cred" title="No. controles CRED" value="<?php echo $modificar->cred?>" size="12" tabindex="47" />
</td>
</tr>
<tr><td colspan="6" valign="middle"><hr/></td></tr>
<tr>
<td valign="middle"><b>Atenci&oacute;n hospitalaria</b></td>
<td colspan="5">
<?php 
$hospital = array("" => "Seleccione...", "1" => "Si", "2" => "No");
echo form_error('hospital', '<div class="warning">', '</div>'); 
echo form_dropdown('hospital', $hospital, $modificar->hospital, 'id="hospital" style="width: 100px;" tabindex="48"');
?>
</td>
</tr>
<tr><td colspan="6" valign="middle"><hr/></td></tr>
<tr>
<td valign="middle" bgcolor="#CCCCCC"><strong>Ingreso a emergencia</strong></td>
<td>
<?php echo form_error('fecha_eme', '<div class="warning">', '</div>'); ?> 
<input name="fecha_eme" type="text" id="fecha_eme" tabindex="49" title="Ingrese la fecha de ingreso a emergencia" value="<?php echo $this->fechas_model->modificarFechas($modificar->fecha_eme);?>" size='20' placeholder='Ejm. dd-mm-YYYY' />
</td>
<td valign="middle" bgcolor="#CCCCCC"><strong>Hora</strong></td>
<td>
<?php echo form_error('hora_eme', '<div class="warning">', '</div>'); ?> 
<input name="hora_eme" type="text" id="hora_eme" title="Hora de ingreso a emergencia" value="<?php echo $modificar->hora_eme?>" size="10" tabindex="51" placeholder="Ej. 99.99" />
</td>
</tr>
<tr>
<td valign="middle" bgcolor="#CCCCCC"><strong>Ingreso a hospitalizaci&oacute;n</strong></td>
<td>
<?php echo form_error('fecha_hos', '<div class="warning">', '</div>'); ?> 
<input name="fecha_hos" type="text" id="fecha_hos" tabindex="52" title="Ingrese la fecha de ingreso a hospitalizaci&oacute;n" value="<?php echo $this->fechas_model->modificarFechas($modificar->fecha_hos);?>" size='20' placeholder='Ejm. dd-mm-YYYY' />
</td>
<td valign="middle" bgcolor="#CCCCCC"><strong>Hora</strong></td>
<td>
<?php echo form_error('hora_hos', '<div class="warning">', '</div>'); ?> 
<input name="hora_hos" type="text" id="hora_hos" title="Hora de ingreso a hospitalizaci&oacute;n" value="<?php echo $modificar->hora_hos?>" size="10" tabindex="53" placeholder="Ej. 99.99" />
</td>
</tr>
<tr>
<td valign="middle" bgcolor="#CCCCCC"><strong>Diagn&oacute;stico de Ingreso</strong></td>
<td colspan="2">
<?php echo form_error('dx1', '<div class="warning">', '</div>'); ?> 
<input name="dx1" type="text" id="dx1" title="Diagn&oacute;stico de Ingreso" value="<?php echo $modificar->dx1?>" onkeyup="javascript:this.value=this.value.toUpperCase();" size="45" tabindex="54" />
</td>
</tr>
<tr>
<td valign="middle">&nbsp;</td>
<td colspan="2">
<?php echo form_error('dx2', '<div class="warning">', '</div>'); ?> 
<input name="dx2" type="text" id="dx2" title="Diagn&oacute;stico de Ingreso" value="<?php echo $modificar->dx2?>" onkeyup="javascript:this.value=this.value.toUpperCase();" size="45" tabindex="55" />
</td>
</tr>
<tr>
<td valign="middle">&nbsp;</td>
<td colspan="2">
<?php echo form_error('dx3', '<div class="warning">', '</div>'); ?> 
<input name="dx3" type="text" id="dx3" title="Diagn&oacute;stico de Ingreso" value="<?php echo $modificar->dx3?>" onkeyup="javascript:this.value=this.value.toUpperCase();" size="45" tabindex="56" />
</td>
</tr>
<tr><td colspan="6" valign="middle"><hr/></td></tr>
<tr>
<td colspan="6" valign="middle"><b>Diagn&oacute;sticos Finales</b></td>
</tr>
<tr><td colspan="6" valign="middle"><hr/></td></tr>
<tr>
<td valign="middle" bgcolor="#CCCCCC"><strong>Causa B&aacute;sica</strong></td>
<td colspan="2">
<?php echo form_error('cbasica', '<div class="warning">', '</div>'); ?> 
<input name="cbasica" type="text" id="cbasica" title="Causa B&aacute;sica" value="<?php echo $modificar->cbasica?>" onkeyup="javascript:this.value=this.value.toUpperCase();" size="45" tabindex="57" />
</td>
</tr>
<tr>
<td valign="middle" bgcolor="#CCCCCC"><strong>Causa Intermedia</strong></td>
<td colspan="2">
<?php echo form_error('cintermedia', '<div class="warning">', '</div>'); ?> 
<input name="cintermedia" type="text" id="cintermedia" title="Causa Intermedia" value="<?php echo $modificar->cintermedia?>" onkeyup="javascript:this.value=this.value.toUpperCase();" size="45" tabindex="58" />
</td>
</tr>
<tr>
<td valign="middle" bgcolor="#CCCCCC"><strong>Causa Terminal</strong></td>
<td colspan="2">
<?php echo form_error('cterminal', '<div class="warning">', '</div>'); ?> 
<input name="cterminal" type="text" id="cterminal" title="Causa Terminal" value="<?php echo $modificar->cterminal?>" onkeyup="javascript:this.value=this.value.toUpperCase();" size="45" tabindex="59" />
</td>
</tr>
<tr>
<td colspan="6" align="right">
<input type="submit" id="botonGrabar" name="grabar" value="Grabar" title="Guardar los datos ingresados" />
<input type="button" id="botonBuscar" name="abrir" value="Listado" title="Buscar casos registrados" onclick="window.location='<?php echo site_url('modulos3/listarNeumonias'); ?>'" />
<input type="button" id="botonSalir" name="salir" value="Salir" title="Retornar a la p&aacute;gina principal" onclick="window.location='<?php echo site_url('index/principal'); ?>'" />
</td>
</tr>
</table>
</div>
<?php
echo form_close();
?>	