<?php 
class Rlocales_model extends CI_Model{
	public function campos(){
		 $this->db->order_by('orden');
		$sql = $this->db->get_where('campos', array('formulario'=>'Locales - Datos Principales', 'estado'=>1));
		return $sql->result_array();
	}
	
	public function ubigeo_cdepart(){
		$sql = $this->db->get_where('ubigeo', array('codprov'=>0, 'coddist'=>0));
		return $sql->result_array();
	}
	
	public function ubigeo_codprov($dpto){
		$sql = $this->db->get_where('ubigeo', array('coddpto'=>$dpto, 'coddist'=>0));
		return $sql->result_array();
	}
	public function ubigeo_coddist($dpto, $prov){
		$sql = $this->db->get_where('ubigeo', array('coddpto'=>$dpto, 'codprov'=>$prov));
		return $sql->result_array();
	}
}