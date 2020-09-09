<?php

class EstadoIniciativa extends MY_Model {
    

    function __construct() {
          parent::__construct();
          $this->table = "Estado_Iniciativa";
          $this->vista = "v_Estado_Iniciativa";
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
		return 'No se puede eliminar un elemento en uso';
	}
	
}

?>