@extends('layouts.app')

@section('heading')
    @if (isset($kelas, $mapel))
        Nilai Rapot {{ $mapel->nama_mapel }} {{ $kelas->nama_kelas }}
    @else
        Nilai Rapot
    @endif
@endsection

@section('breadcrumbs')
    <li class="breadcrumb-item active">Nilai Rapot</li>
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

        input.sikap {
            text-transform: uppercase;
        }
    </style>
@endpush

@section('content')
    <form id="form-search" method="get" action="{{ route('rapot-uts.index') }}"></form>

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-3">
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

                    @if (isset($mapelList))
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="mapel">Mata Pelajaran</label>

                                <select form="form-search" id="mapel" name="mapel" class="select2 form-control"
                                    onchange="event.target.form.submit()">
                                    <option selected disabled>-- Pilih Mapel --</option>
                                    @foreach ($mapelList as $_mapel)
                                        <option value="{{ $_mapel->nama_mapel }}_{{ $_mapel->kelompok }}"
                                            @if (isset($mapel) && $_mapel->id === $mapel->id) selected @endif>
                                            {{ $_mapel->nama_mapel }} ({{ $_mapel->kelompok }})
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
                    @if (!isset($kelas, $mapel))
                        <div class="col-md-12">
                            <p class="mb-0 text-center text-muted">
                                Pilih kelas dan mata pelajaran terlebih dahulu
                            </p>
                        </div>
                    @endif

                    @if (isset($kelas, $mapel))
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
                                        <th colspan="2" class="text-center">Nilai Tugas</th>
                                        <th colspan="2" class="text-center">Nilai Ulangan Harian</th>
                                        <th rowspan="2" class="text-center">UTS</th>
                                        <th rowspan="2" class="text-center">Praktik</th>
                                        <th rowspan="2" class="text-center">Sikap</th>
                                    </tr>
                                    <tr class="text-center">
                                        <th>Tugas 1</th>
                                        <th>Tugas 2</th>
                                        <th>Ulha 1</th>
                                        <th>Ulha 2</th>
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
                                                    value="{{ $siswa->rapotUts->first()->tugas_1 ?? '' }}" disabled>
                                            </td>

                                            <td class="nilai text-center">
                                                <input form="{{ $loop->iteration }}-form-nilai" type="number"
                                                    name="tugas_2" class="nilai" min="1" max="100"
                                                    value="{{ $siswa->rapotUts->first()->tugas_2 ?? '' }}" disabled>
                                            </td>

                                            <td class="nilai text-center">
                                                <input form="{{ $loop->iteration }}-form-nilai" type="number"
                                                    name="ulha_1" class="nilai" min="1" max="100"
                                                    value="{{ $siswa->rapotUts->first()->ulha_1 ?? '' }}" disabled>
                                            </td>

                                            <td class="nilai text-center">
                                                <input form="{{ $loop->iteration }}-form-nilai" type="number"
                                                    name="ulha_2" class="nilai" min="1" max="100"
                                                    value="{{ $siswa->rapotUts->first()->ulha_2 ?? '' }}" disabled>
                                            </td>

                                            <td class="nilai text-center">
                                                <input form="{{ $loop->iteration }}-form-nilai" type="number"
                                                    name="uts" class="nilai" min="1" max="100"
                                                    value="{{ $siswa->rapotUts->first()->uts ?? '' }}" disabled>
                                            </td>

                                            <td class="nilai text-center">
                                                <input form="{{ $loop->iteration }}-form-nilai" type="number"
                                                    name="praktik" class="nilai" min="1" max="100"
                                                    value="{{ $siswa->rapotUts->first()->praktik ?? '' }}"
                                                    @if (auth()->user()->role === 'admin') disabled @endif>
                                            </td>

                                            <td class="nilai text-center">
                                                <input form="{{ $loop->iteration }}-form-nilai" type="text"
                                                    name="sikap" class="nilai sikap" maxlength="1"
                                                    value="{{ $siswa->rapotUts->first()->sikap ?? '' }}"
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
    </div>
@endsection

@if (auth()->user()->role === 'guru' && isset($kelas, $mapel))
    @section('script')
        <script>
            function saveNilai(input) {
                $.ajax({
                    type: 'post',
                    url: '{{ route('rapot-uts.store') }}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    data: {
                        kelas_siswa_id: input.form.elements.kelas_siswa_id.value,
                        mapel_id: {{ $mapel->id }},
                        nilai: input.name,
                        nilai_value: input.value,
                    },
                    success: function() {
                        input.parentElement.classList.remove('error');
                        toastr.success('Nilai berhasil disimpan.');
                    },
                    error: function() {
                        input.parentElement.classList.add('error');
                        toastr.error('Nilai tidak dapat disimpan.');
                    },
                });
            }

            $('input.nilai').on('blur', function(event) {
                var value = event.target.value;
                if (value < 0) {
                    event.target.value = 0;
                } else if (value > 100) {
                    event.target.value = 100;
                }
            });

            $('input.nilai').on('change', function(event) {
                saveNilai(event.target);
            });

            $('input.sikap').on('keydown', function(event) {
                var which = event.which
                if ((which >= 33 && which <= 126) && (event.which < 65 || event.which > 69)) {
                    event.preventDefault();
                }
            });
        </script>
    @endsection
@endif
