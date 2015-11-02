<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*******************************************  
*   CONTROLADOR ESTRATIFICACION DE MAPAS   *
********************************************/

class Estratos extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
        $this->layout->setLayout('template2');
        $this->layout->setTitle("Vigilancia Epidemiol&oacute;gica");

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
		$array = $this->mapas_model->obtenerIndividual();
		
		$k = 0;
		
		foreach($array as $valor)
		{
			$datos[$valor->cie_10] = $valor->diagno;
			$k++;
		}
		
		$crud = new grocery_CRUD();

		$crud->set_table('estratos');
		$crud->columns('id','enfermedad','semana','estrato_1','estrato_2','estrato_3','estrato_4','estrato_5','tipo','habitantes');
		$crud->order_by('id,enfermedad','asc');
		$crud->display_as('id','from estratos')
					->display_as('id','Item');
		$crud->set_subject('Estrato');
		$crud->field_type('enfermedad','dropdown',$datos);         
		$crud->field_type('tipo','dropdown',array('1' => 'Casos', '2' => 'Incidencia', '3' => 'Estrat. Casos'));         
		$output = $crud->render();

		$this->_example_output($output);
	}
}