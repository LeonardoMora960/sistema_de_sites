<?php

class Formulario_fase_cuatro_model extends CI_Model
{
    private $table = 'locales_formulario_fase_cuatro';

    public function getAllTipoTres($locales_formulario = 0) {
        $this->db->select('id, nombre, estatus');
        $this->db->where('locales_formulario', $locales_formulario);
        $this->db->order_by('estatus', 'asc');
        $this->db->order_by('id', 'asc');
        $query = $this->db->get($this->table);
        return $query->result();
    }

    public function getAllTipoTresActivo($locales_formulario = 0) {
        $this->db->select('id, nombre, estatus');
        $this->db->where('locales_formulario', $locales_formulario);
        $this->db->where('estatus', 'activo');
        $this->db->order_by('id', 'asc');
        $query = $this->db->get($this->table);
        return $query->result();
    }

    public function saveFaseCuatro($data = []) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function updateFaseCuatro($id = 0, $data = []) {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    public function deleteFaseCuatro($id = 0) {
        $this->db->where('id', $id);
        return $this->db->update($this->table, ['estatus' => 'eliminado']);
    }

    public function restoreFaseCuatro($id = 0) {
        $this->db->where('id', $id);
        return $this->db->update($this->table, ['estatus' => 'activo']);
    }
}
