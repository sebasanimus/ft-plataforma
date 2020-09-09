<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Propuestas extends CI_Controller {

    public function __construct() {
		parent::__construct();

		$this->load->model('Propuesta');

	}

	public function index()	{		
		header("Location: ".base_url().'propuestas/home/es');
	}

	public function home($lang){
		$lang = ($lang=='en')? 'en' : 'es';
		$data = array();
		$data['lang'] = $lang;

		$this->load->model('Info');
		$data['textos'] = $this->Info->obtenerByIndiceLang($lang, 'webstory');

		$data['cantpropuestas'] = $this->Propuesta->getCantidadDashboard();
		$data['totalusd'] = $this->Propuesta->getTotalDashboard();

		$data['puntosMapa'] = $this->Propuesta->getPuntosPpales($lang);
		$data['puntosMapaEstimados'] = $this->Propuesta->getPuntosEstimados($lang);

		$data['propuestas'] = $this->Propuesta->getHome($lang);

		$this->load->model('Webstory');
		$data['webstories'] = $this->Webstory->getOtrasWS(0, $lang);

		$this->load->model('Noticia');
		$data['noticias'] = $this->Noticia->getHome($lang);

		$this->load->model('Iniciativa');
		$data['iniciativas'] = $this->Iniciativa->getEnCurso($lang);

		//buscador
		//$this->load->model('Operacion');
		//$data['tipos'] = $this->Operacion->getAllByLang($lang, 'nombre', 'asc');
		$data['anios'] = $this->Propuesta->getAnios();
		$this->load->model('Estado');
		$data['estados'] = $this->Estado->getAllByLang($lang, 'nombre', 'asc');
		$this->load->model('Pais');
		$data['paises'] = $this->Pais->getAllByLang($lang, 'nombre', 'asc');
		$this->load->model('Estrategica');
		$data['estrategicas'] = $this->Estrategica->getAllByLang($lang, 'nombre', 'asc');
		$this->load->model('Innovacion');
		$data['innovaciones'] = $this->Innovacion->getAllByLang($lang, 'nombre', 'asc');
		$this->load->model('Investigacion');
		$data['investigaciones'] = $this->Investigacion->getAllByLang($lang, 'nombre', 'asc');
		$this->load->model('Solucion');
		$data['soluciones'] = $this->Solucion->getAllByLang($lang, 'nombre', 'asc');
		$this->load->model('Sector');
		$data['sectores'] = $this->Sector->getAllByLang($lang, 'nombre', 'asc');
		$this->load->model('Subsector');
		$data['subsectores'] = $this->Subsector->getAllByLang($lang, 'nombre', 'asc');
		$this->load->model('Tema');
		$data['temas'] = $this->Tema->getAllByLang($lang, 'nombre', 'asc');
	
		$this->load->view('proyecto_home', $data);
	}
	
	public function ver($url, $lang){
		$lang = ($lang=='en')? 'en' : 'es';

		$data = array();
		$data['lang'] = $lang;
		$puedeVerBorrador = $this->login->isLogged() && $this->session->userdata('role')==1;

		$data['propuesta'] = $this->Propuesta->getByUrl($url, $lang, $puedeVerBorrador);
		if(empty($data['propuesta'])){
			header("Location: ".base_url().'propuestas/home/es');
			exit;
		} 
		$idpropuesta = $data['propuesta']['idpropuesta'];

		$this->load->model('Info');
		$data['textos'] = $this->Info->obtenerByIndiceLang($lang, 'webstory');

		$data['paises'] = $this->Propuesta->getPaises($idpropuesta, $lang);

		$this->load->model('Badge');
		$data['badges'] = $this->Badge->getByPropuestaVista($idpropuesta, $lang);

		$this->load->model('Noticia');
		$data['noticias'] = $this->Noticia->getByPropuesta($idpropuesta, $lang);

		$this->load->model('Webstory');
		$webstories = $this->Webstory->getByPropuesta($idpropuesta, $lang);
		$data['webstory'] = empty($webstories)? Array() : $webstories[0];
		$data['posters'] = $webstories;

		$this->load->model('Organismo');
		$data['participaciones'] = $this->Organismo->getByPropuestaCompleto($idpropuesta, $lang);

		$data['donantes'] = $this->Organismo->getDonantes($idpropuesta);
		$data['donantesObligados'] = $this->Organismo->getDonantesObligados($idpropuesta);

		$data['otrasPropuestas'] =  $this->Propuesta->getOtrasWeb($idpropuesta, $lang);

		$data['financiamiento'] = $this->Propuesta->getFinanciamientoPorPais($idpropuesta, $lang);

		$data['documentos'] = $this->Propuesta->getAdjuntosVerProy($idpropuesta, $lang);
		$data['documentos'] = array_merge($this->Propuesta->getProductosVerProy($idpropuesta, $lang),$data['documentos']);

		$this->load->model('Tema');
		$data['temas'] = $this->Tema->getTemasPropuestaTexto($idpropuesta, $lang);

		$data['sectores'] = $this->Propuesta->getSectorTexto($idpropuesta, $lang);

		$this->load->model('Tech');
		$data['techs'] = $this->Tech->getByPropuesta($idpropuesta, $lang);



		$this->load->model('Mapaelemento');
		$this->load->model('Mapa');
		$idmapa = $this->Propuesta->getMapaId($idpropuesta);
		if(!empty($idmapa)){
			$data['elementos'] = $this->Mapaelemento->getByMapa($idmapa);
			if(!empty($data['elementos'])){
				$data['mapa'] = $this->Mapa->getById($idmapa);
				$data['startingPoint'] = $this->Propuesta->getStartingPoint($idpropuesta);
			}
		}
			
		$this->load->view('proyecto_ver', $data);
	}


	public function iniciativa($idiniciativa, $url, $lang){
		$lang = ($lang=='en')? 'en' : 'es';

		$data = array();
		$data['lang'] = $lang;

		$this->load->model('Iniciativa');
		$data['iniciativa'] = $this->Iniciativa->getByIdLang($lang, $idiniciativa);
		if(empty($data['iniciativa'])){
			redirect(base_url().'proyectos/home/es');
			exit;
		}
		$this->load->model('Info');
		$data['textos'] = $this->Info->obtenerByIndiceLang($lang, 'webstory');

		$this->load->view('proyecto_iniciativa', $data);
	}

	public function buscar($lang){
		$lang = ($lang=='en')? 'en' : 'es';

		$data = array();
		$data['lang'] = $lang;


		$data['pagina'] = $this->input->get('pagina');

		$data['keyword'] = $this->input->get('keyword');
		$data['anio'] = $this->input->get('anio');
		$data['tipo'] = $this->input->get('tipo');
		$data['estado'] = $this->input->get('estado');
		$data['pais'] = $this->input->get('pais');
		$data['estrategica'] = $this->input->get('estrategica');
		$data['innovacion'] = $this->input->get('innovacion');
		$data['investigacion'] = $this->input->get('investigacion');
		$data['solucion'] = $this->input->get('solucion');
		$data['sector'] = $this->input->get('sector');
		$data['subsector'] = $this->input->get('subsector');
		$data['tema'] = $this->input->get('tema');

		$busqueda = $this->Propuesta->buscar($data);
		$data['propuestas'] = $busqueda['listado'];
		$data['total'] = $busqueda['total'];
				

		$this->load->model('Info');
		$data['textos'] = $this->Info->obtenerByIndiceLang($lang, 'webstory');
		
		//$this->load->model('Operacion');
		//$data['tipos'] = $this->Operacion->getAllByLang($lang, 'nombre', 'asc');
		$data['anios'] = $this->Propuesta->getAnios();
		$this->load->model('Estado');
		$data['estados'] = $this->Estado->getAllByLang($lang, 'nombre', 'asc');
		$this->load->model('Pais');
		$data['paises'] = $this->Pais->getAllByLang($lang, 'nombre', 'asc');

		$this->load->model('Estrategica');
		$data['estrategicas'] = $this->Estrategica->getAllByLang($lang, 'nombre', 'asc');
		$this->load->model('Innovacion');
		$data['innovaciones'] = $this->Innovacion->getAllByLang($lang, 'nombre', 'asc');
		$this->load->model('Investigacion');
		$data['investigaciones'] = $this->Investigacion->getAllByLang($lang, 'nombre', 'asc');
		$this->load->model('Solucion');
		$data['soluciones'] = $this->Solucion->getAllByLang($lang, 'nombre', 'asc');
		$this->load->model('Sector');
		$data['sectores'] = $this->Sector->getAllByLang($lang, 'nombre', 'asc');
		$this->load->model('Subsector');
		$data['subsectores'] = $this->Subsector->getAllByLang($lang, 'nombre', 'asc');
		$this->load->model('Tema');
		$data['temas'] = $this->Tema->getAllByLang($lang, 'nombre', 'asc');

		$data['criterio'] = Array();
		if(!empty($data['keyword'])) $data['criterio'][] = $data['keyword'];


		$this->load->model('Iniciativa');
		$data['iniciativas'] = $this->Iniciativa->getEnCurso($lang);

		$this->load->view('proyecto_buscar', $data);
	}


	public function mapa($lang){
		$lang = ($lang=='en')? 'en' : 'es';
		$data = array();
		$data['lang'] = $lang;

		$this->load->model('Info');
		$data['textos'] = $this->Info->obtenerByIndiceLang($lang, 'webstory');


		$data['puntosMapa'] = $this->Propuesta->getPuntosPpales($lang);
		$data['puntosMapaEstimados'] = $this->Propuesta->getPuntosEstimados($lang);

		
		$this->load->view('proyecto_mapa', $data);
	}
}
?>
