@extends('layouts.app')

@section('content')

<style>
    :root {
        --primary: #2f4b8f;
        --primary-dark: #1e3a8a;
        --soft-bg: #f4f6fb;
    }

    body {
        background: var(--soft-bg);
    }

    .card-modern {
        background: #ffffff;
        border-radius: 20px;
        padding: 20px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        transition: 0.3s;
    }

    .card-modern:hover {
        transform: translateY(-3px);
    }

    .fitur-box {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        border-radius: 20px;
        padding: 25px;
        color: white;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .fitur-item {
        background: rgba(255,255,255,0.1);
        padding: 12px 16px;
        border-radius: 10px;
        margin-bottom: 10px;
        transition: 0.3s;
        cursor: pointer;
        color: white;
        text-decoration: none;
        display: block;
    }

    .fitur-item:hover {
        background: rgba(255,255,255,0.2);
        transform: translateX(5px);
    }

    .text-primary-custom {
        color: var(--primary);
    }

    .fade-in {
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.6s ease;
    }

    .fade-in.show {
        opacity: 1;
        transform: translateY(0);
    }
</style>

@php
    $role = session('role');
    $nama = session('nama');
@endphp

<div class="container">

    <div class="mb-4 fade-in">
        <h2 class="fw-bold text-primary-custom">
            {{ $role == 'admin' ? 'Dashboard Admin Perpustakaan' : 'Dashboard Perpustakaan' }}
        </h2>

        <p class="text-muted">
            Selamat datang, {{ $nama }} 👋
        </p>
    </div>

    {{-- ADMIN --}}
    @if($role == 'admin')

    <div class="row g-4">

        <div class="col-md-4 fade-in">
            <div class="card-modern text-center">
                <h6 class="text-muted">Total Buku</h6>
                <h2 class="fw-bold text-primary-custom">{{ \App\Models\Buku::count() }}</h2>
            </div>
        </div>

        <div class="col-md-4 fade-in">
            <div class="card-modern text-center">
                <h6 class="text-muted">Total Peminjaman</h6>
                <h2 class="fw-bold text-primary-custom">{{ \App\Models\Peminjaman::count() }}</h2>
            </div>
        </div>

        <div class="col-md-4 fade-in">
            <div class="card-modern text-center">
                <h6 class="text-muted">Total User</h6>
                <h2 class="fw-bold text-primary-custom">{{ \App\Models\User::count() }}</h2>
            </div>
        </div>

    </div>

    <div class="mt-5 fitur-box fade-in">
        <h5 class="mb-3 fw-bold">Fitur Admin</h5>

        <div class="row">
            <div class="col-md-6">
                <a href="/buku" class="fitur-item">📚 Data Buku</a>
                <a href="/peminjaman" class="fitur-item">📖 Peminjaman</a>
                <a href="/user" class="fitur-item">👥 Data User</a>
            </div>

            <div class="col-md-6">
                <a href="/buku/tambah" class="fitur-item">➕ Tambah Buku</a>
                <a href="/user/tambah" class="fitur-item">➕ Tambah User</a>
                <a href="/profil" class="fitur-item">👤 Profil</a>
            </div>
        </div>
    </div>

    {{-- USER --}}
    @else

    <div class="row g-4">

        <div class="col-md-4 fade-in">
            <div class="card-modern text-center">
                <h6 class="text-muted">Total Buku</h6>
                <h2 class="fw-bold text-primary-custom">{{ \App\Models\Buku::count() }}</h2>
            </div>
        </div>

        <div class="col-md-4 fade-in">
            <div class="card-modern text-center">
                <h6 class="text-muted">Peminjaman Saya</h6>
                <h2 class="fw-bold text-primary-custom">
                    {{ \App\Models\Peminjaman::where('user_id', session('user_id'))->count() }}
                </h2>
            </div>
        </div>

        <div class="col-md-4 fade-in">
            <div class="card-modern text-center">
                <h6 class="text-muted">Status</h6>
                <h3 class="text-success fw-bold">Aktif</h3>
            </div>
        </div>

    </div>

    <div class="mt-5 fitur-box fade-in">
        <h5 class="mb-3 fw-bold">Menu User</h5>

        <div class="row">
            <div class="col-md-4">
                <a href="/buku" class="fitur-item">📚 Lihat Buku</a>
            </div>
            <div class="col-md-4">
                <a href="/peminjaman" class="fitur-item">📖 Peminjaman</a>
            </div>
            <div class="col-md-4">
                <a href="/profil" class="fitur-item">👤 Profil</a>
            </div>
        </div>
    </div>

    @endif

</div>

<script>
    const items = document.querySelectorAll('.fade-in');

    window.addEventListener('load', () => {
        items.forEach((el, i) => {
            setTimeout(() => {
                el.classList.add('show');
            }, i * 120);
        });
    });
</script>

@endsection
