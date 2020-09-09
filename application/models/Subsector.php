<?php

class Subsector extends MY_Model {
    

    function __construct() {
          parent::__construct();
          $this->table = "Subsector";
          $this->vista = "v_Subsector";
          $this->idname = "id";
    }



	protected function getWhere($params){
		$search = $params['busqueda'];
		$where = "WHERE idsector=".$params['idsector'].' ';
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

    public function eliminarSeguro($id){
		$query=$this->db->query("SELECT * FROM Propuesta_Subsector WHERE idsubsector=?",$id);
		$resultado=$query->result_array();
		if(empty($resultado)){
			$query=$this->db->query("DELETE FROM {$this->table} WHERE {$this->idname}=?",$id);
			$query=$this->db->query("DELETE FROM {$this->table}_lang WHERE {$this->idname}=?",$id);
			if($this->loggear){
				$this->db->query("INSERT INTO Logs(entidad, sentencia, idusuario, idprincipal, funcion) VALUES(?,?,?,?,?) ", Array($this->table, "DELETE FROM {$this->table} WHERE {$this->idname}={$id}", $this->session->userdata('idusuario'), $id, 'eliminarSeguro') );
			}
			return '';
		}else{
			return 'No se puede eliminar un elemento en uso';
		}
	}


	public function obtener($idsubsector){
		$retorno = array();
		$query = $this->db->query("SELECT * FROM {$this->table} WHERE {$this->idname} = ?", array($idsubsector));
		$result = $query->result_array();
		if(empty($result)){
			return array();
		}
		$retorno['idsubsector'] = $idsubsector;
		$retorno['idsector'] = $result[0]['idsector'];
		$paqueteLang = $this->getLanguages($idsubsector);
		foreach($paqueteLang as $pl){
			$retorno['nombre_'.$pl['codlang']] = $pl['nombre'];
		}
		return $retorno;
	}

    public function getAllBySector($idsector, $codlang){
        $query=$this->db->query("SELECT sl.id, sl.nombre 
									FROM Subsector s 
									JOIN Subsector_lang sl ON s.id=sl.id WHERE idsector=? AND codlang=? ORDER BY nombre asc", Array($idsector, $codlang));
		$resultado=$query->result_array();
        return $resultado;
	}
	
	public function getSubsectorPropuesta($idpropuesta, $idsector){
		$query=$this->db->query("SELECT ps.idpropuesta, ps.idsubsector 
									FROM Propuesta_Subsector ps 
									JOIN Subsector s ON ps.idsubsector=s.id
									WHERE idpropuesta=? AND s.idsector=?", Array($idpropuesta, $idsector));
		$resultado=$query->result_array();
		$retorno = Array();
		foreach($resultado as $res){
			$retorno[$res['idsubsector']] = $res;
		}
		return $retorno;
	}

	public function actualizarPropuesta($idpropuesta, $subsectores){
		$this->db->query("DELETE FROM Propuesta_Subsector WHERE idpropuesta=?", Array($idpropuesta));
		if(empty($subsectores)){
			return;
		}
		foreach($subsectores as $idsubsector){
			$this->db->query("INSERT INTO Propuesta_Subsector(idsubsector, idpropuesta) VALUES(?,?)", Array($idsubsector, $idpropuesta));
		}
	}

    
    public function getAllByLang($codlang, $order = '', $asc = ''){
        $ordenar = (empty($order))? '': 'ORDER BY '.$order.' '.$asc;
        $query=$this->db->query("SELECT t.id as value, tl.nombre as label, t.idsector FROM {$this->table}_lang tl JOIN {$this->table} t ON t.id=tl.id WHERE codlang=? {$ordenar}", array($codlang));
		$resultado=$query->result_array();
        return $resultado;
    }
	

	public function getSubsectorPerfil($idperfil){
		$query=$this->db->query("SELECT * FROM Perfil_Subsector WHERE idperfil=?", Array($idperfil));
		$resultado=$query->result_array();
		$retorno = Array();
		foreach($resultado as $res){
			$retorno[$res['idsubsector']] = $res;
		}
		return $retorno;
	}
}

?>