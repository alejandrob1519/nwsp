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
    <center><h2>Registro de Establecimientos de Salud</h2></center>
	<div style="border: solid 1px #000; width: 100%;">
		<table width="100%" align="center">
			<tr>
				<td width="21%" height="38" bgcolor="#CCCCCC"><strong>Diresa:</strong></td>
				<td width="79%" bgcolor="#CCCCCC">
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
			  <td height="38" bgcolor="#CCCCCC"><strong>Microred: </strong></td>
			  <td bgcolor="#CCCCCC">
			  <?php echo form_error('microred', '<div class="warning">', '</div>'); 
			  $microred[''] = "Seleccione...";
			  echo form_dropdown('microred', $microred, $modificar->microred, 'id="microred" style="width: 200px;"');
			  ?>
            </tr>
	    <tr>
			  <td height="36"><strong>C&oacute;digo:</strong></td>
			  <td>
			  <?php echo form_error('codigo', '<div class="warning">', '</div>'); ?>
              <input name="codigo" type="text" id="codigo" title="Ingrese el c&oacute;digo del establecimiento de salud" value="<?php echo $modificar->cod_est;?>" onkeyup="javascript:this.value=this.value.toUpperCase();" size="100" /></td>
        </tr>
	    <tr>
			  <td height="36"><strong>C&oacute;digo RENAES:</strong></td>
			  <td>
			  <?php echo form_error('renaes', '<div class="warning">', '</div>'); ?>
              <input name="renaes" type="text" id="renaes" title="Ingrese el c&oacute;digo RENAES del establecimiento de salud" value="<?php echo $modificar->renaes;?>" onkeyup="javascript:this.value=this.value.toUpperCase();" size="100" /></td>
        </tr>
			<tr>  
				<td height="37" bgcolor="#CCCCCC"><strong>Denominaci&oacute;n:</strong></td>
				<td bgcolor="#CCCCCC">
				<?php echo form_error('nombre', '<div class="warning">', '</div>'); ?> 
				<input name="nombre" type="text" id="nombre" title="Ingrese el nombre del establecimiento de salud" value="<?php echo $modificar->raz_soc;?>" onkeyup="javascript:this.value=this.value.toUpperCase();" size='100' />
				</td>
			</tr>
			<tr>  
				<td><strong>&iquest;Es Unidad Notificante?</strong></td>
				<td>
				<?php echo form_error('notifica', '<div class="warning">', '</div>'); ?> 
				<select name="notifica" id="notifica" title="Elija si es una unidad notificante o no">
				  <option value="" <?php if ($modificar->notifica==''){ echo "SELECTED";} ?>>Elija...</option>
				  <option value="S" <?php if ($modificar->notifica=='S'){ echo "SELECTED";} ?>>SI</option>
				  <option value="N" <?php if ($modificar->notifica=='N'){ echo "SELECTED";} ?>>NO</option>
				</select>
			  </td>
			</tr>
			<tr>  
				<td bgcolor="#CCCCCC"><strong>Tipo de Establecimiento:</strong></td>
				<td bgcolor="#CCCCCC">
				<?php echo form_error('tipo', '<div class="warning">', '</div>'); ?> 
				<select name="tipo" id="tipo" title="Elija el tipo de establecimiento de salud">
				  <option value="" <?php if ($modificar->tipo==''){ echo "SELECTED";} ?>>Elija...</option>
				  <option value="A" <?php if ($modificar->tipo=='A'){ echo "SELECTED";} ?>>MINSA</option>
				  <option value="C" <?php if ($modificar->tipo=='C'){ echo "SELECTED";} ?>>ESSALUD</option>
				  <option value="D" <?php if ($modificar->tipo=='D'){ echo "SELECTED";} ?>>FFAA/PNP</option>
				  <option value="X" <?php if ($modificar->tipo=='X'){ echo "SELECTED";} ?>>PRIVADOS/OTROS</option>
				</select>
			  </td>
			</tr>
			<tr>  
				<td><strong>Nivel de Establecimiento:</strong></td>
				<td>
				<?php echo form_error('nivel', '<div class="warning">', '</div>'); ?> 
				<select name="nivel" id="nivel" title="Elija el nivel de establecimiento de salud">
				  <option value="" <?php if ($modificar->nivel==''){ echo "SELECTED";} ?>>Elija...</option>
				  <option value="1" <?php if ($modificar->nivel=='1'){ echo "SELECTED";} ?>>HOSPITAL</option>
				  <option value="2" <?php if ($modificar->nivel=='2'){ echo "SELECTED";} ?>>CENTRO DE SALUD</option>
				  <option value="3" <?php if ($modificar->nivel=='3'){ echo "SELECTED";} ?>>PUESTO DE SALUD</option>
				  <option value="4" <?php if ($modificar->nivel=='4'){ echo "SELECTED";} ?>>OTROS</option>
				</select>
			  </td>
			</tr>
			<tr>  
				<td height="37" bgcolor="#CCCCCC"><strong>Categor&iacute;a:</strong></td>
				<td bgcolor="#CCCCCC">
				<?php echo form_error('categoria', '<div class="warning">', '</div>'); ?> 
				<input name="categoria" type="text" id="categoria" title="Ingrese 	la categor&iacute;a del establecimiento" value="<?php echo $modificar->categoria;?>" onkeyup="javascript:this.value=this.value.toUpperCase();" size='100' />
				</td>
			</tr>
			<tr>  
				<td><strong>&iquest;Estado</strong></td>
				<td>
				<?php echo form_error('estado', '<div class="warning">', '</div>'); ?> 
				<select name="estado" id="estado" title="Elija si est&aacute; activo o no">
				  <option value="" <?php if ($modificar->estado==''){ echo "SELECTED";} ?>>Elija...</option>
				  <option value="1" <?php if ($modificar->estado=='1'){ echo "SELECTED";} ?>>Activado</option>
				  <option value="2" <?php if ($modificar->estado=='2'){ echo "SELECTED";} ?>>Desactivado</option>
				</select>
			  </td>
			</tr>
	    <tr>
			  <td height="68" colspan="2" align="right" bgcolor="#CCCCCC">
				<input type="submit" name="enviar" value="Modificar Datos" />
				<input type="button" name="volver" value="Volver al listado" onclick="window.location='<?php echo site_url('backend/sistema/listarEstablecimientos'); ?>'" />
			  </td>
			</tr>
		</table>    
	</div>
</div>
<?php
    echo form_close();
?>