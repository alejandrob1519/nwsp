<?php
if($this->session->flashdata('ControllerMessage') != ''){
	?>
	<div class="error"><?php echo $this->session->flashdata('ControllerMessage'); ?></div>
	<?php
}
?>
<div style="width: auto; height: 570px; overflow: auto;">
<embed src="<?php echo base_url().'public/documentos/Fichamnp.pdf'?>" width="100%" height="100%" />
</div>