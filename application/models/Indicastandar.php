<?php

class Indicastandar extends MY_Model {
    

    function __construct() {
          parent::__construct();
          $this->table = "Indicastandar";
          $this->vista = "v_Indicastandar";
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
		$query=$this->db->query("SELECT * FROM Tecnica WHERE indicastandar=?",$id);
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
	

	public function getAllByLangComp($codlang, $componente){
		$filtrar = '';
		if(!empty($componente)){
			$filtrar = 'AND i.componente IN (';
			$primero = true;
			foreach($componente as $c){
				$valor = is_array($c)? $c['value']: $c;
				if(is_numeric($valor)){
					if($primero){
						$primero=false;					
					}else{
						$filtrar .= ',';
					}				
					$filtrar .= $valor;
				}				
			}
			$filtrar .= ')';
		}
        $query=$this->db->query("SELECT il.id as value, il.nombre as label 
								FROM {$this->table} i JOIN {$this->table}_lang il ON i.id=il.id
								WHERE il.id<>9 AND il.codlang=? {$filtrar} ORDER BY il.nombre", array($codlang));
		$resultado=$query->result_array();
        return $resultado;
    }
}

?>