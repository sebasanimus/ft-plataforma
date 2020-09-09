<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Exportarpdf extends CI_Controller {

    public function __construct() {
		parent::__construct();
		$this->login->verify();
	}

	public function generarPerfil($idperfil){
		$this->load->model('Perfil');	
		$perfil = $this->Perfil->getById($idperfil);
		if(empty($perfil)){
			exit;
		}
		if($this->session->userdata('role')==2 && $this->session->userdata('idusuario')!=$perfil['idusuario'] ){//los postulantes se pueden descargar su perfil
			exit;
		}
		
		$node = $this->config->item('tech_node');
		$hn = $this->config->item('tech_hn');
		$pdfName = 'perfil_'.$idperfil.'.pdf';
		$pathPDF = $this->config->item('tech_pathPDF');		
		$pathPDF .= 'pdfs/'.$pdfName;
		shell_exec($node.' '.$hn.'hn-perfil.js '.$idperfil.' '.base_url().' '.$pathPDF.' 2>&1');

		header("Content-type: application/pdf");
		header("Content-Length: " . filesize($pathPDF));
		header("Content-Disposition: attachment; filename=$pdfName");
		@readfile($pathPDF);
	}

	public function generarIsta($idista){
		$this->load->model('Ista');	
		$ista = $this->Ista->getById($idista);
		if(empty($ista)){
			exit;
		}
		/*if($this->session->userdata('role')==2 && $this->session->userdata('idusuario')!=$perfil['idusuario'] ){//los postulantes se pueden descargar su perfil
			exit;
		}*/
		
		$node = $this->config->item('tech_node');
		$hn = $this->config->item('tech_hn');
		$pdfName = 'ista_'.$idista.'.pdf';
		$pathPDF = $this->config->item('tech_pathPDF');		
		$pathPDF .= 'pdfs/'.$pdfName;
		shell_exec($node.' '.$hn.'hn-ista.js '.$idista.' '.base_url().' '.$pathPDF.' 2>&1');

		header("Content-type: application/pdf");
		header("Content-Length: " . filesize($pathPDF));
		header("Content-Disposition: attachment; filename=$pdfName");
		@readfile($pathPDF);
	}

	public function convocatoria($idiniciativa){
		$this->load->model('Perfil');
		$perfiles = $this->Perfil->getIdsExportar($idiniciativa);
		$node = $this->config->item('tech_node');
		$hn = $this->config->item('tech_hn');
		$pathPDF = $this->config->item('tech_pathPDF');	
		$pathPDF .= 'pdfs/export_'.date('Y_m_d_H_i_s');
		mkdir($pathPDF);
		foreach($perfiles as $idperfil){
			$pdfName = 'perfil_'.$idperfil['idperfil'].'.pdf';
			$pathPDFComplete = $pathPDF.'/'.$pdfName;
			shell_exec($node.' '.$hn.'hn-perfil.js '.$idperfil['idperfil'].' '.base_url().' '.$pathPDFComplete.' 2>&1');
		}

		// Initialize archive object
		$zip = new ZipArchive();
		$zip->open($pathPDF.'.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE);

		// Create recursive directory iterator
		/** @var SplFileInfo[] $files */
		$files = new RecursiveIteratorIterator(
			new RecursiveDirectoryIterator($pathPDF),
			RecursiveIteratorIterator::LEAVES_ONLY
		);

		foreach ($files as $name => $file)
		{
			// Skip directories (they would be added automatically)
			if (!$file->isDir())
			{
				// Get real and relative path for current file
				$filePath = $file->getRealPath();
				$relativePath = substr($filePath, strlen($pathPDF) + 1);

				// Add current file to archive
				$zip->addFile($filePath, $relativePath);
			}
		}

		// Zip archive will be created only after closing object
		$zip->close();

		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename='.basename($pathPDF.'.zip'));
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize($pathPDF.'.zip'));
		readfile($pathPDF.'.zip');
	}

	public function convocatoriaPre($idiniciativa){
		$this->load->model('Perfil');
		$perfiles = $this->Perfil->getIdsExportarPre($idiniciativa);
		$node = $this->config->item('tech_node');
		$hn = $this->config->item('tech_hn');
		$pathPDF = $this->config->item('tech_pathPDF');	
		$pathPDF .= 'pdfs/export_'.date('Y_m_d_H_i_s');
		mkdir($pathPDF);
		foreach($perfiles as $idperfil){			
			if(!empty($idperfil['adjunto_pre_propuesta'])){
				$file = 'uploads/perfiles/'.$idperfil['adjunto_pre_propuesta'];
				$ext = pathinfo($file, PATHINFO_EXTENSION);
				copy($file, $pathPDF.'/perfil_'.$idperfil['idperfil'].'_propuesta.'.$ext);
			}		
			if(!empty($idperfil['adjunto_pre_presupuesto'])){
				$file = 'uploads/perfiles/'.$idperfil['adjunto_pre_presupuesto'];
				$ext = pathinfo($file, PATHINFO_EXTENSION);
				copy($file, $pathPDF.'/perfil_'.$idperfil['idperfil'].'_presupuesto.'.$ext);
			}
		}

		// Initialize archive object
		$zip = new ZipArchive();
		$zip->open($pathPDF.'.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE);

		// Create recursive directory iterator
		/** @var SplFileInfo[] $files */
		$files = new RecursiveIteratorIterator(
			new RecursiveDirectoryIterator($pathPDF),
			RecursiveIteratorIterator::LEAVES_ONLY
		);

		foreach ($files as $name => $file)
		{
			// Skip directories (they would be added automatically)
			if (!$file->isDir())
			{
				// Get real and relative path for current file
				$filePath = $file->getRealPath();
				$relativePath = substr($filePath, strlen($pathPDF) + 1);

				// Add current file to archive
				$zip->addFile($filePath, $relativePath);
			}
		}

		// Zip archive will be created only after closing object
		$zip->close();

		header('Content-Description: File Transfer');
		header('Content-Type:  application/zip');
		header('Content-Disposition: attachment; filename='.basename($pathPDF.'.zip'));
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		//header('Content-Length: ' . filesize($pathPDF.'.zip'));
		readfile($pathPDF.'.zip');
	}

	public function convocatoriaSel($idiniciativa){
		$this->load->model('Perfil');
		$perfiles = $this->Perfil->getIdsExportarPre($idiniciativa);
		$node = $this->config->item('tech_node');
		$hn = $this->config->item('tech_hn');
		$pathPDF = $this->config->item('tech_pathPDF');	
		$pathPDF .= 'pdfs/export_'.date('Y_m_d_H_i_s');
		mkdir($pathPDF);
		foreach($perfiles as $idperfil){			
			if(!empty($idperfil['adjunto_seleccion'])){
				$file = 'uploads/perfiles/'.$idperfil['adjunto_seleccion'];
				$ext = pathinfo($file, PATHINFO_EXTENSION);
				copy($file, $pathPDF.'/perfil_'.$idperfil['idperfil'].'_propuesta.'.$ext);
			}	
		}

		// Initialize archive object
		$zip = new ZipArchive();
		$zip->open($pathPDF.'.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE);

		// Create recursive directory iterator
		/** @var SplFileInfo[] $files */
		$files = new RecursiveIteratorIterator(
			new RecursiveDirectoryIterator($pathPDF),
			RecursiveIteratorIterator::LEAVES_ONLY
		);

		foreach ($files as $name => $file)
		{
			// Skip directories (they would be added automatically)
			if (!$file->isDir())
			{
				// Get real and relative path for current file
				$filePath = $file->getRealPath();
				$relativePath = substr($filePath, strlen($pathPDF) + 1);

				// Add current file to archive
				$zip->addFile($filePath, $relativePath);
			}
		}

		// Zip archive will be created only after closing object
		$zip->close();

		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename='.basename($pathPDF.'.zip'));
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize($pathPDF.'.zip'));
		readfile($pathPDF.'.zip');
	}



	public function convocatoriaIstas($idcallista){
		$this->load->model('Ista');
		$istas = $this->Ista->getIdsExportar($idcallista);
		$node = $this->config->item('tech_node');
		$hn = $this->config->item('tech_hn');
		$pathPDF = $this->config->item('tech_pathPDF');	
		$pathPDF .= 'pdfs/export_ista_'.date('Y_m_d_H_i_s');
		mkdir($pathPDF);
		foreach($istas as $idista){
			$pdfName = 'ista_'.$idista['idista'].'.pdf';
			$pathPDFComplete = $pathPDF.'/'.$pdfName;
			shell_exec($node.' '.$hn.'hn-ista.js '.$idista['idista'].' '.base_url().' '.$pathPDFComplete.' 2>&1');
			if(!empty($idista['adjunto'])){
				$file = 'uploads/istas/'.$idista['adjunto'];
				$ext = pathinfo($file, PATHINFO_EXTENSION);
				copy($file, $pathPDF.'/ista_'.$idista['idista'].'_adj.'.$ext);
			}
		}

		// Initialize archive object
		$zip = new ZipArchive();
		$zip->open($pathPDF.'.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE);

		// Create recursive directory iterator
		/** @var SplFileInfo[] $files */
		$files = new RecursiveIteratorIterator(
			new RecursiveDirectoryIterator($pathPDF),
			RecursiveIteratorIterator::LEAVES_ONLY
		);

		foreach ($files as $name => $file)
		{
			// Skip directories (they would be added automatically)
			if (!$file->isDir())
			{
				// Get real and relative path for current file
				$filePath = $file->getRealPath();
				$relativePath = substr($filePath, strlen($pathPDF) + 1);

				// Add current file to archive
				$zip->addFile($filePath, $relativePath);
			}
		}

		// Zip archive will be created only after closing object
		$zip->close();

		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename='.basename($pathPDF.'.zip'));
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize($pathPDF.'.zip'));
		readfile($pathPDF.'.zip');
	}

}
