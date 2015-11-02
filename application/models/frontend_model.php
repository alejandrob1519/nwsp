<?php
class frontend_model extends CI_Model{
    function __construct() {
        parent::__construct();
    }
	
	//Guarda los datos ingresados en la notificación telemática
	public function insertarTelematica($datos)
	{
		set_time_limit(-1);
		ini_set('memory_limit', '512M'); /// temporal hasta optimizar consultas
		$this->db->insert("telematica", $datos);
		return true;
	}
    	
	//Guarda los datos ingresado en la ficha de notificación individual
	public function insertarIndividual($datos)
	{
		$this->db->insert("individual", $datos);
		return true;
	}
    	
	//Guarda los datos ingresado en la ficha de notificación de Edas
	public function insertarEdas($datos)
	{
		$this->db->insert("edas", $datos);
		return true;
	}
    	
	//Guarda los datos ingresado en la ficha de notificación de Iras
	public function insertarIras($datos)
	{
		$this->db->insert("iras", $datos);
		return true;
	}
    	
	//Guarda los datos ingresado en la ficha de notificación de febriles
	public function insertarFebriles($datos)
	{
		$this->db->insert("febriles", $datos);
		return true;
	}
    	
	//verifica si existe el paciente en la notificación individual
	public function buscaIndividual($dato)
	{
		$where = array('clave' => $dato);
		
		$this->db
				->where($where)
				->from('individual');
				return $this->db->count_all_results();
	}

	//Ejecuta la modificación del registro de la notificación individual
	public function ejecutarModificarIndidivual($modificar=array(), $id)
	{
		$where = array("registroId"=>$id);

		$this->db->where($where);
		$this->db->update('individual',$modificar);
		return true;
	}

	//Ejecuta la modificación del registro de la notificación Edas
	public function ejecutarModificarEdas($modificar=array(), $id)
	{
		$where = array("registroId"=>$id);

		$this->db->where($where);
		$this->db->update('edas',$modificar);
		return true;
	}

	//Ejecuta la modificación del registro de la notificación Iras
	public function ejecutarModificarIras($modificar=array(), $id)
	{
		$where = array("registroId"=>$id);

		$this->db->where($where);
		$this->db->update('iras',$modificar);
		return true;
	}

	//Ejecuta la modificación del registro de la notificación de febriles
	public function ejecutarModificarFebriles($modificar=array(), $id)
	{
		$where = array("registroId"=>$id);

		$this->db->where($where);
		$this->db->update('febriles',$modificar);
		return true;
	}

	//Muestra el registro de la notificación individual para modificar
	public function modificarIndividual($id)
	{
		$where = array('registroId' => $id);
		
		$query = $this->db
				->select('*')
				->from('individual')
				->where($where)
				->get();
				return $query->row();
	}

	//Muestra el registro de la notificación de Edas para modificar
	public function modificarEdas($id)
	{
		$where = array('registroId' => $id);
		
		$query = $this->db
				->select('*')
				->from('edas')
				->where($where)
				->get();
				return $query->row();
	}

	//Muestra el registro de la notificación de Iras para modificar
	public function modificarIras($id)
	{
		$where = array('registroId' => $id);
		
		$query = $this->db
				->select('*')
				->from('iras')
				->where($where)
				->get();
				return $query->row();
	}

	//Muestra el registro de la notificación de febriles para modificar
	public function modificarFebriles($id)
	{
		$where = array('registroId' => $id);
		
		$query = $this->db
				->select('*')
				->from('febriles')
				->where($where)
				->get();
				return $query->row();
	}

	//verifica si existe el paciente en la notificación individual
	public function comparaIndividual($id1, $id2, $id3, $id4, $id5)
	{
		$where = array('dni' => $id1, 'apepat' => $id2, 'apemat' => $id3, 'nombres' => $id4, 'diagnostic' => $id5);
		
		$this->db
				->where($where)
				->from('individual');
				return $this->db->count_all_results();
	}

