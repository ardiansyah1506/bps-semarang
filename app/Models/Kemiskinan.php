<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kemiskinan extends Model
{
    use HasFactory;

    protected $table = 'kemiskinan';
    
    protected $fillable = [
        'tahun',
        'kecamatan',
        'jumlah_penduduk_miskin',
        'persentase_penduduk_miskin',
        'garis_kemiskinan',
        'indeks_kedalaman_kemiskinan',
        'indeks_keparahan_kemiskinan',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'tahun' => 'integer',
        'jumlah_penduduk_miskin' => 'integer',
        'persentase_penduduk_miskin' => 'float',
        'garis_kemiskinan' => 'float',
        'indeks_kedalaman_kemiskinan' => 'float',
        'indeks_keparahan_kemiskinan' => 'float',
    ];
} 