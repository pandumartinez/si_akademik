@extends('layouts.app')

@section('heading', 'Data Mapel')

@section('breadcrumbs')
    <li class="breadcrumb-item active">Data Mapel</li>
@endsection

@section('content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tambah-mapel">
                    <i class="nav-icon fas fa-folder-plus"></i>
                    &nbsp;
                    Tambah Data Mapel
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
                                <td>{{ $mapel->kelompok->kode }} ({{ $mapel->kelompok->nama_kelompok }})</td>
                                <td>
                                    <a href="{{ route('mapel.edit', Crypt::encrypt($mapel->id)) }}"
                                        class="btn btn-success btn-sm">
                                        <i class="nav-icon fas fa-edit"></i>
                                        &nbsp;
                                        Edit
                                    </a>

                                    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#hapus-mapel"
                                        onclick="hapusMapel('{{ $mapel->id }}')">
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

    <div id="tambah-mapel" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Data Mapel</h4>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form method="post" action="{{ route('mapel.store') }}">
                    @csrf

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="nama_mapel">Nama Mapel</label>

                                    <input id="nama_mapel" type="text" name="nama_mapel"
                                        class="form-control @error('nama_mapel') is-invalid @enderror"
                                        placeholder="Nama mata pelajaran" required>
                                </div>

                                <div class="form-group">
                                    <label for="kelompok">Kelompok</label>

                                    <select id="kelompok" name="kelompok"
                                        class="select2 form-control @error('kelompok') is-invalid @enderror" required>
                                        <option value="">-- Pilih kelompok mapel --</option>
                                        @foreach ($kelompokMapel as $kelompok)
                                            <option value="{{ $kelompok->id }}">
                                                Pelajaran {{ $kelompok->nama_kelompok }}
                                            </option>
                                        @endforeach
                                    </select>
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

    <div id="hapus-mapel" class="modal fade">
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

                    <form id="mapel-destroy" method="post">
                        @csrf
                        @method('delete')
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" form="mapel-destroy" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function hapusMapel(id) {
            const actionUrl = '{{ route('mapel.destroy', ':id') }}';

            document.getElementById('mapel-destroy').action = actionUrl.replace(':id', id);
        }
    </script>
@endsection