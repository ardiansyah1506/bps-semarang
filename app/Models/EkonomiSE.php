<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EkonomiSE extends Model
{
    use HasFactory;
    protected $table = 'ekonomidua';
    protected $fillable = [
        'tahun',
        'kategori',
        'triwulansatu',
        'triwulandua',
        'triwulantiga',
        'triwulanempat',
        'tahunan'
    ];

    protected $casts =[
        'tahun' => 'integer',
        'kategori' => 'string',
        'triwulansatu' => 'integer',
        'triwulandua' => 'integer',
        'triwulantiga' => 'integer',
        'triwulanempat' => 'integer',
        'tahunan' => 'integer',
    ];
}
