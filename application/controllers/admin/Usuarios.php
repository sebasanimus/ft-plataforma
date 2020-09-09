<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller {

    public function __construct() {
		parent::__construct();
		$this->login->verify();

        $this->load->model('Usuario');
       
	}

	public function index()	{		
		header("Location: ".base_url().'admin/usuarios/listar');
	}
	
    public function listar(){
		$data['libs'] = Array('datatables');
        $data['page'] = 'usuario_listar';
		$this->load->view('admin/estruc/estructura', $data);
    }

	public function paginar(){
		$input['busqueda'] = $this->input->post('sSearch');
		$input['comienzo'] = $this->input->post('iDisplayStart');
		$input['cantidad'] = $this->input->post('iDisplayLength');	
		$input['ordenar'] = 'email';
				
		$columnas[0] = 'email';
		$columnas[1] = 'nombre';
		$columnas[2] = 'tipo';
		$columnas[3] = 'propuestas';
		$columnas[4] = 'habilitado';
		$columnas[5] = 'idusuario';
		$sort = $this->input->post('iSortCol_0');
		if(!empty($sort)){
			$input['ordenar'] = $columnas[$sort].' '.$this->input->post('sSortDir_0');
		}
		
		$output['sEcho'] = $this->input->post('sEcho');
		$output['iTotalRecords'] = $this->Usuario->getTotalRecords(); 
		$output['iTotalDisplayRecords'] = $this->Usuario->getTotalFilteredRecords($input);
		$output['aaData'] = array();
		$datos = $this->Usuario->getPaginated($input);
		foreach($datos as $dat){
			$salida = array();
            $salida[0] = $dat['email'];
			$salida[1] = $dat['nombre'];
			$salida[2] = $dat['tipo'];
			$salida[3] = $dat['propuestas'];
			$salida[4] = $dat['habilitado'];
			$salida[5] = $dat['idusuario'];
			$output['aaData'][] = $salida;
		}
		echo json_encode($output);
	}

    public function modificar($idusuario = 0){
        $data['idusuario'] = $idusuario;
        $data['usuario'] = array();
        $this->load->helper('form');
		if (!empty($_POST)){
            if(!empty($idusuario)){//Chequeando que tenga acceso de modificar ese usuario
                $this->getCleanUsuario($idusuario);
            }
            $usuario = array();
            $usuario['email'] = Array('val'=>$this->input->post('email'), 'req'=>TRUE);
            if(empty($idusuario) || !empty($this->input->post('password'))){
                $pass = $this->login->hashPass($this->input->post('password'));
                $usuario['password'] = Array('val'=>$pass, 'req'=>TRUE);
            }
            $habilitado = (isset($_POST['habilitado']) && $_POST['habilitado']=='on')? 1 : 0;
            $usuario['habilitado'] = Array('val'=>$habilitado, 'req'=>FALSE);
            $usuario['idtipousuario'] = Array('val'=>$this->input->post('idtipousuario'), 'req'=>TRUE);
            $usuario['avatar'] = Array('val'=>$this->input->post('avatar'), 'req'=>TRUE);
			$usuario['createdby'] = Array('val'=>$this->session->userdata('idusuario'), 'req'=>FALSE);
			
			$usuario['institucion'] = Array('val'=>$this->input->post('institucion'), 'req'=>FALSE);
			$usuario['posicion'] = Array('val'=>$this->input->post('posicion'), 'req'=>FALSE);
			$usuario['nombre'] = Array('val'=>$this->input->post('nombre'), 'req'=>FALSE);

            $alerta_mail = (isset($_POST['alerta_mail']) && $_POST['alerta_mail']=='on')? 1 : 0;
			$usuario['alerta_mail'] = Array('val'=>$alerta_mail, 'req'=>FALSE);			
            $alerta_nuevo_organismo = (isset($_POST['alerta_nuevo_organismo']) && $_POST['alerta_nuevo_organismo']=='on')? 1 : 0;
            $usuario['alerta_nuevo_organismo'] = Array('val'=>$alerta_nuevo_organismo, 'req'=>FALSE);
            $alerta_contenidos = (isset($_POST['alerta_contenidos']) && $_POST['alerta_contenidos']=='on')? 1 : 0;
            $usuario['alerta_contenidos'] = Array('val'=>$alerta_contenidos, 'req'=>FALSE);
			
            $result = $this->Usuario->insertOrUpdate($idusuario, $usuario);
            if($result && is_numeric($result)){  
				$idpropuestas = $this->input->post('idpropuestas');
				$this->Usuario->actualizarPropuestas($result, $idpropuestas);
                redirect("admin/usuarios/ver/".$result);
            }else{
                $data['error'] = $result;
                $data['usuario'] = $this->Usuario->getValores($usuario);
            }
        }else{
            if(!empty($idusuario)){
                $usuario = $this->getCleanUsuario($idusuario);
                if(empty($usuario)){
                    $data['error'] = 'No se encontro al usuario con ID '.$idusuario;
                }else{
                    $data['usuario'] = $usuario;
                }
            }
        }
		$data['propuestas'] = $this->Usuario->getPropuestas($idusuario);
        $data['tipousuario'] = $this->Usuario->getTipoUsuario();
		$data['libs'] = Array('imagepicker', 'select2');
        $data['page'] = 'usuario_modificar';
        $this->load->view('admin/estruc/estructura', $data);
        
    }

    private function getCleanUsuario($idusuario){
        if(empty($idusuario) || !is_numeric($idusuario)){
            $this->session->set_userdata('error', 'No se encontro al usuario con ID '.$idusuario);
            redirect("admin/usuarios");
        }
        $usuario = $this->Usuario->getById($idusuario);
        if(empty($usuario)){
            $this->session->set_userdata('error', 'No se encontro al usuario con ID '.$idusuario);
            redirect("admin/usuarios");
        }
        return $usuario;
    }

    public function ver($idusuario){
        $usuario = $this->getCleanUsuario($idusuario);
        $data['usuario'] = $usuario;

        $data['tipousuario'] = $this->Usuario->getTipoUsuario();
		$data['propuestas'] = $this->Usuario->getPropuestas($idusuario);
		$data['idusuario'] = $idusuario;
		$data['libs'] = Array('select2');
		$data['readonly'] = true;
        $data['page'] = 'usuario_modificar';
        $this->load->view('admin/estruc/estructura', $data);

    }

    public function eliminar(){
        $ideliminar = $_POST['ideliminar'];
        $this->Usuario->eliminar($ideliminar);
    }
}
?>
