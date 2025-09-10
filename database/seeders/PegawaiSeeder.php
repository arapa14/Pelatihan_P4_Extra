<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PegawaiSeeder extends Seeder
{
    public function run(): void
    {
        $pegawais = [
            [
                'nama' => 'Andi Wijaya',
                'jabatan' => 'Staff Administrasi',
                'umur' => 28,
                'alamat' => 'Jl. Melati No.1 Jakarta',
                'golongan_id' => 1, // Staff
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Siti Rahma',
                'jabatan' => 'Supervisor Produksi',
                'umur' => 34,
                'alamat' => 'Jl. Kenanga No.5 Bekasi',
                'golongan_id' => 2, // Supervisor
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Budi Santoso',
                'jabatan' => 'Manager Operasional',
                'umur' => 41,
                'alamat' => 'Jl. Mawar No.10 Tangerang',
                'golongan_id' => 3, // Manager
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($pegawais as $pegawai) {
            DB::table('pegawais')->insert($pegawai);
        }
    }
}
