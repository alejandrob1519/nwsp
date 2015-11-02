<?php
    if($this->session->flashdata('ControllerMessage') != ''){
        ?>
        <div class="error"><?php echo $this->session->flashdata('ControllerMessage'); ?></div>
        <?php
    }
    $atributos = array('id'=>'form1', 'name'=>'form1');
    echo form_open(null, $atributos);
	
	$fecha = date("d-m-Y");
?>
<div class="formulario1">
    <center><h2>Registro de Usuarios Operadores del Sistema</h2></center>
	<div style="width: 100%;">
		<table width="100%" align="center">
			<tr>  
				<td width="23%" bgcolor="#CCCCCC"><strong>Usuario : </strong></td>
				<td width="77%" bgcolor="#CCCCCC" colspan="3">
				<?php echo form_error('codigo', '<div class="warning">', '</div>'); ?> 
				<input name="codigo" type="text" id="codigo" title="Ingrese el c&oacute;digo del usuario" value="<?php echo $this->input->post("codigo", true);?>" />
				</td>
			</tr>
			<tr>  
				<td bgcolor="#FFFFFF"><strong>Contrase&ntilde;a :</strong></td>
				<td bgcolor="#FFFFFF" colspan="3">
				<?php echo form_error('clave', '<div class="warning">', '</div>'); ?> 
				<input name="clave" type="password" id="clave" title="Ingrese la contrase&ntilde;a del usuario" value="1234567" /> Ej. por defecto se encuentra ingresado el: 1234567
				</td>
			</tr>
			<tr>
			  <td bgcolor="#CCCCCC"><strong>Nombres :</strong></td>
			  <td bgcolor="#CCCCCC" colspan="3"><?php echo form_error('nombres', '<div class="warning">', '</div>'); ?>
              <input name="nombres" type="text" id="nombres" title="Ingrese los apellidos y nombres del usuario" value="<?php echo set_value('nombres')?>" onkeyup="javascript:this.value=this.value.toUpperCase();" size="100" /></td>
		  </tr>
			<tr>  
				<td bgcolor="#FFFFFF"><strong>DNI :</strong></td>
				<td bgcolor="#FFFFFF" colspan="3">
				<?php echo form_error('dni', '<div class="warning">', '</div>'); ?> 
				<input name="dni" type="text" id="dni" title="Ingrese el DNI del usuario" value="<?php echo set_value('dni')?>" />
				</td>
			</tr>
			<tr>  
				<td bgcolor="#CCCCCC"><strong>
				  Correo :
			  </strong></td>
				<td bgcolor="#CCCCCC" colspan="3">
				<?php echo form_error('correo', '<div class="warning">', '</div>'); ?> 
				<input name="correo" type="text" id="correo" title="Ingrese el correo electr&oacute;nico del usuario" value="<?php echo set_value('correo')?>" size="55" />
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
					  <option value="<?php echo $niv; ?>"><?php echo $nom; ?></option>
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
				  <option value="">Elija...</option>
				  <option value="A">MINSA</option>
				  <option value="C">ESSALUD</option>
				  <option value="D">FFAA/PNP</option>
				  <option value="X">PRIVADOS</option>
				</select>
				</td>
			</tr>
			<tr>
			  <td bgcolor="#CCCCCC"><strong>Caducidad :</strong></td>
			  <td bgcolor="#CCCCCC" colspan="3"><?php echo form_error('caduca', '<div class="warning">', '</div>'); ?>
              <input name="caduca" type="text" id="caduca" title="Ingrese la fecha de caducidad del usuario" value="<?php echo $this->usuarios_model->dateadd($fecha,0,0,1,0,0,0)?>" placeholder='Ej. dd-mm-YYYY' /></td>
		  </tr>
			<tr>  
				<td bgcolor="#FFFFFF"><strong>Estado :</strong></td>
				<td bgcolor="#FFFFFF" colspan="3">
				<?php echo form_error('estado', '<div class="warning">', '</div>'); ?> 
				<select name="estado" id="estado" title="No olvide activar al usuario" style="width:140px;">
				  <option value="">Elija...</option>
				  <option value="1">Activo</option>
				  <option value="2">Desactivado</option>
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
                $subreg[''] = "Seleccione...";
                foreach($this->mantenimiento_model->buscarDiresas() as $diresa){
                    $subreg[$diresa->codigo] = $diresa->nombre;
                }
                
                echo form_dropdown('diresa', $subreg, null, 'id="diresa" style="width: 200px;" title="Diresa de origen del usuario"');
                ?>
              </td>
              <td bgcolor="#CCCCCC">
                <?php
                $red[''] = "Seleccione...";
                echo form_dropdown('redes', $red, null, 'id="redes" style="width: 200px;" title="Red de origen del usuario"');
                ?>
              </td>
              <td bgcolor="#CCCCCC">
                <?php
                $mred[''] = "Seleccione...";
                echo form_dropdown('microred', $mred, null, 'id="microred" style="width: 200px;" title="Microred de origen del usuario"');
                ?>
              </td>
              <td bgcolor="#CCCCCC">
                <?php
                $est[''] = "Seleccione...";
                echo form_dropdown('establec', $est, null, 'id="establec" style="width: 200px;" title="Establecimiento de origen del usuario"');
                ?>
              </td>
          </tr>
          <tr>
          <td><strong>Grabar<?php echo form_checkbox('grabar', 'grabar', FALSE, 'title="Privilegio de grabaci&oacute;n para el usuario"');?></strong></td>
          <td><strong>Modificar<?php echo form_checkbox('modificar', 'modificar', FALSE, 'title="Privilegio de modificaci&oacute;n para el usuario"');?></strong></td>
          <td><strong>Eliminar<?php echo form_checkbox('eliminar', 'eliminar', FALSE, 'title="Privilegio de eliminaci&oacute;n para el usuario"');?></strong></td>
          <td><strong>Descargar<?php echo form_checkbox('descargar', 'descargar', FALSE, 'title="Privilegio de descarga de base de datos para el usuario"');?></strong></td>
          </tr>
            <tr><td colspan="4" bgcolor="#CCCCCC"><strong>Equipo t&eacute;cnico</strong></td></tr>
            <tr>
              <td bgcolor="#FFFFFF">
                <?php
                $equipo[''] = "Seleccione...";
                foreach($this->usuarios_model->listarEquipos() as $dato){
                    $equipo[$dato->codigo] = $dato->denominacion;
                }
                
                echo form_dropdown('equipo', $equipo, null, 'id="equipo" style="width: 200px;" title="Equipo tem&aacute;tico de origen del usuario"');
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