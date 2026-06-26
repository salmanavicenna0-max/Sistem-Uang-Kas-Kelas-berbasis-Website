<?php

class Murid {
    private $table = 'murid';
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getAllMurid($keyword = '', $limit = 0, $offset = 0) {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE deleted_at IS NULL';
        
        if ($keyword) {
            $query .= ' AND (nama LIKE :keyword OR nis LIKE :keyword)';
        }
        
        $query .= ' ORDER BY nama ASC';
        
        if ($limit > 0) {
            $query .= ' LIMIT :limit OFFSET :offset';
        }
        
        $this->db->query($query);
        
        if ($keyword) {
            $this->db->bind('keyword', "%$keyword%");
        }
        if ($limit > 0) {
            $this->db->bind('limit', $limit, PDO::PARAM_INT);
            $this->db->bind('offset', $offset, PDO::PARAM_INT);
        }
        
        return $this->db->resultSet();
    }

    public function getTotalRows($keyword = '') {
        $query = 'SELECT COUNT(id) as total FROM ' . $this->table . ' WHERE deleted_at IS NULL';
        if ($keyword) {
            $query .= ' AND (nama LIKE :keyword OR nis LIKE :keyword)';
        }
        $this->db->query($query);
        if ($keyword) {
            $this->db->bind('keyword', "%$keyword%");
        }
        return $this->db->single()['total'] ?? 0;
    }

    public function getMuridById($id) {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE id=:id AND deleted_at IS NULL');
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function tambahDataMurid($data) {
        $query = "INSERT INTO murid (nama, nis, kelas, alamat, no_telp) VALUES (:nama, :nis, :kelas, :alamat, :no_telp)";
        $this->db->query($query);
        $this->db->bind('nama', htmlspecialchars($data['nama'], ENT_QUOTES, 'UTF-8'));
        $this->db->bind('nis', htmlspecialchars($data['nis'], ENT_QUOTES, 'UTF-8'));
        $this->db->bind('kelas', htmlspecialchars($data['kelas'], ENT_QUOTES, 'UTF-8'));
        $this->db->bind('alamat', htmlspecialchars($data['alamat'], ENT_QUOTES, 'UTF-8'));
        $this->db->bind('no_telp', htmlspecialchars($data['no_telp'], ENT_QUOTES, 'UTF-8'));
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function editDataMurid($data) {
        $query = "UPDATE murid SET nama=:nama, nis=:nis, kelas=:kelas, alamat=:alamat, no_telp=:no_telp WHERE id=:id";
        $this->db->query($query);
        $this->db->bind('id', $data['id']);
        $this->db->bind('nama', htmlspecialchars($data['nama'], ENT_QUOTES, 'UTF-8'));
        $this->db->bind('nis', htmlspecialchars($data['nis'], ENT_QUOTES, 'UTF-8'));
        $this->db->bind('kelas', htmlspecialchars($data['kelas'], ENT_QUOTES, 'UTF-8'));
        $this->db->bind('alamat', htmlspecialchars($data['alamat'], ENT_QUOTES, 'UTF-8'));
        $this->db->bind('no_telp', htmlspecialchars($data['no_telp'], ENT_QUOTES, 'UTF-8'));
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function hapusDataMurid($id) {
        $query = "UPDATE murid SET deleted_at = NOW() WHERE id=:id";
        $this->db->query($query);
        $this->db->bind('id', $id);
        $this->db->execute();
        return $this->db->rowCount();
    }
}
