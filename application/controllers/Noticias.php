<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Noticias extends CI_Controller {

    public function __construct() {
		parent::__construct();

		$this->load->model('Noticia');
		$this->load->model('Propuesta');
	}

	public function index()	{		
		header("Location: ".base_url().'noticias/listar');
	}

	public function listar(){
		redirect(LINK_PROYECTOS);
	}
	
	public function ver($idnoticia, $lang, $nombre=''){
		$lang = ($lang=='en')? 'en' : 'es';

		$data = array();
		$data['lang'] = $lang;
		$puedeVerBorrador = $this->login->isLogged() && $this->session->userdata('role')==1;

		$data['noticia'] = $this->Noticia->getNoticia($idnoticia, $lang, $puedeVerBorrador);

		if(empty($data['noticia'])){
			header("Location: ".base_url().'noticias/listar');
			exit;
		} 
		$idpropuesta = $data['noticia']['idpropuesta'];

		$this->load->model('Info');
		$data['textos'] = $this->Info->obtenerByIndiceLang($lang, 'webstory');
	
		$data['propuesta'] = $this->Propuesta->getInfoById($idpropuesta, $lang);

		$data['noticias'] = $this->Noticia->getByPropuesta($idpropuesta, $lang);
		$this->load->model('Webstory');
		$webstories = $this->Webstory->getByPropuesta($idpropuesta, $lang);
		$data['webstory'] = empty($webstories)? Array() : $webstories[0];
	
		$this->load->view('noticia_ver', $data);
	}
}
?>
