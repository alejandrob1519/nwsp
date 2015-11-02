<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chikungunya extends CI_Controller {
    
	private $session_id;

	public function __construct()
    {
        parent::__construct();
        $this->layout->setTitle(":: NotiWeb :: Chikungunya");
        $this->session_id = $this->session->userdata('usuario');
	}

    public function index()
    {
        if(!empty($this->session_id)){
			$acceso = $this->login_model->loginAccesoFichas($this->session->userdata('usuario'), '1');
			
			if(count($acceso) != 0){
            	redirect(site_url("chikungunya/principal"), 301);
			}else{
	            $this->session->set_flashdata('ControllerMessage', 'No tiene acceso a la ficha epidemiológica elegida.');
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
			
			$accion = 'Chikungunya';
			
			$this->login_model->auditoriaOperador($session_id['usuario'], $accion);
			
	        $this->layout->setLayout('template4_4');

            $this->layout->view("principal", compact("session_id", "menu"));
        }else{
			$accion = 'Error Chikungunya';
			
			$this->login_model->auditoriaOperador($this->input->post("usuario", true), $accion);
			
            $this->session->set_flashdata('ControllerMessage', 'Su sesi&oacute;n ha caducado, vuelva a ingresar.');
            redirect(site_url("index/principal"), 301);
        }
    }
}