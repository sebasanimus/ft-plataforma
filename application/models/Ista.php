<?php

class Ista extends MY_Model {
    

    function __construct() {
          parent::__construct();
          $this->table = "Ista";
          $this->vista = "v_Ista";
          $this->idname = "idista";
    }



	protected function getWhere($params){
		$search = $params['busqueda'];
		$where = "WHERE idcallista=".$params['idcallista'].' ';
		if(!empty($search)){
			$where .= "AND (titulo_simple like '%$search%' OR identificador like '%$search%' ) ";
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
	public function obtenerId($idcallista, $idpropuesta){
		$query = $this->db->query("SELECT idista FROM Ista WHERE idpropuesta=? AND idcallista=?", array($idpropuesta, $idcallista));
		$resultado = $query->result_array();
		if(!empty($resultado)){
			return $resultado[0]['idista'];
		}
		$this->db->query("INSERT INTO Ista(idcallista, idpropuesta, actualizado) VALUES (?,?, now() )",
							Array($idcallista, $idpropuesta));
		return $this->db->insert_id();
	}

	public function terminar($idista){		
		$query = $this->db->query("SELECT idista FROM Ista WHERE idista=$idista AND enviado IS NULL AND porcentaje=100");
		$validar = $query->result_array();
		if(empty($validar)){
			return;
		}
		$query = $this->db->query("UPDATE Ista SET enviado=now() WHERE idista=$idista");
		if($this->loggear){
			$query=$this->db->query("INSERT INTO Logs(entidad, sentencia, idusuario, idprincipal, funcion) VALUES(?,?,?,?,?) ", Array($this->table, "UPDATE Ista SET enviado=now() WHERE idista=$idista", $this->session->userdata('idusuario'), $idista, 'enviado'));
		}
	}

	public function actualizar($idista, $idusuario, $datos, $xtras){
		if(!is_numeric($idista) || !is_numeric($idusuario) ){
			$idista=0;
			$idusuario=0;
		}
		$query = $this->db->query("SELECT idista FROM Ista WHERE idista=? AND enviado IS NULL ", Array($idista) );
		$validar = $query->result_array();
		if(empty($validar)){
			return 0;
		}
		 
		$valores = Array();
		$str = '';
		foreach($datos as $key=>$val){
			if(!empty($str)) $str.=', ';
			$str .=$key.'=?';
			$valores[]=$val;
		}
		$query = $this->db->query("UPDATE Ista SET $str WHERE idista=$idista", $valores);

		
		$porcentaje = round(100*$xtras['porcentajes']['total']['completados']/$xtras['porcentajes']['total']['cantidad']);
		if($porcentaje==100 && $xtras['porcentajes']['total']['completados']<$xtras['porcentajes']['total']['cantidad']){
			$porcentaje=99;
		}
		$query = $this->db->query("UPDATE Ista SET porcentaje=?, actualizado=now() WHERE idista=? ", Array($porcentaje, $idista));

		//Log
		$query = $this->db->query("INSERT INTO Log_Ista(idista, idusuario, data, extra) VALUES (?,?,?,?)", Array($idista, $idusuario, json_encode($datos), json_encode($xtras)));
		return 1;
	}

	public function getIdsExportar($idcallista){
		$query=$this->db->query("SELECT p.idista, p.adjunto 
									FROM Ista p 
									WHERE p.idcallista=? AND p.enviado IS NOT NULL ORDER BY p.idista ASC", array($idcallista));
		return $query->result_array();
	}
	
	public function getDownload($idcallista){
		$query = $this->db->query("SELECT i.idista, i.titulo_simple, u.nombre, u.email, i.porcentaje, i.actualizado 
									FROM v_Ista i 
									JOIN Propuesta_usuario pu ON pu.idpropuesta=i.idpropuesta
									JOIN usuario u ON pu.idusuario=u.idusuario WHERE i.idcallista=?", array($idcallista));
		$resultado = $query->result_array();
		return $resultado;
	}

	public function rechazar($idista, $motivo){
		$idusuario = $this->session->userdata('idusuario');
		$query = $this->db->query("UPDATE Ista SET enviado=null WHERE idista=?", Array($idista));
		$query = $this->db->query("INSERT INTO Ista_Rechazo(idista, comentario, idusuario) VALUES(?,?,?)", Array($idista, $motivo, $idusuario));		
	}

	public function getRechazos($idista){
		$query = $this->db->query("SELECT i.*, u.email, u.nombre
									FROM Ista_Rechazo i
									LEFT JOIN usuario u ON i.idusuario=u.idusuario
									WHERE idista=?", array($idista));
		$resultado = $query->result_array();
		return $resultado;
	}

}

?>