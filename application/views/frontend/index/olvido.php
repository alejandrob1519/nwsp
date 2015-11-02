<?php
if($this->session->flashdata('ControllerMessage') != ''){
	?>
	<div class="error"><?php echo $this->session->flashdata('ControllerMessage'); ?></div>
	<?php
}
$atributos = array('id'=>'form1', 'name'=>'form1');
echo form_open(null, $atributos);
?>
<div style="width:50%; margin-top:9%; margin-bottom:15%; margin-left:auto; margin-right:auto;">
<table width="100%" align="center" class="table">
    <tr>
      <td align="center"><img src="../../public/images/Acceso_Usuarios.jpg" width="75" width="75" /></td>
        <td align="center" valign="middle">
            <h1>&iquest;Olvid&oacute; su contrase&ntilde;a?</h1>
        </td>
  	</tr>
    <tr>
        <td colspan="2">
            <strong>Si ha olvidado su contrase&ntilde;a, registre aqu&iacute; el correo electr&oacute;nico que tiene registrado en la DGE y automaticamente recibir&aacute; un mensaje con su usuario y contrase&ntilde;a de acceso al NotiWeb.</strong>
        </td>
    </tr>
    <tr>
      <td align="center" colspan="2"><?php echo form_error('correo', '<div class="warning">', '</div>'); ?> 
     <input name="correo" type="text" id="correo" size="100" autofocus />
     </td>
    </tr>
    <tr>
      <td align="center" colspan="2">
      <input type="submit" name="enviar" value="Enviar" style="width:100px;" title="Enviar el correo" class="btn btn-primary" />
      <input type="button" name="retornar" value="Retornar" style="width:100px;" title="Retornar al login" onclick="window.location='<?php echo site_url('index/login'); ?>'" class="btn btn-primary" /></td>
    </tr>
</table>
</div>
<?php
    echo form_close();
?>