<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
		parent::__construct();
		$this->login->verify();
	}

	public function index()	{		
		$lastlogin = $this->session->userdata('lastlogin');
		$date = new DateTime($lastlogin);
		$data['lastlogin'] = $date->format('d-m-Y');
		$this->load->Model('Usuario');
		$data['cantidadusuarios'] = $this->Usuario->getUltimosLogueados();
		$date = new DateTime($lastlogin);

		$this->load->Model('Propuesta');
		$data['aportes'] = $this->Propuesta->getAportesDashboard();

		$data['cantpropuestas'] = $this->Propuesta->getCantidadDashboard();

		$this->load->Model('Adjunto');
		$data['cantadjuntos'] = $this->Adjunto->getCantidadDashboard();

		$this->load->model('Noticia');
		$data['noticias'] = $this->Noticia->getDashboard();

		$this->load->model('Iniciativa');
		$data['cantiniciativas'] = $this->Iniciativa->getDashboard();

		$data['page'] = 'dashboard';
		$this->load->view('admin/estruc/estructura', $data);
	}	
	
}
?>
