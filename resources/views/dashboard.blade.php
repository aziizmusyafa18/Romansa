@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<!-- Header Section -->
<div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
    <div>
        <h2 class="fw-bold mb-1" style="color:#1e293b;">Selamat datang kembali, {{ explode(' ', Auth::user()->name)[0] }} 👋</h2>
        <p class="text-muted mb-0">Berikut ringkasan data administrasi anggota Romansa hari ini.</p>
    </div>
    <a href="{{ route('members.page') }}" class="btn btn-accent">
        <i class="bi bi-people-fill me-2"></i> Kelola Anggota
    </a>
</div>

<!-- Stat Cards -->
<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card-pro">
            <div class="d-flex justify-content-between align-items-start">
                <div class="stat-icon bg-slate"><i class="bi bi-people-fill"></i></div>
                <span class="trend-badge"><i class="bi bi-bar-chart-fill"></i></span>
            </div>
            <div class="stat-content mt-3">
                <div class="stat-value">{{ $stats['total'] }}</div>
                <div class="stat-label">Total Anggota</div>
                <small class="text-muted">Seluruh anggota terdaftar</small>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card-pro">
            <div class="d-flex justify-content-between align-items-start">
                <div class="stat-icon bg-sky"><i class="bi bi-person-plus-fill"></i></div>
                <span class="trend-badge text-info">{{ date('Y') }}</span>
            </div>
            <div class="stat-content mt-3">
                <div class="stat-value">{{ $stats['tahun_ini'] }}</div>
                <div class="stat-label">Masuk Tahun Ini</div>
                <small class="text-muted">Anggota baru tahun {{ date('Y') }}</small>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card-pro">
            <div class="d-flex justify-content-between align-items-start">
                <div class="stat-icon bg-green"><i class="bi bi-mortarboard-fill"></i></div>
                <span class="trend-badge text-success">
                    {{ $stats['total'] ? round($stats['lulus'] / $stats['total'] * 100) : 0 }}%
                </span>
            </div>
            <div class="stat-content mt-3">
                <div class="stat-value">{{ $stats['lulus'] }}</div>
                <div class="stat-label">Lulus Madrasah</div>
                <small class="text-muted">Sudah lulus madrasah</small>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card-pro">
            <div class="d-flex justify-content-between align-items-start">
                <div class="stat-icon bg-amber"><i class="bi bi-building-fill"></i></div>
                <span class="trend-badge text-warning">
                    {{ $stats['total'] ? round($stats['berkampus'] / $stats['total'] * 100) : 0 }}%
                </span>
            </div>
            <div class="stat-content mt-3">
                <div class="stat-value">{{ $stats['berkampus'] }}</div>
                <div class="stat-label">Berkampus</div>
                <small class="text-muted">Sedang/pernah berkampus</small>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Anggota Terbaru -->
    <div class="col-lg-8">
        <div class="panel-card h-100">
            <div class="panel-header">
                <div>
                    <h5 class="panel-title">Anggota Terbaru</h5>
                    <small class="text-muted">5 anggota terakhir yang ditambahkan</small>
                </div>
                <a href="{{ route('members.page') }}" class="btn btn-sm btn-light">
                    Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="panel-body p-0">
                @if($recentMembers->isEmpty())
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-1 d-block mb-2 opacity-50"></i>
                        Belum ada data anggota.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 recent-table">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Tahun Masuk</th>
                                    <th>Kampus</th>
                                    <th class="text-end">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentMembers as $m)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="mini-avatar">{{ strtoupper(mb_substr($m->nama, 0, 1)) }}</span>
                                                <div>
                                                    <div class="fw-semibold" style="color:#1e293b;">{{ $m->nama }}</div>
                                                    @if($m->job)<small class="text-muted">{{ $m->job }}</small>@endif
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="badge bg-light text-dark border">{{ $m->tahun_masuk }}</span></td>
                                        <td>{{ $m->kampus ?: '—' }}</td>
                                        <td class="text-end">
                                            @if($m->lulus_madrasah && $m->lulus_madrasah <= date('Y'))
                                                <span class="badge bg-success-subtle text-success">Lulus</span>
                                            @elseif($m->lulus_madrasah && $m->lulus_madrasah > date('Y'))
                                                <span class="badge bg-warning-subtle text-warning">Belum Tamat</span>
                                            @else
                                                <span class="badge bg-secondary-subtle text-secondary">Aktif</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Sidebar kanan: Distribusi + Quick Actions -->
    <div class="col-lg-4">
        <!-- Distribusi per tahun -->
        <div class="panel-card mb-4">
            <div class="panel-header">
                <h5 class="panel-title">Distribusi per Tahun Masuk</h5>
            </div>
            <div class="panel-body">
                @forelse($byYear as $row)
                    <div class="dist-row">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="fw-semibold">{{ $row->tahun_masuk }}</span>
                            <span class="text-muted small">{{ $row->jumlah }} anggota</span>
                        </div>
                        <div class="dist-bar">
                            <div class="dist-fill" style="width: {{ round($row->jumlah / $maxYear * 100) }}%"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted text-center mb-0 py-3">Belum ada data.</p>
                @endforelse
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="panel-card">
            <div class="panel-header">
                <h5 class="panel-title">Aksi Cepat</h5>
            </div>
            <div class="panel-body d-grid gap-2">
                <a href="{{ route('members.page') }}" class="quick-action">
                    <span class="qa-icon bg-sky"><i class="bi bi-person-plus-fill"></i></span>
                    <span>
                        <span class="qa-title">Tambah Anggota</span>
                        <small class="qa-sub">Daftarkan anggota baru</small>
                    </span>
                    <i class="bi bi-chevron-right ms-auto text-muted"></i>
                </a>
                <a href="{{ route('members.page') }}" class="quick-action">
                    <span class="qa-icon bg-slate"><i class="bi bi-table"></i></span>
                    <span>
                        <span class="qa-title">Lihat Data Anggota</span>
                        <small class="qa-sub">Kelola seluruh data</small>
                    </span>
                    <i class="bi bi-chevron-right ms-auto text-muted"></i>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Stat Cards */
