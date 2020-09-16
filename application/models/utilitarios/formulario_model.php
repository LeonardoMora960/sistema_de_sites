<?php

class Formulario_model extends CI_Model
{
	private $table = 'locales_detalleformulario';

	function get_formulario(){
		$this->db->select('iIdFormulario id,vNombre');
		$this->db->where('eEstado', 1);
		$this->db->order_by('iIdFormulario', 'asc');
		$query = $this->db->get('locales_formulario');
		return $query->result();
	}
	
	function get_tipocampo(){
		$this->db->select('iIdTipoCampo id,vNombre');
		$this->db->where('eEstado', 1);
		$this->db->order_by('vNombre', 'asc');
		$query = $this->db->get('locales_tipocampo');
		return $query->result();
	}
	
	public function buscar_detalleformulario_all($array = [])
	{
		$datos = [];

		$sql = '
			SELECT
			iIdDetalleFormulario, fo.vNombre formulario, dfo.vNombre, tc.vNombre tipocampo,
			cObligatorio, cNumerico, dfo.eEstado, dfo.iIdFormulario,dfo.iIdTipoCampo, dfo.iOrden, dfo.alert_expiration,
			dfo.locales_formulario_fase, dfo.locales_formulario_fase_id
			FROM locales_detalleformulario dfo
			INNER JOIN locales_formulario fo ON dfo.iIdFormulario = fo.iIdFormulario
			INNER JOIN locales_tipocampo tc ON dfo.iIdTipoCampo = tc.iIdTipoCampo
			WHERE 1 = 1';

		if (!empty($array['iIdFormulario'])) {
			$sql .= ' AND dfo.iIdFormulario = ?';
			array_push($datos, $array['iIdFormulario']);
		}

		if (!empty($array['vNombreBusqueda'])) {
			$sql .= ' AND dfo.vNombre like ?';
			array_push($datos, '%' . $array['vNombreBusqueda'] . '%');
		}

		if (!empty($array['fase'])) {
			$sql .= ' AND dfo.locales_formulario_fase = ?';
			array_push($datos, $array['fase']);
		}

		if (!empty($array['fase_id'])) {
			$sql .= ' AND dfo.locales_formulario_fase_id = ?';
			array_push($datos, $array['fase_id']);
		}

		$query = $this->db->query($sql, $datos);
		return $query->result();
	}
	
	function save_detalleformulario($data){
		$this->db->insert('locales_detalleformulario', $data);
		return $this->db->insert_id();
	}

	public function update_detalleformulario($id = 0, $data = [], $where = 'iIdDetalleFormulario')
	{
		$this->db->where($where, $id);
		return $this->db->update($this->table, $data);
	}

