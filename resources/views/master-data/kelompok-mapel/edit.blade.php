@extends('layouts.app')

@section('heading', 'Edit Kelompok Mapel')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('kelompok-mapel.index') }}">Mapel</a></li>
    <li class="breadcrumb-item active">Edit Kelompok Mapel</li>
@endsection

@section('content')
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Edit Kelompok Mapel</h3>
            </div>

            <form method="post" action="{{ route('kelompok-mapel.update', $kelompokMapel->id) }}">
                @csrf
                @method('patch')

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="kode_kelompok">Kode Kelompok</label>

                                <input id="kode_kelompok" type="text" name="kode_kelompok"
                                    class="form-control @error('kode_kelompok') is-invalid @enderror"
                                    placeholder="Kode kelompok mapel"
                                    value="{{ $kelompokMapel->kode }}"
                                    disabled>
                            </div>

                            <div class="form-group">
                                <label for="nama_kelompok">Nama Kelompok</label>

                                <input id="nama_kelompok" type="text" name="nama_kelompok"
                                    class="form-control @error('nama_kelompok') is-invalid @enderror"
                                    placeholder="Nama kelompok mapel"
                                    value="{{ $kelompokMapel->nama_kelompok }}"
                                    required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <a href="{{ route('kelompok-mapel.index') }}" class="btn btn-default">
                        <i class='nav-icon fas fa-arrow-left'></i>
                        &nbsp;
                        Kembali
                    </a>
                    &nbsp;
                    <button type="submit" class="btn btn-primary">
                        <i class="nav-icon fas fa-save"></i>
                        &nbsp;
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
