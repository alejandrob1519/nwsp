<?php
	$atributos = array('id'=>'form1', 'name'=>'form1');
    echo form_open(null, $atributos);
?>
<div class="loginNotiWeb">
    <table width="100%" align="center">
        <tr>
            <td width="45%">
                <center><img src="<?php echo base_url()?>public/images/cambio.png" width="50" height="50" /></center>
            </td>
            <td width="55%">
                <h2>Cambio de clave</h2>
            </td>
        </tr>
        <tr>
        	<td colspan="2" align="center">
            <b style="color:#F00; font-size:10px;">Se ha enviado un c&oacute;digo de seguridad al correo electr&oacute;nico con el que registr&oacute su declaraci&oacute;n jurada; por primera vez, por favor ingr&eacute;selo para poder cambiar su contrase&ntilde;a.</b><br/>
            <b style="color:#000; font-size:10px;">Recuerde que cada vez que ingresa a esta ventana se le env&iacute;a un nuevo c&oacute;digo de seguridad, caducando el anterior.</b>
			</td>
		</tr>
        <tr>
	        <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;&nbsp;
                <strong>Usuario:</strong>
            </td>
            <td>
                <?php echo form_error('usuario', '<div class="warning">', '</div>'); ?> 
                <input name="usuario" maxlength="100" id="inputUsuario" title="Registre su usuario asignado" value="<?php if(!$this->input->post()){ echo $this->session->userdata('usuario'); }else{echo set_value('usuario');}?>" autofocus />
            </td>
        </tr>
        <tr>
            <td>&nbsp;&nbsp;
                <strong>Nueva Clave:</strong>
            </td>
            <td>
                <?php echo form_error('clave', '<div class="warning">', '</div>'); ?> 
                <input name="clave" type="password" maxlength="100" id="inputClave" title="Digite su nueva contrase&ntilde;a" value="<?php echo set_value('clave')?>" onblur="javascript: cambia();" />
            </td>
        </tr>
        <tr>
            <td>&nbsp;&nbsp;
                <strong>Verifica:</strong>
            </td>
            <td>
                <input name="nueva" type="text" maxlength="100" id="inputClave" title="Verifique su contrase&ntilde;a digitada" value="<?php echo set_value('clave')?>" readonly="readonly" />
            </td>
        </tr>
        <tr>
            <td>&nbsp;&nbsp;
                <strong>C&oacute;digo:</strong>
            </td>
            <td>
                <?php echo form_error('seguridad', '<div class="warning">', '</div>'); ?> 
                <input name="seguridad" type="text" maxlength="100" id="seguridad" title="Ingrese el c&oacute;digo enviado a su correo" value="<?php echo set_value('seguridad')?>" />&nbsp;<b>*</b>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <br />
                <input type="submit" name="enviar" value="Cambiar" />
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <br />
            </td>
        </tr>
    </table>
</div>
<?php
    echo form_close();
?>