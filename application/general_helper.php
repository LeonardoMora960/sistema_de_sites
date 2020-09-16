<?php
   function FormatoNumero($numero=0,$dig=2,$dec=".",$mil=""){
  //if(validar_numero($numero)){
	 $numero=number_format($numero,$dig,$dec,$mil); // Mostrar� 3.422,38 	
  //}
  return $numero;
  }
   function FormatoFecha($pdate,$format){
      if(!empty($pdate)){
       $date = str_replace('/', '-', $pdate);
       return date($format, strtotime($date));
      }
    }
    
   //retorna la extension del archivo
   function extension($filename){$file = explode(".",$filename); return strtolower(end($file));}
   
   
    #retornar nombre de archivo valido
    function NombreArchivo($archivo=""){
      //$archivo=explode(".",$archivo);
      $extension=extension($archivo);
      $archivo=utf8_decode($archivo);
      $archivo=preg_replace('/(.pdf|.jpg|.jpeg|.png|.gif)$/', '',$archivo);
      $archivo=safename($archivo);
      return $archivo.".".$extension;      
    }    
   
   function safename($title){
// reemplazamos todos los caracteres no deseados de una cadena por "-" ;
		$title = str_replace("&", "and", $title);
		$arrStupid = array('feat.', 'feat', '.com', '(tm)', ' ', '*', "'s",  '"', ",", ":", ";", "@", "#", "(", ")", "?", "!", "_",
							 "$","+", "=", "|", "'", '/', "~", "`s", "`", "\\", "^", "[","]","{", "}", "<", ">", "%", "™");

		$title = htmlentities($title);
  		$title = preg_replace('/&([a-zA-Z])(.*?);/','$1',$title); // get rid of bogus characters
		$title = strtolower("$title");
		$title = str_replace(".", "", $title);
		$title = str_replace($arrStupid, "-", $title);
		$flag = 1;
			while($flag){ 
  			  $newtitle = str_replace("--","-",$title);
				if($title != $newtitle) { 
					$flag = 1;
				 }
				else $flag = 0;
 			  $title = $newtitle;
			}
		$len = strlen($title);
		if($title[$len-1] == "-") {
			$title = substr($title, 0, $len-1);
		}
		return $title;
  }
  
  function validar_numero($element) {
	if (preg_match("/^[0-9]+$/", $element))
		return true;
		else
		return false;
}

function RemoveFile($path='',$file=''){
  if(!empty($path)){
	  if(isset($file) && !empty($file)){
		  if(is_array($file)){
			  foreach($file as $read){
			    @unlink($path.$read);
			  }
			}else{
			 @unlink($path.$file);
			}
		}
  }
        
}


function fn_insert($arr, $table){   
    $CI =& get_instance();
		while (list($_key, $_val) = each($arr))
    {
        $key[] = $_key;
        $val[] = $_val;
    }
    $arr_str = array();
    for ($i = 0; $i < count($val); $i++)
    {
        if (is_int($val[$i])) $arr_str[] = $val[$i];
		else if(strtoupper($val[$i])=='NOW()')
		$arr_str[] = "NOW()";
		else
		//$arr_str[] = "'" . $val[$i] . "'";
		$arr_str[] = $CI->db->escape($val[$i]);
    }
    $fields = implode(",", $key);
    $values = implode(",", $arr_str);
    $sql = "INSERT INTO " . $table . "($fields) VALUES ($values)";
		$result = $CI->db->query($sql) or die(mysql_error());

    if ($result) return true;

    else return false;
}


function fn_update($arr, $table, $arr_where,$orando=" AND "){
    $CI =& get_instance();
		
		while (list($_key, $_val) = each($arr))
    {
        $key[] = $_key;
        $val[] = $_val;
    }
    $arr_str = array();
    for ($i = 0; $i < count($val); $i++)
    {
        if (is_int($val[$i])) $arr_str[] = $key[$i] . "=" . $val[$i];
        else $arr_str[] = $key[$i] . "=" . $CI->db->escape($val[$i]);
        //else $arr_str[] = $key[$i] . "='" . $val[$i] . "'";
    }
    $values = implode(",", $arr_str);
    $key = array();
    $val = array();
    while (list($_key, $_val) = each($arr_where))
    {
        $key[] = $_key;
        $val[] = $_val;
    }
    $arr_str = array();
    for ($i = 0; $i < count($val); $i++)
    {
        
        //if (is_int($val[$i])) $arr_str[] = $key[$i] . "=" . $val[$i];
        //else $arr_str[] = $key[$i] . "=" . $CI->db->escape($val[$i]);
       
      if (is_int($val[$i])) $arr_str[] = $key[$i] . "=" . $val[$i];
      elseif(strtoupper($val[$i])=='NOW()') $arr_str[] = $key[$i] . "=NOW()";
      else $arr_str[] = $key[$i] . "=" . $CI->db->escape($val[$i]);
      
         //if (is_int($val[$i])) $arr_str[] = $key[$i];
         // else if(strtoupper($val[$i])=='NOW()')
         //$arr_str[] = "NOW()";
         // else
         //$arr_str[] = $CI->db->escape($val[$i]);
      
        
        
				//else $arr_str[] = $key[$i] . "='" . $val[$i] . "'";
    }
    $where = implode($orando, $arr_str);
    $sql = "UPDATE " . $table . " SET $values WHERE $where";
    //echo $sql;
    $result = $CI->db->query($sql)or die(mysql_error());
    //$result = $GLOBALS['CONNECT']->Query($sql)or die(mysql_error());
    if ($result) return true;
    else return false;
}


