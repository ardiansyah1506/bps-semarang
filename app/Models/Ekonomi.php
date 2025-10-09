<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ekonomi extends Model
{
    use HasFactory;
    protected $table = 'ekonomi';
    protected $fillable = [
        'tahun',
        'kategori',
        'trisa',
        'trida',
        'tri',
        'trifor',
        'tahunan'
    ];
    protected $casts = [
        'tahun' => 'integer',
        'kategori' => 'string',
        'trisa' => 'integer',
        'trida' => 'integer',
        'tri' => 'integer',
        'trifor' => 'integer',
        'tahunan' => 'integer',
    ];
}
