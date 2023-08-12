<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::create(
            [
                'name' => 'Super Admin',
                'email' => 'rizsamudera.su@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'superadmin',
                'email_verified_at' => now()
            ]
        );

        User::create(
            [
                'name' => 'Direktur',
                'email' => 'rizsamudera.direktur@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'direktur',
                'email_verified_at' => now()
            ]
        );

        User::create(
            [
                'name' => 'Manajer Keuangan',
                'email' => 'rizsamudera.keuangan@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'manajer keuangan',
                'email_verified_at' => now()
            ]
        );

        User::create([
            'name' => 'Teknisi',
            'email' => 'rizsamudera.teknisi@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'teknisi',
            'email_verified_at' => now()
        ]);

        User::create([
            'name' => 'Admin',
            'email' => 'rizsamudera.admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now()
        ]);
    }
}
