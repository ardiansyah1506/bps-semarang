<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerlengkapanSehat extends Model
{
    use HasFactory;
    protected $table = 'perlengkapan';
    protected $fillable = [
        'tahun',
        'bulan',
        'ihk_kesehatan',
        'inflasi_kesehatan',
        'andil_kesehatan',
        'jumlah'
    ];
    protected $casts = [
        'tahun' => 'integer',
        'bulan' => 'string',
        'ihk_kesehatan' => 'decimal:2',
        'inflasi_kesehatan' => 'decimal:2',
        'andil_kesehatan' => 'decimal:2',
        'jumlah' => 'integer'
    ];
}
