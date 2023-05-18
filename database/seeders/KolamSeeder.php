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
        Kolam::create([
            'nama' => 'A1',
            'lokasi' => 'STP UNDIP',
            'tipe' => 'Kolam Bisnis',
            'luas' => '25',
            'kedalaman' => '1.5',
        ]);
    }
}
