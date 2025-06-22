<?php

namespace App\Imports;

use App\Kelas;
use App\Guru;
use App\Mapel;
use App\Jadwal;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Row;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class JadwalImport implements OnEachRow, WithHeadingRow
{
    private const NAMA_HARI = [
        'senin' => 1,
        'selasa' => 2,
        'rabu' => 3,
        'kamis' => 4,
        'jumat' => 5,
    ];

    public function onRow(Row $row)
    {
        $hari = JadwalImport::NAMA_HARI[strtolower($row['hari'])];

        $kelas = Kelas::firstWhere('nama_kelas', '=', $row['kelas']);

        $mapel = Mapel::firstWhere('nama_mapel', '=', $row['mapel']);

        $guru = Guru::firstWhere('nama_guru', '=', $row['guru']);

        $jadwal = Jadwal::updateOrCreate(
            [
                'hari' => $hari,

                'jam_mulai' => Date::excelToDateTimeObject($row['jam_mulai']),

                'jam_selesai' => Date::excelToDateTimeObject($row['jam_selesai']),
            ],
            [
                'kelas_id' => $kelas->id,

                'mapel_id' => $mapel->id,

                'guru_id' => $guru->id,
            ]
        );

        return $jadwal;
    }
}
