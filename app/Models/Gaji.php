<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gaji extends Model
{
    protected $table = 'gajis';

    protected $fillable = [
        'pegawai_id',
        'jumlah_gaji',
        'jumlah_lembur',
        'potongan',
        'gaji_diterima',
        'tanggal_gaji'
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}
