@extends('layouts.app')

@section('heading', 'Edit Profile')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('profile') }}">Profile</a></li>
    <li class="breadcrumb-item active">Edit Profile</li>
@endsection

@php
    $user = auth()->user();
@endphp

@section('content')
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Edit Profile {{ $user->name }}</h3>
            </div>

            <form method="post" action="{{ route('profile.update') }}">
                @csrf
                @method('patch')

                @if ($user->role == 'admin')
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">Username</label>

                                    <input id="name" type="text" name="name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        placeholder="Nama user"
                                        value="{{ $user->name }}"
                                        required>
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif ($user->role == 'guru')
                    @php
                        $guru = $user->guru;
                    @endphp

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Username</label>

                                    <input id="name" type="text" name="name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        placeholder="Nama user"
                                        value="{{ $user->name }}"
                                        required>
                                </div>

                                <div class="form-group">
                                    <label for="jk">Jenis Kelamin</label>

                                    <select id="jk" name="jk"
                                        class="select2 form-control @error('jk') is-invalid @enderror"
                                        required>
                                        <option value="">-- Pilih Jenis Kelamin --</option>
                                        <option
                                            @if ($guru->jk == 'L') selected @endif
                                            value="L">
                                            Laki-Laki
                                        </option>
                                        <option
                                            @if ($guru->jk == 'P') selected @endif
                                            value="P">
                                            Perempuan
                                        </option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="tmp_lahir">Tempat Lahir</label>

                                    <input id="tmp_lahir" type="text" name="tmp_lahir"
                                        class="form-control @error('tmp_lahir') is-invalid @enderror"
                                        placeholder="Tempat lahir"
                                        value="{{ $guru->tmp_lahir }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nip">NIP</label>

                                    <input id="nip" type="text"
                                        class="form-control"
                                        value="{{ $guru->nip }}"
                                        readonly>
                                </div>

                                <div class="form-group">
                                    <label for="telp">Nomor Telpon/HP</label>

                                    <input id="telp" type="tel" name="telp"
                                        class="form-control @error('telp') is-invalid @enderror"
                                        placeholder="+62XXXXXXXXXXX"
                                        value="{{ $guru->telp }}">
                                </div>

                                <div class="form-group">
                                    <label for="tgl_lahir">Tanggal Lahir</label>

                                    <input id="tgl_lahir" type="date" name="tgl_lahir"
                                        class="form-control @error('tgl_lahir') is-invalid @enderror"
                                        placeholder="Tanggal lahir"
                                        value="{{ $guru->tgl_lahir ? $guru->tgl_lahir->format('Y-m-d') : null }}">
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

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
