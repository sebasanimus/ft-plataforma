<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Items extends CI_Controller {

    public function __construct() {
		parent::__construct();
		$this->login->verify();

		$this->load->model('Item');
		$this->load->model('Propuesta');
	}

	public function index()	{		
		header("Location: ".base_url().'admin/propuestas/listar');
	}
	/*
    public function listar($idpropuesta){
		if(!is_numeric($idpropuesta) || empty($idpropuesta)){
			header("Location: ".base_url().'admin/propuestas/listar');
		}
		$data['propuesta'] = $this->Propuesta->getById($idpropuesta);
		$data['libs'] = Array('datatables');
        $data['page'] = 'item_listar';
		$this->load->view('admin/estruc/estructura', $data);
    }*/


	public function paginar($idpropuesta){
		if(!is_numeric($idpropuesta) || empty($idpropuesta)){
			header("Location: ".base_url().'admin/propuestas/listar');
		}
		$input['idpropuesta'] = $idpropuesta;
		$input['busqueda'] = $this->input->post('sSearch');
		$input['comienzo'] = $this->input->post('iDisplayStart');
		$input['cantidad'] = $this->input->post('iDisplayLength');	
		$input['ordenar'] = 'iditem';
				
		$columnas[0] = 'pais';
		$columnas[1] = 'organismo';
		$columnas[2] = 'participacion';
		$columnas[3] = 'region';
		$columnas[4] = 'aporte_fontagro';
		$columnas[5] = 'aporte_bid';
		$columnas[6] = 'movilizacion_agencias';
		$columnas[7] = 'aporte_contrapartida';
		$columnas[8] = 'aporte_agencias';
		$columnas[9] = 'total';
		$columnas[10] = 'iditem';
		$sort = $this->input->post('iSortCol_0');
		if(!empty($sort)){
			$input['ordenar'] = $columnas[$sort].' '.$this->input->post('sSortDir_0');
		}
		
		$output['sEcho'] = $this->input->post('sEcho');
		$output['iTotalRecords'] = $this->Item->getTotalRecords(); 
		$output['iTotalDisplayRecords'] = $this->Item->getTotalFilteredRecords($input);
		$output['aaData'] = array();
		$datos = $this->Item->getPaginated($input);
		foreach($datos as $dat){
			$salida = array();
			$salida[0] = $dat['pais'];
			$salida[1] = $dat['organismo'];
			$salida[2] = $dat['participacion'];
			$salida[3] = $dat['region'];
			$salida[4] = '$ '.number_format($dat['aporte_fontagro'],0);
			$salida[5] = '$ '.number_format($dat['aporte_bid'],0);
			$salida[6] = '$ '.number_format($dat['movilizacion_agencias'],0);
			$salida[7] = '$ '.number_format($dat['aporte_contrapartida'],0);
			$salida[8] = '$ '.number_format($dat['aporte_agencias'],0);
			$salida[9] = '$ '.number_format($dat['total'],0);
			$salida[10] = $dat['iditem'];
			$output['aaData'][] = $salida;
		}
		//print_r($this->Item->getItemted($input)); exit;
		echo json_encode($output);
	}
	

    public function modificar($idpropuesta, $iditem=0){
		if(!is_numeric($idpropuesta) || empty($idpropuesta)){
			header("Location: ".base_url().'admin/propuestas/listar');
		}
		$data['idpropuesta'] = $idpropuesta;
		$data['lenguajes'] = $this->Lenguaje->getHabilitados('idlenguaje', 'asc');
		$data['datas_lang'] = array();
        $data['iditem'] = $iditem;
        $data['item'] = array();
        $this->load->helper('form');
		if (!empty($_POST)){           
			$item = array();
			
			$item['idpropuesta'] = Array('val'=>$idpropuesta, 'req'=>TRUE);
			$item['idorganismo'] = Array('val'=>$this->input->post('idorganismo'), 'req'=>TRUE);
												
			$item['participacion'] = Array('val'=>$this->input->post('participacion'), 'req'=>TRUE);						
			$item['tipo_institucion'] = Array('val'=>$this->input->post('tipo_institucion'), 'req'=>TRUE);					
			$item['region'] = Array('val'=>$this->input->post('region'), 'req'=>TRUE);					
			$item['pais'] = Array('val'=>$this->input->post('pais'), 'req'=>TRUE);

			$item['aporte_fontagro'] = Array('val'=>$this->solo_numeros($this->input->post('aporte_fontagro')), 'req'=>FALSE);
			$item['aporte_bid'] = Array('val'=>$this->solo_numeros($this->input->post('aporte_bid')), 'req'=>FALSE);
			$item['movilizacion_agencias'] = Array('val'=>$this->solo_numeros($this->input->post('movilizacion_agencias')), 'req'=>FALSE);
			$item['aporte_contrapartida'] = Array('val'=>$this->solo_numeros($this->input->post('aporte_contrapartida')), 'req'=>FALSE);
			$item['aporte_agencias'] = Array('val'=>$this->solo_numeros($this->input->post('aporte_agencias')), 'req'=>FALSE);
			$total = $item['aporte_fontagro']['val'] + 
						$item['aporte_bid']['val'] + 
						$item['movilizacion_agencias']['val'] + 
						$item['aporte_contrapartida']['val'] + 
						$item['aporte_agencias']['val'];
			$item['total'] = Array('val'=>$total, 'req'=>FALSE);
			
			/*$datas_lang = array();
			foreach($data['lenguajes'] as $lenguaje){
				$paquete_lang= array();
				$paquete_lang['pais'] = $this->input->post('pais_'.$lenguaje->codlang);
				$datas_lang[$lenguaje->codlang] = $paquete_lang;
			}*/
			            
            $result = $this->Item->insertOrUpdate($iditem, $item);
            if($result && is_numeric($result)){	
				$this->Propuesta->actualizarTotales($idpropuesta);			
				//$this->Item->insertOrUpdateLanguage($result, $datas_lang);
                redirect("admin/propuestas/ver/".$idpropuesta);
            }else{
                $data['error'] = $result;
                $data['item'] = $this->Item->getValores($item);
            }
        }else{
            if(!empty($iditem)){
                $item = $this->getCleanItem($iditem);
                if(empty($item)){
                    $data['error'] = 'No se encontro al item con ID '.$iditem;
                }else{
					$data['item'] = $item;
					$this->load->model('Organismo');
					$data['organismo'] = $this->Organismo->getById($item['idorganismo']);
					/*$datas_lang = array();
					$paqueteLang = $this->Item->getLanguages($iditem);
					foreach($paqueteLang as $pl){
						$datas_lang[$pl['codlang']] = $pl;
					}
					$data['datas_lang'] = $datas_lang;*/
                }
            }
		}
		$this->load->model('Participacion');
		$data['participacion'] = $this->Participacion->getAllView('nombre', 'asc');
		$this->load->model('Institucion');
		$data['tipo_institucion'] = $this->Institucion->getAllView('nombre', 'asc');
		$this->load->model('Region');
		$data['region'] = $this->Region->getAllView('nombre', 'asc');
		$this->load->model('Pais');
		$data['pais'] = $this->Pais->getAllView('nombre', 'asc');

		$data['libs'] = Array('tinymce', 'icheck', 'select2');
        $data['page'] = 'item_modificar';
        $this->load->view('admin/estruc/estructura', $data);        
	}


	private function solo_numeros($val){
		$res = preg_replace('/[^0-9.]/', '', $val);
		if(empty($res)) return 0;
		return $res;
	}	


    private function getCleanItem($iditem){
        if(empty($iditem) || !is_numeric($iditem)){
            $this->session->set_userdata('error', 'No se encontro al item con ID '.$iditem);
            redirect("admin/items");
        }
        $item = $this->Item->getByIdTable($iditem);
        if(empty($item)){
            $this->session->set_userdata('error', 'No se encontro al item con ID '.$iditem);
            redirect("admin/items");
        }
        return $item;
    }


    public function eliminar(){
		$ideliminar = $_POST['ideliminar'];
		$item = $this->getCleanItem($ideliminar);
		$this->Item->eliminarBlando($ideliminar);
		$this->Propuesta->actualizarTotales($item['idpropuesta']);	
		echo $item['idpropuesta'];
    }
}
?>
