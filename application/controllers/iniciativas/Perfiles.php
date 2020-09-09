<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*cuando ambos (perfil e iniciativa) están en la etapa 'pre-seleccion' puede cargar 2 adjuntos (propuesta y presupuesto). 
Cuando ambos, perfil e iniciativa, están en el estado "seleccionado" y "propuesta" respectivamente pueden cargar el 3er adjunto*/
class Perfiles extends CI_Controller {

    public function __construct() {
		parent::__construct();
		$this->login->verify();

		$this->load->model('Perfil');
		$this->load->model('Iniciativa');
	}

	public function index()	{		
		header("Location: ".base_url().'iniciativas/perfiles/principal');
	}
	
    public function principal(){
		$data = Array();
		$codlang = $this->obtenerLang();
		$data['iniciativas'] = $this->Iniciativa->getAbiertas($codlang, $this->session->userdata('idusuario'));
		if(count($data['iniciativas'])==1 && !empty($data['iniciativas'][0]['idperfil'])){ //Si hay solo una iniciativa abierta y estoy inscripto, no muestro el dashboard y voy a la carga
			redirect('iniciativas/perfiles/pasos/'.$data['iniciativas'][0]['idperfil']);
		}
		$data['cerradas'] = $this->Iniciativa->getParticipo($codlang, $this->session->userdata('idusuario'));
		$this->load->model('Info');
		$data['textos'] = $this->Info->obtenerByIndiceLang($codlang, 'perfil');
		$data['libs'] = Array('');
        $data['page'] = 'principal';
		$this->load->view('iniciativas/estruc/estructura', $data);
	}
	
    public function misdatos(){
		$data = Array();
		$this->load->model('Usuario');
		$codlang = $this->obtenerLang();
		$idusuario = $this->session->userdata('idusuario');
		$data['usuario'] = $this->Usuario->getById($idusuario);

		if (!empty($_POST)) {
			$usuario = array();
			$usuario['email'] = Array('val'=>$this->input->post('username'), 'req'=>TRUE);		
			
			$pass =$this->input->post('password');
			if(!empty($pass)){
				$usuario['password'] = Array('val'=> $this->login->hashPass($pass), 'req'=>TRUE);
			}			
			
			$usuario['institucion'] = Array('val'=>$this->input->post('institucion'), 'req'=>TRUE);
			$usuario['posicion'] = Array('val'=>$this->input->post('posicion'), 'req'=>TRUE);
			$usuario['nombre'] = Array('val'=>$this->input->post('nombre'), 'req'=>TRUE);

			$alerta_mail = (isset($_POST['alerta_mail']) && $_POST['alerta_mail']=='on')? 1 : 0;
			$usuario['alerta_mail'] = Array('val'=>$alerta_mail, 'req'=>FALSE);	
			
            $result = $this->Usuario->insertOrUpdate($idusuario, $usuario);					
			if($result && is_numeric($result)){
				redirect("iniciativas/perfiles/principal");
			}else{
				$data['error'] = $result;			
			}			
		}

		$this->load->model('Info');
		$data['textos'] = $this->Info->obtenerByIndiceLang($codlang, 'perfil');

		$data['libs'] = Array('');
        $data['page'] = 'misdatos';
		$this->load->view('iniciativas/estruc/estructura', $data);
	}

	public function anotarse(){
		$retorno = array('error'=>'');
		$idiniciativa = $this->input->post('idiniciativa');
		$iniciativa = $this->Iniciativa->getById($idiniciativa);
		if(empty($iniciativa)){
			$retorno['error'] = 'No existe';
			echo json_encode($retorno);
			exit;
		}
		$idusuario = $this->session->userdata('idusuario');
		if($iniciativa['idoperacion']==1){
			$idperfil = $this->Perfil->crear($idusuario, $idiniciativa, $iniciativa['idoperacion']);
			$retorno['url'] = base_url().'iniciativas/perfiles/pasos/'.$idperfil;
			echo json_encode($retorno);
			exit; 
		}
		$retorno['error'] = 'Ocurrió un error';
		echo json_encode($retorno);
		exit;
	}

