<?php

class Perfil extends MY_Model {
    

    function __construct() {
          parent::__construct();
          $this->table = "Perfil";
          $this->vista = "v_Perfil";
          $this->idname = "idperfil";
    }



	protected function getWhere($params){
		$search = $params['busqueda'];
		$where = "WHERE idiniciativa=".$params['idiniciativa'].'  ';
		if(!empty($search)){
			$where .= "AND (titulo_corto like '%$search%' OR titulo like '%$search%' OR nombre like '%$search%' OR email like '%$search%' OR estado like '%$search%' ) ";
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
	
	public function getDownload($idiniciativa){
		$query = $this->db->query("SELECT idperfil, titulo_corto, nombre, email, porcentaje, actualizado FROM v_Perfil WHERE somosnosotros=0 AND idiniciativa=?", array($idiniciativa));
		$resultado = $query->result_array();
		return $resultado;
	}

	public function crear($idusuario, $idiniciativa, $idoperacion){
		$query = $this->db->query("SELECT idperfil FROM Perfil WHERE idusuario=? AND idiniciativa=?", array($idusuario, $idiniciativa));
		$resultado = $query->result_array();
		if(!empty($resultado)){
			return $resultado[0]['idperfil'];
		}
		$this->db->query("INSERT INTO Perfil(idusuario, idiniciativa, idoperacion, actualizado) VALUES (?,?,?, now() )",
							Array($idusuario, $idiniciativa, $idoperacion));
		return $this->db->insert_id();
	}

	public function terminar($idperfil, $idusuario){
		if(!is_numeric($idperfil) || !is_numeric($idusuario) ){
			$idperfil=0;
			$idusuario=0;
		}
		$query = $this->db->query("SELECT idperfil FROM Perfil WHERE idusuario=? AND idperfil=? AND enviado IS NULL ", Array($idusuario, $idperfil) );
		$validar = $query->result_array();
		if(empty($validar)){
			return;
		}
		$query = $this->db->query("UPDATE Perfil SET enviado=now() WHERE idusuario=$idusuario AND idperfil=$idperfil", $valores);
	}

	public function actualizarPre($idperfil, $idusuario, $datos, $xtras){
		if(!is_numeric($idperfil) || !is_numeric($idusuario) ){
			$idperfil=0;
			$idusuario=0;
		}
		$query = $this->db->query("SELECT idperfil FROM Perfil WHERE idusuario=? AND idperfil=? AND idestadoperfil=2 ", Array($idusuario, $idperfil) );
		$validar = $query->result_array();
		if(empty($validar)){
			return;
		}		 
		
		$query = $this->db->query("UPDATE Perfil SET actualizado=now(), adjunto_pre_propuesta=?, adjunto_pre_presupuesto=? WHERE idperfil=? ", Array($datos['adjunto_pre_propuesta'], $datos['adjunto_pre_presupuesto'], $idperfil));
		//Log
		$query = $this->db->query("INSERT INTO Log_Perfil(idperfil, idusuario, data, extra) VALUES (?,?,?,?)", Array($idperfil, $idusuario, json_encode($datos), json_encode($xtras)));

	}

	public function actualizarSel($idperfil, $idusuario, $datos, $xtras){
		if(!is_numeric($idperfil) || !is_numeric($idusuario) ){
			$idperfil=0;
			$idusuario=0;
		}
		$query = $this->db->query("SELECT idperfil FROM Perfil WHERE idusuario=? AND idperfil=? AND idestadoperfil=3 ", Array($idusuario, $idperfil) );
		$validar = $query->result_array();
		if(empty($validar)){
			return;
		}		 
		
		$query = $this->db->query("UPDATE Perfil SET actualizado=now(), adjunto_seleccion=? WHERE idperfil=? ", Array($datos['adjunto_seleccion'], $idperfil));
		//Log
		$query = $this->db->query("INSERT INTO Log_Perfil(idperfil, idusuario, data, extra) VALUES (?,?,?,?)", Array($idperfil, $idusuario, json_encode($datos), json_encode($xtras)));

	}

	public function actualizar($idperfil, $idusuario, $datos, $xtras){
		if(!is_numeric($idperfil) || !is_numeric($idusuario) ){
			$idperfil=0;
			$idusuario=0;
		}
		$query = $this->db->query("SELECT idperfil FROM Perfil WHERE idusuario=? AND idperfil=? AND enviado IS NULL ", Array($idusuario, $idperfil) );
		$validar = $query->result_array();
		if(empty($validar)){
			return;
		}
		 
		$valores = Array();
		$str = '';
		foreach($datos as $key=>$val){
			if(!empty($str)) $str.=', ';
			$str .=$key.'=?';
			$valores[]=$val;
		}
		$query = $this->db->query("UPDATE Perfil SET $str WHERE idusuario=$idusuario AND idperfil=$idperfil", $valores);

		$query=$this->db->query("DELETE FROM Perfil_BadgeODS WHERE idperfil=?", array($idperfil));
		if(!empty($xtras['badgesObtenidas'])){ 
			foreach($xtras['badgesObtenidas'] as $b){
				$query=$this->db->query("INSERT INTO Perfil_BadgeODS(idperfil, idbadgeods) VALUES(?,?) ", array($idperfil, $b));
			}
		}
		
		$query=$this->db->query("DELETE FROM Perfil_Tema WHERE idperfil=?", array($idperfil));
		if(!empty($xtras['temasSelect'])){ 
			foreach($xtras['temasSelect'] as $idtema){
				$query=$this->db->query("INSERT INTO Perfil_Tema(idperfil, idtema) VALUES(?,?) ", array($idperfil, $idtema));
			}
		}

		if(!empty($xtras['ejecutor'])){
			$this->db->query("REPLACE INTO Perfil_Organismo(idperfil, participacion, orden, 
			visible, idorganismo, idpais, nombre_contacto, cargo_contacto, email_contacto, telefono_contacto) 
			VALUES (?,?,?,?,?,?,?,?,?,?)", 
			Array($idperfil, 3, 1, true, $xtras['ejecutor']['idorganismo'], $xtras['ejecutor']['idpais'], $xtras['ejecutor']['nombre'],
				$xtras['ejecutor']['cargo'], $xtras['ejecutor']['email'], $xtras['ejecutor']['telefono'] ) );
		}

		if(!empty($xtras['coejecutor'])){
			foreach($xtras['coejecutor'] as $orden=>$coejecutor){
				$this->db->query("REPLACE INTO Perfil_Organismo(idperfil, participacion, orden, 
				visible, idorganismo, idpais, nombre_contacto, cargo_contacto, email_contacto, telefono_contacto) 
				VALUES (?,?,?,?,?,?,?,?,?,?)", 
				Array($idperfil, 2, $orden, true, $coejecutor['idorganismo'], $coejecutor['idpais'], $coejecutor['nombre'],
					$coejecutor['cargo'], $coejecutor['email'], $coejecutor['telefono']));
			}
		}

		if(!empty($xtras['asociado'])){
			foreach($xtras['asociado'] as $orden=>$asociado){
				$this->db->query("REPLACE INTO Perfil_Organismo(idperfil, participacion, orden, 
				visible, idorganismo, idpais, nombre_contacto, cargo_contacto, email_contacto, telefono_contacto) 
				VALUES (?,?,?,?,?,?,?,?,?,?)", 
				Array($idperfil, 1, $orden, true, $asociado['idorganismo'], $asociado['idpais'], $asociado['nombre'],
					$asociado['cargo'], $asociado['email'], $asociado['telefono']));
			}
		}

