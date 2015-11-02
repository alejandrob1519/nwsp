<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reportes extends CI_Controller {
    
    private $session_id;

	public function __construct()
    {
        parent::__construct();
        $this->layout->setLayout('template2');
        $this->layout->setTitle(":: NotiWeb :: Vigilancia Epidemiol&oacute;gica");
        $this->session_id =  $this->session->userdata('usuario');

		if($this->session->userdata('nivel') <> '1'){
            redirect(site_url("backend/index/login"), 301);
		}
	}

    public function _example_output1($output = null)
    {
		$this->layout->view('notificacionAutoriza.php',$output);
    }

	public function index()
    {
		$this->_example_output1((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
	}
	
	//Lista las coberturas generadas
	public function generarCobertura()
	{
			$tipo = array('0'=>'No Notific&oacute;', '1'=>'Notific&oacute;', '2'=>'Not. Negativa');
			
			$crud = new grocery_CRUD();
	
			$crud->columns('ano', 'semana', 'ndiresa', 'nred', 'nmicrored', 'nestablec', 'notificacion', 'fecha', 'hora');
			$crud->set_table('cobertura');
			$crud->set_subject('Proceso');
			
			switch($this->session->userdata('nivel'))
			{
				case 5:
				$where = array('diresa' => $this->session->userdata('diresa'));
				break;
				case 6:
				$where = array('diresa' => $this->session->userdata('diresa'), 'red' => $this->session->userdata('red'));
				break;
				case 7:
				$where = array('diresa' => $this->session->userdata('diresa'), 'red' => $this->session->userdata('red'), 'microred' => $this->session->userdata('microred'));
				break;
				default:
				$this->session->set_flashdata('error', 'Este proceso no est&aacute; permitido para su nivel de usuario');
				redirect(site_url("backend/index/principal"), 301);
				break;
			}
			
			$crud->field_type('notificacion','dropdown',$tipo);
			$crud->display_as('establec', 'Establecimiento');
			$crud->display_as('notificacion', 'Notificaci&oacute;n');
			$crud->display_as('ndiresa', 'Diresa');
			$crud->display_as('nred', 'Red');
			$crud->display_as('nmicrored', 'Microred');
			$crud->display_as('nestablec', 'Establecimiento');
			$crud->where($where);
			$crud->change_field_type('ano', 'readonly');
			$crud->change_field_type('semana', 'readonly');
			$crud->change_field_type('diresa', 'readonly');
			$crud->change_field_type('red', 'readonly');
			$crud->change_field_type('microred', 'readonly');
			$crud->change_field_type('establec', 'readonly');
			
			//$crud->unset_read();
			//$crud->unset_edit();
			$crud->unset_delete();
			$crud->unset_print();
			$crud->unset_add();

			///////////////////////////////////////////////////////////////////////////////
			$crud->add_action_peru('A&ntilde;adir Proceso', '', 'proceso','add-icon');
			///////////////////////////////////////////////////////////////////////////////
				
			$output = $crud->render();
	
			$this->_example_output1($output);
	}

	//Proceso del reporte de cobertura
    public function cobertura()
    {
		if($this->input->post())
		{
            if ($this->form_validation->run("reportes/reportes"))
            {
				$anio = $this->input->post('anio');
				$semana = $this->input->post('semana');
				
				$resultado = $this->reportes_model->cobertura($anio, $semana);
				
				if($resultado == true){
					$this->load->view('backend/reportes/reporteCobertura', compact('resultado', 'anio', 'semana'));
				}else{
					$this->session->set_flashdata('error', 'No hay informaci&oacute;n de cobertura para la semana elegida');
					redirect(site_url("backend/index/principal"), 301);
				}
			}
		}else{
			if(!empty($this->session_id)){
				$this->layout->view('cobertura');
			}else{
				redirect(site_url("backend/index/login"), 301);
			}
		}
    }
	
	public function notificacionAutoriza()
	{
		  $anio = array();
		  
		  for($i=2010;$i<=date("Y");$i++)
		  {
			  $anio[$i] = $i;
		  }
		  
		  $semana = array();
		  
		  for($i=1;$i<=53;$i++)
		  {
			  $semana[$i] = $i;
		  }
		  
		  $sub = $this->frontend_model->buscarDiresas();
  
		  $subr = array();
		  
		  foreach($sub as $dato)
		  {
			  $subr[$dato->codigo] = $dato->nombre;
		  }
  
		  $tipo = array('1'=>'Autorizado', '2'=>'No autorizado');
		  
		  $crud = new grocery_CRUD();
  
		  $crud->columns('ano', 'semana', 'diresa', 'estado', 'fecha', 'hora', 'usuario');
		  $crud->set_table('autoriza');
		  $crud->set_subject('Autorizaci&oacute;n');
		  
		  $crud->fields('ano', 'semana', 'diresa', 'estado');
		  $crud->display_as('ano', 'A&ntilde;o');
		  $crud->field_type('ano','dropdown',$anio);
		  $crud->field_type('semana','dropdown',$semana);
		  $crud->field_type('diresa','dropdown',$subr);
		  $crud->field_type('estado','dropdown',$tipo);
		  $crud->required_fields('diresa', 'ano', 'semana', 'estado');
		  $crud->order_by('ano, semana', 'DESC');
		  
		  $crud->unset_add();
		  $crud->unset_edit();
		  $crud->unset_read();
		  //$crud->unset_export();
		  $crud->unset_DELETE();
		  $crud->unset_print();
		  
		  $output = $crud->render();
  
		  $this->_example_output1($output);
	}

	public function notificacion()
    {
		if($this->input->post())
		{
            if ($this->form_validation->run("reportes/reportes"))
            {
				$anio = $this->input->post('anio');
				$semana = $this->input->post('semana');
				
				$resultado = $this->reportes_model->notificacion($anio, $semana);
				
				if($resultado == true){
					$this->load->view('backend/reportes/reporteNotificacion', compact('resultado', 'anio', 'semana'));
				}else{
					$this->session->set_flashdata('error', 'No hay informaci&oacute;n de notificaci&oacute;n para la semana elegida');
					redirect(site_url("backend/index/principal"), 301);
				}
			}
		}else{
			  if(!empty($this->session_id)){
				  //$resultado = $this->reportes_model->notificacion();
				  $this->layout->view('notificacion');
			  }else{
				  redirect(site_url("backend/index/login"), 301);
			  }
		}
    }
	
	public function boletines(){
		if($this->input->post()){
			$anio = $this->input->post("anio");
			$semana = $this->input->post("semana");
			
			$tabla1 = $this->reportes_model->tablasBoletin1($anio, $semana);
			
			$tabla2 = $this->reportes_model->tablasBoletin2($anio, $semana);
			
			$tabla3 = $this->reportes_model->tablasBoletin3($anio, $semana);
			
			$tabla4 = $this->reportes_model->tablasBoletin4($anio, $semana);
			
			define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
			
			$IOFactory = getcwd()."/application/libraries/PHPExcel/Classes/PHPExcel/IOFactory.php";
			
			require_once($IOFactory);
			
			if (!file_exists(getcwd().'/public/images/boletin.xlsx')) {
				exit("No se encuentra el archivo platilla." . EOL);
			}			
			
			// Leemos un archivo Excel 2007
			
			$objPHPExcel = PHPExcel_IOFactory::load(getcwd().'/public/images/boletin.xlsx'); 
			
			$objPHPExcel->setActiveSheetIndex(0);
			
			$objPHPExcel->getActiveSheet()->SetCellValue('A1', $semana);
			$objPHPExcel->getActiveSheet()->SetCellValue('B1', $anio);
			
			$i = 6;
			
			foreach($tabla1 as $dato){
				$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, $dato->actual_ant);
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, $dato->acumulado_ant);
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, $dato->defunciones_ant);
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$i, $dato->ia_ant);
				$objPHPExcel->getActiveSheet()->SetCellValue('F'.$i, $dato->actual_act);
				$objPHPExcel->getActiveSheet()->SetCellValue('G'.$i, $dato->acumulado_act);
				$objPHPExcel->getActiveSheet()->SetCellValue('H'.$i, $dato->defunciones_act);
				$objPHPExcel->getActiveSheet()->SetCellValue('I'.$i, $dato->ia_act);
				$i++;
			}
			 
			$objPHPExcel->setActiveSheetIndex(1);
			
			$i = 6;
			
			foreach($tabla2 as $dato){
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, $dato->Antrax);
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, $dato->ia_a22);
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$i, $dato->Dengue_con_senales_de_alarma);
				$objPHPExcel->getActiveSheet()->SetCellValue('F'.$i, $dato->Dengue_grave);
				$objPHPExcel->getActiveSheet()->SetCellValue('G'.$i, $dato->Dengue_sin_senales_de_alarma);
				$objPHPExcel->getActiveSheet()->SetCellValue('H'.$i, $dato->Dengue);
				$objPHPExcel->getActiveSheet()->SetCellValue('I'.$i, $dato->ia_a97);
				$objPHPExcel->getActiveSheet()->SetCellValue('J'.$i, $dato->Enf_de_Carrion_aguda);
				$objPHPExcel->getActiveSheet()->SetCellValue('K'.$i, $dato->Enf_de_Carrion_cronica);
				$objPHPExcel->getActiveSheet()->SetCellValue('L'.$i, $dato->Enf_de_Carrion);
				$objPHPExcel->getActiveSheet()->SetCellValue('M'.$i, $dato->ia_a44);
				$objPHPExcel->getActiveSheet()->SetCellValue('N'.$i, $dato->Enf_de_Chagas);
				$objPHPExcel->getActiveSheet()->SetCellValue('O'.$i, $dato->ia_b57);
				$objPHPExcel->getActiveSheet()->SetCellValue('P'.$i, $dato->Fiebre_amarilla_selvatica);
				$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$i, $dato->ia_a950);
				$objPHPExcel->getActiveSheet()->SetCellValue('R'.$i, $dato->Hepatitis_B);
				$objPHPExcel->getActiveSheet()->SetCellValue('S'.$i, $dato->ia_b16);
				$objPHPExcel->getActiveSheet()->SetCellValue('T'.$i, $dato->Leishmaniosis_cutanea);
				$objPHPExcel->getActiveSheet()->SetCellValue('U'.$i, $dato->ia_b551);
				$objPHPExcel->getActiveSheet()->SetCellValue('V'.$i, $dato->Leishmaniosis_mucocutanea);
				$objPHPExcel->getActiveSheet()->SetCellValue('W'.$i, $dato->ia_b552);
				$objPHPExcel->getActiveSheet()->SetCellValue('X'.$i, $dato->Leptospirosis);
				$objPHPExcel->getActiveSheet()->SetCellValue('Y'.$i, $dato->ia_a27);
				$i++;
			}
			 
			$objPHPExcel->setActiveSheetIndex(2);
			
			$i = 6;
			
			foreach($tabla2 as $dato){
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, $dato->Loxocelismo);
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, $dato->Malaria_mixta);
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$i, $dato->ia_b501);
				$objPHPExcel->getActiveSheet()->SetCellValue('F'.$i, $dato->Malaria_por_P_Falciparum);
				$objPHPExcel->getActiveSheet()->SetCellValue('G'.$i, $dato->ia_b50);
				$objPHPExcel->getActiveSheet()->SetCellValue('H'.$i, $dato->Malaria_por_P_Vivax);
				$objPHPExcel->getActiveSheet()->SetCellValue('I'.$i, $dato->ia_b51);
				$objPHPExcel->getActiveSheet()->SetCellValue('J'.$i, $dato->Muerte_materna_directa);
				$objPHPExcel->getActiveSheet()->SetCellValue('K'.$i, $dato->Muerte_materna_incidental);
				$objPHPExcel->getActiveSheet()->SetCellValue('L'.$i, $dato->Muerte_materna_indirecta);
				$objPHPExcel->getActiveSheet()->SetCellValue('M'.$i, $dato->Ofidismo);
				$objPHPExcel->getActiveSheet()->SetCellValue('N'.$i, $dato->Peste_bubonica);
				$objPHPExcel->getActiveSheet()->SetCellValue('O'.$i, $dato->ia_a200);
				$objPHPExcel->getActiveSheet()->SetCellValue('P'.$i, $dato->Rabia_humana_silvestre);
				$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$i, $dato->ia_a820);
				$objPHPExcel->getActiveSheet()->SetCellValue('R'.$i, $dato->Sifilis_congenita);
				$objPHPExcel->getActiveSheet()->SetCellValue('S'.$i, $dato->ia_a50);
				$objPHPExcel->getActiveSheet()->SetCellValue('T'.$i, $dato->Tetanos);
				$objPHPExcel->getActiveSheet()->SetCellValue('U'.$i, $dato->ia_a35);
				$objPHPExcel->getActiveSheet()->SetCellValue('V'.$i, $dato->Tos_ferina);
				$objPHPExcel->getActiveSheet()->SetCellValue('W'.$i, $dato->ia_a37);
				$objPHPExcel->getActiveSheet()->SetCellValue('X'.$i, $dato->Muerte_perinatal_fetal);
				$objPHPExcel->getActiveSheet()->SetCellValue('Y'.$i, $dato->Muerte_perinatal_neonatal);
				$i++;
			}
			 
			$objPHPExcel->setActiveSheetIndex(3);
			
			$i = 7;
			
			foreach($tabla3 as $dato){
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, $dato->actual_daa_ant);
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, $dato->acumulado_daa_ant);
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$i, $dato->actual_dis_ant);
				$objPHPExcel->getActiveSheet()->SetCellValue('F'.$i, $dato->acumulado_dis_ant);
				$objPHPExcel->getActiveSheet()->SetCellValue('G'.$i, $dato->hospital_ant);
				$objPHPExcel->getActiveSheet()->SetCellValue('H'.$i, $dato->defuncion_ant);
				$objPHPExcel->getActiveSheet()->SetCellValue('I'.$i, $dato->total_ant);
				$objPHPExcel->getActiveSheet()->SetCellValue('J'.$i, $dato->actual_daa_act);
				$objPHPExcel->getActiveSheet()->SetCellValue('K'.$i, $dato->acumulado_daa_act);
				$objPHPExcel->getActiveSheet()->SetCellValue('L'.$i, $dato->actual_dis_act);
				$objPHPExcel->getActiveSheet()->SetCellValue('M'.$i, $dato->acumulado_dis_act);
				$objPHPExcel->getActiveSheet()->SetCellValue('N'.$i, $dato->hospital_act);
				$objPHPExcel->getActiveSheet()->SetCellValue('O'.$i, $dato->defuncion_act);
				$objPHPExcel->getActiveSheet()->SetCellValue('P'.$i, $dato->total_act);
				$i++;
			}
			 
			$objPHPExcel->setActiveSheetIndex(4);
			
			$i = 7;
			
			foreach($tabla4 as $dato){
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, $dato->actual_ira_ant);
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, $dato->acumulado_ira_ant);
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$i, $dato->actual_neu_ant);
				$objPHPExcel->getActiveSheet()->SetCellValue('F'.$i, $dato->acumulado_neu_ant);
				$objPHPExcel->getActiveSheet()->SetCellValue('G'.$i, $dato->hospital_ant);
				$objPHPExcel->getActiveSheet()->SetCellValue('H'.$i, $dato->defuncion_ant);
				$objPHPExcel->getActiveSheet()->SetCellValue('I'.$i, $dato->total_ant);
				$objPHPExcel->getActiveSheet()->SetCellValue('J'.$i, $dato->actual_ira_act);
				$objPHPExcel->getActiveSheet()->SetCellValue('K'.$i, $dato->acumulado_ira_act);
				$objPHPExcel->getActiveSheet()->SetCellValue('L'.$i, $dato->actual_neu_act);
				$objPHPExcel->getActiveSheet()->SetCellValue('M'.$i, $dato->acumulado_neu_act);
				$objPHPExcel->getActiveSheet()->SetCellValue('N'.$i, $dato->hospital_act);
				$objPHPExcel->getActiveSheet()->SetCellValue('O'.$i, $dato->defuncion_act);
				$objPHPExcel->getActiveSheet()->SetCellValue('P'.$i, $dato->total_act);
				$i++;
			}
			 
			ob_end_clean();
			 
			header('Content-type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="tablas para boletines.xlsx"');
			header('Cache-Control: max-age=0');
			 
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');
			
		}else{
			if(!empty($this->session_id)){
				$this->layout->view('boletines');
			}else{
				redirect(site_url("backend/index/login"), 301);
			}
		}
	}
}