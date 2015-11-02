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
	<?php
}

$login = $this->session->userdata("usuario");

if(empty($login)){
	redirect(site_url("index/login"), 301);
}
//echo "<div class='col-lg-12 col-lg-offset-4'><br/><br/><br/><br/><br/>";
//echo "<img src='".base_url();
//echo "uploads/logo.png'>";
//echo "</div>";
?>


<center>
<h2 class="animated fadeIn" style="color:#666;">Vigilancia Epidemiológica de Lesiones <br/> por Accidentes de transito</h2><br/><br/>
</center>
<div class="row-centered">

	<div class="col-centered col-xs-7 col-sm-4 col-md-3 col-lg-2 animated fadeInDown">
		<div class="fmcircle_out">
			<a href="<?php echo site_url('modulotransito/registro_transito');?>">
				<div class="fmcircle_border" >
					<div class="fmcircle_in fmcircle_blue">
						<span>Nueva Ficha</span><img src="<?php echo base_url()?>assets/images/nueva.png" alt="" />
					</div>
				</div>
			</a>
		</div>
	</div>

	<div class="col-centered col-xs-7 col-sm-4 col-md-3 col-lg-2 animated fadeInDown retraso1">
		<div class="fmcircle_out">
			<a href="<?php echo site_url('modulotransito/listar_transito');?>">
				<div class="fmcircle_border">
					<div class="fmcircle_in fmcircle_green">
						<span>Listar Fichas</span><img src="<?php echo base_url()?>assets/images/listar.png" alt="" />
					</div>
				</div>
			</a>
		</div>
	</div>

	<div class="col-centered col-xs-7 col-sm-4 col-md-3 col-lg-2 animated fadeInDown retraso2">
		<div class="fmcircle_out">
			<a href="<?php echo site_url('modulotransito/exportar') ?>">
				<div class="fmcircle_border">
					<div class="fmcircle_in fmcircle_red">
						<span>Exportar Base</span><img src="<?php echo base_url()?>assets/images/exportar.png" alt="" />
					</div>
				</div>
			</a>
		</div>
	</div>
</div>
