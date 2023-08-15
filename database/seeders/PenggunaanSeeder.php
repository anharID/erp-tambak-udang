<?php

namespace Database\Seeders;

use App\Models\PenggunaanEnergi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PenggunaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PenggunaanEnergi::create([
            'penggunaan' => 'Penerangan'
        ]);
        PenggunaanEnergi::create([
            'penggunaan' => 'Kincir'
        ]);
        PenggunaanEnergi::create([
            'penggunaan' => 'Pemanas'
        ]);
    }
}
