<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendidikanDua extends Model
{
    use HasFactory;
    protected $table = 'pendidikandua';

    protected $fillable = [
        'tahun',
        'kategori',
        'apm',
        'apk'
    ];

    protected $casts = [
        'tahun' => 'integer',
        'kategori' => 'string',
        'apm' => 'integer',
        'apk' => 'integer',
        
    ];
}
