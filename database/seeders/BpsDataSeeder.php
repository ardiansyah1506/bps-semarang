<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Penduduk;
use App\Models\TenagaKerja;
use App\Models\Kemiskinan;
use App\Models\GiniRasio;

class BpsDataSeeder extends Seeder
{
    public function run()
    {
        // Database kosong - siap untuk data asli
        // Data akan ditambahkan melalui fitur CRUD di website
        
        // Data Tenaga Kerja (kosong)
        // TenagaKerja::create([
        //     'tahun' => 2023,
        //     'kecamatan' => 'Semarang Kota',
        //     'jumlah_angkatan_kerja' => 850000,
        //     'jumlah_bekerja' => 780000,
        //     'jumlah_pengangguran' => 70000,
        //     'tingkat_pengangguran' => 8.2,
        //     'tingkat_partisipasi_kerja' => 75.5
        // ]);

        // Data Kemiskinan (kosong)
        // Kemiskinan::create([
        //     'tahun' => 2023,
        //     'kecamatan' => 'Semarang Kota',
        //     'jumlah_penduduk_miskin' => 125000,
        //     'persentase_penduduk_miskin' => 8.5,
        //     'garis_kemiskinan' => 450000,
        //     'indeks_kedalaman_kemiskinan' => 1.5,
        //     'indeks_keparahan_kemiskinan' => 0.8
        // ]);

        // Data Gini Rasio (kosong)
        // GiniRasio::create([
        //     'tahun' => 2023,
        //     'kecamatan' => 'Semarang Kota',
        //     'nilai_gini_rasio' => 0.385,
        //     'kategori_ketimpangan' => 'Sedang',
        //     'pendapatan_per_kapita' => 4500000
        // ]);
    }
} 