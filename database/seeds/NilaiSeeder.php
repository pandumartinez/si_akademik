<?php

use App\Kelas;
use App\Nilai;
use Illuminate\Database\Seeder;

class NilaiSeeder extends Seeder
{
    public function run()
    {
        $kelasList = Kelas::with('mapel', 'siswa.kelasSiswa')->get();

        foreach ($kelasList->random(2) as $kelas) {
            foreach ($kelas->siswa as $siswa) {
                foreach ($kelas->mapel->random(5) as $mapel) {
                    Nilai::create([
                        'kelas_siswa_id' => $siswa->kelasSiswa->id,
                        'mapel_id' => $mapel->id,
                        'tugas_1' => rand(60, 100),
                        'tugas_2' => rand(60, 100),
                        'tugas_3' => rand(60, 100),
                        'tugas_4' => rand(60, 100),
                        'ulha_1' => rand(60, 100),
                        'ulha_2' => rand(60, 100),
                        'ulha_3' => rand(60, 100),
                        'ulha_4' => rand(60, 100),
                    ]);
                }
            }
        }
    }
}
