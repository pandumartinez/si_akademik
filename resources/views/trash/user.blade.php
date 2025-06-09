@extends('layouts.app')

@section('heading', 'Trash User')

@section('breadcrumbs')
    <li class="breadcrumb-item active">Trash User</li>
@endsection

@section('content')
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Trash Data User</h3>
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
                                <td>{{ $user->role }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <button type="submit" form="{{ $loop->iteration }}-user-restore"
                                        class="btn btn-success btn-sm">
                                        <i class="nav-icon fas fa-undo"></i>
                                        &nbsp;
                                        Restore
                                    </button>

                                    <button type="submit" form="{{ $loop->iteration }}-user-destroy"
                                        class="btn btn-danger btn-sm">
                                        <i class="nav-icon fas fa-trash-alt"></i>
                                        &nbsp;
                                        Hapus
                                    </button>

                                    <form id="{{ $loop->iteration }}-user-restore"
                                        method="post" action="{{ route('user.restore', $user->id) }}">
                                        @csrf
                                    </form>

                                    <form id="{{ $loop->iteration }}-user-destroy"
                                        method="post" action="{{ route('user.destroy.permanent', $user->id) }}">
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
@endsection
