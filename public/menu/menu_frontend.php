<?php
	$menu = $this->mantenimiento_model->mostrarMenu();
	$fichas = $this->fichas_model->listarAplicaciones();
?>
<ul id="nav">
	<?php
	foreach($menu as $dato)
	{
		if($dato->enlace == '#'){
			?>
			<li class="top"><a href="<?php echo site_url($dato->enlace);?>" class="top_link"><span class="down"><?php echo $dato->denominacion;?></span></a>
			<?php
		}else{
			?>
			<li class="top"><a href="<?php echo site_url($dato->enlace);?>" class="top_link"><span><?php echo $dato->denominacion;?></span></a>
			<?php
		}
		
		if($submenu = $this->mantenimiento_model->mostrarSubMenu($dato->registroId))
		{
			?>
            <ul class="sub">
            <?php
			foreach($submenu as $dato1)
			{
				?>
                <li><a href="<?php echo site_url($dato1->enlace);?>"><?php echo $dato1->denominacion;?></a></li><br/>
                <?php	
				
				if($dato1->menu == 8){
					foreach($fichas as $dato2)
					{
						?>
						<li><a href="<?php echo site_url($dato2->enlace);?>"><?php echo $dato2->nombre;?></a></li><br/>
						<?php	
					}
				}
			}
			?>
	    	</ul>
            <?php
		}
		?>
        </li>
		<?php
	}
	?>
</ul>