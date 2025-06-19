@extends('layouts.app')

@section('heading', 'Trash Guru')

@section('breadcrumbs')
    <li class="breadcrumb-item active">Trash Guru</li>
@endsection

@section('content')
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Trash Data Guru</h3>
            </div>

            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Guru</th>
                            <th>NIP</th>
                            <th>Foto</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($gurus as $guru)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $guru->nama_guru }}</td>
                                <td>{{ $guru->nip }}</td>
                                <td>
                                    <a href="{{ asset($guru->foto) }}"
                                        data-toggle="lightbox"
                                        data-title="Foto {{ $guru->nama_guru }}"
                                        data-gallery="gallery">
                                        <img src="{{ asset($guru->foto) }}" class="img-fluid mb-2">
                                    </a>
                                </td>
                                <td>
                                    <button type="submit" form="{{ $loop->iteration }}-guru-restore"
                                        class="btn btn-success btn-sm">
                                        <i class="nav-icon fas fa-undo"></i>
                                        &nbsp;
                                        Restore
                                    </button>

                                    <button type="submit" form="{{ $loop->iteration }}-guru-destroy"
                                        class="btn btn-danger btn-sm">
                                        <i class="nav-icon fas fa-trash-alt"></i>
                                        &nbsp;
                                        Hapus
                                    </button>

                                    <form id="{{ $loop->iteration }}-guru-restore"
                                        method="post" action="{{ route('guru.restore', $guru->id) }}">
                                        @csrf
                                    </form>

                                    <form id="{{ $loop->iteration }}-guru-destroy"
                                        method="post" action="{{ route('guru.destroy.permanent', $guru->id) }}">
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
