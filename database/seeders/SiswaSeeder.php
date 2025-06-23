<?php

namespace Database\Seeders;

use App\Kelas;
use App\Periode;
use App\Siswa;
use Illuminate\Database\Seeder;

class SiswaSeeder extends Seeder
{
    public function run()
    {
        $kelasList = Kelas::all();

        $jumlah = $kelasList->count() * 30;

        Siswa::factory()->count($jumlah)->create();

        $siswaList = Siswa::orderBy('tgl_lahir')->get('id')
            ->chunk(30);

        foreach ($kelasList as $index => $kelas) {
            foreach ($siswaList->get($index) as $siswa) {
                $siswa->kelas()->sync([
                    $kelas->id => ['periode_id' => Periode::id()]
                ]);
            }
        }
    }
}
