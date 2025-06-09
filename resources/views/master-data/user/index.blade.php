@extends('layouts.app')

@section('heading', 'Data User')

@section('breadcrumbs')
    <li class="breadcrumb-item active">Data User</li>
@endsection

@section('content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <button type="button" class="btn btn-primary btn-sm"
                    data-toggle="modal"
                    data-target="#tambah-user">
                    <i class="nav-icon fas fa-folder-plus"></i>
                    &nbsp;
                    Tambah Data User
                </button>
            </div>

            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Role</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ ucfirst($user->role) }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if ($user->role === 'guru')
                                        <a href="{{ route('guru.show', Crypt::encrypt($user->guru->id)) }}"
                                            class="btn btn-info btn-sm">
                                            <i class="nav-icon fas fa-id-card"></i>
                                            &nbsp;
                                            Detail
                                        </a>
                                    @endif

                                    <button type="submit" form="{{ $loop->iteration }}-user-destroy"
                                        class="btn btn-danger btn-sm">
                                        <i class="nav-icon fas fa-trash-alt"></i>
                                        &nbsp;
                                        Hapus
                                    </button>

                                    <form id="{{ $loop->iteration }}-user-destroy"
                                        method="post" action="{{ route('user.destroy', $user->id) }}">
                                        @csrf
                                        @method('delete')
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="tambah-user" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Data User</h4>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form id="form-create-user" method="post" action="{{ route('user.store') }}">
                    @csrf

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="email">Email</label>

                                    <input id="email" type="email" name="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        placeholder="Alamat email"
                                        required>
                                </div>

                                <div class="form-group">
                                    <label for="role">Role</label>

                                    <select id="role" name="role"
                                        class="select2 form-control @error('role') is-invalid @enderror"
                                        required>
                                        <option value="">-- Pilih role --</option>
                                        <option value="admin">Admin</option>
                                        @if ($gurus->isNotEmpty())
                                            <option value="guru">Guru</option>
                                        @endif
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="name">Username</label>

                                    <input id="name" type="text" name="name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        placeholder="Nama user"
                                        required>
                                </div>

                                <div class="form-group" style="display: none">
                                    <label for="nip">NIP</label>

                                    <select id="nip" name="nip"
                                        class="select2 form-control @error('nip') is-invalid @enderror">
                                        <option value="">-- Pilih guru --</option>
                                        @foreach ($gurus as $guru)
                                            <option value="{{ $guru->nip }}">{{ $guru->nama_guru }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="password">Password</label>

                                    <input id="password" type="password" name="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        placeholder="Password user"
                                        required>
                                </div>

                                <div class="form-group">
                                    <label for="password-confirm">Konfirmasi Password</label>

                                    <input id="password-confirm" type="password" name="password_confirmation"
                                        class="form-control @error('password') is-invalid @enderror"
                                        placeholder="Konfirmasi password user"
                                        required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            <i class='nav-icon fas fa-arrow-left'></i>
                            &nbsp;
                            Kembali
                        </button>

                        <button type="submit" class="btn btn-primary">
                            <i class="nav-icon fas fa-save"></i>
                            &nbsp;
                            Tambahkan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $('#role').on('change', function (event) {
            var role = event.target.value;

            if (role === 'admin') {
                $('#name').parent().show();
                $('#nip').parent().hide();
            } else if (role === 'guru') {
                $('#name').parent().hide();
                $('#nip').parent().show();
            }

            $('#name')
                .attr('required', role === 'admin')
                .attr('disabled', role === 'guru');

            $('#nip')
                .attr('required', role === 'guru')
                .attr('disabled', role === 'admin');
        });
    </script>
@endsection
