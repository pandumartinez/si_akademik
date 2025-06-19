<?php

namespace App\Imports;

use App\Guru;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithSkipDuplicates;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class GuruImport implements ToModel, WithHeadingRow, WithBatchInserts, WithSkipDuplicates
{
    public function model(array $row)
    {
        $guru = new Guru([
            'nip' => $row['nip'],

            'nama_guru' => $row['nama_guru'],

            'jk' => $row['jenis_kelamin'],

            'telp' => $row['nomor_teleponhp'],

            'tmp_lahir' => $row['tempat_lahir'],

            'tgl_lahir' => Carbon::instance(Date::excelToDateTimeObject($row['tanggal_lahir'])),

            'foto' => $row['jenis_kelamin'] === 'L'
                ? 'uploads/guru/35251431012020_male.jpg'
                : 'uploads/guru/23171022042020_female.jpg'
        ]);

        return $guru;
    }

    public function batchSize(): int
    {
        return 1000;
    }
}
