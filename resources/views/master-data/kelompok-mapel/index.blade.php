@extends('layouts.app')

@section('heading', 'Data Kelompok Mapel')

@section('breadcrumbs')
    <li class="breadcrumb-item active">Data Kelompok Mapel</li>
@endsection

@section('content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('mapel.index') }}" class="btn btn-default btn-sm">
                    <i class="nav-icon fas fa-arrow-left"></i>
                    &nbsp;
                    Kembali
                </a>

                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                    data-target="#tambah-kelompok-mapel">
                    <i class="nav-icon fas fa-folder-plus"></i>
                    &nbsp;
                    Tambah Kelompok Mapel
                </button>
            </div>

            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Kode Kelompok</th>
                            <th>Nama Kelompok</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kelompokMapel as $kelompok)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $kelompok->kode  }}</td>
                                <td>{{ $kelompok->nama_kelompok }}</td>
                                <td>
                                    <a href="{{ route('kelompok-mapel.edit', Crypt::encrypt($kelompok->id)) }}"
                                        class="btn btn-success btn-sm">
                                        <i class="nav-icon fas fa-edit"></i>
                                        &nbsp;
                                        Edit
                                    </a>

                                    <button class="btn btn-danger btn-sm" data-toggle="modal"
                                        data-target="#hapus-kelompok-mapel" onclick="hapusKelompokMapel('{{ $kelompok->id }}')">
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

        <div class="card">
            <div class="card-header">
            </div>

            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Timestamp</th>
                            <th>Subject</th>
                            <th>Action</th>
                            <th>Actor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($activities as $log)
                            <tr data-toggle="collapse" data-target="#log-detail-{{ $loop->iteration }}"
                                style="cursor: pointer;">
                                <td>{{ $log->created_at }}</td>
                                <td>{{ $log->subject->nama_kelompok ?? 'null' }}</td>
                                <td>{{ $log->description }}</td>
                                <td>{{ $log->causer->name }}</td>
                            </tr>
                            <tr class="collapse" id="log-detail-{{ $loop->iteration }}">
                                <td colspan="4">
                                    <div style="max-width: 100%; overflow-x: auto;">
                                        <pre
                                            style="white-space: pre; margin: 0;">{{ json_encode($log->changes, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="tambah-kelompok-mapel" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Kelompok Mapel</h4>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form method="post" action="{{ route('kelompok-mapel.store') }}">
                    @csrf

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="kode_kelompok">Kode Kelompok</label>

                                    <input id="kode_kelompok" type="text" name="kode_kelompok"
                                        class="form-control @error('kode_kelompok') is-invalid @enderror"
                                        placeholder="Kode kelompok mapel" required>
                                </div>

                                <div class="form-group">
                                    <label for="nama_kelompok">Nama Kelompok</label>

                                    <input id="nama_kelompok" type="text" name="nama_kelompok"
                                        class="form-control @error('nama_kelompok') is-invalid @enderror"
                                        placeholder="Nama kelompok mapel" required>
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

    <div id="hapus-kelompok-mapel" class="modal fade">
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

                    <form id="kelompok-mapel-destroy" method="post">
                        @csrf
                        @method('delete')
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" form="kelompok-mapel-destroy" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function hapusKelompokMapel(id) {
            const actionUrl = '{{ route('kelompok-mapel.destroy', ':id') }}';

            document.getElementById('kelompok-mapel-destroy').action = actionUrl.replace(':id', id);
        }
    </script>
@endsection