<?php
    if($this->session->flashdata('ControllerMessage') != ''){
        ?>
        <div class="error"><?php echo $this->session->flashdata('ControllerMessage'); ?></div>
        <?php
    }
    $atributos = array('id'=>'form1', 'name'=>'form1');
    echo form_open(null, $atributos);
?>
<div class="login">
    <table width="100%" align="center">
        <tr>
            <td>
                <center><img src="<?php echo base_url()?>public/images/Acceso_Usuarios.jpg" width="50" height="50" /></center>
            </td>
            <td>
                <h1>Acceso</h1>
            </td>
        </tr>
        <tr>
            <td>
                <strong>Usuario:</strong>
            </td>
            <td>
                <?php echo form_error('usuario', '<div class="warning" style="position: relative;">', '</div>'); ?> 
                <input name="usuario" maxlength="100" id="inputUsuario" title="Registre su usuario asignado" value="<?php echo set_value('usuario')?>" autofocus />
            </td>
        </tr>
        <tr>
            <td>
                <strong>Contrase&ntilde;a:</strong>
            </td>
            <td>
                <?php echo form_error('clave', '<div class="warning" style="position: relative;">', '</div>'); ?> 
                <input name="clave" type="password" maxlength="100" id="inputClave" title="Registre su contrase&ntilde;a asignada" value="<?php echo set_value('clave')?>" />
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <br />
                <input type="submit" name="enviar" value="Acceder" />
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
<div id="chikungunya"></div>
<!--<div id="notifica">Notificaci&oacute;n</div>
-->