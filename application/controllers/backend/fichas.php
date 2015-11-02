<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fichas extends CI_Controller {

    public function __construct()
    {
		parent::__construct();
        $this->layout->setLayout('template2');
        $this->layout->setTitle(":: NotiWeb :: Vigilancia Epidemiol&oacute;gica");

		if($this->session->userdata('nivel') <> '1'){
            redirect(site_url("backend/index/login"), 301);
		}
	}

    public function _example_output1($output = null)
    {
		$this->layout->view('accesos.php',$output);
    }

    public function _example_output2($output = null)
    {
		$this->layout->view('aplicacion.php',$output);
    }

    public function _example_output4($output = null)
    {
		$this->layout->view('menus.php',$output);
    }

    public function _example_output5($output = null)
    {
		$this->layout->view('databases.php',$output);
    }

    public function index()
    {
		$this->_example_output((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
    }
    
	//Grocery Crud: Listado de Aplicaciones
    public function listarAplicaciones()
    {
		$crud = new grocery_CRUD();

		$crud->set_table('aplicaciones');
		$crud->columns('aplicacion', 'nombre', 'enlace', 'estado');
		$crud->set_subject('Aplicaci&oacute;n');
		$crud->field_type('estado','dropdown',array('1' => 'Activo', '2' => 'Inactivo', '3' => 'Mantenimiento'));         
		
		$output = $crud->render();

		$this->_example_output2($output);
    }

	//Grocery Crud: Listado de Accesos
    public function listarAccesos()
    {
		$aplica = $this->fichas_model->buscarAplicaciones();
		
		$aplicacion = array();
		
		foreach($aplica as $dato)
		{
			$aplicacion[$dato->aplicacion] = $dato->nombre;
		}
		
		$usuarios = $this->fichas_model->buscarUsuarios();
		
		$usu = array();
		
		foreach($usuarios as $dato)
		{
			$usu[$dato->usuario] = $dato->usuario." - ".$dato->nombres;
		}
		
		$crud = new grocery_CRUD();

		$crud->set_table('tablaccesos');
		$crud->columns('aplicacion', 'usuario', 'estado');
		$crud->set_subject('Acceso');
		$crud->field_type('aplicacion','dropdown',$aplicacion);         
		$crud->field_type('usuario','dropdown',$usu);         
		$crud->field_type('estado','dropdown',array('1' => 'Activo', '2' => 'Inactivo', '3' => 'Suspendido'));         

		$crud->unset_print();
		$crud->unset_export();
		$crud->unset_add();

		
		$output = $crud->render();

		$this->_example_output1($output);
    }
	
	public function autorizaFichas($id=null){
		if(!$id)
		{
			show_404();
		}
		
        if($this->input->post()){
			
			$acce = $_POST['acc'];
			
			$this->usuarios_model->borrarAcceso($this->input->post("usuario"));

			foreach($acce as $dato){
				$data = array(
				"aplicacion" => $dato,
				"usuario" => $this->input->post("usuario"),
				"estado" => "1"
				);
					
				$this->usuarios_model->guardarAcceso($data, $this->input->post("usuario"));
					
			}
			
			$this->session->set_flashdata('exito', 'Los accesos han sido grabados con &eacute;xito.');
			redirect('backend/usuario/listarUsuarios', 301);
		}else{
			$operador = $this->usuarios_model->buscarOperadores($id);
			
			if(sizeof($operador)==0)
			{
				show_404();
			}
			
			//$accesos = $this->usuarios_model->tablaAccesos($operador->usuario);
			
			$this->layout->view('autorizar', compact('operador'));
		}
	}

	//Grocery Crud: Listado de Menus de Primer Nivel
    public function listarMenuFicha()
    {
		$aplica = $this->fichas_model->buscarAplicaciones();
		
		$aplicacion = array();
		
		foreach($aplica as $dato)
		{
			$aplicacion[$dato->aplicacion] = $dato->nombre;
		}
		
		$crud = new grocery_CRUD();

		$crud->set_table('menufrontend');
		$crud->columns('aplicacion', 'nombre', 'enlace', 'imagen', 'estado');
		$crud->set_subject('Men&uacute;');
		$crud->field_type('aplicacion','dropdown',$aplicacion);         
		$crud->field_type('estado','dropdown',array('1' => 'Activo', '2' => 'Inactivo', '3' => 'Suspendido')); 
		
		$output = $crud->render();

		$this->_example_output4($output);
    }

	function monitoreatest()
	{
	$output = '';
	$query_rsbase="SELECT * FROM aplicaciones";
	$rsbase = $this->db->query($query_rsbase);
	$row_rsbase = $rsbase->result();
	$totalRows_rsbase =$rsbase->num_rows();
	
	if ($totalRows_rsbase > 0) { // Show if recordset not empty 
	$output.=' <div class="ui-state-default">test </div>
	<table width="800" border="1" cellpadding="0" cellspacing="0">
	<tr class="rs_header">';
	foreach($row_rsbase[0] as $k=>$v){
	$output.= "<td align='center'> <span class='cabezas'>".$k."</span> </td>"; 
	} 
	$output.= ' </tr> ';
	
	for ($i=1; $i<=$totalRows_rsbase; $i++) { 
	$output.= '<tr>';
	foreach($row_rsbase[$i-1] as $k=>$v){
	$output.= "<td align='center'>".$v."</td>"; 
	} 
	
	$output.= ' </tr>';
	} ; 
	$output.= ' </table>'; 
	echo $output;
	}
	
	}
    //Generar backup de la base de datos
    public function asistente()
    {
		set_time_limit(90);
		
		$tables = array();
		$result = $this->mantenimiento_model->mostrarTablas();
		
		$i = 0;
		foreach($result as $dato){
			$tables[$i] = $dato->Tables_in_maestro;
			$i++;
		}
		
		//cycle through
		foreach($tables as $table){
			$result = $this->mantenimiento_model->listarTablas($table);
			$num_rows = $this->mantenimiento_model->numerarLineas($table);
			$num_fields = $this->mantenimiento_model->numerarColumnas($table);
			
			$return.= 'DROP TABLE '.$table.';';
			$row2 = $this->mantenimiento_model->crearTablas($table);
			
			$i = 0;
			foreach($row2 as $dato){
				$create[$i] = $dato;
				$i++;
			}
			$return.= "\n\n".$create[1].";\n\n";
			
			for ($i = 0; $i < $num_rows; $i++){
				$return.= 'INSERT INTO '.$table.' VALUES(';
				$j = 0;
				foreach($result[$i] as $dato=>$valor){
			   		$return.= '"'.$valor.'"'; 
					   	
					if ($j<($num_fields-1)) { 
						$return.= ','; 
					}
					$j++;
				 }
				$return.= ");\n";
			}
		}
		$return.="\n\n\n";

		$nombreArchivo = 'db-backup-'.date("dmY").'-'.(md5(implode(',',$tables))).'.sql';
		
		header ("Content-Type: application/download");
		header ("Content-Disposition: attachment; filename=$nombreArchivo");
		echo $return;
	}
	
    //Llena el combo redes
	public function llenaRedes()
	{
		$filtro = $this->input->get('diresa');
		foreach ($this->mantenimiento_model->buscarRedes($filtro) as $red) {
			$redes[$red->codigo] = $red->nombre;
		}
		echo json_encode($redes);
	}

    //Llena el combo redes
	public function llenaMicroredes()
	{
		$filtro1 = $this->input->get('diresa');
		$filtro2 = $this->input->get('redes');
										   
		foreach ($this->mantenimiento_model->buscarMicroredes($filtro1, $filtro2) as $mred) {
			$microred[$mred->codigo] = $mred->nombre;
		}
		
		echo json_encode($microred);
	}

    //Llena el combo establecimientos
	public function llenaEstablec()
	{
		$filtro1 = $this->input->get('diresa');
		$filtro2 = $this->input->get('redes');
		$filtro3 = $this->input->get('microred');
										   
		foreach ($this->mantenimiento_model->buscarEstablec($filtro1, $filtro2, $filtro3) as $est) {
			$establec[$est->cod_est] = $est->raz_soc;
		}
		
		echo json_encode($establec);
	}
}
