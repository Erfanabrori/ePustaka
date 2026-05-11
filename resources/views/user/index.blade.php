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
        padding: 20px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.05);
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
    }

    .btn-warning-custom {
        background: #f59e0b;
        color: #fff;
    }

    .btn-danger-custom {
        background: #ef4444;
        color: #fff;
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

    .action-buttons a {
        margin: 2px;
    }

    .fade-in {
        opacity: 0;
        transform: translateY(20px);
        transition: 0.4s ease;
    }

    .fade-in.show {
        opacity: 1;
        transform: translateY(0);
    }
</style>

<div class="container">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2 fade-in">
        <h3 class="fw-bold m-0" style="color: var(--primary)">
            <i class="" style="margin-right: 8px;"></i>Data Pengguna
        </h3>

        <div class="d-flex gap-2">
            <a href="/user/cetak-semua" target="_blank"
               class="btn-custom btn-primary-custom">
               Cetak Semua
            </a>

            <a href="/user/tambah"
               class="btn-custom btn-primary-custom">
               + Tambah
            </a>
        </div>
    </div>

    <!-- TABLE -->
    <div class="card-modern fade-in">
        <div class="table-responsive">
            <table class="table table-modern">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($data as $i => $d)
                        <tr>
                            <td class="text-center">{{ $i + 1 }}</td>
                            <td><b>{{ $d->name }}</b></td>
                            <td>{{ $d->email }}</td>

                            <td class="action-buttons text-center">
                                <a href="/user/edit/{{ $d->id }}"
                                   class="btn-custom btn-warning-custom">Edit</a>

                                <a href="/user/hapus/{{ $d->id }}"
                                   class="btn-custom btn-danger-custom"
                                   onclick="return confirm('Yakin hapus data?')">
                                   Hapus
                                </a>

                                <a href="/user/cetak/{{ $d->id }}"
                                   target="_blank"
                                   class="btn-custom btn-primary-custom">
                                   Kartu
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4">
                                <span style="color:#888">
                                    <i class="bi bi-inbox" style="margin-right: 6px;"></i>Belum ada data pengguna
                                </span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>

</div>

<!-- ANIMASI -->
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
