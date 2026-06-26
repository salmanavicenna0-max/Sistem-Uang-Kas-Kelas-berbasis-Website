<?php

class User {
    private $table = 'users';
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getUser($email) {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE email=:email');
        $this->db->bind('email', $email);
        return $this->db->single();
    }
    
    public function getUserById($id) {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE id=:id');
        $this->db->bind('id', $id);
        return $this->db->single();
    }
    
    public function updatePassword($id, $new_password) {
        $query = "UPDATE users SET password = :password WHERE id = :id";
        $this->db->query($query);
        $this->db->bind('password', password_hash($new_password, PASSWORD_DEFAULT));
        $this->db->bind('id', $id);
        $this->db->execute();
        return $this->db->rowCount();
    }
    
    public function updateProfil($id, $nama) {
        $query = "UPDATE users SET nama = :nama WHERE id = :id";
        $this->db->query($query);
        $this->db->bind('nama', htmlspecialchars($nama, ENT_QUOTES, 'UTF-8'));
        $this->db->bind('id', $id);
        $this->db->execute();
        return $this->db->rowCount();
    }
}
