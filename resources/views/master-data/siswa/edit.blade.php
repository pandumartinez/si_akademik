@extends('layouts.app')

@section('heading', 'Edit Siswa')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('siswa.index') }}">Data Siswa</a></li>
    <li class="breadcrumb-item active">Edit Siswa</li>
@endsection

@section('content')
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Edit Data Siswa</h3>
            </div>

            <form method="post" action="{{ route('siswa.update', $siswa->id) }}">
                @csrf
                @method('patch')

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nis">Nomor Induk</label>

                                <input id="nis" type="text" name="nis"
                                    class="form-control"
                                    value="{{ $siswa->nis }}"
                                    readonly>
                            </div>

                            <div class="form-group">
                                <label for="nama_siswa">Nama Siswa</label>

                                <input id="nama_siswa" type="text" name="nama_siswa"
                                    class="form-control @error('nama_siswa') is-invalid @enderror"
                                    placeholder="Nama lengkap siswa"
                                    value="{{ $siswa->nama_siswa }}"
                                    required>
                            </div>

                            <div class="form-group">
                                <label for="jk">Jenis Kelamin</label>

                                <select id="jk" name="jk"
                                    class="select2 form-control @error('jk') is-invalid @enderror"
                                    required>
                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                    <option
                                        @if ($siswa->jk == 'L') selected @endif
                                        value="L">
                                        Laki-Laki
                                    </option>
                                    <option
                                        @if ($siswa->jk == 'P') selected @endif
                                        value="P">
                                        Perempuan
                                    </option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="tmp_lahir">Tempat Lahir</label>

                                <input id="tmp_lahir" type="text" name="tmp_lahir"
                                    class="form-control @error('tmp_lahir') is-invalid @enderror"
                                    placeholder="Tempat lahir"
                                    value="{{ $siswa->tmp_lahir }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nisn">NISN</label>

                                <input id="nisn" type="text" name="nisn"
                                    class="form-control @error('nisn') is-invalid @enderror"
                                    placeholder="Nomor Induk Siswa Nasional"
                                    value="{{ $siswa->nisn }}">
                            </div>

                            <div class="form-group">
                                <label for="kelas_id">Kelas</label>

                                <select id="kelas_id" name="kelas_id"
                                    class="select2 form-control @error('kelas_id') is-invalid @enderror"
                                    required>
                                    <option value="">-- Pilih Kelas --</option>
                                    @foreach ($kelas as $_kelas)
                                        <option
                                            @if ($siswa->kelas->id == $_kelas->id) selected @endif
                                            value="{{ $_kelas->id }}">
                                            {{ $_kelas->nama_kelas }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="telp">Nomor Telpon/HP</label>

                                <input id="telp" type="tel" name="telp"
                                    class="form-control @error('telp') is-invalid @enderror"
                                    placeholder="+62XXXXXXXXXXX"
                                    value="{{ $siswa->telp }}">
                            </div>

                            <div class="form-group">
                                <label for="tgl_lahir">Tanggal Lahir</label>

                                <input id="tgl_lahir" type="date" name="tgl_lahir"
                                    class="form-control @error('tgl_lahir') is-invalid @enderror"
                                    placeholder="Tanggal lahir"
                                    value="{{ $siswa->tgl_lahir ? $siswa->tgl_lahir->format('Y-m-d') : null }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <a href="{{ session('siswa_index_url', url()->previous()) }}" class="btn btn-default">
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
