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
        background: #fff;
        border-radius: 18px;
        padding: 22px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.05);
        transition: 0.25s;
    }

    .card-modern:hover {
        transform: translateY(-2px);
    }

    .btn-custom {
        border-radius: 10px;
        padding: 7px 14px;
        font-size: 14px;
        text-decoration: none;
        display: inline-block;
    }

    .btn-primary-custom {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: #fff;
        border: none;
    }

    .btn-warning-custom {
        background: #f59e0b;
        color: #fff;
    }

    .btn-danger-custom {
        background: #ef4444;
        color: #fff;
    }

    .table-modern {
        font-size: 14px;
    }

    .table-modern th {
        background: var(--primary);
        color: #fff;
        white-space: nowrap;
        text-align: center;
    }

    .table-modern td {
        vertical-align: middle;
    }

    .table-modern tr:hover {
        background: #f1f5ff;
    }

    .search-box {
        border-radius: 10px;
        padding: 8px 12px;
        border: 1px solid #ddd;
        min-width: 220px;
    }

    .action-buttons a {
        margin: 2px;
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

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4 fade-in">
        <h3 class="fw-bold m-0" style="color: var(--primary)">
            <i class="" style="margin-right: 8px;"></i>Data Buku
        </h3>

        @if ($role === 'admin')
            <div>
                <a href="/buku/tambah" class="btn-custom btn-primary-custom">+ Tambah</a>
                <a href="/buku/cetak-semua" target="_blank" class="btn-custom btn-primary-custom">Cetak Barcode</a>
            </div>
        @endif
    </div>

    <!-- SEARCH -->
    <div class="card-modern mb-3 fade-in">
        <form method="GET" class="d-flex flex-wrap gap-2 align-items-center">
            <input type="text" name="search" placeholder="Cari buku..." class="search-box">
            <button class="btn-custom btn-primary-custom">Cari</button>
        </form>
    </div>

    <!-- TABLE -->
    <div class="card-modern fade-in">
        <div class="table-responsive">
            <table class="table table-modern">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Sub</th>
                        <th>ISBN</th>
                        <th>Tahun</th>
                        <th>Halaman</th>
                        <th>Penerbit</th>
                        <th>Tempat</th>
                        <th>Edisi</th>
                        <th>Panggil</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $b)
                        <tr>
                            <td>{{ $b->judul_buku ?? '-' }}</td>
                            <td>{{ $b->sub_judul ?? '-' }}</td>
                            <td>{{ $b->isbn ?? '-' }}</td>
                            <td>{{ $b->tahun_terbit ?? '-' }}</td>
                            <td>{{ $b->jumlah_halaman ?? '-' }}</td>
                            <td>{{ optional($b->penerbit)->nama_penerbit ?? '-' }}</td>
                            <td>{{ $b->tempat_terbit ?? '-' }}</td>
                            <td>{{ $b->edisi ?? '-' }}</td>
                            <td>{{ $b->nomor_panggil ?? '-' }}</td>
                            <td><b>{{ $b->stok ?? 0 }}</b></td>

                            <td class="action-buttons">
                                @if ($role === 'admin')
                                    <a href="/buku/edit/{{ $b->id }}" class="btn-custom btn-warning-custom">Edit</a>
                                    <a href="/buku/hapus/{{ $b->id }}" class="btn-custom btn-danger-custom"
                                       onclick="return confirm('Yakin hapus data?')">Hapus</a>
                                    <a href="/buku/cetak/{{ $b->id }}" target="_blank"
                                       class="btn-custom btn-primary-custom">Barcode</a>
                                @else
                                    <a href="/peminjaman/tambah?buku_id={{ $b->id }}"
                                       class="btn-custom btn-primary-custom">Pinjam</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

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
