@extends('layouts.app')

@section('heading', 'Profile')

@section('breadcrumbs')
    <li class="breadcrumb-item active">Profile</li>
@endsection

@php
    $user = auth()->user();
@endphp

@section('content')
    <div class="col-md-5">
        <div class="card card-primary card-outline">
            <div class="card-body">
                <div class="text-center">
                    @if ($user->role == 'guru')
                        <a href="{{ asset($user->guru->foto) }}" data-toggle="lightbox"
                            data-title="Foto {{ $user->guru->nama_guru }}" data-gallery="gallery"
                            data-footer='
                                <a href="{{ route('profile.edit', ['page' => 'foto']) }}"
                                    class="btn btn-link btn-block btn-light">
                                    <i class="nav-icon fas fa-file-upload"></i>
                                    &nbsp;
                                    Ubah Foto
                                </a>'>
                            <img src="{{ asset($user->guru->foto) }}" class="profile-user-img img-fluid img-circle"
                                style="object-position: center; object-fit: cover; aspect-ratio: 1 / 1;">
                        </a>
                    @else
                        <img src="{{ asset('img/admin-picture.jpg') }}" class="profile-user-img img-fluid img-circle"
                            style="object-position: center; object-fit: cover; aspect-ratio: 1 / 1;">
                    @endif
                </div>

                <h3 class="profile-username text-center">
                    {{ $user->name }}
                </h3>

                <p class="text-muted text-center">
                    {{ ucfirst($user->role) }}
                </p>

                @if ($user->role == 'guru')
                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>NIP</b>
                            <a class="float-right">{{ $user->guru->nip }}</a>
                        </li>
                    </ul>
                @endif

                <a href="{{ route('profile.edit') }}" class="btn btn-primary btn-block">
                    <b>Edit Profile</b>
                </a>
            </div>
        </div>

        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Pengaturan Akun</h3>
            </div>

            <ul class="list-group list-group-unbordered">
                <li class="list-group-item px-4 d-flex align-items-center justify-content-between">
                    <i class="nav-icon fas fa-envelope"></i>
                    <span class="ml-4 mr-auto">Ubah Email</span>
                    <a href="{{ route('profile.edit', ['page' => 'email']) }}" class="float-right btn btn-default btn-sm">
                        Edit
                    </a>
                </li>

                <li class="list-group-item px-4 d-flex align-items-center justify-content-between">
                    <i class="nav-icon fas fa-key"></i>
                    <span class="ml-4 mr-auto">Ubah Password</span>
                    <a href="{{ route('profile.edit', ['page' => 'password']) }}"
                        class="float-right btn btn-default btn-sm">
                        Edit
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="col-md-7">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">About Me</h3>
            </div>
            <div class="card-body">
                <strong>
                    <i class="far fa-envelope mr-1"></i>
                    Email
                </strong>
                <p class="text-muted">
                    {{ $user->email }}
                </p>

                @if ($user->role == 'guru')
                    <hr>
                    <strong>
                        <i class="fas fa-book mr-1"></i>
                        Guru Mapel
                    </strong>
                    <p class="text-muted">
                        {{ $user->guru->mapel->map(fn($mapel) => $mapel->nama_mapel)->join(', ') }}
                    </p>
                    <hr>

                    <strong>
                        <i class="fas fa-map-marker-alt mr-1"></i>
                        Tempat Lahir
                    </strong>
                    <p class="text-muted">
                        {{ $user->guru->tmp_lahir ?? '-' }}
                    </p>
                    <hr>

                    <strong>
                        <i class="far fa-calendar mr-1"></i>
                        Tanggal Lahir
                    </strong>
                    <p class="text-muted">
                        {{ $user->guru->tgl_lahir ? $user->guru->tgl_lahir->format('d F Y') : '-' }}
                    </p>
                    <hr>

                    <strong>
                        <i class="fas fa-phone mr-1"></i>
                        No. Telepon
                    </strong>
                    <p class="text-muted">
                        {{ $user->guru->telp ?? '-' }}
                    </p>
                @endif
            </div>
        </div>
    </div>
@endsection
