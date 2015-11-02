<?php
/********************************************  
*   GENERADOR DEL REPORTE DE NOTIFICACION   *
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
<td align="center" colspan="14"><h2><b>Informe de Notificaci&oacute;n y Cobertura</b></h2></td>
</tr>
<tr>
<td align="left"><strong>A&ntilde;o de proceso:</strong></td>
<td align="left"><strong><?php echo $anio; ?></strong></td>
</tr>
<tr>
<td align="left"><strong>Semana de proceso:</strong></td>
<td align="left"><strong><?php echo $semana; ?></strong></td>
</tr>
<tr bgcolor="#CCCCCC">
<td align="left"><strong>Nombre</strong></td>
<td align="center"><strong>Hospital</strong></td>
<td align="center"><strong>Centro de Salud</strong></td>
<td align="center"><strong>Puesto de Salud</strong></td>
<td align="center"><strong>Otros</strong></td>
<td align="center"><strong>Total</strong></td>
<td align="center"><strong>Hospital</strong></td>
<td align="center"><strong>Centro de Salud</strong></td>
<td align="center"><strong>Puesto de Salud</strong></td>
<td align="center"><strong>Otros</strong></td>
<td align="center"><strong>Negativa</strong></td>
<td align="center"><strong>Porcentaje</strong></td>
<td align="center"><strong>Total</strong></td>
<td align="center"><strong>Porcentaje</strong></td>
</tr>
<?php
$color0 = "#A4B4C1";
$color1 = "#D5E7FB";
$color2 = "#E8F2FC";
$color3 = "#E0FAC5";
$color = $color1;
$x = 0;
foreach($resultado as $dato)
{
	if($x == 0){	
		echo " <tr align=\"left\" style=\"background-color:$color\" onMouseOver=\"this.style.backgroundColor='$color3'\" onMouseOut=\"this.style.backgroundColor='$color'\" >";
		$x = 1;
	}else{
		echo " <tr align=\"left\" style=\"background-color:$color2\" onMouseOver=\"this.style.backgroundColor='$color3'\" onMouseOut=\"this.style.backgroundColor='$color2'\" >";
		$x = 0;
	}
	echo "<td align='left'>";
	echo $dato->nombre;
	echo "</td>";
	echo "<td align='right'>";
	echo $dato->hospital;
	echo "</td>";
	echo "<td align='right'>";
	echo $dato->cs;
	echo "</td>";
	echo "<td align='right'>";
	echo $dato->ps;
	echo "</td>";
	echo "<td align='right'>";
	echo $dato->otros;
	echo "</td>";
	echo "<td align='right'>";
	echo ($dato->hospital+$dato->cs+$dato->ps+$dato->otros);
	echo "</td>";
	echo "<td align='right'>";
	echo $dato->hospital1;
	echo "</td>";
	echo "<td align='right'>";
	echo $dato->cs1;
	echo "</td>";
	echo "<td align='right'>";
	echo $dato->ps1;
	echo "</td>";
	echo "<td align='right'>";
	echo $dato->otros1;
	echo "</td>";
	echo "<td align='right'>";
	echo $dato->negativa;
	echo "</td>";
	echo "<td align='right'>";
	if(($dato->hospital1+$dato->cs1+$dato->ps1+$dato->otros1) != 0){
		echo number_format(round(($dato->negativa / ($dato->hospital1+$dato->cs1+$dato->ps1+$dato->otros1)) * 100,2),2);
	}else{
		echo "0.00";
	}
	echo "</td>";
	echo "<td align='right'>";
	echo ($dato->hospital1+$dato->cs1+$dato->ps1+$dato->otros1);
	echo "</td>";
	echo "<td align='right'>";
	if(($dato->hospital1+$dato->cs1+$dato->ps1+$dato->otros1) != 0){
		echo number_format(round((($dato->hospital+$dato->cs+$dato->ps+$dato->otros) / ($dato->hospital1+$dato->cs1+$dato->ps1+$dato->otros1)) * 100,2),2);
	}else{
		echo "0.00";
	}
	echo "</td></tr>";
}
?>
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