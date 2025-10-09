<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendudukUmur extends Model
{
    protected $table = 'pendudukumur';

    protected $fillable = [
        'tahun',
        'umur',
        'laki_laki',
        'perempuan',
        'jumlah',
    ];

    protected $appends = ['jumlah'];

    public function getJumlahAttribute()
    {
        return $this->laki_laki + $this->perempuan;
    }
}
