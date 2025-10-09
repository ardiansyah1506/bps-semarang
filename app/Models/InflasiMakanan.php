<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InflasiMakanan extends Model
{
    use HasFactory;
    protected $table = 'inflasimakanan';
    protected $fillable = [
        'tahun',
        'bulan',
        'ihk_pakaian',
        'inflasi_pakaian',
        'andil_pakaian',
        'jumlah',
    ];
    protected $casts = [
        'tahun' => 'string',
        'bulan' => 'string',
        'ihk_pakaian' => 'decimal:2',
        'inflasi_pakaian' => 'decimal:2',
        'andil_pakaian' => 'decimal:2',
        'jumlah' => 'integer',
    ];
}
