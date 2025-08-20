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
                        <button id="button-absen" type="submit" class="btn btn-primary" disabled>
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

            if ("geolocation" in navigator) {
                const options = {
                    enableHighAccuracy: true,
                    maximumAge: 30000, // cache
                };

                function success(position) {
                    $('#button-absen').text('Hadir');

                    $.ajax({
                        type: 'post',
                        url: '{{ route('cek-lokasi') }}',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType: 'json',
                        data: {
                            latitude: position.coords.latitude,
                            longitude: position.coords.longitude,
                        },
                        success: function (data) {
                            if (data.success) {
                                $('#button-absen').prop('disabled', false);
                            } else {
                                toastr.error(data.message);
                            }
                        },
                        error: function (error) {
                            toastr.error('Tidak dapat melakukan verifikasi pada data lokasi anda.');
                        },
                    });
                }

                function error(error) {
                    $('#button-absen').text('Hadir');

                    let message = '';
                    if (error.core === 1) {
                        message = ' Akses lokasi tidak diizinkan.';
                    }
                    toastr.error('Tidak dapat mendapatkan lokasi GPS anda.' + message);
                }

                $('#button-absen').text('Mendapatkan lokasi...');

                navigator.geolocation.getCurrentPosition(success, error, options);
            } else {
                toastr.error('Fitur lokasi GPS tidak tersedia di perangkat anda.');
            }
        })
    </script>
@endsection