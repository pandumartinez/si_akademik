@extends('layouts.app')

@section('heading', 'Trash Siswa')

@section('breadcrumbs')
    <li class="breadcrumb-item active">Trash Siswa</li>
@endsection

@section('content')
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Trash Data Siswa</h3>
            </div>

            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Siswa</th>
                            <th>No. Induk</th>
                            <th>Kelas</th>
                            <th>Foto</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($siswas as $siswa)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $siswa->nama_siswa }}</td>
                                <td>{{ $siswa->nis }}</td>
                                <td>{{ $siswa->kelas->nama_kelas }}</td>
                                <td>
                                    <a href="{{ asset($siswa->foto) }}"
                                        data-toggle="lightbox"
                                        data-title="Foto {{ $siswa->nama_siswa }}"
                                        data-gallery="gallery">
                                        <img src="{{ asset($siswa->foto) }}" class="img-fluid mb-2"
                                            style="height: 12rem;">
                                    </a>
                                </td>
                                <td>
                                    <button type="submit" form="{{ $loop->iteration }}-siswa-restore"
                                        class="btn btn-success btn-sm">
                                        <i class="nav-icon fas fa-undo"></i>
                                        &nbsp;
                                        Restore
                                    </button>

                                    <button type="submit" form="{{ $loop->iteration }}-siswa-destroy"
                                        class="btn btn-danger btn-sm">
                                        <i class="nav-icon fas fa-trash-alt"></i>
                                        &nbsp;
                                        Hapus
                                    </button>

                                    <form id="{{ $loop->iteration }}-siswa-restore"
                                        method="post" action="{{ route('siswa.restore', $siswa->id) }}">
                                        @csrf
                                    </form>

                                    <form id="{{ $loop->iteration }}-siswa-destroy"
                                        method="post" action="{{ route('siswa.destroy.permanent', $siswa->id) }}">
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
