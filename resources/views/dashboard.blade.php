@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
              </ol>
            </nav>
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="h3 mb-0 text-gray-800">Dashboard Admin</h2>
                <div class="text-muted small">
                    Logged in as: <strong>{{ Auth::user()->name }}</strong> ({{ Auth::user()->email == 'admin@romansa.com' ? 'Administrator' : 'Staff' }})
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Anggota</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ \App\Models\Member::count() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Bisa ditambah card statistik lainnya di sini -->
    </div>

    <div class="row">
        <div class="col-12">
            <member-management></member-management>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .border-left-primary {
        border-left: .25rem solid #4e73df!important;
    }
</style>
@endpush
