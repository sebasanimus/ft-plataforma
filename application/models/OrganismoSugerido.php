<?php

class OrganismoSugerido extends MY_Model {
    

    function __construct() {
          parent::__construct();
          $this->table = "Organismo_Sugerido";
          $this->vista = "v_Organismo_Sugerido";
          $this->idname = "idsugerido";
    }



	protected function getWhere($params){
		$search = $params['busqueda'];
		$where = "WHERE 1=1 ";
		if(!empty($search)){
			$where .= "AND (nombre like '%$search%' OR nombre_largo like '%$search%' OR usuario like '%$search%' OR pais like '%$search%' ) ";
		}
		return $where;
	}

	protected function getWhereObligado(){
		return '';
	}

    
    protected function validar($id, $data){
        $sar = parent::validar($id, $data);
        if(!empty($sar)){
            return $sar;
		}   	
		return '';     
	}

	public function setAprobado($idsugerido){
		$query=$this->db->query("UPDATE {$this->table} SET aprobado=1 WHERE {$this->idname}=?",$idsugerido);
	}

	public function setRechazado($idsugerido, $motivo){
		$query=$this->db->query("UPDATE {$this->table} SET aprobado=0, motivo=? WHERE {$this->idname}=?", Array($motivo, $idsugerido));
	}
}

?>
