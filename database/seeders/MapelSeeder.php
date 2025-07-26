<?php

namespace Database\Seeders;

use App\KelompokMapel;
use App\Mapel;
use Illuminate\Database\Seeder;

class MapelSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'kelompok' => [
                    'nama_kelompok' => 'Wajib/Umum',
                    'kode' => 'A',
                ],
                'mapel' => [
                    'Bahasa Indonesia',
                    'Bahasa Inggris',
                    'Informatika',
                    'Matematika Wajib',
                    'Muatan Lokal: Bahasa Daerah',
                    'Pendidikan Agama dan Budi Pekerti',
                    'Pendidikan Jasmani, Olah Raga, dan Kesehatan',
                    'Pendidikan Pancasila dan Kewarganegaraan',
                    'Prakarya dan Kewirausahaan',
                    'Sejarah Indonesia',
                    'Seni Budaya',
                ],
            ],
            [
                'kelompok' => [
                    'nama_kelompok' => 'Peminatan',
                    'kode' => 'B',
                ],
                'mapel' => [
                    'Matematika',
                    'Biologi',
                    'Fisika',
                    'Kimia',
                    'Sejarah',
                    'Ekonomi',
                    'Geografi',
                    'Sosiologi',
                ],
            ],
            [
                'kelompok' => [
                    'nama_kelompok' => 'Lintas Minat',
                    'kode' => 'C',
                ],
                'mapel' => [
                    'Matematika LM',
                    'Biologi LM',
                    'Fisika LM',
                    'Kimia LM',
                    'Sejarah LM',
                    'Ekonomi LM',
                    'Geografi LM',
                    'Sosiologi LM',
                ],
            ],
        ];

        foreach ($data as $datum) {
            $kelompokMapel = KelompokMapel::create($datum['kelompok']);

            foreach ($datum['mapel'] as $nama_mapel) {
                Mapel::create([
                    'nama_mapel' => $nama_mapel,
                    'kelompok_mapel' => $kelompokMapel->id,
                ]);
            }
        }
    }
}
