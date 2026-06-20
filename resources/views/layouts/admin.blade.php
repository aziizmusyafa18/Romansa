<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('rodena.png') }}">
    <title>{{ config('app.name', 'Romansa') }} — @yield('title', 'Dashboard')</title>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="admin-body">
@php
    $user = Auth::user();
    $role = $user->email === 'admin@romansa.com' ? 'Administrator' : 'Staff';
    $initials = strtoupper(mb_substr($user->name, 0, 1));
@endphp
<div id="app">
  <div class="admin-layout" :class="{ 'sidebar-collapsed': sidebarCollapsed }">
    <!-- Sidebar -->
    <aside class="admin-sidebar" :class="{ show: sidebarOpen }">
        <div class="sidebar-brand">
            <span class="brand-mark"><img src="{{ asset('rodena.png') }}" alt="{{ config('app.name', 'Romansa') }}"></span>
            <span class="brand-text">{{ config('app.name', 'Romansa') }}</span>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-label">Menu Utama</div>
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" data-title="Dashboard">
                <i class="bi bi-grid-1x2-fill"></i> <span class="nav-text">Dashboard</span>
            </a>
            <a href="{{ route('members.page') }}" class="nav-link {{ request()->routeIs('members.page') ? 'active' : '' }}" data-title="Kelola Anggota">
                <i class="bi bi-people-fill"></i> <span class="nav-text">Kelola Anggota</span>
            </a>

            <div class="nav-label">Lainnya</div>
            <a href="{{ url('/') }}" class="nav-link" data-title="Beranda">
                <i class="bi bi-house-door"></i> <span class="nav-text">Beranda</span>
            </a>
            <a href="#" class="nav-link" data-title="Pengaturan">
                <i class="bi bi-gear"></i> <span class="nav-text">Pengaturan</span>
            </a>
        </nav>

        <div class="sidebar-footer">
            <span class="footer-full">&copy; {{ date('Y') }} {{ config('app.name', 'Romansa') }}</span>
            <span class="footer-mini">&copy;</span>
        </div>
    </aside>

    <div class="sidebar-backdrop" :class="{ show: sidebarOpen }" @click="sidebarOpen = false"></div>

    <!-- Main -->
    <div class="admin-main">
        <header class="admin-topbar">
            <div class="d-flex align-items-center gap-3">
                <button class="sidebar-toggle" @click="toggleSidebar" title="Sembunyikan/tampilkan menu">
                    <i class="bi bi-list"></i>
                </button>
                <span class="topbar-title">@yield('title', 'Dashboard')</span>
            </div>

            <div class="topbar-user dropdown">
                <a href="#" class="d-flex align-items-center gap-2 text-decoration-none dropdown-toggle"
                   role="button" data-bs-toggle="dropdown" aria-expanded="false" v-pre>
                    <span class="user-meta d-none d-sm-block">
                        <span class="u-name d-block">{{ $user->name }}</span>
                        <span class="u-role">{{ $role }}</span>
                    </span>
                    <span class="avatar">{{ $initials }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                    <li><span class="dropdown-item-text small text-muted">{{ $user->email }}</span></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bi bi-box-arrow-right me-2"></i> Keluar
                        </a>
                    </li>
                </ul>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
            </div>
        </header>

        <main class="admin-content">
            @yield('content')
        </main>
    </div>
  </div>
</div>
@stack('scripts')
</body>
</html>
