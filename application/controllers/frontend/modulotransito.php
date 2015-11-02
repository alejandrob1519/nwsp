<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modulotransito extends CI_Controller {

    private $session_id;

	public function __construct()
    {
        parent::__construct();
        $this->session_id = $this->session->userdata('usuario');
        if (empty($this->session_id)) {
        	redirect(site_url("index/login"), 301);
        	//echo "no hay sesion";
        }
        $this->layout->setLayout('template_transito');
        $this->layout->setTitle(":: ACCIDENTES DE TRANSITO :: Vigilancia Epidemiol&oacute;gica");
        date_default_timezone_set('America/Lima');
	}

	public function listar_transito()
	{
		/*$establecimiento = $this->mantenimiento_transito->listarEstablecimiento();

		foreach($establecimiento as $dato){
			$est[$dato->cod_est] = $dato->raz_soc;
		} */

		$crud = new grocery_CRUD();
		//$crud->set_theme('bootstrap');
		$crud->set_table('trans_lesacctra');
		$crud->columns('id', 'ano', 'ap_nm1', 'ap_nm2', 'nom_les', 'edad', 'tipo_edad', 'diresa', 'eess');
		$crud->set_subject('Ficha Transito');

		$nivelUsuario = $this->session->userdata("nivel");

		switch($nivelUsuario){
			case '8':
			$where = array('cod_eess' =>  $this->session->userdata("establecimiento"));
			$crud->where($where);
			break;
			case '7':
			//$where = "where cod_eess in(select cod_est FROM renace where subregion = '$diresa' and red = '$red' and microred = '$microred')";
			$where = array('microred' =>  $this->session->userdata("microred"), 'red' =>  $this->session->userdata("red"), 'cod_dir' =>  $this->session->userdata("diresa"));
			$crud->where($where);
			break;
			case '6':
			//$where = "where cod_eess in(select cod_est FROM renace where subregion = '$diresa' and red = '$red')";
			$where = array('red' =>  $this->session->userdata("red"), 'cod_dir' =>  $this->session->userdata("diresa"));
			$crud->where($where);
			break;
			case '5':
			$where = array('cod_dir' => $this->session->userdata("diresa"));
			$crud->where($where);
			break;
		}

		//$crud->field_type('establec', 'dropdown', $est);
		$crud->display_as("id", "ID")
			->display_as("ano", "AÑO")
			->display_as("ap_nm1", "APELLIDO PATERNO")
			->display_as("ap_nm2", "APELLIDO MATERNO")
			->display_as("nom_les", "NOMBRES")
			->display_as("edad", "EDAD")
			->display_as("tipo_edad", "TIPO")
			->display_as("diresa", "DIRESA")
			->display_as("eess", "ESTABLECIENTO DE SALUD");
		$crud->unset_add();
		$crud->unset_edit();
		$crud->unset_read();
		$crud->unset_print();
		$crud->unset_export();
		$crud->unset_delete();
		$crud->order_by('id','desc');

		$crud->add_action('Eliminar Ficha', base_url().'assets/images/close.png', 'modulotransito/borrarFichatransito','borrar-icon');
		$crud->add_action('Vista previa', '', 'modulotransito/ver_ficha_transito','read-icon');
		$crud->add_action('Editar Ficha Transito', '', 'modulotransito/modificacion_transito','edit-icon');

		$output = $crud->render();


		$usuario = $this->session->userdata("usuario");

		$accion = 'Listar Casos Accidentes de Transito';

		$this->login_model->auditoriaOperador($usuario, $accion);

		$this->layout->view('listar_transito', $output);
	}

	public function borrarFichatransito($id)
	{
       

       	// comprobar el cierre de año de registro
	    $anio = $this->mantenimiento_transito->getAnioRegTrans($id); 
	    $apli = 9;
	    $estado = $this->mantenimiento_transito->getEstado($anio, $apli);	      
	    
        if ($estado==1)
	    {
	       	$this->session->set_flashdata('error', 'Este registro tiene el año Cerrado : No podra eliminarlo.');
	       	redirect(site_url('modulotransito/listar_transito'), 301);
	    }else{
           	$this->mantenimiento_transito->borrarFicha($id);
           	$this->session->set_flashdata('exito', 'se elimino correctamente.');
           	redirect(site_url('modulotransito/listar_transito'), 301);
       	}


	}

	public function registro_transito()
	{	
		//codigo para restringir el acceso a la ficha
		$acceso = $this->login_model->loginAccesoFichas($this->session->userdata('usuario'), '9');
		if(count($acceso) != 0){
			$usuario = $this->session->userdata("usuario");
		}else{
			$this->session->set_flashdata('alerta', 'Alerta: No tiene acceso a la ficha epidemiol&oacute;gica elegida.');
			redirect(site_url("index/login"), 301);
		}

		// accion al hacer el post
        if($this->input->post()){

			//codigo pra auditoria
			$accion 	= 'post en registro_transito';
			$this->login_model->auditoriaOperador($this->input->post("usuario"), $accion);


			$usuario = $this->session->userdata("usuario");
			$random 	= rand(5, 15);
			$fichanum = $this->input->post("cod_eess") . '-' . $random;

			$fechaE 	= str_replace('-', '', $this->input->post("fec_accd"));
			$horaE 	= str_replace(':', '', $this->input->post("hor_accid"));
			$viaE 	= $this->input->post("via_accd");
			$evento 	= $this->input->post("dist_acc") . '-' . $fechaE .'-' . $horaE.'-'.$viaE;
			//if ($this->form_validation->run("modulotransito/registrar")) {
			$nomEESS = $this->mantenimiento_transito->mostrarEstablecimiento($this->input->post("cod_eess"));

				$data = array(
					"fuen_finc"=>$this->input->post("fuen_finc"),
					"hce"=>$this->input->post("hce"),
					"hch"=>$this->input->post("hch"),
					"ref_es"=>$this->input->post("ref_es"),
					"referi"=>$this->input->post("referi"),
					"ap_nm1"=>$this->input->post("ap_nm1"),
					"ap_nm2"=>$this->input->post("ap_nm2"),
					"nom_les"=>$this->input->post("nom_les"),
					"cod_dir"=>$this->input->post("cod_dir"),
					"diresa"=>$this->mantenimiento_transito->getDiresa($this->input->post("cod_dir")),
					"red"=>$this->input->post("redes_not"),
					"microred"=>$this->input->post("microred_not"),
					"cod_eess"=>$this->input->post("cod_eess"),
					"eess"=>$nomEESS->raz_soc,
					"dni"=>$this->input->post("dni"),
					"edad"=>$this->input->post("edad"),
					"tipo_edad"=>$this->input->post("tipo_edad"),
					"sexo"=>$this->input->post("sexo"),
					"depar"=>$this->mantenimiento_transito->getdepartamento($this->input->post("depar")),
					"prov"=> $this->mantenimiento_transito->getprovincia($this->input->post("depar"), $this->input->post("prov")),
					"dis"=>$this->mantenimiento_transito->getdistrito($this->input->post("dis")),
					"ubigeo"=>$this->input->post("dis"),
					"direccion"=>$this->input->post("direccion"),
					"ing_eess"=>$this->fechas_model->arreglarfechas($this->input->post("ing_eess")),
					"hora"=>$this->input->post("hora"),
					"dx1"=>$this->input->post("dx1"),
					"dx2"=>$this->input->post("dx2"),
					"dx3"=>$this->input->post("dx3"),
					"fech_egre"=>$this->fechas_model->arreglarfechas($this->input->post("fech_egre")),
					"cond_egr"=>$this->input->post("cond_egr"),
					"refer"=>$this->input->post("refer"),
					"rehab"=>$this->input->post("rehab"),
					"fec_accd"=>$this->fechas_model->arreglarfechas($this->input->post("fec_accd")),
					"hor_accid"=>$this->input->post("hor_accid"),
					"lug_accid"=>$this->input->post("lug_accid"),
					"depar_acc"=>$this->mantenimiento_transito->getdepartamento($this->input->post("depar_acc")),
					"prov_acc"=>$this->mantenimiento_transito->getprovincia($this->input->post("depar_acc"), $this->input->post("prov_acc")),
					"dist_acc"=>$this->mantenimiento_transito->getdistrito($this->input->post("dist_acc")),
					"ubigeo_ac"=>$this->input->post("dist_acc"),
					"via_accd"=>$this->input->post("via_accd"),
					"tp_accd"=>$this->input->post("tp_accd"),
					"veh_moto"=>$this->input->post("veh_moto"),
					"ub_les"=>$this->input->post("ub_les"),
					"trasl_les"=>$this->input->post("trasl_les"),
					"tp_moto"=>$this->input->post("tp_moto"),
					"tp_condi"=>$this->input->post("tp_condi"),
					"tp_nomoto"=>$this->input->post("tp_nomoto"),
					"nom_condc1"=>$this->input->post("nom_condc1"),
					"ape_condc"=>$this->input->post("ape_condc"),
					"nom_condc2"=>$this->input->post("nom_condc2"),
					"ed_cond"=>$this->input->post("ed_cond"),
					"sex_cond"=>$this->input->post("sex_cond"),
					"lic_conduc"=>$this->input->post("lic_conduc"),
					"comisar"=>$this->input->post("comisar"),
					"dep_com"=>$this->mantenimiento_transito->getdepartamento($this->input->post("dep_com")),
					"prov_com"=> $this->mantenimiento_transito->getprovincia($this->input->post("dep_com"), $this->input->post("prov_com")),
					"dist_com"=>$this->mantenimiento_transito->getdistrito($this->input->post("dist_com")),
					"ubigeo_com"=>$this->input->post("dist_com"),
					"num_pol"=>$this->input->post("num_pol"),
					"num_plac"=>$this->input->post("num_plac"),
					"nom_duepol"=>$this->input->post("nom_duepol"),
					"aseg"=>$this->input->post("aseg"),
					"otroaseg"=>$this->input->post("otroaseg"),
					"ano"=>(substr($this->input->post("ing_eess"), 6, 4)),
					"fichanum"=>$fichanum,
					"tpa_otro"=>$this->input->post("tpa_otro"),
					"evento"=> $evento
				);


				$guardar = $this->mantenimiento_transito->insertarTransLesacctra($data);

				if($guardar)
				{
					$this->session->set_flashdata('exito', 'Informaci&oacute;n guardada con &eacute;xito.');
					redirect(site_url('modulotransito/listar_transito'), 301);
				}else{
					$this->session->set_flashdata('error', 'Se encontraron errores en la informaci&oacute;n registrada.');
				}

		/*	}else{
				$this->session->set_flashdata('error', 'Se encontraron errores en la informaci&oacute;n registrada.');
			} */
		}

		//combo DIRESA
		$diresa = $this->getDiresasPorNivel($this->input->post('diresa'));
		//combo Red
		$redes = $this->getRedesPorNivel($this->input->post('diresa'), $this->input->post('redes'));
		//combo Microred
		$microred = $this->getMicroRedesPorNivel($this->input->post('diresa'), $this->input->post('redes'), $this->input->post('microred'));
		//combo Establecimiento
		$establec = $this->getEstablecPorNivel($this->input->post('diresa'), $this->input->post('redes'), $this->input->post('microred'), $this->input->post('establec'));



		// PARA REFERIDOS ** Diresa ** (nivel nacional)
		$subregNac = $this->mantenimiento_transito->buscarDiresas();

		$diresaNac[''] = 'Seleccione ...';
		foreach ($subregNac as $dato){
			$diresaNac[$dato->codigo] = $dato->nombre;
		}


		//combo Departamentos
		$depar = $this->mantenimiento_transito->buscarDepartamentos();

		$departamento[''] = 'Seleccione ...';
		foreach ($depar as $dato){
			$departamento[$dato->ubigeo] = $dato->nombre;
		}

		$provincia = array(''=>'Seleccione...');
		$distrito = array(''=>'Seleccione...');

		//combo Provincias

		if($this->input->post('departamento') != ''){
			$prov = $this->mantenimiento_transito->buscarProvincias($this->input->post('departamento'));

			//$provincia[''] = 'Seleccione ...';
			foreach ($prov as $dato){
				$provincia[$dato->ubigeo] = $dato->nombre;
			}
		}

		//combo Distrito

		if($this->input->post('provincia') != ''){
			$dist = $this->mantenimiento_transito->buscarDistritos($this->input->post('provincia'));

			//$distrito[''] = 'Seleccione ...';
			foreach ($dist as $dato){
				$distrito[$dato->ubigeo] = $dato->nombre;
			}
		}

        //$indicadora = array();
		$ciex = $this->mantenimiento_transito->listarDiagnoMedico();

		foreach ($ciex as $dato){
			$indicadora[$dato->CIE_10] = '"'.$dato->DIAGNO.'"';
		}
		$indicadora[''] = 'Seleccione ...';

		//$indicadora = implode(',', $indicadora);
		//echo '<pre>';
		//var_dump($ciex); die;
		//combo Departamentos

		$depar = $this->mantenimiento_transito->buscarDepartamentos();

		$departamento_accidente[''] = 'Seleccione ...';
		foreach ($depar as $dato){
			$departamento_accidente[$dato->ubigeo] = $dato->nombre;
		}

		$provincia_accidente = array(''=>'Seleccione...');
		$distrito_accidente = array(''=>'Seleccione...');

		//combo Provincias

		if($this->input->post('departamento_accidente') != ''){
			$prov = $this->mantenimiento_transito->buscarProvincias($this->input->post('departamento_accidente'));

			//$provincia[''] = 'Seleccione ...';
			foreach ($prov as $dato){
				$provincia_accidente[$dato->ubigeo] = $dato->nombre;
			}
		}

		//combo Distrito

		if($this->input->post('provincia_accidente') != ''){
			$dist = $this->mantenimiento_transito->buscarDistritos($this->input->post('provincia_accidente'));

			//$distrito[''] = 'Seleccione ...';
			foreach ($dist as $dato){
				$distrito_accidente[$dato->ubigeo] = $dato->nombre;
			}
		}

		//combo Departamentos

		$depar = $this->mantenimiento_transito->buscarDepartamentos();

		$departamento_cond[''] = 'Seleccione ...';
		foreach ($depar as $dato){
			$departamento_cond[$dato->ubigeo] = $dato->nombre;
		}

		$provincia_cond = array(''=>'Seleccione...');
		$distrito_cond = array(''=>'Seleccione...');

		//combo Provincias

		if($this->input->post('departamento_cond') != ''){
			$prov = $this->mantenimiento_transito->buscarProvincias($this->input->post('departamento_cond'));

			//$provincia[''] = 'Seleccione ...';
			foreach ($prov as $dato){
				$provincia_cond[$dato->ubigeo] = $dato->nombre;
			}
		}

		//combo Distrito

		if($this->input->post('provincia_cond') != ''){
			$dist = $this->mantenimiento_transito->buscarDistritos($this->input->post('provincia_cond'));

			//$distrito[''] = 'Seleccione ...';
			foreach ($dist as $dato){
				$distrito_aid[$dato->ubigeo] = $dato->nombre;
			}
		}


		$this->layout->view('registro_transito', compact('diresaNac','diresa','redes','microred','establec','departamento',
														 'provincia','distrito','departamento_accidente','provincia_accidente',
														 'distrito_accidente','departamento_cond','provincia_cond','distrito_aid',
														 'departamento_def','provincia_def','distrito_def','indicadora'));
	}

	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	public function modificacion_transito($id=null)
	{
		if(!$id)
		{
			show_404();
		}


		// comprobar el cierre de año de registro
	    $anio = $this->mantenimiento_transito->getAnioRegTrans($id); 
	    $apli = 9;
	    $estado = $this->mantenimiento_transito->getEstado($anio, $apli);	      
	    
        if ($estado==1)
             {
                 $this->session->set_flashdata('error', 'Este registro tiene el año Cerrado : No podra modificarlo.');
                 redirect(site_url('modulotransito/listar_transito'), 301);
             }
      

		//codigo para restringir el acceso a la ficha
		$acceso = $this->login_model->loginAccesoFichas($this->session->userdata('usuario'), '9');
		if(count($acceso) != 0){
			$usuario = $this->session->userdata("usuario");
		}else{
			$this->session->set_flashdata('alerta', 'Alerta: No tiene acceso a la ficha epidemiol&oacute;gica elegida.');
			redirect(site_url("index/login"), 301);
		}


		// accion al hacer el post
		if($this->input->post()){

			//codigo para auditoria
			$accion = 'Modificacion ficha Transito';
			$this->login_model->auditoriaOperador($this->input->post("usuario"), $accion);

			$usuario = $this->session->userdata("usuario");
			$random 	= rand(5, 15);
			$fichanum = $this->input->post("cod_eess") . '-' . $random;

			$fechaE 	= str_replace('-', '', $this->input->post("fec_accd"));
			$horaE 	= str_replace(':', '', $this->input->post("hor_accid"));
			$viaE 	= $this->input->post("via_accd");
			$evento 	= $this->input->post("dist_acc") . '-' . $fechaE .'-' . $horaE.'-'.$viaE;
			//if ($this->form_validation->run("modulotransito/registrar")) {
			$nomEESS = $this->mantenimiento_transito->mostrarEstablecimiento($this->input->post("cod_eess"));

				$data = array(
					"fuen_finc"=>$this->input->post("fuen_finc"),
					"hce"=>$this->input->post("hce"),
					"hch"=>$this->input->post("hch"),
					"ref_es"=>$this->input->post("ref_es"),
					"referi"=>$this->input->post("referi"),
					"ap_nm1"=>$this->input->post("ap_nm1"),
					"ap_nm2"=>$this->input->post("ap_nm2"),
					"nom_les"=>$this->input->post("nom_les"),
					"cod_dir"=>$this->input->post("cod_dir"),
					"diresa"=>$this->mantenimiento_transito->getDiresa($this->input->post("cod_dir")),
					"red"=>$this->input->post("redes_not"),
					"microred"=>$this->input->post("microred_not"),
					"cod_eess"=>$this->input->post("cod_eess"),
					"eess"=>$nomEESS->raz_soc,
					"dni"=>$this->input->post("dni"),
					"edad"=>$this->input->post("edad"),
					"tipo_edad"=>$this->input->post("tipo_edad"),
					"sexo"=>$this->input->post("sexo"),
					"depar"=>$this->mantenimiento_transito->getdepartamento($this->input->post("depar")),
					"prov"=> $this->mantenimiento_transito->getprovincia($this->input->post("depar"), $this->input->post("prov")),
					"dis"=>$this->mantenimiento_transito->getdistrito($this->input->post("dis")),
					"ubigeo"=>$this->input->post("dis"),
					"direccion"=>$this->input->post("direccion"),
					"ing_eess"=>$this->fechas_model->arreglarfechas($this->input->post("ing_eess")),
					"hora"=>$this->input->post("hora"),
					"dx1"=>$this->input->post("dx1"),
					"dx2"=>$this->input->post("dx2"),
					"dx3"=>$this->input->post("dx3"),
					"fech_egre"=>$this->fechas_model->arreglarfechas($this->input->post("fech_egre")),
					"cond_egr"=>$this->input->post("cond_egr"),
					"refer"=>$this->input->post("refer"),
					"rehab"=>$this->input->post("rehab"),
					"fec_accd"=>$this->fechas_model->arreglarfechas($this->input->post("fec_accd")),
					"hor_accid"=>$this->input->post("hor_accid"),
					"lug_accid"=>$this->input->post("lug_accid"),
					"depar_acc"=>$this->mantenimiento_transito->getdepartamento($this->input->post("depar_acc")),
					"prov_acc"=> $this->mantenimiento_transito->getprovincia($this->input->post("depar_acc"), $this->input->post("prov_acc")),
					"dist_acc"=>$this->mantenimiento_transito->getdistrito($this->input->post("dist_acc")),
					"ubigeo_ac"=>$this->input->post("dist_acc"),
					"via_accd"=>$this->input->post("via_accd"),
					"tp_accd"=>$this->input->post("tp_accd"),
					"veh_moto"=>$this->input->post("veh_moto"),
					"ub_les"=>$this->input->post("ub_les"),
					"trasl_les"=>$this->input->post("trasl_les"),
					"tp_moto"=>$this->input->post("tp_moto"),
					"tp_condi"=>$this->input->post("tp_condi"),
					"tp_nomoto"=>$this->input->post("tp_nomoto"),
					"nom_condc1"=>$this->input->post("nom_condc1"),
					"ape_condc"=>$this->input->post("ape_condc"),
					"nom_condc2"=>$this->input->post("nom_condc2"),
					"ed_cond"=>$this->input->post("ed_cond"),
					"sex_cond"=>$this->input->post("sex_cond"),
					"lic_conduc"=>$this->input->post("lic_conduc"),
					"comisar"=>$this->input->post("comisar"),
					"dep_com"=>$this->mantenimiento_transito->getdepartamento($this->input->post("dep_com")),
					"prov_com"=> $this->mantenimiento_transito->getprovincia($this->input->post("dep_com"), $this->input->post("prov_com")),
					"dist_com"=>$this->mantenimiento_transito->getdistrito($this->input->post("dist_com")),
					"ubigeo_com"=>$this->input->post("dist_com"),
					"num_pol"=>$this->input->post("num_pol"),
					"num_plac"=>$this->input->post("num_plac"),
					"nom_duepol"=>$this->input->post("nom_duepol"),
					"aseg"=>$this->input->post("aseg"),
					"otroaseg"=>$this->input->post("otroaseg"),
					"ano"=>(substr($this->input->post("ing_eess"), 6, 4)),
					"fichanum"=>$fichanum,
					"tpa_otro"=>$this->input->post("tpa_otro"),
					"evento"=> $evento
				);
				
				$actualizar = $this->mantenimiento_transito->modificarTransLesacctra($data, $id);

				if($actualizar)
				{
					$this->session->set_flashdata('exito', 'Informaci&oacute;n Actualizada con &eacute;xito.');
					redirect(site_url('modulotransito/listar_transito'), 301);
				}else{
					$this->session->set_flashdata('error', 'Se encontraron errores en la informaci&oacute;n registrada.');
				}
		}



		$modificar = $this->mantenimiento_transito->mostrarTransLesacctra($id);


	/*	echo '<pre>';
		var_dump($modificar);
		die; */

		// PRIMERA DIRESA
		// obtiene todos los datos del establecimientoooooo
		$estab = $this->mantenimiento_transito->mostrarEstablecimiento($modificar->cod_eess);

		//combo // obtiene todos los datos del  DIRESAaaaa
		$subreg = $this->mantenimiento_transito->buscarDiresas();

		// recorre y da formato para el comboooooo
		$diresa[''] = 'Seleccione ...';
		foreach ($subreg as $dato){
			$diresa[$dato->codigo] = $dato->nombre;
		}

		//combo Red
		$red = $this->mantenimiento_transito->buscarRedes($estab->subregion);
		$redes[''] = 'Seleccione ...';
		foreach ($red as $dato){
			$redes[$dato->codigo] = $dato->nombre;
		}

		//combo Microred
		$mred = $this->mantenimiento_transito->buscarMicroredes($estab->subregion,$estab->red);
		$microred[''] = 'Seleccione ...';
		foreach ($mred as $dato){
			$microred[$dato->codigo] = $dato->nombre;
		}

		//combo Establecimiento
		$est = $this->mantenimiento_transito->buscarEstablec($estab->subregion,$estab->red,$estab->microred);
		$establec[''] = 'Seleccione ...';
		foreach ($est as $dato){
			$establec[$dato->cod_est] = $dato->raz_soc;
		}


		// SEGUNDA DIRESA (referido origen)
		// obtiene todos los datos del establecimientoooooo
		$estabRef = array(); $redesRef = array(''=>'Seleccione ...'); $microredRef = array(); $establecRef = array();
		if ($modificar->referi != '' && $modificar->referi != 0) {
			$estabRef = $this->mantenimiento_transito->mostrarEstablecimiento($modificar->referi);

			//combo Red
			$redRef = $this->mantenimiento_transito->buscarRedes($estabRef->subregion);
			$redesRef[''] = 'Seleccione ...';
			foreach ($redRef as $dato){
				$redesRef[$dato->codigo] = $dato->nombre;
			}

			//combo Microred
			$mredRef = $this->mantenimiento_transito->buscarMicroredes($estabRef->subregion,$estabRef->red);
			$microredRef[''] = 'Seleccione ...';
			foreach ($mredRef as $dato){
				$microredRef[$dato->codigo] = $dato->nombre;
			}

			//combo Establecimiento
			$estRef = $this->mantenimiento_transito->buscarEstablec($estabRef->subregion,$estabRef->red,$estabRef->microred);
			$establecRef[''] = 'Seleccione ...';
			foreach ($estRef as $dato){
				$establecRef[$dato->cod_est] = $dato->raz_soc;
			}
		}

		// TERCERA DIRESA (referido destino)
		// obtiene todos los datos del establecimientoooooo
		$estabRefd = array(); $redesRefd = array(''=>'Seleccione ...'); $microredRefd = array(); $establecRefd = array();
		if ($modificar->refer!='' && $modificar->refer!=0) {
			$estabRefd = $this->mantenimiento_transito->mostrarEstablecimiento($modificar->refer);

			//combo Red
			$redRefd = $this->mantenimiento_transito->buscarRedes($estabRefd->subregion);
			$redesRefd[''] = 'Seleccione ...';
			foreach ($redRefd as $dato){
				$redesRefd[$dato->codigo] = $dato->nombre;
			}

			//combo Microred
			$mredRef = $this->mantenimiento_transito->buscarMicroredes($estabRefd->subregion,$estabRefd->red);
			$microredRefd[''] = 'Seleccione ...';
			foreach ($mredRef as $dato){
				$microredRefd[$dato->codigo] = $dato->nombre;
			}

			//combo Establecimiento
			$estRefd = $this->mantenimiento_transito->buscarEstablec($estabRefd->subregion,$estabRefd->red,$estabRefd->microred);
			$establecRefd[''] = 'Seleccione ...';
			foreach ($estRefd as $dato){
				$establecRefd[$dato->cod_est] = $dato->raz_soc;
			}
		}


		//combo Departamentos
		$depar = $this->mantenimiento_transito->buscarDepartamentos();

		$departamento[''] = 'Seleccione ...';
		foreach ($depar as $dato){
			$departamento[$dato->ubigeo] = $dato->nombre;
		}

		$provincia = array(''=>'Seleccione...');
		$distrito = array(''=>'Seleccione...');

		//combo Provincias
		$prov = $this->mantenimiento_transito->buscarProvincias(substr($modificar->ubigeo,0,2));

		//$provincia[''] = 'Seleccione ...';
		foreach ($prov as $dato){
			$provincia[$dato->ubigeo] = $dato->nombre;
		}

		//combo Distrito
		$dist = $this->mantenimiento_transito->buscarDistritos(substr($modificar->ubigeo,0,4));

		//$distrito[''] = 'Seleccione ...';
		foreach ($dist as $dato){
			$distrito[$dato->ubigeo] = $dato->nombre;
		}


		//combo Departamentos
		$depar = $this->mantenimiento_transito->buscarDepartamentos();

		$departamento_accidente[''] = 'Seleccione ...';
		foreach ($depar as $dato){
			$departamento_accidente[$dato->ubigeo] = $dato->nombre;
		}

		$provincia_accidente = array(''=>'Seleccione...');
		$distrito_accidente = array(''=>'Seleccione...');

		//combo Provincias
		$prov = $this->mantenimiento_transito->buscarProvincias(substr($modificar->ubigeo_ac,0,2));

		//$provincia[''] = 'Seleccione ...';
		foreach ($prov as $dato){
			$provincia_accidente[$dato->ubigeo] = $dato->nombre;
		}

		//combo Distrito
		$dist = $this->mantenimiento_transito->buscarDistritos(substr($modificar->ubigeo_ac,0,4));

		//$distrito[''] = 'Seleccione ...';
		foreach ($dist as $dato){
			$distrito_accidente[$dato->ubigeo] = $dato->nombre;
		}


		//combo Departamentos
		$depar = $this->mantenimiento_transito->buscarDepartamentos();

		$departamento_cond[''] = 'Seleccione...';
		foreach ($depar as $dato){
			$departamento_cond[$dato->ubigeo] = $dato->nombre;
		}

		$provincia_cond = array(''=>'Seleccione...');
		$distrito_cond = array(''=>'Seleccione...');

		//combo Provincias
		$prov = $this->mantenimiento_transito->buscarProvincias(substr($modificar->ubigeo_com,0,2));

		//$provincia[''] = 'Seleccione ...';
		foreach ($prov as $dato){
			$provincia_cond[$dato->ubigeo] = $dato->nombre;
		}

		//combo Distrito
		$dist = $this->mantenimiento_transito->buscarDistritos(substr($modificar->ubigeo_com,0,4));

		//$distrito[''] = 'Seleccione ...';
		foreach ($dist as $dato){
			$distrito_cond[$dato->ubigeo] = $dato->nombre;
		}

		// datos de los ciex validado en el caso de que no exista
		$dataDx1 = ($modificar->dx1!='') ? $this->autollenadoDiagno($modificar->dx1) : array();
		$dataDx2 = ($modificar->dx2!='') ? $this->autollenadoDiagno($modificar->dx2) : array();
		$dataDx3 = ($modificar->dx3!='') ? $this->autollenadoDiagno($modificar->dx3) : array();

		$this->layout->view('modificacion_transito', compact('modificar','estab','diresa','redes','microred','establec',
														'estabRef','redesRef','microredRef','establecRef', 'estabRefd','redesRefd','microredRefd','establecRefd',
														 'departamento','provincia','distrito','departamento_accidente','provincia_accidente',
														 'distrito_accidente','departamento_cond','provincia_cond','distrito_cond','dataDx1','dataDx2','dataDx3'));
	}


	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	public function ver_Ficha_Transito($id=null)
	{
		if(!$id)
		{
			show_404();
		}

		//codigo para restringir el acceso a la ficha
		$acceso = $this->login_model->loginAccesoFichas($this->session->userdata('usuario'), '9');
		if(count($acceso) != 0){
			$usuario = $this->session->userdata("usuario");
		}else{
			$this->session->set_flashdata('alerta', 'Alerta: No tiene acceso a la ficha epidemiol&oacute;gica elegida.');
			redirect(site_url("index/login"), 301);
		}

		// accion al hacer el post borrado




		$modificar = $this->mantenimiento_transito->mostrarTransLesacctra($id);

	/*	echo '<pre>';
		var_dump($modificar);
		die; */

		// PRIMERA DIRESA
		// obtiene todos los datos del establecimientoooooo
		$estab = $this->mantenimiento_transito->mostrarEstablecimiento($modificar->cod_eess);

		//combo // obtiene todos los datos del  DIRESAaaaa
		$subreg = $this->mantenimiento_transito->buscarDiresas();

		// recorre y da formato para el comboooooo
		$diresa[''] = 'Seleccione ...';
		foreach ($subreg as $dato){
			$diresa[$dato->codigo] = $dato->nombre;
		}

		//combo Red
		$red = $this->mantenimiento_transito->buscarRedes($estab->subregion);
		$redes[''] = 'Seleccione ...';
		foreach ($red as $dato){
			$redes[$dato->codigo] = $dato->nombre;
		}

		//combo Microred
		$mred = $this->mantenimiento_transito->buscarMicroredes($estab->subregion,$estab->red);
		$microred[''] = 'Seleccione ...';
		foreach ($mred as $dato){
			$microred[$dato->codigo] = $dato->nombre;
		}

		//combo Establecimiento
		$est = $this->mantenimiento_transito->buscarEstablec($estab->subregion,$estab->red,$estab->microred);
		$establec[''] = 'Seleccione ...';
		foreach ($est as $dato){
			$establec[$dato->cod_est] = $dato->raz_soc;
		}


		// SEGUNDA DIRESA (referido origen)
		// obtiene todos los datos del establecimientoooooo
		$estabRef = array(); $redesRef = array(''=>'Seleccione ...'); $microredRef = array(); $establecRef = array();
		if ($modificar->referi != '' && $modificar->referi != 0) {
			$estabRef = $this->mantenimiento_transito->mostrarEstablecimiento($modificar->referi);

			//combo Red
			$redRef = $this->mantenimiento_transito->buscarRedes($estabRef->subregion);
			$redesRef[''] = 'Seleccione ...';
			foreach ($redRef as $dato){
				$redesRef[$dato->codigo] = $dato->nombre;
			}

			//combo Microred
			$mredRef = $this->mantenimiento_transito->buscarMicroredes($estabRef->subregion,$estabRef->red);
			$microredRef[''] = 'Seleccione ...';
			foreach ($mredRef as $dato){
				$microredRef[$dato->codigo] = $dato->nombre;
			}

			//combo Establecimiento
			$estRef = $this->mantenimiento_transito->buscarEstablec($estabRef->subregion,$estabRef->red,$estabRef->microred);
			$establecRef[''] = 'Seleccione ...';
			foreach ($estRef as $dato){
				$establecRef[$dato->cod_est] = $dato->raz_soc;
			}
		}

		// TERCERA DIRESA (referido destino)
		// obtiene todos los datos del establecimientoooooo
		$estabRefd = array(); $redesRefd = array(''=>'Seleccione ...'); $microredRefd = array(); $establecRefd = array();
		if ($modificar->refer!='' && $modificar->refer!=0) {
			$estabRefd = $this->mantenimiento_transito->mostrarEstablecimiento($modificar->refer);

			//combo Red
			$redRefd = $this->mantenimiento_transito->buscarRedes($estabRefd->subregion);
			$redesRefd[''] = 'Seleccione ...';
			foreach ($redRefd as $dato){
				$redesRefd[$dato->codigo] = $dato->nombre;
			}

			//combo Microred
			$mredRef = $this->mantenimiento_transito->buscarMicroredes($estabRefd->subregion,$estabRefd->red);
			$microredRefd[''] = 'Seleccione ...';
			foreach ($mredRef as $dato){
				$microredRefd[$dato->codigo] = $dato->nombre;
			}

			//combo Establecimiento
			$estRefd = $this->mantenimiento_transito->buscarEstablec($estabRefd->subregion,$estabRefd->red,$estabRefd->microred);
			$establecRefd[''] = 'Seleccione ...';
			foreach ($estRefd as $dato){
				$establecRefd[$dato->cod_est] = $dato->raz_soc;
			}
		}


		//combo Departamentos
		$depar = $this->mantenimiento_transito->buscarDepartamentos();

		$departamento[''] = 'Seleccione ...';
		foreach ($depar as $dato){
			$departamento[$dato->ubigeo] = $dato->nombre;
		}

		$provincia = array(''=>'Seleccione...');
		$distrito = array(''=>'Seleccione...');

		//combo Provincias
		$prov = $this->mantenimiento_transito->buscarProvincias(substr($modificar->ubigeo,0,2));

		//$provincia[''] = 'Seleccione ...';
		foreach ($prov as $dato){
			$provincia[$dato->ubigeo] = $dato->nombre;
		}

		//combo Distrito
		$dist = $this->mantenimiento_transito->buscarDistritos(substr($modificar->ubigeo,0,4));

		//$distrito[''] = 'Seleccione ...';
		foreach ($dist as $dato){
			$distrito[$dato->ubigeo] = $dato->nombre;
		}


		//combo Departamentos
		$depar = $this->mantenimiento_transito->buscarDepartamentos();

		$departamento_accidente[''] = 'Seleccione ...';
		foreach ($depar as $dato){
			$departamento_accidente[$dato->ubigeo] = $dato->nombre;
		}

		$provincia_accidente = array(''=>'Seleccione...');
		$distrito_accidente = array(''=>'Seleccione...');

		//combo Provincias
		$prov = $this->mantenimiento_transito->buscarProvincias(substr($modificar->ubigeo_ac,0,2));

		//$provincia[''] = 'Seleccione ...';
		foreach ($prov as $dato){
			$provincia_accidente[$dato->ubigeo] = $dato->nombre;
		}

		//combo Distrito
		$dist = $this->mantenimiento_transito->buscarDistritos(substr($modificar->ubigeo_ac,0,4));

		//$distrito[''] = 'Seleccione ...';
		foreach ($dist as $dato){
			$distrito_accidente[$dato->ubigeo] = $dato->nombre;
		}


		//combo Departamentos
		$depar = $this->mantenimiento_transito->buscarDepartamentos();

		$departamento_cond[''] = 'Seleccione ...';
		foreach ($depar as $dato){
			$departamento_cond[$dato->ubigeo] = $dato->nombre;
		}

		$provincia_cond = array(''=>'Seleccione...');
		$distrito_aid = array(''=>'Seleccione...');

		//combo Provincias
		$prov = $this->mantenimiento_transito->buscarProvincias(substr($modificar->ubigeo_com,0,2));

		//$provincia[''] = 'Seleccione ...';
		foreach ($prov as $dato){
			$provincia_cond[$dato->ubigeo] = $dato->nombre;
		}

		//combo Distrito
		$dist = $this->mantenimiento_transito->buscarDistritos(substr($modificar->ubigeo_com,0,4));

		//$distrito[''] = 'Seleccione ...';
		foreach ($dist as $dato){
			$distrito_cond[$dato->ubigeo] = $dato->nombre;
		}

		// datos de los ciex validado en el caso de que no exista
		$dataDx1 = ($modificar->dx1!='') ? $this->autollenadoDiagno($modificar->dx1) : array();
		$dataDx2 = ($modificar->dx2!='') ? $this->autollenadoDiagno($modificar->dx2) : array();
		$dataDx3 = ($modificar->dx3!='') ? $this->autollenadoDiagno($modificar->dx3) : array();

		$this->layout->view('ver_ficha_transito', compact('modificar','estab','diresa','redes','microred','establec',
														'estabRef','redesRef','microredRef','establecRef', 'estabRefd','redesRefd','microredRefd','establecRefd',
														 'departamento','provincia','distrito','departamento_accidente','provincia_accidente',
														 'distrito_accidente','departamento_cond','provincia_cond','distrito_cond','dataDx1','dataDx2','dataDx3'));
	}


	//Llena el combo redes
	public function llenaRedes()
	{
		$filtro = $this->input->get('diresa');
		foreach ($this->mantenimiento_transito->buscarRedes($filtro) as $red) {
			$redes[$red->codigo] = $red->nombre;
		}
		echo json_encode($redes);
	}

    //Llena el combo microredes
	public function llenaMicroredes()
	{
		$filtro1 = $this->input->get('diresa');
		$filtro2 = $this->input->get('redes');

		foreach ($this->mantenimiento_transito->buscarMicroredes($filtro1, $filtro2) as $mred) {
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

		foreach ($this->mantenimiento_transito->buscarEstablec($filtro1, $filtro2, $filtro3) as $est) {
			$establec[$est->cod_est] = $est->raz_soc;
		}

		echo json_encode($establec);
	}

    //Llena el combo Provincias
	public function llenaProvincias()
	{
		$filtro = $this->input->get('departamento');
		foreach ($this->mantenimiento_transito->buscarProvincias($filtro) as $dato) {
			$prov[$dato->ubigeo] = $dato->nombre;
		}
		echo json_encode($prov);
	}

    //Llena el combo distrito
	public function llenaDistritos()
	{
		$filtro = $this->input->get('departamento');
		$filtro1 = $this->input->get('provincia');
		foreach ($this->mantenimiento_transito->buscarDistritos($filtro1) as $dato) {
			$dist[$dato->ubigeo] = $dato->nombre;
		}
		echo json_encode($dist);
	}

	//Verifica sessión iniciada
	function _sesionIniciada()
	{
		$usuario = $this->session->userdata('usuario');
		$sesionIniciada = $this->session->userdata('sesionIniciada');
		if( ! isset($sesionIniciada) || $sesionIniciada === FALSE || ! isset($usuario) || $usuario == '' )
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

	//Función para validar las fechas ingresadas
	function validar_fecha($str){
		$patron="/^(\d){2}\-(\d){2}\-(\d){4}$/i";
		if(!empty($str)){
			if (preg_match($patron,$str)){
				return TRUE;
			}else{
				$this->form_validation->set_message('validar_fecha',
				'dato en %s no v&aacute;lido');
				return FALSE;
			}
		}
	}


	// autocompletar
	function autollenadoDiagno($cie10=null)
	{
		if ($cie10!=null) {
			$where = " cie_10='$cie10'";
		} else {
			$termino = $_GET['term'];
			$where = " concat(cie_10,diagno) like '%$termino%' limit 10";
		}

		$causa =$this->db->query("SELECT cie_10, diagno, desc_cap, desc_gru, desc_cat FROM trans_ciex as c
		left join (SELECT cp.desc_cap as desc_cap, g.desc_gru as desc_gru, ca.cod_cat as cod_cat, ca.desc_cat as desc_cat FROM trans_categori as ca
		left join trans_grupo as g on(g.cod_gru=ca.cod_gru)
		left join trans_capitulo as cp on(cp.cod_cap=ca.cod_cap)) x on(c.cod_cat=x.cod_cat)
		where $where ");

		if ($cie10!=null) {
			return $causa->row();
		} else {
			foreach ($causa->result() as $ca) {
				$data[]=array('id'=>$ca->cie_10,'value'=>$ca->diagno,'capi'=>$ca->desc_cap,'grup'=>$ca->desc_gru,'cate'=>$ca->desc_cat,'label'=>$ca->cie_10.' - '.$ca->diagno);
			}
			echo json_encode($data);
		}

	}

	// Graficos Querys
	public function graficos()	{

			//codigo para restringir el acceso a la ficha
			$acceso = $this->login_model->loginAccesoFichas($this->session->userdata('usuario'), '9');
			if(count($acceso) != 0){
				$usuario = $this->session->userdata("usuario");
			}else{
				$this->session->set_flashdata('alerta', 'Alerta: No tiene acceso a la ficha epidemiol&oacute;gica elegida.');
				redirect(site_url("index/login"), 301);
			}

        if($this->input->post()){

        	//codigo pra auditoria
			$accion = 'generar grafico Transito';
			$this->login_model->auditoriaOperador($this->input->post("usuario"), $accion);

			$direPost = $this->input->post('cod_dir');
			$redPost = $this->input->post('redes_not');
			$mrPost = $this->input->post('microred_not');
			$estabPost = $this->input->post('cod_eess');
			$ano = $this->input->post('ano_exp');

			$qAno = ($ano == 't') ? "" : " and ano = '$ano'";

			if ($estabPost != '') {
				$where = " where cod_eess = '$estabPost' $qAno ";
			} else if ($estabPost == '' && $mrPost !='') {
				$where = " where cod_eess in(select cod_est FROM renace where subregion = '$direPost' and red = '$redPost' and microred = '$mrPost') $qAno ";
			} else if ($estabPost == '' && $mrPost =='' && $redPost !='') {
				$where = " where cod_eess in(select cod_est FROM renace where subregion = '$direPost' and red = '$redPost') $qAno ";
			} else if ($estabPost == '' && $mrPost =='' && $redPost =='' && $direPost !='') {
				$where = " where cod_dir = '$direPost' $qAno ";
			} else {
				$qAno = ($ano == 't') ? "" : " where ano = '$ano'";
				$where = " $qAno ";
			}

			$tipoRepo = $this->input->post('tipoRepo');
			$mesLabel = array(''=>'Sin Mes', '1'=>'Ene', '2'=>'Feb', '3'=>'Mar', '4'=>'Abr', '5'=>'May',
					'6'=>'Jun', '7'=>'Jul', '8'=>'Ago', '9'=>'Set', '10'=>'Oct', '11'=>'Nov', '12'=>'Dic');
			$grafico = '';

			if ($tipoRepo == 'xmeses') {
				$query = "select month(fec_accd) as mes, count(*) as casos from trans_lesacctra $where group by mes";
				$meses = ''; $nCasos = '';
				$data = $this->mantenimiento_transito->getData($query);
				foreach ($data as $val) {
					$meses .= "'" . $mesLabel[$val->mes] . "',";
					$nCasos .= $val->casos . ",";
				}
				//echo '<pre>';
				//var_dump($nCasos); die;

				$grafico = "chart: {
		            type: 'column'
		        },
		        title: {
		            text: 'Casos Atendidos por Meses'
		        },
		        subtitle: {
		            text: 'Fuente: Sistema Nacional de Vigilancia Epidemiol&oacute;gica en Salud Pública'
		        },
		        xAxis: {
		            categories: [$meses],
		            crosshair: true
		        },
		        yAxis: {
		            min: 0,
		            title: {
		                text: 'N° de Casos'
		            }
		        },
		        tooltip: {
		            headerFormat: '<span>{point.key}</span><table>',
		            pointFormat: '<tr><td>casos: </td>' +
		                '<td><b>{point.y:1f}</b></td></tr>',
		            footerFormat: '</table>',
		            shared: true,
		            useHTML: true
		        },
		        plotOptions: {
		            column: {
		                pointPadding: 0.2,
		                borderWidth: 0
		            }
		        },
		        series: [{
		            name: 'Meses',
		            data: [$nCasos]
		        }]";
			}

		}

		$this->layout->setLayout('template_transito');
        $this->layout->setTitle(":: ACCIDENTES DE TRANSITO ::");

		//combo DIRESA
		$diresa = $this->getDiresasPorNivel($this->input->post('diresa'));
		//combo Red
		$redes = $this->getRedesPorNivel($this->input->post('diresa'), $this->input->post('redes'));
		//combo Microred
		$microred = $this->getMicroRedesPorNivel($this->input->post('diresa'), $this->input->post('redes'), $this->input->post('microred'));
		//combo Establecimiento
		$establec = $this->getEstablecPorNivel($this->input->post('diresa'), $this->input->post('redes'), $this->input->post('microred'), $this->input->post('establec'));


		$result = $this->mantenimiento_transito->getAnio();
				//$anio['t'] = 'Todos';
				foreach ($result as $dato){
					$anio[$dato->anoexp] = $dato->anoexp;
				}

		$this->layout->view("graficos_transito",compact('grafico', 'diresa', 'redes', 'microred', 'establec', 'anio'));
	}


	// EXPORTAR A EXCEL
	public function exportar()
	{
		//codigo para restringir el acceso a la ficha
		$acceso = $this->login_model->loginAccesoFichas($this->session->userdata('usuario'), '9');
		if(count($acceso) != 0){
			$usuario = $this->session->userdata("usuario");
		}else{
			$this->session->set_flashdata('alerta', 'Alerta: No tiene acceso a la ficha epidemiol&oacute;gica elegida.');
			redirect(site_url("index/login"), 301);
		}

        if($this->input->post()){

			//codigo para auditoria
				$accion = 'exportar base Transito';
				$this->login_model->auditoriaOperador($this->input->post("usuario"), $accion);

        	// validamos tipo de base
        	if (($this->input->post('tipo_base')=='dbf') || ($this->input->post('tipo_base')=='')) {
        		$maximo = 0;
				$contador = 0;
				$puntero = 0;
				$limite = 0;
				$anio = $this->input->post('ano_exp');
				$ruta_db = "0";

				$diresa = $this->input->post('cod_dir');
				$red = $this->input->post('redes_not');
				$microred = $this->input->post('microred_not');
				$estab = $this->input->post('cod_eess');
				$ano = $this->input->post('ano_exp');

				$qAno = ($ano == 't') ? "" : " and ano = '$ano'";

				if ($estab != '') {
					$where = "where cod_eess = '$estab' $qAno";
				} else if ($estab == '' && $microred !='') {
					$where = "where cod_eess in(select cod_est FROM renace where subregion = '$diresa' and red = '$red' and microred = '$microred') $qAno";
				} else if ($estab == '' && $microred =='' && $red !='') {
					$where = "where cod_eess in(select cod_est FROM renace where subregion = '$diresa' and red = '$red') $qAno";
				} else if ($estab == '' && $microred =='' && $red =='' && $diresa !='') {
					$where = "where cod_dir = '$diresa' $qAno";
				} else {
					$qAno = ($ano == 't') ? "" : " where ano = '$ano'";
					$where = "$qAno";
				}

	            $this->session->set_userdata('where', $where);

				redirect('modulotransito/exportarDbf'.'/'.$maximo.'/'.$contador.'/'.$puntero.'/'.$limite.'/'.$anio.'/'.$ruta_db,301);
        	} else {
				$diresa = $this->input->post('cod_dir');
				$red = $this->input->post('redes_not');
				$microred = $this->input->post('microred_not');
				$estab = $this->input->post('cod_eess');
				$ano = $this->input->post('ano_exp');

				$qAno = ($ano == 't') ? "" : " and ano = '$ano'";

				$encabezados = 'fuen_finc, hce, hch, ref_es, referi, ap_nm1, ap_nm2, nom_les, concat("\'",cod_dir) as cod_dir, d.nombre as diresa, concat("\'",red) as red, concat("\'",microred) as microred, concat("\'",cod_eess) as cod_eess, eess, IF (dni = "", "", concat("\'",dni)) as dni, edad, tipo_edad, sexo, depar, prov, dis, concat("\'",ubigeo) as ubigeo, direccion, ing_eess, hora, dx1, c1.diagno as diagno1, dx2, c2.diagno as diagno2, dx3, c3.diagno as diagno3, fech_egre, cond_egr, refer, rehab, fec_accd, hor_accid, lug_accid, depar_acc, prov_acc, dist_acc, concat("\'",ubigeo_ac) as ubigeo_ac, via_accd, tp_accd, veh_moto, ub_les, trasl_les, tp_moto, tp_condi, nom_condc1, ape_condc, nom_condc2, ed_cond, sex_cond, lic_conduc, comisar, dep_com, prov_com, dist_com, concat("\'",ubigeo_com) as ubigeo_com, num_pol, num_plac, nom_duepol, aseg, otroaseg, ano, concat("\'",fichanum) as fichanum, tpa_otro, evento';
				$join = ' left join diresas as d on(l.cod_dir=d.codigo)
						left join trans_ciex as c1 on (l.dx1=c1.cie_10)
						left join trans_ciex as c2 on (l.dx2=c2.cie_10)
						left join trans_ciex as c3 on (l.dx3=c3.cie_10)';

				if ($estab != '') {
					$query = "select $encabezados from trans_lesacctra as l $join where cod_eess = '$estab' $qAno order by ano desc";
				} else if ($estab == '' && $microred !='') {
					$query = "select $encabezados from trans_lesacctra as l $join where cod_eess in(select cod_est FROM renace where subregion = '$diresa' and red = '$red' and microred = '$microred') $qAno order by ano desc";
				} else if ($estab == '' && $microred =='' && $red !='') {
					$query = "select $encabezados from trans_lesacctra as l $join where cod_eess in(select cod_est FROM renace where subregion = '$diresa' and red = '$red') $qAno order by ano desc";
				} else if ($estab == '' && $microred =='' && $red =='' && $diresa !='') {
					$query = "select $encabezados from trans_lesacctra as l $join where cod_dir = '$diresa' $qAno order by ano desc";
				} else {
					$qAno = ($ano == 't') ? "" : " where ano = '$ano'";
					$query = "select $encabezados from trans_lesacctra as l $join $qAno order by ano desc";
				}
				// echo $query; die;
				$data = $this->mantenimiento_transito->getDataExportar($query);

				$this->load->library('export');
				$this->export->to_excel($data, 'lesacctra');

				exit();
			}
		}

		$this->layout->setLayout('template_transito');
        $this->layout->setTitle(":: ACCIDENTES DE TRANSITO ::");

		//combo DIRESA
		$diresa = $this->getDiresasPorNivel($this->input->post('diresa'));
		//combo Red
		$redes = $this->getRedesPorNivel($this->input->post('diresa'), $this->input->post('redes'));
		//combo Microred
		$microred = $this->getMicroRedesPorNivel($this->input->post('diresa'), $this->input->post('redes'), $this->input->post('microred'));
		//combo Establecimiento
		$establec = $this->getEstablecPorNivel($this->input->post('diresa'), $this->input->post('redes'), $this->input->post('microred'), $this->input->post('establec'));



		$result = $this->mantenimiento_transito->getAnio();
				//$anio['t'] = 'Todos';
				foreach ($result as $dato){
					$anio[$dato->anoexp] = $dato->anoexp;
				}

		$this->layout->view("exportar_transito",compact('diresa','redes','microred','establec','anio'));
	}


	// exportar a dbf
	public function exportarDbf($maximo, $contador, $puntero, $limite, $anio, $ruta_db)
	{
		$where = $this->session->userdata('where');
		$numRows = $this->mantenimiento_transito->getCantidad($where);

		if($ruta_db <> '0'){
			$ruta_db = str_replace("L", "/", $ruta_db);
		}else{
			$ruta_db = "";
		}

		if($maximo == 0){
			if($numRows->cantidad == 0){
				redirect(site_url('modulotransito/exportar'), 301);
			}

			$maximo = $numRows->cantidad;
			$limite = ceil($maximo / 10);
			$usuario = $this->session->userdata('usuario');
			$NombreArchivo = $usuario.date("dmYHis").".dbf";

			$ruta_dbO = getcwd()."/basefuente/lesacctra.dbf";

			$ruta_db = getcwd().'/uploads/'.$NombreArchivo;

			copy ($ruta_dbO,$ruta_db) or die("no se pudo generar el molde");

			// Abrir el archivo dbase
			$dbh = dbase_open($ruta_db, 2) or die("¡Error! No se pudo abrir el archivo de base de datos dbase ".$ruta_db);

			$row = $this->mantenimiento_transito->getDataDbf($where,$puntero,$limite);
			foreach($row as $data)
			{
				dbase_add_record($dbh,array($data->fuen_finc, $data->hce, $data->hch, $data->ref_es, $data->referi, $data->ap_nm1, $data->ap_nm2, $data->nom_les, $data->cod_dir, $data->diresa, $data->red, $data->microred, $data->cod_eess, $data->eess, $data->dni, $data->edad, $data->tipo_edad, $data->sexo, $data->depar, $data->prov, $data->dis, $data->ubigeo, $data->tipo_loc, $data->direccion, $data->ing_eess, $data->hora, $data->dx1, $data->dx2, $data->dx3, $data->fech_egre, $data->cond_egr, $data->refer, $data->rehab, $data->fec_accd, $data->hor_accid, $data->lug_accid, $data->tipo_loc1, $data->depar_acc, $data->prov_acc, $data->dist_acc, $data->ubigeo_ac, $data->via_accd, $data->tp_accd, $data->movil, $data->nomovil, $data->veh_moto, $data->veh_nomoto, $data->peaton, $data->ub_les, $data->trasl_les, $data->tp_moto, $data->tp_nomoto, $data->tp_condi, $data->nom_condc1, $data->ape_condc, $data->nom_condc2, $data->ed_cond, $data->sex_cond, $data->lic_conduc, $data->comisar, $data->dep_com, $data->prov_com, $data->dist_com, $data->ubigeo_com, $data->alcoh, $data->num_pol, $data->num_plac, $data->nom_duepol, $data->aseg, $data->otroaseg, $data->ano, $data->estado, $data->fichanum, $data->tpa_otro, $data->evento));

				$contador = $contador + 1;
			}
			dbase_close($dbh);

			$puntero = $puntero + $limite;

			$ruta_db = str_replace("\\", "L", $ruta_db);
			$ruta_db = str_replace("/", "L", $ruta_db);

			redirect("modulotransito/exportarDbf"."/".$maximo."/".$contador."/".$puntero."/".$limite."/".$anio."/".$ruta_db,301);
		} else {
			// Abrir el archivo dbase
			$dbh = dbase_open($ruta_db, 2) or die("¡Error! No se pudo abrir el archivo de base de datos dbase ".$ruta_db);

			$row = $this->mantenimiento_transito->getDataDbf($where,$puntero,$limite);
			foreach($row as $data)
			{
				dbase_add_record($dbh,array($data->fuen_finc, $data->hce, $data->hch, $data->ref_es, $data->referi, $data->ap_nm1, $data->ap_nm2, $data->nom_les, $data->cod_dir, $data->diresa, $data->red, $data->microred, $data->cod_eess, $data->eess, $data->dni, $data->edad, $data->tipo_edad, $data->sexo, $data->depar, $data->prov, $data->dis, $data->ubigeo, $data->tipo_loc, $data->direccion, $data->ing_eess, $data->hora, $data->dx1, $data->dx2, $data->dx3, $data->fech_egre, $data->cond_egr, $data->refer, $data->rehab, $data->fec_accd, $data->hor_accid, $data->lug_accid, $data->tipo_loc1, $data->depar_acc, $data->prov_acc, $data->dist_acc, $data->ubigeo_ac, $data->via_accd, $data->tp_accd, $data->movil, $data->nomovil, $data->veh_moto, $data->veh_nomoto, $data->peaton, $data->ub_les, $data->trasl_les, $data->tp_moto, $data->tp_nomoto, $data->tp_condi, $data->nom_condc1, $data->ape_condc, $data->nom_condc2, $data->ed_cond, $data->sex_cond, $data->lic_conduc, $data->comisar, $data->dep_com, $data->prov_com, $data->dist_com, $data->ubigeo_com, $data->alcoh, $data->num_pol, $data->num_plac, $data->nom_duepol, $data->aseg, $data->otroaseg, $data->ano, $data->estado, $data->fichanum, $data->tpa_otro, $data->evento));

				$contador = $contador + 1;
			}
			dbase_close($dbh);

			if($puntero >= $maximo){
				$filename = $ruta_db;

				if (file_exists($filename)) {
					header('Content-Description: File Transfer');
					header('Content-Type: application/octet-stream');

					header('Content-Disposition: attachment; filename=lesacctra.dbf');

					header('Content-Transfer-Encoding: binary');
					header('Expires: 0');
					header('Cache-Control: must-revalidate');
					header('Pragma: public');
					header('Content-Length: ' . filesize($filename));
					ob_clean();
					flush();
					readfile($filename);
				}else{
					echo "el fichero no se creo";
				}

				unlink($filename);

				redirect('modulotransito/exportar', refresh);
			}else{
				$puntero = $puntero + $limite;

				$ruta_db = str_replace("\\", "L", $ruta_db);
				$ruta_db = str_replace("/", "L", $ruta_db);

				redirect("modulotransito/exportarDbf"."/".$maximo."/".$contador."/".$puntero."/".$limite."/".$anio."/".$ruta_db,301);
			}
		}

	}

	public function controlnotificacion_transito()
	{
		$casos = $this->mantenimiento_transito->getAccidentesNivelMeses();

		$direPost = $this->session->userdata('diresa');
		$redPost = $this->session->userdata('red');
		$mrPost = $this->session->userdata('microred');
		$estabPost = $this->session->userdata('establecimiento');

		if ($estabPost != '') {
			$nivel = "Establecimiento";
		} else if ($estabPost == '' && $mrPost !='') {
			$nivel = "Establecimientos";
		} else if ($estabPost == '' && $mrPost =='' && $redPost !='') {
			$nivel = "Microredes";
		} else if ($estabPost == '' && $mrPost =='' && $redPost =='' && $direPost !='') {
			$nivel = "Redes";
		} else {
			$nivel = "Diresas";
		}
		//combo DIRESA
		$diresa = $this->getDiresasPorNivel($this->input->post('diresa'));
		//combo Red
		$redes = $this->getRedesPorNivel($this->input->post('diresa'), $this->input->post('redes'));
		//combo Microred
		$microred = $this->getMicroRedesPorNivel($this->input->post('diresa'), $this->input->post('redes'), $this->input->post('microred'));
		//combo Establecimiento
		$establec = $this->getEstablecPorNivel($this->input->post('diresa'), $this->input->post('redes'), $this->input->post('microred'), $this->input->post('establec'));


		$this->layout->view("controlnotificacion_transito",compact('nivel', 'casos', 'diresa', 'redes', 'microred', 'establec'));

			//codigo para restringir el acceso a la ficha
			$acceso = $this->login_model->loginAccesoFichas($this->session->userdata('usuario'), '9');
			if(count($acceso) != 0){
				$usuario = $this->session->userdata("usuario");
			}else{
				$this->session->set_flashdata('alerta', 'Alerta: No tiene acceso a la ficha epidemiol&oacute;gica elegida.');
				redirect(site_url("index/login"), 301);
			}
	}

	public function casosAjax()
	{
		$casos = $this->mantenimiento_transito->getAccidentesNivelMeses();

		$direPost = $this->input->post('diresa');
		$redPost = $this->input->post('red');
		$mrPost = $this->input->post('mred');
		$estabPost = $this->input->post('eess');
		$anio = $this->input->post('anio');

		if ($estabPost != '') {
			$nivel = "Establecimiento";
		} else if ($estabPost == '' && $mrPost !='') {
			$nivel = "Establecimientos";
		} else if ($estabPost == '' && $mrPost =='' && $redPost !='') {
			$nivel = "Microredes";
		} else if ($estabPost == '' && $mrPost =='' && $redPost =='' && $direPost !='') {
			$nivel = "Redes";
		} else {
			$nivel = "Diresas";
		}

		echo '<table class="table  table-bordered table-condensed table-hover">
        	<tr>
        		<th style="text-align: center;">Nro</th>
                <th>'.$nivel.'</th>
                <th>ene</th>
                <th>feb</th>
                <th>mar</th>
                <th>abr</th>
                <th>may</th>
				<th>jun</th>
				<th>jul</th>
				<th>ago</th>
				<th>set</th>
				<th>oct</th>
				<th>nov</th>
				<th>dic</th>
            </tr>';
		if($casos->num_rows()>0){
			$nro = 1;
					$etiqueta= "class='bg-danger'";
					foreach ($casos->result_array() as $caso) {
						echo '<tr>
								<td style="text-align: center;">'.$nro++.'</td>
								<td>'.$caso[$nivel].'</td>
								<td '.($caso['ene']<1 ? $etiqueta:"").'>'.$caso['ene'].'</td>
								<td '.($caso['feb']<1 ? $etiqueta:"").'>'.$caso['feb'].'</td>
								<td '.($caso['mar']<1 ? $etiqueta:"").'>'.$caso['mar'].'</td>
								<td '.($caso['abr']<1 ? $etiqueta:"").'>'.$caso['abr'].'</td>
								<td '.($caso['may']<1 ? $etiqueta:"").'>'.$caso['may'].'</td>
								<td '.($caso['jun']<1 ? $etiqueta:"").'>'.$caso['jun'].'</td>
								<td '.($caso['jul']<1 ? $etiqueta:"").'>'.$caso['jul'].'</td>
								<td '.($caso['ago']<1 ? $etiqueta:"").'>'.$caso['ago'].'</td>
								<td '.($caso['sep']<1 ? $etiqueta:"").'>'.$caso['sep'].'</td>
								<td '.($caso['oct']<1 ? $etiqueta:"").'>'.$caso['oct'].'</td>
								<td '.($caso['nov']<1 ? $etiqueta:"").'>'.$caso['nov'].'</td>
								<td '.($caso['dic']<1 ? $etiqueta:"").'>'.$caso['dic'].'</td>
							</tr>';
					}
		}else{
			echo '<tr>
						<td colspan="13">No se encontraron resultados</td>
					</tr>';
		}
		echo '</table>';

	}

	public function getDiresasPorNivel($postDiresa='')
	{
		if($this->session->userdata('diresa') == ''){
			$subreg = $this->mantenimiento_transito->buscarDiresas();

			$diresa[''] = 'Seleccione ...';
			foreach ($subreg as $dato){
				$diresa[$dato->codigo] = $dato->nombre;
			}
		}else{
			if($postDiresa == ''){
				$subreg = $this->mantenimiento_transito->mostrarDiresa($this->session->userdata('diresa'));
				foreach ($subreg as $dato){
					$diresa[$dato->codigo] = $dato->nombre;
				}
			}else{
				$subreg = $this->mantenimiento_transito->mostrarDiresa($postDiresa);
				foreach ($subreg as $dato){
					$diresa[$dato->codigo] = $dato->nombre;
				}
			}
		}
		return $diresa;
	}

	public function getRedesPorNivel($postDiresa='', $postRed='')
	{
		if($this->session->userdata('red') != ''){
			$red = $this->mantenimiento_transito->mostrarRed($this->session->userdata('diresa'),$this->session->userdata('red'));
			foreach ($red as $dato){
				$redes[$dato->codigo] = $dato->nombre;
			}
		}else{
			if($postRed == ''){
				$red = $this->mantenimiento_transito->buscarRedes($this->session->userdata('diresa'));
				$redes[''] = 'Seleccione ...';
				foreach ($red as $dato){
					$redes[$dato->codigo] = $dato->nombre;
				}
			}else{
				$red = $this->mantenimiento_transito->buscarRedes($postDiresa);
				$redes[''] = 'Seleccione ...';
				foreach ($red as $dato){
					$redes[$dato->codigo] = $dato->nombre;
				}
			}
		}
		return $redes;
	}

	public function getMicroRedesPorNivel($postDiresa='', $postRed='', $postMicroRed='')
	{
		if($this->session->userdata('microred') != ''){
			$mred = $this->mantenimiento_transito->mostrarMicrored($this->session->userdata('diresa'), $this->session->userdata('red'), $this->session->userdata('microred'));
			foreach ($mred as $dato){
				$microred[$dato->codigo] = $dato->nombre;
			}
		}else{
			if($postMicroRed == ''){
				$mred = $this->mantenimiento_transito->buscarMicroredes($this->session->userdata('diresa'), $this->session->userdata('red'));
				$microred[''] = 'Seleccione ...';
				foreach ($mred as $dato){
					$microred[$dato->codigo] = $dato->nombre;
				}
			}else{
				$mred = $this->mantenimiento_transito->buscarMicroredes($postDiresa, $postRed);
				$microred[''] = 'Seleccione ...';
				foreach ($mred as $dato){
					$microred[$dato->codigo] = $dato->nombre;
				}
			}
		}
		return $microred;
	}

	public function getEstablecPorNivel($postDiresa='', $postRed='', $postMicroRed='', $postEstablec='')
	{
		if($this->session->userdata('establecimiento') != ''){
			$est = $this->mantenimiento_transito->mostrarEstablecimiento($this->session->userdata('establecimiento'));
				$establec[$est->cod_est] = $est->raz_soc;
		}
		else{
			if($postEstablec == ''){
				$est = $this->mantenimiento_transito->buscarEstablec($this->session->userdata('diresa'),$this->session->userdata('red'),$this->session->userdata('microred'));
				$establec[''] = 'Seleccione ...';
				foreach ($est as $dato){
					$establec[$dato->cod_est] = $dato->raz_soc;
				}
			}else{
				$est = $this->mantenimiento_transito->buscarEstablec($postDiresa, $postRed, $postMicroRed);
				$establec[''] = 'Seleccione ...';
				foreach ($est as $dato){
					$establec[$dato->cod_est] = $dato->raz_soc;
				}
			}
		}
		return $establec;
	}
	
	public function principal_transito()
    {
        $this->layout->setLayout('template_transito');
        $this->layout->setTitle(":: ACCIDENTES DE TRANSITO ::");

		$estado = $this->login_model->estado();

		if($estado->estado == '0'){
			redirect(site_url('index/mantenimiento'), 301);
		}

		$caducidad = $this->session->userdata('caduca');

		$faltan = $this->login_model->daysDifference($caducidad, date('Y-m-d'));

		if($this->session->userdata('codigo') == '1234567')
		{
			redirect('index/cambioClave', 301);
		}

		if(!empty($this->session_id)){
            $session_id = $this->session_id;
			$nivel_id = $this->session->userdata('nivel');

			if($faltan <= 30){
			    $termina = 'Atenci&oacute;n: Faltan '.$faltan.' d&iacute;as para que su usuario caduque, USTED DEBE CAMBIAR SU CONTRASE&Ntilde;A. Proceda por favor.';
			}else{
				$termina = null;
			}

			if($faltan <= 0){
				$data = array("usuario" => $this->session->userdata("usuario"), "estado" => "2");

				$this->login_model->baja($data);

	            redirect(site_url("index/login"), 301);
			}

			$acceso = $this->login_model->loginAccesoFichas($this->session->userdata('usuario'), '9');
			if(count($acceso) != 0){
				$this->layout->view('principal_transito', compact("session_id", "nivel_id", "termina"));
			}else{
				$this->session->set_flashdata('error', 'Alerta: No tiene acceso a la ficha epidemiol&oacute;gica elegida.');
				redirect(site_url("index/principal"), 301);
			}
			//$this->layout->view('principal', compact("session_id", "nivel_id", "termina"));
        }else{
            redirect(site_url("index/login"), 301);
        }
    }

    function vercierreaplica()
    {
    	$anio = $_GET['anio'];
        $apli = $_GET['apli'];
        $veranio = $this->db->query("SELECT * FROM cierreapli where aplicativo='$apli' and anio='$anio'");
        $data ['estado'] = $veranio->row()->estado;
        echo json_encode($data);
	}



}
