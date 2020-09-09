<?php

class Unidad extends MY_Model {
    

    function __construct() {
          parent::__construct();
          $this->table = "Unidad";
          $this->vista = "v_Unidad";
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

	public function getAllByLangComp($codlang, $componente, $indicador){
		$filtrar = '';
		if(empty($componente) && empty($indicador)){
			return $this->getAllByLang($codlang);
		}else{
			if(empty($indicador)){
				$filtrar = 'AND t.componente IN (';
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
			}else{
				$filtrar = 'AND t.indicastandar IN (';
				$primero = true;
				foreach($indicador as $c){
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
		}
        $query=$this->db->query("SELECT ul.id as value, ul.nombre as label 
								FROM Tecnica t JOIN {$this->table}_lang ul ON t.unidad=ul.id
								WHERE ul.codlang=? {$filtrar} GROUP BY ul.id ORDER BY ul.nombre", array($codlang));
		$resultado=$query->result_array();
        return $resultado;
	}
	

    public function eliminarSeguro($id){
		$query=$this->db->query("SELECT * FROM Tecnica WHERE unidad=?",$id);
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
	
}

?>