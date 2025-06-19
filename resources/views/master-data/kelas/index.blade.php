@extends('layouts.app')

@section('heading', 'Data Kelas')

@section('breadcrumbs')
    <li class="breadcrumb-item active">Data Kelas</li>
@endsection

@section('content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <button type="button" class="btn btn-primary btn-sm"
                    data-toggle="modal"
                    data-target="#modal-kelas"
                    onclick="setModalKelas('create')">
                    <i class="nav-icon fas fa-folder-plus"></i>
                    &nbsp;
                    Tambah Data Kelas
                </button>
            </div>

            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Kelas</th>
                            <th>Wali Kelas</th>
                            <th>Tahun</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kelas as $_kelas)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $_kelas->nama_kelas }}</td>
                                <td>{{ $_kelas->waliKelas ? $_kelas->waliKelas->nama_guru : '-' }}</td>
                                <td>{{ $periode->tahun_ajaran }}</td>
                                <td>
                                    <a href="{{ route('siswa.index', ['kelas' => Crypt::encrypt($_kelas->id)]) }}"
                                        class="btn btn-info btn-sm">
                                        <i class="nav-icon fas fa-users"></i>
                                        &nbsp;
                                        Lihat Siswa
                                    </a>

                                    <a href="{{ route('jadwal.index', ['kelas' => Crypt::encrypt($_kelas->id)]) }}"
                                        class="btn btn-info btn-sm">
                                        <i class="nav-icon fas fa-calendar-alt"></i>
                                        &nbsp;
                                        Lihat Jadwal
                                    </a>

                                    <button type="button" class="btn btn-success btn-sm"
                                        data-toggle="modal"
                                        data-target="#modal-kelas"
                                        onclick="
                                            setModalKelas('edit', {
                                                kelasId: {{ $_kelas->id }},
                                                namaKelas: '{{ $_kelas->nama_kelas }}',
                                                waliKelas: {{ $_kelas->waliKelas ? $_kelas->waliKelas->id : 'null' }},
                                            });">
                                        <i class="nav-icon fas fa-edit"></i>
                                        &nbsp;
                                        Edit
                                    </button>

                                    <button type="submit" form="{{ $loop->iteration }}-kelas-destroy"
                                        class="btn btn-danger btn-sm">
                                        <i class="nav-icon fas fa-trash-alt"></i>
                                        &nbsp;
                                        Hapus
                                    </button>

                                    <form id="{{ $loop->iteration }}-kelas-destroy"
                                        method="post" action="{{ route('kelas.destroy', $_kelas->id) }}">
                                        @csrf
                                        @method('delete')
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="modal-kelas" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"></h4>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form method="post" action="{{ route('kelas.store') }}">
                    @csrf
                    @method('patch')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group" id="form_nama">
                                    <label for="nama_kelas">Nama Kelas</label>

                                    <input id="nama_kelas" type='text' name='nama_kelas'
                                        class="form-control @error('nama_kelas') is-invalid @enderror" placeholder="Nama Kelas"
                                        required>
                                </div>

                                <div class="form-group">
                                    <label for="wali_kelas">Wali Kelas</label>

                                    <select id="wali_kelas" name="wali_kelas"
                                        class="select2 form-control @error('wali_kelas') is-invalid @enderror"
                                        required>
                                        <option value="">-- Pilih Wali Kelas --</option>
                                        @foreach ($gurus as $guru)
                                            <option
                                                @if ($guru->kelasWali) disabled @endif
                                                value="{{ $guru->id }}">
                                                {{ $guru->nama_guru }} @if ($guru->kelasWali) ({{ $guru->kelasWali->nama_kelas }}) @endif
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
                            <span>Tambahkan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function setModalKelas(mode, param) {
            if (mode === 'create') {
                $('#modal-kelas .modal-title').text('Tambah Data Kelas');

                $('#modal-kelas form').attr('action', '{{ route('kelas.store') }}');
                $('#modal-kelas input[name="_method"').attr('disabled', true);

                $('#nama_kelas').val(null);
                $('#wali_kelas').val(null);

                $('#wali_kelas').trigger('change');

                $('#modal-kelas button[type="submit"] span').text('Tambahkan');
            } else if (mode === 'edit') {
                const editUrl = '{{ route('kelas.update', ':kelasId') }}';

                $('#modal-kelas .modal-title').text('Edit Data Kelas');

                $('#modal-kelas form').attr('action', editUrl.replace(':kelasId', param.kelasId));
                $('#modal-kelas input[name="_method"').removeAttr('disabled');

                $('#nama_kelas').val(param.namaKelas);
                $('#wali_kelas').val(param.waliKelas);

                $('#wali_kelas').trigger('change');

                $('#modal-kelas button[type="submit"] span').text('Simpan');
            }
        }
    </script>
@endsection
