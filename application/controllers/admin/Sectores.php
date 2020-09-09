<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sectores extends CI_Controller {

    public function __construct() {
		parent::__construct();
		$this->login->verify();

        $this->load->model('Sector');
	}

	public function index()	{		
		header("Location: ".base_url().'admin/sectores/listar');
	}
	
    public function listar(){
		$data['libs'] = Array('datatables');
        $data['page'] = 'sector_listar';
		$this->load->view('admin/estruc/estructura', $data);
    }


	public function paginar(){
		$input['busqueda'] = $this->input->post('sSearch');
		$input['comienzo'] = $this->input->post('iDisplayStart');
		$input['cantidad'] = $this->input->post('iDisplayLength');	
		$input['ordenar'] = $this->Sector->idname;
				
		$columnas[0] = $this->Sector->idname;
		$columnas[1] = 'nombre';
		$columnas[2] = $this->Sector->idname;
		$sort = $this->input->post('iSortCol_0');
		if(!empty($sort)){
			$input['ordenar'] = $columnas[$sort].' '.$this->input->post('sSortDir_0');
		}
		
		$output['sEcho'] = $this->input->post('sEcho');
		$output['iTotalRecords'] = $this->Sector->getTotalRecords(); 
		$output['iTotalDisplayRecords'] = $this->Sector->getTotalFilteredRecords($input);
		$output['aaData'] = array();
		$datos = $this->Sector->getPaginated($input);
		foreach($datos as $dat){
			$salida = array();
			$salida[0] = $dat[$this->Sector->idname];
			$salida[1] = $dat['nombre'];
			$salida[2] = $dat[$this->Sector->idname];
			$output['aaData'][] = $salida;
		}
		echo json_encode($output);
	}
	

    public function modificar($idsector=0){
		$data['lenguajes'] = $this->Lenguaje->getHabilitados('idlenguaje', 'asc');
		$data['datas_lang'] = array();
        $data['idsector'] = $idsector;
        $data['sector'] = array();
        $this->load->helper('form');
		if (!empty($_POST)){           
			$sector = array(); 
			$datas_lang = array();
			foreach($data['lenguajes'] as $lenguaje){
				$paquete_lang= array();
				$paquete_lang['nombre'] =$this->input->post('nombre_'.$lenguaje->codlang);
				$datas_lang[$lenguaje->codlang] = $paquete_lang;
			}
            
            $result = $this->Sector->insertOrUpdate($idsector, $sector);
            if($result && is_numeric($result)){				
				$this->Sector->insertOrUpdateLanguage($result, $datas_lang);
                redirect("admin/sectores/listar");
            }else{
                $data['error'] = $result;
                $data['sector'] = $this->Sector->getValores($sector);
            }
        }else{
            if(!empty($idsector)){
				$sector = $this->getCleanSector($idsector);
                if(empty($sector)){
                    $data['error'] = 'No se encontro al sector con ID '.$idsector;
                }else{
					$data['sector'] = $sector;
					$datas_lang = array();
					$paqueteLang = $this->Sector->getLanguages($idsector);
					foreach($paqueteLang as $pl){
						$datas_lang[$pl['codlang']] = $pl;
					}
					$data['datas_lang'] = $datas_lang;
                }
            }
		}
		$this->load->model('Componente');
		$data['componentes'] = $this->Componente->getAllByLang('es');	
		$data['libs'] = Array('datatables');
        $data['page'] = 'sector_modificar';
        $this->load->view('admin/estruc/estructura', $data);        
	}

    private function getCleanSector($idsector){
        if(empty($idsector) || !is_numeric($idsector)){
            $this->session->set_userdata('error', 'No se encontro al sector con ID '.$idsector);
            redirect("admin/sectores");
        }
        $sector = $this->Sector->getById($idsector);
        if(empty($sector)){
            $this->session->set_userdata('error', 'No se encontro al sector con ID '.$idsector);
            redirect("admin/admin/sectores");
        }
        return $sector;
    }


    public function eliminar(){
        $ideliminar = $_POST['ideliminar'];
        echo $this->Sector->eliminarSeguro($ideliminar);
	}
	

    public function eliminarSubsector(){
		$this->load->model('Subsector');
		$ideliminar = $_POST['ideliminar'];
        echo $this->Subsector->eliminarSeguro($ideliminar);
	}


	public function paginarSubsector($idsector){
		$this->load->model('Subsector');
		if(empty($idsector) || !is_numeric($idsector)){
			exit;
		}
		$input['idsector'] = $idsector;
		$input['busqueda'] = $this->input->post('sSearch');
		$input['comienzo'] = $this->input->post('iDisplayStart');
		$input['cantidad'] = $this->input->post('iDisplayLength');	
		$input['ordenar'] = $this->Subsector->idname;
				
		$columnas[0] = 'nombre';
		$columnas[1] = $this->Subsector->idname;
		$sort = $this->input->post('iSortCol_0');
		$input['ordenar'] = $columnas[$sort].' '.$this->input->post('sSortDir_0');
		
		
		$output['sEcho'] = $this->input->post('sEcho');
		$output['iTotalRecords'] = $this->Subsector->getTotalRecords(); 
		$output['iTotalDisplayRecords'] = $this->Subsector->getTotalFilteredRecords($input);
		$output['aaData'] = array();
		$datos = $this->Subsector->getPaginated($input);
		foreach($datos as $dat){
			$salida = array();
			$salida[0] = $dat['nombre'];
			$salida[1] = $dat[$this->Subsector->idname];
			$output['aaData'][] = $salida;
		}
		
		echo json_encode($output);
	}
	

	public function obtenerSubsector(){
		$this->load->model('Subsector');
		$subsector = $this->Subsector->obtener($this->input->post('idsubsector'));
		echo json_encode($subsector);
	}

	public function agregarSubsector(){		
		if (!empty($_POST)){           
			$subsector = array();
			$lenguajes = $this->Lenguaje->getHabilitados('idlenguaje', 'asc');
			$idsubsector = $this->input->post('idsubsector');
			$idsector = $this->input->post('idsector');
			
			$this->load->model('Subsector'); 
			
			$subsector['idsector'] = Array('val'=>$this->input->post('idsector'), 'req'=>TRUE);
			$datas_lang = array();
			foreach($lenguajes as $lenguaje){
				$paquete_lang= array();
				$paquete_lang['nombre'] = $this->input->post('nombre_'.$lenguaje->codlang);
				$datas_lang[$lenguaje->codlang] = $paquete_lang;
			}
			            
            $result = $this->Subsector->insertOrUpdate($idsubsector, $subsector);
            if($result && is_numeric($result)){				
				$this->Subsector->insertOrUpdateLanguage($result, $datas_lang);
				echo '';
				exit;
            }else{
				echo $result;
			}
		}
	}
}
?>
