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
<div id="logoPrincipal"></div>