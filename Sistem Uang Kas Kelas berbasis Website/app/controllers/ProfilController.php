<?php

class ProfilController extends Controller {
    public function __construct() {
        $this->checkAuth();
    }

    public function index() {
        $data['judul'] = 'Profil Saya';
        $data['user'] = $this->model('User')->getUserById($_SESSION['user']['id']);
        
        $this->view('templates/header', $data);
        $this->view('profil/index', $data);
        $this->view('templates/footer');
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_SESSION['user']['id'];
            $nama = $_POST['nama'];
            
            if ($this->model('User')->updateProfil($id, $nama) > 0) {
                $_SESSION['user']['nama'] = htmlspecialchars($nama, ENT_QUOTES, 'UTF-8');
                Flasher::setFlash('Profil berhasil', 'diperbarui', 'success');
            } else {
                Flasher::setFlash('Profil gagal', 'diperbarui', 'danger');
            }
            header('Location: ' . BASEURL . '/profil');
            exit;
        }
    }

    public function ganti_password() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_SESSION['user']['id'];
            $password_lama = $_POST['password_lama'];
            $password_baru = $_POST['password_baru'];
            $konfirmasi_password = $_POST['konfirmasi_password'];
            
            $user = $this->model('User')->getUserById($id);
            
            if (password_verify($password_lama, $user['password'])) {
                if ($password_baru === $konfirmasi_password) {
                    if ($this->model('User')->updatePassword($id, $password_baru) > 0) {
                        Flasher::setFlash('Password berhasil', 'diubah', 'success');
                    } else {
                        Flasher::setFlash('Password gagal', 'diubah', 'danger');
                    }
                } else {
                    Flasher::setFlash('Konfirmasi password', 'tidak cocok', 'danger');
                }
            } else {
                Flasher::setFlash('Password lama', 'salah', 'danger');
            }
            
            header('Location: ' . BASEURL . '/profil');
            exit;
        }
    }
}
