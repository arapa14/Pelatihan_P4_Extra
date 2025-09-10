<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lembur extends Model
{
    protected $table = 'lemburs';

    protected $fillable = [
        'pegawai_id',
        'bulan',
        'tahun',
        'jumlah_jam',
        'rate_per_jam'
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }

}
