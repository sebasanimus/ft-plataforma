<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

abstract class MY_Model extends CI_Model  {
    public $table = "";
    public $vista = "";
    public $idname = "";
	public $order = "";
	public $loggear = TRUE;

   function __construct() {
          parent::__construct();
    }
    

    public function getById($id){
      $query=$this->db->query("SELECT * FROM {$this->vista} WHERE {$this->idname}=?", array($id));
		  $resultado=$query->result_array();
      if (!$resultado || empty($resultado)) {
        return Array();
      }		
      return $resultado[0];
	}

    public function getByIdTable($id){
      $query=$this->db->query("SELECT * FROM {$this->table} WHERE {$this->idname}=?", array($id));
		  $resultado=$query->result_array();
      if (!$resultado || empty($resultado)) {
        return Array();
      }		
      return $resultado[0];
	}
	
	public function getByIdLang($codlang, $id){
		$query=$this->db->query("SELECT * 
								FROM {$this->table} p JOIN {$this->table}_lang pl ON p.{$this->idname}=pl.{$this->idname} AND pl.codlang=?
								WHERE p.{$this->idname}=?", array($codlang, $id));
		$resultado=$query->result_array();
		if (!$resultado || empty($resultado)) {
			return Array();
		}		
		return $resultado[0];
	}
    
    public function getAll($order = '', $asc = ''){
        $ordenar = (empty($order))? '': 'ORDER BY '.$order.' '.$asc;
        $query=$this->db->query("SELECT * FROM {$this->table} {$ordenar}");
		    $resultado=$query->result();
        return $resultado;
    }
    
    public function getAllByLang($codlang, $order = '', $asc = ''){
        $ordenar = (empty($order))? '': 'ORDER BY '.$order.' '.$asc;
        $query=$this->db->query("SELECT id as value, nombre as label FROM {$this->table}_lang  WHERE codlang=? {$ordenar}", array($codlang));
		$resultado=$query->result_array();
        return $resultado;
    }
    
    public function getAllView($order = '', $asc = ''){
        $ordenar = (empty($order))? '': 'ORDER BY '.$order.' '.$asc;
        $query=$this->db->query("SELECT * FROM {$this->vista} {$ordenar}");
		$resultado=$query->result_array();
        return $resultado;
    }
    
    public function getHabilitados($order = '', $asc = ''){
        $ordenar = (empty($order))? $this->order: 'ORDER BY '.$order.' '.$asc;
        $where = 'WHERE '.$this->whereHabilitados();
        $query=$this->db->query("SELECT * FROM {$this->table} {$where} {$ordenar}");
		    $resultado=$query->result();
        return $resultado;
    }
    protected function whereHabilitados(){
      return 'habilitado=1';
    }
	
	public function deshabilitar($id){
		$query=$this->db->query("UPDATE {$this->table} SET habilitado=0 WHERE {$this->idname}=?",$id);
		if($this->loggear){
			$query=$this->db->query("INSERT INTO Logs(entidad, sentencia, idusuario, idprincipal, funcion) VALUES(?,?,?,?,?) ", Array($this->table, "UPDATE {$this->table} SET habilitado=0 WHERE {$this->idname}={$id}", $this->session->userdata('idusuario'), $id, 'deshabilitar') );
		}
	}


    public function eliminar($id){
		$query=$this->db->query("DELETE FROM {$this->table} WHERE {$this->idname}=?",$id);
		if($this->loggear){
			$query=$this->db->query("INSERT INTO Logs(entidad, sentencia, idusuario, idprincipal, funcion) VALUES(?,?,?,?,?) ", Array($this->table, "DELETE FROM {$this->table} WHERE {$this->idname}={$id}", $this->session->userdata('idusuario'), $id, 'eliminar'));
		}
	}	

    public function eliminarLang($id){
		$query=$this->db->query("DELETE FROM {$this->table}_lang WHERE {$this->idname}=?",$id);
      	$query=$this->db->query("DELETE FROM {$this->table} WHERE {$this->idname}=?",$id);
	}


    public function eliminarBlando($id){
		$query=$this->db->query("UPDATE {$this->table} SET deleted=now() WHERE {$this->idname}=?",$id);
		if($this->loggear){
			$query=$this->db->query("INSERT INTO Logs(entidad, sentencia, idusuario, idprincipal, funcion) VALUES(?,?,?,?,?) ", Array($this->table, "UPDATE {$this->table} SET deleted=now() WHERE {$this->idname}={$id}", $this->session->userdata('idusuario'), $id, 'eliminarBlando'));
		}  
	}	
	
    
    public function getLanguages($id){
        $query=$this->db->query("SELECT * FROM {$this->table}_lang WHERE {$this->idname}=?",$id);
		$resultado=$query->result_array();
        return $resultado;
	}
	

    public function getValores($data){
		$valores = array();
		foreach($data as $k=>$d){
			$valores[$k] = $d['val'];
		}
		return $valores;
	}
	
	public function insertOrUpdateLanguage($id, $datas_lang){
		foreach($datas_lang as $codlang=>$data){
			$campos = '';
			$signos = '';
			$values = array();
			foreach($data as $k=>$d){
			  if(!empty($campos)){
				$campos.=',';
				$signos.=',';
			  }
			  $campos.=$k;
			  $signos.='?';
			  $values[]=$d;
			}
			$str = "REPLACE INTO {$this->table}_lang (codlang, {$this->idname}, $campos) VALUES ('$codlang', $id, $signos) ";
			$query=$this->db->query($str, $values);	
			if($this->loggear){
				$idusuario = $this->session->userdata('idusuario');
				if(empty($idusuario)) $idusuario = 0;
				$query=$this->db->query("INSERT INTO Logs(entidad, sentencia, idusuario, idprincipal, funcion) VALUES(?,?,?,?,?) ", Array($this->table, $str.json_encode($values), $idusuario, $id, 'insertOrUpdateLanguage'));
			} 
		}
	}

    public function insertOrUpdate($id, $data){
		if(empty($id)){
			return $this->insertar($data);
		}else{
			return $this->modificar($id, $data);
		}
    }

    protected function validar($id, $data){
		foreach($data as $k=>$d){
			if($d['req'] && empty($d['val'])){
				return $k.' debe contener un valor';
			}
		}
		return ''; 
    }

    function insertar($data){
		$validacion = $this->validar(0, $data);
		if(!empty($validacion)){
			return $validacion;
		}
		
		$campos = '';
		$signos = '';
		$values = array();
		foreach($data as $k=>$d){
			if(!empty($campos)){
			$campos.=',';
			$signos.=',';
			}
			$campos.=$k;
			$signos.='?';
			$values[]=$d['val'];
		}
		$str = "INSERT INTO {$this->table} ($campos) VALUES ($signos) ";
		$query=$this->db->query($str, $values);		  
		if($query){
			$idretorno = $this->db->insert_id();
			if($this->loggear){
				$idusuario = $this->session->userdata('idusuario');
				if(empty($idusuario)) $idusuario = 0;
				$query=$this->db->query("INSERT INTO Logs(entidad, sentencia, idusuario, idprincipal, funcion) VALUES(?,?,?,?,?) ", Array($this->table, "INSERT INTO {$this->table} ($campos) VALUES ($signos) ", $idusuario, $idretorno, 'insertar'));
			}
			return $idretorno;
		}else{
			return 0;
		}

    }

    function modificar($id, $data){
		if(!is_numeric($id)) return "Error con el ID";
		$validacion = $this->validar($id, $data);
		if(!empty($validacion)){
			return $validacion;
		}
		
		$campos = '';
		$values = array();
		foreach($data as $k=>$d){
			if(!empty($campos)){
			$campos.=',';
			}
			$campos.=$k.'= ?';
			$values[]=$d['val'];
		}
		if(empty($campos)){ //no hay campos para actualizar
			return $id;
		}
		$str = "UPDATE {$this->table} SET $campos WHERE {$this->idname}={$id} ";
		$query=$this->db->query($str, $values);		  
		if($query){
			if($this->loggear){
				$query=$this->db->query("INSERT INTO Logs(entidad, sentencia, idusuario, idprincipal, funcion) VALUES(?,?,?,?,?) ", Array($this->table, "UPDATE {$this->table} SET $campos WHERE {$this->idname}={$id} ", $this->session->userdata('idusuario'), $id, 'modificar'));
			}
			return $id;
		}else{
			return 0;
		}

    }

    /*Para las DATATABLES*/
    protected abstract function getWhere($params);
    protected function getWhereObligado(){
      return ''; 
    }
    public function getTotalRecords(){
		$whereObligado = $this->getWhereObligado();
		if(!empty($whereObligado)) $whereObligado = 'WHERE 1=1 '.$whereObligado;       
		$query = $this->db->query("SELECT count(*) as total FROM {$this->vista} {$whereObligado} ");
		$resultado = $query->result();
		if(!$resultado) return 0;
		return $resultado[0]->total;
    }
    public function getTotalFilteredRecords($params){
		$where = $this->getWhere($params);
		$whereObligado = $this->getWhereObligado();
		$query = $this->db->query("SELECT count(*) as total FROM {$this->vista} {$where} {$whereObligado} ");
		$result = $query->result();
		if(!$result) return 0;
		return $result[0]->total;
    }
    public function getPaginated($params) {
		$limite = ' LIMIT '.$params['comienzo'].', '.$params['cantidad'];
		$where = $this->getWhere($params);
		$whereObligado = $this->getWhereObligado();
		$order = 'ORDER BY '.$params['ordenar'];
		$query = $this->db->query("SELECT * FROM {$this->vista} {$where} {$whereObligado} {$order} {$limite}");
		$result = $query->result_array();
		if (!$result || empty($result)) {
			return Array();
		}		
		return $result;
    }
	/*FIN DATATABLES*/
	

    public function getByNombre($nombre){
		$nombre = strtolower($nombre);
        $query=$this->db->query("SELECT {$this->idname} id FROM {$this->vista} WHERE LCASE(nombre) =  '$nombre' ");
		$resultado=$query->result();
		if(empty($resultado)){
			return 0;
		}
        return $resultado[0]->id;
	}
	

    public function getOrInsertByNombre($nombre){
		$nombre_lower = strtolower($nombre);
        $query=$this->db->query("SELECT {$this->idname} id FROM {$this->vista} WHERE LCASE(nombre) =  '$nombre_lower' ");
		$resultado=$query->result();
		if(empty($resultado)){
			$query=$this->db->query("INSERT INTO {$this->table}(id) VALUES(NULL)");
			$id = $this->db->insert_id();
			$query=$this->db->query("INSERT INTO {$this->table}_lang(id, codlang, nombre) VALUES($id, 'es', '$nombre')");
			return $id;
		}
        return $resultado[0]->id;
    }

  }
?>
