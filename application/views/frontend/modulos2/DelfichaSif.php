<?php
    if($this->session->flashdata('ControllerMessage') != ''){
        ?>
        <div class="error"><?php echo $this->session->flashdata('ControllerMessage'); ?></div>
        <?php
    }
    $atributos = array('id'=>'form1', 'name'=>'form1');
    echo form_open(null, $atributos);
?>
<div class="formulario1">
    <center><h2>Ficha de Investigaci&oacute;n Epidemiol&oacute;gica</h2></center>
    <center><h2>S&iacute;filis Materna y S&iacute;filis Cong&eacute;nita</h2></center>
	<div style="border: solid 1px #000; width: 100%;">
		<table width="100%" align="center">
			<tr>
			  <td colspan="4" bgcolor="#000" style="color:#FFF;"><strong>&nbsp;I. DATOS GENERALES:</strong></td>
		  	</tr>
			<tr>
			  <td colspan="4" bgcolor="#CCCCCC"><hr/></td>
	  	  </tr>
			<tr>
				<td><strong>Apellidos y nombres de la madre:</strong></td>
			  	<td>
	              <input name="madre_apenom" type="text" id="madre_apenom" title="Vienen del NotiWeb" value="<?php echo $modificar->madre_apenom;?>" size="50" readonly="readonly" /></td>
			  	<td colspan="2"><strong>Código (DNI Madre)</strong></td>
	  	  	</tr>
            <tr>
				<td><strong>Apellidos y nombres del hijo (a):</strong></td>
			  	<td><?php echo form_error('hijo_apenom', '<div class="warning">', '</div>'); ?>
	              <input name="hijo_apenom" type="text" id="hijo_apenom" title="Registrar los apellidos y nombres del hijo (a)" value="<?php echo $modificar->hijo_apenom;?>" onkeyup="javascript:this.value=this.value.toUpperCase();" size="50" /></td>
			  	<td colspan="2"><input name="codigo" type="text" id="codigo" title="Vienen del NotiWeb" value="<?php echo $modificar->codigo;?>" size="15" readonly="readonly" /></td>
	  	  	</tr>
		    <tr>
		      <td><strong>Establecimiento de Salud:</strong></td>
			   <td><input name="establecimiento" type="text" id="establecimiento" title="Vienen del NotiWeb" value="<?php echo $modificar->raz_soc;?>" size="50" readonly="readonly" /></td>
			   <td colspan="2"><strong>Nivel de establecimiento</strong></td>
	      	</tr>
			<tr>
			   <td><strong>Instituci&oacute;n:</strong></td>
			   <td><input name="insti" type="text" id="insti" title="Vienen del NotiWeb" value="<?php echo $modificar->institucion;?>" size="15" readonly="readonly" /></td>
			   <td colspan="2"><input name="categoria" type="text" id="categoria" title="Vienen del NotiWeb" value="<?php echo $modificar->categoria;?>" size="15" readonly="readonly" /></td>
	      	</tr>
		    <tr>  
				<td><strong>DISA/DIRESA/GERESA</strong></td>
				<td><strong>Redes</strong></td>
				<td colspan="2"><strong>Microred</strong></td>
		  	</tr>
            <tr>
				<td><input name="subregion" type="text" id="subregion" title="Vienen del NotiWeb" value="<?php echo $modificar->diresas;?>" size="25" readonly="readonly" /></td>
				<td><input name="red" type="text" id="red" title="Vienen del NotiWeb" value="<?php echo $modificar->redes;?>" size="50" readonly="readonly" /></td>
				<td colspan="2"><input name="mred" type="text" id="mred" title="Vienen del NotiWeb" value="<?php echo $modificar->microredes;?>" size="50" readonly="readonly" /></td>
          	</tr>
            <tr>
              <td><strong>Fecha de notificaci&oacute;n</strong></td>
              <td><strong>Semana epidemiol&oacute;gica</strong></td>
              <td colspan="2"><strong>Investigaci&oacute;n de:</strong></td>
            </tr>
            <tr>
              <td><?php echo form_error('fecha_not', '<div class="warning">', '</div>'); ?>
              <input name="fecha_not" type="text" id="fecha_not" title="Ingrese la fecha de investigaci&oacute;n" value="<?php echo $this->fechas_model->modificarFechas($modificar->fecha_not);?>" size="15" /></td>
              <td><input name="semana" type="text" id="semana" title="Vienen del NotiWeb" value="<?php echo $modificar->semana;?>" size="5" readonly="readonly" /></td>
              <td><?php echo form_error('sifilis1', '<div class="warning">', '</div>'); 
			  if($modificar->tiposMat == "1"){
				  ?>
				  <input name="sifilis1" type="checkbox" id="sifilis1" checked="checked" title="Haga click de ser el caso" /> 
                  <?php
			  }else{
				  ?>
				  <input name="sifilis1" type="checkbox" id="sifilis1" title="Haga click de ser el caso" /> 
                  <?php
			  }
			  ?>
			  <strong>S&iacute;filis materna</strong>&nbsp;&nbsp;</td>
              <td><?php echo form_error('sifilis2', '<div class="warning">', '</div>'); 
			  if($modificar->tiposCon == "1"){
				  ?>
				  <input name="sifilis2" type="checkbox" id="sifilis2" checked="checked" title="Haga click de ser el caso" /> 
                  <?php
			  }else{
				  ?>
				  <input name="sifilis2" type="checkbox" id="sifilis2" title="Haga click de ser el caso" /> 
                  <?php
			  }
			  ?>
              <strong>S&iacute;filis cong&eacute;nita</strong></td>
            </tr>
			<tr>
			  <td colspan="9" bgcolor="#CCCCCC"><hr/></td>
	  	  	</tr>
        </table>
        <table width="100%" align="center">
        	<tr>
            <td><?php echo form_error('notificador', '<div class="warning">', '</div>'); ?>
            <strong>Nombres y apellidos del notificador:</strong>&nbsp;&nbsp;<input name="notificador" type="text" id="notificador" title="apellidos y nombres del responsable de la notificaci&oacute;n" value="<?php echo $modificar->notificador;?>" size="50" onkeyup="javascript:this.value=this.value.toUpperCase();" /></td>
            </tr>
			<tr>
			  <td><hr/></td>
	  	    </tr>
            <tr>
			  <td align="right">
				<input type="button" id="botonListado" name="volver" value="&nbsp;&nbsp;&nbsp;Listado" onclick="window.location='<?php echo site_url('modulos2/listarSifilis'); ?>'" />
				<input type="button" id="botonEliminar" name="eliminar" value="&nbsp;&nbsp;&nbsp;Eliminar" onclick="javascript:return asegurar();" />
                <input type="hidden" id="regis" name="regis" value="<?php echo $registro['id'];?>" />
                <input type="hidden" id="estab" name="estab" value="<?php echo $modificar->establecimiento;?>" />
                <input type="hidden" id="dir" name="dir" value="<?php echo $modificar->diresa;?>" />
                <input type="hidden" id="rd" name="rd" value="<?php echo $modificar->red;?>" />
                <input type="hidden" id="mrd" name="mrd" value="<?php echo $modificar->microred;?>" />
			  </td>
		  </tr>
        </table>
    </div>
    <br/>  
</div>
<?php
    echo form_close();
?>