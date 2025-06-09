<?php

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

        factory(Siswa::class, $jumlah)->create();

        $siswaList = Siswa::orderBy('tgl_lahir')->get('id')
            ->chunk(30);

        foreach ($kelasList as $index => $kelas) {
            foreach ($siswaList->get($index) as $siswa) {
                $siswa->kelas()->attach($kelas->id, ['periode_id' => Periode::id()]);
            }
        }
    }
}
