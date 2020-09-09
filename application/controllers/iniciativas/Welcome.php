<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()	{
		$data = array();
		if (!empty($_POST)) {
			$rUser = $this->login->in();
					
			if ($rUser==false) {
				$data['error'] =  $this->session->userdata('error_login');
			}else{
				$this->toDashboard();
			}
			
		}else{
			if($this->login->isLogged() ){
				$this->toDashboard();
			}
		}	
		$codlang = $this->obtenerLang();
		$data['codlang'] = $codlang;
		$this->load->model('Info');
		$data['textos'] = $this->Info->obtenerByIndiceLang($codlang, 'perfil');
		$data['page'] = 'login'; 
		$this->load->view('iniciativas/login', $data);
	}

	public function logout() {
		$this->login->out();
		redirect('iniciativas/');
	}

	public function toDashboard(){
		redirect("iniciativas/perfiles/principal");
	}

	private function obtenerLang(){
		$get_codlang = $this->input->get('codlang');
		if(!empty($get_codlang)){
			$get_codlang = $get_codlang=='en'? 'en':'es';
			$this->session->set_userdata('codlang', $get_codlang);
		}
		$codlang = $this->session->userdata('codlang');
		if($codlang!='en'){ //si esta vacio o no es ingles, es español
			$codlang = 'es';
		}
		return $codlang;
	}

	public function registro()	{
		$data = array();
		$codlang = $this->obtenerLang();
		$data['codlang'] = $codlang;
		$this->load->model('Info');
		$data['textos'] = $this->Info->obtenerByIndiceLang($codlang, 'perfil');
		if (!empty($_POST)) {
			$usuario = array();
			$usuario['email'] = Array('val'=>$this->input->post('username'), 'req'=>TRUE);			
           
            $pass = $this->login->hashPass($this->input->post('password'));
			$usuario['password'] = Array('val'=>$pass, 'req'=>TRUE);
			
            $usuario['habilitado'] = Array('val'=>1, 'req'=>FALSE);
            $usuario['idtipousuario'] = Array('val'=>2, 'req'=>TRUE);
			
			$usuario['institucion'] = Array('val'=>$this->input->post('institucion'), 'req'=>TRUE);
			$usuario['posicion'] = Array('val'=>$this->input->post('posicion'), 'req'=>TRUE);
			$usuario['nombre'] = Array('val'=>$this->input->post('nombre'), 'req'=>TRUE);
			
            $result = $this->Usuario->insertOrUpdate(0, $usuario);					
			if($result && is_numeric($result)){
				$this->login->in();
				//Si hay solo una iniciativa abierta, lo inscribo
				$this->load->model('Iniciativa');
				$iniciativas = $this->Iniciativa->getAbiertas('es', $result);
				if(count($iniciativas)==1){
					$this->load->model('Perfil');
					$idperfil = $this->Perfil->crear($result, $iniciativas['0']['idiniciativa'], $iniciativas['0']['idoperacion']);
				}
				$this->load->library('Utilidades');
				$this->utilidades->enviarEmailInicial($data['textos'], $usuario['nombre']['val'], $usuario['email']['val']);
				$this->toDashboard();
			}else{
				$data['error'] = $result;
				$data['oldata'] = Array(
					'username' => $usuario['email']['val'],
					'institucion' => $usuario['institucion']['val'],
					'posicion' => $usuario['posicion']['val'],
					'nombre' => $usuario['nombre']['val'],
				);
			}			
		}else{
			if($this->login->isLogged() ){
				$this->toDashboard();
			}
		}	
		
		$data['page'] = 'registro'; 
		$this->load->view('iniciativas/registro', $data);
	}

	public function olvido(){	
		$codlang = $this->obtenerLang();	
		$data = array();
		$data['exito'] = false;
		$data['codlang'] = $codlang;
		$this->load->model('Info');
		$data['textos'] = $this->Info->obtenerByIndiceLang($codlang, 'perfil');
		$this->load->model('Usuario');
		if (!empty($_POST)) {
			$usuario = $this->Usuario->getByUsername($this->input->post('email'));
					
			if (empty($usuario)) {
				$data['error'] = $this->input->post('email').' '.$data['textos']['recuperar_error'];
			}else{
				$this->load->library('Utilidades');
				$token = $this->utilidades->random_str(48);
				$this->Usuario->actualizarToken($usuario[0]->idusuario, $token);
				$this->utilidades->enviarEmailRecuperar($data['textos'], $token, $this->input->post('email'));
				$data['exito'] = true;
			}
			
		}
		$data['page'] = 'olvido'; 
		$this->load->view('iniciativas/login_olvido', $data);
	}

	public function recuperar($token){
		$codlang = $this->obtenerLang();
		$data = array();
		$data['exito'] = false;	
		$data['codlang'] = $codlang;
		$this->load->model('Info');
		$data['textos'] = $this->Info->obtenerByIndiceLang($codlang, 'perfil');

		if (!empty($_POST)) {
			$usuario = $this->Usuario->getByUsername($this->input->post('email'));
			if(empty($usuario)){
				$data['error'] = $this->input->post('email').' '.$data['textos']['recuperar_error'];
			}else if(empty($token) || $usuario[0]->pass_token!=$token){
				$data['error'] = $data['textos']['recuperar_error_token'];
			}else{
				$t1 = strtotime( 'now' );
				$t2 = strtotime( $usuario[0]->pass_token_updated );
				$diff = $t1 - $t2;
				$hours = round($diff / ( 60 * 60 ));
				if($hours>24){
					$data['error'] = $data['textos']['recuperar_error_expirado'];
				}else{
					$nuevoPass = $this->login->hashPass($this->input->post('password'));
					$this->Usuario->cambiarPass($usuario[0]->idusuario, $nuevoPass);
					$data['exito'] = true;
				}
			}

		}
		$data['page'] = 'recuperar'; 
		$this->load->view('iniciativas/login_recuperar', $data);
	}
/*
	public function testmail(){
		$data = Array();
		$data['url'] = base_url();
		$this->load->library('utilidades');
		$data['nombre'] = 'Sebas';
		$data['page'] = 'mail_inicial';
		$this->load->model('Info');
		$data['textos'] = $this->Info->obtenerByIndiceLang('es', 'perfil');
		$this->load->view('iniciativas/mail', $data);
	}

	public function testsendmail(){
		$data = Array();
		$this->load->library('utilidades');
		$token = $this->utilidades->random_str(48);
		$this->load->model('Info');
		$data['textos'] = $this->Info->obtenerByIndiceLang('es', 'perfil');
		
		$this->utilidades->enviarEmailRecuperar($data['textos'], $token, 'szsebas@gmail.com');
	}*/
}
