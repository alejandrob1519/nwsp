<?php
/******************************************  
*   REGISTRO SEMANAL NOTIFICACION EDAS    *
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
<BR /><BR />
<table width="100%" style="font-size:12px; background-color:#CEE3F6;" align="center">
<tr>
<td colspan="9" valign="middle"><strong>REGISTRO SEMANAL DE LA NOTIFICACION DE LAS ENFERMEDADES DIARREICAS AGUDAS - EDA's</strong></td>
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
echo form_dropdown('departamento', $departamento, substr($modificar->ubigeo,0,2), 'id="departamento" style="width: 160px;" tabindex="10"');
?>
</td>
<td valign="middle" bgcolor="#CCCCCC"><strong>Provincia</strong></td>
<td valign="middle">
<?php echo form_error('provincia', '<div class="warning">', '</div>'); 
$provincia[''] = "Seleccione...";
echo form_dropdown('provincia', $provincia, substr($modificar->ubigeo,0,4), 'id="provincia" style="width: 200px;" tabindex="11"');
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
<tr><td colspan="9" valign="middle"><hr/></td></tr>
<td valign="middle" bgcolor="#CCCCCC" colspan="9"><center><strong>DIARREA ACUOSA AGUDA (NO INCLUYE SOSPECHOSOS DE COLERA)</strong></center></td>
</tr>
<tr>
<td valign="middle" colspan="3"><center><strong>No. de Casos</strong></center></td>
<td valign="middle" colspan="3"><center><strong>No. de Defunciones</strong></center></td>
<td valign="middle" colspan="3"><center><strong>No. de Hospitalizados</strong></center></td>
</tr>
<tr>
<td valign="middle" bgcolor="#CCCCCC"><center><strong>< 1 a&ntilde;os</strong></center></td>
<td valign="middle" bgcolor="#CCCCCC"><center><strong>1 a 4 a&ntilde;os</strong></center></td>
<td valign="middle" bgcolor="#CCCCCC"><center><strong>5 a +</strong></center></td>
<td valign="middle" bgcolor="#CCCCCC"><center><strong>< 1 a&ntilde;os</strong></center></td>
<td valign="middle" bgcolor="#CCCCCC"><center><strong>1 a 4 a&ntilde;os</strong></center></td>
<td valign="middle" bgcolor="#CCCCCC"><center><strong>5 a +</strong></center></td>
<td valign="middle" bgcolor="#CCCCCC"><center><strong>< 1 a&ntilde;os</strong></center></td>
<td valign="middle" bgcolor="#CCCCCC"><center><strong>1 a 4 a&ntilde;os</strong></center></td>
<td valign="middle" bgcolor="#CCCCCC"><center><strong>5 a +</strong></center></td>
</tr>
<tr>
<td align="center">
<?php echo form_error('daa_c1', '<div class="warning">', '</div>'); ?> 
<input name="daa_c1" type="text" id="daa_c1" title="Diarreas acuosas agudas en < 1 a&ntilde;o" value="<?php echo $modificar->daa_c1;?>" size='10' tabindex="13" />
</td>
<td align="center">
<?php echo form_error('daa_c1_4', '<div class="warning">', '</div>'); ?> 
<input name="daa_c1_4" type="text" id="daa_c1_4" title="Diarreas acuosas agudas en < 4 a&ntilde;os" value="<?php echo $modificar->daa_c1_4;?>" size='10' tabindex="14" />
</td>
<td align="center">
<?php echo form_error('daa_c5', '<div class="warning">', '</div>'); ?> 
<input name="daa_c5" type="text" id="daa_c5" title="Diarreas acuosas agudas en > 5 a&ntilde;os" value="<?php echo $modificar->daa_c5;?>" size='10' tabindex="15" />
</td>
<td align="center">
<?php echo form_error('daa_d1', '<div class="warning">', '</div>'); ?> 
<input name="daa_d1" type="text" id="daa_d1" title="Defunciones en diareas acuosas agudas en < 1 a&ntilde;o" value="<?php echo $modificar->daa_d1;?>" size='10' tabindex="16" />
</td>
<td align="center">
<?php echo form_error('daa_d1_4', '<div class="warning">', '</div>'); ?> 
<input name="daa_d1_4" type="text" id="daa_d1_4" title="Defunciones en diareas acuosas agudas en < 4 a&ntilde;os" value="<?php echo $modificar->daa_d1_4;?>" size='10' tabindex="17" />
</td>
<td align="center">
<?php echo form_error('daa_d5', '<div class="warning">', '</div>'); ?> 
<input name="daa_d5" type="text" id="daa_d5" title="Defunciones en diareas acuosas agudas en > 5 a&ntilde;os" value="<?php echo $modificar->daa_d5;?>" size='10' tabindex="18" />
</td>
<td align="center">
<?php echo form_error('daa_h1', '<div class="warning">', '</div>'); ?> 
<input name="daa_h1" type="text" id="daa_h1" title="Hospitalizados en diareas acuosas agudas en < 1 a&ntilde;o" value="<?php echo $modificar->daa_h1;?>" size='10' tabindex="19" />
</td>
<td align="center">
<?php echo form_error('daa_h1_4', '<div class="warning">', '</div>'); ?> 
<input name="daa_h1_4" type="text" id="daa_h1_4" title="Hospitalizados en diareas acuosas agudas en < 4 a&ntilde;os" value="<?php echo $modificar->daa_h1_4;?>" size='10' tabindex="20" />
</td>
<td align="center">
<?php echo form_error('daa_h5', '<div class="warning">', '</div>'); ?> 
<input name="daa_h5" type="text" id="daa_h5" title="Hospitalizados en diareas acuosas agudas en > 5 a&ntilde;os" value="<?php echo $modificar->daa_h5;?>" size='10' tabindex="21" />
</td>
</tr>
<tr><td colspan="9" valign="middle"><hr/></td></tr>
<td valign="middle" bgcolor="#CCCCCC" colspan="9"><center><strong>DISENTERIAS</strong></center></td>
</tr>
<tr>
<td valign="middle" colspan="3"><center><strong>No. de Casos</strong></center></td>
<td valign="middle" colspan="3"><center><strong>No. de Defunciones</strong></center></td>
<td valign="middle" colspan="3"><center><strong>No. de Hospitalizados</strong></center></td>
</tr>
<tr>
<td valign="middle" bgcolor="#CCCCCC"><center><strong>< 1 a&ntilde;os</strong></center></td>
<td valign="middle" bgcolor="#CCCCCC"><center><strong>1 a 4 a&ntilde;os</strong></center></td>
<td valign="middle" bgcolor="#CCCCCC"><center><strong>5 a +</strong></center></td>
<td valign="middle" bgcolor="#CCCCCC"><center><strong>< 1 a&ntilde;os</strong></center></td>
<td valign="middle" bgcolor="#CCCCCC"><center><strong>1 a 4 a&ntilde;os</strong></center></td>
<td valign="middle" bgcolor="#CCCCCC"><center><strong>5 a +</strong></center></td>
<td valign="middle" bgcolor="#CCCCCC"><center><strong>< 1 a&ntilde;os</strong></center></td>
<td valign="middle" bgcolor="#CCCCCC"><center><strong>1 a 4 a&ntilde;os</strong></center></td>
<td valign="middle" bgcolor="#CCCCCC"><center><strong>5 a +</strong></center></td>
</tr>
<tr>
<td align="center">
<?php echo form_error('dis_c1', '<div class="warning">', '</div>'); ?> 
<input name="dis_c1" type="text" id="dis_c1" title="Diarreas disent&eacute;ricas en < 1 a&ntilde;o" value="<?php echo $modificar->dis_c1;?>" size='10' tabindex="22" />
</td>
<td align="center">
<?php echo form_error('dis_c1_4', '<div class="warning">', '</div>'); ?> 
<input name="dis_c1_4" type="text" id="dis_c1_4" title="Diarreas disent&eacute;ricas en < 4 a&ntilde;os" value="<?php echo $modificar->dis_c1_4;?>" size='10' tabindex="23" />
</td>
<td align="center">
<?php echo form_error('dis_c5', '<div class="warning">', '</div>'); ?> 
<input name="dis_c5" type="text" id="dis_c5" title="Diarreas disent&eacute;ricas en > 5 a&ntilde;os" value="<?php echo $modificar->dis_c5;?>" size='10' tabindex="24" />
</td>
<td align="center">
<?php echo form_error('dis_d1', '<div class="warning">', '</div>'); ?> 
<input name="dis_d1" type="text" id="dis_d1" title="Defunciones en diareas disent&eacute;ricas en < 1 a&ntilde;o" value="<?php echo $modificar->dis_d1;?>" size='10' tabindex="25" />
</td>
<td align="center">
<?php echo form_error('dis_d1_4', '<div class="warning">', '</div>'); ?> 
<input name="dis_d1_4" type="text" id="dis_d1_4" title="Defunciones en diareas disent&eacute;ricas en < 4 a&ntilde;os" value="<?php echo $modificar->dis_d1_4;?>" size='10' tabindex="26" />
</td>
<td align="center">
<?php echo form_error('dis_d5', '<div class="warning">', '</div>'); ?> 
<input name="dis_d5" type="text" id="dis_d5" title="Defunciones en diareas disent&eacute;ricas en > 5 a&ntilde;os" value="<?php echo $modificar->dis_d5;?>" size='10' tabindex="27" />
</td>
<td align="center">
<?php echo form_error('dis_h1', '<div class="warning">', '</div>'); ?> 
<input name="dis_h1" type="text" id="dis_h1" title="Hospitalizados en diareas disent&eacute;ricas en < 1 a&ntilde;o" value="<?php echo $modificar->dis_h1;?>" size='10' tabindex="28" />
</td>
<td align="center">
<?php echo form_error('dis_h1_4', '<div class="warning">', '</div>'); ?> 
<input name="dis_h1_4" type="text" id="dis_h1_4" title="Hospitalizados en diareas disent&eacute;ricas en < 4 a&ntilde;os" value="<?php echo $modificar->dis_h1_4;?>" size='10' tabindex="29" />
</td>
<td align="center">
<?php echo form_error('dis_h5', '<div class="warning">', '</div>'); ?> 
<input name="dis_h5" type="text" id="dis_h5" title="Hospitalizados en diareas disent&eacute;ricas en > 5 a&ntilde;os" value="<?php echo $modificar->dis_h5;?>" size='10' tabindex="30" />
</td>
</tr>
<tr><td colspan="9" valign="middle"><hr/></td></tr>
<tr>
<td colspan="9" align="right">
<!--<input type="button" id="botonListado" name="nuevo" value="Nuevo" title="Registrar nuevo caso" disabled="disabled" />
--><input type="submit" id="botonGrabar" name="grabar" value="Grabar" title="Guardar los datos ingresados" />
<input type="button" id="botonBuscar" name="abrir" value="Abrir" title="Buscar casos registrados" onclick="window.location='<?php echo site_url('edas/listadoEdas'); ?>'" />
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