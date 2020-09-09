<?php

class Usuario extends MY_Model {
    

    function __construct() {
          parent::__construct();
          $this->table = "usuario";
          $this->vista = "v_usuario";
          $this->idname = "idusuario";
    }

    function getByUsername($username){
        $query=$this->db->query("SELECT * FROM {$this->table} WHERE email=? ", array($username));
		$resultado=$query->result();
        return $resultado;
    }


	protected function getWhere($params){
		$search = $params['busqueda'];
		$where = "WHERE 1=1 ";
		if(!empty($search)){
			$where .= "AND (email like '%$search%' OR tipo like '%$search%' OR nombre like '%$search%' OR institucion like '%$search%' OR propuestas like '%$search%') ";
		}
		return $where;
	}

	protected function getWhereObligado(){
		return '';
	}

    
    public function getTipoUsuario($soloCoor=false){
        $query=$this->db->query("SELECT * FROM tipousuario");
		$resultado=$query->result();
        return $resultado;
    }

    protected function validar($id, $data){
        $sar = parent::validar($id, $data);
        if(!empty($sar)){
            return $sar;
		}        
		if(!filter_var($data['email']['val'], FILTER_VALIDATE_EMAIL)){
			return 'Email no válido';
		}
        $query = $this->db->query("SELECT * FROM {$this->table} WHERE email = ?", array($data['email']['val']));
        $result = $query->result_array();
        if (!$result || empty($result)) {
			return ''; 
		}else{            
            if(sizeof($result)==1 && $result[0]['idusuario'] == $id){ //estoy modificando el mismo usuario
                return ''; 
            }
            return 'Email ya registrado';
        }        
    }

	public function updateLastLogin($idusuario){
		$query = $this->db->query("UPDATE usuario SET lastlogin=now() WHERE idusuario = ?", array($idusuario));
	}

	public function getUltimosLogueados(){
		$query = $this->db->query("SELECT count(*) cantidad FROM usuario WHERE datediff(now(), lastlogin)<=7");
		$result = $query->result_array();
		if (!$result || empty($result)) {
			return 0; 
		}else{ 
			return $result[0]['cantidad'];
		}
	}

	public function cambiarIdioma($idusuario, $codlang){
		$query = $this->db->query("UPDATE usuario SET codlang=? WHERE idusuario = ?", array($codlang, $idusuario));
	}

	public function checkTabs($idusuario, $tabID){
		$query = $this->db->query("SELECT tabid FROM usuario WHERE idusuario=? AND (now()-tabidupdated)<33", Array($idusuario));
		$result = $query->result_array();
		if(empty($result)){ //no hay tab actualizandose en los ultimos 60segundos
			$this->db->query("UPDATE usuario SET tabidupdated=now(), tabid=? WHERE idusuario=?", Array($tabID, $idusuario));
			return '';
		}else{
			if($result[0]['tabid']==$tabID){
				return '';
			}else{
				return 'error';
			}
		}
	}

	public function checkTabsIsta($idusuario, $tabID){
		$query = $this->db->query("SELECT tabid_ista FROM usuario WHERE idusuario=? AND (now()-tabidupdated_ista)<33", Array($idusuario));
		$result = $query->result_array();
		if(empty($result)){ //no hay tab actualizandose en los ultimos 60segundos
			$this->db->query("UPDATE usuario SET tabidupdated_ista=now(), tabid_ista=? WHERE idusuario=?", Array($tabID, $idusuario));
			return '';
		}else{
			if($result[0]['tabid_ista']==$tabID){
				return '';
			}else{
				return 'error';
			}
		}
	}

	public function actualizarToken($idusuario, $token){
		$query = $this->db->query("UPDATE usuario SET pass_token_updated=now(), pass_token=? WHERE idusuario = ?", array($token, $idusuario));
	}

	public function cambiarPass($idusuario, $pass){
		$query = $this->db->query("UPDATE usuario SET pass_token_updated=NULL, pass_token=NULL, password=?  WHERE idusuario = ?", array($pass, $idusuario));
	}

	public function actualizarPropuestas($idusuario, $idpropuestas){
		$query = $this->db->query("DELETE FROM Propuesta_usuario WHERE idusuario=?", Array($idusuario));
		foreach($idpropuestas as $idp){
			$query = $this->db->query("INSERT INTO Propuesta_usuario(idusuario, idpropuesta) VALUES(?,?)", Array($idusuario, $idp));
		}
	}

	public function getPropuestas($idusuario){
		$query = $this->db->query("SELECT pu.idpropuesta, pl.titulo_simple
									FROM Propuesta_usuario pu
									JOIN Propuesta_lang pl ON pu.idpropuesta=pl.idpropuesta AND pl.codlang='es'
									WHERE idusuario=?", Array($idusuario));
		return $query->result_array();
	}

	public function getByPropuesta($idpropuesta){
		$query = $this->db->query("SELECT u.* 
									FROM v_usuario u
									JOIN Propuesta_usuario pu ON u.idusuario=pu.idusuario
									WHERE pu.idpropuesta=?", Array($idpropuesta));
		return $query->result_array();
	}
}

?>