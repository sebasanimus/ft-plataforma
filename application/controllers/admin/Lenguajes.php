<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lenguajes extends CI_Controller {

    public function __construct() {
		parent::__construct();
		$this->login->verify();
	}

	public function index()	{		
		header("Location: ".base_url().'admin/lenguajes/listar');
	}
	
    public function listar(){
		$data['libs'] = Array('datatables');
        $data['page'] = 'lenguaje_listar';
		$this->load->view('admin/estruc/estructura', $data);
    }


	public function paginar(){
		$input['esexcursion'] = FALSE;
		$input['busqueda'] = $this->input->post('sSearch');
		$input['comienzo'] = $this->input->post('iDisplayStart');
		$input['cantidad'] = $this->input->post('iDisplayLength');	
		$input['ordenar'] = 'idlenguaje';
				
		$columnas[0] = 'idlenguaje';
		$columnas[1] = 'nombre';
		$columnas[2] = 'codlang';
		$columnas[3] = 'habilitado';
		$columnas[4] = 'idlenguaje';
		$sort = $this->input->post('iSortCol_0');
		if(!empty($sort)){
			$input['ordenar'] = $columnas[$sort].' '.$this->input->post('sSortDir_0');
		}
		
		$output['sEcho'] = $this->input->post('sEcho');
		$output['iTotalRecords'] = $this->Lenguaje->getTotalRecords(); 
		$output['iTotalDisplayRecords'] = $this->Lenguaje->getTotalFilteredRecords($input);
		$output['aaData'] = array();
		$datos = $this->Lenguaje->getPaginated($input);
		foreach($datos as $dat){
			$salida = array();
			$salida[0] = $dat['idlenguaje'];
			$salida[1] = $dat['nombre'];
			$salida[2] = $dat['codlang'];
			$salida[3] = $dat['habilitado'];
			$salida[4] = $dat['idlenguaje'];
			$output['aaData'][] = $salida;
		}
		//print_r($this->Lenguaje->getPaginated($input)); exit;
		echo json_encode($output);
	}
	

    public function modificar($idlenguaje = 0){
        $data['idlenguaje'] = $idlenguaje;
        $data['lenguaje'] = array();
        $this->load->helper('form');
		if (!empty($_POST)){
            if(!empty($idlenguaje)){//Chequeando que tenga acceso de modificar ese lenguaje
                $this->getCleanLenguaje($idlenguaje);
            }
            $lenguaje = array();
            $lenguaje['nombre'] = Array('val'=>$_POST['nombre'], 'req'=>TRUE);
            $lenguaje['codlang'] = Array('val'=>$_POST['codlang'], 'req'=>TRUE);
            $habilitado = (isset($_POST['habilitado']) && $_POST['habilitado']=='on')? 1 : 0;
            $lenguaje['habilitado'] = Array('val'=>$habilitado, 'req'=>FALSE); 
            
            $result = $this->Lenguaje->insertOrUpdate($idlenguaje, $lenguaje);
            if($result && is_numeric($result)){
				$lenguajes = $this->Lenguaje->getHabilitados();
				$this->session->set_userdata('lenguajes', $lenguajes);		
				$this->session->set_userdata('lenguaje_nombre', 'Todos');	
				$this->session->set_userdata('lenguaje_cod', '');
                redirect("admin/lenguajes/listar");
            }else{
                $data['error'] = $result;
                $data['lenguaje'] = $this->Lenguaje->getValores($lenguaje);
            }
        }else{
            if(!empty($idlenguaje)){
                $lenguaje = $this->getCleanLenguaje($idlenguaje);
                if(empty($lenguaje)){
                    $data['error'] = 'No se encontro al lenguaje con ID '.$idlenguaje;
                }else{
                    $data['lenguaje'] = $lenguaje;
                }
            }
		}
		$data['libs'] = Array('icheck');
        $data['page'] = 'lenguaje_modificar';
        $this->load->view('admin/estruc/estructura', $data);        
    }


    private function getCleanLenguaje($idlenguaje){
        if(empty($idlenguaje) || !is_numeric($idlenguaje)){
            $this->session->set_userdata('error', 'No se encontro al lenguaje con ID '.$idlenguaje);
            redirect("admin/lenguajes");
        }
        $lenguaje = $this->Lenguaje->getById($idlenguaje);
        if(empty($lenguaje)){
            $this->session->set_userdata('error', 'No se encontro al lenguaje con ID '.$idlenguaje);
            redirect("admin/lenguajes");
        }
        return $lenguaje;
    }


    public function eliminar(){
        $ideliminar = $_POST['ideliminar'];
		$this->Lenguaje->deshabilitar($ideliminar);

		$lenguajes = $this->Lenguaje->getHabilitados();
		$this->session->set_userdata('lenguajes', $lenguajes);		
		$this->session->set_userdata('lenguaje_nombre', 'Todos');	
		$this->session->set_userdata('lenguaje_cod', '');
    }
	
	public function cambiarLenguaje($codigo=0){
		if(empty($codigo)){
			$this->session->set_userdata('lenguaje_nombre', 'Todos');	
			$this->session->set_userdata('lenguaje_cod', '');
			echo 'Todos';
		}else{
			$lenguaje = $this->Lenguaje->getByCodigo($codigo);
			$this->session->set_userdata('lenguaje_nombre', $lenguaje['nombre']);	
			$this->session->set_userdata('lenguaje_cod', $lenguaje['codlang']);
			echo $lenguaje['nombre'];
		}
	}

	public function editarArchivo($idlenguaje){
		$data['lenguaje'] = $this->Lenguaje->getById($idlenguaje);

		$file = '../../locales/'.$data['lenguaje']['codlang'].'/translation.json';
		if (!empty($_POST)){
			$json_armado = array();
			foreach($_POST as $key=>$elemento){
				$roots = explode("***", $key);
				$s='';
				foreach($roots as $r){
					//$r = preg_replace("/[^a-zA-Z0-9]/", "", $root);
					$s.="['$r']";
				}
				eval('$json_armado'.$s.'=$elemento;');
				
			}

			$fp = fopen($file, 'w');
			fwrite($fp, json_encode($json_armado, JSON_PRETTY_PRINT));
			fclose($fp);

			redirect("admin/lenguajes/listar");
		}
		
		if(!file_exists($file)){//Si es la primera vez que se edita el lenguaje, se copia del español
			copy('../../locales/es/translation.json', $file);
		}
		// Read JSON file
		$json = file_get_contents($file);

		//Decode JSON
		$data['json_data'] = json_decode($json,true);

		$data['libs'] = Array('');
        $data['page'] = 'lenguaje_editar_archivo';
        $this->load->view('admin/estruc/estructura', $data);      
	}
}
?>
