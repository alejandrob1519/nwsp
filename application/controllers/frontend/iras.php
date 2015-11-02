<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Iras extends CI_Controller {
    
    private $session_id;

	public function __construct()
    {
        parent::__construct();
        $this->layout->setLayout('template4');
        $this->layout->setTitle(":: NotiWeb :: Vigilancia Epidemiol&oacute;gica");
        $this->session_id = $this->session->userdata('usuario');
		date_default_timezone_set('America/Lima');
	}

    public function _example_output1($output = null)
    {
		$this->layout->view('listadoIras.php',$output);
    }

	public function index()
    {
		$this->_example_output1((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
	}
	
	// Listar registros de IRAS
	public function listadoIras()
	{
		$sub = $this->frontend_model->buscarDiresas();

		$subr = array();
		
		foreach($sub as $dato)
		{
			$subr[$dato->codigo] = $dato->nombre;
		}

		$dist = $this->frontend_model->listarDistritos();

		$ubigeo = array();
		
		foreach($dist as $dato)
		{
			$ubigeo[$dato->ubigeo] = $dato->nombre;
		}

		$est = $this->frontend_model->listaEstablec();

		$establec = array();
		
		foreach($est as $dato)
		{
			$establec[$dato->cod_est] = $dato->raz_soc;
		}

		$filtro = array();
		
		(($this->input->post('diresa')) ? $filtro['sub_reg_nt'] = $this->input->post('diresa') : '');
		(($this->input->post('redes')) ? $filtro['red'] = $this->input->post('redes') : '');
		(($this->input->post('microred')) ? $filtro['microred'] = $this->input->post('microred') : '');
		(($this->input->post('establec')) ? $filtro['e_salud'] = $this->input->post('establec') : '');
		(($this->input->post('departamento')) ? $filtro['substr(ubigeo,1,2)'] = $this->input->post('departamento') : '' );
		(($this->input->post('provincia')) ? $filtro['substr(ubigeo,1,4)'] = $this->input->post('provincia') : '' );
		(($this->input->post('distrito')) ? $filtro['ubigeo'] = $this->input->post('distrito') : '' );
		(($this->input->post('ano')) ? $filtro['ano'] = $this->input->post('ano') : '' );
		(($this->input->post('semana')) ? $filtro['semana'] = $this->input->post('semana') : '' );
		
		$crud = new grocery_CRUD();
		$crud->set_theme("datatables");
		$crud->set_table('iras');
		$crud->columns('ano', 'semana', 'sub_reg_nt', 'e_salud', 'ubigeo', 'ira_m2', 'ira_2_11', 'ira_1_4a', 'neu_2_11', 'neu_1_4a', 'ngr_m2', 'ngr_2_11', 'ngr_1_4a');
		$crud->display_as('ano','A&ntilde;o')
			->display_as('e_salud','Establecimiento')
			->display_as('sub_reg_nt','Diresa');
		$crud->field_type('sub_reg_nt','dropdown',$subr);         
		$crud->field_type('e_salud','dropdown',$establec);         
		$crud->field_type('ubigeo','dropdown',$ubigeo);         

		if($this->input->post()){
			if($this->session->userdata('institucion') == 'A'){
				$crud->where($filtro);
			}else{
				$crud->where($filtro);
				$crud->where(array('substr(e_salud,7,1)' => $this->session->userdata('institucion')));
			}
		}else{
			$crud->where(array('ano'=>date('Y')));
		
			switch($this->session->userdata('nivel')){
				case 4:
				$accesar = $this->session->userdata('equipo');

				if($this->session->userdata('institucion') <> 'A'){
					$crud->where(array('substr(e_salud,7,1)' => $this->session->userdata('institucion')));
				}
				
				break;
				case 5:
				$accesar = $this->session->userdata('diresa');
				
				if($this->session->userdata('institucion') != 'A'){
					$crud->where(array('substr(e_salud,7,1)' => $this->session->userdata('institucion'), 'sub_reg_nt' => $accesar));
				}else{
					$crud->where(array('sub_reg_nt' => $accesar));
				}
				
				break;
				case 6:
				$accesar = $this->session->userdata('diresa');
				$accesar1 = $this->session->userdata('red');
				
				if($this->session->userdata('institucion') != 'A'){
					$crud->where(array('substr(e_salud,7,1)' => $this->session->userdata('institucion'), 'sub_reg_nt' => $accesar, 'red' => $accesar1));
				}else{
					$crud->where(array('sub_reg_nt' => $accesar, 'red' => $accesar1));
				}
				
				break;
				case 7:
				$accesar = $this->session->userdata('diresa');
				$accesar1 = $this->session->userdata('red');
				$accesar2 = $this->session->userdata('microred');
				
				if($this->session->userdata('institucion') != 'A'){
					$crud->where(array('substr(e_salud,7,1)' => $this->session->userdata('institucion'), 'sub_reg_nt' => $accesar, 'red' => $accesar1, 'microred' => $accesar2));
				}else{
					$crud->where(array('sub_reg_nt' => $accesar, 'red' => $accesar1, 'microred' => $accesar2));
				}
				
				break;
				case 8:
				$accesar = $this->session->userdata('establecimiento');
				$crud->where(array('e_salud' => $accesar));
				break;
			}
		}
		
		$crud->limit(1000);
		$crud->order_by('semana', 'DESC');
		$crud->set_subject('Atenciones');
				
		$crud->unset_add();
		$crud->unset_read();
		$crud->unset_edit();
		$crud->unset_export();
		$crud->unset_print();

		$crud->callback_after_delete(array($this,'log_usuario_before_delete'));
		
		$crud->add_action('Editar', '', 'iras/modIras','ui-icon-pencil');
		///////////////////////////////////////////////////////////////////////////////
		//$crud->add_action_peru('A&ntilde;adir IRAS', '', 'regIras','add-icon');
		///////////////////////////////////////////////////////////////////////////////

		$output = $crud->render();
		
		$this->_example_output1($output);
	}
	
	//Registro de la ficha de IRAS
    public function regIras()
    {
        if($this->input->post()){
            if ($this->form_validation->run("iras/iras"))
            {
				$usuario = $this->session->userdata('usuario');
				
				$ano = $this->input->post('ano');
				
				if($this->frontend_model->buscaCierre($ano) != 0)
				{
					$this->session->set_flashdata('error', 'El cierre de base de datos para el a&ntilde;o solicitado ya ha sido realizado, No se grab&oacute; la informaci&oacute;n');
					redirect(site_url('iras/regIras'), 301);
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
					$this->session->set_flashdata('error', 'Error: Debe ingresar alguna atenci&oacute;n. NO se grab&oacute; el registro.');
					redirect("iras/regIras", 301);
				}

				if($this->session->userdata('grabar') == '1'){
					
					$guardar = $this->frontend_model->insertarIras($data);

					if($guardar)
					{
						$this->mantenimiento_model->auditoriaOperador($this->session->userdata('usuario'), 'Registro Iras');
						$this->session->set_flashdata('exito', 'Informaci&oacute;n guardada con &eacute;xito.');
						redirect('iras/regIras', 301);
					}
				}else{
					$this->session->set_flashdata('error', 'Error: Usted no cuenta con autorizaci&oacute;n para grabar registros. NO se grab&oacute; la informaci&oacute;n ingresada.');
					redirect('index/principal', 301);
				}
			}
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
		
		//combo Etnias
		
		$etn = $this->frontend_model->mostrarEtnias();

		$etnias[''] = 'Seleccione ...';
		foreach ($etn as $dato){
			$etnias[$dato->registroId] = $dato->nombre;
		}

		//combo Sub-Etnias
		
		if($this->input->post('etnias') != ''){
			$setn = $this->frontend_model->mostrarSubEtnias($this->input->post('etnias'));
	
			$subetnias[''] = 'Seleccione ...';
			foreach ($setn as $dato){
				$subetnias[$dato->registroId] = $dato->nombre;
			}
		}
		
		$session_id = $this->session_id;
		$grabar_id = $this->session->userdata('grabar');
		
		if($this->session->userdata('nivel') == '1' or $this->session->userdata('nivel') == '4')
		{
            redirect(site_url("iras/listadoIras"), 301);
		}
		
		if(!empty($this->session_id)){
			if($grabar_id != '1'){
				$this->session->set_flashdata('errorFrontend', 'Error: Usted no cuenta con autorizaci&oacute;n para grabar registros.');
				redirect(site_url("index/principal"), 301);
			}
			$this->layout->view('regIras', compact('session_id', 'diresa', 'redes', 'microred', 'establec', 'departamento', 'provincia', 'distrito', 'etnias', 'subetnias'));
        }else{
            redirect(site_url("index/login"), 301);
        }
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
					redirect("iras/listadoIras", 301);
				}
				
				if($this->session->userdata('grabar') == '1' and $this->session->userdata('modificar') == '1'){
					
					$guardar = $this->frontend_model->ejecutarModificarIras($data, $id);
						
					if($guardar)
					{
						$this->mantenimiento_model->auditoriaOperador($this->session->userdata('usuario'), 'Modificar Iras');
						$this->session->set_flashdata('exito', 'Informaci&oacute;n modificada con &eacute;xito.');
						redirect('iras/listadoIras', 301);
					}
				}else{
					$this->session->set_flashdata('error', 'Error: Usted no cuenta con autorizaci&oacute;n para grabar &oacute; modificar registros. NO se modific&oacute; la informaci&oacute;n corregida.');
					redirect('index/principal', 301);
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
			if($grabar_id != '1' or $modificar_id != '1'){
				$this->session->set_flashdata('error', 'Error: Usted no cuenta con autorizaci&oacute;n para grabar &oacute; modificar registros.');
	            redirect(site_url("iras/listadoIras"), 301);
			}
			$this->layout->view('modIras', compact('session_id', 'modificar', 'diresa', 'redes', 'microred', 'establec', 'departamento', 'provincia', 'distrito', 'etnias', 'subetnias'));
        }else{
            redirect(site_url("index/login"), 301);
        }
    }

    //validar duplicado
	public function validaDuplicado()
	{
		$ano = $this->input->post('ano');
		$semana = $this->input->post('semana');
		$e_salud = $this->input->post('establec');
		$ubigeo = $this->input->post('distrito');
		$etnia = $this->input->post('etnias');
		$subetnia = $this->input->post('subetnias');

		$filtro = $this->frontend_model->validaDuplicadoIras($ano, $semana, $e_salud, $ubigeo, $etnia, $subetnia);
		
		$data = array();
		
		foreach($filtro as $dato)
		{
			$data['ira'] = $dato->registroId;
		}
		
		echo json_encode($data);
	}

    //Llena el combo redes
	public function llenaRedes()
	{
		$filtro = $this->input->get('diresa');
		foreach ($this->mantenimiento_model->buscarRedes($filtro) as $red) {
			$redes[$red->codigo] = $red->nombre;
		}
		echo json_encode($redes);
	}

    //Llena el combo redes
	public function llenaMicroredes()
	{
		$filtro1 = $this->input->get('diresa');
		$filtro2 = $this->input->get('redes');
										   
		foreach ($this->mantenimiento_model->buscarMicroredes($filtro1, $filtro2) as $mred) {
			$microred[$mred->codigo] = $mred->nombre;
		}
		
		echo json_encode($microred);
	}

    //Llena el combo establecimientos
	public function llenaEstablec()
	{
		$filtro1 = $this->input->get('diresa');
		$filtro2 = $this->input->get('redes');
		$filtro3 = $this->input->get('microred');
										   
		foreach ($this->mantenimiento_model->buscarEstablec($filtro1, $filtro2, $filtro3) as $est) {
			$establec[$est->cod_est] = $est->raz_soc;
		}
		
		echo json_encode($establec);
	}

    //Llena el combo provincias
	public function llenaProvincias()
	{
		$filtro = $this->input->get('departamento');
		foreach ($this->mantenimiento_model->buscarProvincias($filtro) as $prov) {
			$provincia[$prov->ubigeo] = $prov->nombre;
		}
		echo json_encode($provincia);
	}

    //Llena el combo distritos
	public function llenaDistritos()
	{
		$filtro1 = $this->input->get('provincia');
										   
		foreach ($this->mantenimiento_model->buscarDistritos($filtro1) as $dist) {
			$distrito[$dist->ubigeo] = $dist->nombre;
		}
		
		echo json_encode($distrito);
	}

    //Llena el combo subetnias
	public function llenaSubetnias()
	{
		$filtro1 = $this->input->get('etnias');
										   
		foreach ($this->mantenimiento_model->buscarSubetnias($filtro1) as $subetn) {
			$subetnias[$subetn->registroId] = $subetn->nombre;
		}
		
		echo json_encode($subetnias);
	}

	// Funciones de validación del registro individual
	// Validando fechas
	function validar_fecha($str){
		$patron="/^(\d){2}\-(\d){2}\-(\d){4}$/i";
		if (preg_match($patron,$str)){
			return TRUE;
		}else{
			$this->form_validation->set_message('validar_fecha',
			'formato de %s no v&aacute;lido');
			return FALSE;
		}
	}
	
	// Validando ubigeos
	function validar_ubigeo($str){
		$pais= $this->input->post('paises');
		$ubigeo = $this->input->post('distrito');
		
		if($pais == "171" and $ubigeo == "")
		{
			$this->form_validation->set_message('validar_ubigeo',
			'El campo %s es obligatorio');
			return FALSE;
		}else{
			return true;
		}
	}

	// Validando año
	function validar_anio($str){
		$ano = $this->input->post('ano');
		
		if($ano > date("Y") or $ano < 2000)
		{
			$this->form_validation->set_message('validar_anio',
			'Valor del campo %s no es v&aacute;lido');
			return FALSE;
		}else{
			return true;
		}
	}

	// Validando semana
	function validar_semana($str){
		$semana = $this->input->post('semana');
		
		if($semana == 0 or $semana > 53)
		{
			$this->form_validation->set_message('validar_semana',
			'Valor del campo %s no es v&aacute;lido');
			return FALSE;
		}else{
			return true;
		}
	}
	
	// Infeciones respiratorias agudas - Hospitalizados
	// Validando casos hos_m2
	function validar_hos_m2($str){
		$ngr_m2 = $this->input->post('ngr_m2');
		$hos_m2 = $this->input->post('hos_m2');
		
		if($hos_m2 > $ngr_m2)
		{
			$this->form_validation->set_message('validar_hos_m2', 
			'Valor del campo %s no es v&aacute;lido');
			return FALSE;
		}else{
			return true;
		}
	}

	// Validando casos hos_2_11
	function validar_hos_2_11($str){
		$neu_2_11 = $this->input->post('neu_2_11');
		$ngr_2_11 = $this->input->post('ngr_2_11');
		$hos_2_11 = $this->input->post('hos_2_11');
		
		if($hos_2_11 > ($neu_2_11 + $ngr_2_11))
		{
			$this->form_validation->set_message('validar_hos_2_11', 
			'Valor del campo %s no es v&aacute;lido');
			return FALSE;
		}else{
			return true;
		}
	}

	// Validando casos hos_1_4a
	function validar_hos_1_4a($str){
		$neu_1_4a = $this->input->post('neu_1_4a');
		$ngr_1_4a = $this->input->post('ngr_1_4a');
		$hos_1_4a = $this->input->post('hos_1_4a');
		
		if($hos_1_4a > ($neu_1_4a + $ngr_1_4a))
		{
			$this->form_validation->set_message('validar_hos_1_4a', 
			'Valor del campo %s no es v&aacute;lido');
			return FALSE;
		}else{
			return true;
		}
	}

	// Validando casos hos_5_9a
	function validar_hos_5_9a($str){
		$neu_5_9a = $this->input->post('neu_5_9a');
		$hos_5_9a = $this->input->post('hos_5_9a');
		
		if($hos_5_9a > $neu_5_9a)
		{
			$this->form_validation->set_message('validar_hos_5_9a', 
			'Valor del campo %s no es v&aacute;lido');
			return FALSE;
		}else{
			return true;
		}
	}

	// Validando casos hos_10_19
	function validar_hos_10_19($str){
		$neu_10_19 = $this->input->post('neu_10_19');
		$hos_10_19 = $this->input->post('hos_10_19');
		
		if($hos_10_19 > $neu_10_19)
		{
			$this->form_validation->set_message('validar_hos_10_19', 
			'Valor del campo %s no es v&aacute;lido');
			return FALSE;
		}else{
			return true;
		}
	}

	// Validando casos hos_20_59
	function validar_hos_20_59($str){
		$neu_20_59 = $this->input->post('neu_20_59');
		$hos_20_59 = $this->input->post('hos_20_59');
		
		if($hos_20_59 > $neu_20_59)
		{
			$this->form_validation->set_message('validar_hos_20_59', 
			'Valor del campo %s no es v&aacute;lido');
			return FALSE;
		}else{
			return true;
		}
	}

	// Validando casos hos_60a
	function validar_hos_60a($str){
		$neu_60a = $this->input->post('neu_60a');
		$hos_60a = $this->input->post('hos_60a');
		
		if($hos_60a > $neu_60a)
		{
			$this->form_validation->set_message('validar_hos_60a', 
			'Valor del campo %s no es v&aacute;lido');
			return FALSE;
		}else{
			return true;
		}
	}

	// Infeciones respiratorias agudas - Defunciones intrahospitalarias
	// Validando casos dih_m2
	function validar_dih_m2($str){
		$ngr_m2 = $this->input->post('ngr_m2');
		$dih_m2 = $this->input->post('dih_m2');
		
		if($dih_m2 > $ngr_m2)
		{
			$this->form_validation->set_message('validar_dih_m2', 
			'Valor del campo %s no es v&aacute;lido');
			return FALSE;
		}else{
			return true;
		}
	}

	// Validando casos dih_2_11
	function validar_dih_2_11($str){
		$neu_2_11 = $this->input->post('neu_2_11');
		$ngr_2_11 = $this->input->post('ngr_2_11');
		$dih_2_11 = $this->input->post('dih_2_11');
		
		if($dih_2_11 > ($neu_2_11 + $ngr_2_11))
		{
			$this->form_validation->set_message('validar_dih_2_11', 
			'Valor del campo %s no es v&aacute;lido');
			return FALSE;
		}else{
			return true;
		}
	}

	// Validando casos dih_1_4a
	function validar_dih_1_4a($str){
		$neu_1_4a = $this->input->post('neu_1_4a');
		$ngr_1_4a = $this->input->post('ngr_1_4a');
		$dih_1_4a = $this->input->post('dih_1_4a');
		
		if($dih_1_4a > ($neu_1_4a + $ngr_1_4a))
		{
			$this->form_validation->set_message('validar_dih_1_4a', 
			'Valor del campo %s no es v&aacute;lido');
			return FALSE;
		}else{
			return true;
		}
	}

	// Validando casos dih_5_9a
	function validar_dih_5_9a($str){
		$neu_5_9a = $this->input->post('neu_5_9a');
		$dih_5_9a = $this->input->post('dih_5_9a');
		
		if($dih_5_9a > $neu_5_9a)
		{
			$this->form_validation->set_message('validar_dih_5_9a', 
			'Valor del campo %s no es v&aacute;lido');
			return FALSE;
		}else{
			return true;
		}
	}

	// Validando casos dih_10_19
	function validar_dih_10_19($str){
		$neu_10_19 = $this->input->post('neu_10_19');
		$dih_10_19 = $this->input->post('dih_10_19');
		
		if($dih_10_19 > $neu_10_19)
		{
			$this->form_validation->set_message('validar_dih_10_19', 
			'Valor del campo %s no es v&aacute;lido');
			return FALSE;
		}else{
			return true;
		}
	}

	// Validando casos dih_20_59
	function validar_dih_20_59($str){
		$neu_20_59 = $this->input->post('neu_20_59');
		$dih_20_59 = $this->input->post('dih_20_59');
		
		if($dih_20_59 > $neu_20_59)
		{
			$this->form_validation->set_message('validar_dih_20_59', 
			'Valor del campo %s no es v&aacute;lido');
			return FALSE;
		}else{
			return true;
		}
	}

	// Validando casos dih_60a
	function validar_dih_60a($str){
		$neu_60a = $this->input->post('neu_60a');
		$dih_60a = $this->input->post('dih_60a');
		
		if($dih_60a > $neu_60a)
		{
			$this->form_validation->set_message('validar_dih_60a', 
			'Valor del campo %s no es v&aacute;lido');
			return FALSE;
		}else{
			return true;
		}
	}

	// Infeciones respiratorias agudas - Defunciones extrahospitalarias
	// Validando casos deh_m2
	function validar_deh_m2($str){
		$ngr_m2 = $this->input->post('ngr_m2');
		$deh_m2 = $this->input->post('deh_m2');
		
		if($deh_m2 > $ngr_m2)
		{
			$this->form_validation->set_message('validar_deh_m2', 
			'Valor del campo %s no es v&aacute;lido');
			return FALSE;
		}else{
			return true;
		}
	}

	// Validando casos deh_2_11
	function validar_deh_2_11($str){
		$neu_2_11 = $this->input->post('neu_2_11');
		$ngr_2_11 = $this->input->post('ngr_2_11');
		$deh_2_11 = $this->input->post('deh_2_11');
		
		if($deh_2_11 > ($neu_2_11 + $ngr_2_11))
		{
			$this->form_validation->set_message('validar_deh_2_11', 
			'Valor del campo %s no es v&aacute;lido');
			return FALSE;
		}else{
			return true;
		}
	}

	// Validando casos deh_1_4a
	function validar_deh_1_4a($str){
		$neu_1_4a = $this->input->post('neu_1_4a');
		$ngr_1_4a = $this->input->post('ngr_1_4a');
		$deh_1_4a = $this->input->post('deh_1_4a');
		
		if($deh_1_4a > ($neu_1_4a + $ngr_1_4a))
		{
			$this->form_validation->set_message('validar_deh_1_4a', 
			'Valor del campo %s no es v&aacute;lido');
			return FALSE;
		}else{
			return true;
		}
	}

	// Validando casos deh_5_9a
	function validar_deh_5_9a($str){
		$neu_5_9a = $this->input->post('neu_5_9a');
		$deh_5_9a = $this->input->post('deh_5_9a');
		
		if($deh_5_9a > $neu_5_9a)
		{
			$this->form_validation->set_message('validar_deh_5_9a', 
			'Valor del campo %s no es v&aacute;lido');
			return FALSE;
		}else{
			return true;
		}
	}

	// Validando casos deh_10_19
	function validar_deh_10_19($str){
		$neu_10_19 = $this->input->post('neu_10_19');
		$deh_10_19 = $this->input->post('deh_10_19');
		
		if($deh_10_19 > $neu_10_19)
		{
			$this->form_validation->set_message('validar_deh_10_19', 
			'Valor del campo %s no es v&aacute;lido');
			return FALSE;
		}else{
			return true;
		}
	}

	// Validando casos deh_20_59
	function validar_deh_20_59($str){
		$neu_20_59 = $this->input->post('neu_20_59');
		$deh_20_59 = $this->input->post('deh_20_59');
		
		if($deh_20_59 > $neu_20_59)
		{
			$this->form_validation->set_message('validar_deh_20_59', 
			'Valor del campo %s no es v&aacute;lido');
			return FALSE;
		}else{
			return true;
		}
	}

	// Validando casos deh_60a
	function validar_deh_60a($str){
		$neu_60a = $this->input->post('neu_60a');
		$deh_60a = $this->input->post('deh_60a');
		
		if($deh_60a > $neu_60a)
		{
			$this->form_validation->set_message('validar_deh_60a', 
			'Valor del campo %s no es v&aacute;lido');
			return FALSE;
		}else{
			return true;
		}
	}

	// Validando casos
	function validar_cantidad($str){
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
			$this->form_validation->set_message('validar_cantidad', 
			'No se permite un registro sin atenciones');
			return FALSE;
		}else{
			return true;
		}
	}

	// Callback para la eliminación de registro
	public function log_usuario_before_delete()
	{
		$this->mantenimiento_model->auditoriaOperador($this->session->userdata('usuario'), 'Eliminar Iras');		
		return true;
	}
}