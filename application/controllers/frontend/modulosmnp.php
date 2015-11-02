<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modulosmnp extends CI_Controller {
	
	private $session_id;
	
    public function __construct()
    {
		parent::__construct();
		$this->session_id = $this->session->userdata('usuario');
	
		if(!empty($this->session_id)){
			$this->layout->setLayout('templatemnp');
			$this->layout->setTitle(":: NotiWeb :: Muerte Fetal y Neonatal");
			date_default_timezone_set('America/Lima');
        }else{
            redirect(site_url("index/login"), 301);
        }		

	}

    public function _example_output($output = null)
    {
		
		$accion = 'Listar Mnp';
			
		$this->login_model->auditoriaOperador($this->session_id, $accion);
			
		$this->layout->view('mnp.php', $output);
    }

    public function index()
    {
		$this->_example_output((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
    }
	
	//Grocery Crud: Listado de Fichas del Módulo de la Vigilancia de Muerte Fetal y Neonatal
    public function listarMnp()
    {
		$crud = new grocery_CRUD();

		$crud->set_table('mnp');
		$crud->columns('registroId', 'ape_nom', 'sexo', 'fecha_nac', 'fecha_mte','fecha_reg','usuario');
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

		$crud->field_type('sexo','dropdown',array('M'=>'Masculino', 'F'=>'Femenino', 'I'=>'Indeterminado'));   
		$crud->display_as("registroId", "Ficha");
		$crud->display_as("ape_nom", "Apellidos y Nombres");
		$crud->display_as("fecha_nac", "Fecha de Nacimiento");
		$crud->display_as("fecha_mte", "Defunci&oacute;n");
		$crud->display_as("fecha_reg", "Fecha de Registro");
	
		$crud->unset_add();
		$crud->unset_edit();
		$crud->unset_read();
		$crud->unset_export();
		$crud->unset_delete();
		//$crud->unset_print();		
		
		$crud->add_action_peru('', '', 'RegfichaMnp','add-icon');
		
		$crud->add_action('Eliminar Ficha', base_url().'assets/images/close.png', 'modulosmnp/delFichaMnp','borrar-icon');
		
		$crud->add_action('Modificar Ficha', '', 'modulosmnp/ModfichaMnp','edit-icon');
		$crud->add_action('Ver Ficha', '', 'modulosmnp/VerfichaMnp','read-icon');
		$output = $crud->render();

		$this->_example_output($output);
    }
	
	public function delFichaMnp($id)
    {
        $modificar = $this->fichas_model->buscarMnp($id);
		
		$anio = substr(($modificar->fecha_mte),0,4);
        $apli = 4;
		$clavemnp = $modificar->registroId;
		
        $this->load->model('mantenimiento_mnp');
        $result = $this->mantenimiento_mnp->buscarmte($anio, $apli);
		
		$veomnp = $result->estado;
        
        //echo $clavemnp; die;
		
		if ($veomnp==2)
		{
			$succes = $this->mantenimiento_mnp->eliminarMnp($clavemnp);

			if($succes == true){
                $this->session->set_flashdata('exito', 'Informaci&oacute;n eliminada con &eacute;xito.');
				redirect(site_url('modulosmnp/listarMnp'), 301);
			}
		}else{
            $this->session->set_flashdata('error', 'No se pudo eliminar la informaci&oacute;n.');
			redirect(site_url('modulosmnp/listarMnp'), 301);
        }
    }


	//Registra una nueva ficha Mnp
    public function RegfichaMnp()
    {
        if($this->input->post()){
			$usu = $this->session->userdata("usuario");
			
			$usuario = $usu;
			
			$nivelUsuario = $this->session->userdata("nivel");
			
			//$establec = $this->input->post("establec");
			//$microred = $this->input->post("microred");
			$red = $this->input->post("redes");
			//$diresa = $this->input->post("diresa");
			//$ape_nom = $this->input->post("ape_nom");
			
			//print_r($this->input->post());

        			//echo $ape_nom;
					//exit;
			
			if ($this->form_validation->run("modulosmnp/RegfichaMnp")){
			    //$ape_nom = $this->input->post("ape_nom");
			    $data = array
				(	
					"diresa"=>$this->input->post("diresa", true),
					"microred"=>$this->input->post("microred", true),
					"e_salud"=>$this->input->post("establec", true),
					//"diresa"=>$diresa,
					"red"=>$red,
					//"microred"=>$microred,
					//"e_salud"=>$establec,
					//"ape_nom"=>$ape_nom,
					"anio"=>$this->input->post("ano", true),
					"semana"=>$this->input->post("semana", true),
					"responsabl"=>$this->input->post("responsabl", true),
					"ape_nom"=>$this->input->post("ape_nom", true),
					"apepat"=>$this->input->post("apepat", true),
					"apemat"=>$this->input->post("apemat", true),
					"nombres"=>$this->input->post("nombres", true),
					"sexo"=>$this->input->post("sexo", true),
					"edadges"=>$this->input->post("edadges", true),
					"fecha_nac"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_nac", true)),
					"hora_nac"=>$this->input->post("hora_nac", true),
					"fecha_mte"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_mte", true)),
					"hora_mte"=>$this->input->post("hora_mte", true),
					"lugar_mte"=>$this->input->post("lugar_mte", true),
					"peso_nac"=>$this->input->post("peso_nac", true),
					"tipo_mte"=>$this->input->post("tipo_mte", true),
					"causa_bas"=>$this->input->post("causa_bas", true),
					"estancia"=>$this->input->post("estancia", true),
					"diagno"=>$this->input->post("diagno", true),
					"categoria"=>$this->input->post("categoria", true),
					"codcat"=>$this->input->post("codcat", true),
					"vida"=>$this->input->post("diasvid", true),
					"lugar_par"=>$this->input->post("lugar_par", true),
					"momento"=>$this->input->post("momento", true),
					"ubigeo_res"=>$this->input->post("distrito14_1", true),
					"dni_madre"=>$this->input->post("dni_madre", true),
					'fecha_reg' => date('Y-m-d'),
					"usuario"=>$usuario
				);
				
				$guardar = $this->fichas_model->insertarMnp($data);
				
				if($guardar)
				{
					$this->session->set_flashdata('exito', 'Informaci&oacute;n guardada con &eacute;xito.');
					redirect(site_url('modulosmnp/listarMnp'), 301);
				}else{
					$this->session->set_flashdata('error', 'No se guard&oacute; la informaci&oacute;n registrada.');
					redirect(site_url('regFichaMnp'), 301);
				}
			}
        }
       
		//combo DIRESA
		
		if($this->session->userdata('diresa') == ''){
			$subreg = $this->frontend_model->buscarDiresas();
			
			$diresa = array(''=>'Seleccione ...');
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
				$microred = array(''=>'Seleccione ...');
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
				$institucion = $this->llenaInstitucion2($dato->tipo); 
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
				$establec = array(''=>'Seleccione ...');
				foreach ($est as $dato){
					$establec[$dato->cod_est] = $dato->raz_soc;
				}
			}
		}

		
		//combo Departamentos14_1
		
		$depar = $this->frontend_model->buscarDepartamentos();

		$departamento14_1 = array(""=>'Seleccione ...');
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
    
//	$session_id = $this->session_id;
	
//		if(!empty($this->session_id)){
			$this->layout->view("regFichaMnp", compact('session_id', 'diresa', 'redes', 'microred', 'establec', 'institucion', 'departamento14_1', 'provincia14_1', 'distrito14_1'));
//        }else{
//            redirect(site_url("index/login"), 301);
//        }
                // $this->layout->view("regFichaMnp", compact('session_id', 'diresa', 'redes', 'microred', 'establec', 'institucion', 'departamento14_1', 'provincia14_1', 'distrito14_1'));
    			//print_r($this);
				//echo establec;
				//exit;
	}

    //Modifica el registro de la ficha de MNP
    public function Modfichamnp($id=null)
    {
  		//echo $id; die;
		if(!$id)
	   	{
		  	show_404();
		}
		
      if($this->input->post()){
			 $usu = $this->session->userdata("usuario");
			
			 $usuario = $usu;
			
			 $nivelUsuario = $this->session->userdata("nivel");
			
			 $est = $this->input->post("establec");
			 $mred = $this->input->post("microred");
			 $red = $this->input->post("redes");
			 $subr = $this->input->post("diresa");
			 $ape_nom = $this->input->post("ape_nom");
			
      
			//print_r($this->input->post());
     
			if ($this->form_validation->run("modulosmnp/RegfichaMnp"))
			{
		 
    		$data = array
				(
					"diresa"=>$subr,
					"red"=>$red,
					"microred"=>$mred,
					"e_salud"=>$est,
					"responsabl"=>$this->input->post("responsabl", true),
					"ape_nom"=>$ape_nom,
 					"anio"=>$this->input->post("ano", true),
					"semana"=>$this->input->post("semana", true),         
					"apepat"=>$this->input->post("apepat", true),
					"apemat"=>$this->input->post("apemat", true),
					"nombres"=>$this->input->post("nombres", true),
					"sexo"=>$this->input->post("sexo", true),
					"fecha_nac"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_nac", true)),
					"ubigeo_res"=>$this->input->post("distrito14_1", true),
					"peso_nac"=>$this->input->post("peso_nac", true),
					"edadges"=>$this->input->post("edadges", true),
					"fecha_nac"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_nac", true)),
					"hora_nac"=>$this->input->post("hora_nac", true),
					"fecha_mte"=>$this->fechas_model->arreglarFechas($this->input->post("fecha_mte", true)),
					"hora_mte"=>$this->input->post("hora_mte", true),
					"lugar_mte"=>$this->input->post("lugar_mte", true),
					"tipo_mte"=>$this->input->post("tipo_mte", true),
					"causa_bas"=>$this->input->post("causa_ba", true),
					"categoria"=>$this->input->post("categoria", true),
					"codcat"=>$this->input->post("codcat", true),
					"estancia"=>$this->input->post("estancia", true),
					"diagno"=>$this->input->post("diagno", true),
					"vida"=>$this->input->post("diasvid", true),
					"lugar_par"=>$this->input->post("lugar_par", true),
					"momento"=>$this->input->post("momento", true),
					"dni_madre"=>$this->input->post("dni_madre", true),
					"usuario"=>$usuario
				);
				
				$guardar = $this->fichas_model->ejecutarModificarMnp($data, $id);
				
				if($guardar)
				{
					$this->session->set_flashdata('exito', 'Informaci&oacute;n modificada con &eacute;xito.');
					redirect(site_url('modulosmnp/listarMnp'), 301);
				}else{
					$this->session->set_flashdata('error', 'No se modific&oacute; la informaci&oacute;n registrada.');
					redirect(site_url('modFichaMnp').$id, 301);
				}
            }
		}
    
		$modificar = $this->fichas_model->buscarMnp($id);
		
		if(sizeof($modificar)==0)
		{
			show_404();
		}
							//mira estado de aplicacion con año
                              $anio = substr(($modificar->fecha_mte),0,4);
                              $apli = 4;
							  
                              $this->load->model('mantenimiento_mnp');
                              $result = $this->mantenimiento_mnp->buscarmte($anio, $apli);
                              
                              $veoestado = $result->estado;
							  
                              //echo $veoestado; die;
							  if ($veoestado==1)
								{
									$this->session->set_flashdata('error', 'Fecha de defunci&oacute;n Cerrada : No podra modificar el Registro.');
									redirect(site_url('modulosmnp/listarMnp'), 301);
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
		$est[''] = 'Seleccione ...';
		foreach ($result as $dato){
			$est[$dato->cod_est] = $dato->raz_soc;
		}
		
		$result = $this->mantenimiento_model->buscarProvincias(substr($modificar->ubigeo_res,0,2));
		$prov1[''] = 'Seleccione ...';
		foreach ($result as $dato){
			$prov1[$dato->ubigeo] = $dato->nombre;
		}
		
		$result = $this->mantenimiento_model->buscarDistritos(substr($modificar->ubigeo_res,0,4));
		$dist1[''] = 'Seleccione ...';
		foreach ($result as $dato){
			$dist1[$dato->ubigeo] = $dato->nombre;
		}
//		$session_id = $this->session_id;
		$institucion = $this->llenaInstitucion($modificar->e_salud);
		
//		if(!empty($this->session_id)){
			$this->layout->view("modFichaMnp", compact("id", "modificar", "subr", "red", "mred", "est", "prov1", "dist1", "institucion"));
//        }else{
//            redirect(site_url("index/login"), 301);
//        }		
		//$this->layout->view("modFichaMnp", compact("id", "modificar", "subr", "red", "mred", "est", "prov1", "dist1", "institucion"));
    }

    //Ver el registro de la ficha de Mnp
    public function VerfichaMnp($id=null)
    {
		if(!$id)
		{
			show_404();
		}
		
		$modificar = $this->fichas_model->buscarMnp($id);
		
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
		$est[''] = 'Seleccione ...';
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
			
		$institucion = $this->llenaInstitucion($modificar->e_salud);
		
		$this->layout->view("verFichaMnp", compact("id", "modificar", "subr", "red", "mred", "est", "prov", "dist", "institucion"));
  }

	//Exporta la base de datos de la ficha de Muertes Perinatales
	public function exportarMnp2()
	{
		date_default_timezone_set('America/Lima');
		
		switch($this->session->userdata("nivel"))
		
		{
			case '8':
			$where = array("e_salud"=>$this->session->userdata("establecimiento") );
      
			$query = $this->db
        ->select("diresas.nombre as Subregion, renace.raz_soc as Establecimiento, redes.nombre as Red, microred.nombre as MicroRed, departamento.nombre as Departamento, provincia.nombre as Provincia, distrito.nombre as Distrito, mnp.*")  
        ->from ("mnp") 
        ->join('diresas','codigo = mnp.diresa')
        ->join('renace','renace.cod_est = mnp.e_salud')
        ->join('redes','redes.subregion = renace.subregion and redes.codigo = renace.red')
        ->join('microred','microred.subregion = renace.subregion and microred.red = renace.red and microred.codigo = renace.microred')
        ->join('departamento','departamento.ubigeo = SUBSTRING(mnp.ubigeo_res,1,2)')
        ->join('provincia','provincia.ubigeo = SUBSTRING(mnp.ubigeo_res,1,4)')
        ->join('distrito','distrito.ubigeo = mnp.ubigeo_res')
 				->where($where)
				->get();
			break;
			
      case '7':
			$where = array("mnp.diresa"=>$this->session->userdata("diresa"), "mnp.red"=>$this->session->userdata("red"), "mnp.microred"=>$this->session->userdata("microred"));
			
			$query = $this->db
        ->select("diresas.nombre as Subregion, renace.raz_soc as Establecimiento, redes.nombre as Red, microred.nombre as MicroRed, departamento.nombre as Departamento, provincia.nombre as Provincia, distrito.nombre as Distrito, mnp.*")  
        ->from ("mnp") 
        ->join('diresas','codigo = mnp.diresa')
        ->join('renace','renace.cod_est = mnp.e_salud')
        ->join('redes','redes.subregion = renace.subregion and redes.codigo = renace.red')
        ->join('microred','microred.subregion = renace.subregion and microred.red = renace.red and microred.codigo = renace.microred')
        ->join('departamento','departamento.ubigeo = SUBSTRING(mnp.ubigeo_res,1,2)')
        ->join('provincia','provincia.ubigeo = SUBSTRING(mnp.ubigeo_res,1,4)')
        ->join('distrito','distrito.ubigeo = mnp.ubigeo_res')      
				->where($where)
				->get();
			break;

			case '6':
			$where = array("mnp.diresa"=>$this->session->userdata("diresa"), "mnp.red"=>$this->session->userdata("red"));
			
			$query = $this->db
        ->select("diresas.nombre as Subregion, renace.raz_soc as Establecimiento, redes.nombre as Red, microred.nombre as MicroRed, departamento.nombre as Departamento, provincia.nombre as Provincia, distrito.nombre as Distrito, mnp.*")  
        ->from ("mnp") 
        ->join('diresas','codigo = mnp.diresa')
        ->join('renace','renace.cod_est = mnp.e_salud')
        ->join('redes','redes.subregion = renace.subregion and redes.codigo = renace.red')
        ->join('microred','microred.subregion = renace.subregion and microred.red = renace.red and microred.codigo = renace.microred')
        ->join('departamento','departamento.ubigeo = SUBSTRING(mnp.ubigeo_res,1,2)')
        ->join('provincia','provincia.ubigeo = SUBSTRING(mnp.ubigeo_res,1,4)')
        ->join('distrito','distrito.ubigeo = mnp.ubigeo_res')      
				->where($where)
				->get();
			break;
      
			case '5':
			$where = array("mnp.diresa"=>$this->session->userdata("diresa"));
			
			$query = $this->db
        ->select("diresas.nombre as Subregion, renace.raz_soc as Establecimiento, redes.nombre as Red, microred.nombre as MicroRed, departamento.nombre as Departamento, provincia.nombre as Provincia, distrito.nombre as Distrito, mnp.*")  
        ->from ("mnp") 
        ->join('diresas','codigo = mnp.diresa')
        ->join('renace','renace.cod_est = mnp.e_salud')
        ->join('redes','redes.subregion = renace.subregion and redes.codigo = renace.red')
        ->join('microred','microred.subregion = renace.subregion and microred.red = renace.red and microred.codigo = renace.microred')
        ->join('departamento','departamento.ubigeo = SUBSTRING(mnp.ubigeo_res,1,2)')
        ->join('provincia','provincia.ubigeo = SUBSTRING(mnp.ubigeo_res,1,4)')
        ->join('distrito','distrito.ubigeo = mnp.ubigeo_res')      
      	->where($where)
				->get();
			break;
			
      default:
            $where = "anio = 2010";
			$query = $this->db
        ->select("diresas.nombre as Subregion, renace.raz_soc as Establecimiento, redes.nombre as Red, microred.nombre as MicroRed, departamento.nombre as Departamento, provincia.nombre as Provincia, distrito.nombre as Distrito, mnp.*")  
        ->from ("mnp") 
        ->join('diresas','codigo = mnp.diresa')
        ->join('renace','renace.cod_est = mnp.e_salud')
        ->join('redes','redes.subregion = renace.subregion and redes.codigo = renace.red')
        ->join('microred','microred.subregion = renace.subregion and microred.red = renace.red and microred.codigo = renace.microred')
        ->join('departamento','departamento.ubigeo = SUBSTRING(mnp.ubigeo_res,1,2)')
        ->join('provincia','provincia.ubigeo = SUBSTRING(mnp.ubigeo_res,1,4)')
        ->join('distrito','distrito.ubigeo = mnp.ubigeo_res')  
        ->where($where)		
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
        foreach($query->result() as $data)
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
        header('Content-Disposition: attachment;filename="mnp_'.date('dMy').'.xls"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');

		redirect(site_url('mnp/principal'), 301);

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

    //Llena la caja institucion segun tipo de Establecimiento
	public function llenaInstitucion2($id)
	{
		$dato = $id;
										   
		//$dato = substr($filtro1,6,1);
		
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
		foreach ($this->mantenimiento_model->buscarDistritos($filtro1) as $dato) {
			$dist[$dato->ubigeo] = $dato->nombre;
		}
		echo json_encode($dist);
	}
// autocompletar
	function causas()
	{
		$where = $_GET['termx'];
		$causa =$this->db->query("SELECT * FROM ciex where concat(ciex,descripcion) like '%$where%' and (ciex like 'P%' or ciex like 'Q%')limit 15 ");
		foreach ($causa->result() as $ca) {
			$data[]=array('id'=>$ca->ciex,'value'=>$ca->descripcion,'label'=>$ca->ciex.' - '.$ca->descripcion);
		}
		echo json_encode($data);
	}
	
	function causasMM()
	{
		
		$where = $_GET['term'];
		$causa =$this->db->query("SELECT * FROM cie10 where concat(ciex,descripcion) like '%$where%' and (ciex like 'P%' or ciex like 'Q%') limit 10 ");
		foreach ($causa->result() as $ca) {
			$data[]=array('id'=>$ca->ciex,'value'=>$ca->descripcion,'clave'=>$ca->categoria,'codigo'=>$ca->codcat,'label'=>$ca->ciex.' - '.$ca->descripcion);
		}
		echo json_encode($data);
	}
//	
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

	// Verifica si año de aplicativo esta cerrado
	
  function vercierreaplica()
	{
		$anio = $_GET['anio'];
		$apli = $_GET['apli'];
		$veranio = $this->db->query("SELECT * FROM cierreapli where aplicativo='$apli' and anio='$anio'");
		$data ['estado'] = $veranio->row()->estado;
		echo json_encode($data);
	}  
}
