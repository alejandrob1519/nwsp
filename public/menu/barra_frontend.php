<?php
	$barra = $this->mantenimiento_model->mostrarBarra();
?>
<div class="barra">
&nbsp;&nbsp;&nbsp;
<?php
foreach($barra as $dato2){
	?>
	<a href="<?php echo site_url($dato2->enlace);?>">
    <img src="<?php echo base_url().'public/images/'.$dato2->imagen?>" width="35" height="35" title="<?php echo $dato2->denominacion;?>" />
    </a>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <?php
}
?>
</div>
