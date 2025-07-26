@extends('layouts.app')

@section('heading', 'Data Jadwal')

@section('breadcrumbs')
    <li class="breadcrumb-item active">Data Jadwal</li>
@endsection

@section('content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tambah-jadwal">
                    <i class="nav-icon fas fa-folder-plus"></i>
                    &nbsp;
                    Tambah Data Jadwal
                </button>

                <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#import-excel">
                    <i class="nav-icon fas fa-file-import"></i>
                    &nbsp;
                    Import Excel
                </button>

                <a href="{{ route('jadwal.export') }}" class="btn btn-default btn-sm">
                    <i class="nav-icon fas fa-file-export"></i>
                    &nbsp;
                    Export Excel
                </a>

                <!-- <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#drop-table">
                    <i class="nav-icon fas fa-minus-circle"></i>
                    &nbsp;
                    Drop
                </button> -->
            </div>

            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Kelas</th>
                            <th>Tahun</th>
                            <th>Lihat Jadwal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kelas as $_kelas)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $_kelas->nama_kelas }}</td>
                                <td>{{ $periode->tahun_ajaran }}</td>
                                <td>
                                    <a href="{{ route('jadwal.index', ['kelas' => Crypt::encrypt($_kelas->id)]) }}"
                                        class="btn btn-info btn-sm">
                                        <i class="nav-icon fas fa-search-plus"></i>
                                        &nbsp;
                                        Details
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="tambah-jadwal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Data Jadwal</h4>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form method="post" action="{{ route('jadwal.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="kelas_id">Kelas</label>

                                    <select id="kelas_id" name="kelas_id"
                                        class="select2 form-control @error('kelas_id') is-invalid @enderror" required>
                                        <option value="">-- Pilih Kelas --</option>
                                        @foreach ($kelas as $_kelas)
                                            <option value="{{ $_kelas->id }}">{{ $_kelas->nama_kelas }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="jam_mulai">Jam Mulai</label>

                                    <input id="jam_mulai" type='time' name='jam_mulai'
                                        class="form-control @error('jam_mulai') is-invalid @enderror" required>
                                </div>

                                <div class="form-group">
                                    <label for="mapel_id">Mata Pelajaran</label>

                                    <select id="mapel_id" name="mapel_id"
                                        class="select2 form-control @error('mapel_id') is-invalid @enderror" required>
                                        <option value="">-- Pilih Mapel --</option>
                                        @foreach ($mapels as $mapel)
                                            <option value="{{ $mapel->id }}">
                                                {{ $mapel->nama_mapel }} ({{ $mapel->kelompok->kode }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="hari">Hari</label>

                                    <select id="hari" name="hari"
                                        class="select2 form-control @error('hari') is-invalid @enderror" required>
                                        <option value="">-- Pilih Hari --</option>
                                        <option value="1">Senin</option>
                                        <option value="2">Selasa</option>
                                        <option value="3">Rabu</option>
                                        <option value="4">Kamis</option>
                                        <option value="5">Jumat</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="jam_selesai">Jam Selesai</label>

                                    <input id="jam_selesai" type='time' name='jam_selesai'
                                        class="form-control @error('jam_selesai') is-invalid @enderror" required>
                                </div>

                                <div class="form-group">
                                    <label for="guru_id">Nama Guru</label>

                                    <select id="guru_id" name="guru_id"
                                        class="select2 form-control @error('guru_id') is-invalid @enderror" required>
                                        <option value="">-- Pilih Guru --</option>
                                        @foreach ($gurus as $guru)
                                            <option value="{{ $guru->id }}">{{ $guru->nama_guru }}</option>
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

    <div id="import-excel" class="modal moda-primary fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Import Excel</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form method="post" action="{{ route('jadwal.import') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="modal-body">
                        <h5>Petunjuk Import</h5>

                        <p>Gunakan format berikut pada file Excel yang diunggah atau gunakan <a target="_blank" href="{{ asset('templates/template-import-data-jadwal.xlsx') }}">template ini</a>.</p>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Hari</th>
                                    <th>Jam Mulai</th>
                                    <th>Jam Selesai</th>
                                    <th>Kelas</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Guru</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>string</td>
                                    <td>string</td>
                                    <td>string</td>
                                    <td>string</td>
                                    <td>string</td>
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

                                <label for="file" class="custom-file-label">Pilih file Excel atau CSV (.xls, .xlsx, .csv)</label>
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

    <div id="drop-table" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Delete all jadwal data?</h4>
                </div>

                <div class="modal-body">
                    <b>This action cannot be reversed.</b>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Cancel
                    </button>

                    <button type="submit" form="jadwal-destroy" class="btn btn-danger">
                        Drop
                    </button>

                    <form id="jadwal-destroy" method="post" action="{{ route('jadwal.destroy', '') }}">
                        @csrf
                        @method('delete')
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection