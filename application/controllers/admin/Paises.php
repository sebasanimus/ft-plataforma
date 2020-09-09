<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Paises extends CI_Controller {

    public function __construct() {
		parent::__construct();
		$this->login->verify();

        $this->load->model('Pais');
	}

	public function index()	{		
		header("Location: ".base_url().'admin/paises/listar');
	}
	
    public function listar(){
		$data['libs'] = Array('datatables');
        $data['page'] = 'pais_listar';
		$this->load->view('admin/estruc/estructura', $data);
    }


	public function paginar(){
		$input['busqueda'] = $this->input->post('sSearch');
		$input['comienzo'] = $this->input->post('iDisplayStart');
		$input['cantidad'] = $this->input->post('iDisplayLength');	
		$input['ordenar'] = $this->Pais->idname;
				
		$columnas[0] = $this->Pais->idname;
		$columnas[1] = 'nombre';
		$columnas[2] = 'code';
		$columnas[3] = $this->Pais->idname;
		$sort = $this->input->post('iSortCol_0');
		if(!empty($sort)){
			$input['ordenar'] = $columnas[$sort].' '.$this->input->post('sSortDir_0');
		}
		
		$output['sEcho'] = $this->input->post('sEcho');
		$output['iTotalRecords'] = $this->Pais->getTotalRecords(); 
		$output['iTotalDisplayRecords'] = $this->Pais->getTotalFilteredRecords($input);
		$output['aaData'] = array();
		$datos = $this->Pais->getPaginated($input);
		foreach($datos as $dat){
			$salida = array();
			$salida[0] = $dat[$this->Pais->idname];
			$salida[1] = $dat['nombre'];
			$salida[2] = $dat['code'];
			$salida[3] = $dat[$this->Pais->idname];
			$output['aaData'][] = $salida;
		}
		echo json_encode($output);
	}
	
	private function solo_numeros($val){
		$res = preg_replace('/[^0-9.]/', '', $val);
		if(empty($res)) return 0;
		return $res;
	}

    public function modificar($idpais=0){
		$data['lenguajes'] = $this->Lenguaje->getHabilitados('idlenguaje', 'asc');
		$data['datas_lang'] = array();
        $data['idpais'] = $idpais;
        $data['pais'] = array();
        $this->load->helper('form');
		if (!empty($_POST)){           
			$pais = array(); 
			$datas_lang = array();
			$pais['code'] = Array('val'=>$this->input->post('code'), 'req'=>TRUE);
			$pais['contribucion_fija'] = Array('val'=>$this->solo_numeros($this->input->post('contribucion_fija')), 'req'=>FALSE);

			foreach($data['lenguajes'] as $lenguaje){
				$paquete_lang= array();
				$paquete_lang['nombre'] =$this->input->post('nombre_'.$lenguaje->codlang);
				$datas_lang[$lenguaje->codlang] = $paquete_lang;
			}
            
            $result = $this->Pais->insertOrUpdate($idpais, $pais);
            if($result && is_numeric($result)){				
				$this->Pais->insertOrUpdateLanguage($result, $datas_lang);
                redirect("admin/paises/listar");
            }else{
                $data['error'] = $result;
                $data['pais'] = $this->Pais->getValores($pais);
            }
        }else{
            if(!empty($idpais)){
				$pais = $this->getCleanPais($idpais);
                if(empty($pais)){
                    $data['error'] = 'No se encontro al pais con ID '.$idpais;
                }else{
					$data['pais'] = $pais;
					$datas_lang = array();
					$paqueteLang = $this->Pais->getLanguages($idpais);
					foreach($paqueteLang as $pl){
						$datas_lang[$pl['codlang']] = $pl;
					}
					$data['datas_lang'] = $datas_lang;
                }
            }
		}
		$data['libs'] = Array();
        $data['page'] = 'pais_modificar';
        $this->load->view('admin/estruc/estructura', $data);        
	}

    private function getCleanPais($idpais){
        if(empty($idpais) || !is_numeric($idpais)){
            $this->session->set_userdata('error', 'No se encontro al pais con ID '.$idpais);
            redirect("admin/paises");
        }
        $pais = $this->Pais->getById($idpais);
        if(empty($pais)){
            $this->session->set_userdata('error', 'No se encontro al pais con ID '.$idpais);
            redirect("admin/paises");
        }
        return $pais;
    }


    public function eliminar(){
        $ideliminar = $_POST['ideliminar'];
        echo $this->Pais->eliminarSeguro($ideliminar);
    }
}
?>
