<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IPG extends Model
{
    use HasFactory;
    protected $table = 'ipg';
    protected $fillable = [
        'tahun',
        'UHH_Pria',
        'UHH_Wanita',
        'RLS_Pria',
        'RLS_Wanita',
        'HLS_Pria',
        'HLS_Wanita',
        'Pengeluaran_Pria',
        'Pengeluaran_Wanita',
        'jumlah',
    ];
    protected $casts = [
        'tahun' => 'integer',
        'UHH_Pria' => 'decimal:2',
        'UHH_Wanita' => 'decimal:2',
        'RLS_Pria' => 'decimal:2',
        'RLS_Wanita' => 'decimal:2',
        'HLS_Pria' => 'decimal:2',
        'HLS_Wanita' => 'decimal:2',
        'Pengeluaran_Pria' => 'integer',
        'Pengeluaran_Wanita' => 'integer',
        'jumlah' => 'integer',
    ];
    
}
