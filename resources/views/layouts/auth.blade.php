<!DOCTYPE html>
<html lang="id" data-layout-mode="light_mode" data-layout="without-header" data-color="magenta">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Dreams POS is a powerful Bootstrap based Inventory Management Admin Template designed for businesses, offering seamless invoicing, project tracking, and estimates.">
    <meta name="keywords"
        content="inventory management, admin dashboard, bootstrap template, invoicing, estimates, business management, responsive admin, POS system">
    <meta name="author" content="Dreams Technologies">
    <meta name="robots" content="index, follow">
    <title>Asta Warehouse - Login</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/favicon.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/apple-touch-icon.png') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/tabler-icons/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <style>
        .bg-login {
            --s: 200px;
            /* control the size*/
            --c1: #f2f2f230;
            --c2: #cdcbcc30;
            --c3: #99999930;

            --_g: 0 120deg, #0000 0;
            background:
                conic-gradient(at calc(250%/3) calc(100%/3), var(--c3) var(--_g)),
                conic-gradient(from -120deg at calc(50%/3) calc(100%/3), var(--c2) var(--_g)),
                conic-gradient(from 120deg at calc(100%/3) calc(250%/3), var(--c1) var(--_g)),
                conic-gradient(from 120deg at calc(200%/3) calc(250%/3), var(--c1) var(--_g)),
                conic-gradient(from -180deg at calc(100%/3) 50%, var(--c2) 60deg, var(--c1) var(--_g)),
                conic-gradient(from 60deg at calc(200%/3) 50%, var(--c1) 60deg, var(--c3) var(--_g)),
                conic-gradient(from -60deg at 50% calc(100%/3), var(--c1) 120deg, var(--c2) 0 240deg, var(--c3) 0);
            background-size: calc(var(--s)*sqrt(3)) var(--s);
        }
    </style>
</head>

<body class="account-page bg-white">
    <div class="main-wrapper">
        <div class="account-content">
            <div class="row login-wrapper bg-login m-0">
                <div class="col-lg-6 p-0">
                    <div class="login-content">
                        @yield('content')
                    </div>
                </div>
                <div class="col-lg-6 p-0">
                    <div class="login-img">
                        <img src="{{ asset('assets/img/login.jpg') }}" alt="img">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    {{--
    <script src="{{ asset('assets/js/script.js') }}"></script> --}}
    @include('layouts.includes.script')
    <script>
        // Pilih semua elemen dengan class 'toggle-password'
        const togglePassword = document.querySelectorAll('.toggle-password');

        togglePassword.forEach(icon => {
            icon.addEventListener('click', function (e) {
                // Dapatkan elemen input password di dalam 'pass-group' yang sama
                const passInput = document.querySelectorAll('.pass-input');;

                // Cek tipe input saat ini
                const type = passInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passInput.setAttribute('type', type);

                // Ganti ikon mata
                this.classList.toggle('ti-eye');
                this.classList.toggle('ti-eye-slash');
            });
        });
    </script>
</body>

</html>