<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/***********************************  
*   CONTROLADOR MAPAS              *
***********************************/

class Mapas extends CI_Controller {

	function __construct()
	{
		parent::__construct();

        $this->layout->setLayout('template5');
		$this->layout->setTitle("DGE | NotiWeb - Mapas");		

		if($this->_sesionIniciada() === FALSE){
			redirect('inicioSesion', 'refresh');
		}
		date_default_timezone_set('America/Lima');
	}

	// INDEX   
	public function index() 
	{
		$this->layout->view('index');
	}

	public function llenaComboNivel()
	{
		$opcion = $this->input->get('opcion');
		switch($opcion){
			case 1:
			$resultado = $this->mapas_model->obtenerDepartamentos();
			$data["00"] = "1 - PERU";
			foreach ($resultado as $departamento) {
				 $data[$departamento->ubigeo] = $departamento->nombre;
			}
			break;
			case 2:
			$resultado = $this->mapas_model->obtenerDiresas();
			$data["00"] = "1 - PERU";
			foreach ($resultado as $diresa) {
				  $data[$diresa->codigo] = $diresa->nombre;
			}
			break;
		}
		
		echo json_encode($data);
	}

	public function llenaComboDiagno()
	{
		$opcion = $this->input->get('opcion');
		switch($opcion){
			case 1:
				$resultado = $this->mapas_model->obtenerEstratos();
				
				foreach ($resultado as $enf) {
					 $data[$enf->cie_10] = $enf->diagno;
				}
			break;
			case 2:
				$dato = array();
				$dato = array('XX1' => 'EDAs Totales');
				$data = $dato;				
			break;
			case 3:
				$dato = array();
				$dato = array('YY1' => 'IRAs Neumonias');
				$data = $dato;				
			break;
		}
		
		echo json_encode($data);
	}

	public function jvmapa()
	{
        if($this->input->post()){
/*            if ($this->form_validation->run("mapas/mapas"))
            {
*/				$opciones = $this->input->post("opciones");
				$enfermedad = $this->input->post("enfermedad");
				$anio = $this->input->post("anio");
				$nivel = $this->input->post("nivel");
				$diagno = $this->input->post("diagno");
				
				if($enfermedad == "00" or $enfermedad == ""){
					$msg = 3;
					echo json_encode($msg);
					return;
				}
				
				switch($opciones){
				case 1:
					switch($enfermedad){
					case 1:
						if($nivel == "00"){
								$Recordset1 = $this->mapas_model->totalIndividual($anio, $diagno);
						}else{
								$Recordset1 = $this->mapas_model->departamentoIndividual($anio, $diagno, $nivel);
						}
					break;
					case 2:
						if($nivel == "00"){
							switch($diagno){
								case 'XX1':
									$Recordset1 = $this->mapas_model->totalEdas($anio, $diagno);
								break;
							}
						}else{
							switch($diagno){
								case 'XX1':
									$Recordset1 = $this->mapas_model->departamentoEdas($anio, $diagno, $nivel);
								break;
							}
						}
					break;
					case 3:
						if($nivel == "00"){
							switch($diagno){
								case 'YY1':
									$Recordset1 = $this->mapas_model->totalNeumonias($anio, $diagno);
								break;
							}
						}else{
							switch($diagno){
								case 'YY1':
									$Recordset1 = $this->mapas_model->departamentoNeumonias($anio, $diagno, $nivel);
								break;
							}
						}
					break;
					}
				break;
				}

				$jsondata = array();
				
				if($nivel == '00'){
					$jsondata['mapa'] = 'peru';
				}else{
					switch($nivel){
						case "00":
						$jsondata['mapa'] = 'peru';
						break;
						case "01":
						$jsondata['mapa'] = 'amazonas';
						break;
						case "02":
						$jsondata['mapa'] = 'ancash';
						break;
						case "03":
						$jsondata['mapa'] = 'apurimac';
						break;
						case "04":
						$jsondata['mapa'] = 'arequipa';
						break;
						case "05":
						$jsondata['mapa'] = 'ayacucho';
						break;
						case "06":
						$jsondata['mapa'] = 'cajamarca';
						break;
						case "07":
						$jsondata['mapa'] = 'callao';
						break;
						case "08":
						$jsondata['mapa'] = 'cusco';
						break;
						case "09":
						$jsondata['mapa'] = 'huancavelica';
						break;
						case "10":
						$jsondata['mapa'] = 'huanuco';
						break;
						case "11":
						$jsondata['mapa'] = 'ica';
						break;
						case "12":
						$jsondata['mapa'] = 'junin';
						break;
						case "13":
						$jsondata['mapa'] = 'lalibertad';
						break;
						case "14":
						$jsondata['mapa'] = 'lambayeque';
						break;
						case "15":
						$jsondata['mapa'] = 'lima';
						break;
						case "16":
						$jsondata['mapa'] = 'loreto';
						break;
						case "17":
						$jsondata['mapa'] = 'madrededios';
						break;
						case "18":
						$jsondata['mapa'] = 'moquegua';
						break;
						case "19":
						$jsondata['mapa'] = 'pasco';
						break;
						case "20":
						$jsondata['mapa'] = 'piura';
						break;
						case "21":
						$jsondata['mapa'] = 'puno';
						break;
						case "22":
						$jsondata['mapa'] = 'sanmartin';
						break;
						case "23":
						$jsondata['mapa'] = 'tacna';
						break;
						case "24":
						$jsondata['mapa'] = 'tumbes';
						break;
						case "25":
						$jsondata['mapa'] = 'ucayali';
						break;
						case "31":
						$jsondata['mapa'] = 'Luciano';
						break;
						case "32":
						$jsondata['mapa'] = 'PiuraI';
						break;
						case "33":
						$jsondata['mapa'] = 'ApurimacI';
						break;
						case "34":
						$jsondata['mapa'] = 'Chanka';
						break;
						case "35":
						$jsondata['mapa'] = 'CajamarcaI';
						break;
						case "36":
						$jsondata['mapa'] = 'Chachapoyas';
						break;
						case "37":
						$jsondata['mapa'] = 'Chota';
						break;
						case "38":
						$jsondata['mapa'] = 'Jaen';
						break;
						case "40":
						$jsondata['mapa'] = 'LimaC';
						break;
						case "41":
						$jsondata['mapa'] = 'LimaE';
						break;
						case "42":
						$jsondata['mapa'] = 'LimaN';
						break;
						case "43":
						$jsondata['mapa'] = 'LimaS';
						break;
						case "46":
						$jsondata['mapa'] = 'Cutervo';
						break;
					}
				}
				
				$jsondata['c1'] = '#4b93c1';
				
				if(count($Recordset1) <> 0){
					foreach ($Recordset1 as $valor){
						$jsondata[$valor->ubigeo] = $valor->categoria;
					}
					echo json_encode($jsondata);
				}else{
					$jsondata = array();
					echo json_encode($jsondata);
				}
			//}
		}
	}
	
