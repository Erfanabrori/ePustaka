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
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            transition: 0.3s;
        }

        .card-modern:hover {
            transform: translateY(-3px);
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 10px;
            text-decoration: none;
            transition: 0.3s;
        }

        .btn-danger-custom {
            background: #ef4444;
            color: white;
            padding: 6px 12px;
            border-radius: 8px;
            text-decoration: none;
        }

        .btn-warning-custom {
            background: #f59e0b;
            color: white;
            padding: 6px 12px;
            border-radius: 8px;
            text-decoration: none;
        }

        .table-modern th {
            background: var(--primary);
            color: white;
        }

        .table-modern td,
        .table-modern th {
            padding: 12px;
        }

        .table-modern tr:hover {
            background: #f1f5ff;
        }

        .search-box {
            border-radius: 10px;
            padding: 8px 12px;
            border: 1px solid #ddd;
            width: 250px;
        }

        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.5s ease;
        }

        .fade-in.show {
            opacity: 1;
            transform: translateY(0);
        }
    </style>

    <div class="container">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4 fade-in">
            <h2 class="fw-bold" style="color: var(--primary)">
                📚 Daftar Buku
            </h2>
        </div>

        <!-- Search & Tambah -->
        <div class="card-modern mb-3 fade-in">
            <form method="GET" class="d-flex gap-2">
                <input type="text" name="search" placeholder="Cari buku..." class="search-box">
                <button class="btn-primary-custom">Cari</button>

                @if ($role === 'admin')
                    <a href="/buku/tambah" class="btn-primary-custom">+ Tambah Buku</a>
                    <a href="/buku/cetak-semua" class="btn-primary-custom" target="_blank">Cetak Barcode</a>
                @endif
            </form>
        </div>

        <!-- Table -->
        <div class="card-modern fade-in">
            <table class="table table-modern">
                <thead>
                    <tr>
                        <th>Judul Buku</th>
                        <th>Sub Judul</th>
                        <th>ISBN</th>
                        <th>Tahun Terbit</th>
                        <th>Deskripsi</th>
                        <th>Jumlah Halaman</th>
                        <th>Penerbit</th>
                        <th>Tempat Terbit</th>
                        <th>Edisi</th>
                        <th>Nomor Panggil</th>
                        <th>Stok</th>
                        <th width="200">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $b)
                        <tr>
                            <td>{{ $b->judul_buku ?? '-' }}</td>
                            <td>{{ $b->sub_judul ?? '-' }}</td>
                            <td>{{ $b->isbn ?? '-' }}</td>
                            <td>{{ $b->tahun_terbit ?? '-' }}</td>
                            <td>{{ $b->deskripsi ?? '-' }}</td>
                            <td>{{ $b->jumlah_halaman ?? '-' }}</td>
                            <td>{{ optional($b->penerbit)->nama_penerbit ?? '-' }}</td>
                            <td>{{ $b->tempat_terbit ?? '-' }}</td>
                            <td>{{ $b->edisi ?? '-' }}</td>
                            <td>{{ $b->nomor_panggil ?? '-' }}</td>
                            <td>{{ $b->stok ?? '-' }}</td>
                            <td>
                                @if ($role === 'admin')
                                    <a href="/buku/edit/{{ $b->id }}" class="btn-warning-custom">Edit</a>
                                    <a href="/buku/hapus/{{ $b->id }}" class="btn-danger-custom"
                                        onclick="return confirm('Yakin hapus data?')">
                                        Hapus
                                    </a>
                                    <a href="/buku/cetak/{{ $b->id }}" class="btn-primary-custom" target="_blank">Barcode</a>
                                @else
                                    <a href="/peminjaman/tambah?buku_id={{ $b->id }}"
                                        class="btn-primary-custom">
                                        Pinjam
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

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
