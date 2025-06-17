@extends('layouts.app')

@section('heading', 'Periode Akademik')

@section('breadcrumbs')
    <li class="breadcrumb-item">Pengaturan</li>
    <li class="breadcrumb-item active">Periode Akademik</li>
@endsection

@section('content')
    <form id="form-periode" method="post" action="{{ route('periode.store') }}">
        @csrf
    </form>

    <div class="col-md-12">
        <div class="card card-outline card-info">
            <div class="card-body pad">
                <dl class="border-bottom">
                    <dt>Periode Aktif</dt>
                    <dd>{{ $periode }}</dd>
                </dl>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="periode">Periode Baru</label>

                            <input disabled form="form-periode" id="periode" type="text" class="form-control"
                                value="Periode Baru ">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="semester">Semester</label>

                            <select form="form-periode" id="semester" name="semester"
                                class="select2 form-control @error('semester') is-invalid @enderror" required>
                                <option value="ganjil">Ganjil</option>
                                <option value="genap">Genap</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="tanggal_awal">Tanggal Awal</label>

                            <input form="form-periode" id="tanggal_awal" type="date" name="tanggal_awal"
                                class="form-control @error('tanggal_awal') is-invalid @enderror" required>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="tanggal_akhir">Tanggal Akhir</label>

                            <input form="form-periode" id="tanggal_akhir" type="date" name="tanggal_akhir"
                                class="form-control @error('tanggal_akhir') is-invalid @enderror" required>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" form="form-periode" class="btn btn-primary">
                    <i class="nav-icon fas fa-save"></i>
                    &nbsp;
                    Tambah Periode Baru
                </button>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function updatePeriodeBaru() {
            if (!$('#tanggal_awal').val()) return;

            var tahun = $('#tanggal_awal').val().substring(0, 4);
            var semester = $('#semester option:selected').text();
            $('#periode').val(`${tahun}-${Number.parseInt(tahun) + 1} ${semester}`);
        }

        $('#semester').on('change', function (event) {
            updatePeriodeBaru();
        });

        $('#tanggal_awal').on('change', function (event) {
            $('#tanggal_akhir').attr('min', event.target.value);

            updatePeriodeBaru();

            var tanggalAwalDate = new Date(event.target.value);
            var tanggalAkhir = addMonths(tanggalAwalDate, 6);
            $('#tanggal_akhir').val(tanggalAkhir.toISOString().substring(0, 10));
        });

        function addMonths(date, n) {
            const result = new Date(date);
            result.setMonth(result.getMonth() + n);
            return result;
        }
    </script>
@endsection