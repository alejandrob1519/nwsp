<?php
if($this->session->flashdata('exito') != ''){
	?>
	<div class="exito"><?php echo $this->session->flashdata('exito'); ?></div>
	<?php
}
if($this->session->flashdata('error') != ''){
	?>
	<div class="errores"><?php echo $this->session->flashdata('error'); ?></div>
	<?php
}
if($this->session->flashdata('info') != ''){
	?>
	<div class="info"><?php echo $this->session->flashdata('info'); ?></div>
<?php } ?>

<?php
   $atributos = array('id'=>'form1', 'name'=>'form1');
   echo form_open(null, $atributos);
?>
<div id="dialog-message" title="Mensaje Importante!"></div>

<div class="container">

	<div class="row">

        <div class="row clearfix">
            <div class="col-sm-3 col-md-3 col-lg-3">
               <!-- <label>Nro Ficha: <?php echo $fichanum; ?></label> -->
            </div>

			<div class="form-group">
				<div class="segmented-control col-xs-12 col-sm-9 col-lg-9" style="color: #80C4F5">
					<input type="radio" name="fuen_finc" id="sb-0" value="" >
					<input type="radio" name="fuen_finc" id="sb-1"value="1">
					<input type="radio" name="fuen_finc" id="sb-2"value="2">
					<input type="radio" name="fuen_finc" id="sb-3"value="3">
					<label for="sb-0" data-value="I. FUENTE DE FINANCIAMIENTO:">I. FUENTE DE FINANCIAMIENTO:</label>
					<label for="sb-1" data-value="SOAT">SOAT</label>
					<label for="sb-2" data-value="MTC">MTC</label>
					<label for="sb-3" data-value="PARTICULAR">PARTICULAR</label>
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-3 col-lg-3">
					<label for="diresa_not">Diresa</label>
					  <div class="form-group">
						  <?php
						  echo form_dropdown('cod_dir', $diresa, set_value('cod_dir'), 'id="diresa_not" class="form-control" ');
						  ?>
					  </div>
				</div>
				<div class="col-sm-3 col-lg-3">
					<label for="redes_les">Red</label>
					<div class="form-group">
						<?php
						echo form_dropdown('redes_not', $redes, set_value('redes_not'), 'id="redes_not" class="form-control" ');
						?>
					</div>
				</div>
				<div class="col-sm-3 col-lg-3">
					<label for="microred_not">Microred</label>
					<div class="form-group">
						<?php
						echo form_dropdown('microred_not', $microred, set_value('microred_not'), 'id="microred_not" class="form-control" ');
						?>
					</div>
				</div>
				<div class="col-sm-3 col-lg-3" id="eess_notificante">
					<label for="cod_eess">eess</label>
					<div class="form-group">
						<?php
						echo form_dropdown('cod_eess', $establec, set_value('cod_eess'), 'id="cod_eess" class="form-control"');
						?>
					</div>
				</div>
			</div>
        </div>
		<br/>


		<!-- CREANDO LAS PESTAÑAS -->
		<ul class="nav nav-tabs nav-justified" id="tabsFicha">
			<li class="active"><a href="#tabs-1" role="tablist" data-toggle="tab"><i class="fa fa-user fa-lg"></i> II. DATOS RELACIONADOS AL LESIONADO</a></li>
			<li><a href="#tabs-2" data-toggle="tab"><i class="fa fa-map-marker fa-lg"></i> III. DATOS RELACIONADOS AL ACCIDENTE</a></li>
			<li><a href="#tabs-3" data-toggle="tab"><i class="fa fa-bus fa-lg"></i> IV. y V. DATOS DEL CONDUCTOR Y VEHICULO</a></li>
		</ul>



		<!-- CREANDO CONTENEDORES PARA LAS PESTAÑAS -->
		<div class="tab-content">

			<!-- PESTAÑA "II Datos relacionados al lesionado" -->
			<div class="tab-pane fade in active" id="tabs-1">

				<h5><strong>&nbsp</strong></h5>
				<div id="bloque1">
					<div class="row list-group-item">
						<div class="row clearfix">
							<div class="col-sm-4 col-md-3 col-lg-3">
								<label for="hce">1.# HC Emergencia</label>
								<div class="form-group">
								  <input type="text" name="hce" id="hce" placeholder="Nro Historia emerg." class="form-control">
								</div>
							</div>
							<div class="col-sm-4 col-md-3 col-lg-3">
								<label for="hch">2.# HC Hospitalizado</label>
								<div class="form-group">
								  <input type="text" name="hch" id="hch" placeholder="Nro Historia hosp." class="form-control">
								</div>
							</div>
							<div class="col-sm-4 col-md-3 col-lg-3">
								<label> </label>
								<div class="col-middle">
									<label class="checkbox-inline">
									<input type="checkbox" name="ref_es" id="ref_es" value="1" onchange="javascript:mostrar_contenido()" onClick="habilita_elemento()" />
									2.1 El Paciente es Referido?
									</label>
								</div>
							</div>
						</div>
					</div>

					<div id="contenido_oculto" style="display: none;">
						<h5><strong>REFERENCIA DEL PACIENTE</strong></h5>
						<div class="row list-group-item" style="background: #FBDF9F;">
							<div class="col-sm-3 col-lg-3">
								<label for="diresa_les">Diresa</label>
								<div class="form-group">
									<?php
									echo form_dropdown('', $diresaNac, set_value('diresa_les'), 'id="diresa_les" class="form-control" disabled');
									?>
								</div>
							</div>
							<div class="col-sm-3 col-lg-3">
								<label for="redes_les">Red</label>
								<div class="form-group">
									<?php //$redesNac[''] = 'Seleccione.. ';
									$redesNac = array('' => 'Seleccione.. ');
									echo form_dropdown('', $redesNac, set_value('redes_les'), 'id="redes_les" class="form-control" disabled');
									?>
								</div>
							</div>
							<div class="col-sm-3 col-lg-3">
								<label for="microred_les">Microred</label>
								<div class="form-group">
									<?php $microredNac = array('' => 'Seleccione.. ');
									echo form_dropdown('', $microredNac, set_value('microred_les'), 'id="microred_les" class="form-control" disabled');
									?>
								</div>
						   </div>
						   <div class="col-sm-3 col-lg-3">
								<label for="referi">eess</label>
								<div class="form-group">
									<?php $establecNac = array('' => 'Seleccione.. ');
									echo form_dropdown('referi', $establecNac, set_value('referi'), 'id="referi" class="form-control" disabled');
									?>
								</div>
						   </div>
						</div>
					</div>
				</div>

				<h5><strong>DATOS DEL LESIONADO</strong></h5>

				<div class="row list-group-item">
					<div class="row clearfix">
						<div class="col-sm-6 col-lg-3">
							<label for="ap_nm1">3.1 Apellido paterno</label>
							<div class="form-group">
							  <input type="text" name="ap_nm1" id="ap_nm1" class="form-control" placeholder="Apellido paterno">
							</div>

						</div>

						<div class="col-sm-6 col-lg-3">
							<label for="ap_nm2">3.2 Apellido materno</label>
							<div class="form-group">
							  <input type="text" name="ap_nm2" id="ap_nm2" class="form-control" placeholder="Apellido materno">
							</div>

						</div>
						<div class="col-sm-6 col-lg-3">
							<label for="nom_les">3.3 Nombres</label>
							<div class="form-group">
							  <input type="text" name="nom_les" id="nom_les" class="form-control" placeholder="Nombres">
							</div>

						</div>
						<div class="col-sm-6 col-lg-3">
							<label for="dni" class="control-label">4.dni</label>
							<div class="form-group">
							<input type="text" name="dni" id="dni" class="form-control" placeholder="dni" maxlength="8" onKeyPress="return acceptNum(event)">
							</div>
						</div>
					</div>

					<div class="row clearfix" >
						<div class="col-xs-6 col-sm-4 col-lg-2">
							<label for="edad">5.Edad</label>
							<div class="form-group">
								<input type="text" name="edad" id="edad" class="form-control" placeholder="edad" maxlength="3" onKeyPress="return acceptNum(event)">
							</div>
						</div>
						<div class="col-xs-6 col-sm-4 col-lg-2">
							<label for="tipo_edad">5.1 Tipo edad</label>
							<div class="form-group">
								<?php
								$tipo_edad = array(''=>'Seleccione...','A'=>'Años','M'=>'Meses','D'=>'Dias');
								echo form_dropdown('tipo_edad', $tipo_edad, set_value('tipo_edad'), 'id="tipo_edad" class="form-control"');
								?>
							</div>
						</div>
						<div class="col-xs-12 col-sm-4 col-lg-2">
							<label for="sexo">6.Sexo</label>
							<div class="form-group">
								<?php
								$sexo = array(''=>'Seleccione...','M'=>'Masculino','F'=>'Femenino');
								echo form_dropdown('sexo', $sexo, set_value('sexo'), 'id="sexo" class="form-control"');
								?>
							</div>
						</div>
						<div class="col-xs-12 col-sm-12 col-lg-6">
							<label for="direccion">7. Direccion del lesionado</label>
							  <div class="form-group">
								<input type="text" name="direccion" id="direccion" placeholder="7.1 Jr/Av/Calle/localidad" class="form-control">
							  </div>
						</div>
					</div>

					<div class="row clearfix">
						<div class="col-xs-6 col-sm-4 col-lg-2">
							<label for="departamento">7.4 Departamento</label>
							<div class="form-group">
								<?php echo form_error('depar', '<div class="warning">', '</div>');
								echo form_dropdown('depar', $departamento, set_value('departamento'), 'id="departamento" class="form-control"');
								?>
							</div>
						</div>
						<div class="col-xs-6 col-sm-4 col-lg-2">
							  <label for="provincia">7.3 Provincia</label>
							<div class="form-group">
								<?php echo form_error('prov', '<div class="warning">', '</div>');
								echo form_dropdown('prov', $provincia, set_value('provincia'), 'id="provincia" class="form-control"');
								?>
							</div>
						</div>
						<div class="col-xs-12 col-sm-4 col-lg-2">
							  <label for="distrito">7.2 Distrito</label>
							  <div class="form-group">
								<?php echo form_error('dis', '<div class="warning">', '</div>');
								echo form_dropdown('dis', $distrito, set_value('distrito'), 'id="distrito" class="form-control"');
								?>
							  </div>
						</div>
						<div class="col-xs-12 col-sm-4 col-lg-3 fecha_ingreso_lesion">
							<label for="fecha_ingreso_lesion">8.Fecha ingreso al eess</label>
							<div class="input-group">
								<div class="form-group">
								  <input type='text' class="form-control datepicker" name="ing_eess" id="fecha_ingreso_lesion" title="Digite la fecha de notificaci&oacute;n del caso" placeholder="dd-mm-aaaa" value="<?php echo set_value('fecha_ingreso_lesion')?>" onKeyPress="return acceptNum(event)" />
								</div>
								<div class="input-group-addon"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-4 col-lg-3">
							<label for="hora">9.Hora</label>
							<div class="form-group">
								<div class="input-group clockpicker" data-autoclose="true">
									<input type="text" name="hora" id="hora" class="form-control" placeholder="00:00">
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-time"></span>
									</span>
									<span class="input-group-addon" id="sizing-addon1">horas/min</span>
								</div>
							</div>
						</div>
					</div>
				</div>

				<h5><strong>10. DIAGNOSTICO MEDICO</strong></h5>

				<div class="row list-group-item">
					<div class="row clearfix">
						<div class="col-xs-4 col-sm-2 col-lg-2">
							<label for="capitulo1">Capitulo</label>
							<input type="text" id="capitulo1" class="form-control" readonly>
						</div>
						<div class="col-xs-4 col-sm-2 col-lg-2">
							<label for="grupo1">Grupo</label>
							<input type="text" id="grupo1" class="form-control" readonly>
						</div>
						<div class="col-xs-4 col-sm-2 col-lg-2">
							<label for="categoria1">Categoria</label>
							<input type="text" id="categoria1" class="form-control" readonly>
						</div>
						<div class="col-xs-8 col-sm-4 col-lg-4">
							<label for="diagno1">10.1 Diagnostico</label>
							<div class="form-group">
								<input type="text" name="diagno1" id="diagno1" class="form-control " placeholder="Ingrese el CIEX o Diagnostico" data-toggle="tooltip" title="Escribe el codigo CIEX o el nombre de diagnostico">
							</div>
						</div>
						<div class="col-xs-4 col-sm-2 col-lg-2">
							<label for="diagno1">10.2 Codigo</label>
							<input name="dx1" type="text" class="form-control" id="ciex1" readonly="readonly"  />
					   </div>
					</div>

					<div class="row clearfix">
						<div class="col-xs-4 col-sm-2 col-lg-2">
							  <input type="text" id="capitulo2" class="form-control" readonly>
						</div>
						<div class="col-xs-4 col-sm-2 col-lg-2">
							  <input type="text" id="grupo2" class="form-control" readonly>
						</div>
						<div class="col-xs-4 col-sm-2 col-lg-2">
							  <input type="text" id="categoria2" class="form-control" readonly>
						</div>
						<div class="col-xs-8 col-sm-4 col-lg-4">
							<input type="text" id="diagno2" class="form-control" placeholder="Ingrese el CIEX o Diagnostico" data-toggle="tooltip" title="Escribe el codigo CIEX o el nombre de diagnostico">
						</div>
						<div class="col-xs-4 col-sm-2 col-lg-2">
							<input name="dx2" type="text" class="form-control" id="ciex2" readonly="readonly"  />
						</div>
					</div>

					<div class="row clearfix">
						<div class="col-xs-4 col-sm-2 col-lg-2">
							<input type="text" id="capitulo3" class="form-control" readonly>
						</div>
						<div class="col-xs-4 col-sm-2 col-lg-2">
							<input type="text" id="grupo3" class="form-control" readonly>
						</div>
						<div class="col-xs-4 col-sm-2 col-lg-2">
							<input type="text" id="categoria3" class="form-control" readonly>
						</div>
						<div class="col-xs-8 col-sm-4 col-lg-4">
							<input type="text" id="diagno3" class="form-control" placeholder="Ingrese el CIEX o Diagnostico" data-toggle="tooltip" title="Escribe el codigo CIEX o el nombre de diagnostico">
						</div>
						<div class="col-xs-4 col-sm-2 col-lg-2">
							<input name="dx3" type="text" class="form-control" id="ciex3" readonly="readonly"  />
						</div>
					</div>

					<div class="row clearfix">
						<div class="col-xs-12 col-sm-3 col-lg-3">
							<label for="fecha_egreso_lesion">11.Fecha egreso del eess</label>
							<div class="input-group">
								<div class="form-group">
									<input type='text' class="form-control datepicker" name="fech_egre" id="fecha_egreso_lesion" placeholder="dd-mm-aaaa" value="<?php echo set_value('fecha_egreso_lesion')?>" onKeyPress="return acceptNum(event)" />
								</div>
								<div class="input-group-addon">
									<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-6 col-lg-4">
							
									<label>12.Condicion de egreso</label>
							
							<div>
								<label class="radio-inline">
									<input type="radio" name="cond_egr" id="inlineRadio121" value="1" onClick="mostrar_contenido()"> 12.1 Alta
								</label>
								<label class="radio-inline">
									<input type="radio" name="cond_egr" id="inlineRadio122" value="2" onClick="mostrar_contenido()"> 12.2 Fallecido
								</label>
								<label class="radio-inline">
									<input type="radio" name="cond_egr" id="inlineRadio123" value="3" onclick="mostrar_contenido()"> 12.3 Referido
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-sm-3 col-lg-5">
							
								<label>12.4. Requiere rehabilitacion</label>
							
							<div>
								<label class="radio-inline">
									<input type="radio" name="rehab" id="inlineRadio1241" value="1"> Si
								</label>
								<label class="radio-inline">
									<input type="radio" name="rehab" id="inlineRadio1242" value="2"> No
								</label>
							</div>
						</div>
					</div>
				</div>

				<div class="row list-group-item" id="conten_ref_oculto" style="display: none; background: #FBDF9F">
					<h5>Referido a:</h5>
					<div class="col-sm-3 col-lg-3">
						<label for="diresa_ref_destino">Diresa</label>
						<div class="form-group">
							<?php
							echo form_dropdown('', $diresaNac, set_value('diresa_ref_destino'), 'id="diresa_ref_destino" class="form-control"');
							?>
						</div>
					</div>
					<div class="col-sm-3 col-lg-3">
						<label for="redes_ref_destino">Red</label>
						<div class="form-group">
							<?php //$redesNac[''] = 'Seleccione.. ';
							$redesNac = array('' => 'Seleccione.. ');
							echo form_dropdown('', $redesNac, set_value('redes_ref_destino'), 'id="redes_ref_destino" class="form-control"');
							?>
						</div>
					</div>
					<div class="col-sm-3 col-lg-3">
						<label for="microred_ref_destino">Microred</label>
						<div class="form-group">
							<?php $microredNac = array('' => 'Seleccione.. ');
							echo form_dropdown('', $microredNac, set_value('microred_ref_destino'), 'id="microred_ref_destino" class="form-control"');
							?>
						</div>
					</div>
					<div class="col-sm-3 col-lg-3">
						<label for="refer">eess</label>
						<div class="form-group">
							<?php $establecNac = array('' => 'Seleccione.. ');
							echo form_dropdown('refer', $establecNac, set_value('refer'), 'id="refer" class="form-control"');
							?>
						</div>
					</div>
				</div>

				<br/>
				<div class="row">
					<div class="col-xs-offset-6 col-sm-offset-9 col-md-offset-9 col-lg-offset-10">
						<button type="submit" class="btn btn-primary ladda-button" data-style="expand-right" disabled="disabled"><span class="ladda-label">GRABAR</span><span class="ladda-spinner"></span><div class="ladda-progress" style="width: 0px;"></div></button>
						<a class="btn btn-primary" href="#" id="btnSiguiente">Siguiente</a>
					</div>
				</div>
			</div>




			<!-- PESTAÑA "III Datos relacionados al accidente" -->
			<div class="tab-pane fade" id="tabs-2">
				<h5><strong>Fecha y lugar del accidente <small> (Buscar en la denúncia policial)</small></strong></h5>
				<div class="row list-group-item">
					<div class="row clearfix">
						  <div class="col-xs-12 col-sm-3 col-lg-3">
							  <label for="fecha_accidente">13.Fecha accidente</label>
									<div class="input-group">
										  <div class="form-group">
											<input type='text' class="form-control datepicker" name="fec_accd" id="fecha_accidente" title="Digite la fecha de notificaci&oacute;n del caso" placeholder="dd-mm-aaaa" value="<?php echo set_value('fecha_accidente')?>" onKeyPress="return acceptNum(event)" />
										  </div>
										<div class="input-group-addon"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></div>
									</div>
						  </div>
						<div class="col-xs-12 col-sm-4 col-lg-3">
							<label for="hor_accid">14.Hora accidente</label>
							<div class="form-group">
								<div class="input-group clockpicker" data-autoclose="true">
									<input type="text"  name="hor_accid" id="hor_accid" class="form-control" placeholder="00:00">
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-time"></span>
									</span>
									<span class="input-group-addon" id="sizing-addon2">horas/min</span>
								</div>
							</div>

						</div>
						<div class="col-xs-12 col-sm-5 col-lg-6">
							<label for="lug_accid">15.1 Lugar del accidente</label>
							<input type="text" name="lug_accid" id="lug_accid" placeholder="Jr/Av/Calle/localidad: Lugar del accidente" class="form-control">
						</div>
					</div>

					<div class="form-group clearfix">
						<div class="col-xs-6 col-sm-6 col-lg-4">
							<label for="departamento_accidente">15.2 Departamento</label>
							<div class="row">
								<?php
								echo form_dropdown('depar_acc', $departamento_accidente, set_value('departamento_accidente'), 'id="departamento_accidente" class="form-control"');
								?>
							</div>
						</div>
						<div class="col-xs-6 col-sm-6 col-lg-4 clearfix">
							<label for="provincia_accidente">15.3 Provincia</label>
							<div class="form-group">
								<?php
								echo form_dropdown('prov_acc', $provincia_accidente, set_value('provincia_accidente'), 'id="provincia_accidente" class="form-control"');
								?>
							</div>
						</div>
						<div class="col-xs-12 col-sm-12 col-lg-4">
							<label for="distrito_accidente">15.4 Distrito</label>
							<div class="form-group">
								<?php
								echo form_dropdown('dist_acc', $distrito_accidente, set_value('distrito_accidente'), 'id="distrito_accidente" class="form-control"');
								?>
							</div>
						</div>
					</div>
				</div>
				<br/>

				<div class="row">
					<div class="list-group-item col-xs-12 col-sm-6 col-lg-6">
						<label>
						16.Via donde ocurrio el accidente
						</label>
						<table class="table table-hover table-condensed">
							<tr>
								<td>
									<label class="radio-inline">
										<input type="radio" name="via_accd" id="inlineRadio161" value="1">16.1 Calles/Jirones
									</label>
								</td>
								<td>
									<label class="radio-inline">
										<input type="radio" name="via_accd" id="inlineRadio165" value="5">16.5 Fluvial
									</label>
								</td>
							</tr>
							<tr>
								<td>
									<label class="radio-inline">
										<input type="radio" name="via_accd" id="inlineRadio162" value="2">16.2 Avenidas
									</label>
								</td>
								<td>
									<label class="radio-inline">
										<input type="radio" name="via_accd" id="inlineRadio166" value="7">16.6 Maritimo
									</label>
								</td>
							</tr>
							<tr>
								<td><label class="radio-inline">
										<input type="radio" name="via_accd" id="inlineRadio163" value="3">16.3 Carreteras
									</label>
								</td>
								<td>
									<label class="radio-inline">
										<input type="radio" name="via_accd" id="inlineRadio167" value="6">16.7 Aereo
									</label>
								</td>
							</tr>
							<tr>
								<td>
									<label class="radio-inline">
										<input type="radio" name="via_accd" id="inlineRadio164" value="4">16.4 Autopistas/Via expresa
									</label>
								</td>
								<td>

								</td>
							</tr>
						</table>
					</div>


					<div class="list-group-item col-xs-12 col-sm-6 col-lg-6">
						<div class="form-group">
							<label>17.Tipo de accidente</label>
							<table class="table table-hover table-condensed">
								<tr>
									<td>
										<label class="radio-inline">
											<input type="radio" name="tp_accd" id="inlineRadio171" value="1" onClick="habilita_elemento()">17.1 Atropellado
										</label>
									</td>
									<td>
										<label class="radio-inline">
											<input type="radio" name="tp_accd" id="inlineRadio174" value="4" onClick="habilita_elemento()">17.4 Caida de ocupante
										</label>
									</td>
								</tr>
								<tr>
									<td>
										<label class="radio-inline">
										<input type="radio" name="tp_accd" id="inlineRadio172" value="2" onClick="habilita_elemento()">17.2 Choque
										</label>
									</td>
									<td>
										<label class="radio-inline">
										  <input type="radio" name="tp_accd" id="inlineRadio175" value="5" onClick="habilita_elemento()">17.5 Otro
										</label>
									</td>
								</tr>
								<tr>
								<td><label class="radio-inline">
										<input type="radio" name="tp_accd" id="inlineRadio173" value="3" onClick="habilita_elemento()">17.3 Volcadura
									</label>
								</td>
									<td>
										<input type="text" name="tipo_accidente_otros" id="tipo_accidente_otros" placeholder="Ingrese Otro tipo de accidente" class="form-control" readonly>
									</td>
								</tr>
								<tr>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td></td>
									<td></td>
								</tr>
							</table>
						</div>
					</div>

				</div>

				<div class="row">
					<div class="col-xs-12 col-sm-6 col-lg-6">
						<h5><strong>A. REFERENTE AL LESIONADO</strong></h5>
					</div>
					<div class="col-xs-12 col-sm-6 col-lg-6">
						<h5><strong>B. REFERENTE AL OCACIONANTE DEL ACCIDENTE</strong></h5>
					</div>
				</div>

				<div class="row">
					<div class="list-group-item col-xs-12 col-sm-6 col-lg-6">
						<label>18.El lesionado se encontraba en:  </label>
						<table class="table table-hover table-condensed">
							<tr>
								<td><label class="radio-inline">
										<input type="radio" name="veh_moto" id="inlineRadio181" value="1">18.1 Motocicleta
									</label>
								</td>
								<td>
									<label class="radio-inline">
										<input type="radio" name="veh_moto" id="inlineRadio188" value="8">18.8 Bicicleta
									</label>
								</td>
							</tr>
							<tr>
								<td>
									<label class="radio-inline">
										<input type="radio" name="veh_moto" id="inlineRadio182" value="2">18.2 Motocar
									</label>
								</td>
								<td>
									<label class="radio-inline">
										<input type="radio" name="veh_moto" id="inlineRadio189" value="9">18.9 Carreta
									</label>
								</td>
							</tr>
							<tr>
								<td><label class="radio-inline">
										<input type="radio" name="veh_moto" id="inlineRadio183" value="3">18.3 Automovil
									</label>
								</td>
								<td>
									<label class="radio-inline">
										<input type="radio" name="veh_moto" id="inlineRadio1810" value="10">18.10 Avión
									</label>
								</td>
							</tr>
							<tr>
								<td><label class="radio-inline">
										<input type="radio" name="veh_moto" id="inlineRadio184" value="4">18.4 Microbus
									</label>
								</td>
								<td>
									<label class="radio-inline">
										<input type="radio" name="veh_moto" id="inlineRadio1811" value="11">18.11 Avioneta/Helicoptero
									</label>
								</td>
							</tr>
							<tr>
								<td><label class="radio-inline">
										<input type="radio" name="veh_moto" id="inlineRadio185" value="5">18.5 Omnibus
									</label>
								</td>
								<td>
									<label class="radio-inline">
										<input type="radio" name="veh_moto" id="inlineRadio1812" value="12">18.12 Embarcacion c/motor
									</label>
								</td>
							</tr>
							<tr>
								<td><label class="radio-inline">
										<input type="radio" name="veh_moto" id="inlineRadio186" value="6">18.6 Camion/Trailer
									</label>
								</td>
								<td>
									<label class="radio-inline">
										<input type="radio" name="veh_moto" id="inlineRadio1813" value="13">18.13 Embarcación s/motor
									</label>
								</td>
							</tr>
							<tr>
								<td><label class="radio-inline">
										<input type="radio" name="veh_moto" id="inlineRadio187" value="7">18.7 Tren
									</label>
								</td>
								<td>

								</td>
							</tr>
						</table>

						<label>19.Ubicacion del lesionado</label>
						<table class="table table-hover table-condensed">
							<tr>
								<td>
									<label class="radio-inline">
										<input type="radio" name="ub_les" id="inlineRadio191" value="1">19.1 Pasajero
									</label>
									<label class="radio-inline">
										<input type="radio" name="ub_les" id="inlineRadio192" value="2">19.2 Conductor
									</label>
									<label class="radio-inline">
										<input type="radio" name="ub_les" id="inlineRadio193" value="3">19.3 Peaton
									</label>
								</td>
							</tr>
						</table>

						<div class="form-group">
							<label>20.Traslado del lesionado por:  </label>
							<table class="table table-hover table-condensed">
								<tr>
									<td><label class="radio-inline">
											<input type="radio" name="trasl_les" id="inlineRadio201" value="1">20.1 Ocasionante
										</label>
									</td>
									<td>
										<label class="radio-inline">
											<input type="radio" name="trasl_les" id="inlineRadio208" value="5">20.8 Persona particular
										</label>
									</td>
								</tr>
								<tr>
									<td>
										<label class="radio-inline">
											<input type="radio" name="trasl_les" id="inlineRadio202" value="2">20.2 Familiar
										</label>
									</td>
									<td>
										<label class="radio-inline">
											<input type="radio" name="trasl_les" id="inlineRadio209" value="6">20.9 Policía
										</label>
									</td>
								</tr>
								<tr>
									<td><label class="radio-inline">
											<input type="radio" name="trasl_les" id="inlineRadio203" value="3">20.3 Propios medios
										</label>
									</td>
									<td>
										<label class="radio-inline">
											<input type="radio" name="trasl_les" id="inlineRadio2010" value="7">20.10 Bomberos
										</label>
									</td>
								</tr>
								<tr>
									<td><label class="radio-inline">
											<input type="radio" name="trasl_les" id="inlineRadio204" value="4">20.4 Serenazgo
										</label>
									</td>
									<td>
										<label class="radio-inline">
											<input type="radio" name="trasl_les" id="inlineRadio2011" value="8">20.11 Ambulancia servicio salud
										</label>
									</td>
								</tr>
							</table>
						</div>
					</div>

					<div class="list-group-item col-xs-12 col-sm-6 col-lg-6">
						<label>21.Tipo de vehiculo ocacionante:</label>
						<table class="table table-hover table-condensed">
							<tr>
								<td><label class="radio-inline">
										<input type="radio" name="tp_moto" id="inlineRadio211" value="1">21.1 Motocicleta
									</label>
								</td>
								<td>
									<label class="radio-inline">
										<input type="radio" name="tp_moto" id="inlineRadio218" value="8">21.8 Bicicleta
									</label>
								</td>
							</tr>
							<tr>
								<td>
									<label class="radio-inline">
										<input type="radio" name="tp_moto" id="inlineRadio212" value="2">21.2 Motocar
									</label>
								</td>
								<td>
									<label class="radio-inline">
										<input type="radio" name="tp_moto" id="inlineRadio219" value="9">21.9 Carreta
									</label>
								</td>
							</tr>
							<tr>
								<td><label class="radio-inline">
										<input type="radio" name="tp_moto" id="inlineRadio213" value="3">21.3 Automovil
									</label>
								</td>
								<td>
									<label class="radio-inline">
										<input type="radio" name="tp_moto" id="inlineRadio2110" value="10">21.10 Avión
									</label>
								</td>
							</tr>
							<tr>
								<td><label class="radio-inline">
										<input type="radio" name="tp_moto" id="inlineRadio214" value="4">21.4 Microbus
									</label>
								</td>
								<td>
									<label class="radio-inline">
										<input type="radio" name="tp_moto" id="inlineRadio2111" value="11">21.11 Avioneta/Helicoptero
									</label>
								</td>
							</tr>
							<tr>
								<td><label class="radio-inline">
										<input type="radio" name="tp_moto" id="inlineRadio215" value="5">21.5 Omnibus
									</label>
								</td>
								<td>
									<label class="radio-inline">
										<input type="radio" name="tp_moto" id="inlineRadio2112" value="12">21.12 Embarcacion c/motor
									</label>
								</td>
							</tr>
							<tr>
								<td>
									<label class="radio-inline">
										<input type="radio" name="tp_moto" id="inlineRadio216" value="6">21.6 Camion/Trailer
									</label>
								</td>
								<td>
									<label class="radio-inline">
										<input type="radio" name="tp_moto" id="inlineRadio2113" value="13">21.13 Embarcación s/motor
									</label>
								</td>
							</tr>
							<tr>
								<td>
									<label class="radio-inline">
										<input type="radio" name="tp_moto" id="inlineRadio217" value="7">21.7 Tren
									</label>
								</td>
								<td>

								</td>
							</tr>
						</table>

						<label>22. Condicion vehiculo ocasionante del accidente</label>
						<table class="table table-hover table-condensed">
							<tr>
								<td>
									<label class="radio-inline">
										<input type="radio" name="tp_condi" id="inlineRadio221" value="1">22.1 Particular
									</label>
								</td>
								<td>
									<label class="radio-inline">
										<input type="radio" name="tp_condi" id="inlineRadio223" value="3">22.3 Estatal
									</label>
								</td>
							</tr>
							<tr>
								<td>
									<label class="radio-inline">
									  <input type="radio" name="tp_condi" id="inlineRadio222" value="2">22.2 Público
									</label>
								</td>
								<td>
									<label class="radio-inline">
										<input type="radio" name="tp_condi" id="inlineRadio224" value="4">22.4 Privado
									</label>
								</td>
							</tr>
							<tr>
							  <td></td>
							  <td></td>
							</tr>
							<tr>
							  <td></td>
							  <td></td>
							</tr>
							<tr>
							  <td></td>
							  <td></td>
							</tr>
							<tr>
							  <td></td>
							  <td></td>
							</tr>
							<tr>
							  <td></td>
							  <td></td>
							</tr>
							<tr>
							  <td></td>
							  <td></td>
							</tr>
							<tr>
							  <td></td>
							  <td></td>
							</tr>
							<tr>
							  <td></td>
							  <td></td>
							</tr>
							<tr>
							  <td></td>
							  <td></td>
							</tr>
							<tr>
							  <td></td>
							  <td></td>
							</tr>
							<tr>
							  <td></td>
							  <td></td>
							</tr>
							<tr>
							  <td></td>
							  <td></td>
							</tr>
							<tr>
							  <td></td>
							  <td></td>
							</tr>
						</table>
					</div>
				</div>
				<br/>
				<div class="form-group">
					<div class="col-xs-1 col-sm-1 col-lg-1">
						<a class="btn btn-primary" href="#" id="btnAtras">Atras</a>
					</div>
					<div class="col-xs-offset-6 col-sm-offset-9 col-md-offset-9 col-lg-offset-10">
						<button type="submit" class="btn btn-primary ladda-button" data-style="expand-right" disabled="disabled">
						<span class="ladda-label">GRABAR</span><span class="ladda-spinner"></span><div class="ladda-progress" style="width: 0px;"></div></button>
						<a class="btn btn-primary" href="#" id="btnSiguiente2">Siguiente</a>
					</div>
				</div>
			</div>


			<!-- PESTAÑA "IV y V Datos relacionados al conductor y vehiculo" -->
			<div class="tab-pane fade" id="tabs-3">
				<h5><strong>IV. DATOS RELACIONADOS AL CONDUCTOR</strong></h5>

				<div class="row list-group-item">
					<div class="row">
						<div class="col-xs-12 col-sm-4 col-lg-3">
							<label for="nom_condc1">23.1 Apellido paterno</label>
							<div class="form-group">
							  <input type="text" name="nom_condc1" id="nom_condc1" class="form-control" placeholder="Apellido paterno">
							</div>
						</div>

						<div class="col-xs-12 col-sm-4 col-lg-3">
							<label for="ape_condc">23.2 Apellido materno</label>
							<div class="form-group">
							  <input type="text" name="ape_condc" id="ape_condc" class="form-control" placeholder="Apellido materno">
							</div>
						</div>
						<div class="col-xs-12 col-sm-4 col-lg-4">
							<label for="nom_condc2">23.3 Nombres</label>
							<div class="form-group">
							  <input type="text" name="nom_condc2" id="nom_condc2" class="form-control" placeholder="Nombres">
							</div>
					   </div>
						<div class="col-xs-6 col-sm-2 col-lg-2">
							<label for="ed_cond">24.Edad</label>
							<div class="form-group">
							  	<input type="text" name="ed_cond" id="ed_cond" class="form-control" placeholder="Edad" maxlength="3" onKeyPress="return acceptNum(event)">
							</div>
						</div>
						<div class="col-xs-6 col-sm-2 col-lg-2">
							<label for="sex_cond">25. Sexo</label>
							<div class="form-group">
							  <?php
							  $sexoconductor = array(''=>'Seleccione...','M'=>'Masculino','F'=>'Femenino');
							  echo form_dropdown('sex_cond', $sexoconductor, set_value('sexoconductor'), 'id="sex_cond" class="form-control"');
							  ?>
							</div>
						</div>
						<div class="col-xs-12 col-sm-8 col-lg-5">
							
								<label>26. N° Licencia de conducir</label>
							
							<div >
								<label class="radio-inline">
									<input type="radio" name="lic_conduc" id="inlineRadio261" value="SI" onClick="habilita_elemento()"> Si
								</label>
								<label class="radio-inline">
									<input type="radio" name="lic_conduc" id="inlineRadio262" value="NO" onClick="habilita_elemento()"> NO
								</label>
								<label class="radio-inline">
									<input type="radio" name="lic_conduc" id="inlineRadio263" value="NOSABE" onClick="habilita_elemento()"> NOSABE
								</label>
								<label class="radio-inline">
									<input type="text" name="lic_conduc" id="licenciaconducir" placeholder="Nro Licencia" class="form-control" readonly>
								</label>
							</div>
						</div>
						<div class="col-xs-12 col-sm-12 col-lg-5">
							<label for="comisar">27. Comisaria donde se registra denuncia policial</label>
							<div class="form-group">
							  <input type="text" name="comisar" id="comisar" placeholder="Lugar de la denuncia policial" class="form-control">
							</div>
						</div>
					</div>
					<div class="form-group clearfix">
						<div class="col-xs-6 col-sm-4 col-lg-3">
							<label for="departamento_cond">27.1 Departamento</label>
							<div class="row">
								<?php
								  echo form_dropdown('dep_com', $departamento_cond, set_value('departamento_cond'), 'id="departamento_cond" class="form-control"');
								?>
							</div>
						</div>
						<div class="col-xs-6 col-sm-4 col-lg-3">
							<label for="provincia_cond">27.2 Provincia</label>
							<div class="form-group">
							  <?php
							  echo form_dropdown('prov_com', $provincia_cond, set_value('provincia_cond'), 'id="provincia_cond" class="form-control"');
							  ?>
							</div>
						</div>
						<div class="col-xs-12 col-sm-4 col-lg-6">
							<label for="distrito_cond">27.3 Distrito</label>
							<div class="form-group">
							  <?php
							  echo form_dropdown('dist_com', $distrito, set_value('distrito_cond'), 'id="distrito_cond" class="form-control"');
							  ?>
							</div>
						</div>
					</div>
				</div>

				<h5><strong>V. DATOS RELACIONADOS DEL VEHÍCULO </strong></h5>
				<div class="row list-group-item">
					<div class="row clearfix">
						<div class="col-xs-6 col-sm-4 col-lg-3">
							<label for="num_pol">28. N° Poliza SOAT</label>
							  <div class="form-group">
								<input type="text" name="num_pol" id="num_pol" class="form-control" placeholder="Nro poliza SOAT">
							  </div>
						</div>
						<div class="col-xs-6 col-sm-4 col-lg-3">
								<label for="num_plac">29. N° Placa del vehiculo</label>
						  <div class="form-group">
								<input type="text" name="num_plac" id="num_plac" class="form-control" placeholder="Placa Vehiculo">
						  </div>
						</div>
						<div class="col-xs-12 col-sm-12 col-lg-6">
							<label for="nom_duepol">30. Nombre dueño de poliza</label>
						  <div class="form-group">
							<input type="text" name="nom_duepol" id="nom_duepol" class="form-control" placeholder="Dueño poliza">
						  </div>
						</div>
					</div>
					<div class="form-group clearfix">
						<div class="col-xs-12 col-sm-2 col-lg-2">
							<label>31. Aseguradora:</label>

						</div>
						<div class="col-xs-12 col-sm-10 col-lg-10">
							<table class="table table-hover table-condensed">
								<tr>
									<td>
										<label class="radio-inline">
											<input type="radio" name="aseg" id="inlineRadio311" value="1" onClick="habilita_elemento()">Rimac
										</label>
									</td>
									<td>
										<label class="radio-inline">
											<input type="radio" name="aseg" id="inlineRadio312" value="2" onClick="habilita_elemento()">Pacifico Seguros
										</label>
									</td>
									<td>
										<label class="radio-inline">
											<input type="radio" name="aseg" id="inlineRadio313" value="3" onClick="habilita_elemento()">La positiva
										</label>
									</td>
									<td>
										<label class="radio-inline">
											<input type="radio" name="aseg" id="inlineRadio314" value="4" onClick="habilita_elemento()">Generali Peru
										</label>
									</td>
								</tr>
								<tr>
									<td>
										<label class="radio-inline">
											<input type="radio" name="aseg" id="inlineRadio315" value="5" onClick="habilita_elemento()">Mapfre Peru
										</label>
									</td>
									<td>
										<label class="radio-inline">
											<input type="radio" name="aseg" id="inlineRadio316" value="7" onClick="habilita_elemento()">Latinos Seguros
										</label>
									</td>
									<td colspan="2">
										<div class="input-group">
										  <span class="input-group-addon">
											<label class="radio-inline">
											<input type="radio" name="aseg" id="inlineRadio318" value="8" onClick="habilita_elemento()" >Otro:
											</label>
										  </span>
										  <input type="text" name="otroaseg" placeholder="otra aseguradora.." id="otraaseguradora" class="form-control" readonly>
										</div>
									</td>
								</tr>
							</table>
						</div>
					</div>

				</div>
				<br/>

				<div class="form-group">
					<div class="col-xs-1 col-sm-1 col-lg-1">
						<a class="btn btn-primary" href="#" id="btnAtras2">Atras</a>
					</div>
					<div class="col-xs-offset-9 col-sm-offset-10 col-md-offset-11 col-lg-offset-11">
						<button type="submit" class="btn btn-primary ladda-button" data-style="expand-right" disabled="disabled"><span class="ladda-label">GRABAR</span><span class="ladda-spinner"></span><div class="ladda-progress" style="width: 0px;"></div></button>
					</div>
				</div>

			</div>

		</div>
	</div>
</div>


<?php
    echo form_close();
?>