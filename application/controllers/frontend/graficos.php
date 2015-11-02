<?php
class Graficos extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->layout->setLayout('template6');
		$this->layout->setTitle("DGE | NotiWeb - Gráficos");		

		if($this->_sesionIniciada() === FALSE){
			redirect('inicioSesion', 'refresh');
		}
		
		set_time_limit(180);
		date_default_timezone_set('America/Lima');
    }

	public function index() 
	{
        if($this->input->post()){
            if ($this->form_validation->run("graficos/graficos"))
            {
				$opciones = $_POST["opciones"];
				$enfermedad = $_POST["enfermedad"];
				$anio = $_POST["anio"];
				$nivel = $_POST["nivel"];
				$diagno = $_POST["diagno"];
				
				if($enfermedad == "99" or $enfermedad == ""){
					$msg = 3;
					echo json_encode($msg);
					return;
				}
				
				/////////////////////////////////////////////////////////////////////
				//Sección donde se obtiene la información para generar los gráficos//
				/////////////////////////////////////////////////////////////////////
				
				switch($opciones){
				case 1:
					switch($enfermedad){
					case 1:
					if($diagno != "B50" and $diagno != "B51"){
						if($nivel == "00"){
							$Recordset1 = $this->graficos_model->totalInd($anio, $diagno);
							$Recordset2 = $this->graficos_model->totalIndAnos($anio, $diagno);
							$Recordset3 = $this->graficos_model->nacionalEdadInd($anio, $diagno);
						}else{
							$Recordset1 = $this->graficos_model->departamentosTotalInd($anio, $diagno, $nivel);
							$Recordset2 = $this->graficos_model->departamentosTotalIndAnos($anio, $diagno, $nivel);
							$Recordset3 = $this->graficos_model->departamentosEdadInd($anio, $diagno, $nivel);
						}
					}else{
						if($nivel == "00"){
							$Recordset1 = $this->graficos_model->totalInd($anio, $diagno);
							$Recordset2 = $this->graficos_model->totalIndAnos($anio, $diagno);
							$Recordset3 = $this->graficos_model->nacionalIndEndemico($anio, $diagno);
							$Recordset4 = $this->graficos_model->nacionalCanalEndemicoIndActual($anio, $diagno);
						}else{
							$Recordset1 = $this->graficos_model->departamentosTotalInd($anio, $diagno, $nivel);
							$Recordset2 = $this->graficos_model->departamentosTotalIndAnos($anio, $diagno, $nivel);
							$Recordset3 = $this->graficos_model->departamentosIndEndemico($anio, $diagno, $nivel);
							$Recordset4 = $this->graficos_model->departamentosCanalEndemicoIndActual($anio, $diagno, $nivel);
						}
					}
					break;
					case 2:
						if($nivel == "00"){
							if($diagno == "XX1"){
									$Recordset1 = $this->graficos_model->totalEdas($anio);
									$Recordset2 = $this->graficos_model->totalEdasAnos($anio);
									$Recordset3 = $this->graficos_model->nacionalCanalEndemicoEdas($anio);
									$Recordset4 = $this->graficos_model->nacionalCanalEndemicoEdasActual($anio);
							}
						}else{
							if($diagno == "XX1"){
									$Recordset1 = $this->graficos_model->departamentoTotalEdas($anio, $nivel);
									$Recordset2 = $this->graficos_model->departamentosTotalEdasAnos($anio, $nivel);
									$Recordset3 = $this->graficos_model->departamentosCanalEndemicoEdas($anio, $nivel);
									$Recordset4 = $this->graficos_model->departamentosCanalEndemicoEdasActual($anio, $nivel);
							}
						}
					break;
					case 3:
						if($nivel == "00"){
							if($diagno == "YY1"){
									$Recordset1 = $this->graficos_model->totalIras($anio);
									$Recordset2 = $this->graficos_model->totalIrasAnos($anio);
									$Recordset3 = $this->graficos_model->nacionalCanalEndemicoIras($anio);
									$Recordset4 = $this->graficos_model->nacionalCanalEndemicoIrasActual($anio);
							}
						}else{
							if($diagno == "YY1"){
									$Recordset1 = $this->graficos_model->departamentosTotalIras($anio, $nivel);
									$Recordset2 = $this->graficos_model->departamentosTotalIrasAnos($anio, $nivel);
									$Recordset3 = $this->graficos_model->departamentosCanalEndemicoIras($anio, $nivel);
									$Recordset4 = $this->graficos_model->departamentosCanalEndemicoIrasActual($anio, $nivel);
							}
						}
					break;
					}
				break;
				}
				
				//////////////////////////////////////////////////////////////////
				//Genera gráficos  de tendencia de los ultimos 3 años
				//////////////////////////////////////////////////////////////////
				
				$array = "[";
							  
				$i = 1;
				
				$lineas = count($Recordset1); 
				
				foreach ($Recordset1 as $valor){
					if($valor->incidencia == "")
					{
						$valor->incidencia = 0;
					}
					if($i < $lineas){
						$array .= "['".$valor->semana."',".$valor->incidencia."],";
					}else{
						$array .= "['".$valor->semana."',".$valor->incidencia."]";
					}
					$i++;
				}
				
				$array = $array."]";
				
				$data['array'] = $array;
				
				///////////////////////////////////////////////////////////////////
				//Genera gráficos de los ultimos 10 años
				//////////////////////////////////////////////////////////////////
				
				$array2 = "[";
				
				$i = 1;
				
				$lineas = count($Recordset2); 
				
				foreach ($Recordset2 as $valor){
					if($valor->incidencia == "")
					{
						$valor->incidencia = 0;
					}
					if($i < $lineas){
						$array2 .= "['".$valor->ano."',".$valor->incidencia."],";
					}else{
						$array2 .= "['".$valor->ano."',".$valor->incidencia."]";
					}
					$i++;
				}
				
				$array2 = $array2."]";
				
				$data['array1'] = $array2;
				
				////////////////////////////////////////////////////////////////////
				//Genera el canal endemico
				//////////////////////////////////////////////////////////////////
				
				if($diagno == "XX1" or $diagno == "YY1"){
					$array3 = "name: 'IC_Inf', data: [";
					$array4 = "name: 'Media_IC_Inf', data: [";
					$array5 = "name: 'IC_Sup_Media', data: [";
					$array6 = "name: $anio, data: [";
					$array7 = "[";
					
					$i = 1;
					
					$lineas = count($Recordset3); 
					
					foreach ($Recordset3 as $valor){
						if($i < $lineas){
							$array3 .= $valor->IC_Inf.",";
							$array4 .= $valor->Media_IC_Inf.",";
							$array5 .= $valor->IC_Sup_Media.",";
							$array7 .= "'".$valor->semana."',";
						}else{
							$array3 .= $valor->IC_Inf;
							$array4 .= $valor->Media_IC_Inf;
							$array5 .= $valor->IC_Sup_Media;
							$array7 .= "'".$valor->semana."'";
						}
						$i++;
					}
					
					$i = 1;
					
					$lineas = count($Recordset4); 
					
					foreach ($Recordset4 as $valor){
						if($i < $lineas){
							$array6 .= $valor->cantidad.",";
						}else{
							$array6 .= $valor->cantidad;
						}
						$i++;
					}
		
					$array3 = $array3."], lineWidth: 0, lineColor: Highcharts.getOptions().colors[0]";
					$array4 = $array4."], lineWidth: 0, lineColor: Highcharts.getOptions().colors[0]";
					$array5 = $array5."], lineWidth: 0, lineColor: Highcharts.getOptions().colors[0]";
					$array6 = $array6."]";
					$array7 = $array7."]";
					
					$data['array2'] = $array3;
					$data['array3'] = $array4;
					$data['array4'] = $array5;
					$data['array5'] = $array6;
					$data['array6'] = $array7;
				}elseif($diagno != "B50" and $diagno != "B51"){
					$array3 = "[";
					
					$i = 1;
					
					$lineas = count($Recordset3); 
					
					foreach ($Recordset3 as $valor){
						if($i < $lineas){
							$array3 .= "['".$valor->rango."',".$valor->cantidad."],";
						}else{
							$array3 .= "['".$valor->rango."',".$valor->cantidad."]";
						}
						$i++;
					}
					$array3 = $array3."]";
					
					$data['array2'] = $array3;
					
				}elseif($diagno == "B50" or $diagno == "B51"){
					$array3 = "name: 'IC_Inf', data: [";
					$array4 = "name: 'Media_IC_Inf', data: [";
					$array5 = "name: 'IC_Sup_Media', data: [";
					$array6 = "name: $anio, data: [";
					$array7 = "[";
					
					$i = 1;
					
					$lineas = count($Recordset3); 
					
					foreach ($Recordset3 as $valor){
						if($i < $lineas){
							$array3 .= $valor->IC_Inf.",";
							$array4 .= $valor->Media_IC_Inf.",";
							$array5 .= $valor->IC_Sup_Media.",";
							$array7 .= "'".$valor->semana."',";
						}else{
							$array3 .= $valor->IC_Inf;
							$array4 .= $valor->Media_IC_Inf;
							$array5 .= $valor->IC_Sup_Media;
							$array7 .= "'".$valor->semana."'";
						}
						$i++;
					}
					
					$i = 1;
					
					$lineas = count($Recordset4); 
					
					foreach ($Recordset4 as $valor){
						if($i < $lineas){
							$array6 .= $valor->cantidad.",";
						}else{
							$array6 .= $valor->cantidad;
						}
						$i++;
					}
		
					$array3 = $array3."], lineWidth: 0, lineColor: Highcharts.getOptions().colors[0]";
					$array4 = $array4."], lineWidth: 0, lineColor: Highcharts.getOptions().colors[0]";
					$array5 = $array5."], lineWidth: 0, lineColor: Highcharts.getOptions().colors[0]";
					$array6 = $array6."]";
					$array7 = $array7."]";
					
					$data['array2'] = $array3;
					$data['array3'] = $array4;
					$data['array4'] = $array5;
					$data['array5'] = $array6;
					$data['array6'] = $array7;
				}
				///////////////////////////////////////////////////////////////////
				//Coloca en el encabezado de los graficos el nivel correspondiente
				//////////////////////////////////////////////////////////////////
				
				if($nivel != "00"){
					$proceso = $this->graficos_model->graficosDepartamentos($nivel);
					
					foreach($proceso as $valor)
					{
						$datito = $valor->nombre;
					}
					
					$vector = $datito;
					
					$data['vector'] = $vector;
					
					$proceso = $this->graficos_model->obtenerEnfermedad($diagno);
	
					foreach($proceso as $valor)
					{
						$datito = $valor->diagno;
					}
					
					$enfermedad = $datito;
					
					$data['enfermedad'] = $enfermedad;
					$data['anio'] = $anio;
				}else{
					$vector = "Perú";
					$enfermedad = "Perú";
					$data['vector'] = $vector;
	
					$proceso = $this->graficos_model->obtenerEnfermedad($diagno);
					
					foreach($proceso as $valor)
					{
						$datito = $valor->diagno;
					}
					
					$enfermedad = $datito;
					
					$data['enfermedad'] = $enfermedad;
					$data['anio'] = $anio;
				}
				
				//////////////////////////////////////////////////////////////////////
	
				if($diagno == "XX1"){
					$this->load->view("frontend/graficos/graficaEdas", $data);
				}elseif($diagno == "YY1"){
					$this->load->view("frontend/graficos/graficaIras", $data);
				}elseif($diagno != "B50" and $diagno != "B51"){
					$this->load->view("frontend/graficos/graficaIndividual", $data);
				}elseif($diagno == "B50" or $diagno == "B51"){
					$this->load->view("frontend/graficos/graficaIndividualAlterna", $data);
				}
			
			}
		}else{
			$this->layout->view('index');
		}
	}

	public function llenaComboNivel()
	{
		$opcion = $this->input->get('opcion');
		switch($opcion){
			case 1:
			$resultado = $this->graficos_model->obtenerDepartamentos();
			foreach ($resultado as $departamento) {
				 $dato[$departamento->ubigeo] = $departamento->nombre;
			}
			break;
			case 2:
			$resultado = $this->graficos_model->obtenerDiresas();
			$dato["00"] = "1 - PERU";
			foreach ($resultado as $diresa) {
				  $dato[$diresa->diresa] = $diresa->descripcion;
			}
			break;
		}
		
		echo json_encode($dato);
	}

	public function graficosNivel($param)
	{
		$opcion = $this->input->get('opcion');
		switch($opcion){
			case 1:
			$resultado = $this->graficos_model->graficosDepartamentos($param);
			break;
		}
	}

	public function llenaComboDiagno()
	{
		$opcion = $this->input->get('opcion');
		switch($opcion){
			case 1:
				$resultado = $this->graficos_model->obtenerIndividual();
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

	public function graficosDiagno($param)
	{
		switch($param){
			case 1:
				$resultado = $this->graficos_model->obtenerIndividual();
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