		if(!empty($xtras['sector'])){
			foreach($xtras['sector'] as $orden=>$sector){
				$this->db->query("REPLACE INTO Perfil_Sector(idperfil, orden, idsector) 
									VALUES (?,?,?)", Array($idperfil, $orden, $sector['idsector']));
			}
		}
		$query=$this->db->query("DELETE FROM Perfil_Subsector WHERE idperfil=?", array($idperfil));
		if(!empty($xtras['subsectorSelect'])){ 
			foreach($xtras['subsectorSelect'] as $idsubsector){
				$query=$this->db->query("INSERT IGNORE INTO Perfil_Subsector(idperfil, idsubsector) VALUES(?,?) ", array($idperfil, $idsubsector));
			}
		}

		if(!empty($xtras['componente'])){
			foreach($xtras['componente'] as $orden=>$componente){
				$this->db->query("REPLACE INTO Perfil_Componente(idperfil, orden, nombre, actividad, producto, resultado) VALUES (?,?,?,?,?,?)", 
					Array($idperfil, $orden, $componente['nombre'], $componente['actividad'], $componente['producto'], $componente['resultado']) );
				$query = $this->db->query("SELECT idperfilcomponente FROM Perfil_Componente WHERE idperfil=? AND orden=?", Array($idperfil, $orden));	
				$idperfilcomponente = $query->result_array()[0]['idperfilcomponente'];

				/*$this->db->query("DELETE FROM Perfil_C_Actividad WHERE idperfilcomponente=?", Array($idperfilcomponente));	
				$actividades = explode(',', $componente['actividad']);
				foreach($actividades as $actividad){
					$this->db->query("INSERT INTO Perfil_C_Actividad(idperfilcomponente, nombre) VALUES (?,?)", Array($idperfilcomponente, $actividad));
				}	

				$this->db->query("DELETE FROM Perfil_C_Producto WHERE idperfilcomponente=?", Array($idperfilcomponente));	
				$productos = explode(',', $componente['producto']);
				foreach($productos as $producto){
					$this->db->query("INSERT INTO Perfil_C_Producto(idperfilcomponente, nombre) VALUES (?,?)", Array($idperfilcomponente, $producto));
				}	

				$this->db->query("DELETE FROM Perfil_C_Resultado WHERE idperfilcomponente=?", Array($idperfilcomponente));	
				$resultados = explode(',', $componente['resultado']);
				foreach($resultados as $resultado){
					$this->db->query("INSERT INTO Perfil_C_Resultado(idperfilcomponente, nombre) VALUES (?,?)", Array($idperfilcomponente, $resultado));
				}	*/		
			}
		}
		$porcentaje = round(100*$xtras['porcentajes']['total']['completados']/$xtras['porcentajes']['total']['cantidad']);
		if($porcentaje==100 && $xtras['porcentajes']['total']['completados']<$xtras['porcentajes']['total']['cantidad']){
			$porcentaje=99;
		}
		$query = $this->db->query("UPDATE Perfil SET porcentaje=?, actualizado=now() WHERE idperfil=? ", Array($porcentaje, $idperfil));

		//Log
		$query = $this->db->query("INSERT INTO Log_Perfil(idperfil, idusuario, data, extra) VALUES (?,?,?,?)", Array($idperfil, $idusuario, json_encode($datos), json_encode($xtras)));
	}

	
	public function getEjecutor($id){
		$query=$this->db->query("SELECT * FROM Perfil_Organismo WHERE idperfil=? AND participacion=3", array($id));
		$resultado=$query->result_array();
		if (!$resultado || empty($resultado)) {
		  	return Array();
		}		
		return $resultado[0];
	}

