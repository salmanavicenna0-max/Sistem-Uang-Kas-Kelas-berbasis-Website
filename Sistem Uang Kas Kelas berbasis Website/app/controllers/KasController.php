<?php
class KasController extends Controller {
    public function __construct() {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASEURL . '/auth');
            exit;
        }
    }

    public function index() {
        $data['judul'] = 'Uang Kas Mingguan';
        
        $bulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('n');
        $tahun = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');
        
        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;
        $data['kas'] = $this->model('Kas')->getKasBulanTahun($bulan, $tahun);

        $this->view('templates/header', $data);
        $this->view('kas/index', $data);
        $this->view('templates/footer');
    }

    public function bayar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->model('Kas')->bayarKas($_POST)) {
                Flasher::setFlash('berhasil', 'dibayar', 'success');
            } else {
                Flasher::setFlash('gagal', 'dibayar', 'danger');
            }
            $bulan = $_POST['bulan'] ?? date('n');
            $tahun = $_POST['tahun'] ?? date('Y');
            $murid_id = $_POST['murid_id'];
            header('Location: ' . BASEURL . '/kas?bulan=' . $bulan . '&tahun=' . $tahun . '#row-' . $murid_id);
            exit;
        }
    }

    public function batal() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->model('Kas')->batalKas($_POST)) {
                Flasher::setFlash('berhasil', 'dibatalkan', 'success');
            } else {
                Flasher::setFlash('gagal', 'dibatalkan', 'danger');
            }
            $bulan = $_POST['bulan'] ?? date('n');
            $tahun = $_POST['tahun'] ?? date('Y');
            $murid_id = $_POST['murid_id'];
            header('Location: ' . BASEURL . '/kas?bulan=' . $bulan . '&tahun=' . $tahun . '#row-' . $murid_id);
            exit;
        }
    }
}
