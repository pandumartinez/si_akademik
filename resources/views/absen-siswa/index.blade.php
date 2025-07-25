@extends('layouts.app')

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
                                                    @if (auth()->user()->role === 'admin') disabled @endif
                                                    @if ($kehadiran === 'izin') checked @endif>
                                            </td>

                                            <td class="absen">
                                                <input form="{{ $loop->iteration }}-form-absen" type="radio"
                                                    class="absen" name="keterangan" value="sakit"
                                                    @if (auth()->user()->role === 'admin') disabled @endif
                                                    @if ($kehadiran === 'sakit') checked @endif>
                                            </td>

                                            <td class="absen">
                                                <input form="{{ $loop->iteration }}-form-absen" type="radio"
                                                    class="absen" name="keterangan" value="tanpa keterangan"
                                                    @if (auth()->user()->role === 'admin') disabled @endif
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
    </div>
@endsection

@if (auth()->user()->role === 'guru' && Auth::user()->guru->kelasWali)
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