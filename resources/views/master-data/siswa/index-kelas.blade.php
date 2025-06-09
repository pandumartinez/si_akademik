@extends('layouts.app')

@section('heading', 'Data Siswa')

@section('breadcrumbs')
    <li class="breadcrumb-item active">Data Siswa</li>
@endsection

@section('content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <button type="button" class="btn btn-primary btn-sm"
                    data-toggle="modal"
                    data-target="#tambah-siswa">
                    <i class="nav-icon fas fa-folder-plus"></i>
                    &nbsp;
                    Tambah Data Siswa
                </button>
            </div>

            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Kelas</th>
                            {{-- <th>Tahun</th> --}}
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kelas as $_kelas)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $_kelas->nama_kelas }}</td>
                                {{-- <td>{{  }}</td> --}}
                                <td>
                                    <a href="{{ route('siswa.index', ['kelas' => Crypt::encrypt($_kelas->id)]) }}"
                                        class="btn btn-info btn-sm">
                                        <i class="nav-icon fas fa-search-plus"></i>
                                        &nbsp;
                                        Lihat Siswa
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="tambah-siswa" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Data Siswa</h4>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form method="post" action="{{ route('siswa.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nis">Nomor Induk</label>

                                    <input id="nis" type="number" name="nis"
                                        class="form-control @error('nis') is-invalid @enderror"
                                        placeholder="Nomor induk siswa"
                                        required>
                                </div>

                                <div class="form-group">
                                    <label for="nama_siswa">Nama Siswa</label>

                                    <input id="nama_siswa" type="text" name="nama_siswa"
                                        class="form-control @error('nama_siswa') is-invalid @enderror"
                                        placeholder="Nama lengkap siswa"
                                        required>
                                </div>

                                <div class="form-group">
                                    <label for="jk">Jenis Kelamin</label>

                                    <select id="jk" name="jk"
                                        class="select2 form-control @error('jk') is-invalid @enderror"
                                        required>
                                        <option value="">-- Pilih Jenis Kelamin --</option>
                                        <option value="L">Laki-Laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="tmp_lahir">Tempat Lahir</label>

                                    <input id="tmp_lahir" type="text" name="tmp_lahir"
                                        class="form-control @error('tmp_lahir') is-invalid @enderror"
                                        placeholder="Tempat lahir">
                                </div>

                                <div class="form-group">
                                    <label for="foto">Foto</label>

                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input id="foto" type="file" name="foto"
                                                class="custom-file-input @error('foto') is-invalid @enderror">

                                            <label class="custom-file-label" for="foto">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nisn">NISN</label>

                                    <input id="nisn" type="number" name="nisn"
                                        class="form-control @error('nisn') is-invalid @enderror"
                                        placeholder="Nomor Induk Siswa Nasional">
                                </div>

                                <div class="form-group">
                                    <label for="kelas_id">Kelas</label>

                                    <select id="kelas_id" name="kelas_id"
                                        class="select2 form-control @error('kelas_id') is-invalid @enderror"
                                        required>
                                        <option value="">-- Pilih Kelas --</option>
                                        @foreach ($kelas as $_kelas)
                                            <option value="{{ $_kelas->id }}">{{ $_kelas->nama_kelas }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="telp">Nomor Telpon/HP</label>

                                    <input id="telp" type="tel" name="telp"
                                        class="form-control @error('telp') is-invalid @enderror"
                                        placeholder="+62XXXXXXXXXXX">
                                </div>

                                <div class="form-group">
                                    <label for="tgl_lahir">Tanggal Lahir</label>

                                    <input id="tgl_lahir" type="date" name="tgl_lahir"
                                        class="form-control @error('tgl_lahir') is-invalid @enderror">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            <i class='nav-icon fas fa-arrow-left'></i>
                            &nbsp;
                            Kembali
                        </button>

                        <button type="submit" class="btn btn-primary">
                            <i class="nav-icon fas fa-save"></i>
                            &nbsp;
                            Tambahkan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
