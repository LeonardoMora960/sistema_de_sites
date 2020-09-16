<?php

class Formulario_fase_dos_model extends CI_Model
{
    private $table = 'locales_formulario_fase_dos';

    public function getAllTipoUno($locales_formulario = 0) {
        $this->db->select('id, nombre, estatus');
        $this->db->where('locales_formulario', $locales_formulario);
        $this->db->order_by('estatus', 'asc');
        $this->db->order_by('id', 'asc');
        $query = $this->db->get($this->table);
        return $query->result();
    }

    public function getAllTipoUnoActivo($locales_formulario = 0) {
        $sql = '
            SELECT
            lffd.id, lffd.nombre, lffd.estatus,
            lfft.id AS id_fase_tres, lfft.nombre AS nombre_fase_tres, lfft.estatus AS estatus_fase_tres
            FROM locales_formulario_fase_dos AS lffd
            LEFT JOIN locales_formulario_fase_tres AS lfft ON lfft.locales_formulario = lffd.id
            WHERE lffd.locales_formulario = ? AND lffd.estatus = ? AND lfft.estatus = ?
            ORDER BY lffd.id ASC, lfft.id ASC;
        ';
        $parameters = [
            $locales_formulario,
            'activo',
            'activo',
        ];
        $query = $this->db->query($sql, $parameters);
        return $query->result();
    }

    public function saveFaseDos($data = []) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function updateFaseDos($id = 0, $data = []) {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    public function deleteFaseDos($id = 0) {
        $this->db->where('id', $id);
        return $this->db->update($this->table, ['estatus' => 'eliminado']);
    }

    public function restoreFaseDos($id = 0) {
        $this->db->where('id', $id);
        return $this->db->update($this->table, ['estatus' => 'activo']);
    }
}
