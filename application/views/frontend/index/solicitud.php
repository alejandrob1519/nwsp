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
$atributos = array('id'=>'form1', 'name'=>'form1');
echo form_open(null, $atributos);
?>
<div style="position: relative; float:left; width:50%;">
<table class="table">
    <tr>
        <td>
        <h2 align="center">Declaraci&oacute;n Jurada</h2>
        <p align="justify">Declaro bajo juramento que:</p>
        <p align="justify">Toda la informaci&oacute;n consignada en el presente formulario electr&oacute;nico se ajusta a la verdad.</p>
        <p align="justify">Tengo pleno conocimiento de lo establecido en el Art&iacute;culo 15&ordm; inciso b de la Ley General de Salud 26842, <strong>&quot;Toda persona, usuaria de los servicios de salud, tiene derecho... a exigir la reserva de la informaci&oacute;n relacionada con el acto m&eacute;dico y su historia cl&iacute;nica...&quot;</strong></p>
        <p align="justify">Tengo pleno conocimiento de lo establecido en el Art&iacute;culo 17&ordm; de Ley de Protecci&oacute;n de datos Personales 29733, Confidencialidad de datos personales: <strong>"El titular del banco de datos personales, el encargado y quienes intervengan en cualquier parte de su tratamiento est&aacute;n obligados a guardar confidencialidad respecto de los mismos y de sus antecedentes. esta obligaci&oacute;n subsiste a&uacute;n despu&eacute;s de finalizadas las relaciones con el titular del banco de datos personales..."</strong></p>
        <p align="justify">Tengo pleno conocimiento de lo establecido en el Art&iacute;culo 38&ordm; de la Ley de Protecci&oacute;n de Datos Personales 29733, Infracciones: <strong>Son infracciones graves... Incumplir la obligaci&oacute;n de confidencialidad establecida en el Art&iacute;culo 17&ordm;"</strong></p>
        <p align="justify">Acepto las condiciones de uso de este aplicativo:</p>
        <p align="justify">El uso del usuario y contrase&ntilde;a de este aplicativo es personal e intransferible.</p>
        <p align="justify">El usuario del aplicativo es responsable del acceso a las diferentes opciones para las que se le ha otorgado derechos.</p>
        <p align="justify">El usuario debe modificar la contrase&ntilde;a asignada por el m&oacute;dulo.</p>
        <p align="justify">En caso de cesar las funciones en el cargo que viene desempe&ntilde;ando y/o dejar de prestar servicios en el lugar de trabajo consignado al solicitar el otorgamiento del usuario y/o contrase&ntilde;a de acceso, el usuario deber&aacute; inactivar los mismos mediante el uso de la opci&oacute;n determinada en el aplicativo.</p>
        <p align="justify">En caso de resultar falsa la informaci&oacute;n que he proporcionado, acepto haber incurrido en el delito de falsa declaraci&oacute;n en procesos administrativos-Art&iacute;culo 411&ordm; del C&oacute;digo Procesal Penal y delito contra la f&eacute; p&uacute;blica-T&iacute;tulo XIX del C&oacute;digo Procesal Penal, acorde al art&iacute;culo 32&ordm; de la Ley N&ordm; 27444, Ley del Procedimiento Administrativo General.</p>
        </td>
    </tr>
