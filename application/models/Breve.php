<?php

class Breve extends MY_Model {
    

    function __construct() {
          parent::__construct();
          $this->table = "Breve";
          $this->vista = "v_Breve";
          $this->idname = "idbreve";
    }



	protected function getWhere($params){
		$search = $params['busqueda'];
		$where = "WHERE 1=1 ";
		if(!empty($search)){
			$where .= "AND (nombre like '%$search%') ";
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
	
	public function getByIdPais($idpais, $codlang){
		$query=$this->db->query("SELECT * FROM {$this->table} b JOIN Breve_lang bl ON b.idbreve=bl.idbreve WHERE idpais=? AND codlang=?", array($idpais, $codlang));
		$resultado=$query->result_array();
		if (!$resultado || empty($resultado)) {
		  return Array();
		}		
		return $resultado[0];
	}

}

?>