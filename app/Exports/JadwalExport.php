<?php

namespace App\Exports;

use App\Jadwal;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class JadwalExport extends DefaultValueBinder implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    public function collection()
    {
        return Jadwal::all();
    }

    public function headings(): array
    {
        return [
            'Hari',
            'Jam Mulai',
            'Jam Selesai',
            'Kelas',
            'Mata Pelajaran',
            'Guru',
        ];
    }

    public function map($jadwal): array
    {
        return [
            ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'][$jadwal->hari - 1],
            $jadwal->jam_mulai->format('H:i'),
            $jadwal->jam_selesai->format('H:i'),
            $jadwal->kelas->nama_kelas,
            $jadwal->mapel->nama_mapel,
            $jadwal->guru->nama_guru,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
