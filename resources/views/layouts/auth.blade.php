<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('rodena.png') }}">
    <title>{{ config('app.name', 'Romansa') }} — Login</title>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @stack('styles')
</head>
<body>
    <div id="app">
        <div class="auth-wrapper">
            <div class="w-100" style="max-width: 430px;">
                <div class="auth-brand">
                    <div class="auth-logo"><img src="{{ asset('rodena.png') }}" alt="{{ config('app.name', 'Romansa') }}"></div>
                    <h1>{{ config('app.name', 'Romansa') }}</h1>
                    <p>Sistem Informasi Administrasi</p>
                </div>
                @yield('content')
            </div>
        </div>
    </div>
    @stack('scripts')
</body>
</html>
