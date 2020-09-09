<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Callistas extends CI_Controller {

    public function __construct() {
		parent::__construct();
		$this->login->verify();

		$this->load->model('Callista');
	}

	public function index()	{		
		header("Location: ".base_url().'admin/callistas/listar');
	}
	
	public function listar(){
		$data =Array();
		$data['lenguajes'] = $this->Lenguaje->getHabilitados('idlenguaje', 'asc');
		$data['libs'] = Array('datatables');
        $data['page'] = 'callista_listar';
		$this->load->view('admin/estruc/estructura', $data);
	}

	public function paginar(){
		$input['busqueda'] = $this->input->post('sSearch');
		$input['comienzo'] = $this->input->post('iDisplayStart');
		$input['cantidad'] = $this->input->post('iDisplayLength');	
		$input['ordenar'] = 'idcallista';
				
		$columnas[0] = 'idcallista';
		$columnas[1] = 'titulo';
		$columnas[2] = 'fecha_desde';
		$columnas[3] = 'fecha_hasta';
		$columnas[4] = 'estado';
		$columnas[5] = 'idcallista';
		$sort = $this->input->post('iSortCol_0');
		if(!empty($sort)){
			$input['ordenar'] = $columnas[$sort].' '.$this->input->post('sSortDir_0');
		}
		
		$output['sEcho'] = $this->input->post('sEcho');
		$output['iTotalRecords'] = $this->Callista->getTotalRecords(); 
		$output['iTotalDisplayRecords'] = $this->Callista->getTotalFilteredRecords($input);
		$output['aaData'] = array();
		$datos = $this->Callista->getPaginated($input);
		foreach($datos as $dat){
			$salida = array();
			$salida[0] = $dat['idcallista'];
			$salida[1] = $dat['titulo'];
			$salida[2] = fromYYYYMMDDtoDDMMYYY($dat['fecha_desde'], false);
			$salida[3] = fromYYYYMMDDtoDDMMYYY($dat['fecha_hasta'], false);
			$salida[4] = $dat['estado'];
			$salida[5] = $dat['idcallista'];
			$output['aaData'][] = $salida;
		}
		//print_r($this->Callista->getItemted($input)); exit;
		echo json_encode($output);
	}

	public function modificar($idcallista=0){
		$data['lenguajes'] = $this->Lenguaje->getHabilitados('idlenguaje', 'asc');
		$data['datas_lang'] = array();
        $data['idcallista'] = $idcallista;
        $data['callista'] = array();
        $this->load->helper('form');
		if (!empty($_POST)){           
			$callista = array();
				
			$callista['fecha_desde'] = Array('val'=>fromDDMMYYYtoYYYYMMDD($this->input->post('fecha_desde'), false), 'req'=>FALSE);		
			$callista['fecha_hasta'] = Array('val'=>fromDDMMYYYtoYYYYMMDD($this->input->post('fecha_hasta'), false), 'req'=>FALSE);
			
			$datas_lang = array();
			foreach($data['lenguajes'] as $lenguaje){
				$paquete_lang= array();
				$paquete_lang['titulo'] = $this->input->post('titulo_'.$lenguaje->codlang);
				$paquete_lang['descripcion'] = $this->input->post('descripcion_'.$lenguaje->codlang);
				$paquete_lang['antecedentes'] = $this->input->post('antecedentes_'.$lenguaje->codlang);
				$paquete_lang['objetivos'] = $this->input->post('objetivos_'.$lenguaje->codlang);
				$paquete_lang['metodologia'] = $this->input->post('metodologia_'.$lenguaje->codlang);
				$paquete_lang['calendario'] = $this->input->post('calendario_'.$lenguaje->codlang);
				$paquete_lang['normas'] = $this->input->post('normas_'.$lenguaje->codlang);
				$datas_lang[$lenguaje->codlang] = $paquete_lang;
			}
			            
            $result = $this->Callista->insertOrUpdate($idcallista, $callista);
            if($result && is_numeric($result)){			
				$this->Callista->insertOrUpdateLanguage($result, $datas_lang);
                redirect("admin/callistas/listar/");
            }else{
                $data['error'] = $result;
                $data['callista'] = $this->Callista->getValores($callista);
            }
        }else{
            if(!empty($idcallista)){
                $callista = $this->getCleanCallista($idcallista);
                if(empty($callista)){
                    $data['error'] = 'No se encontro al callista con ID '.$idcallista;
                }else{
					$data['callista'] = $callista;
					$datas_lang = array();
					$paqueteLang = $this->Callista->getLanguages($idcallista);
					foreach($paqueteLang as $pl){
						$datas_lang[$pl['codlang']] = $pl;
					}
					$data['datas_lang'] = $datas_lang;
                }
            }
		}		
		if(!empty($data['callista'])){
			$data['callista']['fecha_desde'] = fromYYYYMMDDtoDDMMYYY($data['callista']['fecha_desde'], false);
			$data['callista']['fecha_hasta'] = fromYYYYMMDDtoDDMMYYY($data['callista']['fecha_hasta'], false);
		}
		$data['libs'] = Array('tinymce', 'datetimepicker');
        $data['page'] = 'callista_modificar';
        $this->load->view('admin/estruc/estructura', $data);        
	}



	public function eliminar(){
		$ideliminar = $this->input->post('ideliminar');
		$this->Callista->eliminarBlando($ideliminar);
	}

	
    private function getCleanCallista($idcallista){
        if(empty($idcallista) || !is_numeric($idcallista)){
            $this->session->set_userdata('error', 'No se encontro al callista con ID '.$idcallista);
            redirect("admin/callistas");
        }
        $callista = $this->Callista->getById($idcallista);
        if(empty($callista)){
            $this->session->set_userdata('error', 'No se encontro al callista con ID '.$idcallista);
            redirect("admin/callistas");
        }
        return $callista;
	}
	

    public function textos(){
		$this->load->model('Info');
		$data['lenguajes'] = $this->Lenguaje->getHabilitados('idlenguaje', 'asc');
		$data['datas_lang'] = array();
		$this->load->helper('form');
		$campos_lang = Array(
		
			Array('area'=> 'Menu', 'tipo'=>'text', 'nombre'=>'ista_volver', 'titulo'=>'Volver', 'descripcion'=>'Traducción', 'max'=>30), 
			Array('area'=> 'Menu', 'tipo'=>'text', 'nombre'=>'ista_anterior', 'titulo'=>'Anterior', 'descripcion'=>'Traducción', 'max'=>30), 
			Array('area'=> 'Menu', 'tipo'=>'text', 'nombre'=>'ista_guardar', 'titulo'=>'Guardar', 'descripcion'=>'Traducción', 'max'=>30), 
			Array('area'=> 'Menu', 'tipo'=>'text', 'nombre'=>'ista_siguiente', 'titulo'=>'Siguiente', 'descripcion'=>'Traducción', 'max'=>30), 
			Array('area'=> 'Menu', 'tipo'=>'text', 'nombre'=>'ista_notificacion_exito', 'titulo'=>'Éxito al guardar', 'descripcion'=>'Traducción', 'max'=>300), 
			Array('area'=> 'Menu', 'tipo'=>'text', 'nombre'=>'ista_notificacion_error', 'titulo'=>'Error al guardar', 'descripcion'=>'Traducción', 'max'=>300), 
			Array('area'=> 'Menu', 'tipo'=>'text', 'nombre'=>'ista_notificacion_incompleto', 'titulo'=>'Perfil incompleto', 'descripcion'=>'Traducción', 'max'=>300), 
			Array('area'=> 'Menu', 'tipo'=>'text', 'nombre'=>'ista_notificacion_completo', 'titulo'=>'Perfil completo', 'descripcion'=>'Traducción', 'max'=>300), 
			Array('area'=> 'Menu', 'tipo'=>'text', 'nombre'=>'ista_notificacion_tiempo', 'titulo'=>'Tiempo restante', 'descripcion'=>'Traducción', 'max'=>300), 
			Array('area'=> 'Menu', 'tipo'=>'text', 'nombre'=>'ista_datos_requeridos', 'titulo'=>'Datos requeridos', 'descripcion'=>'Traducción', 'max'=>30), 

			Array('area'=> 'Menu', 'tipo'=>'text', 'nombre'=>'ista_paso_1', 'titulo'=>'Paso 1', 'descripcion'=>'Título Paso 1', 'max'=>30), 
			Array('area'=> 'Menu', 'tipo'=>'text', 'nombre'=>'ista_paso_2', 'titulo'=>'Paso 2', 'descripcion'=>'Título Paso 2', 'max'=>30), 
			Array('area'=> 'Menu', 'tipo'=>'text', 'nombre'=>'ista_paso_3', 'titulo'=>'Paso 3', 'descripcion'=>'Título Paso 3', 'max'=>30), 
			Array('area'=> 'Menu', 'tipo'=>'text', 'nombre'=>'ista_paso_4', 'titulo'=>'Paso 4', 'descripcion'=>'Título Paso 4', 'max'=>30), 
			Array('area'=> 'Menu', 'tipo'=>'text', 'nombre'=>'ista_paso_5', 'titulo'=>'Paso 5', 'descripcion'=>'Título Paso 5', 'max'=>30), 
			Array('area'=> 'Menu', 'tipo'=>'text', 'nombre'=>'ista_paso_6', 'titulo'=>'Paso 6', 'descripcion'=>'Título Paso 6', 'max'=>30), 
			Array('area'=> 'Menu', 'tipo'=>'text', 'nombre'=>'ista_menu_mas_info', 'titulo'=>'Mas Info', 'descripcion'=>'Traduccion', 'max'=>30), 

			Array('area'=> 'Paso 0', 'tipo'=>'text', 'nombre'=>'ista_bienvenida', 'titulo'=>'Bienvenida', 'descripcion'=>'Bienvenida a la convocatoria', 'max'=>300), 
			Array('area'=> 'Paso 0', 'tipo'=>'textarea', 'nombre'=>'ista_he_leido', 'titulo'=>'He Leído', 'descripcion'=>'He leído el manual', 'max'=>0), 
			Array('area'=> 'Paso 0', 'tipo'=>'text', 'nombre'=>'ista_debe_aceptar', 'titulo'=>'Debe Aceptar', 'descripcion'=>'Debe aceptar para continuar', 'max'=>100), 

			Array('area'=> 'Paso 1', 'tipo'=>'text', 'nombre'=>'ista_investigador', 'titulo'=>'Investigador', 'descripcion'=>'Traducción', 'max'=>100), 
			Array('area'=> 'Paso 1', 'tipo'=>'textarea', 'nombre'=>'ista_investigador_descripcion', 'titulo'=>'Descripción Investigador', 'descripcion'=>'Traducción', 'max'=>0),
			Array('area'=> 'Paso 1', 'tipo'=>'text', 'nombre'=>'ista_objetivo', 'titulo'=>'Objetivo', 'descripcion'=>'Traducción', 'max'=>100), 
			Array('area'=> 'Paso 1', 'tipo'=>'textarea', 'nombre'=>'ista_objetivo_descripcion', 'titulo'=>'Descripción Objetivo', 'descripcion'=>'Traducción', 'max'=>0),
		
			Array('area'=> 'Paso 2', 'tipo'=>'text', 'nombre'=>'ista_resumen_ejecutivo', 'titulo'=>'Resumen Ejecutivo', 'descripcion'=>'Traducción', 'max'=>100), 
			Array('area'=> 'Paso 2', 'tipo'=>'textarea', 'nombre'=>'ista_resumen_ejecutivo_descripcion', 'titulo'=>'Descripción Resumen Ejecutivo', 'descripcion'=>'Traducción', 'max'=>0),
			Array('area'=> 'Paso 2', 'tipo'=>'text', 'nombre'=>'ista_resultados', 'titulo'=>'Resultados', 'descripcion'=>'Traducción', 'max'=>100), 
			Array('area'=> 'Paso 2', 'tipo'=>'textarea', 'nombre'=>'ista_resultados_descripcion', 'titulo'=>'Descripción Resultados', 'descripcion'=>'Traducción', 'max'=>0),			
			Array('area'=> 'Paso 2', 'tipo'=>'text', 'nombre'=>'ista_productos', 'titulo'=>'Productos', 'descripcion'=>'Traducción', 'max'=>100), 
			Array('area'=> 'Paso 2', 'tipo'=>'textarea', 'nombre'=>'ista_productos_descripcion', 'titulo'=>'Descripción Productos', 'descripcion'=>'Traducción', 'max'=>0),
		
			Array('area'=> 'Paso 3', 'tipo'=>'text', 'nombre'=>'ista_hallazgos', 'titulo'=>'Hallazgos', 'descripcion'=>'Traducción', 'max'=>100), 
			Array('area'=> 'Paso 3', 'tipo'=>'textarea', 'nombre'=>'ista_hallazgos_descripcion', 'titulo'=>'Descripción Hallazgos', 'descripcion'=>'Traducción', 'max'=>0),
			Array('area'=> 'Paso 3', 'tipo'=>'text', 'nombre'=>'ista_innovaciones', 'titulo'=>'Innovaciones', 'descripcion'=>'Traducción', 'max'=>100), 
			Array('area'=> 'Paso 3', 'tipo'=>'textarea', 'nombre'=>'ista_innovaciones_descripcion', 'titulo'=>'Descripción Innovaciones', 'descripcion'=>'Traducción', 'max'=>0),
		
			Array('area'=> 'Paso 4', 'tipo'=>'text', 'nombre'=>'ista_historias', 'titulo'=>'Historias', 'descripcion'=>'Traducción', 'max'=>100), 
			Array('area'=> 'Paso 4', 'tipo'=>'textarea', 'nombre'=>'ista_historias_descripcion', 'titulo'=>'Descripción Historias', 'descripcion'=>'Traducción', 'max'=>0),
			Array('area'=> 'Paso 4', 'tipo'=>'text', 'nombre'=>'ista_oportunidades', 'titulo'=>'Oportunidades', 'descripcion'=>'Traducción', 'max'=>100), 
			Array('area'=> 'Paso 4', 'tipo'=>'textarea', 'nombre'=>'ista_oportunidades_descripcion', 'titulo'=>'Descripción Oportunidades', 'descripcion'=>'Traducción', 'max'=>0),
		
			Array('area'=> 'Paso 5', 'tipo'=>'text', 'nombre'=>'ista_articulacion', 'titulo'=>'Articulación', 'descripcion'=>'Traducción', 'max'=>100), 
			Array('area'=> 'Paso 5', 'tipo'=>'textarea', 'nombre'=>'ista_articulacion_descripcion', 'titulo'=>'Descripción Articulación', 'descripcion'=>'Traducción', 'max'=>0),
			Array('area'=> 'Paso 5', 'tipo'=>'text', 'nombre'=>'ista_gestion', 'titulo'=>'Gestión', 'descripcion'=>'Traducción', 'max'=>100), 
			Array('area'=> 'Paso 5', 'tipo'=>'textarea', 'nombre'=>'ista_gestion_descripcion', 'titulo'=>'Descripción Gestión', 'descripcion'=>'Traducción', 'max'=>0),
		
			Array('area'=> 'Paso 6', 'tipo'=>'text', 'nombre'=>'ista_adjunto', 'titulo'=>'Adjunto', 'descripcion'=>'Traducción', 'max'=>100), 
			Array('area'=> 'Paso 6', 'tipo'=>'textarea', 'nombre'=>'ista_adjunto_descripcion', 'titulo'=>'Descripción Adjunto', 'descripcion'=>'Traducción', 'max'=>0),
			
			Array('area'=> 'Paso 7', 'tipo'=>'text', 'nombre'=>'ista_submit_titulo_exito', 'titulo'=>'Título Exitoso', 'descripcion'=>'Traduccion', 'max'=>300), 
			Array('area'=> 'Paso 7', 'tipo'=>'text', 'nombre'=>'ista_submit_subtitulo_exito', 'titulo'=>'Subtítulo Exitoso', 'descripcion'=>'Traduccion', 'max'=>300), 
			Array('area'=> 'Paso 7', 'tipo'=>'textarea', 'nombre'=>'ista_submit_descripcion_exito', 'titulo'=>'Descripción Exitoso', 'descripcion'=>'Traduccion', 'max'=>0), 
			Array('area'=> 'Paso 7', 'tipo'=>'text', 'nombre'=>'ista_submit_titulo_error', 'titulo'=>'Título Incompleto', 'descripcion'=>'Traduccion', 'max'=>300), 
			Array('area'=> 'Paso 7', 'tipo'=>'text', 'nombre'=>'ista_submit_subtitulo_error', 'titulo'=>'Subtítulo Incompleto', 'descripcion'=>'Traduccion', 'max'=>300), 
			Array('area'=> 'Paso 7', 'tipo'=>'textarea', 'nombre'=>'ista_submit_descripcion_error', 'titulo'=>'Descripción Incompleto', 'descripcion'=>'Traduccion', 'max'=>0), 
			Array('area'=> 'Paso 7', 'tipo'=>'text', 'nombre'=>'ista_submit_boton', 'titulo'=>'Finalizar Botón', 'descripcion'=>'Texto del botón', 'max'=>30), 
			Array('area'=> 'Paso 7', 'tipo'=>'text', 'nombre'=>'ista_submit_error', 'titulo'=>'Error al enviar', 'descripcion'=>'Error al enviar', 'max'=>300), 
		);
		if (!empty($_POST)){     
			foreach($data['lenguajes'] as $lenguaje){	
				foreach($campos_lang as $campol){			
					$valor = $this->input->post($campol['nombre'].'_'.$lenguaje->codlang);
					$this->Info->actualizar($lenguaje->codlang, $campol['nombre'], $valor, 'ista');
				}
			}            
		}
		$data['campos_lang']=$campos_lang;
		$data['readonly'] = FALSE;
		$data['infos'] = $this->Info->obtenerByIndice('ista');
		$data['libs'] = Array();
        $data['page'] = 'ista_textos';
        $this->load->view('admin/estruc/estructura', $data);        
	}

}
?>