	//Ubica al paciente en la notificación individual
	public function mostrarIndividual($id1, $id2, $id3, $id4, $id5)
	{
		$where = array('dni' => $id1, 'apepat' => $id2, 'apemat' => $id3, 'nombres' => $id4, 'diagnostic' => $id5);
		
		$query = $this->db
				->where($where)
				->get('individual');
				return $query->row();
	}

	//verifica si existe la notificación en Edas para la semana
	public function validaDuplicadoEdas($id1, $id2, $id3, $id4, $id5, $id6)
	{
		$where = array('ano' => $id1, 'semana' => $id2, 'e_salud' => $id3, 'ubigeo' => $id4, 'etniaproc' => $id5, 'etnias' => $id6);
		
		$query = $this->db
				->where($where)
				->get('edas');
				return $query->result();
	}

	//verifica si existe la notificación en Edas para la semana
	public function validaDuplicadoIras($id1, $id2, $id3, $id4, $id5, $id6)
	{
		$where = array('ano' => $id1, 'semana' => $id2, 'e_salud' => $id3, 'ubigeo' => $id4, 'etniaproc' => $id5, 'etnias' => $id6);
		
		$query = $this->db
				->where($where)
				->get('iras');
				return $query->result();
	}

	//verifica si existe la notificación en febriles para la semana
	public function validaDuplicadoFebriles($id1, $id2, $id3)
	{
		$where = array('e_salud' => $id1, 'ubigeo' => $id2, 'fecha_ate' => $id3);
		
		$query = $this->db
				->where($where)
				->get('febriles');
				return $query->result();
	}

