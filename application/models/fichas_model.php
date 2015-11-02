<?php
class fichas_model extends CI_Model{
    function __construct() {
        parent::__construct();
    }
    	
	//Selecciona los niveles de acceso de los usuarios
	public function buscarAplicaciones()
	{
		$query = $this->db
                ->select("aplicacion, nombre, estado")
                ->from("aplicaciones")
				->get();
				return $query->result();
	}

	//Lista los accesos a las aplicaciones
	public function accesoAplicaciones($id=null)
	{
		$sql = "select x.aplicacion, x.nombre, y.usuario, x.estado
				from
				aplicaciones x
				left join
				(select a.usuario, b.aplicacion
				from tablaccesos a
				left join
				aplicaciones b
				on a.aplicacion = b.aplicacion
				where a.estado = '1' and a.usuario = '".$id."' and b.estado = '1'
				order by b.aplicacion) y
				on x.aplicacion = y.aplicacion
				";
				
		$query = $this->db
                ->query($sql);
				return $query->result();
	}

	//Selecciona los niveles de acceso de los usuarios
	public function listarAplicaciones()
	{
		$where = array("estado"=>'1');
		
		$query = $this->db
                ->select("aplicacion, nombre, enlace, estado")
                ->from("aplicaciones")
				->where($where)
				->order_by('aplicacion, nombre', 'asc')
				->get();
				return $query->result();
	}

	//Lista usuarios del frontend
	public function buscarUsuarios()
	{
		$where = array("estado"=>'1');
		
		$query = $this->db
                ->select("usuario, nombres")
                ->from("usuarios_frontend")
				->where($where)
				->order_by('nombres', 'asc')
				->get();
				return $query->result();
	}

	//Lista la relación de diresas
	public function buscarDiresas()
	{
		$this->db = $this->load->database('db', TRUE);
		
		$query = $this->db
                ->select("codigo, nombre")
				->get('diresas');
				return $query->result();
	}

	//Selecciona las redes de acuerdo a su nivel
	public function buscarRedes($id)
	{
		$this->db = $this->load->database('db', TRUE);
		
		$where = array("subregion"=>$id, "estado"=>'1');
		
		$query = $this->db
                ->select("codigo, nombre")
                ->from("redes")
				->where($where)
				->get();
				return $query->result();
	}

	//Selecciona las microredes de acuerdo a su nivel
	public function buscarMicroredes($id, $id1)
	{
		$this->db = $this->load->database('db', TRUE);
		
		$where = array("subregion"=>$id,"red"=>$id1, "estado"=>'1');
		
		$query = $this->db
                ->select("codigo, nombre")
                ->from("microred")
				->where($where)
				->get();
				return $query->result();
	}

	//Selecciona los establecimientos de acuerdo a su nivel
	public function buscarEstablec($id, $id1, $id2)
	{
		$this->db = $this->load->database('db', TRUE);
		
		$where = array("subregion"=>$id, "red"=>$id1, "microred"=>$id2, "estado"=>'1');
		
		$query = $this->db
                ->select("cod_est, raz_soc")
                ->from("renace")
				->where($where)
				->get();
				return $query->result();
	}

	//Selecciona los establecimientos 
	public function mostrarEstablecimiento()
	{
		$query = $this->db
                ->select("cod_est, raz_soc")
                ->from("renace")
				->get();
				return $query->result();
	}

	//Selecciona los establecimientos de acuerdo a su nivel
	public function buscarEstCat($id)
	{
		$where = array("cod_est"=>$id, "estado"=>'1');
		
		$query = $this->db
                ->select("cod_est, raz_soc, categoria")
                ->from("renace")
				->where($where)
				->get();
				return $query->result();
	}

	//Selecciona la categoria del establecimiento de acuerdo a su nivel
	public function buscarCategoria($id)
	{
		$this->db = $this->load->database('db', TRUE);
		
		$where = array("cod_est"=>$id);
		
		$query = $this->db
                ->select("categoria")
                ->from("renace")
				->where($where)
				->get();
				return $query->row();
	}


