<?php

class Fontagro extends MY_Model {
    

    function __construct() {
          parent::__construct();
          $this->table = "Fontagro";
          $this->vista = "Fontagro";
          $this->idname = "idfontagro";
    }



	protected function getWhere($params){
		$search = $params['busqueda'];
		$where = "WHERE 1=1 ";
		if(!empty($search)){
			$where .= " ";
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
	
}

?>