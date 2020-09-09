<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alianzas extends CI_Controller {

    public function __construct() {
		parent::__construct();

		$this->load->model('Organismo');
		$this->load->model('Institucion');
	}

	public function index()	{	
		$codlang= 'es';
		$this->lang($codlang);
	}

	public function lang($codlang){

		$data = Array();
		$tipo_institucion = $this->Institucion->getAllByLang($codlang, 'nombre', 'asc');
		foreach($tipo_institucion as &$ti){
			$ti['organismos'] = $this->Organismo->getByTipo($ti['value']);
		}
		$otros = Array('value'=>0, 'label'=>'Otros', 'organismos'=> $this->Organismo->getByTipo(0));
		$tipo_institucion[] = $otros;

		$textos = Array(
			'socios'=> ($codlang=='es')? 'Socios' : 'Strategic Partners',
			'aportes'=> ($codlang=='es')? '% de aportes sobre el total del fondo' : '% of contributions over the total',
		);
		$data['textos'] = $textos;
		$data['estadisticas'] = $this->Institucion->getEstadistica($codlang);
		$total = 0;
		foreach($data['estadisticas'] as $est){
			$total += $est['total'];
		}
		
		$data['tipo_institucion'] = $tipo_institucion;
		$data['total'] = $total;
		$this->load->view('alianzas', $data);
	}

}