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
<td>&nbsp;</td>
</tr>
<tr>
<td>&nbsp;</td>
</tr>
<tr>
<td align="center" colspan="54"><h2><b>REPORTE DE NOTIFICACION - SE <?php echo $semana." - ".$anio;?></b></h2></td>
</tr>
<tr>
<td>&nbsp;</td>
</tr>
<tr bgcolor="#CCCCCC">
<td>NOMBRE</td>
<?php
for($i=1; $i<=53; $i++){
	echo "<td>".$i."</td>";
}
?>
</tr>
<?php
$color0 = "#A4B4C1";
$color1 = "#D5E7FB";
$color2 = "#E8F2FC";
$color3 = "#E0FAC5";
$color = $color1;
$x=0;

foreach($resultado as $dato)
{
/*	if($x == 0){	
		echo " <tr align=\"left\" style=\"background-color:$color\" onMouseOver=\"this.style.backgroundColor='$color3'\" onMouseOut=\"this.style.backgroundColor='$color'\" >";
		$x = 1;
	}else{
		echo " <tr align=\"left\" style=\"background-color:$color2\" onMouseOver=\"this.style.backgroundColor='$color3'\" onMouseOut=\"this.style.backgroundColor='$color2'\" >";
		$x = 0;
	}
*/	
	echo "<tr>";
	echo "<td>".$dato->nombre."</td>";
	if($dato->s1 != 0){ echo "<td bg-color:'#81F7BE'>".'Si'; }else{ echo "<td bg-color: '#F5BCA9'>".'No'."</td>";}
	if($dato->s2 != 0){ echo "<td bg-color:'#81F7BE'>".'Si'; }else{ echo "<td bg-color: '#F5BCA9'>".'No'."</td>";}
	if($dato->s3 != 0){ echo "<td bg-color:'#81F7BE'>".'Si'; }else{ echo "<td bg-color: '#F5BCA9'>".'No'."</td>";}
	if($dato->s4 != 0){ echo "<td bg-color:'#81F7BE'>".'Si'; }else{ echo "<td bg-color: '#F5BCA9'>".'No'."</td>";}
	if($dato->s5 != 0){ echo "<td bg-color:'#81F7BE'>".'Si'; }else{ echo "<td bg-color: '#F5BCA9'>".'No'."</td>";}
	if($dato->s6 != 0){ echo "<td bg-color:'#81F7BE'>".'Si'; }else{ echo "<td bg-color: '#F5BCA9'>".'No'."</td>";}
	if($dato->s7 != 0){ echo "<td bg-color:'#81F7BE'>".'Si'; }else{ echo "<td bg-color: '#F5BCA9'>".'No'."</td>";}
	if($dato->s8 != 0){ echo "<td bg-color:'#81F7BE'>".'Si'; }else{ echo "<td bg-color: '#F5BCA9'>".'No'."</td>";}
	if($dato->s9 != 0){ echo "<td bg-color:'#81F7BE'>".'Si'; }else{ echo "<td bg-color: '#F5BCA9'>".'No'."</td>";}
	if($dato->s10 != 0){ echo "<td bg-color: '#81F7BE'>".'Si'; }else{ echo "<td bg-color: '#F5BCA9'>".'No'."</td>";}
	if($dato->s11 != 0){ echo "<td bg-color: '#81F7BE'>".'Si'; }else{ echo "<td bg-color: '#F5BCA9'>".'No'."</td>";}
	if($dato->s12 != 0){ echo "<td bg-color: '#81F7BE'>".'Si'; }else{ echo "<td bg-color: '#F5BCA9'>".'No'."</td>";}
	if($dato->s13 != 0){ echo "<td bg-color: '#81F7BE'>".'Si'; }else{ echo "<td bg-color: '#F5BCA9'>".'No'."</td>";}
	if($dato->s14 != 0){ echo "<td bg-color: '#81F7BE'>".'Si'; }else{ echo "<td bg-color: '#F5BCA9'>".'No'."</td>";}
	if($dato->s15 != 0){ echo "<td bg-color: '#81F7BE'>".'Si'; }else{ echo "<td bg-color: '#F5BCA9'>".'No'."</td>";}
	if($dato->s16 != 0){ echo "<td bg-color: '#81F7BE'>".'Si'; }else{ echo "<td bg-color: '#F5BCA9'>".'No'."</td>";}
	if($dato->s17 != 0){ echo "<td bg-color: '#81F7BE'>".'Si'; }else{ echo "<td bg-color: '#F5BCA9'>".'No'."</td>";}
	if($dato->s18 != 0){ echo "<td bg-color: '#81F7BE'>".'Si'; }else{ echo "<td bg-color: '#F5BCA9'>".'No'."</td>";}
	if($dato->s19 != 0){ echo "<td bg-color: '#81F7BE'>".'Si'; }else{ echo "<td bg-color: '#F5BCA9'>".'No'."</td>";}
	if($dato->s20 != 0){ echo "<td bg-color: '#81F7BE'>".'Si'; }else{ echo "<td bg-color: '#F5BCA9'>".'No'."</td>";}
	if($dato->s21 != 0){ echo "<td bg-color: '#81F7BE'>".'Si'; }else{ echo "<td bg-color: '#F5BCA9'>".'No'."</td>";}
	if($dato->s22 != 0){ echo "<td bg-color: '#81F7BE'>".'Si'; }else{ echo "<td bg-color: '#F5BCA9'>".'No'."</td>";}
	if($dato->s23 != 0){ echo "<td bg-color: '#81F7BE'>".'Si'; }else{ echo "<td bg-color: '#F5BCA9'>".'No'."</td>";}
	if($dato->s24 != 0){ echo "<td bg-color: '#81F7BE'>".'Si'; }else{ echo "<td bg-color: '#F5BCA9'>".'No'."</td>";}
	if($dato->s25 != 0){ echo "<td bg-color: '#81F7BE'>".'Si'; }else{ echo "<td bg-color: '#F5BCA9'>".'No'."</td>";}
	if($dato->s26 != 0){ echo "<td bg-color: '#81F7BE'>".'Si'; }else{ echo "<td bg-color: '#F5BCA9'>".'No'."</td>";}
	if($dato->s27 != 0){ echo "<td bg-color: '#81F7BE'>".'Si'; }else{ echo "<td bg-color: '#F5BCA9'>".'No'."</td>";}
	if($dato->s28 != 0){ echo "<td bg-color: '#81F7BE'>".'Si'; }else{ echo "<td bg-color: '#F5BCA9'>".'No'."</td>";}
	if($dato->s29 != 0){ echo "<td bg-color: '#81F7BE'>".'Si'; }else{ echo "<td bg-color: '#F5BCA9'>".'No'."</td>";}
	if($dato->s30 != 0){ echo "<td bg-color: '#81F7BE'>".'Si'; }else{ echo "<td bg-color: '#F5BCA9'>".'No'."</td>";}
	if($dato->s31 != 0){ echo "<td bg-color: '#81F7BE'>".'Si'; }else{ echo "<td bg-color: '#F5BCA9'>".'No'."</td>";}
	if($dato->s32 != 0){ echo "<td bg-color: '#81F7BE'>".'Si'; }else{ echo "<td bg-color: '#F5BCA9'>".'No'."</td>";}
	if($dato->s33 != 0){ echo "<td bg-color: '#81F7BE'>".'Si'; }else{ echo "<td bg-color: '#F5BCA9'>".'No'."</td>";}
	if($dato->s34 != 0){ echo "<td bg-color: '#81F7BE'>".'Si'; }else{ echo "<td bg-color: '#F5BCA9'>".'No'."</td>";}
	if($dato->s35 != 0){ echo "<td bg-color: '#81F7BE'>".'Si'; }else{ echo "<td bg-color: '#F5BCA9'>".'No'."</td>";}
	if($dato->s36 != 0){ echo "<td bg-color: '#81F7BE'>".'Si'; }else{ echo "<td bg-color: '#F5BCA9'>".'No'."</td>";}
	if($dato->s37 != 0){ echo "<td bg-color: '#81F7BE'>".'Si'; }else{ echo "<td bg-color: '#F5BCA9'>".'No'."</td>";}
	if($dato->s38 != 0){ echo "<td bg-color: '#81F7BE'>".'Si'; }else{ echo "<td bg-color: '#F5BCA9'>".'No'."</td>";}
	if($dato->s39 != 0){ echo "<td bg-color: '#81F7BE'>".'Si'; }else{ echo "<td bg-color: '#F5BCA9'>".'No'."</td>";}
	if($dato->s40 != 0){ echo "<td bg-color: '#81F7BE'>".'Si'; }else{ echo "<td bg-color: '#F5BCA9'>".'No'."</td>";}
	if($dato->s41 != 0){ echo "<td bg-color: '#81F7BE'>".'Si'; }else{ echo "<td bg-color: '#F5BCA9'>".'No'."</td>";}
	if($dato->s42 != 0){ echo "<td bg-color: '#81F7BE'>".'Si'; }else{ echo "<td bg-color: '#F5BCA9'>".'No'."</td>";}
	if($dato->s43 != 0){ echo "<td bg-color: '#81F7BE'>".'Si'; }else{ echo "<td bg-color: '#F5BCA9'>".'No'."</td>";}
	if($dato->s44 != 0){ echo "<td bg-color: '#81F7BE'>".'Si'; }else{ echo "<td bg-color: '#F5BCA9'>".'No'."</td>";}
	if($dato->s45 != 0){ echo "<td bg-color: '#81F7BE'>".'Si'; }else{ echo "<td bg-color: '#F5BCA9'>".'No'."</td>";}
	if($dato->s46 != 0){ echo "<td bg-color: '#81F7BE'>".'Si'; }else{ echo "<td bg-color: '#F5BCA9'>".'No'."</td>";}
	if($dato->s47 != 0){ echo "<td bg-color: '#81F7BE'>".'Si'; }else{ echo "<td bg-color: '#F5BCA9'>".'No'."</td>";}
	if($dato->s48 != 0){ echo "<td bg-color: '#81F7BE'>".'Si'; }else{ echo "<td bg-color: '#F5BCA9'>".'No'."</td>";}
	if($dato->s49 != 0){ echo "<td bg-color: '#81F7BE'>".'Si'; }else{ echo "<td bg-color: '#F5BCA9'>".'No'."</td>";}
	if($dato->s50 != 0){ echo "<td bg-color: '#81F7BE'>".'Si'; }else{ echo "<td bg-color: '#F5BCA9'>".'No'."</td>";}
	if($dato->s51 != 0){ echo "<td bg-color: '#81F7BE'>".'Si'; }else{ echo "<td bg-color: '#F5BCA9'>".'No'."</td>";}
	if($dato->s52 != 0){ echo "<td bg-color: '#81F7BE'>".'Si'; }else{ echo "<td bg-color: '#F5BCA9'>".'No'."</td>";}
	if($dato->s53 != 0){ echo "<td bg-color: '#81F7BE'>".'Si'; }else{ echo "<td bg-color: '#F5BCA9'>".'No'."</td>";}
}
?>
</tr>
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