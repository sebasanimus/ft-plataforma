<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Webservice extends CI_Controller {

    public function __construct() {
		parent::__construct();

		$this->load->model('Propuesta');
		$this->load->model('Tecnica');
	}

	private function cors() {
		// Allow from any origin
		if (isset($_SERVER['HTTP_ORIGIN'])) {
			// Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
			// you want to allow, and if so:
			header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
			header('Access-Control-Allow-Credentials: true');
			header('Access-Control-Max-Age: 86400');    // cache for 1 day
		}

		// Access-Control headers are received during OPTIONS requests
		if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

			if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
				header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         

			if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
				header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
			exit(0);
		}
	}

	private function getLang($codlang){
		if(empty($codlang)){
			return 'es';
		}
		$codlang = substr($codlang, 0, 2);
		if($codlang!='en'){
			return 'es';
		}
		return $codlang;
	}
	
	public function getFiltros(){
		$this->cors();
		$request_body = file_get_contents('php://input');
		$datos = json_decode($request_body, true);	
		$codlang = $this->getLang($datos['codlang']);
		$retorno = Array();
		$this->load->model('Estrategica');
		$retorno['estrategica'] = $this->Estrategica->getAllByLang($codlang);
		$this->load->model('Operacion');
		$retorno['operacion'] = $this->Operacion->getAllByLang($codlang);
		$this->load->model('Investigacion');
		$retorno['tipoInvestigacion'] = $this->Investigacion->getAllByLang($codlang);
		$this->load->model('Innovacion');
		$retorno['tipoInnovacion'] = $this->Innovacion->getAllByLang($codlang);
		$this->load->model('Solucion');
		$retorno['solucion'] = $this->Solucion->getAllByLang($codlang);
		$this->load->model('Pais');
		$retorno['pais'] = $this->Pais->getAllByLang($codlang, 'nombre', 'asc');
		$this->load->model('Region');
		$retorno['region'] = $this->Region->getAllByLang($codlang, 'nombre', 'asc');
		$this->load->model('Institucion');
		$retorno['institucion'] = $this->Institucion->getAllByLang($codlang, 'nombre', 'asc');
		//$this->load->model('Rubro');
		//$retorno['rubro'] = $this->Rubro->getAllByLang($codlang, 'nombre', 'asc');
		//$this->load->model('Areainvestigacion');
		//$retorno['area_investigacion'] = $this->Areainvestigacion->getAllByLang($codlang, 'nombre', 'asc');
		$this->load->model('Sector');
		$retorno['sector_productivo'] = $this->Sector->getAllByLang($codlang, 'nombre', 'asc');
		$this->load->model('Tema');
		$retorno['tema'] = $this->Tema->getAllByLang($codlang, 'nombre', 'asc');

		$this->load->model('Item');
		$retorno['organismo'] = $this->Item->getAllOrganismoEjecutor();
		$retorno['organismoCo'] = $this->Item->getAllOrganismo();


		echo json_encode($retorno);
	}
	
	public function getData(){
		$this->cors();
		$request_body = file_get_contents('php://input');
		$datos = json_decode($request_body, true);	
		$codlang = $this->getLang($datos['codlang']);
		$retorno = ($datos['campo']=='resumen')?  $this->Propuesta->getResumenData($codlang, $datos['tipo']) : $this->Propuesta->getGraphData($codlang, $datos['campo'], $datos['tipo'], $datos);
		echo json_encode($retorno);
	}

	
	public function getFiltrosTecnica(){
		$this->cors();
		$request_body = file_get_contents('php://input');
		$datos = json_decode($request_body, true);	
		$codlang = $this->getLang($datos['codlang']);
		$retorno = Array();
		$this->load->model('Estrategica');
		$retorno['estrategica'] = $this->Estrategica->getAllByLang($codlang);
		$this->load->model('Operacion');
		$retorno['operacion'] = $this->Operacion->getAllByLang($codlang);
		$this->load->model('Investigacion');
		$retorno['tipoInvestigacion'] = $this->Investigacion->getAllByLang($codlang);
		$this->load->model('Innovacion');
		$retorno['tipoInnovacion'] = $this->Innovacion->getAllByLang($codlang);
		$this->load->model('Solucion');
		$retorno['solucion'] = $this->Solucion->getAllByLang($codlang);
		$this->load->model('Pais');
		$retorno['pais'] = $this->Pais->getAllByLang($codlang);
		$this->load->model('Region');
		$retorno['region'] = $this->Region->getAllByLang($codlang);
		$this->load->model('Institucion');
		$retorno['institucion'] = $this->Institucion->getAllByLang($codlang);
		//$this->load->model('Rubro');
		//$retorno['rubro'] = $this->Rubro->getAllByLang($codlang);
		//$this->load->model('Areainvestigacion');
		//$retorno['area_investigacion'] = $this->Areainvestigacion->getAllByLang($codlang);
		$this->load->model('Sector');
		$retorno['sector_productivo'] = $this->Sector->getAllByLang($codlang);
		$this->load->model('Tema');
		$retorno['tema'] = $this->Tema->getAllByLang($codlang, 'nombre', 'asc');


		$this->load->model('Componente');
		$retorno['componente'] = $this->Componente->getAllByLang($codlang);

		$this->load->model('Indicastandar');
		$retorno['indicador'] = $this->Indicastandar->getAllByLangComp($codlang, $datos['componente']);
		$this->load->model('Unidad');
		$retorno['unidad'] = $this->Unidad->getAllByLangComp($codlang, $datos['componente'], $datos['indicador']);

		$this->load->model('Item');
		$retorno['organismo'] = $this->Item->getAllOrganismo();

		
		$retorno['localidad'] = $this->Tecnica->getAllLocalidad($codlang);
		//$retorno['indicador'] = $this->Tecnica->getAllIndicador($codlang);
		//$retorno['unidad'] = $this->Tecnica->getAllUnidad($codlang);

		echo json_encode($retorno);
	}

	
	public function getDataTecnica(){
		$this->cors();
		$request_body = file_get_contents('php://input');
		$datos = json_decode($request_body, true);	
		$codlang = $this->getLang($datos['codlang']);
		$retorno = $this->Tecnica->getData($codlang, $datos);
		echo json_encode($retorno);
	}

	public function downloadDataTecnica(){
		$this->cors();
		$request_body = file_get_contents('php://input');
		$datos = json_decode($request_body, true);	
		$codlang = $this->getLang($datos['codlang']);
		$retorno = $this->Tecnica->getData($codlang, $datos);

		$this->download_send_headers("data_export_" . date("Y-m-d") . ".csv");
		echo $this->array2csv($retorno['datos']);
	}

	public function downloadPropuestas(){
		$this->cors();
		$request_body = file_get_contents('php://input');
		$datos = json_decode($request_body, true);	
		$codlang = $this->getLang($datos['codlang']);
		$retorno = $this->Propuesta->getResumenData($codlang, 'money');

		$this->download_send_headers("data_export_" . date("Y-m-d") . ".csv");
		echo $this->array2csv($retorno['tablaCompleta']);
	}


	private function array2csv(array &$array){
		if (count($array) == 0) {
			return null;
		}
		ob_start();
		$df = fopen("php://output", 'w');
		fputcsv($df, array_keys(reset($array)));
		foreach ($array as $row) {
			fputcsv($df, $row);
		}
		fclose($df);
		return ob_get_clean();
	}

	private function download_send_headers($filename) {
		// disable caching
		
	    $ctype="application/vnd.ms-excel";

	    //Begin writing headers
	    header("Pragma: public");
	    header("Expires: 0");
	    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	    header("Cache-Control: public");
	    header("Content-Description: File Transfer");
	   
	    //Use the switch-generated Content-Type
	    header("Content-Type: $ctype");

	    //Force the download
	    $header="Content-Disposition: attachment; filename=".$filename.";";
	    header($header );
	    header("Content-Transfer-Encoding: binary");
	    //header("Content-Length: ".$len);
	}

}