	public function pasos($idperfil){
		$data = Array();
		$codlang = $this->obtenerLang();
		$data['codlang'] = $codlang;
		
		$perfil = $this->Perfil->getById($idperfil);
		if(empty($perfil)){
			redirect(base_url().'iniciativas/perfiles/principal');
		}
		if($perfil['idusuario'] != $this->session->userdata('idusuario')){
			redirect(base_url().'iniciativas/perfiles/principal');
		}
		if(!empty($perfil['enviado'])){
			redirect(base_url().'iniciativas/perfiles/principal');
		}
		if(!$this->Iniciativa->sigueAbierta($idperfil)){
			redirect(base_url().'iniciativas/perfiles/principal');
		}
		$data['perfil'] = $perfil;

		$iniciativa = $this->Iniciativa->getByIdLang($codlang, $perfil['idiniciativa']);
		$data['iniciativa'] = $iniciativa;
		$data['falta'] = $this->falta($iniciativa['falta'], $codlang);

		$this->load->model('Info');
		$data['textos'] = $this->Info->obtenerByIndiceLang($codlang, 'perfil');

		$data['perfil']['ejecutor'] = $this->Perfil->getEjecutor($idperfil);
		$data['perfil']['coejecutor'] = $this->Perfil->getOtrosOrg($idperfil, 'coejecutor');
		$data['perfil']['asociado'] = $this->Perfil->getOtrosOrg($idperfil, 'asociado');

		$data['perfil']['componente'] = $this->Perfil->getComponentes($idperfil);
		$data['perfil']['sector'] = $this->Perfil->getSector($idperfil);

		$this->load->Model('Badge');
		$data['badges'] = $this->Badge->getAllView();
		$data['perfil']['badgesObtenidas'] = $this->Badge->getByPerfil($idperfil);

		$this->load->model('Estrategica');
		$data['estrategica'] = $this->Estrategica->getAllByLang($codlang, 'nombre', 'asc');
		$this->load->model('Investigacion');
		$data['tipoInvestigacion'] = $this->Investigacion->getAllByLang($codlang, 'nombre', 'asc');
		$this->load->model('Innovacion');
		$data['tipoInnovacion'] = $this->Innovacion->getAllByLang($codlang, 'nombre', 'asc');
		$this->load->model('Solucion');
		$data['solucion'] = $this->Solucion->getAllByLang($codlang, 'nombre', 'asc');		
		$this->load->model('Sector');
		$data['sectores'] = $this->Sector->getAllByLang($codlang, 'nombre', 'asc');		
		$this->load->model('Subsector');
		$data['subsectores'] = $this->Subsector->getAllByLang($codlang, 'nombre', 'asc');	
		$data['perfil']['subsectorSelect'] = $this->Subsector->getSubsectorPerfil($idperfil);
		
		$this->load->model('Organismo');
		$data['organismos'] = $this->Organismo->getAllView('nombre', 'asc');
		$this->load->model('Pais');
		$data['paises'] = $this->Pais->getAllView('nombre', 'asc');	
		$this->load->model('Institucion');
		$data['tipo_institucion'] = $this->Institucion->getAllByLang($codlang, 'nombre', 'asc');	
		
		$this->load->model('Tema');
		$data['temas'] = $this->Tema->getAllByLang($codlang, 'nombre', 'asc');
		$data['perfil']['temasSelect'] = $this->Tema->getTemasPerfil($idperfil);
		
		$data['porcentajes'] = $this->calcularPorcentaje($data['perfil']);
		$i=0;
		for($i=0; $i<9; $i++){
			if($data['porcentajes']['paso'.$i]['cantidad'] > $data['porcentajes']['paso'.$i]['completados']){
				break;
			}
		}
        $data['paso'] = $i;
		$data['libs'] = Array('');
        $data['page'] = 'pasos';
		$this->load->view('iniciativas/estruc/estructura', $data);
	}
	
	private function obtenerLang(){
		$codlang = $this->session->userdata('codlang');
		if($codlang!='en'){ //si esta vacio o no es ingles, es español
			$codlang = 'es';
		}
		return $codlang;
	}

