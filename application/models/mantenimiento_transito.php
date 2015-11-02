<?php
class mantenimiento_transito extends CI_Model {

    function __construct()
    {
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

	//Lista un distrito por su id
	public function getDiresa($id)
	{
		$query = $this->db
                ->select("nombre")
                ->where('codigo', $id)
				->get('diresas');
				$result = $query->row();

		return $result->nombre;
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

	//Selecciona las redes de acuerdo a su nivel
	public function listarRedes()
	{
		$query = $this->db
                ->select("codigo, nombre")
                ->from("redes")
				->get();
				return $query->result();
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

	//Mostrar microred
	public function listarMicrored()
	{
		$query = $this->db
                ->select("codigo, nombre")
				->order_by('nombre')
				->get('microred');
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

	//Selecciona los establecimientos de acuerdo a su nivel
	public function listarEstablec()
	{
		$query = $this->db
                ->select("cod_est, raz_soc")
                ->from("renace")
				->get();
				return $query->result();
	}

	//Mostrar establecimiento
	public function mostrarEstablecimiento($id1)
	{
		$where = array('cod_est' => $id1, 'estado' => '1');

		$query = $this->db
                ->select("subregion, red, microred, cod_est, raz_soc")
				->where($where)
				->order_by('raz_soc')
				->get('renace');
				return $query->row();
	}

	//Listar establecimiento
	public function listarEstablecimiento()
	{
		$where = array('estado' => '1');

		$query = $this->db
                ->select("cod_est, raz_soc")
				->where($where)
				->order_by('raz_soc')
				->get('renace');
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

	//Lista un departamento por su id
	public function getDepartamento($idDepa)
	{
		$query = $this->db
                ->select("nombre")
                ->where('ubigeo', $idDepa)
				->get('departamento');
				$result = $query->row();

		return $result->nombre;
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

	//Lista un provincia por su id
	public function getProvincia($idDepa, $idProv)
	{
		$query = $this->db
                ->select("nombre")
                ->where('ubigeo', $idProv)
                ->where('departamento', $idDepa)
				->get('provincia');
				$result = $query->row();

		return $result->nombre;
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

	//Lista un distrito por su id
	public function getDistrito($idDist)
	{
		$query = $this->db
                ->select("nombre")
                ->where('ubigeo', $idDist)
				->get('distrito');
				$result = $query->row();

		return $result->nombre;
	}

	// Lista los años que hay en la base de datos
	public function getAnio()
	{
		$query = $this->db
			->query("SELECT distinct(ano) as anoexp FROM trans_lesacctra ORDER BY ano desc");
		return $query->result();
	}

	// Ejecuta query para exportar excel
	//ini_set('memory_limit','250');
	public function getDataExportar($consulta)
	{
		$query = $this->db
			->query($consulta);
		return $query;
	}

	// Ejecuta querys y devuelve array de objetos
	public function getData($consulta)
	{
		$query = $this->db
			->query($consulta);
		return $query->result();
	}

	//Lista los distritos
	public function listarDistritos()
	{
		$query = $this->db
                ->select("ubigeo, nombre")
                ->from("distrito")
				->get();
				return $query->result();
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

	//Listar enfermedades indicadoras
	public function listarDiagnoMedico()
	{
		$query = $this->db
					->select("CIE_10, DIAGNO")
					->from("trans_ciex")
					->get();
					return $query->result();
	}

	//Guardar ficha de vih - sida individual
	public function insertarTransLesacctra($data = array())
	{
		$this->db->insert('trans_lesacctra', $data);
		return true;
	}

	//Ejecuta la modificación del registro de la ficha de VIH
	public function modificarTransLesacctra($modificar=array(), $id)
	{
		$where = array("id"=>$id);

		$this->db->where($where);
		$this->db->update('trans_lesacctra',$modificar);
		return true;
	}

	//Busca una determinada ficha
	public function mostrarTransLesacctra($id)
	{
		$where = array("id"=>$id);

		$query = $this->db
                ->select("*")
                ->from("trans_lesacctra")
				->where($where)
				->get();
				return $query->row();
	}

	//Obtener el caso notificado
	public function obtenerCaso($id)
	{
		$where = array('registroId' => $id);

		$query = $this->db
				->where($where)
				->get('individual');
				return $query->row();
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

	public function getDataDbf($where='', $puntero, $limite)
	{
		$encabezados = 'fuen_finc, hce, hch, ref_es, referi, ap_nm1, ap_nm2, nom_les, cod_dir, diresa, red, microred, cod_eess, eess, dni, edad, tipo_edad, sexo, depar, prov, dis, ubigeo, tipo_loc, direccion, replace(ing_eess, "-", "") as ing_eess, hora, dx1, dx2, dx3, replace(fech_egre, "-", "") as fech_egre, cond_egr, refer, rehab, replace(fec_accd,"-", "") as fec_accd, hor_accid, lug_accid, tipo_loc1, depar_acc, prov_acc, dist_acc, ubigeo_ac, via_accd, tp_accd, movil, nomovil, veh_moto, veh_nomoto, peaton, ub_les, trasl_les, tp_moto, tp_nomoto, tp_condi, nom_condc1, ape_condc, nom_condc2, ed_cond, sex_cond, lic_conduc, comisar, dep_com, prov_com, dist_com, ubigeo_com, alcoh, num_pol, num_plac, nom_duepol, aseg, otroaseg, ano, estado, fichanum, tpa_otro, evento';
		$query = $this->db->query("select $encabezados from trans_lesacctra $where order by ano desc limit $puntero, $limite");
		return $query->result();
	}

	// obtiene cantidad de datos
	public function getCantidad($where='')
	{
		$query = $this->db->query("select count(*) as cantidad from trans_lesacctra $where ");
		return $query->row();
	}

	// obtiene casos de accidentes por nivel y por meses
	public function getAccidentesNivelMeses()
	{
		if($this->input->post()) {
			$direPost = $this->input->post('diresa');
			$redPost = $this->input->post('red');
			$mrPost = $this->input->post('mred');
			$estabPost = $this->input->post('eess');
			$anio = $this->input->post('anio');
		} else {
			$direPost = $this->session->userdata('diresa');
			$redPost = $this->session->userdata('red');
			$mrPost = $this->session->userdata('microred');
			$estabPost = $this->session->userdata('establecimiento');
			$anio = date('Y');
		}

			if ($estabPost != '') {
				$q1		= "rn.raz_soc as Establecimiento";
				$q2 	= "inner join renace as rn
						on  t.cod_dir=rn.subregion and t.red=rn.red and t.microred=rn.microred and t.cod_eess=rn.cod_est
						WHERE ano=$anio and t.cod_dir=$direPost and t.red=$redPost and t.microred=$mrPost and t.cod_eess='$estabPost'
						GROUP BY eess";

			} else if ($estabPost == '' && $mrPost !='') {
				$q1		= "rn.raz_soc as Establecimientos";
				$q2 	= "inner join renace as rn
						on  t.cod_dir=rn.subregion and t.red=rn.red and t.microred=rn.microred and t.cod_eess=rn.cod_est
						WHERE ano=$anio and t.cod_dir=$direPost and t.red=$redPost and t.microred=$mrPost
						GROUP BY eess";

			} else if ($estabPost == '' && $mrPost =='' && $redPost !='') {
				$q1		= "mr.nombre as Microredes";
				$q2 	= "inner join microred as mr
						on  t.cod_dir=mr.subregion and t.red=mr.red and t.microred=mr.codigo
						WHERE ano=$anio and t.cod_dir=$direPost and t.red=$redPost
						GROUP BY mr.nombre";

			} else if ($estabPost == '' && $mrPost =='' && $redPost =='' && $direPost !='') {
				$q1		= "r.nombre as Redes";
				$q2 	= "inner join redes as r
						on  t.cod_dir=r.subregion and t.red=r.codigo
						WHERE ano=$anio and cod_dir=$direPost
						GROUP BY r.nombre";

			} else {
				$q1		= "diresa as Diresas";
				$q2 	= "WHERE ano=$anio
							GROUP BY diresa";
			}

			$query = $this->db->query("SELECT $q1,
						COUNT( IF (MONTH(ing_eess)=1,  1,NULL)) as ene,
						COUNT( IF (MONTH(ing_eess)=2,  1,NULL)) as feb,
						COUNT( IF (MONTH(ing_eess)=3,  1,NULL)) as mar,
						COUNT( IF (MONTH(ing_eess)=4,  1,NULL)) as abr,
						COUNT( IF (MONTH(ing_eess)=5,  1,NULL)) as may,
						COUNT( IF (MONTH(ing_eess)=6,  1,NULL)) as jun,
						COUNT( IF (MONTH(ing_eess)=7,  1,NULL)) as jul,
						COUNT( IF (MONTH(ing_eess)=8,  1,NULL)) as ago,
						COUNT( IF (MONTH(ing_eess)=9,  1,NULL)) as sep,
						COUNT( IF (MONTH(ing_eess)=10, 1,NULL)) as oct,
						COUNT( IF (MONTH(ing_eess)=11, 1,NULL)) as nov,
						COUNT( IF (MONTH(ing_eess)=12, 1,NULL)) as dic,
						count(ing_eess) as total
					FROM trans_lesacctra as t
					$q2");
		return $query;
	}

	public function getEstado($anio, $apli)
	{
		$query = $this->db->query("SELECT estado FROM cierreapli where aplicativo=$apli and anio=$anio");
		$result = $query->row();
		return $result->estado;
	}


	public function getAnioRegTrans($id)
	{
		$query = $this->db->query("SELECT ano FROM trans_lesacctra where id=$id");
		$result = $query->row();
		return $result->ano;
	}

	public function borrarFicha($id)
	{
		$query = $this->db->query("DELETE FROM trans_lesacctra where id=$id");
	}





}