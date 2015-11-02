<?php
/*********************************************************************  
*   PROGRAMA DE EXPORTACION DE LA BASE DE DATOS DE MUERTE PERINATAL  *
**********************************************************************/
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

/*if($this->session->userdata('descarga') != '1'){
	$this->session->set_flashdata('error', 'Usted no cuenta con el privilegio de descarga de base de datos');
	redirect(site_url('mnp/principal'), 301);
}*/
?>
<div class="loginNotiWeb">
	<div id="cargandoPNT" style="background-color:#F00; color:#FFF; font-weight:bold; display:none;">Procesando...</div>
    <table width="100%" align="center" class="table">
    <tr><td colspan="2"><?php echo date("d-m-Y | H:m:s");?>&nbsp;</td></tr>
    <tr>
    <td width="50%" align="center"><h1><b>Exportar la Base de Datos de Muerte Perinatal</b></h1></td>
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
    <tr><td colspan="2">&nbsp;</td></tr>
    <tr>
    <td colspan="2" align="center">
    <input type="submit" id="botonCargando" name="aceptar" value="Aceptar" onclick="javascript:showContent();" />
    <input type="button" id="botonSalir" name="cancelar" value="Cancelar" onclick="window.location='<?php echo site_url('mnp/principal'); ?>'" /></td>
    </tr>
    <tr><td colspan="2">&nbsp;</td></tr>
	</table>
</div>
<?php
echo form_close();
?>	