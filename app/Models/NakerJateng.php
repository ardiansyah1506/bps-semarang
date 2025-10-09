<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NakerJateng extends Model
{
    use HasFactory;
    protected $table = 'tenagakerjajateng';
    protected $fillable = [
        'tahun',
        'kategori',
        'nilai',
    ];
    protected $casts = [
        'tahun' => 'integer',
        'nilai' => 'integer',
    ];
}
