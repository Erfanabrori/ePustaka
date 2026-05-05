<!DOCTYPE html>
<html>

<head>
    <title>Perpustakaan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --primary: #2f4b8f;
            --dark: #1f2937;
            --soft-bg: #f4f6fb;
        }

        body {
            background: var(--soft-bg);
            font-family: 'Segoe UI', sans-serif;
        }

        /* SIDEBAR */
        .sidebar {
            height: 100vh;
            width: 230px;
            position: fixed;
            background: linear-gradient(180deg, #1f2937, #111827);
            color: #fff;
            padding: 20px 15px;
        }

        .sidebar h4 {
            text-align: center;
            font-weight: bold;
            margin-bottom: 30px;
        }

        .menu-title {
            font-size: 11px;
            color: #9ca3af;
            margin: 15px 0 5px;
            text-transform: uppercase;
        }

        .sidebar a {
            display: block;
            color: #e5e7eb;
            padding: 10px 12px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 14px;
            transition: 0.25s;
        }

        .sidebar a:hover {
            background: rgba(255,255,255,0.08);
            transform: translateX(4px);
        }

        .sidebar .active {
            background: var(--primary);
            color: #fff;
        }

        /* TOPBAR */
        .topbar {
            margin-left: 230px;
            background: #fff;
            padding: 12px 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .topbar .user {
            font-size: 14px;
            color: #555;
        }

        /* CONTENT */
        .content {
            margin-left: 230px;
            padding: 25px;
        }

        /* CARD */
        .card-custom {
            background: #fff;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: 0.3s;
        }

        .card-custom:hover {
            transform: translateY(-2px);
        }
    </style>
</head>

<body>

@php
    $user = \App\Models\User::find(session('user_id'));
@endphp

<!-- SIDEBAR -->
<div class="sidebar">
    <h4>📚 ePerpus</h4>

    <div class="menu-title">Menu</div>
    <a href="/dashboard" class="{{ request()->is('dashboard') ? 'active' : '' }}">Dashboard</a>

    @if ($user && $user->role == 'admin')
        <div class="menu-title">Admin</div>
        <a href="/user" class="{{ request()->is('user*') ? 'active' : '' }}">Data Pengguna</a>
        <a href="/buku" class="{{ request()->is('buku*') ? 'active' : '' }}">Data Buku</a>
        <a href="/laporan" class="{{ request()->is('laporan*') ? 'active' : '' }}">Laporan</a>
    @else
        <div class="menu-title">Buku</div>
        <a href="/buku" class="{{ request()->is('buku*') ? 'active' : '' }}">Daftar Buku</a>
    @endif

    <div class="menu-title">Transaksi</div>
    <a href="/peminjaman" class="{{ request()->is('peminjaman*') ? 'active' : '' }}">Peminjaman</a>

    @if($user && $user->role !== 'admin')
        <a href="/riwayat" class="{{ request()->is('riwayat*') ? 'active' : '' }}">Riwayat</a>
        <a href="/komentar" class="{{ request()->is('komentar*') ? 'active' : '' }}">Komentar</a>
        <a href="/wishlist" class="{{ request()->is('wishlist*') ? 'active' : '' }}">Wishlist</a>
        <a href="/profil" class="{{ request()->is('profil*') ? 'active' : '' }}">Profil</a>
    @endif

    <div class="menu-title">Akun</div>
    <a href="/logout">Logout</a>
</div>

<!-- TOPBAR -->
<div class="topbar">
    <div>
        <strong>Dashboard Perpustakaan</strong>
    </div>

    <div class="user">
        👤 {{ $user->name ?? 'User' }}
    </div>
</div>

<!-- CONTENT -->
<div class="content">
    @yield('content')
</div>

</body>
</html>
