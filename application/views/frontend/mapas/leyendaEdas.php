<?php
$enf = $Recordset1['enf'];
$q1 = $Recordset1['q1'];
$q2 = $Recordset1['q2'];
$q3 = $Recordset1['q3'];
$q4 = $Recordset1['q4'];
$q5 = $Recordset1['q5'];
$proceso = $Recordset1['proceso'];
$habitantes = $Recordset1['hab'];
?>
<hr />
<table width="100%" border = '0' style="font-size:11px;">
<tr><td colspan="3">
<center><strong>Estratificaci&oacute;n</strong></center>
</td></tr>
<tr><td colspan="3">
<center>Incidencia por <?php echo $habitantes; ?> hab.</center>
</td></tr>
<tr>
  <td bgcolor="#FFFFFF">&nbsp;</td> 
<td align="center"><strong>&nbsp;Sin casos</strong></td>
<td align="center">&nbsp;</td> 
</tr>
<tr>
<td bgcolor="#00FF00">&nbsp;</td> 
<td align="right"><?php echo "0.01"; ?></td> 
<td align="right"><?php echo number_format($q1,3); ?></td> 
</tr>
<tr>
<td bgcolor="#FFFF00">&nbsp;</td> 
<td align="right"><?php echo number_format(($q1+0.001),3); ?></td> 
<td align="right"><?php echo number_format($q2,3); ?></td> 
</tr>
<td bgcolor="#FA5882">&nbsp;</td> 
<td align="right"><?php echo number_format(($q2+0.001),3); ?></td> 
<td align="right"><?php echo number_format($q3,3); ?></td> 
</tr>
</tr>
<td bgcolor="#FF0000">&nbsp;</td> 
<td align="right"><?php echo number_format(($q3+0.001),3); ?></td> 
<td align="right"><?php echo number_format($q4,3); ?></td> 
</tr>
</tr>
<td bgcolor="#610B0B">&nbsp;</td> 
<td align="right"><?php echo number_format(($q5),3); ?></td> 
<td align="right"><strong>a m&aacute;s...</strong></td> 
</tr>
</table>
<hr />