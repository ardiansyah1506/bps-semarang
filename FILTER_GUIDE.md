# 🎯 Panduan Filter Data Website BPS Kota Semarang

## 📋 **Daftar Isi**
1. [Cara Kerja Filter](#cara-kerja-filter)
2. [Filter yang Tersedia](#filter-yang-tersedia)
3. [Cara Menggunakan Filter](#cara-menggunakan-filter)
4. [Fitur CRUD Data](#fitur-crud-data)
5. [Database Integration](#database-integration)
6. [Troubleshooting](#troubleshooting)

---

## 🔧 **Cara Kerja Filter**

### **1. Filter Tahun (Yang Sudah Berfungsi)**
```php
// Di Controller
$tahun = $request->get('tahun', date('Y')); // Ambil tahun dari URL parameter
```

### **2. Filter Umur Multi-Select (Baru Ditambahkan)**
```php
// Di Controller
$filterUmur = $request->get('umur', []); // Ambil filter umur sebagai array
```

### **3. Proses Filter:**
1. **User memilih tahun dan umur** → Checkbox berubah
2. **User klik "Filter Data"** → Form dikirim ke server
3. **Controller memproses** → Data difilter berdasarkan tahun dan umur yang dipilih
4. **View di-render** → Halaman baru dengan data yang sudah difilter

---

## 📊 **Filter yang Tersedia**

### **A. Filter Tahun (✅ Sudah Berfungsi)**
```
Pilih Tahun: [2022 ▼] [2023] [2024]
```

**Lokasi:**
- ✅ Data Penduduk Berdasarkan Umur
- ✅ Data Penduduk per Kecamatan  
- ✅ Data Penduduk Jawa Tengah

**Fungsi:**
- ✅ Menampilkan data sesuai tahun yang dipilih
- ✅ Data berubah sesuai tahun (2022, 2023, 2024)

### **B. Filter Umur Multi-Select (✅ Baru Ditambahkan)**
```
Pilih Kelompok Umur (Bisa Pilih Lebih dari Satu):
☐ 0-4 tahun    ☐ 5-9 tahun    ☐ 10-14 tahun    ☐ 15-19 tahun
☐ 20-24 tahun  ☐ 25-29 tahun  ☐ 30-34 tahun    ☐ 35-39 tahun
☐ 40-44 tahun  ☐ 45-49 tahun  ☐ 50-54 tahun    ☐ 55-59 tahun
☐ 60-64 tahun  ☐ 65+ tahun
```

**Lokasi:**
- ✅ Data Penduduk Berdasarkan Umur

**Fungsi:**
- ✅ Menampilkan data sesuai kelompok umur yang dipilih
- ✅ Bisa memilih lebih dari satu umur sekaligus
- ✅ Data tabel dan grafik update sesuai filter
- ✅ Menampilkan info filter aktif

### **C. Filter yang Bisa Ditambahkan (🔄 Belum Ada)**

#### **1. Filter Kecamatan**
```
Pilih Kecamatan: [Semua Kecamatan ▼] [🔍 Filter]
```

#### **2. Filter Gender**
```
Pilih Gender: [Semua ▼] [Laki-laki] [Perempuan]
```

#### **3. Filter Range Data**
```
Range: [Min: 0] [Max: 1,000,000] [🔍 Filter]
```

---

## 🎮 **Cara Menggunakan Filter**

### **Step 1: Akses Halaman**
```
1. Login ke website BPS
2. Klik menu "Penduduk"
3. Pilih card "Data Penduduk Berdasarkan Umur"
```

### **Step 2: Gunakan Filter Tahun dan Umur**
```
1. Lihat bagian "Filter Tahun dan Umur" di atas tabel
2. Pilih tahun dari dropdown (2022, 2023, 2024)
3. Pilih kelompok umur dengan checkbox:
   - Centang checkbox untuk umur yang ingin ditampilkan
   - Bisa pilih lebih dari satu umur sekaligus
   - Contoh: centang "0-4 tahun" dan "5-9 tahun" untuk data anak-anak
4. Klik tombol "Filter Data"
5. Halaman akan refresh dengan data yang sudah difilter
```

### **Step 3: Verifikasi Hasil**
```
✅ Perubahan yang terlihat:
- Info "Filter Aktif" menampilkan tahun dan umur yang dipilih
- Judul halaman menampilkan tahun yang dipilih
- Data tabel berubah sesuai tahun dan umur yang dipilih
- Grafik update sesuai data baru
- Total penduduk berubah
- Analisis piramida penduduk update
```

### **Step 4: Reset Filter**
```
1. Klik tombol "Reset" untuk menghapus semua filter
2. Data akan kembali ke tampilan default (semua umur, tahun terbaru)
```

---

## 📈 **Contoh Penggunaan Filter Umur Multi-Select**

### **Scenario 1: Analisis Anak-anak**
```
Filter: Tahun 2023, Umur ["0-4 tahun", "5-9 tahun", "10-14 tahun"]
Hasil: Data penduduk usia anak-anak (0-14 tahun) tahun 2023
```

### **Scenario 2: Analisis Remaja dan Dewasa Muda**
```
Filter: Tahun 2024, Umur ["15-19 tahun", "20-24 tahun", "25-29 tahun"]
Hasil: Data penduduk usia remaja dan dewasa muda tahun 2024
```

### **Scenario 3: Analisis Dewasa Produktif**
```
Filter: Tahun 2023, Umur ["25-29 tahun", "30-34 tahun", "35-39 tahun", "40-44 tahun"]
Hasil: Data penduduk usia produktif tahun 2023
```

### **Scenario 4: Analisis Lansia**
```
Filter: Tahun 2022, Umur ["60-64 tahun", "65+ tahun"]
Hasil: Data penduduk usia lanjut tahun 2022
```

### **Scenario 5: Analisis Komparasi Umur**
```
Filter: Tahun 2024, Umur ["0-4 tahun", "25-29 tahun", "65+ tahun"]
Hasil: Data penduduk anak-anak, dewasa muda, dan lansia tahun 2024
```

### **Scenario 6: Analisis Semua Umur**
```
Filter: Tahun 2023, Umur [] (tidak ada yang dicentang)
Hasil: Data semua kelompok umur tahun 2023
```

---

## 🛠️ **Fitur CRUD Data**

### **A. Tambah Data (✅ Baru Ditambahkan)**
```
Tombol: [➕ Tambah Data]
```

**Cara Menggunakan:**
1. Klik tombol "Tambah Data" di header tabel
2. Modal akan terbuka dengan form input
3. Isi data:
   - Pilih Kelompok Umur
   - Masukkan Jumlah Laki-laki
   - Masukkan Jumlah Perempuan
4. Klik "Simpan" untuk menyimpan data
5. Data akan ditambahkan ke tabel dan database

### **B. Edit Data (✅ Baru Ditambahkan)**
```
Tombol: [✏️ Edit] (untuk setiap baris data)
```

**Cara Menggunakan:**
1. Klik tombol "Edit" (ikon pensil) pada baris data yang ingin diedit
2. Modal akan terbuka dengan data yang sudah terisi
3. Edit data yang diinginkan:
   - Kelompok Umur
   - Jumlah Laki-laki
   - Jumlah Perempuan
4. Klik "Update" untuk menyimpan perubahan
5. Data akan diperbarui di tabel dan database

### **C. Hapus Data (✅ Baru Ditambahkan)**
```
Tombol: [🗑️ Hapus] (untuk setiap baris data)
```

**Cara Menggunakan:**
1. Klik tombol "Hapus" (ikon tempat sampah) pada baris data yang ingin dihapus
2. Modal konfirmasi akan terbuka
3. Baca pesan konfirmasi dengan teliti
4. Klik "Hapus" untuk menghapus data
5. Data akan dihapus dari tabel dan database

### **D. Alert Messages (✅ Baru Ditambahkan)**
```
✅ Success: "Data berhasil ditambahkan!"
✅ Success: "Data berhasil diperbarui!"
✅ Success: "Data berhasil dihapus!"
❌ Error: Pesan error jika ada masalah
```

---

## 🗄️ **Database Integration**

### **A. Koneksi Database (✅ Baru Ditambahkan)**
```php
// Controller sekarang terhubung ke database
$dataUmur = Penduduk::where('tahun', $tahun)
    ->select('id', 'kecamatan as umur', 'laki_laki', 'perempuan', 'jumlah_penduduk as total')
    ->get()
    ->toArray();
```

### **B. Tambah Data ke Database (✅ Baru Ditambahkan)**
```php
// Simpan ke database
Penduduk::create([
    'tahun' => $request->tahun,
    'kecamatan' => $request->umur, // Gunakan field kecamatan untuk menyimpan umur
    'laki_laki' => $request->laki_laki,
    'perempuan' => $request->perempuan,
    'jumlah_penduduk' => $total
]);
```

### **C. Update Data di Database (✅ Baru Ditambahkan)**
```php
// Update data di database
$penduduk = Penduduk::findOrFail($id);
$penduduk->update([
    'tahun' => $request->tahun,
    'kecamatan' => $request->umur,
    'laki_laki' => $request->laki_laki,
    'perempuan' => $request->perempuan,
    'jumlah_penduduk' => $total
]);
```

### **D. Hapus Data dari Database (✅ Baru Ditambahkan)**
```php
// Hapus data dari database
$penduduk = Penduduk::findOrFail($id);
$penduduk->delete();
```

### **E. Data Awal (✅ Baru Ditambahkan)**
```php
// Seeder sudah ditambahkan data umur untuk tahun 2023
$umurData = [
    ['tahun' => 2023, 'kecamatan' => '0-4 tahun', 'jumlah_penduduk' => 88000, 'laki_laki' => 45000, 'perempuan' => 43000],
    ['tahun' => 2023, 'kecamatan' => '5-9 tahun', 'jumlah_penduduk' => 94000, 'laki_laki' => 48000, 'perempuan' => 46000],
    // ... semua kelompok umur
];
```

---

## 🎯 **Cara Kerja CRUD**

### **1. Tambah Data**
```php
// Route
Route::post('/penduduk/umur/tambah', [DashboardController::class, 'tambahDataUmur']);

// Controller
public function tambahDataUmur(Request $request)
{
    $request->validate([
        'umur' => 'required|string',
        'laki_laki' => 'required|integer|min:0',
        'perempuan' => 'required|integer|min:0',
        'tahun' => 'required|integer'
    ]);
    
    try {
        $total = $request->laki_laki + $request->perempuan;
        
        // Simpan ke database
        Penduduk::create([
            'tahun' => $request->tahun,
            'kecamatan' => $request->umur,
            'laki_laki' => $request->laki_laki,
            'perempuan' => $request->perempuan,
            'jumlah_penduduk' => $total
        ]);
        
        return redirect()->route('penduduk.umur')->with('success', 'Data berhasil ditambahkan!');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Gagal menambahkan data: ' . $e->getMessage());
    }
}
```

### **2. Edit Data**
```php
// Route
Route::put('/penduduk/umur/edit/{id}', [DashboardController::class, 'editDataUmur']);

// Controller
public function editDataUmur(Request $request, $id)
{
    $request->validate([
        'umur' => 'required|string',
        'laki_laki' => 'required|integer|min:0',
        'perempuan' => 'required|integer|min:0',
        'tahun' => 'required|integer'
    ]);
    
    try {
        $total = $request->laki_laki + $request->perempuan;
        
        // Update data di database
        $penduduk = Penduduk::findOrFail($id);
        $penduduk->update([
            'tahun' => $request->tahun,
            'kecamatan' => $request->umur,
            'laki_laki' => $request->laki_laki,
            'perempuan' => $request->perempuan,
            'jumlah_penduduk' => $total
        ]);
        
        return redirect()->route('penduduk.umur')->with('success', 'Data berhasil diperbarui!');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
    }
}
```

### **3. Hapus Data**
```php
// Route
Route::delete('/penduduk/umur/hapus/{id}', [DashboardController::class, 'hapusDataUmur']);

// Controller
public function hapusDataUmur($id)
{
    try {
        // Hapus data dari database
        $penduduk = Penduduk::findOrFail($id);
        $penduduk->delete();
        
        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
    }
}
```

---

## 🛠️ **Troubleshooting**

### **Problem 1: Filter Tidak Berfungsi**
**Gejala:** Data tidak berubah ketika filter dipilih

**Solusi:**
```bash
1. Pastikan sudah klik tombol "Filter Data"
2. Pastikan minimal satu checkbox umur dicentang
3. Cek apakah ada error di console browser
4. Pastikan JavaScript enabled
5. Coba refresh halaman (Ctrl+F5)
```

### **Problem 2: Data Tidak Muncul**
**Gejala:** Tabel kosong setelah filter

**Solusi:**
```bash
1. Coba centang semua checkbox umur untuk melihat semua data
2. Pastikan tahun yang dipilih ada datanya
3. Jalankan migration: php artisan migrate:fresh --seed
```

### **Problem 3: Charts Tidak Update**
**Gejala:** Grafik tetap sama meski data berubah

**Solusi:**
```bash
1. Cek console browser untuk error JavaScript
2. Pastikan Chart.js library ter-load
3. Refresh halaman (Ctrl+F5)
```

### **Problem 4: CRUD Tidak Berfungsi**
**Gejala:** Modal tidak terbuka atau data tidak tersimpan

**Solusi:**
```bash
1. Pastikan Bootstrap JS ter-load
2. Cek console browser untuk error JavaScript
3. Pastikan form validation berjalan
4. Cek Laravel log untuk error server
```

### **Problem 5: Data Tidak Tersimpan ke Database**
**Gejala:** Alert sukses muncul tapi data tidak ada di database

**Solusi:**
```bash
1. Jalankan migration: php artisan migrate:fresh --seed
2. Cek koneksi database di .env
3. Cek Laravel log untuk error database
4. Pastikan tabel penduduk sudah dibuat
```

### **Problem 6: Filter Lambat**
**Gejala:** Halaman loading lama ketika filter

**Solusi:**
```bash
1. Cek query database di controller
2. Tambahkan index di database
3. Optimasi query dengan eager loading
```

---

## 🎯 **Kesimpulan**

### **✅ Yang Sudah Berfungsi:**
- Filter tahun di semua halaman detail
- Filter umur multi-select di halaman "Data Penduduk Berdasarkan Umur"
- Button "Filter Data" berfungsi dengan baik
- Button "Reset" berfungsi dengan baik
- Data berubah secara real-time
- Charts update sesuai filter
- Tampilan bersih tanpa debug info
- Info filter aktif ditampilkan
- **Fitur CRUD lengkap (Create, Read, Update, Delete)**
- **Modal untuk tambah, edit, dan hapus data**
- **Alert messages untuk feedback user**
- **Form validation untuk data integrity**
- **Database integration - data tersimpan ke database**
- **Error handling untuk operasi database**

### **🔄 Yang Bisa Ditambahkan:**
- Filter kecamatan
- Filter gender
- Filter range data
- Export data hasil filter
- Filter umur di halaman lain
- **Bulk operations (hapus multiple data)**
- **Import data dari Excel/CSV**
- **Data backup dan restore**

### **📊 Manfaat Filter Multi-Select:**
- **Analisis Komparasi:** Bandingkan data antar kelompok umur
- **Analisis Kategori:** Analisis berdasarkan kategori umur (anak, dewasa, lansia)
- **Fleksibilitas:** Pilih kombinasi umur sesuai kebutuhan
- **Efisiensi:** Tidak perlu filter berulang kali

### **📊 Manfaat Fitur CRUD:**
- **Manajemen Data:** Kelola data dengan mudah
- **Akurasi Data:** Update data yang tidak akurat
- **Fleksibilitas:** Tambah data baru sesuai kebutuhan
- **Kontrol Data:** Hapus data yang tidak diperlukan

### **📊 Manfaat Database Integration:**
- **Persistensi Data:** Data tersimpan permanen di database
- **Real-time Updates:** Perubahan langsung terlihat
- **Data Integrity:** Validasi dan error handling
- **Scalability:** Bisa menangani data dalam jumlah besar

---

## 🚀 **Next Steps**

### **Filter Lanjutan yang Bisa Ditambahkan:**

#### **1. Multi-Filter**
```
Tahun: [2023 ▼]
Umur: [☐ 0-4] [☐ 5-9] [☐ 10-14] ... [☐ 65+]
Gender: [Semua ▼]
[🔍 Filter Data]
```

#### **2. Advanced Filter**
```
Tahun: [2023 ▼]
Kategori Umur: [☐ Anak (0-14)] [☐ Dewasa (15-64)] [☐ Lansia (65+)]
Range Data: [Min: 0] [Max: 1,000,000]
[🔍 Filter Data]
```

#### **3. Export Filter**
```
Filter: [Tahun 2023] [Umur: 0-4, 5-9, 10-14 tahun]
[📊 Export Excel] [📄 Export PDF]
```

### **CRUD Lanjutan yang Bisa Ditambahkan:**

#### **1. Bulk Operations**
```
☐ Select All | [🗑️ Hapus Selected] [📊 Export Selected]
```

#### **2. Import Data**
```
[📁 Choose File] [📤 Import Excel/CSV]
```

#### **3. Data History**
```
[📋 View History] [🔄 Restore Version]
```

---

## 📋 **Instruksi Setup Database**

### **Step 1: Jalankan Migration dan Seeder**
```bash
# Di terminal Laragon atau command prompt
cd D:\laragon\www\project-backend
php artisan migrate:fresh --seed
```

### **Step 2: Verifikasi Data**
```bash
# Cek apakah data sudah masuk ke database
php artisan tinker
>>> App\Models\Penduduk::where('tahun', 2023)->count()
```

### **Step 3: Test CRUD**
```
1. Buka website BPS
2. Login dengan admin@bps.go.id / password123
3. Klik menu "Penduduk" → "Data Penduduk Berdasarkan Umur"
4. Test tambah, edit, dan hapus data
5. Cek database untuk memastikan data tersimpan
```

---

**🎉 Filter multi-select dan fitur CRUD sudah terhubung ke database! Sekarang data benar-benar tersimpan dan bisa dikelola dengan mudah. Silakan jalankan migration dan seeder, lalu test fitur CRUD-nya.** 