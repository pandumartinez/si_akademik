@extends('layouts.app')

@section('heading', 'Predikat')

@section('breadcrumbs')
    <li class="breadcrumb-item active">Predikat</li>
@endsection

@section('content')
    <div class="col-md-12">
        <div class="card card-outline card-info">
            <form method="post" action="{{ route('predikat.store') }}">
                @csrf
                <div class="card-header">
                    <button type="submit" class="btn btn-outline-primary">
                        Simpan
                        &nbsp;
                        <i class="nav-icon fas fa-save"></i>
                    </button>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="predikat_a">Predikat A</label>

                                <input id="predikat_a" type="number" name="predikat_a"
                                    class="form-control @error('predikat_a') is-invalid @enderror"
                                    placeholder="Batas bawah predikat A" min="0" max="100"
                                    value="{{ $predikat->A }}" required>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="predikat_b">Predikat B</label>

                                <input id="predikat_b" type="number" name="predikat_b"
                                    class="form-control @error('predikat_b') is-invalid @enderror"
                                    placeholder="Batas bawah predikat B" min="0" max="100"
                                    value="{{ $predikat->B }}" required>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="predikat_c">Predikat C</label>

                                <input id="predikat_c" type="number" name="predikat_c"
                                    class="form-control @error('predikat_c') is-invalid @enderror"
                                    placeholder="Batas bawah predikat C" min="0" max="100"
                                    value="{{ $predikat->C }}" required>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="predikat_d">Predikat D</label>

                                <input id="predikat_d" type="number"
                                    class="form-control"
                                    placeholder="Batas bawah selalu 0" 
                                     disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection