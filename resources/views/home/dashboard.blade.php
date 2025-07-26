@extends('layouts.app')

@section('heading', 'Dashboard')

@section('breadcrumbs')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
    <div class="col-lg-4 col-6">
        <div class="small-box bg-teal">
            <div class="inner">
                <h3>{{ $user }}</h3>
                <p>User</p>
            </div>
            <div class="icon">
                <i class="fas fa-users nav-icon"></i>
            </div>
            <a href="{{ route('user.index') }}" class="small-box-footer">
                More info
                <i class="ml-1 fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-4 col-6">
        <div class="small-box bg-purple">
            <div class="inner">
                <h3>{{ $guru['total'] }}</h3>
                <p>Guru</p>
            </div>
            <div class="icon">
                <i class="fas fa-id-card nav-icon"></i>
            </div>
            <a href="{{ route('guru.index') }}" class="small-box-footer">
                More info
                <i class="ml-1 fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-4 col-6">
        <div class="small-box bg-olive">
            <div class="inner">
                <h3>{{ $siswa['total'] }}</h3>
                <p>Siswa</p>
            </div>
            <div class="icon">
                <i class="fas fa-id-card nav-icon"></i>
            </div>
            <a href="{{ route('kelas.index') }}" class="small-box-footer">
                More info
                <i class="ml-1 fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-4 col-6">
        <div class="small-box bg-fuchsia">
            <div class="inner">
                <h3>{{ $mapel }}</h3>
                <p>Mapel</p>
            </div>
            <div class="icon">
                <i class="fas fa-book nav-icon"></i>
            </div>
            <a href="{{ route('mapel.index') }}" class="small-box-footer">
                More info
                <i class="ml-1 fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-4 col-6">
        <div class="small-box bg-maroon">
            <div class="inner">
                <h3>{{ $kelas }}</h3>
                <p>Kelas</p>
            </div>
            <div class="icon">
                <i class="fas fa-chalkboard-teacher nav-icon"></i>
            </div>
            <a href="{{ route('kelas.index') }}" class="small-box-footer">
                More info
                <i class="ml-1 fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-4 col-6">
        <div class="small-box bg-indigo">
            <div class="inner">
                <h3>{{ $jadwal }}</h3>
                <p>Jadwal</p>
            </div>
            <div class="icon">
                <i class="fas fa-calendar-alt nav-icon"></i>
            </div>
            <a href="{{ route('kelas.index') }}" class="small-box-footer">
                More info
                <i class="ml-1 fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex">
                    <p class="d-flex flex-column">
                        <span class="text-bold text-lg">Data Guru</span>
                    </p>
                </div>
                <div class="position-relative mb-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="chart-responsive">
                                <canvas id="chart-guru"></canvas>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <ul class="chart-legend clearfix">
                                <li>
                                    <i class="fas fa-circle text-primary mr-2"></i>
                                    Laki-laki
                                </li>
                                <li>
                                    <i class="fas fa-circle text-danger mr-2"></i>
                                    Perempuan
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex">
                    <p class="d-flex flex-column">
                        <span class="text-bold text-lg">Data Siswa</span>
                    </p>
                </div>
                <div class="position-relative mb-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="chart-responsive">
                                <canvas id="chart-siswa"></canvas>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <ul class="chart-legend clearfix">
                                <li>
                                    <i class="fas fa-circle text-primary mr-2"></i>
                                    Laki-laki
                                </li>
                                <li>
                                    <i class="fas fa-circle text-danger mr-2"></i>
                                    Perempuan
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            new Chart($('#chart-guru').get(0).getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: ['Laki-laki', 'Perempuan'],
                    datasets: [
                        {
                            data: [{{ $guru['L'] }}, {{ $guru['P'] }}],
                            backgroundColor: ['#007BFF', '#DC3545'],
                        }
                    ],
                },
                options: {
                    legend: { display: false },
                },
            })

            new Chart($('#chart-siswa').get(0).getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: ['Laki-laki', 'Perempuan'],
                    datasets: [
                        {
                            data: [{{ $siswa['L'] }}, {{ $siswa['P'] }}],
                            backgroundColor: ['#007BFF', '#DC3545'],
                        },
                    ],
                },
                options: {
                    legend: { display: false },
                },
            })
        })
    </script>
@endsection
