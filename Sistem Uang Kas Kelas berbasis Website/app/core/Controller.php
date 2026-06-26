<?php

class Controller {
    public function view($view, $data = []) {
        require_once __DIR__ . '/../views/' . $view . '.php';
    }

    public function model($model) {
        require_once __DIR__ . '/../models/' . $model . '.php';
        return new $model;
    }

    public function checkAuth() {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASEURL . '/auth');
            exit;
        }
    }

    public function restrictTo($role) {
        $this->checkAuth();
        if ($_SESSION['user']['role'] !== $role) {
            Flasher::setFlash('Akses', 'ditolak', 'danger');
            header('Location: ' . BASEURL . '/dashboard');
            exit;
        }
    }
}
