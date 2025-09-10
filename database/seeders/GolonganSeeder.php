<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GolonganSeeder extends Seeder
{
    public function run(): void
    {
        $golongans = [
            [
                'nama' => 'Staff',
                'gaji_pokok' => 3000000,
                'tunjangan_keluarga' => 250000,
                'tunjangan_transport' => 100000,
                'tunjangan_makan' => 150000,
                'tarif_lembur_per_jam' => 20000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Supervisor',
                'gaji_pokok' => 5000000,
                'tunjangan_keluarga' => 400000,
                'tunjangan_transport' => 200000,
                'tunjangan_makan' => 200000,
                'tarif_lembur_per_jam' => 30000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Manager',
                'gaji_pokok' => 8000000,
                'tunjangan_keluarga' => 700000,
                'tunjangan_transport' => 400000,
                'tunjangan_makan' => 300000,
                'tarif_lembur_per_jam' => 45000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($golongans as $golongan) {
            DB::table('golongans')->insert($golongan);
        }
    }
}
