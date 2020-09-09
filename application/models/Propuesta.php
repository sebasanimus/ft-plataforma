<?php

class Propuesta extends MY_Model {
    

    function __construct() {
          parent::__construct();
          $this->table = "Propuesta";
          $this->vista = "v_Propuesta";
          $this->idname = "idpropuesta";
    }



	protected function getWhere($params){
		$search = $params['busqueda'];
		$where = "WHERE 1=1 ";
		if(!empty($search)){
			$where .= "AND (titulo_simple like '%$search%' OR identificador like '%$search%' OR anio like '%$search%' OR sector_productivo like '%$search%' OR elestado like '%$search%') ";
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
		
        $query = $this->db->query("SELECT * FROM {$this->table} WHERE identificador = ?", array($data['identificador']['val']));
        $result = $query->result_array();
		if ($result && !empty($result)){            
            if(sizeof($result)!=1 || $result[0][$this->idname] != $id){ //estoy modificando el mismo 
                return 'identificador de propuesta duplicado';
            }            
		} 
		
		if(!empty($data['web_url']['val'])){
			$query = $this->db->query("SELECT * FROM {$this->table} WHERE web_url = ?", array($data['web_url']['val']));
			$result = $query->result_array();
			if ($result && !empty($result)){            
				if(sizeof($result)!=1 || $result[0][$this->idname] != $id){ //estoy modificando el mismo 
					return 'url de propuesta duplicado';
				}            
			}  
		}
		return '';      
	}
	
	public function getByIdentificador($id){
		$query=$this->db->query("SELECT * FROM {$this->vista} WHERE identificador=?", array($id));
		$resultado=$query->result_array();
		if (!$resultado || empty($resultado)) {
		  	return 0;
		}		
		return $resultado[0]['idpropuesta'];
	}
	
	public function actualizarTotales($id){
		$query = $this->db->query("UPDATE Propuesta p 
											JOIN v_ItemTotales i ON p.idpropuesta=i.idpropuesta 
											SET 
											p.aporte_fontagro = i.aporte_fontagro, 
											p.aporte_bid = i.aporte_bid, 
											p.movilizacion_agencias = i.movilizacion_agencias, 
											p.aporte_contrapartida = i.aporte_contrapartida, 
											p.aporte_agencias = i.aporte_agencias, 
											p.total = i.total 
											WHERE p.idpropuesta = ?", array($id));
	}

	public function buscarSelect($search){
		$where = '';
		if($this->session->userdata('role')==4){
			$where .= " AND idpropuesta IN (SELECT idpropuesta FROM Propuesta_usuario WHERE idusuario=".$this->session->userdata('idusuario').") ";
		}
		$query=$this->db->query("SELECT idpropuesta AS id, CONCAT(titulo_simple, ' (', identificador, ')') as 'text' 
									FROM v_Propuesta 
									WHERE (titulo_simple like '%$search%' OR identificador like '%$search%') $where");
		$resultado=$query->result_array();		
		return $resultado;
	}

	public function getGraphData($codlang, $campo, $tipo, $filtros){
		$datosPaises = array();
		$datosPlata = array();
		$datosPie = array();
		$datosMapaPie = array();
		$ult = array();
		$opciones = array();
		$tipos = array();
		$tipos['tipo_investigacion'] = 'Investigacion';
		$tipos['operacion'] = 'Operacion';
		$tipos['linea_estrategica'] = 'Estrategica';
		$tipos['tipo_innovacion'] = 'Innovacion';
		$tipos['solucion_tecnologica'] = 'Solucion';		
		//$tipos['rubro'] = 'Rubro';
		//$tipos['area_investigacion'] = 'Areainvestigacion';	
		$tipos['sector_productivo'] = 'Sector';
		$tipos['tema'] = 'Tema';

		$tipos['pais'] = 'v_Pais';
		$tipos['paistodos'] = 'v_PaisTodos';
		$tipos['tipo_institucion'] = 'Institucion';
		$tipos['region'] = 'Region';

		$tipos['organismo'] = 'O';
		$tipos['mapa'] = 'O';
		$tipos['organismoCo'] = 'O';

		$total = 'p_total';
		$prefijo = 'p_';
		$propuesta = 'v_PropuestaEjecutor';
		if($campo=='pais' || $campo=='tipo_institucion' || $campo=='region'){ //Es el total del item del organismo ejecutor
			$total = 'total';
			$prefijo = '';
		}else if($this->startsWith($campo, 'participacion_')){
			$total = 'total';
			$prefijo = '';
			$propuesta = 'v_PropuestaParticipacion';
			$campo = substr($campo, 14);
			if($campo=='pais'){
				$tipos['pais'] = 'v_PaisTodos';
			}
		}

		if(!empty($filtros['organismoCo'])){
			$total = 'total';
			$prefijo = '';
			$propuesta = 'v_PropuestaParticipacion';
		}

		if(empty($tipos[$campo])){
			return array();
		}
		

		$tabla = $tipos[$campo];
		$where = '';
		foreach($tipos as $k=>$t){
			if(!empty($filtros[$k])){
				$aux = $k.' IN (';
				if($k=='organismoCo' || $k=='organismo'){
					$aux = 'idorganismo IN (';
				}else if($k=='tema'){
					$aux = 'idpropuesta IN ( SELECT idpropuesta FROM Propuesta_Tema WHERE idtema IN (';
				}else if($k=='sector_productivo'){
					$aux = 'idpropuesta IN ( SELECT idpropuesta FROM Propuesta_Sector WHERE idsector IN (';
				}
				$first = true;
				foreach($filtros[$k] as $fil){
					//if(is_numeric($fil['value'])){
						$aux .= ($first)? '' : ',';
						$first = false;
						$aux .= "'". $this->db->_escape_str($fil['value'])."'";
					
				}
				$aux .= ')';
				if($k=='tema') $aux .= ')';
				if($k=='sector_productivo') $aux .= ')';
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
		
		if($tipo=='money'){
			$total = "round(sum($total))";
		}else{
			$total = 'count(*)';
		}
		
		$retorno = array();
		$totalTotal = 0;

		if($campo!='mapa'){

			$query = $this->db->query("SELECT o.id, o.nombre
										FROM ".$tabla."_lang o 
										WHERE codlang=?
										ORDER BY o.id", array($codlang));
			$opciones=$query->result_array();	
			
			/*$query = $this->db->query("SELECT DISTINCT(anio) valor 
										FROM Propuesta 
										WHERE deleted IS NULL AND anio>=? AND anio<=?  
										ORDER BY anio ASC", array($rango['min'], $rango['max']));
			$anios=$query->result_array();	
			foreach($anios as $anio){
				$retorno[$anio['valor']] = array('anio'=>$anio['valor']);
				foreach($opciones as $opc){
					$retorno[$anio['valor']][$opc['id']] = 0;
				}
			}*/


			$anios = range($rango['min'], $rango['max']);
			foreach($anios as $anio){
				$retorno[$anio] = array('anio'=>$anio);
				foreach($opciones as $opc){
					$retorno[$anio][$opc['id']] = 0;
				}
			}

			/*POR AÑOS*/
			$query = $this->db->query("SELECT p.anio, p.$campo id, $total total
										FROM $propuesta p 
										WHERE p.deleted is null $where
										GROUP BY p.anio, p.$campo
										ORDER BY p.anio asc, p.$campo");
			$datos=$query->result_array();			
			foreach($datos as $d){
				if(empty($d['id']) || !isset($retorno[$d['anio']][$d['id']]) ){
					continue;
				}
				$retorno[$d['anio']][$d['id']] += $d['total'];
				$totalTotal += $d['total'];
			}
			
			foreach($retorno as $ret){
				$ult[] = $ret;
			}

			/* PIE */
			$query = $this->db->query("SELECT o.nombre tipo, $total total
										FROM $propuesta p
										JOIN ".$tabla."_lang o ON o.id=p.$campo
										WHERE o.codlang=? AND p.deleted is null $where
										GROUP BY o.id
										ORDER BY o.id", array($codlang));
			$datosPie = $query->result_array();

			/* PLATA */
			if($tipo=='money'){//tengo mas graficos
				$query = $this->db->query("SELECT o.nombre as eje, 
							sum(".$prefijo."aporte_fontagro) aporte_fontagro, 
							sum(".$prefijo."aporte_bid) aporte_bid, 
							sum(".$prefijo."movilizacion_agencias) movilizacion_agencias, 
							sum(".$prefijo."aporte_contrapartida) aporte_contrapartida, 
							sum(".$prefijo."aporte_agencias) aporte_agencias
							FROM $propuesta p 
							JOIN ".$tabla."_lang o ON o.id=p.$campo					
							WHERE o.codlang=? AND p.deleted is null $where
							GROUP BY p.$campo
							ORDER BY p.$campo", array($codlang));
				$datosPlata = $query->result_array();
			}

			/* MAPA PIE*/
			$query = $this->db->query("SELECT pai.code, o.nombre tipo, $total total
										FROM $propuesta p 
										JOIN ".$tabla."_lang o ON o.id=p.$campo
										JOIN Pais pai ON pai.id=p.pais
										WHERE o.codlang=? AND p.deleted is null $where
										GROUP BY pai.code, o.id
										ORDER BY pai.code, o.id", array($codlang));
			$dmp = $query->result_array();
			
			foreach($dmp as $dat){
				if(empty($datosMapaPie[$dat['code']])){
					$datosMapaPie[$dat['code']] = array();
				}
				$array = array('tipo' =>  $dat['tipo'], 'total'=>$dat['total'] );
				$datosMapaPie[$dat['code']][] = $array;
			}

		}else{

			/* MAPA */
			$query = $this->db->query("SELECT pal.nombre name, latitud , longitud, '#67b7dc' color,  $total total
										FROM v_PropuestaEjecutor p 
										JOIN Pais pa ON p.pais=pa.id
										JOIN Pais_lang pal ON pa.id=pal.id 
										WHERE pal.codlang=? AND p.deleted is null $where
										GROUP BY p.pais ", array($codlang));
			$datosPaises =  $query->result_array();
			foreach($datosPaises as $key => &$pais){
				$pais["latitude"]= floatval($pais['latitud']);
				$pais["longitude"]= floatval($pais['longitud']);
				$pais["value"]= round(floatval($pais['total']));
			}
		}

		return Array('datos'=>$ult, 
					'labels'=>$opciones, 
					'datosPie'=>$datosPie, 
					'datosPlata'=>$datosPlata, 
					'datosPaises'=>$datosPaises, 
					'datosMapaPie'=>$datosMapaPie, 
					'totalTotal'=>$totalTotal);
	}

	function getResumenData($codlang, $tipo){
		$opt = Array();
		$opt[] = Array('id'=>'uno', "es"=>'FONTAGRO', 'en'=>'FONTAGRO' );
		$opt[] = Array('id'=>'dos', "es"=>'MOVILIZACIÓN DE RECURSOS Y OTRAS AGENCIAS (INCLUIDO BID)', 'en'=>'MOBILIZATION OF RESOURCES AND OTHER AGENCIES (INCLUDING IDB)');
		$opt[] = Array('id'=>'tres', "es"=>'CONTRAPARTIDA', 'en'=>'COUNTERPART');
		$datos = Array();
		$opciones = Array();
		$datosPie = Array();
		$datosMapaPie = Array();
		$tablaCompleta = Array();
		$tablaSubtotales = Array();
		$tablaOperacion = Array();
		$tablaApalanca = Array();

		if($tipo=='cant'){ //GRAFICOS
			$query = $this->db->query("SELECT anio, SUM(aporte_fontagro) uno, SUM(aporte_bid+movilizacion_agencias+aporte_agencias) dos,SUM(aporte_contrapartida) tres
								FROM Propuesta p
								WHERE p.deleted is null 
								GROUP BY anio");
			$datos =  $query->result_array();
			
			foreach($opt as $op){
				$opciones[] = Array('id'=>$op['id'], 'nombre'=>$op[$codlang]);
			}		

			$query = $this->db->query("SELECT SUM(aporte_fontagro) uno, SUM(aporte_bid+movilizacion_agencias+aporte_agencias) dos,SUM(aporte_contrapartida) tres
								FROM Propuesta p
								WHERE p.deleted is null");
			$pie = $query->result_array()[0];
			
			foreach($opt as $op){
				$datosPie[] = Array('total'=>$pie[$op['id']], 'tipo'=>$op[$codlang]);
			}	

			/* MAPA PIE*/
			$query = $this->db->query("SELECT pai.code, SUM(aporte_fontagro) uno, SUM(aporte_bid+movilizacion_agencias+aporte_agencias) dos,SUM(aporte_contrapartida) tres
					FROM Item i 
					JOIN Pais pai ON pai.id=i.pais
					WHERE i.deleted is null 
					GROUP BY pai.code ORDER BY pai.code");
			$dmp = $query->result_array();
			foreach($dmp as $dat){
				$array = Array();
				foreach($opt as $op){
					$array[] = Array('total'=>$dat[$op['id']], 'tipo'=>$op[$codlang]);
				}	
				$datosMapaPie[$dat['code']] = $array;
			}

		}else{ //TABLAS
			$query = $this->db->query("SELECT p.identificador, p.anio, pl.titulo_simple, CONCAT(org.nombre,' (', pal.nombre,')') ejecutor, o.nombre coejecutores, 
									ROUND(p.aporte_fontagro) aporte_fontagro, 
									ROUND(p.aporte_bid+p.movilizacion_agencias+p.aporte_agencias) otros, 
									ROUND(p.aporte_contrapartida) aporte_contrapartida, 
									ROUND(p.total) total
									FROM Propuesta p
									JOIN Propuesta_lang pl ON p.idpropuesta=pl.idpropuesta AND pl.codlang = ?
									LEFT JOIN Item i ON p.idpropuesta=i.idpropuesta 
									LEFT JOIN Organismo org ON i.idorganismo=org.idorganismo 
									LEFT JOIN Pais_lang pal ON i.pais=pal.id AND pal.codlang = ?
									LEFT JOIN v_OrganismosCoEjecutores o ON o.idpropuesta=p.idpropuesta
									WHERE (i.participacion=3 OR i.idpropuesta IS NULL) AND p.deleted is NULL AND i.deleted IS NULL
									ORDER BY p.anio DESC, p.idpropuesta DESC", Array($codlang, $codlang) );
			$tablaCompleta = $query->result_array();

			$query = $this->db->query("SELECT p.anio,  
									ROUND(SUM(p.aporte_fontagro)) aporte_fontagro, 
									ROUND(SUM(p.aporte_bid+p.movilizacion_agencias+p.aporte_agencias)) otros, 
									ROUND(SUM(p.aporte_contrapartida)) aporte_contrapartida, 
									ROUND(SUM(p.total)) total 
									FROM Propuesta p
									WHERE p.deleted is NULL 
									GROUP BY p.anio
									ORDER BY p.anio ASC" );
			$tablaSubtotales = $query->result_array();

			$acumOtras = 0;
			$acumContr = 0;
			$acumFonta = 0;
			foreach($tablaSubtotales as $sub){
				$acumOtras += $sub['otros'];
				$acumContr += $sub['aporte_contrapartida'];
				$acumFonta += $sub['aporte_fontagro'];
				$total = $acumOtras + $acumContr;
				if($sub['anio']<2013) continue;
				$tablaApalanca[] = Array(
						'anio'=> $sub['anio'], 
						'contra_ftg' => 	number_format(round($acumContr / $acumFonta, 1),1), 
						'otra_ftg' =>   	number_format(round($acumOtras / $acumFonta, 1),1), 
						'otra_contra_ftg' =>	number_format(round($total / $acumFonta, 1),1));
			}
			$tablaSubtotales = array_reverse($tablaSubtotales);

			$query = $this->db->query("SELECT o.nombre, 
												ROUND(SUM(p.aporte_fontagro)) fontagro, 
												ROUND(SUM(p.aporte_bid)) bid, 
												ROUND(SUM(p.movilizacion_agencias)) movilizacion, 
												ROUND(SUM(p.aporte_agencias)) otras,
												ROUND(SUM(p.aporte_bid+p.movilizacion_agencias+p.aporte_agencias)) suma, 
												ROUND(SUM(p.aporte_contrapartida)) contrapartida, 
												ROUND(SUM(p.total)) total
								FROM Propuesta p 
								JOIN Operacion_lang o ON p.operacion=o.id AND o.codlang=?
								WHERE p.deleted is NULL
								GROUP BY p.operacion", Array($codlang) );
			$tablaOperacion = $query->result_array();
			$query = $this->db->query("SELECT 'Total' nombre, 
												ROUND(SUM(p.aporte_fontagro)) fontagro, 
												ROUND(SUM(p.aporte_bid)) bid, 
												ROUND(SUM(p.movilizacion_agencias)) movilizacion, 
												ROUND(SUM(p.aporte_agencias)) otras,
												ROUND(SUM(p.aporte_bid+p.movilizacion_agencias+p.aporte_agencias)) suma, 
												ROUND(SUM(p.aporte_contrapartida)) contrapartida, 
												FLOOR(SUM(p.total)) total
								FROM Propuesta p
								WHERE p.deleted is NULL" );
			$tablaOperacionTotales = $query->result_array();
			array_unshift($tablaOperacion, $tablaOperacionTotales[0]);
		}		

		return Array('datos' => $datos, 
					'labels' => $opciones, 
					'datosPie' => $datosPie, 
					'datosPlata' => array(), 
					'datosPaises' => array(), 
					'datosMapaPie' => $datosMapaPie, 
					'totalTotal' => array(),
					'tablaCompleta' => $tablaCompleta,
					'tablaOperacion' => $tablaOperacion,
					'tablaApalanca' => $tablaApalanca,
					'tablaSubtotales' => $tablaSubtotales);
	}

	function startsWith($string, $startString){ 
		$len = strlen($startString); 
		return (substr($string, 0, $len) === $startString); 
	} 

	function graficoTortaTotales(){
		$query = $this->db->query("SELECT 
							sum(aporte_fontagro) aporte_fontagro, 
							sum(aporte_bid) aporte_bid, 
							sum(aporte_contrapartida) aporte_contrapartida, 
							sum(aporte_agencias + movilizacion_agencias) otras
							FROM Propuesta WHERE deleted IS NULL");
		$datosPlata = $query->result_array();
		return $datosPlata[0];
	}

	function totalTabla(){
		$retorno = array();
		$query = $this->db->query("SELECT count(*) total
				FROM Propuesta WHERE deleted IS NULL");
		$datos = $query->result_array();
		$retorno['proyectosAprobados'] = $datos[0]['total'];

		$query = $this->db->query("SELECT ROUND(SUM(total)/1000000,1) total
				FROM Propuesta WHERE deleted IS NULL");
		$datos = $query->result_array();
		$retorno['montoTotal'] = $datos[0]['total'];

		$query = $this->db->query("SELECT ROUND(SUM(aporte_fontagro)/1000000,1) total
				FROM Propuesta WHERE deleted IS NULL");
		$datos = $query->result_array();
		$retorno['fontagroTotal'] = $datos[0]['total'];

		$query = $this->db->query("SELECT ROUND(SUM(aporte_agencias + movilizacion_agencias)/1000000,1) total
				FROM Propuesta WHERE deleted IS NULL");
		$datos = $query->result_array();
		$retorno['otrosTotal'] = $datos[0]['total'];

		$query = $this->db->query("SELECT count(DISTINCT pais) total FROM Item WHERE deleted IS NULL AND pais<>24");
		$datos = $query->result_array();
		$retorno['paises'] = $datos[0]['total'];

		$query = $this->db->query("SELECT * FROM Fontagro WHERE idfontagro=1");
		$datos = $query->result_array();
		$retorno['tecnologias_generadas'] = $datos[0]['tecnologias_generadas'];
		$retorno['tecnologias_nuevas'] = $datos[0]['tecnologias_nuevas'];
		$retorno['tecnologias_relevantes'] = $datos[0]['tecnologias_relevantes'];


		return $retorno;
	}

	function getDatosPais($idpais){
		$retorno = array();
		$query = $this->db->query("SELECT ROUND(SUM(aporte_contrapartida)/1000000,1) total FROM Item WHERE deleted IS NULL AND pais=? AND idpropuesta IN (SELECT idpropuesta FROM Propuesta WHERE deleted is null)", Array($idpais));
		$datos = $query->result_array();
		$retorno['yaAportado'] = $datos[0]['total'];

		$query = $this->db->query("SELECT count(DISTINCT idpropuesta) total 
				FROM v_PropuestaParticipacion 
				WHERE pais=?", Array($idpais));
		$retorno['consorcios'] = $query->result_array()[0]['total'];

		$query = $this->db->query("SELECT count(*) total 
				FROM v_PropuestaEjecutor 
				WHERE pais=?", Array($idpais));
		$retorno['consorciosLider'] = $query->result_array()[0]['total'];

		$query = $this->db->query("SELECT ROUND(SUM(total)/1000000,1) total 
		FROM Propuesta 
		WHERE deleted IS NULL AND idpropuesta IN (SELECT idpropuesta FROM Item Where pais=? AND deleted is null)", Array($idpais));
		$retorno['totalConsorcios'] = $query->result_array()[0]['total'];

		$query = $this->db->query("SELECT ROUND(SUM(total)/1000000,1) total 
		FROM Propuesta 
		WHERE deleted IS NULL AND idpropuesta IN (SELECT idpropuesta FROM Item Where pais=? AND participacion=3 AND deleted is null)", Array($idpais));
		$retorno['totalConsorciosLider'] = $query->result_array()[0]['total'];

		$query = $this->db->query("SELECT ROUND(SUM(aporte_fontagro + aporte_agencias + movilizacion_agencias + aporte_bid)/1000000,1) total 
		FROM Propuesta 
		WHERE deleted IS NULL AND idpropuesta IN (SELECT idpropuesta FROM Item Where pais=? AND deleted is null)", Array($idpais));
		$retorno['aporteFontagro'] = $query->result_array()[0]['total'];

		return $retorno;
	}

	function ejemplos($idpais, $codlang){
		$query = $this->db->query("SELECT p.idpropuesta, p.anio, pl.titulo_simple, p.total
			FROM Propuesta p
			JOIN Propuesta_lang pl ON pl.idpropuesta=p.idpropuesta
			WHERE pl.codlang=? AND p.deleted IS NULL AND p.web_publicado=1
			AND p.idpropuesta IN (SELECT idpropuesta FROM Item Where pais=? AND deleted is null)
			ORDER BY anio DESC LIMIT 6", 
			Array($codlang, $idpais));
		$propuestas = $query->result_array();
		
		foreach($propuestas as &$pr){
			$query = $this->db->query("SELECT pl.nombre, o.nombre as organismo
										FROM Item i
										JOIN Pais_lang pl ON i.pais=pl.id
										JOIN Organismo o ON o.idorganismo=i.idorganismo
										WHERE pl.codlang=? AND i.participacion=3 AND i.idpropuesta=?", Array($codlang, $pr['idpropuesta']));
			$datos = $query->result_array();			
			$pr['lider'] = (empty($datos))? '' : $datos[0]['organismo'].' '.$datos[0]['nombre'];

			$query = $this->db->query("SELECT p.code, o.nombre as organismo
										FROM Item i
										JOIN Pais p ON i.pais=p.id
										JOIN Organismo o ON o.idorganismo=i.idorganismo
										WHERE i.participacion<>3 AND i.idpropuesta=?", Array($pr['idpropuesta']));
			$miembros = $query->result_array();
			$pr['miembros'] = '';
			foreach($miembros as $m){
				$pr['miembros'] .= $m['organismo'].' ('.$m['code'].'); ';
			}
		}
		return $propuestas;
	}

	function totalPais($codlang){

		$query = $this->db->query("SELECT p.id, pl.nombre 
					FROM Pais p 
					JOIN Pais_lang pl ON pl.id=p.id  
					WHERE p.esmiembro=1 AND pl.codlang=? 
					ORDER BY pl.nombre", array($codlang));
		$datos = $query->result_array();
		
		$query = $this->db->query("SELECT pais, count(*) total 
					FROM v_PropuestaParticipacion pp 
					JOIN Pais p ON p.id=pp.pais  
					WHERE participacion=3 AND p.esmiembro=1 
					GROUP BY pais");
		$proyectosEjecutor = $query->result_array();

		$query = $this->db->query("SELECT pais, count(DISTINCT idpropuesta) total 
					FROM v_PropuestaParticipacion pp 
					JOIN Pais p ON p.id=pp.pais 
					WHERE p.esmiembro=1 
					GROUP BY pais");
		$proyectosParticipante = $query->result_array();

		$retorno = array('labels'=>array(), 'proyectosEjecutor'=>array(), 'proyectosParticipante'=>array() );
		foreach($datos as $pais){
			$retorno['labels'][] = $pais['nombre'];
			$total = 0;
			foreach($proyectosEjecutor as $pe){
				if($pe['pais']==$pais['id']){
					$total = $pe['total'];
					break;
				}
			}
			$retorno['proyectosEjecutor'][] = $total;

			$total = 0;
			foreach($proyectosParticipante as $pp){
				if($pp['pais']==$pais['id']){
					$total = $pp['total'];
					break;
				}
			}
			$retorno['proyectosParticipante'][] = $total;
		}
		return $retorno;
	}

	public function getStartingPoint($idpropuesta){
		$query = $this->db->query("SELECT p.latitud, p.longitud
					FROM v_PropuestaEjecutor pe 
					JOIN Pais p ON p.id=pe.pais 
					WHERE idpropuesta = ? ", Array($idpropuesta));
		$result = $query->result_array();
		if(empty($result)){
			return Array('lat'=> 0, 'lng'=> 0);
		}else{
			return Array('lat'=> $result[0]['latitud'], 'lng'=> $result[0]['longitud']);
		}
	}

	public function getPuntosPpales($codlang){
		$query = $this->db->query("SELECT *	FROM v_puntosPpales	WHERE codlang = ? ", Array($codlang));
		return $query->result_array();
	}

	public function getPuntosEstimados($codlang){
		$query = $this->db->query("SELECT *	FROM v_puntosEstimados WHERE codlang = ? ", Array($codlang));
		return $query->result_array();
	}

	public function getHome($codlang){
		$query = $this->db->query("SELECT p.identificador, pl.titulo_simple, pl.titulo_completo, p.anio, p.web_url, p.web_publicado, p.urlvieja, ol.nombre operacion 	
									FROM Propuesta p
									JOIN Propuesta_lang pl ON p.idpropuesta=pl.idpropuesta AND pl.codlang=?
									JOIN Operacion_lang ol ON p.operacion=ol.id AND ol.codlang=?
									WHERE p.web_publicado=1
									ORDER BY p.idpropuesta DESC LIMIT 12", Array($codlang, $codlang));
		return $query->result_array();
	}

	public function getByUrl($url, $lang, $puedeVerBorrador){
		$habilitado = ($puedeVerBorrador) ? '' : 'AND web_publicado=1';
		//rl.nombre rubro, LEFT JOIN Rubro_lang pl ON p.idrubro=pl.id AND sl.codlang = ?	
		$query = $this->db->query("SELECT p.*, pl.*, el.nombre estrategica, il.nombre investigacion, sl.nombre solucion, ol.nombre iniciativa, inl.nombre innovacion, es.nombre nombreestado 		 		
										FROM Propuesta p 
										JOIN Propuesta_lang pl ON p.idpropuesta=pl.idpropuesta 
										LEFT JOIN Estrategica_lang el ON p.linea_estrategica=el.id AND el.codlang = ?
										LEFT JOIN Investigacion_lang il ON p.tipo_investigacion=il.id AND il.codlang = ?
										LEFT JOIN Solucion_lang sl ON p.solucion_tecnologica=sl.id AND sl.codlang = ?	
										LEFT JOIN Innovacion_lang inl ON p.tipo_innovacion=inl.id AND inl.codlang = ?											
										LEFT JOIN Operacion_lang ol ON p.operacion=ol.id AND ol.codlang=?
										LEFT JOIN Estado_lang es ON p.estado=es.id AND es.codlang=?
										WHERE p.web_url = ? AND pl.codlang = ? $habilitado ", array($lang, $lang, $lang, $lang, $lang, $lang, $url, $lang));
		$result = $query->result_array();
		if(!$result || empty($result)) {
			return Array(); 
		}
		return $result[0];
	}

	public function getInfoById($idpropuesta, $lang){
		//rl.nombre rubro, LEFT JOIN Rubro_lang pl ON p.idrubro=pl.id AND sl.codlang = ?	
		$query = $this->db->query("SELECT p.*, pl.*, el.nombre estrategica, il.nombre investigacion, sl.nombre solucion, ol.nombre iniciativa, inl.nombre innovacion 		 		
										FROM Propuesta p 
										JOIN Propuesta_lang pl ON p.idpropuesta=pl.idpropuesta 
										LEFT JOIN Estrategica_lang el ON p.linea_estrategica=el.id AND el.codlang = ?
										LEFT JOIN Investigacion_lang il ON p.tipo_investigacion=il.id AND il.codlang = ?
										LEFT JOIN Solucion_lang sl ON p.solucion_tecnologica=sl.id AND sl.codlang = ?	
										LEFT JOIN Innovacion_lang inl ON p.tipo_innovacion=inl.id AND inl.codlang = ?											
										LEFT JOIN Operacion_lang ol ON p.operacion=ol.id AND ol.codlang=?
										WHERE p.idpropuesta = ? AND pl.codlang = ? ", array($lang, $lang, $lang, $lang, $lang, $idpropuesta, $lang));
		$result = $query->result_array();
		if(!$result || empty($result)) {
			return Array(); 
		}
		return $result[0];
	}
	
	public function getPaises($idpropuesta, $lang){
		$query = $this->db->query("SELECT p.id, p.code, pl.nombre, max(i.participacion) participacion
									FROM Item i
									JOIN Pais p ON i.pais=p.id
									JOIN Pais_lang pl ON pl.id=p.id AND codlang = ? 
									WHERE i.idpropuesta = ? AND i.deleted IS NULL AND p.id<>24
									GROUP BY p.code
									ORDER BY max(i.participacion) DESC, pl.nombre ASC", array($lang, $idpropuesta));
		$result = $query->result_array();
		if(!$result || empty($result)) {
			return Array(); 
		}
		return $result;		
	}
	
	public function getFinanciamientoPorPais($idpropuesta, $lang){
		$query = $this->db->query("SELECT pl.nombre pais, 
											SUM(i.aporte_fontagro) fontagro,
											SUM(aporte_bid)+SUM(movilizacion_agencias)+SUM(aporte_agencias) bid,
											SUM(aporte_contrapartida) contrapartida
									FROM Item i
									JOIN Pais_lang pl ON pl.id=i.pais AND codlang = ? 
									WHERE i.idpropuesta = ? AND i.deleted IS NULL
									GROUP BY pl.id
									ORDER BY pl.nombre ASC", array($lang, $idpropuesta));
		$result = $query->result_array();
		if(!$result || empty($result)) {
			return Array(); 
		}
		return $result;		
	}


	public function getOtrasWeb($idpropuesta, $lang){
		$query = $this->db->query("SELECT p.web_foto as foto, p.web_url, p.web_publicado, pl.titulo_simple, p.urlvieja
									FROM Propuesta p
									JOIN Propuesta_lang pl ON p.idpropuesta=pl.idpropuesta	AND pl.codlang=?							
									WHERE p.web_publicado=1 AND p.idpropuesta<>? AND p.web_foto IS NOT NULL AND p.web_foto<>'' ORDER BY RAND() LIMIT 3 ", array($lang, $idpropuesta));
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

	public function insertarAdjunto($idadjunto, $idpropuesta){
		$query=$this->db->query("INSERT INTO Propuesta_adjunto(idadjunto, idpropuesta) VALUES(?, ?)", Array($idadjunto, $idpropuesta) );
		if($this->loggear){
			$query=$this->db->query("INSERT INTO Logs(entidad, sentencia, idusuario, idprincipal, funcion) VALUES(?,?,?,?,?) ", Array($this->table, "INSERT INTO Propuesta_adjunto(idadjunto, idpropuesta) VALUES($idadjunto, $idpropuesta)", $this->session->userdata('idusuario'), $idadjunto, 'insertarAdjunto') );
		}
	}

	public function eliminarAdjunto($idadjunto, $idpropuesta){
		$query=$this->db->query("DELETE FROM Propuesta_adjunto WHERE idadjunto=? AND idpropuesta=?", Array($idadjunto, $idpropuesta) );
		if($this->loggear){
			$query=$this->db->query("INSERT INTO Logs(entidad, sentencia, idusuario, idprincipal, funcion) VALUES(?,?,?,?,?) ", Array($this->table, "DELETE FROM Propuesta_adjunto WHERE idadjunto=$idadjunto AND idpropuesta=$idpropuesta", $this->session->userdata('idusuario'), $idadjunto, 'eliminarAdjunto') );
		}
	}

	public function getAdjuntos($tipo, $idpropuesta, $lang){
		$query = $this->db->query("SELECT al.nombre, archivo, tal.nombre tipo, a.urlold 
									FROM Propuesta_adjunto pa 
									JOIN Adjunto a ON a.idadjunto = pa.idadjunto 
									JOIN Adjunto_lang al ON al.idadjunto = a.idadjunto AND al.codlang = ?
									JOIN TipoAdjunto_lang tal ON tal.idtipo=a.idtipo AND tal.codlang=?
									WHERE pa.idpropuesta = ? AND a.idtipo=? ORDER BY a.orden ASC", array($lang, $lang, $idpropuesta, $tipo));
		$result = $query->result_array();
		if(!$result || empty($result)) {
			return Array(); 
		}
		return $result;
	}

	public function getAdjuntosVerProy($idpropuesta, $lang){
		$query = $this->db->query("SELECT al.nombre, archivo, tal.nombre tipo, a.urlold, 'adjuntos' carpeta 
									FROM Propuesta_adjunto pa 
									JOIN Adjunto a ON a.idadjunto = pa.idadjunto 
									JOIN Adjunto_lang al ON al.idadjunto = a.idadjunto AND al.codlang = ?
									JOIN TipoAdjunto_lang tal ON tal.idtipo=a.idtipo AND tal.codlang=?
									WHERE a.habilitado=1 AND pa.idpropuesta = ? AND a.idtipo IN (6,7) ORDER BY a.orden ASC, a.idadjunto DESC", array($lang, $lang, $idpropuesta));
		$result = $query->result_array();
		if(!$result || empty($result)) {
			return Array(); 
		}
		return $result;
	}

	public function getProductosVerProy($idpropuesta, $lang){
		$query = $this->db->query("SELECT pl.nombre, archivo, ptl.nombre tipo, '' urlold, 'productos' carpeta 
									FROM Producto p
									JOIN Producto_lang pl ON p.idproducto=pl.idproducto AND pl.codlang = ?
									JOIN ProductoTipo_lang ptl ON ptl.idtipo=p.idtipo AND ptl.codlang=?
									WHERE p.idpropuesta = ? AND publicado=1 ORDER BY p.orden ASC, p.idproducto DESC", array($lang, $lang, $idpropuesta));
		$result = $query->result_array();
		if(!$result || empty($result)) {
			return Array(); 
		}
		return $result;
	}

	public function getAportesDashboard(){
		$query = $this->db->query("SELECT round(sum(total)) total, pais, p.code, pl.nombre
									FROM Item i 
									JOIN Pais p ON p.id=i.pais
									JOIN Pais_lang pl ON pl.id=i.pais AND pl.codlang='es'  
									WHERE deleted is null 
									GROUP BY pais order by sum(total) desc ");
		$retorno = Array('paises'=>$query->result_array());
		$query = $this->db->query("SELECT round(sum(total)) total FROM Item i WHERE deleted is null ");
		$retorno['total'] = $query->result_array()[0]['total'];
		return $retorno;
	}

	public function getCantidadDashboard(){
		$query = $this->db->query("SELECT count(*) total FROM Propuesta WHERE deleted IS NULL ");
		return $query->result_array()[0]['total'];
	}

	public function getTotalDashboard(){
		$query = $this->db->query("SELECT sum(total) total FROM Propuesta WHERE deleted IS NULL ");
		return $query->result_array()[0]['total'];
	}


	public function getSectorTexto($idpropuesta, $codlang){
		$query=$this->db->query("SELECT * 
									FROM Propuesta_Sector ps
									JOIN Sector_lang sl ON sl.id=ps.idsector AND sl.codlang=?
									WHERE ps.idpropuesta=? ", array($codlang, $idpropuesta));
		$resultado=$query->result_array();
		if (!$resultado || empty($resultado)) {
		  	return Array();
		}	
		foreach($resultado as &$sector){
			$query=$this->db->query("SELECT *	
										FROM Propuesta_Subsector ps
										JOIN Subsector_lang sl ON sl.id=ps.idsubsector AND sl.codlang=?
										JOIN Subsector s ON s.id=ps.idsubsector
										WHERE ps.idpropuesta=? AND s.idsector=? ORDER BY sl.nombre", array($codlang, $idpropuesta, $sector['idsector']));
			$sector['subsectores'] = $query->result_array();			
		}
		return $resultado;
	}
	
	public function getMapaId($idpropuesta){
		$query = $this->db->query("SELECT idmapa FROM Mapa WHERE idpropuesta=? AND deleted IS NULL ORDER BY idmapa ASC", array($idpropuesta));
		$result = $query->result_array();
		if(!$result || empty($result)) {
			return 0; 
		}
		return $result[0]['idmapa'];		
	}

	public function buscar($data){
		$codlang = $data['lang']; 
		$where = '';
		if(!empty($data['keyword'])){
			$palabras = explode(' ',$data['keyword']);
			foreach($palabras as $pal){
				$palabra = $this->db->_escape_str($pal);
				$where.=" AND (titulo_completo like '%$palabra%' OR titulo_simple like '%$palabra%' OR anio='$palabra' OR identificador like '%$palabra%')";
			}			
		}
		if(!empty($data['anio']) && is_numeric($data['anio'])){
			$where.=' AND p.anio='.$data['anio'];
		}
		if(!empty($data['tipo']) && is_numeric($data['tipo'])){
			$where.=' AND p.operacion='.$data['tipo'];
		}
		if(!empty($data['estado']) && is_numeric($data['estado'])){
			$where.=' AND p.estado='.$data['estado'];
		}
		if(!empty($data['estrategica']) && is_numeric($data['estrategica'])){
			$where.=' AND p.linea_estrategica='.$data['estrategica'];
		}
		if(!empty($data['innovacion']) && is_numeric($data['innovacion'])){
			$where.=' AND p.tipo_innovacion='.$data['innovacion'];
		}
		if(!empty($data['investigacion']) && is_numeric($data['investigacion'])){
			$where.=' AND p.tipo_investigacion='.$data['investigacion'];
		}
		if(!empty($data['solucion']) && is_numeric($data['solucion'])){
			$where.=' AND p.solucion_tecnologica='.$data['solucion'];
		}
		if(!empty($data['pais']) && is_numeric($data['pais'])){
			$where.=' AND p.idpropuesta IN (SELECT idpropuesta FROM Item WHERE pais='.$data['pais'].')';
		}
		if(!empty($data['sector'])){
			$where.=' AND p.idpropuesta IN (SELECT idpropuesta FROM Propuesta_Sector WHERE ';
			$first=true;
			foreach($data['sector'] as $sec){
				if(is_numeric($sec)){
					if(!$first) $where.=' AND ';
					$where.=' idsector='.$sec;
					$first=false;
				}
			}
			$where.=')';
		}
		if(!empty($data['subsector'])){
			$where.=' AND p.idpropuesta IN (SELECT idpropuesta FROM Propuesta_Subsector WHERE ';
			$first=true;
			foreach($data['subsector'] as $sec){
				if(is_numeric($sec)){
					if(!$first) $where.=' AND ';
					$where.=' idsubsector='.$sec;
					$first=false;
				}
			}
			$where.=')';
		}
		if(!empty($data['tema'])){
			$where.=' AND p.idpropuesta IN (SELECT idpropuesta FROM Propuesta_Tema WHERE ';
			$first=true;
			foreach($data['tema'] as $sec){
				if(is_numeric($sec)){
					if(!$first) $where.=' AND ';
					$where.=' idtema='.$sec;
					$first=false;
				}
			}
			$where.=')';
		}
		$pagina = (empty($data['pagina']) || !is_numeric($data['pagina']))? 0 : $data['pagina'];
		$cantidad = 10;
		$offset = $cantidad*$pagina;

		$querystr = "FROM Propuesta p 
						JOIN Propuesta_lang pl ON pl.idpropuesta=p.idpropuesta AND pl.codlang='$codlang'
						JOIN Operacion_lang ol ON ol.id=p.operacion AND ol.codlang='$codlang'
						WHERE p.deleted IS NULL AND p.web_publicado=1 $where";
		$query = $this->db->query("SELECT count(*) total 
										$querystr");
		$retorno = Array();	
		$retorno['total'] = $query->result_array()[0]['total'];							
		$query = $this->db->query("SELECT pl.titulo_simple, pl.titulo_completo, p.identificador, p.web_url, p.urlvieja, pl.web_resumen, p.web_publicado, p.anio, ol.nombre operacion 
										$querystr
										ORDER BY p.anio desc, p.idpropuesta DESC
										LIMIT $offset, $cantidad");
		$retorno['listado'] = $query->result_array();
		return $retorno;
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

	public function getAnios(){
		$query = $this->db->query("SELECT DISTINCT anio FROM Propuesta WHERE deleted IS NULL ORDER BY anio desc");
		return $query->result_array();
	}

	public function getByOrganismo($idorganismo){
		$retorno =Array();
		$query = $this->db->query("SELECT p.*, i.total as total_item, par.nombre as nombre_participacion 
									FROM v_Propuesta p 
									JOIN Item i ON p.idpropuesta=i.idpropuesta 
									JOIN v_Participacion par ON par.id=i.participacion
									WHERE i.idorganismo=?", Array($idorganismo));
		$retorno['financieros'] = $query->result_array();

		$query = $this->db->query("SELECT p.*
									FROM v_Propuesta p 
									JOIN Donante d ON d.idpropuesta=p.idpropuesta
									WHERE d.idorganismo=?", Array($idorganismo));
		$retorno['donantes'] = $query->result_array();

		$query = $this->db->query("SELECT w.*
									FROM v_Webstory w 
									JOIN Webstory_organismos d ON d.idwebstory=w.idwebstory
									WHERE d.idorganismo=?", Array($idorganismo));
		$retorno['webstories'] = $query->result_array();

		return $retorno;
	}
}

?>
