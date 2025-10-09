<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InflasiPakaian extends Model
{
    use HasFactory;
    protected $table = 'inflasipakaian';
    protected $fillable = [
        'tahun',
        'bulan',
        'ihk_pakaian',
        'inflasi_pakaian',
        'andil_pakaian',
        'jumlah',
    ];
    protected $casts = [
        'tahun' => 'integer',
        'bulan' => 'string',
        'ihk_pakaian' => 'decimal:2',
        'inflasi_pakaian' => 'decimal:2',
        'andil_pakaian' => 'decimal:2',
        'jumlah' => 'integer',
    ];
}
