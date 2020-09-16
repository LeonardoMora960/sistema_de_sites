<?php
class Registro_model extends CI_Model{
	
	function get_detalleformulario_by_idformulario($iIdFormulario){
		
		$sql = "SELECT 	
vNombre
,REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(vNombre,' ','_'),'.', '_'),'á','a'),'é','e'),'í','i'),'ó','o'),'ú','u'),'(',''),')',''),'/',''),'ñ','n'),':',''),'Á','a'),'É','e'),'Í','i'),'Ó','o'),'Ú','u') as campo
,iIdTipoCampo
,cObligatorio
,cNumerico
,alert_expiration
,locales_formulario_fase_id
,locales_formulario_fase
FROM 		locales_detalleformulario
WHERE		iIdFormulario = ".$iIdFormulario."
AND			eEstado = 1
ORDER BY iOrden";
		$sql = utf8_encode($sql);	
		$query = $this->db->query($sql);
		return $query->result();
		
	}
	
	public function get_tabla($campo)
	{
		$campo = str_replace('fase__fase_id__', '', $campo);
		//echo 'faysor1: ' . $campo;
		//$sql = 'SELECT ' . $campo . ' id, /*CONCAT(vCodigo, ' - ', vNombre)*/ vNombre, vCodigo
		//	FROM  locales_' . $campo;
		//echo 'faysor: ' . $sql;
		$sql = "select $campo id, vNombre, vCodigo from locales_$campo where eEstado = 1;";
		$sql = utf8_encode($sql);
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function get_vNombre_tabla_by_id($campo,$id){
		
		$sql = "SELECT vNombre, vCodigo
FROM 		locales_".$campo."
WHERE		".$campo." = ".$id;

		$sql = utf8_encode($sql);	
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0):
			return $query->row('vNombre');
		endif;
		
	}
	
	function save_local($data){
		$this->db->insert('locales_local', $data);
		return $this->db->insert_id();		
	}
	
	function update_local($id, $data){
		$this->db->where('iIdLocal', $id);
		return $this->db->update('locales_local', $data);
	}
	
	function buscar_local_all($array=array()){
		//Reemplazamos la A y a
		$array['campos'] = str_replace(
		array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
		array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
		$array['campos']
		);

		//Reemplazamos la E y e
		$array['campos'] = str_replace(
		array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
		array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
		$array['campos'] );

		//Reemplazamos la I y i
		$array['campos'] = str_replace(
		array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
		array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
		$array['campos'] );

		//Reemplazamos la O y o
		$array['campos'] = str_replace(
		array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
		array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
		$array['campos'] );

		//Reemplazamos la U y u
		$array['campos'] = str_replace(
		array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
		array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
		$array['campos'] );

		//Reemplazamos la N, n, C y c
		$array['campos'] = str_replace(
		array('Ñ', 'ñ', 'Ç', 'ç'),
		array('N', 'n', 'C', 'c'),
		$array['campos']
		);		

		$datos 			= array();
		
		$sql = "
SELECT
".$array['campos']."
FROM 		locales_local lo
WHERE 1 = 1 ";
		
		/*
		if(!empty($array["codigo_de_local"])){
			$sql .= " AND 	codigo_de_local like ?";
			array_push($datos,"%".$array["codigo_de_local"]."%");
		}
		
		if(!empty($array["nombre_de_local"])){	
			$sql .= " AND 	nombre_de_local like ?";
			array_push($datos,"%".$array["nombre_de_local"]."%");
		}
		*/
		
		$array_campos = explode(',',$array['campos']);
		unset($array_campos["departamento"]);
		unset($array_campos["provincia"]);
		unset($array_campos["distrito"]);
		foreach($array_campos as $row):
			if(!empty($array[$row])){	
				$sql .= " AND 	".$row." like ?";
				array_push($datos,"%".$array[$row]."%");
			}	
		endforeach;
		
		if(!empty($array["departamento"])){
			$sql .= " AND 	departamento = ?";
			array_push($datos,$array["departamento"]);
		}
		
		if(!empty($array["provincia"])){
			$sql .= " AND 	provincia = ?";
			array_push($datos,$array["provincia"]);
		}
		
		if(!empty($array["distrito"])){
			$sql .= " AND 	distrito = ?";
			array_push($datos,$array["distrito"]);
		}
		
		if(!empty($array["iIdCategoria"])){
			$sql .= " AND 	iIdLocal IN(
										SELECT 	iIdLocal 
										FROM 		locales_detalledocumento
										WHERE		iIdCategoria = ".$array["iIdCategoria"]."
										)";
		}
		
		if(!empty($array["cDocumento"])){
			$sql .= " AND 	EXISTS (SELECT iIdDetalleDocumento FROM locales_detalledocumento WHERE codigo_de_local = lo.codigo_de_local)";
		}
		
		if(!empty($array["cImagen"])){
			$sql .= " AND 	EXISTS (SELECT iIdDetalleImagen FROM locales_detalleimagen WHERE iIdLocal = lo.iIdLocal)";
		}
		
		if(!empty($array["cUbicacion"])){
			$sql .= " AND 	latitud != '' AND longitud != ''";
		}
		
		$sql .= " ORDER BY ".$array['campo']." DESC"; 
		
		$query = $this->db->query($sql,$datos);	
		return $query->result();
	}
	
	function save_detalleimagen($id,$detalle){
		
		$this->db->where('iIdLocal',$id);
		$this->db->where('eEstado', 1);
		$this->db->delete('locales_detalleimagen');
		
		foreach($detalle as $row){
		
			$data = array(
			   'iIdLocal'		=> $id,
			   'vDescripcion' 	=> $row['vDescripcion'],
			   'vimagen'		=> $row['vimagen']
			);
			$this->db->insert('locales_detalleimagen', $data);
		}
		return TRUE;
	}
	
	function get_by_detalle_imagen($id){
	
		$sql = "SELECT 	iIdDetalleImagen,vDescripcion,vimagen
FROM		locales_detalleimagen
WHERE		eEstado <> 3
AND			iIdLocal = ".$id;
		
		$query = $this->db->query($sql);
		return $query->result();				
	
	}
	
	function get_categoria()
	{
		if (!$this->db->table_exists('locales_fase_3_fase_id_2_categoria')) {
			return false;
		}
		$this->db->select('fase_3_fase_id_2_categoria id, vNombre');
		$this->db->where('eEstado', 1);
		$this->db->order_by('vNombre', 'asc');
		$query = $this->db->get('locales_fase_3_fase_id_2_categoria');
		return $query->result();
	}
	
	function getAlertFieldsByIdFormulario($id_local, $id_formulario)
	{
		if (!$this->db->table_exists('alert_fields')) {
			return false;
		}
		
		$this->db->select('*');
		$this->db->where('alert_id_local', $id_local);
		$this->db->where('alert_id_formulario', $id_formulario);
		$query = $this->db->get('alert_fields');
		return $query->result();
	}
	
	function editAlarm($data)
	{
		$this->db->where('alert_id', $data['alert_id']);
		return $this->db->update('alert_fields', $data);
	}
	
	
	function createAlarm($data)
	{
		$this->db->insert('alert_fields', $data);
		return $this->db->insert_id();
	}
	
	function get_alertas_campos($id)
	{
		if (!$this->db->table_exists('alert_fields')) {
			return false;
		}

		$this->db->select('*');
		$this->db->where('alert_id_local', $id);
		$query = $this->db->get('alert_fields');
		return $query->result();
	}
	
	function save_documento($data) {
		$this->db->insert('locales_documento', $data);
		return $this->db->insert_id();
	}
	
	function update_documento($id, $data){
		$this->db->where('iIdDocumento', $id);
		return $this->db->update('locales_documento', $data);
	}
    
    function eliminar_documento($id){
		$this->db->where('iIdDetalleFormulario', $id);
		$this->db->delete('locales_detalledocumento');
    }   
    
	public function save_detalledocumento($iIdLocal, $iIdCategoria, $detalle)
	{
		foreach($detalle as $row) {
			$data = [
			   'iIdLocal' => $iIdLocal,
			   'iIdCategoria' => $iIdCategoria,
			   'vDocumento' => $row['vDocumento'],
			];
			$this->db->insert('locales_detalledocumento', $data);
		}
		return true;
	}

	public function create_detalledocumento($data)
	{
		$documento_exist = $this->buscar_documento_first([
			$data['iIdDetalleFormulario'],
			$data['locales_formulario_fase'],
			$data['locales_formulario_fase_id'],
			$data['iIdLocal'],
		]);
		if (!empty($documento_exist->iIdDetalleDocumento)) {
			$this->db->where('iIdDetalleDocumento', $documento_exist->iIdDetalleDocumento);
			$this->db->update('locales_detalledocumento', $data);
			return $documento_exist->iIdDetalleDocumento;
		}
		$this->db->insert('locales_detalledocumento', $data);
		return $this->db->insert_id();
	}

	public function buscar_documento_all($array = [])
	{
		if (!$this->db->table_exists('locales_fase_3_fase_id_2_categoria')) {
			return false;
		}
		$datos 	= [];
		$sql = "
			SELECT
			cat.vNombre categoria,
			GROUP_CONCAT(iIdDetalleDocumento ORDER BY iIdDetalleDocumento SEPARATOR ',') iIdDetalleDocumento,
			GROUP_CONCAT(vDocumento ORDER BY iIdDetalleDocumento SEPARATOR ',') vDocumento
			FROM locales_detalledocumento dd
			INNER JOIN locales_fase_3_fase_id_2_categoria cat ON dd.iIdCategoria = cat.fase_3_fase_id_2_categoria
			inner join locales_local i on i.iIdLocal = dd.iIdLocal

			WHERE dd.eEstado = 1
			AND cat.eEstado = 1
			AND	i.fase_3_fase_id_2_codigo_de_local = '" . $array["codigo_de_local"] . "'";

		if(!empty($array["iIdCategoriaBusqueda"])){
			$sql .= " AND dd.iIdCategoria = ?";
			array_push($datos, $array["iIdCategoriaBusqueda"]);
		}

		$sql .= " GROUP BY dd.iIdCategoria";

		$query = $this->db->query($sql, $datos);
		return $query->result();
	}

	public function buscar_documento_first($parameters = [])
	{
	    
		$sql = "SELECT * FROM locales_detalledocumento WHERE iIdDetalleFormulario = ? AND locales_formulario_fase = ? AND locales_formulario_fase_id = ? AND iIdLocal = ?";

		$query = $this->db->query($sql, $parameters);
		return $query->row();
	}

	public function buscar_campo_first($parameters = [])
	{
		$sql = "SELECT count(locales_formulario_fase) as total FROM locales_detalleformulario WHERE eEstado = 1 AND locales_formulario_fase = ? AND locales_formulario_fase_id = ?";

		$query = $this->db->query($sql, $parameters);
		return $query->row();
	}

	public function get_by_iIdDocumento($iIdCategoria)
	{
		$sql = "
			SELECT 	iIdDocumento
			FROM locales_documento
			WHERE iIdCategoria = " . $iIdCategoria . "
			LIMIT 1";
		$query = $this->db->query($sql);
		return $query->row('iIdDocumento');
	}

	public function get_ubicacion_by_id($id)
	{
		if (!$this->db->field_exists('fase_3_fase_id_2_longitud', 'locales_local')) {
			return false;
		}
		$sql = "SELECT fase_3_fase_id_2_longitud, fase_3_fase_id_2_latitud
			FROM locales_local
			WHERE iIdLocal = ".$id;
	
		$query = $this->db->query($sql);
		return $query->row();
	}

	public function get_campo_by_id($campo, $id)
	{
		$sql = "SELECT 	".$campo." vNombre
			FROM locales_local
			WHERE iIdLocal = ".$id;
		$query = $this->db->query($sql);
		return $query->row('vNombre');
	}

	public function get_local_by_id($campo, $id)
	{
		$campo = str_replace('fase__fase_id__', '', $campo);
		$sql = 'SELECT ' . $campo . '
			FROM locales_local
			WHERE iIdLocal = ?';
		$query = $this->db->query($sql, [$id]);
		return $query->row();
	}

	public function get_permiso_modulo($id)
	{
		$sql = "SELECT 	DISTINCT sm.iIdModulo,mo.vNombre modulo
			FROM locales_permiso pe
			INNER JOIN locales_submodulo sm ON pe.iIdSubModulo = sm.iIdSubModulo
			INNER JOIN locales_modulo mo ON sm.iIdModulo = mo.iIdModulo
			WHERE iIdUsuario = ".$id."
			AND iPermiso = 1";
		$query = $this->db->query($sql);
		return $query->result();
	}

	function get_permiso_submodulo($iIdUsuario, $iIdModulo){
		$sql = "SELECT 	sm.iIdSubModulo,sm.vDescripcion submodulo
		,GROUP_CONCAT(iIdOpciones ORDER BY pe.iIdPermiso SEPARATOR ',')opciones
		,vRutaPag
		FROM		locales_permiso pe
		INNER JOIN locales_submodulo sm ON pe.iIdSubModulo = sm.iIdSubModulo
		INNER JOIN locales_modulo mo ON sm.iIdModulo = mo.iIdModulo
		WHERE		iIdUsuario = ".$iIdUsuario."
		AND			mo.iIdModulo = ".$iIdModulo."
		AND			iPermiso = 1
		AND			sm.iIdSubModulo NOT IN (13,14,15,17)
		GROUP BY sm.iIdSubModulo";
	
		$query = $this->db->query($sql);
		return $query->result();
		
	}
	
	function get_permiso_tab($iIdUsuario,$iIdModulo){
	
		$sql = "SELECT 	sm.iIdSubModulo,sm.vDescripcion submodulo
			,GROUP_CONCAT(iIdOpciones ORDER BY pe.iIdPermiso SEPARATOR ',')opciones
			,vRutaPag,vRutaImg,iIdImg
			FROM		locales_permiso pe
			INNER JOIN locales_submodulo sm ON pe.iIdSubModulo = sm.iIdSubModulo
			INNER JOIN locales_modulo mo ON sm.iIdModulo = mo.iIdModulo
			WHERE		iIdUsuario = ".$iIdUsuario."
			AND			mo.iIdModulo = ".$iIdModulo."
			AND			iPermiso = 1
			AND			sm.iIdSubModulo IN (13,14,15)
			GROUP BY sm.iIdSubModulo
			ORDER BY sm.vNombre";
	
		$query = $this->db->query($sql);
		return $query->result();
		
	}
	
	function save_detalledocumento_masivo($iIdCategoria,$detalle){
		
		foreach($detalle as $row){
		
			$data = array(
				'iIdCategoria'		=> $iIdCategoria,
			   	'iIdLocal'			=> $row['iIdLocal'],
			   	'vDocumento' 		=> $row['vDocumento'],
			   	'codigo_de_local' 	=> $row['codigo_de_local'],
			);			
			$this->db->insert('locales_detalledocumento', $data);
		}
		return TRUE;
	}	
	
	
	function get_detalleformulario_fecha_by_idformulario($iIdFormulario){
	
		$sql = "SELECT 	
iIdDetalleFormulario id, alert_expiration
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
	
	function get_departamento()
	{
		if (!$this->db->table_exists('locales_fase_3_fase_id_2_departamento')) {
			return false;
		}
		$this->db->select('fase_3_fase_id_2_departamento id,vNombre,vCodigo');
		$this->db->order_by('vNombre', 'asc');
		$query = $this->db->get('locales_fase_3_fase_id_2_departamento');
		return $query->result();
	} 
	
	function get_provincia_departamento($id)
	{
		if (!$this->db->table_exists('locales_fase_3_fase_id_2_provincia')) {
			return false;
		}
		$this->db->select('fase_3_fase_id_2_provincia id,vNombre,vCodigo');
		$this->db->where('fase_3_fase_id_2_departamento ', $id);
		$this->db->order_by('vNombre', 'asc');
		$query = $this->db->get('locales_fase_3_fase_id_2_provincia');
		return $query->result();
	}
	
	function get_distrito_provincia($id, $idDepartamento)
	{
		if (!$this->db->table_exists('locales_fase_3_fase_id_2_distrito')) {
			return false;
		}
		$this->db->select('fase_3_fase_id_2_distrito id,vNombre,vCodigo');
		$this->db->where('fase_3_fase_id_2_provincia ', $id);
		$this->db->where('fase_3_fase_id_2_departamento ', $idDepartamento);
		$this->db->order_by('vNombre', 'asc');
		$query = $this->db->get('locales_fase_3_fase_id_2_distrito');
		return $query->result();
	}

	function get_local_serie($data){
		$sql = 'CALL proc_local_serie(?,?,?)';
		$query = $this->db->query($sql,$data);
		//mysqli_next_result($this->db->conn_id);
		return $query->row('NumeroSerie');
	}
	
	function update_registro($informacion,$data){		
		$this->db->where($informacion['condicion'], $informacion['valor']);
		return $this->db->update($informacion['table'], $data);	
	}
	
	function update_detalledocumento($id, $data){
		$this->db->where('iIdDetalleDocumento', $id);
		return $this->db->update('locales_detalledocumento', $data);
	}
	
	function save_categoria($data){
		$this->db->insert('locales_fase_3_fase_id_2_categoria', $data);
		return $this->db->insert_id();		
	}
	
	function update_categoria($id, $data){
		$this->db->where('fase_3_fase_id_2_categoria', $id);
		return $this->db->update('locales_fase_3_fase_id_2_categoria', $data);
	}
	
	function get_id_tabla_by_nombre_04022015($campo,$nombre){
		
		$sql = "SELECT 	 ".$campo." id
FROM 		locales_".$campo."
WHERE		TRIM(vNombre) = '".$nombre."'";

		$sql = utf8_encode($sql);	
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0):
			return $query->row('id');
		endif;
	}
	
	function get_id_tabla_by_nombre_distrito($campo,$nombre,$provincia){
		
		$sql = "SELECT 	 ".$campo." id
FROM 		locales_".$campo."
WHERE		TRIM(vNombre) = '".$nombre."'
AND			provincia = ".$provincia;

		$sql = utf8_encode($sql);	
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0):
			return $query->row('id');
		endif;
	}
	
	function get_id_tabla_by_nombre($campo,$nombre, $relacion=null){

		if(!is_null($relacion)){
		$sql = "SELECT   ".$campo." id FROM locales_".$campo." WHERE TRIM(vNombre) = '".$nombre."' AND provincia='".$relacion."'";
		}else{
		$sql = "SELECT   ".$campo." id FROM locales_".$campo." WHERE TRIM(vNombre) = '".$nombre."'";
		}
		
		//$sql = utf8_encode($sql); 
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0):
		return $query->row('id');
		endif;
	}


	public function get_permisos_opciones($iIdUsuario, $iIdSubModulo)
	{
	
		$sql = "SELECT 	GROUP_CONCAT(iIdOpciones SEPARATOR ',') opciones
		FROM 		locales_permiso
		WHERE 		iIdUsuario = ".$iIdUsuario."
		AND			iIdSubModulo = ".$iIdSubModulo."
		AND			iPermiso = 1";

		$query = $this->db->query($sql);
		return $query->row('opciones');
	}

	 public function getAllTipoTresActivo($locales_formulario = 0) {
        $this->db->select('id, nombre, estatus');
        $this->db->where('locales_formulario', $locales_formulario);
        $this->db->where('estatus', 'activo');
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('locales_formulario_fase_cuatro');
        return $query->result();
    }

	public function getAllTipoCuatroActivo($locales_formulario = 0) {
        $this->db->select('id, nombre, estatus');
        $this->db->where('locales_formulario', $locales_formulario);
        $this->db->where('estatus', 'activo');
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('locales_formulario_fase_cinco');
        return $query->result();
    }
	
	public function get_detalleformulario_by_idformulario_idusuario($iIdUsuario = 0, $iIdFormulario = 0, $fase = 0, $fase_id = 0)
	{
		$sql = "SELECT
		df.iIdDetalleFormulario,
		REPLACE(
			REPLACE(
				REPLACE(
					REPLACE(
						REPLACE(
							REPLACE(
								REPLACE(
									REPLACE(
										REPLACE(
											REPLACE(
												REPLACE(
													REPLACE(
														REPLACE(
															REPLACE(
																REPLACE(
																	REPLACE(
																		REPLACE(
																			REPLACE(
																				df.vNombre, '-', '_'
																			), ' ', '_'
																		), 'á', 'a'
																	), '.', '_'
																),'é','e'
															),'í','i'
														),'ó','o'
													),'ú','u'
												),'(',''
											),')',''
										),'/',''
									),'ñ','n'
								),':',''
							),'Á','a'
						),'É','e'
					),'Í','i'
				),'Ó','o'
			),'Ú','u'
		) as campo, df.vNombre,
		iIdTipoCampo, cObligatorio, cNumerico, df.locales_formulario_fase, df.locales_formulario_fase_id, alert_expiration
		FROM 		locales_detalleformulario df
		INNER JOIN  locales_permisocampo pc ON df.iIdDetalleFormulario = pc.iIdDetalleFormulario
		WHERE		iIdFormulario = " . $iIdFormulario . "
		AND			iIdUsuario = " . $iIdUsuario . "
		AND			iPermiso = 1
		AND			df.eEstado = 1";
		if ($fase > 0) {
			$sql .= ' AND df.locales_formulario_fase = ' . $fase . ' AND df.locales_formulario_fase_id = ' . $fase_id;
		}
		$sql .= ' ORDER BY df.iOrden';
		$sql = utf8_encode($sql);
		$query = $this->db->query($sql);
		$query = $query->result();

		foreach ($query as $keySql => $datoSql) {

			$query[$keySql]->campo = str_replace(
			array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
			array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
			$datoSql->campo
			);

			//Reemplazamos la E y e
			$query[$keySql]->campo = str_replace(
			array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
			array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
			$datoSql->campo );

			//Reemplazamos la I y i
			$query[$keySql]->campo = str_replace(
			array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
			array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
			$datoSql->campo );

			//Reemplazamos la O y o
			$query[$keySql]->campo = str_replace(
			array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
			array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
			$datoSql->campo );

			//Reemplazamos la U y u
			$query[$keySql]->campo = str_replace(
			array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
			array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
			$datoSql->campo );

			//Reemplazamos la N, n, C y c
			$query[$keySql]->campo = str_replace(
			array('Ñ', 'ñ', 'Ç', 'ç'),
			array('N', 'n', 'C', 'c'),
			$datoSql->campo
			);
		}
		return $query;
	}

	public function faseSeccionada($id = 0, $inicial = 'dos', $final = 'tres')
	{
		$sql = "SELECT lffd.nombre as inicial, lfft.nombre as final
		FROM locales_formulario_fase_{$final} AS lfft
		LEFT JOIN locales_formulario_fase_{$inicial} AS lffd ON lffd.id = lfft.locales_formulario
		WHERE lfft.id = ?;";
		$parameters[] = $id;
		$query = $this->db->query($sql, $parameters);
		return $query->row();
	}

	function get_detalleformulario_fecha_by_idformulario_idusuario($iIdUsuario,$iIdFormulario){
	
		$sql = "SELECT 	
df.iIdDetalleFormulario id, alert_expiration
,vNombre
,REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(vNombre,' ','_'),'á','a'),'é','e'),'í','i'),'ó','o'),'ú','u'),'(',''),')',''),'/',''),'ñ','n'),':',''),'Á','a'),'É','e'),'Í','i'),'Ó','o'),'Ú','u') as campo
FROM 		locales_detalleformulario df
INNER JOIN locales_permisocampo pc ON df.iIdDetalleFormulario = pc.iIdDetalleFormulario
WHERE 		iIdTipoCampo = 6
AND			iIdFormulario = ".$iIdFormulario."
AND			iIdUsuario = ".$iIdUsuario."
AND			iPermiso = 1
AND			df.eEstado = 1";
		
		$sql = utf8_encode($sql);
		$query = $this->db->query($sql);
		return $query->result();	
	
	}
	
	function get_idlocal_by_codigo($codigo){
		
		$sql = "SELECT 	 iIdLocal
FROM 		locales_local
WHERE		TRIM(codigo_de_local) = '".$codigo."' limit 1";

		$sql = utf8_encode($sql);	
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0):
			return $query->row('iIdLocal');
		endif;
	}
	
	function delete_local(){
		//$this->db->delete('locales_local');
		$sql = "DELETE FROM locales_local";
		$query = $this->db->query($sql);
	}
	
	
	
}
?>