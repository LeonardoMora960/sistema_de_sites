<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Registro extends CI_Controller
{

	var $argumento = [];
	var $cache_vipo_buscar = '__cache__Formulario__';
	var $limite_pagina = 10; //Limite por pagina
  	var $limite_pagina_cobranza = 1000; //Limite por pagina
  	var $tiempo_cache = 300; //5 minutos
  		
	public function __construct()
	{
		parent::__construct();
		$this->load->model('registro/registro_model', 'registro');
		$this->load->model('process_model', 'administracion');
		$this->load->model('utilitarios/formulario_fase_dos_model', 'formulario_fase_dos');
		$this->load->model('utilitarios/formulario_fase_cuatro_model', 'formulario_fase_cuatro');
		$this->load->model('utilitarios/formulario_fase_cinco_model', 'formulario_fase_cinco');
		
		$this->load->driver('cache', ['adapter' => 'file']);
		
		$this->iIdUsuario = $this->session->userdata('iIdUsuario');
		$this->Usuario = $this->session->userdata('usuario');
		$this->nombre = $this->session->userdata('nombre');
		$this->apellidos = $this->session->userdata('apellidos');
		
		$this->get_session();

		$this->argumento['modulo'] = $this->registro->get_permiso_modulo($this->iIdUsuario);
		
	}
	
	private function get_session()
	{
        $this->argumento['iIdUsuario'] = $this->iIdUsuario;
        $this->argumento['Usuario'] = $this->Usuario;
		$this->argumento['NombreUsuario'] = $this->nombre . ' ' . $this->apellidos;
    }
	
	private function js($arg1 = '')
	{
        $js = '';
        switch ($arg1) {
            case 'busqueda':
                $js = '<script src="' . base_url() . 'public/js/registro/busqueda.js"></script>';
				$js .= "<script type=\"text/javascript\">
						var gcontroller = 'administracion_formulario';
						var gmethod = 'index';
						var gform = 'frm_busqueda';
						gtitle = 'Registro de Administracion de Formularios';
					</script>";

            break;
				
            case 'registro':
                $js = '<script src="' . base_url() . 'public/js/registro/registro.js?v=1.0.1"></script>';
				$js .= "<script type=\"text/javascript\">
						var gcontroller = 'registro';
						var gmethod = 'imagenes';
						var gform = 'frm_busqueda';
						gtitle = 'Registro de Administracion de Formularios';
					</script>";
				
            break;
			
			case 'imagenes':
                $js = '<script src="' . base_url() . 'public/js/registro/imagen.js"></script>';
				$js .= "<script type=\"text/javascript\">
						var gcontroller = 'registro';
						var gmethod = 'documentos';
						var gform = 'frm_busqueda';
						gtitle = 'Registro de Administracion de Formularios';
					</script>";
				
            break;
			
			case 'documento':
                $js = '<script src="' . base_url() . 'public/js/registro/documento.js"></script>';
				$js .= "<script type=\"text/javascript\">
						var gcontroller = 'registro';
						var gmethod = 'documentos';
						var gform = 'frm_busqueda';
						gtitle = 'Registro de Administracion de Formularios';
					</script>";
				
            break;
			
			case 'ubicacion':
                $js = '<script src="' . base_url() . 'public/js/registro/ubicacion.js"></script>';
				$js .= "<script type=\"text/javascript\">
						var gcontroller = 'registro';
						var gmethod = 'ubicacion';
						var gform = 'frm_busqueda';
						gtitle = 'Registro de Administracion de Formularios';
					</script>";
				
            break;
        }
        $this->argumento['jw_jsoptional'] = $js;
    }
		
	public function index()
	{
		$this->argumento['title'] = 'Registrar formulario';
		$this->js('registro');
		
		$detalleformulario = $this->registro->get_detalleformulario_by_idformulario_idusuario($this->iIdUsuario, 1);
		
		$formato_c1 = [];
		$formato_c2 = [];
		
		$columna[1] = [];
		$columna[2] = [];
		$i = 0;
		$column_number = 1;
		foreach ($detalleformulario as $row_detalleformulario):
			$i++;
			if ($i > 7) {
				$i = 0;
				$column_number = ($column_number == 1) ? 2: 1;
			}
			$columna[$column_number][] = [
				'vNombre' => $row_detalleformulario->vNombre,
				'campo' => strtolower($row_detalleformulario->campo),
				'iIdTipoCampo' => $row_detalleformulario->iIdTipoCampo,
				'cObligatorio' => $row_detalleformulario->cObligatorio,
				'cNumerico' => $row_detalleformulario->cNumerico,
				'locales_formulario_fase' => $row_detalleformulario->locales_formulario_fase,
				'locales_formulario_fase_id' => $row_detalleformulario->locales_formulario_fase_id,
			];
		endforeach;
		
		$this->argumento['columna1'] = $columna[1];
		$this->argumento['columna2'] = $columna[2];
		
		$this->load->view('template/header',$this->argumento);
		$this->argumento['tabs'] = $this->registro->get_permiso_tab($this->iIdUsuario, 1);
		
		$this->argumento['opciones'] = $this->registro->get_permisos_opciones($this->iIdUsuario, 1);

		$this->argumento['menu_items'] = $this->formulario_fase_dos->getAllTipoUnoActivo(1);
		
		$this->pagina = 'locales/index';
		$this->load->view($this->pagina, $this->argumento);
		$this->load->view('template/footer');
	}

	public function ver_local($id)
	{
		$this->argumento['title'] = 'Registrar formulario';
		$this->argumento["tab_name"] = 'datos principales';
		$this->js('registro');

		/*
		$detalleformulario = $this->registro->get_detalleformulario_by_idformulario_idusuario($this->iIdUsuario, 1);

		$formato_c1 = [];
		$formato_c2 = [];
		$campos = '';
		
		$columna[1] = [];
		$columna[2] = [];
		$i = 0;
		$column_number = 1;
		foreach ($detalleformulario as $row_detalleformulario):
			$i++;
			if ($i > 7) {
				$i = 0;
				$column_number = ($column_number == 1) ? 2: 1;
			}
			$detalle_formulario = new stdClass();
			$detalle_formulario->vNombre = $row_detalleformulario->vNombre;
			$detalle_formulario->campo = strtolower($row_detalleformulario->campo);
			$detalle_formulario->iIdTipoCampo = $row_detalleformulario->iIdTipoCampo;
			$detalle_formulario->cObligatorio = $row_detalleformulario->cObligatorio;
			$detalle_formulario->cNumerico = $row_detalleformulario->cNumerico;
			$detalle_formulario->locales_formulario_fase = $row_detalleformulario->locales_formulario_fase;
			$detalle_formulario->locales_formulario_fase_id = $row_detalleformulario->locales_formulario_fase_id;
			$columna[$column_number][] = $detalle_formulario;

			$campo = 'fase_' . $row_detalleformulario->locales_formulario_fase . '_fase_id_' . $row_detalleformulario->locales_formulario_fase_id . '_' . strtolower($row_detalleformulario->campo);
			if ($row_detalleformulario->iIdTipoCampo == 6):
				$campos .= ',' . 'DATE_FORMAT(' . $campo . ", '%d/%m/%Y')" . $campo;
			else:
				$campos .= ',' . $campo;
			endif;
		endforeach;

		$campos = substr($campos, 1, 50000);

		$this->argumento['local'] = $this->registro->get_local_by_id($campos, $id);

		$this->argumento['columna1'] = $columna[1];
		$this->argumento['columna2'] = $columna[2];
		*/

		$this->argumento['iIdLocal']  = $id;
		$this->argumento['xfase']     = isset($_GET['fase']) ? $_GET['fase'] : false;
		$this->argumento['xfase_id']     = isset($_GET['fase_id']) ? $_GET['fase_id'] : false;


		$this->load->view('template/header',$this->argumento);
		$this->argumento['tabs'] = $this->registro->get_permiso_tab($this->iIdUsuario, 1);
		$this->argumento['opciones'] = $this->registro->get_permisos_opciones($this->iIdUsuario, 1);
		$this->pagina = 'locales/editar_local';

		$this->argumento['menu_items'] = $this->formulario_fase_dos->getAllTipoUnoActivo(1);
		$this->load->view($this->pagina, $this->argumento);
		$this->load->view('template/footer');
	}
	
	public function busqueda()
	{
		$this->argumento["title"] = "Busqueda local";
		$this->js("busqueda");
		$this->load->view('template/header_busqueda',$this->argumento);
		$this->argumento["tabs"] = $this->registro->get_permiso_tab($this->iIdUsuario,1);
		$this->argumento["categoria"]= $this->registro->get_categoria();
		$this->argumento["departamento"] = $this->registro->get_departamento();
		$this->argumento["opciones"] = $this->registro->get_permisos_opciones($this->iIdUsuario,16);
		$this->argumento["opciones_comparar"] = $this->registro->get_permisos_opciones($this->iIdUsuario,17);
		$this->pagina="locales/busqueda_local";
		$this->load->view($this->pagina, $this->argumento);
		$this->load->view('template/footer');
	}

	function active(){
		echo 'active';
	}

	function imagenes($id){
	
		$this->argumento["title"] = "Registrar imagenes";
		$this->js("imagenes");
		$this->argumento["iIdLocal"] = $id;
		$this->argumento["tab_name"] = 'imágenes';
		$this->argumento["local"] = $this->registro->get_local_by_id('fase_3_fase_id_2_nombre_del_sitio',$id);
		$this->load->view('template/header',$this->argumento);
		$this->argumento["tabs"] = $this->registro->get_permiso_tab($this->iIdUsuario,1);
		$this->argumento["opciones"] = $this->registro->get_permisos_opciones($this->iIdUsuario,13);
		$this->pagina="locales/imagenes";
		$this->argumento["detalleimagen"]= $this->registro->get_by_detalle_imagen($id);
		$this->load->view($this->pagina,$this->argumento);
		$this->load->view('template/footer');
		
	}

	public function documentos($id)
	{
		$this->argumento["title"] = "Registrar documentos";
		$this->js("documento");
		$this->argumento["iIdLocal"] = $id;
		$this->argumento["tab_name"] = 'documentos';
		$this->argumento["local"] = $this->registro->get_local_by_id('fase_3_fase_id_2_nombre_del_sitio, fase_3_fase_id_2_codigo_de_local', $id);
		$this->load->view('template/header',$this->argumento);
		$this->argumento["tabs"] = $this->registro->get_permiso_tab($this->iIdUsuario,1);
		$this->argumento["opciones"] = $this->registro->get_permisos_opciones($this->iIdUsuario,14);
		$this->pagina="locales/documentos";
		$this->argumento["categoria"]= $this->registro->get_categoria();
		$this->argumento['menu_items'] = $this->formulario_fase_dos->getAllTipoUnoActivo(2);
		$this->load->view($this->pagina,$this->argumento);
		$this->load->view('template/footer');
	}

	public function ubicacion($id)
	{
		$this->argumento["title"] = "Busqueda ubicacion";
		$this->js("ubicacion");
		$this->argumento["iIdLocal"] = $id;
		$this->argumento["tab_name"] = 'ubicación';
		$this->argumento["local"] = $this->registro->get_local_by_id('fase_3_fase_id_2_nombre_del_sitio' ,$id);
		$this->argumento["ubicacion"]= $this->registro->get_ubicacion_by_id($id);
		$this->load->view('template/header_normal',$this->argumento);
		$this->argumento["tabs"] = $this->registro->get_permiso_tab($this->iIdUsuario, 1);
		$this->pagina="locales/ubicacion";
		$this->load->view($this->pagina,$this->argumento);
		$this->load->view('template/footer');
		
	}

	public function upload_galeria()
	{
		$file = $_FILES['file'];
		move_uploaded_file($_FILES["file"]["tmp_name"], 'public/images/galeria/' . $_FILES["file"]["name"]);
		echo "success";
	}

	public function upload_documento()
	{
		$fase = $this->input->post('fase');
		$fase_id = $this->input->post('fase_id');
		$file = $_FILES['file'];
		$vDocumento = $fase . '_' . $fase_id . '_' . $file["name"];
		move_uploaded_file($_FILES["file"]["tmp_name"], 'public/images/documento/' . basename($vDocumento));
		echo "success";
	}

	function agregar_detalleimagen(){
		
		parse_str($this->input->post('formdata'),$_FORM);		
		
		$this->registro->save_detalleimagen($_FORM['iIdLocal'],$this->input->post('detalle'));
		
		$data_log = array(
						   'iIdEvento' 		=> 4,
						   'iIdUsuario'		=> $this->session->userdata('iIdUsuario'),
						   'dFecha_Log'		=> date('Y-m-d H:i:s'),
						   'vIp' 			=> getRealIP(),
						   'dRegistro' 		=> date('Y-m-d H:i:s'),
						   'iIdFormulario' 	=> 1,
							);
							
		$this->administracion->save_log($data_log);
		
		echo "success";
	
	}

	public function agregar_documento()
	{
		parse_str($this->input->post('formdata'), $_FORM);
	
		$this->registro->save_detalledocumento(
			$_FORM['iIdLocal'],
			$_FORM['iIdCategoria'],
			$this->input->post('detalle')
		);
		
		$data_log = [
			'iIdEvento' => 4,
			'iIdUsuario'=> $this->session->userdata('iIdUsuario'),
			'dFecha_Log' => date('Y-m-d H:i:s'),
			'vIp' => getRealIP(),
			'dRegistro' => date('Y-m-d H:i:s'),
			'iIdFormulario' => 1,
		];

		$this->administracion->save_log($data_log);
		echo "success";
	}
	
	// Ajax carga de pais
	public function datos_locales(){
		$num_set = count($_REQUEST);
		$calc = $num_set/2;
		for($i=1; $i<=$calc; $i++)
		{
			echo $this->input->post('t'.$i)." = ".$this->input->post('v'.$i). "<br>";
		}
	}
	
	public function codprov($dpto){
		$prov = $this->rlocales_model->ubigeo_codprov($dpto);
		echo "<option> -- <option>";	
		foreach($prov as $row){
			if($row['codprov'] == 0){
				
			}else{
				echo "<option value='".$row['codprov']."'>".$row['nombre'] ."</option>";	
			}
		}
	}
	
	public function coddist($dpto, $prov){
		$dist = $this->rlocales_model->ubigeo_coddist($dpto, $prov);
		echo "<option> -- <option>";	
		foreach($dist as $row){
			if($row['coddist']==1){
				
			}else{
				echo "<option value='".$row['coddist']."'>".$row['nombre'] ."</option>";	
			}
		}
	}
	
	function validateDate($test_date){
        
        $test_arr  = explode('/', $test_date);
        if (count($test_arr) == 3) {
            if (checkdate($test_arr[1], $test_arr[0], $test_arr[2])) {
                return $test_arr[2] . '/' . $test_arr[1]. '/' . $test_arr[0];
            } else {
               return $test_date;
            }
        } else {
           return $test_date;
        }
    }
	
	function agregar_local()
	{
		
		//$fecha = $this->registro->get_detalleformulario_fecha_by_idformulario(1);
		$fecha = $this->registro->get_detalleformulario_fecha_by_idformulario_idusuario($this->iIdUsuario,1);
		
		//var_dump($fecha);exit;
		
		/*foreach($fecha as $row_fecha):
			$campo = $row_fecha->campo;
			//$campo = strtolower($row_fecha->campo);
			$_POST[$campo]=(!empty($_POST[$campo]))?FormatoFecha($_POST[$campo],"Y-m-d"):"";
		endforeach;*/
		$data = [];
		foreach($_POST as $key => $rowPost) {
			if (is_array($_POST[$key])) {
				$data[$key] = implode(', ', $_POST[$key]);
				continue;
			}
			$data[$key] = $this->validateDate($_POST[$key]);
		}
		
		$data 		= $data;
		
		if (!empty($data['iIdLocal'])){
			$iIdLocal = $data['iIdLocal'];
			$this->registro->update_local($iIdLocal, $data);
			$evento = 5;
		}else{
			$iIdLocal = $this->registro->save_local($data);
			$evento = 4;
		}
		
		$data_log = array(
			'iIdEvento' 		=> $evento,
			'iIdUsuario'		=> $this->session->userdata('iIdUsuario'),
			'dFecha_Log'		=> date('Y-m-d H:i:s'),
			'vIp' 			=> getRealIP(),
			'dRegistro' 		=> date('Y-m-d H:i:s'),
			'iIdFormulario' 	=> 1,
		);
							
		$this->administracion->save_log($data_log);
		echo $iIdLocal;
	}

	public function buscar_local_all()
	{
		$array =array();
		$columnas = [];
		$campos = 'iIdLocal';
		
		$this->argumento["detalleformulario"] = $this->registro->get_detalleformulario_by_idformulario_idusuario($this->iIdUsuario, 1); 
		
		foreach($this->argumento["detalleformulario"] as $key => $row_detalleformulario):
			$row_detalleformulario->campo = 'fase_' . $row_detalleformulario->locales_formulario_fase . '_fase_id_' . $row_detalleformulario->locales_formulario_fase_id . '_' . $row_detalleformulario->campo;
			if($row_detalleformulario->iIdTipoCampo == 6):
				$campos .= ","."DATE_FORMAT(" . strtolower($row_detalleformulario->campo).",'%d/%m/%Y')".strtolower($row_detalleformulario->campo);
			else:
				$campos .= "," . strtolower($row_detalleformulario->campo);
			endif;
			$columnas[strtolower($row_detalleformulario->campo)] = $row_detalleformulario;
			
			$campos = str_replace(
			array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
			array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
			$campos
			);

			//Reemplazamos la E y e
			$campos = str_replace(
			array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
			array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
			$campos );

			//Reemplazamos la I y i
			$campos = str_replace(
			array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
			array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
			$campos);

			//Reemplazamos la O y o
			$campos = str_replace(
			array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
			array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
			$campos );

			//Reemplazamos la U y u
			$campos = str_replace(
			array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
			array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
			$campos);

			//Reemplazamos la N, n, C y c
			$campos = str_replace(
			array('Ñ', 'ñ', 'Ç', 'ç'),
			array('N', 'n', 'C', 'c'),
			$campos
			);
		endforeach;
        $this->argumento["detalleformulario"] = $columnas;
        $_POST['campos'] = $campos;
		$_POST['campo']  = 'iIdLocal';
		$_POST['asc'] 	 = isset($_POST['asc']) ? $_POST['asc'] : 'ASC';

		$array = $_POST;

		if (isset($_POST["nav"]) && $_POST["nav"] == 1) {
			
			$this->argumento["resultado"] = $this->cache->get($this->cache_vipo_buscar);
			
		} else {
			
			$this->argumento["resultado"] = ObtenerCacheFile($this->cache_vipo_buscar, $this->registro->buscar_local_all($array), $this->tiempo_cache);
			
		}

		$page = (isset($_POST['page']) && !empty($_POST['page'])) ? $_POST['page'] : 1;
		if ($page == 0)$page = 1;
		
		$datos = $array;
		unset($datos["iIdCategoria"]);
		unset($datos["campo"]);
		unset($datos["asc"]);
		unset($datos["vNombreArchivo"]);
		unset($datos["page"]);
		unset($datos["nav"]);
		unset($datos["campos"]);
		unset($datos["iIdLocal"]);

		$this->argumento["datos"] = $datos;

		$this->argumento["opciones_registro_local"] = $this->registro->get_permisos_opciones($this->iIdUsuario,1);
		$this->argumento["opciones_documento"] = $this->registro->get_permisos_opciones($this->iIdUsuario,14);
		$this->argumento["total"] = count($this->argumento["resultado"]);
		$this->argumento["limit"] = $this->limite_pagina;
		$this->argumento["page"] = $page;
		
		$this->load->view("locales/busqueda_local_ajax", $this->argumento);
		
	}	

	public function buscar_documento_all()
	{
		if ($_POST['nav'] == 1) {
			$this->argumento['resultado'] = $this->cache->get($this->cache_vipo_buscar);
		} else {
			$array = [];
			$array = $_POST;
			$this->argumento['resultado'] = ObtenerCacheFile($this->cache_vipo_buscar, $this->registro->buscar_documento_all($array), $this->tiempo_cache);
		}
		
		print_r($this->argumento['resultado']);

		$page = (isset($_POST['page']) && !empty($_POST['page'])) ? $_POST['page']: 1;
		if ($page == 0)$page = 1;

		$this->argumento['opciones'] = $this->registro->get_permisos_opciones($this->iIdUsuario, 14);
		$this->argumento['total'] = count($this->argumento['resultado']);
		$this->argumento['limit'] = $this->limite_pagina;
		$this->argumento['page'] = $page;

		$this->load->view('locales/documentos_ajax', $this->argumento);
	}

	public function recuperar_iIdDocumento()
	{
		$iIdDocumento = $this->registro->get_by_iIdDocumento($this->input->post('iIdCategoria'));
		echo $iIdDocumento;
	}
	
	function comparar_local(){
			
		//print_r($this->input->post('detalle_local'));
		
		$this->argumento["detalle_local"] = $this->input->post('detalle_local');
		//$this->argumento["campos"] = $this->registro->get_detalleformulario_by_idformulario(1);
		$this->argumento["campos"] = $this->registro->get_detalleformulario_by_idformulario_idusuario($this->iIdUsuario,1);
		$this->argumento["opciones_comparar"] = $this->registro->get_permisos_opciones($this->iIdUsuario,17);

		//$this->argumento["limit"] = $this->limite_pagina;
		
		$this->load->view("locales/busqueda_comparar_local_ajax", $this->argumento);
		
	}	
	
	function recuperar_provincia_departamento(){
		
		$provincia = $this->registro->get_provincia_departamento($this->input->post('id'));
		
		if($provincia) 
		{
			exit(json_encode($provincia));
		}
		else
		{
			exit(json_encode(NULL));	
		}	
		
	}

	function recuperar_distrito_provincia(){
	
		$distrito = $this->registro->get_distrito_provincia($this->input->post('id'), $this->input->post('idDpto'));
		
		if($distrito) 
		{
			exit(json_encode($distrito));
		}
		else
		{
			exit(json_encode(NULL));	
		}	
		
	}
	
	function recuperar_local_serie(){
		
		$data = array(
		   'departamento' 	=> $this->input->post('departamento'),
		   'provincia'		=> $this->input->post('provincia'),
		   'distrito' 		=> $this->input->post('distrito')
		);
		
		$serie = $this->registro->get_local_serie($data);
		
		echo $serie;
		
	}
	
	function eliminar_documento() {
		$id = $this->input->post("id");	  
		$informacion = array(
						    'table' => 'locales_detalledocumento',
						    'condicion' => 'iIdDetalleDocumento',
						    'valor' => $this->input->post("id")
						   );
					 
		$data = array('eEstado'=>3);
					 
        $respuesta = $this->registro->update_registro($informacion,$data);
		$delete = $this->registro->eliminar_documento($id);
		$data_log = array(
						   'iIdEvento' 		=> 6,
						   'iIdUsuario'		=> $this->session->userdata('iIdUsuario'),
						   'dFecha_Log'		=> date('Y-m-d H:i:s'),
						   'vIp' 			=> getRealIP(),
						   'dRegistro' 		=> date('Y-m-d H:i:s'),
						   'iIdFormulario' 	=> 1,
							);
							
		$this->administracion->save_log($data_log);
		
        if ($respuesta) {
            echo 1;
        } 
    }

    public function update_detalledocumento()
	{
		$fase = $this->input->post('fase');
		$fase_id = $this->input->post('fase_id');
		$file = $_FILES['file'];
		$vDocumento = $fase . '_' . $fase_id . '_' . $file["name"];
		move_uploaded_file($_FILES["file"]["tmp_name"], 'public/images/documento/' . basename($vDocumento));

		$data = array(
			'vDocumento' => $vDocumento,
			'locales_formulario_fase' => $fase,
			'locales_formulario_fase_id' => $fase_id,
			'iIdUserMod' => $this->session->userdata('iIdUsuario'),
			'dModificacion' => date('Y-m-d H:i:s'),
		);

		$this->registro->update_detalledocumento($this->input->post("iIdDetalleDocumento"), $data);
		
		$data_log = array(
			'iIdEvento' 		=> 5,
			'iIdUsuario'		=> $this->session->userdata('iIdUsuario'),
			'dFecha_Log'		=> date('Y-m-d H:i:s'),
			'vIp' 			=> getRealIP(),
			'dRegistro' 		=> date('Y-m-d H:i:s'),
			'iIdFormulario' 	=> 1,
		);

		$this->administracion->save_log($data_log);
		echo "success";
	}


	public function add_or_update_alert()
	{
		$days_ant = $this->input->post('days_ant');
		$date_expire = $this->input->post('date_exp');
		$id_formulario = $this->input->post('vid_formulario');
		$id_local = $this->input->post('iIdLocal');
		$id_alert = $this->input->post('id_alert');
		$alert = $this->registro->getAlertFieldsByIdFormulario($id_local, $id_formulario);

		$rowAlert = array(
			'alert_id_local'		=> $id_local,
			'alert_id_formulario'	=> $id_formulario,
			'alert_days'			=> $days_ant,
			'alert_date' 			=> $date_expire
		);
		if($id_alert):
			$rowAlert['alert_id'] = $id_alert;
			$alerta = $this->registro->editAlarm($rowAlert);
		else:
			$alerta = $this->registro->createAlarm($rowAlert);
		endif;

		exit(json_encode($alerta));
	}

	public function create_detalledocumento()
	{
		//$iIdDetalleDocumento = $this->input->post('iIdDetalleDocumento');
		$iIdLocal = $this->input->post('iIdLocal');
		$iIdDetalleFormulario = $this->input->post('iIdDetalleFormulario');
		$fase = $this->input->post('fase');
		$fase_id = $this->input->post('fase_id');
		$file = $_FILES['file'];
		$vDocumento = $fase . '_' . $fase_id . '_' . $iIdDetalleFormulario . '-' . $file["name"];
		move_uploaded_file($_FILES["file"]["tmp_name"], 'public/images/documento/' . basename($vDocumento));

		$data = array(
			//'iIdDetalleDocumento' => $iIdDetalleDocumento,
			'vDocumento' => $vDocumento,
			'iIdLocal' => $iIdLocal,
			'iIdDetalleFormulario' => $iIdDetalleFormulario,
			'iIdUserReg' => $this->session->userdata('iIdUsuario'),
			'locales_formulario_fase' => $fase,
			'locales_formulario_fase_id' => $fase_id,
		);

		$documento_id = $this->registro->create_detalledocumento($data);
		
		$data_log = array(
			'iIdEvento' 		=> 4,
			'iIdUsuario'		=> $this->session->userdata('iIdUsuario'),
			'dFecha_Log'		=> date('Y-m-d H:i:s'),
			'vIp' 			=> getRealIP(),
			'dRegistro' 		=> date('Y-m-d H:i:s'),
			'iIdFormulario' 	=> 1,
		);

		$this->administracion->save_log($data_log);

		$response = $this->registro->buscar_documento_first([
			$iIdDetalleFormulario,
			$fase,
			$fase_id,
			$iIdLocal,
		]);
		$response->dModificacion = date('d/m/Y h:m:s a', strtotime($response->dModificacion));
		echo json_encode($response, true);
	}

	function categoria(){
	
		$this->pagina="locales/view_frm_categoria";
		$this->load->view($this->pagina, $this->argumento);
		
	}
	
	function agregar_categoria(){
		
		$data 		= $_POST;
		
		if (!empty($_POST['iIdCategoria'])){
			$iIdCategoria = $_POST['iIdCategoria'];
			$this->registro->update_categoria($iIdCategoria,$data);
		}else{
			$iIdCategoria = $this->registro->save_categoria($data);
		}
		
		echo "success";
	
	}
	
	function recuperar_categoria(){
		
		$categoria = $this->registro->get_categoria();
		
		if($categoria) 
		{
			exit(json_encode($categoria));
		}
		else
		{
			exit(json_encode(NULL));	
		}	
		
	}
	
	function descargar($archivo){
	   
	    $extension=extension($archivo);
		$name=explode(".",$archivo);
		
		$name_fichero=$name[0].".xls";
		$tabla_excel = '';
		
		if(strcmp($extension,"xls")==0):
			header("Content-type: application/vnd.ms-excel; name='excel'");
			header("Content-Disposition: filename=".$name_fichero);
			header("Pragma: no-cache");
			header("Expires: 0");
			$tabla_excel.=file_get_contents("excel/locales/".$archivo);
			echo utf8_decode($tabla_excel);
		else:
			header("Content-Type: application/octet-stream");
			header("Content-Disposition: attachment; filename=" .($archivo));
			header("Content-Type: application/octet-stream"); 
			header("Content-Type: application/download"); 
			header("Content-Description: File Transfer"); 
			//header("Content-Length: " . filesize($archivo)); 
			header("Content-Length: ".filesize('archivo/pdf/locales/'.$archivo));
			readfile('archivo/pdf/locales/'.$archivo);
			flush();
			endif;
	}
	
	function pdf_local_busqueda(){
			
		$this->load->helper(array('fpdf', 'file'));
		
		$clspdf = new PDF('L', 'mm', 'A4');
		$clspdf->SetAutoPageBreak(true,5);  
		$clspdf->AddPage();
		
		$clspdf->setX(5);
		$x=$clspdf->GetX();
		$y = 5;
		$clspdf->SetY($y);
		$y=$clspdf->GetY();$y+=5;
		$clspdf->SetXY($x,$y);
		
		$clspdf->SetFont('Arial','B',8);
		$clspdf->Cell(40,4,"BUSQUEDA DE LOCALES",0,0,'');
		$y+=6;
		
		$array =array();
		$campos = 'iIdLocal';
		
		$detalleformulario = $this->registro->get_detalleformulario_by_idformulario(1);
		
		foreach($detalleformulario as $key => $row_detalleformulario):					
			
			if($row_detalleformulario->iIdTipoCampo == 6):
				$campos .= ","."DATE_FORMAT(".strtolower($row_detalleformulario->campo).",'%d/%m/%Y')".strtolower($row_detalleformulario->campo);
			else:
				$campos .= ",".strtolower($row_detalleformulario->campo);
			endif;
			
		endforeach;
		
		$_POST['campos'] = $campos;
		$array = $_POST;
		$local = $this->registro->buscar_local_all($array);
		
		/****************/
		$clspdf->SetXY($x,$y+=16);
		
		foreach($local as $key=>$row_local):
			if($key == 0):
				$clspdf->SetFont('Arial','B',6);
				foreach($detalleformulario as $row_detalleformulario):
					$campo = strtolower($row_detalleformulario->campo);
					$clspdf->setX($x);
					$x=$clspdf->GetX();
					$clspdf->MultiCell(20,3,utf8_decode($row_detalleformulario->vNombre),1,'C');$clspdf->SetXY($x,$y);
					$x += 20;
				endforeach;
				
				$clspdf->SetXY($x,$y+=6);
				
			endif;
			
			$clspdf->setX(5);
			$x=$clspdf->GetX();
			$clspdf->SetXY($x,$y+=6);
			
			foreach($detalleformulario as $row_detalleformulario):
				$campo = strtolower($row_detalleformulario->campo);
				$vNombre = $row_local->$campo;
				if($row_detalleformulario->iIdTipoCampo == 3):
					$vNombre = $this->registro->get_vNombre_tabla_by_id($campo,$row_local->$campo);
				endif;
				$clspdf->setX($x);
				$x=$clspdf->GetX();
				$clspdf->MultiCell(20,3,utf8_decode($vNombre),0,'C');$clspdf->SetXY($x,$y);
				$x += 20;
			endforeach;
			
		endforeach;
		
		
		$clspdf->Output('archivo/pdf/locales/local.pdf');
		
		echo "{'tipo':'pdf','archivo':'local.pdf'}";	
			
	}
	
	function pdf_local_principal(){
			
		$this->load->helper(array('fpdf', 'file'));
		
		$clspdf = new PDF('P', 'mm', 'A4');
		$clspdf->SetAutoPageBreak(true,5);  
		$clspdf->AddPage();
		
		$detalleformulario = $this->registro->get_detalleformulario_by_idformulario(1);
		$mitad_formulario = ceil(count($detalleformulario) / 2);
		
		$campos = "";
		foreach($detalleformulario as $key => $row_detalleformulario):
		
			if(($key + 1) <= $mitad_formulario):
				$columna1[$key]->vNombre		= $row_detalleformulario->vNombre;
				$columna1[$key]->campo 			= strtolower($row_detalleformulario->campo);
				$columna1[$key]->iIdTipoCampo 	= $row_detalleformulario->iIdTipoCampo;
				$columna1[$key]->cObligatorio	= $row_detalleformulario->cObligatorio;
				$columna1[$key]->alert_expiration	= $row_detalleformulario->alert_expiration;
				$columna1[$key]->cNumerico		= $row_detalleformulario->cNumerico;
			elseif(($key + 1) > $mitad_formulario):
				$columna2[$key]->vNombre		= $row_detalleformulario->vNombre;
				$columna2[$key]->campo 			= strtolower($row_detalleformulario->campo);
				$columna2[$key]->iIdTipoCampo 	= $row_detalleformulario->iIdTipoCampo;
				$columna2[$key]->cObligatorio	= $row_detalleformulario->cObligatorio;
				$columna2[$key]->alert_expiration	= $row_detalleformulario->alert_expiration;
				$columna2[$key]->cNumerico		= $row_detalleformulario->cNumerico;
			endif;
			
			if($row_detalleformulario->iIdTipoCampo == 6):
				$campos .= ","."DATE_FORMAT(".strtolower($row_detalleformulario->campo).",'%d/%m/%Y')".strtolower($row_detalleformulario->campo);
			else:
				$campos .= ",".strtolower($row_detalleformulario->campo);
			endif;
			
		endforeach;
		
		$campos = substr($campos,1,50000);
		
		$local = $this->registro->get_local_by_id($campos,$this->input->post('iIdLocal'));
		
		/********************/
		
		$clspdf->setX(5);
		$x=$clspdf->GetX();
		$y = 5;
		$clspdf->SetY($y);
		$y=$clspdf->GetY();$y+=5;
		$clspdf->SetXY($x,$y);
		
		
		$clspdf->SetFont('Arial','B',8);
		$clspdf->Cell(40,4,"REGISTRO DE SITIOS",0,0,'');
		$y2=$y;
		$y+=6;
		
		foreach($columna1 as $key=>$row):
			$campo = $row->campo;
			
			if($row->iIdTipoCampo == 2):
				$clspdf->SetFont('Arial','B',8);$clspdf->SetXY($x,$y+=4);$clspdf->Cell(50,4,utf8_decode($row->vNombre.':'),0,0,'');
				$clspdf->SetFont('Arial','',8);$clspdf->MultiCell(55,4,utf8_decode($local->$campo),0,'');
				//if($row->cObligatorio == 1):$clspdf->SetFont('Arial','',5);$clspdf->Cell(5,4,"(*)",0,0,'');endif;
				$y+=8;
			endif;
			if($row->iIdTipoCampo == 1|| $row->iIdTipoCampo == 6):
				$clspdf->SetFont('Arial','B',8);$clspdf->SetXY($x,$y+=4);$clspdf->Cell(50,4,utf8_decode($row->vNombre.':'),0,0,'');
				$clspdf->SetFont('Arial','',8);$clspdf->Cell(30,4,utf8_decode($local->$campo),0,0,'');
				//if($row->cObligatorio == 1):$clspdf->SetFont('Arial','',5);$clspdf->Cell(5,4,"(*)",0,0,'');endif;
			endif;
			if($row->iIdTipoCampo == 3):
				if($local->$campo > 0)$vNombre = $this->registro->get_vNombre_tabla_by_id($campo,$local->$campo);
				$clspdf->SetFont('Arial','B',8);$clspdf->SetXY($x,$y+=4);$clspdf->Cell(50,4,utf8_decode($row->vNombre.':'),0,0,'');
				$clspdf->SetFont('Arial','',8);$clspdf->Cell(30,4,utf8_decode($vNombre),0,0,'');
				//if($row->cObligatorio == 1):$clspdf->SetFont('Arial','',5);$clspdf->Cell(5,4,"(*)",0,0,'');endif;
	   		endif;
			
		endforeach;
		
		$y2+=6;
		foreach($columna2 as $key=>$row):
			$campo = $row->campo;
			
			if($row->iIdTipoCampo == 2):
				$clspdf->SetFont('Arial','B',8);$clspdf->SetXY($x,$y+=4);$clspdf->Cell(50,4,utf8_decode($row->vNombre.':'),0,0,'');
				$clspdf->SetFont('Arial','',8);$clspdf->MultiCell(55,4,utf8_decode($local->$campo),0,'');
				//if($row->cObligatorio == 1):$clspdf->SetFont('Arial','',5);$clspdf->Cell(5,4,"(*)",0,0,'');endif;
				$y+=8;
			endif;
			if($row->iIdTipoCampo == 1 || $row->iIdTipoCampo == 6):
				$clspdf->SetFont('Arial','B',8);$clspdf->SetXY(110,$y2+=4);$clspdf->Cell(50,4,utf8_decode($row->vNombre.':'),0,0,'');
				$clspdf->SetFont('Arial','',8);$clspdf->MultiCell(30,4,utf8_decode($local->$campo),0,'');
				//if($row->cObligatorio == 1):$clspdf->SetFont('Arial','',5);$clspdf->Cell(5,4,"(*)",0,0,'');endif;
			endif;
			if($row->iIdTipoCampo == 3):
				$vNombre = $this->registro->get_vNombre_tabla_by_id($campo,$local->$campo);
				$clspdf->SetFont('Arial','B',8);$clspdf->SetXY(110,$y2+=4);$clspdf->Cell(50,4,utf8_decode($row->vNombre.':'),0,0,'');
				$clspdf->SetFont('Arial','',8);$clspdf->Cell(30,4,utf8_decode($vNombre),0,0,'');
				//if($row->cObligatorio == 1):$clspdf->SetFont('Arial','',5);$clspdf->Cell(5,4,"(*)",0,0,'');endif;
	   		endif;
			
		endforeach;
		
		$clspdf->Output('archivo/pdf/locales/local.pdf');
		
		echo "{'tipo':'pdf','archivo':'local.pdf'}";	
		
	}
	
	function pdf_local_imagen(){
		
		$this->load->helper(array('fpdf', 'file'));
		
		$clspdf = new PDF('P', 'mm', 'A4');
		$clspdf->SetAutoPageBreak(true,5);  
		$clspdf->AddPage();
		
		$local = $this->registro->get_local_by_id('fase_3_fase_id_2_nombre_del_sitio',$this->input->post('iIdLocal'));
		$detalleimagen = $this->registro->get_by_detalle_imagen($this->input->post('iIdLocal'));
		//$clspdf->SetFont('Arial','',8);$clspdf->Cell(30,4,utf8_decode($vNombre),0,0,'');
		
		$clspdf->setX(5);
		$x=$clspdf->GetX();
		$y = 5;
		$clspdf->SetY($y);
		$y=$clspdf->GetY();$y+=5;
		$clspdf->SetXY($x,$y);
		
		$clspdf->SetFont('Arial','B',8);
		$clspdf->Cell(40,4,"IMAGENES DEL LOCAL ".$local->fase_3_fase_id_2_nombre_del_sitio,0,0,'');
		$y2=$y;
		$y+=12;
		
		foreach($detalleimagen as $key=>$row):
			$clspdf->Image(base_url() . "public/images/galeria/".$row->vimagen,$x,$y,70);
			$clspdf->SetFont('Arial','B',8);$clspdf->SetXY(100,$y);$clspdf->Cell(40,4,utf8_decode('Comentario :'),0,0,'');
			//$clspdf->SetFont('Arial','',8);$clspdf->Cell(30,4,utf8_decode($row->vDescripcion),0,0,'');
			$clspdf->SetXY(140,$y);
			$clspdf->SetFont('Arial','',8);$clspdf->MultiCell(80,2,utf8_decode($row->vDescripcion),0,'');
			$y+=60;
		endforeach;
		
		
		$clspdf->Output('archivo/pdf/locales/local_imagen.pdf');
		echo "{'tipo':'pdf','archivo':'local_imagen.pdf'}";	
	
	}
	
	function pdf_local_documento(){
		
		$this->load->helper(array('fpdf', 'file'));
		
		$clspdf = new PDF('P', 'mm', 'A4');
		$clspdf->SetAutoPageBreak(true,5);  
		$clspdf->AddPage();
		
		$local = $this->registro->get_local_by_id('fase_3_fase_id_2_nombre_del_sitio',$this->input->post('iIdLocal'));
		$array =array();
		$array = $_POST;
		$documentos = $this->registro->buscar_documento_all($array);
			
		$clspdf->setX(5);
		$x=$clspdf->GetX();
		$y = 5;
		$clspdf->SetY($y);
		$y=$clspdf->GetY();$y+=5;
		$clspdf->SetXY($x,$y);
		
		$clspdf->SetFont('Arial','B',8);
		$clspdf->Cell(40,4,"DOCUMENTOS DEL LOCAL ".$local->fase_3_fase_id_2_nombre_del_sitio,0,0,'');
		$y2=$y;
		$y+=12;
		
		foreach($documentos as $key_documentos=>$row_documentos):
			$clspdf->SetFont('Arial','B',8);$clspdf->SetXY($x+10,$y+=4);$clspdf->Cell(50,4,utf8_decode($row_documentos->categoria),0,0,'');
			$y+=4;
			$vDocumento = explode(',',$row_documentos->vDocumento);
			foreach($vDocumento as $key_vDocumento=>$row_vDocumento):
				$clspdf->Image(base_url() . "public/images/Word.jpg",$x+25,$y,5);
				$clspdf->SetFont('Arial','',8);$clspdf->SetXY($x+30,$y);$clspdf->Cell(80,4,utf8_decode($row_vDocumento),0,0,'');
				$y+=8;
			endforeach;
			
		endforeach;
		
		
		$clspdf->Output('archivo/pdf/locales/local_documento.pdf');
		echo "{'tipo':'pdf','archivo':'local_documento.pdf'}";	
	
	}
	
	function pdf_local_comparar(){
		
		$this->load->helper(array('fpdf', 'file'));
		
		$clspdf = new PDF('P', 'mm', 'A4');
		$clspdf->SetAutoPageBreak(true,5);  
		$clspdf->AddPage();
		
		$detalle_local = $this->input->post('detalle_local');
		$campos = $this->registro->get_detalleformulario_by_idformulario(1);	
			
		$clspdf->setX(5);
		$x=$clspdf->GetX();
		$y = 5;
		$clspdf->SetY($y);
		$y=$clspdf->GetY();$y+=5;
		$clspdf->SetXY($x,$y);
		
		$clspdf->SetFont('Arial','B',8);
		$clspdf->Cell(40,4,"COMPARACION DEL LOCALES",0,0,'');
		$y2=$y;
		$y+=8;
		$x+=70;
		foreach($detalle_local as $row_local):
			$clspdf->Image(/*base_url() . */"public/images/icono_local.jpg",$x,$y,5);
			$clspdf->SetFont('Arial','',8);$clspdf->SetXY($x+=5,$y);$clspdf->Cell(60,4,utf8_decode($row_local['local']),0,0,'');
			$x+=55;
		endforeach;
		
		$y+=6;
		$clspdf->setX(5);
		$x=$clspdf->GetX();
		$clspdf->SetXY($x,$y);
		
		foreach($campos as $row_campos):
			
			$clspdf->SetFont('Arial','B',8);$clspdf->SetXY($x,$y);$clspdf->MultiCell(70,3,utf8_decode($row_campos->vNombre),0,'');$clspdf->SetXY(75,$y);
			
			foreach($detalle_local as $row_local):
				$campo = strtolower($row_campos->campo);
				$vNombre = $this->registro->get_campo_by_id($row_campos->campo,$row_local['iIdLocal']);
				if($row_campos->iIdTipoCampo == 3):
					$vNombre = $this->registro->get_vNombre_tabla_by_id($campo,$row_campos->campo);
				endif;
				$clspdf->SetFont('Arial','',6);$clspdf->MultiCell(60,3,utf8_decode($vNombre),0,'');$clspdf->SetXY(135,$y);
			endforeach;
			
			//$y=$clspdf->GetY();
			//$y+=3;
			
			$clspdf->SetY($y);
			$y=$clspdf->GetY();$y+=5;
			
			if($row_campos->iIdTipoCampo == 2)$y+=6;
			
			$clspdf->SetXY($x,$y);
			//$clspdf->Ln();
			//$clspdf->SetXY($x,$y);
			
		endforeach;
		
		$clspdf->Output('archivo/pdf/locales/local_comparar.pdf');
		echo "{'tipo':'pdf','archivo':'local_comparar.pdf'}";	
	
	}

	public function excel_local_busqueda()
	{
	
		$array =array();
		$columnas =array();
		$campos = "iIdLocal";
		$detalleformulario = $this->registro->get_detalleformulario_by_idformulario_idusuario($this->iIdUsuario, 1, 3, 2);
		
		foreach($detalleformulario as $key => $row_detalleformulario):
			$row_detalleformulario->campo = 'fase_' . $row_detalleformulario->locales_formulario_fase . '_fase_id_' . $row_detalleformulario->locales_formulario_fase_id . '_' . $row_detalleformulario->campo;
			if($row_detalleformulario->iIdTipoCampo == 6):
				$campos .= ","."DATE_FORMAT(".strtolower($row_detalleformulario->campo).',"%d/%m/%Y")'.strtolower($row_detalleformulario->campo);
			else:
				$campos .= ",".strtolower($row_detalleformulario->campo);
			endif;
			$columnas[$row_detalleformulario->iIdDetalleFormulario] = $row_detalleformulario;
		endforeach;
		$detalleformulario = $columnas;
		$_POST['campos'] = $campos;
		$array = $_POST;
		$local = $this->registro->buscar_local_all($array);
		
		/****************/
		
		$html="";
		//$ruta=base_url()."imagen/u49_normal.png";
		$ruta = '';
		$html.='<center>&nbsp;</center>';
		$html.="<table>";
		foreach($local as $key=>$row_local):
			if($key == 0):
			$html.="<tr>";
			foreach($detalleformulario as $row_detalleformulario):
				$campo = strtolower($row_detalleformulario->campo);
				$html.="<td style='background-color:#007EA2;color:#FFF;border:1px solid #CCC'>".$row_detalleformulario->vNombre."</td>";
			endforeach;
			$html.="</tr>";
			endif;
			
			$html.="<tr>";
			foreach($detalleformulario as $row_detalleformulario):
				$campo = strtolower($row_detalleformulario->campo);
                $campo = str_replace(
    			array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
    			array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
    			$campo
    			);
    
    			//Reemplazamos la E y e
    			$campo = str_replace(
    			array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
    			array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
    			$campo );
    
    			//Reemplazamos la I y i
    			$campo = str_replace(
    			array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
    			array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
    			$campo);
    
    			//Reemplazamos la O y o
    			$campo = str_replace(
    			array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
    			array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
    			$campo );
    
    			//Reemplazamos la U y u
    			$campo = str_replace(
    			array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
    			array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
    			$campo);
    
    			//Reemplazamos la N, n, C y c
    			$campo = str_replace(
    			array('Ñ', 'ñ', 'Ç', 'ç'),
    			array('N', 'n', 'C', 'c'),
    			$campo
    			);
    			
				$vNombre = $row_local->$campo;
				if($row_detalleformulario->iIdTipoCampo == 3):
					if($row_local->$campo > 0)$vNombre = $this->registro->get_vNombre_tabla_by_id($campo,$row_local->$campo);
					else $vNombre = '';
				endif;
				$html.="<td style='border:1px solid #CCC'>".$vNombre."</td>";
			endforeach;	
			$html.="</tr>";				
		endforeach;
			
		$html.="</table>";
		
		$nuevoarchivo = fopen("excel/locales/local_busqueda.xls", "w+");
		fwrite($nuevoarchivo,$html);
		fclose($nuevoarchivo);
		echo "{'tipo':'excel','archivo':'local_busqueda.xls'}";
		
	}
	
	
	function excel_local_formato(){
	
		$array =array();
		$campos = 'iIdLocal';
		
		$detalleformulario = $this->registro->get_detalleformulario_by_idformulario(1);
		
		/****************/
		
		$html="";
		$html.="<table>";
		$html.="<tr>";
		foreach($detalleformulario as $row_detalleformulario):
			$campo = $row_detalleformulario->campo = 'fase_' . $row_detalleformulario->locales_formulario_fase . '_fase_id_' . $row_detalleformulario->locales_formulario_fase_id . '_' . strtolower($row_detalleformulario->campo);
			$html.="<td style='background-color:#FFFF00;color:#234C7B;border:1px solid #CCC'>".$row_detalleformulario->vNombre."</td>";
		endforeach;
		$html.="</tr>";
		$html.="</table>";
		
		$nuevoarchivo = fopen("excel/locales/local_formato.xls", "w+");
		fwrite($nuevoarchivo,$html);
		fclose($nuevoarchivo);
		echo "{'tipo':'excel','archivo':'local_formato.xls'}";
		
	}
	
	function upload_excel_local(){
		
		$file = $_FILES['file'];
		move_uploaded_file($_FILES["file"]["tmp_name"], 'excel/importacion/' . $_FILES["file"]["name"]);
		
		echo "success";
		
	}
	
	function importar_excel_local() {
		
        $vNombreArchivo = $_POST["vNombreArchivo"];

        $tipo = explode('.', $vNombreArchivo);
        $extencion = $tipo[1];
		
        $this->load->library("PHPExcel");

        if ($extencion == "xls") {
            $objReader = PHPExcel_IOFactory::createReader('Excel5');
        }
        if ($extencion == "xlsx") {
            $objReader = PHPExcel_IOFactory::createReader('Excel2007');
        }

        $objReader->setReadDataOnly(true);
        $objPHPExcel = $objReader->load("./excel/importacion/$vNombreArchivo");
        $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);

        $cantmax = $objWorksheet->getHighestRow();
		
		$detalleformulario = $this->registro->get_detalleformulario_by_idformulario(1);
		$this->registro->delete_local();
		
		unset($data);
        for ($i = 2; $i <= $cantmax; $i++) {
			
			foreach($detalleformulario as $key=>$row_detalleformulario):
				$campo = $row_detalleformulario->campo = 'fase_' . $row_detalleformulario->locales_formulario_fase . '_fase_id_' . $row_detalleformulario->locales_formulario_fase_id . '_' . strtolower($row_detalleformulario->campo);
				$vNombre = trim($objWorksheet->getCellByColumnAndRow($key, $i)->getValue());
				if($row_detalleformulario->iIdTipoCampo == 3):
					if($campo == 'fase_3_fase_id_2_distrito'):
						//$vNombre = $this->registro->get_id_tabla_by_nombre_distrito($campo,$vNombre,$provincia);
						
						$prov_nombre = trim($objWorksheet->getCellByColumnAndRow($key-1, $i)->getValue());
      					$prov_id = $this->registro->get_id_tabla_by_nombre('fase_3_fase_id_2_provincia',$prov_nombre );
	  					$vNombre = $this->registro->get_id_tabla_by_nombre($campo,$vNombre,$prov_id );
	  
					else:
						$vNombre = $this->registro->get_id_tabla_by_nombre($campo,$vNombre);
					endif;
					
					if($campo == 'fase_3_fase_id_2_provincia'):
						$provincia = $vNombre;
					endif;
					
				endif;
				if($row_detalleformulario->iIdTipoCampo == 6):
					$parte = explode("/",$vNombre);
					if(count($parte)==1 && strlen($vNombre) > 0){
						$dateObj = PHPExcel_Shared_Date::ExcelToPHPObject($vNombre);
						$vNombre = $dateObj->format('Y-m-d');
					}else{
						$vNombre = "";
					}
				endif;
				
				$data[$campo] = $vNombre;
			endforeach;
			
			//print_r($data);exit();
			
			//$codigo_de_local = trim($objWorksheet->getCellByColumnAndRow(0, $i)->getValue());
			//$iIdLocal = $this->registro->get_idlocal_by_codigo($codigo_de_local);
			/*
			if($iIdLocal):
				$this->registro->update_local($iIdLocal,$data);
			else:
				$this->registro->save_local($data);	
			endif;
			*/
			$this->registro->save_local($data);
            
        }
		
		echo "success";
		//echo "{'msg':'".$msg."','id':'".$iIdPackingList."'}";
		
    }

    public function formularios_campos()
	{
		$fase = $this->input->post('fase');
		$fase_id = $this->input->post('fase_id');
		$fase_tres_id = $this->input->post('fase_tres_id');
		$fase_cuatro_id = $this->input->post('fase_cuatro_id');
		$fase_cinco_id = $this->input->post('fase_cinco_id');

		if ($fase == 3) {
			$fase_tres_id = $fase_id;
		} elseif ($fase == 4) {
			$fase_cuatro_id = $fase_id;
		} elseif ($fase == 5) {
			$fase_cinco_id = $fase_id;
		}
		if ($fase == 4 || $fase == 5) {
			$data['fase_cinco'] = $this->formulario_fase_cinco->getAllTipoCuatroActivo($fase_cuatro_id);
		}
		$data['fase_tres_id'] = $fase_tres_id;
		$data['fase_cuatro_id'] = $fase_cuatro_id;
		$data['fase_cinco_id'] = $fase_cinco_id;
		$data['fase_step'] = $fase;
		$data['fase'] = $fase;
		$data['fase_id'] = $fase_id;

		$detalleformulario = $this->registro->get_detalleformulario_by_idformulario_idusuario($this->iIdUsuario, 1, $fase, $fase_id);

		$data['fase_tres_selecionada'] = $this->registro->faseSeccionada($fase_tres_id);

		if (count($detalleformulario) == 0 && (!isset($data['fase_cinco']))) {
			echo '<p style="margin-left: -1.8em;">No existe campos relacionados a este nivel</p>';
		}

		$columna = [];
		foreach ($detalleformulario as $row_detalleformulario):
			$columna[$row_detalleformulario->iIdDetalleFormulario] = [
				'vNombre' => $row_detalleformulario->vNombre,
				'campo' => strtolower($row_detalleformulario->campo),
				'iIdTipoCampo' => $row_detalleformulario->iIdTipoCampo,
				'cObligatorio' => $row_detalleformulario->cObligatorio,
				'alert_expiration' => $row_detalleformulario->alert_expiration,
				'cNumerico' => $row_detalleformulario->cNumerico,
				'locales_formulario_fase' => $row_detalleformulario->locales_formulario_fase,
				'locales_formulario_fase_id' => $row_detalleformulario->locales_formulario_fase_id,
				
			];
		endforeach;
		
		$data['columna'] = $columna;
		$data['opciones'] = explode(',', $this->registro->get_permisos_opciones($this->iIdUsuario, 1));

		$data['fase_cuatro'] = $this->formulario_fase_cuatro->getAllTipoTresActivo($fase_tres_id);
		$data['id_formulario'] = $fase_id;
		
		$this->load->view('locales/forms/principal', $data);
	}

	function formularios_campos_editar($id, $documento = false)
	{
		$fase = $this->input->post('fase');
		$fase_id = $this->input->post('fase_id');
		$fase_tres_id = $this->input->post('fase_tres_id');
		$fase_cuatro_id = $this->input->post('fase_cuatro_id');
		$fase_cinco_id = $this->input->post('fase_cinco_id');
		$idFormulario = ($this->input->post('formulario_id') != null) ? $this->input->post('formulario_id') : 1;

		if ($fase == 3) {
			$fase_tres_id = $fase_id;
		} elseif ($fase == 4) {
			$fase_cuatro_id = $fase_id;
		} elseif ($fase == 5) {
			$fase_cinco_id = $fase_id;
		}
		if ($fase == 4 || $fase == 5) {
			$data['fase_cinco'] = $this->formulario_fase_cinco->getAllTipoCuatroActivo($fase_cuatro_id);
		}
		$data['fase_tres_id'] = $fase_tres_id;
		$data['fase_cuatro_id'] = $fase_cuatro_id;
		$data['fase_cinco_id'] = $fase_cinco_id;
		$data['fase_step'] = $fase;

		$detalleformulario = $this->registro->get_detalleformulario_by_idformulario_idusuario(
			$this->iIdUsuario, $idFormulario,
			$fase,
			$fase_id		);


		$alertas = $this->registro->get_alertas_campos($id);
		$alertas = $alertas != null ? $alertas : [];
		$alertColumnas = [];

		foreach ($alertas as $id_alert => $alerta):
			$alertColumnas[$alerta->alert_id_formulario] = $alerta;
		endforeach;
		$data['alertas'] = $alertColumnas;

		$data['fase_tres_selecionada'] = $this->registro->faseSeccionada($fase_tres_id);
		if (count($detalleformulario) == 0 && (!isset($data['fase_cinco']))) {
			echo '<p style="margin-left: -1.8em;">No existe campos relacionados a este nivel</p>';
		}

		$campos = '';
		$columna = [];
		foreach ($detalleformulario as $row_detalleformulario):
			$detalle_formulario = new stdClass();
			$detalle_formulario->iIdDetalleFormulario = $row_detalleformulario->iIdDetalleFormulario;
			$detalle_formulario->vNombre = $row_detalleformulario->vNombre;
			$detalle_formulario->campo = strtolower($row_detalleformulario->campo);
			$detalle_formulario->iIdTipoCampo = $row_detalleformulario->iIdTipoCampo;
			$detalle_formulario->cObligatorio = $row_detalleformulario->cObligatorio;
			$detalle_formulario->alert_expiration = $row_detalleformulario->alert_expiration;
			$detalle_formulario->cNumerico = $row_detalleformulario->cNumerico;
			$detalle_formulario->locales_formulario_fase = $row_detalleformulario->locales_formulario_fase;
			$detalle_formulario->locales_formulario_fase_id = $row_detalleformulario->locales_formulario_fase_id;
			$columna[$row_detalleformulario->iIdDetalleFormulario] = $detalle_formulario;

			$campo = 'fase_' . $row_detalleformulario->locales_formulario_fase . '_fase_id_' . $row_detalleformulario->locales_formulario_fase_id . '_' . strtolower($row_detalleformulario->campo);
			if ($row_detalleformulario->iIdTipoCampo == 6):
				$campos .= ',' . 'DATE_FORMAT(' . $campo . ", '%d/%m/%Y')" . $campo;
			else:
				$campos .= ',' . $campo;
			endif;
		endforeach;
			$data['campos'] = $campos;
		if (!empty($campos)) {
			$campos = substr($campos, 1, 50000);
			$data['local'] = $this->registro->get_local_by_id($campos, $id);
		}
		
		$data['nombre_sitio'] = $this->registro->get_local_by_id('fase_3_fase_id_2_nombre_del_sitio', $id);
		 

		$data['columna'] = $columna;
		$data['iIdLocal'] = $id;
		$data['isDocumento'] = $documento;
		$subModule_permiso = $documento ? 14 : 1;
		$data['opciones'] = explode(',', $this->registro->get_permisos_opciones($this->iIdUsuario, $subModule_permiso));

		$data['fase_cuatro'] = $this->formulario_fase_cuatro->getAllTipoTresActivo($fase_tres_id);
		$data['id_formulario'] = $fase_id;
		$data['fase'] = $fase;
		$data['fase_id'] = $fase_id;
		
		$this->load->view('locales/forms/edit_principal', $data);
	}
}

?>