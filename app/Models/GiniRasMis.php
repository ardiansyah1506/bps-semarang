<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiniRasMis extends Model
{
    use HasFactory;
    protected $table = 'ginirasio_kemiskinan';
    protected $fillable = [
        'tahun',
        'penduduk_miskin',
        'penduduk_miskin_persen',
        'garis_kemiskinan',
        'gini_rasio',
        'jumlah',
    ];
    protected $casts = [
        'tahun' => 'integer',
        'penduduk_miskin' => 'integer',
        'penduduk_miskin_persen' => 'float',
        'garis_kemiskinan' => 'integer',
        'gini_rasio' => 'float',
        'jumlah' => 'integer',
    ];
}
