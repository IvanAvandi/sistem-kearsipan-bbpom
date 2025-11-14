# Sistem Kearsipan Digital BBPOM (Modul SIBOB)

Sistem manajemen kearsipan (Record Management System) berbasis web yang dirancang sebagai modul untuk SIBOB BBPOM. Aplikasi ini mengelola siklus hidup arsip (penciptaan, pemindahan, pemusnahan) dan terintegrasi langsung dengan database SIBOB.

## 🧰 Stack Teknologi

-   **Framework:** Laravel 8
-   **Frontend:** TALL Stack (TailwindCSS, Alpine.js, Livewire)
-   **Database:** MySQL / MariaDB

## 🚀 Fitur Utama

-   Manajemen Arsip (CRUD).
-   Alur Usul Pindah (Arsiparis -> Admin TU).
-   Alur Usul Musnah (Admin TU -> Pusat).
-   Penjadwal (Cron Job) JRA otomatis untuk retensi arsip.
-   Integrasi langsung dengan tabel `users` dan `divisi` SIBOB.
-   Hak akses dinamis (Admin/Arsiparis) berdasarkan `divisi_id`.
-   Ekspor Laporan Excel (BA Pindah, Usul Musnah) sesuai standar.

---

## ⚙️ Prasyarat & Konfigurasi Server

Instruksi ini untuk **Skenario 1**: Aplikasi diinstal di server yang memiliki akses baca/tulis langsung ke database SIBOB yang sudah ada, pastikan sudah ada tabel users dan divisi di dalamnnya.

### Prasyarat Teknis

-   PHP >= 8.0
-   Composer
-   Node.js & NPM
-   Database SIBOB yang sudah ada (MySQL/MariaDB)

### Checklist Konfigurasi

Setelah dependensi standar Laravel (`composer install`, `npm install && npm run build`) diinstal, berikut adalah langkah-langkah spesifik untuk proyek ini:

**1. Konfigurasi `.env`**
Pastikan variabel berikut diatur untuk menunjuk ke database SIBOB yang sudah ada:

```.env
DB_CONNECTION=mysql
DB_HOST=[IP_SERVER_DB_SIBOB]
DB_PORT=3306
DB_DATABASE=db_sibob
DB_USERNAME=user_sibob
DB_PASSWORD="password_sibob_anda"
```

**2. Jalankan Migrasi (Penting)**
Perintah ini **aman** dijalankan pada database SIBOB yang ada. Laravel hanya akan menambahkan tabel-tabel baru yang spesifik untuk modul ini (misal: `arsip`, `usulan_pindahs`, `usulan_pemusnahan`, dll.).

```bash
php artisan migrate --force
```

**3. Jalankan Seeder (Rekomendasi)**
Untuk mengisi data master awal aplikasi (JRA):

```bash
php artisan db:seed --class=KlasifikasiSuratSeeder
```

**4. Buat Link Storage**
Diperlukan untuk mengakses file BA dan lampiran yang di-upload atau buat ulang jika linknya rusak.

```bash
php artisan storage:link
```

**5. Konfigurasi Cron Job (Wajib untuk JRA)**
Aplikasi ini memerlukan _scheduler_ Laravel untuk menjalankan JRA otomatis (`arsip:update-status`). Tambahkan baris berikut ke `crontab` server:

```bash
* * * * * cd /path/ke/folder/proyek && php artisan schedule:run >> /dev/null 2>&1
```

**6. Optimasi Production**
Untuk performa terbaik, jalankan perintah _cache_:

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```
