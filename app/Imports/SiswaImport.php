<?php

namespace App\Imports;

use App\Kelas;
use App\Periode;
use App\Siswa;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Row;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class SiswaImport implements OnEachRow, WithHeadingRow
{

    public function onRow(Row $row)
    {
        $siswa = Siswa::updateOrCreate(
            [
                'nis' => $row['nis'],
            ],
            [
                'nisn' => $row['nisn'],

                'nama_siswa' => $row['nama_siswa'],

                'jk' => $row['jenis_kelamin'],

                'telp' => $row['nomor_teleponhp'],

                'tmp_lahir' => $row['tempat_lahir'],

                'tgl_lahir' => Carbon::instance(Date::excelToDateTimeObject($row['tanggal_lahir'])),

                'foto' => $row['jenis_kelamin'] === 'L'
                    ? 'uploads/guru/35251431012020_male.jpg'
                    : 'uploads/guru/23171022042020_female.jpg'
            ]
        );

        $kelas = Kelas::firstWhere('nama_kelas', '=', $row['kelas']);

        $siswa->kelas()->sync([
            $kelas->id => ['periode_id' => Periode::id()]
        ]);

        return $siswa;
    }
}
