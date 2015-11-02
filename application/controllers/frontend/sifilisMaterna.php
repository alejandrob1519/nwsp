<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class sifilisMaterna extends CI_Controller {

    private $session_id;

	public function __construct()
    {
        parent::__construct();
        $this->layout->setLayout('template5_5');
        $this->layout->setTitle(":: NotiWeb :: Vigilancia Epidemiol&oacute;gica");
        $this->session_id = $this->session->userdata('usuario');
		date_default_timezone_set('America/Lima');
	}

	public function index()
	{
        if(!empty($this->session_id)){
			$acceso = $this->login_model->loginAccesoFichas($this->session->userdata('usuario'), '2');
			
			if(count($acceso) != 0){
            	redirect(site_url("sifilisMaterna/principal"), 301);
			}else{
	            $this->session->set_flashdata('error', 'No tiene acceso a la ficha epidemiológica elegida.');
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
			
			$accion = 'Sifilis Materna';
			
			$this->login_model->auditoriaOperador($session_id['usuario'], $accion);
			
            $this->layout->view("principal", compact("session_id", "menu"));
        }else{
			$accion = 'Error Sifilis Materna';
			
			$this->login_model->auditoriaOperador($this->input->post("usuario", true), $accion);
			
            $this->session->set_flashdata('ControllerMessage', 'Su sesi&oacute;n ha caducado, vuelva a ingresar.');
            redirect(site_url("index/principal"), 301);
        }
    }
	
	//Grocery Crud: Listado de Fichas del Módulo Sífilis
    public function listarSifilis()
    {
		$establecimiento = $this->mantenimiento_model->listarEstablecimiento();

		foreach($establecimiento as $dato){
			$est[$dato->cod_est] = $dato->raz_soc;
		}
		
		$enfermedad = $this->mantenimiento_model->listarDiagnostico();
		
		foreach($enfermedad as $dato){
			$diagno[$dato->cie_10] = $dato->diagno;
		}
		$crud = new grocery_CRUD();

		$crud->set_table('sifilis');
		$crud->columns('establecimiento', 'codigo', 'ciex', 'madre_apenom', 'hijo_apenom', 'fecha_not', 'semana', 'fecha_not');
		$crud->set_subject('S&iacute;filis Materna');
		
		$nivelUsuario = $this->session->userdata("nivel");
			
		switch($nivelUsuario){
			case '8':
			$where = array('establecimiento' =>  $this->session->userdata("establecimiento"));
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
		$crud->field_type('establecimiento', 'dropdown', $est);
		$crud->field_type('ciex', 'dropdown', $diagno);
		$crud->display_as("registroId", "Item");
		$crud->display_as("madre_apenom", "NOMBRE DE LA MADRE");
		$crud->display_as("hijo_apenom", "NOMBRE DEL HIJO");
		$crud->display_as("fecha_not", "NOTIFICACION");
		$crud->display_as("ciex", "ENFERMEDAD");
		$crud->display_as("codigo", "CODIGO");
		$crud->display_as("establecimiento", "ESTABLECIMIENTO");
		$crud->display_as("semana", "SEMANA");
	
		$crud->unset_add();
		$crud->unset_edit();
		$crud->unset_read();
		$crud->unset_export();
		$crud->unset_delete();
		$crud->unset_print();
		
		$crud->add_action('Eliminar Ficha', base_url().'assets/images/close.png', 'sifilisMaterna/DelfichaSif','borrar-icon');
		$crud->add_action('Modificar Ficha', '', 'sifilisMaterna/ModfichaSif','edit-icon');
		$output = $crud->render();

		$this->layout->view('listarMaterna', $output);		
    }

	//Grocery Crud: Listado de casos de sífilis notificados
    public function listarCasos()
    {
		$establecimiento = $this->mantenimiento_model->listarEstablecimiento();
		
		foreach($establecimiento as $dato){
			$est[$dato->cod_est] = $dato->raz_soc;
		}
		
		$diagnostico = $this->mantenimiento_model->listarDiagnostico();
		
		foreach($diagnostico as $dato){
			$diagno[$dato->cie_10] = $dato->diagno;
		}
		
		$crud = new grocery_CRUD();
		//$crud->set_theme("datatables");
		$crud->set_table('individual');
		$crud->columns('diagnostic', 'ano', 'semana', 'e_salud', 'apepat', 'apemat', 'nombres', 'dni', 'fecha_ini');
		$crud->set_subject('Ficha');
		
		$nivelUsuario = $this->session->userdata("nivel");
			
		switch($nivelUsuario){
			case '8':
			$where = array('diagnostic' => 'O98.1', 'e_salud' => $this->session->userdata("establecimiento"));
			$or_where = array('diagnostic' => 'A50');
			
			$crud->where($where);
			$crud->or_where($or_where);
			break;
			case '7':
			$where = array('diagnostic' => 'O98.1', 'microred' => $this->session->userdata("microred"), 'redes' =>  $this->session->userdata("red"), 'diresa' =>  $this->session->userdata("diresa"));
			$or_where = array('diagnostic' => 'A50');
			
			$crud->where($where);
			$crud->or_where($or_where);
			break;
			case '6':
			$where = array('diagnostic' => 'O98.1', 'redes' => $this->session->userdata("red"), 'diresa' =>  $this->session->userdata("diresa"));
			$or_where = array('diagnostic' => 'A50');
			
			$crud->where($where);
			$crud->or_where($or_where);
			break;
			case '5':
			$where = array('diagnostic' => 'O98.1', 'sub_reg_nt' => $this->session->userdata("diresa"));
			$or_where = array('diagnostic' => 'A50');
			
			$crud->where($where);
			$crud->or_where($or_where);
			break;
			default:
			$where = array('diagnostic' => 'O98.1');
			$or_where = array('diagnostic' => 'A50');
			
			$crud->where($where);
			$crud->or_where($or_where);
			break;
		}
		
		$crud->field_type('e_salud', 'dropdown', $est);
		$crud->display_as("e_salud", "Establecimiento");
		$crud->field_type('diagnostic', 'dropdown', $diagno);
		$crud->display_as("diagnostic", "Enfermedad");
		$crud->display_as("apepat", "Paterno");
		$crud->display_as("apemat", "Materno");
		$crud->display_as("fecha_ini", "Fecha");
		$crud->display_as("ano", "A&ntilde;o");
		$crud->order_by("ano, semana");
		$crud->unset_add();
		$crud->unset_edit();
		$crud->unset_delete();
		$crud->unset_read();
		$crud->unset_print();
		$crud->unset_export();
		
		$crud->add_action('Registrar Ficha', base_url().'public/images/anadir.png', 'sifilisMaterna/RegfichaSif','');
		$output = $crud->render();

		$this->layout->view('listarCasos', $output);		
	}

	//Registra una nueca ficha de sífilis
    public function RegfichaSif($id=null)
    {
        if($this->input->post()){
			$usu = $this->session->userdata("usuario");
			
			$usuario = $usu;
			
			$nivelUsuario = $this->session->userdata("nivel");
			
			if($this->input->post("sifilis1", true) == "on"){
				$tipo1 = "1";
			}else{
				$tipo1 = "0";
			}
			
			if($this->input->post("sifilis2", true) == "on"){
				$tipo2 = "1";
			}else{
				$tipo2 = "0";
			}
			
			if($this->input->post("desconocido_ini", true) == "on"){
				$desconocido_ini = "1";
			}else{
				$desconocido_ini = "0";
			}

			if($this->input->post("desconocido_con1", true) == "on"){
				$desconocido_con1 = "1";
			}else{
				$desconocido_con1 = "0";
			}

			if($this->input->post("motivo_no1", true) == "on"){
				$motivo_no1 = "1";
			}else{
				$motivo_no1 = "0";
			}

			if($this->input->post("motivo_no2", true) == "on"){
				$motivo_no2 = "1";
			}else{
				$motivo_no2 = "0";
			}

			if($this->input->post("motivo_no3", true) == "on"){
				$motivo_no3 = "1";
			}else{
				$motivo_no3 = "0";
			}

			if($this->input->post("motivo_no4", true) == "on"){
				$motivo_no4 = "1";
			}else{
				$motivo_no4 = "0";
			}

			if($this->input->post("desconocido_par", true) == "on"){
				$desconocido_par = "1";
			}else{
				$desconocido_par = "0";
			}

			if($this->input->post("domicilio", true) == "on"){
				$domicilio = "1";
			}else{
				$domicilio = "0";
			}

			if($this->input->post("desconocido_fac", true) == "on"){
				$desconocido_fac = "1";
			}else{
				$desconocido_fac = "0";
			}

			if($this->input->post("desconocido_nac", true) == "on"){
				$desconocido_nac = "1";
			}else{
				$desconocido_nac = "0";
			}

			if($this->input->post("desconocido_ges", true) == "on"){
				$desconocido_ges = "1";
			}else{
				$desconocido_ges = "0";
			}

			if($this->input->post("criterio1", true) == "on"){
				$criterio1 = "1";
			}else{
				$criterio1 = "0";
			}

			if($this->input->post("criterio2", true) == "on"){
				$criterio2 = "1";
			}else{
				$criterio2 = "0";
			}

			if($this->input->post("criterio3", true) == "on"){
				$criterio3 = "1";
			}else{
				$criterio3 = "0";
			}

			if($this->input->post("criterio4", true) == "on"){
				$criterio4 = "1";
			}else{
				$criterio4 = "0";
			}

			if($this->input->post("criterio5", true) == "on"){
				$criterio5 = "1";
			}else{
				$criterio5 = "0";
			}

			if($this->input->post("desconocido", true) == "on"){
				$desconocido = "1";
			}else{
				$desconocido = "0";
			}
			
			$data = array
			(
			 	"clave"=>$this->input->post("claveNoti", true),
				"codigo"=>$this->input->post("codigo", true),
				"ciex"=>$this->input->post("diagnostico", true),
				"madre_apenom"=>$this->input->post("madre_apenom", true),
				"hijo_apenom"=>$this->input->post("hijo_apenom", true),
				"diresa"=>$this->input->post("dir", true),
				"red"=>$this->input->post("rd", true),
				"microred"=>$this->input->post("mrd", true),
				"establecimiento"=>$this->input->post("estab", true),
				"institucion"=>$this->input->post("insti", true),
				"categoria"=>$this->input->post("categoria", true),
				"fecha_not"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_not", true)),
				"semana"=>$this->input->post("semana", true),
				"tiposMat"=>$tipo1,					
				"tiposCon"=>$tipo2,					
				"notificador"=>$this->input->post("notificador", true),			
				"usuario"=>$usuario,
				"fecha_reg"=>date("Y-m-d"),
				"notificante"=>$nivelUsuario["diresa"]
			);
			
			$data1 = array
			(
				"codigo"=>$this->input->post("codigo", true),
				"fecha_nac"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_nac", true)),
				"edad"=>$this->input->post("edad", true),
				"tipo_edad"=>$this->input->post("tedad", true),
				"pais"=>$this->input->post("pais", true),
				"residencia"=>$this->input->post("distrito", true),
				"localidad"=>$this->input->post("localidad", true),
				"fecha_ini"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_ini", true)),
				"desconocido_ini"=>$desconocido_ini,
				"atencion"=>$this->input->post("atencion", true),
				"fecha_con1"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_con1", true)),
				"desconocido_con1"=>$desconocido_con1,
				"edad_ges"=>$this->input->post("edad_ges_mat", true),
				"fecha_ntrep1"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_ntrep1", true)),
				"resultados_ntrep1"=>$this->input->post("resultados_ntrep1", true),
				"titulo_ntrep1"=>$this->input->post("titulo_ntrep1", true),
				"momento_ntrep1"=>$this->input->post("momento_ntrep1", true),
				"fecha_ntrep2"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_ntrep2", true)),
				"resultados_ntrep2"=>$this->input->post("resultados_ntrep2", true),
				"titulo_ntrep2"=>$this->input->post("titulo_ntrep2", true),
				"momento_ntrep2"=>$this->input->post("momento_ntrep2", true),
				"fecha_trep1"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_trep1", true)),
				"tipo_trep1"=>$this->input->post("tipo_trep1", true),
				"otra_trep1"=>$this->input->post("otra_trep1", true),
				"resultados_trep1"=>$this->input->post("resultados_trep1", true),
				"momento_trep1"=>$this->input->post("momento_trep1", true),
				"fecha_trep2"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_trep1", true)),
				"tipo_trep2"=>$this->input->post("tipo_trep1", true),
				"otra_trep2"=>$this->input->post("otra_trep1", true),
				"resultados_trep2"=>$this->input->post("resultados_trep1", true),
				"momento_trep2"=>$this->input->post("momento_trep1", true),
				"tratamiento"=>$this->input->post("tratamiento", true),
				"motivo_no1"=>$motivo_no1,
				"motivo_no2"=>$motivo_no2,
				"motivo_no3"=>$motivo_no3,
				"motivo_no4"=>$motivo_no4,
				"contacto"=>$this->input->post("contacto", true),
				"contactos"=>$this->input->post("contactos", true),
				"estadio"=>$this->input->post("estadio", true),
				"usuario"=>$usuario,
				"fecha_reg"=>date("Y-m-d")
			);

			$data2 = array
			(
				"codigo"=>$this->input->post("codigo", true),
				"fecha_par"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_par", true)),
				"desconocido_par"=>$desconocido_par,
				"establec_par"=>$this->input->post("establec", true),
				"establec_cat_par"=>$this->input->post("nivel_estab", true),
				"domicilio_par"=>$domicilio,
				"estado_vital"=>$this->input->post("estado_vital", true),
				"fecha_fac"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_fac", true)),
				"desconocido_fac"=>$desconocido_fac,
				"peso_nac"=>$this->input->post("peso_nac", true),
				"desconocido_nac"=>$desconocido_nac,
				"edad_ges"=>$this->input->post("edad_ges_con", true),
				"desconocido_edad"=>$desconocido_ges,
				"criterio1"=>$criterio1,
				"criterio2"=>$criterio2,
				"fecha_test"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_test", true)),
				"desconocido"=>$desconocido,
				"titulo_madre"=>$this->input->post("titulo_madre", true),
				"titulo_hijo"=>$this->input->post("titulo_hijo", true),
				"criterio3"=>$criterio3,
				"criterio4"=>$criterio4,
				"criterio5"=>$criterio5,
				"tratado"=>$this->input->post("tratado", true),
				"clasificacion"=>$this->input->post("clasificacion", true),
				"usuario"=>$usuario,
				"fecha_reg"=>date("Y-m-d")
			);

			$guardar = $this->mantenimiento_model->insertarSifilis($data);
			
			if($this->input->post("diagnostico") == "O98.1"){
				$guardar1 = $this->mantenimiento_model->insertarSifilisMaterna($data1);
			}
			
			if($this->input->post("diagnostico") == "A50"){
				$guardar1 = $this->mantenimiento_model->insertarSifilisMaterna($data1);
				$guardar2 = $this->mantenimiento_model->insertarSifilisCongenita($data2);
			}

			if($guardar)
			{
				$this->session->set_flashdata('exito', 'Informaci&oacute;n guardada con &eacute;xito.');
				redirect(site_url('sifilisMaterna/listarSifilis'), 301);
			}else{
				$this->session->set_flashdata('error', 'Error en la información registrada, verifique.');
				redirect(site_url('sifilisMaterna/RegfichaSif/'.$id), 301);
			}
		}

		if(!$id)
		{
			show_404();
		}

		$nivelUsuario = $this->session->userdata("nivel");
		
		$registro = $id;
		
		$datos = $this->mantenimiento_model->mostrarSifilis($registro);
		
		//combo Paises
		
		$pais = $this->mantenimiento_model->buscarPaises();

		$paises[''] = 'Seleccione ...';
		foreach ($pais as $dato){
			$paises[$dato->codigo] = $dato->nombre;
		}

		//combo Departamentos
		
		$depar = $this->mantenimiento_model->buscarDepartamentos();

		$departamento[''] = 'Seleccione ...';
		foreach ($depar as $dato){
			$departamento[$dato->ubigeo] = $dato->nombre;
		}
		
		$provincia = array(''=>'Seleccione...');
		$distrito = array(''=>'Seleccione...');
		
		//combo Provincias
		
		$prov = $this->mantenimiento_model->buscarProvincias(substr($caso->ubigeo,0,2));
	
		//$provincia[''] = 'Seleccione ...';
		foreach ($prov as $dato){
			$provincia[$dato->ubigeo] = $dato->nombre;
		}
		
		//combo Distrito
		
		$dist = $this->mantenimiento_model->buscarDistritos(substr($caso->ubigeo,0,4));
		
		$local = $this->mantenimiento_model->buscarLocalidad($caso->localcod);
	
		//$distrito[''] = 'Seleccione ...';
		foreach ($dist as $dato){
			$distrito[$dato->ubigeo] = $dato->nombre;
		}

		$this->layout->view("RegfichaSif", compact('nivelUsuario','datos','registro','paises','diresa','redes','microred','establec','departamento','provincia','distrito','local'));
    }

    //Modifica el registro de la ficha de sifilis
    public function ModfichaSif($id=null)
    {
		if(!$id)
		{
			show_404();
		}
		
        if($this->input->post()){
			$usu = $this->session->userdata("usuario");
			
			$usuario = $usu;
			
			$nivelUsuario = $this->session->userdata("nivel");
			
			if($this->input->post("sifilis1", true) == "on"){
				$tipo1 = "1";
			}else{
				$tipo1 = "0";
			}
			
			if($this->input->post("sifilis2", true) == "on"){
				$tipo2 = "1";
			}else{
				$tipo2 = "0";
			}
			
			if($this->input->post("sifilis1", true) == "on"){
				$tipo = "1";
			}elseif($this->input->post("sifilis2", true) == "on"){
				$tipo = "2";
			}

			if($this->input->post("desconocido_ini", true) == "on"){
				$desconocido_ini = "1";
			}else{
				$desconocido_ini = "0";
			}

			if($this->input->post("desconocido_con1", true) == "on"){
				$desconocido_con1 = "1";
			}else{
				$desconocido_con1 = "0";
			}

			if($this->input->post("motivo_no1", true) == "on"){
				$motivo_no1 = "1";
			}else{
				$motivo_no1 = "0";
			}

			if($this->input->post("motivo_no2", true) == "on"){
				$motivo_no2 = "1";
			}else{
				$motivo_no2 = "0";
			}

			if($this->input->post("motivo_no3", true) == "on"){
				$motivo_no3 = "1";
			}else{
				$motivo_no3 = "0";
			}

			if($this->input->post("motivo_no4", true) == "on"){
				$motivo_no4 = "1";
			}else{
				$motivo_no4 = "0";
			}

			if($this->input->post("desconocido_par", true) == "on"){
				$desconocido_par = "1";
			}else{
				$desconocido_par = "0";
			}

			if($this->input->post("domicilio", true) == "on"){
				$domicilio = "1";
			}else{
				$domicilio = "0";
			}

			if($this->input->post("desconocido_fac", true) == "on"){
				$desconocido_fac = "1";
			}else{
				$desconocido_fac = "0";
			}

			if($this->input->post("desconocido_nac", true) == "on"){
				$desconocido_nac = "1";
			}else{
				$desconocido_nac = "0";
			}

			if($this->input->post("desconocido_ges", true) == "on"){
				$desconocido_ges = "1";
			}else{
				$desconocido_ges = "0";
			}

			if($this->input->post("criterio1", true) == "on"){
				$criterio1 = "1";
			}else{
				$criterio1 = "0";
			}

			if($this->input->post("criterio2", true) == "on"){
				$criterio2 = "1";
			}else{
				$criterio2 = "0";
			}

			if($this->input->post("criterio3", true) == "on"){
				$criterio3 = "1";
			}else{
				$criterio3 = "0";
			}

			if($this->input->post("criterio4", true) == "on"){
				$criterio4 = "1";
			}else{
				$criterio4 = "0";
			}

			if($this->input->post("criterio5", true) == "on"){
				$criterio5 = "1";
			}else{
				$criterio5 = "0";
			}

			if($this->input->post("desconocido", true) == "on"){
				$desconocido = "1";
			}else{
				$desconocido = "0";
			}

			$data = array
			(
			 	"clave"=>$this->input->post("claveNoti", true),
				"codigo"=>$this->input->post("codigo", true),
				"ciex"=>$this->input->post("diagnostico", true),
				"madre_apenom"=>$this->input->post("madre_apenom", true),
				"hijo_apenom"=>$this->input->post("hijo_apenom", true),
				"diresa"=>$this->input->post("dir", true),
				"red"=>$this->input->post("rd", true),
				"microred"=>$this->input->post("mrd", true),
				"establecimiento"=>$this->input->post("estab", true),
				"institucion"=>$this->input->post("insti", true),
				"categoria"=>$this->input->post("categoria", true),
				"fecha_not"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_not", true)),
				"semana"=>$this->input->post("semana", true),
				"tiposMat"=>$tipo1,					
				"tiposCon"=>$tipo2,					
				"notificador"=>$this->input->post("notificador", true),			
				"usuario"=>$usuario,
				"fecha_reg"=>date("Y-m-d"),
				"notificante"=>$nivelUsuario["diresa"]
			);
			
			$data1 = array
			(
				"codigo"=>$this->input->post("codigo", true),
				"fecha_nac"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_nac", true)),
				"edad"=>$this->input->post("edad", true),
				"tipo_edad"=>$this->input->post("tedad", true),
				"pais"=>$this->input->post("pais", true),
				"residencia"=>$this->input->post("distrito", true),
				"localidad"=>$this->input->post("localidad", true),
				"fecha_ini"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_ini", true)),
				"desconocido_ini"=>$desconocido_ini,
				"atencion"=>$this->input->post("atencion", true),
				"fecha_con1"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_con1", true)),
				"desconocido_con1"=>$desconocido_con1,
				"edad_ges"=>$this->input->post("edad_ges_mat", true),
				"fecha_ntrep1"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_ntrep1", true)),
				"resultados_ntrep1"=>$this->input->post("resultados_ntrep1", true),
				"titulo_ntrep1"=>$this->input->post("titulo_ntrep1", true),
				"momento_ntrep1"=>$this->input->post("momento_ntrep1", true),
				"fecha_ntrep2"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_ntrep2", true)),
				"resultados_ntrep2"=>$this->input->post("resultados_ntrep2", true),
				"titulo_ntrep2"=>$this->input->post("titulo_ntrep2", true),
				"momento_ntrep2"=>$this->input->post("momento_ntrep2", true),
				"fecha_trep1"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_trep1", true)),
				"tipo_trep1"=>$this->input->post("tipo_trep1", true),
				"otra_trep1"=>$this->input->post("otra_trep1", true),
				"resultados_trep1"=>$this->input->post("resultados_trep1", true),
				"momento_trep1"=>$this->input->post("momento_trep1", true),
				"fecha_trep2"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_trep1", true)),
				"tipo_trep2"=>$this->input->post("tipo_trep1", true),
				"otra_trep2"=>$this->input->post("otra_trep1", true),
				"resultados_trep2"=>$this->input->post("resultados_trep1", true),
				"momento_trep2"=>$this->input->post("momento_trep1", true),
				"tratamiento"=>$this->input->post("tratamiento", true),
				"motivo_no1"=>$motivo_no1,
				"motivo_no2"=>$motivo_no2,
				"motivo_no3"=>$motivo_no3,
				"motivo_no4"=>$motivo_no4,
				"contacto"=>$this->input->post("contacto", true),
				"contactos"=>$this->input->post("contactos", true),
				"estadio"=>$this->input->post("estadio", true),
				"usuario"=>$usuario,
				"fecha_reg"=>date("Y-m-d")
			);

			$data2 = array
			(
				"codigo"=>$this->input->post("codigo", true),
				"fecha_par"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_par", true)),
				"desconocido_par"=>$desconocido_par,
				"establec_par"=>$this->input->post("establec", true),
				"establec_cat_par"=>$this->input->post("nivel_estab", true),
				"domicilio_par"=>$domicilio,
				"estado_vital"=>$this->input->post("estado_vital", true),
				"fecha_fac"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_fac", true)),
				"desconocido_fac"=>$desconocido_fac,
				"peso_nac"=>$this->input->post("peso_nac", true),
				"desconocido_nac"=>$desconocido_nac,
				"edad_ges"=>$this->input->post("edad_ges_con", true),
				"desconocido_edad"=>$desconocido_ges,
				"criterio1"=>$criterio1,
				"criterio2"=>$criterio2,
				"fecha_test"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_test", true)),
				"desconocido"=>$desconocido,
				"titulo_madre"=>$this->input->post("titulo_madre", true),
				"titulo_hijo"=>$this->input->post("titulo_hijo", true),
				"criterio3"=>$criterio3,
				"criterio4"=>$criterio4,
				"criterio5"=>$criterio5,
				"tratado"=>$this->input->post("tratado", true),
				"clasificacion"=>$this->input->post("clasificacion", true),
				"usuario"=>$usuario,
				"fecha_reg"=>date("Y-m-d")
			);
			
			$guardar = $this->mantenimiento_model->modificarSifilis($data, $id);
			
			if($this->input->post("diagnostico", true) == "O98.1"){
				$guardar1 = $this->mantenimiento_model->modificarSifilisMaterna($data1, $this->input->post("codigo", true));
			}
			
			if($this->input->post("diagnostico", true) == "A50"){
				$guardar2 = $this->mantenimiento_model->modificarSifilisCongenita($data2, $this->input->post("codigo", true));
			}
					
			if($guardar)
			{
				$this->session->set_flashdata('exito', 'Informaci&oacute;n actualizada con &eacute;xito.');
				redirect(site_url('sifilisMaterna/listarSifilis'), 301);
			}else{
				$this->session->set_flashdata('error', 'No se ha actualizado la información, verifique.');
				redirect(site_url('ModfichaSif'), 301);
			}
        }
		
		$modificar = $this->mantenimiento_model->buscarSifilis($id);
			
		$datos = $this->mantenimiento_model->mostrarSifilisNotificado($modificar->clave);
		
		if(sizeof($modificar)==0)
		{
			$this->session->set_flashdata('error', 'No hay informaci&oacute;n para modificar, verifique.');
			redirect(site_url('sifilisMaterna/listarSifilis'), 301);
		}
		
		$modificar1 = $this->mantenimiento_model->buscarSifilisMaternaFicha($modificar->codigo);
		$modificar2 = $this->mantenimiento_model->buscarSifilisCongenita($modificar->codigo);
		
		$establec_cong = $this->mantenimiento_model->mostrarEstablec($modificar2->establec_par);
		
		//combo Paises
		
		$pais = $this->mantenimiento_model->buscarPaises();

		$paises[''] = 'Seleccione ...';
		foreach ($pais as $dato){
			$paises[$dato->codigo] = $dato->nombre;
		}
		
		//combo Departamentos
		
		$depar = $this->mantenimiento_model->buscarDepartamentos();

		$departamento[''] = 'Seleccione ...';
		foreach ($depar as $dato){
			$departamento[$dato->ubigeo] = $dato->nombre;
		}
		
		$provincia = array(''=>'Seleccione...');
		$distrito = array(''=>'Seleccione...');
		
		//combo Provincias
		
		$prov = $this->mantenimiento_model->buscarProvincias(substr($modificar1->residencia,0,2));
	
		//$provincia[''] = 'Seleccione ...';
		foreach ($prov as $dato){
			$provincia[$dato->ubigeo] = $dato->nombre;
		}
		
		//combo Distrito
		
		$dist = $this->mantenimiento_model->buscarDistritos(substr($modificar1->residencia,0,4));
		
		$local = $this->mantenimiento_model->buscarLocalidad($caso->localcod);
	
		//$distrito[''] = 'Seleccione ...';
		foreach ($dist as $dato){
			$distrito[$dato->ubigeo] = $dato->nombre;
		}

		$subr = "";
		$red = "";
		$mred = "";
		$est = "";
		
		$result = $this->mantenimiento_model->buscarRedes($establec_cong->subregion);
		$red[''] = 'Seleccione ...';
		foreach ($result as $dato){
			$red[$dato->codigo] = $dato->nombre;
		}
		
		$result = $this->mantenimiento_model->buscarMicroredes($establec_cong->subregion,$establec_cong->red);
		$mred[''] = 'Seleccione ...';
		foreach ($result as $dato){
			$mred[$dato->codigo] = $dato->nombre;
		}
		
		$result = $this->mantenimiento_model->buscarEstablec($establec_cong->subregion,$establec_cong->red,$establec_cong->microred);
		$est[''] = 'Seleccione ...';
		foreach ($result as $dato){
			$est[$dato->cod_est] = $dato->raz_soc;
		}
		
		$result = $this->mantenimiento_model->buscarProvincias(substr($modificar1->residencia,0,2));
		$prov[''] = 'Seleccione ...';
		foreach ($result as $dato){
			$prov[$dato->ubigeo] = $dato->nombre;
		}
		
		$result = $this->mantenimiento_model->buscarDistritos(substr($modificar1->residencia,0,4));
		$dist[''] = 'Seleccione ...';
		foreach ($result as $dato){
			$dist[$dato->ubigeo] = $dato->nombre;
		}
		
		$this->layout->view("ModfichaSif", compact('id', 'modificar', 'modificar1', 'modificar2', "tedad", "subr", 
												   "red", "mred", "est", "prov", "dist", "establec_cong", "datos", 
												   "paises",'departamento','provincia','distrito'));
    }

    //Eliminar la ficha de sifilis 
    public function DelfichaSif($id)
    {
		$modificar = $this->mantenimiento_model->buscarSifilis($id);
		
		$succes = $this->mantenimiento_model->eliminarSifilis($modificar->codigo);

		if($succes == true){
			$this->session->set_flashdata('exito', 'Informaci&oacute;n eliminada con &eacute;xito.');
			redirect(site_url('sifilisMaterna/listarSifilis'), 301);
		}else{
			$this->session->set_flashdata('error', 'No se pudo eliminar la informaci&oacute;n.');
			redirect(site_url('sifilisMaterna/listarSifilis'), 301);
		}
	}

	//Exporta la base de datos de la ficha de chikungunya
	public function exportarSifilis()
	{
		date_default_timezone_set('America/Lima');
		
		if($this->input->post()){
			if($this->input->post('establec') != ""){		
				$where = array("establecimiento"=>$this->input->post('establec'), "substr(fecha_not,0,4)"=>$this->input->post('anoExport'));
			
				$query = $this->db
				->select("sifilis.clave, sifilis.codigo, sifilis.ciex, sifilis.madre_apenom, sifilis.hijo_apenom,
						 sifilis.establecimiento, sifilis.institucion, sifilis.categoria, sifilis.diresa, sifilis.red,
						 sifilis.microred, sifilis.fecha_not, sifilis.semana, sifilis.tiposMat, sifilis.tiposCon,
						 sifilis.usuario as usuario_enc, sifilis.fecha_reg as registro_enc, sifilis.notificador, 
						 sifilis.notificante, sifilis_materna.codigo as codigo_mat, sifilis_materna.fecha_nac, 
						 sifilis_materna.edad, sifilis_materna.tipo_edad, sifilis_materna.pais, sifilis_materna.residencia,
						 sifilis_materna.localidad, sifilis_materna.fecha_ini, sifilis_materna.desconocido_ini, 
						 sifilis_materna.atencion, sifilis_materna.fecha_con1, sifilis_materna.desconocido_con1,
						 sifilis_materna.edad_ges, sifilis_materna.fecha_ntrep1, sifilis_materna.resultados_ntrep1, 
						 sifilis_materna.titulo_ntrep1, sifilis_materna.momento_ntrep1, sifilis_materna.fecha_ntrep2,
						 sifilis_materna.resultados_ntrep2, sifilis_materna.titulo_ntrep2, sifilis_materna.momento_ntrep2,
						 sifilis_materna.fecha_trep1, sifilis_materna.tipo_trep1, sifilis_materna.otra_trep1, 
						 sifilis_materna.resultados_trep1, sifilis_materna.momento_trep1, sifilis_materna.fecha_trep2,
						 sifilis_materna.tipo_trep2, sifilis_materna.otra_trep2, sifilis_materna.resultados_trep2,
						 sifilis_materna.momento_trep2, sifilis_materna.tratamiento, sifilis_materna.motivo_no1, 
						 sifilis_materna.motivo_no2, sifilis_materna.motivo_no3, sifilis_materna.motivo_no4, 
						 sifilis_materna.contacto, sifilis_materna.contactos, sifilis_materna.estadio, 
						 sifilis_materna.usuario as usuario_mat, sifilis_materna.fecha_reg as registro_mat, 
						 sifilis_congenita.codigo as codigo_con, sifilis_congenita.fecha_par, sifilis_congenita.desconocido_par,
						 sifilis_congenita.establec_par, sifilis_congenita.establec_cat_par, sifilis_congenita.domicilio_par,
						 sifilis_congenita.estado_vital, sifilis_congenita.fecha_fac, sifilis_congenita.desconocido_fac,
						 sifilis_congenita.peso_nac, sifilis_congenita.desconocido_nac, sifilis_congenita.edad_ges,
						 sifilis_congenita.desconocido_edad, sifilis_congenita.criterio1, sifilis_congenita.criterio2,
						 sifilis_congenita.fecha_test, sifilis_congenita.desconocido, sifilis_congenita.titulo_madre,
						 sifilis_congenita.titulo_hijo, sifilis_congenita.criterio3, sifilis_congenita.criterio4,
						 sifilis_congenita.criterio5, sifilis_congenita.tratado, sifilis_congenita.clasificacion,
						 sifilis_congenita.usuario as usuario_con, sifilis_congenita.fecha_reg as registro_con")
				->from("sifilis")
				->where($where)
				->join('sifilis_materna', 'sifilis.codigo=sifilis_materna.codigo', 'left')
				->join('sifilis_congenita', 'sifilis.codigo=sifilis_congenita.codigo', 'left')
				->get();
			}else if($this->input->post('microred') != "" && $this->input->post('establec') == ""){
				$where = array("diresa"=>$this->input->post('diresa'), "red"=>$this->input->post('redes'), "microred"=>$this->input->post('microred'), "substr(fecha_not,0,4)"=>$this->input->post('anoExport'));
			
				$query = $this->db
				->select("sifilis.clave, sifilis.codigo, sifilis.ciex, sifilis.madre_apenom, sifilis.hijo_apenom,
						 sifilis.establecimiento, sifilis.institucion, sifilis.categoria, sifilis.diresa, sifilis.red,
						 sifilis.microred, sifilis.fecha_not, sifilis.semana, sifilis.tiposMat, sifilis.tiposCon,
						 sifilis.usuario as usuario_enc, sifilis.fecha_reg as registro_enc, sifilis.notificador, 
						 sifilis.notificante, sifilis_materna.codigo as codigo_mat, sifilis_materna.fecha_nac, 
						 sifilis_materna.edad, sifilis_materna.tipo_edad, sifilis_materna.pais, sifilis_materna.residencia,
						 sifilis_materna.localidad, sifilis_materna.fecha_ini, sifilis_materna.desconocido_ini, 
						 sifilis_materna.atencion, sifilis_materna.fecha_con1, sifilis_materna.desconocido_con1,
						 sifilis_materna.edad_ges, sifilis_materna.fecha_ntrep1, sifilis_materna.resultados_ntrep1, 
						 sifilis_materna.titulo_ntrep1, sifilis_materna.momento_ntrep1, sifilis_materna.fecha_ntrep2,
						 sifilis_materna.resultados_ntrep2, sifilis_materna.titulo_ntrep2, sifilis_materna.momento_ntrep2,
						 sifilis_materna.fecha_trep1, sifilis_materna.tipo_trep1, sifilis_materna.otra_trep1, 
						 sifilis_materna.resultados_trep1, sifilis_materna.momento_trep1, sifilis_materna.fecha_trep2,
						 sifilis_materna.tipo_trep2, sifilis_materna.otra_trep2, sifilis_materna.resultados_trep2,
						 sifilis_materna.momento_trep2, sifilis_materna.tratamiento, sifilis_materna.motivo_no1, 
						 sifilis_materna.motivo_no2, sifilis_materna.motivo_no3, sifilis_materna.motivo_no4, 
						 sifilis_materna.contacto, sifilis_materna.contactos, sifilis_materna.estadio, 
						 sifilis_materna.usuario as usuario_mat, sifilis_materna.fecha_reg as registro_mat, 
						 sifilis_congenita.codigo as codigo_con, sifilis_congenita.fecha_par, sifilis_congenita.desconocido_par,
						 sifilis_congenita.establec_par, sifilis_congenita.establec_cat_par, sifilis_congenita.domicilio_par,
						 sifilis_congenita.estado_vital, sifilis_congenita.fecha_fac, sifilis_congenita.desconocido_fac,
						 sifilis_congenita.peso_nac, sifilis_congenita.desconocido_nac, sifilis_congenita.edad_ges,
						 sifilis_congenita.desconocido_edad, sifilis_congenita.criterio1, sifilis_congenita.criterio2,
						 sifilis_congenita.fecha_test, sifilis_congenita.desconocido, sifilis_congenita.titulo_madre,
						 sifilis_congenita.titulo_hijo, sifilis_congenita.criterio3, sifilis_congenita.criterio4,
						 sifilis_congenita.criterio5, sifilis_congenita.tratado, sifilis_congenita.clasificacion,
						 sifilis_congenita.usuario as usuario_con, sifilis_congenita.fecha_reg as registro_con")
				->from("sifilis")
				->where($where)
				->join('sifilis_materna', 'sifilis.codigo=sifilis_materna.codigo', 'left')
				->join('sifilis_congenita', 'sifilis.codigo=sifilis_congenita.codigo', 'left')
				->get();
			}else if($this->input->post('redes') != "" && $this->input->post('microred') == "" && $this->input->post('establec') == ""){
				$where = array("diresa"=>$this->input->post('diresa'), "red"=>$this->input->post('redes'), "substr(fecha_not,0,4)"=>$this->input->post('anoExport'));
			
				$query = $this->db
				->select("sifilis.clave, sifilis.codigo, sifilis.ciex, sifilis.madre_apenom, sifilis.hijo_apenom,
						 sifilis.establecimiento, sifilis.institucion, sifilis.categoria, sifilis.diresa, sifilis.red,
						 sifilis.microred, sifilis.fecha_not, sifilis.semana, sifilis.tiposMat, sifilis.tiposCon,
						 sifilis.usuario as usuario_enc, sifilis.fecha_reg as registro_enc, sifilis.notificador, 
						 sifilis.notificante, sifilis_materna.codigo as codigo_mat, sifilis_materna.fecha_nac, 
						 sifilis_materna.edad, sifilis_materna.tipo_edad, sifilis_materna.pais, sifilis_materna.residencia,
						 sifilis_materna.localidad, sifilis_materna.fecha_ini, sifilis_materna.desconocido_ini, 
						 sifilis_materna.atencion, sifilis_materna.fecha_con1, sifilis_materna.desconocido_con1,
						 sifilis_materna.edad_ges, sifilis_materna.fecha_ntrep1, sifilis_materna.resultados_ntrep1, 
						 sifilis_materna.titulo_ntrep1, sifilis_materna.momento_ntrep1, sifilis_materna.fecha_ntrep2,
						 sifilis_materna.resultados_ntrep2, sifilis_materna.titulo_ntrep2, sifilis_materna.momento_ntrep2,
						 sifilis_materna.fecha_trep1, sifilis_materna.tipo_trep1, sifilis_materna.otra_trep1, 
						 sifilis_materna.resultados_trep1, sifilis_materna.momento_trep1, sifilis_materna.fecha_trep2,
						 sifilis_materna.tipo_trep2, sifilis_materna.otra_trep2, sifilis_materna.resultados_trep2,
						 sifilis_materna.momento_trep2, sifilis_materna.tratamiento, sifilis_materna.motivo_no1, 
						 sifilis_materna.motivo_no2, sifilis_materna.motivo_no3, sifilis_materna.motivo_no4, 
						 sifilis_materna.contacto, sifilis_materna.contactos, sifilis_materna.estadio, 
						 sifilis_materna.usuario as usuario_mat, sifilis_materna.fecha_reg as registro_mat, 
						 sifilis_congenita.codigo as codigo_con, sifilis_congenita.fecha_par, sifilis_congenita.desconocido_par,
						 sifilis_congenita.establec_par, sifilis_congenita.establec_cat_par, sifilis_congenita.domicilio_par,
						 sifilis_congenita.estado_vital, sifilis_congenita.fecha_fac, sifilis_congenita.desconocido_fac,
						 sifilis_congenita.peso_nac, sifilis_congenita.desconocido_nac, sifilis_congenita.edad_ges,
						 sifilis_congenita.desconocido_edad, sifilis_congenita.criterio1, sifilis_congenita.criterio2,
						 sifilis_congenita.fecha_test, sifilis_congenita.desconocido, sifilis_congenita.titulo_madre,
						 sifilis_congenita.titulo_hijo, sifilis_congenita.criterio3, sifilis_congenita.criterio4,
						 sifilis_congenita.criterio5, sifilis_congenita.tratado, sifilis_congenita.clasificacion,
						 sifilis_congenita.usuario as usuario_con, sifilis_congenita.fecha_reg as registro_con")
				->from("sifilis")
				->where($where)
				->join('sifilis_materna', 'sifilis.codigo=sifilis_materna.codigo', 'left')
				->join('sifilis_congenita', 'sifilis.codigo=sifilis_congenita.codigo', 'left')
				->get();
			}else if($this->input->post('diresa') != "" && $this->input->post('redes') == "" && $this->input->post('microred') == "" && $this->input->post('establec') == ""){
				$where = array("diresa"=>$this->input->post('diresa'), "substr(fecha_not,0,4)"=>$this->input->post('anoExport'));
			
				$query = $this->db
				->select("sifilis.clave, sifilis.codigo, sifilis.ciex, sifilis.madre_apenom, sifilis.hijo_apenom,
						 sifilis.establecimiento, sifilis.institucion, sifilis.categoria, sifilis.diresa, sifilis.red,
						 sifilis.microred, sifilis.fecha_not, sifilis.semana, sifilis.tiposMat, sifilis.tiposCon,
						 sifilis.usuario as usuario_enc, sifilis.fecha_reg as registro_enc, sifilis.notificador, 
						 sifilis.notificante, sifilis_materna.codigo as codigo_mat, sifilis_materna.fecha_nac, 
						 sifilis_materna.edad, sifilis_materna.tipo_edad, sifilis_materna.pais, sifilis_materna.residencia,
						 sifilis_materna.localidad, sifilis_materna.fecha_ini, sifilis_materna.desconocido_ini, 
						 sifilis_materna.atencion, sifilis_materna.fecha_con1, sifilis_materna.desconocido_con1,
						 sifilis_materna.edad_ges, sifilis_materna.fecha_ntrep1, sifilis_materna.resultados_ntrep1, 
						 sifilis_materna.titulo_ntrep1, sifilis_materna.momento_ntrep1, sifilis_materna.fecha_ntrep2,
						 sifilis_materna.resultados_ntrep2, sifilis_materna.titulo_ntrep2, sifilis_materna.momento_ntrep2,
						 sifilis_materna.fecha_trep1, sifilis_materna.tipo_trep1, sifilis_materna.otra_trep1, 
						 sifilis_materna.resultados_trep1, sifilis_materna.momento_trep1, sifilis_materna.fecha_trep2,
						 sifilis_materna.tipo_trep2, sifilis_materna.otra_trep2, sifilis_materna.resultados_trep2,
						 sifilis_materna.momento_trep2, sifilis_materna.tratamiento, sifilis_materna.motivo_no1, 
						 sifilis_materna.motivo_no2, sifilis_materna.motivo_no3, sifilis_materna.motivo_no4, 
						 sifilis_materna.contacto, sifilis_materna.contactos, sifilis_materna.estadio, 
						 sifilis_materna.usuario as usuario_mat, sifilis_materna.fecha_reg as registro_mat, 
						 sifilis_congenita.codigo as codigo_con, sifilis_congenita.fecha_par, sifilis_congenita.desconocido_par,
						 sifilis_congenita.establec_par, sifilis_congenita.establec_cat_par, sifilis_congenita.domicilio_par,
						 sifilis_congenita.estado_vital, sifilis_congenita.fecha_fac, sifilis_congenita.desconocido_fac,
						 sifilis_congenita.peso_nac, sifilis_congenita.desconocido_nac, sifilis_congenita.edad_ges,
						 sifilis_congenita.desconocido_edad, sifilis_congenita.criterio1, sifilis_congenita.criterio2,
						 sifilis_congenita.fecha_test, sifilis_congenita.desconocido, sifilis_congenita.titulo_madre,
						 sifilis_congenita.titulo_hijo, sifilis_congenita.criterio3, sifilis_congenita.criterio4,
						 sifilis_congenita.criterio5, sifilis_congenita.tratado, sifilis_congenita.clasificacion,
						 sifilis_congenita.usuario as usuario_con, sifilis_congenita.fecha_reg as registro_con")
				->from("sifilis")
				->where($where)
				->join('sifilis_materna', 'sifilis.codigo=sifilis_materna.codigo', 'left')
				->join('sifilis_congenita', 'sifilis.codigo=sifilis_congenita.codigo', 'left')
				->get();
			}else{
				$where = array("substr(fecha_not,0,4)"=>$this->input->post('anoExport'));
				
				$query = $this->db
				->select("sifilis.clave, sifilis.codigo, sifilis.ciex, sifilis.madre_apenom, sifilis.hijo_apenom,
						 sifilis.establecimiento, sifilis.institucion, sifilis.categoria, sifilis.diresa, sifilis.red,
						 sifilis.microred, sifilis.fecha_not, sifilis.semana, sifilis.tiposMat, sifilis.tiposCon,
						 sifilis.usuario as usuario_enc, sifilis.fecha_reg as registro_enc, sifilis.notificador, 
						 sifilis.notificante, sifilis_materna.codigo as codigo_mat, sifilis_materna.fecha_nac, 
						 sifilis_materna.edad, sifilis_materna.tipo_edad, sifilis_materna.pais, sifilis_materna.residencia,
						 sifilis_materna.localidad, sifilis_materna.fecha_ini, sifilis_materna.desconocido_ini, 
						 sifilis_materna.atencion, sifilis_materna.fecha_con1, sifilis_materna.desconocido_con1,
						 sifilis_materna.edad_ges, sifilis_materna.fecha_ntrep1, sifilis_materna.resultados_ntrep1, 
						 sifilis_materna.titulo_ntrep1, sifilis_materna.momento_ntrep1, sifilis_materna.fecha_ntrep2,
						 sifilis_materna.resultados_ntrep2, sifilis_materna.titulo_ntrep2, sifilis_materna.momento_ntrep2,
						 sifilis_materna.fecha_trep1, sifilis_materna.tipo_trep1, sifilis_materna.otra_trep1, 
						 sifilis_materna.resultados_trep1, sifilis_materna.momento_trep1, sifilis_materna.fecha_trep2,
						 sifilis_materna.tipo_trep2, sifilis_materna.otra_trep2, sifilis_materna.resultados_trep2,
						 sifilis_materna.momento_trep2, sifilis_materna.tratamiento, sifilis_materna.motivo_no1, 
						 sifilis_materna.motivo_no2, sifilis_materna.motivo_no3, sifilis_materna.motivo_no4, 
						 sifilis_materna.contacto, sifilis_materna.contactos, sifilis_materna.estadio, 
						 sifilis_materna.usuario as usuario_mat, sifilis_materna.fecha_reg as registro_mat, 
						 sifilis_congenita.codigo as codigo_con, sifilis_congenita.fecha_par, sifilis_congenita.desconocido_par,
						 sifilis_congenita.establec_par, sifilis_congenita.establec_cat_par, sifilis_congenita.domicilio_par,
						 sifilis_congenita.estado_vital, sifilis_congenita.fecha_fac, sifilis_congenita.desconocido_fac,
						 sifilis_congenita.peso_nac, sifilis_congenita.desconocido_nac, sifilis_congenita.edad_ges,
						 sifilis_congenita.desconocido_edad, sifilis_congenita.criterio1, sifilis_congenita.criterio2,
						 sifilis_congenita.fecha_test, sifilis_congenita.desconocido, sifilis_congenita.titulo_madre,
						 sifilis_congenita.titulo_hijo, sifilis_congenita.criterio3, sifilis_congenita.criterio4,
						 sifilis_congenita.criterio5, sifilis_congenita.tratado, sifilis_congenita.clasificacion,
						 sifilis_congenita.usuario as usuario_con, sifilis_congenita.fecha_reg as registro_con")
				->from("sifilis")
				->where($where)
				->join('sifilis_materna', 'sifilis.codigo=sifilis_materna.codigo', 'left')
				->join('sifilis_congenita', 'sifilis.codigo=sifilis_congenita.codigo', 'left')
				->get();
			}
		

			if(!$query)
				return false;
	
			$objPHPExcel= new PHPExcel();
			$objPHPExcel->getProperties()->setTitle("export")->setDescription("none");
			$objPHPExcel->setActiveSheetIndex(0);
			
			$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial');
			$objPHPExcel->getDefaultStyle()->getFont()->setSize(12);
			
			$fields = $query->list_fields();
			$col= 0;
			foreach($fields as $field)
			{
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $field);
				$col++;
			}
	
			$row= 2;
			foreach($query->result() as$data)
			{
				$col= 0;
				foreach($fields as $field)
				{
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data->$field);
					$col++;
				}
				$row++;
			}
			$objPHPExcel->setActiveSheetIndex(0);
	
		   
	
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="sifilis_'.date('dMy').'.xls"');
			header('Cache-Control: max-age=0');
			$objWriter->save('php://output');
	
			redirect(site_url('sifilis/principal'), 301);
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

		$this->layout->view("exportar",compact('diresa','redes','microred','establec'));
	}

    //Llena la caja de categoria del establecimiento
	public function llenaCategoria()
	{
		$filtro1 = $this->input->get('establec');
										   
		$resultado = $this->fichas_model->buscarCategoria($filtro1);
		
		$var = $resultado->categoria;
		
		echo json_encode($var);
	}

    //Llena la caja de categoria del establecimiento
	public function buscaCategoria()
	{
		$filtro1 = $this->input->get('eess');
		
		$resultado = $this->mantenimiento_model->buscaCategoria($filtro1);
		
		$var = $resultado->categoria;
		
		echo json_encode($var);
	}

	//Valida las fechas registradas
	function validar_fecha($str){
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

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */