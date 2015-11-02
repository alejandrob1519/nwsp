<?php
/*****************************************************  
*   GENERADOR DEL REPORTE DE NOTIFICACION - ESPACIO  *
******************************************************/
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
<td align="center" colspan="13"><h3><b>REPORTE DE NOTIFICACION DE IRAS EN DESCRIPCION DE ESPACIO</b></h3></td>
</tr>
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
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
<td>NOMBRE</td>
<td align="center">SEM 1</td>
<td align="center">SEM 2</td>
<td align="center">SEM 3</td>
<td align="center">SEM 4</td>
<td align="center">SEM 5</td>
<td align="center">SEM 6</td>
<td align="center">SEM 7</td>
<td align="center">SEM 8</td>
<td align="center">SEM 9</td>
<td align="center">SEM 10</td>
<td align="center">SEM 11</td>
<td align="center">SEM 12</td>
<td align="center">SEM 13</td>
<td align="center">SEM 14</td>
<td align="center">SEM 15</td>
<td align="center">SEM 16</td>
<td align="center">SEM 17</td>
<td align="center">SEM 18</td>
<td align="center">SEM 19</td>
<td align="center">SEM 20</td>
<td align="center">SEM 21</td>
<td align="center">SEM 22</td>
<td align="center">SEM 23</td>
<td align="center">SEM 24</td>
<td align="center">SEM 25</td>
<td align="center">SEM 26</td>
<td align="center">SEM 27</td>
<td align="center">SEM 28</td>
<td align="center">SEM 29</td>
<td align="center">SEM 30</td>
<td align="center">SEM 31</td>
<td align="center">SEM 32</td>
<td align="center">SEM 33</td>
<td align="center">SEM 34</td>
<td align="center">SEM 35</td>
<td align="center">SEM 36</td>
<td align="center">SEM 37</td>
<td align="center">SEM 38</td>
<td align="center">SEM 39</td>
<td align="center">SEM 40</td>
<td align="center">SEM 41</td>
<td align="center">SEM 42</td>
<td align="center">SEM 43</td>
<td align="center">SEM 44</td>
<td align="center">SEM 45</td>
<td align="center">SEM 46</td>
<td align="center">SEM 47</td>
<td align="center">SEM 48</td>
<td align="center">SEM 49</td>
<td align="center">SEM 50</td>
<td align="center">SEM 51</td>
<td align="center">SEM 52</td>
<td align="center">SEM 53</td>
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
	echo "<td align='right'>".$dato->sem1."</td>";
	echo "<td align='right'>".$dato->sem2."</td>";
	echo "<td align='right'>".$dato->sem3."</td>";
	echo "<td align='right'>".$dato->sem4."</td>";
	echo "<td align='right'>".$dato->sem5."</td>";
	echo "<td align='right'>".$dato->sem6."</td>";
	echo "<td align='right'>".$dato->sem7."</td>";
	echo "<td align='right'>".$dato->sem8."</td>";
	echo "<td align='right'>".$dato->sem9."</td>";
	echo "<td align='right'>".$dato->sem10."</td>";
	echo "<td align='right'>".$dato->sem11."</td>";
	echo "<td align='right'>".$dato->sem12."</td>";
	echo "<td align='right'>".$dato->sem13."</td>";
	echo "<td align='right'>".$dato->sem14."</td>";
	echo "<td align='right'>".$dato->sem15."</td>";
	echo "<td align='right'>".$dato->sem16."</td>";
	echo "<td align='right'>".$dato->sem17."</td>";
	echo "<td align='right'>".$dato->sem18."</td>";
	echo "<td align='right'>".$dato->sem19."</td>";
	echo "<td align='right'>".$dato->sem20."</td>";
	echo "<td align='right'>".$dato->sem21."</td>";
	echo "<td align='right'>".$dato->sem22."</td>";
	echo "<td align='right'>".$dato->sem23."</td>";
	echo "<td align='right'>".$dato->sem24."</td>";
	echo "<td align='right'>".$dato->sem25."</td>";
	echo "<td align='right'>".$dato->sem26."</td>";
	echo "<td align='right'>".$dato->sem27."</td>";
	echo "<td align='right'>".$dato->sem28."</td>";
	echo "<td align='right'>".$dato->sem29."</td>";
	echo "<td align='right'>".$dato->sem30."</td>";
	echo "<td align='right'>".$dato->sem31."</td>";
	echo "<td align='right'>".$dato->sem32."</td>";
	echo "<td align='right'>".$dato->sem33."</td>";
	echo "<td align='right'>".$dato->sem34."</td>";
	echo "<td align='right'>".$dato->sem35."</td>";
	echo "<td align='right'>".$dato->sem36."</td>";
	echo "<td align='right'>".$dato->sem37."</td>";
	echo "<td align='right'>".$dato->sem38."</td>";
	echo "<td align='right'>".$dato->sem39."</td>";
	echo "<td align='right'>".$dato->sem40."</td>";
	echo "<td align='right'>".$dato->sem41."</td>";
	echo "<td align='right'>".$dato->sem42."</td>";
	echo "<td align='right'>".$dato->sem43."</td>";
	echo "<td align='right'>".$dato->sem44."</td>";
	echo "<td align='right'>".$dato->sem45."</td>";
	echo "<td align='right'>".$dato->sem46."</td>";
	echo "<td align='right'>".$dato->sem47."</td>";
	echo "<td align='right'>".$dato->sem48."</td>";
	echo "<td align='right'>".$dato->sem49."</td>";
	echo "<td align='right'>".$dato->sem50."</td>";
	echo "<td align='right'>".$dato->sem51."</td>";
	echo "<td align='right'>".$dato->sem52."</td>";
	echo "<td align='right'>".$dato->sem53."</td>";
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