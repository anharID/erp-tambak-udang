<?php

namespace Database\Seeders;

use App\Models\Kolam;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KolamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Kolam::create(
            [
                'nama' => 'A1',
                'lokasi' => 'STP UNDIP',
                'tipe' => 'Kolam Bisnis',
                'luas' => '625',
                'kedalaman' => '2',
            ]
        );

        Kolam::create([
            'nama' => 'A2',
            'lokasi' => 'STP UNDIP',
            'tipe' => 'Kolam Bisnis',
            'luas' => '625',
            'kedalaman' => '2',
        ]);
    }
}
