@extends('layouts.app')

@section('heading')
    Absensi Guru
@endsection

@section('breadcrumbs')
    <li class="breadcrumb-item active">Absensi Guru</li>
@endsection

@section('content')
    <form id="form-search" method="get" action="{{ route('absen-guru.index') }}"></form>

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="form-group">
                        <label for="guru">Nama Guru</label>

                        <select form="form-search" id="guru" name="guru" class="select2 form-control"
                            onchange="event.target.form.submit()">
                            <option selected disabled>-- Pilih Nama Guru --</option>
                            @foreach ($guruList as $guru)
                                <option value="{{ $guru->id }}" @if (request()->guru == $guru->id) selected @endif>
                                    {{ $guru->nama_guru }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-absen">
                        <i class="nav-icon fas fa-folder-plus"></i>
                        &nbsp;
                        Absensi Guru
                    </button>
                </div>
            </div>

            <div class="card-body p-0">
                <div id="calendar"></div>
            </div>
        </div>
    </div>

    <div id="modal-absen" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Absensi Guru</h4>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form method="post" action="{{ route('absen-guru.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="guru">Nama Guru</label>

                                    <select id="guru" name="guru[]" multiple="multiple"
                                        class="select2 form-control @error('guru') is-invalid @enderror" required>
                                        @foreach ($guruList as $guru)
                                            <option value="{{ $guru->id }}">
                                                {{ $guru->nama_guru }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="keterangan">Keterangan Kehadiran</label>

                                    <select id="keterangan" name="keterangan"
                                        class="select2 form-control @error('jk') is-invalid @enderror" required>
                                        <option value="">-- Pilih Keterangan Kehadiran --</option>
                                        <option value="sakit">Sakit</option>
                                        <option value="izin">Izin</option>
                                        <option value="bertugas keluar">Bertugas keluar</option>
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
                            <span>Simpan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.css' rel='stylesheet'>
@endpush

@section('script')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.18/index.global.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.18/locales/id.global.min.js'></script>

    <script>
        $(function () {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                locale: 'id',
                firstDay: 0,
                slotMinTime: '06:00',
                slotMaxTime: '19:00',
                initialView: 'timeGridDay',
                themeSystem: 'bootstrap',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: {{ Illuminate\Support\Js::from($absens) }},
            });

            calendar.render();
        })
    </script>
@endsection