	public function cambiarIdioma($codlang){
		if($codlang!='en'){ //si esta vacio o no es ingles, es español
			$codlang = 'es';
		}
		$this->session->set_userdata('codlang', $codlang);
		$this->load->model('Usuario');
		$this->Usuario->cambiarIdioma($this->session->userdata('codlang'), $codlang);
		redirect("iniciativas/perfiles/principal");
	}
	
	public function testSaving(){		
		$retorno = Array('error' => '');
		$idperfil = $this->input->post('idperfil');
		if(!$this->Iniciativa->sigueAbierta($idperfil)){
			$retorno['error'] = 'cerrada';
			echo json_encode($retorno);
			exit;
		}
		$idusuario = $this->session->userdata('idusuario');
		$campos = $this->campos();
		$datos = $this->input->post(array_keys($campos));
		$datos['monto_total'] = $datos['monto'] + $datos['monto_contrapartida'];
		$xtras = Array();
		$xtras['badgesObtenidas'] =  $this->input->post('ods');
		$xtras['temasSelect'] =  $this->input->post('idtemas');
		$xtras['ejecutor'] =  $this->input->post('ejecutor');
		$xtras['coejecutor'] =  $this->input->post('coejecutor');
		$xtras['asociado'] =  $this->input->post('asociado');
		$xtras['componente'] =  $this->input->post('componente');
		$xtras['sector'] =  $this->input->post('sector');
		$xtras['subsectorSelect'] =  $this->input->post('idsubsectores');
		$retorno['porcentajes'] = $this->calcularPorcentaje(array_merge($datos, $xtras));
		$xtras['porcentajes'] = $retorno['porcentajes'];
		$this->Perfil->actualizar($idperfil, $idusuario, $datos, $xtras);
		echo json_encode($retorno);
		exit;
	}

	private function campos(){
		return Array(
			'leyo_manual' => Array('paso'=>0, 'obligatorio'=>true), 
			'titulo' => Array('paso'=>1, 'obligatorio'=>true), 
			'titulo_corto' => Array('paso'=>1, 'obligatorio'=>true), 
			'linea_estrategica' => Array('paso'=>1, 'obligatorio'=>true), 
			'tipo_innovacion' => Array('paso'=>1, 'obligatorio'=>true), 
			'tipo_investigacion' => Array('paso'=>1, 'obligatorio'=>true), 
			'solucion_tecnologica' => Array('paso'=>1, 'obligatorio'=>true), 
			'monto' => Array('paso'=>3, 'obligatorio'=>true), 
			'monto_contrapartida' => Array('paso'=>3, 'obligatorio'=>true), 
			'plazo' => Array('paso'=>3, 'obligatorio'=>true), 
			'congruencia' => Array('paso'=>4, 'obligatorio'=>true), 
			'regionalidad' => Array('paso'=>4, 'obligatorio'=>true), 
			'capacidad' => Array('paso'=>4, 'obligatorio'=>true), 
			'articulacion' => Array('paso'=>4, 'obligatorio'=>true), 
			'impacto' => Array('paso'=>5, 'obligatorio'=>true), 
			'beneficiarios' => Array('paso'=>5, 'obligatorio'=>true), 
			'antecedentes' => Array('paso'=>6, 'obligatorio'=>true), 
			'fin_proyecto' => Array('paso'=>6, 'obligatorio'=>true), 
			'proposito' => Array('paso'=>6, 'obligatorio'=>true), 
			'marco_logico' => Array('paso'=>7, 'obligatorio'=>true), 
			'evidencia_capacidad' => Array('paso'=>8, 'obligatorio'=>true), 
			'evidencia_compromiso' => Array('paso'=>8, 'obligatorio'=>true), 
			'evidencia_articulacion' => Array('paso'=>8, 'obligatorio'=>true), 
			'evidencia_mecanismos' => Array('paso'=>8, 'obligatorio'=>true), 
			'adicional_cientifica' => Array('paso'=>9, 'obligatorio'=>true), 
			'adicional_potencial' => Array('paso'=>9, 'obligatorio'=>true), 
			'adicional_escalamiento' => Array('paso'=>9, 'obligatorio'=>true), 
			'adicional_transferencia' => Array('paso'=>9, 'obligatorio'=>true), 
			'adicional_riesgos' => Array('paso'=>9, 'obligatorio'=>true), 
			'adicional_pmp' => Array('paso'=>9, 'obligatorio'=>true)
		);
	}
	
