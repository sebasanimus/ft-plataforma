<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Adjuntos extends CI_Controller {

    public function __construct() {
		parent::__construct();
		$this->login->verify();

		$this->load->model('Adjunto');
	}

	public function index()	{		
		header("Location: ".base_url().'admin/webstories/listar');
	}
	
    public function obtener($modo, $idmodelo){
		$this->cargarModeloCorrecto($modo);
		$this->getClean($idmodelo);
		$adjunto = $this->Adjunto->obtener($this->input->post('idadjunto'));
		echo json_encode($adjunto);
	}

	public function paginar($modo, $idmodelo){
		$this->cargarModeloCorrecto($modo);
		$this->getClean($idmodelo);

		$input['busqueda'] = $this->input->post('sSearch');
		$input['comienzo'] = $this->input->post('iDisplayStart');
		$input['cantidad'] = $this->input->post('iDisplayLength');	
		$input['ordenar'] = 'idadjunto';
		$input['idmodelo'] = $idmodelo;
		$input['modelo'] = ($modo=='webstory')? 'webstory' : 'propuesta';
				
		$columnas[0] = 'archivo';
		$columnas[1] = 'tipo';
		$columnas[2] = 'nombre';
		$columnas[3] = 'orden';
		$columnas[4] = 'habilitado';
		$columnas[5] = 'idadjunto';
		$sort = $this->input->post('iSortCol_0');
		if(!empty($sort)){
			$input['ordenar'] = $columnas[$sort].' '.$this->input->post('sSortDir_0');
		}
		
		$output['sEcho'] = $this->input->post('sEcho');
		$output['iTotalRecords'] = $this->Adjunto->getTotalRecords(); 
		$output['iTotalDisplayRecords'] = $this->Adjunto->getTotalFilteredRecords($input);
		$output['aaData'] = array();
		$datos = $this->Adjunto->getPaginated($input);
		foreach($datos as $dat){
			$salida = array();
			$salida[0] = $dat['archivo'].'**'.$dat['idtipo'].'**'.$dat['urlold'];
			$salida[1] = $dat['tipo'];
			$salida[2] = $dat['nombre'];
			$salida[3] = $dat['orden'];
			$salida[4] = $dat['habilitado'];
			$salida[5] = $dat['idadjunto'];
			$output['aaData'][] = $salida;
		}
		echo json_encode($output);
	}
	
	private function cargarModeloCorrecto($modo){
		if($modo=='webstory'){
			$this->load->model('Webstory', 'Modelo');
		}else{
			$this->load->model('Propuesta', 'Modelo');
		}
	}

	public function adjuntar($modo='webstory', $idadjunto=0){
		$this->cargarModeloCorrecto($modo);

		$data['lenguajes'] = $this->Lenguaje->getHabilitados('idlenguaje', 'asc');

		if (!empty($_POST)){
			$adjunto = array();
			$idmodelo = $this->input->post('idmodelo');  
			$this->getClean($idmodelo);

			if(!empty($idadjunto)){ //TODO me tengo que asegurar que el adjunto a modificar corresponda al webstory que dice pertenecer
				/*$adj = $this->Adjunto->getById($idadjunto);
				if($adj[$this->Modelo->idname]!=$idmodelo){
					echo 'No coinciden los datos';
					exit;
				}*/
			}

			$adjunto['orden'] = Array('val'=>$this->input->post('orden'), 'req'=>FALSE);
			$adjunto['fecha'] = Array('val'=>$this->input->post('fecha'), 'req'=>FALSE);
			$adjunto['autor'] = Array('val'=>$this->input->post('autor'), 'req'=>FALSE);
			$adjunto['urlold'] = Array('val'=>$this->input->post('urlold'), 'req'=>FALSE);
			$adjunto['idtipo'] = Array('val'=>$this->input->post('idtipo'), 'req'=>TRUE);
			$habilitado = (isset($_POST['habilitado']))? $_POST['habilitado'] : 0;
			if($modo=='propuesta'){
				if($this->session->userdata('role')==4){
					if(empty($idadjunto)){ //si es inv en propuesta y recien estra creando el adjunto, aparece despublicado
						$adjunto['habilitado'] = Array('val'=>0, 'req'=>FALSE);
					}
				}else{
					$adjunto['habilitado'] = Array('val'=>$habilitado, 'req'=>FALSE);
				}
			}

			$link = $this->input->post('link');
			if(!empty($link)) $adjunto['link'] = Array('val'=>$link, 'req'=>TRUE);

			$retUpload = ($adjunto['idtipo']['val']==1 || $adjunto['idtipo']['val']==3 || $adjunto['idtipo']['val']==4) ? $this->do_upload('file') : $this->do_upload_file('file');
			if(!empty($retUpload['imagen'])){
				$adjunto['archivo'] = Array('val'=>$retUpload['imagen'], 'req'=>FALSE);
			}else if(empty($idadjunto) && empty($adjunto['urlold']['val'])){
				echo 'Debe seleccionar un archivo';
				exit;
			}	

			$datas_lang = array();
			foreach($data['lenguajes'] as $lenguaje){
				$paquete_lang= array();
				$paquete_lang['nombre'] = $this->input->post('nombre_'.$lenguaje->codlang);
				$paquete_lang['taller'] = $this->input->post('taller_'.$lenguaje->codlang);
				$paquete_lang['lugar'] = $this->input->post('lugar_'.$lenguaje->codlang);

				$descripcion = $this->input->post('descripcion_'.$lenguaje->codlang);
				if(!empty($descripcion)) $paquete_lang['descripcion'] = $descripcion; 

				$datas_lang[$lenguaje->codlang] = $paquete_lang;
			}

			$result = $this->Adjunto->insertOrUpdate($idadjunto, $adjunto);
            if($result && is_numeric($result)){				
				$this->Adjunto->insertOrUpdateLanguage($result, $datas_lang);
				if(empty($idadjunto)){
					$this->Modelo->insertarAdjunto($result, $idmodelo);
					if($this->session->userdata('role')==4 && $modo=='propuesta'){
						$this->load->library('Utilidades');
						$this->utilidades->crearAlerta('Adjunto pendiente de moderación', 'Se encuentra pendiente de moderación el adjunto: '.$datas_lang['es']['nombre'], base_url().'admin/propuestas/ver/'.$idmodelo, 'contenidos');
					}
				}
				echo 'ok';
				if(!empty($adjunto['archivo'])) echo '***'.$adjunto['archivo']['val'].'***';
				exit;
            }else{
				echo $result;   
				exit;            
            }			            
		}
		echo '';		
	}

	private function do_upload($campo) {
		$retorno = Array('error'=>'', 'imagen'=>'');
		if (isset($_FILES[$campo]) && is_uploaded_file($_FILES[$campo]['tmp_name'])) {
			$config['upload_path']          = './uploads/adjuntos/';
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
	
	private function do_upload_file($campo, $allowed='*') {
		$retorno = Array('error'=>'', 'imagen'=>'');
		if (isset($_FILES[$campo]) && is_uploaded_file($_FILES[$campo]['tmp_name'])) {
			$config['upload_path']          = './uploads/adjuntos/';
			$config['allowed_types']        = $allowed;
			$config['max_size']             = 100000; //en kb

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

    private function getClean($idmodelo){
        if(empty($idmodelo) || !is_numeric($idmodelo)){
            $this->session->set_userdata('error', 'No se encontro al con ID '.$idmodelo);
            redirect("admin/webstories");
        }
        $webstory = $this->Modelo->getById($idmodelo);
        if(empty($webstory)){
            $this->session->set_userdata('error', 'No se encontro al con ID '.$idmodelo);
            redirect("admin/webstories");
		}
		if(!$this->Modelo->tengoPermiso($webstory['idpropuesta'])){
			$this->session->set_userdata('error', 'No tiene permisos para modificar ese proyecto');
            redirect("admin/propuestas/listar");
		}
        return $webstory;
    }


    public function eliminar($modo, $idmodelo){
		$this->cargarModeloCorrecto($modo);
		$this->getClean($idmodelo);
		$ideliminar = $this->input->post('ideliminar');
		$adjunto = $this->Adjunto->getById($ideliminar);
		$this->Modelo->eliminarAdjunto($ideliminar, $idmodelo);		
	}
	

}
?>
