<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiniRasio extends Model
{
    use HasFactory;

    protected $table = 'gini_rasio';
    
    protected $fillable = [
        'tahun',
        'kecamatan',
        'nilai_gini_rasio',
        'kategori_ketimpangan',
        'pendapatan_per_kapita',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'tahun' => 'integer',
        'nilai_gini_rasio' => 'float',
        'pendapatan_per_kapita' => 'float',
    ];
} 