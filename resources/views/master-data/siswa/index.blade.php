@extends('layouts.app')

@section('heading', "Data Siswa $kelas->nama_kelas")

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('siswa.index') }}">Siswa</a></li>
    <li class="breadcrumb-item active">{{ $kelas->nama_kelas }}</li>
@endsection

@section('content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('siswa.index') }}" class="btn btn-default btn-sm">
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
                            <th>No. Induk</th>
                            <th>Foto</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kelas->siswa as $siswa)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $siswa->nama_siswa }}</td>
                                <td>{{ $siswa->nis }}</td>
                                <td>
                                    <a href="{{ asset($siswa->foto) }}"
                                        data-toggle="lightbox"
                                        data-title="Foto {{ $siswa->nama_siswa }}"
                                        data-gallery="gallery"
                                        data-footer='
                                            <a href="{{ route('siswa.edit.foto', Crypt::encrypt($siswa->id)) }}"
                                                class="btn btn-link btn-block btn-light">
                                                <i class="nav-icon fas fa-file-upload"></i>
                                                &nbsp;
                                                Ubah Foto
                                            </a>'>
                                        <img src="{{ asset($siswa->foto) }}" class="img-fluid mb-2"
                                            style="height: 12rem;">
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('siswa.show', Crypt::encrypt($siswa->id)) }}"
                                        class="btn btn-info btn-sm">
                                        <i class="nav-icon fas fa-id-card"></i>
                                        &nbsp;
                                        Detail
                                    </a>

                                    <a href="{{ route('siswa.edit', Crypt::encrypt($siswa->id)) }}"
                                        class="btn btn-success btn-sm">
                                        <i class="nav-icon fas fa-edit"></i>
                                        &nbsp;
                                        Edit
                                    </a>

                                    <button type="submit" form="{{ $loop->iteration }}-siswa-destroy"
                                        class="btn btn-danger btn-sm">
                                        <i class="nav-icon fas fa-trash-alt"></i>
                                        &nbsp;
                                        Hapus
                                    </button>

                                    <form id="{{ $loop->iteration }}-siswa-destroy"
                                        method="post" action="{{ route('siswa.destroy', $siswa->id) }}">
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
