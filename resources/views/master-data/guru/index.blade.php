@extends('layouts.app')

@section('heading', "Data Guru")

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

                <a href="{{ route('guru.export') }}" class="btn btn-default btn-sm">
                    <i class="nav-icon fas fa-file-export"></i>
                    &nbsp;
                    Export Excel
                </a>
            </div>

            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>NIP</th>
                            <th>Mata Pelajaran</th>
                            <th>Foto</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($guruList as $guru)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $guru->nama_guru }}</td>
                                <td>{{ $guru->nip }}</td>
                                <td>
                                    @if ($guru->mapel->isEmpty())
                                        -
                                    @else
                                        <ul>
                                            @foreach ($guru->mapel as $mapel)
                                                <li>{{ $mapel->nama_mapel }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ asset($guru->foto) }}" data-toggle="lightbox"
                                        data-title="Foto {{ $guru->nama_guru }}" data-gallery="gallery" data-footer='
                                                            <a href="{{ route('guru.edit.foto', Crypt::encrypt($guru->id)) }}"
                                                                class="btn btn-link btn-block btn-light">
                                                                <i class="nav-icon fas fa-file-upload"></i>
                                                                &nbsp;
                                                                Ubah Foto
                                                            </a>'>
                                        <img src="{{ asset($guru->foto) }}" class="img-fluid mb-2" style="height: 150px;">
                                    </a>
                                </td>
                                <td>
                                    <div class="d-flex flex-wrap" style="gap: .25rem">
                                        <a href="{{ route('guru.show', Crypt::encrypt($guru->id)) }}"
                                            class="btn btn-info btn-sm">
                                            <i class="nav-icon fas fa-id-card"></i>
                                            &nbsp;
                                            Detail
                                        </a>

                                        <a href="{{ route('guru.edit', Crypt::encrypt($guru->id)) }}"
                                            class="btn btn-success btn-sm">
                                            <i class="nav-icon fas fa-edit"></i>
                                            &nbsp;
                                            Edit
                                        </a>

                                        <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#hapus-guru"
                                            onclick="hapusGuru('{{ $guru->id }}')">
                                            <i class="nav-icon fas fa-trash-alt"></i>
                                            &nbsp;
                                            Hapus
                                        </button>
                                    </div>
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

    <div id="hapus-guru" class="modal fade">
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

                    <form id="guru-destroy" method="post">
                        @csrf
                        @method('delete')
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" form="guru-destroy" class="btn btn-danger">Delete</button>
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

                <form method="post" action="{{ route('guru.import') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="modal-body">
                        <h5>Petunjuk Import</h5>

                        <p>Gunakan format berikut pada file Excel yang diunggah atau gunakan <a target="_blank"
                                href="{{ asset('templates/template-import-data-guru.xlsx') }}">template ini</a>.</p>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>NIP</th>
                                    <th>Nama Guru</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Nomor Telepon/HP</th>
                                    <th>Tempat Lahir</th>
                                    <th>Tanggal Lahir</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>string</td>
                                    <td>string</td>
                                    <td>enum: L, P</td>
                                    <td>string. max 15</td>
                                    <td>string. max 50</td>
                                    <td>date</td>
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
        function hapusGuru(id) {
            const actionUrl = '{{ route('guru.destroy', ':id') }}';

            document.getElementById('guru-destroy').action = actionUrl.replace(':id', id);
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bs-custom-file-input/1.3.4/bs-custom-file-input.min.js"></script>

    <script>
        bsCustomFileInput.init()
    </script>
@endsection