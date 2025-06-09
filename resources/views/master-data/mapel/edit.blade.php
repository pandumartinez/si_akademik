@extends('layouts.app')

@section('heading', 'Edit Mapel')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('mapel.index') }}">Mapel</a></li>
    <li class="breadcrumb-item active">Edit Mapel</li>
@endsection

@section('content')
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Edit Data Mapel</h3>
            </div>

            <form method="post" action="{{ route('mapel.update', $mapel->id) }}">
                @csrf
                @method('patch')

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="nama_mapel">Nama Mapel</label>

                                <input id="nama_mapel" type="text" name="nama_mapel"
                                    class="form-control @error('nama_mapel') is-invalid @enderror"
                                    placeholder="Nama mata pelajaran"
                                    value="{{ $mapel->nama_mapel }}"
                                    required>
                            </div>

                            <div class="form-group">
                                <label for="kelompok">Kelompok</label>

                                <select id="kelompok" name="kelompok"
                                    class="select2 form-control @error('kelompok') is-invalid @enderror"
                                    required>
                                    <option value="">-- Pilih kelompok mapel --</option>
                                    <option
                                        @if ($mapel->kelompok === 'A') selected @endif
                                        value="A">
                                        Pelajaran Wajib/Umum
                                    </option>
                                    <option
                                        @if ($mapel->kelompok === 'B') selected @endif
                                        value="B">
                                        Pelajaran Peminatan
                                    </option>
                                    <option
                                        @if ($mapel->kelompok === 'C') selected @endif
                                        value="C">
                                        Pelajaran Lintas Minat
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <a href="{{ route('mapel.index') }}" class="btn btn-default">
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
