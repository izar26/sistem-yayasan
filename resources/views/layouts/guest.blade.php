<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Login</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
        
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

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
                    <img src="{{ asset('assets/images/logo.png') }}" alt="Logo Yayasan">
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <input id="username" class="form-control" type="text" name="username" value="{{ old('username') }}" required autofocus autocomplete="username" placeholder="Username">
                    </div>

                    <div class="mb-4">
                        <input id="password" class="form-control" type="password" name="password" required autocomplete="current-password" placeholder="Password">
                    </div>

                    <div class="form-check mb-4">
                        <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                        <label for="remember_me" class="form-check-label">
                            <span class="ms-2 text-sm">{{ __('Remember me') }}</span>
                        </label>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-login">
                            {{ __('Log in') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

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
