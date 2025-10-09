# Instruksi Menjalankan Migration

## Masalah
Grafik tidak muncul karena kemungkinan database belum terisi data.

## Solusi
Jalankan migration dan seeder dari Laragon Terminal:

### Langkah 1: Buka Laragon Terminal
1. Buka aplikasi Laragon
2. Klik tombol "Terminal" di bagian bawah Laragon
3. Terminal akan terbuka dengan direktori yang sudah benar

### Langkah 2: Jalankan Migration
```bash
php artisan migrate:fresh --seed
```

### Langkah 3: Cek Data
Setelah migration selesai, buka browser dan akses:
- `http://localhost/project-backend/debug-penduduk` (untuk cek data penduduk)
- `http://localhost/project-backend/login` (untuk login dan lihat dashboard)

### Langkah 4: Login
- Email: `admin@bps.go.id`
- Password: `password123`

## Jika Masih Ada Error

### Cek Database Connection
1. Buka file `.env` di root project
2. Pastikan konfigurasi database benar:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```

### Cek Database
1. Buka phpMyAdmin dari Laragon
2. Pastikan database `laravel` sudah ada
3. Pastikan tabel `penduduk` sudah ada dan berisi data

### Alternative: Manual Database Setup
Jika migration tidak berhasil, buat database manual:
1. Buka phpMyAdmin
2. Buat database baru bernama `laravel`
3. Import file SQL yang sudah disediakan (jika ada)

## Debug Routes
- `/debug-auth` - Cek status login
- `/debug-db` - Cek koneksi database
- `/debug-penduduk` - Cek data penduduk

## Troubleshooting
- Jika PHP tidak dikenali, pastikan Laragon sudah terinstall dengan benar
- Jika database error, cek apakah MySQL sudah running di Laragon
- Jika masih error, restart Laragon dan coba lagi 