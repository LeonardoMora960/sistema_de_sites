<?php
if (!defined('BASEPATH'))
exit('No direct script access allowed');

class Mantenimiento_datos extends CI_Controller{

	var $argumento = array();
	var $cache_vipo_buscar = "__cache__Formulario__";
	var $limite_pagina = 10; //Limite por pagina
  	var $limite_pagina_cobranza = 1000; //Limite por pagina
  	var $tiempo_cache = 300; //5 minutos
	
	public function __construct(){
		parent::__construct();
		$this->load->model("utilitarios/formulario_model", "formulario");
		$this->load->model('process_model','administracion');
		$this->load->driver('cache', array('adapter' => 'file'));
		
		$this->iIdUsuario = $this->session->userdata('iIdUsuario');
		$this->Usuario = $this->session->userdata('usuario');
		$this->nombre = $this->session->userdata('nombre');
		$this->apellidos = $this->session->userdata('apellidos');
		
		$this->get_session();
		
		$this->argumento["modulo"] = $this->formulario->get_permiso_modulo($this->iIdUsuario);
	}
	
	private function get_session() {
        $this->argumento["iIdUsuario"] = $this->iIdUsuario;
        $this->argumento["Usuario"] = $this->Usuario;
		$this->argumento["NombreUsuario"] = $this->nombre.' '.$this->apellidos;
    }
	
	private function js($arg1 = "") {
        $js = "";
        switch ($arg1) {
            case "ingreso":
                $js = "<script src=\"assets/js/registroingresosalida/ingreso.js\"></script>";
				/*$js .= "<script type=\"text/javascript\">var gcontroller = 'registroingresosalida';var gmethod = 'ingreso';</script>";*/

                break;
				
            case "formulario":
                $js = "<script src=\"".base_url()."public/js/formulario/mantenimiento_dato.js\"></script>";
				$js .= "<script type=\"text/javascript\">var gcontroller = 'mantenimiento_datos';var gmethod = 'index';var gform = 'frm_busqueda';gtitle = 'Registro de Mantenimiento de Datos';</script>";
				
                break;
        }
        $this->argumento["jw_jsoptional"] = $js;
    }
	
	public function index()
	{
		$id = $this->formulario->get_detalleformulario_id_limit();
		$this->argumento["title"] = "Registrar mantenimiento de datos";
		$this->js("formulario");
		$this->load->view('template/header', $this->argumento);
		$this->argumento["opciones"] = $this->formulario->get_permisos_opciones($this->iIdUsuario, 5);
		$this->pagina="utilitarios/mantenimiento_dato";
		$this->argumento["iIdDetalleFormulario"]= $id;
		$this->argumento["tabla"]= $this->formulario->get_detalleformulario_by_id($id);
		$this->argumento["detalleformulario"]= $this->formulario->get_detalleformulario_select();
		$this->load->view($this->pagina, $this->argumento);
		$this->load->view('template/footer');
	}
	
	function ver_mantenimiento_dato($id){
		
		$this->argumento["title"] = "Registrar mantenimiento de datos";
		$this->js("formulario");
		$this->load->view('template/header',$this->argumento);
		$this->argumento["opciones"] = $this->formulario->get_permisos_opciones($this->iIdUsuario, 5);
		$this->pagina="utilitarios/mantenimiento_dato";
		$this->argumento["iIdDetalleFormulario"]= $id;
		$this->argumento["tabla"]= $this->formulario->get_detalleformulario_by_id($id);
		$this->argumento["detalleformulario"]= $this->formulario->get_detalleformulario_select();
		$this->load->view($this->pagina,$this->argumento);
		$this->load->view('template/footer');
		
	}

