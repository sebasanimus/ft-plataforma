<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mapas extends CI_Controller {

    public function __construct() {
		parent::__construct();
		$this->login->verify();

        $this->load->model('Propuesta');
		$this->load->model('Mapa');
		$this->load->model('Mapaelemento');
	}

	public function index()	{		
		header("Location: ".base_url().'admin/mapas/listar');
	}
	
	public function listar($idpropuesta){		
		//Un solo mapa por propuesta
		$idmapa = $this->Mapa->getByIdPropuesta($idpropuesta);
		if(empty($idmapa)){
			$mapa = array();
			$lenguajes = $this->Lenguaje->getHabilitados('idlenguaje', 'asc');
			$propuesta = $this->getCleanPropuesta($idpropuesta); //por tema de permisos
			
			$mapa['idpropuesta'] = Array('val'=>$idpropuesta, 'req'=>TRUE);
			
			$datas_lang = array();
			foreach($lenguajes as $lenguaje){
				$paquete_lang= array();
				$paquete_lang['nombre'] = 'mapa';
				$paquete_lang['descripcion'] = 'principal';
				$datas_lang[$lenguaje->codlang] = $paquete_lang;
			}
			            
			$idmapa = $this->Mapa->insertOrUpdate(0, $mapa);
			$this->Mapa->insertOrUpdateLanguage($idmapa, $datas_lang);
		}

		redirect("admin/mapas/editarElementos/".$idmapa);
		
		/*$data =Array();
		$data['propuesta'] = $this->getCleanPropuesta($idpropuesta);
		$data['lenguajes'] = $this->Lenguaje->getHabilitados('idlenguaje', 'asc');
		$data['libs'] = Array('datatables');
        $data['idpropuesta'] = $idpropuesta;
        $data['page'] = 'mapa_listar';
		$this->load->view('admin/estruc/estructura', $data);*/
	}
/*
	public function paginar($idpropuesta){
		if(!is_numeric($idpropuesta) || empty($idpropuesta)){
			header("Location: ".base_url().'admin/propuestas/listar');
		}
		$input['idpropuesta'] = $idpropuesta;
		$input['busqueda'] = $this->input->post('sSearch');
		$input['comienzo'] = $this->input->post('iDisplayStart');
		$input['cantidad'] = $this->input->post('iDisplayLength');	
		$input['ordenar'] = 'idmapa';
				
		$columnas[0] = 'nombre';
		$columnas[1] = 'descripcion';
		$columnas[2] = 'idmapa';
		$sort = $this->input->post('iSortCol_0');
		if(!empty($sort)){
			$input['ordenar'] = $columnas[$sort].' '.$this->input->post('sSortDir_0');
		}
		
		$output['sEcho'] = $this->input->post('sEcho');
		$output['iTotalRecords'] = $this->Mapa->getTotalRecords(); 
		$output['iTotalDisplayRecords'] = $this->Mapa->getTotalFilteredRecords($input);
		$output['aaData'] = array();
		$datos = $this->Mapa->getPaginated($input);
		foreach($datos as $dat){
			$salida = array();
			$salida[0] = $dat['nombre'];
			$salida[1] = $dat['descripcion'];
			$salida[2] = $dat['idmapa'];
			$output['aaData'][] = $salida;
		}
		//print_r($this->Mapa->getItemted($input)); exit;
		echo json_encode($output);
	}*/
/*
	public function agregarMapa(){
		
		if (!empty($_POST)){           
			$mapa = array();
			$lenguajes = $this->Lenguaje->getHabilitados('idlenguaje', 'asc');
			//print_r($this->input->post()); exit;
			$idmapa = $this->input->post('idmapa');
			$idpropuesta = $this->input->post('idpropuesta');
			$propuesta = $this->getCleanPropuesta($idpropuesta); //por tema de permisos

			if(!empty($idmapa)){ //me tengo que asegurar que el mapa a modificar corresponda a la propuesta que dice pertenecer
				$ind = $this->Mapa->getById($idmapa);
				if($ind['idpropuesta']!=$idpropuesta){
					echo 'No coinciden los datos';
					exit;
				}
			}

			$mapa['idpropuesta'] = Array('val'=>$idpropuesta, 'req'=>TRUE);
			
			$datas_lang = array();
			foreach($lenguajes as $lenguaje){
				$paquete_lang= array();
				$paquete_lang['nombre'] = $this->input->post('nombre_'.$lenguaje->codlang);
				$paquete_lang['descripcion'] = $this->input->post('descripcion_'.$lenguaje->codlang);
				$datas_lang[$lenguaje->codlang] = $paquete_lang;
			}
			            
            $result = $this->Mapa->insertOrUpdate($idmapa, $mapa);
            if($result && is_numeric($result)){				
				$this->Mapa->insertOrUpdateLanguage($result, $datas_lang);
				echo '';
				exit;
            }else{
				echo $result;
			}
		}
	}*/

	public function obtenerMapa($idpropuesta){
		$this->getCleanPropuesta($idpropuesta);  //por tema de permisos
		$mapa = $this->Mapa->obtener($idpropuesta, $this->input->post('idmapa'));
		echo json_encode($mapa);
	}

	public function eliminarMapa($idpropuesta){
		$this->getCleanPropuesta($idpropuesta);  //por tema de permisos
		$ideliminar = $this->input->post('ideliminar');
		$mapa = $this->Mapa->getById($ideliminar);
		if($mapa['idpropuesta']==$idpropuesta){
			$this->Mapa->eliminarBlando($ideliminar);
		}
	}


    private function getCleanPropuesta($idpropuesta){
        if(empty($idpropuesta) || !is_numeric($idpropuesta)){
            $this->session->set_userdata('error', 'No se encontro al propuesta con ID '.$idpropuesta);
            redirect("admin/propuestas/listar");
        }
        $propuesta = $this->Propuesta->getById($idpropuesta);
        if(empty($propuesta)){
            $this->session->set_userdata('error', 'No se encontro al propuesta con ID '.$idpropuesta);
            redirect("admin/propuestas/listar");
		}
		if(!$this->Propuesta->tengoPermiso($idpropuesta)){
			$this->session->set_userdata('error', 'No tiene permisos para modificar ese proyecto');
            redirect("admin/propuestas/listar");
		}
        return $propuesta;
	}
	
    private function getCleanMapa($idmapa){
        if(empty($idmapa) || !is_numeric($idmapa)){
            $this->session->set_userdata('error', 'No se encontro al propuesta con ID '.$idmapa);
            redirect("admin/propuestas");
        }
        $mapa = $this->Mapa->getById($idmapa);
        if(empty($mapa)){
            $this->session->set_userdata('error', 'No se encontro al propuesta con ID '.$idmapa);
            redirect("admin/propuestas");
        }
        return $mapa;
    }

    public function editarElementos($idmapa){
		$data=Array();
		$data['lenguajes'] = $this->Lenguaje->getHabilitados('idlenguaje', 'asc');
		$data['idmapa'] = $idmapa;
		$data['mapa'] = $this->getCleanMapa($idmapa);
		$data['propuesta'] = $this->getCleanPropuesta($data['mapa']['idpropuesta']);		
		$data['startingPoint'] = $this->Propuesta->getStartingPoint($data['mapa']['idpropuesta']);
		$data['libs'] = Array('jasny');
		$data['elementos'] = $this->Mapaelemento->getByMapa($idmapa);
        $data['page'] = 'mapa';
		$this->load->view('admin/estruc/estructura', $data);
    }

	
	public function guardarElementos($idmapa){
		$elementos = json_decode($this->input->post('elementos'), true);
		$lenguajes = $this->Lenguaje->getHabilitados('idlenguaje', 'asc');
		$mapa = $this->getCleanMapa($idmapa);
		$this->getCleanPropuesta($mapa['idpropuesta']);//por tema de permisos

		$idsValidos = Array();
		foreach($elementos as $elem){
			$elemento = array();
			$elemento['idmapa'] = Array('val'=>$idmapa, 'req'=>TRUE);
			$elemento['tipo'] = Array('val'=>$elem['tipo'], 'req'=>TRUE);
			$elemento['latlng'] = Array('val'=>json_encode($elem['latlng']), 'req'=>TRUE);
			$elemento['link'] = Array('val'=>$elem['link'], 'req'=>FALSE);
			$elemento['esppal'] = Array('val'=>$elem['esppal'], 'req'=>FALSE);
			$elemento['foto'] = Array('val'=>$elem['foto'], 'req'=>FALSE);
			$idelemento = empty($elem['idelemento'])? 0 : $elem['idelemento'];
			$datas_lang = array();
			foreach($lenguajes as $lenguaje){
				$paquete_lang= array();
				$paquete_lang['nombre'] = $elem['nombre_'.$lenguaje->codlang];
				$paquete_lang['descripcion'] = $elem['descripcion_'.$lenguaje->codlang];
				$datas_lang[$lenguaje->codlang] = $paquete_lang;
			}
			
			$result = $this->Mapaelemento->insertOrUpdate($idelemento, $elemento);
            if($result && is_numeric($result)){	
				$idsValidos[] = $result;			
				$this->Mapaelemento->insertOrUpdateLanguage($result, $datas_lang);
				continue;
            }else{
				echo $result;
			}
		}
		$this->Mapaelemento->eliminarEliminados($idmapa, $idsValidos);
	}

	public function adjuntar(){
		$retUpload =$this->do_upload('file');
		if(!empty($retUpload['imagen'])){
			echo '***'.$this->input->post('idlocal').'***'.$retUpload['imagen'].'***';
		}else{
			echo 'Error: '.$retUpload['error'];
		}		
	}

	private function do_upload($campo){
		$retorno = Array('error'=>'', 'imagen'=>'');
		if (isset($_FILES[$campo]) && is_uploaded_file($_FILES[$campo]['tmp_name'])) {
			$config['upload_path']          = './uploads/mapas/';
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
}
?>
