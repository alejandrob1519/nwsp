<?php
/*****************************  
*   GENERADOR DE GRAFICOS    *
******************************/
if($this->session->flashdata('exito') != ''){
	?>
	<div class="exitoFrontend"><?php echo $this->session->flashdata('exito'); ?></div>
	<?php
}
if($this->session->flashdata('error') != ''){
	?>
	<div class="errorFrontend"><?php echo $this->session->flashdata('error'); ?></div>
	<?php
}
if($this->session->flashdata('info') != ''){
	?>
	<div class="infoFrontend"><?php echo $this->session->flashdata('info'); ?></div>
	<?php
}

$atributos = array('id'=>'form1', 'name'=>'form1');
echo form_open(null, $atributos);
?>
<fieldset class="formulario">
  <legend><strong>Generaci&oacute;n de Gr&aacute;ficos Din&aacute;micos</strong></legend>
    <div class='contenedor'>
        <div class="izquierda">
            <div style="background:#E0ECF8; font-size:12px; font-weight: bold; width:100%; float:left;">Opci&oacute;n de Proceso</div>
            <?php echo form_error('opciones', '<div class="warning">', '</div>'); ?>
            <label>
              <select name="opciones" id="opciones" style="width:100%;">
                    <option value="" selected="selected">Elija la opci&oacute;n</option>
                    <option value="1">Graficos por UBIGEO</option>
                    <!--<option value="2">Graficos por DIRESA</option>-->
              </select>
            </label>
            <div style="background:#E0ECF8; font-size:12px; font-weight: bold; width:100%; float:left;">Tipo de Enfermedad</div><br />
            <?php echo form_error('enfermedad', '<div class="warning">', '</div>'); ?>
            <label>
              <select name="enfermedad" id="enfermedad" style="width:100%;">
                    <option value="" selected="selected">Elija la opci&oacute;n</option>
                    <option value="1">Notificaci&oacute;n Individual</option>
                    <option value="2">Enfermedades Diarr&eacute;icas Agudas</option>
                    <option value="3">Infecciones Respiratorias Agudas</option>
                    <option value="4">Casos Febriles</option>
              </select>
            <div style="background:#E0ECF8; font-size:12px; font-weight: bold; width:100%; float:left;">Periodo de Proceso</div><br />
            <b>A&ntilde;o de proceso:</b>
            <?php echo form_error('anio', '<div class="warning">', '</div>'); ?>
            <label>
              <select name="anio" id="anio" style="width:54%;">
              <?php
                for($i=date("Y"); $i>=2000; $i--)
                {
                    ?>
                    <option value="<?php echo $i; ?>" <?php //if($_POST["mes"] == $i){ echo 'checked=checked'; }?>><?php echo $i; ?></option>
                    <?php
                }
              ?>
              </select>
            </label>
            <div style="background:#E0ECF8; font-size:12px; font-weight: bold; width:100%; float:left;">Nivel de Proceso</div><br />
            <?php echo form_error('nivel', '<div class="warning">', '</div>'); ?>
            <label>
            <select name='nivel' id='nivel' style="width:100%">
                <option value=''>Elija la opci&oacute;n...</option>
            </select>
            </label>
            <div style="background:#E0ECF8; font-size:12px; font-weight: bold; width:100%;  float:left;">Enfermedad para Proceso</div>
            <?php echo form_error('diagno', '<div class="warning">', '</div>'); ?>
            <label>
            <select name='diagno' id='diagno' style="width:100%">
                <option value=''>Elija la opci&oacute;n...</option>
            </select>
            <br />
            <br />
            <div style="width:100%; position:relative; text-align:center;">
                <input type="submit" id="botonAnadirG" name="enviar" value="Generar" title="Generar los gr&aacute;ficos para el an&aacute;lisis" onclick="javascript: return asegurar();" />
                <input type="button" id="botonSalir" name="enviar" value="Salir" title="Regresar a la p&aacute;gina principal" onclick="javascript:location.href='<?php echo site_url('index/principal')?>';" />
                <br />
                <br />
                <input type="button" id="botonLimpiar" name="enviar" value="&nbsp;&nbsp;&nbsp;Limpiar" title="Refrescar la p&aacute;gina" onclick="javascript:location.href='<?php echo site_url('graficos')?>';" />
                <br />
                <br />
            </div>
        </div>
    </div>
</fieldset>
<?php
    echo form_close();
?>