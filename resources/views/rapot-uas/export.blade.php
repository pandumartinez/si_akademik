<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Rapor Pengetahuan - Pandu Sanika</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
        }

        h1,
        h2 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 14px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            vertical-align: top;
        }

        th {
            background-color: #f0f0f0;
        }

        .info {
            margin-bottom: 20px;
        }

        .info td {
            border: none;
            padding: 4px;
        }

        .group {
            background-color: #d9e1f2;
            font-weight: bold;
            text-align: left;
        }
    </style>
</head>

<body>
    <table>
        <tr style="border-style: none;">
            <td style="text-align: left; border-style: none;">Nama Sekolah</td>
            <td style="text-align: left; border-style: none;">: SMA YP 17 SURABAYA</td>
            <td style="text-align: left; border-style: none;">Kelas</td>
            <td style="text-align: left; border-style: none;">: {{ $kelas->nama_kelas }}</td>
        </tr>
        <tr>
            <td style="text-align: left; border-style: none;">Alamat</td>
            <td style="text-align: left; border-style: none;">: JL. SIDOTOPO WETAN NO. 112</td>
            <td style="text-align: left; border-style: none;">Semester</td>
            <td style="text-align: left; border-style: none;">: 2 (Dua)</td>
        </tr>
        <tr>
            <td style="text-align: left; border-style: none;">Nama</td>
            <td style="text-align: left; border-style: none;">: {{ $siswa->nama_siswa }}</td>
            <td style="text-align: left; border-style: none;">Tahun Pelajaran</td>
            <td style="text-align: left; border-style: none;">: {{ App\Periode::aktif()->tahun_ajaran }}</td>
        </tr>
        <tr>
            <td style="text-align: left; border-style: none;">NISN / NIS</td>
            <td style="text-align: left; border-style: none;">: {{ $siswa->nis }} / {{ $siswa->nisn }}</td>
        </tr>
    </table>
    <p><strong>A. PENGETAHUAN</strong></p>
    <p><strong>Kriteria Ketuntasan Minimal = 75</strong></p>
    <table>
        <thead>
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2">Mata Pelajaran</th>
                <th colspan="3">Pengetahuan</th>
            </tr>
            <tr>
                <th>Nilai</th>
                <th>Predikat</th>
                <th>Deskripsi</th>
            </tr>
        </thead>
        <tbody>
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
                        <td colspan="5" class="group">{{ $labelMapel[$kelompok] }}</td>
                    </tr>
                    @foreach ($grupMapel[$kelompok] as $mapel)
                        @php
                            $rapotUas = $mapel->rapotUas->first();
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $mapel->nama_mapel }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $rapotUas?->nilai_pengetahuan }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $rapotUas?->predikat_pengetahuan }}</td>
                            <td>{{ $rapotUas?->deskripsi_pengetahuan }}</td>
                        </tr>
                    @endforeach
                @endif
                </tr>
            @endforeach
        </tbody>
    </table>

    <table>
        <tr style="border-style: none;">
            <td style="text-align: left; border-style: none;">Nama Sekolah</td>
            <td style="text-align: left; border-style: none;">: SMA YP 17 SURABAYA</td>
            <td style="text-align: left; border-style: none;">Kelas</td>
            <td style="text-align: left; border-style: none;">: {{ $kelas->nama_kelas }}</td>
        </tr>
        <tr>
            <td style="text-align: left; border-style: none;">Alamat</td>
            <td style="text-align: left; border-style: none;">: JL. SIDOTOPO WETAN NO. 112</td>
            <td style="text-align: left; border-style: none;">Semester</td>
            <td style="text-align: left; border-style: none;">: 2 (Dua)</td>
        </tr>
        <tr>
            <td style="text-align: left; border-style: none;">Nama</td>
            <td style="text-align: left; border-style: none;">: {{ $siswa->nama_siswa }}</td>
            <td style="text-align: left; border-style: none;">Tahun Pelajaran</td>
            <td style="text-align: left; border-style: none;">: {{ App\Periode::aktif()->tahun_ajaran }}</td>
        </tr>
        <tr>
            <td style="text-align: left; border-style: none;">NISN / NIS</td>
            <td style="text-align: left; border-style: none;">: {{ $siswa->nis }} / {{ $siswa->nisn }}</td>
        </tr>
    </table>
    <p><strong>B. KETERAMPILAN</strong></p>
    <p><strong>Kriteria Ketuntasan Minimal = 75</strong></p>
    <table>
        <thead>
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2">Mata Pelajaran</th>
                <th colspan="3">Keterampilan</th>
            </tr>
            <tr>
                <th>Nilai</th>
                <th>Predikat</th>
                <th>Deskripsi</th>
            </tr>
        </thead>
        <tbody>
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
                        <td colspan="5" class="group">{{ $labelMapel[$kelompok] }}</td>
                    </tr>
                    @foreach ($grupMapel[$kelompok] as $mapel)
                        @php
                            $rapotUas = $mapel->rapotUas->first();
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $mapel->nama_mapel }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $rapotUas?->nilai_keterampilan }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ $rapotUas?->predikat_keterampilan }}</td>
                            <td>{{ $rapotUas?->deskripsi_keterampilan }}</td>
                        </tr>
                    @endforeach
                @endif
            @endforeach
        </tbody>
    </table>

    <table>
        <tr style="border-style: none;">
            <td style="text-align: left; border-style: none;">Nama Sekolah</td>
            <td style="text-align: left; border-style: none;">: SMA YP 17 SURABAYA</td>
            <td style="text-align: left; border-style: none;">Kelas</td>
            <td style="text-align: left; border-style: none;">: {{ $kelas->nama_kelas }}</td>
        </tr>
        <tr>
            <td style="text-align: left; border-style: none;">Alamat</td>
            <td style="text-align: left; border-style: none;">: JL. SIDOTOPO WETAN NO. 112</td>
            <td style="text-align: left; border-style: none;">Semester</td>
            <td style="text-align: left; border-style: none;">: 2 (Dua)</td>
        </tr>
        <tr>
            <td style="text-align: left; border-style: none;">Nama</td>
            <td style="text-align: left; border-style: none;">: {{ $siswa->nama_siswa }}</td>
            <td style="text-align: left; border-style: none;">Tahun Pelajaran</td>
            <td style="text-align: left; border-style: none;">: {{ App\Periode::aktif()->tahun_ajaran }}</td>
        </tr>
        <tr>
            <td style="text-align: left; border-style: none;">NISN / NIS</td>
            <td style="text-align: left; border-style: none;">: {{ $siswa->nis }} / {{ $siswa->nisn }}</td>
        </tr>
    </table>

    <p><strong>C. KETIDAKHADIRAN</strong></p>
    <table>
        <tr>
            <td>Sakit</td>
            <td>: {{ $jumlahAbsen['sakit'] }} hari</td>
        </tr>
        <tr>
            <td>Izin</td>
            <td>: {{ $jumlahAbsen['izin'] }} hari</td>
        </tr>
        <tr>
            <td>Tanpa Keterangan</td>
            <td>: {{ $jumlahAbsen['tanpa keterangan'] }} hari</td>
        </tr>
    </table>

    <p><strong>D. CATATAN WALI KELAS</strong></p>
    <p style="min-height: 50px; border: 1px solid #000;"><em>Lanjutkan meraih cita-citamu dan sukses selalu</em></p>

    <p><strong>E. TANGGAPAN ORANG TUA/WALI</strong></p>
    <p style="min-height: 50px; border: 1px solid #000;"></p>

    <h3>Keterangan Kelulusan : Lulus / Tidak Lulus</h3>

    <table style="border: none;">
        <tr style="border: none;">
            <td style="border: none;">Mengetahui<br>Orang Tua/Wali<br><br><br><br><br>.................................
            </td>
            <td style="border: none; text-align: center;">
                Mengetahui<br>Kepala Sekolah<br><br><br><br><br><strong>(Asri Mei Dini Hari, S.Pd)</strong>
            </td>
            <td style="border: none; text-align: center;">
                Surabaya, 9 Oktober 2024<br>Wali Kelas<br><br><br><br><br><strong>(Idris Salim, S.Pd.)</strong>
            </td>
        </tr>
    </table>
</body>

</html>