<?php
class mantenimiento_model extends CI_Model{
    function __construct() {
        parent::__construct();
    }
    	
	//Lista la relación de diresas
	public function buscarDiresas()
	{
		$query = $this->db
                ->select("codigo, nombre")
				->order_by('nombre')
				->get('diresas');
				return $query->result();
	}

	//Selecciona las redes de acuerdo a su nivel
	public function buscarRedes($id)
	{
		$where = array("subregion"=>$id, 'estado' => '1');
		
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
		$where = array("subregion"=>$id,"red"=>$id1, 'estado' => '1');
		
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
		$where = array("subregion"=>$id, "red"=>$id1, "microred"=>$id2, 'estado' => '1');
		
		$query = $this->db
                ->select("cod_est, raz_soc")
                ->from("renace")
				->where($where)
				->get();
				return $query->result();
	}

	//lista los establecimientos de acuerdo a su nivel
	public function listarEstablecimiento()
	{
		$query = $this->db
                ->select("cod_est, raz_soc")
                ->from("renace")
				->get();
				return $query->result();
	}

	//Selecciona la categoria del establecimiento de acuerdo a su nivel
	public function buscarCategoria($id)
	{
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
		$query = $this->db
                ->select("codigo, nombre")
				->get('paises');
				return $query->result();
	}

	//Lista la relación de departamentos
	public function buscarDepartamentos()
	{
		$query = $this->db
                ->select("ubigeo, nombre")
				->get('departamento');
				return $query->result();
	}

	//Selecciona las provincias
	public function buscarProvincias($id)
	{
		$where = array("departamento"=>$id);
		
		$query = $this->db
                ->select("ubigeo, nombre")
                ->from("provincia")
				->where($where)
				->get();
				return $query->result();
	}

	//Selecciona los distritos
	public function buscarDistritos($id1)
	{
		$where = array("provinci"=>$id1);
		
		$query = $this->db
                ->select("ubigeo, nombre")
                ->from("distrito")
				->where($where)
				->get();
				return $query->result();
	}

	//Muestra el listado de subetnias
	public function buscarSubetnias($id)
	{
		$where = array("tipo"=>$id);
		
		$query = $this->db
                ->select("registroId, nombre")
                ->from("etniaproc")
				->where($where)
				->get();
				return $query->result();
	}

	//Selecciona localidades
	public function buscarLocalidades($id1)
	{
		$where = array("ubigeo"=>$id1);
		
		$query = $this->db
                ->select("codloc, nombre")
                ->from("localidad")
				->where($where)
				->get();
				return $query->result();
	}

	//Selecciona las redes
	public function mostrarRedes()
	{
		$query = $this->db
                ->select("codigo, nombre, estado")
                ->from("redes")
				->get();
				return $query->result();
	}

	//Selecciona la Microred
	public function mostrarMicrored($id)
	{
		$where = array('registroId' => $id);
		
		$query = $this->db
                ->select("*")
                ->from("microred")
				->where($where)
				->get();
				return $query->row();
	}

	//Selecciona el establecimiento
	public function mostrarEstablecimiento($id)
	{
		$where = array('registroId' => $id);
		
		$query = $this->db
                ->select("*")
                ->from("renace")
				->where($where)
				->get();
				return $query->row();
	}

	//Inserta las microredes
	public function insertarMicrored($datos = array())
	{
		$this->db->insert("microred", $datos);
		return true;
	}
	
	//Ejecuta la modificación del registro de la microred
	public function ejecutarModificar($modificar=array(), $id)
	{
		$where = array("registroId"=>$id);

		$this->db->where($where);
		$this->db->update('microred',$modificar);
		return true;
	}

	//Inserta establecimientos
	public function insertarEstablecimiento($datos = array())
	{
		$this->db->insert("renace", $datos);
		return true;
	}

	//Ejecuta la modificación del registro del establecimiento
	public function ejecutarModificarEstablecimiento($modificar=array(), $id)
	{
		$where = array("registroId"=>$id);

		$this->db->where($where);
		$this->db->update('renace',$modificar);
		return true;
	}

	//Muestra los departamentos del Perú
	public function mostrarDepartamentos()
	{
		$query = $this->db
                ->select("ubigeo, nombre")
                ->from("departamento")
				->get();
				return $query->result();
	}

	//Muestra el listado del menú principal del sistema
	public function mostrarMenu()
	{
		$where = array('estado'=>'1');
		
		$query = $this->db
				->from('menu_frontend')
				->where($where)
				->order_by('orden', 'ASC')
				->get();
				return $query->result();
	}

	//Muestra el listado del menú principal del sistema
	public function mostrarSubMenu($id)
	{
		$where = array('menu'=>$id, 'estado'=>'1');
		
		$query = $this->db
				->from('submenu_frontend')
				->where($where)
				->order_by('orden', 'ASC')
				->get();
				return $query->result();
	}

