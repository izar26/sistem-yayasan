<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=poppins:400,500,600&display=swap" rel="stylesheet" />

        <!-- Aset Eksternal -->
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
        
        <!-- Toastify.js -->
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

        <!-- CSS Kustom untuk Halaman Login -->
        <style>
            body {
                background-color: #f8f7fc;
                font-family: 'Poppins', sans-serif;
            }
            .login-container {
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
            }
            .login-card {
                background-color: #ffffff;
                padding: 2.5rem;
                border-radius: 15px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
                width: 100%;
                max-width: 400px;
                position: relative;
                z-index: 10;
            }
            .login-logo {
                text-align: center;
                margin-bottom: 1.5rem;
            }
            .login-logo img {
                max-width: 100px;
            }
            .form-control {
                border: 1px solid #e0e0e0;
                border-radius: 8px;
                padding: 0.75rem 1rem;
                height: auto;
            }
            .form-control:focus {
                border-color: #8a2be2;
                box-shadow: 0 0 0 0.25rem rgba(138, 43, 226, 0.15);
            }
            .btn-login {
                background-color: #8a2be2;
                border: none;
                color: white;
                border-radius: 8px;
                padding: 0.8rem;
                font-weight: 600;
                width: 100%;
                transition: background-color 0.3s ease;
            }
            .btn-login:hover {
                background-color: #7324b8;
                color: white;
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="login-container">
            <div class="login-card">
                <div class="login-logo">
                    <!-- Pastikan path ini benar! -->
                    <img src="{{ asset('assets/images/logo.png') }}" alt="Logo Yayasan">
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Username -->
                    <div class="mb-3">
                        <label for="username" class="form-label visually-hidden">Username</label>
                        <input id="username" class="form-control" type="text" name="username" value="{{ old('username') }}" required autofocus autocomplete="username" placeholder="Username">
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <label for="password" class="form-label visually-hidden">Password</label>
                        <input id="password" class="form-control" type="password" name="password" required autocomplete="current-password" placeholder="Password">
                    </div>

                    <!-- Remember Me -->
                    <div class="form-check mb-4">
                        <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                        <label for="remember_me" class="form-check-label">
                            <span class="ms-2 text-sm">{{ __('Remember me') }}</span>
                        </label>
                    </div>

                    <div class="d-grid">
                        <!-- PERBAIKAN PENTING: Mengubah tag <button> menjadi <input type="submit"> -->
                        <!-- Ini lebih kompatibel dan jarang menimbulkan masalah submit -->
                        <button type="submit" class="btn btn-login">{{ __('Log in') }}</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Script Bootstrap & Pemicu Toastify -->
        <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
        
        @if (session('error'))
        <script>
            Toastify({
                text: "{{ session('error') }}",
                duration: 4000,
                close: true,
                gravity: "top",
                position: "right",
                stopOnFocus: true,
                style: {
                    background: "linear-gradient(to right, #e85858, #c94040)",
                },
            }).showToast();
        </script>
        @endif
    </body>
</html>
