<?php

class Pais extends MY_Model {
    

    function __construct() {
          parent::__construct();
          $this->table = "Pais";
          $this->vista = "v_Pais";
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
		$query=$this->db->query("SELECT * FROM Item WHERE pais=?",$id);
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

	public function getPaisesMiembro($codlang){
		$query=$this->db->query("SELECT * FROM {$this->table} p JOIN Pais_lang pl ON p.id=pl.id WHERE esmiembro=1 AND codlang=? ORDER BY pl.nombre ASC", array($codlang));
		$resultado=$query->result_array();	
		return $resultado;
	}

	public function getPaisStat($idpais){
		$query=$this->db->query("SELECT SUM(aporte_contrapartida) contribucion FROM Item WHERE deleted IS NULL AND pais=? AND idpropuesta IN (SELECT idpropuesta FROM Propuesta WHERE deleted is null)", array($idpais));
		$resultado=$query->result_array();	
		$retorno = Array('contribucion'=>$resultado[0]['contribucion']);

		$query=$this->db->query("SELECT SUM(total) participacion 
		FROM Propuesta 
		WHERE deleted IS NULL AND idpropuesta IN (SELECT idpropuesta FROM Item Where pais=? AND deleted is null)", array($idpais));
		$resultado=$query->result_array();	
		$retorno['participacion']=$resultado[0]['participacion'];

		return $retorno;
	}
	
}

?>
