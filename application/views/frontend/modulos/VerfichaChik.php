<?php
    $atributos = array('id'=>'form1', 'name'=>'form1');
    echo form_open(null, $atributos);
?>
<br/>  
<p><input type="button" id="imprime" value="&nbsp;Imprimir&nbsp;"></p>
<br/>  
<!--<div class="formulario1">-->
<div><img src="<?php echo base_url().'public/images/logo.png';?>" width="300" height="40" alt="logo" /></div>
    <center><h2>Ficha de investigaci&oacute;n cl&iacute;nico epidemiol&oacute;gica</h2></center>
    <center><h2>de Chikungunya (CIE 10: A92.0)</h2></center>
	<div style="border: solid 1px #000; width: 100%;">
		<table width="100%" align="center">
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><strong>I. Datos Generales:</strong></td>
		  	</tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><hr/></td>
	  	  </tr>
			<tr>
				<td><strong>Semana</strong></td>
			  	<td><strong>Notificaci&oacute;n</strong></td>
			  	<td><strong>Investigaci&oacute;n</strong></td>
          </tr>
             <tr>
				<td><input name="semana" type="text" id="semana" placeholder="Ej. 99" title="Ingrese la semana epidemiol&oacute;gica" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $modificar->semana;?>" size="4" readonly="readonly" />
				</td>
			  	<td><input name="fecha_not" type="text" disabled="disabled" id="fecha_not" placeholder="Ej. dd-mm-YYYY" title="Ingrese la fecha de notificaci&oacute;n" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $this->fechas_model->modificarFechas($modificar->fecha_not);?>" size="20" readonly="readonly" /></td>
			  	<td><input name="fecha_inv" type="text" disabled="disabled" id="fecha_inv" placeholder="Ej. dd-mm-YYYY" title="Ingrese la fecha de investigaci&oacute;n" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $this->fechas_model->modificarFechas($modificar->fecha_inv);?>" size="20" readonly="readonly" /></td>
	  	  </tr>
			<tr>  
				<td><strong>Diresa</strong></td>
				<td><strong>Redes</strong></td>
				<td><strong>Microred</strong></td>
				<td><strong>Establecimiento</strong></td>
				<td><strong>Instituci&oacute;n de salud</strong></td>
          </tr>
            <tr>
				<td>
                  <?php
				  $subr[''] = "Seleccione...";
				  
				  if( $modificar->diresa == ""){
					  echo form_dropdown('diresa', $subr, null, 'id="diresa" style="width: 200px;"');
				  }else{
					  echo form_dropdown('diresa', $subr, $modificar->diresa, 'id="diresa" disabled="disabled" style="width: 200px;"');
				  }
				  ?>
				</td>
				<td>
                  <?php
				  $red[''] = "Seleccione...";
				  
				  if($modificar->red == ""){
					  echo form_dropdown('redes', $red, null, 'id="redes" style="width: 200px;"');
				  }else{
					  echo form_dropdown('redes', $red, $modificar->red, 'id="redes" disabled="disabled" style="width: 200px;"');
				  }
				  ?>
				</td>
				<td>
                  <?php
				  $mred[''] = "Seleccione...";

				  if($modificar->microred == ""){
					  echo form_dropdown('microred', $mred, null, 'id="microred" style="width: 200px;"');
				  }else{
					  echo form_dropdown('microred', $mred, $modificar->microred, 'id="microred" disabled="disabled" style="width: 200px;"');
				  }
				  ?>
				</td>
				<td>
                  <?php
				  $est[''] = "Seleccione...";

				  if($modificar->establecimiento == ""){
					  echo form_dropdown('establec', $est, null, 'id="establec" style="width: 200px;"');
				  }else{
					  echo form_dropdown('establec', $est, $modificar->establecimiento, 'id="establec" disabled="disabled" style="width: 200px;"');
				  }
				  ?>
				</td>
			  	<td>
          	  		<input name="institucion" type="text" id="institucion" title="Ingrese la instituci&oacute;n del establecimiento" value="<?php echo $institucion;?>" onkeyup="javascript:this.value=this.value.toUpperCase();" size="15" readonly="readonly" /></td>
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
				<td><strong>Historia</strong></td>
				<td><strong>Tel&eacute;fono</strong></td>
				<td><strong>Apellido Paterno</strong></td>
				<td><strong>Apellido Materno</strong></td>
				<td><strong>Nombres</strong></td>
				<td><strong>DNI</strong></td>
  	      </tr>
            <tr>
			  	<td><input name="historia" type="text" id="historia" title="Ingrese la historia del paciente" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $modificar->historia;?>" size="30" readonly="readonly" /></td>
			  	<td><input name="telefono" type="text" id="telefono" title="Ingrese el tel&eacute;fono del paciente o familiar" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $modificar->telefono;?>" size="30" readonly="readonly" /></td>
			  	<td><input name="paterno" type="text" id="paterno" title="Ingrese el apellido paterno del paciente" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $modificar->paterno;?>" size="30" readonly="readonly" /></td>
			  	<td><input name="materno" type="text" id="materno" title="Ingrese el apellido materno del paciente" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $modificar->materno;?>" size="30" readonly="readonly" /></td>
			  	<td><input name="nombres" type="text" id="nombres" title="Ingrese los nombres del paciente" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $modificar->nombres;?>" size="20" readonly="readonly" /></td>
			  	<td><input name="dni" type="text" id="dni" title="Ingrese el DNI del paciente" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $modificar->dni;?>" size="20" readonly="readonly" /></td>
          </tr>
            <tr>
				<td><strong>Fecha de Nacimiento</strong></td>
				<td><strong>Edad</strong></td>
				<td><strong>Tipo de Edad</strong></td>
				<td><strong>Sexo</strong></td>
  	      </tr>
             <tr>
			  	<td><input name="fecha_nac" type="text" disabled="disabled" id="fecha_nac" placeholder="Ej. dd-mm-YYYY" title="Ingrese la fecha de nacimiento del paciente" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $this->fechas_model->modificarFechas($modificar->fecha_nac);?>" size="20" readonly="readonly" /></td>
			  	<td><input name="edad" type="text" id="edad" title="Ingrese la edad del paciente" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $modificar->edad;?>" size="30" readonly="readonly" /></td>
				<td>
                  <?php
				  $tedad[''] = "Seleccione...";
				  echo form_dropdown('tipo_edad', $tedad, $modificar->tipo_edad, 'disabled="disabled" id="tipo_edad" title="Seleccione el tipo de la edad del paciente" style="width: 200px;"');
				  ?>
				</td>
				<td>
                  <?php
				  $sex[''] = "Seleccione...";
				  echo form_dropdown('sexo', $sex, $modificar->sexo, 'disabled="disabled" id="sexo" title="Seleccione el sexo del paciente" style="width: 200px;"');
				  ?>
				</td>
	  	  </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><strong>Residencia habitual</strong></td>
	  	  </tr>
            <tr>
				<td><strong>Pa&iacute;s</strong></td>
				<td><strong>Departamento</strong></td>
				<td><strong>Provincia</strong></td>
				<td><strong>Distrito</strong></td>
				<td><strong>Localidad</strong></td>
				<td><strong>Direcci&oacute;n</strong></td>
  	      </tr>
            <tr>
				<td>
                  <?php
				  $paises[''] = "Seleccione...";
				  foreach($this->mantenimiento_model->buscarPaises() as $dato){
					  $paises[$dato->codigo] = $dato->nombre;
				  }
				  echo form_dropdown('pais', $paises, $modificar->pais, 'disabled="disabled" id="pais" style="width: 200px;"');
				  ?>
				</td>
				<td>
                  <?php
				  $dep[''] = "Seleccione...";
				  foreach($this->mantenimiento_model->buscarDepartamentos() as $dato){
					  $dep[$dato->ubigeo] = $dato->nombre;
				  }
				  echo form_dropdown('departamento', $dep, substr($modificar->residencia,0,2), 'disabled="disabled" id="departamento" style="width: 200px;"');
				  ?>
				</td>
				<td>
                  <?php
				  $prov[''] = "Seleccione...";
				  echo form_dropdown('provincia', $prov, substr($modificar->residencia,0,4), 'disabled="disabled" id="provincia" style="width: 200px;"');
				  ?>
				</td>
				<td>
                  <?php
				  $dist[''] = "Seleccione...";
				  echo form_dropdown('distrito', $dist, $modificar->residencia, 'disabled="disabled" id="distrito" style="width: 200px;"');
				  ?>
				</td>
			  	<td><input name="localidad" type="text" id="localidad" title="Ingrese la localidad donde habita el paciente" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $modificar->localidad;?>" size="20" readonly="readonly" /></td>
			  	<td><input name="direccion" type="text" id="direccion" title="Ingrese la direcci&oacute;n del paciente" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $modificar->direccion;?>" size="30" readonly="readonly" /></td>
          	</tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><hr/></td>
	  	  </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><strong>III. Datos Epidemiol&oacute;gicos: ¿En qu&eacute; lugar estuvo en los &uacute;ltimos 14 d&iacute;as? (Establecer el lugar probable de infecci&oacute;n)</strong></td>
          </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><hr/></td>
	  	  </tr>
            <tr>
				<td><strong>Pa&iacute;s</strong></td>
				<td><strong>Departamento</strong></td>
				<td><strong>Provincia</strong></td>
				<td><strong>Distrito</strong></td>
				<td><strong>Localidad</strong></td>
				<td><strong>Direcci&oacute;n</strong></td>
  	      </tr>
            <tr>
				<td>
                  <?php
				  $paises[''] = "Seleccione...";
				  foreach($this->mantenimiento_model->buscarPaises() as $dato){
					  $paises[$dato->codigo] = $dato->nombre;
				  }
				  echo form_dropdown('pais14_1', $paises, $modificar->pais14_1, 'disabled="disabled" id="pais14_1" style="width: 200px;"');
				  ?>
				</td>
				<td>
                  <?php
				  $dep[''] = "Seleccione...";
				  foreach($this->mantenimiento_model->buscarDepartamentos() as $dato){
					  $dep[$dato->ubigeo] = $dato->nombre;
				  }
				  echo form_dropdown('departamento14_1', $dep, substr($modificar->ubigeo14_1,0,2), 'disabled="disabled" id="departamento14_1" style="width: 200px;"');
				  ?>
				</td>
				<td>
                  <?php
				  $prov1[''] = "Seleccione...";
				  echo form_dropdown('provincia14_1', $prov1, substr($modificar->ubigeo14_1,0,4), 'disabled="disabled" id="provincia14_1" style="width: 200px;"');
				  ?>
				</td>
				<td>
                  <?php
				  $dist1[''] = "Seleccione...";
				  echo form_dropdown('distrito14_1', $dist1, $modificar->ubigeo14_1, 'disabled="disabled" id="distrito14_1" style="width: 200px;"');
				  ?>
				</td>
			  	<td><input name="localidad14_1" type="text" id="localidad14_1" title="Ingrese la localidad donde estuvo el paciente" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $modificar->localidad14_1;?>" size="20" readonly="readonly" /></td>
			  	<td><input name="direccion14_1" type="text" id="direccion14_1" title="Ingrese la direcci&oacute;n donde estuvo el paciente" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $modificar->direccion14_1;?>" size="30" readonly="readonly" /></td>
          	</tr>
            <tr>
				<td>
                  <?php
				  $paises[''] = "Seleccione...";
				  foreach($this->mantenimiento_model->buscarPaises() as $dato){
					  $paises[$dato->codigo] = $dato->nombre;
				  }
				  echo form_dropdown('pais14_2', $paises, $modificar->pais14_2, 'disabled="disabled" id="pais14_2" style="width: 200px;"');
				  ?>
				</td>
				<td>
                  <?php
				  $dep[''] = "Seleccione...";
				  foreach($this->mantenimiento_model->buscarDepartamentos() as $dato){
					  $dep[$dato->ubigeo] = $dato->nombre;
				  }
				  echo form_dropdown('departamento14_2', $dep, substr($modificar->ubigeo14_2,0,2), 'disabled="disabled" id="departamento14_2" style="width: 200px;"');
				  ?>
				</td>
				<td>
                  <?php
				  $prov2[''] = "Seleccione...";
				  echo form_dropdown('provincia14_2', $prov2, substr($modificar->ubigeo14_2,0,4), 'disabled="disabled" id="provincia14_2" style="width: 200px;"');
				  ?>
				</td>
				<td>
                  <?php
				  $dist2[''] = "Seleccione...";
				  echo form_dropdown('distrito14_2', $dist2, $modificar->ubigeo14_2, 'id="disabled="disabled" distrito14_2" style="width: 200px;"');
				  ?>
				</td>
			  	<td><input name="localidad14_2" type="text" id="localidad14_2" title="Ingrese la localidad donde estuvo el paciente" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $modificar->localidad14_2;?>" size="20" readonly="readonly" /></td>
			  	<td><input name="direccion14_2" type="text" id="direccion14_2" title="Ingrese la direcci&oacute;n donde estuvo el paciente" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $modificar->direccion14_2;?>" size="30" readonly="readonly" /></td>
          	</tr>
            <tr>
				<td><strong>Antecedentes</strong></td>
				<td><strong>Comorbilidad</strong></td>
				<td><strong>Gestante</strong></td>
				<td><strong>Conoce otras personas</strong></td>
				<td><strong>¿D&oacute;nde?</strong></td>
  	      </tr>
           <tr>
	           <td>
				<select name="antecedentes" id="antecedentes" title="Elija si tuvo antecedentes previos" disabled="disabled">
				  <option value="" <?php if (!(strcmp("", $modificar->antecedentes))) {echo "selected=\"selected\"";} ?>>Selecione...</option>
				  <option value="1" <?php if (!(strcmp(1, $modificar->antecedentes))) {echo "selected=\"selected\"";} ?>>Si</option>
				  <option value="2" <?php if (!(strcmp(2, $modificar->antecedentes))) {echo "selected=\"selected\"";} ?>>No</option>
				  <option value="3" <?php if (!(strcmp(3, $modificar->antecedentes))) {echo "selected=\"selected\"";} ?>>Ignorado</option>
				</select>
             </td>
             <td><input name="comorbilidad" type="text" id="comorbilidad" title="Ingrese cual morbilidad?" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $modificar->comorbilidad;?>" size="30" readonly="readonly" /></td>
	           <td>
				<select name="gestante" id="gestante" title="Elija si es gestante" disabled="disabled">
				  <option value="" <?php if (!(strcmp("", $modificar->gestante))) {echo "selected=\"selected\"";} ?>>Selecione...</option>
				  <option value="1" <?php if (!(strcmp(1, $modificar->gestante))) {echo "selected=\"selected\"";} ?>>Si</option>
				  <option value="2" <?php if (!(strcmp(2, $modificar->gestante))) {echo "selected=\"selected\"";} ?>>No</option>
				  <option value="3" <?php if (!(strcmp(3, $modificar->gestante))) {echo "selected=\"selected\"";} ?>>Ignorado</option>
				</select>
             </td>
	           <td>
				<select name="conoce_personas" id="conoce_personas" title="Elija si conoce otras personas que presentaron s&iacute;ntomas en los &uacute;ltimo 14 d&iacute;as" disabled="disabled">
				  <option value="" <?php if (!(strcmp("", $modificar->conoce_personas))) {echo "selected=\"selected\"";} ?>>Selecione...</option>
				  <option value="1" <?php if (!(strcmp(1, $modificar->conoce_personas))) {echo "selected=\"selected\"";} ?>>Si</option>
				  <option value="2" <?php if (!(strcmp(2, $modificar->conoce_personas))) {echo "selected=\"selected\"";} ?>>No</option>
				  <option value="3" <?php if (!(strcmp(3, $modificar->conoce_personas))) {echo "selected=\"selected\"";} ?>>Ignorado</option>
				</select>
             </td>
			  	<td><input name="donde" type="text" id="donde" title="Ingrese el lugar" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $modificar->donde;?>" size="20" readonly="readonly" /></td>
          </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><hr/></td>
	  	  </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><strong>IV. Datos cl&iacute;nicos</strong></td>
          </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><hr/></td>
	  	  </tr>
            <tr>
				<td><strong>Inicio de s&iacute;ntomas</strong></td>
				<td><strong>Toma de muestra</strong></td>
  	      </tr>
          <tr>
			  	<td><input name="fecha_sin" type="text" disabled="disabled" id="fecha_sin" placeholder="Ej. dd-mm-YYYY" title="Ingrese la fecha de inicio de s&iacute;ntomas" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $this->fechas_model->modificarFechas($modificar->fecha_sin);?>" size="20" readonly="readonly" /></td>
			  	<td><input name="fecha_mue" type="text" disabled="disabled" id="fecha_mue" placeholder="Ej. dd-mm-YYYY" title="Ingrese la fecha de toma de muestras" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $this->fechas_model->modificarFechas($modificar->fecha_mue);?>" size="20" /></td>
          </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><strong>Signos y s&iacute;ntomas</strong></td>
	  	  </tr>
            <tr>
              <td width="17%"><strong>Fiebre</strong></td>
              <td width="16%">
              <select name="fiebre" id="fiebre" title="Elija si el paciente tuvo fiebre" disabled="disabled">
                <option value="" <?php if (!(strcmp("", $modificar->fiebre))) {echo "selected=\"selected\"";} ?>>Selecione...</option>
                <option value="1" <?php if (!(strcmp(1, $modificar->fiebre))) {echo "selected=\"selected\"";} ?>>Si</option>
                <option value="2" <?php if (!(strcmp(2, $modificar->fiebre))) {echo "selected=\"selected\"";} ?>>No</option>
                <option value="3" <?php if (!(strcmp(3, $modificar->fiebre))) {echo "selected=\"selected\"";} ?>>Ignorado</option>
              </select>
              </td>
              <td width="19%"><strong>Cefalea</strong></td>
              <td width="18%">
              <select name="cefalea" id="cefalea" title="Elija si el paciente tuvo cefalea" disabled="disabled">
                <option value="" <?php if (!(strcmp("", $modificar->cefalea))) {echo "selected=\"selected\"";} ?>>Selecione...</option>
                <option value="1" <?php if (!(strcmp(1, $modificar->cefalea))) {echo "selected=\"selected\"";} ?>>Si</option>
                <option value="2" <?php if (!(strcmp(2, $modificar->cefalea))) {echo "selected=\"selected\"";} ?>>No</option>
                <option value="3" <?php if (!(strcmp(3, $modificar->cefalea))) {echo "selected=\"selected\"";} ?>>Ignorado</option>
              </select>
              </td>
              <td width="6%"><strong>Rash</strong></td>
              <td width="24%">
                <select name="rash" id="rash" title="Elija si el paciente tuvo rash" disabled="disabled">
                  <option value="" <?php if (!(strcmp("", $modificar->rash))) {echo "selected=\"selected\"";} ?>>Selecione...</option>
                  <option value="1" <?php if (!(strcmp(1, $modificar->rash))) {echo "selected=\"selected\"";} ?>>Si</option>
                  <option value="2" <?php if (!(strcmp(2, $modificar->rash))) {echo "selected=\"selected\"";} ?>>No</option>
                  <option value="3" <?php if (!(strcmp(3, $modificar->rash))) {echo "selected=\"selected\"";} ?>>Ignorado</option>
              </select></td>
            </tr>
            <tr>
              <td><strong>Poliartralgias</strong></td>
              <td>
                <select name="poliartralgias" id="poliartralgias" title="Elija si el paciente tuvo poliartralgias" disabled="disabled">
                  <option value="" <?php if (!(strcmp("", $modificar->poliartralgias))) {echo "selected=\"selected\"";} ?>>Selecione...</option>
                  <option value="1" <?php if (!(strcmp(1, $modificar->poliartralgias))) {echo "selected=\"selected\"";} ?>>Si</option>
                  <option value="2" <?php if (!(strcmp(2, $modificar->poliartralgias))) {echo "selected=\"selected\"";} ?>>No</option>
                  <option value="3" <?php if (!(strcmp(3, $modificar->poliartralgias))) {echo "selected=\"selected\"";} ?>>Ignorado</option>
              </select></td>
              <td><strong>Mialgias</strong></td>
              <td>
                <select name="mialgias" id="mialgias" title="Elija si el paciente tuvo mialgias" disabled="disabled">
                  <option value="" <?php if (!(strcmp("", $modificar->mialgias))) {echo "selected=\"selected\"";} ?>>Selecione...</option>
                  <option value="1" <?php if (!(strcmp(1, $modificar->mialgias))) {echo "selected=\"selected\"";} ?>>Si</option>
                  <option value="2" <?php if (!(strcmp(2, $modificar->mialgias))) {echo "selected=\"selected\"";} ?>>No</option>
                  <option value="3" <?php if (!(strcmp(3, $modificar->mialgias))) {echo "selected=\"selected\"";} ?>>Ignorado</option>
              </select></td>
              <td><strong>Otros</strong></td>
              <td>
                <select name="otro" id="otro" title="Elija si el paciente tuvo rash" disabled="disabled">
                  <option value="" <?php if (!(strcmp("", $modificar->otro))) {echo "selected=\"selected\"";} ?>>Selecione...</option>
                  <option value="1" <?php if (!(strcmp(1, $modificar->otro))) {echo "selected=\"selected\"";} ?>>Si</option>
                  <option value="2" <?php if (!(strcmp(2, $modificar->otro))) {echo "selected=\"selected\"";} ?>>No</option>
                  <option value="3" <?php if (!(strcmp(3, $modificar->otro))) {echo "selected=\"selected\"";} ?>>Ignorado</option>
              </select></td>
            </tr>
            <tr>
              <td><strong>Artritis en: Manos</strong></td>
              <td>
                <select name="artritis_manos" id="artritis_manos" title="Elija si el paciente tuvo artritis en manos" disabled="disabled">
                  <option value="" <?php if (!(strcmp("", $modificar->artritis_manos))) {echo "selected=\"selected\"";} ?>>Selecione...</option>
                  <option value="1" <?php if (!(strcmp(1, $modificar->artritis_manos))) {echo "selected=\"selected\"";} ?>>Si</option>
                  <option value="2" <?php if (!(strcmp(2, $modificar->artritis_manos))) {echo "selected=\"selected\"";} ?>>No</option>
                  <option value="3" <?php if (!(strcmp(3, $modificar->artritis_manos))) {echo "selected=\"selected\"";} ?>>Ignorado</option>
              </select></td>
              <td><strong>Dolor difuso en espalda</strong></td>
              <td>
                <select name="dolor_espalda" id="dolor_espalda" title="Elija si el paciente tuvo dolor difuso enn espalda" disabled="disabled">
                  <option value="" <?php if (!(strcmp("", $modificar->dolor_espalda))) {echo "selected=\"selected\"";} ?>>Selecione...</option>
                  <option value="1" <?php if (!(strcmp(1, $modificar->dolor_espalda))) {echo "selected=\"selected\"";} ?>>Si</option>
                  <option value="2" <?php if (!(strcmp(2, $modificar->dolor_espalda))) {echo "selected=\"selected\"";} ?>>No</option>
                  <option value="3" <?php if (!(strcmp(3, $modificar->dolor_espalda))) {echo "selected=\"selected\"";} ?>>Ignorado</option>
              </select></td>
              <td>&nbsp;</td>
              <td><input name="otro_sintoma" type="text" id="otro_sintoma" title="Ingrese si el paciente tiene otro síntoma" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $modificar->otro_sintoma;?>" size="30" readonly="readonly" /></td>
            </tr>
            <tr>
              <td><strong>Artritis en: Pies</strong></td>
              <td>
                <select name="artritis_pies" id="artritis_pies" title="Elija si el paciente tuvo artritis en pies" disabled="disabled">
                  <option value="" <?php if (!(strcmp("", $modificar->artritis_pies))) {echo "selected=\"selected\"";} ?>>Selecione...</option>
                  <option value="1" <?php if (!(strcmp(1, $modificar->artritis_pies))) {echo "selected=\"selected\"";} ?>>Si</option>
                  <option value="2" <?php if (!(strcmp(2, $modificar->artritis_pies))) {echo "selected=\"selected\"";} ?>>No</option>
                  <option value="3" <?php if (!(strcmp(3, $modificar->artritis_pies))) {echo "selected=\"selected\"";} ?>>Ignorado</option>
              </select></td>
              <td><strong>N&aacute;useas</strong></td>
              <td>
                <select name="nauseas" id="nauseas" title="Elija si el paciente tuvo n&aacute;useas" disabled="disabled">
                  <option value="" <?php if (!(strcmp("", $modificar->nauseas))) {echo "selected=\"selected\"";} ?>>Selecione...</option>
                  <option value="1" <?php if (!(strcmp(1, $modificar->nauseas))) {echo "selected=\"selected\"";} ?>>Si</option>
                  <option value="2" <?php if (!(strcmp(2, $modificar->nauseas))) {echo "selected=\"selected\"";} ?>>No</option>
                  <option value="3" <?php if (!(strcmp(3, $modificar->nauseas))) {echo "selected=\"selected\"";} ?>>Ignorado</option>
              </select></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><strong>Artritis en: Tobillos</strong></td>
              <td>
                <select name="artritis_tobillos" id="artritis_tobillos" title="Elija si el paciente tuvo artritis en tobillos" disabled="disabled">
                  <option value="" <?php if (!(strcmp("", $modificar->artritis_tobillos))) {echo "selected=\"selected\"";} ?>>Selecione...</option>
                  <option value="1" <?php if (!(strcmp(1, $modificar->artritis_tobillos))) {echo "selected=\"selected\"";} ?>>Si</option>
                  <option value="2" <?php if (!(strcmp(2, $modificar->artritis_tobillos))) {echo "selected=\"selected\"";} ?>>No</option>
                  <option value="3" <?php if (!(strcmp(3, $modificar->artritis_tobillos))) {echo "selected=\"selected\"";} ?>>Ignorado</option>
              </select></td>
              <td><strong>V&oacute;mitos</strong></td>
              <td>
                <select name="vomitos" id="vomitos" title="Elija si el paciente tuvo v&oacute;mitos" disabled="disabled">
                  <option value="" <?php if (!(strcmp("", $modificar->vomitos))) {echo "selected=\"selected\"";} ?>>Selecione...</option>
                  <option value="1" <?php if (!(strcmp(1, $modificar->vomitos))) {echo "selected=\"selected\"";} ?>>Si</option>
                  <option value="2" <?php if (!(strcmp(2, $modificar->vomitos))) {echo "selected=\"selected\"";} ?>>No</option>
                  <option value="3" <?php if (!(strcmp(3, $modificar->vomitos))) {echo "selected=\"selected\"";} ?>>Ignorado</option>
              </select></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><strong>Artritis en: Otros</strong></td>
              <td>
                <select name="artritis_otros" id="artritis_otros" title="Elija si el paciente tuvo artritis en otros lugares" disabled="disabled">
                  <option value="" <?php if (!(strcmp("", $modificar->artritis_otros))) {echo "selected=\"selected\"";} ?>>Selecione...</option>
                  <option value="1" <?php if (!(strcmp(1, $modificar->artritis_otros))) {echo "selected=\"selected\"";} ?>>Si</option>
                  <option value="2" <?php if (!(strcmp(2, $modificar->artritis_otros))) {echo "selected=\"selected\"";} ?>>No</option>
                  <option value="3" <?php if (!(strcmp(3, $modificar->artritis_otros))) {echo "selected=\"selected\"";} ?>>Ignorado</option>
              </select></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td><input name="otro_artritis" type="text" id="otro_artritis" title="Ingrese si el paciente tiene otro s&iacute;ntoma de artritis" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $modificar->otro_artritis;?>" size="30" readonly="readonly" /></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><hr/></td>
	  	  </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><strong>V. Examenes de laboratorio</strong></td>
          </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><hr/></td>
	  	  </tr>
            <tr>
				<td><strong>Serolog&iacute;a</strong></td>
				<td><strong>Toma de muestra</strong></td>
				<td><strong>IgM (T&iacute;tulo)</strong></td>
				<td><strong>IgG (T&iacute;tulo)</strong></td>
				<td><strong>Resultado</strong></td>
				<td><strong>Fecha Resultado</strong></td>
  	      </tr>
          <tr>
				<td><strong>1era. Muestra</strong></td>
			  	<td><input name="fecha_ser1" type="text" disabled="disabled" id="fecha_ser1" placeholder="Ej. dd-mm-YYYY" title="Ingrese la fecha de toma de la primera muestra" value="<?php echo $this->fechas_model->modificarFechas($modificar->fecha_ser1);?>" size="20" readonly="readonly" /></td>
			  	<td><input name="igm1" type="text" id="igm1" title="Ingrese el t&iacute;tulo IgM de la muestra" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $modificar->igm1;?>" size="20" readonly="readonly" /></td>
			  	<td><input name="igg1" type="text" id="igg1" title="Ingrese el t&iacute;tulo IgG de la muestra" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $modificar->igg1;?>" size="20" readonly="readonly" /></td>
			  	<td><input name="resultado1" type="text" id="resultado1" title="Ingrese el resultado de la muestra" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $modificar->resultado1;?>" size="20" readonly="readonly" /></td>
			  	<td><input name="fecha_res1" type="text" disabled="disabled" id="fecha_res1" placeholder="Ej. dd-mm-YYYY" title="Ingrese la fecha del resultado de la primera muestra" value="<?php echo $this->fechas_model->modificarFechas($modificar->fecha_res1);?>" size="20" /></td>
          </tr>
          <tr>
				<td><strong>2da. Muestra</strong></td>
			  	<td><input name="fecha_ser2" type="text" disabled="disabled" id="fecha_ser2" placeholder="Ej. dd-mm-YYYY" title="Ingrese la fecha de toma de la segunda muestra" value="<?php echo $this->fechas_model->modificarFechas($modificar->fecha_ser2);?>" size="20" /></td>
			  	<td><input name="igm2" type="text" id="igm2" title="Ingrese el t&iacute;tulo IgM de la muestra" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $modificar->igm2;?>" size="20" readonly="readonly" /></td>
			  	<td><input name="igg2" type="text" id="igg2" title="Ingrese el t&iacute;tulo IgG de la muestra" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $modificar->igg2;?>" size="20" readonly="readonly" /></td>
			  	<td><input name="resultado2" type="text" id="resultado2" title="Ingrese el resultado de la muestra" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $modificar->resultado2;?>" size="20" readonly="readonly" /></td>
			  	<td><input name="fecha_res2" type="text" disabled="disabled" id="fecha_res2" placeholder="Ej. dd-mm-YYYY" title="Ingrese la fecha del resultado de la segunda muestra" value="<?php echo $this->fechas_model->modificarFechas($modificar->fecha_res2);?>" size="20" /></td>
          </tr>
            <tr>
				<td><strong>PCR</strong></td>
				<td><strong>Toma de muestra</strong></td>
				<td><strong>Positivo</strong></td>
				<td><strong>Fecha Resultado</strong></td>
  	      </tr>
          <tr>
	            <td></td>
			  	<td><input name="fecha_pcr" type="text" id="fecha_pcr" placeholder="Ej. dd-mm-YYYY" title="Ingrese la fecha de toma de la muestra" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $this->fechas_model->modificarFechas($modificar->fecha_pcr);?>" size="20" readonly="readonly" /></td>
	           <td>
				<select name="positivo" id="positivo" title="Elija si es positivo" disabled="disabled">
				  <option value="" <?php if (!(strcmp("", $modificar->positivo))) {echo "selected=\"selected\"";} ?>>Selecione...</option>
				  <option value="1" <?php if (!(strcmp(1, $modificar->positivo))) {echo "selected=\"selected\"";} ?>>Si</option>
				  <option value="2" <?php if (!(strcmp(2, $modificar->positivo))) {echo "selected=\"selected\"";} ?>>No</option>
				  <option value="3" <?php if (!(strcmp(3, $modificar->positivo))) {echo "selected=\"selected\"";} ?>>Ignorado</option>
				</select>
             </td>
			  	<td><input name="fecha_res3" type="text" disabled="disabled" id="fecha_res3" placeholder="Ej. dd-mm-YYYY" title="Ingrese la fecha de resultado de la muestra" value="<?php echo $this->fechas_model->modificarFechas($modificar->fecha_res3);?>" size="20" /></td>
          </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><hr/></td>
	  	  </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><strong>VI. Evoluci&oacute;n</strong></td>
          </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><hr/></td>
	  	  </tr>
            <tr>
				<td><strong>Fecha Hospitalizaci&oacute;n</strong></td>
				<td><strong>Evoluci&oacute;n del paciente</strong></td>
				<td></td>
				<td><strong>Fecha</strong></td>
  	      </tr>
          <tr>
			  	<td><input name="fecha_hos" type="text" disabled="disabled" id="fecha_hos" placeholder="Ej. dd-mm-YYYY" title="Ingrese la fecha de hospitalziaci&oacute;n del paciente" value="<?php echo $this->fechas_model->modificarFechas($modificar->fecha_hos);?>" size="20" /></td>
				<td><strong>Alta</strong></td>
	           <td>
				<select name="alta" id="alta" title="Elija la opci&oacute;n de alta" disabled="disabled">
				  <option value="" <?php if (!(strcmp("", $modificar->alta))) {echo "selected=\"selected\"";} ?>>Selecione...</option>
				  <option value="1" <?php if (!(strcmp(1, $modificar->alta))) {echo "selected=\"selected\"";} ?>>Si</option>
				  <option value="2" <?php if (!(strcmp(2, $modificar->alta))) {echo "selected=\"selected\"";} ?>>No</option>
				  <option value="3" <?php if (!(strcmp(3, $modificar->alta))) {echo "selected=\"selected\"";} ?>>Ignorado</option>
				</select>
             </td>
			  	<td><input name="fecha_alt" type="text" disabled="disabled" id="fecha_alt" placeholder="Ej. dd-mm-YYYY" title="Ingrese la fecha de alta del paciente" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $this->fechas_model->modificarFechas($modificar->fecha_alt);?>" size="20" /></td>
          </tr>
          <tr>
			  	<td></td>
				<td><strong>Referido</strong></td>
	           <td>
				<select name="referido" id="referido" title="Elija la opci&oacute;n de referido" disabled="disabled">
				  <option value="" <?php if (!(strcmp("", $modificar->referido))) {echo "selected=\"selected\"";} ?>>Selecione...</option>
				  <option value="1" <?php if (!(strcmp(1, $modificar->referido))) {echo "selected=\"selected\"";} ?>>Si</option>
				  <option value="2" <?php if (!(strcmp(2, $modificar->referido))) {echo "selected=\"selected\"";} ?>>No</option>
				  <option value="3" <?php if (!(strcmp(3, $modificar->referido))) {echo "selected=\"selected\"";} ?>>Ignorado</option>
				</select>
             </td>
			  	<td><input name="fecha_ref" type="text" disabled="disabled" id="fecha_ref" placeholder="Ej. dd-mm-YYYY" title="Ingrese la fecha de referencia del paciente" value="<?php echo $this->fechas_model->modificarFechas($modificar->fecha_ref);?>" size="20" /></td>
          </tr>
          <tr>
			  	<td></td>
				<td><strong>Fallecido</strong></td>
	           <td>
				<select name="fallecido" id="fallecido" title="Elija la opci&oacute;n de fallecido" disabled="disabled">
				  <option value="" <?php if (!(strcmp("", $modificar->fallecido))) {echo "selected=\"selected\"";} ?>>Selecione...</option>
				  <option value="1" <?php if (!(strcmp(1, $modificar->fallecido))) {echo "selected=\"selected\"";} ?>>Si</option>
				  <option value="2" <?php if (!(strcmp(2, $modificar->fallecido))) {echo "selected=\"selected\"";} ?>>No</option>
				  <option value="3" <?php if (!(strcmp(3, $modificar->fallecido))) {echo "selected=\"selected\"";} ?>>Ignorado</option>
				</select>
             </td>
			  	<td><input name="fecha_def" type="text" disabled="disabled" id="fecha_def" placeholder="Ej. dd-mm-YYYY" title="Ingrese la fecha de defunci&oacute;n del paciente" value="<?php echo $this->fechas_model->modificarFechas($modificar->fecha_def);?>" size="20" /></td>
          </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><hr/></td>
	  	  </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><strong>VII. Clasificaci&oacute;n Final</strong></td>
          </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><hr/></td>
	  	  </tr>
          <tr>
              <td><strong>Caso Probable</strong>&nbsp;&nbsp;
              <?php
			   if($modificar->probable == '1'){
				   ?>
	              <input name="probable" type="checkbox" id="probable" title="Elija si el caso es probable" checked="checked" disabled="disabled"/>
                    <?php
			   }else{
				   ?>
	              <input name="probable" type="checkbox" id="probable" title="Elija si el caso es probable" disabled="disabled"/>
                   <?php
			   }
			   ?>
               </td>
              <td><strong>Caso Confirmado</strong>&nbsp;&nbsp;
              <?php
			   if($modificar->confirmado == '1'){
				   ?>
	              <input name="confirmado" type="checkbox" id="confirmado" title="Elija si el caso es confirmado" checked="checked" disabled="disabled"/>
                    <?php
			   }else{
				   ?>
	              <input name="confirmado" type="checkbox" id="confirmado" title="Elija si el caso es confirmado" disabled="disabled"/>
                   <?php
			   }
			   ?>
				</td>
              <td><strong>Caso Descartado</strong>&nbsp;&nbsp;
              <?php
			   if($modificar->descartado == '1'){
				   ?>
	              <input name="descartado" type="checkbox" id="descartado" title="Elija si el caso es descartado" checked="checked" disabled="disabled"/>
                    <?php
			   }else{
				   ?>
	              <input name="descartado" type="checkbox" id="descartado" title="Elija si el caso es descartado" disabled="disabled"/>
                   <?php
			   }
			   ?>
				</td>
              <td><strong>Especificar la causa de descarte</strong></td>
              <td colspan="2"><input name="causa_desc" type="text" id="causa_desc" title="Ingrese la causa de descarte" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $modificar->causa_desc;?>" size="55" readonly="readonly" /></td>
			</tr>              
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><hr/></td>
	  	  </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><strong>VIII. Procedencia del Caso</strong></td>
          </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><hr/></td>
	  	  </tr>
          <tr>
              <td><strong>Aut&oacute;ctono</strong>&nbsp;&nbsp;
              <?php
			   if($modificar->autoctono == '1'){
				   ?>
              		<input name="autoctono" type="checkbox" id="autoctono" title="Elija si el caso es autoctono" checked="checked" disabled="disabled"/>
                    <?php
			   }else{
				   ?>
              		<input name="autoctono" type="checkbox" id="autoctono" title="Elija si el caso es autoctono" disabled="disabled" />
                    <?php
			   }
			   ?>
               </td>
              <td><strong>Importado Nacional</strong>&nbsp;&nbsp;
              <?php
			   if($modificar->nacional == '1'){
				   ?>
              		<input name="nacional" type="checkbox" id="nacional" title="Elija si el caso es importado nacional" checked="checked" disabled="disabled"/>
                    <?php
			   }else{
				   ?>
              		<input name="nacional" type="checkbox" id="nacional" title="Elija si el caso es importado nacional" disabled="disabled"/>
                    <?php
			   }
			   ?>
				</td>
              <td><strong>Importado Internacional</strong>&nbsp;&nbsp;
              <?php
			   if($modificar->importado == '1'){
				   ?>
	        	     <input name="importado" type="checkbox" id="importado" title="Elija si el caso es importado internacional" checked="checked" disabled="disabled"/>
                    <?php
			   }else{
				   ?>
	        	     <input name="importado" type="checkbox" id="importado" title="Elija si el caso es importado internacional" disabled="disabled"/>
                    <?php
			   }
			   ?>
			</td>
			</tr>              
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><hr/></td>
	  	  </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><strong>IX. Observaciones</strong></td>
          </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><hr/></td>
	  	  </tr>
          <tr>
              <td colspan="6"><?php 
			  $datos = array(
							'name'        => 'observaciones',
							'id'          => 'observaciones',
							'value'       =>  $modificar->observaciones,
							'rows'   	  => '5',
							'cols'        => '100',
							'style'       => 'width:100%',
						  );
			  
			  echo form_textarea($datos);?>
          </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><hr/></td>
	  	  </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><strong>X. Datos de la persona que realiza la investigaci&oacute;n</strong></td>
          </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><hr/></td>
	  	  </tr>
          <tr>
              <td><strong>Nombre del investigador</strong></td>
			  	<td><input name="investigador" type="text" id="investigador" title="Ingrese el nombre del investigador" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $modificar->investigador;?>" size="30" readonly="readonly" /></td>
			</tr>                
            <tr>
              <td><strong>Cargo</strong></td>
			  	<td><input name="cargo" type="text" id="cargo" title="Ingrese el cargo del investigador" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $modificar->cargo;?>" size="30" readonly="readonly" /></td>
            </tr>
            <tr>
              <td><strong>Tel&eacute;fono</strong></td>
			  	<td>
           	  	<input name="telefono" type="text" id="telefono" title="Ingrese el tel&eacute;fono del investigador" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $modificar->telefono;?>" size="30" readonly="readonly" /></td>
                <td></td>
                <td colspan="2" align="center"></td>
			</tr>                
            <tr>
              <td><strong>Correo</strong></td>
			  	<td><input name="correo" type="text" id="correo" title="Ingrese el correo del investigador" value="<?php echo $modificar->correo;?>" size="30" readonly="readonly" /></td>
                <td></td>
                <td colspan="2" align="center"></td>
           </tr>
          </tr>
          <tr>
			  <td colspan="8">
              <hr />
			  </td>
          </tr>
		</table>  
	</div>
<!--</div>-->
<?php
    echo form_close();
?>