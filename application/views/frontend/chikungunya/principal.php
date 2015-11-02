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
?>
<center>
<br/><br/>
<div style="position:static;">
	<img src="<?php echo base_url().'public/images/chikun.jpg'?>" alt="Chikungunya" />
</div>
<h1 class="hidden-xs animated fadeIn" style="color:#666; height: 100px; font-family:Arial, Helvetica, sans-serif">Vigilancia Epidemiológica de Fiebre de Chikungunya</h1>
</center>
<div class="row-centered">
    <div class="row">
        <div class="col-centered col-xs-12 col-xs-offset-3 col-sm-4 col-sm-offset-0 col-md-3 col-md-offset-2 col-lg-2 col-lg-offset-3">
            <div class="fmcircle_out">
                <a href="<?php echo site_url('modulos/listarCasos');?>">
                    <div class="fmcircle_border" >
                        <div class="fmcircle_in fmcircle_blue">
                            <span>Nueva Ficha</span><img src="<?php echo base_url()?>assets/images/nueva.png" alt="" />
                        </div>
                    </div>
                </a>
            </div>
        </div>
    
        <div class="col-centered col-xs-12 col-xs-offset-3 col-sm-4 col-sm-offset-0 col-md-3 col-lg-2">
            <div class="fmcircle_out">
                <a href="<?php echo site_url('modulos/listarChikungunya');?>">
                    <div class="fmcircle_border">
                        <div class="fmcircle_in fmcircle_green">
                            <span>Listar Fichas</span><img src="<?php echo base_url()?>assets/images/listar.png" alt="" />
                        </div>
                    </div>
                </a>
            </div>
        </div>
      
        <div class="col-centered col-xs-12 col-xs-offset-3 col-sm-4 col-sm-offset-0 col-md-3 col-lg-2">
            <div class="fmcircle_out">
                <a href="<?php echo site_url('modulos/exportarChikungunya') ?>">
                    <div class="fmcircle_border">
                        <div class="fmcircle_in fmcircle_red">
                            <span>Exportar Datos</span><img src="<?php echo base_url()?>assets/images/exportar.png" alt="" />
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>	