//funcion para guardar la informacion en cache
function ObtenerCacheFile($prefijo="",$dataobj="",$expiretime=3600){
   $CI =&get_instance();
   $CI->load->driver('cache', array('adapter' => 'file'));

   $expiretime=($expiretime<=0)?300:$expiretime;
   $data="";
   if(!empty($prefijo)){
     $data=$CI->cache->get($prefijo);
      /*
      //if(empty($data)){
        $data=$dataobj;
        $CI->cache->save($prefijo, $data, 2360);
        //var_dump($CI->cache->cache_info());
      //}
       */
      //if(empty($dataobj)) @$CI->cache->delete($prefijo);
      
      //if(empty($data)){
        $data=$dataobj;
        $CI->cache->save($prefijo, $data, $expiretime);
      //}
   }
   return $data;
}



//PAGINACION AJAX
function Paginador($page=1, $totalitems=0, $limit=15, $function_js="", $params='', $fase = '', $fase_id = '')
{
 $adjacents = 1;
 if(!$limit) $limit = 15;
 if(!$page) $page = 1;
 
 $prev = $page - 1;									     //previous page is page - 1
 $next = $page + 1;									     //next page is page + 1
 $lastpage = ceil($totalitems / $limit); //lastpage is = total items / items per page, rounded up.
 $lpm1 = $lastpage - 1;								   //last page minus 1
 
 if(!empty($params))$params=',\''.$params.'\'';
 if (!empty($fase)) {
	$params .= ", $fase, $fase_id";
}
 
 $pagination = "";
 if($lastpage > 1){
   //Anterior
	 if ($page > 1)
	   $pagination .= "<a href=\"javascript:void(0);\" onclick=\"$function_js($prev$params);\">&laquo; Anterior</a>";
	 else
	   $pagination .= "<span class=\"disabled\">&laquo; Anterior</span>";	
	 
	 //mostrar la numeracion
	 if ($lastpage < 7 + ($adjacents * 2)){	
			for ($counter = 1; $counter <= $lastpage; $counter++){
				if ($counter == $page)
					$pagination .= "<span class=\"current\">$counter</span>";
				else
					$pagination .= "<a href=\"javascript:void(0);\"  onclick=\"$function_js($counter$params);\">$counter</a>";
			}
		}
	 elseif($lastpage >= 7 + ($adjacents * 2)){//mostrar numeracion avanzada
			if($page < 1 + ($adjacents * 3)){
				for ($counter = 1; $counter < 5 + ($adjacents * 2); $counter++){
					if ($counter == $page)
						$pagination .= "<span class=\"current\">$counter</span>";
					else
						$pagination .= "<a href=\"javascript:void(0);\" onclick=\"$function_js($counter$params)\">$counter</a>";					
				}
				$pagination .= "...";
				$pagination .= "<a href=\"javascript:void(0);\" onclick=\"$function_js($lpm1$params)\">$lpm1</a>";
				$pagination .= "<a href=\"javascript:void(0);\" onclick=\"$function_js($lastpage$params)\">$lastpage</a>";		
			}//fin del if
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)){
				$pagination .= "<a href=\"javascript:void(0);\" onclick=\"$function_js(1$params)\">1</a>";
				$pagination .= "<a href=\"javascript:void(0);\" onclick=\"$function_js(2$params)\">2</a>";
				$pagination .= "...";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++){
					if ($counter == $page)
						$pagination .= "<span class=\"current\">$counter</span>";
					else
						$pagination .= "<a href=\"javascript:void(0);\" onclick=\"$function_js($counter$params)\" >$counter</a>";					
				}
				$pagination .= "...";
				$pagination .= "<a href=\"javascript:void(0);\" onclick=\"$function_js($lpm1$params)\">$lpm1</a>";
				$pagination .= "<a href=\"javascript:void(0);\" onclick=\"$function_js($lastpage$params)\">$lastpage</a>";		
			}else{
				$pagination .= "<a href=\"javascript:void(0);\" onclick=\"$function_js(1$params)\" >1</a>";
				$pagination .= "<a href=\"javascript:void(0);\" onclick=\"$function_js(2$params)\" >2</a>";
				$pagination .= "...";
				for ($counter = $lastpage - (1 + ($adjacents * 3)); $counter <= $lastpage; $counter++){
					if ($counter == $page)
						$pagination .= "<span class=\"current\">$counter</span>";
					else
						$pagination .= "<a href=\"javascript:void(0);\" onclick=\"$function_js($counter$params)\">$counter</a>";					
				}
			}
		}
		
		
		if ($page <= $counter) 
			if($page == $lastpage) {
			$pagination .= "<span class=\"disabled\">Siguiente &raquo;</span>";
			}
			else {
			$pagination .= "<a href=\"javascript:void(0);\" onclick=\"$function_js($next$params)\"><b>Siguiente &raquo;</b></a>";
			}
		else
			$pagination .= "<span class=\"disabled\">Siguiente &raquo;</span>";
		//$pagination .= "</div>\n";
 }//mayor
 return $pagination;
}//cierra funcion


function toHtmlEntities($string="",$utf8=true){
    if($utf8==true) return htmlentities($string,ENT_COMPAT,"UTF-8");
   return htmlentities($string);
}

function HoraAmPm($is_db=false,$time=""){
  if(!empty($time)){
	 return date("h:i A",strtotime($time));
  }else{
      if($is_db==true)
	return date("h:i:s a",time());
      else
	return date("h:i A",time());
  }
}

function diferencia_meses($fecha_actual,$fecha_anterior){

$diff = abs(strtotime($fecha_actual) - strtotime($fecha_anterior));

$years = floor($diff / (365*60*60*24));
$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

if(!empty($years)){
			 $months=((int)$years*12)+(int)$months; 
		}else{
		     $months=$months;
		}

$informacion_fecha=array("year"=>$years,"month"=>$months,"day"=>$days);

return $informacion_fecha;

}





  function Obtener_color_bg_orsy($tnt,$orsy){
	  
	  $color="";
	  
	  if(strcmp($orsy,1)==0 && strlen($tnt)==0):
	       $color="#FCD5B4";
	  endif;
	  
	  if(strcmp($orsy,0)==0 && strcmp($tnt,1)==0):
	       $color="#FFFF00";
	  endif;
	  
	  
	  if(strcmp($orsy,0)==0 && strcmp($tnt,0)==0):
	       $color="#FFFF99";
	  endif;
	  
	  if(strcmp($orsy,0)==0 && strlen($tnt)==0):
	       $color="#FFFFFF";
	  endif;
	  
	  if(strcmp($orsy,1)==0 && strcmp($tnt,1)==0):
	       $color="#C0504D";
	  endif;
	  
	   if(strcmp($orsy,1)==0 && strcmp($tnt,0)==0):
	       $color="#E6B8B7";
	  endif;
	  
	  return $color;
 
  }
  
  
  function FuncRestarFecha($d=""){
      $d = strtotime(FormatoFecha($d, "Y-m-d"));
      $td = date("Y-m-d");
      $td = strtotime(date($td));
      return $td-$d;
 }


  function quitar_comilla($str=""){
    $array=array("'",'"');
    return str_replace($array, "", $str);
  }
  
  
  function slug_c($name){
		$sname = trim($name); 
		$sname = preg_replace('/\s+/','-',$sname); 
		$table = array(
		'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'C'=>'C', 'c'=>'c', 'C'=>'C', 'c'=>'c',
		'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
		'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O',
		'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'S',
		'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e',
		'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o',
		'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b',
		'ÿ'=>'y', 'R'=>'R', 'r'=>'r', ','=>'', '&'=>'y', '--'=>'-', '---'=>'-'
		);
		$sname = strtr($sname, $table);
		$sname = preg_replace('/[^A-Za-z0-9-]+/', "", $sname);
		$sname = strtolower($sname);
		return $sname;
}
  
  function devolver_cod_banco($name){
	   
	   $cod_banco='';
	   switch($name):
			case  'bcp-mn':
			$cod_banco=1;
			break;
			case  'bcp-me':

			$cod_banco=2;
			break;
			case  'scotiabank-mn':
			$cod_banco=3;
			break;
	   endswitch;
	   
	   return $cod_banco;
         
  }
  
  
   function Descargar($ruta,$archivo){
	   echo "--------->" . $ruta,$archivo . "<br>";
	   header('Cache-Control: no-store, no-cache, must-revalidate'); 
	   header('Pragma: public');
	   header("Expires: 0");
	   header("Content-Type: application/force-download");
	   header("Content-Type: application/octet-stream");
	   header("Content-Type: application/download");
	   header("Content-Disposition: attachment; filename=".date("d-m-Y")."_".$archivo);
	   header("Content-Transfer-Encoding:­ binary");
	   header("Content-Length: ".filesize($ruta.$archivo));
	   readfile($ruta.$archivo); 
	   exit();
	}
  
	function getRealIP() {
		if (!empty($_SERVER['HTTP_CLIENT_IP']))
			return $_SERVER['HTTP_CLIENT_IP'];
		   
		if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
			return $_SERVER['HTTP_X_FORWARDED_FOR'];
		
		return $_SERVER['REMOTE_ADDR'];
	}
	
	
	function establecer_funcion_mantenedor(){

		$datos=array(
			'unic_empresa'=>
			    array(
				'funcion'=>'listar_empresa',
			    'archivo'=>'view_mantenedor_ajax_empresa',
			    'archivo_frm' => 'view_frm_empresa'
			    ),
			'unic_marca'=>
			    array(
			    'funcion'=>'listar_marca',
			    'archivo'=>'view_mantenedor_ajax_marca',
			    'archivo_frm'=>'view_frm_marca'
			    ),
			'unic_color'=>
			    array(
			    'funcion'=>'listar_color',
			    'archivo'=>'view_mantenedor_ajax_color',
			    'archivo_frm'=>'view_frm_color'
			    ),
			'unic_pais'=>
			    array(
			    'funcion'=>'listar_pais',
			    'archivo'=>'view_mantenedor_ajax_pais',
			    'archivo_frm'=>'view_frm_pais'
			    ),
			'unic_genero'=>
			    array(
			    'funcion'=>'listar_genero',
			    'archivo'=>'view_mantenedor_ajax_genero',
			    'archivo_frm'=>'view_frm_genero'
			    ),
			'unic_talla'=>
			    array(
			    'funcion'=>'listar_talla',
			    'archivo'=>'view_mantenedor_ajax_talla',
			    'archivo_frm'=>'view_frm_talla'
			    ),
			'unic_articulo'=>
			    array(
			    'funcion'=>'listar_articulo',
			    'archivo'=>'view_mantenedor_ajax_articulo',
			    'archivo_frm'=>'view_frm_articulo'
			    ),
			'unic_ciudad'=>
			    array(
			    'funcion'=>'listar_ciudad',
			    'archivo'=>'view_mantenedor_ajax_ciudad',
			    'archivo_frm'=>'view_frm_ciudad'
			    ),
			'unic_clasificacion'=>
			    array(
			    'funcion'=>'listar_clasificacion',
			    'archivo'=>'view_mantenedor_ajax_clasificacion',
			    'archivo_frm'=>'view_frm_clasificacion'
			    ),
			'unic_proveedor'=>
			    array(
			    'funcion'=>'listar_proveedor',
			    'archivo'=>'view_mantenedor_ajax_proveedor',
			    'archivo_frm'=>'view_frm_proveedor'
			    ),
			'unic_lavadotela'=>
			    array(
			    'funcion'=>'listar_lavadotela',
			    'archivo'=>'view_mantenedor_ajax_lavadotela',
			    'archivo_frm'=>'view_frm_lavadotela'
			    ),
			'unic_lavadoprenda'=>
			    array(
			    'funcion'=>'listar_lavadoprenda',
			    'archivo'=>'view_mantenedor_ajax_lavadoprenda',
			    'archivo_frm'=>'view_frm_lavadoprenda'
			    ),
			'unic_hilo'=>
			    array(
			    'funcion'=>'listar_hilo',
			    'archivo'=>'view_mantenedor_ajax_hilo',
			    'archivo_frm'=>'view_frm_hilo'
			    ),
			'unic_tela'=>
			    array(
			    'funcion'=>'listar_tela',
			    'archivo'=>'view_mantenedor_ajax_tela',
			    'archivo_frm'=>'view_frm_tela'
			    ),	
			'unic_tiposervicio'=>
			    array(
			    'funcion'=>'listar_tiposervicio',
			    'archivo'=>'view_mantenedor_ajax_tiposervicio',
			    'archivo_frm'=>'view_frm_tiposervicio'
			    ),
			'unic_coleccion'=>
			    array(
			    'funcion'=>'listar_coleccion',
			    'archivo'=>'view_mantenedor_ajax_coleccion',
			    'archivo_frm'=>'view_frm_coleccion'
			    )			
												
		);
       return $datos;
	}
	

/*
Obtengo el direcctorio antes del controlador. Sirve para los controladores que estan en subcarpetas
*/

function path_of_controller()
{
	$CI =& get_instance();
	$url = $CI->uri->uri_string();
	$method = $CI->router->fetch_class();
	$url = explode($method, $url);
	return $url[0].$method;
}

/* End of file MY_url_helper.php */
/* Location: ./application/helpers/MY_url_helper */

 
?>
