@extends('layouts.app')

@section('heading', 'Ubah Email')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('profile') }}">Profile</a></li>
    <li class="breadcrumb-item active">Ubah Email</li>
@endsection

@php
    $user = auth()->user();
@endphp

@section('content')
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Ubah Email {{ $user->name }}</h3>
            </div>

            <form method="post" action="{{ route('profile.update') }}">
                @csrf
                @method('patch')

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="email-current">Email Saat Ini</label>

                                <input id="email-current" type="email"
                                    class="form-control"
                                    value="{{ $user->email }}"
                                    disabled>
                            </div>

                            <div class="form-group">
                                <label for="email">Email Baru</label>

                                <input id="email" type="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    placeholder="Email baru"
                                    required>
                            </div>
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
                        <i class="nav-icon fas fa-save"></i>
                        &nbsp;
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
