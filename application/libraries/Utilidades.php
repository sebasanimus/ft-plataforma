<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Utilidades {
	public $CI;
	var $url_front;

	public function __construct() {
		$this->CI =& get_instance();
		$this->url_front = str_replace("admin/","",base_url());
	}
	
	
    public function enviarEmailRecuperar($textos, $token, $to){
		$data = array();

		$data['titulo_cuerpo'] = $textos['recuperar_mail_titulo'];
		$data['subtitulo'] = '';
		$data['contenido'] = $textos['recuperar_mail_descripcion'];
		$data['url'] = base_url().'iniciativas/recuperar/'.$token;
		$data['url_accion'] = $textos['recuperar_mail_titulo'];
		$data['url_aclaracion'] = $textos['recuperar_mail_aclaracion'];	

        $mseg = $this->CI->load->view('iniciativas/mail', $data, true);        
		$subject = 'Fontagro - '.$data['titulo_cuerpo'];		
		$this->enviarMail($to, $subject, $mseg);
	}

    public function enviarEmailInicial($textos, $nombre, $to){
		$data = array();

		$data['titulo_cuerpo'] = $textos['mail_inicial_titulo'].' '.$nombre;
		$data['subtitulo'] = $textos['mail_inicial_subtitulo'];
		$data['contenido'] = nl2br($textos['mail_inicial_descripcion']);
		$data['url'] = base_url().'iniciativas';
		$data['url_accion'] = $textos['mail_inicial_accion'];
		$data['url_aclaracion'] = $textos['mail_inicial_aclaracion'];

        $mseg = $this->CI->load->view('iniciativas/mail', $data, true);        
		$subject = 'Fontagro - '.$data['titulo_cuerpo'];		
		$this->enviarMail($to, $subject, $mseg);
	}

    public function enviarEmailOrgAceptado($datos, $usuario){		

		$data = array();
		$data['titulo_cuerpo'] = 'Organismo incorporado al sistema';
		$data['subtitulo'] ='El organismo que usted solicitó fue dado de alta en el sistema y ya se encuentra disponible para su utilización';
		$data['contenido'] = 'El organismo fue dado de alta con los siguientes datos:<br>
								Sigla: '.$datos['nombre'].'<br>
								Nombre completo: '.$datos['nombre_largo'].'<br>
								<br>
								Muchas gracias.<br>	';		
		
		
		$this->CI->load->model('Alerta');
		$idalerta = $this->CI->Alerta->crear($data['titulo_cuerpo'], $data['contenido'], "");
		$this->CI->Alerta->agregarUsuario($idalerta, $usuario['idusuario']);
		
		$mseg = $this->CI->load->view('iniciativas/mail', $data, true);
		$subject = 'Fontagro - '.$data['titulo_cuerpo'];		
		$this->enviarMail($usuario['email'], $subject, $mseg);

	}

    public function enviarEmailOrgRechazado($datos, $usuario){    
		$data = array();
		$data['titulo_cuerpo'] = 'Organismo Sugerido Rechazado';
		$data['subtitulo'] ='Se rechazo el ingreso al sistema del organismo: '.$datos['nombre'].' - '.$datos['nombre_largo'];
		$data['contenido'] = 'Motivo: <br>'.nl2br($datos['motivo']);		
		
		
		$this->CI->load->model('Alerta');
		$idalerta = $this->CI->Alerta->crear($data['titulo_cuerpo'], $data['subtitulo'].'<br>'.$data['contenido'], "");
		$this->CI->Alerta->agregarUsuario($idalerta, $usuario['idusuario']);
		
		$mseg = $this->CI->load->view('iniciativas/mail', $data, true);
		$subject = 'Fontagro - '.$data['titulo_cuerpo'];		
		$this->enviarMail($usuario['email'], $subject, $mseg);
	}	

    public function enviarEmailIstaRechazado($datos, $usuario){	
		
		$data=array();
		$data['titulo'] = 'La STA ha revisado su Informe de Seguimiento Técnico y tiene sugerencias para realizar';		
		$data['titulo_cuerpo'] = '';
		$data['subtitulo'] = 'Estimado/a '.$usuario['nombre'].',<br>La Secretaría Técnica Administrativa ha revisado su Informe de Seguimiento Técnico (ISTA) del proyecto "'.$datos['propuesta'].'" y tiene sugerencias para realizar.';
		$data['contenido'] = nl2br($datos['motivo']);
		$data['url'] = base_url().'admin/istas/seleccion';
		$data['url_accion'] = 'Revise su ISTA aquí';
		$data['url_aclaracion'] = '';	

		$this->CI->load->model('Alerta');
		$idalerta = $this->CI->Alerta->crear($data['titulo'], $data['subtitulo'].'<br><br>'.$data['contenido'], $data['url'] );
		//$this->CI->Alerta->agregarUsuario($idalerta, $usuario['idusuario']);
		
        $mseg = $this->CI->load->view('iniciativas/mail', $data, true);        
		$subject = 'Fontagro - '.$data['titulo'];		
		//$this->enviarMail($usuario['email'], $subject, $mseg);
	}

    public function enviarEmailProductoRechazado($datos, $usuario){				
		
		$data=array();
		$data['titulo'] = 'Producto de Conocimiento';
		$data['titulo_cuerpo'] = '';
		$data['subtitulo'] = 'Estimado/a '.$usuario['nombre'].',<br>La Secretaría Técnica Administrativa ha revisado su Producto de conocimiento "'.$datos['producto'].'" del proyecto "'.$datos['propuesta'].'" y tiene sugerencias para realizar:<br>';
		$data['contenido'] = nl2br($datos['motivo']);
		$data['contenido'] .= '<br><br>Una vez realizados los ajustes, podrá subir el documento nuevamente a la plataforma. Si tiene alguna duda, puede contactarse con la STA escribiendo a secretaria-ftg@iadb.org';

		$this->CI->load->model('Alerta');
		$idalerta = $this->CI->Alerta->crear($data['titulo'], $data['subtitulo'].'<br><br>'.$data['contenido'], "");
		//$this->CI->Alerta->agregarUsuario($idalerta, $usuario['idusuario']);

        $mseg = $this->CI->load->view('iniciativas/mail', $data, true);        
		$subject = 'Fontagro - '.$data['titulo'];		
		//$this->enviarMail($usuario['email'], $subject, $mseg, Array('justina@animus.com.ar'=>'Seba'));
	}

    public function enviarEmailProductoAceptado($datos, $usuario){				

		$data=array();
		$data['titulo'] = 'La STA ha revisado su Producto de Conocimiento y se ha publicado';
		$data['titulo_cuerpo'] = '';
		$data['subtitulo'] = 'Estimado/a '.$usuario['nombre'].',<br>Le informamos que la Secretaría Técnica Administrativa ha publicado su Producto de conocimiento "'.$datos['producto'].'" del proyecto "'.$datos['propuesta'].'"';
		$data['contenido'] = '';
		$data['url'] = LINK_PROYECTOS.$datos['web_url'];
		$data['url_accion'] = 'Link al Proyecto';

		$this->CI->load->model('Alerta');
		$idalerta = $this->CI->Alerta->crear($data['titulo'], $data['subtitulo'].'<br><br>'.$data['contenido'], "");
		//$this->CI->Alerta->agregarUsuario($idalerta, $usuario['idusuario']);

        $mseg = $this->CI->load->view('iniciativas/mail', $data, true);        
		$subject = 'Fontagro - '.$data['titulo'];		
		//$this->enviarMail($usuario['email'], $subject, $mseg);
	}

	public function enviarMail($to, $subject, $mseg, $bccs=Array()){
		require("application/libraries/sendgrid/sendgrid-php.php");
		$email = new \SendGrid\Mail\Mail();
		$email->setFrom("fontagro@iadb.org", "FONTAGRO");
		$email->setSubject($subject);
		$email->addTo($to);
		if(!empty($bccs)){
			$email->addBccs($bccs);
		}
		$email->addContent("text/html", $mseg);
		
		$sendgrid = new \SendGrid($this->CI->config->item('sendgrid_api_key'));
		try {
			$response = $sendgrid->send($email);
		} catch (Exception $e) {
			echo 'Caught exception: '. $e->getMessage() ."\n";
		}
	}
	

	public function random_str($length, $keyspace = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'){
        require_once 'application/libraries/random_compat/lib/random.php';
        $str = '';
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $str .= $keyspace[random_int(0, $max)];
        }
        return $str;
	}
	
	public function crearAlerta($titulo, $contenido, $link, $tipo, $enviarMails = TRUE, $param=''){
		$this->CI->load->model('Alerta');
		$idalerta = $this->CI->Alerta->crear($titulo, $contenido, $link);
		$mails = $this->CI->Alerta->agregarUsuarios($idalerta, $tipo, $param);
		if($enviarMails && !empty($mails)){

			$data=array();
			$data['titulo_cuerpo'] = $titulo;
			$data['subtitulo'] = 'Esta es una notificación generada por el sistema';
			$data['contenido'] = nl2br($contenido);
			$data['url'] = $link;
			$data['url_accion'] = 'VER';
			$data['url_aclaracion'] = 'o copie y puegue el siguiente link';

			$mseg = $this->CI->load->view('iniciativas/mail', $data, true);			
			$subject = 'Fontagro - '.$titulo;
			$this->enviarMail('fontagro@iadb.org', $subject, $mseg, $mails);
		}
	}
	/*
	$data=array();
			$data['titulo_cuerpo'] = ;
			$data['subtitulo'] = ;
			$data['contenido'] = ;
			$data['url'] = ;
			$data['url_accion'] = ;
			$data['url_aclaracion'] = ;	
	*/ 
}
?>
