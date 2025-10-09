<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InflasiPemeliharaRT extends Model
{
    use HasFactory;
    protected $table = 'pemeliharart';
    protected $fillable = [
        'tahun',
        'bulan',
        'ihk_rt',
        'inflasi_rt',
        'andil_rt',
        'jumlah'
    ];
    protected $casts = [
        'tahun' => 'integer',
         'bulan' => 'string',
        'ihk_rt' => 'decimal:2',
        'inflasi_rt' => 'decimal:2',
        'andil_rt' => 'decimal:2',
        'jumlah' => 'integer'
    ];
}