	//Lista la relación de paises
	public function buscarPaises()
	{
		$this->db = $this->load->database('db', TRUE);
		
		$query = $this->db
                ->select("codigo, nombre")
				->get('paises');
				return $query->result();
	}

	//Lista la relación de departamentos
	public function buscarDepartamentos()
	{
		$this->db = $this->load->database('db', TRUE);
		
		$query = $this->db
                ->select("ubigeo, nombre")
				->get('departamento');
				return $query->result();
	}

	//Selecciona las provincias
	public function buscarProvincias($id)
	{
		$this->db = $this->load->database('db', TRUE);
		
		$where = array("departamento"=>$id);
		
		$query = $this->db
                ->select("ubigeo, nombre")
                ->from("provincia")
				->where($where)
				->get();
				return $query->result();
	}

	//Selecciona los distritos
	public function buscarDistritos($id1, $id2)
	{
		$where = array("departamento"=>$id1, "provinci"=>$id2);
		
		$this->db = $this->load->database('db', TRUE);
		
		$query = $this->db
                ->select("ubigeo, nombre")
                ->from("distrito")
				->where($where)
				->get();
				return $query->result();
	}

	//Registra ficha de neumonias
	public function insertarNeumonias($datos = array())
	{
		$this->db->insert("neumonias", $datos);
		return true;
	}

	//Ejecuta la modificación de la ficha neumonias
	public function ejecutarModificarNeumonias($modificar=array(), $id)
	{
		$where = array("registroId"=>$id);

		$this->db->where($where);
		$this->db->update('neumonias',$modificar);
		return true;
	}

	//Busca una determinada ficha
	public function buscarNeumonias($id)
	{
		$where = array("registroId"=>$id);
		
		$query = $this->db
                ->select("*")
                ->from("neumonias")
				->where($where)
				->get();
				return $query->row();
	}

	//Registra ficha de chikungunya
	public function insertarChikungunya($datos = array())
	{
		$this->db->insert("chikungunya", $datos);
		return true;
	}

	//Busca una determinada ficha
	public function buscarChikungunya($id)
	{
		$where = array("registroId"=>$id);
		
		$query = $this->db
                ->select("*")
                ->from("chikungunya")
				->where($where)
				->get();
				return $query->row();
	}

	//Busca una determinada ficha
	public function buscarFicChikungunya($id)
	{
		$where = array("dni"=>$id);
		
		$query = $this->db
                ->select("*")
                ->from("chikungunya")
				->where($where)
				->get();
				return $query->num_rows();
	}

	//Busca una determinada ficha
	public function existeChikungunya($id)
	{
		$where = array("notificacion"=>$id);
		
		$query = $this->db
				->where($where)
				->get("chikungunya");
				return $query->num_rows();
	}

	//Ejecuta la modificación del registro del usuario
	public function modificarChikungunya($modificar=array(), $id)
	{
		$where = array("registroId"=>$id);

		$this->db->where($where);
		$this->db->update('chikungunya',$modificar);
		return true;
	}

	//Ejecuta la modificación de la ficha chikungunya
	public function ejecutarModificarChikungunya($modificar=array(), $id)
	{
		$where = array("registroId"=>$id);

		$this->db->where($where);
		$this->db->update('chikungunya',$modificar);
		return true;
	}

	//Lista la base de chikungunya
	public function listarChikungunya($parametro)
	{
		switch($parametro["nivel"])
		{
			case '8':
			$where = array("establecimiento"=>$parametro["establecimiento"]);
			
			$query = $this->db
				->where($where)
				->get("chikungunya");
				return $query->result();
			break;
			case '7':
			$where = array("diresa"=>$parametro["diresa"], "red"=>$parametro["red"], "microred"=>$parametro["microred"]);
			
			$query = $this->db
				->where($where)
				->get("chikungunya");
				return $query->result();
			break;
			case '6':
			$where = array("diresa"=>$parametro["diresa"], "red"=>$parametro["red"]);
			
			$query = $this->db
				->where($where)
				->get("chikungunya");
				return $query->result();
			break;
			case '5':
			$where = array("diresa"=>$parametro["diresa"]);
			
			$query = $this->db
				->where($where)
				->get("chikungunya");
				return $query->result();
			break;
			default:
			$query = $this->db
				->get("chikungunya");
				return $query->result();
			break;
		}
	}

