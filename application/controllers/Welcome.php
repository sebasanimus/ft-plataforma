<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()	{
		redirect('proyectos/'); exit;
		$data = array();
		if (!empty($_POST)) {
			$rUser = $this->login->in();
						
			if ($rUser==false) {
				$data['error'] = 'Verifique usuario y contraseña';
			}else{
				$this->toDashboard();
			}
			
		}else{
			if($this->login->isLogged() ){
				$this->toDashboard();
			}
		}	
		$data['error'] = $this->session->userdata('error_login');	
		$this->load->view('admin/login', $data);
	}

	public function logout() {
		$this->login->out();
		redirect('proyectos/'); exit;
		redirect('admin/');
	}

	public function toDashboard(){
		redirect('proyectos/'); exit;
		redirect("admin/dashboard/");
	}
}
