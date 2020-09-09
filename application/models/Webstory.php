<?php

class Webstory extends MY_Model {
    

    function __construct() {
          parent::__construct();
          $this->table = "Webstory";
          $this->vista = "v_Webstory";
          $this->idname = "idwebstory";
    }



	protected function getWhere($params){
		$search = $params['busqueda'];
		$where = "WHERE 1=1 ";
		if(!empty($search)){
			$where .= "AND (titulo_simple like '%$search%' OR identificador like '%$search%' OR url like '%$search%' ) ";
		}
		if($this->session->userdata('role')==4){
			$where .= " AND idpropuesta IN (SELECT idpropuesta FROM Propuesta_usuario WHERE idusuario=".$this->session->userdata('idusuario').") ";
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
		
        $query = $this->db->query("SELECT * FROM {$this->table} w WHERE w.url = ?", array($data['url']['val']));
        $result = $query->result_array();
        if (!$result || empty($result)) {
			return ''; 
		}else{            
            if(sizeof($result)==1 && $result[0][$this->idname] == $id){ //estoy modificando el mismo 
                return ''; 
            }
            return 'url de webstory duplicado';
        }             
	}

	public function insertarAdjunto($idadjunto, $idwebstory){
		$query=$this->db->query("INSERT INTO Webstory_adjunto(idadjunto, idwebstory) VALUES(?, ?)", Array($idadjunto, $idwebstory) );
		if($this->loggear){
			$query=$this->db->query("INSERT INTO Logs(entidad, sentencia, idusuario, idprincipal, funcion) VALUES(?,?,?,?,?) ", Array($this->table, "INSERT INTO Webstory_adjunto(idadjunto, idwebstory) VALUES($idadjunto, $idwebstory)", $this->session->userdata('idusuario'), $idadjunto, 'insertarAdjunto') );
		}
	}


	public function eliminarAdjunto($idadjunto, $idwebstory){
		$query=$this->db->query("DELETE FROM Webstory_adjunto WHERE idadjunto=? AND idwebstory=?", Array($idadjunto, $idwebstory) );
		if($this->loggear){
			$query=$this->db->query("INSERT INTO Logs(entidad, sentencia, idusuario, idprincipal, funcion) VALUES(?,?,?,?,?) ", Array($this->table, "DELETE FROM Webstory_adjunto WHERE idadjunto=$idadjunto AND idwebstory=$idwebstory", $this->session->userdata('idusuario'), $idadjunto, 'eliminarAdjunto') );
		}
	}

	public function getByUrl($url, $lang, $puedeVerBorrador){
		$habilitado = ($puedeVerBorrador) ? '' : 'AND habilitado=1';
		
		$query = $this->db->query("SELECT * 
										FROM Webstory w 
										JOIN Webstory_lang wl ON w.idwebstory=wl.idwebstory 
										WHERE w.url = ? AND wl.codlang = ? AND w.deleted IS NULL $habilitado ", array($url, $lang));
		$result = $query->result_array();
		if(!$result || empty($result)) {
			return Array(); 
		}
		return $result[0];
	}

	public function getByPropuesta($idpropuesta, $lang){		
		$query = $this->db->query("SELECT * 
										FROM Webstory w 
										JOIN Webstory_lang wl ON w.idwebstory=wl.idwebstory 
										WHERE w.idpropuesta = ? AND wl.codlang = ? AND w.deleted IS NULL AND habilitado=1", array($idpropuesta, $lang));
		$result = $query->result_array();
		if(!$result || empty($result)) {
			return Array(); 
		}
		return $result;
	}
	

	public function getAdjuntos($tipo, $idwebstory, $lang){
		$query = $this->db->query("SELECT nombre, archivo 
									FROM Webstory_adjunto wa 
									JOIN Adjunto a ON a.idadjunto = wa.idadjunto 
									JOIN Adjunto_lang al ON al.idadjunto = a.idadjunto AND al.codlang = ?
									WHERE wa.idwebstory = ? AND idtipo=? ORDER BY orden ASC", array($lang, $idwebstory, $tipo));
		$result = $query->result_array();
		if(!$result || empty($result)) {
			return Array(); 
		}
		return $result;
	}

	public function getPaises($idwebstory, $idpropuesta,  $lang){
		$query = $this->db->query("SELECT p.id, p.code, pl.nombre, 1 participacion
									FROM Webstory_organismos i
									JOIN Pais p ON i.pais=p.id
									JOIN Pais_lang pl ON pl.id=p.id AND codlang = ? 
									WHERE i.idwebstory = ?
									AND p.id NOT IN (SELECT pais FROM Item WHERE deleted is null AND idpropuesta=?)
									GROUP BY p.code
									ORDER BY pl.nombre ASC", array($lang, $idwebstory, $idpropuesta));
		$result = $query->result_array();
		if(!$result || empty($result)) {
			return Array(); 
		}
		return $result;		
	}

	public function getInfoPropuesta($idwebstory, $lang){
		//al.nombre area_investigacion, rl.nombre rubro, LEFT JOIN Rubro_lang rl ON p.idrubro=rl.id AND rl.codlang = ?	LEFT JOIN Areainvestigacion_lang al ON p.idareainvestigacion=al.id AND al.codlang = ?
		$query = $this->db->query("SELECT  spl.nombre sector_productivo, el.nombre estrategica, il.nombre investigacion, sl.nombre solucion, p.linea_estrategica, p.solucion_tecnologica, p.web_url, p.web_publicado, p.urlvieja
									FROM Webstory w
									JOIN Propuesta p ON p.idpropuesta = w.idpropuesta
									LEFT JOIN Propuesta_lang pl ON pl.idpropuesta = p.idpropuesta AND pl.codlang = ? 
									LEFT JOIN Estrategica_lang el ON p.linea_estrategica=el.id AND el.codlang = ?
									LEFT JOIN Investigacion_lang il ON p.tipo_investigacion=il.id AND il.codlang = ?
									LEFT JOIN Solucion_lang sl ON p.solucion_tecnologica=sl.id AND sl.codlang = ?	
									LEFT JOIN v_Sectores_lang spl ON spl.idpropuesta=p.idpropuesta AND spl.codlang= ?									
									WHERE w.idwebstory = ? AND w.deleted IS NULL", array($lang, $lang, $lang, $lang, $lang, $idwebstory));
		$result = $query->result_array();
		if(!$result || empty($result)) {
			return Array(); 
		}
		return $result[0];		
	}

	public function getOtrasWS($idwebstory, $lang){
		$query = $this->db->query("SELECT w.foto_principal as foto, w.foto_link, w.url, wl.titulo
									FROM Webstory w
									JOIN Webstory_lang wl ON w.idwebstory=wl.idwebstory	AND wl.codlang=?							
									WHERE w.habilitado=1 AND w.idwebstory<>? AND w.deleted IS NULL ORDER BY RAND() LIMIT 6 ", array($lang, $idwebstory));
		return $query->result_array();	

		/*
		Solucion que se supone es más rapida cuando sean muchos registros, pero selecciona repetidas
		$query = $this->db->query("SELECT count(*) total FROM Webstory w WHERE w.habilitado=1");
		$total = $query->result_array()[0]['total']-1;
		$retorno = array();
		for($i=0; $i<6; $i++){		
			$rando = rand(0,$total);
			$query = $this->db->query("SELECT w.foto_principal as foto, w.url, wl.titulo
										FROM Webstory w
										JOIN Webstory_lang wl ON w.idwebstory=wl.idwebstory	AND wl.codlang=?							
										WHERE w.habilitado=1 LIMIT ?,1 ", array($lang, $rando));
			$result = $query->result_array();	
			$retorno[$i] = $result[0];
		}	
		return $retorno;	*/	
	}

	public function getTodasWS($lang){
		$query = $this->db->query("SELECT w.foto_principal as foto, w.foto_link, w.url, wl.titulo
									FROM Webstory w
									JOIN Webstory_lang wl ON w.idwebstory=wl.idwebstory	AND wl.codlang=?							
									WHERE w.habilitado=1  AND w.deleted IS NULL ORDER BY w.idwebstory DESC", array($lang));
		return $query->result_array();	

	}

	public function insertOrUpdateLanguage($id, $datas_lang){
		foreach($datas_lang as $codlang=>$data){
			$query=$this->db->query("INSERT IGNORE INTO {$this->table}_lang (codlang, {$this->idname}) VALUES('$codlang', $id)");
			$campos = '';
			$values = array();
			foreach($data as $k=>$d){
			  if(!empty($campos)){
				$campos.=',';
			  }
			  $campos.=$k.'=?';
			  $values[]=$d;
			}
			$str = "UPDATE {$this->table}_lang SET $campos 
						WHERE codlang='$codlang' AND {$this->idname} = $id ";
			$query=$this->db->query($str, $values);	
			if($this->loggear){
				$query=$this->db->query("INSERT INTO Logs(entidad, sentencia, idusuario, idprincipal, funcion) VALUES(?,?,?,?,?) ", Array($this->table, $str.json_encode($values), $this->session->userdata('idusuario'), $id, 'insertOrUpdateLanguage'));
			} 
		}
	}


	public function buscarSelectPropuesta($idpropuesta, $search){
		$where = empty($search)? '' : "titulo like '%$search%' AND";
		$query=$this->db->query("SELECT idwebstory AS id, titulo as 'text' FROM v_Webstory WHERE $where idpropuesta=$idpropuesta");
		$resultado=$query->result_array();		
		return $resultado;
	}
	

	public function tengoPermiso($idpropuesta){
		if($this->session->userdata('role')==4){
			$query = $this->db->query("SELECT * FROM Propuesta_usuario WHERE idusuario=? AND idpropuesta=?", Array($this->session->userdata('idusuario'), $idpropuesta));
			$resultado = $query->result_array();
			if(empty($resultado)){
				return false;
			}
		}
		return true;
	}

    public function eliminarBlando($id){
		$query=$this->db->query("UPDATE {$this->table} SET deleted=now(), url=NULL, habilitado=0 WHERE {$this->idname}=?",$id);
		if($this->loggear){
			$query=$this->db->query("INSERT INTO Logs(entidad, sentencia, idusuario, idprincipal, funcion) VALUES(?,?,?,?,?) ", Array($this->table, "UPDATE {$this->table} SET deleted=now() WHERE {$this->idname}={$id}", $this->session->userdata('idusuario'), $id, 'eliminarBlando'));
		}  
	}	
}

?>