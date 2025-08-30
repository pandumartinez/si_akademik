@extends('layouts.app')

@section('heading', 'Pengumuman')

@section('breadcrumbs')
    <li class="breadcrumb-item">Pengaturan</li>
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

        @if (auth()->user()->role === 'admin')
        <div class="card">
            <div class="card-header">
            </div>

            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Timestamp</th>
                            <th>Subject</th>
                            <th>Action</th>
                            <th>Actor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($activities as $log)
                            <tr data-toggle="collapse" data-target="#log-detail-{{ $loop->iteration }}" style="cursor: pointer;">
                                <td>{{ $log->created_at }}</td>
                                <td>{{ $log->subject->key ?? 'null' }}</td>
                                <td>{{ $log->description }}</td>
                                <td>{{ $log->causer->name }}</td>
                            </tr>
                            <tr class="collapse" id="log-detail-{{ $loop->iteration }}">
                                <td colspan="4">
                                    <div style="max-width: 100%; overflow-x: auto;">
                                        <pre
                                            style="white-space: pre; margin: 0;">{{ json_encode($log->changes, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
@endsection

@section('script')
    <script>
        $('#textarea').summernote();
    </script>
@endsection
