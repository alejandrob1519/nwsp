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
    <center><h2>Modificaci&oacute;n del Registro de Usuarios Operadores del Sistema</h2></center>
	<div style="width: 100%;">
		<table width="100%" align="center">
			<tr>  
				<td width="23%" bgcolor="#CCCCCC"><strong>Usuario : </strong></td>
				<td width="77%" bgcolor="#CCCCCC" colspan="3">
				<?php echo form_error('codigo', '<div class="warning">', '</div>'); ?> 
				<input name="codigo" type="text" id="codigo" title="Ingrese el c&oacute;digo del usuario" value="<?php echo $modificar->usuario;?>" />
				</td>
			</tr>
			<tr>  
				<td bgcolor="#FFFFFF"><strong>Contrase&ntilde;a :</strong></td>
				<td bgcolor="#FFFFFF" colspan="3">
				<?php echo form_error('clave', '<div class="warning">', '</div>'); ?> 
				<input name="clave" type="password" id="clave" title="Ingrese la contrase&ntilde;a del usuario" value="<?php if($modificar->codigo == ''){ echo '1234567'; }else{ echo $modificar->codigo;}?>" />
				</td>
			</tr>
			<tr>
			  <td bgcolor="#CCCCCC"><strong>Nombres :</strong></td>
			  <td bgcolor="#CCCCCC" colspan="3"><?php echo form_error('nombres', '<div class="warning">', '</div>'); ?>
              <input name="nombres" type="text" id="nombres" title="Ingrese los apellidos y nombres del usuario" value="<?php echo $modificar->nombres;?>" onkeyup="javascript:this.value=this.value.toUpperCase();" size="100" /></td>
		  </tr>
			<tr>  
				<td bgcolor="#FFFFFF"><strong>DNI :</strong></td>
				<td bgcolor="#FFFFFF" colspan="3">
				<?php echo form_error('dni', '<div class="warning">', '</div>'); ?> 
				<input name="dni" type="text" id="dni" title="Ingrese el DNI del usuario" value="<?php echo $modificar->dni;?>" />
				</td>
			</tr>
			<tr>  
				<td bgcolor="#CCCCCC"><strong>
				  Correo :
			  </strong></td>
				<td bgcolor="#CCCCCC" colspan="3">
				<?php echo form_error('correo', '<div class="warning">', '</div>'); ?> 
				<input name="correo" type="text" id="correo" title="Ingrese el correo electr&oacute;nico del usuario" value="<?php echo $modificar->email;?>" size="55" />
				</td>
			</tr>
			<tr>  
				<td bgcolor="#FFFFFF"><strong>
				  Nivel
			  :</strong></td>
				<td bgcolor="#FFFFFF" colspan="3">
				<?php 
					echo form_error('nivel', '<div class="warning">', '</div>'); 
				?> 
				<select name="nivel" id="nivel" title="Ingrese el nivel del usuario" style="width:140px;">
				  <option value="">Elija...</option>
                  <?php
				  $niveles = $this->usuarios_model->buscarNiveles();
				  foreach($niveles as $datos){
					  $niv = $datos->nivel;
					  $nom = $datos->nombre;
					  ?>
					  <option value="<?php echo $niv; ?>"<?php if($modificar->nivel == $niv){?> selected = 'selected' <?php }?>><?php echo $nom; ?></option>
                      <?php
				  }
				  ?>
				</select>
				</td>
			</tr>
			<tr>  
				<td bgcolor="#FFFFFF"><strong>
				  Instituci&oacute;n
			  :</strong></td>
				<td bgcolor="#FFFFFF" colspan="3">
				<?php 
					echo form_error('institucion', '<div class="warning">', '</div>'); 
				?> 
				<select name="institucion" id="institucion" title="Instituci&oacute;n del usuario" style="width:140px;">
				  <option value=""<?php if($modificar->institucion == ''){?> selected = 'selected' <?php }?>>Elija...</option>
				  <option value="A"<?php if($modificar->institucion == 'A'){?> selected = 'selected' <?php }?>>MINSA</option>
				  <option value="C"<?php if($modificar->institucion == 'C'){?> selected = 'selected' <?php }?>>ESSALUD</option>
				  <option value="D"<?php if($modificar->institucion == 'D'){?> selected = 'selected' <?php }?>>FFAA/PNP</option>
				  <option value="X"<?php if($modificar->institucion == 'X'){?> selected = 'selected' <?php }?>>PRIVADOS</option>
				</select>
				</td>
			</tr>
			<tr>
			  <td bgcolor="#CCCCCC"><strong>Caducidad :</strong></td>
			  <td bgcolor="#CCCCCC" colspan="3"><?php echo form_error('caduca', '<div class="warning">', '</div>'); ?>
              <input name="caduca" type="text" id="caduca" title="Ingrese la fecha de caducidad del usuario" value="<?php echo $this->fechas_model->modificarFechas($modificar->caduca);?>" placeholder='Ej. dd-mm-YYYY' /></td>
		  </tr>
			<tr>  
				<td bgcolor="#FFFFFF"><strong>Estado :</strong></td>
				<td bgcolor="#FFFFFF" colspan="3">
				<?php echo form_error('estado', '<div class="warning">', '</div>'); ?> 
				<select name="estado" id="estado" title="No olvide activar al usuario" style="width:140px;">
				  <option value=""<?php if($modificar->estado == ''){?> selected = 'selected' <?php }?>>Elija...</option>
				  <option value="1"<?php if($modificar->estado == '1'){?> selected = 'selected' <?php }?>>Activo</option>
				  <option value="2"<?php if($modificar->estado == '2'){?> selected = 'selected' <?php }?>>Desactivado</option>
				</select>
					
				</td>
			</tr>
            <tr><td colspan="4"><hr /></td></tr>
            <tr>
            <td colspan="4"><strong>Elegir los privilegios para el usuario</strong></td>
            </tr>
            <tr><td colspan="4"><hr /></td></tr>
            <tr><td><strong>Diresa</strong></td><td><strong>Red</strong></td><td><strong>Microred</strong></td><td><strong>Establecimiento</strong></td></tr>
            <tr>
              <td bgcolor="#CCCCCC">
                <?php
                $diresa[''] = "Seleccione...";
                echo form_dropdown('diresa', $diresa, $modificar->diresa, 'id="diresa" style="width: 200px;" title="Diresa de origen del usuario"');
                ?>
              </td>
              <td bgcolor="#CCCCCC">
                <?php
                $red[''] = "Seleccione...";
                echo form_dropdown('redes', $redes, $modificar->red, 'id="redes" style="width: 200px;" title="Red de origen del usuario"');
                ?>
              </td>
              <td bgcolor="#CCCCCC">
                <?php
                $microred[''] = "Seleccione...";
                echo form_dropdown('microred', $microred, $modificar->microred, 'id="microred" style="width: 200px;" title="Microred de origen del usuario"');
                ?>
              </td>
              <td bgcolor="#CCCCCC">
                <?php
                $establec[''] = "Seleccione...";
                echo form_dropdown('establec', $establec, $modificar->establecimiento, 'id="establec" style="width: 200px;" title="Establecimiento de origen del usuario"');
                ?>
              </td>
          </tr>
          <tr>
          <td><strong>Grabar<?php 
		  if($modificar->grabar == '1'){
			echo form_checkbox('grabar', 'grabar', TRUE, 'title="Privilegio de grabaci&oacute;n para el usuario"');
		  }else{
			echo form_checkbox('grabar', 'grabar', FALSE, 'title="Privilegio de grabaci&oacute;n para el usuario"');
		  }
		  ?></strong></td>
          <td><strong>Modificar<?php 
		  if($modificar->modificar == '1'){
			  echo form_checkbox('modificar', 'modificar', TRUE, 'title="Privilegio de modificaci&oacute;n para el usuario"');
		  }else{
			  echo form_checkbox('modificar', 'modificar', FALSE, 'title="Privilegio de modificaci&oacute;n para el usuario"');
		  }
		  ?></strong></td>
          <td><strong>Eliminar<?php 
		  if($modificar->eliminar == '1'){
			  echo form_checkbox('eliminar', 'eliminar', TRUE, 'title="Privilegio de eliminaci&oacute;n para el usuario"');
		  }else{
			  echo form_checkbox('eliminar', 'eliminar', FALSE, 'title="Privilegio de eliminaci&oacute;n para el usuario"');
		  }
		  ?></strong></td>
          <td><strong>Descarga<?php 
		  if($modificar->descarga == '1'){
			  echo form_checkbox('descarga', 'descarga', TRUE, 'title="Privilegio de descarga de base de datos para el usuario"');
		  }else{
			  echo form_checkbox('descarga', 'descarga', FALSE, 'title="Privilegio de descarga de base de datos para el usuario"');
		  }
		  ?></strong></td>
          </tr>
            <tr>
            <td bgcolor="#CCCCCC"><strong>Equipo t&eacute;cnico</strong></td>
            <td colspan="3" bgcolor="#CCCCCC"><strong>&iquest;Enviar mensaje al usuario?</strong></td>
            </tr>
            <tr>
              <td bgcolor="#FFFFFF">
                <?php
                $equipo[''] = "Seleccione...";
                foreach($this->usuarios_model->listarEquipos() as $dato){
                    $equipo[$dato->codigo] = $dato->denominacion;
                }
                
                echo form_dropdown('equipo', $equipo, $modificar->equipo, 'id="equipo" style="width: 200px;" title="Equipo tem&aacute;tico de origen del usuario"');
                ?>
              </td>
              <td> 
              <?php
              echo form_checkbox('mensaje', 'mensaje', FALSE, 'title="Enviar mensaje de correo al usuario"');
			  ?>
              </td>
          </tr>
         </table>
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