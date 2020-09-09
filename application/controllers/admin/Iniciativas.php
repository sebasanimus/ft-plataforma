<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Iniciativas extends CI_Controller {

    public function __construct() {
		parent::__construct();
		$this->login->verify();

		$this->load->model('Iniciativa');
	}

	public function index()	{		
		header("Location: ".base_url().'admin/iniciativas/listar');
	}
	
	public function listar(){
		$data =Array();
		$data['lenguajes'] = $this->Lenguaje->getHabilitados('idlenguaje', 'asc');
		$data['libs'] = Array('datatables');
        $data['page'] = 'iniciativa_listar';
		$this->load->view('admin/estruc/estructura', $data);
	}

	public function paginar(){
		$input['busqueda'] = $this->input->post('sSearch');
		$input['comienzo'] = $this->input->post('iDisplayStart');
		$input['cantidad'] = $this->input->post('iDisplayLength');	
		$input['ordenar'] = 'idiniciativa';
				
		$columnas[0] = 'idiniciativa';
		$columnas[1] = 'titulo';
		$columnas[2] = 'tipo';
		$columnas[3] = 'fecha_desde';
		$columnas[4] = 'fecha_hasta';
		$columnas[5] = 'estado';
		$columnas[6] = 'idiniciativa';
		$sort = $this->input->post('iSortCol_0');
		if(!empty($sort)){
			$input['ordenar'] = $columnas[$sort].' '.$this->input->post('sSortDir_0');
		}
		
		$output['sEcho'] = $this->input->post('sEcho');
		$output['iTotalRecords'] = $this->Iniciativa->getTotalRecords(); 
		$output['iTotalDisplayRecords'] = $this->Iniciativa->getTotalFilteredRecords($input);
		$output['aaData'] = array();
		$datos = $this->Iniciativa->getPaginated($input);
		foreach($datos as $dat){
			$salida = array();
			$salida[0] = $dat['idiniciativa'];
			$salida[1] = $dat['titulo'];
			$salida[2] = $dat['tipo'];
			$salida[3] = fromYYYYMMDDtoDDMMYYY($dat['fecha_desde'], false);
			$salida[4] = fromYYYYMMDDtoDDMMYYY($dat['fecha_hasta'], false);
			$salida[5] = $dat['estado'];
			$salida[6] = $dat['idiniciativa'];
			$output['aaData'][] = $salida;
		}
		//print_r($this->Iniciativa->getItemted($input)); exit;
		echo json_encode($output);
	}

	public function modificar($idiniciativa=0){
		$data['lenguajes'] = $this->Lenguaje->getHabilitados('idlenguaje', 'asc');
		$data['datas_lang'] = array();
        $data['idiniciativa'] = $idiniciativa;
        $data['iniciativa'] = array();
        $this->load->helper('form');
		if (!empty($_POST)){           
			$iniciativa = array();
			
			$iniciativa['idoperacion'] = Array('val'=>$this->input->post('idoperacion'), 'req'=>TRUE);	
			$iniciativa['idestado'] = Array('val'=>$this->input->post('idestado'), 'req'=>TRUE);	
			$iniciativa['fecha_desde'] = Array('val'=>fromDDMMYYYtoYYYYMMDD($this->input->post('fecha_desde'), false), 'req'=>FALSE);		
			$iniciativa['fecha_hasta'] = Array('val'=>fromDDMMYYYtoYYYYMMDD($this->input->post('fecha_hasta'), false), 'req'=>FALSE);		
			$iniciativa['fecha_preseleccion'] = Array('val'=>fromDDMMYYYtoYYYYMMDD($this->input->post('fecha_preseleccion'), false), 'req'=>FALSE);

			$iniciativa['identificador'] = Array('val'=>$this->input->post('identificador'), 'req'=>FALSE);
			$iniciativa['link_preseleccionados'] = Array('val'=>$this->input->post('link_preseleccionados'), 'req'=>FALSE);
			$iniciativa['link_ganadores'] = Array('val'=>$this->input->post('link_ganadores'), 'req'=>FALSE);
			
			$retUpload = $this->do_upload('foto');
			if(!empty($retUpload['imagen'])){
				$iniciativa['foto'] = Array('val'=>$retUpload['imagen'], 'req'=>FALSE);
			}
			
			$datas_lang = array();
			foreach($data['lenguajes'] as $lenguaje){
				$paquete_lang= array();
				$paquete_lang['titulo'] = $this->input->post('titulo_'.$lenguaje->codlang);
				$paquete_lang['descripcion'] = $this->input->post('descripcion_'.$lenguaje->codlang);
				$paquete_lang['link_terminos'] = $this->input->post('link_terminos_'.$lenguaje->codlang);
				$paquete_lang['html_parte1'] = $this->input->post('html_parte1_'.$lenguaje->codlang);
				$paquete_lang['html_parte2'] = $this->input->post('html_parte2_'.$lenguaje->codlang);
				$paquete_lang['html_intro'] = $this->input->post('html_intro_'.$lenguaje->codlang);
				$datas_lang[$lenguaje->codlang] = $paquete_lang;
			}
			            
            $result = $this->Iniciativa->insertOrUpdate($idiniciativa, $iniciativa);
            if($result && is_numeric($result)){			
				$this->Iniciativa->insertOrUpdateLanguage($result, $datas_lang);
                redirect("admin/iniciativas/listar/");
            }else{
                $data['error'] = $result;
                $data['iniciativa'] = $this->Iniciativa->getValores($iniciativa);
            }
        }else{
            if(!empty($idiniciativa)){
                $iniciativa = $this->getCleanIniciativa($idiniciativa);
                if(empty($iniciativa)){
                    $data['error'] = 'No se encontro al iniciativa con ID '.$idiniciativa;
                }else{
					$data['iniciativa'] = $iniciativa;
					$datas_lang = array();
					$paqueteLang = $this->Iniciativa->getLanguages($idiniciativa);
					foreach($paqueteLang as $pl){
						$datas_lang[$pl['codlang']] = $pl;
					}
					$data['datas_lang'] = $datas_lang;
                }
            }
		}		
		if(!empty($data['iniciativa'])){
			$data['iniciativa']['fecha_desde'] = fromYYYYMMDDtoDDMMYYY($data['iniciativa']['fecha_desde'], false);
			$data['iniciativa']['fecha_hasta'] = fromYYYYMMDDtoDDMMYYY($data['iniciativa']['fecha_hasta'], false);
			$data['iniciativa']['fecha_preseleccion'] = fromYYYYMMDDtoDDMMYYY($data['iniciativa']['fecha_preseleccion'], false);
		}
		$this->load->model('Operacion');
		$data['tipos'] = $this->Operacion->getAllView('nombre', 'asc');
		$this->load->model('EstadoIniciativa');
		$data['estados'] = $this->EstadoIniciativa->getAllView('id', 'asc');
		$data['libs'] = Array('jasny', 'tinymce', 'datetimepicker');
        $data['page'] = 'iniciativa_modificar';
        $this->load->view('admin/estruc/estructura', $data);        
	}

	private function do_upload($campo){
		$retorno = Array('error'=>'', 'imagen'=>'');
		if (isset($_FILES[$campo]) && is_uploaded_file($_FILES[$campo]['tmp_name'])) {
			$config['upload_path']          = './uploads/noticias/';
			$config['allowed_types']        = 'gif|jpg|jpeg|png';
			$config['max_size']             = 10000; //en kb

			$this->load->library('upload', $config);

			if (!$this->upload->do_upload($campo)){			
				$retorno['error'] = $this->upload->display_errors();
			}else{			
				$uploadData = $this->upload->data();
				$retorno['imagen'] = $uploadData['file_name'];		
				$this->processImage($config['upload_path'], $uploadData['file_name']);
			}
		}
		return $retorno;
	}

	private function processImage($directory, $image){
        $image_location = $directory . "/" . $image; 
        $thumb_destination = $directory . "/" . $image; 
        $compression_type = Imagick::COMPRESSION_JPEG; 
    
        $thumbnail = new Imagick($image_location); 

        if($thumbnail->getImageFormat()=='PNG'){  
            $thumbnail->setImageCompressionQuality(95); 
        }else{
            $thumbnail->setImageCompressionQuality(70); 
        }
        $thumbnail->stripImage();
        $thumbnail->writeImage($thumb_destination); 

        $thumbnail->thumbnailImage(null,400); 
        $thumb_destination = $directory . "/400_" . $image; 
		$thumbnail->writeImage($thumb_destination);        
    }


	public function eliminar(){
		$ideliminar = $this->input->post('ideliminar');
		$this->Iniciativa->eliminarBlando($ideliminar);
	}

	
    private function getCleanIniciativa($idiniciativa){
        if(empty($idiniciativa) || !is_numeric($idiniciativa)){
            $this->session->set_userdata('error', 'No se encontro al iniciativa con ID '.$idiniciativa);
            redirect("admin/iniciativas");
        }
        $iniciativa = $this->Iniciativa->getById($idiniciativa);
        if(empty($iniciativa)){
            $this->session->set_userdata('error', 'No se encontro al iniciativa con ID '.$idiniciativa);
            redirect("admin/iniciativas");
        }
        return $iniciativa;
    }

	public function info($idiniciativa){
		$iniciativa = $this->getCleanIniciativa($idiniciativa);
		
	}
}
?>
