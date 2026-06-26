<?php

class TransaksiController extends Controller {
    public function __construct() {
        $this->checkAuth();
    }

    public function index() {
        $data['judul'] = 'Data Transaksi';
        
        $start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
        $end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 15;
        $offset = ($page - 1) * $limit;
        
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['page'] = $page;
        $data['limit'] = $limit;
        
        $data['transaksi'] = $this->model('Transaksi')->getAllTransaksi($start_date, $end_date, $limit, $offset);
        $data['total_rows'] = $this->model('Transaksi')->getTotalFilteredRows($start_date, $end_date);
        $data['total_pages'] = ceil($data['total_rows'] / $limit);
        
        $data['total_masuk'] = $this->model('Transaksi')->getTotalMasuk($start_date, $end_date);
        $data['total_keluar'] = $this->model('Transaksi')->getTotalKeluar($start_date, $end_date);
        $data['saldo'] = $this->model('Transaksi')->getSaldo($start_date, $end_date);
        
        $data['kategori'] = $this->model('Kategori')->getAllKategori();
        
        $this->view('templates/header', $data);
        $this->view('transaksi/index', $data);
        $this->view('templates/footer');
    }

    public function tambah() {
        $this->restrictTo('admin', 'bendahara');
        $newId = $this->model('Transaksi')->tambahDataTransaksi($_POST);
        if ($newId > 0) {
            // Log Transaksi
            $this->model('LogTransaksi')->addLog($newId, 'insert', null, $_POST);
            
            Flasher::setFlash('berhasil', 'ditambahkan', 'success');
            header('Location: ' . BASEURL . '/transaksi');
            exit;
        } else {
            Flasher::setFlash('gagal', 'ditambahkan', 'danger');
            header('Location: ' . BASEURL . '/transaksi');
            exit;
        }
    }

    public function hapus($id) {
        $this->restrictTo('admin');
        $transaksi = $this->model('Transaksi')->getTransaksiById($id);
        if ($this->model('Transaksi')->hapusDataTransaksi($id) > 0) {
            $this->model('LogTransaksi')->addLog($id, 'delete', $transaksi, null);
            
            Flasher::setFlash('berhasil', 'dihapus', 'success');
            header('Location: ' . BASEURL . '/transaksi');
            exit;
        } else {
            Flasher::setFlash('gagal', 'dihapus', 'danger');
            header('Location: ' . BASEURL . '/transaksi');
            exit;
        }
    }
    
    public function export() {
        $start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
        $end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
        
        $transaksi = $this->model('Transaksi')->getAllTransaksi($start_date, $end_date); // get all without limit
        $total_masuk = $this->model('Transaksi')->getTotalMasuk($start_date, $end_date);
        $total_keluar = $this->model('Transaksi')->getTotalKeluar($start_date, $end_date);
        $saldo = $this->model('Transaksi')->getSaldo($start_date, $end_date);
        
        $filename = "Laporan_Transaksi_UangKas_" . date('Ymd') . ".csv";
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $output = fopen('php://output', 'w');
        
        // Add UTF-8 BOM for Excel
        fputs($output, $bom =(chr(0xEF) . chr(0xBB) . chr(0xBF)));
        
        // Header
        fputcsv($output, ['Tanggal', 'Keterangan', 'Kategori', 'Tipe', 'Nominal (Rp)', 'Dicatat Oleh'], ';');
        
        foreach ($transaksi as $t) {
            fputcsv($output, [
                date('d M Y', strtotime($t['tanggal'])),
                $t['keterangan'],
                $t['nama_kategori'],
                $t['tipe'],
                $t['jumlah'],
                $t['nama_user']
            ], ';');
        }
        
        fputcsv($output, [], ';');
        fputcsv($output, ['TOTAL MASUK', '', '', '', $total_masuk, ''], ';');
        fputcsv($output, ['TOTAL KELUAR', '', '', '', $total_keluar, ''], ';');
        fputcsv($output, ['SALDO AKHIR', '', '', '', $saldo, ''], ';');
        
        fclose($output);
        exit;
    }
}
