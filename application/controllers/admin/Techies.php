<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Techies extends CI_Controller {

    public function __construct() {
		parent::__construct();
		$this->login->verify();

        $this->load->model('Webstory');
        $this->load->model('Tech');
	}

	public function index()	{		
		header("Location: ".base_url().'admin/techies/listar');
	}
	
    public function listar(){
		$data['libs'] = Array('datatables', 'select2');
        $data['page'] = 'tech_listar';
		$this->load->view('admin/estruc/estructura', $data);
    }

	public function paginar(){
		$input['busqueda'] = $this->input->post('sSearch');
		$input['comienzo'] = $this->input->post('iDisplayStart');
		$input['cantidad'] = $this->input->post('iDisplayLength');	
		$input['ordenar'] = 'idwebstory';
				
		$columnas[0] = 'titulo_simple';
		$columnas[1] = 'titulo';
		$columnas[2] = 'tech_titulo';
		$columnas[3] = 'tech_habilitado';
		$columnas[4] = 'idtech';
		$sort = $this->input->post('iSortCol_0');
		$input['ordenar'] = $columnas[$sort].' '.$this->input->post('sSortDir_0');
		
		$output['sEcho'] = $this->input->post('sEcho');
		$output['iTotalRecords'] = $this->Tech->getTotalRecords(); 
		$output['iTotalDisplayRecords'] = $this->Tech->getTotalFilteredRecords($input);
		$output['aaData'] = array();
		$datos = $this->Tech->getPaginated($input);
		foreach($datos as $dat){
			$salida = array();
			$salida[0] = $dat['titulo_simple'].'**'.$dat['identificador'];
			$salida[1] = $dat['titulo'].'**'.$dat['url'];
			$salida[2] = $dat['tech_titulo'];
			$salida[3] = $dat['tech_habilitado'];
			$salida[4] = $dat['idtech'];
			$output['aaData'][] = $salida;
		}
		echo json_encode($output);
	}
	
	public function agregarTech(){
		$idpropuesta = $this->input->post('idpropuesta');
		$this->load->model('Propuesta');
		$propuesta = $this->Propuesta->getById($idpropuesta);
		if(empty($propuesta) || !$this->Propuesta->tengoPermiso($idpropuesta)){
			echo 'No se encuentra la propuesta';
			exit;
		}
		$idwebstory = $this->input->post('idwebstory');
		$ws = $this->Webstory->getById($idwebstory);
		if(empty($ws)){ //La webstory no existe y hay que crearla con los datos minimos
			$webstory = array();
			$lenguajes = $this->Lenguaje->getHabilitados('idlenguaje', 'asc');
			$webstory['habilitado'] = Array('val'=>0, 'req'=>FALSE);
			$webstory['url'] = Array('val'=>'propuesta_'.$idpropuesta, 'req'=>TRUE);
			$webstory['idpropuesta'] = Array('val'=>$idpropuesta, 'req'=>TRUE);
			$datas_lang = array();
			foreach($lenguajes as $lenguaje){
				$paquete_lang= array();
				$paquete_lang['titulo'] = $propuesta['titulo_simple'];
				$datas_lang[$lenguaje->codlang] = $paquete_lang;
			}
			$result = $this->Webstory->insertOrUpdate(0, $webstory);
            if($result && is_numeric($result)){				
				$this->Webstory->insertOrUpdateLanguage($result, $datas_lang);
				$idwebstory = $result;
            }else{
                echo 'Error al crear el Webstory: '.$webstory;
				exit;
            }
		}

		$this->getCleanWebstory($idwebstory);//permisos
		$idtech = $this->Tech->getByIdWebstory($idwebstory);
		if(empty($idtech)){ // El tech todavia no existe
			$tech = Array();
			$tech['idwebstory'] = Array('val'=>$idwebstory, 'req'=>TRUE);
			$tech['habilitado'] = Array('val'=>0, 'req'=>FALSE);
			$result = $this->Tech->insertOrUpdate(0, $tech);
            if($result && is_numeric($result)){				
				$idtech = $result;
			}else{
				echo 'Error al crear el Tech: '.$result;
				exit;
            }
		}
		echo $idtech;
	}

    public function ver($idtech){
		$tech = $this->Tech->getById($idtech);
		if(empty($tech)){
			redirect("admin/techies/listar");
		}
		$tech['habilitado'] = $tech['tech_habilitado'];
		$idwebstory = $tech['idwebstory'];
		$this->getCleanWebstory($idwebstory);//permisos
		$data['tech'] = $tech;
		$data['lenguajes'] = $this->Lenguaje->getHabilitados('idlenguaje', 'asc');
		$data['datas_lang'] = array();
        $data['idwebstory'] = $idwebstory;
        $data['webstory'] = array();
        $this->load->helper('form');
		if (!empty($_POST)){        
			$tech = array();
			$webstory = array();
			
			$publica_inv = (isset($_POST['publica_inv']) && $_POST['publica_inv']=='on')? 1 : 0;
			$habilitado = (isset($_POST['habilitado']) && $_POST['habilitado']=='on')? 1 : 0;
			if($this->session->userdata('role')==4){
				$webstory['publica_inv'] = Array('val'=>$publica_inv, 'req'=>FALSE);
				if(empty($idtech)){ //si es inv y recien estra creando la webstory, aparece despublicada
					$tech['habilitado'] = Array('val'=>0, 'req'=>FALSE);
				}
			}else{
				$tech['habilitado'] = Array('val'=>$habilitado, 'req'=>FALSE);
			}
			
					
			$retUpload = $this->do_upload('foto_principal');
			if(!empty($retUpload['imagen'])){
				$webstory['foto_principal'] = Array('val'=>$retUpload['imagen'], 'req'=>FALSE);
			}	
					
			$datas_lang = array();
			foreach($data['lenguajes'] as $lenguaje){
				$paquete_lang= array();
				$paquete_lang['tech_titulo'] = $this->input->post('tech_titulo_'.$lenguaje->codlang);

				$paquete_lang['tech_solucion'] = $this->input->post('tech_solucion_'.$lenguaje->codlang);
				$paquete_lang['tech_descripcion'] = $this->input->post('tech_descripcion_'.$lenguaje->codlang);
				$paquete_lang['tech_resultados'] = $this->input->post('tech_resultados_'.$lenguaje->codlang);
				
				$datas_lang[$lenguaje->codlang] = $paquete_lang;
			}
			            
			$result = $this->Tech->insertOrUpdate($idtech, $tech);
			if(!empty($webstory)){
				$this->Webstory->insertOrUpdate($idwebstory, $webstory);
			}
            if($result && is_numeric($result)){				
				$this->Webstory->insertOrUpdateLanguage($idwebstory, $datas_lang);
				if($this->session->userdata('role')==4 && $publica_inv){
					$this->load->library('Utilidades');
					$this->utilidades->crearAlerta('Tech: '.substr($datas_lang['es']['tech_titulo'], 0, 25).'...', 'Se encuentra pendiente de moderación el tech: '.$datas_lang['es']['tech_titulo'], base_url().'admin/techies/ver/'.$result, 'contenidos');
				}
                redirect("admin/techies/ver/".$result);
            }else{
                $data['error'] = $result;
            }
        }else{
            if(!empty($idwebstory)){
                $webstory = $this->getCleanWebstory($idwebstory);                
				$data['webstory'] = $webstory;

				$datas_lang = array();
				$paqueteLang = $this->Webstory->getLanguages($idwebstory);
				foreach($paqueteLang as $pl){
					$datas_lang[$pl['codlang']] = $pl;
				}
				$data['datas_lang'] = $datas_lang;
				
				$this->load->model('Propuesta');
				$data['propuesta'] = $this->Propuesta->getById($webstory['idpropuesta']);

				$data['readonly'] = FALSE; 
            }
		}
		//$this->load->model('Adjunto');
		//$data['tipoadjuntos'] =  $this->Adjunto->getTipos('webstory');
		$this->load->model('Pais');
		$data['paises'] = $this->Pais->getAllView('nombre', 'asc');	

		$this->load->model('Badge');
		$data['badges'] = $this->Badge->getAllView();
		$data['badgesObtenidas'] = $this->Badge->getByWebstory($idwebstory);
		$data['libs'] = Array('datatables', 'select2', 'jasny', 'imagepicker', 'iconsvgpicker', 'summernote');
        $data['page'] = 'tech_modificar';
        $this->load->view('admin/estruc/estructura', $data);        
	}

	private function do_upload($campo) {
		$retorno = Array('error'=>'', 'imagen'=>'');
		if (isset($_FILES[$campo]) && is_uploaded_file($_FILES[$campo]['tmp_name'])) {
			$config['upload_path']          = './uploads/webstories/';
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

    private function getCleanWebstory($idwebstory){
        if(empty($idwebstory) || !is_numeric($idwebstory)){
            $this->session->set_userdata('error', 'No se encontro al webstory con ID '.$idwebstory);
            redirect("admin/techies");
        }
        $webstory = $this->Webstory->getById($idwebstory);
        if(empty($webstory)){
            $this->session->set_userdata('error', 'No se encontro al webstory con ID '.$idwebstory);
            redirect("admin/techies");
        }
		if(!$this->Webstory->tengoPermiso($webstory['idpropuesta'])){
			$this->session->set_userdata('error', 'No tiene permisos para modificar ese proyecto');
            redirect("admin/webstories/listar");
		}
        return $webstory;
    }


    public function eliminar(){
        $ideliminar = $_POST['ideliminar'];
        $this->Tech->eliminarBlando($ideliminar);
	}


	function selectWS($idpropuesta, $search=''){
		if(!is_numeric($idpropuesta)){
			exit;
		}
		$search = $search=='undefined'? '':$search;
		$retorno = array('results'=>array());
		$retorno['pagination'] = array('more'=>false);
		
		$propuestas = $this->Webstory->buscarSelectPropuesta($idpropuesta,$search);

		$retorno['results'] = array_merge(Array(Array('id'=>0, 'text'=>'Nuevo')), $propuestas);
		
		echo json_encode($retorno);
	}
		
}
?>
