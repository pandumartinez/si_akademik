<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Capaian Kompetensi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 20px;
        }

        img.logo {
            width: 100px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
        }

        th {
            background-color: #f2f2f2;
        }

        .section-title {
            text-align: left;
            font-weight: bold;
            background-color: #ddd;
        }

        .left {
            text-align: left;
        }

        .no-border {
            border: none;
        }
    </style>
</head>

<body>


    <h3>YAYASAN PENDIDIKAN "TUJUH BELAS" JAWA TIMUR<br>SMA YP 17 SURABAYA<br>TAHUN PELAJARAN 2023 - 2024</h3>
    <h3>LAPORAN CAPAIAN KOMPETENSI</h3>

    <table>
        <tr style="border-style: none;">
            <td style="text-align: left; border-style: none;">Nama Siswa</td>
            <td style="text-align: left; border-style: none;">: {{ $siswa->nama_siswa }}</td>
            <td style="text-align: left; border-style: none;">Kelas</td>
            <td style="text-align: left; border-style: none;">: {{ $kelas->nama_kelas }}</td>
        </tr>
        <tr>
            <td style="text-align: left; border-style: none;">NISN / NIS</td>
            <td style="text-align: left; border-style: none;">: {{ $siswa->nisn }} / {{ $siswa->nis }}</td>
            <td style="text-align: left; border-style: none;">Periode</td>
            <td style="text-align: left; border-style: none;">: {{ App\Periode::aktif() }}</td>
        </tr>
    </table>

    <table>
        <tr>
            <th rowspan="2">No</th>
            <th rowspan="2">Mata Pelajaran</th>
            <th colspan="5">Pengetahuan / Kognitif</th>
            <th rowspan="2">Praktik</th>
            <th rowspan="2">Sikap</th>
        </tr>
        <tr>
            <th>Tugas 1</th>
            <th>Tugas 2</th>
            <th>UH 1</th>
            <th>UH 2</th>
            <th>UTS</th>
        </tr>

        @php
            $grupMapel = $mapels->groupBy('kelompok');
            $labelMapel = [
                'A' => "KELOMPOK A (WAJIB / UMUM)",
                'B' => "KELOMPOK B (PEMINATAN)",
                'C' => "KELOMPOK C (LINTAS MINAT)",
            ];
        @endphp

        @foreach (['A', 'B', 'C'] as $kelompok)
            @if (isset($grupMapel[$kelompok]))
                <tr>
                    <td colspan="11" class="left"><strong>{{ $labelMapel[$kelompok] }}</strong></td>
                </tr>
                <tr>
                    @foreach ($grupMapel[$kelompok] as $mapel)
                        @php
                            $rapotUts = $mapel->rapotUts->first();
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="left">{{ $mapel->nama_mapel }}</td>
                            <td>{{ $rapotUts?->tugas_1 ?? null }}</td>
                            <td>{{ $rapotUts?->tugas_2 ?? null }}</td>
                            <td>{{ $rapotUts?->ulha_1 ?? null }}</td>
                            <td>{{ $rapotUts?->ulha_2 ?? null }}</td>
                            <td>{{ $rapotUts?->uts ?? null }}</td>
                            <td>{{ $rapotUts?->praktik ?? null }}</td>
                            <td>{{ $rapotUts?->sikap ?? null }}</td>
                        </tr>
                    @endforeach
                </tr>
            @endif
        @endforeach

        <tr colspan="4">
            <td></td>
            <td class="left">1. Sakit</td>
            <td class="left" colspan="8">{{ $jumlahAbsen['sakit'] }} Hari</td>
        </tr>
        <tr>
            <td></td>
            <td class="left">2. Ijin</td>
            <td class="left" colspan="8">{{ $jumlahAbsen['izin'] }} Hari</td>
        </tr>
        <tr>
            <td></td>
            <td class="left">3. Tanpa Keterangan</td>
            <td class="left" colspan="8">{{ $jumlahAbsen['tanpa keterangan'] }} Hari</td>
        </tr>
        <tr>
            <td></td>
            <td class="left" rowspan="2">Catatan Wali kelas</td>
            <td colspan="8"></td>
        </tr>
    </table>

    <br><br>
    <table style="border: none;">
        <tr style="border: none;">
            <td style="border: none;">Orang Tua / Wali Siswa<br><br><br><br><br><br>.................................
            </td>
            <td style="border: none; text-align: center;">
                Mengetahui<br>Kepala SMA YP 17 Surabaya<br><br><br><br><br><br><strong>(Asri Mei Dini Hari,
                    S.Pd)</strong>
            </td>
            <td style="border: none; text-align: center;">
                Surabaya, 9 Oktober 2024<br>Wali Kelas<br><br><br><br><br><br><strong>(Idris Salim, S.Pd.)</strong>
            </td>
        </tr>
    </table>

</body>

</html>