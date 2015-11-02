<?php
/********************************************  
*   GENERADOR DEL REPORTE DE NOTIFICACION   *
*********************************************/
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

$anio = array();

for($i=2010;$i<=date("Y");$i++)
{
	$anio[$i] = $i;
}

?>
<div class="repNotiWeb">
	<div id="cargandoPNT" style="background-color:#F00; color:#FFF; font-weight:bold; display:none;">Procesando...</div>    
	<table width="100%" align="center" class="table">
    <tr>
    <td colspan="2" align="right"><h1>Informe de Notificaci&oacute;n de Enfermedades Diarr&eacute;icas Agudas</h1></td>
    <td colspan="2" align="left"><img src="<?php echo base_url().'public/images/ruedadentini.jpg'?>" width="100px" height="100px" /></td>
    </tr>
    <tr><td colspan="4"><hr /></td></tr>
    <tr>
    <td width="25%"><strong>&nbsp;&nbsp;Seleccione una opci&oacute;n:</strong></td>
    <td colspan="3">
    <?php
	echo form_error('descrip1', '<div class="warning">', '</div>');
	echo '
	<b><input type="radio" id="descrip1" name="opcion" value="t_ind" > Descripci&oacute;n en tiempo
	<input type="radio" id="descrip2" name="opcion" value="e_ind" > Descripci&oacute;n en espacio</b>';    
	?>
    </td>
    </tr>
    <tr><td colspan="4"><hr /></td></tr>
    <tr>
    <td><strong>&nbsp;&nbsp;Reporte Emitido por:</strong></td>
    <td colspan="3">
    <?php
	echo '<b><input type="radio" id="nivel1" name="nivel" value="ubigeo" checked > Lugar probable de infecci&oacute;n
	<input type="radio" id="nivel2" name="nivel" value="eess" > Unidad notificante';    
	?>
    </td>
    </tr>
    <tr><td colspan="4"><hr /></td></tr>
    <tr>
    <td valign="middle" bgcolor="#CCCCCC"><strong>&nbsp;&nbsp;Departamento</strong></td>
    <td valign="middle">
    <?php echo form_error('departamento', '<div class="warning">', '</div>'); 
    $departamento[''] = "Seleccione...";
    echo form_dropdown('departamento', $departamento, set_value('departamento'), 'id="departamento" style="width: 200px;"');
    ?>
    </td>
    <td valign="middle" bgcolor="#CCCCCC"><strong>&nbsp;&nbsp;Diresa</strong></td>
    <td valign="middle">
    <?php echo form_error('diresa', '<div class="warning">', '</div>'); 
    //$diresa[''] = "Seleccione...";
    echo form_dropdown('diresa', $diresa, set_value('diresa'), 'id="diresa" style="width: 250px;" disabled');
    ?>
    </td>
    </tr>
    <tr>
    <td valign="middle" bgcolor="#CCCCCC"><strong>&nbsp;&nbsp;Provincia</strong></td>
    <td valign="middle">
    <?php echo form_error('provincia', '<div class="warning">', '</div>'); 
    $provincia[''] = "Seleccione...";
    echo form_dropdown('provincia', $provincia, set_value('provincia'), 'id="provincia" style="width: 200px;"');
    ?>
    </td>
    <td valign="middle" bgcolor="#CCCCCC"><strong>&nbsp;&nbsp;Redes</strong></td>
    <td valign="middle">
    <?php echo form_error('redes', '<div class="warning">', '</div>'); 
    //$redes[''] = "Seleccione...";
    echo form_dropdown('redes', $redes, set_value('redes'), 'id="redes" style="width: 250px;" disabled');
    ?>
    </td>
    </tr>
    <tr>
    <td valign="middle" bgcolor="#CCCCCC"><strong>&nbsp;&nbsp;Distrito</strong></td>
    <td valign="middle">
    <?php echo form_error('distrito', '<div class="warning">', '</div>'); 
    $distrito[''] = "Seleccione...";
    echo form_dropdown('distrito', $distrito, set_value('distrito'), 'id="distrito" style="width: 200px;"');
    ?>
    </td>
    <td valign="middle" bgcolor="#CCCCCC"><strong>&nbsp;&nbsp;Microred</strong></td>
    <td valign="middle">
    <?php echo form_error('microred', '<div class="warning">', '</div>'); 
    //$microred[''] = "Seleccione...";
    echo form_dropdown('microred', $microred, set_value('microred'), 'id="microred" style="width: 250px;" disabled');
    ?>
    </td>
    </tr>
    <tr>
    <td></td>
    <td></td>
    <td valign="middle" bgcolor="#CCCCCC"><strong>&nbsp;&nbsp;Establecimiento</strong></td>
    <td valign="middle">
    <?php echo form_error('establec', '<div class="warning">', '</div>'); 
    //$establec[''] = "Seleccione...";
    echo form_dropdown('establec', $establec, set_value('establec'), 'id="establec" style="width: 250px;" disabled');
    ?>
    </td>
    </tr>
    <tr><td colspan="4"><hr /></td></tr>
    <tr>
    <td colspan="4" align="center">
    <input type="submit" id="botonCargando" name="aceptar" value="Aceptar" onclick="javascript:showContent();" />
    <input type="button" id="botonLimpiar" name="limpiar" value="limpiar" onclick="window.location='<?php echo site_url('reportes/repEdas'); ?>'" />
    <input type="button" id="botonSalir" name="cancelar" value="Cancelar" onclick="window.location='<?php echo site_url('index/principal'); ?>'" /></td>
    </tr>
    <tr><td colspan="4">&nbsp;</td></tr>
	</table>
</div>
<?php
echo form_close();
?>	