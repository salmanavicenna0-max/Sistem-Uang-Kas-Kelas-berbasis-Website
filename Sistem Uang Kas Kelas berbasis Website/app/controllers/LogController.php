<?php

class LogController extends Controller {
    public function index() {
        $data['judul'] = 'Log Aktivitas';
        $data['logs'] = $this->model('LogTransaksi')->getAllLogs();
        $this->view('logs/index', $data);
    }
}
