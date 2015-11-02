<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modulos2 extends CI_Controller {

    public function __construct()
    {
		parent::__construct();
        $this->layout->setLayout('template6_6');
        $this->layout->setTitle(":: NotiWeb :: S&iacute;filis Materna");
    }

    public function _example_output($output = null)
    {
		$usu = $this->session->userdata("usuario");
		
		$usuario = $usu['usuario'];
		
		$accion = 'Listar Sífilis';
			
		$this->login_model->auditoriaOperador($usuario, $accion);
			
		$this->layout->view('sifilis.php', $output);
    }

    public function index()
    {
		$this->_example_output((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
    }
	
	//Grocery Crud: Listado de Fichas del Módulo Sífilis
    public function listarSifilis()
    {
		$crud = new grocery_CRUD();

		$crud->set_table('sifilis');
		$crud->columns('registroId', 'codigo', 'ciex', 'madre_apenom', 'hijo_apenom', 
					   'fecha_not', 'semana', 'fecha_reg');
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
		$crud->display_as("registroId", "Item");
		$crud->display_as("madre_apenom", "Nombre de la madre");
		$crud->display_as("hijo_apenom", "Nombre del hijo(a)");
		$crud->display_as("fecha_not", "Notificaci&oacute;n");
		$crud->display_as("fecha_reg", "Registro");
	
		$crud->unset_add();
		$crud->unset_edit();
		$crud->unset_read();
		$crud->unset_export();
		$crud->unset_delete();
		
		$crud->add_action_peru('', '', 'listarCasos','add-icon');
		$crud->add_action('Eliminar Ficha', '', 'modulos2/DelfichaSif','delete-icon');
		$crud->add_action('Modificar Ficha', '', 'modulos2/ModfichaSif','edit-icon');
		$crud->add_action('Ver Ficha', '', 'modulos2/VerfichaSif','read-icon');
		$crud->add_action('Ficha de S&iacute;filis Cong&eacute;nita', base_url().'public/images/more.png', 'modulos2/listarCongenita');
		$output = $crud->render();

		$this->_example_output($output);
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
		$crud->columns('diagnostic', 'e_salud', 'apepat', 'apemat', 'nombres', 'dni');
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
			
			$crud->where('diagnostic','O98.1');
			$crud->or_where($or_where);
			break;
		}
		
		$crud->field_type('e_salud', 'dropdown', $est);
		$crud->display_as("e_salud", "Establecimiento");
		$crud->field_type('diagnostic', 'dropdown', $diagno);
		$crud->display_as("diagnostic", "Enfermedad");
		$crud->display_as("apepat", "Paterno");
		$crud->display_as("apemat", "Materno");
		$crud->display_as("fecha_not", "Notificaci&oacute;n");
		$crud->unset_add();
		$crud->unset_edit();
		$crud->unset_delete();
		$crud->unset_read();
		$crud->unset_print();
		$crud->unset_export();
		
		$crud->add_action('Registrar Ficha', '', 'modulos2/RegfichaSif','edit-icon');
		$output = $crud->render();

		$this->layout->view('listarCasos', $output);		
	}

	//Registra una nueca ficha de sífilis
    public function RegfichaSif($id=null)
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

			if ($this->form_validation->run("modulos2/materna")){
				$data = array
				(
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
					"edad_ges"=>$this->input->post("edad_ges", true),
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
					"contacto"=>$this->input->post("contacto", true),
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
					"edad_ges"=>$this->input->post("edad_ges", true),
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

				$guardar = $this->fichas_model->insertarSifilis($data);
			  	$guardar1 = $this->fichas_model->insertarSifilisMaterna($data1);
			  	$guardar2 = $this->fichas_model->insertarSifilisCongenita($data2);
			  }

			  if($guardar)
			  {
				  redirect(site_url('modulos2/listarSifilis'), 301);
			  }else{
				  redirect(site_url('modulos2/RegfichaSif'), 301);
			  }
		}

		$nivelUsuario = $this->session->userdata("nivel");
		
		$registro = $id;
		
        $this->layout->view("RegfichaSif", compact("nivelUsuario", "registro"));
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

			if($this->input->post("diagnostico", true) == "O98.1"){
				if ($this->form_validation->run("modulos2/materna")){
					$data = array
					(
						"codigo"=>$this->input->post("codigo", true),
						"ciex"=>$this->input->post("diagnostico", true),
						"madre_apenom"=>$this->input->post("madre_apenom", true),
						"hijo_apenom"=>$this->input->post("hijo_apenom", true),
						"establecimiento"=>$this->input->post("estab", true),
						"institucion"=>$this->input->post("insti", true),
						"categoria"=>$this->input->post("categoria", true),
						"diresa"=>$this->input->post("dir", true),
						"red"=>$this->input->post("rd", true),
						"microred"=>$this->input->post("mrd", true),
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
						"edad_ges"=>$this->input->post("edad_ges", true),
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
						"contacto"=>$this->input->post("contacto", true),
						"estadio"=>$this->input->post("estadio", true),
						"usuario"=>$usuario,
						"fecha_reg"=>date("Y-m-d")
					);
				}
			}
				
			if($this->input->post("diagnostico", true) == "A50"){
				if ($this->form_validation->run("modulos2/congenita")){
					$data = array
					(
						"codigo"=>$this->input->post("codigo", true),
						"ciex"=>$this->input->post("diagnostico", true),
						"madre_apenom"=>$this->input->post("madre_apenom", true),
						"hijo_apenom"=>$this->input->post("hijo_apenom", true),
						"establecimiento"=>$this->input->post("estab", true),
						"institucion"=>$this->input->post("insti", true),
						"categoria"=>$this->input->post("categoria", true),
						"diresa"=>$this->input->post("dir", true),
						"red"=>$this->input->post("rd", true),
						"microred"=>$this->input->post("mrd", true),
						"fecha_not"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_not", true)),
						"semana"=>$this->input->post("semana", true),
						"tiposMat"=>$tipo1,					
						"tiposCon"=>$tipo2,					
						"notificador"=>$this->input->post("notificador", true),			
						"usuario"=>$usuario,
						"fecha_reg"=>date("Y-m-d"),
						"notificante"=>$nivelUsuario["diresa"]
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
						"edad_ges"=>$this->input->post("edad_ges", true),
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
				}
				
				$guardar = $this->fichas_model->modificarSifilis($data, $id);
				
				if($this->input->post("diagnostico", true) == "O98.1"){
					$guardar1 = $this->fichas_model->modificarSifilisMaterna($data1, $this->input->post("codigo", true));
				}
				
				if($this->input->post("diagnostico", true) == "A50"){
					$guardar2 = $this->fichas_model->modificarSifilisCongenita($data2, $this->input->post("codigo", true));
				}
						
				if($guardar)
				{
					redirect(site_url('modulos2/listarSifilis'), 301);
				}else{
					redirect(site_url('ModfichaSif'), 301);
				}
				
			}
        }
		
		$modificar = $this->fichas_model->buscarSifilis($id);
			
		if(sizeof($modificar)==0)
		{
			redirect(site_url('modulos2/listarSifilis'), 301);
		}
		
		$modificar1 = $this->fichas_model->buscarSifilisMaterna($modificar->codigo);
		$modificar2 = $this->fichas_model->buscarSifilisCongenita($modificar->codigo);
		
		$establec_cong = $this->fichas_model->mostrarEstablec($modificar2->establec_par);
		
		$subr = "";
		$red = "";
		$mred = "";
		$est = "";
		
		$result = $this->login_model->buscarRedes($establec_cong->subregion);
		$red[''] = 'Seleccione ...';
		foreach ($result as $dato){
			$red[$dato->codigo] = $dato->nombre;
		}
		
		$result = $this->login_model->buscarMicroredes($establec_cong->subregion,$establec_cong->red);
		$mred[''] = 'Seleccione ...';
		foreach ($result as $dato){
			$mred[$dato->codigo] = $dato->nombre;
		}
		
		$result = $this->login_model->buscarEstablec($establec_cong->subregion,$establec_cong->red,$establec_cong->microred);
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
		
		$this->layout->view("ModfichaSif", compact('id', 'modificar', 'modificar1', 'modificar2', "tedad", "subr", "red", "mred", "est", "prov", "dist", "establec_cong"));
    }

    //Visualiza la ficha de sifilis para su exportación a PDF
    public function VerfichaSif($id=null)
    {
		if(!$id)
		{
			show_404();
		}
		
		$modificar = $this->fichas_model->buscarSifilis($id);
			
		if(sizeof($modificar)==0)
		{
			redirect(site_url('modulos2/listarSifilis'), 301);
		}
		
		$modificar1 = $this->fichas_model->buscarSifilisMaterna($modificar->codigo);
		$modificar2 = $this->fichas_model->buscarSifilisCongenita($modificar->codigo);
		
		$establec_cong = $this->mantenimiento_model->mostrarEstablec($modificar2->establec_par);
		
		$subr = "";
		$red = "";
		$mred = "";
		$est = "";
		
		$result = $this->login_model->buscarRedes($establec_cong->subregion);
		$red[''] = 'Seleccione ...';
		foreach ($result as $dato){
			$red[$dato->codigo] = $dato->nombre;
		}
		
		$result = $this->login_model->buscarMicroredes($establec_cong->subregion,$establec_cong->red);
		$mred[''] = 'Seleccione ...';
		foreach ($result as $dato){
			$mred[$dato->codigo] = $dato->nombre;
		}
		
		$result = $this->login_model->buscarEstablec($establec_cong->subregion,$establec_cong->red,$establec_cong->microred);
		$est[''] = 'Seleccione ...';
		foreach ($result as $dato){
			$est[$dato->cod_est] = $dato->raz_soc;
		}
		
		$result = $this->mantenimiento_model->buscarProvincias(substr($modificar1->residencia,0,2));
		$prov[''] = 'Seleccione ...';
		foreach ($result as $dato){
			$prov[$dato->ubigeo] = $dato->nombre;
		}
		
		$result = $this->mantenimiento_model->buscarDistritos(substr($modificar1->residencia,0,2), substr($modificar1->residencia,0,4));
		$dist[''] = 'Seleccione ...';
		foreach ($result as $dato){
			$dist[$dato->ubigeo] = $dato->nombre;
		}
		
		$this->layout->view("VerfichaSif", compact('id', 'modificar', 'modificar1', 'modificar2', "tedad", "subr", "red", "mred", "est", "prov", "dist", "establec_cong"));
    }

    //Eliminar la ficha de sifilis 
    public function DelfichaSif($id=null)
    {
		if(!$id)
		{
			show_404();
		}
		
		if($this->input->post()){
			$eliminar = $this->fichas_model->buscarSifilis($id);
			
			$this->fichas_model->eliminarSifilis($id, $eliminar->codigo);
				
			$this->listarSifilis();
		}

		$modificar = $this->fichas_model->buscarSifilis($id);
			
		if(sizeof($modificar)==0)
		{
			redirect(site_url('modulos2/listarSifilis'), 301);
		}
		
		$modificar1 = $this->fichas_model->buscarSifilisMaterna($modificar->codigo);
		$modificar2 = $this->fichas_model->buscarSifilisCongenita($modificar->codigo);
		
		$establec_cong = $this->mantenimiento_model->mostrarEstablec($modificar2->establec_par);
		
		$subr = "";
		$red = "";
		$mred = "";
		$est = "";
		
		$result = $this->login_model->buscarRedes($establec_cong->subregion);
		$red[''] = 'Seleccione ...';
		foreach ($result as $dato){
			$red[$dato->codigo] = $dato->nombre;
		}
		
		$result = $this->login_model->buscarMicroredes($establec_cong->subregion,$establec_cong->red);
		$mred[''] = 'Seleccione ...';
		foreach ($result as $dato){
			$mred[$dato->codigo] = $dato->nombre;
		}
		
		$result = $this->login_model->buscarEstablec($establec_cong->subregion,$establec_cong->red,$establec_cong->microred);
		$est[''] = 'Seleccione ...';
		foreach ($result as $dato){
			$est[$dato->cod_est] = $dato->raz_soc;
		}
		
		$result = $this->mantenimiento_model->buscarProvincias(substr($modificar1->residencia,0,2));
		$prov[''] = 'Seleccione ...';
		foreach ($result as $dato){
			$prov[$dato->ubigeo] = $dato->nombre;
		}
		
		$result = $this->mantenimiento_model->buscarDistritos(substr($modificar1->residencia,0,2), substr($modificar1->residencia,0,4));
		$dist[''] = 'Seleccione ...';
		foreach ($result as $dato){
			$dist[$dato->ubigeo] = $dato->nombre;
		}
		
		$this->layout->view("DelfichaSif", compact('id', 'modificar', 'modificar1', 'modificar2', "tedad", "subr", "red", "mred", "est", "prov", "dist", "establec_cong"));
	}

	//Exporta la base de datos de la ficha de chikungunya
	public function exportarSifilis()
	{
		date_default_timezone_set('America/Lima');
		
		$nivelUsuario = $this->session->userdata("nivel");
		
		switch($nivelUsuario)
		{
			case '8':
			$where = array("establecimiento"=>$nivelUsuario["establecimiento"]);
			
			$query = $this->db
			->select("sifilis.*, sifilis_materna.*, sifilis_congenita.*")
			->from("sifilis")
			->where($where)
			->join('sifilis_materna', 'sifilis.codigo=sifilis_materna.codigo', 'left')
			->join('sifilis_congenita', 'sifilis.codigo=sifilis_congenita.codigo', 'left')
			->get();
			break;
			case '7':
			$where = array("diresa"=>$nivelUsuario["diresa"], "red"=>$nivelUsuario["red"], "microred"=>$nivelUsuario["microred"]);
			
			$query = $this->db
			->select("sifilis.*, sifilis_materna.*, sifilis_congenita.*")
			->from("sifilis")
			->where($where)
			->join('sifilis_materna', 'sifilis.codigo=sifilis_materna.codigo', 'left')
			->join('sifilis_congenita', 'sifilis.codigo=sifilis_congenita.codigo', 'left')
			->get();
			break;
			case '6':
			$where = array("diresa"=>$nivelUsuario["diresa"], "red"=>$nivelUsuario["red"]);
			
			$query = $this->db
			->select("sifilis.*, sifilis_materna.*, sifilis_congenita.*")
			->from("sifilis")
			->where($where)
			->join('sifilis_materna', 'sifilis.codigo=sifilis_materna.codigo', 'left')
			->join('sifilis_congenita', 'sifilis.codigo=sifilis_congenita.codigo', 'left')
			->get();
			break;
			case '5':
			$where = array("diresa"=>$nivelUsuario["diresa"]);
			
			$query = $this->db
			->select("sifilis.*, sifilis_materna.*, sifilis_congenita.*")
			->from("sifilis")
			->where($where)
			->join('sifilis_materna', 'sifilis.codigo=sifilis_materna.codigo', 'left')
			->join('sifilis_congenita', 'sifilis.codigo=sifilis_congenita.codigo', 'left')
			->get();
			break;
			default:
			$query = $this->db
			->select("sifilis.*, sifilis_materna.*, sifilis_congenita.*")
			->from("sifilis")
			->join('sifilis_materna', 'sifilis.codigo=sifilis_materna.codigo', 'left')
			->join('sifilis_congenita', 'sifilis.codigo=sifilis_congenita.codigo', 'left')
			->get();
			break;
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

    //Llena la caja de categoria del establecimiento
	public function llenaCategoria()
	{
		$filtro1 = $this->input->get('establec');
										   
		$resultado = $this->fichas_model->buscarCategoria($filtro1);
		
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
