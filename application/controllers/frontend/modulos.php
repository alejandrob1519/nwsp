<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modulos extends CI_Controller {

    public function __construct()
    {
		parent::__construct();
        $this->layout->setLayout('template4_4');
        $this->layout->setTitle(":: NotiWeb :: Chikungunya");
		date_default_timezone_set('America/Lima');

		if($this->session->userdata("usuario") == ''){
			redirect(site('login'));
		}
    }

    public function _example_output($output = null)
    {
		$usu = $this->session->userdata("usuario");
		
		$usuario = $usu['usuario'];
		
		$accion = 'Listar Chikungunya';
			
		$this->login_model->auditoriaOperador($usuario, $accion);
			
		$this->layout->view('chikungunya.php', $output);
    }

    public function _notificados_output($output = null)
    {
		$usu = $this->session->userdata("usuario");
		
		$usuario = $usu['usuario'];
		
		$accion = 'Listar Notificados Chikungunya';
			
		$this->login_model->auditoriaOperador($usuario, $accion);
			
		$this->layout->view('listarCasos.php', $output);
    }

    public function index()
    {
		$this->_example_output((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
		$this->_notificados_output((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
    }
	
	//Grocery Crud: Listado de Fichas del Módulo Chikungunya
    public function listarChikungunya()
    {
		$crud = new grocery_CRUD();

		$crud->set_table('chikungunya');
		$crud->columns('registroId', 'semana', 'paterno', 'materno', 'nombres', 'dni', 'notificacion', 'fecha_inv');
		$crud->set_subject('Ficha');
		
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

		$crud->display_as("paterno", "Apellido Paterno");
		$crud->display_as("materno", "Apellido Materno");
		$crud->display_as("fecha_inv", "Investigaci&oacute;n");
	
		$crud->unset_add();
		$crud->unset_edit();
		$crud->unset_read();
		$crud->unset_export();
		//$crud->unset_print();
		
		$crud->add_action_peru('', '', 'listarCasos','add-icon');
		$crud->add_action('Modificar Ficha', '', 'modulos/ModfichaChik','edit-icon');
		//$crud->add_action('Ver Ficha', '', 'modulos/VerfichaChik','read-icon');
		$output = $crud->render();

		$this->_example_output($output);
    }

	//Grocery Crud: Listado de casos de sífilis notificados
    public function listarCasos()
    {
		$nivelUsuario = $this->session->userdata("nivel");
			
    	$enfermedad = array('diagnostic'=>'A92.0');
    	$enfermedad1 = array('diagnostic'=>'A92.5');
    	$tipo = array('C'=>'Confirmado', 'P'=>'Probable', 'D'=>'Descartado', 'S'=>'Sospechoso');

		$est = $this->frontend_model->listaEstablec();
		
		$estab = array();
		
		foreach($est as $dato)
		{
			$estab[$dato->cod_est] = $dato->raz_soc;
		}

		$crud = new grocery_CRUD();

		$crud->set_table('individual');
		//$crud->set_theme('datatables');
		$crud->columns('semana', 'diagnostic', 'tipo_dx', 'e_salud', 'ubigeo', 'apepat', 'apemat', 'nombres', 'dni', 'fecha_inv');
		$crud->set_subject('Ficha');
		
		switch($nivelUsuario){
			case '8':
			$where = array('e_salud' =>  $this->session->userdata("establecimiento"));
			$crud->where($where);
			break;
			case '7':
			$where = array('microred' =>  $this->session->userdata("microred"), 'red' =>  $this->session->userdata("red"), 'sub_reg_nt' =>  $this->session->userdata("diresa"));
			$crud->where($where);
			break;
			case '6':
			$where = array('red' =>  $this->session->userdata("red"), 'sub_reg_nt' =>  $this->session->userdata("diresa"));
			$crud->where($where);
			break;
			case '5':
			$where = array('sub_reg_nt' => $this->session->userdata("diresa"));
			$crud->where($where);
			break;
		}
		
		$crud->where($enfermedad);
		$crud->or_where($enfermedad1);
		$crud->display_as("apepat", "Ap. Paterno");
		$crud->display_as("apemat", "Ap. Materno");
		$crud->display_as("ubigeo", "Distrito");
		$crud->display_as("diagnostic", "Enfermedad");
		$crud->display_as("e_salud", "Establecimiento");
		$crud->display_as("fecha_inv", "Investigaci&oacute;n");
		$crud->set_relation('ubigeo', 'distrito', 'nombre');
		$crud->set_relation('diagnostic', 'diagno', 'diagno');
		$crud->field_type('e_salud','dropdown',$estab); 
		$crud->field_type('tipo_dx','dropdown',$tipo); 
		
		$crud->unset_add();
		$crud->unset_edit();
		$crud->unset_read();
		$crud->unset_export();
		$crud->unset_delete();
		$crud->unset_print();
		
		$crud->add_action('Registrar Ficha', base_url().'assets/images/more.png', 'modulos/RegfichaChik','');

		$output1 = $crud->render();

		$this->_notificados_output($output1);
    }

	//Registra una nueva ficha de chikungunya
    public function RegfichaChik($id=null)
    {
		if($id == ""){
			redirect('listarCasos', 301);
		}
		
        if($this->input->post()){
			$usu = $this->session->userdata("usuario");
			
			$usuario = $usu;
			
			$nivelUsuario = $this->session->userdata("nivel");

			$establec = $this->input->post("estab");
			$microred = $this->input->post("mrd");
			$red = $this->input->post("rd");
			$diresa = $this->input->post("dir");

			$clasifica = array();
			$procede = array();

			$clasifica = $this->input->post("clasifica");
			$procede = $this->input->post("procede");

			$sospechoso = $confirmado = $probable = $descartado = $sospechosoG = $confirmadoG = $probableG = $descartadoG = 0;
			
			for($i=0; $i <= count($clasifica); $i++){
				if($clasifica[$i] == 'sospechoso'){
					$sospechoso = "1";
				}
				if($clasifica[$i] == 'confirmado'){
					$confirmado = "1";
				}
				if($clasifica[$i] == 'probable'){
					$sospechoso = "1";
				}
				if($clasifica[$i] == 'descartado'){
					$descartado = "1";
				}
				if($clasifica[$i] == 'sospechosoG'){
					$sospechosoG = "1";
				}
				if($clasifica[$i] == 'confirmadoG'){
					$confirmadoG = "1";
				}
				if($clasifica[$i] == 'probableG'){
					$probableG = "1";
				}
				if($clasifica[$i] == 'descartadoG'){
					$descartadoG = "1";
				}
			}

			$autoctono = $nacional = $importado = 0;

			for($i=0; $i <= count($procede); $i++){
				if($procede[$i] == 'autoctono'){
					$autoctono = "1";
				}
				if($procede[$i] == 'nacional'){
					$nacional = "1";
				}
				if($procede[$i] == 'importado'){
					$importado = "1";
				}
			}

			if($this->input->post("sexo", true) == "MASCULINO"){
				$sexo = "1";
			}else{
				$sexo = "2";
			}
			
			$tedad = substr($this->input->post("tipo_edad"),0,1);
			
			if($tedad == "A"){
				$tipo_edad = "1";
			}
			
			if($tedad == "M"){
				$tipo_edad = "2";
			}
			
			if($tedad == "D"){
				$tipo_edad = "3";
			}

			$data = array
			(
				"semana"=>$this->input->post("semana", true),
				"fecha_inv"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_inv", true)),
				"diresa"=>$diresa,
				"red"=>$red,
				"microred"=>$microred,
				"establecimiento"=>$establec,
				"categoria"=>$this->input->post("categoria", true),
				"historia"=>$this->input->post("historia", true),
				"telefono"=>$this->input->post("telefono", true),
				"paterno"=>$this->input->post("paterno", true),
				"materno"=>$this->input->post("materno", true),
				"nombres"=>$this->input->post("nombres", true),
				"dni"=>$this->input->post("dni", true),
				"fecha_nac"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_nac", true)),
				"edad"=>$this->input->post("edad", true),
				"tipo_edad"=>$tipo_edad,
				"sexo"=>$sexo,
				"pais"=>$this->input->post("pais", true),
				"residencia"=>$this->input->post("distrito", true),
				"localidad"=>$this->input->post("localidad", true),
				"direccion"=>$this->input->post("direccion", true),
				"ocupacion"=>$this->input->post("ocupacion", true),
				"telefono"=>$this->input->post("telefono", true),
				"pais14_1"=>$this->input->post("pais14_1", true),
				"ubigeo14_1"=>$this->input->post("distrito14_1", true),
				"localidad14_1"=>$this->input->post("localidad14_1", true),
				"direccion14_1"=>$this->input->post("direccion14_1", true),
				"antecedentes"=>$this->input->post("antecedentes", true),
				"comorbilidad"=>$this->input->post("comorbilidad", true),
				"gestante"=>$this->input->post("gestante", true),
				"conoce_personas"=>$this->input->post("conoce_personas", true),
				"fecha_sin"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_sin", true)),
				"fecha_mue"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_mue", true)),
				"fiebre"=>$this->input->post("fiebre", true),
				"poliartralgias"=>$this->input->post("poliartralgias", true),
				"artritis_manos"=>$this->input->post("artritis_manos", true),
				"artritis_pies"=>$this->input->post("artritis_pies", true),
				"artritis_tobillos"=>$this->input->post("artritis_tobillos", true),
				"artritis_otros"=>$this->input->post("artritis_otros", true),
				"otro_artritis"=>$this->input->post("otro_artritis", true),
				"cefalea"=>$this->input->post("cefalea", true),
				"mialgias"=>$this->input->post("mialgias", true),
				"dolor_espalda"=>$this->input->post("dolor_espalda", true),
				"nauseas"=>$this->input->post("nauseas", true),
				"vomitos"=>$this->input->post("vomitos", true),
				"rash"=>$this->input->post("rash", true),
				"otro"=>$this->input->post("otro", true),
				"otro_sintoma"=>$this->input->post("otro_sintoma", true),
				"fecha_cult"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_cult", true)),
				"fecha_resul"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_resul", true)),
				"cultivo"=>$this->input->post("cultivo", true),
				"fecha_ser1"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_ser1", true)),
				"igm1"=>$this->input->post("igm1", true),
				"igg1"=>$this->input->post("igg1", true),
				"resultado1"=>$this->input->post("resultado1", true),
				"fecha_res1"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_res1", true)),
				"fecha_ser2"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_ser2", true)),
				"igm2"=>$this->input->post("igm2", true),
				"igg2"=>$this->input->post("igg2", true),
				"resultado2"=>$this->input->post("resultado2", true),
				"fecha_res2"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_res2", true)),
				"fecha_pcr"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_pcr", true)),
				"positivo"=>$this->input->post("positivo", true),
				"fecha_res3"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_res3", true)),
				"fecha_hos"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_hos", true)),
				"alta"=>$this->input->post("alta", true),
				"referido"=>$this->input->post("referido", true),
				"fallecido"=>$this->input->post("fallecido", true),
				"fecha_def"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_def", true)),
				"sospechoso"=>$sospechoso,
				"probable"=>$probable,
				"confirmado"=>$confirmado,
				"descartado"=>$descartado,
				"sospechosoG"=>$sospechosoG,
				"probableG"=>$probableG,
				"confirmadoG"=>$confirmadoG,
				"descartadoG"=>$descartadoG,
				"autoctono"=>$autoctono,
				"nacional"=>$nacional,
				"importado"=>$importado,
				"observaciones"=>$this->input->post("observaciones", true),
				"investigador"=>$this->input->post("investigador", true),
				"cargo"=>$this->input->post("cargo", true),
				"telef"=>$this->input->post("telefonos", true),
				"correo"=>$this->input->post("correo", true),
				"usuario"=>$usuario,
				"notificacion"=>$this->input->post('notificacion')
			);
			
			$guardar = $this->fichas_model->insertarChikungunya($data);
			
			if($guardar)
			{
				$this->session->set_flashdata('exito', 'Informaci&oacute;n guardada con &eacute;xito.');
				redirect(site_url('modulos/listarChikungunya'), 301);
			}else{
				$this->session->set_flashdata('error', 'No se guard&oacute; la informaci&oacute;n registrada.');
				redirect(site_url('RegfichaChik'), 301);
			}
        }
       
		$nivelUsuario = $this->session->userdata("nivel");

		$registro = $id;
		
        $this->layout->view("RegfichaChik", compact("nivelUsuario", "registro"));
    }

    //Modifica el registro de la ficha de chikungunya
    public function ModfichaChik($id=null)
    {
		if(!$id)
		{
			show_404();
		}
		
        if($this->input->post()){
			$usu = $this->session->userdata("usuario");
			
			$usuario = $usu;
			
			$nivelUsuario = $this->session->userdata("nivel");
			
			$establec = $this->input->post("estab");
			$microred = $this->input->post("mrd");
			$red = $this->input->post("rd");
			$diresa = $this->input->post("dir");

			$clasifica = array();
			$procede = array();

			$clasifica = $this->input->post("clasifica");
			$procede = $this->input->post("procede");

			$sospechoso = $confirmado = $probable = $descartado = $sospechosoG = $confirmadoG = $probableG = $descartadoG = 0;

			for($i=0; $i <= count($clasifica); $i++){
				if($clasifica[$i] == 'sospechoso'){
					$sospechoso = "1";
				}
				if($clasifica[$i] == 'confirmado'){
					$confirmado = "1";
				}
				if($clasifica[$i] == 'probable'){
					$sospechoso = "1";
				}
				if($clasifica[$i] == 'descartado'){
					$descartado = "1";
				}
				if($clasifica[$i] == 'sospechosoG'){
					$sospechosoG = "1";
				}
				if($clasifica[$i] == 'confirmadoG'){
					$confirmadoG = "1";
				}
				if($clasifica[$i] == 'probableG'){
					$probableG = "1";
				}
				if($clasifica[$i] == 'descartadoG'){
					$descartadoG = "1";
				}
			}

			$autoctono = $nacional = $importado = 0;

			for($i=0; $i <= count($procede); $i++){
				if($procede[$i] == 'autoctono'){
					$autoctono = "1";
				}
				if($procede[$i] == 'nacional'){
					$nacional = "1";
				}
				if($procede[$i] == 'importado'){
					$importado = "1";
				}
			}

			$data = array
			(
				"semana"=>$this->input->post("semana", true),
				"fecha_not"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_not", true)),
				"fecha_inv"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_inv", true)),
				"diresa"=>$diresa,
				"red"=>$red,
				"microred"=>$microred,
				"establecimiento"=>$establec,
				"categoria"=>$this->input->post("categoria", true),
				"historia"=>$this->input->post("historia", true),
				"telefono"=>$this->input->post("telefono", true),
				"paterno"=>$this->input->post("paterno", true),
				"materno"=>$this->input->post("materno", true),
				"nombres"=>$this->input->post("nombres", true),
				"dni"=>$this->input->post("dni", true),
				"fecha_nac"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_nac", true)),
				"edad"=>$this->input->post("edad", true),
				"tipo_edad"=>$this->input->post("tipo_edad", true),
				"sexo"=>$this->input->post("sexo", true),
				"pais"=>$this->input->post("pais", true),
				"residencia"=>$this->input->post("distrito", true),
				"localidad"=>$this->input->post("localidad", true),
				"direccion"=>$this->input->post("direccion", true),
				"pais14_1"=>$this->input->post("pais14_1", true),
				"ubigeo14_1"=>$this->input->post("distrito14_1", true),
				"localidad14_1"=>$this->input->post("localidad14_1", true),
				"direccion14_1"=>$this->input->post("direccion14_1", true),
				"antecedentes"=>$this->input->post("antecedentes", true),
				"comorbilidad"=>$this->input->post("comorbilidad", true),
				"gestante"=>$this->input->post("gestante", true),
				"conoce_personas"=>$this->input->post("conoce_personas", true),
				"fecha_sin"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_sin", true)),
				"fecha_mue"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_mue", true)),
				"fiebre"=>$this->input->post("fiebre", true),
				"poliartralgias"=>$this->input->post("poliartralgias", true),
				"artritis_manos"=>$this->input->post("artritis_manos", true),
				"artritis_pies"=>$this->input->post("artritis_pies", true),
				"artritis_tobillos"=>$this->input->post("artritis_tobillos", true),
				"artritis_otros"=>$this->input->post("artritis_otros", true),
				"otro_artritis"=>$this->input->post("otro_artritis", true),
				"cefalea"=>$this->input->post("cefalea", true),
				"mialgias"=>$this->input->post("mialgias", true),
				"dolor_espalda"=>$this->input->post("dolor_espalda", true),
				"nauseas"=>$this->input->post("nauseas", true),
				"vomitos"=>$this->input->post("vomitos", true),
				"rash"=>$this->input->post("rash", true),
				"otro"=>$this->input->post("otro", true),
				"otro_sintoma"=>$this->input->post("otro_sintoma", true),
				"fecha_cult"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_cult", true)),
				"fecha_resul"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_resul", true)),
				"cultivo"=>$this->input->post("cultivo", true),
				"fecha_ser1"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_ser1", true)),
				"igm1"=>$this->input->post("igm1", true),
				"igg1"=>$this->input->post("igg1", true),
				"resultado1"=>$this->input->post("resultado1", true),
				"fecha_res1"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_res1", true)),
				"fecha_ser2"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_ser2", true)),
				"igm2"=>$this->input->post("igm2", true),
				"igg2"=>$this->input->post("igg2", true),
				"resultado2"=>$this->input->post("resultado2", true),
				"fecha_res2"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_res2", true)),
				"fecha_pcr"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_pcr", true)),
				"positivo"=>$this->input->post("positivo", true),
				"fecha_res3"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_res3", true)),
				"fecha_hos"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_hos", true)),
				"alta"=>$this->input->post("alta", true),
				"fecha_alt"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_alt", true)),
				"referido"=>$this->input->post("referido", true),
				"fecha_ref"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_ref", true)),
				"fallecido"=>$this->input->post("fallecido", true),
				"fecha_def"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_def", true)),
				"sospechoso"=>$sospechoso,
				"probable"=>$probable,
				"confirmado"=>$confirmado,
				"descartado"=>$descartado,
				"sospechosoG"=>$sospechosoG,
				"probableG"=>$probableG,
				"confirmadoG"=>$confirmadoG,
				"descartadoG"=>$descartadoG,
				"autoctono"=>$autoctono,
				"nacional"=>$nacional,
				"importado"=>$importado,
				"observaciones"=>$this->input->post("observaciones", true),
				"investigador"=>$this->input->post("investigador", true),
				"cargo"=>$this->input->post("cargo", true),
				"telef"=>$this->input->post("telefonos", true),
				"correo"=>$this->input->post("correo", true),
				"usuario"=>$usuario,
				"notificacion"=>$this->input->post('notificacion')
			);
			
			$guardar = $this->fichas_model->ejecutarModificarChikungunya($data, $id);
					
			if($guardar)
			{
				$this->session->set_flashdata('exito', 'Informaci&oacute;n modificada con &eacute;xito.');
				redirect(site_url('modulos/listarChikungunya'), 301);
			}else{
				$this->session->set_flashdata('error', 'No se modific&oacute; la informaci&oacute;n registrada.');
				redirect(site_url('ModfichaChik').$id, 301);
			}
        }
		
		$modificar = $this->fichas_model->buscarChikungunya($id);
			
		if(sizeof($modificar)==0)
		{
			show_404();
		}
		
		$tedad[''] = 'Seleccione ...';
		$tedad['1'] = "A&ntilde;os";
		$tedad['2'] = "Meses";
		$tedad['3'] = "D&iacute;as";

		$sex[''] = 'Seleccione ...';
		$sex['1'] = "Masculino";
		$sex['2'] = "Femenino";
		
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
		
		$result = $this->mantenimiento_model->buscarProvincias(substr($modificar->residencia,0,2));
		$prov[''] = 'Seleccione ...';
		foreach ($result as $dato){
			$prov[$dato->ubigeo] = $dato->nombre;
		}
		
		$result = $this->mantenimiento_model->buscarDistritos(substr($modificar->residencia,0,4));
		$dist[''] = 'Seleccione ...';
		foreach ($result as $dato){
			$dist[$dato->ubigeo] = $dato->nombre;
		}
		
		$result = $this->mantenimiento_model->buscarProvincias(substr($modificar->ubigeo14_1,0,2));
		$prov1[''] = 'Seleccione ...';
		foreach ($result as $dato){
			$prov1[$dato->ubigeo] = $dato->nombre;
		}
		
		$result = $this->mantenimiento_model->buscarDistritos(substr($modificar->ubigeo14_1,0,4));
		$dist1[''] = 'Seleccione ...';
		foreach ($result as $dato){
			$dist1[$dato->ubigeo] = $dato->nombre;
		}
		
		$this->layout->view("ModfichaChik", compact('id', 'modificar', "tedad", "sex", "subr", "red", "mred", "est", "prov", "dist", "prov1", "dist1", "institucion"));
    }

    //Visualiza la ficha de chikungunya para su exportación a PDF
    public function VerfichaChik($id=null)
    {
		if(!$id)
		{
			show_404();
		}
		
		$modificar = $this->fichas_model->buscarChikungunya($id);
			
		if(sizeof($modificar)==0)
		{
			show_404();
		}
		
		$tedad[''] = 'Seleccione ...';
		$tedad['1'] = "A&ntilde;os";
		$tedad['2'] = "Meses";
		$tedad['3'] = "D&iacute;as";

		$sex[''] = 'Seleccione ...';
		$sex['1'] = "Masculino";
		$sex['2'] = "Femenino";
		
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
		
		$dato = substr($modificar->establecimiento,6,1);
		
		switch($dato){
			case "A":
			$institucion = "MINSA";
			break;
			case "C":
			$institucion = "ESSALUD";
			break;
			case "D":
			$institucion = "FFAA/PNP";
			break;
			case "X":
			$institucion = "PRIVADOS";
			break;
		}

		$result = $this->mantenimiento_model->buscarProvincias(substr($modificar->residencia,0,2));
		$prov[''] = 'Seleccione ...';
		foreach ($result as $dato){
			$prov[$dato->ubigeo] = $dato->nombre;
		}
		
		$result = $this->mantenimiento_model->buscarDistritos(substr($modificar->residencia,0,2), substr($modificar->residencia,0,4));
		$dist[''] = 'Seleccione ...';
		foreach ($result as $dato){
			$dist[$dato->ubigeo] = $dato->nombre;
		}
		
		$result = $this->mantenimiento_model->buscarProvincias(substr($modificar->ubigeo14_1,0,2));
		$prov1[''] = 'Seleccione ...';
		foreach ($result as $dato){
			$prov1[$dato->ubigeo] = $dato->nombre;
		}
		
		$result = $this->mantenimiento_model->buscarDistritos(substr($modificar->ubigeo14_1,0,2), substr($modificar->ubigeo14_1,0,4));
		$dist1[''] = 'Seleccione ...';
		foreach ($result as $dato){
			$dist1[$dato->ubigeo] = $dato->nombre;
		}
		
		$result = $this->mantenimiento_model->buscarProvincias(substr($modificar->ubigeo14_2,0,2));
		$prov2[''] = 'Seleccione ...';
		foreach ($result as $dato){
			$prov2[$dato->ubigeo] = $dato->nombre;
		}
		
		$result = $this->mantenimiento_model->buscarDistritos(substr($modificar->ubigeo14_2,0,2), substr($modificar->ubigeo14_2,0,4));
		$dist2[''] = 'Seleccione ...';
		foreach ($result as $dato){
			$dist2[$dato->ubigeo] = $dato->nombre;
		}
		
		$this->layout->view("VerfichaChik", compact('id', 'modificar', "tedad", "sex", "subr", "red", "mred", "est", "prov", "dist", "prov1", "dist1", "prov2", "dist2", "institucion"));
	}

	//Exporta la base de datos de la ficha de chikungunya
	public function exportarChikungunya()
	{
		if($this->input->post()){
			$sql = "SELECT semana, fecha_not, fecha_inv, c.nombre as diresa, d.nombre as red, e.nombre as microred,
			b.raz_soc as establecimiento, a.categoria, institucion, historia, paterno, materno, nombres, 
			dni, fecha_nac,edad,
			(case tipo_edad when 1 then 'Años' when 2 then 'Meses' when 3 then 'Días' end) as tipo_edad,
			(case sexo when 1 then 'Masculino' when 2 then 'Femenino' end) as sexo, 
			f.nombre as pais, h.nombre as departamento_res,i.nombre as provincia_res, j.nombre as distrito_res, 
			localidad, direccion as direccion_res, ocupacion, telefono, g.nombre as pais14_1, k.nombre as departamento14_1, 
			l.nombre as provincia14_1, m.nombre as distrito14_1, localidad14_1,direccion14_1, 
			(case antecedentes when '' then '' when 1 then 'Si' when 2 then 'No' when 3 then 'Ignorado' end) as antecedentes,
			gestante, fecha_sin as fecha_ini, fecha_mue,
			(case conoce_personas when '' then '' when 1 then 'Si' when 2 then 'No' when 3 then 'Ignorado' end) as conoce_personas,
			(case fiebre when '' then '' when 1 then 'Si' when 2 then 'No' when 3 then 'Ignorado' end) as fiebre,
			(case poliartralgias when '' then '' when 1 then 'Si' when 2 then 'No' when 3 then 'Ignorado' end) as poliartralgias,
			(case artritis_manos when '' then '' when 1 then 'Si' when 2 then 'No' when 3 then 'Ignorado' end) as artritis_manos,
			(case artritis_pies when '' then '' when 1 then 'Si' when 2 then 'No' when 3 then 'Ignorado' end) as artritis_pies,
			(case artritis_tobillos when '' then '' when 1 then 'Si' when 2 then 'No' when 3 then 'Ignorado' end) as artritis_tobillos,
			(case artritis_otros when '' then '' when 1 then 'Si' when 2 then 'No' when 3 then 'Ignorado' end) as artritis_otros,
			otro_artritis,(case cefalea when '' then '' when 1 then 'Si' when 2 then 'No' when 3 then 'Ignorado' end) as cefalea,
			(case mialgias when '' then '' when 1 then 'Si' when 2 then 'No' when 3 then 'Ignorado' end) as mialgias,
			(case dolor_espalda when '' then '' when 1 then 'Si' when 2 then 'No' when 3 then 'Ignorado' end) as dolor_espalda,
			(case nauseas when '' then '' when 1 then 'Si' when 2 then 'No' when 3 then 'Ignorado' end) as nauseas,
			(case vomitos when '' then '' when 1 then 'Si' when 2 then 'No' when 3 then 'Ignorado' end) as vomitos,
			(case rash when '' then '' when 1 then 'Si' when 2 then 'No' when 3 then 'Ignorado' end) as rash,
			(case otro when '' then '' when 1 then 'Si' when 2 then 'No' when 3 then 'Ignorado' end) as otro, otro_sintoma,
			fecha_cult, fecha_resul,(case cultivo when '' then '' when 1 then 'Si' when 2 then 'No' when 3 then 'Ignorado' end) as cultivo,
			fecha_ser1, igm1, igg1, resultado1, fecha_res1, fecha_ser2, igm2, igg2, resultado2, fecha_res2, fecha_pcr,
			(case positivo when '' then '' when 1 then 'Si' when 2 then 'No' when 3 then 'Ignorado' end) as reactivo,fecha_res3,
			fecha_hos,(case alta when '' then '' when 1 then 'Si' when 2 then 'No' when 3 then 'Ignorado' end) as curado,
			(case fallecido when '' then '' when 1 then 'Si' when 2 then 'No' when 3 then 'Ignorado' end) as fallecido,fecha_def,
			(case referido when '' then '' when 1 then 'Si' when 2 then 'No' when 3 then 'Ignorado' end) as referido,
			sospechoso, probable, confirmado, descartado,sospechosoG, probableG, confirmadoG, descartadoG, autoctono,nacional,
			importado,observaciones,investigador,cargo,telef,correo,usuario as digitador
			FROM chikungunya a
			left join renace b on a.establecimiento=b.cod_est
			left join diresas c on a.diresa=c.codigo
			left join redes d on a.diresa=d.subregion and a.red=d.codigo
			left join microred e on a.diresa=e.subregion and a.red=e.red and a.microred=e.codigo
			left join paises f on a.pais=f.codigo
			left join paises g on a.pais14_1=g.codigo
			left join departamento h on substr(a.residencia,1,2)=h.ubigeo
			left join provincia i on substr(a.residencia,1,4)=i.ubigeo
			left join distrito j on a.residencia=j.ubigeo
			left join departamento k on substr(a.ubigeo14_1,1,2)=k.ubigeo
			left join provincia l on substr(a.ubigeo14_1,1,4)=l.ubigeo
			left join distrito m on a.ubigeo14_1=m.ubigeo";
	
			if($this->input->post('establec') != ""){		
				$where = " where a.establecimiento='".$this->input->post('establec')."'";
				$query = $this->db->query($sql.$where);
			}else if($this->input->post('microred') != "" && $this->input->post('establec') == ""){
				$where = " where a.diresa='".$this->input->post('diresa')."' and a.red='".$this->input->post('redes')."' and a.microred='".$this->input->post('microred')."'";
				$query = $this->db->query($sql.$where);
			}else if($this->input->post('redes') != "" && $this->input->post('microred') == "" && $this->input->post('establec') == ""){
				$where = " where a.diresa='".$this->input->post('diresa')."' and a.red='".$this->input->post('redes')."'";
				$query = $this->db->query($sql.$where);
			}else if($this->input->post('diresa') != "" && $this->input->post('redes') == "" && $this->input->post('microred') == "" && $this->input->post('establec') == ""){
				$where = " where a.diresa='".$this->input->post('diresa')."'";
				$query = $this->db->query($sql.$where);
			}else{
				$query = $this->db->query($sql);
			}
	
			if(!$query)
				return false;
			
	
			$headers = ''; // just creating the var for field headers to append to below
			$data = ''; // just creating the var for field data to append to below
			
			$fields = $query->list_fields();
			$col= 0;
			/*echo "<pre>";
			var_dump($fields); die;*/
			if($query->num_rows() == 0) {
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
				header('Content-Disposition: attachment; filename="chikungunya_'.date('dMy').'.xls"');
				echo "$headers\n$data";
				exit;
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

		$this->layout->view("exportar",compact('diresa','redes','microred','establec'));
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
	public function llenaInstitucion()
	{
		$filtro1 = $this->input->get('establec');
										   
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
		
		echo json_encode($var);
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
		foreach ($this->mantenimiento_model->buscarDistritos($filtro1) as $dato) {
			$dist[$dato->ubigeo] = $dato->nombre;
		}
		echo json_encode($dist);
	}

    //Llena el combo distrito
	public function llenaLocalidades()
	{
		$filtro = $this->input->get('ubigeo');
		foreach ($this->mantenimiento_model->buscarLocalidades($filtro) as $dato) {
			$local[$dato->codloc] = $dato->nombre;
		}
		echo json_encode($local);
	}

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
