<?php echo $dato->nombre?><?php
class login_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
	
	//Estado de línea del sistema
	public function estado()
	{
		$query = $this->db
                ->select("estado")
				->get('mantenimiento');
				return $query->row();
	}

	function getLoginBackend($usuario, $clave) 
    {
    	$datoValidar = array(
        'usuario' => $usuario, 
    	'clave' => md5($clave),
    	'estado' => '1'
    	); 
    	
    	$validado = $this->db->get_where('usuarios_backend', $datoValidar);
        
    	if ($validado->num_rows() == 1){
        	foreach ($this->credencial($usuario)->result() as $usuarioValidado) {
				$username = $usuarioValidado->usuario;
				$nivel = $usuarioValidado->nivel;
				$estado = $usuarioValidado->estado;
				$correo = $usuarioValidado->correo;
			}

			$datoSesion = array(
			'usuario' => $usuario,
			'sesionIniciada' => TRUE,
			'username' => $username,
			'nivel' => $nivel,
			'estado' => $estado,
			'correo' => $correo
			);

            $this->session->set_userdata($datoSesion);

            return TRUE;
    	}else{
            return FALSE;
    	}
    }

	function getLoginFrontend($usuario, $clave) 
    {
    	$datoValidar = array(
        'usuario' => $usuario, 
    	'clave' => md5($clave),
    	'estado' => '1'
    	); 
    	
    	$validado = $this->db->get_where('usuarios_frontend', $datoValidar);
		
    	if ($validado->num_rows() == 1){
        	foreach ($this->credencialFrontend($usuario)->result() as $usuarioValidado) {
				$usuario = $usuarioValidado->usuario;
				$nombres = $usuarioValidado->nombres;
				$nivel = $usuarioValidado->nivel;
				$institucion = $usuarioValidado->institucion;
				$diresa = $usuarioValidado->diresa;
				$red = $usuarioValidado->red;
				$microred = $usuarioValidado->microred;
				$establecimiento = $usuarioValidado->establecimiento;
				$estado = $usuarioValidado->estado;
				$correo = $usuarioValidado->correo;
				$grabar = $usuarioValidado->grabar;
				$modificar = $usuarioValidado->modificar;
				$eliminar = $usuarioValidado->eliminar;
				$descarga = $usuarioValidado->descarga;
				$equipo = $usuarioValidado->equipo;
				$caduca = $usuarioValidado->caduca;
			}
			
			$datoSesion = array(
			'usuario' => $usuario,
			'nombres' => $nombres,
			'sesionIniciada' => TRUE,
			'nivel' => $nivel,
			'institucion' => $institucion,
			'diresa' => $diresa,
			'red' => $red,
			'microred' => $microred,
			'establecimiento' => $establecimiento,
			'estado' => $estado,
			'grabar' => $grabar,
			'modificar' => $modificar,
			'eliminar' => $eliminar,
			'descarga' => $descarga,
			'equipo' => $equipo,
			'caduca' => $caduca
			);

            $this->session->set_userdata($datoSesion);
			
            return TRUE;
    	}else{
            return FALSE;
    	}
    }
	
	function loginAccesoFichas($usuario=null, $aplicacion=null)
	{
		$where = array("usuario"=>$usuario, "aplicacion"=>$aplicacion, "estado"=>"1");
		
		$query = $this->db
                ->select("registroId")
				->from('tablaccesos')
				->where($where)
				->get();
				return $query->row();
	}

    function auditoriaOperador($usuario, $dato) 
	{
		$mes = date('Y') - 2;
		
		$datoAuditar = array(
		'ipentrada' => $this->Saber_IP(),
		'usuario' => $usuario, 
		'fecha' => date('Y-m-d'),
		'hentrada' => date('H:i:s'),
		'browser' => $this->agent->agent_string(),
		'pagina' => $_SERVER['REQUEST_URI'],
		'accion' => $dato,
		'anio' => date('Y'),
		'mes' => date('m')
    	); 
		
		$this->db->insert('auditoria', $datoAuditar);
		
		//$this->db->delete('auditoria', array('anio' => $mes)); 
	}

	function credencial($usuario)
    {
    	$this->db->where('usuario', $usuario);
    	return $this->db->get('usuarios_backend');
    }  

	function credencialFrontend($usuario)
    {
    	$this->db->where('usuario', $usuario);
    	return $this->db->get('usuarios_frontend');
    }  

	function Saber_IP(){
		if(getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown")){
			$ip = getenv("HTTP_CLIENT_IP");
		}
		elseif(getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown")){
			$ip = getenv("HTTP_X_FORWARDED_FOR");
		}
		elseif(getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown")){
			$ip = getenv("REMOTE_ADDR");
		}
		elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown")){
			$ip = $_SERVER['REMOTE_ADDR'];
		} else {
			$ip = "Unknown";
		}
		return $ip;
	}

	//Lista la relacion de menus de las aplicaciones
	public function listarMenu($aplicacion)
	{
		$where = array("aplicacion"=>$aplicacion, "estado"=>"1");
		
		$query = $this->db
                ->select("nombre, enlace, imagen")
				->where($where)
				->get('menufrontend');
				return $query->result();
	}

	//Lista una diresa
	public function buscarDiresa($id)
	{
		$where = array("codigo"=>$id);
		
		$query = $this->db
                ->select("codigo, nombre")
				->from('diresas')
				->where($where)
				->get();
				return $query->result();
	}

	//Lista la relación de diresas
	public function buscarDiresas()
	{
		$query = $this->db
                ->select("codigo, nombre")
				->get('diresas');
				return $query->result();
	}

	//Selecciona las redes de acuerdo a su nivel
	public function buscarRedes($id)
	{
		$where = array("subregion"=>$id);
		
		$query = $this->db
                ->select("codigo, nombre")
                ->from("redes")
				->where($where)
				->order_by("nombre")
				->get();
				return $query->result();
	}

	//Selecciona las microredes de acuerdo a su nivel
	public function buscarMicroredes($id, $id1)
	{
		$where = array("subregion"=>$id,"red"=>$id1);
		
		$query = $this->db
                ->select("codigo, nombre")
                ->from("microred")
				->where($where)
				->order_by("nombre")
				->get();
				return $query->result();
	}

	//Selecciona los establecimientos de acuerdo a su nivel
	public function buscarEstablec($id, $id1, $id2)
	{
		$where = array("subregion"=>$id, "red"=>$id1, "microred"=>$id2);
		
		$query = $this->db
                ->select("cod_est, raz_soc")
                ->from("renace")
				->where($where)
				->order_by("raz_soc")
				->get();
				return $query->result();
	}
	
	//Importante: Verifica el estado del aplicativo
	public function estadoAplicativo($id)
	{
		$where = array("aplicacion"=>$id);
		
		$query = $this->db
                ->select("estado")
                ->from("aplicaciones")
				->where($where)
				->get();
				return $query->result();
	}

	//Importante: Cambia la clave del usuario
	public function cambiarClave($data)
	{
		$where = array("usuario"=>$data["usuario"]);
		
		$this->db->where($where);
		$this->db->update('usuarios_frontend',$data);
		return true;
	}

	//Importante: Darse de baja
	public function Baja($data)
	{
		$where = array("usuario"=>$data["usuario"]);
		
		$this->db->where($where);
		$this->db->update('usuarios_frontend',$data);
		return true;
	}

	//Importante: Cambia la clave del usuario del backend
	public function cambiarClaveBackend($data)
	{
		$where = array("usuario"=>$data["usuario"]);
		
		$this->db->where($where);
		$this->db->update('usuarios_backend',$data);
		return true;
	}

	//Lista la relación de niveles de los usuarios
	public function buscarNivel($id=null)
	{
		$nivel = array('nivel'=>$id);
		
		$query = $this->db
                ->select("nivel, nombre")
				->from('niveles')
				->where($nivel)
				->get();
				return $query->row();
	}

	//Devielve usuario y clave para el olvido
	public function olvido($id=null)
	{
		$email = array('email'=>$id);
		
		$query = $this->db
                ->select("usuario, codigo, nombres")
				->from('usuarios_frontend')
				->where($email)
				->get();
				return $query->row();
	}

	function daysDifference($fecha1,$fecha2){
		$dias	= (strtotime($fecha1)-strtotime($fecha2))/86400;
		$dias 	= abs($dias); $dias = floor($dias);		
		
		return $dias;
	}
}