	//Muestra la barra de accesos del menú principal del sistema
	public function mostrarBarra()
	{
		$where = array('estado'=>'1');
		
		$query = $this->db
				->from('barra_frontend')
				->where($where)
				->order_by('orden', 'ASC')
				->get();
				return $query->result();
	}

	//Muestra el listado del menú principal del sistema
	public function mostrarEtnias()
	{
		$query = $this->db
				->get('etnias');
				return $query->result();
	}

	//Selecciona la base de datos para backup
	public function mostrarTablas()
	{
		$query = $this->db
				->query("SHOW TABLES FROM notiweb");
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

	//Lista la relación de equipos temáticos
	public function listarEquipos()
	{
		$query = $this->db
                ->select("codigo, denominacion")
				->get('tematicos');
				return $query->result();
	}

	//Actualiza el cierre de bases de datos
	public function existe($id)
	{
		$where = array('ano' => $id);
		
		$query = $this->db
				->where($where)
				->from('individual_ant')
				->count_all_results();
				
		return $query;
	}

	//Listar diagnosticos
	public function listarDiagnostico()
	{
		$query = $this->db
					->select("cie_10, diagno")
					->from("diagno")
					->get();
					return $query->result();
	}
	
	//Reapertura las bases de datos que estaban cerradas
	public function abreBases($id)
	{
		$where = array('ano' => $id);
		
		ini_set('memory_limit', '512M'); /// temporal hasta optimizar consultas
		$this->db->query('insert into individual 
						 (ano, semana, diagnostic, tipo_dx, subregion, ubigeo, localcod, localidad, apepat, apemat, nombres, 
						 edad, tipo_edad, sexo, protegido, fecha_ini, fecha_def, fecha_not, fecha_inv, sub_reg_nt, red, 
						 microred, e_salud, semana_not, an_notific, fecha_ing, ficha_inv, tipo_noti, clave, importado, 
						 migrado, verifica, dni, muestra, hc, fecha_hos, estado, tip_zona, cod_pais, tipo_id, direccion, 
						 etniaproc, etnias, procede, otroproc, usuario)
						 (select ano, semana, diagnostic, tipo_dx, subregion, ubigeo, localcod, localidad, apepat, apemat, nombres, 
						 edad, tipo_edad, sexo, protegido, fecha_ini, fecha_def, fecha_not, fecha_inv, sub_reg_nt, red, 
						 microred, e_salud, semana_not, an_notific, fecha_ing, ficha_inv, tipo_noti, clave, importado, 
						 migrado, verifica, dni, muestra, hc, fecha_hos, estado, tip_zona, cod_pais, tipo_id, direccion, 
						 etniaproc, etnias, procede, otroproc, usuario from individual_ant where ano = '.$id.')');
		
		$this->db->delete('individual_ant', $where);
		
		$this->db->query('insert into edas (ano, semana, sub_reg_nt, red, microred, e_salud, ubigeo, daa_c1, daa_c1_4,
						daa_c5, daa_d1, daa_d1_4, daa_d5, daa_h1, daa_h1_4, daa_h5, col_c1, col_c1_4, col_c5, col_d1, 
						col_d1_4, col_d5, col_h1, col_h1_4, col_h5, dis_c1, dis_c1_4, dis_c5, dis_d1, dis_d1_4, dis_d5, 
						dis_h1, dis_h1_4, dis_h5, cop_t1, cop_t1_4, cop_t5, cop_p1, cop_p1_4, cop_p5, cop_s1, cop_s1_4, 
						cop_s5, fecha_ing, clave, migrado, verifica, etapa, estado, etniaproc, etnias, procede, otroproc, 
						usuario)
						 (select ano, semana, sub_reg_nt, red, microred, e_salud, ubigeo, daa_c1, daa_c1_4,
						daa_c5, daa_d1, daa_d1_4, daa_d5, daa_h1, daa_h1_4, daa_h5, col_c1, col_c1_4, col_c5, col_d1, 
						col_d1_4, col_d5, col_h1, col_h1_4, col_h5, dis_c1, dis_c1_4, dis_c5, dis_d1, dis_d1_4, dis_d5, 
						dis_h1, dis_h1_4, dis_h5, cop_t1, cop_t1_4, cop_t5, cop_p1, cop_p1_4, cop_p5, cop_s1, cop_s1_4, 
						cop_s5, fecha_ing, clave, migrado, verifica, etapa, estado, etniaproc, etnias, procede, otroproc, 
						usuario
						from edas_ant where ano = '.$id.')');
		
		$this->db->delete('edas_ant', $where);
		
		$this->db->query('insert into iras (ano, semana, sub_reg_nt, red, microred, e_salud, ubigeo, ira_m2, ira_2_11, 
						ira_1_4a, neu_2_11, neu_1_4a, hos_m2, hos_2_11, hos_1_4a, ngr_m2, ngr_2_11, ngr_1_4a, dih_m2, 
						dih_2_11, dih_1_4a, deh_m2, deh_2_11, deh_1_4a, sob_2a, sob_2_4a, fecha_ing, clave, migrado, verifica,
						etapa, ira_5_9a, ira_60a, neu_5_9a, neu_60a, hos_5_9a, hos_60a, ngr_5_9a, ngr_60a, dih_5_9a, deh_60a, 
						sob_5_9a, sob_60a, estado, localcod, neu_10_19, neu_20_59, hos_10_19, hos_20_59, dih_10_19, dih_20_59,
						deh_10_19, deh_20_59, etniaproc, etnias, procede, otroproc, usuario)
						(select ano, semana, sub_reg_nt, red, microred, e_salud, ubigeo, ira_m2, ira_2_11, 
						ira_1_4a, neu_2_11, neu_1_4a, hos_m2, hos_2_11, hos_1_4a, ngr_m2, ngr_2_11, ngr_1_4a, dih_m2, 
						dih_2_11, dih_1_4a, deh_m2, deh_2_11, deh_1_4a, sob_2a, sob_2_4a, fecha_ing, clave, migrado, verifica,
						etapa, ira_5_9a, ira_60a, neu_5_9a, neu_60a, hos_5_9a, hos_60a, ngr_5_9a, ngr_60a, dih_5_9a, deh_60a, 
						sob_5_9a, sob_60a, estado, localcod, neu_10_19, neu_20_59, hos_10_19, hos_20_59, dih_10_19, dih_20_59,
						deh_10_19, deh_20_59, etniaproc, etnias, procede, otroproc, usuario from iras_ant where ano = '.$id.')');
		
		$this->db->delete('iras_ant', $where);
		
		return true;
	}

	//Cierra la base de datos 	
	public function cierreBases($id)
	{
		$where = array('ano' => $id);
		
		ini_set('memory_limit', '512M'); /// temporal hasta optimizar consultas
		$this->db->query('insert into individual_ant 
						 (ano, semana, diagnostic, tipo_dx, subregion, ubigeo, localcod, localidad, apepat, apemat, nombres, 
						 edad, tipo_edad, sexo, protegido, fecha_ini, fecha_def, fecha_not, fecha_inv, sub_reg_nt, red, 
						 microred, e_salud, semana_not, an_notific, fecha_ing, ficha_inv, tipo_noti, clave, importado, 
						 migrado, verifica, dni, muestra, hc, fecha_hos, estado, tip_zona, cod_pais, tipo_id, direccion, 
						 etniaproc, etnias, procede, otroproc, usuario)
						 (select ano, semana, diagnostic, tipo_dx, subregion, ubigeo, localcod, localidad, apepat, apemat, nombres, 
						 edad, tipo_edad, sexo, protegido, fecha_ini, fecha_def, fecha_not, fecha_inv, sub_reg_nt, red, 
						 microred, e_salud, semana_not, an_notific, fecha_ing, ficha_inv, tipo_noti, clave, importado, 
						 migrado, verifica, dni, muestra, hc, fecha_hos, estado, tip_zona, cod_pais, tipo_id, direccion, 
						 etniaproc, etnias, procede, otroproc, usuario from individual where ano = '.$id.')');
		
		$this->db->delete('individual', $where);
		
		$this->db->query('insert into edas_ant (ano, semana, sub_reg_nt, red, microred, e_salud, ubigeo, daa_c1, daa_c1_4,
						daa_c5, daa_d1, daa_d1_4, daa_d5, daa_h1, daa_h1_4, daa_h5, col_c1, col_c1_4, col_c5, col_d1, 
						col_d1_4, col_d5, col_h1, col_h1_4, col_h5, dis_c1, dis_c1_4, dis_c5, dis_d1, dis_d1_4, dis_d5, 
						dis_h1, dis_h1_4, dis_h5, cop_t1, cop_t1_4, cop_t5, cop_p1, cop_p1_4, cop_p5, cop_s1, cop_s1_4, 
						cop_s5, fecha_ing, clave, migrado, verifica, etapa, estado, etniaproc, etnias, procede, otroproc, 
						usuario)
						 (select ano, semana, sub_reg_nt, red, microred, e_salud, ubigeo, daa_c1, daa_c1_4,
						daa_c5, daa_d1, daa_d1_4, daa_d5, daa_h1, daa_h1_4, daa_h5, col_c1, col_c1_4, col_c5, col_d1, 
						col_d1_4, col_d5, col_h1, col_h1_4, col_h5, dis_c1, dis_c1_4, dis_c5, dis_d1, dis_d1_4, dis_d5, 
						dis_h1, dis_h1_4, dis_h5, cop_t1, cop_t1_4, cop_t5, cop_p1, cop_p1_4, cop_p5, cop_s1, cop_s1_4, 
						cop_s5, fecha_ing, clave, migrado, verifica, etapa, estado, etniaproc, etnias, procede, otroproc, 
						usuario from edas where ano = '.$id.')');
		
		$this->db->delete('edas', $where);
		
		$this->db->query('insert into iras_ant (ano, semana, sub_reg_nt, red, microred, e_salud, ubigeo, ira_m2, ira_2_11, 
						ira_1_4a, neu_2_11, neu_1_4a, hos_m2, hos_2_11, hos_1_4a, ngr_m2, ngr_2_11, ngr_1_4a, dih_m2, 
						dih_2_11, dih_1_4a, deh_m2, deh_2_11, deh_1_4a, sob_2a, sob_2_4a, fecha_ing, clave, migrado, verifica,
						etapa, ira_5_9a, ira_60a, neu_5_9a, neu_60a, hos_5_9a, hos_60a, ngr_5_9a, ngr_60a, dih_5_9a, deh_60a, 
						sob_5_9a, sob_60a, estado, localcod, neu_10_19, neu_20_59, hos_10_19, hos_20_59, dih_10_19, dih_20_59,
						deh_10_19, deh_20_59, etniaproc, etnias, procede, otroproc, usuario)
						(select ano, semana, sub_reg_nt, red, microred, e_salud, ubigeo, ira_m2, ira_2_11, 
						ira_1_4a, neu_2_11, neu_1_4a, hos_m2, hos_2_11, hos_1_4a, ngr_m2, ngr_2_11, ngr_1_4a, dih_m2, 
						dih_2_11, dih_1_4a, deh_m2, deh_2_11, deh_1_4a, sob_2a, sob_2_4a, fecha_ing, clave, migrado, verifica,
						etapa, ira_5_9a, ira_60a, neu_5_9a, neu_60a, hos_5_9a, hos_60a, ngr_5_9a, ngr_60a, dih_5_9a, deh_60a, 
						sob_5_9a, sob_60a, estado, localcod, neu_10_19, neu_20_59, hos_10_19, hos_20_59, dih_10_19, dih_20_59,
						deh_10_19, deh_20_59, etniaproc, etnias, procede, otroproc, usuario from iras where ano = '.$id.')');
		
		$this->db->delete('iras', $where);
		
		return true;
	}

	public function auditoriaOperador($usuario, $dato) 
	{
		$anio = date('Y') - 2;
		
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
		
		//$this->db->delete('auditoria', array('anio' => $anio)); 
		
		return true;
	}

	public function Saber_IP(){
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

	//Muestra recurrencia de usuarios
	public function mostrarCaducidad($id)
	{
		$where = array('usuario' => $id);
		
		$query = $this->db
				->select("(caduca - date('Y-m-d')) as cantidad")
				->where($where)
				->from('usuarios_frontend')
				->get();
				return $query->result();
	}

	//Busca caso de sífilis materna y/o congénita
	public function mostrarSifilis($id)
	{
		$where = array("individual.registroId"=>$id);
		
		$query = $this->db
		->select("individual.*, renace.raz_soc, renace.categoria, renace.tipo, diresas.nombre as diresa, 
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

	//Busca caso de sífilis materna y/o congénita
	public function mostrarSifilisNotificado($id)
	{
		$where = array("individual.clave"=>$id);
		
		$query = $this->db
		->select("*, renace.raz_soc, renace.categoria, renace.tipo, diresas.nombre as diresa, 
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

	//Busca una determinada ficha de sifilis materna
	public function buscarSifilisMaternaFicha($id)
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
		$where = array("codigo"=>$id);

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
		$where = array("codigo"=>$id);

		$this->db->where($where);
		$this->db->update('sifilis',$modificar);
		return true;
	}

	//elimina sifilis
	public function eliminarSifilis($id)
	{
		$where = array("codigo"=>$id);

		$this->db->where($where);
		$this->db->delete('sifilis');

		$this->db->where($where);
		$this->db->delete('sifilis_materna');

		$this->db->where($where);
		$this->db->delete('sifilis_congenita');
		return true;
	}

	//Selecciona la localidad
	public function buscarLocalidad($id1)
	{
		$where = array("codloc"=>$id1);
		
		$query = $this->db
                ->select("nombre")
                ->from("localidad")
				->where($where)
				->get();
				return $query->row();
	}
}
?>
