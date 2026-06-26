<?php

class LogTransaksi {
    private $table = 'log_transaksi';
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function addLog($transaksiId, $aksi, $dataLama, $dataBaru) {
        $query = "INSERT INTO log_transaksi (transaksi_id, aksi, data_lama, data_baru, dilakukan_oleh) 
                  VALUES (:transaksi_id, :aksi, :data_lama, :data_baru, :dilakukan_oleh)";
        $this->db->query($query);
        $this->db->bind('transaksi_id', $transaksiId);
        $this->db->bind('aksi', $aksi);
        $this->db->bind('data_lama', json_encode($dataLama));
        $this->db->bind('data_baru', json_encode($dataBaru));
        $this->db->bind('dilakukan_oleh', $_SESSION['user']['id']);
        $this->db->execute();
    }

    public function getAllLogs() {
        $query = "SELECT l.*, u.nama as nama_user FROM log_transaksi l 
                  LEFT JOIN users u ON l.dilakukan_oleh = u.id 
                  ORDER BY l.created_at DESC";
        $this->db->query($query);
        return $this->db->resultSet();
    }
}
