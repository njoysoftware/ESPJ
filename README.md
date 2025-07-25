# Aplikasi SPJ Kecamatan - Bawaslu Kabupaten

Aplikasi ini merupakan sistem pelaporan Surat Pertanggungjawaban (SPJ) di lingkungan Bawaslu Kabupaten, khususnya untuk tingkat Kecamatan. Aplikasi ini dibangun menggunakan framework **CodeIgniter 4** dan basis data **MySQL**.

## Fitur Utama

- Manajemen Kuitansi Kecamatan
- Manajemen BKU Kecamatan
- Hak akses berdasarkan peran pengguna (Admin, Kecamatan)

## Teknologi yang Digunakan

- **Framework**: CodeIgniter 4
- **Database**: MySQL
- **Bahasa Pemrograman**: PHP 8+
- **Frontend**: Bootstrap 5 (default dari CI4)

## Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/njoysoftware/espj.git
cd espj
```

### 2. Install Dependencies
Jika menggunakan Composer:
```bash
composer install
```
### 3. Konfigurasi Environment
ubah file env menjadi .env

### 4. Import Database
import db_app.sql kedalam database 

### 5 jalankan Localhost
php spark serve
atau : localhost

## 📁 Struktur Folder Penting
- /app/Controllers – Logika kontrol aplikasi
- /app/Models – Interaksi dengan database
- /app/Views – Tampilan halaman
- /public/ – Akses publik (index.php, asset)
- /database/ – File SQL, migrasi


## Lisensi
Aplikasi ini dikembangkan untuk keperluan internal Bawaslu Kabupaten dan tidak untuk penggunaan komersial. Untuk penggunaan lebih lanjut, silakan hubungi pengelola sistem.

