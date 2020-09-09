<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Productos extends CI_Controller {

    public function __construct() {
		parent::__construct();
		$this->login->verify();

		$this->load->model('Producto');
		$this->load->model('Propuesta');
	}

	public function index()	{		
		header("Location: ".base_url().'admin/propuestas/listar');
	}
	
    public function obtener($idpropuesta){
		$this->getCleanPropuesta($idpropuesta);
		$producto = $this->Producto->obtener($this->input->post('idproducto'));
		echo json_encode($producto);
	}

	public function paginar($idpropuesta){
		$this->getCleanPropuesta($idpropuesta);

		$input['busqueda'] = $this->input->post('sSearch');
		$input['comienzo'] = $this->input->post('iDisplayStart');
		$input['cantidad'] = $this->input->post('iDisplayLength');	
		$input['ordenar'] = 'idproducto';
		$input['idpropuesta'] = $idpropuesta;
				
		$columnas[0] = 'archivo';
		$columnas[1] = 'tipo';
		$columnas[2] = 'nombre';
		$columnas[3] = 'numero';
		$columnas[4] = 'orden';
		$columnas[5] = 'publicado';
		$columnas[6] = 'idproducto';
		$sort = $this->input->post('iSortCol_0');
		if(!empty($sort)){
			$input['ordenar'] = $columnas[$sort].' '.$this->input->post('sSortDir_0');
		}
		
		$output['sEcho'] = $this->input->post('sEcho');
		$output['iTotalRecords'] = $this->Producto->getTotalRecords(); 
		$output['iTotalDisplayRecords'] = $this->Producto->getTotalFilteredRecords($input);
		$output['aaData'] = array();
		$datos = $this->Producto->getPaginated($input);
		foreach($datos as $dat){
			$salida = array();
			$salida[0] = $dat['archivo'];
			$salida[1] = $dat['tipo'];
			$salida[2] = $dat['nombre'];
			$salida[3] = $dat['numero'];
			$salida[4] = $dat['orden'];
			$salida[5] = $dat['publicado'];
			$salida[6] = $dat['idproducto'];
			$output['aaData'][] = $salida;
		}
		echo json_encode($output);
	}
	

	public function adjuntar($idproducto=0){
		$data['lenguajes'] = $this->Lenguaje->getHabilitados('idlenguaje', 'asc');
		if (!empty($_POST)){
			$producto = array();
			$idpropuesta = $this->input->post('idpropuesta');  
			$propuesta = $this->getCleanPropuesta($idpropuesta);

			if(!empty($idproducto)){ //me tengo que asegurar que el producto a modificar corresponda a la propuesta que dice pertenecer
				$pro = $this->Producto->getById($idproducto);
				if($pro['idpropuesta']!=$idpropuesta){
					echo 'No coinciden los datos';
					exit;
				}
				if($this->session->userdata('role')==4 && !empty($pro['publicado'])){//esta modificando el investigador
					echo 'No se puede modificar un producto aprobado';
					exit;
				}
			}

			$producto['idpropuesta'] = Array('val'=>$idpropuesta, 'req'=>TRUE);
			$producto['orden'] = Array('val'=>$this->input->post('orden'), 'req'=>FALSE);
			$producto['numero'] = Array('val'=>$this->input->post('numero'), 'req'=>FALSE);
			$producto['idtipo'] = Array('val'=>$this->input->post('idtipo'), 'req'=>TRUE);
			if($this->session->userdata('role')==4){//esta modificando el investigador
				$producto['publicado'] = Array('val'=>null, 'req'=>FALSE);
			}

			$retUpload = $this->do_upload_file('file', 'pdf');
			if(!empty($retUpload['imagen'])){
				$producto['archivo'] = Array('val'=>$retUpload['imagen'], 'req'=>FALSE);
			}else if(!empty($retUpload['error'])){
				echo $retUpload['error'];
				exit;
			}else if(empty($idproducto)){
				echo 'Debe seleccionar un archivo';
				exit;
			}	

			$datas_lang = array();
			foreach($data['lenguajes'] as $lenguaje){
				$paquete_lang= array();
				$paquete_lang['nombre'] = $this->input->post('nombre_'.$lenguaje->codlang);
				$datas_lang[$lenguaje->codlang] = $paquete_lang;
			}

			$result = $this->Producto->insertOrUpdate($idproducto, $producto);
            if($result && is_numeric($result)){				
				$this->Producto->insertOrUpdateLanguage($result, $datas_lang);
				echo 'ok';
				if(!empty($producto['archivo'])) echo '***'.$producto['archivo']['val'].'***';
				if($this->session->userdata('role')==4){//esta modificando el investigador
					$this->load->library('Utilidades');
					$this->utilidades->crearAlerta('Producto de conocimiento: '.$propuesta['identificador'], 'Se encuentra pendiente de moderación el producto de conocimiento: '.$datas_lang['es']['nombre'], base_url().'admin/propuestas/ver/'.$idpropuesta, 'contenidos');
				}
				exit;
            }else{
				echo $result;   
				exit;            
            }			            
		}
		echo '';		
	}

	private function do_upload_file($campo, $allowed='*') {
		$retorno = Array('error'=>'', 'imagen'=>'');
		if (isset($_FILES[$campo]) && is_uploaded_file($_FILES[$campo]['tmp_name'])) {
			$config['upload_path']          = './uploads/productos/';
			$config['allowed_types']        = $allowed;
			$config['max_size']             = 100000; //en kb

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

    public function aceptar($idpropuesta){
		$propuesta = $this->getCleanPropuesta($idpropuesta);
		$idaceptar = $this->input->post('idaceptar');
		$producto = $this->Producto->getById($idaceptar);
		if($producto['idpropuesta'] != $idpropuesta){
			return;
		} 
		$this->Producto->aceptar($idaceptar);	

		$this->load->model('Usuario');
		$usuarios = $this->Usuario->getByPropuesta($idpropuesta);	
		$this->load->library('Utilidades');					
		$datos = Array(
			'propuesta' => $propuesta['titulo_simple'],
			'producto' => $producto['nombre'],
			'web_url' => $producto['web_url']
		);
		
		foreach($usuarios as $usuario){			
			$this->utilidades->enviarEmailProductoAceptado($datos, $usuario);			
		}
			
	}	

    public function eliminar($idpropuesta){
		$propuesta = $this->getCleanPropuesta($idpropuesta);
		$ideliminar = $this->input->post('ideliminar');
		$producto = $this->Producto->getById($ideliminar);
		if($producto['idpropuesta'] != $idpropuesta){
			return;
		} 
		if($this->session->userdata('role')==4 && !empty($producto['publicado'])){//si esta publicado el investigador no puede eliminar
			return;
		}
		if($this->session->userdata('role')!=4){// && empty($producto['publicado']) ){//Si lo elimina el admin y no estaba aprobado, avisa a los investigadores
			$this->load->model('Usuario');
			$usuarios = $this->Usuario->getByPropuesta($idpropuesta);	
			$this->load->library('Utilidades');					
			$datos = Array(
				'propuesta' => $propuesta['titulo_simple'],
				'motivo' =>  $this->input->post('motivo'),
				'producto' => $producto['nombre']
			);
			
			foreach($usuarios as $usuario){			
				$this->utilidades->enviarEmailProductoRechazado($datos, $usuario);			
			}
		}
		$this->Producto->eliminar($ideliminar);		
	}
	

}
?>
