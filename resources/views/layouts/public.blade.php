<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('rodena.png') }}">
    <title>{{ config('app.name', 'Romansa') }} — @yield('title', 'Beranda')</title>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="public-body">
<div id="app">
    <nav class="navbar navbar-expand-lg public-navbar fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ url('/') }}">
                <span class="brand-mark"><img src="{{ asset('rodena.png') }}" alt="{{ config('app.name', 'Romansa') }}"></span>
                <span class="fw-bold">{{ config('app.name', 'Romansa') }}</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#publicNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="publicNav">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
                    <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="#features">Fitur</a></li>
                    <li class="nav-item"><a class="nav-link" href="#about">Tentang</a></li>
                    <li class="nav-item ms-lg-2">
                        @auth
                            <a class="btn btn-accent btn-sm px-3" href="{{ route('dashboard') }}">
                                <i class="bi bi-grid-1x2-fill me-1"></i> Dashboard
                            </a>
                        @else
                            <a class="btn btn-accent btn-sm px-3" href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right me-1"></i> Masuk
                            </a>
                        @endauth
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="public-footer">
        <div class="container">
            <div class="row gy-4 align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <div class="d-flex align-items-center gap-2 justify-content-center justify-content-md-start mb-2">
                        <span class="brand-mark"><img src="{{ asset('rodena.png') }}" alt="{{ config('app.name', 'Romansa') }}"></span>
                        <span class="fw-bold fs-5 text-white">{{ config('app.name', 'Romansa') }}</span>
                    </div>
                    <p class="mb-0 small">Sistem informasi administrasi komunitas & usaha.</p>
                </div>
                <div class="col-md-6 text-center text-md-end small">
                    &copy; {{ date('Y') }} {{ config('app.name', 'Romansa') }} Community. All rights reserved.
                </div>
            </div>
        </div>
    </footer>
</div>
@stack('scripts')
</body>
</html>
