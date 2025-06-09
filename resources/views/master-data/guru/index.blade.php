@extends('layouts.app')

@section('heading', "Data Guru $mapel->nama_mapel")

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('guru.index') }}">Data Guru</a></li>
    <li class="breadcrumb-item active">{{ $mapel->nama_mapel }}</li>
@endsection

@section('content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('guru.index') }}" class="btn btn-default btn-sm">
                    <i class="nav-icon fas fa-arrow-left"></i>
                    &nbsp;
                    Kembali
                </a>
            </div>

            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>NIP</th>
                            <th>Foto</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($mapel->guru as $guru)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $guru->nama_guru }}</td>
                                <td>{{ $guru->nip }}</td>
                                <td>
                                    <a href="{{ asset($guru->foto) }}"
                                        data-toggle="lightbox"
                                        data-title="Foto {{ $guru->nama_guru }}"
                                        data-gallery="gallery"
                                        data-footer='
                                            <a href="{{ route('guru.edit.foto', Crypt::encrypt($guru->id)) }}"
                                                class="btn btn-link btn-block btn-light">
                                                <i class="nav-icon fas fa-file-upload"></i>
                                                &nbsp;
                                                Ubah Foto
                                            </a>'>
                                        <img src="{{ asset($guru->foto) }}" class="img-fluid mb-2"
                                            style="height: 12rem;">
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('guru.show', Crypt::encrypt($guru->id)) }}"
                                        class="btn btn-info btn-sm">
                                        <i class="nav-icon fas fa-id-card"></i>
                                        &nbsp;
                                        Detail
                                    </a>

                                    <a href="{{ route('guru.edit', Crypt::encrypt($guru->id)) }}"
                                        class="btn btn-success btn-sm">
                                        <i class="nav-icon fas fa-edit"></i>
                                        &nbsp;
                                        Edit
                                    </a>

                                    <button type="submit" form="{{ $loop->iteration }}-guru-destroy"
                                        class="btn btn-danger btn-sm">
                                        <i class="nav-icon fas fa-trash-alt"></i>
                                        &nbsp;
                                        Hapus
                                    </button>

                                    <form id="{{ $loop->iteration }}-guru-destroy"
                                        method="post" action="{{ route('guru.destroy', $guru->id) }}">
                                        @csrf
                                        @method('delete')
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
