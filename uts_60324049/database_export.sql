CREATE DATABASE IF NOT EXISTS uts_perpustakaan_60324049
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE uts_perpustakaan_60324049;

CREATE TABLE IF NOT EXISTS kategori (
    id_kategori  INT AUTO_INCREMENT PRIMARY KEY,
    kode_kategori VARCHAR(10) UNIQUE NOT NULL,
    nama_kategori VARCHAR(50) NOT NULL,
    deskripsi     TEXT,
    status        ENUM('Aktif', 'Nonaktif') DEFAULT 'Aktif',
    created_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO kategori (kode_kategori, nama_kategori, deskripsi, status) VALUES
('KAT-001', 'Pemrograman', 'Buku-buku tentang bahasa pemrograman', 'Aktif'),
('KAT-002', 'Database',    'Buku-buku tentang sistem basis data',  'Nonaktif'),
('KAT-003', 'Jaringan',    'Buku-buku tentang jaringan komputer',  'Nonaktif'),
('KAT-004', 'Statistik',   'Buku-buku tentang statistik',          'Aktif'),
('KAT-005', 'Kecerdasan Buatan', 'Buku-buku tentang kecerdasan buatan', 'Nonaktif');