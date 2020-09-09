<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Exportartech extends CI_Controller {

    public function __construct() {
		parent::__construct();

		$this->load->model('Propuesta');       
		$this->load->model('Fontagro');
		$this->load->model('Pais');
		$this->load->model('Tech');
		$this->load->model('Webstory');
	}

	public function index()	{		
		header("Location: ".base_url().'exportartech/listar');
	}
	

	public function getHTML($idtech, $codlang){	
		$codlang = ($codlang=='en')? 'en' : 'es';
		$data = Array();	
		$tech = $this->Tech->getById($idtech);
		if(empty($tech)){
			exit;
		}

		$fontagro = $this->Fontagro->getByIdLang($codlang, 1);
		$db = $this->Propuesta->graficoTortaTotales();
		
		$valores = $this->Propuesta->totalTabla();
		$paisesMiembro = $this->Pais->getPaisesMiembro($codlang);
		
		$en = ($codlang == 'es') ? 'en' : 'in';

		$this->load->model('Info');
		$data['textos'] = $this->Info->obtenerByIndiceLang($codlang, 'webstory');

		$idwebstory = $tech['idwebstory']; 
		$data['webstory'] = $this->Webstory->getByIdLang($codlang, $idwebstory);
		$idpropuesta = $data['webstory']['idpropuesta'];
		$this->load->model('Badge');
		$data['badges'] = $this->Badge->getByWebstoryVista($idwebstory, $codlang);
		$this->load->model('WSIndicador');
		$data['indicadores'] = $this->WSIndicador->getByWebstory($idwebstory, $codlang, 6);
		
		$paisesPro = $this->Propuesta->getPaises($idpropuesta, $codlang);
		$paisesWeb = $this->Webstory->getPaises($idwebstory, $idpropuesta, $codlang);
		$data['paises'] = array_merge($paisesPro, $paisesWeb);

		$this->load->model('Organismo');
		$data['donantes'] = $this->Organismo->getDonantes($idpropuesta);
		
		$data['paisesMiembro'] = $paisesMiembro;
		$data['valores'] = $valores;
		$data['db'] = $db;
		$data['fontagro'] = $fontagro;
		$this->load->view('tech_maqueta', $data);
	}

	public function generarPDF($idtech, $codlang){
		$codlang = ($codlang=='en')? 'en' : 'es';	
		$tech = $this->Tech->getById($idtech);
		if(empty($tech)){
			exit;
		}
		
		$node = $this->config->item('tech_node');
		$hn = $this->config->item('tech_hn');
		$pathPDF = $this->config->item('tech_pathPDF');
		$pathPDF .= 'tech_pdf/tech_'.$idtech.'_'.$codlang.'.pdf';
		shell_exec($node.' '.$hn.'hn.js '.$idtech.' '.$codlang.' '.base_url().' '.$pathPDF.' 2>&1');

		redirect(base_url().'exportartech/verPDF/'.$idtech.'/'.$codlang);
	}

	public function verPDF($idtech, $codlang){
		$codlang = ($codlang=='en')? 'en' : 'es';	
		$tech = $this->Tech->getById($idtech);
		if(empty($tech)){
			exit;
		}
		if(empty($tech['habilitado'])){
			$this->login->verify();
		}
		$pathPDF = $this->config->item('tech_pathPDF');
		$pathPDF .= 'tech_pdf/tech_'.$idtech.'_'.$codlang.'.pdf';

		if(file_exists($pathPDF)){
			header("Content-type: application/pdf");
			header("Content-Disposition: inline; filename=fontagro-tech.pdf");
			@readfile($pathPDF);
		}else{
			echo 'EL ARCHIVO NO EXISTE';
			//$this->generarPDF($idtech, $codlang);
		}
		
	}
}
?>
