<?php
if (!defined('BASEPATH'))
exit('No direct script access allowed');

class Administracion_formulario extends CI_Controller{

	var $argumento = array();
	var $cache_vipo_buscar = "__cache__Formulario__";
	var $limite_pagina = 15; //Limite por pagina
  	var $limite_pagina_cobranza = 1000; //Limite por pagina
  	var $tiempo_cache = 300; //5 minutos
  		
	public function __construct(){
		parent::__construct();
		$this->load->model("utilitarios/formulario_model", "formulario");
		$this->load->model('utilitarios/formulario_fase_dos_model', 'formulario_fase_dos');
		$this->load->model('utilitarios/formulario_fase_tres_model', 'formulario_fase_tres');
		$this->load->model('utilitarios/formulario_fase_cuatro_model', 'formulario_fase_cuatro');
		$this->load->model('utilitarios/formulario_fase_cinco_model', 'formulario_fase_cinco');
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
                $js = "<script src=\"".base_url()."public/js/formulario/formulario.js\"></script>";
				$js .= "<script type=\"text/javascript\">var gcontroller = 'administracion_formulario';var gmethod = 'index';var gform = 'frm_busqueda';gtitle = 'Registro de Administracion de Formularios';</script>";
				
            break;
			
			case "importacion_masiva":
                $js = "<script src=\"".base_url()."public/js/formulario/importacion_masiva.js\"></script>";
				$js .= "<script type=\"text/javascript\">var gcontroller = 'administracion_formulario';var gmethod = 'importacion_masiva';var gform = 'frm_busqueda';gtitle = 'Registro de Administracion de Formularios';</script>";
				
            break;
        }
        $this->argumento["jw_jsoptional"] = $js;
    }
	
	function index()
	{
		$this->argumento["title"] = "Registrar formulario";
		$this->js("formulario");
		$this->load->view('template/header',$this->argumento);
		$this->argumento["opciones"] = $this->formulario->get_permisos_opciones($this->iIdUsuario,4);
		$this->pagina="utilitarios/formulario";
		$this->argumento["formulario"]= $this->formulario->get_formulario();
		$this->argumento["tipocampo"]= $this->formulario->get_tipocampo();

		$this->load->view($this->pagina,$this->argumento);
		$this->load->view('template/footer');
	}

	public function buscar_detalleformulario_all()
	{
		$fase = $this->input->post('fase');
		$fase_id = $this->input->post('fase_id');
		$nav = $this->input->post('nav');
		$page = $this->input->post('page');

		if ($nav == 1) {
			$this->argumento['resultado'] = $this->cache->get($this->cache_vipo_buscar);
		} else {
			$array = [];
			$array = $_POST;
			
			$this->argumento['resultado'] = ObtenerCacheFile($this->cache_vipo_buscar, $this->formulario->buscar_detalleformulario_all($array), $this->tiempo_cache);
		}
		
		$page = (!empty($page)) ? $page: 1;
		if ($page == 0) $page = 1;
		
		$this->argumento['total'] = count($this->argumento['resultado']);
		$this->argumento['limit'] = $this->limite_pagina;
		$this->argumento['page'] = $page;
		$this->argumento['fase'] = $fase;
		$this->argumento['fase_id'] = $fase_id;
		$this->argumento['opciones'] = $this->formulario->get_permisos_opciones($this->iIdUsuario, 4);
		$this->load->view('utilitarios/formulario_ajax', $this->argumento);
	}

	public function formulario_filter()
	{
		$fase = $this->input->post('fase');
		$fase_id = $this->input->post('fase_id');
		$data['function_formulario'] = (empty($fase) ? 'Buscar()': 'Buscar(false, false, ' . $fase . ', ' . $fase_id . ')');
		$this->load->view('utilitarios/formulario/filter', $data);
	}

	// Fase 2
	public function select_fase_dos()
	{
		$select_fase_uno = $this->input->post('select_fase_uno');
		$data['registers'] = $this->formulario_fase_dos->getAllTipoUno($select_fase_uno);
		$data['id_formulario'] = $select_fase_uno;
		$this->load->view('utilitarios/formulario/dos', $data);
	}

	public function guardar_fase_dos()
	{
		$id_formulario = $this->input->post('id_formulario');
		$id = $this->input->post('id');
		$nombre = $this->input->post('nombre');
		if (empty($id)) {
			$this->formulario_fase_dos->saveFaseDos([
				'locales_usuario_reg' => $this->iIdUsuario,
				'locales_formulario' => $id_formulario,
				'nombre' => $nombre,
			]);
		} else {
			$this->formulario_fase_dos->updateFaseDos(
				$id,
				[
					'locales_usuario_mod' => $this->iIdUsuario,
					'modificacion' => date('Y-m-d H:i:s'),
					'nombre' => $nombre,
				]
			);
		}
	}

	public function eliminar_fase_dos()
	{
		$id = $this->input->post('id');
		$this->formulario_fase_dos->deleteFaseDos($id);
	}

	public function recuperar_fase_dos()
	{
		$id = $this->input->post('id');
		$this->formulario_fase_dos->restoreFaseDos($id);
	}

	public function select_fase_tres()
	{
		$select_fase_dos = $this->input->post('select_fase_dos');
		$data['registers'] = $this->formulario_fase_tres->getAllTipoDos($select_fase_dos);
		$data['id_formulario'] = $select_fase_dos;
		$this->load->view('utilitarios/formulario/tres', $data);
	}

	public function guardar_fase_tres()
	{
		$id_formulario = $this->input->post('id_formulario');
		$id = $this->input->post('id');
		$nombre = $this->input->post('nombre');
		if (empty($id)) {
			$this->formulario_fase_tres->saveFaseTres([
				'locales_usuario_reg' => $this->iIdUsuario,
				'locales_formulario' => $id_formulario,
				'nombre' => $nombre,
			]);
		} else {
			$this->formulario_fase_tres->updateFaseTres(
				$id,
				[
					'locales_usuario_mod' => $this->iIdUsuario,
					'modificacion' => date('Y-m-d H:i:s'),
					'nombre' => $nombre,
				]
			);
		}
	}

	public function eliminar_fase_tres()
	{
		$id = $this->input->post('id');
		$this->formulario_fase_tres->deleteFaseTres($id);
	}

	public function recuperar_fase_tres()
	{
		$id = $this->input->post('id');
		$this->formulario_fase_tres->restoreFaseTres($id);
	}

	// Fase 4
	public function select_fase_cuatro()
	{
		$select_fase_tres = $this->input->post('select_fase_tres');
		$data['registers'] = $this->formulario_fase_cuatro->getAllTipoTres($select_fase_tres);
		$data['id_formulario'] = $select_fase_tres;
		$this->load->view('utilitarios/formulario/cuatro', $data);
	}

	public function guardar_fase_cuatro()
	{
		$id_formulario = $this->input->post('id_formulario');
		$id = $this->input->post('id');
		$nombre = $this->input->post('nombre');
		if (empty($id)) {
			$this->formulario_fase_cuatro->saveFaseCuatro([
				'locales_usuario_reg' => $this->iIdUsuario,
				'locales_formulario' => $id_formulario,
				'nombre' => $nombre,
			]);
		} else {
			$this->formulario_fase_cuatro->updateFaseCuatro(
				$id,
				[
					'locales_usuario_mod' => $this->iIdUsuario,
					'modificacion' => date('Y-m-d H:i:s'),
					'nombre' => $nombre,
				]
			);
		}
	}

	public function eliminar_fase_cuatro()
	{
		$id = $this->input->post('id');
		$this->formulario_fase_cuatro->deleteFaseCuatro($id);
	}

	public function recuperar_fase_cuatro()
	{
		$id = $this->input->post('id');
		$this->formulario_fase_cuatro->restoreFaseCuatro($id);
	}

	// Fase 5
	public function select_fase_cinco()
	{
		$select_fase_cuatro = $this->input->post('select_fase_cuatro');
		$data['registers'] = $this->formulario_fase_cinco->getAllTipoCuatro($select_fase_cuatro);
		$data['id_formulario'] = $select_fase_cuatro;
		$this->load->view('utilitarios/formulario/cinco', $data);
	}

	public function guardar_fase_cinco()
	{
		$id_formulario = $this->input->post('id_formulario');
		$id = $this->input->post('id');
		$nombre = $this->input->post('nombre');
		if (empty($id)) {
			$this->formulario_fase_cinco->saveFaseCinco([
				'locales_usuario_reg' => $this->iIdUsuario,
				'locales_formulario' => $id_formulario,
				'nombre' => $nombre,
			]);
		} else {
			$this->formulario_fase_cinco->updateFaseCinco(
				$id,
				[
					'locales_usuario_mod' => $this->iIdUsuario,
					'modificacion' => date('Y-m-d H:i:s'),
					'nombre' => $nombre,
				]
			);
		}
	}

	public function eliminar_fase_cinco()
	{
		$id = $this->input->post('id');
		$this->formulario_fase_cinco->deleteFaseCinco($id);
	}

	public function recuperar_fase_cinco()
	{
		$id = $this->input->post('id');
		$this->formulario_fase_cinco->restoreFaseCinco($id);
	}

	public function agregar_detalleformulario()
	{
		$this->db->trans_begin();
		$data = $_POST;
		$bandera = 0;
		$campo2	= '';
		$tipodato2 = '';

		$fase = $this->input->post('locales_formulario_fase');
		$fase_id = $this->input->post('locales_formulario_fase_id');
		$iIdDetalleFormulario = $this->input->post('iIdDetalleFormulario');

		if (!empty($iIdDetalleFormulario)) {
			if (empty($data['cNumerico'])) {
				$data['cNumerico'] = 0;
			}
			if (empty($data['cObligatorio'])) {
				$data['cObligatorio'] = 0;
			}
			
			if (empty($data['alert_expiration'])) {
				$data['alert_expiration'] = 0;
			}


			$id_formulario = $iIdDetalleFormulario;
			$name_formulario = 'iIdDetalleFormulario';
			$datos2 = $this->formulario->get_campo_detalleformulario($id_formulario);
			$campo2 =  'fase_' . $fase . '_fase_id_' . $fase_id . '_' . strtolower($datos2->campo);
			$tipodato2 = $datos2->iIdTipoCampo;
			$this->formulario->update_detalleformulario($id_formulario, $data, $name_formulario);
			$bandera = 2;
		} else {
			$iIdDetalleFormulario = $this->formulario->save_detalleformulario($data);
			$bandera = 1;
		}
		
		$datos1 = $this->formulario->get_campo_detalleformulario($iIdDetalleFormulario);
		$campo1 = strtolower($datos1->campo);
		$tipodato1 = $datos1->iIdTipoCampo;

		if (!empty($fase)) {
			$campo1 = 'fase_' . $fase . '_fase_id_' . $fase_id . '_' . $campo1;
		}

		$tabla = $this->input->post('iIdFormulario');
		$response = $this->formulario->add_alter_column($bandera, $tabla, $campo1, $tipodato1, $campo2, $tipodato2);
		if ($response == 1 || $response == 3) {
			$this->db->trans_commit();
		} else {
			$this->db->trans_rollback();
		}
		echo $response;
	}

	function importacion_masiva(){
	
		$this->argumento["title"] = "Registrar importacion masiva";
		$this->js("importacion_masiva");
		$this->load->view('template/header',$this->argumento);
		$this->argumento["opciones"] = $this->formulario->get_permisos_opciones($this->iIdUsuario,3);
		$this->pagina="utilitarios/importacion_masiva";
		$this->argumento["categoria"]= $this->formulario->get_categoria();
		$this->load->view($this->pagina,$this->argumento);
		$this->load->view('template/footer');	
	
	}
	
	function upload_importacion_masiva(){
		
		$ruta = 'public/images/documento/';
		$mensage = '';
		foreach ($_FILES as $key):
			if($key['error'] == UPLOAD_ERR_OK ):
				$NombreOriginal = $key['name'];
				$temporal = $key['tmp_name'];
				$Destino = $ruta.$NombreOriginal;
				move_uploaded_file($temporal, $Destino);
			endif;
		
			if($key['error']==''):
				$NombreLocal = explode('_',$NombreOriginal);
				$iIdLocal 			= '';
				$nombre_de_local 	= '';
				if(isset($NombreLocal[0]) && strlen(trim($NombreLocal[0])) > 0):
					$iIdLocal 			= '';
					$nombre_de_local 	= '';
					$datos_local = $this->formulario->get_datos_local($NombreLocal[0],$NombreOriginal);
					if($datos_local):
						$iIdLocal 			= $datos_local->iIdLocal;
						$nombre_de_local 	= $datos_local->nombre_de_local;
						$codigo_de_local	= $NombreLocal[0];
					endif;
				endif;
				$mensage .= ','.$NombreOriginal.'@'.$iIdLocal.'@'.$nombre_de_local.'@'.$codigo_de_local;
			endif;
			
		endforeach;
		
		echo $mensage;

		/*****************/
		//$file = $_FILES['file'];
		//move_uploaded_file($_FILES["file"]["tmp_name"], 'public/images/documento/' . $_FILES["file"]["name"]);
		
		//echo "success";
		
	}

	public function agregar_masivo()
	{
		parse_str($this->input->post('formdata'),$_FORM);
		
		$this->formulario->save_detalledocumento_masivo($_FORM['iIdCategoria'],$this->input->post('detalle'));
		
		echo "success";
	
	}
}

?>