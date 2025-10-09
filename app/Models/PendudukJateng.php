<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendudukJateng extends Model
{
    use HasFactory;

    protected $table = 'pendudukjateng';
    protected $fillable = [
        'tahun',
        'provinsi',
        'jumlahwarga',
        'pria',
        'wanita',
    ];
    protected $casts = [
        'tahun' => 'integer',
        'jumlahwarga' => 'integer',
        'pria' => 'integer',
        'wanita' => 'integer',
    ];

}
