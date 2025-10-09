<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Informasi extends Model
{
    use HasFactory;
    protected $table = 'informasi';
    protected $fillable = [
        'tahun',
        'bulan',
        'ihk_informasi',
        'inflasi_informasi',
        'andil_informasi',
        'jumlah',
    ];
    protected $casts = [
        'tahun' => 'integer',
        'bulan' => 'string',
        'ihk_informasi' => 'decimal:2',
        'inflasi_informasi' => 'decimal:2',
        'andil_informasi' => 'decimal:2',
        'jumlah' => 'integer',
    ];
  
}
