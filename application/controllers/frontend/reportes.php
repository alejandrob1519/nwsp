<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reportes extends CI_Controller {
    
    private $session_id;

	public function __construct()
    {
        parent::__construct();
        $this->layout->setLayout('template7');
        $this->layout->setTitle(":: NotiWeb :: Vigilancia Epidemiol&oacute;gica");
        $this->session_id =  $this->session->userdata('usuario');
		date_default_timezone_set('America/Lima');
	}

    public function _example_output1($output = null)
    {
		$this->layout->view('generarCobertura.php',$output);
    }

    public function _example_output2($output = null)
    {
		$this->layout->view('notificacionExterna.php',$output);
    }

    public function _example_output3($output = null)
    {
		$this->layout->view('notificacionAutoriza.php',$output);
    }

    public function _example_output4($output = null)
    {
		$this->layout->view('bitacora.php',$output);
    }

	public function index()
    {
		$this->_example_output1((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
		$this->_example_output2((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
		$this->_example_output3((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
	}
	
	//Lista las coberturas generadas
	public function generarCobertura()
	{
		  if($this->session->userdata('institucion') != 'A'){
			  $this->session->set_flashdata('error', 'Su nivel de usuario no le permite realizar este proceso');
			  redirect(site_url("index/principal"), 301);
		  }
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
				redirect(site_url("index/principal"), 301);
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
					$this->load->view('frontend/reportes/reporteCobertura', compact('resultado', 'anio', 'semana'));
				}else{
					$this->session->set_flashdata('error', 'No hay informaci&oacute;n de cobertura para la semana elegida');
					redirect(site_url("index/principal"), 301);
				}
			}
		}else{
			if(!empty($this->session_id)){
				$this->layout->view('cobertura');
			}else{
				redirect(site_url("index/login"), 301);
			}
		}
    }
	
	//Proceso del reporte de notificación de casos notificados por otras diresas
    public function notificacionExterna()
    {
		$resultado = $this->reportes_model->notificacionExterna();
		
		if($resultado == true){
			switch($this->session->userdata('nivel'))
			{
				case 5:
				$where1 = array('subregion' => $this->session->userdata('diresa'));
				$where2 = array('sub_reg_nt <> ' => $this->session->userdata('diresa'));
				break;
			}

			$crud = new grocery_CRUD();
	
			$crud->columns('semana', 'diagnostic', 'ubigeo', 'tipo_dx', 'apepat', 'apemat', 'nombres', 'edad', 'tipo_edad', 'semana_not', 'fecha_ini', 'sub_reg_nt');
			$crud->set_table('individual');
			$crud->set_relation("ubigeo", "distrito", "nombre");
			$crud->set_relation("sub_reg_nt", "diresas", "nombre");
			$crud->set_relation("diagnostic", "diagno", "diagno");
			$crud->display_as('sub_reg_nt', 'Notificante');
			$crud->display_as('ubigeo', 'Distrito');
			$crud->where($where1);
			$crud->where($where2);
			
			$crud->unset_add();
			$crud->unset_read();
			$crud->unset_edit();
			$crud->unset_delete();
			//$crud->unset_export();
			$crud->unset_print();

			$output = $crud->render();
	
			$this->_example_output2($output);
		}else{
			$this->session->set_flashdata('error', 'No hay informaci&oacute;n acerca de este proceso para su nivel de usuario');
			redirect(site_url("index/principal"), 301);
		}
    }
	
	//Listas las autorizaciones de las diresas
	public function notificacionAutoriza()
	{
		if($this->session->userdata('nivel') != 5 or $this->session->userdata('institucion') != 'A'){
			$this->session->set_flashdata('error', 'Su nivel de usuario no le permite realizar este proceso');
			redirect(site_url("index/principal"), 301);
		}
		
		switch($this->session->userdata('nivel'))
		{
			case 5:
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
			
			$sub = $this->frontend_model->mostrarDiresa($this->session->userdata('diresa'));
	
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
			
			$where = array('diresa' => $this->session->userdata('diresa'));
			
			$crud->fields('ano', 'semana', 'diresa', 'estado');
			$crud->display_as('ano', 'A&ntilde;o');
			$crud->field_type('ano','dropdown',$anio);
			$crud->field_type('semana','dropdown',$semana);
			$crud->field_type('diresa','dropdown',$subr);
			$crud->field_type('estado','dropdown',$tipo);
			$crud->required_fields('diresa', 'ano', 'semana', 'estado');
			$crud->where($where);
			$crud->order_by('ano, semana', 'DESC');
			$crud->callback_insert(array($this,'autorizar'));
			
			$output = $crud->render();
	
			$this->_example_output3($output);
			break;
			default:
			$this->session->set_flashdata('error', 'Este proceso no est&aacute; permitido para su nivel de usuario');
			redirect(site_url("index/principal"), 301);
			break;
		}
	}
	
	//calback que registra la autorización
	public function autorizar($post_array){
		$post_array['fecha'] = date("Y-m-d");
		$post_array['hora'] = date("H:m:s");
		$post_array['usuario'] = $this->session->userdata('usuario');
		
/*		$reporta = array('ano'=>$post_array['ano'], 'semana'=>$post_array['semana'],'diresa'=>$this->session->userdata('diresa'));

		$comprobante = $this->reportes_model->compruebaProcesos($reporta);
		
		if($comprobante->notificacion <> '1'){
			$this->session->set_flashdata('error', 'Error: Usted no ha procesado el reporte de notificación, debe hacerlo antes de autorizar la notificaci&oacute;n.');
			redirect(site_url("reportes/notificacionAutoriza"), 301);
			return false;
		}elseif($comprobante->calidad <> '1'){
			$this->session->set_flashdata('error', 'Error: Usted no ha procesado el control de calidad, debe hacerlo antes de autorizar la notificaci&oacute;n.');
			redirect(site_url("reportes/notificacionAutoriza"), 301);
			return false;
		}elseif($comprobante->cobertura <> '1'){
			$lang['insert_mensaje'] = 'Error: Usted no ha procesado el reporte de coberturas, debe hacerlo antes de autorizar la notificaci&oacute;n.';
			$this->grocery_crud->set_lang_string('insert_mensaje', 'Error: Usted no ha procesado el reporte de coberturas, debe hacerlo antes de autorizar la notificaci&oacute;n.');
			return false;
		}elseif($comprobante->bitacora <> '1'){
			$this->session->set_flashdata('error', 'Error: Usted no ha registrado el Anexo 1 (Bitacora), debe hacerlo antes de autorizar la notificaci&oacute;n.');
			redirect(site_url("reportes/notificacionAutoriza"), 301);
			return false;
		}else{
			return $this->db->insert('autoriza',$post_array);
			return true;
		}
*/
		return $this->db->insert('autoriza',$post_array);
		return true;
	}

	//Proceso del reporte de notificación
    public function proceso()
    {
		if($this->input->post())
		{
            if ($this->form_validation->run("reportes/reportes"))
            {
				$reporta = array('ano'=>$this->input->post('anio'), 'semana'=>$this->input->post('semana'));
				
				$this->reportes_model->registraCobertura($reporta);
				
				$this->frontend_model->revision('cobertura');

				$anio = $this->input->post('anio');
				$semana = $this->input->post('semana');
				
				$this->reportes_model->reporteNotificacion($anio, $semana);
				
				redirect('reportes/generarCobertura', 301);
			}
		}else{
			if(!empty($this->session_id)){
				$this->layout->view('proceso');
			}else{
				redirect(site_url("index/login"), 301);
			}
		}
    }
	
	//Proceso del reporte de notificación
    public function notificacion()
    {
		if($this->input->post())
		{
            if ($this->form_validation->run("reportes/reportes"))
            {
				$this->frontend_model->revision('notificacion');
				
				$anio = $this->input->post('anio');
				$semana = $this->input->post('semana');
				
				$resultado = $this->reportes_model->notificacion($anio, $semana);
				
				if($resultado == true){
					$reporta = array('ano'=>$this->input->post('anio'), 'semana'=>$this->input->post('semana'));
					
					$this->reportes_model->registraNotificacion($reporta);
					
					$this->load->view('frontend/reportes/reporteNotificacion', compact('resultado', 'anio', 'semana'));
				}else{
					$this->session->set_flashdata('error', 'No hay informaci&oacute;n de notificaci&oacute;n para la semana elegida');
					redirect(site_url("index/principal"), 301);
				}
			}
		}else{
			if(!empty($this->session_id)){
				$this->layout->view('notificacion');
			}else{
				redirect(site_url("index/login"), 301);
			}
		}
    }
	
	//Emisión de reportes de la notificación individual en tiempo, espacio y persona.
    public function repIndividual()
    {
		if($this->input->post())
		{
            if ($this->form_validation->run("reportes/repIndividual"))
            {
				$opcion = $this->input->post('opcion');
				$anio = date("Y");
				$departamento = $this->input->post('departamento');
				$provincia = $this->input->post('provincia');
				$distrito = $this->input->post('distrito');
				$diresa = $this->input->post('diresa');
				$redes = $this->input->post('redes');
				$microred = $this->input->post('microred');
				$establec = $this->input->post('establec');
				$nivel = $this->input->post('nivel');
				$diagno = $this->input->post('diagno');
				
				if($nivel == "ubigeo"){
					if($opcion == "t_ind"){
						$resultado = $this->reportes_model->notificacionIndTiempoUbigeo($anio, $diagno, $departamento, $provincia, $distrito);
					}elseif($opcion == "e_ind"){
						$resultado = $this->reportes_model->notificacionIndEspacioUbigeo($anio, $diagno, $departamento, $provincia, $distrito);
					}elseif($opcion == "p_ind"){
						$resultado = $this->reportes_model->notificacionIndPersonaUbigeo($anio, $diagno, $departamento, $provincia, $distrito);
					}
				}if($nivel == "eess"){
					if($opcion == "t_ind"){
						$resultado = $this->reportes_model->notificacionIndTiempoEESS($anio, $diagno, $diresa, $redes, $microred, $establec);
					}elseif($opcion == "e_ind"){
						$resultado = $this->reportes_model->notificacionIndEspacioEESS($anio, $diagno, $diresa, $redes, $microred, $establec);
					}elseif($opcion == "p_ind"){
						$resultado = $this->reportes_model->notificacionIndPersonaEESS($anio, $diagno, $diresa, $redes, $microred, $establec);
					}
				}
				
				if($resultado == true){
					if($opcion == "t_ind"){
						$this->load->view('frontend/reportes/reporteIndTiempo', compact('resultado', 'anio', 'diagno', 'departamento', 'provincia', 'distrito', 'diresa', 'redes', 'microred', 'establec', 'opcion', 'nivel'));
					}elseif($opcion == "e_ind"){
						$this->load->view('frontend/reportes/reporteIndEspacio', compact('resultado', 'anio', 'diagno', 'departamento', 'provincia', 'distrito', 'diresa', 'redes', 'microred', 'establec', 'opcion', 'nivel'));
					}elseif($opcion == "p_ind"){
						$this->load->view('frontend/reportes/reporteIndPersona', compact('resultado', 'anio', 'diagno', 'departamento', 'provincia', 'distrito', 'diresa', 'redes', 'microred', 'establec', 'opcion', 'nivel'));
					}
				}else{
					$this->session->set_flashdata('error', 'No hay informaci&oacute;n de notificaci&oacute;n para la semana elegida');
					redirect(site_url("index/principal"), 301);
				}
			}else{
				$this->session->set_flashdata('info', 'Elija los datos necesarios por favor.');
				redirect(site_url("reportes/repIndividual"), 301);
			}
		}else{
	
			//combo Diagnóstico
			
			$diag = $this->frontend_model->mostrarDiagnostico();
	
			$diagno[''] = 'Seleccione ...';
			foreach ($diag as $dato){
				$diagno[$dato->cie_10] = $dato->diagno;
			}
	
			//combo DIRESA
			
			if($this->session->userdata('diresa') == ''){
				$subreg = $this->frontend_model->buscarDiresas();
				
				$diresa[''] = 'Seleccione ...';
				foreach ($subreg as $dato){
					$diresa[$dato->codigo] = $dato->nombre;
				}
			}else{
				if($this->input->post('diresa') == ''){
					$subreg = $this->frontend_model->mostrarDiresa($this->session->userdata('diresa'));
					//$diresa[''] = 'Seleccione ...';
					foreach ($subreg as $dato){
						$diresa[$dato->codigo] = $dato->nombre;
					}
				}else{
					$subreg = $this->frontend_model->mostrarDiresa($this->input->post('diresa'));
					foreach ($subreg as $dato){
						$diresa[$dato->codigo] = $dato->nombre;
					}
				}
			}
	
			//combo Red
			
			if($this->session->userdata('red') != ''){
				$red = $this->frontend_model->mostrarRed($this->session->userdata('diresa'),$this->session->userdata('red'));
				//$redes[''] = 'Seleccione ...';
				foreach ($red as $dato){
					$redes[$dato->codigo] = $dato->nombre;
				}
			}else{
				if($this->input->post('red') == ''){
					$red = $this->frontend_model->buscarRedes($this->session->userdata('diresa'));
					$redes[''] = 'Seleccione ...';
					foreach ($red as $dato){
						$redes[$dato->codigo] = $dato->nombre;
					}
				}else{
					$red = $this->frontend_model->buscarRedes($this->input->post('diresa'));
					$redes[''] = 'Seleccione ...';
					foreach ($red as $dato){
						$redes[$dato->codigo] = $dato->nombre;
					}
				}
			}
	
			//combo Microred
			
			if($this->session->userdata('microred') != ''){
				$mred = $this->frontend_model->mostrarMicrored($this->session->userdata('diresa'),$this->session->userdata('red'),$this->session->userdata('microred'));
				//$microred[''] = 'Seleccione ...';
				foreach ($mred as $dato){
					$microred[$dato->codigo] = $dato->nombre;
				}
			}else{
				if($this->input->post('microred') == ''){
					$mred = $this->frontend_model->buscarMicroredes($this->session->userdata('diresa'),$this->session->userdata('red'));
					$microred[''] = 'Seleccione ...';
					foreach ($mred as $dato){
						$microred[$dato->codigo] = $dato->nombre;
					}
				}else{
					$mred = $this->frontend_model->buscarMicroredes($this->input->post('diresa'),$this->input->post('redes'));
					$microred[''] = 'Seleccione ...';
					foreach ($mred as $dato){
						$microred[$dato->codigo] = $dato->nombre;
					}
				}
			}
	
			//combo Establecimiento
			
			if($this->session->userdata('establecimiento') != ''){
				$est = $this->frontend_model->mostrarEstablecimiento($this->session->userdata('establecimiento'));
				//$establec[''] = 'Seleccione ...';
				foreach ($est as $dato){
					$establec[$dato->cod_est] = $dato->raz_soc;
				}
			}else{
				if($this->input->post('establec') == ''){
					$est = $this->frontend_model->buscarEstablec($this->session->userdata('diresa'),$this->session->userdata('red'),$this->session->userdata('microred'));
					$establec[''] = 'Seleccione ...';
					foreach ($est as $dato){
						$establec[$dato->cod_est] = $dato->raz_soc;
					}
				}else{
					$est = $this->frontend_model->buscarEstablec($this->input->post('diresa'),$this->input->post('redes'),$this->input->post('microred'));
					$establec[''] = 'Seleccione ...';
					foreach ($est as $dato){
						$establec[$dato->cod_est] = $dato->raz_soc;
					}
				}
			}
			
			//combo Departamentos
			
			$depar = $this->frontend_model->buscarDepartamentos();
	
			$departamento[''] = 'Seleccione ...';
			foreach ($depar as $dato){
				$departamento[$dato->ubigeo] = $dato->nombre;
			}
			
			//combo Provincias
			
			if($this->input->post('departamento') != ''){
				$prov = $this->frontend_model->buscarProvincias($this->input->post('departamento'));
		
				//$provincia[''] = 'Seleccione ...';
				foreach ($prov as $dato){
					$provincia[$dato->ubigeo] = $dato->nombre;
				}
			}
			
			//combo Distrito
			
			if($this->input->post('provincia') != ''){
				$dist = $this->frontend_model->buscarDistritos($this->input->post('provincia'));
		
				//$distrito[''] = 'Seleccione ...';
				foreach ($dist as $dato){
					$distrito[$dato->ubigeo] = $dato->nombre;
				}
			}
			
			if(!empty($this->session_id)){
				$this->layout->view('repIndividual', compact('diagno', 'departamento', 'provincia', 'distrito', 'diresa', 'redes', 'microred', 'establec'));
			}else{
				redirect(site_url("index/login"), 301);
			}
		}
    }
	
	//Emisión de reportes de la notificación de EDA en tiempo y espacio.
    public function repEdas()
    {
		if($this->input->post()){
            if ($this->form_validation->run("reportes/repColetivo"))
            {
				$opcion = $this->input->post('opcion');
				$anio = date("Y");
				$departamento = $this->input->post('departamento');
				$provincia = $this->input->post('provincia');
				$distrito = $this->input->post('distrito');
				$diresa = $this->input->post('diresa');
				$redes = $this->input->post('redes');
				$microred = $this->input->post('microred');
				$establec = $this->input->post('establec');
				$nivel = $this->input->post('nivel');
				
				if($nivel == "ubigeo"){
					if($opcion == "t_ind"){
						$resultado = $this->reportes_model->notificacionEdaTiempoUbigeo($anio, $departamento, $provincia, $distrito);
					}elseif($opcion == "e_ind"){
						$resultado = $this->reportes_model->notificacionEdaEspacioUbigeo($anio, $departamento, $provincia, $distrito);
					}
				}if($nivel == "eess"){
					if($opcion == "t_ind"){
						$resultado = $this->reportes_model->notificacionEdaTiempoEESS($anio, $diresa, $redes, $microred, $establec);
					}elseif($opcion == "e_ind"){
						$resultado = $this->reportes_model->notificacionEdaEspacioEESS($anio, $diresa, $redes, $microred, $establec);
					}
				}
				
				if($resultado == true){
					if($opcion == "t_ind"){
						$this->load->view('frontend/reportes/reporteEdaTiempo', compact('resultado', 'anio', 'departamento', 'provincia', 'distrito', 'diresa', 'redes', 'microred', 'establec', 'opcion', 'nivel'));
					}elseif($opcion == "e_ind"){
						$this->load->view('frontend/reportes/reporteEdaEspacio', compact('resultado', 'anio', 'departamento', 'provincia', 'distrito', 'diresa', 'redes', 'microred', 'establec', 'opcion', 'nivel'));
					}
				}else{
					$this->session->set_flashdata('error', 'No hay informaci&oacute;n de notificaci&oacute;n para la semana elegida');
					redirect(site_url("index/principal"), 301);
				}
			}else{
				$this->session->set_flashdata('info', 'Elija los datos necesarios por favor.');
				redirect(site_url("reportes/repEdas"), 301);
			}
		}else{
	
			//combo DIRESA
			
			if($this->session->userdata('diresa') == ''){
				$subreg = $this->frontend_model->buscarDiresas();
				
				$diresa[''] = 'Seleccione ...';
				foreach ($subreg as $dato){
					$diresa[$dato->codigo] = $dato->nombre;
				}
			}else{
				if($this->input->post('diresa') == ''){
					$subreg = $this->frontend_model->mostrarDiresa($this->session->userdata('diresa'));
					//$diresa[''] = 'Seleccione ...';
					foreach ($subreg as $dato){
						$diresa[$dato->codigo] = $dato->nombre;
					}
				}else{
					$subreg = $this->frontend_model->mostrarDiresa($this->input->post('diresa'));
					foreach ($subreg as $dato){
						$diresa[$dato->codigo] = $dato->nombre;
					}
				}
			}
	
			//combo Red
			
			if($this->session->userdata('red') != ''){
				$red = $this->frontend_model->mostrarRed($this->session->userdata('diresa'),$this->session->userdata('red'));
				//$redes[''] = 'Seleccione ...';
				foreach ($red as $dato){
					$redes[$dato->codigo] = $dato->nombre;
				}
			}else{
				if($this->input->post('red') == ''){
					$red = $this->frontend_model->buscarRedes($this->session->userdata('diresa'));
					$redes[''] = 'Seleccione ...';
					foreach ($red as $dato){
						$redes[$dato->codigo] = $dato->nombre;
					}
				}else{
					$red = $this->frontend_model->buscarRedes($this->input->post('diresa'));
					$redes[''] = 'Seleccione ...';
					foreach ($red as $dato){
						$redes[$dato->codigo] = $dato->nombre;
					}
				}
			}
	
			//combo Microred
			
			if($this->session->userdata('microred') != ''){
				$mred = $this->frontend_model->mostrarMicrored($this->session->userdata('diresa'),$this->session->userdata('red'),$this->session->userdata('microred'));
				//$microred[''] = 'Seleccione ...';
				foreach ($mred as $dato){
					$microred[$dato->codigo] = $dato->nombre;
				}
			}else{
				if($this->input->post('microred') == ''){
					$mred = $this->frontend_model->buscarMicroredes($this->session->userdata('diresa'),$this->session->userdata('red'));
					$microred[''] = 'Seleccione ...';
					foreach ($mred as $dato){
						$microred[$dato->codigo] = $dato->nombre;
					}
				}else{
					$mred = $this->frontend_model->buscarMicroredes($this->input->post('diresa'),$this->input->post('redes'));
					$microred[''] = 'Seleccione ...';
					foreach ($mred as $dato){
						$microred[$dato->codigo] = $dato->nombre;
					}
				}
			}
	
			//combo Establecimiento
			
			if($this->session->userdata('establecimiento') != ''){
				$est = $this->frontend_model->mostrarEstablecimiento($this->session->userdata('establecimiento'));
				//$establec[''] = 'Seleccione ...';
				foreach ($est as $dato){
					$establec[$dato->cod_est] = $dato->raz_soc;
				}
			}else{
				if($this->input->post('establec') == ''){
					$est = $this->frontend_model->buscarEstablec($this->session->userdata('diresa'),$this->session->userdata('red'),$this->session->userdata('microred'));
					$establec[''] = 'Seleccione ...';
					foreach ($est as $dato){
						$establec[$dato->cod_est] = $dato->raz_soc;
					}
				}else{
					$est = $this->frontend_model->buscarEstablec($this->input->post('diresa'),$this->input->post('redes'),$this->input->post('microred'));
					$establec[''] = 'Seleccione ...';
					foreach ($est as $dato){
						$establec[$dato->cod_est] = $dato->raz_soc;
					}
				}
			}
			
			//combo Departamentos
			
			$depar = $this->frontend_model->buscarDepartamentos();
	
			$departamento[''] = 'Seleccione ...';
			foreach ($depar as $dato){
				$departamento[$dato->ubigeo] = $dato->nombre;
			}
			
			//combo Provincias
			
			if($this->input->post('departamento') != ''){
				$prov = $this->frontend_model->buscarProvincias($this->input->post('departamento'));
		
				//$provincia[''] = 'Seleccione ...';
				foreach ($prov as $dato){
					$provincia[$dato->ubigeo] = $dato->nombre;
				}
			}
			
			//combo Distrito
			
			if($this->input->post('provincia') != ''){
				$dist = $this->frontend_model->buscarDistritos($this->input->post('provincia'));
		
				//$distrito[''] = 'Seleccione ...';
				foreach ($dist as $dato){
					$distrito[$dato->ubigeo] = $dato->nombre;
				}
			}
			
			if(!empty($this->session_id)){
				$this->layout->view('repEdas', compact('departamento', 'provincia', 'distrito', 'diresa', 'redes', 'microred', 'establec'));
			}else{
				redirect(site_url("index/login"), 301);
			}
		}
    }
	
	//Emisión de reportes de la notificación de IRA en tiempo y espacio.
    public function repIras()
    {
		if($this->input->post()){
            if ($this->form_validation->run("reportes/repColetivo"))
            {
				$opcion = $this->input->post('opcion');
				$anio = date("Y");
				$departamento = $this->input->post('departamento');
				$provincia = $this->input->post('provincia');
				$distrito = $this->input->post('distrito');
				$diresa = $this->input->post('diresa');
				$redes = $this->input->post('redes');
				$microred = $this->input->post('microred');
				$establec = $this->input->post('establec');
				$nivel = $this->input->post('nivel');
				
				if($nivel == "ubigeo"){
					if($opcion == "t_ind"){
						$resultado = $this->reportes_model->notificacionIraTiempoUbigeo($anio, $departamento, $provincia, $distrito);
					}elseif($opcion == "e_ind"){
						$resultado = $this->reportes_model->notificacionIraEspacioUbigeo($anio, $departamento, $provincia, $distrito);
					}
				}if($nivel == "eess"){
					if($opcion == "t_ind"){
						$resultado = $this->reportes_model->notificacionIraTiempoEESS($anio, $diresa, $redes, $microred, $establec);
					}elseif($opcion == "e_ind"){
						$resultado = $this->reportes_model->notificacionIraEspacioEESS($anio, $diresa, $redes, $microred, $establec);
					}
				}
				
				if($resultado == true){
					if($opcion == "t_ind"){
						$this->load->view('frontend/reportes/reporteIraTiempo', compact('resultado', 'anio', 'departamento', 'provincia', 'distrito', 'diresa', 'redes', 'microred', 'establec', 'opcion', 'nivel'));
					}elseif($opcion == "e_ind"){
						$this->load->view('frontend/reportes/reporteIraEspacio', compact('resultado', 'anio', 'departamento', 'provincia', 'distrito', 'diresa', 'redes', 'microred', 'establec', 'opcion', 'nivel'));
					}
				}else{
					$this->session->set_flashdata('error', 'No hay informaci&oacute;n de notificaci&oacute;n para la semana elegida');
					redirect(site_url("index/principal"), 301);
				}
			}else{
				$this->session->set_flashdata('info', 'Elija los datos necesarios por favor.');
				redirect(site_url("reportes/repIras"), 301);
			}
		}else{
	
			//combo DIRESA
			
			if($this->session->userdata('diresa') == ''){
				$subreg = $this->frontend_model->buscarDiresas();
				
				$diresa[''] = 'Seleccione ...';
				foreach ($subreg as $dato){
					$diresa[$dato->codigo] = $dato->nombre;
				}
			}else{
				if($this->input->post('diresa') == ''){
					$subreg = $this->frontend_model->mostrarDiresa($this->session->userdata('diresa'));
					//$diresa[''] = 'Seleccione ...';
					foreach ($subreg as $dato){
						$diresa[$dato->codigo] = $dato->nombre;
					}
				}else{
					$subreg = $this->frontend_model->mostrarDiresa($this->input->post('diresa'));
					foreach ($subreg as $dato){
						$diresa[$dato->codigo] = $dato->nombre;
					}
				}
			}
	
			//combo Red
			
			if($this->session->userdata('red') != ''){
				$red = $this->frontend_model->mostrarRed($this->session->userdata('diresa'),$this->session->userdata('red'));
				//$redes[''] = 'Seleccione ...';
				foreach ($red as $dato){
					$redes[$dato->codigo] = $dato->nombre;
				}
			}else{
				if($this->input->post('red') == ''){
					$red = $this->frontend_model->buscarRedes($this->session->userdata('diresa'));
					$redes[''] = 'Seleccione ...';
					foreach ($red as $dato){
						$redes[$dato->codigo] = $dato->nombre;
					}
				}else{
					$red = $this->frontend_model->buscarRedes($this->input->post('diresa'));
					$redes[''] = 'Seleccione ...';
					foreach ($red as $dato){
						$redes[$dato->codigo] = $dato->nombre;
					}
				}
			}
	
			//combo Microred
			
			if($this->session->userdata('microred') != ''){
				$mred = $this->frontend_model->mostrarMicrored($this->session->userdata('diresa'),$this->session->userdata('red'),$this->session->userdata('microred'));
				//$microred[''] = 'Seleccione ...';
				foreach ($mred as $dato){
					$microred[$dato->codigo] = $dato->nombre;
				}
			}else{
				if($this->input->post('microred') == ''){
					$mred = $this->frontend_model->buscarMicroredes($this->session->userdata('diresa'),$this->session->userdata('red'));
					$microred[''] = 'Seleccione ...';
					foreach ($mred as $dato){
						$microred[$dato->codigo] = $dato->nombre;
					}
				}else{
					$mred = $this->frontend_model->buscarMicroredes($this->input->post('diresa'),$this->input->post('redes'));
					$microred[''] = 'Seleccione ...';
					foreach ($mred as $dato){
						$microred[$dato->codigo] = $dato->nombre;
					}
				}
			}
	
			//combo Establecimiento
			
			if($this->session->userdata('establecimiento') != ''){
				$est = $this->frontend_model->mostrarEstablecimiento($this->session->userdata('establecimiento'));
				//$establec[''] = 'Seleccione ...';
				foreach ($est as $dato){
					$establec[$dato->cod_est] = $dato->raz_soc;
				}
			}else{
				if($this->input->post('establec') == ''){
					$est = $this->frontend_model->buscarEstablec($this->session->userdata('diresa'),$this->session->userdata('red'),$this->session->userdata('microred'));
					$establec[''] = 'Seleccione ...';
					foreach ($est as $dato){
						$establec[$dato->cod_est] = $dato->raz_soc;
					}
				}else{
					$est = $this->frontend_model->buscarEstablec($this->input->post('diresa'),$this->input->post('redes'),$this->input->post('microred'));
					$establec[''] = 'Seleccione ...';
					foreach ($est as $dato){
						$establec[$dato->cod_est] = $dato->raz_soc;
					}
				}
			}
			
			//combo Departamentos
			
			$depar = $this->frontend_model->buscarDepartamentos();
	
			$departamento[''] = 'Seleccione ...';
			foreach ($depar as $dato){
				$departamento[$dato->ubigeo] = $dato->nombre;
			}
			
			//combo Provincias
			
			if($this->input->post('departamento') != ''){
				$prov = $this->frontend_model->buscarProvincias($this->input->post('departamento'));
		
				//$provincia[''] = 'Seleccione ...';
				foreach ($prov as $dato){
					$provincia[$dato->ubigeo] = $dato->nombre;
				}
			}
			
			//combo Distrito
			
			if($this->input->post('provincia') != ''){
				$dist = $this->frontend_model->buscarDistritos($this->input->post('provincia'));
		
				//$distrito[''] = 'Seleccione ...';
				foreach ($dist as $dato){
					$distrito[$dato->ubigeo] = $dato->nombre;
				}
			}
			
			if(!empty($this->session_id)){
				$this->layout->view('repIras', compact('departamento', 'provincia', 'distrito', 'diresa', 'redes', 'microred', 'establec'));
			}else{
				redirect(site_url("index/login"), 301);
			}
		}
    }
	
	public function bitacora(){
		if($this->session->userdata('nivel') < 5){
			$this->session->set_flashdata('error', 'Su nivel no le permite realizar este proceso');
			redirect(site_url("index/principal"), 301);
		}

		$anio = array();
		
		for($i=date('Y');$i>=date("Y")-1;$i--)
		{
			$anio[$i] = $i;
		}
		
		$semana = array();
		
		for($i=1;$i<=53;$i++)
		{
			$semana[$i] = $i;
		}
		
		$where = array('diresa'=>$this->session->userdata('diresa'));
		
		$crud = new grocery_CRUD();

		$crud->set_table('bitacora');
		$crud->columns('ano', 'semana','diresa','individual','edas','iras','brotes','inmuno','cobertura','usuario','fechaReg');
		$crud->where($where);
		$crud->display_as('ano','A&ntilde;o')
			 ->display_as('inmuno','Inmunoprevenibles')
			 ->display_as('fechaReg','Registro');
		$crud->set_subject('Anexo');
		$crud->set_relation('diresa','diresas','nombre', array('codigo'=>$this->session->userdata('diresa')));
		$crud->field_type('ano','dropdown',$anio);
		$crud->field_type('semana','dropdown',$semana);
		$crud->set_rules('diresa','DIRESA','required|xss');
		$crud->set_rules('ano','A&ntilde;o','required|numeric|xss');
		$crud->set_rules('semana','Semana','required|numeric|xss');
		$crud->set_rules('individual','Individual','required|xss');
		$crud->set_rules('edas','EDAs','required|xss');
		$crud->set_rules('iras','IRAs','required|xss');
		$crud->set_rules('brotes','Secci&oacute;n Brotes','required|xss');
		$crud->set_rules('inmuno','Secci&oacute;n Inmunoprevenibles','required|xss');
		$crud->set_rules('cobertura','Cobertura','required|xss');
		$crud->callback_add_field('individual',array($this,'insertarIndividual'));
		$crud->callback_add_field('edas',array($this,'insertarEdas'));
		$crud->callback_add_field('iras',array($this,'insertarIras'));
		$crud->callback_add_field('cobertura',array($this,'insertarCobertura'));
		$crud->callback_add_field('usuario',array($this,'insertarUsuario'));
		$crud->callback_add_field('fechaReg',array($this,'insertarFecha'));

		$crud->callback_after_insert(array($this,'ingresaBitacora'));
		
		$output = $crud->render();

		$this->_example_output4($output);
		
	}	
	
	// Validando tipo de descripción
	function validar_Descripcion($str){
		$dat = $this->input->post('opcion');
		if(empty($dat))
		{
			$this->form_validation->set_message('validar_Descripcion',
			'Debe elegir alg&uacute;n nivel de descripci&oacute;n');
			return FALSE;
		}else{
			return true;
		}
	}

	//calback que registra la fecha de registro y el usuario
	public function insertarUsuario($post_array){
		return '<input type="text" maxlength="15" value="'.$this->session->userdata('usuario').'" name="usuario">';
	}
	
	public function insertarFecha($post_array){
		return '<input type="text" maxlength="15" value="'.date('d-m-Y').'" name="fechaReg">';
	}

	public function insertarCobertura($post_array){
		return '<input type="text" maxlength="15" value="" name="cobertura"> <b>(*) Porcentaje</b>';
	}

	public function insertarIndividual($post_array){
		return '<input type="text" maxlength="15" value="" name="individual"> <b>(*) Total registros enviados</b>';
	}

	public function insertarEdas($post_array){
		return '<input type="text" maxlength="15" value="" name="edas"> <b>(*) Total registros enviados</b>';
	}

	public function insertarIras($post_array){
		return '<input type="text" maxlength="15" value="" name="iras"> <b>(*) Total registros enviados</b>';
	}
	
	//calback que registra la autorización
	public function ingresaBitacora($post_array){
		$reporta = array('ano'=>$post_array['ano'], 'semana'=>$post_array['semana']);

		$this->reportes_model->registraBitacora($reporta);
		
		return true;
	}
}