</table>
</div>
<div class="loginNotiWeb" style="position: relative; float:left; width:40%; margin-top: 2%; margin-left: 5%;">
<table width="100%" align="center" class="table">
    <tr>  
        <td bgcolor="#CCCCCC"><strong>DNI (*):</strong></td>
        <td bgcolor="#CCCCCC" colspan="3">
        <?php echo form_error('dni', '<div class="warning">', '</div>'); ?> 
        <input name="dni" type="text" id="dni" title="Ingrese el DNI del usuario" value="<?php echo set_value('dni')?>" />
        </td>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF"><strong>Apel. y Nombres(*):</strong></td>
      <td bgcolor="#FFFFFF" colspan="3"><?php echo form_error('nombres', '<div class="warning">', '</div>'); ?>
      <input name="nombres" type="text" id="nombres" title="Ingrese los apellidos y nombres del usuario" value="<?php echo set_value('nombres')?>" onkeyup="javascript:this.value=this.value.toUpperCase();" size="40" /></td>
    </tr>
    <tr>  
        <td bgcolor="#CCCCCC"><strong>
          Correo (*) :
      </strong></td>
        <td bgcolor="#CCCCCC" colspan="3">
        <?php echo form_error('correo', '<div class="warning">', '</div>'); ?> 
        <input name="correo" type="text" id="correo" title="Ingrese el correo electr&oacute;nico del usuario" value="<?php echo set_value('correo')?>" size="40" />
        </td>
    </tr>
    <tr>  
        <td bgcolor="#FFFFFF"><strong>
          Nivel (*) :</strong></td>
        <td bgcolor="#FFFFFF" colspan="3">
        <?php 
            echo form_error('nivel', '<div class="warning">', '</div>'); 
        ?> 
        <select name="nivel" id="nivel" title="Ingrese el nivel del usuario" style="width:140px;">
          <option value="">Elija...</option>
          <?php
          $niveles = $this->usuarios_model->buscarNiveles();
          foreach($niveles as $datos){
			  if($datos->nivel != '1' and $datos->nivel != '4'){
				  $niv = $datos->nivel;
				  $nom = $datos->nombre;
				  ?>
				  <option value="<?php echo $niv; ?>"><?php echo $nom; ?></option>
				  <?php
			  }
          }
          ?>
        </select>
        </td>
    </tr>
    <tr>  
        <td bgcolor="#FFFFFF"><strong>
          Instituci&oacute;n (*) :</strong></td>
        <td bgcolor="#FFFFFF" colspan="3">
        <?php 
            echo form_error('institucion', '<div class="warning">', '</div>'); 
        ?> 
        <select name="institucion" id="institucion" title="Ingrese la institucion del usuario" style="width:140px;">
          <option value="">Elija...</option>
		  <option value="A">MINSA</option>
		  <option value="C">ESSALUD</option>
		  <option value="D">FFAA/PNP</option>
		  <option value="X">PRIVADOS</option>
        </select>
        </td>
    </tr>
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
    </tr><tr>
    <td valign="middle" bgcolor="#FFFFFF"><strong>Establecimiento</strong></td>
    <td valign="middle" bgcolor="#FFFFFF">
    <?php echo form_error('establec', '<div class="warning">', '</div>'); 
    echo form_dropdown('establec', $establec, set_value('establec'), 'id="establec" style="width: 250px;"');
    ?>
    </td>
    </tr>
    <tr>
      <td align="center" colspan="2" bgcolor="#CCCCCC">
        <input type="submit" name="enviar" value="Enviar" style="width:100px;" title="Enviar el correo" class="btn btn-primary" />
        <input type="button" name="retornar" value="Retornar" style="width:100px;" title="Retornar al login" onclick="window.location='<?php echo site_url('index/login'); ?>'" class="btn btn-primary" /></td>
      </td>
    </tr>
</table>
</div>
<div style="position: relative; float:right; width:50%; margin-top: 2%;">
<table class="table">
    <tr>
        <td>
        <p align="justify">Los datos y an&aacute;lisis que emite este software son provisionales y pueden estar sujetos a modificaci&oacute;n. Esta informaci&oacute;n es suministrada por la Red Nacional de Epidemiolog&iacute;a (RENACE), cuya fuente es el registro de enfermedades y eventos sujetos a notificaci&oacute;n inmediata o semanal. La Semana Epidemiol&oacute;gica inicia el d&iacute;a domingo de cada semana y concluye el d&iacute;a s&aacute;bado siguiente.</p>
        <p align="justify">De no ser aprobada esta solicitud, me comprometo total y absolutamente a no solicitar explicaci&oacute;n de alguna &iacute;ndole con respecto a la decisi&oacute;n tomada por la Direcci&oacute;n General de Epidemiolog&iacute;a del Ministerio de Salud del Per&uacute;. Con el solo env&iacute;o de esta solicitud expreso que comprendo totalmente los alcances de los lineamientos aqu&iacute; establecidos y me comprometo a respetarlos y cumplirlos fielmente.</p>
        </td>
    </tr>
</table>
</div>
<?php
    echo form_close();
?>