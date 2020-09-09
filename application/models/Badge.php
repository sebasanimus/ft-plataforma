<?php

class Badge extends MY_Model {
    

    function __construct() {
          parent::__construct();
          $this->table = "BadgeODS";
          $this->vista = "v_BadgeODS";
          $this->idname = "idbadgeods";
    }



	protected function getWhere($params){
		$search = $params['busqueda'];
		$where = "WHERE 1=1 ";
		if(!empty($search)){
			$where .= "AND (nombre like '%$search%' OR descripcion like '%$search%' ) ";
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
		$query=$this->db->query("SELECT * FROM Webstory_BadgeODS WHERE {$this->idname}=?",$id);
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

	public function getByCode($code, $codlang){
		$query=$this->db->query("SELECT * FROM {$this->table} p JOIN Pais_lang pl ON p.id=pl.id WHERE code=? AND codlang=?", array($code, $codlang));
		$resultado=$query->result_array();
		if (!$resultado || empty($resultado)) {
		  return Array();
		}		
		return $resultado[0];
	}

	public function getByWebstory($idwebstory){
		$query=$this->db->query("SELECT idbadgeods FROM Webstory_BadgeODS WHERE idwebstory=?", array($idwebstory));
		$resultado=$query->result_array();
		$retorno = Array();
		foreach($resultado as $res){
			$retorno[$res['idbadgeods']] = true;
		}
		return $retorno;
	}

	public function getByPerfil($idperfil){
		$query=$this->db->query("SELECT idbadgeods FROM Perfil_BadgeODS WHERE idperfil=?", array($idperfil));
		$resultado=$query->result_array();
		$retorno = Array();
		foreach($resultado as $res){
			$retorno[$res['idbadgeods']] = true;
		}
		return $retorno;
	}

	public function getByWebstoryVista($idwebstory, $lang){
		$query=$this->db->query("SELECT nombre, descripcion, foto 
									FROM Webstory_BadgeODS wb
									JOIN BadgeODS_lang bl ON wb.idbadgeods=bl.idbadgeods
									WHERE idwebstory=? AND codlang=? ", array($idwebstory, $lang));
		$resultado=$query->result_array();
		return $resultado;
	}

	public function getByPropuesta($idpropuesta){
		$query=$this->db->query("SELECT idbadgeods FROM Propuesta_BadgeODS WHERE idpropuesta=?", array($idpropuesta));
		$resultado=$query->result_array();
		$retorno = Array();
		foreach($resultado as $res){
			$retorno[$res['idbadgeods']] = true;
		}
		return $retorno;
	}

	public function getByPropuestaVista($idpropuesta, $lang){
		$query=$this->db->query("SELECT nombre, descripcion, foto 
									FROM Propuesta_BadgeODS pb
									JOIN BadgeODS_lang bl ON pb.idbadgeods=bl.idbadgeods
									WHERE idpropuesta=? AND codlang=? ", array($idpropuesta, $lang));
		$resultado=$query->result_array();
		return $resultado;
	}

	public function actualizarWebstory($idwebstory, $badges){
		$query=$this->db->query("DELETE FROM Webstory_BadgeODS WHERE idwebstory=?", array($idwebstory));
		foreach($badges as $b){
			$query=$this->db->query("INSERT INTO Webstory_BadgeODS(idwebstory, idbadgeods) VALUES(?,?) ", array($idwebstory, $b));
		}
	}

	public function actualizarPropuesta($idpropuesta, $badges){
		$query=$this->db->query("DELETE FROM Propuesta_BadgeODS WHERE idpropuesta=?", array($idpropuesta));
		foreach($badges as $b){
			$query=$this->db->query("INSERT INTO Propuesta_BadgeODS(idpropuesta, idbadgeods) VALUES(?,?) ", array($idpropuesta, $b));
		}
	}
	
}

?>