	public function leyenda()
	{
		if($this->input->post()){
			$opciones = $_POST["opciones"];
			$enfermedad = $_POST["enfermedad"];
			$anio = $_POST["anio"];
			$nivel = $_POST["nivel"];
			$diagno = $_POST["diagno"];
			
			if($enfermedad == "00" or $enfermedad == ""){
				$msg = 3;
				echo json_encode($msg);
				return;
			}
			
			switch($opciones){
			case 1:
				switch($enfermedad){
				case 1:
					if($nivel == "00"){
							$Recordset1 = $this->mapas_model->totalIndividualLeyenda($anio, $diagno);
					}else{
							$Recordset1 = $this->mapas_model->departamentoIndividualLeyenda($anio, $diagno, $nivel);
					}

					//$this->load->view('mapas/leyenda', compact('Recordset1'));
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
					<?php
				break;
				case 2:
					if($nivel == "00"){
						switch($diagno){
							case 'XX1':
								$Recordset1 = $this->mapas_model->totalEdasLeyenda($anio, $diagno, $nivel);
							break;
						}
					}else{
						switch($diagno){
							case 'XX1':
								$Recordset1 = $this->mapas_model->departamentoEdasLeyenda($anio, $diagno, $nivel);
							break;
						}
					}
					//$this->load->view("mapas/leyendaEdas", compact('Recordset1'));
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
					<?php			
				break;
				case 3:
					if($nivel == "00"){
						switch($diagno){
							case 'YY1':
								$Recordset1 = $this->mapas_model->totalNeumoniasLeyenda($anio, $diagno, $nivel);
							break;
						}
					}else{
						switch($diagno){
							case 'YY1':
								$Recordset1 = $this->mapas_model->departamentoNeumoniasLeyenda($anio, $diagno, $nivel);
							break;
						}
					}
					//$this->load->view('mapas/leyendaIras', compact('Recordset1'));
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
					<td align="right"><?php echo number_format($q4,3); ?></td> 
					<td align="right"><strong>a m&aacute;s...</strong></td> 
					</tr>
					</table>
					<hr />
					<?php
				break;
				}
			break;
			}
		}
	}

	function _sesionIniciada() 
	{
		$usuario = $this->session->userdata('usuario');
		$sesionIniciada = $this->session->userdata('sesionIniciada');
		if( ! isset($sesionIniciada) || $sesionIniciada === FALSE || ! isset($usuario) || $usuario == '' ) 
		{
			return FALSE;			
		}
		else 
		{
			return TRUE;
		}
	}
}
?>