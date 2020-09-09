<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Badges extends CI_Controller {

    public function __construct() {
		parent::__construct();
		$this->login->verify();

        $this->load->model('Badge');
	}

	public function index()	{		
		header("Location: ".base_url().'admin/badges/listar');
	}
	
    public function listar(){
		$data['libs'] = Array('datatables');
        $data['page'] = 'badge_listar';
		$this->load->view('admin/estruc/estructura', $data);
    }


	public function paginar(){
		$input['busqueda'] = $this->input->post('sSearch');
		$input['comienzo'] = $this->input->post('iDisplayStart');
		$input['cantidad'] = $this->input->post('iDisplayLength');	
		$input['ordenar'] = $this->Badge->idname;
				
		$columnas[0] = $this->Badge->idname;
		$columnas[1] = 'nombre';
		$columnas[2] = 'descripcion';
		$columnas[3] = $this->Badge->idname;
		$sort = $this->input->post('iSortCol_0');
		if(!empty($sort)){
			$input['ordenar'] = $columnas[$sort].' '.$this->input->post('sSortDir_0');
		}
		
		$output['sEcho'] = $this->input->post('sEcho');
		$output['iTotalRecords'] = $this->Badge->getTotalRecords(); 
		$output['iTotalDisplayRecords'] = $this->Badge->getTotalFilteredRecords($input);
		$output['aaData'] = array();
		$datos = $this->Badge->getPaginated($input);
		foreach($datos as $dat){
			$salida = array();
			$salida[0] = $dat[$this->Badge->idname];
			$salida[1] = $dat['nombre'];
			$salida[2] = $dat['descripcion'];
			$salida[3] = $dat[$this->Badge->idname];
			$output['aaData'][] = $salida;
		}
		//print_r($this->Badge->getBadgeted($input)); exit;
		echo json_encode($output);
	}
	

    public function modificar($idbadgeods=0){
		$data['lenguajes'] = $this->Lenguaje->getHabilitados('idlenguaje', 'asc');
		$data['datas_lang'] = array();
        $data['idbadgeods'] = $idbadgeods;
        $data['badge'] = array();
        $this->load->helper('form');
		if (!empty($_POST)){           
			$badge = array(); 
			$datas_lang = array();
			$paqueteLang = $this->Badge->getLanguages($idbadgeods);
			
			foreach($data['lenguajes'] as $lenguaje){
				$paquete_lang= array();
				$paquete_lang['nombre'] =$this->input->post('nombre_'.$lenguaje->codlang);
				$paquete_lang['descripcion'] =$this->input->post('descripcion_'.$lenguaje->codlang);

				$retUpload = $this->do_upload('foto_'.$lenguaje->codlang);
				if(!empty($retUpload['imagen'])){
					$paquete_lang['foto'] = $retUpload['imagen'];
				}else if(!empty($idbadgeods)){ //sino me elimina la foto ya cargada
					foreach($paqueteLang as $pal){
						if($pal['codlang']==$lenguaje->codlang) $paquete_lang['foto'] = $pal['foto'];
					}		
				}

				$datas_lang[$lenguaje->codlang] = $paquete_lang;
			}
            
            $result = $this->Badge->insertOrUpdate($idbadgeods, $badge);
            if($result && is_numeric($result)){				
				$this->Badge->insertOrUpdateLanguage($result, $datas_lang);
                redirect("admin/badges/listar");
            }else{
                $data['error'] = $result;
                $data['badge'] = $this->Badge->getValores($badge);
            }
        }else{
            if(!empty($idbadgeods)){
				$badge = $this->getCleanBadge($idbadgeods);
                if(empty($badge)){
                    $data['error'] = 'No se encontro al badge con ID '.$idbadgeods;
                }else{
					$data['badge'] = $badge;
					$datas_lang = array();
					$paqueteLang = $this->Badge->getLanguages($idbadgeods);
					foreach($paqueteLang as $pl){
						$datas_lang[$pl['codlang']] = $pl;
					}
					$data['datas_lang'] = $datas_lang;
                }
            }
		}
		$data['libs'] = Array('jasny');
        $data['page'] = 'badge_modificar';
        $this->load->view('admin/estruc/estructura', $data);        
	}

    private function getCleanBadge($idbadgeods){
        if(empty($idbadgeods) || !is_numeric($idbadgeods)){
            $this->session->set_userdata('error', 'No se encontro al badge con ID '.$idbadgeods);
            redirect("admin/badges");
        }
        $badge = $this->Badge->getById($idbadgeods);
        if(empty($badge)){
            $this->session->set_userdata('error', 'No se encontro al badge con ID '.$idbadgeods);
            redirect("admin/badges");
        }
        return $badge;
	}
	
	private function do_upload($campo) {
		$retorno = Array('error'=>'', 'imagen'=>'');
		if (isset($_FILES[$campo]) && is_uploaded_file($_FILES[$campo]['tmp_name'])) {
			$config['upload_path']          = './uploads/badges/';
			$config['allowed_types']        = 'gif|jpg|jpeg|png';
			$config['max_size']             = 1000; //en kb

			$this->load->library('upload', $config);

			if (!$this->upload->do_upload($campo)){			
				$retorno['error'] = $this->upload->display_errors();
			}else{			
				$uploadData = $this->upload->data();
				$retorno['imagen'] = $uploadData['file_name'];		
			}
		}
		return $retorno;
	}


    public function eliminar(){
        $ideliminar = $_POST['ideliminar'];
        echo $this->Badge->eliminarSeguro($ideliminar);
    }
}
?>