	public function ver_categoria()
	{
		$this->argumento["title"] = "Registrar mantenimiento de datos";
		$this->js("formulario");
		$this->load->view('template/header',$this->argumento);
		$this->argumento["opciones"] = $this->formulario->get_permisos_opciones($this->iIdUsuario,5);
		$this->pagina="utilitarios/mantenimiento_categoria";
		$this->argumento["iIdDetalleFormulario"]= 0;
		$this->argumento["detalleformulario"]= $this->formulario->get_detalleformulario_select();
		$this->load->view($this->pagina,$this->argumento);
		$this->load->view('template/footer');
	}
	
	
	function buscar_tabla_all()
	{
		if ($_POST["nav"] == 1) {
			$array =array();
			$dato 	= $this->formulario->get_campo_detalleformulario($_POST['iIdDetalleFormulario']);
			if (empty($dato)) {
				return;
			}
			$_POST['tabla'] = 'fase_' . $dato->locales_formulario_fase . '_fase_id_' . $dato->locales_formulario_fase_id . '_' . strtolower($dato->campo);
			$array = $_POST;
			$this->argumento["resultado"] = $this->cache->get($this->cache_vipo_buscar);
		} else {
			$array =array();
			$dato 	= $this->formulario->get_campo_detalleformulario($_POST['iIdDetalleFormulario']);
			if (empty($dato)) {
				return;
			}
			$_POST['tabla'] = 'fase_' . $dato->locales_formulario_fase . '_fase_id_' . $dato->locales_formulario_fase_id . '_' . strtolower($dato->campo);
			$array = $_POST;
			
			$this->argumento["resultado"] = ObtenerCacheFile($this->cache_vipo_buscar, $this->formulario->buscar_tabla_all($array), $this->tiempo_cache);
			
		}
		
		$page = (isset($_POST['page']) && !empty($_POST['page'])) ? $_POST['page'] : 1;
		if ($page == 0)$page = 1;
		$this->argumento["tabla"] = isset($_POST['tabla']) ? $_POST['tabla'] : '';
		$this->argumento["opciones"] = $this->formulario->get_permisos_opciones($this->iIdUsuario,5);
		$this->argumento["total"] = count($this->argumento["resultado"]);
		$this->argumento["limit"] = $this->limite_pagina;
		$this->argumento["page"] = $page;
		
		$this->load->view("utilitarios/mantenimiento_dato_ajax", $this->argumento);
		
	}

	public function buscar_categoria_all()
	{
		if ($_POST["nav"] == 1) {
			$this->argumento["resultado"] = $this->cache->get($this->cache_vipo_buscar);
		} else {
			$array =array();
			$array = $_POST;
			
			$this->argumento["resultado"] = ObtenerCacheFile($this->cache_vipo_buscar, $this->formulario->buscar_categoria_all($array), $this->tiempo_cache);
		}
		
		$page = (isset($_POST['page']) && !empty($_POST['page'])) ? $_POST['page'] : 1;
		if ($page == 0)$page = 1;
		
		$this->argumento["opciones"] = $this->formulario->get_permisos_opciones($this->iIdUsuario,5);
		$this->argumento["total"] = count($this->argumento["resultado"]);
		$this->argumento["limit"] = $this->limite_pagina;
		$this->argumento["page"] = $page;
		
		$this->load->view("utilitarios/mantenimiento_categoria_ajax", $this->argumento);
		
	}	

	public function agregar_data_tabla()
	{
		
		$dato 	= $this->formulario->get_campo_detalleformulario($_POST['iIdDetalleFormulario']);
		unset($_POST['iIdDetalleFormulario']);
		
		$dato->campo = 'fase_' . $dato->locales_formulario_fase . '_fase_id_' . $dato->locales_formulario_fase_id . '_' . $dato->campo;
		$id_key	= $dato->campo;
		$tabla 	= 'locales_'.strtolower($dato->campo);
		
		$val_id = $_POST['id'];
		unset($_POST['id']);
		
		$_POST[$id_key] = $val_id;
		$data 	= $_POST;
		
		if (!empty($_POST[$id_key])){
			$id = $_POST[$id_key];
			$this->formulario->update_tabla($id,$data,$tabla,$id_key);
		} else{
			$id = $this->formulario->save_tabla($data,$tabla);
		}
		
		echo "success";
	}
	
	function agregar_categoria(){
		
		if (!empty($_POST['id'])){
			$id = $_POST['id'];
			unset($_POST['id']);
			$data 	= $_POST;
			$this->formulario->update_categoria($id,$data);
		}else{
			unset($_POST['id']);
			$data 	= $_POST;
			$id = $this->formulario->save_categoria($data);
		}
		
		echo "success";
	
	
	}
	
	
	function eliminar_registro() {
		$table = $this->input->post('table');
		$iIdDetalleFormulario = $this->input->post("iIdDetalleFormulario");
		
		$dato 	= $this->formulario->get_campo_detalleformulario($iIdDetalleFormulario);
		$tabla 	= strtolower($dato->campo);	
			  
		$informacion = array(
						    'table' => 'locales_' . $table,
						    'condicion' => $table,
						    'valor' => $this->input->post("id")
						   );
					 
		$data = array('eEstado'=>3);
					 
        $respuesta = $this->formulario->update_registro($informacion, $data);

        if ($respuesta) {
            echo 1;
        } 
    }
	
	function eliminar_categoria() {
		$informacion = array(
						    'table' => 'locales_fase_3_fase_id_2_categoria',
						    'condicion' => 'fase_3_fase_id_2_categoria',
						    'valor' => $this->input->post("id")
		 );
					 
		$data = array('eEstado'=>3);
					 
        $respuesta = $this->formulario->update_registro($informacion,$data);

        if ($respuesta) {
            echo 1;
        } 
    }
	
	

}


?>