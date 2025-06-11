@extends('layouts.app')

@section('heading')
    Absensi Guru
@endsection

@section('breadcrumbs')
    <li class="breadcrumb-item active">Absensi Guru</li>
@endsection

@section('content')
    <form id="form-search" method="get" action="{{ route('absensi-guru') }}"></form>

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="bulan">Bulan</label>

                            <select form="form-search" id="bulan" name="bulan" class="select2 form-control"
                                onchange="event.target.form.submit()">
                                <option selected disabled>-- Pilih Bulan --</option>
                                <option value="01" @if ($bulan === '01') selected @endif>Januari</option>
                                <option value="02" @if ($bulan === '02') selected @endif>Februari</option>
                                <option value="03" @if ($bulan === '03') selected @endif>Maret</option>
                                <option value="04" @if ($bulan === '04') selected @endif>April</option>
                                <option value="05" @if ($bulan === '05') selected @endif>Mei</option>
                                <option value="06" @if ($bulan === '06') selected @endif>Juni</option>
                                <option value="07" @if ($bulan === '07') selected @endif>Juli</option>
                                <option value="08" @if ($bulan === '08') selected @endif>Agustus</option>
                                <option value="09" @if ($bulan === '09') selected @endif>September</option>
                                <option value="10" @if ($bulan === '10') selected @endif>Oktober</option>
                                <option value="11" @if ($bulan === '11') selected @endif>November</option>
                                <option value="12" @if ($bulan === '12') selected @endif>Desember</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Hari</th>
                            <th>Waktu</th>
                            <th>Nama Guru</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($absens as $absen)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $absen->created_at->translatedFormat('l, j F') }}</td>
                                <td>{{ $absen->created_at->format('H:i') }}</td>
                                <td>{{ $absen->guru->nama_guru }}</td>
                                <td>{{ ucwords($absen->keterangan) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection