<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendidikan extends Model
{
    use HasFactory;
    protected $table = 'pendidikan';
    protected $fillable = [
        'tahun',
       
        'usia',
        'laki',
        'perempuan',
        'jumlah'
    ];
    protected $casts = [
        'tahun' => 'integer',
       
        'usia' => 'string',
        'laki' => 'integer',
        'perempuan' => 'integer',
        'jumlah' => 'integer'
    ];
}
