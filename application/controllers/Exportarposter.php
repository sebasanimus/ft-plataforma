<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Exportarposter extends CI_Controller {

    public function __construct() {
		parent::__construct();

		$this->load->model('Propuesta');       
		$this->load->model('Fontagro');
		$this->load->model('Pais');
		$this->load->model('Tech');
		$this->load->model('Webstory');
	}

	public function index()	{		
		header("Location: ".base_url().'exportarposter/listar');
	}
	

	public function getHTML($url, $lang){	
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
		$data['indicadores'] = $this->WSIndicador->getByWebstory($idwebstory, $lang);

		$this->load->model('Propuesta');
		$paisesPro = $this->Propuesta->getPaises($idpropuesta, $lang);
		$paisesWeb = $this->Webstory->getPaises($idwebstory, $idpropuesta, $lang);
		$data['paises'] = array_merge($paisesPro, $paisesWeb);
		
		$data['propuesta'] = $this->Webstory->getInfoPropuesta($idwebstory, $lang);

		$this->load->model('Organismo');
		$organismosPro = $this->Organismo->getByPropuesta($idpropuesta);
		$organismosWeb = $this->Organismo->getByWebstory($idwebstory);
		$data['organismos'] = array_merge($organismosPro, $organismosWeb);
		$data['ejecutor'] = $this->Organismo->getByPropuestaCompleto($idpropuesta, $lang)[0]['organismos'][0];
		
		$data['donantes'] = $this->Organismo->getDonantes($idpropuesta);

		$this->load->view('poster_maqueta', $data);
	}

	public function generarPDF($url, $codlang){
		$codlang = ($codlang=='en')? 'en' : 'es';	

		$puedeVerBorrador = $this->login->isLogged() && ($this->session->userdata('role')==1 || $this->session->userdata('role')==4);
		$webstory = $this->Webstory->getByUrl($url, $codlang, $puedeVerBorrador);
		if(empty($webstory)){
			header("Location: ".base_url());
			exit;
		} 
		
		$node = $this->config->item('tech_node');
		$hn = $this->config->item('tech_hn');
		$pathPDF = $this->config->item('tech_pathPDF');
		$pathPDF .= 'poster_pdf/poster_'.$url.'_'.$codlang.'.pdf';
		shell_exec($node.' '.$hn.'hn-poster.js '.$url.' '.$codlang.' '.base_url().' '.$pathPDF.' 2>&1');

		redirect(base_url().'exportarposter/verPDF/'.$url.'/'.$codlang);
	}

	public function verPDF($url, $codlang){
		$codlang = ($codlang=='en')? 'en' : 'es';	

		$puedeVerBorrador = $this->login->isLogged() && ($this->session->userdata('role')==1 || $this->session->userdata('role')==4);
		$webstory = $this->Webstory->getByUrl($url, $codlang, $puedeVerBorrador);
		if(empty($webstory)){
			header("Location: ".base_url());
			exit;
		} 

		$pathPDF = $this->config->item('tech_pathPDF');
		$pathPDF .= 'poster_pdf/poster_'.$url.'_'.$codlang.'.pdf';

		if(file_exists($pathPDF)){
			header("Content-type: application/pdf");
			header("Content-Disposition: inline; filename=fontagro-poster-$url.pdf");
			@readfile($pathPDF);
		}else{
			redirect(base_url().'exportarposter/generarPDF/'.$url.'/'.$codlang);
		}
		
	}

	public function getQR($url, $codlang, $back = 'FFFFFF', $fore = '3a8269'){
		include('application/libraries/qr/qrlib.php');    
		// outputs image directly into browser, as PNG stream
		
		$tamaño = 10; //Tamaño de Pixel
		$level = 'L'; //Precisión Baja
		$framSize = 0; //Tamaño en blanco
		$back_color = hexdec($back);
		$fore_color = hexdec($fore);
    	echo QRcode::svg(LINK_WEBSTORIES.$url.'/'.$codlang, false, $level, $tamaño, $framSize, false, $back_color, $fore_color);
	}
}
?>
