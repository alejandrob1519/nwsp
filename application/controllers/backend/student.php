<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*******************************************  
*   CONTROLADOR T STUDENT  *
********************************************/

class Student extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
        $this->layout->setLayout('template2');
		$this->layout->setTitle("T de Student");

		if($this->session->userdata('nivel') <> '1'){
            redirect(site_url("backend/index/login"), 301);
		}
	}

    public function _example_output($output = null)
    {
		$this->layout->view('index',$output);
    }

	public function index() 
	{
		$anio = array();
		
		for($i=2000;$i<=2020;$i++)
		{
			$anio[$i] = $i;
		}

		$crud = new grocery_CRUD();

		$crud->set_table('student');
		$crud->columns('registroId','ano','datos','t');
		$crud->order_by('ano','asc');
		$crud->display_as('registroId','Item')
			->display_as('ano','A&ntilde;o')
			->display_as('registroId','Item');
		$crud->set_subject('Datos');
		$crud->field_type('ano','dropdown',$anio);         

		$output = $crud->render();

		$this->_example_output($output);
	}
}