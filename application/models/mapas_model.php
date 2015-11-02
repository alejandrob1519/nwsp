<?php
class mapas_model extends CI_Model{
    function __construct() {
        parent::__construct();
    }
    	
	public function obtenerDepartamentos()
	{
		$query = 
				$this->db
				->order_by('nombre')
				->get('departamento');
		$resultado = $query->result();
		$query->free_result();
		return $resultado;
	}

	public function obtenerDiresas()
	{
		$query = 
				$this->db
				->order_by('nombre')
				->get('diresas');
		$resultado = $query->result();
		$query->free_result();
		return $resultado;
	}

	public function obtenerIndividual()
	{
		$query = 
				$this->db
				->order_by('diagno')
				->get('diagno');
		$resultado = $query->result();
		$query->free_result();
		return $resultado;
	}
	
	public function obtenerEstratos()
	{
		$query = 
				$this->db
				->query('SELECT b.* FROM `estratos` a left join diagno b on b.cie_10 = a.enfermedad 
						where enfermedad != "XX1" and enfermedad != "YY1"');
		$resultado = $query->result();
		$query->free_result();
		return $resultado;
	}
	
	public function totalIndividual($anio, $diagno)
	{
		set_time_limit(180);

		$agnio = $anio;
		$diagno = $diagno;
		
		ini_set('memory_limit', '512M'); /// temporal hasta optimizar consultas
		$query = $this->db->query("
		select * from estratos where enfermedad = '".$diagno."'");
		$resultado = $query->result();
		$query->free_result();
		
		foreach($resultado as $valor)
		{
			$q1 = $valor->estrato_1;
			
			$q2 = $valor->estrato_2;
	
			$q3 = $valor->estrato_3;
			
			$q4 = $valor->estrato_4;

			$q5 = $valor->estrato_5;
			
			$proceso = $valor->tipo;

			$habitantes = $valor->habitantes;
		}
		
		$cierre = $this->frontend_model->buscaCierre($agnio);
		
		if($proceso == '2'){
	 		if($cierre == 0){
				$query1 = $this->db->query("
				select concat('noti',ubigeo) as ubigeo,
				case
				  when categoria = 0 then 'white'
				  when categoria = 4 then 'red'
				  when categoria = 3 then 'pink'
				  when categoria = 2 then 'yellow'
				  when categoria = 1 then 'green'
				end as categoria
				from
					(select y.*,
					case
					when y.incidencia = 0 then 0
					when y.incidencia between 0.01 and $q1 then 1
					when y.incidencia between $q1 + 0.01 and $q2 then 2
					when y.incidencia between $q2 + 0.01 and $q3 then 3
					when y.incidencia >= $q3 + 0.01 then 4
					end as categoria
					from
					(select a.ano, a.ubigeo, round((ifnull(b.cantidad,0) / a.poblacion) * $habitantes,2) as incidencia 
					from 
					(select ano, ubigeo, pobtot as poblacion from codubi where ano = $agnio) a, 
					(select ano, ubigeo, count(ubigeo) as cantidad 
					from individual where diagnostic = '".$diagno."' and ano = $agnio 
					and ano <> 0 and ubigeo <> '999999' group by ano, ubigeo) b 
					where a.ano = b.ano and a.ubigeo = b.ubigeo 
					group by a.ubigeo 
					order by incidencia) y) k;
				");
		  	}elseif($cierre <> 0){
				$query1 = $this->db->query("
				select concat('noti',ubigeo) as ubigeo,
				case
				  when categoria = 0 then 'white'
				  when categoria = 4 then 'red'
				  when categoria = 3 then 'pink'
				  when categoria = 2 then 'yellow'
				  when categoria = 1 then 'green'
				end as categoria
				from
					(select y.*,
					case
					when y.incidencia = 0 then 0
					when y.incidencia between 0.01 and $q1 then 1
					when y.incidencia between $q1 + 0.01 and $q2 then 2
					when y.incidencia between $q2 + 0.01 and $q3 then 3
					when y.incidencia >= $q3 + 0.01 then 4
					end as categoria
					from
					(select a.ano, a.ubigeo, round((ifnull(b.cantidad,0) / a.poblacion) * $habitantes,2) as incidencia 
					from 
					(select ano, ubigeo, pobtot as poblacion from codubi where ano = $agnio) a, 
					(select ano, ubigeo, count(ubigeo) as cantidad 
					from individual_ant where diagnostic = '".$diagno."' and ano = $agnio 
					and ano <> 0 and ubigeo <> '999999' group by ano, ubigeo) b 
					where a.ano = b.ano and a.ubigeo = b.ubigeo 
					group by a.ubigeo 
					order by incidencia) y) k;
				");
			}
			$resultado2 = $query1->result();
			$query1->free_result();
			return $resultado2;
		}elseif($proceso == '1'){
			ini_set('memory_limit', '512M'); /// temporal hasta optimizar consultas
	 		if($cierre == 0){
				$query1 = $this->db->query("
				select concat('noti',ubigeo) as ubigeo,
				case
				  when categoria = 0 then 'white'
				  when categoria = 1 then 'red'
				end as categoria
				from
					(select y.*,
					case
					when y.incidencia = 0 then 0
					when y.incidencia between 0.01 and $q1 then 1
					end as categoria
					from
					(select a.ano, a.ubigeo, ifnull(b.cantidad,0) as incidencia 
					from 
					(select ano, ubigeo, pobtot as poblacion from codubi where ano = $agnio) a, 
					(select ano, ubigeo, count(ubigeo) as cantidad 
					from individual where diagnostic = '".$diagno."' and ano = $agnio 
					and ano <> 0 and ubigeo <> '999999' group by ano, ubigeo) b 
					where a.ano = b.ano and a.ubigeo = b.ubigeo 
					group by a.ubigeo 
					order by incidencia) y) k;
				");
		  	}elseif($cierre <> 0){
				$query1 = $this->db->query("
				select concat('noti',ubigeo) as ubigeo,
				case
				  when categoria = 0 then 'white'
				  when categoria = 1 then 'red'
				end as categoria
				from
					(select y.*,
					case
					when y.incidencia = 0 then 0
					when y.incidencia between 0.01 and $q1 then 1
					end as categoria
					from
					(select a.ano, a.ubigeo, ifnull(b.cantidad,0) as incidencia 
					from 
					(select ano, ubigeo, pobtot as poblacion from codubi where ano = $agnio) a, 
					(select ano, ubigeo, count(ubigeo) as cantidad 
					from individual_ant where diagnostic = '".$diagno."' and ano = $agnio 
					and ano <> 0 and ubigeo <> '999999' group by ano, ubigeo) b 
					where a.ano = b.ano and a.ubigeo = b.ubigeo 
					group by a.ubigeo 
					order by incidencia) y) k;
				");
			}
			$resultado2 = $query1->result();
			$query1->free_result();
			return $resultado2;
		}elseif($proceso == '3'){
			ini_set('memory_limit', '512M'); /// temporal hasta optimizar consultas
	 		if($cierre == 0){
				$query1 = $this->db->query("
				select concat('noti',ubigeo) as ubigeo,
				case
				  when categoria = 0 then 'white'
				  when categoria = 3 then 'red'
				  when categoria = 2 then 'yellow'
				  when categoria = 1 then 'green'
				end as categoria
				from
					(select y.*,
					case
					when y.incidencia = 0 then 0
					when y.incidencia between 1 and $q1 then 1
					when y.incidencia between $q1 + 1 and $q2 then 2
					when y.incidencia between $q2 + 1 and $q3 then 3
					end as categoria
					from
					(select a.ano, a.ubigeo, ifnull(b.cantidad,0) as incidencia 
					from 
					(select ano, ubigeo, pobtot as poblacion from codubi where ano = $agnio) a, 
					(select ano, ubigeo, count(ubigeo) as cantidad 
					from individual where diagnostic = '".$diagno."' and ano = $agnio 
					and ano <> 0 and ubigeo <> '999999' group by ano, ubigeo) b 
					where a.ano = b.ano and a.ubigeo = b.ubigeo 
					group by a.ubigeo 
					order by incidencia) y) k;
				");
		  	}elseif($cierre <> 0){
				$query1 = $this->db->query("
				select concat('noti',ubigeo) as ubigeo,
				case
				  when categoria = 0 then 'white'
				  when categoria = 3 then 'red'
				  when categoria = 2 then 'yellow'
				  when categoria = 1 then 'green'
				end as categoria
				from
					(select y.*,
					case
					when y.incidencia = 0 then 0
					when y.incidencia between 1 and $q1 then 1
					when y.incidencia between $q1 + 1 and $q2 then 2
					when y.incidencia between $q2 + 1 and $q3 then 3
					end as categoria
					from
					(select a.ano, a.ubigeo, ifnull(b.cantidad,0) as incidencia 
					from 
					(select ano, ubigeo, pobtot as poblacion from codubi where ano = $agnio) a, 
					(select ano, ubigeo, count(ubigeo) as cantidad 
					from individual_ant where diagnostic = '".$diagno."' and ano = $agnio 
					and ano <> 0 and ubigeo <> '999999' group by ano, ubigeo) b 
					where a.ano = b.ano and a.ubigeo = b.ubigeo 
					group by a.ubigeo 
					order by incidencia) y) k;
				");
			}
			$resultado2 = $query1->result();
			$query1->free_result();
			return $resultado2;
		}
	}

	public function departamentoIndividual($anio, $diagno, $nivel)
	{
		set_time_limit(180);
		
		$agnio = $anio;
		$diagno = $diagno;
		
		$query = $this->db->query("
		select * from estratos where enfermedad = '".$diagno."'");
		$resultado = $query->result();
		$query->free_result();

		foreach($resultado as $valor)
		{
			$q1 = $valor->estrato_1;
			
			$q2 = $valor->estrato_2;
	
			$q3 = $valor->estrato_3;
			
			$q4 = $valor->estrato_4;

			$q5 = $valor->estrato_5;
			
			$proceso = $valor->tipo;

			$habitantes = $valor->habitantes;
		}
		
		$cierre = $this->frontend_model->buscaCierre($agnio);
		
		if($proceso == '2'){
			ini_set('memory_limit', '512M'); /// temporal hasta optimizar consultas
	 		if($cierre == 0){
				$query1 = $this->db->query("
				select concat('noti',ubigeo) as ubigeo,
				case
				  when categoria = 0 then 'white'
				  when categoria = 4 then 'red'
				  when categoria = 3 then 'pink'
				  when categoria = 2 then 'yellow'
				  when categoria = 1 then 'green'
				end as categoria
				from
					(select y.*,
					case
					when y.incidencia = 0 then 0
					when y.incidencia between 0.01 and $q1 then 1
					when y.incidencia between $q1 + 0.01 and $q2 then 2
					when y.incidencia between $q2 + 0.01 and $q3 then 3
					when y.incidencia >= $q3 + 0.01 then 4
					end as categoria
					from
					(select a.ano, a.ubigeo, round((ifnull(b.cantidad,0) / a.poblacion) * $habitantes,2) as incidencia 
					from 
					(select ano, ubigeo, pobtot as poblacion from codubi where ano = $agnio and substr(ubigeo,1,2) = $nivel) a, 
					(select ano, ubigeo, count(ubigeo) as cantidad 
					from individual where diagnostic = '".$diagno."' and substr(ubigeo,1,2) = $nivel and ano = $agnio 
					and ano <> 0 and ubigeo <> '999999' group by ano, ubigeo) b 
					where a.ano = b.ano and a.ubigeo = b.ubigeo 
					group by a.ubigeo 
					order by incidencia) y) k;
				");
		  	}elseif($cierre <> 0){
				$query1 = $this->db->query("
				select concat('noti',ubigeo) as ubigeo,
				case
				  when categoria = 0 then 'white'
				  when categoria = 4 then 'red'
				  when categoria = 3 then 'pink'
				  when categoria = 2 then 'yellow'
				  when categoria = 1 then 'green'
				end as categoria
				from
					(select y.*,
					case
					when y.incidencia = 0 then 0
					when y.incidencia between 0.01 and $q1 then 1
					when y.incidencia between $q1 + 0.01 and $q2 then 2
					when y.incidencia between $q2 + 0.01 and $q3 then 3
					when y.incidencia >= $q3 + 0.01 then 4
					end as categoria
					from
					(select a.ano, a.ubigeo, round((ifnull(b.cantidad,0) / a.poblacion) * $habitantes,2) as incidencia 
					from 
					(select ano, ubigeo, pobtot as poblacion from codubi where ano = $agnio and substr(ubigeo,1,2) = $nivel) a, 
					(select ano, ubigeo, count(ubigeo) as cantidad 
					from individual_ant where diagnostic = '".$diagno."' and substr(ubigeo,1,2) = $nivel and ano = $agnio 
					and ano <> 0 and ubigeo <> '999999' group by ano, ubigeo) b 
					where a.ano = b.ano and a.ubigeo = b.ubigeo 
					group by a.ubigeo 
					order by incidencia) y) k;
				");
			}
			$resultado2 = $query1->result();
			$query1->free_result();
			return $resultado2;
		}elseif($proceso == '1'){
			ini_set('memory_limit', '512M'); /// temporal hasta optimizar consultas
	 		if($cierre == 0){
				$query1 = $this->db->query("
				select concat('noti',ubigeo) as ubigeo,
				case
				  when categoria = 0 then 'white'
				  when categoria = 1 then 'red'
				end as categoria
				from
					(select y.*,
					case
					when y.incidencia = 0 then 0
					when y.incidencia between 0.01 and $q1 then 1
					end as categoria
					from
					(select a.ano, a.ubigeo, ifnull(b.cantidad,0) as incidencia 
					from 
					(select ano, ubigeo, pobtot as poblacion from codubi where ano = $agnio and substr(ubigeo,1,2) = $nivel) a, 
					(select ano, ubigeo, count(ubigeo) as cantidad 
					from individual where diagnostic = '".$diagno."' and substr(ubigeo,1,2) = $nivel and ano = $agnio 
					and ano <> 0 and ubigeo <> '999999' group by ano, ubigeo) b 
					where a.ano = b.ano and a.ubigeo = b.ubigeo 
					group by a.ubigeo 
					order by incidencia) y) k;
				");
		  	}elseif($cierre <> 0){
				$query1 = $this->db->query("
				select concat('noti',ubigeo) as ubigeo,
				case
				  when categoria = 0 then 'white'
				  when categoria = 1 then 'red'
				end as categoria
				from
					(select y.*,
					case
					when y.incidencia = 0 then 0
					when y.incidencia between 0.01 and $q1 then 1
					end as categoria
					from
					(select a.ano, a.ubigeo, ifnull(b.cantidad,0) as incidencia 
					from 
					(select ano, ubigeo, pobtot as poblacion from codubi where ano = $agnio and substr(ubigeo,1,2) = $nivel) a, 
					(select ano, ubigeo, count(ubigeo) as cantidad 
					from individual_ant where diagnostic = '".$diagno."' and substr(ubigeo,1,2) = $nivel and ano = $agnio 
					and ano <> 0 and ubigeo <> '999999' group by ano, ubigeo) b 
					where a.ano = b.ano and a.ubigeo = b.ubigeo 
					group by a.ubigeo 
					order by incidencia) y) k;
				");
			}
			$resultado2 = $query1->result();
			$query1->free_result();
			return $resultado2;
		}elseif($proceso == '3'){
			ini_set('memory_limit', '512M'); /// temporal hasta optimizar consultas
	 		if($cierre == 0){
				$query1 = $this->db->query("
				select concat('noti',ubigeo) as ubigeo,
				case
				  when categoria = 0 then 'white'
				  when categoria = 3 then 'red'
				  when categoria = 2 then 'yellow'
				  when categoria = 1 then 'green'
				end as categoria
				from
					(select y.*,
					case
					when y.incidencia = 0 then 0
					when y.incidencia between 1 and $q1 then 1
					when y.incidencia between $q1 + 1 and $q2 then 2
					when y.incidencia between $q2 + 1 and $q3 then 3
					end as categoria
					from
					(select a.ano, a.ubigeo, ifnull(b.cantidad,0) as incidencia 
					from 
					(select ano, ubigeo, pobtot as poblacion from codubi where ano = $agnio and substr(ubigeo,1,2) = $nivel) a, 
					(select ano, ubigeo, count(ubigeo) as cantidad 
					from individual where diagnostic = '".$diagno."' and substr(ubigeo,1,2) = $nivel and ano = $agnio 
					and ano <> 0 and ubigeo <> '999999' group by ano, ubigeo) b 
					where a.ano = b.ano and a.ubigeo = b.ubigeo 
					group by a.ubigeo 
					order by incidencia) y) k;
				");
		  	}elseif($cierre <> 0){
				$query1 = $this->db->query("
				select concat('noti',ubigeo) as ubigeo,
				case
				  when categoria = 0 then 'white'
				  when categoria = 3 then 'red'
				  when categoria = 2 then 'yellow'
				  when categoria = 1 then 'green'
				end as categoria
				from
					(select y.*,
					case
					when y.incidencia = 0 then 0
					when y.incidencia between 1 and $q1 then 1
					when y.incidencia between $q1 + 1 and $q2 then 2
					when y.incidencia between $q2 + 1 and $q3 then 3
					end as categoria
					from
					(select a.ano, a.ubigeo, ifnull(b.cantidad,0) as incidencia 
					from 
					(select ano, ubigeo, pobtot as poblacion from codubi where ano = $agnio and substr(ubigeo,1,2) = $nivel) a, 
					(select ano, ubigeo, count(ubigeo) as cantidad 
					from individual_ant where diagnostic = '".$diagno."' and substr(ubigeo,1,2) = $nivel and ano = $agnio 
					and ano <> 0 and ubigeo <> '999999' group by ano, ubigeo) b 
					where a.ano = b.ano and a.ubigeo = b.ubigeo 
					group by a.ubigeo 
					order by incidencia) y) k;
				");
			}
			$resultado2 = $query1->result();
			$query1->free_result();
			return $resultado2;
		}
	}

	public function totalIndividualLeyenda($anio, $diagno)
	{
		$agnio = $anio;
		$diagno = $diagno;
		
		$query = $this->db->query("
		select * from estratos where enfermedad = '".$diagno."'");
		$resultado = $query->result();
		$query->free_result();

		foreach($resultado as $valor)
		{
			$enf = $valor->enfermedad;
			
			$q1 = $valor->estrato_1;
			
			$q2 = $valor->estrato_2;
	
			$q3 = $valor->estrato_3;
			
			$q4 = $valor->estrato_4;

			$q5 = $valor->estrato_5;
			
			$proceso = $valor->tipo;

			$habitantes = $valor->habitantes;
		}
		
		if($proceso == '2'){
			$array = array('enf' => $enf, 'q1' => $q1, 'q2' => $q2, 'q3' => $q3, 'q4' => $q4, 'q5' => $q5, 'proceso' => $proceso, 'hab' => $habitantes);
			return $array;
		}elseif($proceso == '1'){
			$array = array('enf' => $enf, 'q1' => $q1, 'q2' => $q2, 'proceso' => $proceso, 'hab' => $habitantes);
			return $array;
		}elseif($proceso == '3'){
			$array = array('enf' => $enf, 'q1' => $q1, 'q2' => $q2, 'q3' => $q3, 'proceso' => $proceso, 'hab' => $habitantes);
			return $array;
		}
	}

	public function departamentoIndividualLeyenda($anio, $diagno, $nivel)
	{
		$agnio = $anio;
		$diagno = $diagno;
		
		$query = $this->db->query("
		select * from estratos where enfermedad = '".$diagno."'");
		$resultado = $query->result();
		$query->free_result();

		foreach($resultado as $valor)
		{
			$enf = $valor->enfermedad;
			
			$q1 = $valor->estrato_1;
			
			$q2 = $valor->estrato_2;
	
			$q3 = $valor->estrato_3;
			
			$q4 = $valor->estrato_4;

			$q5 = $valor->estrato_5;
			
			$proceso = $valor->tipo;

			$habitantes = $valor->habitantes;
		}
		
		if($proceso == '2'){
			$array = array('enf' => $enf, 'q1' => $q1, 'q2' => $q2, 'q3' => $q3, 'q4' => $q4, 'q5' => $q5, 'proceso' => $proceso, 'hab' => $habitantes);
			return $array;
		}elseif($proceso == '1'){
			$array = array('enf' => $enf, 'q1' => $q1, 'q2' => $q2, 'proceso' => $proceso, 'hab' => $habitantes);
			return $array;
		}elseif($proceso == '3'){
			$array = array('enf' => $enf, 'q1' => $q1, 'q2' => $q2, 'q3' => $q3, 'proceso' => $proceso, 'hab' => $habitantes);
			return $array;
		}
	}

	public function totalEdas($anio, $diagno)
	{
		set_time_limit(180);
		
		$agnio = $anio;
		$diagno = $diagno;
		$semana = date("W")-1;		
		
		ini_set('memory_limit', '512M'); /// temporal hasta optimizar consultas
		$query = $this->db->query("
		select * from estratos where enfermedad = '".$diagno."' and semana = '".$semana."'");
		$resultado = $query->result();
		$query->free_result();

		foreach($resultado as $valor)
		{
			$q1 = $valor->estrato_1;
			
			$q2 = $valor->estrato_2;
	
			$q3 = $valor->estrato_3;
			
			$q4 = $valor->estrato_4;

			$q5 = $valor->estrato_5;
			
			$proceso = $valor->tipo;

			$habitantes = $valor->habitantes;
		}
		
		$cierre = $this->frontend_model->buscaCierre($agnio);
		
 		if($cierre == 0){
			$query1 = $this->db->query("
			select concat('noti',ubigeo) as ubigeo,
			case
			  when categoria = 0 then 'white'
			  when categoria = 5 then 'brown'
			  when categoria = 4 then 'red'
			  when categoria = 3 then 'pink'
			  when categoria = 2 then 'yellow'
			  when categoria = 1 then 'green'
			end as categoria
			from
				(select y.*,
				case
				when y.incidencia = 0 then 0
				when y.incidencia between 0 and $q1 then 1
				when y.incidencia between $q1 + 0.001 and $q2 then 2
				when y.incidencia between $q2 + 0.001 and $q3 then 3
				when y.incidencia between $q3 + 0.001 and $q4 then 4
				when y.incidencia >= $q5 + 0.001 then 5
				end as categoria
				from
				(select a.ano, a.ubigeo, round((ifnull(b.cantidad,0) / a.poblacion) * 1000,2) as incidencia
				from
				(select ano, ubigeo, pobtot as poblacion from codubi where ano = $agnio) a,
				(select ano, ubigeo, sum(daa_c1+daa_c1_4+daa_c5+dis_c1+dis_c1_4+dis_c5) as cantidad
				from edas where ano = $agnio and ubigeo <> '999999' group by ano, ubigeo) b
				where a.ano = b.ano and a.ubigeo = b.ubigeo
				group by a.ubigeo
				order by incidencia
				) y) k;
			");
		}elseif($cierre <> 0){
			$query1 = $this->db->query("
			select concat('noti',ubigeo) as ubigeo,
			case
			  when categoria = 0 then 'white'
			  when categoria = 5 then 'brown'
			  when categoria = 4 then 'red'
			  when categoria = 3 then 'pink'
			  when categoria = 2 then 'yellow'
			  when categoria = 1 then 'green'
			end as categoria
			from
				(select y.*,
				case
				when y.incidencia = 0 then 0
				when y.incidencia between 0 and $q1 then 1
				when y.incidencia between $q1 + 0.001 and $q2 then 2
				when y.incidencia between $q2 + 0.001 and $q3 then 3
				when y.incidencia between $q3 + 0.001 and $q4 then 4
				when y.incidencia >= $q5 + 0.001 then 5
				end as categoria
				from
				(select a.ano, a.ubigeo, round((ifnull(b.cantidad,0) / a.poblacion) * 1000,2) as incidencia
				from
				(select ano, ubigeo, pobtot as poblacion from codubi where ano = $agnio) a,
				(select ano, ubigeo, sum(daa_c1+daa_c1_4+daa_c5+dis_c1+dis_c1_4+dis_c5) as cantidad
				from edas_ant where ano = $agnio and ano <> 0 and ubigeo <> '999999' group by ano, ubigeo) b
				where a.ano = b.ano and a.ubigeo = b.ubigeo
				group by a.ubigeo
				order by incidencia
				) y) k;
			");
		}
		$resultado2 = $query1->result();
		$query1->free_result();
		return $resultado2;
	}

	public function departamentoEdas($anio, $diagno, $nivel)
	{
		set_time_limit(180);
		
		$agnio = $anio;
		$diagno = $diagno;
		$semana = date("W")-1;		
		
		ini_set('memory_limit', '512M'); /// temporal hasta optimizar consultas
		$query = $this->db->query("
		select * from estratos where enfermedad = '".$diagno."' and semana = '".$semana."'");
		$resultado = $query->result();
		$query->free_result();

		foreach($resultado as $valor)
		{
			$q1 = $valor->estrato_1;
			
			$q2 = $valor->estrato_2;
	
			$q3 = $valor->estrato_3;
			
			$q4 = $valor->estrato_4;

			$q5 = $valor->estrato_5;
			
			$proceso = $valor->tipo;

			$habitantes = $valor->habitantes;
		}

		$cierre = $this->frontend_model->buscaCierre($agnio);
		
 		if($cierre == 0){
			$query1 = $this->db->query("
			select concat('noti',ubigeo) as ubigeo,
			case
			  when categoria = 0 then 'white'
			  when categoria = 5 then 'brown'
			  when categoria = 4 then 'red'
			  when categoria = 3 then 'pink'
			  when categoria = 2 then 'yellow'
			  when categoria = 1 then 'green'
			end as categoria
			from
				(select y.*,
				case
				when y.incidencia = 0 then 0
				when y.incidencia between 0 and $q1 then 1
				when y.incidencia between $q1 + 0.001 and $q2 then 2
				when y.incidencia between $q2 + 0.001 and $q3 then 3
				when y.incidencia between $q3 + 0.001 and $q4 then 4
				when y.incidencia >= $q5 + 0.001 then 5
				end as categoria
				from
				(select a.ano, a.ubigeo, round((ifnull(b.cantidad,0) / a.poblacion) * 1000,2) as incidencia
				from
				(select ano, ubigeo, pobtot as poblacion from codubi where ano = $agnio and substr(ubigeo,1,2) = $nivel) a,
				(select ano, ubigeo, sum(daa_c1+daa_c1_4+daa_c5+dis_c1+dis_c1_4+dis_c5) as cantidad
				from edas where ano = $agnio and substr(ubigeo,1,2) = $nivel and ano <> 0 and ubigeo <> '999999' group by ano, ubigeo) b
				where a.ano = b.ano and a.ubigeo = b.ubigeo
				group by a.ubigeo
				order by incidencia
				) y) k;
			");
		}elseif($cierre <> 0){
			$query1 = $this->db->query("
			select concat('noti',ubigeo) as ubigeo,
			case
			  when categoria = 0 then 'white'
			  when categoria = 5 then 'brown'
			  when categoria = 4 then 'red'
			  when categoria = 3 then 'pink'
			  when categoria = 2 then 'yellow'
			  when categoria = 1 then 'green'
			end as categoria
			from
				(select y.*,
				case
				when y.incidencia = 0 then 0
				when y.incidencia between 0 and $q1 then 1
				when y.incidencia between $q1 + 0.001 and $q2 then 2
				when y.incidencia between $q2 + 0.001 and $q3 then 3
				when y.incidencia between $q3 + 0.001 and $q4 then 4
				when y.incidencia >= $q5 + 0.001 then 5
				end as categoria
				from
				(select a.ano, a.ubigeo, round((ifnull(b.cantidad,0) / a.poblacion) * 1000,2) as incidencia
				from
				(select ano, ubigeo, pobtot as poblacion from codubi where ano = $agnio and substr(ubigeo,1,2) = $nivel) a,
				(select ano, ubigeo, sum(daa_c1+daa_c1_4+daa_c5+dis_c1+dis_c1_4+dis_c5) as cantidad
				from edas_ant where ano = $agnio and substr(ubigeo,1,2) = $nivel and ano <> 0 and ubigeo <> '999999' group by ano, ubigeo) b
				where a.ano = b.ano and a.ubigeo = b.ubigeo
				group by a.ubigeo
				order by incidencia
				) y) k;
			");
		}
		$resultado2 = $query1->result();
		$query1->free_result();
		return $resultado2;
	}

	public function totalEdasLeyenda($anio, $diagno, $nivel)
	{
		$agnio = $anio;
		$diagno = $diagno;
		$semana = date("W")-1;		
		
		$query = $this->db->query("
		select * from estratos where enfermedad = '".$diagno."' and semana = '".$semana."'");
		$resultado = $query->result();
		$query->free_result();

		foreach($resultado as $valor)
		{
			$enf = $valor->enfermedad;
			
			$q1 = $valor->estrato_1;
			
			$q2 = $valor->estrato_2;
	
			$q3 = $valor->estrato_3;
			
			$q4 = $valor->estrato_4;

			$q5 = $valor->estrato_5;
			
			$proceso = $valor->tipo;

			$habitantes = $valor->habitantes;
		}
		
		$array = array('enf' => $enf, 'q1' => $q1, 'q2' => $q2, 'q3' => $q3, 'q4' => $q4, 'q5' => $q5, 'proceso' => $proceso, 'hab' => $habitantes);
		return $array;
	}

	public function departamentoEdasLeyenda($anio, $diagno)
	{
		$agnio = $anio;
		$diagno = $diagno;
		$semana = date("W")-1;		
		
		$query = $this->db->query("
		select * from estratos where enfermedad = '".$diagno."' and semana = '".$semana."'");
		$resultado = $query->result();
		$query->free_result();

		foreach($resultado as $valor)
		{
			$enf = $valor->enfermedad;
			
			$q1 = $valor->estrato_1;
			
			$q2 = $valor->estrato_2;
	
			$q3 = $valor->estrato_3;
			
			$q4 = $valor->estrato_4;

			$q5 = $valor->estrato_5;
			
			$proceso = $valor->tipo;

			$habitantes = $valor->habitantes;
		}
		
		$array = array('enf' => $enf, 'q1' => $q1, 'q2' => $q2, 'q3' => $q3, 'q4' => $q4, 'q5' => $q5, 'proceso' => $proceso, 'hab' => $habitantes);
		return $array;
	}

	public function totalNeumonias($anio, $diagno)
	{
		set_time_limit(180);
		
		$agnio = $anio;
		$diagno = $diagno;
		$semana = date("W")-1;		
		
		ini_set('memory_limit', '512M'); /// temporal hasta optimizar consultas
		$query = $this->db->query("
		select * from estratos where enfermedad = '".$diagno."' and semana = $semana");
		$resultado = $query->result();
		$query->free_result();

		foreach($resultado as $valor)
		{
			$q1 = $valor->estrato_1;
			
			$q2 = $valor->estrato_2;
	
			$q3 = $valor->estrato_3;
			
			$q4 = $valor->estrato_4;

			$q5 = $valor->estrato_5;
			
			$proceso = $valor->tipo;

			$habitantes = $valor->habitantes;
		}

		$cierre = $this->frontend_model->buscaCierre($agnio);
		
 		if($cierre == 0){
			$query1 = $this->db->query("
			select concat('noti',ubigeo) as ubigeo,
			case
			  when categoria = 0 then 'white'
			  when categoria = 4 then 'red'
			  when categoria = 3 then 'pink'
			  when categoria = 2 then 'yellow'
			  when categoria = 1 then 'green'
			end as categoria
			from
				(select y.*,
				case
				when y.incidencia = 0 then 0
				when y.incidencia between 0 and $q1 then 1
				when y.incidencia between $q1 + 0.001 and $q2 then 2
				when y.incidencia between $q2 + 0.001 and $q3 then 3
				when y.incidencia >= $q4 then 4
				end as categoria
				from
				(select a.ano, a.ubigeo, round((ifnull(b.cantidad,0) / a.poblacion) * 1000,2) as incidencia
				from
				(select ano, ubigeo, pobtot as poblacion from codubi where ano = $agnio) a,
				(select ano, ubigeo, sum(neu_2_11+neu_1_4a+ngr_m2+ngr_2_11+ngr_1_4a) as cantidad
				from iras where ano = $agnio and ano <> 0 and ubigeo <> '999999' group by ano, ubigeo) b
				where a.ano = b.ano and a.ubigeo = b.ubigeo
				group by a.ubigeo
				order by incidencia
				) y) k;
			");
		}elseif($cierre <> 0){
			$query1 = $this->db->query("
			select concat('noti',ubigeo) as ubigeo,
			case
			  when categoria = 0 then 'white'
			  when categoria = 4 then 'red'
			  when categoria = 3 then 'pink'
			  when categoria = 2 then 'yellow'
			  when categoria = 1 then 'green'
			end as categoria
			from
				(select y.*,
				case
				when y.incidencia = 0 then 0
				when y.incidencia between 0 and $q1 then 1
				when y.incidencia between $q1 + 0.001 and $q2 then 2
				when y.incidencia between $q2 + 0.001 and $q3 then 3
				when y.incidencia >= $q4 then 4
				end as categoria
				from
				(select a.ano, a.ubigeo, round((ifnull(b.cantidad,0) / a.poblacion) * 1000,2) as incidencia
				from
				(select ano, ubigeo, pobtot as poblacion from codubi where ano = $agnio) a,
				(select ano, ubigeo, sum(neu_2_11+neu_1_4a+ngr_m2+ngr_2_11+ngr_1_4a) as cantidad
				from iras_ant where ano = $agnio and ano <> 0 and ubigeo <> '999999' group by ano, ubigeo) b
				where a.ano = b.ano and a.ubigeo = b.ubigeo
				group by a.ubigeo
				order by incidencia
				) y) k;
			");
		}
		$resultado2 = $query1->result();
		$query1->free_result();
		return $resultado2;
	}

	public function departamentoNeumonias($anio, $diagno, $nivel)
	{
		set_time_limit(180);
		
		$agnio = $anio;
		$diagno = $diagno;
		$semana = date("W")-1;		
		
		ini_set('memory_limit', '512M'); /// temporal hasta optimizar consultas
		$query = $this->db->query("
		select * from estratos where enfermedad = '".$diagno."' and semana = $semana");
		$resultado = $query->result();
		$query->free_result();

		foreach($resultado as $valor)
		{
			$q1 = $valor->estrato_1;
			
			$q2 = $valor->estrato_2;
	
			$q3 = $valor->estrato_3;
			
			$q4 = $valor->estrato_4;

			$q5 = $valor->estrato_5;
			
			$proceso = $valor->tipo;

			$habitantes = $valor->habitantes;
		}

		$cierre = $this->frontend_model->buscaCierre($agnio);
		
 		if($cierre == 0){
			$query1 = $this->db->query("
			select concat('noti',ubigeo) as ubigeo,
			case
			  when categoria = 0 then 'white'
			  when categoria = 4 then 'red'
			  when categoria = 3 then 'pink'
			  when categoria = 2 then 'yellow'
			  when categoria = 1 then 'green'
			end as categoria
			from
				(select y.*,
				case
				when y.incidencia = 0 then 0
				when y.incidencia between 0 and $q1 then 1
				when y.incidencia between $q1 + 0.001 and $q2 then 2
				when y.incidencia between $q2 + 0.001 and $q3 then 3
				when y.incidencia >= $q4 then 4
				end as categoria
				from
				(select a.ano, a.ubigeo, round((ifnull(b.cantidad,0) / a.poblacion) * 1000,2) as incidencia
				from
				(select ano, ubigeo, pobtot as poblacion from codubi where ano = $agnio and substr(ubigeo,1,2) = $nivel) a,
				(select ano, ubigeo, sum(neu_2_11+neu_1_4a+ngr_m2+ngr_2_11+ngr_1_4a) as cantidad
				from iras where ano = $agnio and substr(ubigeo,1,2) = $nivel and ano <> 0 and ubigeo <> '999999' group by ano, ubigeo) b
				where a.ano = b.ano and a.ubigeo = b.ubigeo
				group by a.ubigeo
				order by incidencia
				) y) k;
			");
		}elseif($cierre <> 0){
			$query1 = $this->db->query("
			select concat('noti',ubigeo) as ubigeo,
			case
			  when categoria = 0 then 'white'
			  when categoria = 4 then 'red'
			  when categoria = 3 then 'pink'
			  when categoria = 2 then 'yellow'
			  when categoria = 1 then 'green'
			end as categoria
			from
				(select y.*,
				case
				when y.incidencia = 0 then 0
				when y.incidencia between 0 and $q1 then 1
				when y.incidencia between $q1 + 0.001 and $q2 then 2
				when y.incidencia between $q2 + 0.001 and $q3 then 3
				when y.incidencia >= $q4 then 4
				end as categoria
				from
				(select a.ano, a.ubigeo, round((ifnull(b.cantidad,0) / a.poblacion) * 1000,2) as incidencia
				from
				(select ano, ubigeo, pobtot as poblacion from codubi where ano = $agnio and substr(ubigeo,1,2) = $nivel) a,
				(select ano, ubigeo, sum(neu_2_11+neu_1_4a+ngr_m2+ngr_2_11+ngr_1_4a) as cantidad
				from iras_ant where ano = $agnio and substr(ubigeo,1,2) = $nivel and ano <> 0 and ubigeo <> '999999' group by ano, ubigeo) b
				where a.ano = b.ano and a.ubigeo = b.ubigeo
				group by a.ubigeo
				order by incidencia
				) y) k;
			");
		}
		$resultado2 = $query1->result();
		$query1->free_result();
		return $resultado2;
	}

	public function totalNeumoniasLeyenda($anio, $diagno)
	{
		$agnio = $anio;
		$diagno = $diagno;
		$semana = date("W")-1;		
		
		$query = $this->db->query("
		select * from estratos where enfermedad = '".$diagno."' and semana = '".$semana."'");
		$resultado = $query->result();
		$query->free_result();

		foreach($resultado as $valor)
		{
			$enf = $valor->enfermedad;
			
			$q1 = $valor->estrato_1;
			
			$q2 = $valor->estrato_2;
	
			$q3 = $valor->estrato_3;
			
			$q4 = $valor->estrato_4;

			$q5 = $valor->estrato_5;
			
			$proceso = $valor->tipo;

			$habitantes = $valor->habitantes;
		}
		
		$array = array('enf' => $enf, 'q1' => $q1, 'q2' => $q2, 'q3' => $q3, 'q4' => $q4, 'q5' => $q5, 'proceso' => $proceso, 'hab' => $habitantes);
		return $array;
	}

	public function departamentoNeumoniasLeyenda($anio, $diagno)
	{
		$agnio = $anio;
		$diagno = $diagno;
		$semana = date("W")-1;		
		
		$query = $this->db->query("
		select * from estratos where enfermedad = '".$diagno."' and semana = '".$semana."'");
		$resultado = $query->result();
		$query->free_result();

		foreach($resultado as $valor)
		{
			$enf = $valor->enfermedad;
			
			$q1 = $valor->estrato_1;
			
			$q2 = $valor->estrato_2;
	
			$q3 = $valor->estrato_3;
			
			$q4 = $valor->estrato_4;

			$q5 = $valor->estrato_5;
			
			$proceso = $valor->tipo;

			$habitantes = $valor->habitantes;
		}
		
		$array = array('enf' => $enf, 'q1' => $q1, 'q2' => $q2, 'q3' => $q3, 'q4' => $q4, 'q5' => $q5, 'proceso' => $proceso, 'hab' => $habitantes);
		return $array;
	}
}
?>