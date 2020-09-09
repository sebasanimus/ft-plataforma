<?php

class Areainvestigacion extends MY_Model {
    

    function __construct() {
          parent::__construct();
          $this->table = "Areainvestigacion";
          $this->vista = "v_Areainvestigacion";
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
		$query=$this->db->query("SELECT * FROM Propuesta WHERE idareainvestigacion=?",$id);
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

	public function migrar(){
		$query=$this->db->query("SELECT idpropuesta FROM Propuesta");
		$propuestas=$query->result_array();
		foreach($propuestas as $prop){
			$query=$this->db->query("SELECT codlang, area_investigacion FROM Propuesta_lang WHERE idpropuesta=?",$prop['idpropuesta']);
			$areas = $query->result_array();
			$areacod = Array();
			foreach($areas as $area){
				$areacod[$area['codlang']] = $area['area_investigacion'];
			}
			$query = $this->db->query("SELECT id FROM Areainvestigacion_lang WHERE codlang='es' AND nombre like ? ", trim($areacod['es']));
			$yaExiste = $query->result_array();
			if(empty($yaExiste)){
				$this->db->query("INSERT INTO Areainvestigacion(id) VALUES(null)");
				$idareainvestigacion = $this->db->insert_id();
				$this->db->query("INSERT INTO Areainvestigacion_lang(id, codlang, nombre) VALUES(?,?,?)", Array($idareainvestigacion, 'es', trim($areacod['es'])));
				$this->db->query("INSERT INTO Areainvestigacion_lang(id, codlang, nombre) VALUES(?,?,?)", Array($idareainvestigacion, 'en', trim($areacod['en'])));
				$this->db->query("UPDATE Propuesta SET idareainvestigacion=? WHERE idpropuesta=?", Array($idareainvestigacion, $prop['idpropuesta']));
			}else{
				$this->db->query("UPDATE Propuesta SET idareainvestigacion=? WHERE idpropuesta=?", Array($yaExiste[0]['id'], $prop['idpropuesta']));
			}

		}
	}
	
}

?>