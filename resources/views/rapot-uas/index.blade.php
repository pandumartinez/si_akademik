@extends('layouts.app')

@section('heading')
    @if (isset($kelas, $mapel))
        Nilai Rapot UAS {{ $mapel->nama_mapel }} {{ $kelas->nama_kelas }}
    @else
        Nilai Rapot UAS
    @endif
@endsection

@section('breadcrumbs')
    <li class="breadcrumb-item active">Nilai Rapot</li>
@endsection

@push('styles')
    <style>
        th.nilai,
        th.predikat {
            width: 80px;
        }

        th.deskripsi {
            width: 240px;
        }

        td {
            vertical-align: middle !important;
        }

        td.nilai {
            padding: 0;
            cursor: text;
        }

        td.nilai.error {
            background-color: rgb(254, 226, 226);
        }

        input[type=number] {
            -moz-appearance: textfield;
        }

        input.nilai {
            width: 56px;
            padding: 4px;
            text-align: center;
            border: none;
            outline: none;
            background: none;
        }

        input.nilai::-webkit-inner-spin-button,
        input.nilai::-webkit-outer-spin-button {
            appearance: none;
            margin: 0;
        }
    </style>
@endpush

@php
    $view = request()->view ?? (auth()->user()->role === 'admin' ? 'siswa' : 'kelas');
@endphp

