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

    <img src="{{ asset('img/emblem.png') }}" alt="Logo" class="logo">
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
            <td style="text-align: left; border-style: none;">: {{ $siswa->nis }} / {{ $siswa->nisn }}</td>
            <td style="text-align: left; border-style: none;">Periode</td>
            <td style="text-align: left; border-style: none;">: {{ App\Periode::aktif() }}</td>
        </tr>
        <tr>
            <td class="no-border" colspan="2" style="text-align: left;">
                Nama Siswa: <strong></strong><br>
                NIS / NISN: <strong>{{ $siswa->nis }} / {{ $siswa->nisn }}</strong><br>
                Kelas: <strong>{{ $kelas->nama_kelas }}</strong><br>
                Semester: <strong>{{ App\Periode::aktif() }}</strong>
            </td>
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

        <!-- Kelompok A -->
        <!-- <tr>
            <td colspan="11" class="left"><strong>KELOMPOK A (WAJIB / UMUM)</strong></td>
        </tr> -->
        <tr>
            @foreach ($mapels as $mapel)
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
        <tr colspan="4">
            <td></td>
            <td class="left">1. Sakit</td>
            <td class="left" colspan="8">0 Hari</td>
        </tr>
        <tr>
            <td></td>
            <td class="left">2. Ijin</td>
            <td class="left" colspan="8">0 Hari</td>
        </tr>
        <tr>
            <td></td>
            <td class="left">3. Tanpa Keterangan</td>
            <td class="left" colspan="8">0 Hari</td>
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
            <td style="border: none;">Orang Tua / Wali Siswa<br><br><br>.................................</td>
            <td style="border: none; text-align: center;">
                Mengetahui<br>Kepala SMA YP 17 Surabaya<br><br><br><strong>(Asri Mei Dini Hari, S.Pd)</strong>
            </td>
            <td style="border: none; text-align: center;">
                Surabaya, 9 Oktober 2024<br>Wali Kelas<br><br><br><strong>(Idris Salim, S.Pd.)</strong>
            </td>
        </tr>
    </table>

</body>

</html>