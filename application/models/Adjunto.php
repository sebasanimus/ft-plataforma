<?php

class Adjunto extends MY_Model {
    

    function __construct() {
          parent::__construct();
          $this->table = "Adjunto";
          $this->vista = "v_Adjunto";
          $this->idname = "idadjunto";
    }



	protected function getWhere($params){
		$search = $params['busqueda'];
		$idmodelo = $params['idmodelo'];
		$modelo = $params['modelo'];
		$where = "WHERE idmodelo=$idmodelo AND modelo='$modelo' ";
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

	public function getTipos($es){
		$where = 'propuestas=1';
		if($es=='webstory'){
			$where = 'webstories=1';
		}
		$query=$this->db->query("SELECT * FROM TipoAdjunto WHERE $where");
		$resultado=$query->result_array();	
		return $resultado;
	}

	
	public function obtener($idadjunto){
		$retorno = array();
		$query = $this->db->query("SELECT * FROM Adjunto a WHERE idadjunto = ?", array($idadjunto));
		$result = $query->result_array();
		if(empty($result)){
			return array();
		}
		$retorno['idadjunto'] = $idadjunto;
		$retorno['orden'] = $result[0]['orden'];
		$retorno['fecha'] = $result[0]['fecha'];
		$retorno['autor'] = $result[0]['autor'];
		$retorno['urlold'] = $result[0]['urlold'];
		$retorno['idtipo'] = $result[0]['idtipo'];
		$retorno['archivo'] = $result[0]['archivo'];
		$retorno['habilitado'] = $result[0]['habilitado'];
		$retorno['link'] = $result[0]['link'];
		$paqueteLang = $this->getLanguages($idadjunto);
		foreach($paqueteLang as $pl){
			$retorno['nombre_'.$pl['codlang']] = $pl['nombre'];
			$retorno['descripcion_'.$pl['codlang']] = $pl['descripcion'];
			$retorno['lugar_'.$pl['codlang']] = $pl['lugar'];
			$retorno['taller_'.$pl['codlang']] = $pl['taller'];
		}
		return $retorno;
	}



	public function getCantidadDashboard(){
		$query = $this->db->query("SELECT count(*) total FROM Adjunto ");
		return $query->result_array()[0]['total'];
	}
}
?>
