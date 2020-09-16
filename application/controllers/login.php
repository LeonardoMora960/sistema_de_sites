<?php

class Login extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('process_model');
	}

	public function index($valid = NULL){
		if(!$valid){
			$data['error']=NULL;
			$this->load->view('logtemplate/header');
			$this->load->view('login/index', $data);
			$this->load->view('logtemplate/footer');	
		}else{
			$data['error']="<span class='error'>Por favor verifique sus datos</span>";
			$this->load->view('logtemplate/header');
			$this->load->view('login/index', $data);
			$this->load->view('logtemplate/footer');	
		}
		
	}
	
	public function process(){
		$validar = $this->process_model->ingresar($this->input->post('usuario'), $this->input->post('contrasena'));
		if($validar>0){
			$data=array("usuario"=>$this->input->post("usuario"),"contrasena"=>$this->input->post("contrasena"));
			$management = $this->process_model->get_management($data);
			if($management){
				foreach($management as $item){
					$sesion = array(
					'iIdUsuario' 	=> $item->iIdUsuario,
					'usuario'   	=> $item->usuario,
					'nombre'    	=> $item->nombre,
					'apellidos'  	=> $item->apellidos
					);
				}
			}
			
			$this->session->set_userdata($sesion);
			
			$data_log = array(
							   'iIdEvento' 	=> 1,
							   'iIdUsuario'	=> $this->session->userdata('iIdUsuario'),
							   'dFecha_Log'	=> date('Y-m-d H:i:s'),
							   'vIp' 		=> getRealIP(),
							   'dRegistro' 	=> date('Y-m-d H:i:s')
								);
								
			$this->process_model->save_log($data_log);
			
			exit('success');
		}else{
			//redirect('login/index/error');
			//exit('Su usuario y/o contraseña es incorrecto, intente nuevamente');	
		}
	}
	
	function recuperar_clave(){
		$this->load->view('login/recoverkey');
		$this->load->view('logtemplate/footer');
	}
	
	function sendclave(){
		
		$validar = $this->process_model->recoverkey($this->input->post('usuario'));
		
		if($validar>0):
			
			$usu = $this->process_model->get_datos_usuario($this->input->post('usuario'));
			
			$mailcontent = '';
			$mailcontent.='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Documento sin titulo</title>
	</head>
	<body>';
	
			$mailcontent.= "<br/><br/><span style='font-weight:bold;color:#1F497D;display:block;'>Estimado(a) </span><span style='color:#1F497D'>".$usu->nombre." ".$usu->apellidos."</span><br/><br/><br/>";
			$mailcontent.= "<span style='color:#1F497D;display:block;'>Este correo electr&oacute;nico ha sido enviado debido a una solicitud de restablecimiento de contrase&ntilde;a.</span><br/><br/>";
			$mailcontent.= "<span style='color:#1F497D;display:block;'>Si esta informaci&oacute;n es correcta y desea restablecer su contrase&ntilde;a, por favor haga clic en el siguiente enlace</span> <a style='color:#54A1EA' href='".base_url()."login/restablecer_contrasena'>CONFIRMAR RECUPERACIÓN DE CONTRASE&Ntilde;A</a><br/><br/>";
			
			$mailcontent.= "<span style='color:#1F497D;display:block;'>En caso contrario, le pedimos que ignore este aviso y continúe utilizando sus credenciales de acceso (usuario y contrase&ntilde;a) con total normalidad como hasta ahora.</span><br/><br/><br/>";

			$mailcontent.= "<span style='color:#1F497D;display:block;'>Atte.</span><br/><br/>";
			
			$mailcontent.= "<span style='color:#1F497D;display:block;'>El Administrador - Sistema de Administraci&oacute;n de Locales</span><br/><br/>";
			
			$email = $usu->usuario;
			//$email = "wyamunaque@amconsultores.com.pe";
	
			$config_mail = Array('mailtype' => 'html','charset'=>'iso-8859-1');
			$this->load->library('email',$config_mail);		
			
			$correo_usuario = "administrador@telefonica.com";
			$this->email->to($email);
			$this->email->from('Soporte Telefonica',$correo_usuario);
			$this->email->cc('gbravo@amconsultores.com.pe,kvega@amconsultores.com.pe');
			$this->email->subject('Restablecer contraseña - Sistema de Administración de Locales');
			$this->email->message($mailcontent);
			$this->email->send();
			$this->email->print_debugger();
			
			echo "success";
		else:
			
			echo "El correo ingresado no es correcto";
			
		endif;
	}
	
	function restablecer_contrasena(){
		
		$this->load->view('login/restablecer_contrasena');
		$this->load->view('logtemplate/footer');
		
	}
	
	function logout(){
		
		$data_log = array(
					   'iIdEvento' 	=> 2,
					   'iIdUsuario'	=> $this->session->userdata('iIdUsuario'),
					   'dFecha_Log'	=> date('Y-m-d H:i:s'),
					   'vIp' 		=> getRealIP(),
					   'dRegistro' 	=> date('Y-m-d H:i:s')
						);
						
	  	$this->process_model->save_log($data_log);
	  
		session_destroy();
	  	redirect(base_url());
		
	}	
	
	function update_usuario(){
				
		$usu = $this->process_model->get_datos_usuario($this->input->post('usuario'));
		$iIdUsuario = $usu->iIdUsuario;
		
		$data = array(
						'contrasena' => $this->input->post('contrasena')
					);
		
		$this->process_model->update_usuario($iIdUsuario,$data);
		
		echo "success";
	
	}
	
}

?>
