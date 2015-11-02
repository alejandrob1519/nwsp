<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ViolenciaFamiliar extends CI_Controller {

	private $session_id;

	public function __construct()
    {
        parent::__construct();
        $this->load->model('violenciafamiliar_model');      
        date_default_timezone_set('America/Lima');
        $this->session_id = $this->session->userdata('usuario');

        if (empty($this->session_id)) {
        	redirect(site_url("index/login"), 301);
        	//echo "no hay sesion";
        	
        }
	}
	
	public function index()
	{
		
		$this->load->view('frontend/violenciafamiliar/agregar');	
		
		
	}

	// vista agregar registro
	public function agregar()
	{			
		//combo DIRESA
		$diresa = $this->getDiresasPorNivel($this->input->post('diresa'));

		//combo Red
		$redes = $this->getRedesPorNivel($this->input->post('diresa'), $this->input->post('redes'));
		//combo Microred
		$microred = $this->getMicroRedesPorNivel($this->input->post('diresa'), $this->input->post('redes'), $this->input->post('microred'));
		//combo Establecimiento
		$establec = $this->getEstablecPorNivel($this->input->post('diresa'), $this->input->post('redes'), $this->input->post('microred'), $this->input->post('establec'));

		//$page_data['page_name']  = 'Agregar Nueva Ficha';
		$data['page_title'] = 'Agregar Nueva Ficha';
		$data['diresa'] = $diresa;
		
		$this->load->view('frontend/violenciafamiliar/agregar', $data);
		
	}


	// FUNCION GENERAL PARA DIRESAS, REDES Y MICROREDES
	// funcion para buscar (enlistar) diresas o mostrar solo nombre de diresa segun usuario logeado
	public function getDiresasPorNivel($postDiresa='')
	{
		if($this->session->userdata('diresa') == ''){
			$subreg = $this->violenciafamiliar_model->buscarDiresas();

			$diresa[''] = 'Seleccione ...';
			foreach ($subreg as $dato){
				$diresa[$dato->codigo] = $dato->nombre;
			}
		}else{
			if($postDiresa == ''){
				$subreg = $this->violenciafamiliar_model->mostrarDiresa($this->session->userdata('diresa'));
				foreach ($subreg as $dato){
					$diresa[$dato->codigo] = $dato->nombre;
				}
			}else{
				$subreg = $this->violenciafamiliar_model->mostrarDiresa($postDiresa);
				foreach ($subreg as $dato){
					$diresa[$dato->codigo] = $dato->nombre;
				}
			}
		}
		return $diresa;
	}

	// funcion para buscar (enlistar) redes o mostrar solo nombre de red segun usuario logeado
	public function getRedesPorNivel($postDiresa='', $postRed='')
	{
		if($this->session->userdata('red') != ''){
			$red = $this->violenciafamiliar_model->mostrarRed($this->session->userdata('diresa'),$this->session->userdata('red'));
			foreach ($red as $dato){
				$redes[$dato->codigo] = $dato->nombre;
			}
		}else{
			if($postRed == ''){
				$red = $this->violenciafamiliar_model->buscarRedes($this->session->userdata('diresa'));
				$redes[''] = 'Seleccione ...';
				foreach ($red as $dato){
					$redes[$dato->codigo] = $dato->nombre;
				}
			}else{
				$red = $this->violenciafamiliar_model->buscarRedes($postDiresa);
				$redes[''] = 'Seleccione ...';
				foreach ($red as $dato){
					$redes[$dato->codigo] = $dato->nombre;
				}
			}
		}
		return $redes;
	}

	// funcion para buscar (enlistar) microredes o mostrar solo nombre de microred segun usuario logeado
	public function getMicroRedesPorNivel($postDiresa='', $postRed='', $postMicroRed='')
	{
		if($this->session->userdata('microred') != ''){
			$mred = $this->violenciafamiliar_model->mostrarMicrored($this->session->userdata('diresa'), $this->session->userdata('red'), $this->session->userdata('microred'));
			foreach ($mred as $dato){
				$microred[$dato->codigo] = $dato->nombre;
			}
		}else{
			if($postMicroRed == ''){
				$mred = $this->violenciafamiliar_model->buscarMicroredes($this->session->userdata('diresa'), $this->session->userdata('red'));
				$microred[''] = 'Seleccione ...';
				foreach ($mred as $dato){
					$microred[$dato->codigo] = $dato->nombre;
				}
			}else{
				$mred = $this->violenciafamiliar_model->buscarMicroredes($postDiresa, $postRed);
				$microred[''] = 'Seleccione ...';
				foreach ($mred as $dato){
					$microred[$dato->codigo] = $dato->nombre;
				}
			}
		}
		return $microred;
	}

	// funcion para buscar (enlistar) establecimientos o mostrar solo nombre de establecimiento segun usuario logeado
	public function getEstablecPorNivel($postDiresa='', $postRed='', $postMicroRed='', $postEstablec='')
	{
		if($this->session->userdata('establecimiento') != ''){
			$est = $this->violenciafamiliar_model->mostrarEstablecimiento($this->session->userdata('establecimiento'));
				$establec[$est->cod_est] = $est->raz_soc;
		}
		else{
			if($postEstablec == ''){
				$est = $this->violenciafamiliar_model->buscarEstablec($this->session->userdata('diresa'),$this->session->userdata('red'),$this->session->userdata('microred'));
				$establec[''] = 'Seleccione ...';
				foreach ($est as $dato){
					$establec[$dato->cod_est] = $dato->raz_soc;
				}
			}else{
				$est = $this->violenciafamiliar_model->buscarEstablec($postDiresa, $postRed, $postMicroRed);
				$establec[''] = 'Seleccione ...';
				foreach ($est as $dato){
					$establec[$dato->cod_est] = $dato->raz_soc;
				}
			}
		}
		return $establec;
	}

	













/*

	//Llena el combo redes
	public function llenaRedes()
	{
		$filtro = $this->input->get('diresa');

		foreach ($this->violenciafamiliar_model->buscarRedes($filtro) as $red) {
			$redes[$red->codigo] = $red->nombre;
		}
		echo json_encode($redes);
	}

    //Llena el combo microredes
	public function llenaMicroredes()
	{
		$filtro1 = $this->input->get('diresa');
		$filtro2 = $this->input->get('redes');

		foreach ($this->violenciafamiliar_model->buscarMicroredes($filtro1, $filtro2) as $mred) {
			$microred[$mred->codigo] = $mred->nombre;
		}

		echo json_encode($microred);
	}

    //Llena el combo establecimientos
	public function llenaEstablec()
	{
		$filtro1 = $this->input->get('diresa');
		$filtro2 = $this->input->get('redes');
		$filtro3 = $this->input->get('microred');

		foreach ($this->violenciafamiliar_model->buscarEstablec($filtro1, $filtro2, $filtro3) as $est) {
			$establec[$est->cod_est] = $est->raz_soc;
		}

		echo json_encode($establec);
	}


*/






}
