<?php

class Producto extends MY_Model {
    

    function __construct() {
          parent::__construct();
          $this->table = "Producto";
          $this->vista = "v_Producto";
          $this->idname = "idproducto";
    }



	protected function getWhere($params){
		$search = $params['busqueda'];
		$idpropuesta = $params['idpropuesta'];
		$where = "WHERE idpropuesta=$idpropuesta ";
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

	public function getTipos(){
		$query=$this->db->query("SELECT * FROM ProductoTipo_lang WHERE codlang='es' ORDER BY nombre");
		$resultado=$query->result_array();	
		return $resultado;
	}

	
	public function obtener($idproducto){
		$retorno = array();
		$query = $this->db->query("SELECT * FROM Producto a WHERE idproducto = ?", array($idproducto));
		$result = $query->result_array();
		if(empty($result)){
			return array();
		}
		$retorno['idproducto'] = $idproducto;
		$retorno['idtipo'] = $result[0]['idtipo'];
		$retorno['orden'] = $result[0]['orden'];
		$retorno['archivo'] = $result[0]['archivo'];
		$retorno['numero'] = $result[0]['numero'];
		$retorno['publicado'] = $result[0]['publicado'];
		$paqueteLang = $this->getLanguages($idproducto);
		foreach($paqueteLang as $pl){
			$retorno['nombre_'.$pl['codlang']] = $pl['nombre'];
		}
		return $retorno;
	}


	public function getCantidadDashboard(){
		$query = $this->db->query("SELECT count(*) total FROM Producto ");
		return $query->result_array()[0]['total'];
	}

	public function aceptar($idproducto){
		$query = $this->db->query("UPDATE Producto SET publicado=1 WHERE idproducto=? AND publicado IS NULL", $idproducto);
	}


}
?>
