<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Organismosugeridos extends CI_Controller {

    public function __construct() {
		parent::__construct();
		$this->login->verify();

		$this->load->model('OrganismoSugerido');
	}

	public function index()	{		
		header("Location: ".base_url().'admin/organismosugeridos/listar');
	}
	
	public function listar(){
		$data =Array();
		$data['lenguajes'] = $this->Lenguaje->getHabilitados('idlenguaje', 'asc');
		$data['libs'] = Array('datatables');
		$data['page'] = 'organismosugerido_listar';
		$this->load->model('Pais');
		$data['paises'] = $this->Pais->getAllView('nombre', 'asc');	
		$this->load->model('Institucion');
		$data['tipo_institucion'] = $this->Institucion->getAllView('nombre', 'asc');
		$this->load->view('admin/estruc/estructura', $data);
	}

	public function paginar(){
		$input['busqueda'] = $this->input->post('sSearch');
		$input['comienzo'] = $this->input->post('iDisplayStart');
		$input['cantidad'] = $this->input->post('iDisplayLength');	
		$input['ordenar'] = 'created';
				
		$columnas[0] = 'created';
		$columnas[1] = 'nombre';
		$columnas[2] = 'nombre_largo';
		$columnas[3] = 'link';
		$columnas[4] = 'pais';
		$columnas[5] = 'tipo';
		$columnas[6] = 'usuario';
		$columnas[7] = 'idsugerido';
		$sort = $this->input->post('iSortCol_0');
		$input['ordenar'] = $columnas[$sort].' '.$this->input->post('sSortDir_0');
		
		
		$output['sEcho'] = $this->input->post('sEcho');
		$output['iTotalRecords'] = $this->OrganismoSugerido->getTotalRecords(); 
		$output['iTotalDisplayRecords'] = $this->OrganismoSugerido->getTotalFilteredRecords($input);
		$output['aaData'] = array();
		$datos = $this->OrganismoSugerido->getPaginated($input);
		foreach($datos as $dat){
			$salida = array();
			$salida[0] = fromYYYYMMDDtoDDMMYYY($dat['created'], false);
			$salida[1] = $dat['nombre'];
			$salida[2] = $dat['nombre_largo'];
			$salida[3] = $dat['link'];
			$salida[4] = $dat['pais'];
			$salida[5] = $dat['tipo'];
			$salida[6] = $dat['usuario'];
			$salida[7] = $dat['idsugerido'];
			$output['aaData'][] = $salida;
		}
		echo json_encode($output);
	}

	public function getSugerido(){
		$sugerido = $this->OrganismoSugerido->getById($this->input->post('idsugerido'));
		echo json_encode($sugerido);
	}

	public function rechazar(){			
		$sugerido = $this->OrganismoSugerido->getById($this->input->post('idsugerido'));
		$this->OrganismoSugerido->setRechazado($this->input->post('idsugerido'), $this->input->post('motivo'));
		$this->load->library('Utilidades');
		$datos = Array(
			'nombre' =>  $sugerido['nombre'],
			'nombre_largo' =>  $sugerido['nombre_largo'], 
			'motivo' => $this->input->post('motivo')
		);
		$this->utilidades->enviarEmailOrgRechazado($datos, $sugerido);
	}

}
?>
