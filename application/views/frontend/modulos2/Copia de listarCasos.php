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
    <center><h2>Casos Notificados de S&iacute;filis Materna y S&iacute;filis Cong&eacute;nita</h2></center>
	<div style="width: 100%;">
    <br />
    <table width="100%" align="center">
        <tr>
        <td><?php echo form_error('busqueda', '<div class="warning">', '</div>'); ?>
        B&uacute;squeda:
        <input type="text" name="busqueda"  id="busqueda" size="15"/>&nbsp;<b>* Digite el DNI del paciente (Madre)</b>
        <input type="submit" name="enviar" id="botonBuscar" value="&nbsp;Buscar..."/>
        </td>
        </tr>
    </table>
    <?php
    if(count($casos) != 0){
        ?>
        <table width="100%" align="center">
            <tr>
            <td colspan="9">
            <hr />
            </td>
            </tr>
            <tr>
              <td bgcolor="#CCCCCC"><strong>A&ntilde;o</strong></td>
              <td bgcolor="#CCCCCC"><strong>Semana</strong></td>
              <td bgcolor="#CCCCCC"><strong>Fecha Inicio</strong></td>
              <td bgcolor="#CCCCCC"><strong>DNI</strong></td>
              <td bgcolor="#CCCCCC"><strong>Ap. Paterno</strong></td>
              <td bgcolor="#CCCCCC"><strong>Ap. Materno</strong></td>
              <td bgcolor="#CCCCCC"><strong>Nombres</strong></td>
              <td bgcolor="#CCCCCC"><strong>Diagn&oacute;stico</strong></td>
              <td align="center" bgcolor="#CCCCCC"><strong>Acci&oacute;n</strong></td>
            </tr>
            <tr>
            <td colspan="9">
            <hr />
            </td>
            </tr>
        <?php
        $registros = count($casos);
        $pagina = 
        $registros .= 17;
        $i = 1;
        
        foreach($casos as $dato)
        {
            if($i == 0){
                echo "<tr  bgcolor='#fff'>";
                $i++;
            }else{
                echo "<tr  bgcolor='#F2F2F2'>";
                $i = 0;
            }
            
            echo "<td>".$dato->ano."</td>";
            echo "<td>".$dato->semana."</td>";
            echo "<td>".$this->fechas_model->modificarFechas($dato->fecha_ini)."</td>";
            echo "<td>".$dato->dni."</td>";
            echo "<td>".$dato->apepat."</td>";
            echo "<td>".$dato->apemat."</td>";
            echo "<td>".$dato->nombres."</td>";
            echo "<td>".$dato->diagnostic."</td>";
            ?>
            <td align="center">
            <a id="botonListado" href="<?php echo site_url("modulos2/RegfichaSif")."?id=".$dato->registroId;?>" title="Registrar ficha epidemiol&oacute;gica">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Registrar Ficha&nbsp;</a>
            </td>
            <?php
        }
        ?>
        </tr>
        <tr>
        <td colspan="9">
        <hr />
        </td>
        </tr>
    </table>
    </div>
    <?php
	}else{
		?>
        <hr />
        <?php
	}
?>
</div>
<?php
    echo form_close();
?>