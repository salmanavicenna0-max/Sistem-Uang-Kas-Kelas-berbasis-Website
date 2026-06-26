<?php

class Kategori {
    private $table = 'kategori';
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getAllKategori() {
        $this->db->query('SELECT * FROM ' . $this->table . ' ORDER BY nama ASC');
        return $this->db->resultSet();
    }

    public function getKategoriById($id) {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE id=:id');
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function tambahDataKategori($data) {
        $query = "INSERT INTO kategori (nama, deskripsi) VALUES (:nama, :deskripsi)";
        $this->db->query($query);
        $this->db->bind('nama', $data['nama']);
        $this->db->bind('deskripsi', $data['deskripsi']);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function editDataKategori($data) {
        $query = "UPDATE kategori SET nama=:nama, deskripsi=:deskripsi WHERE id=:id";
        $this->db->query($query);
        $this->db->bind('id', $data['id']);
        $this->db->bind('nama', $data['nama']);
        $this->db->bind('deskripsi', $data['deskripsi']);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function hapusDataKategori($id) {
        $query = "DELETE FROM kategori WHERE id=:id";
        $this->db->query($query);
        $this->db->bind('id', $id);
        $this->db->execute();
        return $this->db->rowCount();
    }
}
