<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Istas extends CI_Controller {

    public function __construct() {
		parent::__construct();
		if( !($_SERVER['REMOTE_ADDR']=='40.114.46.42' && $this->router->fetch_method()=='ver') ){ //si es el node lo dejo entrar
			$this->login->verify();
		}

		$this->load->model('Ista');
		$this->load->model('Callista');
		$this->load->model('Propuesta');
	}

	public function index()	{		
		header("Location: ".base_url().'admin/istas/seleccion');
	}
	
	
	public function listar($idcallista){		
		$data =Array();
		$data['idcallista'] = $idcallista;
		$data['callista'] = $this->Callista->getById($idcallista);
		if(empty($data['callista'])){
			echo 'no existe'; exit;
		}
		$data['estadisticas'] = $this->Callista->getEstadisticas($idcallista);
		$data['lenguajes'] = $this->Lenguaje->getHabilitados('idlenguaje', 'asc');
		$data['libs'] = Array('datatables');
        $data['page'] = 'ista_listar';
		$this->load->view('admin/estruc/estructura', $data);
	}

	public function paginar($idcallista){
		$input['idcallista'] = $idcallista;
		$input['busqueda'] = $this->input->post('sSearch');
		$input['comienzo'] = $this->input->post('iDisplayStart');
		$input['cantidad'] = $this->input->post('iDisplayLength');	
				
		$columnas[0] = 'idista';
		$columnas[1] = 'identificador';
		$columnas[2] = 'porcentaje';
		$columnas[3] = 'actualizado';
		$columnas[4] = 'enviado';
		$columnas[5] = 'idcallista';
		$sort = $this->input->post('iSortCol_0');
		$input['ordenar'] = $columnas[$sort].' '.$this->input->post('sSortDir_0');
		
		
		$output['sEcho'] = $this->input->post('sEcho');
		$output['iTotalRecords'] = $this->Ista->getTotalRecords(); 
		$output['iTotalDisplayRecords'] = $this->Ista->getTotalFilteredRecords($input);
		$output['aaData'] = array();
		$datos = $this->Ista->getPaginated($input);
		foreach($datos as $dat){
			$salida = array();
			$salida[0] = $dat['idista'];
			$salida[1] = $dat['identificador'].' - '.$dat['titulo_simple'];
			$salida[2] = $dat['porcentaje'].'%';
			$salida[3] = fromYYYYMMDDtoDDMMYYY($dat['actualizado'], false);
			$salida[4] = empty($dat['enviado'])? '': fromYYYYMMDDtoDDMMYYY($dat['enviado'], false);
			$salida[5] = $dat['idista'];
			$output['aaData'][] = $salida;
		}
		echo json_encode($output);
	}

    public function seleccion(){
		$data = Array();
		$codlang = $this->obtenerLang();
		$data['callistas'] = $this->Callista->getAbiertas($codlang, $this->session->userdata('idusuario'));
		
		$data['libs'] = Array('');
        $data['page'] = 'ista_seleccion';
		$this->load->view('admin/estruc/estructura', $data);
	}


    private function getCleanPropuesta($idpropuesta){
        if(empty($idpropuesta) || !is_numeric($idpropuesta)){
            $this->session->set_userdata('error', 'No se encontro al propuesta con ID '.$idpropuesta);
            redirect("admin/istas/seleccion");
        }
        $propuesta = $this->Propuesta->getById($idpropuesta);
        if(empty($propuesta)){
            $this->session->set_userdata('error', 'No se encontro al propuesta con ID '.$idpropuesta);
            redirect("admin/istas/seleccion");
        }
		if(!$this->Propuesta->tengoPermiso($idpropuesta)){
			$this->session->set_userdata('error', 'No tiene permisos para modificar ese proyecto');
            redirect("admin/istas/seleccion");
		}
        return $propuesta;
	}	
	
	public function ver($idista, $pdf=false){
		$data = Array();
		$codlang = $this->obtenerLang();
		$data['codlang'] = $codlang;
			

		$ista = $this->Ista->getById($idista);
		if(empty($ista)){
			redirect(base_url().'admin/istas/seleccion');
		}
		$data['ista'] = $ista;

		$data['propuesta'] = $this->getCleanPropuesta($ista['idpropuesta']); 

		$callista = $this->Callista->getByIdLang($codlang, $ista['idcallista']);

		$data['callista'] = $callista;
		$data['falta'] = $this->falta($callista['falta'], $codlang);

		$this->load->model('Usuario');
		$data['usuarios'] = $this->Usuario->getByPropuesta($ista['idpropuesta']);


		$this->load->model('Info');
		$data['textos'] = $this->Info->obtenerByIndiceLang($codlang, 'ista');

		$data['rechazos'] = $this->Ista->getRechazos($idista);
		
		$data['porcentajes'] = $this->calcularPorcentaje($data['ista']);
		$i=0;
		for($i=0; $i<6; $i++){
			if($data['porcentajes']['paso'.$i]['cantidad'] > $data['porcentajes']['paso'.$i]['completados']){
				break;
			}
		}
        $data['paso'] = $i;
		$data['libs'] = Array();
		if($pdf){
			$this->load->view('admin/ista_ver_pdf', $data);
		}else{
			$data['page'] ='ista_ver';
			$this->load->view('admin/estruc/estructura', $data);
		}
	}

	public function pasos($idcallista, $idpropuesta){
		$data = Array();
		$codlang = $this->obtenerLang();
		$data['codlang'] = $codlang;

		if(!$this->Callista->sigueAbierta($idcallista)){
			redirect(base_url().'admin/istas/seleccion');
		}

		$data['propuesta'] = $this->getCleanPropuesta($idpropuesta); //por permisos
		
		$idista = $this->Ista->obtenerId($idcallista, $idpropuesta);

		$ista = $this->Ista->getById($idista);
		if(empty($ista)){
			redirect(base_url().'admin/istas/seleccion');
		}
		$data['ista'] = $ista;

		$callista = $this->Callista->getByIdLang($codlang, $idcallista);

		$data['callista'] = $callista;
		$data['falta'] = $this->falta($callista['falta'], $codlang);

		$this->load->model('Info');
		$data['textos'] = $this->Info->obtenerByIndiceLang($codlang, 'ista');
		
		$data['porcentajes'] = $this->calcularPorcentaje($data['ista']);
		$i=0;
		for($i=0; $i<6; $i++){
			if($data['porcentajes']['paso'.$i]['cantidad'] > $data['porcentajes']['paso'.$i]['completados']){
				break;
			}
		}
        $data['paso'] = $i;
		$data['libs'] = Array();
        $data['page'] = 'pasos';
		$this->load->view('istas/estruc/estructura', $data);
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
		redirect("admin/istas/seleccion");
	}
	
	public function testSaving(){		
		$retorno = Array('error' => '');
		$idista = $this->input->post('idista');
		if(!$this->Callista->sigueAbierta($idista)){
			$retorno['error'] = 'cerrada';
			echo json_encode($retorno);
			exit;
		}
		$ista = $this->Ista->getById($idista); //por permisos
		$data['propuesta'] = $this->getCleanPropuesta($ista['idpropuesta']); //por permisos

		$idusuario = $this->session->userdata('idusuario');
		$campos = $this->campos();
		$datos = $this->input->post(array_keys($campos));
		$xtras = Array();
		
		$retorno['porcentajes'] = $this->calcularPorcentaje(array_merge($datos, $xtras));
		$xtras['porcentajes'] = $retorno['porcentajes'];
		$pudo = $this->Ista->actualizar($idista, $idusuario, $datos, $xtras);
		if(empty($pudo)){
			$retorno['error'] = 'cerrada';
			echo json_encode($retorno);
			exit;
		}
		echo json_encode($retorno);
		exit;
	}

	private function campos(){
		return Array(
			'leyo_manual' => Array('paso'=>0, 'obligatorio'=>true), 
			'investigador' => Array('paso'=>1, 'obligatorio'=>true), 
			'objetivo' => Array('paso'=>1, 'obligatorio'=>true), 
			'resumen_ejecutivo' => Array('paso'=>2, 'obligatorio'=>true), 
			'resultados' => Array('paso'=>2, 'obligatorio'=>true), 
			'productos' => Array('paso'=>2, 'obligatorio'=>true), 
			'hallazgos' => Array('paso'=>3, 'obligatorio'=>true), 
			'innovaciones' => Array('paso'=>3, 'obligatorio'=>true), 
			'historias' => Array('paso'=>4, 'obligatorio'=>true), 
			'oportunidades' => Array('paso'=>4, 'obligatorio'=>true), 
			'articulacion' => Array('paso'=>5, 'obligatorio'=>true), 
			'gestion' => Array('paso'=>5, 'obligatorio'=>true)	, 
			'adjunto' => Array('paso'=>6, 'obligatorio'=>true)		
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
			'paso6'=> Array('cantidad'=>0, 'completados'=>0)
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
	
		return $porcentajes;
		
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
		$idista = $this->input->post('idista');

		$idista = $this->input->post('idista');
		if(!$this->Callista->sigueAbierta($idista)){
			$retorno['error'] = 'cerrada';
			echo json_encode($retorno);
			exit;
		}
		$ista = $this->Ista->getById($idista); //por permisos
		$data['propuesta'] = $this->getCleanPropuesta($ista['idpropuesta']); //por permisos

		$this->Ista->terminar($idista);

		$this->load->library('Utilidades');
		$this->utilidades->crearAlerta('Propuesta: '.substr($ista['titulo_simple'], 0, 25).'...', 'Se encuentra pendiente de revisión el ISTA', base_url().'admin/istas/ver/'.$idista, 'contenidos');
				
	}

	public function multipleTabs(){
		$tabID = $this->input->post('tabID');
		$idusuario = $this->session->userdata('idusuario');
		$this->load->model('Usuario');
		echo $this->Usuario->checkTabsIsta($idusuario, $tabID);
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
			$config['upload_path']          = './uploads/istas/';
			$config['allowed_types']        = 'xls|xlsx|xml|odt';
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

	function descargarAdjunto($idista){
		$ista = $this->Ista->getById($idista);
		$data['propuesta'] = $this->getCleanPropuesta($ista['idpropuesta']); //por permisos

		if(empty($ista['adjunto'])){
			echo 'Archivo no encontrado';
		}
		$path = file_get_contents('./uploads/istas/'.$ista['adjunto']);
		$this->load->helper('download');
		force_download($ista['adjunto'], $path);
	}


	public function descargar($idcallista){
		$data = $this->Ista->getDownload($idcallista);
		//print_r($data); exit;
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
	
	public function crearAlerta(){
		$idcallista = $this->input->post('idcallista');
		$callista = $this->Callista->getById($idcallista);
		if(empty($callista)){
			echo 'No existe la idcallista'; 
			exit;
		}
		$quienes = $this->input->post('quienes');
		$titulo = $this->input->post('titulo');
		$contenido = $this->input->post('contenido');
		if(empty($titulo) || empty($contenido)){
			echo 'Faltan campos'; 
			exit;
		}
		$this->load->library('Utilidades');
		$a_quienes = 'todos';
		/*if($quienes==2){
			$a_quienes = 'completo';
		}else if($quienes==3){
			$a_quienes = 'incompleto';
		}*/
		$this->utilidades->crearAlerta($titulo, $contenido, base_url().'admin', 'istas_'.$a_quienes, TRUE, $idcallista);
				
		echo '1'; 		
	}

	public function rechazar(){
		$idista = $this->input->post('idista');
		$motivo = $this->input->post('motivo');
		$ista = $this->Ista->getById($idista);	
		if(empty($idista) || empty($motivo) || empty($ista)){
			echo 'Faltan campos'; 
			exit;
		}
		$this->Ista->rechazar($idista, $motivo);
		$this->load->model('Usuario');
		$usuarios = $this->Usuario->getByPropuesta($ista['idpropuesta']);

		$this->load->library('Utilidades');		
		
		$datos = Array(
			'propuesta' => $ista['titulo_simple'],
			'motivo' =>  $motivo
		);
		
		foreach($usuarios as $usuario){			
			$this->utilidades->enviarEmailIstaRechazado($datos, $usuario);			
		}
				
		echo '1'; 		
	}
}
?>
