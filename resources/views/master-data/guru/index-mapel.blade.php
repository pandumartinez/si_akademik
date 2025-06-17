@extends('layouts.app')

@section('heading', 'Data Guru')

@section('breadcrumbs')
    <li class="breadcrumb-item active">Data Guru</li>
@endsection

@section('content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tambah-guru">
                    <i class="nav-icon fas fa-folder-plus"></i>
                    &nbsp;
                    Tambah Data Guru
                </button>
                <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#import-excel">
                    <i class="nav-icon fas fa-file-import"></i>
                    &nbsp;
                    Import Excel
                </button>
                <button type="button" class="btn btn-default btn-sm"
                    onclick="window.location='{{ route('jadwal.export-excel') }}'">
                    <i class="nav-icon fas fa-file-export"></i>
                    &nbsp;
                    Export Excel
                </button>
            </div>

            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Mapel</th>
                            <th>Kelompok</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($mapels as $mapel)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $mapel->nama_mapel }}</td>
                                @if ($mapel->kelompok == "A")
                                    <td>{{ $mapel->kelompok }} (Wajib/Umum)</td>
                                @elseif ($mapel->kelompok == "B")
                                    <td>{{ $mapel->kelompok }} (Peminatan)</td>
                                @else
                                    <td>{{ $mapel->kelompok }} (Lintas Minat)</td>
                                @endif
                                <td>
                                    <a href="{{ route('guru.index', ['mapel' => Crypt::encrypt($mapel->id)]) }}"
                                        class="btn btn-info btn-sm">
                                        <i class="nav-icon fas fa-search-plus"></i>
                                        &nbsp;
                                        Lihat Guru
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="tambah-guru" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Data Guru</h4>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form method="post" action="{{ route('guru.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama_guru">Nama Guru</label>

                                    <input id="nama_guru" type="text" name="nama_guru"
                                        class="form-control @error('nama_guru') is-invalid @enderror"
                                        placeholder="Nama lengkap guru" required>
                                </div>

                                <div class="form-group">
                                    <label for="jk">Jenis Kelamin</label>

                                    <select id="jk" name="jk" class="select2 form-control @error('jk') is-invalid @enderror"
                                        required>
                                        <option value="">-- Pilih jenis kelamin --</option>
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
                                    <label for="nip">NIP</label>

                                    <input id="nip" type="number" name="nip"
                                        class="form-control @error('nip') is-invalid @enderror"
                                        placeholder="Nomor Induk Pegawai" required>
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