.stat-card-pro {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    padding: 22px;
    height: 100%;
    transition: all .25s ease;
    box-shadow: 0 1px 3px rgba(15, 23, 42, .04);
}
.stat-card-pro:hover {
    border-color: #cbd5e1;
    box-shadow: 0 12px 24px rgba(15, 23, 42, .08);
    transform: translateY(-3px);
}
.stat-card-pro .stat-icon {
    width: 52px; height: 52px; border-radius: 14px;
    display: inline-flex; align-items: center; justify-content: center;
    font-size: 1.45rem; color: #fff;
}
.stat-icon.bg-slate { background: linear-gradient(135deg, #475569, #0f172a); }
.stat-icon.bg-sky   { background: linear-gradient(135deg, #38bdf8, #0ea5e9); }
.stat-icon.bg-green { background: linear-gradient(135deg, #22c55e, #16a34a); }
.stat-icon.bg-amber { background: linear-gradient(135deg, #fbbf24, #f59e0b); }
.trend-badge {
    font-size: .78rem; font-weight: 700;
    background: #f1f5f9; color: #64748b;
    padding: .25rem .6rem; border-radius: 50rem;
}
.stat-value { font-size: 2rem; font-weight: 800; color: #1e293b; line-height: 1; }
.stat-label { font-size: .85rem; font-weight: 600; color: #334155; margin-top: .35rem; }

/* Panel cards */
.panel-card {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    box-shadow: 0 1px 3px rgba(15, 23, 42, .04);
    overflow: hidden;
}
.panel-header {
    display: flex; align-items: center; justify-content: space-between;
    padding: 1.1rem 1.35rem;
    border-bottom: 1px solid #f1f5f9;
}
.panel-title { font-size: 1.02rem; font-weight: 700; color: #1e293b; margin: 0; }
.panel-body { padding: 1.1rem 1.35rem; }

/* Recent table */
.recent-table thead th {
    font-size: .72rem; text-transform: uppercase; letter-spacing: .5px;
    color: #64748b; font-weight: 700; background: #f8fafc; border: none;
    padding: .75rem 1.35rem;
}
.recent-table tbody td { padding: .85rem 1.35rem; border-color: #f1f5f9; }
.mini-avatar {
    width: 36px; height: 36px; border-radius: 50%; flex-shrink: 0;
    display: inline-flex; align-items: center; justify-content: center;
    background: linear-gradient(135deg, #475569, #1e293b);
    color: #fff; font-weight: 700; font-size: .85rem;
}

/* Distribution bars */
.dist-row { margin-bottom: 1rem; }
.dist-row:last-child { margin-bottom: 0; }
.dist-bar { height: 8px; background: #f1f5f9; border-radius: 50rem; overflow: hidden; }
.dist-fill {
    height: 100%; border-radius: 50rem;
    background: linear-gradient(90deg, #38bdf8, #0ea5e9);
    transition: width .6s ease;
}

/* Quick actions */
.quick-action {
    display: flex; align-items: center; gap: .85rem;
    padding: .75rem .9rem; border-radius: 11px;
    border: 1px solid #e2e8f0; text-decoration: none;
    transition: all .2s ease;
}
.quick-action:hover { background: #f8fafc; border-color: #cbd5e1; transform: translateX(3px); }
.qa-icon {
    width: 40px; height: 40px; border-radius: 11px; flex-shrink: 0;
    display: inline-flex; align-items: center; justify-content: center;
    color: #fff; font-size: 1.1rem;
}
.qa-icon.bg-sky   { background: linear-gradient(135deg, #38bdf8, #0ea5e9); }
.qa-icon.bg-slate { background: linear-gradient(135deg, #475569, #0f172a); }
.qa-title { display: block; font-weight: 600; color: #1e293b; font-size: .92rem; }
.qa-sub   { color: #94a3b8; font-size: .78rem; }
</style>
@endpush
