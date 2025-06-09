<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Sistem Informasi Akademik Sekolah</title>

    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">

    <style>
        .login-page {
            background-image: url('{{ asset("img/bg-login.jpeg") }}');
            background-attachment: fixed;
            background-position: center center;
            background-size: 100%;
        }
    </style>
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <img src="{{ asset('img/emblem-with-text.png') }}" width="100%">
            </div>
            @yield('content')
        </div>
    </div>

    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>

    @yield('script')
</body>
</html>
