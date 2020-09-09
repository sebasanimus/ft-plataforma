<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Indicastandares extends CI_Controller {

    public function __construct() {
		parent::__construct();
		$this->login->verify();

        $this->load->model('Indicastandar');
	}

	public function index()	{		
		header("Location: ".base_url().'admin/indicastandares/listar');
	}
	
    public function listar(){
		$data['libs'] = Array('datatables');
        $data['page'] = 'indicastandar_listar';
		$this->load->view('admin/estruc/estructura', $data);
    }


	public function paginar(){
		$input['busqueda'] = $this->input->post('sSearch');
		$input['comienzo'] = $this->input->post('iDisplayStart');
		$input['cantidad'] = $this->input->post('iDisplayLength');	
		$input['ordenar'] = $this->Indicastandar->idname;
				
		$columnas[0] = $this->Indicastandar->idname;
		$columnas[1] = 'nombre';
		$columnas[2] = 'componente';
		$columnas[3] = $this->Indicastandar->idname;
		$sort = $this->input->post('iSortCol_0');
		if(!empty($sort)){
			$input['ordenar'] = $columnas[$sort].' '.$this->input->post('sSortDir_0');
		}
		
		$output['sEcho'] = $this->input->post('sEcho');
		$output['iTotalRecords'] = $this->Indicastandar->getTotalRecords(); 
		$output['iTotalDisplayRecords'] = $this->Indicastandar->getTotalFilteredRecords($input);
		$output['aaData'] = array();
		$datos = $this->Indicastandar->getPaginated($input);
		foreach($datos as $dat){
			$salida = array();
			$salida[0] = $dat[$this->Indicastandar->idname];
			$salida[1] = $dat['nombre'];
			$salida[2] = $dat['componente'];
			$salida[3] = $dat[$this->Indicastandar->idname];
			$output['aaData'][] = $salida;
		}
		//print_r($this->Indicastandar->getIndicastandarted($input)); exit;
		echo json_encode($output);
	}
	

    public function modificar($idindicastandar=0){
		$data['lenguajes'] = $this->Lenguaje->getHabilitados('idlenguaje', 'asc');
		$data['datas_lang'] = array();
        $data['idindicastandar'] = $idindicastandar;
        $data['indicastandar'] = array();
        $this->load->helper('form');
		if (!empty($_POST)){           
			$indicastandar = array(); 
			$datas_lang = array();
			$indicastandar['componente'] = Array('val'=>$this->input->post('componente'), 'req'=>TRUE);
			foreach($data['lenguajes'] as $lenguaje){
				$paquete_lang= array();
				$paquete_lang['nombre'] =$this->input->post('nombre_'.$lenguaje->codlang);
				$datas_lang[$lenguaje->codlang] = $paquete_lang;
			}
            
            $result = $this->Indicastandar->insertOrUpdate($idindicastandar, $indicastandar);
            if($result && is_numeric($result)){				
				$this->Indicastandar->insertOrUpdateLanguage($result, $datas_lang);
                redirect("admin/indicastandares/listar");
            }else{
                $data['error'] = $result;
                $data['indicastandar'] = $this->Indicastandar->getValores($indicastandar);
            }
        }else{
            if(!empty($idindicastandar)){
				$indicastandar = $this->getCleanIndicastandar($idindicastandar);
                if(empty($indicastandar)){
                    $data['error'] = 'No se encontro al indicastandar con ID '.$idindicastandar;
                }else{
					$data['indicastandar'] = $indicastandar;
					$datas_lang = array();
					$paqueteLang = $this->Indicastandar->getLanguages($idindicastandar);
					foreach($paqueteLang as $pl){
						$datas_lang[$pl['codlang']] = $pl;
					}
					$data['datas_lang'] = $datas_lang;
                }
            }
		}
		$this->load->model('Componente');
		$data['componentes'] = $this->Componente->getAllByLang('es');
		$data['libs'] = Array();
        $data['page'] = 'indicastandar_modificar';
        $this->load->view('admin/estruc/estructura', $data);        
	}

    private function getCleanIndicastandar($idindicastandar){
        if(empty($idindicastandar) || !is_numeric($idindicastandar)){
            $this->session->set_userdata('error', 'No se encontro al indicastandar con ID '.$idindicastandar);
            redirect("admin/indicastandares");
        }
        $indicastandar = $this->Indicastandar->getById($idindicastandar);
        if(empty($indicastandar)){
            $this->session->set_userdata('error', 'No se encontro al indicastandar con ID '.$idindicastandar);
            redirect("admin/admin/indicastandares");
        }
        return $indicastandar;
    }


    public function eliminar(){
        $ideliminar = $_POST['ideliminar'];
        echo $this->Indicastandar->eliminarSeguro($ideliminar);
    }
}
?>
