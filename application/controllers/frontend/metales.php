<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Metales extends CI_Controller {
    
	private $session_id;

	public function __construct()
    {
        parent::__construct();
        $this->layout->setTitle(":: NotiWeb :: Exposici&oacute;n por Metal Pesado");
        $this->session_id = $this->session->userdata('usuario');
		date_default_timezone_set('America/Lima');

		$this->layout->setLayout('template4metal');
		
	}

    public function index()
    {
        if(!empty($this->session_id)){
			$acceso = $this->login_model->loginAccesoFichas($this->session->userdata('usuario'), '8');
			
			if(count($acceso) != 0){
            	redirect(site_url("metales/principal"), 301);
			}else{
	            $this->session->set_flashdata('error', 'No tiene acceso a la ficha epidemiológica elegida.');
	            redirect(site_url("index/principal"), 301);
			}
        }else{
            redirect(site_url("index/principal"), 301);
        }
    }

    public function principal()
    {
        if(!empty($this->session_id)){
            $session_id = $this->session_id;
		    $nivel_id = $this->session->userdata('nivel');
		   
         		   $accion = 'metales';
			
				   $this->login_model->auditoriaOperador($session_id['usuario'], $accion);

			$this->layout->view('principal', compact("session_id", "nivel_id", "menu"));
        }else{
			       $accion = 'Error Metales';
			
			       $this->login_model->auditoriaOperador($this->input->post("usuario", true), $accion);
			
            $this->session->set_flashdata('ControllerMessage', 'Su sesi&oacute;n ha caducado, vuelva a ingresar.');
            redirect(site_url("index/principal"), 301);
        }
    }
}















