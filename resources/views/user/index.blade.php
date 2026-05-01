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

    .btn-primary-custom:hover {
        opacity: 0.9;
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
        <h2 class="fw-bold" style="color: var(--primary)">👤 Data Pengguna</h2>
        <div class="d-flex gap-2">
            <a href="/user/cetak-semua" class="btn-primary-custom" target="_blank">Cetak Semua Kartu</a>
            <a href="/user/tambah" class="btn-primary-custom">+ Tambah Pengguna</a>
        </div>
    </div>

    <!-- Table -->
    <div class="card-modern fade-in">

        <table class="table table-modern">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th width="200">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $d)
                    <tr>
                        <td>{{ $d->name }}</td>
                        <td>{{ $d->email }}</td>
                        <td>
                            <a href="/user/edit/{{ $d->id }}" class="btn-warning-custom">Edit</a>
                            <a href="/user/hapus/{{ $d->id }}" class="btn-danger-custom"
                               onclick="return confirm('Yakin hapus data?')">
                                Hapus
                            </a>
                            <a href="/user/cetak/{{ $d->id }}" class="btn-primary-custom" target="_blank">Kartu</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

<!-- Animasi -->
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
