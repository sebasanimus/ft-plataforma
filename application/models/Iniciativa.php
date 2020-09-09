<?php

class Iniciativa extends MY_Model {
    

    function __construct() {
          parent::__construct();
          $this->table = "Iniciativa";
          $this->vista = "v_Iniciativa";
          $this->idname = "idiniciativa";
    }



	protected function getWhere($params){
		$search = $params['busqueda'];
		$where = "WHERE 1=1 ";
		if(!empty($search)){
			$where .= "AND (titulo like '%$search%' OR estado like '%$search%' OR tipo like '%$search%') ";
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
		$query=$this->db->query("SELECT i.*, il.*, op.nombre as tipo, p.idperfil 
									FROM v_IniciativaEstado i 
									JOIN Iniciativa_lang il ON i.idiniciativa=il.idiniciativa AND il.codlang=?
									JOIN Operacion_lang op ON op.id=i.idoperacion AND op.codlang=?
									LEFT JOIN Perfil p ON p.idiniciativa=i.idiniciativa AND p.idusuario=?
									WHERE i.idestadoreal=1",Array($codlang, $codlang, $idusuario));
		return $query->result_array();
	}



	public function getParticipo($codlang, $idusuario){
		$query=$this->db->query("SELECT i.*, il.*, op.nombre as tipo, p.idperfil, p.porcentaje, p.titulo_corto, p.idestadoperfil, e.nombre estadoperfil 
									FROM v_IniciativaEstado i 
									JOIN Iniciativa_lang il ON i.idiniciativa=il.idiniciativa AND il.codlang=?
									JOIN Operacion_lang op ON op.id=i.idoperacion AND op.codlang=?
									JOIN Perfil p ON p.idiniciativa=i.idiniciativa AND p.idusuario=?
									JOIN Perfil_Estado e ON e.idestadoperfil=p.idestadoperfil
									WHERE i.idestadoreal<>1",Array($codlang, $codlang, $idusuario));
		return $query->result_array();
	}

	public function sigueAbierta($idperfil){
		$query=$this->db->query("SELECT i.idiniciativa 
									FROM Iniciativa i 
									LEFT JOIN Perfil p ON p.idiniciativa=i.idiniciativa AND p.idperfil=?
									WHERE i.deleted IS NULL AND fecha_desde<=now() AND fecha_hasta>=now()",Array($idperfil));
		$resultado = $query->result_array();
		if(empty($resultado)){
			return FALSE;
		}else{
			return TRUE;
		}
	}

	public function sigueAbiertaPre($idperfil){
		$query=$this->db->query("SELECT i.idiniciativa 
									FROM v_IniciativaEstado i 
									LEFT JOIN Perfil p ON p.idiniciativa=i.idiniciativa AND p.idperfil=?
									WHERE idestadoreal=2",Array($idperfil));
		$resultado = $query->result_array();
		if(empty($resultado)){
			return FALSE;
		}else{
			return TRUE;
		}
	}

	public function sigueAbiertaSel($idperfil){
		$query=$this->db->query("SELECT i.idiniciativa 
									FROM v_IniciativaEstado i 
									LEFT JOIN Perfil p ON p.idiniciativa=i.idiniciativa AND p.idperfil=?
									WHERE idestadoreal=3",Array($idperfil));
		$resultado = $query->result_array();
		if(empty($resultado)){
			return FALSE;
		}else{
			return TRUE;
		}
	}

	public function getEnCurso($codlang){
		$query=$this->db->query("SELECT i.*, il.*, op.nombre as tipo, eil.nombre estado									
									FROM v_IniciativaEstado i 
									JOIN Iniciativa_lang il ON i.idiniciativa=il.idiniciativa AND il.codlang=?
									JOIN Operacion_lang op ON op.id=i.idoperacion AND op.codlang=?
									JOIN Estado_Iniciativa_lang eil ON i.idestadoreal=eil.id AND eil.codlang=?
									WHERE fecha_desde<=now()",Array($codlang, $codlang, $codlang));
		return $query->result_array();
	}


	
	public function getByIdLang($codlang, $id){
		$query=$this->db->query("SELECT i.*, il.*, op.nombre as tipo, eil.nombre estado, eil.descripcion estado_descripcion, 
									TIMESTAMPDIFF(SECOND,now(),fecha_hasta) as falta, TIMESTAMPDIFF(SECOND,now(),fecha_preseleccion) as falta_preseleccion 
								FROM v_IniciativaEstado i 
								JOIN Iniciativa_lang il ON i.idiniciativa=il.idiniciativa AND il.codlang=?
								JOIN Operacion_lang op ON op.id=i.idoperacion AND op.codlang=?
								JOIN Estado_Iniciativa_lang eil ON i.idestadoreal=eil.id AND eil.codlang=?
								WHERE i.idiniciativa=?", array($codlang, $codlang, $codlang, $id));
		$resultado=$query->result_array();
		if (!$resultado || empty($resultado)) {
			return Array();
		}		
		return $resultado[0];
	}

	public function getEstadisticas($idiniciativa){
		$query=$this->db->query("SELECT 
									count(*) total, 
									avg(p.porcentaje) promedio, 
									SUM(CASE WHEN p.porcentaje=100 THEN 1 ELSE 0 END) AS completos,
									SUM(CASE WHEN p.idestadoperfil>=2 THEN 1 ELSE 0 END) AS preseleccionados,
									SUM(CASE WHEN p.idestadoperfil>=2 AND p.adjunto_pre_propuesta IS NOT NULL AND p.adjunto_pre_presupuesto IS NOT NULL THEN 1 ELSE 0 END) AS preseleccionados_completos,
									SUM(CASE WHEN p.idestadoperfil>=3 THEN 1 ELSE 0 END) AS seleccionados,
									SUM(CASE WHEN p.idestadoperfil>=3 AND p.adjunto_seleccion IS NOT NULL THEN 1 ELSE 0 END) AS seleccionados_completos,
									SUM(CASE WHEN p.actualizado >= DATE(NOW()) - INTERVAL 7 DAY THEN 1 ELSE 0 END) semana
									FROM Perfil p
									JOIN usuario u ON p.idusuario=u.idusuario 
									WHERE p.idiniciativa=? AND somosnosotros=0", array($idiniciativa));
		return $query->result_array()[0];
	}

	public function getDashboard(){
		$query=$this->db->query("SELECT count(*) total FROM v_IniciativaEstado WHERE idestadoreal=1");
		return $query->result_array()[0]['total'];
	}
	
	
}

?>
