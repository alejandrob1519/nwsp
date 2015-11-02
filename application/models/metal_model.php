<?php
class metal_model extends CI_Model{
    function __construct() {
        parent::__construct();
    }
	//Registra ficha de Metales pesados
	public function insertarMetales($datos = array())
	{
		$this->db->insert("metales", $datos);
		return true;
	}

	//Ejecuta la modificación de la ficha 
	public function ejecutarModificarMetales($modificar=array(), $id)
	{
		$where = array("registroId"=>$id);

		$this->db->where($where);
		$this->db->update('metales',$modificar);
		return true;
	}
	//Busca una determinada ficha
	public function buscarMetales($id)
	{
		$where = array("registroId"=>$id);
		
		$query = $this->db
                ->select("*")
                ->from("metales")
				->where($where)
				->get();
				return $query->row();
	}
	//Busca por DNI
	public function buscarDNI($id)
	{
		$where = array("dni"=>$id);
		$where1 = array("dni <>"=>"");
		
		$query = $this->db
				->where($where)
				->where($where1)
				->get("metales");
				return $query->result();
	}

	//Selecciona un número de ficha de Metales Pesados
	public function numeroMetales($id)
	{
		$anio = date("Y");
		
		$where = array("eess"=>$id, "anio"=>$anio);
		
		$query = $this->db
				->select("numero")
                ->from("numerofichasMP")
				->where($where)
				->get();
				return $query->result();
	}

	//Registra ficha de Metales
	public function insertarNumeroMetales($dato1, $dato2, $dato3)
	{
		$datos = array("eess"=>$dato1, "anio"=>$dato2, "numero"=>$dato3);
		
		$this->db
		->insert("numerofichasMP", $datos);
		return true;
	}

	//Ejecuta la modificación de la ficha 
	public function actualizarNumeroMetales($dato1, $dato2, $dato3)
	{
		$datos = array("eess"=>$dato1, "anio"=>$dato2);
		$dato = array("numero"=>$dato3);
		
		$this->db->where($datos);
		$this->db->update('numerofichasMP',$dato);
		return true;
	}
}
?>