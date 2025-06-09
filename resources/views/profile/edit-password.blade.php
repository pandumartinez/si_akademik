@extends('layouts.app')

@section('heading', 'Ubah Password')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('profile') }}">Profile</a></li>
    <li class="breadcrumb-item active">Ubah Password</li>
@endsection

@php
    $user = auth()->user();
@endphp

@section('content')
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Ubah Password {{ $user->name }}</h3>
            </div>

            <form method="post" action="{{ route('profile.update') }}">
                @csrf
                @method('patch')

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="password-current">Password Lama</label>

                                <input id="password-current" type="password" name="password_current"
                                    class="form-control @error('password_current') is-invalid @enderror"
                                    autocomplete="current-password"
                                    placeholder="Password saat ini"
                                    required>
                            </div>

                            <div class="form-group">
                                <label for="password">Password Baru</label>

                                <input id="password" type="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    autocomplete="new-password"
                                    placeholder="Password baru"
                                    required>
                            </div>

                            <div class="form-group">
                                <label for="password-confirm">Konfirmasi Password</label>

                                <input id="password-confirm" type="password" name="password_confirmation"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Konfirmasi password baru"
                                    autocomplete="new-password"
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
