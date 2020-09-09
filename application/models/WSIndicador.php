<?php

class WSIndicador extends MY_Model {
    

    function __construct() {
          parent::__construct();
          $this->table = "Webstory_Indicador";
          $this->vista = "v_Webstory_Indicador";
          $this->idname = "idwebstoryindicador";
    }

	protected function getWhere($params){
		$search = $params['busqueda'];
		$where = "WHERE idwebstory=".$params['idwebstory']." ";
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
	
	
	public function obtener($idwebstory, $idwebstoryindicador){
		$retorno = array();
		$query = $this->db->query("SELECT * FROM {$this->table} a WHERE idwebstory=? AND {$this->idname} = ?", array($idwebstory, $idwebstoryindicador));
		$result = $query->result_array();
		if(empty($result)){
			return array();
		}
		$retorno['idwebstoryindicador'] = $idwebstoryindicador;
		$retorno['idwebstory'] = $result[0]['idwebstory'];
		$retorno['icono'] = $result[0]['icono'];
		$retorno['valor'] = $result[0]['valor'];
		$retorno['prefijo'] = $result[0]['prefijo'];
		$retorno['unidad'] = $result[0]['unidad'];
		$paqueteLang = $this->getLanguages($idwebstoryindicador);
		foreach($paqueteLang as $pl){
			$retorno['nombre_'.$pl['codlang']] = $pl['nombre'];
		}
		return $retorno;
	}

	public function getByWebstory($idwebstory, $lang, $limit=4){
		$query = $this->db->query("SELECT icono, nombre, valor, prefijo, unidad 
									FROM Webstory_Indicador i 
									JOIN Webstory_Indicador_lang il ON il.idwebstoryindicador = i.idwebstoryindicador
									WHERE i.idwebstory=? AND il.codlang=? LIMIT ?", array($idwebstory, $lang, $limit));
		$result = $query->result_array();
		return $result;
	}
}

?>