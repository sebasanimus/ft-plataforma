<?php

class Item extends MY_Model {
    

    function __construct() {
          parent::__construct();
          $this->table = "Item";
          $this->vista = "v_Item";
          $this->idname = "iditem";
    }



	protected function getWhere($params){
		$search = $params['busqueda'];
		$where = "WHERE idpropuesta=".$params['idpropuesta']." ";
		if(!empty($search)){
			$where .= "AND (organismo like '%$search%') ";
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
	
	public function getAllOrganismoEjecutor(){
		$query=$this->db->query("SELECT DISTINCT idorganismo value, CONCAT(organismo,' - ',pais) label FROM v_Item WHERE participacion='Ejecutor' ORDER BY CONCAT(organismo,' - ',pais) ", array());
		$resultado=$query->result_array();		
		return $resultado;
	}


	public function getAllOrganismo(){
		$query=$this->db->query("SELECT idorganismo value, CONCAT(nombre,' - ',pais) label FROM v_Organismo ORDER BY CONCAT(nombre,' - ',pais) ASC", array());
		$resultado=$query->result_array();		
		return $resultado;
	}
}

?>