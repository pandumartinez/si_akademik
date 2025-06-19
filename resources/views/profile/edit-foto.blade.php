@extends('layouts.app')

@section('heading', 'Ubah Foto')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('profile') }}">Profile</a></li>
    <li class="breadcrumb-item active">Ubah Foto</li>
@endsection

@php
    $guru = auth()->user()->guru;
@endphp

@section('content')
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="card-title">Form Ubah Foto</h3>
                    </div>
                    <div class="col-md-6">
                        <h3 class="card-title">Foto saat ini</h3>
                    </div>
                </div>
            </div>

            <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('patch')

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_guru">Nama Guru</label>

                                <input id="nama_guru" type="text"
                                    class="form-control"
                                    value="{{ $guru->nama_guru }}"
                                    readonly>
                            </div>

                            <div class="form-group">
                                <label for="foto">File input</label>

                                <div class="input-group">
                                    <div class="custom-file">
                                        <input id="foto" type="file" name="foto"
                                            class="custom-file-input @error('foto') is-invalid @enderror"
                                            onchange="previewFoto(event)">

                                        <label for="foto" class="custom-file-label">Choose file</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <img
                                id="foto-preview"
                                src="{{ asset($guru->foto) }}"
                                class="img img-responsive"
                                style="height: 12rem;" />
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <a href="{{ route('profile') }}" class="btn btn-default">
                        <i class='nav-icon fas fa-arrow-left'></i>
                        &nbsp;
                        Kembali
                    </a>
                    &nbsp;
                    <button type="submit" class="btn btn-primary">
                        <i class="nav-icon fas fa-upload"></i>
                        &nbsp;
                        Upload
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bs-custom-file-input/1.3.4/bs-custom-file-input.min.js"></script>
    <script>
        $(document).ready(function () {
            bsCustomFileInput.init()
        })

        function previewFoto(event) {
            console.log('previewFoto', event)
            const reader = new FileReader();

            reader.onloadend = function () {
                $('#foto-preview').attr('src', reader.result)
            }

            const file = event.target.files[0];

            if (file) {
                reader.readAsDataURL(file);
            } else {
                $('#foto-preview').attr('src', '{{ asset($guru->foto) }}');
            }
        }

    </script>
@endsection