	public function getEjecutorTexto($id){
		$query=$this->db->query("SELECT po.*, CONCAT(o.nombre, ' - ',COALESCE(o.nombre_largo,'')) as organismo, pa.nombre as pais 
									FROM Perfil_Organismo po 
									JOIN Organismo o ON po.idorganismo=o.idorganismo
									JOIN Pais_lang pa ON pa.id=po.idpais AND pa.codlang='es'
									WHERE po.idperfil=? AND po.participacion=3", array($id));
		$resultado=$query->result_array();
		if (!$resultado || empty($resultado)) {
		  	return Array();
		}		
		return $resultado[0];
	}

	public function getOtrosOrg($id, $tipo){
		$participacion = ($tipo=='coejecutor')? 2 : 1;
		$query=$this->db->query("SELECT * FROM Perfil_Organismo WHERE idperfil=? AND participacion=? ORDER BY orden ASC", array($id, $participacion));
		$resultado=$query->result_array();
		if (!$resultado || empty($resultado)) {
		  	return Array();
		}	
		$retorno = Array();	
		foreach($resultado as $org){
			$retorno[$org['orden']]=$org;			
		}
		return $retorno;
	}

	public function getOtrosOrgTexto($id, $tipo){
		$participacion = ($tipo=='coejecutor')? 2 : 1;
		$query=$this->db->query("SELECT po.*, CONCAT(o.nombre, ' - ',COALESCE(o.nombre_largo,'')) as organismo, pa.nombre as pais 
									FROM Perfil_Organismo po
									JOIN Organismo o ON po.idorganismo=o.idorganismo
									JOIN Pais_lang pa ON pa.id=po.idpais AND pa.codlang='es'
									WHERE po.idperfil=? AND po.participacion=? ORDER BY po.orden ASC", array($id, $participacion));
		$resultado=$query->result_array();
		if (!$resultado || empty($resultado)) {
		  	return Array();
		}	
		$retorno = Array();	
		foreach($resultado as $org){
			$retorno[$org['orden']]=$org;			
		}
		return $retorno;
	}

	public function getSector($id){
		$query=$this->db->query("SELECT * FROM Perfil_Sector WHERE idperfil=? ORDER BY orden ASC", array($id));
		$resultado=$query->result_array();
		if (!$resultado || empty($resultado)) {
		  	return Array();
		}	
		$retorno = Array();	
		foreach($resultado as $org){
			$retorno[$org['orden']]=$org;			
		}
		return $retorno;
	}

	public function getSectorTexto($idperfil){
		$query=$this->db->query("SELECT * 
									FROM Perfil_Sector ps
									JOIN Sector_lang sl ON sl.id=ps.idsector AND sl.codlang='es'
									WHERE ps.idperfil=? ORDER BY ps.orden ASC", array($idperfil));
		$resultado=$query->result_array();
		if (!$resultado || empty($resultado)) {
		  	return Array();
		}	
		foreach($resultado as &$sector){
			$query=$this->db->query("SELECT *	
										FROM Perfil_Subsector ps
										JOIN Subsector_lang sl ON sl.id=ps.idsubsector AND sl.codlang='es'
										JOIN Subsector s ON s.id=ps.idsubsector
										WHERE ps.idperfil=? AND s.idsector=? ORDER BY sl.nombre", array($idperfil, $sector['idsector']));
			$sector['subsectores'] = $query->result_array();			
		}
		return $resultado;
	}

	public function getComponentes($id){
		$query=$this->db->query("SELECT * FROM Perfil_Componente WHERE idperfil=? ORDER BY orden ASC", array($id));
		$resultado=$query->result_array();
		if (!$resultado || empty($resultado)) {
		  	return Array();
		}	
		$retorno = Array();	
		foreach($resultado as &$com){
			/*$query=$this->db->query("SELECT GROUP_CONCAT(nombre) nombres FROM Perfil_C_Actividad WHERE idperfilcomponente=? GROUP BY idperfilcomponente", array($com['idperfilcomponente']));
			$actividades = $query->result_array();
			$com['actividad'] = empty($actividades)? '' : $actividades[0]['nombres'];
			
			$query=$this->db->query("SELECT GROUP_CONCAT(nombre) nombres FROM Perfil_C_Producto WHERE idperfilcomponente=? GROUP BY idperfilcomponente", array($com['idperfilcomponente']));
			$productos = $query->result_array();
			$com['producto'] = empty($productos)? '' : $productos[0]['nombres'];

			$query=$this->db->query("SELECT GROUP_CONCAT(nombre) nombres FROM Perfil_C_Resultado WHERE idperfilcomponente=? GROUP BY idperfilcomponente", array($com['idperfilcomponente']));
			$resultados = $query->result_array();
			$com['resultado'] = empty($resultados)? '' : $resultados[0]['nombres'];*/

			$retorno[$com['orden']]=$com;			
		}
		return $retorno;
	}

	public function getIdsExportar($idiniciativa){
		$query=$this->db->query("SELECT p.idperfil 
									FROM v_Perfil p 
									WHERE p.idiniciativa=? AND p.somosnosotros=0 AND p.porcentaje=100 ORDER BY p.idperfil ASC", array($idiniciativa));
		return $query->result_array();
	}

	public function getIdsExportarPre($idiniciativa){
		$query=$this->db->query("SELECT p.idperfil, p.adjunto_pre_propuesta, p.adjunto_pre_presupuesto  
									FROM v_Perfil p 
									WHERE p.idiniciativa=? AND p.somosnosotros=0 AND p.idestadoperfil=2 ORDER BY p.idperfil ASC", array($idiniciativa));
		return $query->result_array();
	}

	public function getIdsExportarSel($idiniciativa){
		$query=$this->db->query("SELECT p.idperfil, p.adjunto_seleccion 
									FROM v_Perfil p 
									WHERE p.idiniciativa=? AND p.somosnosotros=0 AND p.idestadoperfil=3 ORDER BY p.idperfil ASC", array($idiniciativa));
		return $query->result_array();
	}
	
	public function getDownloadResumen($idiniciativa){
		$query = $this->db->query("SELECT i.identificador, p.idperfil, titulo_corto, monto, monto_contrapartida, monto_total, plazo 
										FROM v_Perfil p
										JOIN Iniciativa i ON i.idiniciativa=p.idiniciativa 
										WHERE somosnosotros=0 AND p.porcentaje=100 AND p.idiniciativa=?", array($idiniciativa));
		return $query->result_array();
	}

	public function getEstados(){
		$query=$this->db->query("SELECT idestadoperfil, nombre FROM Perfil_Estado ORDER BY idestadoperfil ASC");
		return $query->result_array();
	}

	public function cambiarEstado($idperfil, $idestado){
		$query = $this->db->query("UPDATE Perfil SET idestadoperfil = ? WHERE idperfil = ? ", Array($idestado, $idperfil) );
	}

	public function buscarSelect($search){
		$query=$this->db->query("SELECT idperfil AS id, CONCAT('ID:', idperfil, ' - ', titulo_corto) as 'text' 
									FROM Perfil 
									WHERE (titulo_corto like '%$search%' OR idperfil = '$search' ) AND idestadoperfil=3");
		$resultado=$query->result_array();		
		return $resultado;
	}
}

?>
