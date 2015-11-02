<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modulos4 extends CI_Controller {

    public function __construct()
    {
		parent::__construct();
        $this->layout->setLayout('template8_8');
        $this->layout->setTitle(":: NotiWeb :: Intoxicaci&oacute;n por Plaguicidas");
    }

    public function _example_output($output = null)
    {
		$usu = $this->session->userdata("usuario");
		
		$usuario = $usu['usuario'];
		
		$accion = 'Listar Plaguicidas';
			
		$this->login_model->auditoriaOperador($usuario, $accion);
			
		$this->layout->view('plaguicidas.php', $output);
    }

    public function _example_output1($output = null)
    {
		$this->layout->view('notificados.php', $output);
    }

    public function _example_output2($output = null)
    {
		$this->layout->view('brotes.php', $output);
    }

    public function _example_output3($output = null)
    {
		$this->layout->view('intoxicado.php', $output);
    }

    public function index()
    {
		$this->_example_output((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
		$this->_example_output1((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
		$this->_example_output2((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
		$this->_example_output3((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
    }
	
	//Grocery Crud: Listado de Fichas del Módulo plaguicidas
    public function listarPlaguicidas()
    {
		$eess = $this->fichas_model->mostrarEstablecimiento();
		
		foreach($eess as $dato)
		{
			$establec[$dato->cod_est]=$dato->raz_soc;
		}
		
		$crud = new grocery_CRUD();

		$crud->set_table('plaguicidas');
		$crud->columns('codigo', 'fecha_est', 'fecha_inv', 'fecha_dir', 'fecha_not', 'e_salud', 'ubigeo_dom');
		$crud->set_subject('Ficha');
		
		$nivelUsuario = $this->session->userdata("nivel");
			
		switch($nivelUsuario){
			case '8':
			$where = array('e_salud' =>  $this->session->userdata("establecimiento"));
			$crud->where($where);
			break;
			case '7':
			$where = array('microred' =>  $this->session->userdata("microred"), 'redes' =>  $this->session->userdata("red"), 'sub_reg_nt' =>  $this->session->userdata("diresa"));
			$crud->where($where);
			break;
			case '6':
			$where = array('redes' =>  $this->session->userdata("red"), 'diresa' =>  $this->session->userdata("diresa"));
			$crud->where($where);
			break;
			case '5':
			$where = array('diresa' => $this->session->userdata("diresa"));
			$crud->where($where);
			break;
		}
		$crud->set_relation('ubigeo_dom', 'distrito', 'nombre');
		$crud->display_as("fecha_est", "Fecha Establecimiento");
		$crud->display_as("fecha_inv", "Investigaci&oacute;n");
		$crud->display_as("fecha_dir", "Fecha Diresa");
		$crud->display_as("fecha_not", "Notificaci&oacute;n");
		$crud->display_as("e_salud", "Establecimiento");
		$crud->display_as("ubigeo_dom", "Domicilio");
		$crud->field_type('e_salud', 'dropdown', $establec);
	
		$crud->unset_add();
		$crud->unset_edit();
		$crud->unset_read();
		$crud->unset_export();
		$crud->unset_print();
		
		$crud->add_action('Modificar Ficha', '', 'modulos4/modificarPlaguicidas','edit-icon');
		$crud->add_action('Ver Ficha', '', 'modulos4/verPlaguicidas','read-icon');
		$output = $crud->render();

		$this->_example_output($output);
    }

	//Grocery Crud: Listado de casos de plaguicidas notificados
    public function listarCasos()
    {
		$eess = $this->fichas_model->mostrarEstablecimiento();
		
		foreach($eess as $dato)
		{
			$establec[$dato->cod_est]=$dato->raz_soc;
		}
		
		$filtro = array("substr(diagnostic,1,3)"=>"T60");
		
		$crud = new grocery_CRUD();

		$crud->set_table('individual');
		$crud->columns('ano', 'semana', 'diagnostic', 'tipo_dx', 'e_salud', 'ubigeo', 'apepat', 'apemat', 'nombres', 'dni');
		$crud->set_subject('Individual');
		
		$nivelUsuario = $this->session->userdata("nivel");
			
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

		$crud->where($filtro);
		$crud->where(array('tipo_dx <>'=>'D'));
		$crud->display_as("ano", "A&ntilde;o");
		$crud->display_as("diagnostic", "Diagn&oacute;stico");
		$crud->display_as("e_salud", "Establecimiento");
		$crud->display_as("apepat", "Apellido Paterno");
		$crud->display_as("apemat", "Apellido Materno");
		$crud->display_as("dni", "DNI");
		$crud->field_type('tipo_dx', 'dropdown', array('S'=>'Sospechoso', 'C'=>'Confirmado', 'P'=>'Probable'));
		$crud->field_type('e_salud', 'dropdown', $establec);
		$crud->set_relation('diagnostic', 'diagno', 'diagno');
		$crud->set_relation('ubigeo', 'distrito', 'nombre');
		$crud->unset_add();
		$crud->unset_edit();
		$crud->unset_read();
		$crud->unset_export();
		$crud->unset_print();
		$crud->unset_delete();
		
		$crud->add_action('Registrar Ficha', '', 'modulos4/registrarPlaguicidas','edit-icon');
		$output = $crud->render();

		$this->_example_output1($output);
    }

	//Grocery Crud: Listado de fichas de brotes de plaguicidas
    public function listarBrotes()
    {
		$eess = $this->fichas_model->mostrarEstablecimiento();
		
		foreach($eess as $dato)
		{
			$establec[$dato->cod_est]=$dato->raz_soc;
		}
		
		$crud = new grocery_CRUD();

		$crud->set_table('bplaguicidas');
		$crud->columns('e_salud', 'ubigeo', 'codigo', 'fecha_loc', 'fecha_est', 'fecha_inv', 'fecha_dir', 'fecha_not', 'fecha_rep');
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

		$crud->field_type('e_salud', 'dropdown', $establec);
		$crud->set_relation('ubigeo', 'distrito', 'nombre');
		$crud->unset_add();
		$crud->unset_edit();
		$crud->unset_read();
		$crud->unset_export();
		$crud->unset_delete();

		$crud->add_action_peru('', '', 'registrarBrote','add-icon');
		$crud->add_action('Registrar Intoxicados', '', 'modulos4/listarGrillaBrotes','more-icon');
		$crud->add_action('Registrar Ficha', '', 'modulos4/modificarBrote','edit-icon');
		$output = $crud->render();

		$this->_example_output2($output);
    }

	//Grocery Crud: Listado de fichas de brotes de plaguicidas
    public function listarGrillaBrotes($id=null)
    {
		$where = array('codigo'=>$id);
		
		$crud = new grocery_CRUD();

		$crud->set_table('gplaguicidas');
		$crud->where($where);
		$crud->display_as("apenom", "Apellidos y nombres");
		$crud->display_as("fecha_int", "Fecha de intoxicaci&oacute;n");
		$crud->display_as("hora", "Hora inicio 1er. s&iacute;ntoma");
		$crud->display_as("residencia", "Lugar de residencia");
		$crud->display_as("codigo", "C&oacute;digo");
		$crud->field_type('sexo', 'dropdown', array('1'=>'Masculino', '2'=>'Femenino'));
		$crud->field_type('tratado', 'dropdown', array('1'=>'Si', '2'=>'No'));
		$crud->field_type('estado', 'dropdown', array('1'=>'Recuperado', '2'=>'Fallecido'));
		$crud->set_subject('Ficha');
		$output = $crud->render();

		$this->_example_output3($output);
    }

	//Registra una nueva ficha de plaguicidas
    public function registrarPlaguicidas($id=null)
    {
		if(!$id)
		{
			show_404();
		}
		
        if($this->input->post()){
			$usu = $this->session->userdata("usuario");
			
			$usuario = $usu;
			
			if($this->input->post("produccion", true) == "on"){
				$produccion = "1";
			}else{
				$produccion = "0";
			}
			
			if($this->input->post("almacenamiento", true) == "on"){
				$almacenamiento = "1";
			}else{
				$almacenamiento = "0";
			}
			
			if($this->input->post("agricola", true) == "on"){
				$agricola = "1";
			}else{
				$agricola = "0";
			}
			
			if($this->input->post("salud", true) == "on"){
				$salud = "1";
			}else{
				$salud = "0";
			}
			
			if($this->input->post("mantenimiento", true) == "on"){
				$mantenimiento = "1";
			}else{
				$mantenimiento = "0";
			}
			
			if($this->input->post("humano", true) == "on"){
				$humano = "1";
			}else{
				$humano = "0";
			}
			
			if($this->input->post("domiciliario", true) == "on"){
				$domiciliario = "1";
			}else{
				$domiciliario = "0";
			}
			
			if($this->input->post("veterinario", true) == "on"){
				$veterinario = "1";
			}else{
				$veterinario = "0";
			}
			
			if($this->input->post("reentrada", true) == "on"){
				$reentrada = "1";
			}else{
				$reentrada = "0";
			}
			
			if($this->input->post("proteccion", true) == "on"){
				$proteccion = "1";
			}else{
				$proteccion = "0";
			}
			
			if($this->input->post("mezcla", true) == "on"){
				$mezcla = "1";
			}else{
				$mezcla = "0";
			}
			
			if($this->input->post("transporte", true) == "on"){
				$transporte = "1";
			}else{
				$transporte = "0";
			}
			
			if($this->input->post("otros", true) == "on"){
				$otros = "1";
			}else{
				$otros = "0";
			}
			
			if($this->input->post("eoral", true) == "on"){
				$eoral = "1";
			}else{
				$eoral = "0";
			}
			
			if($this->input->post("piel", true) == "on"){
				$piel = "1";
			}else{
				$piel = "0";
			}
			
			if($this->input->post("mucosas", true) == "on"){
				$mucosas = "1";
			}else{
				$mucosas = "0";
			}
			
			if($this->input->post("respiratoria", true) == "on"){
				$respiratoria = "1";
			}else{
				$respiratoria = "0";
			}
			
			if($this->input->post("desconocida", true) == "on"){
				$desconocida = "1";
			}else{
				$desconocida = "0";
			}
			
			if($this->input->post("nauseas", true) == "on"){
				$nauseas = "1";
			}else{
				$nauseas = "0";
			}
			
			if($this->input->post("vomitos", true) == "on"){
				$vomitos = "1";
			}else{
				$vomitos = "0";
			}
			
			if($this->input->post("abdominal", true) == "on"){
				$abdominal = "1";
			}else{
				$abdominal = "0";
			}
			
			if($this->input->post("incontinencia", true) == "on"){
				$incontinencia = "1";
			}else{
				$incontinencia = "0";
			}
			
			if($this->input->post("cefalea", true) == "on"){
				$cefalea = "1";
			}else{
				$cefalea = "0";
			}
			
			if($this->input->post("diarreas", true) == "on"){
				$diarreas = "1";
			}else{
				$diarreas = "0";
			}
			
			if($this->input->post("miosis", true) == "on"){
				$miosis = "1";
			}else{
				$miosis = "0";
			}
			
			if($this->input->post("sudoracion", true) == "on"){
				$sudoracion = "1";
			}else{
				$sudoracion = "0";
			}
			
			if($this->input->post("temblor", true) == "on"){
				$temblor = "1";
			}else{
				$temblor = "0";
			}
			
			if($this->input->post("cianosis", true) == "on"){
				$cianosis = "1";
			}else{
				$cianosis = "0";
			}
			
			if($this->input->post("midriasis", true) == "on"){
				$midriasis = "1";
			}else{
				$midriasis = "0";
			}
			
			if($this->input->post("mareos", true) == "on"){
				$mareos = "1";
			}else{
				$mareos = "0";
			}
			
			if($this->input->post("bradicardia", true) == "on"){
				$bradicardia = "1";
			}else{
				$bradicardia = "0";
			}
			
			if($this->input->post("conciencia", true) == "on"){
				$conciencia = "1";
			}else{
				$conciencia = "0";
			}
			
			if($this->input->post("disnea", true) == "on"){
				$disnea = "1";
			}else{
				$disnea = "0";
			}
			
			if($this->input->post("convulsiones", true) == "on"){
				$convulsiones = "1";
			}else{
				$convulsiones = "0";
			}
			
			if($this->input->post("polipnea", true) == "on"){
				$polipnea = "1";
			}else{
				$polipnea = "0";
			}
			
			if($this->input->post("rash", true) == "on"){
				$rash = "1";
			}else{
				$rash = "0";
			}
			
			if($this->input->post("sibilancias", true) == "on"){
				$sibilancias = "1";
			}else{
				$sibilancias = "0";
			}
			
			if($this->input->post("inferiores", true) == "on"){
				$inferiores = "1";
			}else{
				$inferiores = "0";
			}
			
			if($this->input->post("proximales", true) == "on"){
				$proximales = "1";
			}else{
				$proximales = "0";
			}
			
			if($this->input->post("insuficiencia", true) == "on"){
				$insuficiencia = "1";
			}else{
				$insuficiencia = "0";
			}
			
			if($this->input->post("otro_sintoma", true) == "on"){
				$otro_sintoma = "1";
			}else{
				$otro_sintoma = "0";
			}
			
			if($this->input->post("sin_sintomas", true) == "on"){
				$sin_sintomas = "1";
			}else{
				$sin_sintomas = "0";
			}
			
			if($this->input->post("tipo_mue", true) == "on"){
				$tipo_mue = "1";
			}else{
				$tipo_mue = "0";
			}
			
			if ($this->form_validation->run("modulos4/plaguicidas")){
				$data = array
				(
					"codigo"=>$this->input->post("codigo", true),
					"fecha_loc"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_loc", true)),
					"fecha_est"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_est", true)),
					"fecha_inv"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_inv", true)),
					"fecha_dir"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_dir", true)),
					"fecha_not"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_not", true)),
					"diresa"=>$this->input->post("diresa", true),
					"redes"=>$this->input->post("redes", true),
					"microred"=>$this->input->post("microred", true),
					"e_salud"=>$this->input->post("establecimiento", true),
					"ubigeo"=>$this->input->post("distrito1", true),
					"localidad"=>$this->input->post("localidad1", true),
					"captado"=>$this->input->post("captado", true),
					"captado_otro"=>$this->input->post("captado_otro", true),
					"notificacion"=>$this->input->post("notificacion", true),
					"notifica_otro"=>$this->input->post("notifica_otro", true),
					"notificado"=>$this->input->post("notificado", true),
					"fecha_nac"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_nac", true)),
					"lugar_nac"=>$this->input->post("lugar_nac", true),
					"embarazada"=>$this->input->post("embarazada", true),
					"instruccion"=>$this->input->post("instruccion", true),
					"seguro"=>$this->input->post("seguro", true),
					"seguro_otro"=>$this->input->post("seguro_otro", true),
					"ocupacion"=>$this->input->post("ocupacion", true),
					"ubigeo_dom"=>$this->input->post("distrito", true),
					"localidad_dom"=>$this->input->post("localidad", true),
					"telefonos"=>$this->input->post("telefono", true),
					"referencia"=>$this->input->post("referencia", true),
					"etnia"=>$this->input->post("etnia", true),
					"etnia_otro"=>$this->input->post("etnia_otro", true),
					"procedencia"=>$this->input->post("procedencia", true),
					"fecha_int"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_int", true)),
					"hora"=>$this->input->post("hora", true),
					"meridiano"=>$this->input->post("meridiano", true),
					"ocurrencia"=>$this->input->post("ocurrencia", true),
					"trabajo"=>$this->input->post("trabajo", true),
					"ocurrencia_otro"=>$this->input->post("ocurrencia_otro", true),
					"ubigeo_int"=>$this->input->post("distrito14_1", true),
					"localidad_int"=>$this->input->post("localidad14_1", true),
					"direccion_int"=>$this->input->post("direccion14_1", true),
					"alimentos"=>$this->input->post("alimentos", true),
					"producto"=>$this->input->post("producto", true),
					"producto_otro"=>$this->input->post("producto_otro", true),
					"nombre"=>$this->input->post("nombre", true),
					"concentracion"=>$this->input->post("concentracion", true),
					"presentacion"=>$this->input->post("presentacion", true),
					"cantidad"=>$this->input->post("cantidad", true),
					"obtencion"=>$this->input->post("obtencion", true),
					"circunstancia"=>$this->input->post("circunstancia", true),
					"circunstancia_otro"=>$this->input->post("circunstancia_otro", true),
					"produccion"=>$produccion,
					"almacenamiento"=>$almacenamiento,
					"agricola"=>$agricola,
					"salud"=>$salud,
					"mantenimiento"=>$mantenimiento,
					"humano"=>$humano,
					"domiciliario"=>$domiciliario,
					"veterinario"=>$veterinario,
					"reentrada"=>$reentrada,
					"proteccion"=>$proteccion,
					"mezcla"=>$mezcla,
					"transporte"=>$transporte,
					"otros"=>$otros,
					"actividad_otro"=>$this->input->post("actividad_otro", true),
					"manejo"=>$this->input->post("manejo", true),
					"tiempo"=>$this->input->post("tiempo", true),
					"tiempo_tipo"=>$this->input->post("tiempo_tipo", true),
					"eoral"=>$eoral,
					"piel"=>$piel,
					"mucosas"=>$mucosas,
					"respiratoria"=>$respiratoria,
					"desconocida"=>$desconocida,
					"fecha_con"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_con", true)),
					"sistemico"=>$this->input->post("sistemico", true),
					"nauseas"=>$nauseas,
					"vomitos"=>$vomitos,
					"abdominal"=>$abdominal,
					"incontinencia"=>$incontinencia,
					"cefalea"=>$cefalea,
					"diarreas"=>$diarreas,
					"miosis"=>$miosis,
					"sudoracion"=>$sudoracion,
					"temblor"=>$temblor,
					"cianosis"=>$cianosis,
					"midriasis"=>$midriasis,
					"mareos"=>$mareos,
					"bradicardia"=>$bradicardia,
					"conciencia"=>$conciencia,
					"disnea"=>$disnea,
					"convulsiones"=>$convulsiones,
					"polipnea"=>$polipnea,
					"rash"=>$rash,
					"sibilancias"=>$sibilancias,
					"inferiores"=>$inferiores,
					"proximales"=>$proximales,
					"insuficiencia"=>$insuficiencia,
					"otro_sintoma"=>$otro_sintoma,
					"sintoma_otro"=>$this->input->post("sintoma_otro", true),
					"sin_sintomas"=>$sin_sintomas,
					"tipo"=>$this->input->post("tipo", true),
					"anteriores"=>$this->input->post("anteriores", true),
					"veces"=>$this->input->post("veces", true),
					"fecha_ant"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_ant", true)),
					"lugar_ant"=>$this->input->post("lugar_ant", true),
					"anterior_otro"=>$this->input->post("anterior_otro", true),
					"observaciones"=>$this->input->post("observaciones", true),
					"causa_ant"=>$this->input->post("causa_ant", true),
					"causa_otro"=>$this->input->post("causa_otro", true),
					"laboratorio"=>$this->input->post("laboratorio", true),
					"muestra"=>$this->input->post("muestra", true),
					"tipo_mue"=>$tipo_mue,
					"tipomue_otro"=>$this->input->post("tipomue_otro", true),
					"fecha_mue"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_mue", true)),
					"fecha_env"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_env", true)),
					"fecha_rec"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_rec", true)),
					"colinesterasa"=>$this->input->post("colinesterasa", true),
					"colinesterasa_res"=>$this->input->post("colinesterasa_res", true),
					"metodo"=>$this->input->post("metodo", true),
					"examen_otro"=>$this->input->post("examen_otro", true),
					"examen_cual"=>$this->input->post("examen_cual", true),
					"servicio"=>$this->input->post("servicio", true),
					"fecha_ocu"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_ocu", true)),
					"destino"=>$this->input->post("destino", true),
					"fecha_hos"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_hos", true)),
					"destino_serv"=>$this->input->post("destino_serv", true),
					"oral"=>$this->input->post("oral", true),
					"oral_dosis"=>$this->input->post("oral_dosis", true),
					"parenteral"=>$this->input->post("parenteral", true),
					"parenteral_dosis"=>$this->input->post("parenteral_dosis", true),
					"antidoto"=>$this->input->post("antidoto", true),
					"secuelas"=>$this->input->post("secuelas", true),
					"evolucion"=>$this->input->post("evolucion", true),
					"lugar_trans"=>$this->input->post("lugar_trans", true),
					"fecha_alt"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_alt", true)),
					"causa"=>$this->input->post("mostrar", true),
					"diagnostico"=>$this->input->post("diagnostico", true),
					"diagnostico_otro"=>$this->input->post("diagnostico_otro", true),
					"fecha_inv1"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_inv1", true)),
					"fecha_inv2"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_inv2", true)),
					"investigador"=>$this->input->post("investigador", true),
					"profesion"=>$this->input->post("profesion", true),
					"telefono"=>$this->input->post("telefono", true),
					"celular"=>$this->input->post("celular", true),
					"usuario"=>$usuario
				);
				
				$guardar = $this->fichas_model->insertarPlaguicidas($data);
				
				if($guardar)
				{
					$this->session->set_flashdata('exito', 'Informaci&oacute;n guardada con &eacute;xito.');
					redirect(site_url('modulos4/listarCasos'), 301);
				}else{
					$this->session->set_flashdata('error', 'No se guard&oacute; la informaci&oacute;n registrada.');
					redirect(site_url('registrarPlaguicidas'), 301);
				}
			}
        }

        $datos = $this->fichas_model->mostrarIndividual($id);
		
		$dni = $datos->dni;

		$existe = $this->fichas_model->existeFicha($dni);
		
		if($existe <> 0){
			$this->session->set_flashdata('error', 'Cuidado: Este paciente ya tiene registrada una ficha.');
		}
       
        $this->layout->view("registrarPlaguicidas", compact("id", "datos"));
    }

	//Modificar ficha de plaguicidas
    public function modificarPlaguicidas($id=null)
    {
		if(!$id)
		{
			show_404();
		}
		
        if($this->input->post()){
			$usu = $this->session->userdata("usuario");
			
			$usuario = $usu;
			
			if($this->input->post("produccion", true) == "on"){
				$produccion = "1";
			}else{
				$produccion = "0";
			}
			
			if($this->input->post("almacenamiento", true) == "on"){
				$almacenamiento = "1";
			}else{
				$almacenamiento = "0";
			}
			
			if($this->input->post("agricola", true) == "on"){
				$agricola = "1";
			}else{
				$agricola = "0";
			}
			
			if($this->input->post("salud", true) == "on"){
				$salud = "1";
			}else{
				$salud = "0";
			}
			
			if($this->input->post("mantenimiento", true) == "on"){
				$mantenimiento = "1";
			}else{
				$mantenimiento = "0";
			}
			
			if($this->input->post("humano", true) == "on"){
				$humano = "1";
			}else{
				$humano = "0";
			}
			
			if($this->input->post("domiciliario", true) == "on"){
				$domiciliario = "1";
			}else{
				$domiciliario = "0";
			}
			
			if($this->input->post("veterinario", true) == "on"){
				$veterinario = "1";
			}else{
				$veterinario = "0";
			}
			
			if($this->input->post("reentrada", true) == "on"){
				$reentrada = "1";
			}else{
				$reentrada = "0";
			}
			
			if($this->input->post("proteccion", true) == "on"){
				$proteccion = "1";
			}else{
				$proteccion = "0";
			}
			
			if($this->input->post("mezcla", true) == "on"){
				$mezcla = "1";
			}else{
				$mezcla = "0";
			}
			
			if($this->input->post("transporte", true) == "on"){
				$transporte = "1";
			}else{
				$transporte = "0";
			}
			
			if($this->input->post("otros", true) == "on"){
				$otros = "1";
			}else{
				$otros = "0";
			}
			
			if($this->input->post("eoral", true) == "on"){
				$eoral = "1";
			}else{
				$eoral = "0";
			}
			
			if($this->input->post("piel", true) == "on"){
				$piel = "1";
			}else{
				$piel = "0";
			}
			
			if($this->input->post("mucosas", true) == "on"){
				$mucosas = "1";
			}else{
				$mucosas = "0";
			}
			
			if($this->input->post("respiratoria", true) == "on"){
				$respiratoria = "1";
			}else{
				$respiratoria = "0";
			}
			
			if($this->input->post("desconocida", true) == "on"){
				$desconocida = "1";
			}else{
				$desconocida = "0";
			}
			
			if($this->input->post("nauseas", true) == "on"){
				$nauseas = "1";
			}else{
				$nauseas = "0";
			}
			
			if($this->input->post("vomitos", true) == "on"){
				$vomitos = "1";
			}else{
				$vomitos = "0";
			}
			
			if($this->input->post("abdominal", true) == "on"){
				$abdominal = "1";
			}else{
				$abdominal = "0";
			}
			
			if($this->input->post("incontinencia", true) == "on"){
				$incontinencia = "1";
			}else{
				$incontinencia = "0";
			}
			
			if($this->input->post("cefalea", true) == "on"){
				$cefalea = "1";
			}else{
				$cefalea = "0";
			}
			
			if($this->input->post("diarreas", true) == "on"){
				$diarreas = "1";
			}else{
				$diarreas = "0";
			}
			
			if($this->input->post("miosis", true) == "on"){
				$miosis = "1";
			}else{
				$miosis = "0";
			}
			
			if($this->input->post("sudoracion", true) == "on"){
				$sudoracion = "1";
			}else{
				$sudoracion = "0";
			}
			
			if($this->input->post("temblor", true) == "on"){
				$temblor = "1";
			}else{
				$temblor = "0";
			}
			
			if($this->input->post("cianosis", true) == "on"){
				$cianosis = "1";
			}else{
				$cianosis = "0";
			}
			
			if($this->input->post("midriasis", true) == "on"){
				$midriasis = "1";
			}else{
				$midriasis = "0";
			}
			
			if($this->input->post("mareos", true) == "on"){
				$mareos = "1";
			}else{
				$mareos = "0";
			}
			
			if($this->input->post("bradicardia", true) == "on"){
				$bradicardia = "1";
			}else{
				$bradicardia = "0";
			}
			
			if($this->input->post("conciencia", true) == "on"){
				$conciencia = "1";
			}else{
				$conciencia = "0";
			}
			
			if($this->input->post("disnea", true) == "on"){
				$disnea = "1";
			}else{
				$disnea = "0";
			}
			
			if($this->input->post("convulsiones", true) == "on"){
				$convulsiones = "1";
			}else{
				$convulsiones = "0";
			}
			
			if($this->input->post("polipnea", true) == "on"){
				$polipnea = "1";
			}else{
				$polipnea = "0";
			}
			
			if($this->input->post("rash", true) == "on"){
				$rash = "1";
			}else{
				$rash = "0";
			}
			
			if($this->input->post("sibilancias", true) == "on"){
				$sibilancias = "1";
			}else{
				$sibilancias = "0";
			}
			
			if($this->input->post("inferiores", true) == "on"){
				$inferiores = "1";
			}else{
				$inferiores = "0";
			}
			
			if($this->input->post("proximales", true) == "on"){
				$proximales = "1";
			}else{
				$proximales = "0";
			}
			
			if($this->input->post("insuficiencia", true) == "on"){
				$insuficiencia = "1";
			}else{
				$insuficiencia = "0";
			}
			
			if($this->input->post("otro_sintoma", true) == "on"){
				$otro_sintoma = "1";
			}else{
				$otro_sintoma = "0";
			}
			
			if($this->input->post("sin_sintomas", true) == "on"){
				$sin_sintomas = "1";
			}else{
				$sin_sintomas = "0";
			}
			
			if($this->input->post("tipo_mue", true) == "on"){
				$tipo_mue = "1";
			}else{
				$tipo_mue = "0";
			}
			
			if ($this->form_validation->run("modulos4/plaguicidas")){
				$data = array
				(
					"codigo"=>$this->input->post("codigo", true),
					"fecha_loc"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_loc", true)),
					"fecha_est"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_est", true)),
					"fecha_inv"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_inv", true)),
					"fecha_dir"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_dir", true)),
					"fecha_not"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_not", true)),
					"diresa"=>$this->input->post("diresa", true),
					"redes"=>$this->input->post("redes", true),
					"microred"=>$this->input->post("microred", true),
					"e_salud"=>$this->input->post("establecimiento", true),
					"ubigeo"=>$this->input->post("distrito1", true),
					"localidad"=>$this->input->post("localidad1", true),
					"captado"=>$this->input->post("captado", true),
					"captado_otro"=>$this->input->post("captado_otro", true),
					"notificacion"=>$this->input->post("notificacion", true),
					"notifica_otro"=>$this->input->post("notifica_otro", true),
					"notificado"=>$this->input->post("notificado", true),
					"fecha_nac"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_nac", true)),
					"lugar_nac"=>$this->input->post("lugar_nac", true),
					"embarazada"=>$this->input->post("embarazada", true),
					"instruccion"=>$this->input->post("instruccion", true),
					"seguro"=>$this->input->post("seguro", true),
					"seguro_otro"=>$this->input->post("seguro_otro", true),
					"ocupacion"=>$this->input->post("ocupacion", true),
					"ubigeo_dom"=>$this->input->post("distrito", true),
					"localidad_dom"=>$this->input->post("localidad", true),
					"telefonos"=>$this->input->post("telefono", true),
					"referencia"=>$this->input->post("referencia", true),
					"etnia"=>$this->input->post("etnia", true),
					"etnia_otro"=>$this->input->post("etnia_otro", true),
					"procedencia"=>$this->input->post("procedencia", true),
					"fecha_int"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_int", true)),
					"hora"=>$this->input->post("hora", true),
					"meridiano"=>$this->input->post("meridiano", true),
					"ocurrencia"=>$this->input->post("ocurrencia", true),
					"trabajo"=>$this->input->post("trabajo", true),
					"ocurrencia_otro"=>$this->input->post("ocurrencia_otro", true),
					"ubigeo_int"=>$this->input->post("distrito14_1", true),
					"localidad_int"=>$this->input->post("localidad14_1", true),
					"direccion_int"=>$this->input->post("direccion14_1", true),
					"alimentos"=>$this->input->post("alimentos", true),
					"producto"=>$this->input->post("producto", true),
					"producto_otro"=>$this->input->post("producto_otro", true),
					"nombre"=>$this->input->post("nombre", true),
					"concentracion"=>$this->input->post("concentracion", true),
					"presentacion"=>$this->input->post("presentacion", true),
					"cantidad"=>$this->input->post("cantidad", true),
					"obtencion"=>$this->input->post("obtencion", true),
					"circunstancia"=>$this->input->post("circunstancia", true),
					"circunstancia_otro"=>$this->input->post("circunstancia_otro", true),
					"produccion"=>$produccion,
					"almacenamiento"=>$almacenamiento,
					"agricola"=>$agricola,
					"salud"=>$salud,
					"mantenimiento"=>$mantenimiento,
					"humano"=>$humano,
					"domiciliario"=>$domiciliario,
					"veterinario"=>$veterinario,
					"reentrada"=>$reentrada,
					"proteccion"=>$proteccion,
					"mezcla"=>$mezcla,
					"transporte"=>$transporte,
					"otros"=>$otros,
					"actividad_otro"=>$this->input->post("actividad_otro", true),
					"manejo"=>$this->input->post("manejo", true),
					"tiempo"=>$this->input->post("tiempo", true),
					"tiempo_tipo"=>$this->input->post("tiempo_tipo", true),
					"eoral"=>$eoral,
					"piel"=>$piel,
					"mucosas"=>$mucosas,
					"respiratoria"=>$respiratoria,
					"desconocida"=>$desconocida,
					"fecha_con"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_con", true)),
					"sistemico"=>$this->input->post("sistemico", true),
					"nauseas"=>$nauseas,
					"vomitos"=>$vomitos,
					"abdominal"=>$abdominal,
					"incontinencia"=>$incontinencia,
					"cefalea"=>$cefalea,
					"diarreas"=>$diarreas,
					"miosis"=>$miosis,
					"sudoracion"=>$sudoracion,
					"temblor"=>$temblor,
					"cianosis"=>$cianosis,
					"midriasis"=>$midriasis,
					"mareos"=>$mareos,
					"bradicardia"=>$bradicardia,
					"conciencia"=>$conciencia,
					"disnea"=>$disnea,
					"convulsiones"=>$convulsiones,
					"polipnea"=>$polipnea,
					"rash"=>$rash,
					"sibilancias"=>$sibilancias,
					"inferiores"=>$inferiores,
					"proximales"=>$proximales,
					"insuficiencia"=>$insuficiencia,
					"otro_sintoma"=>$otro_sintoma,
					"sintoma_otro"=>$this->input->post("sintoma_otro", true),
					"sin_sintomas"=>$sin_sintomas,
					"tipo"=>$this->input->post("tipo", true),
					"anteriores"=>$this->input->post("anteriores", true),
					"veces"=>$this->input->post("veces", true),
					"fecha_ant"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_ant", true)),
					"lugar_ant"=>$this->input->post("lugar_ant", true),
					"anterior_otro"=>$this->input->post("anterior_otro", true),
					"observaciones"=>$this->input->post("observaciones", true),
					"causa_ant"=>$this->input->post("causa_ant", true),
					"causa_otro"=>$this->input->post("causa_otro", true),
					"laboratorio"=>$this->input->post("laboratorio", true),
					"muestra"=>$this->input->post("muestra", true),
					"tipo_mue"=>$tipo_mue,
					"tipomue_otro"=>$this->input->post("tipomue_otro", true),
					"fecha_mue"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_mue", true)),
					"fecha_env"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_env", true)),
					"fecha_rec"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_rec", true)),
					"colinesterasa"=>$this->input->post("colinesterasa", true),
					"colinesterasa_res"=>$this->input->post("colinesterasa_res", true),
					"metodo"=>$this->input->post("metodo", true),
					"examen_otro"=>$this->input->post("examen_otro", true),
					"examen_cual"=>$this->input->post("examen_cual", true),
					"servicio"=>$this->input->post("servicio", true),
					"fecha_ocu"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_ocu", true)),
					"destino"=>$this->input->post("destino", true),
					"fecha_hos"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_hos", true)),
					"destino_serv"=>$this->input->post("destino_serv", true),
					"oral"=>$this->input->post("oral", true),
					"oral_dosis"=>$this->input->post("oral_dosis", true),
					"parenteral"=>$this->input->post("parenteral", true),
					"parenteral_dosis"=>$this->input->post("parenteral_dosis", true),
					"antidoto"=>$this->input->post("antidoto", true),
					"secuelas"=>$this->input->post("secuelas", true),
					"evolucion"=>$this->input->post("evolucion", true),
					"lugar_trans"=>$this->input->post("lugar_trans", true),
					"fecha_alt"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_alt", true)),
					"causa"=>$this->input->post("mostrar", true),
					"diagnostico"=>$this->input->post("diagnostico", true),
					"diagnostico_otro"=>$this->input->post("diagnostico_otro", true),
					"fecha_inv1"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_inv1", true)),
					"fecha_inv2"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_inv2", true)),
					"investigador"=>$this->input->post("investigador", true),
					"profesion"=>$this->input->post("profesion", true),
					"telefono"=>$this->input->post("telefono", true),
					"celular"=>$this->input->post("celular", true),
					"usuario"=>$usuario
				);
				
				$guardar = $this->fichas_model->modificarPlaguicidas($data, $id);
				
				if($guardar)
				{
					$this->session->set_flashdata('exito', 'Informaci&oacute;n guardada con &eacute;xito.');
					redirect(site_url('modulos4/listarPlaguicidas'), 301);
				}else{
					$this->session->set_flashdata('error', 'No se guard&oacute; la informaci&oacute;n registrada.');
					redirect(site_url('modificarPlaguicidas'), 301);
				}
			}
        }

		$plaga = $this->fichas_model->buscarPlaguicidas($id);
		
		$noti = $plaga->notificado;
		
		//combo Departamentos
		
		$depar = $this->mantenimiento_model->buscarDepartamentos();

		$departamento[''] = 'Seleccione ...';
		foreach ($depar as $dato){
			$departamento[$dato->ubigeo] = $dato->nombre;
		}
		
		//combo Provincias
		
		$prov = $this->mantenimiento_model->buscarProvincias(substr($plaga->ubigeo_dom,0,2));
	
		//$provincia[''] = 'Seleccione ...';
		foreach ($prov as $dato){
			$provincia[$dato->ubigeo] = $dato->nombre;
		}
		
		//combo Distrito
		
		$dist = $this->mantenimiento_model->buscarDistritos(substr($plaga->ubigeo_dom,0,4));
	
		//$distrito[''] = 'Seleccione ...';
		foreach ($dist as $dato){
			$distrito[$dato->ubigeo] = $dato->nombre;
		}
		
		//combo Departamentos
		
		$depar = $this->mantenimiento_model->buscarDepartamentos();

		$departamento14_1[''] = 'Seleccione ...';
		foreach ($depar as $dato){
			$departamento14_1[$dato->ubigeo] = $dato->nombre;
		}
		
		$prov = $this->mantenimiento_model->buscarProvincias(substr($plaga->ubigeo_int,0,2));
	
		//$provincia[''] = 'Seleccione ...';
		foreach ($prov as $dato){
			$provincia14_1[$dato->ubigeo] = $dato->nombre;
		}
		
		//combo Distrito
		
		$dist = $this->mantenimiento_model->buscarDistritos(substr($plaga->ubigeo_int,0,4));
	
		//$distrito[''] = 'Seleccione ...';
		foreach ($dist as $dato){
			$distrito14_1[$dato->ubigeo] = $dato->nombre;
		}

		$datos = $this->fichas_model->mostrarInd($noti);
		
		if(count($datos) == 0){
			$datos = $this->fichas_model->mostrarIndAnt($noti);
		}

        $this->layout->view("modificarPlaguicidas", compact("id", "plaga", "datos", 'departamento', 'provincia', 'distrito', 'departamento14_1', 'provincia14_1', 'distrito14_1'));
    }

	//Ver ficha de plaguicidas
    public function verPlaguicidas($id=null)
    {
		if(!$id)
		{
			show_404();
		}
		
		$plaga = $this->fichas_model->buscarPlaguicidas($id);
		
		$noti = $plaga->notificado;
		
		//combo Departamentos
		
		$depar = $this->mantenimiento_model->buscarDepartamentos();

		$departamento[''] = 'Seleccione ...';
		foreach ($depar as $dato){
			$departamento[$dato->ubigeo] = $dato->nombre;
		}
		
		//combo Provincias
		
		$prov = $this->mantenimiento_model->buscarProvincias(substr($plaga->ubigeo_dom,0,2));
	
		//$provincia[''] = 'Seleccione ...';
		foreach ($prov as $dato){
			$provincia[$dato->ubigeo] = $dato->nombre;
		}
		
		//combo Distrito
		
		$dist = $this->mantenimiento_model->buscarDistritos(substr($plaga->ubigeo_dom,0,4));
	
		//$distrito[''] = 'Seleccione ...';
		foreach ($dist as $dato){
			$distrito[$dato->ubigeo] = $dato->nombre;
		}
		
		//combo Departamentos
		
		$depar = $this->mantenimiento_model->buscarDepartamentos();

		$departamento14_1[''] = 'Seleccione ...';
		foreach ($depar as $dato){
			$departamento14_1[$dato->ubigeo] = $dato->nombre;
		}
		
		$prov = $this->mantenimiento_model->buscarProvincias(substr($plaga->ubigeo_int,0,2));
	
		//$provincia[''] = 'Seleccione ...';
		foreach ($prov as $dato){
			$provincia14_1[$dato->ubigeo] = $dato->nombre;
		}
		
		//combo Distrito
		
		$dist = $this->mantenimiento_model->buscarDistritos(substr($plaga->ubigeo_int,0,4));
	
		//$distrito[''] = 'Seleccione ...';
		foreach ($dist as $dato){
			$distrito14_1[$dato->ubigeo] = $dato->nombre;
		}

		$datos = $this->fichas_model->mostrarInd($noti);
		
		if(count($datos) == 0){
			$datos = $this->fichas_model->mostrarIndAnt($noti);
		}

        $this->layout->view("verPlaguicidas", compact("id", "plaga", "datos", 'departamento', 'provincia', 'distrito', 'departamento14_1', 'provincia14_1', 'distrito14_1'));
    }

	//Registra una nueva ficha brote de plaguicidas
    public function registrarBrote()
    {
		
        if($this->input->post()){
			$usu = $this->session->userdata("usuario");
			
			$usuario = $usu;
			
			if ($this->form_validation->run("modulos4/brotes")){
				$data = array
				(
					"codigo"=>$this->input->post("codigo", true),
					"fecha_loc"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_loc", true)),
					"fecha_est"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_est", true)),
					"fecha_inv"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_inv", true)),
					"fecha_dir"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_dir", true)),
					"fecha_not"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_not", true)),
					"diresa"=>$this->input->post("diresa", true),
					"redes"=>$this->input->post("redes", true),
					"microred"=>$this->input->post("microred", true),
					"e_salud"=>$this->input->post("establec", true),
					"ubigeo"=>$this->input->post("distrito", true),
					"localidad"=>$this->input->post("localidad", true),
					"descripcion"=>$this->input->post("descripcion", true),
					"indice"=>$this->input->post("indice", true),
					"fecha_rep"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_rep", true)),
					"ubigeo_rep"=>$this->input->post("distrito14_1", true),
					"localidad_rep"=>$this->input->post("localidad_rep", true),
					"sustancia"=>$this->input->post("sustancia", true),
					"concentracion"=>$this->input->post("concentracion", true),
					"cantidad"=>$this->input->post("cantidad", true),
					"procedencia"=>$this->input->post("procedencia", true),
					"expuestos"=>$this->input->post("expuestos", true),
					"noexpuestos"=>$this->input->post("noexpuestos", true),
					"tipo"=>$this->input->post("tipo", true),
					"poblacion"=>$this->input->post("poblacion", true),
					"lugar"=>$this->input->post("lugar", true),
					"actividad"=>$this->input->post("actividad", true),
					"direccion"=>$this->input->post("direccion", true),
					"condicion1"=>$this->input->post("condicion1", true),
					"condicion2"=>$this->input->post("condicion2", true),
					"condicion3"=>$this->input->post("condicion3", true),
					"condicion4"=>$this->input->post("condicion4", true),
					"condicion5"=>$this->input->post("condicion5", true),
					"condicion6"=>$this->input->post("condicion6", true),
					"condicion7"=>$this->input->post("condicion7", true),
					"condicion8"=>$this->input->post("condicion8", true),
					"condicion_otros"=>$this->input->post("condicion_otros", true),
					"acto1"=>$this->input->post("acto1", true),
					"acto2"=>$this->input->post("acto2", true),
					"acto3"=>$this->input->post("acto3", true),
					"acto4"=>$this->input->post("acto4", true),
					"acto5"=>$this->input->post("acto5", true),
					"acto6"=>$this->input->post("acto6", true),
					"acto7"=>$this->input->post("acto7", true),
					"acto8"=>$this->input->post("acto8", true),
					"acto9"=>$this->input->post("acto9", true),
					"acto10"=>$this->input->post("acto10", true),
					"acto_otros"=>$this->input->post("acto_otros", true),
					"busqueda"=>$this->input->post("busqueda", true),
					"educacion"=>$this->input->post("educacion", true),
					"examenes"=>$this->input->post("examenes", true),
					"fichas"=>$this->input->post("fichas", true),
					"informe"=>$this->input->post("informe", true),
					"acciones1"=>$this->input->post("acciones1", true),
					"acciones2"=>$this->input->post("acciones2", true),
					"acciones3"=>$this->input->post("acciones3", true),
					"acciones4"=>$this->input->post("acciones4", true),
					"acciones5"=>$this->input->post("acciones5", true),
					"personas"=>$this->input->post("personas", true),
					"instituciones"=>$this->input->post("instituciones", true),
					"observaciones"=>$this->input->post("observaciones", true),
					"responsable"=>$this->input->post("responsable", true),
					"profesion"=>$this->input->post("profesion", true),
					"cargo"=>$this->input->post("cargo", true),
					"telefono"=>$this->input->post("telefono", true),
					"celular"=>$this->input->post("celular", true),
					"usuario"=>$usuario
				);
				
				$guardar = $this->fichas_model->insertarBrote($data);
				
				if($guardar)
				{
					$this->session->set_flashdata('exito', 'Informaci&oacute;n guardada con &eacute;xito.');
					redirect(site_url('modulos4/listarBrotes'), 301);
				}else{
					$this->session->set_flashdata('error', 'No se guard&oacute; la informaci&oacute;n registrada.');
					redirect(site_url('registrarBrote'), 301);
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
		
		$depar = $this->mantenimiento_model->buscarDepartamentos();

		$departamento[''] = 'Seleccione ...';
		foreach ($depar as $dato){
			$departamento[$dato->ubigeo] = $dato->nombre;
		}
		
		//combo Provincias
		
		if($this->input->post('departamento') != ''){
			$prov = $this->mantenimiento_model->buscarProvincias($this->input->post('departamento'));
	
			//$provincia[''] = 'Seleccione ...';
			foreach ($prov as $dato){
				$provincia[$dato->ubigeo] = $dato->nombre;
			}
		}
		
		//combo Distrito
		
		if($this->input->post('provincia') != ''){
			$dist = $this->mantenimiento_model->buscarDistritos($this->input->post('provincia'));
	
			//$distrito[''] = 'Seleccione ...';
			foreach ($dist as $dato){
				$distrito[$dato->ubigeo] = $dato->nombre;
			}
		}
		
		//combo Departamentos
		
		$depar = $this->mantenimiento_model->buscarDepartamentos();

		$departamento14_1[''] = 'Seleccione ...';
		foreach ($depar as $dato){
			$departamento14_1[$dato->ubigeo] = $dato->nombre;
		}
		
		//combo Provincias
		
		if($this->input->post('departamento14_1') != ''){
			$prov = $this->mantenimiento_model->buscarProvincias($this->input->post('departamento14_1'));
	
			//$provincia[''] = 'Seleccione ...';
			foreach ($prov as $dato){
				$provincia14_1[$dato->ubigeo] = $dato->nombre;
			}
		}
		
		//combo Distrito
		
		if($this->input->post('provincia14_1') != ''){
			$dist = $this->mantenimiento_model->buscarDistritos($this->input->post('provincia14_1'));
	
			//$distrito[''] = 'Seleccione ...';
			foreach ($dist as $dato){
				$distrito14_1[$dato->ubigeo] = $dato->nombre;
			}
		}

		if($this->session->userdata('sesionIniciada') == TRUE){
			$this->layout->view("registrarBrote", compact('session_id', 'diresa', 'redes', 'microred', 'establec', 'departamento', 'provincia', 'distrito', 'departamento14_1', 'provincia14_1', 'distrito14_1'));
        }else{
            redirect(site_url("index/login"), 301);
        }
    }

	//Modifica una nueva ficha brote de plaguicidas
    public function modificarBrote($id=null)
    {
		
		if(!$id)
		{
			show_404();
		}
		
        if($this->input->post()){
			$usu = $this->session->userdata("usuario");
			
			$usuario = $usu;
			
			if ($this->form_validation->run("modulos4/brotes")){
				$data = array
				(
					"codigo"=>$this->input->post("codigo", true),
					"fecha_loc"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_loc", true)),
					"fecha_est"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_est", true)),
					"fecha_inv"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_inv", true)),
					"fecha_dir"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_dir", true)),
					"fecha_not"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_not", true)),
					"diresa"=>$this->input->post("diresa", true),
					"redes"=>$this->input->post("redes", true),
					"microred"=>$this->input->post("microred", true),
					"e_salud"=>$this->input->post("establec", true),
					"ubigeo"=>$this->input->post("distrito", true),
					"localidad"=>$this->input->post("localidad", true),
					"descripcion"=>$this->input->post("descripcion", true),
					"indice"=>$this->input->post("indice", true),
					"fecha_rep"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_rep", true)),
					"ubigeo_rep"=>$this->input->post("distrito14_1", true),
					"localidad_rep"=>$this->input->post("localidad_rep", true),
					"sustancia"=>$this->input->post("sustancia", true),
					"concentracion"=>$this->input->post("concentracion", true),
					"cantidad"=>$this->input->post("cantidad", true),
					"procedencia"=>$this->input->post("procedencia", true),
					"expuestos"=>$this->input->post("expuestos", true),
					"noexpuestos"=>$this->input->post("noexpuestos", true),
					"tipo"=>$this->input->post("tipo", true),
					"poblacion"=>$this->input->post("poblacion", true),
					"lugar"=>$this->input->post("lugar", true),
					"actividad"=>$this->input->post("actividad", true),
					"direccion"=>$this->input->post("direccion", true),
					"condicion1"=>$this->input->post("condicion1", true),
					"condicion2"=>$this->input->post("condicion2", true),
					"condicion3"=>$this->input->post("condicion3", true),
					"condicion4"=>$this->input->post("condicion4", true),
					"condicion5"=>$this->input->post("condicion5", true),
					"condicion6"=>$this->input->post("condicion6", true),
					"condicion7"=>$this->input->post("condicion7", true),
					"condicion8"=>$this->input->post("condicion8", true),
					"condicion_otros"=>$this->input->post("condicion_otros", true),
					"acto1"=>$this->input->post("acto1", true),
					"acto2"=>$this->input->post("acto2", true),
					"acto3"=>$this->input->post("acto3", true),
					"acto4"=>$this->input->post("acto4", true),
					"acto5"=>$this->input->post("acto5", true),
					"acto6"=>$this->input->post("acto6", true),
					"acto7"=>$this->input->post("acto7", true),
					"acto8"=>$this->input->post("acto8", true),
					"acto9"=>$this->input->post("acto9", true),
					"acto10"=>$this->input->post("acto10", true),
					"acto_otros"=>$this->input->post("acto_otros", true),
					"busqueda"=>$this->input->post("busqueda", true),
					"educacion"=>$this->input->post("educacion", true),
					"examenes"=>$this->input->post("examenes", true),
					"fichas"=>$this->input->post("fichas", true),
					"informe"=>$this->input->post("informe", true),
					"acciones1"=>$this->input->post("acciones1", true),
					"acciones2"=>$this->input->post("acciones2", true),
					"acciones3"=>$this->input->post("acciones3", true),
					"acciones4"=>$this->input->post("acciones4", true),
					"acciones5"=>$this->input->post("acciones5", true),
					"personas"=>$this->input->post("personas", true),
					"instituciones"=>$this->input->post("instituciones", true),
					"observaciones"=>$this->input->post("observaciones", true),
					"responsable"=>$this->input->post("responsable", true),
					"profesion"=>$this->input->post("profesion", true),
					"cargo"=>$this->input->post("cargo", true),
					"telefono"=>$this->input->post("telefono", true),
					"celular"=>$this->input->post("celular", true),
					"usuario"=>$usuario
				);
				
				$guardar = $this->fichas_model->modificarBrotes($data, $id);
				
				if($guardar)
				{
					$this->session->set_flashdata('exito', 'Informaci&oacute;n guardada con &eacute;xito.');
					redirect(site_url('modulos4/listarBrotes'), 301);
				}else{
					$this->session->set_flashdata('error', 'No se guard&oacute; la informaci&oacute;n registrada.');
					redirect(site_url('registrarBrote'), 301);
				}
			}
        }
		
		$datos = $this->fichas_model->mostrarBrote($id);
		
		//combo DIRESA
		
		$subreg = $this->frontend_model->buscarDiresas();
		
		$diresa[''] = 'Seleccione ...';
		foreach ($subreg as $dato){
			$diresa[$dato->codigo] = $dato->nombre;
		}

		//combo Red
		
		$red = $this->frontend_model->buscarRedes($datos->diresa);
		$redes[''] = 'Seleccione ...';
		foreach ($red as $dato){
			$redes[$dato->codigo] = $dato->nombre;
		}

		//combo Microred
		
		$mred = $this->frontend_model->buscarMicroredes($datos->diresa,$datos->redes);
		$microred[''] = 'Seleccione ...';
		foreach ($mred as $dato){
			$microred[$dato->codigo] = $dato->nombre;
		}

		//combo Establecimiento
		
		$est = $this->frontend_model->buscarEstablec($datos->diresa,$datos->redes,$datos->microred);
		$establec[''] = 'Seleccione ...';
		foreach ($est as $dato){
			$establec[$dato->cod_est] = $dato->raz_soc;
		}

		//combo Departamentos
		
		$depar = $this->mantenimiento_model->buscarDepartamentos();

		$departamento[''] = 'Seleccione ...';
		foreach ($depar as $dato){
			$departamento[$dato->ubigeo] = $dato->nombre;
		}
		
		//combo Provincias
		
		$prov = $this->mantenimiento_model->buscarProvincias(substr($datos->ubigeo,0,2));

		//$provincia[''] = 'Seleccione ...';
		foreach ($prov as $dato){
			$provincia[$dato->ubigeo] = $dato->nombre;
		}
		
		//combo Distrito
		
		$dist = $this->mantenimiento_model->buscarDistritos(substr($datos->ubigeo,0,4));

		//$distrito[''] = 'Seleccione ...';
		foreach ($dist as $dato){
			$distrito[$dato->ubigeo] = $dato->nombre;
		}
		
		//combo Departamentos
		
		$depar = $this->mantenimiento_model->buscarDepartamentos();

		$departamento14_1[''] = 'Seleccione ...';
		foreach ($depar as $dato){
			$departamento14_1[$dato->ubigeo] = $dato->nombre;
		}
		
		//combo Provincias
		
		$prov = $this->mantenimiento_model->buscarProvincias(substr($datos->ubigeo_rep,0,2));

		//$provincia[''] = 'Seleccione ...';
		foreach ($prov as $dato){
			$provincia14_1[$dato->ubigeo] = $dato->nombre;
		}
		
		//combo Distrito
		
		$dist = $this->mantenimiento_model->buscarDistritos(substr($datos->ubigeo_rep,0,4));

		//$distrito[''] = 'Seleccione ...';
		foreach ($dist as $dato){
			$distrito14_1[$dato->ubigeo] = $dato->nombre;
		}

		if($this->session->userdata('sesionIniciada') == TRUE){
			$this->layout->view("modificarBrote", compact('session_id', 'datos', 'diresa', 'redes', 'microred', 'establec', 'departamento', 'provincia', 'distrito', 'departamento14_1', 'provincia14_1', 'distrito14_1'));
        }else{
            redirect(site_url("index/login"), 301);
        }
    }

	//Exporta la base de datos de la ficha de plaguicidas
	public function exportarPlaguicidas()
	{
		date_default_timezone_set('America/Lima');
		
		$nivelUsuario = $this->session->userdata("acceso");
		
		switch($this->session->userdata("nivel"))
		{
			case '8':
			$where = array("establecimiento"=>$this->session->userdata("establecimiento"));
			
			$query = $this->db
				->where($where)
				->get("chikungunya");
			break;
			case '7':
			$where = array("diresa"=>$this->session->userdata("diresa"), "red"=>$this->session->userdata("red"), "microred"=>$this->session->userdata("microred"));
			
			$query = $this->db
				->where($where)
				->get("chikungunya");
			break;
			case '6':
			$where = array("diresa"=>$this->session->userdata("diresa"), "red"=>$this->session->userdata("red"));
			
			$query = $this->db
				->where($where)
				->get("chikungunya");
			break;
			case '5':
			$where = array("diresa"=>$this->session->userdata("diresa"));
			
			$query = $this->db
				->where($where)
				->get("chikungunya");
			break;
			default:
			$query = $this->db
				->get("chikungunya");
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
        header('Content-Disposition: attachment;filename="chikungunya_'.date('dMy').'.xls"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');

		redirect(site_url('chikungunya/principal'), 301);

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
		foreach ($this->mantenimiento_model->buscarDistritos($filtro, $filtro1) as $dato) {
			$dist[$dato->ubigeo] = $dato->nombre;
		}
		echo json_encode($dist);
	}

	function validar_fecha($str){
		$patron="/^(\d){2}\-(\d){2}\-(\d){4}$/i";
		if(!empty($str)){
			if (preg_match($patron,$str)){
				return TRUE;
			}else{
				$this->form_validation->set_message('validar_fecha',
				'formato de fecha %s no v&aacute;lido');
				return FALSE;
			}
		}
	}

	// Validando casos
	function validar_via($str){
		
		if($this->input->post("eoral") <> 'on' and $this->input->post("piel") <> 'on' and $this->input->post("mucosas") <> 'on' and $this->input->post("respiratoria") <> 'on' and $this->input->post("desconocida") <> 'on'){
			$this->form_validation->set_message('validar_via', 
			'debe elegir una v&iacute;a de exposici&oacute;n');
			return FALSE;
		}else{
			return true;
		}
	}
	
	// Validando casos
	function validar_cuadro($str){
		
		if($this->input->post("nauseas") <> 'on' and 
			$this->input->post("vomitos") <> 'on' and 
			$this->input->post("abdominal") <> 'on' and 
			$this->input->post("incontinencia") <> 'on' and 
			$this->input->post("cefalea") <> 'on' and 
			$this->input->post("diarreas") <> 'on' and 
			$this->input->post("miosis") <> 'on' and 
			$this->input->post("sudoracion") <> 'on' and 
			$this->input->post("temblor") <> 'on' and 
			$this->input->post("cianosis") <> 'on' and 
			$this->input->post("midriasis") <> 'on' and 
			$this->input->post("mareos") <> 'on' and 
			$this->input->post("bradicardia") <> 'on' and 
			$this->input->post("conciencia") <> 'on' and 
			$this->input->post("disnea") <> 'on' and 
			$this->input->post("convulsiones") <> 'on' and 
			$this->input->post("polipnea") <> 'on' and 
			$this->input->post("rash") <> 'on' and 
			$this->input->post("sibilancias") <> 'on' and 
			$this->input->post("inferiores") <> 'on' and 
			$this->input->post("proximales") <> 'on' and 
			$this->input->post("insuficiencia") <> 'on' and 
			$this->input->post("otro_sintoma") <> 'on' and 
			$this->input->post("sin_sintoma") <> 'on' 
			){
			$this->form_validation->set_message('validar_cuadro', 
			'debe elegir una opci&oacute;n del cuadro cl&iacute;nico');
			return FALSE;
		}else{
			return true;
		}
	}
}