	public function get_campo_detalleformulario($iIdDetalleFormulario = 0)
	{
		$sql = "SELECT
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
																				vNombre, '-', '_'
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
		) as campo,
		iIdTipoCampo, locales_formulario_fase, locales_formulario_fase_id
		FROM locales_detalleformulario
		WHERE iIdDetalleFormulario = " . $iIdDetalleFormulario;
		$sql = utf8_encode($sql);
		$query = $this->db->query($sql);
		return $query->row();
	}

	public function nuevoIdColumnLocal()
	{
		$sql = "SELECT max(iIdDetalleFormulario) + 1 as total FROM locales_detalleformulario;";
		$query = $this->db->query($sql);
		return $query->row()->total;
	}

	/**
	1 = No hay cambios
	2 = Existe la columna
	3 = Exito
	*/
	public function add_alter_column($bandera, $tabla, $campo1, $tipodato1, $campo2, $tipodato2)
	{
		if ($campo1 != $campo2) {
			if (
				$this->db->field_exists($campo1, 'locales_local')
			) {
				return 2;
			}
		} elseif($campo1 == $campo2 && $tipodato1 == $tipodato2) {
			return 1;
		}

		$tipo = 'VARCHAR(60)';
		$nom_tabla = '';
		
		if ($tabla == 1 || $tabla == 2) $nom_tabla = 'locales_local';
		if ($tabla == 3) $nom_tabla = 'locales_usuario';
		
		if ($bandera == 1):
			$sql = 'ALTER TABLE ' . $nom_tabla . ' ADD ' . $campo1 . ' ' . $tipo;
			$query = $this->db->query($sql);

			if (($tipodato1 == 3 || $tipodato1 == 4 || $tipodato1 == 5)):
				$sql2 = "
				CREATE TABLE `locales_" . $campo1 . "` (
				  `".$campo1."` int(11) unsigned NOT NULL AUTO_INCREMENT,
				  `vNombre` varchar(60) DEFAULT NULL,
				  `vCodigo` varchar(60) DEFAULT NULL,
				  `eEstado` enum('activo','inactivo','eliminado') NOT NULL DEFAULT 'activo',
				  PRIMARY KEY (`" . $campo1 . "`)
				) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";
				$query2 = $this->db->query($sql2);
			endif;
		endif;

		if ($bandera == 2):
			if ($campo1 != $campo2) {
				$sql = 'ALTER TABLE ' . $nom_tabla . ' CHANGE COLUMN ' . $campo2 . ' ' . $campo1 . ' ' . $tipo;
				$query = $this->db->query($sql);
			}
			if (
				$tipodato1 != $tipodato2 &&
				($tipodato1 == 3 || $tipodato1 == 4 || $tipodato1 == 5) &&
				$this->db->table_exists('locales_' . $campo1)
			):
				$sql = 'DROP TABLE locales_' . $campo1 . ';';
				$query = $this->db->query($sql);
			endif;
			
			if (
				$tipodato1 != $tipodato2 &&
				($tipodato2 == 3 || $tipodato2 == 4 || $tipodato2 == 5) &&
				$this->db->table_exists('locales_' . $campo2)
			):
				$sql = 'DROP TABLE locales_' . $campo2 . ';';
				$query = $this->db->query($sql);
			endif;

			if (
				($tipodato2 != 3 && $tipodato2 != 4 && $tipodato2 != 5) &&
				$tipodato1 != $tipodato2 &&
				($tipodato1 == 3 || $tipodato1 == 4 || $tipodato1 == 5) &&
				$this->db->table_exists('locales_' . $campo2)
			):
				$sql = 'DROP TABLE locales_' . $campo2 . ';';
				$query = $this->db->query($sql);
			endif;

			if (
				($tipodato1 == 3 || $tipodato1 == 4 || $tipodato1 == 5) &&
				!$this->db->table_exists('locales_' . $campo1)
			):
				$sql2 = "
				CREATE TABLE `locales_" . $campo1 . "` (
				  `".$campo1."` int(11) unsigned NOT NULL AUTO_INCREMENT,
				  `vNombre` varchar(60) DEFAULT NULL,
				  `vCodigo` varchar(60) DEFAULT NULL,
				  `eEstado` enum('activo','inactivo','eliminado') NOT NULL DEFAULT 'activo',
				  PRIMARY KEY (`" . $campo1 . "`)
				) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";
				$query2 = $this->db->query($sql2);
			endif;

			if (
				($tipodato2 == 3 || $tipodato2 == 4 || $tipodato2 == 5) &&
				$tipodato1 != $tipodato2 &&
				($tipodato1 == 3 || $tipodato1 == 4 || $tipodato1 == 5) &&
				!$this->db->table_exists('locales_' . $campo2)
			):
					$sql2 = "
					CREATE TABLE `locales_" . $campo2 . "` (
					  `".$campo2."` int(11) unsigned NOT NULL AUTO_INCREMENT,
					  `vNombre` varchar(60) DEFAULT NULL,
					  `vCodigo` varchar(60) DEFAULT NULL,
					  `eEstado` enum('activo','inactivo','eliminado') NOT NULL DEFAULT 'activo',
					  PRIMARY KEY (`" . $campo2 . "`)
					) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";
					$query2 = $this->db->query($sql2);
			endif;

			if (($tipodato1 == 3 || $tipodato1 == 4 || $tipodato1 == 5) && $campo1 != $campo2):
				$sql2 = 'ALTER TABLE locales_' . $campo1 . ' RENAME locales_' . $campo2;
				$query2 = $this->db->query($sql2);
			endif;
		endif;

		return 3;
	}

	public function get_detalleformulario_select()
	{
	
		$sql = "SELECT 	iIdDetalleFormulario id,vNombre
FROM 		locales_detalleformulario
WHERE 		(iIdTipoCampo = 3 OR iIdTipoCampo = 4 OR iIdTipoCampo = 5)
AND			eEstado = 1
AND			locales_formulario_fase = 3";
		
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function buscar_tabla_all($array=array())
	{
		if (!$this->db->table_exists('locales_' . $array['tabla'])) {
			return false;
		}
		$sql = "
		SELECT 	".$array['tabla']." id,vNombre,vCodigo,eEstado
		FROM 		locales_".$array['tabla']."
		WHERE 	1 = 1 
		AND		eEstado <> 3";
		
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function buscar_categoria_all($array=array())
	{
		if (!$this->db->table_exists('locales_fase_3_fase_id_2_categoria')) {
			return false;
		}
		$sql = "
		SELECT 	fase_3_fase_id_2_categoria id,vNombre,eEstado
		FROM 		locales_fase_3_fase_id_2_categoria
		WHERE 	1 = 1 
		AND		eEstado <> 3";
		$query = $this->db->query($sql);
		return $query->result();
	}

	function save_tabla($data,$tabla){
		$this->db->insert($tabla, $data);
		return $this->db->insert_id();		
	}
	
	function update_tabla($id,$data,$tabla,$id_key){
		$this->db->where($id_key, $id);
		return $this->db->update($tabla, $data);
	}
	
	function save_categoria($data){
		$this->db->insert('locales_fase_3_fase_id_2_categoria', $data);
		return $this->db->insert_id();		
	}
	
	function update_categoria($id,$data){
		$this->db->where('fase_3_fase_id_2_categoria', $id);
		return $this->db->update('locales_fase_3_fase_id_2_categoria', $data);
	}
	
	
	function get_detalleformulario_id_limit(){
	
		$sql = "SELECT 	iIdDetalleFormulario
		FROM 		locales_detalleformulario
		WHERE 	iIdTipoCampo = 3
		AND		eEstado = 1
		AND		locales_formulario_fase = 3
		LIMIT 1";
		
		$query = $this->db->query($sql);

		$result = $query->row('iIdDetalleFormulario');
		return empty($result) ? 0: $result;
	}
	
	function get_detalleformulario_by_id($id)
	{
		$sql = "SELECT 	vNombre,iIdFormulario,cObligatorio,iOrden
		FROM 		locales_detalleformulario
		WHERE 	(iIdTipoCampo = 3 OR iIdTipoCampo = 4 OR iIdTipoCampo = 5)
		AND		eEstado = 1
		AND		iIdDetalleFormulario = ".$id;
		
		$query = $this->db->query($sql);
		return $query->row('iIdDetalleFormulario');
	
	}
	
	function update_registro($informacion,$data){		
		$this->db->where($informacion['condicion'], $informacion['valor']);
		return $this->db->update($informacion['table'], $data);	
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
	
	function get_datos_local($codigo='',$NombreOriginal){
	
		$sql = "SELECT 	iIdLocal,nombre_de_local
FROM 		locales_local
WHERE		codigo_de_local = '".$codigo."'
AND			eEstado = 1
AND 		NOT EXISTS (SELECT vDocumento FROM locales_detalledocumento WHERE vDocumento = '".$NombreOriginal."' and eEstado = 1)";
	
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0):
			return $query->row();
		endif;
	}
	
	function save_detalledocumento_masivo($iIdCategoria,$detalle){
		
		foreach($detalle as $row){
		
			$data = array(
				'iIdCategoria'		=> $iIdCategoria,
			   	'iIdLocal'			=> $row['iIdLocal'],
			   	'vDocumento' 		=> $row['vDocumento'],
			   	'codigo_de_local'	=> $row['codigo_de_local'],
			);			
			$this->db->insert('locales_detalledocumento', $data);
		}
		return TRUE;
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