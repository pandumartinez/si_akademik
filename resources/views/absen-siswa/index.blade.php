@extends('layouts.app')

@section('heading')
    Absensi Kelas {{ $kelas->nama_kelas }}
    Hari {{ \Carbon\Carbon::now()->translatedFormat('l, j F') }}
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
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    @if (isset($kelas, $siswa))
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

                                <dt class="col-sm-3">Jumlah Siswa</dt>
                                <dd class="col-sm-3">{{ $kelas->siswa_count }}</dd>
                            </dl>
                        </div>

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
                                        <tr>
                                            <form id="{{ $loop->iteration }}-form-absen">
                                                <input type="hidden" name="siswa_id" value="{{ $siswa->id }}">
                                            </form>

                                            <td class="text-center">{{ $siswa->nis }}</td>

                                            <td>{{ $siswa->nama_siswa }}</td>

                                            <td class="absen">
                                                <input form="{{ $loop->iteration }}-form-absen" type="checkbox"
                                                    class="absen" name="keterangan" value="izin"
                                                    @if ($siswa->absenHariIni && $siswa->absenHariIni->keterangan === 'izin') checked @endif>
                                            </td>

                                            <td class="absen">
                                                <input form="{{ $loop->iteration }}-form-absen" type="checkbox"
                                                    class="absen" name="keterangan" value="sakit"
                                                    @if ($siswa->absenHariIni && $siswa->absenHariIni->keterangan === 'sakit') checked @endif>
                                            </td>

                                            <td class="absen">
                                                <input form="{{ $loop->iteration }}-form-absen" type="checkbox"
                                                    class="absen" name="keterangan" value="tanpa keterangan"
                                                    @if ($siswa->absenHariIni && $siswa->absenHariIni->keterangan === 'tanpa keterangan') checked @endif>
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
            function saveAbsen(input) {
                $.ajax({
                    type: 'post',
                    url: '{{ route('absen-siswa.store') }}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    data: {
                        siswa_id: input.form.elements.siswa_id.value,
                        keterangan: input.value,
                    },
                    success: function() {
                        input.parentElement.classList.remove('error');
                        toastr.success('Absen berhasil disimpan.');
                    },
                    error: function() {
                        input.parentElement.classList.add('error');
                        toastr.error('Absen tidak dapat disimpan.');
                    },
                });
            }

            $('input.absen').on('change', function(event) {
                saveAbsen(event.target);

                var formId = event.target.form.id;

                $(`input.absen[value="izin"][form="${formId}"`)
                    .attr('disabled', event.target.checked && event.target.value !== 'izin');

                $(`input.absen[value="sakit"][form="${formId}"`)
                    .attr('disabled', event.target.checked && event.target.value !== 'sakit');

                $(`input.absen[value="tanpa keterangan"][form="${formId}"`)
                    .attr('disabled', event.target.checked && event.target.value !== 'tanpa keterangan');
            });
        </script>
    @endsection
@endif
