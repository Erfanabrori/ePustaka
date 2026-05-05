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

    /* HEADER */
    .page-title {
        font-weight: bold;
        color: var(--primary);
    }

    /* CARD STATS */
    .stat-card {
        border-radius: 18px;
        padding: 20px;
        color: white;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        transition: 0.3s;
    }

    .stat-card:hover {
        transform: translateY(-4px);
    }

    .stat-number {
        font-size: 28px;
        font-weight: bold;
    }

    .stat-label {
        font-size: 14px;
        opacity: 0.9;
    }

    /* FEATURE BOX */
    .feature-box {
        background: #fff;
        border-radius: 18px;
        padding: 25px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.05);
    }

    .feature-item {
        display: block;
        padding: 14px 16px;
        border-radius: 12px;
        background: #f9fafb;
        margin-bottom: 10px;
        text-decoration: none;
        color: #333;
        transition: 0.25s;
    }

    .feature-item:hover {
        background: var(--primary);
        color: white;
        transform: translateX(5px);
    }

    /* FADE */
    .fade-in {
        opacity: 0;
        transform: translateY(20px);
        transition: 0.5s;
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

    <!-- HEADER -->
    <div class="mb-4 fade-in">
        <h3 class="page-title">
            {{ $role == 'admin' ? 'Dashboard Admin' : 'Dashboard Perpustakaan' }}
        </h3>
        <p class="text-muted">Selamat datang, <b>{{ $nama }}</b> 👋</p>
    </div>

    {{-- ADMIN --}}
    @if($role == 'admin')

    <!-- STATS -->
    <div class="row g-3 mb-4">

        <div class="col-md-4 fade-in">
            <div class="stat-card text-center">
                <div class="stat-number">{{ \App\Models\Buku::count() }}</div>
                <div class="stat-label">📚 Total Buku</div>
            </div>
        </div>

        <div class="col-md-4 fade-in">
            <div class="stat-card text-center">
                <div class="stat-number">{{ \App\Models\Peminjaman::count() }}</div>
                <div class="stat-label">📖 Total Peminjaman</div>
            </div>
        </div>

        <div class="col-md-4 fade-in">
            <div class="stat-card text-center">
                <div class="stat-number">{{ \App\Models\User::count() }}</div>
                <div class="stat-label">👥 Total User</div>
            </div>
        </div>

    </div>

    <!-- FEATURES -->
    <div class="feature-box fade-in">
        <h5 class="fw-bold mb-3">⚡ Menu Cepat</h5>

        <div class="row">
            <div class="col-md-6">
                <a href="/buku" class="feature-item">📚 Kelola Buku</a>
                <a href="/peminjaman" class="feature-item">📖 Kelola Peminjaman</a>
                <a href="/user" class="feature-item">👥 Kelola User</a>
            </div>

            <div class="col-md-6">
                <a href="/buku/tambah" class="feature-item">➕ Tambah Buku</a>
                <a href="/user/tambah" class="feature-item">➕ Tambah User</a>
                <a href="/profil" class="feature-item">👤 Profil</a>
            </div>
        </div>
    </div>

    {{-- USER --}}
    @else

    <!-- STATS -->
    <div class="row g-3 mb-4">

        <div class="col-md-4 fade-in">
            <div class="stat-card text-center">
                <div class="stat-number">{{ \App\Models\Buku::count() }}</div>
                <div class="stat-label">📚 Total Buku</div>
            </div>
        </div>

        <div class="col-md-4 fade-in">
            <div class="stat-card text-center">
                <div class="stat-number">
                    {{ \App\Models\Peminjaman::where('user_id', session('user_id'))->count() }}
                </div>
                <div class="stat-label">📖 Peminjaman Saya</div>
            </div>
        </div>

        <div class="col-md-4 fade-in">
            <div class="stat-card text-center">
                <div class="stat-number">✔</div>
                <div class="stat-label">Status Aktif</div>
            </div>
        </div>

    </div>

    <!-- FEATURES -->
    <div class="feature-box fade-in">
        <h5 class="fw-bold mb-3">⚡ Menu</h5>

        <div class="row">
            <div class="col-md-4">
                <a href="/buku" class="feature-item">📚 Lihat Buku</a>
            </div>
            <div class="col-md-4">
                <a href="/peminjaman" class="feature-item">📖 Peminjaman</a>
            </div>
            <div class="col-md-4">
                <a href="/profil" class="feature-item">👤 Profil</a>
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
            }, i * 100);
        });
    });
</script>

@endsection
