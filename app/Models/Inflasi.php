<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inflasi extends Model
{
    use HasFactory;
    protected $table = 'inflasie';
    protected $fillable = [
        'tahun',
        'bulan',
        'kategori',
        'ihk',
        'inflasi_komulatif',
        'andil',
    ];
}
