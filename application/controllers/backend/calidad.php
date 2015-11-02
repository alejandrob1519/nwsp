<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Calidad extends CI_Controller {
    
    private $session_id;

	public function __construct()
    {
        parent::__construct();
        $this->layout->setLayout('templateBackendCalidad');
        $this->layout->setTitle(":: NotiWeb :: Vigilancia Epidemiol&oacute;gica");
        $this->session_id = $this->session->userdata('usuario');
		date_default_timezone_set('America/Lima');
	}

	public function index()
    {
        if(empty($this->session_id)){
           	redirect(site_url("backend/index/login"), 301);
        }else{
			$this->layout->view('index.php');
        }
	}
	
	/* Control de Calidad para la sección de la notificación individual */
	
	public function individualCalidad(){
		if(empty($this->session_id)){
			redirect(site_url("backend/index/login"), 301);
		}
		
		$crud = new grocery_CRUD();
		$crud->set_table('individual');
		$crud->columns('ano', 'semana', 'diagnostic', 'tipo_dx', 'subregion', 'sub_reg_nt', 
					   'ubigeo', 'sexo', 'apepat', 'apemat', 'nombres');
		$crud->display_as('ano','A&ntilde;o')
			->display_as('diagnostic','Diagn&oacute;stico')
			->display_as('subregion','Diresa')
			->display_as('sub_reg_nt','Notificante')
			->display_as('ubigeo','Distrito')
			->display_as('tipo_dx','Tipo')
			->display_as('apepat','Ap. Paterno')
			->display_as('apemat','Ap. Materno');
		$crud->set_relation('subregion','diresas','nombre');         
		$crud->set_relation('sub_reg_nt','diresas','nombre');         
		$crud->set_relation('ubigeo','distrito','nombre');         
		$crud->set_relation('diagnostic','diagno','diagno');         
		$crud->field_type('tipo_dx','tipo_dx','denominacion');         
		$crud->field_type('sexo','dropdown',array('M'=>'Masculino', 'F'=>'Femenino'));   
		
		$semana = date('W')-2;
		
		switch($this->session->userdata('nivel')){
			case 4:
			$accesar = $this->session->userdata('equipo');
			$crud->where(array('ano'=>date('Y'), 'semana >'=>$semana));
			break;
			case 5:
			$accesar = $this->session->userdata('diresa');
			$crud->where(array('ano'=>date('Y'), 'semana >'=>$semana, 'subregion'=>$accesar));
			break;
			case 6:
			$accesar = $this->session->userdata('diresa');
			$accesar1 = $this->session->userdata('red');
			$crud->where(array('ano'=>date('Y'), 'semana >'=>$semana, 'sub_reg_nt' => $accesar, 'red' => $accesar1));
			break;
			case 7:
			$accesar = $this->session->userdata('diresa');
			$accesar1 = $this->session->userdata('red');
			$accesar2 = $this->session->userdata('microred');
			$crud->where(array('ano'=>date('Y'), 'semana >'=>$semana, 'sub_reg_nt' => $accesar, 'red' => $accesar1, 'microred' => $accesar2));
			break;
			case 8:
			$accesar = $this->session->userdata('establecimiento');
			$crud->where(array('ano'=>date('Y'), 'semana >'=>$semana, 'e_salud' => $accesar));
			break;
			default:
			$crud->where(array('ano'=>date('Y'), 'semana >'=>$semana));
		}
		
		$crud->order_by('semana', 'DESC');
				
		$crud->unset_add();
		$crud->unset_read();
		$crud->unset_edit();
		//$crud->unset_delete();
		//$crud->unset_export();
		$crud->unset_print();
		
		$crud->callback_after_delete(array($this,'log_registro_before_delete'));
		
		$output = $crud->render();
		
		$this->layout->view('individualCalidad.php', $output);
	}

	public function individualDiagnostico(){
		if(empty($this->session_id)){
			redirect(site_url("backend/index/login"), 301);
		}
		
		$this->calidad_model->diagnosticos();
		
		$crud = new grocery_CRUD();
		$crud->set_table('individualCalidad');
		$crud->columns('ano', 'semana', 'semana_not', 'diagnostic', 'tipo_dx', 'subregion', 'sub_reg_nt', 
					   'ubigeo', 'sexo', 'apepat', 'apemat', 'nombres', 'fecha_ini');
		$crud->display_as('ano','A&ntilde;o')
			->display_as('semana_not','Notificaci&oacute;n')
			->display_as('diagnostic','Diagn&oacute;stico')
			->display_as('subregion','Diresa')
			->display_as('sub_reg_nt','Notificante')
			->display_as('ubigeo','Distrito')
			->display_as('tipo_dx','Tipo')
			->display_as('apepat','Ap. Paterno')
			->display_as('apemat','Ap. Materno')
			->display_as('fecha_ini','Inicio');
		$crud->set_relation('subregion','diresas','nombre');         
		$crud->set_relation('sub_reg_nt','diresas','nombre');         
		$crud->set_relation('ubigeo','distrito','nombre');         
		$crud->field_type('tipo_dx','tipo_dx','denominacion');         
		$crud->field_type('sexo','dropdown',array('M'=>'Masculino', 'F'=>'Femenino'));   
		
		switch($this->session->userdata('nivel')){
			case 4:
			$accesar = $this->session->userdata('equipo');
			break;
			case 5:
			$accesar = $this->session->userdata('diresa');
			$crud->where(array('subregion' => $accesar, ));
			$crud->or_where(array('sub_reg_nt' => $accesar));
			break;
			case 6:
			$accesar = $this->session->userdata('diresa');
			$accesar1 = $this->session->userdata('red');
			$crud->where(array('sub_reg_nt' => $accesar, 'red' => $accesar1));
			break;
			case 7:
			$accesar = $this->session->userdata('diresa');
			$accesar1 = $this->session->userdata('red');
			$accesar2 = $this->session->userdata('microred');
			$crud->where(array('sub_reg_nt' => $accesar, 'red' => $accesar1, 'microred' => $accesar2));
			break;
			case 8:
			$accesar = $this->session->userdata('establecimiento');
			$crud->where(array('e_salud' => $accesar));
			break;
		}
		
		$crud->order_by('diagnostic');
				
		$crud->unset_add();
		$crud->unset_read();
		$crud->unset_edit();
		//$crud->unset_delete();
		//$crud->unset_export();
		$crud->unset_print();
		
		//$crud->callback_after_delete(array($this,'log_registro_after_delete'));
		
		$output = $crud->render();

		$this->layout->view('individualDiagnostico.php', $output);
	}
	
	public function duplicados(){
		$this->calidad_model->duplicados();
		redirect(site_url('backend/calidad/individualDuplicados'), 301);
	}

	public function individualDuplicados(){
		if(empty($this->session_id)){
			redirect(site_url("backend/index/login"), 301);
		}
		
		//Establecimiento
		
		switch ($this->session->userdata('nivel')){
			case 5:
			$est = $this->frontend_model->buscarEstablec($this->session->userdata('diresa'));
			$establec[''] = 'Seleccione ...';
			foreach ($est as $dato){
				$establec[$dato->cod_est] = $dato->raz_soc;
			}
			break;
			case 6:
			$est = $this->frontend_model->buscarEstablec($this->session->userdata('diresa'),$this->session->userdata('red'));
			$establec[''] = 'Seleccione ...';
			foreach ($est as $dato){
				$establec[$dato->cod_est] = $dato->raz_soc;
			}
			break;
			case 7:
			$est = $this->frontend_model->buscarEstablec($this->session->userdata('diresa'),$this->session->userdata('red'),$this->session->userdata('microred'));
			$establec[''] = 'Seleccione ...';
			foreach ($est as $dato){
				$establec[$dato->cod_est] = $dato->raz_soc;
			}
			break;
			case 8:
			$est = $this->frontend_model->buscarEstablec($this->session->userdata('establecimiento'));
			$establec[''] = 'Seleccione ...';
			foreach ($est as $dato){
				$establec[$dato->cod_est] = $dato->raz_soc;
			}
			break;
			default:
			$est = $this->frontend_model->listaEstablec();
			$establec[''] = 'Seleccione ...';
			foreach ($est as $dato){
				$establec[$dato->cod_est] = $dato->raz_soc;
			}
			break;
		}

		$crud = new grocery_CRUD();
		$crud->set_table('individualDuplicado');
		$crud->columns('ano', 'semana', 'diagnostic', 'tipo_dx', 'subregion', 'ubigeo', 'localidad', 'apepat', 'apemat', 
					   'nombres', 'edad', 'tipo_edad', 'sexo', 'fecha_ini', 'fecha_def', 'fecha_not', 'fecha_inv', 
					   'sub_reg_nt', 'red', 'microred', 'e_salud', 'semana_not', 'an_notific', 'fecha_ing', 'direccion', 
					   'etniaproc', 'etnias', 'procede', 'otroproc');
		$crud->display_as('ano','A&ntilde;o')
			->display_as('semana_not','Notificaci&oacute;n')
			->display_as('diagnostic','Diagn&oacute;stico')
			->display_as('subregion','Diresa')
			->display_as('sub_reg_nt','Notificante')
			->display_as('ubigeo','Distrito')
			->display_as('tipo_dx','Tipo');
		$crud->set_relation('subregion','diresas','nombre');         
		$crud->set_relation('sub_reg_nt','diresas','nombre');         
		$crud->set_relation('ubigeo','distrito','nombre');         
		$crud->set_relation('localcod','localidad','nombre');         
		$crud->set_relation('diagnostic','diagno','diagno');         
		$crud->field_type('e_salud','dropdown',$establec);         
		$crud->field_type('tipo_dx','tipo_dx','denominacion');         
		$crud->field_type('sexo','dropdown',array('M'=>'Masculino', 'F'=>'Femenino'));   
		
		switch($this->session->userdata('nivel')){
			case 4:
			$accesar = $this->session->userdata('equipo');
			break;
			case 5:
			$accesar = $this->session->userdata('diresa');
			$crud->where(array('subregion' => $accesar, ));
			$crud->or_where(array('sub_reg_nt' => $accesar));
			break;
			case 6:
			$accesar = $this->session->userdata('diresa');
			$accesar1 = $this->session->userdata('red');
			$crud->where(array('sub_reg_nt' => $accesar, 'red' => $accesar1));
			break;
			case 7:
			$accesar = $this->session->userdata('diresa');
			$accesar1 = $this->session->userdata('red');
			$accesar2 = $this->session->userdata('microred');
			$crud->where(array('sub_reg_nt' => $accesar, 'red' => $accesar1, 'microred' => $accesar2));
			break;
			case 8:
			$accesar = $this->session->userdata('establecimiento');
			$crud->where(array('e_salud' => $accesar));
			break;
		}
		
		$crud->order_by('diagnostic');
				
		$crud->unset_add();
		$crud->unset_read();
		$crud->unset_edit();
		//$crud->unset_delete();
		//$crud->unset_export();
		$crud->unset_print();
		
		//$crud->add_action('Eliminar', base_url().'assets/images/close.png', 'calidad/eliminarRegistro','borrar-icon');
		
		$crud->callback_after_delete(array($this,'log_registro_after_delete'));
		
		$output = $crud->render();

		$this->layout->view('individualDuplicados.php', $output);
	}

	public function inconsistencias(){
		$this->calidad_model->inconsistencias();
		redirect(site_url('backend/calidad/individualInconsistencias'), 301);
	}

	public function individualInconsistencias(){
		if(empty($this->session_id)){
			redirect(site_url("backend/index/login"), 301);
		}
		
		$est = $this->frontend_model->buscarEstablec($this->session->userdata('diresa'),$this->session->userdata('red'),$this->session->userdata('microred'));
		
		//$data = $this->calidad_model->inconsistencias();
		
		$crud = new grocery_CRUD();
		$crud->set_table('individualInconsistencias');
		$crud->display_as('ano','A&ntilde;o');
		
		switch($this->session->userdata('nivel')){
			case 4:
			$accesar = $this->session->userdata('equipo');
			break;
			case 5:
			$accesar = $this->session->userdata('diresa');
			$crud->where(array('subregion' => $accesar, ));
			$crud->or_where(array('sub_reg_nt' => $accesar));
			break;
			case 6:
			$accesar = $this->session->userdata('diresa');
			$accesar1 = $this->session->userdata('red');
			$crud->where(array('sub_reg_nt' => $accesar, 'red' => $accesar1));
			break;
			case 7:
			$accesar = $this->session->userdata('diresa');
			$accesar1 = $this->session->userdata('red');
			$accesar2 = $this->session->userdata('microred');
			$crud->where(array('sub_reg_nt' => $accesar, 'red' => $accesar1, 'microred' => $accesar2));
			break;
			case 8:
			$accesar = $this->session->userdata('establecimiento');
			$crud->where(array('e_salud' => $accesar));
			break;
		}
		
		$crud->order_by('semana');
				
		$crud->unset_add();
		$crud->unset_read();
		$crud->unset_edit();
		//$crud->unset_delete();
		//$crud->unset_export();
		$crud->unset_print();
		
		$crud->add_action('Editar', '', 'backend/calidad/modIndividual','edit-icon');
		$crud->callback_after_delete(array($this,'log_registro_after_delete'));
		
		$output = $crud->render();

		$this->layout->view('individualInconsistencias.php', $output);
	}

	//Modificar registro de la ficha de notificación individual
	
    public function modIndividual($id=null)
    {
		if(!$id)
		{
			show_404();
		}
		
        if($this->input->post()){
            if ($this->form_validation->run("notificacion/individual"))
            {
				$usuario = $this->session->userdata('usuario');
				
				$ano = substr($this->fechas_model->arreglarFechas($this->input->post('fecha_ini')),0,4);
				
				if($this->frontend_model->buscaCierre($ano) != 0)
				{
					$this->session->set_flashdata('error', 'El cierre de base de datos para el a&ntilde;o solicitado ya ha sido realizado, No se actualiz&oacute; la informaci&oacute;n');
					redirect(site_url('calidad/modIndividual'), 301);
				}
			
				$clave = $this->input->post('ano_ini').
				$this->input->post('semana_ini').
				$this->input->post('establec'). 
				$this->input->post('diagno').
				$this->input->post('edad').
				substr($this->input->post('apepat'),0,2). 
				substr($this->input->post('apepat'),0,2).
				substr($this->input->post('nombres'),0,2).
				$this->input->post('etnias').
				$this->input->post('subetnias').
				$this->input->post('sexo');
				
				if($this->input->post('paises') == '171'){
					$subr = $this->frontend_model->buscarDistrito($this->input->post('distrito'));
					$ubigeo = $this->input->post('distrito');
					
					foreach($subr as $dato)
					{
						$subregion = $dato->diresa;
					}
				}else{
					$subregion = '99';
					$ubigeo = '999999';
				}
				
				$data = array('ano' => $this->input->post('ano_ini'),
					'semana' => $this->input->post('semana_ini'),
					'diagnostic' => $this->input->post('diagno'),
					'tipo_dx' => $this->input->post('tipoDx'),
					'subregion' => $subregion,
					'ubigeo' => $ubigeo,
					'localcod' => $this->input->post('localidad'),
					'localidad' => '',
					'apepat' => $this->input->post('apepat'),
					'apemat' => $this->input->post('apemat'),
					'nombres' => $this->input->post('nombres'),
					'edad' => $this->input->post('edad'),
					'tipo_edad' => $this->input->post('tipo'),
					'sexo' => $this->input->post('sexo'),
					'protegido' => $this->input->post('protegido'),
					'fecha_ini' => $this->fechas_model->arreglarFechas($this->input->post('fecha_ini')),
					'fecha_def' => $this->fechas_model->arreglarFechas($this->input->post('fecha_def')),
					'fecha_not' => $this->fechas_model->arreglarFechas($this->input->post('fecha_not')),
					'fecha_inv' => $this->fechas_model->arreglarFechas($this->input->post('fecha_inv')),
					'sub_reg_nt' => $this->input->post('diresa'),
					'red' => $this->input->post('redes'),
					'microred' => $this->input->post('microred'),
					'e_salud' => $this->input->post('establec'),
					'semana_not' => $this->input->post('semana_not'),
					'an_notific' => substr($this->input->post('ano_not'),2,2),
					'fecha_ing' => date("Y-m-d"),
					'ficha_inv' => "",
					'tipo_noti' => $this->input->post('vigilancias'),
					'clave' => $clave,
					'importado' => '',
					'migrado' => '',
					'verifica' => '',
					'dni' => $this->input->post('dni'),
					'muestra' => $this->input->post('muestra'),
					'hc' => $this->input->post('historia'),
					'fecha_hos' => $this->fechas_model->arreglarFechas($this->input->post('fecha_hos')),
					'estado' => '',
					'tip_zona' => $this->input->post('zona'),
					'cod_pais' => $this->input->post('paises'),
					'tipo_id' => '',
					'direccion' => $this->input->post('direccion'),
					'etniaproc' => $this->input->post('etnias'),
					'etnias' => $this->input->post('subetnias'),
					'procede' => '',
					'otroproc' => $this->input->post('otro'),
					'usuario' => $usuario
				);
				
				if($this->session->userdata('grabar') == '1' and $this->session->userdata('modificar') == '1'){
					$guardar = $this->frontend_model->ejecutarModificarIndidivual($data, $id);
						
					if($guardar)
					{
						$this->mantenimiento_model->auditoriaOperador($this->session->userdata('usuario'), 'Modificar individual');
						$this->session->set_flashdata('exito', 'Informaci&oacute;n modificada con &eacute;xito.');
						redirect(site_url('backend/calidad/individualInconsistencias'), 301);
					}
				}else{
					$this->session->set_flashdata('error', 'Error: Usted no cuenta con autorizaci&oacute;n para grabar &oacute; modificar registros. NO se modific&oacute; la informaci&oacute;n corregida.');
					redirect(site_url('backend/calidad/individualInconsistencias'), 301);
				}
			}
		}
		
		// Buscando registro a modificar
		
		$modificar = $this->frontend_model->modificarIndividual($id);
		
		if(sizeof($modificar)==0)
		{
			show_404();
		}
		
		//combo vigilancias
		
		$vigila = $this->frontend_model->mostrarVigilancias();

		$vigilancias[''] = 'Seleccione ...';
		foreach ($vigila as $dato){
			$vigilancias[$dato->codigo] = $dato->denominacion;
		}

		//combo DIRESA
		
		$subreg = $this->frontend_model->mostrarDiresa($modificar->sub_reg_nt);

		$diresa[''] = 'Seleccione ...';
		foreach ($subreg as $dato){
			$diresa[$dato->codigo] = $dato->nombre;
		}

		//combo Red
		
		$red = $this->frontend_model->buscarRedes($modificar->sub_reg_nt);
		$redes[''] = 'Seleccione ...';
		foreach ($red as $dato){
			$redes[$dato->codigo] = $dato->nombre;
		}

		//combo Microred
		
		$mred = $this->frontend_model->buscarMicroredes($modificar->sub_reg_nt,$modificar->red);
		$microred[''] = 'Seleccione ...';
		foreach ($mred as $dato){
			$microred[$dato->codigo] = $dato->nombre;
		}

		//combo Establecimiento
		
		$est = $this->frontend_model->buscarEstablec($modificar->sub_reg_nt,$modificar->red,$modificar->microred);
		$establec[''] = 'Seleccione ...';
		foreach ($est as $dato){
			$establec[$dato->cod_est] = $dato->raz_soc;
		}

		//combo paises
		
		$pais = $this->frontend_model->buscarPaises();

		$paises[''] = 'Seleccione ...';
		foreach ($pais as $dato){
			$paises[$dato->codigo] = $dato->nombre;
		}

		//combo Departamentos
		
		$depar = $this->frontend_model->buscarDepartamentos();

		$departamento[''] = 'Seleccione ...';
		foreach ($depar as $dato){
			$departamento[$dato->ubigeo] = $dato->nombre;
		}

		//combo Provincias
		
		$prov = $this->frontend_model->buscarProvincias(substr($modificar->ubigeo,0,2));

		$provincia[''] = 'Seleccione ...';
		foreach ($prov as $dato){
			$provincia[$dato->ubigeo] = $dato->nombre;
		}

		//combo Distritos
		
		$dist = $this->frontend_model->buscarDistritos(substr($modificar->ubigeo,0,4));

		$distrito[''] = 'Seleccione ...';
		foreach ($dist as $dato){
			$distrito[$dato->ubigeo] = $dato->nombre;
		}

		//combo Localidad
		
		$loca = $this->frontend_model->buscarLocalidad($modificar->ubigeo);

		$localidad[''] = 'Seleccione ...';
		foreach ($loca as $dato){
			$localidad[$dato->codloc] = $dato->nombre;
		}

		//combo Etnias
		
		$etn = $this->frontend_model->mostrarEtnias();

		$etnias[''] = 'Seleccione ...';
		foreach ($etn as $dato){
			$etnias[$dato->registroId] = $dato->nombre;
		}

		//combo Sub-Etnias
		
		$setn = $this->frontend_model->mostrarSubEtnias($modificar->etniaproc);

		$subetnias[''] = 'Seleccione ...';
		foreach ($setn as $dato){
			$subetnias[$dato->registroId] = $dato->nombre;
		}

		//combo Diagnóstico
		
		$diag = $this->frontend_model->mostrarDiagnostico();

		$diagno[''] = 'Seleccione ...';
		foreach ($diag as $dato){
			$diagno[$dato->cie_10] = $dato->diagno;
		}

		//combo tipo de diagnóstico
		
		$tip = $this->frontend_model->mostrarTipo();

		$tipoDx[''] = 'Seleccione ...';
		foreach ($tip as $dato){
			$tipoDx[$dato->codigo] = $dato->denominacion;
		}

		$session_id = $this->session_id;
		$grabar_id = $this->session->userdata('grabar');
		$modificar_id = $this->session->userdata('modificar');
		
		if(!empty($this->session_id)){
	        //$this->layout->setLayout('template4');
			$this->layout->view('modIndividual', compact('session_id', 'modificar', 'vigilancias', 'diresa', 'redes', 'microred', 'establec', 'paises', 'departamento', 'provincia', 'distrito', 'localidad', 'etnias', 'subetnias', 'diagno', 'tipoDx'));
        }else{
			$this->layout->view('individualInconsistencias.php');
        }
    }

	public function individualEstablecimientos(){
		if(empty($this->session_id)){
			redirect(site_url("backend/index/login"), 301);
		}
		
		$this->calidad_model->establecimientos();
		
		$crud = new grocery_CRUD();
		$crud->set_table('individualCalidad');
		$crud->columns('ano', 'semana', 'diagnostic', 'tipo_dx', 'subregion', 'sub_reg_nt', 
					   'ubigeo', 'e_salud', 'apepat', 'apemat', 'nombres', 'fecha_ini');
		$crud->display_as('ano','A&ntilde;o')
			->display_as('diagnostic','Diagn&oacute;stico')
			->display_as('subregion','Diresa')
			->display_as('sub_reg_nt','Notificante')
			->display_as('ubigeo','Distrito')
			->display_as('tipo_dx','Tipo')
			->display_as('apepat','Ap. Paterno')
			->display_as('apemat','Ap. Materno')
			->display_as('fecha_ini','Inicio');
		$crud->set_relation('subregion','diresas','nombre');         
		$crud->set_relation('sub_reg_nt','diresas','nombre');         
		$crud->set_relation('ubigeo','distrito','nombre');         
		$crud->field_type('e_salud','dropdown',$establec);         
		$crud->field_type('tipo_dx','tipo_dx','denominacion');         
		$crud->field_type('sexo','dropdown',array('M'=>'Masculino', 'F'=>'Femenino'));   
		
		switch($this->session->userdata('nivel')){
			case 4:
			$accesar = $this->session->userdata('equipo');
			break;
			case 5:
			$accesar = $this->session->userdata('diresa');
			$crud->where(array('subregion' => $accesar, ));
			$crud->or_where(array('sub_reg_nt' => $accesar));
			break;
			case 6:
			$accesar = $this->session->userdata('diresa');
			$accesar1 = $this->session->userdata('red');
			$crud->where(array('sub_reg_nt' => $accesar, 'red' => $accesar1));
			break;
			case 7:
			$accesar = $this->session->userdata('diresa');
			$accesar1 = $this->session->userdata('red');
			$accesar2 = $this->session->userdata('microred');
			$crud->where(array('sub_reg_nt' => $accesar, 'red' => $accesar1, 'microred' => $accesar2));
			break;
			case 8:
			$accesar = $this->session->userdata('establecimiento');
			$crud->where(array('e_salud' => $accesar));
			break;
		}
		
		$crud->order_by('diagnostic');
				
		$crud->unset_add();
		$crud->unset_read();
		$crud->unset_edit();
		$crud->unset_delete();
		//$crud->unset_export();
		$crud->unset_print();
		
		//$crud->callback_after_delete(array($this,'log_registro_after_delete'));
		
		$output = $crud->render();

		$this->layout->view('individualEstablecimientos.php', $output);
	}
	
	public function nombres(){
		$this->calidad_model->nombresDuplicados();
		redirect(site_url('backend/calidad/individualNombres'), 301);
	}

	public function individualNombres(){
		if(empty($this->session_id)){
			redirect(site_url("backend/index/login"), 301);
		}
		
		$crud = new grocery_CRUD();
		$crud->set_table('individualNombres');
		$crud->columns('ano','semana','diagnostic','tipo_dx','subregion','sub_reg_nt','ubigeo','localidad', 
					   'apepat','apemat','nombres','edad','tipo_edad','sexo','fecha_ini','fecha_def', 'fecha_not', 
					   'red','microred','e_salud','direccion','etniaproc','etnias','procede','otroproc');
		$crud->display_as('ano','A&ntilde;o');
		
		switch($this->session->userdata('nivel')){
			case 4:
			$accesar = $this->session->userdata('equipo');
			break;
			case 5:
			$accesar = $this->session->userdata('diresa');
			$crud->where(array('subregion' => $accesar, ));
			$crud->or_where(array('sub_reg_nt' => $accesar));
			break;
			case 6:
			$accesar = $this->session->userdata('diresa');
			$accesar1 = $this->session->userdata('red');
			$crud->where(array('sub_reg_nt' => $accesar, 'red' => $accesar1));
			break;
			case 7:
			$accesar = $this->session->userdata('diresa');
			$accesar1 = $this->session->userdata('red');
			$accesar2 = $this->session->userdata('microred');
			$crud->where(array('sub_reg_nt' => $accesar, 'red' => $accesar1, 'microred' => $accesar2));
			break;
			case 8:
			$accesar = $this->session->userdata('establecimiento');
			$crud->where(array('e_salud' => $accesar));
			break;
		}
		
		$crud->unset_add();
		$crud->unset_read();
		$crud->unset_edit();
		//$crud->unset_delete();
		//$crud->unset_export();
		$crud->unset_print();
		
		$crud->callback_after_delete(array($this,'log_registro_after_delete'));
		
		$output = $crud->render();
		
		$this->layout->view('individualNombres.php', $output);
	}

	// Elimina registro 
	public function eliminarRegistro($id)
	{
		$this->calidad_model->eliminaIndividual(array('registroId'=>$id));		
        $this->session->set_flashdata('exito', 'registro eliminado exitosamente');
		redirect(site_url('backend/calidad/individualDuplicados'), 301);
	}
	
	public function eliminarDuplicado($id)
	{
		$this->calidad_model->eliminaIndividual(array('registroId'=>$id));		
        $this->session->set_flashdata('exito', 'registro eliminado exitosamente');
		redirect(site_url('backend/calidad/individualNombres'), 301);
	}

	// Callback para la eliminación de registro
	public function log_registro_after_delete($primary_key)
	{
		$this->calidad_model->eliminaIndividual(array('registroId'=>$primary_key));		
	}

	/* Control de Calidad para la sección de la notificación de las EDAs */

	public function edasCalidad(){
		if(empty($this->session_id)){
			redirect(site_url("backend/index/login"), 301);
		}
		
		$crud = new grocery_CRUD();
		$crud->set_table('edas');
		$crud->columns('ano', 'semana', 'sub_reg_nt', 'red', 'microred', 'e_salud', 'ubigeo');
		$crud->display_as('ano','A&ntilde;o');
		
		$semana = date('W')-2;
		
		switch($this->session->userdata('nivel')){
			case 4:
			$accesar = $this->session->userdata('equipo');
			$crud->where(array('ano'=>date('Y'), 'semana >'=>$semana));
			break;
			case 5:
			$accesar = $this->session->userdata('diresa');
			$crud->where(array('ano'=>date('Y'), 'semana >'=>$semana, 'sub_reg_nt'=>$accesar));
			break;
			case 6:
			$accesar = $this->session->userdata('diresa');
			$accesar1 = $this->session->userdata('red');
			$crud->where(array('ano'=>date('Y'), 'semana >'=>$semana, 'sub_reg_nt' => $accesar, 'red' => $accesar1));
			break;
			case 7:
			$accesar = $this->session->userdata('diresa');
			$accesar1 = $this->session->userdata('red');
			$accesar2 = $this->session->userdata('microred');
			$crud->where(array('ano'=>date('Y'), 'semana >'=>$semana, 'sub_reg_nt' => $accesar, 'red' => $accesar1, 'microred' => $accesar2));
			break;
			case 8:
			$accesar = $this->session->userdata('establecimiento');
			$crud->where(array('ano'=>date('Y'), 'semana >'=>$semana, 'e_salud' => $accesar));
			break;
			default:
			$crud->where(array('ano'=>date('Y'), 'semana >'=>$semana));
		}
		
		$crud->order_by('semana', 'DESC');
				
		$crud->unset_add();
		$crud->unset_read();
		$crud->unset_edit();
		//$crud->unset_delete();
		//$crud->unset_export();
		$crud->unset_print();
		
		$crud->callback_after_delete(array($this,'log_edas_before_delete'));
		
		$output = $crud->render();

		$this->layout->view('edasCalidad.php', $output);
	}

	public function edasDuplicados(){
		if(empty($this->session_id)){
			redirect(site_url("backend/index/login"), 301);
		}
		
		$this->calidad_model->edasDuplicados();

		$crud = new grocery_CRUD();
		$crud->set_table('edasDuplicado');
		$crud->columns('ano','semana','sub_reg_nt','red','microred','e_salud','ubigeo',
					  'daa_c1','daa_c1_4','daa_c5','daa_d1','daa_d1_4','daa_d5','daa_h1','daa_h1_4','daa_h5',
					  'dis_c1','dis_c1_4','dis_c5','dis_d1','dis_d1_4','dis_d5','dis_h1','dis_h1_4','dis_h5',
					  'etniaproc','etnias','procede','otroproc');
		$crud->display_as('ano','A&ntilde;o');
		
		switch($this->session->userdata('nivel')){
			case 4:
			$accesar = $this->session->userdata('equipo');
			break;
			case 5:
			$accesar = $this->session->userdata('diresa');
			$crud->or_where(array('sub_reg_nt' => $accesar));
			break;
			case 6:
			$accesar = $this->session->userdata('diresa');
			$accesar1 = $this->session->userdata('red');
			$crud->where(array('sub_reg_nt' => $accesar, 'red' => $accesar1));
			break;
			case 7:
			$accesar = $this->session->userdata('diresa');
			$accesar1 = $this->session->userdata('red');
			$accesar2 = $this->session->userdata('microred');
			$crud->where(array('sub_reg_nt' => $accesar, 'red' => $accesar1, 'microred' => $accesar2));
			break;
			case 8:
			$accesar = $this->session->userdata('establecimiento');
			$crud->where(array('e_salud' => $accesar));
			break;
		}
		
		$crud->order_by('semana');
				
		$crud->unset_add();
		$crud->unset_read();
		$crud->unset_edit();
		//$crud->unset_delete();
		//$crud->unset_export();
		$crud->unset_print();
		
		//$crud->add_action('Eliminar', base_url().'assets/images/close.png', 'calidad/eliminarRegistro','borrar-icon');
		
		$crud->callback_after_delete(array($this,'log_edas_after_delete'));
		
		$output = $crud->render();

		$this->layout->view('edasDuplicados.php', $output);
	}

	public function edasSemanas(){
		if(empty($this->session_id)){
			redirect(site_url("backend/index/login"), 301);
		}
		
		//$this->calidad_model->edasSemanas();
		
		$semana = date("W") - 2;
		
		$where = array('semana > '=>$semana);

		$crud = new grocery_CRUD();
		$crud->set_table('edas');
		$crud->columns('ano','semana','sub_reg_nt','red','microred','e_salud','ubigeo',
					  'daa_c1','daa_c1_4','daa_c5','daa_d1','daa_d1_4','daa_d5','daa_h1','daa_h1_4','daa_h5',
					  'dis_c1','dis_c1_4','dis_c5','dis_d1','dis_d1_4','dis_d5','dis_h1','dis_h1_4','dis_h5',
					  'etniaproc','etnias','procede','otroproc');
		$crud->display_as('ano','A&ntilde;o');
		
		$crud->where($where);
		
		switch($this->session->userdata('nivel')){
			case 4:
			$accesar = $this->session->userdata('equipo');
			break;
			case 5:
			$accesar = $this->session->userdata('diresa');
			$crud->or_where(array('sub_reg_nt' => $accesar));
			break;
			case 6:
			$accesar = $this->session->userdata('diresa');
			$accesar1 = $this->session->userdata('red');
			$crud->where(array('sub_reg_nt' => $accesar, 'red' => $accesar1));
			break;
			case 7:
			$accesar = $this->session->userdata('diresa');
			$accesar1 = $this->session->userdata('red');
			$accesar2 = $this->session->userdata('microred');
			$crud->where(array('sub_reg_nt' => $accesar, 'red' => $accesar1, 'microred' => $accesar2));
			break;
			case 8:
			$accesar = $this->session->userdata('establecimiento');
			$crud->where(array('e_salud' => $accesar));
			break;
		}
		
		$crud->order_by('semana');
				
		$crud->unset_add();
		$crud->unset_read();
		$crud->unset_edit();
		//$crud->unset_delete();
		//$crud->unset_export();
		$crud->unset_print();
		
		//$crud->add_action('Eliminar', base_url().'assets/images/close.png', 'calidad/eliminarRegistro','borrar-icon');
		
		//$crud->callback_after_delete(array($this,'log_edas_after_delete'));
		
		$output = $crud->render();

		$this->layout->view('edasSemanas.php', $output);
	}

	public function edasEstablecimientos(){
		if(empty($this->session_id)){
			redirect(site_url("backend/index/login"), 301);
		}
		
		$this->calidad_model->edasEstablecimientos();
		
		$crud = new grocery_CRUD();
		$crud->set_table('edasCalidad');
		$crud->columns('ano','semana','sub_reg_nt','red','microred','e_salud','ubigeo',
					  'daa_c1','daa_c1_4','daa_c5','daa_d1','daa_d1_4','daa_d5','daa_h1','daa_h1_4','daa_h5',
					  'dis_c1','dis_c1_4','dis_c5','dis_d1','dis_d1_4','dis_d5','dis_h1','dis_h1_4','dis_h5');
		$crud->display_as('ano','A&ntilde;o');
		
		switch($this->session->userdata('nivel')){
			case 4:
			$accesar = $this->session->userdata('equipo');
			break;
			case 5:
			$accesar = $this->session->userdata('diresa');
			$crud->or_where(array('sub_reg_nt' => $accesar));
			break;
			case 6:
			$accesar = $this->session->userdata('diresa');
			$accesar1 = $this->session->userdata('red');
			$crud->where(array('sub_reg_nt' => $accesar, 'red' => $accesar1));
			break;
			case 7:
			$accesar = $this->session->userdata('diresa');
			$accesar1 = $this->session->userdata('red');
			$accesar2 = $this->session->userdata('microred');
			$crud->where(array('sub_reg_nt' => $accesar, 'red' => $accesar1, 'microred' => $accesar2));
			break;
			case 8:
			$accesar = $this->session->userdata('establecimiento');
			$crud->where(array('e_salud' => $accesar));
			break;
		}
		
		$crud->order_by('semana');
				
		$crud->unset_add();
		$crud->unset_read();
		$crud->unset_edit();
		$crud->unset_delete();
		//$crud->unset_export();
		$crud->unset_print();
		
		//$crud->callback_after_delete(array($this,'log_registro_after_delete'));
		
		$output = $crud->render();

		$this->layout->view('edasEstablecimientos.php', $output);
	}

	public function edasDefunciones(){
		if(empty($this->session_id)){
			redirect(site_url("backend/index/login"), 301);
		}
		
		$this->calidad_model->edasDefunciones();
		
		$crud = new grocery_CRUD();
		$crud->set_table('edasDefunciones');
		$crud->columns('ano','semana','sub_reg_nt','red','microred','e_salud','ubigeo',
					  'daa_c1','daa_c1_4','daa_c5','daa_d1','daa_d1_4','daa_d5','daa_h1','daa_h1_4','daa_h5',
					  'dis_c1','dis_c1_4','dis_c5','dis_d1','dis_d1_4','dis_d5','dis_h1','dis_h1_4','dis_h5');
		$crud->display_as('ano','A&ntilde;o');
		
		switch($this->session->userdata('nivel')){
			case 4:
			$accesar = $this->session->userdata('equipo');
			break;
			case 5:
			$accesar = $this->session->userdata('diresa');
			$crud->or_where(array('sub_reg_nt' => $accesar));
			break;
			case 6:
			$accesar = $this->session->userdata('diresa');
			$accesar1 = $this->session->userdata('red');
			$crud->where(array('sub_reg_nt' => $accesar, 'red' => $accesar1));
			break;
			case 7:
			$accesar = $this->session->userdata('diresa');
			$accesar1 = $this->session->userdata('red');
			$accesar2 = $this->session->userdata('microred');
			$crud->where(array('sub_reg_nt' => $accesar, 'red' => $accesar1, 'microred' => $accesar2));
			break;
			case 8:
			$accesar = $this->session->userdata('establecimiento');
			$crud->where(array('e_salud' => $accesar));
			break;
		}
		
		$crud->order_by('semana');
				
		$crud->unset_add();
		$crud->unset_read();
		$crud->unset_edit();
		//$crud->unset_delete();
		//$crud->unset_export();
		$crud->unset_print();
		
		$crud->add_action('Editar', '', 'backend/calidad/modEdas','edit-icon');
		$crud->callback_after_delete(array($this,'log_edas_registro_after_delete'));
		
		$output = $crud->render();

		$this->layout->view('edasDefunciones.php', $output);
	}

	public function edasCampos(){
		if(empty($this->session_id)){
			redirect(site_url("backend/index/login"), 301);
		}
		
		$this->calidad_model->edasCampos();
		
		$crud = new grocery_CRUD();
		$crud->set_table('edasDefunciones');
		$crud->columns('ano','semana','sub_reg_nt','red','microred','e_salud','ubigeo',
					  'daa_c1','daa_c1_4','daa_c5','daa_d1','daa_d1_4','daa_d5','daa_h1','daa_h1_4','daa_h5',
					  'dis_c1','dis_c1_4','dis_c5','dis_d1','dis_d1_4','dis_d5','dis_h1','dis_h1_4','dis_h5');
		$crud->display_as('ano','A&ntilde;o');
		
		switch($this->session->userdata('nivel')){
			case 4:
			$accesar = $this->session->userdata('equipo');
			break;
			case 5:
			$accesar = $this->session->userdata('diresa');
			$crud->or_where(array('sub_reg_nt' => $accesar));
			break;
			case 6:
			$accesar = $this->session->userdata('diresa');
			$accesar1 = $this->session->userdata('red');
			$crud->where(array('sub_reg_nt' => $accesar, 'red' => $accesar1));
			break;
			case 7:
			$accesar = $this->session->userdata('diresa');
			$accesar1 = $this->session->userdata('red');
			$accesar2 = $this->session->userdata('microred');
			$crud->where(array('sub_reg_nt' => $accesar, 'red' => $accesar1, 'microred' => $accesar2));
			break;
			case 8:
			$accesar = $this->session->userdata('establecimiento');
			$crud->where(array('e_salud' => $accesar));
			break;
		}
		
		$crud->order_by('semana');
				
		$crud->unset_add();
		$crud->unset_read();
		$crud->unset_edit();
		//$crud->unset_delete();
		//$crud->unset_export();
		$crud->unset_print();
		
		$crud->add_action('Editar', '', 'backend/calidad/modEdas','edit-icon');
		$crud->callback_after_delete(array($this,'log_edas_registro_after_delete'));
		
		$output = $crud->render();

		$this->layout->view('edasCampos.php', $output);
	}

	//Modificar registro de la ficha de notificación de las EDAS
    public function modEdas($id=null)
    {
		if(!$id)
		{
			show_404();
		}
		
        if($this->input->post()){
            if ($this->form_validation->run("edas/edas"))
            {
				$usuario = $this->session->userdata('usuario');
				
				$ano = $this->input->post('ano');
				
				if($this->frontend_model->buscaCierre($ano) != 0)
				{
					$this->session->set_flashdata('error', 'El cierre de base de datos para el a&ntilde;o solicitado ya ha sido realizado, No se actualiz&oacute; la informaci&oacute;n');
					redirect(site_url('edas/modEdas'), 301);
				}
			
				$clave = $this->input->post('ano').
				$this->input->post('semana').
				$this->input->post('establec'). 
				$this->input->post('diagno').
				$this->input->post('distrito').
				$this->input->post('etnias').
				$this->input->post('subetnias');
				
				$data = array('ano' => $this->input->post('ano'),
					'semana' => $this->input->post('semana'),
					'sub_reg_nt' => $this->input->post('diresa'),
					'red' => $this->input->post('redes'),
					'microred' => $this->input->post('microred'),
					'e_salud' => $this->input->post('establec'),
					'ubigeo' => $this->input->post('distrito'),
					'daa_c1' => $this->input->post('daa_c1'),
					'daa_c1_4' => $this->input->post('daa_c1_4'),
					'daa_c5' => $this->input->post('daa_c5'),
					'daa_d1' => $this->input->post('daa_d1'),
					'daa_d1_4' => $this->input->post('daa_d1_4'),
					'daa_d5' => $this->input->post('daa_d5'),
					'daa_h1' => $this->input->post('daa_h1'),
					'daa_h1_4' => $this->input->post('daa_h1_4'),
					'daa_h5' => $this->input->post('daa_h5'),
					'col_c1' => "",
					'col_c1_4' => "",
					'col_c5' => "",
					'col_d1' => "",
					'col_d1_4' => "",
					'col_d5' => "",
					'col_h1' => "",
					'col_h1_4' => "",
					'col_h5' => "",
					'dis_c1' => $this->input->post('dis_c1'),
					'dis_c1_4' => $this->input->post('dis_c1_4'),
					'dis_c5' => $this->input->post('dis_c5'),
					'dis_d1' => $this->input->post('dis_d1'),
					'dis_d1_4' => $this->input->post('dis_d1_4'),
					'dis_d5' => $this->input->post('dis_d5'),
					'dis_h1' => $this->input->post('dis_h1'),
					'dis_h1_4' => $this->input->post('dis_h1_4'),
					'dis_h5' => $this->input->post('dis_h5'),
					'cop_t1' => "",
					'cop_t1_4' => "",
					'cop_t5' => "",
					'cop_p1' => "",
					'cop_p1_4' => "",
					'cop_p5' => "",
					'cop_s1' => "",
					'cop_s1_4' => "",
					'cop_s5' => "",
					'fecha_ing' => date("Y-m-d"),
					'clave' => $clave,
					'migrado' => "",
					'verifica' => "",
					'etapa' => "",
					'estado' => "",
					'etniaproc' => $this->input->post('etnias'),
					'etnias' => $this->input->post('subetnias'),
					'procede' => $this->input->post('zona'),
					'otroproc' => $this->input->post('otro'),
					'usuario' => $usuario
				);
				
				$cantidad = $this->input->post("daa_c1")+$this->input->post("daa_c1_4")+$this->input->post("daa_c5")+
					$this->input->post("dis_c1")+$this->input->post("dis_c1_4")+$this->input->post("dis_c5");
					
				if($cantidad == 0){
					$this->session->set_flashdata('error', 'Debe ingresar alguna atenci&oacute;n. NO se grab&oacute; el registro');
					redirect("backend/calidad/edasDefunciones", 301);
				}
				
				$guardar = $this->frontend_model->ejecutarModificarEdas($data, $id);
						
				if($guardar)
				{
					$this->mantenimiento_model->auditoriaOperador($this->session->userdata('usuario'), 'Modificar Edas');
					$this->session->set_flashdata('exito', 'Informaci&oacute;n modificada con &eacute;xito.');
					redirect('backend/calidad/edasDefunciones', 301);
				}
			}
		}
		
		// Buscando registro a modificar
		$modificar = $this->frontend_model->modificarEdas($id);
		
		if(sizeof($modificar)==0)
		{
			show_404();
		}
		
		//combo DIRESA
		$subreg = $this->frontend_model->mostrarDiresa($modificar->sub_reg_nt);

		$diresa[''] = 'Seleccione ...';
		foreach ($subreg as $dato){
			$diresa[$dato->codigo] = $dato->nombre;
		}

		//combo Red
		$red = $this->frontend_model->buscarRedes($modificar->sub_reg_nt);
		$redes[''] = 'Seleccione ...';
		foreach ($red as $dato){
			$redes[$dato->codigo] = $dato->nombre;
		}

		//combo Microred
		$mred = $this->frontend_model->buscarMicroredes($modificar->sub_reg_nt,$modificar->red);
		$microred[''] = 'Seleccione ...';
		foreach ($mred as $dato){
			$microred[$dato->codigo] = $dato->nombre;
		}

		//combo Establecimiento
		$est = $this->frontend_model->buscarEstablec($modificar->sub_reg_nt,$modificar->red,$modificar->microred);
		$establec[''] = 'Seleccione ...';
		foreach ($est as $dato){
			$establec[$dato->cod_est] = $dato->raz_soc;
		}

		//combo Departamentos
		$depar = $this->frontend_model->buscarDepartamentos();

		$departamento[''] = 'Seleccione ...';
		foreach ($depar as $dato){
			$departamento[$dato->ubigeo] = $dato->nombre;
		}

		//combo Provincias
		$prov = $this->frontend_model->buscarProvincias(substr($modificar->ubigeo,0,2));

		$provincia[''] = 'Seleccione ...';
		foreach ($prov as $dato){
			$provincia[$dato->ubigeo] = $dato->nombre;
		}

		//combo Distritos
		$dist = $this->frontend_model->buscarDistritos(substr($modificar->ubigeo,0,4));

		$distrito[''] = 'Seleccione ...';
		foreach ($dist as $dato){
			$distrito[$dato->ubigeo] = $dato->nombre;
		}

		//combo Etnias
		$etn = $this->frontend_model->mostrarEtnias();

		$etnias[''] = 'Seleccione ...';
		foreach ($etn as $dato){
			$etnias[$dato->registroId] = $dato->nombre;
		}

		//combo Sub-Etnias
		$setn = $this->frontend_model->mostrarSubEtnias($modificar->etniaproc);

		$subetnias[''] = 'Seleccione ...';
		foreach ($setn as $dato){
			$subetnias[$dato->registroId] = $dato->nombre;
		}

		$session_id = $this->session_id;
		$grabar_id = $this->session->userdata('grabar');
		$modificar_id = $this->session->userdata('modificar');
		
		if(!empty($this->session_id)){
			$this->layout->view('modEdas', compact('session_id', 'modificar', 'diresa', 'redes', 'microred', 'establec', 'departamento', 'provincia', 'distrito', 'etnias', 'subetnias'));
        }else{
            redirect(site_url("backend/calidad/edasDefunciones"), 301);
        }
    }

	// Callback para la eliminación de registro
	public function log_edas_after_delete($primary_key)
	{
		$this->calidad_model->eliminaEdas(array('registroId'=>$primary_key));		
	}

	/* Control de Calidad para la sección de la notificación de las IRAs */
	
	public function irasCalidad(){
		if(empty($this->session_id)){
			redirect(site_url("backend/index/login"), 301);
		}
		
		$crud = new grocery_CRUD();
		$crud->set_table('iras');
		$crud->columns('ano', 'semana', 'sub_reg_nt', 'red', 'microred', 'e_salud', 'ubigeo');
		$crud->display_as('ano','A&ntilde;o');
		
		$semana = date('W')-2;
		
		switch($this->session->userdata('nivel')){
			case 4:
			$accesar = $this->session->userdata('equipo');
			$crud->where(array('ano'=>date('Y'), 'semana >'=>$semana));
			break;
			case 5:
			$accesar = $this->session->userdata('diresa');
			$crud->where(array('ano'=>date('Y'), 'semana >'=>$semana, 'sub_reg_nt'=>$accesar));
			break;
			case 6:
			$accesar = $this->session->userdata('diresa');
			$accesar1 = $this->session->userdata('red');
			$crud->where(array('ano'=>date('Y'), 'semana >'=>$semana, 'sub_reg_nt' => $accesar, 'red' => $accesar1));
			break;
			case 7:
			$accesar = $this->session->userdata('diresa');
			$accesar1 = $this->session->userdata('red');
			$accesar2 = $this->session->userdata('microred');
			$crud->where(array('ano'=>date('Y'), 'semana >'=>$semana, 'sub_reg_nt' => $accesar, 'red' => $accesar1, 'microred' => $accesar2));
			break;
			case 8:
			$accesar = $this->session->userdata('establecimiento');
			$crud->where(array('ano'=>date('Y'), 'semana >'=>$semana, 'e_salud' => $accesar));
			break;
			default:
			$crud->where(array('ano'=>date('Y'), 'semana >'=>$semana));
		}
		
		$crud->order_by('semana', 'DESC');
				
		$crud->unset_add();
		$crud->unset_read();
		$crud->unset_edit();
		//$crud->unset_delete();
		//$crud->unset_export();
		$crud->unset_print();
		
		$crud->callback_after_delete(array($this,'log_iras_before_delete'));
		
		$output = $crud->render();

		$this->layout->view('irasCalidad.php', $output);
	}

	public function irasDuplicados(){
		if(empty($this->session_id)){
			redirect(site_url("backend/index/login"), 301);
		}
		
		$this->calidad_model->irasDuplicados();

		$crud = new grocery_CRUD();
		$crud->set_table('irasDuplicado');
		$crud->columns('ano','semana','sub_reg_nt','red','microred','e_salud','ubigeo',
					  'ira_m2','ira_2_11','ira_1_4a','neu_2_11','neu_1_4a','ngr_m2','ngr_2_11','ngr_1_4a',					  'dis_c1','dis_c1_4','dis_c5','dis_d1','dis_d1_4','dis_d5','dis_h1','dis_h1_4','dis_h5',
					  'etniaproc','etnias','procede','otroproc');
		$crud->display_as('ano','A&ntilde;o');
		
		switch($this->session->userdata('nivel')){
			case 4:
			$accesar = $this->session->userdata('equipo');
			break;
			case 5:
			$accesar = $this->session->userdata('diresa');
			$crud->or_where(array('sub_reg_nt' => $accesar));
			break;
			case 6:
			$accesar = $this->session->userdata('diresa');
			$accesar1 = $this->session->userdata('red');
			$crud->where(array('sub_reg_nt' => $accesar, 'red' => $accesar1));
			break;
			case 7:
			$accesar = $this->session->userdata('diresa');
			$accesar1 = $this->session->userdata('red');
			$accesar2 = $this->session->userdata('microred');
			$crud->where(array('sub_reg_nt' => $accesar, 'red' => $accesar1, 'microred' => $accesar2));
			break;
			case 8:
			$accesar = $this->session->userdata('establecimiento');
			$crud->where(array('e_salud' => $accesar));
			break;
		}
		
		$crud->order_by('semana');
				
		$crud->unset_add();
		$crud->unset_read();
		$crud->unset_edit();
		//$crud->unset_delete();
		//$crud->unset_export();
		$crud->unset_print();
		
		//$crud->add_action('Eliminar', base_url().'assets/images/close.png', 'calidad/eliminarRegistro','borrar-icon');
		
		$crud->callback_after_delete(array($this,'log_iras_after_delete'));
		
		$output = $crud->render();

		$this->layout->view('irasDuplicados.php', $output);
	}

	public function irasSemanas(){
		if(empty($this->session_id)){
			redirect(site_url("backend/index/login"), 301);
		}
		
		//$this->calidad_model->edasSemanas();
		
		$semana = date("W") - 2;
		
		$where = array('semana > '=>$semana);

		$crud = new grocery_CRUD();
		$crud->set_table('iras');
		$crud->columns('ano','semana','sub_reg_nt','red','microred','e_salud','ubigeo',
					  'ira_m2','ira_2_11','ira_1_4a','neu_2_11','neu_1_4a','ngr_m2','ngr_2_11','ngr_1_4a',					  'dis_c1','dis_c1_4','dis_c5','dis_d1','dis_d1_4','dis_d5','dis_h1','dis_h1_4','dis_h5',
					  'etniaproc','etnias','procede','otroproc');
		$crud->display_as('ano','A&ntilde;o');
		
		$crud->where($where);
		
		switch($this->session->userdata('nivel')){
			case 4:
			$accesar = $this->session->userdata('equipo');
			break;
			case 5:
			$accesar = $this->session->userdata('diresa');
			$crud->or_where(array('sub_reg_nt' => $accesar));
			break;
			case 6:
			$accesar = $this->session->userdata('diresa');
			$accesar1 = $this->session->userdata('red');
			$crud->where(array('sub_reg_nt' => $accesar, 'red' => $accesar1));
			break;
			case 7:
			$accesar = $this->session->userdata('diresa');
			$accesar1 = $this->session->userdata('red');
			$accesar2 = $this->session->userdata('microred');
			$crud->where(array('sub_reg_nt' => $accesar, 'red' => $accesar1, 'microred' => $accesar2));
			break;
			case 8:
			$accesar = $this->session->userdata('establecimiento');
			$crud->where(array('e_salud' => $accesar));
			break;
		}
		
		$crud->order_by('semana');
				
		$crud->unset_add();
		$crud->unset_read();
		$crud->unset_edit();
		//$crud->unset_delete();
		//$crud->unset_export();
		$crud->unset_print();
		
		//$crud->add_action('Eliminar', base_url().'assets/images/close.png', 'calidad/eliminarRegistro','borrar-icon');
		
		//$crud->callback_after_delete(array($this,'log_edas_after_delete'));
		
		$output = $crud->render();

		$this->layout->view('irasSemanas.php', $output);
	}

	public function irasEstablecimientos(){
		if(empty($this->session_id)){
			redirect(site_url("backend/index/login"), 301);
		}
		
		$this->calidad_model->irasEstablecimientos();
		
		$crud = new grocery_CRUD();
		$crud->set_table('irasCalidad');
		$crud->columns('ano','semana','sub_reg_nt','red','microred','e_salud','ubigeo',
					  'ira_m2','ira_2_11','ira_1_4a','neu_2_11','neu_1_4a','ngr_m2','ngr_2_11','ngr_1_4a');
		$crud->display_as('ano','A&ntilde;o');
		
		switch($this->session->userdata('nivel')){
			case 4:
			$accesar = $this->session->userdata('equipo');
			break;
			case 5:
			$accesar = $this->session->userdata('diresa');
			$crud->or_where(array('sub_reg_nt' => $accesar));
			break;
			case 6:
			$accesar = $this->session->userdata('diresa');
			$accesar1 = $this->session->userdata('red');
			$crud->where(array('sub_reg_nt' => $accesar, 'red' => $accesar1));
			break;
			case 7:
			$accesar = $this->session->userdata('diresa');
			$accesar1 = $this->session->userdata('red');
			$accesar2 = $this->session->userdata('microred');
			$crud->where(array('sub_reg_nt' => $accesar, 'red' => $accesar1, 'microred' => $accesar2));
			break;
			case 8:
			$accesar = $this->session->userdata('establecimiento');
			$crud->where(array('e_salud' => $accesar));
			break;
		}
		
		$crud->order_by('semana');
				
		$crud->unset_add();
		$crud->unset_read();
		$crud->unset_edit();
		$crud->unset_delete();
		//$crud->unset_export();
		$crud->unset_print();
		
		//$crud->callback_after_delete(array($this,'log_registro_after_delete'));
		
		$output = $crud->render();

		$this->layout->view('irasEstablecimientos.php', $output);
	}

	public function irasDefunciones(){
		if(empty($this->session_id)){
			redirect(site_url("backend/index/login"), 301);
		}
		
		$this->calidad_model->irasDefunciones();
		
		$crud = new grocery_CRUD();
		$crud->set_table('irasDefunciones');
		$crud->columns('ano','semana','sub_reg_nt','red','microred','e_salud','ubigeo',
					  'neu_2_11','neu_1_4a','ngr_m2','ngr_2_11','ngr_1_4a','dih_m2',
					  'dih_2_11','dih_1_4a','deh_m2','deh_2_11','deh_1_4a');
		$crud->display_as('ano','A&ntilde;o');

		
		switch($this->session->userdata('nivel')){
			case 4:
			$accesar = $this->session->userdata('equipo');
			break;
			case 5:
			$accesar = $this->session->userdata('diresa');
			$crud->or_where(array('sub_reg_nt' => $accesar));
			break;
			case 6:
			$accesar = $this->session->userdata('diresa');
			$accesar1 = $this->session->userdata('red');
			$crud->where(array('sub_reg_nt' => $accesar, 'red' => $accesar1));
			break;
			case 7:
			$accesar = $this->session->userdata('diresa');
			$accesar1 = $this->session->userdata('red');
			$accesar2 = $this->session->userdata('microred');
			$crud->where(array('sub_reg_nt' => $accesar, 'red' => $accesar1, 'microred' => $accesar2));
			break;
			case 8:
			$accesar = $this->session->userdata('establecimiento');
			$crud->where(array('e_salud' => $accesar));
			break;
		}
		
		$crud->order_by('semana');
				
		$crud->unset_add();
		$crud->unset_read();
		$crud->unset_edit();
		//$crud->unset_delete();
		//$crud->unset_export();
		$crud->unset_print();
		
		$crud->add_action('Editar', '', 'backend/calidad/modIras','edit-icon');
		$crud->callback_after_delete(array($this,'log_iras_registro_after_delete'));
		
		$output = $crud->render();

		$this->layout->view('irasDefunciones.php', $output);
	}

	public function irasCampos(){
		if(empty($this->session_id)){
			redirect(site_url("backend/index/login"), 301);
		}
		
		$this->calidad_model->edasCampos();
		
		$crud = new grocery_CRUD();
		$crud->set_table('irasDefunciones');
		$crud->columns('ano','semana','sub_reg_nt','red','microred','e_salud','ubigeo',
					  'ira_m2','ira_2_11','ira_1_4a','neu_2_11','neu_1_4a','ngr_m2','ngr_2_11','ngr_1_4a');
		$crud->display_as('ano','A&ntilde;o');
		
		switch($this->session->userdata('nivel')){
			case 4:
			$accesar = $this->session->userdata('equipo');
			break;
			case 5:
			$accesar = $this->session->userdata('diresa');
			$crud->or_where(array('sub_reg_nt' => $accesar));
			break;
			case 6:
			$accesar = $this->session->userdata('diresa');
			$accesar1 = $this->session->userdata('red');
			$crud->where(array('sub_reg_nt' => $accesar, 'red' => $accesar1));
			break;
			case 7:
			$accesar = $this->session->userdata('diresa');
			$accesar1 = $this->session->userdata('red');
			$accesar2 = $this->session->userdata('microred');
			$crud->where(array('sub_reg_nt' => $accesar, 'red' => $accesar1, 'microred' => $accesar2));
			break;
			case 8:
			$accesar = $this->session->userdata('establecimiento');
			$crud->where(array('e_salud' => $accesar));
			break;
		}
		
		$crud->order_by('semana');
				
		$crud->unset_add();
		$crud->unset_read();
		$crud->unset_edit();
		//$crud->unset_delete();
		//$crud->unset_export();
		$crud->unset_print();
		
		$crud->add_action('Editar', '', 'backend/calidad/modIras','edit-icon');
		$crud->callback_after_delete(array($this,'log_iras_registro_after_delete'));
		
		$output = $crud->render();

		$this->layout->view('irasCampos.php', $output);
	}

	//Modificar registro de la ficha de notificación de las IRAS
    public function modIras($id=null)
    {
		if(!$id)
		{
			show_404();
		}
		
        if($this->input->post()){
            if ($this->form_validation->run("iras/iras"))
            {
				$usuario = $this->session->userdata('usuario');
				
				$ano = $this->input->post('ano');
				
				if($this->frontend_model->buscaCierre($ano) != 0)
				{
					$this->session->set_flashdata('error', 'El cierre de base de datos para el a&ntilde;o solicitado ya ha sido realizado, No se grab&oacute; la informaci&oacute;n');
					redirect(site_url('iras/modIras'), 301);
				}
			
				$clave = $this->input->post('ano').
				$this->input->post('semana').
				$this->input->post('establec'). 
				$this->input->post('diagno').
				$this->input->post('distrito').
				$this->input->post('etnias').
				$this->input->post('subetnias');
				
				$data = array('ano' => $this->input->post('ano'),
					'semana' => $this->input->post('semana'),
					'sub_reg_nt' => $this->input->post('diresa'),
					'red' => $this->input->post('redes'),
					'microred' => $this->input->post('microred'),
					'e_salud' => $this->input->post('establec'),
					'ubigeo' => $this->input->post('distrito'),
					'ira_m2' => $this->input->post('ira_m2'),
					'ira_2_11' => $this->input->post('ira_2_11'),
					'ira_1_4a' => $this->input->post('ira_1_4a'),
					'neu_2_11' => $this->input->post('neu_2_11'),
					'neu_1_4a' => $this->input->post('neu_1_4a'),
					'hos_m2' => $this->input->post('hos_m2'),
					'hos_2_11' => $this->input->post('hos_2_11'),
					'hos_1_4a' => $this->input->post('hos_1_4a'),
					'ngr_m2' => $this->input->post('ngr_m2'),
					'ngr_2_11' => $this->input->post('ngr_2_11'),
					'ngr_1_4a' => $this->input->post('ngr_1_4a'),
					'dih_m2' => $this->input->post('dih_m2'),
					'dih_2_11' => $this->input->post('dih_2_11'),
					'dih_1_4a' => $this->input->post('dih_1_4a'),
					'deh_m2' => $this->input->post('deh_m2'),
					'deh_2_11' => $this->input->post('deh_2_11'),
					'deh_1_4a' => $this->input->post('deh_1_4a'),
					'sob_2a' => $this->input->post('sob_2a'),
					'sob_2_4a' => $this->input->post('sob_2_4a'),
					'fecha_ing' => date("Y-m-d"),
					'clave' => $clave,
					'migrado' => "",
					'verifica' => "",
					'etapa' => "",
					'ira_5_9a' => $this->input->post('ira_5_9a'),
					'ira_60a' => $this->input->post('ira_60a'),
					'neu_5_9a' => $this->input->post('neu_5_9a'),
					'neu_60a' => $this->input->post('neu_60a'),
					'hos_5_9a' => $this->input->post('hos_5_9a'),
					'hos_60a' => $this->input->post('hos_60a'),
					'ngr_5_9a' => $this->input->post('ngr_5_9a'),
					'ngr_60a' => $this->input->post('ngr_60a'),
					'dih_5_9a' => $this->input->post('dih_5_9a'),
					'dih_60a' => $this->input->post('dih_60a'),
					'deh_5_9a' => $this->input->post('deh_5_9a'),
					'deh_60a' => $this->input->post('deh_60a'),
					'sob_5_9a' => $this->input->post('sob_5_9a'),
					'sob_60a' => $this->input->post('sob_60a'),
					'estado' => "",
					'localcod' => "",
					'neu_10_19' => $this->input->post('neu_10_19'),
					'neu_20_59' => $this->input->post('neu_20_59'),
					'hos_10_19' => $this->input->post('hos_10_19'),
					'hos_20_59' => $this->input->post('hos_20_59'),
					'dih_10_19' => $this->input->post('dih_10_19'),
					'dih_20_59' => $this->input->post('dih_20_59'),
					'deh_10_19' => $this->input->post('deh_10_19'),
					'deh_20_59' => $this->input->post('deh_20_59'),
					'etniaproc' => $this->input->post('etnias'),
					'etnias' => $this->input->post('subetnias'),
					'procede' => $this->input->post('zona'),
					'otroproc' => $this->input->post('otro'),
					'usuario' => $usuario
				);
				
				$cantidad = $this->input->post("ira_m2")+$this->input->post("ira_2_11")+$this->input->post("ira_1_4a")+
					$this->input->post("neu_2_11")+$this->input->post("neu_1_4a")+
					$this->input->post("ngr_m2")+$this->input->post("ngr_2_11")+$this->input->post("ngr_1_4a")+
					$this->input->post("sob_2a")+$this->input->post("sob_2_4a")+
					$this->input->post("sob_5_9a")+$this->input->post("sob_60a")+
					$this->input->post("ira_5_9a")+$this->input->post("ira_60a")+
					$this->input->post("neu_5_9a")+$this->input->post("neu_60a")+
					$this->input->post("ngr_5_9a")+$this->input->post("ngr_60a")+
					$this->input->post("neu_10_19")+$this->input->post("neu_20_59");
					
				if($cantidad == 0){
					$this->session->set_flashdata('error', 'Debe ingresar alguna atenci&oacute;n. NO se grab&oacute; el registro');
					redirect("baqckend/calidad/irasDefunciones", 301);
				}
				
				$guardar = $this->frontend_model->ejecutarModificarIras($data, $id);
					
				if($guardar)
				{
					$this->mantenimiento_model->auditoriaOperador($this->session->userdata('usuario'), 'Modificar Iras');
					$this->session->set_flashdata('exito', 'Informaci&oacute;n modificada con &eacute;xito.');
					redirect('backend/calidad/irasDefunciones', 301);
				}
			}
		}
		
		// Buscando registro a modificar
		$modificar = $this->frontend_model->modificarIras($id);
		
		if(sizeof($modificar)==0)
		{
			show_404();
		}
		
		//combo DIRESA
		$subreg = $this->frontend_model->mostrarDiresa($modificar->sub_reg_nt);

		$diresa[''] = 'Seleccione ...';
		foreach ($subreg as $dato){
			$diresa[$dato->codigo] = $dato->nombre;
		}

		//combo Red
		$red = $this->frontend_model->buscarRedes($modificar->sub_reg_nt);
		$redes[''] = 'Seleccione ...';
		foreach ($red as $dato){
			$redes[$dato->codigo] = $dato->nombre;
		}

		//combo Microred
		$mred = $this->frontend_model->buscarMicroredes($modificar->sub_reg_nt,$modificar->red);
		$microred[''] = 'Seleccione ...';
		foreach ($mred as $dato){
			$microred[$dato->codigo] = $dato->nombre;
		}

		//combo Establecimiento
		$est = $this->frontend_model->buscarEstablec($modificar->sub_reg_nt,$modificar->red,$modificar->microred);
		$establec[''] = 'Seleccione ...';
		foreach ($est as $dato){
			$establec[$dato->cod_est] = $dato->raz_soc;
		}

		//combo Departamentos
		$depar = $this->frontend_model->buscarDepartamentos();

		$departamento[''] = 'Seleccione ...';
		foreach ($depar as $dato){
			$departamento[$dato->ubigeo] = $dato->nombre;
		}

		//combo Provincias
		$prov = $this->frontend_model->buscarProvincias(substr($modificar->ubigeo,0,2));

		$provincia[''] = 'Seleccione ...';
		foreach ($prov as $dato){
			$provincia[$dato->ubigeo] = $dato->nombre;
		}

		//combo Distritos
		$dist = $this->frontend_model->buscarDistritos(substr($modificar->ubigeo,0,4));

		$distrito[''] = 'Seleccione ...';
		foreach ($dist as $dato){
			$distrito[$dato->ubigeo] = $dato->nombre;
		}

		//combo Etnias
		$etn = $this->frontend_model->mostrarEtnias();

		$etnias[''] = 'Seleccione ...';
		foreach ($etn as $dato){
			$etnias[$dato->registroId] = $dato->nombre;
		}

		//combo Sub-Etnias
		$setn = $this->frontend_model->mostrarSubEtnias($modificar->etniaproc);

		$subetnias[''] = 'Seleccione ...';
		foreach ($setn as $dato){
			$subetnias[$dato->registroId] = $dato->nombre;
		}

		$session_id = $this->session_id;
		$grabar_id = $this->session->userdata('grabar');
		$modificar_id = $this->session->userdata('modificar');
		
		if(!empty($this->session_id)){
			$this->layout->view('modIras', compact('session_id', 'modificar', 'diresa', 'redes', 'microred', 'establec', 'departamento', 'provincia', 'distrito', 'etnias', 'subetnias'));
        }else{

            redirect(site_url("backend/calidad/irasDefunciones"), 301);
        }
    }

	// Callback para la eliminación de registro
	public function log_iras_after_delete($primary_key)
	{
		$this->calidad_model->eliminaIras(array('registroId'=>$primary_key));		
	}
}