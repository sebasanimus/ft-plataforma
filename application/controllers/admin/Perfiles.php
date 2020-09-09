<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perfiles extends CI_Controller {

    public function __construct() {
		parent::__construct();
		if( !(($_SERVER['REMOTE_ADDR']=='40.114.46.42' || $_SERVER['REMOTE_ADDR']=='142.93.196.133') && $this->router->fetch_method()=='ver') ){ //si es el node lo dejo entrar
			$this->login->verify();
		}

		$this->load->model('Perfil');
		$this->load->model('Iniciativa');
	}

	public function index()	{		
		header("Location: ".base_url().'admin/prefiles/listar');
	}
	
	
	public function listar($idiniciativa){		
		$data =Array();
		$data['idiniciativa'] = $idiniciativa;
		$data['iniciativa'] = $this->Iniciativa->getById($idiniciativa);
		if(empty($data['iniciativa'])){
			echo 'no existe'; exit;
		}
		$data['estadisticas'] = $this->Iniciativa->getEstadisticas($idiniciativa);
		$data['lenguajes'] = $this->Lenguaje->getHabilitados('idlenguaje', 'asc');
		$data['estados'] = $this->Perfil->getEstados();
		$data['libs'] = Array('datatables');
        $data['page'] = 'perfil_listar';
		$this->load->view('admin/estruc/estructura', $data);
	}

	public function paginar($idiniciativa){
		$input['idiniciativa'] = $idiniciativa;
		$input['busqueda'] = $this->input->post('sSearch');
		$input['comienzo'] = $this->input->post('iDisplayStart');
		$input['cantidad'] = $this->input->post('iDisplayLength');	
				
		$columnas[0] = 'idperfil';
		$columnas[1] = 'titulo_corto';
		$columnas[2] = 'nombre';
		$columnas[3] = 'email';
		$columnas[4] = 'porcentaje';
		$columnas[5] = 'actualizado';
		$columnas[6] = 'estado';
		$columnas[7] = 'adjunto_pre_propuesta';
		$columnas[8] = 'adjunto_seleccion';
		$columnas[9] = 'idperfil';
		$sort = $this->input->post('iSortCol_0');
		$input['ordenar'] = $columnas[$sort].' '.$this->input->post('sSortDir_0');
		
		
		$output['sEcho'] = $this->input->post('sEcho');
		$output['iTotalRecords'] = $this->Perfil->getTotalRecords(); 
		$output['iTotalDisplayRecords'] = $this->Perfil->getTotalFilteredRecords($input);
		$output['aaData'] = array();
		$datos = $this->Perfil->getPaginated($input);
		foreach($datos as $dat){
			$salida = array();
			$salida[0] = $dat['idperfil'];
			$salida[1] = $dat['titulo_corto'];
			$salida[2] = $dat['nombre'];
			$salida[3] = $dat['email'];
			$salida[4] = $dat['porcentaje'].'%';
			$salida[5] = fromYYYYMMDDtoDDMMYYY($dat['actualizado'], false);
			$salida[6] = $dat['estado'];
			$salida[7] = !empty($dat['adjunto_pre_propuesta']) && !empty($dat['adjunto_pre_presupuesto']) ;
			$salida[8] = !empty($dat['adjunto_seleccion']) ;
			$salida[9] = $dat['idperfil'];
			$output['aaData'][] = $salida;
		}
		echo json_encode($output);
	}


    private function getCleanPerfil($idperfil){
        if(empty($idperfil) || !is_numeric($idperfil)){
            $this->session->set_userdata('error', 'No se encontro al webstory con ID '.$idperfil);
            redirect("admin/perfiles");
        }
        $perfil = $this->Webstory->getById($idperfil);
        if(empty($perfil)){
            $this->session->set_userdata('error', 'No se encontro al webstory con ID '.$idperfil);
            redirect("admin/perfiles");
        }
        return $perfil;
    }

	public function ver($idperfil, $pdf=false){
		$data = Array();
		
		$perfil = $this->Perfil->getById($idperfil);
		if(empty($perfil)){
			redirect(base_url());
		}
		$data['perfil'] = $perfil;
		$codlang = 'es';

		$iniciativa = $this->Iniciativa->getByIdLang($codlang , $perfil['idiniciativa']);

		$data['iniciativa'] = $iniciativa;

		$this->load->model('Info');
		$data['textos'] = $this->Info->obtenerByIndiceLang('es', 'perfil');

		$data['perfil']['ejecutor'] = $this->Perfil->getEjecutorTexto($idperfil);
		$data['perfil']['coejecutor'] = $this->Perfil->getOtrosOrgTexto($idperfil, 'coejecutor');
		$data['perfil']['asociado'] = $this->Perfil->getOtrosOrgTexto($idperfil, 'asociado');

		$data['perfil']['componente'] = $this->Perfil->getComponentes($idperfil);
		$data['perfil']['sector'] = $this->Perfil->getSectorTexto($idperfil);

		$this->load->Model('Badge');
		$data['badges'] = $this->Badge->getAllView();
		$data['perfil']['badgesObtenidas'] = $this->Badge->getByPerfil($idperfil);

		$this->load->model('Estrategica');
		$data['estrategica'] = $this->Estrategica->getById($perfil['linea_estrategica']);
		$this->load->model('Investigacion');
		$data['tipoInvestigacion'] = $this->Investigacion->getById($perfil['tipo_investigacion']);
		$this->load->model('Innovacion');
		$data['tipoInnovacion'] = $this->Innovacion->getById($perfil['tipo_innovacion']);
		$this->load->model('Solucion');
		$data['solucion'] = $this->Solucion->getById($perfil['solucion_tecnologica']);		
					
		
		$this->load->model('Tema');
		$data['temas'] = $this->Tema->getTemasPerfilTexto($idperfil);

		$this->load->model('Usuario');
		$data['usuario'] = $this->Usuario->getById($perfil['idusuario']);

		$data['libs'] = Array('');
		if($pdf){
			$this->load->view('admin/perfil_ver_pdf', $data);
		}else{
			$data['page'] ='perfil_ver';
			$this->load->view('admin/estruc/estructura', $data);
		}

	}


    public function textos(){
		$this->load->model('Info');
		$data['lenguajes'] = $this->Lenguaje->getHabilitados('idlenguaje', 'asc');
		$data['datas_lang'] = array();
		$this->load->helper('form');
		$campos_lang = Array(
			Array('area'=> 'Login', 'tipo'=>'text', 'nombre'=>'perfiles_y_proyectos', 'titulo'=>'Perfiles y Proyectos', 'descripcion'=>'Traducción', 'max'=>30), 
			Array('area'=> 'Login', 'tipo'=>'text', 'nombre'=>'registro', 'titulo'=>'Registro', 'descripcion'=>'Traducción', 'max'=>30), 
			Array('area'=> 'Login', 'tipo'=>'text', 'nombre'=>'login', 'titulo'=>'Login', 'descripcion'=>'Traducción', 'max'=>30), 
			Array('area'=> 'Login', 'tipo'=>'text', 'nombre'=>'email', 'titulo'=>'Email', 'descripcion'=>'Traducción', 'max'=>30), 
			Array('area'=> 'Login', 'tipo'=>'text', 'nombre'=>'password', 'titulo'=>'Contraseña', 'descripcion'=>'Traducción', 'max'=>30), 
			Array('area'=> 'Login', 'tipo'=>'text', 'nombre'=>'ingresar', 'titulo'=>'Ingresar', 'descripcion'=>'Traducción', 'max'=>30), 
			Array('area'=> 'Login', 'tipo'=>'text', 'nombre'=>'no_tiene_cuenta', 'titulo'=>'¿No tiene cuenta?', 'descripcion'=>'Traducción', 'max'=>30), 
			Array('area'=> 'Login', 'tipo'=>'text', 'nombre'=>'olvido', 'titulo'=>'¿Olvido su contraseña?', 'descripcion'=>'Traducción', 'max'=>30), 
			Array('area'=> 'Login', 'tipo'=>'text', 'nombre'=>'sobre_fontagro_perfil', 'titulo'=>'Sobre Fontagro', 'descripcion'=>'Traducción', 'max'=>30), 
			Array('area'=> 'Login', 'tipo'=>'text', 'nombre'=>'proyectos', 'titulo'=>'Proyectos', 'descripcion'=>'Traducción', 'max'=>30), 
			Array('area'=> 'Login', 'tipo'=>'text', 'nombre'=>'modificar_datos', 'titulo'=>'Modificar', 'descripcion'=>'Traducción', 'max'=>30), 

			Array('area'=> 'Login', 'tipo'=>'text', 'nombre'=>'perfiles', 'titulo'=>'Perfiles', 'descripcion'=>'Traducción', 'max'=>100), 
			Array('area'=> 'Login', 'tipo'=>'textarea', 'nombre'=>'perfiles_descripcion', 'titulo'=>'Perfiles Descripción', 'descripcion'=>'Una descripción', 'max'=>500), 
			Array('area'=> 'Login', 'tipo'=>'text', 'nombre'=>'convocatorias', 'titulo'=>'Convocatorias', 'descripcion'=>'Traducción', 'max'=>100), 
			Array('area'=> 'Login', 'tipo'=>'textarea', 'nombre'=>'convocatorias_descripcion', 'titulo'=>'Convocatorias Descripción', 'descripcion'=>'Una descripción', 'max'=>500), 
			Array('area'=> 'Login', 'tipo'=>'text', 'nombre'=>'instructivo', 'titulo'=>'Instructivo', 'descripcion'=>'Traducción', 'max'=>100), 
			Array('area'=> 'Login', 'tipo'=>'textarea', 'nombre'=>'instructivos_descripcion', 'titulo'=>'Instructivos descripción', 'descripcion'=>'Una descripción', 'max'=>500), 
			Array('area'=> 'Login', 'tipo'=>'text', 'nombre'=>'nombre', 'titulo'=>'Nombre y Apellido', 'descripcion'=>'Traducción', 'max'=>100), 
			Array('area'=> 'Login', 'tipo'=>'text', 'nombre'=>'institucion', 'titulo'=>'Institución', 'descripcion'=>'Traducción', 'max'=>100), 
			Array('area'=> 'Login', 'tipo'=>'text', 'nombre'=>'posicion', 'titulo'=>'Posición', 'descripcion'=>'Traducción', 'max'=>100), 
			Array('area'=> 'Login', 'tipo'=>'text', 'nombre'=>'registrarse', 'titulo'=>'Registrarse', 'descripcion'=>'Traducción', 'max'=>100),
			Array('area'=> 'Login', 'tipo'=>'text', 'nombre'=>'notificaciones_mail', 'titulo'=>'Recibir notificaciones por mail', 'descripcion'=>'Traducción', 'max'=>100),  


			Array('area'=> 'Mail Inicial', 'tipo'=>'text', 'nombre'=>'mail_inicial_titulo', 'titulo'=>'Título', 'descripcion'=>'Traducción', 'max'=>100),
			Array('area'=> 'Mail Inicial', 'tipo'=>'text', 'nombre'=>'mail_inicial_subtitulo', 'titulo'=>'Subtitulo', 'descripcion'=>'Traducción', 'max'=>255),
			Array('area'=> 'Mail Inicial', 'tipo'=>'textarea', 'nombre'=>'mail_inicial_descripcion', 'titulo'=>'Descripción', 'descripcion'=>'Traducción', 'max'=>2000),
			Array('area'=> 'Mail Inicial', 'tipo'=>'text', 'nombre'=>'mail_inicial_accion', 'titulo'=>'Acción', 'descripcion'=>'Traducción', 'max'=>60),
			Array('area'=> 'Mail Inicial', 'tipo'=>'text', 'nombre'=>'mail_inicial_aclaracion', 'titulo'=>'Aclaración', 'descripcion'=>'Traducción', 'max'=>255), 

			Array('area'=> 'Recuperar Password', 'tipo'=>'text', 'nombre'=>'recuperar_exito', 'titulo'=>'Se envió mail', 'descripcion'=>'Traducción', 'max'=>500), 
			Array('area'=> 'Recuperar Password', 'tipo'=>'text', 'nombre'=>'recuperar_error', 'titulo'=>'Error', 'descripcion'=>'Traducción', 'max'=>500), 
			Array('area'=> 'Recuperar Password', 'tipo'=>'text', 'nombre'=>'recuperar_nuevo', 'titulo'=>'Nuevo password', 'descripcion'=>'Traducción', 'max'=>100),
			Array('area'=> 'Recuperar Password', 'tipo'=>'text', 'nombre'=>'recuperar_ingrese', 'titulo'=>'Ingrese su email', 'descripcion'=>'Traducción', 'max'=>100),
			Array('area'=> 'Recuperar Password', 'tipo'=>'text', 'nombre'=>'recuperar_mail_titulo', 'titulo'=>'Mail titulo', 'descripcion'=>'Traducción', 'max'=>100), 
			Array('area'=> 'Recuperar Password', 'tipo'=>'text', 'nombre'=>'recuperar_mail_descripcion', 'titulo'=>'Mail Descripción', 'descripcion'=>'Traducción', 'max'=>0), 
			Array('area'=> 'Recuperar Password', 'tipo'=>'text', 'nombre'=>'recuperar_mail_aclaracion', 'titulo'=>'Copie y pegue', 'descripcion'=>'Traducción', 'max'=>500), 
			Array('area'=> 'Recuperar Password', 'tipo'=>'text', 'nombre'=>'recuperar_exito_final', 'titulo'=>'Se reestablecio', 'descripcion'=>'Traducción', 'max'=>500), 
			Array('area'=> 'Recuperar Password', 'tipo'=>'text', 'nombre'=>'recuperar_error_token', 'titulo'=>'Token incorrecto', 'descripcion'=>'Traducción', 'max'=>500),
			Array('area'=> 'Recuperar Password', 'tipo'=>'text', 'nombre'=>'recuperar_error_expirado', 'titulo'=>'Token expirado', 'descripcion'=>'Traducción', 'max'=>500),
			Array('area'=> 'Recuperar Password', 'tipo'=>'text', 'nombre'=>'recuperar_ingrese_nuevo', 'titulo'=>'Ingrese nuevo pass', 'descripcion'=>'Traducción', 'max'=>500), 
	
			Array('area'=> 'Menu', 'tipo'=>'text', 'nombre'=>'mis_datos', 'titulo'=>'Mis Datos', 'descripcion'=>'Traducción', 'max'=>30),
			Array('area'=> 'Menu', 'tipo'=>'text', 'nombre'=>'datos_requeridos', 'titulo'=>'Datos Requeridos', 'descripcion'=>'Traducción', 'max'=>30), 
			Array('area'=> 'Menu', 'tipo'=>'text', 'nombre'=>'volver_perfil', 'titulo'=>'Volver', 'descripcion'=>'Traducción', 'max'=>30), 
			Array('area'=> 'Menu', 'tipo'=>'text', 'nombre'=>'anterior', 'titulo'=>'Anterior', 'descripcion'=>'Traducción', 'max'=>30), 
			Array('area'=> 'Menu', 'tipo'=>'text', 'nombre'=>'guardar', 'titulo'=>'Guardar', 'descripcion'=>'Traducción', 'max'=>30), 
			Array('area'=> 'Menu', 'tipo'=>'text', 'nombre'=>'siguiente', 'titulo'=>'Siguiente', 'descripcion'=>'Traducción', 'max'=>30), 
			Array('area'=> 'Menu', 'tipo'=>'text', 'nombre'=>'notificacion_exito', 'titulo'=>'Éxito al guardar', 'descripcion'=>'Traducción', 'max'=>300), 
			Array('area'=> 'Menu', 'tipo'=>'text', 'nombre'=>'notificacion_error', 'titulo'=>'Error al guardar', 'descripcion'=>'Traducción', 'max'=>300), 
			Array('area'=> 'Menu', 'tipo'=>'text', 'nombre'=>'notificacion_incompleto', 'titulo'=>'Perfil incompleto', 'descripcion'=>'Traducción', 'max'=>300), 
			Array('area'=> 'Menu', 'tipo'=>'text', 'nombre'=>'notificacion_completo', 'titulo'=>'Perfil completo', 'descripcion'=>'Traducción', 'max'=>300), 
			Array('area'=> 'Menu', 'tipo'=>'text', 'nombre'=>'notificacion_tiempo', 'titulo'=>'Tiempo restante', 'descripcion'=>'Traducción', 'max'=>300), 

			Array('area'=> 'Menu', 'tipo'=>'text', 'nombre'=>'paso_1', 'titulo'=>'Paso 1', 'descripcion'=>'Título Paso 1', 'max'=>30), 
			Array('area'=> 'Menu', 'tipo'=>'text', 'nombre'=>'paso_2', 'titulo'=>'Paso 2', 'descripcion'=>'Título Paso 2', 'max'=>30), 
			Array('area'=> 'Menu', 'tipo'=>'text', 'nombre'=>'paso_3', 'titulo'=>'Paso 3', 'descripcion'=>'Título Paso 3', 'max'=>30), 
			Array('area'=> 'Menu', 'tipo'=>'text', 'nombre'=>'paso_4', 'titulo'=>'Paso 4', 'descripcion'=>'Título Paso 4', 'max'=>30), 
			Array('area'=> 'Menu', 'tipo'=>'text', 'nombre'=>'paso_5', 'titulo'=>'Paso 5', 'descripcion'=>'Título Paso 5', 'max'=>30), 
			Array('area'=> 'Menu', 'tipo'=>'text', 'nombre'=>'paso_6', 'titulo'=>'Paso 6', 'descripcion'=>'Título Paso 6', 'max'=>30), 
			Array('area'=> 'Menu', 'tipo'=>'text', 'nombre'=>'paso_7', 'titulo'=>'Paso 7', 'descripcion'=>'Título Paso 7', 'max'=>30), 
			Array('area'=> 'Menu', 'tipo'=>'text', 'nombre'=>'paso_8', 'titulo'=>'Paso 8', 'descripcion'=>'Título Paso 8', 'max'=>30), 
			Array('area'=> 'Menu', 'tipo'=>'text', 'nombre'=>'paso_9', 'titulo'=>'Paso 9', 'descripcion'=>'Título Paso 9', 'max'=>30), 
			Array('area'=> 'Menu', 'tipo'=>'text', 'nombre'=>'menu_mas_info', 'titulo'=>'Mas Info', 'descripcion'=>'Traduccion', 'max'=>30), 

			Array('area'=> 'Paso 0', 'tipo'=>'text', 'nombre'=>'bienvenida', 'titulo'=>'Bienvenida', 'descripcion'=>'Bienvenida a la convocatoria', 'max'=>300), 
			Array('area'=> 'Paso 0', 'tipo'=>'textarea', 'nombre'=>'bienvenida_descripcion', 'titulo'=>'Bienvenida Descripción', 'descripcion'=>'Descripción a la convocatoria', 'max'=>0), 
			Array('area'=> 'Paso 0', 'tipo'=>'textarea', 'nombre'=>'he_leido', 'titulo'=>'He Leído', 'descripcion'=>'He leído el manual', 'max'=>0), 
			Array('area'=> 'Paso 0', 'tipo'=>'text', 'nombre'=>'ver_manual', 'titulo'=>'Ver Manual', 'descripcion'=>'Ver el Manual de operaciones', 'max'=>100), 
			Array('area'=> 'Paso 0', 'tipo'=>'text', 'nombre'=>'link_manual', 'titulo'=>'Link Manual', 'descripcion'=>'Link al Manual de operaciones', 'max'=>100), 
			Array('area'=> 'Paso 0', 'tipo'=>'text', 'nombre'=>'ver_plan', 'titulo'=>'Ver Plan', 'descripcion'=>'Ver el Plan de mediano plazo', 'max'=>100),
			Array('area'=> 'Paso 0', 'tipo'=>'text', 'nombre'=>'link_plan', 'titulo'=>'Link Plan', 'descripcion'=>'Link el Plan de mediano plazo', 'max'=>100),
			Array('area'=> 'Paso 0', 'tipo'=>'text', 'nombre'=>'ver_terminos', 'titulo'=>'Ver Términos', 'descripcion'=>'Ver Términos de referencia', 'max'=>100),
			Array('area'=> 'Paso 0', 'tipo'=>'text', 'nombre'=>'ver_instructivo', 'titulo'=>'Ver Instructivo', 'descripcion'=>'Ver Instructivo de aplicación de perfiles', 'max'=>100),
			Array('area'=> 'Paso 0', 'tipo'=>'text', 'nombre'=>'link_instructivo', 'titulo'=>'Link Instructivo', 'descripcion'=>'Link Instructivo de aplicación de perfiles', 'max'=>100),
			Array('area'=> 'Paso 0', 'tipo'=>'text', 'nombre'=>'debe_aceptar', 'titulo'=>'Debe Aceptar', 'descripcion'=>'Debe aceptar para continuar', 'max'=>100), 

			Array('area'=> 'Paso 1', 'tipo'=>'text', 'nombre'=>'titulo', 'titulo'=>'Título proyecto', 'descripcion'=>'Traducción', 'max'=>100), 
			Array('area'=> 'Paso 1', 'tipo'=>'textarea', 'nombre'=>'titulo_descripcion', 'titulo'=>'Descripción Título proyecto', 'descripcion'=>'Traducción', 'max'=>0),
			Array('area'=> 'Paso 1', 'tipo'=>'text', 'nombre'=>'titulo_corto', 'titulo'=>'Título Corto', 'descripcion'=>'Traducción', 'max'=>100), 
			Array('area'=> 'Paso 1', 'tipo'=>'textarea', 'nombre'=>'titulo_corto_descripcion', 'titulo'=>'Descripción Título Corto', 'descripcion'=>'Traducción', 'max'=>0),
			Array('area'=> 'Paso 1', 'tipo'=>'text', 'nombre'=>'ods', 'titulo'=>'ODS', 'descripcion'=>'Traducción', 'max'=>100),   
			Array('area'=> 'Paso 1', 'tipo'=>'textarea', 'nombre'=>'ods_descripcion', 'titulo'=>'ODS descripcion', 'descripcion'=>'Traducción', 'max'=>0),   
			Array('area'=> 'Paso 1', 'tipo'=>'text', 'nombre'=>'seleccionar', 'titulo'=>'Seleccionar', 'descripcion'=>'Traducción', 'max'=>30), 
			Array('area'=> 'Paso 1', 'tipo'=>'text', 'nombre'=>'linea_estrategica', 'titulo'=>'Línea Estratégica', 'descripcion'=>'Traducción', 'max'=>30), 
			Array('area'=> 'Paso 1', 'tipo'=>'text', 'nombre'=>'tipo_de_innovacion', 'titulo'=>'Tipo de Innovación', 'descripcion'=>'Traducción', 'max'=>30), 
			Array('area'=> 'Paso 1', 'tipo'=>'text', 'nombre'=>'tipo_de_investigacion', 'titulo'=>'Tipo de Investigación', 'descripcion'=>'Traducción', 'max'=>30), 
			Array('area'=> 'Paso 1', 'tipo'=>'text', 'nombre'=>'solucion_tecnologica', 'titulo'=>'Solución Tecnológica', 'descripcion'=>'Traducción', 'max'=>30), 
			Array('area'=> 'Paso 1', 'tipo'=>'text', 'nombre'=>'temas', 'titulo'=>'Temas', 'descripcion'=>'Traducción', 'max'=>30),  
			Array('area'=> 'Paso 1', 'tipo'=>'text', 'nombre'=>'sector_productivo', 'titulo'=>'Sector Productivo', 'descripcion'=>'Traducción', 'max'=>30),  

			Array('area'=> 'Paso 2', 'tipo'=>'text', 'nombre'=>'plataforma', 'titulo'=>'Plataforma', 'descripcion'=>'Traducción', 'max'=>30),
			Array('area'=> 'Paso 2', 'tipo'=>'textarea', 'nombre'=>'plataforma_descripcion', 'titulo'=>'Plataforma Descripción', 'descripcion'=>'Introducción', 'max'=>0),   
			Array('area'=> 'Paso 2', 'tipo'=>'textarea', 'nombre'=>'plataforma_incorporar', 'titulo'=>'Plataforma Incorporar', 'descripcion'=>'Introducción', 'max'=>0),   
			Array('area'=> 'Paso 2', 'tipo'=>'text', 'nombre'=>'organismo_ejecutor', 'titulo'=>'Organismo Ejecutor', 'descripcion'=>'Traducción', 'max'=>30),   
			Array('area'=> 'Paso 2', 'tipo'=>'text', 'nombre'=>'nombre_y_apellido', 'titulo'=>'Nombre y apellido del contacto', 'descripcion'=>'Traducción', 'max'=>30),   
			Array('area'=> 'Paso 2', 'tipo'=>'text', 'nombre'=>'cargo', 'titulo'=>'Cargo', 'descripcion'=>'Traducción', 'max'=>30),   
			Array('area'=> 'Paso 2', 'tipo'=>'text', 'nombre'=>'telefono', 'titulo'=>'Teléfono', 'descripcion'=>'Traducción', 'max'=>30),   
			Array('area'=> 'Paso 2', 'tipo'=>'text', 'nombre'=>'seleccionar_pais', 'titulo'=>'Seleccionar País', 'descripcion'=>'Traducción', 'max'=>30),  
			Array('area'=> 'Paso 2', 'tipo'=>'text', 'nombre'=>'seleccionar_tipo_inst', 'titulo'=>'Seleccionar Tipo Institución', 'descripcion'=>'Traducción', 'max'=>50),  
			Array('area'=> 'Paso 2', 'tipo'=>'text', 'nombre'=>'organismos_coejecutores', 'titulo'=>'Organismos Co-Ejecutores', 'descripcion'=>'Traducción', 'max'=>30),   
			Array('area'=> 'Paso 2', 'tipo'=>'text', 'nombre'=>'seleccione_ejecutor', 'titulo'=>'Seleccione Organismo Ejecutor', 'descripcion'=>'Traducción', 'max'=>60),
			Array('area'=> 'Paso 2', 'tipo'=>'text', 'nombre'=>'seleccione_coejecutor', 'titulo'=>'Seleccione Organismo Co-Ejecutor', 'descripcion'=>'Traducción', 'max'=>60),   
			Array('area'=> 'Paso 2', 'tipo'=>'text', 'nombre'=>'seleccione_asociado', 'titulo'=>'Seleccione Organismo Asociado', 'descripcion'=>'Traducción', 'max'=>60),   
			Array('area'=> 'Paso 2', 'tipo'=>'text', 'nombre'=>'organismo_asociado', 'titulo'=>'Organismos Asociados', 'descripcion'=>'Traducción', 'max'=>30),  
			Array('area'=> 'Paso 2', 'tipo'=>'text', 'nombre'=>'aclaracion_coejecutor', 'titulo'=>'Aclaracion Organismo co-ejecutor', 'descripcion'=>'No mas de 4', 'max'=>0),  
			Array('area'=> 'Paso 2', 'tipo'=>'text', 'nombre'=>'solicitar_nuevo', 'titulo'=>'Solicitar nuevo organismo', 'descripcion'=>'Traducción', 'max'=>30),  
			Array('area'=> 'Paso 2', 'tipo'=>'text', 'nombre'=>'solicitar_descripcion', 'titulo'=>'Nuevo organismo Descripcion', 'descripcion'=>'Aclaración', 'max'=>255),
			Array('area'=> 'Paso 2', 'tipo'=>'text', 'nombre'=>'solicitar_sigla', 'titulo'=>'Sigla', 'descripcion'=>'Traducción', 'max'=>30),  
			Array('area'=> 'Paso 2', 'tipo'=>'text', 'nombre'=>'solicitar_nombre', 'titulo'=>'Nombre completo', 'descripcion'=>'Traducción', 'max'=>30),  
			Array('area'=> 'Paso 2', 'tipo'=>'text', 'nombre'=>'solicitar_link', 'titulo'=>'Link', 'descripcion'=>'Traducción', 'max'=>30),  
			Array('area'=> 'Paso 2', 'tipo'=>'text', 'nombre'=>'solicitar_aclaracion', 'titulo'=>'Aclaración post alta organismo', 'descripcion'=>'Aclaración', 'max'=>255),
			Array('area'=> 'Paso 2', 'tipo'=>'text', 'nombre'=>'enviar', 'titulo'=>'Enviar', 'descripcion'=>'Traducción', 'max'=>30),

			Array('area'=> 'Paso 3', 'tipo'=>'text', 'nombre'=>'monto_solicitado', 'titulo'=>'Monto Solicitado', 'descripcion'=>'Traducción', 'max'=>30),
			Array('area'=> 'Paso 3', 'tipo'=>'textarea', 'nombre'=>'monto_solicitado_descripcion', 'titulo'=>'Monto Solicitado Descripción', 'descripcion'=>'Traducción', 'max'=>0),
			Array('area'=> 'Paso 3', 'tipo'=>'text', 'nombre'=>'monto_contrapartida', 'titulo'=>'Monto Contrapartida', 'descripcion'=>'Traducción', 'max'=>30),
			Array('area'=> 'Paso 3', 'tipo'=>'textarea', 'nombre'=>'monto_contrapartida_descripcion', 'titulo'=>'Monto Contrapartida Descr.', 'descripcion'=>'Traducción', 'max'=>0),
			Array('area'=> 'Paso 3', 'tipo'=>'text', 'nombre'=>'monto_total', 'titulo'=>'Monto Total', 'descripcion'=>'Traducción', 'max'=>30),
			Array('area'=> 'Paso 3', 'tipo'=>'textarea', 'nombre'=>'monto_total_descripcion', 'titulo'=>'Monto Total Descripción', 'descripcion'=>'Traducción', 'max'=>0),
			Array('area'=> 'Paso 3', 'tipo'=>'text', 'nombre'=>'plazo_ejecucion', 'titulo'=>'Plazo Ejecución', 'descripcion'=>'Traducción', 'max'=>30),
			Array('area'=> 'Paso 3', 'tipo'=>'textarea', 'nombre'=>'plazo_ejecucion_descripcion', 'titulo'=>'Plazo Ejecución Descripción', 'descripcion'=>'Traducción', 'max'=>0),

			Array('area'=> 'Paso 4', 'tipo'=>'text', 'nombre'=>'congruencia', 'titulo'=>'Congruencia', 'descripcion'=>'Traducción', 'max'=>30),
			Array('area'=> 'Paso 4', 'tipo'=>'textarea', 'nombre'=>'congruencia_descripcion', 'titulo'=>'Congruencia Descripción', 'descripcion'=>'Traducción', 'max'=>0),
			Array('area'=> 'Paso 4', 'tipo'=>'text', 'nombre'=>'regionalidad', 'titulo'=>'Regionalidad', 'descripcion'=>'Traducción', 'max'=>30),
			Array('area'=> 'Paso 4', 'tipo'=>'textarea', 'nombre'=>'regionalidad_descripcion', 'titulo'=>'Regionalidad Descripción', 'descripcion'=>'Traducción', 'max'=>0),
			Array('area'=> 'Paso 4', 'tipo'=>'text', 'nombre'=>'capacidad', 'titulo'=>'Capacidad', 'descripcion'=>'Traducción', 'max'=>60),
			Array('area'=> 'Paso 4', 'tipo'=>'textarea', 'nombre'=>'capacidad_descripcion', 'titulo'=>'Capacidad Descripción', 'descripcion'=>'Traducción', 'max'=>0),
			Array('area'=> 'Paso 4', 'tipo'=>'text', 'nombre'=>'articulacion', 'titulo'=>'Articulación', 'descripcion'=>'Traducción', 'max'=>60),
			Array('area'=> 'Paso 4', 'tipo'=>'textarea', 'nombre'=>'articulacion_descripcion', 'titulo'=>'Articulación Descripción', 'descripcion'=>'Traducción', 'max'=>0),

			Array('area'=> 'Paso 5', 'tipo'=>'text', 'nombre'=>'impacto', 'titulo'=>'Impacto', 'descripcion'=>'Traducción', 'max'=>60),
			Array('area'=> 'Paso 5', 'tipo'=>'textarea', 'nombre'=>'impacto_descripcion', 'titulo'=>'Impacto Descripción', 'descripcion'=>'Traducción', 'max'=>0),
			Array('area'=> 'Paso 5', 'tipo'=>'text', 'nombre'=>'beneficiarios', 'titulo'=>'Beneficiarios', 'descripcion'=>'Traducción', 'max'=>60),
			Array('area'=> 'Paso 5', 'tipo'=>'textarea', 'nombre'=>'beneficiarios_descripcion', 'titulo'=>'Beneficiarios Descripción', 'descripcion'=>'Traducción', 'max'=>0),

			Array('area'=> 'Paso 6', 'tipo'=>'text', 'nombre'=>'antecedentes', 'titulo'=>'Antecedentes', 'descripcion'=>'Traducción', 'max'=>60),
			Array('area'=> 'Paso 6', 'tipo'=>'textarea', 'nombre'=>'antecedentes_descripcion', 'titulo'=>'Antecedentes Descripción', 'descripcion'=>'Traducción', 'max'=>0),
			Array('area'=> 'Paso 6', 'tipo'=>'text', 'nombre'=>'fin_proyecto', 'titulo'=>'Fin Proyecto', 'descripcion'=>'Traducción', 'max'=>60),
			Array('area'=> 'Paso 6', 'tipo'=>'textarea', 'nombre'=>'fin_proyecto_descripcion', 'titulo'=>'Fin Proyecto Descripción', 'descripcion'=>'Traducción', 'max'=>0),
			Array('area'=> 'Paso 6', 'tipo'=>'text', 'nombre'=>'proposito', 'titulo'=>'Propósito', 'descripcion'=>'Traducción', 'max'=>60),
			Array('area'=> 'Paso 6', 'tipo'=>'textarea', 'nombre'=>'proposito_descripcion', 'titulo'=>'Propósito Descripción', 'descripcion'=>'Traducción', 'max'=>0),

			Array('area'=> 'Paso 7', 'tipo'=>'text', 'nombre'=>'marco_logico', 'titulo'=>'Marco Lógico', 'descripcion'=>'Traducción', 'max'=>30),
			Array('area'=> 'Paso 7', 'tipo'=>'textarea', 'nombre'=>'marco_logico_descripcion', 'titulo'=>'Marco Lógico Descripción', 'descripcion'=>'Traducción', 'max'=>0),
			Array('area'=> 'Paso 7', 'tipo'=>'text', 'nombre'=>'componente', 'titulo'=>'Componente', 'descripcion'=>'Traducción', 'max'=>30),
			Array('area'=> 'Paso 7', 'tipo'=>'text', 'nombre'=>'componente_nombre', 'titulo'=>'Componente Nombre', 'descripcion'=>'Traducción', 'max'=>30),
			Array('area'=> 'Paso 7', 'tipo'=>'textarea', 'nombre'=>'componente_nombre_descripcion', 'titulo'=>'Componente Nombre Descripción', 'descripcion'=>'Traducción', 'max'=>0),
			Array('area'=> 'Paso 7', 'tipo'=>'text', 'nombre'=>'componente_actividad', 'titulo'=>'Componente Actividad', 'descripcion'=>'Traducción', 'max'=>30),
			Array('area'=> 'Paso 7', 'tipo'=>'textarea', 'nombre'=>'componente_actividad_descripcion', 'titulo'=>'Componente Actividad Descripción', 'descripcion'=>'Traducción', 'max'=>0),
			Array('area'=> 'Paso 7', 'tipo'=>'text', 'nombre'=>'componente_producto', 'titulo'=>'Componente producto', 'descripcion'=>'Traducción', 'max'=>30),
			Array('area'=> 'Paso 7', 'tipo'=>'textarea', 'nombre'=>'componente_producto_descripcion', 'titulo'=>'Componente producto Descripción', 'descripcion'=>'Traducción', 'max'=>0),
			Array('area'=> 'Paso 7', 'tipo'=>'text', 'nombre'=>'componente_resultado', 'titulo'=>'Componente Resultado', 'descripcion'=>'Traducción', 'max'=>30),
			Array('area'=> 'Paso 7', 'tipo'=>'textarea', 'nombre'=>'componente_resultado_descripcion', 'titulo'=>'Componente Resultado Descripción', 'descripcion'=>'Traducción', 'max'=>0),
			Array('area'=> 'Paso 7', 'tipo'=>'text', 'nombre'=>'componente_agregar', 'titulo'=>'Agregar Componente', 'descripcion'=>'Traducción', 'max'=>30),
			
			Array('area'=> 'Paso 8', 'tipo'=>'text', 'nombre'=>'evidencia_capacidad', 'titulo'=>'Evidencia Capacidad', 'descripcion'=>'Traducción', 'max'=>60),
			Array('area'=> 'Paso 8', 'tipo'=>'textarea', 'nombre'=>'evidencia_capacidad_descripcion', 'titulo'=>'Evidencia Capacidad Descripción', 'descripcion'=>'Traducción', 'max'=>0),
			Array('area'=> 'Paso 8', 'tipo'=>'text', 'nombre'=>'evidencia_articulacion', 'titulo'=>'Evidencia Articulación', 'descripcion'=>'Traducción', 'max'=>60),
			Array('area'=> 'Paso 8', 'tipo'=>'textarea', 'nombre'=>'evidencia_articulacion_descripcion', 'titulo'=>'Evidencia Articulacián Descripción', 'descripcion'=>'Traducción', 'max'=>0),
			Array('area'=> 'Paso 8', 'tipo'=>'text', 'nombre'=>'evidencia_mecanismos', 'titulo'=>'Evidencia Mecanismos', 'descripcion'=>'Traducción', 'max'=>60),
			Array('area'=> 'Paso 8', 'tipo'=>'textarea', 'nombre'=>'evidencia_mecanismos_descripcion', 'titulo'=>'Evidencia Mecanismos Descripción', 'descripcion'=>'Traducción', 'max'=>0),
			Array('area'=> 'Paso 8', 'tipo'=>'text', 'nombre'=>'evidencia_compromiso', 'titulo'=>'Evidencia Compromiso', 'descripcion'=>'Traducción', 'max'=>0),

			Array('area'=> 'Paso 9', 'tipo'=>'text', 'nombre'=>'adicional_cientifica', 'titulo'=>'Base científica', 'descripcion'=>'Traducción', 'max'=>60),
			Array('area'=> 'Paso 9', 'tipo'=>'textarea', 'nombre'=>'adicional_cientifica_descripcion', 'titulo'=>'Base científica Descripción', 'descripcion'=>'Traducción', 'max'=>0),
			Array('area'=> 'Paso 9', 'tipo'=>'text', 'nombre'=>'adicional_potencial', 'titulo'=>'Potencial de mercado', 'descripcion'=>'Traducción', 'max'=>60),
			Array('area'=> 'Paso 9', 'tipo'=>'textarea', 'nombre'=>'adicional_potencial_descripcion', 'titulo'=>'Potencial de mercado Descripción', 'descripcion'=>'Traducción', 'max'=>0),
			Array('area'=> 'Paso 9', 'tipo'=>'text', 'nombre'=>'adicional_escalamiento', 'titulo'=>'Estrategia de escalamiento', 'descripcion'=>'Traducción', 'max'=>60),
			Array('area'=> 'Paso 9', 'tipo'=>'textarea', 'nombre'=>'adicional_escalamiento_descripcion', 'titulo'=>'Estrategia de escalamiento Descripción', 'descripcion'=>'Traducción', 'max'=>0),
			Array('area'=> 'Paso 9', 'tipo'=>'text', 'nombre'=>'adicional_transferencia', 'titulo'=>'Estrategia de transferencia ', 'descripcion'=>'Traducción', 'max'=>60),
			Array('area'=> 'Paso 9', 'tipo'=>'textarea', 'nombre'=>'adicional_transferencia_descripcion', 'titulo'=>'Estrategia de transferencia Descripción', 'descripcion'=>'Traducción', 'max'=>0),
			Array('area'=> 'Paso 9', 'tipo'=>'text', 'nombre'=>'adicional_riesgos', 'titulo'=>'Posibles Riesgos', 'descripcion'=>'Traducción', 'max'=>60),
			Array('area'=> 'Paso 9', 'tipo'=>'textarea', 'nombre'=>'adicional_riesgos_descripcion', 'titulo'=>'Posibles Riesgos Descripción', 'descripcion'=>			Array('area'=> 'Paso 9', 'tipo'=>'textarea', 'nombre'=>'adicional_pmp_descripcion', 'titulo'=>'Alineamiento al PMP Descripción', 'descripcion'=>'Traducción', 'max'=>0),
'Traducción', 'max'=>0),
			Array('area'=> 'Paso 9', 'tipo'=>'text', 'nombre'=>'adicional_pmp', 'titulo'=>'Alineamiento al PMP de FONTAGRO', 'descripcion'=>'Traducción', 'max'=>60),
			
			Array('area'=> 'Paso 10', 'tipo'=>'text', 'nombre'=>'submit_titulo_exito', 'titulo'=>'Título Exitoso', 'descripcion'=>'Traduccion', 'max'=>300), 
			Array('area'=> 'Paso 10', 'tipo'=>'text', 'nombre'=>'submit_subtitulo_exito', 'titulo'=>'Subtítulo Exitoso', 'descripcion'=>'Traduccion', 'max'=>300), 
			Array('area'=> 'Paso 10', 'tipo'=>'textarea', 'nombre'=>'submit_descripcion_exito', 'titulo'=>'Descripción Exitoso', 'descripcion'=>'Traduccion', 'max'=>0), 
			Array('area'=> 'Paso 10', 'tipo'=>'text', 'nombre'=>'submit_titulo_error', 'titulo'=>'Título Incompleto', 'descripcion'=>'Traduccion', 'max'=>300), 
			Array('area'=> 'Paso 10', 'tipo'=>'text', 'nombre'=>'submit_subtitulo_error', 'titulo'=>'Subtítulo Incompleto', 'descripcion'=>'Traduccion', 'max'=>300), 
			Array('area'=> 'Paso 10', 'tipo'=>'textarea', 'nombre'=>'submit_descripcion_error', 'titulo'=>'Descripción Incompleto', 'descripcion'=>'Traduccion', 'max'=>0), 
			Array('area'=> 'Paso 10', 'tipo'=>'text', 'nombre'=>'submit_boton', 'titulo'=>'Finalizar Botón', 'descripcion'=>'Texto del botón', 'max'=>30), 
			//Array('area'=> 'Paso 10', 'tipo'=>'text', 'nombre'=>'submit_error', 'titulo'=>'Error al enviar', 'descripcion'=>'Error al enviar', 'max'=>300), 

			Array('area'=> 'Preseleccion', 'tipo'=>'text', 'nombre'=>'paso_1_preseleccion', 'titulo'=>'Paso 1 preselección', 'descripcion'=>'Descripcion ', 'max'=>50), 
			Array('area'=> 'Preseleccion', 'tipo'=>'text', 'nombre'=>'paso_2_preseleccion', 'titulo'=>'Paso 2 preselección', 'descripcion'=>'Descripcion ', 'max'=>50), 
			Array('area'=> 'Preseleccion', 'tipo'=>'textarea', 'nombre'=>'perfil_adjunto_propuesta', 'titulo'=>'Adjunto propuesta', 'descripcion'=>'Descripcion archivo propuesta', 'max'=>0), 
			Array('area'=> 'Preseleccion', 'tipo'=>'textarea', 'nombre'=>'perfil_adjunto_presupuesto', 'titulo'=>'Adjunto presupuesto', 'descripcion'=>'Descripcion archivo presupuesto', 'max'=>0),
			Array('area'=> 'Preseleccion', 'tipo'=>'textarea', 'nombre'=>'submit_descripcion_exito_pre', 'titulo'=>'Descripción Exitoso', 'descripcion'=>'Traduccion', 'max'=>0), 
			Array('area'=> 'Preseleccion', 'tipo'=>'textarea', 'nombre'=>'submit_descripcion_error_pre', 'titulo'=>'Descripción Incompleto', 'descripcion'=>'Traduccion', 'max'=>0), 

			Array('area'=> 'Seleccion', 'tipo'=>'text', 'nombre'=>'paso_1_seleccion', 'titulo'=>'Paso 1 selección', 'descripcion'=>'Descripcion ', 'max'=>50), 
			Array('area'=> 'Seleccion', 'tipo'=>'textarea', 'nombre'=>'perfil_adjunto_seleccion', 'titulo'=>'Adjunto Selección', 'descripcion'=>'Descripcion archivo propuesta', 'max'=>0), 
			Array('area'=> 'Seleccion', 'tipo'=>'textarea', 'nombre'=>'submit_descripcion_exito_sel', 'titulo'=>'Descripción Exitoso', 'descripcion'=>'Traduccion', 'max'=>0), 
			Array('area'=> 'Seleccion', 'tipo'=>'textarea', 'nombre'=>'submit_descripcion_error_sel', 'titulo'=>'Descripción Incompleto', 'descripcion'=>'Traduccion', 'max'=>0), 
			
		);
		if (!empty($_POST)){      
			$campos = Array('twitter', 'vimeo', 'youtube', 'linkedin');

			foreach($campos as $campo){
				$valor = $this->input->post($campo);
				$this->Info->actualizar('ni', $campo, $valor, 'all');
			}
									
			foreach($data['lenguajes'] as $lenguaje){	
				foreach($campos_lang as $campol){			
					$valor = $this->input->post($campol['nombre'].'_'.$lenguaje->codlang);
					$this->Info->actualizar($lenguaje->codlang, $campol['nombre'], $valor, 'perfil');
				}
			}

            
		}
		$data['campos_lang']=$campos_lang;
		$data['readonly'] = TRUE;
		$data['infos'] = $this->Info->obtenerByIndice('perfil');
		$data['libs'] = Array();
        $data['page'] = 'perfil_textos';
        $this->load->view('admin/estruc/estructura', $data);        
	}
	
	public function crearAlerta(){
		$idiniciativa = $this->input->post('idiniciativa');
		$iniciativa = $this->Iniciativa->getById($idiniciativa);
		if(empty($iniciativa)){
			echo 'No existe la iniciativa'; 
			exit;
		}
		$quienes = $this->input->post('quienes');
		$titulo = $this->input->post('titulo');
		$contenido = $this->input->post('contenido');
		if(empty($quienes) || empty($titulo) || empty($contenido)){
			echo 'Faltan campos'; 
			exit;
		}
		$this->load->library('Utilidades');
		$a_quienes = 'todos';
		if($quienes==2){
			$a_quienes = 'completo';
		}else if($quienes==3){
			$a_quienes = 'incompleto';
		}else if($quienes==4){
			$a_quienes = 'inicial';
		}else if($quienes==5){
			$a_quienes = 'preseleccionado';
		}else if($quienes==6){
			$a_quienes = 'seleccionado';
		}
		$this->utilidades->crearAlerta($titulo, $contenido, base_url().'iniciativas', 'personalizada_'.$a_quienes, TRUE, $idiniciativa);
				
		echo '1'; 		
	}

	public function descargar($idiniciativa){
		$data = $this->Perfil->getDownload($idiniciativa);
		$this->download_send_headers("data_export_".date("Y-m-d-H-i-s").".csv");
		echo $this->array2csv($data);
		die();
	}

	private function array2csv(array &$array){
		if (count($array) == 0) {
			return null;
		}
		ob_start();
		$df = fopen("php://output", 'w');
		fputcsv($df, array_keys(reset($array)));
		foreach ($array as $row) {
			fputcsv($df, $row);
		}
		fclose($df);
		return ob_get_clean();
	}

	private function download_send_headers($filename) {
		// disable caching
		
	    $ctype="application/vnd.ms-excel";

	    //Begin writing headers
	    header("Pragma: public");
	    header("Expires: 0");
	    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	    header("Cache-Control: public");
	    header("Content-Description: File Transfer");
	   
	    //Use the switch-generated Content-Type
	    header("Content-Type: $ctype");

	    //Force the download
	    $header="Content-Disposition: attachment; filename=".$filename.";";
	    header($header );
	    header("Content-Transfer-Encoding: binary");
	    //header("Content-Length: ".$len);
	}

	public function descargarResumen($idiniciativa){
		$perfiles = $this->Perfil->getDownloadResumen($idiniciativa);
		//print_r($unidad);
		$data = Array();
		foreach($perfiles as $perfil){
			$dataPer = Array();
			$row = Array(
				'ID Perfil' => $perfil['identificador'].$perfil['idperfil'], 
				'Titulo Corto'=>$perfil['titulo_corto'],
				'Monto solicitado'=>$perfil['monto'],
				'Monto de Contrapartida	'=>$perfil['monto_contrapartida'],
				'Monto Total'=>$perfil['monto_total'],
				'Plazo de Ejecución (meses)'=>$perfil['plazo'],
				'Organismo Ejecutor' => '',
				'Organismo Ejecutor Nombre' => '',
				'Organismo Ejecutor Email' => '',
				'Organismo Ejecutor Teléfono' => '',
				'Organismo Ejecutor País' => '',
				'Organismo Coejecutor' => '',
				'Organismo Coejecutor Nombre' => '',
				'Organismo Coejecutor Email' => '',
				'Organismo Coejecutor Teléfono' => '',
				'Organismo Coejecutor País' => '',
				'Organismo Asociado' => '',
				'Organismo Asociado Nombre' => '',
				'Organismo Asociado Email' => '',
				'Organismo Asociado Teléfono' => '',
				'Organismo Asociado País' => ''
			);
			$ejecutor = $this->Perfil->getEjecutorTexto($perfil['idperfil']);
			if(!empty($ejecutor)){
				$row['Organismo Ejecutor'] = $ejecutor['organismo'];
				$row['Organismo Ejecutor Nombre'] = $ejecutor['nombre_contacto'];
				$row['Organismo Ejecutor Email'] = $ejecutor['email_contacto'];
				$row['Organismo Ejecutor Teléfono'] = $ejecutor['telefono_contacto'];
				$row['Organismo Ejecutor País'] = $ejecutor['pais'];
			}
			$dataPer[] = $row;
			$coejecutores = $this->Perfil->getOtrosOrgTexto($perfil['idperfil'], 'coejecutor');
			$i = 0;
			foreach($coejecutores as $coejecutor){
				if(empty($dataPer[$i])){
					$row = Array(
						'ID Perfil' => '', 
						'Titulo Corto'=>'',
						'Monto solicitado'=>'',
						'Monto de Contrapartida	'=>'',
						'Monto Total'=>'',
						'Plazo de Ejecución (meses)'=>'',
						'Organismo Ejecutor' => '',
						'Organismo Ejecutor Nombre' => '',
						'Organismo Ejecutor Email' => '',
						'Organismo Ejecutor Teléfono' => '',
						'Organismo Ejecutor País' => '',
						'Organismo Coejecutor' => '',
						'Organismo Coejecutor Nombre' => '',
						'Organismo Coejecutor Email' => '',
						'Organismo Coejecutor Teléfono' => '',
						'Organismo Coejecutor País' => '',
						'Organismo Asociado' => '',
						'Organismo Asociado Nombre' => '',
						'Organismo Asociado Email' => '',
						'Organismo Asociado Teléfono' => '',
						'Organismo Asociado País' => ''
					);
					$dataPer[] = $row;
				}
				$dataPer[$i]['Organismo Coejecutor'] = $coejecutor['organismo'];
				$dataPer[$i]['Organismo Coejecutor Nombre'] = $coejecutor['nombre_contacto'];
				$dataPer[$i]['Organismo Coejecutor Email'] = $coejecutor['email_contacto'];
				$dataPer[$i]['Organismo Coejecutor Teléfono'] = $coejecutor['telefono_contacto'];
				$dataPer[$i]['Organismo Coejecutor País'] = $coejecutor['pais'];
				$i++;
			}
			$asociados = $this->Perfil->getOtrosOrgTexto($perfil['idperfil'], 'asociado');
			$i = 0;
			foreach($asociados as $asociado){
				if(empty($dataPer[$i])){
					$row = Array(
						'ID Perfil' => '', 
						'Titulo Corto'=>'',
						'Monto solicitado'=>'',
						'Monto de Contrapartida	'=>'',
						'Monto Total'=>'',
						'Plazo de Ejecución (meses)'=>'',
						'Organismo Ejecutor' => '',
						'Organismo Ejecutor Nombre' => '',
						'Organismo Ejecutor Email' => '',
						'Organismo Ejecutor Teléfono' => '',
						'Organismo Ejecutor País' => '',
						'Organismo Coejecutor' => '',
						'Organismo Coejecutor Nombre' => '',
						'Organismo Coejecutor Email' => '',
						'Organismo Coejecutor Teléfono' => '',
						'Organismo Coejecutor País' => '',
						'Organismo Asociado' => '',
						'Organismo Asociado Nombre' => '',
						'Organismo Asociado Email' => '',
						'Organismo Asociado Teléfono' => '',
						'Organismo Asociado País' => ''
					);
					$dataPer[] = $row;
				}
				$dataPer[$i]['Organismo Asociado'] = $asociado['organismo'];
				$dataPer[$i]['Organismo Asociado Nombre'] = $asociado['nombre_contacto'];
				$dataPer[$i]['Organismo Asociado Email'] = $asociado['email_contacto'];
				$dataPer[$i]['Organismo Asociado Teléfono'] = $asociado['telefono_contacto'];
				$dataPer[$i]['Organismo Asociado País'] = $asociado['pais'];
				$i++;
			}
			$data = array_merge($data, $dataPer);
		}
		$this->download_send_headers("data_export_".date("Y-m-d-H-i-s").".csv");
		echo $this->array2csv($data);
		die();
	}

	public function cambiarEstado(){
		$idestado = $this->input->post('idestado');
		$idperfil = $this->input->post('idperfil');
		if(!is_numeric($idestado) || !is_numeric($idperfil)){
			return;
		}
		$this->Perfil->cambiarEstado($idperfil, $idestado);
	}

	function descargarPropuesta($idperfil){
		$perfil = $this->Perfil->getById($idperfil);

		if(empty($perfil) || empty($perfil['adjunto_pre_propuesta'])){
			echo 'Archivo no encontrado';
		}
		$path = file_get_contents('./uploads/perfiles/'.$perfil['adjunto_pre_propuesta']);
		$this->load->helper('download');
		force_download($perfil['adjunto_pre_propuesta'], $path);
	}

	function descargarPresupuesto($idperfil){
		$perfil = $this->Perfil->getById($idperfil);

		if(empty($perfil) || empty($perfil['adjunto_pre_presupuesto'])){
			echo 'Archivo no encontrado';
		}
		$path = file_get_contents('./uploads/perfiles/'.$perfil['adjunto_pre_presupuesto']);
		$this->load->helper('download');
		force_download($perfil['adjunto_pre_presupuesto'], $path);
	}

	function descargarSeleccion($idperfil){
		$perfil = $this->Perfil->getById($idperfil);

		if(empty($perfil) || empty($perfil['adjunto_seleccion'])){
			echo 'Archivo no encontrado';
		}
		$path = file_get_contents('./uploads/perfiles/'.$perfil['adjunto_seleccion']);
		$this->load->helper('download');
		force_download($perfil['adjunto_seleccion'], $path);
	}
		
	function select($search){
		$retorno = array('results'=>array());
		$retorno['pagination'] = array('more'=>false);
		if(strlen($search)>0){
			$perfiles = $this->Perfil->buscarSelect($search);
			$retorno['results'] = $perfiles;
		}
		echo json_encode($retorno);
	}
}
?>
