<!DOCTYPE html>
<html>

<head>
    <title>Perpustakaan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', sans-serif;
        }

        /* SIDEBAR */
        .sidebar {
            height: 100vh;
            background: linear-gradient(180deg, #2c3e50, #1a252f);
            color: white;
            padding: 20px;
            position: fixed;
            width: 220px;
            animation: slideLeft 0.5s ease;
        }

        .sidebar h4 {
            margin-bottom: 25px;
            font-weight: bold;
            text-align: center;
        }

        .sidebar a {
            display: block;
            color: white;
            padding: 10px 12px;
            margin-bottom: 5px;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
        }

        .sidebar .active {
            background: rgba(255, 255, 255, 0.2);
        }

        /* CONTENT */
        .content {
            margin-left: 230px;
            padding: 25px;
            animation: fadeIn 0.5s ease;
        }

        /* CARD */
        .card-custom {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .card-custom:hover {
            transform: translateY(-3px);
        }

        /* ANIMATION */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideLeft {
            from {
                transform: translateX(-30px);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
    </style>
</head>

<body>

    @php
        $user = \App\Models\User::find(session('user_id'));
    @endphp

    <div class="sidebar">
        <h4>📚 ePerpus</h4>

        <a href="/dashboard">Dashboard</a>

        @if ($user && $user->role == 'admin')
            <a href="/user">Data Pengguna</a>
            <a href="/buku">Data Buku</a>
            <a href="/laporan">Laporan Transaksi</a>
        @else
            <a href="/buku">Daftar Buku</a>
        @endif

        <a href="/peminjaman">Peminjaman</a>
        @if($user && $user->role !== 'admin')
        <a href="/riwayat">Riwayat Transaksi</a>
        <a href="/komentar">Komentar</a>
        <a href="/wishlist">Wishlist</a>
        <a href="/profil">Profil</a>
        @endif

        <hr style="border-color: rgba(255,255,255,0.2)">

        <a href="/logout">Logout</a>
    </div>

    <div class="content">
        @yield('content')
    </div>

</body>

</html>
