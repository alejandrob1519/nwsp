<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Febriles extends CI_Controller {
    
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
		$this->layout->view('listadoFebriles.php',$output);
    }

	public function index()
    {
		$this->_example_output1((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
	}
	
	// Listar registros de febriles
	public function listadoFebriles()
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

		$crud->set_table('febriles');
		$crud->set_theme("datatables");
		$crud->columns('ano', 'semana', 'sub_reg_nt', 'e_salud', 'feb_m1', 'feb_1_4', 'feb_5_9', 'feb_10_19', 'feb_20_59', 'feb_m60', 'feb_tot');
		$crud->display_as('ano','A&ntilde;o')
			->display_as('e_salud','Establecimiento')
			->display_as('sub_reg_nt','Diresa')
			->display_as('feb_m1','Men. 1')
			->display_as('feb_1_4','1 a 4')
			->display_as('feb_5_9','5 a 9')
			->display_as('feb_10_19','10 a 19')
			->display_as('feb_20_59','20 a 59')
			->display_as('feb_m60','> 60')
			->display_as('feb_tot','Febriles');
		$crud->field_type('sub_reg_nt','dropdown',$subr);         
		$crud->field_type('e_salud','dropdown',$establec);         
		//$crud->where(array('ano'=>date('Y')));
		
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
		$crud->set_subject('Febriles');
				
		$crud->unset_add();
		$crud->unset_read();
		$crud->unset_edit();
		$crud->unset_export();
		$crud->unset_print();
		
		$crud->callback_after_delete(array($this,'log_usuario_before_delete'));
		
		$crud->add_action('Editar', '', 'febriles/modFebriles','ui-icon-pencil');
		///////////////////////////////////////////////////////////////////////////////
		//$crud->add_action_peru('A&ntilde;adir Febriles', '', 'regFebriles','add-icon');
		///////////////////////////////////////////////////////////////////////////////
		
//		echo "<pre>";
//		print_r($crud);
//		exit;

		$output = $crud->render();

		$this->_example_output1($output);
	}
	
	//Registro de la ficha de Febriles
    public function regFebriles()
    {
        if($this->input->post()){
            if ($this->form_validation->run("febriles/febriles"))
            {
				$usuario = $this->session->userdata('usuario');
				
				$ano = $this->input->post('ano');
				
				if($this->frontend_model->buscaCierre($ano) != 0)
				{
					$this->session->set_flashdata('info', 'Atenci&oacute;n: El cierre de base de datos para el a&ntilde;o '.$ano.' ya ha sido realizado, No se grab&oacute; la informaci&oacute;n');
					redirect(site_url('febriles/regFebriles'), 301);
				}
			
				$clave = $this->input->post('ano').
				$this->input->post('semana').
				$this->input->post('establec'). 
				$this->input->post('distrito');
				
				$data = array('ano' => $this->input->post('ano'),
					'semana' => $this->input->post('semana'),
					'sub_reg_nt' => $this->input->post('diresa'),
					'red' => $this->input->post('redes'),
					'microred' => $this->input->post('microred'),
					'e_salud' => $this->input->post('establec'),
					'ubigeo' => $this->input->post('distrito'),
					'feb_m1' => $this->input->post('feb_m1'),
					'feb_1_4' => $this->input->post('feb_1_4'),
					'feb_5_9' => $this->input->post('feb_5_9'),
					'feb_10_19' => $this->input->post('feb_10_19'),
					'feb_20_59' => $this->input->post('feb_20_59'),
					'feb_m60' => $this->input->post('feb_m60'),
					'fecha_ing' => date("Y-m-d"),
					'clave' => $clave,
					'feb_tot' => $this->input->post('feb_tot'),
					'fecha_not' => $this->fechas_model->arreglarFechas($this->input->post('fecha_not')),
					'fecha_ate' => $this->fechas_model->arreglarFechas($this->input->post('fecha_ate')),
					'tot_aten' => $this->input->post('tot_aten'),
					'usuario' => $usuario
				);
				
				$cantidad = $this->input->post("feb_m1")+$this->input->post("feb_1_4")+$this->input->post("feb_5_9")+
					$this->input->post("feb_10_19")+$this->input->post("feb_20_59")+$this->input->post("feb_m60");
					
				if($cantidad == 0){
					$this->session->set_flashdata('error', 'Error Grave: No ha ingresado ninguna atenci&oacute;n. NO se grab&oacute; el registro.');
					redirect("febriles/regFebriles", 301);
				}

				if($this->session->userdata('grabar') == '1'){
					
					$guardar = $this->frontend_model->insertarFebriles($data);

					if($guardar)
					{
						$this->mantenimiento_model->auditoriaOperador($this->session->userdata('usuario'), 'Registro Febriles');
						$this->session->set_flashdata('exito', 'Informaci&oacute;n guardada con &eacute;xito.');
						redirect('febriles/regFebriles', 301);
					}
				}else{
					$this->session->set_flashdata('error', 'Error Grave: Usted no cuenta con autorizaci&oacute;n para grabar registros. NO se grab&oacute; la informaci&oacute;n ingresada.');
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
		
		$session_id = $this->session_id;
		$grabar_id = $this->session->userdata('grabar');
		
		if($this->session->userdata('nivel') == '1' or $this->session->userdata('nivel') == '4')
		{
            redirect(site_url("febriles/listadoFebriles"), 301);
		}
		
		if(!empty($this->session_id)){
			if($grabar_id != '1'){
				$this->session->set_flashdata('errorFrontend', 'Error: Usted no cuenta con autorizaci&oacute;n para grabar registros.');
				redirect(site_url("index/principal"), 301);
			}
			$this->layout->view('regFebriles', compact('session_id', 'diresa', 'redes', 'microred', 'establec', 'departamento', 'provincia', 'distrito'));
        }else{
            redirect(site_url("index/login"), 301);
        }
    }

	//Modificar registro de la ficha de notificación de febriles
    public function modFebriles($id=null)
    {
		if(!$id)
		{
			show_404();
		}
		
        if($this->input->post()){
            if ($this->form_validation->run("febriles/febriles"))
            {
				$usuario = $this->session->userdata('usuario');
				
				$ano = $this->input->post('ano');
				
				if($this->frontend_model->buscaCierre($ano) != 0)
				{
					$this->session->set_flashdata('error', 'El cierre de base de datos para el a&ntilde;o solicitado ya ha sido realizado, No se grab&oacute; la informaci&oacute;n');
					redirect(site_url('febriles/modFebriles'), 301);
				}
			
				$clave = $this->input->post('ano').
				$this->input->post('semana').
				$this->input->post('establec'). 
				$this->input->post('distrito');
				
				$data = array('ano' => $this->input->post('ano'),
					'semana' => $this->input->post('semana'),
					'sub_reg_nt' => $this->input->post('diresa'),
					'red' => $this->input->post('redes'),
					'microred' => $this->input->post('microred'),
					'e_salud' => $this->input->post('establec'),
					'ubigeo' => $this->input->post('distrito'),
					'feb_m1' => $this->input->post('feb_m1'),
					'feb_1_4' => $this->input->post('feb_1_4'),
					'feb_5_9' => $this->input->post('feb_5_9'),
					'feb_10_19' => $this->input->post('feb_10_19'),
					'feb_20_59' => $this->input->post('feb_20_59'),
					'feb_m60' => $this->input->post('feb_m60'),
					'fecha_ing' => date("Y-m-d"),
					'clave' => $clave,
					'feb_tot' => $this->input->post('feb_tot'),
					'fecha_not' => $this->fechas_model->arreglarFechas($this->input->post('fecha_not')),
					'fecha_ate' => $this->fechas_model->arreglarFechas($this->input->post('fecha_ate')),
					'tot_aten' => $this->input->post('tot_aten'),
					'usuario' => $usuario
				);
				
				$cantidad = $this->input->post("feb_m1")+$this->input->post("feb_1_4")+$this->input->post("feb_5_9")+
					$this->input->post("feb_10_19")+$this->input->post("feb_20_59")+$this->input->post("feb_m60");
					
				if($cantidad == 0){
					$this->session->set_flashdata('error', 'Error Grave: No ha ingresado ninguna atenci&oacute;n. NO se grab&oacute; el registro.');
					redirect("febriles/regFebriles", 301);
				}
				
				if($this->session->userdata('grabar') == '1' and $this->session->userdata('modificar') == '1'){
					
					$guardar = $this->frontend_model->ejecutarModificarFebriles($data, $id);
						
					if($guardar)
					{
						$this->mantenimiento_model->auditoriaOperador($this->session->userdata('usuario'), 'Modificar Febriles');
						$this->session->set_flashdata('exito', 'Informaci&oacute;n modificada con &eacute;xito.');
						redirect('febriles/listadoFebriles', 301);
					}
				}else{
					$this->session->set_flashdata('error', 'Error: Usted no cuenta con autorizaci&oacute;n para grabar &oacute; modificar registros. NO se modific&oacute; la informaci&oacute;n corregida.');
					redirect('index/principal', 301);
				}
			}
		}
		
		// Buscando registro a modificar
		$modificar = $this->frontend_model->modificarFebriles($id);
		
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

		$session_id = $this->session_id;
		$grabar_id = $this->session->userdata('grabar');
		$modificar_id = $this->session->userdata('modificar');
		
		if(!empty($this->session_id)){
			if($grabar_id != '1' or $modificar_id != '1'){
				$this->session->set_flashdata('error', 'Error: Usted no cuenta con autorizaci&oacute;n para grabar &oacute; modificar registros.');
	            redirect(site_url("febriles/listadoFebriles"), 301);
			}
			$this->layout->view('modFebriles', compact('session_id', 'modificar', 'diresa', 'redes', 'microred', 'establec', 'departamento', 'provincia', 'distrito'));
        }else{
            redirect(site_url("index/login"), 301);
        }
    }

    //validar duplicado
	public function validaDuplicado()
	{
		$e_salud = $this->input->post('establec');
		$ubigeo = $this->input->post('distrito');
		$fecha = $this->fechas_model->arreglarFechas($this->input->post('fecha_ate'));

		$filtro = $this->frontend_model->validaDuplicadoFebriles($e_salud, $ubigeo, $fecha);
		
		$data = array();
		
		foreach($filtro as $dato)
		{
			$data['febril'] = $dato->registroId;
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
	
	// Validando casos
	function validar_cantidad($str){
		$cantidad = $this->input->post("feb_m1")+$this->input->post("feb_1_4")+$this->input->post("feb_5_9")+
			$this->input->post("feb_10_19")+$this->input->post("feb_20_59")+$this->input->post("feb_m60");
			
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
		$this->mantenimiento_model->auditoriaOperador($this->session->userdata('usuario'), 'Eliminar Febril');		
		return true;
	}
}