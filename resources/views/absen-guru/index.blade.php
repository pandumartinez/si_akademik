@extends('layouts.app')

@section('heading')
    Absen Harian Guru
@endsection

@section('breadcrumbs')
    <li class="breadcrumb-item active">Absensi Guru</li>
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
    <div class="card">
        <div class="card-body">
          <table id="example1" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Guru</th>
                    <th>Ket.</th>
                    <th width="80px">Jam Absen</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($absen as $data)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $data->guru->nama_guru }}</td>
                        <td>{{ $data->kehadiran->ket }}</td>
                        <td>{{ $data->created_at->format('H:i:s') }}</td>
                    </tr>
                @endforeach
            </tbody>
          </table>
        </div>
    </div>
</div>
<div class="col-md-6">
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Absen Harian Guru</h3>
      </div>
      <form action="" method="post">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="id_card">Nomor ID Card</label>
                <input type="text" id="id_card" name="id_card" maxlength="5" onkeypress="return inputAngka(event)" class="form-control @error('id_card') is-invalid @enderror">
            </div>
            <div class="form-group">
              <label for="kehadiran_id">Keterangan Kehadiran</label>
              <select id="kehadiran_id" type="text" class="form-control @error('kehadiran_id') is-invalid @enderror select2bs4" name="kehadiran_id">
                <option value="">-- Pilih Keterangan Kehadiran --</option>
                {{-- @foreach ($kehadiran as $data)
                  <option value="{{ $data->id }}">{{ $data->ket }}</option> 
                @endforeach --}}
              </select>
            </div>
        </div>
        <div class="card-footer">
          <button name="submit" class="btn btn-primary"><i class="nav-icon fas fa-save"></i> &nbsp; Absen</button>
        </div>
      </form>
    </div>
</div>
@endsection

{{-- @if (auth()->user()->role === 'guru')
    @section('script')
        <script>
            function saveAbsen(input) {
                $.ajax({
                    type: 'post',
                    url: '{{ route('absen-guru.store') }}',
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
                    },
                    error: function() {
                        input.parentElement.classList.add('error');
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
@endif --}}
