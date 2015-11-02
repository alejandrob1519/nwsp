<?php
class calidad_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
	
	//Genera el proceso de cobertura de los establecimientos de salud, por niveles
	
	public function diagnosticos() 
    {
        $query = $this->db->query("CALL proc_individual_calidad()");
		
		return $query->result();
	}
	
	public function duplicados() 
    {
        $query = $this->db->query("CALL proc_individual_duplicados()");
		
		return $query->result();
	}
	
	public function inconsistencias()
	{
        $query = $this->db->query("CALL proc_individual_inconsistencias()");
		
		return $query->result();
	}
	
	public function establecimientos()
	{
        $query = $this->db->query("CALL proc_individual_establecimientos()");
		
		return $query->result();
	}

	public function nombresDuplicados()
	{
		ini_set('memory_limit', '1024M');
		$query = $this->db->query("CALL proc_individual_nombresDuplicados()");
		
		return $query->result();
	}

	public function edasDuplicados()
	{
		ini_set('memory_limit', '1024M');
		$query = $this->db->query("CALL proc_edas_duplicados()");
		
		return $query->result();
	}

	public function edasSemanas()
	{
		$query = $this->db->query("select * from edas where semana > week(curdate())-2");
		
		return $query->result();
	}

	public function edasEstablecimientos()
	{
        $query = $this->db->query("CALL proc_edas_establecimientos()");
		
		return $query->result();
	}

	public function edasDefunciones()
	{
        $query = $this->db->query("CALL proc_edas_defunciones()");
		
		return $query->result();
	}

	public function edasCampos()
	{
        $query = $this->db->query("CALL proc_edas_campos()");
		
		return $query->result();
	}

	public function eliminaIndividual($id)
	{
		$this->db->delete("individual", $id);
		return true;
	}

	public function eliminaEdas($id)
	{
		$this->db->delete("edas", $id);
		return true;
	}

	public function eliminaIras($id)
	{
		$this->db->delete("iras", $id);
		return true;
	}

	public function irasDuplicados()
	{
		ini_set('memory_limit', '1024M');
		$query = $this->db->query("CALL proc_iras_duplicados()");
		
		return $query->result();
	}

	public function irasSemanas()
	{
		$query = $this->db->query("select * from iras where semana > week(curdate())-2");
		
		return $query->result();
	}

	public function irasEstablecimientos()
	{
        $query = $this->db->query("CALL proc_iras_establecimientos()");
		
		return $query->result();
	}

	public function irasDefunciones()
	{
        $query = $this->db->query("CALL proc_iras_defunciones()");
		
		return $query->result();
	}

	public function irasCampos()
	{
        $query = $this->db->query("CALL proc_iras_campos()");
		
		return $query->result();
	}
}
?>