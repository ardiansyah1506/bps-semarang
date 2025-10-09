<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IpM extends Model
{
    use HasFactory;
    protected $table = 'ipm';
    protected $fillable = [
        'tahun',
        'UHH',
        'RLS',
        'HLS',
        'Pengeluaran',
    ];
    protected $casts = [
        'tahun' => 'integer',
        'UHH' => 'float',
        'RLS' => 'float',
        'HLS' => 'float',
        'Pengeluaran' => 'integer',
    ];
}
