<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GajiSeeder extends Seeder
{
    public function run(): void
    {
        $gajis = [
            // Gaji Andi untuk Agustus 2025
            [
                'pegawai_id' => 1,
                'jumlah_gaji' => 3000000 + 250000 + 100000 + 150000, // pokok + tunjangan
                'jumlah_lembur' => 5 * 20000, // sesuai lembur yang kita masukkan
                'potongan' => 0,
                'gaji_diterima' => (3000000 + 250000 + 100000 + 150000) + (5 * 20000) - 0,
                'tanggal_gaji' => '2025-08-31',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Gaji Siti untuk Agustus 2025
            [
                'pegawai_id' => 2,
                'jumlah_gaji' => 5000000 + 400000 + 200000 + 200000,
                'jumlah_lembur' => 8 * 30000,
                'potongan' => 100000,
                'gaji_diterima' => (5000000 + 400000 + 200000 + 200000) + (8 * 30000) - 100000,
                'tanggal_gaji' => '2025-08-31',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Gaji Budi untuk Agustus 2025
            [
                'pegawai_id' => 3,
                'jumlah_gaji' => 8000000 + 700000 + 400000 + 300000,
                'jumlah_lembur' => 3 * 45000,
                'potongan' => 200000,
                'gaji_diterima' => (8000000 + 700000 + 400000 + 300000) + (3 * 45000) - 200000,
                'tanggal_gaji' => '2025-08-31',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($gajis as $gaji) {
            DB::table('gajis')->insert($gaji);
        }
    }
}
