<?php
if($this->session->flashdata('ControllerMessage') != ''){
	?>
	<div class="error"><?php echo $this->session->flashdata('ControllerMessage'); ?></div>
	<?php
}
?>
