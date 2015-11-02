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
<div class="loginNotiWeb">
	<div id="cargandoPNT" style="background-color:#F00; color:#FFF; font-weight:bold; display:none;">Procesando...</div>    
	<table width="100%" align="center" class="table">
    <tr>
    <td width="50%" align="center"><h2><b>Informe de Notificaci&oacute;n Individual</b></h2></td>
    <td width="50%" align="center"><img src="<?php echo base_url().'public/images/ruedadentini.jpg'?>" width="100px" height="100px" /></td>
    </tr>
    <tr>
    <td>
    <?php
	echo 'Seleccione una opci&oacute;n: &nbsp;&nbsp;&nbsp; 
	<input type="radio" id="opcion1" name="opcion" value="t_ind" > Descripción en tiempo
	&nbsp;&nbsp;&nbsp;<input type="radio" id="opcion2" name="opcion" value="e_ind" > Descripción en espacio
	&nbsp;&nbsp;&nbsp;<input type="radio" id="opcion3" name="opcion" value="p_ind" > Descripción en persona';    
	?>
    </td>
    </tr>
    <tr><td colspan="2"><hr /></td></tr>
    <tr><td><strong>&nbsp;&nbsp;A&ntilde;o de proceso:</strong></td>
    <td align="left">
	<?php echo form_error('anio', '<div class="warning">', '</div>'); 
    $anio[''] = "Seleccione...";
    echo form_dropdown('anio', $anio, set_value('anio'), 'id="anio" style="width: 160px;"');?>
    </td></tr>
    <tr><td><strong>&nbsp;&nbsp;Diagn&oacute;stico de proceso:</strong></td>
    <td align="left">
	<?php 
    echo form_error('diagno', '<div class="warning">', '</div>'); 
    echo form_dropdown('diagno', $diagno, set_value('diagno'), 'id="diagno" style="width: 200px;" tabindex="25"');
    ?>
    </td></tr>
    <tr><td colspan="2">&nbsp;</td></tr>
    <tr><td colspan="2"><hr /></td></tr>
    <tr>
    <td colspan="2" align="center">
    <input type="submit" id="botonCargando" name="aceptar" value="Aceptar" onclick="javascript:showContent();" />
    <input type="button" id="botonSalir" name="cancelar" value="Cancelar" onclick="window.location='<?php echo site_url('index/principal'); ?>'" /></td>
    </tr>
    <tr><td colspan="2">&nbsp;</td></tr>
	</table>
</div>
<?php
echo form_close();
?>	