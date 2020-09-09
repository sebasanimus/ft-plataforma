<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Parametros extends CI_Controller {

    public function __construct() {
		parent::__construct();
		$this->login->verify();

        //$this->load->model('Parametro');
	}

	public function index()	{		
		header("Location: ".base_url().'admin/parametros/listar');
	}
	
    public function listar($param){
		$this->load->model($param, 'Parametro');
		$data['Parametro'] = $param;
		$data['libs'] = Array('datatables');
        $data['page'] = 'parametro_listar';
		$this->load->view('admin/estruc/estructura', $data);
    }


	public function paginar($param){
		$this->load->model($param, 'Parametro');
		$input['busqueda'] = $this->input->post('sSearch');
		$input['comienzo'] = $this->input->post('iDisplayStart');
		$input['cantidad'] = $this->input->post('iDisplayLength');	
		$input['ordenar'] = $this->Parametro->idname;
				
		$columnas[0] = $this->Parametro->idname;
		$columnas[1] = 'nombre';
		$columnas[2] = $this->Parametro->idname;
		$sort = $this->input->post('iSortCol_0');
		if(!empty($sort)){
			$input['ordenar'] = $columnas[$sort].' '.$this->input->post('sSortDir_0');
		}
		
		$output['sEcho'] = $this->input->post('sEcho');
		$output['iTotalRecords'] = $this->Parametro->getTotalRecords(); 
		$output['iTotalDisplayRecords'] = $this->Parametro->getTotalFilteredRecords($input);
		$output['aaData'] = array();
		$datos = $this->Parametro->getPaginated($input);
		foreach($datos as $dat){
			$salida = array();
			$salida[0] = $dat[$this->Parametro->idname];
			$salida[1] = $dat['nombre'];
			$salida[2] = $dat[$this->Parametro->idname];
			$output['aaData'][] = $salida;
		}
		echo json_encode($output);
	}
	

    public function modificar($param, $idparametro=0){
		$this->load->model($param, 'Parametro');
		$data['Parametro'] = $param;
		$data['lenguajes'] = $this->Lenguaje->getHabilitados('idlenguaje', 'asc');
		$data['datas_lang'] = array();
        $data['idparametro'] = $idparametro;
        $data['param'] = array();
        $this->load->helper('form');
		if (!empty($_POST)){           
			$parametro = array(); 
			$datas_lang = array();
			foreach($data['lenguajes'] as $lenguaje){
				$paquete_lang= array();
				$paquete_lang['nombre'] =$this->input->post('nombre_'.$lenguaje->codlang);
				$datas_lang[$lenguaje->codlang] = $paquete_lang;
			}
            
            $result = $this->Parametro->insertOrUpdate($idparametro, $parametro);
            if($result && is_numeric($result)){				
				$this->Parametro->insertOrUpdateLanguage($result, $datas_lang);
                redirect("admin/parametros/listar/".$param);
            }else{
                $data['error'] = $result;
                $data['param'] = $this->Parametro->getValores($parametro);
            }
        }else{
            if(!empty($idparametro)){
                $parametro = $this->getCleanParametro($idparametro);
                if(empty($parametro)){
                    $data['error'] = 'No se encontro al parametro con ID '.$idparametro;
                }else{
					$data['param'] = $parametro;
					$datas_lang = array();
					$paqueteLang = $this->Parametro->getLanguages($idparametro);
					foreach($paqueteLang as $pl){
						$datas_lang[$pl['codlang']] = $pl;
					}
					$data['datas_lang'] = $datas_lang;
                }
            }
		}
		$data['libs'] = Array();
        $data['page'] = 'parametro_modificar';
        $this->load->view('admin/estruc/estructura', $data);        
	}

    private function getCleanParametro($idparametro){
        if(empty($idparametro) || !is_numeric($idparametro)){
            $this->session->set_userdata('error', 'No se encontro al parametro con ID '.$idparametro);
            redirect("admin/parametros");
        }
        $parametro = $this->Parametro->getById($idparametro);
        if(empty($parametro)){
            $this->session->set_userdata('error', 'No se encontro al parametro con ID '.$idparametro);
            redirect("admin/parametros");
        }
        return $parametro;
    }


    public function eliminar($param){
		$this->load->model($param, 'Parametro');
        $ideliminar = $_POST['ideliminar'];
        echo $this->Parametro->eliminarSeguro($ideliminar);
    }
}
?>
