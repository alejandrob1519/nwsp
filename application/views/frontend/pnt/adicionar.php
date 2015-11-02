<?php
/******************************************  
*   PROGRAMA DE NOTIIFCACION TELEMATICA   *
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
<div class="loginNotiWeb">
	<div id="cargandoPNT" style="background-color:#F00; color:#FFF; font-weight:bold; display:none;">Procesando...</div>
    <table width="100%" align="center" class="table">
    <tr><td colspan="2">&nbsp;</td></tr>
    <tr>
    <td align="center"><h2><b>&iquest;Est&aacute; seguro de realizar este proceso?</b></h2></td>
    <td><img src="<?php echo base_url().'public/images/ruedadentini.jpg'?>" width="100px" height="100px" /></td>
    </tr>
    <tr><td colspan="2"><h5>ATENCION: Este proceso adicionar&aacute; a la base de datos principal la informaci&oacute;n que se est&aacute; remitiendo.</h5></td></tr>
    <tr>
    <td colspan="2" align="center">
    <input type="submit" id="botonCargando" name="aceptar" value="Aceptar" onclick="javascript:showContent();" />
    <input type="button" id="botonSalir" name="cancelar" value="Cancelar" onclick="window.location='<?php echo site_url('pnt/listadoNotificacion'); ?>'" /></td>
    <input type="hidden" name="id" value="<?php echo $id; ?>" />
    </tr>
    <tr><td colspan="2">&nbsp;</td></tr>
	</table>
</div>
<?php
echo form_close();
?>	