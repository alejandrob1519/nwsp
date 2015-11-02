<?php
    if($this->session->flashdata('info') != ''){
        ?>
        <div class="info"><?php echo $this->session->flashdata('info'); ?></div>
        <?php
    }
    $atributos = array('id'=>'form1', 'name'=>'form1');
    echo form_open(null, $atributos);
?>
<!--<div class="formulario1">-->
    <center><h2>Ficha de Investigaci&oacute;n de brote de intoxicaci&oacute;n por plaguicidas</h2></center>
    <br />
	<div style="border: solid 1px #000; width: 100%; overflow:auto;">
		<table width="100%" align="center" cellspacing="3px">
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><strong>I. Datos Generales y del Establecimiento de salud:</strong></td>
		  	</tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><hr/></td>
	  	  </tr>
			<tr>
				<td><strong>C&oacute;digo</strong></td>
			  	<td><strong>Conocimiento local</strong></td>
			  	<td><strong>Conoc. establecimiento</strong></td>
			  	<td><strong>Fecha investigaci&oacute;n</strong></td>
			  	<td><strong>notificaci&oacute;n DIRESA</strong></td>
			  	<td><strong>Notificaci&oacute;n NACIONAL</strong></td>
          </tr>
             <tr>
				<td>
				<?php echo form_error('codigo', '<div class="warning">', '</div>'); ?> 
				<input name="codigo" type="text" id="codigo" value="<?php echo $datos->codigo?>"size="15" placeholder='Ej. 2015-00001' onkeypress="return acceptNum(event)" />
				</td>
			  	<td><?php echo form_error('fecha_loc', '<div class="warning">', '</div>'); ?>
           	    <input name="fecha_loc" type="text" id="fecha_loc" value="<?php echo $this->fechas_model->modificarFechas($datos->fecha_loc)?>" size="15" placeholder="Ej. dd-mm-YYYY" /></td>
			  	<td><?php echo form_error('fecha_est', '<div class="warning">', '</div>'); ?>
           	    <input name="fecha_est" type="text" id="fecha_est" value="<?php echo $this->fechas_model->modificarFechas($datos->fecha_est)?>" size="15" placeholder="Ej. dd-mm-YYYY" /></td>
			  	<td><?php echo form_error('fecha_inv', '<div class="warning">', '</div>'); ?>
           	    <input name="fecha_inv" type="text" id="fecha_inv" value="<?php echo $this->fechas_model->modificarFechas($datos->fecha_inv)?>" size="15" placeholder="Ej. dd-mm-YYYY" /></td>
			  	<td><?php echo form_error('fecha_dir', '<div class="warning">', '</div>'); ?>
           	    <input name="fecha_dir" type="text" id="fecha_dir" value="<?php echo $this->fechas_model->modificarFechas($datos->fecha_dir)?>" size="15" placeholder="Ej. dd-mm-YYYY" /></td>
			  	<td><?php echo form_error('fecha_not', '<div class="warning">', '</div>'); ?>
           	    <input name="fecha_not" type="text" id="fecha_not" value="<?php echo $this->fechas_model->modificarFechas($datos->fecha_not)?>" size="15" placeholder="Ej. dd-mm-YYYY" /></td>
	  	  </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><hr/></td>
	  	  </tr>
          <tr>
          	<td colspan="6"><strong>Datos del establecimiento de salud</strong></td>
          </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><hr/></td>
	  	  </tr>
			<tr>  
				<td><strong>Diresa</strong></td>
				<td><strong>Redes</strong></td>
				<td><strong>Microred</strong></td>
				<td><strong>Establecimiento</strong></td>
          </tr>
          <tr>
              <td>
              <?php echo form_error('diresa', '<div class="warning">', '</div>'); 
              echo form_dropdown('diresa', $diresa, $datos->diresa, 'id="diresa" class="form-control" style="width: 200px;"');
              ?>
              </td>
              <td>
              <?php echo form_error('redes', '<div class="warning">', '</div>'); 
              echo form_dropdown('redes', $redes, $datos->redes, 'id="redes" class="form-control" style="width: 200px;"');
              ?>
              </td>
              <td>
              <?php echo form_error('microred', '<div class="warning">', '</div>'); 
              echo form_dropdown('microred', $microred, $datos->microred, 'id="microred" class="form-control" style="width: 200px;"');
              ?>
              </td>
              <td colspan="2">
              <?php echo form_error('establec', '<div class="warning">', '</div>'); 
              echo form_dropdown('establec', $establec, $datos->e_salud, 'id="establec" class="form-control" style="width: 250px;"');
              ?>
              </td>
          </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><hr/></td>
	  	  </tr>
          <tr>
          	<td colspan="6"><strong>Lugar donde se produjo el brote</strong></td>
          </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><hr/></td>
	  	  </tr>
			<tr>  
				<td><strong>Departamento</strong></td>
				<td><strong>Provincia</strong></td>
				<td><strong>Distrito</strong></td>
				<td><strong>Localidad</strong></td>
          </tr>
            <tr>
                <td>
                    <?php echo form_error('departamento', '<div class="warning">', '</div>'); 
                    $departamento[''] = "Seleccione...";
                    echo form_dropdown('departamento', $departamento, substr($datos->ubigeo,0,2), 'id="departamento" class="form-control" style="width: 200px;"');
                    ?>
                </td>
                <td>
                    <?php echo form_error('provincia', '<div class="warning">', '</div>'); 
                    $provincia[''] = "Seleccione...";
                    echo form_dropdown('provincia', $provincia, substr($datos->ubigeo,0,4), 'id="provincia" class="form-control" style="width: 200px;"');
                    ?>
                </td>
                <td>
                    <?php echo form_error('distrito', '<div class="warning">', '</div>'); 
                    $distrito[''] = "Seleccione...";
                    echo form_dropdown('distrito', $distrito, $datos->ubigeo, 'id="distrito" class="form-control" style="width: 200px;"');
                    ?>
                </td>
				<td colspan="2">
				<input name="localidad" type="text" id="localidad" value="<?php echo $datos->localidad?>" size="25" onkeyup="javascript:this.value=this.value.toUpperCase();" /></td>
            </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><hr/></td>
	  	  </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><strong>II. Breve descripción del brote:</strong></td>
          </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><hr/></td>
	  	  </tr>
          <tr>
          <td colspan="6">
          <textarea name="descripcion" id="descripcion" rows="5" cols="150">
          <?php echo $datos->descripcion?>
          </textarea>
          </td>
          </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><hr/></td>
	  	  </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><strong>III. Investigaci&oacute;n (metodolog&iacute;a empleada)</strong></td>
          </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><hr/></td>
	  	  </tr>
          <tr>
          	<td>
            	<strong>Primer caso reportado:</strong>
            </td>
            <td colspan="2">
				<input name="indice" type="text" id="indice" value="<?php echo $datos->indice?>" size="60" onkeyup="javascript:this.value=this.value.toUpperCase();" /></td>
            </td>
            <td><strong>Fecha de reporte</strong></td>
            <td><?php echo form_error('fecha_rep', '<div class="warning">', '</div>'); ?>
            <input name="fecha_rep" type="text" id="fecha_rep" value="<?php echo $this->fechas_model->modificarFechas($datos->fecha_rep)?>" size="15" placeholder="Ej. dd-mm-YYYY" /></td>
          </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><hr/></td>
	  	  </tr>
			<tr>  
				<td><strong>Departamento</strong></td>
				<td><strong>Provincia</strong></td>
				<td><strong>Distrito</strong></td>
				<td><strong>Localidad</strong></td>
            </tr>
            <tr>
                <td>
                    <?php echo form_error('departamento', '<div class="warning">', '</div>'); 
                    $departamento14_1[''] = "Seleccione...";
                    echo form_dropdown('departamento14_1', $departamento14_1, substr($datos->ubigeo_rep,0,2), 'id="departamento14_1" class="form-control" style="width: 200px;"');
                    ?>
                </td>
                <td>
                    <?php echo form_error('provincia14_1', '<div class="warning">', '</div>'); 
                    $provincia14_1[''] = "Seleccione...";
                    echo form_dropdown('provincia14_1', $provincia14_1, substr($datos->ubigeo_rep,0,4), 'id="provincia14_1" class="form-control" style="width: 200px;"');
                    ?>
                </td>
                <td>
                    <?php echo form_error('distrito14_1', '<div class="warning">', '</div>'); 
                    $distrito14_1[''] = "Seleccione...";
                    echo form_dropdown('distrito14_1', $distrito14_1, $datos->ubigeo_rep, 'id="distrito14_1" class="form-control" style="width: 200px;"');
                    ?>
                </td>
				<td colspan="2">
				<input name="localidad_rep" type="text" id="localidad_rep" value="<?php echo $datos->localidad_rep?>" size="25" onkeyup="javascript:this.value=this.value.toUpperCase();" /></td>
            </tr>
			<tr>  
				<td><strong>Probable sustancia</strong></td>
				<td><strong>Concentraci&oacute;n</strong></td>
				<td><strong>Cantidad</strong></td>
				<td><strong>Donde obtuvo</strong></td>
				<td><strong>Expuestos</strong></td>
				<td><strong>No expuestos</strong></td>
            </tr>
            <tr>
				<td>
				<input name="sustancia" type="text" id="sustancia" value="<?php echo $datos->sustancia?>" size="25" onkeyup="javascript:this.value=this.value.toUpperCase();" /></td>
				<td>
				<input name="concentracion" type="text" id="concentracion" value="<?php echo $datos->concentracion?>" size="25" onkeyup="javascript:this.value=this.value.toUpperCase();" /></td>
				<td>
				<input name="cantidad" type="text" id="cantidad" value="<?php echo $datos->cantidad?>" size="25" onkeyup="javascript:this.value=this.value.toUpperCase();" /></td>
				<td>
				<input name="procedencia" type="text" id="procedencia" value="<?php echo $datos->procedencia?>" size="25" onkeyup="javascript:this.value=this.value.toUpperCase();" /></td>
				<td>
				<input name="expuestos" type="text" id="expuestos" value="<?php echo $datos->expuestos?>" size="25" onkeyup="javascript:this.value=this.value.toUpperCase();" /></td>
				<td>
				<input name="noexpuestos" type="text" id="noexpuestos" value="<?php echo $datos->noexpuestos?>" size="25" onkeyup="javascript:this.value=this.value.toUpperCase();" /></td>
            </tr>
			<tr>  
				<td colspan="2"><strong>Tipo de exposici&oacute;n</strong></td>
				<td><strong>Poblaci&oacute;n en riesgo</strong></td>
				<td><strong>Lugar de ocurrencia</strong></td>
				<td><strong>Actividad que realizaba</strong></td>
				<td><strong>Direccion Ocurrencia</strong></td>
            </tr>
            <tr>
				<td colspan="2">
				<input name="tipo" type="text" id="tipo" value="<?php echo $datos->tipo?>" size="60" onkeyup="javascript:this.value=this.value.toUpperCase();" /></td>
				<td>
				<input name="poblacion" type="text" id="poblacion" value="<?php echo $datos->poblacion?>" size="25" onkeyup="javascript:this.value=this.value.toUpperCase();" /></td>
				<td>
                  <?php
				  $lugar = array(''=>'Seleccione...', '1'=>'Urbana', '2'=>'Urbana marginal', '3'=>'Rural campesina', '4'=>'N localidades comprometidas');
				  echo form_dropdown('lugar', $lugar, $datos->lugar, 'id="lugar" style="width: 180px;"');
				  ?>
				<td>
				<input name="actividad" type="text" id="actividad" value="<?php echo $datos->actividad?>" size="25" onkeyup="javascript:this.value=this.value.toUpperCase();" /></td>
				<td>
				<input name="direccion" type="text" id="direccion" value="<?php echo $datos->direccion?>" size="25" onkeyup="javascript:this.value=this.value.toUpperCase();" /></td>
            </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><hr/></td>
	  	  </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><strong>IV. Ocurrencia del brote por intoxicaci&oacute;n con plaguicidas</strong></td>
          </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><hr/></td>
	  	  </tr>          
          <tr>
            <td colspan="3">
            	<strong>CONDICIONES INSEGURAS</strong>
            </td>
            <td colspan="3">
            	<strong>ACTOS INSEGUROS</strong>
            </td>
          </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><hr/></td>
	  	  </tr>
          <tr>
          	<td colspan="2">
            	<strong>1. Mal estado de equipos de fumigaci&oacute;n</strong>
            </td>
          	<td>
				<?php
                $condicion1 = array(''=>'Seleccione...', '1'=>'Si', '2'=>'No');
                echo form_dropdown('condicion1', $condicion1, $datos->condicion1, 'id="condicion1" style="width: 100px;"');
                ?>
            </td>
          	<td colspan="2">
            	<strong>1. Uso de equipos de proteci&oacute;n personal</strong>
            </td>
          	<td>
				<?php
                $acto1 = array(''=>'Seleccione...', '1'=>'Si', '2'=>'No');
                echo form_dropdown('acto1', $acto1, $datos->acto1, 'id="acto1" style="width: 100px;"');
                ?>
            </td>
          </tr>
          <tr>
          	<td colspan="2">
            	<strong>2. Envase inadecuado del producto qu&iacute;mico</strong>
            </td>
          	<td>
				<?php
                $condicion2 = array(''=>'Seleccione...', '1'=>'Si', '2'=>'No');
                echo form_dropdown('condicion2', $condicion2, $datos->condicion2, 'id="condicion2" style="width: 100px;"');
                ?>
            </td>
          	<td colspan="2">
            	<strong>2. Comer durante la aplicaci&oacute;n de plaguicidas</strong>
            </td>
          	<td>
				<?php
                $acto2 = array(''=>'Seleccione...', '1'=>'Si', '2'=>'No');
                echo form_dropdown('acto2', $acto2, $datos->acto2, 'id="acto2" style="width: 100px;"');
                ?>
            </td>
          </tr>
          <tr>
          	<td colspan="2">
            	<strong>3. Orden de ingreso a campo reci&eacute;n fumigado</strong>
            </td>
          	<td>
				<?php
                $condicion3 = array(''=>'Seleccione...', '1'=>'Si', '2'=>'No');
                echo form_dropdown('condicion3', $condicion3, $datos->condicion3, 'id="condicion3" style="width: 100px;"');
                ?>
            </td>
          	<td colspan="2">
            	<strong>3. Fumar durante la aplicaci&oacute;n de plaguicidas</strong>
            </td>
          	<td>
				<?php
                $acto3 = array(''=>'Seleccione...', '1'=>'Si', '2'=>'No');
                echo form_dropdown('acto3', $acto3, $datos->acto3, 'id="acto3" style="width: 100px;"');
                ?>
            </td>
          </tr>
          <tr>
          	<td colspan="2">
            	<strong>4. Almacenamiento inadecuado de productos qu&iacute;micos</strong>
            </td>
          	<td>
				<?php
                $condicion4 = array(''=>'Seleccione...', '1'=>'Si', '2'=>'No');
                echo form_dropdown('condicion4', $condicion4, $datos->condicion4, 'id="condicion4" style="width: 100px;"');
                ?>
            </td>
          	<td colspan="2">
            	<strong>4. Uso dom&eacute;stico de envases de plaguicidas</strong>
            </td>
          	<td>
				<?php
                $acto4 = array(''=>'Seleccione...', '1'=>'Si', '2'=>'No');
                echo form_dropdown('acto4', $acto4, $datos->acto4, 'id="acto4" style="width: 100px;"');
                ?>
            </td>
          </tr>
          <tr>
          	<td colspan="2">
            	<strong>5. Falta de se&ntilde;alizaci&oacute;n</strong>
            </td>
          	<td>
				<?php
                $condicion5 = array(''=>'Seleccione...', '1'=>'Si', '2'=>'No');
                echo form_dropdown('condicion5', $condicion5, $datos->condicion5, 'id="condicion5" style="width: 100px;"');
                ?>
            </td>
          	<td colspan="2">
            	<strong>5. Estado de embriaguez</strong>
            </td>
          	<td>
				<?php
                $acto5 = array(''=>'Seleccione...', '1'=>'Si', '2'=>'No');
                echo form_dropdown('acto5', $acto5, $datos->acto5, 'id="acto5" style="width: 100px;"');
                ?>
            </td>
          </tr>
          <tr>
          	<td colspan="2">
            	<strong>6. Mezcla y reenvase de productos</strong>
            </td>
          	<td>
				<?php
                $condicion6 = array(''=>'Seleccione...', '1'=>'Si', '2'=>'No');
                echo form_dropdown('condicion6', $condicion6, $datos->condicion6, 'id="condicion6" style="width: 100px;"');
                ?>
            </td>
          	<td colspan="2">
            	<strong>6. Intento de suicidio</strong>
            </td>
          	<td>
				<?php
                $acto6 = array(''=>'Seleccione...', '1'=>'Si', '2'=>'No');
                echo form_dropdown('acto6', $acto6, $datos->acto6, 'id="acto6" style="width: 100px;"');
                ?>
            </td>
          </tr>
          <tr>
          	<td colspan="2">
            	<strong>7. Da&ntilde;os intencionales al medio ambiente</strong>
            </td>
          	<td>
				<?php
                $condicion7 = array(''=>'Seleccione...', '1'=>'Si', '2'=>'No');
                echo form_dropdown('condicion7', $condicion7, $datos->condicion7, 'id="condicion7" style="width: 100px;"');
                ?>
            </td>
          	<td colspan="2">
            	<strong>7. Intento de homicidio</strong>
            </td>
          	<td>
				<?php
                $acto7 = array(''=>'Seleccione...', '1'=>'Si', '2'=>'No');
                echo form_dropdown('acto7', $acto7, $datos->acto7, 'id="acto7" style="width: 100px;"');
                ?>
            </td>
          </tr>
          <tr>
          	<td colspan="2">
            	<strong>8. Otros (especificar)</strong>
            </td>
          	<td>
				<?php
                $condicion8 = array(''=>'Seleccione...', '1'=>'Si', '2'=>'No');
                echo form_dropdown('condicion8', $condicion8, $datos->condicion8, 'id="condicion8" style="width: 100px;"');
                ?>
            </td>
          	<td colspan="2">
            	<strong>8. Consumo de productos contaminados</strong>
            </td>
          	<td>
				<?php
                $acto8 = array(''=>'Seleccione...', '1'=>'Si', '2'=>'No');
                echo form_dropdown('acto8', $acto8, $datos->acto8, 'id="acto8" style="width: 100px;"');
                ?>
            </td>
          </tr>
          <tr>
          	<td colspan="3">
  				<input name="condicion_otros" type="text" id="condicion_otros" value="<?php echo $datos->condicion_otros?>" size="83" onkeyup="javascript:this.value=this.value.toUpperCase();" />
	        </td>
          	<td colspan="2">
            	<strong>9. Cumple copn recomendaciones indicadas</strong>
            </td>
          	<td>
				<?php
                $acto9 = array(''=>'Seleccione...', '1'=>'Si', '2'=>'No');
                echo form_dropdown('acto9', $acto9, $datos->acto9, 'id="acto9" style="width: 100px;"');
                ?>
            </td>
          </tr>
          <tr>
          	<td colspan="3">
            </td>
          </td>
          	<td colspan="2">
            	<strong>10. Otros (especificar)</strong>
            </td>
          	<td>
				<?php
                $acto10 = array(''=>'Seleccione...', '1'=>'Si', '2'=>'No');
                echo form_dropdown('acto10', $acto10, $datos->acto10, 'id="acto10" style="width: 100px;"');
                ?>
            </td>
          </tr>
          <tr>
          	<td colspan="3">
            </td>
          </td>
          	<td colspan="3">
  				<input name="acto_otros" type="text" id="acto_otros" value="<?php echo $datos->acto_otros?>" size="77" onkeyup="javascript:this.value=this.value.toUpperCase();" />
            </td>
          </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><hr/></td>
	  	  </tr>
          <tr>
            <td colspan="3">
            	<strong>ACCIONES REALIZADAS</strong>
            </td>
            <td colspan="3">
            	<strong>ACCIONES RECOMENDADAS</strong>
            </td>
          </tr>
          <tr>
          	<td colspan="2">
            	<strong>1. B&uacute;squeda activa de nuevos casos</strong>
            </td>
          	<td>
  				<input name="busqueda" type="text" id="busqueda" value="<?php echo $datos->busqueda?>" size="20" onkeyup="javascript:this.value=this.value.toUpperCase();" />
            </td>
          </td>
          	<td colspan="3">
  				<input name="acciones1" type="text" id="acciones1" value="<?php echo $datos->acciones1?>" size="50" onkeyup="javascript:this.value=this.value.toUpperCase();" />
            </td>
          </tr>
          <tr>
          	<td colspan="2">
            	<strong>2. Educaci&oacute;n a personas expuestas</strong>
            </td>
          	<td>
  				<input name="educacion" type="text" id="educacion" value="<?php echo $datos->educacion?>" size="20" onkeyup="javascript:this.value=this.value.toUpperCase();" />
            </td>
          </td>
          	<td colspan="3">
  				<input name="acciones2" type="text" id="acciones2" value="<?php echo $datos->acciones2?>" size="50" onkeyup="javascript:this.value=this.value.toUpperCase();" />
            </td>
          </tr>
          <tr>
          	<td colspan="2">
            	<strong>3. Ex&aacute;menes de laboratorio</strong>
            </td>
          	<td>
  				<input name="examenes" type="text" id="examenes" value="<?php echo $datos->examenes?>" size="20" onkeyup="javascript:this.value=this.value.toUpperCase();" />
            </td>
          </td>
          	<td colspan="3">
  				<input name="acciones3" type="text" id="acciones3" value="<?php echo $datos->acciones3?>" size="50" onkeyup="javascript:this.value=this.value.toUpperCase();" />
            </td>
          </tr>
          <tr>
          	<td colspan="2">
            	<strong>4. Llenado de fichas individuales</strong>
            </td>
          	<td>
  				<input name="fichas" type="text" id="fichas" value="<?php echo $datos->fichas?>" size="20" onkeyup="javascript:this.value=this.value.toUpperCase();" />
            </td>
          </td>
          	<td colspan="3">
  				<input name="acciones4" type="text" id="acciones4" value="<?php echo $datos->acciones4?>" size="50" onkeyup="javascript:this.value=this.value.toUpperCase();" />
            </td>
          </tr>
          <tr>
          	<td colspan="2">
            	<strong>5. Informe t&eacute;cnico</strong>
            </td>
          	<td>
  				<input name="informe" type="text" id="informe" value="<?php echo $datos->informe?>" size="20" onkeyup="javascript:this.value=this.value.toUpperCase();" />
            </td>
          </td>
          	<td colspan="3">
  				<input name="acciones5" type="text" id="acciones5" value="<?php echo $datos->acciones5?>" size="50" onkeyup="javascript:this.value=this.value.toUpperCase();" />
            </td>
          </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><hr/></td>
	  	  </tr>
          <tr>
          	<td colspan="2">
            	<strong>Personas participantes en la investigaci&oacute;n del brote</strong>
            </td>
          	<td>
  				<input name="personas" type="text" id="personas" value="<?php echo $datos->personas?>" size="20" onkeyup="javascript:this.value=this.value.toUpperCase();" />
            </td>
          </td>
          	<td>
            	<strong>Instituciones</strong>
            </td>
          	<td>
  				<input name="instituciones" type="text" id="instituciones" value="<?php echo $datos->instituciones?>" size="25" onkeyup="javascript:this.value=this.value.toUpperCase();" />
            </td>
          </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><hr/></td>
	  	  </tr>
          <tr>
          	<td>
            	<strong>Observaciones:</strong>
            </td>
          	<td colspan="5">
  				<input name="observaciones" type="text" id="observaciones" value="<?php echo $datos->observaciones?>" size="65" onkeyup="javascript:this.value=this.value.toUpperCase();" />
            </td>
          </td>
          </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><hr/></td>
	  	  </tr>
          <tr>  
              <td><strong>Responsable</strong></td>
              <td><strong>Profesi&oacute;n</strong></td>
              <td><strong>Cargo</strong></td>
              <td><strong>Tel&eacute;fono</strong></td>
              <td><strong>Celular</strong></td>
          </tr>
          <tr>
              <td><?php echo form_error('responsable', '<div class="warning">', '</div>'); ?>
              <input name="responsable" type="text" id="responsable" value="<?php echo $datos->responsable?>"  title="Ingrese el nombre del responsable" onkeyup="javascript:this.value=this.value.toUpperCase();" size="25" /></td>
              <td><?php echo form_error('profesion', '<div class="warning">', '</div>'); ?>
              <input name="profesion" type="text" id="profesion" value="<?php echo $datos->profesion?>"  title="Ingrese la profesi&oacute;n del investigador" onkeyup="javascript:this.value=this.value.toUpperCase();" size="25" /></td>
              <td><?php echo form_error('cargo', '<div class="warning">', '</div>'); ?>
              <input name="cargo" type="text" id="cargo" value="<?php echo $datos->cargo?>"  title="Ingrese el cargo del responsable" onkeyup="javascript:this.value=this.value.toUpperCase();" size="25" /></td>
              <td><?php echo form_error('telefono', '<div class="warning">', '</div>'); ?>
              <input name="telefono" type="text" id="telefono" value="<?php echo $datos->telefono?>"  title="Ingrese el telefono o celular del responsable" onkeypress="return acceptNum(event)" size="20" /></td>
              <td><?php echo form_error('celular', '<div class="warning">', '</div>'); ?>
              <input name="celular" type="text" id="celular" value="<?php echo $datos->celular?>"  title="Ingrese el telefono o celular del responsable" onkeypress="return acceptNum(event)" size="20" /></td>
          </tr>
		  <tr>
			  <td colspan="6" bgcolor="#CCCCCC"><hr/></td>
	  	  </tr>
          <tr>
			  <td colspan="8" align="right">
				<input type="button" id="botonListado" name="volver" value="&nbsp;&nbsp;&nbsp;Listado" onclick="window.location='<?php echo site_url('modulos4/listarBrotes'); ?>'" />
				<input type="submit" id="botonGrabar" name="enviar" value="&nbsp;&nbsp;&nbsp;Grabar" />
			  </td>
		  </tr>
		</table>  
	</div>
    <br/>  
<!--</div>-->
<?php
    echo form_close();
?>