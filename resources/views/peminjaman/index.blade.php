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

    .btn-success-custom {
        background: #16a34a;
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
        <h2 class="fw-bold" style="color: var(--primary)">
            @if($role === 'admin')
                📖 Data Peminjaman
            @else
                📖 Peminjaman Saya
            @endif
        </h2>
    </div>

    <!-- Button (Hanya User) -->
    @if($role !== 'admin')
    <div class="card-modern mb-3 fade-in">
        <a href="/peminjaman/tambah" class="btn-primary-custom">+ Pinjam Buku</a>
    </div>
    @endif

    <!-- Table -->
    <div class="card-modern fade-in">
        <table class="table table-modern">
            <thead>
                <tr>
                    <th>No</th>

                    @if($role === 'admin')
                        <th>User</th>
                    @endif

                    <th>Buku</th>
                    <th>Tanggal Pinjam</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>
                @foreach($data as $i => $d)
                    <tr>
                        <td>{{ $i+1 }}</td>

                        @if($role === 'admin')
                            <td>{{ $d->user->name }}</td>
                        @endif

                        <td>{{ $d->Buku->judul_buku ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($d->tanggal_pinjam)->format('d-m-Y') }}</td>

                        <td>
                            @if($d->tanggal_kembali)
                                <span class="badge bg-success">Kembali</span>
                            @else
                                @if($role !== 'admin')
                                <a href="/peminjaman/kembali/{{ $d->id }}" class="btn-success-custom">
                                    Kembalikan
                                </a>
                                @else
                                <span class="badge bg-warning">Dipinjam</span>
                                @endif
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
