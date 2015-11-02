<?php
/**************************************************  
*   PROGRAMA DE EXPORTACION DE LA BASE DE DATOS   *
***************************************************/
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
<div class="loginNotiWeb" style="width: 50%;">
	<div id="cargandoPNT" style="background-color:#F00; color:#FFF; font-weight:bold; display:none;">Procesando...</div>
    <table width="100%" align="center" class="table">
    <tr>
    <td width="50%" align="center"><h1><b>Exportar la Base de Datos</b></h1></td>
    <td width="50%" align="center"><img src="<?php echo base_url().'public/images/ruedadentini.jpg'?>" width="100px" height="100px" /></td>
    </tr>
    <tr>
    <td>&nbsp;&nbsp;<b>A&ntilde;o de exportaci&oacute;n:</b></td>
    <td>
	<?php 
	$anio = array();
		
	for($i=date("Y");$i>=2000;$i--)
	{
		$anio[$i] = $i;
	}

    echo form_error('anoExport', '<div class="warning">', '</div>'); 
	
    echo form_dropdown('anoExport', $anio, set_value('anoExport'), 'id="anoExport"');
    ?>
    </td>
    </tr>
    <tr>
    <td>&nbsp;&nbsp;<b>Base de datos:</b></td>
    <td>
	<?php 
    echo form_error('baseExport', '<div class="warning">', '</div>'); 
	
    $baseExport = array("" => "Seleccione...", "1" => "Notificaci&oacute;n Individual", "2"=> "Notificaci&oacute;n EDAS", "3"=> "Notificaci&oacute;n IRAS", "4"=> "Notificaci&oacute;n Febriles", "5"=>"Notificaci&oacute;n de Coberturas");
    echo form_dropdown('baseExport', $baseExport, set_value('baseExport'), 'id="baseExport"');
    ?>
    </td>
    </tr>
    <tr><td colspan="2">&nbsp;</td></tr>
    <tr>
    <td colspan="2" align="center">
    <input type="submit" id="botonCargando" name="aceptar" value="Aceptar" onclick="javascript:showContent();" />
    <input type="button" id="botonSalir" name="cancelar" value="Cancelar" onclick="window.location='<?php echo site_url('backend/index/principal'); ?>'" /></td>
<!--    <input type="hidden" name="id" value="<?php //echo $id; ?>" />
-->    </tr>
    <tr><td colspan="2">&nbsp;</td></tr>
	</table>
</div>
<?php
echo form_close();
?>	