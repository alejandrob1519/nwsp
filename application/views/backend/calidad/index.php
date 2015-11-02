 <?php
if($this->session->flashdata('exito') != ''){
	?>
	<div class="exitoFrontend"><?php echo $this->session->flashdata('exito'); ?></div>
	<?php
}
if($this->session->flashdata('error') != ''){
	?>
	<div class="errorFrontend"><?php echo $this->session->flashdata('error'); ?></div>
	<?php
}
if($this->session->flashdata('info') != ''){
	?>
	<div class="infoFrontend"><?php echo $this->session->flashdata('info'); ?></div>
	<?php
}
if($termina <> ""){
	?>
	<div style="width: 100%; background:#FCC; font-weight:bold; text-align:center; padding: 2px;"><?php echo $termina?></div>
    <?php
}
?>
<br/><br/><h1 style="text-align:center; text-shadow: 0.1em 0.1em 0.2em #666">Control de Calidad de la Notificaci&oacute;n Semanal</h1>
<hr />
<div class="row row-centered">
    <div class="col-centered col-xs-2 col-xs-offset-2">
        <div class="fmcircle_out">
            <a href="<?php echo site_url('backend/calidad/individualCalidad');?>">
                <div class="fmcircle_border" >
                    <div class="fmcircle_in fmcircle_blue">
                        <span>Individual</span><img src="<?php echo base_url()?>public/images/notiInd.png" alt="" />
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="col-centered col-xs-2 col-xs-offset-1">
        <div class="fmcircle_out">
            <a href="<?php echo site_url('backend/calidad/edasCalidad');?>">
                <div class="fmcircle_border">
                    <div class="fmcircle_in fmcircle_green">
                        <span>EDA's</span><img src="<?php echo base_url()?>public/images/notiCol.png" alt="" />
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="col-centered col-xs-2 col-xs-offset-1">
        <div class="fmcircle_out">
            <a href="<?php echo site_url('backend/calidad/irasCalidad') ?>">
                <div class="fmcircle_border">
                    <div class="fmcircle_in fmcircle_red">
                        <span>IRA's</span><img src="<?php echo base_url()?>public/images/notiCol.png" alt="" />
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
<hr />
<h5 style="text-align:center; font-weight:bold;">Elija la opci&oacute;n para empezar el proceso.</h5><br/><br/>
