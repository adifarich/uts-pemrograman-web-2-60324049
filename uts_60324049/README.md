# UTS Pemrograman Web 2 — Sistem Manajemen Kategori Buku

## Identitas Mahasiswa

| | |
|---|---|
| **Nama** | Mohammad Adi Farich |
| **NIM** | 60324049 |
| **Program Studi** | Informatika |
| **Mata Kuliah** | Pemrograman Web 2 |
| **Semester** | Genap 2025/2026 |

---

## Deskripsi Aplikasi

Aplikasi web sederhana untuk mengelola **Kategori Buku** di perpustakaan. Dibangun menggunakan **PHP Native** dan **MySQL**, dengan fitur CRUD lengkap (Create, Read, Update, Delete).

Fitur utama:
- Menampilkan daftar kategori buku dalam tabel (READ)
- Menambah kategori baru dengan validasi server-side (CREATE)
- Mengubah data kategori yang ada (UPDATE)
- Menghapus kategori dengan konfirmasi (DELETE)

---

## Cara Instalasi & Menjalankan

### Persyaratan
- PHP >= 7.4
- MySQL / MariaDB
- Web server (XAMPP / Laragon / WAMP)

### Langkah-langkah

1. **Clone / copy** folder `uts_60324049` ke direktori htdocs (XAMPP) atau www (Laragon).

2. **Buat database** menggunakan phpMyAdmin atau terminal:
   ```bash
   mysql -u root -p < database_export.sql
   ```
   atau import file `database_export.sql` melalui phpMyAdmin.

3. **Sesuaikan konfigurasi** di `config/database.php`:
   ```php
   define('DB_NAME', 'uts_perpustakaan_60324049'); 
   ```

4. **Buka browser** dan akses:
   ```
   http://localhost/uts_60324049/index.php
   ```

---

## Struktur Folder

```
uts_60324049/
├── config/
│   └── database.php      # Koneksi & konfigurasi database
├── database_export.sql   # Database hasil export
├── index.php             # Halaman READ - daftar kategori
├── create.php            # Halaman CREATE - tambah kategori
├── edit.php              # Halaman UPDATE - edit kategori
├── delete.php            # Proses DELETE - hapus kategori
└── README.md             # Dokumentasi proyek
```

---

## Link Repository GitHub

[https://github.com/adifarich/uts-pemrograman-web-2-60324049](https://github.com/)

---

*© UTS Pemrograman Web 2 — UIN K.H. Abdurrahman Wahid Pekalongan*
