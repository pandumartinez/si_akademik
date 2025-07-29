@extends('layouts.app')

@section('heading', 'Edit Guru')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('guru.index') }}">Data Guru</a></li>
    <li class="breadcrumb-item active">Edit Guru</li>
@endsection

@section('content')
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Edit Data Guru</h3>
            </div>

            <form method="post" action="{{ route('guru.update', $guru->id) }}">
                @csrf
                @method('patch')

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_guru">Nama Guru</label>

                                <input id="nama_guru" type="text" name="nama_guru"
                                    class="form-control @error('nama_guru') is-invalid @enderror"
                                    placeholder="Nama lengkap guru" value="{{ $guru->nama_guru }}" required>
                            </div>

                            <div class="form-group">
                                <label for="jk">Jenis Kelamin</label>

                                <select id="jk" name="jk" class="select2 form-control @error('jk') is-invalid @enderror"
                                    required>
                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                    <option @if ($guru->jk == 'L') selected @endif value="L">
                                        Laki-Laki
                                    </option>
                                    <option @if ($guru->jk == 'P') selected @endif value="P">
                                        Perempuan
                                    </option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="jabatan">Jabatan</label>

                                <select id="jabatan" name="jabatan[]" multiple="multiple"
                                    class="select2 form-control @error('jabatan') is-invalid @enderror">
                                    <option value="">-- Pilih jabatan --</option>
                                    @foreach ($jabatanList as $jabatan)
                                        <option value="{{ $jabatan->id }}" @if ($guru->jabatan->contains($jabatan)) selected
                                        @endif>
                                            {{ $jabatan->nama_jabatan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="tmp_lahir">Tempat Lahir</label>

                                <input id="tmp_lahir" type="text" name="tmp_lahir"
                                    class="form-control @error('tmp_lahir') is-invalid @enderror" placeholder="Tempat lahir"
                                    value="{{ $guru->tmp_lahir }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nip">NIP</label>

                                <input id="nip" type="text" class="form-control" value="{{ $guru->nip }}" readonly>
                            </div>

                            <div class="form-group">
                                <label for="telp">Nomor Telepon/HP</label>

                                <input id="telp" type="tel" name="telp"
                                    class="form-control @error('telp') is-invalid @enderror" placeholder="+62XXXXXXXXXXX"
                                    value="{{ $guru->telp }}">
                            </div>

                            <div class="form-group">
                                <label for="tgl_lahir">Tanggal Lahir</label>

                                <input id="tgl_lahir" type="date" name="tgl_lahir"
                                    class="form-control @error('tgl_lahir') is-invalid @enderror"
                                    placeholder="Tanggal lahir"
                                    value="{{ $guru->tgl_lahir ? $guru->tgl_lahir->format('Y-m-d') : null }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <a href="{{ session('guru_index_url', url()->previous()) }}" class="btn btn-default">
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