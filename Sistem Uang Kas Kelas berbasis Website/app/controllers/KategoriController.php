<?php

class KategoriController extends Controller {
    public function __construct() {
        $this->checkAuth();
    }

    public function index() {
        $data['judul'] = 'Kategori Transaksi';
        $data['kategori'] = $this->model('Kategori')->getAllKategori();
        $this->view('kategori/index', $data);
    }

    public function tambah() {
        $this->restrictTo('admin');
        if ($this->model('Kategori')->tambahDataKategori($_POST) > 0) {
            Flasher::setFlash('berhasil', 'ditambahkan', 'success');
            header('Location: ' . BASEURL . '/kategori');
            exit;
        } else {
            Flasher::setFlash('gagal', 'ditambahkan', 'danger');
            header('Location: ' . BASEURL . '/kategori');
            exit;
        }
    }

    public function edit() {
        $this->restrictTo('admin');
        if ($this->model('Kategori')->editDataKategori($_POST) > 0) {
            Flasher::setFlash('berhasil', 'diubah', 'success');
            header('Location: ' . BASEURL . '/kategori');
            exit;
        } else {
            Flasher::setFlash('gagal', 'diubah', 'danger');
            header('Location: ' . BASEURL . '/kategori');
            exit;
        }
    }

    public function hapus($id) {
        $this->restrictTo('admin');
        if ($this->model('Kategori')->hapusDataKategori($id) > 0) {
            Flasher::setFlash('berhasil', 'dihapus', 'success');
            header('Location: ' . BASEURL . '/kategori');
            exit;
        } else {
            Flasher::setFlash('gagal', 'dihapus', 'danger');
            header('Location: ' . BASEURL . '/kategori');
            exit;
        }
    }
}
