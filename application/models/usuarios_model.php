<?php
class usuarios_model extends CI_Model{
    function __construct() {
        parent::__construct();
    }
    	
	//Registra nuevos usuarios
	public function insertarUsuarios($datos = array())
	{
		$this->db->insert("usuarios_backend", $datos);
		return true;
	}

	//Registra nuevos usuarios operadores
	public function insertarOperador($datos = array())
	{
		$this->db->insert("usuarios_frontend", $datos);
		return true;
	}

	//Busca un determinado usuario para modificarlo
	public function buscarUsuarios($id)
	{
		$where = array("registroId"=>$id);
		
		$query = $this->db
                ->select("registroId, usuario, contrasena, dni, paterno, materno, nombres, correo, telefono, mobil, nivel, estado, autoriza, fecha_aut, codigo")
                ->from("usuarios_backend")
				->where($where)
				->get();
				return $query->row();
	}

	//Busca un determinado usuario para modificarlo
	public function buscarOperadores($id)
	{
		$where = array("registroId"=>$id);
		
		$query = $this->db
                ->from("usuarios_frontend")
				->where($where)
				->get();
				return $query->row();
	}

	//Verifica si el usuario ya existe
	public function buscarOperador($id)
	{
		$where = array("dni"=>$id);
		
		$query = $this->db
                ->from("usuarios_frontend")
				->where($where)
				->get();
				return $query->row();
	}

	//Selecciona los niveles de acceso de los usuarios
	public function buscarNiveles()
	{
		$where = array("estado"=>'1');
		
		$query = $this->db
                ->select("nivel, nombre, estado")
                ->from("niveles")
				->where($where)
				->get();
				return $query->result();
	}

	//Ejecuta la modificación del registro del usuario administrador
	public function ejecutarModificar($modificar=array(), $id)
	{
		$where = array("registroId"=>$id);

		$this->db->where($where);
		$this->db->update('usuarios_backend',$modificar);
		return true;
	}

	//Ejecuta la modificación del registro del usuario operador
	public function ejecutarModificarOperador($modificar=array(), $id)
	{
		$where = array("registroId"=>$id);

		$this->db->where($where);
		$this->db->update('usuarios_frontend',$modificar);
		return true;
	}

	//Busca usuarios administradores
	public function buscarAdministrador($id)
	{
		$where = array("usuario"=>$id);
		
		$query = $this->db
                ->select("usuario, nombres, correo")
                ->from("usuarios_backend")
				->where($where)
				->get();
				return $query->result();
	}

	//Lista la relación de equipos temáticos
	public function listarEquipos()
	{
		$query = $this->db
                ->select("codigo, denominacion")
				->get('tematicos');
				return $query->result();
	}

	//Lista usuarios caducados
	public function listarCaducados()
	{
		$where = array("caduca <=" => date("Y-m-d"));
		
		$query = $this->db
				->where($where)
				->get('usuarios_frontend');
				return $query->result();
	}

	//Actualiza fecha de caducidad
	public function actualizarCaducidad($id=null, $registro=null)
	{
		$fecha = $this->fechas_model->modificarFechas($registro);
		$caducidad = $this->dateadd($fecha,0,0,1,0,0,0);
		$cambia = $this->fechas_model->arreglarFechas($caducidad);
		
		$where = array("registroId"=>$id);
		$modificar = array("caduca" => $cambia);
		
		$this->db->where($where);
		$this->db->update('usuarios_frontend',$modificar);
		return true;
	}

	function dateadd($date, $dd=0, $mm=0, $yy=0, $hh=0, $mn=0, $ss=0){
		$date_r = getdate(strtotime($date));
		$date_result = date("d-m-Y", mktime(($date_r["hours"]+$hh),($date_r["minutes"]+$mn),($date_r["seconds"]+$ss),($date_r["mon"]+$mm),($date_r["mday"]+$dd),($date_r["year"]+$yy)));
		return $date_result;
	}

	//Registra el codigo de seguridad del cambio de contraseña
	public function registrarSeguridad($dato1,$dato2)
	{
		$registrar = array("usuario" => $dato1, "codigo" => $dato2);
		$this->db->insert("seguridad", $registrar);
		return true;
	}

	public function buscarSeguridad($id)
	{
		$where = array("usuario"=>$id);
		
		$query = $this->db
                ->select("usuario, codigo")
                ->from("seguridad")
				->where($where)
				->get();
				return $query->result();
	}

	public function modificarSeguridad($id,$codigo)
	{
		$modificar = array("codigo" => $codigo);
		
		$where = array("usuario"=>$id);

		$this->db->where($where);
		$this->db->update('seguridad',$modificar);
		return true;
	}

	public function eliminarSeguridad($id)
	{
		$where = array("usuario"=>$id);

		$this->db->where($where);
		$this->db->delete('seguridad');
		return true;
	}

	public function tablaAccesos($id)
	{
		$where = array("usuario"=>$id);
		
		$query = $this->db
                ->select("aplicacion, usuario, estado")
                ->from("tablaccesos")
				->where($where)
				->get();
				return $query->result();
	}
	
	public function borrarAcceso($id){
		$where = array("usuario"=>$id);

		$this->db->where($where);
		$this->db->delete('tablaccesos');
	}

	public function guardarAcceso($datos = array())
	{
		$this->db->insert("tablaccesos", $datos);
		return true;
	}
}
?>