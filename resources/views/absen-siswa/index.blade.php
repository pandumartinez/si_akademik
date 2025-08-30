@extends('layouts.app')

@php
    $canAbsen = isset($kelas) && auth()->user()->can('absen', $kelas);
@endphp

@section('heading')
    @if (auth()->user()->role === 'admin')
        @if (isset($kelas))
            Absensi Kelas {{ $kelas->nama_kelas }}
        @else
            Absensi Kelas
        @endif
    @elseif (auth()->user()->role === 'guru')
        @if (isset($kelas))
            Absensi Kelas {{ $kelas->nama_kelas }}
            Hari {{ \Carbon\Carbon::now()->translatedFormat('l, j F') }}
        @else
            Absensi Kelas
        @endif
    @endif
@endsection

@section('breadcrumbs')
    <li class="breadcrumb-item active">Absensi Kelas</li>
@endsection

@push('styles')
    <style>
        th.absen,
        td.absen {
            width: 120px;
            text-align: center;
        }

        td.absen.error {
            background-color: rgb(254, 226, 226);
        }
    </style>
@endpush

@section('content')
    <form id="form-search" method="get" action="{{ route('absen-siswa.index') }}"></form>

    @if (auth()->user()->role === 'admin' && isset($kelas))
        <form id="form-buka-absen" method="post" action="{{ route('absen-siswa.buka') }}">
            @csrf
            <input type="hidden" name="buka" value="{{ $absenDibuka ? '0' : '1' }}">
            <input type="hidden" name="kelas_id" value="{{ $kelas->id }}">
        </form>
    @endif

    <div class="col-md-12">
        <div class="card">
            @if (auth()->user()->role === 'admin')
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="kelas">Kelas</label>

                                <select form="form-search" id="kelas" name="kelas" class="select2 form-control"
                                    onchange="event.target.form.submit()">
                                    <option selected disabled>-- Pilih Kelas --</option>
                                    @foreach ($kelasList as $_kelas)
                                        <option value="{{ $_kelas->nama_kelas }}" @if (isset($kelas) && $_kelas->id === $kelas->id)
                                        selected @endif>
                                            {{ $_kelas->nama_kelas }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="tanggal">Tanggal</label>

                                <input form="form-search" id="tanggal" type="date" name="tanggal"
                                    class="form-control"
                                    onchange="event.target.form.submit()"
                                    placeholder="Tanggal kehadiran"
                                    value="{{ $tanggal }}">
                            </div>
                        </div>

                        @if (isset($kelas) && date('H:i') >= '08:00')
                            <div class="col-md-7 d-flex align-items-center justify-content-end">
                                <button form="form-buka-absen" type="submit" class="btn btn-{{ $absenDibuka ? 'danger' : 'secondary' }}">
                                    <i class="nav-icon fas fa-{{ $absenDibuka ? 'lock' : 'lock-open' }}"></i>
                                    &nbsp;
                                    {{ $absenDibuka ? 'Tutup' : 'Buka' }} Absen
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <div class="card-body">
                <div class="row">
                    @if (!isset($kelas))
                        <div class="col-md-12">
                            <p class="mb-0 text-center text-muted">
                                Pilih kelas terlebih dahulu
                            </p>
                        </div>
                    @endif

                    @if (isset($kelas))
                        <div class="col-md-12 border-bottom">
                            <dl class="row">
                                <dt class="col-sm-3">Nama Kelas</dt>
                                <dd class="col-sm-3">{{ $kelas->nama_kelas }}</dd>

                                <dt class="col-sm-3">Periode</dt>
                                <dd class="col-sm-3">
                                    {{ App\Periode::aktif() }}
                                </dd>

                                <dt class="col-sm-3">Wali Kelas</dt>
                                <dd class="col-sm-3">{{ $kelas->waliKelas->nama_guru }}</dd>

                                <dt class="col-sm-3">Jumlah Siswa</dt>
                                <dd class="col-sm-3">{{ $kelas->siswa->count() }}</dd>
                            </dl>
                        </div>

                        @if (auth()->user()->role === 'admin')
                            <div class="col-md-12 mt-3">
                                <dl class="row">
                                    <dt class="col-sm-3">Jumlah Izin</dt>
                                    <dd id="jumlah-izin" class="col-sm-1">{{ $jumlah['izin'] ?? 0 }}</dd>

                                    <dt class="col-sm-3">Jumlah Sakit</dt>
                                    <dd id="jumlah-sakit" class="col-sm-1">{{ $jumlah['sakit'] ?? 0 }}</dd>

                                    <dt class="col-sm-3">Jumlah Tanpa Keterangan</dt>
                                    <dd id="jumlah-tanpa-keterangan" class="col-sm-1">{{ $jumlah['tanpa keterangan'] ?? 0 }}</dd>
                                </dl>
                            </div>
                        @endif

                        <div class="col-md-12">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th rowspan="2" class="text-center">No. Induk</th>
                                        <th rowspan="2">Nama Siswa</th>
                                        <th colspan="3" class="text-center">Absensi</th>
                                    </tr>
                                    <tr class="text-center">
                                        <th class="absen">Izin</th>
                                        <th class="absen">Sakit</th>
                                        <th class="absen">Tanpa Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kelas->siswa as $siswa)
                                        @php
                                            $kehadiran = $siswa->absen->first()?->keterangan ?? null;
                                        @endphp
                                        <tr>
                                            <form id="{{ $loop->iteration }}-form-absen">
                                                <input type="hidden" name="siswa_id" value="{{ $siswa->id }}">
                                            </form>

                                            <td class="text-center">{{ $siswa->nis }}</td>

                                            <td>{{ $siswa->nama_siswa }}</td>

                                            <td class="absen">
                                                <input form="{{ $loop->iteration }}-form-absen" type="radio"
                                                    class="absen" name="keterangan" value="izin"
                                                    @if (!$canAbsen) disabled @endif
                                                    @if ($kehadiran === 'izin') checked @endif>
                                            </td>

                                            <td class="absen">
                                                <input form="{{ $loop->iteration }}-form-absen" type="radio"
                                                    class="absen" name="keterangan" value="sakit"
                                                    @if (!$canAbsen) disabled @endif
                                                    @if ($kehadiran === 'sakit') checked @endif>
                                            </td>

                                            <td class="absen">
                                                <input form="{{ $loop->iteration }}-form-absen" type="radio"
                                                    class="absen" name="keterangan" value="tanpa keterangan"
                                                    @if (!$canAbsen) disabled @endif
                                                    @if ($kehadiran === 'tanpa keterangan') checked @endif>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        @if (auth()->user()->role === 'admin')
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
                            <tr data-toggle="collapse" data-target="#log-detail-{{ $loop->iteration }}" style="cursor: pointer;">
                                <td>{{ $log->created_at }}</td>
                                <td>{{ $log->subject->siswa->nama_siswa ?? 'null' }}</td>
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
        @endif
    </div>
@endsection

@if ($canAbsen)
    @section('script')
        <script>
            function saveAbsen(radio) {
                $.ajax({
                    type: 'post',
                    url: '{{ route('absen-siswa.store') }}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    data: {
                        siswa_id: radio.form.elements.siswa_id.value,
                        keterangan: radio.value,
                    },
                    success: function () {
                        radio.parentElement.classList.remove('error');
                        toastr.success('Absen berhasil disimpan.');
                    },
                    error: function () {
                        radio.parentElement.classList.add('error');
                        toastr.error('Absen tidak dapat disimpan.');
                    },
                });
            }

            $('input.absen').on('change', function (event) {
                saveAbsen(event.target);
            });
        </script>
    @endsection
@endif