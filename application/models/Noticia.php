<?php

class Noticia extends MY_Model {
    

    function __construct() {
          parent::__construct();
          $this->table = "Noticia";
          $this->vista = "v_Noticia";
          $this->idname = "idnoticia";
    }



	protected function getWhere($params){
		$search = $params['busqueda'];
		$where = 'WHERE '.(empty($params['idpropuesta'])? '1=1':'idpropuesta='.$params['idpropuesta']).' ';
		if(!empty($search)){
			$where .= "AND (titulo like '%$search%' OR tiponoticia like '%$search%' OR aprobada like '%$search%') ";
		}
		return $where;
	}

	protected function getWhereObligado(){
		return '';
	}

    
    protected function validar($id, $data){
        $sar = parent::validar($id, $data);
        if(!empty($sar)){
            return $sar;
		}   	
		return '';       
	}

	public function getNoticia($idnoticia, $lang, $puedeVerBorrador){
		$tabla = ($puedeVerBorrador) ? 'v_Noticia_Publicada' : 'Noticia';
		
		$query = $this->db->query("SELECT * 
										FROM $tabla n 
										JOIN Noticia_lang nl ON nl.idnoticia=n.idnoticia 
										WHERE n.idnoticia = ? AND nl.codlang = ? ", array($idnoticia, $lang));
		$result = $query->result_array();
		if(!$result || empty($result)) {
			return Array(); 
		}
		return $result[0];
	}

	public function getByPropuesta($idpropuesta, $lang){
		$query=$this->db->query("SELECT * 
									FROM v_Noticia_Publicada n
									JOIN Noticia_lang nl ON nl.idnoticia=n.idnoticia 
									WHERE idpropuesta=? AND codlang=? AND nl.titulo<>'' ORDER BY publicada DESC", array($idpropuesta, $lang));
		return $query->result_array();
	}
	
	public function getHome($lang){
		$query=$this->db->query("SELECT p.web_publicado, p.web_url, p.web_publicado, pl.titulo_simple, nl.titulo, nl.url, n.idnoticia, n.foto  
									FROM v_Noticia_Publicada n
									JOIN Noticia_lang nl ON nl.idnoticia=n.idnoticia AND nl.codlang=?
									JOIN Propuesta p ON n.idpropuesta=p.idpropuesta
									JOIN Propuesta_lang pl ON pl.idpropuesta=p.idpropuesta AND pl.codlang=?
									ORDER BY publicada DESC LIMIT 3", array($lang, $lang));
		return $query->result_array();
	}
	
	public function getDashboard(){
		$where = ($this->session->userdata('role')==4)? 'WHERE p.idpropuesta IN (SELECT idpropuesta FROM Propuesta_usuario WHERE idusuario='.$this->session->userdata('idusuario').')' : '';
		$query=$this->db->query("SELECT p.idpropuesta, p.web_url, p.web_publicado, pl.titulo_simple, nl.titulo, nl.url, n.idnoticia, n.foto, nl.bajada
									FROM v_Noticia_Publicada n
									JOIN Noticia_lang nl ON nl.idnoticia=n.idnoticia AND nl.codlang='es'
									JOIN Propuesta p ON n.idpropuesta=p.idpropuesta
									JOIN Propuesta_lang pl ON pl.idpropuesta=p.idpropuesta AND pl.codlang='es'
									$where
									ORDER BY publicada DESC LIMIT 3");
		return $query->result_array();
	}

	
}

?>