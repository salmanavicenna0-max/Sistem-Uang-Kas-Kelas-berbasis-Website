<?php

class MuridController extends Controller {
    public function __construct() {
        $this->checkAuth();
    }

    public function index() {
        $data['judul'] = 'Daftar Murid';
        
        $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 15;
        $offset = ($page - 1) * $limit;
        
        $data['keyword'] = $keyword;
        $data['page'] = $page;
        $data['limit'] = $limit;
        
        $data['murid'] = $this->model('Murid')->getAllMurid($keyword, $limit, $offset);
        $data['total_rows'] = $this->model('Murid')->getTotalRows($keyword);
        $data['total_pages'] = ceil($data['total_rows'] / $limit);
        
        $this->view('templates/header', $data);
        $this->view('murid/index', $data);
        $this->view('templates/footer');
    }

    public function tambah() {
        $this->restrictTo('admin');
        if ($this->model('Murid')->tambahDataMurid($_POST) > 0) {
            Flasher::setFlash('berhasil', 'ditambahkan', 'success');
            header('Location: ' . BASEURL . '/murid');
            exit;
        } else {
            Flasher::setFlash('gagal', 'ditambahkan', 'danger');
            header('Location: ' . BASEURL . '/murid');
            exit;
        }
    }

    public function edit() {
        $this->restrictTo('admin');
        if ($this->model('Murid')->editDataMurid($_POST) > 0) {
            Flasher::setFlash('berhasil', 'diubah', 'success');
            header('Location: ' . BASEURL . '/murid');
            exit;
        } else {
            Flasher::setFlash('gagal', 'diubah', 'danger');
            header('Location: ' . BASEURL . '/murid');
            exit;
        }
    }

    public function hapus($id) {
        $this->restrictTo('admin');
        if ($this->model('Murid')->hapusDataMurid($id) > 0) {
            Flasher::setFlash('berhasil', 'dihapus', 'success');
            header('Location: ' . BASEURL . '/murid');
            exit;
        } else {
            Flasher::setFlash('gagal', 'dihapus', 'danger');
            header('Location: ' . BASEURL . '/murid');
            exit;
        }
    }
}
