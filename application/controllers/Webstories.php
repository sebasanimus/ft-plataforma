<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Webstories extends CI_Controller {

    public function __construct() {
		parent::__construct();

		$this->load->model('Webstory');

	}

	public function index()	{		
		header("Location: ".base_url().'webstories/listar');
	}

	public function listar(){
		redirect(LINK_PROYECTOS);
	}
	
	public function ver($url, $lang){
		$lang = ($lang=='en')? 'en' : 'es';

		$data = array();
		$data['lang'] = $lang;
		$puedeVerBorrador = $this->login->isLogged() && ($this->session->userdata('role')==1 || $this->session->userdata('role')==4);
		$data['webstory'] = $this->Webstory->getByUrl($url, $lang, $puedeVerBorrador);
		if(empty($data['webstory'])){
			header("Location: ".base_url().'webstories/listar');
			exit;
		} 
		$idwebstory = $data['webstory']['idwebstory'];
		$idpropuesta = $data['webstory']['idpropuesta'];

		$this->load->model('Info');
		$data['textos'] = $this->Info->obtenerByIndiceLang($lang, 'webstory');

		$this->load->model('Badge');
		$data['badges'] = $this->Badge->getByWebstoryVista($idwebstory, $lang);

		$this->load->model('WSIndicador');
		$data['indicadores'] = $this->WSIndicador->getByWebstory($idwebstory, $lang, 8);

		$this->load->model('Propuesta');
		$paisesPro = $this->Propuesta->getPaises($idpropuesta, $lang);
		$paisesWeb = $this->Webstory->getPaises($idwebstory, $idpropuesta, $lang);

		$data['paises'] = array_merge($paisesPro, $paisesWeb);
		
		$this->load->model('Tema');
		$data['temas'] = $this->Tema->getByPropuestaVista($idpropuesta, $lang);

		$data['propuesta'] = $this->Webstory->getInfoPropuesta($idwebstory, $lang);

		$data['fotosIniciativa'] = $this->Webstory->getAdjuntos(4, $idwebstory, $lang);

		$data['fotosGaleria'] = $this->Webstory->getAdjuntos(1, $idwebstory, $lang);

		$data['fotosEstadisticas'] = $this->Webstory->getAdjuntos(3, $idwebstory, $lang);

		$this->load->model('Organismo');
		$organismosPro = $this->Organismo->getByPropuesta($idpropuesta);
		$organismosWeb = $this->Organismo->getByWebstory($idwebstory);
		$data['organismos'] = array_merge($organismosPro, $organismosWeb);

		$data['link_propuesta'] = (!empty($data['propuesta']['web_publicado']) && !empty($data['propuesta']['web_url']))? LINK_PROYECTOS.$data['propuesta']['web_url'].'/'.$lang : '';
		if(empty($data['link_propuesta'])){
			//if(empty($data['propuesta']['urlvieja'])){
				$data['link_propuesta'] = 'https://www.fontagro.org/es/resultados/buscador-de-proyectos/';
			/*}else{
				$data['link_propuesta'] = $data['propuesta']['urlvieja'];
			}*/
		}

		$data['donantes'] = $this->Organismo->getDonantes($idpropuesta);

		$data['otrasStories'] =  $this->Webstory->getOtrasWS($idwebstory, $lang);

		$this->load->view('webstory_ver', $data);
	}

	public function todas($lang){
		$lang = ($lang=='en')? 'en' : 'es';
		$data = Array();
		$data['lang'] = $lang;
		$data['otrasStories'] = $this->Webstory->getTodasWS($lang);
		$this->load->view('webstory_todas', $data);
	}



	public function techs($lang){
		$lang = ($lang=='en')? 'en' : 'es';
		$data = Array();
		$data['lang'] = $lang;
		$this->load->model('Tech');
		$data['techies'] = $this->Tech->getTodos($lang);
		$this->load->view('techs_todos', $data);
	}
}
?>
