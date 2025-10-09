# Instruksi Logo BPS

## Cara Menempatkan Logo BPS

1. **Siapkan gambar logo**
   - Simpan gambar logo BPS dengan nama `bps-logo.png`
   - Format yang didukung: PNG, JPG, JPEG
   - Ukuran yang disarankan: 200x200 pixel atau lebih besar

2. **Tempatkan file logo**
   - Buka folder `public/images/` di project Laravel Anda
   - Copy file `bps-logo.png` ke dalam folder tersebut
   - Pastikan path lengkap: `public/images/bps-logo.png`

3. **Verifikasi logo**
   - Refresh halaman website
   - Logo akan muncul di sidebar kiri
   - Jika logo tidak muncul, akan otomatis menggunakan icon Font Awesome sebagai fallback

## Struktur File
```
project-backend/
├── public/
│   └── images/
│       └── bps-logo.png  ← Tempatkan logo di sini
├── resources/
│   └── views/
│       └── layouts/
│           └── app.blade.php  ← File layout utama
└── ...
```

## Fitur Logo
- **Responsif**: Logo akan menyesuaikan ukuran di mobile dan desktop
- **Efek hover**: Logo akan membesar dan lebih terang saat di-hover
- **Fallback**: Jika logo tidak ditemukan, akan menggunakan icon Font Awesome
- **Animasi**: Logo memiliki efek shimmer yang modern

## Troubleshooting
- Jika logo tidak muncul, pastikan file ada di `public/images/bps-logo.png`
- Jika masih tidak muncul, cek permission file dan folder
- Pastikan nama file sesuai dengan yang ada di kode (`bps-logo.png`) 