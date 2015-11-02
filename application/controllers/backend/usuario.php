<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuario extends CI_Controller {

    public function __construct()
    {
		parent::__construct();
        $this->layout->setLayout('template2');
        $this->layout->setTitle("Vigilancia Epidemiol&oacute;gica");

		if($this->session->userdata('nivel') <> '1'){
            redirect(site_url("backend/index/login"), 301);
		}
	}

    public function _example_output($output = null)
    {
		$this->layout->view('usuario.php',$output);
    }

    public function _example_output1($output = null)
    {
		$this->layout->view('equipos.php',$output);
    }

    public function _example_output2($output = null)
    {
		$this->layout->view('niveles.php',$output);
    }

    public function _example_output3($output = null)
    {
		$this->layout->view('frontend.php',$output);
    }

    public function _example_output4($output = null)
    {
		$this->layout->view('niveles.php',$output);
    }

    public function _example_output5($output = null)
    {
		$this->layout->view('caducados.php',$output);
    }

    public function index()
    {
		$this->_example_output((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
		$this->_example_output1((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
		$this->_example_output2((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
		$this->_example_output3((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
		$this->_example_output4((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
		$this->_example_output5((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
    }
    
	//Grocery Crud: Listado de Usuarios
    public function listarUsuariosAdministradores()
    {
		$adm = $this->usuarios_model->buscarAdministrador($this->session->userdata('usuario'));
		
		$administrador = array();
		
		foreach($adm as $dato){
			$administrador[$dato->usuario] = $dato->nombres;
		}
		
		$crud = new grocery_CRUD();

		$crud->set_table('usuarios_backend');
		$crud->columns('usuario','nombres','dni','correo','nivel','estado','codigo','autoriza','caduca','registro');
		$crud->display_as('registroId','from usuarios_backend')
					->display_as('usuario','Usuario')
					->display_as('contrasena','Contrase&ntilde;a');
		$crud->change_field_type('clave','password');
		$crud->set_subject('Usuario');
		$crud->field_type('nivel','dropdown',array('1' => 'Administrador', '2' => 'Operador'));         
		$crud->field_type('estado','dropdown',array('1' => 'Activo', '2' => 'Inactivo'));         
		$crud->field_type('autoriza','dropdown',$administrador);         
		
		$crud->callback_before_insert(array($this,'encrypt_password_callback'));
		$crud->callback_before_update(array($this,'encrypt_password_callback'));
		
		$crud->unset_read();
			
		$output = $crud->render();

		$this->_example_output($output);
    }

	//Grocery Crud: Listado de Usuarios
    public function listarUsuarios()
    {
		$niveles = $this->usuarios_model->buscarNiveles();
		
		$a = count($niveles);
		$i = 1;
		$nnivel = array();
		
		foreach($niveles as $dato){
				$nnivel[$dato->nivel] = $dato->nombre;
		}
		
		$crud = new grocery_CRUD();

		$crud->set_table('usuarios_frontend');
		$crud->columns('nombres','nivel','diresa','red','microred','establecimiento','estado','institucion','grabar','modificar','eliminar','descarga');
		$crud->display_as('usuario','Usuario')
					->display_as('caduca','Caducidad');
		$crud->set_subject('Usuario');
		$crud->field_type('nivel','dropdown',$nnivel);         
		$crud->field_type('estado','dropdown',array('0' => 'Pendiente', '1' => 'Activo', '2' => 'Inactivo', '3' => 'Baja'));         
		$crud->field_type('grabar','dropdown',array('0' => 'No', '1' => 'Si'));         
		$crud->field_type('modificar','dropdown',array('0' => 'No', '1' => 'Si'));         
		$crud->field_type('eliminar','dropdown',array('0' => 'No', '1' => 'Si'));         
		$crud->field_type('descarga','dropdown',array('0' => 'No', '1' => 'Si'));         
		$crud->field_type('institucion','dropdown',array('A' => 'MINSA', 'C' => 'ESSALUD', 'D'=>'FFAA/PNP', 'X'=>'PRIVADOS'));         
		
		$crud->unset_add();
		$crud->unset_edit();
		
		$crud->add_action_peru('', '', site_url('backend/usuario/registrar'),'');
		$crud->add_action('Modificar usuario', '', 'backend/usuario/modificar','edit-icon');
		$crud->add_action('Autorizar usuario', base_url().'public/images/about.png', 'backend/fichas/autorizaFichas','');
		
		$output = $crud->render();

		$this->_example_output3($output);
    }

	//Grocery Crud: Listado de Niveles
    public function listarNiveles()
    {
		$crud = new grocery_CRUD();

		$crud->set_table('niveles');
		$crud->columns('nivel','nombre','estado');
		$crud->set_subject('Niveles');
		$crud->field_type('estado','dropdown',array('1' => 'Activo', '2' => 'Inactivo'));         
		
		$output = $crud->render();

		$this->_example_output4($output);
    }

    //Registra un nuevo usuario en la base de datos
    public function registrar()
    {
        if($this->input->post()){
            if ($this->form_validation->run("operadores/usuario"))
            {
						
				$codigo = md5($this->input->post("clave", true));
				if($this->input->post("grabar", true) == 'grabar'){ 
					$graba =  '1';
				}else{ 
					$graba = '0';
				}
				
				if($this->input->post("modificar", true) == 'modificar'){ 
					$modifica = '1';
				}else{ 
					$modifica = '0';
				}
				
				if($this->input->post("eliminar", true) == 'eliminar'){ 
					$elimina = '1';
				}else{ 
					$elimina = '0';
				}

				if($this->input->post("descargar", true) == 'descargar'){ 
					$descargar = '1';
				}else{ 
					$descargar = '0';
				}

				$data = array
				(
					"usuario"=>$this->input->post("codigo", true),
					"clave"=>$codigo,
					"nombres"=>$this->input->post("nombres", true),
					"dni"=>$this->input->post("dni", true),
					"email"=>$this->input->post("correo", true),
					"nivel"=>$this->input->post("nivel", true),
					"institucion"=>$this->input->post("institucion", true),
					"caduca"=>$this->fechas_model->arreglarFechas($this->input->post('caduca')),
					"estado"=>$this->input->post("estado", true),
					"diresa"=>$this->input->post("diresa", true),
					"red"=>$this->input->post("redes", true),
					"microred"=>$this->input->post("microred", true),
					"establecimiento"=>$this->input->post("establec", true),
					"grabar"=>$graba,
					"modificar"=>$modifica,
					"eliminar"=>$elimina,
					"descarga"=>$descargar,
					"equipo"=>$this->input->post("equipo", true),
					"codigo"=>$this->input->post("clave", true),
					"autoriza"=>$this->session->userdata("usuario"),
					"registro"=>date("Y-m-d")
				);
						
				$guardar = $this->usuarios_model->insertarOperador($data);
						
				if($guardar)
				{
					redirect(site_url('backend/usuario/listarUsuarios'), 301);
				}else{
					redirect('backend/usuario/registrar', 301);
				}
            }
        }
       
        $this->layout->view("registrar");
    }

    //Modifica el registro del usuario en la tabla usuarios
    public function modificar($id=null)
    {
		if(!$id)
		{
			show_404();
		}
		
        if($this->input->post()){
            if ($this->form_validation->run("operadores/usuario"))
            {

				$codigo = md5($this->input->post("clave", true));
				if($this->input->post("grabar", true) == 'grabar'){ 
					$graba =  '1';
				}else{ 
					$graba = '0';
				}
				
				if($this->input->post("modificar", true) == 'modificar'){ 
					$modifica = '1';
				}else{ 
					$modifica = '0';
				}
				
				if($this->input->post("eliminar", true) == 'eliminar'){ 
					$elimina = '1';
				}else{ 
					$elimina = '0';
				}

				if($this->input->post("descarga", true) == 'descarga'){ 
					$descarga = '1';
				}else{ 
					$descarga = '0';
				}

				$data = array
				(
					"usuario"=>$this->input->post("codigo", true),
					"clave"=>$codigo,
					"nombres"=>$this->input->post("nombres", true),
					"dni"=>$this->input->post("dni", true),
					"email"=>$this->input->post("correo", true),
					"nivel"=>$this->input->post("nivel", true),
					"institucion"=>$this->input->post("institucion", true),
					"caduca"=>$this->fechas_model->arreglarFechas($this->input->post('caduca')),
					"estado"=>$this->input->post("estado", true),
					"diresa"=>$this->input->post("diresa", true),
					"red"=>$this->input->post("redes", true),
					"microred"=>$this->input->post("microred", true),
					"establecimiento"=>$this->input->post("establec", true),
					"grabar"=>$graba,
					"modificar"=>$modifica,
					"eliminar"=>$elimina,
					"descarga"=>$descarga,
					"equipo"=>$this->input->post("equipo", true),
					"codigo"=>$this->input->post("clave", true),
					"autoriza"=>$this->session->userdata("usuario"),
					"registro"=>date("Y-m-d")
				);
						
				$guardar = $this->usuarios_model->ejecutarModificarOperador($data, $id);
						
				if($guardar)
				{
					if($this->input->post("mensaje", true) == 'mensaje'){ 
						$body = "
						Estimado(a): ".$this->input->post('nombres')."<br>
						<br>
						Recibes este mensaje como respuesta a tu solicitud de registro de usuario y contraseña de acceso al sistema NotiWeb de la Dirección General de Epidemiología.<br/><br/>
						Usuario: <b>".$this->input->post('codigo')."</b><br /><br />
						Contraseña: <b>".$this->input->post('clave')."</b><br /><br />
						Al ingresar al software por primera vez, el mismo le solicitará que cambie su contraseña por una de su preferencia.<br/><br/>
						Agradecemos inmensamente tu siempre gentil colaboracion.<br/><br/>
						POR FAVOR NO RESPONDAS A ESTE MENSAJE DE CORREO";
						
						$asunto = "Usted ha recibido un mensaje de la Direccion General de Epidemiologia.";
						$From = "notificacion@dge.gob.pe";
						$FromName = "Direccion General de Epidemiologia";
		
						$this->sendMail($asunto,$this->input->post('correo'),$mensaje->nombres,$From,$FromName,$body);
						
					}
					redirect(site_url('backend/usuario/listarUsuarios'), 301);
				}else{
					redirect('backend/usuario/modificar/'.$id, 301);
				}
            }
        }
		
		$modificar = $this->usuarios_model->buscarOperadores($id);
			
		if(sizeof($modificar)==0)
		{
			show_404();
		}
		
		$result = $this->mantenimiento_model->buscarDiresas();
		
		$diresa[''] = 'Seleccione ...';
		foreach ($result as $dato){
			$diresa[$dato->codigo] = $dato->nombre;
		}
		
		$result = $this->mantenimiento_model->buscarRedes($modificar->diresa);
		
		$redes[''] = 'Seleccione ...';
		foreach ($result as $dato){
			$redes[$dato->codigo] = $dato->nombre;
		}
		
		$result = $this->mantenimiento_model->buscarMicroredes($modificar->diresa, $modificar->red);
		
		$microred[''] = 'Seleccione ...';
		foreach ($result as $dato){
			$microred[$dato->codigo] = $dato->nombre;
		}

		$result = $this->mantenimiento_model->buscarEstablec($modificar->diresa, $modificar->red, $modificar->microred);
		
		$establec[''] = 'Seleccione ...';
		foreach ($result as $dato){
			$establec[$dato->cod_est] = $dato->raz_soc;
		}

		$this->layout->view("modificar", compact('id', 'diresa', 'redes', 'microred', 'establec', 'modificar'));
    }

	function encrypt_password_callback($post_array, $primary_key = null)
	{
		$post_array['clave'] = do_hash($post_array['clave'], 'md5');
		return $post_array;
	}

	//Grocery Crud: Listado de equipos temáticos
    public function listarTematicos()
    {
		$crud = new grocery_CRUD();

		$crud->set_table('tematicos');
		$crud->columns('registroId','codigo','denominacion');
		$crud->display_as('registroId','Item');
		$crud->set_subject('Equipo');
		
		$output = $crud->render();

		$this->_example_output1($output);
    }

	//Grocery Crud: Listado de Usuarios caducados
    public function listarCaducados()
    {
		$niveles = $this->usuarios_model->buscarNiveles();
		
		$a = count($niveles);
		$i = 1;
		$nnivel = array();
		
		foreach($niveles as $dato){
				$nnivel[$dato->nivel] = $dato->nombre;
		}
		
		$crud = new grocery_CRUD();

		$crud->set_table('usuarios_frontend');
		$crud->columns('usuario','nombres','nivel','diresa','red','microred','establecimiento','estado','autoriza','caduca','registro');
		$crud->display_as('usuario','Usuario')
					->display_as('caduca','Caducidad');
		$crud->set_subject('Usuario');
		$crud->field_type('nivel','dropdown',$nnivel);         
		$crud->field_type('estado','dropdown',array('0' => 'Pendiente', '1' => 'Activo', '2' => 'Inactivo', '3' => 'Baja'));         
		$crud->where("caduca < ", date('Y-m-d'));
		$crud->unset_add();
		$crud->unset_edit();
		$crud->unset_delete();
		$crud->unset_print();
		//$crud->unset_export();
		
		$crud->add_action_peru('', '', site_url('backend/usuario/actualizar'),'');
		//$crud->add_action('Modificar usuario', '', 'backend/usuario/modificar','edit-icon');
		
		
		$output = $crud->render();

		$this->_example_output5($output);
    }
	
	public function actualizar(){
		$caducados = $this->usuarios_model->listarCaducados();
		
		foreach($caducados as $datos){
			$this->usuarios_model->actualizarCaducidad($datos->registroId, $datos->registro);
		}
		
		redirect(site_url('backend/usuario/listarUsuarios'), 301);
	}

	public function sendMail($Asunto,$emailPara,$nombrePara,$email_de,$nombre_de, $body)
	{
		$mail = new PHPMailer(true); 
		$mail->IsSMTP(); 
		try {
		  $mail->SMTPDebug  =  0;//2;                
		  $mail->SMTPAuth   = true;                  
		  $mail->SMTPSecure = "ssl";
		  $mail->Host = "192.168.200.8";
		  $mail->Port = 465;
		  $mail->Username = "notificacion@dge.gob.pe";
		  $mail->Password = 'notifica';
		  $mail->AddAddress('aurbiola@dge.gob.pe','Anibal Urbiola Ayquipa');
		  $mail->AddBCC($emailPara, $nombrePara);//Destinatario
		  $mail->SetFrom($email_de, $nombre_de); //Remitente
		  $mail->Subject = $Asunto; //asunto
		  $mail->AltBody = 'Para ver el mensaje es necesario usuar un cliente de correo compatible con HTML!'; 
		  //$mail->MsgHTML(file_get_contents('contents.html')); //Cuerpo HTML
		  $mail->MsgHTML($body); //Cuerpo HTML
		  $mail->Send();
		} catch (phpmailerException $e) {
		  $echo = $e->errorMessage(); 
		} catch (Exception $e) {
		  $echo = $e->getMessage(); 
		}
	}
}
