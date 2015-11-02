<?php
class fechas_model extends CI_Model{
    function __construct() {
        parent::__construct();
    }
    	
	public function arreglarFechas($param1){
		$fecha1=substr($param1,0,2);
		$fecha2=substr($param1,3,2);
		$fecha3=substr($param1,6,4);
		$fecha=$fecha3."-".$fecha2."-".$fecha1;
		return $fecha;
	}
	
	public function modificarFechas($param1){
		$fecha1=substr($param1,0,4);
		$fecha2=substr($param1,5,2);
		$fecha3=substr($param1,8,2);
		$fecha=$fecha3."-".$fecha2."-".$fecha1;
		return $fecha;
	}
}
?>