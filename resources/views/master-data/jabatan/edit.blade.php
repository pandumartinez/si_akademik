@extends('layouts.app')

@section('heading', 'Edit Jabatan')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('jabatan.index') }}">Guru</a></li>
    <li class="breadcrumb-item active">Edit Jabatan</li>
@endsection

@section('content')
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Edit Jabatan</h3>
            </div>

            <form method="post" action="{{ route('jabatan.update', $jabatans->id) }}">
                @csrf
                @method('patch')

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="nama_jabatan">Nama Jabatan</label>

                                <input id="nama_jabatan" type="text" name="nama_jabatan"
                                    class="form-control @error('nama_jabatan') is-invalid @enderror"
                                    placeholder="Kode kelompok mapel"
                                    value="{{ $jabatans->nama_jabatan }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <a href="{{ route('jabatan.index') }}" class="btn btn-default">
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
