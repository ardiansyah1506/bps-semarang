<?php

namespace App\Imports;

use App\Models\PendudukUmur;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PendudukUmurImport implements ToModel, WithHeadingRow
{
    protected $tahun;

    public function __construct($tahun)
    {
        $this->tahun = $tahun;
    }

    public function model(array $row)
    {
        \Log::info('Baris yang dibaca:', $row);

        // Pastikan nama kolom sesuai dengan heading di file Excel kamu
        return new PendudukUmur([
            'kelompok_umur' => $row['kelompok_umur'] ?? null,
            'laki_laki' => $row['laki_laki'] ?? 0,
            'perempuan' => $row['perempuan'] ?? 0,
            'jumlah' => $row['jumlah'] ?? 0,
            'tahun' => $this->tahun
        ]);
    }
}
