@extends('layouts.app')

@section('heading', 'Details Siswa')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ url()->previous() }}">Data Siswa</a></li>
    <li class="breadcrumb-item active">Details Siswa</li>
@endsection

@section('content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <a href="{{ url()->previous() }}" class="btn btn-default btn-sm">
                    <i class='nav-icon fas fa-arrow-left'></i>
                    &nbsp;
                    Kembali
                </a>
            </div>

            <div class="card-body">
                <div class="row no-gutters ml-2 mb-2 mr-2">
                    <div class="col-md-4">
                        <img src="{{ asset($siswa->foto) }}" style="height: 12rem;">
                    </div>

                    <div class="col-md-8">
                        <dl class="row">
                            <dt class="col-sm-4">Nama</dt>
                            <dd class="col-sm-8">{{ $siswa->nama_siswa }}</dd>

                            <dt class="col-sm-4">No. Induk</dt>
                            <dd class="col-sm-8">{{ $siswa->nis }}</dd>

                            <dt class="col-sm-4">Nomor Induk Siswa Nasional (NISN)</dt>
                            <dd class="col-sm-8">{{ $siswa->nisn }}</dd>

                            <dt class="col-sm-4">Kelas</dt>
                            <dd class="col-sm-8">{{ $siswa->kelas->nama_kelas }}</dd>

                            <dt class="col-sm-4">Jenis Kelamin</dt>
                            <dd class="col-sm-8">
                                {{ $siswa->jk === 'L' ? 'Laki-laki' : 'Perempuan' }}
                            </dd>

                            <dt class="col-sm-4">Tempat, Tanggal Lahir</dt>
                            <dd class="col-sm-8">
                                @if ($siswa->tmp_lahir && $siswa->tgl_lahir)
                                    {{ $siswa->tmp_lahir }}, {{ $siswa->tgl_lahir->format('d F Y') }}
                                @else
                                    -
                                @endif
                            </dd>

                            <dt class="col-sm-4">No. Telepon</dt>
                            <dd class="col-sm-8">
                                {{ $siswa->telp ?? '-' }}
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