	private function calcularPorcentaje($perfil){
		$porcentajes = Array(
			'total'=> Array('cantidad'=>0, 'completados'=>0),
			'paso0'=> Array('cantidad'=>0, 'completados'=>0),
			'paso1'=> Array('cantidad'=>0, 'completados'=>0),
			'paso2'=> Array('cantidad'=>0, 'completados'=>0),
			'paso3'=> Array('cantidad'=>0, 'completados'=>0),
			'paso4'=> Array('cantidad'=>0, 'completados'=>0),
			'paso5'=> Array('cantidad'=>0, 'completados'=>0),
			'paso6'=> Array('cantidad'=>0, 'completados'=>0),
			'paso7'=> Array('cantidad'=>0, 'completados'=>0),
			'paso8'=> Array('cantidad'=>0, 'completados'=>0),
			'paso9'=> Array('cantidad'=>0, 'completados'=>0)
		);

		$campos = $this->campos();
		$completado = 0;
		foreach($campos as $key=>$val){
			if($val['obligatorio']){
				$porcentajes['total']['cantidad']++;
				$porcentajes['paso'.$val['paso']]['cantidad']++;
				if(!empty($perfil[$key]) && $perfil[$key]!='0.0000' ){
					$porcentajes['total']['completados']++;
					$porcentajes['paso'.$val['paso']]['completados']++;
				} 
			}
		}
		$porcentajes['total']['cantidad']++;
		$porcentajes['paso1']['cantidad']++;
		if(!empty($perfil['badgesObtenidas'])){ 
			$porcentajes['total']['completados']++;
			$porcentajes['paso1']['completados']++;
		}
		$porcentajes['total']['cantidad']++;
		$porcentajes['paso1']['cantidad']++;
		if(!empty($perfil['temasSelect'])){ 
			$porcentajes['total']['completados']++;
			$porcentajes['paso1']['completados']++;
		}


		$porcentajes['total']['cantidad']++;
		$porcentajes['paso1']['cantidad']++;
		if(!empty($perfil['sector'])){ 
			foreach($perfil['sector'] as $orden => $sector){
				if(!empty($sector['idsector'])){
					$porcentajes['total']['completados']++;
					$porcentajes['paso1']['completados']++;
					break;
				}
			}			
		}

		$porcentajes['total']['cantidad']++;
		$porcentajes['paso2']['cantidad']++;
		if(!empty($perfil['ejecutor'])){ 
			if($this->orgCompleto($perfil['ejecutor'])){
				$porcentajes['total']['completados']++;
				$porcentajes['paso2']['completados']++;
			}
		}
		$porcentajes['total']['cantidad']++;
		$porcentajes['paso2']['cantidad']++;
		if(!empty($perfil['coejecutor'])){ 
			foreach($perfil['coejecutor'] as $orden => $coejecutor){
				if($orden>1 && !empty($coejecutor['idorganismo'])){ //al roden 1 ya lo sumo arriba xq es el obligatorio
					$porcentajes['total']['cantidad']++;
					$porcentajes['paso2']['cantidad']++;
				}
				if($this->orgCompleto($coejecutor)){
					$porcentajes['total']['completados']++;
					$porcentajes['paso2']['completados']++;
				}
			}			
		}
		
		if(!empty($perfil['asociado'])){ 
			foreach($perfil['asociado'] as $orden => $asociado){
				if(!empty($asociado['idorganismo'])){
					$porcentajes['total']['cantidad']++;
					$porcentajes['paso2']['cantidad']++;
				}
				if($this->orgCompleto($asociado)){
					$porcentajes['total']['completados']++;
					$porcentajes['paso2']['completados']++;
				}
			}			
		}


		$porcentajes['total']['cantidad']++;
		$porcentajes['paso7']['cantidad']++;
		if(!empty($perfil['componente'])){ 
			foreach($perfil['componente'] as $orden => $componente){
				if($orden>1 && !empty($componente['nombre'])){ //al roden 1 ya lo sumo arriba xq es el obligatorio
					$porcentajes['total']['cantidad']++;
					$porcentajes['paso7']['cantidad']++;
				}
				if($this->compCompleto($componente)){
					$porcentajes['total']['completados']++;
					$porcentajes['paso7']['completados']++;
				}
			}			
		}
		return $porcentajes;
		
	}

