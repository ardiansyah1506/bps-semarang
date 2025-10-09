<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trans extends Model
{
    use HasFactory;
    protected $table='trans';
    protected $fillable = [
        'tahun',
        'bulan',
        'ihk_trans',
        'inflasi_trans',
        'andil_trans',
        'jumlah',
    ];
    protected $casts = [
        'tahun' => 'integer',
        'bulan' => 'string',
        'ihk_trans' => 'decimal:2',
        'inflasi_trans' => 'decimal:2',
        'andil_trans' => 'decimal:2',
        'jumlah' => 'integer',
    ];
}
