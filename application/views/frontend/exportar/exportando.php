<?php

$maximo = $datos['maximo'];
$contador = $datos['contador'];
$puntero = $datos['puntero'];
$limite = $datos['limite'];
$base = $datos['base'];
$anio = $datos['anio'];

if($datos['ruta_db'] <> '0'){
	$ruta_db = str_replace("L", "/", $datos['ruta_db']);
}else{
	$ruta_db = "";
}

if($maximo == 0){
	switch($base)
	{
		case 1:
		$namet = 'noti';
		
		$lineas = $this->frontend_model->buscaCierre($anio);
		
		if($lineas == 0){
			$param1 = 'individual';
		}else{
			$param1 = 'individual_ant';
		}
	
		switch($this->session->userdata('nivel'))
		{
			case 4:
			if($this->session->userdata('institucion') <> 'A'){
				$where = " a where a.ano = ".$anio." and substr(e_salud,7,1) = '".$this->session->userdata('institucion')."'";
			}else{
				$where = " a left join diagno b on a.diagnostic=b.cie_10 left join tematicos c on b.clave=c.codigo where a.ano = ".$anio." and c.codigo = '".$this->session->userdata('equipo')."'";
			}
			break;
			case 5:
			if($this->session->userdata('institucion') <> 'A'){
				$where = " a where ano = ".$anio." and sub_reg_nt = '".$this->session->userdata('diresa')."' and substr(e_salud,7,1) = '".$this->session->userdata('institucion')."'";
			}else{
				$where = " a where ano = ".$anio." and sub_reg_nt = '".$this->session->userdata('diresa')."'";
			}
			break;
			case 6:
			if($this->session->userdata('institucion') <> 'A'){
				$where = " a where ano = ".$anio." and sub_reg_nt = '".$this->session->userdata('diresa')."' and red = '".$this->session->userdata('red')."' and substr(e_salud,7,1) = '".$this->session->userdata('institucion')."'";
			}else{
				$where = " a where ano = ".$anio." and sub_reg_nt = '".$this->session->userdata('diresa')."' and red = '".$this->session->userdata('red')."'";
			}
			break;
			case 7:
			if($this->session->userdata('institucion') <> 'A'){
				$where = " a where ano = ".$anio." and sub_reg_nt = '".$this->session->userdata('diresa')."' and red = '".$this->session->userdata('red')."' and microred = '".$this->session->userdata('microred')."' and substr(e_salud,7,1) = '".$this->session->userdata('institucion')."'";						
			}else{
				$where = " a where ano = ".$anio." and sub_reg_nt = '".$this->session->userdata('diresa')."' and red = '".$this->session->userdata('red')."' and microred = '".$this->session->userdata('microred')."'";						
			}
			break;
			case 8:
			$where = " a where e_salud = '".$this->session->userdata('establecimiento')."' and ano = ".$anio;
			break;
			default:
			if($this->session->userdata('institucion') <> 'A'){
				$where = " a where ano = ".$anio." and substr(e_salud,7,1) = '".$this->session->userdata('institucion')."'";
			}else{
				$where = " a where ano = ".$anio;
			}
			break;
		}
		
		break;
		
		case 2:
		$namet = 'eda';

		$lineas = $this->frontend_model->buscaCierre($anio);
		
		if($lineas == 0){
			$param1 = 'edas';
		}else{
			$param1 = 'edas_ant';
		}
	
		switch($this->session->userdata('nivel'))
		{
			case 4:
			if($this->session->userdata('equipo') == "EDAS"){
				$where = " where ano = ".$anio;
			}else{
				if($this->session->userdata('institucion') <> 'A'){
					$where = " a where ano = ".$anio." and substr(e_salud,7,1) = '".$this->session->userdata('institucion')."'";
				}else{
					$where = " a where ano = ".$anio;
				}
			}
			break;
			case 5:
				if($this->session->userdata('institucion') <> 'A'){
					$where = " where sub_reg_nt = '".$this->session->userdata('diresa')."' and ano = ".$anio." and substr(e_salud,7,1) = '".$this->session->userdata('institucion')."'";
				}else{
					$where = " where sub_reg_nt = '".$this->session->userdata('diresa')."' and ano = ".$anio;
				}
			break;
			case 6:
				if($this->session->userdata('institucion') <> 'A'){
					$where = " where sub_reg_nt = '".$this->session->userdata('diresa')."' and red = '".$this->session->userdata('red')."' and ano = ".$anio." and substr(e_salud,7,1) = '".$this->session->userdata('institucion')."'";
				}else{
					$where = " where sub_reg_nt = '".$this->session->userdata('diresa')."' and red = '".$this->session->userdata('red')."' and ano = ".$anio;
				}
			break;
			case 7:
				if($this->session->userdata('institucion') <> 'A'){
					$where = " where sub_reg_nt = '".$this->session->userdata('diresa')."' and red = '".$this->session->userdata('red')."' and microred = '".$this->session->userdata('microred')."' and ano = ".$anio." and substr(e_salud,7,1) = '".$this->session->userdata('institucion')."'";						
				}else{
					$where = " where sub_reg_nt = '".$this->session->userdata('diresa')."' and red = '".$this->session->userdata('red')."' and microred = '".$this->session->userdata('microred')."' and ano = ".$anio;						
				}
			break;
			case 8:
			$where = " a where e_salud = '".$this->session->userdata('establecimiento')."' and ano = ".$anio;
			break;
			default:
				if($this->session->userdata('institucion') <> 'A'){
					$where = " a where ano = ".$anio." and substr(e_salud,7,1) = '".$this->session->userdata('institucion')."'";
				}else{
					$where = " a where ano = ".$anio;
				}
			break;
		}
		
		break;
		
		case 3:
		$namet = 'ira';

		$lineas = $this->frontend_model->buscaCierre($anio);
		
		if($lineas == 0){
			$param1 = 'iras';
		}else{
			$param1 = 'iras_ant';
		}
	
		switch($this->session->userdata('nivel'))
		{
			case 4:
			if($this->session->userdata('equipo') == "IRAS"){
				$where = " where ano = ".$anio;
			}else{
				if($this->session->userdata('institucion') <> 'A'){
					$where = " a where ano = ".$anio." and substr(e_salud,7,1) = '".$this->session->userdata('institucion')."'";
				}else{
					$where = " a where ano = ".$anio;
				}
			}
			break;
			case 5:
				if($this->session->userdata('institucion') <> 'A'){
					$where = " where sub_reg_nt = '".$this->session->userdata('diresa')."' and ano = ".$anio." and substr(e_salud,7,1) = '".$this->session->userdata('institucion')."'";
				}else{
					$where = " where sub_reg_nt = '".$this->session->userdata('diresa')."' and ano = ".$anio;
				}
			break;
			case 6:
				if($this->session->userdata('institucion') <> 'A'){
					$where = " where sub_reg_nt = '".$this->session->userdata('diresa')."' and red = '".$this->session->userdata('red')."' and ano = ".$anio." and substr(e_salud,7,1) = '".$this->session->userdata('institucion')."'";
				}else{
					$where = " where sub_reg_nt = '".$this->session->userdata('diresa')."' and red = '".$this->session->userdata('red')."' and ano = ".$anio;
				}
			break;
			case 7:
				if($this->session->userdata('institucion') <> 'A'){
					$where = " where sub_reg_nt = '".$this->session->userdata('diresa')."' and red = '".$this->session->userdata('red')."' and microred = '".$this->session->userdata('microred')."' and ano = ".$anio." and substr(e_salud,7,1) = '".$this->session->userdata('institucion')."'";						
				}else{
					$where = " where sub_reg_nt = '".$this->session->userdata('diresa')."' and red = '".$this->session->userdata('red')."' and microred = '".$this->session->userdata('microred')."' and ano = ".$anio;						
				}
			break;
			case 8:
			$where = " a where e_salud = '".$this->session->userdata('establecimiento')."' and ano = ".$anio;
			break;
			default:
				if($this->session->userdata('institucion') <> 'A'){
					$where = " a where ano = ".$anio." and substr(e_salud,7,1) = '".$this->session->userdata('institucion')."'";
				}else{
					$where = " a where ano = ".$anio;
				}
			break;
		}

		break;
		
		case 4:
		$namet = 'feb';

		$lineas = $this->frontend_model->buscaCierre($anio);
		
		if($lineas == 0){
			$param1 = 'febriles';
		}else{
			$param1 = 'febriles_ant';
		}
	
		switch($this->session->userdata('nivel'))
		{
			case 4:
			if($this->session->userdata('equipo') == "IRAS" or $this->session->userdata('equipo') == "METAX"){
				$where = " where a.ano = ".$anio;
			}else{
				$where = "";
			}
			break;
			case 5:
				if($this->session->userdata('institucion') <> 'A'){
					$where = " where sub_reg_nt = '".$this->session->userdata('diresa')."' and ano = ".$anio." and substr(e_salud,7,1) = '".$this->session->userdata('institucion')."'";
				}else{
					$where = " where sub_reg_nt = '".$this->session->userdata('diresa')."' and ano = ".$anio;
				}
			break;
			case 6:
				if($this->session->userdata('institucion') <> 'A'){
					$where = " where sub_reg_nt = '".$this->session->userdata('diresa')."' and red = '".$this->session->userdata('red')."' and ano = ".$anio." and substr(e_salud,7,1) = '".$this->session->userdata('institucion')."'";
				}else{
					$where = " where sub_reg_nt = '".$this->session->userdata('diresa')."' and red = '".$this->session->userdata('red')."' and ano = ".$anio;
				}
			break;
			case 7:
				if($this->session->userdata('institucion') <> 'A'){
					$where = " where sub_reg_nt = '".$this->session->userdata('diresa')."' and red = '".$this->session->userdata('red')."' and microred = '".$this->session->userdata('microred')."' and ano = ".$anio." and substr(e_salud,7,1) = '".$this->session->userdata('institucion')."'";						
				}else{
					$where = " where sub_reg_nt = '".$this->session->userdata('diresa')."' and red = '".$this->session->userdata('red')."' and microred = '".$this->session->userdata('microred')."' and ano = ".$anio;						
				}
			break;
			case 8:
			$where = " a where e_salud = '".$this->session->userdata('establecimiento')."' and ano = ".$anio;
			break;
			default:
				if($this->session->userdata('institucion') <> 'A'){
					$where = " a where ano = ".$anio." and substr(e_salud,7,1) = '".$this->session->userdata('institucion')."'";
				}else{
					$where = " a where ano = ".$anio;
				}
			break;
		}
		
		break;

		case 5:
		$namet = 'cobertura';

		//$lineas = $this->frontend_model->buscaCierre($anio);
		
		$param1 = 'cobertura';
	
		switch($this->session->userdata('nivel'))
		{
			case 4:
				if($this->session->userdata('institucion') <> 'A'){
					$where = " a where ano = ".$anio." and substr(e_salud,7,1) = '".$this->session->userdata('institucion')."'";
				}else{
					$where = " a where ano = ".$anio;
				}
			break;
			case 5:
				if($this->session->userdata('institucion') <> 'A'){
					$where = " where sub_reg_nt = '".$this->session->userdata('diresa')."' and ano = ".$anio." and substr(e_salud,7,1) = '".$this->session->userdata('institucion')."'";
				}else{
					$where = " where sub_reg_nt = '".$this->session->userdata('diresa')."' and ano = ".$anio;
				}
			break;
			case 6:
				if($this->session->userdata('institucion') <> 'A'){
					$where = " where sub_reg_nt = '".$this->session->userdata('diresa')."' and red = '".$this->session->userdata('red')."' and ano = ".$anio." and substr(e_salud,7,1) = '".$this->session->userdata('institucion')."'";
				}else{
					$where = " where sub_reg_nt = '".$this->session->userdata('diresa')."' and red = '".$this->session->userdata('red')."' and ano = ".$anio;
				}
			break;
			case 7:
				if($this->session->userdata('institucion') <> 'A'){
					$where = " where sub_reg_nt = '".$this->session->userdata('diresa')."' and red = '".$this->session->userdata('red')."' and microred = '".$this->session->userdata('microred')."' and ano = ".$anio." and substr(e_salud,7,1) = '".$this->session->userdata('institucion')."'";						
				}else{
					$where = " where sub_reg_nt = '".$this->session->userdata('diresa')."' and red = '".$this->session->userdata('red')."' and microred = '".$this->session->userdata('microred')."' and ano = ".$anio;						
				}
			break;
			case 8:
			$where = " a where e_salud = '".$this->session->userdata('establecimiento')."' and ano = ".$anio;
			break;
			default:
				if($this->session->userdata('institucion') <> 'A'){
					$where = " a where ano = ".$anio." and substr(e_salud,7,1) = '".$this->session->userdata('institucion')."'";
				}else{
					$where = " a where ano = ".$anio;
				}
			break;
		}
		
		break;
	}
	
	$row = $this->frontend_model->exportarInd_1($param1,$where);
	
	if($row->cantidad == 0){
		//$this->session->set_flashdata('error', 'No hay información para el nivel solicitado');
		redirect(site_url('exportar'), 301);
	}
	
	$maximo = $row->cantidad;
	
	$limite = ceil($maximo / 10);
	
	$usuario = $this->session->userdata('usuario');
	
	$NombreArchivo = $usuario.date("dmYHis").".dbf";
	
	if($namet != "cobertura"){
		$ruta_dbO = getcwd()."/public/images/".$namet."_sp.dbf";
	}else{
		$ruta_dbO = getcwd()."/public/images/".$namet.".dbf";
	}
	
	$ruta_db = getcwd().'/uploads/'.$NombreArchivo;
	
	copy ($ruta_dbO,$ruta_db) or die("no se pudo generar el molde");
	
	// Abrir el archivo dbase
	$dbh = dbase_open($ruta_db, 2) or die("¡Error! No se pudo abrir el archivo de base de datos dbase ".$ruta_db);
	
	switch($base)
	{
		case 1:
		
		$row = $this->frontend_model->exportarInd($param1,$where,$puntero,$limite);
		
		foreach($row as $data) 
		{
			dbase_add_record($dbh,array($data->ANO,	$data->SEMANA, $data->DIAGNOSTIC, $data->TIPO_DX,
			$data->SUBREGION, $data->UBIGEO, $data->LOCALCOD, $data->LOCALIDAD, utf8_decode($data->APEPAT), utf8_decode($data->APEMAT),
			utf8_decode($data->NOMBRES), $data->EDAD, $data->TIPO_EDAD, $data->SEXO,	$data->PROTEGIDO, $data->FECHA_INI,
			$data->FECHA_DEF, $data->FECHA_NOT, $data->FECHA_INV, $data->SUB_REG_NT, $data->RED, $data->MICRORED,
			$data->E_SALUD,	$data->SEMANA_NOT, $data->AN_NOTIFIC, $data->FECHA_ING,	$data->FICHA_INV,
			$data->TIPO_NOTI, $data->CLAVE,	$data->IMPORTADO, $data->MIGRADO, $data->VERIFICA, $data->DNI,
			$data->MUESTRA, $data->HC, $data->ESTADO, $data->TIP_ZONA, $data->COD_PAIS, $data->TIPO_ID,
			$data->DIRECCION, $data->ETNIAPROC, $data->ETNIAS, $data->PROCEDE, $data->OTROPROC));
			$contador = $contador + 1;
		}
		break;
		case 2:
		$row = $this->frontend_model->exportarEda($param1,$where,$puntero,$limite);
		
		foreach($row as $data) 
		{
			dbase_add_record($dbh,array($data->ANO,	$data->SEMANA, 
			$data->SUB_REG_NT, $data->RED, $data->MICRORED, $data->E_SALUD,	$data->UBIGEO, $data->DAA_C1,
			$data->DAA_C1_4, $data->DAA_C5, $data->DAA_D1, $data->DAA_D1_4, $data->DAA_D5, $data->DAA_H1,
			$data->DAA_H1_4, $data->DAA_H5, $data->COL_C1, $data->COL_C1_4, $data->COL_C5, $data->COL_D1, 
			$data->COL_D1_4, $data->COL_D5, $data->COL_H1, $data->COL_H1_4, $data->COL_H5, $data->DIS_C1,
			$data->DIS_C1_4, $data->DIS_C5, $data->DIS_D1, $data->DIS_D1_4, $data->DIS_D5, $data->DIS_H1,
			$data->DIS_H1_4, $data->DIS_H5, $data->COP_T1, $data->COP_T1_4, $data->COP_T5, $data->COP_P1, 
			$data->COP_P1_4, $data->COP_P5, $data->COP_S1, $data->COP_S1_4, $data->COP_S5, $data->FECHA_ING,
			$data->CLAVE, $data->MIGRADO, $data->VERIFICA, $data->ETAPA, $data->ESTADO, $data->ETNIAPROC,
			$data->ETNIAS, $data->PROCEDE, $data->OTROPROC));
			$contador = $contador + 1;
		}
		break;
		case 3:
		$row = $this->frontend_model->exportarIra($param1,$where,$puntero,$limite);
	
		foreach($row as $data) 
		{
			dbase_add_record($dbh,array($data->ANO,	$data->SEMANA, $data->SUB_REG_NT, $data->RED, $data->MICRORED, $data->E_SALUD, 
			$data->UBIGEO, $data->IRA_M2, $data->IRA_2_11, $data->IRA_1_4A, $data->NEU_2_11, $data->NEU_1_4A, $data->HOS_M2,
			$data->HOS_2_11, $data->HOS_1_4A, $data->NGR_M2, $data->NGR_2_11, $data->NGR_1_4A, $data->DIH_M2, $data->DIH_2_11, 
			$data->DIH_1_4A, $data->DEH_M2, $data->DEH_2_11, $data->DEH_1_4A, $data->SOB_2A, $data->SOB_2_4A, $data->FECHA_ING, 
			$data->CLAVE, $data->MIGRADO, $data->VERIFICA, $data->ETAPA, $data->IRA_5_9A, $data->IRA_60A, $data->NEU_5_9A, 
			$data->NEU_60A, $data->HOS_5_9A, $data->HOS_60A, $data->NGR_5_9A, $data->NGR_60A, $data->DIH_5_9A, $data->DIH_60A, 
			$data->DEH_5_9A, $data->DEH_60A, $data->SOB_5_9A, $data->SOB_60A, $data->ESTADO, $data->LOCALCOD, $data->NEU_10_19, 
			$data->NEU_20_59, $data->HOS_10_19, $data->HOS_20_59, $data->DIH_10_19, $data->DIH_20_59, $data->DEH_10_19, 
			$data->DEH_20_59, $data->ETNIAPROC, $data->ETNIAS, $data->PROCEDE, $data->OTROPROC));
			$contador = $contador + 1;
		}
		break;
		case 4:
		$row = $this->frontend_model->exportarFebriles($param1,$where,$puntero,$limite);
	
		foreach($row as $data) 
		{
			dbase_add_record($dbh,array($data->ANO,	$data->SEMANA, $data->SUB_REG_NT, $data->RED, 
			$data->MICRORED, $data->E_SALUD, $data->UBIGEO, $data->FEB_M1, $data->FEB_1_4, $data->FEB_5_9, 
			$data->FEB_10_19, $data->FEB_20_59, $data->FEB_M60, $data->FECHA_ING, $data->CLAVE, 
			'', '', '', '', $data->FEB_TOT, $data->FECHA_NOT, $data->FECHA_ATE, $data->TOT_ATEN));
			$contador = $contador + 1;
		}
		break;
		case 5:
		$row = $this->frontend_model->exportarCobertura($param1,$where,$puntero,$limite);
	
		foreach($row as $data) 
		{
			dbase_add_record($dbh,array($data->ANO,	$data->SEMANA, '0', $data->COD_EST, $data->EST_NOT, 
			$data->REGION, $data->RED, '', $data->MICRORED, $data->SITUACION, $data->FGENERA, 
			$data->HORANOT));
			$contador = $contador + 1;
		}
		break;
	}
	
	dbase_close($dbh); 
	
	$puntero = $puntero + $limite;
	
	$ruta_db = str_replace("\\", "L", $ruta_db);
	$ruta_db = str_replace("/", "L", $ruta_db);
	
	redirect("exportar/exportando"."/".$maximo."/".$contador."/".$puntero."/".$limite."/".$base."/".$anio."/".$ruta_db,301);
}else{
	// Abrir un el archivo dbase
	$dbh = dbase_open($ruta_db, 2) or die("¡Error! No se pudo abrir el archivo de base de datos dbase ".$ruta_db);
	
	switch($base)
	{
		case 1:
		$namet = 'noti';
		
		$lineas = $this->frontend_model->buscaCierre($anio);
		
		if($lineas == 0){
			$param1 = 'individual';
		}else{
			$param1 = 'individual_ant';
		}
	
		switch($this->session->userdata('nivel'))
		{
			case 4:
			if($this->session->userdata('institucion') <> 'A'){
				$where = " a where a.ano = ".$anio." and substr(e_salud,7,1) = '".$this->session->userdata('institucion')."'";
			}else{
				$where = " a left join diagno b on a.diagnostic=b.cie_10 left join tematicos c on b.clave=c.codigo where a.ano = ".$anio." and c.codigo = '".$this->session->userdata('equipo')."'";
			}
			break;
			case 5:
			if($this->session->userdata('institucion') <> 'A'){
				$where = " a where ano = ".$anio." and sub_reg_nt = '".$this->session->userdata('diresa')."' and substr(e_salud,7,1) = '".$this->session->userdata('institucion')."'";
			}else{
				$where = " a where ano = ".$anio." and sub_reg_nt = '".$this->session->userdata('diresa')."'";
			}
			break;
			case 6:
			if($this->session->userdata('institucion') <> 'A'){
				$where = " a where ano = ".$anio." and sub_reg_nt = '".$this->session->userdata('diresa')."' and red = '".$this->session->userdata('red')."' and substr(e_salud,7,1) = '".$this->session->userdata('institucion')."'";
			}else{
				$where = " a where ano = ".$anio." and sub_reg_nt = '".$this->session->userdata('diresa')."' and red = '".$this->session->userdata('red')."'";
			}
			break;
			case 7:
			if($this->session->userdata('institucion') <> 'A'){
				$where = " a where ano = ".$anio." and sub_reg_nt = '".$this->session->userdata('diresa')."' and red = '".$this->session->userdata('red')."' and microred = '".$this->session->userdata('microred')."' and substr(e_salud,7,1) = '".$this->session->userdata('institucion')."'";						
			}else{
				$where = " a where ano = ".$anio." and sub_reg_nt = '".$this->session->userdata('diresa')."' and red = '".$this->session->userdata('red')."' and microred = '".$this->session->userdata('microred')."'";						
			}
			break;
			case 8:
			$where = " a where e_salud = '".$this->session->userdata('establecimiento')."' and ano = ".$anio;
			break;
			default:
			if($this->session->userdata('institucion') <> 'A'){
				$where = " a where ano = ".$anio." and substr(e_salud,7,1) = '".$this->session->userdata('institucion')."'";
			}else{
				$where = " a where ano = ".$anio;
			}
			break;
		}
		
		$row = $this->frontend_model->exportarInd($param1,$where,$puntero,$limite);
		
		foreach($row as $data) 
		{
			dbase_add_record($dbh,array($data->ANO,	$data->SEMANA, $data->DIAGNOSTIC, $data->TIPO_DX,
			$data->SUBREGION, $data->UBIGEO, $data->LOCALCOD, $data->LOCALIDAD, utf8_decode($data->APEPAT), utf8_decode($data->APEMAT),
			utf8_decode($data->NOMBRES), $data->EDAD, $data->TIPO_EDAD, $data->SEXO,	$data->PROTEGIDO, $data->FECHA_INI,
			$data->FECHA_DEF, $data->FECHA_NOT, $data->FECHA_INV, $data->SUB_REG_NT, $data->RED, $data->MICRORED,
			$data->E_SALUD,	$data->SEMANA_NOT, $data->AN_NOTIFIC, $data->FECHA_ING,	$data->FICHA_INV,
			$data->TIPO_NOTI, $data->CLAVE,	$data->IMPORTADO, $data->MIGRADO, $data->VERIFICA, $data->DNI,
			$data->MUESTRA, $data->HC, $data->ESTADO, $data->TIP_ZONA, $data->COD_PAIS, $data->TIPO_ID,
			$data->DIRECCION, $data->ETNIAPROC, $data->ETNIAS, $data->PROCEDE, $data->OTROPROC));
			$contador = $contador + 1;
		}
		break;
		case 2:
		$namet = 'eda';

		$lineas = $this->frontend_model->buscaCierre($anio);
		
		if($lineas == 0){
			$param1 = 'edas';
		}else{
			$param1 = 'edas_ant';
		}
	
		switch($this->session->userdata('nivel'))
		{
			case 4:
			if($this->session->userdata('equipo') == "EDAS"){
				$where = " where ano = ".$anio;
			}else{
				if($this->session->userdata('institucion') <> 'A'){
					$where = " a where ano = ".$anio." and substr(e_salud,7,1) = '".$this->session->userdata('institucion')."'";
				}else{
					$where = " a where ano = ".$anio;
				}
			}
			break;
			case 5:
				if($this->session->userdata('institucion') <> 'A'){
					$where = " where sub_reg_nt = '".$this->session->userdata('diresa')."' and ano = ".$anio." and substr(e_salud,7,1) = '".$this->session->userdata('institucion')."'";
				}else{
					$where = " where sub_reg_nt = '".$this->session->userdata('diresa')."' and ano = ".$anio;
				}
			break;
			case 6:
				if($this->session->userdata('institucion') <> 'A'){
					$where = " where sub_reg_nt = '".$this->session->userdata('diresa')."' and red = '".$this->session->userdata('red')."' and ano = ".$anio." and substr(e_salud,7,1) = '".$this->session->userdata('institucion')."'";
				}else{
					$where = " where sub_reg_nt = '".$this->session->userdata('diresa')."' and red = '".$this->session->userdata('red')."' and ano = ".$anio;
				}
			break;
			case 7:
				if($this->session->userdata('institucion') <> 'A'){
					$where = " where sub_reg_nt = '".$this->session->userdata('diresa')."' and red = '".$this->session->userdata('red')."' and microred = '".$this->session->userdata('microred')."' and ano = ".$anio." and substr(e_salud,7,1) = '".$this->session->userdata('institucion')."'";						
				}else{
					$where = " where sub_reg_nt = '".$this->session->userdata('diresa')."' and red = '".$this->session->userdata('red')."' and microred = '".$this->session->userdata('microred')."' and ano = ".$anio;						
				}
			break;
			case 8:
			$where = " a where e_salud = '".$this->session->userdata('establecimiento')."' and ano = ".$anio;
			break;
			default:
				if($this->session->userdata('institucion') <> 'A'){
					$where = " a where ano = ".$anio." and substr(e_salud,7,1) = '".$this->session->userdata('institucion')."'";
				}else{
					$where = " a where ano = ".$anio;
				}
			break;
		}
		
		$row = $this->frontend_model->exportarEda($param1,$where,$puntero,$limite);
		
		foreach($row as $data) 
		{
			dbase_add_record($dbh,array($data->ANO,	$data->SEMANA, 
			$data->SUB_REG_NT, $data->RED, $data->MICRORED, $data->E_SALUD,	$data->UBIGEO, $data->DAA_C1,
			$data->DAA_C1_4, $data->DAA_C5, $data->DAA_D1, $data->DAA_D1_4, $data->DAA_D5, $data->DAA_H1,
			$data->DAA_H1_4, $data->DAA_H5, $data->COL_C1, $data->COL_C1_4, $data->COL_C5, $data->COL_D1, 
			$data->COL_D1_4, $data->COL_D5, $data->COL_H1, $data->COL_H1_4, $data->COL_H5, $data->DIS_C1,
			$data->DIS_C1_4, $data->DIS_C5, $data->DIS_D1, $data->DIS_D1_4, $data->DIS_D5, $data->DIS_H1,
			$data->DIS_H1_4, $data->DIS_H5, $data->COP_T1, $data->COP_T1_4, $data->COP_T5, $data->COP_P1, 
			$data->COP_P1_4, $data->COP_P5, $data->COP_S1, $data->COP_S1_4, $data->COP_S5, $data->FECHA_ING,
			$data->CLAVE, $data->MIGRADO, $data->VERIFICA, $data->ETAPA, $data->ESTADO, $data->ETNIAPROC,
			$data->ETNIAS, $data->PROCEDE, $data->OTROPROC));
			$contador = $contador + 1;
		}
		break;
		case 3:
		$namet = 'ira';

		$lineas = $this->frontend_model->buscaCierre($anio);
		
		if($lineas == 0){
			$param1 = 'iras';
		}else{
			$param1 = 'iras_ant';
		}
	
		switch($this->session->userdata('nivel'))
		{
			case 4:
			if($this->session->userdata('equipo') == "IRAS"){
				$where = " where ano = ".$anio;
			}else{
				if($this->session->userdata('institucion') <> 'A'){
					$where = " a where ano = ".$anio." and substr(e_salud,7,1) = '".$this->session->userdata('institucion')."'";
				}else{
					$where = " a where ano = ".$anio;
				}
			}
			break;
			case 5:
				if($this->session->userdata('institucion') <> 'A'){
					$where = " where sub_reg_nt = '".$this->session->userdata('diresa')."' and ano = ".$anio." and substr(e_salud,7,1) = '".$this->session->userdata('institucion')."'";
				}else{
					$where = " where sub_reg_nt = '".$this->session->userdata('diresa')."' and ano = ".$anio;
				}
			break;
			case 6:
				if($this->session->userdata('institucion') <> 'A'){
					$where = " where sub_reg_nt = '".$this->session->userdata('diresa')."' and red = '".$this->session->userdata('red')."' and ano = ".$anio." and substr(e_salud,7,1) = '".$this->session->userdata('institucion')."'";
				}else{
					$where = " where sub_reg_nt = '".$this->session->userdata('diresa')."' and red = '".$this->session->userdata('red')."' and ano = ".$anio;
				}
			break;
			case 7:
				if($this->session->userdata('institucion') <> 'A'){
					$where = " where sub_reg_nt = '".$this->session->userdata('diresa')."' and red = '".$this->session->userdata('red')."' and microred = '".$this->session->userdata('microred')."' and ano = ".$anio." and substr(e_salud,7,1) = '".$this->session->userdata('institucion')."'";						
				}else{
					$where = " where sub_reg_nt = '".$this->session->userdata('diresa')."' and red = '".$this->session->userdata('red')."' and microred = '".$this->session->userdata('microred')."' and ano = ".$anio;						
				}
			break;
			case 8:
			$where = " a where e_salud = '".$this->session->userdata('establecimiento')."' and ano = ".$anio;
			break;
			default:
				if($this->session->userdata('institucion') <> 'A'){
					$where = " a where ano = ".$anio." and substr(e_salud,7,1) = '".$this->session->userdata('institucion')."'";
				}else{
					$where = " a where ano = ".$anio;
				}
			break;
		}

		$row = $this->frontend_model->exportarIra($param1,$where,$puntero,$limite);
	
		foreach($row as $data) 
		{
			dbase_add_record($dbh,array($data->ANO,	$data->SEMANA, $data->SUB_REG_NT, $data->RED, $data->MICRORED, $data->E_SALUD, 
			$data->UBIGEO, $data->IRA_M2, $data->IRA_2_11, $data->IRA_1_4A, $data->NEU_2_11, $data->NEU_1_4A, $data->HOS_M2,
			$data->HOS_2_11, $data->HOS_1_4A, $data->NGR_M2, $data->NGR_2_11, $data->NGR_1_4A, $data->DIH_M2, $data->DIH_2_11, 
			$data->DIH_1_4A, $data->DEH_M2, $data->DEH_2_11, $data->DEH_1_4A, $data->SOB_2A, $data->SOB_2_4A, $data->FECHA_ING, 
			$data->CLAVE, $data->MIGRADO, $data->VERIFICA, $data->ETAPA, $data->IRA_5_9A, $data->IRA_60A, $data->NEU_5_9A, 
			$data->NEU_60A, $data->HOS_5_9A, $data->HOS_60A, $data->NGR_5_9A, $data->NGR_60A, $data->DIH_5_9A, $data->DIH_60A, 
			$data->DEH_5_9A, $data->DEH_60A, $data->SOB_5_9A, $data->SOB_60A, $data->ESTADO, $data->LOCALCOD, $data->NEU_10_19, 
			$data->NEU_20_59, $data->HOS_10_19, $data->HOS_20_59, $data->DIH_10_19, $data->DIH_20_59, $data->DEH_10_19, 
			$data->DEH_20_59, $data->ETNIAPROC, $data->ETNIAS, $data->PROCEDE, $data->OTROPROC));
			$contador = $contador + 1;
		}
		break;
		case 4:
		$namet = 'feb';

		$lineas = $this->frontend_model->buscaCierre($anio);
		
		if($lineas == 0){
			$param1 = 'febriles';
		}else{
			$param1 = 'febriles_ant';
		}
	
		switch($this->session->userdata('nivel'))
		{
			case 4:
			if($this->session->userdata('equipo') == "IRAS" or $this->session->userdata('equipo') == "METAX"){
				$where = " where a.ano = ".$anio;
			}else{
				$where = "";
			}
			break;
			case 5:
				if($this->session->userdata('institucion') <> 'A'){
					$where = " where sub_reg_nt = '".$this->session->userdata('diresa')."' and ano = ".$anio." and substr(e_salud,7,1) = '".$this->session->userdata('institucion')."'";
				}else{
					$where = " where sub_reg_nt = '".$this->session->userdata('diresa')."' and ano = ".$anio;
				}
			break;
			case 6:
				if($this->session->userdata('institucion') <> 'A'){
					$where = " where sub_reg_nt = '".$this->session->userdata('diresa')."' and red = '".$this->session->userdata('red')."' and ano = ".$anio." and substr(e_salud,7,1) = '".$this->session->userdata('institucion')."'";
				}else{
					$where = " where sub_reg_nt = '".$this->session->userdata('diresa')."' and red = '".$this->session->userdata('red')."' and ano = ".$anio;
				}
			break;
			case 7:
				if($this->session->userdata('institucion') <> 'A'){
					$where = " where sub_reg_nt = '".$this->session->userdata('diresa')."' and red = '".$this->session->userdata('red')."' and microred = '".$this->session->userdata('microred')."' and ano = ".$anio." and substr(e_salud,7,1) = '".$this->session->userdata('institucion')."'";						
				}else{
					$where = " where sub_reg_nt = '".$this->session->userdata('diresa')."' and red = '".$this->session->userdata('red')."' and microred = '".$this->session->userdata('microred')."' and ano = ".$anio;						
				}
			break;
			case 8:
			$where = " a where e_salud = '".$this->session->userdata('establecimiento')."' and ano = ".$anio;
			break;
			default:
				if($this->session->userdata('institucion') <> 'A'){
					$where = " a where ano = ".$anio." and substr(e_salud,7,1) = '".$this->session->userdata('institucion')."'";
				}else{
					$where = " a where ano = ".$anio;
				}
			break;
		}

		$row = $this->frontend_model->exportarFebriles($param1,$where,$puntero,$limite);
	
		foreach($row as $data) 
		{
			dbase_add_record($dbh,array($data->ANO,	$data->SEMANA, $data->SUB_REG_NT, $data->RED, 
			$data->MICRORED, $data->E_SALUD, $data->UBIGEO, $data->FEB_M1, $data->FEB_1_4, $data->FEB_5_9, 
			$data->FEB_10_19, $data->FEB_20_59, $data->FEB_M60, $data->FECHA_ING, $data->CLAVE, 
			'', '', '', '', $data->FEB_TOT, $data->FECHA_NOT, $data->FECHA_ATE, $data->TOT_ATEN));
			$contador = $contador + 1;
		}
		break;
		case 5:
		$namet = 'cobertura';

		//$lineas = $this->frontend_model->buscaCierre($anio);
		
		$param1 = 'cobertura';
	
		switch($this->session->userdata('nivel'))
		{
			case 4:
				if($this->session->userdata('institucion') <> 'A'){
					$where = " a where ano = ".$anio." and substr(e_salud,7,1) = '".$this->session->userdata('institucion')."'";
				}else{
					$where = " a where ano = ".$anio;
				}
			break;
			case 5:
				if($this->session->userdata('institucion') <> 'A'){
					$where = " where sub_reg_nt = '".$this->session->userdata('diresa')."' and ano = ".$anio." and substr(e_salud,7,1) = '".$this->session->userdata('institucion')."'";
				}else{
					$where = " where sub_reg_nt = '".$this->session->userdata('diresa')."' and ano = ".$anio;
				}
			break;
			case 6:
				if($this->session->userdata('institucion') <> 'A'){
					$where = " where sub_reg_nt = '".$this->session->userdata('diresa')."' and red = '".$this->session->userdata('red')."' and ano = ".$anio." and substr(e_salud,7,1) = '".$this->session->userdata('institucion')."'";
				}else{
					$where = " where sub_reg_nt = '".$this->session->userdata('diresa')."' and red = '".$this->session->userdata('red')."' and ano = ".$anio;
				}
			break;
			case 7:
				if($this->session->userdata('institucion') <> 'A'){
					$where = " where sub_reg_nt = '".$this->session->userdata('diresa')."' and red = '".$this->session->userdata('red')."' and microred = '".$this->session->userdata('microred')."' and ano = ".$anio." and substr(e_salud,7,1) = '".$this->session->userdata('institucion')."'";						
				}else{
					$where = " where sub_reg_nt = '".$this->session->userdata('diresa')."' and red = '".$this->session->userdata('red')."' and microred = '".$this->session->userdata('microred')."' and ano = ".$anio;						
				}
			break;
			case 8:
			$where = " a where e_salud = '".$this->session->userdata('establecimiento')."' and ano = ".$anio;
			break;
			default:
				if($this->session->userdata('institucion') <> 'A'){
					$where = " a where ano = ".$anio." and substr(e_salud,7,1) = '".$this->session->userdata('institucion')."'";
				}else{
					$where = " a where ano = ".$anio;
				}
			break;
		}

		$row = $this->frontend_model->exportarCobertura($param1,$where,$puntero,$limite);
	
		foreach($row as $data) 
		{
			dbase_add_record($dbh,array($data->ANO,	$data->SEMANA, '0', $data->COD_EST, $data->EST_NOT, 
			$data->REGION, $data->RED, '', $data->MICRORED, $data->SITUACION, $data->FGENERA, 
			$data->HORANOT));
			$contador = $contador + 1;
		}
		break;
	}

	dbase_close($dbh); 
	
	if($puntero >= $maximo){
		
		//Actualizando el registro de auditoria
		$this->mantenimiento_model->auditoriaOperador($this->session->userdata('usuario'), 'Descarga de '.$namet.'_sp.dbf');		

		/// descarga del dbf generado
		$filename = $ruta_db;	
		
		if (file_exists($filename)) {
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			
			if($namet != "cobertura"){
				header('Content-Disposition: attachment; filename='.$namet.'_sp.dbf');
			}else{
				header('Content-Disposition: attachment; filename='.$namet.'.dbf');
			}
			
			header('Content-Transfer-Encoding: binary');
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Content-Length: ' . filesize($filename));
			ob_clean();
			flush();
			readfile($filename);
		}else{
			echo "el fichero no se creo";
		}

		unlink(glob().$filename);

		redirect('exportar', refresh);
	}else{
		$puntero = $puntero + $limite;
		
		$ruta_db = str_replace("\\", "L", $ruta_db);
		$ruta_db = str_replace("/", "L", $ruta_db);
	
		redirect("exportar/exportando"."/".$maximo."/".$contador."/".$puntero."/".$limite."/".$base."/".$anio."/".$ruta_db,301);
	}
}
?>	