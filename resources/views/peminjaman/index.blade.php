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

    .btn-success-custom {
        background: #16a34a;
        color: #fff;
    }

    .badge-status {
        padding: 6px 10px;
        border-radius: 8px;
        font-size: 12px;
    }

    .badge-dipinjam {
        background: #f59e0b;
        color: #fff;
    }

    .badge-kembali {
        background: #16a34a;
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
    <div class="d-flex justify-content-between align-items-center mb-4 fade-in">
        <h3 class="fw-bold m-0" style="color: var(--primary)">
            @if ($role === 'admin')
                <i class="bi bi-book-open" style="margin-right: 8px;"></i>Data Peminjaman
            @else
                <i class="bi bi-book-open" style="margin-right: 8px;"></i>Peminjaman Saya
            @endif
        </h3>

        @if ($role !== 'admin')
            <a href="/peminjaman/tambah" class="btn-custom btn-primary-custom">
                + Pinjam Buku
            </a>
        @endif
    </div>

    <!-- TABLE -->
    <div class="card-modern fade-in">
        <div class="table-responsive">
            <table class="table table-modern">
                <thead>
                    <tr>
                        <th>No</th>

                        @if ($role === 'admin')
                            <th>User</th>
                        @endif

                        <th>Judul Buku</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($data as $i => $d)
                        <tr>
                            <td class="text-center">{{ $i + 1 }}</td>

                            @if ($role === 'admin')
                                <td>{{ $d->user->name ?? '-' }}</td>
                            @endif

                            <td>
                                <b>{{ optional($d->buku)->judul_buku ?? 'Buku tidak ditemukan' }}</b>
                            </td>

                            <td>
                                {{ $d->tanggal_pinjam
                                    ? \Carbon\Carbon::parse($d->tanggal_pinjam)->format('d M Y')
                                    : '-' }}
                            </td>

                            <td class="text-center">
                                @if ($d->tanggal_kembali)
                                    <span class="badge-status badge-kembali">
                                        ✔ Kembali
                                    </span>
                                @else
                                    @if ($role !== 'admin')
                                        <a href="/peminjaman/kembali/{{ $d->id }}"
                                           class="btn-custom btn-success-custom">
                                            Kembalikan
                                        </a>
                                    @else
                                        <span class="badge-status badge-dipinjam">
                                            ⏳ Dipinjam
                                        </span>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                <span style="color:#888">
                                    📭 Belum ada data peminjaman
                                </span>
                            </td>
                        </tr>
                    @endforelse
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
