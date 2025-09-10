<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LemburSeeder extends Seeder
{
    public function run(): void
    {
        $lemburs = [
            // Andi (pegawai_id = 1) lembur di Agustus 2025
            [
                'pegawai_id' => 1,
                'bulan' => 8,
                'tahun' => 2025,
                'jumlah_jam' => 5,
                'rate_per_jam' => 20000, // override optional (sama seperti golongan staff)
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Siti (pegawai_id = 2) lembur di Agustus 2025
            [
                'pegawai_id' => 2,
                'bulan' => 8,
                'tahun' => 2025,
                'jumlah_jam' => 8,
                'rate_per_jam' => 30000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Budi (pegawai_id = 3) lembur di Agustus 2025
            [
                'pegawai_id' => 3,
                'bulan' => 8,
                'tahun' => 2025,
                'jumlah_jam' => 3,
                'rate_per_jam' => 45000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // contoh lembur lain di bulan berbeda
            [
                'pegawai_id' => 1,
                'bulan' => 7,
                'tahun' => 2025,
                'jumlah_jam' => 2,
                'rate_per_jam' => 20000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($lemburs as $l) {
            DB::table('lemburs')->insert($l);
        }
    }
}
