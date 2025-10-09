<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InflasiPPL extends Model
{
    use HasFactory;
    protected $table = 'inflasippl';
    protected $fillable = [
        'tahun',
        'bulan',
        'ihk_ppl',
        'inflasi_ppl',
        'andil_ppl',
        'jumlah',
    ];
    protected $casts = [
        'tahun' => 'integer',
        'bulan' => 'string',
        'ihk_ppl' => 'decimal:2',
        'inflasi_ppl' => 'decimal:2',
        'andil_ppl' => 'decimal:2',
        'jumlah' => 'integer',
    ];
}
