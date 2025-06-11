@extends('layouts.app')

@section('heading', 'Pengumuman')

@section('breadcrumbs')
    <li class="breadcrumb-item active">Pengumuman</li>
@endsection

@section('content')
    <div class="col-md-12">
        <div class="card card-outline card-info">
            <form method="post" action="{{ route('pengumuman.store') }}"
                class="form-group">
                @csrf
                <div class="card-header">
                    <button type="submit" type="submit" class="btn btn-outline-primary">
                        Simpan
                        &nbsp;
                        <i class="nav-icon fas fa-save"></i>
                    </button>
                </div>

                <div class="card-body pad">
                    <div class="mb-3">
                        <textarea id="textarea" name="isi" @error('isi') class="is-invalid" @enderror>{{ $pengumuman ?? '' }}</textarea>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $('#textarea').summernote();
    </script>
@endsection
