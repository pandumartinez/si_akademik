@extends('layouts.app')

@section('heading', 'Details Guru')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ url()->previous() }}">Data Guru</a></li>
    <li class="breadcrumb-item active">Details Guru</li>
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
                        <img src="{{ asset($guru->foto) }}" style="height: 12rem;">
                    </div>

                    <div class="col-md-8">
                        <dl class="row">
                            <dt class="col-sm-4">Nama Lengkap</dt>
                            <dd class="col-sm-8">{{ $guru->nama_guru }}</dd>

                            <dt class="col-sm-4">Nomor Induk Pegawai (NIP)</dt>
                            <dd class="col-sm-8">{{ $guru->nip }}</dd>

                            <dt class="col-sm-4">Jabatan</dt>
                            <dd class="col-sm-8">
                                <ul>
                                    @foreach ($guru->jabatan as $jabatan)
                                        <li>{{ $jabatan->nama_jabatan}}</li>
                                    @endforeach
                                </ul>
                            </dd>

                            <dt class="col-sm-4">Mata Pelajaran</dt>
                            <dd class="col-sm-8">
                                <ul>
                                    @foreach ($guru->mapel as $mapel)
                                        <li>{{ $mapel->nama_mapel }}</li>
                                    @endforeach
                                </ul>
                            </dd>

                            <dt class="col-sm-4">Jenis Kelamin</dt>
                            <dd class="col-sm-8">
                                {{ $guru->jk === 'L' ? 'Laki-laki' : 'Perempuan' }}
                            </dd>

                            <dt class="col-sm-4">Tempat, Tanggal Lahir</dt>
                            <dd class="col-sm-8">
                                @if ($guru->tmp_lahir && $guru->tgl_lahir)
                                    {{ $guru->tmp_lahir }}, {{ $guru->tgl_lahir->format('d F Y') }}
                                @else
                                    -
                                @endif
                            </dd>

                            <dt class="col-sm-4">No. Telepon</dt>
                            <dd class="col-sm-8">
                                {{ $guru->telp ?? '-' }}
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection