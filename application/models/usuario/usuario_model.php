<?php
class Usuario_model extends CI_Model{
	
	function get_detalleformulario_by_idformulario($iIdFormulario){
		
		$sql = "SELECT
iIdDetalleFormulario		
,vNombre
,REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(vNombre,' ','_'),'-',''),'ñ','n'),'á','a'),'é','e'),'í','i'),'ó','o'),'ú','u') as campo
,iIdTipoCampo
,cObligatorio
,cNumerico
FROM 		locales_detalleformulario
WHERE		iIdFormulario = ".$iIdFormulario."
AND			eEstado = 1
ORDER BY iOrden";
		$sql = utf8_encode($sql);	
		$query = $this->db->query($sql);
		return $query->result();
		
	}
	
	function get_tabla($campo){
		
		$sql = "SELECT 	".$campo." id,CONCAT(vCodigo,' - ',vNombre) vNombre
FROM 		locales_".$campo;
		$sql = utf8_encode($sql);	
		$query = $this->db->query($sql);
		return $query->result();
		
	}
	
	
	function save_usuario($data){
		$this->db->insert('locales_usuario', $data);
		return $this->db->insert_id();		
	}
	
	function update_usuario($id, $data){
		$this->db->where('iIdUsuario', $id);
		return $this->db->update('locales_usuario', $data);
	}
	
	function buscar_usuario_all($array=array()){
		
		$datos 			= array();
		
		$sql = "
SELECT
".$array['campos']."
FROM 		locales_usuario us
WHERE 1 = 1 ";
		
		if(!empty($array["nombre"])){
			$sql .= " AND 	CONCAT(us.nombre,' ',us.apellidos) like ?";
			array_push($datos,"%".$array["nombre"]."%");
		}
		
		if(!empty($array["dni"])){			
			$sql .= " AND 	us.dni like ?";
			array_push($datos,"%".$array["dni"]."%");
		}
		
		if(!empty($array["tipo_de_usuario"])){
			$sql .= " AND 	us.tipo_de_usuario = ?";
			array_push($datos,$array["tipo_de_usuario"]);
		}
		
		if(!empty($array["area"])){
			$sql .= " AND 	us.area = ?";
			array_push($datos,$array["area"]);
		}
		
		if(!empty($array["eEstado"])){
			$sql .= " AND 	us.eEstado = ".$array["eEstado"];
		}
		
		if(!empty($array["fecha_de_expiracion_desde"]) || !empty($array["fecha_de_expiracion_hasta"])){
			
			if(!empty($array["fecha_de_expiracion_desde"])){
				
				$sql .= " AND 	fecha_de_expiracion >= '".$array["fecha_de_expiracion_desde"]." 00:00'";
			}
			
			if(!empty($array["fecha_de_expiracion_hasta"])){
				
				$sql .= " AND 	fecha_de_expiracion <= '".$array["fecha_de_expiracion_hasta"]." 23:59'";
			}

		}
		
		$query = $this->db->query($sql,$datos);	
		return $query->result();
	
	}
	
	function get_usuario_by_id($campos,$id){
	
		$sql = "SELECT 	".$campos."
FROM		locales_usuario
WHERE 	iIdUsuario = ".$id;
		
		$query = $this->db->query($sql);	
		return $query->result_array();
		
	}
	
	function buscar_log_all($array=array()){
		
		$datos 			= array();
		
		$sql = "
SELECT
us.nombre,us.apellidos,us.dni
,tu.vNombre tipo_de_usuario
,us.usuario,lg.vIp
,ev.vNombre evento
,us.eEstado estado
,DATE_FORMAT(dFecha_Log,'%d/%m/%Y')dFecha_Log,iIdFormulario
,DATE_FORMAT(dFecha_Log,'%r')hora_log
FROM 		locales_log lg
INNER JOIN locales_usuario us ON lg.iIdUsuario = us.iIdUsuario
INNER JOIN locales_tipo_de_usuario tu ON us.tipo_de_usuario = tu.tipo_de_usuario
INNER JOIN locales_evento ev ON lg.iIdEvento = ev.iIdEvento
WHERE 1 = 1 ";
		
		if(!empty($array["nombre"])){
			$sql .= " AND 	CONCAT(us.nombre,' ',us.apellidos) like ?";
			array_push($datos,"%".$array["nombre"]."%");
		}
		
		if(!empty($array["usuario"])){			
			$sql .= " AND 	us.usuario like ?";
			array_push($datos,"%".$array["usuario"]."%");
		}
		
		if(!empty($array["dni"])){			
			$sql .= " AND 	us.dni like ?";
			array_push($datos,"%".$array["dni"]."%");
		}
		
		if(!empty($array["iIdEvento"])){
			$sql .= " AND 	lg.iIdEvento = ?";
			array_push($datos,$array["iIdEvento"]);
		}
		
		$sql .= " ORDER BY 	iIdLog DESC ";

		$query = $this->db->query($sql,$datos);	
		return $query->result();
	
	}
	
	function get_evento(){
		$this->db->select('iIdEvento id, vNombre');
		$this->db->where('eEstado', 1);
		$this->db->order_by('vNombre', 'asc');
		$query = $this->db->get('locales_evento');
		return $query->result();
	}
	
	function get_modulo(){
		$this->db->select('iIdModulo id, vNombre');
		$this->db->where('eEstado', 1);
		$this->db->order_by('vNombre', 'asc');
		$query = $this->db->get('locales_modulo');
		return $query->result();
	}
	
	function get_submodulo($id){
	
		$sql = "SELECT  iIdSubModulo id,vNombre 
FROM	locales_submodulo
WHERE 	iIdModulo =".$id;

		$sql .= " ORDER BY iIdSubModulo";
	
		$query = $this->db->query($sql);
		return $query->result();
		
	}
	
	function get_detallesubmodulo($id){
	
		$sql = "SELECT  iIdDetalleSubModulo id,vNombre 
FROM	locales_detallesubmodulo
WHERE 	iIdSubModulo =".$id;

		$sql .= " ORDER BY iIdDetalleSubModulo";
	
		$query = $this->db->query($sql);
		return $query->result();
		
	}
	
	function get_opciones(){
		$this->db->select('iIdOpciones id, vNombre');
		$this->db->where('eEstado', 1);
		$this->db->order_by('iIdOpciones', 'asc');
		$query = $this->db->get('locales_opciones');
		return $query->result();
	}
	
	function buscar_permiso_all($array=array()){
		
		$datos 			= array();
		
		$sql = "
SELECT
iIdSubModulo
,mo.vDescripcion modulo
,smo.vNombre submodulo
,(SELECT 	GROUP_CONCAT(IFNULL(pe.iPermiso,0) SEPARATOR ',')
FROM 		locales_opciones op
LEFT JOIN	locales_permiso pe ON pe.iIdOpciones = op.iIdOpciones 
WHERE iIdUsuario = ".$array['iIdUsuario']."
AND		iIdSubModulo = smo.iIdSubModulo
)permiso
FROM 		locales_modulo mo
INNER JOIN locales_submodulo smo ON mo.iIdModulo = smo.iIdModulo
WHERE 1 = 1 ";
		
		$sql .= " ORDER BY mo.iIdModulo,smo.iIdSubModulo";
		
		$query = $this->db->query($sql,$datos);	
		return $query->result();
	
	}
	
	function get_by_codigo_usuario_x_nombre($codigo){
		$sql="";
		$sql="SELECT 	iIdUsuario,CONCAT(nombre,' ',apellidos) nombre
FROM 		locales_usuario
Where 		eEstado = 1 
and 		CONCAT(nombre,' ',apellidos) like '%".$codigo."%'";
		$query = $this->db->query($sql);	
		return $query->result();
	}
	
	function get_by_codigo_usuario_x_dni($codigo){
		$sql="";
		$sql="SELECT 	iIdUsuario,dni
FROM 		locales_usuario
Where 		eEstado = 1 
and 		dni like '%".$codigo."%'";
		$query = $this->db->query($sql);	
		return $query->result();
	}
	
	function get_by_codigo_usuario_x_usuario($codigo){
		$sql="";
		$sql="SELECT 	iIdUsuario,usuario
FROM 		locales_usuario
Where 		eEstado = 1 
and 		usuario like '%".$codigo."%'";
		$query = $this->db->query($sql);	
		return $query->result();
	}
	
	function save_permiso($id,$detalle,$sub_detalle){
		
		$this->db->where('iIdUsuario',$id);
		$this->db->delete('locales_permiso');
		
		foreach($detalle as $key=>$row):
			
			if(isset($sub_detalle[$key])):
			foreach($sub_detalle[$key] as $key_sub_detalle=>$row_sub_detalle):
			
				$data = array(
					'iIdUsuario' 	=> $id,
					'iIdSubModulo'	=> $row['iIdSubModulo'],
					'iIdOpciones'	=> $row_sub_detalle['iIdOpciones'],
					'iPermiso'		=> $row_sub_detalle['iPermiso']
				);	
						
				$this->db->insert('locales_permiso', $data);
			
			endforeach;
			endif;
			
		endforeach;
		/*
		$this->db->where('iIdUsuario',$id);
		$this->db->delete('locales_permisocampo');
		
		$detalleformulario = $this->get_detalleformulario_by_idformulario(1);
		
		foreach($detalleformulario as $key => $row_detalleformulario):
			$data2 = array(
					'iIdUsuario' 			=> $id,
					'iIdDetalleFormulario'	=> $row_detalleformulario->iIdDetalleFormulario,
					'iPermiso'				=> 1
				);	
						
			$this->db->insert('locales_permisocampo', $data2);
		endforeach;
		*/
		return TRUE;
	}
	
	function get_permiso_modulo($id){
	
		$sql = "SELECT 	DISTINCT sm.iIdModulo,mo.vNombre modulo
FROM		locales_permiso pe
INNER JOIN locales_submodulo sm ON pe.iIdSubModulo = sm.iIdSubModulo
INNER JOIN locales_modulo mo ON sm.iIdModulo = mo.iIdModulo
WHERE		iIdUsuario = ".$id."
AND			iPermiso = 1";
	
		$query = $this->db->query($sql);	
		return $query->result();
		
	}
	
	function get_detalleformulario_fecha_by_idformulario($iIdFormulario){
	
		$sql = "SELECT 	
iIdDetalleFormulario id
,vNombre
,REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(vNombre,' ','_'),'á','a'),'é','e'),'í','i'),'ó','o'),'ú','u'),'(',''),')',''),'/',''),'ñ','n'),':',''),'Á','a'),'É','e'),'Í','i'),'Ó','o'),'Ú','u') as campo
FROM 		locales_detalleformulario
WHERE 		iIdTipoCampo = 6
AND			iIdFormulario = ".$iIdFormulario."
AND			eEstado = 1";
		
		$sql = utf8_encode($sql);
		$query = $this->db->query($sql);
		return $query->result();	
	
	}
	
	function get_area(){
		$this->db->select('area id, vNombre');
		$this->db->where('eEstado', 1);
		$this->db->order_by('vNombre', 'asc');
		$query = $this->db->get('locales_area');
		return $query->result();
	}
	
	function get_tipo_de_usuario(){
		$this->db->select('tipo_de_usuario id, vNombre');
		$this->db->where('eEstado', 1);
		$this->db->order_by('vNombre', 'asc');
		$query = $this->db->get('locales_tipo_de_usuario');
		return $query->result();
	}
	
	function get_vNombre_tabla_by_id($campo,$id){
		
		$sql = "SELECT 	/*CONCAT(vCodigo,' - ',vNombre)*/ vNombre,vCodigo
FROM 		locales_".$campo."
WHERE		".$campo." = ".$id;

		$sql = utf8_encode($sql);	
		$query = $this->db->query($sql);
		return $query->row('vNombre');
		
	}
	
	function save_permisocampo($id,$detalle){
		
		$this->db->where('iIdUsuario',$id);
		$this->db->delete('locales_permisocampo');
		
		foreach($detalle as $key=>$row):
			$data = array(
				'iIdUsuario' 			=> $id,
				'iIdDetalleFormulario'	=> $row['iIdDetalleFormulario'],
				'iPermiso'				=> $row['iPermiso']
			);	
					
			$this->db->insert('locales_permisocampo', $data);			
		endforeach;
		
		return TRUE;
	}
	
	function get_permisocampo_by_idusuario($id){
	
		$sql = "SELECT 	iIdDetalleFormulario,iPermiso
FROM		locales_permisocampo
WHERE 		iIdUsuario = ".$id;
		
		$query = $this->db->query($sql);	
		return $query->row();
		
	}

	function get_permisocampo_by_idformulario_idusuario($iIdFormulario,$iIdUsuario){
		$sql = "SELECT
		df.iIdDetalleFormulario		
		,vNombre
		,REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(vNombre,' ','_'),'-',''),'ñ','n'),'á','a'),'é','e'),'í','i'),'ó','o'),'ú','u') as campo
		,IFNULL(iPermiso,0)iPermiso
		FROM 		locales_detalleformulario df
		LEFT JOIN	locales_permisocampo pc ON df.iIdDetalleFormulario = pc.iIdDetalleFormulario AND iIdUsuario = ".$iIdUsuario."
		WHERE		(iIdFormulario = 2 or iIdFormulario = ".$iIdFormulario.")
		AND			df.eEstado = 1
		ORDER BY iOrden";

		$sql = utf8_encode($sql);	
		$query = $this->db->query($sql);
		return $query->result();
		
	}
	
	function validar_detalle_submodulo($iIdSubModulo,$iIdOpciones){
		$sql="";
		$sql="SELECT 	iIdDetalleSubModulo
FROM 		locales_detallesubmodulo
WHERE		iIdSubModulo = ".$iIdSubModulo."
AND			iIdOpciones = ".$iIdOpciones;
		$query = $this->db->query($sql);
		if($query->num_rows() > 0):
			return $query->row('iIdDetalleSubModulo');
		endif;
	}
	
	function get_permisos_opciones($iIdUsuario,$iIdSubModulo){
	
		$sql = "SELECT 	GROUP_CONCAT(iIdOpciones SEPARATOR ',') opciones
		FROM 		locales_permiso
		WHERE 		iIdUsuario = ".$iIdUsuario."
		AND			iIdSubModulo = ".$iIdSubModulo."
		AND			iPermiso = 1";
			
		$query = $this->db->query($sql);
		return $query->row('opciones');
		
	}
	
	
}
?>