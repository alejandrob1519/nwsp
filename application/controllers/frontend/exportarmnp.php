<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Exportarmnp extends CI_Controller {
	
    private $session_id;

	public function __construct()
    {
        parent::__construct();
        $this->layout->setLayout('templatemnp');
        $this->layout->setTitle(":: NotiWeb :: Vigilancia Epidemiol&oacute;gica");
        $this->session_id = $this->session->userdata('usuario');
		date_default_timezone_set('America/Lima');
	}
	
	public function index()
    {
        if($this->input->post()){
		    echo "vamos peru";
            //if ($this->form_validation->run(""))
            {
				$maximo = 0;
				$contador = 0;
				$puntero = 0;
				$limite = 0;
				$base = 1;
				$anio = $this->input->post('anoExport');
				$ruta_db = "0";
				
				redirect('exportarmnp/exportandomnp'.'/'.$maximo.'/'.$contador.'/'.$puntero.'/'.$limite.'/'.$base.'/'.$anio.'/'.$ruta_db,301);
			}
		}else{
			if(!empty($this->session_id)){
				$this->layout->view('exportarmnp');
			}else{
				redirect(site_url("index/login"), 301);
			}
		}
	}
	
	public function exportandomnp($maximo, $contador, $puntero, $limite, $base, $anio, $ruta_db){
		$datos = array("ruta_db" => $ruta_db, 
					   "maximo" => $maximo,
					   "contador" => $contador,
					   "puntero" => $puntero,
					   "limite" => $limite,
					   "base" => $base,
					   "anio" => $anio
					   );
		
		$this->load->view('frontend/exportarmnp/exportandomnp', compact('datos'));	
	}
}