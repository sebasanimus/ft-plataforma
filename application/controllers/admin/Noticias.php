<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Noticias extends CI_Controller {

    public function __construct() {
		parent::__construct();
		$this->login->verify();

        $this->load->model('Propuesta');
		$this->load->model('Noticia');
	}

	public function index()	{		
		header("Location: ".base_url().'admin/noticias/listar');
	}
	
	public function listar($idpropuesta=0){
		$data =Array();
		if($this->session->userdata('role')!=1 || !empty($idpropuesta)){
			$data['propuesta'] = $this->getCleanPropuesta($idpropuesta);
		}
		$data['lenguajes'] = $this->Lenguaje->getHabilitados('idlenguaje', 'asc');
		$data['libs'] = Array('datatables');
        $data['idpropuesta'] = $idpropuesta;
        $data['page'] = 'noticia_listar';
		$this->load->view('admin/estruc/estructura', $data);
	}

	public function paginar($idpropuesta=0){
		
		if($this->session->userdata('role')!=1 || !empty($idpropuesta)){
			$this->getCleanPropuesta($idpropuesta);  //por tema de permisos
		}
		$input['idpropuesta'] = $idpropuesta;
		$input['busqueda'] = $this->input->post('sSearch');
		$input['comienzo'] = $this->input->post('iDisplayStart');
		$input['cantidad'] = $this->input->post('iDisplayLength');	
		$input['ordenar'] = 'idnoticia';
				
		$columnas[0] = 'idnoticia';
		$columnas[1] = 'titulo';
		$columnas[2] = 'publicada';
		$columnas[3] = 'hasta';
		$columnas[4] = 'actualmente_publicada';
		$columnas[5] = 'url';
		$columnas[6] = 'aprobada_admin';
		$columnas[7] = 'idtiponoticia';
		$columnas[8] = 'idnoticia';
		$sort = $this->input->post('iSortCol_0');
		if(!empty($sort)){
			$input['ordenar'] = $columnas[$sort].' '.$this->input->post('sSortDir_0');
		}
		
		$output['sEcho'] = $this->input->post('sEcho');
		$output['iTotalRecords'] = $this->Noticia->getTotalRecords(); 
		$output['iTotalDisplayRecords'] = $this->Noticia->getTotalFilteredRecords($input);
		$output['aaData'] = array();
		$datos = $this->Noticia->getPaginated($input);
		foreach($datos as $dat){
			$salida = array();
			$salida[0] = $dat['foto'];
			$salida[1] = $dat['titulo'].'<br/><small>'.$dat['identificador'].'</small>';
			$salida[2] = fromYYYYMMDDtoDDMMYYY($dat['publicada'], false);
			$salida[3] = fromYYYYMMDDtoDDMMYYY($dat['hasta'], false);
			$salida[4] = $dat['actualmente_publicada'];
			$salida[5] = $dat['url'];
			$salida[6] = $dat['aprobada_admin'];
			$salida[7] = $dat['idtiponoticia'];
			$salida[8] = $dat['idnoticia'].'***'.$dat['idpropuesta'];
			$output['aaData'][] = $salida;
		}
		//print_r($this->Noticia->getItemted($input)); exit;
		echo json_encode($output);
	}

	public function modificar($idpropuesta, $idnoticia=0){
		if(!is_numeric($idpropuesta) || empty($idpropuesta)){
			header("Location: ".base_url().'admin/propuestas/listar');
		}
		$data['propuesta'] =$this->getCleanPropuesta($idpropuesta);  //por tema de permisos
		$data['idpropuesta'] = $idpropuesta;
		$data['lenguajes'] = $this->Lenguaje->getHabilitados('idlenguaje', 'asc');
		$data['datas_lang'] = array();
        $data['idnoticia'] = $idnoticia;
        $data['noticia'] = array();
        $this->load->helper('form');
		if (!empty($_POST)){           
			$noticia = array();
			
			$noticia['idpropuesta'] = Array('val'=>$idpropuesta, 'req'=>TRUE);
			$noticia['idusuario'] = Array('val'=>$this->session->userdata('idusuario'), 'req'=>TRUE);	
			$noticia['publicada'] = Array('val'=>fromDDMMYYYtoYYYYMMDD($this->input->post('publicada'), false), 'req'=>FALSE);		
			$noticia['hasta'] = Array('val'=>fromDDMMYYYtoYYYYMMDD($this->input->post('hasta'), false), 'req'=>FALSE);
			$noticia['idtiponoticia'] = Array('val'=>$this->input->post('idtiponoticia'), 'req'=>TRUE);	

			$publica_inv = (isset($_POST['publica_inv']) && $_POST['publica_inv']=='on')? 1 : 0;
			$aprobada_admin = (isset($_POST['aprobada_admin']) && $_POST['aprobada_admin']=='on')? 1 : 0;
			if($this->session->userdata('role')==4){
				$noticia['publica_inv'] = Array('val'=>$publica_inv, 'req'=>FALSE);
				if(empty($idnoticia)){ //si es inv y recien estra creando la noticia, aparece despublicada
					$noticia['aprobada_admin'] = Array('val'=>0, 'req'=>FALSE);
				}
			}else{
				$noticia['aprobada_admin'] = Array('val'=>$aprobada_admin, 'req'=>FALSE);
			}

			$retUpload = $this->do_upload('foto');
			if(!empty($retUpload['imagen'])){
				$noticia['foto'] = Array('val'=>$retUpload['imagen'], 'req'=>FALSE);
			}
			//print_r($noticia['publicada']); exit;
			
			$datas_lang = array();
			foreach($data['lenguajes'] as $lenguaje){
				$paquete_lang= array();
				$paquete_lang['titulo'] = $this->input->post('titulo_'.$lenguaje->codlang);
				$paquete_lang['contenido'] = $this->input->post('contenido_'.$lenguaje->codlang);
				$paquete_lang['bajada'] = $this->input->post('bajada_'.$lenguaje->codlang);
				$paquete_lang['url'] = toURLFriendly($paquete_lang['titulo']);
				$datas_lang[$lenguaje->codlang] = $paquete_lang;
			}
			            
            $result = $this->Noticia->insertOrUpdate($idnoticia, $noticia);
            if($result && is_numeric($result)){			
				$this->Noticia->insertOrUpdateLanguage($result, $datas_lang);
				if($this->session->userdata('role')==4 && $publica_inv){
					$this->load->library('Utilidades');
					$this->utilidades->crearAlerta('Noticia: '.substr($datas_lang['es']['titulo'], 0, 25).'...', 'Se encuentra pendiente de moderación la noticia: '.$datas_lang['es']['titulo'], base_url().'admin/noticias/modificar/'.$idpropuesta.'/'.$result, 'contenidos');
				}
                redirect("admin/noticias/listar/".$idpropuesta);
            }else{
                $data['error'] = $result;
                $data['noticia'] = $this->Noticia->getValores($noticia);
            }
        }else{
            if(!empty($idnoticia)){
                $noticia = $this->getCleanNoticia($idnoticia);
                if(empty($noticia)){
                    $data['error'] = 'No se encontro al noticia con ID '.$idnoticia;
                }else{
					$data['noticia'] = $noticia;
					$datas_lang = array();
					$paqueteLang = $this->Noticia->getLanguages($idnoticia);
					foreach($paqueteLang as $pl){
						$datas_lang[$pl['codlang']] = $pl;
					}
					$data['datas_lang'] = $datas_lang;
                }
            }
		}		
		if(!empty($data['noticia'])){
			$data['noticia']['publicada'] = fromYYYYMMDDtoDDMMYYY($data['noticia']['publicada'], false);
			$data['noticia']['hasta'] = fromYYYYMMDDtoDDMMYYY($data['noticia']['hasta'], false);
		}else{
			$data['noticia']['publicada'] = date("d/m/Y 00:00");
			$data['noticia']['idtiponoticia'] = 1;
			$data['noticia']['publica_inv'] = true;
			$data['noticia']['aprobada_admin'] = true;
		}
		$data['tiposnoticia'] = Array(Array('id'=>1, 'nombre'=>'Noticia'), Array('id'=>2, 'nombre'=>'Blog'));
		$data['libs'] = Array('jasny', 'tinymce', 'datetimepicker');
        $data['page'] = 'noticia_modificar';
        $this->load->view('admin/estruc/estructura', $data);        
	}


	public function eliminar($idpropuesta){
		$this->getCleanPropuesta($idpropuesta);  //por tema de permisos
		$ideliminar = $this->input->post('ideliminar');
		$noticia = $this->Noticia->getById($ideliminar);
		if($noticia['idpropuesta']==$idpropuesta){
			$this->Noticia->eliminarBlando($ideliminar);
		}
	}


    private function getCleanPropuesta($idpropuesta){
        if(empty($idpropuesta) || !is_numeric($idpropuesta)){
            $this->session->set_userdata('error', 'No se encontro al propuesta con ID '.$idpropuesta);
            redirect("admin/propuestas");
        }
        $propuesta = $this->Propuesta->getById($idpropuesta);
        if(empty($propuesta)){
            $this->session->set_userdata('error', 'No se encontro al propuesta con ID '.$idpropuesta);
            redirect("admin/propuestas");
        }
		if(!$this->Propuesta->tengoPermiso($idpropuesta)){
			$this->session->set_userdata('error', 'No tiene permisos para modificar ese proyecto');
            redirect("admin/propuestas/listar");
		}
        return $propuesta;
	}
	
    private function getCleanNoticia($idnoticia){
        if(empty($idnoticia) || !is_numeric($idnoticia)){
            $this->session->set_userdata('error', 'No se encontro al propuesta con ID '.$idnoticia);
            redirect("admin/propuestas");
        }
        $noticia = $this->Noticia->getById($idnoticia);
        if(empty($noticia)){
            $this->session->set_userdata('error', 'No se encontro al propuesta con ID '.$idnoticia);
            redirect("admin/propuestas");
        }
        return $noticia;
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
}
?>
