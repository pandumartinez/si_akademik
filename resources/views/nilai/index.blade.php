@extends('layouts.app')

@section('heading')
    @if (isset($kelas, $mapel))
        Nilai Mata Pelajaran {{ $mapel->nama_mapel }} {{ $kelas->nama_kelas }}
    @else
        Nilai Mata Pelajaran
    @endif
@endsection

@section('breadcrumbs')
    <li class="breadcrumb-item active">Nilai Mata Pelajaran</li>
@endsection

@push('styles')
    <style>
        td {
            vertical-align: middle !important;
        }

        td.nilai {
            padding: 0;
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
    <form id="form-search" method="get" action="{{ route('nilai.index') }}"></form>

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">

                <div class="row mt-3 pt-2 border-top">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="kelas">Kelas</label>

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
                                        <th colspan="4" class="text-center">Nilai Tugas</th>
                                        <th colspan="4" class="text-center">Nilai Ulangan Harian</th>
                                        <th rowspan="2" class="text-center">UTS</th>
                                        <th rowspan="2" class="text-center">UAS</th>
                                    </tr>
                                    <tr class="text-center">
                                        <th>Tugas 1</th>
                                        <th>Tugas 2</th>
                                        <th>Tugas 3</th>
                                        <th>Tugas 4</th>
                                        <th>Ulha 1</th>
                                        <th>Ulha 2</th>
                                        <th>Ulha 3</th>
                                        <th>Ulha 4</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($mapels as $mapel)
                                        @php
                                            $nilai = $mapel->nilai->first();
                                        @endphp
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>

                                            <td>{{ $mapel->nama_mapel }}</td>

                                            <td class="nilai text-center">
                                                {{ $nilai ? $nilai->tugas_1 : null }}
                                            </td>

                                            <td class="nilai text-center">
                                                {{ $nilai ? $nilai->tugas_2 : null }}
                                            </td>

                                            <td class="nilai text-center">
                                                {{ $nilai ? $nilai->tugas_3 : null }}
                                            </td>

                                            <td class="nilai text-center">
                                                {{ $nilai ? $nilai->tugas_4 : null }}
                                            </td>

                                            <td class="nilai text-center">
                                                {{ $nilai ? $nilai->ulha_1 : null }}
                                            </td>

                                            <td class="nilai text-center">
                                                {{ $nilai ? $nilai->ulha_2 : null }}
                                            </td>

                                            <td class="nilai text-center">
                                                {{ $nilai ? $nilai->ulha_3 : null }}
                                            </td>

                                            <td class="nilai text-center">
                                                {{ $nilai ? $nilai->ulha_4 : null }}
                                            </td>

                                            <td class="nilai text-center">
                                                {{ $nilai ? $nilai->uts : null }}
                                            </td>

                                            <td class="nilai text-center">
                                                {{ $nilai ? $nilai->uas : null }}
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
                                        <th colspan="4" class="text-center">Nilai Tugas</th>
                                        <th colspan="4" class="text-center">Nilai Ulangan Harian</th>
                                        <th rowspan="2" class="text-center">UTS</th>
                                        <th rowspan="2" class="text-center">UAS</th>
                                    </tr>
                                    <tr class="text-center">
                                        <th>Tugas 1</th>
                                        <th>Tugas 2</th>
                                        <th>Tugas 3</th>
                                        <th>Tugas 4</th>
                                        <th>Ulha 1</th>
                                        <th>Ulha 2</th>
                                        <th>Ulha 3</th>
                                        <th>Ulha 4</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kelas->siswa as $siswa)
                                        <tr>
                                            <form id="{{ $loop->iteration }}-form-nilai">
                                                <input type="hidden" name="kelas_siswa_id"
                                                    value="{{ $siswa->pivot->id }}">
                                            </form>

                                            <td class="text-center">{{ $siswa->nis }}</td>

                                            <td>{{ $siswa->nama_siswa }}</td>

                                            <td class="nilai text-center">
                                                <input form="{{ $loop->iteration }}-form-nilai" type="number"
                                                    name="tugas_1" class="nilai" min="1" max="100"
                                                    value="{{ $siswa->nilai->first()->tugas_1 ?? '' }}"
                                                    @if (auth()->user()->role === 'admin') disabled @endif>
                                            </td>

                                            <td class="nilai text-center">
                                                <input form="{{ $loop->iteration }}-form-nilai" type="number"
                                                    name="tugas_2" class="nilai" min="1" max="100"
                                                    value="{{ $siswa->nilai->first()->tugas_2 ?? '' }}"
                                                    @if (auth()->user()->role === 'admin') disabled @endif>
                                            </td>

                                            <td class="nilai text-center">
                                                <input form="{{ $loop->iteration }}-form-nilai" type="number"
                                                    name="tugas_3" class="nilai" min="1" max="100"
                                                    value="{{ $siswa->nilai->first()->tugas_3 ?? '' }}"
                                                    @if (auth()->user()->role === 'admin') disabled @endif>
                                            </td>

                                            <td class="nilai text-center">
                                                <input form="{{ $loop->iteration }}-form-nilai" type="number"
                                                    name="tugas_4" class="nilai" min="1" max="100"
                                                    value="{{ $siswa->nilai->first()->tugas_4 ?? '' }}"
                                                    @if (auth()->user()->role === 'admin') disabled @endif>
                                            </td>

                                            <td class="nilai text-center">
                                                <input form="{{ $loop->iteration }}-form-nilai" type="number"
                                                    name="ulha_1" class="nilai" min="1" max="100"
                                                    value="{{ $siswa->nilai->first()->ulha_1 ?? '' }}"
                                                    @if (auth()->user()->role === 'admin') disabled @endif>
                                            </td>

                                            <td class="nilai text-center">
                                                <input form="{{ $loop->iteration }}-form-nilai" type="number"
                                                    name="ulha_2" class="nilai" min="1" max="100"
                                                    value="{{ $siswa->nilai->first()->ulha_2 ?? '' }}"
                                                    @if (auth()->user()->role === 'admin') disabled @endif>
                                            </td>

                                            <td class="nilai text-center">
                                                <input form="{{ $loop->iteration }}-form-nilai" type="number"
                                                    name="ulha_3" class="nilai" min="1" max="100"
                                                    value="{{ $siswa->nilai->first()->ulha_3 ?? '' }}"
                                                    @if (auth()->user()->role === 'admin') disabled @endif>
                                            </td>

                                            <td class="nilai text-center">
                                                <input form="{{ $loop->iteration }}-form-nilai" type="number"
                                                    name="ulha_4" class="nilai" min="1" max="100"
                                                    value="{{ $siswa->nilai->first()->ulha_4 ?? '' }}"
                                                    @if (auth()->user()->role === 'admin') disabled @endif>
                                            </td>

                                            <td class="nilai text-center">
                                                <input form="{{ $loop->iteration }}-form-nilai" type="number"
                                                    name="uts" class="nilai" min="1" max="100"
                                                    value="{{ $siswa->nilai->first()->uts ?? '' }}"
                                                    @if (auth()->user()->role === 'admin') disabled @endif>
                                            </td>

                                            <td class="nilai text-center">
                                                <input form="{{ $loop->iteration }}-form-nilai" type="number"
                                                    name="uas" class="nilai" min="1" max="100"
                                                    value="{{ $siswa->nilai->first()->uas ?? '' }}"
                                                    @if (auth()->user()->role === 'admin') disabled @endif>
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
                                <td>{{ $log->subject->siswa->nama_siswa ?? 'null' }} & {{ $log->subject->mapel->nama_mapel ?? 'null' }}</td>
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

@if (auth()->user()->role === 'guru' && $view === 'kelas' && isset($kelas, $mapel))
    @section('script')
        <script>
            function saveNilai(input) {
                $.ajax({
                    type: 'post',
                    url: '{{ route('nilai.store') }}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    data: {
                        kelas_siswa_id: input.form.elements.kelas_siswa_id.value,
                        mapel_id: {{$mapel->id}},
                        nilai: input.name,
                        nilai_value: input.value,
                    },
                    success: function () {
                        input.parentElement.classList.remove('error');
                        toastr.success('Nilai berhasil disimpan.');
                    },
                    error: function () {
                        input.parentElement.classList.add('error');
                        toastr.error('Nilai tidak dapat disimpan.');
                    },
                });
            }

            $('input.nilai').on('blur', function (event) {
                var value = event.target.value;
                if (value < 0) {
                    event.target.value = 0;
                } else if (value > 100) {
                    event.target.value = 100;
                }
            });

            $('input.nilai').on('change', function (event) {
                saveNilai(event.target);
            });
        </script>
    @endsection
@endif
