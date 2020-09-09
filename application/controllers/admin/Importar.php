<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Importar extends CI_Controller {

    public function __construct() {
		parent::__construct();
		$this->login->verify();

		$this->load->model('Propuesta');

		$this->load->model('Item');
       
		$this->load->model('Tecnica');
	}

	public function index()	{		
		header("Location: ".base_url().'admin/importar/listar');
	}
	

	public function desdearchivo(){		

		$data['errores'] = array();
		$data['cargados'] = 0;
        $this->load->helper('form');
		include './application/libraries/PHPExcel/Classes/PHPExcel/IOFactory.php';
		
		$objPHPExcel = PHPExcel_IOFactory::load('./uploads/tmp/BaseFinanciera.xls');
		$proyectos = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
		$idpropuesta = 0;
		for($i=2; $i<=sizeof($proyectos); $i++){
			if(empty($proyectos[$i]['A'])){
				if(empty($proyectos[$i]['C'])){
					continue;
				}
				$item = array();
				$item['idpropuesta'] = Array('val'=>$idpropuesta, 'req'=>TRUE);
				$item['organismo'] = Array('val'=>utf8_encode($proyectos[$i]['N']), 'req'=>TRUE);
				
				$item['aporte_fontagro'] = Array('val'=>$this->solo_numeros($proyectos[$i]['T']), 'req'=>FALSE);
				$item['aporte_bid'] = Array('val'=>$this->solo_numeros($proyectos[$i]['U']), 'req'=>FALSE);
				$item['movilizacion_agencias'] = Array('val'=>$this->solo_numeros($proyectos[$i]['V']), 'req'=>FALSE);
				$item['aporte_contrapartida'] = Array('val'=>$this->solo_numeros($proyectos[$i]['W']), 'req'=>FALSE);
				$item['aporte_agencias'] = Array('val'=>$this->solo_numeros($proyectos[$i]['X']), 'req'=>FALSE);
				$item['total'] = Array('val'=>$this->solo_numeros($proyectos[$i]['Y']), 'req'=>FALSE);

				$participacion = utf8_encode(trim($proyectos[$i]['O']));
				$item['d_participacion'] = Array('val'=>$participacion, 'req'=>FALSE);
				$this->load->model('Participacion');
				$iditem = $this->Participacion->getByNombre($participacion);				
				$item['participacion'] = Array('val'=>$iditem, 'req'=>FALSE);

				$institucion = utf8_encode(trim($proyectos[$i]['P']));
				$item['d_tipo_institucion'] = Array('val'=>$institucion, 'req'=>FALSE);
				$this->load->model('Institucion');
				$iditem = $this->Institucion->getByNombre($institucion);				
				$item['tipo_institucion'] = Array('val'=>$iditem, 'req'=>FALSE);

				$region = utf8_encode(trim($proyectos[$i]['R']));
				$item['d_region'] = Array('val'=>$region, 'req'=>FALSE);
				$this->load->model('Region');
				$iditem = $this->Region->getByNombre($region);				
				$item['region'] = Array('val'=>$iditem, 'req'=>FALSE);

				$pais = utf8_encode(trim($proyectos[$i]['Q']));
				$item['d_pais'] = Array('val'=>$pais, 'req'=>FALSE);
				$this->load->model('Pais');
				$iditem = $this->Pais->getByNombre($pais);				
				$item['pais'] = Array('val'=>$iditem, 'req'=>FALSE);

				/*$datas_lang = array();
				$paquete_lang= array();
				$paquete_lang['pais'] =utf8_encode($proyectos[$i]['Q']);
				$datas_lang['es'] = $paquete_lang;*/

				$result = $this->Item->insertOrUpdate(0, $item);
				if($result && is_numeric($result)){
					//$this->Item->insertOrUpdateLanguage($result, $datas_lang);
					$data['cargados']++;
					continue;
				}else{
					$data['errores'][] = 'Error al intentar cargar a '.$i.' '.$result;
				}	
				
			}else{
				$proy = array();
				$proy['identificador'] = Array('val'=>str_replace(' ', '',$proyectos[$i]['A']), 'req'=>TRUE);
				$proy['anio'] = Array('val'=>utf8_encode($proyectos[$i]['B']), 'req'=>TRUE);

				$estado = utf8_encode(trim($proyectos[$i]['C']));
				$proy['d_estado'] = Array('val'=>$estado, 'req'=>FALSE);
				$this->load->model('Estado');
				$idestado = $this->Estado->getByNombre($estado);				
				$proy['estado'] = Array('val'=>$idestado, 'req'=>FALSE);

				$operacion = utf8_encode(trim($proyectos[$i]['G']));
				$proy['d_operacion'] = Array('val'=>$operacion, 'req'=>FALSE);
				$this->load->model('Operacion');
				$idoperacion = $this->Operacion->getByNombre($operacion);				
				$proy['operacion'] = Array('val'=>$idoperacion, 'req'=>FALSE);

				$linea_estrategica = utf8_encode(trim($proyectos[$i]['J']));
				$proy['d_linea_estrategica'] = Array('val'=>$linea_estrategica, 'req'=>FALSE);
				$this->load->model('Estrategica');
				$idestrategica = $this->Estrategica->getByNombre($linea_estrategica);				
				$proy['linea_estrategica'] = Array('val'=>$idestrategica, 'req'=>FALSE);

				$tipo_investigacion = utf8_encode(trim($proyectos[$i]['K']));
				$proy['d_tipo_investigacion'] = Array('val'=>$tipo_investigacion, 'req'=>FALSE);
				$this->load->model('Investigacion');
				$idinvestigacion = $this->Investigacion->getByNombre($tipo_investigacion);				
				$proy['tipo_investigacion'] = Array('val'=>$idinvestigacion, 'req'=>FALSE);

				$tipo_innovacion = utf8_encode(trim($proyectos[$i]['L']));
				$proy['d_tipo_innovacion'] = Array('val'=>$tipo_innovacion, 'req'=>FALSE);
				$this->load->model('Innovacion');
				$idtipo_innovacion = $this->Innovacion->getByNombre($tipo_innovacion);				
				$proy['tipo_innovacion'] = Array('val'=>$idtipo_innovacion, 'req'=>FALSE);

				$solucion_tecnologica = utf8_encode(trim($proyectos[$i]['M']));
				$proy['d_solucion_tecnologica'] = Array('val'=>$solucion_tecnologica, 'req'=>FALSE);
				$this->load->model('Solucion');
				$idsolucion_tecnologica = $this->Solucion->getByNombre($solucion_tecnologica);				
				$proy['solucion_tecnologica'] = Array('val'=>$idsolucion_tecnologica, 'req'=>FALSE);

				$proy['aporte_fontagro'] = Array('val'=>$this->solo_numeros($proyectos[$i]['T']), 'req'=>FALSE);
				$proy['aporte_bid'] = Array('val'=>$this->solo_numeros($proyectos[$i]['U']), 'req'=>FALSE);
				$proy['movilizacion_agencias'] = Array('val'=>$this->solo_numeros($proyectos[$i]['V']), 'req'=>FALSE);
				$proy['aporte_contrapartida'] = Array('val'=>$this->solo_numeros($proyectos[$i]['W']), 'req'=>FALSE);
				$proy['aporte_agencias'] = Array('val'=>$this->solo_numeros($proyectos[$i]['X']), 'req'=>FALSE);
				$proy['total'] = Array('val'=>$this->solo_numeros($proyectos[$i]['Y']), 'req'=>FALSE);

				$datas_lang = array();
				$paquete_lang= array();
				$paquete_lang['titulo_completo'] = utf8_encode($proyectos[$i]['D']);
				$paquete_lang['titulo_simple'] = utf8_encode($proyectos[$i]['E']);
				$paquete_lang['area_investigacion'] = utf8_encode($proyectos[$i]['H']);
				$paquete_lang['rubro'] = utf8_encode($proyectos[$i]['I']);
				$paquete_lang['otras_agencias'] = utf8_encode($proyectos[$i]['S']);
				$paquete_lang['plataforma'] = utf8_encode($proyectos[$i]['F']);
				$datas_lang['es'] = $paquete_lang;
				
				$result = $this->Propuesta->insertOrUpdate(0, $proy);
				if($result && is_numeric($result)){
					$idpropuesta = $result;
					$this->Propuesta->insertOrUpdateLanguage($result, $datas_lang);
					$data['cargados']++;
					continue;
				}else{
					$data['errores'][] = 'Error al intentar cargar a '.$i.' '.$result;
				}	
			}				
		}

		echo '<pre>';
		print_r($data);

	}


	public function fromfile(){		

		$data['errores'] = array();
		$data['cargados'] = 0;
        $this->load->helper('form');
		include './application/libraries/PHPExcel/Classes/PHPExcel/IOFactory.php';
		
		$objPHPExcel = PHPExcel_IOFactory::load('./uploads/tmp/FinancialDatabase.xls');
		$proyectos = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
		$idpropuesta = 0;
		$id = 0;
		for($i=2; $i<=sizeof($proyectos); $i++){
			if(empty($proyectos[$i]['A'])){
				if(empty($proyectos[$i]['C'])){
					continue;
				}
				$id++;
				$datas_lang = array();
				$paquete_lang= array();
				$paquete_lang['pais'] =utf8_encode($proyectos[$i]['Q']);
				$datas_lang['en'] = $paquete_lang;

				//$this->Item->insertOrUpdateLanguage($id, $datas_lang);
				$data['cargados']++;
				continue;			
				
			}else{				
				$datas_lang = array();
				$paquete_lang= array();
				$paquete_lang['titulo_completo'] = utf8_encode($proyectos[$i]['D']);
				$paquete_lang['titulo_simple'] = utf8_encode($proyectos[$i]['E']);
				$paquete_lang['area_investigacion'] = utf8_encode($proyectos[$i]['H']);
				$paquete_lang['rubro'] = utf8_encode($proyectos[$i]['I']);
				$paquete_lang['otras_agencias'] = utf8_encode($proyectos[$i]['S']);
				$paquete_lang['plataforma'] = utf8_encode($proyectos[$i]['F']);
				$paquete_lang['solucion_tecnologica'] = utf8_encode($proyectos[$i]['M']);
				$datas_lang['en'] = $paquete_lang;
				$identificador = str_replace(' ', '',$proyectos[$i]['A']);
				$result = $this->Propuesta->getByIdentificador($identificador);
				if(!empty($result)){
					$idpropuesta = $result;
					$this->Propuesta->insertOrUpdateLanguage($result, $datas_lang);
					$data['cargados']++;
					continue;
				}else{
					$data['errores'][] = 'Error al intentar cargar a '.$i.' '.$result;
				}	
			}				
		}

		echo '<pre>';
		print_r($data);

	}

	private function solo_numeros($val){
		$res = preg_replace('/[^0-9.]/', '', $val);
		if(empty($res)) return 0;
		return $res;
	}

	private function do_upload($campo) {
		$retorno = Array('error'=>'', 'imagen'=>'');
		if (isset($_FILES[$campo]) && is_uploaded_file($_FILES[$campo]['tmp_name'])) {
			$config['upload_path']          = './uploads/tmp/';
			$config['allowed_types']        = '*';
			$config['max_size']             = 10000; //en kb

			$this->load->library('upload', $config);

			if (!$this->upload->do_upload($campo)){			
				$retorno['error'] = $this->upload->display_errors();
				echo $retorno['error']; exit;
			}else{			
				$uploadData = $this->upload->data();
				$retorno['imagen'] = $uploadData['file_name'];	
			}
		}
		return $retorno;
    }



	

	public function desdearchivoTecnica(){		

		$data['errores'] = array();
		$data['cargados'] = 0;
        $this->load->helper('form');
		include './application/libraries/PHPExcel/Classes/PHPExcel/IOFactory.php';
		
		$objPHPExcel = PHPExcel_IOFactory::load('./uploads/tmp/BaseTecnicaFinal.xls');
		$proyectos = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
		$idpropuesta = 0;
		for($i=2; $i<=sizeof($proyectos); $i++){			
			if(utf8_encode(trim($proyectos[$i]['R']))=='Proyecto'){
				$identificador = str_replace(' ', '',$proyectos[$i]['A']);
				$result = $this->Propuesta->getByIdentificador($identificador);		
				if(!empty($result)){
					$idpropuesta = $result;
					continue;
				}else{
					$idpropuesta = 0;
					$data['errores'][] = 'Error al intentar cargar a '.$i.' '.$result;
				}	
			}else{
				$tecnica = array();
				$tecnica['idpropuesta'] = Array('val'=>$idpropuesta, 'req'=>TRUE);
				
				$componente = utf8_encode(trim($proyectos[$i]['R']));
				$tecnica['d_componente'] = Array('val'=>$componente, 'req'=>FALSE);
				$this->load->model('Componente');
				$iditem = $this->Componente->getByNombre($componente);				
				$tecnica['componente'] = Array('val'=>$iditem, 'req'=>FALSE);

				$indicastandar = utf8_encode(trim($proyectos[$i]['S']));
				$tecnica['d_indicastandar'] = Array('val'=>$indicastandar, 'req'=>FALSE);
				$this->load->model('Indicastandar');
				$iditem = $this->Indicastandar->getOrInsertByNombre($indicastandar);				
				$tecnica['indicastandar'] = Array('val'=>$iditem, 'req'=>FALSE);

				$unidad = utf8_encode(trim($proyectos[$i]['X']));
				$tecnica['d_unidad'] = Array('val'=>$unidad, 'req'=>FALSE);
				$this->load->model('Unidad');
				$iditem = $this->Unidad->getOrInsertByNombre($unidad);				
				$tecnica['unidad'] = Array('val'=>$iditem, 'req'=>FALSE);

				$tecnica['localidad'] = Array('val'=>utf8_encode($proyectos[$i]['V']), 'req'=>FALSE);
				$tecnica['anio_ind'] = Array('val'=>utf8_encode($proyectos[$i]['W']), 'req'=>FALSE);
				$tecnica['antes'] = Array('val'=>utf8_encode($proyectos[$i]['Y']), 'req'=>FALSE);
				$tecnica['despues'] = Array('val'=>utf8_encode($proyectos[$i]['Z']), 'req'=>FALSE);

				
				$pais = utf8_encode(trim($proyectos[$i]['U']));
				$tecnica['d_pais'] = Array('val'=>$pais, 'req'=>FALSE);
				$this->load->model('Pais');
				$iditem = $this->Pais->getByNombre($pais);				
				$tecnica['paisindicador'] = Array('val'=>$iditem, 'req'=>FALSE);

				$datas_lang = array();
				$paquete_lang= array();
				$paquete_lang['indicador'] =utf8_encode($proyectos[$i]['T']);
				$datas_lang['es'] = $paquete_lang;

				$result = $this->Tecnica->insertOrUpdate(0, $tecnica);
				if($result && is_numeric($result)){
					$this->Tecnica->insertOrUpdateLanguage($result, $datas_lang);
					$data['cargados']++;
					continue;
				}else{
					$data['errores'][] = 'Error al intentar cargar a '.$i.' '.$result;
				}	
				
			}				
		}

		echo '<pre>';
		print_r($data);

	}

}
?>
