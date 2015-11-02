<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Exportar extends CI_Controller {
	
    private $session_id;

	public function __construct()
    {
        parent::__construct();
        $this->layout->setLayout('template2');
        $this->layout->setTitle(":: NotiWeb :: Vigilancia Epidemiol&oacute;gica");
        $this->session_id = $this->session->userdata('usuario');
		date_default_timezone_set('America/Lima');

		if($this->session->userdata('nivel') <> '1'){
            redirect(site_url("backend/index/login"), 301);
		}
	}
	
	public function index()
    {
        if($this->input->post()){
            if ($this->form_validation->run("exportar/exportar"))
            {
				switch($this->input->post('baseExport'))
				{
					case 1:
					$namet = 'noti';
					$param1 = 'individual';

					$where = " a where ano = ".$this->input->post('anoExport');
					break;
					case 2:
					$namet = 'eda';
					$param1 = 'edas';

					$where = " where ano = ".$this->input->post('anoExport');
					break;
					case 3:
					$namet = 'ira';
					$param1 = 'iras';

					$where = " where ano = ".$this->input->post('anoExport');
					break;
					case 4:
					$namet = 'feb';
					$param1 = 'febriles';

					$where = " where ano = ".$this->input->post('anoExport');
					break;
				}
				
				$usuario = $this->session->userdata('usuario');

				$NombreArchivo = $usuario.date("dmYHis").".dbf";
				$ruta_dbO = getcwd()."/public/images/".$namet."_sp.dbf";
				$ruta_db = getcwd()."/uploads/$NombreArchivo";
				
				copy ($ruta_dbO,$ruta_db) or die("no se pudo generar el molde");
				
				// Abrir un el archivo dbase
				$dbh = dbase_open($ruta_db, 2) or die("¡Error! No se pudo abrir el archivo de base de datos dbase '$ruta_db'.");
				
				switch($this->input->post('baseExport'))
				{
					case 1:
					$row = $this->frontend_model->exportarInd($param1,$where);
					
					if(count($row) == 0){
						$this->session->set_flashdata('info', 'No hay información para el nivel solicitado');
						redirect(site_url('backend/exportar/exportar'), 301);
					}
					
					foreach($row as $data) 
					{
						dbase_add_record($dbh,array($data->ANO,	$data->SEMANA, $data->DIAGNOSTIC, $data->TIPO_DX,
						$data->SUBREGION, $data->UBIGEO, $data->LOCALCOD, $data->LOCALIDAD, $data->APEPAT, $data->APEMAT,
						$data->NOMBRES, $data->EDAD, $data->TIPO_EDAD, $data->SEXO,	$data->PROTEGIDO, $data->FECHA_INI,
						$data->FECHA_DEF, $data->FECHA_NOT, $data->FECHA_INV, $data->SUB_REG_NT, $data->RED, $data->MICRORED,
						$data->E_SALUD,	$data->SEMANA_NOT, $data->AN_NOTIFIC, $data->FECHA_ING,	$data->FICHA_INV,
						$data->TIPO_NOTI, $data->CLAVE,	$data->IMPORTADO, $data->MIGRADO, $data->VERIFICA, $data->DNI,
						$data->MUESTRA, $data->HC, $data->ESTADO, $data->TIP_ZONA, $data->COD_PAIS, $data->TIPO_ID,
						$data->DIRECCION, $data->ETNIAPROC, $data->ETNIAS, $data->PROCEDE, $data->OTROPROC));
					}
					break;
					case 2:
					$row = $this->frontend_model->exportarEda($param1,$where);
					
					if(count($row) == 0){
						$this->session->set_flashdata('info', 'No hay información para el nivel solicitado');
						redirect(site_url('backend/exportar/exportar'), 301);
					}
				
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
					}
					break;
					case 3:
					$row = $this->frontend_model->exportarIra($param1,$where);
				
					if(count($row) == 0){
						$this->session->set_flashdata('info', 'No hay información para el nivel solicitado');
						redirect(site_url('backend/exportar/exportar'), 301);
					}
				
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
					}
					break;
					case 4:
					$row = $this->frontend_model->exportarFebriles($param1,$where);
				
					if(count($row) == 0){
						$this->session->set_flashdata('info', 'No hay información para el nivel solicitado');
						redirect(site_url('backend/exportar/exportar'), 301);
					}
				
					foreach($row as $data) 
					{
						dbase_add_record($dbh,array($data->ANO,	$data->SEMANA, $data->SUB_REG_NT, $data->RED, 
						$data->MICRORED, $data->E_SALUD, $data->UBIGEO, $data->FEB_M1, $data->FEB_1_4, $data->FEB_5_9, 
						$data->FEB_10_19, $data->FEB_20_59, $data->FEB_M60, $data->FECHA_ING, $data->CLAVE, 
						'', '', '', '', $data->FEB_TOT, $data->FECHA_NOT, $data->FECHA_ATE, $data->TOT_ATEN));
					}
					break;
				}

				dbase_close($dbh); 
				
				/// descarga del dbf generado
				$filename = $ruta_db;	
				
/*				if (file_exists($filename)) {
					header('Content-Description: File Transfer');
					header('Content-Type: application/octet-stream');
					header('Content-Disposition: attachment; filename="'.$namet.'_sp.dbf"');
					header('Content-Transfer-Encoding: binary');
					header('Expires: 0');
					header('Cache-Control: must-revalidate');
					header('Pragma: public');
					header('Content-Length: ' . filesize($filename));
					ob_clean();
					flush();
					readfile($filename);
					exit;
				}else{
					echo "el fichero no se creo";
				}*/
				
				$nombre = $usuario.date("dmYHis").".zip";
				$ruta = getcwd()."/uploads/";
				
				ini_set('memory_limit', '-1');
				
				$this->zip->read_file($filename);
				$this->zip->archive($ruta.$nombre);
				$this->zip->download($nombre);

				//force_download($namet.'_sp.dbf', $filename);
				
				unlink($filename);

				//Actualizando el registro de auditoria
				$this->mantenimiento_model->auditoriaOperador($this->session->userdata('usuario'), 'Descarga de '.$namet.'_sp.dbf');		
				
			}
		}
		
        if(!empty($this->session_id)){
            $this->layout->view('exportar');
        }else{
            redirect(site_url("backend/index/login"), 301);
        }
	}
}