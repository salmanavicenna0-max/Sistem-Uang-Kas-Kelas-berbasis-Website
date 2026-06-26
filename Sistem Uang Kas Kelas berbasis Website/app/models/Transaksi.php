<?php

class Transaksi {
    private $table = 'transaksi';
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getAllTransaksi($start_date = '', $end_date = '', $limit = 0, $offset = 0) {
        $query = "SELECT t.*, k.nama as nama_kategori, u.nama as nama_user 
                  FROM transaksi t 
                  LEFT JOIN kategori k ON t.kategori_id = k.id 
                  LEFT JOIN users u ON t.created_by = u.id ";
                  
        $where = [];
        if ($start_date) {
            $where[] = "t.tanggal >= :start_date";
        }
        if ($end_date) {
            $where[] = "t.tanggal <= :end_date";
        }
        
        if (count($where) > 0) {
            $query .= " WHERE " . implode(' AND ', $where);
        }
                  
        $query .= " ORDER BY t.tanggal DESC, t.id DESC";
        
        if ($limit > 0) {
            $query .= " LIMIT :limit OFFSET :offset";
        }

        $this->db->query($query);
        
        if ($start_date) {
            $this->db->bind('start_date', $start_date);
        }
        if ($end_date) {
            $this->db->bind('end_date', $end_date);
        }
        if ($limit > 0) {
            $this->db->bind('limit', $limit, PDO::PARAM_INT);
            $this->db->bind('offset', $offset, PDO::PARAM_INT);
        }
        
        return $this->db->resultSet();
    }

    public function getTotalFilteredRows($start_date = '', $end_date = '') {
        $query = "SELECT COUNT(id) as total FROM transaksi t";
        
        $where = [];
        if ($start_date) {
            $where[] = "t.tanggal >= :start_date";
        }
        if ($end_date) {
            $where[] = "t.tanggal <= :end_date";
        }
        
        if (count($where) > 0) {
            $query .= " WHERE " . implode(' AND ', $where);
        }

        $this->db->query($query);
        
        if ($start_date) {
            $this->db->bind('start_date', $start_date);
        }
        if ($end_date) {
            $this->db->bind('end_date', $end_date);
        }
        
        return $this->db->single()['total'] ?? 0;
    }

    public function getTransaksiById($id) {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE id=:id');
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function tambahDataTransaksi($data) {
        $query = "INSERT INTO transaksi (kategori_id, tipe, tanggal, keterangan, jumlah, created_by) 
                  VALUES (:kategori_id, :tipe, :tanggal, :keterangan, :jumlah, :created_by)";
        $this->db->query($query);
        $this->db->bind('kategori_id', $data['kategori_id']);
        $this->db->bind('tipe', $data['tipe']);
        $this->db->bind('tanggal', $data['tanggal']);
        $this->db->bind('keterangan', htmlspecialchars($data['keterangan'], ENT_QUOTES, 'UTF-8'));
        $this->db->bind('jumlah', $data['jumlah']);
        $this->db->bind('created_by', $_SESSION['user']['id']);
        $this->db->execute();
        
        if ($this->db->rowCount() > 0) {
            return $this->db->lastInsertId();
        }
        return 0;
    }

    public function hapusDataTransaksi($id) {
        $query = "DELETE FROM transaksi WHERE id=:id";
        $this->db->query($query);
        $this->db->bind('id', $id);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function getTotalMasuk($start_date = '', $end_date = '') {
        $query = "SELECT SUM(jumlah) as total FROM transaksi WHERE tipe='masuk'";
        if ($start_date) $query .= " AND tanggal >= :start_date";
        if ($end_date) $query .= " AND tanggal <= :end_date";
        $this->db->query($query);
        if ($start_date) $this->db->bind('start_date', $start_date);
        if ($end_date) $this->db->bind('end_date', $end_date);
        return $this->db->single()['total'] ?? 0;
    }

    public function getTotalKeluar($start_date = '', $end_date = '') {
        $query = "SELECT SUM(jumlah) as total FROM transaksi WHERE tipe='keluar'";
        if ($start_date) $query .= " AND tanggal >= :start_date";
        if ($end_date) $query .= " AND tanggal <= :end_date";
        $this->db->query($query);
        if ($start_date) $this->db->bind('start_date', $start_date);
        if ($end_date) $this->db->bind('end_date', $end_date);
        return $this->db->single()['total'] ?? 0;
    }

    public function getSaldo($start_date = '', $end_date = '') {
        return (float)$this->getTotalMasuk($start_date, $end_date) - (float)$this->getTotalKeluar($start_date, $end_date);
    }
}
