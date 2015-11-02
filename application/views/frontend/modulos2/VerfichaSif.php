<?php
    if($this->session->flashdata('ControllerMessage') != ''){
        ?>
        <div class="error"><?php echo $this->session->flashdata('ControllerMessage'); ?></div>
        <?php
    }
    $atributos = array('id'=>'form1', 'name'=>'form1');
    echo form_open(null, $atributos);
?>
<br/>  
<p><input type="button" id="imprime" value="&nbsp;Imprimir&nbsp;"></p>
<br/>  
<div class="formulario1">
	<div><img src="<?php echo base_url().'public/images/logo.png';?>" width="300" height="40" alt="logo" /></div>
    <center><h2>Ficha de Investigaci&oacute;n Epidemiol&oacute;gica</h2></center>
    <center><h2>S&iacute;filis Materna y S&iacute;filis Cong&eacute;nita</h2></center>
	<div style="border: solid 1px #000; width: 100%;">
		<table width="100%" align="center">
			<tr>
			  <td colspan="4" bgcolor="#000" style="color:#FFF;"><strong>&nbsp;I. DATOS GENERALES:</strong></td>
		  	</tr>
			<tr>
			  <td colspan="4" bgcolor="#CCCCCC"><hr/></td>
	  	  </tr>
			<tr>
				<td><strong>Apellidos y nombres de la madre:</strong></td>
			  	<td>
	              <input name="madre_apenom" type="text" id="madre_apenom" title="Vienen del NotiWeb" value="<?php echo $modificar->madre_apenom;?>" size="50" readonly="readonly" /></td>
			  	<td colspan="2"><strong>Código (DNI Madre)</strong></td>
	  	  	</tr>
            <tr>
				<td><strong>Apellidos y nombres del hijo (a):</strong></td>
			  	<td><?php echo form_error('hijo_apenom', '<div class="warning">', '</div>'); ?>
                <input name="hijo_apenom" type="text" id="hijo_apenom" title="Registrar los apellidos y nombres del hijo (a)" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $modificar->hijo_apenom;?>" size="50" readonly="readonly" /></td>
			  	<td colspan="2"><input name="codigo" type="text" id="codigo" title="Vienen del NotiWeb" value="<?php echo $modificar->codigo;?>" size="15" readonly="readonly" /></td>
	  	  	</tr>
		    <tr>
		      <td><strong>Establecimiento de Salud:</strong></td>
			   <td><input name="establecimiento" type="text" id="establecimiento" title="Vienen del NotiWeb" value="<?php echo $modificar->raz_soc;?>" size="50" readonly="readonly" /></td>
			   <td colspan="2"><strong>Nivel de establecimiento</strong></td>
	      	</tr>
			<tr>
			   <td><strong>Instituci&oacute;n:</strong></td>
			   <td><input name="insti" type="text" id="insti" title="Vienen del NotiWeb" value="<?php echo $modificar->institucion;?>" size="15" readonly="readonly" /></td>
			   <td colspan="2"><input name="categoria" type="text" id="categoria" title="Vienen del NotiWeb" value="<?php echo $modificar->categoria;?>" size="15" readonly="readonly" /></td>
	      	</tr>
		    <tr>  
				<td><strong>DISA/DIRESA/GERESA</strong></td>
				<td><strong>Redes</strong></td>
				<td colspan="2"><strong>Microred</strong></td>
		  	</tr>
            <tr>
				<td><input name="subregion" type="text" id="subregion" title="Vienen del NotiWeb" value="<?php echo $modificar->diresas;?>" size="25" readonly="readonly" /></td>
				<td><input name="red" type="text" id="red" title="Vienen del NotiWeb" value="<?php echo $modificar->redes;?>" size="50" readonly="readonly" /></td>
				<td colspan="2"><input name="mred" type="text" id="mred" title="Vienen del NotiWeb" value="<?php echo $modificar->microredes;?>" size="50" readonly="readonly" /></td>
          	</tr>
            <tr>
              <td><strong>Fecha de notificaci&oacute;n</strong></td>
              <td><strong>Semana epidemiol&oacute;gica</strong></td>
              <td colspan="2"><strong>Investigaci&oacute;n de:</strong></td>
            </tr>
            <tr>
              <td><?php echo form_error('fecha_not', '<div class="warning">', '</div>'); ?>
              <input name="fecha_not" type="text" id="fecha_not" title="Ingrese la fecha de investigaci&oacute;n" value="<?php echo $this->fechas_model->modificarFechas($modificar->fecha_not);?>" size="15" /></td>
              <td><input name="semana" type="text" id="semana" title="Vienen del NotiWeb" value="<?php echo $modificar->semana;?>" size="5" readonly="readonly" /></td>
              <td><?php echo form_error('sifilis1', '<div class="warning">', '</div>'); 
			  if($modificar->tiposMat == "1"){
				  ?>
				  <input name="sifilis1" type="checkbox" id="sifilis1" checked="checked" disabled="disabled" title="Haga click de ser el caso" /> 
                  <?php
			  }else{
				  ?>
				  <input name="sifilis1" type="checkbox" id="sifilis1" disabled="disabled" title="Haga click de ser el caso" /> 
                  <?php
			  }
			  ?>
			  <strong>S&iacute;filis materna</strong>&nbsp;&nbsp;</td>
              <td><?php echo form_error('sifilis2', '<div class="warning">', '</div>'); 
			  if($modificar->tiposCon == "1"){
				  ?>
				  <input name="sifilis2" type="checkbox" id="sifilis2" checked="checked" disabled="disabled" title="Haga click de ser el caso" /> 
                  <?php
			  }else{
				  ?>
				  <input name="sifilis2" type="checkbox" id="sifilis2" disabled="disabled" title="Haga click de ser el caso" /> 
                  <?php
			  }
			  ?>
              <strong>S&iacute;filis cong&eacute;nita</strong></td>
            </tr>
			<tr>
			  <td colspan="9" bgcolor="#CCCCCC"><hr/></td>
	  	  	</tr>
        </table>
   		<table width="100%" align="center">
			<tr>
			  <td colspan="5" bgcolor="#000" style="color:#FFF;"><strong>&nbsp;II. SIFILIS MATERNA:</strong></td>
		  	</tr>
			<tr>
			  <td colspan="5" bgcolor="#CCCCCC"><hr/></td>
	  	  	</tr>
			<tr>
			  <td colspan="5" bgcolor="#CCCCCC"><strong>&nbsp;Informaci&oacute;n demogr&aacute;fica</strong></td>
		  	</tr>
            <tr>
              <td><strong>Fecha de nacimiento</strong></td>
              <td><strong>Edad en a&ntilde;os</strong></td>
              <td><strong>Tipo de Edad</strong></td>
            </tr>
            <tr>
              <td><?php echo form_error('fecha_nac', '<div class="warning">', '</div>'); ?>
              <input name="fecha_nac" type="text" id="fecha_nac" title="Ingrese la fecha de nacimiento del paciente" value="<?php echo $this->fechas_model->modificarFechas($modificar1->fecha_nac);?>" size="15" readonly="readonly" placeholder="Ej. dd-mm-YYYY" /></td>
              <td><input name="edad" type="text" id="edad" title="Vienen del NotiWeb" value="<?php echo $modificar1->edad;?>" size="5" readonly="readonly" /></td>
               <?php
			   switch($modificar1->tipo_edad)
			   {
				   case 'A':
				   $tedad = 'A&Ntilde;OS';
				   break;
				   case 'D':
				   $tedad = 'DIAS';
				   break;
				   case 'M':
				   $tedad = 'MESES';
				   break;
			   }
			   ?>
			   <td><input name="tedad" type="text" id="tedad" title="Vienen del NotiWeb" value="<?php echo $tedad;?>" size="15" readonly="readonly" /></td>
            </tr>
			<tr>
			  <td colspan="5" bgcolor="#CCCCCC"><hr/></td>
	  	    </tr>
			<tr>
			  <td colspan="5"><strong>Lugar de residencia habitual</strong></td>
		  	</tr>
			<tr>
			  <td colspan="5" bgcolor="#CCCCCC"><hr/></td>
	  	    </tr>
            <tr>
              <td><strong>Pa&iacute;s</strong></td>
              <td><strong>Departamento</strong></td>
              <td><strong>Provincia</strong></td>
              <td><strong>Distrito</strong></td>
              <td><strong>localidad</strong></td>
            </tr>
            <tr>
              <td>
                <?php
                $paises[''] = "Seleccione...";
                foreach($this->mantenimiento_model->buscarPaises() as $dato){
                    $paises[$dato->codigo] = $dato->nombre;
                }
                echo form_dropdown('pais', $paises, $modificar1->pais, 'id="pais" disabled="disabled" style="width: 200px;"');
                ?>
              </td>
              <td>
                <?php echo form_error('departamento', '<div class="warning">', '</div>'); 
                $dep[''] = "Seleccione...";
                foreach($this->mantenimiento_model->buscarDepartamentos() as $dato){
                    $dep[$dato->ubigeo] = $dato->nombre;
                }
                echo form_dropdown('departamento', $dep, substr($modificar1->residencia,0,2), 'id="departamento" disabled="disabled" style="width: 200px;"');
                ?>
              </td>
              <td>
                <?php echo form_error('provincia', '<div class="warning">', '</div>'); 
                $prov[''] = "Seleccione...";
                echo form_dropdown('provincia', $prov, substr($modificar1->residencia,0,4), 'id="provincia" disabled="disabled" style="width: 200px;"');
                ?>
              </td>
              <td>
                <?php echo form_error('distrito', '<div class="warning">', '</div>'); 
                $dist[''] = "Seleccione...";
                echo form_dropdown('distrito', $dist, $modificar1->residencia, 'id="distrito" disabled="disabled" style="width: 200px;"');
                ?>
              </td>
              <td><?php echo form_error('localidad', '<div class="warning">', '</div>'); ?>
              <input name="localidad" type="text" id="localidad" title="Ingrese la localidad donde habita el paciente" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $modificar1->localidad;?>" size="40" readonly="readonly" /></td>
			</tr>              
			<tr>
			  <td colspan="5" bgcolor="#CCCCCC"><hr/></td>
	  	  	</tr>
			<tr>
			  <td colspan="5" bgcolor="#CCCCCC"><strong>&nbsp;Embarazo actual</strong></td>
		  	</tr>
			<tr>
			  <td colspan="5" bgcolor="#CCCCCC"><hr/></td>
	  	    </tr>
            <tr>
              <td><strong>Ultimo control mestrual</strong></td>
              <td></td>
              <td><strong>Recibi&oacute; atenci&oacute;n prenatal</strong></td>
            </tr>
            <tr>
              <td>
              <input name="fecha_ini" type="text" id="fecha_ini" title="Ingrese la fecha de inicio de &uacute;ltima mestruasi&oacute;n" value="<?php echo $this->fechas_model->modificarFechas($modificar1->fecha_ini);?>" size="15" readonly="readonly" placeholder="Ej. dd-mm-YYYY" /></td>
              <td>
              <?php
			  if($modificar1->desconocido_ini == "1"){
				  ?>
				  <input name="desconocido_ini" type="checkbox" id="desconocido_ini" checked="checked" disabled="disabled" title="Desconoce la fecha de inicio de &uacute;ltima mestruasi&oacute;n" />&nbsp;&nbsp;<strong>Desconocido</strong></td>
				  <?php                  
			  }else{
				  ?>
				  <input name="desconocido_ini" type="checkbox" id="desconocido_ini" disabled="disabled" title="Desconoce la fecha de inicio de &uacute;ltima mestruasi&oacute;n" />&nbsp;&nbsp;<strong>Desconocido</strong></td>
				  <?php                  
			  }
			  ?>
              <td>
                <select name="atencion" id="atencion" disabled="disabled" title="Elija si la paciente recibi&oacute; atenci&oacute;n prenatal">
                  <option value="">Selecione...</option>
                  <option value="1" <?php if($modificar1->atencion == "1"){?> selected="selected" <?php }?>>Si</option>
                  <option value="2" <?php if($modificar1->atencion == "2"){?> selected="selected" <?php }?>>No</option>
                  <option value="3" <?php if($modificar1->atencion == "3"){?> selected="selected" <?php }?>>Desconocido</option>
                </select>
              </td>            
            </tr>
            <tr>
              <td><strong>Primer control prenatal</strong></td>
              <td></td>
              <td><strong>Edad gestacional en 1er. control prenatal</strong></td>
            </tr>
            <tr>
              <td><input name="fecha_con1" type="text" id="fecha_con1" title="Ingrese la fecha de primer control prenatal" value="<?php echo $this->fechas_model->modificarFechas($modificar1->fecha_con1);?>" size="15" readonly="readonly" placeholder="Ej. dd-mm-YYYY" /></td>
              <td>
              <?php
			  if($modificar1->desconocido_con1 == "1"){
				  ?>
	              <input name="desconocido_con1" type="checkbox" id="desconocido_con1" checked="checked" disabled="disabled" title="Desconoce la fecha de primer control prenatal" />&nbsp;&nbsp;<strong>Desconocido</strong></td>
				  <?php                  
			  }else{
				  ?>
	              <input name="desconocido_con1" type="checkbox" id="desconocido_con1" disabled="disabled" title="Desconoce la fecha de primer control prenatal" />&nbsp;&nbsp;<strong>Desconocido</strong></td>
				  <?php                  
			  }
			  ?>
              <td><input name="edad_ges" type="text" id="edad_ges" title="Ingrese edad gestacional" value="<?php echo $modificar1->edad_ges;?>" size="5" readonly="readonly" /></td>            
            </tr>
			<tr>
			  <td colspan="5" bgcolor="#CCCCCC"><hr/></td>
	  	    </tr>
			<tr>
			  <td colspan="5" align="justify"><strong>Indique las fechas y resultados de la primera (a) y la m&aacute;s reciente (b) prueba no trepon&eacute;mica (RPR, VDRL) realizada durante la gestaci&oacute;n, parto o puerperio.</strong></td>
		  	</tr>
			<tr>
			  <td colspan="5" bgcolor="#CCCCCC"><hr/></td>
	  	    </tr>
            <tr>
              <td><strong>Fecha (d&iacute;a - mes - a&ntilde;o)</strong></td>
              <td><strong>Resultados</strong></td>
              <td><strong>T&iacute;tulo</strong></td>
              <td><strong>Momento</strong></td>
            </tr>
            <tr>
              <td><?php echo form_error('fecha_ntrep1', '<div class="warning">', '</div>'); ?>
              <input name="fecha_ntrep1" type="text" id="fecha_ntrep1" title="Ingrese la fecha correspondiente" value="<?php echo $this->fechas_model->modificarFechas($modificar1->fecha_ntrep1);?>" size="15" readonly="readonly" placeholder="Ej. dd-mm-YYYY" /></td>
              <td><?php echo form_error('resultados_ntrep1', '<div class="warning">', '</div>'); ?>
                <select name="resultados_ntrep1" id="resultados_ntrep1" disabled="disabled" title="Elija el resultado correspondiente">
                  <option value="">Selecione...</option>
                  <option value="1" <?php if($modificar1->resultados_ntrep1 == "1"){?> selected="selected" <?php }?>>Reactivo</option>
                  <option value="2" <?php if($modificar1->resultados_ntrep1 == "2"){?> selected="selected" <?php }?>>No reactivo</option>
                  <option value="3" <?php if($modificar1->resultados_ntrep1 == "3"){?> selected="selected" <?php }?>>Desconocido</option>
                </select>
              </td>      
              <td><?php echo form_error('titulo_ntrep1', '<div class="warning">', '</div>'); ?>      
              <input name="titulo_ntrep1" type="text" id="titulo_ntrep1" title="Ingrese los t&iacute;tulos de los resultados" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $modificar1->titulo_ntrep1;?>" size="30" readonly="readonly" /></td>            
              <td><?php echo form_error('momento_ntrep1', '<div class="warning">', '</div>'); ?>    
                <select name="momento_ntrep1" id="momento_ntrep1" disabled="disabled" title="Elija el momento correspondiente">
                  <option value="">Selecione...</option>
                  <option value="1" <?php if($modificar1->momento_ntrep1 == "1"){?> selected="selected" <?php }?>>Gestaci&oacute;n</option>
                  <option value="2" <?php if($modificar1->momento_ntrep1 == "2"){?> selected="selected" <?php }?>>Parto</option>
                  <option value="3" <?php if($modificar1->momento_ntrep1 == "3"){?> selected="selected" <?php }?>>Puerperio</option>
                </select>
              </td>            
            </tr>
            <tr>
              <td><?php echo form_error('fecha_ntrep2', '<div class="warning">', '</div>'); ?>
              <input name="fecha_ntrep2" type="text" id="fecha_ntrep2" title="Ingrese la fecha correspondiente" value="<?php echo $this->fechas_model->modificarFechas($modificar1->fecha_ntrep2);?>" size="15" readonly="readonly" placeholder="Ej. dd-mm-YYYY" /></td>
              <td><?php echo form_error('resultados_ntrep2', '<div class="warning">', '</div>'); ?>
                <select name="resultados_ntrep2" id="resultados_ntrep2" disabled="disabled" title="Elija el resultado correspondiente">
                  <option value="">Selecione...</option>
                  <option value="1" <?php if($modificar1->resultados_ntrep2 == "1"){?> selected="selected" <?php }?>>Reactivo</option>
                  <option value="2" <?php if($modificar1->resultados_ntrep2 == "2"){?> selected="selected" <?php }?>>No reactivo</option>
                  <option value="3" <?php if($modificar1->resultados_ntrep2 == "3"){?> selected="selected" <?php }?>>Desconocido</option>
                </select>
              </td>            
              <td><?php echo form_error('titulo_ntrep2', '<div class="warning">', '</div>'); ?>
              <input name="titulo_ntrep2" type="text" id="titulo_ntrep2" title="Ingrese los t&iacute;tulos de los resultados" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $modificar1->titulo_ntrep2;?>" size="30" readonly="readonly" /></td>            
              <td><?php echo form_error('momento_ntrep2', '<div class="warning">', '</div>'); ?>  
                <select name="momento_ntrep2" id="momento_ntrep2" disabled="disabled" title="Elija el momento correspondiente">
                  <option value="">Selecione...</option>
                  <option value="1" <?php if($modificar1->momento_ntrep2 == "1"){?> selected="selected" <?php }?>>Gestaci&oacute;n</option>
                  <option value="2" <?php if($modificar1->momento_ntrep2 == "2"){?> selected="selected" <?php }?>>Parto</option>
                  <option value="3" <?php if($modificar1->momento_ntrep2 == "3"){?> selected="selected" <?php }?>>Puerperio</option>
                </select>
              </td>            
            </tr>
			<tr>
			  <td colspan="5" bgcolor="#CCCCCC"><hr/></td>
	  	    </tr>
			<tr>
			  <td colspan="5"><strong>Indique las fechas y resultados de la primera (a) y la m&aacute;s reciente (b) prueba trepon&eacute;mica (TPHA, TPPA, FTA Abs, ELISA prueba r&aacute;pida o dual) realizada durante la gestaci&oacute;n, parto o puerperio.</strong></td>
		  	</tr>
			<tr>
			  <td colspan="5" bgcolor="#CCCCCC"><hr/></td>
	  	    </tr>
            <tr>
              <td><strong>Fecha (d&iacute;a - mes - a&ntilde;o)</strong></td>
              <td><strong>Tipo de prueba</strong></td>
              <td></td>
              <td><strong>Resultados</strong></td>
              <td><strong>Momento</strong></td>
            </tr>
            <tr>
              <td><?php echo form_error('fecha_trep1', '<div class="warning">', '</div>'); ?>
              <input name="fecha_trep1" type="text" id="fecha_trep1" title="Ingrese la fecha correspondiente" value="<?php echo $this->fechas_model->modificarFechas($modificar1->fecha_trep1);?>" size="15" readonly="readonly" placeholder="Ej. dd-mm-YYYY" /></td>
              <td><?php echo form_error('tipo_trep1', '<div class="warning">', '</div>'); ?>
                <select name="tipo_trep1" id="tipo_trep1" disabled="disabled" title="Elija el tipo de prueba correspondiente">
                  <option value="">Selecione...</option>
                  <option value="1" <?php if($modificar1->tipo_trep1 == "1"){?> selected="selected" <?php }?>>Prueba r&aacute;pida/ Prueba dual</option>
                  <option value="2" <?php if($modificar1->tipo_trep1 == "2"){?> selected="selected" <?php }?>>R&aacute;pida</option>
                </select>
              </td>            
              <td><input name="otra_trep1" type="text" id="otra_trep1" title="Ingrese otra prueba" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $modificar1->otra_trep1;?>" size="30" readonly="readonly" /></td>            
              <td><?php echo form_error('resultados_trep1', '<div class="warning">', '</div>'); ?>
                <select name="resultados_trep1" id="resultados_trep1" disabled="disabled" title="Elija el resultado correspondiente">
                  <option value="">Selecione...</option>
                  <option value="1" <?php if($modificar1->resultados_trep1 == "1"){?> selected="selected" <?php }?>>Reactivo</option>
                  <option value="2" <?php if($modificar1->resultados_trep1 == "2"){?> selected="selected" <?php }?>>No reactivo</option>
                  <option value="3" <?php if($modificar1->resultados_trep1 == "3"){?> selected="selected" <?php }?>>Desconocido</option>
                </select>
              </td>            
              <td><?php echo form_error('momento_trep1', '<div class="warning">', '</div>'); ?> 
                <select name="momento_trep1" id="momento_trep1" disabled="disabled" title="Elija el momento correspondiente">
                  <option value="">Selecione...</option>
                  <option value="1" <?php if($modificar1->momento_trep1 == "1"){?> selected="selected" <?php }?>>Gestaci&oacute;n</option>
                  <option value="2" <?php if($modificar1->momento_trep1 == "2"){?> selected="selected" <?php }?>>Parto</option>
                  <option value="3" <?php if($modificar1->momento_trep1 == "3"){?> selected="selected" <?php }?>>Puerperio</option>
                </select>
              </td>            
            </tr>
            <tr>
              <td><?php echo form_error('fecha_trep2', '<div class="warning">', '</div>'); ?>
              <input name="fecha_trep2" type="text" id="fecha_trep2" title="Ingrese la fecha correspondiente" value="<?php echo $this->fechas_model->modificarFechas($modificar1->fecha_trep2);?>" size="15" readonly="readonly" placeholder="Ej. dd-mm-YYYY" /></td>
              <td><?php echo form_error('tipo_trep2', '<div class="warning">', '</div>'); ?>
                <select name="tipo_trep2" id="tipo_trep2" disabled="disabled" title="Elija el tipo de prueba correspondiente">
                  <option value="">Selecione...</option>
                  <option value="1" <?php if($modificar1->tipo_trep2 == "1"){?> selected="selected" <?php }?>>Prueba r&aacute;pida/ Prueba dual</option>
                  <option value="2" <?php if($modificar1->tipo_trep2 == "2"){?> selected="selected" <?php }?>>R&aacute;pida</option>
                </select>
              </td>            
              <td><input name="otra_trep2" type="text" id="otra_trep2" title="Ingrese otra prueba" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $modificar1->otra_trep2;?>" size="30" readonly="readonly" /></td>            
              <td><?php echo form_error('resultados_trep2', '<div class="warning">', '</div>'); ?>
                <select name="resultados_trep2" id="resultados_trep2" disabled="disabled" title="Elija el resultado correspondiente">
                  <option value="">Selecione...</option>
                  <option value="1" <?php if($modificar1->resultados_trep2 == "1"){?> selected="selected" <?php }?>>Reactivo</option>
                  <option value="2" <?php if($modificar1->resultados_trep2 == "2"){?> selected="selected" <?php }?>>No reactivo</option>
                  <option value="3" <?php if($modificar1->resultados_trep2 == "3"){?> selected="selected" <?php }?>>Desconocido</option>
                </select>
              </td>            
              <td><?php echo form_error('momento_trep2', '<div class="warning">', '</div>'); ?>
                <select name="momento_trep2" id="momento_trep2" disabled="disabled" title="Elija el momento correspondiente">
                  <option value="">Selecione...</option>
                  <option value="1" <?php if($modificar1->momento_trep2 == "1"){?> selected="selected" <?php }?>>Gestaci&oacute;n</option>
                  <option value="2" <?php if($modificar1->momento_trep2 == "2"){?> selected="selected" <?php }?>>Parto</option>
                  <option value="3" <?php if($modificar1->momento_trep2 == "3"){?> selected="selected" <?php }?>>Puerperio</option>
                </select>
              </td>            
            </tr>
            <tr>
              <td colspan="2"><strong>Durante el embarazo ¿La madre fue apropiadamente tratada?</strong></td>
              <td><strong>Contacto(s) sexual(es) tratado</strong></td>
              <td><strong>Estad&iacute;o de la s&iacute;filis</strong></td>
              <td></td>
            </tr>
            <tr>
              <td>
                <select name="tratamiento" id="tratamiento" disabled="disabled" title="Elija si tuvo tratamiento apropiado">
                  <option value="">Selecione...</option>
                  <option value="1" <?php if($modificar1->tratamiento == "1"){?> selected="selected" <?php }?>>Si</option>
                  <option value="2" <?php if($modificar1->tratamiento == "2"){?> selected="selected" <?php }?>>No</option>
                  <option value="3" <?php if($modificar1->tratamiento == "3"){?> selected="selected" <?php }?>>Desconocido</option>
                </select>
              </td>            
              <td>
              <?php
			  if($modificar1->motivo_no1 == "1"){
				  ?>
	              <input name="motivo_no1" type="checkbox" id="motivo_no1" checked="checked" disabled="disabled" title="Elija motivo" />&nbsp;&nbsp;<strong>Tratamiento sin penicilina</strong><br />
				  <?php                  
			  }else{
				  ?>
	              <input name="motivo_no1" type="checkbox" id="motivo_no1" disabled="disabled" title="Elija motivo" />&nbsp;&nbsp;<strong>Tratamiento sin penicilina</strong><br />
				  <?php                  
			  }
			  ?>
              <?php
			  if($modificar1->motivo_no2 == "1"){
				  ?>
	              <input name="motivo_no2" type="checkbox" id="motivo_no2" checked="checked" disabled="disabled" title="Elija motivo" />&nbsp;&nbsp;<strong>Tratamiento durante los primeros 30 d&iacute;as previos</strong><br />
				  <?php                  
			  }else{
				  ?>
	              <input name="motivo_no2" type="checkbox" id="motivo_no2" disabled="disabled" title="Elija motivo" />&nbsp;&nbsp;<strong>Tratamiento durante los primeros 30 d&iacute;as previos</strong><br />
				  <?php                  
			  }
			  ?>
              <?php
			  if($modificar1->motivo_no3 == "1"){
				  ?>
                  <input name="motivo_no3" type="checkbox" id="motivo_no3" checked="checked" disabled="disabled" title="Elija motivo" />&nbsp;&nbsp;<strong>No inicio tratamiento durante la gestaci&oacute;n</strong>
				  <?php                  
			  }else{
				  ?>
                  <input name="motivo_no3" type="checkbox" id="motivo_no3" disabled="disabled" title="Elija motivo" />&nbsp;&nbsp;<strong>No inicio tratamiento durante la gestaci&oacute;n</strong>
				  <?php                  
			  }
			  ?>
              </td>
              <td>
                <select name="contacto" id="contacto" disabled="disabled" title="Elija el resultado correspondiente">
                  <option value="">Selecione...</option>
                  <option value="1" <?php if($modificar1->contacto == "1"){?> selected="selected" <?php }?>>Si</option>
                  <option value="2" <?php if($modificar1->contacto == "2"){?> selected="selected" <?php }?>>No</option>
                  <option value="3" <?php if($modificar1->contacto == "3"){?> selected="selected" <?php }?>>Desconocido</option>
                </select>
              </td>            
              <td>
                <select name="estadio" id="estadio" disabled="disabled" title="Elija el momento correspondiente">
                  <option value="">Selecione...</option>
                  <option value="1" <?php if($modificar1->estadio == "1"){?> selected="selected" <?php }?>>S&iacute;filis primaria</option>
                  <option value="2" <?php if($modificar1->estadio == "2"){?> selected="selected" <?php }?>>S&iacute;filis secundaria</option>
                  <option value="3" <?php if($modificar1->estadio == "3"){?> selected="selected" <?php }?>>S&iacute;filis latente</option>
                  <option value="4" <?php if($modificar1->estadio == "4"){?> selected="selected" <?php }?>>Desconocido</option>
                </select>
              </td>            
            </tr>
			<tr>
			  <td colspan="5" bgcolor="#CCCCCC"><hr/></td>
	  	    </tr>
       	</table>
   		<table width="100%" align="center">
			<tr>
			  <td colspan="6" bgcolor="#000" style="color:#FFF;"><strong>&nbsp;III. SIFILIS CONGENITA:</strong></td>
		  	</tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><hr/></td>
	  	   	</tr>
            <tr>
              <td><strong>Fecha del parto/culminaci&oacute;n de embarazo</strong></td>
              <td colspan="4"><strong>Lugar del parto/culminaci&oacute;n de embarazo (DIRESA / RED / MICRORED / ESTABLECIMIENTO)</strong></td>
              <td><strong>Estado vital</strong></td>
            </tr>
            <tr>
              <td><?php echo form_error('fecha_par', '<div class="warning">', '</div>'); ?>
              <input name="fecha_par" type="text" id="fecha_par" title="Ingrese la fecha correspondiente" value="<?php echo $this->fechas_model->modificarFechas($modificar2->fecha_par);?>" size="15" readonly="readonly" placeholder="Ej. dd-mm-YYYY" /></td>
              <td><?php echo form_error('diresa', '<div class="warning">', '</div>'); ?>
                <?php
                $subreg[''] = "Seleccione...";
                foreach($this->mantenimiento_model->buscarDiresas() as $diresa){
                    $subreg[$diresa->codigo] = $diresa->nombre;
                }
                
                echo form_dropdown('diresa', $subreg, $establec_cong->subregion, 'id="diresa" disabled="disabled" style="width: 200px;"');
                ?>
              </td>
              <td><?php echo form_error('redes', '<div class="warning">', '</div>'); ?>
                <?php
                $red[''] = "Seleccione...";
                echo form_dropdown('redes', $red, $establec_cong->red, 'id="redes" disabled="disabled" style="width: 200px;"');
                ?>
              </td>
              <td><?php echo form_error('microred', '<div class="warning">', '</div>'); ?>
                <?php
                $mred[''] = "Seleccione...";
                echo form_dropdown('microred', $mred, $establec_cong->microred, 'id="microred" disabled="disabled" style="width: 200px;"');
                ?>
              </td>
              <td><?php echo form_error('establec', '<div class="warning">', '</div>'); ?>
                <?php
                $est[''] = "Seleccione...";
                echo form_dropdown('establec', $est, $modificar2->establec_par, 'id="establec" disabled="disabled" style="width: 200px;"');
                ?>
              </td>
              <td><?php echo form_error('estado_vital', '<div class="warning">', '</div>'); ?>
                <select name="estado_vital" id="estado_vital" disabled="disabled" title="Elija el momento correspondiente">
                  <option value="">Selecione...</option>
                  <option value="1" <?php if($modificar2->estado_vital == "1"){?> selected="selected" <?php }?>>Vivo</option>
                  <option value="2" <?php if($modificar2->estado_vital == "2"){?> selected="selected" <?php }?>>Nació vivo, luego falleci&oacute;</option>
                  <option value="3" <?php if($modificar2->estado_vital == "3"){?> selected="selected" <?php }?>>Mortinato</option>
                  <option value="4" <?php if($modificar2->estado_vital == "4"){?> selected="selected" <?php }?>>Aborto</option>
                </select>
              </td>            
            </tr>
            <tr>
              <td>
              <?php
			  if($modificar2->desconocido_par == "1"){
				  ?>
	              <input name="desconocido_par" type="checkbox" id="desconocido_par" checked="checked" disabled="disabled" title="Desconoce la fecha de parto/culminaci&oacute;n de embarazo" />&nbsp;&nbsp;<strong>Desconocido</strong></td>
				  <?php                  
			  }else{
				  ?>
	              <input name="desconocido_par" type="checkbox" id="desconocido_par" disabled="disabled" title="Desconoce la fecha de parto/culminaci&oacute;n de embarazo" />&nbsp;&nbsp;<strong>Desconocido</strong></td>
				  <?php                  
			  }
			  ?>
              <td colspan="4"><strong>Nivel de establecimiento: </strong><input name="nivel_estab" type="text" id="nivel_estab" value="<?php echo $this->input->post("nivel_estab", true);?>" size="30" readonly="readonly" /></td>
            </tr>
            <tr>
              <td></td>
              <td>
              <?php
			  if($modificar2->domicilio_par == "1"){
				  ?>
	              <input name="domicilio" type="checkbox" id="domicilio" checked="checked" disabled="disabled" title="Lugar de parto/culminaci&oacute;n de embarazo" />&nbsp;&nbsp;<strong>Domicilio</strong></td>
				  <?php                  
			  }else{
				  ?>
	              <input name="domicilio" type="checkbox" id="domicilio" disabled="disabled" title="Lugar de parto/culminaci&oacute;n de embarazo" />&nbsp;&nbsp;<strong>Domicilio</strong></td>
				  <?php                  
			  }
			  ?>
            </tr>
            <tr>
              <td><strong>Fecha de fallecimiento: </strong><input name="fecha_fac" type="text" id="fecha_fac" title="Ingrese la fecha correspondiente" value="<?php echo $this->fechas_model->modificarFechas($modificar2->fecha_fac);?>" size="15" readonly="readonly" placeholder="Ej. dd-mm-YYYY" /></td>
              <td colspan="2"><strong>Peso al nacimiento: </strong><input name="peso_nac" type="text" id="peso_nac" title="Ingrese el peso al nacer" value="<?php echo $modificar2->peso_nac;?>" size="5" readonly="readonly" /><strong> gramos</strong></td>            
              <td colspan="2"><strong>Edad gestacional estimada: </strong><input name="edad_ges" type="text" id="edad_ges" title="Ingrese la edad gestacional" value="<?php echo $modificar2->edad_ges;?>" size="5" readonly="readonly" /><strong> semanas</strong></td>            
            </tr>
            <tr>
              <td>
              <?php
			  if($modificar2->desconocido_fac == "1"){
				  ?>
	              <input name="desconocido_fac" type="checkbox" id="desconocido_fac" checked="checked" disabled="disabled" title="Desconoce la fecha de fallecimiento" />&nbsp;&nbsp;<strong>Desconocido</strong></td>
				  <?php                  
			  }else{
				  ?>
	              <input name="desconocido_fac" type="checkbox" id="desconocido_fac" disabled="disabled" title="Desconoce la fecha de fallecimiento" />&nbsp;&nbsp;<strong>Desconocido</strong></td>
				  <?php                  
			  }
			  ?>
              <td colspan="2">
              <?php
			  if($modificar2->desconocido_nac == "1"){
				  ?>
	              <input name="desconocido_nac" type="checkbox" id="desconocido_fac" checked="checked" disabled="disabled" title="Desconoce el peso de nacimiento" />&nbsp;&nbsp;<strong>Desconocido</strong></td>
				  <?php                  
			  }else{
				  ?>
	              <input name="desconocido_nac" type="checkbox" id="desconocido_fac" disabled="disabled" title="Desconoce el peso de nacimiento" />&nbsp;&nbsp;<strong>Desconocido</strong></td>
				  <?php                  
			  }
			  ?>
              <td colspan="2">
              <?php
			  if($modificar2->desconocido_edad == "1"){
				  ?>
	              <input name="desconocido_ges" type="checkbox" id="desconocido_ges" checked="checked" disabled="disabled" title="Desconoce la edad gestacional" />&nbsp;&nbsp;<strong>Desconocido</strong></td>
				  <?php                  
			  }else{
				  ?>
	              <input name="desconocido_ges" type="checkbox" id="desconocido_ges" disabled="disabled" title="Desconoce la edad gestacional" />&nbsp;&nbsp;<strong>Desconocido</strong></td>
				  <?php                  
			  }
			  ?>
            </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><hr/></td>
	  	    </tr>
			<tr>
			  <td colspan="6" align="justify"><strong>Indique cual o cuales criterios cumple el producto de la gestaci&oacute;n para ser considerado caso de s&iacute;filis cong&eacute;nita:</strong>&nbsp;(Marque todas las que apliquen)</td>
		  	</tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><hr/></td>
	  	    </tr>
            <tr>
              <td colspan="6">
              <?php
			  if($modificar2->criterio1 == "1"){
				  ?>
	              <input name="criterio1" type="checkbox" id="criterio1" title="Elija de ser el caso" checked="checked" disabled="disabled" />&nbsp;&nbsp;<strong>Madre con s&iacute;filis, que no recibi&oacute; tratamiento o fue tratada inadecuadamente.</strong></td>
				  <?php                  
			  }else{
				  ?>
	              <input name="criterio1" type="checkbox" id="criterio1" disabled="disabled" title="Elija de ser el caso" />&nbsp;&nbsp;<strong>Madre con s&iacute;filis, que no recibi&oacute; tratamiento o fue tratada inadecuadamente.</strong></td>
				  <?php                  
			  }
			  ?>
            </tr>
            <tr>
              <td colspan="6">
              <?php
			  if($modificar2->criterio2 == "1"){
				  ?>
	              <input name="criterio2" type="checkbox" id="criterio2" checked="checked" disabled="disabled" title="Elija de ser el caso" />&nbsp;&nbsp;<strong>Resultado de t&iacute;tulos de an&aacute;lisis no trepon&eacute;micos cuatro veces mayor que los t&iacute;tulos de la madre:</strong></td>
				  <?php                  
			  }else{
				  ?>
	              <input name="criterio2" type="checkbox" id="criterio2" disabled="disabled" title="Elija de ser el caso" />&nbsp;&nbsp;<strong>Resultado de t&iacute;tulos de an&aacute;lisis no trepon&eacute;micos cuatro veces mayor que los t&iacute;tulos de la madre:</strong></td>
				  <?php                  
			  }
			  ?>
            </tr>
            <tr>
              <td><strong>Fecha de los test: </strong>&nbsp;&nbsp;<input name="fecha_test" type="text" id="fecha_test" title="Ingrese la fecha correspondiente" value="<?php echo $this->fechas_model->modificarFechas($modificar2->fecha_test);?>" size="12" readonly="readonly" placeholder="Ej. dd-mm-YYYY" /></td>
              <td>
              <?php
			  if($modificar2->desconocido == "1"){
				  ?>
	              <input name="desconocido" type="checkbox" id="desconocido" checked="checked" disabled="disabled" title="Elija de ser el caso" />&nbsp;&nbsp;<strong>Desconocido</strong></td>
				  <?php                  
			  }else{
				  ?>
	              <input name="desconocido" type="checkbox" id="desconocido" disabled="disabled" title="Elija de ser el caso" />&nbsp;&nbsp;<strong>Desconocido</strong></td>
				  <?php                  
			  }
			  ?>
              <td colspan="2"><strong>T&iacute;tulo de la madre:</strong>&nbsp;&nbsp;<input name="titulo_madre" type="text" id="titulo_madre" title="Ingrese los t&iacute;tulos de la madre" value="<?php echo $modificar2->titulo_madre;?>" size="20" readonly="readonly" /></td>
              <td colspan="2"><strong>T&iacute;tulo del ni&ntilde;o:</strong>&nbsp;&nbsp;<input name="titulo_hijo" type="text" id="titulo_hijo" title="Ingrese los t&iacute;tulos del ni&ntilde;o" value="<?php echo $modificar2->titulo_hijo;?>" size="20" readonly="readonly" /></td>
            </tr>
            <tr>
              <td colspan="6">
              <?php
			  if($modificar2->criterio3 == "1"){
				  ?>
	              <input name="criterio3" type="checkbox" id="criterio3" checked="checked" disabled="disabled" title="Elija de ser el caso" />&nbsp;&nbsp;<strong>Ni&ntilde;o con manifestaciones cl&iacute;nicas sugestivas de s&iacute;filis cong&eacute;nita (al examen f&iacute;sico o evidencia radiogr&aacute;fica)</strong></td>
				  <?php                  
			  }else{
				  ?>
	              <input name="criterio3" type="checkbox" id="criterio3" disabled="disabled" title="Elija de ser el caso" />&nbsp;&nbsp;<strong>Ni&ntilde;o con manifestaciones cl&iacute;nicas sugestivas de s&iacute;filis cong&eacute;nita (al examen f&iacute;sico o evidencia radiogr&aacute;fica)</strong></td>
				  <?php                  
			  }
			  ?>
            </tr>
            <tr>
              <td colspan="6">
              <?php
			  if($modificar2->criterio4 == "1"){
				  ?>
	              <input name="criterio4" type="checkbox" id="criterio4" checked="checked" disabled="disabled" title="Elija de ser el caso" />&nbsp;&nbsp;<strong>Demostraci&oacute;n de treponema pallidum en lesiones, placenta, cord&oacute;n umbilical o material de autopsia</strong></td>
				  <?php                  
			  }else{
				  ?>
	              <input name="criterio4" type="checkbox" id="criterio4" disabled="disabled" title="Elija de ser el caso" />&nbsp;&nbsp;<strong>Demostraci&oacute;n de treponema pallidum en lesiones, placenta, cord&oacute;n umbilical o material de autopsia</strong></td>
				  <?php                  
			  }
			  ?>
            </tr>
            <tr>
              <td colspan="6">
              <?php
			  if($modificar2->criterio5 == "1"){
				  ?>
	              <input name="criterio5" type="checkbox" id="criterio5" checked="checked" disabled="disabled" title="Elija de ser el caso" />&nbsp;&nbsp;<strong>Ni&ntilde;o mayor de dos a&ntilde;os de edad, con signos cl&iacute;nicos de s&iacute;filis secundaria en el que se ha descartado el antecedente de abuso sexual o contacto sexual.</strong></td>
				  <?php                  
			  }else{
				  ?>
	              <input name="criterio5" type="checkbox" id="criterio5" disabled="disabled" title="Elija de ser el caso" />&nbsp;&nbsp;<strong>Ni&ntilde;o mayor de dos a&ntilde;os de edad, con signos cl&iacute;nicos de s&iacute;filis secundaria en el que se ha descartado el antecedente de abuso sexual o contacto sexual.</strong></td>
				  <?php                  
			  }
			  ?>
            </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><hr/></td>
	  	    </tr>
            <tr>
              <td colspan="3"><strong>¿Fue el ni&ntilde;o tratado?</strong></td>
              <td colspan="3"><strong>Clasificaci&oacute;n final del ni&ntilde;o, mortinato o aborto</strong></td>
            </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><hr/></td>
	  	    </tr>
            <tr>
              <td colspan="3">
                <select name="tratado" id="tratado" disabled="disabled" title="Elija el momento correspondiente">
                  <option value="">Selecione...</option>
                  <option value="1" <?php if($modificar2->tratado == "1"){?> selected="selected" <?php }?>>Si, con penicilina acuosa o procainica por >= 10 d&iacute;as</option>
                  <option value="2" <?php if($modificar2->tratado == "2"){?> selected="selected" <?php }?>>Si, con tratamiento penicilina benzat&iacute;nica x 1 dosis</option>
                  <option value="3" <?php if($modificar2->tratado == "3"){?> selected="selected" <?php }?>>Si, con otro tratamiento</option>
                  <option value="4" <?php if($modificar2->tratado == "4"){?> selected="selected" <?php }?>>No recibi&oacute; tratamiento</option>
                  <option value="5" <?php if($modificar2->tratado == "5"){?> selected="selected" <?php }?>>Desconocido</option>
                </select>
              </td>            
              <td colspan="3">
                <select name="clasificacion" id="clasificacion" disabled="disabled" title="Elija el momento correspondiente">
                  <option value="">Selecione...</option>
                  <option value="1" <?php if($modificar2->clasificacion == "1"){?> selected="selected" <?php }?>>S&iacute;filis cong&eacute;nita</option>
                  <option value="2" <?php if($modificar2->clasificacion == "2"){?> selected="selected" <?php }?>>Ni&ntilde;o expuesto a s&iacute;filis, no infectado</option>
                </select>
              </td>            
            </tr>
			<tr>
			  <td colspan="6" bgcolor="#CCCCCC"><hr/></td>
	  	    </tr>
       </table>
       <table width="100%" align="center">
        	<tr>
            <td><?php echo form_error('notificador', '<div class="warning">', '</div>'); ?>
            <strong>Nombres y apellidos del notificador:</strong>&nbsp;&nbsp;<input name="notificador" type="text" id="notificador" title="apellidos y nombres del responsable de la notificaci&oacute;n" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $modificar->notificador;?>" size="50" readonly="readonly" /></td>
            </tr>
			<tr>
			  <td><hr/></td>
	  	    </tr>
        </table>
    </div>
</div>
<?php
    echo form_close();
?>