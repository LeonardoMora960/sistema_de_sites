<?php

class Formulario_fase_tres_model extends CI_Model
{
    private $table = 'locales_formulario_fase_tres';

    public function getAllTipoDos($locales_formulario = 0) {
        $this->db->select('id, nombre, estatus');
        $this->db->where('locales_formulario', $locales_formulario);
        $this->db->order_by('estatus', 'asc');
        $this->db->order_by('id', 'asc');
        $query = $this->db->get($this->table);
        return $query->result();
    }

    public function getAllTipoDosActivo($locales_formulario = 0) {
        $this->db->select('id, nombre, estatus');
        $this->db->where('locales_formulario', $locales_formulario);
        $this->db->where('estatus', 'activo');
        $this->db->order_by('id', 'asc');
        $query = $this->db->get($this->table);
        return $query->result();
    }

    public function saveFaseTres($data = []) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function updateFaseTres($id = 0, $data = []) {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    public function deleteFaseTres($id = 0) {
        $this->db->where('id', $id);
        return $this->db->update($this->table, ['estatus' => 'eliminado']);
    }

    public function restoreFaseTres($id = 0) {
        $this->db->where('id', $id);
        return $this->db->update($this->table, ['estatus' => 'activo']);
    }
}
