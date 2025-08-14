@extends('layouts.app')

@section('heading')
    Absen Harian Guru
@endsection

@section('breadcrumbs')
    <li class="breadcrumb-item active">Absensi Guru</li>
@endsection

@section('content')
    <div class="col-md-8">
        <div class="card">
            <div class="card-body p-0">
                <div id="calendar"></div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Absen Harian Guru</h3>
            </div>

            <form method="post" action="{{ route('absen-guru.store') }}">
                @csrf
                <div class="card-body">
                    @if (!$absenHariIni || ($absenHariIni && in_array($absenHariIni->keterangan, ['hadir', 'terlambat'])))
                        <h4>
                            Pukul {{ date('H:i') }} @if (date('H:i') > '07:00') (Terlambat) @endif
                        </h4>
                    @elseif ($absenHariIni && $absenHariIni->keterangan === 'selesai mengajar')
                        <p class="mb-0">Anda telah selesai mengajar untuk hari ini.</p>
                    @elseif ($absenHariIni && in_array($absenHariIni->keterangan, ['sakit', 'izin', 'bertugas keluar']))
                        <p class="mb-0">Anda {{ $absenHariIni->keterangan }} hari ini.</p>
                    @endif
                </div>

                @if (!$absenHariIni || in_array($absenHariIni->keterangan, ['hadir', 'terlambat']))
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="nav-icon fas fa-save"></i>
                            &nbsp;
                            @if (!$absenHariIni)
                                Hadir
                            @else
                                Selesai mengajar
                            @endif
                        </button>
                    </div>
                @endif
            </form>
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
                firstDay: 1,
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