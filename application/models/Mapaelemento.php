<?php

class Mapaelemento extends MY_Model {
    

    function __construct() {
          parent::__construct();
          $this->table = "MapaElemento";
          $this->vista = "v_MapaElemento";
          $this->idname = "idmapaelemento";
    }



	protected function getWhere($params){
		$search = $params['busqueda'];
		$where = "WHERE idmapa=".$params['idmapa']." ";
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

	public function getByMapa($idmapa){
		$retorno = array();
		$query = $this->db->query("SELECT * FROM {$this->table} e JOIN {$this->table}_lang el ON e.idmapaelemento=el.idmapaelemento
										WHERE idmapa=? AND deleted IS NULL ORDER BY e.idmapaelemento ASC", array($idmapa));
		$result = $query->result_array();
		$retorno = Array();
		foreach($result as $res){
			if(!isset($retorno[$res['idmapaelemento']])){
				$aux = Array( 
						'idelemento' => $res['idmapaelemento'],
						'tipo' => $res['tipo'],
						'latlng' => json_decode($res['latlng'], TRUE),
						'foto' => $res['foto'],
						'link' => $res['link'],
						'esppal' => $res['esppal']);
				$retorno[$res['idmapaelemento']] = $aux;
			}
			$retorno[$res['idmapaelemento']]['nombre_'.$res['codlang']] = $res['nombre'];
			$retorno[$res['idmapaelemento']]['descripcion_'.$res['codlang']] = $res['descripcion'];
		}
		return $retorno;
	}
	
	public function eliminarEliminados($idmapa, $seSalvan){
		if(empty($seSalvan)){
			$query = $this->db->query("UPDATE {$this->table} SET deleted=now() WHERE idmapa=? AND deleted IS NULL ", array($idmapa));
		}else{
			$query = $this->db->query("UPDATE {$this->table} SET deleted=now() WHERE idmapa=? AND deleted IS NULL AND idmapaelemento NOT IN ? ", array($idmapa, $seSalvan));
		}
		
	}
}

?>