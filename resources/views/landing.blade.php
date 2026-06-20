@extends('layouts.public')

@section('title', 'Beranda')

@section('content')
<!-- Hero -->
<header class="hero">
    <div class="container">
        <div class="row gx-5 align-items-center">
            <div class="col-lg-6">
                <span class="hero-badge"><i class="bi bi-stars"></i> Platform Administrasi Terpadu</span>
                <h1>Kelola Komunitas &amp; Usaha <span class="accent-text">Lebih Mudah</span></h1>
                <p class="lead mb-4">
                    Aplikasi terintegrasi untuk pengolahan data anggota, manajemen inventory berbagai divisi usaha,
                    dan rekapitulasi otomatis dalam satu platform.
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a class="btn btn-accent btn-lg px-4" href="#features">
                        <i class="bi bi-rocket-takeoff me-1"></i> Mulai Sekarang
                    </a>
                    <a class="btn btn-outline-light btn-lg px-4" href="#about">Pelajari Fitur</a>
                </div>
            </div>
            <div class="col-lg-6 d-none d-lg-block mt-5 mt-lg-0">
                <div class="hero-visual">
                    <img src="https://images.unsplash.com/photo-1551434678-e076c223a692?auto=format&fit=crop&w=800&q=80" alt="Tim bekerja sama">
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Stats Strip -->
<section class="stats-strip">
    <div class="container">
        <div class="row text-center g-4">
            <div class="col-6 col-md-3">
                <div class="stat-num">3+</div>
                <div class="stat-cap">Divisi Usaha</div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-num">100%</div>
                <div class="stat-cap">Rekap Otomatis</div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-num">24/7</div>
                <div class="stat-cap">Akses Data</div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-num">1</div>
                <div class="stat-cap">Platform Terpadu</div>
            </div>
        </div>
    </div>
</section>

<!-- Features -->
<section class="features-section" id="features">
    <div class="container">
        <div class="text-center mb-5">
            <div class="section-eyebrow">Fitur Unggulan</div>
            <h2 class="section-title">Segala Kebutuhan Organisasi dalam Genggaman</h2>
        </div>
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="feature-card">
                    <div class="feature-ico"><i class="bi bi-people-fill"></i></div>
                    <h3>Data Anggota</h3>
                    <p>Kelola data profil, kontribusi, dan status anggota komunitas dengan mudah dan terorganisir.</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="feature-card">
                    <div class="feature-ico"><i class="bi bi-box-seam-fill"></i></div>
                    <h3>Inventory Multi-Divisi</h3>
                    <p>Pantau stok bahan baku dan produk dari berbagai unit usaha seperti bakso, gorengan, dan lainnya.</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="feature-card">
                    <div class="feature-ico"><i class="bi bi-file-earmark-bar-graph-fill"></i></div>
                    <h3>Rekap Otomatis</h3>
                    <p>Laporan bulanan otomatis untuk setiap divisi usaha untuk memudahkan evaluasi dan transparansi.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="cta-section" id="about">
    <div class="container">
        <h2>Siap mengelola organisasi dengan lebih rapi?</h2>
        <p>Masuk ke dashboard untuk mulai mengelola data anggota dan usaha komunitas Anda.</p>
        @auth
            <a class="btn btn-accent btn-lg px-4" href="{{ route('dashboard') }}">
                <i class="bi bi-grid-1x2-fill me-1"></i> Buka Dashboard
            </a>
        @else
            <a class="btn btn-accent btn-lg px-4" href="{{ route('login') }}">
                <i class="bi bi-box-arrow-in-right me-1"></i> Masuk ke Akun
            </a>
        @endauth
    </div>
</section>
@endsection
