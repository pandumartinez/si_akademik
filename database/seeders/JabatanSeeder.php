<?php

namespace Database\Seeders;

use App\Jabatan;
use Illuminate\Database\Seeder;

class JabatanSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // Jabatan Struktural
            'Kepala Sekolah',
            'Wakil Kepala Sekolah Bidang Kurikulum',
            'Wakil Kepala Sekolah Bidang Kesiswaan',
            'Wakil Kepala Sekolah Bidang Sarana dan Prasarana',
            'Wakil Kepala Sekolah Bidang Humas',

            // Jabatan Fungsional
            'Guru Mata Pelajaran',
            'Guru BK (Bimbingan dan Konseling)',
            'Wali Kelas',
            'Guru Piket',

            // Jabatan Non-Akademik
            'Pembina OSIS',
            'Pelatih Ekstrakurikuler',
            'Penanggung Jawab UKS',
        ];

        foreach ($data as $nama_jabatan) {
            Jabatan::create(compact('nama_jabatan'));
        }
    }
}
