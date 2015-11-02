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
<div class="formulario1">
    <center><h2>Autorizaci&oacute;n de Usuarios Operadores del Sistema</h2></center>
	<div style="width: 100%;">
		<table width="100%" align="center">
			<tr>
			  <td bgcolor="#CCCCCC"><strong>Usuario :</strong></td>
			  <td bgcolor="#CCCCCC" colspan="3"><?php echo form_error('usuario', '<div class="warning">', '</div>'); ?>
	          <input name="usuario" type="text" id="usuario" value="<?php echo $operador->usuario;?>" onkeyup="javascript:this.value=this.value.toUpperCase();" size="100" /></td>
			</tr>
			<tr>
			  <td bgcolor="#CCCCCC"><strong>Nombres :</strong></td>
			  <td bgcolor="#CCCCCC" colspan="3"><?php echo form_error('nombres', '<div class="warning">', '</div>'); ?>
	          <input name="nombres" type="text" id="nombres" value="<?php echo $operador->nombres;?>" onkeyup="javascript:this.value=this.value.toUpperCase();" size="100" /></td>
			</tr>
        </table>
        <hr/>
        <?php
		
		//$modulos = $this->fichas_model->buscarAplicaciones();
		
		$accesos = $this->fichas_model->accesoAplicaciones($operador->usuario);
		
		foreach($accesos as $acce){
			if($acce->usuario != ""){
				?>
				<input type="checkbox" name="acc[]" value="<?php echo $acce->aplicacion;?>" checked="checked" />&nbsp;<?php echo $acce->aplicacion." - ".$acce->nombre;?>
				<br/>
				<?php
			}else{
				if($acce->estado == "1"){
					?>
					<input type="checkbox" name="acc[]" value="<?php echo $acce->aplicacion;?>" />&nbsp;<?php echo $acce->aplicacion." - ".$acce->nombre;?>
					<br/>
					<?php
				}else{
					?>
					<input type="checkbox" name="acc[]" value="<?php echo $acce->aplicacion;?>" disabled="disabled" />&nbsp;<?php echo $acce->aplicacion." - ".$acce->nombre;?>
					<br/>
					<?php
				}
			}
		}
		?>
        <hr/>
   		<table width="100%" align="center">
			<tr>
			  <td colspan="2" align="right" bgcolor="#CCCCCC">
				<input type="button" name="volver" value="Volver al listado" onclick="window.location='<?php echo site_url('backend/usuario/listarUsuarios'); ?>'" />
				<input type="submit" name="enviar" value="Grabar Usuario" />
			  </td>
		  </tr>
	  </table>    
	</div>
</div>
<?php
    echo form_close();
?>