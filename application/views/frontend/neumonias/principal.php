<?php
if($this->session->flashdata('ControllerMessage') != ''){
	?>
	<div class="error"><?php echo $this->session->flashdata('ControllerMessage'); ?></div>
	<?php
}
?>
<div style="width:50%; height:10%; margin-left:auto; margin-right:auto; margin-top: 10%;">
<table width="100%" align="center">
<tr>
<td align="center">
<a href="<?php echo site_url('neumonias/directiva') ?>" ><img src="<?php echo base_url()?>public/images/Book.ico" width="200px" height="200px" title="Directiva epidemiol&oacute;gica de la vigilancia" />
<p>Directiva Epidemiol&oacute;gica</p></a><a href="directiva.php">directiva.php</a>
</td>
<td align="center">
<a href="<?php echo site_url('neumonias/anexo03') ?>" ><img src="<?php echo base_url()?>public/images/ficha.png" width="200px" height="200px" title="Ficha Epidemiol&oacute;gica" />
<p>Ficha Epidemiol&oacute;gica</p></a>
</td>
<td align="center">
<a href="<?php echo site_url('neumonias/instructivo') ?>" ><img src="<?php echo base_url()?>public/images/instructivo.png" width="200px" height="200px" title="Instructivo de la Ficha" />
<p>Instructivo de la Ficha</p></a>
</td>
</tr>
</table>
</div>