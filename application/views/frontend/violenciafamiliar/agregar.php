<?php $this->load->view('frontend/violenciafamiliar/includes/header'); ?>

<div class="container">
	<div class="row">
		<!-- CREANDO LAS PESTAÑAS -->
		<ul class="nav nav-tabs nav-justified" id="tabsFicha">
			<li class="active"><a href="#tabs-1" role="tablist" data-toggle="tab"><i class="fa fa-user fa-lg"></i> Notificante</a></li>
			<li><a href="#tabs-2" data-toggle="tab"><i class="fa fa-map-marker fa-lg"></i> Agredido</a></li>
			<li><a href="#tabs-3" data-toggle="tab"><i class="fa fa-map-marker fa-lg"></i> Agresor</a></li>
			<li><a href="#tabs-3" data-toggle="tab"><i class="fa fa-map-marker fa-lg"></i> Sobre Agresion</a></li>
			<li><a href="#tabs-3" data-toggle="tab"><i class="fa fa-map-marker fa-lg"></i> Medidas Tomadas</a></li>
			<li><a href="#tabs-3" data-toggle="tab"><i class="fa fa-map-marker fa-lg"></i> Seguimiento</a></li>
		</ul>
	</div>

	<!-- 1. BLOQUE UNIDAD NOTIFICANTE-->
	<fieldset class="margen-bloque">
		<legend>1. UNIDAD NOTIFICANTE</legend>
		<div class="col-xs-12 col-sm-6 col-md-2 col-lg-3">
			<label for="codigo">1.1 CIEX</label>
		  	<div class="form-group">
				<?php
					$codigo = array(''=>'Seleccione...','T74'=>'T74 Síndrome  del maltrato',
						'T74.0'=>'T74.0 Negligencia o abandono','T74.1'=>'T74.1 Abuso físico', 
						'T74.2'=>"T74.2 Abuso sexual",'T74.3'=>'T74.3 Abuso Psicológico', 
						'T74.8'=>'T74.8 Otros síndromes maltrato', 
						'T74.9'=>'T74.9 Síndrome de maltrato; no esp.');
					echo form_dropdown('codigo', $codigo, set_value('codigo'), 'id="codigo" class="form-control"');
				?>	
	  		</div>
		</div>
		<div class="col-xs-12 col-sm-6 col-md-3 col-lg-2">
			<label for="freg">1.2 Registro Ficha</label>
		  	<div class="form-group">
				<div class="input-group">
					<div class="form-group">
						<input type='text' class="form-control datepicker" name="freg" id="freg" placeholder="dd-mm-aaaa"
						value="<?php echo set_value('freg')?>" onKeyPress="return acceptNum(event)" class="form-control">
					</div>
					<div class="input-group-addon">
						<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
					</div>
				</div>
	  		</div>
		</div>
		<div class="col-xs-6 col-sm-4 col-md-2 col-lg-2">
			<label for="codigo">1.3 Eval. anterior?</label>
		  	<div class="form-group">
				<div class="radio radio-info radio-inline">
	                <input type="radio" id="evalantSi" value="1" name="evalant">
	                <label for="evalantSi">Si</label>
	            </div>
	             <div class="radio radio-inline">
	                <input type="radio" id="evalantNo" value="0" name="evalant">
	                <label for="evalantNo">No</label>
	            </div>
	  		</div>
		</div>
		<div class="col-xs-6 col-sm-4 col-md-2 col-lg-2">
			<label for="institu">1.4 Institución</label>
		  	<div class="form-group">
				<?php
					$institu = array(''=>'Seleccione...','MINSA'=>'MINSA','PNP'=>'PNP','Defensoria'=>'Defensoria', 
						'CMM'=>'CM Municipio','Essalud'=>'Essalud','CE Mujer'=>'CE Mujer','M. Educacion'=>'M. Educacion',
						'M. Publico'=>'M. Publico', 'Poder Judicial'=>'Poder Judicial','Sanidad'=>'Sanidad',
						'ONG'=>'ONG','Otros'=>'Otros');
					echo form_dropdown('institu', $institu, set_value('institu'), 'id="institu" class="form-control"');
				?>
	  		</div>
		</div>
		<div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
			<label class="labelnormal" for="donde">1.4.1 Otra institución</label>
			<div class="form-group">
				<input id="donde" placeholder="Especifique nombre de institución..." class="form-control">
			</div>
		</div>
		<br><br><br><br>
		<div class="form-group clearfix">
			<div class="col-xs-12 col-sm-2 col-md-3 col-lg-3">
				<label class="labeltitulo2">1.5 Lugar de Digitación <i class="fa fa-chevron-right"></i></label>
			</div>
			<div class="col-xs-6 col-sm-2 col-lg-2">
				<label for="cod_disa">Diresa</label>
			  	<div class="form-group">
					<!--<select class="form-control"> <option>seleccione..</option></select> -->
				   	<?php
						echo form_dropdown('cod_disa', $diresa, set_value('cod_disa'), 'id="cod_disa" class="form-control" ');
			  		?>
		  		</div>
			</div>
			<div class="col-xs-6 col-sm-2 col-md-2 col-lg-2">
				<label for="red">Red</label>
				<div class="form-group">
					<select class="form-control"> <option>seleccione..</option></select>
					<?php
					//echo form_dropdown('red', $redes, set_value('red'), 'id="red" class="form-control" ');
					?>
				</div>
			</div>
			<div class="col-xs-6 col-sm-3 col-md-2 col-lg-2">
				<label for="microred">Microred</label>
				<div class="form-group">
					<select class="form-control"> <option>seleccione..</option></select>
					<?php
					//echo form_dropdown('microred', $microred, set_value('microred'), 'id="microred" class="form-control" ');
					?>
				</div>
			</div>
			<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3" id="eess_notificante">
				<label for="establec">Establecimiento</label>
				<div class="form-group">
					<select class="form-control"> <option>seleccione..</option></select>
					<?php
					//echo form_dropdown('establec', $establec, set_value('establec'), 'id="establec" class="form-control"');
					?>
				</div>
			</div>			
		</div>
	</fieldset>


	<!-- 2. BLOQUE DATOS DEL AGREDIDO-->
	<fieldset class="margen-bloque">
		<legend>2. DATOS DEL AGREDIDO</legend>

		<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
			<label for="nom_1">2.1 Nombres</label>
			<div class="form-group">
		  	<input type="text" name="nom_1" id="nom_1" class="form-control" placeholder="Nombres">
			</div>
		</div>

		<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
			<label for="ape_pat">2.1 Apellido paterno</label>
			<div class="form-group">
			  	<input type="text" name="ape_pat" id="ape_pat" class="form-control" placeholder="Apellido paterno">
			</div>
		</div>

		<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
			<label for="ape_mat">2.1 Apellido materno</label>
			<div class="form-group">
			  <input type="text" name="ape_mat" id="ape_mat" class="form-control" placeholder="Apellido materno">
			</div>
		</div>

		<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
			<label for="ide">2.2 DNI</label>
			<div class="form-group">
			  	<input type='text' class="form-control" name="ide" id="ide" placeholder="DNI"
						maxlength="8" onKeyPress="return SoloNumeros(event)">
			</div>
		</div>

		<div class="col-xs-6 col-sm-6 col-md-4 col-lg-3">
			<label for="coddepres">2.3 Depart. resid. ultimo año</label>
			<div class="form-group">
			  	<?php
					$coddepres = array(''=>'Seleccione...');
					echo form_dropdown('coddepres', $coddepres, set_value('coddepres'), 'id="coddepres" class="form-control"');
				?>
			</div>
		</div>

		<div class="col-xs-6 col-sm-3 col-md-2 col-lg-1">
			<label for="edad">2.4 Edad</label>
			<div class="form-group">
			  <input type="text" name="edad" id="edad" class="form-control" placeholder="Edad" maxlength="3" onKeyPress="return SoloNumeros(event)">
			</div>
		</div>
		<div class="col-xs-6 col-sm-3 col-md-2 col-lg-2">
			<label for="t_edad">2.5 Tipo edad</label>
			<div class="form-group">
				<?php
					$t_edad = array(''=>'Seleccione...', 'Años'=>'Años', 'Meses'=>'Meses', 'Dias'=>'Dias');
					echo form_dropdown('t_edad', $t_edad, set_value('t_edad'), 'id="t_edad" class="form-control"');
				?>
			</div>
		</div>

		<div class="col-xs-6 col-sm-3 col-md-2 col-lg-2">
			<label for="sexo">2.6 Sexo</label>
			<div class="form-group">
			  <?php
					$sexo = array(''=>'Seleccione...', 'Hombre'=>'Hombre', 'Mujer'=>'Mujer');
					echo form_dropdown('sexo', $sexo, set_value('sexo'), 'id="sexo" class="form-control"');
				?>
			</div>
		</div>
		<div class="col-xs-6 col-sm-3 col-md-2 col-lg-2">
			<div class="clearfix">
				<label  for="gesta">2.6.1 Gestante?</label>
			</div>
			<div class="radio radio-info radio-inline">
                <input type="radio" id="gestaSi" value="1" name="gesta">
                <label for="gestaSi">Si</label>
            </div>
             <div class="radio radio-inline">
                <input type="radio" id="gestaNo" value="0" name="gesta">
                <label for="gestaNo">No</label>
            </div>
		</div>
		<div class="col-xs-6 col-sm-6 col-md-3 col-lg-2">
			<label for="ecivil">2.7 Estado civil</label>
			<div class="form-group">
			  <?php
					$ecivil = array(''=>'Seleccione...', 'Soltero(a)'=>'Soltero(a)', 'Casado(a)'=>'Casado(a)',
						'Conviviente'=>'Conviviente', 'Separado(a)'=>'Separado(a)','Divorsiado(a)'=>'Divorsiado(a)',
						'Viudo(a)'=>'Viudo(a)','Ex-Conyugue'=>'Ex-Conyugue','Ex-Conviviente'=>'Ex-Conviviente');
					echo form_dropdown('ecivil', $ecivil, set_value('ecivil'), 'id="ecivil" class="form-control"');
				?>
			</div>
		</div>
		<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
			<label for="gins">2.8 Grado de instrucción</label>
			<div class="form-group">
			  <?php
					$gins = array(''=>'Seleccione...', 'iletrada'=>'iletrada', 'Primaria Completa'=>'Primaria Completa',
						'Primaria Incompleta'=>'Primaria Incompleta', 'Secundaria Completa'=>'Secundaria Completa',
						'Secundaria Incompleta'=>'Secundaria Incompleta', 'Superior Completa'=>'Superior Completa', 'Superior Incompleta'=>'Superior Incompleta');
					echo form_dropdown('gins', $gins, set_value('gins'), 'id="gins" class="form-control"');
				?>
			</div>
		</div>

		<div class="col-xs-6 col-sm-6 col-md-4 col-lg-3">
			<label  for="ocupa">2.9 Ocupación.. <i class="fa fa-chevron-right"></i></label>
			<div class="form-group">
			 	<input type='text' class="form-control" name="ocupa" id="ocupa" placeholder="Ocupación"
				class="form-control">
			</div>
		</div>

		<div class="col-xs-6 col-sm-4 col-md-2 col-lg-2">
			<label  for="remuneraSi">es remunerado?</label>
			<div class="form-group">			 	
				<div class="radio radio-info radio-inline">
	                <input type="radio" id="remuneraSi" value="1" name="remunera">
	                <label for="remuneraSi">Si</label>
	            </div>
	             <div class="radio radio-inline">
	                <input type="radio" id="remuneraNo" value="0" name="remunera">
	                <label for="remuneraNo">No</label>
	            </div>				
			</div>
		</div>

		<div class="col-xs-12 col-sm-8 col-md-6 col-lg-4">
			<label for="domi">2.10 Dirección <i class="fa fa-chevron-right"></i> Domicilio</label>
			<div class="form-group">
				<input type="text" placeholder="Domicilio del agredido" class="form-control">
			</div>
		</div>

		<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
			<label for="depar">2.10 Departamento</label>
			<div class="form-group">
				<select class="form-control"> <option>seleccione..</option></select>
				<?php
				//echo form_dropdown('depar', $depar, set_value('depar'), 'id="depar" class="form-control"');
				?>
			</div>
		</div>
		<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
			<label for="provi">2.10 Provincia</label>
			<div class="form-group">
			<select class="form-control"> <option>seleccione..</option></select>
				<?php
				//echo form_dropdown('provi', $provi, set_value('provi'), 'id="provi" class="form-control"');
				?>
			</div>
		</div>
		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-3">
			<label for="ubigeo2">2.10 Distrito</label>
			<div class="form-group">
				<select class="form-control"> <option>seleccione..</option></select>
				<?php
				//echo form_dropdown('ubigeo2', $ubigeo2, set_value('ubigeo2'), 'id="ubigeo2" class="form-control"');
				?>
			</div>
		</div>
		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-3">
			<label for="local">2.10 Localidad</label>
			<div class="form-group">
				<select class="form-control"> <option>seleccione..</option></select>
				<?php
				//echo form_dropdown('local', $local, set_value('local'), 'id="local" class="form-control"');
				?>
			</div>
		</div>		

	</fieldset>

	<!-- 3. BLOQUE DATOS DEL AGRESOR-->
	<fieldset class="margen-bloque">
		<legend>3. DATOS DEL AGRESOR</legend>
		<div class="col-xs-6 col-sm-6 col-md-2 col-lg-3">
			<label for="nombagreso">3.1 Nombres</label>
			<div class="form-group">
		  	<input type="text" name="nombagreso" id="nombagreso" class="form-control" placeholder="Nombres">
			</div>
		</div>
		<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
			<label for="apep_agres">3.1 Apellido paterno</label>
			<div class="form-group">
			  	<input type="text" name="apep_agres" id="apep_agres" class="form-control" placeholder="Apellido paterno">
			</div>
		</div>
		<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
			<label for="apem_agres">3.1 Apellido materno</label>
			<div class="form-group">
			  <input type="text" name="apem_agres" id="apem_agres" class="form-control" placeholder="Apellido materno">
			</div>
		</div>

		<div class="col-xs-6 col-sm-3 col-md-2 col-lg-1">
			<label for="edadagre">3.2 Edad</label>
			<div class="form-group">
			  <input type="text" name="edadagre" id="edadagre" class="form-control" placeholder="Edad" maxlength="3" onKeyPress="return SoloNumeros(event)">
			</div>
		</div>
		<div class="col-xs-4 col-sm-3 col-md-2 col-lg-2">
			<label for="sexagre">3.3 Sexo</label>
			<div class="form-group">
			  <?php
					$sexagre = array(''=>'Seleccione...', 'Hombre'=>'Hombre', 'Mujer'=>'Mujer');
					echo form_dropdown('sexagre', $sexagre, set_value('sexagre'), 'id="sexagre" class="form-control"');
				?>
			</div>
		</div>
		<div class="col-xs-8 col-sm-6 col-md-3 col-lg-2">
			<label for="vinculo">3.4 Vinculo con victima</label>
			<div class="form-group">
			  <?php
					$vinculo = array(''=>'Seleccione...', 'Esposo(a)'=>'Esposo(a)', 'Conviviente'=>'Conviviente',
							'Hijo(a)'=>'Hijo(a)', 'Padre'=>'Padre', 'Madre'=>'Madre', 'Ex-Conyugue'=>'Ex-Conyugue',
							'Ex-Conviviente'=>'Ex-Conviviente','Otro'=>'Otro');
					echo form_dropdown('vinculo', $vinculo, set_value('vinculo'), 'id="vinculo" class="form-control"');
				?>
			</div>
		</div>
		<div class="col-xs-6 col-sm-6 col-md-2 col-lg-3">
			<label for="queotrovin">otro Vinculo</label>
			<div class="form-group">
			  <input type="text" name="queotrovin" id="queotrovin" class="form-control" placeholder="Que otro vinculo?">
			</div>
		</div>
		<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
			<label for="gradoins">3.5 Grado de instrucción</label>
			<div class="form-group">
			  <?php
					$gradoins = array(''=>'Seleccione...', 'iletrada'=>'iletrada', 'Primaria Completa'=>'Primaria Completa',
						'Primaria Incompleta'=>'Primaria Incompleta', 'Secundaria Completa'=>'Secundaria Completa',
						'Secundaria Incompleta'=>'Secundaria Incompleta', 'Superior Completa'=>'Superior Completa', 'Superior Incompleta'=>'Superior Incompleta');
					echo form_dropdown('gradoins', $gradoins, set_value('gradoins'), 'id="gradoins" class="form-control"');
				?>
			</div>
		</div>

		<div class="col-xs-6 col-sm-3 col-md-2 col-lg-2">
			<label  for="ocupacion">3.6 Ocupación.. <i class="fa fa-chevron-right"></i></label>
			<div class="form-group">
			 	<input type='text' class="form-control datepicker" name="ocupacion" id="ocupacion" placeholder="Ocupación"
					value="<?php echo set_value('ide')?>" onKeyPress="return acceptNum(event)" class="form-control">
			</div>
		</div>

		<div class="col-xs-6 col-sm-3 col-md-2 col-lg-2">
			<label  for="remuneraSi">es remunerado?</label>
			<div class="form-group">			 	
				<div class="radio radio-info radio-inline">
	                <input type="radio" id="empremSi" value="1" name="emprem">
	                <label for="empremSi">Si</label>
	            </div>
	             <div class="radio radio-inline">
	                <input type="radio" id="empremNo" value="0" name="emprem">
	                <label for="empremNo">No</label>
	            </div>				
			</div>
		</div>

	</fieldset>

	<!-- DATOS DE LA AGRESION-->
	<fieldset class="margen-bloque">
		<legend>4. DATOS DE LA AGRESIÓN</legend>
		<div class="col-xs-12 col-sm-2 col-md-4 col-lg-3">
			<label class="labeltitulo2">4.1 Ubicacion geografica de agresión <i class="fa fa-chevron-right"></i></label>			  	
		</div>
		<div class="col-xs-6 col-sm-4 col-md-4 col-lg-2">
			<label for="departam">4.1 Departamento</label>
			<div class="form-group">
				<select class="form-control"> <option>seleccione..</option></select>
				<?php
				//echo form_dropdown('departam', $departam, set_value('departam'), 'id="departam" class="form-control"');
				?>
			</div>
		</div>
		<div class="col-xs-6 col-sm-4 col-md-4 col-lg-2">
			<label for="provinci">4.1 Provincia</label>
			<div class="form-group">
			<select class="form-control"> <option>seleccione..</option></select>
				<?php
				//echo form_dropdown('provinci', $provinci, set_value('provinci'), 'id="provinci" class="form-control"');
				?>
			</div>
		</div>
		<div class="col-xs-6 col-sm-4 col-md-6 col-lg-3">
			<label for="ubigeo1">4.1 Distrito</label>
			<div class="form-group">
				<select class="form-control"> <option>seleccione..</option></select>
				<?php
				//echo form_dropdown('ubigeo1', $ubigeo1, set_value('ubigeo1'), 'id="ubigeo1" class="form-control"');
				?>
			</div>
		</div>
		<div class="col-xs-6 col-sm-4 col-md-6 col-lg-2">
			<label for="fagres">4.2 Fecha Agresión</label>
		  	<div class="form-group">
				<div class="input-group">
					<div class="form-group">
						<input type='text' class="form-control datepicker" name="fagres" id="fagres" placeholder="dd-mm-aaaa"
						value="<?php echo set_value('fagres')?>" onKeyPress="return acceptNum(event)" class="form-control">
					</div>
					<div class="input-group-addon">
						<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
					</div>
				</div>
	  		</div>
		</div>

		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
			<div class="clearfix">
				<label>4.3 Estado del agresor</label>
			</div>
			<div class="checkbox checkbox-info checkbox-inline">
                <input type="checkbox" name="ecuanime" id="ecuanime" value="1">
                <label for="ecuanime"> Equanime </label>
	        </div>
	        <div class="checkbox checkbox-info checkbox-inline">
	            <input type="checkbox" name="droga" id="droga" value="1">
	            <label for="droga"> Efecto de drogas </label>
	        </div>
	        <div class="checkbox checkbox-info checkbox-inline">
	            <input type="checkbox" name="alcohol" id="alcohol" value="1">
	            <label for="alcohol"> Efecto de Alcohol </label>
	        </div>
	        <div class="checkbox checkbox-info checkbox-inline">
	            <input type="checkbox" name="otros" id="otros" value="1">
	            <label for="otros"> Otros </label>
	        </div>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
			<div class="clearfix">
				<label>4.4 Tipo de Violencia</label>
			</div>
			<div class="checkbox checkbox-info checkbox-inline">
                <input type="checkbox" name="fisica" id="fisica" value="1">
                <label for="fisica"> Fisica </label>
	        </div>
	        <div class="checkbox checkbox-info checkbox-inline">
	            <input type="checkbox" name="psicol" id="psicol" value="1">
	            <label for="psicol"> Psicolóliga </label>
	        </div>
	        <div class="checkbox checkbox-info checkbox-inline">
	            <input type="checkbox" name="relsex" id="relsex" value="1">
	            <label for="relsex"> Relaciones sexuales </label>
	        </div>
	        <div class="checkbox checkbox-info checkbox-inline">
	            <input type="checkbox" name="aband" id="aband" value="1">
	            <label for="aband"> Abandono </label>
	        </div>
		</div><br><br><br>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
			<div class="clearfix">
				<label>4.5 Medio Utilizado</label>
			</div>
			<div class="checkbox checkbox-info checkbox-inline">
                <input type="checkbox" name="propiocuer" id="propiocuer" value="1">
                <label for="propiocuer"> Propio Cuerpo </label>
	        </div>
	        <div class="checkbox checkbox-info checkbox-inline">
	            <input type="checkbox" name="armablan" id="armablan" value="1">
	            <label for="armablan"> Arma blanca </label>
	        </div>
	        <div class="checkbox checkbox-info checkbox-inline">
	            <input type="checkbox" name="armafuego" id="armafuego" value="1">
	            <label for="armafuego"> Arma de fuego </label>
	        </div>
	        <div class="checkbox checkbox-info checkbox-inline">
	            <input type="checkbox" name="objcontun" id="objcontun" value="1">
	            <label for="objcontun"> Objeto contundente </label>
	        </div>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
			<div class="clearfix">
				<label>4.6 Motivo expresado</label>
			</div>
			<div class="checkbox checkbox-info checkbox-inline">
                <input type="checkbox" name="familiar" id="familiar" value="1">
                <label for="familiar"> Familiares </label>
	        </div>
	        <div class="checkbox checkbox-info checkbox-inline">
	            <input type="checkbox" name="celos" id="celos" value="1">
	            <label for="celos"> Celos </label>
	        </div>
	        <div class="checkbox checkbox-info checkbox-inline">
	            <input type="checkbox" name="economicos" id="economicos" value="1">
	            <label for="economicos"> Económ. </label>
	        </div>
	        <div class="checkbox checkbox-info checkbox-inline">
	            <input type="checkbox" name="laborales" id="laborales" value="1">
	            <label for="laborales"> Labor. </label>
	        </div>
	       <div class="checkbox checkbox-info checkbox-inline">
	            <input type="checkbox" name="sinmotivo" id="sinmotivo" value="1">
	            <label for="sinmotivo"> Sin motivo </label>
	        </div>
	        <div class="checkbox checkbox-info checkbox-inline">
	            <input type="checkbox" name="espemoti" id="espemoti" value="1">
	            <label for="espemoti"> Otros </label>
	        </div><br><br>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<label>4.7 FRECUENCIA DE AGRESIÓN</label>
		</div>
		<div class="col-xs-6 col-sm-3 col-md-2 col-lg-2">
			<div class="clearfix">
				<label>Primera vez?</label>
			</div>
			<div class="radio radio-info radio-inline">
                <input type="radio" id="primvezSi" value="1" name="primvez">
                <label for="primvezSi">Si</label>
            </div>
             <div class="radio radio-inline">
                <input type="radio" id="primvezNo" value="0" name="primvez">
                <label for="primvezNo">No</label>
            </div>
		</div>
		<div class="col-xs-8 col-sm-4 col-md-5 col-lg-5">
			<label for="duransem">Durante la semana cuantas veces fue agredido(a)?</label>
			<div class="form-group">
			  <?php
					$duransem = array('0'=>'Seleccione...', '1'=>'01 vez', '2'=>'02 veces',
						'3'=>'03 veces', '4'=>'04 veces', '5'=>'05 veces', '6'=>'06 veces', '7'=>'07 veces');
					echo form_dropdown('duransem', $duransem, set_value('duransem'), 'id="duransem" class="form-control"');
				?>
			</div>
		</div>
		<div class="col-xs-8 col-sm-4 col-md-5 col-lg-5">
			<label for="duranmes">Durante el mes cuantas veces fue agredido(a)?</label>
			<div class="form-group">
			  <?php
					$duranmes = array('0'=>'Seleccione...', '1'=>'01 vez', '2'=>'2-3 veces',
						'3'=>'4-5 veces', '4'=>'6-7 veces', '5'=>'8-9 veces', '6'=>'09 veces', '7'=>'10 veces');
					echo form_dropdown('duranmes', $duranmes, set_value('duranmes'), 'id="duranmes" class="form-control"');
				?>
			</div>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-7">
			<div class="clearfix">
				<label>4.8 Lugar de agresión</label>
			</div>
			<div class="checkbox checkbox-info checkbox-inline">
                <input type="checkbox" name="calle" id="calle" value="1">
                <label for="calle"> Calle </label>
	        </div>
	        <div class="checkbox checkbox-info checkbox-inline">
	            <input type="checkbox" name="casa" id="casa" value="1">
	            <label for="casa"> Casa </label>
	        </div>
	        <div class="checkbox checkbox-info checkbox-inline">
	            <input type="checkbox" name="centrotrab" id="centrotrab" value="1">
	            <label for="centrotrab"> Centro de trabajo </label>
	        </div>
	        <div class="checkbox checkbox-info checkbox-inline">
	            <input type="checkbox" name="espelug" id="espelug" value="1">
	            <label for="espelug"> Otros </label>
	        </div>
	        <div class="col-xs-12 col-sm-5 col-md-6 col-lg-5 bloque-lineal">
				<input type="text" name="espelug" placeholder="Indique otros" id="espelug" class="form-control" readonly>
			</div>
	       <br><br>
		</div>
		<div class="col-xs-12 col-sm-6 col-lg-3">
			<label for="hora">4.9 Hora de agresión</label>
			<div class="form-group">
				<div class="input-group clockpicker" data-autoclose="true">
					<input type="text" name="hora" id="hora" class="form-control" placeholder="00:00">
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-time"></span>
					</span>
					<span class="input-group-addon" id="sizing-addon1">horas:min</span>
				</div>
			</div>
		</div>
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-2">
			<div class="clearfix">
				<label>4.10 Hubo Defunción?</label>
			</div>
			<div class="radio radio-info radio-inline">
                <input type="radio" id="defunSi" value="1" name="defuncion">
                <label for="defunSi">Si</label>
            </div>
             <div class="radio radio-inline">
                <input type="radio" id="defunNo" value="0" name="defuncion">
                <label for="defunNo">No</label>
            </div>
		</div>
		
	</fieldset>

	<!-- BLOQUE MEDIDAS A TOMAR-->
	<fieldset class="margen-bloque">
		<legend>5. MEDIDAS A TOMAR</legend>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="checkbox checkbox-info checkbox-inline">
                <input type="checkbox" name="atenmedica" id="atenmedica" value="1">
                <label for="atenmedica"> Atención médica </label>
	        </div>
	        <div class="checkbox checkbox-info checkbox-inline">
	            <input type="checkbox" name="atenpsicol" id="atenpsicol" value="1">
	            <label for="atenpsicol"> Atención psicolóliga </label>
	        </div>
	        <div class="checkbox checkbox-info checkbox-inline">
	            <input type="checkbox" name="denunjudic" id="denunjudic" value="1">
	            <label for="denunjudic"> Denuncia judicial </label>
	        </div>
	        <div class="checkbox checkbox-info checkbox-inline">
	            <input type="checkbox" name="asistsocia" id="asistsocia" value="1">
	            <label for="asistsocia"> Asistencia social </label>
	        </div>
	          <div class="checkbox checkbox-info checkbox-inline">
	            <input type="checkbox" name="denunpolic" id="denunpolic" value="1">
	            <label for="denunpolic"> Denuncia Policial </label>
	        </div>
	          <div class="checkbox checkbox-info checkbox-inline">
	            <input type="checkbox" name="otro2" id="otro2" value="1">
	            <label for="otro2"> Otros </label>
	        </div>
	        <div class="col-xs-12 col-sm-8 col-md-12 col-lg-3 bloque-lineal">
				<input type="text" name="otro2" placeholder="Indique otros" id="otro2" class="form-control" readonly>
			</div>
	       <br><br>
		</div>
	</fieldset>

	<!-- BLOQUE SEGUIMIENTO-->
	<fieldset class="margen-bloque">
		<legend>6. SEGUIMIENTO</legend>
		<div class="col-xs-6 col-sm-3 col-md-2 col-lg-2">
			<div class="clearfix">
				<label>Fue derivado?</label>
			</div>
			<div class="radio radio-info radio-inline">
                <input type="radio" id="derivadoSi" value="1" name="derivado">
                <label for="derivadoSi">Si</label>
            </div>
             <div class="radio radio-inline">
                <input type="radio" id="derivadoNo" value="0" name="derivado">
                <label for="derivadoNo">No</label>
            </div>
		</div>
		<div class="col-xs-6 col-sm-5 col-md-2 col-lg-2">
			<label for="cod_disa_d">Diresa</label>
		  	<div class="form-group">
				<select class="form-control"> <option>seleccione..</option></select>
			   	<?php
				//	echo form_dropdown('cod_disa_d', $diresa, set_value('cod_disa_d'), 'id="cod_disa_d" class="form-control" ');
		  		?>
	  		</div>
		</div>
		<div class="col-xs-6 col-sm-4 col-md-2 col-lg-2">
			<label for="redes_d">Red</label>
			<div class="form-group">
				<select class="form-control"> <option>seleccione..</option></select>
				<?php
				//echo form_dropdown('redes_d', $redes, set_value('redes_d'), 'id="redes_d" class="form-control" ');
				?>
			</div>
		</div>
		<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
			<label for="microred_d">Microred</label>
			<div class="form-group">
				<select class="form-control"> <option>seleccione..</option></select>
				<?php
				//echo form_dropdown('microred_d', $microred, set_value('microred_d'), 'id="microred_d" class="form-control" ');
				?>
			</div>
		</div>
		<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3" id="eess_notificante">
			<label for="establec_d">Establecimiento</label>
			<div class="form-group">
				<select class="form-control"> <option>seleccione..</option></select>
				<?php
				//echo form_dropdown('establec_d', $establec_d, set_value('establec_d'), 'id="establec_d" class="form-control"');
				?>
			</div>
		</div>
	</fieldset>

</div>

<?php $this->load->view('frontend/violenciafamiliar/includes/footer'); ?>