	private function orgCompleto($org){
		$email = isset($org['email_contacto'])? $org['email_contacto'] : $org['email'];
		if(empty($org['idorganismo']) || empty($org['idpais']) || 
			(empty($org['nombre_contacto']) && empty($org['nombre']))|| 
			(empty($org['cargo_contacto']) && empty($org['cargo'])) || 
			(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL) ) || 
			(empty($org['telefono_contacto']) && empty($org['telefono']))  ){
			return false;
		}
		return true;
	}

	private function compCompleto($com){
		if(empty($com['nombre']) || 
			empty($com['actividad']) || empty($com['producto']) || 	empty($com['resultado'])  ){
			return false;
		}
		return true;
	}

	public function agregarOrganismo(){
		if (!empty($_POST)){
			$this->load->model('OrganismoSugerido');        
			$organismo = array(); 
			$organismo['idpais'] = Array('val'=>$this->input->post('idpais'), 'req'=>TRUE);
			$organismo['nombre'] = Array('val'=>$this->input->post('nombre'), 'req'=>TRUE);
			$organismo['nombre_largo'] = Array('val'=>$this->input->post('nombre_largo'), 'req'=>TRUE);
			$organismo['link'] = Array('val'=>$this->input->post('link'), 'req'=>TRUE);
			$organismo['tipo_institucion'] = Array('val'=>$this->input->post('tipo_institucion'), 'req'=>TRUE);
			$idusuario = $this->session->userdata('idusuario');
			$organismo['idusuario'] = Array('val'=>$idusuario, 'req'=>TRUE);			
            
            $result = $this->OrganismoSugerido->insertOrUpdate(0, $organismo);
            if($result && is_numeric($result)){		
				$this->load->library('Utilidades');
				$this->utilidades->crearAlerta('Nuevo Organismo Sugerido', 'Se encuentra pendiente de moderación el organismo '.$organismo['nombre']['val'].' - '.$organismo['nombre_largo']['val'], base_url().'admin/organismosugeridos/listar', 'nuevo_organismo');
				echo ''; 
				exit;
            }else{
				echo $result;
				exit;
            }
        }
	}

	private function falta($total, $codlang){
		$diaTxt = ($codlang=='en')? 'days':'días';
		$horTxt = ($codlang=='en')? 'hours':'horas';
		$minTxt = ($codlang=='en')? 'minutes':'minutos';
		$segsXdia = 86400;
		$segsXhora = 3600;
		$segsXMin = 60;
		$faltantes = Array();
		$faltantes['dias'] = floor($total/$segsXdia);
		$total = $total - $faltantes['dias'] * $segsXdia;
		$faltantes['horas'] = floor($total/$segsXhora);
		$total = $total - $faltantes['horas'] * $segsXhora;
		$faltantes['min'] = floor($total/$segsXMin);
		$total = $total - $faltantes['min'] * $segsXMin;
		$faltantes['seg'] = $total;
		$faltantes['txt'] = $faltantes['dias'].' '.$diaTxt.', '.$faltantes['horas'].' '.$horTxt.', '.$faltantes['min'].' '.$minTxt;
		return $faltantes;
	}


	public function terminar(){
		$idperfil = $this->input->post('idperfil');
		$idusuario = $this->session->userdata('idusuario');
		$this->Perfil->terminar($idperfil, $idusuario);
	}

	public function multipleTabs(){
		$tabID = $this->input->post('tabID');
		$idusuario = $this->session->userdata('idusuario');
		$this->load->model('Usuario');
		echo $this->Usuario->checkTabs($idusuario, $tabID);
	}


	public function preseleccionado($idperfil){
		$data = Array();
		$codlang = $this->obtenerLang();
		$data['codlang'] = $codlang;
		
		$perfil = $this->Perfil->getById($idperfil);
		if(empty($perfil)){
			redirect(base_url().'iniciativas/perfiles/principal');
		}
		if($perfil['idusuario'] != $this->session->userdata('idusuario')){
			redirect(base_url().'iniciativas/perfiles/principal');
		}
		
		$iniciativa = $this->Iniciativa->getByIdLang($codlang, $perfil['idiniciativa']);
		if($iniciativa['idestadoreal']!=2){
			redirect(base_url().'iniciativas/perfiles/principal');
		}
		$data['perfil'] = $perfil;
		$data['iniciativa'] = $iniciativa;
		$data['falta'] = $this->falta($iniciativa['falta_preseleccion'], $codlang);

		$this->load->model('Info');
		$data['textos'] = $this->Info->obtenerByIndiceLang($codlang, 'perfil');

		
		$data['porcentajes'] = $this->calcularPorcentajePreseleccion($data['perfil']);
		$i=1;
		for($i=1; $i<3; $i++){
			if($data['porcentajes']['paso'.$i]['cantidad'] > $data['porcentajes']['paso'.$i]['completados']){
				break;
			}
		}
        $data['paso'] = $i;
		$data['libs'] = Array('');
        $data['page'] = 'preseleccion';
		$this->load->view('iniciativas/estruc/estructura', $data);
	}
	
	private function camposPreseleccion(){
		return Array(			
			'adjunto_pre_propuesta' => Array('paso'=>1, 'obligatorio'=>true),
			'adjunto_pre_presupuesto' => Array('paso'=>2, 'obligatorio'=>true)			
		);
	}
	
	private function calcularPorcentajePreseleccion($perfil){
		$porcentajes = Array(
			'total'=> Array('cantidad'=>0, 'completados'=>0),
			'paso1'=> Array('cantidad'=>0, 'completados'=>0),
			'paso2'=> Array('cantidad'=>0, 'completados'=>0),
		);

		$campos = $this->camposPreseleccion();
		$completado = 0;
		foreach($campos as $key=>$val){
			if($val['obligatorio']){
				$porcentajes['total']['cantidad']++;
				$porcentajes['paso'.$val['paso']]['cantidad']++;
				if(!empty($perfil[$key])){
					$porcentajes['total']['completados']++;
					$porcentajes['paso'.$val['paso']]['completados']++;
				} 
			}
		}	

		return $porcentajes;		
	}
	
	public function preseleccionSaving(){		
		$retorno = Array('error' => '');
		$idperfil = $this->input->post('idperfil');
		if(!$this->Iniciativa->sigueAbiertaPre($idperfil)){
			$retorno['error'] = 'cerrada';
			echo json_encode($retorno);
			exit;
		}
		$idusuario = $this->session->userdata('idusuario');
		$campos = $this->camposPreseleccion();
		$datos = $this->input->post(array_keys($campos));
		$xtras = Array();		
		$retorno['porcentajes'] = $this->calcularPorcentajePreseleccion(array_merge($datos, $xtras));
		$xtras['porcentajes'] = $retorno['porcentajes'];
		$this->Perfil->actualizarPre($idperfil, $idusuario, $datos, $xtras);
		echo json_encode($retorno);
		exit;
	}

	public function adjuntar(){
		if(!empty($_POST)){
			$retUpload = $this->do_upload('file');
			if(empty($retUpload['imagen'])){
				if(!empty($retUpload['error'])){
					echo $retUpload['error'];
				}else{
					echo 'Debe seleccionar un archivo';
				}
				exit;
			}	
			echo 'ok';
			echo '***'.$retUpload['imagen'].'***';
		}
	}

	private function do_upload($campo) {
		$retorno = Array('error'=>'', 'imagen'=>'');
		if (isset($_FILES[$campo]) && is_uploaded_file($_FILES[$campo]['tmp_name'])) {
			$config['upload_path']          = './uploads/perfiles/';
			$config['allowed_types']        = 'xls|xlsx|xml|doc|docx|odt';
			$config['max_size']             = 10000; //en kb

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

	function descargarPropuesta($idperfil){
		$perfil = $this->Perfil->getById($idperfil);

		if(empty($perfil) || empty($perfil['adjunto_pre_propuesta']) || $perfil['idusuario']!=$this->session->userdata('idusuario')){
			echo 'Archivo no encontrado';
		}
		$path = file_get_contents('./uploads/perfiles/'.$perfil['adjunto_pre_propuesta']);
		$this->load->helper('download');
		force_download($perfil['adjunto_pre_propuesta'], $path);
	}

	function descargarPresupuesto($idperfil){
		$perfil = $this->Perfil->getById($idperfil);

		if(empty($perfil) || empty($perfil['adjunto_pre_presupuesto']) || $perfil['idusuario']!=$this->session->userdata('idusuario')){
			echo 'Archivo no encontrado';
		}
		$path = file_get_contents('./uploads/perfiles/'.$perfil['adjunto_pre_presupuesto']);
		$this->load->helper('download');
		force_download($perfil['adjunto_pre_presupuesto'], $path);
	}

	function descargarSelecionado($idperfil){
		$perfil = $this->Perfil->getById($idperfil);

		if(empty($perfil) || empty($perfil['adjunto_seleccion']) || $perfil['idusuario']!=$this->session->userdata('idusuario')){
			echo 'Archivo no encontrado';
		}
		$path = file_get_contents('./uploads/perfiles/'.$perfil['adjunto_seleccion']);
		$this->load->helper('download');
		force_download($perfil['adjunto_seleccion'], $path);
	}

	public function seleccionado($idperfil){
		$data = Array();
		$codlang = $this->obtenerLang();
		$data['codlang'] = $codlang;
		
		$perfil = $this->Perfil->getById($idperfil);
		if(empty($perfil)){
			redirect(base_url().'iniciativas/perfiles/principal');
		}
		if($perfil['idusuario'] != $this->session->userdata('idusuario')){
			redirect(base_url().'iniciativas/perfiles/principal');
		}
		
		$iniciativa = $this->Iniciativa->getByIdLang($codlang, $perfil['idiniciativa']);
		if($iniciativa['idestadoreal']!=3){
			redirect(base_url().'iniciativas/perfiles/principal');
		}
		$data['perfil'] = $perfil;
		$data['iniciativa'] = $iniciativa;

		$this->load->model('Info');
		$data['textos'] = $this->Info->obtenerByIndiceLang($codlang, 'perfil');

		
		$data['porcentajes'] = $this->calcularPorcentajeSeleccion($data['perfil']);
		$i=1;
		for($i=1; $i<2; $i++){
			if($data['porcentajes']['paso'.$i]['cantidad'] > $data['porcentajes']['paso'.$i]['completados']){
				break;
			}
		}
        $data['paso'] = $i;
		$data['libs'] = Array('');
        $data['page'] = 'seleccion';
		$this->load->view('iniciativas/estruc/estructura', $data);
	}
	
	private function camposSeleccion(){
		return Array(			
			'adjunto_seleccion' => Array('paso'=>1, 'obligatorio'=>true)		
		);
	}
	
	private function calcularPorcentajeSeleccion($perfil){
		$porcentajes = Array(
			'total'=> Array('cantidad'=>0, 'completados'=>0),
			'paso1'=> Array('cantidad'=>0, 'completados'=>0),
		);

		$campos = $this->camposSeleccion();
		$completado = 0;
		foreach($campos as $key=>$val){
			if($val['obligatorio']){
				$porcentajes['total']['cantidad']++;
				$porcentajes['paso'.$val['paso']]['cantidad']++;
				if(!empty($perfil[$key])){
					$porcentajes['total']['completados']++;
					$porcentajes['paso'.$val['paso']]['completados']++;
				} 
			}
		}	

		return $porcentajes;		
	}
	
	public function seleccionSaving(){		
		$retorno = Array('error' => '');
		$idperfil = $this->input->post('idperfil');
		if(!$this->Iniciativa->sigueAbiertaSel($idperfil)){
			$retorno['error'] = 'cerrada';
			echo json_encode($retorno);
			exit;
		}
		$idusuario = $this->session->userdata('idusuario');
		$campos = $this->camposSeleccion();
		$datos = $this->input->post(array_keys($campos));
		$xtras = Array();		
		$retorno['porcentajes'] = $this->calcularPorcentajeSeleccion(array_merge($datos, $xtras));
		$xtras['porcentajes'] = $retorno['porcentajes'];
		$this->Perfil->actualizarSel($idperfil, $idusuario, $datos, $xtras);
		echo json_encode($retorno);
		exit;
	}
}
?>
