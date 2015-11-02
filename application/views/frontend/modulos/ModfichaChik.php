<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
</head>
<body>
<?php
    if($this->session->flashdata('ControllerMessage') != ''){
        ?>
        <div class="error"><?php echo $this->session->flashdata('ControllerMessage'); ?></div>
        <?php
    }
    $atributos = array('id'=>'form1', 'name'=>'form1');
    echo form_open(null, $atributos);

    $datos = $this->fichas_model->mostrarChikungunya($modificar->notificacion);

    $estab = $datos->e_salud;
    $dir = $datos->sub_reg_nt;
    $rd = $datos->red;
    $mrd = $datos->microred;
    $notificacion = $datos->registroId;

    //combo Departamentos
    
    $depar = $this->mantenimiento_model->buscarDepartamentos();

    $dep14_1[''] = 'Seleccione ...';
    foreach ($depar as $dato){
        $dep14_1[$dato->ubigeo] = $dato->nombre;
    }
    
    $prov14_1 = array(''=>'Seleccione...');
    $dist14_1 = array(''=>'Seleccione...');
    $localidad14_1 = array(''=>'Seleccione...');
    
    //combo Provincias
    
    $provi = $this->mantenimiento_model->buscarProvincias(substr($datos->ubigeo,0,2));

    //$provincia[''] = 'Seleccione ...';
    foreach ($provi as $dato){
        $prov14_1[$dato->ubigeo] = $dato->nombre;
    }
    
    //combo Distrito
    
    $distri = $this->mantenimiento_model->buscarDistritos(substr($datos->ubigeo,0,4));

    //$distrito[''] = 'Seleccione ...';
    foreach ($distri as $dato){
        $dist14_1[$dato->ubigeo] = $dato->nombre;
    }

    //combo localidad
    
    $loca = $this->mantenimiento_model->buscarLocalidades($datos->ubigeo);

    //$distrito[''] = 'Seleccione ...';
    foreach ($loca as $dato){
        $loc14_1[$dato->codloc] = $dato->nombre;
    }
