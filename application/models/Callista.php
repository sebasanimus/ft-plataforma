<?php

class Callista extends MY_Model {
    

    function __construct() {
          parent::__construct();
          $this->table = "Callista";
          $this->vista = "v_Callista";
          $this->idname = "idcallista";
    }



	protected function getWhere($params){
		$search = $params['busqueda'];
		$where = "WHERE 1=1 ";
		if(!empty($search)){
			$where .= "AND (titulo like '%$search%' OR estado like '%$search%') ";
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

	public function getAbiertas($codlang, $idusuario){
		$query=$this->db->query("SELECT vc.*, p.idpropuesta, p.web_foto, pl.titulo_simple 
									FROM v_Callista vc 
									JOIN Propuesta p ON p.estado=1
									JOIN Propuesta_lang pl ON p.idpropuesta=pl.idpropuesta AND pl.codlang=?
									LEFT JOIN Ista i ON i.idcallista=vc.idcallista AND i.idpropuesta=p.idpropuesta
									WHERE vc.idestadoreal=1 
									AND p.idpropuesta IN (SELECT idpropuesta FROM Propuesta_usuario WHERE idusuario=?)
									AND i.enviado IS NULL", Array($codlang, $idusuario));
		return $query->result_array();
	}

	public function sigueAbierta($idcallista){
		$query=$this->db->query("SELECT idcallista 
									FROM v_CallistaEstado 
									WHERE idestadoreal=1",Array($idcallista));
		$resultado = $query->result_array();
		if(empty($resultado)){
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	public function getByIdLang($codlang, $id){
		$query=$this->db->query("SELECT vc.*, cl.*, el.nombre estado, TIMESTAMPDIFF(SECOND,now(),fecha_hasta) as falta 
								FROM v_Callista vc 
								JOIN Callista_lang cl ON vc.idcallista=cl.idcallista AND cl.codlang=?
								JOIN Estado_lang el ON vc.idestadoreal=el.id AND el.codlang=?
								WHERE vc.idcallista=?", array($codlang, $codlang, $id));
		$resultado=$query->result_array();
		if (!$resultado || empty($resultado)) {
			return Array();
		}		
		return $resultado[0];
	}

	public function getDashboard(){
		$query=$this->db->query("SELECT count(*) total FROM v_CallistaEstado WHERE idestadoreal=1");
		return $query->result_array()[0]['total'];
	}
	
	public function getEstadisticas($idcallista){
		$query=$this->db->query("SELECT count(*) total, avg(p.porcentaje) promedio, SUM(CASE WHEN p.enviado IS NULL THEN 0 ELSE 1 END) AS completos,
									SUM(CASE WHEN p.actualizado >= DATE(NOW()) - INTERVAL 7 DAY THEN 1 ELSE 0 END) semana
									FROM Ista p
									WHERE p.idcallista=?", array($idcallista));
		return $query->result_array()[0];
	}
	
}

?>