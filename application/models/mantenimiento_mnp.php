<?php
class mantenimiento_mnp extends CI_Model{
    function __construct() {
        parent::__construct();
    }
	//Busca Registro
	public function buscarmte($anio, $apli)
	{
		$where = array("anio"=>$anio, "aplicativo"=>$apli);
		
		$query = $this->db
                 ->from("cierreapli")
				->where($where)
				->get();
				return $query->row();
	}
    
	//elimina mnp
    public function eliminarMnp($id)
    {
        $where = array("registroId"=>$id);

        $this->db->where($where);
        $this->db->delete('mnp');

        return true;
    }
}
?>