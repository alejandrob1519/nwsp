<?php
/******************************************  
*   REGISTRO SEMANAL NOTIFICACION IRAS    *
*******************************************/
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
<table width="100%" style="font-size:12px; background-color:#CEE3F6;" align="center">
<tr>
<td colspan="9" valign="middle"><strong>REGISTRO SEMANAL DE LA NOTIFICACION DE LAS INFECCIONES RESPIRATORIAS AGUDAS - IRA's</strong></td>
</tr>
<tr><td colspan="9" valign="middle"><hr/></td></tr>
<tr>
<td colspan="9" valign="middle">Notificaci&oacute;n</td>
</tr>
<tr>
<td valign="middle" bgcolor="#CCCCCC"><strong>A&ntilde;o</strong></td>
<td>
<?php echo form_error('ano', '<div class="warning">', '</div>'); ?> 
<input name="ano" type="text" id="ano" value="<?php echo $modificar->ano;?>" size='10' tabindex="1" />
</td>
<td valign="middle" bgcolor="#CCCCCC"><strong>Semana</strong></td>
<td>
<?php echo form_error('semana', '<div class="warning">', '</div>'); ?> 
<input name="semana" type="text" id="semana" value="<?php echo $modificar->semana;?>" size='10' tabindex="2" />
</td>
</tr>
<tr>
<td valign="middle" bgcolor="#CCCCCC"><strong>Etnia</strong></td>
<td valign="middle">
<?php echo form_error('etnias', '<div class="warning">', '</div>'); 
$etnias[''] = "Seleccione...";
echo form_dropdown('etnias', $etnias, $modificar->etniaproc, 'id="etnias" style="width: 160px;" tabindex="3"');
?>
</td>
<td valign="middle">
<?php echo form_error('subetnias', '<div class="warning">', '</div>'); 
$subetnias[''] = "Seleccione...";
echo form_dropdown('subetnias', $subetnias, $modificar->etnias, 'id="subetnias" style="width: 200px;" tabindex="4"');
?>
</td>
<td>
<?php echo form_error('otro', '<div class="warning">', '</div>'); ?> 
<input name="otro" type="text" id="otro" title="Otra etnia de procedencia del paciente" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $modificar->otroproc;?>" size='20' placeholder="Otra etnia" disabled="disabled" tabindex="4" />
</td>
<td valign="middle" bgcolor="#CCCCCC"><strong>Procedencia</strong></td>
<td>
<?php 
$zona = array("" => "Seleccione...", "1" => "Urbana", "2" => "Urbana Marginal", "3" => "Rural Campesina");
echo form_error('zona', '<div class="warning">', '</div>'); 
echo form_dropdown('zona', $zona, $modificar->procede, 'id="zona" style="width: 200px;" tabindex="5"');
?>
</td>
</tr>
<tr>
<td colspan="5" valign="middle">Establecimiento notificante</td>
</tr>
<tr>
<td valign="middle" bgcolor="#CCCCCC"><strong>DIRESA</strong></td>
<td valign="middle">
<?php echo form_error('diresa', '<div class="warning">', '</div>'); 
$diresa[''] = "Seleccione...";
echo form_dropdown('diresa', $diresa, $modificar->sub_reg_nt, 'id="diresa" style="width: 160px;" tabindex="6"');
?>
</td>
<td valign="middle" bgcolor="#CCCCCC"><strong>RED</strong></td>
<td valign="middle">
<?php echo form_error('redes', '<div class="warning">', '</div>'); 
$redes[''] = "Seleccione...";
echo form_dropdown('redes', $redes, $modificar->red, 'id="redes" style="width: 200px;" tabindex="7"');
?>
</td>
<td valign="middle" bgcolor="#CCCCCC"><strong>MICRORED</strong></td>
<td valign="middle">
<?php echo form_error('microred', '<div class="warning">', '</div>'); 
$microred[''] = "Seleccione...";
echo form_dropdown('microred', $microred, $modificar->microred, 'id="microred" style="width: 200px;" tabindex="8"');
?>
</td>
<td valign="middle" bgcolor="#CCCCCC"><strong>ESTABLECIMIENTO</strong></td>
<td valign="middle">
<?php echo form_error('establec', '<div class="warning">', '</div>'); 
$establec[''] = "Seleccione...";
echo form_dropdown('establec', $establec, $modificar->e_salud, 'id="establec" style="width: 200px;" tabindex="9"');
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
echo form_dropdown('departamento', $departamento, substr( $modificar->ubigeo,0,2), 'id="departamento" style="width: 160px;" tabindex="10"');
?>
</td>
<td valign="middle" bgcolor="#CCCCCC"><strong>Provincia</strong></td>
<td valign="middle">
<?php echo form_error('provincia', '<div class="warning">', '</div>'); 
$provincia[''] = "Seleccione...";
echo form_dropdown('provincia', $provincia, substr( $modificar->ubigeo,0,4), 'id="provincia" style="width: 200px;" tabindex="11"');
?>
</td>
<td valign="middle" bgcolor="#CCCCCC"><strong>Distrito</strong></td>
<td valign="middle">
<?php echo form_error('distrito', '<div class="warning">', '</div>'); 
$distrito[''] = "Seleccione...";
echo form_dropdown('distrito', $distrito, $modificar->ubigeo, 'id="distrito" style="width: 200px;" tabindex="12"');
?>
</td>
</tr>
</table>
<table width="100%" style="font-size:12px; background-color:#CEE3F6;" align="center">
<tr><td colspan="8" valign="middle"><hr/></td></tr>
<td valign="middle" bgcolor="#CCCCCC"><strong>Grupo Edad</strong></td>
<td valign="middle" bgcolor="#CCCCCC"><center><strong>IRAS</strong></center></td>
<td valign="middle" bgcolor="#CCCCCC"><center><strong>NEUMONIAS</strong></center></td>
<td valign="middle" bgcolor="#CCCCCC"><center><strong>NEUM. GRAVE</strong></center></td>
<td valign="middle" bgcolor="#CCCCCC"><center><strong>HOSPITALIZADOS</strong></center></td>
<td valign="middle" bgcolor="#CCCCCC"><center><strong>DEF. INTRAHOSPITALARIAS</strong></center></td>
<td valign="middle" bgcolor="#CCCCCC"><center><strong>DEF. EXTRAHOSPITALARIAS</strong></center></td>
<td valign="middle" bgcolor="#CCCCCC"><center><strong>SOB/ASMA</strong></center></td>
</tr>
<tr>
<td valign="middle" bgcolor="#CCCCCC"><strong>Menores de 2 meses</strong></td>
<td align="center">
<?php echo form_error('ira_m2', '<div class="warning">', '</div>'); ?> 
<input name="ira_m2" type="text" id="ira_m2" value="<?php echo $modificar->ira_m2?>" size='15' tabindex="13" />
</td>
<td>
</td>
<td align="center">
<?php echo form_error('ngr_m2', '<div class="warning">', '</div>'); ?> 
<input name="ngr_m2" type="text" id="ngr_m2" value="<?php echo $modificar->ngr_m2?>" size='15' tabindex="22" />
</td>
<td align="center">
<?php echo form_error('hos_m2', '<div class="warning">', '</div>'); ?> 
<input name="hos_m2" type="text" id="hos_m2" value="<?php echo $modificar->hos_m2?>" size='15' tabindex="25" />
</td>
<td align="center">
<?php echo form_error('dih_m2', '<div class="warning">', '</div>'); ?> 
<input name="dih_m2" type="text" id="dih_m2" value="<?php echo $modificar->dih_m2?>" size='15' tabindex="32" />
</td>
<td align="center">
<?php echo form_error('deh_m2', '<div class="warning">', '</div>'); ?> 
<input name="deh_m2" type="text" id="deh_m2" value="<?php echo $modificar->deh_m2?>" size='15' tabindex="39" />
</td>
</tr>
<tr>
<td valign="middle" bgcolor="#CCCCCC"><strong>2 a 11 meses</strong></td>
<td align="center">
<?php echo form_error('ira_2_11', '<div class="warning">', '</div>'); ?> 
<input name="ira_2_11" type="text" id="ira_2_11" value="<?php echo $modificar->ira_2_11?>" size='15' tabindex="14" />
</td>
<td align="center">
<?php echo form_error('neu_2_11', '<div class="warning">', '</div>'); ?> 
<input name="neu_2_11" type="text" id="neu_2_11" value="<?php echo $modificar->neu_2_11?>" size='15' tabindex="16" />
</td>
<td align="center">
<?php echo form_error('ngr_2_11', '<div class="warning">', '</div>'); ?> 
<input name="ngr_2_11" type="text" id="ngr_2_11" value="<?php echo $modificar->ngr_2_11?>" size='15' tabindex="23" />
</td>
<td align="center">
<?php echo form_error('hos_2_11', '<div class="warning">', '</div>'); ?> 
<input name="hos_2_11" type="text" id="hos_2_11" value="<?php echo $modificar->hos_2_11?>" size='15' tabindex="26" />
</td>
<td align="center">
<?php echo form_error('dih_2_11', '<div class="warning">', '</div>'); ?> 
<input name="dih_2_11" type="text" id="dih_2_11" value="<?php echo $modificar->dih_2_11?>" size='15' tabindex="33" />
</td>
<td align="center">
<?php echo form_error('deh_2_11', '<div class="warning">', '</div>'); ?> 
<input name="deh_2_11" type="text" id="deh_2_11" value="<?php echo $modificar->deh_2_11?>" size='15' tabindex="40" />
</td>
</tr>
<tr>
<td valign="middle" bgcolor="#CCCCCC"><strong>1 a 4 a&ntilde;os</strong></td>
<td align="center">
<?php echo form_error('ira_1_4a', '<div class="warning">', '</div>'); ?> 
<input name="ira_1_4a" type="text" id="ira_1_4a" value="<?php echo $modificar->ira_1_4a?>" size='15' tabindex="15" />
</td>
<td align="center">
<?php echo form_error('neu_1_4a', '<div class="warning">', '</div>'); ?> 
<input name="neu_1_4a" type="text" id="neu_1_4a" value="<?php echo $modificar->neu_1_4a?>" size='15' tabindex="17" />
</td>
<td align="center">
<?php echo form_error('ngr_1_4a', '<div class="warning">', '</div>'); ?> 
<input name="ngr_1_4a" type="text" id="ngr_1_4a" value="<?php echo $modificar->ngr_1_4a?>" size='15' tabindex="24" />
</td>
<td align="center">
<?php echo form_error('hos_1_4a', '<div class="warning">', '</div>'); ?> 
<input name="hos_1_4a" type="text" id="hos_1_4a" value="<?php echo $modificar->hos_1_4a?>" size='15' tabindex="27" />
</td>
<td align="center">
<?php echo form_error('dih_1_4a', '<div class="warning">', '</div>'); ?> 
<input name="dih_1_4a" type="text" id="dih_1_4a" value="<?php echo $modificar->dih_1_4a?>" size='15' tabindex="34" />
</td>
<td align="center">
<?php echo form_error('deh_1_4a', '<div class="warning">', '</div>'); ?> 
<input name="deh_1_4a" type="text" id="deh_1_4a" value="<?php echo $modificar->deh_1_4a?>" size='15' tabindex="41" />
</td>
</tr>
<tr><td colspan="9" valign="middle"><hr/></td></tr>
<tr>
<td valign="middle" bgcolor="#CCCCCC"><strong>5 a 9 a&ntilde;os</strong></td>
<td align="center">
</td>
<td align="center">
<?php echo form_error('neu_5_9a', '<div class="warning">', '</div>'); ?> 
<input name="neu_5_9a" type="text" id="neu_5_9a" value="<?php echo $modificar->neu_5_9a?>" size='15' tabindex="18" />
</td>
<td align="center">
</td>
<td align="center">
<?php echo form_error('hos_5_9a', '<div class="warning">', '</div>'); ?> 
<input name="hos_5_9a" type="text" id="hos_5_9a" value="<?php echo $modificar->hos_5_9a?>" size='15' tabindex="28" />
</td>
<td align="center">
<?php echo form_error('dih_5_9a', '<div class="warning">', '</div>'); ?> 
<input name="dih_5_9a" type="text" id="dih_5_9a" value="<?php echo $modificar->dih_5_9a?>" size='15' tabindex="35" />
</td>
<td align="center">
<?php echo form_error('deh_5_9a', '<div class="warning">', '</div>'); ?> 
<input name="deh_5_9a" type="text" id="deh_5_9a" value="<?php echo $modificar->deh_5_9a?>" size='15' tabindex="42" />
</td>
</tr>
<tr>
<td valign="middle" bgcolor="#CCCCCC"><strong>10 a 19 a&ntilde;os</strong></td>
<td align="center">
</td>
<td align="center">
<?php echo form_error('neu_10_19', '<div class="warning">', '</div>'); ?> 
<input name="neu_10_19" type="text" id="neu_10_19" value="<?php echo $modificar->neu_10_19?>" size='15' tabindex="19" />
</td>
<td align="center">
</td>
<td align="center">
<?php echo form_error('hos_10_19', '<div class="warning">', '</div>'); ?> 
<input name="hos_10_19" type="text" id="hos_10_19" value="<?php echo $modificar->hos_10_19?>" size='15' tabindex="29" />
</td>
<td align="center">
<?php echo form_error('dih_10_19', '<div class="warning">', '</div>'); ?> 
<input name="dih_10_19" type="text" id="dih_10_19" value="<?php echo $modificar->dih_10_19?>" size='15' tabindex="36" />
</td>
<td align="center">
<?php echo form_error('deh_10_19', '<div class="warning">', '</div>'); ?> 
<input name="deh_10_19" type="text" id="deh_10_19" value="<?php echo $modificar->deh_10_19?>" size='15' tabindex="43" />
</td>
</tr>
<tr>
<td valign="middle" bgcolor="#CCCCCC"><strong>20 a 59 a&ntilde;os</strong></td>
<td align="center">
</td>
<td align="center">
<?php echo form_error('neu_20_59', '<div class="warning">', '</div>'); ?> 
<input name="neu_20_59" type="text" id="neu_20_59" value="<?php echo $modificar->neu_20_59?>" size='15' tabindex="20" />
</td>
<td align="center">
</td>
<td align="center">
<?php echo form_error('hos_20_59', '<div class="warning">', '</div>'); ?> 
<input name="hos_20_59" type="text" id="hos_20_59" value="<?php echo $modificar->hos_20_59?>" size='15' tabindex="30" />
</td>
<td align="center">
<?php echo form_error('dih_20_59', '<div class="warning">', '</div>'); ?> 
<input name="dih_20_59" type="text" id="dih_20_59" value="<?php echo $modificar->dih_20_59?>" size='15' tabindex="37" />
</td>
<td align="center">
<?php echo form_error('deh_20_59', '<div class="warning">', '</div>'); ?> 
<input name="deh_20_59" type="text" id="deh_20_59" value="<?php echo $modificar->deh_20_59?>" size='15' tabindex="44" />
</td>
</tr>
<tr>
<td valign="middle" bgcolor="#CCCCCC"><strong>60 a&ntilde;os a m&aacute;s</strong></td>
<td align="center">
</td>
<td align="center">
<?php echo form_error('neu_60a', '<div class="warning">', '</div>'); ?> 
<input name="neu_60a" type="text" id="neu_60a" value="<?php echo $modificar->neu_60a?>" size='15' tabindex="21" />
</td>
<td align="center">
</td>
<td align="center">
<?php echo form_error('hos_60a', '<div class="warning">', '</div>'); ?> 
<input name="hos_60a" type="text" id="hos_60a" value="<?php echo $modificar->hos_60a?>" size='15' tabindex="31" />
</td>
<td align="center">
<?php echo form_error('dih_60a', '<div class="warning">', '</div>'); ?> 
<input name="dih_60a" type="text" id="dih_60a" value="<?php echo $modificar->dih_60a?>" size='15' tabindex="38" />
</td>
<td align="center">
<?php echo form_error('deh_60a', '<div class="warning">', '</div>'); ?> 
<input name="deh_60a" type="text" id="deh_60a" value="<?php echo $modificar->deh_60a?>" size='15' tabindex="45" />
</td>
</tr>
<tr><td colspan="9" valign="middle"><hr/></td></tr>
<tr>
<td valign="middle" bgcolor="#CCCCCC"><strong>Menores de 2 a&ntilde;os</strong></td>
<td align="center">
</td>
<td align="center">
</td>
<td align="center">
</td>
<td align="center">
</td>
<td align="center">
</td>
<td align="center">
</td>
<td align="center">
<?php echo form_error('sob_2a', '<div class="warning">', '</div>'); ?> 
<input name="sob_2a" type="text" id="sob_2a" value="<?php echo $modificar->sob_2a?>" size='15' tabindex="46" />
</td>
</tr>
<tr>
<td valign="middle" bgcolor="#CCCCCC"><strong>2 a 4 a&ntilde;os</strong></td>
<td align="center">
</td>
<td align="center">
</td>
<td align="center">
</td>
<td align="center">
</td>
<td align="center">
</td>
<td align="center">
</td>
<td align="center">
<?php echo form_error('sob_2_4a', '<div class="warning">', '</div>'); ?> 
<input name="sob_2_4a" type="text" id="sob_2_4a" value="<?php echo $modificar->sob_2_4a?>" size='15' tabindex="47" />
</td>
</tr>
<tr><td colspan="9" valign="middle"><hr/></td></tr>
<tr>
<td colspan="9" align="right">
<!--<input type="button" id="botonListado" name="nuevo" value="Nuevo" title="Registrar nuevo caso" disabled="disabled" />
--><input type="submit" id="botonGrabar" name="grabar" value="Grabar" title="Guardar los datos ingresados" />
<input type="button" id="botonBuscar" name="abrir" value="Abrir" title="Buscar casos registrados" onclick="window.location='<?php echo site_url('iras/listadoIras'); ?>'" />
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