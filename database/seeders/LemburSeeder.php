<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LemburSeeder extends Seeder
{
    public function run(): void
    {
        $lemburs = [];
        $tahun = 2025;

        // Simulasi 6 bulan terakhir (Maret - Agustus)
        $bulanRange = range(3, 8);

        foreach ($bulanRange as $bulan) {
            // Pola fluktuasi jam lembur (biar naik turun)
            $baseJam = [2, 6, 3, 8, 4, 7];

            $lemburs[] = [
                'pegawai_id' => 1,
                'bulan' => $bulan,
                'tahun' => $tahun,
                'jumlah_jam' => $baseJam[$bulan - 3] + rand(-1, 2),
                'rate_per_jam' => 20000,
                'created_at' => Carbon::create($tahun, $bulan, rand(10, 25)),
                'updated_at' => Carbon::create($tahun, $bulan, rand(10, 25)),
            ];

            $lemburs[] = [
                'pegawai_id' => 2,
                'bulan' => $bulan,
                'tahun' => $tahun,
                'jumlah_jam' => $baseJam[$bulan - 3] + rand(0, 4),
                'rate_per_jam' => 30000,
                'created_at' => Carbon::create($tahun, $bulan, rand(10, 25)),
                'updated_at' => Carbon::create($tahun, $bulan, rand(10, 25)),
            ];

            $lemburs[] = [
                'pegawai_id' => 3,
                'bulan' => $bulan,
                'tahun' => $tahun,
                'jumlah_jam' => max(1, $baseJam[$bulan - 3] - rand(0, 3)),
                'rate_per_jam' => 45000,
                'created_at' => Carbon::create($tahun, $bulan, rand(10, 25)),
                'updated_at' => Carbon::create($tahun, $bulan, rand(10, 25)),
            ];
        }

        DB::table('lemburs')->insert($lemburs);
    }
}
