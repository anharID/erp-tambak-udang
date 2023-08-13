<?php

namespace Database\Seeders;

use App\Models\KelolaJenisBarang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenisBarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        KelolaJenisBarang::create([
            'jenisbarang' => 'Pakan'
        ]);
        KelolaJenisBarang::create([
            'jenisbarang' => 'Obat-obatan'
        ]);
        KelolaJenisBarang::create([
            'jenisbarang' => 'Bahah Kimia'
        ]);
    }
}
