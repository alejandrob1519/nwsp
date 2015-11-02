<?php
/********************************************  
*   GENERADOR DEL REPORTE DE COBERTURAS     *
*********************************************/
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
<td align="center" colspan="18"><h2><b>COBERTURA DE NOTIFICACION OPORTUNA - SE <?php echo $semana." - ".$anio;?></b></h2></td>
</tr>
<tr>
<td align="center" colspan="18"><h2><b>RED NACIONAL DE EPIDEMIOLOGIA - PERU</b></h2></td>
</tr>
<tr><td>&nbsp;</td></tr>
<tr bgcolor="#CCCCCC">
<td align="left" rowspan="2" valign="middle"><strong>DIRESA/RED/MICRORED</strong></td>
<td colspan="5"><strong>UNIDADES NOTIFICANTES REGISTRADAS</strong></td>
<td colspan="6"><strong>UNIDADES QUE NOTIFICARON OPORTUNAMENTE</strong></td>
<td colspan="4"><strong>UNIDADES QUE NO NOTIFICARON</strong></td>
<td colspan="2"><strong>COBERTURA FINAL</strong></td>
</tr>
<tr>
<td align="center"><strong>Hospital</strong></td>
<td align="center"><strong>Centro de Salud</strong></td>
<td align="center"><strong>Puesto de Salud</strong></td>
<td align="center"><strong>Otros</strong></td>
<td align="center"><strong>Total</strong></td>
<td align="center"><strong>Hospital</strong></td>
<td align="center"><strong>Centro de Salud</strong></td>
<td align="center"><strong>Puesto de Salud</strong></td>
<td align="center"><strong>Otros</strong></td>
<td align="center"><strong>Total</strong></td>
<td align="center"><strong>Porcentaje</strong></td>
<td align="center"><strong>No Notifico</strong></td>
<td align="center"><strong>Porcentaje</strong></td>
<td align="center"><strong>Negatica</strong></td>
<td align="center"><strong>Porcentaje</strong></td>
<td align="center"><strong>Cobertura</strong></td>
<td align="center"><strong>Total</strong></td>
</tr>
<?php
$color0 = "#A4B4C1";
$color1 = "#D5E7FB";
$color2 = "#E8F2FC";
$color3 = "#E0FAC5";
$color = $color1;
$x = 0;
$y = 0;
$divisor = 0;
$hos = 0;
$cs = 0;
$ps = 0;
$ot = 0;
$tot = 0;

foreach($resultado as $dato)
{
	if($x == 0){	
		echo " <tr align=\"left\" style=\"background-color:$color\" onMouseOver=\"this.style.backgroundColor='$color3'\" onMouseOut=\"this.style.backgroundColor='$color'\" >";
		$x = 1;
	}else{
		echo " <tr align=\"left\" style=\"background-color:$color2\" onMouseOver=\"this.style.backgroundColor='$color3'\" onMouseOut=\"this.style.backgroundColor='$color2'\" >";
		$x = 0;
	}

	echo "<td>";
	switch($this->session->userdata('nivel')){
		case 1:
		echo $dato->diresa;
		break;
		case 4:
		echo $dato->diresa;
		break;
		case 5:
		echo $dato->red;
		break;
		case 6:
		echo $dato->microred;
		break;
	}
	echo "</td>";
	echo "<td align='right'>";
	echo $dato->hosp_act;
	echo "</td>";
	echo "<td align='right'>";
	echo $dato->centro_act;
	echo "</td>";
	echo "<td align='right'>";
	echo $dato->puesto_act;
	echo "</td>";
	echo "<td align='right'>";
	echo $dato->otrosact;
	echo "</td>";
	echo "<td align='right'>";
	echo $dato->total_act;
	echo "</td>";
	echo "<td align='right'>";
	echo $dato->hospital;
	echo "</td>";
	echo "<td align='right'>";
	echo $dato->centro_salud;
	echo "</td>";
	echo "<td align='right'>";
	echo $dato->puesto_salud;
	echo "</td>";
	echo "<td align='right'>";
	echo $dato->otros;
	echo "</td>";
	echo "<td align='right'>";
	echo $dato->total;
	echo "</td>";
	echo "<td align='right'>";
	echo $dato->porcentaje;
	echo "</td>";
	echo "<td align='right'>";
	echo $dato->no_notifico;
	echo "</td>";
	echo "<td align='right'>";
	echo $dato->porc_nonot;
	echo "</td>";
	echo "<td align='right'>";
	echo $dato->not_neg;
	echo "</td>";
	echo "<td align='right'>";
	echo $dato->porc_notNeg;
	echo "</td>";
	echo "<td align='right'>";
	echo $dato->porcCobertura;
	echo "</td>";
	echo "<td align='right'>";
	echo $dato->porcTotal;
	echo "</td></tr>";
}
?>
<tr><td>&nbsp;</td></tr>
<tr><td colspan="14" align="center"><hr /></td></tr>
</table>
<?php
header("Content-type: application/vnd.ms-excel"); 
header("Content-disposition: attachment; filename=notificacion.xls"); 
?>
</div>
<?php
echo form_close();
?>	