	//Muestra los tipos de vigilancias
	public function mostrarVigilancias()
	{
		$query = $this->db
				->get('vigilancia');
				return $query->result();
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

	//Mostrar diresas
	public function mostrarDiresa($id)
	{
		$where = array('codigo' => $id);
		
		$query = $this->db
                ->select("codigo, nombre")
				->where($where)
				->order_by('nombre')
				->get('diresas');
				return $query->result();
	}

	//Mostrar diresas en lineas
	public function mostrarLineaDiresa($id)
	{
		$where = array('codigo' => $id);
		
		$query = $this->db
                ->select("nombre")
				->where($where)
				->get('diresas');
				return $query->row();
	}

	//Mostrar red en linea
	public function mostrarLineaRed($id1, $id2)
	{
		$where = array('subregion' => $id1, 'codigo' => $id2, 'estado' => '1');
		
		$query = $this->db
                ->select("nombre")
				->where($where)
				->order_by('nombre')
				->get('redes');
				return $query->row();
	}

	//Mostrar microred en linea
	public function mostrarLineaMicrored($id1, $id2, $id3)
	{
		$where = array('subregion' => $id1, 'red' => $id2, 'codigo' => $id3, 'estado' => '1');
		
		$query = $this->db
                ->select("nombre")
				->where($where)
				->order_by('nombre')
				->get('microred');
				return $query->row();
	}

	//Mostrar establecimiento en linea
	public function mostrarLineaEstablecimiento($id1)
	{
		$where = array('cod_est' => $id1, 'estado' => '1');
		
		$query = $this->db
                ->select("raz_soc")
				->where($where)
				->order_by('raz_soc')
				->get('renace');
				return $query->row();
	}

	//Mostrar red
	public function mostrarRed($id1, $id2)
	{
		$where = array('subregion' => $id1, 'codigo' => $id2, 'estado' => '1');
		
		$query = $this->db
                ->select("codigo, nombre")
				->where($where)
				->order_by('nombre')
				->get('redes');
				return $query->result();
	}

	//Mostrar microred
	public function mostrarMicrored($id1, $id2, $id3)
	{
		$where = array('subregion' => $id1, 'red' => $id2, 'codigo' => $id3, 'estado' => '1');
		
		$query = $this->db
                ->select("codigo, nombre")
				->where($where)
				->order_by('nombre')
				->get('microred');
				return $query->result();
	}

	//Mostrar establecimiento
	public function mostrarEstablecimiento($id1)
	{
		$where = array('cod_est' => $id1, 'estado' => '1');
		
		$query = $this->db
                ->select("cod_est, raz_soc")
				->where($where)
				->order_by('raz_soc')
				->get('renace');
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

	//Selecciona las microredes de acuerdo a su nivel
	public function buscaMicroredes($id)
	{
		$where = array("subregion"=>$id, 'estado' => '1');
		
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

	//Lista los establecimientos 
	public function listaEstablec()
	{
		$query = $this->db
                ->select("cod_est, raz_soc")
                ->from("renace")
				->get();
				return $query->result();
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

	//Selecciona los localidades
	public function buscarLocalidad($id1)
	{
		$where = array("ubigeo"=>$id1);
		
		$query = $this->db
                ->select("codloc, nombre")
                ->from("localidad")
				->where($where)
				->get();
				return $query->result();
	}

	//Mostrar departamentos
	public function buscarDepartamento($id1)
	{
		$where = array("ubigeo"=>$id1);
		
		$query = $this->db
                ->select("nombre")
                ->from("departamento")
				->where($where)
				->get();
				return $query->row();
	}

	//Mostrar provincia
	public function buscarProvincia($id1)
	{
		$where = array("ubigeo"=>$id1);
		
		$query = $this->db
                ->select("nombre")
                ->from("provincia")
				->where($where)
				->get();
				return $query->row();
	}

	//Mostrar los distrito
	public function muestraDistrito($id1)
	{
		$where = array("ubigeo"=>$id1);
		
		$query = $this->db
                ->select("nombre")
                ->from("distrito")
				->where($where)
				->get();
				return $query->row();
	}

	//Mostrar los distrito
	public function buscarDistrito($id1)
	{
		$where = array("ubigeo"=>$id1);
		
		$query = $this->db
                ->select("diresa")
                ->from("distrito")
				->where($where)
				->get();
				return $query->result();
	}

	//Listar distritos
	public function listarDistritos()
	{
		$query = $this->db
                ->select("ubigeo, nombre")
                ->from("distrito")
				->get();
				return $query->result();
	}

	//Muestra el listado de etnias
	public function mostrarEtnias()
	{
		$query = $this->db
				->get('etnias');
				return $query->result();
	}

	//Muestra el listado de subetnias
	public function mostrarSubEtnias($id)
	{
		$where = array('tipo' => $id);
		
		$query = $this->db
				->where($where)
				->get('etniaproc');
				return $query->result();
	}

	//Muestra el listado de diagnósticos
	public function mostrarDiagnostico()
	{
		$where = array("diresa"=>"00");
		$or_where = array("diresa"=>$this->session->userdata('diresa'));
		
		$query = $this->db
				->where($where)
				->or_where($or_where)
				->order_by('diagno', 'ASC')
				->get('diagno');
				return $query->result();
	}

	//Muestra el listado de diagnósticos
	public function muestraDiagnostico($id)
	{
		$query = $this->db
				->where('cie_10', $id)
				->order_by('diagno', 'ASC')
				->get('diagno');
				return $query->row();
	}

	//Muestra el listado de diagnósticos
	public function mostrarTipoDiagnostico($id)
	{
		$where = array('clave' => $id);
		
		$query = $this->db
				->order_by('diagno', 'ASC')
				->where($where)
				->get('diagno');
				return $query->result();
	}

	//Muestra el listado de tipo de diagnósticos
	public function mostrarTipo()
	{
		$query = $this->db
				->get('tipo_dx');
				return $query->result();
	}

	//Muestra el listado de sexo
	public function mostrarSexo($id)
	{
		$where = array('cie_10' => $id);
		
		$query = $this->db
				->where($where)
				->get('diagno');
				return $query->result();
	}

	//Registra la notificación telemática
	public function ejecutarNotificacion($id)
	{
		$registrar = array('diresa' => $this->session->userdata('diresa'), 'red' => $this->session->userdata('red'), 
		'microred' => $this->session->userdata('microred'), 'establecimiento' => $this->session->userdata('establecimiento'),
		'usuario' => $this->session->userdata('usuario'), 'fecha' => date("Y-m-d"), 'enviado' => '2');
		
		$where = array("registroId"=>$id);

		$this->db->where($where);
		$this->db->update('telematica',$registrar);
		return true;
	}

	//Muestra el registro a notificar
	public function Notificar($id)
	{
		$where = array('registroId' => $id);
		
		$query = $this->db
				->where($where)
				->get('telematica');
				return $query->row();
	}

	//Muestra la autorización
	public function Autorizacion($id1)
	{
		$where = array('diresa' => $id1, 'ano' => $date("Y"));
		
		$query = $this->db
				->where($where)
				->get('autoriza');
				return $query->result();
	}

	//Dispone de las tablas para la notificación telemática
	
	public function notificacionTelematica($dato, $carpeta, $id)
	{
		if($dato->diresa <> "" and $dato->red <> "" and $dato->microred <> "" and $dato->establecimiento <> ""){
			$where = array('ano <= ' => $dato->ano, 'e_salud' => $dato->establecimiento);
		}elseif($dato->diresa <> "" and $dato->red <> "" and $dato->microred <> "" and $dato->establecimiento == ""){
			$where = array('ano <= ' => $dato->ano, 'sub_reg_nt' => $dato->diresa, 'red' => $dato->red, 'microred' => $dato->microred);
		}elseif($dato->diresa <> "" and $dato->red <> "" and $dato->microred == "" and $dato->establecimiento == ""){
			$where = array('ano <= ' => $dato->ano, 'sub_reg_nt' => $dato->diresa, 'red' => $dato->red);
		}elseif($dato->diresa <> "" and $dato->red == "" and $dato->microred == "" and $dato->establecimiento == ""){
			$where = array('ano <= ' => $dato->ano, 'sub_reg_nt' => $dato->diresa);
		}
		
		$tablas = array('individual', 'edas', 'iras', 'febriles');
		
		$this->db
		->where($where)
		->delete($tablas);
		
		return true;
	}
	
	// Actualiza el pendiente del listado del PNT
	public function actualizaTelematica($id)
	{
		$where = array("registroId"=>$id);

		$this->db->where($where);
		$this->db->update('telematica',array('enviado' => '1'));
		return true;
	}
	
	//Para exportar las bases de datos
	public function exportarInd($id1, $id2, $id3, $id4)
	{
		set_time_limit(-1);
		ini_set('memory_limit', '512M'); /// temporal hasta optimizar consultas

		$res2 = "SELECT ANO, SEMANA, DIAGNOSTIC, TIPO_DX, SUBREGION, UBIGEO, LOCALCOD, LOCALIDAD, APEPAT, APEMAT ,
				NOMBRES, EDAD, TIPO_EDAD, SEXO, PROTEGIDO, DATE_FORMAT(fecha_ini,'%Y%m%d') as FECHA_INI,
				DATE_FORMAT(fecha_def,'%Y%m%d') as FECHA_DEF, DATE_FORMAT(fecha_not,'%Y%m%d') as FECHA_NOT,
				DATE_FORMAT(fecha_inv,'%Y%m%d') as FECHA_INV, SUB_REG_NT, RED, MICRORED, E_SALUD, SEMANA_NOT,
				AN_NOTIFIC, DATE_FORMAT(fecha_ing,'%Y%m%d') as FECHA_ING, FICHA_INV, TIPO_NOTI, CLAVE, IMPORTADO,
				MIGRADO, VERIFICA, DNI, MUESTRA, HC, ESTADO, TIP_ZONA, COD_PAIS, TIPO_ID, DIRECCION, ETNIAPROC,
				ETNIAS, PROCEDE, OTROPROC FROM ".$id1.$id2." LIMIT ".$id3.",".$id4; 

		$query = $this->db->query($res2);
		return $query->result();
	}

	public function exportarEda($id1, $id2, $id3, $id4)
	{
		set_time_limit(-1);
		ini_set('memory_limit', '512M'); /// temporal hasta optimizar consultas

		$res2 = "SELECT ANO, SEMANA, SUB_REG_NT, RED, MICRORED, E_SALUD, UBIGEO, DAA_C1, DAA_C1_4, 
		DAA_C5, DAA_D1, DAA_D1_4, DAA_D5, DAA_H1, DAA_H1_4, DAA_H5, COL_C1, COL_C1_4, COL_C5, COL_D1, COL_D1_4, 
		COL_D5, COL_H1, COL_H1_4, COL_H5, DIS_C1, DIS_C1_4, DIS_C5, DIS_D1, DIS_D1_4, DIS_D5, DIS_H1, DIS_H1_4, 
		DIS_H5, COP_T1, COP_T1_4, COP_T5, COP_P1, COP_P1_4, COP_P5, COP_S1, COP_S1_4, COP_S5, 
		DATE_FORMAT(fecha_ing,'%Y%m%d') as FECHA_ING, CLAVE, MIGRADO, VERIFICA, ETAPA, ESTADO, ETNIAPROC, ETNIAS, 
		PROCEDE, OTROPROC FROM ".$id1.$id2." LIMIT ".$id3.",".$id4; 

		$query = $this->db->query($res2);
		return $query->result();
	}

	public function exportarIra($id1, $id2, $id3, $id4)
	{
		set_time_limit(-1);
		ini_set('memory_limit', '512M'); /// temporal hasta optimizar consultas

		$res2 = "SELECT ANO, SEMANA, SUB_REG_NT, RED, MICRORED, E_SALUD, UBIGEO, 
		IRA_M2, IRA_2_11, IRA_1_4A, 
		NEU_2_11, NEU_1_4A, 
		HOS_M2, HOS_2_11, HOS_1_4A, 
		NGR_M2,	NGR_2_11, NGR_1_4A, 
		DIH_M2, DIH_2_11, DIH_1_4A, 
		DEH_M2, DEH_2_11, DEH_1_4A, 
		SOB_2A, SOB_2_4A, 
		DATE_FORMAT(fecha_ing,'%Y%m%d') as FECHA_ING, CLAVE, MIGRADO, VERIFICA, ETAPA, 
		IRA_5_9A, IRA_60A, 
		NEU_5_9A, NEU_60A, 
		HOS_5_9A, HOS_60A, 
		NGR_5_9A, NGR_60A, 
		DIH_5_9A, DIH_60A, 
		DEH_5_9A, DEH_60A, 
		SOB_5_9A, SOB_60A, 
		ESTADO, LOCALCOD, 
		NEU_10_19, NEU_20_59, 
		HOS_10_19, HOS_20_59, 
		DIH_10_19, DIH_20_59, 
		DEH_10_19, DEH_20_59, 
		ETNIAPROC, ETNIAS, PROCEDE, OTROPROC FROM ".$id1.$id2." LIMIT ".$id3.",".$id4; 

		$query = $this->db->query($res2);
		return $query->result();
	}

	public function exportarFebriles($id1, $id2, $id3, $id4)
	{
		set_time_limit(-1);
		ini_set('memory_limit', '512M'); /// temporal hasta optimizar consultas

		$res2 = "SELECT ANO, SEMANA, SUB_REG_NT, RED, MICRORED, E_SALUD, UBIGEO, FEB_M1, FEB_1_4, 
		FEB_5_9, FEB_10_19, FEB_20_59, FEB_M60,	DATE_FORMAT(fecha_ing,'%Y%m%d') as FECHA_ING, CLAVE, 
		FEB_TOT, DATE_FORMAT(fecha_not,'%Y%m%d') as FECHA_NOT, DATE_FORMAT(fecha_ate,'%Y%m%d') as FECHA_ATE, 
		TOT_ATEN FROM ".$id1.$id2." LIMIT ".$id3.",".$id4; 

		$query = $this->db->query($res2);
		return $query->result();
	}

	public function exportarCobertura($id1, $id2, $id3, $id4)
	{
		set_time_limit(-1);
		ini_set('memory_limit', '512M'); /// temporal hasta optimizar consultas

		$res2 = "SELECT ANO, SEMANA, 'NIVEL', ESTABLEC AS COD_EST, DIRESA AS EST_NOT, DIRESA AS REGION, RED, 'Z', MICRORED, 
		NOTIFICACION AS SITUACION, DATE_FORMAT(fecha,'%Y%m%d') AS FGENERA, HORA AS HORANOT FROM ".$id1.$id2." LIMIT ".$id3.",".$id4; 

		$query = $this->db->query($res2);
		return $query->result();
	}

	//Procesar para contar registros para exportar las bases de datos
	public function exportarInd_1($id1, $id2)
	{
		$res2 = "SELECT count(*) as cantidad FROM ".$id1.$id2; 
		
		$query = $this->db->query($res2);
		return $query->row();
	}

	public function exportarEda_1($id1, $id2)
	{
		$res2 = "SELECT count(*) as cantidad FROM ".$id1.$id2; 

		$query = $this->db->query($res2);
		return $query->row();
	}

	public function exportarIra_1($id1, $id2)
	{
		$res2 = "SELECT count(*) as cantidad FROM ".$id1.$id2; 

		$query = $this->db->query($res2);
		return $query->row();
	}

	public function exportarFebriles_1($id1, $id2)
	{
		$res2 = "SELECT count(*) as cantidad FROM ".$id1.$id2; 

		$query = $this->db->query($res2);
		return $query->row();
	}

	public function exportarCobertura_1($id1, $id2)
	{
		$res2 = "SELECT count(*) as cantidad FROM ".$id1.$id2; 

		$query = $this->db->query($res2);
		return $query->row();
	}

	//verifica si existe el cierre de la base de datos del año
	public function buscaCierre($id)
	{
		$where = array('anio' => $id, 'estado' => '1');
		
		$this->db
				->where($where)
				->from('cierre');
				return $this->db->count_all_results();
	}

	//mostrar el cierre de base de datos
	public function mostrarCierre()
	{
		$query = $this->db
					->from('cierre')
					->get();
					return $query->result();
	}

	//Elimina la información de años que ya han sido cerrados
	public function compactarBase($anio){
		
		$where = array('ano <=' => $anio);
		
		$tablas = array('individual', 'edas', 'iras', 'febriles');
		
		$this->db
		->where($where)
		->delete($tablas);
		
		return true;
	}

	//mostrar el ciex
	public function mostrarCiex()
	{
		$query = $this->db
					->from('ciex')
					->order_by('descripcion', 'asc')
					->get();
					return $query->result();
	}

	//Para exportar la base de datos de Muerte Perinatal	
	public function exportarIndmnp($id1, $id2, $id3, $id4)
	{
		set_time_limit(-1);
		ini_set('memory_limit', '512M'); /// temporal hasta optimizar consultas
		$res2 = "SELECT diresas.nombre as Subregion, renace.raz_soc as Establecim, redes.nombre as Redes, 
				 microred.nombre as MicroRedes, departamento.nombre as Departamen, provincia.nombre as Provincia, 
				 distrito.nombre as Distrito, mnp.registroId, anio, semana, mnp.diresa, mnp.red, mnp.microred, e_salud, responsabl,
				 ape_nom, apepat, apemat, nombres, sexo, edadges, DATE_FORMAT(fecha_nac,'%Y%m%d') as fecha_nac, 
				 hora_nac, DATE_FORMAT(fecha_mte,'%Y%m%d') as fecha_mte, hora_mte, peso_nac, tipo_mte, causa_bas,
				 diagno, estancia, lugar_par, momento, lugar_mte, dni_madre, DATE_FORMAT(fecha_reg,'%Y%m%d') as fecha_reg,
				 usuario, ubigeo_res, vida, codcat, mnp.categoria FROM ".$id1." JOIN (diresas, renace, redes, microred, departamento, provincia, distrito) ON 
				 (diresas.codigo = mnp.diresa AND 
				 renace.cod_est = mnp.e_salud AND redes.subregion = renace.subregion and redes.codigo = renace.red AND
				 microred.subregion = renace.subregion and microred.red = renace.red and microred.codigo = renace.microred AND
				 departamento.ubigeo = SUBSTRING(mnp.ubigeo_res,1,2) AND provincia.ubigeo = SUBSTRING(mnp.ubigeo_res,1,4) AND 
				 distrito.ubigeo = mnp.ubigeo_res) ".$id2." LIMIT ".$id3.",".$id4; 
        
		/*$res2 = "SELECT diresas.nombre as Subregion, renace.raz_soc as Establecim, redes.nombre as Redes, 
				 microred.nombre as MicroRedes, departamento.nombre as Departamen, provincia.nombre as Provincia, 
				 distrito.nombre as Distrito, mnp.* FROM ".$id1." JOIN (diresas, renace, redes, microred, departamento, provincia, distrito) ON 
				 (diresas.codigo = mnp.diresa AND 
				 renace.cod_est = mnp.e_salud AND redes.subregion = renace.subregion and redes.codigo = renace.red AND
				 microred.subregion = renace.subregion and microred.red = renace.red and microred.codigo = renace.microred AND
				 departamento.ubigeo = SUBSTRING(mnp.ubigeo_res,1,2) AND provincia.ubigeo = SUBSTRING(mnp.ubigeo_res,1,4) AND 
				 distrito.ubigeo = mnp.ubigeo_res) ".$id2." LIMIT ".$id3.",".$id4; 
        */
		
		$query = $this->db->query($res2);
		return $query->result();
	}
	
	public function revision(){
		switch($this->session->userdata('nivel')){
			case 5: 
			if($ident == 'notificacion'){
				$datos = array('diresa'=>$this->session->userdata('diresa'), 'notificacion'=>'1');
			}elseif($ident == 'calidad'){
				$datos = array('diresa'=>$this->session->userdata('diresa'), 'calidad'=>'1');
			}elseif($ident == 'cobertura'){
				$datos = array('diresa'=>$this->session->userdata('diresa'), 'cobertura'=>'1');
			}else{
				return false;
			}
			
			$this->db->insert("revision", $datos);
			break;
			case 6:
			if($ident == 'notificacion'){
				$datos = array('diresa'=>$this->session->userdata('diresa'), 'red'=>$this->session->userdata('red'), 'notificacion'=>'1');
			}elseif($ident == 'calidad'){
				$datos = array('diresa'=>$this->session->userdata('diresa'), 'red'=>$this->session->userdata('red'), 'calidad'=>'1');
			}elseif($ident == 'cobertura'){
				$datos = array('diresa'=>$this->session->userdata('diresa'), 'red'=>$this->session->userdata('red'), 'cobertura'=>'1');
			}else{
				return false;
			}

			$this->db->insert("revision", $datos);
			break;
			case 7:
			if($ident == 'notificacion'){
				$datos = array('diresa'=>$this->session->userdata('diresa'), 'red'=>$this->session->userdata('red'), 'microred'=>$this->session->userdata('microred'), 'notificacion'=>'1');
			}elseif($ident == 'calidad'){
				$datos = array('diresa'=>$this->session->userdata('diresa'), 'red'=>$this->session->userdata('red'), 'microred'=>$this->session->userdata('microred'), 'calidad'=>'1');
			}elseif($ident == 'cobertura'){
				$datos = array('diresa'=>$this->session->userdata('diresa'), 'red'=>$this->session->userdata('red'), 'microred'=>$this->session->userdata('microred'), 'cobertura'=>'1');
			}else{
				return false;
			}

			$this->db->insert("revision", $datos);
			break;
			case 8:
			if($ident == 'notificacion'){
				$datos = array('diresa'=>$this->session->userdata('diresa'), 'red'=>$this->session->userdata('red'), 'microred'=>$this->session->userdata('microred'), 'establec'=>$this->session->userdata('establecimiento'), 'notificacion'=>'1');
			}elseif($ident == 'calidad'){
				$datos = array('diresa'=>$this->session->userdata('diresa'), 'red'=>$this->session->userdata('red'), 'microred'=>$this->session->userdata('microred'), 'establec'=>$this->session->userdata('establecimiento'), 'calidad'=>'1');
			}elseif($ident == 'cobertura'){
				$datos = array('diresa'=>$this->session->userdata('diresa'), 'red'=>$this->session->userdata('red'), 'microred'=>$this->session->userdata('microred'), 'establec'=>$this->session->userdata('establecimiento'), 'cobertura'=>'1');
			}else{
				return false;
			}

			$this->db->insert("revision", $datos);
			break;
		}
		
		return true;
	}
}
?>