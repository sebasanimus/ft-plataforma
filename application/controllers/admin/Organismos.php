<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Organismos extends CI_Controller {

    public function __construct() {
		parent::__construct();
		$this->login->verify();

        $this->load->model('Organismo');
	}

	public function index()	{		
		header("Location: ".base_url().'admin/organismos/listar');
	}
	
    public function listar(){
		$data['libs'] = Array('datatables');
        $data['page'] = 'organismo_listar';
		$this->load->view('admin/estruc/estructura', $data);
    }


	public function paginar(){
		$input['busqueda'] = $this->input->post('sSearch');
		$input['comienzo'] = $this->input->post('iDisplayStart');
		$input['cantidad'] = $this->input->post('iDisplayLength');	
		$input['ordenar'] = $this->Organismo->idname;
				
		$columnas[0] = $this->Organismo->idname;
		$columnas[1] = 'logo';
		$columnas[2] = 'nombre';
		$columnas[3] = 'nombre_largo';
		$columnas[4] = 'tipo';
		$columnas[5] = 'pais';
		$columnas[6] = 'enuso';
		$columnas[7] = 'habilitado';
		$columnas[8] = $this->Organismo->idname;
		$sort = $this->input->post('iSortCol_0');
		$input['ordenar'] = $columnas[$sort].' '.$this->input->post('sSortDir_0');
		
		
		$output['sEcho'] = $this->input->post('sEcho');
		$output['iTotalRecords'] = $this->Organismo->getTotalRecords(); 
		$output['iTotalDisplayRecords'] = $this->Organismo->getTotalFilteredRecords($input);
		$output['aaData'] = array();
		$datos = $this->Organismo->getPaginated($input);
		foreach($datos as $dat){
			$salida = array();
			$salida[0] = $dat[$this->Organismo->idname];
			$salida[1] = $dat['logo'];
			$salida[2] = $dat['nombre'];
			$salida[3] = $dat['nombre_largo'];
			$salida[4] = $dat['tipo'];
			$salida[5] = $dat['pais'];
			$salida[6] = $dat['enuso'];
			$salida[7] = $dat['habilitado'];
			$salida[8] = $dat[$this->Organismo->idname];
			$output['aaData'][] = $salida;
		}
		echo json_encode($output);
	}


    public function modificar($idorganismo=0){
        $data['idorganismo'] = $idorganismo;
        $data['organismo'] = array();
        $this->load->helper('form');
		if (!empty($_POST)){           
			$organismo = array(); 
			
			$habilitado = (isset($_POST['habilitado']) && $_POST['habilitado']=='on')? 1 : 0;
			$organismo['habilitado'] = Array('val'=>$habilitado, 'req'=>FALSE);

			$organismo['nombre'] = Array('val'=>$this->input->post('nombre'), 'req'=>TRUE);
			$organismo['nombre_largo'] = Array('val'=>$this->input->post('nombre_largo'), 'req'=>FALSE);
			$organismo['link'] = Array('val'=>$this->input->post('link'), 'req'=>FALSE);
			$organismo['tipo_institucion'] = Array('val'=>$this->input->post('tipo_institucion'), 'req'=>TRUE);
			$organismo['idpais'] = Array('val'=>$this->input->post('idpais'), 'req'=>FALSE);
			$retUpload = $this->do_upload('logo');
			if(!empty($retUpload['imagen'])){
				$organismo['logo'] = Array('val'=>$retUpload['imagen'], 'req'=>FALSE);
			}
            
            $result = $this->Organismo->insertOrUpdate($idorganismo, $organismo);
            if($result && is_numeric($result)){				
				//$this->Organismo->insertOrUpdateLanguage($result, $datas_lang);
                redirect("admin/organismos/listar");
            }else{
                $data['error'] = $result;
                $data['organismo'] = $this->Organismo->getValores($organismo);
            }
        }else{
            if(!empty($idorganismo)){
				$organismo = $this->getCleanOrganismo($idorganismo);
                if(empty($organismo)){
                    $data['error'] = 'No se encontro al organismo con ID '.$idorganismo;
                }else{
					$data['organismo'] = $organismo;
					/*$datas_lang = array();
					$paqueteLang = $this->Organismo->getLanguages($idorganismo);
					foreach($paqueteLang as $pl){
						$datas_lang[$pl['codlang']] = $pl;
					}
					$data['datas_lang'] = $datas_lang;*/
                }
            }
		}
		$this->load->model('Institucion');
		$data['tipo_institucion'] = $this->Institucion->getAllView('nombre', 'asc');
		$this->load->model('Pais');
		$data['paises'] = $this->Pais->getAllView('nombre', 'asc');
		$this->load->model('Propuesta');
		$data['propuestas'] = $this->Propuesta->getByOrganismo($idorganismo);

		$data['libs'] = Array('jasny');
        $data['page'] = 'organismo_modificar';
        $this->load->view('admin/estruc/estructura', $data);        
	}

    private function getCleanOrganismo($idorganismo){
        if(empty($idorganismo) || !is_numeric($idorganismo)){
            $this->session->set_userdata('error', 'No se encontro al organismo con ID '.$idorganismo);
            redirect("admin/organismos");
        }
        $organismo = $this->Organismo->getById($idorganismo);
        if(empty($organismo)){
            $this->session->set_userdata('error', 'No se encontro al organismo con ID '.$idorganismo);
            redirect("admin/organismos");
        }
        return $organismo;
	}
	
	private function do_upload($campo) {
		$retorno = Array('error'=>'', 'imagen'=>'');
		if (isset($_FILES[$campo]) && is_uploaded_file($_FILES[$campo]['tmp_name'])) {
			$config['upload_path']          = './uploads/organismos/';
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
        echo $this->Organismo->eliminarSeguro($ideliminar);
	}
	
	function select($search){
		$retorno = array('results'=>array());
		$retorno['pagination'] = array('more'=>false);
		if(strlen($search)>0){
			$organismos = $this->Organismo->buscarSelect($search);
			$retorno['results'] = $organismos;
		}
		echo json_encode($retorno);
	}



    public function agregarDesdeSugerido(){
		$data = Array('error' => ''); 
		if (!empty($_POST)){           
			$organismo = array(); 
			
			$organismo['habilitado'] = Array('val'=>1, 'req'=>FALSE);
			$organismo['nombre'] = Array('val'=>$this->input->post('nombre'), 'req'=>TRUE);
			$organismo['nombre_largo'] = Array('val'=>$this->input->post('nombre_largo'), 'req'=>FALSE);
			$organismo['link'] = Array('val'=>$this->input->post('link'), 'req'=>FALSE);
			$organismo['idpais'] = Array('val'=>$this->input->post('idpais'), 'req'=>FALSE);
			$organismo['tipo_institucion'] = Array('val'=>$this->input->post('tipo_institucion'), 'req'=>FALSE);
            
            $result = $this->Organismo->insertOrUpdate(0, $organismo);
            if($result && is_numeric($result)){	
				$this->load->model('OrganismoSugerido');	
				$sugerido = $this->OrganismoSugerido->getById($this->input->post('idsugerido'));
				$this->OrganismoSugerido->setAprobado($this->input->post('idsugerido'));
				$this->load->library('Utilidades');
				$datos = Array(
					'nombre' =>  $organismo['nombre']['val'],
					'nombre_largo' =>  $organismo['nombre_largo']['val']
				);
				$this->utilidades->enviarEmailOrgAceptado($datos, $sugerido);
				
            }else{
                echo $result;
            }
        }       
	}
}
?>
