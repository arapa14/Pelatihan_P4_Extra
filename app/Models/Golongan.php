<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Golongan extends Model
{
    protected $table = 'golongans';

    protected $fillable = [
        'nama', 
        'gaji_pokok', 
        'tunjangan_keluarga', 
        'tunjangan_transport', 
        'tunjangan_makan', 
        'tarif_lembur_per_jam'
    ];

    public function pegawais()
    {
        return $this->hasMany(Pegawai::class, 'golongan_id');
    }
}
