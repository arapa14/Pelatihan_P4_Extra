<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class GajiSeeder extends Seeder
{
    public function run(): void
    {
        $gajis = [];
        $tahun = 2025;
        $bulanRange = range(3, 8);

        // Gaji pokok (tetap)
        $pokok = [
            1 => 3000000 + 250000 + 100000 + 150000, // Andi
            2 => 5000000 + 400000 + 200000 + 200000, // Siti
            3 => 8000000 + 700000 + 400000 + 300000, // Budi
        ];

        // Fluktuasi potongan
        $potonganPattern = [0, 100000, 50000, 200000, 150000, 75000];

        foreach ($bulanRange as $index => $bulan) {
            foreach ([1, 2, 3] as $pegawaiId) {
                // variasi lembur tiap pegawai
                $jamLembur = ($pegawaiId * 2) + rand(0, $index + 2);
                $rate = $pegawaiId == 1 ? 20000 : ($pegawaiId == 2 ? 30000 : 45000);
                $lembur = $jamLembur * $rate;

                $potongan = $potonganPattern[$index] + rand(0, 50000);

                $gajis[] = [
                    'pegawai_id' => $pegawaiId,
                    'jumlah_gaji' => $pokok[$pegawaiId],
                    'jumlah_lembur' => $lembur,
                    'potongan' => $potongan,
                    'gaji_diterima' => $pokok[$pegawaiId] + $lembur - $potongan,
                    'bulan' => $bulan,
                    'tahun' => $tahun,
                    'tanggal_gaji' => Carbon::create($tahun, $bulan, 28),
                    'created_at' => Carbon::create($tahun, $bulan, 28),
                    'updated_at' => Carbon::create($tahun, $bulan, 28),
                ];
            }
        }

        DB::table('gajis')->insert($gajis);
    }
}
