<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends CI_Controller {
    
    private $session_id;

	public function __construct()
    {
        parent::__construct();
        $this->session_id =  $this->session->userdata('usuario');
		date_default_timezone_set('America/Lima');
	}

    public function index()
    {
		if(!empty($this->session_id)){
            $this->layout->view('backend/index/index');
        }else{
            redirect(site_url("backend/index/login"), 301);
        }
    }
	
    public function login()
    {
        $this->layout->setLayout('template1');
        $this->layout->setTitle(":: NotiWeb :: Vigilancia Epidemiol&oacute;gica");
		
        if($this->input->post()){
            if ($this->form_validation->run("index/login"))
            {
				if($this->input->post("clave", true) == '1234567')
				{
					$dato = $this->usuarios_model->buscarAdministrador($this->input->post('usuario'));
					
					foreach($dato as $dat){
						$administrador[] = $dat->correo; 
						$administrador[] = $dat->nombres; 
					}
					
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
						
						$seguro = $this->usuarios_model->buscarSeguridad($this->input->post("usuario"),$code);
						
						if(empty($seguro)){
							$this->usuarios_model->registrarSeguridad($this->input->post("usuario"),$code);
						}else{
							$this->usuarios_model->modificarSeguridad($this->input->post("usuario"),$code);
						}
	
						redirect('backend/index/cambioClave', 301);
					}
				}
				
                $datos = $this->login_model->getLoginBackend($this->input->post("usuario", true), $this->input->post("clave", true));
                
                if($datos == TRUE){
                    redirect(site_url("backend/index/principal"), 301);
                }else{
                    $this->session->set_flashdata('error', 'Usuario y/o Clave incorrecta.');
                    redirect(site_url("backend/index/login"), 301);
                }
            }
        }

		$this->layout->view('login');
    }

	public function cambioClave()
	{
        $this->layout->setLayout('template1');
        $this->layout->setTitle(":: NotiWeb :: Vigilancia Epidemiol&oacute;gica");
		
        if ($this->form_validation->run("index/login"))
        {
			$seguridad = $this->usuarios_model->buscarSeguridad($this->input->post("usuario"));
			
			foreach($seguridad as $dato){
				$administrador[] = $dato->codigo; 
			}

			if($administrador[0] == $this->input->post("seguridad")){
				$codigo = md5($this->input->post("clave", true));
				
				$data=array(
					"usuario"=>$this->input->post("usuario", true),
					"clave"=>$codigo,
					"codigo"=>$this->input->post("clave", true)
				);
				
				$guardar = $this->login_model->cambiarClaveBackend($data);
	
				if($guardar)
				{
					$this->usuarios_model->eliminarSeguridad($this->input->post("usuario"));
					
					$this->session->set_flashdata('exito', 'Contrase&ntilde;a cambiada con &eacute;xito.');
					redirect(site_url('backend/index/login'), 301);
				}else{
					$this->session->set_flashdata('info', 'Usted debe cambiar su contrase&ntilde;a, proceda a hacerlo.');
					$this->layout->view("cambioClave");
				}
			}else{
			  $this->session->set_flashdata('error', 'El código registrado no existe, acción cancelada.');
			  redirect(site_url('backend/index/login'), 301);
			}
		}
		$this->session->set_flashdata('info', 'Usted debe cambiar su contrase&ntilde;a, proceda a hacerlo.');
		$this->layout->view("cambioClave");
	}

    public function principal()
    {
        $this->layout->setLayout('template2');
        $this->layout->setTitle(":: NotiWeb :: Vigilancia Epidemiol&oacute;gica");
		
		if($this->session->userdata('nivel') <> '1'){
            redirect(site_url("backend/index/login"), 301);
		}
		
        if(!empty($this->session_id)){
            $session_id = $this->session_id;
            $this->layout->view('principal', compact("session_id"));
        }else{
            redirect(site_url("backend/index/login"), 301);
        }
    }

    public function logout()
    {
        $this->session->unset_userdata(array('usuario'=>''));
        $this->session->sess_destroy("usuario");
        redirect(site_url("backend/index/login"), 301);
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