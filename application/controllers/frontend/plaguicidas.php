<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Plaguicidas extends CI_Controller {
    
	private $session_id;

	public function __construct()
    {
        parent::__construct();
        $this->layout->setTitle(":: NotiWeb :: Intoxicaci&oacute;n por Plaguicidas");
        $this->session_id = $this->session->userdata('usuario');
	}

    public function index()
    {
        if(!empty($this->session_id)){
			$acceso = $this->login_model->loginAccesoFichas($this->session->userdata('usuario'), '1');
			
			if(count($acceso) != 0){
            	redirect(site_url("plaguicidas/principal"), 301);
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
			
			$accion = 'Plaguicidas';
			
			$this->login_model->auditoriaOperador($session_id['usuario'], $accion);
			
	        $this->layout->setLayout('template8_8');

            $this->layout->view("principal", compact("session_id", "menu"));
        }else{
			$accion = 'Error Plaguicidas';
			
			$this->login_model->auditoriaOperador($this->input->post("usuario", true), $accion);
			
            $this->session->set_flashdata('ControllerMessage', 'Su sesi&oacute;n ha caducado, vuelva a ingresar.');
            redirect(site_url("index/principal"), 301);
        }
    }
}