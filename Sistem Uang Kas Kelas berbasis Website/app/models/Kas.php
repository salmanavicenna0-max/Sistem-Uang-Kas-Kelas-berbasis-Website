<?php
class Kas {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getKasBulanTahun($bulan, $tahun) {
        $query = "SELECT m.id, m.nama, m.nis, 
                         MAX(CASE WHEN k.minggu_ke = 1 THEN k.status ELSE NULL END) as minggu_1,
                         MAX(CASE WHEN k.minggu_ke = 2 THEN k.status ELSE NULL END) as minggu_2,
                         MAX(CASE WHEN k.minggu_ke = 3 THEN k.status ELSE NULL END) as minggu_3,
                         MAX(CASE WHEN k.minggu_ke = 4 THEN k.status ELSE NULL END) as minggu_4
                  FROM murid m
                  LEFT JOIN pembayaran_kas k ON m.id = k.murid_id AND k.bulan = :bulan AND k.tahun = :tahun
                  GROUP BY m.id, m.nama, m.nis
                  ORDER BY m.nama ASC";
        $this->db->query($query);
        $this->db->bind('bulan', $bulan);
        $this->db->bind('tahun', $tahun);
        return $this->db->resultSet();
    }

    public function bayarKas($data) {
        $query = "INSERT INTO pembayaran_kas (murid_id, minggu_ke, bulan, tahun, status, tanggal_bayar) 
                  VALUES (:murid_id, :minggu_ke, :bulan, :tahun, 'lunas', :tanggal_bayar)
                  ON DUPLICATE KEY UPDATE status = 'lunas', tanggal_bayar = :tanggal_bayar";
        $this->db->query($query);
        $this->db->bind('murid_id', $data['murid_id']);
        $this->db->bind('minggu_ke', $data['minggu_ke']);
        $this->db->bind('bulan', $data['bulan']);
        $this->db->bind('tahun', $data['tahun']);
        $this->db->bind('tanggal_bayar', date('Y-m-d'));
        $this->db->execute();
        
        if ($this->db->rowCount() > 0) {
            // Get murid name
            $this->db->query("SELECT nama FROM murid WHERE id = :id");
            $this->db->bind('id', $data['murid_id']);
            $murid = $this->db->single();
            $nama = $murid['nama'];

            $nama_bulan = array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
            $keterangan = "Uang Kas {$nama} Minggu {$data['minggu_ke']} {$nama_bulan[$data['bulan']]} {$data['tahun']}";
            
            // Insert to transaksi
            $query = "INSERT INTO transaksi (kategori_id, tipe, tanggal, keterangan, jumlah, created_by) 
                      VALUES (1, 'masuk', :tanggal, :keterangan, 2000, :created_by)";
            $this->db->query($query);
            $this->db->bind('tanggal', date('Y-m-d'));
            $this->db->bind('keterangan', $keterangan);
            $this->db->bind('created_by', $_SESSION['user']['id'] ?? 1);
            $this->db->execute();
            return true;
        }
        return false;
    }

    public function batalKas($data) {
        $query = "DELETE FROM pembayaran_kas WHERE murid_id = :murid_id AND minggu_ke = :minggu_ke AND bulan = :bulan AND tahun = :tahun";
        $this->db->query($query);
        $this->db->bind('murid_id', $data['murid_id']);
        $this->db->bind('minggu_ke', $data['minggu_ke']);
        $this->db->bind('bulan', $data['bulan']);
        $this->db->bind('tahun', $data['tahun']);
        $this->db->execute();
        
        if ($this->db->rowCount() > 0) {
            // Try to delete the related transaction
            $this->db->query("SELECT nama FROM murid WHERE id = :id");
            $this->db->bind('id', $data['murid_id']);
            $murid = $this->db->single();
            $nama = $murid['nama'];

            $nama_bulan = array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
            $keterangan = "Uang Kas {$nama} Minggu {$data['minggu_ke']} {$nama_bulan[$data['bulan']]} {$data['tahun']}";
            
            $query = "DELETE FROM transaksi WHERE keterangan = :keterangan AND kategori_id = 1 AND tipe = 'masuk'";
            $this->db->query($query);
            $this->db->bind('keterangan', $keterangan);
            $this->db->execute();
            return true;
        }
        return false;
    }
}
