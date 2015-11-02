<?php
if($Recordset1['proceso'] == '2'){
	$enf = $Recordset1['enf'];
	$q1 = $Recordset1['q1'];
	$q2 = $Recordset1['q2'];
	$q3 = $Recordset1['q3'];
	$q4 = $Recordset1['q4'];
	$q5 = $Recordset1['q5'];
	$proceso = $Recordset1['proceso'];
	$habitantes = $Recordset1['hab'];
}elseif($Recordset1['proceso'] == '1'){
	$enf = $Recordset1['enf'];
	$q1 = $Recordset1['q1'];
	$q2 = $Recordset1['q2'];
	$proceso = $Recordset1['proceso'];
	$habitantes = $Recordset1['hab'];
}elseif($Recordset1['proceso'] == '3'){
	$enf = $Recordset1['enf'];
	$q1 = $Recordset1['q1'];
	$q2 = $Recordset1['q2'];
	$q3 = $Recordset1['q3'];
	$proceso = $Recordset1['proceso'];
	$habitantes = $Recordset1['hab'];
}
?>
<hr />
<table width="100%" border = '0' style="font-size:11px;">
<tr><td colspan="3">
<center><strong>Estratificaci&oacute;n</strong></center>
</td></tr>
<tr><td colspan="3">
<?php
if($Recordset1['proceso'] == '2'){
	?>
	<center>Incidencia por <?php echo $habitantes; ?> hab.</center>
    <?php
}else{
	?>
	<center>Por N&uacute;mmero de casos</center>
    <?php
}
?>
</td></tr>
<tr>
  <td bgcolor="#FFFFFF">&nbsp;</td> 
<td align="center"><strong>&nbsp;Sin casos</strong></td>
<td align="center">&nbsp;</td> 
</tr>
<?php
if($proceso == '2'){
	if($enf == 'B51' or $enf == 'B50'){
		?>
		<tr>
		<td bgcolor="#00FF00">&nbsp;</td> 
		<td align="right"><?php echo "0.01"; ?></td> 
		<td align="right"><?php echo number_format($q1,2); ?></td> 
		</tr>
		<tr>
		<td bgcolor="#FFFF00">&nbsp;</td> 
		<td align="right"><?php echo number_format(($q1+0.01),2); ?></td> 
		<td align="right"><?php echo number_format($q2,2); ?></td> 
		</tr>
		<td bgcolor="#FA5882">&nbsp;</td> 
		<td align="right"><?php echo number_format(($q2+0.01),2); ?></td> 
		<td align="right"><?php echo number_format($q3,2); ?></td> 
		</tr>
		<tr>
		<td bgcolor="#FF0000">&nbsp;</td> 
		<td align="right"><?php echo number_format(($q3+0.01),2); ?></td> 
		<td align="right"><strong>a m&aacute;s...</strong></td> 
		</tr>
	<?php
	}else{
		?>
		<tr>
		<td bgcolor="#00FF00">&nbsp;</td> 
		<td align="right"><?php echo "0.01"; ?></td> 
		<td align="right"><?php echo number_format($q1,2); ?></td> 
		</tr>
		<tr>
		<td bgcolor="#FFFF00">&nbsp;</td> 
		<td align="right"><?php echo number_format(($q1+0.01),2); ?></td> 
		<td align="right"><?php echo number_format($q2,2); ?></td> 
		</tr>
		<tr>
		<td bgcolor="#FF0000">&nbsp;</td> 
		<td align="right"><?php echo number_format(($q2+0.01),2); ?></td> 
		<td align="right"><strong>a m&aacute;s...</strong></td> 
		</tr>
		<?php
	}
}elseif($proceso == '1'){
	?>
	<tr>
	<td bgcolor="#FF0000">&nbsp;</td> 
	<td align="right"><?php echo number_format($q1,2); ?></td> 
	<td align="right"><?php echo number_format($q2,2); ?></td> 
	</tr>
	<?php
}elseif($proceso == '3'){
	?>
	<tr>
	<td bgcolor="#00FF00">&nbsp;</td> 
	<td align="right"><?php echo "1"; ?></td> 
	<td align="right"><?php echo number_format($q1,2); ?></td> 
	</tr>
	<tr>
	<td bgcolor="#FFFF00">&nbsp;</td> 
	<td align="right"><?php echo number_format(($q1+1),2); ?></td> 
	<td align="right"><?php echo number_format($q2,2); ?></td> 
	</tr>
	<tr>
	<td bgcolor="#FF0000">&nbsp;</td> 
	<td align="right"><?php echo number_format(($q2+1),2); ?></td> 
	<td align="right"><strong>a m&aacute;s...</strong></td> 
	</tr>
	<?php
}
?>
</table>
<hr />