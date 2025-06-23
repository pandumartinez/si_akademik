<?php

namespace Database\Seeders;

use App\Mapel;
use Illuminate\Database\Seeder;

class MapelSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'A' => [
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
            'B' => [
                'Matematika',
                'Biologi',
                'Fisika',
                'Kimia',
                'Sejarah',
                'Ekonomi',
                'Geografi',
                'Sosiologi',
            ],
            'C' => [
                'Matematika LM',
                'Biologi LM',
                'Fisika LM',
                'Kimia LM',
                'Sejarah LM',
                'Ekonomi LM',
                'Geografi LM',
                'Sosiologi LM',
            ],
        ];

        foreach ($data as $kelompok => $mapel) {
            foreach ($mapel as $nama_mapel) {
                Mapel::create(compact('nama_mapel', 'kelompok'));
            }
        }
    }
}
