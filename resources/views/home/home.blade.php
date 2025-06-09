@extends('layouts.app')

@section('heading')
    Hari {{ \Carbon\Carbon::now()->translatedFormat('l, j F') }}
@endsection

@section('breadcrumbs')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
    @if ($pengumuman)
        <div class="col-md-12">
            <div class="callout callout-info">
                <h5>Pengumuman!</h5>

                <p>{!! $pengumuman !!}</p>
            </div>
        </div>
    @endif

    <div class="col-md-12">
        <div class="card">
            <div class="card-body p-0">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Jam Pelajaran</th>
                            <th>Mata Pelajaran</th>
                            <th>Kelas</th>
                            <th>Ket.</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($jadwals as $jadwal)
                            <tr>
                                <td>
                                    <h6 class="mb-0">
                                        {{ $jadwal->jam_mulai->format('H:i') }}
                                        &ndash;
                                        {{ $jadwal->jam_selesai->format('H:i') }}
                                    </h6>
                                </td>
                                <td>
                                    <h6 class="mb-0 text-muted">{{ $jadwal->guru->nama_guru }}</h6>
                                    <h5 class="mb-0">{{ $jadwal->mapel->nama_mapel }}</h5>
                                </td>
                                <td>
                                    <h6 class="mb-0">{{ $jadwal->kelas->nama_kelas }}</h6>
                                </td>
                                <td>
                                    <span class="badge badge-success">kehadiran</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
