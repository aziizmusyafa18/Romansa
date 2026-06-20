@extends('layouts.admin')

@section('title', 'Kelola Anggota')

@section('content')
<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Kelola Anggota</li>
    </ol>
</nav>

<member-management></member-management>
@endsection
