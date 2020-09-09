<?php

class WSPais extends MY_Model {
    

    function __construct() {
          parent::__construct();
          $this->table = "Webstory_organismos";
          $this->vista = "v_Webstory_organismos";
          $this->idname = "idwebstoryorganismo";
    }

	protected function getWhere($params){
		$search = $params['busqueda'];
		$where = "WHERE idwebstory=".$params['idwebstory']." ";
		if(!empty($search)){
			$where .= "AND (nombre_pais like '%$search%' OR organismo like '%$search%') ";
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
	
	
	public function obtener($idwebstory, $idwebstoryorganismo){
		$retorno = array();
		$query = $this->db->query("SELECT * FROM {$this->table} a WHERE idwebstory=? AND {$this->idname} = ?", array($idwebstory, $idwebstoryorganismo));
		$result = $query->result_array();
		if(empty($result)){
			return array();
		}
		$retorno['idwebstoryorganismo'] = $idwebstoryorganismo;
		$retorno['idwebstory'] = $result[0]['idwebstory'];
		$retorno['idorganismo'] = $result[0]['idorganismo'];
		$retorno['pais'] = $result[0]['pais'];		
		return $retorno;
	}

	public function getByWebstory($idwebstory, $lang){
		$query = $this->db->query("SELECT icono, nombre, valor 
									FROM Webstory_organismos i 
									WHERE i.idwebstory=? ", array($idwebstory));
		$result = $query->result_array();
		return $result;
	}
}

?>