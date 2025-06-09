<?php

use App\Pengaturan;
use App\Periode;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'role' => 'admin',
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'password' => Hash::make('password'),
        ]);

        Periode::create([
            'tahun' => '2024',
            'semester' => 'genap',
            'aktif' => true,
        ]);

        Pengaturan::create([
            'key' => 'predikat',
            'value' => json_encode([
                'A' => 90,
                'B' => 80,
                'C' => 70,
            ])
        ]);

        $this->call(MapelSeeder::class);

        $this->call(GuruSeeder::class);

        $this->call(KelasSeeder::class);

        $this->call(SiswaSeeder::class);

        $this->call(JadwalSeeder::class);

        $this->call(NilaiSeeder::class);
    }
}
