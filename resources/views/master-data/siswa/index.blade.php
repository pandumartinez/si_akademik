@extends('layouts.app')

@section('heading', "Data Siswa $kelas->nama_kelas")

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('kelas.index') }}">Kelas</a></li>
    <li class="breadcrumb-item active">{{ $kelas->nama_kelas }}</li>
    <li class="breadcrumb-item active">Siswa</li>
@endsection

@section('content')
    <form id="form-search" method="get" action="{{ route('siswa.index') }}">
        <input type="hidden" name="kelas" value="{{ Crypt::encrypt($kelas->id) }}">
    </form>

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('kelas.index') }}" class="btn btn-default btn-sm">
                    <i class="nav-icon fas fa-arrow-left"></i>
                    &nbsp;
                    Kembali
                </a>

                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tambah-siswa">
                    <i class="nav-icon fas fa-folder-plus"></i>
                    &nbsp;
                    Tambah Data Siswa
                </button>

                <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#import-excel">
                    <i class="nav-icon fas fa-file-import"></i>
                    &nbsp;
                    Import Excel
                </button>

                <a href="{{ route('siswa.export') }}" class="btn btn-default btn-sm">
                    <i class="nav-icon fas fa-file-export"></i>
                    &nbsp;
                    Export Excel
                </a>

                <div class="icheck-primary">
                    <input form="form-search" id="tampilkan-deleted" type="checkbox" name="show-all"
                        onChange="this.form.submit()" @checked(request()->boolean('show-all'))>

                    <label for="tampilkan-deleted">Tampilkan deleted</label>
                </div>
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
                        @foreach ($siswaList as $siswa)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $siswa->nama_siswa }}</td>
                                <td>{{ $siswa->nis }}</td>
                                <td>
                                    <a href="{{ asset($siswa->foto) }}" data-toggle="lightbox"
                                        data-title="Foto {{ $siswa->nama_siswa }}" data-gallery="gallery" data-footer='
                                                            <a href="{{ route('siswa.edit.foto', Crypt::encrypt($siswa->id)) }}"
                                                                class="btn btn-link btn-block btn-light">
                                                                <i class="nav-icon fas fa-file-upload"></i>
                                                                &nbsp;
                                                                Ubah Foto
                                                            </a>'>
                                        <img src="{{ asset($siswa->foto) }}" class="img-fluid mb-2" style="height: 150px;">
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('siswa.show', Crypt::encrypt($siswa->id)) }}" class="btn btn-info btn-sm">
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

                                    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#hapus-siswa"
                                        onclick="hapusSiswa('{{ $siswa->id }}')">
                                        <i class="nav-icon fas fa-trash-alt"></i>
                                        &nbsp;
                                        Hapus
                                    </button>
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
                                        placeholder="Nomor induk siswa" required>
                                </div>

                                <div class="form-group">
                                    <label for="nama_siswa">Nama Siswa</label>

                                    <input id="nama_siswa" type="text" name="nama_siswa"
                                        class="form-control @error('nama_siswa') is-invalid @enderror"
                                        placeholder="Nama lengkap siswa" required>
                                </div>

                                <div class="form-group">
                                    <label for="jk">Jenis Kelamin</label>

                                    <select id="jk" name="jk" class="select2 form-control @error('jk') is-invalid @enderror"
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
                                        class="select2 form-control @error('kelas_id') is-invalid @enderror" required>
                                        <option value="">-- Pilih Kelas --</option>
                                        @foreach ($kelasList as $_kelas)
                                            <option value="{{ $_kelas->id }}" @if ($_kelas->id === $kelas->id) selected @endif>
                                                {{ $_kelas->nama_kelas }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="telp">Nomor Telepon/HP</label>

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

    <div id="hapus-siswa" class="modal fade">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h4 class="modal-title">Konfirmasi Hapus</h4>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <p>
                        Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.
                    </p>

                    <form id="siswa-destroy" method="post">
                        @csrf
                        @method('delete')
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" form="siswa-destroy" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <div id="import-excel" class="modal modal-primary fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Import Excel</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form method="post" action="{{ route('siswa.import') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="modal-body">
                        <h5>Petunjuk Import</h5>

                        <p>Gunakan format berikut pada file Excel yang diunggah atau gunakan <a target="_blank"
                                href="{{ asset('templates/template-import-data-siswa.xlsx') }}">template ini</a>.</p>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>NIS</th>
                                    <th>NISN</th>
                                    <th>Nama Siswa</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Nomor Telepon/HP</th>
                                    <th>Tempat Lahir</th>
                                    <th>Tanggal Lahir</th>
                                    <th>Kelas</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>string</td>
                                    <td>string</td>
                                    <td>string</td>
                                    <td>enum: L, P</td>
                                    <td>string. max 15</td>
                                    <td>string. max 50</td>
                                    <td>date</td>
                                    <td>string</td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="form-group">
                            <label for="file">File Data</label>

                            <div class="custom-file">
                                <input id="file" type="file" name="file"
                                    class="custom-file-input @error('file') is-invalid @enderror"
                                    accept="application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,text/csv"
                                    required>

                                <label for="file" class="custom-file-label">Pilih file Excel atau CSV (.xls, .xlsx,
                                    .csv)</label>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Close
                        </button>

                        <button type="submit" class="btn btn-primary">
                            Import
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function hapusSiswa(id) {
            const actionUrl = '{{ route('siswa.destroy', ':id') }}';

            document.getElementById('siswa-destroy').action = actionUrl.replace(':id', id);
        }
    </script>
@endsection