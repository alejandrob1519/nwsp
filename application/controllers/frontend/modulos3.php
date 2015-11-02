<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modulos3 extends CI_Controller {

    public function __construct()
    {
		parent::__construct();
        $this->layout->setLayout('template7_7');
        $this->layout->setTitle(":: NotiWeb :: Defunciones por Neumon&iacute;as");
		date_default_timezone_set('America/Lima');
    }

    public function _example_output($output = null)
    {
		$usu = $this->session->userdata("usuario");
		
		$usuario = $usu['usuario'];
		
		$accion = 'Listar Neumonias';
			
		$this->login_model->auditoriaOperador($usuario, $accion);
			
		$this->layout->view('neumonias.php', $output);
    }

    public function index()
    {
		$this->_example_output((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
    }
	
	//Grocery Crud: Listado de Fichas del Módulo Chikungunya
    public function listarNeumonias()
    {
		$sub = $this->frontend_model->buscarDiresas();

		$subr = array();
		
		foreach($sub as $dato)
		{
			$subr[$dato->codigo] = $dato->nombre;
		}

		$est = $this->frontend_model->listaEstablec();
		
		$estab = array();
		
		foreach($est as $dato)
		{
			$estab[$dato->cod_est] = $dato->raz_soc;
		}
		
		$crud = new grocery_CRUD();

		$crud->set_table('neumonias');
		$crud->columns('diresa', 'e_salud', 'apepat', 'apemat', 'nombres', 'sexo', 'fecha_reg', 'fecha_def', 'usuario');
		$crud->set_subject('Ficha');
		
		$nivelUsuario = $this->session->userdata("nivel");
			
		switch($nivelUsuario){
			case '8':
			$where = array('e_salud' =>  $this->session->userdata("establecimiento"));
			$crud->where($where);
			break;
			case '7':
			$where = array('microred' =>  $this->session->userdata("microred"), 'red' =>  $this->session->userdata("red"), 'diresa' =>  $this->session->userdata("diresa"));
			$crud->where($where);
			break;
			case '6':
			$where = array('red' =>  $this->session->userdata("red"), 'diresa' =>  $this->session->userdata("diresa"));
			$crud->where($where);
			break;
			case '5':
			$where = array('diresa' => $this->session->userdata("diresa"));
			$crud->where($where);
			break;
		}

		$crud->field_type('sexo','dropdown',array('M'=>'Masculino', 'F'=>'Femenino'));   
		$crud->field_type('diresa','dropdown',$subr);         
		$crud->field_type('e_salud','dropdown',$estab);         
		$crud->display_as("apepat", "Apellido Paterno");
		$crud->display_as("apemat", "Apellido Materno");
		$crud->display_as("fecha_reg", "Registro");
		$crud->display_as("fecha_def", "Defunci&oacute;n");
		$crud->display_as("e_salud", "Establecimiento");
	
		$crud->unset_add();
		$crud->unset_edit();
		$crud->unset_read();
		$crud->unset_export();
		//$crud->unset_print();
		
		$crud->callback_after_delete(array($this,'log_usuario_before_delete'));
		
		$crud->add_action_peru('', '', 'RegfichaNeum','add-icon');
		$crud->add_action('Modificar Ficha', '', 'modulos3/ModfichaNeum','edit-icon');
		$crud->add_action('Ver Ficha', '', 'modulos3/VerfichaNeum','read-icon');
		$output = $crud->render();

		$this->_example_output($output);
    }

	//Registra una nueva ficha
    public function RegfichaNeum()
    {
        if($this->input->post()){
			$usu = $this->session->userdata("usuario");
			
			$usuario = $usu;
			
			$nivelUsuario = $this->session->userdata("nivel");
			
			if ($this->form_validation->run("modulos3/RegfichaNeum")){
				$establec = $this->input->post("establec");
				$microred = $this->input->post("microred");
				$red = $this->input->post("redes");
				$diresa = $this->input->post("diresa");
				
				$data = array
				(
					"diresa"=>$diresa,
					"red"=>$red,
					"microred"=>$microred,
					"e_salud"=>$establec,
					"fecha_reg"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_reg", true)),
					"apepat"=>$this->input->post("apepat", true),
					"apemat"=>$this->input->post("apemat", true),
					"nombres"=>$this->input->post("nombres", true),
					"sexo"=>$this->input->post("sexo", true),
					"fecha_nac"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_nac", true)),
					"ubigeo_res"=>$this->input->post("distrito", true),
					"direccion"=>$this->input->post("direccion", true),
					"zona"=>$this->input->post("zona", true),
					"fecha_def"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_def", true)),
					"hora_def"=>$this->input->post("hora_def", true),
					"ubigeo_def"=>$this->input->post("distrito14_1", true),
					"lugar_def"=>$this->input->post("lugar_def", true),
					"otro_def"=>$this->input->post("otro_def", true),
					"cuidador"=>$this->input->post("cuidador", true),
					"cuida_otro"=>$this->input->post("cuida_otro", true),
					"fecha_ini"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_ini", true)),
					"lugar_atencion"=>$this->input->post("lugar_atencion", true),
					"otro_lugar"=>$this->input->post("otro_lugar", true),
					"fecha_ate"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_ate", true)),
					"gravedad_tran"=>$this->input->post("gravedad_tran", true),
					"acepto_tran"=>$this->input->post("acepto_tran", true),
					"fecha_tra"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_tra", true)),
					"hora_tra"=>$this->input->post("hora_tra", true),
					"seguro"=>$this->input->post("seguro", true),
					"otro_seguro"=>$this->input->post("otro_seguro", true),
					"programa"=>$this->input->post("programa", true),
					"otro_programa"=>$this->input->post("otro_programa", true),
					"pentavalente"=>$this->input->post("pentavalente", true),
					"neumococo"=>$this->input->post("neumococo", true),
					"influenza"=>$this->input->post("influenza", true),
					"talla"=>$this->input->post("talla", true),
					"peso"=>$this->input->post("peso", true),
					"nutricion"=>$this->input->post("nutricion", true),
					"tipo"=>$this->input->post("tipo", true),
					"lactancia"=>$this->input->post("lactancia", true),
					"otro_lactancia"=>$this->input->post("otro_lactancia", true),
					"cred"=>$this->input->post("cred", true),
					"hospital"=>$this->input->post("hospital", true),
					"fecha_eme"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_eme", true)),
					"hora_eme"=>$this->input->post("hora_eme", true),
					"fecha_hos"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_hos", true)),
					"hora_hos"=>$this->input->post("hora_hos", true),
					"dx1"=>$this->input->post("dx1", true),
					"dx2"=>$this->input->post("dx2", true),
					"dx3"=>$this->input->post("dx3", true),
					"cbasica"=>$this->input->post("cbasica", true),
					"cintermedia"=>$this->input->post("cintermedia", true),
					"cterminal"=>$this->input->post("cterminal", true),
					"usuario"=>$usuario
				);
				
				$guardar = $this->fichas_model->insertarNeumonias($data);
				
				if($guardar)
				{
					$this->session->set_flashdata('exito', 'Informaci&oacute;n guardada con &eacute;xito.');
					redirect(site_url('modulos3/listarNeumonias'), 301);
				}else{
					$this->session->set_flashdata('error', 'No se guard&oacute; la informaci&oacute;n registrada.');
					redirect(site_url('regFichaNeum'), 301);
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
		
		//combo Departamentos14_1
		
		$depar = $this->frontend_model->buscarDepartamentos();

		$departamento14_1[''] = 'Seleccione ...';
		foreach ($depar as $dato){
			$departamento14_1[$dato->ubigeo] = $dato->nombre;
		}
		
		//combo Provincias
		
		if($this->input->post('departamento14_1') != ''){
			$prov = $this->frontend_model->buscarProvincias($this->input->post('departamento14_1'));
	
			//$provincia[''] = 'Seleccione ...';
			foreach ($prov as $dato){
				$provincia14_1[$dato->ubigeo] = $dato->nombre;
			}
		}
		
		//combo Distrito
		
		if($this->input->post('provincia14_1') != ''){
			$dist = $this->frontend_model->buscarDistritos($this->input->post('provincia14_1'));
	
			//$distrito[''] = 'Seleccione ...';
			foreach ($dist as $dato){
				$distrito14_1[$dato->ubigeo] = $dato->nombre;
			}
		}
		
		$nivelUsuario = $this->session->userdata("nivel");

		$registro = $this->input->get();
		
        $this->layout->view("regFichaNeum", compact('session_id', 'diresa', 'redes', 'microred', 'establec', 'departamento', 'provincia', 'distrito', 'departamento14_1', 'provincia14_1', 'distrito14_1'));
    }

    //Modifica el registro de la ficha de chikungunya
    public function ModfichaNeum($id=null)
    {
		if(!$id)
		{
			show_404();
		}
		
        if($this->input->post()){
			$usu = $this->session->userdata("usuario");
			
			$usuario = $usu;
			
			$nivelUsuario = $this->session->userdata("nivel");
			
			$establec = $this->input->post("establec");
			$microred = $this->input->post("microred");
			$red = $this->input->post("redes");
			$diresa = $this->input->post("diresa");
			
            if ($this->form_validation->run("modulos3/RegfichaNeum"))
            {
				$data = array
				(
					"diresa"=>$diresa,
					"red"=>$red,
					"microred"=>$microred,
					"e_salud"=>$establec,
					"fecha_reg"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_reg", true)),
					"apepat"=>$this->input->post("apepat", true),
					"apemat"=>$this->input->post("apemat", true),
					"nombres"=>$this->input->post("nombres", true),
					"sexo"=>$this->input->post("sexo", true),
					"fecha_nac"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_nac", true)),
					"ubigeo_res"=>$this->input->post("distrito", true),
					"direccion"=>$this->input->post("direccion", true),
					"zona"=>$this->input->post("zona", true),
					"fecha_def"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_def", true)),
					"hora_def"=>$this->input->post("hora_def", true),
					"ubigeo_def"=>$this->input->post("distrito14_1", true),
					"lugar_def"=>$this->input->post("lugar_def", true),
					"otro_def"=>$this->input->post("otro_def", true),
					"cuidador"=>$this->input->post("cuidador", true),
					"cuida_otro"=>$this->input->post("cuida_otro", true),
					"fecha_ini"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_ini", true)),
					"lugar_atencion"=>$this->input->post("lugar_atencion", true),
					"otro_lugar"=>$this->input->post("otro_lugar", true),
					"fecha_ate"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_ate", true)),
					"gravedad_tran"=>$this->input->post("gravedad_tran", true),
					"acepto_tran"=>$this->input->post("acepto_tran", true),
					"fecha_tra"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_tra", true)),
					"hora_tra"=>$this->input->post("hora_tra", true),
					"seguro"=>$this->input->post("seguro", true),
					"otro_seguro"=>$this->input->post("otro_seguro", true),
					"programa"=>$this->input->post("programa", true),
					"otro_programa"=>$this->input->post("otro_programa", true),
					"pentavalente"=>$this->input->post("pentavalente", true),
					"neumococo"=>$this->input->post("neumococo", true),
					"influenza"=>$this->input->post("influenza", true),
					"talla"=>$this->input->post("talla", true),
					"peso"=>$this->input->post("peso", true),
					"nutricion"=>$this->input->post("nutricion", true),
					"tipo"=>$this->input->post("tipo", true),
					"lactancia"=>$this->input->post("lactancia", true),
					"otro_lactancia"=>$this->input->post("otro_lactancia", true),
					"cred"=>$this->input->post("cred", true),
					"hospital"=>$this->input->post("hospital", true),
					"fecha_eme"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_eme", true)),
					"hora_eme"=>$this->input->post("hora_eme", true),
					"fecha_hos"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_hos", true)),
					"hora_hos"=>$this->input->post("hora_hos", true),
					"dx1"=>$this->input->post("dx1", true),
					"dx2"=>$this->input->post("dx2", true),
					"dx3"=>$this->input->post("dx3", true),
					"cbasica"=>$this->input->post("cbasica", true),
					"cintermedia"=>$this->input->post("cintermedia", true),
					"cterminal"=>$this->input->post("cterminal", true),
					"usuario"=>$usuario
				);
				
				$guardar = $this->fichas_model->ejecutarModificarNeumonias($data, $id);
				
				if($guardar)
				{
					$this->session->set_flashdata('exito', 'Informaci&oacute;n modificada con &eacute;xito.');
					redirect(site_url('modulos3/listarNeumonias'), 301);
				}else{
					$this->session->set_flashdata('error', 'No se modific&oacute; la informaci&oacute;n registrada.');
					redirect(site_url('modFichaNeum').$id, 301);
				}
            }
        }
		
		$modificar = $this->fichas_model->buscarNeumonias($id);
		
		if(sizeof($modificar)==0)
		{
			show_404();
		}
		
		$subr = "";
		$red = "";
		$mred = "";
		$est = "";
		
		$result = $this->login_model->buscarDiresa($modificar->diresa);
		$subr[''] = 'Seleccione ...';
		foreach ($result as $dato){
			$subr[$dato->codigo] = $dato->nombre;
		}

		$result = $this->login_model->buscarRedes($modificar->diresa);
		$red[''] = 'Seleccione ...';
		foreach ($result as $dato){
			$red[$dato->codigo] = $dato->nombre;
		}
		
		$result = $this->login_model->buscarMicroredes($modificar->diresa,$modificar->red);
		$mred[''] = 'Seleccione ...';
		foreach ($result as $dato){
			$mred[$dato->codigo] = $dato->nombre;
		}
		
		$result = $this->login_model->buscarEstablec($modificar->diresa,$modificar->red,$modificar->microred);
		$estc[''] = 'Seleccione ...';
		foreach ($result as $dato){
			$est[$dato->cod_est] = $dato->raz_soc;
		}
		
		$result = $this->mantenimiento_model->buscarProvincias(substr($modificar->ubigeo_res,0,2));
		$prov[''] = 'Seleccione ...';
		foreach ($result as $dato){
			$prov[$dato->ubigeo] = $dato->nombre;
		}
		
		$result = $this->mantenimiento_model->buscarDistritos(substr($modificar->ubigeo_res,0,4));
		$dist[''] = 'Seleccione ...';
		foreach ($result as $dato){
			$dist[$dato->ubigeo] = $dato->nombre;
		}
		
		$result = $this->mantenimiento_model->buscarProvincias(substr($modificar->ubigeo_def,0,2));
		$prov1[''] = 'Seleccione ...';
		foreach ($result as $dato){
			$prov1[$dato->ubigeo] = $dato->nombre;
		}
		
		$result = $this->mantenimiento_model->buscarDistritos(substr($modificar->ubigeo_def,0,4));
		$dist1[''] = 'Seleccione ...';
		foreach ($result as $dato){
			$dist1[$dato->ubigeo] = $dato->nombre;
		}
		
		$institucion = $this->llenaInstitucion($modificar->e_salud);
		
		$this->layout->view("modFichaNeum", compact("id", "modificar", "subr", "red", "mred", "est", "prov", "dist", "prov1", "dist1", "institucion"));
    }

    //Ver el registro de la ficha de chikungunya
    public function VerfichaNeum($id=null)
    {
		if(!$id)
		{
			show_404();
		}
		
		$modificar = $this->fichas_model->buscarNeumonias($id);
		
		if(sizeof($modificar)==0)
		{
			show_404();
		}
		
		$subr = "";
		$red = "";
		$mred = "";
		$est = "";
		
		$result = $this->login_model->buscarDiresa($modificar->diresa);
		$subr[''] = 'Seleccione ...';
		foreach ($result as $dato){
			$subr[$dato->codigo] = $dato->nombre;
		}

		$result = $this->login_model->buscarRedes($modificar->diresa);
		$red[''] = 'Seleccione ...';
		foreach ($result as $dato){
			$red[$dato->codigo] = $dato->nombre;
		}
		
		$result = $this->login_model->buscarMicroredes($modificar->diresa,$modificar->red);
		$mred[''] = 'Seleccione ...';
		foreach ($result as $dato){
			$mred[$dato->codigo] = $dato->nombre;
		}
		
		$result = $this->login_model->buscarEstablec($modificar->diresa,$modificar->red,$modificar->microred);
		$estc[''] = 'Seleccione ...';
		foreach ($result as $dato){
			$est[$dato->cod_est] = $dato->raz_soc;
		}
		
		$result = $this->mantenimiento_model->buscarProvincias(substr($modificar->ubigeo_res,0,2));
		$prov[''] = 'Seleccione ...';
		foreach ($result as $dato){
			$prov[$dato->ubigeo] = $dato->nombre;
		}
		
		$result = $this->mantenimiento_model->buscarDistritos(substr($modificar->ubigeo_res,0,4));
		$dist[''] = 'Seleccione ...';
		foreach ($result as $dato){
			$dist[$dato->ubigeo] = $dato->nombre;
		}
		
		$result = $this->mantenimiento_model->buscarProvincias(substr($modificar->ubigeo_def,0,2));
		$prov1[''] = 'Seleccione ...';
		foreach ($result as $dato){
			$prov1[$dato->ubigeo] = $dato->nombre;
		}
		
		$result = $this->mantenimiento_model->buscarDistritos(substr($modificar->ubigeo_def,0,4));
		$dist1[''] = 'Seleccione ...';
		foreach ($result as $dato){
			$dist1[$dato->ubigeo] = $dato->nombre;
		}
		
		$institucion = $this->llenaInstitucion($modificar->e_salud);
		
		$this->layout->view("verFichaNeum", compact("id", "modificar", "subr", "red", "mred", "est", "prov", "dist", "prov1", "dist1", "institucion"));
    }

	//Exporta la base de datos de la ficha de chikungunya
	public function exportarNeumonias()
	{
		date_default_timezone_set('America/Lima');
		
		switch($this->session->userdata("nivel"))
		{
			case '8':
			$where = array("e_salud"=>$nivelUsuario["establecimiento"]);
			
			$query = $this->db
				->where($where)
				->get("neumonias");
			break;
			case '7':
			$where = array("diresa"=>$this->session->userdata("diresa"), "red"=>$this->session->userdata("red"), "microred"=>$this->session->userdata("microred"));
			
			$query = $this->db
				->where($where)
				->get("neumonias");
			break;
			case '6':
			$where = array("diresa"=>$this->session->userdata("diresa"), "red"=>$this->session->userdata("red"));
			
			$query = $this->db
				->where($where)
				->get("neumonias");
			break;
			case '5':
			$where = array("diresa"=>$this->session->userdata("diresa"));
			
			$query = $this->db
				->where($where)
				->get("neumonias");
			break;
			default:
			$query = $this->db
				->get("neumonias");
			break;
		}

        if(!$query)
            return false;

		$headers = ''; // just creating the var for field headers to append to below
		$data = ''; // just creating the var for field data to append to below
		
		$fields = $query->list_fields();
		$col= 0;
		/*echo "<pre>";
		var_dump($fields); die;*/
		if ($query->num_rows() == 0) {
			echo '<p>La tabla al parecer no contiene datos.</p>';
		}else{
			foreach($fields as $field){
				$headers .= $field . "\t";
			}
		
			foreach ($query->result() as $row) {
				$line = '';
				foreach($row as $value) {
					if ((!isset($value)) OR ($value == "")) {
						$value = "\t";
					} else {
						$value = str_replace('"', '""', $value);
						$value = '"' . $value . '"' . "\t";
					}
					$line .= $value;
				}
				$data .= trim($line)."\n";
			}
			
			$data = str_replace("\r","",$data);
			
			header("Content-type: application/x-msdownload");
			header('Content-Disposition: attachment; filename="neumonias_'.date('dMy').'.xls"');
			echo "$headers\n$data";
		}

		redirect(site_url('neumonias/principal'), 301);

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

    //Llena la caja institucion de la ficha
	public function llenaInstitucion($id)
	{
		$filtro1 = $id;
										   
		$dato = substr($filtro1,6,1);
		
		switch($dato){
			case "A":
			$var = "MINSA";
			break;
			case "C":
			$var = "ESSALUD";
			break;
			case "D":
			$var = "FFAA/PNP";
			break;
			case "X":
			$var = "PRIVADOS";
			break;
		}
		
		return $var;
	}

    //Llena el combo Provincias
	public function llenaProvincias()
	{
		$filtro = $this->input->get('departamento');
		foreach ($this->mantenimiento_model->buscarProvincias($filtro) as $dato) {
			$prov[$dato->ubigeo] = $dato->nombre;
		}
		echo json_encode($prov);
	}

    //Llena el combo distrito
	public function llenaDistritos()
	{
		$filtro = $this->input->get('departamento');
		$filtro1 = $this->input->get('provincia');
		foreach ($this->mantenimiento_model->buscarDistritos($filtro, $filtro1) as $dato) {
			$dist[$dato->ubigeo] = $dato->nombre;
		}
		echo json_encode($dist);
	}

	function validar_fecha($str){
		if($str){
			$patron="/^(\d){2}\-(\d){2}\-(\d){4}$/i";
			if (preg_match($patron,$str)){
				return TRUE;
			}else{
				$this->form_validation->set_message('validar_fecha',
				'formato de fecha %s no v&aacute;lido');
				return FALSE;
			}
		}
	}

	// Callback para la eliminación de registro
	public function log_usuario_before_delete()
	{
		$this->mantenimiento_model->auditoriaOperador($this->session->userdata('usuario'), 'Eliminar Neumonias');		
		return true;
	}
}
