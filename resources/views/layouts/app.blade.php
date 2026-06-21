# Layout Blade Modern AdminMart Style

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan</title>
    <link rel="icon" type="image/png" href="{{ asset('icon16x16.png') }}" sizes="16x16">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        :root {
            --sidebar-bg: #0f172a;
            --sidebar-soft: #1e293b;
            --primary: #4f7cff;
            --primary-hover: #3f6ef5;
            --text-soft: #94a3b8;
            --content-bg: #f1f5f9;
            --white: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: var(--content-bg);
            overflow-x: hidden;
        }

        @php
            $user = \App\Models\User::find(session('user_id'));
        @endphp

        /* SIDEBAR */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 260px;
            height: 100vh;
            background: linear-gradient(180deg, #111827, #0f172a);
            padding: 20px 16px;
            transition: all 0.3s ease;
            z-index: 999;
            overflow-y: auto;
        }

        .sidebar.collapsed {
            width: 85px;
        }

        .sidebar.collapsed .logo-text,
        .sidebar.collapsed .menu-title,
        .sidebar.collapsed .menu-text,
        .sidebar.collapsed .user-info,
        .sidebar.collapsed .arrow {
            display: none;
        }

        .sidebar.collapsed .menu-link {
            justify-content: center;
        }

        .sidebar.collapsed .sidebar-user {
            justify-content: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 35px;
            color: white;
            font-size: 20px;
            font-weight: 700;
        }

        .logo-icon {
            width: 42px;
            height: 42px;
            border-radius: 14px;
            background: linear-gradient(135deg, var(--primary), #6ea8fe);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .menu-title {
            color: var(--text-soft);
            font-size: 11px;
            text-transform: uppercase;
            margin: 20px 10px 10px;
            letter-spacing: 1px;
        }

        .menu-link {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 14px;
            border-radius: 14px;
            color: #dbeafe;
            text-decoration: none;
            margin-bottom: 6px;
            transition: all 0.25s ease;
            position: relative;
            font-size: 14px;
        }

        .menu-link i {
            font-size: 18px;
            min-width: 20px;
        }

        .menu-link:hover {
            background: rgba(255,255,255,0.08);
            color: white;
            transform: translateX(4px);
        }

        .menu-link.active {
            background: linear-gradient(90deg, var(--primary), #6ea8fe);
            color: white;
            box-shadow: 0 6px 18px rgba(79,124,255,0.35);
        }

        .menu-link .badge-custom {
            margin-left: auto;
            background: rgba(255,255,255,0.18);
            padding: 3px 8px;
            border-radius: 30px;
            font-size: 10px;
        }

        .sidebar-user {
            margin-top: 30px;
            background: rgba(255,255,255,0.06);
            border-radius: 18px;
            padding: 14px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sidebar-user img {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            object-fit: cover;
        }

        .sidebar-user h6 {
            margin: 0;
            color: white;
            font-size: 14px;
        }

        .sidebar-user small {
            color: #cbd5e1;
        }

        /* TOPBAR */
        .topbar {
            position: fixed;
            top: 0;
            left: 260px;
            right: 0;
            height: 72px;
            background: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 25px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            z-index: 998;
        }

        .topbar.expanded {
            left: 85px;
        }

        .toggle-btn {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            border: none;
            background: #eef2ff;
            color: var(--primary);
            font-size: 20px;
            transition: 0.3s;
        }

        .toggle-btn:hover {
            background: var(--primary);
            color: white;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .profile-box {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #f8fafc;
            padding: 8px 14px;
            border-radius: 14px;
        }

        .profile-box img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }

        /* CONTENT */
        .content {
            margin-left: 260px;
            margin-top: 72px;
            padding: 25px;
            transition: all 0.3s ease;
        }

        .content.expanded {
            margin-left: 85px;
        }

        .card-custom {
            background: white;
            border-radius: 24px;
            padding: 24px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.04);
            border: 1px solid #e2e8f0;
        }

        @media (max-width: 768px) {
            .sidebar {
                left: -260px;
            }

            .sidebar.mobile-show {
                left: 0;
            }

            .topbar {
                left: 0 !important;
            }

            .content {
                margin-left: 0 !important;
            }
        }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar" id="sidebar">

    <div class="logo">
        <div class="logo-icon">
            <i class="bi bi-book"></i>
        </div>

        <div class="logo-text">
            ePustaka
        </div>
    </div>

    <div class="menu-title">Home</div>

    <a href="/dashboard" class="menu-link {{ request()->is('dashboard') ? 'active' : '' }}">
        <i class="bi bi-house-door"></i>
        <span class="menu-text">Dashboard</span>
    </a>

    @if ($user && $user->role == 'admin')

        <div class="menu-title">Admin</div>

        <a href="/user" class="menu-link {{ request()->is('user*') ? 'active' : '' }}">
            <i class="bi bi-people"></i>
            <span class="menu-text">Data Pengguna</span>
        </a>

        <a href="/buku" class="menu-link {{ request()->is('buku*') ? 'active' : '' }}">
            <i class="bi bi-book"></i>
            <span class="menu-text">Data Buku</span>
        </a>

        <a href="/laporan" class="menu-link {{ request()->is('laporan*') ? 'active' : '' }}">
            <i class="bi bi-bar-chart"></i>
            <span class="menu-text">Laporan</span>
        </a>

        <a href="/admin/komentar" class="menu-link {{ request()->is('admin/komentar*') ? 'active' : '' }}">
            <i class="bi bi-chat-left-text"></i>
            <span class="menu-text">Komentar</span>
        </a>

    @else

        <div class="menu-title">Buku</div>

        <a href="/buku" class="menu-link {{ request()->is('buku*') ? 'active' : '' }}">
            <i class="bi bi-journal-bookmark"></i>
            <span class="menu-text">Daftar Buku</span>
        </a>

    @endif

    <div class="menu-title">Transaksi</div>

    <a href="/peminjaman" class="menu-link {{ request()->is('peminjaman*') ? 'active' : '' }}">
        <i class="bi bi-arrow-left-right"></i>
        <span class="menu-text">Peminjaman</span>
    </a>

    @if($user && $user->role !== 'admin')

        <a href="/riwayat" class="menu-link {{ request()->is('riwayat*') ? 'active' : '' }}">
            <i class="bi bi-clock-history"></i>
            <span class="menu-text">Riwayat</span>
        </a>

        <a href="/komentar" class="menu-link {{ request()->is('komentar*') ? 'active' : '' }}">
            <i class="bi bi-chat-dots"></i>
            <span class="menu-text">Komentar</span>
        </a>

        <a href="/wishlist" class="menu-link {{ request()->is('wishlist*') ? 'active' : '' }}">
            <i class="bi bi-heart"></i>
            <span class="menu-text">Wishlist</span>
        </a>

        <a href="/profil" class="menu-link {{ request()->is('profil*') ? 'active' : '' }}">
            <i class="bi bi-person"></i>
            <span class="menu-text">Profil</span>
        </a>

    @endif

    <div class="menu-title">Akun</div>

    <a href="/logout" class="menu-link">
        <i class="bi bi-box-arrow-right"></i>
        <span class="menu-text">Logout</span>
    </a>


</div>

<!-- TOPBAR -->
<div class="topbar" id="topbar">

    <div class="d-flex align-items-center gap-3">
        <button class="toggle-btn" id="toggleSidebar">
            <i class="bi bi-list"></i>
        </button>

        <div>
            <h5 class="mb-0 fw-bold">Dashboard Perpustakaan</h5>
            <small class="text-muted">Sistem Informasi Perpustakaan</small>
        </div>
    </div>

    <div class="topbar-right">

        <i class="bi bi-bell fs-5"></i>

        <div class="profile-box">
            <i class="bi bi-person-circle fs-3"></i>

            <div>
                <div class="fw-semibold">{{ $user->name ?? 'User' }}</div>
                <small class="text-muted">{{ $user->role ?? 'Member' }}</small>
            </div>
        </div>

    </div>
</div>

<!-- CONTENT -->
<div class="content" id="content">
    @yield('content')
</div>

<script>
    const sidebar = document.getElementById('sidebar');
    const topbar = document.getElementById('topbar');
    const content = document.getElementById('content');
    const toggleBtn = document.getElementById('toggleSidebar');

    toggleBtn.addEventListener('click', function() {
        sidebar.classList.toggle('collapsed');
        topbar.classList.toggle('expanded');
        content.classList.toggle('expanded');
    });
</script>

</body>
</html>
```

