<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penduduk extends Model
{
    use HasFactory;

    protected $table = 'penduduk';
    
    protected $fillable = [
        'tahun',
        'kecamatan',
        'jumlah_penduduk',
        'laki_laki',
        'perempuan',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'tahun' => 'integer',
        'jumlah_penduduk' => 'integer',
        'laki_laki' => 'integer',
        'perempuan' => 'integer',
    ];
} 