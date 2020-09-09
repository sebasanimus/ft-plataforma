<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fontagros extends CI_Controller {

    public function __construct() {
		parent::__construct();
		$this->login->verify();

		$this->load->model('Fontagro');
		$this->load->model('Breve');
	}

	public function index()	{		
		header("Location: ".base_url().'admin/fontagros/listar');
	}
	


	public function paginar(){
		$input['busqueda'] = $this->input->post('sSearch');
		$input['comienzo'] = $this->input->post('iDisplayStart');
		$input['cantidad'] = $this->input->post('iDisplayLength');	
		$input['ordenar'] = 'idbreve';
				
		$columnas[0] = 'nombre';
		$columnas[1] = 'idbreve';
		$sort = $this->input->post('iSortCol_0');
		if(!empty($sort)){
			$input['ordenar'] = $columnas[$sort].' '.$this->input->post('sSortDir_0');
		}
		
		$output['sEcho'] = $this->input->post('sEcho');
		$output['iTotalRecords'] = $this->Breve->getTotalRecords(); 
		$output['iTotalDisplayRecords'] = $this->Breve->getTotalFilteredRecords($input);
		$output['aaData'] = array();
		$datos = $this->Breve->getPaginated($input);
		foreach($datos as $dat){
			$salida = array();
			$salida[0] = $dat['nombre'];
			$salida[1] = $dat['idbreve'].'*'.$dat['esmiembro'].'*'.$dat['code'];
			$output['aaData'][] = $salida;
		}
		echo json_encode($output);
	}
	

    public function modificar(){
		$idfontagro=1;
		$data['lenguajes'] = $this->Lenguaje->getHabilitados('idlenguaje', 'asc');
		$data['datas_lang'] = array();
        $data['idfontagro'] = $idfontagro;
        $data['fontagro'] = array();
        $this->load->helper('form');
		if (!empty($_POST)){           
			$fontagro = array();		
			
			$fontagro['tecnologias_generadas'] = Array('val'=>$this->input->post('tecnologias_generadas'), 'req'=>TRUE);
			$fontagro['tecnologias_nuevas'] = Array('val'=>$this->input->post('tecnologias_nuevas'), 'req'=>TRUE);
			$fontagro['tecnologias_relevantes'] = Array('val'=>$this->input->post('tecnologias_relevantes'), 'req'=>TRUE);

			$datas_lang = array();
			foreach($data['lenguajes'] as $lenguaje){
				$paquete_lang= array();
				$paquete_lang['sobreTitulo'] = $this->input->post('sobreTitulo_'.$lenguaje->codlang);
				$paquete_lang['sobre'] = $this->input->post('sobre_'.$lenguaje->codlang);
				$paquete_lang['gobernanzaTitulo'] = $this->input->post('gobernanzaTitulo_'.$lenguaje->codlang);
				$paquete_lang['gobernanza'] = $this->input->post('gobernanza_'.$lenguaje->codlang);
				$paquete_lang['misionTitulo'] = $this->input->post('misionTitulo_'.$lenguaje->codlang);
				$paquete_lang['mision'] = $this->input->post('mision_'.$lenguaje->codlang);
				$paquete_lang['planTitulo'] = $this->input->post('planTitulo_'.$lenguaje->codlang);
				$paquete_lang['plan'] = $this->input->post('plan_'.$lenguaje->codlang);
				$paquete_lang['enCifrasTitulo'] = $this->input->post('enCifrasTitulo_'.$lenguaje->codlang);
				$paquete_lang['participacionTitulo'] = $this->input->post('participacionTitulo_'.$lenguaje->codlang);
				$paquete_lang['origenTitulo'] = $this->input->post('origenTitulo_'.$lenguaje->codlang);

				$paquete_lang['proyectosAprobados'] = $this->input->post('proyectosAprobados_'.$lenguaje->codlang);
				$paquete_lang['montoTotal'] = $this->input->post('montoTotal_'.$lenguaje->codlang);
				$paquete_lang['otrosInvercionistas'] = $this->input->post('otrosInvercionistas_'.$lenguaje->codlang);
				$paquete_lang['paisesBeneficiados'] = $this->input->post('paisesBeneficiados_'.$lenguaje->codlang);
				$paquete_lang['tecnologiasGeneradas'] = $this->input->post('tecnologiasGeneradas_'.$lenguaje->codlang);
				$paquete_lang['tecnologiasNuevas'] = $this->input->post('tecnologiasNuevas_'.$lenguaje->codlang);
				$paquete_lang['tecnologiasRelevantes'] = $this->input->post('tecnologiasRelevantes_'.$lenguaje->codlang);

				$paquete_lang['miembro'] = $this->input->post('miembro_'.$lenguaje->codlang);
				$paquete_lang['lider'] = $this->input->post('lider_'.$lenguaje->codlang);
				$paquete_lang['aporteContrapartida'] = $this->input->post('aporteContrapartida_'.$lenguaje->codlang);
				$paquete_lang['BID'] = $this->input->post('BID_'.$lenguaje->codlang);
				$paquete_lang['otrasAgencias'] = $this->input->post('otrasAgencias_'.$lenguaje->codlang);
				$paquete_lang['ejemplos'] = $this->input->post('ejemplos_'.$lenguaje->codlang);

				$paquete_lang['fortalecimiento'] = $this->input->post('fortalecimiento_'.$lenguaje->codlang);
				$paquete_lang['paisesMiembro'] = $this->input->post('paisesMiembro_'.$lenguaje->codlang);
				$paquete_lang['anio'] = $this->input->post('anio_'.$lenguaje->codlang);
				$paquete_lang['institucionLider'] = $this->input->post('institucionLider_'.$lenguaje->codlang);
				$paquete_lang['miembros'] = $this->input->post('miembros_'.$lenguaje->codlang);
				$paquete_lang['tema'] = $this->input->post('tema_'.$lenguaje->codlang);
				$paquete_lang['monto'] = $this->input->post('monto_'.$lenguaje->codlang);

				$paquete_lang['paises'] = $this->input->post('paises_'.$lenguaje->codlang);
				$paquete_lang['contribucion'] = $this->input->post('contribucion_'.$lenguaje->codlang);
				$paquete_lang['participacion'] = $this->input->post('participacion_'.$lenguaje->codlang);

				$datas_lang[$lenguaje->codlang] = $paquete_lang;
			}
			            
			$result = $this->Fontagro->insertOrUpdate($idfontagro, $fontagro);		
			$this->Fontagro->insertOrUpdateLanguage($idfontagro, $datas_lang);
			redirect("admin/fontagros/modificar");
            
        }else{
            if(!empty($idfontagro)){
                $fontagro = $this->getCleanFontagro($idfontagro);
                if(empty($fontagro)){
                    $data['error'] = 'No se encontro al fontagro con ID '.$idfontagro;
                }else{
					$data['fontagro'] = $fontagro;
					$datas_lang = array();
					$paqueteLang = $this->Fontagro->getLanguages($idfontagro);
					foreach($paqueteLang as $pl){
						$datas_lang[$pl['codlang']] = $pl;
					}
					$data['datas_lang'] = $datas_lang;
                }
            }
		}
		$this->load->model('Breve');
		$data['breves'] = $this->Breve->getAllView();

		$data['libs'] = Array('datatables', 'summernote');
        $data['page'] = 'fontagro_modificar';
        $this->load->view('admin/estruc/estructura', $data);        
	}

	public function breve($idbreve){
		if(empty($idbreve)){
			exit;
		}
		$data['lenguajes'] = $this->Lenguaje->getHabilitados('idlenguaje', 'asc');
		$data['datas_lang'] = array();
        $data['idbreve'] = $idbreve;
        $data['breve'] = array();
        $this->load->helper('form');
		if (!empty($_POST)){           
			$breve = array();	

			$datas_lang = array();
			foreach($data['lenguajes'] as $lenguaje){
				$paquete_lang= array();
				$paquete_lang['contenido'] = $this->input->post('contenido_'.$lenguaje->codlang);
				$paquete_lang['fortalecimiento'] = $this->input->post('fortalecimiento_'.$lenguaje->codlang);
				$datas_lang[$lenguaje->codlang] = $paquete_lang;
			}      
           			
			$this->Breve->insertOrUpdateLanguage($idbreve, $datas_lang);
			redirect("admin/fontagros/modificar");
            
        }else{
            if(!empty($idbreve)){
                $breve = $this->getCleanBreve($idbreve);
                if(empty($breve)){
                    $data['error'] = 'No se encontro al fontagro con ID '.$idbreve;
                }else{
					$data['breve'] = $breve;
					$datas_lang = array();
					$paqueteLang = $this->Breve->getLanguages($idbreve);
					foreach($paqueteLang as $pl){
						$datas_lang[$pl['codlang']] = $pl;
					}
					$data['datas_lang'] = $datas_lang;
                }
            }
		}
		
		$data['libs'] = Array('summernote');
        $data['page'] = 'breve_modificar';
        $this->load->view('admin/estruc/estructura', $data);        
	}


    private function getCleanFontagro($idfontagro){
        if(empty($idfontagro) || !is_numeric($idfontagro)){
            $this->session->set_userdata('error', 'No se encontro al fontagro con ID '.$idfontagro);
            redirect("admin/fontagros");
        }
        $fontagro = $this->Fontagro->getById($idfontagro);
        if(empty($fontagro)){
            $this->session->set_userdata('error', 'No se encontro al fontagro con ID '.$idfontagro);
            redirect("admin/fontagros");
        }
        return $fontagro;
    }

    private function getCleanBreve($idbreve){
        if(empty($idbreve) || !is_numeric($idbreve)){
            $this->session->set_userdata('error', 'No se encontro al fontagro con ID '.$idbreve);
            redirect("admin/fontagros");
        }
        $breve = $this->Breve->getById($idbreve);
        if(empty($breve)){
            $this->session->set_userdata('error', 'No se encontro al fontagro con ID '.$idbreve);
            redirect("admin/fontagros");
        }
        return $breve;
    }


}
?>
