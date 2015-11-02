<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sistema extends CI_Controller {

    public function __construct()
    {
		parent::__construct();
        $this->layout->setLayout('template2');
        $this->layout->setTitle(":: NotiWeb :: Vigilancia Epidemiol&oacute;gica");

		if($this->session->userdata('nivel') <> '1'){
            redirect(site_url("backend/index/login"), 301);
		}
	}

    public function _example_output1($output = null)
    {
		$this->layout->view('diagnostico.php',$output);
    }

    public function _example_output2($output = null)
    {
		$this->layout->view('vigilancia.php',$output);
    }

    public function _example_output3($output = null)
    {
		$this->layout->view('tipo_dx.php',$output);
    }

    public function _example_output4($output = null)
    {
		$this->layout->view('diresa.php',$output);
    }

    public function _example_output5($output = null)
    {
		$this->layout->view('redes.php',$output);
    }

    public function _example_output6($output = null)
    {
		$this->layout->view('microred.php',$output);
    }

    public function _example_output7($output = null)
    {
		$this->layout->view('establecimiento.php',$output);
    }

    public function _example_output8($output = null)
    {
		$this->layout->view('departamento.php',$output);
    }

    public function _example_output9($output = null)
    {
		$this->layout->view('provincia.php',$output);
    }

    public function _example_output10($output = null)
    {
		$this->layout->view('distrito.php',$output);
    }

    public function _example_output11($output = null)
    {
		$this->layout->view('menu.php',$output);
    }

    public function _example_output12($output = null)
    {
		$this->layout->view('submenu.php',$output);
    }

    public function _example_output13($output = null)
    {
		$this->layout->view('etnias.php',$output);
    }

    public function _example_output14($output = null)
    {
		$this->layout->view('subetnias.php',$output);
    }

    public function _example_output15($output = null)
    {
		$this->layout->view('barra.php',$output);
    }

    public function _example_output16($output = null)
    {
		$this->layout->view('cierre.php',$output);
    }

    public function _example_output17($output = null)
    {
		$this->layout->view('auditoria.php',$output);
    }

    public function _example_output18($output = null)
    {
		$this->layout->view('mantenimiento.php',$output);
    }

    public function _example_output19($output = null)
    {
		$this->layout->view('modulos.php',$output);
    }

	public function index()
    {
		$this->_example_output1((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
		$this->_example_output2((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
		$this->_example_output3((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
		$this->_example_output4((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
		$this->_example_output5((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
		$this->_example_output6((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
		$this->_example_output7((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
		$this->_example_output8((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
		$this->_example_output9((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
		$this->_example_output10((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
		$this->_example_output11((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
		$this->_example_output12((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
		$this->_example_output13((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
		$this->_example_output14((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
		$this->_example_output15((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
		$this->_example_output16((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
		$this->_example_output17((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
		$this->_example_output18((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
    }
    
	//Grocery Crud: Listado de enfermedades vigiladas
    public function listarEnfermedades()
    {
		$equipos = $this->mantenimiento_model->listarEquipos();
		
		$tematico = array();
		
		foreach($equipos as $dato)
		{
			$tematico[$dato->codigo] = $dato->denominacion;
		}
		
		$crud = new grocery_CRUD();

		$crud->set_table('diagno');
		$crud->columns('cie_10','diagno','inmunoprev','tipo','tipo_notif','edad','tipoE','sexo','clave','boletin','diresa');
		$crud->display_as('cie_10','C&oacute;digo')
			->display_as('diagno','Diagn&oacute;stico')
			->display_as('inmunoprev','Inmunoprevenible')
			->display_as('tipo','Alcance')
			->display_as('tipoE','Tipo Edad')
			->display_as('tipo_notif','Periodicidad');
		$crud->set_subject('Enfermedad');
		$crud->field_type('inmunoprev','dropdown',array('0' => 'No', '1' => 'Si'));         
		$crud->field_type('tipo','dropdown',array('N' => 'Nacional', 'R' => 'Regional', 'L' => 'Local'));         
		$crud->field_type('tipo_notif','dropdown',array('S' => 'Semanal', 'Q' => 'Quincenal', 'M' => 'Mensual', 'I' => 'Inmediata'));         
		$crud->field_type('sexo','dropdown',array('M' => 'Masculino', 'F' => 'Femenino', 'A' => 'Ambos'));         
		$crud->field_type('boletin','dropdown',array('0' => 'No', '1' => 'Si'));         
		$crud->field_type('tipoE','dropdown',array('A' => 'A&ntilde;o', 'M' => 'Mes', 'D' => 'D&iacute;a', 'T' => 'Todos'));         
		$crud->field_type('clave','dropdown',$tematico);         
		$crud->order_by('diagno', 'ASC');
		
		$crud->unset_read();
		
		$output = $crud->render();

		$this->_example_output1($output);
    }

	//Grocery Crud: Listado de tipos de diagnósticos
    public function listarClasificacion()
    {
		$crud = new grocery_CRUD();

		$crud->set_table('vigilancia');
		$crud->columns('registroId','codigo','denominacion');
		$crud->display_as('registroId','Item');
		$crud->set_subject('Vigilancia');
		
		$output = $crud->render();

		$this->_example_output2($output);
    }

	//Grocery Crud: Listado de tipos de diagnósticos
    public function listarDiagno()
    {
		$crud = new grocery_CRUD();

		$crud->set_table('tipo_dx');
		$crud->columns('registroId','codigo','denominacion');
		$crud->display_as('registroId','Item');
		$crud->set_subject('Tipo');
		
		$output = $crud->render();

		$this->_example_output3($output);
    }

	//Grocery Crud: Listado de diresas
    public function listarDiresas()
    {
		$crud = new grocery_CRUD();

		$crud->set_table('diresas');
		$crud->columns('codigo','nombre');
		$crud->order_by('nombre');
		$crud->set_subject('DIRESA');
		
		$output = $crud->render();

		$this->_example_output4($output);
    }

	//Grocery Crud: Listado de redes de salud
    public function listarRedes()
    {
		$subreg = $this->mantenimiento_model->buscarDiresas();
		
		$subregion = array();
		
		foreach($subreg as $dato)
		{
			$subregion[$dato->codigo] = $dato->nombre;
		}
		
		$estado = array('1' => 'Activo', '2' => 'Desactivado');
		
		$crud = new grocery_CRUD();

		$crud->set_table('redes');
		$crud->columns('subregion','codigo','nombre', 'estado');
		$crud->order_by('subregion', 'ASC');
		$crud->display_as('subregion', 'Diresas');
		$crud->set_subject('Redes');
		$crud->field_type('subregion','dropdown',$subregion);         
		$crud->field_type('estado','dropdown',$estado);         

		$crud->unset_read();

		$output = $crud->render();

		$this->_example_output5($output);
    }

	//Grocery Crud: Listado de microredes de salud
    public function listarMicroredes()
    {
		$subreg = $this->mantenimiento_model->buscarDiresas();
		
		$subregion = array();
		
		foreach($subreg as $dato)
		{
			$subregion[$dato->codigo] = $dato->nombre;
		}
		
		$red = $this->mantenimiento_model->mostrarRedes();
		
		$redes = array();
		
		foreach($red as $dato)
		{
			$redes[$dato->codigo] = $dato->nombre;
		}
		
		$estado = array('1' => 'Activo', '2' => 'Desactivado');
		
		$crud = new grocery_CRUD();

		$crud->set_table('microred');
		$crud->set_relation('subregion','diresas','nombre', 'estado');
		$crud->order_by('subregion, red', 'ASC');
		$crud->set_subject('Microred');
		$crud->field_type('estado','dropdown',$estado);         
		
		$crud->unset_edit();
		$crud->unset_add();
		$crud->unset_read();
			
		$crud->add_action('Modificar microred', '', 'backend/sistema/modMicrored','edit-icon');
		///////////////////////////////////////////////////////////////////////////////
		$crud->add_action_peru('A&ntilde;adir microred', '', 'addMicrored','add-icon');
		///////////////////////////////////////////////////////////////////////////////
		
		$output = $crud->render();

		$this->_example_output6($output);
    }

	//Registra una nueva microred
    public function addMicrored()
    {
        if($this->input->post()){
            if ($this->form_validation->run("sistema/microred"))
            {
				$data = array
				(
					"subregion"=>$this->input->post("diresa", true),
					"red"=>$this->input->post("redes", true),
					"codigo"=>$this->input->post("codigo", true),
					"nombre"=>$this->input->post("nombre", true)
				);
						
				$guardar = $this->mantenimiento_model->insertarMicrored($data);
						
				if($guardar)
				{
					$this->session->set_flashdata('ControllerMessage', 'Registro Ingresado exitosamente.');
					redirect(site_url('backend/sistema/listarMicroredes'), 301);
				}else{
					redirect('backend/sistema/addMicrored', 301);
				}
            }
        }
       
		$result = $this->mantenimiento_model->buscarDiresas();
		$diresa[''] = 'Seleccione ...';
		foreach ($result as $dato){
			$diresa[$dato->codigo] = $dato->nombre;
		}
		
        $this->layout->view("addMicrored", compact('diresa'));
	}

	//Modifica una microred
    public function modMicrored($id=null)
    {
		if(!$id)
		{
			show_404();
		}
		
        if($this->input->post()){
            if ($this->form_validation->run("sistema/microred"))
            {
				$data = array
				(
					"subregion"=>$this->input->post("diresa", true),
					"red"=>$this->input->post("redes", true),
					"codigo"=>$this->input->post("codigo", true),
					"nombre"=>$this->input->post("nombre", true),
					"estado"=>$this->input->post("estado", true)
				);
						
				$guardar = $this->mantenimiento_model->ejecutarModificar($data, $id);
						
				if($guardar)
				{
					$this->session->set_flashdata('ControllerMessage', 'Registro Modificado exitosamente.');
					redirect(site_url('backend/sistema/listarMicroredes'), 'refresh');
				}else{
					redirect('backend/sistema/modMicrored', 301);
				}
            }
        }
		
		$modificar = $this->mantenimiento_model->mostrarMicrored($id);
		
		$result = $this->mantenimiento_model->buscarDiresas();
		
		$diresa[''] = 'Seleccione ...';
		foreach ($result as $dato){
			$diresa[$dato->codigo] = $dato->nombre;
		}
		
		$subreg = $modificar->subregion;
		
		$result = $this->mantenimiento_model->buscarRedes($subreg);
		
		$redes[''] = 'Seleccione ...';
		foreach ($result as $dato){
			$redes[$dato->codigo] = $dato->nombre;
		}
  
        $this->layout->view("modMicrored", compact('diresa', 'redes', 'modificar'));
	}

	//Grocery Crud: Listado de establecimientos de salud
    public function listarEstablecimientos()
    {
		$subreg = $this->mantenimiento_model->buscarDiresas();
		
		$subregion = array();
		
		foreach($subreg as $dato)
		{
			$subregion[$dato->codigo] = $dato->nombre;
		}
		
		$red = $this->mantenimiento_model->mostrarRedes();
		
		$redes = array();
		
		foreach($red as $dato)
		{
			$redes[$dato->codigo] = $dato->nombre;
		}
		
		$estado = array('1' => 'Activo', '0' => 'Desactivado', '2' => 'Inactivo');

		$crud = new grocery_CRUD();

		$crud->set_table('renace');
		$crud->columns('cod_est','renaes','raz_soc','subregion','red','microred','notifica','tipo','nivel','categoria', 'estado');
		$crud->set_relation('subregion','diresas','nombre');
		$crud->order_by('subregion, red', 'ASC');
		$crud->display_as('subregion', 'Diresa');
		$crud->display_as('cod_est', 'C&oacute;digo');
		$crud->display_as('raz_soc', 'Denominaci&oacute;n');
		$crud->display_as('notifica', 'Und. Notificante');
		$crud->field_type('notifica','dropdown',array('N' => 'NO', 'S' => 'SI'));         
		$crud->field_type('tipo','dropdown',array('A' => 'MINSA', 'C' => 'ESSALUD', 'D' => 'FFAA/PNP', 'X' => 'PRIVADOS'));         
		$crud->field_type('nivel','dropdown',array('1' => 'HOSPITAL', '2' => 'CENTRO DE SALUD', '3' => 'PUESTO DE SALUD', '4' => 'OTROS'));         
		$crud->field_type('estado','dropdown',$estado);         
		$crud->set_subject('Establecimiento');
		
		$crud->unset_edit();
		$crud->unset_add();
			
		$crud->add_action('Modificar establecimiento', '', 'backend/sistema/modEstablecimiento','edit-icon');
		///////////////////////////////////////////////////////////////////////////////
		$crud->add_action_peru('A&ntilde;adir establecimiento', '', 'addEstablecimiento','add-icon');
		///////////////////////////////////////////////////////////////////////////////
		
		$output = $crud->render();

		$this->_example_output7($output);
    }

	//Registra nuevo establecimiento
    public function addEstablecimiento()
    {
        if($this->input->post()){
            if ($this->form_validation->run("sistema/establecimiento"))
            {
				$data = array
				(
					"subregion"=>$this->input->post("diresa", true),
					"red"=>$this->input->post("redes", true),
					"microred"=>$this->input->post("microred", true),
					"cod_est"=>$this->input->post("codigo", true),
					"renaes"=>$this->input->post("renaes", true),
					"raz_soc"=>$this->input->post("nombre", true),
					"notifica"=>$this->input->post("notifica", true),
					"tipo"=>$this->input->post("tipo", true),
					"nivel"=>$this->input->post("nivel", true),
					"categoria"=>$this->input->post("categoria", true)
				);
						
				$guardar = $this->mantenimiento_model->insertarEstablecimiento($data);
						
				if($guardar)
				{
					$this->session->set_flashdata('ControllerMessage', 'Registro Ingresado exitosamente.');
					redirect(site_url('backend/sistema/listarEstablecimientos'), 301);
				}else{
					redirect('backend/sistema/addEstablecimiento', 301);
				}
            }
        }
       
		$result = $this->mantenimiento_model->buscarDiresas();
		$diresa[''] = 'Seleccione ...';
		foreach ($result as $dato){
			$diresa[$dato->codigo] = $dato->nombre;
		}
		
        $this->layout->view("addEstablecimiento", compact('diresa'));
	}

	//Modifica una microred
    public function modEstablecimiento($id=null)
    {
		if(!$id)
		{
			show_404();
		}
		
        if($this->input->post()){
            if ($this->form_validation->run("sistema/microred"))
            {
				$data = array
				(
					"subregion"=>$this->input->post("diresa", true),
					"red"=>$this->input->post("redes", true),
					"microred"=>$this->input->post("microred", true),
					"cod_est"=>$this->input->post("codigo", true),
					"renaes"=>$this->input->post("renaes", true),
					"raz_soc"=>$this->input->post("nombre", true),
					"notifica"=>$this->input->post("notifica", true),
					"tipo"=>$this->input->post("tipo", true),
					"nivel"=>$this->input->post("nivel", true),
					"categoria"=>$this->input->post("categoria", true),
					"estado"=>$this->input->post("estado", true)
				);
				
				$guardar = $this->mantenimiento_model->ejecutarModificarEstablecimiento($data, $id);
						
				if($guardar)
				{
					$this->session->set_flashdata('ControllerMessage', 'Registro Modificado exitosamente.');
					redirect(site_url('backend/sistema/listarEstablecimientos'), 'refresh');
				}else{
					redirect('backend/sistema/modEstablecimiento', 301);
				}
            }
        }
		
		$modificar = $this->mantenimiento_model->mostrarEstablecimiento($id);
		
		$result = $this->mantenimiento_model->buscarDiresas();
		
		$diresa[''] = 'Seleccione ...';
		foreach ($result as $dato){
			$diresa[$dato->codigo] = $dato->nombre;
		}
		
		$result = $this->mantenimiento_model->buscarRedes($modificar->subregion);
		
		$redes[''] = 'Seleccione ...';
		foreach ($result as $dato){
			$redes[$dato->codigo] = $dato->nombre;
		}
		
		$result = $this->mantenimiento_model->buscarMicroredes($modificar->subregion, $modificar->red);
		
		$microred[''] = 'Seleccione ...';
		foreach ($result as $dato){
			$microred[$dato->codigo] = $dato->nombre;
		}
		
        $this->layout->view("modEstablecimiento", compact('diresa', 'redes', 'microred', 'modificar'));
	}

	//Grocery Crud: Listado de departamentos
    public function listarDepartamentos()
    {
		$crud = new grocery_CRUD();

		$crud->set_table('departamento');
		$crud->columns('ubigeo','nombre');
		$crud->order_by('nombre');
		$crud->set_subject('departamento');
		
		$output = $crud->render();

		$this->_example_output8($output);
    }

	//Grocery Crud: Listado de provincias del Perú
    public function listarProvincias()
    {
		$depar = $this->mantenimiento_model->mostrarDepartamentos();
		
		$departamento = array();
		
		foreach($depar as $dato)
		{
			$departamento[$dato->ubigeo] = $dato->nombre;
		}
		
		$crud = new grocery_CRUD();

		$crud->set_table('provincia');
		$crud->columns('departamento','ubigeo','nombre');
		$crud->order_by('departamento', 'ASC');
		$crud->display_as('subregion', 'Diresas');
		$crud->set_subject('Redes');
		$crud->field_type('departamento','dropdown',$departamento);         
		
		$output = $crud->render();

		$this->_example_output9($output);
    }

	//Grocery Crud: Listado de distritos del Perú
    public function listarDistritos()
    {
		$depar = $this->mantenimiento_model->mostrarDepartamentos();
		
		$departamento = array();
		
		foreach($depar as $dato)
		{
			$departamento[$dato->ubigeo] = $dato->nombre;
		}
		
		$crud = new grocery_CRUD();

		$crud->set_table('distrito');
		$crud->columns('departamento','provinci','ubigeo','nombre');
		$crud->order_by('nombre', 'ASC');
		$crud->set_relation('departamento','departamento','nombre');
		$crud->set_relation('provinci','provincia','nombre');
		$crud->display_as('provinci','Provincia');
		$crud->order_by('departamento','ASC');
		$crud->set_subject('Distrito');
		
		$output = $crud->render();

		$this->_example_output10($output);
    }

	//Grocery Crud: Listado del menú principal del sistema
    public function listarMenu()
    {
		$crud = new grocery_CRUD();

		$crud->set_table('menu_frontend');
		$crud->order_by('orden', 'ASC');
		$crud->set_subject('Men&uacute;');
		$crud->field_type('estado','dropdown',array('1'=>'Activado', '2'=>'Desactivado'));         
		
		$output = $crud->render();

		$this->_example_output11($output);
    }

	//Grocery Crud: Listado de submenús del sistema principal de menús
    public function listarSubMenu()
    {
		$men = $this->mantenimiento_model->mostrarMenu();
		
		$menu = array();
		
		foreach($men as $dato)
		{
			$menu[$dato->registroId] = $dato->denominacion;
		}
		
		$crud = new grocery_CRUD();

		$crud->set_table('submenu_frontend');
		$crud->order_by('orden', 'ASC');
		$crud->set_subject('Sub-Men&uacute;');
		$crud->field_type('menu','dropdown',$menu);         
		$crud->field_type('estado','dropdown',array('1'=>'Activado', '2'=>'Desactivado'));         
		
		$output = $crud->render();

		$this->_example_output12($output);
    }

	//Grocery Crud: Listado de etnias
    public function listarEtnias()
    {
		$crud = new grocery_CRUD();
		
		$crud->columns('registroId','nombre');
		$crud->set_table('etnias');
		$crud->set_subject('Etnia');
		$crud->display_as('registroId', 'Item');
		
		$output = $crud->render();

		$this->_example_output13($output);
    }

	//Grocery Crud: Listado de subetnias
    public function listarSubEtnias()
    {
		$et = $this->mantenimiento_model->mostrarEtnias();
		
		$etnias = array();
		
		foreach($et as $dato)
		{
			$etnias[$dato->registroId] = $dato->nombre;
		}
		
		$crud = new grocery_CRUD();

		$crud->set_table('etniaproc');
		$crud->columns('registroId','nombre','tipo');
		$crud->set_subject('Etnia');
		$crud->display_as('tipo', 'Etnia');
		$crud->field_type('tipo','dropdown',$etnias);         
		$crud->display_as('registroId', 'Item');
		
		$output = $crud->render();

		$this->_example_output14($output);
    }

	//Grocery Crud: Listado de la barra del menú principal del sistema
    public function listarBarra()
    {
		$crud = new grocery_CRUD();

		$crud->set_table('barra_frontend');
		$crud->order_by('orden', 'ASC');
		$crud->set_subject('Acceso');
		$crud->field_type('estado','dropdown',array('1'=>'Activado', '2'=>'Desactivado'));         
		$crud->set_field_upload('imagen','public/images');

		$output = $crud->render();

		$this->_example_output15($output);
    }

	//Grocery Crud: Listado del cierre anual de la base de datos
    public function listarCierre()
    {
		$anio = array();
	
		for($i=date("Y");$i>=2000;$i--)
		{
			$anio[$i] = $i;
		}

		$crud = new grocery_CRUD();
		
		$crud->columns('registroId', 'anio', 'estado');
		$crud->set_table('cierre');
		$crud->display_as('registroId', 'Item');
		$crud->display_as('anio', 'A&ntilde;o');
		$crud->order_by('anio', 'DESC');
		$crud->set_subject('Cierre');
		$crud->field_type('estado','dropdown',array('1'=>'Activado', '2'=>'Desactivado'));         
		$crud->field_type('anio','dropdown',$anio);         

		$crud->callback_before_insert(array($this, 'cierre_before_insert'));
		$crud->callback_before_update(array($this, 'cierre_before_update'));

		$output = $crud->render();

		$this->_example_output16($output);
    }

	//Grocery Crud: Listado del cierre anual de la base de datos de los módulos
    public function listarCierreModulos()
    {
		$anio = array();
	
		for($i=date("Y");$i>=2000;$i--)
		{
			$anio[$i] = $i;
		}

		$crud = new grocery_CRUD();
		
		$crud->columns('aplicativo', 'anio', 'estado');
		$crud->set_table('cierreapli');
		$crud->display_as('anio', 'A&ntilde;o');
		$crud->order_by('anio', 'DESC');
		$crud->set_subject('Cierre');
		$crud->field_type('estado','dropdown',array('1'=>'Activado', '2'=>'Desactivado'));         
		$crud->field_type('anio','dropdown',$anio);         
		$crud->set_relation('aplicativo','aplicaciones','nombre');

		$output = $crud->render();

		$this->_example_output19($output);
    }

	//Grocery Crud: Listado del registro de auditoria de la base de datos
    public function listarAuditoria()
    {
		$where = array('anio' => date("Y"));
		
		$crud = new grocery_CRUD();
		
		$crud->set_table('auditoria');
		$crud->where($where);
		$crud->display_as('ipentrada', 'Procedencia');
		$crud->display_as('hentrada', 'Hora');
		$crud->display_as('pagina', 'P&aacute;gina');
		$crud->display_as('accion', 'Acci&oacute;n');
		$crud->display_as('anio', 'A&ntilde;o');
		
		$crud->unset_read();
		$crud->unset_edit();
		$crud->unset_delete();
		$crud->unset_print();

		$output = $crud->render();

		$this->_example_output17($output);
    }

	//Grocery Crud: Poner en mantenimiento el sistema
    public function listarEstado()
    {
		$estado = array('0' => '<b>En Mantenimiento</b>', '1' => '<b>En l&iacute;nea</b>');
		
		$crud = new grocery_CRUD();
		
		$crud->set_table('mantenimiento');
		$crud->field_type('estado','dropdown',$estado);         
		
		$crud->unset_add();
		$crud->unset_read();
		//$crud->unset_edit();
		$crud->unset_delete();
		$crud->unset_print();

		$output = $crud->render();

		$this->_example_output18($output);
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

    //Generar backup de la base de datos
    public function asistente()
    {
		set_time_limit(180);
		
		$tables = array();
		$result = $this->mantenimiento_model->mostrarTablas();
		
		$i = 0;
		foreach($result as $dato){
			$tables[$i] = $dato->Tables_in_notiweb;
			$i++;
		}
		
		//cycle through
		foreach($tables as $table){
			$result = $this->mantenimiento_model->listarTablas($table);
			$num_rows = $this->mantenimiento_model->numerarLineas($table);
			$num_fields = $this->mantenimiento_model->numerarColumnas($table);
			
			$return.= 'DROP TABLE '.$table.';';
			$row2 = $this->mantenimiento_model->crearTablas($table);
			
			$i = 0;
			foreach($row2 as $dato){
				$create[$i] = $dato;
				$i++;
			}
			$return.= "\n\n".$create[1].";\n\n";
			
			for ($i = 0; $i < $num_rows; $i++){
				$return.= 'INSERT INTO '.$table.' VALUES(';
				$j = 0;
				foreach($result[$i] as $dato=>$valor){
			   		$return.= '"'.$valor.'"'; 
					   	
					if ($j<($num_fields-1)) { 
						$return.= ','; 
					}
					$j++;
				 }
				$return.= ");\n";
			}
		}
		$return.="\n\n\n";

		$nombreArchivo = 'db-backup-'.date("dmY").'-'.(md5(implode(',',$tables))).'.sql';
		
		header ("Content-Type: application/download");
		header ("Content-Disposition: attachment; filename=$nombreArchivo");
		echo $return;
	}

	function cierre_before_insert($post_array,$primary_key=null)
	{
		$this->mantenimiento_model->cierreBases($post_array['anio']);	 
		return true;
	}

	function cierre_before_update($post_array,$primary_key=null)
	{
		$existe = $this->mantenimiento_model->existe($post_array['anio']);
		
		if($existe > 0){
			$this->mantenimiento_model->abreBases($post_array['anio']);	 
			return true;
		}else{
			$this->mantenimiento_model->cierreBases($post_array['anio']);	 
			return true;
		}
	}
}
