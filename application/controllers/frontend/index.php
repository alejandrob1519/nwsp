<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends CI_Controller {
    
    private $session_id;

	public function __construct()
    {
        parent::__construct();
        $this->session_id = $this->session->userdata('usuario');
		date_default_timezone_set('America/Lima');
	}

    public function index()
    {
        if(!empty($this->session_id)){
            redirect(site_url("index/principal"), 301);
        }else{
            redirect(site_url("index/login"), 301);
        }
    }
	
    public function login()
    {
        $this->layout->setLayout('template3');
        $this->layout->setTitle(":: NotiWeb :: Vigilancia Epidemiol&oacute;gica");
		
        if($this->input->post()){
            if ($this->form_validation->run("index/login"))
            {
                $datos = $this->login_model->getLoginFrontend($this->input->post("usuario", true), $this->input->post("clave", true));
				
                if($datos == TRUE){
					if($this->input->post("clave", true) == '1234567')
					{
						redirect('index/cambioClave?id='.$this->input->post("usuario"), 301);
					}
					
					$accion = 'Coneccion al NotiWeb';
					
					$this->mantenimiento_model->auditoriaOperador($this->input->post("usuario"), $accion);
		
					$this->session->set_flashdata('exito', 'Conexi&oacute;n exitosa, Bienvenido!!');
					redirect(site_url("index/principal"), 301);
                }else{
                    $this->session->set_flashdata('ControllerMessage', 'Usuario y/o clave incorrecta &oacute; su usuario no se encuentra activado.');
                    redirect(site_url("index/login"), 301);
                }
            }
        }

		$estado = $this->login_model->estado();
		
		if($estado->estado == '0'){
			redirect(site_url('index/mantenimiento'), 301);
		}
		
		$this->layout->view('login');
    }

    public function principal()
    {
        $this->layout->setLayout('template4');
        $this->layout->setTitle(":: NotiWeb :: Vigilancia Epidemiol&oacute;gica");
		
		$estado = $this->login_model->estado();
		
		if($estado->estado == '0'){
			redirect(site_url('index/mantenimiento'), 301);
		}
		
		$caducidad = $this->session->userdata('caduca');
		
		$faltan = $this->login_model->daysDifference($caducidad, date('Y-m-d'));
		
        if(!empty($this->session_id)){
            $session_id = $this->session_id;
			$nivel_id = $this->session->userdata('nivel');
			
			if($faltan <= 30){
			    $termina = 'Faltan '.$faltan.' d&iacute;as para que su usuario caduque, USTED DEBE CAMBIAR SU CONTRASE&Ntilde;A para obtener UN A&Ntilde;O MAS. Proceda por favor.';
			}
			
			if($faltan <= 0){
				$data = array("usuario" => $this->session->userdata("usuario"), "estado" => "2");
				
				$this->login_model->baja($data);
				
	            redirect(site_url("index/login"), 301);
			}
			
			$this->layout->view('principal', compact("session_id", "nivel_id", "termina"));
        }else{
            redirect(site_url("index/login"), 301);
        }
    }

	public function cambioClave()
	{
        $this->layout->setLayout('template3');
        $this->layout->setTitle(":: NotiWeb :: Vigilancia Epidemiol&oacute;gica");
		
		if($this->input->post()){
			if ($this->form_validation->run("index/login"))
			{
				$seguridad = $this->usuarios_model->buscarSeguridad($this->input->post("usuario"));
				
				foreach($seguridad as $dato){
					$administrador[] = $dato->codigo; 
				}
				
				if($administrador[0] == $this->input->post("seguridad")){
					$fecha = date("d-m-Y");
					$caducidad = $this->usuarios_model->dateadd($fecha,0,0,1,0,0,0);
					
					$codigo = md5($this->input->post("clave", true));
					
					$data=array(
						"usuario"=>$this->input->post("usuario", true),
						"clave"=>$codigo,
						"codigo"=>$this->input->post("clave", true),
						"caduca"=>$this->fechas_model->arreglarFechas($caducidad)
					);
					
					$guardar = $this->login_model->cambiarClave($data);
		
					if($guardar)
					{
						$this->usuarios_model->eliminarSeguridad($this->input->post("usuario"));
						
						$this->session->set_flashdata('exito', 'Contrase&ntilde;a cambiada con &eacute;xito.');
						redirect(site_url('index/login'), 301);
					}else{
						$this->session->set_flashdata('ControllerMessage', 'Usted debe cambiar su contrase&ntilde;a, proceda a hacerlo.');
						$this->layout->view("cambioClave");
					}
				}else{
				  $this->session->set_flashdata('error', 'El código registrado no existe, acción cancelada.');
				  redirect(site_url('index/login'), 301);
				}
			}
		}else{
			if(!$this->input->get()){
				$id = $this->session->userdata('usuario');
			}else{
				$id = $this->input->get('id');
			}
			
			if(!empty($id)){
				$dato = $this->usuarios_model->buscarOperador($id);
			}else{
				$dato = $this->usuarios_model->buscarOperador($this->session->userdata('usuario'));
			}
			
			$administrador[] = $dato->email; 
			$administrador[] = $dato->nombres; 
			
			$code = $this->mKey();
			
			if(!empty($administrador)){
				$body = "
				Estimado(a): ".$administrador[1]."<br>
				<br>
				Recibes este mensaje con el código de seguridad para poder cambiar tu contraseña.<br/><br/>
				Código: <b>".$code."</b><br /><br />
				Si usted no está deseando cambiar su contraseña y no ha solicitado el código de seguridad, comuníquelo urgentemente a la Dirección General de Epidemiología.<br/><br/>
				Agradecemos inmensamente tu siempre gentil colaboracion.<br/><br/>
				POR FAVOR NO RESPONDAS A ESTE MENSAJE DE CORREO";
				
				$asunto = "Usted ha recibido un mensaje de la Direccion General de Epidemiologia.";
				$From = "notificacion@dge.gob.pe";
				$FromName = "Direccion General de Epidemiologia";
	
				$this->sendMail($asunto,$administrador[0],$administrador[1],$From,$FromName,$body);
				
				$seguro = $this->usuarios_model->buscarSeguridad($id,$code);
				
				if(empty($seguro)){
					$this->usuarios_model->registrarSeguridad($id,$code);
				}else{
					$this->usuarios_model->modificarSeguridad($id,$code);
				}
			}
		}
		
        $this->session->set_flashdata('ControllerMessage', 'Usted debe cambiar su contrase&ntilde;a, proceda a hacerlo.');
   		$this->layout->view("cambioClave");
	}

	public function olvido()
    {
        if($this->input->post()){
            if ($this->form_validation->run("index/olvido"))
            {
				$mensaje = $this->login_model->olvido($this->input->post('correo'));
				
				if($mensaje){
					$this->session->set_flashdata('ControllerMessage', 'Mensaje emitido con &eacute;xito.');

					$body = "
					Estimado(a): $mensaje->nombres<br>
					<br>
					Recibes este mensaje como respuesta a tu solicitud de remisión de usuario y contraseña de acceso al sistema NotiWeb, de no haberlo solicitado comunícalo urgentemente a la Dirección General de Epidemiología<br/><br/>
					Agradecemos inmensamente tu siempre gentil colaboracion.<br/><br/>
					Usuario: <b>$mensaje->usuario</b><br/>
					Contraseña: <b>$mensaje->codigo</b><br/><br/>
					POR FAVOR NO RESPONDAS A ESTE MENSAJE DE CORREO";
					
					$asunto = "Usted ha recibido un mensaje de la Direccion General de Epidemiologia.";
					$From = "notificacion@dge.gob.pe";
					$FromName = "Direccion General de Epidemiologia";
	
					$this->sendMail($asunto,$this->input->post('correo'),$mensaje->nombres,$From,$FromName,$body);
					
					redirect(site_url("index/login"), 301);
				}else{
					$this->session->set_flashdata('ControllerMessage', 'Correo electr&oacute;nico no existe.');
					redirect(site_url("index/olvido"), 301);
				}
			}
		}
		$this->layout->setLayout('template3');
        $this->layout->setTitle(":: NotiWeb ::");
		
        $this->layout->view("olvido");
    }

    public function logout()
    {
		$accion = 'Sesion terminada';
		
		$this->mantenimiento_model->auditoriaOperador($this->session_id, $accion);

        $this->session->unset_userdata(array('usuario'=>''));
        $this->session->sess_destroy("usuario");
        redirect(site_url("index/login"), 301);
    }
	
	public function Baja()
	{
        $this->layout->setLayout('template4');
        $this->layout->setTitle(":: NotiWeb :: Vigilancia Epidemiol&oacute;gica");
		
        if ($this->input->post())
        {
			$data=array("usuario"=>$this->session->userdata("usuario"), 'estado' => '3');
			
			$guardar = $this->login_model->Baja($data);

			if($guardar)
			{
			    $this->session->set_flashdata('info', 'Su usuario ha sido dado de baja');
				redirect(site_url('index/login'), 301);
			}else{
			    $this->session->set_flashdata('error', 'Ocurri&oacute; un error en el proceso, comun&iacute;quese con el administrador del sistema.');
				redirect(site_url('index/login'), 301);
			}
		}
		
    	$this->layout->view("darBaja");
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
		  $mail->AddAddress('areanotificacion@dge.gob.pe','Area Notificacion');
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

	public function mantenimiento(){
        $this->layout->setLayout('template3');
        $this->layout->setTitle(":: NotiWeb :: Vigilancia Epidemiol&oacute;gica");
		
		$this->layout->view("mantenimiento");
	}

	public function solicitud(){
        $this->layout->setLayout('template3');
        $this->layout->setTitle(":: NotiWeb :: Vigilancia Epidemiol&oacute;gica");

        if($this->input->post()){
            if ($this->form_validation->run("index/solicitud"))
            {
				print_r($this->input->post());
				
				$data = array(
				'usuario' => $this->input->post('dni'),
				'nombres' => $this->input->post('nombres'),
				'dni' => $this->input->post('dni'),
				'email' => $this->input->post('correo'),
				'nivel' => $this->input->post('nivel'),
				'estado' => '0',
				'institucion' => $this->input->post('institucion'),
				'diresa' => $this->input->post('diresa'),
				'red' => $this->input->post('redes'),
				'microred' => $this->input->post('microred'),
				'establecimiento' => $this->input->post('establec'),
				'autoriza' => 'Sistema',
				'registro' => date("Y-m-d")
				);
				
				$existe = $this->usuarios_model->buscarOperador($this->input->post('dni'));
				
				if(count($existe) == 0){
					$guardar = $this->usuarios_model->insertarOperador($data);
							
					if($guardar)
					{
						$body = "
						Estimado(a): ".$this->input->post('nombres')."<br>
						<br>
						Recibes este mensaje como respuesta a tu solicitud de registro de usuario y contraseña de acceso al sistema NotiWeb, de no haberlo solicitado comunícalo urgentemente a la Dirección General de Epidemiología.<br/><br/>
						para que podamos activar tu usuario y contraseña usted debe esperar a que vuestra DIRESA no brinde el visto bueno correspondiente, por favor comunícate con el encargado de su DIRESA / DISA / SUBREGION / GERSA, para realizar las coordinaciones del caso.<br /><br />
						Agradecemos inmensamente tu siempre gentil colaboracion.<br/><br/><br/>
						POR FAVOR NO RESPONDAS A ESTE MENSAJE DE CORREO";
						
						$asunto = "Usted ha recibido un mensaje de la Direccion General de Epidemiologia.";
						$From = "notificacion@dge.gob.pe";
						$FromName = "Direccion General de Epidemiologia";
		
						$this->sendMail($asunto,$this->input->post('correo'),$mensaje->nombres,$From,$FromName,$body);
						
						$this->session->set_flashdata('exito', 'Exito: Informaci&oacute;n guardada con &eacute;xito.');
						redirect(site_url('index/login'), 301);
					}else{
						$this->session->set_flashdata('error', 'Error: NO se grab&oacute; el registro.');
						redirect('index/solicitud', 301);
					}
				}else{
					$this->session->set_flashdata('error', 'Error: Este DNI ya est&aacute; siendo usado por un usuario, coordine usted con el administrador del sistema.');
					redirect('index/solicitud', 301);
				}
			}
		}
		
		//combo DIRESA
		
		$subreg = $this->frontend_model->buscarDiresas();
		
		$diresa[''] = 'Seleccione ...';
		foreach ($subreg as $dato){
			$diresa[$dato->codigo] = $dato->nombre;
		}

		$redes[''] = 'Seleccione ...';
		$microred[''] = 'Seleccione ...';
		$establec[''] = 'Seleccione ...';

		$this->layout->view("solicitud", compact('diresa', 'redes', 'microred', 'establec'));
	}

	function validar_establec($str){
		if($this->input->post('diresa') == '' and $this->input->post('redes') == '' and $this->input->post('microred') == '' and $this->input->post('establec') == ''){
		  $this->form_validation->set_message('validar_establec',
			  'Debe elegir alg&uacute;n nivel de registro');
			  return FALSE;
		}
	}

	function mKey($len = 4, $type = 'ALNUM') 
	{ 
		// Register the lower case alphabet array 
		$alpha = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 
					   'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'); 
	
		// Register the upper case alphabet array					 
		$ALPHA = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 
						 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'); 
			
		// Register the numeric array			   
		$num = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '0'); 
		
		// Initialize the keyVals array for use in the for loop 
		$keyVals = array(); 
		
		// Initialize the key array to register each char 
		$key = array();	
		
		// Loop through the choices and register 
		// The choice to keyVals array 
		switch ($type) 
		{ 
			case 'lower' : 
				$keyVals = $alpha; 
				break; 
			case 'upper' : 
				$keyVals = $ALPHA; 
				break; 
			case 'numeric' : 
				$keyVals = $num; 
				break; 
			case 'ALPHA' : 
				$keyVals = array_merge($alpha, $ALPHA); 
				break; 
			case 'ALNUM' : 
				$keyVals = array_merge($alpha, $ALPHA, $num); 
				break; 
		} 
		
		// Loop as many times as specified 
		// Register each value to the key array 
		for($i = 0; $i <= $len-1; $i++) 
		{ 
			$r = rand(0,count($keyVals)-1); 
			$key[$i] = $keyVals[$r]; 
		} 
		
		// Glue the key array into a string and return it 
		return join("", $key); 
	} 
}