<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $table = "pegawais";

    protected $fillable = [
        'nama',
        'jabatan',
        'umur',
        'alamat',
        'golongan_id'
    ];

    public function golongan()
    {
        return $this->belongsTo(Golongan::class, 'golongan_id');
    }

    public function lemburs()
    {
        return $this->hasMany(Lembur::class);
    }

    public function gajis()
    {
        return $this->hasMany(Gaji::class);
    }

    /**
     * Hitung komponen gaji (pokok + tunjangan)
     */
    public function hitungKomponenGaji(): int
    {
        $g = $this->golongan;
        if (! $g) return 0;
        return ($g->gaji_pokok ?? 0)
             + ($g->tunjangan_keluarga ?? 0)
             + ($g->tunjangan_transport ?? 0)
             + ($g->tunjangan_makan ?? 0);
    }

    /**
     * Hitung total lembur untuk bulan tertentu
     */
    public function totalLemburUntuk($bulan, $tahun): int
    {
        // asumsi lembur.jumlah_jam dan rate_per_jam / golongan->tarif_lembur_per_jam
        $lemburs = $this->lemburs()->where('bulan', $bulan)->where('tahun', $tahun)->get();
        $total = 0;
        foreach ($lemburs as $l) {
            $rate = $l->rate_per_jam ?? ($this->golongan->tarif_lembur_per_jam ?? 0);
            $total += ($l->jumlah_jam * $rate);
        }
        return $total;
    }
}
