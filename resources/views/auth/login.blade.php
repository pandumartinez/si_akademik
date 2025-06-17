@extends('layouts.auth')

@section('content')
    <div class="card-body">
        <p class="login-box-msg">Harap login terlebih dahulu</p>

        <form method="post" action="{{ route('login') }}">
            @csrf

            <div class="input-group mb-3">
                <input id="email" type="email" name="email"
                    class="form-control"
                    placeholder="Email address"
                    autocomplete="email"
                    autofocus>

                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                    </div>
                </div>
            </div>

            <div class="input-group mb-3">
                <input id="password" type="password" name="password"
                    class="form-control"
                    placeholder="Password"
                    autocomplete="current-password"
                    disabled>

                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-8">
                    <div class="icheck-primary">
                        <input id="remember" type="checkbox" name="remember"
                            disabled>

                        <label for="remember">Remember Me</label>
                    </div>
                </div>

                <div class="col-4">
                    <button id="btn-login" type="submit"
                        class="btn btn-primary btn-block"
                        disabled>
                        Login
                        &nbsp;
                        <i class="nav-icon fas fa-sign-in-alt"></i>
                    </button>
                </div>
            </div>
        </form>

        <footer class="mt-3">
            <marquee>
                <strong>Copyright &copy;
                    <script>document.write(new Date().getFullYear())</script>
                    &diams;
                    <a href="">SMA YP 17 Surabaya</a>
                </strong>
            </marquee>
        </footer>
    </div>
@endsection

@section('script')
    <script>
        function debounce(func, wait, immediate) {
            var timeout;
            return function () {
                var context = this, args = arguments;
                var later = function () {
                    timeout = null;
                    if (!immediate) func.apply(context, args);
                };
                var callNow = immediate && !timeout;
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
                if (callNow) func.apply(context, args);
            };
        };

        $('#email').keyup(debounce(function () {
            var email = $('#email').val();

            if (email.length < 5) {
                $('#email').removeClass('is-valid is-invalid');
                $('#password').val('');
                $('#password').attr('disabled', true);
                $('#remember').attr('disabled', true);
                $('#btn-login').attr('disabled', true);
                return;
            }

            $.ajax({
                type: 'post',
                url: '{{ route('auth.cek.email') }}',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                data: {
                    email: email,
                },
                success: function (data) {
                    if (data.success) {
                        $('#email').addClass('is-valid');
                        $('#email').removeClass('is-invalid');
                        $('#password').val('');
                        $('#password').removeAttr('disabled');
                    } else {
                        $('#email').addClass('is-invalid');
                        $('#email').removeClass('is-valid');
                        $('#password').val('');
                        $('#password').attr('disabled', true);
                        $('#remember').attr('disabled', true);
                        $('#btn-login').attr('disabled', true);
                    }
                },
            });
        }, 250));

        $('#password').keyup(debounce(function () {
            var email = $('#email').val();
            var password = $('#password').val();

            if (password.length === 0) {
                $('#password').removeClass('is-valid is-invalid');
                $('#remember').attr('disabled', true);
                $('#btn-login').attr('disabled', true);
                return;
            }

            $.ajax({
                type: 'post',
                url: '{{ route('auth.cek.password') }}',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                data: {
                    email: email,
                    password: password,
                },
                success: function (data) {
                    if (data.success) {
                        $('#password').addClass('is-valid');
                        $('#password').removeClass('is-invalid');
                        $('#remember').removeAttr('disabled');
                        $('#btn-login').removeAttr('disabled');
                    } else {
                        $('#password').addClass('is-invalid');
                        $('#password').removeClass('is-valid');
                        $('#remember').attr('disabled', true);
                        $('#btn-login').attr('disabled', true);
                    }
                },
            });
        }, 250));
    </script>
@endsection
