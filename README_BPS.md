# Website BPS Kota Semarang

Website sistem informasi statistik untuk Badan Pusat Statistik (BPS) Kota Semarang yang dibangun menggunakan framework Laravel.

## Fitur Utama

### 🔐 Autentikasi
- Login dengan email dan password
- Logout dengan aman
- Middleware autentikasi untuk melindungi halaman

### 📊 Dashboard
- Statistik ringkasan (Total Penduduk, Angkatan Kerja, Penduduk Miskin, Gini Rasio)
- Grafik trend statistik Kota Semarang
- Informasi kontak BPS
- Menu akses cepat ke semua modul

### 👥 Data Penduduk
- Tabel data penduduk per kecamatan
- Informasi jumlah penduduk, laki-laki, perempuan
- Kepadatan penduduk dan pertumbuhan
- Grafik distribusi dan trend pertumbuhan

### 💼 Data Tenaga Kerja
- Data angkatan kerja per kecamatan
- Informasi tingkat pengangguran dan partisipasi kerja
- Grafik status tenaga kerja dan trend pengangguran

### ❤️ Data Kemiskinan
- miskin per kecamatan
- Garis kemiskinan dan indeks kemiskinan
- Grafik persentase kemiskinan dan trend garis kemiskinan

### 📈 Data Gini Rasio
- Data ketimpangan pendapatan per kecamatan
- Kategori ketimpangan (Rendah/Sedang/Tinggi)
- Grafik gini rasio per kecamatan dan trend kota

### 🎨 UI/UX
- Sidebar responsif dengan menu navigasi
- Design modern dengan gradient warna
- Grafik interaktif menggunakan Chart.js
- Modal untuk tambah/edit data
- Responsive design untuk mobile

## Teknologi yang Digunakan

### Backend
- **Laravel 10** - Framework PHP
- **MySQL** - Database
- **Eloquent ORM** - Database abstraction layer

### Frontend
- **Bootstrap 5** - CSS Framework
- **Font Awesome** - Icon library
- **Chart.js** - JavaScript charting library

### Database
- **MySQL** - Database management system
- **Migration** - Database schema management
- **Seeder** - Sample data generation

## Struktur Database

### Tabel Penduduk
- `id` - Primary key
- `tahun` - Tahun data
- `kecamatan` - Nama kecamatan
- `jumlah_penduduk` - Total penduduk
- `laki_laki` - Jumlah penduduk laki-laki
- `perempuan` - Jumlah penduduk perempuan
- `kepadatan_penduduk` - Kepadatan penduduk per km²
- `pertumbuhan_penduduk` - Persentase pertumbuhan

### Tabel Tenaga Kerja
- `id` - Primary key
- `tahun` - Tahun data
- `kecamatan` - Nama kecamatan
- `jumlah_angkatan_kerja` - Jumlah angkatan kerja
- `jumlah_bekerja` - Jumlah yang bekerja
- `jumlah_pengangguran` - Jumlah pengangguran
- `tingkat_pengangguran` - Persentase pengangguran
- `tingkat_partisipasi_kerja` - Tingkat partisipasi kerja

### Tabel Kemiskinan
- `id` - Primary key
- `tahun` - Tahun data
- `kecamatan` - Nama kecamatan
- `jumlah_penduduk_miskin` - Jumlah penduduk miskin
- `persentase_penduduk_miskin` - Persentase kemiskinan
- `garis_kemiskinan` - Nilai garis kemiskinan
- `indeks_kedalaman_kemiskinan` - Indeks kedalaman
- `indeks_keparahan_kemiskinan` - Indeks keparahan

### Tabel Gini Rasio
- `id` - Primary key
- `tahun` - Tahun data
- `kecamatan` - Nama kecamatan
- `nilai_gini_rasio` - Nilai gini rasio
- `kategori_ketimpangan` - Kategori ketimpangan
- `pendapatan_per_kapita` - Pendapatan per kapita

## Instalasi dan Setup

### Prerequisites
- PHP 8.1 atau lebih tinggi
- Composer
- MySQL/MariaDB
- Web server (Apache/Nginx)

### Langkah Instalasi

1. **Clone repository**
   ```bash
   git clone <repository-url>
   cd project-backend
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Setup environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Konfigurasi database di .env**
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=bps_semarang
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Jalankan migration**
   ```bash
   php artisan migrate
   ```

6. **Jalankan seeder**
   ```bash
   php artisan db:seed
   ```

7. **Start development server**
   ```bash
   php artisan serve
   ```

### Login Default
- **Email**: admin@bps.go.id
- **Password**: password123

## Struktur Folder

```
project-backend/
├── app/
│   ├── Http/Controllers/
│   │   ├── AuthController.php
│   │   └── DashboardController.php
│   ├── Models/
│   │   ├── Penduduk.php
│   │   ├── TenagaKerja.php
│   │   ├── Kemiskinan.php
│   │   └── GiniRasio.php
│   └── Http/Middleware/
│       └── CheckAuth.php
├── database/
│   ├── migrations/
│   │   ├── create_penduduk_table.php
│   │   ├── create_tenaga_kerja_table.php
│   │   ├── create_kemiskinan_table.php
│   │   └── create_gini_rasio_table.php
│   └── seeders/
│       ├── DatabaseSeeder.php
│       └── BpsDataSeeder.php
├── resources/views/
│   ├── auth/
│   │   └── login.blade.php
│   ├── dashboard/
│   │   ├── index.blade.php
│   │   ├── penduduk.blade.php
│   │   ├── tenaga-kerja.blade.php
│   │   ├── kemiskinan.blade.php
│   │   └── gini-rasio.blade.php
│   └── layouts/
│       └── app.blade.php
└── routes/
    └── web.php
```

## Routes

| Method | URL | Description |
|--------|-----|-------------|
| GET | `/` | Redirect ke login |
| GET | `/login` | Halaman login |
| POST | `/login` | Proses login |
| POST | `/logout` | Proses logout |
| GET | `/dashboard` | Dashboard utama |
| GET | `/penduduk` | Data penduduk |
| GET | `/tenaga-kerja` | Data tenaga kerja |
| GET | `/kemiskinan` | Data kemiskinan |
| GET | `/gini-rasio` | Data gini rasio |

## Kontribusi

1. Fork repository
2. Buat branch fitur baru (`git checkout -b feature/nama-fitur`)
3. Commit perubahan (`git commit -am 'Tambah fitur baru'`)
4. Push ke branch (`git push origin feature/nama-fitur`)
5. Buat Pull Request

## Lisensi

Proyek ini dikembangkan untuk BPS Kota Semarang.

## Kontak

- **BPS Kota Semarang**
- Alamat: Jl. Dr. Wahidin No.1, Semarang Tengah, Kota Semarang
- Telepon: (024) 351-1234
- Email: bps3374@bps.go.id
- Website: semarangkota.bps.go.id 