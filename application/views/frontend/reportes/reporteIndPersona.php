<?php
/****************************************************  
*   GENERADOR DEL REPORTE DE NOTIFICACION - PERSONA  *
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

$diag = $this->frontend_model->muestraDiagnostico($diagno);

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
<td align="center" colspan="28"><h3><b>REPORTE DE NOTIFICACION EN DESCRIPCION DE PERSONA</b></h3></td>
</tr>
<tr>
<td><b>ENFERMEDAD:</b></td><td><b><?php echo $diag->diagno;?></b></h3></td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>Reporte emitido el: </td><td align="left"><?php echo date("d-m-Y");?></td>
<td>A horas: </td><td align="left"><?php echo date("h:m:s");?></td>
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
<td rowspan="2" valign="middle">NOMBRE</td>
<td colspan="3" align="center">SEXO</td>
<td colspan="24" align="center">GRUPO DE EDAD</td>
</tr>
<tr bgcolor="#CCCCCC">
<td align="center">MASCULINO</td>
<td align="center">FEMENINO</td>
<td align="center">TOTAL</td>
<td align="center">CASOS MEN. 1 AÑO</td>
<td align="center">TASA MEN. 1 AÑO</td>
<td align="center">DEFUNCION MEN. 1 AÑO</td>
<td align="center">TASA MEN. 1 AÑO</td>
<td align="center">CASOS 1 A 11 AÑOS</td>
<td align="center">TASA 1 A 11 AÑOS</td>
<td align="center">DEFUNCION 1 A 11 AÑOS</td>
<td align="center">TASA 1 A 11 AÑOS</td>
<td align="center">CASOS 12 A 17 AÑOS</td>
<td align="center">TASA 12 A 17 AÑOS</td>
<td align="center">DEFUNCION 12 A 17 AÑOS</td>
<td align="center">TASA 12 A 17 AÑOS</td>
<td align="center">CASOS 18 A 29 AÑOS</td>
<td align="center">TASA 18 A 29 AÑOS</td>
<td align="center">DEFUNCION 18 A 29 AÑOS</td>
<td align="center">TASA 18 A 29 AÑOS</td>
<td align="center">CASOS 30 A 59 AÑOS</td>
<td align="center">TASA 30 A 59 AÑOS</td>
<td align="center">DEFUNCION 30 A 59 AÑOS</td>
<td align="center">TASA 30 A 59 AÑOS</td>
<td align="center">CASOS MAY. 60 AÑOS</td>
<td align="center">TASA MAY. 60 AÑOS</td>
<td align="center">DEFUNCION MAY. 60 AÑOS</td>
<td align="center">TASA MAY. 60 AÑOS</td>
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
	echo "<td align='left'>".$dato->nombre."</td>";
	echo "<td align='right'>".$dato->masculino."</td>";
	echo "<td align='right'>".$dato->femenino."</td>";
	echo "<td align='right'>".$dato->total."</td>";
	echo "<td align='right'>".$dato->c0."</td>";
	echo "<td align='right'>".$dato->t0."</td>";
	echo "<td align='right'>".$dato->d0."</td>";
	echo "<td align='right'>".$dato->td0."</td>";
	echo "<td align='right'>".$dato->c1_11."</td>";
	echo "<td align='right'>".$dato->t1_11."</td>";
	echo "<td align='right'>".$dato->d1_11."</td>";
	echo "<td align='right'>".$dato->td1_11."</td>";
	echo "<td align='right'>".$dato->c12_17."</td>";
	echo "<td align='right'>".$dato->t12_17."</td>";
	echo "<td align='right'>".$dato->d12_17."</td>";
	echo "<td align='right'>".$dato->td12_17."</td>";
	echo "<td align='right'>".$dato->c18_29."</td>";
	echo "<td align='right'>".$dato->t18_29."</td>";
	echo "<td align='right'>".$dato->d18_29."</td>";
	echo "<td align='right'>".$dato->td18_29."</td>";
	echo "<td align='right'>".$dato->c30_59."</td>";
	echo "<td align='right'>".$dato->t30_59."</td>";
	echo "<td align='right'>".$dato->d30_59."</td>";
	echo "<td align='right'>".$dato->td30_59."</td>";
	echo "<td align='right'>".$dato->c60."</td>";
	echo "<td align='right'>".$dato->t60."</td>";
	echo "<td align='right'>".$dato->d60."</td>";
	echo "<td align='right'>".$dato->td60."</td>";
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