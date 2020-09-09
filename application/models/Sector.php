<?php

class Sector extends MY_Model {
    

    function __construct() {
          parent::__construct();
          $this->table = "Sector";
          $this->vista = "v_Sector";
          $this->idname = "id";
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

    public function eliminarSeguro($id){
		$query=$this->db->query("SELECT * FROM Propuesta_Sector WHERE idsector=?",$id);
		$resultado=$query->result_array();
		if(empty($resultado)){
			$query=$this->db->query("DELETE FROM {$this->table}_lang WHERE {$this->idname}=?",$id);
			$query=$this->db->query("DELETE FROM {$this->table} WHERE {$this->idname}=?",$id);
			if($this->loggear){
				$this->db->query("INSERT INTO Logs(entidad, sentencia, idusuario, idprincipal, funcion) VALUES(?,?,?,?,?) ", Array($this->table, "DELETE FROM {$this->table} WHERE {$this->idname}={$id}", $this->session->userdata('idusuario'), $id, 'eliminarSeguro') );
			}
			return '';
		}else{
			return 'No se puede eliminar un elemento en uso';
		}
	}

	public function getSectorPropuesta($idpropuesta){
		$query=$this->db->query("SELECT * FROM Propuesta_Sector WHERE idpropuesta=?", Array($idpropuesta));
		$resultado=$query->result_array();
		$retorno = Array();
		foreach($resultado as $res){
			$retorno[$res['idsector']] = $res;
		}
		return $retorno;
	}

	public function actualizarPropuesta($idpropuesta, $sectores){
		$this->db->query("DELETE FROM Propuesta_Sector WHERE idpropuesta=?", Array($idpropuesta));
		if(empty($sectores)){
			return;
		}
		foreach($sectores as $idsector){
			$this->db->query("INSERT INTO Propuesta_Sector(idsector, idpropuesta) VALUES(?,?)", Array($idsector, $idpropuesta));
		}
	}
	
}

?>