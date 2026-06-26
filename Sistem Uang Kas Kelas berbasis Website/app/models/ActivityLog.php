<?php

class ActivityLog {
    private $table = 'activity_logs';
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function addLog($userId, $aksi, $detail) {
        $query = "INSERT INTO activity_logs (user_id, aksi, detail) VALUES (:user_id, :aksi, :detail)";
        $this->db->query($query);
        $this->db->bind('user_id', $userId);
        $this->db->bind('aksi', $aksi);
        $this->db->bind('detail', $detail);
        $this->db->execute();
    }

    public function getAllLogs() {
        $query = "SELECT l.*, u.username FROM activity_logs l 
                  LEFT JOIN users u ON l.user_id = u.id 
                  ORDER BY l.created_at DESC";
        $this->db->query($query);
        return $this->db->resultSet();
    }
}
