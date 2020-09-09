<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tecnicas extends CI_Controller {

    public function __construct() {
		parent::__construct();
		$this->login->verify();

		$this->load->model('Tecnica');
		$this->load->model('Propuesta');
	}

	public function index()	{		
		header("Location: ".base_url().'admin/propuestas/listar');
	}
	/*
    public function listar($idpropuesta){
		if(!is_numeric($idpropuesta) || empty($idpropuesta)){
			header("Location: ".base_url().'admin/propuestas/listar');
		}
		$data['propuesta'] = $this->Propuesta->getById($idpropuesta);
		$data['libs'] = Array('datatables');
        $data['page'] = 'tecnica_listar';
		$this->load->view('admin/estruc/estructura', $data);
    }*/


	public function paginar($idpropuesta){
		$this->getCleanPropuesta($idpropuesta);//permisos
		
		$input['idpropuesta'] = $idpropuesta;
		$input['busqueda'] = $this->input->post('sSearch');
		$input['comienzo'] = $this->input->post('iDisplayStart');
		$input['cantidad'] = $this->input->post('iDisplayLength');	
		$input['ordenar'] = 'idtecnica';
				
		$columnas[0] = 'componente_nombre';
		$columnas[1] = 'indicador_nombre';
		$columnas[2] = 'indicador';
		$columnas[3] = 'pais_nombre';
		$columnas[4] = 'localidad';
		$columnas[5] = 'anio_ind';
		$columnas[6] = 'unidad_nombre';
		$columnas[7] = 'antes';
		$columnas[8] = 'despues';
		$columnas[9] = 'idtecnica';
		$sort = $this->input->post('iSortCol_0');
		if(!empty($sort)){
			$input['ordenar'] = $columnas[$sort].' '.$this->input->post('sSortDir_0');
		}
		
		$output['sEcho'] = $this->input->post('sEcho');
		$output['iTotalRecords'] = $this->Tecnica->getTotalRecords(); 
		$output['iTotalDisplayRecords'] = $this->Tecnica->getTotalFilteredRecords($input);
		$output['aaData'] = array();
		$datos = $this->Tecnica->getPaginated($input);
		foreach($datos as $dat){
			$salida = array();
			$salida[0] = $dat['componente_nombre'];
			$salida[1] = $dat['indicador_nombre'];
			$salida[2] = $dat['indicador'];
			$salida[3] = $dat['pais_nombre'];
			$salida[4] = $dat['localidad'];
			$salida[5] = $dat['anio_ind'];
			$salida[6] = $dat['unidad_nombre'];
			$salida[7] = $dat['antes'];
			$salida[8] = $dat['despues'];
			$salida[9] = $dat['idtecnica'];
			$output['aaData'][] = $salida;
		}
		echo json_encode($output);
	}
	

    public function modificar($idpropuesta, $idtecnica=0){
		$this->getCleanPropuesta($idpropuesta);//permisos
		$data['idpropuesta'] = $idpropuesta;
		$data['lenguajes'] = $this->Lenguaje->getHabilitados('idlenguaje', 'asc');
		$data['datas_lang'] = array();
        $data['idtecnica'] = $idtecnica;
        $data['tecnica'] = array();
        $this->load->helper('form');
		if (!empty($_POST)){           
			$tecnica = array();
			
			$tecnica['idpropuesta'] = Array('val'=>$idpropuesta, 'req'=>TRUE);
			$tecnica['componente'] = Array('val'=>$this->input->post('componente'), 'req'=>TRUE);										
			$tecnica['indicastandar'] = Array('val'=>$this->input->post('indicastandar'), 'req'=>TRUE);		
			$tecnica['paisindicador'] = Array('val'=>$this->input->post('paisindicador'), 'req'=>FALSE);						
			$tecnica['localidad'] = Array('val'=>$this->input->post('localidad'), 'req'=>FALSE);					
			$tecnica['anio_ind'] = Array('val'=>$this->input->post('anio_ind'), 'req'=>FALSE);					
			$tecnica['antes'] = Array('val'=>$this->input->post('antes'), 'req'=>FALSE);				
			$tecnica['despues'] = Array('val'=>$this->input->post('despues_san'), 'req'=>FALSE);		
			$tecnica['despues_san'] = Array('val'=>$this->input->post('despues_san'), 'req'=>FALSE);

			$tecnica['unidad'] = Array('val'=>$this->input->post('unidad'), 'req'=>TRUE);	
			
			$datas_lang = array();
			foreach($data['lenguajes'] as $lenguaje){
				$paquete_lang= array();
				$paquete_lang['indicador'] = $this->input->post('indicador_'.$lenguaje->codlang);
				$datas_lang[$lenguaje->codlang] = $paquete_lang;
			}
			            
            $result = $this->Tecnica->insertOrUpdate($idtecnica, $tecnica);
            if($result && is_numeric($result)){			
				$this->Tecnica->insertOrUpdateLanguage($result, $datas_lang);
                redirect("admin/propuestas/ver/".$idpropuesta);
            }else{
                $data['error'] = $result;
                $data['tecnica'] = $this->Tecnica->getValores($tecnica);
            }
        }else{
            if(!empty($idtecnica)){
                $tecnica = $this->getCleanTecnica($idtecnica);
                if(empty($tecnica)){
                    $data['error'] = 'No se encontro al tecnica con ID '.$idtecnica;
                }else{
					$data['tecnica'] = $tecnica;
					$datas_lang = array();
					$paqueteLang = $this->Tecnica->getLanguages($idtecnica);
					foreach($paqueteLang as $pl){
						$datas_lang[$pl['codlang']] = $pl;
					}
					$data['datas_lang'] = $datas_lang;
                }
            }
		}
		$this->load->model('Componente');
		$data['componente'] = $this->Componente->getAllView('nombre', 'asc');
		$this->load->model('Indicastandar');
		$data['indicastandar'] = $this->Indicastandar->getAllView('nombre', 'asc');
		$this->load->model('Pais');
		$data['paisindicador'] = $this->Pais->getAllView('nombre', 'asc');		
		array_unshift($data['paisindicador'], array('id'=>0, 'nombre'=>'Ninguno'));
		$this->load->model('Unidad');
		$data['unidades'] = $this->Unidad->getAllView('nombre', 'asc');
		$data['libs'] = Array();
        $data['page'] = 'tecnica_modificar';
        $this->load->view('admin/estruc/estructura', $data);        
	}


	private function solo_numeros($val){
		$res = preg_replace('/[^0-9.]/', '', $val);
		if(empty($res)) return 0;
		return $res;
	}	


    private function getCleanTecnica($idtecnica){
        if(empty($idtecnica) || !is_numeric($idtecnica)){
            $this->session->set_userdata('error', 'No se encontro al tecnica con ID '.$idtecnica);
            redirect("admin/tecnicas");
        }
        $tecnica = $this->Tecnica->getByIdTable($idtecnica);
        if(empty($tecnica)){
            $this->session->set_userdata('error', 'No se encontro al tecnica con ID '.$idtecnica);
            redirect("admin/tecnicas");
        }
        return $tecnica;
    }


    public function eliminar(){
		$ideliminar = $_POST['ideliminar'];
		$tecnica = $this->getCleanTecnica($ideliminar);
		$this->getCleanPropuesta($tecnica['idpropuesta']);//permisos
		$this->Tecnica->eliminarBlando($ideliminar);
		echo $tecnica['idpropuesta'];
	}
	
	public function agregar($idpropuesta){		
		$this->getCleanPropuesta($idpropuesta);//permisos		
		$data['lenguajes'] = $this->Lenguaje->getHabilitados('idlenguaje', 'asc');
		if (!empty($_POST)){        
			$tecnica = array();
			$idtecnica = $this->input->post('idtecnica');
			
			$tecnica['idpropuesta'] = Array('val'=>$idpropuesta, 'req'=>TRUE);
			$tecnica['componente'] = Array('val'=>$this->input->post('componente'), 'req'=>TRUE);										
			$tecnica['indicastandar'] = Array('val'=>$this->input->post('indicastandar'), 'req'=>TRUE);		
			$tecnica['paisindicador'] = Array('val'=>$this->input->post('paisindicador'), 'req'=>FALSE);						
			$tecnica['localidad'] = Array('val'=>$this->input->post('localidad'), 'req'=>FALSE);					
			$tecnica['anio_ind'] = Array('val'=>$this->input->post('anio_ind'), 'req'=>FALSE);					
			$tecnica['antes'] = Array('val'=>$this->input->post('antes'), 'req'=>FALSE);				
			$tecnica['despues'] = Array('val'=>$this->input->post('despues_san'), 'req'=>FALSE);		
			$tecnica['despues_san'] = Array('val'=>$this->input->post('despues_san'), 'req'=>FALSE);

			$tecnica['unidad'] = Array('val'=>$this->input->post('unidad'), 'req'=>TRUE);	
			$datas_lang = array();
			foreach($data['lenguajes'] as $lenguaje){
				$paquete_lang= array();
				$paquete_lang['indicador'] = $this->input->post('indicador_'.$lenguaje->codlang);
				$datas_lang[$lenguaje->codlang] = $paquete_lang;
			}
			            
            $result = $this->Tecnica->insertOrUpdate($idtecnica, $tecnica);
            if($result && is_numeric($result)){			
				$this->Tecnica->insertOrUpdateLanguage($result, $datas_lang);
                echo '';
            }else{
                echo $result;
            }
        }
	}

	public function obtener(){		
		$tecnica = $this->Tecnica->obtener($this->input->post('idtecnica'));
		$this->getCleanPropuesta($tecnica['idpropuesta']);//permisos
		echo json_encode($tecnica);
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
}
?>
