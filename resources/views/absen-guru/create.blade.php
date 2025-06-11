@extends('layouts.app')

@section('heading')
    Absen Harian Guru
@endsection

@section('breadcrumbs')
    <li class="breadcrumb-item active">Absensi Guru</li>
@endsection

@section('content')
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Hari</th>
                            <th>Waktu</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($absens as $absen)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $absen->created_at->translatedFormat('l') }}</td>
                                <td>{{ $absen->created_at->format('H:i') }}</td>
                                <td>{{ ucwords($absen->keterangan) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Absen Harian Guru</h3>
            </div>

            <form method="post" action="{{ route('absen-guru.store') }}">
                @csrf
                <div class="card-body">
                    @if (!$absenHariIni)
                        <div class="form-group">
                            <label for="keterangan">Keterangan Kehadiran</label>

                            <select id="keterangan" name="keterangan"
                                class="select2 form-control @error('jk') is-invalid @enderror" required>
                                <option value="">-- Pilih Keterangan Kehadiran --</option>
                                @if ($absenHariIni && in_array($absenHariIni->keterangan, ['terlambat', 'hadir']))
                                    <option value="selesai mengajar">Selesai Mengajar</option>
                                @elseif (date('H:i') > '07:00')
                                    <option value="terlambat">Terlambat</option>
                                @else
                                    <option value="hadir">Hadir</option>
                                @endif
                                @if (!$absenHariIni)
                                    <option value="sakit">Sakit</option>
                                    <option value="izin">Izin</option>
                                    <option value="bertugas keluar">Bertugas keluar</option>
                                @endif
                            </select>
                        </div>
                    @elseif ($absenHariIni && $absenHariIni->keterangan === 'selesai mengajar')
                        <p class="mb-0">Anda telah selesai mengajar untuk hari ini.</p>
                    @elseif ($absenHariIni && in_array($absenHariIni->keterangan, ['sakit', 'izin', 'bertugas keluar']))
                        <p class="mb-0">Anda {{ $absenHariIni->keterangan }} hari ini.</p>
                    @endif
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary" @if ($absenHariIni && !in_array($absenHariIni->keterangan, ['hadir', 'terlambat'])) disabled @endif>
                        <i class="nav-icon fas fa-save"></i>
                        &nbsp;
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection