<?php
/****************************************************  
*   GENERADOR DEL REPORTE DE NOTIFICACION - TIEMPO  *
*****************************************************/
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

if($nivel == "ubigeo"){
	$dep = $this->frontend_model->buscarDepartamento($departamento);
	$prov = $this->frontend_model->buscarProvincia($provincia);
	$dist = $this->frontend_model->muestraDistrito($distrito);
}elseif($nivel == "eess"){
	$dir = $this->frontend_model->mostrarLineaDiresa($diresa);
	$red = $this->frontend_model->mostrarLineaRed($diresa, $redes);
	$mic = $this->frontend_model->mostrarLineaMicrored($diresa, $redes, $microred);
	$est = $this->frontend_model->mostrarLineaEstablecimiento($establec);
}

$atributos = array('id'=>'form1', 'name'=>'form1');
echo form_open(null, $atributos);
?>
<div style="position: absolute; padding-top: 5px; padding-left: 5px;"><img src="<?php echo base_url()?>public/images/logo.png" width="350" /></div>
<div style="height: 570px; overflow: auto; border:#999 1px solid; padding-top: 2%;">
<table width="100%" align="center" class="table">
<tr>
<td>&nbsp;</td>
</tr>
<tr>
<td>&nbsp;</td>
</tr>
<tr>
<td align="center" colspan="13"><h3><b>REPORTE DE NOTIFICACION DE EDA EN DESCRIPCION DE TIEMPO</b></h3></td>
</tr>
<tr>
<td colspan="8">&nbsp;</td>
<td>Reporte emitido el: </td><td><?php echo date("d-m-Y");?></td>
<td align="right">A horas: </td><td><?php echo date("h:m:s");?></td>
</tr>
<tr>
<td><b>NIVEL:</b></td>
<td><b>DEPARTAMENTO:</b></td><td><b><?php echo $dep->nombre;?></b></h3></td><td></td><td><b>DIRESA:</b></td><td><b><?php echo $dir->nombre;?></b></h3></td></tr>
<tr><td></td><td><b>PROVINCIA:</b></td><td><b><?php echo $prov->nombre;?></b></h3></td><td></td><td><b>RED:</b></td><td><b><?php echo $red->nombre;?></b></h3></td></tr>
<tr><td></td><td><b>DISTRITO:</b></td><td><b><?php echo $dist->nombre;?></b></h3></td><td></td><td><b>MICRORED:</b></td><td><b><?php echo $mic->nombre;?></b></h3></td></tr>
<tr><td></td><td></td><td><td></td><td><b>ESTABLECIMIENTO:</b></td><td><b><?php echo $est->raz_soc;?></b></h3></td></tr>
<tr>
<td>&nbsp;</td>
</tr>
</table>
<table width="100%" align="center" class="table" border="1">
<tr bgcolor="#CCCCCC">
<td rowspan="2" valign="middle">SEMANA</td>
<td colspan="4" align="center"><?php echo $anio - 2; ?></td>
<td colspan="4" align="center"><?php echo $anio - 1; ?></td>
<td colspan="4" align="center"><?php echo $anio; ?></td>
</tr>
<tr bgcolor="#CCCCCC">
<td align="center">CASOS</td>
<td align="center">TASA</td>
<td align="center">DEFUNCION</td>
<td align="center">LETALIDAD</td>
<td align="center">CASOS</td>
<td align="center">TASA</td>
<td align="center">DEFUNCION</td>
<td align="center">LETALIDAD</td>
<td align="center">CASOS</td>
<td align="center">TASA</td>
<td align="center">DEFUNCION</td>
<td align="center">LETALIDAD</td>
</tr>
<?php
$color0 = "#A4B4C1";
$color1 = "#D5E7FB";
$color2 = "#E8F2FC";
$color3 = "#E0FAC5";
$color = $color1;
$x=0;
$y = 0;

foreach($resultado as $dato)
{
	if($x == 0){	
		echo " <tr align=\"left\" style=\"background-color:$color\" onMouseOver=\"this.style.backgroundColor='$color3'\" onMouseOut=\"this.style.backgroundColor='$color'\" >";
		$x = 1;
	}else{
		echo " <tr align=\"left\" style=\"background-color:$color2\" onMouseOver=\"this.style.backgroundColor='$color3'\" onMouseOut=\"this.style.backgroundColor='$color2'\" >";
		$x = 0;
	}
	echo "<td align='right'>".$dato->semana."</td>";
	echo "<td align='right'>".$dato->casos_1."</td>";
	echo "<td align='right'>".$dato->inc_1."</td>";
	echo "<td align='right'>".$dato->def_1."</td>";
	echo "<td align='right'>".$dato->letal_1."</td>";
	echo "<td align='right'>".$dato->casos_2."</td>";
	echo "<td align='right'>".$dato->inc_2."</td>";
	echo "<td align='right'>".$dato->def_2."</td>";
	echo "<td align='right'>".$dato->letal_2."</td>";
	echo "<td align='right'>".$dato->casos_3."</td>";
	echo "<td align='right'>".$dato->inc_3."</td>";
	echo "<td align='right'>".$dato->def_3."</td>";
	echo "<td align='right'>".$dato->letal_3."</td>";
	echo "</tr>";
}
?>
</tr>
</table>
<?php
header("Content-type: application/vnd.ms-excel"); 
header("Content-disposition: attachment; filename=notificacion.xls"); 
?>
</div>
<?php
echo form_close();
?>	