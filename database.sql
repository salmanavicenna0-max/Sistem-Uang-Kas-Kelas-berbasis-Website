-- Database: db_kaskelas
-- Menggunakan engine InnoDB untuk foreign key support

CREATE TABLE users (
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'bendahara', 'viewer') DEFAULT 'viewer',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE murid (
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    nama VARCHAR(100) NOT NULL,
    nis VARCHAR(20) UNIQUE,
    kelas VARCHAR(50),
    alamat TEXT,
    no_telp VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL DEFAULT NULL
) ENGINE=InnoDB;

CREATE TABLE kategori (
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    nama VARCHAR(100) UNIQUE NOT NULL,
    deskripsi TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE transaksi (
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    kategori_id INT(11) NOT NULL,
    tipe ENUM('masuk', 'keluar') NOT NULL,
    tanggal DATE NOT NULL,
    keterangan VARCHAR(255),
    jumlah DECIMAL(12,0) NOT NULL DEFAULT 0,
    created_by INT(11) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_transaksi_kategori FOREIGN KEY (kategori_id) REFERENCES kategori(id) ON DELETE RESTRICT,
    CONSTRAINT fk_transaksi_user FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE pembayaran_kas (
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    murid_id INT(11) NOT NULL,
    minggu_ke INT(11) NOT NULL,
    bulan INT(11) NOT NULL,
    tahun INT(11) NOT NULL,
    status ENUM('lunas', 'belum') DEFAULT 'lunas',
    tanggal_bayar DATE NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_kas_murid FOREIGN KEY (murid_id) REFERENCES murid(id) ON DELETE CASCADE,
    UNIQUE KEY unique_kas (murid_id, minggu_ke, bulan, tahun)
) ENGINE=InnoDB;

-- Tabel opsional untuk log perubahan (transparansi audit)
CREATE TABLE log_transaksi (
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    transaksi_id INT(11) NOT NULL,
    aksi ENUM('insert', 'update', 'delete') NOT NULL,
    data_lama JSON,
    data_baru JSON,
    dilakukan_oleh INT(11) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_log_user FOREIGN KEY (dilakukan_oleh) REFERENCES users(id) ON DELETE RESTRICT
) ENGINE=InnoDB;