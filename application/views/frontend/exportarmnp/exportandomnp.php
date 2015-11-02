<?php

$maximo = $datos['maximo'];
$contador = $datos['contador'];
$puntero = $datos['puntero'];
$limite = $datos['limite'];
$anio = $datos['anio'];
$base = $datos['base'];

if($datos['ruta_db'] <> '0'){
	$ruta_db = str_replace("L", "/", $datos['ruta_db']);
}else{
	$ruta_db = "";
}

if($maximo == 0){
	{
		$namet = 'mnp';		
		$param1 = 'mnp';

		switch($this->session->userdata('nivel'))
		{
			case 4:
			if($this->session->userdata('equipo') == "MMATE"){
				$where = " where anio = ".$anio;
			}else{
				$where = "";
			}
			break;			break;
			case 5:
			$where = " where anio = ".$anio." and mnp.diresa = '".$this->session->userdata('diresa')."'";
			break;
			case 6:
			$where = " where anio = ".$anio." and mnp.diresa = '".$this->session->userdata('diresa')."' and mnp.red = '".$this->session->userdata('red')."'";
			break;
			case 7:
			$where = " where anio = ".$anio." and mnp.diresa = '".$this->session->userdata('diresa')."' and mnp.red = '".$this->session->userdata('red')."' and mnp.microred = '".$this->session->userdata('microred')."'";						
			break;
			case 8:
			$where = " where e_salud = '".$this->session->userdata('establecimiento')."' and anio = ".$anio;
			break;
			default:
			$where = " where anio = ".$anio;
			break;
		}
		
	}
	
	$row = $this->frontend_model->exportarInd_1($param1,$where);
	
	if($row->cantidad == 0){
		//$this->session->set_flashdata('error', 'No hay información para el nivel solicitado');
		redirect(site_url('exportamnp'), 301);
	}
	
	$maximo = $row->cantidad;
	
	$limite = ceil($maximo / 10);
	
	$usuario = $this->session->userdata('usuario');
	
	$NombreArchivo = $usuario.date("dmYHis").".dbf";
	$ruta_dbO = getcwd()."/public/images/".$namet.".dbf";
	$ruta_db = getcwd().'/uploads/'.$NombreArchivo;
	
	copy ($ruta_dbO,$ruta_db) or die("no se pudo generar el molde");
	
	// Abrir el archivo dbase
	$dbh = dbase_open($ruta_db, 2) or die("¡Error! No se pudo abrir el archivo de base de datos dbase Richi".$ruta_db);
	
	switch($base)
	{
		case 1:
		
		$row = $this->frontend_model->exportarIndmnp($param1,$where,$puntero,$limite);
		
		foreach($row as $data) 
		{
			dbase_add_record($dbh,array($data->Subregion, $data->Establecim, $data->Redes, $data->MicroRedes, $data->Departamen, $data->Provincia, $data->Distrito, 
			$data->registroId, $data->anio, $data->semana, $data->diresa, $data->red, $data->microred, $data->e_salud, utf8_decode($data->responsabl), utf8_decode($data->ape_nom),
			utf8_decode($data->apepat),utf8_decode($data->apemat),utf8_decode($data->nombres), $data->sexo, $data->edadges, $data->fecha_nac, $data->hora_nac, $data->fecha_mte,  
			$data->hora_mte,  $data->peso_nac,  $data->tipo_mte,  $data->causa_bas,  $data->diagno,  $data->estancia,  $data->lugar_par,  $data->momento,  $data->lugar_mte,  
			$data->dni_madre,  $data->fecha_reg,  $data->usuario,  $data->ubigeo_res,  $data->vida,  $data->codcat,  $data->categoria));
			$contador = $contador + 1;
		}
		break;
	}

	dbase_close($dbh); 
	
	$puntero = $puntero + $limite;
	
	$ruta_db = str_replace("\\", "L", $ruta_db);
	$ruta_db = str_replace("/", "L", $ruta_db);
	
	redirect("exportarmnp/exportandomnp"."/".$maximo."/".$contador."/".$puntero."/".$limite."/".$base."/".$anio."/".$ruta_db,301);
}else{
	// Abrir un el archivo dbase
	$dbh = dbase_open($ruta_db, 2) or die("¡Error! No se pudo abrir el archivo de base de datos dbase 2".$ruta_db);
	
	switch($base)
	{
		case 1:

		$namet = 'mnp';
		$param1 = 'mnp';
	
		switch($this->session->userdata('nivel'))
		{
			case 4:
			if($this->session->userdata('equipo') == "MMATE"){
				$where = " where anio = ".$anio;
			}else{
				$where = "";
			}
			break;
			case 5:
			$where = " where anio = ".$anio." and mnp.diresa = '".$this->session->userdata('diresa')."'";
			break;
			case 6:
			$where = " where anio = ".$anio." and mnp.diresa = '".$this->session->userdata('diresa')."' and mnp.red = '".$this->session->userdata('red')."'";
			break;
			case 7:
			$where = " where anio = ".$anio." and mnp.diresa = '".$this->session->userdata('diresa')."' and mnp.red = '".$this->session->userdata('red')."' and mnp.microred = '".$this->session->userdata('microred')."'";						
			break;
			case 8:
			$where = " where e_salud = '".$this->session->userdata('establecimiento')."' and anio = ".$anio;
			break;
			default:
			$where = " where anio = ".$anio;
			break;
		}
		
		$row = $this->frontend_model->exportarIndmnp($param1,$where,$puntero,$limite);
		
		foreach($row as $data) 
		{
			dbase_add_record($dbh,array($data->Subregion, $data->Establecim, $data->Redes, $data->MicroRedes, $data->Departamen, $data->Provincia, $data->Distrito, 
			$data->registroId, $data->anio, $data->semana, $data->diresa, $data->red, $data->microred, $data->e_salud, utf8_decode($data->responsabl), utf8_decode($data->ape_nom),
			utf8_decode($data->apepat),utf8_decode($data->apemat),utf8_decode($data->nombres), $data->sexo, $data->edadges, $data->fecha_nac, $data->hora_nac, $data->fecha_mte,  
			$data->hora_mte,  $data->peso_nac,  $data->tipo_mte,  $data->causa_bas,  $data->diagno,  $data->estancia,  $data->lugar_par,  $data->momento,  $data->lugar_mte,  
			$data->dni_madre,  $data->fecha_reg,  $data->usuario,  $data->ubigeo_res,  $data->vida,  $data->codcat,  $data->categoria));
			$contador = $contador + 1;
		}
		break;
	}

	dbase_close($dbh); 
	
	if($puntero >= $maximo or $contador >= $maximo){
		
		//Actualizando el registro de auditoria
		$this->mantenimiento_model->auditoriaOperador($this->session->userdata('usuario'), 'Descarga de '.$namet.'.dbf');		

		/// descarga del dbf generado
		$filename = $ruta_db;	
		
		if (file_exists($filename)) {
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename='.$namet.'.dbf');
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

		unlink($filename);

		redirect('exportarmnp', refresh);
	}else{
		$puntero = $puntero + $limite;
		
		$ruta_db = str_replace("\\", "L", $ruta_db);
		$ruta_db = str_replace("/", "L", $ruta_db);
	
		redirect("exportarmnp/exportandomnp"."/".$maximo."/".$contador."/".$puntero."/".$limite."/".$base."/".$anio."/".$ruta_db,301);
	}
}
?>	