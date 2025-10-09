# Panduan Setup Website BPS Kota Semarang

## Langkah-langkah Setup

### 1. Konfigurasi Database
Pastikan MySQL sudah terinstall dan buat database baru:
```sql
CREATE DATABASE bps_semarang;
```

### 2. Konfigurasi Environment
Copy file .env.example ke .env dan sesuaikan konfigurasi database:
```bash
cp .env.example .env
```

Edit file .env dan sesuaikan konfigurasi database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bps_semarang
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 3. Install Dependencies
```bash
composer install
```

### 4. Generate Application Key
```bash
php artisan key:generate
```

### 5. Jalankan Migration
```bash
php artisan migrate
```

### 6. Jalankan Seeder
```bash
php artisan db:seed
```

### 7. Start Development Server
```bash
php artisan serve
```

## Login Default
- **Email**: admin@bps.go.id
- **Password**: password123

## Fitur yang Tersedia

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
- Data penduduk miskin per kecamatan
- Garis kemiskinan dan indeks kemiskinan
- Grafik persentase kemiskinan dan trend garis kemiskinan

### 📈 Data Gini Rasio
- Data ketimpangan pendapatan per kecamatan
- Kategori ketimpangan (Rendah/Sedang/Tinggi)
- Grafik gini rasio per kecamatan dan trend kota

## Struktur Database

### Tabel yang Dibuat:
1. **users** - Tabel user untuk autentikasi
2. **penduduk** - Data statistik penduduk
3. **tenaga_kerja** - Data statistik tenaga kerja
4. **kemiskinan** - Data statistik kemiskinan
5. **gini_rasio** - Data statistik ketimpangan pendapatan

### Data Sample:
- 16 kecamatan di Kota Semarang
- Data tahun 2023
- Data random untuk testing

## Troubleshooting

### Error Database Connection
- Pastikan MySQL service berjalan
- Periksa konfigurasi database di .env
- Pastikan database `bps_semarang` sudah dibuat

### Error Migration
- Pastikan semua dependencies terinstall
- Jalankan `composer install`
- Pastikan database connection berhasil

### Error Seeder
- Pastikan migration sudah berhasil
- Periksa model dan fillable fields
- Pastikan database tidak kosong

## Kontak Support

Jika mengalami masalah, silakan hubungi:
- Email: bps3374@bps.go.id
- Telepon: (024) 351-1234 