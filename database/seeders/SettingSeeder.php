<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'key' => 'app_name',
                'value' => 'Kantor Papoy',
                'description' => 'Name of the Application'
            ],
            [
                'key' => 'app_logo',
                'value' => 'storage/logo/default.png',
                'description' => 'Logo of the Application'
            ],
        ];

        DB::table('settings')->insert($settings);
    }
}
