<?php

namespace App\Exports;

use App\Guru;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RapotUtsExport extends DefaultValueBinder implements FromCollection, WithHeadings, WithMapping, WithCustomValueBinder, ShouldAutoSize, WithColumnFormatting, WithStyles
{
    public function collection()
    {
        return Guru::all();
    }

    public function headings(): array
    {
        return [
            'NIP',
            'Nama Guru',
            'Jenis Kelamin',
            'Nomor Telepon/HP',
            'Tempat Lahir',
            'Tanggal Lahir',
        ];
    }

    public function map($guru): array
    {
        return [
            $guru->nip,
            $guru->nama_guru,
            $guru->jk === 'L' ? 'Laki-laki' : 'Perempuan',
            $guru->telp,
            $guru->tmp_lahir,
            Date::dateTimeToExcel($guru->tgl_lahir),
        ];
    }

    public function bindValue(Cell $cell, $value)
    {
        if ($cell->getColumn() === 'D') {
            $cell->setValueExplicit($value, DataType::TYPE_STRING);

            return true;
        }

        return parent::bindValue($cell, $value);
    }

    public function columnFormats(): array
    {
        return [
            'F' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
