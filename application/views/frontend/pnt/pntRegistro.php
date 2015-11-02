<?php
if($this->session->flashdata('exito') != ''){
	?>
	<div class="exito"><?php echo $this->session->flashdata('exito'); ?></div>
	<?php
}
if($this->session->flashdata('error') != ''){
	?>
	<div class="error"><?php echo $this->session->flashdata('error'); ?></div>
	<?php
}
if($this->session->flashdata('info') != ''){
	?>
	<div class="info"><?php echo $this->session->flashdata('info'); ?></div>
	<?php
}

$anio = array();

for($i=date("Y")-1;$i<=date("Y");$i++)
{
	$anio[$i] = $i;
}

$semana = array();

for($i=1;$i<=53;$i++)
{
	$semana[$i] = $i;
}

$atributos = array('id'=>'form1', 'name'=>'form1');
echo form_open_multipart('pnt/do_upload', $atributos);
?>
<div class="loginNotiWeb" style="position: relative; float:left; width:40%; margin-top: 2%; margin-left: 30%;">
<table width="100%" align="center" class="table">
    <tr><td bgcolor="#CCCCCC"><strong>&nbsp;&nbsp;A&ntilde;o de proceso:</strong></td>
    <td align="left" bgcolor="#CCCCCC">
	<?php echo form_error('anio', '<div class="warning">', '</div>'); 
    $anio[''] = "Seleccione...";
    echo form_dropdown('anio', $anio, date("Y"), 'id="anio" style="width: 160px;"');?>
    </td></tr>
    <tr><td bgcolor="#FFFFFF"><strong>&nbsp;&nbsp;Semana de proceso:</strong></td>
    <td align="left" bgcolor="#FFFFFF">
	<?php echo form_error('semana', '<div class="warning">', '</div>'); 
    $semana[''] = "Seleccione...";
    echo form_dropdown('semana', $semana, date("W")-1, 'id="semana" style="width: 160px;"');?>
    </td></tr>
    <tr>
    <td valign="middle" bgcolor="#CCCCCC"><strong>DIRESA</strong></td>
    <td valign="middle" bgcolor="#CCCCCC">
    <?php echo set_value('diresa');
	echo form_error('diresa', '<div class="warning">', '</div>'); 
    echo form_dropdown('diresa', $diresa, set_value('diresa'), 'id="diresa" style="width: 250px;"');
    ?>
    </td>
    </tr>
    <tr>
    <td valign="middle" bgcolor="#FFFFFF"><strong>Red</strong></td>
    <td valign="middle" bgcolor="#FFFFFF">
    <?php echo form_error('redes', '<div class="warning">', '</div>'); 
    echo form_dropdown('redes', $redes, set_value('redes'), 'id="redes" style="width: 250px;"');
    ?>
    </td>
    </tr><tr>
    <td valign="middle" bgcolor="#CCCCCC"><strong>Microred</strong></td>
    <td valign="middle" bgcolor="#CCCCCC">
    <?php echo form_error('microred', '<div class="warning">', '</div>'); 
    echo form_dropdown('microred', $microred, set_value('microred'), 'id="microred" style="width: 250px;"');
    ?>
    </td>
    </tr>
    <tr>
    <td valign="middle" bgcolor="#FFFFFF"><strong>Establecimiento</strong></td>
    <td valign="middle" bgcolor="#FFFFFF">
    <?php echo form_error('establec', '<div class="warning">', '</div>'); 
    echo form_dropdown('establec', $establec, set_value('establec'), 'id="establec" style="width: 250px;"');
    ?>
    </td>
    </tr>
    <tr>
    <td valign="middle" bgcolor="#CCCCCC"><strong>Archivo</strong></td>
    <td valign="middle" bgcolor="#CCCCCC">
    <?php echo form_error('userfile', '<div class="warning">', '</div>'); ?>
    <input type="file" name="userfile" size="20" />
    <br />
    <?php echo 'El tama&ntilde;o m&aacute;ximo del archivo no puede exceder: ' . ini_get('upload_max_filesize') . "\n";?>
    <br />
    <?php echo 'El sistema solo aceptar&aacute; archivos de extensi&oacute;n ZIP'; ?>
    </td>
    </tr>
    <tr>
      <td align="center" colspan="2" bgcolor="#FFFFFF">
        <input type="submit" name="enviar" value="Enviar" style="width:100px;" title="Enviar el correo" class="btn btn-primary" />
        <input type="button" name="retornar" value="Retornar" style="width:100px;" title="Retornar al login" onclick="window.location='<?php echo site_url('pnt/listadoNotificacion'); ?>'" class="btn btn-primary" /></td>
      </td>
    </tr>
</table>
</div>
<?php
    echo form_close();
?>