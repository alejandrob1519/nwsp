<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<script type="text/javascript" src="<?php echo base_url()?>assets/js/materna.js"></script>
</head>
<body>
<?php
	if($this->session->flashdata('exito') != ''){
		?>
		<div class="exito"><?php echo $this->session->flashdata('exito'); ?></div>
		<?php
	}
	if($this->session->flashdata('error') != ''){
		?>
		<div class="error"><?php echo $this->session->flashdata('error'); ?></div>
		<?php
	}
	if($this->session->flashdata('info') != ''){
		?>
		<div class="info"><?php echo $this->session->flashdata('info'); ?></div>
		<?php
	}
?>
<?php
	$atributos = array('id'=>'form1', 'name'=>'form1');
	echo form_open(null, $atributos);
?>
<div class="panel panel-primary">
    <div class="panel-heading">
      <h3 class="panel-title"><center>FICHA DE INVESTIGACION EPIDEMIOLOGICA DE CASO DE SIFILIS MATERNA Y CONGENITA</center></h3>
    </div>
    <div class="panel-body">
        <div role="tabpanel">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
              <li role="presentation" class="active">
                <a href="#home" aria-controls="home" role="tab" data-toggle="tab"><i class="fa fa-user-plus fa-lg"></i>&nbsp;&nbsp;Encabezado</a>
              </li>
			  <?php
              if($datos->diagnostic == "O98.1"){
                  ?>
	              <li role="presentation">
    	            <a href="#materna" aria-controls="materna" role="tab" data-toggle="tab"><i class="fa fa-user-md fa-lg"></i>&nbsp;&nbsp;S&iacute;filis Materna</a>
        	      </li>
              <?php
			  }
			  ?>
			  <?php
              if($datos->diagnostic == "A50"){
                  ?>
	              <li role="presentation">
    	            <a href="#congenita" aria-controls="congenita" role="tab" data-toggle="tab"><i class="fa fa-plus-square fa-lg"></i>&nbsp;&nbsp;S&iacute;filis Cong&eacute;nita</a>
        	      </li>
              <?php
			  }
			  ?>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel"  class="tab-pane fade in active" id="home">
                    <div class="row list-group-item">
                        <div class="col-xs-12">
                            <strong>DATOS GENERALES</strong>
                        </div>
                    </div>
                    <div class="row list-group-item">
                        <div class="col-xs-3">
                            <strong>Apellidos y Nombres de la Madre</strong>
                        </div>
                        <div class="col-xs-5">
                            <div class="form-group">
                            <?php	  
                            if($modificar->ciex == "O98.1"){
                                ?>
                                <input name="madre_apenom" type="text" class="form-control" id="madre_apenom" title="Apellidos y nombres de la madre" value="<?php echo $datos->apepat." ".$datos->apemat." ".$datos->nombres;?>" readonly />
                                <?php
                            }else{
                                ?>
                                <input name="madre_apenom" type="text" class="form-control" id="madre_apenom" title="Apellidos y nombres de la madre" value="<?php echo $modificar->madre_apenom;?>" />
                                <?php
                            }
                            ?>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <strong>C&oacute;digo (DNI Madre)</strong>
                        </div>
                    </div>
                    <div class="row list-group-item">
                        <div class="col-xs-3">
                            <strong>Apellidos y Nombres del hijo</strong>
                        </div>
                        <div class="col-xs-5">
                            <div class="form-group">
                            <?php	  
                            if($modificar->ciex == "O98.1"){
                                ?>
                                <input name="hijo_apenom" type="text" class="form-control" id="hijo_apenom" title="Apellidos y nombres de la madre" value="<?php echo $modificar->hijo_apenom;?>" />
                                <?php
                            }else{
                                ?>
                                <input name="hijo_apenom" type="text" class="form-control" id="hijo_apenom" title="Apellidos y nombres de la madre" value="<?php echo $datos->apepat." ".$datos->apemat." ".$datos->nombres;?>" readonly />
                                <?php
                            }
                            ?>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="form-group">                            
                            <?php	  
                            if($modificar->ciex == "O98.1"){
                                ?>
                                <input name="codigo" type="text" class="form-control" id="codigo" title="Vienen del NotiWeb" value="<?php echo $datos->dni;?>" size="15" readonly /></td>
                                <?php
                            }else{
                                ?>
                                <input name="codigo" type="text" class="form-control" id="codigo" title="Vienen del NotiWeb" value="<?php echo $modificar->codigo;?>" size="15" /></td>
                                <?php
                            }
                            ?>
                            </div>
                        </div>
                    </div>
                    <div class="row list-group-item">
                        <div class="col-xs-3">
                            <strong>Establecimiento de salud</strong>
                        </div>
                        <div class="col-xs-5">
                            <input name="establecimiento" type="text" class="form-control" id="establecimiento" title="Vienen del NotiWeb" value="<?php echo $datos->raz_soc;?>" readonly />
                        </div>
                        <div class="col-xs-4">
                            <strong>Nivel de establecimiento</strong>
                        </div>
                    </div>
                    <div class="row list-group-item">
                        <div class="col-xs-3">
                            <strong>Institucion</strong>
                        </div>
                        <div class="col-xs-5">
                           <?php
                           switch($datos->tipo)
                           {
                               case 'A':
                               $institucion = 'MINSA';
                               break;
                               case 'C':
                               $institucion = 'ESSALUD';
                               break;
                               case 'D':
                               $institucion = 'FFAA/PNP';
                               break;
                               case 'X':
                               $institucion = 'PRIVADOS';
                               break;
                           }
                           ?>
                            <input name="insti" type="text" class="form-control" id="insti" title="Vienen del NotiWeb" value="<?php echo $institucion;?>" readonly />
                        </div>
                        <div class="col-xs-4">
                            <input name="categoria" type="text" class="form-control" id="categoria" title="Vienen del NotiWeb" value="<?php echo $datos->categoria;?>" readonly />
                        </div>
                    </div>
                    <div class="row list-group-item">
                        <div class="col-xs-4">
                            <strong>DIRESA/DISA/GERESA</strong>
                        </div>
                        <div class="col-xs-4">
                            <strong>RED</strong>
                        </div>
                        <div class="col-xs-4">
                            <strong>MICRORED</strong>
                        </div>
                    </div>
                    <div class="row list-group-item">
                        <div class="col-xs-4">
                            <input name="subregion" type="text" class="form-control" id="subregion" title="Vienen del NotiWeb" value="<?php echo $datos->diresa;?>" readonly />
                        </div>
                        <div class="col-xs-4">
                            <input name="red" type="text" class="form-control" id="red" title="Vienen del NotiWeb" value="<?php echo $datos->redes;?>" readonly />
                        </div>
                        <div class="col-xs-4">
                            <input name="mred" type="text" class="form-control" id="mred" title="Vienen del NotiWeb" value="<?php echo $datos->microredes;?>" readonly />
                        </div>
                    </div>
                    <div class="row list-group-item">
                        <div class="col-xs-3">
                            <strong>Fecha de notificación</strong>
                        </div>
                        <div class="col-xs-3">
                            <strong>Semana epidemiológica</strong>
                        </div>
                        <div class="col-xs-3">
                            <strong>Investigaci&oacute;n de...</strong>
                        </div>
                    </div>
                    <div class="row list-group-item">
                        <div class="col-xs-3">
                            <input name="fecha_not" type="text" class="form-control" id="fecha_not" title="Vienen del NotiWeb" value="<?php echo $this->fechas_model->modificarFechas($datos->fecha_not);?>" readonly />
                        </div>
                        <div class="col-xs-3">
                            <input name="semana" type="text" class="form-control" id="semana" title="Vienen del NotiWeb" value="<?php echo $datos->semana;?>" readonly />
                        </div>
                        <div class="col-xs-6">
                            <?php 
                            if($datos->diagnostic == "O98.1"){
                              ?>
                              <input name="sifilis1" type="checkbox" id="sifilis1" title="Haga click de ser el caso" checked="checked" /> 
                              <?php
                            }else{
                              ?>
                              <input name="sifilis1" type="checkbox" id="sifilis1" title="Haga click de ser el caso" /> 
                              <?php
                            }
                            ?>
                            <strong>S&iacute;filis materna</strong>&nbsp;&nbsp;</td>
                            <?php
                            if($datos->diagnostic == "A50"){
                              ?>
                              <input name="sifilis2" type="checkbox" id="sifilis2" title="Haga click de ser el caso" checked="checked" /> 
                              <?php
                            }else{
                              ?>
                              <input name="sifilis2" type="checkbox" id="sifilis2" title="Haga click de ser el caso" /> 
                              <?php
                            }
                            ?>
                            <strong>S&iacute;filis cong&eacute;nita</strong>
                        </div>
                    </div>
                </div>
                
                <!--/////////////////////////////-->
                
                <?php
                if($datos->diagnostic == "O98.1"){
					?>
                    <div role="tabpanel"  class="tab-pane fade" id="materna">
                        <div class="row list-group-item">
                            <div class="col-xs-12">
                                <strong>INFORMACION DEMOGRAFICA MATERNA</strong>
                            </div>
                        </div>
                        <div class="row list-group-item">
                            <div class="col-xs-2">
                                <strong>1. Fecha de nacimiento</strong>
                            </div>
                            <div class="col-xs-2">
                                <strong>2. Edad</strong>
                            </div>
                            <div class="col-xs-2">
                                <strong>Tipo Edad</strong>
                            </div>
                        </div>
                        <div class="row list-group-item">
                            <div class="col-xs-2">
                                <div class="input-group">
                                    <input type='text' class="form-control datepicker" name="fecha_nac" id="fecha_nac" title="Fecha de nacimiento del paciente" placeholder="Ej.99-99-9999" value="<?php echo $this->fechas_model->modificarFechas($modificar1->fecha_nac);?>" onKeyPress="return acceptNum(event)" />
                                    <div class="input-group-addon"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></div>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <input name="edad" type="text" class="form-control" id="edad" title="Vienen del NotiWeb" value="<?php echo $datos->edad;?>" readonly />
                            </div>
                           <?php
                           switch($datos->tipo_edad)
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
                            <div class="col-xs-2">
                                <input name="tedad" type="text" class="form-control" id="tedad" title="Vienen del NotiWeb" value="<?php echo $tedad;?>" readonly />
                            </div>
                        </div>
                        <div class="row list-group-item">
                            <div class="col-xs-12">
                                <strong>3. Lugar de Residencia Habitual</strong>
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
                            <div class="col-xs-4">
                                <strong>Localidad</strong>
                            </div>
                        </div>
                        <div class="row list-group-item">
                            <div class="col-xs-2">
                                <?php 
                                echo form_dropdown('pais', $paises, $modificar1->pais, 'id="pais" class="form-control"');
                                ?>
                            </div>
                            <div class="col-xs-2">
                                <?php 
                                echo form_dropdown('departamento', $departamento, substr($modificar1->residencia,0,2), 'id="departamento" class="form-control"');
                                ?>
                            </div>
                            <div class="col-xs-2">
                                <?php 
                                echo form_dropdown('provincia', $provincia, substr($modificar1->residencia,0,4), 'id="provincia" class="form-control"');
                                ?>
                            </div>
                            <div class="col-xs-2">
	                            <div class="form-group">
	                                <?php 
    	                            echo form_dropdown('distrito', $distrito, $modificar1->residencia, 'id="distrito" class="form-control"');
        	                        ?>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <input name="localidad" type="text" class="form-control" id="localidad" title="Localidad" value="<?php echo $modificar1->localidad;?>" onKeyUp="javascript:this.value=this.value.toUpperCase();" placeholder="Localidad" />
                            </div>
                        </div>
                        <div class="row list-group-item">
                            <div class="col-xs-12">
                                <strong>EMBARAZO ACTUAL</strong>
                            </div>
                        </div>
                        <div class="row list-group-item">
                            <div class="col-xs-3">
                                <strong>4. Ultimo periodo menstrual</strong>
                            </div>
                            <div class="col-xs-3">
                                <strong>5. Atenci&oacute;n prenatal</strong>
                            </div>
                            <div class="col-xs-3">
                                <strong>6. Primer control prenatal</strong>
                            </div>
                            <div class="col-xs-3">
                                <strong>7. Edad gestacional</strong>
                            </div>
                        </div>
                        <div class="row list-group-item">
                            <div class="col-xs-3">
                                <div class="input-group">
                                    <input type='text' class="form-control datepicker" name="fecha_ini" id="fecha_ini" title="Ingrese la fecha de inicio de &uacute;ltima mestruasi&oacute;n" placeholder="Ej.99-99-9999" value="<?php echo $this->fechas_model->modificarFechas($modificar1->fecha_ini);?>" onKeyPress="return acceptNum(event)" />
                                    <div class="input-group-addon"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></div>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="input-group">
                                    <select name="atencion" id="atencion" class="form-control" title="Elija si la paciente recibi&oacute; atenci&oacute;n prenatal">
                                      <option value="">Seleccione...</option>
                                      <option value="1" <?php if($modificar1->atencion == "1"){?> selected="selected" <?php }?>>Si</option>
                                      <option value="2" <?php if($modificar1->atencion == "2"){?> selected="selected" <?php }?>>No</option>
                                      <option value="3" <?php if($modificar1->atencion == "3"){?> selected="selected" <?php }?>>Desconocido</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="input-group">
                                    <input type='text' class="form-control datepicker" name="fecha_con1" id="fecha_con1" title="Ingrese la fecha de primer control prenatal" placeholder="Ej.99-99-9999" value="<?php echo $this->fechas_model->modificarFechas($modificar1->fecha_con1);?>" onKeyPress="return acceptNum(event)" />
                                    <div class="input-group-addon"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></div>
                                </div>
                            </div>
                            <div class="col-xs-3">
	                            <div class="form-group">
	                                <div class="input-group">
    	                                <input name="edad_ges_mat" type="text" id="edad_ges_mat" class="form-control" title="Ingrese edad gestacional" value="<?php echo $modificar1->edad_ges;?>" />&nbsp;<strong>Semanas</strong>                               
        	                        </div>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="input-group">
                                    <?php
                                    if($modificar1->desconocido_ini == "1"){
                                        ?>
                                        <input name="desconocido_ini" type="checkbox" id="desconocido_ini" checked="checked" title="Desconoce la fecha de inicio de &uacute;ltima mestruasi&oacute;n" />&nbsp;&nbsp;<strong>Desconocido</strong>
                                        <?php                  
                                    }else{
                                        ?>
                                        <input name="desconocido_ini" type="checkbox" id="desconocido_ini" title="Desconoce la fecha de inicio de &uacute;ltima mestruasi&oacute;n" />&nbsp;&nbsp;<strong>Desconocido</strong>
                                        <?php                  
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="input-group">
                                    <?php
                                    if($modificar1->desconocido_con1 == "1"){
                                        ?>
                                        <input name="desconocido_con1" type="checkbox" id="desconocido_con1" checked="checked" title="Desconoce la fecha de primer control prenatal" />&nbsp;&nbsp;<strong>Desconocido</strong>
                                        <?php                  
                                    }else{
                                        ?>
                                        <input name="desconocido_con1" type="checkbox" id="desconocido_con1" title="Desconoce la fecha de primer control prenatal" />&nbsp;&nbsp;<strong>Desconocido</strong>
                                        <?php                  
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="row list-group-item">
                            <div class="col-xs-12">
                                <strong>8. Indique las fechas y resultados de la primera (a) y la m&aacute;s reciente (b) prueba no trepon&eacute;mica (RPR, VDRL) realizada durante la gestación, parto o puerperio</strong>
                            </div>
                        </div>
                        <div class="row list-group-item">
                            <div class="col-xs-3">
                                <strong>Fecha (dia-mes-año)</strong>
                            </div>
                            <div class="col-xs-3">
                                <strong>Resultados</strong>
                            </div>
                            <div class="col-xs-3">
                                <strong>T&iacute;tulo</strong>
                            </div>
                            <div class="col-xs-3">
                                <strong>Momento</strong>
                            </div>
                        </div>
                        <div class="row list-group-item">
                            <div class="col-xs-3">
                                <div class="input-group">
                                    <input type='text' class="form-control datepicker" name="fecha_ntrep1" id="fecha_ntrep1" title="Ingrese la fecha correspondiente" placeholder="Ej.99-99-9999" value="<?php echo $this->fechas_model->modificarFechas($modificar1->fecha_ntrep1);?>" onKeyPress="return acceptNum(event)" />
                                    <div class="input-group-addon"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></div>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="input-group">
                                    <select name="resultados_ntrep1" id="resultados_ntrep1" class="form-control" title="Elija el resultado correspondiente">
                                      <option value="">Selecione...</option>
                                      <option value="1" <?php if($modificar1->resultados_ntrep1 == "1"){?> selected="selected" <?php }?>>Reactivo</option>
                                      <option value="2" <?php if($modificar1->resultados_ntrep1 == "2"){?> selected="selected" <?php }?>>No reactivo</option>
                                      <option value="3" <?php if($modificar1->resultados_ntrep1 == "3"){?> selected="selected" <?php }?>>Desconocido</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="input-group">
                                    <input name="titulo_ntrep1" type="text" id="titulo_ntrep1" class="form-control" title="Ingrese los t&iacute;tulos de los resultados" value="<?php echo $modificar1->titulo_ntrep1;?>" onKeyUp="javascript:this.value=this.value.toUpperCase();" />                                
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="input-group">
                                    <select name="momento_ntrep1" id="momento_ntrep1" class="form-control" title="Elija el momento correspondiente">
                                      <option value="">Selecione...</option>
                                      <option value="1" <?php if($modificar1->momento_ntrep1 == "1"){?> selected="selected" <?php }?>>Gestaci&oacute;n</option>
                                      <option value="2" <?php if($modificar1->momento_ntrep1 == "2"){?> selected="selected" <?php }?>>Parto</option>
                                      <option value="3" <?php if($modificar1->momento_ntrep1 == "3"){?> selected="selected" <?php }?>>Puerperio</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row list-group-item">
                            <div class="col-xs-3">
                                <div class="input-group">
                                    <input type='text' class="form-control datepicker" name="fecha_ntrep2" id="fecha_ntrep2" title="Ingrese la fecha correspondiente" placeholder="Ej.99-99-9999" value="<?php echo $this->fechas_model->modificarFechas($modificar1->fecha_ntrep2);?>" onKeyPress="return acceptNum(event)" />
                                    <div class="input-group-addon"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></div>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="input-group">
                                    <select name="resultados_ntrep2" id="resultados_ntrep2" class="form-control" title="Elija el resultado correspondiente">
                                      <option value="">Selecione...</option>
                                      <option value="1" <?php if($modificar1->resultados_ntrep2 == "1"){?> selected="selected" <?php }?>>Reactivo</option>
                                      <option value="2" <?php if($modificar1->resultados_ntrep2 == "2"){?> selected="selected" <?php }?>>No reactivo</option>
                                      <option value="3" <?php if($modificar1->resultados_ntrep2 == "3"){?> selected="selected" <?php }?>>Desconocido</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="input-group">
                                    <input name="titulo_ntrep2" type="text" id="titulo_ntrep2" class="form-control" title="Ingrese los t&iacute;tulos de los resultados" value="<?php echo $modificar1->titulo_ntrep2;?>" onKeyUp="javascript:this.value=this.value.toUpperCase();" />                                
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="input-group">
                                    <select name="momento_ntrep2" id="momento_ntrep2" class="form-control" title="Elija el momento correspondiente">
                                      <option value="">Selecione...</option>
                                      <option value="1" <?php if($modificar1->momento_ntrep2 == "1"){?> selected="selected" <?php }?>>Gestaci&oacute;n</option>
                                      <option value="2" <?php if($modificar1->momento_ntrep2 == "2"){?> selected="selected" <?php }?>>Parto</option>
                                      <option value="3" <?php if($modificar1->momento_ntrep2 == "3"){?> selected="selected" <?php }?>>Puerperio</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row list-group-item">
                            <div class="col-xs-12">
                                <strong>9.	Indique las fechas y resultados de la primera (a) y la más reciente (b) prueba treponémica (TPHA, TPPA, FTA Abs, ELISA, Prueba Rápida o Dual)  realizada durante la gestación, parto o puerperio</strong>
                            </div>
                        </div>
                        <div class="row list-group-item">
                            <div class="col-xs-2">
                                <strong>Fecha (dia-mes-año)</strong>
                            </div>
                            <div class="col-xs-2">
                                <strong>Tipo de Prueba</strong>
                            </div>
                            <div class="col-xs-2">
                            </div>
                            <div class="col-xs-3">
                                <strong>Resultados</strong>
                            </div>
                            <div class="col-xs-3">
                                <strong>Momento</strong>
                            </div>
                        </div>
                        <div class="row list-group-item">
                            <div class="col-xs-2">
                                <div class="input-group">
                                    <input type='text' class="form-control datepicker" name="fecha_trep1" id="fecha_trep1" title="Ingrese la fecha correspondiente" placeholder="Ej.99-99-9999" value="<?php echo $this->fechas_model->modificarFechas($modificar1->fecha_trep1);?>" onKeyPress="return acceptNum(event)" />
                                    <div class="input-group-addon"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></div>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="input-group">
                                    <select name="tipo_trep1" id="tipo_trep1" class="form-control datepicker" title="Elija el tipo de prueba correspondiente">
                                      <option value="">Selecione...</option>
                                      <option value="1" <?php if($modificar1->tipo_trep1 == "1"){?> selected="selected" <?php }?>>Prueba r&aacute;pida/ Prueba dual</option>
                                      <option value="2" <?php if($modificar1->tipo_trep1 == "2"){?> selected="selected" <?php }?>>Otra</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="input-group">
                                    <input name="otra_trep1" type="text" id="otra_trep1" class="form-control" title="Ingrese otra prueba" value="<?php echo $modificar1->otra_trep1;?>" onKeyUp="javascript:this.value=this.value.toUpperCase();" />                                
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="input-group">
                                    <select name="resultados_trep1" id="resultados_trep1" class="form-control" title="Elija el resultado correspondiente">
                                      <option value="">Selecione...</option>
                                      <option value="1" <?php if($modificar1->resultados_trep1 == "1"){?> selected="selected" <?php }?>>Reactivo</option>
                                      <option value="2" <?php if($modificar1->resultados_trep1 == "2"){?> selected="selected" <?php }?>>No reactivo</option>
                                      <option value="3" <?php if($modificar1->resultados_trep1 == "3"){?> selected="selected" <?php }?>>Desconocido</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="input-group">
                                    <select name="momento_trep1" id="momento_trep1" class="form-control" title="Elija el momento correspondiente">
                                      <option value="">Selecione...</option>
                                      <option value="1" <?php if($modificar1->momento_trep1 == "1"){?> selected="selected" <?php }?>>Gestaci&oacute;n</option>
                                      <option value="2" <?php if($modificar1->momento_trep1 == "2"){?> selected="selected" <?php }?>>Parto</option>
                                      <option value="3" <?php if($modificar1->momento_trep1 == "3"){?> selected="selected" <?php }?>>Puerperio</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row list-group-item">
                            <div class="col-xs-2">
                                <div class="input-group">
                                    <input type='text' class="form-control datepicker" name="fecha_trep2" id="fecha_trep2" title="Ingrese la fecha correspondiente" placeholder="Ej.99-99-9999" value="<?php echo $this->fechas_model->modificarFechas($modificar1->fecha_trep2);?>" onKeyPress="return acceptNum(event)" />
                                    <div class="input-group-addon"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></div>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="input-group">
                                    <select name="tipo_trep2" id="tipo_trep2" class="form-control datepicker" title="Elija el tipo de prueba correspondiente">
                                      <option value="">Selecione...</option>
                                      <option value="1" <?php if($modificar1->tipo_trep2 == "1"){?> selected="selected" <?php }?>>Prueba r&aacute;pida/ Prueba dual</option>
                                      <option value="2" <?php if($modificar1->tipo_trep2 == "2"){?> selected="selected" <?php }?>>Otra</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="input-group">
                                    <input name="otra_trep2" type="text" id="otra_trep2" class="form-control" title="Ingrese otra prueba" value="<?php echo $modificar1->otra_trep2;?>" onKeyUp="javascript:this.value=this.value.toUpperCase();" />                                
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="input-group">
                                    <select name="resultados_trep2" id="resultados_trep2" class="form-control" title="Elija el resultado correspondiente">
                                      <option value="">Selecione...</option>
                                      <option value="1" <?php if($modificar1->resultados_trep2 == "1"){?> selected="selected" <?php }?>>Reactivo</option>
                                      <option value="2" <?php if($modificar1->resultados_trep2 == "2"){?> selected="selected" <?php }?>>No reactivo</option>
                                      <option value="3" <?php if($modificar1->resultados_trep2 == "3"){?> selected="selected" <?php }?>>Desconocido</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="input-group">
                                    <select name="momento_trep2" id="momento_trep2" class="form-control" title="Elija el momento correspondiente">
                                      <option value="">Selecione...</option>
                                      <option value="1" <?php if($modificar1->momento_trep2 == "1"){?> selected="selected" <?php }?>>Gestaci&oacute;n</option>
                                      <option value="2" <?php if($modificar1->momento_trep2 == "2"){?> selected="selected" <?php }?>>Parto</option>
                                      <option value="3" <?php if($modificar1->momento_trep2 == "3"){?> selected="selected" <?php }?>>Puerperio</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row list-group-item">
                            <div class="col-xs-8">
                                <strong>10. Durante el embarazo ¿la madre fue apropiadamente tratada?</strong>
                            </div>
                            <div class="col-xs-2">
                                <strong>Contacto(s) sexual(es) tratado(s)</strong>
                            </div>
                            <div class="col-xs-2">
                                <strong>Clasificaci&oacute;n de caso de s&iacute;filis en la gestante</strong>
                            </div>
                        </div>
                        <div class="row list-group-item">
                            <div class="col-xs-2">
                                <div class="input-group">
                                    <select name="tratamiento" id="tratamiento" class="form-control" title="Elija si tuvo tratamiento apropiado">
                                      <option value="">Selecione...</option>
                                      <option value="1" <?php if($modificar1->tratamiento == "1"){?> selected="selected" <?php }?>>Si</option>
                                      <option value="2" <?php if($modificar1->tratamiento == "2"){?> selected="selected" <?php }?>>No</option>
                                      <option value="3" <?php if($modificar1->tratamiento == "3"){?> selected="selected" <?php }?>>Desconocido</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <strong>Indicar el motivo</strong>
                            </div>
                            <div class="col-xs-4">
                                <div class="input-group">
                                    <?php
                                    if($modificar1->motivo_no1 == "1"){
                                        ?>
                                        <input name="motivo_no1" type="checkbox" id="motivo_no1" checked="checked" title="Elija motivo" />&nbsp;&nbsp;<strong>Tratamiento sin penicilina</strong><br />
                                        <?php                  
                                    }else{
                                        ?>
                                        <input name="motivo_no1" type="checkbox" id="motivo_no1" title="Elija motivo" />&nbsp;&nbsp;<strong>Tratamiento sin penicilina</strong><br />
                                        <?php                  
                                    }
                                    ?>
                                    <?php
                                    if($modificar1->motivo_no2 == "1"){
                                        ?>
                                        <input name="motivo_no2" type="checkbox" id="motivo_no2" checked="checked" title="Elija motivo" />&nbsp;&nbsp;<strong>Tratamiento durante los 30 d&iacute;as previos al parto</strong><br />
                                        <?php                  
                                    }else{
                                        ?>
                                        <input name="motivo_no2" type="checkbox" id="motivo_no2" title="Elija motivo" />&nbsp;&nbsp;<strong>Tratamiento durante los 30 d&iacute;as previos al parto</strong><br />
                                        <?php                  
                                    }
                                    ?>
                                    <?php
                                    if($modificar1->motivo_no3 == "1"){
                                        ?>
                                        <input name="motivo_no3" type="checkbox" id="motivo_no3" checked="checked" title="Elija motivo" />&nbsp;&nbsp;<strong>No inicio durante la gestaci&oacute;n</strong><br />
                                        <?php                  
                                    }else{
                                        ?>
                                        <input name="motivo_no3" type="checkbox" id="motivo_no3" title="Elija motivo" />&nbsp;&nbsp;<strong>No inicio durante la gestaci&oacute;n</strong><br />
                                        <?php                  
                                    }
                                    ?>
                                    <?php
                                    if($modificar1->motivo_no4 == "1"){
                                        ?>
                                        <input name="motivo_no4" type="checkbox" id="motivo_no4" checked="checked" title="Elija motivo" />&nbsp;&nbsp;<strong>Tratamiento incompleto (1 ó 2 dosis)</strong>
                                        <?php                  
                                    }else{
                                        ?>
                                        <input name="motivo_no4" type="checkbox" id="motivo_no4" title="Elija motivo" />&nbsp;&nbsp;<strong>Tratamiento incompleto (1 ó 2 dosis)</strong>
                                        <?php                  
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="input-group">
                                    <select name="contacto" id="contacto" class="form-control" title="Elija el resultado correspondiente">
                                      <option value="">Selecione...</option>
                                      <option value="1" <?php if($modificar1->contacto == "1"){?> selected="selected" <?php }?>>Si</option>
                                      <option value="2" <?php if($modificar1->contacto == "3"){?> selected="selected" <?php }?>>No</option>
                                      <option value="3" <?php if($modificar1->contacto == "3"){?> selected="selected" <?php }?>>Desconocido</option>
                                    </select>
                                    <input name="contactos" type="text" id="contactos" class="form-control" title="Ingrese el n&uacute;mero de contactos" value="<?php echo $modificar1->contactos;?>" />                                
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="input-group">
                                    <select name="estadio" id="estadio" class="form-control" title="Elija el momento correspondiente">
                                      <option value="">Selecione...</option>
                                      <option value="1" <?php if($modificar1->estadio == "1"){?> selected="selected" <?php }?>>Probable</option>
                                      <option value="2" <?php if($modificar1->estadio == "2"){?> selected="selected" <?php }?>>Confirmado</option>
                                      <option value="3" <?php if($modificar1->estadio == "3"){?> selected="selected" <?php }?>>Descartado (Falso Positivo)</option>
                                      <option value="4" <?php if($modificar1->estadio == "4"){?> selected="selected" <?php }?>>Descartado (S&iacute;filis Memoria)</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
				}
				?>

                <!--/////////////////////////////-->
                
                <div role="tabpanel"  class="tab-pane fade" id="congenita">
                    <div class="row list-group-item">
                        <div class="col-xs-12">
                            <strong>SIFILIS CONGENITA</strong>
                        </div>
                    </div>
                    <div class="row list-group-item">
                        <div class="col-xs-2">
                            <strong>13. Culminaci&oacute;n del embarazo/parto</strong>
                        </div>
                        <div class="col-xs-8">
                            <strong>14. Lugar del Parto/Culminaci&oacute;n del embarazo</strong>
                        </div>
                        <div class="col-xs-2">
                            <strong>15. Estado Vital</strong>
                        </div>
                    </div>
                    <div class="row list-group-item">
                        <div class="col-xs-2">
                            <div class="input-group">
                                <input type='text' class="form-control datepicker" name="fecha_par" id="fecha_par" title="Ingrese la fecha correspondiente" placeholder="Ej.99-99-9999" value="<?php echo $this->fechas_model->modificarFechas($modificar2->fecha_par);?>" onKeyPress="return acceptNum(event)" />
                                <div class="input-group-addon"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></div>
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <?php
                            $subreg[''] = "Seleccione...";
                            foreach($this->mantenimiento_model->buscarDiresas() as $diresa){
                                $subreg[$diresa->codigo] = $diresa->nombre;
                            }
                            
                            echo form_dropdown('diresa', $subreg, $establec_cong->subregion, 'id="diresa" class="form-control"');
                            ?>
                        </div>
                        <div class="col-xs-2">
                            <?php
                            $red[''] = "Seleccione...";
                            echo form_dropdown('redes', $red, $establec_cong->red, 'id="redes" class="form-control"');
                            ?>
                        </div>
                        <div class="col-xs-2">
                            <?php
                            $mred[''] = "Seleccione...";
                            echo form_dropdown('microred', $mred, $establec_cong->microred, 'id="microred" class="form-control"');
                            ?>
                        </div>
                        <div class="col-xs-2">
                            <?php
                            $est[''] = "Seleccione...";
                            echo form_dropdown('establec', $est, $modificar2->establec_par, 'id="establec" class="form-control"');
                            ?>
                        </div>
                        <div class="col-xs-2">
                            <select name="estado_vital" id="estado_vital" class="form-control" title="Elija el momento correspondiente">
                              <option value="">Seleccione...</option>
                              <option value="1" <?php if($modificar2->estado_vital == "1"){?> selected="selected" <?php }?>>Vivo</option>
                              <option value="2" <?php if($modificar2->estado_vital == "2"){?> selected="selected" <?php }?>>Nació vivo, luego falleci&oacute;</option>
                              <option value="3" <?php if($modificar2->estado_vital == "3"){?> selected="selected" <?php }?>>Mortinato</option>
                              <option value="4" <?php if($modificar2->estado_vital == "4"){?> selected="selected" <?php }?>>Aborto</option>
                            </select>
                        </div>
                        <div class="col-xs-2">
                            <?php
                            if($modificar2->desconocido_par == "1"){
                                ?>
                                <input name="desconocido_par" type="checkbox" id="desconocido_par" checked="checked" title="Desconoce la fecha de parto/culminaci&oacute;n de embarazo" />&nbsp;&nbsp;<strong>Desconocido</strong></td>
                                <?php                  
                            }else{
                                ?>
                                <input name="desconocido_par" type="checkbox" id="desconocido_par" title="Desconoce la fecha de parto/culminaci&oacute;n de embarazo" />&nbsp;&nbsp;<strong>Desconocido</strong></td>
                                <?php                  
                            }
                            ?>
                        </div>
                        <div class="col-xs-2">
                            <input name="nivel_estab" type="text" id="nivel_estab" class="form-control" value="<?php echo $establec_cong->categoria;?>"readonly />
                        </div>
                        <div class="col-xs-2">
                            <?php
                            if($modificar2->domicilio_par == "1"){
                                ?>
                                <input name="domicilio" type="checkbox" id="domicilio" checked="checked" title="Lugar de parto/culminaci&oacute;n de embarazo" />&nbsp;&nbsp;<strong>Domicilio</strong></td>
                                <?php                  
                            }else{
                                ?>
                                <input name="domicilio" type="checkbox" id="domicilio" title="Lugar de parto/culminaci&oacute;n de embarazo" />&nbsp;&nbsp;<strong>Domicilio</strong></td>
                                <?php                  
                            }
                            ?>
                        </div>
                    </div>
                    <div class="row list-group-item">
                        <div class="col-xs-2">
                            <strong>16. Fecha de fallecimiento</strong>
                        </div>
                        <div class="col-xs-2">
                            <strong>17. Peso al nacimiento</strong>
                        </div>
                        <div class="col-xs-2">
                            <strong>18. Edad Gestacional</strong>
                        </div>
                    </div>
                    <div class="row list-group-item">
                        <div class="col-xs-2">
                            <div class="input-group">
                                <input type='text' class="form-control datepicker" name="fecha_fac" id="fecha_fac" title="Ingrese la fecha correspondiente" placeholder="Ej.99-99-9999" value="<?php echo $this->fechas_model->modificarFechas($modificar2->fecha_fac);?>" onKeyPress="return acceptNum(event)" />
                                <div class="input-group-addon"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></div>
                            </div>
                            <?php
                            if($modificar2->desconocido_fac == "1"){
                                ?>
                                <input name="desconocido_fac" type="checkbox" id="desconocido_fac" checked="checked" title="Desconoce la fecha de fallecimiento" />&nbsp;&nbsp;<strong>Desconocido</strong></td>
                                <?php                  
                            }else{
                                ?>
                                <input name="desconocido_fac" type="checkbox" id="desconocido_fac" title="Desconoce la fecha de fallecimiento" />&nbsp;&nbsp;<strong>Desconocido</strong></td>
                                <?php                  
                            }
                            ?>
                        </div>
                        <div class="col-xs-2">
                            <div class="input-group">
                                <input name="peso_nac" type="text" id="peso_nac" class="form-control" title="Ingrese el peso al nacer" value="<?php echo $modificar2->peso_nac;?>" placeholder="Gramos" />                               
                                <?php
                                if($modificar2->desconocido_nac == "1"){
                                    ?>
                                    <input name="desconocido_nac" type="checkbox" id="desconocido_fac" checked="checked" title="Desconoce el peso de nacimiento" />&nbsp;&nbsp;<strong>Desconocido</strong></td>
                                    <?php                  
                                }else{
                                    ?>
                                    <input name="desconocido_nac" type="checkbox" id="desconocido_fac" title="Desconoce el peso de nacimiento" />&nbsp;&nbsp;<strong>Desconocido</strong></td>
                                    <?php                  
                                }
                                ?>
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <div class="input-group">
                                <input name="edad_ges_con" type="text" id="edad_ges_con" class="form-control" title="Ingrese la edad gestacional" value="<?php echo $modificar2->edad_ges;?>" placeholder="Semanas" />                                
                                <?php
                                if($modificar2->desconocido_edad == "1"){
                                    ?>
                                    <input name="desconocido_ges" type="checkbox" id="desconocido_ges" checked="checked" title="Desconoce la edad gestacional" />&nbsp;&nbsp;<strong>Desconocido</strong></td>
                                    <?php                  
                                }else{
                                    ?>
                                    <input name="desconocido_ges" type="checkbox" id="desconocido_ges" title="Desconoce la edad gestacional" />&nbsp;&nbsp;<strong>Desconocido</strong></td>
                                    <?php                  
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="row list-group-item">
                        <div class="col-xs-12">
                            <strong>19. Indique cual o cuales criterios cumple el producto de la gestación para ser considerado caso de sífilis congénita: (Marque todas las que apliquen)</strong>
                        </div>
                    </div>
                    <div class="row list-group-item">
                        <div class="col-xs-12">
                            <div class="input-group">
                                <?php
                                if($modificar2->criterio1 == "1"){
                                    ?>
                                    <input name="criterio1" type="checkbox" id="criterio1" title="Elija de ser el caso" checked="checked" />&nbsp;&nbsp;<strong>Madre con s&iacute;filis, que no recibi&oacute; tratamiento o fue tratada inadecuadamente.</strong></td>
                                    <?php                  
                                }else{
                                    ?>
                                    <input name="criterio1" type="checkbox" id="criterio1" title="Elija de ser el caso" />&nbsp;&nbsp;<strong>Madre con s&iacute;filis, que no recibi&oacute; tratamiento o fue tratada inadecuadamente.</strong></td>
                                    <?php                  
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="row list-group-item">
                        <div class="col-xs-12">
                            <div class="input-group">
                                <?php
                                if($modificar2->criterio2 == "1"){
                                    ?>
                                    <input name="criterio2" type="checkbox" id="criterio2" checked="checked" title="Elija de ser el caso" />&nbsp;&nbsp;<strong>Resultado de t&iacute;tulos de an&aacute;lisis no trepon&eacute;micos cuatro veces mayor que los t&iacute;tulos de la madre:</strong></td>
                                    <?php                  
                                }else{
                                    ?>
                                    <input name="criterio2" type="checkbox" id="criterio2" title="Elija de ser el caso" />&nbsp;&nbsp;<strong>Resultado de t&iacute;tulos de an&aacute;lisis no trepon&eacute;micos cuatro veces mayor que los t&iacute;tulos de la madre:</strong></td>
                                    <?php                  
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="row list-group-item">
                        <div class="col-xs-2">
                            <strong>Fecha de los test</strong>
                        </div>
                        <div class="col-xs-3">
                        </div>
                        <div class="col-xs-3">
                            <strong>T&iacute;tulos de la Madre</strong>
                        </div>
                        <div class="col-xs-3">
                            <strong>T&iacute;tulo del ni&ntilde;o</strong>
                        </div>
                    </div>
                    <div class="row list-group-item">
                        <div class="col-xs-2">
                            <div class="input-group">
                                <input name="fecha_test" type="text" id="fecha_test" class="form-control" title="Ingrese la fecha correspondiente" value="<?php echo $this->fechas_model->modificarFechas($modificar2->fecha_test);?>" size="12" placeholder="Ej.99-99-9999" />
                                <div class="input-group-addon"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></div>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="input-group">
                                <?php
                                if($modificar2->desconocido == "1"){
                                    ?>
                                    <input name="desconocido" type="checkbox" id="desconocido" checked="checked" title="Elija de ser el caso" />&nbsp;&nbsp;<strong>Desconocido</strong></td>
                                    <?php                  
                                }else{
                                    ?>
                                    <input name="desconocido" type="checkbox" id="desconocido" title="Elija de ser el caso" />&nbsp;&nbsp;<strong>Desconocido</strong></td>
                                    <?php                  
                                }
                                ?>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="input-group">
                                <input name="titulo_madre" type="text" id="titulo_madre" class="form-control" title="Ingrese los t&iacute;tulos de la madre" value="<?php echo $modificar2->titulo_madre;?>" />                                
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="input-group">
                                <input name="titulo_hijo" type="text" id="titulo_hijo" class="form-control" title="Ingrese los t&iacute;tulos del ni&ntilde;o" value="<?php echo $modificar2->titulo_hijo;?>" />
                            </div>
                        </div>
                    </div>
                    <div class="row list-group-item">
                        <div class="col-xs-12">
                            <div class="input-group">
                                <?php
                                if($modificar2->criterio3 == "1"){
                                    ?>
                                    <input name="criterio3" type="checkbox" id="criterio3" checked="checked" title="Elija de ser el caso" />&nbsp;&nbsp;<strong>Ni&ntilde;o con manifestaciones cl&iacute;nicas sugestivas de s&iacute;filis cong&eacute;nita (al examen f&iacute;sico o evidencia radiogr&aacute;fica)</strong></td>
                                    <?php                  
                                }else{
                                    ?>
                                    <input name="criterio3" type="checkbox" id="criterio3" title="Elija de ser el caso" />&nbsp;&nbsp;<strong>Ni&ntilde;o con manifestaciones cl&iacute;nicas sugestivas de s&iacute;filis cong&eacute;nita (al examen f&iacute;sico o evidencia radiogr&aacute;fica)</strong></td>
                                    <?php                  
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="row list-group-item">
                        <div class="col-xs-12">
                            <div class="input-group">
                                <?php
                                if($modificar2->criterio4 == "1"){
                                    ?>
                                    <input name="criterio4" type="checkbox" id="criterio4" checked="checked" title="Elija de ser el caso" />&nbsp;&nbsp;<strong>Demostraci&oacute;n de treponema pallidum en lesiones, placenta, cord&oacute;n umbilical o material de autopsia</strong></td>
                                    <?php                  
                                }else{
                                    ?>
                                    <input name="criterio4" type="checkbox" id="criterio4" title="Elija de ser el caso" />&nbsp;&nbsp;<strong>Demostraci&oacute;n de treponema pallidum en lesiones, placenta, cord&oacute;n umbilical o material de autopsia</strong></td>
                                    <?php                  
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="row list-group-item">
                        <div class="col-xs-12">
                            <div class="input-group">
                                <?php
                                if($modificar2->criterio5 == "1"){
                                    ?>
                                    <input name="criterio5" type="checkbox" id="criterio5" checked="checked" title="Elija de ser el caso" />&nbsp;&nbsp;<strong>Ni&ntilde;o mayor de 2 a&ntilde;os de edad; con signos cl&iacute;nicos de s&iacute;filis secundaria en el que se ha descartado el antecedente de abuso sexual o contacto sexual</strong></td>
                                    <?php                  
                                }else{
                                    ?>
                                    <input name="criterio5" type="checkbox" id="criterio5" title="Elija de ser el caso" />&nbsp;&nbsp;<strong>Ni&ntilde;o mayor de 2 a&ntilde;os de edad; con signos cl&iacute;nicos de s&iacute;filis secundaria en el que se ha descartado el antecedente de abuso sexual o contacto sexual</strong></td>
                                    <?php                  
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="row list-group-item">
                        <div class="col-xs-4">
                            <strong>¿Fue el ni&ntilde;o tratado?</strong>
                        </div>
                        <div class="col-xs-4">
                            <strong>Clasificaci&oacute;n final del ni&ntilde;o, mortinato o aborto</strong>
                        </div>
                        <div class="col-xs-4">
                            <strong>Nombre y Apellido del Notificador</strong>
                        </div>
                    </div>
                    <div class="row list-group-item">
                        <div class="col-xs-4">
                            <div class="input-group">
                                <select name="tratado" id="tratado" class="form-control" title="Elija el momento correspondiente">
                                  <option value="">Seleccione...</option>
                                  <option value="1" <?php if($modificar2->tratado == "1"){?> selected="selected" <?php }?>>Si, con penicilina G s&oacute;dica procainica por >= 10 d&iacute;as</option>
                                  <option value="2" <?php if($modificar2->tratado == "2"){?> selected="selected" <?php }?>>Si, con tratamiento penicilina benzat&iacute;nica x 1 dosis</option>
                                  <option value="3" <?php if($modificar2->tratado == "3"){?> selected="selected" <?php }?>>Si, con otro tratamiento</option>
                                  <option value="4" <?php if($modificar2->tratado == "4"){?> selected="selected" <?php }?>>No recibi&oacute; tratamiento</option>
                                  <option value="5" <?php if($modificar2->tratado == "5"){?> selected="selected" <?php }?>>Desconocido</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="input-group">
                                <select name="clasificacion" id="clasificacion" class="form-control" title="Elija el momento correspondiente">
                                  <option value="">Seleccione...</option>
                                  <option value="1" <?php if($modificar2->clasificacion == "1"){?> selected="selected" <?php }?>>S&iacute;filis cong&eacute;nita</option>
                                  <option value="2" <?php if($modificar2->clasificacion == "2"){?> selected="selected" <?php }?>>Ni&ntilde;o expuesto a s&iacute;filis, no infectado</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="input-group">
                                <input name="notificador" type="text" id="notificador" class="form-control" title="apellidos y nombres del responsable de la notificaci&oacute;n" value="<?php echo $modificar->notificador?>" onKeyUp="javascript:this.value=this.value.toUpperCase();" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>                
        </div>
        <div class="panel-footer col-xs-12 text-right">
            <a class="btn btn-primary ladda-button" href="<?php echo site_url('sifilisMaterna/listarSifilis');?>" role="button">Listar Fichas</a>
            <button type="submit" class="btn btn-primary ladda-button">Actualizar Datos</button>
            <a class="btn btn-primary ladda-button" href="<?php echo site_url('fichas');?>" role="button">Cancelar</a>
            <input type="hidden" name="claveNoti" id="claveNoti" value="<?php echo $modificar->clave?>" />
            <input type="hidden" id="id" name="id" value="<?php echo $registro;?>" />
            <input type="hidden" id="estab" name="estab" value="<?php echo $datos->e_salud;?>" />
            <input type="hidden" id="dir" name="dir" value="<?php echo $datos->sub_reg_nt;?>" />
            <input type="hidden" id="rd" name="rd" value="<?php echo $datos->red;?>" />
            <input type="hidden" id="mrd" name="mrd" value="<?php echo $datos->microred;?>" />
            <input type="hidden" id="diagnostico" name="diagnostico" value="<?php echo $datos->diagnostic;?>" />
        </div>
    </div>
</div>
<?php
    echo form_close();
?>
</body>
</html>