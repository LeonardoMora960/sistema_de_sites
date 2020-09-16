<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {
	
	var $argumento = array();
	var $cache_vipo_buscar = "__cache__Formulario__";
	var $limite_pagina = 15; //Limite por pagina
  	var $limite_pagina_cobranza = 1000; //Limite por pagina
  	var $tiempo_cache = 300; //5 minutos
	
	public function __construct(){
		parent::__construct();
		$this->load->model("registro/registro_model", "registro");
		$this->load->model('process_model','administracion');
		$this->load->driver('cache', array('adapter' => 'file'));
		
		$this->iIdUsuario = $this->session->userdata('iIdUsuario');
		$this->Usuario = $this->session->userdata('usuario');
		$this->nombre = $this->session->userdata('nombre');
		$this->apellidos = $this->session->userdata('apellidos');
		
		$this->get_session();
		
		$this->argumento["modulo"] = $this->registro->get_permiso_modulo($this->iIdUsuario);
		
	}

	private function get_session() {
        $this->argumento["iIdUsuario"] = $this->iIdUsuario;
        $this->argumento["Usuario"] = $this->Usuario;
		$this->argumento["NombreUsuario"] = $this->nombre.' '.$this->apellidos;
    }
	
	public function index(){
		$this->argumento["title"] = "Bienvenidos";
		$this->load->view('template/header',$this->argumento);
		$this->load->view('home/slider',$this->argumento);
		$this->pagina="home/index";
		$this->load->view($this->pagina,$this->argumento);
		$this->load->view('template/footer');
	}
	
	function mapa_sitio(){
		$this->argumento["title"] = "Bienvenidos";
		$this->load->view('template/header',$this->argumento);
		$this->load->view('home/slider',$this->argumento);
		$this->pagina="home/mapa_sitio";
		$this->load->view($this->pagina,$this->argumento);
		$this->load->view('template/footer');
	}

}

/* End of file home.php */
/* Location: ./application/controllers/home.php */

?>
