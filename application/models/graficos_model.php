<?php
class graficos_model extends CI_Model{
    function __construct() {
        parent::__construct();
    }
	
	//Modelo para generar los gráficos de Edas en el nivel NACIONAL
    	
	public function totalEdas($anio)
	{
		$agnio = $anio;
		$semana = date("W")-1;		
		
		ini_set('memory_limit', '512M'); /// temporal hasta optimizar consultas
		if($agnio == date("Y")){
			$query1 = $this->db->query("
			select a.semana, a.cantidad as incidencia
			from
			(select ano, semana, sum(daa_c1+daa_c1_4+daa_c5+dis_c1+dis_c1_4+dis_c5) as cantidad
			from edas where ano <> 0 and ubigeo <> '999999' group by ano, semana
			union all
			select ano, semana, sum(daa_c1+daa_c1_4+daa_c5+dis_c1+dis_c1_4+dis_c5) as cantidad
			from edas_ant where ano >= $agnio-2 and ano <> 0 and ubigeo <> '999999' group by ano, semana) a
			order by a.ano, a.semana
			");
		}elseif($agnio < date("Y")){
			$query1 = $this->db->query("
			select a.semana, a.cantidad as incidencia
			from
			(select ano, semana, sum(daa_c1+daa_c1_4+daa_c5+dis_c1+dis_c1_4+dis_c5) as cantidad
			from edas_ant where ano <= $agnio and ano > $agnio-2 and ano <> 0 and ubigeo <> '999999' 
			group by ano, semana) a
			order by a.ano, a.semana
			");
		}
		$resultado2 = $query1->result();
		$query1->free_result();
		return $resultado2;
	}

	public function totalEdasAnos($anio)
	{
		$agnio = $anio;
		
		ini_set('memory_limit', '512M'); /// temporal hasta optimizar consultas
		if($agnio == date("Y")){
			$query1 = $this->db->query("
			select a.ano, a.cantidad as incidencia
			from
			(select ano, sum(daa_c1+daa_c1_4+daa_c5+dis_c1+dis_c1_4+dis_c5) as cantidad
			from edas where ano <> 0 and ubigeo <> '999999' group by ano
			union all
			select ano, sum(daa_c1+daa_c1_4+daa_c5+dis_c1+dis_c1_4+dis_c5) as cantidad
			from edas_ant where ano >= $agnio-9 and ano <> 0 and ubigeo <> '999999' 
			group by ano
			) a
			left join
			(select ano, sum(pobtot) as poblacion from codubi where ano >= $agnio-9 group by ano) b
			on a.ano = b.ano
			group by a.ano
			order by a.ano
			");
		}elseif($agnio < date("Y")){
			$query1 = $this->db->query("
			select a.ano, a.cantidad as incidencia
			from
			(select ano, sum(daa_c1+daa_c1_4+daa_c5+dis_c1+dis_c1_4+dis_c5) as cantidad
			from edas_ant where ano >= $agnio-9 and ano <> 0 and ubigeo <> '999999' 
			group by ano
			) a
			left join
			(select ano, sum(pobtot) as poblacion from codubi where ano >= $agnio-9 group by ano) b
			on a.ano = b.ano
			group by a.ano
			order by a.ano
			");
		}
		$resultado2 = $query1->result();
		$query1->free_result();
		return $resultado2;
	}

	public function nacionalCanalEndemicoEdas($anio)
	{
		
		$agnio = $anio;
		
		ini_set('memory_limit', '512M'); /// temporal hasta optimizar consultas
		$query1 = $this->db->query("
		select j.semana, IC_Inf_Casos as IC_Inf, (Media_Casos - IC_Inf_Casos) as Media_IC_Inf, (IC_Sup_Casos - Media_Casos) as IC_Sup_Media
		from
		(select semana,
		IC_Inf_tasa,
		Media_tasa,
		IC_Sup_tasa,
		round((IC_Inf_tasa * i.poblacion) / 100000,2) as IC_Inf_Casos,
		round((Media_tasa * i.poblacion) / 100000,2) as Media_Casos,
		round((IC_Sup_tasa * i.poblacion) / 100000,2) as IC_Sup_Casos
		from
		(select semana, round(exp(IC_Inf),1) as IC_Inf_tasa, round(exp(media),1) as Media_tasa, round(exp(IC_Sup),1) as IC_Sup_tasa
		from
		(select semana, media, desviacion, round(media-(f.t * desviacion) / sqrt(f.datos),1) as IC_Inf, round(media+(f.t * desviacion) / sqrt(f.datos),1) as IC_Sup
		from
		(select semana, round(avg(logaritmo),1) as media, round(std(logaritmo),1) as desviacion
		from
		(select ano, semana, incidencia, ln(incidencia) as logaritmo
		from
		(select a.ano, a.semana, round((a.cantidad / b.poblacion) * 100000+1,2) as incidencia
		from
		(select ano, semana, sum(daa_c1+dis_c1+daa_c1_4+dis_c1_4+daa_c5+dis_c5) as cantidad
		from edas_ant where ano >= 2000 and ano <= $agnio - 1 group by ano, semana) a
		left join
		(select ano, sum(pobtot) as poblacion from codubi where ano >= 2000 and ano <= $agnio - 1 group by ano) b
		on a.ano = b.ano
		group by a.ano, a.semana
		order by a.ano, a.semana) c )d
		group by semana) e, (select ano, datos, t from student where ano = year(curdate())-1) f) g) h,
		(select ano, sum(pobtot) as poblacion from codubi where ano >= 2000 and ano = $agnio - 1 group by ano) i) j
		");
		$resultado2 = $query1->result();
		$query1->free_result();
		return $resultado2;
	}
	
	public function nacionalCanalEndemicoEdasActual($anio)
	{
		
		$agnio = $anio;
		
		ini_set('memory_limit', '512M'); /// temporal hasta optimizar consultas
		if($agnio == date("Y")){
			$query1 = $this->db->query("
			select semana, sum(daa_c1+dis_c1+daa_c1_4+dis_c1_4+daa_c5+dis_c5) as cantidad
			from edas where ano = $agnio group by semana
			");
		}elseif($agnio < date("Y")){
			$query1 = $this->db->query("
			select semana, sum(daa_c1+dis_c1+daa_c1_4+dis_c1_4+daa_c5+dis_c5) as cantidad
			from edas_ant where ano = $agnio group by semana
			");
		}
		$resultado2 = $query1->result();
		$query1->free_result();
		return $resultado2;
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////
	
	public function departamentoTotalEdas($anio, $nivel)
	{
		$agnio = $anio;
		$semana = date("W")-1;		
		
		ini_set('memory_limit', '512M'); /// temporal hasta optimizar consultas
		if($agnio == date("Y")){
			$query1 = $this->db->query("
			select a.semana, a.cantidad as incidencia
			from
			(select ano, semana, sum(daa_c1+daa_c1_4+daa_c5+dis_c1+dis_c1_4+dis_c5) as cantidad
			from edas where ano <> 0 and ubigeo <> '999999' and substr(ubigeo, 1, 2) = $nivel group by ano, semana
			union all
			select ano, semana, sum(daa_c1+daa_c1_4+daa_c5+dis_c1+dis_c1_4+dis_c5) as cantidad
			from edas_ant where ano >= $agnio-2 and ano <> 0 and ubigeo <> '999999' and substr(ubigeo, 1, 2) = $nivel
			group by ano, semana order by ano, semana) a
			order by a.ano, a.semana
			");
		}elseif($agnio < date("Y")){
			$query1 = $this->db->query("
			select a.semana, a.cantidad as incidencia
			from
			(select ano, semana, sum(daa_c1+daa_c1_4+daa_c5+dis_c1+dis_c1_4+dis_c5) as cantidad
			from edas_ant where ano >= $agnio-2 and ano <> 0 and ubigeo <> '999999' and substr(ubigeo, 1, 2) = $nivel
			group by ano, semana order by ano, semana) a
			order by a.ano, a.semana
			");
		}
		$resultado2 = $query1->result();
		$query1->free_result();
		return $resultado2;
	}

	public function departamentosTotalEdasAnos($anio, $nivel)
	{
		$agnio = $anio;
		
		ini_set('memory_limit', '512M'); /// temporal hasta optimizar consultas
		if($agnio == date("Y")){
			$query1 = $this->db->query("
			select a.ano, a.cantidad as incidencia
			from
			(select ano, sum(daa_c1+daa_c1_4+daa_c5+dis_c1+dis_c1_4+dis_c5) as cantidad
			from edas where ano <> 0 and ubigeo <> '999999' and substr(ubigeo, 1, 2) = $nivel group by ano
			union all
			select ano, sum(daa_c1+daa_c1_4+daa_c5+dis_c1+dis_c1_4+dis_c5) as cantidad
			from edas_ant where ano >= $agnio-9 and ano <> 0 and ubigeo <> '999999' and substr(ubigeo, 1, 2) = $nivel group by ano		) a
			left join
			(select ano, sum(pobtot) as poblacion from codubi where ano >= $agnio-9 and substr(ubigeo, 1, 2) = $nivel group by ano) b
			on a.ano = b.ano
			group by a.ano
			order by a.ano
			");
		}elseif($agnio < date("Y")){
			$query1 = $this->db->query("
			select a.ano, a.cantidad as incidencia
			from
			(select ano, sum(daa_c1+daa_c1_4+daa_c5+dis_c1+dis_c1_4+dis_c5) as cantidad
			from edas_ant where ano >= $agnio-9 and ano <> 0 and ubigeo <> '999999' and substr(ubigeo, 1, 2) = $nivel group by ano		) a
			left join
			(select ano, sum(pobtot) as poblacion from codubi where ano >= $agnio-9 and substr(ubigeo, 1, 2) = $nivel group by ano) b
			on a.ano = b.ano
			group by a.ano
			order by a.ano
			");
		}
		$resultado2 = $query1->result();
		$query1->free_result();
		return $resultado2;
	}

	public function departamentosCanalEndemicoEdas($anio, $nivel)
	{
		
		$agnio = $anio;
		
		ini_set('memory_limit', '512M'); /// temporal hasta optimizar consultas
		$query1 = $this->db->query("
		select j.semana, IC_Inf_Casos as IC_Inf, (Media_Casos - IC_Inf_Casos) as Media_IC_Inf, (IC_Sup_Casos - Media_Casos) as IC_Sup_Media
		from
		(select semana,
		IC_Inf_tasa,
		Media_tasa,
		IC_Sup_tasa,
		round((IC_Inf_tasa * i.poblacion) / 100000,2) as IC_Inf_Casos,
		round((Media_tasa * i.poblacion) / 100000,2) as Media_Casos,
		round((IC_Sup_tasa * i.poblacion) / 100000,2) as IC_Sup_Casos
		from
		(select semana, round(exp(IC_Inf),1) as IC_Inf_tasa, round(exp(media),1) as Media_tasa, round(exp(IC_Sup),1) as IC_Sup_tasa
		from
		(select semana, media, desviacion, round(media-(f.t * desviacion) / sqrt(f.datos),1) as IC_Inf, round(media+(f.t * desviacion) / sqrt(f.datos),1) as IC_Sup
		from
		(select semana, round(avg(logaritmo),1) as media, round(std(logaritmo),1) as desviacion
		from
		(select ano, semana, incidencia, ln(incidencia) as logaritmo
		from
		(select a.ano, a.semana, round((a.cantidad / b.poblacion) * 100000+1,2) as incidencia
		from
		(select ano, semana, sum(daa_c1+dis_c1+daa_c1_4+dis_c1_4+daa_c5+dis_c5) as cantidad
		from edas_ant where ano >= 2000 and ano <= $agnio - 1 and substr(ubigeo, 1, 2) = $nivel group by ano, semana) a
		left join
		(select ano, sum(pobtot) as poblacion from codubi where ano >= 2000 and ano <= $agnio - 1 and substr(ubigeo, 1, 2) = $nivel group by ano) b
		on a.ano = b.ano
		group by a.ano, a.semana
		order by a.ano, a.semana) c )d
		group by semana) e, (select ano, datos, t from student where ano = year(curdate())-1) f) g) h,
		(select ano, sum(pobtot) as poblacion from codubi where ano >= 2000 and ano = $agnio - 1 and substr(ubigeo, 1, 2) = $nivel group by ano) i) j
		");
		$resultado2 = $query1->result();
		$query1->free_result();
		return $resultado2;
	}
	
	public function departamentosCanalEndemicoEdasActual($anio, $nivel)
	{
		
		$agnio = $anio;
		
		ini_set('memory_limit', '512M'); /// temporal hasta optimizar consultas
		if($agnio == date("Y")){
			$query1 = $this->db->query("
			select semana, sum(daa_c1+dis_c1+daa_c1_4+dis_c1_4+daa_c5+dis_c5) as cantidad
			from edas where ano = $agnio and substr(ubigeo, 1, 2) = $nivel group by semana
			");
		}elseif($agnio < date("Y")){
			$query1 = $this->db->query("
			select semana, sum(daa_c1+dis_c1+daa_c1_4+dis_c1_4+daa_c5+dis_c5) as cantidad
			from edas_ant where ano = $agnio and substr(ubigeo, 1, 2) = $nivel group by semana
			");
		}
		$resultado2 = $query1->result();
		$query1->free_result();
		return $resultado2;
	}

	//Modelo para general los gráficos de Iras
    	
	public function totalIras($anio)
	{
		$agnio = $anio;
		$semana = date("W")-1;		
		
		ini_set('memory_limit', '512M'); /// temporal hasta optimizar consultas
		if($agnio == date("Y")){
			$query1 = $this->db->query("
			select a.semana, a.cantidad as incidencia
			from
			(select ano, semana, sum(neu_2_11+neu_1_4a+ngr_m2+ngr_2_11+ngr_1_4a) as cantidad
			from iras where ano <> 0 and ubigeo <> '999999' group by ano, semana
			union all
			select ano, semana, sum(neu_2_11+neu_1_4a+ngr_m2+ngr_2_11+ngr_1_4a) as cantidad
			from iras_ant where ano >= $agnio-2 and ano <> 0 and ubigeo <> '999999' group by ano, semana) a
			order by a.ano, a.semana
			");
		}elseif($agnio < date("Y")){
			$query1 = $this->db->query("
			select a.semana, a.cantidad as incidencia
			from
			(select ano, semana, sum(neu_2_11+neu_1_4a+ngr_m2+ngr_2_11+ngr_1_4a) as cantidad
			from iras_ant where ano >= $agnio-2 and ano <> 0 and ubigeo <> '999999' group by ano, semana) a
			order by a.ano, a.semana
			");
		}
		$resultado2 = $query1->result();
		$query1->free_result();
		return $resultado2;
	}

	public function totalIrasAnos($anio)
	{
		$agnio = $anio;
		
		ini_set('memory_limit', '512M'); /// temporal hasta optimizar consultas
		if($agnio == date("Y")){
			$query1 = $this->db->query("
			select a.ano, a.cantidad as incidencia
			from
			(select ano, sum(neu_2_11+neu_1_4a+ngr_m2+ngr_2_11+ngr_1_4a) as cantidad
			from iras where ano <> 0 and ubigeo <> '999999' group by ano
			union all
			select ano, sum(neu_2_11+neu_1_4a+ngr_m2+ngr_2_11+ngr_1_4a) as cantidad
			from iras_ant where ano >= $agnio-9 and ano <> 0 and ubigeo <> '999999' group by ano) a
			left join
			(select ano, sum(pobtot) as poblacion from codubi where ano >= $agnio-9 group by ano) b
			on a.ano = b.ano
			group by a.ano
			order by a.ano
			");
		}elseif($agnio < date("Y")){
			$query1 = $this->db->query("
			select a.ano, a.cantidad as incidencia
			from
			(select ano, sum(neu_2_11+neu_1_4a+ngr_m2+ngr_2_11+ngr_1_4a) as cantidad
			from iras_ant where ano >= $agnio-9 and ano <> 0 and ubigeo <> '999999' group by ano) a
			left join
			(select ano, sum(pobtot) as poblacion from codubi where ano >= $agnio-9 group by ano) b
			on a.ano = b.ano
			group by a.ano
			order by a.ano
			");
		}
		$resultado2 = $query1->result();
		$query1->free_result();
		return $resultado2;
	}

	public function nacionalCanalEndemicoIras($anio)
	{
		
		$agnio = $anio;
		
		ini_set('memory_limit', '512M'); /// temporal hasta optimizar consultas
		$query1 = $this->db->query("
		select j.semana, IC_Inf_Casos as IC_Inf, (Media_Casos - IC_Inf_Casos) as Media_IC_Inf, (IC_Sup_Casos - Media_Casos) as IC_Sup_Media
		from
		(select semana,
		IC_Inf_tasa,
		Media_tasa,
		IC_Sup_tasa,
		round((IC_Inf_tasa * i.poblacion) / 100000,2) as IC_Inf_Casos,
		round((Media_tasa * i.poblacion) / 100000,2) as Media_Casos,
		round((IC_Sup_tasa * i.poblacion) / 100000,2) as IC_Sup_Casos
		from
		(select semana, round(exp(IC_Inf),1) as IC_Inf_tasa, round(exp(media),1) as Media_tasa, round(exp(IC_Sup),1) as IC_Sup_tasa
		from
		(select semana, media, desviacion, round(media-(f.t * desviacion) / sqrt(f.datos),1) as IC_Inf, round(media+(f.t * desviacion) / sqrt(f.datos),1) as IC_Sup
		from
		(select semana, round(avg(logaritmo),1) as media, round(std(logaritmo),1) as desviacion
		from
		(select ano, semana, incidencia, ln(incidencia) as logaritmo
		from
		(select a.ano, a.semana, round((a.cantidad / b.poblacion) * 100000+1,2) as incidencia
		from
		(select ano, semana, sum(neu_2_11+neu_1_4a+ngr_m2+ngr_2_11+ngr_1_4a) as cantidad
		from iras_ant where ano >= 2000 and ano <= $agnio - 1 group by ano, semana) a
		left join
		(select ano, sum(pobtot) as poblacion from codubi where ano >= 2000 and ano <= $agnio - 1 group by ano) b
		on a.ano = b.ano
		group by a.ano, a.semana
		order by a.ano, a.semana) c )d
		group by semana) e, (select ano, datos, t from student where ano = year(curdate())-1) f) g) h,
		(select ano, sum(pobtot) as poblacion from codubi where ano >= 2000 and ano = $agnio - 1 group by ano) i) j
		");
		$resultado2 = $query1->result();
		$query1->free_result();
		return $resultado2;
	}
	
	public function nacionalCanalEndemicoIrasActual($anio)
	{
		
		$agnio = $anio;
		
		ini_set('memory_limit', '512M'); /// temporal hasta optimizar consultas
		if($agnio == date("Y")){
			$query1 = $this->db->query("
			select semana, sum(neu_2_11+neu_1_4a+ngr_m2+ngr_2_11+ngr_1_4a) as cantidad
			from iras where ano = $agnio group by semana
			");
		}elseif($agnio < date("Y")){
			$query1 = $this->db->query("
			select semana, sum(neu_2_11+neu_1_4a+ngr_m2+ngr_2_11+ngr_1_4a) as cantidad
			from iras_ant where ano = $agnio group by semana
			");
		}
		$resultado2 = $query1->result();
		$query1->free_result();
		return $resultado2;
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////
	
	public function departamentostotalIras($anio, $nivel)
	{
		$agnio = $anio;
		$semana = date("W")-1;		
		
		ini_set('memory_limit', '512M'); /// temporal hasta optimizar consultas
		if($agnio == date("Y")){
			$query1 = $this->db->query("
			select a.semana, a.cantidad as incidencia
			from
			(select ano, semana, sum(neu_2_11+neu_1_4a+ngr_m2+ngr_2_11+ngr_1_4a) as cantidad
			from iras where ano <> 0 and ubigeo <> '999999' and substr(ubigeo, 1, 2) = $nivel group by ano, semana
			union all
			select ano, semana, sum(neu_2_11+neu_1_4a+ngr_m2+ngr_2_11+ngr_1_4a) as cantidad
			from iras_ant where ano >= $agnio-2 and ano <> 0 and ubigeo <> '999999' and substr(ubigeo, 1, 2) = $nivel group by ano, semana) a
			order by a.ano, a.semana
			");
		}else{
			$query1 = $this->db->query("
			select a.semana, a.cantidad as incidencia
			from
			(select ano, semana, sum(neu_2_11+neu_1_4a+ngr_m2+ngr_2_11+ngr_1_4a) as cantidad
			from iras_ant where ano >= $agnio-2 and ano <> 0 and ubigeo <> '999999' and substr(ubigeo, 1, 2) = $nivel group by ano, semana) a
			order by a.ano, a.semana
			");
		}
		$resultado2 = $query1->result();
		$query1->free_result();
		return $resultado2;
	}

	public function departamentostotalIrasAnos($anio, $nivel)
	{
		$agnio = $anio;
		
		ini_set('memory_limit', '512M'); /// temporal hasta optimizar consultas
		if($agnio == date("Y")){
			$query1 = $this->db->query("
			select a.ano, a.cantidad as incidencia
			from
			(select ano, sum(neu_2_11+neu_1_4a+ngr_m2+ngr_2_11+ngr_1_4a) as cantidad
			from iras where ano <> 0 and ubigeo <> '999999' group by ano
			union all
			select ano, sum(neu_2_11+neu_1_4a+ngr_m2+ngr_2_11+ngr_1_4a) as cantidad
			from iras_ant where ano >= $agnio-9 and ano <> 0 and ubigeo <> '999999' group by ano) a
			left join
			(select ano, sum(pobtot) as poblacion from codubi where ano >= $agnio-9 and substr(ubigeo, 1, 2) = $nivel group by ano) b
			on a.ano = b.ano
			group by a.ano
			order by a.ano
			");
		}elseif($agnio < date("Y")){
			$query1 = $this->db->query("
			select a.ano, a.cantidad as incidencia
			from
			(select ano, sum(neu_2_11+neu_1_4a+ngr_m2+ngr_2_11+ngr_1_4a) as cantidad
			from iras_ant where ano >= $agnio-9 and ano <> 0 and ubigeo <> '999999' group by ano) a
			left join
			(select ano, sum(pobtot) as poblacion from codubi where ano >= $agnio-9 and substr(ubigeo, 1, 2) = $nivel group by ano) b
			on a.ano = b.ano
			group by a.ano
			order by a.ano
			");
		}
		$resultado2 = $query1->result();
		$query1->free_result();
		return $resultado2;
	}

	public function departamentosCanalEndemicoIras($anio, $nivel)
	{
		
		$agnio = $anio;
		
		ini_set('memory_limit', '512M'); /// temporal hasta optimizar consultas
		$query1 = $this->db->query("
		select j.semana, IC_Inf_Casos as IC_Inf, (Media_Casos - IC_Inf_Casos) as Media_IC_Inf, (IC_Sup_Casos - Media_Casos) as IC_Sup_Media
		from
		(select semana,
		IC_Inf_tasa,
		Media_tasa,
		IC_Sup_tasa,
		round((IC_Inf_tasa * i.poblacion) / 100000,2) as IC_Inf_Casos,
		round((Media_tasa * i.poblacion) / 100000,2) as Media_Casos,
		round((IC_Sup_tasa * i.poblacion) / 100000,2) as IC_Sup_Casos
		from
		(select semana, round(exp(IC_Inf),1) as IC_Inf_tasa, round(exp(media),1) as Media_tasa, round(exp(IC_Sup),1) as IC_Sup_tasa
		from
		(select semana, media, desviacion, round(media-(f.t * desviacion) / sqrt(f.datos),1) as IC_Inf, round(media+(f.t * desviacion) / sqrt(f.datos),1) as IC_Sup
		from
		(select semana, round(avg(logaritmo),1) as media, round(std(logaritmo),1) as desviacion
		from
		(select ano, semana, incidencia, ln(incidencia) as logaritmo
		from
		(select a.ano, a.semana, round((a.cantidad / b.poblacion) * 100000+1,2) as incidencia
		from
		(select ano, semana, sum(neu_2_11+neu_1_4a+ngr_m2+ngr_2_11+ngr_1_4a) as cantidad
		from iras_ant where ano >= 2000 and ano <= $agnio - 1 and substr(ubigeo, 1, 2) = $nivel group by ano, semana) a
		left join
		(select ano, sum(pobtot) as poblacion from codubi where ano >= 2000 and ano <= $agnio - 1 and substr(ubigeo, 1, 2) = $nivel group by ano) b
		on a.ano = b.ano
		group by a.ano, a.semana
		order by a.ano, a.semana) c )d
		group by semana) e, (select ano, datos, t from student where ano = year(curdate())-1) f) g) h,
		(select ano, sum(pobtot) as poblacion from codubi where ano >= 2000 and ano = $agnio - 1 and substr(ubigeo, 1, 2) = $nivel group by ano) i) j
		");
		$resultado2 = $query1->result();
		$query1->free_result();
		return $resultado2;
	}
	
	public function departamentosCanalEndemicoIrasActual($anio, $nivel)
	{
		
		$agnio = $anio;
		
		ini_set('memory_limit', '512M'); /// temporal hasta optimizar consultas
		if($agnio == date("Y")){
			$query1 = $this->db->query("
			select semana, sum(neu_2_11+neu_1_4a+ngr_m2+ngr_2_11+ngr_1_4a) as cantidad
			from iras where ano = $agnio and substr(ubigeo, 1, 2) = $nivel group by semana
			");
		}elseif($agnio < date("Y")){
			$query1 = $this->db->query("
			select semana, sum(neu_2_11+neu_1_4a+ngr_m2+ngr_2_11+ngr_1_4a) as cantidad
			from iras_ant where ano = $agnio and substr(ubigeo, 1, 2) = $nivel group by semana
			");
		}
		$resultado2 = $query1->result();
		$query1->free_result();
		return $resultado2;
	}

	//Modelo para generar los gráficos de casos individuales
    	
	public function totalInd($anio, $diagno)
	{
		$agnio = $anio;
		$semana = date("W")-1;		
		
		ini_set('memory_limit', '512M'); /// temporal hasta optimizar consultas
		if($agnio == date("Y")){
			$query1 = $this->db->query("
			select a.semana, a.cantidad as incidencia
			from
			(select ano, semana, count(ubigeo) as cantidad
			from individual where ubigeo <> '999999' and diagnostic = '".$diagno."' 
			group by ano, semana
			union all
			select ano, semana, count(ubigeo) as cantidad
			from individual_ant
			where ano >= $agnio-2 and ubigeo <> '999999' and diagnostic = '".$diagno."' 
			group by ano, semana
			order by ano, semana) a
			");
		}elseif($agnio < date("Y")){
			$query1 = $this->db->query("
			select a.semana, a.cantidad as incidencia
			from
			(select ano, semana, count(ubigeo) as cantidad
			from individual_ant
			where ano >= $agnio-2 and ubigeo <> '999999' and diagnostic = '".$diagno."' 
			group by ano, semana
			order by ano, semana) a
			");
		}
		$resultado2 = $query1->result();
		$query1->free_result();
		return $resultado2;
	}

	public function totalIndAnos($anio, $diagno)
	{
		$agnio = $anio;
		
		ini_set('memory_limit', '512M'); /// temporal hasta optimizar consultas
		if($agnio == date("Y")){
			$query1 = $this->db->query("
			select a.ano as ano, a.cantidad as incidencia
			from
			(select ano, count(ubigeo) as cantidad
			from individual where ubigeo <> '999999' and diagnostic = '".$diagno."' group by ano
			union all
			select ano, count(ubigeo) as cantidad
			from individual_ant where ano >= $agnio-9 and ubigeo <> '999999' and diagnostic = '".$diagno."' group by ano) a
			left join
			(select ano, sum(pobtot) as poblacion from codubi where ano >= $agnio-9 group by ano) b
			on a.ano = b.ano
			group by a.ano
			order by a.ano
			");
		}elseif($agnio < date("Y")){
			$query1 = $this->db->query("
			select a.ano as ano, a.cantidad as incidencia
			from
			(select ano, count(ubigeo) as cantidad
			from individual_ant where ano >= $agnio-9 and ubigeo <> '999999' and diagnostic = '".$diagno."' group by ano) a
			left join
			(select ano, sum(pobtot) as poblacion from codubi where ano >= $agnio-9 group by ano) b
			on a.ano = b.ano
			group by a.ano
			order by a.ano
			");
		}
		$resultado2 = $query1->result();
		$query1->free_result();
		return $resultado2;
	}

	public function nacionalEdadInd($anio, $diagno)
	{
		$agnio = $anio;
		
		ini_set('memory_limit', '512M'); /// temporal hasta optimizar consultas
		if($agnio == date("Y")){
			$query1 = $this->db->query("
			select Rango as rango, round((cantidad / ctotal) * 100,2) as cantidad
			from
			(select '0-11' as Rango, ifnull(sum(if(edad <= 11, 1, 0)),0) as cantidad
			from
			(select * from individual where ano = $agnio and diagnostic = '".$diagno."') a
			union
			select '12-17' as Rango, ifnull(sum(if(edad >= 12 and edad <= 17 and tipo_edad = 'A', 1, 0)),0) as cantidad
			from
			(select * from individual where ano = $agnio and diagnostic = '".$diagno."') b
			union
			select '18-29' as Rango, ifnull(sum(if(edad >= 18 and edad <= 29 and tipo_edad = 'A', 1, 0)),0) as cantidad
			from
			(select * from individual where ano = $agnio and diagnostic = '".$diagno."') c
			union
			select '30-59' as Rango, ifnull(sum(if(edad >= 30 and edad <= 59 and tipo_edad = 'A', 1, 0)),0) as cantidad
			from
			(select * from individual where ano = $agnio and diagnostic = '".$diagno."') d
			union
			select '60-mas' as Rango, ifnull(sum(if(edad >= 60 and tipo_edad = 'A', 1, 0)),0) as cantidad
			from
			(select * from individual where ano = $agnio and diagnostic = '".$diagno."') e) h,
			(select *
			from
			(select count(*) as ctotal from individual where ano = $agnio and diagnostic = '".$diagno."') f) g
			");
		}elseif($agnio < date("Y")){
			$query1 = $this->db->query("
			select Rango as rango, round((cantidad / ctotal) * 100,2) as cantidad
			from
			(select '0-11' as Rango, ifnull(sum(if(edad <= 11, 1, 0)),0) as cantidad
			from
			(select * from individual_ant where ano = $agnio and diagnostic = '".$diagno."') a
			union
			select '12-17' as Rango, ifnull(sum(if(edad >= 12 and edad <= 17 and tipo_edad = 'A', 1, 0)),0) as cantidad
			from
			(select * from individual_ant where ano = $agnio and diagnostic = '".$diagno."') b
			union
			select '18-29' as Rango, ifnull(sum(if(edad >= 18 and edad <= 29 and tipo_edad = 'A', 1, 0)),0) as cantidad
			from
			(select * from individual_ant where ano = $agnio and diagnostic = '".$diagno."') c
			union
			select '30-59' as Rango, ifnull(sum(if(edad >= 30 and edad <= 59 and tipo_edad = 'A', 1, 0)),0) as cantidad
			from
			(select * from individual_ant where ano = $agnio and diagnostic = '".$diagno."') d
			union
			select '60-mas' as Rango, ifnull(sum(if(edad >= 60 and tipo_edad = 'A', 1, 0)),0) as cantidad
			from
			(select * from individual_ant where ano = $agnio and diagnostic = '".$diagno."') e) h,
			(select *
			from
			(select count(*) as ctotal from individual_ant where ano = $agnio and diagnostic = '".$diagno."') f) g
			");
		}
		$resultado2 = $query1->result();
		$query1->free_result();
		return $resultado2;
	}

	public function nacionalIndEndemico($anio, $diagno)
	{
		
		$agnio = $anio;
		
		ini_set('memory_limit', '512M'); /// temporal hasta optimizar consultas
		$query1 = $this->db->query("
		select j.semana, IC_Inf_Casos as IC_Inf, (Media_Casos - IC_Inf_Casos) as Media_IC_Inf, (IC_Sup_Casos - Media_Casos) as IC_Sup_Media
		from
		(select semana,
		IC_Inf_tasa,
		Media_tasa,
		IC_Sup_tasa,
		round((IC_Inf_tasa * i.poblacion) / 100000,2) as IC_Inf_Casos,
		round((Media_tasa * i.poblacion) / 100000,2) as Media_Casos,
		round((IC_Sup_tasa * i.poblacion) / 100000,2) as IC_Sup_Casos
		from
		(select semana, round(exp(IC_Inf),1) as IC_Inf_tasa, round(exp(media),1) as Media_tasa, round(exp(IC_Sup),1) as IC_Sup_tasa
		from
		(select semana, media, desviacion, round(media-(f.t * desviacion) / sqrt(f.datos),1) as IC_Inf, round(media+(f.t * desviacion) / sqrt(f.datos),1) as IC_Sup
		from
		(select semana, round(avg(logaritmo),1) as media, round(std(logaritmo),1) as desviacion
		from
		(select ano, semana, incidencia, ln(incidencia) as logaritmo
		from
		(select a.ano, a.semana, round((a.cantidad / b.poblacion) * 100000+1,2) as incidencia
		from
		(select * from
		(select ano, semana, count(ubigeo) as cantidad
		from individual_ant where ano >= 2000 and ano <= $agnio - 1 and diagnostic = '".$diagno."' group by ano, semana
		union
		select ano, semana, sum(p_vivax) as cantidad
		from malaria where ano >= 2000 and ano <= 2008 group by ano, semana) k) a
		left join
		(select ano, sum(pobtot) as poblacion from codubi where ano >= 2000 and ano <= $agnio - 1 group by ano) b
		on a.ano = b.ano
		group by a.ano, a.semana
		order by a.ano, a.semana) c )d
		group by semana) e, (select ano, datos, t from student where ano = year(curdate())-1) f) g) h,
		(select ano, sum(pobtot) as poblacion from codubi where ano >= 2000 and ano <= $agnio - 1 group by ano) i) j
		group by semana
		");
		$resultado2 = $query1->result();
		$query1->free_result();
		return $resultado2;
	}
	
	public function nacionalCanalEndemicoIndActual($anio, $diagno)
	{
		
		$agnio = $anio;
		
		ini_set('memory_limit', '512M'); /// temporal hasta optimizar consultas
		if($agnio == date("Y")){
			$query1 = $this->db->query("
			select semana, count(ubigeo) as cantidad
			from individual where ano = $agnio and diagnostic = '".$diagno."' group by semana
			");
		}elseif($agnio < date("Y")){
			$query1 = $this->db->query("
			select semana, count(ubigeo) as cantidad
			from individual_ant where ano = $agnio and diagnostic = '".$diagno."' group by semana
			");
		}
		$resultado2 = $query1->result();
		$query1->free_result();
		return $resultado2;
	}

	////////////////////////////////////////////////////////////////////////////////////////////////

	public function departamentosTotalInd($anio, $diagno, $nivel)
	{
		$agnio = $anio;
		$semana = date("W")-1;		
		
		ini_set('memory_limit', '512M'); /// temporal hasta optimizar consultas
		if($agnio == date("Y")){
			$query1 = $this->db->query("
			select a.semana, a.cantidad as incidencia
			from
			(select ano, semana, count(ubigeo) as cantidad from individual where ano <> 0 and 
			ubigeo <> '999999' and diagnostic = '".$diagno."' and substr(ubigeo, 1, 2) = $nivel group by ano, semana
			union all
			select ano, semana, count(ubigeo) as cantidad from individual_ant where ano >= $agnio-2 and ano <> 0 and 
			ubigeo <> '999999' and diagnostic = '".$diagno."' and substr(ubigeo, 1, 2) = $nivel group by ano, semana) a
			order by a.ano, a.semana
			");
		}elseif($agnio < date("Y")){
			$query1 = $this->db->query("
			select a.semana, a.cantidad as incidencia
			from
			(select ano, semana, count(ubigeo) as cantidad
			from individual_ant where ano >= $agnio-2 and ano <> 0 and ubigeo <> '999999' and diagnostic = '".$diagno."' 
			and substr(ubigeo, 1, 2) = $nivel group by ano, semana) a
			order by a.ano, a.semana
			");
		}
		$resultado2 = $query1->result();
		$query1->free_result();
		return $resultado2;
	}

	public function departamentosTotalIndAnos($anio, $diagno, $nivel)
	{
		$agnio = $anio;
		
		ini_set('memory_limit', '512M'); /// temporal hasta optimizar consultas
		if($agnio == date("Y")){
			$query1 = $this->db->query("
			select a.ano as ano, a.cantidad as incidencia
			from
			(select ano, count(ubigeo) as cantidad from individual where ano <> 0 and 
			ubigeo <> '999999' and diagnostic = '".$diagno."' and substr(ubigeo, 1, 2) = $nivel group by ano
			union all
			select ano, count(ubigeo) as cantidad from individual_ant where ano >= $agnio-9 and ano <> 0 and 
			ubigeo <> '999999' and diagnostic = '".$diagno."' and substr(ubigeo, 1, 2) = $nivel group by ano) a
			left join
			(select ano, sum(pobtot) as poblacion from codubi where ano >= $agnio-9 and substr(ubigeo, 1, 2) = $nivel group by ano) b
			on a.ano = b.ano
			group by a.ano
			order by a.ano
			");
		}elseif($agnio < date("Y")){
			$query1 = $this->db->query("
			select a.ano as ano, a.cantidad as incidencia
			from
			(select ano, count(ubigeo) as cantidad
			from individual_ant where ano >= $agnio-9 and ano <> 0 and ubigeo <> '999999' and diagnostic = '".$diagno."' and substr(ubigeo, 1, 2) = $nivel group by ano) a
			left join
			(select ano, sum(pobtot) as poblacion from codubi where ano >= $agnio-9 and substr(ubigeo, 1, 2) = $nivel group by ano) b
			on a.ano = b.ano
			group by a.ano
			order by a.ano
			");
		}
		$resultado2 = $query1->result();
		$query1->free_result();
		return $resultado2;
	}

	public function departamentosEdadInd($anio, $diagno, $nivel)
	{
		$agnio = $anio;
		
		ini_set('memory_limit', '512M'); /// temporal hasta optimizar consultas
		if($agnio == date("Y")){
			$query1 = $this->db->query("
			select Rango as rango, round((cantidad / ctotal) * 100,2) as cantidad
			from
			(select '0-11' as Rango, ifnull(sum(if(edad <= 11, 1, 0)),0) as cantidad
			from
			(select * from individual where ano = $agnio and substr(ubigeo, 1, 2) = $nivel and diagnostic = '".$diagno."') a
			union
			select '12-17' as Rango, ifnull(sum(if(edad >= 12 and edad <= 17 and tipo_edad = 'A', 1, 0)),0) as cantidad
			from
			(select * from individual where ano = $agnio and substr(ubigeo, 1, 2) = $nivel and diagnostic = '".$diagno."') b
			union
			select '18-29' as Rango, ifnull(sum(if(edad >= 18 and edad <= 29 and tipo_edad = 'A', 1, 0)),0) as cantidad
			from
			(select * from individual where ano = $agnio and substr(ubigeo, 1, 2) = $nivel and diagnostic = '".$diagno."') c
			union
			select '30-59' as Rango, ifnull(sum(if(edad >= 30 and edad <= 59 and tipo_edad = 'A', 1, 0)),0) as cantidad
			from
			(select * from individual where ano = $agnio and substr(ubigeo, 1, 2) = $nivel and diagnostic = '".$diagno."') d
			union
			select '60-mas' as Rango, ifnull(sum(if(edad >= 60 and tipo_edad = 'A', 1, 0)),0) as cantidad
			from
			(select * from individual where ano = $agnio and substr(ubigeo, 1, 2) = $nivel and diagnostic = '".$diagno."') e) h,
			(select *
			from
			(select count(*) as ctotal from individual where ano = $agnio and substr(ubigeo, 1, 2) = $nivel and diagnostic = '".$diagno."') f) g
			");
		}elseif($agnio < date("Y")){
			$query1 = $this->db->query("
			select Rango as rango, round((cantidad / ctotal) * 100,2) as cantidad
			from
			(select '0-11' as Rango, ifnull(sum(if(edad <= 11, 1, 0)),0) as cantidad
			from
			(select * from individual_ant where ano = $agnio and substr(ubigeo, 1, 2) = $nivel and diagnostic = '".$diagno."') a
			union
			select '12-17' as Rango, ifnull(sum(if(edad >= 12 and edad <= 17 and tipo_edad = 'A', 1, 0)),0) as cantidad
			from
			(select * from individual_ant where ano = $agnio and substr(ubigeo, 1, 2) = $nivel and diagnostic = '".$diagno."') b
			union
			select '18-29' as Rango, ifnull(sum(if(edad >= 18 and edad <= 29 and tipo_edad = 'A', 1, 0)),0) as cantidad
			from
			(select * from individual_ant where ano = $agnio and substr(ubigeo, 1, 2) = $nivel and diagnostic = '".$diagno."') c
			union
			select '30-59' as Rango, ifnull(sum(if(edad >= 30 and edad <= 59 and tipo_edad = 'A', 1, 0)),0) as cantidad
			from
			(select * from individual_ant where ano = $agnio and substr(ubigeo, 1, 2) = $nivel and diagnostic = '".$diagno."') d
			union
			select '60-mas' as Rango, ifnull(sum(if(edad >= 60 and tipo_edad = 'A', 1, 0)),0) as cantidad
			from
			(select * from individual_ant where ano = $agnio and substr(ubigeo, 1, 2) = $nivel and diagnostic = '".$diagno."') e) h,
			(select *
			from
			(select count(*) as ctotal from individual_ant where ano = $agnio and substr(ubigeo, 1, 2) = $nivel and diagnostic = '".$diagno."') f) g
			");
		}
		$resultado2 = $query1->result();
		$query1->free_result();
		return $resultado2;
	}

	public function departamentosIndEndemico($anio, $diagno, $nivel)
	{
		
		$agnio = $anio;
		
		ini_set('memory_limit', '512M'); /// temporal hasta optimizar consultas
		$query1 = $this->db->query("
		select j.semana, IC_Inf_Casos as IC_Inf, (Media_Casos - IC_Inf_Casos) as Media_IC_Inf, (IC_Sup_Casos - Media_Casos) as IC_Sup_Media
		from
		(select semana,
		IC_Inf_tasa,
		Media_tasa,
		IC_Sup_tasa,
		round((IC_Inf_tasa * i.poblacion) / 100000,2) as IC_Inf_Casos,
		round((Media_tasa * i.poblacion) / 100000,2) as Media_Casos,
		round((IC_Sup_tasa * i.poblacion) / 100000,2) as IC_Sup_Casos
		from
		(select semana, round(exp(IC_Inf),1) as IC_Inf_tasa, round(exp(media),1) as Media_tasa, round(exp(IC_Sup),1) as IC_Sup_tasa
		from
		(select semana, media, desviacion, round(media-(f.t * desviacion) / sqrt(f.datos),1) as IC_Inf, round(media+(f.t * desviacion) / sqrt(f.datos),1) as IC_Sup
		from
		(select semana, round(avg(logaritmo),1) as media, round(std(logaritmo),1) as desviacion
		from
		(select ano, semana, incidencia, ln(incidencia) as logaritmo
		from
		(select a.ano, a.semana, round((a.cantidad / b.poblacion) * 100000+1,2) as incidencia
		from
		(select * from
		(select ano, semana, count(ubigeo) as cantidad
		from individual_ant where ano >= 2000 and ano <= $agnio - 1 and diagnostic = '".$diagno."' and substr(ubigeo, 1, 2) = $nivel group by ano, semana
		union
		select ano, semana, sum(p_vivax) as cantidad
		from malaria where ano >= 2000 and ano <= 2008 and substr(ubigeo, 1, 2) = $nivel group by ano, semana) k) a
		left join
		(select ano, sum(pobtot) as poblacion from codubi where ano >= 2000 and ano <= $agnio - 1 and substr(ubigeo, 1, 2) = $nivel group by ano) b
		on a.ano = b.ano
		group by a.ano, a.semana
		order by a.ano, a.semana) c )d
		group by semana) e, (select ano, datos, t from student where ano = year(curdate())-1) f) g) h,
		(select ano, sum(pobtot) as poblacion from codubi where ano >= 2000 and ano <= $agnio - 1 and substr(ubigeo, 1, 2) = $nivel group by ano) i) j
		group by semana
		");
		$resultado2 = $query1->result();
		$query1->free_result();
		return $resultado2;
	}
	
	public function departamentosCanalEndemicoIndActual($anio, $diagno, $nivel)
	{
		
		$agnio = $anio;
		
		ini_set('memory_limit', '512M'); /// temporal hasta optimizar consultas
		if($agnio == date("Y")){
			$query1 = $this->db->query("
			select semana, count(ubigeo) as cantidad
			from individual where ano = $agnio and diagnostic = '".$diagno."' and substr(ubigeo, 1, 2) = $nivel group by semana
			");
		}elseif($agnio < date("Y")){
			$query1 = $this->db->query("
			select semana, count(ubigeo) as cantidad
			from individual_ant where ano = $agnio and diagnostic = '".$diagno."' and substr(ubigeo, 1, 2) = $nivel group by semana
			");
		}
		$resultado2 = $query1->result();
		$query1->free_result();
		return $resultado2;
	}

	////////////////////////////////////////////////////////////////////////////////////////////////

	public function obtenerDepartamentos()
	{
		$query = $this->db
				->order_by('nombre')
				->get('departamento');
		$resultado = $query->result();
		$query->free_result();
		return $resultado;
	}

	public function graficosDepartamentos($param)
	{
		$query = 
				$this->db
				->order_by('nombre')
				->where(array('ubigeo' => $param))
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
				->get('diresa');
		$resultado = $query->result();
		$query->free_result();
		return $resultado;
	}

	public function obtenerIndividual()
	{
		$query = 
				$this->db
				->query('SELECT b.* FROM `estratos` a left join diagno b on b.cie_10 = a.enfermedad 
						where enfermedad != "XX1" and enfermedad != "YY1"');
		$resultado = $query->result();
		$query->free_result();
		return $resultado;
	}

	public function obtenerEnfermedad($dato)
	{
		$where = array("cie_10"=>$dato);
		$query = 
				$this->db
				->where($where)
				->get('diagno');
		$resultado = $query->result();
		$query->free_result();
		return $resultado;
	}
}
?>