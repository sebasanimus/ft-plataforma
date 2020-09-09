<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Webstories extends CI_Controller {

    public function __construct() {
		parent::__construct();
		$this->login->verify();

        $this->load->model('Webstory');
        $this->load->model('Propuesta');
	}

	public function index()	{		
		header("Location: ".base_url().'admin/webstories/listar');
	}
	
    public function listar(){
		$data['libs'] = Array('datatables');
        $data['page'] = 'webstory_listar';
		$this->load->view('admin/estruc/estructura', $data);
    }


	public function paginar(){
		$input['busqueda'] = $this->input->post('sSearch');
		$input['comienzo'] = $this->input->post('iDisplayStart');
		$input['cantidad'] = $this->input->post('iDisplayLength');	
		$input['ordenar'] = 'idwebstory';
				
		$columnas[0] = 'foto_principal';
		$columnas[1] = 'titulo_simple';
		$columnas[2] = 'url';
		$columnas[3] = 'habilitado';
		$columnas[4] = 'idwebstory';
		$sort = $this->input->post('iSortCol_0');
		if(!empty($sort)){
			$input['ordenar'] = $columnas[$sort].' '.$this->input->post('sSortDir_0');
		}
		
		$output['sEcho'] = $this->input->post('sEcho');
		$output['iTotalRecords'] = $this->Webstory->getTotalRecords(); 
		$output['iTotalDisplayRecords'] = $this->Webstory->getTotalFilteredRecords($input);
		$output['aaData'] = array();
		$datos = $this->Webstory->getPaginated($input);
		foreach($datos as $dat){
			$salida = array();
			$salida[0] = $dat['foto_principal'];
			$salida[1] = $dat['titulo_simple'].'**'.$dat['identificador'];
			$salida[2] = $dat['titulo'].'**'.$dat['url'];
			$salida[3] = $dat['habilitado'];
			$salida[4] = $dat['idwebstory'];
			$output['aaData'][] = $salida;
		}
		echo json_encode($output);
	}
	

    public function ver($idwebstory=0){
		$data['lenguajes'] = $this->Lenguaje->getHabilitados('idlenguaje', 'asc');
		$data['datas_lang'] = array();
        $data['idwebstory'] = $idwebstory;
        $data['webstory'] = array();
        $this->load->helper('form');
		if (!empty($_POST)){           
			$webstory = array();
			if(!empty($idwebstory)){
				$this->getCleanWebstory($idwebstory); //permisos
			}

			$publica_inv = (isset($_POST['publica_inv']) && $_POST['publica_inv']=='on')? 1 : 0;
			$habilitado = (isset($_POST['habilitado']) && $_POST['habilitado']=='on')? 1 : 0;
			if($this->session->userdata('role')==4){
				$webstory['publica_inv'] = Array('val'=>$publica_inv, 'req'=>FALSE);
				if(empty($idwebstory)){ //si es inv y recien estra creando la webstory, aparece despublicada
					$webstory['habilitado'] = Array('val'=>0, 'req'=>FALSE);
				}
			}else{
				$webstory['link_publicacion'] = Array('val'=>$this->input->post('link_publicacion'), 'req'=>FALSE);
				$webstory['habilitado'] = Array('val'=>$habilitado, 'req'=>FALSE);
			}
			
			
			$webstory['url'] = Array('val'=>toURLFriendly($this->input->post('url')), 'req'=>TRUE);
			$webstory['idpropuesta'] = Array('val'=>$this->input->post('idpropuesta'), 'req'=>TRUE);
			$this->getCleanPropuesta($webstory['idpropuesta']['val']);//permisos
			$webstory['video'] = Array('val'=>$this->input->post('video'), 'req'=>FALSE);

			$retUpload = $this->do_upload('foto_principal');
			if(!empty($retUpload['imagen'])){
				$webstory['foto_principal'] = Array('val'=>$retUpload['imagen'], 'req'=>FALSE);
			}	
			$retUpload = $this->do_upload('foto_cita');
			if(!empty($retUpload['imagen'])){
				$webstory['foto_cita'] = Array('val'=>$retUpload['imagen'], 'req'=>FALSE);
			}	
			$retUpload = $this->do_upload('foto_link');
			if(!empty($retUpload['imagen'])){
				$webstory['foto_link'] = Array('val'=>$retUpload['imagen'], 'req'=>FALSE);
			}
			
			$paqueteLang = $this->Webstory->getLanguages($idwebstory);			
			$datas_lang = array();
			foreach($data['lenguajes'] as $lenguaje){
				$paquete_lang= array();
				$paquete_lang['titulo'] = $this->input->post('titulo_'.$lenguaje->codlang);
				$paquete_lang['bajada'] = $this->input->post('bajada_'.$lenguaje->codlang);
				$paquete_lang['contexto'] = $this->input->post('contexto_'.$lenguaje->codlang);
				$paquete_lang['iniciativa_titulo'] = $this->input->post('iniciativa_titulo_'.$lenguaje->codlang);
				$paquete_lang['iniciativa_descripcion'] = $this->input->post('iniciativa_descripcion_'.$lenguaje->codlang);
				$paquete_lang['solucion_titulo'] = $this->input->post('solucion_titulo_'.$lenguaje->codlang);
				$paquete_lang['solucion_descripcion'] = $this->input->post('solucion_descripcion_'.$lenguaje->codlang);
				$paquete_lang['cita_texto'] = $this->input->post('cita_texto_'.$lenguaje->codlang);
				$paquete_lang['cita_fuente'] = $this->input->post('cita_fuente_'.$lenguaje->codlang);
				//$paquete_lang['impactos'] = $this->input->post('impactos_'.$lenguaje->codlang);
				$paquete_lang['resultados'] = $this->input->post('resultados_'.$lenguaje->codlang);
				$paquete_lang['infografia_titulo'] = $this->input->post('infografia_titulo_'.$lenguaje->codlang);
				$paquete_lang['estadisticas_titulo'] = $this->input->post('estadisticas_titulo_'.$lenguaje->codlang);
				$paquete_lang['infografia_volanta'] = $this->input->post('infografia_volanta_'.$lenguaje->codlang);
				$paquete_lang['codigo_estadisticas'] = $this->input->post('codigo_estadisticas_'.$lenguaje->codlang);
				$paquete_lang['codigo_infografia'] = $this->input->post('codigo_infografia_'.$lenguaje->codlang);
				if($this->session->userdata('role')!=4){
					$paquete_lang['link_publicacion_titulo'] = $this->input->post('link_publicacion_titulo_'.$lenguaje->codlang);
				}

				$retUpload = $this->do_upload('infografia_'.$lenguaje->codlang);
				if(!empty($retUpload['imagen'])){
					$paquete_lang['infografia'] = $retUpload['imagen'];
				}else if(!empty($idwebstory)){ //sino me elimina la foto ya cargada
					foreach($paqueteLang as $pal){
						if($pal['codlang']==$lenguaje->codlang){
							if (empty($_POST['infografia_'.$pal['codlang'].'_delete'])){
								$paquete_lang['infografia'] = $pal['infografia'];
							}else{
								$paquete_lang['infografia'] = null;
							}
						} 
					}		
				}
				$datas_lang[$lenguaje->codlang] = $paquete_lang;
			}
			
			            
            $result = $this->Webstory->insertOrUpdate($idwebstory, $webstory);
            if($result && is_numeric($result)){				
				$this->Webstory->insertOrUpdateLanguage($result, $datas_lang);
				if($this->session->userdata('role')==4 && $publica_inv){
					$this->load->library('Utilidades');
					$this->utilidades->crearAlerta('Webstory: '.substr($datas_lang['es']['titulo'], 0, 25).'...', 'Se encuentra pendiente de moderación la webstory: '.$datas_lang['es']['titulo'], base_url().'admin/webstories/ver/'.$result, 'contenidos');
				}
                redirect("admin/webstories/ver/".$result);
            }else{
                $data['error'] = $result;
                $data['webstory'] = $this->Webstory->getValores($webstory);
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
		$this->load->model('Adjunto');
		$data['tipoadjuntos'] =  $this->Adjunto->getTipos('webstory');
		$this->load->model('Pais');
		$data['paises'] = $this->Pais->getAllView('nombre', 'asc');	

		$this->load->model('Badge');
		$data['badges'] = $this->Badge->getAllView();
		$data['badgesObtenidas'] = $this->Badge->getByWebstory($idwebstory);
		$data['libs'] = Array('datatables', 'select2', 'jasny', 'imagepicker', 'iconsvgpicker', 'summernote');
        $data['page'] = 'webstory_modificar';
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
                $this->processImageOriginal($config['upload_path'], $uploadData['file_name']);
			}
		}
		return $retorno;
	}
	
    private function processImageOriginal($directory, $image){
        $image_location = $directory . "/" . $image; 
        $thumb_destination = $directory . "/" . $image; 
        $compression_type = Imagick::COMPRESSION_JPEG; 
    
        $thumbnail = new Imagick($image_location); 

        if($thumbnail->getImageFormat()=='PNG'){  
            $thumbnail->setImageCompressionQuality(95); 
        }else{
            $thumbnail->setImageCompressionQuality(25); 
        }
        $thumbnail->stripImage();
		$thumbnail->writeImage($thumb_destination); 
		
		if($thumbnail->getImageWidth()>2000 ){
			$thumbnail->thumbnailImage(null,2000);
		} 

        $thumb_destination = $directory . "/" . $image; 
		$thumbnail->writeImage($thumb_destination);        
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
            redirect("admin/webstories/listar");
        }
        $webstory = $this->Webstory->getById($idwebstory);
        if(empty($webstory)){
            $this->session->set_userdata('error', 'No se encontro al webstory con ID '.$idwebstory);
            redirect("admin/webstories/listar");
        }
		if(!$this->Webstory->tengoPermiso($webstory['idpropuesta'])){
			$this->session->set_userdata('error', 'No tiene permisos para modificar ese proyecto');
            redirect("admin/webstories/listar");
		}
        return $webstory;
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
        $this->Webstory->eliminarBlando($ideliminar);
	}

	public function guardarBadges(){
		$badges = $this->input->post('badges');
		$idwebstory = $this->input->post('idwebstory');
		$webstory = $this->getCleanWebstory($idwebstory); //por tema de permisos
		$this->load->model('Badge'); 
		$this->Badge->actualizarWebstory($idwebstory, $badges);
	}


	public function paginarIndicadores($idwebstory){
		$this->load->model('WSIndicador');
		$input['busqueda'] = $this->input->post('sSearch');
		$input['comienzo'] = $this->input->post('iDisplayStart');
		$input['cantidad'] = $this->input->post('iDisplayLength');	
		$input['ordenar'] = 'idwebstoryindicador';

		$input['idwebstory'] = $idwebstory;
		$this->getCleanWebstory($idwebstory); //por tema de permisos
				
		$columnas[0] = 'idwebstoryindicador';
		$columnas[1] = 'nombre';
		$columnas[2] = 'valor';
		$columnas[3] = 'idwebstoryindicador';
		$sort = $this->input->post('iSortCol_0');
		
		$input['ordenar'] = $columnas[$sort].' '.$this->input->post('sSortDir_0');
		
		
		$output['sEcho'] = $this->input->post('sEcho');
		$output['iTotalRecords'] = $this->WSIndicador->getTotalRecords(); 
		$output['iTotalDisplayRecords'] = $this->WSIndicador->getTotalFilteredRecords($input);
		$output['aaData'] = array();
		$datos = $this->WSIndicador->getPaginated($input);
		foreach($datos as $dat){
			$salida = array();
			$salida[0] = $dat['icono'];
			$salida[1] = $dat['nombre'];
			$salida[2] = $dat['prefijo'].$dat['valor'].$dat['unidad'];
			$salida[3] = $dat['idwebstoryindicador'];
			$output['aaData'][] = $salida;
		}
		echo json_encode($output);
	}

	public function agregarIndicador(){
		
		if (!empty($_POST)){           
			$indicador = array();
			$lenguajes = $this->Lenguaje->getHabilitados('idlenguaje', 'asc');
			$idindicador = $this->input->post('idwebstoryindicador');
			$idwebstory = $this->input->post('idwebstory');
			$webstory = $this->getCleanWebstory($idwebstory); //por tema de permisos
			$this->load->model('WSIndicador'); 

			if(!empty($idindicador)){ //me tengo que asegurar que el adjunto a modificar corresponda al webstory que dice pertenecer
				$ind = $this->WSIndicador->getById($idindicador);
				if($ind['idwebstory']!=$idwebstory){
					echo 'No coinciden los datos';
					exit;
				}
			}

			$indicador['idwebstory'] = Array('val'=>$this->input->post('idwebstory'), 'req'=>FALSE);
			$indicador['valor'] = Array('val'=>$this->input->post('valor'), 'req'=>FALSE);
			$indicador['icono'] = Array('val'=>$this->input->post('icon'), 'req'=>TRUE);
			$indicador['prefijo'] = Array('val'=>$this->input->post('prefijo'), 'req'=>FALSE);
			$indicador['unidad'] = Array('val'=>$this->input->post('unidad'), 'req'=>FALSE);
			$datas_lang = array();
			foreach($lenguajes as $lenguaje){
				$paquete_lang= array();
				$paquete_lang['nombre'] = $this->input->post('nombre_'.$lenguaje->codlang);
				$datas_lang[$lenguaje->codlang] = $paquete_lang;
			}
			            
            $result = $this->WSIndicador->insertOrUpdate($idindicador, $indicador);
            if($result && is_numeric($result)){				
				$this->WSIndicador->insertOrUpdateLanguage($result, $datas_lang);
				echo '';
				exit;
            }else{
				echo $result;
			}
		}
	}

	public function obtenerIndicador($idwebstory){
		$this->getCleanWebstory($idwebstory);  //por tema de permisos
		$this->load->model('WSIndicador');
		$indicador = $this->WSIndicador->obtener($idwebstory, $this->input->post('idindicador'));
		echo json_encode($indicador);
	}

    public function eliminarIndicador($idwebstory){
		$this->getCleanWebstory($idwebstory);  //por tema de permisos
		$ideliminar = $this->input->post('ideliminar');
		$this->load->model('WSIndicador');
		$indicador = $this->WSIndicador->getById($ideliminar);
		if($indicador['idwebstory']==$idwebstory){
			$this->WSIndicador->eliminarLang($ideliminar);
		}
	}
	

	public function paginarPais($idwebstory){
		$this->load->model('WSPais');
		$input['busqueda'] = $this->input->post('sSearch');
		$input['comienzo'] = $this->input->post('iDisplayStart');
		$input['cantidad'] = $this->input->post('iDisplayLength');	
		$input['ordenar'] = 'idwebstoryorganismo';

		$input['idwebstory'] = $idwebstory;
		$this->getCleanWebstory($idwebstory);  //por tema de permisos
				
		$columnas[0] = 'nombre_pais';
		$columnas[1] = 'organismo';
		$columnas[2] = 'idwebstoryorganismo';
		$sort = $this->input->post('iSortCol_0');
		
		$input['ordenar'] = $columnas[$sort].' '.$this->input->post('sSortDir_0');
		
		
		$output['sEcho'] = $this->input->post('sEcho');
		$output['iTotalRecords'] = $this->WSPais->getTotalRecords(); 
		$output['iTotalDisplayRecords'] = $this->WSPais->getTotalFilteredRecords($input);
		$output['aaData'] = array();
		$datos = $this->WSPais->getPaginated($input);
		foreach($datos as $dat){
			$salida = array();
			$salida[0] = $dat['nombre_pais'];
			$salida[1] = $dat['organismo'];
			$salida[2] = $dat['idwebstoryorganismo'];
			$output['aaData'][] = $salida;
		}
		echo json_encode($output);
	}

	public function agregarPais(){
		
		if (!empty($_POST)){           
			$pais = array();
			$lenguajes = $this->Lenguaje->getHabilitados('idlenguaje', 'asc');
			$idwebstoryorganismo = $this->input->post('idwebstoryorganismo');
			$idwebstory = $this->input->post('idwebstory');
			$webstory = $this->getCleanWebstory($idwebstory); //por tema de permisos
			$this->load->model('WSPais'); 

			if(!empty($idwebstoryorganismo)){ //me tengo que asegurar que el adjunto a modificar corresponda al webstory que dice pertenecer
				$ind = $this->WSPais->getById($idwebstoryorganismo);
				if($ind['idwebstory']!=$idwebstory){
					echo 'No coinciden los datos';
					exit;
				}
			}

			$pais['idwebstory'] = Array('val'=>$this->input->post('idwebstory'), 'req'=>TRUE);
			$pais['idorganismo'] = Array('val'=>$this->input->post('idorganismo'), 'req'=>FALSE);
			$idpais = $this->input->post('pais');
			$idpais = empty($idpais)? null:$idpais;
			$pais['pais'] = Array('val'=>$idpais, 'req'=>FALSE);
			
			            
            $result = $this->WSPais->insertOrUpdate($idwebstoryorganismo, $pais);
            if($result && is_numeric($result)){				
				echo '';
				exit;
            }else{
				echo $result;
			}
		}
	}

	public function obtenerPais($idwebstory){
		$this->getCleanWebstory($idwebstory);  //por tema de permisos
		$this->load->model('WSPais');
		$pais = $this->WSPais->obtener($idwebstory, $this->input->post('idwebstoryorganismo'));
		echo json_encode($pais);
	}

    public function eliminarPais($idwebstory){
		$this->getCleanWebstory($idwebstory);  //por tema de permisos
		$ideliminar = $this->input->post('ideliminar');
		$this->load->model('WSPais');
		$pais = $this->WSPais->getById($ideliminar);
		if($pais['idwebstory']==$idwebstory){
			$this->WSPais->eliminar($ideliminar);
		}
	}

    public function textos(){
		$this->load->model('Info');
		$data['lenguajes'] = $this->Lenguaje->getHabilitados('idlenguaje', 'asc');
		$data['datas_lang'] = array();
        $this->load->helper('form');
		if (!empty($_POST)){           
			$webstory = array();
			$campos = Array('twitter', 'vimeo', 'youtube', 'linkedin');

			foreach($campos as $campo){
				$valor = $this->input->post($campo);
				$this->Info->actualizar('ni', $campo, $valor, 'all');
			}
			
			
			$campos_lang = Array('descripcion', 'sobre_fontagro', 'contexto', 'iniciativa', 'solucion', 'mapa', 'impactos_resultados', 'estadisticas', 
				'video', 'infografia', 'donantes', 'informacion', 'logos', 'prefooter', 'menu', 'historias', 'volver', 'conocer_mas', 'ficha', 'novedades', 
				'conoce', 'tipo_proyecto', 'tech_descripcion', 'iniciativas_y_proyectos', 'iniciativas_en_curso', 'proyectos_dato_1', 'proyectos_dato_2', 
				'proyectos_dato_3', 'proyectos_dato_4', 'proyectos_dato_5', 'proyectos_dato_6', 'fuente_de_financiamiento', 'resumen_ejecutivo', 'beneficiarios_proyectos',
				'objetivos_sostenibles', 'novedades_proyecto', 'webstory_tagline', 'webstory_titulo', 'graficos_y_datos', 'financiamiento_pais', 'proyecto_anterior',
				'proyecto_siguiente', 'mapa_geolocalizado', 'publicaciones_y_recursos', 'otros_proyectos', 'patrocinadores', 'con_el_apoyo', 'el_proyecto', 
				'compartir', 'plazo_ejecucion_proyecto', 'plazo_ejecucion_meses', 'productos_de_diseminacion',
				'proyhome_titulo', 'proyhome_descripcion', 'proyhome_tit_part1', 'proyhome_tit_part2', 'proyhome_tit_part3', 'proyhome_proy_activos', 
				'proyhome_usd_fondos', 'proyhome_buscar_proy', 'proyhome_buscar', 'proyhome_pal_clave', 'proyhome_tipo', 'proyhome_estado',  'proyhome_anio',
				'proyhome_tema', 'proyhome_pais', 'proyhome_iniciativas', 'proyhome_ini_desc', 'proyhome_conocer', 'proyhome_cargar', 
				'proyhome_ver', 'proyhome_editar', 'proyhome_ultimas', 'proyhome_delos', 'proyhome_proyecto', 'proyhome_organismo', 'proyhome_ejecutor',
				'proyhome_ver_todos', 'proyhome_convocatorias', 'proyhome_concursos', 'proyini_plataforma',
				'proyini_perfiles_pre', 'proyini_perfiles_desc', 'proyini_info', 'proyini_info_desc', 'proyini_ganadores', 'proyini_ganadores_desc',
				'proybus_todos', 'proybus_activos', 'proybus_ejecutados', 'proybus_encontraron', 'proybus_iniciativas', 'proybus_siguiendo', 'proybus_pagina', 'proybus_de');
				
			foreach($data['lenguajes'] as $lenguaje){	
				foreach($campos_lang as $campol){			
					$valor = $this->input->post($campol.'_'.$lenguaje->codlang);
					$this->Info->actualizar($lenguaje->codlang, $campol, $valor, 'webstory');
				}
			}

            
		}
		$data['readonly'] = TRUE;
		$data['infos'] = $this->Info->obtenerByIndice('webstory');
		$data['libs'] = Array();
        $data['page'] = 'webstory_textos';
        $this->load->view('admin/estruc/estructura', $data);        
	}
	
}
?>