?>
<div class="panel panel-primary">
    <div class="panel-heading">
      <h3 class="panel-title"><center>Ficha de investigaci&oacute;n cl&iacute;nico epidemiol&oacute;gica de la Fiebre de Chikungunya</center></h3>
    </div>

    <div class="panel-body">
        <div role="tabpanel">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
              <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab"><i class="fa fa-user fa-lg"></i>&nbsp;&nbsp;Datos Generales / Personales</a></li>
              <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab"><i class="fa fa-user fa-lg"></i>&nbsp;&nbsp;Datos Epidemiol&oacute;gicos / Cl&iacute;nicos</a></li>
              <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab"><i class="fa fa-user-md fa-lg"></i>&nbsp;&nbsp;Examenes de Laboratorio / Evoluci&oacute;n</a></li>
              <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab"><i class="fa fa-server fa-lg"></i>&nbsp;&nbsp;Clasificaci&oacute;n Final / Procedencia / Observaciones</a></li>
            </ul>
    
            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel"  class="tab-pane fade in active" id="home">
                    <div class="row list-group-item">
                        <div class="col-xs-2">
							<strong>Semana</strong>
                        </div>
                        <div class="col-xs-2">
			  				<strong>Investigaci&oacute;n</strong>
                        </div>
                    </div>
                    <div class="row list-group-item">
                        <div class="col-xs-2">
                            <div class="form-group">
								<input name="semana" type="text" id="semana" class="form-control" value="<?php echo $datos->semana;?>" readonly />
                            </div>
                        </div>
                        <div class="col-xs-2">
	                        <div class="form-group">
    	                        <div class="input-group">
	                                <input type='text' class="form-control datepicker" name="fecha_inv" id="fecha_inv" value="<?php if($datos->fecha_inv != '0000-00-00'){ echo $this->fechas_model->modificarFechas($datos->fecha_inv); }else{ echo ''; }?>" onKeyPress="return acceptNum(event)" placeholder = 'd-m-A' readonly />
	                                <div class="input-group-addon"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></div>
	                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="row list-group-item">
                        <div class="col-xs-2">
							<strong>Diresa</strong>
                        </div>
                        <div class="col-xs-2">
							<strong>Redes</strong>
                        </div>
                        <div class="col-xs-3">
							<strong>Microred</strong>
                        </div>
                        <div class="col-xs-3">
							<strong>Establecimiento</strong>
                        </div>
                        <div class="col-xs-2">
							<strong>Categor&iacute;a</strong>
                        </div>
                    </div>
                    <div class="row list-group-item">
                        <div class="col-xs-2">
                            <div class="form-group">
								<input name="subregion" type="text" id="subregion" class="form-control" value="<?php echo $datos->diresa;?>" readonly = "readonly" />
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <div class="form-group">
								<input name="red" type="text" id="red" class="form-control" value="<?php echo $datos->redes;?>" readonly = "readonly" />
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="form-group">
								<input name="mred" type="text" id="mred" class="form-control" value="<?php echo $datos->microredes;?>" readonly = "readonly" />
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="form-group">
								<input name="establecimiento" type="text" id="establecimiento" class="form-control" value="<?php echo $datos->raz_soc;?>" readonly = "readonly" />
                            </div>
                    	</div>
                        <div class="col-xs-2">
						   <?php
                           $categoria = $this->fichas_model->buscarEstCat($datos->e_salud);
                           
                           foreach($categoria as $dato){
                               $cate = $dato->categoria;
                           }
                           ?>
                            <div class="form-group">
	                           <input name="categoria" type="text" id="categoria" class="form-control" value="<?php echo $cate;?>" size="15" readonly = "readonly" />
                            </div>
                       </div>
                   </div>
                    <div class="row list-group-item">
                        <div class="col-xs-2">
							<strong>II. Datos del paciente:</strong>
                        </div>
                    </div>
                    <div class="row list-group-item">
                        <div class="col-xs-2">
							<strong>Historia</strong>
                        </div>
                        <div class="col-xs-2">
							<strong>Apellido Paterno</strong>
                        </div>
                        <div class="col-xs-2">
							<strong>Apellido Materno</strong>
                        </div>
                        <div class="col-xs-2">
							<strong>Nombres</strong>
                        </div>
                        <div class="col-xs-2">
							<strong>DNI</strong>
                        </div>
                        <div class="col-xs-2">
							<strong>Fecha de Nacimiento</strong>
                        </div>
                    </div>
                    <div class="row list-group-item">
                        <div class="col-xs-2">
                            <div class="form-group">
							  	<input name="historia" type="text" id="historia" class="form-control" value="<?php echo $datos->hc;?>" readonly = "readonly" />
                            </div>
                        </div>
		                <div class="col-xs-2">
                            <div class="form-group">
				           		<input name="paterno" type="text" id="paterno" class="form-control" value="<?php echo $datos->apepat;?>" readonly = "readonly" />
                            </div>
						</div>                      
		                <div class="col-xs-2">
                            <div class="form-group">
								<input name="materno" type="text" id="materno" class="form-control" value="<?php echo $datos->apemat;?>" readonly = "readonly" />
                            </div>
                        </div>
		                <div class="col-xs-2">
                            <div class="form-group">
	           	  				<input name="nombres" type="text" id="nombres" class="form-control" value="<?php echo $datos->nombres;?>" readonly = "readonly" />
                            </div>
                        </div>
		                <div class="col-xs-2">
                            <div class="form-group">
					  			<input name="dni" type="text" id="dni" class="form-control" value="<?php echo $datos->dni;?>" readonly = "readonly" />
                            </div>
                        </div>
		                <div class="col-xs-2">
                            <div class="form-group">
                                <div class="input-group">
                                    <input name="fecha_nac" type="text" id="fecha_nac" class="form-control" value="<?php if($modificar->fecha_nac != '0000-00-00'){ echo $this->fechas_model->modificarFechas($modificar->fecha_nac); }else{ echo ''; }?>"  title="Ingrese la fecha de nacimiento del paciente" placeholder="d-m-A"/>
                                    <div class="input-group-addon"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row list-group-item">
                        <div class="col-xs-2">
							<strong>Edad</strong>
                        </div>
                        <div class="col-xs-2">
							<strong>Tipo de Edad</strong>
                        </div>
                        <div class="col-xs-2">
							<strong>Sexo</strong>
                        </div>
                    </div>
                    <div class="row list-group-item">
                        <div class="col-xs-2">
                            <div class="form-group">
	           	   				<input name="edad" type="text" id="edad" class="form-control" value="<?php echo $datos->edad;?>" readonly = "readonly" />
                            </div>
                        </div>
                        <div class="col-xs-2">
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
                             <div class="form-group">
	                             <input name="tipo_edad" type="text" id="tipo_edad" class="form-control" value="<?php echo $tedad;?>" readonly = "readonly" />
                             </div>
                         </div>
                        <div class="col-xs-2">
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
							<div class="form-group">
                            	<input name="sexo" type="text" id="sexo" class="form-control" value="<?php echo $sexo;?>" readonly = "readonly" />
                            </div>
                         </div>
                     </div>
                    <div class="row list-group-item">
                        <div class="col-xs-2">
							<strong>Pa&iacute;s</strong>
                        </div>
                        <div class="col-xs-2">
							<strong>Departamento</strong>
                        </div>
                        <div class="col-xs-2">
							<strong>Provincia</strong>
                        </div>
                        <div class="col-xs-2">
							<strong>Distrito</strong>
                        </div>
                        <div class="col-xs-2">
							<strong>Localidad</strong>
                        </div>
                        <div class="col-xs-2">
							<strong>Direcci&oacute;n</strong>
                        </div>
                    </div>
                    <div class="row list-group-item">
                        <div class="col-xs-2">
		          			<?php
							  $paises[''] = "Seleccione...";
							  foreach($this->mantenimiento_model->buscarPaises() as $dato){
								  $paises[$dato->codigo] = $dato->nombre;
							  }
							  echo form_dropdown('pais', $paises, $modificar->pais, 'id="pais" style="width: 200px;" class="form-control"');
							?>
                        </div>
                        <div class="col-xs-2">
							<?php
                            $dep[''] = "Seleccione...";
                            foreach($this->mantenimiento_model->buscarDepartamentos() as $dato){
                                $dep[$dato->ubigeo] = $dato->nombre;
                            }
                            echo form_dropdown('departamento', $dep, substr($modificar->residencia,0,2), 'id="departamento" style="width: 200px;" class="form-control"');
                            ?>
                        </div>
                        <div class="col-xs-2">
							<?php
                            $prov[''] = "Seleccione...";
                            echo form_dropdown('provincia', $prov, substr($modificar->residencia,0,4), 'id="provincia" style="width: 200px;" class="form-control"');
                            ?>
                        </div>
                        <div class="col-xs-2">
                            <div class="form-group">
                                <div class="input-group">
        							<?php
                                    $dist[''] = "Seleccione...";
                                    echo form_dropdown('distrito', $dist, $modificar->residencia, 'id="distrito" style="width: 200px;" class="form-control"');
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-2">
							<div class="form-group">
				                <input name="localidad" type="text" id="localidad" class="form-control" value="<?php echo $modificar->localidad;?>" title="Ingrese la localidad donde habita el paciente" onKeyUp="javascript:this.value=this.value.toUpperCase();" />
                            </div>
                        </div>
                        <div class="col-xs-2">
							<div class="form-group">
				           	  	<input name="direccion" type="text" id="direccion" class="form-control" value="<?php echo $datos->direccion;?>" size="25" readonly = "readonly" />
                            </div>
                        </div>
                    </div>
                    <div class="row list-group-item">
                        <div class="col-xs-2">
							<strong>Ocupaci&oacute;n</strong>
                        </div>
                        <div class="col-xs-2">
							<strong>Tel&eacute;fono</strong>
                        </div>
                    </div>
                    <div class="row list-group-item">
                        <div class="col-xs-2">
							<div class="form-group">
				  				<input name="ocupacion" type="text" id="ocupacion" class="form-control" value="<?php echo $modificar->ocupacion;?>" title="Ingrese la ocupacion del paciente" onKeyUp="javascript:this.value=this.value.toUpperCase();" size="30" />
                            </div>
                        </div>
                        <div class="col-xs-2">
							<div class="form-group">
				  				<input name="telefono" type="text" id="telefono" class="form-control" value="<?php echo $modificar->telefono;?>" title="Ingrese el tel&eacute;fono del paciente o familiar" onKeyUp="javascript:this.value=this.value.toUpperCase();" size="30" />
                            </div>
                        </div>
                    </div>    
                </div>
                <div role="tabpanel"  class="tab-pane fade" id="profile">
                    <div class="row list-group-item">
                        <div class="col-xs-12">
                            <strong>III. Datos Epidemiol&oacute;gicos: ¿En qu&eacute; lugar estuvo en los &uacute;ltimos 14 d&iacute;as? (Establecer el lugar probable de infecci&oacute;n)</strong>
                        </div>
                    </div>
                    <div class="row list-group-item">
                        <div class="col-xs-2">
                            <strong>Pa&iacute;s</strong>
                        </div>
                        <div class="col-xs-2">
                            <strong>Departamento</strong>
                        </div>
                        <div class="col-xs-2">
                            <strong>Provincia</strong>
                        </div>
                        <div class="col-xs-2">
                            <strong>Distrito</strong>
                        </div>
                        <div class="col-xs-2">
                            <strong>Localidad</strong>
                        </div>
                        <div class="col-xs-2">
                            <strong>Direcci&oacute;n</strong>
                        </div>
                    </div>
                    <div class="row list-group-item">
                        <div class="col-xs-2">
                            <?php
                            $paises[''] = "Seleccione...";
                            foreach($this->mantenimiento_model->buscarPaises() as $dato){
                              $paises[$dato->codigo] = $dato->nombre;
                            }
                            echo form_dropdown('pais14_1', $paises, $modificar->pais14_1, 'id="pais14_1" class="form-control" readonly="readonly"');
                            ?>
                        </div>
                        <div class="col-xs-2">
                            <?php
                            $dep[''] = "Seleccione...";
                            foreach($this->mantenimiento_model->buscarDepartamentos() as $dato){
                              $dep[$dato->ubigeo] = $dato->nombre;
                            }
                            echo form_dropdown('departamento14_1', $dep14_1, substr($datos->ubigeo,0,2), 'id="departamento14_1" class="form-control" readonly="readonly"');
                            ?>
                        </div>
                        <div class="col-xs-2">
                            <?php
                            $prov[''] = "Seleccione...";
                            echo form_dropdown('provincia14_1', $prov14_1, substr($datos->ubigeo,0,4), 'id="provincia14_1" class="form-control" readonly="readonly"');
                            ?>
                        </div>
                        <div class="col-xs-2">
                            <?php
                            $dist[''] = "Seleccione...";
                            echo form_dropdown('distrito14_1', $dist14_1, $datos->ubigeo, 'id="distrito14_1" class="form-control" readonly="readonly"');
                            ?>
                        </div>
                        <div class="col-xs-2">
                            <?php
                            $localidad14_1[''] = "Seleccione...";
                            echo form_dropdown('localidad14_1', $loc14_1, $datos->localcod, 'id="localidad14_1" class="form-control" readonly="readonly"');
                            ?>
                        </div>
                        <div class="col-xs-2">
                            <input name="direccion14_1" type="text" class="form-control" id="direccion14_1" value="<?php echo $modificar->direccion14_1;?>" title="Ingrese la direcci&oacute;n donde estuvo el paciente" onKeyUp="javascript:this.value=this.value.toUpperCase();" /></td>
                        </div>
                    </div>
                    <div class="row list-group-item">
                        <div class="col-xs-2">
                            <strong>Antecedentes</strong>
                        </div>
                        <div class="col-xs-2">
                            <strong>Gestante</strong>
                        </div>
                        <div class="col-xs-8">
                            <strong>Conoce otras personas que presentaron s&iacute;ntomas en los &uacute;ltimos 14 d&iacute;as</strong>
                        </div>
                    </div>
                    <div class="row list-group-item">
                        <div class="col-xs-2">
                            <?php
                            $antecedentes = array(''=>'Seleccione Tipo...','1'=>'Si','2'=>'No','3'=>'Ignorado');
                            echo form_dropdown('antecedentes', $antecedentes, $modificar->antecedentes, 'id="antecedentes" class="form-control"');
                            ?>
                       </div>
                        <div class="col-xs-2">
                            <?php
                            if($datos->sexo == "F"){
                                $gestante = array(''=>'Seleccione Tipo...','1'=>'Si','2'=>'No','3'=>'Ignorado');
                                echo form_dropdown('gestante', $gestante, $modificar->gestante, 'id="gestante" class="form-control"');
                            }else{
                                $gestante = array(''=>'Seleccione Tipo...','1'=>'Si','2'=>'No','3'=>'Ignorado');
                                echo form_dropdown('gestante', $gestante, $modificar->gestante, 'id="gestante" class="form-control" disabled');
                            }
                            ?>
                        </div>
                        <div class="col-xs-2">
                            <?php
                                $conoce_personas = array(''=>'Seleccione Tipo...','1'=>'Si','2'=>'No','3'=>'Ignorado');
                                echo form_dropdown('conoce_personas', $conoce_personas, $modificar->conoce_personas, 'id="conoce_personas" class="form-control"');
                            ?>
                        </div>
                    </div>
                    <div class="row list-group-item">
                        <div class="col-xs-12">
                            <strong>IV. Datos cl&iacute;nicos</strong></td>
                        </div>
                    </div>
                    <div class="row list-group-item">
                        <div class="col-xs-2">
				            <strong>Inicio de s&iacute;ntomas</strong>
                        </div>
                        <div class="col-xs-2">
				            <strong>Toma de muestra</strong>
                        </div>
                    </div>
                    <div class="row list-group-item">
                        <div class="col-xs-2">
                            <div class="input-group">
                                <input name="fecha_sin" type="text" id="fecha_sin" class="form-control" value="<?php echo $this->fechas_model->modificarFechas($datos->fecha_ini);?>" onKeyUp="javascript:this.value=this.value.toUpperCase();" placeholder="Ej. dd-mm-YYYY" readonly = "readonly" />
                                <div class="input-group-addon"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></div>
                            </div>
                        </div>                            
                        <div class="col-xs-2">
                            <div class="form-group">
                                <div class="input-group">
                                    <input name="fecha_mue" type="text" id="fecha_mue" class="form-control" title="Ingrese la fecha de toma de muestras" value="<?php if($modificar->fecha_mue != '0000-00-00'){ echo $this->fechas_model->modificarFechas($modificar->fecha_mue); }else{ echo ''; }?>" onKeyUp="javascript:this.value=this.value.toUpperCase();" placeholder="dd-mm-YYYY" />
                                   <div class="input-group-addon"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row list-group-item">
                        <div class="col-xs-2">
                            <strong>Signos y s&iacute;ntomas</strong>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-2">
                            <strong>Fiebre</strong>
                        </div>
                        <div class="col-xs-2">
                            <?php
                                $fiebre = array(''=>'Seleccione Tipo...','1'=>'Si','2'=>'No','3'=>'Ignorado');
                                echo form_dropdown('fiebre', $fiebre, $modificar->fiebre, 'id="fiebre" class="form-control"');
                            ?>
                        </div>
                        <div class="col-xs-2">
                            <strong>Cefalea</strong>
                        </div>
                        <div class="col-xs-2">
                            <?php
                                $cefalea = array(''=>'Seleccione Tipo...','1'=>'Si','2'=>'No','3'=>'Ignorado');
                                echo form_dropdown('cefalea', $cefalea, $modificar->cefalea, 'id="cefalea" class="form-control"');
                            ?>
                        </div>
                        <div class="col-xs-2">
                            <strong>Rash</strong>
                        </div>
                        <div class="col-xs-2">
                            <?php
                                $rash = array(''=>'Seleccione Tipo...','1'=>'Si','2'=>'No','3'=>'Ignorado');
                                echo form_dropdown('rash', $rash, $modificar->rash, 'id="rash" class="form-control"');
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-2">
                            <strong>Poliartralgias</strong>
                        </div>
                        <div class="col-xs-2">
                            <?php
                                $poliartralgias = array(''=>'Seleccione Tipo...','1'=>'Si','2'=>'No','3'=>'Ignorado');
                                echo form_dropdown('poliartralgias', $poliartralgias, $modificar->poliartralgias, 'id="poliartralgias" class="form-control"');
                            ?>
                        </div>
                        <div class="col-xs-2">
                            <strong>Mialgias</strong>
                        </div>
                        <div class="col-xs-2">
                            <?php
                                $mialgias = array(''=>'Seleccione Tipo...','1'=>'Si','2'=>'No','3'=>'Ignorado');
                                echo form_dropdown('mialgias', $mialgias, $modificar->mialgias, 'id="mialgias" class="form-control"');
                            ?>
                        </div>
                        <div class="col-xs-2">
                            <strong>Otros</strong>
                        </div>
                        <div class="col-xs-2">
                            <?php
                                $otro = array(''=>'Seleccione Tipo...','1'=>'Si','2'=>'No','3'=>'Ignorado');
                                echo form_dropdown('otro', $otro, $modificar->otro, 'id="otro" class="form-control"');
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-2">
                            <strong>Artritis en: Manos</strong>
                        </div>
                        <div class="col-xs-2">
                            <?php
                                $artritis_manos = array(''=>'Seleccione Tipo...','1'=>'Si','2'=>'No','3'=>'Ignorado');
                                echo form_dropdown('artritis_manos', $artritis_manos, $modificar->artritis_manos, 'id="artritis_manos" class="form-control"');
                            ?>
                        </div>
                        <div class="col-xs-2">
                            <strong>Dolor difuso en espalda</strong>
                        </div>
                        <div class="col-xs-2">
                            <?php
                                $dolor_espalda = array(''=>'Seleccione Tipo...','1'=>'Si','2'=>'No','3'=>'Ignorado');
                                echo form_dropdown('dolor_espalda', $dolor_espalda, $modificar->dolor_espalda, 'id="dolor_espalda" class="form-control"');
                            ?>
                        </div>
                        <div class="col-xs-2">
                        &nbsp;
                        </div>
                        <div class="col-xs-2">
                            <input name="otro_sintoma" type="text" id="otro_sintoma" value = "<?php echo $modificar->otro_sintoma;?>" class="form-control" title="Ingrese si el paciente tiene otro síntoma" onKeyUp="javascript:this.value=this.value.toUpperCase();" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-2">
                            <strong>Artritis en: Pies</strong>
                        </div>
                        <div class="col-xs-2">
                            <?php
                                $artritis_pies = array(''=>'Seleccione Tipo...','1'=>'Si','2'=>'No','3'=>'Ignorado');
                                echo form_dropdown('artritis_pies', $artritis_pies, $modificar->artritis_pies, 'id="artritis_pies" class="form-control"');
                            ?>
                        </div>
                        <div class="col-xs-2">
                            <strong>N&aacute;useas</strong>
                        </div>
                        <div class="col-xs-2">
                            <?php
                                $nauseas = array(''=>'Seleccione Tipo...','1'=>'Si','2'=>'No','3'=>'Ignorado');
                                echo form_dropdown('nauseas', $nauseas, $modificar->nauseas, 'id="nauseas" class="form-control"');
                            ?>
                        </div>
                        <div class="col-xs-2">
                            <strong>Artritis en: Tobillos</strong>
                        </div>
                        <div class="col-xs-2">
                            <?php
                                $artritis_tobillos = array(''=>'Seleccione Tipo...','1'=>'Si','2'=>'No','3'=>'Ignorado');
                                echo form_dropdown('artritis_tobillos', $artritis_tobillos, $modificar->artritis_tobillos, 'id="artritis_tobillos" class="form-control"');
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-2">
                            <strong>V&oacute;mitos</strong>
                        </div>
                        <div class="col-xs-2">
                            <?php
                                $vomitos = array(''=>'Seleccione Tipo...','1'=>'Si','2'=>'No','3'=>'Ignorado');
                                echo form_dropdown('vomitos', $vomitos, $modificar->vomitos, 'id="vomitos" class="form-control"');
                            ?>
                        </div>
                        <div class="col-xs-2">
                            <strong>Artritis en: Otros</strong>
                        </div>
                        <div class="col-xs-2">
                            <?php
                                $artritis_otros = array(''=>'Seleccione Tipo...','1'=>'Si','2'=>'No','3'=>'Ignorado');
                                echo form_dropdown('artritis_otros', $artritis_otros, $modificar->artritis_otros, 'id="artritis_otros" class="form-control"');
                            ?>
                        </div>
                        <div class="col-xs-2">
                            <input name="otro_artritis" type="text" id="otro_artritis" value = "<?php echo $modificar->otro_artritis;?>" title="Ingrese si el paciente tiene otro s&iacute;ntoma de artritis" onKeyUp="javascript:this.value=this.value.toUpperCase();" />
                        </div>
                    </div>
                </div>
                <div role="tabpanel"  class="tab-pane fade" id="messages">
                    <div class="row list-group-item">
                        <div class="col-xs-12">
                            <strong>V. Examenes de laboratorio</strong>
                        </div>
                    </div>
                    <div class="row list-group-item">
                        <div class="col-xs-2">
				            <strong>Cultivo</strong>
                        </div>
                        <div class="col-xs-2">
        				    <strong>Toma de muestra</strong>
                        </div>
                        <div class="col-xs-2">
				            <strong>Fecha Resultado</strong>
                        </div>
                        <div class="col-xs-2">
				            <strong>Resultado</strong>
                        </div>
                    </div>
                    <div class="row list-group-item">
                        <div class="col-xs-2">
                            <strong>Aislamiento viral</strong>
                        </div>
                        <div class="col-xs-2">
                            <div class="form-group">
                                <div class="input-group">
                                    <input name="fecha_cult" type="text" id="fecha_cult" class="form-control" value="<?php if($modificar->fecha_cult != '0000-00-00'){ echo $this->fechas_model->modificarFechas($modificar->fecha_cult); }else{ echo ''; }?>" title="Ingrese la fecha de toma de la muestra" placeholder="d-m-A" />
                                    <div class="input-group-addon"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <div class="form-group">
                                <div class="input-group">
                                    <input name="fecha_resul" type="text" id="fecha_resul" value="<?php if($modificar->fecha_resul != '0000-00-00'){ echo $this->fechas_model->modificarFechas($modificar->fecha_resul); }else{ echo ''; }?>" class="form-control" title="Ingrese la fecha del resultado de la muestra" placeholder="d-m-A" />
                                    <div class="input-group-addon"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <?php
                                $cultivo = array(''=>'Seleccione Tipo...','1'=>'Si','2'=>'No','3'=>'Ignorado');
                                echo form_dropdown('cultivo', $cultivo, $modificar->cultivo, 'id="cultivo" class="form-control"');
                            ?>
                        </div>
                    </div>
                    <div class="row list-group-item">
                        <div class="col-xs-2">
                            <strong>Serolog&iacute;a</strong>
                        </div>
                        <div class="col-xs-2">
                            <strong>Toma de muestra</strong>
                        </div>
                        <div class="col-xs-2">
                            <strong>IgM (T&iacute;tulo)</strong>
                        </div>
                        <div class="col-xs-2">
                            <strong>IgG (T&iacute;tulo)</strong>
                        </div>
                        <div class="col-xs-2">
                            <strong>Resultado</strong>
                        </div>
                        <div class="col-xs-2">
                            <strong>Fecha Resultado</strong>
                        </div>
                    </div>
                    <div class="row list-group-item">
                        <div class="col-xs-2">
                            <strong>1era. Muestra</strong>
                        </div>
                        <div class="col-xs-2">
                            <div class="form-group">
                                <div class="input-group">
                                    <input name="fecha_ser1" type="text" id="fecha_ser1" value="<?php if($modificar->fecha_ser1 != '0000-00-00'){ echo $this->fechas_model->modificarFechas($modificar->fecha_ser1); }else{ echo ''; }?>" class="form-control" title="Ingrese la fecha de toma de la primera muestra" placeholder="d-m-A" />
                                    <div class="input-group-addon"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <?php
                                $igm1 = array(''=>'Seleccione...','1'=>'Positivo','2'=>'Negativo');
                                echo form_dropdown('igm1', $igm1, $modificar->igm1, 'id="igm1" class="form-control"');
                            ?>
                        </div>
                        <div class="col-xs-2">
                            <?php
                                $igg1 = array(''=>'Seleccione...','1'=>'Positivo','2'=>'Negativo');
                                echo form_dropdown('igg1', $igg1, $modificar->igg1, 'id="igg1" class="form-control"');
                            ?>
                        </div>
                        <div class="col-xs-2">
                            <input name="resultado1" type="text" id="resultado1" value = "<?php echo $modificar->resultado1; ?>" class="form-control" title="Ingrese el resultado de la muestra" onKeyUp="javascript:this.value=this.value.toUpperCase();" />
                        </div>
                        <div class="col-xs-2">
                            <div class="form-group">
                                <div class="input-group">
                                    <input name="fecha_res1" type="text" id="fecha_res1" value="<?php if($modificar->fecha_res1 != '0000-00-00'){ echo $this->fechas_model->modificarFechas($modificar->fecha_res1); }else{ echo ''; }?>" class="form-control" title="Ingrese la fecha del resultado de la primera muestra" placeholder="d-m-A" />
                                    <div class="input-group-addon"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row list-group-item">
                        <div class="col-xs-2">
                            <strong>2da. Muestra</strong>
                        </div>
                        <div class="col-xs-2">
                            <div class="form-group">
                                <div class="input-group">
                                    <input name="fecha_ser2" type="text" id="fecha_ser2" value="<?php if($modificar->fecha_ser2 != '0000-00-00'){ echo $this->fechas_model->modificarFechas($modificar->fecha_ser2); }else{ echo ''; }?>" class="form-control" title="Ingrese la fecha de toma de la segunda muestra" placeholder="d-m-A" />
                                    <div class="input-group-addon"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <?php
                                $igm2 = array(''=>'Seleccione...','1'=>'Positivo','2'=>'Negativo');
                                echo form_dropdown('igm2', $igm2, $modificar->igm2, 'id="igm1" class="form-control"');
                            ?>
                        </div>
                        <div class="col-xs-2">
                            <?php
                                $igg2 = array(''=>'Seleccione...','1'=>'Positivo','2'=>'Negativo');
                                echo form_dropdown('igg2', $igg2, $modificar->igg2, 'id="igg2" class="form-control"');
                            ?>
                        </div>
                        <div class="col-xs-2">
                            <input name="resultado2" type="text" id="resultado2" value = "<?php echo $modificar->resultado2; ?>" class="form-control" title="Ingrese el resultado de la muestra" onKeyUp="javascript:this.value=this.value.toUpperCase();" />
                        </div>
                        <div class="col-xs-2">
                            <div class="form-group">
                                <div class="input-group">
                                    <input name="fecha_res2" type="text" id="fecha_res2" value="<?php if($modificar->fecha_res2 != '0000-00-00'){ echo $this->fechas_model->modificarFechas($modificar->fecha_res2); }else{ echo ''; }?>" class="form-control" title="Ingrese la fecha del resultado de la segunda muestra" placeholder="d-m-A" />
                                    <div class="input-group-addon"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row list-group-item">
                        <div class="col-xs-2">
                            &nbsp;
                        </div>
                        <div class="col-xs-2">
                            <strong>Toma de muestra</strong>
                        </div>
                        <div class="col-xs-2">
                            <strong>Positivo</strong>
                        </div>
                        <div class="col-xs-2">
                            <strong>Fecha Resultado</strong>
                        </div>
                    </div>
                    <div class="row list-group-item">
                        <div class="col-xs-2">
                            <strong>PCR</strong>
                        </div>
                        <div class="col-xs-2">
                            <div class="form-group">
                                <div class="input-group">
                                    <input name="fecha_pcr" type="text" id="fecha_pcr" value="<?php if($modificar->fecha_pcr != '0000-00-00'){ echo $this->fechas_model->modificarFechas($modificar->fecha_pcr); }else{ echo ''; }?>" class="form-control" title="Ingrese la fecha de toma de la muestra" onKeyUp="javascript:this.value=this.value.toUpperCase();" placeholder="d-m-A" />
                                    <div class="input-group-addon"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <?php
                                $positivo = array(''=>'Seleccione Tipo...','1'=>'Si','2'=>'No','3'=>'Ignorado');
                                echo form_dropdown('positivo', $positivo, $modificar->positivo, 'id="positivo" class="form-control"');
                            ?>
                        </div>
                        <div class="col-xs-2">
                            <div class="form-group">
                                <div class="input-group">
                                    <input name="fecha_res3" type="text" id="fecha_res3" value="<?php if($modificar->fecha_res3 != '0000-00-00'){ echo $this->fechas_model->modificarFechas($modificar->fecha_res3); }else{ echo ''; }?>" class="form-control" title="Ingrese la fecha de resultado de la muestra" placeholder="d-m-A" />
                                    <div class="input-group-addon"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row list-group-item">
                        <div class="col-xs-12">
                            <strong>VI. Evoluci&oacute;n</strong>
                        </div>
                    </div>
                    <div class="row list-group-item">
                        <div class="col-xs-2">
                            <strong>Fecha Hospitalizaci&oacute;n</strong>
                        </div>
                        <div class="col-xs-2">
                            <strong>Evoluci&oacute;n del paciente</strong>
                        </div>
                        <div class="col-xs-2">
                            &nbsp;
                        </div>
                        <div class="col-xs-2">
                            <strong>Fecha</strong>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-2">
                            <div class="form-group">
                                <div class="input-group">
                                    <input name="fecha_hos" type="text" id="fecha_hos" value="<?php if($modificar->fecha_hos != '0000-00-00'){ echo $this->fechas_model->modificarFechas($modificar->fecha_hos); }else{ echo ''; }?>" class="form-control" title="Ingrese la fecha de hospitalziaci&oacute;n del paciente" placeholder="d-m-A" />
                                    <div class="input-group-addon"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <strong>Curado</strong>
                        </div>
                        <div class="col-xs-2">
                            <?php
                                $alta = array(''=>'Seleccione Tipo...','1'=>'Si','2'=>'No','3'=>'Ignorado');
                                echo form_dropdown('alta', $alta, $modificar->alta, 'id="alta" class="form-control"');
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-2">
                            &nbsp;
                        </div>
                        <div class="col-xs-2">
                            <strong>Fallecido</strong>
                        </div>
                        <div class="col-xs-2">
                            <?php
                                $fallecido = array(''=>'Seleccione Tipo...','1'=>'Si','2'=>'No','3'=>'Ignorado');
                                echo form_dropdown('fallecido', $fallecido, $modificar->fallecido, 'id="fallecido" class="form-control"');
                            ?>
                        </div>
                        <div class="col-xs-2">
                            <div class="form-group">
                                <div class="input-group">
                                    <input name="fecha_def" type="text" id="fecha_def" value="<?php if($modificar->fecha_def != '0000-00-00'){ echo $this->fechas_model->modificarFechas($modificar->fecha_def); }else{ echo ''; }?>" class="form-control" title="Ingrese la fecha de defunci&oacute;n del paciente" placeholder="d-m-A" />
                                    <div class="input-group-addon"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-2">
                            &nbsp;
                        </div>
                        <div class="col-xs-2">
                            <strong>Referido</strong>
                        </div>
                        <div class="col-xs-2">
                            <?php
                                $referido = array(''=>'Seleccione Tipo...','1'=>'Si','2'=>'No','3'=>'Ignorado');
                                echo form_dropdown('referido', $referido, $modificar->referido, 'id="referido" class="form-control"');
                            ?>
                        </div>
                    </div>
                </div>
                <div role="tabpanel"  class="tab-pane fade" id="settings">
                    <div class="form-group">
                        <div class="row list-group-item">
                            <div class="col-xs-12">
                                <strong>VII. Clasificaci&oacute;n Final</strong>
                            </div>
                        </div>
                        <div class="row list-group-item">
                            <div class="col-xs-12">
                                <strong>FIEBRE DE CHIKUNGUNYA</strong>
                            </div>
                        </div>
                        <div class="row list-group-item">
                            <div class="col-xs-2">
                                <div class="button-group">
                                    <strong>Sospechoso</strong>&nbsp;&nbsp;
                                    <input type="checkbox" name="clasifica[]" id="sospechoso" value = "sospechoso" <?php if($modificar->sospechoso == '1'){?> checked="checked" <?php }?> title="Elija si el caso es sospechoso"/>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="button-group">
                                    <strong>Probable</strong>&nbsp;&nbsp;
                                    <input type="checkbox" name="clasifica[]" id="probable" value = "probable" <?php if($modificar->probable == '1'){?> checked="checked" <?php }?> title="Elija si el caso es probable"/>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="button-group">
                                    <strong>Confirmado</strong>&nbsp;&nbsp;
                                    <input type="checkbox" name="clasifica[]" id="confirmado" value = "confirmado" <?php if($modificar->confirmado == '1'){?> checked="checked" <?php }?> title="Elija si el caso es confirmado"/>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="button-group">
                                    <strong>Descartado</strong>&nbsp;&nbsp;
                                   <input type="checkbox" name="clasifica[]" id="descartado" value = "descartado" <?php if($modificar->descartado == '1'){?> checked="checked" <?php }?> title="Elija si el caso es descartado"/>
                                </div>
                            </div>
                        </div>
                        <div class="row list-group-item">
                            <div class="col-xs-12">
                                <strong>FIEBRE DE CHIKUNGUNYA GRAVE</strong>
                            </div>
                        </div>
                        <div class="row list-group-item">
                            <div class="col-xs-2">
                                <div class="button-group">
                                    <strong>Sospechoso</strong>&nbsp;&nbsp;
                                    <input type="checkbox" name="clasifica[]" id="sospechosoG" value = "sospechosoG" <?php if($modificar->sospechosoG == '1'){?> checked="checked" <?php }?> title="Elija si el caso es sospechoso"/>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="button-group">
                                    <strong>Probable</strong>&nbsp;&nbsp;
                                    <input type="checkbox" name="clasifica[]" id="probableG" value = "probableG" <?php if($modificar->probableG == '1'){?> checked="checked" <?php }?> title="Elija si el caso es probable"/>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="button-group">
                                    <strong>Confirmado</strong>&nbsp;&nbsp;
                                    <input type="checkbox" name="clasifica[]" id="confirmadoG" value = "confirmadoG" <?php if($modificar->confirmadoG == '1'){?> checked="checked" <?php }?> title="Elija si el caso es confirmado"/>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="button-group">
                                    <strong>Descartado</strong>&nbsp;&nbsp;
                                    <input type="checkbox" name="clasifica[]" id="descartadoG" value = "descartadoG" <?php if($modificar->descartadoG == '1'){?> checked="checked" <?php }?> title="Elija si el caso es descartado"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row list-group-item">
                        <div class="col-xs-12">
                            <strong>VIII. Procedencia del Caso</strong>
                        </div>
                    </div>
                    <div class="row list-group-item">
                        <div class="form-group">
                            <div class="col-xs-2">
                                <div class="button-group">
                                    <strong>Aut&oacute;ctono</strong>&nbsp;&nbsp;
                                    <input type="checkbox" name="procede[]" id="autoctono" value = "autoctono" <?php if($modificar->autoctono == '1'){?> checked="checked" <?php }?> title="Elija si el caso es autoctono"/>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="button-group">
                                    <strong>Importado Nacional</strong>&nbsp;&nbsp;
                                    <input type="checkbox" name="procede[]" id="nacional" value = "nacional" <?php if($modificar->nacional == '1'){?> checked="checked" <?php }?> title="Elija si el caso es importado nacional"/>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="button-group">
                                    <strong>Importado Internacional</strong>&nbsp;&nbsp;
                                    <input type="checkbox" name="procede[]" id="importado" value = "importado" <?php if($modificar->importado == '1'){?> checked="checked" <?php }?> title="Elija si el caso es importado internacional"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row list-group-item">
                        <div class="col-xs-12">
                            <strong>IX. Observaciones</strong>
                        </div>
                        <div class="col-xs-12">
                            <?php 
        			         $datos = array(
        							'name'        => 'observaciones',
        							'id'          => 'observaciones',
                                    'class'       => 'form-control',
        							'value'       => $modificar->observaciones,
        							'rows'   	  => '5',
        							'cols'        => '100',
        							'style'       => 'width:100%',
        					);
        			  
                            echo form_textarea($datos);
                            ?>
                        </div>
                    </div>
                    <div class="row list-group-item">
                        <div class="col-xs-12">
                            <strong>X. Datos de la persona que realiza la investigaci&oacute;n</strong>
                        </div>
                    </div>
                    <div class="row list-group-item">
                        <div class="col-xs-2">
                            <strong>Nombre del investigador</strong>
                        </div>
                        <div class="col-xs-2">
                            <strong>Cargo</strong>
                        </div>
                        <div class="col-xs-2">
                            <strong>Tel&eacute;fono</strong>
                        </div>
                        <div class="col-xs-2">
                            <strong>Correo</strong>
                        </div>
                    </div>
                    <div class="row list-group-item">
                        <div class="col-xs-2">
                            <div class="form-group">
                           	  	<input name="investigador" type="text" id="investigador" class="form-control" title="Ingrese el nombre del investigador" value="<?php echo $modificar->investigador?>" onKeyUp="javascript:this.value=this.value.toUpperCase();" />
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <div class="form-group">
                           	  	<input name="cargo" type="text" id="cargo" class="form-control" title="Ingrese el cargo del investigador" value="<?php echo $modificar->cargo?>" onKeyUp="javascript:this.value=this.value.toUpperCase();" />
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <div class="form-group">
                           	  	<input name="telefonos" type="text" id="telefonos" class="form-control" value="<?php echo $modificar->telef?>" title="Ingrese el tel&eacute;fono del investigador" onKeyUp="javascript:this.value=this.value.toUpperCase();" />
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="form-group">
                           	  	<input name="correo" type="text" id="correo" class="form-control" title="Ingrese el correo del investigador" value="<?php echo $modificar->correo?>" placeholder="cuentadecorreo@hola.com" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer col-xs-12 text-right">
                    <a class="btn btn-primary btn-md" href="<?php echo site_url('modulos/listarChikungunya');?>" role="button">Listar Fichas</a>
                    <button type="submit" class="btn btn-primary btn-default btn-md">Grabar Datos</button>
                    <a class="btn btn-primary btn-md" href="<?php echo site_url('modulos/listarChikungunya');?>" role="button">Cancelar</a>
                    <input type="hidden" name="diaHoy" id="diaHoy" value="<?php echo date('d-m-Y');?>"/>
                    <input type="hidden" id="regis" name="regis" value="<?php echo $registro;?>" />
                    <input type="hidden" id="estab" name="estab" value="<?php echo $estab;?>" />
                    <input type="hidden" id="dir" name="dir" value="<?php echo $dir;?>" />
                    <input type="hidden" id="rd" name="rd" value="<?php echo $rd;?>" />
                    <input type="hidden" id="mrd" name="mrd" value="<?php echo $mrd;?>" />
                    <input type="hidden" id="notificacion" name="notificacion" value="<?php echo $notificacion; ?>" />
                </div>
        	</div>
        </div>
    </div>
</div>
<?php
    echo form_close();
?>
</body>
</HTML>