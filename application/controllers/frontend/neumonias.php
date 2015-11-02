<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Neumonias extends CI_Controller {
    
	private $session_id;

	public function __construct()
    {
        parent::__construct();
        $this->layout->setTitle(":: NotiWeb :: Defunciones por Neumon&iacute;as");
        $this->session_id = $this->session->userdata('usuario');
		date_default_timezone_set('America/Lima');

		$this->layout->setLayout('template7_7');

	}

    public function index()
    {
        if(!empty($this->session_id)){
			$acceso = $this->login_model->loginAccesoFichas($this->session->userdata('usuario'), '3');
			
			if(count($acceso) != 0){
            	redirect(site_url("neumonias/principal"), 301);
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
			
			$accion = 'Neumonias';
			
			$this->login_model->auditoriaOperador($session_id['usuario'], $accion);
			
            $this->layout->view("principal", compact("session_id", "menu"));
        }else{
			$accion = 'Error Neumonias';
			
			$this->login_model->auditoriaOperador($this->input->post("usuario", true), $accion);
			
            $this->session->set_flashdata('ControllerMessage', 'Su sesi&oacute;n ha caducado, vuelva a ingresar.');
            redirect(site_url("index/principal"), 301);
        }
    }
	
	public function directiva(){
        if(!empty($this->session_id)){
            $session_id = $this->session_id;
			
           $this->layout->view("directiva", compact("session_id", "menu"));
        }else{
            $this->session->set_flashdata('ControllerMessage', 'Su sesi&oacute;n ha caducado, vuelva a ingresar.');
            redirect(site_url("index/principal"), 301);
        }
	}
	
	public function anexo03(){
        if(!empty($this->session_id)){
            $session_id = $this->session_id;
			
           $this->layout->view("anexo03", compact("session_id", "menu"));
        }else{
            $this->session->set_flashdata('ControllerMessage', 'Su sesi&oacute;n ha caducado, vuelva a ingresar.');
            redirect(site_url("index/principal"), 301);
        }
	}
	
	public function instructivo(){
        if(!empty($this->session_id)){
            $session_id = $this->session_id;
			
           $this->layout->view("instructivo", compact("session_id", "menu"));
        }else{
            $this->session->set_flashdata('ControllerMessage', 'Su sesi&oacute;n ha caducado, vuelva a ingresar.');
            redirect(site_url("index/principal"), 301);
        }
	}
}