@extends('layouts.app')

@section('heading')
    Deskripsi Rapot
@endsection

@section('breadcrumbs')
    <li class="breadcrumb-item active">Deskripsi Rapot</li>
@endsection

@section('content')
    <form id="form-search" method="get" action="{{ route('deskripsi-predikat.index') }}"></form>

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    @if(Auth::user()->role === 'admin')
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="guru">Guru</label>

                                <select form="form-search" id="guru" name="guru" class="select2 form-control"
                                    onchange="event.target.form.submit()">
                                    <option selected disabled>-- Pilih Guru --</option>
                                    @foreach (\App\Guru::all() as $_guru)
                                        <option value="{{ $_guru->nama_guru }}" @if (isset($guru) && $guru->id === $_guru->id)
                                        selected @endif>
                                            {{ $_guru->nama_guru }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="jenis">Jenis</label>

                            <select form="form-search" id="jenis" name="jenis" class="select2 form-control"
                                onchange="event.target.form.submit()">
                                <option selected disabled>-- Pilih Jenis --</option>
                                <option value="pengetahuan" @if (isset($jenis) && $jenis === 'pengetahuan') selected @endif>
                                    Pengetahuan
                                </option>
                                <option value="keterampilan" @if (isset($jenis) && $jenis === 'keterampilan') selected @endif>
                                    Keterampilan
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    @if (!isset($jenis, $guru))
                        <div class="col-md-12">
                            <p class="mb-0 text-center text-muted">
                                @if (Auth::user()->role === 'admin')
                                    Pilih jenis dan guru terlebih dahulu
                                @else
                                    Pilih jenis terlebih dahulu
                                @endif
                            </p>
                        </div>
                    @endif

                    @if (isset($jenis, $guru))
                        <div class="col-md-12">
                            <dl class="row">
                                <dt class="col-sm-3">Mata Pelajaran</dt>
                                @foreach ($guru->mapel as $mapel)
                                    <dd class="col-sm-3">{{ $mapel->nama_mapel }}</dd>
                                @endforeach
                            </dl>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="A">Predikat A</label>
                                <textarea class="deskripsi form-control" name="A" id="A" rows="4"
                                    placeholder="Isikan deskripsi untuk predikat A" @if (Auth::user()->role === 'admin') disabled
                                    @endif>{{ $deskripsi['A'] }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="C">Predikat C</label>
                                <textarea class="deskripsi form-control" name="C" id="C" rows="4"
                                    placeholder="Isikan deskripsi untuk predikat C" @if (Auth::user()->role === 'admin') disabled
                                    @endif>{{ $deskripsi['C'] }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="B">Predikat B</label>
                                <textarea class="deskripsi form-control" name="B" id="B" rows="4"
                                    placeholder="Isikan deskripsi untuk predikat B" @if (Auth::user()->role === 'admin') disabled
                                    @endif>{{ $deskripsi['B'] }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="D">Predikat D</label>
                                <textarea class="deskripsi form-control" name="D" id="D" rows="4"
                                    placeholder="Isikan deskripsi untuk predikat D" @if (Auth::user()->role === 'admin') disabled
                                    @endif>{{ $deskripsi['D'] }}</textarea>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@if (Auth::user()->role === 'guru' && isset($jenis, $guru))
    @section('script')
        <script>
            function saveDeskripsi(input) {
                $.ajax({
                    type: 'post',
                    url: '{{ route('deskripsi-predikat.store') }}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    data: {
                        jenis: '{{ $jenis }}',
                        predikat: input.name,
                        deskripsi: input.value,
                    },
                    success: function () {
                        toastr.success('Deskripsi berhasil disimpan.');
                    },
                    error: function () {
                        toastr.error('Deskripsi tidak dapat disimpan.');
                    },
                });
            }

            $('textarea.deskripsi').on('change', function (event) {
                saveDeskripsi(event.target);
            });
        </script>
    @endsection
@endif