	//Busca caso de chikungunya
	public function mostrarChikungunya($id)
	{
		$where = array("individual.registroId"=>$id);
		
		$query = $this->db
		->select("individual.*, renace.raz_soc, renace.categoria, diresas.nombre as diresa, 
				 redes.nombre as redes, microred.nombre as microredes")
		->from("individual")
		->join('renace', 'individual.e_salud=renace.cod_est', 'left')
		->join('diresas', 'individual.sub_reg_nt=diresas.codigo', 'left')
		->join('redes', 'concat(individual.sub_reg_nt,individual.red)=concat(redes.subregion,redes.codigo)', 'left')
		->join('microred', 'concat(individual.sub_reg_nt,individual.red,individual.microred)=concat(microred.subregion,microred.red,microred.codigo)', 'left')
		->where($where)
		->get();
		return $query->row();
	}

	public function mostrarIndividual($id)
	{
		$where = array("individual.registroId"=>$id);
		
		$query = $this->db
		->select("individual.*, renace.raz_soc, renace.categoria, diresas.nombre as diresa, 
				 redes.nombre as redes, microred.nombre as microredes")
		->from("individual")
		->join('renace', 'individual.e_salud=renace.cod_est', 'left')
		->join('diresas', 'individual.sub_reg_nt=diresas.codigo', 'left')
		->join('redes', 'concat(individual.sub_reg_nt,individual.red)=concat(redes.subregion,redes.codigo)', 'left')
		->join('microred', 'concat(individual.sub_reg_nt,individual.red,individual.microred)=concat(microred.subregion,microred.red,microred.codigo)', 'left')
		->where($where)
		->get();
		return $query->row();
	}

	//lista los casos de sífilis materna y congénita
	public function listarSifilis($id)
	{
		$where = array("dni"=>$id);
		$where1 = array("diagnostic"=>"A50");
		$where2 = array("diagnostic"=>"O98.1");
		
		//$this->db2 = $this->load->database('db2', TRUE);
		
		$query = $this->db
		->select("*")
		->from("individual")
		->where($where)
		->where($where1)
		->or_where($where2)
		->order_by("ano desc, apepat asc, apemat asc, nombres asc")
		->get();
		return $query->result();
	}

	//lista los casos de sífilis materna y congénita
	public function listarChikun($id)
	{
		$where = array("dni"=>$id);
		$where1 = array("diagnostic"=>"A92.0");
		$where2 = array("diagnostic"=>"A92.5");
		
		$query = $this->db
		->select("*")
		->from("individual")
		->where($where)
		->where($where1)
		->or_where($where2)
		->order_by("ano desc, apepat asc, apemat asc, nombres asc")
		->get();
		return $query->result();
	}

	//Busca caso de sífilis materna y/o congénita
	public function mostrarSifilis($id)
	{
		$where = array("individual.registroId"=>$id);
		
		$query = $this->db
		->select("*, renace.raz_soc, renace.categoria, diresas.nombre as diresa, 
				 redes.nombre as redes, microred.nombre as microredes")
		->from("individual")
		->join('renace', 'individual.e_salud=renace.cod_est', 'left')
		->join('diresas', 'individual.sub_reg_nt=diresas.codigo', 'left')
		->join('redes', 'concat(individual.sub_reg_nt,individual.red)=concat(redes.subregion,redes.codigo)', 'left')
		->join('microred', 'concat(individual.sub_reg_nt,individual.red,individual.microred)=concat(microred.subregion,microred.red,microred.codigo)', 'left')
		->where($where)
		->get();
		return $query->row();
	}

	//Registra ficha de sifilis
	public function insertarSifilis($datos = array())
	{
		$this->db->insert("sifilis", $datos);
		return true;
	}

	//Registra ficha de sifilis materna
	public function insertarSifilisMaterna($datos = array())
	{
		$this->db->insert("sifilis_materna", $datos);
		return true;
	}

	//Registra ficha de sifilis congenita
	public function insertarSifilisCongenita($datos = array())
	{
		$this->db->insert("sifilis_congenita", $datos);
		return true;
	}

	//Busca una determinada ficha de sifilis
	public function buscarSifilis($id)
	{
		$where = array("sifilis.registroId"=>$id);
		
		$query = $this->db
		->select("sifilis.*, renace.raz_soc, renace.categoria, diresas.nombre as diresas, 
				 redes.nombre as redes, microred.nombre as microredes")
		->from("sifilis")
		->where($where)
		->join('renace', 'sifilis.establecimiento=renace.cod_est', 'left')
		->join('diresas', 'sifilis.diresa=diresas.codigo', 'left')
		->join('redes', 'concat(sifilis.diresa,sifilis.red)=concat(redes.subregion,redes.codigo)', 'left')
		->join('microred', 'concat(sifilis.diresa,sifilis.red,sifilis.microred)=concat(microred.subregion,microred.red,microred.codigo)', 'left')
		->get();
		return $query->row();
	}

	//Busca una determinada ficha de sifilis materna
	public function buscarSifilisMaterna($id)
	{
		$where = array("codigo"=>$id);
		
		$query = $this->db
                ->select("*")
                ->from("sifilis_materna")
				->where($where)
				->get();
				return $query->row();
	}

	//Busca una determinada ficha de sifilis congénita
	public function buscarSifilisCongenita($id)
	{
		$where = array("codigo"=>$id);
		
		$query = $this->db
                ->select("*")
                ->from("sifilis_congenita")
				->where($where)
				->get();
				return $query->row();
	}

	//Ejecuta la modificación del registro de sifilis
	public function modificarSifilis($modificar=array(), $id)
	{
		$where = array("registroId"=>$id);

		$this->db->where($where);
		$this->db->update('sifilis',$modificar);
		return true;
	}

	//Ejecuta la modificación del registro de sifilis Materna
	public function modificarSifilisMaterna($modificar=array(), $id)
	{
		$where = array("codigo"=>$id);

		$this->db->where($where);
		$this->db->update('sifilis_materna',$modificar);
		return true;
	}

	//Ejecuta la modificación del registro de sifilis congenita
	public function modificarSifilisCongenita($modificar=array(), $id)
	{
		$where = array("codigo"=>$id);

		$this->db->where($where);
		$this->db->update('sifilis_congenita',$modificar);
		return true;
	}

	//Ejecuta la modificación de la ficha sifilis
	public function ejecutarModificarSifilis($modificar=array(), $id)
	{
		$where = array("registroId"=>$id);

		$this->db->where($where);
		$this->db->update('sifilis',$modificar);
		return true;
	}

	//Selecciona los establecimientos 
	public function mostrarEstablec($id)
	{
		$where = array("cod_est"=>$id);
		
		$query = $this->db
                ->select("*")
                ->from("renace")
				->where($where)
				->get();
				return $query->row();
	}

	//elimina sifilis
	public function eliminarSifilis($id1, $id2)
	{
		$where = array("registroId"=>$id1);

		$this->db->where($where);
		$this->db->delete('sifilis');

		$where = array("codigo"=>$id2);

		$this->db->where($where);
		$this->db->delete('sifilis_materna');

		$this->db->where($where);
		$this->db->delete('sifilis_congenita');
		return true;
	}

	//Selecciona la base de datos para backup
	public function mostrarTablas()
	{
		$query = $this->db
				->query("SHOW TABLES FROM maestro");
				return $query->result();
	}

	//lista las tablas para el backup
	public function listarTablas($id)
	{
		$query = $this->db
                ->select("*")
                ->from($id)
				->get();
				return $query->result();
	}

	//lista las tablas para el backup
	public function numerarLineas($id)
	{
		$query = $this->db
                ->select("*")
                ->from($id)
				->get();
				return $query->num_rows();
	}

	//lista las tablas para el backup
	public function numerarColumnas($id)
	{
		$query = $this->db
                ->select("*")
                ->from($id)
				->get();
				return $query->num_fields();
	}

	//Crea la tabla para el backup
	public function crearTablas($id)
	{
		$query = $this->db
				->query("SHOW CREATE TABLE ".$id);
				return $query->row();
	}

	//Muestra el listado de diagnósticos
	public function mostrarDiagnostico()
	{
		$query = $this->db
				->select('cie_10, diagno')
				->order_by('diagno', 'ASC')
				->get('diagno');
				return $query->result();
	}

	//Registra ficha de Plaguicidas
	public function insertarPlaguicidas($datos = array())
	{
		$this->db->insert("plaguicidas", $datos);
		return true;
	}

	//Registra ficha de brotes
	public function insertarBrote($datos = array())
	{
		$this->db->insert("bplaguicidas", $datos);
		return true;
	}

	public function mostrarBrote($id)
	{
		$where = array("registroId"=>$id);
		
		$query = $this->db
		->from("bplaguicidas")
		->where($where)
		->get();
		return $query->row();
	}

	public function existeFicha($id){
		$query = $this->db
                ->from('plaguicidas')
				->get();
				return $query->num_rows();
	}

	//Busca una determinada ficha de plaguicidas
	public function buscarPlaguicidas($id)
	{
		$where = array("registroid"=>$id);
		
		$query = $this->db
                ->select("*")
                ->from("plaguicidas")
				->where($where)
				->get();
				return $query->row();
	}

	//Ejecuta la modificación del registro del usuario
	public function modificarPlaguicidas($modificar=array(), $id)
	{
		$where = array("registroid"=>$id);

		$this->db->where($where);
		$this->db->update('plaguicidas',$modificar);
		return true;
	}

	//Ejecuta la modificación de la ficha de brotes
	public function modificarBrotes($modificar=array(), $id)
	{
		$where = array("registroid"=>$id);

		$this->db->where($where);
		$this->db->update('bplaguicidas',$modificar);
		return true;
	}

	public function mostrarInd($id)
	{
		$where = array("clave"=>$id);
		
		$query = $this->db
		->select("*, renace.raz_soc, renace.categoria, diresas.nombre as diresa, 
				 redes.nombre as redes, microred.nombre as microredes")
		->from("individual")
		->join('renace', 'individual.e_salud=renace.cod_est', 'left')
		->join('diresas', 'individual.sub_reg_nt=diresas.codigo', 'left')
		->join('redes', 'concat(individual.sub_reg_nt,individual.red)=concat(redes.subregion,redes.codigo)', 'left')
		->join('microred', 'concat(individual.sub_reg_nt,individual.red,individual.microred)=concat(microred.subregion,microred.red,microred.codigo)', 'left')
		->where($where)
		->get();
		return $query->row();
	}

	public function mostrarIndAnt($id)
	{
		$where = array("clave"=>$id);
		
		$query = $this->db
		->select("*, renace.raz_soc, renace.categoria, diresas.nombre as diresa, 
				 redes.nombre as redes, microred.nombre as microredes")
		->from("individual_ant")
		->join('renace', 'individual_ant.e_salud=renace.cod_est', 'left')
		->join('diresas', 'individual_ant.sub_reg_nt=diresas.codigo', 'left')
		->join('redes', 'concat(individual_ant.sub_reg_nt,individual_ant.red)=concat(redes.subregion,redes.codigo)', 'left')
		->join('microred', 'concat(individual_ant.sub_reg_nt,individual_ant.red,individual_ant.microred)=concat(microred.subregion,microred.red,microred.codigo)', 'left')
		->where($where)
		->get();
		return $query->row();
	}
	
  //Registra ficha de Muerte Perinatal
	public function insertarMnp($datos = array())
	{
		$this->db->insert("mnp", $datos);
		return true;
	}

	//Ejecuta la modificación de la ficha de Muerte Perinatal
	public function ejecutarModificarMnp($modificar=array(), $id)
	{
		$where = array("registroId"=>$id);

		$this->db->where($where);
		$this->db->update('mnp',$modificar);
		return true;
	}

	//Busca ficha de Muerte Perinatal
	public function buscarMnp($id)
	{
		$where = array("registroId"=>$id);
		
		$query = $this->db
                 ->from("mnp")
				->where($where)
				->get();
				return $query->row();
	}
}
?>