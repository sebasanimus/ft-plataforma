<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Propuestas extends CI_Controller {

    public function __construct() {
		parent::__construct();
		$this->login->verify();

        $this->load->model('Propuesta');
	}

	public function index()	{		
		header("Location: ".base_url().'admin/propuestas/listar');
	}
	
    public function listar(){
		$data['libs'] = Array('datatables');
        $data['page'] = 'propuesta_listar';
		$this->load->view('admin/estruc/estructura', $data);
    }


	public function paginar(){
		$input['busqueda'] = $this->input->post('sSearch');
		$input['comienzo'] = $this->input->post('iDisplayStart');
		$input['cantidad'] = $this->input->post('iDisplayLength');	
		$input['ordenar'] = 'idpropuesta';
				
		$columnas[0] = 'identificador';
		$columnas[1] = 'anio';
		$columnas[2] = 'titulo_simple';
		$columnas[3] = 'sector_productivo';
		$columnas[4] = 'elestado';
		$columnas[5] = 'web_publicado';
		$columnas[6] = 'total';
		$columnas[7] = 'idpropuesta';
		$sort = $this->input->post('iSortCol_0');
		if(!empty($sort)){
			$input['ordenar'] = $columnas[$sort].' '.$this->input->post('sSortDir_0');
		}
		
		$output['sEcho'] = $this->input->post('sEcho');
		$output['iTotalRecords'] = $this->Propuesta->getTotalRecords(); 
		$output['iTotalDisplayRecords'] = $this->Propuesta->getTotalFilteredRecords($input);
		$output['aaData'] = array();
		$datos = $this->Propuesta->getPaginated($input);
		foreach($datos as $dat){
			$salida = array();
			$salida[0] = $dat['identificador'];
			$salida[1] = $dat['anio'];
			$salida[2] = $dat['titulo_simple'];
			$salida[3] = $dat['sector_productivo'];
			$salida[4] = $dat['elestado'];
			$salida[5] = $dat['web_publicado'];
			$salida[6] = '$ '.number_format($dat['total'],0);
			$salida[7] = $dat['idpropuesta'];
			$output['aaData'][] = $salida;
		}
		echo json_encode($output);
	}
	

    public function ver($idpropuesta=0){
		$data['lenguajes'] = $this->Lenguaje->getHabilitados('idlenguaje', 'asc');
		$data['datas_lang'] = array();
        $data['idpropuesta'] = $idpropuesta;
        $data['propuesta'] = array();
        $this->load->helper('form');
		if (!empty($_POST)){           
			$propuesta = array();
			$propuesta['identificador'] = Array('val'=>str_replace(' ', '',$this->input->post('identificador')), 'req'=>TRUE);
			$propuesta['anio'] = Array('val'=>$this->input->post('anio'), 'req'=>TRUE);
			
			$propuesta['idperfil'] = Array('val'=>$this->input->post('idperfil'), 'req'=>FALSE);	

			$propuesta['estado'] = Array('val'=>$this->input->post('estado'), 'req'=>TRUE);						
			$propuesta['operacion'] = Array('val'=>$this->input->post('operacion'), 'req'=>TRUE);						
			$propuesta['linea_estrategica'] = Array('val'=>$this->input->post('linea_estrategica'), 'req'=>TRUE);						
			$propuesta['tipo_investigacion'] = Array('val'=>$this->input->post('tipo_investigacion'), 'req'=>TRUE);					
			$propuesta['tipo_innovacion'] = Array('val'=>$this->input->post('tipo_innovacion'), 'req'=>TRUE);				
			$propuesta['solucion_tecnologica'] = Array('val'=>$this->input->post('solucion_tecnologica'), 'req'=>TRUE);
			//$propuesta['idrubro'] = Array('val'=>$this->input->post('idrubro'), 'req'=>TRUE);
			//$propuesta['idareainvestigacion'] = Array('val'=>$this->input->post('idareainvestigacion'), 'req'=>TRUE);
			$propuesta['plazo'] = Array('val'=>$this->solo_numeros($this->input->post('plazo')), 'req'=>FALSE);

			/*$propuesta['aporte_fontagro'] = Array('val'=>$this->solo_numeros($this->input->post('aporte_fontagro')), 'req'=>FALSE);
			$propuesta['aporte_bid'] = Array('val'=>$this->solo_numeros($this->input->post('aporte_bid')), 'req'=>FALSE);
			$propuesta['movilizacion_agencias'] = Array('val'=>$this->solo_numeros($this->input->post('movilizacion_agencias')), 'req'=>FALSE);
			$propuesta['aporte_contrapartida'] = Array('val'=>$this->solo_numeros($this->input->post('aporte_contrapartida')), 'req'=>FALSE);
			$propuesta['aporte_agencias'] = Array('val'=>$this->solo_numeros($this->input->post('aporte_agencias')), 'req'=>FALSE);
			$total = $propuesta['aporte_fontagro']['val'] + 
						$propuesta['aporte_bid']['val'] + 
						$propuesta['movilizacion_agencias']['val'] + 
						$propuesta['aporte_contrapartida']['val'] + 
						$propuesta['aporte_agencias']['val'];
			$propuesta['total'] = Array('val'=>$total, 'req'=>FALSE);*/
				
			$propuesta['urlvieja'] = Array('val'=>$this->input->post('urlvieja'), 'req'=>FALSE);
			$propuesta['web_url'] = Array('val'=>$this->input->post('web_url'), 'req'=>FALSE);
			if(!empty($_POST['web_foto_delete'])){
				$propuesta['web_foto'] = Array('val'=>NULL, 'req'=>FALSE);
			}
			$retUpload = $this->do_upload('web_foto');
			if(!empty($retUpload['imagen'])){
				$propuesta['web_foto'] = Array('val'=>$retUpload['imagen'], 'req'=>FALSE);
			}	
			$habilitado = (isset($_POST['web_publicado']) && $_POST['web_publicado']=='on')? 1 : 0;
			$propuesta['web_publicado'] = Array('val'=>$habilitado, 'req'=>FALSE);
			
			$datas_lang = array();
			foreach($data['lenguajes'] as $lenguaje){
				$paquete_lang= array();
				$paquete_lang['titulo_completo'] = $this->input->post('titulo_completo_'.$lenguaje->codlang);
				$paquete_lang['titulo_simple'] = $this->input->post('titulo_simple_'.$lenguaje->codlang);
				$paquete_lang['otras_agencias'] = $this->input->post('otras_agencias_'.$lenguaje->codlang);
				$paquete_lang['plataforma'] = $this->input->post('plataforma_'.$lenguaje->codlang);

				$paquete_lang['web_impacto'] = $this->input->post('web_impacto_'.$lenguaje->codlang);
				$paquete_lang['web_beneficiarios'] = $this->input->post('web_beneficiarios_'.$lenguaje->codlang);
				$paquete_lang['web_solucion'] = $this->input->post('web_solucion_'.$lenguaje->codlang);
				$paquete_lang['web_resumen'] = $this->input->post('web_resumen_'.$lenguaje->codlang);
				$datas_lang[$lenguaje->codlang] = $paquete_lang;
			}
			            
            $result = $this->Propuesta->insertOrUpdate($idpropuesta, $propuesta);
            if($result && is_numeric($result)){		
				$this->load->model('Tema');
				$this->Tema->actualizarPropuesta($result, $this->input->post('idtemas'));	
				$this->load->model('Sector');
				$this->Sector->actualizarPropuesta($idpropuesta, $this->input->post('idsectores'));	
				$this->load->model('Subsector');			
				$this->Subsector->actualizarPropuesta($idpropuesta, $this->input->post('idsubsectores'));		
				$this->Propuesta->insertOrUpdateLanguage($result, $datas_lang);
                redirect("admin/propuestas/ver/".$result);
            }else{
                $data['error'] = $result;
                $data['propuesta'] = $this->Propuesta->getValores($propuesta);
            }
        }else{
            if(!empty($idpropuesta)){
				$propuesta = $this->getCleanPropuesta($idpropuesta);  				            
				$data['propuesta'] = $propuesta;
				if(!empty($propuesta['idperfil'])){
					$this->load->model('Perfil');
					$data['perfil'] = $this->Perfil->getById($propuesta['idperfil']);
				}

				$datas_lang = array();
				$paqueteLang = $this->Propuesta->getLanguages($idpropuesta);
				foreach($paqueteLang as $pl){
					$datas_lang[$pl['codlang']] = $pl;
				}
				$data['datas_lang'] = $datas_lang;
				
				if(empty($data['propuesta']['web_url'])){
					$data['propuesta']['web_url'] = toURLFriendly($data['datas_lang']['es']['titulo_simple']);
				}  
                $data['readonly'] = true;
            }
		}
		$this->load->model('Estado');
		$data['estado'] = $this->Estado->getAllView();
		$this->load->model('Operacion');
		$data['operacion'] = $this->Operacion->getAllView('nombre', 'asc');
		$this->load->model('Estrategica');
		$data['linea_estrategica'] = $this->Estrategica->getAllView('nombre', 'asc');
		$this->load->model('Investigacion');
		$data['tipo_investigacion'] = $this->Investigacion->getAllView('nombre', 'asc');
		$this->load->model('Innovacion');
		$data['tipo_innovacion'] = $this->Innovacion->getAllView('nombre', 'asc');
		$this->load->model('Solucion');
		$data['solucion'] = $this->Solucion->getAllView('nombre', 'asc');
		//$this->load->model('Rubro');
		//$data['rubros'] = $this->Rubro->getAllView('nombre', 'asc');
		//$this->load->model('Areainvestigacion');
		//$data['areas'] = $this->Areainvestigacion->getAllView('nombre', 'asc');
		$this->load->model('Sector');
		$data['sector_productivo'] = $this->Sector->getAllView('nombre', 'asc');
		$data['sectorSelect'] = $this->Sector->getSectorPropuesta($idpropuesta);
		$this->load->model('Subsector');
		foreach($data['sector_productivo'] as &$sector){
			$sector['subsectores'] = $this->Subsector->getAllBySector($sector['id'], 'es');
			$sector['select'] = $this->Subsector->getSubsectorPropuesta($idpropuesta, $sector['id']);
		}
		$this->load->model('Tema');
		$data['temas'] = $this->Tema->getAllView('nombre', 'asc');
		$data['temasSelect'] = $this->Tema->getTemasPropuesta($idpropuesta);
		$this->load->model('Indicastandar');
		$data['indicastandar'] = $this->Indicastandar->getAllView('nombre', 'asc');
		$this->load->model('Componente');
		$data['componente'] = $this->Componente->getAllView('nombre', 'asc');
		$this->load->model('Pais');
		$data['paisindicador'] = $this->Pais->getAllView('nombre', 'asc');		
		array_unshift($data['paisindicador'], array('id'=>0, 'nombre'=>'Ninguno'));
		$this->load->model('Unidad');
		$data['unidades'] = $this->Unidad->getAllView('nombre', 'asc');
		$this->load->model('Badge');
		$data['badges'] = $this->Badge->getAllView();
		$data['badgesObtenidas'] = $this->Badge->getByPropuesta($idpropuesta);

		$this->load->model('Adjunto');
		$data['tipoadjuntos'] =  $this->Adjunto->getTipos('propuestas');
		$this->load->model('Producto');
		$data['tipoproductos'] =  $this->Producto->getTipos();

		$this->load->model('Mapa');
		$data['tienePpal'] = $this->Mapa->tienePpal($idpropuesta);
		
		$data['libs'] = Array('tinymce', 'datatables', 'select2', 'jasny', 'imagepicker', 'summernote');
        $data['page'] = 'propuesta_modificar';
        $this->load->view('admin/estruc/estructura', $data);        
	}

	private function solo_numeros($val){
		$res = preg_replace('/[^0-9.]/', '', $val);
		if(empty($res)) return 0;
		return $res;
	}	

	
    public function depurar($idpropuesta){
		if(empty($idpropuesta)) return;
		$data['lenguajes'] = $this->Lenguaje->getHabilitados('idlenguaje', 'asc');
		$data['datas_lang'] = array();
        $data['idpropuesta'] = $idpropuesta;
        $data['propuesta'] = array();
        $this->load->helper('form');
		if (!empty($_POST)){           
			
            $this->load->model('Tema');
			$this->Tema->actualizarPropuesta($idpropuesta, $this->input->post('idtemas'));	
            $this->load->model('Sector');
			$this->Sector->actualizarPropuesta($idpropuesta, $this->input->post('idsectores'));	
			$this->load->model('Subsector');			
			$this->Subsector->actualizarPropuesta($idpropuesta, $this->input->post('idsubsectores'));	
			redirect("admin/propuestas/listar");           
        }else{
            if(!empty($idpropuesta)){
                $propuesta = $this->getCleanPropuesta($idpropuesta);                
				$data['propuesta'] = $propuesta;

				$datas_lang = array();
				$paqueteLang = $this->Propuesta->getLanguages($idpropuesta);
				foreach($paqueteLang as $pl){
					$datas_lang[$pl['codlang']] = $pl;
				}
				$data['datas_lang'] = $datas_lang;
				
				if(empty($data['propuesta']['web_url'])){
					$data['propuesta']['web_url'] = toURLFriendly($data['datas_lang']['es']['titulo_simple']);
				}
                $data['readonly'] = true;
            }
		}
		$this->load->model('Estado');
		$data['estado'] = $this->Estado->getAllView();
		$this->load->model('Operacion');
		$data['operacion'] = $this->Operacion->getAllView('nombre', 'asc');
		$this->load->model('Estrategica');
		$data['linea_estrategica'] = $this->Estrategica->getAllView('nombre', 'asc');
		$this->load->model('Investigacion');
		$data['tipo_investigacion'] = $this->Investigacion->getAllView('nombre', 'asc');
		$this->load->model('Innovacion');
		$data['tipo_innovacion'] = $this->Innovacion->getAllView('nombre', 'asc');
		$this->load->model('Solucion');
		$data['solucion'] = $this->Solucion->getAllView('nombre', 'asc');
		//$this->load->model('Rubro');
		//$data['rubros'] = $this->Rubro->getAllView('nombre', 'asc');
		//$this->load->model('Areainvestigacion');
		//$data['areas'] = $this->Areainvestigacion->getAllView('nombre', 'asc');
		$this->load->model('Sector');
		$data['sector_productivo'] = $this->Sector->getAllView('nombre', 'asc');
		$data['sectorSelect'] = $this->Sector->getSectorPropuesta($idpropuesta);
		$this->load->model('Subsector');
		foreach($data['sector_productivo'] as &$sector){
			$sector['subsectores'] = $this->Subsector->getAllBySector($sector['id'], 'es');
			$sector['select'] = $this->Subsector->getSubsectorPropuesta($idpropuesta, $sector['id']);
		}

		$this->load->model('Tema');
		$data['temas'] = $this->Tema->getAllView('nombre', 'asc');
		$data['temasSelect'] = $this->Tema->getTemasPropuesta($idpropuesta);
		
		$data['libs'] = Array();
        $data['page'] = 'propuesta_depurar';
        $this->load->view('admin/estruc/estructura', $data);        
	}


    public function investigador($idpropuesta){
		$data['lenguajes'] = $this->Lenguaje->getHabilitados('idlenguaje', 'asc');
		$data['datas_lang'] = array();
		$this->getCleanPropuesta($idpropuesta);  //permisos
        $data['idpropuesta'] = $idpropuesta;
        $data['propuesta'] = array();
        $this->load->helper('form');
		if (!empty($_POST)){           
			$propuesta = array();
	
				
			$retUpload = $this->do_upload('web_foto');
			if(!empty($retUpload['imagen'])){
				$propuesta['web_foto'] = Array('val'=>$retUpload['imagen'], 'req'=>FALSE);
			}	
			$habilitado = (isset($_POST['web_publicado']) && $_POST['web_publicado']=='on')? 1 : 0;
			$propuesta['web_publicado'] = Array('val'=>$habilitado, 'req'=>FALSE);
			
			$datas_lang = array();
			foreach($data['lenguajes'] as $lenguaje){
				$paquete_lang= array();

				$paquete_lang['web_impacto'] = $this->input->post('web_impacto_'.$lenguaje->codlang);
				$paquete_lang['web_beneficiarios'] = $this->input->post('web_beneficiarios_'.$lenguaje->codlang);
				$paquete_lang['web_solucion'] = $this->input->post('web_solucion_'.$lenguaje->codlang);
				$paquete_lang['web_resumen'] = $this->input->post('web_resumen_'.$lenguaje->codlang);
				$datas_lang[$lenguaje->codlang] = $paquete_lang;
			}
			            
            $result = $this->Propuesta->insertOrUpdate($idpropuesta, $propuesta);
            if($result && is_numeric($result)){		
				$this->load->model('Tema');
				$this->Tema->actualizarPropuesta($result, $this->input->post('idtemas'));	
				$this->load->model('Sector');
				$this->Sector->actualizarPropuesta($idpropuesta, $this->input->post('idsectores'));	
				$this->load->model('Subsector');			
				$this->Subsector->actualizarPropuesta($idpropuesta, $this->input->post('idsubsectores'));		
				$this->Propuesta->insertOrUpdateLanguage($result, $datas_lang);
                redirect("admin/propuestas/investigador/".$result);
            }else{
                $data['error'] = $result;
                $data['propuesta'] = $this->Propuesta->getValores($propuesta);
            }
        }else{
            if(!empty($idpropuesta)){
                $propuesta = $this->getCleanPropuesta($idpropuesta);                
				$data['propuesta'] = $propuesta;

				$datas_lang = array();
				$paqueteLang = $this->Propuesta->getLanguages($idpropuesta);
				foreach($paqueteLang as $pl){
					$datas_lang[$pl['codlang']] = $pl;
				}
				$data['datas_lang'] = $datas_lang;
				
				if(empty($data['propuesta']['web_url'])){
					$data['propuesta']['web_url'] = toURLFriendly($data['datas_lang']['es']['titulo_simple']);
				}
                $data['readonly'] = false;
            }
		}
		
		$this->load->model('Sector');
		$data['sector_productivo'] = $this->Sector->getAllView('nombre', 'asc');
		$data['sectorSelect'] = $this->Sector->getSectorPropuesta($idpropuesta);
		$this->load->model('Subsector');
		foreach($data['sector_productivo'] as &$sector){
			$sector['subsectores'] = $this->Subsector->getAllBySector($sector['id'], 'es');
			$sector['select'] = $this->Subsector->getSubsectorPropuesta($idpropuesta, $sector['id']);
		}
		$this->load->model('Tema');
		$data['temas'] = $this->Tema->getAllView('nombre', 'asc');
		$data['temasSelect'] = $this->Tema->getTemasPropuesta($idpropuesta);
		$this->load->model('Indicastandar');
		$data['indicastandar'] = $this->Indicastandar->getAllView('nombre', 'asc');
		$this->load->model('Componente');
		$data['componente'] = $this->Componente->getAllView('nombre', 'asc');
		$this->load->model('Pais');
		$data['paisindicador'] = $this->Pais->getAllView('nombre', 'asc');		
		array_unshift($data['paisindicador'], array('id'=>0, 'nombre'=>'Ninguno'));
		$this->load->model('Unidad');
		$data['unidades'] = $this->Unidad->getAllView('nombre', 'asc');
		$this->load->model('Badge');
		$data['badges'] = $this->Badge->getAllView();
		$data['badgesObtenidas'] = $this->Badge->getByPropuesta($idpropuesta);

		$this->load->model('Adjunto');
		$data['tipoadjuntos'] =  $this->Adjunto->getTipos('propuestas');
		$this->load->model('Producto');
		$data['tipoproductos'] =  $this->Producto->getTipos();

		$this->load->model('Mapa');
		$data['tienePpal'] = $this->Mapa->tienePpal($idpropuesta);
		
		$data['libs'] = Array('tinymce', 'datatables', 'select2', 'jasny', 'imagepicker', 'summernote');
        $data['page'] = 'propuesta_investigador';
        $this->load->view('admin/estruc/estructura', $data);        
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


    public function eliminar(){
        $ideliminar = $_POST['ideliminar'];
        $this->Propuesta->eliminarBlando($ideliminar);
	}
		
	function select($search){
		$retorno = array('results'=>array());
		$retorno['pagination'] = array('more'=>false);
		if(strlen($search)>0){
			$propuestas = $this->Propuesta->buscarSelect($search);
			$retorno['results'] = $propuestas;
		}
		echo json_encode($retorno);
	}

	function agregarDonante(){
		if (!empty($_POST)){ 
			$this->load->model('Organismo');
			$idpropuesta = $this->input->post('idpropuesta'); 
			$this->getCleanPropuesta($idpropuesta);//permisos
			$idorganismo = $this->input->post('idorganismo'); 
			$orden = $this->input->post('orden');
			if(empty($idpropuesta) || empty($idorganismo) || !is_numeric($idpropuesta) || !is_numeric($idorganismo) || !is_numeric($orden) ){
				echo 'Complete correctamente los datos';
				exit;
			}
			$this->Organismo->agregarDonante($idpropuesta, $idorganismo, $orden);
		}
		return '';
	}

	function deleteDonante(){
		$iddonante = $this->input->post('iddonante'); 
		if(is_numeric($iddonante)){
			$this->load->model('Organismo');
			$this->Organismo->eliminarDonante($iddonante);
		}
	}

	function getDonantes($idpropuesta){
		$this->getCleanPropuesta($idpropuesta);//permisos
		$data = array();
		$this->load->model('Organismo');
		$data['donantes'] = $this->Organismo->getDonantes($idpropuesta);
		$this->load->view('admin/tabla_donantes', $data);
	}

	private function do_upload($campo) {
		$retorno = Array('error'=>'', 'imagen'=>'');
		if (isset($_FILES[$campo]) && is_uploaded_file($_FILES[$campo]['tmp_name'])) {
			$config['upload_path']          = './uploads/propuestas/';
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

	public function guardarBadges(){
		$badges = $this->input->post('badges');
		$idpropuesta = $this->input->post('idpropuesta');
		$propuesta = $this->getCleanPropuesta($idpropuesta); //por tema de permisos
		$this->load->model('Badge'); 
		$this->Badge->actualizarPropuesta($idpropuesta, $badges);
	}
}
?>
