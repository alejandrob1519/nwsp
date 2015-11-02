<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pnt extends CI_Controller {
    
    private $session_id;

	public function __construct()
    {
        parent::__construct();
        $this->layout->setLayout('template7');
        $this->layout->setTitle(":: NotiWeb :: Vigilancia Epidemiol&oacute;gica");
        $this->session_id = $this->session->userdata('usuario');
		date_default_timezone_set('America/Lima');
	}

    public function _example_output1($output = null)
    {
		$this->layout->view('listadoNotificacion.php',$output);
    }

	public function index()
    {
		$this->_example_output1((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
	}
	
	public function listadoNotificacion()
	{
		if($this->session->userdata('nivel') != 5 or $this->session->userdata('institucion') != 'A'){
			$this->session->set_flashdata('error', 'Su nivel de usuario no le permite realizar este proceso');
			redirect(site_url("index/principal"), 301);
		}
		
		$anio = array();
		
		for($i=date("Y")-1;$i<=date("Y");$i++)
		{
			$anio[$i] = $i;
		}

		$semanas = array();
		
		for($i=1;$i<=53;$i++)
		{
			$semanas[$i] = $i;
		}

		$usuario = $this->session->userdata('usuario');
		$carpeta = getcwd()."/uploads/".$usuario."/";
		
		if(!file_exists($carpeta))
		{
			mkdir(getcwd()."/uploads/".$usuario, 0777);
		}
		
		$subr = $this->frontend_model->mostrarDiresa($this->session->userdata('diresa'));
			
		$subregion = array();
			
		foreach($subr as $dato)
		{
			$subregion[$dato->codigo] = $dato->nombre;
		}
			
		$rd = $this->frontend_model->buscarRedes($this->session->userdata('diresa'));
			
		$red = array();
			
		foreach($rd as $dato)
		{
			$red[$dato->codigo] = $dato->nombre;
		}

		$mrd = $this->frontend_model->buscaMicroredes($this->session->userdata('diresa'));
		
		$microred = array();
			
		foreach($mrd as $dato)
		{
			$microred[$dato->codigo] = $dato->nombre;
		}
		
		$crud = new grocery_CRUD();
		
		$crud->set_table('telematica');
		$crud->columns('ano', 'semana', 'diresa', 'red', 'microred', 'establecimiento', 'archivo', 'usuario', 'fecha', 'enviado');
		$crud->fields('ano', 'semana', 'diresa', 'red', 'microred', 'establecimiento', 'archivo');
		$crud->display_as('ano','A&ntilde;o');
		$crud->display_as('enviado','Estado');
		$crud->field_type('ano','dropdown',$anio);         
		$crud->field_type('semana','dropdown',$semanas);         
		$crud->field_type('diresa','dropdown',$subregion);         
		$crud->field_type('red','dropdown',$red);         
		//$crud->field_type('microred','dropdown',$microred);  
		
		$crud->field_type('enviado','dropdown',array('1' => 'Notificado', '2' => 'Pendiente'));         
		//$crud->where(array('ano'=>date('Y')));
		$crud->where(array('diresa' => $this->session->userdata('diresa')));
		$crud->order_by('ano', 'DESC');
		$crud->set_subject('Notificaci&oacute;n');
		$crud->set_field_upload('archivo','uploads/'.$usuario);

		$crud->unset_add();
		$crud->unset_read();
		//$crud->unset_delete();
		$crud->unset_edit();
		$crud->unset_export();
		
		$crud->callback_after_insert(array($this,'log_usuario_after_insert'));
		
		///////////////////////////////////////////////////////////////////////////////
		$crud->add_action_peru('A&ntilde;adir Notificaci&oacute;n', '', 'pntRegistro','add-icon');
		///////////////////////////////////////////////////////////////////////////////
		//$crud->add_action('A&ntilde;adir informaci&oacute;n', base_url().'public/images/telematica.gif', 'pnt/adicionar','');
		$crud->add_action('Efectuar notificaci&oacute;n', base_url().'public/images/contact.png', 'pnt/envio','');

		$output = $crud->render();

		$this->_example_output1($output);
	}

	//Sube el archivo al servidor 
	function do_upload()
	{
		ini_set('upload_max_filesize', '5M');
		ini_set('post_max_size', '5M');
		ini_set('memory_limit', '512M');
		
		$key = "";
		$caracteres = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$length = 5;
		$max = strlen($caracteres) - 1;
		for ($i=0;$i<$length;$i++) {
			$key .= substr($caracteres, rand(0, $max), 1);
		}
		
		$usuario = $this->session->userdata('usuario');
		$codigo = strrev($key);
		
		$nombre = $codigo.$usuario.$this->session->userdata('diresa').$this->session->userdata('red').
		$this->session->userdata('microred').$this->session->userdata('establecimiento').date("dmY");

		$config['upload_path'] = getcwd().'/uploads/'.$usuario."/";
		$config['file_name'] = $nombre;
		$config['allowed_types'] = 'zip';
		$config['max_size'] = "50000";
		$config['max_width'] = "2000";
		$config['max_height'] = "2000";
		
		echo $this->load->library('upload', $config);
	
		if (!$this->upload->do_upload())
		{
			$this->session->set_flashdata('error', $this->upload->display_errors());
			redirect(site_url('pnt/listadoNotificacion'));
		}else{
			$data = array(
			'ano' => $this->input->post('anio'),
			'semana' => $this->input->post('semana'),
			'diresa' => $this->input->post('diresa'),
			'red'=> $this->input->post('redes'),
			'microred' => $this->input->post('microred'),
			'establecimiento' => $this->input->post('establec'),
			'archivo' => $nombre.".zip",
			'usuario' => $this->session->userdata('usuario'),
			'fecha' => date('Y-m-d'),
			'enviado' => '2'
			);

			$guardar = $this->frontend_model->insertarTelematica($data);
			
			if($guardar){
				$this->mantenimiento_model->auditoriaOperador($this->session->userdata('usuario'), 'Notificacion telematica');
			}

			$this->session->set_flashdata('exito', 'Informaci&oacute;n registrada con &eacute;xito.');
			redirect(site_url('pnt/listadoNotificacion'));
		}
	}	
	
	//Para colocar un nuevo archivo para la notificación telemática
	public function pntRegistro()
	{

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

		$usuario = $this->session->userdata('usuario');
		$carpeta = getcwd()."/uploads/".$usuario."/";
		
		if(!file_exists($carpeta))
		{
			mkdir(getcwd()."/uploads/".$usuario, 0777);
		}
		
		$this->layout->view('pntRegistro', compact('diresa', 'redes', 'microred', 'establec'));		
	}
	
	//Para el reemplazo de lo notificado
	public function envio($id=null)
	{
		if(!$id)
		{
			show_404();
		}
		
		if($this->input->post())
		{
			if($this->input->post('aceptar')){
				if($this->session->userdata('nivel') >= 5){
					// Buscando archivo para descomprimir
					
					$notificar = $this->frontend_model->Notificar($id);
					
					//Eliminando la información anterior
					$this->frontend_model->notificacionTelematica($notificar, $carpeta, $id);
				}else{
					$this->session->set_flashdata('error', 'Su nivel no le permite realizar este proceso');
					redirect(site_url("index/principal"), 301);
				}
				
				$id = $this->input->post('id');
				redirect(site_url('pnt/Notificar/'.$id), 301);
			}
		}
		$this->layout->view('envio', compact('id'));		
	}
	
	//Para la adición de registros notificados
	public function adicionar($id=null)
	{
		if(!$id)
		{
			show_404();
		}
		
		if($this->input->post())
		{
			if($this->input->post('aceptar')){
				$id = $this->input->post('id');
				redirect(site_url('pnt/Notificar/'.$id), 301);
			}
		}
		$this->layout->view('adicionar', compact('id'));		
	}
	
	//Proceso de notificación
	public function Notificar($id=null)
	{
		if(!$id)
		{
			show_404();
		}
		
		// Buscando archivo para descomprimir
		
		$notificar = $this->frontend_model->Notificar($id);
		
		if(sizeof($notificar)==0)
		{
			show_404();
		}
		if($notificar->enviado == '1')
		{
			$this->session->set_flashdata('info', 'Cuidado: Este registro ya ha sido notificado.');
            redirect(site_url("pnt/listadoNotificacion"), 301);
		}else{
			// Descomprime el archivo ZIP
			$usuario = $this->session->userdata('usuario');
			$carpeta = getcwd()."/uploads/".$usuario."/";
			$fname = $notificar->archivo;
			$archivoZip = $carpeta.$fname;
			
			chmod($carpeta, 0777);
			
			$parametro = array('id' => '');
			
			$this->load->library('pclzip', $parametro);

			$archivo = new PclZip($archivoZip);
			
			if ($archivo->extract(
				PCLZIP_OPT_PATH, $carpeta)) {
			}else{
				die("Error : ".$archivo->errorInfo(true));
			}
			
			ini_set('memory_limit', '512M');
			set_time_limit(180);
			
			//Proceso de notificación telemática
			if($this->session->userdata('nivel') >= 5){
				//Anexando la nueva información según la existencia de los archivos correspondientes
				$noti = $carpeta."NOTI_SP.TXT";
				$eda = $carpeta."eda_sp.txt";
				$ira = $carpeta."ira_sp.txt";
				$febriles = $carpeta."feb_sp.txt";
				
				if(file_exists($noti)){
					$lineas = file($noti);
					
					foreach($lineas as $linea_num => $linea)
					{
						$datos = explode(",",str_replace('"','',$linea));

						$this->db->query("INSERT INTO individual (registroId, ano, semana, diagnostic, tipo_dx, subregion,
						ubigeo, localcod, localidad, apepat, apemat, nombres, edad, tipo_edad, sexo, protegido, fecha_ini,
						fecha_def, fecha_not, fecha_inv, sub_reg_nt, red, microred, e_salud, semana_not, an_notific,
						fecha_ing, ficha_inv, tipo_noti, clave, importado, migrado, verifica, dni, muestra,	hc, fecha_hos,
						estado, tip_zona, cod_pais, tipo_id, direccion, etniaproc, etnias, procede, otroproc, usuario) 
						VALUES ('','".trim($datos[0])."','".trim($datos[1])."','".trim($datos[2])."','".trim($datos[3]).
						"','".trim($datos[4])."','".trim($datos[5])."','".trim($datos[6])."','".trim($datos[7]).
						"','".utf8_encode(trim($datos[8]))."','".utf8_encode(trim($datos[9])).
						"','".utf8_encode(trim($datos[10]))."','".trim($datos[11]).
						"','".trim($datos[12])."','".trim($datos[13])."','".trim($datos[14])."','".trim($datos[15]).
						"','".trim($datos[16])."','".trim($datos[17])."','".trim($datos[18])."','".trim($datos[19]).
						"','".trim($datos[20])."','".trim($datos[21])."','".trim($datos[22])."','".trim($datos[23]).
						"','".trim($datos[24])."','".trim($datos[25])."','".trim($datos[26])."','".trim($datos[27]).
						"','".trim($datos[28])."','".trim($datos[29])."','".trim($datos[30])."','".trim($datos[31]).
						"','".trim($datos[32])."','".trim($datos[33])."','".trim($datos[34])."','".trim($datos[35]).
						"','".trim($datos[36])."','".trim($datos[37])."','".trim($datos[38])."','".trim($datos[39]).
						"','".utf8_encode(trim($datos[40]))."','".trim($datos[41])."','".trim($datos[42]).
						"','".trim($datos[43])."','".trim($datos[44])."','".$this->session->userdata('usuario')."')");
					}
				}

				if(file_exists($eda)){
					$lineas = file($eda);
					
					foreach($lineas as $linea_num => $linea)
					{
						$datos = explode(",",str_replace('"','',$linea));

						$this->db->query("INSERT INTO edas (registroId, ano, semana, sub_reg_nt, red, microred, e_salud, 
						ubigeo, daa_c1, daa_c1_4, daa_c5, daa_d1, daa_d1_4, daa_d5, daa_h1, daa_h1_4, daa_h5, col_c1, 
						col_c1_4, col_c5, col_d1, col_d1_4, col_d5, col_h1, col_h1_4, col_h5, dis_c1, dis_c1_4, dis_c5,
						dis_d1, dis_d1_4, dis_d5, dis_h1, dis_h1_4, dis_h5, cop_t1, cop_t1_4, cop_t5, cop_p1, cop_p1_4, 
						cop_p5, cop_s1, cop_s1_4, cop_s5, fecha_ing, clave, migrado, verifica, etapa, estado, etniaproc,
						etnias, procede, otroproc, usuario) 
						VALUES ('','".trim($datos[0])."','".trim($datos[1])."','".trim($datos[2])."','".trim($datos[3]).
						"','".trim($datos[4])."','".trim($datos[5])."','".trim($datos[6])."','".trim($datos[7]).
						"','".trim($datos[8])."','".trim($datos[9])."','".trim($datos[10])."','".trim($datos[11]).
						"','".trim($datos[12])."','".trim($datos[13])."','".trim($datos[14])."','".trim($datos[15]).
						"','".trim($datos[16])."','".trim($datos[17])."','".trim($datos[18])."','".trim($datos[19]).
						"','".trim($datos[20])."','".trim($datos[21])."','".trim($datos[22])."','".trim($datos[23]).
						"','".trim($datos[24])."','".trim($datos[25])."','".trim($datos[26])."','".trim($datos[27]).
						"','".trim($datos[28])."','".trim($datos[29])."','".trim($datos[30])."','".trim($datos[31]).
						"','".trim($datos[32])."','".trim($datos[33])."','".trim($datos[34])."','".trim($datos[35]).
						"','".trim($datos[36])."','".trim($datos[37])."','".trim($datos[38])."','".trim($datos[39]).
						"','".trim($datos[40])."','".trim($datos[41])."','".trim($datos[42])."','".trim($datos[43]).
						"','".trim($datos[44])."','".trim($datos[45])."','".trim($datos[46])."','".trim($datos[47]).
						"','".trim($datos[48])."','".trim($datos[49])."','".trim($datos[50])."','".trim($datos[51]).
						"','".trim($datos[52])."','".$this->session->userdata('usuario')."')");
					}
				}

				if(file_exists($ira)){
					$lineas = file($ira);
					
					foreach($lineas as $linea_num => $linea)
					{
						$datos = explode(",",str_replace('"','',$linea));

						$this->db->query("INSERT INTO iras (registroId, ano, semana, sub_reg_nt, red, microred, e_salud, 
						ubigeo, ira_m2, ira_2_11, ira_1_4a, neu_2_11, neu_1_4a, hos_m2, hos_2_11, hos_1_4a, ngr_m2, 
						ngr_2_11, ngr_1_4a, dih_m2, dih_2_11, dih_1_4a, deh_m2, deh_2_11, deh_1_4a, sob_2a, sob_2_4a, 
						fecha_ing, clave, migrado, verifica, etapa, ira_5_9a, ira_60a, neu_5_9a, neu_60a, hos_5_9a, 
						hos_60a, ngr_5_9a, ngr_60a, dih_5_9a, dih_60a, deh_5_9a, deh_60a, sob_5_9a, sob_60a, estado, 
						localcod, neu_10_19, neu_20_59, hos_10_19, hos_20_59, dih_10_19, dih_20_59, deh_10_19, deh_20_59, 
						etniaproc, etnias, procede, otroproc, usuario) 
						VALUES ('','".trim($datos[0])."','".trim($datos[1])."','".trim($datos[2])."','".trim($datos[3]).
						"','".trim($datos[4])."','".trim($datos[5])."','".trim($datos[6])."','".trim($datos[7]).
						"','".trim($datos[8])."','".trim($datos[9])."','".trim($datos[10])."','".trim($datos[11]).
						"','".trim($datos[12])."','".trim($datos[13])."','".trim($datos[14])."','".trim($datos[15]).
						"','".trim($datos[16])."','".trim($datos[17])."','".trim($datos[18])."','".trim($datos[19]).
						"','".trim($datos[20])."','".trim($datos[21])."','".trim($datos[22])."','".trim($datos[23]).
						"','".trim($datos[24])."','".trim($datos[25])."','".trim($datos[26])."','".trim($datos[27]).
						"','".trim($datos[28])."','".trim($datos[29])."','".trim($datos[30])."','".trim($datos[31]).
						"','".trim($datos[32])."','".trim($datos[33])."','".trim($datos[34])."','".trim($datos[35]).
						"','".trim($datos[36])."','".trim($datos[37])."','".trim($datos[38])."','".trim($datos[39]).
						"','".trim($datos[40])."','".trim($datos[41])."','".trim($datos[42])."','".trim($datos[43]).
						"','".trim($datos[44])."','".trim($datos[45])."','".trim($datos[46])."','".trim($datos[47]).
						"','".trim($datos[48])."','".trim($datos[49])."','".trim($datos[50])."','".trim($datos[51]).
						"','".trim($datos[52])."','".trim($datos[53])."','".trim($datos[54])."','".trim($datos[55]).
						"','".trim($datos[56])."','".trim($datos[57])."','".trim($datos[58]).
						"','".$this->session->userdata('usuario')."')");
					}
				}
				
				if(file_exists($febriles)){
					$lineas = file($febriles);
					
					foreach($lineas as $linea_num => $linea)
					{
						$datos = explode(",",str_replace('"','',$linea));

						$this->db->query("INSERT INTO febriles (registroId, ano, semana, sub_reg_nt, red, microred, e_salud, 
						ubigeo, feb_m1, feb_1_4, feb_5_9, feb_10_19, feb_20_59, feb_m60, fecha_ing, clave, feb_tot, fecha_not,
						fecha_ate, tot_aten, usuario) 
						VALUES ('','".trim($datos[0])."','".trim($datos[1])."','".trim($datos[2])."','".trim($datos[3]).
						"','".trim($datos[4])."','".trim($datos[5])."','".trim($datos[6])."','".trim($datos[7]).
						"','".trim($datos[8])."','".trim($datos[9])."','".trim($datos[10])."','".trim($datos[11]).
						"','".trim($datos[12])."','".trim($datos[13])."','".trim($datos[14])."','".trim($datos[15]).
						"','".trim($datos[16])."','".trim($datos[17])."','".trim($datos[18]).
						"','".$this->session->userdata('usuario')."')");
					}
				}

				//Eliminando los archivos txt

				$file = $carpeta . "NOTI_SP.TXT";
				$do = unlink($file);
				 
				$file = $carpeta . "eda_sp.txt";
				$do = unlink($file);

				$file = $carpeta . "ira_sp.txt";
				$do = unlink($file);

				$file = $carpeta . "mal_sp.txt";
				$do = unlink($file);
				
				$file = $carpeta . "feb_sp.txt";
				$do = unlink($file);
				
				//Obteniendo años cerrados
				
				$cerrados = $this->frontend_model->mostrarCierre();
				
				foreach($cerrados as $datos){
					$this->frontend_model->compactarBase($datos->anio);
				}
				
				//Actualizando el estado del registro del PNT
				$this->frontend_model->actualizaTelematica($id);
				
				//Actualizando el registro de auditoria
				$this->mantenimiento_model->auditoriaOperador($this->session->userdata('usuario'), 'Proceso PNT');		
				$this->session->set_flashdata('exito', 'El proceso de notificaci&oacute;n se ha realizado con &eacute;xito');
	            redirect(site_url("pnt/listadoNotificacion"), 301);
			}else{
				$this->session->set_flashdata('error', 'Su nivel no le permite realizar este proceso');
	            redirect(site_url("index/principal"), 301);
			}
		}
	}
	
	// Callback para la notificación telemática
	public function log_usuario_after_insert($post_array, $primary_key)
	{
		$this->frontend_model->ejecutarNotificacion($primary_key);
		$this->mantenimiento_model->auditoriaOperador($this->session->userdata('usuario'), 'Notificacion telematica');		
		return true;
	}
}