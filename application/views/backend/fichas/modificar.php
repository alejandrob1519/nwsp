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
    <center><h2>Registro de Usuarios Administradores del Sistema</h2></center>
	<div style="border: solid 1px #000; width: 70%; margin-left: 15%;">
		<table width="100%" align="center">
			<tr>
				<td width="41%" bgcolor="#CCCCCC"><strong>Apellido Paterno:</strong></td>
				<td width="59%">
					<?php echo form_error('paterno', '<div class="warning">', '</div>'); ?> 
					<input name="paterno" type="text" id="paterno" title="Ingrese el apellido paterno del usuario" value="<?php echo $modificar->paterno;?>" onkeyup="javascript:this.value=this.value.toUpperCase();" autofocus="autofocus" size="30" />
				</td>
			</tr>
			<tr>
			  <td bgcolor="#CCCCCC"><strong>Apellido Materno: </strong></td>
			  <td><?php echo form_error('materno', '<div class="warning">', '</div>'); ?>
              <input name="materno" type="text" id="materno" title="Ingrese el apellido materno del usuario" value="<?php echo $modificar->materno;?>" onkeyup="javascript:this.value=this.value.toUpperCase();" size="30" /></td>
		  </tr>
			<tr>
			  <td bgcolor="#CCCCCC"><strong>Nombres:</strong></td>
			  <td><?php echo form_error('nombres', '<div class="warning">', '</div>'); ?>
              <input name="nombres" type="text" id="nombres" title="Ingrese los nombres del usuario" value="<?php echo $modificar->nombres;?>" onkeyup="javascript:this.value=this.value.toUpperCase();" size="30" /></td>
		  </tr>
			<tr>  
				<td bgcolor="#CCCCCC"><strong>DNI:</strong></td>
				<td>
				<?php echo form_error('dni', '<div class="warning">', '</div>'); ?> 
				<input name="dni" type="text" id="dni" title="Ingrese el DNI del usuario" value="<?php echo $modificar->dni;?>" />
				</td>
			</tr>
			<tr>  
				<td bgcolor="#CCCCCC"><strong>
				  Correo:
			  </strong></td>
				<td>
				<?php echo form_error('correo', '<div class="warning">', '</div>'); ?> 
				<input name="correo" type="text" id="correo" title="Ingrese el correo electr&oacute;nico del usuario" value="<?php echo $modificar->correo;?>" size="55" />
				</td>
			</tr>
			<tr>
			  <td bgcolor="#CCCCCC"><strong>Tel&eacute;fono: </strong></td>
			  <td><?php echo form_error('telefono', '<div class="warning">', '</div>'); ?>
              <input name="telefono" type="text" id="telefono" title="Ingrese el tel&eacute;fono del usuario" value="<?php echo $modificar->telefono;?>" /></td>
		  </tr>
			<tr>
			  <td bgcolor="#CCCCCC"><strong>M&oacute;bil: </strong></td>
			  <td><?php echo form_error('mobil', '<div class="warning">', '</div>'); ?>
              <input name="mobil" type="text" id="mobil" title="Ingrese el m&oacute;bil del usuario" value="<?php echo $modificar->mobil;?>" /></td>
		  </tr>
			<tr>  
				<td bgcolor="#CCCCCC"><strong>Usuario: </strong></td>
				<td>
				<?php echo form_error('usuario', '<div class="warning">', '</div>'); ?> 
				<input name="usuario" type="text" id="usuario" title="Ingrese el c&oacute;digo del usuario" value="<?php echo $modificar->usuario;?>" />
				</td>
			</tr>
			<tr>  
				<td bgcolor="#CCCCCC"><strong>
				  Contrase&ntilde;a:
				</strong></td>
				<td>
				<?php echo form_error('contrasena', '<div class="warning">', '</div>'); ?> 
				<input name="contrasena" type="password" id="contrasena" title="Ingrese la contrase&ntilde;a del usuario" value="<?php echo $modificar->contrasena;?>" />
				</td>
			</tr>
			<tr>  
				<td bgcolor="#CCCCCC"><strong>
				  Nivel
			  </strong></td>
				<td>
				<?php 
					echo form_error('nivel', '<div class="warning">', '</div>'); 
				?> 
				<select name="nivel" id="nivel" title="Ingrese el nivel del usuario">
				  <option value="">Elija...</option>
                  <?php
				  $niveles = $this->mantenimiento_model->buscarNiveles();
				  foreach($niveles as $datos){
					  $niv = $datos->nivel;
					  $nom = $datos->nombre;
					  if($niv != $modificar->nivel){
					  	?>
					  	<option value="<?php echo $niv; ?>"><?php echo $nom; ?></option>
                      	<?php
				  	  }else{
					  	?>
					  	<option value="<?php echo $niv; ?>" selected="selected"><?php echo $nom; ?></option>
                      	<?php
					  }
				  }
				  ?>
				</select>
				</td>
			</tr>
			<tr>  
				<td bgcolor="#CCCCCC"><strong>
				  Diresa
			  </strong></td>
				<td>
                  <?php
				  foreach($this->mantenimiento_model->buscarDiresas() as $diresa){
					  $subreg[$diresa->codigo] = $diresa->nombre;
				  }
				  echo form_dropdown('diresa', $subreg, $modificar->diresa, 'id="diresa" style="width: 200px;"');
				  ?>
				</td>
			</tr>
			<tr>  
				<td bgcolor="#CCCCCC"><strong>
				  Redes
			  </strong></td>
				<td>
                  <?php
				  $red[''] = "Seleccione...";
				  echo form_dropdown('redes', $red, $modificar->red, 'id="redes" style="width: 200px;"');
				  ?>
				</td>
			</tr>
			<tr>  
				<td bgcolor="#CCCCCC"><strong>
				  Microred
			  </strong></td>
				<td>
                  <?php
				  $mred[''] = "Seleccione...";
				  echo form_dropdown('microred', $mred, $modificar->microred, 'id="microred" style="width: 200px;"');
				  ?>
				</td>
			</tr>
			<tr>  
				<td bgcolor="#CCCCCC"><strong>
				  Establecimiento
			  </strong></td>
				<td>
                  <?php
				  $est[''] = "Seleccione...";
				  echo form_dropdown('establec', $est, $modificar->establecimiento, 'id="establec" style="width: 200px;"');
				  ?>
				</td>
			</tr>
			<tr>  
				<td bgcolor="#CCCCCC"><strong>
				  Estado
			  </strong></td>
				<td>
				<?php echo form_error('estado', '<div class="warning">', '</div>'); ?> 
				<select name="estado" id="estado" title="No olvide activar al usuario">
				  <option value="" <?php if ($modificar->estado=='') {echo "SELECTED";} ?>>Elija...</option>
				  <option value="1" <?php if ($modificar->estado=='1') {echo "SELECTED";} ?>>Activo</option>
				  <option value="2" <?php if ($modificar->estado=='2') {echo "SELECTED";} ?>>Desactivado</option>
				</select>
					
				</td>
			</tr>
			<tr>
			  <td colspan="2" align="right">
				<input type="button" name="volver" value="Volver al listado" onclick="window.location='<?php echo site_url('backend/mantenimiento/listarUsuarios'); ?>'" />
				<input type="submit" name="enviar" value="Modificar Datos" />
			  </td>
			</tr>
		</table>    
	</div>
</div>
<?php
    echo form_close();
?>