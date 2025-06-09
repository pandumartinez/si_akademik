<?php

use App\Guru;
use App\Kelas;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
{
    public function run()
    {
        $kelas = [
            'X IPA',
            'X IPS',
            'XI IPA',
            'XI IPS',
            'XII IPA',
            'XII IPS',
        ];

        $guruList = Guru::inRandomOrder()
            ->limit(count($kelas))
            ->get();

        foreach ($kelas as $index => $nama_kelas) {
            $kelas = Kelas::create([
                'nama_kelas' => $nama_kelas,
                'wali_kelas' => $guruList[$index]->id,
            ]);
        }
    }
}
