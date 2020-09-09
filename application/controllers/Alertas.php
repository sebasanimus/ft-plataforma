<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alertas extends CI_Controller {

    public function __construct() {
		parent::__construct();
		$this->login->verify();
	}

	public function index()	{		
	}	

	public function getAlertas(){
		$this->load->Model('Alerta');
		$retorno = Array('alertas'=>$this->Alerta->getAbiertas($this->session->userdata('idusuario')));
		echo json_encode($retorno);
	}

	public function getAlerta(){
		$idalerta = $this->input->post('idalerta');
		$this->load->Model('Alerta');
		$retorno = Array('alerta'=>$this->Alerta->getAlerta($idalerta, $this->session->userdata('idusuario')));
		echo json_encode($retorno);
	}

	public function cerrarAlerta(){
		$idalerta = $this->input->post('idalerta');
		$this->load->Model('Alerta');
		$this->Alerta->cerrarAlerta($idalerta, $this->session->userdata('idusuario'));
	}

	/*public function test(){
		$this->load->library('Utilidades');
		$this->utilidades->crearAlerta('Nuevo Organismo Sugerido', 'Se encuentran pendiente de moderación nuevos organismos sugeridos', base_url().'admin/organismosugeridos/listar', 'nuevo_organismo');				
	}*/
	
}
?>
