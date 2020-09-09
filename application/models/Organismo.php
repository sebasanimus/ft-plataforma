<?php

class Organismo extends MY_Model {
    

    function __construct() {
          parent::__construct();
          $this->table = "Organismo";
          $this->vista = "v_Organismo";
          $this->idname = "idorganismo";
    }



	protected function getWhere($params){
		$search = $params['busqueda'];
		$where = "WHERE 1=1 ";
		if(!empty($search)){
			$where .= "AND (nombre like '%$search%' OR nombre_largo like '%$search%' OR tipo like '%$search%' OR enuso like '%$search%') ";
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
		$query = $this->db->query("SELECT * FROM {$this->table} w WHERE w.nombre = ? AND w.idpais=?", array($data['nombre']['val'], $data['idpais']['val']));
        $result = $query->result_array();
        if (!$result || empty($result)) {
			return ''; 
		}else{            
            if(sizeof($result)==1 && $result[0][$this->idname] == $id){ //estoy modificando el mismo 
                return ''; 
            }
            return 'sigla-pais de propuesta duplicado';
        }     
	}

    public function eliminarSeguro($id){
		$query=$this->db->query("SELECT * FROM Item WHERE {$this->idname}=?",$id);
		$resultado=$query->result_array();
		if(empty($resultado)){
			$query=$this->db->query("DELETE FROM {$this->table} WHERE {$this->idname}=?",$id);
			if($this->loggear){
				$this->db->query("INSERT INTO Logs(entidad, sentencia, idusuario, idprincipal, funcion) VALUES(?,?,?,?,?) ", Array($this->table, "DELETE FROM {$this->table} WHERE {$this->idname}={$id}", $this->session->userdata('idusuario'), $id, 'eliminarSeguro') );
			}
			return '';
		}else{
			return 'No se puede eliminar un elemento en uso';
		}
	}

	public function getByPropuesta($idpropuesta){
		$query=$this->db->query("SELECT o.idorganismo, o.nombre, o.nombre_largo, o.logo, o.pais 
									FROM v_Organismo o 
									JOIN Item i ON i.idorganismo=o.idorganismo 
									WHERE i.idpropuesta=? AND i.deleted IS NULL GROUP BY o.idorganismo", array($idpropuesta));
		$resultado=$query->result_array();		
		return $resultado;
	}

	public function getByWebstory($idwebstory){
		$query=$this->db->query("SELECT o.idorganismo, o.nombre, o.nombre_largo, o.logo, o.pais
									FROM v_Organismo o 
									JOIN Webstory_organismos i ON i.idorganismo=o.idorganismo 
									WHERE i.idwebstory=? 									
									GROUP BY o.idorganismo", array($idwebstory));
		$resultado=$query->result_array();		
		return $resultado;
	}

	public function getByPropuestaCompleto($idpropuesta, $lang){
		$query=$this->db->query("SELECT *
									FROM Participacion_lang p 
									WHERE codlang=?
									ORDER BY case when id=3 THEN 1
												 when id=2 THEN 2
												 when id=1 THEN 3
												 else 4 END ASC", array($lang));
		$resultado=$query->result_array();	
		foreach($resultado as $key => &$par){
			$query=$this->db->query("SELECT o.idorganismo, o.nombre, o.logo, o.nombre_largo, o.pais 
										FROM v_Organismo o 
										JOIN Item i ON i.idorganismo=o.idorganismo 
										WHERE i.idpropuesta=? AND i.participacion=? AND i.deleted IS NULL GROUP BY o.idorganismo", array($idpropuesta, $par['id']));
			$par['organismos']=$query->result_array();
			if(empty($par['organismos'])){
				unset($resultado[$key]);
			}
		}		
		return $resultado;
	}

	public function getDonantes($idpropuesta){
		$query=$this->db->query("SELECT o.idorganismo, o.nombre, o.nombre_largo, o.logo, o.link, o.pais, d.iddonante, d.orden 
										FROM v_Organismo o 
										JOIN Donante d ON d.idorganismo=o.idorganismo 
										WHERE d.idpropuesta=? ORDER BY d.orden ASC", array($idpropuesta));
		$resultado=$query->result_array();		
		return $resultado;
	}

	public function getDonantesObligados(){ //TRAE BID Y FONTAGRO
		$query=$this->db->query("SELECT o.idorganismo, o.nombre, o.logo, o.link, 0 iddonante, 0 orden 
									FROM Organismo o 									 
									WHERE idorganismo=256 OR idorganismo=257 ORDER BY nombre='FONTAGRO' desc");
		$resultado=$query->result_array();		
		return $resultado;
	}

	public function agregarDonante($idpropuesta, $idorganismo, $orden){
		$query=$this->db->query("INSERT IGNORE INTO Donante(idpropuesta, idorganismo, orden) VALUES(?,?,?)", Array($idpropuesta, $idorganismo, $orden) );
	}

	public function eliminarDonante($iddonante){
		if($this->session->userdata('role')==4){
			$query=$this->db->query("DELETE FROM Donante WHERE iddonante=? AND idpropuesta IN (SELECT idpropuesta FROM Propuesta_usuario WHERE idusuario=?)", Array($iddonante, $this->session->userdata('idusuario')) );
		}else{
			$query=$this->db->query("DELETE FROM Donante WHERE iddonante=?", Array($iddonante) );
		}
	}
	
	public function buscarSelect($search){
		$query=$this->db->query("SELECT o.idorganismo AS id, CONCAT(o.nombre, ' - ',COALESCE(pal.nombre,''), ' - ',COALESCE(o.nombre_largo,'')) as 'text', o.idpais, o.tipo_institucion 
									FROM Organismo o
									LEFT JOIN Pais_lang pal ON o.idpais=pal.id AND pal.codlang = 'es'
									WHERE o.nombre like '%$search%' AND o.habilitado=1");
		$resultado=$query->result_array();		
		return $resultado;
	}

	public function getByTipo($idtipo){
		$whereTipo = (!empty($idtipo) && is_numeric($idtipo))? "tipo_institucion=$idtipo" : "tipo_institucion is null";
		$query=$this->db->query("SELECT o.idorganismo, o.nombre, o.nombre_largo, o.link, o.logo 
									FROM v_Organismo o 									
									WHERE o.logo IS NOT NULL AND enuso IS NOT NULL AND $whereTipo ORDER BY o.nombre ASC");
		$resultado=$query->result_array();		
		return $resultado;
	}
}

?>
