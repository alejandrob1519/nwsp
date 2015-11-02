<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Individual extends CI_Controller {
    
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
		$this->layout->view('listadoIndividual.php',$output);
    }

	public function index()
    {
		$this->_example_output1((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
	}
	
	// Listar reegistros de la notificación individual
	
	public function listadoIndividual()
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

		$enf = $this->frontend_model->mostrarDiagnostico();

		$enfermedad = array();
		
		foreach($enf as $dato)
		{
			$enfermedad[$dato->cie_10] = $dato->diagno;
		}

		$tdx = $this->frontend_model->mostrarTipo();

		$tipoDx = array();
		
		foreach($tdx as $dato)
		{
			$tipoDx[$dato->codigo] = $dato->denominacion;
		}
		
		$filtro = array();
		
		(($this->input->post('diresa')) ? $filtro['sub_reg_nt'] = $this->input->post('diresa') : '');
		(($this->input->post('redes')) ? $filtro['red'] = $this->input->post('redes') : '');
		(($this->input->post('microred')) ? $filtro['microred'] = $this->input->post('microred') : '');
		(($this->input->post('establec')) ? $filtro['e_salud'] = $this->input->post('establec') : '');
		(($this->input->post('departamento')) ? $filtro['substr(ubigeo,1,2)'] = $this->input->post('departamento') : '' );
		(($this->input->post('provincia')) ? $filtro['substr(ubigeo,1,4)'] = $this->input->post('provincia') : '' );
		(($this->input->post('distrito')) ? $filtro['ubigeo'] = $this->input->post('distrito') : '' );
		(($this->input->post('diagno')) ? $filtro['diagnostic'] = $this->input->post('diagno') : '' );
		(($this->input->post('tipoDx')) ? $filtro['tipo_dx'] = $this->input->post('tipoDx') : '' );
		(($this->input->post('ano_ini')) ? $filtro['ano'] = $this->input->post('ano_ini') : '' );
		(($this->input->post('semana_ini')) ? $filtro['semana'] = $this->input->post('semana_ini') : '' );
		(($this->input->post('apepat')) ? $filtro['apepat'] = $this->input->post('apepat') : '' );
		
		$crud = new grocery_CRUD();
		$crud->set_theme("datatables");
		$crud->set_table('individual');
		$crud->columns('ano', 'semana', 'diagnostic', 'tipo_dx', 'subregion', 'sub_reg_nt', 'ubigeo', 'sexo', 'apepat', 'apemat', 'nombres');
		$crud->display_as('ano','A&ntilde;o')
			->display_as('diagnostic','Diagn&oacute;stico')
			->display_as('subregion','Diresa')
			->display_as('sub_reg_nt','Notificante')
			->display_as('ubigeo','Distrito')
			->display_as('tipo_dx','Tipo')
			->display_as('apepat','Ap. Paterno')
			->display_as('apemat','Ap. Materno');
		$crud->field_type('subregion','dropdown',$subr);         
		$crud->field_type('sub_reg_nt','dropdown',$subr);         
		$crud->field_type('ubigeo','dropdown',$ubigeo);         
		$crud->field_type('diagnostic','dropdown',$enfermedad);         
		$crud->field_type('tipo_dx','dropdown',$tipoDx);         
		$crud->field_type('sexo','dropdown',array('M'=>'Masculino', 'F'=>'Femenino'));   
		
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
					$crud->where(array('substr(e_salud,7,1)' => $this->session->userdata('institucion'), 'subregion' => $accesar));
				}else{
					$crud->where(array('subregion' => $accesar));
					$crud->or_where(array('sub_reg_nt' => $accesar));
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
		$crud->set_subject('Individual');
				
		$crud->unset_add();
		$crud->unset_read();
		$crud->unset_edit();
		$crud->unset_export();
		$crud->unset_print();
		
		$crud->callback_after_delete(array($this,'log_usuario_before_delete'));
		
		
		$crud->add_action('Editar', '', 'individual/modIndividual','ui-icon-pencil');
		///////////////////////////////////////////////////////////////////////////////
		//$crud->add_action_peru('A&ntilde;adir Individual', '', 'regIndividual','add-icon');
		///////////////////////////////////////////////////////////////////////////////

		$output = $crud->render();

		$this->_example_output1($output);
	}
	
	//Registro de la ficha de notificación individual
	
    public function regIndividual()
    {
        if($this->input->post()){
            if ($this->form_validation->run("notificacion/individual"))
            {
				$usuario = $this->session->userdata('usuario');
				
				$ano = substr($this->fechas_model->arreglarFechas($this->input->post('fecha_ini')),0,4);
				
				if($this->frontend_model->buscaCierre($ano) != 0)
				{
					$this->session->set_flashdata('error', 'El cierre de base de datos para el a&ntilde;o solicitado ya ha sido realizado, No se grab&oacute; la informaci&oacute;n');
					redirect(site_url('individual/regIndividual'), 301);
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
				
				if($this->session->userdata('grabar') == '1'){
					if($this->frontend_model->comparaIndividual($this->input->post('dni', true), 
						$this->input->post('apepat', true), $this->input->post('apemat', true), 
						$this->input->post('nombres', true), $this->input->post('diagno', true)) != 0){
						
						$registro = $this->frontend_model->mostrarIndividual(
						$this->input->post('dni', true), $this->input->post('apepat', true), 
						$this->input->post('apemat', true), $this->input->post('nombres', true), 
						$this->input->post('diagno', true));
						
						$sub = $this->frontend_model->mostrarLineaDiresa($registro->sub_reg_nt);
						
						$this->session->set_flashdata('info', 'Atenci&oacute;n: Este caso ya est&aacute; notificado por la DIRESA '.$sub->nombre.' No se grab&oacute; el registro.');
						redirect('individual/regIndividual', 301);
					}else{
						if($this->frontend_model->buscaIndividual($clave) == 0){
							$guardar = $this->frontend_model->insertarIndividual($data);
							
							if($guardar)
							{
								$this->mantenimiento_model->auditoriaOperador($this->session->userdata('usuario'), 'Registro individual');
								$this->session->set_flashdata('exito', 'Informaci&oacute;n guardada con &eacute;xito.');
								redirect('individual/regIndividual', 301);
							}
						}else{
								$this->session->set_flashdata('error', 'Error: Ya existe un registro para este paciente, NO se grab&oacute; el registro.');
								redirect('individual/regIndividual', 301);
						}
					}
				}else{
					$this->session->set_flashdata('error', 'Error: Usted no cuenta con autorizaci&oacute;n para grabar registros. NO se grab&oacute; la informaci&oacute;n ingresada.');
					redirect('individual/regIndividual', 301);
				}
			}
		}
		
		//combo vigilancias
		
		$vigila = $this->frontend_model->mostrarVigilancias();

		$vigilancias[''] = 'Seleccione ...';
		foreach ($vigila as $dato){
			$vigilancias[$dato->codigo] = $dato->denominacion;
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
		
		//combo Localidad
		
		if($this->input->post('distrito') != ''){
			$local = $this->frontend_model->buscarLocalidad($this->input->post('distrito'));
	
			//$localidad[''] = 'Seleccione ...';
			foreach ($local as $dato){
				$localidad[$dato->codloc] = $dato->nombre;
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
		
		if($this->session->userdata('nivel') == '1' or $this->session->userdata('nivel') == '4')
		{
            redirect(site_url("individual/listadoIndividual"), 301);
		}
		
		if(!empty($this->session_id)){
			if($grabar_id != '1'){
				$this->session->set_flashdata('error', 'Error: Usted no cuenta con autorizaci&oacute;n para grabar registros.');
	            redirect(site_url("index/principal"), 301);
			}
			$this->layout->view('regIndividual', compact('session_id', 'vigilancias', 'diresa', 'redes', 'microred', 'establec', 'paises', 'departamento', 'provincia', 'distrito', 'localidad', 'etnias', 'subetnias', 'diagno', 'tipoDx'));
        }else{
            redirect(site_url("index/login"), 301);
        }
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
					redirect(site_url('individual/modIndividual'), 301);
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
						redirect('individual/listadoIndividual', 301);
					}
				}else{
					$this->session->set_flashdata('error', 'Error: Usted no cuenta con autorizaci&oacute;n para grabar &oacute; modificar registros. NO se modific&oacute; la informaci&oacute;n corregida.');
					redirect('individual/listadoIndividual', 301);
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
			if($grabar_id != '1' or $modificar_id != '1'){
				$this->session->set_flashdata('error', 'Error: Usted no cuenta con autorizaci&oacute;n para grabar &oacute; modificar registros.');
	            redirect(site_url("individual/listadoIndividual"), 301);
			}
			$this->layout->view('modIndividual', compact('session_id', 'modificar', 'vigilancias', 'diresa', 'redes', 'microred', 'establec', 'paises', 'departamento', 'provincia', 'distrito', 'localidad', 'etnias', 'subetnias', 'diagno', 'tipoDx'));
        }else{
            redirect(site_url("index/login"), 301);
        }
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

    //Llena el combo localidad
	public function llenaLocalidad()
	{
		$filtro1 = $this->input->get('distrito');
										   
		foreach ($this->mantenimiento_model->buscarLocalidades($filtro1) as $local) {
			$localidad[$local->codloc] = $local->nombre;
		}
		
		echo json_encode($localidad);
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
		if($str != ''){
			$patron="/^(\d){2}\-(\d){2}\-(\d){4}$/i";
			if (preg_match($patron,$str)){
				return TRUE;
			}else{
				$this->form_validation->set_message('validar_fecha',
				'formato de %s no v&aacute;lido');
				return FALSE;
			}
		}
	}
	
	// Validando sexo
	function validar_sexo($str){
		$diagnostico = $this->input->post('diagno');
		$sex = $this->input->post('sexo');
		
		$se = '';
		
		foreach ($this->frontend_model->mostrarSexo($diagnostico) as $diagn) {
			$enfer = $diagn->cie_10;
			$se = $diagn->sexo;
		}
		
		if($sex == $se or $se == 'A')
		{
			return true;
		}else{
			$this->form_validation->set_message('validar_sexo',
			'Elecci&oacute;n de %s no v&aacute;lido');
			return FALSE;
		}
	}

	// Validando tipo de diagnóstico
	function validar_tipoDiag($str){
		$diagnostico = $this->input->post('diagno');
		$tipo = $this->input->post('tipoDx');
		
		if(($diagnostico == "B50" or $diagnostico == "B51") and $tipo != "C")
		{
			$this->form_validation->set_message('validar_tipoDiag',
			'Elecci&oacute;n de %s no v&aacute;lido');
			return FALSE;
		}else{
			return true;
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

	// Validando edad
	public function validar_edad($str)
	{
		$diagnostico = $this->input->post('diagno');
		$sex = $this->input->post('sexo');
		$eda = $this->input->post('edad');
		$ted = $this->input->post('tipo');
		
		foreach ($this->frontend_model->mostrarSexo($diagnostico) as $diagn) {
			$enfer = $diagn->cie_10;
			$sex = $diagn->sexo;
			$ed = $diagn->edad;
			$te = $diagn->tipoE;
		}
		
		switch($te)
		{
			case 'D':
				if($ted <> $te or $eda > $ed)
				{
					$this->form_validation->set_message('validar_edad',
					'El rango de %s no es v&aacute;lido');
					return FALSE;
				}else{
					return true;
				}
			break;
			case 'M':
				if(($ted == 'A') or ($ted == 'M' and $eda > $ed))
				{
					$this->form_validation->set_message('validar_edad',
					'El rango de %s no es v&aacute;lido');
					return FALSE;
				}else{
					return true;
				}
			break;
			case 'A':
				if(($ted != 'D' and $ted != 'M') and $eda > $ed)
				{
					$this->form_validation->set_message('validar_edad',
					'El rango de %s no es v&aacute;lido');
					return FALSE;
				}else{
					return true;
				}
			break;
			default:
			return true;
			break;
		}
	}
	
	// Validando fechas
	
	function validar_fechaIni($str){
		if($this->input->post('fecha_ini') != '' and $this->input->post('fecha_ini') != '00-00-0000'){
			$fecha1 = date("d-m-Y");
			$fecha2 = $this->input->post('fecha_ini');
			$fecha3 = $this->input->post('fecha_def');
			$fecha4 = $this->input->post('fecha_inv');
			$fecha5 = $this->input->post('fecha_not');

			$fecha2 = explode(" ",$fecha2);
			$inicio = $fecha2[0];
			$fecha3 = explode(" ",$fecha3);
			$defuncion = $fecha3[0];
			$fecha4 = explode(" ",$fecha4);
			$investigacion = $fecha4[0];
			$fecha5 = explode(" ",$fecha5);
			$notificacion = $fecha5[0];

			$fechaInicio = strtotime("$inicio");
			$fechaHoy = strtotime("$fecha1");
			$fechaDefuncion = strtotime("$defuncion");
			$fechaInvestigacion = strtotime("$investigacion");
			$fechaNotificacion = strtotime("$notificacion");
			
			if($fechaHoy < $fechaInicio and $fecha2 <> '' and $fecha2[0] <> '00-00-0000'){
				$this->form_validation->set_message('validar_fechaIni',
				'Error en la %s no es v&aacute;lida7');
				return FALSE;
			}
			
			if($fechaInicio > $fechaDefuncion and $fechaDefuncion != '' and $this->input->post('fecha_def') != '00-00-0000'){
				$this->form_validation->set_message('validar_fechaIni',
				'Error en la %s no es v&aacute;lida8');
				return FALSE;
			}
			
			if($fechaInicio > $fechaInvestigacion and $fechaInvestigacion != '' and $fecha4[0] != '00-00-0000'){
				$this->form_validation->set_message('validar_fechaIni',
				'Error en la %s no es v&aacute;lida9');
				return FALSE;
			}
			
			if($fechaInicio > $fechaNotificacion and $notificacion != '' and $fecha5[0] != '00-00-0000'){
				$this->form_validation->set_message('validar_fechaIni',
				'Error en la %s no es v&aacute;lida10');
				return FALSE;
			}
		}
			
		return true;
	}

	function validar_fechaHosp($str){
		if($this->input->post('fecha_hos') != '' and $this->input->post('fecha_hos') != '00-00-0000'){
			$fecha1 = date("d-m-Y");
			$fecha2 = $this->input->post('fecha_hos');
			$fecha3 = $this->input->post('fecha_ini');
			$fecha4 = $this->input->post('fecha_def');
			
			$fechaHoy = strtotime("$fecha1");
			$fecha2 = explode(" ",$fecha2);
			$hospitalizacion = $fecha2[0];
			$fecha3 = explode(" ",$fecha3);
			$Inicio = $fecha3[0];
			$fecha4 = explode(" ",$fecha4);
			$Defuncion = $fecha4[0];

			$fechaHospitalizacion = strtotime("$hospitalizacion");
			$fechaInicio = strtotime("$inicio");
			$fechaHoy = strtotime("$fecha1");
			$fechaDefuncion = strtotime("$defuncion");
			
			if($hospitalizacion > $fechaHoy and $hospitalizacion != '' and $fecha2[0] != '00-00-0000'){
				$this->form_validation->set_message('validar_fechaHosp',
				'Error en la %s no es v&aacute;lida1');
				return FALSE;
			}

			if($hospitalizacion < $Inicio and $Inicio != '' and $fecha2[0] != '00-00-0000'){
				$this->form_validation->set_message('validar_fechaHosp',
				'Error en la %s no es v&aacute;lida2');
				return FALSE;
			}

			if($hospitalizacion > $Defuncion and $Defuncion != '' and $this->input->post('fecha_def') != '00-00-0000'){
				$this->form_validation->set_message('validar_fechaHosp',
				'Error en la %s no es v&aacute;lida3');
				return FALSE;
			}
			
			if($hospitalizacion > $fechaHoy){
				$this->form_validation->set_message('validar_fechaHosp',
				'Error en la %s no es v&aacute;lida4');
				return FALSE;
			}
			
			return true;
		}
	}

	function validar_fechaDef($str){
		if($this->input->post('fecha_def') != '' and $this->input->post('fecha_def') != '00-00-0000'){
			$fecha1 = date("d-m-Y");
			$fecha2 = $this->input->post('fecha_def');
			$fecha3 = $this->input->post('fecha_ini');
			$dato = $this->input->post('diagno');
			
			$fechaHoy = strtotime("$fecha1");
			$fecha2 = explode(" ",$fecha2);
			$Defuncion = $fecha2[0];
			$fecha3 = explode(" ",$fecha3);
			$Inicio = $fecha3[0];

			$fechaHospitalizacion = strtotime("$hospitalizacion");
			$fechaInicio = strtotime("$inicio");
			$fechaHoy = strtotime("$fecha1");
			$fechaDefuncion = strtotime("$defuncion");
			
			if($Defuncion > $fechaHoy and $Defuncion != '' and $this->input->post('fecha_def') != '00-00-0000'){
				$this->form_validation->set_message('validar_fechaDef',
				'Error en la %s no es v&aacute;lida15');
				return FALSE;
			}
			
			if($fechaDefuncion < $fechaInicio and ($Inicio != '00-00-0000' and $this->input->post('fecha_def') != '00-00-0000')){
				$this->form_validation->set_message('validar_fechaDef',
				'Error en la %s no es v&aacute;lida16');
				return FALSE;
			}
			
			if($Defuncion != '' and $dato == 'A97.0'){
				$this->form_validation->set_message('validar_fechaDef',
				'Error en la %s no es v&aacute;lida17');
				return FALSE;
			}
			
			if($fechaDefuncion > $fechaHoy){
				$this->form_validation->set_message('validar_fechaDef',
				'Error en la %s no es v&aacute;lida18');
				return FALSE;
			}

			return true;
		}else{
			$fecha2 = $this->input->post('fecha_def');
			$dato = $this->input->post('diagno');

			$fechaHoy = strtotime("$fecha1");
			$fecha2 = explode(" ",$fecha2);
			$Defuncion = $fecha2[0];

			if($Defuncion == '' and ($dato == 'O95' or $dato == 'O96' or $dato == 'O97')){
				$this->form_validation->set_message('validar_fechaDef',
				'Defunci&oacute;n, debe colocar la %s');
				return FALSE;
			}
			
			return true;			
		}
	}

	function validar_fechaInv($str){
		if($this->input->post('fecha_inv') != '' and $this->input->post('fecha_inv') != '00-00-0000'){
			$fecha1 = date("d-m-Y");
			$fecha2 = $this->input->post('fecha_inv');
			$fecha3 = $this->input->post('fecha_ini');
			
			$fechaHoy = strtotime("$fecha1");
			$fecha2 = explode(" ",$fecha2);
			$investigacion = $fecha2[0];
			$fecha3 = explode(" ",$fecha3);
			$Inicio = $fecha3[0];

			$fechaInvestigacion = strtotime("$investigacion");
			$fechaInicio = strtotime("$inicio");
			$fechaHoy = strtotime("$fecha1");
			
			if($fechaInvestigacion > $fechaHoy and $fechaInvestigacion != '' and $fecha2[0] != '00-00-0000'){
				$this->form_validation->set_message('validar_fechaInv',
				'Error en la %s no es v&aacute;lida20');
				return FALSE;
			}
			
			if($fechaInvestigacion < $Inicio and $Inicio != ''){
				$this->form_validation->set_message('validar_fechaInv',
				'Error en la %s no es v&aacute;lida21');
				return FALSE;
			}
			
			if($fechaInvestigacion > $fechaHoy){
				$this->form_validation->set_message('validar_fechaInv',
				'Error en la %s no es v&aacute;lida22');
				return FALSE;
			}

			return true;
		}
	}

	function validar_fechaNot($str){
		if($this->input->post('fecha_not') != '' and $this->input->post('fecha_not') != '00-00-0000'){
			$fecha1 = date("d-m-Y");
			$fecha2 = $this->input->post('fecha_not');
			$fecha3 = $this->input->post('fecha_ini');
			$fecha4 = $this->input->post('fecha_def');
			
			$fecha2 = explode(" ",$fecha2);
			$notificacion = $fecha2[0];
			$fecha3 = explode(" ",$fecha3);
			$inicio = $fecha3[0];
			$fecha4 = explode(" ",$fecha4);
			$defuncion = $fecha4[0];

			$fechaInicio = strtotime("$inicio");
			$fechaHoy = strtotime("$fecha1");
			$fechaDefuncion = strtotime("$defuncion");
			$fechaNotificacion = strtotime("$notificacion");
			
			if($fechaNotificacion > $fechaHoy and $fechaNotificacion != ''){
				$this->form_validation->set_message('validar_fechaNot',
				'Error en la %s no es v&aacute;lida25');
				return FALSE;
			}
			
			if($fechaNotificacion < $fechaInicio and $fechaInicio != ''){
				$this->form_validation->set_message('validar_fechaNot',
				'Error en la %s no es v&aacute;lida26');
				return FALSE;
			}
			
/*			if($fechaNotificacion < $fechaDefuncion and $fechaDefuncion != '' and $this->input->post('fecha_def') != '00-00-0000'){
				$this->form_validation->set_message('validar_fechaNot',
				'Error en la %s no es v&aacute;lida27');
				return FALSE;
			}
			
			if($fechaNotificacion > $fechaNotificacion){
				$this->form_validation->set_message('validar_fechaNot',
				'Error en la %s no es v&aacute;lida28');
				return FALSE;
			}
			
*/			return true;
		}
	}

	// Callback para la eliminación de registro
	
	public function log_usuario_before_delete()
	{
		$this->mantenimiento_model->auditoriaOperador($this->session->userdata('usuario'), 'Eliminar individual');		
		return true;
	}

	// Callback para la adición de registro
	
	public function log_individual_before_add()
	{
		$this->mantenimiento_model->auditoriaOperador($this->session->userdata('usuario'), 'Eliminar individual');		
		return true;
	}
}