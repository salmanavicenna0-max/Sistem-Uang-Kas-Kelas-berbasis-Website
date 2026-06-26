<?php

class DashboardController extends Controller {
    public function __construct() {
        $this->checkAuth();
    }

    public function index() {
        $data['judul'] = 'Dashboard';
        
        // Data Keuangan
        $transaksi = $this->model('Transaksi');
        $data['total_masuk'] = $transaksi->getTotalMasuk();
        $data['total_keluar'] = $transaksi->getTotalKeluar();
        $data['saldo'] = $transaksi->getSaldo();
        
        // Statistik
        $data['jumlah_murid'] = count($this->model('Murid')->getAllMurid());
        
        // Log Terbaru (5 terakhir)
        $logs = $this->model('LogTransaksi')->getAllLogs();
        $data['recent_logs'] = array_slice($logs, 0, 5);

        $this->view('dashboard/index', $data);
    }
}
