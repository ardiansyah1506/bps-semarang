<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rekreasi extends Model
{
    use HasFactory;
    protected $table = 'rekreasi';
    protected $fillable = [
        'tahun',
        'bulan',
        'ihk_rekreasi',
        'inflasi_rekreasi',
        'andil_rekreasi',
        'jumlah'
    ];
    protected $casts = [
        'tahun' => 'integer',
        'bulan' => 'string',
        'ihk_rekreasi' => 'decimal:2',
        'inflasi_rekreasi' => 'decimal:2',
        'andil_rekreasi' => 'decimal:2',
        'jumlah' => 'integer'
    ];
}
