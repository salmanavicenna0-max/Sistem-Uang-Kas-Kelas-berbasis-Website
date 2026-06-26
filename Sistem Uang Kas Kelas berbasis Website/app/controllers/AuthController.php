<?php

class AuthController extends Controller {
    public function index() {
        if (isset($_SESSION['user'])) {
            header('Location: ' . BASEURL . '/dashboard');
            exit;
        }
        $this->view('auth/login');
    }

    public function login() {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = $this->model('User')->getUser($email);

        if ($user) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'nama' => $user['nama'],
                    'email' => $user['email'],
                    'role' => $user['role']
                ];
                header('Location: ' . BASEURL . '/dashboard');
                exit;
            } else {
                Flasher::setFlash('Password', 'salah', 'danger');
                header('Location: ' . BASEURL . '/auth');
                exit;
            }
        } else {
            Flasher::setFlash('Email', 'tidak ditemukan', 'danger');
            header('Location: ' . BASEURL . '/auth');
            exit;
        }
    }

    public function logout() {
        session_destroy();
        header('Location: ' . BASEURL . '/auth');
        exit;
    }
}
