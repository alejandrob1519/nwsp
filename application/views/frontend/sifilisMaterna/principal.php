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
<h2 class="hidden-xs animated fadeIn" style="color:#666;">Vigilancia Epidemiológica de <br/>S&iacute;filis Materna y Cong&eacute;nita</h2><br/><br/>
</center>
<div class="row-centered">
    <div class="row">
        <div class="col-centered col-xs-12 col-xs-offset-3 col-sm-4 col-sm-offset-0 col-md-3 col-md-offset-2 col-lg-2 col-lg-offset-3 animated fadeInDown">
            <div class="fmcircle_out">
                <a href="<?php echo site_url('sifilisMaterna/listarCasos');?>">
                    <div class="fmcircle_border" >
                        <div class="fmcircle_in fmcircle_blue">
                            <span>Nueva Ficha</span><img src="<?php echo base_url()?>assets/images/nueva.png" alt="" />
                        </div>
                    </div>
                </a>
            </div>
        </div>
    
        <div class="col-centered col-xs-12 col-xs-offset-3 col-sm-4 col-sm-offset-0 col-md-3 col-lg-2 animated fadeInDown retraso1">
            <div class="fmcircle_out">
                <a href="<?php echo site_url('sifilisMaterna/listarSifilis');?>">
                    <div class="fmcircle_border">
                        <div class="fmcircle_in fmcircle_green">
                            <span>Listar Fichas</span><img src="<?php echo base_url()?>assets/images/listar.png" alt="" />
                        </div>
                    </div>
                </a>
            </div>
        </div>
      
        <div class="col-centered col-xs-12 col-xs-offset-3 col-sm-4 col-sm-offset-0 col-md-3 col-lg-2 animated fadeInDown retraso2">
            <div class="fmcircle_out">
                <a href="<?php echo site_url('sifilisMaterna/exportarSifilis');?>">
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
