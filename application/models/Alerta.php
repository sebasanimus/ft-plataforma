<?php

class Alerta extends MY_Model {
    

    function __construct() {
          parent::__construct();
          $this->table = "Alerta";
          $this->vista = "Alerta";
          $this->idname = "idalerta";
    }



	protected function getWhere($params){
		$search = $params['busqueda'];
		$where = "WHERE 1=1 ";
		if(!empty($search)){
			$where .= "AND (titulo like '%$search%') ";
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

    public function crear($titulo, $contenido, $link){
		$query=$this->db->query("INSERT INTO Alerta(titulo, contenido, link) VALUES(?,?,?)",Array($titulo, $contenido, $link));
		return $this->db->insert_id();
	}
	
	public function agregarUsuarios($idalerta, $tipo, $param){
		$mails = Array();
		$insert = "INSERT IGNORE INTO Alerta_Usuario(idalerta, idusuario) SELECT $idalerta, idusuario FROM usuario WHERE ";
		switch($tipo){
			case 'nuevo_organismo':
				$this->db->query($insert." alerta_$tipo=1 AND idtipousuario=1");
				break;
			case 'contenidos':
				$this->db->query($insert." alerta_$tipo=1 AND idtipousuario=1");
				break;
			case 'personalizada_todos':
				$this->db->query($insert." idusuario IN (SELECT idusuario FROM Perfil WHERE idiniciativa=$param)");
				break;
			case 'personalizada_completo':
				$this->db->query($insert." idusuario IN (SELECT idusuario FROM Perfil WHERE idiniciativa=$param AND porcentaje=100)");
				break;
			case 'personalizada_incompleto':
				$this->db->query($insert." idusuario IN (SELECT idusuario FROM Perfil WHERE idiniciativa=$param AND porcentaje<100)");
				break;
			case 'personalizada_inicial':
				$this->db->query($insert." idusuario IN (SELECT idusuario FROM Perfil WHERE idestadoperfil=1)");
				break;
			case 'personalizada_preseleccionado':
				$this->db->query($insert." idusuario IN (SELECT idusuario FROM Perfil WHERE idestadoperfil=2)");
				break;
			case 'personalizada_seleccionado':
				$this->db->query($insert." idusuario IN (SELECT idusuario FROM Perfil WHERE idestadoperfil=3)");
				break;
			case 'istas_todos':
				$this->db->query($insert." idusuario IN (SELECT pu.idusuario FROM Propuesta_usuario pu JOIN Propuesta p ON pu.idpropuesta=p.idpropuesta WHERE p.estado=1)");
				break;
			case 'istas_individuo':
				$this->db->query($insert." idusuario IN (SELECT pu.idusuario FROM Propuesta_usuario pu JOIN Propuesta p ON pu.idpropuesta=p.idpropuesta JOIN Ista i ON i.idpropuesta=p.idpropuesta WHERE i.idista=$param)");
				break;
		}

		$query = $this->db->query("SELECT email, nombre FROM usuario WHERE alerta_mail=1 AND idusuario IN (SELECT idusuario FROM Alerta_Usuario WHERE idalerta=$idalerta)");
		$resultado = $query->result_array();
		foreach ($resultado as $mail){
			$mails[$mail['email']] = $mail['nombre'];
		}
		return $mails;
	}

	public function agregarUsuario($idalerta, $idusuario){
		$this->db->query("INSERT IGNORE INTO Alerta_Usuario(idalerta, idusuario) VALUES(?,?)", Array($idalerta, $idusuario));
	}

	public function getAbiertas($idusuario){
		$query = $this->db->query("SELECT a.idalerta, a.titulo, a.created, au.leido 
									FROM Alerta a JOIN Alerta_Usuario au ON a.idalerta=au.idalerta
									WHERE au.idusuario = ? AND cerrada = 0 ORDER BY a.idalerta DESC", Array($idusuario));
		return $query->result_array();
	}

	public function getAlerta($idalerta, $idusuario){
		$query = $this->db->query("SELECT a.titulo, a.created, au.leido, a.contenido, a.link 
									FROM Alerta a JOIN Alerta_Usuario au ON a.idalerta=au.idalerta
									WHERE au.idusuario = ? AND au.idalerta = ? ", Array($idusuario, $idalerta));			
		$resultado = $query->result_array();
		if(empty($resultado)){
			return Array();			
		}
		if(empty($resultado[0]['leido'])){
			$this->db->query("UPDATE Alerta_Usuario SET leido=now() WHERE leido IS NULL AND idusuario=? AND idalerta = ?", Array($idusuario, $idalerta));
		}
		return $resultado[0];
	}

	public function cerrarAlerta($idalerta, $idusuario){
		$this->db->query("UPDATE Alerta_Usuario SET cerrada=1 WHERE idusuario=? AND idalerta = ?", Array($idusuario, $idalerta));		
	}
}

?>