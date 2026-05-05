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
    }

    .btn-primary-custom {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: #fff;
        border: none;
    }

    .table-modern th {
        background: var(--primary);
        color: #fff;
        text-align: center;
        white-space: nowrap;
    }

    .table-modern td {
        vertical-align: middle;
    }

    .table-modern tr:hover {
        background: #f1f5ff;
    }

    .badge-status {
        padding: 5px 10px;
        border-radius: 8px;
        font-size: 12px;
    }

    .badge-dipinjam {
        background: #f59e0b;
        color: #fff;
    }

    .badge-selesai {
        background: #16a34a;
        color: #fff;
    }

    .filter-box {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        align-items: center;
    }

    .filter-box select {
        border-radius: 10px;
        padding: 8px 12px;
        border: 1px solid #ddd;
    }
</style>

<div class="container">

    <!-- HEADER -->
    <div class="mb-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <h3 class="fw-bold m-0" style="color: var(--primary)">
            📊 Laporan Transaksi
        </h3>
    </div>

    <!-- FILTER -->
    <div class="card-modern mb-3">
        <form method="GET" class="filter-box">

            <select name="bulan">
                <option value="">-- Bulan --</option>
                @for($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($i)->format('F') }}
                    </option>
                @endfor
            </select>

            <select name="tahun">
                <option value="">-- Tahun --</option>
                @for($i = 2023; $i <= date('Y'); $i++)
                    <option value="{{ $i }}" {{ request('tahun') == $i ? 'selected' : '' }}>
                        {{ $i }}
                    </option>
                @endfor
            </select>

            <button class="btn-custom btn-primary-custom">
                Filter
            </button>

            <a href="/laporan/cetak?bulan={{ request('bulan') }}&tahun={{ request('tahun') }}"
               target="_blank"
               class="btn-custom btn-primary-custom">
               Cetak
            </a>

        </form>
    </div>

    <!-- TABLE -->
    <div class="card-modern">
        <div class="table-responsive">
            <table class="table table-modern">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Peminjam</th>
                        <th>Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($data as $i => $d)
                        <tr>
                            <td class="text-center">{{ $i + 1 }}</td>

                            <td>{{ optional($d->user)->name ?? '-' }}</td>

                            <td>
                                <b>{{ optional($d->buku)->judul_buku ?? '-' }}</b>
                            </td>

                            <td>
                                {{ $d->tanggal_pinjam
                                    ? \Carbon\Carbon::parse($d->tanggal_pinjam)->format('d M Y')
                                    : '-' }}
                            </td>

                            <td>
                                {{ $d->tanggal_kembali
                                    ? \Carbon\Carbon::parse($d->tanggal_kembali)->format('d M Y')
                                    : '-' }}
                            </td>

                            <td class="text-center">
                                @if($d->tanggal_kembali)
                                    <span class="badge-status badge-selesai">
                                        ✔ Selesai
                                    </span>
                                @else
                                    <span class="badge-status badge-dipinjam">
                                        ⏳ Dipinjam
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <span style="color:#888">
                                    📭 Tidak ada data laporan
                                </span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>

</div>

@endsection
