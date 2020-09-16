<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Process_model extends CI_Model{
	public function ingresar($mail, $pass){
		$sql = $this->db->get_where('locales_usuario', array('usuario'=>$mail,'contrasena'=>$pass,'eEstado'=>1));
		return $sql->num_rows();
	}
	
	public function recoverkey($mail){
		$sql = $this->db->get_where('locales_usuario', array('usuario'=>$mail));
		return $sql->num_rows();
	}
	
	function get_datos_usuario($mail){
		$this->db->select('iIdUsuario,usuario,nombre,apellidos');
		$this->db->from('locales_usuario');
		$this->db->where('usuario', $mail);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0){
			return $query->row();
		}
	}
	
	function get_management($data){
		
		$this->db->select('iIdUsuario,usuario,nombre,apellidos');
		$this->db->from('locales_usuario us');
		$this->db->where('usuario', $data['usuario']);
		$this->db->where('contrasena', $data['contrasena']);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0)
		{
			//return TRUE;
			return $query->result();
			
		}
	}
	
	function save_log($data){
		$this->db->insert('locales_log', $data);
		return $this->db->insert_id();	
	}
	
	function get_permiso_submodulo($iIdUsuario,$iIdModulo){
	
		$sql = "SELECT 	sm.iIdSubModulo,sm.vDescripcion submodulo
		,GROUP_CONCAT(iIdOpciones ORDER BY pe.iIdPermiso SEPARATOR ',')opciones
		,vRutaPag
		FROM		locales_permiso pe
		INNER JOIN locales_submodulo sm ON pe.iIdSubModulo = sm.iIdSubModulo
		INNER JOIN locales_modulo mo ON sm.iIdModulo = mo.iIdModulo
		WHERE		iIdUsuario = ".$iIdUsuario."
		AND			mo.iIdModulo = ".$iIdModulo."
		AND			iPermiso = 1 AND sm.eEstado = 1
		AND			sm.iIdSubModulo NOT IN (13,14,15,17)
		GROUP BY sm.iIdSubModulo
		ORDER BY sm.vNombre";
	
		$query = $this->db->query($sql);
		return $query->result();
		
	}
	
	function update_usuario($id, $data){
		$this->db->where('iIdUsuario', $id);
		return $this->db->update('locales_usuario', $data);
	}
	
	
}
?>