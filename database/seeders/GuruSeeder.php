<?php

namespace Database\Seeders;

use App\Deskripsi;
use App\Guru;
use App\Mapel;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class GuruSeeder extends Seeder
{
    public function run()
    {
        $jumlah = Mapel::distinct()->count('nama_mapel');

        $guruList = Guru::factory()->count($jumlah)->create();

        $password = Hash::make('password');

        foreach ($guruList as $guru) {
            $guru->user()->save(new User([
                'role' => 'guru',
                'name' => $guru->nama_guru,
                'email' => strtolower(str_replace(' ', '.', $guru->nama_guru)) . '@mail.com',
                'password' => $password,
            ]));

            foreach (['pengetahuan', 'keterampilan'] as $jenis) {
                foreach (['A', 'B', 'C', 'D'] as $predikat) {
                    $deskripsi = Deskripsi::factory()->make();
                    $deskripsi->jenis = $jenis;
                    $deskripsi->predikat = $predikat;

                    $guru->deskripsi()->save($deskripsi);
                }
            }
        }
    }
}
