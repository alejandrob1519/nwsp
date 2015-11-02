
<center>
	<h4>Seguimiento de casos mensuales <br> Vigilancia epidemiológica de Lesiones por Accidentes de transito</h4>
</center>
<br>
<div class="container my-container" style="margin-bottom:10px;">
	<div class="row">
		<div class="col-sm-6 col-lg-3">
			<label for="diresa_not">Diresa</label>
			<div class="form-group">
			  <?php
			  echo form_dropdown('cod_dir', $diresa, set_value('cod_dir'), 'id="diresa_not" class="form-control" ');
			  ?>
			</div>
		</div>
		<div class="col-sm-6 col-lg-3">
			<label for="redes_les">Red</label>
			<div class="form-group">
				<?php
				echo form_dropdown('redes_not', $redes, set_value('redes_not'), 'id="redes_not" class="form-control" ');
				?>
			</div>
		</div>
		<div class="col-sm-6 col-lg-3">
			<label for="microred_not">Microred</label>
			<div class="form-group">
				<?php
				echo form_dropdown('microred_not', $microred, set_value('microred_not'), 'id="microred_not" class="form-control" ');
				?>
			</div>
		</div>
		<div class="col-sm-6 col-lg-3">
			<label for="cod_eess">eess</label>
			<div class="form-group" >
				<?php
				echo form_dropdown('cod_eess', $establec, set_value('cod_eess'), 'id="cod_eess" class="form-control"');
				?>
			</div>
		</div>
		<div class="col-sm-6 col-lg-3">
				<label for="ano_exp">Año</label>
				<div class="form-group">
					<select id="filtro_an" class="form-control">
						<?php
							for ($i=date('Y'); $i>=2005;$i--){
								echo "<option value='".$i."'>".$i."</option>";
							}
						?>
					</select>
				</div>
		</div>
		<div class="col-sm-6 col-lg-3">
			<label for="ano_exp"></label>
			<div class="form-group">
				<a class="btn btn-primary" href="#" id="ListarCasos"><i class="fa fa-filter"></i> Filtrar casos</a>
			</div>
		</div>


		<div class="registros" id="listar-registros">
		    <table class="table  table-bordered table-condensed table-hover">
		        <tr>
		            <th style="text-align: center;">Nro</th>
		            <th><?php echo $nivel; ?></th>
		            <th>ene</th>
		            <th>feb</th>
		            <th>mar</th>
		            <th>abr</th>
		            <th>may</th>
					<th>jun</th>
					<th>jul</th>
					<th>ago</th>
					<th>set</th>
					<th>oct</th>
					<th>nov</th>
					<th>dic</th>
		        </tr>
				<?php
					$nro = 1;
					$etiqueta= "class='bg-danger'";
					foreach ($casos->result_array() as $caso) {
						echo '<tr>
								<td style="text-align: center;">'.$nro++.'</td>
								<td>'.$caso[$nivel].'</td>
								<td '.($caso['ene']<1 ? $etiqueta:"").'>'.$caso['ene'].'</td>
								<td '.($caso['feb']<1 ? $etiqueta:"").'>'.$caso['feb'].'</td>
								<td '.($caso['mar']<1 ? $etiqueta:"").'>'.$caso['mar'].'</td>
								<td '.($caso['abr']<1 ? $etiqueta:"").'>'.$caso['abr'].'</td>
								<td '.($caso['may']<1 ? $etiqueta:"").'>'.$caso['may'].'</td>
								<td '.($caso['jun']<1 ? $etiqueta:"").'>'.$caso['jun'].'</td>
								<td '.($caso['jul']<1 ? $etiqueta:"").'>'.$caso['jul'].'</td>
								<td '.($caso['ago']<1 ? $etiqueta:"").'>'.$caso['ago'].'</td>
								<td '.($caso['sep']<1 ? $etiqueta:"").'>'.$caso['sep'].'</td>
								<td '.($caso['oct']<1 ? $etiqueta:"").'>'.$caso['oct'].'</td>
								<td '.($caso['nov']<1 ? $etiqueta:"").'>'.$caso['nov'].'</td>
								<td '.($caso['dic']<1 ? $etiqueta:"").'>'.$caso['dic'].'</td>
							</tr>';
					}
				?>
		    </table>
		</div>
	</div>
</div>


