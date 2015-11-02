<?php
class reportes_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
	
	//Genera el proceso de cobertura de los establecimientos de salud, por niveles
	
	public function reporteNotificacion($anio, $semana) 
    {
		switch($this->session->userdata('nivel')){
			case 5:
			$plantilla = "
			select ifnull(x.ano,".$anio.") as ano, ifnull(x.semana,".$semana.") as semana, y.subregion as diresa, 
			dd.nombre as ndiresa, y.red as red, rr.nombre as nred, y.microred as microred, mm.nombre as nmicrored, 
			y.cod_est as establec, y.raz_soc as nestablec, 
			if(sum(cantidad)>0,1,0) as notificacion, curdate() as fecha, 
			curtime() as hora
			from
			renace y
			left join 
			diresas dd
			on dd.codigo = y.subregion
			left join 
			redes rr
			on concat(y.subregion, y.red) = concat(rr.subregion, rr.codigo)
			left join
			microred mm
			on concat(y.subregion, y.red, y.microred) = concat(mm.subregion, mm.red, mm.codigo)
			left join
			(select a.ano, a.semana, a.sub_reg_nt, a.e_salud, count(a.ubigeo) as cantidad
			from individual a
			left join diresas b on a.sub_reg_nt = b.codigo
			left join renace c on a.e_salud = c.cod_est
			where a.ano = $anio and a.semana = $semana and sub_reg_nt = '".$this->session->userdata('diresa')."'
			group by a.ano, a.semana, a.sub_reg_nt, a.e_salud
			union
			select a.ano, a.semana, a.sub_reg_nt, a.e_salud, count(a.ubigeo) as cantidad
			from edas a
			left join diresas b on a.sub_reg_nt = b.codigo
			left join renace c on a.e_salud = c.cod_est
			where a.ano = $anio and a.semana = $semana and sub_reg_nt = '".$this->session->userdata('diresa')."'
			group by a.ano, a.semana, a.sub_reg_nt, a.e_salud
			union
			select a.ano, a.semana, a.sub_reg_nt, a.e_salud, count(a.ubigeo) as cantidad
			from iras a
			left join diresas b on a.sub_reg_nt = b.codigo
			left join renace c on a.e_salud = c.cod_est
 			where a.ano = $anio and a.semana = $semana and sub_reg_nt = '".$this->session->userdata('diresa')."'
			group by a.ano, a.semana, a.sub_reg_nt, a.e_salud) x
			on y.cod_est = x.e_salud
			where y.subregion = '".$this->session->userdata('diresa')."' and y.notifica = 'S'
			group by y.subregion, y.red, y.microred, y.raz_soc
			order by y.subregion, y.red, y.microred, y.raz_soc
			";
			
			$where = array('ano'=>$anio, 'semana'=>$semana, 'diresa'=>$this->session->userdata('diresa'));
			
			$this->db->where($where);
			$this->db->delete('cobertura');
			break;
			case 6:
			$plantilla = "
			select ifnull(x.ano,".$anio.") as ano, ifnull(x.semana,".$semana.") as semana, y.subregion as diresa, dd.nombre as ndiresa, 
			y.red as red, rr.nombre as nred, y.microred as microred, mm.nombre as nmicrored, y.cod_est as establec, y.raz_soc as nestablec, 
			if(sum(cantidad)>0,1,0) as notificacion, curdate() as fecha, curtime() as hora
			from
			renace y
			left join 
			diresas dd
			on dd.codigo = y.subregion
			left join 
			redes rr
			on concat(y.subregion, y.red) = concat(rr.subregion, rr.codigo)
			left join
			microred mm
			on concat(y.subregion, y.red, y.microred) = concat(mm.subregion, mm.red, mm.codigo)
			left join
			(select a.ano, a.semana, a.sub_reg_nt, a.e_salud, count(a.ubigeo) as cantidad
			from individual a
			left join diresas b on a.sub_reg_nt = b.codigo
			left join renace c on a.e_salud = c.cod_est
			where a.ano = $anio and a.semana = $semana and a.sub_reg_nt = '".$this->session->userdata('diresa')."' and a.red = '".$this->session->userdata('red')."'
			group by a.ano, a.semana, a.sub_reg_nt, a.e_salud
			union
			select a.ano, a.semana, a.sub_reg_nt, a.e_salud, count(a.ubigeo) as cantidad
			from edas a
			left join diresas b on a.sub_reg_nt = b.codigo
			left join renace c on a.e_salud = c.cod_est
			where a.ano = $anio and a.semana = $semana and a.sub_reg_nt = '".$this->session->userdata('diresa')."' and a.red = '".$this->session->userdata('red')."'
			group by a.ano, a.semana, a.sub_reg_nt, a.e_salud
			union
			select a.ano, a.semana, a.sub_reg_nt, a.e_salud, count(a.ubigeo) as cantidad
			from iras a
			left join diresas b on a.sub_reg_nt = b.codigo
			left join renace c on a.e_salud = c.cod_est
			where a.ano = $anio and a.semana = $semana and a.sub_reg_nt = '".$this->session->userdata('diresa')."' and a.red = '".$this->session->userdata('red')."'
			group by a.ano, a.semana, a.sub_reg_nt, a.e_salud) x
			on y.cod_est = x.e_salud
			where y.subregion = '".$this->session->userdata('diresa')."' and y.red = '".$this->session->userdata('red')."' and y.notifica = 'S'
			group by y.subregion, y.red, y.microred, y.raz_soc
			order by y.subregion, y.red, y.microred, y.raz_soc
			";
			
			$where = array('ano'=>$anio, 'semana'=>$semana, 'diresa'=>$this->session->userdata('diresa'), 'red'=>$this->session->userdata('red'));
			
			$this->db->where($where);
			$this->db->delete('cobertura');
			break;
			case 7:
			$plantilla = "
			select ifnull(x.ano,".$anio.") as ano, ifnull(x.semana,".$semana.") as semana, y.subregion as diresa, dd.nombre as ndiresa, 
			y.red as red, rr.nombre as nred, y.microred as microred, mm.nombre as nmicrored, y.cod_est as establec, y.raz_soc as nestablec, 
			if(sum(cantidad)>0,1,0) as notificacion, curdate() as fecha, curtime() as hora
			from
			renace y
			left join 
			diresas dd
			on dd.codigo = y.subregion
			left join 
			redes rr
			on concat(y.subregion, y.red) = concat(rr.subregion, rr.codigo)
			left join
			microred mm
			on concat(y.subregion, y.red, y.microred) = concat(mm.subregion, mm.red, mm.codigo)
			left join
			(select a.ano, a.semana, a.sub_reg_nt, a.e_salud, count(a.ubigeo) as cantidad
			from individual a
			left join diresas b on a.sub_reg_nt = b.codigo
			left join renace c on a.e_salud = c.cod_est
			where a.ano = $anio and a.semana = $semana and a.sub_reg_nt = '".$this->session->userdata('diresa')."' and a.red = '".$this->session->userdata('red')."' and a.microred = '".$this->session->userdata('microred')."'
			group by a.ano, a.semana, a.sub_reg_nt, a.e_salud
			union
			select a.ano, a.semana, a.sub_reg_nt, a.e_salud, count(a.ubigeo) as cantidad
			from edas a
			left join diresas b on a.sub_reg_nt = b.codigo
			left join renace c on a.e_salud = c.cod_est
			where a.ano = $anio and a.semana = $semana and a.sub_reg_nt = '".$this->session->userdata('diresa')."' and a.red = '".$this->session->userdata('red')."' and a.microred = '".$this->session->userdata('microred')."'
			group by a.ano, a.semana, a.sub_reg_nt, a.e_salud
			union
			select a.ano, a.semana, a.sub_reg_nt, a.e_salud, count(a.ubigeo) as cantidad
			from iras a
			left join diresas b on a.sub_reg_nt = b.codigo
			left join renace c on a.e_salud = c.cod_est
			where a.ano = $anio and a.semana = $semana and a.sub_reg_nt = '".$this->session->userdata('diresa')."' and a.red = '".$this->session->userdata('red')."' and a.microred = '".$this->session->userdata('microred')."'
			group by a.ano, a.semana, a.sub_reg_nt, a.e_salud) x
			on y.cod_est = x.e_salud
			where y.subregion = '".$this->session->userdata('diresa')."' and y.red = '".$this->session->userdata('red')."' and y.microred = '".$this->session->userdata('microred')."' and y.notifica = 'S'
			group by y.subregion, y.red, y.microred, y.raz_soc
			order by y.subregion, y.red, y.microred, y.raz_soc
			";
			
			$where = array('ano'=>$anio, 'semana'=>$semana, 'diresa'=>$this->session->userdata('diresa'), 'red'=>$this->session->userdata('red'), 'microred'=>$this->session->userdata('microred'));
			
			$this->db->where($where);
			$this->db->delete('cobertura');
			break;
		}
		
		$query = $this->db->query($plantilla);
		
		$resul = $query->result();
		
		$resultado = array();
		
		foreach($resul as $dato)
		{
			$resultado['ano'] = $dato->ano;
			$resultado['semana'] = $dato->semana;
			$resultado['diresa'] = $dato->diresa;
			$resultado['ndiresa'] = $dato->ndiresa;
			$resultado['red'] = $dato->red;
			$resultado['nred'] = $dato->nred;
			$resultado['microred'] = $dato->microred;
			$resultado['nmicrored'] = $dato->nmicrored;
			$resultado['establec'] = $dato->establec;
			$resultado['nestablec'] = $dato->nestablec;
			$resultado['notificacion'] = $dato->notificacion;
			$resultado['fecha'] = $dato->fecha;
			$resultado['hora'] = $dato->hora;

			$this->db->insert('cobertura', $resultado);
		}		
		
		return true;
		
	}
	
	//Procesa los resultados de la cobertura de la notificación
	public function cobertura($anio, $semana)
	{
		switch($this->session->userdata('nivel')){
			case 1:
			$plantilla = "
			select q.*,
      		ifnull(z.no_notifico, 0) as no_notifico,
		    ifnull(round((z.no_notifico/q.total_act)*100,2),0) as porc_nonot,
			ifnull(p.not_neg, 0) as not_neg,
      		ifnull(round((p.not_neg/q.total_act)*100,2),0) as porc_notNeg,
      		q.porcentaje + ifnull(round((p.not_neg/q.total_act)*100,2),0) as porcCobertura,
      		q.porcentaje + ifnull(round((z.no_notifico/q.total_act)*100,2),0) + ifnull(round((p.not_neg/q.total_act)*100,2),0) as porcTotal
			from
			(select *, round((total/total_act)*100,2) as porcentaje
			from
			(select b.nombre as diresa,
			sum(if(substr(a.cod_est,8,1) = '1', 1, 0)) as hosp_act,
			sum(if(substr(a.cod_est,8,1) = '2', 1, 0)) as centro_act,
			sum(if(substr(a.cod_est,8,1) = '3', 1, 0)) as puesto_act,
			sum(if(substr(a.cod_est,8,1) != '1' and substr(a.cod_est,8,1) != '2' and
			substr(a.cod_est,8,1) != '3', 1, 0)) as otrosact,
			sum(if(a.cod_est != '', 1, 0)) as total_act
			from
			renace a left join diresas b on a.subregion = b.codigo
			where a.notifica = 'S' and a.estado = '1'
			group by b.nombre
			order by b.nombre) x
			join
			(select b.nombre as diresa,
			sum(if(substr(a.establec,8,1) = '1', 1, 0)) as hospital,
			sum(if(substr(a.establec,8,1) = '2', 1, 0)) as centro_salud,
			sum(if(substr(a.establec,8,1) = '3', 1, 0)) as puesto_salud,
			sum(if(substr(a.establec,8,1) != '1' and
	    	substr(a.establec,8,1) != '2' and
    	  	substr(a.establec,8,1) != '3', 1, 0)) as otros,
			sum(if(a.establec != '', 1, 0)) as total
			from
			cobertura a left join diresas b on a.diresa = b.codigo
			where ano = $anio and semana = $semana and notificacion = '1'
			group by a.ano, a.semana, b.nombre
			order by b.nombre) y
			USING (diresa)) q
			left join
			(select b.nombre as diresa,
			sum(if(substr(a.establec,8,1) != '', 1, 0)) as no_notifico
			from
			cobertura a left join diresas b on a.diresa = b.codigo
			where ano = $anio and semana = $semana and notificacion = '0'
			group by a.ano, a.semana, b.nombre
			order by b.nombre) z
			on q.diresa = z.diresa
			left join
			(select b.nombre as diresa,
			sum(if(substr(a.establec,8,1) != '', 1, 0)) as not_neg
			from
			cobertura a left join diresas b on a.diresa = b.codigo
			where ano = $anio and semana = $semana and notificacion = '2'
			group by a.ano, a.semana, b.nombre
			order by b.nombre) p
			on q.diresa = p.diresa
			";
			$query = $this->db->query($plantilla);
			
			return $query->result();
			break;
			
			case 4:
			$plantilla = "
			select q.*,
      		ifnull(z.no_notifico, 0) as no_notifico,
		    ifnull(round((z.no_notifico/q.total_act)*100,2),0) as porc_nonot,
			ifnull(p.not_neg, 0) as not_neg,
      		ifnull(round((p.not_neg/q.total_act)*100,2),0) as porc_notNeg,
      		q.porcentaje + ifnull(round((p.not_neg/q.total_act)*100,2),0) as porcCobertura,
      		q.porcentaje + ifnull(round((z.no_notifico/q.total_act)*100,2),0) + ifnull(round((p.not_neg/q.total_act)*100,2),0) as porcTotal
			from
			(select *, round((total/total_act)*100,2) as porcentaje
			from
			(select b.nombre as diresa,
			sum(if(substr(a.cod_est,8,1) = '1', 1, 0)) as hosp_act,
			sum(if(substr(a.cod_est,8,1) = '2', 1, 0)) as centro_act,
			sum(if(substr(a.cod_est,8,1) = '3', 1, 0)) as puesto_act,
			sum(if(substr(a.cod_est,8,1) != '1' and substr(a.cod_est,8,1) != '2' and
			substr(a.cod_est,8,1) != '3', 1, 0)) as otrosact,
			sum(if(a.cod_est != '', 1, 0)) as total_act
			from
			renace a left join diresas b on a.subregion = b.codigo
			where a.notifica = 'S' and a.estado = '1'
			group by b.nombre
			order by b.nombre) x
			join
			(select b.nombre as diresa,
			sum(if(substr(a.establec,8,1) = '1', 1, 0)) as hospital,
			sum(if(substr(a.establec,8,1) = '2', 1, 0)) as centro_salud,
			sum(if(substr(a.establec,8,1) = '3', 1, 0)) as puesto_salud,
			sum(if(substr(a.establec,8,1) != '1' and
	    	substr(a.establec,8,1) != '2' and
    	  	substr(a.establec,8,1) != '3', 1, 0)) as otros,
			sum(if(a.establec != '', 1, 0)) as total
			from
			cobertura a left join diresas b on a.diresa = b.codigo
			where ano = $anio and semana = $semana and notificacion = '1'
			group by a.ano, a.semana, b.nombre
			order by b.nombre) y
			USING (diresa)) q
			left join
			(select b.nombre as diresa,
			sum(if(substr(a.establec,8,1) != '', 1, 0)) as no_notifico
			from
			cobertura a left join diresas b on a.diresa = b.codigo
			where ano = $anio and semana = $semana and notificacion = '0'
			group by a.ano, a.semana, b.nombre
			order by b.nombre) z
			on q.diresa = z.diresa
			left join
			(select b.nombre as diresa,
			sum(if(substr(a.establec,8,1) != '', 1, 0)) as not_neg
			from
			cobertura a left join diresas b on a.diresa = b.codigo
			where ano = $anio and semana = $semana and notificacion = '2'
			group by a.ano, a.semana, b.nombre
			order by b.nombre) p
			on q.diresa = p.diresa
			";
			$query = $this->db->query($plantilla);
			
			return $query->result();
			break;
			
			case 5:
			$plantilla = "
			select q.*,
      		ifnull(z.no_notifico, 0) as no_notifico,
      		ifnull(round((z.no_notifico/q.total_act)*100,2),0) as porc_nonot,
			ifnull(p.not_neg, 0) as not_neg,
      		ifnull(round((p.not_neg/q.total_act)*100,2),0) as porc_notNeg,
      		q.porcentaje + ifnull(round((p.not_neg/q.total_act)*100,2),0) as porcCobertura,
      		q.porcentaje + ifnull(round((z.no_notifico/q.total_act)*100,2),0) + ifnull(round((p.not_neg/q.total_act)*100,2),0) as porcTotal
			from
			(select *, round((total/total_act)*100,2) as porcentaje
			from
			(select b.nombre as red,
			sum(if(substr(a.cod_est,8,1) = '1', 1, 0)) as hosp_act,
			sum(if(substr(a.cod_est,8,1) = '2', 1, 0)) as centro_act,
			sum(if(substr(a.cod_est,8,1) = '3', 1, 0)) as puesto_act,
			sum(if(substr(a.cod_est,8,1) != '1' and substr(a.cod_est,8,1) != '2' and
			substr(a.cod_est,8,1) != '3', 1, 0)) as otrosact,
			sum(if(a.cod_est != '', 1, 0)) as total_act
			from
			renace a left join redes b on concat(a.subregion,a.red) = concat(b.subregion,b.codigo)
			where a.notifica = 'S' and a.estado = '1' and a.subregion = '".$this->session->userdata('diresa')."'
			group by b.nombre
			order by b.nombre) x
			join
			(select b.nombre as red,
			sum(if(substr(a.establec,8,1) = '1', 1, 0)) as hospital,
			sum(if(substr(a.establec,8,1) = '2', 1, 0)) as centro_salud,
			sum(if(substr(a.establec,8,1) = '3', 1, 0)) as puesto_salud,
			sum(if(substr(a.establec,8,1) != '1' and substr(a.establec,8,1) != '2' and
			substr(a.establec,8,1) != '3', 1, 0)) as otros,
			sum(if(a.establec != '', 1, 0)) as total
			from
			cobertura a left join redes b on concat(a.diresa,a.red) = concat(b.subregion,b.codigo)
			where ano = $anio and semana = $semana and notificacion = '1' and a.diresa = '".$this->session->userdata('diresa')."'
			group by a.ano, a.semana, b.nombre
			order by b.nombre) y
			USING (red)) q
			left join
			(select b.nombre as red,
			sum(if(substr(a.establec,8,1) != '', 1, 0)) as no_notifico
			from
			cobertura a left join redes b on concat(a.diresa,a.red) = concat(b.subregion,b.codigo)
			where ano = $anio and semana = $semana and notificacion = '0' and a.diresa = '".$this->session->userdata('diresa')."'
			group by a.ano, a.semana, b.nombre
			order by b.nombre) z
			on q.red = z.red
			left join
			(select b.nombre as red,
			sum(if(substr(a.establec,8,1) != '', 1, 0)) as not_neg
			from
			cobertura a left join redes b on concat(a.diresa,a.red) = concat(b.subregion,b.codigo)
			where ano = $anio and semana = $semana and notificacion = '2' and a.diresa = '".$this->session->userdata('diresa')."'
			group by a.ano, a.semana, b.nombre
			order by b.nombre) p
			on q.red = p.red
			";
			
			$query = $this->db->query($plantilla);
			
			return $query->result();
			
			break;
			case 6:
			$plantilla = "
			select q.*,
      		ifnull(z.no_notifico, 0) as no_notifico,
      		ifnull(round((z.no_notifico/q.total_act)*100,2),0) as porc_nonot,
			ifnull(p.not_neg, 0) as not_neg,
      		ifnull(round((p.not_neg/q.total_act)*100,2),0) as porc_notNeg,
      		q.porcentaje + ifnull(round((p.not_neg/q.total_act)*100,2),0) as porcCobertura,
      		q.porcentaje + ifnull(round((z.no_notifico/q.total_act)*100,2),0) + ifnull(round((p.not_neg/q.total_act)*100,2),0) as porcTotal
			from
			(select *, round((total/total_act)*100,2) as porcentaje
			from
			(select b.nombre as microred,
			sum(if(substr(a.cod_est,8,1) = '1', 1, 0)) as hosp_act,
			sum(if(substr(a.cod_est,8,1) = '2', 1, 0)) as centro_act,
			sum(if(substr(a.cod_est,8,1) = '3', 1, 0)) as puesto_act,
			sum(if(substr(a.cod_est,8,1) != '1' and substr(a.cod_est,8,1) != '2' and
			substr(a.cod_est,8,1) != '3', 1, 0)) as otrosact,
			sum(if(a.cod_est != '', 1, 0)) as total_act
			from
			renace a left join microred b on concat(a.subregion,a.red,a.microred) = concat(b.subregion,b.red,b.codigo)
			where a.notifica = 'S' and a.estado = '1' and a.subregion = '".$this->session->userdata('diresa')."' and a.red = '".$this->session->userdata('red')."'
			group by b.nombre
			order by b.nombre) x
			join
			(select b.nombre as microred,
			sum(if(substr(a.establec,8,1) = '1', 1, 0)) as hospital,
			sum(if(substr(a.establec,8,1) = '2', 1, 0)) as centro_salud,
			sum(if(substr(a.establec,8,1) = '3', 1, 0)) as puesto_salud,
			sum(if(substr(a.establec,8,1) != '1' and substr(a.establec,8,1) != '2' and
			substr(a.establec,8,1) != '3', 1, 0)) as otros,
			sum(if(a.establec != '', 1, 0)) as total
			from
			cobertura a left join microred b on concat(a.diresa,a.red,a.microred) = concat(b.subregion,b.red,b.codigo)
			where ano = $anio and semana = $semana and notificacion = '1' and a.diresa = '".$this->session->userdata('diresa')."' and a.red = '".$this->session->userdata('red')."'
			group by a.ano, a.semana, b.nombre
			order by b.nombre) y
			USING (microred)) q
			left join
			(select b.nombre as microred,
			sum(if(substr(a.establec,8,1) != '', 1, 0)) as no_notifico
			from
			cobertura a left join microred b on concat(a.diresa,a.red,a.microred) = concat(b.subregion,b.red,b.codigo)
			where ano = $anio and semana = $semana and notificacion = '0' and a.diresa = '".$this->session->userdata('diresa')."' and a.red = '".$this->session->userdata('red')."'
			group by a.ano, a.semana, b.nombre
			order by b.nombre) z
			on q.microred = z.microred
			left join
			(select b.nombre as microred,
			sum(if(substr(a.establec,8,1) != '', 1, 0)) as not_neg
			from
			cobertura a left join microred b on concat(a.diresa,a.red,a.microred) = concat(b.subregion,b.red,b.codigo)
			where ano = $anio and semana = $semana and notificacion = '2' and a.diresa = '".$this->session->userdata('diresa')."' and a.red = '".$this->session->userdata('red')."'
			group by a.ano, a.semana, b.nombre
			order by b.nombre) p
			on q.microred = p.microred
			";
			
			$query = $this->db->query($plantilla);
			
			return $query->result();
			
			break;
		}
	}
	
	//Proceso para el reporte de notificación
	public function notificacion($anio, $semana)
	{
		switch($this->session->userdata('nivel')){
			case 1:
			$plantilla = "
			select a.nombre as nombre,
			sum(if(b.semana = '1', 1, 0)) as 's1',
			sum(if(b.semana = '2', 1, 0)) as 's2',
			sum(if(b.semana = '3', 1, 0)) as 's3',
			sum(if(b.semana = '4', 1, 0)) as 's4',
			sum(if(b.semana = '5', 1, 0)) as 's5',
			sum(if(b.semana = '6', 1, 0)) as 's6',
			sum(if(b.semana = '7', 1, 0)) as 's7',
			sum(if(b.semana = '8', 1, 0)) as 's8',
			sum(if(b.semana = '9', 1, 0)) as 's9',
			sum(if(b.semana = '10', 1, 0)) as 's10',
			sum(if(b.semana = '11', 1, 0)) as 's11',
			sum(if(b.semana = '12', 1, 0)) as 's12',
			sum(if(b.semana = '13', 1, 0)) as 's13',
			sum(if(b.semana = '14', 1, 0)) as 's14',
			sum(if(b.semana = '15', 1, 0)) as 's15',
			sum(if(b.semana = '16', 1, 0)) as 's16',
			sum(if(b.semana = '17', 1, 0)) as 's17',
			sum(if(b.semana = '18', 1, 0)) as 's18',
			sum(if(b.semana = '19', 1, 0)) as 's19',
			sum(if(b.semana = '20', 1, 0)) as 's20',
			sum(if(b.semana = '21', 1, 0)) as 's21',
			sum(if(b.semana = '22', 1, 0)) as 's22',
			sum(if(b.semana = '23', 1, 0)) as 's23',
			sum(if(b.semana = '24', 1, 0)) as 's24',
			sum(if(b.semana = '25', 1, 0)) as 's25',
			sum(if(b.semana = '26', 1, 0)) as 's26',
			sum(if(b.semana = '27', 1, 0)) as 's27',
			sum(if(b.semana = '28', 1, 0)) as 's28',
			sum(if(b.semana = '29', 1, 0)) as 's29',
			sum(if(b.semana = '30', 1, 0)) as 's30',
			sum(if(b.semana = '31', 1, 0)) as 's31',
			sum(if(b.semana = '32', 1, 0)) as 's32',
			sum(if(b.semana = '33', 1, 0)) as 's33',
			sum(if(b.semana = '34', 1, 0)) as 's34',
			sum(if(b.semana = '35', 1, 0)) as 's35',
			sum(if(b.semana = '36', 1, 0)) as 's36',
			sum(if(b.semana = '37', 1, 0)) as 's37',
			sum(if(b.semana = '38', 1, 0)) as 's38',
			sum(if(b.semana = '39', 1, 0)) as 's39',
			sum(if(b.semana = '40', 1, 0)) as 's40',
			sum(if(b.semana = '41', 1, 0)) as 's41',
			sum(if(b.semana = '42', 1, 0)) as 's42',
			sum(if(b.semana = '43', 1, 0)) as 's43',
			sum(if(b.semana = '44', 1, 0)) as 's44',
			sum(if(b.semana = '45', 1, 0)) as 's45',
			sum(if(b.semana = '46', 1, 0)) as 's46',
			sum(if(b.semana = '47', 1, 0)) as 's47',
			sum(if(b.semana = '48', 1, 0)) as 's48',
			sum(if(b.semana = '49', 1, 0)) as 's49',
			sum(if(b.semana = '50', 1, 0)) as 's50',
			sum(if(b.semana = '51', 1, 0)) as 's51',
			sum(if(b.semana = '52', 1, 0)) as 's52',
			sum(if(b.semana = '53', 1, 0)) as 's53'
			from
			diresas a
			left join
			(select * from iras where semana <= $semana) b
			on a.codigo = b.sub_reg_nt
			group by a.nombre
			";
			
			$query = $this->db->query($plantilla);
			
			return $query->result();
			
			break;
			case 4:
			$plantilla = "
			select a.nombre as nombre,
			sum(if(b.semana = '1', 1, 0)) as 's1',
			sum(if(b.semana = '2', 1, 0)) as 's2',
			sum(if(b.semana = '3', 1, 0)) as 's3',
			sum(if(b.semana = '4', 1, 0)) as 's4',
			sum(if(b.semana = '5', 1, 0)) as 's5',
			sum(if(b.semana = '6', 1, 0)) as 's6',
			sum(if(b.semana = '7', 1, 0)) as 's7',
			sum(if(b.semana = '8', 1, 0)) as 's8',
			sum(if(b.semana = '9', 1, 0)) as 's9',
			sum(if(b.semana = '10', 1, 0)) as 's10',
			sum(if(b.semana = '11', 1, 0)) as 's11',
			sum(if(b.semana = '12', 1, 0)) as 's12',
			sum(if(b.semana = '13', 1, 0)) as 's13',
			sum(if(b.semana = '14', 1, 0)) as 's14',
			sum(if(b.semana = '15', 1, 0)) as 's15',
			sum(if(b.semana = '16', 1, 0)) as 's16',
			sum(if(b.semana = '17', 1, 0)) as 's17',
			sum(if(b.semana = '18', 1, 0)) as 's18',
			sum(if(b.semana = '19', 1, 0)) as 's19',
			sum(if(b.semana = '20', 1, 0)) as 's20',
			sum(if(b.semana = '21', 1, 0)) as 's21',
			sum(if(b.semana = '22', 1, 0)) as 's22',
			sum(if(b.semana = '23', 1, 0)) as 's23',
			sum(if(b.semana = '24', 1, 0)) as 's24',
			sum(if(b.semana = '25', 1, 0)) as 's25',
			sum(if(b.semana = '26', 1, 0)) as 's26',
			sum(if(b.semana = '27', 1, 0)) as 's27',
			sum(if(b.semana = '28', 1, 0)) as 's28',
			sum(if(b.semana = '29', 1, 0)) as 's29',
			sum(if(b.semana = '30', 1, 0)) as 's30',
			sum(if(b.semana = '31', 1, 0)) as 's31',
			sum(if(b.semana = '32', 1, 0)) as 's32',
			sum(if(b.semana = '33', 1, 0)) as 's33',
			sum(if(b.semana = '34', 1, 0)) as 's34',
			sum(if(b.semana = '35', 1, 0)) as 's35',
			sum(if(b.semana = '36', 1, 0)) as 's36',
			sum(if(b.semana = '37', 1, 0)) as 's37',
			sum(if(b.semana = '38', 1, 0)) as 's38',
			sum(if(b.semana = '39', 1, 0)) as 's39',
			sum(if(b.semana = '40', 1, 0)) as 's40',
			sum(if(b.semana = '41', 1, 0)) as 's41',
			sum(if(b.semana = '42', 1, 0)) as 's42',
			sum(if(b.semana = '43', 1, 0)) as 's43',
			sum(if(b.semana = '44', 1, 0)) as 's44',
			sum(if(b.semana = '45', 1, 0)) as 's45',
			sum(if(b.semana = '46', 1, 0)) as 's46',
			sum(if(b.semana = '47', 1, 0)) as 's47',
			sum(if(b.semana = '48', 1, 0)) as 's48',
			sum(if(b.semana = '49', 1, 0)) as 's49',
			sum(if(b.semana = '50', 1, 0)) as 's50',
			sum(if(b.semana = '51', 1, 0)) as 's51',
			sum(if(b.semana = '52', 1, 0)) as 's52',
			sum(if(b.semana = '53', 1, 0)) as 's53'
			from
			diresas a
			left join
			(select * from iras where semana <= $semana) b
			on a.codigo = b.sub_reg_nt
			group by a.nombre
			";
			
			$query = $this->db->query($plantilla);
			
			return $query->result();
			
			break;
			case 5:
			$plantilla = "
			select c.nombre as nombre,
			sum(if(b.semana = '1', 1, 0)) as 's1',
			sum(if(b.semana = '2', 1, 0)) as 's2',
			sum(if(b.semana = '3', 1, 0)) as 's3',
			sum(if(b.semana = '4', 1, 0)) as 's4',
			sum(if(b.semana = '5', 1, 0)) as 's5',
			sum(if(b.semana = '6', 1, 0)) as 's6',
			sum(if(b.semana = '7', 1, 0)) as 's7',
			sum(if(b.semana = '8', 1, 0)) as 's8',
			sum(if(b.semana = '9', 1, 0)) as 's9',
			sum(if(b.semana = '10', 1, 0)) as 's10',
			sum(if(b.semana = '11', 1, 0)) as 's11',
			sum(if(b.semana = '12', 1, 0)) as 's12',
			sum(if(b.semana = '13', 1, 0)) as 's13',
			sum(if(b.semana = '14', 1, 0)) as 's14',
			sum(if(b.semana = '15', 1, 0)) as 's15',
			sum(if(b.semana = '16', 1, 0)) as 's16',
			sum(if(b.semana = '17', 1, 0)) as 's17',
			sum(if(b.semana = '18', 1, 0)) as 's18',
			sum(if(b.semana = '19', 1, 0)) as 's19',
			sum(if(b.semana = '20', 1, 0)) as 's20',
			sum(if(b.semana = '21', 1, 0)) as 's21',
			sum(if(b.semana = '22', 1, 0)) as 's22',
			sum(if(b.semana = '23', 1, 0)) as 's23',
			sum(if(b.semana = '24', 1, 0)) as 's24',
			sum(if(b.semana = '25', 1, 0)) as 's25',
			sum(if(b.semana = '26', 1, 0)) as 's26',
			sum(if(b.semana = '27', 1, 0)) as 's27',
			sum(if(b.semana = '28', 1, 0)) as 's28',
			sum(if(b.semana = '29', 1, 0)) as 's29',
			sum(if(b.semana = '30', 1, 0)) as 's30',
			sum(if(b.semana = '31', 1, 0)) as 's31',
			sum(if(b.semana = '32', 1, 0)) as 's32',
			sum(if(b.semana = '33', 1, 0)) as 's33',
			sum(if(b.semana = '34', 1, 0)) as 's34',
			sum(if(b.semana = '35', 1, 0)) as 's35',
			sum(if(b.semana = '36', 1, 0)) as 's36',
			sum(if(b.semana = '37', 1, 0)) as 's37',
			sum(if(b.semana = '38', 1, 0)) as 's38',
			sum(if(b.semana = '39', 1, 0)) as 's39',
			sum(if(b.semana = '40', 1, 0)) as 's40',
			sum(if(b.semana = '41', 1, 0)) as 's41',
			sum(if(b.semana = '42', 1, 0)) as 's42',
			sum(if(b.semana = '43', 1, 0)) as 's43',
			sum(if(b.semana = '44', 1, 0)) as 's44',
			sum(if(b.semana = '45', 1, 0)) as 's45',
			sum(if(b.semana = '46', 1, 0)) as 's46',
			sum(if(b.semana = '47', 1, 0)) as 's47',
			sum(if(b.semana = '48', 1, 0)) as 's48',
			sum(if(b.semana = '49', 1, 0)) as 's49',
			sum(if(b.semana = '50', 1, 0)) as 's50',
			sum(if(b.semana = '51', 1, 0)) as 's51',
			sum(if(b.semana = '52', 1, 0)) as 's52',
			sum(if(b.semana = '53', 1, 0)) as 's53'
			from
			renace a
			left join
			(select * from iras where sub_reg_nt = '".$this->session->userdata('diresa')."' and semana <= $semana) b
			on a.cod_est = b.e_salud
			left join
			redes as c
			on concat(b.sub_reg_nt, b.red) = concat(c.subregion,c.codigo)
			where a.subregion = '".$this->session->userdata('diresa')."' and c.codigo <> '' and c.estado = '1'
			group by c.nombre
			";
			
			$query = $this->db->query($plantilla);
			
			return $query->result();
			
			break;
			case 6:
			$plantilla = "
			select c.nombre as nombre,
			sum(if(b.semana = '1', 1, 0)) as 's1',
			sum(if(b.semana = '2', 1, 0)) as 's2',
			sum(if(b.semana = '3', 1, 0)) as 's3',
			sum(if(b.semana = '4', 1, 0)) as 's4',
			sum(if(b.semana = '5', 1, 0)) as 's5',
			sum(if(b.semana = '6', 1, 0)) as 's6',
			sum(if(b.semana = '7', 1, 0)) as 's7',
			sum(if(b.semana = '8', 1, 0)) as 's8',
			sum(if(b.semana = '9', 1, 0)) as 's9',
			sum(if(b.semana = '10', 1, 0)) as 's10',
			sum(if(b.semana = '11', 1, 0)) as 's11',
			sum(if(b.semana = '12', 1, 0)) as 's12',
			sum(if(b.semana = '13', 1, 0)) as 's13',
			sum(if(b.semana = '14', 1, 0)) as 's14',
			sum(if(b.semana = '15', 1, 0)) as 's15',
			sum(if(b.semana = '16', 1, 0)) as 's16',
			sum(if(b.semana = '17', 1, 0)) as 's17',
			sum(if(b.semana = '18', 1, 0)) as 's18',
			sum(if(b.semana = '19', 1, 0)) as 's19',
			sum(if(b.semana = '20', 1, 0)) as 's20',
			sum(if(b.semana = '21', 1, 0)) as 's21',
			sum(if(b.semana = '22', 1, 0)) as 's22',
			sum(if(b.semana = '23', 1, 0)) as 's23',
			sum(if(b.semana = '24', 1, 0)) as 's24',
			sum(if(b.semana = '25', 1, 0)) as 's25',
			sum(if(b.semana = '26', 1, 0)) as 's26',
			sum(if(b.semana = '27', 1, 0)) as 's27',
			sum(if(b.semana = '28', 1, 0)) as 's28',
			sum(if(b.semana = '29', 1, 0)) as 's29',
			sum(if(b.semana = '30', 1, 0)) as 's30',
			sum(if(b.semana = '31', 1, 0)) as 's31',
			sum(if(b.semana = '32', 1, 0)) as 's32',
			sum(if(b.semana = '33', 1, 0)) as 's33',
			sum(if(b.semana = '34', 1, 0)) as 's34',
			sum(if(b.semana = '35', 1, 0)) as 's35',
			sum(if(b.semana = '36', 1, 0)) as 's36',
			sum(if(b.semana = '37', 1, 0)) as 's37',
			sum(if(b.semana = '38', 1, 0)) as 's38',
			sum(if(b.semana = '39', 1, 0)) as 's39',
			sum(if(b.semana = '40', 1, 0)) as 's40',
			sum(if(b.semana = '41', 1, 0)) as 's41',
			sum(if(b.semana = '42', 1, 0)) as 's42',
			sum(if(b.semana = '43', 1, 0)) as 's43',
			sum(if(b.semana = '44', 1, 0)) as 's44',
			sum(if(b.semana = '45', 1, 0)) as 's45',
			sum(if(b.semana = '46', 1, 0)) as 's46',
			sum(if(b.semana = '47', 1, 0)) as 's47',
			sum(if(b.semana = '48', 1, 0)) as 's48',
			sum(if(b.semana = '49', 1, 0)) as 's49',
			sum(if(b.semana = '50', 1, 0)) as 's50',
			sum(if(b.semana = '51', 1, 0)) as 's51',
			sum(if(b.semana = '52', 1, 0)) as 's52',
			sum(if(b.semana = '53', 1, 0)) as 's53'
			from
			renace a
			left join
			(select * from iras where sub_reg_nt = '".$this->session->userdata('diresa')."' and 
			red = '".$this->session->userdata('red')."' and semana <= $semana) b
			on a.cod_est = b.e_salud
			left join
			microred as c
			on concat(b.sub_reg_nt, b.red) = concat(c.subregion,c.red)
			where a.subregion = '".$this->session->userdata('diresa')."' and 
			a.red = '".$this->session->userdata('red')."' and c.codigo <> '' and c.estado = '1'
			group by c.nombre
			";
			
			$query = $this->db->query($plantilla);
			
			return $query->result();
			
			break;
			case 7:
			$plantilla = "
			select a.raz_soc as nombre,
			sum(if(b.semana = '1', 1, 0)) as 's1',
			sum(if(b.semana = '2', 1, 0)) as 's2',
			sum(if(b.semana = '3', 1, 0)) as 's3',
			sum(if(b.semana = '4', 1, 0)) as 's4',
			sum(if(b.semana = '5', 1, 0)) as 's5',
			sum(if(b.semana = '6', 1, 0)) as 's6',
			sum(if(b.semana = '7', 1, 0)) as 's7',
			sum(if(b.semana = '8', 1, 0)) as 's8',
			sum(if(b.semana = '9', 1, 0)) as 's9',
			sum(if(b.semana = '10', 1, 0)) as 's10',
			sum(if(b.semana = '11', 1, 0)) as 's11',
			sum(if(b.semana = '12', 1, 0)) as 's12',
			sum(if(b.semana = '13', 1, 0)) as 's13',
			sum(if(b.semana = '14', 1, 0)) as 's14',
			sum(if(b.semana = '15', 1, 0)) as 's15',
			sum(if(b.semana = '16', 1, 0)) as 's16',
			sum(if(b.semana = '17', 1, 0)) as 's17',
			sum(if(b.semana = '18', 1, 0)) as 's18',
			sum(if(b.semana = '19', 1, 0)) as 's19',
			sum(if(b.semana = '20', 1, 0)) as 's20',
			sum(if(b.semana = '21', 1, 0)) as 's21',
			sum(if(b.semana = '22', 1, 0)) as 's22',
			sum(if(b.semana = '23', 1, 0)) as 's23',
			sum(if(b.semana = '24', 1, 0)) as 's24',
			sum(if(b.semana = '25', 1, 0)) as 's25',
			sum(if(b.semana = '26', 1, 0)) as 's26',
			sum(if(b.semana = '27', 1, 0)) as 's27',
			sum(if(b.semana = '28', 1, 0)) as 's28',
			sum(if(b.semana = '29', 1, 0)) as 's29',
			sum(if(b.semana = '30', 1, 0)) as 's30',
			sum(if(b.semana = '31', 1, 0)) as 's31',
			sum(if(b.semana = '32', 1, 0)) as 's32',
			sum(if(b.semana = '33', 1, 0)) as 's33',
			sum(if(b.semana = '34', 1, 0)) as 's34',
			sum(if(b.semana = '35', 1, 0)) as 's35',
			sum(if(b.semana = '36', 1, 0)) as 's36',
			sum(if(b.semana = '37', 1, 0)) as 's37',
			sum(if(b.semana = '38', 1, 0)) as 's38',
			sum(if(b.semana = '39', 1, 0)) as 's39',
			sum(if(b.semana = '40', 1, 0)) as 's40',
			sum(if(b.semana = '41', 1, 0)) as 's41',
			sum(if(b.semana = '42', 1, 0)) as 's42',
			sum(if(b.semana = '43', 1, 0)) as 's43',
			sum(if(b.semana = '44', 1, 0)) as 's44',
			sum(if(b.semana = '45', 1, 0)) as 's45',
			sum(if(b.semana = '46', 1, 0)) as 's46',
			sum(if(b.semana = '47', 1, 0)) as 's47',
			sum(if(b.semana = '48', 1, 0)) as 's48',
			sum(if(b.semana = '49', 1, 0)) as 's49',
			sum(if(b.semana = '50', 1, 0)) as 's50',
			sum(if(b.semana = '51', 1, 0)) as 's51',
			sum(if(b.semana = '52', 1, 0)) as 's52',
			sum(if(b.semana = '53', 1, 0)) as 's53'
			from
			renace a
			left join
			(select * from iras where sub_reg_nt = '".$this->session->userdata('diresa')."' and 
			red = '".$this->session->userdata('red')."' and microred = '".$this->session->userdata('microred')."' 
			and semana <= $semana) b 
			on concat(b.sub_reg_nt, b.red, b.microred) = concat(a.subregion,a.red,a.microred)
			where a.subregion = '".$this->session->userdata('diresa')."' and 
			a.red = '".$this->session->userdata('red')."' and a.microred = '".$this->session->userdata('microred')."' 
			group by a.raz_soc
			";
			
			$query = $this->db->query($plantilla);
			
			return $query->result();
			
			break;
			default:
			$this->session->set_flashdata('error', 'Este proceso no est&aacute; activo para su nivel de usuario');
			redirect(site_url("backend/index/principal"), 301);
			break;
		}
	}
	
	public function notificacionExterna()
	{
		switch($this->session->userdata('nivel')){
			case 5:
			$plantilla = "
			select a.ano, a.semana, d.diagno as diagnostico, a.tipo_dx, a.fecha_not, a.semana_not, a.fecha_ini, 
			c.nombre as diresa, b.nombre as distrito
			from
			(select * from individual where subregion = '".$this->session->userdata('diresa')."' and 
			sub_reg_nt <> '".$this->session->userdata('diresa')."') a
			left join
			distrito b
			on a.ubigeo = b.ubigeo
			left join
			diresas c
			on a.sub_reg_nt = c.codigo
			left join
			diagno d
			on a.diagnostic = d.cie_10
			";
			$query = $this->db->query($plantilla);
			
			return $query->result();
			
			break;
			default:
			$this->session->set_flashdata('error', 'Este proceso no est&aacute; activo para su nivel de usuario');
			redirect(site_url("index/principal"), 301);
			break;
		}
	}
	
	//Reporte de la notificación individual en descripción de tiempo por nivel de ubigeo
	
	public function notificacionIndTiempoUbigeo($anio, $diagno, $departamento, $provincia, $distrito)
	{
		if(!empty($departamento) and !empty($provincia) and !empty($distrito)){
			$plantilla = "
			select a.semana,
			a.casos as casos_1,
			a.poblacion as pob_1,
			round((a.casos / a.poblacion) * 100000,2) as inc_1,
			if(a.semana=d.semana, d.defuncion, 0) as def_1,
			round((if(a.semana=d.semana, d.defuncion, 0) / a.poblacion * 1000),2) as mort_1,
			round((if(a.semana=d.semana, d.defuncion, 0) / a.casos * 100),2) as letal_1,
			b.casos as casos_2,
			b.poblacion as pob_2,
			round((b.casos / b.poblacion) * 100000,2) as inc_2,
			if(a.semana=e.semana, e.defuncion, 0) as def_2,
			round((if(a.semana=e.semana, e.defuncion, 0) / b.poblacion * 1000),2) as mort_2,
			round((if(a.semana=e.semana, e.defuncion, 0) / b.casos * 100),2) as letal_2,
			ifnull(c.casos,0) as casos_3,
			ifnull(c.poblacion,0) as pob_3,
			ifnull(round((c.casos / c.poblacion) * 100000,2),0) as inc_3,
			ifnull(if(a.semana=f.semana, f.defuncion, 0),0) as def_3,
			round((if(a.semana=f.semana, f.defuncion, 0) / c.poblacion * 1000),2) as mort_3,
			round((if(a.semana=f.semana, f.defuncion, 0) / c.casos * 100),2) as letal_3
			from
			(select ano, semana, diagnostic, count(ubigeo) as casos,
			(select sum(pobtot) from codubi where ano = $anio-2) as poblacion from individual_ant
			where ano = $anio-2 and diagnostic = '".$diagno."' and tipo_dx != 'D' and ubigeo = '".$distrito."' group by ano, semana) a
			left join
			(select ano, semana, diagnostic, count(ubigeo) as casos, (select sum(pobtot) from codubi where ano = $anio-1) as poblacion from individual_ant
			where ano = $anio-1 and diagnostic = '".$diagno."' and tipo_dx != 'D' and ubigeo = '".$distrito."' group by ano, semana) b
			on concat(a.semana,a.diagnostic) = concat(b.semana,b.diagnostic)
			left join
			(select ano, semana, diagnostic, count(ubigeo) as casos, (select sum(pobtot) from codubi where ano = $anio) as poblacion from individual
			where ano = $anio and diagnostic = '".$diagno."' and tipo_dx != 'D' and ubigeo = '".$distrito."' group by ano, semana) c
			on concat(a.semana,a.diagnostic) = concat(c.semana,c.diagnostic)
			left join
			(select ano, semana, diagnostic, count(ubigeo) as defuncion from individual_ant
			where ano = $anio-2 and diagnostic = '".$diagno."' and tipo_dx != 'D' and ubigeo = '".$distrito."' and fecha_def != '0000-00-00' group by ano, semana) d
			on concat(a.semana,a.diagnostic) = concat(d.semana,d.diagnostic)
			left join
			(select ano, semana, diagnostic, count(ubigeo) as defuncion from individual_ant
			where ano = $anio-1 and diagnostic = '".$diagno."' and tipo_dx != 'D' and ubigeo = '".$distrito."' and fecha_def != '0000-00-00' group by ano, semana) e
			on concat(a.semana,a.diagnostic) = concat(e.semana,e.diagnostic)
			left join
			(select ano, semana, diagnostic, count(ubigeo) as defuncion from individual
			where ano = $anio and diagnostic = '".$diagno."' and tipo_dx != 'D' and ubigeo = '".$distrito."' and fecha_def != '0000-00-00' group by ano, semana) f
			on concat(a.semana,a.diagnostic) = concat(f.semana,f.diagnostic)
			group by a.semana			
			";
		}elseif(!empty($departamento) and !empty($provincia) and empty($distrito)){
			$plantilla = "
			select a.semana,
			a.casos as casos_1,
			a.poblacion as pob_1,
			round((a.casos / a.poblacion) * 100000,2) as inc_1,
			if(a.semana=d.semana, d.defuncion, 0) as def_1,
			round((if(a.semana=d.semana, d.defuncion, 0) / a.poblacion * 1000),2) as mort_1,
			round((if(a.semana=d.semana, d.defuncion, 0) / a.casos * 100),2) as letal_1,
			b.casos as casos_2,
			b.poblacion as pob_2,
			round((b.casos / b.poblacion) * 100000,2) as inc_2,
			if(a.semana=e.semana, e.defuncion, 0) as def_2,
			round((if(a.semana=e.semana, e.defuncion, 0) / b.poblacion * 1000),2) as mort_2,
			round((if(a.semana=e.semana, e.defuncion, 0) / b.casos * 100),2) as letal_2,
			ifnull(c.casos,0) as casos_3,
			ifnull(c.poblacion,0) as pob_3,
			ifnull(round((c.casos / c.poblacion) * 100000,2),0) as inc_3,
			ifnull(if(a.semana=f.semana, f.defuncion, 0),0) as def_3,
			round((if(a.semana=f.semana, f.defuncion, 0) / c.poblacion * 1000),2) as mort_3,
			round((if(a.semana=f.semana, f.defuncion, 0) / c.casos * 100),2) as letal_3
			from
			(select ano, semana, diagnostic, count(ubigeo) as casos,
			(select sum(pobtot) from codubi where ano = $anio-2) as poblacion from individual_ant
			where ano = $anio-2 and diagnostic = '".$diagno."' and tipo_dx != 'D' and substr(ubigeo,1,4) = '".$provincia."' group by ano, semana) a
			left join
			(select ano, semana, diagnostic, count(ubigeo) as casos, (select sum(pobtot) from codubi where ano = $anio-1) as poblacion from individual_ant
			where ano = $anio-1 and diagnostic = '".$diagno."' and tipo_dx != 'D' and substr(ubigeo,1,4) = '".$provincia."' group by ano, semana) b
			on concat(a.semana,a.diagnostic) = concat(b.semana,b.diagnostic)
			left join
			(select ano, semana, diagnostic, count(ubigeo) as casos, (select sum(pobtot) from codubi where ano = $anio) as poblacion from individual
			where ano = $anio and diagnostic = '".$diagno."' and tipo_dx != 'D' and substr(ubigeo,1,4) = '".$provincia."' group by ano, semana) c
			on concat(a.semana,a.diagnostic) = concat(c.semana,c.diagnostic)
			left join
			(select ano, semana, diagnostic, count(ubigeo) as defuncion from individual_ant
			where ano = $anio-2 and diagnostic = '".$diagno."' and tipo_dx != 'D' and substr(ubigeo,1,4) = '".$provincia."' and fecha_def != '0000-00-00' group by ano, semana) d
			on concat(a.semana,a.diagnostic) = concat(d.semana,d.diagnostic)
			left join
			(select ano, semana, diagnostic, count(ubigeo) as defuncion from individual_ant
			where ano = $anio-1 and diagnostic = '".$diagno."' and tipo_dx != 'D' and substr(ubigeo,1,4) = '".$provincia."' and fecha_def != '0000-00-00' group by ano, semana) e
			on concat(a.semana,a.diagnostic) = concat(e.semana,e.diagnostic)
			left join
			(select ano, semana, diagnostic, count(ubigeo) as defuncion from individual
			where ano = $anio and diagnostic = '".$diagno."' and tipo_dx != 'D' and substr(ubigeo,1,4) = '".$provincia."' and fecha_def != '0000-00-00' group by ano, semana) f
			on concat(a.semana,a.diagnostic) = concat(f.semana,f.diagnostic)
			group by a.semana			
			";
		}elseif(!empty($departamento) and empty($provincia) and empty($distrito)){
			$plantilla = "
			select a.semana,
			a.casos as casos_1,
			a.poblacion as pob_1,
			round((a.casos / a.poblacion) * 100000,2) as inc_1,
			if(a.semana=d.semana, d.defuncion, 0) as def_1,
			round((if(a.semana=d.semana, d.defuncion, 0) / a.poblacion * 1000),2) as mort_1,
			round((if(a.semana=d.semana, d.defuncion, 0) / a.casos * 100),2) as letal_1,
			b.casos as casos_2,
			b.poblacion as pob_2,
			round((b.casos / b.poblacion) * 100000,2) as inc_2,
			if(a.semana=e.semana, e.defuncion, 0) as def_2,
			round((if(a.semana=e.semana, e.defuncion, 0) / b.poblacion * 1000),2) as mort_2,
			round((if(a.semana=e.semana, e.defuncion, 0) / b.casos * 100),2) as letal_2,
			ifnull(c.casos,0) as casos_3,
			ifnull(c.poblacion,0) as pob_3,
			ifnull(round((c.casos / c.poblacion) * 100000,2),0) as inc_3,
			ifnull(if(a.semana=f.semana, f.defuncion, 0),0) as def_3,
			round((if(a.semana=f.semana, f.defuncion, 0) / c.poblacion * 1000),2) as mort_3,
			round((if(a.semana=f.semana, f.defuncion, 0) / c.casos * 100),2) as letal_3
			from
			(select ano, semana, diagnostic, count(ubigeo) as casos,
			(select sum(pobtot) from codubi where ano = $anio-2) as poblacion from individual_ant
			where ano = $anio-2 and diagnostic = '".$diagno."' and tipo_dx != 'D' 
			and substr(ubigeo,1,2) = '".$departamento."' group by ano, semana) a
			left join
			(select ano, semana, diagnostic, count(ubigeo) as casos, (select sum(pobtot) 
			from codubi where ano = $anio-1) as poblacion from individual_ant
			where ano = $anio-1 and diagnostic = '".$diagno."' and tipo_dx != 'D' and substr(ubigeo,1,2) = '".$departamento."' 
			group by ano, semana) b
			on concat(a.semana,a.diagnostic) = concat(b.semana,b.diagnostic)
			left join
			(select ano, semana, diagnostic, count(ubigeo) as casos, (select sum(pobtot) 
			from codubi where ano = $anio) as poblacion from individual
			where ano = $anio and diagnostic = '".$diagno."' and tipo_dx != 'D' and substr(ubigeo,1,2) = '".$departamento."'
			group by ano, semana) c
			on concat(a.semana,a.diagnostic) = concat(c.semana,c.diagnostic)
			left join
			(select ano, semana, diagnostic, count(ubigeo) as defuncion from individual_ant
			where ano = $anio-2 and diagnostic = '".$diagno."' and tipo_dx != 'D' and substr(ubigeo,1,2) = '".$departamento."' and fecha_def != '0000-00-00' group by ano, semana) d
			on concat(a.semana,a.diagnostic) = concat(d.semana,d.diagnostic)
			left join
			(select ano, semana, diagnostic, count(ubigeo) as defuncion from individual_ant
			where ano = $anio-1 and diagnostic = '".$diagno."' and tipo_dx != 'D' and substr(ubigeo,1,2) = '".$departamento."' and fecha_def != '0000-00-00' 
			group by ano, semana) e
			on concat(a.semana,a.diagnostic) = concat(e.semana,e.diagnostic)
			left join
			(select ano, semana, diagnostic, count(ubigeo) as defuncion from individual
			where ano = $anio and diagnostic = '".$diagno."' and tipo_dx != 'D' and substr(ubigeo,1,2) = '".$departamento."' and fecha_def != '0000-00-00' group by ano, semana) f
			on concat(a.semana,a.diagnostic) = concat(f.semana,f.diagnostic)
			group by a.semana			
			";
		}elseif(empty($departamento) and empty($provincia) and empty($distrito)){
			if($this->session->userdata('nivel') == '1' or $this->session->userdata('nivel') == '4'){
				$plantilla = "
				select a.semana,
				a.casos as casos_1,
				a.poblacion as pob_1,
				round((a.casos / a.poblacion) * 100000,2) as inc_1,
				if(a.semana=d.semana, d.defuncion, 0) as def_1,
				round((if(a.semana=d.semana, d.defuncion, 0) / a.poblacion * 1000),2) as mort_1,
				round((if(a.semana=d.semana, d.defuncion, 0) / a.casos * 100),2) as letal_1,
				b.casos as casos_2,
				b.poblacion as pob_2,
				round((b.casos / b.poblacion) * 100000,2) as inc_2,
				if(a.semana=e.semana, e.defuncion, 0) as def_2,
				round((if(a.semana=e.semana, e.defuncion, 0) / b.poblacion * 1000),2) as mort_2,
				round((if(a.semana=e.semana, e.defuncion, 0) / b.casos * 100),2) as letal_2,
				ifnull(c.casos,0) as casos_3,
				ifnull(c.poblacion,0) as pob_3,
				ifnull(round((c.casos / c.poblacion) * 100000,2),0) as inc_3,
				ifnull(if(a.semana=f.semana, f.defuncion, 0),0) as def_3,
				round((if(a.semana=f.semana, f.defuncion, 0) / c.poblacion * 1000),2) as mort_3,
				round((if(a.semana=f.semana, f.defuncion, 0) / c.casos * 100),2) as letal_3
				from
				(select ano, semana, diagnostic, count(ubigeo) as casos,
				(select sum(pobtot) from codubi where ano = $anio-2) as poblacion from individual_ant
				where ano = $anio-2 and diagnostic = '".$diagno."' and tipo_dx != 'D' group by ano, semana) a
				left join
				(select ano, semana, diagnostic, count(ubigeo) as casos, 
				(select sum(pobtot) from codubi where ano = $anio-1) as poblacion from individual_ant
				where ano = $anio-1 and diagnostic = '".$diagno."' and tipo_dx != 'D' group by ano, semana) b
				on concat(a.semana,a.diagnostic) = concat(b.semana,b.diagnostic)
				left join
				(select ano, semana, diagnostic, count(ubigeo) as casos, 
				(select sum(pobtot) from codubi where ano = $anio) as poblacion from individual
				where ano = $anio and diagnostic = '".$diagno."' and tipo_dx != 'D' group by ano, semana) c
				on concat(a.semana,a.diagnostic) = concat(c.semana,c.diagnostic)
				left join
				(select ano, semana, diagnostic, count(ubigeo) as defuncion from individual_ant
				where ano = $anio-2 and diagnostic = '".$diagno."' and tipo_dx != 'D' and fecha_def != '0000-00-00' 
				group by ano, semana) d
				on concat(a.semana,a.diagnostic) = concat(d.semana,d.diagnostic)
				left join
				(select ano, semana, diagnostic, count(ubigeo) as defuncion from individual_ant
				where ano = $anio-1 and diagnostic = '".$diagno."' and tipo_dx != 'D' and fecha_def != '0000-00-00' 
				group by ano, semana) e
				on concat(a.semana,a.diagnostic) = concat(e.semana,e.diagnostic)
				left join
				(select ano, semana, diagnostic, count(ubigeo) as defuncion from individual
				where ano = $anio and diagnostic = '".$diagno."' and tipo_dx != 'D' and fecha_def != '0000-00-00' group by ano, semana) f
				on concat(a.semana,a.diagnostic) = concat(f.semana,f.diagnostic)
				group by a.semana			
				";
			}else{
				$this->session->set_flashdata('error', 'Debe elegir alg&uacute;n nivel de proceso, este reporte no est&aacute; activo para su nivel de usuario, comun&iacute;quese a notificacion@dge.gob.pe');
				redirect(site_url("reportes/repIndividual"), 301);
			}
		}
		
		$query = $this->db->query($plantilla);
		
		return $query->result();
		
	}

	//Reporte de la notificación individual en descripción de tiempo por nivel de Establecimiento de salud
	
	public function notificacionIndTiempoEESS($anio, $diagno, $diresa, $red, $microred, $establec)
	{
		if(!empty($diresa) and !empty($red) and !empty($microred) and !empty($establec)){
			$plantilla = "
			select a.semana,
			a.casos as casos_1,
			a.poblacion as pob_1,
			round((a.casos / a.poblacion) * 100000,2) as inc_1,
			if(a.semana=d.semana, d.defuncion, 0) as def_1,
			round((if(a.semana=d.semana, d.defuncion, 0) / a.poblacion * 1000),2) as mort_1,
			round((if(a.semana=d.semana, d.defuncion, 0) / a.casos * 100),2) as letal_1,
			b.casos as casos_2,
			b.poblacion as pob_2,
			round((b.casos / b.poblacion) * 100000,2) as inc_2,
			if(a.semana=e.semana, e.defuncion, 0) as def_2,
			round((if(a.semana=e.semana, e.defuncion, 0) / b.poblacion * 1000),2) as mort_2,
			round((if(a.semana=e.semana, e.defuncion, 0) / b.casos * 100),2) as letal_2,
			ifnull(c.casos,0) as casos_3,
			ifnull(c.poblacion,0) as pob_3,
			ifnull(round((c.casos / c.poblacion) * 100000,2),0) as inc_3,
			ifnull(if(a.semana=f.semana, f.defuncion, 0),0) as def_3,
			round((if(a.semana=f.semana, f.defuncion, 0) / c.poblacion * 1000),2) as mort_3,
			round((if(a.semana=f.semana, f.defuncion, 0) / c.casos * 100),2) as letal_3
			from
			(select ano, semana, diagnostic, count(ubigeo) as casos,
			(select sum(pobtot) from codubi where ano = $anio-2) as poblacion from individual_ant
			where ano = $anio-2 and diagnostic = '".$diagno."' and tipo_dx != 'D' and e_salud = '".$establec."' group by ano, semana) a
			left join
			(select ano, semana, diagnostic, count(ubigeo) as casos, (select sum(pobtot) from codubi where ano = $anio-1) as poblacion from individual_ant
			where ano = $anio-1 and diagnostic = '".$diagno."' and tipo_dx != 'D' and e_salud = '".$establec."' group by ano, semana) b
			on concat(a.semana,a.diagnostic) = concat(b.semana,b.diagnostic)
			left join
			(select ano, semana, diagnostic, count(ubigeo) as casos, (select sum(pobtot) from codubi where ano = $anio) as poblacion from individual
			where ano = $anio and diagnostic = '".$diagno."' and tipo_dx != 'D' and e_salud = '".$establec."' group by ano, semana) c
			on concat(a.semana,a.diagnostic) = concat(c.semana,c.diagnostic)
			left join
			(select ano, semana, diagnostic, count(ubigeo) as defuncion from individual_ant
			where ano = $anio-2 and diagnostic = '".$diagno."' and tipo_dx != 'D' and e_salud = '".$establec."' and fecha_def != '0000-00-00' group by ano, semana) d
			on concat(a.semana,a.diagnostic) = concat(d.semana,d.diagnostic)
			left join
			(select ano, semana, diagnostic, count(ubigeo) as defuncion from individual_ant
			where ano = $anio-1 and diagnostic = '".$diagno."' and tipo_dx != 'D' and e_salud = '".$establec."' and fecha_def != '0000-00-00' group by ano, semana) e
			on concat(a.semana,a.diagnostic) = concat(e.semana,e.diagnostic)
			left join
			(select ano, semana, diagnostic, count(ubigeo) as defuncion from individual
			where ano = $anio and diagnostic = '".$diagno."' and tipo_dx != 'D' and e_salud = '".$establec."' and fecha_def != '0000-00-00' group by ano, semana) f
			on concat(a.semana,a.diagnostic) = concat(f.semana,f.diagnostic)
			group by a.semana			
			";
		}elseif(!empty($diresa) and !empty($red) and !empty($microred) and empty($establec)){
			$plantilla = "
			select a.semana,
			a.casos as casos_1,
			a.poblacion as pob_1,
			round((a.casos / a.poblacion) * 100000,2) as inc_1,
			if(a.semana=d.semana, d.defuncion, 0) as def_1,
			round((if(a.semana=d.semana, d.defuncion, 0) / a.poblacion * 1000),2) as mort_1,
			round((if(a.semana=d.semana, d.defuncion, 0) / a.casos * 100),2) as letal_1,
			b.casos as casos_2,
			b.poblacion as pob_2,
			round((b.casos / b.poblacion) * 100000,2) as inc_2,
			if(a.semana=e.semana, e.defuncion, 0) as def_2,
			round((if(a.semana=e.semana, e.defuncion, 0) / b.poblacion * 1000),2) as mort_2,
			round((if(a.semana=e.semana, e.defuncion, 0) / b.casos * 100),2) as letal_2,
			ifnull(c.casos,0) as casos_3,
			ifnull(c.poblacion,0) as pob_3,
			ifnull(round((c.casos / c.poblacion) * 100000,2),0) as inc_3,
			ifnull(if(a.semana=f.semana, f.defuncion, 0),0) as def_3,
			round((if(a.semana=f.semana, f.defuncion, 0) / c.poblacion * 1000),2) as mort_3,
			round((if(a.semana=f.semana, f.defuncion, 0) / c.casos * 100),2) as letal_3
			from
			(select ano, semana, diagnostic, count(ubigeo) as casos,
			(select sum(pobtot) from codubi where ano = $anio-2) as poblacion from individual_ant
			where ano = $anio-2 and diagnostic = '".$diagno."' and tipo_dx != 'D' and sub_reg_nt = '".$diresa."' and red = '".$red."' and microred = '".$microred."' 
			group by ano, semana) a
			left join
			(select ano, semana, diagnostic, count(ubigeo) as casos, (select sum(pobtot) from codubi where ano = $anio-1) as poblacion from individual_ant
			where ano = $anio-1 and diagnostic = '".$diagno."' and tipo_dx != 'D' and sub_reg_nt = '".$diresa."' and red = '".$red."' and microred = '".$microred."' 
			group by ano, semana) b
			on concat(a.semana,a.diagnostic) = concat(b.semana,b.diagnostic)
			left join
			(select ano, semana, diagnostic, count(ubigeo) as casos, (select sum(pobtot) from codubi where ano = $anio) as poblacion from individual
			where ano = $anio and diagnostic = '".$diagno."' and tipo_dx != 'D' and sub_reg_nt = '".$diresa."' and red = '".$red."' and microred = '".$microred."' 
			group by ano, semana) c
			on concat(a.semana,a.diagnostic) = concat(c.semana,c.diagnostic)
			left join
			(select ano, semana, diagnostic, count(ubigeo) as defuncion from individual_ant
			where ano = $anio-2 and diagnostic = '".$diagno."' and tipo_dx != 'D' and sub_reg_nt = '".$diresa."' and red = '".$red."' and microred = '".$microred."' and fecha_def != '0000-00-00' group by ano, semana) d
			on concat(a.semana,a.diagnostic) = concat(d.semana,d.diagnostic)
			left join
			(select ano, semana, diagnostic, count(ubigeo) as defuncion from individual_ant
			where ano = $anio-1 and diagnostic = '".$diagno."' and tipo_dx != 'D' and sub_reg_nt = '".$diresa."' and red = '".$red."' and microred = '".$microred."' and fecha_def != '0000-00-00' group by ano, semana) e
			on concat(a.semana,a.diagnostic) = concat(e.semana,e.diagnostic)
			left join
			(select ano, semana, diagnostic, count(ubigeo) as defuncion from individual
			where ano = $anio and diagnostic = '".$diagno."' and tipo_dx != 'D' and sub_reg_nt = '".$diresa."' and red = '".$red."' and microred = '".$microred."' and fecha_def != '0000-00-00' group by ano, semana) f
			on concat(a.semana,a.diagnostic) = concat(f.semana,f.diagnostic)
			group by a.semana			
			";
		}elseif(!empty($diresa) and !empty($red) and empty($microred) and empty($establec)){
			$plantilla = "
			select a.semana,
			a.casos as casos_1,
			a.poblacion as pob_1,
			round((a.casos / a.poblacion) * 100000,2) as inc_1,
			if(a.semana=d.semana, d.defuncion, 0) as def_1,
			round((if(a.semana=d.semana, d.defuncion, 0) / a.poblacion * 1000),2) as mort_1,
			round((if(a.semana=d.semana, d.defuncion, 0) / a.casos * 100),2) as letal_1,
			b.casos as casos_2,
			b.poblacion as pob_2,
			round((b.casos / b.poblacion) * 100000,2) as inc_2,
			if(a.semana=e.semana, e.defuncion, 0) as def_2,
			round((if(a.semana=e.semana, e.defuncion, 0) / b.poblacion * 1000),2) as mort_2,
			round((if(a.semana=e.semana, e.defuncion, 0) / b.casos * 100),2) as letal_2,
			ifnull(c.casos,0) as casos_3,
			ifnull(c.poblacion,0) as pob_3,
			ifnull(round((c.casos / c.poblacion) * 100000,2),0) as inc_3,
			ifnull(if(a.semana=f.semana, f.defuncion, 0),0) as def_3,
			round((if(a.semana=f.semana, f.defuncion, 0) / c.poblacion * 1000),2) as mort_3,
			round((if(a.semana=f.semana, f.defuncion, 0) / c.casos * 100),2) as letal_3
			from
			(select ano, semana, diagnostic, count(ubigeo) as casos,
			(select sum(pobtot) from codubi where ano = $anio-2) as poblacion from individual_ant
			where ano = $anio-2 and diagnostic = '".$diagno."' and tipo_dx != 'D' and sub_reg_nt = '".$diresa."' and red = '".$red."' 
			group by ano, semana) a
			left join
			(select ano, semana, diagnostic, count(ubigeo) as casos, (select sum(pobtot) 
			from codubi where ano = $anio-1) as poblacion from individual_ant
			where ano = $anio-1 and diagnostic = '".$diagno."' and tipo_dx != 'D' and sub_reg_nt = '".$diresa."' and red = '".$red."'  
			group by ano, semana) b
			on concat(a.semana,a.diagnostic) = concat(b.semana,b.diagnostic)
			left join
			(select ano, semana, diagnostic, count(ubigeo) as casos, (select sum(pobtot) 
			from codubi where ano = $anio) as poblacion from individual
			where ano = $anio and diagnostic = '".$diagno."' and tipo_dx != 'D' and sub_reg_nt = '".$diresa."' and red = '".$red."' 
			group by ano, semana) c
			on concat(a.semana,a.diagnostic) = concat(c.semana,c.diagnostic)
			left join
			(select ano, semana, diagnostic, count(ubigeo) as defuncion from individual_ant
			where ano = $anio-2 and diagnostic = '".$diagno."' and tipo_dx != 'D' and sub_reg_nt = '".$diresa."' and red = '".$red."' and fecha_def != '0000-00-00' group by ano, semana) d
			on concat(a.semana,a.diagnostic) = concat(d.semana,d.diagnostic)
			left join
			(select ano, semana, diagnostic, count(ubigeo) as defuncion from individual_ant
			where ano = $anio-1 and diagnostic = '".$diagno."' and tipo_dx != 'D' and sub_reg_nt = '".$diresa."' and red = '".$red."' and fecha_def != '0000-00-00' 
			group by ano, semana) e
			on concat(a.semana,a.diagnostic) = concat(e.semana,e.diagnostic)
			left join
			(select ano, semana, diagnostic, count(ubigeo) as defuncion from individual
			where ano = $anio and diagnostic = '".$diagno."' and tipo_dx != 'D' and sub_reg_nt = '".$diresa."' and red = '".$red."' and fecha_def != '0000-00-00' group by ano, semana) f
			on concat(a.semana,a.diagnostic) = concat(f.semana,f.diagnostic)
			group by a.semana			
			";
		}elseif(!empty($diresa) and empty($red) and empty($microred) and empty($establec)){
			$plantilla = "
			select a.semana,
			a.casos as casos_1,
			a.poblacion as pob_1,
			round((a.casos / a.poblacion) * 100000,2) as inc_1,
			if(a.semana=d.semana, d.defuncion, 0) as def_1,
			round((if(a.semana=d.semana, d.defuncion, 0) / a.poblacion * 1000),2) as mort_1,
			round((if(a.semana=d.semana, d.defuncion, 0) / a.casos * 100),2) as letal_1,
			b.casos as casos_2,
			b.poblacion as pob_2,
			round((b.casos / b.poblacion) * 100000,2) as inc_2,
			if(a.semana=e.semana, e.defuncion, 0) as def_2,
			round((if(a.semana=e.semana, e.defuncion, 0) / b.poblacion * 1000),2) as mort_2,
			round((if(a.semana=e.semana, e.defuncion, 0) / b.casos * 100),2) as letal_2,
			ifnull(c.casos,0) as casos_3,
			ifnull(c.poblacion,0) as pob_3,
			ifnull(round((c.casos / c.poblacion) * 100000,2),0) as inc_3,
			ifnull(if(a.semana=f.semana, f.defuncion, 0),0) as def_3,
			round((if(a.semana=f.semana, f.defuncion, 0) / c.poblacion * 1000),2) as mort_3,
			round((if(a.semana=f.semana, f.defuncion, 0) / c.casos * 100),2) as letal_3
			from
			(select ano, semana, diagnostic, count(ubigeo) as casos,
			(select sum(pobtot) from codubi where ano = $anio-2) as poblacion from individual_ant
			where ano = $anio-2 and diagnostic = '".$diagno."' and tipo_dx != 'D' and sub_reg_nt = '".$diresa."' 
			group by ano, semana) a
			left join
			(select ano, semana, diagnostic, count(ubigeo) as casos, (select sum(pobtot) 
			from codubi where ano = $anio-1) as poblacion from individual_ant
			where ano = $anio-1 and diagnostic = '".$diagno."' and tipo_dx != 'D' and sub_reg_nt = '".$diresa."' 
			group by ano, semana) b
			on concat(a.semana,a.diagnostic) = concat(b.semana,b.diagnostic)
			left join
			(select ano, semana, diagnostic, count(ubigeo) as casos, (select sum(pobtot) 
			from codubi where ano = $anio) as poblacion from individual
			where ano = $anio and diagnostic = '".$diagno."' and tipo_dx != 'D' and sub_reg_nt = '".$diresa."'
			group by ano, semana) c
			on concat(a.semana,a.diagnostic) = concat(c.semana,c.diagnostic)
			left join
			(select ano, semana, diagnostic, count(ubigeo) as defuncion from individual_ant
			where ano = $anio-2 and diagnostic = '".$diagno."' and tipo_dx != 'D' and sub_reg_nt = '".$diresa."' and fecha_def != '0000-00-00' group by ano, semana) d
			on concat(a.semana,a.diagnostic) = concat(d.semana,d.diagnostic)
			left join
			(select ano, semana, diagnostic, count(ubigeo) as defuncion from individual_ant
			where ano = $anio-1 and diagnostic = '".$diagno."' and tipo_dx != 'D' and sub_reg_nt = '".$diresa."' and fecha_def != '0000-00-00' 
			group by ano, semana) e
			on concat(a.semana,a.diagnostic) = concat(e.semana,e.diagnostic)
			left join
			(select ano, semana, diagnostic, count(ubigeo) as defuncion from individual
			where ano = $anio and diagnostic = '".$diagno."' and tipo_dx != 'D' and sub_reg_nt = '".$diresa."' and fecha_def != '0000-00-00' group by ano, semana) f
			on concat(a.semana,a.diagnostic) = concat(f.semana,f.diagnostic)
			group by a.semana			
			";
		}elseif(empty($diresa) and empty($red) and empty($microred) and empty($establec)){
			$plantilla = "
			select a.semana,
			a.casos as casos_1,
			a.poblacion as pob_1,
			round((a.casos / a.poblacion) * 100000,2) as inc_1,
			if(a.semana=d.semana, d.defuncion, 0) as def_1,
			round((if(a.semana=d.semana, d.defuncion, 0) / a.poblacion * 1000),2) as mort_1,
			round((if(a.semana=d.semana, d.defuncion, 0) / a.casos * 100),2) as letal_1,
			b.casos as casos_2,
			b.poblacion as pob_2,
			round((b.casos / b.poblacion) * 100000,2) as inc_2,
			if(a.semana=e.semana, e.defuncion, 0) as def_2,
			round((if(a.semana=e.semana, e.defuncion, 0) / b.poblacion * 1000),2) as mort_2,
			round((if(a.semana=e.semana, e.defuncion, 0) / b.casos * 100),2) as letal_2,
			ifnull(c.casos,0) as casos_3,
			ifnull(c.poblacion,0) as pob_3,
			ifnull(round((c.casos / c.poblacion) * 100000,2),0) as inc_3,
			ifnull(if(a.semana=f.semana, f.defuncion, 0),0) as def_3,
			round((if(a.semana=f.semana, f.defuncion, 0) / c.poblacion * 1000),2) as mort_3,
			round((if(a.semana=f.semana, f.defuncion, 0) / c.casos * 100),2) as letal_3
			from
			(select ano, semana, diagnostic, count(ubigeo) as casos,
			(select sum(pobtot) from codubi where ano = $anio-2) as poblacion from individual_ant
			where ano = $anio-2 and diagnostic = '".$diagno."' and tipo_dx != 'D' group by ano, semana) a
			left join
			(select ano, semana, diagnostic, count(ubigeo) as casos, 
			(select sum(pobtot) from codubi where ano = $anio-1) as poblacion from individual_ant
			where ano = $anio-1 and diagnostic = '".$diagno."' and tipo_dx != 'D' group by ano, semana) b
			on concat(a.semana,a.diagnostic) = concat(b.semana,b.diagnostic)
			left join
			(select ano, semana, diagnostic, count(ubigeo) as casos, 
			(select sum(pobtot) from codubi where ano = $anio) as poblacion from individual
			where ano = $anio and diagnostic = '".$diagno."' and tipo_dx != 'D' group by ano, semana) c
			on concat(a.semana,a.diagnostic) = concat(c.semana,c.diagnostic)
			left join
			(select ano, semana, diagnostic, count(ubigeo) as defuncion from individual_ant
			where ano = $anio-2 and diagnostic = '".$diagno."' and tipo_dx != 'D' and fecha_def != '0000-00-00' 
			group by ano, semana) d
			on concat(a.semana,a.diagnostic) = concat(d.semana,d.diagnostic)
			left join
			(select ano, semana, diagnostic, count(ubigeo) as defuncion from individual_ant
			where ano = $anio-1 and diagnostic = '".$diagno."' and tipo_dx != 'D' and fecha_def != '0000-00-00' 
			group by ano, semana) e
			on concat(a.semana,a.diagnostic) = concat(e.semana,e.diagnostic)
			left join
			(select ano, semana, diagnostic, count(ubigeo) as defuncion from individual
			where ano = $anio and diagnostic = '".$diagno."' and tipo_dx != 'D' and fecha_def != '0000-00-00' 
			group by ano, semana) f
			on concat(a.semana,a.diagnostic) = concat(f.semana,f.diagnostic)
			group by a.semana			
			";
		}
		
		$query = $this->db->query($plantilla);
		
		return $query->result();
		
	}

	//Reporte de la notificación individual en descripción de espacio por nivel de ubigeo
	public function notificacionIndEspacioUbigeo($anio, $diagno, $departamento, $provincia, $distrito)
	{
		if(!empty($departamento) and !empty($provincia) and !empty($distrito)){
			$plantilla = "
			select b.distrito as nombre,
			ifnull(sum(if(a.semana = 1, a.cantidad, 0)),0) as sem1,
			ifnull(sum(if(a.semana = 2, a.cantidad, 0)),0) as sem2,
			ifnull(sum(if(a.semana = 3, a.cantidad, 0)),0) as sem3,
			ifnull(sum(if(a.semana = 4, a.cantidad, 0)),0) as sem4,
			ifnull(sum(if(a.semana = 5, a.cantidad, 0)),0) as sem5,
			ifnull(sum(if(a.semana = 6, a.cantidad, 0)),0) as sem6,
			ifnull(sum(if(a.semana = 7, a.cantidad, 0)),0) as sem7,
			ifnull(sum(if(a.semana = 8, a.cantidad, 0)),0) as sem8,
			ifnull(sum(if(a.semana = 9, a.cantidad, 0)),0) as sem9,
			ifnull(sum(if(a.semana = 10, a.cantidad, 0)),0) as sem10,
			ifnull(sum(if(a.semana = 11, a.cantidad, 0)),0) as sem11,
			ifnull(sum(if(a.semana = 12, a.cantidad, 0)),0) as sem12,
			ifnull(sum(if(a.semana = 13, a.cantidad, 0)),0) as sem13,
			ifnull(sum(if(a.semana = 14, a.cantidad, 0)),0) as sem14,
			ifnull(sum(if(a.semana = 15, a.cantidad, 0)),0) as sem15,
			ifnull(sum(if(a.semana = 16, a.cantidad, 0)),0) as sem16,
			ifnull(sum(if(a.semana = 17, a.cantidad, 0)),0) as sem17,
			ifnull(sum(if(a.semana = 18, a.cantidad, 0)),0) as sem18,
			ifnull(sum(if(a.semana = 19, a.cantidad, 0)),0) as sem19,
			ifnull(sum(if(a.semana = 20, a.cantidad, 0)),0) as sem20,
			ifnull(sum(if(a.semana = 21, a.cantidad, 0)),0) as sem21,
			ifnull(sum(if(a.semana = 22, a.cantidad, 0)),0) as sem22,
			ifnull(sum(if(a.semana = 23, a.cantidad, 0)),0) as sem23,
			ifnull(sum(if(a.semana = 24, a.cantidad, 0)),0) as sem24,
			ifnull(sum(if(a.semana = 25, a.cantidad, 0)),0) as sem25,
			ifnull(sum(if(a.semana = 26, a.cantidad, 0)),0) as sem26,
			ifnull(sum(if(a.semana = 27, a.cantidad, 0)),0) as sem27,
			ifnull(sum(if(a.semana = 28, a.cantidad, 0)),0) as sem28,
			ifnull(sum(if(a.semana = 29, a.cantidad, 0)),0) as sem29,
			ifnull(sum(if(a.semana = 30, a.cantidad, 0)),0) as sem30,
			ifnull(sum(if(a.semana = 31, a.cantidad, 0)),0) as sem31,
			ifnull(sum(if(a.semana = 32, a.cantidad, 0)),0) as sem32,
			ifnull(sum(if(a.semana = 33, a.cantidad, 0)),0) as sem33,
			ifnull(sum(if(a.semana = 34, a.cantidad, 0)),0) as sem34,
			ifnull(sum(if(a.semana = 35, a.cantidad, 0)),0) as sem35,
			ifnull(sum(if(a.semana = 36, a.cantidad, 0)),0) as sem36,
			ifnull(sum(if(a.semana = 37, a.cantidad, 0)),0) as sem37,
			ifnull(sum(if(a.semana = 38, a.cantidad, 0)),0) as sem38,
			ifnull(sum(if(a.semana = 39, a.cantidad, 0)),0) as sem39,
			ifnull(sum(if(a.semana = 40, a.cantidad, 0)),0) as sem40,
			ifnull(sum(if(a.semana = 41, a.cantidad, 0)),0) as sem41,
			ifnull(sum(if(a.semana = 42, a.cantidad, 0)),0) as sem42,
			ifnull(sum(if(a.semana = 43, a.cantidad, 0)),0) as sem43,
			ifnull(sum(if(a.semana = 44, a.cantidad, 0)),0) as sem44,
			ifnull(sum(if(a.semana = 45, a.cantidad, 0)),0) as sem45,
			ifnull(sum(if(a.semana = 46, a.cantidad, 0)),0) as sem46,
			ifnull(sum(if(a.semana = 47, a.cantidad, 0)),0) as sem47,
			ifnull(sum(if(a.semana = 48, a.cantidad, 0)),0) as sem48,
			ifnull(sum(if(a.semana = 49, a.cantidad, 0)),0) as sem49,
			ifnull(sum(if(a.semana = 50, a.cantidad, 0)),0) as sem50,
			ifnull(sum(if(a.semana = 51, a.cantidad, 0)),0) as sem51,
			ifnull(sum(if(a.semana = 52, a.cantidad, 0)),0) as sem52,
			ifnull(sum(if(a.semana = 53, a.cantidad, 0)),0) as sem53
			from
			codubi b
			left join
			(select ubigeo, semana, count(ubigeo) as cantidad from individual 
			where ano = $anio and diagnostic = '".$diagno."' and ubigeo = '".$distrito."' and ubigeo <> '' 
			group by ubigeo, semana) a
			on b.ubigeo = a.ubigeo
			where b.ano = $anio and a.ubigeo = '".$distrito."' 
			group by b.distrito
			";
		}elseif(!empty($departamento) and !empty($provincia) and empty($distrito)){
			$plantilla = "
			select b.distrito as nombre,
			ifnull(sum(if(a.semana = 1, a.cantidad, 0)),0) as sem1,
			ifnull(sum(if(a.semana = 2, a.cantidad, 0)),0) as sem2,
			ifnull(sum(if(a.semana = 3, a.cantidad, 0)),0) as sem3,
			ifnull(sum(if(a.semana = 4, a.cantidad, 0)),0) as sem4,
			ifnull(sum(if(a.semana = 5, a.cantidad, 0)),0) as sem5,
			ifnull(sum(if(a.semana = 6, a.cantidad, 0)),0) as sem6,
			ifnull(sum(if(a.semana = 7, a.cantidad, 0)),0) as sem7,
			ifnull(sum(if(a.semana = 8, a.cantidad, 0)),0) as sem8,
			ifnull(sum(if(a.semana = 9, a.cantidad, 0)),0) as sem9,
			ifnull(sum(if(a.semana = 10, a.cantidad, 0)),0) as sem10,
			ifnull(sum(if(a.semana = 11, a.cantidad, 0)),0) as sem11,
			ifnull(sum(if(a.semana = 12, a.cantidad, 0)),0) as sem12,
			ifnull(sum(if(a.semana = 13, a.cantidad, 0)),0) as sem13,
			ifnull(sum(if(a.semana = 14, a.cantidad, 0)),0) as sem14,
			ifnull(sum(if(a.semana = 15, a.cantidad, 0)),0) as sem15,
			ifnull(sum(if(a.semana = 16, a.cantidad, 0)),0) as sem16,
			ifnull(sum(if(a.semana = 17, a.cantidad, 0)),0) as sem17,
			ifnull(sum(if(a.semana = 18, a.cantidad, 0)),0) as sem18,
			ifnull(sum(if(a.semana = 19, a.cantidad, 0)),0) as sem19,
			ifnull(sum(if(a.semana = 20, a.cantidad, 0)),0) as sem20,
			ifnull(sum(if(a.semana = 21, a.cantidad, 0)),0) as sem21,
			ifnull(sum(if(a.semana = 22, a.cantidad, 0)),0) as sem22,
			ifnull(sum(if(a.semana = 23, a.cantidad, 0)),0) as sem23,
			ifnull(sum(if(a.semana = 24, a.cantidad, 0)),0) as sem24,
			ifnull(sum(if(a.semana = 25, a.cantidad, 0)),0) as sem25,
			ifnull(sum(if(a.semana = 26, a.cantidad, 0)),0) as sem26,
			ifnull(sum(if(a.semana = 27, a.cantidad, 0)),0) as sem27,
			ifnull(sum(if(a.semana = 28, a.cantidad, 0)),0) as sem28,
			ifnull(sum(if(a.semana = 29, a.cantidad, 0)),0) as sem29,
			ifnull(sum(if(a.semana = 30, a.cantidad, 0)),0) as sem30,
			ifnull(sum(if(a.semana = 31, a.cantidad, 0)),0) as sem31,
			ifnull(sum(if(a.semana = 32, a.cantidad, 0)),0) as sem32,
			ifnull(sum(if(a.semana = 33, a.cantidad, 0)),0) as sem33,
			ifnull(sum(if(a.semana = 34, a.cantidad, 0)),0) as sem34,
			ifnull(sum(if(a.semana = 35, a.cantidad, 0)),0) as sem35,
			ifnull(sum(if(a.semana = 36, a.cantidad, 0)),0) as sem36,
			ifnull(sum(if(a.semana = 37, a.cantidad, 0)),0) as sem37,
			ifnull(sum(if(a.semana = 38, a.cantidad, 0)),0) as sem38,
			ifnull(sum(if(a.semana = 39, a.cantidad, 0)),0) as sem39,
			ifnull(sum(if(a.semana = 40, a.cantidad, 0)),0) as sem40,
			ifnull(sum(if(a.semana = 41, a.cantidad, 0)),0) as sem41,
			ifnull(sum(if(a.semana = 42, a.cantidad, 0)),0) as sem42,
			ifnull(sum(if(a.semana = 43, a.cantidad, 0)),0) as sem43,
			ifnull(sum(if(a.semana = 44, a.cantidad, 0)),0) as sem44,
			ifnull(sum(if(a.semana = 45, a.cantidad, 0)),0) as sem45,
			ifnull(sum(if(a.semana = 46, a.cantidad, 0)),0) as sem46,
			ifnull(sum(if(a.semana = 47, a.cantidad, 0)),0) as sem47,
			ifnull(sum(if(a.semana = 48, a.cantidad, 0)),0) as sem48,
			ifnull(sum(if(a.semana = 49, a.cantidad, 0)),0) as sem49,
			ifnull(sum(if(a.semana = 50, a.cantidad, 0)),0) as sem50,
			ifnull(sum(if(a.semana = 51, a.cantidad, 0)),0) as sem51,
			ifnull(sum(if(a.semana = 52, a.cantidad, 0)),0) as sem52,
			ifnull(sum(if(a.semana = 53, a.cantidad, 0)),0) as sem53
			from
			codubi b
			left join
			(select ubigeo, semana, count(ubigeo) as cantidad from individual 
			where ano = $anio and diagnostic = '".$diagno."' and substr(ubigeo,1,4) = '".$provincia."' and ubigeo <> '' 
			group by ubigeo, semana) a
			on b.ubigeo = a.ubigeo
			where b.ano = $anio and substr(a.ubigeo,1,4) = '".$provincia."' 
			group by b.distrito
			";
		}elseif(!empty($departamento) and empty($provincia) and empty($distrito)){
			$plantilla = "
			select b.provincia as nombre,
			ifnull(sum(if(a.semana = 1, a.cantidad, 0)),0) as sem1,
			ifnull(sum(if(a.semana = 2, a.cantidad, 0)),0) as sem2,
			ifnull(sum(if(a.semana = 3, a.cantidad, 0)),0) as sem3,
			ifnull(sum(if(a.semana = 4, a.cantidad, 0)),0) as sem4,
			ifnull(sum(if(a.semana = 5, a.cantidad, 0)),0) as sem5,
			ifnull(sum(if(a.semana = 6, a.cantidad, 0)),0) as sem6,
			ifnull(sum(if(a.semana = 7, a.cantidad, 0)),0) as sem7,
			ifnull(sum(if(a.semana = 8, a.cantidad, 0)),0) as sem8,
			ifnull(sum(if(a.semana = 9, a.cantidad, 0)),0) as sem9,
			ifnull(sum(if(a.semana = 10, a.cantidad, 0)),0) as sem10,
			ifnull(sum(if(a.semana = 11, a.cantidad, 0)),0) as sem11,
			ifnull(sum(if(a.semana = 12, a.cantidad, 0)),0) as sem12,
			ifnull(sum(if(a.semana = 13, a.cantidad, 0)),0) as sem13,
			ifnull(sum(if(a.semana = 14, a.cantidad, 0)),0) as sem14,
			ifnull(sum(if(a.semana = 15, a.cantidad, 0)),0) as sem15,
			ifnull(sum(if(a.semana = 16, a.cantidad, 0)),0) as sem16,
			ifnull(sum(if(a.semana = 17, a.cantidad, 0)),0) as sem17,
			ifnull(sum(if(a.semana = 18, a.cantidad, 0)),0) as sem18,
			ifnull(sum(if(a.semana = 19, a.cantidad, 0)),0) as sem19,
			ifnull(sum(if(a.semana = 20, a.cantidad, 0)),0) as sem20,
			ifnull(sum(if(a.semana = 21, a.cantidad, 0)),0) as sem21,
			ifnull(sum(if(a.semana = 22, a.cantidad, 0)),0) as sem22,
			ifnull(sum(if(a.semana = 23, a.cantidad, 0)),0) as sem23,
			ifnull(sum(if(a.semana = 24, a.cantidad, 0)),0) as sem24,
			ifnull(sum(if(a.semana = 25, a.cantidad, 0)),0) as sem25,
			ifnull(sum(if(a.semana = 26, a.cantidad, 0)),0) as sem26,
			ifnull(sum(if(a.semana = 27, a.cantidad, 0)),0) as sem27,
			ifnull(sum(if(a.semana = 28, a.cantidad, 0)),0) as sem28,
			ifnull(sum(if(a.semana = 29, a.cantidad, 0)),0) as sem29,
			ifnull(sum(if(a.semana = 30, a.cantidad, 0)),0) as sem30,
			ifnull(sum(if(a.semana = 31, a.cantidad, 0)),0) as sem31,
			ifnull(sum(if(a.semana = 32, a.cantidad, 0)),0) as sem32,
			ifnull(sum(if(a.semana = 33, a.cantidad, 0)),0) as sem33,
			ifnull(sum(if(a.semana = 34, a.cantidad, 0)),0) as sem34,
			ifnull(sum(if(a.semana = 35, a.cantidad, 0)),0) as sem35,
			ifnull(sum(if(a.semana = 36, a.cantidad, 0)),0) as sem36,
			ifnull(sum(if(a.semana = 37, a.cantidad, 0)),0) as sem37,
			ifnull(sum(if(a.semana = 38, a.cantidad, 0)),0) as sem38,
			ifnull(sum(if(a.semana = 39, a.cantidad, 0)),0) as sem39,
			ifnull(sum(if(a.semana = 40, a.cantidad, 0)),0) as sem40,
			ifnull(sum(if(a.semana = 41, a.cantidad, 0)),0) as sem41,
			ifnull(sum(if(a.semana = 42, a.cantidad, 0)),0) as sem42,
			ifnull(sum(if(a.semana = 43, a.cantidad, 0)),0) as sem43,
			ifnull(sum(if(a.semana = 44, a.cantidad, 0)),0) as sem44,
			ifnull(sum(if(a.semana = 45, a.cantidad, 0)),0) as sem45,
			ifnull(sum(if(a.semana = 46, a.cantidad, 0)),0) as sem46,
			ifnull(sum(if(a.semana = 47, a.cantidad, 0)),0) as sem47,
			ifnull(sum(if(a.semana = 48, a.cantidad, 0)),0) as sem48,
			ifnull(sum(if(a.semana = 49, a.cantidad, 0)),0) as sem49,
			ifnull(sum(if(a.semana = 50, a.cantidad, 0)),0) as sem50,
			ifnull(sum(if(a.semana = 51, a.cantidad, 0)),0) as sem51,
			ifnull(sum(if(a.semana = 52, a.cantidad, 0)),0) as sem52,
			ifnull(sum(if(a.semana = 53, a.cantidad, 0)),0) as sem53
			from
			codubi b
			left join
			(select ubigeo, semana, count(ubigeo) as cantidad from individual 
			where ano = $anio and diagnostic = '".$diagno."' and substr(ubigeo,1,2) = '".$departamento."' and ubigeo <> '' 
			group by ubigeo, semana) a
			on b.ubigeo = a.ubigeo
			where b.ano = $anio and substr(a.ubigeo,1,2) = '".$departamento."' 
			group by b.provincia
			";
		}elseif(empty($departamento) and empty($provincia) and empty($distrito)){
			if($this->session->userdata('nivel') == '1' or $this->session->userdata('nivel') == '4'){
				$plantilla = "
				select b.departam as nombre,
				ifnull(sum(if(a.semana = 1, a.cantidad, 0)),0) as sem1,
				ifnull(sum(if(a.semana = 2, a.cantidad, 0)),0) as sem2,
				ifnull(sum(if(a.semana = 3, a.cantidad, 0)),0) as sem3,
				ifnull(sum(if(a.semana = 4, a.cantidad, 0)),0) as sem4,
				ifnull(sum(if(a.semana = 5, a.cantidad, 0)),0) as sem5,
				ifnull(sum(if(a.semana = 6, a.cantidad, 0)),0) as sem6,
				ifnull(sum(if(a.semana = 7, a.cantidad, 0)),0) as sem7,
				ifnull(sum(if(a.semana = 8, a.cantidad, 0)),0) as sem8,
				ifnull(sum(if(a.semana = 9, a.cantidad, 0)),0) as sem9,
				ifnull(sum(if(a.semana = 10, a.cantidad, 0)),0) as sem10,
				ifnull(sum(if(a.semana = 11, a.cantidad, 0)),0) as sem11,
				ifnull(sum(if(a.semana = 12, a.cantidad, 0)),0) as sem12,
				ifnull(sum(if(a.semana = 13, a.cantidad, 0)),0) as sem13,
				ifnull(sum(if(a.semana = 14, a.cantidad, 0)),0) as sem14,
				ifnull(sum(if(a.semana = 15, a.cantidad, 0)),0) as sem15,
				ifnull(sum(if(a.semana = 16, a.cantidad, 0)),0) as sem16,
				ifnull(sum(if(a.semana = 17, a.cantidad, 0)),0) as sem17,
				ifnull(sum(if(a.semana = 18, a.cantidad, 0)),0) as sem18,
				ifnull(sum(if(a.semana = 19, a.cantidad, 0)),0) as sem19,
				ifnull(sum(if(a.semana = 20, a.cantidad, 0)),0) as sem20,
				ifnull(sum(if(a.semana = 21, a.cantidad, 0)),0) as sem21,
				ifnull(sum(if(a.semana = 22, a.cantidad, 0)),0) as sem22,
				ifnull(sum(if(a.semana = 23, a.cantidad, 0)),0) as sem23,
				ifnull(sum(if(a.semana = 24, a.cantidad, 0)),0) as sem24,
				ifnull(sum(if(a.semana = 25, a.cantidad, 0)),0) as sem25,
				ifnull(sum(if(a.semana = 26, a.cantidad, 0)),0) as sem26,
				ifnull(sum(if(a.semana = 27, a.cantidad, 0)),0) as sem27,
				ifnull(sum(if(a.semana = 28, a.cantidad, 0)),0) as sem28,
				ifnull(sum(if(a.semana = 29, a.cantidad, 0)),0) as sem29,
				ifnull(sum(if(a.semana = 30, a.cantidad, 0)),0) as sem30,
				ifnull(sum(if(a.semana = 31, a.cantidad, 0)),0) as sem31,
				ifnull(sum(if(a.semana = 32, a.cantidad, 0)),0) as sem32,
				ifnull(sum(if(a.semana = 33, a.cantidad, 0)),0) as sem33,
				ifnull(sum(if(a.semana = 34, a.cantidad, 0)),0) as sem34,
				ifnull(sum(if(a.semana = 35, a.cantidad, 0)),0) as sem35,
				ifnull(sum(if(a.semana = 36, a.cantidad, 0)),0) as sem36,
				ifnull(sum(if(a.semana = 37, a.cantidad, 0)),0) as sem37,
				ifnull(sum(if(a.semana = 38, a.cantidad, 0)),0) as sem38,
				ifnull(sum(if(a.semana = 39, a.cantidad, 0)),0) as sem39,
				ifnull(sum(if(a.semana = 40, a.cantidad, 0)),0) as sem40,
				ifnull(sum(if(a.semana = 41, a.cantidad, 0)),0) as sem41,
				ifnull(sum(if(a.semana = 42, a.cantidad, 0)),0) as sem42,
				ifnull(sum(if(a.semana = 43, a.cantidad, 0)),0) as sem43,
				ifnull(sum(if(a.semana = 44, a.cantidad, 0)),0) as sem44,
				ifnull(sum(if(a.semana = 45, a.cantidad, 0)),0) as sem45,
				ifnull(sum(if(a.semana = 46, a.cantidad, 0)),0) as sem46,
				ifnull(sum(if(a.semana = 47, a.cantidad, 0)),0) as sem47,
				ifnull(sum(if(a.semana = 48, a.cantidad, 0)),0) as sem48,
				ifnull(sum(if(a.semana = 49, a.cantidad, 0)),0) as sem49,
				ifnull(sum(if(a.semana = 50, a.cantidad, 0)),0) as sem50,
				ifnull(sum(if(a.semana = 51, a.cantidad, 0)),0) as sem51,
				ifnull(sum(if(a.semana = 52, a.cantidad, 0)),0) as sem52,
				ifnull(sum(if(a.semana = 53, a.cantidad, 0)),0) as sem53
				from
				codubi b
				left join
				(select ubigeo, semana, count(ubigeo) as cantidad from individual 
				where ano = $anio and diagnostic = '".$diagno."' and ubigeo <> ''
				group by ubigeo, semana) a
				on b.ubigeo = a.ubigeo
				where b.ano = $anio
				group by b.departam
				";
			}else{
				$this->session->set_flashdata('error', 'Debe elegir alg&uacute;n nivel de proceso, este reporte no est&aacute; activo para su nivel de usuario, comun&iacute;quese a notificacion@dge.gob.pe');
				redirect(site_url("reportes/repIndividual"), 301);
			}
		}
		
		$query = $this->db->query($plantilla);
		
		return $query->result();
		
	}

	//Reporte de la notificación individual en descripción de espacio por nivel de EESS
	public function notificacionIndEspacioEESS($anio, $diagno, $diresa, $red, $microred, $establec)
	{
		if(!empty($diresa) and !empty($red) and !empty($microred) and !empty($establec)){
			$plantilla = "
			select b.raz_soc as nombre,
			ifnull(sum(if(a.semana = 1, a.cantidad, 0)),0) as sem1,
			ifnull(sum(if(a.semana = 2, a.cantidad, 0)),0) as sem2,
			ifnull(sum(if(a.semana = 3, a.cantidad, 0)),0) as sem3,
			ifnull(sum(if(a.semana = 4, a.cantidad, 0)),0) as sem4,
			ifnull(sum(if(a.semana = 5, a.cantidad, 0)),0) as sem5,
			ifnull(sum(if(a.semana = 6, a.cantidad, 0)),0) as sem6,
			ifnull(sum(if(a.semana = 7, a.cantidad, 0)),0) as sem7,
			ifnull(sum(if(a.semana = 8, a.cantidad, 0)),0) as sem8,
			ifnull(sum(if(a.semana = 9, a.cantidad, 0)),0) as sem9,
			ifnull(sum(if(a.semana = 10, a.cantidad, 0)),0) as sem10,
			ifnull(sum(if(a.semana = 11, a.cantidad, 0)),0) as sem11,
			ifnull(sum(if(a.semana = 12, a.cantidad, 0)),0) as sem12,
			ifnull(sum(if(a.semana = 13, a.cantidad, 0)),0) as sem13,
			ifnull(sum(if(a.semana = 14, a.cantidad, 0)),0) as sem14,
			ifnull(sum(if(a.semana = 15, a.cantidad, 0)),0) as sem15,
			ifnull(sum(if(a.semana = 16, a.cantidad, 0)),0) as sem16,
			ifnull(sum(if(a.semana = 17, a.cantidad, 0)),0) as sem17,
			ifnull(sum(if(a.semana = 18, a.cantidad, 0)),0) as sem18,
			ifnull(sum(if(a.semana = 19, a.cantidad, 0)),0) as sem19,
			ifnull(sum(if(a.semana = 20, a.cantidad, 0)),0) as sem20,
			ifnull(sum(if(a.semana = 21, a.cantidad, 0)),0) as sem21,
			ifnull(sum(if(a.semana = 22, a.cantidad, 0)),0) as sem22,
			ifnull(sum(if(a.semana = 23, a.cantidad, 0)),0) as sem23,
			ifnull(sum(if(a.semana = 24, a.cantidad, 0)),0) as sem24,
			ifnull(sum(if(a.semana = 25, a.cantidad, 0)),0) as sem25,
			ifnull(sum(if(a.semana = 26, a.cantidad, 0)),0) as sem26,
			ifnull(sum(if(a.semana = 27, a.cantidad, 0)),0) as sem27,
			ifnull(sum(if(a.semana = 28, a.cantidad, 0)),0) as sem28,
			ifnull(sum(if(a.semana = 29, a.cantidad, 0)),0) as sem29,
			ifnull(sum(if(a.semana = 30, a.cantidad, 0)),0) as sem30,
			ifnull(sum(if(a.semana = 31, a.cantidad, 0)),0) as sem31,
			ifnull(sum(if(a.semana = 32, a.cantidad, 0)),0) as sem32,
			ifnull(sum(if(a.semana = 33, a.cantidad, 0)),0) as sem33,
			ifnull(sum(if(a.semana = 34, a.cantidad, 0)),0) as sem34,
			ifnull(sum(if(a.semana = 35, a.cantidad, 0)),0) as sem35,
			ifnull(sum(if(a.semana = 36, a.cantidad, 0)),0) as sem36,
			ifnull(sum(if(a.semana = 37, a.cantidad, 0)),0) as sem37,
			ifnull(sum(if(a.semana = 38, a.cantidad, 0)),0) as sem38,
			ifnull(sum(if(a.semana = 39, a.cantidad, 0)),0) as sem39,
			ifnull(sum(if(a.semana = 40, a.cantidad, 0)),0) as sem40,
			ifnull(sum(if(a.semana = 41, a.cantidad, 0)),0) as sem41,
			ifnull(sum(if(a.semana = 42, a.cantidad, 0)),0) as sem42,
			ifnull(sum(if(a.semana = 43, a.cantidad, 0)),0) as sem43,
			ifnull(sum(if(a.semana = 44, a.cantidad, 0)),0) as sem44,
			ifnull(sum(if(a.semana = 45, a.cantidad, 0)),0) as sem45,
			ifnull(sum(if(a.semana = 46, a.cantidad, 0)),0) as sem46,
			ifnull(sum(if(a.semana = 47, a.cantidad, 0)),0) as sem47,
			ifnull(sum(if(a.semana = 48, a.cantidad, 0)),0) as sem48,
			ifnull(sum(if(a.semana = 49, a.cantidad, 0)),0) as sem49,
			ifnull(sum(if(a.semana = 50, a.cantidad, 0)),0) as sem50,
			ifnull(sum(if(a.semana = 51, a.cantidad, 0)),0) as sem51,
			ifnull(sum(if(a.semana = 52, a.cantidad, 0)),0) as sem52,
			ifnull(sum(if(a.semana = 53, a.cantidad, 0)),0) as sem53
			from
			renace b
			left join
			(select e_salud, semana, count(ubigeo) as cantidad from individual 
			where ano = $anio and diagnostic = '".$diagno."' and e_salud = '".$establec."'
			group by e_salud, semana) a
			on b.cod_est = a.e_salud
			where a.e_salud = '".$establec."' 
			group by b.raz_soc
			";
		}elseif(!empty($diresa) and !empty($red) and !empty($microred) and empty($establec)){
			$plantilla = "
			select b.raz_soc as nombre,
			ifnull(sum(if(a.semana = 1, a.cantidad, 0)),0) as sem1,
			ifnull(sum(if(a.semana = 2, a.cantidad, 0)),0) as sem2,
			ifnull(sum(if(a.semana = 3, a.cantidad, 0)),0) as sem3,
			ifnull(sum(if(a.semana = 4, a.cantidad, 0)),0) as sem4,
			ifnull(sum(if(a.semana = 5, a.cantidad, 0)),0) as sem5,
			ifnull(sum(if(a.semana = 6, a.cantidad, 0)),0) as sem6,
			ifnull(sum(if(a.semana = 7, a.cantidad, 0)),0) as sem7,
			ifnull(sum(if(a.semana = 8, a.cantidad, 0)),0) as sem8,
			ifnull(sum(if(a.semana = 9, a.cantidad, 0)),0) as sem9,
			ifnull(sum(if(a.semana = 10, a.cantidad, 0)),0) as sem10,
			ifnull(sum(if(a.semana = 11, a.cantidad, 0)),0) as sem11,
			ifnull(sum(if(a.semana = 12, a.cantidad, 0)),0) as sem12,
			ifnull(sum(if(a.semana = 13, a.cantidad, 0)),0) as sem13,
			ifnull(sum(if(a.semana = 14, a.cantidad, 0)),0) as sem14,
			ifnull(sum(if(a.semana = 15, a.cantidad, 0)),0) as sem15,
			ifnull(sum(if(a.semana = 16, a.cantidad, 0)),0) as sem16,
			ifnull(sum(if(a.semana = 17, a.cantidad, 0)),0) as sem17,
			ifnull(sum(if(a.semana = 18, a.cantidad, 0)),0) as sem18,
			ifnull(sum(if(a.semana = 19, a.cantidad, 0)),0) as sem19,
			ifnull(sum(if(a.semana = 20, a.cantidad, 0)),0) as sem20,
			ifnull(sum(if(a.semana = 21, a.cantidad, 0)),0) as sem21,
			ifnull(sum(if(a.semana = 22, a.cantidad, 0)),0) as sem22,
			ifnull(sum(if(a.semana = 23, a.cantidad, 0)),0) as sem23,
			ifnull(sum(if(a.semana = 24, a.cantidad, 0)),0) as sem24,
			ifnull(sum(if(a.semana = 25, a.cantidad, 0)),0) as sem25,
			ifnull(sum(if(a.semana = 26, a.cantidad, 0)),0) as sem26,
			ifnull(sum(if(a.semana = 27, a.cantidad, 0)),0) as sem27,
			ifnull(sum(if(a.semana = 28, a.cantidad, 0)),0) as sem28,
			ifnull(sum(if(a.semana = 29, a.cantidad, 0)),0) as sem29,
			ifnull(sum(if(a.semana = 30, a.cantidad, 0)),0) as sem30,
			ifnull(sum(if(a.semana = 31, a.cantidad, 0)),0) as sem31,
			ifnull(sum(if(a.semana = 32, a.cantidad, 0)),0) as sem32,
			ifnull(sum(if(a.semana = 33, a.cantidad, 0)),0) as sem33,
			ifnull(sum(if(a.semana = 34, a.cantidad, 0)),0) as sem34,
			ifnull(sum(if(a.semana = 35, a.cantidad, 0)),0) as sem35,
			ifnull(sum(if(a.semana = 36, a.cantidad, 0)),0) as sem36,
			ifnull(sum(if(a.semana = 37, a.cantidad, 0)),0) as sem37,
			ifnull(sum(if(a.semana = 38, a.cantidad, 0)),0) as sem38,
			ifnull(sum(if(a.semana = 39, a.cantidad, 0)),0) as sem39,
			ifnull(sum(if(a.semana = 40, a.cantidad, 0)),0) as sem40,
			ifnull(sum(if(a.semana = 41, a.cantidad, 0)),0) as sem41,
			ifnull(sum(if(a.semana = 42, a.cantidad, 0)),0) as sem42,
			ifnull(sum(if(a.semana = 43, a.cantidad, 0)),0) as sem43,
			ifnull(sum(if(a.semana = 44, a.cantidad, 0)),0) as sem44,
			ifnull(sum(if(a.semana = 45, a.cantidad, 0)),0) as sem45,
			ifnull(sum(if(a.semana = 46, a.cantidad, 0)),0) as sem46,
			ifnull(sum(if(a.semana = 47, a.cantidad, 0)),0) as sem47,
			ifnull(sum(if(a.semana = 48, a.cantidad, 0)),0) as sem48,
			ifnull(sum(if(a.semana = 49, a.cantidad, 0)),0) as sem49,
			ifnull(sum(if(a.semana = 50, a.cantidad, 0)),0) as sem50,
			ifnull(sum(if(a.semana = 51, a.cantidad, 0)),0) as sem51,
			ifnull(sum(if(a.semana = 52, a.cantidad, 0)),0) as sem52,
			ifnull(sum(if(a.semana = 53, a.cantidad, 0)),0) as sem53
			from
			renace b
			left join
			(select e_salud, semana, count(ubigeo) as cantidad from individual 
			where ano = $anio and diagnostic = '".$diagno."' and sub_reg_nt = '".$diresa."'
			and red = '".$red."' and microred = '".$microred."' 
			group by e_salud, semana) a
			on b.cod_est = a.e_salud
			where b.subregion = '".$diresa."' and b.red = '".$red."' and microred = '".$microred."' and b.estado = '1'
			group by b.raz_soc
			";
		}elseif(!empty($diresa) and !empty($red) and empty($microred) and empty($establec)){
			$plantilla = "
			select b.nombre,
			ifnull(sum(if(a.semana = 1, a.cantidad, 0)),0) as sem1,
			ifnull(sum(if(a.semana = 2, a.cantidad, 0)),0) as sem2,
			ifnull(sum(if(a.semana = 3, a.cantidad, 0)),0) as sem3,
			ifnull(sum(if(a.semana = 4, a.cantidad, 0)),0) as sem4,
			ifnull(sum(if(a.semana = 5, a.cantidad, 0)),0) as sem5,
			ifnull(sum(if(a.semana = 6, a.cantidad, 0)),0) as sem6,
			ifnull(sum(if(a.semana = 7, a.cantidad, 0)),0) as sem7,
			ifnull(sum(if(a.semana = 8, a.cantidad, 0)),0) as sem8,
			ifnull(sum(if(a.semana = 9, a.cantidad, 0)),0) as sem9,
			ifnull(sum(if(a.semana = 10, a.cantidad, 0)),0) as sem10,
			ifnull(sum(if(a.semana = 11, a.cantidad, 0)),0) as sem11,
			ifnull(sum(if(a.semana = 12, a.cantidad, 0)),0) as sem12,
			ifnull(sum(if(a.semana = 13, a.cantidad, 0)),0) as sem13,
			ifnull(sum(if(a.semana = 14, a.cantidad, 0)),0) as sem14,
			ifnull(sum(if(a.semana = 15, a.cantidad, 0)),0) as sem15,
			ifnull(sum(if(a.semana = 16, a.cantidad, 0)),0) as sem16,
			ifnull(sum(if(a.semana = 17, a.cantidad, 0)),0) as sem17,
			ifnull(sum(if(a.semana = 18, a.cantidad, 0)),0) as sem18,
			ifnull(sum(if(a.semana = 19, a.cantidad, 0)),0) as sem19,
			ifnull(sum(if(a.semana = 20, a.cantidad, 0)),0) as sem20,
			ifnull(sum(if(a.semana = 21, a.cantidad, 0)),0) as sem21,
			ifnull(sum(if(a.semana = 22, a.cantidad, 0)),0) as sem22,
			ifnull(sum(if(a.semana = 23, a.cantidad, 0)),0) as sem23,
			ifnull(sum(if(a.semana = 24, a.cantidad, 0)),0) as sem24,
			ifnull(sum(if(a.semana = 25, a.cantidad, 0)),0) as sem25,
			ifnull(sum(if(a.semana = 26, a.cantidad, 0)),0) as sem26,
			ifnull(sum(if(a.semana = 27, a.cantidad, 0)),0) as sem27,
			ifnull(sum(if(a.semana = 28, a.cantidad, 0)),0) as sem28,
			ifnull(sum(if(a.semana = 29, a.cantidad, 0)),0) as sem29,
			ifnull(sum(if(a.semana = 30, a.cantidad, 0)),0) as sem30,
			ifnull(sum(if(a.semana = 31, a.cantidad, 0)),0) as sem31,
			ifnull(sum(if(a.semana = 32, a.cantidad, 0)),0) as sem32,
			ifnull(sum(if(a.semana = 33, a.cantidad, 0)),0) as sem33,
			ifnull(sum(if(a.semana = 34, a.cantidad, 0)),0) as sem34,
			ifnull(sum(if(a.semana = 35, a.cantidad, 0)),0) as sem35,
			ifnull(sum(if(a.semana = 36, a.cantidad, 0)),0) as sem36,
			ifnull(sum(if(a.semana = 37, a.cantidad, 0)),0) as sem37,
			ifnull(sum(if(a.semana = 38, a.cantidad, 0)),0) as sem38,
			ifnull(sum(if(a.semana = 39, a.cantidad, 0)),0) as sem39,
			ifnull(sum(if(a.semana = 40, a.cantidad, 0)),0) as sem40,
			ifnull(sum(if(a.semana = 41, a.cantidad, 0)),0) as sem41,
			ifnull(sum(if(a.semana = 42, a.cantidad, 0)),0) as sem42,
			ifnull(sum(if(a.semana = 43, a.cantidad, 0)),0) as sem43,
			ifnull(sum(if(a.semana = 44, a.cantidad, 0)),0) as sem44,
			ifnull(sum(if(a.semana = 45, a.cantidad, 0)),0) as sem45,
			ifnull(sum(if(a.semana = 46, a.cantidad, 0)),0) as sem46,
			ifnull(sum(if(a.semana = 47, a.cantidad, 0)),0) as sem47,
			ifnull(sum(if(a.semana = 48, a.cantidad, 0)),0) as sem48,
			ifnull(sum(if(a.semana = 49, a.cantidad, 0)),0) as sem49,
			ifnull(sum(if(a.semana = 50, a.cantidad, 0)),0) as sem50,
			ifnull(sum(if(a.semana = 51, a.cantidad, 0)),0) as sem51,
			ifnull(sum(if(a.semana = 52, a.cantidad, 0)),0) as sem52,
			ifnull(sum(if(a.semana = 53, a.cantidad, 0)),0) as sem53
			from
			microred b
			left join
			(select sub_reg_nt, red, microred, semana, count(ubigeo) as cantidad from individual 
			where ano = $anio and diagnostic = '".$diagno."' and sub_reg_nt = '".$diresa."'
			and red = '".$red."'
			group by sub_reg_nt, red, semana) a
			on concat(b.subregion, b.red, b.codigo) = concat(a.sub_reg_nt, a.red, a.microred)
			where b.subregion = '".$diresa."' and b.red = '".$red."' and b.estado = '1' 
			group by b.nombre
			";
		}elseif(!empty($diresa) and empty($red) and empty($microred) and empty($establec)){
			$plantilla = "
			select b.nombre,
			ifnull(sum(if(a.semana = 1, a.cantidad, 0)),0) as sem1,
			ifnull(sum(if(a.semana = 2, a.cantidad, 0)),0) as sem2,
			ifnull(sum(if(a.semana = 3, a.cantidad, 0)),0) as sem3,
			ifnull(sum(if(a.semana = 4, a.cantidad, 0)),0) as sem4,
			ifnull(sum(if(a.semana = 5, a.cantidad, 0)),0) as sem5,
			ifnull(sum(if(a.semana = 6, a.cantidad, 0)),0) as sem6,
			ifnull(sum(if(a.semana = 7, a.cantidad, 0)),0) as sem7,
			ifnull(sum(if(a.semana = 8, a.cantidad, 0)),0) as sem8,
			ifnull(sum(if(a.semana = 9, a.cantidad, 0)),0) as sem9,
			ifnull(sum(if(a.semana = 10, a.cantidad, 0)),0) as sem10,
			ifnull(sum(if(a.semana = 11, a.cantidad, 0)),0) as sem11,
			ifnull(sum(if(a.semana = 12, a.cantidad, 0)),0) as sem12,
			ifnull(sum(if(a.semana = 13, a.cantidad, 0)),0) as sem13,
			ifnull(sum(if(a.semana = 14, a.cantidad, 0)),0) as sem14,
			ifnull(sum(if(a.semana = 15, a.cantidad, 0)),0) as sem15,
			ifnull(sum(if(a.semana = 16, a.cantidad, 0)),0) as sem16,
			ifnull(sum(if(a.semana = 17, a.cantidad, 0)),0) as sem17,
			ifnull(sum(if(a.semana = 18, a.cantidad, 0)),0) as sem18,
			ifnull(sum(if(a.semana = 19, a.cantidad, 0)),0) as sem19,
			ifnull(sum(if(a.semana = 20, a.cantidad, 0)),0) as sem20,
			ifnull(sum(if(a.semana = 21, a.cantidad, 0)),0) as sem21,
			ifnull(sum(if(a.semana = 22, a.cantidad, 0)),0) as sem22,
			ifnull(sum(if(a.semana = 23, a.cantidad, 0)),0) as sem23,
			ifnull(sum(if(a.semana = 24, a.cantidad, 0)),0) as sem24,
			ifnull(sum(if(a.semana = 25, a.cantidad, 0)),0) as sem25,
			ifnull(sum(if(a.semana = 26, a.cantidad, 0)),0) as sem26,
			ifnull(sum(if(a.semana = 27, a.cantidad, 0)),0) as sem27,
			ifnull(sum(if(a.semana = 28, a.cantidad, 0)),0) as sem28,
			ifnull(sum(if(a.semana = 29, a.cantidad, 0)),0) as sem29,
			ifnull(sum(if(a.semana = 30, a.cantidad, 0)),0) as sem30,
			ifnull(sum(if(a.semana = 31, a.cantidad, 0)),0) as sem31,
			ifnull(sum(if(a.semana = 32, a.cantidad, 0)),0) as sem32,
			ifnull(sum(if(a.semana = 33, a.cantidad, 0)),0) as sem33,
			ifnull(sum(if(a.semana = 34, a.cantidad, 0)),0) as sem34,
			ifnull(sum(if(a.semana = 35, a.cantidad, 0)),0) as sem35,
			ifnull(sum(if(a.semana = 36, a.cantidad, 0)),0) as sem36,
			ifnull(sum(if(a.semana = 37, a.cantidad, 0)),0) as sem37,
			ifnull(sum(if(a.semana = 38, a.cantidad, 0)),0) as sem38,
			ifnull(sum(if(a.semana = 39, a.cantidad, 0)),0) as sem39,
			ifnull(sum(if(a.semana = 40, a.cantidad, 0)),0) as sem40,
			ifnull(sum(if(a.semana = 41, a.cantidad, 0)),0) as sem41,
			ifnull(sum(if(a.semana = 42, a.cantidad, 0)),0) as sem42,
			ifnull(sum(if(a.semana = 43, a.cantidad, 0)),0) as sem43,
			ifnull(sum(if(a.semana = 44, a.cantidad, 0)),0) as sem44,
			ifnull(sum(if(a.semana = 45, a.cantidad, 0)),0) as sem45,
			ifnull(sum(if(a.semana = 46, a.cantidad, 0)),0) as sem46,
			ifnull(sum(if(a.semana = 47, a.cantidad, 0)),0) as sem47,
			ifnull(sum(if(a.semana = 48, a.cantidad, 0)),0) as sem48,
			ifnull(sum(if(a.semana = 49, a.cantidad, 0)),0) as sem49,
			ifnull(sum(if(a.semana = 50, a.cantidad, 0)),0) as sem50,
			ifnull(sum(if(a.semana = 51, a.cantidad, 0)),0) as sem51,
			ifnull(sum(if(a.semana = 52, a.cantidad, 0)),0) as sem52,
			ifnull(sum(if(a.semana = 53, a.cantidad, 0)),0) as sem53
			from
			redes b
			left join
			(select sub_reg_nt, red, semana, count(ubigeo) as cantidad from individual 
			where ano = $anio and diagnostic = '".$diagno."' and sub_reg_nt = '".$diresa."' 
			group by sub_reg_nt, semana) a
			on concat(b.subregion, b.codigo) = concat(a.sub_reg_nt, a.red)
			where b.subregion = '".$diresa."' and b.estado = '1' 
			group by b.nombre
			";
		}elseif(empty($diresa) and empty($red) and empty($microred) and empty($establec)){
			if($this->session->userdata('nivel') == '1' or $this->session->userdata('nivel') == '4'){
				$plantilla = "
				select b.nombre,
				ifnull(sum(if(a.semana = 1, a.cantidad, 0)),0) as sem1,
				ifnull(sum(if(a.semana = 2, a.cantidad, 0)),0) as sem2,
				ifnull(sum(if(a.semana = 3, a.cantidad, 0)),0) as sem3,
				ifnull(sum(if(a.semana = 4, a.cantidad, 0)),0) as sem4,
				ifnull(sum(if(a.semana = 5, a.cantidad, 0)),0) as sem5,
				ifnull(sum(if(a.semana = 6, a.cantidad, 0)),0) as sem6,
				ifnull(sum(if(a.semana = 7, a.cantidad, 0)),0) as sem7,
				ifnull(sum(if(a.semana = 8, a.cantidad, 0)),0) as sem8,
				ifnull(sum(if(a.semana = 9, a.cantidad, 0)),0) as sem9,
				ifnull(sum(if(a.semana = 10, a.cantidad, 0)),0) as sem10,
				ifnull(sum(if(a.semana = 11, a.cantidad, 0)),0) as sem11,
				ifnull(sum(if(a.semana = 12, a.cantidad, 0)),0) as sem12,
				ifnull(sum(if(a.semana = 13, a.cantidad, 0)),0) as sem13,
				ifnull(sum(if(a.semana = 14, a.cantidad, 0)),0) as sem14,
				ifnull(sum(if(a.semana = 15, a.cantidad, 0)),0) as sem15,
				ifnull(sum(if(a.semana = 16, a.cantidad, 0)),0) as sem16,
				ifnull(sum(if(a.semana = 17, a.cantidad, 0)),0) as sem17,
				ifnull(sum(if(a.semana = 18, a.cantidad, 0)),0) as sem18,
				ifnull(sum(if(a.semana = 19, a.cantidad, 0)),0) as sem19,
				ifnull(sum(if(a.semana = 20, a.cantidad, 0)),0) as sem20,
				ifnull(sum(if(a.semana = 21, a.cantidad, 0)),0) as sem21,
				ifnull(sum(if(a.semana = 22, a.cantidad, 0)),0) as sem22,
				ifnull(sum(if(a.semana = 23, a.cantidad, 0)),0) as sem23,
				ifnull(sum(if(a.semana = 24, a.cantidad, 0)),0) as sem24,
				ifnull(sum(if(a.semana = 25, a.cantidad, 0)),0) as sem25,
				ifnull(sum(if(a.semana = 26, a.cantidad, 0)),0) as sem26,
				ifnull(sum(if(a.semana = 27, a.cantidad, 0)),0) as sem27,
				ifnull(sum(if(a.semana = 28, a.cantidad, 0)),0) as sem28,
				ifnull(sum(if(a.semana = 29, a.cantidad, 0)),0) as sem29,
				ifnull(sum(if(a.semana = 30, a.cantidad, 0)),0) as sem30,
				ifnull(sum(if(a.semana = 31, a.cantidad, 0)),0) as sem31,
				ifnull(sum(if(a.semana = 32, a.cantidad, 0)),0) as sem32,
				ifnull(sum(if(a.semana = 33, a.cantidad, 0)),0) as sem33,
				ifnull(sum(if(a.semana = 34, a.cantidad, 0)),0) as sem34,
				ifnull(sum(if(a.semana = 35, a.cantidad, 0)),0) as sem35,
				ifnull(sum(if(a.semana = 36, a.cantidad, 0)),0) as sem36,
				ifnull(sum(if(a.semana = 37, a.cantidad, 0)),0) as sem37,
				ifnull(sum(if(a.semana = 38, a.cantidad, 0)),0) as sem38,
				ifnull(sum(if(a.semana = 39, a.cantidad, 0)),0) as sem39,
				ifnull(sum(if(a.semana = 40, a.cantidad, 0)),0) as sem40,
				ifnull(sum(if(a.semana = 41, a.cantidad, 0)),0) as sem41,
				ifnull(sum(if(a.semana = 42, a.cantidad, 0)),0) as sem42,
				ifnull(sum(if(a.semana = 43, a.cantidad, 0)),0) as sem43,
				ifnull(sum(if(a.semana = 44, a.cantidad, 0)),0) as sem44,
				ifnull(sum(if(a.semana = 45, a.cantidad, 0)),0) as sem45,
				ifnull(sum(if(a.semana = 46, a.cantidad, 0)),0) as sem46,
				ifnull(sum(if(a.semana = 47, a.cantidad, 0)),0) as sem47,
				ifnull(sum(if(a.semana = 48, a.cantidad, 0)),0) as sem48,
				ifnull(sum(if(a.semana = 49, a.cantidad, 0)),0) as sem49,
				ifnull(sum(if(a.semana = 50, a.cantidad, 0)),0) as sem50,
				ifnull(sum(if(a.semana = 51, a.cantidad, 0)),0) as sem51,
				ifnull(sum(if(a.semana = 52, a.cantidad, 0)),0) as sem52,
				ifnull(sum(if(a.semana = 53, a.cantidad, 0)),0) as sem53
				from
				diresas b
				left join
				(select sub_reg_nt, semana, count(ubigeo) as cantidad from individual 
				where ano = $anio and diagnostic = '".$diagno."'
				group by sub_reg_nt, semana) a
				on b.codigo = a.sub_reg_nt
				group by b.nombre
				";
			}else{
				$this->session->set_flashdata('error', 'Debe elegir alg&uacute;n nivel de proceso, este reporte no est&aacute; activo para su nivel de usuario, comun&iacute;quese a notificacion@dge.gob.pe');
				redirect(site_url("reportes/repIndividual"), 301);
			}
		}
		
		$query = $this->db->query($plantilla);
		
		return $query->result();
		
	}

	//Reporte de la notificación individual en descripción de espacio por nivel de ubigeo
	public function notificacionIndPersonaUbigeo($anio, $diagno, $departamento, $provincia, $distrito)
	{
		if(!empty($departamento) and !empty($provincia) and !empty($distrito)){
			$plantilla = "
			select a.distrito as nombre,
			ifnull(b.masculino,0) as masculino,
			ifnull(b.femenino,0) as femenino,
			ifnull(b.total,0) as total,
			sum(a.pobtot) as poblacion,
			ifnull(b.c0,0) as c0,
			round(ifnull(b.c0/sum(a.pobtot) * 100000,0),2) as t0,
			ifnull(c.d0,0) as d0,
			round(ifnull(c.d0/sum(a.pobtot) * 100000,0),2) as td0,
			ifnull(b.c1_11,0) as c1_11,
			round(ifnull(b.c1_11/sum(a.pobtot) * 100000,0),2) as t1_11,
			ifnull(c.d1_11,0) as d1_11,
			round(ifnull(c.d1_11/sum(a.pobtot) * 100000,0),2) as td1_11,
			ifnull(b.c12_17,0) as c12_17,
			round(ifnull(b.c12_17/sum(a.pobtot) * 100000,0),2) as t12_17,
			ifnull(c.d12_17,0) as d12_17,
			round(ifnull(c.d12_17/sum(a.pobtot) * 100000,0),2) as td12_17,
			ifnull(b.c18_29,0) as c18_29,
			round(ifnull(b.c18_29/sum(a.pobtot) * 100000,0),2) as t18_29,
			ifnull(c.d18_29,0) as d18_29,
			round(ifnull(c.d18_29/sum(a.pobtot) * 100000,0),2) as td18_29,
			ifnull(b.c30_59,0) as c30_59,
			round(ifnull(b.c30_59/sum(a.pobtot) * 100000,0),2) as t30_59,
			ifnull(c.d30_59,0) as d30_59,
			round(ifnull(c.d30_59/sum(a.pobtot) * 100000,0),2) as td30_59,
			ifnull(b.c60,0) as c60,
			round(ifnull(b.c60/sum(a.pobtot) * 100000,0),2) as t60,
			ifnull(c.d60,0) as d60,
			round(ifnull(c.d60/sum(a.pobtot) * 100000,0),2) as td60
			from
			codubi a
			left join
			(select ubigeo,
			sum(if(sexo='M',1,0)) as masculino,
			sum(if(sexo='F',1,0)) as femenino,
			count(ubigeo) as total,
			sum(if(tipo_edad <> 'A', 1, 0)) as c0,
			sum(if(edad >= 1 and edad <= 11 and tipo_edad = 'A', 1, 0)) as c1_11,
			sum(if(edad >= 12 and edad <= 17 and tipo_edad = 'A', 1, 0)) as c12_17,
			sum(if(edad >= 18 and edad <= 29 and tipo_edad = 'A', 1, 0)) as c18_29,
			sum(if(edad >= 30 and edad <= 59 and tipo_edad = 'A', 1, 0)) as c30_59,
			sum(if(edad >= 60 and tipo_edad = 'A', 1, 0)) as c60
			from individual
			where ubigeo = '".$distrito."' and diagnostic = '".$diagno."' and tipo_dx <> 'D' and ubigeo <> ''
			group by ubigeo
			order by ubigeo) b
			on a.ubigeo = b.ubigeo
			left join
			(select ubigeo as ubigeo,
			sum(if(sexo='M',1,0)) as masculino,
			sum(if(sexo='F',1,0)) as femenino,
			count(ubigeo) as total,
			sum(if(tipo_edad <> 'A', 1, 0)) as d0,
			sum(if(edad >= 1 and edad <= 11 and tipo_edad = 'A', 1, 0)) as d1_11,
			sum(if(edad >= 12 and edad <= 17 and tipo_edad = 'A', 1, 0)) as d12_17,
			sum(if(edad >= 18 and edad <= 29 and tipo_edad = 'A', 1, 0)) as d18_29,
			sum(if(edad >= 30 and edad <= 59 and tipo_edad = 'A', 1, 0)) as d30_59,
			sum(if(edad >= 60 and tipo_edad = 'A', 1, 0)) as d60
			from individual
			where ubigeo = '".$distrito."' and diagnostic = '".$diagno."' and tipo_dx <> 'D' and ubigeo <> '' and fecha_def <> '0000-00-00'
			group by ubigeo
			order by ubigeo) c
			on a.ubigeo = c.ubigeo
			where a.ubigeo = '".$distrito."' and a.ano = ".$anio ." and a.ubigeo <> '999999'
			group by a.distrito
			";
		}elseif(!empty($departamento) and !empty($provincia) and empty($distrito)){
			$plantilla = "
			select a.distrito as nombre,
			ifnull(b.masculino,0) as masculino,
			ifnull(b.femenino,0) as femenino,
			ifnull(b.total,0) as total,
			sum(a.pobtot) as poblacion,
			ifnull(b.c0,0) as c0,
			round(ifnull(b.c0/sum(a.pobtot) * 100000,0),2) as t0,
			ifnull(c.d0,0) as d0,
			round(ifnull(c.d0/sum(a.pobtot) * 100000,0),2) as td0,
			ifnull(b.c1_11,0) as c1_11,
			round(ifnull(b.c1_11/sum(a.pobtot) * 100000,0),2) as t1_11,
			ifnull(c.d1_11,0) as d1_11,
			round(ifnull(c.d1_11/sum(a.pobtot) * 100000,0),2) as td1_11,
			ifnull(b.c12_17,0) as c12_17,
			round(ifnull(b.c12_17/sum(a.pobtot) * 100000,0),2) as t12_17,
			ifnull(c.d12_17,0) as d12_17,
			round(ifnull(c.d12_17/sum(a.pobtot) * 100000,0),2) as td12_17,
			ifnull(b.c18_29,0) as c18_29,
			round(ifnull(b.c18_29/sum(a.pobtot) * 100000,0),2) as t18_29,
			ifnull(c.d18_29,0) as d18_29,
			round(ifnull(c.d18_29/sum(a.pobtot) * 100000,0),2) as td18_29,
			ifnull(b.c30_59,0) as c30_59,
			round(ifnull(b.c30_59/sum(a.pobtot) * 100000,0),2) as t30_59,
			ifnull(c.d30_59,0) as d30_59,
			round(ifnull(c.d30_59/sum(a.pobtot) * 100000,0),2) as td30_59,
			ifnull(b.c60,0) as c60,
			round(ifnull(b.c60/sum(a.pobtot) * 100000,0),2) as t60,
			ifnull(c.d60,0) as d60,
			round(ifnull(c.d60/sum(a.pobtot) * 100000,0),2) as td60
			from
			codubi a
			left join
			(select ubigeo,
			sum(if(sexo='M',1,0)) as masculino,
			sum(if(sexo='F',1,0)) as femenino,
			count(ubigeo) as total,
			sum(if(tipo_edad <> 'A', 1, 0)) as c0,
			sum(if(edad >= 1 and edad <= 11 and tipo_edad = 'A', 1, 0)) as c1_11,
			sum(if(edad >= 12 and edad <= 17 and tipo_edad = 'A', 1, 0)) as c12_17,
			sum(if(edad >= 18 and edad <= 29 and tipo_edad = 'A', 1, 0)) as c18_29,
			sum(if(edad >= 30 and edad <= 59 and tipo_edad = 'A', 1, 0)) as c30_59,
			sum(if(edad >= 60 and tipo_edad = 'A', 1, 0)) as c60
			from individual
			where substr(ubigeo,1,4) = '".$provincia."' and diagnostic = '".$diagno."' and tipo_dx <> 'D' and ubigeo <> ''
			group by ubigeo
			order by ubigeo) b
			on a.ubigeo = b.ubigeo
			left join
			(select ubigeo as ubigeo,
			sum(if(sexo='M',1,0)) as masculino,
			sum(if(sexo='F',1,0)) as femenino,
			count(ubigeo) as total,
			sum(if(tipo_edad <> 'A', 1, 0)) as d0,
			sum(if(edad >= 1 and edad <= 11 and tipo_edad = 'A', 1, 0)) as d1_11,
			sum(if(edad >= 12 and edad <= 17 and tipo_edad = 'A', 1, 0)) as d12_17,
			sum(if(edad >= 18 and edad <= 29 and tipo_edad = 'A', 1, 0)) as d18_29,
			sum(if(edad >= 30 and edad <= 59 and tipo_edad = 'A', 1, 0)) as d30_59,
			sum(if(edad >= 60 and tipo_edad = 'A', 1, 0)) as d60
			from individual
			where substr(ubigeo,1,4) = '".$provincia."' and diagnostic = '".$diagno."' and tipo_dx <> 'D' and ubigeo <> '' and fecha_def <> '0000-00-00'
			group by ubigeo
			order by ubigeo) c
			on a.ubigeo = c.ubigeo
			where substr(a.ubigeo,1,4) = '".$provincia."' and a.ano = ".$anio ." and a.ubigeo <> '999999'
			group by a.distrito
			";
		}elseif(!empty($departamento) and empty($provincia) and empty($distrito)){
			$plantilla = "
			select a.provincia as nombre,
			ifnull(b.masculino,0) as masculino,
			ifnull(b.femenino,0) as femenino,
			ifnull(b.total,0) as total,
			sum(a.pobtot) as poblacion,
			ifnull(b.c0,0) as c0,
			round(ifnull(b.c0/sum(a.pobtot) * 100000,0),2) as t0,
			ifnull(c.d0,0) as d0,
			round(ifnull(c.d0/sum(a.pobtot) * 100000,0),2) as td0,
			ifnull(b.c1_11,0) as c1_11,
			round(ifnull(b.c1_11/sum(a.pobtot) * 100000,0),2) as t1_11,
			ifnull(c.d1_11,0) as d1_11,
			round(ifnull(c.d1_11/sum(a.pobtot) * 100000,0),2) as td1_11,
			ifnull(b.c12_17,0) as c12_17,
			round(ifnull(b.c12_17/sum(a.pobtot) * 100000,0),2) as t12_17,
			ifnull(c.d12_17,0) as d12_17,
			round(ifnull(c.d12_17/sum(a.pobtot) * 100000,0),2) as td12_17,
			ifnull(b.c18_29,0) as c18_29,
			round(ifnull(b.c18_29/sum(a.pobtot) * 100000,0),2) as t18_29,
			ifnull(c.d18_29,0) as d18_29,
			round(ifnull(c.d18_29/sum(a.pobtot) * 100000,0),2) as td18_29,
			ifnull(b.c30_59,0) as c30_59,
			round(ifnull(b.c30_59/sum(a.pobtot) * 100000,0),2) as t30_59,
			ifnull(c.d30_59,0) as d30_59,
			round(ifnull(c.d30_59/sum(a.pobtot) * 100000,0),2) as td30_59,
			ifnull(b.c60,0) as c60,
			round(ifnull(b.c60/sum(a.pobtot) * 100000,0),2) as t60,
			ifnull(c.d60,0) as d60,
			round(ifnull(c.d60/sum(a.pobtot) * 100000,0),2) as td60
			from
			codubi a
			left join
			(select substr(ubigeo,1,4) as ubigeo,
			sum(if(sexo='M',1,0)) as masculino,
			sum(if(sexo='F',1,0)) as femenino,
			count(ubigeo) as total,
			sum(if(tipo_edad <> 'A', 1, 0)) as c0,
			sum(if(edad >= 1 and edad <= 11 and tipo_edad = 'A', 1, 0)) as c1_11,
			sum(if(edad >= 12 and edad <= 17 and tipo_edad = 'A', 1, 0)) as c12_17,
			sum(if(edad >= 18 and edad <= 29 and tipo_edad = 'A', 1, 0)) as c18_29,
			sum(if(edad >= 30 and edad <= 59 and tipo_edad = 'A', 1, 0)) as c30_59,
			sum(if(edad >= 60 and tipo_edad = 'A', 1, 0)) as c60
			from individual
			where substr(ubigeo,1,2) = '".$departamento."' and diagnostic = '".$diagno."' and tipo_dx <> 'D' and ubigeo <> ''
			group by substr(ubigeo,1,4)
			order by substr(ubigeo,1,4)) b
			on substr(a.ubigeo,1,4) = b.ubigeo
			left join
			(select substr(ubigeo,1,4) as ubigeo,
			sum(if(sexo='M',1,0)) as masculino,
			sum(if(sexo='F',1,0)) as femenino,
			count(ubigeo) as total,
			sum(if(tipo_edad <> 'A', 1, 0)) as d0,
			sum(if(edad >= 1 and edad <= 11 and tipo_edad = 'A', 1, 0)) as d1_11,
			sum(if(edad >= 12 and edad <= 17 and tipo_edad = 'A', 1, 0)) as d12_17,
			sum(if(edad >= 18 and edad <= 29 and tipo_edad = 'A', 1, 0)) as d18_29,
			sum(if(edad >= 30 and edad <= 59 and tipo_edad = 'A', 1, 0)) as d30_59,
			sum(if(edad >= 60 and tipo_edad = 'A', 1, 0)) as d60
			from individual
			where substr(ubigeo,1,2) = '".$departamento."' and diagnostic = '".$diagno."' and tipo_dx <> 'D' and ubigeo <> '' and fecha_def <> '0000-00-00'
			group by substr(ubigeo,1,4)
			order by substr(ubigeo,1,4)) c
			on substr(a.ubigeo,1,4) = c.ubigeo
			where substr(a.ubigeo,1,2) = '".$departamento."' and a.ano = ".$anio ." and a.ubigeo <> '999999'
			group by a.provincia
			";
		}elseif(empty($departamento) and empty($provincia) and empty($distrito)){
			if($this->session->userdata('nivel') == '1' or $this->session->userdata('nivel') == '4'){
				$plantilla = "
				select a.departam as nombre,
				ifnull(b.masculino,0) as masculino,
				ifnull(b.femenino,0) as femenino,
				ifnull(b.total,0) as total,
				sum(a.pobtot) as poblacion,
				ifnull(b.c0,0) as c0,
				round(ifnull(b.c0/sum(a.pobtot) * 100000,0),2) as t0,
				ifnull(c.d0,0) as d0,
				round(ifnull(c.d0/sum(a.pobtot) * 100000,0),2) as td0,
				ifnull(b.c1_11,0) as c1_11,
				round(ifnull(b.c1_11/sum(a.pobtot) * 100000,0),2) as t1_11,
				ifnull(c.d1_11,0) as d1_11,
				round(ifnull(c.d1_11/sum(a.pobtot) * 100000,0),2) as td1_11,
				ifnull(b.c12_17,0) as c12_17,
				round(ifnull(b.c12_17/sum(a.pobtot) * 100000,0),2) as t12_17,
				ifnull(c.d12_17,0) as d12_17,
				round(ifnull(c.d12_17/sum(a.pobtot) * 100000,0),2) as td12_17,
				ifnull(b.c18_29,0) as c18_29,
				round(ifnull(b.c18_29/sum(a.pobtot) * 100000,0),2) as t18_29,
				ifnull(c.d18_29,0) as d18_29,
				round(ifnull(c.d18_29/sum(a.pobtot) * 100000,0),2) as td18_29,
				ifnull(b.c30_59,0) as c30_59,
				round(ifnull(b.c30_59/sum(a.pobtot) * 100000,0),2) as t30_59,
				ifnull(c.d30_59,0) as d30_59,
				round(ifnull(c.d30_59/sum(a.pobtot) * 100000,0),2) as td30_59,
				ifnull(b.c60,0) as c60,
				round(ifnull(b.c60/sum(a.pobtot) * 100000,0),2) as t60,
				ifnull(c.d60,0) as d60,
				round(ifnull(c.d60/sum(a.pobtot) * 100000,0),2) as td60
				from
				codubi a
				left join
				(select substr(ubigeo,1,2) as ubigeo,
				sum(if(sexo='M',1,0)) as masculino,
				sum(if(sexo='F',1,0)) as femenino,
				count(ubigeo) as total,
				sum(if(tipo_edad <> 'A', 1, 0)) as c0,
				sum(if(edad >= 1 and edad <= 11 and tipo_edad = 'A', 1, 0)) as c1_11,
				sum(if(edad >= 12 and edad <= 17 and tipo_edad = 'A', 1, 0)) as c12_17,
				sum(if(edad >= 18 and edad <= 29 and tipo_edad = 'A', 1, 0)) as c18_29,
				sum(if(edad >= 30 and edad <= 59 and tipo_edad = 'A', 1, 0)) as c30_59,
				sum(if(edad >= 60 and tipo_edad = 'A', 1, 0)) as c60
				from individual
				where diagnostic = '".$diagno."' and tipo_dx <> 'D' and ubigeo <> ''
				group by substr(ubigeo,1,2)
				order by substr(ubigeo,1,2)) b
				on substr(a.ubigeo,1,2) = b.ubigeo
				left join
				(select substr(ubigeo,1,2) as ubigeo,
				sum(if(sexo='M',1,0)) as masculino,
				sum(if(sexo='F',1,0)) as femenino,
				count(ubigeo) as total,
				sum(if(tipo_edad <> 'A', 1, 0)) as d0,
				sum(if(edad >= 1 and edad <= 11 and tipo_edad = 'A', 1, 0)) as d1_11,
				sum(if(edad >= 12 and edad <= 17 and tipo_edad = 'A', 1, 0)) as d12_17,
				sum(if(edad >= 18 and edad <= 29 and tipo_edad = 'A', 1, 0)) as d18_29,
				sum(if(edad >= 30 and edad <= 59 and tipo_edad = 'A', 1, 0)) as d30_59,
				sum(if(edad >= 60 and tipo_edad = 'A', 1, 0)) as d60
				from individual
				where diagnostic = '".$diagno."' and tipo_dx <> 'D' and ubigeo <> '' and fecha_def <> '0000-00-00'
				group by substr(ubigeo,1,2)
				order by substr(ubigeo,1,2)) c
				on substr(a.ubigeo,1,2) = c.ubigeo
				where a.ano = ".$anio ." and a.ubigeo <> '999999'
				group by a.departam
				";
			}else{
				$this->session->set_flashdata('error', 'Debe elegir alg&uacute;n nivel de proceso, este reporte no est&aacute; activo para su nivel de usuario, comun&iacute;quese a notificacion@dge.gob.pe');
				redirect(site_url("reportes/repIndividual"), 301);
			}
		}
		
		$query = $this->db->query($plantilla);
		
		return $query->result();
		
	}

	//Reporte de la notificación individual en descripción de persona por nivel de EESS
	public function notificacionIndPersonaEESS($anio, $diagno, $diresa, $red, $microred, $establec)
	{
		if(!empty($diresa) and !empty($red) and !empty($microred) and !empty($establec)){
			$plantilla = "
			select a.raz_soc as nombre,
			ifnull(b.masculino,0) as masculino,
			ifnull(b.femenino,0) as femenino,
			ifnull(b.total,0) as total,
			ifnull(b.c0,0) as c0,
			'0.00' as t0,
			ifnull(c.d0,0) as d0,
			'0.00' as td0,
			ifnull(b.c1_11,0) as c1_11,
			'0.00' as t1_11,
			ifnull(c.d1_11,0) as d1_11,
			'0.00' as td1_11,
			ifnull(b.c12_17,0) as c12_17,
			'0.00' as t12_17,
			ifnull(c.d12_17,0) as d12_17,
			'0.00' as td12_17,
			ifnull(b.c18_29,0) as c18_29,
			'0.00' as t18_29,
			ifnull(c.d18_29,0) as d18_29,
			'0.00' as td18_29,
			ifnull(b.c30_59,0) as c30_59,
			'0.00' as t30_59,
			ifnull(c.d30_59,0) as d30_59,
			'0.00' as td30_59,
			ifnull(b.c60,0) as c60,
			'0.00' as t60,
			ifnull(c.d60,0) as d60,
			'0.00' as td60
			from
			renace a
			left join
			(select e_salud,
			sum(if(sexo='M',1,0)) as masculino,
			sum(if(sexo='F',1,0)) as femenino,
			count(ubigeo) as total,
			sum(if(tipo_edad <> 'A', 1, 0)) as c0,
			sum(if(edad >= 1 and edad <= 11 and tipo_edad = 'A', 1, 0)) as c1_11,
			sum(if(edad >= 12 and edad <= 17 and tipo_edad = 'A', 1, 0)) as c12_17,
			sum(if(edad >= 18 and edad <= 29 and tipo_edad = 'A', 1, 0)) as c18_29,
			sum(if(edad >= 30 and edad <= 59 and tipo_edad = 'A', 1, 0)) as c30_59,
			sum(if(edad >= 60 and tipo_edad = 'A', 1, 0)) as c60
			from individual
			where diagnostic = '".$diagno."' and tipo_dx <> 'D' and ubigeo <> ''
			group by e_salud
			order by e_salud) b
			on cod_est = b.e_salud
			left join
			(select e_salud,
			sum(if(sexo='M',1,0)) as masculino,
			sum(if(sexo='F',1,0)) as femenino,
			count(ubigeo) as total,
			sum(if(tipo_edad <> 'A', 1, 0)) as d0,
			sum(if(edad >= 1 and edad <= 11 and tipo_edad = 'A', 1, 0)) as d1_11,
			sum(if(edad >= 12 and edad <= 17 and tipo_edad = 'A', 1, 0)) as d12_17,
			sum(if(edad >= 18 and edad <= 29 and tipo_edad = 'A', 1, 0)) as d18_29,
			sum(if(edad >= 30 and edad <= 59 and tipo_edad = 'A', 1, 0)) as d30_59,
			sum(if(edad >= 60 and tipo_edad = 'A', 1, 0)) as d60
			from individual
			where diagnostic = '".$diagno."' and tipo_dx <> 'D' and ubigeo <> '' and fecha_def <> '0000-00-00'
			group by e_salud
			order by e_salud) c
			on cod_est = c.e_salud
			where a.cod_est = '".$establec."' and a.estado = '1'
			group by a.raz_soc
			";
		}elseif(!empty($diresa) and !empty($red) and !empty($microred) and empty($establec)){
			$plantilla = "
			select a.raz_soc as nombre,
			ifnull(b.masculino,0) as masculino,
			ifnull(b.femenino,0) as femenino,
			ifnull(b.total,0) as total,
			ifnull(b.c0,0) as c0,
			'0.00' as t0,
			ifnull(c.d0,0) as d0,
			'0.00' as td0,
			ifnull(b.c1_11,0) as c1_11,
			'0.00' as t1_11,
			ifnull(c.d1_11,0) as d1_11,
			'0.00' as td1_11,
			ifnull(b.c12_17,0) as c12_17,
			'0.00' as t12_17,
			ifnull(c.d12_17,0) as d12_17,
			'0.00' as td12_17,
			ifnull(b.c18_29,0) as c18_29,
			'0.00' as t18_29,
			ifnull(c.d18_29,0) as d18_29,
			'0.00' as td18_29,
			ifnull(b.c30_59,0) as c30_59,
			'0.00' as t30_59,
			ifnull(c.d30_59,0) as d30_59,
			'0.00' as td30_59,
			ifnull(b.c60,0) as c60,
			'0.00' as t60,
			ifnull(c.d60,0) as d60,
			'0.00' as td60
			from
			renace a
			left join
			(select e_salud,
			sum(if(sexo='M',1,0)) as masculino,
			sum(if(sexo='F',1,0)) as femenino,
			count(ubigeo) as total,
			sum(if(tipo_edad <> 'A', 1, 0)) as c0,
			sum(if(edad >= 1 and edad <= 11 and tipo_edad = 'A', 1, 0)) as c1_11,
			sum(if(edad >= 12 and edad <= 17 and tipo_edad = 'A', 1, 0)) as c12_17,
			sum(if(edad >= 18 and edad <= 29 and tipo_edad = 'A', 1, 0)) as c18_29,
			sum(if(edad >= 30 and edad <= 59 and tipo_edad = 'A', 1, 0)) as c30_59,
			sum(if(edad >= 60 and tipo_edad = 'A', 1, 0)) as c60
			from individual
			where diagnostic = '".$diagno."' and tipo_dx <> 'D' and ubigeo <> ''
			group by e_salud
			order by e_salud) b
			on cod_est = b.e_salud
			left join
			(select e_salud,
			sum(if(sexo='M',1,0)) as masculino,
			sum(if(sexo='F',1,0)) as femenino,
			count(ubigeo) as total,
			sum(if(tipo_edad <> 'A', 1, 0)) as d0,
			sum(if(edad >= 1 and edad <= 11 and tipo_edad = 'A', 1, 0)) as d1_11,
			sum(if(edad >= 12 and edad <= 17 and tipo_edad = 'A', 1, 0)) as d12_17,
			sum(if(edad >= 18 and edad <= 29 and tipo_edad = 'A', 1, 0)) as d18_29,
			sum(if(edad >= 30 and edad <= 59 and tipo_edad = 'A', 1, 0)) as d30_59,
			sum(if(edad >= 60 and tipo_edad = 'A', 1, 0)) as d60
			from individual
			where diagnostic = '".$diagno."' and tipo_dx <> 'D' and ubigeo <> '' and fecha_def <> '0000-00-00'
			group by e_salud
			order by e_salud) c
			on cod_est = c.e_salud
			where a.subregion = '".$diresa."' and a.red = '".$red."' and a.microred = '".$microred."' and a.estado = '1'
			group by a.raz_soc
			";
		}elseif(!empty($diresa) and !empty($red) and empty($microred) and empty($establec)){
			$plantilla = "
			select a.nombre,
			ifnull(b.masculino,0) as masculino,
			ifnull(b.femenino,0) as femenino,
			ifnull(b.total,0) as total,
			ifnull(b.c0,0) as c0,
			'0.00' as t0,
			ifnull(c.d0,0) as d0,
			'0.00' as td0,
			ifnull(b.c1_11,0) as c1_11,
			'0.00' as t1_11,
			ifnull(c.d1_11,0) as d1_11,
			'0.00' as td1_11,
			ifnull(b.c12_17,0) as c12_17,
			'0.00' as t12_17,
			ifnull(c.d12_17,0) as d12_17,
			'0.00' as td12_17,
			ifnull(b.c18_29,0) as c18_29,
			'0.00' as t18_29,
			ifnull(c.d18_29,0) as d18_29,
			'0.00' as td18_29,
			ifnull(b.c30_59,0) as c30_59,
			'0.00' as t30_59,
			ifnull(c.d30_59,0) as d30_59,
			'0.00' as td30_59,
			ifnull(b.c60,0) as c60,
			'0.00' as t60,
			ifnull(c.d60,0) as d60,
			'0.00' as td60
			from
			microred a
			left join
			(select sub_reg_nt, red, microred,
			sum(if(sexo='M',1,0)) as masculino,
			sum(if(sexo='F',1,0)) as femenino,
			count(ubigeo) as total,
			sum(if(tipo_edad <> 'A', 1, 0)) as c0,
			sum(if(edad >= 1 and edad <= 11 and tipo_edad = 'A', 1, 0)) as c1_11,
			sum(if(edad >= 12 and edad <= 17 and tipo_edad = 'A', 1, 0)) as c12_17,
			sum(if(edad >= 18 and edad <= 29 and tipo_edad = 'A', 1, 0)) as c18_29,
			sum(if(edad >= 30 and edad <= 59 and tipo_edad = 'A', 1, 0)) as c30_59,
			sum(if(edad >= 60 and tipo_edad = 'A', 1, 0)) as c60
			from individual
			where diagnostic = '".$diagno."' and tipo_dx <> 'D' and ubigeo <> ''
			group by sub_reg_nt, red, microred
			order by sub_reg_nt, red, microred) b
			on concat(a.subregion, a.red, a.codigo) = concat(b.sub_reg_nt, b.red, b.microred)
			left join
			(select sub_reg_nt, red, microred,
			sum(if(sexo='M',1,0)) as masculino,
			sum(if(sexo='F',1,0)) as femenino,
			count(ubigeo) as total,
			sum(if(tipo_edad <> 'A', 1, 0)) as d0,
			sum(if(edad >= 1 and edad <= 11 and tipo_edad = 'A', 1, 0)) as d1_11,
			sum(if(edad >= 12 and edad <= 17 and tipo_edad = 'A', 1, 0)) as d12_17,
			sum(if(edad >= 18 and edad <= 29 and tipo_edad = 'A', 1, 0)) as d18_29,
			sum(if(edad >= 30 and edad <= 59 and tipo_edad = 'A', 1, 0)) as d30_59,
			sum(if(edad >= 60 and tipo_edad = 'A', 1, 0)) as d60
			from individual
			where diagnostic = '".$diagno."' and tipo_dx <> 'D' and ubigeo <> '' and fecha_def <> '0000-00-00'
			group by sub_reg_nt, red, microred
			order by sub_reg_nt, red, microred) c
			on concat(a.subregion,a.red,a.codigo) = concat(b.sub_reg_nt, b.red, b.microred)
			where a.subregion = '".$diresa."' and a.red = '".$red."' and a.estado = '1'
			group by a.nombre
			";
		}elseif(!empty($diresa) and empty($red) and empty($microred) and empty($establec)){
			$plantilla = "
			select a.nombre,
			ifnull(b.masculino,0) as masculino,
			ifnull(b.femenino,0) as femenino,
			ifnull(b.total,0) as total,
			ifnull(b.c0,0) as c0,
			'0.00' as t0,
			ifnull(c.d0,0) as d0,
			'0.00' as td0,
			ifnull(b.c1_11,0) as c1_11,
			'0.00' as t1_11,
			ifnull(c.d1_11,0) as d1_11,
			'0.00' as td1_11,
			ifnull(b.c12_17,0) as c12_17,
			'0.00' as t12_17,
			ifnull(c.d12_17,0) as d12_17,
			'0.00' as td12_17,
			ifnull(b.c18_29,0) as c18_29,
			'0.00' as t18_29,
			ifnull(c.d18_29,0) as d18_29,
			'0.00' as td18_29,
			ifnull(b.c30_59,0) as c30_59,
			'0.00' as t30_59,
			ifnull(c.d30_59,0) as d30_59,
			'0.00' as td30_59,
			ifnull(b.c60,0) as c60,
			'0.00' as t60,
			ifnull(c.d60,0) as d60,
			'0.00' as td60
			from
			redes a
			left join
			(select sub_reg_nt, red,
			sum(if(sexo='M',1,0)) as masculino,
			sum(if(sexo='F',1,0)) as femenino,
			count(ubigeo) as total,
			sum(if(tipo_edad <> 'A', 1, 0)) as c0,
			sum(if(edad >= 1 and edad <= 11 and tipo_edad = 'A', 1, 0)) as c1_11,
			sum(if(edad >= 12 and edad <= 17 and tipo_edad = 'A', 1, 0)) as c12_17,
			sum(if(edad >= 18 and edad <= 29 and tipo_edad = 'A', 1, 0)) as c18_29,
			sum(if(edad >= 30 and edad <= 59 and tipo_edad = 'A', 1, 0)) as c30_59,
			sum(if(edad >= 60 and tipo_edad = 'A', 1, 0)) as c60
			from individual
			where diagnostic = '".$diagno."' and tipo_dx <> 'D' and ubigeo <> ''
			group by sub_reg_nt, red
			order by sub_reg_nt, red) b
			on concat(subregion,codigo) = concat(b.sub_reg_nt, b.red)
			left join
			(select sub_reg_nt, red,
			sum(if(sexo='M',1,0)) as masculino,
			sum(if(sexo='F',1,0)) as femenino,
			count(ubigeo) as total,
			sum(if(tipo_edad <> 'A', 1, 0)) as d0,
			sum(if(edad >= 1 and edad <= 11 and tipo_edad = 'A', 1, 0)) as d1_11,
			sum(if(edad >= 12 and edad <= 17 and tipo_edad = 'A', 1, 0)) as d12_17,
			sum(if(edad >= 18 and edad <= 29 and tipo_edad = 'A', 1, 0)) as d18_29,
			sum(if(edad >= 30 and edad <= 59 and tipo_edad = 'A', 1, 0)) as d30_59,
			sum(if(edad >= 60 and tipo_edad = 'A', 1, 0)) as d60
			from individual
			where diagnostic = '".$diagno."' and tipo_dx <> 'D' and ubigeo <> '' and fecha_def <> '0000-00-00'
			group by sub_reg_nt, red
			order by sub_reg_nt, red) c
			on concat(subregion,codigo) = concat(b.sub_reg_nt, b.red)
			where subregion = '".$diresa."' and estado = '1'
			group by a.nombre
			";
		}elseif(empty($diresa) and empty($red) and empty($microred) and empty($establec)){
			if($this->session->userdata('nivel') == '1' or $this->session->userdata('nivel') == '4'){
				$plantilla = "
				select a.nombre,
				ifnull(b.masculino,0) as masculino,
				ifnull(b.femenino,0) as femenino,
				ifnull(b.total,0) as total,
				ifnull(b.c0,0) as c0,
				'0.00' as t0,
				ifnull(c.d0,0) as d0,
				'0.00' as td0,
				ifnull(b.c1_11,0) as c1_11,
				'0.00' as t1_11,
				ifnull(c.d1_11,0) as d1_11,
				'0.00' as td1_11,
				ifnull(b.c12_17,0) as c12_17,
				'0.00' as t12_17,
				ifnull(c.d12_17,0) as d12_17,
				'0.00' as td12_17,
				ifnull(b.c18_29,0) as c18_29,
				'0.00' as t18_29,
				ifnull(c.d18_29,0) as d18_29,
				'0.00' as td18_29,
				ifnull(b.c30_59,0) as c30_59,
				'0.00' as t30_59,
				ifnull(c.d30_59,0) as d30_59,
				'0.00' as td30_59,
				ifnull(b.c60,0) as c60,
				'0.00' as t60,
				ifnull(c.d60,0) as d60,
				'0.00' as td60
				from
				diresas a
				left join
				(select sub_reg_nt,
				sum(if(sexo='M',1,0)) as masculino,
				sum(if(sexo='F',1,0)) as femenino,
				count(ubigeo) as total,
				sum(if(tipo_edad <> 'A', 1, 0)) as c0,
				sum(if(edad >= 1 and edad <= 11 and tipo_edad = 'A', 1, 0)) as c1_11,
				sum(if(edad >= 12 and edad <= 17 and tipo_edad = 'A', 1, 0)) as c12_17,
				sum(if(edad >= 18 and edad <= 29 and tipo_edad = 'A', 1, 0)) as c18_29,
				sum(if(edad >= 30 and edad <= 59 and tipo_edad = 'A', 1, 0)) as c30_59,
				sum(if(edad >= 60 and tipo_edad = 'A', 1, 0)) as c60
				from individual
				where diagnostic = '".$diagno."' and tipo_dx <> 'D' and ubigeo <> ''
				group by sub_reg_nt
				order by sub_reg_nt) b
				on codigo = b.sub_reg_nt
				left join
				(select sub_reg_nt,
				sum(if(sexo='M',1,0)) as masculino,
				sum(if(sexo='F',1,0)) as femenino,
				count(ubigeo) as total,
				sum(if(tipo_edad <> 'A', 1, 0)) as d0,
				sum(if(edad >= 1 and edad <= 11 and tipo_edad = 'A', 1, 0)) as d1_11,
				sum(if(edad >= 12 and edad <= 17 and tipo_edad = 'A', 1, 0)) as d12_17,
				sum(if(edad >= 18 and edad <= 29 and tipo_edad = 'A', 1, 0)) as d18_29,
				sum(if(edad >= 30 and edad <= 59 and tipo_edad = 'A', 1, 0)) as d30_59,
				sum(if(edad >= 60 and tipo_edad = 'A', 1, 0)) as d60
				from individual
				where diagnostic = '".$diagno."' and tipo_dx <> 'D' and ubigeo <> '' and fecha_def <> '0000-00-00'
				group by sub_reg_nt
				order by sub_reg_nt) c
				on codigo = c.sub_reg_nt
				group by a.nombre
				";
			}else{
				$this->session->set_flashdata('error', 'Debe elegir alg&uacute;n nivel de proceso, este reporte no est&aacute; activo para su nivel de usuario, comun&iacute;quese a notificacion@dge.gob.pe');
				redirect(site_url("reportes/repIndividual"), 301);
			}
		}
		
		$query = $this->db->query($plantilla);
		
		return $query->result();
		
	}

	//Reporte de la notificación de las Edas en descripción de tiempo por nivel de ubigeo
	
	public function notificacionEdaTiempoUbigeo($anio, $departamento, $provincia, $distrito)
	{
		if(!empty($departamento) and !empty($provincia) and !empty($distrito)){
			$plantilla = "
			select a.semana,
			a.casos as casos_1,
			a.poblacion as pob_1,
			round((a.casos / a.poblacion) * 100000,2) as inc_1,
			if(a.semana=d.semana, d.defuncion, 0) as def_1,
			round((if(a.semana=d.semana, d.defuncion, 0) / a.poblacion * 1000),2) as mort_1,
			round((if(a.semana=d.semana, d.defuncion, 0) / a.casos * 100),2) as letal_1,
			b.casos as casos_2,
			b.poblacion as pob_2,
			round((b.casos / b.poblacion) * 100000,2) as inc_2,
			if(a.semana=e.semana, e.defuncion, 0) as def_2,
			round((if(a.semana=e.semana, e.defuncion, 0) / b.poblacion * 1000),2) as mort_2,
			round((if(a.semana=e.semana, e.defuncion, 0) / b.casos * 100),2) as letal_2,
			ifnull(c.casos,0) as casos_3,
			ifnull(c.poblacion,0) as pob_3,
			ifnull(round((c.casos / c.poblacion) * 100000,2),0) as inc_3,
			ifnull(if(a.semana=f.semana, f.defuncion, 0),0) as def_3,
			round((if(a.semana=f.semana, f.defuncion, 0) / c.poblacion * 1000),2) as mort_3,
			round((if(a.semana=f.semana, f.defuncion, 0) / c.casos * 100),2) as letal_3
			from
			(select ano, semana, sum(daa_c1+daa_c1_4+daa_c5+dis_c1+dis_c1_4+dis_c5) as casos,
			(select sum(pobtot) from codubi where ano = $anio-2) as poblacion from edas_ant
			where ano = $anio-2 and ubigeo = '".$distrito."' group by ano, semana) a
			left join
			(select ano, semana, sum(daa_c1+daa_c1_4+daa_c5+dis_c1+dis_c1_4+dis_c5) as casos, (select sum(pobtot) 
			from codubi where ano = $anio-1) as poblacion from edas_ant
			where ano = $anio-1 and ubigeo = '".$distrito."' group by ano, semana) b
			on a.semana = b.semana
			left join
			(select ano, semana, sum(daa_c1+daa_c1_4+daa_c5+dis_c1+dis_c1_4+dis_c5) as casos, (select sum(pobtot) 
			from codubi where ano = $anio) as poblacion from edas
			where ano = $anio and ubigeo = '".$distrito."' group by ano, semana) c
			on a.semana = c.semana
			left join
			(select ano, semana, sum(daa_d1+daa_d1_4+daa_d5+dis_d1+dis_d1_4+dis_d5) as defuncion from edas_ant
			where ano = $anio-2 and ubigeo = '".$distrito."' group by ano, semana) d
			on a.semana = d.semana
			left join
			(select ano, semana, sum(daa_d1+daa_d1_4+daa_d5+dis_d1+dis_d1_4+dis_d5) as defuncion from edas_ant
			where ano = $anio-1 and ubigeo = '".$distrito."' group by ano, semana) e
			on a.semana = e.semana
			left join
			(select ano, semana, sum(daa_d1+daa_d1_4+daa_d5+dis_d1+dis_d1_4+dis_d5) as defuncion from edas
			where ano = $anio and ubigeo = '".$distrito."' group by ano, semana) f
			on a.semana = f.semana
			group by a.semana			
			";
		}elseif(!empty($departamento) and !empty($provincia) and empty($distrito)){
			$plantilla = "
			select a.semana,
			a.casos as casos_1,
			a.poblacion as pob_1,
			round((a.casos / a.poblacion) * 100000,2) as inc_1,
			if(a.semana=d.semana, d.defuncion, 0) as def_1,
			round((if(a.semana=d.semana, d.defuncion, 0) / a.poblacion * 1000),2) as mort_1,
			round((if(a.semana=d.semana, d.defuncion, 0) / a.casos * 100),2) as letal_1,
			b.casos as casos_2,
			b.poblacion as pob_2,
			round((b.casos / b.poblacion) * 100000,2) as inc_2,
			if(a.semana=e.semana, e.defuncion, 0) as def_2,
			round((if(a.semana=e.semana, e.defuncion, 0) / b.poblacion * 1000),2) as mort_2,
			round((if(a.semana=e.semana, e.defuncion, 0) / b.casos * 100),2) as letal_2,
			ifnull(c.casos,0) as casos_3,
			ifnull(c.poblacion,0) as pob_3,
			ifnull(round((c.casos / c.poblacion) * 100000,2),0) as inc_3,
			ifnull(if(a.semana=f.semana, f.defuncion, 0),0) as def_3,
			round((if(a.semana=f.semana, f.defuncion, 0) / c.poblacion * 1000),2) as mort_3,
			round((if(a.semana=f.semana, f.defuncion, 0) / c.casos * 100),2) as letal_3
			from
			(select ano, semana, sum(daa_c1+daa_c1_4+daa_c5+dis_c1+dis_c1_4+dis_c5) as casos,
			(select sum(pobtot) from codubi where ano = $anio-2) as poblacion from edas_ant
			where ano = $anio-2 and substr(ubigeo,1,4) = '".$provincia."' group by ano, semana) a
			left join
			(select ano, semana, sum(daa_c1+daa_c1_4+daa_c5+dis_c1+dis_c1_4+dis_c5) as casos, (select sum(pobtot) 
			from codubi where ano = $anio-1) as poblacion from edas_ant
			where ano = $anio-1 and substr(ubigeo,1,4) = '".$provincia."' group by ano, semana) b
			on a.semana = b.semana
			left join
			(select ano, semana, sum(daa_c1+daa_c1_4+daa_c5+dis_c1+dis_c1_4+dis_c5) as casos, (select sum(pobtot) 
			from codubi where ano = $anio) as poblacion from edas
			where ano = $anio and substr(ubigeo,1,4) = '".$provincia."' group by ano, semana) c
			on a.semana = c.semana
			left join
			(select ano, semana, sum(daa_d1+daa_d1_4+daa_d5+dis_d1+dis_d1_4+dis_d5) as defuncion from edas_ant
			where ano = $anio-2 and substr(ubigeo,1,4) = '".$provincia."' group by ano, semana) d
			on a.semana = d.semana
			left join
			(select ano, semana, sum(daa_d1+daa_d1_4+daa_d5+dis_d1+dis_d1_4+dis_d5) as defuncion from edas_ant
			where ano = $anio-1 and substr(ubigeo,1,4) = '".$provincia."' group by ano, semana) e
			on a.semana = e.semana
			left join
			(select ano, semana, sum(daa_d1+daa_d1_4+daa_d5+dis_d1+dis_d1_4+dis_d5) as defuncion from edas
			where ano = $anio and substr(ubigeo,1,4) = '".$provincia."' group by ano, semana) f
			on a.semana = f.semana
			group by a.semana			
			";
		}elseif(!empty($departamento) and empty($provincia) and empty($distrito)){
			$plantilla = "
			select a.semana,
			a.casos as casos_1,
			a.poblacion as pob_1,
			round((a.casos / a.poblacion) * 100000,2) as inc_1,
			if(a.semana=d.semana, d.defuncion, 0) as def_1,
			round((if(a.semana=d.semana, d.defuncion, 0) / a.poblacion * 1000),2) as mort_1,
			round((if(a.semana=d.semana, d.defuncion, 0) / a.casos * 100),2) as letal_1,
			b.casos as casos_2,
			b.poblacion as pob_2,
			round((b.casos / b.poblacion) * 100000,2) as inc_2,
			if(a.semana=e.semana, e.defuncion, 0) as def_2,
			round((if(a.semana=e.semana, e.defuncion, 0) / b.poblacion * 1000),2) as mort_2,
			round((if(a.semana=e.semana, e.defuncion, 0) / b.casos * 100),2) as letal_2,
			ifnull(c.casos,0) as casos_3,
			ifnull(c.poblacion,0) as pob_3,
			ifnull(round((c.casos / c.poblacion) * 100000,2),0) as inc_3,
			ifnull(if(a.semana=f.semana, f.defuncion, 0),0) as def_3,
			round((if(a.semana=f.semana, f.defuncion, 0) / c.poblacion * 1000),2) as mort_3,
			round((if(a.semana=f.semana, f.defuncion, 0) / c.casos * 100),2) as letal_3
			from
			(select ano, semana, sum(daa_c1+daa_c1_4+daa_c5+dis_c1+dis_c1_4+dis_c5) as casos,
			(select sum(pobtot) from codubi where ano = $anio-2) as poblacion from edas_ant
			where ano = $anio-2 and substr(ubigeo,1,2) = '".$departamento."' group by ano, semana) a
			left join
			(select ano, semana, sum(daa_c1+daa_c1_4+daa_c5+dis_c1+dis_c1_4+dis_c5) as casos, (select sum(pobtot) 
			from codubi where ano = $anio-1) as poblacion from edas_ant
			where ano = $anio-1 and substr(ubigeo,1,2) = '".$departamento."' 
			group by ano, semana) b
			on a.semana = b.semana
			left join
			(select ano, semana, sum(daa_c1+daa_c1_4+daa_c5+dis_c1+dis_c1_4+dis_c5) as casos, (select sum(pobtot) 
			from codubi where ano = $anio) as poblacion from edas
			where ano = $anio and substr(ubigeo,1,2) = '".$departamento."'
			group by ano, semana) c
			on a.semana = c.semana
			left join
			(select ano, semana, sum(daa_d1+daa_d1_4+daa_d5+dis_d1+dis_d1_4+dis_d5) as defuncion from edas_ant
			where ano = $anio-2 and substr(ubigeo,1,2) = '".$departamento."' group by ano, semana) d
			on a.semana = d.semana
			left join
			(select ano, semana, sum(daa_d1+daa_d1_4+daa_d5+dis_d1+dis_d1_4+dis_d5) as defuncion from edas_ant
			where ano = $anio-1 and substr(ubigeo,1,2) = '".$departamento."' 
			group by ano, semana) e
			on a.semana = e.semana
			left join
			(select ano, semana, sum(daa_d1+daa_d1_4+daa_d5+dis_d1+dis_d1_4+dis_d5) as defuncion from edas
			where ano = $anio and substr(ubigeo,1,2) = '".$departamento."' group by ano, semana) f
			on a.semana = f.semana
			group by a.semana			
			";
		}elseif(empty($departamento) and empty($provincia) and empty($distrito)){
			if($this->session->userdata('nivel') == '1' or $this->session->userdata('nivel') == '4'){
				$plantilla = "
				select a.semana,
				a.casos as casos_1,
				a.poblacion as pob_1,
				round((a.casos / a.poblacion) * 100000,2) as inc_1,
				if(a.semana=d.semana, d.defuncion, 0) as def_1,
				round((if(a.semana=d.semana, d.defuncion, 0) / a.poblacion * 1000),2) as mort_1,
				round((if(a.semana=d.semana, d.defuncion, 0) / a.casos * 100),2) as letal_1,
				b.casos as casos_2,
				b.poblacion as pob_2,
				round((b.casos / b.poblacion) * 100000,2) as inc_2,
				if(a.semana=e.semana, e.defuncion, 0) as def_2,
				round((if(a.semana=e.semana, e.defuncion, 0) / b.poblacion * 1000),2) as mort_2,
				round((if(a.semana=e.semana, e.defuncion, 0) / b.casos * 100),2) as letal_2,
				ifnull(c.casos,0) as casos_3,
				ifnull(c.poblacion,0) as pob_3,
				ifnull(round((c.casos / c.poblacion) * 100000,2),0) as inc_3,
				ifnull(if(a.semana=f.semana, f.defuncion, 0),0) as def_3,
				round((if(a.semana=f.semana, f.defuncion, 0) / c.poblacion * 1000),2) as mort_3,
				round((if(a.semana=f.semana, f.defuncion, 0) / c.casos * 100),2) as letal_3
				from
				(select ano, semana, sum(daa_c1+daa_c1_4+daa_c5+dis_c1+dis_c1_4+dis_c5) as casos,
				(select sum(pobtot) from codubi where ano = $anio-2) as poblacion from edas_ant
				where ano = $anio-2 group by ano, semana) a
				left join
				(select ano, semana, sum(daa_c1+daa_c1_4+daa_c5+dis_c1+dis_c1_4+dis_c5) as casos, 
				(select sum(pobtot) from codubi where ano = $anio-1) as poblacion from edas_ant
				where ano = $anio-1 group by ano, semana) b
				on a.semana = b.semana
				left join
				(select ano, semana, sum(daa_c1+daa_c1_4+daa_c5+dis_c1+dis_c1_4+dis_c5) as casos, 
				(select sum(pobtot) from codubi where ano = $anio) as poblacion from edas
				where ano = $anio group by ano, semana) c
				on a.semana = c.semana
				left join
				(select ano, semana, sum(daa_d1+daa_d1_4+daa_d5+dis_d1+dis_d1_4+dis_d5) as defuncion from edas_ant
				where ano = $anio-2  
				group by ano, semana) d
				on a.semana = d.semana
				left join
				(select ano, semana, sum(daa_d1+daa_d1_4+daa_d5+dis_d1+dis_d1_4+dis_d5) as defuncion from edas_ant
				where ano = $anio-1  
				group by ano, semana) e
				on a.semana = e.semana
				left join
				(select ano, semana, sum(daa_d1+daa_d1_4+daa_d5+dis_d1+dis_d1_4+dis_d5) as defuncion from edas
				where ano = $anio group by ano, semana) f
				on a.semana = f.semana
				group by a.semana			
				";
			}else{
				$this->session->set_flashdata('error', 'Debe elegir alg&uacute;n nivel de proceso, este reporte no est&aacute; activo para su nivel de usuario, comun&iacute;quese a notificacion@dge.gob.pe');
				redirect(site_url("reportes/repEdas"), 301);
			}
		}
		
		$query = $this->db->query($plantilla);
		
		return $query->result();
		
	}

	//Reporte de la notificación de las EDAS en descripción de tiempo por nivel de Establecimiento de salud
	
	public function notificacionEdaTiempoEESS($anio, $diresa, $red, $microred, $establec)
	{
		if(!empty($diresa) and !empty($red) and !empty($microred) and !empty($establec)){
			$plantilla = "
			select a.semana,
			a.casos as casos_1,
			a.poblacion as pob_1,
			round((a.casos / a.poblacion) * 100000,2) as inc_1,
			if(a.semana=d.semana, d.defuncion, 0) as def_1,
			round((if(a.semana=d.semana, d.defuncion, 0) / a.poblacion * 1000),2) as mort_1,
			round((if(a.semana=d.semana, d.defuncion, 0) / a.casos * 100),2) as letal_1,
			b.casos as casos_2,
			b.poblacion as pob_2,
			round((b.casos / b.poblacion) * 100000,2) as inc_2,
			if(a.semana=e.semana, e.defuncion, 0) as def_2,
			round((if(a.semana=e.semana, e.defuncion, 0) / b.poblacion * 1000),2) as mort_2,
			round((if(a.semana=e.semana, e.defuncion, 0) / b.casos * 100),2) as letal_2,
			ifnull(c.casos,0) as casos_3,
			ifnull(c.poblacion,0) as pob_3,
			ifnull(round((c.casos / c.poblacion) * 100000,2),0) as inc_3,
			ifnull(if(a.semana=f.semana, f.defuncion, 0),0) as def_3,
			round((if(a.semana=f.semana, f.defuncion, 0) / c.poblacion * 1000),2) as mort_3,
			round((if(a.semana=f.semana, f.defuncion, 0) / c.casos * 100),2) as letal_3
			from
			(select ano, semana, sum(daa_c1+daa_c1_4+daa_c5+dis_c1+dis_c1_4+dis_c5) as casos,
			(select sum(pobtot) from codubi where ano = $anio-2) as poblacion from edas_ant
			where ano = $anio-2 and e_salud = '".$establec."' group by ano, semana) a
			left join
			(select ano, semana, sum(daa_c1+daa_c1_4+daa_c5+dis_c1+dis_c1_4+dis_c5) as casos, (select sum(pobtot) 
			from codubi where ano = $anio-1) as poblacion from edas_ant
			where ano = $anio-1 and e_salud = '".$establec."' group by ano, semana) b
			on a.semana = b.semana
			left join
			(select ano, semana, sum(daa_c1+daa_c1_4+daa_c5+dis_c1+dis_c1_4+dis_c5) as casos, (select sum(pobtot) 
			from codubi where ano = $anio) as poblacion from edas
			where ano = $anio and e_salud = '".$establec."' group by ano, semana) c
			on a.semana = c.semana
			left join
			(select ano, semana,  sum(daa_d1+daa_d1_4+daa_d5+dis_d1+dis_d1_4+dis_d5) as defuncion from edas_ant
			where ano = $anio-2 and e_salud = '".$establec."' group by ano, semana) d
			on a.semana = d.semana
			left join
			(select ano, semana,  sum(daa_d1+daa_d1_4+daa_d5+dis_d1+dis_d1_4+dis_d5) as defuncion from edas_ant
			where ano = $anio-1 and e_salud = '".$establec."' group by ano, semana) e
			on a.semana = e.semana
			left join
			(select ano, semana,  sum(daa_d1+daa_d1_4+daa_d5+dis_d1+dis_d1_4+dis_d5) as defuncion from edas
			where ano = $anio and e_salud = '".$establec."' group by ano, semana) f
			on a.semana = f.semana
			group by a.semana			
			";
		}elseif(!empty($diresa) and !empty($red) and !empty($microred) and empty($establec)){
			$plantilla = "
			select a.semana,
			a.casos as casos_1,
			a.poblacion as pob_1,
			round((a.casos / a.poblacion) * 100000,2) as inc_1,
			if(a.semana=d.semana, d.defuncion, 0) as def_1,
			round((if(a.semana=d.semana, d.defuncion, 0) / a.poblacion * 1000),2) as mort_1,
			round((if(a.semana=d.semana, d.defuncion, 0) / a.casos * 100),2) as letal_1,
			b.casos as casos_2,
			b.poblacion as pob_2,
			round((b.casos / b.poblacion) * 100000,2) as inc_2,
			if(a.semana=e.semana, e.defuncion, 0) as def_2,
			round((if(a.semana=e.semana, e.defuncion, 0) / b.poblacion * 1000),2) as mort_2,
			round((if(a.semana=e.semana, e.defuncion, 0) / b.casos * 100),2) as letal_2,
			ifnull(c.casos,0) as casos_3,
			ifnull(c.poblacion,0) as pob_3,
			ifnull(round((c.casos / c.poblacion) * 100000,2),0) as inc_3,
			ifnull(if(a.semana=f.semana, f.defuncion, 0),0) as def_3,
			round((if(a.semana=f.semana, f.defuncion, 0) / c.poblacion * 1000),2) as mort_3,
			round((if(a.semana=f.semana, f.defuncion, 0) / c.casos * 100),2) as letal_3
			from
			(select ano, semana, sum(daa_c1+daa_c1_4+daa_c5+dis_c1+dis_c1_4+dis_c5) as casos,
			(select sum(pobtot) from codubi where ano = $anio-2) as poblacion from edas_ant
			where ano = $anio-2 and sub_reg_nt = '".$diresa."' and red = '".$red."' and microred = '".$microred."' 
			group by ano, semana) a
			left join
			(select ano, semana, sum(daa_c1+daa_c1_4+daa_c5+dis_c1+dis_c1_4+dis_c5) as casos, (select sum(pobtot) 
			from codubi where ano = $anio-1) as poblacion from edas_ant
			where ano = $anio-1 and sub_reg_nt = '".$diresa."' and red = '".$red."' and microred = '".$microred."' 
			group by ano, semana) b
			on a.semana = b.semana
			left join
			(select ano, semana, sum(daa_c1+daa_c1_4+daa_c5+dis_c1+dis_c1_4+dis_c5) as casos, (select sum(pobtot) 
			from codubi where ano = $anio) as poblacion from edas
			where ano = $anio and sub_reg_nt = '".$diresa."' and red = '".$red."' and microred = '".$microred."' 
			group by ano, semana) c
			on a.semana = c.semana
			left join
			(select ano, semana, sum(daa_d1+daa_d1_4+daa_d5+dis_d1+dis_d1_4+dis_d5) as defuncion from edas_ant
			where ano = $anio-2 and sub_reg_nt = '".$diresa."' and red = '".$red."' and microred = '".$microred."' group by ano, semana) d
			on a.semana = d.semana
			left join
			(select ano, semana, sum(daa_d1+daa_d1_4+daa_d5+dis_d1+dis_d1_4+dis_d5) as defuncion from edas_ant
			where ano = $anio-1 and sub_reg_nt = '".$diresa."' and red = '".$red."' and microred = '".$microred."' group by ano, semana) e
			on a.semana = e.semana
			left join
			(select ano, semana, sum(daa_d1+daa_d1_4+daa_d5+dis_d1+dis_d1_4+dis_d5) as defuncion from edas
			where ano = $anio and sub_reg_nt = '".$diresa."' and red = '".$red."' and microred = '".$microred."' group by ano, semana) f
			on a.semana = f.semana
			group by a.semana			
			";
		}elseif(!empty($diresa) and !empty($red) and empty($microred) and empty($establec)){
			$plantilla = "
			select a.semana,
			a.casos as casos_1,
			a.poblacion as pob_1,
			round((a.casos / a.poblacion) * 100000,2) as inc_1,
			if(a.semana=d.semana, d.defuncion, 0) as def_1,
			round((if(a.semana=d.semana, d.defuncion, 0) / a.poblacion * 1000),2) as mort_1,
			round((if(a.semana=d.semana, d.defuncion, 0) / a.casos * 100),2) as letal_1,
			b.casos as casos_2,
			b.poblacion as pob_2,
			round((b.casos / b.poblacion) * 100000,2) as inc_2,
			if(a.semana=e.semana, e.defuncion, 0) as def_2,
			round((if(a.semana=e.semana, e.defuncion, 0) / b.poblacion * 1000),2) as mort_2,
			round((if(a.semana=e.semana, e.defuncion, 0) / b.casos * 100),2) as letal_2,
			ifnull(c.casos,0) as casos_3,
			ifnull(c.poblacion,0) as pob_3,
			ifnull(round((c.casos / c.poblacion) * 100000,2),0) as inc_3,
			ifnull(if(a.semana=f.semana, f.defuncion, 0),0) as def_3,
			round((if(a.semana=f.semana, f.defuncion, 0) / c.poblacion * 1000),2) as mort_3,
			round((if(a.semana=f.semana, f.defuncion, 0) / c.casos * 100),2) as letal_3
			from
			(select ano, semana, sum(daa_c1+daa_c1_4+daa_c5+dis_c1+dis_c1_4+dis_c5) as casos,
			(select sum(pobtot) from codubi where ano = $anio-2) as poblacion from edas_ant
			where ano = $anio-2 and sub_reg_nt = '".$diresa."' and red = '".$red."' 
			group by ano, semana) a
			left join
			(select ano, semana, sum(daa_c1+daa_c1_4+daa_c5+dis_c1+dis_c1_4+dis_c5) as casos, (select sum(pobtot) 
			from codubi where ano = $anio-1) as poblacion from edas_ant
			where ano = $anio-1 and sub_reg_nt = '".$diresa."' and red = '".$red."'  
			group by ano, semana) b
			on a.semana = b.semana
			left join
			(select ano, semana, sum(daa_c1+daa_c1_4+daa_c5+dis_c1+dis_c1_4+dis_c5) as casos, (select sum(pobtot) 
			from codubi where ano = $anio) as poblacion from edas
			where ano = $anio and sub_reg_nt = '".$diresa."' and red = '".$red."' 
			group by ano, semana) c
			on a.semana = c.semana
			left join
			(select ano, semana, sum(daa_d1+daa_d1_4+daa_d5+dis_d1+dis_d1_4+dis_d5) as defuncion from edas_ant
			where ano = $anio-2 and sub_reg_nt = '".$diresa."' and red = '".$red."' group by ano, semana) d
			on a.semana = d.semana
			left join
			(select ano, semana, sum(daa_d1+daa_d1_4+daa_d5+dis_d1+dis_d1_4+dis_d5) as defuncion from edas_ant
			where ano = $anio-1 and sub_reg_nt = '".$diresa."' and red = '".$red."'
			group by ano, semana) e
			on a.semana = e.semana
			left join
			(select ano, semana, sum(daa_d1+daa_d1_4+daa_d5+dis_d1+dis_d1_4+dis_d5) as defuncion from edas
			where ano = $anio and sub_reg_nt = '".$diresa."' and red = '".$red."' group by ano, semana) f
			on a.semana = f.semana
			group by a.semana			
			";
		}elseif(!empty($diresa) and empty($red) and empty($microred) and empty($establec)){
			$plantilla = "
			select a.semana,
			a.casos as casos_1,
			a.poblacion as pob_1,
			round((a.casos / a.poblacion) * 100000,2) as inc_1,
			if(a.semana=d.semana, d.defuncion, 0) as def_1,
			round((if(a.semana=d.semana, d.defuncion, 0) / a.poblacion * 1000),2) as mort_1,
			round((if(a.semana=d.semana, d.defuncion, 0) / a.casos * 100),2) as letal_1,
			b.casos as casos_2,
			b.poblacion as pob_2,
			round((b.casos / b.poblacion) * 100000,2) as inc_2,
			if(a.semana=e.semana, e.defuncion, 0) as def_2,
			round((if(a.semana=e.semana, e.defuncion, 0) / b.poblacion * 1000),2) as mort_2,
			round((if(a.semana=e.semana, e.defuncion, 0) / b.casos * 100),2) as letal_2,
			ifnull(c.casos,0) as casos_3,
			ifnull(c.poblacion,0) as pob_3,
			ifnull(round((c.casos / c.poblacion) * 100000,2),0) as inc_3,
			ifnull(if(a.semana=f.semana, f.defuncion, 0),0) as def_3,
			round((if(a.semana=f.semana, f.defuncion, 0) / c.poblacion * 1000),2) as mort_3,
			round((if(a.semana=f.semana, f.defuncion, 0) / c.casos * 100),2) as letal_3
			from
			(select ano, semana, sum(daa_c1+daa_c1_4+daa_c5+dis_c1+dis_c1_4+dis_c5) as casos,
			(select sum(pobtot) from codubi where ano = $anio-2) as poblacion from edas_ant
			where ano = $anio-2 and sub_reg_nt = '".$diresa."' 
			group by ano, semana) a
			left join
			(select ano, semana, sum(daa_c1+daa_c1_4+daa_c5+dis_c1+dis_c1_4+dis_c5) as casos, (select sum(pobtot) 
			from codubi where ano = $anio-1) as poblacion from edas_ant
			where ano = $anio-1 and sub_reg_nt = '".$diresa."' 
			group by ano, semana) b
			on a.semana = b.semana
			left join
			(select ano, semana, sum(daa_c1+daa_c1_4+daa_c5+dis_c1+dis_c1_4+dis_c5) as casos, (select sum(pobtot) 
			from codubi where ano = $anio) as poblacion from edas
			where ano = $anio and sub_reg_nt = '".$diresa."'
			group by ano, semana) c
			on a.semana = c.semana
			left join
			(select ano, semana, sum(daa_d1+daa_d1_4+daa_d5+dis_d1+dis_d1_4+dis_d5) as defuncion from edas_ant
			where ano = $anio-2 and sub_reg_nt = '".$diresa."' group by ano, semana) d
			on a.semana = d.semana
			left join
			(select ano, semana, sum(daa_d1+daa_d1_4+daa_d5+dis_d1+dis_d1_4+dis_d5) as defuncion from edas_ant
			where ano = $anio-1 and sub_reg_nt = '".$diresa."'
			group by ano, semana) e
			on a.semana = e.semana
			left join
			(select ano, semana, sum(daa_d1+daa_d1_4+daa_d5+dis_d1+dis_d1_4+dis_d5) as defuncion from edas
			where ano = $anio and sub_reg_nt = '".$diresa."' group by ano, semana) f
			on a.semana = f.semana
			group by a.semana			
			";
		}elseif(empty($diresa) and empty($red) and empty($microred) and empty($establec)){
			$plantilla = "
			select a.semana,
			a.casos as casos_1,
			a.poblacion as pob_1,
			round((a.casos / a.poblacion) * 100000,2) as inc_1,
			if(a.semana=d.semana, d.defuncion, 0) as def_1,
			round((if(a.semana=d.semana, d.defuncion, 0) / a.poblacion * 1000),2) as mort_1,
			round((if(a.semana=d.semana, d.defuncion, 0) / a.casos * 100),2) as letal_1,
			b.casos as casos_2,
			b.poblacion as pob_2,
			round((b.casos / b.poblacion) * 100000,2) as inc_2,
			if(a.semana=e.semana, e.defuncion, 0) as def_2,
			round((if(a.semana=e.semana, e.defuncion, 0) / b.poblacion * 1000),2) as mort_2,
			round((if(a.semana=e.semana, e.defuncion, 0) / b.casos * 100),2) as letal_2,
			ifnull(c.casos,0) as casos_3,
			ifnull(c.poblacion,0) as pob_3,
			ifnull(round((c.casos / c.poblacion) * 100000,2),0) as inc_3,
			ifnull(if(a.semana=f.semana, f.defuncion, 0),0) as def_3,
			round((if(a.semana=f.semana, f.defuncion, 0) / c.poblacion * 1000),2) as mort_3,
			round((if(a.semana=f.semana, f.defuncion, 0) / c.casos * 100),2) as letal_3
			from
			(select ano, semana, sum(daa_c1+daa_c1_4+daa_c5+dis_c1+dis_c1_4+dis_c5) as casos,
			(select sum(pobtot) from codubi where ano = $anio-2) as poblacion from edas_ant
			where ano = $anio-2 group by ano, semana) a
			left join
			(select ano, semana, sum(daa_c1+daa_c1_4+daa_c5+dis_c1+dis_c1_4+dis_c5) as casos, 
			(select sum(pobtot) from codubi where ano = $anio-1) as poblacion from edas_ant
			where ano = $anio-1 group by ano, semana) b
			on a.semana = b.semana
			left join
			(select ano, semana, sum(daa_c1+daa_c1_4+daa_c5+dis_c1+dis_c1_4+dis_c5) as casos, 
			(select sum(pobtot) from codubi where ano = $anio) as poblacion from edas
			where ano = $anio group by ano, semana) c
			on a.semana = c.semana
			left join
			(select ano, semana, sum(daa_d1+daa_d1_4+daa_d5+dis_d1+dis_d1_4+dis_d5) as defuncion from edas_ant
			where ano = $anio-2 group by ano, semana) d
			on a.semana = d.semana
			left join
			(select ano, semana, sum(daa_d1+daa_d1_4+daa_d5+dis_d1+dis_d1_4+dis_d5) as defuncion from edas_ant
			where ano = $anio-1 group by ano, semana) e
			on a.semana = e.semana
			left join
			(select ano, semana, sum(daa_d1+daa_d1_4+daa_d5+dis_d1+dis_d1_4+dis_d5) as defuncion from edas
			where ano = $anio group by ano, semana) f
			on a.semana = f.semana
			group by a.semana			
			";
		}
		
		$query = $this->db->query($plantilla);
		
		return $query->result();
		
	}

	//Reporte de la notificación de EDAS en descripción de espacio por nivel de ubigeo
	public function notificacionEdaEspacioUbigeo($anio, $departamento, $provincia, $distrito)
	{
		if(!empty($departamento) and !empty($provincia) and !empty($distrito)){
			$plantilla = "
			select b.distrito as nombre,
			ifnull(sum(if(a.semana = 1, a.cantidad, 0)),0) as sem1,
			ifnull(sum(if(a.semana = 2, a.cantidad, 0)),0) as sem2,
			ifnull(sum(if(a.semana = 3, a.cantidad, 0)),0) as sem3,
			ifnull(sum(if(a.semana = 4, a.cantidad, 0)),0) as sem4,
			ifnull(sum(if(a.semana = 5, a.cantidad, 0)),0) as sem5,
			ifnull(sum(if(a.semana = 6, a.cantidad, 0)),0) as sem6,
			ifnull(sum(if(a.semana = 7, a.cantidad, 0)),0) as sem7,
			ifnull(sum(if(a.semana = 8, a.cantidad, 0)),0) as sem8,
			ifnull(sum(if(a.semana = 9, a.cantidad, 0)),0) as sem9,
			ifnull(sum(if(a.semana = 10, a.cantidad, 0)),0) as sem10,
			ifnull(sum(if(a.semana = 11, a.cantidad, 0)),0) as sem11,
			ifnull(sum(if(a.semana = 12, a.cantidad, 0)),0) as sem12,
			ifnull(sum(if(a.semana = 13, a.cantidad, 0)),0) as sem13,
			ifnull(sum(if(a.semana = 14, a.cantidad, 0)),0) as sem14,
			ifnull(sum(if(a.semana = 15, a.cantidad, 0)),0) as sem15,
			ifnull(sum(if(a.semana = 16, a.cantidad, 0)),0) as sem16,
			ifnull(sum(if(a.semana = 17, a.cantidad, 0)),0) as sem17,
			ifnull(sum(if(a.semana = 18, a.cantidad, 0)),0) as sem18,
			ifnull(sum(if(a.semana = 19, a.cantidad, 0)),0) as sem19,
			ifnull(sum(if(a.semana = 20, a.cantidad, 0)),0) as sem20,
			ifnull(sum(if(a.semana = 21, a.cantidad, 0)),0) as sem21,
			ifnull(sum(if(a.semana = 22, a.cantidad, 0)),0) as sem22,
			ifnull(sum(if(a.semana = 23, a.cantidad, 0)),0) as sem23,
			ifnull(sum(if(a.semana = 24, a.cantidad, 0)),0) as sem24,
			ifnull(sum(if(a.semana = 25, a.cantidad, 0)),0) as sem25,
			ifnull(sum(if(a.semana = 26, a.cantidad, 0)),0) as sem26,
			ifnull(sum(if(a.semana = 27, a.cantidad, 0)),0) as sem27,
			ifnull(sum(if(a.semana = 28, a.cantidad, 0)),0) as sem28,
			ifnull(sum(if(a.semana = 29, a.cantidad, 0)),0) as sem29,
			ifnull(sum(if(a.semana = 30, a.cantidad, 0)),0) as sem30,
			ifnull(sum(if(a.semana = 31, a.cantidad, 0)),0) as sem31,
			ifnull(sum(if(a.semana = 32, a.cantidad, 0)),0) as sem32,
			ifnull(sum(if(a.semana = 33, a.cantidad, 0)),0) as sem33,
			ifnull(sum(if(a.semana = 34, a.cantidad, 0)),0) as sem34,
			ifnull(sum(if(a.semana = 35, a.cantidad, 0)),0) as sem35,
			ifnull(sum(if(a.semana = 36, a.cantidad, 0)),0) as sem36,
			ifnull(sum(if(a.semana = 37, a.cantidad, 0)),0) as sem37,
			ifnull(sum(if(a.semana = 38, a.cantidad, 0)),0) as sem38,
			ifnull(sum(if(a.semana = 39, a.cantidad, 0)),0) as sem39,
			ifnull(sum(if(a.semana = 40, a.cantidad, 0)),0) as sem40,
			ifnull(sum(if(a.semana = 41, a.cantidad, 0)),0) as sem41,
			ifnull(sum(if(a.semana = 42, a.cantidad, 0)),0) as sem42,
			ifnull(sum(if(a.semana = 43, a.cantidad, 0)),0) as sem43,
			ifnull(sum(if(a.semana = 44, a.cantidad, 0)),0) as sem44,
			ifnull(sum(if(a.semana = 45, a.cantidad, 0)),0) as sem45,
			ifnull(sum(if(a.semana = 46, a.cantidad, 0)),0) as sem46,
			ifnull(sum(if(a.semana = 47, a.cantidad, 0)),0) as sem47,
			ifnull(sum(if(a.semana = 48, a.cantidad, 0)),0) as sem48,
			ifnull(sum(if(a.semana = 49, a.cantidad, 0)),0) as sem49,
			ifnull(sum(if(a.semana = 50, a.cantidad, 0)),0) as sem50,
			ifnull(sum(if(a.semana = 51, a.cantidad, 0)),0) as sem51,
			ifnull(sum(if(a.semana = 52, a.cantidad, 0)),0) as sem52,
			ifnull(sum(if(a.semana = 53, a.cantidad, 0)),0) as sem53
			from
			codubi b
			left join
			(select ubigeo, semana, sum(daa_c1+daa_c1_4+daa_c5+dis_c1+dis_c1_4+dis_c5) as cantidad from edas 
			where ano = $anio and ubigeo = '".$distrito."' and ubigeo <> '' 
			group by ubigeo, semana) a
			on b.ubigeo = a.ubigeo
			where b.ano = $anio and a.ubigeo = '".$distrito."' 
			group by b.distrito
			";
		}elseif(!empty($departamento) and !empty($provincia) and empty($distrito)){
			$plantilla = "
			select b.distrito as nombre,
			ifnull(sum(if(a.semana = 1, a.cantidad, 0)),0) as sem1,
			ifnull(sum(if(a.semana = 2, a.cantidad, 0)),0) as sem2,
			ifnull(sum(if(a.semana = 3, a.cantidad, 0)),0) as sem3,
			ifnull(sum(if(a.semana = 4, a.cantidad, 0)),0) as sem4,
			ifnull(sum(if(a.semana = 5, a.cantidad, 0)),0) as sem5,
			ifnull(sum(if(a.semana = 6, a.cantidad, 0)),0) as sem6,
			ifnull(sum(if(a.semana = 7, a.cantidad, 0)),0) as sem7,
			ifnull(sum(if(a.semana = 8, a.cantidad, 0)),0) as sem8,
			ifnull(sum(if(a.semana = 9, a.cantidad, 0)),0) as sem9,
			ifnull(sum(if(a.semana = 10, a.cantidad, 0)),0) as sem10,
			ifnull(sum(if(a.semana = 11, a.cantidad, 0)),0) as sem11,
			ifnull(sum(if(a.semana = 12, a.cantidad, 0)),0) as sem12,
			ifnull(sum(if(a.semana = 13, a.cantidad, 0)),0) as sem13,
			ifnull(sum(if(a.semana = 14, a.cantidad, 0)),0) as sem14,
			ifnull(sum(if(a.semana = 15, a.cantidad, 0)),0) as sem15,
			ifnull(sum(if(a.semana = 16, a.cantidad, 0)),0) as sem16,
			ifnull(sum(if(a.semana = 17, a.cantidad, 0)),0) as sem17,
			ifnull(sum(if(a.semana = 18, a.cantidad, 0)),0) as sem18,
			ifnull(sum(if(a.semana = 19, a.cantidad, 0)),0) as sem19,
			ifnull(sum(if(a.semana = 20, a.cantidad, 0)),0) as sem20,
			ifnull(sum(if(a.semana = 21, a.cantidad, 0)),0) as sem21,
			ifnull(sum(if(a.semana = 22, a.cantidad, 0)),0) as sem22,
			ifnull(sum(if(a.semana = 23, a.cantidad, 0)),0) as sem23,
			ifnull(sum(if(a.semana = 24, a.cantidad, 0)),0) as sem24,
			ifnull(sum(if(a.semana = 25, a.cantidad, 0)),0) as sem25,
			ifnull(sum(if(a.semana = 26, a.cantidad, 0)),0) as sem26,
			ifnull(sum(if(a.semana = 27, a.cantidad, 0)),0) as sem27,
			ifnull(sum(if(a.semana = 28, a.cantidad, 0)),0) as sem28,
			ifnull(sum(if(a.semana = 29, a.cantidad, 0)),0) as sem29,
			ifnull(sum(if(a.semana = 30, a.cantidad, 0)),0) as sem30,
			ifnull(sum(if(a.semana = 31, a.cantidad, 0)),0) as sem31,
			ifnull(sum(if(a.semana = 32, a.cantidad, 0)),0) as sem32,
			ifnull(sum(if(a.semana = 33, a.cantidad, 0)),0) as sem33,
			ifnull(sum(if(a.semana = 34, a.cantidad, 0)),0) as sem34,
			ifnull(sum(if(a.semana = 35, a.cantidad, 0)),0) as sem35,
			ifnull(sum(if(a.semana = 36, a.cantidad, 0)),0) as sem36,
			ifnull(sum(if(a.semana = 37, a.cantidad, 0)),0) as sem37,
			ifnull(sum(if(a.semana = 38, a.cantidad, 0)),0) as sem38,
			ifnull(sum(if(a.semana = 39, a.cantidad, 0)),0) as sem39,
			ifnull(sum(if(a.semana = 40, a.cantidad, 0)),0) as sem40,
			ifnull(sum(if(a.semana = 41, a.cantidad, 0)),0) as sem41,
			ifnull(sum(if(a.semana = 42, a.cantidad, 0)),0) as sem42,
			ifnull(sum(if(a.semana = 43, a.cantidad, 0)),0) as sem43,
			ifnull(sum(if(a.semana = 44, a.cantidad, 0)),0) as sem44,
			ifnull(sum(if(a.semana = 45, a.cantidad, 0)),0) as sem45,
			ifnull(sum(if(a.semana = 46, a.cantidad, 0)),0) as sem46,
			ifnull(sum(if(a.semana = 47, a.cantidad, 0)),0) as sem47,
			ifnull(sum(if(a.semana = 48, a.cantidad, 0)),0) as sem48,
			ifnull(sum(if(a.semana = 49, a.cantidad, 0)),0) as sem49,
			ifnull(sum(if(a.semana = 50, a.cantidad, 0)),0) as sem50,
			ifnull(sum(if(a.semana = 51, a.cantidad, 0)),0) as sem51,
			ifnull(sum(if(a.semana = 52, a.cantidad, 0)),0) as sem52,
			ifnull(sum(if(a.semana = 53, a.cantidad, 0)),0) as sem53
			from
			codubi b
			left join
			(select ubigeo, semana, sum(daa_c1+daa_c1_4+daa_c5+dis_c1+dis_c1_4+dis_c5) as cantidad from edas
			where ano = $anio and substr(ubigeo,1,4) = '".$provincia."' and ubigeo <> '' 
			group by ubigeo, semana) a
			on b.ubigeo = a.ubigeo
			where b.ano = $anio and substr(a.ubigeo,1,4) = '".$provincia."' 
			group by b.distrito
			";
		}elseif(!empty($departamento) and empty($provincia) and empty($distrito)){
			$plantilla = "
			select b.provincia as nombre,
			ifnull(sum(if(a.semana = 1, a.cantidad, 0)),0) as sem1,
			ifnull(sum(if(a.semana = 2, a.cantidad, 0)),0) as sem2,
			ifnull(sum(if(a.semana = 3, a.cantidad, 0)),0) as sem3,
			ifnull(sum(if(a.semana = 4, a.cantidad, 0)),0) as sem4,
			ifnull(sum(if(a.semana = 5, a.cantidad, 0)),0) as sem5,
			ifnull(sum(if(a.semana = 6, a.cantidad, 0)),0) as sem6,
			ifnull(sum(if(a.semana = 7, a.cantidad, 0)),0) as sem7,
			ifnull(sum(if(a.semana = 8, a.cantidad, 0)),0) as sem8,
			ifnull(sum(if(a.semana = 9, a.cantidad, 0)),0) as sem9,
			ifnull(sum(if(a.semana = 10, a.cantidad, 0)),0) as sem10,
			ifnull(sum(if(a.semana = 11, a.cantidad, 0)),0) as sem11,
			ifnull(sum(if(a.semana = 12, a.cantidad, 0)),0) as sem12,
			ifnull(sum(if(a.semana = 13, a.cantidad, 0)),0) as sem13,
			ifnull(sum(if(a.semana = 14, a.cantidad, 0)),0) as sem14,
			ifnull(sum(if(a.semana = 15, a.cantidad, 0)),0) as sem15,
			ifnull(sum(if(a.semana = 16, a.cantidad, 0)),0) as sem16,
			ifnull(sum(if(a.semana = 17, a.cantidad, 0)),0) as sem17,
			ifnull(sum(if(a.semana = 18, a.cantidad, 0)),0) as sem18,
			ifnull(sum(if(a.semana = 19, a.cantidad, 0)),0) as sem19,
			ifnull(sum(if(a.semana = 20, a.cantidad, 0)),0) as sem20,
			ifnull(sum(if(a.semana = 21, a.cantidad, 0)),0) as sem21,
			ifnull(sum(if(a.semana = 22, a.cantidad, 0)),0) as sem22,
			ifnull(sum(if(a.semana = 23, a.cantidad, 0)),0) as sem23,
			ifnull(sum(if(a.semana = 24, a.cantidad, 0)),0) as sem24,
			ifnull(sum(if(a.semana = 25, a.cantidad, 0)),0) as sem25,
			ifnull(sum(if(a.semana = 26, a.cantidad, 0)),0) as sem26,
			ifnull(sum(if(a.semana = 27, a.cantidad, 0)),0) as sem27,
			ifnull(sum(if(a.semana = 28, a.cantidad, 0)),0) as sem28,
			ifnull(sum(if(a.semana = 29, a.cantidad, 0)),0) as sem29,
			ifnull(sum(if(a.semana = 30, a.cantidad, 0)),0) as sem30,
			ifnull(sum(if(a.semana = 31, a.cantidad, 0)),0) as sem31,
			ifnull(sum(if(a.semana = 32, a.cantidad, 0)),0) as sem32,
			ifnull(sum(if(a.semana = 33, a.cantidad, 0)),0) as sem33,
			ifnull(sum(if(a.semana = 34, a.cantidad, 0)),0) as sem34,
			ifnull(sum(if(a.semana = 35, a.cantidad, 0)),0) as sem35,
			ifnull(sum(if(a.semana = 36, a.cantidad, 0)),0) as sem36,
			ifnull(sum(if(a.semana = 37, a.cantidad, 0)),0) as sem37,
			ifnull(sum(if(a.semana = 38, a.cantidad, 0)),0) as sem38,
			ifnull(sum(if(a.semana = 39, a.cantidad, 0)),0) as sem39,
			ifnull(sum(if(a.semana = 40, a.cantidad, 0)),0) as sem40,
			ifnull(sum(if(a.semana = 41, a.cantidad, 0)),0) as sem41,
			ifnull(sum(if(a.semana = 42, a.cantidad, 0)),0) as sem42,
			ifnull(sum(if(a.semana = 43, a.cantidad, 0)),0) as sem43,
			ifnull(sum(if(a.semana = 44, a.cantidad, 0)),0) as sem44,
			ifnull(sum(if(a.semana = 45, a.cantidad, 0)),0) as sem45,
			ifnull(sum(if(a.semana = 46, a.cantidad, 0)),0) as sem46,
			ifnull(sum(if(a.semana = 47, a.cantidad, 0)),0) as sem47,
			ifnull(sum(if(a.semana = 48, a.cantidad, 0)),0) as sem48,
			ifnull(sum(if(a.semana = 49, a.cantidad, 0)),0) as sem49,
			ifnull(sum(if(a.semana = 50, a.cantidad, 0)),0) as sem50,
			ifnull(sum(if(a.semana = 51, a.cantidad, 0)),0) as sem51,
			ifnull(sum(if(a.semana = 52, a.cantidad, 0)),0) as sem52,
			ifnull(sum(if(a.semana = 53, a.cantidad, 0)),0) as sem53
			from
			codubi b
			left join
			(select ubigeo, semana, sum(daa_c1+daa_c1_4+daa_c5+dis_c1+dis_c1_4+dis_c5) as cantidad from edas 
			where ano = $anio and substr(ubigeo,1,2) = '".$departamento."' and ubigeo <> '' 
			group by ubigeo, semana) a
			on b.ubigeo = a.ubigeo
			where b.ano = $anio and substr(a.ubigeo,1,2) = '".$departamento."' 
			group by b.provincia
			";
		}elseif(empty($departamento) and empty($provincia) and empty($distrito)){
			if($this->session->userdata('nivel') == '1' or $this->session->userdata('nivel') == '4'){
				$plantilla = "
				select b.departam as nombre,
				ifnull(sum(if(a.semana = 1, a.cantidad, 0)),0) as sem1,
				ifnull(sum(if(a.semana = 2, a.cantidad, 0)),0) as sem2,
				ifnull(sum(if(a.semana = 3, a.cantidad, 0)),0) as sem3,
				ifnull(sum(if(a.semana = 4, a.cantidad, 0)),0) as sem4,
				ifnull(sum(if(a.semana = 5, a.cantidad, 0)),0) as sem5,
				ifnull(sum(if(a.semana = 6, a.cantidad, 0)),0) as sem6,
				ifnull(sum(if(a.semana = 7, a.cantidad, 0)),0) as sem7,
				ifnull(sum(if(a.semana = 8, a.cantidad, 0)),0) as sem8,
				ifnull(sum(if(a.semana = 9, a.cantidad, 0)),0) as sem9,
				ifnull(sum(if(a.semana = 10, a.cantidad, 0)),0) as sem10,
				ifnull(sum(if(a.semana = 11, a.cantidad, 0)),0) as sem11,
				ifnull(sum(if(a.semana = 12, a.cantidad, 0)),0) as sem12,
				ifnull(sum(if(a.semana = 13, a.cantidad, 0)),0) as sem13,
				ifnull(sum(if(a.semana = 14, a.cantidad, 0)),0) as sem14,
				ifnull(sum(if(a.semana = 15, a.cantidad, 0)),0) as sem15,
				ifnull(sum(if(a.semana = 16, a.cantidad, 0)),0) as sem16,
				ifnull(sum(if(a.semana = 17, a.cantidad, 0)),0) as sem17,
				ifnull(sum(if(a.semana = 18, a.cantidad, 0)),0) as sem18,
				ifnull(sum(if(a.semana = 19, a.cantidad, 0)),0) as sem19,
				ifnull(sum(if(a.semana = 20, a.cantidad, 0)),0) as sem20,
				ifnull(sum(if(a.semana = 21, a.cantidad, 0)),0) as sem21,
				ifnull(sum(if(a.semana = 22, a.cantidad, 0)),0) as sem22,
				ifnull(sum(if(a.semana = 23, a.cantidad, 0)),0) as sem23,
				ifnull(sum(if(a.semana = 24, a.cantidad, 0)),0) as sem24,
				ifnull(sum(if(a.semana = 25, a.cantidad, 0)),0) as sem25,
				ifnull(sum(if(a.semana = 26, a.cantidad, 0)),0) as sem26,
				ifnull(sum(if(a.semana = 27, a.cantidad, 0)),0) as sem27,
				ifnull(sum(if(a.semana = 28, a.cantidad, 0)),0) as sem28,
				ifnull(sum(if(a.semana = 29, a.cantidad, 0)),0) as sem29,
				ifnull(sum(if(a.semana = 30, a.cantidad, 0)),0) as sem30,
				ifnull(sum(if(a.semana = 31, a.cantidad, 0)),0) as sem31,
				ifnull(sum(if(a.semana = 32, a.cantidad, 0)),0) as sem32,
				ifnull(sum(if(a.semana = 33, a.cantidad, 0)),0) as sem33,
				ifnull(sum(if(a.semana = 34, a.cantidad, 0)),0) as sem34,
				ifnull(sum(if(a.semana = 35, a.cantidad, 0)),0) as sem35,
				ifnull(sum(if(a.semana = 36, a.cantidad, 0)),0) as sem36,
				ifnull(sum(if(a.semana = 37, a.cantidad, 0)),0) as sem37,
				ifnull(sum(if(a.semana = 38, a.cantidad, 0)),0) as sem38,
				ifnull(sum(if(a.semana = 39, a.cantidad, 0)),0) as sem39,
				ifnull(sum(if(a.semana = 40, a.cantidad, 0)),0) as sem40,
				ifnull(sum(if(a.semana = 41, a.cantidad, 0)),0) as sem41,
				ifnull(sum(if(a.semana = 42, a.cantidad, 0)),0) as sem42,
				ifnull(sum(if(a.semana = 43, a.cantidad, 0)),0) as sem43,
				ifnull(sum(if(a.semana = 44, a.cantidad, 0)),0) as sem44,
				ifnull(sum(if(a.semana = 45, a.cantidad, 0)),0) as sem45,
				ifnull(sum(if(a.semana = 46, a.cantidad, 0)),0) as sem46,
				ifnull(sum(if(a.semana = 47, a.cantidad, 0)),0) as sem47,
				ifnull(sum(if(a.semana = 48, a.cantidad, 0)),0) as sem48,
				ifnull(sum(if(a.semana = 49, a.cantidad, 0)),0) as sem49,
				ifnull(sum(if(a.semana = 50, a.cantidad, 0)),0) as sem50,
				ifnull(sum(if(a.semana = 51, a.cantidad, 0)),0) as sem51,
				ifnull(sum(if(a.semana = 52, a.cantidad, 0)),0) as sem52,
				ifnull(sum(if(a.semana = 53, a.cantidad, 0)),0) as sem53
				from
				codubi b
				left join
				(select ubigeo, semana, sum(daa_c1+daa_c1_4+daa_c5+dis_c1+dis_c1_4+dis_c5) as cantidad from edas
				where ano = $anio and ubigeo <> ''
				group by ubigeo, semana) a
				on b.ubigeo = a.ubigeo
				where b.ano = $anio
				group by b.departam
				";
			}else{
				$this->session->set_flashdata('error', 'Debe elegir alg&uacute;n nivel de proceso, este reporte no est&aacute; activo para su nivel de usuario, comun&iacute;quese a notificacion@dge.gob.pe');
				redirect(site_url("reportes/repEdas"), 301);
			}
		}
		
		$query = $this->db->query($plantilla);
		
		return $query->result();
		
	}

	//Reporte de la notificación de EDAS en descripción de espacio por nivel de EESS
	public function notificacionEdaEspacioEESS($anio, $diresa, $red, $microred, $establec)
	{
		if(!empty($diresa) and !empty($red) and !empty($microred) and !empty($establec)){
			$plantilla = "
			select b.raz_soc as nombre,
			ifnull(sum(if(a.semana = 1, a.cantidad, 0)),0) as sem1,
			ifnull(sum(if(a.semana = 2, a.cantidad, 0)),0) as sem2,
			ifnull(sum(if(a.semana = 3, a.cantidad, 0)),0) as sem3,
			ifnull(sum(if(a.semana = 4, a.cantidad, 0)),0) as sem4,
			ifnull(sum(if(a.semana = 5, a.cantidad, 0)),0) as sem5,
			ifnull(sum(if(a.semana = 6, a.cantidad, 0)),0) as sem6,
			ifnull(sum(if(a.semana = 7, a.cantidad, 0)),0) as sem7,
			ifnull(sum(if(a.semana = 8, a.cantidad, 0)),0) as sem8,
			ifnull(sum(if(a.semana = 9, a.cantidad, 0)),0) as sem9,
			ifnull(sum(if(a.semana = 10, a.cantidad, 0)),0) as sem10,
			ifnull(sum(if(a.semana = 11, a.cantidad, 0)),0) as sem11,
			ifnull(sum(if(a.semana = 12, a.cantidad, 0)),0) as sem12,
			ifnull(sum(if(a.semana = 13, a.cantidad, 0)),0) as sem13,
			ifnull(sum(if(a.semana = 14, a.cantidad, 0)),0) as sem14,
			ifnull(sum(if(a.semana = 15, a.cantidad, 0)),0) as sem15,
			ifnull(sum(if(a.semana = 16, a.cantidad, 0)),0) as sem16,
			ifnull(sum(if(a.semana = 17, a.cantidad, 0)),0) as sem17,
			ifnull(sum(if(a.semana = 18, a.cantidad, 0)),0) as sem18,
			ifnull(sum(if(a.semana = 19, a.cantidad, 0)),0) as sem19,
			ifnull(sum(if(a.semana = 20, a.cantidad, 0)),0) as sem20,
			ifnull(sum(if(a.semana = 21, a.cantidad, 0)),0) as sem21,
			ifnull(sum(if(a.semana = 22, a.cantidad, 0)),0) as sem22,
			ifnull(sum(if(a.semana = 23, a.cantidad, 0)),0) as sem23,
			ifnull(sum(if(a.semana = 24, a.cantidad, 0)),0) as sem24,
			ifnull(sum(if(a.semana = 25, a.cantidad, 0)),0) as sem25,
			ifnull(sum(if(a.semana = 26, a.cantidad, 0)),0) as sem26,
			ifnull(sum(if(a.semana = 27, a.cantidad, 0)),0) as sem27,
			ifnull(sum(if(a.semana = 28, a.cantidad, 0)),0) as sem28,
			ifnull(sum(if(a.semana = 29, a.cantidad, 0)),0) as sem29,
			ifnull(sum(if(a.semana = 30, a.cantidad, 0)),0) as sem30,
			ifnull(sum(if(a.semana = 31, a.cantidad, 0)),0) as sem31,
			ifnull(sum(if(a.semana = 32, a.cantidad, 0)),0) as sem32,
			ifnull(sum(if(a.semana = 33, a.cantidad, 0)),0) as sem33,
			ifnull(sum(if(a.semana = 34, a.cantidad, 0)),0) as sem34,
			ifnull(sum(if(a.semana = 35, a.cantidad, 0)),0) as sem35,
			ifnull(sum(if(a.semana = 36, a.cantidad, 0)),0) as sem36,
			ifnull(sum(if(a.semana = 37, a.cantidad, 0)),0) as sem37,
			ifnull(sum(if(a.semana = 38, a.cantidad, 0)),0) as sem38,
			ifnull(sum(if(a.semana = 39, a.cantidad, 0)),0) as sem39,
			ifnull(sum(if(a.semana = 40, a.cantidad, 0)),0) as sem40,
			ifnull(sum(if(a.semana = 41, a.cantidad, 0)),0) as sem41,
			ifnull(sum(if(a.semana = 42, a.cantidad, 0)),0) as sem42,
			ifnull(sum(if(a.semana = 43, a.cantidad, 0)),0) as sem43,
			ifnull(sum(if(a.semana = 44, a.cantidad, 0)),0) as sem44,
			ifnull(sum(if(a.semana = 45, a.cantidad, 0)),0) as sem45,
			ifnull(sum(if(a.semana = 46, a.cantidad, 0)),0) as sem46,
			ifnull(sum(if(a.semana = 47, a.cantidad, 0)),0) as sem47,
			ifnull(sum(if(a.semana = 48, a.cantidad, 0)),0) as sem48,
			ifnull(sum(if(a.semana = 49, a.cantidad, 0)),0) as sem49,
			ifnull(sum(if(a.semana = 50, a.cantidad, 0)),0) as sem50,
			ifnull(sum(if(a.semana = 51, a.cantidad, 0)),0) as sem51,
			ifnull(sum(if(a.semana = 52, a.cantidad, 0)),0) as sem52,
			ifnull(sum(if(a.semana = 53, a.cantidad, 0)),0) as sem53
			from
			renace b
			left join
			(select e_salud, semana, sum(daa_c1+daa_c1_4+daa_c5+dis_c1+dis_c1_4+dis_c5) as cantidad from edas 
			where ano = $anio and e_salud = '".$establec."'
			group by e_salud, semana) a
			on b.cod_est = a.e_salud
			where a.e_salud = '".$establec."' 
			group by b.raz_soc
			";
		}elseif(!empty($diresa) and !empty($red) and !empty($microred) and empty($establec)){
			$plantilla = "
			select b.raz_soc as nombre,
			ifnull(sum(if(a.semana = 1, a.cantidad, 0)),0) as sem1,
			ifnull(sum(if(a.semana = 2, a.cantidad, 0)),0) as sem2,
			ifnull(sum(if(a.semana = 3, a.cantidad, 0)),0) as sem3,
			ifnull(sum(if(a.semana = 4, a.cantidad, 0)),0) as sem4,
			ifnull(sum(if(a.semana = 5, a.cantidad, 0)),0) as sem5,
			ifnull(sum(if(a.semana = 6, a.cantidad, 0)),0) as sem6,
			ifnull(sum(if(a.semana = 7, a.cantidad, 0)),0) as sem7,
			ifnull(sum(if(a.semana = 8, a.cantidad, 0)),0) as sem8,
			ifnull(sum(if(a.semana = 9, a.cantidad, 0)),0) as sem9,
			ifnull(sum(if(a.semana = 10, a.cantidad, 0)),0) as sem10,
			ifnull(sum(if(a.semana = 11, a.cantidad, 0)),0) as sem11,
			ifnull(sum(if(a.semana = 12, a.cantidad, 0)),0) as sem12,
			ifnull(sum(if(a.semana = 13, a.cantidad, 0)),0) as sem13,
			ifnull(sum(if(a.semana = 14, a.cantidad, 0)),0) as sem14,
			ifnull(sum(if(a.semana = 15, a.cantidad, 0)),0) as sem15,
			ifnull(sum(if(a.semana = 16, a.cantidad, 0)),0) as sem16,
			ifnull(sum(if(a.semana = 17, a.cantidad, 0)),0) as sem17,
			ifnull(sum(if(a.semana = 18, a.cantidad, 0)),0) as sem18,
			ifnull(sum(if(a.semana = 19, a.cantidad, 0)),0) as sem19,
			ifnull(sum(if(a.semana = 20, a.cantidad, 0)),0) as sem20,
			ifnull(sum(if(a.semana = 21, a.cantidad, 0)),0) as sem21,
			ifnull(sum(if(a.semana = 22, a.cantidad, 0)),0) as sem22,
			ifnull(sum(if(a.semana = 23, a.cantidad, 0)),0) as sem23,
			ifnull(sum(if(a.semana = 24, a.cantidad, 0)),0) as sem24,
			ifnull(sum(if(a.semana = 25, a.cantidad, 0)),0) as sem25,
			ifnull(sum(if(a.semana = 26, a.cantidad, 0)),0) as sem26,
			ifnull(sum(if(a.semana = 27, a.cantidad, 0)),0) as sem27,
			ifnull(sum(if(a.semana = 28, a.cantidad, 0)),0) as sem28,
			ifnull(sum(if(a.semana = 29, a.cantidad, 0)),0) as sem29,
			ifnull(sum(if(a.semana = 30, a.cantidad, 0)),0) as sem30,
			ifnull(sum(if(a.semana = 31, a.cantidad, 0)),0) as sem31,
			ifnull(sum(if(a.semana = 32, a.cantidad, 0)),0) as sem32,
			ifnull(sum(if(a.semana = 33, a.cantidad, 0)),0) as sem33,
			ifnull(sum(if(a.semana = 34, a.cantidad, 0)),0) as sem34,
			ifnull(sum(if(a.semana = 35, a.cantidad, 0)),0) as sem35,
			ifnull(sum(if(a.semana = 36, a.cantidad, 0)),0) as sem36,
			ifnull(sum(if(a.semana = 37, a.cantidad, 0)),0) as sem37,
			ifnull(sum(if(a.semana = 38, a.cantidad, 0)),0) as sem38,
			ifnull(sum(if(a.semana = 39, a.cantidad, 0)),0) as sem39,
			ifnull(sum(if(a.semana = 40, a.cantidad, 0)),0) as sem40,
			ifnull(sum(if(a.semana = 41, a.cantidad, 0)),0) as sem41,
			ifnull(sum(if(a.semana = 42, a.cantidad, 0)),0) as sem42,
			ifnull(sum(if(a.semana = 43, a.cantidad, 0)),0) as sem43,
			ifnull(sum(if(a.semana = 44, a.cantidad, 0)),0) as sem44,
			ifnull(sum(if(a.semana = 45, a.cantidad, 0)),0) as sem45,
			ifnull(sum(if(a.semana = 46, a.cantidad, 0)),0) as sem46,
			ifnull(sum(if(a.semana = 47, a.cantidad, 0)),0) as sem47,
			ifnull(sum(if(a.semana = 48, a.cantidad, 0)),0) as sem48,
			ifnull(sum(if(a.semana = 49, a.cantidad, 0)),0) as sem49,
			ifnull(sum(if(a.semana = 50, a.cantidad, 0)),0) as sem50,
			ifnull(sum(if(a.semana = 51, a.cantidad, 0)),0) as sem51,
			ifnull(sum(if(a.semana = 52, a.cantidad, 0)),0) as sem52,
			ifnull(sum(if(a.semana = 53, a.cantidad, 0)),0) as sem53
			from
			renace b
			left join
			(select e_salud, semana, sum(daa_c1+daa_c1_4+daa_c5+dis_c1+dis_c1_4+dis_c5) as cantidad from edas
			where ano = $anio and sub_reg_nt = '".$diresa."'
			and red = '".$red."' and microred = '".$microred."' 
			group by e_salud, semana) a
			on b.cod_est = a.e_salud
			where b.subregion = '".$diresa."' and b.red = '".$red."' and microred = '".$microred."' and b.estado = '1'
			group by b.raz_soc
			";
		}elseif(!empty($diresa) and !empty($red) and empty($microred) and empty($establec)){
			$plantilla = "
			select b.nombre,
			ifnull(sum(if(a.semana = 1, a.cantidad, 0)),0) as sem1,
			ifnull(sum(if(a.semana = 2, a.cantidad, 0)),0) as sem2,
			ifnull(sum(if(a.semana = 3, a.cantidad, 0)),0) as sem3,
			ifnull(sum(if(a.semana = 4, a.cantidad, 0)),0) as sem4,
			ifnull(sum(if(a.semana = 5, a.cantidad, 0)),0) as sem5,
			ifnull(sum(if(a.semana = 6, a.cantidad, 0)),0) as sem6,
			ifnull(sum(if(a.semana = 7, a.cantidad, 0)),0) as sem7,
			ifnull(sum(if(a.semana = 8, a.cantidad, 0)),0) as sem8,
			ifnull(sum(if(a.semana = 9, a.cantidad, 0)),0) as sem9,
			ifnull(sum(if(a.semana = 10, a.cantidad, 0)),0) as sem10,
			ifnull(sum(if(a.semana = 11, a.cantidad, 0)),0) as sem11,
			ifnull(sum(if(a.semana = 12, a.cantidad, 0)),0) as sem12,
			ifnull(sum(if(a.semana = 13, a.cantidad, 0)),0) as sem13,
			ifnull(sum(if(a.semana = 14, a.cantidad, 0)),0) as sem14,
			ifnull(sum(if(a.semana = 15, a.cantidad, 0)),0) as sem15,
			ifnull(sum(if(a.semana = 16, a.cantidad, 0)),0) as sem16,
			ifnull(sum(if(a.semana = 17, a.cantidad, 0)),0) as sem17,
			ifnull(sum(if(a.semana = 18, a.cantidad, 0)),0) as sem18,
			ifnull(sum(if(a.semana = 19, a.cantidad, 0)),0) as sem19,
			ifnull(sum(if(a.semana = 20, a.cantidad, 0)),0) as sem20,
			ifnull(sum(if(a.semana = 21, a.cantidad, 0)),0) as sem21,
			ifnull(sum(if(a.semana = 22, a.cantidad, 0)),0) as sem22,
			ifnull(sum(if(a.semana = 23, a.cantidad, 0)),0) as sem23,
			ifnull(sum(if(a.semana = 24, a.cantidad, 0)),0) as sem24,
			ifnull(sum(if(a.semana = 25, a.cantidad, 0)),0) as sem25,
			ifnull(sum(if(a.semana = 26, a.cantidad, 0)),0) as sem26,
			ifnull(sum(if(a.semana = 27, a.cantidad, 0)),0) as sem27,
			ifnull(sum(if(a.semana = 28, a.cantidad, 0)),0) as sem28,
			ifnull(sum(if(a.semana = 29, a.cantidad, 0)),0) as sem29,
			ifnull(sum(if(a.semana = 30, a.cantidad, 0)),0) as sem30,
			ifnull(sum(if(a.semana = 31, a.cantidad, 0)),0) as sem31,
			ifnull(sum(if(a.semana = 32, a.cantidad, 0)),0) as sem32,
			ifnull(sum(if(a.semana = 33, a.cantidad, 0)),0) as sem33,
			ifnull(sum(if(a.semana = 34, a.cantidad, 0)),0) as sem34,
			ifnull(sum(if(a.semana = 35, a.cantidad, 0)),0) as sem35,
			ifnull(sum(if(a.semana = 36, a.cantidad, 0)),0) as sem36,
			ifnull(sum(if(a.semana = 37, a.cantidad, 0)),0) as sem37,
			ifnull(sum(if(a.semana = 38, a.cantidad, 0)),0) as sem38,
			ifnull(sum(if(a.semana = 39, a.cantidad, 0)),0) as sem39,
			ifnull(sum(if(a.semana = 40, a.cantidad, 0)),0) as sem40,
			ifnull(sum(if(a.semana = 41, a.cantidad, 0)),0) as sem41,
			ifnull(sum(if(a.semana = 42, a.cantidad, 0)),0) as sem42,
			ifnull(sum(if(a.semana = 43, a.cantidad, 0)),0) as sem43,
			ifnull(sum(if(a.semana = 44, a.cantidad, 0)),0) as sem44,
			ifnull(sum(if(a.semana = 45, a.cantidad, 0)),0) as sem45,
			ifnull(sum(if(a.semana = 46, a.cantidad, 0)),0) as sem46,
			ifnull(sum(if(a.semana = 47, a.cantidad, 0)),0) as sem47,
			ifnull(sum(if(a.semana = 48, a.cantidad, 0)),0) as sem48,
			ifnull(sum(if(a.semana = 49, a.cantidad, 0)),0) as sem49,
			ifnull(sum(if(a.semana = 50, a.cantidad, 0)),0) as sem50,
			ifnull(sum(if(a.semana = 51, a.cantidad, 0)),0) as sem51,
			ifnull(sum(if(a.semana = 52, a.cantidad, 0)),0) as sem52,
			ifnull(sum(if(a.semana = 53, a.cantidad, 0)),0) as sem53
			from
			microred b
			left join
			(select sub_reg_nt, red, microred, semana, sum(daa_c1+daa_c1_4+daa_c5+dis_c1+dis_c1_4+dis_c5) as cantidad from edas
			where ano = $anio and sub_reg_nt = '".$diresa."'
			and red = '".$red."'
			group by sub_reg_nt, red, microred, semana) a
			on concat(b.subregion, b.red, b.codigo) = concat(a.sub_reg_nt, a.red, a.microred)
			where b.subregion = '".$diresa."' and b.red = '".$red."' and b.estado = '1' 
			group by b.nombre
			";
		}elseif(!empty($diresa) and empty($red) and empty($microred) and empty($establec)){
			$plantilla = "
			select b.nombre,
			ifnull(sum(if(a.semana = 1, a.cantidad, 0)),0) as sem1,
			ifnull(sum(if(a.semana = 2, a.cantidad, 0)),0) as sem2,
			ifnull(sum(if(a.semana = 3, a.cantidad, 0)),0) as sem3,
			ifnull(sum(if(a.semana = 4, a.cantidad, 0)),0) as sem4,
			ifnull(sum(if(a.semana = 5, a.cantidad, 0)),0) as sem5,
			ifnull(sum(if(a.semana = 6, a.cantidad, 0)),0) as sem6,
			ifnull(sum(if(a.semana = 7, a.cantidad, 0)),0) as sem7,
			ifnull(sum(if(a.semana = 8, a.cantidad, 0)),0) as sem8,
			ifnull(sum(if(a.semana = 9, a.cantidad, 0)),0) as sem9,
			ifnull(sum(if(a.semana = 10, a.cantidad, 0)),0) as sem10,
			ifnull(sum(if(a.semana = 11, a.cantidad, 0)),0) as sem11,
			ifnull(sum(if(a.semana = 12, a.cantidad, 0)),0) as sem12,
			ifnull(sum(if(a.semana = 13, a.cantidad, 0)),0) as sem13,
			ifnull(sum(if(a.semana = 14, a.cantidad, 0)),0) as sem14,
			ifnull(sum(if(a.semana = 15, a.cantidad, 0)),0) as sem15,
			ifnull(sum(if(a.semana = 16, a.cantidad, 0)),0) as sem16,
			ifnull(sum(if(a.semana = 17, a.cantidad, 0)),0) as sem17,
			ifnull(sum(if(a.semana = 18, a.cantidad, 0)),0) as sem18,
			ifnull(sum(if(a.semana = 19, a.cantidad, 0)),0) as sem19,
			ifnull(sum(if(a.semana = 20, a.cantidad, 0)),0) as sem20,
			ifnull(sum(if(a.semana = 21, a.cantidad, 0)),0) as sem21,
			ifnull(sum(if(a.semana = 22, a.cantidad, 0)),0) as sem22,
			ifnull(sum(if(a.semana = 23, a.cantidad, 0)),0) as sem23,
			ifnull(sum(if(a.semana = 24, a.cantidad, 0)),0) as sem24,
			ifnull(sum(if(a.semana = 25, a.cantidad, 0)),0) as sem25,
			ifnull(sum(if(a.semana = 26, a.cantidad, 0)),0) as sem26,
			ifnull(sum(if(a.semana = 27, a.cantidad, 0)),0) as sem27,
			ifnull(sum(if(a.semana = 28, a.cantidad, 0)),0) as sem28,
			ifnull(sum(if(a.semana = 29, a.cantidad, 0)),0) as sem29,
			ifnull(sum(if(a.semana = 30, a.cantidad, 0)),0) as sem30,
			ifnull(sum(if(a.semana = 31, a.cantidad, 0)),0) as sem31,
			ifnull(sum(if(a.semana = 32, a.cantidad, 0)),0) as sem32,
			ifnull(sum(if(a.semana = 33, a.cantidad, 0)),0) as sem33,
			ifnull(sum(if(a.semana = 34, a.cantidad, 0)),0) as sem34,
			ifnull(sum(if(a.semana = 35, a.cantidad, 0)),0) as sem35,
			ifnull(sum(if(a.semana = 36, a.cantidad, 0)),0) as sem36,
			ifnull(sum(if(a.semana = 37, a.cantidad, 0)),0) as sem37,
			ifnull(sum(if(a.semana = 38, a.cantidad, 0)),0) as sem38,
			ifnull(sum(if(a.semana = 39, a.cantidad, 0)),0) as sem39,
			ifnull(sum(if(a.semana = 40, a.cantidad, 0)),0) as sem40,
			ifnull(sum(if(a.semana = 41, a.cantidad, 0)),0) as sem41,
			ifnull(sum(if(a.semana = 42, a.cantidad, 0)),0) as sem42,
			ifnull(sum(if(a.semana = 43, a.cantidad, 0)),0) as sem43,
			ifnull(sum(if(a.semana = 44, a.cantidad, 0)),0) as sem44,
			ifnull(sum(if(a.semana = 45, a.cantidad, 0)),0) as sem45,
			ifnull(sum(if(a.semana = 46, a.cantidad, 0)),0) as sem46,
			ifnull(sum(if(a.semana = 47, a.cantidad, 0)),0) as sem47,
			ifnull(sum(if(a.semana = 48, a.cantidad, 0)),0) as sem48,
			ifnull(sum(if(a.semana = 49, a.cantidad, 0)),0) as sem49,
			ifnull(sum(if(a.semana = 50, a.cantidad, 0)),0) as sem50,
			ifnull(sum(if(a.semana = 51, a.cantidad, 0)),0) as sem51,
			ifnull(sum(if(a.semana = 52, a.cantidad, 0)),0) as sem52,
			ifnull(sum(if(a.semana = 53, a.cantidad, 0)),0) as sem53
			from
			redes b
			left join
			(select sub_reg_nt, red, semana, sum(daa_c1+daa_c1_4+daa_c5+dis_c1+dis_c1_4+dis_c5) as cantidad from edas
			where ano = $anio and sub_reg_nt = '".$diresa."' 
			group by sub_reg_nt, red, semana) a
			on concat(b.subregion, b.codigo) = concat(a.sub_reg_nt, a.red)
			where b.subregion = '".$diresa."' and b.estado = '1' 
			group by b.nombre
			";
		}elseif(empty($diresa) and empty($red) and empty($microred) and empty($establec)){
			if($this->session->userdata('nivel') == '1' or $this->session->userdata('nivel') == '4'){
				$plantilla = "
				select b.nombre,
				ifnull(sum(if(a.semana = 1, a.cantidad, 0)),0) as sem1,
				ifnull(sum(if(a.semana = 2, a.cantidad, 0)),0) as sem2,
				ifnull(sum(if(a.semana = 3, a.cantidad, 0)),0) as sem3,
				ifnull(sum(if(a.semana = 4, a.cantidad, 0)),0) as sem4,
				ifnull(sum(if(a.semana = 5, a.cantidad, 0)),0) as sem5,
				ifnull(sum(if(a.semana = 6, a.cantidad, 0)),0) as sem6,
				ifnull(sum(if(a.semana = 7, a.cantidad, 0)),0) as sem7,
				ifnull(sum(if(a.semana = 8, a.cantidad, 0)),0) as sem8,
				ifnull(sum(if(a.semana = 9, a.cantidad, 0)),0) as sem9,
				ifnull(sum(if(a.semana = 10, a.cantidad, 0)),0) as sem10,
				ifnull(sum(if(a.semana = 11, a.cantidad, 0)),0) as sem11,
				ifnull(sum(if(a.semana = 12, a.cantidad, 0)),0) as sem12,
				ifnull(sum(if(a.semana = 13, a.cantidad, 0)),0) as sem13,
				ifnull(sum(if(a.semana = 14, a.cantidad, 0)),0) as sem14,
				ifnull(sum(if(a.semana = 15, a.cantidad, 0)),0) as sem15,
				ifnull(sum(if(a.semana = 16, a.cantidad, 0)),0) as sem16,
				ifnull(sum(if(a.semana = 17, a.cantidad, 0)),0) as sem17,
				ifnull(sum(if(a.semana = 18, a.cantidad, 0)),0) as sem18,
				ifnull(sum(if(a.semana = 19, a.cantidad, 0)),0) as sem19,
				ifnull(sum(if(a.semana = 20, a.cantidad, 0)),0) as sem20,
				ifnull(sum(if(a.semana = 21, a.cantidad, 0)),0) as sem21,
				ifnull(sum(if(a.semana = 22, a.cantidad, 0)),0) as sem22,
				ifnull(sum(if(a.semana = 23, a.cantidad, 0)),0) as sem23,
				ifnull(sum(if(a.semana = 24, a.cantidad, 0)),0) as sem24,
				ifnull(sum(if(a.semana = 25, a.cantidad, 0)),0) as sem25,
				ifnull(sum(if(a.semana = 26, a.cantidad, 0)),0) as sem26,
				ifnull(sum(if(a.semana = 27, a.cantidad, 0)),0) as sem27,
				ifnull(sum(if(a.semana = 28, a.cantidad, 0)),0) as sem28,
				ifnull(sum(if(a.semana = 29, a.cantidad, 0)),0) as sem29,
				ifnull(sum(if(a.semana = 30, a.cantidad, 0)),0) as sem30,
				ifnull(sum(if(a.semana = 31, a.cantidad, 0)),0) as sem31,
				ifnull(sum(if(a.semana = 32, a.cantidad, 0)),0) as sem32,
				ifnull(sum(if(a.semana = 33, a.cantidad, 0)),0) as sem33,
				ifnull(sum(if(a.semana = 34, a.cantidad, 0)),0) as sem34,
				ifnull(sum(if(a.semana = 35, a.cantidad, 0)),0) as sem35,
				ifnull(sum(if(a.semana = 36, a.cantidad, 0)),0) as sem36,
				ifnull(sum(if(a.semana = 37, a.cantidad, 0)),0) as sem37,
				ifnull(sum(if(a.semana = 38, a.cantidad, 0)),0) as sem38,
				ifnull(sum(if(a.semana = 39, a.cantidad, 0)),0) as sem39,
				ifnull(sum(if(a.semana = 40, a.cantidad, 0)),0) as sem40,
				ifnull(sum(if(a.semana = 41, a.cantidad, 0)),0) as sem41,
				ifnull(sum(if(a.semana = 42, a.cantidad, 0)),0) as sem42,
				ifnull(sum(if(a.semana = 43, a.cantidad, 0)),0) as sem43,
				ifnull(sum(if(a.semana = 44, a.cantidad, 0)),0) as sem44,
				ifnull(sum(if(a.semana = 45, a.cantidad, 0)),0) as sem45,
				ifnull(sum(if(a.semana = 46, a.cantidad, 0)),0) as sem46,
				ifnull(sum(if(a.semana = 47, a.cantidad, 0)),0) as sem47,
				ifnull(sum(if(a.semana = 48, a.cantidad, 0)),0) as sem48,
				ifnull(sum(if(a.semana = 49, a.cantidad, 0)),0) as sem49,
				ifnull(sum(if(a.semana = 50, a.cantidad, 0)),0) as sem50,
				ifnull(sum(if(a.semana = 51, a.cantidad, 0)),0) as sem51,
				ifnull(sum(if(a.semana = 52, a.cantidad, 0)),0) as sem52,
				ifnull(sum(if(a.semana = 53, a.cantidad, 0)),0) as sem53
				from
				diresas b
				left join
				(select sub_reg_nt, semana, sum(daa_c1+daa_c1_4+daa_c5+dis_c1+dis_c1_4+dis_c5) as cantidad from edas 
				where ano = $anio 
				group by sub_reg_nt, semana) a
				on b.codigo = a.sub_reg_nt
				group by b.nombre
				";
			}else{
				$this->session->set_flashdata('error', 'Debe elegir alg&uacute;n nivel de proceso, este reporte no est&aacute; activo para su nivel de usuario, comun&iacute;quese a notificacion@dge.gob.pe');
				redirect(site_url("reportes/repEdas"), 301);
			}
		}
		
		$query = $this->db->query($plantilla);
		
		return $query->result();
		
	}

	//Reporte de la notificación de las Iras en descripción de tiempo por nivel de ubigeo
	
	public function notificacionIraTiempoUbigeo($anio, $departamento, $provincia, $distrito)
	{
		if(!empty($departamento) and !empty($provincia) and !empty($distrito)){
			$plantilla = "
			select a.semana,
			a.casos as casos_1,
			a.poblacion as pob_1,
			round((a.casos / a.poblacion) * 100000,2) as inc_1,
			if(a.semana=d.semana, d.defuncion, 0) as def_1,
			round((if(a.semana=d.semana, d.defuncion, 0) / a.poblacion * 1000),2) as mort_1,
			round((if(a.semana=d.semana, d.defuncion, 0) / a.casos * 100),2) as letal_1,
			b.casos as casos_2,
			b.poblacion as pob_2,
			round((b.casos / b.poblacion) * 100000,2) as inc_2,
			if(a.semana=e.semana, e.defuncion, 0) as def_2,
			round((if(a.semana=e.semana, e.defuncion, 0) / b.poblacion * 1000),2) as mort_2,
			round((if(a.semana=e.semana, e.defuncion, 0) / b.casos * 100),2) as letal_2,
			ifnull(c.casos,0) as casos_3,
			ifnull(c.poblacion,0) as pob_3,
			ifnull(round((c.casos / c.poblacion) * 100000,2),0) as inc_3,
			ifnull(if(a.semana=f.semana, f.defuncion, 0),0) as def_3,
			round((if(a.semana=f.semana, f.defuncion, 0) / c.poblacion * 1000),2) as mort_3,
			round((if(a.semana=f.semana, f.defuncion, 0) / c.casos * 100),2) as letal_3
			from
			(select ano, semana, sum(ira_m2+ira_2_11+ira_1_4a+neu_2_11+neu_1_4a+ngr_m2+ngr_2_11+ngr_1_4a) as casos,
			(select sum(pobtot) from codubi where ano = $anio-2) as poblacion from iras_ant
			where ano = $anio-2 and ubigeo = '".$distrito."' group by ano, semana) a
			left join
			(select ano, semana, sum(ira_m2+ira_2_11+ira_1_4a+neu_2_11+neu_1_4a+ngr_m2+ngr_2_11+ngr_1_4a) as casos, 
			(select sum(pobtot) from codubi where ano = $anio-1) as poblacion from iras_ant
			where ano = $anio-1 and ubigeo = '".$distrito."' group by ano, semana) b
			on a.semana = b.semana
			left join
			(select ano, semana, sum(ira_m2+ira_2_11+ira_1_4a+neu_2_11+neu_1_4a+ngr_m2+ngr_2_11+ngr_1_4a) as casos, 
			(select sum(pobtot) from codubi where ano = $anio) as poblacion from iras
			where ano = $anio and ubigeo = '".$distrito."' group by ano, semana) c
			on a.semana = c.semana
			left join
			(select ano, semana, sum(dih_m2+dih_2_11+dih_1_4a+deh_m2+deh_2_11+deh_1_4a) as defuncion 
			from iras_ant where ano = $anio-2 and ubigeo = '".$distrito."' group by ano, semana) d
			on a.semana = d.semana
			left join
			(select ano, semana, sum(dih_m2+dih_2_11+dih_1_4a+deh_m2+deh_2_11+deh_1_4a) as defuncion 
			from iras_ant where ano = $anio-1 and ubigeo = '".$distrito."' group by ano, semana) e
			on a.semana = e.semana
			left join
			(select ano, semana, sum(dih_m2+dih_2_11+dih_1_4a+deh_m2+deh_2_11+deh_1_4a) as defuncion 
			from iras where ano = $anio and ubigeo = '".$distrito."' group by ano, semana) f
			on a.semana = f.semana
			group by a.semana			
			";
		}elseif(!empty($departamento) and !empty($provincia) and empty($distrito)){
			$plantilla = "
			select a.semana,
			a.casos as casos_1,
			a.poblacion as pob_1,
			round((a.casos / a.poblacion) * 100000,2) as inc_1,
			if(a.semana=d.semana, d.defuncion, 0) as def_1,
			round((if(a.semana=d.semana, d.defuncion, 0) / a.poblacion * 1000),2) as mort_1,
			round((if(a.semana=d.semana, d.defuncion, 0) / a.casos * 100),2) as letal_1,
			b.casos as casos_2,
			b.poblacion as pob_2,
			round((b.casos / b.poblacion) * 100000,2) as inc_2,
			if(a.semana=e.semana, e.defuncion, 0) as def_2,
			round((if(a.semana=e.semana, e.defuncion, 0) / b.poblacion * 1000),2) as mort_2,
			round((if(a.semana=e.semana, e.defuncion, 0) / b.casos * 100),2) as letal_2,
			ifnull(c.casos,0) as casos_3,
			ifnull(c.poblacion,0) as pob_3,
			ifnull(round((c.casos / c.poblacion) * 100000,2),0) as inc_3,
			ifnull(if(a.semana=f.semana, f.defuncion, 0),0) as def_3,
			round((if(a.semana=f.semana, f.defuncion, 0) / c.poblacion * 1000),2) as mort_3,
			round((if(a.semana=f.semana, f.defuncion, 0) / c.casos * 100),2) as letal_3
			from
			(select ano, semana, sum(ira_m2+ira_2_11+ira_1_4a+neu_2_11+neu_1_4a+ngr_m2+ngr_2_11+ngr_1_4a) as casos,
			(select sum(pobtot) from codubi where ano = $anio-2) as poblacion from iras_ant
			where ano = $anio-2 and substr(ubigeo,1,4) = '".$provincia."' group by ano, semana) a
			left join
			(select ano, semana, sum(ira_m2+ira_2_11+ira_1_4a+neu_2_11+neu_1_4a+ngr_m2+ngr_2_11+ngr_1_4a) as casos, (select sum(pobtot) 
			from codubi where ano = $anio-1) as poblacion from iras_ant
			where ano = $anio-1 and substr(ubigeo,1,4) = '".$provincia."' group by ano, semana) b
			on a.semana = b.semana
			left join
			(select ano, semana, sum(ira_m2+ira_2_11+ira_1_4a+neu_2_11+neu_1_4a+ngr_m2+ngr_2_11+ngr_1_4a) as casos, (select sum(pobtot) 
			from codubi where ano = $anio) as poblacion from iras
			where ano = $anio and substr(ubigeo,1,4) = '".$provincia."' group by ano, semana) c
			on a.semana = c.semana
			left join
			(select ano, semana, sum(dih_m2+dih_2_11+dih_1_4a+deh_m2+deh_2_11+deh_1_4a) as defuncion 
			from iras_ant where ano = $anio-2 and substr(ubigeo,1,4) = '".$provincia."' group by ano, semana) d
			on a.semana = d.semana
			left join
			(select ano, semana, sum(dih_m2+dih_2_11+dih_1_4a+deh_m2+deh_2_11+deh_1_4a) as defuncion 
			from iras_ant where ano = $anio-1 and substr(ubigeo,1,4) = '".$provincia."' group by ano, semana) e
			on a.semana = e.semana
			left join
			(select ano, semana, sum(dih_m2+dih_2_11+dih_1_4a+deh_m2+deh_2_11+deh_1_4a) as defuncion 
			from iras where ano = $anio and substr(ubigeo,1,4) = '".$provincia."' group by ano, semana) f
			on a.semana = f.semana
			group by a.semana			
			";
		}elseif(!empty($departamento) and empty($provincia) and empty($distrito)){
			$plantilla = "
			select a.semana,
			a.casos as casos_1,
			a.poblacion as pob_1,
			round((a.casos / a.poblacion) * 100000,2) as inc_1,
			if(a.semana=d.semana, d.defuncion, 0) as def_1,
			round((if(a.semana=d.semana, d.defuncion, 0) / a.poblacion * 1000),2) as mort_1,
			round((if(a.semana=d.semana, d.defuncion, 0) / a.casos * 100),2) as letal_1,
			b.casos as casos_2,
			b.poblacion as pob_2,
			round((b.casos / b.poblacion) * 100000,2) as inc_2,
			if(a.semana=e.semana, e.defuncion, 0) as def_2,
			round((if(a.semana=e.semana, e.defuncion, 0) / b.poblacion * 1000),2) as mort_2,
			round((if(a.semana=e.semana, e.defuncion, 0) / b.casos * 100),2) as letal_2,
			ifnull(c.casos,0) as casos_3,
			ifnull(c.poblacion,0) as pob_3,
			ifnull(round((c.casos / c.poblacion) * 100000,2),0) as inc_3,
			ifnull(if(a.semana=f.semana, f.defuncion, 0),0) as def_3,
			round((if(a.semana=f.semana, f.defuncion, 0) / c.poblacion * 1000),2) as mort_3,
			round((if(a.semana=f.semana, f.defuncion, 0) / c.casos * 100),2) as letal_3
			from
			(select ano, semana, sum(ira_m2+ira_2_11+ira_1_4a+neu_2_11+neu_1_4a+ngr_m2+ngr_2_11+ngr_1_4a) as casos,
			(select sum(pobtot) from codubi where ano = $anio-2) as poblacion from iras_ant
			where ano = $anio-2 and substr(ubigeo,1,2) = '".$departamento."' group by ano, semana) a
			left join
			(select ano, semana, sum(ira_m2+ira_2_11+ira_1_4a+neu_2_11+neu_1_4a+ngr_m2+ngr_2_11+ngr_1_4a) as casos, (select sum(pobtot) 
			from codubi where ano = $anio-1) as poblacion from iras_ant
			where ano = $anio-1 and substr(ubigeo,1,2) = '".$departamento."' 
			group by ano, semana) b
			on a.semana = b.semana
			left join
			(select ano, semana, sum(ira_m2+ira_2_11+ira_1_4a+neu_2_11+neu_1_4a+ngr_m2+ngr_2_11+ngr_1_4a) as casos, (select sum(pobtot) 
			from codubi where ano = $anio) as poblacion from iras
			where ano = $anio and substr(ubigeo,1,2) = '".$departamento."'
			group by ano, semana) c
			on a.semana = c.semana
			left join
			(select ano, semana, sum(dih_m2+dih_2_11+dih_1_4a+deh_m2+deh_2_11+deh_1_4a) as defuncion 
			from iras_ant where ano = $anio-2 and substr(ubigeo,1,2) = '".$departamento."' group by ano, semana) d
			on a.semana = d.semana
			left join
			(select ano, semana, sum(dih_m2+dih_2_11+dih_1_4a+deh_m2+deh_2_11+deh_1_4a) as defuncion 
			from iras_ant where ano = $anio-1 and substr(ubigeo,1,2) = '".$departamento."' 
			group by ano, semana) e
			on a.semana = e.semana
			left join
			(select ano, semana, sum(dih_m2+dih_2_11+dih_1_4a+deh_m2+deh_2_11+deh_1_4a) as defuncion 
			from iras where ano = $anio and substr(ubigeo,1,2) = '".$departamento."' group by ano, semana) f
			on a.semana = f.semana
			group by a.semana			
			";
		}elseif(empty($departamento) and empty($provincia) and empty($distrito)){
			if($this->session->userdata('nivel') == '1' or $this->session->userdata('nivel') == '4'){
				$plantilla = "
				select a.semana,
				a.casos as casos_1,
				a.poblacion as pob_1,
				round((a.casos / a.poblacion) * 100000,2) as inc_1,
				if(a.semana=d.semana, d.defuncion, 0) as def_1,
				round((if(a.semana=d.semana, d.defuncion, 0) / a.poblacion * 1000),2) as mort_1,
				round((if(a.semana=d.semana, d.defuncion, 0) / a.casos * 100),2) as letal_1,
				b.casos as casos_2,
				b.poblacion as pob_2,
				round((b.casos / b.poblacion) * 100000,2) as inc_2,
				if(a.semana=e.semana, e.defuncion, 0) as def_2,
				round((if(a.semana=e.semana, e.defuncion, 0) / b.poblacion * 1000),2) as mort_2,
				round((if(a.semana=e.semana, e.defuncion, 0) / b.casos * 100),2) as letal_2,
				ifnull(c.casos,0) as casos_3,
				ifnull(c.poblacion,0) as pob_3,
				ifnull(round((c.casos / c.poblacion) * 100000,2),0) as inc_3,
				ifnull(if(a.semana=f.semana, f.defuncion, 0),0) as def_3,
				round((if(a.semana=f.semana, f.defuncion, 0) / c.poblacion * 1000),2) as mort_3,
				round((if(a.semana=f.semana, f.defuncion, 0) / c.casos * 100),2) as letal_3
				from
				(select ano, semana, sum(ira_m2+ira_2_11+ira_1_4a+neu_2_11+neu_1_4a+ngr_m2+ngr_2_11+ngr_1_4a) as casos,
				(select sum(pobtot) from codubi where ano = $anio-2) as poblacion from iras_ant
				where ano = $anio-2 group by ano, semana) a
				left join
				(select ano, semana, sum(ira_m2+ira_2_11+ira_1_4a+neu_2_11+neu_1_4a+ngr_m2+ngr_2_11+ngr_1_4a) as casos, 
				(select sum(pobtot) from codubi where ano = $anio-1) as poblacion from iras_ant
				where ano = $anio-1 group by ano, semana) b
				on a.semana = b.semana
				left join
				(select ano, semana, sum(ira_m2+ira_2_11+ira_1_4a+neu_2_11+neu_1_4a+ngr_m2+ngr_2_11+ngr_1_4a) as casos, 
				(select sum(pobtot) from codubi where ano = $anio) as poblacion from iras
				where ano = $anio group by ano, semana) c
				on a.semana = c.semana
				left join
				(select ano, semana, sum(dih_m2+dih_2_11+dih_1_4a+deh_m2+deh_2_11+deh_1_4a) as defuncion 
				from iras_ant where ano = $anio-2  
				group by ano, semana) d
				on a.semana = d.semana
				left join
				(select ano, semana, sum(dih_m2+dih_2_11+dih_1_4a+deh_m2+deh_2_11+deh_1_4a) as defuncion 
				from iras_ant where ano = $anio-1  
				group by ano, semana) e
				on a.semana = e.semana
				left join
				(select ano, semana, sum(dih_m2+dih_2_11+dih_1_4a+deh_m2+deh_2_11+deh_1_4a) as defuncion 
				from iras where ano = $anio group by ano, semana) f
				on a.semana = f.semana
				group by a.semana			
				";
			}else{
				$this->session->set_flashdata('error', 'Debe elegir alg&uacute;n nivel de proceso, este reporte no est&aacute; activo para su nivel de usuario, comun&iacute;quese a notificacion@dge.gob.pe');
				redirect(site_url("reportes/repIras"), 301);
			}
		}
		
		$query = $this->db->query($plantilla);
		
		return $query->result();
		
	}

	//Reporte de la notificación de las IRAS en descripción de tiempo por nivel de Establecimiento de salud
	
	public function notificacionIraTiempoEESS($anio, $diresa, $red, $microred, $establec)
	{
		if(!empty($diresa) and !empty($red) and !empty($microred) and !empty($establec)){
			$plantilla = "
			select a.semana,
			a.casos as casos_1,
			a.poblacion as pob_1,
			round((a.casos / a.poblacion) * 100000,2) as inc_1,
			if(a.semana=d.semana, d.defuncion, 0) as def_1,
			round((if(a.semana=d.semana, d.defuncion, 0) / a.poblacion * 1000),2) as mort_1,
			round((if(a.semana=d.semana, d.defuncion, 0) / a.casos * 100),2) as letal_1,
			b.casos as casos_2,
			b.poblacion as pob_2,
			round((b.casos / b.poblacion) * 100000,2) as inc_2,
			if(a.semana=e.semana, e.defuncion, 0) as def_2,
			round((if(a.semana=e.semana, e.defuncion, 0) / b.poblacion * 1000),2) as mort_2,
			round((if(a.semana=e.semana, e.defuncion, 0) / b.casos * 100),2) as letal_2,
			ifnull(c.casos,0) as casos_3,
			ifnull(c.poblacion,0) as pob_3,
			ifnull(round((c.casos / c.poblacion) * 100000,2),0) as inc_3,
			ifnull(if(a.semana=f.semana, f.defuncion, 0),0) as def_3,
			round((if(a.semana=f.semana, f.defuncion, 0) / c.poblacion * 1000),2) as mort_3,
			round((if(a.semana=f.semana, f.defuncion, 0) / c.casos * 100),2) as letal_3
			from
			(select ano, semana, sum(ira_m2+ira_2_11+ira_1_4a+neu_2_11+neu_1_4a+ngr_m2+ngr_2_11+ngr_1_4a) as casos,
			(select sum(pobtot) from codubi where ano = $anio-2) as poblacion from iras_ant
			where ano = $anio-2 and e_salud = '".$establec."' group by ano, semana) a
			left join
			(select ano, semana, sum(ira_m2+ira_2_11+ira_1_4a+neu_2_11+neu_1_4a+ngr_m2+ngr_2_11+ngr_1_4a) as casos, (select sum(pobtot) 
			from codubi where ano = $anio-1) as poblacion from iras_ant
			where ano = $anio-1 and e_salud = '".$establec."' group by ano, semana) b
			on a.semana = b.semana
			left join
			(select ano, semana, sum(ira_m2+ira_2_11+ira_1_4a+neu_2_11+neu_1_4a+ngr_m2+ngr_2_11+ngr_1_4a) as casos, (select sum(pobtot) 
			from codubi where ano = $anio) as poblacion from iras
			where ano = $anio and e_salud = '".$establec."' group by ano, semana) c
			on a.semana = c.semana
			left join
			(select ano, semana,  sum(dih_m2+dih_2_11+dih_1_4a+deh_m2+deh_2_11+deh_1_4a) as defuncion from iras_ant
			where ano = $anio-2 and e_salud = '".$establec."' group by ano, semana) d
			on a.semana = d.semana
			left join
			(select ano, semana,  sum(dih_m2+dih_2_11+dih_1_4a+deh_m2+deh_2_11+deh_1_4a) as defuncion from iras_ant
			where ano = $anio-1 and e_salud = '".$establec."' group by ano, semana) e
			on a.semana = e.semana
			left join
			(select ano, semana,  sum(dih_m2+dih_2_11+dih_1_4a+deh_m2+deh_2_11+deh_1_4a) as defuncion from iras
			where ano = $anio and e_salud = '".$establec."' group by ano, semana) f
			on a.semana = f.semana
			group by a.semana			
			";
		}elseif(!empty($diresa) and !empty($red) and !empty($microred) and empty($establec)){
			$plantilla = "
			select a.semana,
			a.casos as casos_1,
			a.poblacion as pob_1,
			round((a.casos / a.poblacion) * 100000,2) as inc_1,
			if(a.semana=d.semana, d.defuncion, 0) as def_1,
			round((if(a.semana=d.semana, d.defuncion, 0) / a.poblacion * 1000),2) as mort_1,
			round((if(a.semana=d.semana, d.defuncion, 0) / a.casos * 100),2) as letal_1,
			b.casos as casos_2,
			b.poblacion as pob_2,
			round((b.casos / b.poblacion) * 100000,2) as inc_2,
			if(a.semana=e.semana, e.defuncion, 0) as def_2,
			round((if(a.semana=e.semana, e.defuncion, 0) / b.poblacion * 1000),2) as mort_2,
			round((if(a.semana=e.semana, e.defuncion, 0) / b.casos * 100),2) as letal_2,
			ifnull(c.casos,0) as casos_3,
			ifnull(c.poblacion,0) as pob_3,
			ifnull(round((c.casos / c.poblacion) * 100000,2),0) as inc_3,
			ifnull(if(a.semana=f.semana, f.defuncion, 0),0) as def_3,
			round((if(a.semana=f.semana, f.defuncion, 0) / c.poblacion * 1000),2) as mort_3,
			round((if(a.semana=f.semana, f.defuncion, 0) / c.casos * 100),2) as letal_3
			from
			(select ano, semana, sum(ira_m2+ira_2_11+ira_1_4a+neu_2_11+neu_1_4a+ngr_m2+ngr_2_11+ngr_1_4a) as casos,
			(select sum(pobtot) from codubi where ano = $anio-2) as poblacion from iras_ant
			where ano = $anio-2 and sub_reg_nt = '".$diresa."' and red = '".$red."' and microred = '".$microred."' 
			group by ano, semana) a
			left join
			(select ano, semana, sum(ira_m2+ira_2_11+ira_1_4a+neu_2_11+neu_1_4a+ngr_m2+ngr_2_11+ngr_1_4a) as casos, (select sum(pobtot) 
			from codubi where ano = $anio-1) as poblacion from iras_ant
			where ano = $anio-1 and sub_reg_nt = '".$diresa."' and red = '".$red."' and microred = '".$microred."' 
			group by ano, semana) b
			on a.semana = b.semana
			left join
			(select ano, semana, sum(ira_m2+ira_2_11+ira_1_4a+neu_2_11+neu_1_4a+ngr_m2+ngr_2_11+ngr_1_4a) as casos, (select sum(pobtot) 
			from codubi where ano = $anio) as poblacion from iras
			where ano = $anio and sub_reg_nt = '".$diresa."' and red = '".$red."' and microred = '".$microred."' 
			group by ano, semana) c
			on a.semana = c.semana
			left join
			(select ano, semana, sum(dih_m2+dih_2_11+dih_1_4a+deh_m2+deh_2_11+deh_1_4a) as defuncion from iras_ant
			where ano = $anio-2 and sub_reg_nt = '".$diresa."' and red = '".$red."' and microred = '".$microred."' group by ano, semana) d
			on a.semana = d.semana
			left join
			(select ano, semana, sum(dih_m2+dih_2_11+dih_1_4a+deh_m2+deh_2_11+deh_1_4a) as defuncion from iras_ant
			where ano = $anio-1 and sub_reg_nt = '".$diresa."' and red = '".$red."' and microred = '".$microred."' group by ano, semana) e
			on a.semana = e.semana
			left join
			(select ano, semana, sum(dih_m2+dih_2_11+dih_1_4a+deh_m2+deh_2_11+deh_1_4a) as defuncion from iras
			where ano = $anio and sub_reg_nt = '".$diresa."' and red = '".$red."' and microred = '".$microred."' group by ano, semana) f
			on a.semana = f.semana
			group by a.semana			
			";
		}elseif(!empty($diresa) and !empty($red) and empty($microred) and empty($establec)){
			$plantilla = "
			select a.semana,
			a.casos as casos_1,
			a.poblacion as pob_1,
			round((a.casos / a.poblacion) * 100000,2) as inc_1,
			if(a.semana=d.semana, d.defuncion, 0) as def_1,
			round((if(a.semana=d.semana, d.defuncion, 0) / a.poblacion * 1000),2) as mort_1,
			round((if(a.semana=d.semana, d.defuncion, 0) / a.casos * 100),2) as letal_1,
			b.casos as casos_2,
			b.poblacion as pob_2,
			round((b.casos / b.poblacion) * 100000,2) as inc_2,
			if(a.semana=e.semana, e.defuncion, 0) as def_2,
			round((if(a.semana=e.semana, e.defuncion, 0) / b.poblacion * 1000),2) as mort_2,
			round((if(a.semana=e.semana, e.defuncion, 0) / b.casos * 100),2) as letal_2,
			ifnull(c.casos,0) as casos_3,
			ifnull(c.poblacion,0) as pob_3,
			ifnull(round((c.casos / c.poblacion) * 100000,2),0) as inc_3,
			ifnull(if(a.semana=f.semana, f.defuncion, 0),0) as def_3,
			round((if(a.semana=f.semana, f.defuncion, 0) / c.poblacion * 1000),2) as mort_3,
			round((if(a.semana=f.semana, f.defuncion, 0) / c.casos * 100),2) as letal_3
			from
			(select ano, semana, sum(ira_m2+ira_2_11+ira_1_4a+neu_2_11+neu_1_4a+ngr_m2+ngr_2_11+ngr_1_4a) as casos,
			(select sum(pobtot) from codubi where ano = $anio-2) as poblacion from iras_ant
			where ano = $anio-2 and sub_reg_nt = '".$diresa."' and red = '".$red."' 
			group by ano, semana) a
			left join
			(select ano, semana, sum(ira_m2+ira_2_11+ira_1_4a+neu_2_11+neu_1_4a+ngr_m2+ngr_2_11+ngr_1_4a) as casos, (select sum(pobtot) 
			from codubi where ano = $anio-1) as poblacion from iras_ant
			where ano = $anio-1 and sub_reg_nt = '".$diresa."' and red = '".$red."'  
			group by ano, semana) b
			on a.semana = b.semana
			left join
			(select ano, semana, sum(ira_m2+ira_2_11+ira_1_4a+neu_2_11+neu_1_4a+ngr_m2+ngr_2_11+ngr_1_4a) as casos, (select sum(pobtot) 
			from codubi where ano = $anio) as poblacion from iras
			where ano = $anio and sub_reg_nt = '".$diresa."' and red = '".$red."' 
			group by ano, semana) c
			on a.semana = c.semana
			left join
			(select ano, semana, sum(dih_m2+dih_2_11+dih_1_4a+deh_m2+deh_2_11+deh_1_4a) as defuncion from iras_ant
			where ano = $anio-2 and sub_reg_nt = '".$diresa."' and red = '".$red."' group by ano, semana) d
			on a.semana = d.semana
			left join
			(select ano, semana, sum(dih_m2+dih_2_11+dih_1_4a+deh_m2+deh_2_11+deh_1_4a) as defuncion from iras_ant
			where ano = $anio-1 and sub_reg_nt = '".$diresa."' and red = '".$red."'
			group by ano, semana) e
			on a.semana = e.semana
			left join
			(select ano, semana, sum(dih_m2+dih_2_11+dih_1_4a+deh_m2+deh_2_11+deh_1_4a) as defuncion from iras
			where ano = $anio and sub_reg_nt = '".$diresa."' and red = '".$red."' group by ano, semana) f
			on a.semana = f.semana
			group by a.semana			
			";
		}elseif(!empty($diresa) and empty($red) and empty($microred) and empty($establec)){
			$plantilla = "
			select a.semana,
			a.casos as casos_1,
			a.poblacion as pob_1,
			round((a.casos / a.poblacion) * 100000,2) as inc_1,
			if(a.semana=d.semana, d.defuncion, 0) as def_1,
			round((if(a.semana=d.semana, d.defuncion, 0) / a.poblacion * 1000),2) as mort_1,
			round((if(a.semana=d.semana, d.defuncion, 0) / a.casos * 100),2) as letal_1,
			b.casos as casos_2,
			b.poblacion as pob_2,
			round((b.casos / b.poblacion) * 100000,2) as inc_2,
			if(a.semana=e.semana, e.defuncion, 0) as def_2,
			round((if(a.semana=e.semana, e.defuncion, 0) / b.poblacion * 1000),2) as mort_2,
			round((if(a.semana=e.semana, e.defuncion, 0) / b.casos * 100),2) as letal_2,
			ifnull(c.casos,0) as casos_3,
			ifnull(c.poblacion,0) as pob_3,
			ifnull(round((c.casos / c.poblacion) * 100000,2),0) as inc_3,
			ifnull(if(a.semana=f.semana, f.defuncion, 0),0) as def_3,
			round((if(a.semana=f.semana, f.defuncion, 0) / c.poblacion * 1000),2) as mort_3,
			round((if(a.semana=f.semana, f.defuncion, 0) / c.casos * 100),2) as letal_3
			from
			(select ano, semana, sum(ira_m2+ira_2_11+ira_1_4a+neu_2_11+neu_1_4a+ngr_m2+ngr_2_11+ngr_1_4a) as casos,
			(select sum(pobtot) from codubi where ano = $anio-2) as poblacion from iras_ant
			where ano = $anio-2 and sub_reg_nt = '".$diresa."' 
			group by ano, semana) a
			left join
			(select ano, semana, sum(ira_m2+ira_2_11+ira_1_4a+neu_2_11+neu_1_4a+ngr_m2+ngr_2_11+ngr_1_4a) as casos, (select sum(pobtot) 
			from codubi where ano = $anio-1) as poblacion from iras_ant
			where ano = $anio-1 and sub_reg_nt = '".$diresa."' 
			group by ano, semana) b
			on a.semana = b.semana
			left join
			(select ano, semana, sum(ira_m2+ira_2_11+ira_1_4a+neu_2_11+neu_1_4a+ngr_m2+ngr_2_11+ngr_1_4a) as casos, (select sum(pobtot) 
			from codubi where ano = $anio) as poblacion from iras
			where ano = $anio and sub_reg_nt = '".$diresa."'
			group by ano, semana) c
			on a.semana = c.semana
			left join
			(select ano, semana, sum(dih_m2+dih_2_11+dih_1_4a+deh_m2+deh_2_11+deh_1_4a) as defuncion from iras_ant
			where ano = $anio-2 and sub_reg_nt = '".$diresa."' group by ano, semana) d
			on a.semana = d.semana
			left join
			(select ano, semana, sum(dih_m2+dih_2_11+dih_1_4a+deh_m2+deh_2_11+deh_1_4a) as defuncion from iras_ant
			where ano = $anio-1 and sub_reg_nt = '".$diresa."'
			group by ano, semana) e
			on a.semana = e.semana
			left join
			(select ano, semana, sum(dih_m2+dih_2_11+dih_1_4a+deh_m2+deh_2_11+deh_1_4a) as defuncion from iras
			where ano = $anio and sub_reg_nt = '".$diresa."' group by ano, semana) f
			on a.semana = f.semana
			group by a.semana			
			";
		}elseif(empty($diresa) and empty($red) and empty($microred) and empty($establec)){
			$plantilla = "
			select a.semana,
			a.casos as casos_1,
			a.poblacion as pob_1,
			round((a.casos / a.poblacion) * 100000,2) as inc_1,
			if(a.semana=d.semana, d.defuncion, 0) as def_1,
			round((if(a.semana=d.semana, d.defuncion, 0) / a.poblacion * 1000),2) as mort_1,
			round((if(a.semana=d.semana, d.defuncion, 0) / a.casos * 100),2) as letal_1,
			b.casos as casos_2,
			b.poblacion as pob_2,
			round((b.casos / b.poblacion) * 100000,2) as inc_2,
			if(a.semana=e.semana, e.defuncion, 0) as def_2,
			round((if(a.semana=e.semana, e.defuncion, 0) / b.poblacion * 1000),2) as mort_2,
			round((if(a.semana=e.semana, e.defuncion, 0) / b.casos * 100),2) as letal_2,
			ifnull(c.casos,0) as casos_3,
			ifnull(c.poblacion,0) as pob_3,
			ifnull(round((c.casos / c.poblacion) * 100000,2),0) as inc_3,
			ifnull(if(a.semana=f.semana, f.defuncion, 0),0) as def_3,
			round((if(a.semana=f.semana, f.defuncion, 0) / c.poblacion * 1000),2) as mort_3,
			round((if(a.semana=f.semana, f.defuncion, 0) / c.casos * 100),2) as letal_3
			from
			(select ano, semana, sum(ira_m2+ira_2_11+ira_1_4a+neu_2_11+neu_1_4a+ngr_m2+ngr_2_11+ngr_1_4a) as casos,
			(select sum(pobtot) from codubi where ano = $anio-2) as poblacion from iras_ant
			where ano = $anio-2 group by ano, semana) a
			left join
			(select ano, semana, sum(ira_m2+ira_2_11+ira_1_4a+neu_2_11+neu_1_4a+ngr_m2+ngr_2_11+ngr_1_4a) as casos, 
			(select sum(pobtot) from codubi where ano = $anio-1) as poblacion from iras_ant
			where ano = $anio-1 group by ano, semana) b
			on a.semana = b.semana
			left join
			(select ano, semana, sum(ira_m2+ira_2_11+ira_1_4a+neu_2_11+neu_1_4a+ngr_m2+ngr_2_11+ngr_1_4a) as casos, 
			(select sum(pobtot) from codubi where ano = $anio) as poblacion from iras
			where ano = $anio group by ano, semana) c
			on a.semana = c.semana
			left join
			(select ano, semana, sum(dih_m2+dih_2_11+dih_1_4a+deh_m2+deh_2_11+deh_1_4a) as defuncion from iras_ant
			where ano = $anio-2 group by ano, semana) d
			on a.semana = d.semana
			left join
			(select ano, semana, sum(dih_m2+dih_2_11+dih_1_4a+deh_m2+deh_2_11+deh_1_4a) as defuncion from iras_ant
			where ano = $anio-1 group by ano, semana) e
			on a.semana = e.semana
			left join
			(select ano, semana, sum(dih_m2+dih_2_11+dih_1_4a+deh_m2+deh_2_11+deh_1_4a) as defuncion from iras
			where ano = $anio group by ano, semana) f
			on a.semana = f.semana
			group by a.semana			
			";
		}
		
		$query = $this->db->query($plantilla);
		
		return $query->result();
		
	}

	//Reporte de la notificación de IRAS en descripción de espacio por nivel de ubigeo
	public function notificacionIraEspacioUbigeo($anio, $departamento, $provincia, $distrito)
	{
		if(!empty($departamento) and !empty($provincia) and !empty($distrito)){
			$plantilla = "
			select b.distrito as nombre,
			ifnull(sum(if(a.semana = 1, a.cantidad, 0)),0) as sem1,
			ifnull(sum(if(a.semana = 2, a.cantidad, 0)),0) as sem2,
			ifnull(sum(if(a.semana = 3, a.cantidad, 0)),0) as sem3,
			ifnull(sum(if(a.semana = 4, a.cantidad, 0)),0) as sem4,
			ifnull(sum(if(a.semana = 5, a.cantidad, 0)),0) as sem5,
			ifnull(sum(if(a.semana = 6, a.cantidad, 0)),0) as sem6,
			ifnull(sum(if(a.semana = 7, a.cantidad, 0)),0) as sem7,
			ifnull(sum(if(a.semana = 8, a.cantidad, 0)),0) as sem8,
			ifnull(sum(if(a.semana = 9, a.cantidad, 0)),0) as sem9,
			ifnull(sum(if(a.semana = 10, a.cantidad, 0)),0) as sem10,
			ifnull(sum(if(a.semana = 11, a.cantidad, 0)),0) as sem11,
			ifnull(sum(if(a.semana = 12, a.cantidad, 0)),0) as sem12,
			ifnull(sum(if(a.semana = 13, a.cantidad, 0)),0) as sem13,
			ifnull(sum(if(a.semana = 14, a.cantidad, 0)),0) as sem14,
			ifnull(sum(if(a.semana = 15, a.cantidad, 0)),0) as sem15,
			ifnull(sum(if(a.semana = 16, a.cantidad, 0)),0) as sem16,
			ifnull(sum(if(a.semana = 17, a.cantidad, 0)),0) as sem17,
			ifnull(sum(if(a.semana = 18, a.cantidad, 0)),0) as sem18,
			ifnull(sum(if(a.semana = 19, a.cantidad, 0)),0) as sem19,
			ifnull(sum(if(a.semana = 20, a.cantidad, 0)),0) as sem20,
			ifnull(sum(if(a.semana = 21, a.cantidad, 0)),0) as sem21,
			ifnull(sum(if(a.semana = 22, a.cantidad, 0)),0) as sem22,
			ifnull(sum(if(a.semana = 23, a.cantidad, 0)),0) as sem23,
			ifnull(sum(if(a.semana = 24, a.cantidad, 0)),0) as sem24,
			ifnull(sum(if(a.semana = 25, a.cantidad, 0)),0) as sem25,
			ifnull(sum(if(a.semana = 26, a.cantidad, 0)),0) as sem26,
			ifnull(sum(if(a.semana = 27, a.cantidad, 0)),0) as sem27,
			ifnull(sum(if(a.semana = 28, a.cantidad, 0)),0) as sem28,
			ifnull(sum(if(a.semana = 29, a.cantidad, 0)),0) as sem29,
			ifnull(sum(if(a.semana = 30, a.cantidad, 0)),0) as sem30,
			ifnull(sum(if(a.semana = 31, a.cantidad, 0)),0) as sem31,
			ifnull(sum(if(a.semana = 32, a.cantidad, 0)),0) as sem32,
			ifnull(sum(if(a.semana = 33, a.cantidad, 0)),0) as sem33,
			ifnull(sum(if(a.semana = 34, a.cantidad, 0)),0) as sem34,
			ifnull(sum(if(a.semana = 35, a.cantidad, 0)),0) as sem35,
			ifnull(sum(if(a.semana = 36, a.cantidad, 0)),0) as sem36,
			ifnull(sum(if(a.semana = 37, a.cantidad, 0)),0) as sem37,
			ifnull(sum(if(a.semana = 38, a.cantidad, 0)),0) as sem38,
			ifnull(sum(if(a.semana = 39, a.cantidad, 0)),0) as sem39,
			ifnull(sum(if(a.semana = 40, a.cantidad, 0)),0) as sem40,
			ifnull(sum(if(a.semana = 41, a.cantidad, 0)),0) as sem41,
			ifnull(sum(if(a.semana = 42, a.cantidad, 0)),0) as sem42,
			ifnull(sum(if(a.semana = 43, a.cantidad, 0)),0) as sem43,
			ifnull(sum(if(a.semana = 44, a.cantidad, 0)),0) as sem44,
			ifnull(sum(if(a.semana = 45, a.cantidad, 0)),0) as sem45,
			ifnull(sum(if(a.semana = 46, a.cantidad, 0)),0) as sem46,
			ifnull(sum(if(a.semana = 47, a.cantidad, 0)),0) as sem47,
			ifnull(sum(if(a.semana = 48, a.cantidad, 0)),0) as sem48,
			ifnull(sum(if(a.semana = 49, a.cantidad, 0)),0) as sem49,
			ifnull(sum(if(a.semana = 50, a.cantidad, 0)),0) as sem50,
			ifnull(sum(if(a.semana = 51, a.cantidad, 0)),0) as sem51,
			ifnull(sum(if(a.semana = 52, a.cantidad, 0)),0) as sem52,
			ifnull(sum(if(a.semana = 53, a.cantidad, 0)),0) as sem53
			from
			codubi b
			left join
			(select ubigeo, semana, sum(ira_m2+ira_2_11+ira_1_4a+neu_2_11+neu_1_4a+ngr_m2+ngr_2_11+ngr_1_4a) as cantidad 
			from iras
			where ano = $anio and ubigeo = '".$distrito."' and ubigeo <> '' 
			group by ubigeo, semana) a
			on b.ubigeo = a.ubigeo
			where b.ano = $anio and a.ubigeo = '".$distrito."' 
			group by b.distrito
			";
		}elseif(!empty($departamento) and !empty($provincia) and empty($distrito)){
			$plantilla = "
			select b.distrito as nombre,
			ifnull(sum(if(a.semana = 1, a.cantidad, 0)),0) as sem1,
			ifnull(sum(if(a.semana = 2, a.cantidad, 0)),0) as sem2,
			ifnull(sum(if(a.semana = 3, a.cantidad, 0)),0) as sem3,
			ifnull(sum(if(a.semana = 4, a.cantidad, 0)),0) as sem4,
			ifnull(sum(if(a.semana = 5, a.cantidad, 0)),0) as sem5,
			ifnull(sum(if(a.semana = 6, a.cantidad, 0)),0) as sem6,
			ifnull(sum(if(a.semana = 7, a.cantidad, 0)),0) as sem7,
			ifnull(sum(if(a.semana = 8, a.cantidad, 0)),0) as sem8,
			ifnull(sum(if(a.semana = 9, a.cantidad, 0)),0) as sem9,
			ifnull(sum(if(a.semana = 10, a.cantidad, 0)),0) as sem10,
			ifnull(sum(if(a.semana = 11, a.cantidad, 0)),0) as sem11,
			ifnull(sum(if(a.semana = 12, a.cantidad, 0)),0) as sem12,
			ifnull(sum(if(a.semana = 13, a.cantidad, 0)),0) as sem13,
			ifnull(sum(if(a.semana = 14, a.cantidad, 0)),0) as sem14,
			ifnull(sum(if(a.semana = 15, a.cantidad, 0)),0) as sem15,
			ifnull(sum(if(a.semana = 16, a.cantidad, 0)),0) as sem16,
			ifnull(sum(if(a.semana = 17, a.cantidad, 0)),0) as sem17,
			ifnull(sum(if(a.semana = 18, a.cantidad, 0)),0) as sem18,
			ifnull(sum(if(a.semana = 19, a.cantidad, 0)),0) as sem19,
			ifnull(sum(if(a.semana = 20, a.cantidad, 0)),0) as sem20,
			ifnull(sum(if(a.semana = 21, a.cantidad, 0)),0) as sem21,
			ifnull(sum(if(a.semana = 22, a.cantidad, 0)),0) as sem22,
			ifnull(sum(if(a.semana = 23, a.cantidad, 0)),0) as sem23,
			ifnull(sum(if(a.semana = 24, a.cantidad, 0)),0) as sem24,
			ifnull(sum(if(a.semana = 25, a.cantidad, 0)),0) as sem25,
			ifnull(sum(if(a.semana = 26, a.cantidad, 0)),0) as sem26,
			ifnull(sum(if(a.semana = 27, a.cantidad, 0)),0) as sem27,
			ifnull(sum(if(a.semana = 28, a.cantidad, 0)),0) as sem28,
			ifnull(sum(if(a.semana = 29, a.cantidad, 0)),0) as sem29,
			ifnull(sum(if(a.semana = 30, a.cantidad, 0)),0) as sem30,
			ifnull(sum(if(a.semana = 31, a.cantidad, 0)),0) as sem31,
			ifnull(sum(if(a.semana = 32, a.cantidad, 0)),0) as sem32,
			ifnull(sum(if(a.semana = 33, a.cantidad, 0)),0) as sem33,
			ifnull(sum(if(a.semana = 34, a.cantidad, 0)),0) as sem34,
			ifnull(sum(if(a.semana = 35, a.cantidad, 0)),0) as sem35,
			ifnull(sum(if(a.semana = 36, a.cantidad, 0)),0) as sem36,
			ifnull(sum(if(a.semana = 37, a.cantidad, 0)),0) as sem37,
			ifnull(sum(if(a.semana = 38, a.cantidad, 0)),0) as sem38,
			ifnull(sum(if(a.semana = 39, a.cantidad, 0)),0) as sem39,
			ifnull(sum(if(a.semana = 40, a.cantidad, 0)),0) as sem40,
			ifnull(sum(if(a.semana = 41, a.cantidad, 0)),0) as sem41,
			ifnull(sum(if(a.semana = 42, a.cantidad, 0)),0) as sem42,
			ifnull(sum(if(a.semana = 43, a.cantidad, 0)),0) as sem43,
			ifnull(sum(if(a.semana = 44, a.cantidad, 0)),0) as sem44,
			ifnull(sum(if(a.semana = 45, a.cantidad, 0)),0) as sem45,
			ifnull(sum(if(a.semana = 46, a.cantidad, 0)),0) as sem46,
			ifnull(sum(if(a.semana = 47, a.cantidad, 0)),0) as sem47,
			ifnull(sum(if(a.semana = 48, a.cantidad, 0)),0) as sem48,
			ifnull(sum(if(a.semana = 49, a.cantidad, 0)),0) as sem49,
			ifnull(sum(if(a.semana = 50, a.cantidad, 0)),0) as sem50,
			ifnull(sum(if(a.semana = 51, a.cantidad, 0)),0) as sem51,
			ifnull(sum(if(a.semana = 52, a.cantidad, 0)),0) as sem52,
			ifnull(sum(if(a.semana = 53, a.cantidad, 0)),0) as sem53
			from
			codubi b
			left join
			(select ubigeo, semana, sum(ira_m2+ira_2_11+ira_1_4a+neu_2_11+neu_1_4a+ngr_m2+ngr_2_11+ngr_1_4a) as cantidad 
			from iras
			where ano = $anio and substr(ubigeo,1,4) = '".$provincia."' and ubigeo <> '' 
			group by ubigeo, semana) a
			on b.ubigeo = a.ubigeo
			where b.ano = $anio and substr(a.ubigeo,1,4) = '".$provincia."' 
			group by b.distrito
			";
		}elseif(!empty($departamento) and empty($provincia) and empty($distrito)){
			$plantilla = "
			select b.provincia as nombre,
			ifnull(sum(if(a.semana = 1, a.cantidad, 0)),0) as sem1,
			ifnull(sum(if(a.semana = 2, a.cantidad, 0)),0) as sem2,
			ifnull(sum(if(a.semana = 3, a.cantidad, 0)),0) as sem3,
			ifnull(sum(if(a.semana = 4, a.cantidad, 0)),0) as sem4,
			ifnull(sum(if(a.semana = 5, a.cantidad, 0)),0) as sem5,
			ifnull(sum(if(a.semana = 6, a.cantidad, 0)),0) as sem6,
			ifnull(sum(if(a.semana = 7, a.cantidad, 0)),0) as sem7,
			ifnull(sum(if(a.semana = 8, a.cantidad, 0)),0) as sem8,
			ifnull(sum(if(a.semana = 9, a.cantidad, 0)),0) as sem9,
			ifnull(sum(if(a.semana = 10, a.cantidad, 0)),0) as sem10,
			ifnull(sum(if(a.semana = 11, a.cantidad, 0)),0) as sem11,
			ifnull(sum(if(a.semana = 12, a.cantidad, 0)),0) as sem12,
			ifnull(sum(if(a.semana = 13, a.cantidad, 0)),0) as sem13,
			ifnull(sum(if(a.semana = 14, a.cantidad, 0)),0) as sem14,
			ifnull(sum(if(a.semana = 15, a.cantidad, 0)),0) as sem15,
			ifnull(sum(if(a.semana = 16, a.cantidad, 0)),0) as sem16,
			ifnull(sum(if(a.semana = 17, a.cantidad, 0)),0) as sem17,
			ifnull(sum(if(a.semana = 18, a.cantidad, 0)),0) as sem18,
			ifnull(sum(if(a.semana = 19, a.cantidad, 0)),0) as sem19,
			ifnull(sum(if(a.semana = 20, a.cantidad, 0)),0) as sem20,
			ifnull(sum(if(a.semana = 21, a.cantidad, 0)),0) as sem21,
			ifnull(sum(if(a.semana = 22, a.cantidad, 0)),0) as sem22,
			ifnull(sum(if(a.semana = 23, a.cantidad, 0)),0) as sem23,
			ifnull(sum(if(a.semana = 24, a.cantidad, 0)),0) as sem24,
			ifnull(sum(if(a.semana = 25, a.cantidad, 0)),0) as sem25,
			ifnull(sum(if(a.semana = 26, a.cantidad, 0)),0) as sem26,
			ifnull(sum(if(a.semana = 27, a.cantidad, 0)),0) as sem27,
			ifnull(sum(if(a.semana = 28, a.cantidad, 0)),0) as sem28,
			ifnull(sum(if(a.semana = 29, a.cantidad, 0)),0) as sem29,
			ifnull(sum(if(a.semana = 30, a.cantidad, 0)),0) as sem30,
			ifnull(sum(if(a.semana = 31, a.cantidad, 0)),0) as sem31,
			ifnull(sum(if(a.semana = 32, a.cantidad, 0)),0) as sem32,
			ifnull(sum(if(a.semana = 33, a.cantidad, 0)),0) as sem33,
			ifnull(sum(if(a.semana = 34, a.cantidad, 0)),0) as sem34,
			ifnull(sum(if(a.semana = 35, a.cantidad, 0)),0) as sem35,
			ifnull(sum(if(a.semana = 36, a.cantidad, 0)),0) as sem36,
			ifnull(sum(if(a.semana = 37, a.cantidad, 0)),0) as sem37,
			ifnull(sum(if(a.semana = 38, a.cantidad, 0)),0) as sem38,
			ifnull(sum(if(a.semana = 39, a.cantidad, 0)),0) as sem39,
			ifnull(sum(if(a.semana = 40, a.cantidad, 0)),0) as sem40,
			ifnull(sum(if(a.semana = 41, a.cantidad, 0)),0) as sem41,
			ifnull(sum(if(a.semana = 42, a.cantidad, 0)),0) as sem42,
			ifnull(sum(if(a.semana = 43, a.cantidad, 0)),0) as sem43,
			ifnull(sum(if(a.semana = 44, a.cantidad, 0)),0) as sem44,
			ifnull(sum(if(a.semana = 45, a.cantidad, 0)),0) as sem45,
			ifnull(sum(if(a.semana = 46, a.cantidad, 0)),0) as sem46,
			ifnull(sum(if(a.semana = 47, a.cantidad, 0)),0) as sem47,
			ifnull(sum(if(a.semana = 48, a.cantidad, 0)),0) as sem48,
			ifnull(sum(if(a.semana = 49, a.cantidad, 0)),0) as sem49,
			ifnull(sum(if(a.semana = 50, a.cantidad, 0)),0) as sem50,
			ifnull(sum(if(a.semana = 51, a.cantidad, 0)),0) as sem51,
			ifnull(sum(if(a.semana = 52, a.cantidad, 0)),0) as sem52,
			ifnull(sum(if(a.semana = 53, a.cantidad, 0)),0) as sem53
			from
			codubi b
			left join
			(select ubigeo, semana, sum(ira_m2+ira_2_11+ira_1_4a+neu_2_11+neu_1_4a+ngr_m2+ngr_2_11+ngr_1_4a) as cantidad 
			from iras
			where ano = $anio and substr(ubigeo,1,2) = '".$departamento."' and ubigeo <> '' 
			group by ubigeo, semana) a
			on b.ubigeo = a.ubigeo
			where b.ano = $anio and substr(a.ubigeo,1,2) = '".$departamento."' 
			group by b.provincia
			";
		}elseif(empty($departamento) and empty($provincia) and empty($distrito)){
			if($this->session->userdata('nivel') == '1' or $this->session->userdata('nivel') == '4'){
				$plantilla = "
				select b.departam as nombre,
				ifnull(sum(if(a.semana = 1, a.cantidad, 0)),0) as sem1,
				ifnull(sum(if(a.semana = 2, a.cantidad, 0)),0) as sem2,
				ifnull(sum(if(a.semana = 3, a.cantidad, 0)),0) as sem3,
				ifnull(sum(if(a.semana = 4, a.cantidad, 0)),0) as sem4,
				ifnull(sum(if(a.semana = 5, a.cantidad, 0)),0) as sem5,
				ifnull(sum(if(a.semana = 6, a.cantidad, 0)),0) as sem6,
				ifnull(sum(if(a.semana = 7, a.cantidad, 0)),0) as sem7,
				ifnull(sum(if(a.semana = 8, a.cantidad, 0)),0) as sem8,
				ifnull(sum(if(a.semana = 9, a.cantidad, 0)),0) as sem9,
				ifnull(sum(if(a.semana = 10, a.cantidad, 0)),0) as sem10,
				ifnull(sum(if(a.semana = 11, a.cantidad, 0)),0) as sem11,
				ifnull(sum(if(a.semana = 12, a.cantidad, 0)),0) as sem12,
				ifnull(sum(if(a.semana = 13, a.cantidad, 0)),0) as sem13,
				ifnull(sum(if(a.semana = 14, a.cantidad, 0)),0) as sem14,
				ifnull(sum(if(a.semana = 15, a.cantidad, 0)),0) as sem15,
				ifnull(sum(if(a.semana = 16, a.cantidad, 0)),0) as sem16,
				ifnull(sum(if(a.semana = 17, a.cantidad, 0)),0) as sem17,
				ifnull(sum(if(a.semana = 18, a.cantidad, 0)),0) as sem18,
				ifnull(sum(if(a.semana = 19, a.cantidad, 0)),0) as sem19,
				ifnull(sum(if(a.semana = 20, a.cantidad, 0)),0) as sem20,
				ifnull(sum(if(a.semana = 21, a.cantidad, 0)),0) as sem21,
				ifnull(sum(if(a.semana = 22, a.cantidad, 0)),0) as sem22,
				ifnull(sum(if(a.semana = 23, a.cantidad, 0)),0) as sem23,
				ifnull(sum(if(a.semana = 24, a.cantidad, 0)),0) as sem24,
				ifnull(sum(if(a.semana = 25, a.cantidad, 0)),0) as sem25,
				ifnull(sum(if(a.semana = 26, a.cantidad, 0)),0) as sem26,
				ifnull(sum(if(a.semana = 27, a.cantidad, 0)),0) as sem27,
				ifnull(sum(if(a.semana = 28, a.cantidad, 0)),0) as sem28,
				ifnull(sum(if(a.semana = 29, a.cantidad, 0)),0) as sem29,
				ifnull(sum(if(a.semana = 30, a.cantidad, 0)),0) as sem30,
				ifnull(sum(if(a.semana = 31, a.cantidad, 0)),0) as sem31,
				ifnull(sum(if(a.semana = 32, a.cantidad, 0)),0) as sem32,
				ifnull(sum(if(a.semana = 33, a.cantidad, 0)),0) as sem33,
				ifnull(sum(if(a.semana = 34, a.cantidad, 0)),0) as sem34,
				ifnull(sum(if(a.semana = 35, a.cantidad, 0)),0) as sem35,
				ifnull(sum(if(a.semana = 36, a.cantidad, 0)),0) as sem36,
				ifnull(sum(if(a.semana = 37, a.cantidad, 0)),0) as sem37,
				ifnull(sum(if(a.semana = 38, a.cantidad, 0)),0) as sem38,
				ifnull(sum(if(a.semana = 39, a.cantidad, 0)),0) as sem39,
				ifnull(sum(if(a.semana = 40, a.cantidad, 0)),0) as sem40,
				ifnull(sum(if(a.semana = 41, a.cantidad, 0)),0) as sem41,
				ifnull(sum(if(a.semana = 42, a.cantidad, 0)),0) as sem42,
				ifnull(sum(if(a.semana = 43, a.cantidad, 0)),0) as sem43,
				ifnull(sum(if(a.semana = 44, a.cantidad, 0)),0) as sem44,
				ifnull(sum(if(a.semana = 45, a.cantidad, 0)),0) as sem45,
				ifnull(sum(if(a.semana = 46, a.cantidad, 0)),0) as sem46,
				ifnull(sum(if(a.semana = 47, a.cantidad, 0)),0) as sem47,
				ifnull(sum(if(a.semana = 48, a.cantidad, 0)),0) as sem48,
				ifnull(sum(if(a.semana = 49, a.cantidad, 0)),0) as sem49,
				ifnull(sum(if(a.semana = 50, a.cantidad, 0)),0) as sem50,
				ifnull(sum(if(a.semana = 51, a.cantidad, 0)),0) as sem51,
				ifnull(sum(if(a.semana = 52, a.cantidad, 0)),0) as sem52,
				ifnull(sum(if(a.semana = 53, a.cantidad, 0)),0) as sem53
				from
				codubi b
				left join
				(select ubigeo, semana, sum(ira_m2+ira_2_11+ira_1_4a+neu_2_11+neu_1_4a+ngr_m2+ngr_2_11+ngr_1_4a) as cantidad 
				from iras
				where ano = $anio and ubigeo <> ''
				group by ubigeo, semana) a
				on b.ubigeo = a.ubigeo
				where b.ano = $anio
				group by b.departam
				";
			}else{
				$this->session->set_flashdata('error', 'Debe elegir alg&uacute;n nivel de proceso, este reporte no est&aacute; activo para su nivel de usuario, comun&iacute;quese a notificacion@dge.gob.pe');
				redirect(site_url("reportes/repIras"), 301);
			}
		}
		
		$query = $this->db->query($plantilla);
		
		return $query->result();
		
	}

	//Reporte de la notificación de IRAS en descripción de espacio por nivel de EESS
	public function notificacionIraEspacioEESS($anio, $diresa, $red, $microred, $establec)
	{
		if(!empty($diresa) and !empty($red) and !empty($microred) and !empty($establec)){
			$plantilla = "
			select b.raz_soc as nombre,
			ifnull(sum(if(a.semana = 1, a.cantidad, 0)),0) as sem1,
			ifnull(sum(if(a.semana = 2, a.cantidad, 0)),0) as sem2,
			ifnull(sum(if(a.semana = 3, a.cantidad, 0)),0) as sem3,
			ifnull(sum(if(a.semana = 4, a.cantidad, 0)),0) as sem4,
			ifnull(sum(if(a.semana = 5, a.cantidad, 0)),0) as sem5,
			ifnull(sum(if(a.semana = 6, a.cantidad, 0)),0) as sem6,
			ifnull(sum(if(a.semana = 7, a.cantidad, 0)),0) as sem7,
			ifnull(sum(if(a.semana = 8, a.cantidad, 0)),0) as sem8,
			ifnull(sum(if(a.semana = 9, a.cantidad, 0)),0) as sem9,
			ifnull(sum(if(a.semana = 10, a.cantidad, 0)),0) as sem10,
			ifnull(sum(if(a.semana = 11, a.cantidad, 0)),0) as sem11,
			ifnull(sum(if(a.semana = 12, a.cantidad, 0)),0) as sem12,
			ifnull(sum(if(a.semana = 13, a.cantidad, 0)),0) as sem13,
			ifnull(sum(if(a.semana = 14, a.cantidad, 0)),0) as sem14,
			ifnull(sum(if(a.semana = 15, a.cantidad, 0)),0) as sem15,
			ifnull(sum(if(a.semana = 16, a.cantidad, 0)),0) as sem16,
			ifnull(sum(if(a.semana = 17, a.cantidad, 0)),0) as sem17,
			ifnull(sum(if(a.semana = 18, a.cantidad, 0)),0) as sem18,
			ifnull(sum(if(a.semana = 19, a.cantidad, 0)),0) as sem19,
			ifnull(sum(if(a.semana = 20, a.cantidad, 0)),0) as sem20,
			ifnull(sum(if(a.semana = 21, a.cantidad, 0)),0) as sem21,
			ifnull(sum(if(a.semana = 22, a.cantidad, 0)),0) as sem22,
			ifnull(sum(if(a.semana = 23, a.cantidad, 0)),0) as sem23,
			ifnull(sum(if(a.semana = 24, a.cantidad, 0)),0) as sem24,
			ifnull(sum(if(a.semana = 25, a.cantidad, 0)),0) as sem25,
			ifnull(sum(if(a.semana = 26, a.cantidad, 0)),0) as sem26,
			ifnull(sum(if(a.semana = 27, a.cantidad, 0)),0) as sem27,
			ifnull(sum(if(a.semana = 28, a.cantidad, 0)),0) as sem28,
			ifnull(sum(if(a.semana = 29, a.cantidad, 0)),0) as sem29,
			ifnull(sum(if(a.semana = 30, a.cantidad, 0)),0) as sem30,
			ifnull(sum(if(a.semana = 31, a.cantidad, 0)),0) as sem31,
			ifnull(sum(if(a.semana = 32, a.cantidad, 0)),0) as sem32,
			ifnull(sum(if(a.semana = 33, a.cantidad, 0)),0) as sem33,
			ifnull(sum(if(a.semana = 34, a.cantidad, 0)),0) as sem34,
			ifnull(sum(if(a.semana = 35, a.cantidad, 0)),0) as sem35,
			ifnull(sum(if(a.semana = 36, a.cantidad, 0)),0) as sem36,
			ifnull(sum(if(a.semana = 37, a.cantidad, 0)),0) as sem37,
			ifnull(sum(if(a.semana = 38, a.cantidad, 0)),0) as sem38,
			ifnull(sum(if(a.semana = 39, a.cantidad, 0)),0) as sem39,
			ifnull(sum(if(a.semana = 40, a.cantidad, 0)),0) as sem40,
			ifnull(sum(if(a.semana = 41, a.cantidad, 0)),0) as sem41,
			ifnull(sum(if(a.semana = 42, a.cantidad, 0)),0) as sem42,
			ifnull(sum(if(a.semana = 43, a.cantidad, 0)),0) as sem43,
			ifnull(sum(if(a.semana = 44, a.cantidad, 0)),0) as sem44,
			ifnull(sum(if(a.semana = 45, a.cantidad, 0)),0) as sem45,
			ifnull(sum(if(a.semana = 46, a.cantidad, 0)),0) as sem46,
			ifnull(sum(if(a.semana = 47, a.cantidad, 0)),0) as sem47,
			ifnull(sum(if(a.semana = 48, a.cantidad, 0)),0) as sem48,
			ifnull(sum(if(a.semana = 49, a.cantidad, 0)),0) as sem49,
			ifnull(sum(if(a.semana = 50, a.cantidad, 0)),0) as sem50,
			ifnull(sum(if(a.semana = 51, a.cantidad, 0)),0) as sem51,
			ifnull(sum(if(a.semana = 52, a.cantidad, 0)),0) as sem52,
			ifnull(sum(if(a.semana = 53, a.cantidad, 0)),0) as sem53
			from
			renace b
			left join
			(select e_salud, semana, sum(ira_m2+ira_2_11+ira_1_4a+neu_2_11+neu_1_4a+ngr_m2+ngr_2_11+ngr_1_4a) as cantidad 
			from iras
			where ano = $anio and e_salud = '".$establec."'
			group by e_salud, semana) a
			on b.cod_est = a.e_salud
			where a.e_salud = '".$establec."' 
			group by b.raz_soc
			";
		}elseif(!empty($diresa) and !empty($red) and !empty($microred) and empty($establec)){
			$plantilla = "
			select b.raz_soc as nombre,
			ifnull(sum(if(a.semana = 1, a.cantidad, 0)),0) as sem1,
			ifnull(sum(if(a.semana = 2, a.cantidad, 0)),0) as sem2,
			ifnull(sum(if(a.semana = 3, a.cantidad, 0)),0) as sem3,
			ifnull(sum(if(a.semana = 4, a.cantidad, 0)),0) as sem4,
			ifnull(sum(if(a.semana = 5, a.cantidad, 0)),0) as sem5,
			ifnull(sum(if(a.semana = 6, a.cantidad, 0)),0) as sem6,
			ifnull(sum(if(a.semana = 7, a.cantidad, 0)),0) as sem7,
			ifnull(sum(if(a.semana = 8, a.cantidad, 0)),0) as sem8,
			ifnull(sum(if(a.semana = 9, a.cantidad, 0)),0) as sem9,
			ifnull(sum(if(a.semana = 10, a.cantidad, 0)),0) as sem10,
			ifnull(sum(if(a.semana = 11, a.cantidad, 0)),0) as sem11,
			ifnull(sum(if(a.semana = 12, a.cantidad, 0)),0) as sem12,
			ifnull(sum(if(a.semana = 13, a.cantidad, 0)),0) as sem13,
			ifnull(sum(if(a.semana = 14, a.cantidad, 0)),0) as sem14,
			ifnull(sum(if(a.semana = 15, a.cantidad, 0)),0) as sem15,
			ifnull(sum(if(a.semana = 16, a.cantidad, 0)),0) as sem16,
			ifnull(sum(if(a.semana = 17, a.cantidad, 0)),0) as sem17,
			ifnull(sum(if(a.semana = 18, a.cantidad, 0)),0) as sem18,
			ifnull(sum(if(a.semana = 19, a.cantidad, 0)),0) as sem19,
			ifnull(sum(if(a.semana = 20, a.cantidad, 0)),0) as sem20,
			ifnull(sum(if(a.semana = 21, a.cantidad, 0)),0) as sem21,
			ifnull(sum(if(a.semana = 22, a.cantidad, 0)),0) as sem22,
			ifnull(sum(if(a.semana = 23, a.cantidad, 0)),0) as sem23,
			ifnull(sum(if(a.semana = 24, a.cantidad, 0)),0) as sem24,
			ifnull(sum(if(a.semana = 25, a.cantidad, 0)),0) as sem25,
			ifnull(sum(if(a.semana = 26, a.cantidad, 0)),0) as sem26,
			ifnull(sum(if(a.semana = 27, a.cantidad, 0)),0) as sem27,
			ifnull(sum(if(a.semana = 28, a.cantidad, 0)),0) as sem28,
			ifnull(sum(if(a.semana = 29, a.cantidad, 0)),0) as sem29,
			ifnull(sum(if(a.semana = 30, a.cantidad, 0)),0) as sem30,
			ifnull(sum(if(a.semana = 31, a.cantidad, 0)),0) as sem31,
			ifnull(sum(if(a.semana = 32, a.cantidad, 0)),0) as sem32,
			ifnull(sum(if(a.semana = 33, a.cantidad, 0)),0) as sem33,
			ifnull(sum(if(a.semana = 34, a.cantidad, 0)),0) as sem34,
			ifnull(sum(if(a.semana = 35, a.cantidad, 0)),0) as sem35,
			ifnull(sum(if(a.semana = 36, a.cantidad, 0)),0) as sem36,
			ifnull(sum(if(a.semana = 37, a.cantidad, 0)),0) as sem37,
			ifnull(sum(if(a.semana = 38, a.cantidad, 0)),0) as sem38,
			ifnull(sum(if(a.semana = 39, a.cantidad, 0)),0) as sem39,
			ifnull(sum(if(a.semana = 40, a.cantidad, 0)),0) as sem40,
			ifnull(sum(if(a.semana = 41, a.cantidad, 0)),0) as sem41,
			ifnull(sum(if(a.semana = 42, a.cantidad, 0)),0) as sem42,
			ifnull(sum(if(a.semana = 43, a.cantidad, 0)),0) as sem43,
			ifnull(sum(if(a.semana = 44, a.cantidad, 0)),0) as sem44,
			ifnull(sum(if(a.semana = 45, a.cantidad, 0)),0) as sem45,
			ifnull(sum(if(a.semana = 46, a.cantidad, 0)),0) as sem46,
			ifnull(sum(if(a.semana = 47, a.cantidad, 0)),0) as sem47,
			ifnull(sum(if(a.semana = 48, a.cantidad, 0)),0) as sem48,
			ifnull(sum(if(a.semana = 49, a.cantidad, 0)),0) as sem49,
			ifnull(sum(if(a.semana = 50, a.cantidad, 0)),0) as sem50,
			ifnull(sum(if(a.semana = 51, a.cantidad, 0)),0) as sem51,
			ifnull(sum(if(a.semana = 52, a.cantidad, 0)),0) as sem52,
			ifnull(sum(if(a.semana = 53, a.cantidad, 0)),0) as sem53
			from
			renace b
			left join
			(select e_salud, semana, sum(ira_m2+ira_2_11+ira_1_4a+neu_2_11+neu_1_4a+ngr_m2+ngr_2_11+ngr_1_4a) as cantidad 
			from iras
			where ano = $anio and sub_reg_nt = '".$diresa."'
			and red = '".$red."' and microred = '".$microred."' 
			group by e_salud, semana) a
			on b.cod_est = a.e_salud
			where b.subregion = '".$diresa."' and b.red = '".$red."' and microred = '".$microred."' and b.estado = '1'
			group by b.raz_soc
			";
		}elseif(!empty($diresa) and !empty($red) and empty($microred) and empty($establec)){
			$plantilla = "
			select b.nombre,
			ifnull(sum(if(a.semana = 1, a.cantidad, 0)),0) as sem1,
			ifnull(sum(if(a.semana = 2, a.cantidad, 0)),0) as sem2,
			ifnull(sum(if(a.semana = 3, a.cantidad, 0)),0) as sem3,
			ifnull(sum(if(a.semana = 4, a.cantidad, 0)),0) as sem4,
			ifnull(sum(if(a.semana = 5, a.cantidad, 0)),0) as sem5,
			ifnull(sum(if(a.semana = 6, a.cantidad, 0)),0) as sem6,
			ifnull(sum(if(a.semana = 7, a.cantidad, 0)),0) as sem7,
			ifnull(sum(if(a.semana = 8, a.cantidad, 0)),0) as sem8,
			ifnull(sum(if(a.semana = 9, a.cantidad, 0)),0) as sem9,
			ifnull(sum(if(a.semana = 10, a.cantidad, 0)),0) as sem10,
			ifnull(sum(if(a.semana = 11, a.cantidad, 0)),0) as sem11,
			ifnull(sum(if(a.semana = 12, a.cantidad, 0)),0) as sem12,
			ifnull(sum(if(a.semana = 13, a.cantidad, 0)),0) as sem13,
			ifnull(sum(if(a.semana = 14, a.cantidad, 0)),0) as sem14,
			ifnull(sum(if(a.semana = 15, a.cantidad, 0)),0) as sem15,
			ifnull(sum(if(a.semana = 16, a.cantidad, 0)),0) as sem16,
			ifnull(sum(if(a.semana = 17, a.cantidad, 0)),0) as sem17,
			ifnull(sum(if(a.semana = 18, a.cantidad, 0)),0) as sem18,
			ifnull(sum(if(a.semana = 19, a.cantidad, 0)),0) as sem19,
			ifnull(sum(if(a.semana = 20, a.cantidad, 0)),0) as sem20,
			ifnull(sum(if(a.semana = 21, a.cantidad, 0)),0) as sem21,
			ifnull(sum(if(a.semana = 22, a.cantidad, 0)),0) as sem22,
			ifnull(sum(if(a.semana = 23, a.cantidad, 0)),0) as sem23,
			ifnull(sum(if(a.semana = 24, a.cantidad, 0)),0) as sem24,
			ifnull(sum(if(a.semana = 25, a.cantidad, 0)),0) as sem25,
			ifnull(sum(if(a.semana = 26, a.cantidad, 0)),0) as sem26,
			ifnull(sum(if(a.semana = 27, a.cantidad, 0)),0) as sem27,
			ifnull(sum(if(a.semana = 28, a.cantidad, 0)),0) as sem28,
			ifnull(sum(if(a.semana = 29, a.cantidad, 0)),0) as sem29,
			ifnull(sum(if(a.semana = 30, a.cantidad, 0)),0) as sem30,
			ifnull(sum(if(a.semana = 31, a.cantidad, 0)),0) as sem31,
			ifnull(sum(if(a.semana = 32, a.cantidad, 0)),0) as sem32,
			ifnull(sum(if(a.semana = 33, a.cantidad, 0)),0) as sem33,
			ifnull(sum(if(a.semana = 34, a.cantidad, 0)),0) as sem34,
			ifnull(sum(if(a.semana = 35, a.cantidad, 0)),0) as sem35,
			ifnull(sum(if(a.semana = 36, a.cantidad, 0)),0) as sem36,
			ifnull(sum(if(a.semana = 37, a.cantidad, 0)),0) as sem37,
			ifnull(sum(if(a.semana = 38, a.cantidad, 0)),0) as sem38,
			ifnull(sum(if(a.semana = 39, a.cantidad, 0)),0) as sem39,
			ifnull(sum(if(a.semana = 40, a.cantidad, 0)),0) as sem40,
			ifnull(sum(if(a.semana = 41, a.cantidad, 0)),0) as sem41,
			ifnull(sum(if(a.semana = 42, a.cantidad, 0)),0) as sem42,
			ifnull(sum(if(a.semana = 43, a.cantidad, 0)),0) as sem43,
			ifnull(sum(if(a.semana = 44, a.cantidad, 0)),0) as sem44,
			ifnull(sum(if(a.semana = 45, a.cantidad, 0)),0) as sem45,
			ifnull(sum(if(a.semana = 46, a.cantidad, 0)),0) as sem46,
			ifnull(sum(if(a.semana = 47, a.cantidad, 0)),0) as sem47,
			ifnull(sum(if(a.semana = 48, a.cantidad, 0)),0) as sem48,
			ifnull(sum(if(a.semana = 49, a.cantidad, 0)),0) as sem49,
			ifnull(sum(if(a.semana = 50, a.cantidad, 0)),0) as sem50,
			ifnull(sum(if(a.semana = 51, a.cantidad, 0)),0) as sem51,
			ifnull(sum(if(a.semana = 52, a.cantidad, 0)),0) as sem52,
			ifnull(sum(if(a.semana = 53, a.cantidad, 0)),0) as sem53
			from
			microred b
			left join
			(select sub_reg_nt, red, microred, semana, sum(ira_m2+ira_2_11+ira_1_4a+neu_2_11+neu_1_4a+ngr_m2+ngr_2_11+ngr_1_4a) as cantidad 
		    from iras
			where ano = $anio and sub_reg_nt = '".$diresa."'
			and red = '".$red."'
			group by sub_reg_nt, red, microred, semana) a
			on concat(b.subregion, b.red, b.codigo) = concat(a.sub_reg_nt, a.red, a.microred)
			where b.subregion = '".$diresa."' and b.red = '".$red."' and b.estado = '1' 
			group by b.nombre
			";
		}elseif(!empty($diresa) and empty($red) and empty($microred) and empty($establec)){
			$plantilla = "
			select b.nombre,
			ifnull(sum(if(a.semana = 1, a.cantidad, 0)),0) as sem1,
			ifnull(sum(if(a.semana = 2, a.cantidad, 0)),0) as sem2,
			ifnull(sum(if(a.semana = 3, a.cantidad, 0)),0) as sem3,
			ifnull(sum(if(a.semana = 4, a.cantidad, 0)),0) as sem4,
			ifnull(sum(if(a.semana = 5, a.cantidad, 0)),0) as sem5,
			ifnull(sum(if(a.semana = 6, a.cantidad, 0)),0) as sem6,
			ifnull(sum(if(a.semana = 7, a.cantidad, 0)),0) as sem7,
			ifnull(sum(if(a.semana = 8, a.cantidad, 0)),0) as sem8,
			ifnull(sum(if(a.semana = 9, a.cantidad, 0)),0) as sem9,
			ifnull(sum(if(a.semana = 10, a.cantidad, 0)),0) as sem10,
			ifnull(sum(if(a.semana = 11, a.cantidad, 0)),0) as sem11,
			ifnull(sum(if(a.semana = 12, a.cantidad, 0)),0) as sem12,
			ifnull(sum(if(a.semana = 13, a.cantidad, 0)),0) as sem13,
			ifnull(sum(if(a.semana = 14, a.cantidad, 0)),0) as sem14,
			ifnull(sum(if(a.semana = 15, a.cantidad, 0)),0) as sem15,
			ifnull(sum(if(a.semana = 16, a.cantidad, 0)),0) as sem16,
			ifnull(sum(if(a.semana = 17, a.cantidad, 0)),0) as sem17,
			ifnull(sum(if(a.semana = 18, a.cantidad, 0)),0) as sem18,
			ifnull(sum(if(a.semana = 19, a.cantidad, 0)),0) as sem19,
			ifnull(sum(if(a.semana = 20, a.cantidad, 0)),0) as sem20,
			ifnull(sum(if(a.semana = 21, a.cantidad, 0)),0) as sem21,
			ifnull(sum(if(a.semana = 22, a.cantidad, 0)),0) as sem22,
			ifnull(sum(if(a.semana = 23, a.cantidad, 0)),0) as sem23,
			ifnull(sum(if(a.semana = 24, a.cantidad, 0)),0) as sem24,
			ifnull(sum(if(a.semana = 25, a.cantidad, 0)),0) as sem25,
			ifnull(sum(if(a.semana = 26, a.cantidad, 0)),0) as sem26,
			ifnull(sum(if(a.semana = 27, a.cantidad, 0)),0) as sem27,
			ifnull(sum(if(a.semana = 28, a.cantidad, 0)),0) as sem28,
			ifnull(sum(if(a.semana = 29, a.cantidad, 0)),0) as sem29,
			ifnull(sum(if(a.semana = 30, a.cantidad, 0)),0) as sem30,
			ifnull(sum(if(a.semana = 31, a.cantidad, 0)),0) as sem31,
			ifnull(sum(if(a.semana = 32, a.cantidad, 0)),0) as sem32,
			ifnull(sum(if(a.semana = 33, a.cantidad, 0)),0) as sem33,
			ifnull(sum(if(a.semana = 34, a.cantidad, 0)),0) as sem34,
			ifnull(sum(if(a.semana = 35, a.cantidad, 0)),0) as sem35,
			ifnull(sum(if(a.semana = 36, a.cantidad, 0)),0) as sem36,
			ifnull(sum(if(a.semana = 37, a.cantidad, 0)),0) as sem37,
			ifnull(sum(if(a.semana = 38, a.cantidad, 0)),0) as sem38,
			ifnull(sum(if(a.semana = 39, a.cantidad, 0)),0) as sem39,
			ifnull(sum(if(a.semana = 40, a.cantidad, 0)),0) as sem40,
			ifnull(sum(if(a.semana = 41, a.cantidad, 0)),0) as sem41,
			ifnull(sum(if(a.semana = 42, a.cantidad, 0)),0) as sem42,
			ifnull(sum(if(a.semana = 43, a.cantidad, 0)),0) as sem43,
			ifnull(sum(if(a.semana = 44, a.cantidad, 0)),0) as sem44,
			ifnull(sum(if(a.semana = 45, a.cantidad, 0)),0) as sem45,
			ifnull(sum(if(a.semana = 46, a.cantidad, 0)),0) as sem46,
			ifnull(sum(if(a.semana = 47, a.cantidad, 0)),0) as sem47,
			ifnull(sum(if(a.semana = 48, a.cantidad, 0)),0) as sem48,
			ifnull(sum(if(a.semana = 49, a.cantidad, 0)),0) as sem49,
			ifnull(sum(if(a.semana = 50, a.cantidad, 0)),0) as sem50,
			ifnull(sum(if(a.semana = 51, a.cantidad, 0)),0) as sem51,
			ifnull(sum(if(a.semana = 52, a.cantidad, 0)),0) as sem52,
			ifnull(sum(if(a.semana = 53, a.cantidad, 0)),0) as sem53
			from
			redes b
			left join
			(select sub_reg_nt, red, semana, sum(ira_m2+ira_2_11+ira_1_4a+neu_2_11+neu_1_4a+ngr_m2+ngr_2_11+ngr_1_4a) as cantidad 
		 	from iras
			where ano = $anio and sub_reg_nt = '".$diresa."' 
			group by sub_reg_nt, red, semana) a
			on concat(b.subregion, b.codigo) = concat(a.sub_reg_nt, a.red)
			where b.subregion = '".$diresa."' and b.estado = '1' 
			group by b.nombre
			";
		}elseif(empty($diresa) and empty($red) and empty($microred) and empty($establec)){
			if($this->session->userdata('nivel') == '1' or $this->session->userdata('nivel') == '4'){
				$plantilla = "
				select b.nombre,
				ifnull(sum(if(a.semana = 1, a.cantidad, 0)),0) as sem1,
				ifnull(sum(if(a.semana = 2, a.cantidad, 0)),0) as sem2,
				ifnull(sum(if(a.semana = 3, a.cantidad, 0)),0) as sem3,
				ifnull(sum(if(a.semana = 4, a.cantidad, 0)),0) as sem4,
				ifnull(sum(if(a.semana = 5, a.cantidad, 0)),0) as sem5,
				ifnull(sum(if(a.semana = 6, a.cantidad, 0)),0) as sem6,
				ifnull(sum(if(a.semana = 7, a.cantidad, 0)),0) as sem7,
				ifnull(sum(if(a.semana = 8, a.cantidad, 0)),0) as sem8,
				ifnull(sum(if(a.semana = 9, a.cantidad, 0)),0) as sem9,
				ifnull(sum(if(a.semana = 10, a.cantidad, 0)),0) as sem10,
				ifnull(sum(if(a.semana = 11, a.cantidad, 0)),0) as sem11,
				ifnull(sum(if(a.semana = 12, a.cantidad, 0)),0) as sem12,
				ifnull(sum(if(a.semana = 13, a.cantidad, 0)),0) as sem13,
				ifnull(sum(if(a.semana = 14, a.cantidad, 0)),0) as sem14,
				ifnull(sum(if(a.semana = 15, a.cantidad, 0)),0) as sem15,
				ifnull(sum(if(a.semana = 16, a.cantidad, 0)),0) as sem16,
				ifnull(sum(if(a.semana = 17, a.cantidad, 0)),0) as sem17,
				ifnull(sum(if(a.semana = 18, a.cantidad, 0)),0) as sem18,
				ifnull(sum(if(a.semana = 19, a.cantidad, 0)),0) as sem19,
				ifnull(sum(if(a.semana = 20, a.cantidad, 0)),0) as sem20,
				ifnull(sum(if(a.semana = 21, a.cantidad, 0)),0) as sem21,
				ifnull(sum(if(a.semana = 22, a.cantidad, 0)),0) as sem22,
				ifnull(sum(if(a.semana = 23, a.cantidad, 0)),0) as sem23,
				ifnull(sum(if(a.semana = 24, a.cantidad, 0)),0) as sem24,
				ifnull(sum(if(a.semana = 25, a.cantidad, 0)),0) as sem25,
				ifnull(sum(if(a.semana = 26, a.cantidad, 0)),0) as sem26,
				ifnull(sum(if(a.semana = 27, a.cantidad, 0)),0) as sem27,
				ifnull(sum(if(a.semana = 28, a.cantidad, 0)),0) as sem28,
				ifnull(sum(if(a.semana = 29, a.cantidad, 0)),0) as sem29,
				ifnull(sum(if(a.semana = 30, a.cantidad, 0)),0) as sem30,
				ifnull(sum(if(a.semana = 31, a.cantidad, 0)),0) as sem31,
				ifnull(sum(if(a.semana = 32, a.cantidad, 0)),0) as sem32,
				ifnull(sum(if(a.semana = 33, a.cantidad, 0)),0) as sem33,
				ifnull(sum(if(a.semana = 34, a.cantidad, 0)),0) as sem34,
				ifnull(sum(if(a.semana = 35, a.cantidad, 0)),0) as sem35,
				ifnull(sum(if(a.semana = 36, a.cantidad, 0)),0) as sem36,
				ifnull(sum(if(a.semana = 37, a.cantidad, 0)),0) as sem37,
				ifnull(sum(if(a.semana = 38, a.cantidad, 0)),0) as sem38,
				ifnull(sum(if(a.semana = 39, a.cantidad, 0)),0) as sem39,
				ifnull(sum(if(a.semana = 40, a.cantidad, 0)),0) as sem40,
				ifnull(sum(if(a.semana = 41, a.cantidad, 0)),0) as sem41,
				ifnull(sum(if(a.semana = 42, a.cantidad, 0)),0) as sem42,
				ifnull(sum(if(a.semana = 43, a.cantidad, 0)),0) as sem43,
				ifnull(sum(if(a.semana = 44, a.cantidad, 0)),0) as sem44,
				ifnull(sum(if(a.semana = 45, a.cantidad, 0)),0) as sem45,
				ifnull(sum(if(a.semana = 46, a.cantidad, 0)),0) as sem46,
				ifnull(sum(if(a.semana = 47, a.cantidad, 0)),0) as sem47,
				ifnull(sum(if(a.semana = 48, a.cantidad, 0)),0) as sem48,
				ifnull(sum(if(a.semana = 49, a.cantidad, 0)),0) as sem49,
				ifnull(sum(if(a.semana = 50, a.cantidad, 0)),0) as sem50,
				ifnull(sum(if(a.semana = 51, a.cantidad, 0)),0) as sem51,
				ifnull(sum(if(a.semana = 52, a.cantidad, 0)),0) as sem52,
				ifnull(sum(if(a.semana = 53, a.cantidad, 0)),0) as sem53
				from
				diresas b
				left join
				(select sub_reg_nt, semana, sum(ira_m2+ira_2_11+ira_1_4a+neu_2_11+neu_1_4a+ngr_m2+ngr_2_11+ngr_1_4a) as cantidad }
				from iras
				where ano = $anio 
				group by sub_reg_nt, semana) a
				on b.codigo = a.sub_reg_nt
				group by b.nombre
				";
			}else{
				$this->session->set_flashdata('error', 'Debe elegir alg&uacute;n nivel de proceso, este reporte no est&aacute; activo para su nivel de usuario, comun&iacute;quese a notificacion@dge.gob.pe');
				redirect(site_url("reportes/repIras"), 301);
			}
		}
		
		$query = $this->db->query($plantilla);
		
		return $query->result();
		
	}
	
	//Modelo para las tablas del boletin epidemiologico
	
	public function tablasBoletin1($id1, $id2){
		$anio = $id1;
		$semana = $id2;
		
		$plantilla = "
		SELECT concat(upper(substr(b.diagno,1,1)),lower(substr(b.diagno,2,50))) as enfermedad,
		IFNULL(actual_ant,0) as actual_ant,
		IFNULL(acumulado_ant,0) as acumulado_ant,
		IFNULL(defunciones_ant,0) as defunciones_ant,
		IFNULL(round(acumulado_ant/pob_ant*100000,2),0) as ia_ant,
		IFNULL(actual_act,0) as actual_act,
		IFNULL(acumulado_act,0) as acumulado_act,
		IFNULL(defunciones_act,0) as defunciones_act,
		IFNULL(round(acumulado_act/pob_act*100000,2),0) as ia_act
		FROM
		diagno b
		left join
		(select *
		from
		(select b.diagnostic,
		sum(if(b.ano = ($anio-1) and b.semana = $semana, 1, 0)) as actual_ant,
		sum(if(b.ano = ($anio-1) and b.semana <= $semana, 1, 0)) as acumulado_ant,
		sum(if(b.ano = ($anio-1) and b.semana <= $semana and b.fecha_def!='0000-00-00', 1, 0)) as defunciones_ant,
		(select sum(pobtot) from codubi where ano = $anio group by ano) as pob_ant
		from individual_ant b
		where b.tipo_dx <> 'D' and length(trim(b.ubigeo)) <> 0 and b.ubigeo <> '999999' and b.ano = ($anio-1) and b.semana <= $semana
		group by b.diagnostic) y
		join
		(select a.diagnostic,
		sum(if(a.ano = $anio and a.semana = $semana, 1, 0)) as actual_act,
		sum(if(a.ano = $anio and a.semana <= $semana, 1, 0)) as acumulado_act,
		sum(if(a.ano = $anio and a.semana <= $semana and a.fecha_def!='0000-00-00', 1, 0)) as defunciones_act,
		(select sum(pobtot) from codubi where ano = $anio group by ano) as pob_act
		from individual a where a.tipo_dx <> 'D' and length(trim(a.ubigeo)) <> 0 and a.ubigeo <> '999999'
		group by a.diagnostic) z
		USING(diagnostic)) x
		on b.cie_10=x.diagnostic
		where b.cie_10 != 'A50' and b.boletin = 1
		union
		(select if(c.tipo_mte = 'F', 'Muerte perinatal - fetal','Muerte perinatal - neonatal') as diagnostic,
		sum(if(c.anio = ($anio-1) and c.semana = $semana, 1, 0)) as actual_ant,
		sum(if(c.anio = ($anio-1) and c.semana <= $semana, 1, 0)) as acumulado_ant,
		sum(if(c.anio = ($anio-1) and c.semana <= $semana and c.fecha_mte!='0000-00-00', 1, 0)) as defunciones_ant,0,
		sum(if(c.anio = $anio and c.semana = $semana, 1, 0)) as actual_act,
		sum(if(c.anio = $anio and c.semana <= $semana, 1, 0)) as acumulado_act,
		sum(if(c.anio = $anio and c.semana <= $semana and c.fecha_mte!='0000-00-00', 1, 0)) as defunciones_act,0
		from mnp c where (c.tipo_mte = 'F' or c.tipo_mte = 'N') and length(trim(c.ubigeo_res)) <> 0 and c.ubigeo_res <> '999999'
		group by c.tipo_mte)
		union
		(select *
		from
		(select 'Sífilis Congénita' as diagnostic,
		sum(if(a.ano = ($anio-1) and semana = $semana, 1, 0)) as actual_ant,
		sum(if(a.ano = ($anio-1) and a.semana <= $semana, 1, 0)) as acumulado_ant,
		sum(if(a.ano = ($anio-1) and a.semana <= $semana and a.fecha_def!='0000-00-00', 1, 0)) as defunciones_ant,
		round((sum(if(a.ano = ($anio-1) and a.semana <= $semana, 1, 0)) / (select sum(e0) from codubi where ano = $anio - 1 group by ano)) * 100000,2) as ia_ant
		from individual_ant a where a.tipo_dx <> 'D' and length(trim(a.ubigeo)) <> 0 and a.ubigeo <> '999999' and a.diagnostic='A50'
		group by a.diagnostic) p
		join
		(select 'Sífilis Congénita' as diagnostic,
		sum(if(a.ano = $anio and semana = $semana, 1, 0)) as actual_act,
		sum(if(a.ano = $anio and a.semana <= $semana, 1, 0)) as acumulado_act,
		sum(if(a.ano = $anio and a.semana <= $semana and a.fecha_def!='0000-00-00', 1, 0)) as defunciones_act,
		round((sum(if(a.ano = ($anio) and a.semana <= $semana, 1, 0)) / (select sum(e0) from codubi where ano = $anio group by ano)) * 100000,2) as ia_act
		from individual a where a.tipo_dx <> 'D' and length(trim(a.ubigeo)) <> 0 and a.ubigeo <> '999999' and a.diagnostic='A50'
		group by a.diagnostic) q
		USING(diagnostic))
		order by enfermedad
		";
		
		$query = $this->db->query($plantilla);
		return $query->result();
	}

	public function tablasBoletin2($id1, $id2){
		$anio = $id1;
		$semana = $id2;
		
		$plantilla = "
		select concat(upper(substr(b.departam,1,1)),lower(substr(b.departam,2,50))) as departamento,
		concat(upper(substr(b.disa,1,1)),lower(substr(b.disa,2,50))) as diresa,
		IFNULL(A22,0) as 'Antrax',
		IFNULL(round(A22 / b.pobtot * 100000,2),0) as 'ia_a22',
		IFNULL(A971,0) as 'Dengue_con_senales_de_alarma',
		IFNULL(A972,0) as 'Dengue_grave',
		IFNULL(A970,0) as 'Dengue_sin_senales_de_alarma',
		IFNULL(A970+A971+A972,0) as 'Dengue',
		IFNULL(round((A970+A971+A972) / b.pobtot * 100000,2),0) as 'ia_a97',
		IFNULL(A440,0) as 'Enf_de_Carrion_aguda',
		IFNULL(A441,0) as 'Enf_de_Carrion_cronica',
		IFNULL(A441+A440,0) as 'Enf_de_Carrion',
		IFNULL(round((A441+A440) / b.pobtot * 100000,2),0) as 'ia_a44',
		IFNULL(B57,0) as 'Enf_de_Chagas',
		IFNULL(round(B57 / b.pobtot * 100000,2),0) as 'ia_b57',
		IFNULL(A950,0) as 'Fiebre_amarilla_selvatica',
		IFNULL(round(A950 / b.pobtot * 100000,2),0) as 'ia_a950',
		IFNULL(B16,0) as 'Hepatitis_B',
		IFNULL(round(B16 / b.pobtot * 100000,2),0) as 'ia_b16',
		IFNULL(B551,0) as 'Leishmaniosis_cutanea',
		IFNULL(round(B551 / b.pobtot * 100000,2),0) as 'ia_b551',
		IFNULL(B552,0) as 'Leishmaniosis_mucocutanea',
		IFNULL(round(B552 / b.pobtot * 100000,2),0) as 'ia_b552',
		IFNULL(A27,0) as 'Leptospirosis',
		IFNULL(round(A27 / b.pobtot * 100000,2),0) as 'ia_a27',
		IFNULL(X21,0) as 'Loxocelismo',
		IFNULL(B501,0) as 'Malaria_mixta',
		IFNULL(round(B501 / b.pobtot * 100000,2),0) as 'ia_b501',
		IFNULL(B50,0) as 'Malaria_por_P_Falciparum',
		IFNULL(round(B50 / b.pobtot * 100000,2),0) as 'ia_b50',
		IFNULL(B51,0) as 'Malaria_por_P_Vivax',
		IFNULL(round(B51 / b.pobtot * 100000,2),0) as 'ia_b51',
		IFNULL(O95,0) as 'Muerte_materna_directa',
		IFNULL(O97,0) as 'Muerte_materna_incidental',
		IFNULL(O96,0) as 'Muerte_materna_indirecta',
		IFNULL(X20,0) as 'Ofidismo',
		IFNULL(A200,0) as 'Peste_bubonica',
		IFNULL(round(A200 / b.pobtot * 100000,2),0) as 'ia_a200',
		IFNULL(A820,0) as 'Rabia_humana_silvestre',
		IFNULL(round(A820 / b.pobtot * 100000,2),0) as 'ia_a820',
		IFNULL(A50,0) as 'Sifilis_congenita',
		IFNULL(round(A50 / b.e0 * 100000,2),0) as 'ia_a50',
		IFNULL(A35,0) as 'Tetanos',
		IFNULL(round(A35 / b.pobtot * 100000,2),0) as 'ia_a35',
		IFNULL(A37,0) as 'Tos_ferina',
		IFNULL(round(A37 / b.pobtot * 100000,2),0) as 'ia_a37',
		IFNULL(FETAL,0) as 'Muerte_perinatal_fetal',
		IFNULL(NEONATAL,0) as 'Muerte_perinatal_neonatal'
		from
		(SELECT substr(ubigeo,1,2) as coddep, departam, cod_disa,disa,sum(pobtot) as pobtot,sum(e0) as e0
		FROM `codubi` where ano = $anio and length(trim(ubigeo)) <> 0 and ubigeo <> '999999' group by coddep,disa
		union select 'Total','Total','Total','Total',sum(pobtot) as pobtot ,sum(e0) as e0 FROM `codubi` where ano = $anio) b
		left join
		(select * from (select substr(a.ubigeo,1,2) as coddep,a.subregion,
		sum(if(a.diagnostic = 'A22', 1, 0)) as A22,
		sum(if(a.diagnostic = 'A97.1', 1, 0)) as A971,
		sum(if(a.diagnostic = 'A97.2', 1, 0)) as A972,
		sum(if(a.diagnostic = 'A97.0', 1, 0)) as A970,
		sum(if(a.diagnostic = 'A44.0', 1, 0)) as A440,
		sum(if(a.diagnostic = 'A44.1', 1, 0)) as A441,
		sum(if(a.diagnostic = 'B57', 1, 0)) as B57,
		sum(if(a.diagnostic = 'A95.0', 1, 0)) as A950,
		sum(if(a.diagnostic = 'B16', 1, 0)) as B16,
		sum(if(a.diagnostic = 'B55.1', 1, 0)) as B551,
		sum(if(a.diagnostic = 'B55.2', 1, 0)) as B552,
		sum(if(a.diagnostic = 'A27', 1, 0)) as A27,
		sum(if(a.diagnostic = 'X21', 1, 0)) as X21,
		sum(if(a.diagnostic = 'B501', 1, 0)) as B501,
		sum(if(a.diagnostic = 'B50', 1, 0)) as B50,
		sum(if(a.diagnostic = 'B51', 1, 0)) as B51,
		sum(if(a.diagnostic = 'O95', 1, 0)) as O95,
		sum(if(a.diagnostic = 'O97', 1, 0)) as O97,
		sum(if(a.diagnostic = 'O96', 1, 0)) as O96,
		sum(if(a.diagnostic = 'X20', 1, 0)) as X20,
		sum(if(a.diagnostic = 'A20.0', 1, 0)) as A200,
		sum(if(a.diagnostic = 'A82.0', 1, 0)) as A820,
		sum(if(a.diagnostic = 'A50', 1, 0)) as A50,
		sum(if(a.diagnostic = 'A35', 1, 0)) as A35,
		sum(if(a.diagnostic = 'A37', 1, 0)) as A37
		from individual a
		where a.tipo_dx <> 'D' and a.ano = $anio and a.semana <= $semana and a.subregion<>'99'
		and length(trim(a.ubigeo)) <> 0 and a.ubigeo <> '999999'
		group by coddep,a.subregion) h
		left join
		(select substr(c.e_salud,1,2) as depto, c.diresa,
		sum(if(c.tipo_mte = 'F', 1, 0)) as 'FETAL',
		sum(if(c.tipo_mte = 'N', 1, 0)) as 'NEONATAL'
		from mnp c
		where (c.tipo_mte = 'F' or c.tipo_mte = 'N') and c.anio = $anio and c.semana <= $semana and c.diresa<>'99'
		and length(trim(c.diresa)) <> 0
		group by substr(c.e_salud,1,2), c.diresa) i on concat(h.coddep,h.subregion)=concat(i.depto,i.diresa)
		union
		(select * from (select 'Total' as totdep,'Total' as totdisa,
		sum(if(a.diagnostic = 'A22', 1, 0)) as A22,
		sum(if(a.diagnostic = 'A97.1', 1, 0)) as A971,
		sum(if(a.diagnostic = 'A97.2', 1, 0)) as A972,
		sum(if(a.diagnostic = 'A97.0', 1, 0)) as A970,
		sum(if(a.diagnostic = 'A44.0', 1, 0)) as A440,
		sum(if(a.diagnostic = 'A44.1', 1, 0)) as A441,
		sum(if(a.diagnostic = 'B57', 1, 0)) as B57,
		sum(if(a.diagnostic = 'A95.0', 1, 0)) as A950,
		sum(if(a.diagnostic = 'B16', 1, 0)) as B16,
		sum(if(a.diagnostic = 'B55.1', 1, 0)) as B551,
		sum(if(a.diagnostic = 'B55.2', 1, 0)) as B552,
		sum(if(a.diagnostic = 'A27', 1, 0)) as A27,
		sum(if(a.diagnostic = 'X21', 1, 0)) as X21,
		sum(if(a.diagnostic = 'B501', 1, 0)) as B501,
		sum(if(a.diagnostic = 'B50', 1, 0)) as B50,
		sum(if(a.diagnostic = 'B51', 1, 0)) as B51,
		sum(if(a.diagnostic = 'O95', 1, 0)) as O95,
		sum(if(a.diagnostic = 'O97', 1, 0)) as O97,
		sum(if(a.diagnostic = 'O96', 1, 0)) as O96,
		sum(if(a.diagnostic = 'X20', 1, 0)) as X20,
		sum(if(a.diagnostic = 'A20.0', 1, 0)) as A200,
		sum(if(a.diagnostic = 'A82.0', 1, 0)) as A820,
		sum(if(a.diagnostic = 'A50', 1, 0)) as A50,
		sum(if(a.diagnostic = 'A35', 1, 0)) as A35,
		sum(if(a.diagnostic = 'A37', 1, 0)) as A37
		from individual a
		where a.tipo_dx <> 'D' and a.ano = $anio and a.semana <= $semana and a.subregion<>'99'
		and length(trim(a.ubigeo)) <> 0 and a.ubigeo <> '999999') k
		join
		(select 'Total' as totdep,'Total' as totdisa,
		sum(if(d.tipo_mte = 'F', 1, 0)) as 'FETAL',
		sum(if(d.tipo_mte = 'N', 1, 0)) as 'NEONATAL'
		from mnp d
		where (d.tipo_mte = 'F' or d.tipo_mte = 'N') and d.anio = $anio and d.semana <= $semana and d.diresa<>'99'
		and length(trim(d.ubigeo_res)) <> 0 and d.ubigeo_res <> '999999') j on k.totdep = j.totdep)) l
		on concat(b.coddep,b.cod_disa)=concat(l.coddep,l.subregion)
		";
		
		$query = $this->db->query($plantilla);
		return $query->result();
	}

	public function tablasBoletin3($id1, $id2){
		$anio = $id1;
		$semana = $id2;
		
		$plantilla = "
		select ifnull(departamento,'Total') as departamento, ifnull(diresa,'Total') as diresa, 
		actual_daa_ant,
		acumulado_daa_ant,
		actual_dis_ant,
		acumulado_dis_ant,
		hospital_ant,
		defuncion_ant,
		total_ant,
		actual_daa_act,
		acumulado_daa_act,
		actual_dis_act,
		acumulado_dis_act,
		hospital_act,
		defuncion_act,
		total_act
		from (
		select concat(upper(substr(b.departam,1,1)),lower(substr(b.departam,2,50))) as departamento,
		concat(upper(substr(b.disa,1,1)),lower(substr(b.disa,2,50))) as diresa, substr(b.ubigeo,1,2) as cod_dep,
		sum(actual_daa_ant) as actual_daa_ant,
		sum(acumulado_daa_ant) as acumulado_daa_ant,
		sum(actual_dis_ant) as actual_dis_ant,
		sum(acumulado_dis_ant) as acumulado_dis_ant,
		sum(hospital_ant) as hospital_ant,
		sum(defuncion_ant) as defuncion_ant,
		sum(total_ant) as total_ant,
		sum(actual_daa_act) as actual_daa_act,
		sum(acumulado_daa_act) as acumulado_daa_act,
		sum(actual_dis_act) as actual_dis_act,
		sum(acumulado_dis_act) as acumulado_dis_act,
		sum(hospital_act) as hospital_act,
		sum(defuncion_act) as defuncion_act,
		sum(total_act) as total_act
		from codubi  b
		right join
		(select *
		from
		(select a.ubigeo,
		sum(if(a.ano = $anio-1 and a.semana = $semana, (a.daa_c1+a.daa_c1_4+a.daa_c5), 0)) as actual_daa_ant,
		sum(if(a.ano = $anio-1 and a.semana <= $semana, (a.daa_c1+a.daa_c1_4+a.daa_c5), 0)) as acumulado_daa_ant,
		sum(if(a.ano = $anio-1 and a.semana = $semana, (a.dis_c1+a.dis_c1_4+a.dis_c5), 0)) as actual_dis_ant,
		sum(if(a.ano = $anio-1 and a.semana <= $semana, (a.dis_c1+a.dis_c1_4+a.dis_c5), 0)) as acumulado_dis_ant,
		sum(if(a.ano = $anio-1 and a.semana <= $semana, (a.daa_h1+a.daa_h1_4+a.daa_h5+a.dis_h1+a.dis_h1_4+a.dis_h5), 0)) as hospital_ant,
		sum(if(a.ano = $anio-1 and a.semana <= $semana, (a.daa_d1+a.daa_d1_4+a.daa_d5+a.dis_d1+a.dis_d1_4+a.dis_d5), 0)) as defuncion_ant,
		sum(if(a.ano = $anio-1 and a.semana <= $semana, (a.daa_c1+a.daa_c1_4+a.daa_c5+a.dis_c1+a.dis_c1_4+a.dis_c5), 0)) as total_ant
		from edas_ant a
		where a.ubigeo <> '      '
		group by a.ubigeo
		order by a.ubigeo) p
		join
		(select a.ubigeo,
		sum(if(a.ano = $anio and a.semana = $semana, (a.daa_c1+a.daa_c1_4+a.daa_c5), 0)) as actual_daa_act,
		sum(if(a.ano = $anio and a.semana <= $semana, (a.daa_c1+a.daa_c1_4+a.daa_c5), 0)) as acumulado_daa_act,
		sum(if(a.ano = $anio and a.semana = $semana, (a.dis_c1+a.dis_c1_4+a.dis_c5), 0)) as actual_dis_act,
		sum(if(a.ano = $anio and a.semana <= $semana, (a.dis_c1+a.dis_c1_4+a.dis_c5), 0)) as acumulado_dis_act,
		sum(if(a.ano = $anio and a.semana <= $semana, (a.daa_h1+a.daa_h1_4+a.daa_h5+a.dis_h1+a.dis_h1_4+a.dis_h5), 0)) as hospital_act,
		sum(if(a.ano = $anio and a.semana <= $semana, (a.daa_d1+a.daa_d1_4+a.daa_d5+a.dis_d1+a.dis_d1_4+a.dis_d5), 0)) as defuncion_act,
		sum(if(a.ano = $anio and a.semana <= $semana, (a.daa_c1+a.daa_c1_4+a.daa_c5+a.dis_c1+a.dis_c1_4+a.dis_c5), 0)) as total_act
		from edas a
		where a.ubigeo <> '      '
		group by a.ubigeo
		order by a.ubigeo) q
		USING(ubigeo)) x
		on b.ubigeo=x.ubigeo
		where b.ano = $anio-1
		group by b.disa order by b.departam, b.disa) y
		union
		(select *
		from
		(select 'total','total1',
		sum(if(a.ano = $anio-1 and a.semana = $semana, (a.daa_c1+a.daa_c1_4+a.daa_c5), 0)) as actual_daa_ant,
		sum(if(a.ano = $anio-1 and a.semana <= $semana, (a.daa_c1+a.daa_c1_4+a.daa_c5), 0)) as acumulado_daa_ant,
		sum(if(a.ano = $anio-1 and a.semana = $semana, (a.dis_c1+a.dis_c1_4+a.dis_c5), 0)) as actual_dis_ant,
		sum(if(a.ano = $anio-1 and a.semana <= $semana, (a.dis_c1+a.dis_c1_4+a.dis_c5), 0)) as acumulado_dis_ant,
		sum(if(a.ano = $anio-1 and a.semana <= $semana, (a.daa_h1+a.daa_h1_4+a.daa_h5+a.dis_h1+a.dis_h1_4+a.dis_h5), 0)) as hospital_ant,
		sum(if(a.ano = $anio-1 and a.semana <= $semana, (a.daa_d1+a.daa_d1_4+a.daa_d5+a.dis_d1+a.dis_d1_4+a.dis_d5), 0)) as defuncion_ant,
		sum(if(a.ano = $anio-1 and a.semana <= $semana, (a.daa_c1+a.daa_c1_4+a.daa_c5+a.dis_c1+a.dis_c1_4+a.dis_c5), 0)) as total_ant
		from edas_ant a where a.ano = $anio-1) r
		join
		(select 'total',
		sum(if(a.ano = $anio and a.semana = $semana, (a.daa_c1+a.daa_c1_4+a.daa_c5), 0)) as actual_daa_act,
		sum(if(a.ano = $anio and a.semana <= $semana, (a.daa_c1+a.daa_c1_4+a.daa_c5), 0)) as acumulado_daa_act,
		sum(if(a.ano = $anio and a.semana = $semana, (a.dis_c1+a.dis_c1_4+a.dis_c5), 0)) as actual_dis_act,
		sum(if(a.ano = $anio and a.semana <= $semana, (a.dis_c1+a.dis_c1_4+a.dis_c5), 0)) as acumulado_dis_act,
		sum(if(a.ano = $anio and a.semana <= $semana, (a.daa_h1+a.daa_h1_4+a.daa_h5+a.dis_h1+a.dis_h1_4+a.dis_h5), 0)) as hospital_act,
		sum(if(a.ano = $anio and a.semana <= $semana, (a.daa_d1+a.daa_d1_4+a.daa_d5+a.dis_d1+a.dis_d1_4+a.dis_d5), 0)) as defuncion_act,
		sum(if(a.ano = $anio and a.semana <= $semana, (a.daa_c1+a.daa_c1_4+a.daa_c5+a.dis_c1+a.dis_c1_4+a.dis_c5), 0)) as total_act
		from edas a where a.ano = $anio) s
		USING(total))		
		";
		
		$query = $this->db->query($plantilla);
		return $query->result();
	}

	public function tablasBoletin4($id1, $id2){
		$anio = $id1;
		$semana = $id2;
		
		$plantilla = "
		select ifnull(departamento,'Total') as departamento, ifnull(diresa,'Total') as diresa,
		actual_ira_ant,
		acumulado_ira_ant,
		actual_neu_ant,
		acumulado_neu_ant,
		hospital_ant,
		defuncion_ant,
		total_ant,
		actual_ira_act,
		acumulado_ira_act,
		actual_neu_act,
		acumulado_neu_act,
		hospital_act,
		defuncion_act,
		total_act
		from (
		select concat(upper(substr(b.departam,1,1)),lower(substr(b.departam,2,50))) as departamento,
		concat(upper(substr(b.disa,1,1)),lower(substr(b.disa,2,50))) as diresa,
		sum(actual_ira_ant) as actual_ira_ant,
		sum(acumulado_ira_ant) as acumulado_ira_ant,
		sum(actual_neu_ant) as actual_neu_ant,
		sum(acumulado_neu_ant) as acumulado_neu_ant,
		sum(hospital_ant) as hospital_ant,
		sum(defuncion_ant) as defuncion_ant,
		sum(total_ant) as total_ant,
		sum(actual_ira_act) as actual_ira_act,
		sum(acumulado_ira_act) as acumulado_ira_act,
		sum(actual_neu_act) as actual_neu_act,
		sum(acumulado_neu_act) as acumulado_neu_act,
		sum(hospital_act) as hospital_act,
		sum(defuncion_act) as defuncion_act,
		sum(total_act) as total_act
		from codubi b
		right join
		(select *
		from
		(select a.ubigeo,
		sum(if(a.ano = $anio-1 and a.semana = $semana, (a.ira_m2+a.ira_2_11+a.ira_1_4a), 0)) as actual_ira_ant,
		sum(if(a.ano = $anio-1 and a.semana <= $semana, (a.ira_m2+a.ira_2_11+a.ira_1_4a), 0)) as acumulado_ira_ant,
		sum(if(a.ano = $anio-1 and a.semana = $semana, (a.neu_2_11+a.neu_1_4a+a.ngr_m2+a.ngr_2_11+a.ngr_1_4a), 0)) as actual_neu_ant,
		sum(if(a.ano = $anio-1 and a.semana <= $semana, (a.neu_2_11+a.neu_1_4a+a.ngr_m2+a.ngr_2_11+a.ngr_1_4a), 0)) as acumulado_neu_ant,
		sum(if(a.ano = $anio-1 and a.semana <= $semana, (a.hos_m2+a.hos_2_11+a.hos_1_4a), 0)) as hospital_ant,
		sum(if(a.ano = $anio-1 and a.semana <= $semana, (a.dih_m2+a.dih_2_11+a.dih_1_4a+a.deh_m2+a.deh_2_11+a.deh_1_4a), 0)) as defuncion_ant,
		sum(if(a.ano = $anio-1 and a.semana <= $semana, (a.ira_m2+a.ira_2_11+a.ira_1_4a+a.neu_2_11+a.neu_1_4a+a.ngr_m2+a.ngr_2_11+a.ngr_1_4a), 0)) as total_ant
		from iras_ant a
		where a.ubigeo <> '      '
		group by a.ubigeo
		order by a.ubigeo) x
		join
		(select a.ubigeo,
		sum(if(a.ano = $anio and a.semana = $semana, (a.ira_m2+a.ira_2_11+a.ira_1_4a), 0)) as actual_ira_act,
		sum(if(a.ano = $anio and a.semana <= $semana, (a.ira_m2+a.ira_2_11+a.ira_1_4a), 0)) as acumulado_ira_act,
		sum(if(a.ano = $anio and a.semana = $semana, (a.neu_2_11+a.neu_1_4a+a.ngr_m2+a.ngr_2_11+a.ngr_1_4a), 0)) as actual_neu_act,
		sum(if(a.ano = $anio and a.semana <= $semana, (a.neu_2_11+a.neu_1_4a+a.ngr_m2+a.ngr_2_11+a.ngr_1_4a), 0)) as acumulado_neu_act,
		sum(if(a.ano = $anio and a.semana <= $semana, (a.hos_m2+a.hos_2_11+a.hos_1_4a), 0)) as hospital_act,
		sum(if(a.ano = $anio and a.semana <= $semana, (a.dih_m2+a.dih_2_11+a.dih_1_4a+a.deh_m2+a.deh_2_11+a.deh_1_4a), 0)) as defuncion_act,
		sum(if(a.ano = $anio and a.semana <= $semana, (a.ira_m2+a.ira_2_11+a.ira_1_4a+a.neu_2_11+a.neu_1_4a+a.ngr_m2+a.ngr_2_11+a.ngr_1_4a), 0)) as total_act
		from iras a
		where a.ubigeo <> '      '
		group by a.ubigeo
		order by a.ubigeo) v
		USING(ubigeo)) z
		on b.ubigeo=z.ubigeo
		where b.ano = $anio
		group by b.disa order by b.departam, b.disa) y
		union
		(select *
		from
		(select 'total','total1',
		sum(if(a.ano = $anio-1 and a.semana = $semana, (a.ira_m2+a.ira_2_11+a.ira_1_4a), 0)) as actual_ira_ant,
		sum(if(a.ano = $anio-1 and a.semana <= $semana, (a.ira_m2+a.ira_2_11+a.ira_1_4a), 0)) as acumulado_ira_ant,
		sum(if(a.ano = $anio-1 and a.semana = $semana, (a.neu_2_11+a.neu_1_4a+a.ngr_m2+a.ngr_2_11+a.ngr_1_4a), 0)) as actual_neu_ant,
		sum(if(a.ano = $anio-1 and a.semana <= $semana, (a.neu_2_11+a.neu_1_4a+a.ngr_m2+a.ngr_2_11+a.ngr_1_4a), 0)) as acumulado_neu_ant,
		sum(if(a.ano = $anio-1 and a.semana <= $semana, (a.hos_m2+a.hos_2_11+a.hos_1_4a), 0)) as hospital_ant,
		sum(if(a.ano = $anio-1 and a.semana <= $semana, (a.dih_m2+a.dih_2_11+a.dih_1_4a+a.deh_m2+a.deh_2_11+a.deh_1_4a), 0)) as defuncion_ant,
		sum(if(a.ano = $anio-1 and a.semana <= $semana, (a.ira_m2+a.ira_2_11+a.ira_1_4a+a.neu_2_11+a.neu_1_4a+a.ngr_m2+a.ngr_2_11+a.ngr_1_4a), 0)) as total_ant
		from iras_ant a) o
		join
		(select 'total',
		sum(if(a.ano = $anio and a.semana = $semana, (a.ira_m2+a.ira_2_11+a.ira_1_4a), 0)) as actual_ira_act,
		sum(if(a.ano = $anio and a.semana <= $semana, (a.ira_m2+a.ira_2_11+a.ira_1_4a), 0)) as acumulado_ira_act,
		sum(if(a.ano = $anio and a.semana = $semana, (a.neu_2_11+a.neu_1_4a+a.ngr_m2+a.ngr_2_11+a.ngr_1_4a), 0)) as actual_neu_act,
		sum(if(a.ano = $anio and a.semana <= $semana, (a.neu_2_11+a.neu_1_4a+a.ngr_m2+a.ngr_2_11+a.ngr_1_4a), 0)) as acumulado_neu_act,
		sum(if(a.ano = $anio and a.semana <= $semana, (a.hos_m2+a.hos_2_11+a.hos_1_4a), 0)) as hospital_act,
		sum(if(a.ano = $anio and a.semana <= $semana, (a.dih_m2+a.dih_2_11+a.dih_1_4a+a.deh_m2+a.deh_2_11+a.deh_1_4a), 0)) as defuncion_act,
		sum(if(a.ano = $anio and a.semana <= $semana, (a.ira_m2+a.ira_2_11+a.ira_1_4a+a.neu_2_11+a.neu_1_4a+a.ngr_m2+a.ngr_2_11+a.ngr_1_4a), 0)) as total_act
		from iras a) p
		USING(total))
		";
		
		$query = $this->db->query($plantilla);
		return $query->result();
	}
	
	// Registra los pasos para proceder a la autorización de la notificación
	
	public function registraNotificacion($dato){
		
		$obtiene = $this->db
					->where($dato)
					->get('revision');
					
		$datos = array('ano'=>$dato['ano'],'semana'=>$dato['semana'],'diresa'=>$this->session->userdata('diresa'),'notificacion'=>'1');
		
		if(count($obtiene->row()) == 0){
			$this->db->insert('revision',$datos);
			return true;
		}else{
			$this->db->update('revision',$datos);
			return true;
		}
	}

	public function registraCalidad($dato){
		
		$obtiene = $this->db
					->where($dato)
					->get('revision');
					
		$datos = array('ano'=>$dato['ano'],'semana'=>$dato['semana'],'diresa'=>$this->session->userdata('diresa'),'calidad'=>'1');
		
		if(count($obtiene->row()) == 0){
			$this->db->insert('revision',$datos);
			return true;
		}else{
			$this->db
			->where($dato)
			->update('revision',$datos);
			return true;
		}
	}

	public function registraCobertura($dato){
		
		$obtiene = $this->db
					->where($dato)
					->get('revision');
					
		$datos = array('ano'=>$dato['ano'],'semana'=>$dato['semana'],'diresa'=>$this->session->userdata('diresa'),'cobertura'=>'1');
		
		if(count($obtiene->row()) == 0){
			$this->db->insert('revision',$datos);
			return true;
		}else{
			$this->db
			->where($dato)
			->update('revision',$datos);
			return true;
		}
	}

	public function registraBitacora($dato){
		
		$obtiene = $this->db
					->where($dato)
					->get('revision');
					
		$datos = array('ano'=>$dato['ano'],'semana'=>$dato['semana'],'diresa'=>$this->session->userdata('diresa'),'bitacora'=>'1');
		
		if(count($obtiene->row()) == 0){
			$this->db->insert('revision',$datos);
			return true;
		}else{
			$this->db
			->where($dato)
			->update('revision',$datos);
			return true;
		}
	}
	
	public function compruebaProcesos($id){
		
		$comprueba = $this->db
					->where($id)
					->get('revision');
					
		return $comprueba->row();
	}
}