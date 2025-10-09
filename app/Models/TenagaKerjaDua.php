<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenagaKerjaDua extends Model
{
    use HasFactory;
    protected $table = "tenaga_kerjadua";

    protected $fillable = [
        'tahun',
        'bekerja_pria',
        'bekerja_wanita',
        'pengangguran_pria',
        'pengangguran_wanita',
        'sekolah_pria',
        'sekolah_wanita',
        'rt_pria',
        'rt_wanita',
        'lainnya_pria',
        'lainnya_wanita',
        'jumlah',
    ];

    protected $casts = [
        'tahun' => 'integer',
        'bekerja_pria' => 'integer',
        'bekerja_wanita' => 'integer',
        'pengangguran_pria' => 'integer',
        'pengangguran_wanita' => 'integer',
        'sekolah_pria' => 'integer',
        'sekolah_wanita' => 'integer',
        'rt_pria' => 'integer',
        'rt_wanita' => 'integer',
        'lainnya_pria' => 'integer',
        'lainnya_wanita' => 'integer',
        'jumlah' => 'integer',
    ];
}
