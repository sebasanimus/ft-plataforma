<?php

class Tecnica extends MY_Model {
    

    function __construct() {
          parent::__construct();
          $this->table = "Tecnica";
          $this->vista = "v_Tecnica";
          $this->idname = "idtecnica";
    }



	protected function getWhere($params){
		$search = $params['busqueda'];
		$where = "WHERE idpropuesta=".$params['idpropuesta']." ";
		if(!empty($search)){
			$where .= "AND (componente_nombre like '%$search%' OR indicador_nombre like '%$search%') ";
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
	/*
	public function getAllIndicador($codlang){
		$query=$this->db->query("SELECT indicador value, CONCAT(indicador, ' (', count(*), ')' )  label FROM Tecnica_lang WHERE codlang=? GROUP BY indicador ORDER BY count(*) desc", array($codlang));
		$resultado=$query->result_array();		
		return $resultado;
	}*/
	
	/*
	public function getAllUnidad($codlang){
		$query=$this->db->query("SELECT unidad value, CONCAT(unidad, ' (', count(*), ')' )  label FROM Tecnica_lang WHERE codlang=? AND unidad<>'' GROUP BY unidad ORDER BY count(*) desc", array($codlang));
		$resultado=$query->result_array();		
		return $resultado;
	}*/

	public function getAllLocalidad($codlang){
		$query=$this->db->query("SELECT DISTINCT(localidad) value, localidad label FROM Tecnica");
		$resultado=$query->result_array();		
		return $resultado;
	}

	public function getData($codlang, $filtros){
		$datosPaises = array();
		$datosPlata = array();
		$datosPie = array();
		$datosMapaPie = array();
		$datosEstrategica = array();
		$datosInvestigacion = array();
		$datosInnovacion = array();
		$datosTecnologica = array();
		$datosRegion = array();
		$datosInstitucion = array();
		$datosAnios = array();
		$unidad = array();
		$datos = array();
		$ult = array();
		$opciones = array();
		$tipos = array();
		$tipos['tipo_investigacion'] = 'p';
		$tipos['operacion'] = 'p';
		$tipos['linea_estrategica'] = 'p';
		$tipos['tipo_innovacion'] = 'p';
		$tipos['solucion_tecnologica'] = 'p';		
		$tipos['pais'] = 'p';
		$tipos['tipo_institucion'] = 'p';
		$tipos['region'] = 'p';
		$tipos['organismo'] = 'p';
		//$tipos['rubro'] = 'p';
		//$tipos['area_investigacion'] = 'p';
		$tipos['sector_productivo'] = 'p';
		$tipos['tema'] = 'p';

		$tipos['componente'] = 't';
		$tipos['indicastandar'] = 't';
		$tipos['unidad'] = 't';
		$tipos['paisindicador'] = 't';
		$tipos['localidad'] = 't';
			

		$where = '';
		foreach($tipos as $k=>$t){
			if(!empty($filtros[$k])){
				$aux = $t.'.'.$k.' IN (';
				if($k=='tema'){
					$aux = 'p.idpropuesta IN ( SELECT idpropuesta FROM Propuesta_Tema WHERE idtema IN (';
				}
				$first = true;
				foreach($filtros[$k] as $fil){
					//if(is_numeric($fil['value'])){
						$aux .= ($first)? '' : ',';
						$first = false;
						$aux .= (is_array($fil))? "'". $this->db->_escape_str($fil['value'])."'" :  "'". $this->db->_escape_str($fil)."'";
					
				}
				$aux .= ')';
				if($k=='tema') $aux .= ')';
				$where .= ' AND '.$aux;
			}
		}
		$rango = $filtros['rango'];
		if(is_numeric($rango['min']) && $rango['min']>1998){
			$where .= ' AND anio>='.$rango['min'];
		}
		if(is_numeric($rango['max']) && $rango['max']<date("Y")){
			$where .= ' AND anio<='.$rango['max'];
		}	
		
		if(!empty($where)){
			//pl.area_investigacion, rl.nombre rubro, LEFT JOIN Rubro_lang rl ON rl.id=p.idrubro AND rl.codlang='$codlang'
			$query = $this->db->query("SELECT p.idpropuesta, p.identificador, p.anio, pej.nombre as paisejecutor, pl.titulo_simple, pa.nombre as paisindicador, 
										c.nombre as componente, i.nombre indicador, u.nombre unidad, t.localidad, t.antes, t.despues, t.idtecnica, tl.indicador indicadororiginal, sl.nombre as sector_productivo
										FROM v_PropuestaEjecutor p 
										JOIN Propuesta_lang pl ON p.idpropuesta=pl.idpropuesta AND pl.codlang='$codlang'
										JOIN Tecnica t ON t.idpropuesta=p.idpropuesta
										JOIN Tecnica_lang tl ON tl.idtecnica=t.idtecnica AND tl.codlang='$codlang'
										LEFT JOIN Pais_lang pa ON t.paisindicador=pa.id AND pa.codlang='$codlang'
										LEFT JOIN Pais_lang pej ON p.pais=pej.id AND pej.codlang='$codlang'
										JOIN Componente_lang c ON t.componente=c.id AND c.codlang='$codlang'
										JOIN Indicastandar_lang i ON t.indicastandar=i.id AND i.codlang='$codlang'
										JOIN Unidad_lang u ON t.unidad=u.id AND u.codlang='$codlang'										
										LEFT JOIN v_Sectores_lang sl ON sl.idpropuesta=p.idpropuesta AND sl.codlang='$codlang'
										WHERE t.deleted IS NULL $where
										ORDER BY p.anio asc, p.identificador");
			$datos = $query->result_array();
		}

		/* MAPA */
		$datosPaises = array();
		if(!empty($where)){ //Solo lo muestra cuando hay filtros 

			$query = $this->db->query("SELECT distinct(t.unidad) unidad
									FROM v_PropuestaEjecutor p 
									JOIN Propuesta_lang pl ON p.idpropuesta=pl.idpropuesta AND pl.codlang='$codlang'
									JOIN Tecnica t ON t.idpropuesta=p.idpropuesta
									WHERE t.deleted IS NULL $where");
			$unidades=$query->result_array();

			if(sizeof($unidades)==1){ //Solo si es la misma unidad
				$query = $this->db->query("SELECT u.fun, ul.nombre FROM Unidad u JOIN Unidad_lang ul ON ul.id=u.id WHERE u.id=? AND codlang=?", array($unidades[0]['unidad'], $codlang) );
				$unidad = $query->result_array()[0];
				$query = $this->db->query("SELECT pej.nombre name, latitud , longitud, '#67b7dc' color, ".$unidad['fun']."(despues_san) total
									FROM v_PropuestaEjecutor p 
									JOIN Propuesta_lang pl ON p.idpropuesta=pl.idpropuesta AND pl.codlang='$codlang'
									JOIN Tecnica t ON t.idpropuesta=p.idpropuesta
									JOIN Tecnica_lang tl ON t.idtecnica=tl.idtecnica AND tl.codlang='$codlang'
									JOIN Pais pa ON pa.id=p.pais 
									JOIN Pais_lang pej ON p.pais=pej.id AND pej.codlang='$codlang'
									WHERE t.deleted IS NULL AND t.despues_san IS NOT NULL $where
									GROUP BY p.pais ");
				$datosPaises = $query->result_array();
				$acum=0;
				foreach($datosPaises as $key => &$pais){
					$pais["latitude"]= floatval($pais['latitud']);
					$pais["longitude"]= floatval($pais['longitud']);
					$pais["value"]= round(floatval($pais['total']));
					$acum += $pais["value"];
				}
				if(empty($acum)){ //si todos los datos son 0, tampoco hay que mostrar mapa
					$datosPaises = array();
				}	

				$query = $this->db->query("SELECT p.anio, round(".$unidad['fun']."(despues_san)) valor 
									FROM v_PropuestaEjecutor p 
									JOIN Propuesta_lang pl ON p.idpropuesta=pl.idpropuesta AND pl.codlang='$codlang'
									JOIN Tecnica t ON t.idpropuesta=p.idpropuesta
									JOIN Tecnica_lang tl ON t.idtecnica=tl.idtecnica AND tl.codlang='$codlang'
									WHERE t.deleted IS NULL AND t.despues_san IS NOT NULL $where
									GROUP BY p.anio ORDER BY p.anio ASC");
				$datosA = $query->result_array();
				$anios = range($rango['min'], $rango['max']);
				$i = 0;
				foreach($anios as $anio){
					if(empty($datosA[$i]) || $anio<$datosA[$i]['anio']){
						$datosAnios[] = array('anio'=>substr($anio, -2), 'valor'=>0);
					}else{
						$datosAnios[] = array('anio'=>substr($anio, -2), 'valor'=>$datosA[$i]['valor']);
						$i++;
					}
				}
				
				$query = $this->db->query("SELECT es.nombre nombre, round(".$unidad['fun']."(despues_san)) valor 
									FROM v_PropuestaEjecutor p 
									JOIN Propuesta_lang pl ON p.idpropuesta=pl.idpropuesta AND pl.codlang='$codlang'
									JOIN Tecnica t ON t.idpropuesta=p.idpropuesta
									JOIN Tecnica_lang tl ON t.idtecnica=tl.idtecnica AND tl.codlang='$codlang'
									JOIN Estrategica_lang es ON p.linea_estrategica=es.id AND es.codlang='$codlang'
									WHERE t.deleted IS NULL AND t.despues_san IS NOT NULL $where
									GROUP BY p.linea_estrategica ");
				$datosEstrategica = $query->result_array();

				$query = $this->db->query("SELECT es.nombre nombre, round(".$unidad['fun']."(despues_san)) valor 
									FROM v_PropuestaEjecutor p 
									JOIN Propuesta_lang pl ON p.idpropuesta=pl.idpropuesta AND pl.codlang='$codlang'
									JOIN Tecnica t ON t.idpropuesta=p.idpropuesta
									JOIN Tecnica_lang tl ON t.idtecnica=tl.idtecnica AND tl.codlang='$codlang'
									JOIN Investigacion_lang es ON p.tipo_investigacion=es.id AND es.codlang='$codlang'
									WHERE t.deleted IS NULL AND t.despues_san IS NOT NULL $where
									GROUP BY p.tipo_investigacion ");
				$datosInvestigacion = $query->result_array();

				$query = $this->db->query("SELECT es.nombre nombre, round(".$unidad['fun']."(despues_san)) valor 
									FROM v_PropuestaEjecutor p 
									JOIN Propuesta_lang pl ON p.idpropuesta=pl.idpropuesta AND pl.codlang='$codlang'
									JOIN Tecnica t ON t.idpropuesta=p.idpropuesta
									JOIN Tecnica_lang tl ON t.idtecnica=tl.idtecnica AND tl.codlang='$codlang'
									JOIN Innovacion_lang es ON p.tipo_innovacion=es.id AND es.codlang='$codlang'
									WHERE t.deleted IS NULL AND t.despues_san IS NOT NULL $where
									GROUP BY p.tipo_innovacion ");
				$datosInnovacion = $query->result_array();

				$query = $this->db->query("SELECT es.nombre nombre, round(".$unidad['fun']."(despues_san)) valor 
									FROM v_PropuestaEjecutor p 
									JOIN Propuesta_lang pl ON p.idpropuesta=pl.idpropuesta AND pl.codlang='$codlang'
									JOIN Tecnica t ON t.idpropuesta=p.idpropuesta
									JOIN Tecnica_lang tl ON t.idtecnica=tl.idtecnica AND tl.codlang='$codlang'
									JOIN Solucion_lang es ON p.solucion_tecnologica=es.id AND es.codlang='$codlang'
									WHERE t.deleted IS NULL AND t.despues_san IS NOT NULL $where
									GROUP BY p.solucion_tecnologica ");
				$datosTecnologica = $query->result_array();

				$query = $this->db->query("SELECT es.nombre nombre, round(".$unidad['fun']."(despues_san)) valor 
									FROM v_PropuestaEjecutor p 
									JOIN Propuesta_lang pl ON p.idpropuesta=pl.idpropuesta AND pl.codlang='$codlang'
									JOIN Tecnica t ON t.idpropuesta=p.idpropuesta
									JOIN Tecnica_lang tl ON t.idtecnica=tl.idtecnica AND tl.codlang='$codlang'
									JOIN Region_lang es ON p.region=es.id AND es.codlang='$codlang'
									WHERE t.deleted IS NULL AND t.despues_san IS NOT NULL $where
									GROUP BY p.region ");
				$datosRegion = $query->result_array();

				$query = $this->db->query("SELECT es.nombre nombre, round(".$unidad['fun']."(despues_san)) valor 
									FROM v_PropuestaEjecutor p 
									JOIN Propuesta_lang pl ON p.idpropuesta=pl.idpropuesta AND pl.codlang='$codlang'
									JOIN Tecnica t ON t.idpropuesta=p.idpropuesta
									JOIN Tecnica_lang tl ON t.idtecnica=tl.idtecnica AND tl.codlang='$codlang'
									JOIN Institucion_lang es ON p.tipo_institucion=es.id AND es.codlang='$codlang'
									WHERE t.deleted IS NULL AND t.despues_san IS NOT NULL $where
									GROUP BY p.tipo_institucion ");
				$datosInstitucion = $query->result_array();
			}
		}

		return Array(	'datos'=>$datos, 
						'datosPaises'=>$datosPaises, 
						'undidadPpal' => $unidad,
						'datosEstrategica'=>$datosEstrategica,
						'datosInvestigacion' => $datosInvestigacion,
						'datosInnovacion' => $datosInnovacion,
						'datosRegion' => $datosRegion,
						'datosInstitucion' => $datosInstitucion,
						'datosTecnologica' => $datosTecnologica,
						'datosAnios' => $datosAnios  );
	}

	function startsWith($string, $startString){ 
		$len = strlen($startString); 
		return (substr($string, 0, $len) === $startString); 
	} 


	public function obtener($idtecnica){
		$retorno = array();
		$query = $this->db->query("SELECT * FROM {$this->table} a WHERE {$this->idname} = ?", array($idtecnica));
		$result = $query->result_array();
		if(empty($result)){
			return array();
		}
		$retorno = $result[0];
		$paqueteLang = $this->getLanguages($idtecnica);
		foreach($paqueteLang as $pl){
			$retorno['indicador_'.$pl['codlang']] = $pl['indicador'];
		}
		return $retorno;
	}
}

?>