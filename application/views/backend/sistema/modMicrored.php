<?php
    if($this->session->flashdata('ControllerMessage') != ''){
        ?>
        <div class="error"><?php echo $this->session->flashdata('ControllerMessage'); ?></div>
        <?php
    }
    $atributos = array('id'=>'form1', 'name'=>'form1');
    echo form_open(null, $atributos);
?>
<div class="formulario1">
    <center><h2>Modificar el Registro de Microredes de Salud</h2></center>
	<div style="border: solid 1px #000; width: 100%;">
		<table width="100%" align="center">
			<tr>
				<td width="14%" height="38" bgcolor="#CCCCCC"><strong>Diresa:</strong></td>
				<td width="86%" bgcolor="#CCCCCC">
				<?php echo form_error('diresa', '<div class="warning">', '</div>'); 
				echo form_dropdown('diresa', $diresa, $modificar->subregion, 'id="diresa" style="width: 200px;"');?>
				</td>
			</tr>
			<tr>
			  <td height="38"><strong>Red: </strong></td>
			  <td>
			  <?php echo form_error('redes', '<div class="warning">', '</div>'); 
			  $redes[''] = "Seleccione...";
			  echo form_dropdown('redes', $redes, $modificar->red, 'id="redes" style="width: 200px;"');
			  ?>
		  </tr>
			<tr>
			  <td height="36" bgcolor="#CCCCCC"><strong>C&oacute;digo:</strong></td>
			  <td bgcolor="#CCCCCC">
			  <?php echo form_error('codigo', '<div class="warning">', '</div>'); ?>
              <input name="codigo" type="text" id="codigo" title="Ingrese el c&oacute;digo de la microred" value="<?php echo $modificar->codigo;?>" onkeyup="javascript:this.value=this.value.toUpperCase();" size="30" /></td>
		  </tr>
			<tr>  
				<td height="37"><strong>Nombre:</strong></td>
				<td>
				<?php echo form_error('nombre', '<div class="warning">', '</div>'); ?> 
				<input name="nombre" type="text" id="nombre" title="Ingrese el nombre de la microred" value="<?php echo $modificar->nombre;?>" onkeyup="javascript:this.value=this.value.toUpperCase();" size='30' />
				</td>
			</tr>
			<tr>  
				<td bgcolor="#CCCCCC"><strong>&iquest;Estado</strong></td>
				<td bgcolor="#CCCCCC">
				<?php echo form_error('estado', '<div class="warning">', '</div>'); ?> 
				<select name="estado" id="estado" title="Elija si est&aacute; activo o no">
				  <option value="" <?php if ($modificar->estado==''){ echo "SELECTED";} ?>>Elija...</option>
				  <option value="1" <?php if ($modificar->estado=='1'){ echo "SELECTED";} ?>>Activado</option>
				  <option value="2" <?php if ($modificar->estado=='2'){ echo "SELECTED";} ?>>Desactivado</option>
				</select>
			  </td>
			</tr>
			<tr>
			  <td height="68" colspan="2" align="right">
				<input type="submit" name="enviar" value="Modificar Datos" />
				<input type="button" name="volver" value="Volver al listado" onclick="window.location='<?php echo site_url('backend/sistema/listarMicroredes'); ?>'" />
			  </td>
			</tr>
		</table>    
	</div>
</div>
<?php
    echo form_close();
?>