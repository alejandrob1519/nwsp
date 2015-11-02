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

$semana = array();

for($i=1;$i<=53;$i++)
{
	$semana[$i] = $i;
}

?>
<div class="loginNotiWeb">
	<div id="cargandoPNT" style="background-color:#F00; color:#FFF; font-weight:bold; display:none;">Procesando...</div>    
	<table width="100%" align="center" class="table">
    <tr>
    <td width="50%" align="center"><h2><b>Reporte de Cobertura de la Notificaci&oacute;n</b></h2></td>
    <td width="50%" align="center"><img src="<?php echo base_url().'public/images/ruedadentini.jpg'?>" width="100px" height="100px" /></td>
    </tr>
    <tr><td colspan="2"><hr /></td></tr>
    <tr><td><strong>&nbsp;&nbsp;A&ntilde;o:</strong></td>
    <td align="left">
	<?php echo form_error('anio', '<div class="warning">', '</div>'); 
    $anio[''] = "Seleccione...";
    echo form_dropdown('anio', $anio, date("Y"), 'id="anio" style="width: 140px;"');?>
    </td></tr>
    <tr><td><strong>&nbsp;&nbsp;Semana:</strong></td>
    <td align="left">
	<?php echo form_error('semana', '<div class="warning">', '</div>'); 
    $semana[''] = "Seleccione...";
    echo form_dropdown('semana', $semana, date("W"), 'id="semana" style="width: 140px;"');?>
    </td></tr>
    <tr><td colspan="2">&nbsp;</td></tr>
    <tr><td colspan="2"><hr /></td></tr>
    <tr>
    <td colspan="2" align="center">
    <input type="submit" id="botonCargando" name="aceptar" value="Aceptar" onclick="javascript:showContent();" />
    <input type="button" id="botonSalir" name="cancelar" value="Cancelar" onclick="window.location='<?php echo site_url('backend/index/principal'); ?>'" /></td>
    </tr>
    <tr><td colspan="2">&nbsp;</td></tr>
	</table>
</div>
<?php
echo form_close();
?>	