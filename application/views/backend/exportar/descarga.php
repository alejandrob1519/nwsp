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
<div class="loginNotiWeb">
	<div id="cargandoPNT" style="background-color:#F00; color:#FFF; font-weight:bold; display:none;">Procesando...</div>
    <table width="100%" align="center" class="table">
    <tr><td colspan="2">&nbsp;</td></tr>
    <tr>
    <td width="50%" align="center"><h2><b>Exportar la Base de Datos</b></h2></td>
    <td width="50%" align="center"><img src="<?php echo base_url().'public/images/ruedadentini.jpg'?>" width="100px" height="100px" /></td>
    </tr>
    <tr><td>Descarga de archivo: <?php echo anchor($filename);?></td></tr>
    <tr><td colspan="2">&nbsp;</td></tr>
	</table>
</div>
<?php
echo form_close();
?>	