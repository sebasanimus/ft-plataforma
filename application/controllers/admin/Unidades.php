<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Unidades extends CI_Controller {

    public function __construct() {
		parent::__construct();
		$this->login->verify();

        $this->load->model('Unidad');
	}

	public function index()	{		
		header("Location: ".base_url().'admin/unidades/listar');
	}
	
    public function listar(){
		$data['libs'] = Array('datatables');
        $data['page'] = 'unidad_listar';
		$this->load->view('admin/estruc/estructura', $data);
    }


	public function paginar(){
		$input['busqueda'] = $this->input->post('sSearch');
		$input['comienzo'] = $this->input->post('iDisplayStart');
		$input['cantidad'] = $this->input->post('iDisplayLength');	
		$input['ordenar'] = $this->Unidad->idname;
				
		$columnas[0] = $this->Unidad->idname;
		$columnas[1] = 'nombre';
		$columnas[2] = 'fun';
		$columnas[3] = $this->Unidad->idname;
		$sort = $this->input->post('iSortCol_0');
		if(!empty($sort)){
			$input['ordenar'] = $columnas[$sort].' '.$this->input->post('sSortDir_0');
		}
		
		$output['sEcho'] = $this->input->post('sEcho');
		$output['iTotalRecords'] = $this->Unidad->getTotalRecords(); 
		$output['iTotalDisplayRecords'] = $this->Unidad->getTotalFilteredRecords($input);
		$output['aaData'] = array();
		$datos = $this->Unidad->getPaginated($input);
		foreach($datos as $dat){
			$salida = array();
			$salida[0] = $dat[$this->Unidad->idname];
			$salida[1] = $dat['nombre'];
			$salida[2] = $dat['fun'];
			$salida[3] = $dat[$this->Unidad->idname];
			$output['aaData'][] = $salida;
		}
		echo json_encode($output);
	}
	

    public function modificar($idunidad=0){
		$data['lenguajes'] = $this->Lenguaje->getHabilitados('idlenguaje', 'asc');
		$data['datas_lang'] = array();
        $data['idunidad'] = $idunidad;
        $data['unidad'] = array();
        $this->load->helper('form');
		if (!empty($_POST)){           
			$unidad = array(); 
			$datas_lang = array();
			$unidad['fun'] = Array('val'=>$this->input->post('fun'), 'req'=>TRUE);
			foreach($data['lenguajes'] as $lenguaje){
				$paquete_lang= array();
				$paquete_lang['nombre'] =$this->input->post('nombre_'.$lenguaje->codlang);
				$datas_lang[$lenguaje->codlang] = $paquete_lang;
			}
            
            $result = $this->Unidad->insertOrUpdate($idunidad, $unidad);
            if($result && is_numeric($result)){				
				$this->Unidad->insertOrUpdateLanguage($result, $datas_lang);
                redirect("admin/unidades/listar");
            }else{
                $data['error'] = $result;
                $data['unidad'] = $this->Unidad->getValores($unidad);
            }
        }else{
            if(!empty($idunidad)){
				$unidad = $this->getCleanUnidad($idunidad);
                if(empty($unidad)){
                    $data['error'] = 'No se encontro al unidad con ID '.$idunidad;
                }else{
					$data['unidad'] = $unidad;
					$datas_lang = array();
					$paqueteLang = $this->Unidad->getLanguages($idunidad);
					foreach($paqueteLang as $pl){
						$datas_lang[$pl['codlang']] = $pl;
					}
					$data['datas_lang'] = $datas_lang;
                }
            }
		}
		$data['libs'] = Array();
        $data['page'] = 'unidad_modificar';
        $this->load->view('admin/estruc/estructura', $data);        
	}

    private function getCleanUnidad($idunidad){
        if(empty($idunidad) || !is_numeric($idunidad)){
            $this->session->set_userdata('error', 'No se encontro al unidad con ID '.$idunidad);
            redirect("admin/unidades");
        }
        $unidad = $this->Unidad->getById($idunidad);
        if(empty($unidad)){
            $this->session->set_userdata('error', 'No se encontro al unidad con ID '.$idunidad);
            redirect("admin/unidades");
        }
        return $unidad;
    }


    public function eliminar(){
        $ideliminar = $_POST['ideliminar'];
        echo $this->Unidad->eliminarSeguro($ideliminar);
    }
}
?>