@section('content')
    <!-- <h1>View {{ $view }}</h1> -->
    <form id="form-search" method="get" action="{{ route('rapot-uas.index') }}"></form>

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                @if (isset($kelas))
                    <a href="{{ route('rapot-uas.export', ['kelas' => $kelas->id]) }}" class="btn btn-default btn-sm">
                        <i class="nav-icon fas fa-file-export"></i>
                        &nbsp;
                        Export Excel
                    </a>
                @endif

                <div class="row mt-3 pt-2 border-top">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="jk">Kelas</label>

                            <select form="form-search" id="kelas" name="kelas" class="select2 form-control"
                                onchange="event.target.form.submit()">
                                <option selected disabled>-- Pilih Kelas --</option>
                                @foreach ($kelasList as $_kelas)
                                    <option value="{{ $_kelas->nama_kelas }}"
                                        @if (isset($kelas) && $_kelas->id === $kelas->id) selected @endif>
                                        {{ $_kelas->nama_kelas }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    @if (isset($kelas))
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="view">View</label>

                                <select form="form-search" id="view" name="view" class="select2 form-control"
                                    onchange="event.target.form.submit()">
                                    <option disabled>-- Pilih View --</option>
                                    @if(auth()->user()->role === 'admin')
                                        <option value="siswa" @if ($view === 'siswa') selected @endif>Siswa</option>
                                    @endif
                                    <option value="kelas" @if ($view === 'kelas') selected @endif>Kelas</option>
                                </select>
                            </div>
                        </div>
                    @endif

                    @if ($view === 'siswa' && isset($kelas))
                        <div id="select-siswa" class="col-md-4">
                            <div class="form-group">
                                <label for="siswa">Siswa</label>

                                <select form="form-search" id="siswa" name="siswa" class="select2 form-control"
                                    onchange="event.target.form.submit()">
                                    <option selected disabled>-- Pilih Siswa --</option>
                                    @foreach ($kelas->siswa as $_siswa)
                                        <option value="{{ $_siswa->nama_siswa }}"
                                            @if (isset($siswa) && $_siswa->id === $siswa->id) selected @endif>
                                            {{ $_siswa->nama_siswa }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif

                    @if ($view === 'kelas' && isset($mapelList))
                        <div id="select-mapel" class="col-md-5">
                            <div class="form-group">
                                <label for="mapel">Mata Pelajaran</label>

                                <select form="form-search" id="mapel" name="mapel" class="select2 form-control"
                                    onchange="event.target.form.submit()">
                                    <option selected disabled>-- Pilih Mapel --</option>
                                    @foreach ($mapelList as $_mapel)
                                        <option value="{{ $_mapel->nama_mapel }}_{{ $_mapel->kelompok->kode }}"
                                            @if (isset($mapel) && $_mapel->id === $mapel->id) selected @endif>
                                            {{ $_mapel->nama_mapel }} ({{ $_mapel->kelompok->kode }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    @if ($view === 'siswa' && !isset($siswa))
                        <div class="col-md-12">
                            <p class="mb-0 text-center text-muted">
                                Pilih siswa terlebih dahulu
                            </p>
                        </div>
                    @endif

                    @if ($view === 'kelas' && !isset($kelas, $mapel))
                        <div class="col-md-12">
                            <p class="mb-0 text-center text-muted">
                                Pilih kelas dan mata pelajaran terlebih dahulu
                            </p>
                        </div>
                    @endif

                    @if ($view === 'siswa' && isset($siswa))
                        <div class="col-md-12">
                            <dl class="row">
                                <dt class="col-sm-3">Nama Siswa</dt>
                                <dd class="col-sm-3">{{ $siswa->nama_siswa }}</dd>

                                <dt class="col-sm-3">Kelas</dt>
                                <dd class="col-sm-3">{{ $kelas->nama_kelas }}</dd>

                                <dt class="col-sm-3">NIS / NISN</dt>
                                <dd class="col-sm-3">{{ $siswa->nis }} / {{ $siswa->nisn }}</dd>

                                <dt class="col-sm-3">Periode</dt>
                                <dd class="col-sm-3">
                                    {{ App\Periode::aktif() }}
                                </dd>
                            </dl>
                        </div>

                        <div class="col-md-12">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th rowspan="2" class="text-center">No.</th>
                                        <th rowspan="2">Mata Pelajaran</th>
                                        <th colspan="3" class="text-center">Pengetahuan</th>
                                        <th colspan="3" class="text-center">Keterampilan</th>
                                    </tr>
                                    <tr class="text-center">
                                        <th>Nilai</th>
                                        <th>Predikat</th>
                                        <th>Deskripsi</th>
                                        <th>Nilai</th>
                                        <th>Predikat</th>
                                        <th>Deskripsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($mapels as $mapel)
                                        @php
                                            $rapotUas = $mapel->rapotUas->first();
                                        @endphp
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>

                                            <td>{{ $mapel->nama_mapel }}</td>

                                            <td class="nilai text-center">
                                                {{ $rapotUas ? $rapotUas->nilai_pengetahuan : null }}
                                            </td>

                                            <td class="nilai text-center">
                                                {{ $rapotUas ? $rapotUas->predikat_pengetahuan : null }}
                                            </td>

                                            <td class="nilai text-center">
                                                {{ $rapotUas ? $rapotUas->deskripsi_pengetahuan : null }}
                                            </td>

                                            <td class="nilai text-center">
                                                {{ $rapotUas ? $rapotUas->nilai_keterampilan : null }}
                                            </td>

                                            <td class="nilai text-center">
                                                {{ $rapotUas ? $rapotUas->predikat_keterampilan : null }}
                                            </td>

                                            <td class="nilai text-center">
                                                {{ $rapotUas ? $rapotUas->deskripsi_keterampilan : null }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                    @if ($view === 'kelas' && isset($kelas, $mapel))
                        <div class="col-md-12">
                            <dl class="row">
                                <dt class="col-sm-3">Nama Kelas</dt>
                                <dd class="col-sm-3">{{ $kelas->nama_kelas }}</dd>

                                <dt class="col-sm-3">Periode</dt>
                                <dd class="col-sm-3">
                                    {{ App\Periode::aktif() }}
                                </dd>

                                <dt class="col-sm-3">Wali Kelas</dt>
                                <dd class="col-sm-3">{{ $kelas->waliKelas->nama_guru }}</dd>

                                <dt class="col-sm-3">Mata Pelajaran</dt>
                                <dd class="col-sm-3">{{ $mapel->nama_mapel }}</dd>

                                <dt class="col-sm-3">Jumlah Siswa</dt>
                                <dd class="col-sm-3">{{ $kelas->siswa->count() }}</dd>

                                <dt class="col-sm-3">Guru Mata Pelajaran</dt>
                                <dd class="col-sm-3">{{ $guru->nama_guru }}</dd>
                            </dl>
                        </div>

                        <div class="col-md-12">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th rowspan="2" class="text-center">No. Induk</th>
                                        <th rowspan="2">Nama Siswa</th>
                                        <th colspan="3" class="text-center">Pengetahuan</th>
                                        <th colspan="3" class="text-center">Keterampilan</th>
                                    </tr>
                                    <tr class="text-center">
                                        <th class="nilai">Nilai</th>
                                        <th class="predikat">Predikat</th>
                                        <th class="deskripsi">Deskripsi</th>
                                        <th class="nilai">Nilai</th>
                                        <th class="predikat">Predikat</th>
                                        <th class="deskripsi">Deskripsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kelas->siswa as $siswa)
                                        @php
                                            $rapot = $siswa->rapotUas->first();
                                        @endphp
                                        <tr>
                                            <td class="text-center">{{ $siswa->nis }}</td>

                                            <td>{{ $siswa->nama_siswa }}</td>

                                            <td class="text-center">
                                                {{ $rapot ? $rapot->nilai_pengetahuan : null }}
                                            </td>

                                            <td class="text-center">
                                                {{ $rapot ? $rapot->predikat_pengetahuan : null }}
                                            </td>

                                            <td class="text-center" contenteditable="plaintext-only"
                                                onblur="saveDeskripsi(event.target, {{ $siswa->pivot->id }}, 'pengetahuan')"
                                                tabindex="-1">{{ $rapot ? $rapot->deskripsi_pengetahuan : null }}</td>

                                            <td class="nilai text-center" onclick="event.target.firstElementChild?.focus()">
                                                <input form="{{ $loop->iteration }}-form-nilai" type="number"
                                                    class="nilai" min="1" max="100"
                                                    value="{{ $siswa->rapotUas->first()->nilai_keterampilan ?? '' }}"
                                                    onblur="validateNilai(event.target)"
                                                    onchange="saveNilai(event.target, {{ $siswa->pivot->id }})">
                                            </td>

                                            <td class="text-center">
                                                {{ $rapot ? $rapot->predikat_keterampilan : null }}
                                            </td>

                                            <td class="text-center" contenteditable="plaintext-only"
                                                onblur="saveDeskripsi(event.target, {{ $siswa->pivot->id }}, 'keterampilan')"
                                                tabindex="-1">{{ $rapot ? $rapot->deskripsi_keterampilan : null }}</td>
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

@if (auth()->user()->role === 'guru' && isset($kelas, $mapel))
    @section('script')
        <script>
            function saveDeskripsi(element, kelasSiswaId, jenis) {
                element.textContent = element.textContent.trim();

                $.ajax({
                    async: false,
                    type: 'post',
                    url: '{{ route('rapot-uas.store') }}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    data: {
                        kelas_siswa_id: kelasSiswaId,
                        mapel_id: {{ $mapel->id }},
                        jenis: jenis,
                        deskripsi: element.textContent.trim(),
                    },
                    success: function () {
                        toastr.success('Deskripsi berhasil disimpan.');
                    },
                    error: function () {
                        toastr.error('Deskripsi tidak dapat disimpan.');
                    },
                });
            }

            function validateNilai(input) {
                var value = input.value;
                if (value < 0) {
                    input.value = 0;
                } else if (value > 100) {
                    input.value = 100;
                }
            }

            function saveNilai(input, kelasSiswaId) {
                $.ajax({
                    type: 'post',
                    url: '{{ route('rapot-uas.store') }}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    data: {
                        kelas_siswa_id: kelasSiswaId,
                        mapel_id: {{ $mapel->id }},
                        nilai: input.value,
                    },
                    success: function(response) {
                        input.parentElement.classList.remove('error');
                        toastr.success('Nilai berhasil disimpan.');

                        var row = input.parentElement.parentElement;
                        row.children[6].textContent = response.predikat;
                        row.children[7].textContent = response.deskripsi;
                    },
                    error: function() {
                        input.parentElement.classList.add('error');
                        toastr.error('Nilai tidak dapat disimpan.');
                    },
                });
            }
        </script>
    @endsection
@endif
