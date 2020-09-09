<?php

class Tema extends MY_Model {
    

    function __construct() {
          parent::__construct();
          $this->table = "Tema";
          $this->vista = "v_Tema";
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
		$query=$this->db->query("SELECT * FROM Propuesta_Tema WHERE idtema=?",$id);
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

	public function getTemasPropuesta($idpropuesta){
		$query=$this->db->query("SELECT * FROM Propuesta_Tema WHERE idpropuesta=?", Array($idpropuesta));
		$resultado=$query->result_array();
		$retorno = Array();
		foreach($resultado as $res){
			$retorno[$res['idtema']] = $res;
		}
		return $retorno;
	}

	public function getTemasPerfil($idperfil){
		$query=$this->db->query("SELECT * FROM Perfil_Tema WHERE idperfil=?", Array($idperfil));
		$resultado=$query->result_array();
		$retorno = Array();
		foreach($resultado as $res){
			$retorno[$res['idtema']] = $res;
		}
		return $retorno;
	}

	public function getTemasPerfilTexto($idperfil){
		$query=$this->db->query("SELECT * FROM Perfil_Tema pt
									JOIN Tema_lang tl ON pt.idtema=tl.id AND tl.codlang='es' WHERE idperfil=?", Array($idperfil));		
		return $query->result_array();
	}

	public function getTemasPropuestaTexto($idpropuesta, $codlang){
		$query=$this->db->query("SELECT * FROM Propuesta_Tema pt
									JOIN Tema_lang tl ON pt.idtema=tl.id AND tl.codlang=? WHERE idpropuesta=?", Array($codlang, $idpropuesta));		
		return $query->result_array();
	}

	public function actualizarPropuesta($idpropuesta, $temas){
		$this->db->query("DELETE FROM Propuesta_Tema WHERE idpropuesta=?", Array($idpropuesta));
		if(empty($temas)){
			return;
		}
		foreach($temas as $idtema){
			$this->db->query("INSERT INTO Propuesta_Tema(idtema, idpropuesta) VALUES(?,?)", Array($idtema, $idpropuesta));
		}
	}

	public function getByPropuestaVista($idpropuesta, $lang){
		$query=$this->db->query("SELECT tl.id, nombre 
									FROM Propuesta_Tema pt
									JOIN Tema_lang tl ON pt.idtema=tl.id
									WHERE idpropuesta=? AND codlang=? ", array($idpropuesta, $lang));
		$resultado=$query->result_array();
		return $resultado;
	}

	
}

?>