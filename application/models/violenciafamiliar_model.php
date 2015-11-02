<?php
class Violenciafamiliar_model extends CI_Model {

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












}