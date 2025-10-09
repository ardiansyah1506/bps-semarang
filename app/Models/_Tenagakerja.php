<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class _Tenagakerja extends Model
{
    use HasFactory;

    protected $table = "_tenagakerja";

    protected $fillable = [
        'tahun',
        'bekerja_laki_laki',
        'bekerja_perempuan',
        'pengangguran_laki_laki',
        'pengangguran_perempuan',
        'tpak',
        'tkk',
        'tpt',
        'jumlah',
    ];

    protected $casts = [
        'tahun' => 'integer',
        'bekerja_laki_laki' => 'integer',
        'bekerja_perempuan' => 'integer',
        'pengangguran_laki_laki' => 'integer',
        'pengangguran_perempuan' => 'integer',
        'tpak' => 'string',
        'tkk' => 'string',
        'tpt' => 'string',
        'jumlah' => 'integer',
    ];
}
