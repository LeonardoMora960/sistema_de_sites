<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Registro_usuario extends CI_Controller{
	
	var $argumento = array();
	var $cache_vipo_buscar = "__cache__Formulario__";
	var $limite_pagina = 15; //Limite por pagina
  	var $limite_pagina_cobranza = 1000; //Limite por pagina
  	var $tiempo_cache = 300; //5 minutos
	
	public function __construct(){
		parent::__construct();
		$this->load->model("usuario/usuario_model", "usuario");
		$this->load->model('process_model','administracion');
		$this->load->driver('cache', array('adapter' => 'file'));
		
		$this->iIdUsuario = $this->session->userdata('iIdUsuario');
		$this->Usuario = $this->session->userdata('usuario');
		$this->nombre = $this->session->userdata('nombre');
		$this->apellidos = $this->session->userdata('apellidos');
		
		$this->get_session();
		
		$this->argumento["modulo"] = $this->usuario->get_permiso_modulo($this->iIdUsuario);
	}
	
	private function get_session() {
        $this->argumento["iIdUsuario"] = $this->iIdUsuario;
        $this->argumento["usuario"] = $this->usuario;
		$this->argumento["NombreUsuario"] = $this->nombre.' '.$this->apellidos;
    }
	
	private function js($arg1 = "") {
        $js = "";
        switch ($arg1) {
            case "ingreso":
                $js = "<script src=\"assets/js/registroingresosalida/ingreso.js\"></script>";

            break;
				
            case "registro":
                $js = "<script src=\"".base_url()."public/js/usuario/usuario.js\"></script>";
				$js .= "<script type=\"text/javascript\">var gcontroller = 'usuario/registro_usuario';var gmethod = 'busqueda_usuario';var gform = 'frm_busqueda';gtitle = 'Registro de Usuarios';</script>";
				
            break;
			
			case "permiso":
                $js = "<script src=\"".base_url()."public/js/usuario/permiso.js\"></script>";
				$js .= "<script type=\"text/javascript\">var gcontroller = 'registro_usuario';var gmethod = 'permiso_usuario';var gform = 'frm_busqueda';gtitle = 'Registro de Administracion de Formularios';</script>";
				
            break;
			
			case "busqueda":
                $js = "<script src=\"".base_url()."public/js/usuario/busqueda.js\"></script>";
				$js .= "<script type=\"text/javascript\">var gcontroller = 'registro_usuario';var gmethod = 'permiso_usuario';var gform = 'frm_busqueda';gtitle = 'Log de Seguridad';</script>";
				
            break;
        }
        $this->argumento["jw_jsoptional"] = $js;
    }
	
	public function index(){
	
		$this->argumento["title"] = "Registrar usuario";
		$this->js("registro");
		$detalleformulario = $this->usuario->get_detalleformulario_by_idformulario(3);
		$mitad_formulario = ceil(count($detalleformulario) / 2);
		
		$formato_c1 = array();
		$formato_c2 = array();
		
		$columna1 = array();
		$columna2 = array();
		
		foreach($detalleformulario as $key => $row_detalleformulario):
		
			if(($key + 1) <= $mitad_formulario):
				array_push($columna1, [
					'vNombre' => $row_detalleformulario->vNombre,
					'campo' => strtolower($row_detalleformulario->campo),
					'iIdTipoCampo' => $row_detalleformulario->iIdTipoCampo,
					'cObligatorio' => $row_detalleformulario->cObligatorio,
					'cNumerico' => $row_detalleformulario->cNumerico
				]);
				/*$columna1[$key]->vNombre		= $row_detalleformulario->vNombre;
				$columna1[$key]->campo 			= strtolower($row_detalleformulario->campo);
				$columna1[$key]->iIdTipoCampo 	= $row_detalleformulario->iIdTipoCampo;
				$columna1[$key]->cObligatorio	= $row_detalleformulario->cObligatorio;
				$columna1[$key]->cNumerico		= $row_detalleformulario->cNumerico;*/
			elseif(($key + 1) > $mitad_formulario):
				array_push($columna2, [
					'vNombre' => $row_detalleformulario->vNombre,
					'campo' => strtolower($row_detalleformulario->campo),
					'iIdTipoCampo' => $row_detalleformulario->iIdTipoCampo,
					'cObligatorio' => $row_detalleformulario->cObligatorio,
					'cNumerico' => $row_detalleformulario->cNumerico
				]);
				/*$columna2[$key]->vNombre		= $row_detalleformulario->vNombre;
				$columna2[$key]->campo 			= strtolower($row_detalleformulario->campo);
				$columna2[$key]->iIdTipoCampo 	= $row_detalleformulario->iIdTipoCampo;
				$columna2[$key]->cObligatorio	= $row_detalleformulario->cObligatorio;
				$columna2[$key]->cNumerico		= $row_detalleformulario->cNumerico;*/
			endif;
		
		endforeach;
		
		$this->argumento["columna1"] = $columna1;
		$this->argumento["columna2"] = $columna2;
		
		$this->load->view('template/header',$this->argumento);
		$this->argumento["opciones"] = $this->usuario->get_permisos_opciones($this->iIdUsuario,9);
		$this->pagina="usuario/index";
		$this->load->view($this->pagina,$this->argumento);
		$this->load->view('template/footer');
	}
	
	function ver_usuario($id){
	
		$this->argumento["title"] = "Registrar usuario";
		$this->js("registro");
		$detalleformulario = $this->usuario->get_detalleformulario_by_idformulario(3);
		
		$mitad_formulario = ceil(count($detalleformulario) / 2);
		
		$formato_c1 = array();
		$formato_c2 = array();
		$campos = "";
		
		$columna1 = array();
		$columna2 = array();
		
		foreach($detalleformulario as $key => $row_detalleformulario):
		
			if(($key + 1) <= $mitad_formulario):
				array_push($columna1, [
					'vNombre' => $row_detalleformulario->vNombre,
					'campo' => strtolower($row_detalleformulario->campo),
					'iIdTipoCampo' => $row_detalleformulario->iIdTipoCampo,
					'cObligatorio' => $row_detalleformulario->cObligatorio,
					'cNumerico' => $row_detalleformulario->cNumerico
				]);
				/*$columna1[$key]->vNombre		= $row_detalleformulario->vNombre;
				$columna1[$key]->campo 			= strtolower($row_detalleformulario->campo);
				$columna1[$key]->iIdTipoCampo 	= $row_detalleformulario->iIdTipoCampo;
				$columna1[$key]->cObligatorio	= $row_detalleformulario->cObligatorio;
				$columna1[$key]->cNumerico		= $row_detalleformulario->cNumerico;*/
			elseif(($key + 1) > $mitad_formulario):
				/*$columna2[$key]->vNombre		= $row_detalleformulario->vNombre;
				$columna2[$key]->campo 			= strtolower($row_detalleformulario->campo);
				$columna2[$key]->iIdTipoCampo 	= $row_detalleformulario->iIdTipoCampo;
				$columna2[$key]->cObligatorio	= $row_detalleformulario->cObligatorio;
				$columna2[$key]->cNumerico		= $row_detalleformulario->cNumerico;*/
				array_push($columna2, [
					'vNombre' => $row_detalleformulario->vNombre,
					'campo' => strtolower($row_detalleformulario->campo),
					'iIdTipoCampo' => $row_detalleformulario->iIdTipoCampo,
					'cObligatorio' => $row_detalleformulario->cObligatorio,
					'cNumerico' => $row_detalleformulario->cNumerico
				]);
			endif;
			
			if($row_detalleformulario->iIdTipoCampo == 6):
				$campos .= ","."DATE_FORMAT(".strtolower($row_detalleformulario->campo).",'%d/%m/%Y')".strtolower($row_detalleformulario->campo);
			else:
				$campos .= ",".strtolower($row_detalleformulario->campo);
			endif;
			
			//$campos .= ",".strtolower($row_detalleformulario->campo);
			
		endforeach;
		
		$campos = substr($campos,1,50000);
		$campos = $campos.',eEstado';
		$this->argumento["usuario"] = $this->usuario->get_usuario_by_id($campos,$id);
		
	
		
		$this->argumento["columna1"] = $columna1;
		$this->argumento["columna2"] = $columna2;
		
		$this->argumento["edit_iIdUsuario"] = $id;
		
		$this->load->view('template/header',$this->argumento);
		$this->argumento["opciones"] = $this->usuario->get_permisos_opciones($this->iIdUsuario,9);
		$this->pagina="usuario/editar_usuario";
		$this->load->view($this->pagina,$this->argumento);
		$this->load->view('template/footer');
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
	
	function agregar_usuario(){
		
		$fecha = $this->usuario->get_detalleformulario_fecha_by_idformulario(3);
		
		/*foreach($fecha as $row_fecha):
			$campo =$row_fecha->campo;
			//$campo = strtolower($row_fecha->campo);
			$_POST[$campo]=(!empty($_POST[$campo]))?FormatoFecha($_POST[$campo],"Y-m-d"):"";
		endforeach;*/
		
		foreach($_POST as $key=>$rowPost){
		   $_POST[$key] = $this->validateDate($_POST[$key]);
		}
		
		$data 		= $_POST;
		
		if (!empty($_POST['iIdUsuario'])){
			$iIdUsuario = $_POST['iIdUsuario'];
			$this->usuario->update_usuario($iIdUsuario,$data);
			$evento = 5;
		}else{
			$iIdUsuario = $this->usuario->save_usuario($data);
			$evento = 4;
		}
		
		$data_log = array(
						   'iIdEvento' 		=> $evento,
						   'iIdUsuario'		=> $this->session->userdata('iIdUsuario'),
						   'dFecha_Log'		=> date('Y-m-d H:i:s'),
						   'vIp' 			=> getRealIP(),
						   'dRegistro' 		=> date('Y-m-d H:i:s'),
						   'iIdFormulario' 	=> 2,
							);
							
		$this->administracion->save_log($data_log);
		
		echo "success";
	
	}
	
	function busqueda_usuario(){
	
		$this->argumento["title"] = "Busqueda usuario";
		$this->js("busqueda");
		$this->load->view('template/header',$this->argumento);
		$this->argumento["area"]= $this->usuario->get_area();
		$this->argumento["tipo_de_usuario"] = $this->usuario->get_tipo_de_usuario();
		$this->argumento["opciones"] = $this->usuario->get_permisos_opciones($this->iIdUsuario,12);
		$this->pagina="usuario/busqueda_usuario";
		$this->load->view($this->pagina,$this->argumento);
		$this->load->view('template/footer');
	
	}
	
	function log_usuario(){
	
		$this->argumento["title"] = "Log usuario";
		$this->js("busqueda");
		$this->load->view('template/header',$this->argumento);
		$this->argumento["evento"] = $this->usuario->get_evento();
		$this->argumento["opciones"] = $this->usuario->get_permisos_opciones($this->iIdUsuario,11);
		$this->pagina="usuario/busqueda_log";
		$this->load->view($this->pagina,$this->argumento);
		$this->load->view('template/footer');
	
	}
	
	function buscar_usuario_all(){
			
		if ($_POST["nav"] == 1) {
			$array =array();
			$campos = 'iIdUsuario';
			
			$this->argumento["detalleformulario"] = $this->usuario->get_detalleformulario_by_idformulario(3);
			
			foreach($this->argumento["detalleformulario"] as $key => $row_detalleformulario):					
				
				if($row_detalleformulario->iIdTipoCampo == 6):
					$campos .= ","."DATE_FORMAT(".strtolower($row_detalleformulario->campo).",'%d/%m/%Y')".strtolower($row_detalleformulario->campo);
				else:
					$campos .= ",".strtolower($row_detalleformulario->campo);
				endif;
				
			endforeach;
			
			$_POST['campos'] = $campos;
			$_POST['fecha_de_expiracion_desde']=(!empty($_POST['fecha_de_expiracion_desde']))?FormatoFecha($_POST['fecha_de_expiracion_desde'],"Y-m-d"):"";
			$_POST['fecha_de_expiracion_hasta']=(!empty($_POST['fecha_de_expiracion_hasta']))?FormatoFecha($_POST['fecha_de_expiracion_hasta'],"Y-m-d"):"";
			$array = $_POST;
			$this->argumento["resultado"] = $this->cache->get($this->cache_vipo_buscar);
			
		} else {
			
			$array =array();
			$campos = 'iIdUsuario';
			
			$this->argumento["detalleformulario"] = $this->usuario->get_detalleformulario_by_idformulario(3);
			
			foreach($this->argumento["detalleformulario"] as $key => $row_detalleformulario):					
				
				if($row_detalleformulario->iIdTipoCampo == 6):
					$campos .= ","."DATE_FORMAT(".strtolower($row_detalleformulario->campo).",'%d/%m/%Y')".strtolower($row_detalleformulario->campo);
				else:
					$campos .= ",".strtolower($row_detalleformulario->campo);
				endif;
				
			endforeach;
			
			$_POST['campos'] = $campos;
			$_POST['fecha_de_expiracion_desde']=(!empty($_POST['fecha_de_expiracion_desde']))?FormatoFecha($_POST['fecha_de_expiracion_desde'],"Y-m-d"):"";
			$_POST['fecha_de_expiracion_hasta']=(!empty($_POST['fecha_de_expiracion_hasta']))?FormatoFecha($_POST['fecha_de_expiracion_hasta'],"Y-m-d"):"";
			$array = $_POST;
			$this->argumento["resultado"] = ObtenerCacheFile($this->cache_vipo_buscar, $this->usuario->buscar_usuario_all($array), $this->tiempo_cache);
			
		}
		
		$page = (isset($_POST['page']) && !empty($_POST['page'])) ? $_POST['page'] : 1;
		if ($page == 0)$page = 1;
		
		$this->argumento["opciones_registro_usuario"] = $this->usuario->get_permisos_opciones($this->iIdUsuario,9);
		$this->argumento["opciones_permiso"] = $this->usuario->get_permisos_opciones($this->iIdUsuario,10);
		$this->argumento["total"] = count($this->argumento["resultado"]);
		$this->argumento["limit"] = $this->limite_pagina;
		$this->argumento["page"] = $page;
		
		$this->load->view("usuario/busqueda_usuario_ajax", $this->argumento);
		
	}
	
	function buscar_log_all(){
			
		if ($_POST["nav"] == 1) {
			
			$this->argumento["resultado"] = $this->cache->get($this->cache_vipo_buscar);
			
		} else {
			
			$array =array();
			$array = $_POST;		
			
			$this->argumento["resultado"] = ObtenerCacheFile($this->cache_vipo_buscar, $this->usuario->buscar_log_all($array), $this->tiempo_cache);
			
		}
		
		$page = (isset($_POST['page']) && !empty($_POST['page'])) ? $_POST['page'] : 1;
		if ($page == 0)$page = 1;
		
		$this->argumento["total"] = count($this->argumento["resultado"]);
		$this->argumento["limit"] = $this->limite_pagina;
		$this->argumento["page"] = $page;
		
		$this->load->view("usuario/busqueda_log_ajax", $this->argumento);
		
	}	
	
	
	function permiso_usuario($id=0){
		
		$this->argumento["title"] = "Permiso usuario";
		$this->js("permiso");
		$this->load->view('template/header',$this->argumento);
		$campos = "CONCAT(nombre,' ',apellidos)nombre,dni,usuario";
		if($id > 0)$this->argumento["usuario_datos"] = $this->usuario->get_usuario_by_id($campos,$id);
		$this->argumento["NiIdUsuario"] = $id;
		$this->argumento["opciones"] = $this->usuario->get_permisos_opciones($this->iIdUsuario,10);
		$this->pagina="usuario/busqueda_permiso";
		$this->load->view($this->pagina,$this->argumento);
		$this->load->view('template/footer');
		
	}
	
	function buscar_permiso_all(){
	
		$array =array();
		$array = $_POST;		
		$this->argumento["opciones"] = $this->usuario->get_opciones();
		
		$this->argumento["permisos"] = $this->usuario->buscar_permiso_all($array);	
		$this->argumento["opciones_permiso"] = $this->usuario->get_permisos_opciones($this->iIdUsuario,10);
		$this->load->view("usuario/busqueda_permiso_ajax", $this->argumento);
		
	}
	
	function recuperar_codigo_usuario_x_nombre(){

		$term=$_GET["term"];
		$data=$this->usuario->get_by_codigo_usuario_x_nombre($term);
		
		if(!empty($data)){
			foreach($data as $leer){
					$array[]=array(	"value"			=>$leer->nombre,
									"label"			=>$leer->nombre,
									"iIdUsuario"	=>$leer->iIdUsuario
									);
			}
		echo json_encode($array);
		} 

	}
	
	function recuperar_codigo_usuario_x_dni(){

		$term=$_GET["term"];
		$data=$this->usuario->get_by_codigo_usuario_x_dni($term);
		
		if(!empty($data)){
			foreach($data as $leer){
					$array[]=array(	"value"			=>$leer->dni,
									"label"			=>$leer->dni,
									"iIdUsuario"	=>$leer->iIdUsuario
									);
			}
		echo json_encode($array);
		} 

	}
	
	function recuperar_codigo_usuario_x_usuario(){

		$term=$_GET["term"];
		$data=$this->usuario->get_by_codigo_usuario_x_usuario($term);
		
		if(!empty($data)){
			foreach($data as $leer){
					$array[]=array(	"value"			=>$leer->usuario,
									"label"			=>$leer->usuario,
									"iIdUsuario"	=>$leer->iIdUsuario
									);
			}
		echo json_encode($array);
		} 

	}
	
	function agregar_permiso(){
	
		parse_str($this->input->post('formdata'),$_FORM);

		$data = $_FORM;
		
		$iIdUsuario = $_FORM['iIdUsuario'];
		
		$this->usuario->save_permiso($iIdUsuario,$this->input->post('detalle'),$this->input->post('sub_detalle'));
		//$this->logistica->save_detallefichatecnicacolor($iIdFichaTecnica,$this->input->post('sub_detalle'));
				
		echo "success";
		
	}

	public function permiso_campo()
	{
		$this->argumento["permisocampo"] = $this->usuario->get_permisocampo_by_idformulario_idusuario(1, $this->input->post('iIdUsuario'));
		$this->pagina="usuario/view_frm_permiso_campo";
		$this->load->view($this->pagina, $this->argumento);
	}
	
	function agregar_permisocampo(){
	
		parse_str($this->input->post('formdata'),$_FORM);
		$data = $_FORM;
		$iIdUsuario = $_FORM['iIdUsuario'];
		
		$this->usuario->save_permisocampo($iIdUsuario,$this->input->post('detalle'));
				
		echo "success";
		
	}
	
	function descargar($archivo){
	   
	    $extension=extension($archivo);
		$name=explode(".",$archivo);
		
		$name_fichero=$name[0].".xls";
		
		if(strcmp($extension,"xls")==0):
			header("Content-type: application/vnd.ms-excel; name='excel'");
			header("Content-Disposition: filename=".$name_fichero);
			header("Pragma: no-cache");
			header("Expires: 0");
			$tabla_excel.=file_get_contents("excel/usuario/".$archivo);
			echo utf8_decode($tabla_excel);
		else:
			header("Content-Type: application/octet-stream");
			header("Content-Disposition: attachment; filename=" .($archivo));
			header("Content-Type: application/octet-stream"); 
			header("Content-Type: application/download"); 
			header("Content-Description: File Transfer"); 
			//header("Content-Length: " . filesize($archivo)); 
			header("Content-Length: ".filesize('archivo/pdf/usuario/'.$archivo));
			readfile('archivo/pdf/usuario/'.$archivo);
			flush();
			endif;
	}
	
	function pdf_usuario_busqueda(){
			
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
		$clspdf->Cell(40,4,"BUSQUEDA DE USUARIO",0,0,'');
		$y+=6;
		
		$array =array();
		$campos = 'iIdUsuario';
		
		$detalleformulario = $this->usuario->get_detalleformulario_by_idformulario(3);
		
		foreach($detalleformulario as $key => $row_detalleformulario):					
			if($row_detalleformulario->iIdTipoCampo == 6):
				$campos .= ","."DATE_FORMAT(".strtolower($row_detalleformulario->campo).",'%d/%m/%Y')".strtolower($row_detalleformulario->campo);
			else:
				$campos .= ",".strtolower($row_detalleformulario->campo);
			endif;
		endforeach;
		
		$_POST['campos'] = $campos;
		$array = $_POST;
		$usuario = $this->usuario->buscar_usuario_all($array);
		
		/****************/
		$clspdf->SetXY($x,$y+=12);
		
		foreach($usuario as $key=>$row_usuario):
			if($key == 0):
				$clspdf->SetFont('Arial','B',6);
				foreach($detalleformulario as $row_detalleformulario):
					$campo = strtolower($row_detalleformulario->campo);
					$clspdf->setX($x);
					$x=$clspdf->GetX();
					$clspdf->MultiCell(30,3,utf8_decode("\n ".$row_detalleformulario->vNombre."\n "),1,'C');$clspdf->SetXY($x,$y);
					$x += 30;
				endforeach;
				
				$clspdf->SetXY($x,$y+=6);
				
			endif;
			
			$clspdf->setX(5);
			$x=$clspdf->GetX();
			$clspdf->SetXY($x,$y+=6);
			
			foreach($detalleformulario as $row_detalleformulario):
				$campo = strtolower($row_detalleformulario->campo);
				$vNombre = $row_usuario->$campo;
				if($row_detalleformulario->iIdTipoCampo == 3):
					$vNombre = $this->usuario->get_vNombre_tabla_by_id($campo,$row_usuario->$campo);
				endif;
				$clspdf->setX($x);
				$x=$clspdf->GetX();
				$clspdf->MultiCell(30,3,utf8_decode($vNombre),0,'C');$clspdf->SetXY($x,$y);
				$x += 30;
			endforeach;
			
		endforeach;
		
		
		$clspdf->Output('archivo/pdf/usuario/usuario_busqueda.pdf');
		
		echo "{'tipo':'pdf','archivo':'usuario_busqueda.pdf'}";
			
	}
	
	function pdf_usuario_log(){
			
		$this->load->helper(array('fpdf', 'file'));
		
		$clspdf = new PDF('P', 'mm', 'A4');
		$clspdf->SetAutoPageBreak(true,5);  
		$clspdf->AddPage();
		
		$clspdf->setX(5);
		$x=$clspdf->GetX();
		$y = 5;
		$clspdf->SetY($y);
		$y=$clspdf->GetY();$y+=5;
		$clspdf->SetXY($x,$y);
		
		$clspdf->SetFont('Arial','B',8);
		$clspdf->Cell(40,4,"LOG DE SEGURIDAD",0,0,'');
		$y+=6;
		
		$clspdf->SetXY($x,$y+=6);
		
		$array =array();
		$array = $_POST;		
			
		$log = $this->usuario->buscar_log_all($array);
		
		foreach($log as $key=>$row):
			if($key == 0):
				$clspdf->SetFont('Arial','B',8);
				$clspdf->MultiCell(10,3,"\n Item \n ",1,'C');$clspdf->SetXY(15,$y);
				$clspdf->MultiCell(40,3,"\n Nombre y apellidos \n ",1,'C');$clspdf->SetXY(55,$y);
				$clspdf->MultiCell(20,3,"\n DNI \n ",1,'C');$clspdf->SetXY(75,$y);
				$clspdf->MultiCell(30,3,utf8_decode("\n Tipo de usuario \n "),1,'C');$clspdf->SetXY(105,$y);
				$clspdf->MultiCell(30,3,"\n Usuario \n ",1,'C');$clspdf->SetXY(135,$y);
				$clspdf->MultiCell(20,3,"\n IP \n ",1,'C');$clspdf->SetXY(155,$y);
				$clspdf->MultiCell(30,3,utf8_decode("\n Evento \n "),1,'C');$clspdf->SetXY(185,$y);
				$clspdf->MultiCell(20,3,"\n Estado \n ",1,'C');$clspdf->SetXY(205,$y);
				$clspdf->SetXY($x,$y+=6);
			endif;
			
			$clspdf->setX(5);
			$x=$clspdf->GetX();
			$clspdf->SetXY($x,$y+=6);
			$clspdf->SetFont('Arial','',7);
			
			$clspdf->MultiCell(10,3,($key+1),0,'C');$clspdf->SetXY(15,$y);
			$clspdf->MultiCell(40,3,$row->nombre.' '.$row->apellidos,0,'C');$clspdf->SetXY(55,$y);
			$clspdf->MultiCell(20,3,$row->dni,0,'C');$clspdf->SetXY(75,$y);
			$clspdf->MultiCell(30,3,utf8_decode($row->tipo_de_usuario),0,'C');$clspdf->SetXY(105,$y);
			$clspdf->MultiCell(30,3,utf8_decode($row->usuario),0,'C');$clspdf->SetXY(135,$y);
			$clspdf->MultiCell(20,3,utf8_decode($row->vIp),0,'C');$clspdf->SetXY(155,$y);
			$clspdf->MultiCell(30,3,utf8_decode($row->evento),0,'C');$clspdf->SetXY(185,$y);
			$clspdf->MultiCell(20,3,utf8_decode($row->estado),0,'C');$clspdf->SetXY(205,$y);
			
		endforeach;
		
		$clspdf->Output('archivo/pdf/usuario/usuario_log.pdf');
		
		echo "{'tipo':'pdf','archivo':'usuario_log.pdf'}";
			
	}
	
	function pdf_usuario_permiso(){
			
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
		$clspdf->Cell(40,4,"PERMISOS DE USUARIO",0,0,'');
		$y+=6;
		
		$array =array();
		$array = $_POST;
		$opciones = $this->usuario->get_opciones();
		$campos = "CONCAT(nombre,' ',apellidos)nombre,dni,usuario";
		$usu = $this->usuario->get_usuario_by_id($campos,$_POST['iIdUsuario']);
		$permisos = $this->usuario->buscar_permiso_all($array);
		
		/****************/
		$clspdf->SetXY($x,$y+=6);
		
		$clspdf->Cell(40,3,"Nombre y apellidos :",0,0,'L');
		$clspdf->Cell(70,3,$usu->nombre,0,0,'L');$y+=5;
		$clspdf->SetXY($x,$y);
		$clspdf->Cell(40,3,"Usuario :",0,0,'L');
		$clspdf->Cell(70,3,$usu->usuario,0,0,'L');$y+=5;
		$clspdf->SetXY($x,$y);
		$clspdf->Cell(40,3,"DNI:",0,0,'L');
		$clspdf->Cell(70,3,$usu->dni,0,0,'L');$y+=10;
		$clspdf->SetXY($x,$y);
		
		foreach($permisos as $key=>$row_permisos):
			if($key == 0):
				$clspdf->SetFont('Arial','B',7);
				$clspdf->SetXY($x,$y);
				$clspdf->Cell(70,3,"Módulo",1,0,'C');
				$clspdf->Cell(75,3,"Sub Módulo",1,0,'C');
				$clspdf->Cell(20,3,"Visualizar",1,0,'C');
				$clspdf->Cell(20,3,"Nuevo",1,0,'C');
				$clspdf->Cell(20,3,"Editar",1,0,'C');
				$clspdf->Cell(20,3,"Eliminar",1,0,'C');
				$clspdf->Cell(20,3,"Imprimir",1,0,'C');
				$clspdf->Cell(20,3,"Importar",1,0,'C');
				$clspdf->Cell(20,3,"Exportar",1,0,'C');
				//$clspdf->SetXY($x,$y+=6);
			endif;
			
			$clspdf->setX(5);
			$x=$clspdf->GetX();
			$clspdf->SetXY($x,$y+=6);
			
			$clspdf->Cell(70,3,utf8_decode($row_permisos->modulo),0,0,'C');
			$clspdf->Cell(75,3,utf8_decode($row_permisos->submodulo),0,0,'C');
				
			$permiso = explode(',',$row_permisos->permiso);
			foreach($opciones as $key_opciones=>$row_opciones):
				$check = "--";
				$iIdDetalleSubModulo = $this->usuario->validar_detalle_submodulo($row_permisos->iIdSubModulo,$row_opciones->id);
				if($iIdDetalleSubModulo)$check = "--";
				if(isset($permiso[$key_opciones]) && $permiso[$key_opciones] == 1 && $check == '--')$check = "Si";
				$clspdf->Cell(20,3,$check,0,0,'C');
			endforeach;
			
		endforeach;
		
		
		$clspdf->Output('archivo/pdf/usuario/usuario_permiso.pdf');
		
		echo "{'tipo':'pdf','archivo':'usuario_permiso.pdf'}";
			
	}
	
	
	
	
}

?>