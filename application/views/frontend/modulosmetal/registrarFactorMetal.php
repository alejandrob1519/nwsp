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
	<?php
		$estab = $datos->e_salud;
		$dir = $datos->sub_reg_nt;
		$rd = $datos->red;
		$mrd = $datos->microred;

        $datos1 = $this->frontend_model->buscarDepartamento(substr($estab,0,2));
		$departamento1 = $datos1->nombre;
        $datos2 = $this->frontend_model->buscarProvincia(substr($estab,0,4));
		$provincia1 = $datos2->nombre;
        $datos3 = $this->frontend_model->muestraDistrito(substr($estab,0,6));
		$distrito1 = $datos3->nombre;
	?>
    <center><h2>Ficha de Investigaci&oacute;n epidemiol&oacute;gica en salud p&uacute;blica del riesgo de exposici&oacute;n e intoxicaci&oacute;n por plaguicidas</h2></center>
    <br />
	<div style="border: solid 1px #000; width: 100%; overflow:auto;">
		<table width="100%" align="center" cellspacing="3px">
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><strong>I. Datos Generales:</strong></td>
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
				<input name="codigo" type="text" id="codigo" value="<?php echo set_value('codigo');?>"size="15" placeholder='Ej. 2015-00001' onkeypress="return acceptNum(event)" />
				</td>
			  	<td><?php echo form_error('fecha_loc', '<div class="warning">', '</div>'); ?>
           	    <input name="fecha_loc" type="text" id="fecha_loc" value="<?php echo set_value('fecha_loc');?>" size="15" placeholder="Ej. dd-mm-YYYY" /></td>
			  	<td><?php echo form_error('fecha_est', '<div class="warning">', '</div>'); ?>
           	    <input name="fecha_est" type="text" id="fecha_est" value="<?php echo set_value('fecha_est');?>" size="15" placeholder="Ej. dd-mm-YYYY" /></td>
			  	<td><?php echo form_error('fecha_inv', '<div class="warning">', '</div>'); ?>
           	    <input name="fecha_inv" type="text" id="fecha_inv" value="<?php echo $this->fechas_model->modificarFechas($datos->fecha_inv);?>" size="15" readonly = "readonly" /></td>
			  	<td><?php echo form_error('fecha_dir', '<div class="warning">', '</div>'); ?>
           	    <input name="fecha_dir" type="text" id="fecha_dir" value="<?php echo set_value('fecha_dir');?>" size="15" placeholder="Ej. dd-mm-YYYY" /></td>
			  	<td><?php echo form_error('fecha_not', '<div class="warning">', '</div>'); ?>
           	    <input name="fecha_not" type="text" id="fecha_not" value="<?php echo $this->fechas_model->modificarFechas($datos->fecha_not);?>" size="15" readonly = "readonly" /></td>
	  	  </tr>
			<tr>  
				<td><strong>Diresa</strong></td>
				<td><strong>Redes</strong></td>
				<td><strong>Microred</strong></td>
				<td><strong>Establecimiento</strong></td>
          </tr>
            <tr>
				<td>
				<input name="subregion" type="text" id="subregion" value="<?php echo $datos->diresa;?>" size="25" readonly = "readonly" /></td>
				<td>
				<input name="red" type="text" id="red" value="<?php echo $datos->redes;?>" size="25" readonly = "readonly" /></td>
				<td>
				<input name="mred" type="text" id="mred" value="<?php echo $datos->microredes;?>" size="25" readonly = "readonly" /></td>
				<td>
				<input name="establecimiento" type="text" id="establecimiento" value="<?php echo $datos->raz_soc;?>" size="25" readonly = "readonly" /></td>
            </tr>
			<tr>  
				<td><strong>Departamento</strong></td>
				<td><strong>Provincia</strong></td>
				<td><strong>Distrito</strong></td>
				<td><strong>Localidad</strong></td>
				<td><strong>Captado</strong></td>
				<td><strong>Notificaci&oacute;n</strong></td>
          </tr>
            <tr>
				<td>
				<input name="departamento1" type="text" id="departamento1" value="<?php echo $departamento1;?>" size="25" readonly = "readonly" /></td>
				<td>
				<input name="provincia1" type="text" id="provincia1" value="<?php echo $provincia1;?>" size="25" readonly = "readonly" /></td>
				<td>
				<input name="distrito1" type="text" id="distrito1" value="<?php echo $distrito1;?>" size="25" readonly = "readonly" /></td>
				<td>
				<input name="localidad1" type="text" id="localidad1" value="<?php echo set_value('localidad1');?>" size="25" onkeyup="javascript:this.value=this.value.toUpperCase();" /></td>
				<td>
                  <?php
				  $captado = array(''=>'Seleccione...', '1'=>'Servicio de Inteligencia', '2'=>'Hospitalizaci&oacute;n', '3'=>'Consulta externa', '4'=>'Otros');
				  echo form_dropdown('captado', $captado, set_value('captado'), 'id="captado" style="width: 150px;"');
				  ?>
				</td>
				<td>
                  <?php
				  $notificacion = array(''=>'Seleccione...', '1'=>'Notificaci&oacute;n regular', '2'=>'B&uacute;squeda activa', '3'=>'Situaci&oacute;n de riesgo', '4'=>'Investigaci&oacute;n de brote', '5'=>'Otros');
				  echo form_dropdown('notificacion', $notificacion, set_value('notificacion'), 'id="notificacion" style="width: 150px;"');
				  ?>
				</td>
            </tr>
			<tr>  
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td>
                <input name="captado_otro" type="text" id="captado_otro" value="<?php echo set_value('captado_otro');?>" size="20" onkeyup="javascript:this.value=this.value.toUpperCase();" />
				</td>
				<td>
                <input name="notifica_otro" type="text" id="notifica_otro" value="<?php echo set_value('notifica_otro');?>" size="20" onkeyup="javascript:this.value=this.value.toUpperCase();" />
                </td>
          </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><hr/></td>
	  	  </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><strong>II. Datos del paciente:</strong></td>
          </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><hr/></td>
	  	  </tr>
            <tr>
				<td><strong>Apellido Paterno</strong></td>
				<td><strong>Apellido Materno</strong></td>
				<td><strong>Nombres</strong></td>
				<td><strong>Fecha de Nacimiento</strong></td>
				<td><strong>Lugar de Nacimiento</strong></td>
  	      </tr>
            <tr>
			  	<td><?php echo form_error('paterno', '<div class="warning">', '</div>'); ?>
           	  <input name="paterno" type="text" id="paterno" value="<?php echo $datos->apepat;?>" size="25" readonly = "readonly" /></td>
			  	<td><?php echo form_error('materno', '<div class="warning">', '</div>'); ?>
           	  <input name="materno" type="text" id="materno" value="<?php echo $datos->apemat;?>" size="25" readonly = "readonly" /></td>
			  	<td><?php echo form_error('nombres', '<div class="warning">', '</div>'); ?>
           	  <input name="nombres" type="text" id="nombres" value="<?php echo $datos->nombres;?>" size="25" readonly = "readonly" /></td>
			  	<td><?php echo form_error('fecha_nac', '<div class="warning">', '</div>'); ?>
                <input name="fecha_nac" type="text" id="fecha_nac" value="<?php echo set_value('fecha_nac')?>"  title="Ingrese la fecha de nacimiento del paciente" placeholder="Ej. dd-mm-YYYY" size="20" /></td>
			  	<td><?php echo form_error('lugar_nac', '<div class="warning">', '</div>'); ?>
           	  <input name="lugar_nac" type="text" id="lugar_nac" value="<?php echo set_value('lugar_nac')?>" size="25" onkeyup="javascript:this.value=this.value.toUpperCase();" /></td>
          </tr>
            <tr>
				<td><strong>Edad</strong></td>
				<td><strong>Tipo de Edad</strong></td>
				<td><strong>Sexo</strong></td>
				<td><strong>DNI</strong></td>
				<td><strong>Embarazada</strong></td>
				<td><strong>Grado deinstrucci&oacute;n</strong></td>
  	      </tr>
             <tr>
			  	<td><?php echo form_error('edad', '<div class="warning">', '</div>'); ?>
           	   <input name="edad" type="text" id="edad" value="<?php echo $datos->edad;?>" size="25" readonly = "readonly" /></td>
				<td>
				 <?php
                 switch($datos->tipo_edad)
                 {
                     case 'A':
                     $tedad = 'AÑOS';
                     break;
                     case 'M':
                     $tedad = 'MESES';
                     break;
                     case 'D':
                     $tedad = 'DIAS';
                     break;
                 }
                 ?>
				 <input name="tipo_edad" type="text" id="tipo_edad" value="<?php echo $tedad;?>" size="25" readonly = "readonly" />
				</td>
				<td>
				 <?php
                 switch($datos->sexo)
                 {
                     case 'M':
                     $sexo = 'MASCULINO';
                     break;
                     case 'F':
                     $sexo = 'FEMENINO';
                     break;
                 }
                 ?>
				 <input name="sexo" type="text" id="sexo" value="<?php echo $sexo;?>" size="25" readonly = "readonly" />
				</td>
			  	<td><input name="dni" type="text" id="dni" value="<?php echo $datos->dni;?>" size="20" readonly = "readonly" /></td>
				<td>
                  <?php
				  $embarazada = array(''=>'Seleccione...', '1'=>'Si', '2'=>'No');
				  echo form_dropdown('embarazada', $embarazada, set_value('embarazada'), 'id="embarazada" style="width: 150px;"');
				  ?>
				</td>
				<td><?php echo form_error('instruccion', '<div class="warning">', '</div>'); ?>
                  <?php
				  $instruccion = array(''=>'Seleccione...', '1'=>'Inicial', '2'=>'Primaria', '3'=>'Secundaria', '4'=>'Superior', '5'=>'Sin instrucci&oacute;n');
				  echo form_dropdown('instruccion', $instruccion, set_value('instruccion'), 'id="instruccion" style="width: 150px;"');
				  ?>
				</td>
			</tr>
            <tr>
				<td><strong>Seguro</strong></td>
				<td><strong>Otros</strong></td>
				<td><strong>Ocupaci&oacute;n</strong></td>
  	      	</tr>
            <tr>
				<td><?php echo form_error('seguro', '<div class="warning">', '</div>'); ?>
                  <?php
				  $seguro = array(''=>'Seleccione...', '1'=>'Seguro Integral de Salud - SIS', '2'=>'ESSALUD');
				  echo form_dropdown('seguro', $seguro, set_value('seguro'), 'id="seguro" style="width: 150px;"');
				  ?>
				</td>
			  	<td><input name="seguro_otro" type="text" id="seguro_otro" value="<?php echo set_value('seguro_otro')?>" size="25" onkeyup="javascript:this.value=this.value.toUpperCase();" /></td>
			  	<td><input name="ocupacion" type="text" id="ocupacion" value="<?php echo set_value('ocupacion')?>" size="25" onkeyup="javascript:this.value=this.value.toUpperCase();" /></td>
            </tr>
            <tr>
				<td><strong>Departamento</strong></td>
				<td><strong>Provincia</strong></td>
				<td><strong>Distrito</strong></td>
				<td><strong>Localidad</strong></td>
				<td colspan="2"><strong>Direcci&oacute;n</strong></td>
  	      	</tr>
            <tr>
				<td><?php echo form_error('departamento', '<div class="warning">', '</div>'); ?>
                  <?php
				  $dep[''] = "Seleccione...";
				  foreach($this->mantenimiento_model->buscarDepartamentos() as $dato){
					  $dep[$dato->ubigeo] = $dato->nombre;
				  }
				  echo form_dropdown('departamento', $dep, set_value('departamento'), 'id="departamento" style="width: 185px;"');
				  ?>
				</td>
				<td><?php echo form_error('provincia', '<div class="warning">', '</div>'); ?>
                  <?php
				  $prov[''] = "Seleccione...";
				  echo form_dropdown('provincia', $prov, set_value('provincia'), 'id="provincia" style="width: 185px;"');
				  ?>
				</td>
				<td><?php echo form_error('distrito', '<div class="warning">', '</div>'); ?>
                  <?php
				  $dist[''] = "Seleccione...";
				  echo form_dropdown('distrito', $dist, set_value('distrito'), 'id="distrito" style="width: 185px;"');
				  ?>
				</td>
			  	<td><?php echo form_error('localidad', '<div class="warning">', '</div>'); ?>
                <input name="localidad" type="text" id="localidad" value="<?php echo set_value('localidad');?>" title="Ingrese la localidad donde habita el paciente" onkeyup="javascript:this.value=this.value.toUpperCase();" size="25" /></td>
			  	<td colspan="2"><?php echo form_error('direccion', '<div class="warning">', '</div>'); ?>
           	  	<input name="direccion" type="text" id="direccion" value="<?php echo $datos->direccion;?>" size="55" readonly = "readonly" /></td>
          	</tr>
            <tr>
				<td><strong>Tel&eacute;fono</strong></td>
				<td><strong>Referencia</strong></td>
				<td><strong>Etnia</strong></td>
				<td><strong>Otro</strong></td>
				<td><strong>Procedencia habitual</strong></td>
            </tr>
			<tr>                
			  	<td><input name="telefono" type="text" id="telefono" value="<?php echo set_value('telefono');?>" title="Ingrese el tel&eacute;fono del paciente o familiar" size="25" /></td>
			  	<td><input name="referencia" type="text" id="referencia" value="<?php echo set_value('referencia');?>" title="Ingrese la referencia de la direcci&oacute;n" onkeyup="javascript:this.value=this.value.toUpperCase();" size="25" /></td>
				<td><?php echo form_error('etnia', '<div class="warning">', '</div>'); ?>
                  <?php
				  $etnia = array(''=>'Seleccione...', '1'=>'Mestizo', '2'=>'Afrodescendiente', '3'=>'Andino', '4'=>'Ind&iacute;gena amaz&oacute;nico', '5'=>'Asi&aacute;tico descendiente', '6'=>'Otro');
				  echo form_dropdown('etnia', $etnia, set_value('etnia'), 'id="etnia" style="width: 185px;"');
				  ?>
				</td>
			  	<td><input name="etnia_otro" type="text" id="etnia_otro" value="<?php echo set_value('etnia_otro');?>" title="Ingrese la otra etnia" onkeyup="javascript:this.value=this.value.toUpperCase();" size="25" /></td>
				<td>
                  <?php
				  $procedencia = array(''=>'Seleccione...', '1'=>'Urbana', '2'=>'Urbana Marginal', '3'=>'Rural Campesina', '4'=>'Campamento');
				  echo form_dropdown('procedencia', $procedencia, set_value('procedencia'), 'id="procedencia" style="width: 150px;"');
				  ?>
				</td>
	  	  	</tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><hr/></td>
	  	  </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><strong>III. Factores de riesgo epidemiol&oacute;gico</strong></td>
          </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><hr/></td>
	  	  </tr>
            <tr>
				<td><strong>Fecha Intoxicaci&oacute;n</strong></td>
				<td><strong>Hora</strong></td>
				<td><strong>Lugar de Ocurrencia</strong></td>
				<td><strong>Lugar de Trabajo</strong></td>
				<td><strong>Otros</strong></td>
  	      </tr>
			  	<td><?php echo form_error('fecha_int', '<div class="warning">', '</div>'); ?>
                <input name="fecha_int" type="text" id="fecha_int" value="<?php echo set_value('fecha_int')?>"  title="Ingrese la fecha de intoxicaci&oacute;n del paciente" placeholder="Ej. dd-mm-YYYY" size="20" /></td>
			  	<td><?php echo form_error('hora', '<div class="warning">', '</div>'); ?>
                <input name="hora" type="text" id="hora" value="<?php echo set_value('hora')?>"  title="Ingrese la hora de intoxicaci&oacute;n del paciente" placeholder="Ej. hh.mm" size="10" onkeypress="return acceptNum(event)" />
				<?php
                $meridiano = array(''=>'Seleccione...', '1'=>'AM.', '2'=>'PM.');
                echo form_dropdown('meridiano', $meridiano, set_value('meridiano'), 'id="meridiano" style="width: 100px;"');
                ?>
                </td>
			  	<td>
				<?php
                $ocurrencia = array(''=>'Seleccione...', '1'=>'Casa', '2'=>'Escuela', '3'=>'Trabajo');
                echo form_dropdown('ocurrencia', $ocurrencia, set_value('ocurrencia'), 'id="ocurrencia" style="width: 185px;"');
                ?>
			  	<td><?php echo form_error('trabajo', '<div class="warning">', '</div>'); ?>
                <input name="trabajo" type="text" id="trabajo" value="<?php echo set_value('trabajo')?>"  title="Especificar el lugar de trabajo" onkeyup="javascript:this.value=this.value.toUpperCase();" size="25" />
                </td>
			  	<td><?php echo form_error('ocurrencia_otro', '<div class="warning">', '</div>'); ?>
                <input name="ocurrencia_otro" type="text" id="ocurrencia_otro" value="<?php echo set_value('ocurrencia_otro')?>"  onkeyup="javascript:this.value=this.value.toUpperCase();" title="Ingrese otro lugar de ocurrencia de la intoxicaci&oacute;n" size="25" />
                </td>
            <tr>
				<td><strong>Departamento</strong></td>
				<td><strong>Provincia</strong></td>
				<td><strong>Distrito</strong></td>
				<td><strong>Localidad</strong></td>
				<td colspan="2"><strong>Direcci&oacute;n</strong></td>
  	      </tr>
            <tr>
				<td>
                  <?php
				  $dep[''] = "Seleccione...";
				  foreach($this->mantenimiento_model->buscarDepartamentos() as $dato){
					  $dep[$dato->ubigeo] = $dato->nombre;
				  }
				  echo form_dropdown('departamento14_1', $dep, set_value('departamento14_1'), 'id="departamento14_1" style="width: 185px;"');
				  ?>
				</td>
				<td>
                  <?php
				  $prov[''] = "Seleccione...";
				  echo form_dropdown('provincia14_1', $prov, set_value('provincia14_1'), 'id="provincia14_1" style="width: 185px;"');
				  ?>
				</td>
				<td>
                  <?php
				  $dist[''] = "Seleccione...";
				  echo form_dropdown('distrito14_1', $dist, set_value('distrito14_1'), 'id="distrito14_1" style="width: 185px;"');
				  ?>
				</td>
			  	<td><input name="localidad14_1" type="text" id="localidad14_1" value="<?php echo set_value('localidad14_1');?>" title="Ingrese la localidad donde estuvo el paciente" onkeyup="javascript:this.value=this.value.toUpperCase();" size="25" /></td>
			  	<td colspan="2"><input name="direccion14_1" type="text" id="direccion14_1" value="<?php echo set_value('direccion14_1');?>" title="Ingrese la direcci&oacute;n donde estuvo el paciente" onkeyup="javascript:this.value=this.value.toUpperCase();" size="55" /></td>
          	</tr>
            <tr>
				<td colspan="2"><strong>Alimentos involucrados</strong></td>
				<td><strong>tipo de producto</strong></td>
				<td><strong>Otro</strong></td>
				<td><strong>Nombre del Producto</strong></td>
				<td><strong>Concentraci&oacute;n</strong></td>
  	      </tr>
           <tr>
			  	<td colspan="2"><input name="alimentos" type="text" id="alimentos" value="<?php echo set_value('alimentos');?>" title="Ingrese los alimentos involucrados" onkeyup="javascript:this.value=this.value.toUpperCase();" size="58" /></td>
				<td><?php echo form_error('producto', '<div class="warning">', '</div>'); ?>
                  <?php
				  $producto = array(''=>'Seleccione...', '1'=>'Plaguicidas', '2'=>'Otro');
				  echo form_dropdown('producto', $producto, set_value('producto'), 'id="producto" style="width: 185px;"');
				  ?>
				</td>
			  	<td><input name="producto_otro" type="text" id="producto_otro" value="<?php echo set_value('producto_otro');?>" title="Ingrese si hay otro producto" onkeyup="javascript:this.value=this.value.toUpperCase();" size="25" /></td>
			  	<td><?php echo form_error('nombre', '<div class="warning">', '</div>'); ?>
                <input name="nombre" type="text" id="nombre" value="<?php echo set_value('nombre');?>" title="Ingrese el nombre del producto" onkeyup="javascript:this.value=this.value.toUpperCase();" size="25" /></td>
			  	<td><input name="concentracion" type="text" id="concentracion" value="<?php echo set_value('concentracion');?>" title="Ingrese la concetración del producto" onkeyup="javascript:this.value=this.value.toUpperCase();" size="25" /></td>
          </tr>
            <tr>
				<td><strong>Presentaci&oacute;n</strong></td>
				<td><strong>Cantidad</strong></td>
				<td><strong>Donde la obtuvo</strong></td>
				<td><strong>Circunstancia</strong></td>
				<td><strong>Otro</strong></td>
  	      </tr>
           <tr>
			  	<td><input name="presentacion" type="text" id="presentacion" value="<?php echo set_value('presentacion');?>" title="Presentaci&oacute;n del producto" onkeyup="javascript:this.value=this.value.toUpperCase();" size="25" /></td>
			  	<td><input name="cantidad" type="text" id="cantidad" value="<?php echo set_value('cantidad');?>" title="Cantidad del producto" onkeyup="javascript:this.value=this.value.toUpperCase();" size="25" /></td>
			  	<td><input name="obtencion" type="text" id="obtencion" value="<?php echo set_value('obtencion');?>" title="De donde obtuvo el producto" onkeyup="javascript:this.value=this.value.toUpperCase();" size="25" /></td>
				<td><?php echo form_error('circunstancia', '<div class="warning">', '</div>'); ?>
                  <?php
				  $circunstancia = array(''=>'Seleccione...', '1'=>'Laboral', '2'=>'Accidental no laboral', '3'=>'Voluntaria (intensional suicida)', '4'=>'Provocada (intento de homicidio)', '5'=>'Otros', '6'=>'Desconocida');
				  echo form_dropdown('circunstancia', $circunstancia, set_value('circunstancia'), 'id="circunstancia" style="width: 185px;"');
				  ?>
				</td>
			  	<td><input name="circunstancia_otro" type="text" id="circunstancia_otro" value="<?php echo set_value('circunstancia_otro');?>" title="Otra circunstancia de la intoxicación" onkeyup="javascript:this.value=this.value.toUpperCase();" size="25" /></td>
          </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><hr/></td>
	  	  </tr>
          <tr>
          	<td colspan="6">Actividad que realizaba al momento de la exposici&oacute;n/intoxicaci&oacute;n (Elija una o si es m&uacute;ltiple)</td>
          </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><hr/></td>
	  	  </tr>
          <tr>
              <td colspan="2">&nbsp;&nbsp;
              <input name="produccion" type="checkbox" id="produccion" <?php if($this->input->post('produccion') == 'on'){ ?> checked = 'checked'<?php } ?> title="Elija si el caso"/>
              <strong>Producci&oacute;n/Formulaci&oacute;n/S&iacute;ntesis</strong>&nbsp;&nbsp;
              </td>
              <td colspan="2">
              <input name="almacenamiento" type="checkbox" id="almacenamiento" <?php if($this->input->post('almacenamiento') == 'on'){ ?> checked = 'checked'<?php } ?> title="Elija si el caso"/>
              <strong>Almacenamiento/Distribuci&oacute;n/Expendio</strong>&nbsp;&nbsp;
              </td>
              <td colspan="2">
              <input name="agricola" type="checkbox" id="agricola" <?php if($this->input->post('agricola') == 'on'){ ?> checked = 'checked'<?php } ?> title="Elija si el caso"/>
              <strong>Uso agr&iacute;cola</strong>&nbsp;&nbsp;
              </td>
          </tr>
          <tr>
              <td colspan="2">&nbsp;&nbsp;
              <input name="salud" type="checkbox" id="salud" <?php if($this->input->post('salud') == 'on'){ ?> checked = 'checked'<?php } ?> title="Elija si el caso"/>
              <strong>Uso en salud p&uacute;blica</strong>&nbsp;&nbsp;
              </td>
              <td colspan="2">
              <input name="mantenimiento" type="checkbox" id="mantenimiento" <?php if($this->input->post('mantenimiento') == 'on'){ ?> checked = 'checked'<?php } ?> title="Elija si el caso"/>
              <strong>Mantenimiento de equipo</strong>&nbsp;&nbsp;
              </td>
              <td colspan="2">
              <input name="humano" type="checkbox" id="humano" <?php if($this->input->post('humano') == 'on'){ ?> checked = 'checked'<?php } ?> title="Elija si el caso"/>
              <strong>Uso  Humano</strong>&nbsp;&nbsp;
              </td>
			</tr>              
          <tr>
              <td colspan="2">&nbsp;&nbsp;
              <input name="domiciliario" type="checkbox" id="domiciliario" <?php if($this->input->post('domiciliario') == 'on'){ ?> checked = 'checked'<?php } ?> title="Elija si el caso"/>
              <strong>Uso domiciliario</strong>&nbsp;&nbsp;
              </td>
              <td colspan="2">
              <input name="veterinario" type="checkbox" id="veterinario" <?php if($this->input->post('veterinario') == 'on'){ ?> checked = 'checked'<?php } ?> title="Elija si el caso"/>
              <strong>Uso veterinario</strong>&nbsp;&nbsp;
              </td>
              <td colspan="2">
              <input name="reentrada" type="checkbox" id="reentrada" <?php if($this->input->post('reentrada') == 'on'){ ?> checked = 'checked'<?php } ?> title="Elija si el caso"/>
              <strong>Reentrada en cultivo</strong>&nbsp;&nbsp;
              </td>
			</tr>              
          <tr>
              <td colspan="2">&nbsp;&nbsp;
              <input name="proteccion" type="checkbox" id="proteccion" <?php if($this->input->post('proteccion') == 'on'){ ?> checked = 'checked'<?php } ?> title="Elija si el caso"/>
              <strong>Manejo de plaguicidas sin protecci&oacute;n</strong>&nbsp;&nbsp;
              </td>
              <td colspan="2">
              <input name="mezcla" type="checkbox" id="mezcla" <?php if($this->input->post('mezcla') == 'on'){ ?> checked = 'checked'<?php } ?> title="Elija si el caso"/>
              <strong>Mezcla-Recarga</strong>&nbsp;&nbsp;
              </td>
              <td colspan="2">
              <input name="transporte" type="checkbox" id="transporte" <?php if($this->input->post('transporte') == 'on'){ ?> checked = 'checked'<?php } ?> title="Elija si el caso"/>
              <strong>Transporte</strong>&nbsp;&nbsp;
              </td>
			</tr>              
          <tr>
              <td colspan="2">&nbsp;&nbsp;
              <input name="otros" type="checkbox" id="otros" <?php if($this->input->post('otros') == 'on'){ ?> checked = 'checked'<?php } ?> title="Elija si el caso"/>
              <strong>Otros (especificar)</strong>&nbsp;&nbsp;
              </td>
              <td colspan="2">
			  	<input name="actividad_otro" type="text" id="actividad_otro" value="<?php echo set_value('actividad_otro');?>" title="Otra actividad" onkeyup="javascript:this.value=this.value.toUpperCase();" size="25" />
              </td>
			</tr>              
          <tr>
              <td colspan="2">&nbsp;&nbsp;Realiza buenas pr&aacute;cticas en el manejo de plaguicidas</td>
              <td>
                  <?php
				  $manejo = array(''=>'Seleccione...', '1'=>'Si', '2'=>'No');
				  echo form_dropdown('manejo', $manejo, set_value('manejo'), 'id="manejo" style="width: 100px;"');
				  ?>
              </td>
              <td>Tiempo de exposici&oacute;n</td>
              <td colspan="2">
			  	<input name="tiempo" type="text" id="tiempo" value="<?php echo set_value('tiempo');?>" title="Tiempo de exposición" size="10" />
				<?php
                $tiempo_tipo = array(''=>'Seleccione...', '1'=>'A&ntilde;os', '2'=>'Meses', '3'=>'D&iacute;as', '4'=>'Horas', '5'=>'Minutos');
                echo form_dropdown('tiempo_tipo', $tiempo_tipo, set_value('tiempo_tipo'), 'id="tiempo_tipo" style="width: 100px;"');
                ?>
              </td>
			</tr>              
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><hr/></td>
	  	  </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><strong>IV. V&iacute;as de exposici&oacute;n</strong></td>
          </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><hr/></td>
	  	  </tr>
          <tr>
              <td><?php echo form_error('eoral', '<div class="warning">', '</div>'); ?>
              <input name="eoral" type="checkbox" id="eoral" <?php if($this->input->post('eoral') == 'on'){ ?> checked = 'checked'<?php } ?> title="Elija si el caso"/>
              <strong>Oral</strong>&nbsp;&nbsp;
              </td>
              <td>
              <input name="piel" type="checkbox" id="piel" <?php if($this->input->post('piel') == 'on'){ ?> checked = 'checked'<?php } ?> title="Elija si el caso"/>
              <strong>Piel</strong>&nbsp;&nbsp;
              </td>
              <td>
              <input name="mucosas" type="checkbox" id="mucosas" <?php if($this->input->post('mucosas') == 'on'){ ?> checked = 'checked'<?php } ?> title="Elija si el caso"/>
              <strong>Mucosas - Ocular - Otras</strong>&nbsp;&nbsp;
              </td>
              <td>
              <input name="respiratoria" type="checkbox" id="respiratoria" <?php if($this->input->post('respiratoria') == 'on'){ ?> checked = 'checked'<?php } ?> title="Elija si el caso"/>
              <strong>Respiratoria</strong>&nbsp;&nbsp;
              </td>
              <td>
              <input name="desconocida" type="checkbox" id="desconocida" <?php if($this->input->post('desconocida') == 'on'){ ?> checked = 'checked'<?php } ?> title="Elija si el caso"/>
              <strong>Desconocida</strong>&nbsp;&nbsp;
              </td>
          </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><hr/></td>
	  	  </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><strong>V. Cuadro Cl&iacute;nico</strong></td>
          </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><hr/></td>
	  	  </tr>
            <tr>
				<td><strong>Fecha de Consulta</strong></td>
				<td><strong>Inicio de S&iacute;ntomas</strong></td>
				<td><strong>Semana</strong></td>
				<td><strong>Sist&eacute;mico</strong></td>
  	      </tr>
          <tr>
              <td><?php echo form_error('fecha_con', '<div class="warning">', '</div>'); ?>
              <input name="fecha_con" type="text" id="fecha_con" value="<?php echo set_value('fecha_con')?>"  title="Ingrese la fecha de consulta del paciente" placeholder="Ej. dd-mm-YYYY" size="20" /></td>
              <td><?php echo form_error('fecha_sin', '<div class="warning">', '</div>'); ?>
              <input name="fecha_sin" type="text" id="fecha_sin" value="<?php echo $this->fechas_model->modificarFechas($datos->fecha_ini);?>"  title="Ingrese la fecha de inicio de s&iacute;ntomas del paciente" placeholder="Ej. dd-mm-YYYY" size="20" readonly="readonly" /></td>
              <td><?php echo form_error('semana', '<div class="warning">', '</div>'); ?>
              <input name="semana" type="text" id="semana" value="<?php echo $datos->semana;?>"  title="Ingrese la semana de inicio de s&iacute;ntomas del paciente" placeholder="Ej. dd-mm-YYYY" size="5" readonly="readonly" /></td>
              <td>
				<?php
                $sistemico = array(''=>'Seleccione...', '1'=>'Si', '2'=>'No');
                echo form_dropdown('sistemico', $sistemico, set_value('sistemico'), 'id="sistemico" style="width: 100px;"');
                ?>
              </td>
          </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><hr/></td>
	  	  </tr>
          <tr>
              <td>&nbsp;&nbsp;
			  <?php echo form_error('nauseas', '<div class="warning">', '</div>'); ?>
              <input name="nauseas" type="checkbox" id="nauseas" <?php if($this->input->post('nauseas') == 'on'){ ?> checked = 'checked'<?php } ?> title="Elija si el caso"/>
              <strong>Na&uacute;seas</strong>&nbsp;&nbsp;
              </td>
              <td>
              <input name="vomitos" type="checkbox" id="vomitos" <?php if($this->input->post('vomitos') == 'on'){ ?> checked = 'checked'<?php } ?> title="Elija si el caso"/>
              <strong>V&oacute;mitos</strong>&nbsp;&nbsp;
              </td>
              <td>
              <input name="abdominal" type="checkbox" id="abdominal" <?php if($this->input->post('abdominal') == 'on'){ ?> checked = 'checked'<?php } ?> title="Elija si el caso"/>
              <strong>Dolor Amdominal</strong>&nbsp;&nbsp;
              </td>
              <td>&nbsp;&nbsp;
              <input name="incontinencia" type="checkbox" id="incontinencia" <?php if($this->input->post('incontinencia') == 'on'){ ?> checked = 'checked'<?php } ?> title="Elija si el caso"/>
              <strong>Incontinencia de esf&iacute;nteres</strong>&nbsp;&nbsp;
              </td>
              <td>
              <input name="cefalea" type="checkbox" id="cefalea" <?php if($this->input->post('cefalea') == 'on'){ ?> checked = 'checked'<?php } ?> title="Elija si el caso"/>
              <strong>Cefal&eacute;a</strong>&nbsp;&nbsp;
              </td>
              <td>
              <input name="diarreas" type="checkbox" id="diarreas" <?php if($this->input->post('diarreas') == 'on'){ ?> checked = 'checked'<?php } ?> title="Elija si el caso"/>
              <strong>Diarreas</strong>&nbsp;&nbsp;
              </td>
          </tr>
          <tr>
              <td>&nbsp;&nbsp;
              <input name="miosis" type="checkbox" id="miosis" <?php if($this->input->post('miosis') == 'on'){ ?> checked = 'checked'<?php } ?> title="Elija si el caso"/>
              <strong>Miosis</strong>&nbsp;&nbsp;
              </td>
              <td>
              <input name="sudoracion" type="checkbox" id="sudoracion" <?php if($this->input->post('sudoracion') == 'on'){ ?> checked = 'checked'<?php } ?> title="Elija si el caso"/>
              <strong>Sudoraci&oacute;n</strong>&nbsp;&nbsp;
              </td>
              <td>
              <input name="temblor" type="checkbox" id="temblor" <?php if($this->input->post('temblor') == 'on'){ ?> checked = 'checked'<?php } ?> title="Elija si el caso"/>
              <strong>Temblor de manos y otras partes</strong>&nbsp;&nbsp;
              </td>
              <td>&nbsp;&nbsp;
              <input name="cianosis" type="checkbox" id="cianosis" <?php if($this->input->post('cianosis') == 'on'){ ?> checked = 'checked'<?php } ?> title="Elija si el caso"/>
              <strong>Cianosis</strong>&nbsp;&nbsp;
              </td>
              <td>
              <input name="midriasis" type="checkbox" id="midriasis" <?php if($this->input->post('midriasis') == 'on'){ ?> checked = 'checked'<?php } ?> title="Elija si el caso"/>
              <strong>Midriasis</strong>&nbsp;&nbsp;
              </td>
              <td>
              <input name="mareos" type="checkbox" id="mareos" <?php if($this->input->post('mareos') == 'on'){ ?> checked = 'checked'<?php } ?> title="Elija si el caso"/>
              <strong>Mareos</strong>&nbsp;&nbsp;
              </td>
          </tr>
          <tr>
              <td>&nbsp;&nbsp;
              <input name="bradicardia" type="checkbox" id="bradicardia" <?php if($this->input->post('bradicardia') == 'on'){ ?> checked = 'checked'<?php } ?> title="Elija si el caso"/>
              <strong>Bradicardia</strong>&nbsp;&nbsp;
              </td>
              <td>
              <input name="conciencia" type="checkbox" id="conciencia" <?php if($this->input->post('conciencia') == 'on'){ ?> checked = 'checked'<?php } ?> title="Elija si el caso"/>
              <strong>Transtorno de la conciencia</strong>&nbsp;&nbsp;
              </td>
              <td>
              <input name="disnea" type="checkbox" id="disnea" <?php if($this->input->post('disnea') == 'on'){ ?> checked = 'checked'<?php } ?> title="Elija si el caso"/>
              <strong>Disnea</strong>&nbsp;&nbsp;
              </td>
              <td>&nbsp;&nbsp;
              <input name="convulsiones" type="checkbox" id="convulsiones" <?php if($this->input->post('convulsiones') == 'on'){ ?> checked = 'checked'<?php } ?> title="Elija si el caso"/>
              <strong>Convulsiones</strong>&nbsp;&nbsp;
              </td>
              <td>
              <input name="polipnea" type="checkbox" id="polipnea" <?php if($this->input->post('polipnea') == 'on'){ ?> checked = 'checked'<?php } ?> title="Elija si el caso"/>
              <strong>Polipnea</strong>&nbsp;&nbsp;
              </td>
              <td>
              <input name="rash" type="checkbox" id="rash" <?php if($this->input->post('rash') == 'on'){ ?> checked = 'checked'<?php } ?> title="Elija si el caso"/>
              <strong>Rash D&eacute;rmico</strong>&nbsp;&nbsp;
              </td>
          </tr>
          <tr>
              <td>&nbsp;&nbsp;
              <input name="sibilancias" type="checkbox" id="sibilancia" <?php if($this->input->post('sibilancia') == 'on'){ ?> checked = 'checked'<?php } ?> title="Elija si el caso"/>
              <strong>Sibilancias</strong>&nbsp;&nbsp;
              </td>
              <td>
              <input name="inferiores" type="checkbox" id="inferiores" <?php if($this->input->post('inferiores') == 'on'){ ?> checked = 'checked'<?php } ?> title="Elija si el caso"/>
              <strong>Debilidad musc. miembros inf.</strong>&nbsp;&nbsp;
              </td>
              <td>
              <input name="proximales" type="checkbox" id="proximales" <?php if($this->input->post('proximales') == 'on'){ ?> checked = 'checked'<?php } ?> title="Elija si el caso"/>
              <strong>Debilidad en m&uacute;sculos proximales</strong>&nbsp;&nbsp;
              </td>
              <td>&nbsp;&nbsp;
              <input name="insuficiencia" type="checkbox" id="insuficiencia" <?php if($this->input->post('insuficiencia') == 'on'){ ?> checked = 'checked'<?php } ?> title="Elija si el caso"/>
              <strong>Insuficiencia respiratoria</strong>&nbsp;&nbsp;
              </td>
              <td>
              <input name="otro_sintoma" type="checkbox" id="otro_sintoma" <?php if($this->input->post('otro_sintoma') == 'on'){ ?> checked = 'checked'<?php } ?> title="Elija si el caso"/>
              <strong>Otros</strong>&nbsp;&nbsp;
              </td>
              <td>
              <input name="sin_sintomas" type="checkbox" id="sin_sintomas" <?php if($this->input->post('sin_sintomas') == 'on'){ ?> checked = 'checked'<?php } ?> title="Elija si el caso"/>
              <strong>No present&oacute; s&iacute;ntomas</strong>&nbsp;&nbsp;
              </td>
          </tr>
          <tr>
              <td>&nbsp;&nbsp;
              </td>
              <td>
              </td>
              <td>
              </td>
              <td>&nbsp;&nbsp;
              </td>
              <td><?php echo form_error('sintoma_otro', '<div class="warning">', '</div>'); ?>
              <input name="sintoma_otro" type="text" id="sintoma_otro" value="<?php echo set_value('sintoma_otro')?>"  title="Ingrese otros s&iacute;ntomas del paciente" onkeyup="javascript:this.value=this.value.toUpperCase();" size="25" /></td>
          </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><hr/></td>
	  	  </tr>
            <tr>
				<td><strong>Tipo de intoxicaci&oacute;n</strong></td>
  	      </tr>
          <tr>
              <td>
				<?php
                $tipo = array(''=>'Seleccione...', '1'=>'Leve', '2'=>'Moderada', '3'=>'Grave');
                echo form_dropdown('tipo', $tipo, set_value('tipo'), 'id="tipo" style="width: 150px;"');
                ?>
              </td>
          </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><hr/></td>
	  	  </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><strong>VI. Antecedentes</strong></td>
          </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><hr/></td>
	  	  </tr>
            <tr>
				<td><strong>Intoxicaci&oacute;n anteriores</strong></td>
				<td><strong>No. Veces</strong></td>
				<td><strong>Fecha</strong></td>
				<td><strong>Lugar</strong></td>
				<td><strong>Otros</strong></td>
  	      </tr>
          <tr>
              <td>
				<?php
                $anteriores = array(''=>'Seleccione...', '1'=>'Si', '2'=>'No');
                echo form_dropdown('anteriores', $anteriores, set_value('anteriores'), 'id="anteriores" style="width: 100px;"');
                ?>
              </td>
              <td><?php echo form_error('veces', '<div class="warning">', '</div>'); ?>
              <input name="veces" type="text" id="veces" value="<?php echo set_value('veces')?>"  title="Ingrese el n&uacute;mero de veces anteriores" size="15" /></td>
              <td><?php echo form_error('fecha_ant', '<div class="warning">', '</div>'); ?>
              <input name="fecha_ant" type="text" id="fecha_ant" value="<?php echo set_value('fecha_ant')?>"  title="Ingrese la fecha de la anteriores intoxicaci&oacute;n" placeholder="Ej. dd-mm-YYYY" size="20" /></td>
              <td>
				<?php
                $lugar_ant = array(''=>'Seleccione...', '1'=>'Casa', '2'=>'Escuela', '3'=>'Trabajo', '4'=>'Otros');
                echo form_dropdown('lugar_ant', $lugar_ant, set_value('lugar_ant'), 'id="lugar_ant" style="width: 180px;"');
                ?>
              </td>
              <td><?php echo form_error('anterior_otro', '<div class="warning">', '</div>'); ?>
              <input name="anterior_otro" type="text" id="anterior_otro" value="<?php echo set_value('anterior_otro')?>"  title="Ingrese otro lugar" onkeyup="javascript:this.value=this.value.toUpperCase();" size="25" /></td>
          </tr>
            <tr>
				<td colspan="2"><strong>Observaciones</strong></td>
				<td><strong>Causas</strong></td>
				<td><strong>Otros</strong></td>
  	      </tr>
          <tr>
              <td colspan="2"><?php echo form_error('observaciones', '<div class="warning">', '</div>'); ?>
              <input name="observaciones" type="text" id="observaciones" value="<?php echo set_value('observaciones')?>"  title="Ingrese alguna observaci&oacute;n" onkeyup="javascript:this.value=this.value.toUpperCase();" size="55" /></td>
              <td>
				<?php
                $causa_ant = array(''=>'Seleccione...', '1'=>'Laboral', '2'=>'Accidental No Laboral', '3'=>'Voluntario (intencional)', '4'=>'Provocado (homicidio)', '5'=>'Otro');
                echo form_dropdown('causa_ant', $causa_ant, set_value('causa_ant'), 'id="causa_ant" style="width: 185px;"');
                ?>
              </td>
              <td><?php echo form_error('causa_otro', '<div class="warning">', '</div>'); ?>
              <input name="causa_otro" type="text" id="causa_otro" value="<?php echo set_value('causa_otro')?>"  title="Ingrese otro causa" onkeyup="javascript:this.value=this.value.toUpperCase();" size="25" /></td>
          </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><hr/></td>
	  	  </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><strong>VII. Ex&aacute;menes toxicol&oacute;gicos</strong></td>
          </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><hr/></td>
	  	  </tr>
            <tr>
				<td colspan="2"><strong>Nombre del laboratorio</strong></td>
				<td><strong>Toma de muestra</strong></td>
				<td><strong>Tipo de muestra</strong></td>
				<td><strong>Otros</strong></td>
  	      </tr>
          <tr>
              <td colspan="2"><?php echo form_error('laboratorio', '<div class="warning">', '</div>'); ?>
              <input name="laboratorio" type="text" id="laboratorio" value="<?php echo set_value('laboratorio')?>"  title="Ingrese el nombre del laboratorio" onkeyup="javascript:this.value=this.value.toUpperCase();" size="55" /></td>
              <td>
				<?php
                $muestra = array(''=>'Seleccione...', '1'=>'Si', '2'=>'No');
                echo form_dropdown('muestra', $muestra, set_value('muestra'), 'id="muestra" style="width: 100px;"');
                ?>
              </td>
              <td>
              <input name="tipo_mue" type="checkbox" id="tipo_mue" <?php if($this->input->post('tipo_mue') == 'on'){ ?> checked = 'checked'<?php } ?> title="Elija si el caso"/>
              <strong>Sangre</strong>&nbsp;&nbsp;
              </td>
              <td><?php echo form_error('tipomue_otro', '<div class="warning">', '</div>'); ?>
              <input name="tipomue_otro" type="text" id="tipomue_otro" value="<?php echo set_value('tipomue_otro')?>" onkeyup="javascript:this.value=this.value.toUpperCase();" title="Ingrese otro tipo de muestra" size="25" /></td>
		  </tr>              
            <tr>
				<td><strong>Toma de muestra</strong></td>
				<td><strong>Env&iacute;o a laboratorio</strong></td>
				<td><strong>Recepci&oacute;n de laboratorio</strong></td>
  	      </tr>
          <tr>
              <td><?php echo form_error('fecha_mue', '<div class="warning">', '</div>'); ?>
              <input name="fecha_mue" type="text" id="fecha_mue" value="<?php echo set_value('fecha_mue')?>"  title="Ingrese la fecha de la toma de muestra" placeholder="Ej. dd-mm-YYYY" size="20" /></td>
              <td><?php echo form_error('fecha_env', '<div class="warning">', '</div>'); ?>
              <input name="fecha_env" type="text" id="fecha_env" value="<?php echo set_value('fecha_env')?>"  title="Ingrese la fecha del env&iacute;o al laboratorio" placeholder="Ej. dd-mm-YYYY" size="20" /></td>
              <td><?php echo form_error('fecha_rec', '<div class="warning">', '</div>'); ?>
              <input name="fecha_rec" type="text" id="fecha_rec" value="<?php echo set_value('fecha_rec')?>"  title="Ingrese la fecha de la recepción por el laboratorio" placeholder="Ej. dd-mm-YYYY" size="20" /></td>
          </tr>
            <tr>
				<td><strong>Test de colinesterasa</strong></td>
				<td><strong>Resultado</strong></td>
				<td><strong>U/Lt M&eacute;todo</strong></td>
  	      </tr>
          <tr>
              <td>
				<?php
                $colinesterasa = array(''=>'Seleccione...', '1'=>'Si', '2'=>'No');
                echo form_dropdown('colinesterasa', $colinesterasa, set_value('colinesterasa'), 'id="colinesterasa" style="width: 100px;"');
                ?>
              </td>
              <td><?php echo form_error('colinesterasa_res', '<div class="warning">', '</div>'); ?>
              <input name="colinesterasa_res" type="text" id="colinesterasa_res" value="<?php echo set_value('colinesterasa_res')?>"  title="Ingrese el resultado" size="25" />&nbsp;<strong>%</strong></td>
              <td><?php echo form_error('metodo', '<div class="warning">', '</div>'); ?>
              <input name="metodo" type="text" id="metodo" value="<?php echo set_value('metodo')?>"  title="Ingrese el m&eacute;todo usado" onkeyup="javascript:this.value=this.value.toUpperCase();" size="25" /></td>
          </tr>
            <tr>
				<td><strong>Otros ex&aacute;menes</strong></td>
				<td><strong>Indique cual</strong></td>
				<td><strong>Servicio</strong></td>
				<td><strong>Ultimo examen ocupacional</strong></td>
  	      </tr>
          <tr>
              <td>
				<?php
                $examen_otro = array(''=>'Seleccione...', '1'=>'Si', '2'=>'No');
                echo form_dropdown('examen_otro', $examen_otro, set_value('examen_otro'), 'id="examen_otro" style="width: 100px;"');
                ?>
              </td>
              <td><?php echo form_error('examen_cual', '<div class="warning">', '</div>'); ?>
              <input name="examen_cual" type="text" id="examen_cual" value="<?php echo set_value('examen_cual')?>"  title="Ingrese el nombre del otro examen" onkeyup="javascript:this.value=this.value.toUpperCase();" size="25" /></td>
              <td><?php echo form_error('servicio', '<div class="warning">', '</div>'); ?>
              <input name="servicio" type="text" id="servicio" value="<?php echo set_value('servicio')?>"  title="Ingrese el servicio" onkeyup="javascript:this.value=this.value.toUpperCase();" size="25" /></td>
              <td><?php echo form_error('fecha_ocu', '<div class="warning">', '</div>'); ?>
              <input name="fecha_ocu" type="text" id="fecha_ocu" value="<?php echo set_value('fecha_ocu')?>"  title="Ingrese la fecha del &uacute;ltimo examen ocupacional realizado" placeholder="Ej. dd-mm-YYYY" size="20" /></td>
          </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><hr/></td>
	  	  </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><strong>VIII. Destino del intoxicado</strong></td>
          </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><hr/></td>
	  	  </tr>
            <tr>
				<td><strong>Destinatario</strong></td>
				<td><strong>Hospitalizado</strong></td>
				<td><strong>Servicio</strong></td>
  	      </tr>
          <tr>
              <td>
				<?php
                $destino = array(''=>'Seleccione...', '1'=>'Ambulatorio', '2'=>'Emergencia', '3'=>'Hospitalizado', '4'=>'Su casa', '5'=>'Trabajo', '6'=>'M&eacute;dico legal (fallecido)');
                echo form_dropdown('destino', $destino, set_value('destino'), 'id="destino" style="width: 180px;"');
                ?>
              </td>
              <td><?php echo form_error('fecha_hos', '<div class="warning">', '</div>'); ?>
              <input name="fecha_hos" type="text" id="fecha_hos" value="<?php echo $this->fechas_model->modificarFechas($datos->fecha_hos);?>"  title="Ingrese la fecha de hospitalizaci&oacute;n" placeholder="Ej. dd-mm-YYYY" size="20" /></td>
              <td><?php echo form_error('destino_serv', '<div class="warning">', '</div>'); ?>
              <input name="destino_serv" type="text" id="destino_serv" value="<?php echo set_value('destino_serv')?>"  title="Ingrese el servicio" onkeyup="javascript:this.value=this.value.toUpperCase();" size="25" /></td>
          </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><hr/></td>
	  	  </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><strong>IX. Tratamiento recibido</strong></td>
          </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><hr/></td>
	  	  </tr>
            <tr>
				<td><strong>Oral</strong></td>
				<td><strong>Dosis</strong></td>
				<td><strong>Parenteral</strong></td>
				<td><strong>Dosis</strong></td>
				<td><strong>Ant&iacute;doto</strong></td>
  	      </tr>
          <tr>
              <td><?php echo form_error('oral', '<div class="warning">', '</div>'); ?>
              <input name="oral" type="text" id="oral" value="<?php echo set_value('oral')?>"  title="Ingrese el tratamiento oral" onkeyup="javascript:this.value=this.value.toUpperCase();" size="25" /></td>
              <td><?php echo form_error('oral_dosis', '<div class="warning">', '</div>'); ?>
              <input name="oral_dosis" type="text" id="oral_dosis" value="<?php echo set_value('oral_dosis')?>"  title="Ingrese la dosis tratamiento oral" onkeyup="javascript:this.value=this.value.toUpperCase();" size="25" /></td>
              <td><?php echo form_error('parenteral', '<div class="warning">', '</div>'); ?>
              <input name="parenteral" type="text" id="parenteral" value="<?php echo set_value('parenteral')?>"  title="Ingrese el tratamiento parenteral" onkeyup="javascript:this.value=this.value.toUpperCase();" size="25" /></td>
              <td><?php echo form_error('parenteral_dosis', '<div class="warning">', '</div>'); ?>
              <input name="parenteral_dosis" type="text" id="parenteral_dosis" value="<?php echo set_value('parenteral_dosis')?>"  title="Ingrese la dosis tratamiento parenteral" onkeyup="javascript:this.value=this.value.toUpperCase();" size="25" /></td>
              <td><?php echo form_error('antidoto', '<div class="warning">', '</div>'); ?>
              <input name="antidoto" type="text" id="antidoto" value="<?php echo set_value('antidoto')?>"  title="Ingrese el nombre del ant&iacute;doto" onkeyup="javascript:this.value=this.value.toUpperCase();" size="25" /></td>
          </tr>
            <tr>
				<td colspan="2"><strong>Evaluaci&oacute;n de secuelas</strong></td>
  	      </tr>
          <tr>
              <td colspan="2"><?php echo form_error('secuelas', '<div class="warning">', '</div>'); ?>
              <input name="secuelas" type="text" id="secuelas" value="<?php echo set_value('secuelas')?>"  title="Ingrese la evaluacion de secuelas" onkeyup="javascript:this.value=this.value.toUpperCase();" size="57" /></td>
          </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><hr/></td>
	  	  </tr>
			  <td colspan="6" bgcolor="#CCCCCC"><strong>X. Evoluci&oacute;n del intoxicado</strong></td>
          </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><hr/></td>
	  	  </tr>
            <tr>
				<td><strong>Evoluci&oacute;n</strong></td>
				<td><strong>Fecha alta</strong></td>
				<td><strong>Fecha defunci&oacute;n</strong></td>
				<td colspan="3"><strong>Causa b&aacute;sica</strong></td>
  	      </tr>
			<tr>
              <td>
				<?php
                $evolucion = array(''=>'Seleccione...', '1'=>'Recuperado', '2'=>'Transferido', '3'=>'Alta', '4'=>'Fallecido');
                echo form_dropdown('evolucion', $evolucion, set_value('evolucion'), 'id="evolucion" style="width: 180px;"');
                ?>
              </td>
              <td><?php echo form_error('fecha_alt', '<div class="warning">', '</div>'); ?>
              <input name="fecha_alt" type="text" id="fecha_alt" value="<?php echo set_value('fecha_alt')?>"  title="Ingrese la fecha de alta" placeholder="Ej. dd-mm-YYYY" size="20" /></td>
              <td><?php echo form_error('fecha_def', '<div class="warning">', '</div>'); ?>
              <input name="fecha_def" type="text" id="fecha_def" value="<?php echo $this->fechas_model->modificarFechas($datos->fecha_def);?>" title="Ingrese la fecha de defunci&oacute;n" placeholder="Ej. dd-mm-YYYY" size="20" readonly="readonly" /></td>
              <td colspan="3"><?php echo form_error('mostrar', '<div class="warning">', '</div>'); ?>
				<?php
				$ciex = array(''=>'Seleccione...');
                $mostrar = $this->frontend_model->mostrarCiex();
				
				foreach($mostrar as $dato){
					$ciex[$dato->ciex] = $dato->descripcion;
				}
				
                echo form_dropdown('mostrar', $ciex, set_value('mostrar'), 'id="mostrar" style="width: 550px;"');
                ?>
              </td>
              </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><hr/></td>
	  	  </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><strong>XI. Diagn&oacute;stico final</strong></td>
          </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><hr/></td>
	  	  </tr>
            <tr>
              <td>
				<?php
                $diagnostico = array(''=>'Seleccione...', '1'=>'Confirmaci&oacute;n cl&iacute;nico-epidemiol&oacute;gica', '2'=>'Confirmaci&oacute;n por laboratorio', '3'=>'Descartado');
                echo form_dropdown('diagnostico', $diagnostico, set_value('diagnostico'), 'id="diagnostico" style="width: 180px;"');
                ?>
              </td>
			  <td><strong>Otro</strong></td>
              <td><?php echo form_error('diagnostico_otro', '<div class="warning">', '</div>'); ?>
              <input name="diagnostico_otro" type="text" id="diagnostico_otro" value="<?php echo set_value('diagnostico_otro')?>"  title="Ingrese la evaluacion de secuelas" onkeyup="javascript:this.value=this.value.toUpperCase();" size="25" /></td>
  	      </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><hr/></td>
	  	  </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><strong>XII. Fecha del periodo de la investigaci&oacute;n y nombre del investigador</strong></td>
          </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><hr/></td>
	  	  </tr>
            <tr>
				<td><strong>Inicio</strong></td>
				<td><strong>Final</strong></td>
				<td><strong>Investigador</strong></td>
				<td><strong>Profesion</strong></td>
				<td><strong>Tel&eacute;fono</strong></td>
				<td><strong>Celular</strong></td>
  	      </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><hr/></td>
	  	  </tr>
              <td><?php echo form_error('fecha_inv1', '<div class="warning">', '</div>'); ?>
              <input name="fecha_inv1" type="text" id="fecha_inv1" value="<?php echo set_value('fecha_inv1')?>"  title="Ingrese de inicio de la investigaci&oacute;n" placeholder="Ej. dd-mm-YYYY" size="20" /></td>
              <td><?php echo form_error('fecha_inv2', '<div class="warning">', '</div>'); ?>
              <input name="fecha_inv2" type="text" id="fecha_inv2" value="<?php echo set_value('fecha_inv2')?>"  title="Ingrese final de la investigaci&oacute;n" placeholder="Ej. dd-mm-YYYY" size="20" /></td>
              <td><?php echo form_error('investigador', '<div class="warning">', '</div>'); ?>
              <input name="investigador" type="text" id="investigador" value="<?php echo set_value('investigador')?>"  title="Ingrese el nombre del investigador" onkeyup="javascript:this.value=this.value.toUpperCase();" size="25" /></td>
              <td><?php echo form_error('profesion', '<div class="warning">', '</div>'); ?>
              <input name="profesion" type="text" id="profesion" value="<?php echo set_value('profesion')?>"  title="Ingrese la profesi&oacute;n del investigador" onkeyup="javascript:this.value=this.value.toUpperCase();" size="25" /></td>
              <td><?php echo form_error('telefono', '<div class="warning">', '</div>'); ?>
              <input name="telefono" type="text" id="telefono" value="<?php echo set_value('telefono')?>"  title="Ingrese el telefono o celular del investigador" onkeypress="return acceptNum(event)" size="20" /></td>
              <td><?php echo form_error('celular', '<div class="warning">', '</div>'); ?>
              <input name="celular" type="text" id="celular" value="<?php echo set_value('celular')?>"  title="Ingrese el telefono o celular del investigador" onkeypress="return acceptNum(event)" size="20" /></td>
          </tr>
   		  <tr>
			  <td colspan="6" bgcolor="#CCCCCC"><hr/></td>
	  	  </tr>
          <tr>
			  <td colspan="8">
              <hr />
			  </td>
          </tr>
            <tr>
			  <td colspan="8" align="right">
				<input type="button" id="botonListado" name="volver" value="&nbsp;&nbsp;&nbsp;Listado" onclick="window.location='<?php echo site_url('modulos4/listarCasos'); ?>'" />
				<input type="submit" id="botonGrabar" name="enviar" value="&nbsp;&nbsp;&nbsp;Grabar" />
                <input type="hidden" name="diresa" value="<?php echo $dir;?>"/>
                <input type="hidden" name="redes" value="<?php echo $rd;?>"/>
                <input type="hidden" name="microred" value="<?php echo $mrd;?>"/>
                <input type="hidden" name="establecimiento" value="<?php echo $estab;?>"/>
                <input type="hidden" name="notificado" value="<?php echo $id;?>"/>
			  </td>
		  </tr>
		</table>  
	</div>
    <br/>  
<!--</div>-->
<?php
    echo form_close();
?>